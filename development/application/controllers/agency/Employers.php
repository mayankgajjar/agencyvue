<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Employers
 *
 * @author dhareen
 */
class Employers extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('employer');
    }

    public function index() {

        $data['title'] = 'Employers List';
        $this->template->load('agency_header', 'agency/employers/index', $data);
    }

    public function add() {
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
                    'display_name' => $this->input->post('emp_name'),
                    'password' => md5($this->input->post('password')),
                    'roll_id' => '3',
                );

                $user_tbl = insert_update_data($ins = 1, $table_name = 'crm_user_tbl', $ins_data = $user_tbl_data);
                $user_id = $this->db->insert_id();

                $data_crm_domain_master = array('user_id' => $user_id, 'domain_name' => $this->input->post('domain_name'));
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
                            You are successfully registered in AgencyVue.<br><br>
                            Please click below URL for your information.<br><br>
                            http://agencyvue.com/employers/view_employer_info/" . urlencode(base64_encode($user_id)) . "<br><br>
                            Once admin approve your registration request, then you able to login in our website.<br><br>
                            Thank You,<br><br>
                            AgencyVue";
                    $subject = "Thank You for your registration";
                    $to_email = $this->input->post('login_email');
                    $title = "AgencyVue Employer Registration";
                    send_email($to_email, $subject, $msg, $title);
                    $this->session->set_flashdata('success', 'Employer successfully Insert!');
                    redirect(base_url('agency/employers'));
                } else {
                    $this->session->set_flashdata('error', 'Employer is not Insert!');
                    redirect(base_url('agency/employers'));
                }
            }
        }
        $this->template->load('agency_header', 'agency/employers/add', $data);
    }

    function indexJson() {

        $aColumns = array("user_id", "employer_name", "email", "employer_created_date");

        /* Pagination */

        $sLimit = array();
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $sLimit = array("start" => $_GET['iDisplayLength'], "end" => $_GET['iDisplayStart']);
        }

        /* Search */

        $sWhere = "";

        if ($_GET['sSearch'] != "") {
            $sColumns = array("employer_name", "employer_email", "employer_created_date");

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

        $rResult = $this->employer->get_employer($sLimit, $sWhere, $sOrder);

        $iTotal_f = count($rResult);

        $iTotal = $this->employer->get_employers_count($sWhere);

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
                    } elseif ($aColumns[$i] == 'employer_created_date') {
                        $row[] .= date('m-d-Y h:i:s a', strtotime($aRow['created_date']));
                    } else {
                        $row[] = isset($aRow[$aColumns[$i]]) ? $aRow[$aColumns[$i]] : '';
                    }
                }

                $row[] .= '<a href="' . base_url() . 'agency/employers/edit/' . urlencode(base64_encode($aRow["user_id"])) . '" class="btn btn-info btn-xs view_profile table-action-btn admin-action-icon-in-data-table edit-href"><i class="glyphicon glyphicon-pencil" title="Edit Employer"></i></a>
                        <span class="danger-alert btn btn-danger btn-xs table-action-btn del_lead admin-action-icon-in-data-table remove-span" data-custom-value="' . $aRow["user_id"] . '"><i class="glyphicon glyphicon-remove" title="Remove Employer"></i></span>
                        <span class="danger-alert btn btn-primary btn-xs table-action-btn lead_det admin-action-icon-in-data-table info-span" data-custom-value="' . $aRow["user_id"] . '"><i class="glyphicon glyphicon-eye-open" title="View Log"></i></span>
                        ';

                $output['aaData'][] = $row;
            }
        }

        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    public function view_employer_info() {
        exit('WORKING ON IT || NIPL');
    }

    /**
     * @uses of method: Check email address is already exist in DB.
     * @param: Email @email email address of  user.
     * @author: MGA
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

}
