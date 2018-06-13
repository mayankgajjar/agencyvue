<?php

class Vendor extends CI_Model {

	public function get_vendors($sLimit, $sWhere="" ,$sOrder) {
        $table = 'crm_vendor_primary';
        $options = array(
        	'JOIN' => array(
                array(
                    'table' => 'crm_states',
                    'condition' => 'crm_vendor_primary.vendor_state = crm_states.state_code',
                    'type' => 'FULL'
                ),
            ),
            'conditions' => array(
              "crm_vendor_primary.is_deleted" => 'N'
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

        if(strlen($sWhere) > 0){
          $options['conditions']['or'] = $sWhere;
        }

        $user_arr = get_relation($table, $options);
        return $user_arr;
    }

    public function get_vendors_count($sWhere) {
        $table = 'crm_vendor_primary';
        $options = array(
            'fields' => array(
                'count(*) as total'
            ),
         	'JOIN' => array(
                array(
                    'table' => 'crm_states',
                    'condition' => 'crm_vendor_primary.vendor_state = crm_states.state_code',
                    'type' => 'FULL'
                ),
            ),
            'conditions' => array(
              	"crm_vendor_primary.is_deleted" => 'N'
            ), 
        );

        if(strlen($sWhere) > 0){
          $options['conditions']['or'] = $sWhere;
        }

        $user_count = get_relation($table, $options);
        return $user_count[0]['total'];
    }

    public function get_vendor_profile($vendor_id) {

        $table = 'crm_vendor_primary';
        $options = array(
            'JOIN' => array(
                array(
                    'table' => 'crm_vendor_payment_terms',
                    'condition' => 'crm_vendor_payment_terms.vendor_id = crm_vendor_primary.vendor_id',
                    'type' => 'FULL'
                ),
            ),
            'conditions' => array(
                "crm_vendor_primary.vendor_id" => $vendor_id
            )
        );

        $user_arr = get_relation($table, $options);
        return $user_arr;
    }

}
?>