<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Changepassword extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    function index(){

    	if ($this->input->post('save')) {
            $id = $this->session->userdata['user_info']['user_id'];
            $this->form_validation->set_rules('password', 'New Password', 'trim|required|min_length[5]|matches[confirm_password]');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                $this->form_validation->set_error_delimiters();
            } else {
                $pass = $this->input->post('password');
                $data = array('password' => md5($pass), 'is_login_first_time' => 'N');
                $condition = 'user_id = ' . $id;
                $done = insert_update_data($ins = 0, $tbl_name = 'crm_user_tbl', $ins_data = $data, $where = $condition);
                if ($done) {
                   redirect(base_url().'member/dashboard');
                } 
            }
        }

        $this->load->view('admin/user/email_forget_password');
    }

}