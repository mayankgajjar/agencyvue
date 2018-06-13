<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('broker');
    }

    /**
     * @method Index Method as class default method
     * @uses Display profile info and load profile view     
     * @author HAD 
     */
    public function index() {
        $data['title'] = "Admin Profile";
        $data['state'] = get_data($tbl_name = 'crm_states', $single = 0);
        $user_id = $this->session->userdata['user_info']['user_id'];
        $where = array('admin_id' => $user_id);
        $this->db->where($where);
        $this->db->join('crm_user_tbl', 'crm_user_tbl.user_id = crm_admin_primary_details.admin_id');
        $query = $this->db->get('crm_admin_primary_details');
        $data['profile'] = $query->row_array();
        //$data['profile'] = get_data($tbl_name = 'crm_admin_primary_details', $single = 1,$where = $where);
        $this->db->where('state_code', $data['profile']['admin_state']);
        $que = $this->db->get('crm_cities');
        $data['city_list'] = $que->result_array();
        if ($this->input->post()) {
            $this->form_validation->set_rules('first_name', 'Firstname', 'trim|required');
            $this->form_validation->set_rules('middle_name', 'Middlename', 'trim|required');
            $this->form_validation->set_rules('last_name', 'Lastname', 'trim|required');
            $this->form_validation->set_rules('phone_number', 'Contact Number', 'trim|required');
            $this->form_validation->set_rules('dob', 'Date Of Brith', 'trim|required');
            $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|callback_isEmailExist');
            $this->form_validation->set_rules('address', 'Address', 'trim|required');
            $this->form_validation->set_rules('address_addtional', 'Addtional Address', 'trim|required');
            $this->form_validation->set_rules('sel_city', 'City', 'trim|required');
            $this->form_validation->set_rules('zipcode', 'Zipcod', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $this->form_validation->set_error_delimiters();
            } else {

                if (!empty($_FILES['logo']['name'])) {
                    $imagename = 'log' . time() . $_FILES['logo']['name'];
                    $config['upload_path'] = 'assets/crm_image/admin_profile/';
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['file_name'] = $imagename;
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('logo')) {
                        $error = array('error' => $this->upload->display_errors());
                    } else {
                        //$img_path = $_SERVER['DOCUMENT_ROOT'] . '/crm/assets/crm_image/admin_profile/' . $this->session->userdata['admin_profile_img'];
//                        unlink($img_path); 
                        if (isset($data['profile']['admin_image'])) {
                            $img_path = $_SERVER['DOCUMENT_ROOT'] . '/assets/crm_image/admin_profile/' . $data['profile']['admin_image'];
                            unlink($img_path);
                        }

                        $this->session->unset_userdata['admin_profile_img'];
                        $data = $this->upload->data();
                        $logo = $data['file_name'];
                        $this->session->set_userdata('admin_profile_img', $logo);
                    }
                } else {
                    $logo = '';
                }
                $ins_data_1 = array('admin_first_name' => $this->input->post('first_name'),
                    'admin_middle_name' => $this->input->post('middle_name'),
                    'admin_last_name' => $this->input->post('last_name'),
                    'admin_phone_number' => $this->input->post('phone_number'),
                    'admin_dob' => date('Y-m-d', strtotime($this->input->post('dob'))),
                    'admin_address' => $this->input->post('address'),
                    'admin_address_details' => $this->input->post('address_addtional'),
                    'admin_email' => $this->input->post('email'),
                    'admin_city' => $this->input->post('sel_city'),
                    'admin_state' => $this->input->post('sel_state'),
                    'admin_zipcode' => $this->input->post('zipcode'),
                    'admin_image' => $logo,
                );
                $done = insert_update_data($ins = 0, $tbl_name = 'crm_admin_primary_details', $ins_data = $ins_data_1, $where = $where);
                $up_date_1 = array('email' => $this->input->post('email'));
                $where03 = array('user_id' => $user_id);
                $done = insert_update_data($ins = 0, $tbl_name = 'crm_user_tbl', $ins_data = $up_date_1, $where = $where03);

                if ($done) {
                    $this->session->set_flashdata('success', 'Your Profile successfully updated!');
                    redirect('admin/dashboard');
                }
            }
        }

        $this->template->load('admin_header', 'admin/profile/admin_profile.php', $data);
    }

    public function getcity() {
        $ust = $this->input->post('ustid');

        $con_array = array('state_code' => $ust);
        $this->db->where($con_array);
        $query = $this->db->get('crm_cities');
        $citylist = $query->result();
        $html = "<select class='form-control required' id='user_city' name='sel_city'>";
        $html .= "<option value=''>Please Select City</option>";
        foreach ($citylist as $q) {
            $html = $html . "<option value='$q->city'>$q->city</option>";
        }
        $html .= "</select>";
        echo $html;
    }

    /**
     * @method: isEmailExist()
     * @uses of method: Check email address is already exist in DB.
     * @param: Email @email email address of  user.
     * @author: MGA
     */
    function isEmailExist() {
        $email = $this->input->post('email');
        $id = $this->input->post('id');
        $this->db->where('email', $email);
        $this->db->where('user_id!=', $id);
        $query = $this->db->get('crm_user_tbl');
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('isEmailExist', 'Email address is already exist.');
            return false;
        } else {
            return true;
        }
    }

}
