<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employers extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('employer');
    }

    function index() {

        $data['title'] = 'Employer Dashbord || Admin';
        $sLimit = array("start" => "5", "end" => "0");
        $sOrder = array("field" => 'crm_user_tbl.user_id', "order" => 'DESC');
        $sOrder_u = array("field" => 'created_date', "order" => 'DESC');
        $sWhere = "";
          $data['approvedUser'] = $this->employer->get_all_approved_employer($sLimit, $sWhere, $sOrder,$agent_id="");
        //$data['approvedUser'] = $this->employer->get_all_approved_employer($sLimit, $sWhere, $sOrder);
//        pr_exit($data['approvedUser']);
        $data['unapprovedUser'] = $this->employer->get_unaproved_employer($sLimit, $sWhere, $sOrder_u);
        $this->template->load('admin_header', 'admin/employers/dashboard', $data);
    }

    public function add_employer() {
        $data['title'] = 'Add Employer';
        $data['state'] = get_data($tbl_name = 'crm_states', $single = 0);

        if ($this->input->post('save')) {
            $this->form_validation->set_rules('emp_name', 'Employer Name', 'required');
            $this->form_validation->set_rules('emp_email', 'Email Address', 'required|valid_email');
            $this->form_validation->set_rules('emp_ser_no', 'Customer Service Number', 'required');
            $this->form_validation->set_rules('emp_address', 'Address', 'required');
            $this->form_validation->set_rules('emp_zipcode', 'Zip Code', 'required');
            $this->form_validation->set_rules('domain_name', 'Domain Name', 'required');
            $this->form_validation->set_rules('daily_contact_firstname', 'Daily Contact Firstname', 'required');
            $this->form_validation->set_rules('daily_contact_lastname', 'Daily Contact Lastname', 'required');
            $this->form_validation->set_rules('daily_contact_title', 'Daily Contact Title', 'required');
            $this->form_validation->set_rules('daily_contact_email', 'Daily Contact Email', 'required');
            $this->form_validation->set_rules('daily_contact_contact_no', 'Daily Contact Number', 'required');

            $this->form_validation->set_rules('billing_contact_firstname', 'Billing Contact Firstname', 'required');
            $this->form_validation->set_rules('billing_contact_lastname', 'Billing Contact Lastname', 'required');
            $this->form_validation->set_rules('billing_contact_title', 'Billing Contact Title', 'required');
            $this->form_validation->set_rules('billing_contact_email', 'Billing Contact Email', 'required');
            $this->form_validation->set_rules('billing_contact_contact_no', 'Billing Contact Number', 'required');

            $this->form_validation->set_rules('technical_contact_firstname', 'Technical Contact Firstname', 'required');
            $this->form_validation->set_rules('technical_contact_lastname', 'Technical Contact Lastname', 'required');
            $this->form_validation->set_rules('technical_contact_title', 'Technical Contact Title', 'required');
            $this->form_validation->set_rules('technical_contact_email', 'Technical Contact Email', 'required');
            $this->form_validation->set_rules('technical_contact_contact_no', 'Technical Contact Number', 'required');

            $this->form_validation->set_rules('login_email', 'Login Email', 'trim|required|valid_email|callback_isEmailExist');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|matches[cpassword]');
            $this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $this->form_validation->set_error_delimiters();
            } else {

                $user_tbl_data = array(
                    'email' => $this->input->post('login_email'),
                    'password' => md5($this->input->post('login_email')),
                    'roll_id' => '3',
                    'is_approved' => 'Y',
                    'display_name' => $this->input->post('daily_contact_firstname') . $this->input->post('daily_contact_lastname'),
                );

                $user_tbl = insert_update_data($ins = 1, $table_name = 'crm_user_tbl', $ins_data = $user_tbl_data);
                $user_id = $this->db->insert_id();

                $data_crm_domain_master =  array('user_id' => $user_id, 'domain_name' => $this->input->post('domain_name'));
                $domain = insert_update_data($ins = 1, $table_name = 'crm_domain_master', $ins_data = $data_crm_domain_master);

                $employers_primary_data = array(
                    'user_id' => $user_id,
                    'broker_id' => $this->session->userdata['user_info'] ['user_id'],
                    'employer_name' => $this->input->post('emp_name'),
                    'employer_website' => $this->input->post('emp_website'),
                    'employer_email' => $this->input->post('emp_email'),
                    'employer_cus_service_number' => $this->input->post('emp_ser_no'),
                    'employer_fax' => $this->input->post('emp_fax_no'),
                    'employer_address' => $this->input->post('emp_address'),
                    'employer_address_details' => $this->input->post('emp_address_det'),
                    'employer_city' => $this->input->post('emp_city'),
                    'employer_state' => $this->input->post('emp_state'),
                    'employer_zipcode' => $this->input->post('emp_zipcode'),
                    'employer_fulfillment' => $this->input->post('fulfillment_type'),
                );
                $employers_primary = insert_update_data($ins = 1, $table_name = 'crm_employers_primary', $ins_data = $employers_primary_data);

                $daily_contact_data = array(
                    'user_id' => $user_id,
                    'daily_contact_firstname' => $this->input->post('daily_contact_firstname'),
                    'daily_contact_lastname' => $this->input->post('daily_contact_lastname'),
                    'daily_contact_title' => $this->input->post('daily_contact_title'),
                    'daily_contact_email' => $this->input->post('daily_contact_email'),
                    'daily_contact_contact_number' => $this->input->post('daily_contact_contact_no'),
                    'daily_contact_extension' => $this->input->post('daily_contact_extension'),
                );

                $employers_daily_contact = insert_update_data($ins = 1, $table_name = 'crm_employers_daily_contact', $ins_data = $daily_contact_data);

                $billing_contact_data = array(
                    'user_id' => $user_id,
                    'billing_contact_firstname' => $this->input->post('billing_contact_firstname'),
                    'billing_contact_lastname' => $this->input->post('billing_contact_lastname'),
                    'billing_contact_title' => $this->input->post('billing_contact_title'),
                    'billing_contact_email' => $this->input->post('billing_contact_email'),
                    'billing_contact_contact_number' => $this->input->post('billing_contact_contact_no'),
                    'billing_contact_extension' => $this->input->post('billing_contact_extension'),
                );

                $employers_billing_contact = insert_update_data($ins = 1, $table_name = 'crm_employers_billing_contact', $ins_data = $billing_contact_data);

                $technical_contact_data = array(
                    'user_id' => $user_id,
                    'technical_contact_firstname' => $this->input->post('technical_contact_firstname'),
                    'technical_contact_lastname' => $this->input->post('technical_contact_lastname'),
                    'technical_contact_title' => $this->input->post('technical_contact_title'),
                    'technical_contact_email' => $this->input->post('technical_contact_email'),
                    'technical_contact_contact_number' => $this->input->post('technical_contact_contact_no'),
                    'technical_contact_extension' => $this->input->post('technical_contact_extension'),
                );

                $employers_technical_contact = insert_update_data($ins = 1, $table_name = 'crm_employers_technical_contact', $ins_data = $technical_contact_data);

                $log = array('action_by' => $this->session->userdata['user_info']['user_id'], 'user_id' => $user_id, 'action' => 'created');
                $emp_log = insert_update_data($ins = 1, $table_name = 'crm_employers_log', $ins_data = $log);


                if ($user_tbl && $employers_technical_contact && $employers_billing_contact && $employers_daily_contact && $employers_primary && $emp_log) {

                    $msg = "Hello " . $this->input->post('emp_name') . "<br><br>
                            You are successfully registered in amenitybenefits.<br><br>
                            Please click below URL for your information.<br><br>
                            http://amenitybenefits.agencyvue.com/crm/admin/employers/view_employer_info/" . urlencode(base64_encode($user_id)) . "<br><br>
                            Once admin approve your registration request, then you able to login in our website.<br><br>
                            Thank You,<br><br>
                            Amenitybenefits";
                    $subject = "Thank You for your registration";
                    $to_email = $this->input->post('login_email');
                    $title = "Amenitybenefits Employer Registration";
                    send_email($to_email, $subject, $msg, $title);

                    $this->session->set_flashdata('success', 'Employer successfully Insert!');
                    redirect(base_url('admin/employers'));
                } else {
                    $this->session->set_flashdata('error', 'Employer is not Insert!');
                    redirect(base_url('admin/employers'));
                }
            }
        }

        $this->template->load('admin_header', 'admin/employers/add_employer', $data);
    }

    /*
     * @uses open leads index page
     * @author RRA
     */

    /**
     * @uses of method: Check email address is already exist in DB.
     * @param: Email @email email address of  user.
     * @author: RRA
     */
    function isEmailExist() {
        //$this->load->library('form_validation');  
        $email = $this->input->post('login_email');
        $this->db->select('user_id');
        $this->db->where('email', $email);
        $query = $this->db->get('crm_user_tbl');
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('isEmailExist', 'Login email address is already exist.');
            return false;
        } else {
            return true;
        }
    }

    /*
     * @uses open leads index page
     * @author MGA
     */

    public function manageEmployer() {

        $data['title'] = 'Manage Employer || Admin';
        $this->load->model('lead');
        $data['brokers'] = $this->lead->all_broker_list();
        $this->template->load('admin_header', 'admin/employers/employer_master', $data);
    }

    /*
     * @uses open leads index page
     * @author MGA
     */

    public function unapprovedEmployer() {

        $data['title'] = 'Manage Unapproved Employer || Admin';

        $this->template->load('admin_header', 'admin/employers/index', $data);
    }

    /**
     * @uses indexJson is used for get datatable data
     * @author MGA
     */
    public function indexJson() {
        $agent_id = "";

        if (isset($_REQUEST['agent_id'])) {

            $agent_id = $_REQUEST['agent_id'];
        }

        $aColumns = array("employer_name", "email", "employer_city", "state", "crm_user_tbl.created_date", "broker_name");

        /* Paging */

        $sLimit = array();

        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {

            $sLimit = array("start" => $_GET['iDisplayLength'], "end" => $_GET['iDisplayStart']);
        }

        /* Search */

        $sWhere = "";

        $sColumns = array("employer_name", "employer_email", "employer_city", "employer_state", "created_date", "first_name", "last_name");
        if ($_GET['sSearch'] != "") {
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
            $sOrder = array("field" => $aColumns[5],
                "order" => 'DESC');
        }

        $rResult = $this->employer->get_unaproved_employer($sLimit, $sWhere, $sOrder);

        $iTotal_f = count($rResult);

        $iTotal = $this->employer->get_unaproved_employer_count($sWhere);

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

                    $row[] = isset($aRow[$aColumns[$i]]) ? $aRow[$aColumns[$i]] : '';
                }

                $row[] .= '<a class="btn btn-info waves-effect waves-light btn-xs view_profile" href="' . base_url() . 'admin/employers/profile?user_id=' . urlencode(base64_encode($aRow["emp_id"])) . '" data-target="#tabs-modal" data-toggle="modal"><span class="btn-label"><i class="fa fa-eye"></i></span>View Profile </a> &nbsp'
                        . '<button type="button" class="btn btn-success waves-effect waves-light btn-xs approved" value="' . urlencode(base64_encode($aRow['emp_id'])) . '"><span class="btn-label"><i class="fa fa-check"></i></span>Approved</button> &nbsp'
                        . '<button type="button" class="danger-alert btn btn-danger waves-effect waves-light btn-xs disapproved" value="' . urlencode(base64_encode($aRow['emp_id'])) . '"><span class="btn-label"><i class="fa fa-times"></i></span>Disapproved</button>';

                $output['aaData'][] = $row;
            }
        }

        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    /**
     * @uses employerjson is used for get datatable data
     * @author MGA
     */
    public function employerjson() {
          $agent_id = "";
         if (isset($_REQUEST['agent_id'])) {
            $agent_id = $_REQUEST['agent_id'];
        }

        $aColumns = array("employers_primary_id", "employer_name", "email", "created_date", "broker_name");

        /* Paging */

        $sLimit = array();

        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $sLimit = array("start" => $_GET['iDisplayLength'], "end" => $_GET['iDisplayStart']);
        }

        /* Search */

        $sWhere = "";

        $sColumns = array("employer_name", "employer_email", "created_date", "first_name", "last_name");
        if ($_GET['sSearch'] != "") {
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
            $sOrder = array("field" => $aColumns[5],
                "order" => 'DESC');
        }
          $rResult = $this->employer->get_all_approved_employer($sLimit, $sWhere, $sOrder, $agent_id);
        $iTotal_f = count($rResult);
        $iTotal = $this->employer->get_all_approved_employer_count($sWhere,$agent_id);

//        $rResult = $this->employer->get_all_approved_employer($sLimit, $sWhere, $sOrder);
//        $iTotal_f = count($rResult);
//        $iTotal = $this->employer->get_all_approved_employer_count($sWhere);

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
                    if ($aColumns[$i] == 'employers_primary_id') {
                        $row[] = "
                    <div class='checkbox checkbox-primary checkbox-single m-r-15'>
                        <input id='act_checkbox_" . $aRow['employers_primary_id'] . "' type='checkbox' value=" . urlencode(base64_encode($aRow["employers_primary_id"])) . " name='act_checkbox[]' class='ch_checkbox'>
                        <label for='act-checkbox'></label>
                    </div>
                    <img src=" . base_url() . "assets/images/users/avatar-5.jpg alt='contact-img' title='contact-img' class='img-circle thumb-sm' />";
                    } else {
                        $row[] = isset($aRow[$aColumns[$i]]) ? $aRow[$aColumns[$i]] : '';
                    }
                }

                $row[] .= '<a class="btn btn-info btn-xs table-action-btn admin-action-icon-in-data-table" href="' . base_url() . 'admin/employers/view_profile?user_id=' . urlencode(base64_encode($aRow["emp_id"])) . '"title="View Employer Profile"><i class="fa fa-eye"></i></a>'
                        . '<a class="btn btn-default btn-xs table-action-btn admin-action-icon-in-data-table" href="' . base_url() . 'admin/employers/edit_employer/' . urlencode(base64_encode($aRow["emp_id"])) . '" title = "Edit Employer Prfile"><i class="fa fa-pencil"></i></a>'
                        . '<button class="btn btn-primary btn-xs table-action-btn admin-action-icon-in-data-table view_log" data-custom-value="' . urlencode(base64_encode($aRow['emp_id'])) . '" title = "View Log Of Employer"><i class="fa fa-list-ul"></i></button>'
                        . '<button class="danger-alert btn btn-danger btn-xs table-action-btn admin-action-icon-in-data-table del_broker" value="' . urlencode(base64_encode($aRow['emp_id'])) . '" title = "Remove Employer"><i class="fa fa-times"></i></button>';

                $output['aaData'][] = $row;
            }
        }
        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    function process() {

        if ($_REQUEST['user_id'] != "") {

            if ($_REQUEST['req_type'] != "") {

                $uid = base64_decode(urldecode($_REQUEST['user_id']));
                $userdata = get_data("crm_user_tbl", 1, "user_id = $uid");
                $user_email = $userdata["email"];

                if ($_REQUEST['req_type'] == 'approved') {

                    insert_update_data($ins = 0, $tbl_name = 'crm_user_tbl', $ins_data = array("is_approved" => "Y"), $where = array("user_id" => $uid));
                    $subject = 'Employer account registration';
                    $msg = "Hi,<br><br>

                    <strong> Your Employer account is approved. </strong><br><br>
                                        You can login in system with you Email ID and Password. <br><br>
                                        Here is login URL  http://amenitybenefits.agencyvue.com/crm/  <br><br>
                    Thanks,<br><br>
                    Amenitybenefits.<br>";

                    if (send_broker_email_process($user_email, $subject, $msg)) {
                        echo 'approved';
                    } else {
                        echo "Please try again!";
                    }
                }

                if ($_REQUEST['req_type'] == 'disapproved') {
                    insert_update_data($ins = 0, $tbl_name = 'crm_user_tbl', $ins_data = array("is_approved" => "N"), $where = array("user_id" => $uid));
                    $subject = 'Broker account registration';
                    $msg = "Hi,<br><br>

                    <strong> Your Employer account is disapproved by our admin. </strong> <br><br>
                                        For more details,please feel free to contact us || http://amenitybenefits.agencyvue.com/contact-us-2/ <br><br>
                    Thanks,<br>
                    Amenitybenefits.";

                    if (send_broker_email_process($user_email, $subject, $msg)) {
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

    function profile() {

        $user_id = base64_decode(urldecode($_REQUEST['user_id']));

        $data['emp_details'] = $this->employer->get_employer_profile($user_id);

        $this->load->view('admin/employers/employer_profile', $data);
    }

    function view_profile() {

        $data['title'] = 'Employer Profile';

        $user_id = base64_decode(urldecode($_REQUEST['user_id']));

        $data['emp_info'] = $this->employer->get_employer_profile($user_id);

        $this->template->load('admin_header', 'admin/employers/view_profile', $data);
    }

    /**
     * @uses removelead is used for remove or delete lead
     * @author MGA
     */
    public function removeemp() {

        $cus_id = base64_decode(urldecode($this->input->post('user_id')));
        $con = array('user_id' => $cus_id);
        $data = array('is_deleted' => 'Y');
        $done = insert_update_data($ins = 0, $tbl_name = 'crm_user_tbl', $data = $data, $where = $con);

        if ($done) {
            $msg = "Employer Successfully Delete";
            echo $msg;
        }

        die();
    }

    /**
     * @uses edit_employer is used for edit employer data
     * @author MGA
     */
    public function edit_employer($id = null) {
        $data['title'] = 'Edit Employer';
        $uid = base64_decode(urldecode($id));
        $data['state'] = get_data($tbl_name = 'crm_states', $single = 0);
        $table = 'crm_employers_primary';
        $options = array(
            'JOIN' => array(
                array(
                    'table' => 'crm_employers_daily_contact',
                    'condition' => 'crm_employers_daily_contact.user_id = crm_employers_primary.user_id',
                    'type' => 'FULL'
                ),
                array(
                    'table' => 'crm_employers_billing_contact',
                    'condition' => 'crm_employers_billing_contact.user_id = crm_employers_primary.user_id',
                    'type' => 'FULL'
                ),
                array(
                    'table' => 'crm_employers_technical_contact',
                    'condition' => 'crm_employers_technical_contact.user_id = crm_employers_primary.user_id',
                    'type' => 'FULL'
                ),
            ),
            'conditions' => array(
                "crm_employers_primary.user_id" => $uid,
            ),
        );

        $data['emp_info'] = get_relation($table, $options);
        $con_pri = array('state_code' => $data['emp_info'][0]['employer_state']);
        $this->db->where($con_pri);
        $query = $this->db->get('crm_cities');
        $data['city_pri'] = $query->result_array();
        $data['domain_name'] = get_subdomain_id($uid);
      
        if ($this->input->post('save')) {
            $this->form_validation->set_rules('emp_name', 'Employer Name', 'required');
            $this->form_validation->set_rules('emp_email', 'Email Address', 'required|valid_email');
            $this->form_validation->set_rules('emp_ser_no', 'Customer Service Number', 'required');
            $this->form_validation->set_rules('emp_address', 'Address', 'required');
            $this->form_validation->set_rules('emp_zipcode', 'Zip Code', 'required');

            $this->form_validation->set_rules('daily_contact_firstname', 'Daily Contact Firstname', 'required');
            $this->form_validation->set_rules('daily_contact_lastname', 'Daily Contact Lastname', 'required');
            $this->form_validation->set_rules('daily_contact_title', 'Daily Contact Title', 'required');
            $this->form_validation->set_rules('daily_contact_email', 'Daily Contact Email', 'required');
            $this->form_validation->set_rules('daily_contact_contact_no', 'Daily Contact Number', 'required');

            $this->form_validation->set_rules('billing_contact_firstname', 'Billing Contact Firstname', 'required');
            $this->form_validation->set_rules('billing_contact_lastname', 'Billing Contact Lastname', 'required');
            $this->form_validation->set_rules('billing_contact_title', 'Billing Contact Title', 'required');
            $this->form_validation->set_rules('billing_contact_email', 'Billing Contact Email', 'required');
            $this->form_validation->set_rules('billing_contact_contact_no', 'Billing Contact Number', 'required');

            $this->form_validation->set_rules('technical_contact_firstname', 'Technical Contact Firstname', 'required');
            $this->form_validation->set_rules('technical_contact_lastname', 'Technical Contact Lastname', 'required');
            $this->form_validation->set_rules('technical_contact_title', 'Technical Contact Title', 'required');
            $this->form_validation->set_rules('technical_contact_email', 'Technical Contact Email', 'required');
            $this->form_validation->set_rules('technical_contact_contact_no', 'Technical Contact Number', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->form_validation->set_error_delimiters();
            } else {

                $where_update = array('user_id' => $uid);

                $employers_primary_data = array(
                    'employer_name' => $this->input->post('emp_name'),
                    'employer_website' => $this->input->post('emp_website'),
                    'employer_email' => $this->input->post('emp_email'),
                    'employer_cus_service_number' => $this->input->post('emp_ser_no'),
                    'employer_fax' => $this->input->post('emp_fax_no'),
                    'employer_address' => $this->input->post('emp_address'),
                    'employer_address_details' => $this->input->post('emp_address_det'),
                    'employer_city' => $this->input->post('emp_city'),
                    'employer_state' => $this->input->post('emp_state'),
                    'employer_zipcode' => $this->input->post('emp_zipcode'),
                    'employer_fulfillment' => $this->input->post('fulfillment_type'),
                );
                $employers_primary = insert_update_data($ins = 0, $table_name = 'crm_employers_primary', $ins_data = $employers_primary_data, $where = $where_update);

                $daily_contact_data = array(
                    'daily_contact_firstname' => $this->input->post('daily_contact_firstname'),
                    'daily_contact_lastname' => $this->input->post('daily_contact_lastname'),
                    'daily_contact_title' => $this->input->post('daily_contact_title'),
                    'daily_contact_email' => $this->input->post('daily_contact_email'),
                    'daily_contact_contact_number' => $this->input->post('daily_contact_contact_no'),
                    'daily_contact_extension' => $this->input->post('daily_contact_extension'),
                );

                $employers_daily_contact = insert_update_data($ins = 0, $table_name = 'crm_employers_daily_contact', $ins_data = $daily_contact_data, $where = $where_update);

                $billing_contact_data = array(
                    'billing_contact_firstname' => $this->input->post('billing_contact_firstname'),
                    'billing_contact_lastname' => $this->input->post('billing_contact_lastname'),
                    'billing_contact_title' => $this->input->post('billing_contact_title'),
                    'billing_contact_email' => $this->input->post('billing_contact_email'),
                    'billing_contact_contact_number' => $this->input->post('billing_contact_contact_no'),
                    'billing_contact_extension' => $this->input->post('billing_contact_extension'),
                );

                $employers_billing_contact = insert_update_data($ins = 0, $table_name = 'crm_employers_billing_contact', $ins_data = $billing_contact_data, $where = $where_update);

                $technical_contact_data = array(
                    'technical_contact_firstname' => $this->input->post('technical_contact_firstname'),
                    'technical_contact_lastname' => $this->input->post('technical_contact_lastname'),
                    'technical_contact_title' => $this->input->post('technical_contact_title'),
                    'technical_contact_email' => $this->input->post('technical_contact_email'),
                    'technical_contact_contact_number' => $this->input->post('technical_contact_contact_no'),
                    'technical_contact_extension' => $this->input->post('technical_contact_extension'),
                );

                $employers_technical_contact = insert_update_data($ins = 0, $table_name = 'crm_employers_technical_contact', $ins_data = $technical_contact_data, $where = $where_update);

                $tc_log = array('action_by' => $this->session->userdata['user_info']['user_id'], 'user_id' => $uid, 'action' => 'update');
                $emp_pri_log = insert_update_data($ins = 1, $table_name = 'crm_employers_log', $ins_data = $tc_log);

                if ($employers_technical_contact && $employers_billing_contact && $employers_daily_contact && $employers_primary) {
                    $this->session->set_flashdata('success', 'Employer successfully updated!');
                    redirect(base_url('admin/employers/manageEmployer'));
                } else {
                    $this->session->set_flashdata('error', 'Employer is not updated!');
                    redirect(base_url('admin/employers/manageEmployer'));
                }
            }
        }

        $this->template->load('admin_header', 'admin/employers/edit_employer', $data);
    }

    /*
     * @uses getcity is used for get city in dropdown
     * @author MGA
     */

    public function getcity() {
        $ust = $this->input->post('ustid');

        $con_array = array('state_code' => $ust);

        $this->db->where($con_array);
        $query = $this->db->get('crm_cities');
        $citylist = $query->result();

        $html = "<select class='form-control required' id='emp_city' name='emp_city'>";
        $html .= "<option value=''>Please Select City</option>";
        foreach ($citylist as $q) {
            $html = $html . "<option value='$q->city'>$q->city</option>";
        }

        echo '</select>';

        echo $html;
    }

    /**
     * @uses show_employer_info is used for show employer data and active
     * @author MGA
     */
    public function show_employer_info() {
        $emp_id = base64_decode(urldecode($this->input->post('empid')));
        $this->db->where('user_id', $emp_id);
        $query = $this->db->get('crm_employers_primary');
        $data['result'] = $query->row();
        $table = 'crm_employers_log';
        $options = array(
            'JOIN' => array(
                array(
                    'table' => 'crm_user_tbl',
                    'condition' => 'crm_user_tbl.user_id = crm_employers_log.action_by',
                    'type' => 'FULL'
                ),
            ),
            'conditions' => array(
                "crm_employers_log.user_id" => $emp_id,
            ),
            'ORDER_BY' => array(
                "field" => 'crm_employers_log.log_datetime',
                "order" => 'DESC'
            )
        );

        $data['lead_log'] = get_relation($table, $options);
        echo $this->load->view('admin/employers/info_employer', $data, true);
        die;
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

}
