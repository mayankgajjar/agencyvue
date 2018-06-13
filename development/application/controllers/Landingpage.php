<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Landingpage extends CI_Controller {



    public function __construct() {

        parent::__construct();

        //subdomain_control();

    }



    public function index() {

        $this->load->view('public/landing/landingpage');

    }



}

