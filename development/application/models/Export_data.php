<?php

class Export_data extends CI_Model {
    
    public function get_lead_data() {
        $table = 'crm_lead_member_primary';
        $options = array(
            'JOIN' => array(
                array(
                    'table' => 'crm_lead_member_master',
                    'condition' => 'crm_lead_member_master.customer_id = crm_lead_member_primary.customer_id',
                    'type' => 'LEFT'
                ),
                /*array(
                    'table' => 'crm_lead_member_spouse',
                    'condition' => 'crm_lead_member_spouse.customer_id = crm_lead_member_master.customer_id',
                    'type' => 'LEFT'
                ),*/
            ),
            'conditions' => array(
                "crm_lead_member_master.is_delete" => 'N',
                //"crm_lead_member_master.customer_id" => $customer_id
            )
        );

        $user_arr = get_relation($table, $options);
        return $user_arr;
    }
    
}
?>