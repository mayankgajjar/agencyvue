<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    function __construct() {

        parent::__construct();

        $this->load->model('broker');
        $this->load->model('member');
    }

    /**

     * @method Index Method as class default method

     * @uses Display profile info and load profile view     

     * @author HAD 

     */
    public function index() {

        $data['title'] = "Broker Profile";

        $data['state'] = get_data($tbl_name = 'crm_states', $single = 0);
        $data['activemember'] = $this->member->get_member_active();
        $data['inactivemember'] = $this->member->get_member_inactive();
        $retentionRate = $data['activemember'] - $data['inactivemember'];
        $data['retention'] = $retentionRate;
        $this->load->model('broker');
        $user_id = $this->session->userdata['user_info'] ['user_id'];

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
        $data['subdomain'] = get_subdomain_id($user_id);
        $this->template->load('agent_header', 'agent/profile/profile.php', $data);

        if ($this->input->post()) {

            $where = array('user_id' => $user_id);
            if (!empty($_FILES['logo']['name'])) {
                $imagename = 'log' . time() . $_FILES['logo']['name'];
                $config['upload_path'] = 'assets/crm_image/agent_profile/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['file_name'] = $imagename;
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('logo')) {
                    $error = array('error' => $this->upload->display_errors());
                } else {
                    $img_path = $_SERVER['DOCUMENT_ROOT'] . '/crm/assets/crm_image/agent_profile/' . $this->session->userdata['agent_profile_img'];
                    if (file_exists($img_path)) {
                        unlink($img_path);
                    }
                    $this->session->unset_userdata['agent_profile_img'];
                    $data = $this->upload->data();
                    $logo = $data['file_name'];
                    $this->session->set_userdata('agent_profile_img', $logo);
                }
            } else {
                $logo = $data['broker_details'][0]['agent_image'];
            }


            $ins_data_1 = array('first_name' => $this->input->post('first_name'),
                'middle_name' => $this->input->post('middle_name'),
                'last_name' => $this->input->post('last_name'),
                'personal_phone_number' => $this->input->post('phone_number'),
                'dob' => date('Y-m-d', strtotime($this->input->post('dob'))),
                'personal_address' => $this->input->post('address'),
                'personal_address_addtional' => $this->input->post('address_addtional'),
                'personal_zipcode' => $this->input->post('zipcode'),
                'agent_image' => $logo,
                'agent_target' => $this->input->post('agent_target'),
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
                'account_number' => $this->input->post('ac_name')
            );

            insert_update_data($ins = 0, $tbl_name = 'crm_broker_commision', $ins_data = $ins_data_2, $where = $where);
            $this->session->set_flashdata('success', 'Your Profile successfully updated!');
            echo redirect(base_url() . 'agent/profile');
        }
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

            $html = "<select class='form-control required' id='user_city' name='sel_city'>";

            $html .= "<option value=''>Please Select City</option>";

            foreach ($citylist as $q) {

                $html = $html . "<option value='$q->city'>$q->city</option>";
            }
        } elseif ($bst) {

            $con_array = array('state_code' => $bst);

            $this->db->where($con_array);

            $query = $this->db->get('crm_cities');

            $citylist = $query->result();

            $html = "<select class='form-control required selcity' id='business_city' name='business_city'>";

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

        $html .= "</select>";

        echo $html;
    }

}
