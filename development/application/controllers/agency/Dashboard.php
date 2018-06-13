<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('product');
        $this->load->model('agency');
        $this->load->model('member');
    }

    public function index() {
        $data['title'] = "Agency Dashboard || AgencyVue";
        $data['approvedBroker'] = get_agents($this->session->userdata['user_info']['user_id']);
        $activeMember = array();
        $agenyID = $this->session->userdata['user_info']['user_id'];
        $agencyMembers = get_agency_members($agenyID);
        $activeMember = count($agencyMembers);
        $agencyAgents = get_agents($agenyID);
        if ($agencyAgents != "") {
            foreach ($agencyAgents as $key => $agent) {
                $totalMembers = count(get_agent_member($agent['user_id']));
                $agentMembers[$key] = array("parent_id" => $agent['user_id'], "total_members" => $totalMembers);
                $activeMember = $activeMember + $totalMembers;
            }
        }
        $data['members'] = $activeMember;

        //$data['employer'] = get_agency_employer($this->session->userdata['user_info']['user_id']);

        $data['products'] = $this->product->get_product_sale_count();
        $data['subagency'] = $this->agency->get_sub_agencies_count($sWhere = "", $agencyId = $this->session->userdata['user_info']['user_id']);
        $agency_map = $this->member->get_statewise_member_agency();
        $map  = array();

        $mapValue = array();
        foreach ($agency_map as $m){
            if($m['total_customer'] >= 1 && $m['total_customer'] < 50){
                $color = '#FFB6C1';
            } elseif ($m['total_customer'] >= 50 && $m['total_customer'] < 100) {
                $color = '#FFC0CB';
            } elseif ($m['total_customer'] >= 100 && $m['total_customer'] < 200) {
                $color = '#FF69B4';
            } elseif ($m['total_customer'] >= 200) {
                $color = '#FF1493';
            }
            if ($m['state_code'] == 'DC') {
                $m['state_code'] = 'WA';
            }
            $map[] = array('values' =>
                array('US-' . $m['state_code'] => $color),
                "attribute" => 'fill'
            );
            $mapValue['US-' . $m['state_code']] = array(
                $m['total_customer']
            );
        }
        $data['mapJson'] = json_encode($map);
        $data['mapvalueJson'] = json_encode($mapValue);

        $this->template->load('agency_header', 'agency/dashboard/index', $data);
    }

}
