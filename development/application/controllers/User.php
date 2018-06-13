<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    /**
     * @name change_password()
     * @uses load change password page for change password and recall when user click on save button
     * @author MGA
     */
    public function change_password() {
        $data['title'] = "Change Password";
        if ($this->input->post('save')) {
            $this->form_validation->set_rules('old_password', 'old password', 'trim|required|callback_check_oldpassword');
            $this->form_validation->set_rules('password', 'New Password', 'trim|required|min_length[5]|matches[confirm_password]');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $this->form_validation->set_error_delimiters('<div class="alert alert-warning alert-styled-left alert-bordered"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            } else {
                $pass = $this->input->post('password');
                $data = array('password' => md5($pass));
                $condition = 'user_id = ' . $this->session->userdata['user_info']['user_id'];
                $done = insert_update_data($ins = 0, $tbl_name = 'crm_user_tbl', $ins_data = $data, $where = $condition);
                if ($done) {
                    $this->session->set_flashdata('success', 'Password successfully updated!');
                   
                        if($this->session->userdata['user_info']['roll_id'] == 1){
                            redirect(base_url() . 'admin/dashboard');
                        }elseif ($this->session->userdata['user_info']['roll_id'] == 2) {
                            redirect(base_url() . 'agent/dashboard');
                        }elseif ($this->session->userdata['user_info']['roll_id'] == 4) {
                            redirect(base_url() . 'member/dashboard');
                        }

                } 
            }
        }

            if($this->session->userdata['user_info']['roll_id'] == 1){
                $this->template->load('admin_header', 'admin/user/manage_password', $data);
            }elseif ($this->session->userdata['user_info']['roll_id'] == 2) {
                $this->template->load('agent_header', 'admin/user/manage_password', $data);
            }elseif ($this->session->userdata['user_info']['roll_id'] == 4) {
                $this->template->load('member_header', 'admin/user/manage_password', $data);
            }



        //$this->template->load('admin_header', 'admin/user/manage_password', $data);
    }

    /**
     * @function  check_oldpassword()
     * @uses check old password is valid or not
     * @return boolean TRUE or FALSE
     * @author MGA
     */
    public function check_oldpassword() {
        $oldpassword = $this->input->post('old_password');
        $ch_pass = $this->db->escape(md5($oldpassword));

        $query = $this->db->select('user_id')->where('password =' . $ch_pass)->get('crm_user_tbl');
        $check_email_exist = $query->row_array();

        if ($check_email_exist) {
            return TRUE;
        } else {
            $this->form_validation->set_message('check_oldpassword', 'Old password not matched! Please try with another');
            return FALSE;
        }
    }

    /**
     * @name forget_password()
     * @uses send email to user for forget password
     * @author MGA
     */
    public function forget_password() {

        if ($this->input->post('reset')) {

            $to_email = $this->input->post('email');
            $where = array('email' => $to_email);

            $check_email_exist01 = get_data($tbl_name = 'crm_user_tbl', $single = 1, $where = $where);

            if (!empty($check_email_exist01)) {

                $subject = 'Forget Password for Amenitybenefits Account';
                $msg = "Hi,<br><br>

					You recently requested to reset password for your Amenitybenefits Account. Click the below URL to reset it.<br><br>

					http://amenitybenefits.agencyvue.com/crm/user/email_change_password/" . $check_email_exist01['user_id'] . "<br><br>

					If you did not request a password reset , please ignore this email<br><br>

					Thanks,<br>
					Amenitybenefits.";

                send_forget_password_mail($to_email, $subject, $msg);
            } else {
                $this->session->set_flashdata('error', 'Please Enter Valid Email Address');
            }
        }

        $this->load->view('admin/user/page-recoverpw');
    }

    /**
     * @name email_change_password()
     * @uses change password for forget password
     * @author MGA
     */
    function email_change_password($id = null) {

        if ($this->input->post('save')) {
            $id = $this->uri->segment(3);

            $this->form_validation->set_rules('password', 'New Password', 'trim|required|min_length[5]|matches[confirm_password]');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $this->form_validation->set_error_delimiters('<div class="alert alert-warning alert-styled-left alert-bordered"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            } else {
                $pass = $this->input->post('password');
                $data = array('password' => md5($pass));
                $condition = 'user_id = ' . $id;
                $done = insert_update_data($ins = 0, $tbl_name = 'crm_user_tbl', $ins_data = $data, $where = $condition);
                if ($done) {
                    $this->session->set_flashdata('success', 'Password successfully updated! Please <a href=\'http://amenitybenefits.agencyvue.com\crm\'>Login</a> Now ');
                    //redirect('crm');
                } else {
                    
                }
            }
        }

        $this->load->view('admin/user/email_forget_password');
    }

}
