<?php

class Verification_script extends CI_Model {

    public function get_verification_script($sLimit, $sWhere = "", $sOrder) {
        $table = 'crm_state_verification_script';
        $options = array(
            'conditions' => array(
                "crm_state_verification_script.is_active" => 'YES'
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

        $user_arr = get_relation($table, $options);
        return $user_arr;
    }

    public function get_verification_script_count($sWhere) {
        $table = 'crm_state_verification_script';
        $options = array(
            'fields' => array(
                'count(*) as total'
            ),
            'conditions' => array(
                "crm_state_verification_script.is_active" => 'YES'
            ),
        );

        if (strlen($sWhere) > 0) {
            $options['conditions']['or'] = $sWhere;
        }

        $user_count = get_relation($table, $options);
        return $user_count[0]['total'];
    }

    public function get_product_verification_script($sLimit, $sWhere = "", $sOrder) {
        $table = 'crm_select_product_verification_script as select_script';
        $options = array(
            'fields' => 'id,script_name,state_code,product_name,product.created_date',
            'JOIN' => array(
                array(
                    'table' => 'crm_products as product',
                    'condition' => 'product.global_product_id = select_script.global_product_id',
                    'type' => 'LEFT'
                ),
                array(
                    'table' => 'crm_state_verification_script as all_script',
                    'condition' => 'all_script.verification_script_id = select_script.verification_script_id',
                    'type' => 'LEFT'
                ),
            ),
            'conditions' => array(
                "select_script.status" => 'active'
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

        $user_arr = get_relation($table, $options);
        return $user_arr;
    }

    public function get_product_verification_script_count($sWhere) {
        $table = 'crm_select_product_verification_script as select_script';
        $options = array(
            'fields' => array(
                'count(*) as total'
            ),
            'JOIN' => array(
                array(
                    'table' => 'crm_products as product',
                    'condition' => 'product.global_product_id = select_script.global_product_id',
                    'type' => 'LEFT'
                ),
                array(
                    'table' => 'crm_state_verification_script as all_script',
                    'condition' => 'all_script.verification_script_id = select_script.verification_script_id',
                    'type' => 'LEFT'
                ),
            ),
            'conditions' => array(
                "select_script.status" => 'active'
            ),
        );

        if (strlen($sWhere) > 0) {
            $options['conditions']['or'] = $sWhere;
        }

        $user_count = get_relation($table, $options);
        return $user_count[0]['total'];
    }

    public function get_script_product_id($ProductID = null, $user_state = null) {
        if ($ProductID == null && $user_state == NULL) {
            return "Product ID ISSUE || ERROR";
        } else {
            $table = 'crm_select_product_verification_script as product_s';
            $options = array(
                'fields' => 'product_s.global_product_id,product_s.verification_script_id,script_p.script_html,script_p.state_code,script_p.is_active',
                'JOIN' => array(
                    array(
                        'table' => 'crm_state_verification_script as script_p',
                        'condition' => 'script_p.verification_script_id = product_s.verification_script_id',
                        'type' => 'FULL'
                    ),
                ),
                'conditions' => "product_s.global_product_id = $ProductID and script_p.is_active = 'YES'",
            );
            $script = get_relation($table, $options);
            if(count($script) <= 0){
                $table = 'crm_state_verification_script';
                $options = array(
                    'fields' => '*',
                    'conditions' => "crm_state_verification_script.verification_script_id  = 1 and crm_state_verification_script.is_active = 'YES'",
                );
                $script[] = get_relation($table, $options);
            }
            return $script;
        }
    }

}

?>