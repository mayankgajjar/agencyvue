<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Agencies : Agencies Manager for "Administrator" user only.
 *
 * @author dhareen
 */
class Agencies extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('agency');
    }

    /**
     * @uses Load Mini Dashboard for agencies
     */
    public function index() {

    }

    /**
     * @uses Manage approved agencies
     */
    public function manage() {
        $data['title'] = "Manage Approved Agenies || Admin";
        $this->template->load('admin_header', 'admin/agencies/manage', $data);
    }

    /**
     * @uses Data-table JSON FOR APPROVED AGENCIES.
     */
    public function agenciesJson() {

        $aColumns = array("agency_image", "agency_name", "agency_email", "agency_city", "created_date", "display_name");

        /*
         * Paging
         */

        $sLimit = array();
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {

            $sLimit = array("start" => $_GET['iDisplayLength'], "end" => $_GET['iDisplayStart']);
        }

        /*
         * Search
         */

        $sWhere = "";
        if ($_GET['sSearch'] != "") {
            $aColumns_alise = array("basic.agency_name", "basic.agency_email", "basic.agency_city", "basic.created_date");
            $sWhere .= " (";
            for ($i = 0; $i < count($aColumns_alise); $i++) {
                $sWhere .= $aColumns_alise[$i] . " LIKE '%" . $_GET['sSearch'] . "%' OR ";
                //$sWhere[$aColumns[$i]] = $_GET['sSearch'];
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ') ';
        }
        /*
         * Order
         */
        $sOrder = array();
        if ($_GET['iSortCol_0'] != "") {
            for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                    $sOrder = array("field" => $aColumns[intval($_GET['iSortCol_' . $i])],
                        "order" => $_GET['sSortDir_' . $i]);
                }
            }
        } else {
            $sOrder = array("field" => $aColumns[5],
                "order" => 'DESC');
        }

        $rResult = $this->agency->get_approved_agencies($sLimit, $sWhere, $sOrder);
        $iTotal_f = count($rResult);
        $iTotal = $this->agency->get_count_approved_agenices($sWhere);
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
                    if ($aColumns[$i] == 'agency_image') {
                        if ($aRow['agency_image'] != "") {
                            $row[] = " <div class='checkbox checkbox-primary checkbox-single m-r-15'>
                        <input id='act_checkbox_" . $aRow['user_id'] . "' type='checkbox' value=" . urlencode(base64_encode($aRow["user_id"])) . " name='act_checkbox[]' class='ch_checkbox'>
                        <label for='act-checkbox'></label>
                    </div> <img src=" . base_url() . "assets/crm_image/agencieslogo/" . $aRow['agency_image'] . " alt='contact-img' title='contact-img' class='img-circle thumb-sm' />";
                        } else {
                            $row[] = " <div class='checkbox checkbox-primary checkbox-single m-r-15'>
                        <input id='act_checkbox_" . $aRow['user_id'] . "' type='checkbox' value=" . urlencode(base64_encode($aRow["user_id"])) . " name='act_checkbox[]' class='ch_checkbox'>
                        <label for='act-checkbox'></label>
                    </div> <img src=" . base_url() . "assets/images/users/avatar-5.jpg alt='contact-img' title='contact-img' class='img-circle thumb-sm' />";
                        }
                    } else {
                        $row[] = isset($aRow[$aColumns[$i]]) ? $aRow[$aColumns[$i]] : '';
                    }
                }
                $row[] .= '<a href="' . base_url() . 'admin/agencies/view?user_id=' . urlencode(base64_encode($aRow["user_id"])) . '" class="btn btn-info btn-xs table-action-btn admin-action-icon-in-data-table"title="View Profile"><i class="fa fa-eye"></i></a>&nbsp'
                        . '<a href="' . base_url() . 'admin/agencies/edit?user_id=' . urlencode(base64_encode($aRow["user_id"])) . '" class="btn btn-default btn-xs table-action-btn admin-action-icon-in-data-table" title="Edit Agency Profile"><i class="fa fa-pencil"></i></a>'
                        . '<button type="button" class="danger-alert btn btn-danger btn-xs table-action-btn admin-action-icon-in-data-table del_agency" value="' . urlencode(base64_encode($aRow['user_id'])) . '" title="Remove"><i class="fa fa-times"></i></button>'
                        . '<span class="danger-alert btn btn-primary btn-xs table-action-btn show_log admin-action-icon-in-data-table info-span" data-custom-value="' . $aRow["user_id"] . '" title=" View Activity Log"><i class="fa fa-list-ul" title="View Log"></i></span>'
                        . '<span class="btn btn-info btn-xs table-action-btn admin-action-icon-in-data-table change-password" data-custom-value="' . $aRow["user_id"] . '"><i class="glyphicon glyphicon-lock" title="Change Password"></i></span>';

                $output['aaData'][] = $row;
            }
        }

        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    /**
     * @uses Manage un-approved agencies
     */
    public function unapproved() {
        $data['title'] = "Manage Un-Approved Agenies || Admin";
        $this->template->load('admin_header', 'admin/agencies/unapproved', $data);
    }

    /**
     * @uses  Data-table JSON FOR UN-APPROVED AGENCIES.
     */
    public function unapprovedJson() {

        $aColumns = array("agency_name", "agency_email", "agency_city", "created_date", "parent_id");

        /*
         * Paging
         */

        $sLimit = array();
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {

            $sLimit = array("start" => $_GET['iDisplayLength'], "end" => $_GET['iDisplayStart']);
        }

        /*
         * Search
         */

        $sWhere = "";
        if ($_GET['sSearch'] != "") {
            $aColumns_alise = array("basic.agency_name", "basic.agency_email", "basic.agency_city", "basic.created_date");
            $sWhere .= " (";
            for ($i = 0; $i < count($aColumns_alise); $i++) {
                $sWhere .= $aColumns_alise[$i] . " LIKE '%" . $_GET['sSearch'] . "%' OR ";
                //$sWhere[$aColumns[$i]] = $_GET['sSearch'];
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ') ';
        }
        /*
         * Order
         */
        $sOrder = array();
        if ($_GET['iSortCol_0'] != "") {
            for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                    $sOrder = array("field" => $aColumns[intval($_GET['iSortCol_' . $i])],
                        "order" => $_GET['sSortDir_' . $i]);
                }
            }
        } else {
            $sOrder = array("field" => $aColumns[5],
                "order" => 'DESC');
        }

        $rResult = $this->agency->get_unpproved_agencies($sLimit, $sWhere, $sOrder);
        $iTotal_f = count($rResult);
        $iTotal = $this->agency->get_count_agenices($sWhere);
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
                    if ($aColumns[$i] == "parent_id") {
                        if ($aRow[$aColumns[$i]] == "") {
                            $row[] = "Self Registered";
                        } else {
                            $row[] = $aRow['display_name'];
                        }
                    } else {
                        $row[] = isset($aRow[$aColumns[$i]]) ? $aRow[$aColumns[$i]] : '';
                    }
                }
                $row[] .= '<button class="btn btn-info waves-effect waves-light btn-xs view_profile" value="' . urlencode(base64_encode($aRow["user_id"])) . '" title="View Profile"><i class="fa fa-eye"></i></button>&nbsp'
                        . '<button type="button" class="btn btn-success waves-effect waves-light btn-xs approved" value="' . urlencode(base64_encode($aRow['user_id'])) . '"><i class="fa fa-check" title="Approved"></i></button>&nbsp'
                        . '<button type="button" class="danger-alert btn btn-danger waves-effect waves-light btn-xs disapproved" value="' . urlencode(base64_encode($aRow['user_id'])) . '" title="Disapproved"><i class="fa fa-times"></i></button>';

                $output['aaData'][] = $row;
            }
        }
        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    public function profile() {
        $user_id = base64_decode(urldecode($_REQUEST['user_id']));
        $data['agency_details'] = $this->agency->get_agency_profile($user_id);
        $this->load->view('admin/agencies/agency_profile', $data);
    }

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
                        redirect('agency/subagencies');
                    }
                }
            }
            $this->template->load('admin_header', 'admin/agencies/edit', $data);
        } else {
            exit("Agency ID NULL || ERROR");
        }
    }

    function process() {
        if ($_REQUEST['user_id'] != "") {
            if ($_REQUEST['req_type'] != "") {
                $uid = base64_decode(urldecode($_REQUEST['user_id']));
                $userdata = get_data("crm_user_tbl", 1, "user_id = $uid");
                $agencyBasic = get_data("crm_agencies_basic", 1, "user_id=$uid");
                $user_email = $agencyBasic["agency_email"];
                $type = $agencyBasic["parent_id"];
                if ($_REQUEST['req_type'] == 'approved') {
                    $approvedArray = array("is_approved" => "Y");
                    $userId = array("user_id" => $uid);
                    insert_update_data($ins = 0, $tbl_name = 'crm_user_tbl', $approvedArray, $userId);
                    insert_update_data($ins = 0, "crm_agencies_basic", array("is_approved" => "Y"), $userId);
                    if ($type == "") {
                        $parentArray = array("parent_id" => $this->session->userdata['user_info']['user_id']);
                        insert_update_data($ins = 0, $tbl_name = 'crm_agencies_basic', $parentArray, $userId);
                    }
                    $subject = 'Agency account registration';
                    $msg = "Hi,<br><br>

					<strong> Your Agency account is approved. </strong><br><br>
                                        You can login in system with you Email ID and Password. <br><br>
                                        Here is login URL  http://agencyvue.com/login/  <br><br>
					Thanks,<br><br>
					AgencyVUE.<br>";

                    if (send_broker_email_process($user_email, $subject, $msg)) {
                        $agentAddFeed = array(
                            'from_id' => $this->session->userdata['user_info']['user_id'],
                            'to_id' => $agencyBasic['parent_id'],
                            'feed_type' => 'feed',
                            'feed_icon' => 'fa fa-check',
                            'feed_title' => 'Agency Profile ( ' . $agencyBasic['agency_name'] . ' ) Approved By Admin',
                            'is_admin' => 'Y'
                        );
                        insert_update_data(1, 'crm_feeds', $agentAddFeed);
                        echo 'approved';
                    } else {
                        echo "Please try again!";
                    }
                }
                if ($_REQUEST['req_type'] == 'disapproved') {
                    $unapprovedArray = array("is_approved" => "N");
                    $userId = array("user_id" => $uid);
                    $userTBL = insert_update_data($ins = 0, $tbl_name = 'crm_user_tbl', $unapprovedArray, $userId);
                    $agencyBasicTbl = insert_update_data($ins = 0, "crm_agencies_basic", array("is_approved" => "N"), $userId);
                    if ($userTBL && $agencyBasicTbl) {
                        $swalText = "Disapproved";
                        $agencyBasic = get_data("crm_agencies_basic", 1, $userId);
                        $agency_transaction_id = $agencyBasic['agency_transaction_id'];
                        //transaction id in there in agency
                        if ($agency_transaction_id != "") {
                            $refurndJson = stripe_refund_registration_agency($agency_transaction_id);
                            $refurndArray = json_decode($refurndJson);
                            if (isset($refurndArray->id)) {
                                $updateRefund = array("is_payment" => 'R', "refund_date" => date("Y-m-d H:i:s"));
                                $updateBasic = insert_update_data(0, "crm_agencies_basic", $updateRefund, $userId);
                                if ($updateBasic) {
                                    $swalText = 'Disapproved And Payment Refund';
                                }
                            } elseif (isset($refurndArray->error)) {
                                $swalText = "Disapproved But " . " Payment Refund Error In Stripe:: " . $refurndArray->error->message;
                            } else {
                                $swalText = "Disapproved But Something Went Wrong With Payment Refund";
                            }
                        }
                        $subject = 'Agency account registration';
                        $msg = "Hi,<br><br>

					<strong> Your Agency account is disapproved by our admin. </strong> <br><br>
                                        For more details,please feel free to contact us || http://cms.agencyvue.com/contact-us-2/ <br>
                                        <i>We have refunded your registration fee in your account</i>
					Thanks,<br>
					AgencyVUE.";

                        if (send_broker_email_process($user_email, $subject, $msg)) {
                            $agentAddFeed = array(
                                'from_id' => $this->session->userdata['user_info']['user_id'],
                                'to_id' => $agencyBasic['parent_id'],
                                'feed_type' => 'feed',
                                'feed_icon' => 'fa fa-times',
                                'feed_title' => 'Agency Profile ( ' . $agencyBasic['agency_name'] . ' ) disapproved By Admin',
                                'is_admin' => 'Y'
                            );
                            insert_update_data(1, 'crm_feeds', $agentAddFeed);
                            echo $swalText;
                        }
                    } else {
                        echo "Please try again!";
                    }
                }
            } else {
                exit('error');
            }
        } else {
            exit('unble to access');
        }
    }

    /**
     * Remove Agency
     */
    public function remove($user_id = "") {
        $user_id = base64_decode(urldecode($this->input->post('user_id')));
        if ($user_id == "") {
            exit("USER ID NULL || ERROR!");
        }
        $con = array('user_id' => $user_id);
        $data = array('is_deleted' => 'Y');
        $doneMaster = insert_update_data($ins = 0, $tbl_name = 'crm_user_tbl', $data = $data, $where = $con);
        $data1 = array('is_delete' => 'Y');
        $doneBasic = insert_update_data($ins = 0, $tbl_name = 'crm_agencies_basic', $data = $data1, $where = $con);
        if ($doneBasic && $doneMaster) {
            $msg = "Agency Successfully Delete";
            echo $msg;
        }
    }

    /**
     * View Product
     */
    public function view() {
        $data['title'] = "View Agency In Detail";
        if (isset($_REQUEST['user_id'])) {
            $userId = base64_decode(urldecode($_REQUEST['user_id']));
            $data['details'] = $this->agency->get_agency_details($userId);
            $this->template->load('admin_header', 'admin/agencies/view', $data);
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
        $data['logs'] = $this->agency->get_sub_agency_log($agencyID, "Y");
        echo $this->load->view('admin/agencies/log', $data, true);
        die;
    }

    public function change_password_by_admin() {
        $cus_id = $this->input->post('user_id');
        $mail_password = $this->input->post('password');
        $password = md5($mail_password);
        $data_personal = get_data("crm_user_tbl", 1, "user_id = $cus_id");
        $con = array('user_id' => $cus_id);
        $data = array('password' => $password);
        $done = insert_update_data($ins = 0, $tbl_name = 'crm_user_tbl', $data = $data, $where = $con);

        $msg = "Hello " . $data_personal['display_name'] . "<br><br>
                    Your agencyVUE( https://agencyvue.com) password updated by the system admin.<br><br>
                    Here is your new password:<strong>" . $mail_password . "</strong><br><br>
                    You can login in a system from your login email ID ( this email ID ) with above password. At this URL : https://agencyvue.com/login<br><br>
                    Thanks,<br><br>
                    AgencyVUE.<br>";
        $subject = "AgencyVUE Password Updated";
        $to_email = $data_personal['email'];
        $title = 'AgencyVUE Password Updated';
        send_email($to_email, $subject, $msg, $title);

        if ($done) {
            echo "Password Successfully Change";
        } else {
            echo "Error Into Password Change";
        }
        die;
    }

}
