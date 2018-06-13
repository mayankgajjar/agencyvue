<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Leads extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('lead');
    }

    /**
     * @uses use as index method for the page.
     * @author HAD
     */
    public function index() {
        $data['title'] = 'Leads';
        $data['brokers'] = $this->lead->all_broker_list();
        $this->template->load('admin_header', 'admin/lead/index', $data);
    }

    /**
     * @uses Method for add lead
     * @author HAD
     */
    public function add_lead() {
        $member_data = array('customer_status' => 'lead', 'is_admin' => $this->session->userdata['user_info'] ['user_id']);
        $lead_member_master = insert_update_data($ins = 1, $table_name = 'crm_lead_member_master', $ins_data = $member_data);
        $customer_id = $this->db->insert_id();
        $log = array('action_by' => $this->session->userdata['user_info']['user_id'], 'customer_id' => $customer_id, 'action' => 'created');
        $lead_log = insert_update_data($ins = 1, $table_name = 'crm_lead_log', $ins_data = $log);
        $member_primary = array('customer_id' => $customer_id, 'customer_first_name' => $this->input->post('first'),
            'customer_last_name' => $this->input->post('last'), 'customer_email' => $this->input->post('email1'),
            'customer_phone_number' => $this->input->post('con'));
        $lead_member_primary = insert_update_data($ins = 1, $table_name = 'crm_lead_member_primary', $ins_data = $member_primary);
        if ($lead_member_master && $lead_member_primary && $lead_log) {
            $msg = "Lead Successfully Insert";
            echo $msg;
            //echo $this->session->set_flashdata('success', 'Password successfully updated!');
        }
        die;
    }

    /**
     * @uses to build JSon for Data-table
     * @author HAD
     */
    function indexJson() {

        $agent_id = "";

        if (isset($_REQUEST['agent_id'])) {
            $agent_id = $_REQUEST['agent_id'];
        }

        $aColumns = array("customer_id", "cname", "customer_email", "lead_add_by", "customer_created_date");

        /* Pagination */

        $sLimit = array();

        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $sLimit = array("start" => $_GET['iDisplayLength'], "end" => $_GET['iDisplayStart']);
        }

        /* Search */

        $sWhere = "";
        if ($_GET['sSearch'] != "") {
            $sColumns = array("cname", "customer_email", "lead_add_by", "customer_created_date");
            ;
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

        $rResult = $this->lead->get_leads_admin($sLimit, $sWhere, $sOrder, $agent_id);
        $iTotal_f = count($rResult);
        $iTotal = $this->lead->get_leads_count_admin($sWhere, $agent_id);
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

                        $row[] = "<div class='checkbox checkbox-primary checkbox-single m-r-15'>
                                <input id='act_checkbox_" . $aRow['customer_id'] . "' type='checkbox' value=" . urlencode(base64_encode($aRow["customer_id"])) . " name='act_checkbox[]' class='ch_checkbox'>
                                <label for='act-checkbox'></label>
                            </div>
                    <img src=" . base_url() . "assets/images/users/avatar-5.jpg alt='contact-img' title='contact-img' class='img-circle thumb-sm' />";
                    } elseif ($aColumns[$i] == 'customer_created_date') {
                        $row[] .= date('m-d-Y h:i:s a', strtotime($aRow['customer_created_date']));
                    } else {
                        $row[] = isset($aRow[$aColumns[$i]]) ? $aRow[$aColumns[$i]] : '';
                    }
                }

                $row[] .= '<a class="btn btn-info btn-xs table-action-btn admin-action-icon-in-data-table" href="' . base_url() . 'admin/leads/view_profile?customer_id=' . urlencode(base64_encode($aRow["customer_id"])) . '"title="View lead Profile"><i class="glyphicon glyphicon-eye-open" title="View Profile"></i></a>'
                        . '<a href="' . base_url() . 'admin/leads/edit_leads/' . urlencode(base64_encode($aRow["customer_id"])) . '" " class="btn btn-default btn-xs table-action-btn admin-action-icon-in-data-table"><i class="fa fa-pencil"></i></a>'
                        . '<span class="danger-alert btn btn-danger btn-xs table-action-btn del_lead admin-action-icon-in-data-table remove-span" data-custom-value="' . $aRow["customer_id"] . '"><i class="glyphicon glyphicon-remove"></i></span>'
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

        $this->template->load('admin_header', 'admin/lead/view_profile', $data);
    }

    /**
     * @uses For left side info box
     * @author HAD
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
                "customer_id" => $lead_id
            )
        );
        $data['lead_log'] = get_relation($table, $options);
        echo $this->load->view('admin/lead/lead_info', $data, true);
        die;
    }

    /**
     * @uses Get all leads data
     * @author HAD
     */
    public function edit_leads($id = null) {
        $data['title'] = 'Edit Lead';
        $uid = base64_decode(urldecode($id));
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

        $data['add_child_block_html'] = $this->load->view('admin/lead/get_child_view', $new_block, true);

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
        $this->template->load('admin_header', 'admin/lead/edit_lead', $data);
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
            'customer_email' => $this->input->post('cus_email'),
            'customer_phone_number' => $this->input->post('cus_contact'),
            'customer_dob' => date('Y-m-d', strtotime($this->input->post('cus_dob'))),
            'customer_address' => $this->input->post('cus_address'),
            'customer_address_details' => $this->input->post('cus_sub_address'),
            'customer_city' => $this->input->post('cus_city'),
            'customer_state' => $this->input->post('cus_state'),
            'customer_zipcode' => $this->input->post('cus_zip'),
            'customer_social_security_number' => $this->input->post('cus_security_number'),
            'customer_weight' => $this->input->post('customer_weight'),
            'lead_type' => $this->input->post('cus_lead_type'),
            'lead_category' => 'aged',
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

    /**
     * @uses removelead is used for remove or delete lead
     * @author MGA
     */
    public function removelead() {
        $cus_id = $this->input->post('user_id');
        $con = array('customer_id' => $cus_id);
        $data = array('is_delete' => 'Y');
        $done = insert_update_data($ins = 0, $tbl_name = 'crm_lead_member_master', $data = $data, $where = $con);

        if ($done) {
            $msg = "Lead Successfully Delete";
            echo $msg;
        }
        die();
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

        $new_html = $this->load->view('admin/lead/add_product', $data, true);
        echo json_encode(['prod_data' => $data['product_array'], 'new_html' => $new_html]);
        die;
    }

}
