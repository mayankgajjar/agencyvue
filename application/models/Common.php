<?php

class Common extends CI_Model {

    /**
     * @uses For get single agent's details
     * @param $user_id Need to pass user ID ( user master table ) 
     * @author HAD
     */
    function get_single_agent($user_id) {
        $table = 'crm_user_tbl';

        $options = array(
            'JOIN' => array(
                array(
                    'table' => 'crm_broker_personal',
                    'condition' => 'crm_broker_personal.user_id = crm_user_tbl.user_id',
                    'type' => 'FULL'
                ),
                array(
                    'table' => 'crm_broker_business',
                    'condition' => 'crm_broker_business.user_id = crm_user_tbl.user_id',
                    'type' => 'FULL'
                ),
                array(
                    'table' => 'crm_broker_commision',
                    'condition' => 'crm_broker_commision.user_id = crm_user_tbl.user_id',
                    'type' => 'FULL'
                )
            ),
            'conditions' => array(
                "crm_user_tbl.user_id" => $user_id
            )
        );

        $user_arr = get_relation($table, $options);
        return $user_arr[0];
    }

    function get_all_state() {
        $table = 'crm_states';
        $options = array("ORDER BY" => array("field" => "state", "order" => 'ASC'));
        $all_state = get_relation($table, $options);
        return $all_state;
    }

    function get_all_vendors() {
        $table = 'crm_vendor_primary';
        $options = array("fields" => array("vendor_id", "vendor_name"), "ORDER BY" => array("field" => "vendor_name", "order" => 'ASC'));
        $all_vendor = get_relation($table, $options);
        return $all_vendor;
    }

}
