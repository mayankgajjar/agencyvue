<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Controller For MANAGANING BROKERS. || ADMIN SIDE
 * @author HAD
 * @admin access only
 */

class Brokers extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('broker');
    }

    function index() {
//        $count_row = $this->countTotalrow();
//        $data['count'] = $count_row;
        $data['title'] = 'Brokers Dashbord || Admin';
        $sLimit = array("start" => "5", "end" => "0");
        $sOrder = array("field" => 'user_id', "order" => 'DESC');
        $sOrder_u = array("field" => 'created_date', "order" => 'DESC');
        $sWhere = "";
        $data['approvedBroker'] = $this->broker->get_approveuser_count();
        $data['unapprovedBroker'] = $this->broker->get_unapproveuser_count();
        $data['approvedUser'] = $this->broker->get_all_approved_brokers($sLimit, $sWhere, $sOrder);
        $data['unapprovedUser'] = $this->broker->get_unaproved_brokers($sLimit, $sWhere, $sOrder_u);
        $this->template->load('admin_header', 'admin/brokers/dashboard', $data);
    }

    public function add_broker() {
        $data['title'] = 'Add broker';
        $data['state'] = get_data($tbl_name = 'crm_states', $single = 0);

        if ($this->input->post()) {

            $this->form_validation->set_rules('first_name', 'First Name', 'required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'required');
            $this->form_validation->set_rules('email_address', 'Email Address', 'required|valid_email');
            $this->form_validation->set_rules('phone_number', 'Contact Number', 'required');
            $this->form_validation->set_rules('dob', 'Birth Date', 'required');
            $this->form_validation->set_rules('address', 'Address', 'required');
            $this->form_validation->set_rules('sel_city', 'City', 'required');
            $this->form_validation->set_rules('sel_state', 'State', 'required');
            $this->form_validation->set_rules('zipcode', 'Zipcode', 'required');
            $this->form_validation->set_rules('domain_name', 'Domain Name', 'required');
            $this->form_validation->set_rules('legal_bussiness_name', 'Bussiness Name', 'required');
            $this->form_validation->set_rules('business_email_address', 'Business Email Address', 'required|valid_email');
            $this->form_validation->set_rules('business_address', 'Business Address', 'required');
            $this->form_validation->set_rules('business_city', 'Business City', 'required');
            $this->form_validation->set_rules('business_state', 'Business State', 'required');
            if ($this->input->post('commision_payto') == 'my_self') {
                $this->form_validation->set_rules('social_security_number', 'Social Security Number Zip Code', 'required');
            } else {
                $this->form_validation->set_rules('federal_tax_id', 'Federal Tax Id', 'required');
            }
            $this->form_validation->set_rules('business_zip', 'Business Zip Code', 'required');
            if ($this->input->post('direct_deposit')) {
                $this->form_validation->set_rules('bank_name', 'Bank Name', 'required');
                $this->form_validation->set_rules('rounting_number', 'Rounting Number', 'required');
                $this->form_validation->set_rules('ac_name', 'Account Number', 'required');
            }
            $this->form_validation->set_rules('acc_name', 'Account Name', 'required');
            $this->form_validation->set_rules('commision_address', 'Commision Address', 'required');
            $this->form_validation->set_rules('commision_city', 'Commision City', 'required');
            $this->form_validation->set_rules('commision_state', 'Commision State', 'required');
            $this->form_validation->set_rules('commision_zipcode', 'Commision Zipcode', 'required');

            $this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|matches[cpassword]');
            $this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required');
            $this->form_validation->set_rules('t_and_c', 'Please check terms and conditions checkbox', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->form_validation->set_error_delimiters();
            } else {

                if (!empty($_FILES['img']['name'])) {

                    $imagename = time() . $_FILES['img']['name'];

                    $config['upload_path'] = 'assets/crm_image/broker/';
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['file_name'] = $imagename;
                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('img')) {
                        $upload_error['error'] = 'Please upload valid check file';
                        $this->template->load('admin_header', 'admin/Brokers/add_broker', $upload_error);
                        return FALSE;
                    } else {
                        $data = $this->upload->data();
                        $picture = $data['file_name'];
                    }
                } else {
                    $picture = '';
                }

                $user_tbl_data = array('email' => $this->input->post('user_email'),
                    'password' => md5($this->input->post('password')),
                    'roll_id' => ('2'),
                    'display_name' => $this->input->post('first_name') . ' ' . $this->input->post('last_name'),
                    'is_approved' => 'Y',
                );
                $user_tbl = insert_update_data($ins = 1, $table_name = 'crm_user_tbl', $ins_data = $user_tbl_data);
                $user_id = $this->db->insert_id();

                $data_crm_domain_master = array('user_id' => $user_id, 'domain_name' => $this->input->post('domain_name'));
                $domain = insert_update_data($ins = 1, $table_name = 'crm_domain_master', $ins_data = $data_crm_domain_master);

                $dob1 = $this->input->post('dob');
                $dob = date("Y-m-d", strtotime($dob1));

                $broker_personal_data = array('user_id' => $user_id,
                    'parent_id' => $this->session->userdata['user_info']['user_id'],
                    'first_name' => $this->input->post('first_name'),
                    'middle_name' => $this->input->post('middle_name'),
                    'last_name' => $this->input->post('last_name'),
                    'personal_email_address' => $this->input->post('email_address'),
                    'personal_phone_number' => $this->input->post('phone_number'),
                    'dob' => $dob, 'personal_address' => $this->input->post('address'),
                    'personal_address_addtional' => $this->input->post('address_addtional'),
                    'personal_city' => $this->input->post('sel_city'),
                    'personal_state' => $this->input->post('sel_state'),
                    'personal_zipcode' => $this->input->post('zipcode'));

                $broker_personal = insert_update_data($ins = 1, $table_name = 'crm_broker_personal', $ins_data = $broker_personal_data);

                $broker_business_data = array('user_id' => $user_id,
                    'legal_bussiness_name' => $this->input->post('legal_bussiness_name'),
                    'business_email_address' => $this->input->post('business_email_address'),
                    'custom_service_name' => $this->input->post('custom_service_name'),
                    'business_fax_number' => $this->input->post('fax_number'),
                    'business_address' => $this->input->post('business_address'),
                    'business_add_addtional' => $this->input->post('business_address_addtional'),
                    'business_city' => $this->input->post('business_city'),
                    'business_state' => $this->input->post('business_state'), 'business_zip_code' => $this->input->post('business_zip'));

                $broker_business = insert_update_data($ins = 1, $table_name = 'crm_broker_business', $ins_data = $broker_business_data);

                $broker_commision_data = array('user_id' => $user_id,
                    'commision_payto' => $this->input->post('commision_payto'),
                    'social_security_number' => $this->input->post('social_security_number'),
                    'federal_tax_id' => $this->input->post('federal_tax_id'),
                    'commsion_receive' => $this->input->post('commsion_receive'),
                    'commision_name_on_account' => $this->input->post('acc_name'),
                    'commision_bank_name' => $this->input->post('bank_name'),
                    'commision_address' => $this->input->post('commision_address'),
                    'commision_city' => $this->input->post('commision_city'),
                    'commision_state' => $this->input->post('commision_state'),
                    'commision_add_addtional' => $this->input->post('commision_add_details'),
                    'commision_zipcode' => $this->input->post('commision_zipcode'),
                    'account_options' => $this->input->post('select_account'),
                    'rounting_number' => $this->input->post('rounting_number'),
                    'account_number' => $this->input->post('ac_name'),
                    'upload_void_check' => $picture);

                $broker_commision = insert_update_data($ins = 1, $table_name = 'crm_broker_commision', $ins_data = $broker_commision_data);
                $log = array('action_by' => $this->session->userdata['user_info']['user_id'], 'user_id' => $user_id, 'action' => 'created');
                $member_log = insert_update_data($ins = 1, $table_name = 'crm_broker_log', $ins_data = $log);

                if ($user_tbl && $broker_personal && $broker_business && $broker_commision) {

                    $msg = "Hello " . $this->input->post('first_name') . "<br><br>
                            You are successfully registered in amenitybenefits.<br><br>
                            Your Login details:<br><br>
                            <strong> Email Address : </strong>" . $this->input->post('user_email') . "<br>
                            <strong> Password : </strong>" . $this->input->post('password') . "<br><br>
                            Click Below URL for Login <br><br>
                            http://agencyvue.com/login/  <br><br>
                            Thank You,<br><br>
                            Amenitybenefits";
                    $subject = "Thank You for your registration";
                    $to_email = $this->input->post('user_email');
                    $title = 'Amenitybenefits registration';

                    $mail = send_email($to_email, $subject, $msg, $title);
                    if ($mail) {
                        $this->session->set_flashdata('success', 'Agent Successfully Created');
                    } else {
                        $this->session->set_flashdata('error', 'Agent is not Created');
                    }
                }
                $this->session->set_flashdata('success', 'Agent Successfully Created');
                redirect(base_url() . 'admin/brokers/manageBrokers');
            }
        }

        $this->template->load('admin_header', 'admin/brokers/add_broker', $data);
    }

    /**
     * @uses show_broker_info is used for show broker data and active
     * @author RRA
     */
    public function show_broker_info() {
        $emp_id = base64_decode(urldecode($this->input->post('empid')));
        $this->db->where('user_id', $emp_id);
        $query = $this->db->get('crm_broker_personal');
        $data['result'] = $query->row();
        $table = 'crm_broker_log';
        $options = array(
            'JOIN' => array(
                array(
                    'table' => 'crm_user_tbl',
                    'condition' => 'crm_user_tbl.user_id = crm_broker_log.action_by',
                    'type' => 'FULL'
                ),
            ),
            'conditions' => array(
                "crm_broker_log.user_id" => $emp_id,
            ),
            'ORDER_BY' => array(
                "field" => 'crm_broker_log.log_datetime',
                "order" => 'DESC'
            )
        );

        $data['lead_log'] = get_relation($table, $options);
        echo $this->load->view('admin/brokers/info_broker', $data, true);
    }

//    public function countTotalrow(){
//        $data = array();
//            $data['count'] = $this->Vendors->get_broker_count();
//            return $data['count'];
//    }
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

    function agentbrokesJson() {

        $aColumns = array("user_id", "broker_name", "email", "created_date");

        /* Pagination */

        $sLimit = array();
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $sLimit = array("start" => $_GET['iDisplayLength'], "end" => $_GET['iDisplayStart']);
        }

        /* Search */

        $sWhere = "";
        $sColumns = array("first_name", "last_name", "u.email", "u.created_date");
        if ($_GET['sSearch'] != "") {
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
            $sOrder = array("field" => $aColumns[2],
                "order" => 'DESC');
        }

        $rResult = $this->broker->get_all_approved_brokers($sLimit, $sWhere, $sOrder);
        $iTotal_f = count($rResult);
        $iTotal = $this->broker->get_approveuser_count($sWhere);

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
                        $row[] = "
                    <div class='checkbox checkbox-primary checkbox-single m-r-15'>
                        <input id='act_checkbox_" . $aRow['user_id'] . "' type='checkbox' value=" . urlencode(base64_encode($aRow["user_id"])) . " name='act_checkbox[]' class='ch_checkbox'>
                        <label for='act-checkbox'></label>
                    </div>

                    <img src=" . base_url() . "assets/images/users/avatar-5.jpg alt='contact-img' title='contact-img' class='img-circle thumb-sm' />";
                    } elseif ($aColumns[$i] == 'created_date') {
                        $row[] .= date('m-d-Y h:i:s a', strtotime($aRow['created_date']));
                    } else {
                        $row[] = isset($aRow[$aColumns[$i]]) ? $aRow[$aColumns[$i]] : '';
                    }
                }

                $row[] .= '<a class="btn btn-info btn-xs table-action-btn admin-action-icon-in-data-table" href="' . base_url() . 'admin/Brokers/brokerProfile?user_id=' . urlencode(base64_encode($aRow["user_id"])) . '"title="View Broker Profile"><i class="fa fa-eye"></i></a>'
                        . '<a class="btn btn-default btn-xs table-action-btn admin-action-icon-in-data-table" href="' . base_url() . 'admin/Brokers/brokerEdit?user_id=' . urlencode(base64_encode($aRow["user_id"])) . '" title = "Edit Broker Profile"><i class="fa fa-pencil"></i></a>'
                        . '<button class="danger-alert btn btn-danger btn-xs table-action-btn admin-action-icon-in-data-table del_broker" data-custom-value="' . urlencode(base64_encode($aRow['user_id'])) . '" title = "Remove Broker"><i class="glyphicon glyphicon-remove"></i></button>'
                        . '<button class="btn btn-primary btn-xs table-action-btn admin-action-icon-in-data-table view_log" data-custom-value="' . urlencode(base64_encode($aRow['user_id'])) . '" title = "View Log Of Agent"><i class="fa fa-list-ul"></i></button>'
                        . '<span class="btn btn-info btn-xs table-action-btn admin-action-icon-in-data-table change-password" data-custom-value="' . $aRow['user_id'] . '"><i class="glyphicon glyphicon-lock" title="Change Password"></i></span>';
                $output['aaData'][] = $row;
            }
        }

        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    function removebroker() {
        $user_id = base64_decode(urldecode($this->input->post('user_id')));
        $con = array('user_id' => $user_id);
        $data = array('is_deleted' => 'Y');
        $done = insert_update_data($ins = 0, $tbl_name = 'crm_user_tbl', $data = $data, $where = $con);

        if ($done) {
            $msg = "Broker Successfully Delete";
            echo $msg;
        }
    }

    /**
     * @uses this function is used for edit broker.
     * @author MGA
     */
    function brokerEdit() {
        $data['title'] = "Broker Edit || admin";
        $data['state'] = get_data($tbl_name = 'crm_states', $single = 0);
        $this->load->model('broker');
        $user_id = base64_decode(urldecode($_REQUEST['user_id']));
        $data['broker_details'] = $this->broker->get_broker_profile($user_id);
        $conn = array('state_code' => $data['broker_details'][0]['personal_state']);
        $this->db->where($conn);
        $query = $this->db->get('crm_cities');
        $data['city_pri'] = $query->result_array();
        $conn1 = array('state_code' => $data['broker_details'][0]['business_state']);
        $this->db->where($conn1);
        $query1 = $this->db->get('crm_cities');
        $data['city_bussiness'] = $query1->result_array();
        $conn2 = array('state_code' => $data['broker_details'][0]['commision_state']);
        $this->db->where($conn2);
        $query2 = $this->db->get('crm_cities');
        $data['city_commision'] = $query2->result_array();
        //$data['domain_name'] = get_subdomain_id($user_id);

        if ($this->input->post()) {


            if (!empty($_FILES['img']['name'])) {

                $img_path = $_SERVER['DOCUMENT_ROOT'] . '/crm/assets/crm_image/broker/' . $data['broker_details'][0]['upload_void_check'];

                unlink($img_path);

                $imagename = time() . $_FILES['img']['name'];

                $config['upload_path'] = 'assets/crm_image/broker/';
                $config['allowed_types'] = 'gif|jpg|png|pdf';
                $config['file_name'] = $imagename;
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('img')) {
                    $error = array('error' => $this->upload->display_errors());
                } else {
                    $data = $this->upload->data();
                    $picture = $data['file_name'];
                }
            } else {
                $picture = $data['broker_details'][0]['upload_void_check'];
            }

            $where = array('user_id' => $user_id);

            $ins_data_1 = array('first_name' => $this->input->post('first_name'),
                'middle_name' => $this->input->post('middle_name'),
                'last_name' => $this->input->post('last_name'),
                'personal_phone_number' => $this->input->post('phone_number'),
                'dob' => date('Y-m-d', strtotime($this->input->post('dob'))),
                'personal_address' => $this->input->post('address'),
                'personal_address_addtional' => $this->input->post('address_addtional'),
                'personal_zipcode' => $this->input->post('zipcode')
            );
            insert_update_data($ins = 0, $tbl_name = 'crm_broker_personal', $ins_data = $ins_data_1, $where = $where);
            $ins_data_1 = array('legal_bussiness_name' => $this->input->post('legal_bussiness_name'),
                'business_email_address' => $this->input->post('business_email_address'),
                'custom_service_name' => $this->input->post('custom_service_name'),
                'business_fax_number' => $this->input->post('fax_number'),
                'business_address' => $this->input->post('business_address'),
                'business_add_addtional' => $this->input->post('business_address_addtional'),
                'business_zip_code' => $this->input->post('business_zip')
            );
            insert_update_data($ins = 0, $tbl_name = 'crm_broker_business', $ins_data = $ins_data_1, $where = $where);

            $ins_data_2 = array('commision_payto' => $this->input->post('commision_payto'),
                'social_security_number' => $this->input->post('social_security_number'),
                'federal_tax_id' => $this->input->post('federal_tax_id'),
                'commsion_receive' => $this->input->post('commsion_receive'),
                'commision_name_on_account' => $this->input->post('acc_name'),
                'commision_bank_name' => $this->input->post('bank_name'),
                'commision_address' => $this->input->post('commision_address'),
                'commision_add_addtional' => $this->input->post('commision_add_details'),
                'commision_zipcode' => $this->input->post('commision_zipcode'),
                'account_options' => $this->input->post('select_account'),
                'rounting_number' => $this->input->post('rounting_number'),
                'account_number' => $this->input->post('ac_name'),
                'upload_void_check' => $picture,
            );
            insert_update_data($ins = 0, $tbl_name = 'crm_broker_commision', $ins_data = $ins_data_2, $where = $where);
            $log = array('action_by' => $this->session->userdata['user_info']['user_id'], 'user_id' => $user_id, 'action' => 'updated');
            insert_update_data($ins = 1, $table_name = 'crm_broker_log', $ins_data = $log);
            $this->session->set_flashdata('success', 'Broker Succesfully Updated');
            redirect(base_url() . 'admin/brokers/manageBrokers');
        }

        $this->template->load('admin_header', 'admin/brokers/edit_broker.php', $data);
    }

    function manageBrokers() {
        $data['title'] = 'Manage Brokers || Admin';
        $this->template->load('admin_header', 'admin/brokers/brokers_master', $data);
    }

    function unapprovedBrokers() {
        $data['title'] = 'Manage Unapproved Brokers || Admin';
        $this->template->load('admin_header', 'admin/dashboard/broker', $data);
    }

    function profile() {

        $this->load->model('broker');

        $user_id = base64_decode(urldecode($_REQUEST['user_id']));

        $data['broker_details'] = $this->broker->get_broker_profile($user_id);

        $this->load->view('admin/dashboard/broker_profile', $data);
    }

    function process() {

        if ($_REQUEST['user_id'] != "") {

            if ($_REQUEST['req_type'] != "") {
                $uid = base64_decode(urldecode($_REQUEST['user_id']));
                $userdata = get_data("crm_user_tbl", 1, "user_id = $uid");
                $data_broker_personal = get_data("crm_broker_personal", 1, "user_id = $uid");
                $user_email = $userdata["email"];
                $type = $data_broker_personal["parent_id"];
                if ($_REQUEST['req_type'] == 'approved') {
                    $this->broker->update("crm_user_tbl", array("user_id" => $uid), array("is_approved" => "Y"));
                    if ($type == "self registered") {
                        $this->broker->update("crm_broker_personal", array("user_id" => $uid), array("parent_id" => $this->session->userdata['user_info'] ['user_id']));
                    }
                    $subject = 'Agent account registration';
                    $msg = "Hi,<br><br>
					<strong> Your Broker account is approved. </strong><br><br>
                                        You can login in system with you Email ID and Password. <br><br>
                                        Here is login URL  http://agencyvue.com/login/  <br><br>
					Thanks,<br><br>
					Agency Vue.<br>";

                    if (send_broker_email_process($user_email, $subject, $msg)) {
                        $agentAddFeed = array(
                            'from_id' => $this->session->userdata['user_info']['user_id'],
                            'to_id' => $data_broker_personal['parent_id'],
                            'feed_type' => 'feed',
                            'feed_icon' => 'fa fa-check',
                            'feed_title' => 'Agent Profile ( ' . $data_broker_personal['first_name'] . ' ' . $data_broker_personal['last_name'] . ' ) Approved By Admin',
                            'is_admin' => 'Y'
                        );
                        insert_update_data(1, 'crm_feeds', $agentAddFeed);
                        echo 'approved';
                    } else {
                        echo "Please try again!";
                    }
                }

                if ($_REQUEST['req_type'] == 'disapproved') {
                    $this->broker->update("crm_user_tbl", array("user_id" => $uid), array("is_approved" => "N"));
                    $subject = 'Broker account registration';
                    $msg = "Hi,<br><br>

					<strong> Your Broker account is disapproved by our admin. </strong> <br><br>
                                        For more details,please feel free to contact us || http://amenitybenefits.agencyvue.com/contact-us-2/ <br>
					Thanks,<br>
					Amenitybenefits.";

                    if (send_broker_email_process($user_email, $subject, $msg)) {
                        $agentAddFeed = array(
                            'from_id' => $this->session->userdata['user_info']['user_id'],
                            'to_id' => $data_broker_personal['parent_id'],
                            'feed_type' => 'feed',
                            'feed_icon' => 'fa fa-times',
                            'feed_title' => 'Agent Profile ( ' . $data_broker_personal['first_name'] . ' ' . $data_broker_personal['last_name'] . ' ) disapproved By Admin',
                            'is_admin' => 'Y'
                        );
                        insert_update_data(1, 'crm_feeds', $agentAddFeed);
                        echo 'disapproved';
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
     *
     * @users unapproved broker's JSON
     * @author HAD
     */
    function indexJson() {
        $aColumns = array("first_name", "last_name", "email", "personal_city", "personal_state", "created_date", "parent_id");

        /* Paging */

        $sLimit = array();
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $sLimit = array("start" => $_GET['iDisplayLength'], "end" => $_GET['iDisplayStart']);
        }

        /* Search */
        $sWhere = "";
        $aColumnsSearch = array("first_name", "last_name", "n.email", "personal_city", "personal_state", "n.created_date", "parent_id");
        if ($_GET['sSearch'] != "") {
            $sWhere .= " (";
            for ($i = 0; $i < count($aColumnsSearch); $i++) {
                $sWhere .= $aColumnsSearch[$i] . " LIKE '%" . $_GET['sSearch'] . "%' OR ";
//                $sWhere[$aColumns[$i]] = $_GET['sSearch'];
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
            $sOrder = array("field" => $aColumns[5], "order" => 'DESC');
        }

        $rResult = $this->broker->get_unaproved_brokers($sLimit, $sWhere, $sOrder);
        $iTotal_f = count($rResult);
        $iTotal = $this->broker->get_unaproved_brokers_count($sWhere);

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
                        if ($aRow[$aColumns[$i]] == "self_registered") {
                            $row[] = "Self Registered";
                        } else {
                            $row[] = $aRow['display_name'];
                        }
                    } elseif ($aRow[$aColumns[$i]] == 'created_date') {
                        $row[] .= date('m-d-Y h:i:s a', strtotime($aRow['created_date']));
                    } elseif ($aColumns[$i] == 'personal_state') {
                        $row[] = get_state_name($aRow[$aColumns[$i]]);
                    } else {
                        $row[] = isset($aRow[$aColumns[$i]]) ? $aRow[$aColumns[$i]] : '';
                    }
                }

                $row[] .= '<a class="btn btn-info waves-effect waves-light btn-xs view_profile" href="' . base_url() . 'admin/brokers/profile?user_id=' . urlencode(base64_encode($aRow["user_id"])) . '" data-target="#tabs-modal" data-toggle="modal" title="View Profile"><i class="fa fa-eye"></i></a>&nbsp'
                        . '<button type="button" class="btn btn-success waves-effect waves-light btn-xs approved" value="' . urlencode(base64_encode($aRow['user_id'])) . '"><i class="fa fa-check" title="Approved"></i></button>&nbsp'
                        . '<button type="button" class="danger-alert btn btn-danger waves-effect waves-light btn-xs disapproved" value="' . urlencode(base64_encode($aRow['user_id'])) . '" title="Disapproved"><i class="fa fa-times"></i></button>';
                $output['aaData'][] = $row;
            }
        }

        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    /**
     *
     * @users all broker's JSON
     * @author HAD
     */
    function brokesJson() {

        $aColumns = array("first_name", "last_name", "email", "personal_city", "state_name", "created_date", "parent_name");
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
        $aColumns_alise = array("first_name", "last_name", "u.email", "state.state", "u.created_date", "u1.display_name");
        if ($_GET['sSearch'] != "") {
            $sWhere .= " (";
            for ($i = 0; $i < count($aColumns_alise); $i++) {
                $sWhere .= $aColumns_alise[$i] . " LIKE '%" . $_GET['sSearch'] . "%' OR ";
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
        $rResult = $this->broker->get_all_approved_brokers($sLimit, $sWhere, $sOrder);
        $iTotal_f = count($rResult);
        $iTotal = $this->broker->get_aproved_brokers_count($sWhere);
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
                    if ($aRow[$aColumns[$i]] == 'created_date') {
                        $row[] .= date('m-d-Y h:i:s a', strtotime($aRow['created_date']));
                    } else {
                        $row[] = isset($aRow[$aColumns[$i]]) ? $aRow[$aColumns[$i]] : '';
                    }
                }
                $row[] .= '<a class="btn btn-info btn-xs table-action-btn admin-action-icon-in-data-table" href="' . base_url() . 'admin/brokers/brokerProfile?user_id=' . urlencode(base64_encode($aRow["user_id"])) . '"title="View Broker Profile"><i class="fa fa-eye"></i></a>'
                        . '<a class="btn btn-default btn-xs table-action-btn admin-action-icon-in-data-table" href="' . base_url() . 'admin/brokers/brokerEdit?user_id=' . urlencode(base64_encode($aRow["user_id"])) . '" title = "Edit Broker Prfile"><i class="fa fa-pencil"></i></a>'
                        . '<button class="danger-alert btn btn-danger btn-xs table-action-btn admin-action-icon-in-data-table del_broker" value="' . urlencode(base64_encode($aRow['user_id'])) . '" title = "Remove Broker"><i class="fa fa-times"></i></button>';

                $output['aaData'][] = $row;
            }
        }
        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    public function brokerProfile() {
        $data['title'] = "Broker Profile || Admin";
        $user_id = urldecode(base64_decode($_REQUEST['user_id']));
        $this->load->model('common');
        $data['broker'] = $this->common->get_single_agent($user_id);
        $data['downMembers'] = $this->broker->getdownlineMembers($user_id);
        $data['downEmployers'] = $this->broker->getdownlineEmployers($user_id);
        $data['downAgents'] = $this->broker->getdownlineAgents($user_id);
        //$data['domain_name'] = get_subdomain_id($user_id);
        $this->template->load('admin_header', 'admin/brokers/broker_profile_view.php', $data);
    }

    public function change_password_by_admin() {
        $cus_id = $this->input->post('user_id');
        $mail_password = $this->input->post('password');
        $password = md5($mail_password);
        $data_personal = get_data("crm_user_tbl", 1, "user_id = $cus_id");
        $con = array('user_id' => $cus_id);
        $data = array('password' => $password);
        $done = insert_update_data($ins = 0, $tbl_name = 'crm_user_tbl', $data = $data, $where = $con);

        if ($done) {
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

            echo "Password Successfully Change";
        } else {
            echo "Error Into Password Change";
        }
        die;
    }

}
