<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Members extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('member');
    }

    public function index() {
        $this->load->model('lead');
        $data['title'] = 'Member Management || Admin';
        $data['brokers'] = $this->lead->all_broker_list();
        $this->template->load('admin_header', 'admin/members/index', $data);
    }

    public function membersJson() {

        $agent_id = "";
        if (isset($_REQUEST['agent_id'])) {
            $agent_id = $_REQUEST['agent_id'];
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

            $sColumns = array("customer_first_name", "customer_email", "crm_user_tbl.display_name", "customer_created_date");

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

        $rResult = $this->member->get_members_admin($sLimit, $sWhere, $sOrder, $agent_id);
        $iTotal_f = count($rResult);
        $iTotal = $this->member->get_member_count_admin($sWhere, $agent_id);

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
                    } else {
                        $row[] = isset($aRow[$aColumns[$i]]) ? $aRow[$aColumns[$i]] : '';
                    }
                }


                if ($aRow['is_active'] == "Y") {
                    $row[] .= '<a class="btn btn-info btn-xs table-action-btn admin-action-icon-in-data-table" href="' . base_url() . 'admin/members/view_profile?customer_id=' . urlencode(base64_encode($aRow["customer_id"])) . '"title="View Member Profile"><i class="glyphicon glyphicon-eye-open" title="View Profile"></i></a>'
                            . '<a href="' . base_url() . 'admin/members/edit_member/' . urlencode(base64_encode($aRow["customer_id"])) . '" class="btn btn-default btn-xs table-action-btn admin-action-icon-in-data-table"><i class="fa fa-pencil" title="Edit Member"></i></a>'
                            . '<button class="danger-alert btn btn-danger btn-xs table-action-btn del_lead admin-action-icon-in-data-table remove-span" data-custom-value="' . $aRow["customer_id"] . '"><i class="glyphicon glyphicon-trash" title="Remove Member"></i></button>'
                            . '<button class="danger-alert btn btn-primary btn-xs table-action-btn lead_det admin-action-icon-in-data-table info-span" data-custom-value="' . $aRow["customer_id"] . '"><i class="fa fa-list-ul" title="View Log"></i></button>'
                            . '<span class="danger-alert btn btn-danger btn-xs table-action-btn inactive-member admin-action-icon-in-data-table remove-span" data-custom-value="' . $aRow["customer_id"] . '"><i class="glyphicon glyphicon-remove" title="In-Active Member"></i></span>';
                } else {
                    $row[] .= '<a class="btn btn-info btn-xs table-action-btn admin-action-icon-in-data-table" href="' . base_url() . 'admin/members/view_profile?customer_id=' . urlencode(base64_encode($aRow["customer_id"])) . '"title="View Member Profile"><i class="glyphicon glyphicon-eye-open" title="View Profile"></i></a>'
                            . '<a href="' . base_url() . 'admin/members/edit_member/' . urlencode(base64_encode($aRow["customer_id"])) . '" class="btn btn-default btn-xs table-action-btn admin-action-icon-in-data-table"><i class="fa fa-pencil" title="Edit Member"></i></a>'
                            . '<button class="danger-alert btn btn-danger btn-xs table-action-btn del_lead admin-action-icon-in-data-table remove-span" data-custom-value="' . $aRow["customer_id"] . '"><i class="glyphicon glyphicon-trash" title="Remove Member"></i></button>'
                            . '<button class="danger-alert btn btn-primary btn-xs table-action-btn lead_det admin-action-icon-in-data-table info-span" data-custom-value="' . $aRow["customer_id"] . '"><i class="fa fa-list-ul" title="View Log"></i></button>'
                            . '<span class="danger-alert btn btn-success btn-xs table-action-btn active-member admin-action-icon-in-data-table remove-span" data-custom-value="' . $aRow["customer_id"] . '"><i class="glyphicon glyphicon-ok " title="Active Member"></i></span>';
                }
                $output['aaData'][] = $row;
            }
        }

        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    public function add_member() {

        $data['title'] = 'Add Member';
        $data['state'] = get_data($tbl_name = 'crm_states', $single = 0);
        $new_block['member_child'] = array();
        $new_block['customer_id'] = '';
        $new_block['state'] = get_data($tbl_name = 'crm_states', $single = 0);
        $new_block['add_child_block_arr'] = array();
        $data['add_child_block_html'] = $this->load->view('admin/members/get_child_view', $new_block, true);
        $data['state'] = get_data($tbl_name = 'crm_states', $single = 0);
        $this->template->load('admin_header', 'admin/members/add_member', $data);
    }

    /**
     * @uses check email address is already domain or not.
     * @author MGA
     */
    public function chk_domain() {
        $domain_name = $this->input->post('domain');
        $con = array('domain_name' => $domain_name, 'is_active' => 'Y');
        $this->db->select('domain_id');
        $this->db->where($con);
        $query = $this->db->get('crm_domain_master');
        if ($query->num_rows() > 0) {
            echo '<p class="error-msg email-custom" style="color: #C44B4D;margin-top: 10px;"><i>Domain is already used by another, please try other domain.</i></p>';
        } else {
            echo '<i>Domain is valid</i>';
        }
        die;
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
        echo $this->load->view('agent/member/member_info', $data, true);
        die;
    }

    function view_profile() {

        $data['title'] = 'Members Profile';

        $customer_id = base64_decode(urldecode($_REQUEST['customer_id']));

        $data['customer_id'] = $customer_id;
        $data['member_info'] = $this->member->get_member_profile($customer_id);

        $this->template->load('admin_header', 'admin/members/view_member', $data);
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
                            http://amenitybenefits.agencyvue.com/crm/  <br><br>
                            Thank You,<br><br>
                            Amenitybenefits";

                $subject = "Thank You for your registration";
                $to_email = $this->input->post('cus_email');
                $title = 'Amenitybenefits registration';
                send_email($to_email, $subject, $msg, $title);

                $this->session->set_flashdata('success', 'Member Successfully Added!');


                $select_product_con = array('crm_member_product_config.member_id' => $user, 'crm_member_product_config.is_active' => 'Y');
                $this->db->select('*');
                $this->db->from('crm_member_product_config');
                $this->db->where($select_product_con);
                $this->db->join('crm_products', 'crm_member_product_config.product_id = crm_products.global_product_id');
                $s_product = $this->db->get();
                $data['sel_product'] = $s_product->result_array();
                $data['res_sel_column'] = array_column($data['sel_product'], 'global_product_id');
                //$data['domain_name'] = get_subdomain_id($uid);

                $dob = date('m/d/Y', strtotime($data['lead_info']['customer_dob']));
                $cus_age = ((time() - strtotime($dob)) / (3600 * 24 * 365));
                $main_age = round($cus_age);
                $state_id = $data['lead_info']['customer_state'];
                $zip = '';
                $weights = round($data['lead_info']['customer_weight']);
                $this->load->model('product');
                $data['userid'] = get_global_userID($uid);
                $data['product_array'] = $this->product->findproduct($state_id, $main_age, $zip, $weights);

                echo json_encode(['prod_data' => $data['product_array'], 'new_html' => $new_html]);
            }
        }
    }

    /**
     * Function for edit member
     */
    public function save_edit_member() {

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
            'customer_weight' => $this->input->post('customer_weight'),
            'customer_social_security_number' => $this->input->post('cus_security_number'),
        );

        $condition_crm_lead_member_primary = array('customer_id' => $customer_id);
        insert_update_data($ins = 0, $table_name = 'crm_lead_member_primary', $ins_data = $data_crm_lead_member_primary, $where = $condition_crm_lead_member_primary);
        $lead_info = $this->member->get_infos($customer_id, 'crm_lead_member_spouse', 'customer_id');
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
                $this->member->master_insert('crm_lead_member_spouse', $data_crm_lead_member_spouse);
            } else {
                $condition_crm_lead_member_spouse = array('customer_id' => $customer_id);
                $this->member->master_update('crm_lead_member_spouse', $data_crm_lead_member_spouse, $condition_crm_lead_member_spouse);
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

        echo $this->session->set_flashdata('success', 'Member Successfully Updated!');
    }

    /**
     * @uses newCity is used for get city in dropdawn 
     * @author MGA
     */
    public function newCity() {

        $ust = $this->input->post('ustid');
        $name = $this->input->post('name');
        $id = $this->input->post('id');

        $con_array = array('state_code' => $ust);
        $this->db->where($con_array);
        $query = $this->db->get('crm_cities');
        $citylist = $query->result();

        if ($this->input->post('city') != "")
            $selected_city = $this->input->post('city');
        else
            $selected_city = '';

        $html = "<select class='form-control required' id='$id' name='$name'>";
        $html = "<option value=''>Please Select City</option>";

        foreach ($citylist as $city):

            if ($selected_city != '')
                if ($selected_city == $city->city)
                    $selected = "selected";
                else
                    $selected = "";

            $html = $html . "<option value='$city->city' $selected >$city->city</option>";

        endforeach;

        echo $html;
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
     * @uses Get all leads data
     * @author MGA
     */
    public function edit_member($id = null) {

        $data['title'] = 'Edit Member';
        $uid = base64_decode(urldecode($id));
        $uid1 = get_global_userID($uid);
        $lead_info = $this->member->get_infos($uid, 'crm_lead_member_primary', 'customer_id');
        $data['lead_info'] = $lead_info[0];
        $lead_member_spouse_info = $this->member->get_infos($uid, 'crm_lead_member_spouse', 'customer_id');
        $data['lead_member_spouse_info'] = isset($lead_member_spouse_info[0]) ? $lead_member_spouse_info[0] : array();
        $data['customer_id'] = $uid;
        $new_block['member_child'] = array();
        $new_block['customer_id'] = $uid;
        $new_block['state'] = get_data($tbl_name = 'crm_states', $single = 0);
        $child_arr = $this->member->get_infos($uid, 'crm_lead_member_child', 'customer_id', array('child_id', 'ASC'));

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

        $select_product_con = array('crm_member_product_config.member_id' => $uid, 'crm_member_product_config.is_active' => 'Y');

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
        

        $this->template->load('admin_header', 'admin/members/edit_member', $data);
    }

    /**
     * @uses check email address is already used or not.
     * @author MGA
     */
    public function chk_email() {
        $email = $this->input->post('email');
        $con = array('email' => $email, 'is_deleted' => 'N');
        $this->db->select('user_id');
        $this->db->where($con);
        $query = $this->db->get('crm_user_tbl');
        if ($query->num_rows() > 0) {
            echo '<p class="error-msg email-custom" style="color: #C44B4D;margin-top: 10px;"><i>Email address is already used by another, please try other email address.</i></p>';
        } else {
            echo '<i>Email address is valid</i>';
        }

        die;
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

}
