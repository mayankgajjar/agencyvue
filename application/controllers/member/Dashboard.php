<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    function __construct() {
        parent::__construct();
       
    }

    /**
     * @uses load dashboard page
     * @author MGA
     */
    public function index() {
        $data['title'] = 'Member || Dashboard';
        $con = array('customer_id' => $this->session->userdata['user_info']['user_id']);
        $data['spo'] = $this->db->get_where('crm_lead_member_spouse', $con)->result();
        $no_of_spouse = sizeof($data['spo']);
        $data['chi'] = $this->db->get_where('crm_lead_member_child', $con)->result();
        $no_of_child = sizeof($data['chi']);
        $data['total_dependents'] =  $no_of_spouse + $no_of_child;

        $data_con = array('crm_member_product_config.member_id' => $this->session->userdata['user_info']['user_id'] , 'crm_member_product_config.is_active' => 'Y');
        $this->db->select('crm_products.product_id,crm_member_product_config.member_id,crm_products.product_name,crm_products.plan_id,crm_products.product_image,crm_products.global_product_id');
        $this->db->from('crm_member_product_config');
        $this->db->where($data_con);
        $this->db->join('crm_products', 'crm_member_product_config.product_id = crm_products.global_product_id');
        $query1 = $this->db->get(); 
        $data['product_data'] = $query1->result_array();

        $sel_pro_con =  array('crm_member_products.member_id' => $this->session->userdata['user_info']['user_id'], 'crm_member_products.is_status' => 'Y');
        $this->db->select('crm_products.product_id,crm_member_products.member_id,crm_products.product_name,crm_products.plan_id,crm_products.product_image,crm_products.global_product_id');
        $this->db->from('crm_member_products');
        $this->db->where($sel_pro_con);
        $this->db->join('crm_products', 'crm_member_products.product_id = crm_products.global_product_id');
        $sel_pro_query = $this->db->get();
        $data['selected_product_data'] = $sel_pro_query->result_array();
        $data['res_sel_column'] = array_column($data['selected_product_data'],'product_id');

        $this->template->load('member_header', 'member/dashboard/member',$data);
    }
}
