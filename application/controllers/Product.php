<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {
    function __construct() {
        parent::__construct();
       
    }

    /**
     * @method index()
     * @uses load dashboard page
     * @author MGA
     */
    public function index() {
        $data['title'] = "Product";
        $this->template->load('product_header', 'admin/product/index',$data);
    }


}
