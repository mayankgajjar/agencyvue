<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * Model for Target Setting activity Table name 'crm_agent_target'
 */

/**
 * Description of Target
 *
 * @author dhareen
 */
class Target extends CI_Model {

    /**
     * @uses Get Members Target Array
     */
    public function get_members_target() {
        $membersOptions = array(
            'conditions' => array(
                'target_type' => 'members',
                'agent_id' => $this->session->userdata['user_info']['user_id']
            ),
            'LIMIT' => array(
                'start' => '1',
                'end' => '0'
            ),
            'ORDER_BY' => array(
                'field' => 'id',
                'order' => 'DESC'
            ),
        );
        $memberArray = get_relation('crm_agent_target', $membersOptions);
        if (!empty($memberArray)) {
            return $memberArray[0];
        }
    }

    /**
     * @uses Get Commission Target Array
     */
    public function get_commission_target() {
        $commissionOptions = array(
            'conditions' => array(
                'target_type' => 'commission',
                'agent_id' => $this->session->userdata['user_info']['user_id']
            ),
            'LIMIT' => array(
                'start' => '1',
                'end' => '0'
            ),
            'ORDER_BY' => array(
                'field' => 'id',
                'order' => 'DESC'
            ),
        );
        $commissionArray = get_relation('crm_agent_target', $commissionOptions);
        if (!empty($commissionArray)) {
            return $commissionArray[0];
        }
    }

    /**
     * @uses Get Premium Target Array
     */
    public function get_premium_target() {
        $premiumOptions = array(
            'conditions' => array(
                'target_type' => 'premium',
                'agent_id' => $this->session->userdata['user_info']['user_id']
            ),
            'LIMIT' => array(
                'start' => '1',
                'end' => '0'
            ),
            'ORDER_BY' => array(
                'field' => 'id',
                'order' => 'DESC'
            ),
        );
        $premiumArray = get_relation('crm_agent_target', $premiumOptions);
        if (!empty($premiumArray)) {
            return $premiumArray[0];
        }
    }

}
