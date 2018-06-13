<?php
class Checkout extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->model('common');
        $this->load->model('rawleadfilter_m');
        $this->data['lead_type'] = array(
            '2to30' => array(
                'name' => 'Medicare Supplement 2 To 30 Days Old',
                '249' => 2.00,
                '999' => 1.50,
                '4999' => 1.20,
                '9999' => 1.00,
                '24999' => 0.75,
                '25000' => 0.60,
            ),

            '31to85' => array(
                'name' => 'Medicare Supplement 31 To 85 Days Old',
                '249' => 1.50,
                '999' => 1.20,
                '4999' => 1.00,
                '9999' => 0.75,
                '24999' => 0.60,
                '25000' => 0.40,
            ),

            '86to365' => array(
                'name' => 'Medicare Supplement 86 To 365 Days Old',
                '249' => 0.40,
                '999' => 0.40,
                '4999' => 0.30,
                '9999' => 0.25,
                '24999' => 0.15,
                '25000' => 0.12,
            ),

            '366+' => array(
                'name' => 'Medicare Supplement 366+ Days Old',
                '249' => 0.25,
                '999' => 0.25,
                '4999' => 0.20,
                '9999' => 0.15,
                '24999' => 0.12,
                '25000' => 0.10,
            )

        );

    }

    public function filter(){

        $post = $this->input->post();
        if(empty($post)){
            redirect("agent/campaign/index", "refresh");
        }
        $data['title'] = 'Lead Filter';
        $data['type'] = $post['leadtype'];
        $this->session->set_userdata('lead_type', $post['leadtype']);
        $data['state_result'] = $this->common->get_all_state();
        $this->template->load('agent_header', 'agent/leadstore/checkout/filter', $data);

    }

    public function filterPost() {
        $this->load->model('templeadconvert_m');
        $post = $this->input->post();
        if ($post && $post['is_ajax'] == true) {
            unset($post['is_ajax']);
            $this->data['post'] = $post;
            if ($post['min_age'] != "None") {
                $minage = $post['min_age'];
            }
            if ($post['max_age'] != "None") {
                $max_age = $post['max_age'];
            }
            if ($post['filter_by_zip_code'] == "YES") {
                $zip_list = '';
                $zip_li = '';
                $zipcode = rtrim($post['filter_by_zip_codes'], ',');
                $zip = explode(",", $zipcode);
                foreach ($zip as $zips) {
                    $zip_li .= "'" . $zips . "',";
                }
                $zip_list = rtrim($zip_li, ',');
            }
            if ($post['filter_by_area_code'] != "none") {
                $area_code = $post['filter_by_area_code'];
                $filter_area_state_code = explode(",", $post['filter_by_area_codes']);
                $city = [];
                foreach ($filter_area_state_code as $value) {
                    $city_query = "SELECT GROUP_CONCAT(CONCAT('\"',city,'\"')) as city FROM `crm_state_city_area` WHERE `area_code`=" . $value . "";
                    $city_list_query = $this->db->query($city_query);
                    $city_list = $city_list_query->row_array();
                    $clist = explode(',', $city_list['city']);
                    foreach ($clist as $cl) {
                        $city_array[] = $cl;
                    }
                }
                $city_str01 = implode(",", $city_array);
                $city_str02 = $city_str01;
                $city_str = rtrim($city_str02, ',');
            }

            if (!empty($post['state_code'])) {
                $state_list = '';
                $states = '';
                foreach ($post['state_code'] as $state) {
                    $states .= "'" . $state . "',";
                }
                $state_list = rtrim($states, ',');
            }

            $sql = " 1 > 0 ";
            /* filter for category raw or aged lead */
            if (isset($post['category'])) {
                $sql .= " AND lead_type LIKE '{$post['category']}'";
            }

            if (isset($post['ltype'])) {
                if ($post['ltype'] == '2to30') {
                    $sql .= " AND `raw_created` BETWEEN DATE_SUB(DATE(NOW()), INTERVAL 30 DAY) AND DATE_SUB(DATE(NOW()), INTERVAL 2 DAY)";
                } else if ($post['ltype'] == '31to85') {
                    $sql .= " AND `raw_created` BETWEEN DATE_SUB(DATE(NOW()), INTERVAL 85 DAY) AND DATE_SUB(DATE(NOW()), INTERVAL 31 DAY)";
                } else if ($post['ltype'] == '86to365') {
                    $sql .= " AND `raw_created` BETWEEN DATE_SUB(DATE(NOW()), INTERVAL 365 DAY) AND DATE_SUB(DATE(NOW()), INTERVAL 86 DAY)";
                } else if ($post['ltype'] == '366+') {
                    $sql .= " AND `raw_created` >= DATE_SUB(DATE(NOW()), INTERVAL 365 DAY)";
                }
            }

            if (isset($zip)) {
                $sql .= " AND customer_zipcode IN(" . $zip_list . ")";
            }

            if (isset($state_list)) {
                $sql .= " AND customer_state IN(" . $state_list . ")";
            }

            if (isset($minage) && $minage > 0) {
                $sql .= " AND DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), customer_dob)), '%Y')+0 >='" . $minage . "'";
            }

            if (isset($max_age) && $max_age > 0) {
                $sql .= " AND DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), customer_dob)), '%Y')+0 <='" . $max_age . "'";
            }

            if (isset($area_code)) {
                if ($area_code == 'filter_area_include') {
                    $sql .= " AND customer_city IN(" . $city_str . ")";
                }

                if ($area_code == 'filter_area_exclude') {
                    $sql .= " AND customer_city NOT IN(" . $city_str . ")";
                }
            }

            /* ------------ For Check ids not available in the session list -------------- */

            $ids = '';
            if ($this->session->userdata('lead_cart') != '' && count($this->session->userdata('lead_cart')) > 0) {
                foreach ($this->session->userdata('lead_cart') as $key => $cart_data) {
                    if ($cart_data['lead_ids'] != '') {
                        $ids .= $cart_data['lead_ids'] . ",";
                    }
                }
            }

            $temp_data = $this->templeadconvert_m->get_by(['agent_id' => $this->session->userdata("agent_primary")['broker_id'], 'status' => 'true']);
            if ($temp_data != '' && count($temp_data) > 0) {
                foreach ($temp_data as $key => $temp_cart_data) {
                    if ($temp_cart_data->lead_ids != '') {
                        $ids .= $temp_cart_data->lead_ids . ",";
                    }
                }
            }

            if ($ids != '') {
                $ids = rtrim($ids, ",");
                $ids = explode(",", $ids);
                $sql .= " AND (";
                $lead_ids_chunk = array_chunk($ids, 1000);
                foreach ($lead_ids_chunk as $k => $chnk) {
                    $str = implode(",", $chnk);
                    if ($k == 0) {
                        $sql .= "member_primary_id NOT IN(" . $str . ")";
                    } else {
                        $sql .= " and member_primary_id NOT IN(" . $str . ")";
                    }
                }
                $sql .= ")";
            }

            $sql .= " AND broker_id=0";
            /* ------------ For Check ids not available in the session list -------------- */
            $data = get_relation('crm_lead_member_primary', array('fields' => 'count(member_primary_id) AS Total', 'conditions' => $sql, 'JOIN' => array( array('table' => 'crm_lead_member_master','condition' => "crm_lead_member_master.customer_id = crm_lead_member_primary.customer_id", 'type' => 'INNER'))));
            $this->data['filterData'] = $data[0];
            $html = $this->load->view('agent/leadstore/checkout/filter-result', $this->data, true);
            $output['success'] = true;
            //$output['data'] = $post;
            $output['html'] = $html;
        } else {
            $output['success'] = false;
            $output['data'] = '';
        }

        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));

    }



    public function saveFilter() {
        $post = $this->input->post();
        if ($post && $post['is_ajax'] == true) {
            unset($post['is_ajax']);
            $filterId = isset($post['filter_id']) && $post['filter_id'] > 0 ? $post['filter_id'] : NULL;
            unset($post['filter_id']);
            $data = array(
                'agent_id' => $this->session->userdata('agent_primary')['broker_id'],
                'filter_value' => serialize($post)
            );
            $id = $this->rawleadfilter_m->save($data, $filterId);
            if ($id) {
                $output['success'] = true;
                $output['data'] = $id;
                $html = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Filter saved successfully.</div>';
                $output['html'] = $html;
            } else {
                $output['success'] = false;
                $html = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> Something went wrong.</div>';
                $output['html'] = $html;
            }
        } else {
            $output['success'] = false;
            $html = '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> Something went wrong.</div>';
            $output['html'] = $html;
        }
        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));

    }

    public function cart()
    {
        $this->data['title'] = 'Aged Lead Insuarance | Cart';
        $this->data['breadcrumb'] = 'cart';
        $this->data['pagetitle'] = 'Shopping Cart';
        $this->template->load('agent_header', 'agent/leadstore/checkout/cart', $this->data);
    }

    public function add_to_cart_lead() 
    {
        $lead_cart = array();
        if($this->session->userdata('copy_cart_item') != '' && count($this->session->userdata('copy_cart_item')) > 0){
            $lead_cart[0] = $this->session->userdata('copy_cart_item');
            $lead_ids = $this->fetch_item($this->session->userdata('copy_cart_item'));
            $this->session->unset_userdata('copy_cart_item');
        } else {
            $lead_cart[0] = $_POST;
            $lead_ids = $this->fetch_item($_POST);
        }
        $lead_price = $this->get_item_price($lead_cart[0]['ltype'], $lead_cart[0]['quantity']);

        $lead_cart[0]['lead_ids'] = $lead_ids;
        $lead_cart[0]['lead_price'] = $lead_price;
        $lead_cart[0]['sub_total'] = $lead_price * $lead_cart[0]['quantity'];

        if ($this->session->userdata('lead_cart') != '') {
            $lead_data = $this->session->userdata('lead_cart');
            $lead_cart1 = array_merge($lead_data, $lead_cart);
            if(isset($ststus) && $status == null){
                foreach ($lead_data as $key => $oa) {
                    if ($lead_cart[0]['ltype'] == $oa['ltype'] && $lead_cart[0]['state_code'] == $oa['state_code'] && $lead_cart[0]['min_age'] == $oa['min_age'] && $lead_cart[0]['max_age'] == $oa['max_age'] && $lead_cart[0]['filter_by_area_code'] == $oa['filter_by_area_code'] && $lead_cart[0]['filter_by_zip_code'] == $oa['filter_by_zip_code'] && $lead_cart[0]['cell_phone_land_line'] == $oa['cell_phone_land_line'] && $lead_cart[0]['category'] == $oa['category']) {
                        unset($lead_cart1[$key]);
                    }
                }
                $lead_cart1 = array_values($lead_cart1);
                $this->session->set_userdata('lead_cart', $lead_cart1);
            } else {
                $this->session->set_userdata('lead_cart', $lead_cart);
            }
        } else {
            $this->session->set_userdata('lead_cart', $lead_cart);
        }
        redirect('agent/checkout/cart');
    }

  public function fetch_item($data) 
  {
        $this->load->model('templeadconvert_m');
        $post = $data;
        if ($post['min_age'] != "None") {
            $minage = $post['min_age'];
        }

        if ($post['max_age'] != "None") {
            $max_age = $post['max_age'];
        }

        if ($post['filter_by_zip_code'] == "YES") {
            $zip_list = '';
            $zip_li = '';
            $zipcode = rtrim($post['filter_by_zip_codes'], ',');
            $zip = explode(",", $zipcode);
            foreach ($zip as $zips) {
                $zip_li .= "'" . $zips . "',";
            }
            $zip_list = rtrim($zip_li, ',');
        }

        if ($post['filter_by_area_code'] != "none") {
            $area_code = $post['filter_by_area_code'];
            $filter_area_state_code = explode(",", $post['filter_by_area_codes']);
            $city = [];
            foreach ($filter_area_state_code as $value) {
                $city_query = "SELECT GROUP_CONCAT(CONCAT('\"',city,'\"')) as city FROM `crm_state_city_area` WHERE `area_code`=" . $value . "";
                $city_list_query = $this->db->query($city_query);
                $city_list = $city_list_query->row_array();
                $clist = explode(',', $city_list['city']);
                foreach ($clist as $cl) {
                    $city_array[] = $cl;
                }
            }

            $city_str01 = implode(",", $city_array);
            $city_str02 = $city_str01;
            $city_str = rtrim($city_str02, ',');
        }
        if (!empty($post['state_code'])) {
            $state_list = '';
            $states = '';
            $list_state = explode(",", $post['state_code']);
            foreach ($list_state as $state) {
                $states .= "'" . $state . "',";
            }
            $state_list = rtrim($states, ',');
        }

        $sql = " 1 > 0 ";
        /* filter for category raw or aged lead */

        if (isset($post['category'])) {
            $sql .= " AND lead_type LIKE '{$post['category']}'";
        }

        if (isset($post['ltype'])) {

            if ($post['ltype'] == '2to30') {
                $sql .= " AND `raw_created` BETWEEN DATE_SUB(DATE(NOW()), INTERVAL 30 DAY) AND DATE_SUB(DATE(NOW()), INTERVAL 2 DAY)";
            } else if ($post['ltype'] == '31to85') {
                $sql .= " AND `raw_created` BETWEEN DATE_SUB(DATE(NOW()), INTERVAL 85 DAY) AND DATE_SUB(DATE(NOW()), INTERVAL 31 DAY)";
            } else if ($post['ltype'] == '86to365') {
                $sql .= " AND `raw_created` BETWEEN DATE_SUB(DATE(NOW()), INTERVAL 365 DAY) AND DATE_SUB(DATE(NOW()), INTERVAL 86 DAY)";
            } else if ($post['ltype'] == '366+') {
                $sql .= " AND `raw_created` >= DATE_SUB(DATE(NOW()), INTERVAL 365 DAY)";
            }

        }

        if (isset($zip)) {
            $sql .= " AND customer_zipcode IN(" . $zip_list . ")";
        }

        if (isset($state_list)) {
            $sql .= " AND customer_state IN(" . $state_list . ")";
        }

        if (isset($minage) && $minage > 0) {
            $sql .= " AND DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), customer_dob)), '%Y')+0 >='" . $minage . "'";
        }

        if (isset($max_age) && $max_age > 0) {
            $sql .= " AND DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), customer_dob)), '%Y')+0 <='" . $max_age . "'";
        }

        if (isset($area_code)) {
            if ($area_code == 'filter_area_include') {
                $sql .= " AND customer_city IN(" . $city_str . ")";
            }
            if ($area_code == 'filter_area_exclude') {
                $sql .= " AND customer_city NOT IN(" . $city_str . ")";
            }
        }

        /* ------------ For Check ids not available in the session list -------------- */

        $ids = '';

        if ($this->session->userdata('lead_cart') != '' && count($this->session->userdata('lead_cart')) > 0) {
            $data = $this->session->userdata('lead_cart');
            if(!isset($data['submit'])){
               unset($data);
               $data[0] = $this->session->userdata('lead_cart');
            }
            foreach ($data as $key => $cart_data) {
                if (isset($cart_data['lead_ids']) && $cart_data['lead_ids'] != '') {
                    $ids .= $cart_data['lead_ids'] . ",";
                }
            }
        }

        $temp_data = $this->templeadconvert_m->get_by(['agent_id' => $this->session->userdata("agent_primary")['broker_id'], 'status' => 'true']);
        if ($temp_data != '' && count($temp_data) > 0) {
            foreach ($temp_data as $key => $temp_cart_data) {
                if ($temp_cart_data->lead_ids != '') {
                    $ids .= $temp_cart_data->lead_ids . ",";
                }
            }
        }

        if ($ids != '') {

            $ids = rtrim($ids, ",");
            $ids = explode(",", $ids);
            $sql .= " AND (";
            $lead_ids_chunk = array_chunk($ids, 1000);
            foreach ($lead_ids_chunk as $k => $chnk) {
                $str = implode(",", $chnk);
                if ($k == 0) {
                    $sql .= "member_primary_id NOT IN(" . $str . ")";
                } else {
                    $sql .= " and member_primary_id NOT IN(" . $str . ")";
                }
            }
            $sql .= ")";
        }

        /* ------------ For Check ids not available in the session list -------------- */

        $limitArray = array();
        $limitArray['end'] = 1;
        $limitArray['start'] = $post['quantity'];
        $ORDER_BY = array();
        $ORDER_BY['field'] = 'rand()';
        $sql .= " AND broker_id=0";
        $data = get_relation('crm_lead_member_primary', array('fields' => 'member_primary_id', 'conditions' => $sql, 'JOIN' => array( array('table' => 'crm_lead_member_master','condition' => "crm_lead_member_master.customer_id = crm_lead_member_primary.customer_id", 'type' => 'INNER')) ,'LIMIT' => $limitArray, 'ORDER' => $ORDER_BY));
        $array = array_column($data, 'member_primary_id');
        $str = implode(",", $array);
        return $str;

    }

    public function get_item_price($ltype, $qty) {

        $lead_type_data = $this->data['lead_type'][$ltype];
        $item_price = 0;
        if ($qty < 250) {
            $item_price = $lead_type_data['249'];
        } elseif ($qty >= 250 && $qty <= 999) {
            $item_price = $lead_type_data['999'];
        } elseif ($qty >= 1000 && $qty <= 4999) {
            $item_price = $lead_type_data['4999'];
        } elseif ($qty >= 5000 && $qty <= 9999) {
            $item_price = $lead_type_data['9999'];
        } elseif ($qty >= 10000 && $qty <= 24999) {
            $item_price = $lead_type_data['24999'];
        } elseif ($qty >= 25000) {
            $item_price = $lead_type_data['25000'];
        }

        return $item_price;
    }

    public function ajax_cart() {
        $this->data['test'] = 'Checkout';
        echo $this->load->view("agent/leadstore/checkout/cart_table", $this->data, TRUE);
    }

    public function remove_item_list() {
        foreach ($this->input->post('cart_id') as $id) {
            unset($_SESSION['lead_cart'][$id]);
        }
        array_values($_SESSION['lead_cart']);
        echo true;
    }

    public function continue_shop() {
        $this->session->set_flashdata('conti_shop', 'yes');
        // For open popup according to category wise.
        $data = $this->session->userdata('lead_cart') ? $this->session->userdata('lead_cart') : array();
        $last_cart = end($data);
        $this->session->set_flashdata('conti_cat',$last_cart['category']);
        redirect('agent/campaign/index');
    }

    public function filename($itemJson = "") {
        $itemJson = $_REQUEST['items'];
        if ($itemJson != "") {
            $itemJson = json_decode($itemJson);
            $leadCart = $this->session->userdata('lead_cart');
            if (count($leadCart) > 0) {
                foreach ($leadCart as $key => $cartItem) {
                    $leadCart[$key]['filename'] = $itemJson[$key]->file_name;
                    $this->session->set_userdata('lead_cart', $leadCart);
                }
            }
            $returnType = $itemJson[0]->req_type;
            if ($returnType == 'checkout') {
                echo 'checkout';
            } elseif ($returnType == 'continue') {
                echo 'continue';
            } else {
                echo 'true';
            }
        }
    }

    public function getAreaCode() {

        $state = $this->input->post('state');
        $this->db->group_by('area_code');
        $this->db->where('state_code', $state);
        $area_code_query = $this->db->get('crm_state_city_area');
        $data = $area_code_query->result_array();
        if (!empty($data)) {
            foreach ($data as $state) {
                echo "<div class='col-sm-3'><div class='col-sm-2'><input type='checkbox' class='state-chk' name='filter_area_state_code[]' value='" . $state['area_code'] . "'></div>
                <div class='col-sm-10'>" . $state['area_code'] . "</div></div>";
            }
        }
    }

    public function getCounty() {
        $post = $this->input->post();
        if ($post && $post['is_ajax']) {
            unset($post['is_ajax']);
            // $url = 'http://api.sba.gov/geodata/county_links_for_state_of/'.$post['state'].'.json';
            $stmt = "SELECT distinct(county) as name FROM crm_city_zipcodes WHERE state='" . $post['state'] . "'";
            $query = $this->db->query($stmt);
            $data = $query->result_array();
            return $this->output
                            ->set_content_type('application/json')
                            ->set_output(json_encode($data));
        }
    }

    public function getCity() {
        $post = $this->input->post();
        if ($post && $post['is_ajax']) {
            unset($post['is_ajax']);
            //http://api.sba.gov/geodata/all_links_for_county_of/COUNTY_NAME/STATE_ABBREVIATION.FORMAT
            //$url = 'http://api.sba.gov/geodata/all_links_for_county_of/'.urlencode($post['county']).'/'.$post['state'].'.json';
            $stmt = "SELECT distinct(county), city as name FROM crm_city_zipcodes WHERE county='" . $post['county'] . "' AND state='" . $post['state'] . "'";
            $query = $this->db->query($stmt);
            $data = $query->result_array();
            return $this->output
                            ->set_content_type('application/json')
                            ->set_output(json_encode($data));
        }

    }

    public function getZip() {
        $post = $this->input->post();
        if ($post && $post['is_ajax']) {
            unset($post['is_ajax']);
            //$url = 'https://www.zipcodeapi.com/rest/DyXqchM5R2YWFXjFn4i5V0f2bwzVSoCvXzW9RJfILeErbY6z3pEYqU0CrzxjYaPV/city-zips.json/'.urlencode($post['city']).'/'.$post['state'];

            //$data = file_get_contents($url);
            $stmt = "SELECT zip_code FROM crm_city_zipcodes WHERE city='" . $post['city'] . "' AND county='" . $post['county'] . "' AND state='" . $post['state'] . "'";
            $query = $this->db->query($stmt);
            $data = $query->row_array();
            $data = array_values($data);
            return $this->output
                            ->set_content_type('application/json')
                            ->set_output(json_encode(array('zip' => implode(',', $data))));
        }

    }

    public function getZipByRadius() {
        $post = $this->input->post();
        if ($post && $post['is_ajax']) {
            unset($post['is_ajax']);
            $url = "http://www.zipcodeapi.com/rest/Xav11UF7ePQaAkmwqil0N1PKdw9e1lGYwb0x5FFjvvu6QQCg9YhWZ7GcEQrFc7EI/radius.json/" . urlencode($post['zipcode']) . "/" . urlencode($post['miles']) . "/miles?minimal";
            $data = file_get_contents($url);
            $data = json_decode($data);
            return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode(array('zip' => implode(',', $data->zip_codes))));
        }

    }
    public function getZipByScf() {
        $post = $this->input->post();
        if ($post && $post['is_ajax']) {
            unset($post['is_ajax']);
            $stmt = "SELECT GROUP_CONCAT(zip_code) as string FROM `crm_city_zipcodes` WHERE zip_code like '" . $post['scf'] . "%'";
            $query = $this->db->query($stmt);
            $data = $query->row_array();
            return $this->output
                            ->set_content_type('application/json')
                            ->set_output(json_encode(array('zip' => $data['string'])));
        }

    }

}

