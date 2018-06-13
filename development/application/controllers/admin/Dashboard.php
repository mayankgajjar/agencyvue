<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed')

;class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('broker');
        $this->load->model('member');
        $this->load->model('employer');
          $this->load->model('product');
    }

    function index() {
        $data['title'] = 'Dashboard || Admin';
        $data['approvedBroker'] = $this->broker->get_approveuser_count();
        $data['members'] = $this->member->get_member_count_admin();
         $data['products'] = $this->product->get_product_sale_count();
        $data['employer'] = $this->employer->get_all_approved_employer_count();
        $agent_map = $this->member->get_statewise_member_admin();
        //pr_exit($data['agent_map']);
        $map  = array();
        $mapValue = array();
        foreach ($agent_map as $m){
            if($m['total_customer'] >= 1 && $m['total_customer'] < 50){
                $color = '#FFB6C1';
            }elseif($m['total_customer'] >= 50 && $m['total_customer'] < 100){
                $color = '#FFC0CB';
            }elseif($m['total_customer'] >= 100 && $m['total_customer'] < 200){
                $color = '#FF69B4';
            }elseif($m['total_customer'] >= 200){
                $color = '#FF1493';
            }
            if($m['state_code'] == 'DC'){
                $m['state_code'] = 'WA';
            }
            $map[] = array( 'values' =>
                array('US-'.$m['state_code'] => $color),
                "attribute" => 'fill'
            );
            $mapValue['US-'.$m['state_code']] = array(
                 $m['total_customer']
            );
        }
        $data['mapJson'] = json_encode($map); 
        $data['mapvalueJson'] = json_encode($mapValue);        
        $this->template->load('admin_header', 'admin/dashboard/admin', $data);
    }

}
