<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ManageAgents extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('broker');
    }

    /**
     * @uses open Agent index page
     * @author MGA
     */
    public function index() {
        $data['title'] = 'ManageAgents';
        $this->template->load('admin_header', 'admin/manage_agents/index', $data);
    }

    /**
     * @uses this function is used for add Agent data in  table
     * @author MGA
     */
    public function add_agent() {
        $data['title'] = 'Add Agent';
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
                    $picture = '';
                }

                $user_tbl_data = array('email' => $this->input->post('user_email'),
                    'password' => md5($this->input->post('password')),
                    'roll_id' => ('2'),
                    'display_name' => $this->input->post('first_name') . ' ' . $this->input->post('last_name'));
                $user_tbl = insert_update_data($ins = 1, $table_name = 'crm_user_tbl', $ins_data = $user_tbl_data);
                $user_id = $this->db->insert_id();

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

                if ($user_tbl && $broker_personal && $broker_business && $broker_commision) {

                    $msg = "Hello " . $this->input->post('first_name') . "<br><br>
                            You are successfully registered in amenitybenefits.<br><br>
                            Your Login details:<br><br>
                            <strong> Email Address : </strong>" . $this->input->post('user_email') . "<br>
                            <strong> Password : </strong>" . $this->input->post('password') . "<br><br>
                            Click Below URL for Login <br><br>
                            http://amenitybenefits.agencyvue.com/crm/  <br><br>
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
                redirect(base_url() . 'admin/ManageAgents');
            }
        }

        $this->template->load('admin_header', 'admin/manage_agents/add_agent', $data);
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

    /**
     * @uses this function is used for data fill on index page using datatable.
     * @author MGA
     */
    function agentbrokesJson() {

        $aColumns = array("broker_user_id", "broker_name", "email", "created_date");

        /* Pagination */

        $sLimit = array();
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $sLimit = array("start" => $_GET['iDisplayLength'], "end" => $_GET['iDisplayStart']);
        }

        /* Search */

        $sWhere = "";
        $sColumns = array("crm_broker_personal.first_name", "crm_broker_personal.last_name", "email", "created_date");
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

        $rResult = $this->broker->get_agent_brokers($sLimit, $sWhere, $sOrder);
        $iTotal_f = count($rResult);
        $iTotal = $this->broker->get_agent_brokers_count($sWhere);

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
                    if ($aColumns[$i] == 'broker_user_id') {
                        $row[] = "
                    <div class='checkbox checkbox-primary checkbox-single m-r-15'>
                        <input id='act_checkbox_" . $aRow['broker_user_id'] . "' type='checkbox' value=" . urlencode(base64_encode($aRow["broker_user_id"])) . " name='act_checkbox[]' class='ch_checkbox'>
                        <label for='act-checkbox'></label>
                    </div>

                    <img src=" . base_url() . "assets/images/users/avatar-5.jpg alt='contact-img' title='contact-img' class='img-circle thumb-sm' />";
                    } elseif ($aColumns[$i] == 'created_date') {
                        $row[] .= date('m-d-Y h:i:s a', strtotime($aRow['created_date']));
                    } else {
                        $row[] = isset($aRow[$aColumns[$i]]) ? $aRow[$aColumns[$i]] : '';
                    }
                }

                $row[] .= '<a class="btn btn-info btn-xs table-action-btn admin-action-icon-in-data-table" href="' . base_url() . 'agent/ManageAgents/brokerProfile?user_id=' . urlencode(base64_encode($aRow["broker_user_id"])) . '"title="View Broker Profile"><i class="fa fa-eye"></i></a> &nbsp;'
                        . '<a class="btn btn-default btn-xs table-action-btn admin-action-icon-in-data-table" href="' . base_url() . 'agent/ManageAgents/brokerEdit?user_id=' . urlencode(base64_encode($aRow["broker_user_id"])) . '" title = "Edit Broker Prfile"><i class="fa fa-pencil"></i></a> &nbsp;'
                        . '<span class="danger-alert btn btn-danger btn-xs table-action-btn admin-action-icon-in-data-table del_broker" data-custom-value="' . urlencode(base64_encode($aRow['broker_user_id'])) . '" title = "Remove Broker"><i class="glyphicon glyphicon-remove"></i></span>'
                ;

                $output['aaData'][] = $row;
            }
        }

        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    /**
     * @uses this function is used for remove or delete broker.
     * @author MGA
     */
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
        $data['title'] = "Broker Edit || Agent";
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
            $this->session->set_flashdata('success', 'Broker Succesfully Updated');

            redirect(base_url() . 'admin/ManageAgents');
        }

        $this->template->load('admin_header', 'admin/admin_agents/manageBrokers.php', $data);
    }

    /**
     * @uses Get broker profile in details
     * @author MGA
     */
    public function brokerProfile() {
        $data['title'] = "Broker Profile || Admin";
        $user_id = urldecode(base64_decode($_REQUEST['user_id']));
        $this->load->model('common');
        $data['broker'] = $this->common->get_single_agent($user_id);
        $this->template->load('admin_header', 'admin/admin_agents/broker_profile_view', $data);
    }

}

?>