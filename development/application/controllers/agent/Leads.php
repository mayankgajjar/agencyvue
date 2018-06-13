<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Leads extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('lead');
    }

    /**
     * @uses open leads index page
     * @author MGA
     */
    public function index() {
        $data['title'] = 'Leads';
        $this->template->load('agent_header', 'agent/lead/index', $data);
    }

    /**
     * @uses add leads data in crm_lead_member_primary table
     * @author MGA
     */
    public function add_lead() {
        $member_data = array('customer_status' => 'lead', 'broker_id' => $this->session->userdata['user_info'] ['user_id']);

        $lead_member_master = insert_update_data($ins = 1, $table_name = 'crm_lead_member_master', $ins_data = $member_data);
        $customer_id = $this->db->insert_id();

        $log = array('action_by' => $this->session->userdata['user_info']['user_id'], 'customer_id' => $customer_id, 'action' => 'created');
        $lead_log = insert_update_data($ins = 1, $table_name = 'crm_lead_log', $ins_data = $log);

        $member_primary = array('customer_id' => $customer_id, 'customer_first_name' => $this->input->post('first'),
            'customer_last_name' => $this->input->post('last'), 'customer_gender' => $this->input->post('gender'), 'customer_email' => $this->input->post('email1'),
            'customer_phone_number' => $this->input->post('con'));
        $lead_member_primary = insert_update_data($ins = 1, $table_name = 'crm_lead_member_primary', $ins_data = $member_primary);
        if ($lead_member_master && $lead_member_primary && $lead_log) {
            $msg = "Lead Successfully Insert";
            $leadAddFeed = array(
                'from_id' => $this->session->userdata['user_info']['user_id'],
                'to_id' => $this->session->userdata['user_info']['user_id'],
                'feed_type' => 'feed',
                'feed_icon' => 'fa fa-address-book-o',
                'feed_title' => 'New Lead Added',
                'url' => base_url() . 'agent/leads/edit_leads/' . urlencode(base64_encode($customer_id)),
            );
            insert_update_data(1, 'crm_feeds', $leadAddFeed);
            echo $msg;
            //echo $this->session->set_flashdata('success', 'Password successfully updated!');
        }
        die;
    }

    /**
     * @uses Get all leads data
     * @author MGA
     */
    function indexJson() {

        $aColumns = array("customer_id", "customer_first_name", "customer_email", "customer_created_date");

        /* Pagination */

        $sLimit = array();
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $sLimit = array("start" => $_GET['iDisplayLength'], "end" => $_GET['iDisplayStart']);
        }

        /* Search */

        $sWhere = "";

        if ($_GET['sSearch'] != "") {
            $sColumns = array("customer_first_name", "customer_email", "crm_lead_member_master.customer_created_date");

            $sWhere .= " (";
            for ($i = 0; $i < count($sColumns); $i++) {
                $sWhere .= $sColumns[$i] . " LIKE '%" . $_GET['sSearch'] . "%' OR ";
                //$sWhere[$aColumns[$i]] = $_GET['sSearch'];
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
        } else {
            $sOrder = array("field" => $aColumns[3],
                "order" => 'DESC');
        }

        $rResult = $this->lead->get_leads($sLimit, $sWhere, $sOrder);

        $iTotal_f = count($rResult);

        $iTotal = $this->lead->get_leads_count($sWhere);

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
                    if ($aColumns[$i] == 'customer_id') {

                        if ($aRow['customer_gender'] == 'male') {
                            $row[] = "
                    <div class='checkbox checkbox-primary checkbox-single m-r-15'>
                        <input id='act_checkbox_" . $aRow['customer_id'] . "' type='checkbox' value=" . urlencode(base64_encode($aRow["customer_id"])) . " name='act_checkbox[]' class='ch_checkbox profile_checkbox'>
                        <label for='act-checkbox'></label>
                    </div>
                    <img src=" . base_url() . "assets/crm_image/Male_Placeholder.png alt='contact-img' title='contact-img' class='img-circle thumb-sm' />";
                        } else {
                            $row[] = "
                    <div class='checkbox checkbox-primary checkbox-single m-r-15'>
                        <input id='act_checkbox_" . $aRow['customer_id'] . "' type='checkbox' value=" . urlencode(base64_encode($aRow["customer_id"])) . " name='act_checkbox[]' class='ch_checkbox profile_checkbox'>
                        <label for='act-checkbox'></label>
                    </div>
                    <img src=" . base_url() . "assets/crm_image/Female_Placeholder.png alt='contact-img' title='contact-img' class='img-circle thumb-sm' />";
                        }
                    } elseif ($aColumns[$i] == 'customer_created_date') {
                        $row[] .= date('m-d-Y h:i:s a', strtotime($aRow['customer_created_date']));
                    } else {
                        $row[] = isset($aRow[$aColumns[$i]]) ? $aRow[$aColumns[$i]] : '';
                    }
                }

                $row[] .= '<a class="btn btn-info btn-xs table-action-btn admin-action-icon-in-data-table" href="' . base_url() . 'agent/leads/view_profile?customer_id=' . urlencode(base64_encode($aRow["customer_id"])) . '"title="View lead Profile"><i class="glyphicon glyphicon-eye-open" title="View Profile"></i></a>'
                        . '<a href="' . base_url() . 'agent/leads/edit_leads/' . urlencode(base64_encode($aRow["customer_id"])) . '" class="edit_btn btn btn-default btn-xs table-action-btn admin-action-icon-in-data-table"><i class="glyphicon glyphicon-pencil" title="Edit Lead"></i></a>'
                        . '<span class="danger-alert btn btn-danger btn-xs table-action-btn del_lead admin-action-icon-in-data-table remove-span" data-custom-value="' . $aRow["customer_id"] . '"><i class="glyphicon glyphicon-remove" title="Remove Lead"></i></span>'
                        . '<span class="danger-alert btn btn-primary btn-xs table-action-btn lead_det admin-action-icon-in-data-table info-span" data-custom-value="' . $aRow["customer_id"] . '"><i class="fa fa-list-ul" title="View Log"></i></span>';


                $output['aaData'][] = $row;
            }
        }

        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    function view_profile() {

        $data['title'] = 'Lead Profile';

        $customer_id = base64_decode(urldecode($_REQUEST['customer_id']));

        $data['lead_information'] = $this->lead->get_lead_profile($customer_id);

        $data['customer_id'] = $customer_id;

        $this->template->load('agent_header', 'agent/lead/view_profile', $data);
    }

    /**
     * @uses Get all leads data
     * @author MGA
     */
    public function edit_leads($id = null) {
        $data['title'] = 'Edit Lead';
        $uid = base64_decode(urldecode($id));
        $data['child_names'] = $this->lead->customer_child_count($uid);
        $data['spouse_name'] = $this->lead->customer_spouse_count($uid);
        $lead_info = $this->lead->get_infos($uid, 'crm_lead_member_primary', 'customer_id');
        $data['lead_info'] = $lead_info[0];

        $lead_member_spouse_info = $this->lead->get_infos($uid, 'crm_lead_member_spouse', 'customer_id');
        $data['lead_member_spouse_info'] = isset($lead_member_spouse_info[0]) ? $lead_member_spouse_info[0] : array();
        $data['customer_id'] = $uid;

        $new_block['member_child'] = array();

        $new_block['customer_id'] = $uid;
        $new_block['state'] = get_data($tbl_name = 'crm_states', $single = 0);

        $child_arr = $this->lead->get_infos($uid, 'crm_lead_member_child', 'customer_id');


        if (!empty($child_arr)) {
            $new_block['add_child_block_arr'] = $child_arr;

            $i = 0;
            foreach ($child_arr as $value) {
                $select_state = $value['customer_child_state'];
                $this->db->where('state_code', $select_state);
                $query = $this->db->get('crm_cities');
                $new_block['get_city'][$i] = $query->result_array();
                $i = $i + 1;
            }
        } else {
            $new_block['add_child_block_arr'] = array();
        }

        $data['add_child_block_html'] = $this->load->view('agent/lead/get_child_view', $new_block, true);

        $data['state'] = get_data($tbl_name = 'crm_states', $single = 0);

        $con_pri = array('state_code' => $data['lead_info']['customer_state']);
        $this->db->where($con_pri);
        $query = $this->db->get('crm_cities');
        $data['city_pri'] = $query->result_array();

        if ($data['lead_member_spouse_info']) {
            $con_sop = array('state_code' => $data['lead_member_spouse_info']['customer_spouse_state']);
            $this->db->where($con_sop);
            $query = $this->db->get('crm_cities');
            $data['city_sop'] = $query->result_array();
        }

        $this->load->model('vendor');
        $this->load->model('common');
        $data['vendors'] = $this->vendor->get();
        $data['states'] = $this->common->get_all_state();
        $this->template->load('agent_header', 'agent/lead/edit_lead', $data);
    }

    /**
     * Function for save lead
     */
    public function save_lead() {
        $customer_id = $this->input->post('customer_id');
        $data_crm_lead_member_primary = array(
            'customer_first_name' => $this->input->post('cus_first_name'),
            'customer_middle_name' => $this->input->post('cus_middle_name'),
            'customer_last_name' => $this->input->post('cus_last_name'),
            'customer_gender' => $this->input->post('gender'),
            'customer_email' => $this->input->post('cus_email'),
            'customer_phone_number' => $this->input->post('cus_contact'),
            'customer_dob' => date('Y-m-d', strtotime($this->input->post('cus_dob'))),
            'customer_address' => $this->input->post('cus_address'),
            'customer_address_details' => $this->input->post('cus_sub_address'),
            'customer_city' => $this->input->post('cus_city'),
            'customer_state' => $this->input->post('cus_state'),
            'customer_zipcode' => $this->input->post('cus_zip'),
            'customer_social_security_number' => $this->input->post('cus_security_number'),
            'customer_weight' => $this->input->post('customer_weight')
        );
        $condition_crm_lead_member_primary = array('customer_id' => $customer_id);
        $this->lead->master_update('crm_lead_member_primary', $data_crm_lead_member_primary, $condition_crm_lead_member_primary);
        $pr_log = array('action_by' => $this->session->userdata['user_info']['user_id'], 'customer_id' => $customer_id, 'action' => 'update', 'section' => 'primary section');
        $lead_log = insert_update_data($ins = 1, $table_name = 'crm_lead_log', $ins_data = $pr_log);
        $lead_info = $this->lead->get_infos($customer_id, 'crm_lead_member_spouse', 'customer_id');

        if ($this->input->post('spouse_first_name') != '') {
            $data_crm_lead_member_spouse = array(
                'customer_spouse_first_name' => $this->input->post('spouse_first_name'),
                'customer_spouse_middle_name' => $this->input->post('spouse_middle_name'),
                'customer_spouse_last_name' => $this->input->post('spouse_last_name'),
                'customer_spouse_email' => $this->input->post('spouse_email_address'),
                'customer_spouse_phone_number' => $this->input->post('spouse_phone_no'),
                'customer_spouse_dob' => date('Y-m-d', strtotime($this->input->post('spouse_dob'))),
                'customer_spouse_address' => $this->input->post('spouse_address'),
                'customer_spouse_address_details' => $this->input->post('spouse_sub_address'),
                'customer_spouse_city' => $this->input->post('spouse_city'),
                'customer_spouse_state' => $this->input->post('customer_spouse_state'),
                'customer_spouse_zipcode' => $this->input->post('spouse_zipcode'),
                'customer_spouse_social_security_number' => $this->input->post('spouse_ssn'),
            );

            if (empty($lead_info)) {
                $data_crm_lead_member_spouse['customer_id'] = $customer_id;
                $this->lead->master_insert('crm_lead_member_spouse', $data_crm_lead_member_spouse);
                $sp_log = array('action_by' => $this->session->userdata['user_info']['user_id'], 'customer_id' => $customer_id, 'action' => 'created', 'section' => 'spouse section');
                $lead_log = insert_update_data($ins = 1, $table_name = 'crm_lead_log', $ins_data = $sp_log);
            } else {
                $condition_crm_lead_member_spouse = array('customer_id' => $customer_id);
                $this->lead->master_update('crm_lead_member_spouse', $data_crm_lead_member_spouse, $condition_crm_lead_member_spouse);
                $sp_log = array('action_by' => $this->session->userdata['user_info']['user_id'], 'customer_id' => $customer_id, 'action' => 'update', 'section' => 'spouse section');
                $lead_log = insert_update_data($ins = 1, $table_name = 'crm_lead_log', $ins_data = $sp_log);
            }
        }

        $list = $this->input->post('form');

        foreach ($list as $key => $value) {
            if ($value['customer_child_first_name'] != "") {
                $child_array = array(
                    'customer_id' => $customer_id,
                    'customer_child_first_name' => $value['customer_child_first_name'],
                    'customer_child_middle_name' => $value['customer_child_middle_name'],
                    'customer_child_last_name' => $value['customer_child_last_name'],
                    'customer_child_email' => $value['customer_child_email'],
                    'customer_child_phone_number' => $value['customer_child_phone_number'],
                    'customer_child_dob' => date('Y-m-d', strtotime($value['customer_child_dob'])),
                    'customer_child_address' => $value['customer_child_address'],
                    'customer_child_address_details' => $value['customer_child_address_details'],
                    'customer_child_city' => $value['customer_child_city'],
                    'customer_child_state' => $value['customer_child_state'],
                    'customer_child_zipcode' => $value['customer_child_zipcode'],
                    'customer_child_social_security_number' => $value['customer_child_social_security_number'],
                );

                if ($value['status'] == 'new') {
                    insert_update_data($ins = 1, $table_name = 'crm_lead_member_child', $ins_data = $child_array);

                    $ch_log = array('action_by' => $this->session->userdata['user_info']['user_id'], 'customer_id' => $customer_id, 'action' => 'created', 'section' => 'child section');
                    $lead_log = insert_update_data($ins = 1, $table_name = 'crm_lead_log', $ins_data = $ch_log);
                }
                if ($value['status'] == 'old') {

                    $condition_crm_lead_member_child = array('child_id' => $value['child_id']);
                    insert_update_data($ins = 0, $table_name = 'crm_lead_member_child', $ins_data = $child_array, $where = $condition_crm_lead_member_child);

                    $ch_log = array('action_by' => $this->session->userdata['user_info']['user_id'], 'customer_id' => $customer_id, 'action' => 'update', 'section' => 'child section');
                    $lead_log = insert_update_data($ins = 1, $table_name = 'crm_lead_log', $ins_data = $ch_log);
                }
            }
        }

        echo $this->session->set_flashdata('success', 'Lead Successfully Updated!');
    }

    /**
     * @uses show_lead_info is used for show all lead information and active
     * @author MGA
     */
    public function show_lead_info() {
        $lead_id = $this->input->post('leadid');
        $this->db->where('customer_id', $lead_id);
        $query = $this->db->get('crm_lead_member_primary');
        $data['result'] = $query->row();

        $table = 'crm_lead_log';
        $options = array(
            'fields' => array(
                'log_id', 'action', 'customer_id', 'customer_id', 'customer_id', 'log_datetime', 'section', 'action_by', 'add_product', 'remove_product', 'add_billing', 'remove_billing', 'display_name'
            ),
            'JOIN' => array(
                array(
                    'table' => 'crm_user_tbl',
                    'condition' => 'crm_user_tbl.user_id = crm_lead_log.action_by',
                    'type' => 'FULL'
                )
            ),
            'conditions' => array(
                "crm_lead_log.customer_id" => $lead_id,
            ),
            'ORDER_BY' => array(
                "field" => 'crm_lead_log.log_datetime',
                "order" => 'DESC'
            )
        );

        $data['lead_log'] = get_relation($table, $options);

        echo $this->load->view('agent/lead/lead_info', $data, true);
        die;
    }

    /**
     * @uses removelead is used for remove or delete lead
     * @author MGA
     */
    public function removelead() {

        $cus_id = $this->input->post('user_id');
        $con = array('customer_id' => $cus_id);
        $data = array('is_delete' => 'Y');
        $done = insert_update_data($ins = 0, $tbl_name = 'crm_lead_member_master', $data = $data, $where = $con);

        /* $cus_id = $this->input->post('user_id');
          $con = array('customer_id' => $cus_id);

          $lead_log = delete_data($tbl_name = 'crm_lead_log', $where = $con);
          $lead_member_master = delete_data($tbl_name = 'crm_lead_member_master', $where = $con);
          $lead_member_primary = delete_data($tbl_name = 'crm_lead_member_primary', $where = $con);
          $lead_member_spouse = delete_data($tbl_name = 'crm_lead_member_spouse', $where = $con);
          $lead_member_child = delete_data($tbl_name = 'crm_lead_member_child', $where = $con); */


        if ($done) {
            $msg = "Lead Successfully Delete";
            echo $msg;
        }

        die();
    }

    /**
     * @uses getcity is used for get city in dropdawn
     * @author MGA
     */
    public function getcity() {
        $ust = $this->input->post('ustid');
        $sopstid = $this->input->post('sopstid');

        if ($ust) {
            $con_array = array('state_code' => $ust);

            $this->db->where($con_array);
            $query = $this->db->get('crm_cities');
            $citylist = $query->result();

            $html = "<select class='form-control required' id='user_city' name='cus_city'>";
            $html .= "<option value=''>Please Select City</option>";
            foreach ($citylist as $q) {
                $html = $html . "<option value='$q->city'>$q->city</option>";
            }
        } elseif ($sopstid) {

            $con_array = array('state_code' => $sopstid);

            $this->db->where($con_array);
            $query = $this->db->get('crm_cities');
            $citylist = $query->result();

            $html = "<select class='form-control required' id='spo_user_city' name='spouse_city'>";
            $html .= "<option value=''>Please Select City</option>";
            foreach ($citylist as $q) {
                $html = $html . "<option value='$q->city'>$q->city</option>";
            }
        } elseif ($cst) {

            $con_array = array('state_code' => $cst);

            $this->db->where($con_array);
            $query = $this->db->get('crm_cities');
            $citylist = $query->result();

            $html = "<select class='form-control required selcity' id='commision_city' name='commision_city'>";
            $html .= "<option value=''>Please Select City</option>";
            foreach ($citylist as $q) {
                $html = $html . "<option value='$q->city'>$q->city</option>";
            }
        }
        echo '</select>';

        echo $html;
    }

    /*
     *   Remove Child from lead
     */

    function remove_child($child_id) {
        $res = delete_data('crm_lead_member_child', ['child_id' => $child_id]);
        echo $res;
    }

    /*
     * Convent lead into member
     */

    function lead_to_member() {
        $email = $this->input->post('email');
        $leadID = $this->input->post('leadID');
        if ($email == "") {
            exit('Email Cant Be NULL || H4r3eN');
        }
        if ($leadID == "") {
            exit('Lead ID Cant Be NULL || H4r3eN');
        }
        $user_password = randomPassword();
        $user_array = array(
            'email' => $this->input->post('cus_email'),
            'display_name' => $this->input->post('display_name'),
            'password' => md5($user_password),
            'roll_id' => '4',
        );
        $user_table = insert_update_data($ins = 1, $table_name = 'crm_user_tbl', $ins_data = $user_array);
        $user_id = $this->db->insert_id();
        $lead_memberMaster = array(
            'user_id' => $user_id,
            'customer_status' => 'memeber',
            'is_active' => 'Y'
        );
        $condition = array('customer_id' => $leadID);
        $lead_memberPrimary = array(
        );
        $master = insert_update_data($ins = 0, $tbl_name = 'crm_lead_member_master', $ins_data = $lead_memberMaster, $condition);
        $primary = insert_update_data($ins = 0, $tbl_name = 'crm_lead_member_primary', $ins_data = $lead_memberPrimary, $condition);
        if ($user_table && $lead_memberMaster && $primary) {

            $msg = "Hello " . $this->input->post('cus_first_name') . "<br><br>
                            You are successfully registered in amenitybenefits.<br><br>
                            Your Login details:<br><br>
                            <strong> Email Address : </strong>" . $this->input->post('cus_email') . "<br>
                            <strong> Password : </strong>" . $user_password . "<br><br>
                            Click Below URL for Login <br><br>
                            http://agencyvue.com/login/  <br><br>
                            Thank You,<br><br>
                            Amenitybenefits";
            $subject = "Thank You for your registration";
            $to_email = $this->input->post('cus_email');
            $title = 'Amenitybenefits registration';

            send_email($to_email, $subject, $msg, $title);
            $this->session->set_flashdata('success', 'Member Successfully Added!');

            $dob = $this->input->post('cus_dob');
            $cus_age = ((time() - strtotime($dob)) / (3600 * 24 * 365));
            $main_age = round($cus_age);
            $state_id = $this->input->post('cus_state');
            $zip = '';
            $weights = round($this->input->post('customer_weight'));
            $this->load->model('product');
            $data['userid'] = $user_id;
            $data['product_array'] = $this->product->findproduct($state_id, $main_age, $zip, $weights);
            $new_html = $this->load->view('admin/product/select_product', $data, true);
            echo json_encode(['prod_data' => $data['product_array'], 'new_html' => $new_html]);
        }
    }

    /*
     * Add Product POPUP
     */

    function lead_cart() {
        $lead_dob = $this->input->post('dob');
        $lead_dob = ((time() - strtotime($lead_dob)) / (3600 * 24 * 365));
        $age = round($lead_dob);
        $state_id = $this->input->post('state');
        if ($this->input->post('customer_weight') != "") {
            $weights = $this->input->post('customer_weight');
        } else {
            $weights = null;
        }

        $this->load->model('product');
        $lead_memberPrimary = array(
            'customer_email' => $this->input->post('email'),
            'customer_address' => $this->input->post('add'),
            'customer_address_details' => $this->input->post('oadd'),
            'customer_dob' => date('Y-m-d', strtotime($this->input->post('dob'))),
            'customer_state' => $this->input->post('state'),
            'customer_city' => $this->input->post('city'),
            'customer_zipcode' => $this->input->post('zipcode'),
            'customer_social_security_number' => $this->input->post('ssnumber'),
            'customer_weight' => $this->input->post('customer_weight'),
        );
        $condition = array('customer_id' => $this->input->post('leadID'));
        $master = insert_update_data($ins = 0, $tbl_name = 'crm_lead_member_primary', $ins_data = $lead_memberPrimary, $condition);
        $data['member_id'] = $this->input->post('leadID');
        $data['product_array'] = $this->product->findproduct($state_id, $age, $weights);

        $new_html = $this->load->view('agent/lead/add_product', $data, true);
        echo json_encode(['prod_data' => $data['product_array'], 'new_html' => $new_html]);
        die;
    }

    function addproduct() {
        $leadID = $this->input->post('member');
        $lead_product_id = $this->input->post('product');
        if ($leadID && $lead_product_id == "") {
            exit("Product ID And Member ID Cant Be Null || H4r3en");
        }
        $condition = array('customer_id' => $leadID);
        $leadStatus = get_data($tbl_name = "crm_lead_member_master", $single = 1, $where = $condition);
        if ($leadStatus['customer_status'] == "lead") {
            $user_password = randomPassword();
            $user_array = array(
                'email' => $this->input->post('email'),
                'display_name' => $this->input->post('displayname'),
                'password' => md5($user_password),
                'is_approved' => 'Y',
                'roll_id' => '4',
            );
            $user_table = insert_update_data($ins = 1, $table_name = 'crm_user_tbl', $ins_data = $user_array);
            $user_id = $this->db->insert_id();
            $lead_memberMaster = array(
                'user_id' => $user_id,
                'customer_status' => 'memeber',
                'is_active' => 'Y'
            );
            $condition = array('customer_id' => $leadID);
            $master = insert_update_data($ins = 0, $tbl_name = 'crm_lead_member_master', $ins_data = $lead_memberMaster, $condition);
            if ($user_table && $master) {
                $leadAddFeed = array(
                    'from_id' => $this->session->userdata['user_info']['user_id'],
                    'to_id' => $this->session->userdata['user_info']['user_id'],
                    'feed_type' => 'feed',
                    'feed_icon' => 'fa fa-handshake-o',
                    'feed_title' => 'Lead Convented Into Member',
                    'url' => base_url() . 'agent/members/edit_member/' . urlencode(base64_encode($leadID)),
                );
                insert_update_data(1, 'crm_feeds', $leadAddFeed);
                $msg = "Hello " . $this->input->post('displayname') . "<br><br>
                            You are successfully registered in Agency Vue.<br><br>
                            Your Login details:<br><br>
                            <strong> Email Address : </strong>" . $this->input->post('email') . "<br>
                            <strong> Password : </strong>" . $user_password . "<br><br>
                            Click Below URL for Login <br><br>
                            http://agencyvue.com/login/  <br><br>
                            Thank You,<br><br>
                            Agency Vue";
                $subject = "Thank You for your registration";
                $to_email = $this->input->post('email');
                $title = 'Agency Vue registration';
                send_email($to_email, $subject, $msg, $title);
//                $this->session->set_flashdata('success', 'Member Successfully Added!');
                $data = array('product_id' => $lead_product_id, 'member_id' => $user_id, 'added_by' => $this->session->userdata['user_info']['user_id']);
                insert_update_data($ins = 1, $tbl_name = ' crm_member_products', $data = $data);
                echo "Member Successfully Added!";
                $this->session->set_flashdata('success', 'Member Successfully Added!');
            }
        } else {
            $userID = get_global_userID($leadID);
            $condition = array('customer_id' => $userID);
            $data = array('product_id' => $lead_product_id, 'member_id' => $userID, 'added_by' => $this->session->userdata['user_info']['user_id']);
            insert_update_data($ins = 1, $tbl_name = ' crm_member_products', $data = $data);
            echo "Product Successfully Added in New Member!!";
            $this->session->set_flashdata('success', 'Member Successfully Added!');
        }
    }

    public function change_lead_status()
    {
        $leadID = $this->input->post("leadID");
        $result = $this->lead->change_lead_status_to_member($leadID);
        if ($result == true)
        {
            $lead_info = $this->lead->get_infos($leadID, 'crm_lead_member_primary', 'customer_id');
            $userDetail['email'] = $lead_info[0]['customer_email'];
            $userDetail['display_name'] = $lead_info[0]['customer_first_name'] .' '. $lead_info[0]['customer_last_name'];
            $password = randomPassword();
            $userDetail['password'] = md5($password);
            $userDetail['roll_id'] = '4';
            $result = $this->lead->add_new_member($userDetail);
            if ($result != '')
            {
                $response = "User Added Successfully";
            }
        }
        else
        {
            $response = "Already updated as member";
        }
        //   $leadID = base64_decode(urldecode($leadID));
        return $this->output
                     ->set_content_type('application/json')
                     ->set_output(json_encode($response));

    }

}
