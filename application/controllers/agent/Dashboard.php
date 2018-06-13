<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('member');
        $this->load->model('product');
    }

    public function index() {
        $user = $this->session->userdata('user_info');
        if (empty($user)) {
            redirect($this->config->item('http') . $this->config->item('main_url') . 'login');
        }
        $data['title'] = 'Agent || Dashboard';
        $sLimit = array("start" => "7", "end" => "0");
        $sOrder = array("field" => 'customer_id', "order" => 'DESC');
        $sWhere = '';
        $data['verification'] = $this->member->get_pading_varification();
        $data['activemember'] = $this->member->get_member_active();
        /* echo $this->db->last_query();
          die; */
        $data['inactivemember'] = $this->member->get_member_inactive();
        $retentionRate = $data['activemember'] - $data['inactivemember'];
        $data['retention'] = $retentionRate;
//        $data['productsale'] = $this->product->get_product_sale_count();
        $data['memberlist'] = $this->member->get_member($sLimit, $sWhere, $sOrder);
        /* get the agent target */
        $stmt = "SELECT * FROM crm_broker_personal WHERE user_id = {$this->session->userdata['user_info']['user_id']}";
        $query = $this->db->query($stmt);
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            $data['agentTarget'] = $row['agent_target'];
        } else {
            $data['agentTarget'] = 0;
        }
        /* get total sales by an Agent */
        $stmt = "SELECT sum(product_price) AS total_sale FROM `crm_member_products` mp LEFT JOIN crm_products p ON mp.product_id = p.global_product_id WHERE added_by = {$this->session->userdata['user_info']['user_id']} AND is_status = 'Y'";
        $query = $this->db->query($stmt);
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            $data['agentSales'] = $data['productsale'] = $row['total_sale'];
        } else {
            $data['agentSales'] = 0;
        }

        $stmt12 = "SELECT sum(product_price) AS total_cancel_sale FROM `crm_member_products` mp LEFT JOIN crm_products p ON mp.product_id = p.global_product_id WHERE added_by = {$this->session->userdata['user_info']['user_id']} AND is_status = 'C'";
        $query2 = $this->db->query($stmt12);
        if ($query2->num_rows() > 0) {
            $row2 = $query2->row_array();
            $data['productsale'] = $data['productsale'] - $row2['total_cancel_sale'];
        } else {
            $data['productsale'] = $data['agentSales'];
        }


        if ($data['agentTarget'] != 0) {
            $data['salesPercen'] = number_format(($data['agentSales'] * 100) / $data['agentTarget']);
        } else {
            $data['salesPercen'] = '0';
        }
        /* today slaes total */
        $stmt = "SELECT sum(product_price) AS total_sale FROM `crm_member_products` mp LEFT JOIN crm_products p ON mp.product_id = p.global_product_id WHERE added_by = {$this->session->userdata['user_info']['user_id']} AND is_status = 'Y' AND added_time LIKE '%" . date("Y-m-d") . "%'";
        $query = $this->db->query($stmt);
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            $data['agentTodaySales'] = $row['total_sale'] > 0 ? $row['total_sale'] : 0;
        } else {
            $data['agentTodaySales'] = 0;
        }
        /* get total sales for previous month */
        $previous_week = strtotime("-1 week +1 day");

        $start_week = strtotime("last sunday midnight", $previous_week);
        $end_week = strtotime("next saturday", $start_week);

        $start_week = date("Y-m-d h:i:s", $start_week);
        $end_week = date("Y-m-d h:i:s", $end_week);
        $stmt = "SELECT sum(product_price) AS total_sale FROM `crm_member_products` mp LEFT JOIN crm_products p ON mp.product_id = p.global_product_id WHERE added_by = {$this->session->userdata['user_info']['user_id']} AND is_status = 'Y' AND (added_time >= '{$start_week}' AND added_time <= '{$end_week}')";
        $query = $this->db->query($stmt);
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            $data['agentLastweekSales'] = $row['total_sale'] > 0 ? $row['total_sale'] : 0;
        } else {
            $data['agentLastweekSales'] = 0;
        }
        /* get last month sales */
        $last_month_first_day = strtotime('first day of last month');
        $no_of_days = date('t', $last_month_first_day);
        $date_value = $last_month_first_day;
        $lastFirst = date('Y-m-d h:i:s', $date_value);
        $date_value = strtotime("+{$no_of_days} day", $date_value);
        $lastLast = date('Y-m-d h:i:s', $date_value);
        $stmt = "SELECT sum(product_price) AS total_sale FROM `crm_member_products` mp LEFT JOIN crm_products p ON mp.product_id = p.global_product_id WHERE added_by = {$this->session->userdata['user_info']['user_id']} AND is_status = 'Y' AND (added_time >= '{$lastFirst}' AND  added_time <= '{$lastLast}')";
        $query = $this->db->query($stmt);
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            $data['agentLastmonthSales'] = $row['total_sale'] > 0 ? $row['total_sale'] : 0;
        } else {
            $data['agentLastmonthSales'] = 0;
        }
        $agent_map = $this->member->get_statewise_member();
        //pr_exit($data['agent_map']);
        $map = array();
        $mapValue = array();
        foreach ($agent_map as $m) {
            if ($m['total_customer'] >= 1 && $m['total_customer'] < 50) {
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

        $this->template->load('agent_header', 'admin/dashboard/index', $data);
    }

}
