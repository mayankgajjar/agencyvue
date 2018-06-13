<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Management of Members in Agency Profile
 *
 * @author dhareen
 */
class Members extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('member');
    }

    /**
     * Member Index Page
     */
    public function index() {
        $data['title'] = 'Members List';
        $data['agencts'] = get_agents($this->session->userdata['user_info']['user_id']);
        $this->template->load('agency_header', 'agency/members/index', $data);
    }

    /**
     * @uses Get all member data
     * @author HAD
     */
    public function membersJson() {

        $agent_id = "";
        if (isset($_REQUEST['agent_id'])) {
            $agent_id = $_REQUEST['agent_id'];
        }

        $agents = get_agents($this->session->userdata['user_info']['user_id']);
        $leadPerents = $this->session->userdata['user_info']['user_id'] . ',';
        foreach ($agents as $agents) {
            $leadPerents .= $agents['user_id'] . ',';
        }
        $aColumns = array("customer_id", "customer_first_name", "customer_email", "display_name", "customer_created_date");

        /* Pagination */

        $sLimit = array();

        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $sLimit = array("start" => $_GET['iDisplayLength'], "end" => $_GET['iDisplayStart']);
        }

        /* Search */

        $sWhere = "";

        if ($_GET['sSearch'] != "") {

            $sColumns = array("customer_first_name", "customer_email", "display_name", "customer_created_date");

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
        } else {
            $sOrder = array("field" => $aColumns[3],
                "order" => 'DESC');
        }

        if ($agent_id != "") {
            $rResult = $this->member->get_member_agency($sLimit, $sWhere, $sOrder, $agent_id);
            $iTotal_f = count($rResult);
            $iTotal = $this->member->get_member_agency_count($sWhere, $agent_id);
        } else {
            $rResult = $this->member->get_member_agency($sLimit, $sWhere, $sOrder, rtrim($leadPerents, ","));
            $iTotal_f = count($rResult);
            $iTotal = $this->member->get_member_agency_count($sWhere, rtrim($leadPerents, ","));
        }
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


                if ($aRow['is_active'] == "Y") {
                    $row[] .= '<a class="btn btn-info btn-xs table-action-btn admin-action-icon-in-data-table" href="' . base_url() . 'agency/members/view_profile?customer_id=' . urlencode(base64_encode($aRow["customer_id"])) . '"title="View Member Profile"><i class="glyphicon glyphicon-eye-open" title="View Profile"></i></a>'
                            . '<a href="' . base_url() . 'agency/members/edit_member/' . urlencode(base64_encode($aRow["customer_id"])) . '" class="btn btn-default btn-xs table-action-btn admin-action-icon-in-data-table"><i class="fa fa-pencil" title="Edit Member"></i></a>'
                            . '<button class="danger-alert btn btn-primary btn-xs table-action-btn lead_det admin-action-icon-in-data-table info-span" data-custom-value="' . $aRow["customer_id"] . '"><i class="fa fa-list-ul" title="View Log"></i></button>'
                            . '<button class="danger-alert btn btn-danger btn-xs table-action-btn del_lead admin-action-icon-in-data-table remove-span" data-custom-value="' . $aRow["customer_id"] . '"><i class="glyphicon glyphicon-trash" title="Remove Member"></i></button>'
                            . '<span class="danger-alert btn btn-danger btn-xs table-action-btn inactive-member admin-action-icon-in-data-table remove-span" data-custom-value="' . $aRow["customer_id"] . '"><i class="glyphicon glyphicon-remove" title="In-Active Member"></i></span>';
                } else {
                    $row[] .= '<a class="btn btn-info btn-xs table-action-btn admin-action-icon-in-data-table" href="' . base_url() . 'agency/members/view_profile?customer_id=' . urlencode(base64_encode($aRow["customer_id"])) . '"title="View Member Profile"><i class="glyphicon glyphicon-eye-open" title="View Profile"></i></a>'
                            . '<a href="' . base_url() . 'agency/members/edit_member/' . urlencode(base64_encode($aRow["customer_id"])) . '" class="btn btn-default btn-xs table-action-btn admin-action-icon-in-data-table"><i class="fa fa-pencil" title="Edit Member"></i></a>'
                            . '<button class="danger-alert btn btn-primary btn-xs table-action-btn lead_det admin-action-icon-in-data-table info-span" data-custom-value="' . $aRow["customer_id"] . '"><i class="fa fa-list-ul" title="View Log"></i></button>'
                            . '<button class="danger-alert btn btn-danger btn-xs table-action-btn del_lead admin-action-icon-in-data-table remove-span" data-custom-value="' . $aRow["customer_id"] . '"><i class="glyphicon glyphicon-trash" title="Remove Member"></i></button>'
                            . '<span class="danger-alert btn btn-success btn-xs table-action-btn active-member admin-action-icon-in-data-table remove-span" data-custom-value="' . $aRow["customer_id"] . '"><i class="glyphicon glyphicon-ok " title="Active Member"></i></span>';
                }
                $output['aaData'][] = $row;
            }
        }

        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    /**
     * @uses For left side info box
     * @author HAD
     */
    public function show_member_info() {
        $lead_id = $this->input->post('memberid');
        $this->db->where('customer_id', $lead_id);
        $query = $this->db->get('crm_lead_member_primary');
        $data['result'] = $query->row();
        $this->db->select('*');
        $this->db->from('crm_member_log');
        $this->db->where('crm_member_log.customer_id', $lead_id);
        $this->db->join('crm_user_tbl', 'crm_user_tbl.user_id = crm_member_log.action_by');
        $this->db->order_by("crm_member_log.log_datetime", "desc");
        $lead_log_date = $this->db->get();
        $data['lead_log'] = $lead_log_date->result();
        echo $this->load->view('agency/members/member_info', $data, true);
        die;
    }

    /**
     * Add New Member
     */
    public function add_member() {

        $data['title'] = 'Add Member';
        $data['state'] = get_data($tbl_name = 'crm_states', $single = 0);
        $new_block['member_child'] = array();
        $new_block['customer_id'] = '';
        $new_block['state'] = get_data($tbl_name = 'crm_states', $single = 0);
        $new_block['add_child_block_arr'] = array();
        $data['add_child_block_html'] = $this->load->view('admin/members/get_child_view', $new_block, true);
        $data['state'] = get_data($tbl_name = 'crm_states', $single = 0);
        $this->template->load('agency_header', 'agency/members/add_member', $data);
    }

    /**
     * Function for save member
     */
    public function save_member() {
        $email = $this->input->post('cus_email');
        $this->db->select('user_id');
        $this->db->where('email', $email);
        $query = $this->db->get('crm_user_tbl');
        if ($query->num_rows() > 0) {
            echo 'Email address is already used by another, please try other email address.';
        } else {

            $user_password = randomPassword();

            $user_array = array(
                'email' => $this->input->post('cus_email'),
                'display_name' => $this->input->post('cus_first_name') . ' ' . $this->input->post('cus_last_name'),
                'password' => md5($user_password),
                'roll_id' => '4',
            );

            $user_table = insert_update_data($ins = 1, $table_name = 'crm_user_tbl', $ins_data = $user_array);
            $user_id = $this->db->insert_id();

            $master_array = array('customer_status' => 'memeber', 'broker_id' => $this->session->userdata['user_info'] ['user_id'],
                'user_id' => $user_id);

            $lead_member_master = insert_update_data($ins = 1, $table_name = 'crm_lead_member_master', $ins_data = $master_array);
            $customer_id = $this->db->insert_id();

            $data_crm_lead_member_primary = array(
                'customer_id' => $customer_id,
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
                'customer_weight' => $this->input->post('customer_weight'),
                'customer_social_security_number' => $this->input->post('cus_security_number')
            );

            $primary = insert_update_data($ins = 1, $table_name = 'crm_lead_member_primary', $ins_data = $data_crm_lead_member_primary);

            if ($this->input->post('spouse_first_name') != '') {
                $data_crm_lead_member_spouse = array(
                    'customer_id' => $customer_id,
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

                $data_crm_lead_member_spouse['customer_id'] = $customer_id;
                $this->member->master_insert('crm_lead_member_spouse', $data_crm_lead_member_spouse);
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
                    }
                    if ($value['status'] == 'old') {
                        $condition_crm_lead_member_child = array('child_id' => $value['child_id']);
                        insert_update_data($ins = 0, $table_name = 'crm_lead_member_child', $ins_data = $child_array, $where = $condition_crm_lead_member_child);
                    }
                }
            }

            $log = array('action_by' => $this->session->userdata['user_info']['user_id'], 'customer_id' => $customer_id, 'action' => 'created');
            $member_log = insert_update_data($ins = 1, $table_name = 'crm_member_log', $ins_data = $log);

            if ($lead_member_master && $primary) {

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
                $data['userid'] = $customer_id;
                $data['product_array'] = $this->product->findproduct($state_id, $main_age, $zip, $weights);
                $new_html = $this->load->view('admin/product/select_product', $data, true);
                echo json_encode(['prod_data' => $data['product_array'], 'new_html' => $new_html]);
            }
        }
    }

    /*
     * View Member Prodile
     */

    function view_profile() {

        $data['title'] = 'Members Profile';

        $customer_id = base64_decode(urldecode($_REQUEST['customer_id']));

        $data['customer_id'] = $customer_id;
        $data['member_info'] = $this->member->get_member_profile($customer_id);

        $this->template->load('agency_header', 'agency/members/view_member', $data);
    }

    /**
     * Edit Members
     * @author MGA
     */
    public function edit_member($id = null) {
        $data['title'] = 'Edit Member';
        $uid = base64_decode(urldecode($id));
        $uid1 = get_global_userID($uid);

        $lead_info = $this->member->get_infos($uid, 'crm_lead_member_primary', 'customer_id');
        $data['lead_info'] = $lead_info[0];
        $lead_member_spouse_info = $this->member->get_infos($uid, 'crm_lead_member_spouse', 'customer_id');
        $data['lead_member_spouse_info'] = isset($lead_member_spouse_info) ? $lead_member_spouse_info[0] : array();
        $data['num_of_spouse'] = isset($lead_member_spouse_info) ? sizeof($lead_member_spouse_info) : '0';
        $data['customer_id'] = $uid;
        $new_block['member_child'] = array();
        $new_block['customer_id'] = $uid;
        $new_block['state'] = get_data($tbl_name = 'crm_states', $single = 0);
        $child_arr = $this->member->get_infos($uid, 'crm_lead_member_child', 'customer_id', array('child_id', 'ASC'));
        $child_arr_data = $this->member->get_infos($uid, 'crm_lead_member_child', 'customer_id');
        $data['lead_member_child_info'] = isset($child_arr_data) ? $child_arr_data : array();

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

        $data['add_child_block_html'] = $this->load->view('admin/members/get_child_view', $new_block, true);
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


        $select_product_con = array('crm_member_product_config.member_id' => $uid1, 'crm_member_product_config.is_active' => 'Y');
        $this->db->select('*');
        $this->db->from('crm_member_product_config');
        $this->db->where($select_product_con);
        $this->db->join('crm_products', 'crm_member_product_config.product_id = crm_products.global_product_id');
        $s_product = $this->db->get();
        $data['sel_product'] = $s_product->result_array();
        $data['res_sel_column'] = array_column($data['sel_product'], 'global_product_id');

        $dob = date('m/d/Y', strtotime($data['lead_info']['customer_dob']));
        $cus_age = ((time() - strtotime($dob)) / (3600 * 24 * 365));
        $main_age = round($cus_age);
        $state_id = $data['lead_info']['customer_state'];
        $zip = '';
        $weights = round($data['lead_info']['customer_weight']);
        $this->load->model('product');
        $data['userid'] = $uid1;
        $data['product_array'] = $this->product->findproduct($state_id, $main_age, $zip, $weights);
        $data['member_product_array'] = $this->product->fetch_product_data($uid1);
        $data['member_product_ids'] = array_column($data['member_product_array'], 'global_product_id');
        $data['billing_info'] = get_data('crm_member_payment_info', '1', ['member_id' => $uid]);


        if (($this->input->post('save'))) {

            $customer_id = $this->input->post('customer_id');
            $condition_crm_user_tbl = array('user_id' => $customer_id);

            $data_crm_user_tbl = array('display_name' => $this->input->post('cus_first_name') . " " . $this->input->post('cus_last_name'),);
            $user_table = insert_update_data($ins = 0, $table_name = 'crm_user_tbl', $ins_data = $data_crm_user_tbl, $where = $condition_crm_user_tbl);

            if (!empty($_FILES['verification_script']['name'])) {
                $imagename = 'verification_script' . time() . $_FILES['verification_script']['name'];
                $config['upload_path'] = 'assets/member_verification_script/';
                $config['allowed_types'] = 'mp3';
                $config['file_name'] = $imagename;
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('verification_script')) {
                    $data['verification_script_error'] = 'Please upload valid Verification Script || mp3';
                    $this->template->load('agent_header', 'members/edit_member/<?php echo $id; ?>', $data);
                    return FALSE;
                } else {
                    if (isset($lead_info[0]['customer_verification'])) {
                        $img_path = $_SERVER['DOCUMENT_ROOT'] . '/crm/assets/member_verification_script/' . $lead_info[0]['customer_verification'];
                        unlink($img_path);
                    }
                    $data = $this->upload->data();
                    $vari_script = $data['file_name'];
                }
            } else {
                $vari_script = $lead_info[0]['customer_verification'];
            }

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
                'customer_weight' => $this->input->post('customer_weight'),
                'customer_social_security_number' => $this->input->post('cus_security_number'),
                'customer_verification' => $vari_script,
            );


            $condition_crm_lead_member_primary = array('customer_id' => $customer_id);
            insert_update_data($ins = 0, $table_name = 'crm_lead_member_primary', $ins_data = $data_crm_lead_member_primary, $where = $condition_crm_lead_member_primary);
            $lead_info = $this->member->get_infos($customer_id, 'crm_lead_member_spouse', 'customer_id');

            if ($this->input->post('spouse_first_name') != "") {
                if (empty($lead_info)) {
                    $data_crm_lead_member_spouse = array(
                        'customer_id' => $customer_id,
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

                    insert_update_data($ins = 1, $table_name = 'crm_lead_member_spouse', $ins_data = $data_crm_lead_member_spouse);
                } else {

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

                    $condition_crm_lead_member_spouse = array('customer_id' => $customer_id);
                    insert_update_data($ins = 0, $table_name = 'crm_lead_member_spouse', $ins_data = $data_crm_lead_member_spouse, $where = $condition_crm_lead_member_spouse);
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
                    }
                    if ($value['status'] == 'old') {
                        $condition_crm_lead_member_child = array('child_id' => $value['child_id']);
                        insert_update_data($ins = 0, $table_name = 'crm_lead_member_child', $ins_data = $child_array, $where = $condition_crm_lead_member_child);
                    }
                }
            }


            $log = array('action_by' => $this->session->userdata['user_info']['user_id'], 'customer_id' => $customer_id, 'action' => 'Update');
            $member_log = insert_update_data($ins = 1, $table_name = 'crm_member_log', $ins_data = $log);
            $this->session->set_flashdata('success', 'Member Successfully Updated!');
            redirect(base_url() . 'agency/members/edit_member/' . $id);
        }

        $PC = array('member_id' => $uid1, 'is_status' => 'Y');
        $this->db->select('product_id');
        $this->db->from('crm_member_products');
        $this->db->where($PC);
        $buyProductID = $this->db->get();
        $data['buyProductID'] = $buyProductID->result_array();
        $data['memberProducts'] = array_column($data['buyProductID'], 'product_id');
        if (sizeof($data['memberProducts']) > 0) {
            $id_str = implode(',', $data['memberProducts']);
            $product_query = $this->db->query('SELECT * FROM `crm_product_state` as `states`
            JOIN `crm_products` as `products` ON `states`.`global_product_id` = `products`.`global_product_id`
            JOIN `crm_product_age_weight_height` as `weight` ON `weight`.`global_product_id` = `states`.`global_product_id`
            WHERE `weight`.`max_age` >= ' . $main_age . ' AND `weight`.`min_age` <= ' . $main_age . ' AND `states`.`state` = "' . $state_id . '" AND `weight`.`max_weight` >= ' . $weights . '
            AND `weight`.`min_weight` <= ' . $weights . ' AND products.global_product_id NOT IN(' . $id_str . ') AND `products`.`is_deleted` = "N" AND `products`.`product_status` = "active"');
            $data['product_array01'] = $product_query->result_array();
        } else {
            $data['product_array01'] = $data['product_array'];
        }
        $this->template->load('agency_header', 'agency/members/edit_member', $data);
    }

    public function inactivemember() {
        $cus_id = $this->input->post('user_id');
        $reson = $this->input->post('reason');
        $con = array('customer_id' => $cus_id);
        $data = array('is_active' => 'N');
        $done = insert_update_data($ins = 0, $tbl_name = 'crm_lead_member_master', $data = $data, $where = $con);

        if ($done) {
            //------------- For Maintin Log Change Member Status ----------
            $log_data = array('action' => 'INActive', 'customer_id' => $cus_id, 'action_by' => $this->session->userdata('user_info')['user_id']);
            $res = insert_update_data($ins = 1, $tbl_name = 'crm_member_log', $log_data = $log_data);

            //------------- For Store Member Inactive with reason ----------
            $inactive_data = array('member_id' => $cus_id, 'reason' => $reson, 'inactive_by' => $this->session->userdata('user_info')['user_id']);
            $res = insert_update_data($ins = 1, $tbl_name = 'crm_inactive_member', $inactive_data = $inactive_data);
            echo "Member Successfully Inactive";
        } else {
            echo "Error Into InActive Member";
        }
    }

    public function activemember() {
        $cus_id = $this->input->post('user_id');
        $con = array('customer_id' => $cus_id);
        $data = array('is_active' => 'Y');
        $done = insert_update_data($ins = 0, $tbl_name = 'crm_lead_member_master', $data = $data, $where = $con);

        if ($done) {
            //------------- For Maintin Log Change Member Status ----------
            $log_data = array('action' => 'Active', 'customer_id' => $cus_id, 'action_by' => $this->session->userdata('user_info')['user_id']);
            $res = insert_update_data($ins = 1, $tbl_name = 'crm_member_log', $log_data = $log_data);
            echo "Member Successfully Active";
        } else {
            echo "Error Into Active Member";
        }
    }

    public function removemember() {
        $cus_id = $this->input->post('user_id');
        $con = array('customer_id' => $cus_id);
        $data = array('is_delete' => 'Y');
        $done = insert_update_data($ins = 0, $tbl_name = 'crm_lead_member_master', $data = $data, $where = $con);

        if ($done) {
            echo "Member Successfully Delete";
        }
        die();
    }

    public function product_pop_box() {
        $data['select_product'] = $_REQUEST['product_arr'];
        echo $this->load->view('admin/product/select_product', $data, true);
        die;
    }

    public function addproduct() {
        $product_id = $this->input->post('product');
        $member_id = $this->input->post('member');
        $data = array('product_id' => $product_id, 'member_id' => $member_id);
        $done = insert_update_data($ins = 1, $tbl_name = 'crm_member_product_config', $data = $data);
        if ($done) {
            echo "Product Successfully Added";
        }
        die();
    }

    public function removeproduct() {
        $product_id = $this->input->post('product');
        $member_id = $this->input->post('member');

        $con = array('product_id' => $product_id, 'member_id' => $member_id);
        $data = array('is_active' => 'N');

        $done = insert_update_data($ins = 0, $tbl_name = 'crm_member_product_config', $data = $data, $where = $con);
        if ($done) {
            echo "Product Successfully Remove";
        }
        die();
    }

    public function addmemberproduct() {
        $product_id = $this->input->post('product');
        $member_id = $this->input->post('member');
        $data = array('product_id' => $product_id, 'member_id' => $member_id);
        $done = insert_update_data($ins = 1, $tbl_name = 'crm_member_products', $data = $data);
        if ($done) {
            echo "Product Successfully Added";
        }
        die();
    }

    public function removememberproduct() {
        $product_id = $this->input->post('product');
        $member_id = $this->input->post('member');

        $con = array('product_id' => $product_id, 'member_id' => $member_id);
        $data = array('is_active' => 'N');

        $done = insert_update_data($ins = 0, $tbl_name = 'crm_member_products', $data = $data, $where = $con);
        if ($done) {
            echo "Product Successfully Remove";
        }
        die();
    }

    /**
     * Charges Par Active Members
     */
    public function charges() {
        $activeMember = array();
        $data['title'] = "Charges Par Active Users";
        $agenyID = $this->session->userdata['user_info']['user_id'];
        $last_paymonth = get_data("crm_agency_member_charge", 1, array('agency_id' => $this->session->userdata['user_info']['user_id']));
        if ($last_paymonth['pay_month'] != "") {
            $data['last_paymonth'] = $last_paymonth['pay_month'];
        } else {
            $data['last_paymonth'] = "FALSE";
        }
        $agencyMembers = get_agency_members($agenyID);
        $data['agencyMembers'] = $activeMember = count($agencyMembers);
        $agencyAgents = get_agents($agenyID);
        if ($agencyAgents != "") {
            foreach ($agencyAgents as $key => $agent) {
                $totalMembers = count(get_agent_member($agent['user_id']));
                $agentMembers[$key] = array("parent_id" => $agent['user_id'], "total_members" => $totalMembers);
                $activeMember = $activeMember + $totalMembers;
            }
        }
        $data['agentMembers'] = $agentMembers;
        $data['activeMembersCount'] = $activeMember;
        if ($this->input->post('stripe')) {
            $this->form_validation->set_rules('card_number', 'Card Number', 'required');
            $this->form_validation->set_rules('exp_month', 'Expiration Month', 'required');
            $this->form_validation->set_rules('exp_year', 'Expiration Year', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->form_validation->set_error_delimiters();
            } else {
                $agency_id = $agenyID;
                $number = $this->input->post('card_number');
                $cvc = $this->input->post('card_cvc');
                $exp_month = $this->input->post('exp_month');
                $exp_year = $this->input->post('exp_year');
                $name = "VISA";
                // Total Payble USD || $1 per member charge || Convent Amount into CENTS
                $payable = ($activeMember * 1 ) * 100;
                $agency_name = get_display_name($agency_id);
                $payment_note = $agency_name . "'s Charged Of Active Members";
                $stripeJson = payable_stripe($payable, $number, $cvc, $exp_month, $exp_year, $name, $payment_note);
                $stripeArray = json_decode($stripeJson);
                if (isset($stripeArray->id)) {
                    if ($stripeArray->status == 'succeeded') {
                        $PaymentData = array("agency_id" => $agency_id, "charge_amount" => $activeMember, 'transaction_id' => $stripeArray->id, 'pay_month' => date('F'), 'pay_date' => date("Y-m-d H:i:s"));
                        $updatePayment = insert_update_data(1, "crm_agency_member_charge", $PaymentData);
                        if ($updatePayment) {
                            $flashMsg = "Your Payment Is Success";
                            $msg = "Hello " . $agency_name . "<br><br>
                            Your Payment is successfully received by our system as Active Members Charges.<br><br>
                            Total active members in your profile is<strong> " . $activeMember . " </strong> <br><br>
                            As per our policy, we may charge you <strong> $1 </strong> per active member <br><br>
                            Total Active Member (" . $activeMember . ") * 1 = $" . $activeMember . "<br> <br>
                            You can see your all active members details on this <a href='" . base_url() . "'agency/members/charges'>link</a><br>
                            <i>NOTE: Please do login before accesing this URL.</i>
                            <br> Thank You,<br><br>
                            AgencyVUE";
                            $subject = "Payment Received Of Active Members Charges || AgencyVUE";
                            $to_email = $this->session->userdata['user_info']['email'];
                            $title = 'Active Members Charges';
                            $invoice = send_email($to_email, $subject, $msg, $title);
                            if ($invoice) {
                                $flashMsg .= " And Payment details are sended on your Login Email ID";
                            }
                            $this->session->set_flashdata('success', $flashMsg);
                        } else {
                            $this->session->set_flashdata('error', "Updating Data In System Is Fail");
                            $this->session->set_flashdata('success', "Your Payment Is Success");
                        }
                        redirect("agency/members/charges");
                    }
                } elseif (isset($stripeArray->error)) {
                    $this->session->set_flashdata('error', $stripeArray->error->message);
                } else {
                    $this->session->set_flashdata('error', "Something Went To Wrong");
                }
                redirect("agency/members/charges");
            }
        }
        $this->template->load('agency_header', 'agency/members/charges', $data);
    }

    /**
     * @uses Charges Per Members To Agency Email Invoice
     * @author HAD
     */
    public function charges_cron() {
        $activeMember = array();

        $agenyID = $this->session->userdata['user_info']['user_id'];
        $agencyMembers = get_agency_members($agenyID);
        $data['agencyMembers'] = $activeMember = count($agencyMembers);
        $agencyAgents = get_agents($agenyID);
        if ($agencyAgents != "") {
            foreach ($agencyAgents as $key => $agent) {
                $totalMembers = count(get_agent_member($agent['user_id']));
                $agentMembers[$key] = array("parent_id" => $agent['user_id'], "total_members" => $totalMembers);
                $activeMember = $activeMember + $totalMembers;
            }
        }
        $data['agentMembers'] = $agentMembers;
        $data['activeMembersCount'] = $activeMember;
    }

}
