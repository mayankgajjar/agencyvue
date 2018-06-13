<?php

class Product extends CI_Model {

    public function get($column) {
        $table = 'crm_products as products';
        $options = array(
            'fields' => array(
                "distinct($column)"
            )
        );

        $prod_arr = get_relation($table, $options);
        return $prod_arr;
    }

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
        $this->db->select('global_product_id,product_id,product_name,plan_id,product_price,product_type,product_category,product_coverage,product_pre_existing,product_status,product_requires_appointment,product_requires_license,
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
                "product_status" => 'active'
            )
        );

        $product_sale_count = get_relation($table, $options);
        return $product_sale_count[0]['total'];
    }

    function fetch_product_data($member_id) {
        $this->db->from('crm_member_products as mproducts');
        $this->db->join('crm_products as products', 'mproducts.product_id = products.global_product_id');
        $this->db->where('mproducts.member_id', $member_id);
        $this->db->where('mproducts.is_status != "N"');
        $this->db->where('products.is_deleted', 'N');
        // $this->db->where('products.product_status','active');
        $data = $this->db->get()->result_array();
        return $data;
    }

    function filter_data() {
        $state_name = $this->input->post('state');
        $age = $this->input->post('age');
        $product_type = $this->input->post('producttype');
        $benifits_type = $this->input->post('benifitstype');
        $cost = $this->input->post('cost');
        $this->db->from('crm_product_state as states');
        $this->db->join('crm_products as products', 'states.global_product_id = products.global_product_id');
        $this->db->join('crm_product_age_weight_height as weight', 'weight.global_product_id = states.global_product_id');
        $this->db->where('weight.max_age >=', $age);
        $this->db->where('weight.min_age <=', $age);
        $this->db->where('states.state', $state_name);
        $this->db->where('products.is_deleted', 'N');
        $this->db->where('products.product_status', 'active');
        if ($product_type != '') {
            $this->db->where_in('products.product_type', $product_type);
        }
        if ($benifits_type != '') {
            $this->db->where_in('products.product_benefits_type', $benifits_type);
        }
        if ($cost != '') {
            $sql_full = '';
            foreach ($cost as $key => $value) {
                $arr = explode("_", $value);
                if (count($arr) >= 2) {
                    $sql = "products.product_price BETWEEN ".$arr[0] ." AND " . $arr[1];
                    // $this->db->where('products.product_price >=', $arr[0]);
                    // $this->db->where('products.product_price <=', $arr[1]);
                } else {
                    if ($arr[0] == 100) {
                        $sql = " products.product_price <=".$arr[0];
                        //$this->db->where('products.product_price <=', $arr[0]);
                    } elseif ($arr[0] == 1000) {
                        $sql = " products.product_price >= ". $arr[0];
                      //  $this->db->where('products.product_price >=', $arr[0]);
                    }
                }
                $sql_full = $sql_full . $sql ;
                if (($key+1) < count($cost) AND count($cost) != 1)
                {
                    $sql_full = $sql_full . ' OR ';
                }
            }
            $sql_full = '( ' . $sql_full . ' )';     
            $this->db->where($sql_full);
        }
        $data = $this->db->get()->result_array();
      //  echo $this->db->last_query();
        return $data;
    }

    public function save_quick_product($data) {
        $this->db->set('product_vendor', $data['vendor_id']);
        $this->db->set('product_name', $data['product_name']);
        $this->db->set('product_price', $data['product_price']);
        $this->db->set('product_type', $data['product_type']);
        $this->db->set('product_category', $data['product_category']);
        $this->db->set('product_coverage', $data['coverage_type']);
        $this->db->set('agent_id', $data['agent_id']);
        $this->db->set('product_id', $data['product_id']);
        $this->db->insert('crm_products');
        return $this->db->insert_id();
    }

    public function save_quick_product_enroll_fee($fee, $global_product_id) {
        $this->db->set('global_product_id', $global_product_id);
        $this->db->set('enrollment_fee', $fee);
        $this->db->insert('crm_product_enrollment_fee');
        return $this->db->insert_id();
    }

    public function save_member_prodduct($data) {
        $member_id = $this->find_uid($data['member_id']);
        $this->db->set('product_id', $data['product_id']);
        $this->db->set('member_id', $member_id);
        $this->db->set('added_by', $data['added_by']);
        $this->db->insert('crm_member_products');
        return $this->db->insert_id();
    }

    public function find_uid($member_id) {
        $this->db->where('customer_id', $member_id);
        $query = $this->db->get('crm_lead_member_master');
        $ret = $query->row();
        return $ret->user_id;
    }

    public function get_categories($sLimit, $sWhere, $sOrder) {
        $table = 'crm_product_category';
        $options = array(
            'conditions' => array(
                "created_by" => $this->session->userdata('user_info')['user_id']
            ),
            'LIMIT' => array(
                "start" => $sLimit['start'],
                "end" => $sLimit['end']
            ),
            'ORDER_BY' => array(
                "field" => $sOrder['field'],
                "order" => $sOrder['order']
            )
        );
        if (strlen($sWhere) > 0) {
            $options['conditions']['or'] = $sWhere;
        }

        $categoriesArr = get_relation($table, $options);
        return $categoriesArr;
    }

    public function get_categoriesCount($sWhere) {
        $table = 'crm_product_category';
        $options = array(
            'fields' => array(
                'count(*) as total'
            ),
            'conditions' => array(
                "created_by" => $this->session->userdata('user_info')['user_id']
            ),
        );
        if (strlen($sWhere) > 0) {
            $options['conditions']['or'] = $sWhere;
        }

        $categoriesCount = get_relation($table, $options);
        return $categoriesCount[0]['total'];
    }

    public function get_product_types($sLimit, $sWhere, $sOrder) {
        $table = 'crm_product_type as type';
        $options = array(
            'fields' => array(
                'product_type_id',
                'type.product_category_id',
                'product_category_name',
                'product_type_name',
                'type.created_date'
            ),
            'JOIN' => array(
                array(
                    'table' => 'crm_product_category as category',
                    'condition' => 'type.product_category_id = category.product_category_id',
                    'type' => 'FULL'
                ),
            ),
            'conditions' => array(
                "type.created_by" => $this->session->userdata("user_info")["user_id"],
            ),
            'LIMIT' => array(
                "start" => $sLimit['start'],
                "end" => $sLimit['end']
            ),
            'ORDER_BY' => array(
                "field" => $sOrder['field'],
                "order" => $sOrder['order']
            ),
        );
        if (strlen($sWhere) > 0) {
            $options['conditions']['or'] = $sWhere;
        }

        $typesArr = get_relation($table, $options);
        return $typesArr;
    }

    public function get_typesCount($sWhere) {
        $table = 'crm_product_category as type';
        $options = array(
            'fields' => array(
                'count(*) as total'
            ),
            'JOIN' => array(
                array(
                    'table' => 'crm_product_category as category',
                    'condition' => 'type.product_category_id = category.product_category_id',
                    'type' => 'FULL'
                ),
            ),
            'conditions' => array(
                "type.created_by" => $this->session->userdata("user_info")["user_id"],
            ),
        );
        if (strlen($sWhere) > 0) {
            $options['conditions']['or'] = $sWhere;
        }

        $typeCount = get_relation($table, $options);
        return $typeCount[0]['total'];
    }

    public function get_coverageType($sLimit, $sWhere, $sOrder) {
        $table = 'crm_product_coverage_type';
        $options = array(
            'conditions' => array(
                "created_by" => $this->session->userdata('user_info')['user_id']
            ),
            'LIMIT' => array(
                "start" => $sLimit['start'],
                "end" => $sLimit['end']
            ),
            'ORDER_BY' => array(
                "field" => $sOrder['field'],
                "order" => $sOrder['order']
            )
        );
        if (strlen($sWhere) > 0) {
            $options['conditions']['or'] = $sWhere;
        }

        $cTypeArr = get_relation($table, $options);
        return $cTypeArr;
    }

    public function get_coverageTypeCount($sWhere) {
        $table = 'crm_product_coverage_type';
        $options = array(
            'fields' => array(
                'count(*) as total'
            ),
            'conditions' => array(
                "created_by" => $this->session->userdata('user_info')['user_id']
            ),
        );
        if (strlen($sWhere) > 0) {
            $options['conditions']['or'] = $sWhere;
        }

        $cTypeCount = get_relation($table, $options);
        return $cTypeCount[0]['total'];
    }

}
