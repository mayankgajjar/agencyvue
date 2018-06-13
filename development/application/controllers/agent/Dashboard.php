<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('member');
        $this->load->model('product');
        $this->load->model('target');
        $this->load->model('member_product');
    }

    public function index() {
        $user = $this->session->userdata('user_info');
        if (empty($user)) {
            redirect($this->config->item('http') . $this->config->item('main_url') . 'login');
        }
        $data['title'] = 'Agent || Dashboard';
        $data['feeds'] = get_feeds($this->session->userdata['user_info']['user_id']);
        $sLimit = array("start" => "7", "end" => "0");
        $sOrder = array("field" => 'customer_id', "order" => 'DESC');
        $sWhere = '';

        // Start PENDING VERIFICATION
        $data['verification'] = $this->member->get_pading_varification_v2();
        // End PENDING VERIFICATION
        $data['activemember'] = $this->member->get_member_active();
        $data['inactivemember'] = $this->member->get_member_inactive();

//        Step 1: Total Cancels / Total Orders = Retention Loss
//        Step 2: Retention Loss - 100% = Retention Rate
        $totalOrders = $this->member->get_total_members();
        if ($totalOrders <= 0) {
            $retentionLoss = 0;
        } else {
            $retentionLoss = $data['inactivemember'] / $totalOrders;
        }

        $midStep = $retentionLoss * 100;
        $retentionRate = 100 - $midStep;
        //$retentionRate = $data['activemember'] - $data['inactivemember'];
        $data['retention'] = $retentionRate;

//$data['productsale'] = $this->product->get_product_sale_count();
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
        if ($data['agentTarget'] != 0) {
            $data['salesPercen'] = ($data['agentSales'] * 100) / $data['agentTarget'];
        } else {
            $data['salesPercen'] = 0;
        }
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
        $stmt2 = "SELECT sum(product_price) AS total_sale FROM `crm_member_products` mp LEFT JOIN crm_products p ON mp.product_id = p.global_product_id WHERE added_by = {$this->session->userdata['user_info']['user_id']} AND is_status = 'Y'";
        $query2 = $this->db->query($stmt2);
        if ($query2->num_rows() > 0) {
            $row2 = $query2->row_array();
            $data['agentTotalSales'] = $row2['total_sale'] > 0 ? $row2['total_sale'] : 0;
        } else {
            $data['agentTotalSales'] = 0;
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
//        Last Transactions Widget
//        $sql = "SELECT p.product_name, mp.is_status, mp.added_time, p.product_price  FROM `crm_member_products` mp LEFT JOIN crm_products p ON mp.product_id = p.global_product_id where (is_status='Y' OR is_status='C') AND added_by=" . $this->session->userdata['user_info']['user_id'] . " ORDER BY mp.added_time DESC LIMIT 10";
//        $query03 = $this->db->query($sql);
//        $data['transactions'] = $query03->result_array();

        /*
         * Agent Target Widget  Data
         */
        $membersTarget = $this->target->get_members_target();
        $commissionTarget = $this->target->get_commission_target();
        $premiumTarget = $this->target->get_premium_target();
        $last_month_first_day = strtotime('first day of last month');
        $no_of_days = date('t', $last_month_first_day);
        $date_value = $last_month_first_day;
        $lastmonthFirstDay = date('Y-m-d h:i:s', $date_value);
        $date_value = strtotime("+{$no_of_days} day", $date_value);
        $lastmonthLastDay = date('Y-m-d h:i:s', $date_value);
        // Last Week Count
        $data['last_week_members'] = $this->member->get_member_betweendates($start_week, $end_week);
        // Last Month Count
        $data['last_month_count'] = $this->member->get_member_betweendates($lastmonthFirstDay, $lastmonthLastDay);
        // All The time
        $data['all_member_count'] = $this->member->get_member_betweendates('01-01-2000 00:00:00', date('Y-m-d h:i:s'));
        // Total Member Today
        $data['today_member_count'] = $this->member->get_today_member_count();
        if (!empty($membersTarget)) {
            if (date_parse($membersTarget['reset_time']) > date_parse(date('Y-m-d h:i:s'))) {
                $this->session->set_userdata('member_target', $membersTarget);
                $totalMemberCountRange = $this->member->get_member_betweendates($membersTarget['created'], $membersTarget['reset_time']);
                $data['memberRangePercentage'] = $totalMemberCountRange * 100 / $membersTarget['target_value'];
                $data['memberTargetInfo'] = $membersTarget;
            } else {
                $totalMemberCountRange = $this->member->get_member_betweendates($membersTarget['created'], $membersTarget['reset_time']);
                $memberRangePercentage = $totalMemberCountRange * 100 / $membersTarget['target_value'];
                $pastRecordsArray = array('agent_id' => $this->session->userdata['user_info']['user_id'], 'row_value' => serialize($membersTarget), 'target_achieved' => $memberRangePercentage);
                $pastRecords = insert_update_data(1, 'cmr_agent_target_past_records', $pastRecordsArray);
                if ($pastRecords) {
                    delete_data('crm_agent_target', array('id' => $membersTarget['id']));
                }
                $data['memberRangePercentage'] = null;
                $data['memberTargetInfo'] = 0;
            }
        } else {
            $data['memberRangePercentage'] = null;
            $data['memberTargetInfo'] = 0;
        }
        if (!empty($premiumTarget)) {
            if (date_parse($premiumTarget['reset_time']) > date_parse(date('Y-m-d h:i:s'))) {
                $this->session->set_userdata('premium_target', $premiumTarget);
                $premiumAmount = $this->member_product->get_total_sales_betweendates($premiumTarget['created'], $premiumTarget['reset_time']);
                $data['premiumPercentage'] = $premiumAmount * 100 / $premiumTarget['target_value'];
                $data['premiumTargetInfo'] = $premiumTarget;
            } else {
                $premiumAmount = $this->member_product->get_total_sales_betweendates($premiumTarget['created'], $premiumTarget['reset_time']);
                $premiumPercentage = $premiumAmount * 100 / $premiumTarget['target_value'];
                $pastRecordsArrayP = array('agent_id' => $this->session->userdata['user_info']['user_id'], 'row_value' => serialize($premiumTarget), 'target_achieved' => $premiumPercentage);
                $pastRecordsP = insert_update_data(1, 'cmr_agent_target_past_records', $pastRecordsArrayP);
                if ($pastRecordsP) {
                    delete_data('crm_agent_target', array('id' => $premiumTarget['id']));
                }
                $data['premiumPercentage'] = null;
                $data['premiumTargetInfo'] = 0;
            }
        } else {
            $data['premiumPercentage'] = null;
            $data['premiumTargetInfo'] = 0;
        }
        $this->template->load('agent_header', 'admin/dashboard/index', $data);
    }

    public function feeds_updater() {
        $data['feeds'] = get_feeds($this->session->userdata['user_info']['user_id']);
        echo $this->load->view('agent/ajax_view/feeds', $data, true);
    }

}
