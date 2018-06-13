<?php

class Product extends CI_Model {

    public function get_products($sLimit, $sWhere = "", $sOrder) {
        $table = 'crm_products as products';
        $options = array(
            'fields' => array(
                'products.global_product_id,
                products.product_status,
                products.product_id,
                products.plan_id,
                products.product_name,
                products.product_coverage,
                products.product_type,
                products.product_requires_license,
                count(states.state) as total_states'
            ),
            'JOIN' => array(
                array(
                    'table' => 'crm_product_state as states',
                    'condition' => 'products.global_product_id = states.global_product_id',
                    'type' => 'LEFT'
                ),
            ),
            'conditions' => array(
                "products.is_deleted" => 'N',
                "states.status" => 'active',
            ),
            'LIMIT' => array(
                "start" => $sLimit['start'],
                "end" => $sLimit['end']
            ),
            'ORDER_BY' => array(
                "field" => $sOrder['field'],
                "order" => $sOrder['order']
            ),
            'GROUP_BY' => array(
                "products.global_product_id"
            ),
        );
        if (strlen($sWhere) > 0) {
            $options['conditions']['or'] = $sWhere;
        }
        $products = get_relation($table, $options, FALSE);
        return $products;
    }

    public function get_products_count($sWhere) {
        $table = 'crm_products';
        $options = array(
            'fields' => array('count(*) as total'),
            'conditions' => array(
                "crm_products.is_deleted" => 'N'
            ),
        );

        if (strlen($sWhere) > 0) {
            $options['conditions']['or'] = $sWhere;
        }

        $product_count = get_relation($table, $options);
        return $product_count[0]['total'];
    }

    public function product_details($global_id) {

        $con = array('global_product_id' => $global_id, 'status' => 'active');

        $this->db->select('global_product_id,product_id,product_name,plan_id,product_price,product_type,product_coverage,product_pre_existing,product_status,product_requires_appointment,product_requires_license,
                            product_average_savings,product_network_size,product_benefits_type,product_image,product_enrollment_billing_rule,product_vendor,product_billing_rule,product_next_billing_date_rule,product_activation_date_rule,verification_script');
        $this->db->from('crm_products');
        $this->db->where('global_product_id', $global_id);
        $product_query = $this->db->get();
        $data['product_data'] = $product_query->row_array();

        $this->db->select('product_state_id,state');
        $this->db->from('crm_product_state');
        $this->db->where($con);
        $state_query = $this->db->get();
        $data['state_data'] = $state_query->result_array();

        $this->db->select('license_type_id,license_type');
        $this->db->from('crm_product_license_type');
        $this->db->where($con);
        $license_query = $this->db->get();
        $data['license_data'] = $license_query->result_array();

        $this->db->select('product_enrollment_fee,enrollment_fee');
        $this->db->from('crm_product_enrollment_fee');
        $this->db->where($con);
        $enrollment_query = $this->db->get();
        $data['enrollment_data'] = $enrollment_query->result_array();

        $this->db->where('global_product_id', $global_id);
        $age_weight_height_query = $this->db->get('crm_product_age_weight_height');
        $data['age_weight_height_data'] = $age_weight_height_query->row_array();

        return $data;
    }

    public function findproduct($state_id = null, $age = null, $zip = null, $weights = null) {

        if ($state_id == null || $dob = null) {
            exit('Not able to access method || find Product || State ID NULL ERROR');
        }
        $table = 'crm_product_state as states';
        if ($weights == null) {
            $options = array(
                'JOIN' => array(
                    array(
                        'table' => 'crm_products as products',
                        'condition' => 'states.global_product_id = products.global_product_id',
                        'type' => 'FULL'
                    ),
                    array(
                        'table' => 'crm_product_age_weight_height as weight',
                        'condition' => 'weight.global_product_id = states.global_product_id',
                        'type' => 'FULL'
                    ),
                ),
                'conditions' => array(
                    "weight.max_age >=" => $age,
                    "weight.min_age <=" => $age,
                    "states.state" => $state_id,
                    "products.is_deleted" => 'N',
                    "products.product_status" => 'active'
                ),
            );
        } elseif ($weights != null) {
            $options = array(
                'JOIN' => array(
                    array(
                        'table' => 'crm_products as products',
                        'condition' => 'states.global_product_id = products.global_product_id',
                        'type' => 'FULL'
                    ),
                    array(
                        'table' => 'crm_product_age_weight_height as weight',
                        'condition' => 'weight.global_product_id = states.global_product_id',
                        'type' => 'FULL'
                    ),
                ),
                'conditions' => array(
                    "weight.max_age >=" => $age,
                    "weight.min_age <=" => $age,
                    "states.state" => $state_id,
                    "weight.max_weight >=" => $weights,
                    "weight.min_weight <=" => $weights,
                    "products.is_deleted" => 'N',
                    "products.product_status" => 'active'
                ),
            );
        }

        $stateProducts = get_relation($table, $options, FALSE);
        return $stateProducts;
    }

    public function get_featured_product() {
        $where = array('setting_name' => 'featured_product');
        $fproduct = get_data('crm_settings_tbl', 1, $where);
        $fproductHTML = "";
        if (sizeof($fproduct) != 0) {
            $fproductHTML = $fproduct;
        } else {
            $fproductHTML = "Product Is Not Configured";
        }
        return $fproductHTML['setting_value'];
    }
    public function get_product_sale_count() {
        $table = 'crm_products';
        $options = array(
            'fields' => array(
                'count(*) as total'
            ),
            'conditions' => array(  
                "is_deleted" => 'N',
                "product_status"=>'active'
            )
        );

        $product_sale_count = get_relation($table, $options);
        return $product_sale_count[0]['total'];
    }


    function fetch_product_data($member_id){
        
        $this->db->from('crm_member_products as mproducts');
        $this->db->join('crm_products as products','mproducts.product_id = products.global_product_id');
        $this->db->where('mproducts.member_id',$member_id);
        $this->db->where('mproducts.is_status != "N"');
        $this->db->where('products.is_deleted','N');
        // $this->db->where('products.product_status','active');
        $data=$this->db->get()->result_array();
        return $data;
    }

    function filter_data(){
         $state_name = $this->input->post('state');
         $age = $this->input->post('age');
         $product_type = $this->input->post('producttype');
         $benifits_type = $this->input->post('benifitstype');
         $cost = $this->input->post('cost');
        

         $this->db->from('crm_product_state as states');
         $this->db->join('crm_products as products','states.global_product_id = products.global_product_id');
         $this->db->join('crm_product_age_weight_height as weight','weight.global_product_id = states.global_product_id');
         $this->db->where('weight.max_age >=',$age);
         $this->db->where('weight.min_age <=',$age);
         $this->db->where('states.state',$state_name);
         $this->db->where('products.is_deleted','N');
         $this->db->where('products.product_status','active');
         if($product_type != ''){
            $this->db->where_in('products.product_type',$product_type);
         }
         if($benifits_type != ''){
            $this->db->where_in('products.product_benefits_type',$benifits_type);
         }   
         if($cost != ''){
             foreach ($cost as $key => $value) {                
                 $arr = explode("_",$value);
                 if(count($arr) >= 2){
                    $this->db->where('products.product_price >=', $arr[0]);
                    $this->db->where('products.product_price <=', $arr[1]);
                 }else{
                    if($arr[0] == 100){
                        $this->db->where('products.product_price <=', $arr[0]);
                    }elseif($arr[0] == 1000){
                        $this->db->where('products.product_price >=', $arr[0]);
                    }
                 }

             }
         }

         $data=$this->db->get()->result_array();
         return $data;
    }

}
