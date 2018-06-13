<?php

defined('BASEPATH') OR exit('No direct script access allowed');

Class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * @uses Get broker profile in details
     * @author HAD
     */
    public function brokerProfile() {
        $data['title'] = "Broker Profile || Admin";
        $user_id = urldecode(base64_decode($_REQUEST['user_id']));
        $this->load->model('common');
        $data['broker'] = $this->common->get_single_agent($user_id);
        $this->template->load('admin_header', 'admin/profile/broker_profile_view', $data);
    }

}
