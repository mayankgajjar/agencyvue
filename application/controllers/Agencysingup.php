<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Agencysingup extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('broker');
    }

    /**
     * @method Index Method as class default method
     * @uses Display profile info and load profile view     
     * @author RRA 
     */
    public function index() {
        $data['title'] = "Agencysingup";
        $data['state'] = get_data($tbl_name = 'crm_states', $single = 0);
        $this->template->load('session_less_header', 'public/agencysingup/agencysingup', $data);
    }

}
