<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('member');
    }

    function index(){

    	$data['title'] = 'Client Profile';
    	$cid = $this->session->userdata['user_info']['user_id'];

        $this->db->where('user_id',$cid);
        $query52 = $this->db->get('crm_lead_member_master');
        $get_user_id = $query52->row_array();
        $uid = $get_user_id['customer_id'];
    
        $lead_info = $this->member->get_infos($uid, 'crm_lead_member_primary', 'customer_id');
        $data['lead_info'] = $lead_info[0];


        $lead_member_spouse_info = $this->member->get_infos($uid, 'crm_lead_member_spouse', 'customer_id');
        $data['lead_member_spouse_info'] = isset($lead_member_spouse_info[0]) ? $lead_member_spouse_info[0] : array();
        $data['customer_id'] = $uid;

        $new_block['member_child'] = array();

        $new_block['customer_id'] = $uid;
        $new_block['state'] = get_data($tbl_name = 'crm_states', $single = 0);

        $child_arr = $this->member->get_infos($uid, 'crm_lead_member_child', 'customer_id');

          if(!empty($child_arr)){
            $new_block['add_child_block_arr'] = $child_arr;
             $i = 0;
            foreach ($child_arr as $value) {
                 $select_state =  $value['customer_child_state'];
                 $this->db->where('state_code', $select_state);
                 $query = $this->db->get('crm_cities');
                 $new_block['get_city'][$i] = $query->result_array();
                 $i = $i+1;
            }
          }else{ 
            $new_block['add_child_block_arr'] = array();
        }

        $data['add_child_block_html'] = $this->load->view('member/profile/get_child_view', $new_block, true);

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
        
        if ($this->input->post()) {
            
            $customer_id = $this->input->post('customer_id');
            
            if (!empty($_FILES['logo']['name'])) {
                $imagename = 'logo' . time() . $_FILES['logo']['name'];
               
                $config['upload_path'] = 'assets/crm_image/customer_image/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['file_name'] = $imagename;
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('logo')) {
                    $upload_error['error'] = 'Please upload valid logo file';
                    $this->template->load('member_header', 'member/profile/edit_member.php', $upload_error);
                    return FALSE;
                } else {
                    if(isset($lead_info[0]['customer_image'])){
                        $img_path = $_SERVER['DOCUMENT_ROOT'] . '/crm/assets/crm_image/customer_image/' . $this->session->userdata['member_profile_img'];
                        unlink($img_path);
                    }
                    $this->session->unset_userdata['member_profile_img'];
                    $logo_img = $this->upload->data();
                    $logo = $logo_img['file_name'];
                    $this->session->set_userdata('member_profile_img', $logo);
                }
            } else {
                $logo = $lead_info[0]['customer_image'];
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
                'customer_social_security_number' => $this->input->post('cus_security_number'),
                'customer_image' => $logo,
            );
            if ($this->form_validation->run() == FALSE) {
                $this->form_validation->set_error_delimiters();
            }

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
            echo  redirect(base_url() . 'member/dashboard');
            
        }
      
    	$this->template->load('member_header', 'member/profile/edit_member', $data);
    }



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
     * Function for edit member
     */
//    public function save_edit_member() {
//
//        $customer_id = $this->input->post('customer_id');
//        
//        $data_crm_lead_member_primary = array(
//            'customer_first_name' => $this->input->post('cus_first_name'),
//            'customer_middle_name' => $this->input->post('cus_middle_name'),
//            'customer_last_name' => $this->input->post('cus_last_name'),
//            'customer_email' => $this->input->post('cus_email'),
//            'customer_phone_number' => $this->input->post('cus_contact'),
//            'customer_dob' => date('Y-m-d', strtotime($this->input->post('cus_dob'))),
//            'customer_address' => $this->input->post('cus_address'),
//            'customer_address_details' => $this->input->post('cus_sub_address'),
//            'customer_city' => $this->input->post('cus_city'),
//            'customer_state' => $this->input->post('cus_state'),
//            'customer_zipcode' => $this->input->post('cus_zip'),
//            'customer_social_security_number' => $this->input->post('cus_security_number'),
//        );
//        $condition_crm_lead_member_primary = array('customer_id' => $customer_id);
//
//        insert_update_data($ins = 0, $table_name = 'crm_lead_member_primary', $ins_data = $data_crm_lead_member_primary, $where = $condition_crm_lead_member_primary);
//
//        $lead_info = $this->member->get_infos($customer_id, 'crm_lead_member_spouse', 'customer_id');
//
//       if($this->input->post('spouse_first_name') != ""){
//           
//            if(empty($lead_info)){
//
//                $data_crm_lead_member_spouse = array(
//                    'customer_id' => $customer_id,
//                    'customer_spouse_first_name' => $this->input->post('spouse_first_name'),
//                    'customer_spouse_middle_name' => $this->input->post('spouse_middle_name'),
//                    'customer_spouse_last_name' => $this->input->post('spouse_last_name'),
//                    'customer_spouse_email' => $this->input->post('spouse_email_address'),
//                    'customer_spouse_phone_number' => $this->input->post('spouse_phone_no'),
//                    'customer_spouse_dob' => date('Y-m-d', strtotime($this->input->post('spouse_dob'))),
//                    'customer_spouse_address' => $this->input->post('spouse_address'),
//                    'customer_spouse_address_details' => $this->input->post('spouse_sub_address'),
//                    'customer_spouse_city' => $this->input->post('spouse_city'),
//                    'customer_spouse_state' => $this->input->post('customer_spouse_state'),
//                    'customer_spouse_zipcode' => $this->input->post('spouse_zipcode'),
//                    'customer_spouse_social_security_number' => $this->input->post('spouse_ssn'),
//                );
//
//                insert_update_data($ins = 1, $table_name = 'crm_lead_member_spouse', $ins_data = $data_crm_lead_member_spouse);
//            }else{
//
//                 $data_crm_lead_member_spouse = array(
//                    'customer_spouse_first_name' => $this->input->post('spouse_first_name'),
//                    'customer_spouse_middle_name' => $this->input->post('spouse_middle_name'),
//                    'customer_spouse_last_name' => $this->input->post('spouse_last_name'),
//                    'customer_spouse_email' => $this->input->post('spouse_email_address'),
//                    'customer_spouse_phone_number' => $this->input->post('spouse_phone_no'),
//                    'customer_spouse_dob' => date('Y-m-d', strtotime($this->input->post('spouse_dob'))),
//                    'customer_spouse_address' => $this->input->post('spouse_address'),
//                    'customer_spouse_address_details' => $this->input->post('spouse_sub_address'),
//                    'customer_spouse_city' => $this->input->post('spouse_city'),
//                    'customer_spouse_state' => $this->input->post('customer_spouse_state'),
//                    'customer_spouse_zipcode' => $this->input->post('spouse_zipcode'),
//                    'customer_spouse_social_security_number' => $this->input->post('spouse_ssn'),
//                );
//
//                $condition_crm_lead_member_spouse = array('customer_id' => $customer_id);
//                insert_update_data($ins = 0, $table_name = 'crm_lead_member_spouse', $ins_data = $data_crm_lead_member_spouse, $where = $condition_crm_lead_member_spouse);
//            }
//           
//        }
//
//        $list = $this->input->post('form');
//        
//        foreach ($list as $key => $value) {
//            if($value['customer_child_first_name'] != ""){
//                $child_array = array(
//                    'customer_id' => $customer_id,
//                    'customer_child_first_name' => $value['customer_child_first_name'],
//                    'customer_child_middle_name' => $value['customer_child_middle_name'],
//                    'customer_child_last_name' => $value['customer_child_last_name'],
//                    'customer_child_email' => $value['customer_child_email'],
//                    'customer_child_phone_number' => $value['customer_child_phone_number'],
//                    'customer_child_dob' => date('Y-m-d', strtotime($value['customer_child_dob'])),
//                    'customer_child_address' => $value['customer_child_address'],
//                    'customer_child_address_details' => $value['customer_child_address_details'],
//                    'customer_child_city' => $value['customer_child_city'],
//                    'customer_child_state' => $value['customer_child_state'],
//                    'customer_child_zipcode' => $value['customer_child_zipcode'],
//                    'customer_child_social_security_number' => $value['customer_child_social_security_number'],
//                );
//
//                if ($value['status'] == 'new') {
//                    insert_update_data($ins = 1, $table_name = 'crm_lead_member_child', $ins_data = $child_array);
//                }
//                if ($value['status'] == 'old') {
//                    $condition_crm_lead_member_child = array('child_id' => $value['child_id']);
//                    insert_update_data($ins = 0, $table_name = 'crm_lead_member_child', $ins_data = $child_array, $where = $condition_crm_lead_member_child);
//                }
//            }
//        }
//
//        $log = array('action_by' => $this->session->userdata['user_info']['user_id'], 'customer_id' => $customer_id, 'action' => 'Update');
//        $member_log = insert_update_data($ins = 1, $table_name = 'crm_member_log', $ins_data = $log);
//
//        $msg = "Member Successfully Updated";
//        echo $msg;
//    }

}