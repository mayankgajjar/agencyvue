<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class login extends CI_Controller {

    public function index() {
        $data['error'] = 0;
        if ($_POST) {
            echo '<pre>';
            print_r($_POST);
            echo '</pre>';
            die;
            $this->load->model('user');
            $email = $this->input->post('email', true);
            $password = $this->input->post('password', true);
            $user = $this->user->login($email, $password);
            if (!$user) {
                $data['error'] = 1;
            } else {
                $this->session->set_userdata('userID', $user['userID']);
                $this->session->set_userdata('user_type', $user['user_type']);
                redirect(base_url() . 'posts');
            }
        }
        $this->load->view('admin/user/login', $data);
    }
}
