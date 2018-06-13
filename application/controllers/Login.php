<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user');
    }

    public function index() {
        if (isset($_REQUEST['methodID']) == "loginmed360") {
            if (isset($_REQUEST['userID']) != "") {
                $userID = base64_decode(urldecode($_REQUEST['userID']));
                $user_info = $this->user->getDetails_by_id($userID);
                if ($user_info != "") {
                    if ($user_info['roll_id'] == 4) {
                        $this->session->set_userdata('user_info', $user_info);
                        $where = array('member_primary_id' => $this->session->userdata['user_info']['user_id']);
                        $profile_image = get_data('crm_lead_member_primary', '1', $where);
                        $member_img = $profile_image['customer_image'];

                        $this->session->set_userdata('member_profile_img', $member_img);
                        if ($this->session->userdata['user_info']['is_login_first_time'] == 'Y') {
                            redirect(base_url() . 'changepassword');
                        } else {

                            redirect(base_url() . 'member/dashboard');
                        }
                    } else {
                        $this->session->set_flashdata('error', 'Member Login Only');
                        redirect(base_url());
                    }
                } else {
                    $this->session->set_flashdata('error', 'Access Denied || Bed Request');
                    redirect(base_url());
                }
            }
            redirect(base_url());
        }
        $data['error'] = 0;
        if ($this->input->post('log_in_btn')) {
            $this->form_validation->set_rules('email', 'Username', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim');
            if ($this->form_validation->run() == FALSE) {
                $data['error'] = validation_errors();
            } else {

                $email = $this->input->post('email');
                $password = $this->input->post('password');
                $user = $this->user->login($email, $password);

                if (!$user) {
                    $this->session->set_flashdata('error', 'invalid username or password');
                    //$data['error'] = 1;
                } else {

                    $remember = $this->input->post('remember');

                    if ($remember) {
                        //--- set login cookie for 1 year
                        $expire = time() + 31556926;
                        $cookie_value = array(
                            'created' => time(),
                            'user' => $user['user_id'],
                            'email' => $user['email']
                        );
                        setcookie('already_login', serialize($cookie_value), $expire);

                        //--- set session
                    }
                    $this->session->set_userdata('user_info', $user);

                    if ($this->session->userdata['user_info']['roll_id'] == 1) {
                        $where = array('admin_id' => $this->session->userdata['user_info']['user_id']);
                        $profile_image = get_data('crm_admin_primary_details', '1', $where);
                        $admin_img = $profile_image['admin_image'];
                        $this->session->set_userdata('admin_profile_img', $admin_img);
                        $subdomain = get_subdomain_id($this->session->userdata['user_info']['user_id']);
                        $cookie_name = "subdomain";
                        $cookie_value = $subdomain;
                        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), '/', $this->config->item('cookie_domain')); // 86400 = 1 day
                        redirect($this->config->item('http') . $cookie_value . '.' . $this->config->item('main_url') . 'admin/dashboard');
                        // redirect(base_url() . 'admin/dashboard');
                        //$this->template->load('admin_header', 'admin/dashboard/admin',$data);
                    } elseif ($this->session->userdata['user_info']['roll_id'] == 2) {
                        $where = array('user_id' => $this->session->userdata['user_info']['user_id']);
                        $profile_image = get_data('crm_broker_personal', '1', $where);
                        $agent_img = $profile_image['agent_image'];
                        $this->session->set_userdata('agent_profile_img', $agent_img);
                        $subdomain = get_subdomain_id($this->session->userdata['user_info']['user_id']);
                        $cookie_name = "subdomain";
                        $cookie_value = $subdomain;
                        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), '/', $this->config->item('cookie_domain')); // 86400 = 1 day
                        redirect($this->config->item('http') . $cookie_value . '.' . $this->config->item('main_url') . 'agent/dashboard');
                        //redirect(base_url() . 'agent/dashboard');
                        //$this->template->load('common_header', 'admin/dashboard/index',$data);
                    } elseif ($this->session->userdata['user_info']['roll_id'] == 4) {
                        $where = array('customer_id' => $this->session->userdata['user_info']['user_id']);
                        $profile_image = get_data('crm_lead_member_primary', '1', $where);
                        $member_img = $profile_image['customer_image'];
                        $this->session->set_userdata('member_profile_img', $member_img);
                        if ($this->session->userdata['user_info']['is_login_first_time'] == 'Y') {
                            redirect(base_url() . 'changepassword');
                        } else {
                            redirect(base_url() . 'member/dashboard');
                        }

                        //$this->template->load('common_header', 'admin/dashboard/index',$data);
                    }
                }
            }
        }
        $this->load->view('admin/user/login', $data);
    }

    /**
     * @name logout()
     * @uses call logout
     * @author MGA
     */
    public function logout() {
        setcookie("subdomain", "", time() - 3600, '/', $this->config->item('cookie_domain'));
        if (isset($_COOKIE['already_login'])) {
            unset($_COOKIE['already_login']);
            setcookie('already_login', null, -1, '/');
        }
//        $this->session->unset_userdata('user_info');
        $this->session->sess_destroy();
        redirect($this->config->item('http') . $this->config->item('main_url') . 'login');
        //    redirect(base_url());
    }

}
