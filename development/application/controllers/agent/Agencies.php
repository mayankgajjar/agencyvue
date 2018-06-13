<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Agencies :- Manage Agencies in Agent's Screen.
 *
 * @author dhareen
 */
class Agencies extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('agency');
    }

    /*
     * Index of Sub Agencies Page
     */

    public function index() {
        $data['title'] = "Manage Sub Agencies || AgencyVue";
        $this->template->load('agent_header', 'agent/agency/index', $data);
    }

    /**
     * @uses AJAX DATA-TABLE JSON Creator
     * @return Array List of all agencies underneath
     */
    public function agencyJson() {
        $agentID = $this->session->userdata['user_info']['user_id'];
        $agent_id = "";

        if (isset($_REQUEST['agent_id'])) {
            $agent_id = $_REQUEST['agent_id'];
        }

        $aColumns = array("user_id", "agency_name", "agency_email", "is_approved", "created_date");

        /* Pagination */

        $sLimit = array();

        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $sLimit = array("start" => $_GET['iDisplayLength'], "end" => $_GET['iDisplayStart']);
        }

        /* Search */

        $sWhere = "";
        if ($_GET['sSearch'] != "") {
            $sColumns = array("agency_name", "agency_email", "basic.created_date");
            $sWhere .= " (";
            for ($i = 0; $i < count($sColumns); $i++) {
                $sWhere .= $sColumns[$i] . " LIKE '%" . $_GET['sSearch'] . "%' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ') ';
        }

        /* Order */

        $sOrder = array();

        if ($_GET['iSortCol_0'] != "") {
            for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                    $sOrder = array("field" => $aColumns[intval($_GET['iSortCol_' . $i])],
                        "order" => $_GET['sSortDir_' . $i]);
                }
            }
        }

        $rResult = $this->agency->get_agent_agencies($sLimit, $sWhere, $sOrder, $agentID);
        $iTotal_f = count($rResult);
        $iTotal = $this->agency->get_agent_agencies_count($sWhere, $agentID);
        $output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $iTotal_f,
            "iTotalDisplayRecords" => $iTotal,
            "aaData" => array()
        );
        if ($rResult) {
            foreach ($rResult as $aRow) {
                $row = array();
                for ($i = 0; $i < count($aColumns); $i++) {

                    if ($aColumns[$i] == 'user_id') {

                        $row[] = "<div class='checkbox checkbox-primary checkbox-single m-r-15'>
                                <input id='act_checkbox_" . $aRow['user_id'] . "' type='checkbox' value=" . urlencode(base64_encode($aRow["user_id"])) . " name='act_checkbox[]' class='ch_checkbox'>
                                <label for='act-checkbox'></label>
                            </div>
                    <img src=" . base_url() . "assets/crm_image/agencieslogo/" . $aRow['agency_image'] . " alt='contact-img' title='contact-img' class='img-circle thumb-sm' />";
                    } elseif ($aColumns[$i] == "is_approved") {
                        if ($aRow[$aColumns[$i]] == "NA") {
                            $row[] = '<label class="btn btn-warning btn-xs">Pending</label>';
                        } else {
                            $row[] = '<label class="btn btn-success btn-xs">Approved</label>';
                        }
                    } elseif ($aColumns[$i] == 'created_date') {
                        $row[] .= date('m-d-Y h:i:s a', strtotime($aRow['created_date']));
                    } else {
                        $row[] = isset($aRow[$aColumns[$i]]) ? $aRow[$aColumns[$i]] : '';
                    }
                }

                $row[] .= '<a class="btn btn-info btn-xs table-action-btn admin-action-icon-in-data-table" href="' . base_url() . 'agent/agencies/view?user_id=' . urlencode(base64_encode($aRow["user_id"])) . '"  title="View Agency Profile"><i class="glyphicon glyphicon-eye-open" title="View Profile"></i></a>'
                        . '<a href="' . base_url() . 'agent/agencies/edit?user_id=' . urlencode(base64_encode($aRow["user_id"])) . '" " class="btn btn-default btn-xs table-action-btn admin-action-icon-in-data-table" title="Edit Agency Profile"><i class="fa fa-pencil"></i></a>'
                        . '<span class="danger-alert btn btn-danger btn-xs table-action-btn del_agency admin-action-icon-in-data-table remove-span" data-custom-value="' . $aRow["user_id"] . '" title="Remove Agency Profile"><i class="glyphicon glyphicon-remove"></i></span>'
                        . '<span class="danger-alert btn btn-primary btn-xs table-action-btn show_log admin-action-icon-in-data-table info-span" data-custom-value="' . $aRow["user_id"] . '" title=" View Activity Log"><i class="fa fa-list-ul" title="View Log"></i></span>';


                $output['aaData'][] = $row;
            }
        }
        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    /**
     * @uses Adding in new agency underneath
     */
    public function add() {
        $data['title'] = "Add New Agency || AgencyVue";
        $data['state'] = get_data($tbl_name = 'crm_states', $single = 0);
        if ($this->input->post('save')) {
            $this->form_validation->set_rules('agency_name', 'Agency Name', 'required');
            $this->form_validation->set_rules('contact_email', 'Contact Email', 'required|valid_email');
            $this->form_validation->set_rules('customer_service_number', 'Customer Service Number', 'required');
            $this->form_validation->set_rules('phone_number', 'Phone Number', 'required');
            $this->form_validation->set_rules('address', 'Address', 'required');
            $this->form_validation->set_rules('sel_state', 'State', 'required');
            $this->form_validation->set_rules('sel_city', 'City', 'required');
            $this->form_validation->set_rules('domain_name', 'Domain Name', 'required');
            $this->form_validation->set_rules('login_email', 'Login Email ID', 'required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|matches[cpassword]');
            $this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required|min_length[5]|matches[password]');
            if ($this->form_validation->run() == FALSE) {
                $this->form_validation->set_error_delimiters();
            } else {
                $locationImage = "assets/crm_image/agencieslogo/";
                $agnecyLogo = FileInsert($locationImage, "agency_logo", "image", "2097152");
                $location = "assets/crm_docs/agency_uploaded_docs/";
                $agency_w9 = FileInsert($location, "agency_w9", "doc", "2097152");
                $agency_dd = FileInsert($location, "agency_direct_deposit", "doc", "2097152");
                $agency_ca = FileInsert($location, "agency_contract_agreement", "doc", "2097152");
                if ($agency_w9['status'] == 1 && $agency_dd['status'] == 1 && $agency_ca['status'] == 1 && $agnecyLogo['status'] == 1) {
                    $userMst = array('email' => $this->input->post('login_email'), 'display_name' => $this->input->post('agency_name'), 'password' => md5($this->input->post('password')), 'roll_id' => ('5'));
                    $user_tbl = insert_update_data($ins = 1, $table_name = 'crm_user_tbl', $ins_data = $userMst);
                    $user_id = $this->db->insert_id();
                    $data_crm_domain_master = array('user_id' => $user_id, 'domain_name' => $this->input->post('domain_name'));
                    $domain = insert_update_data($ins = 1, $table_name = 'crm_domain_master', $ins_data = $data_crm_domain_master);
                    $agencyBasic = array(
                        'parent_id' => $this->session->userdata['user_info']['user_id'],
                        'user_id' => $user_id,
                        'agency_name' => $this->input->post('agency_name'),
                        'contact_name' => $this->input->post('contact_name'),
                        'agency_email' => $this->input->post('contact_email'),
                        'agency_phone' => $this->input->post('phone_number'),
                        'agency_address' => $this->input->post('address'),
                        'agency_sub_address' => $this->input->post('address_addtional'),
                        'agency_state' => $this->input->post('sel_state'),
                        'agency_city' => $this->input->post('sel_city'),
                        'agency_zip_code' => $this->input->post('zipcode'),
                        'agency_customer_service_number' => $this->input->post('customer_service_number'),
                        'agency_customer_service_email' => $this->input->post('contact_email'),
                        'agency_image' => $agnecyLogo['msg'],
                        'agency_domain' => $this->input->post('domain_name')
                    );
                    $agencyTbl = insert_update_data($ins = 1, $table_name = 'crm_agencies_basic', $ins_data = $agencyBasic);
                    $agencyBank = array(
                        'agency_id' => $user_id,
                        'bank_name' => $this->input->post('angecy_bank_name'),
                        'bank_add' => $this->input->post('angecy_bank_add'),
                        'bank_city' => $this->input->post('bank_city'),
                        'bank_state' => $this->input->post('bank_state'),
                        'bank_zipcode' => $this->input->post('bank_zipcode'),
                        'agency_name_on_account' => $this->input->post('name_on_account'),
                        'agency_account_number' => $this->input->post('account_number'),
                        'angecy_routing_number' => $this->input->post('routing_number'),
                    );
                    $agencybankTble = insert_update_data($ins = 1, $table_name = 'crm_agencies_bank_details', $ins_data = $agencyBank);
                    $agencyDoc = array(
                        'agency_id' => $user_id,
                        'agency_w9_form' => $agency_w9['msg'],
                        'agency_direct_deposit' => $agency_dd['msg'],
                        'agency_contract_agreement' => $agency_ca['msg']
                    );
                    $agencydocTbl = insert_update_data($ins = 1, $table_name = 'crm_agencies_documents', $ins_data = $agencyDoc);
                    $insertLog = "Agency Created";
                    $logArray = array(
                        'agency_id' => $user_id,
                        'action_by' => $this->session->userdata['user_info']['user_id'],
                        'action_text' => $insertLog
                    );
                    $agencylog = insert_update_data($ins = 1, $table_name = 'crm_agency_log', $ins_data = $logArray);
                    if ($agencyTbl && $domain && $user_tbl && $agencybankTble && $agencydocTbl && $agencylog) {
                        $agentAddFeed = array(
                            'from_id' => $this->session->userdata['user_info']['user_id'],
                            'to_id' => $this->session->userdata['user_info']['user_id'],
                            'feed_type' => 'feed',
                            'feed_icon' => 'fa fa-university',
                            'feed_title' => 'New Agency Added In Your Profile || ' . get_display_name($user_id) . ' || Waiting For Admin Approval',
                        );
                        insert_update_data(1, 'crm_feeds', $agentAddFeed);
                        $msg = "Hello," . $this->input->post('agency_name') . "<br><br>
                            Thank You for your registration.<br><br>
                            You are successfully registered in amenitybenefits.<br><br>
                            Once admin approve your registration request, then you able to login in our website.<br><br>
                            Thank You,<br><br>
                            Agency Vue";
                        $subject = "Thank You for your registration";
                        $to_email = $this->input->post('contact_email');
                        $agencyMail = send_broker_email_process($to_email, $subject, $msg);
                    }
                    if ($agencyMail == 0) {
                        $this->session->set_flashdata('error', "Something Went Wrong With Email");
                    }
                    $script_data['popup'] = 'Yes';
                    $script_data['naid'] = $user_id;
                    $this->session->set_flashdata('success', $script_data);
                    redirect('agent/agencies/add');
                } else {
                    $msg = "";
                    if ($agency_w9['status'] == 0) {
                        $msg .= 'Agency W9 Form :' . $agency_w9['msg'] . "<br>";
                    } if ($agency_dd['status'] == 0) {
                        $msg .= 'Agency Direct Deposit Form :' . $agency_dd['msg'] . "<br>";
                    } if ($agency_ca['status'] == 0) {
                        $msg .= 'Agency Contract Agreement :' . $agency_ca['msg'] . "<br>";
                    } if ($agnecyLogo['status'] == 0) {
                        $msg .= 'Agency Logo :' . $agnecyLogo['msg'] . "<br>";
                    }
                    $this->session->set_flashdata('error', $msg);
                }
            }
        }
        if ($this->input->post('stripe')) {
            $this->form_validation->set_rules('card_number', 'Card Number', 'required');
            $this->form_validation->set_rules('exp_month', 'Expiration Month', 'required');
            $this->form_validation->set_rules('exp_year', 'Expiration Year', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->form_validation->set_error_delimiters();
            } else {
                if ($this->input->post('naid')) {
                    $agency_id = $this->input->post('naid');
                    $cardDetailArray = array('agency_id' => $agency_id,
                        'card_number' => $this->input->post('card_number'),
                        'cvc' => $this->input->post('card_cvc'),
                        'exp_month' => $this->input->post('exp_month'),
                        'exp_year' => $this->input->post('exp_year'));
                    $cardDetailTbl = insert_update_data($ins = 1, $table_name = 'crm_agencies_card_details', $ins_data = $cardDetailArray);
                    if ($cardDetailTbl) {
                        $number = $this->input->post('card_number');
                        $cvc = $this->input->post('card_cvc');
                        $exp_month = $this->input->post('exp_month');
                        $exp_year = $this->input->post('exp_year');
                        $name = "VISA";
                        $agency_name = get_display_name($agency_id);
                        $stripeJson = stripe_payment($number, $cvc, $exp_month, $exp_year, $name, $agency_name);
                        $stripeArray = json_decode($stripeJson);
                        if (isset($stripeArray->id)) {
                            if ($stripeArray->status == 'succeeded') {
                                $updatePayment = array("is_payment" => 'Y', "agency_transaction_id" => $stripeArray->id);
                                $updateBasic = insert_update_data(0, "crm_agencies_basic", $updatePayment, array("user_id" => $agency_id));
                                if ($updateBasic) {
                                    $this->session->set_flashdata('success', "Your Payment Is Success");
                                } else {
                                    $this->session->set_flashdata('error', "Updating Data In System Is Fail");
                                    $this->session->set_flashdata('success', "Your Payment Is Success");
                                }
                                redirect("agent/agencies/");
                            }
                        } elseif (isset($stripeArray->error)) {
                            $this->session->set_flashdata('error', $stripeArray->error->message);
                        } else {
                            $this->session->set_flashdata('error', "Something Went To Wrong");
                        }
                        redirect("agent/agencies/");
                    }
                } else {
                    exit('Agency ID NULL || ERROR');
                }
            }
        }
        $this->template->load('agent_header', 'agent/agency/add', $data);
    }

    /**
     * Edit for
     */
    public function edit() {
        $data['title'] = "Agency Edit";
        $data['state'] = get_data($tbl_name = 'crm_states', $single = 0);
        if (isset($_REQUEST['user_id'])) {
            $userId = base64_decode(urldecode($_REQUEST['user_id']));
            $data['details'] = $this->agency->get_agency_details($userId);
            $data['city_pri'] = get_state_city($data['details']['agency_state']);
            if ($data['details']['bank_state'] != "") {
                $data['bank_cities'] = get_state_city($data['details']['bank_state']);
            }
            $data['state'] = get_all_state();
            if ($this->input->post()) {
                $this->form_validation->set_rules('agency_name', 'Agency Name', 'required');
                $this->form_validation->set_rules('contact_email', 'Contact Email', 'required|valid_email');
                $this->form_validation->set_rules('customer_service_number', 'Customer Service Number', 'required');
                $this->form_validation->set_rules('phone_number', 'Phone Number', 'required');
                $this->form_validation->set_rules('address', 'Address', 'required');
                $this->form_validation->set_rules('sel_state', 'State', 'required');
                $this->form_validation->set_rules('sel_city', 'City', 'required');
                if ($this->form_validation->run() == FALSE) {
                    $this->form_validation->set_error_delimiters();
                } else {
                    $locationImage = "assets/crm_image/agencieslogo/";
                    $location = "assets/crm_docs/agency_uploaded_docs/";
                    $agnecyLogo = FileInsert($locationImage, "agency_logo", "image", "2097152", $this->input->post('h_agency_logo'));
                    $agency_w9 = FileInsert($location, "agency_w9", "doc", "2097152", $this->input->post('h_agency_w9'));
                    $agency_dd = FileInsert($location, "agency_direct_deposit", "doc", "2097152", $this->input->post('h_agency_direct_deposit'));
                    $agency_ca = FileInsert($location, "agency_contract_agreement", "doc", "2097152", $this->input->post('h_agency_contract_agreement'));
                    $agencyBasic = array(
                        'parent_id' => $this->session->userdata['user_info']['user_id'],
                        'agency_name' => $this->input->post('agency_name'),
                        'contact_name' => $this->input->post('contact_name'),
                        'agency_email' => $this->input->post('contact_email'),
                        'agency_phone' => $this->input->post('phone_number'),
                        'agency_address' => $this->input->post('address'),
                        'agency_sub_address' => $this->input->post('address_addtional'),
                        'agency_state' => $this->input->post('sel_state'),
                        'agency_city' => $this->input->post('sel_city'),
                        'agency_zip_code' => $this->input->post('zipcode'),
                        'agency_customer_service_number' => $this->input->post('customer_service_number'),
                        'agency_customer_service_email' => $this->input->post('contact_email'),
                        'agency_image' => $agnecyLogo['msg'],
                    );
                    $condition_agency_basic = array('user_id' => $userId);
                    $agencyTbl = insert_update_data($ins = 0, $table_name = 'crm_agencies_basic', $ins_data = $agencyBasic, $where = $condition_agency_basic);
                    $agencyBank = array(
                        'bank_name' => $this->input->post('angecy_bank_name'),
                        'bank_add' => $this->input->post('angecy_bank_add'),
                        'bank_city' => $this->input->post('bank_city'),
                        'bank_state' => $this->input->post('bank_state'),
                        'bank_zipcode' => $this->input->post('bank_zipcode'),
                        'agency_name_on_account' => $this->input->post('name_on_account'),
                        'agency_account_number' => $this->input->post('account_number'),
                        'angecy_routing_number' => $this->input->post('routing_number'),
                    );
                    $condition_agency_bank = array('agency_id' => $userId);
                    $agencybankTble = insert_update_data($ins = 0, $table_name = 'crm_agencies_bank_details', $ins_data = $agencyBank, $condition_agency_bank);
                    $agencyDoc = array(
                        'agency_id' => $userId,
                        'agency_w9_form' => $agency_w9['msg'],
                        'agency_direct_deposit' => $agency_dd['msg'],
                        'agency_contract_agreement' => $agency_ca['msg']
                    );
                    $condition_agency_doc = array('agency_id' => $userId);
                    $agencydocTbl = insert_update_data($ins = 0, $table_name = 'crm_agencies_documents', $ins_data = $agencyDoc, $condition_agency_doc);
                    if ($agencydocTbl && $agencybankTble && $agencyTbl) {
                        $editLog = "Agency Updated";
                        $logArray = array(
                            'agency_id' => $userId,
                            'action_by' => $this->session->userdata['user_info']['user_id'],
                            'action_text' => $editLog
                        );
                        $agencylog = insert_update_data($ins = 1, $table_name = 'crm_agency_log', $ins_data = $logArray);
                    }
                    if ($agencyTbl) {
                        $this->session->set_flashdata('success', 'Agency Successfully Updated!');
                        redirect('agent/agencies/edit?user_id=' . $_REQUEST['user_id']);
                    }
                }
            }
            $this->template->load('agent_header', 'agent/agency/edit', $data);
        } else {
            exit("Agency ID NULL || ERROR");
        }
    }

    /*
     * Display Agency with details
     */

    public function view() {
        $data['title'] = "View Agency In Detail";
        if (isset($_REQUEST['user_id'])) {
            $userId = base64_decode(urldecode($_REQUEST['user_id']));
            $data['details'] = $this->agency->get_agency_details($userId);
            $this->template->load('agent_header', 'agent/agency/view', $data);
        } else {
            exit("Agency ID NULL || ERROR");
        }
    }

    /**
     * Display log of agency Activities
     */
    public function show_agency_log() {
        $agencyID = $this->input->post('agencyid');
        $aWhere = array('user_id' => $agencyID);
        $data['agency'] = get_data("crm_agencies_basic", 1, $aWhere);
        $data['logs'] = $this->agency->get_sub_agency_log($agencyID);
        echo $this->load->view('admin/agencies/log', $data, true);
        die;
    }

    /**
     * Remove Agency from data grid ( is_delete = Y )
     */
    public function remove() {
        $agencyID = $this->input->post('agency');
        if ($agencyID != "") {
            $condition_agency_basic = array('user_id' => $agencyID);
            $data = array('is_delete' => 'Y');
            $done = insert_update_data($ins = 0, $tbl_name = 'crm_agencies_basic', $data = $data, $where = $condition_agency_basic);
            $this->session->set_flashdata('error', 'Agency Successfully Delete!');
            if ($done) {
                echo "Member Successfully Delete";
            }
        } else {
            exit("Agency ID Can't Be Null || ERROR");
        }
        die();
    }

}
