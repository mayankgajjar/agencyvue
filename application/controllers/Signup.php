<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class signup extends CI_Controller {

    function __construct() {

        parent::__construct();
    }

    function index() {

        $data['title'] = 'Sign Up Page For Broker';
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
            $this->form_validation->set_rules('domain_name', 'Domain Name', 'required');
            $this->form_validation->set_rules('zipcode', 'Zipcode', 'required');
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

            $this->form_validation->set_rules('login_email', 'Email', 'trim|required|valid_email|callback_isEmailExist');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|matches[cpassword]');
            $this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required');
            $this->form_validation->set_rules('t_and_c', 'Please check terms and conditions checkbox', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->form_validation->set_error_delimiters();
            } else {

                if (!empty($_FILES['img']['name'])) {

                    $imagename = time() . $_FILES['img']['name'];

                    $config['upload_path'] = 'assets/crm_image/broker/';
                    $config['allowed_types'] = 'gif|jpg|png|pdf';
                    //$config['max_size']             = 100;
                    //$config['max_width']            = 1024;
                    //$config['max_height']           = 768;  
                    $config['file_name'] = $imagename;
                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('img')) {
                        $error = array('error' => $this->upload->display_errors());
                    } else {
                        $data = $this->upload->data();
                        $picture = $data['file_name'];
                    }
                } else {
                    $picture = '';
                }

                $user_tbl_data = array('email' => $this->input->post('login_email'), 'password' => md5($this->input->post('password')), 'roll_id' => ('2'));
                $user_tbl = insert_update_data($ins = 1, $table_name = 'crm_user_tbl', $ins_data = $user_tbl_data);
                $user_id = $this->db->insert_id();

                $data_crm_domain_master =  array('user_id' => $user_id, 'domain_name' => $this->input->post('domain_name'));
                $domain = insert_update_data($ins = 1, $table_name = 'crm_domain_master', $ins_data = $data_crm_domain_master);

                $dob1 = $this->input->post('dob');
                $dob = date("Y-m-d", strtotime($dob1));

                $broker_personal_data = array('user_id' => $user_id, 'parent_id' => 'self registered',
                    'first_name' => $this->input->post('first_name'),
                    'middle_name' => $this->input->post('middle_name'), 'last_name' => $this->input->post('last_name'),
                    'personal_email_address' => $this->input->post('email_address'), 'personal_phone_number' => $this->input->post('phone_number'),
                    'dob' => $dob, 'personal_address' => $this->input->post('address'),
                    'personal_address_addtional' => $this->input->post('address_addtional'), 'personal_city' => $this->input->post('sel_city'),
                    'personal_state' => $this->input->post('sel_state'), 'personal_zipcode' => $this->input->post('zipcode'));

                $broker_personal = insert_update_data($ins = 1, $table_name = 'crm_broker_personal', $ins_data = $broker_personal_data);

                $broker_business_data = array('user_id' => $user_id, 'legal_bussiness_name' => $this->input->post('legal_bussiness_name'),
                    'business_email_address' => $this->input->post('business_email_address'), 'custom_service_name' => $this->input->post('custom_service_name'),
                    'business_fax_number' => $this->input->post('fax_number'), 'business_address' => $this->input->post('business_address'),
                    'business_add_addtional' => $this->input->post('business_address_addtional'), 'business_city' => $this->input->post('business_city'),
                    'business_state' => $this->input->post('business_state'), 'business_zip_code' => $this->input->post('business_zip'));


                $broker_business = insert_update_data($ins = 1, $table_name = 'crm_broker_business', $ins_data = $broker_business_data);

                $broker_commision_data = array('user_id' => $user_id, 'commision_payto' => $this->input->post('commision_payto'),
                    'social_security_number' => $this->input->post('social_security_number'), 'federal_tax_id' => $this->input->post('federal_tax_id'),
                    'commsion_receive' => $this->input->post('account_options'), 'commision_name_on_account' => $this->input->post('acc_name'),
                    'commision_bank_name' => $this->input->post('bank_name'), 'commision_address' => $this->input->post('commision_address'),
                    'commision_city' => $this->input->post('commision_city'), 'commision_state' => $this->input->post('commision_state'),
                    'commision_add_addtional' => $this->input->post('commision_add_details'), 'commision_zipcode' => $this->input->post('commision_zipcode'),
                    'account_options' => $this->input->post('select_account'), 'rounting_number' => $this->input->post('rounting_number'),
                    'account_number' => $this->input->post('ac_name'), 'upload_void_check' => $picture);

                $broker_commision = insert_update_data($ins = 1, $table_name = 'crm_broker_commision', $ins_data = $broker_commision_data);

                if ($user_tbl && $broker_personal && $broker_business && $broker_commision) {

                    $msg = "Hello " . $this->input->post('login_email') . "<br><br>
                            Thank You for your registration.<br><br>
                            You are successfully registered in amenitybenefits.<br><br>
                            Once admin approve your registration request, then you able to login in our website.<br><br>
                            Thank You,<br><br>
                            Amenitybenefits";
                    $subject = "Thank You for your registration";
                    $to_email = $this->input->post('email_address');

                    send_broker_email_process($to_email, $subject, $msg);

                    redirect('signup/thankyou');
                }
            }
        }

        $this->template->load('session_less_header', 'public/singup/signup_form', $data);
    }

    /**
     * @method: isEmailExist()
     * @uses of method: Check email address is already exist in DB.
     * @param: Email @email email address of  user.
     * @author: MGA
     */
    function isEmailExist() {
        //$this->load->library('form_validation');  
        $email = $this->input->post('user_email');
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

    function thankyou() {
        $data['title'] = "Thankyou for registration";
        $this->template->load('session_less_header', 'public/singup/thankyou', $data);
    }

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

    public function getcity() {
        $ust = $this->input->post('ustid');
        $bst = $this->input->post('bstid');
        $cst = $this->input->post('cstid');

        if ($ust) {
            $con_array = array('state_code' => $ust);
            $this->db->where($con_array);
            $query = $this->db->get('crm_cities');
            $citylist = $query->result();
            if ($this->input->post('city') != "")
                $selected_city = $this->input->post('city');
            else
                $selected_city = '';

            $html = "<select class='form-control required' id='user_city' name='sel_city'>";
            $html = "<option value=''>Please Select City</option>";
            foreach ($citylist as $city) {
                if ($selected_city != '')
                    if ($selected_city == $city->city)
                        $selected = "selected";
                    else
                        $selected = "";
                $html = $html . "<option value='$city->city' $selected >$city->city</option>";
            }
        } elseif ($bst) {

            $con_array = array('state_code' => $bst);

            $this->db->where($con_array);
            $query = $this->db->get('crm_cities');
            $citylist = $query->result();

            $html = "<select class='form-control required selcity' id='business_city' name='business_city'>";
            $html = "<option value=''>Please Select City</option>";
            foreach ($citylist as $city) {
                $html = $html . "<option value='$city->city'>$city->city</option>";
            }
        } elseif ($cst) {

            $con_array = array('state_code' => $cst);

            $this->db->where($con_array);
            $query = $this->db->get('crm_cities');
            $citylist = $query->result();

            $html = "<select class='form-control required selcity' id='commision_city' name='commision_city'>";
            $html = "<option value=''>Please Select City</option>";
            foreach ($citylist as $city) {
                $html = $html . "<option value='$city->city'>$city->city</option>";
            }
        }

        echo $html;
    }

    public function chk_email(){
        $email = $this->input->post('email');
        $this->db->select('user_id');
        $this->db->where('email', $email);
        $query = $this->db->get('crm_user_tbl');
        if ($query->num_rows() > 0) {
            echo '<p class="error-msg email-custom" style="color: #C44B4D;margin-top: 10px;">Email address is already exist.</p>';
        }

        die;
    }

}
