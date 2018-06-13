<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Broker extends CI_Model {
    /*

     * Get All unaproved brokers

     */

    public function get_unaproved_brokers($sLimit, $sWhere = "", $sOrder) {
        $table = 'crm_broker_personal as u';
        $options = array(
            'fields' => array(
                'u.first_name,
                u.last_name,
                n.email,
                u.personal_city,
                u.personal_state,
                n.user_id,
                n.created_date,
                u.parent_id,
                master.display_name'
            ),
            'JOIN' => array(
                array(
                    'table' => 'crm_user_tbl as n',
                    'condition' => 'u.user_id = n.user_id',
                    'type' => 'FULL'
                ),
                array(
                    'table' => 'crm_user_tbl as master',
                    'condition' => 'u.parent_id = master.user_id',
                    'type' => 'LEFT'
                ),
            ),
            'conditions' => array(
                "n.is_approved" => 'NA',
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

        $user_arr = get_relation($table, $options, FALSE);
//        echo $this->db->last_query();
        return $user_arr;
    }

    public function get_unaproved_brokers02() {
        $table = 'crm_broker_personal as personal';
    }

    public function get_broker_profile($user_id) {

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
        return $user_arr;
    }

    public function get_unaproved_brokers_count($sWhere) {

        $table = 'crm_user_tbl as n';

        $options = array(
            'fields' => array(
                'count(*) as total'
            ),
            'JOIN' => array(
                array(
                    'table' => 'crm_broker_personal as u',
                    'condition' => 'u.user_id = n.user_id',
                    'type' => 'FULL'
                ),
            ),
            'conditions' => array(
                "n.is_approved" => 'NA'
            )
        );

        if (strlen($sWhere) > 0) {
            $options['conditions']['or'] = $sWhere;
        }

        $user_count = get_relation($table, $options);

        return $user_count[0]['total'];
    }

    public function get_aproved_brokers_count($sWhere) {

        $table = 'crm_broker_personal b';

        $options = array(
            'fields' => array(
                'count(*) as total'
            ),
            'JOIN' => array(
                array(
                    'table' => 'crm_user_tbl u',
                    'condition' => 'b.user_id = u.user_id',
                    'type' => 'FULL'
                ),
                array(
                    'table' => 'crm_user_tbl u1',
                    'condition' => 'b.parent_id = u1.user_id',
                    'type' => 'FULL'
                ),
                array(
                    'table' => 'crm_states state',
                    'condition' => 'b.personal_state = state.state_code',
                    'type' => 'LEFT'
                ),
            ),
            'conditions' => array(
                "u.is_approved" => 'Y',
                "u.is_deleted" => 'N'
            )
        );

        if (strlen($sWhere) > 0) {
            $options['conditions']['or'] = $sWhere;
        }

        $user_count = get_relation($table, $options);

        return $user_count[0]['total'];
    }

    /**
     * @uses Getting all approved brokers list
     * @author HAD
     */
    public function get_all_approved_brokers($sLimit, $sWhere = "", $sOrder) {
        $table = 'crm_broker_personal b';
        $options = array(
            'fields' => array(
                'b.parent_id',
                'CONCAT(b.first_name," ",b.last_name) as broker_name',
                'b.first_name',
                'b.last_name',
                'b.personal_city',
                'b.personal_state',
                'b.user_id',
                'u.email',
                'u.display_name',
                'u.created_date',
                'u1.display_name as parent_name',
                'state.state as state_name'
            ),
            'JOIN' => array(
                array(
                    'table' => 'crm_user_tbl u',
                    'condition' => 'b.user_id = u.user_id',
                    'type' => 'FULL'
                ),
                array(
                    'table' => 'crm_user_tbl u1',
                    'condition' => 'b.parent_id = u1.user_id',
                    'type' => 'FULL'
                ),
                array(
                    'table' => 'crm_states state',
                    'condition' => 'b.personal_state = state.state_code',
                    'type' => 'LEFT'
                ),
            ),
            'conditions' => array(
                "u.is_approved" => 'Y',
                "u.is_deleted" => 'N',
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

        $user_arr = get_relation($table, $options, FALSE);
        return $user_arr;
    }

    /* @anp: update Record. */

    public function update($table, $condition, $user_array) {
        $this->db->where($condition);
        if ($this->db->update($table, $user_array)) {
            return 1;
        } else {
            return 0;
        }
    }

    public function get_agent_brokers($sLimit, $sWhere = "", $sOrder) {
        $table = 'crm_user_tbl';
        $options = array(
            'fields' => '*,crm_user_tbl.is_approved, crm_user_tbl.user_id as broker_user_id, CONCAT(crm_broker_personal.first_name," ",crm_broker_personal.last_name) as broker_name',
            'JOIN' => array(
                array(
                    'table' => 'crm_broker_personal',
                    'condition' => 'crm_broker_personal.user_id = crm_user_tbl.user_id',
                    'type' => 'FULL'
                ),
            ),
            'conditions' => array(
                "crm_user_tbl.is_deleted" => 'N',
                "crm_broker_personal.parent_id" => $this->session->userdata['user_info']['user_id'],
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

    public function get_agent_brokers_count($sWhere) {

        $table = 'crm_user_tbl';

        $options = array(
            'fields' => array(
                'count(*) as total'
            ),
            'JOIN' => array(
                array(
                    'table' => 'crm_broker_personal',
                    'condition' => 'crm_broker_personal.user_id = crm_user_tbl.user_id',
                    'type' => 'FULL'
                ),
            ),
            'conditions' => array(
                "crm_user_tbl.is_deleted" => 'N',
                "crm_broker_personal.parent_id" => $this->session->userdata['user_info']['user_id'],
            ),
        );

        if (strlen($sWhere) > 0) {
            $options['conditions']['or'] = $sWhere;
        }

        $user_count = get_relation($table, $options);
        return $user_count[0]['total'];
    }

    /**
     *
     * @users Get All Approve User
     * @author RRA
     */
    public function get_approveuser_count() {
        $table = 'crm_user_tbl';
        $options = array(
            'fields' => array(
                'count(*) as total'
            ),
            'conditions' => array(
                "roll_id" => 2,
                "is_approved" => 'Y',
                "is_deleted" => 'N'
            )
        );
        $broker_count = get_relation($table, $options);
        return $broker_count[0]['total'];
    }

    /**
     *
     * @users Get All UnApprove User
     * @author RRA
     */
    public function get_unapproveuser_count() {
        $table = 'crm_user_tbl';
        $options = array(
            'fields' => array(
                'count(*) as total'
            ),
            'conditions' => array(
                "roll_id" => 2,
                "is_approved" => 'NA',
                "is_deleted" => 'N'
            )
        );

        $broker_count = get_relation($table, $options);
        return $broker_count[0]['total'];
    }

    public function getdownlineMembers($userID) {
        $table = 'crm_lead_member_master';
        $options = array(
            'fields' => 'crm_user_tbl.user_id,crm_user_tbl.display_name',
            'JOIN' => array(
                array(
                    'table' => 'crm_user_tbl',
                    'condition' => 'crm_user_tbl.user_id = crm_lead_member_master.customer_id',
                    'type' => 'LEFT'
                )
            ),
            'conditions' => array(
                "crm_user_tbl.is_deleted" => 'N',
                "crm_lead_member_master.broker_id" => $userID,
            ),
        );
        $downMembers = get_relation($table, $options, FALSE);
        return $downMembers;
    }

    public function getdownlineEmployers($userID) {
        $table = 'crm_employers_primary';
        $options = array(
            'fields' => 'crm_user_tbl.user_id,crm_user_tbl.display_name',
            'JOIN' => array(
                array(
                    'table' => 'crm_user_tbl',
                    'condition' => 'crm_user_tbl.user_id = crm_employers_primary.user_id',
                    'type' => 'LEFT'
                )
            ),
            'conditions' => array(
                "crm_user_tbl.is_deleted" => 'N',
                "crm_employers_primary.broker_id" => $userID,
            ),
        );
        $downEmployers = get_relation($table, $options, FALSE);
        return $downEmployers;
    }

    public function getdownlineAgents($userID) {
        $table = 'crm_broker_personal';
        $options = array(
            'fields' => 'crm_user_tbl.user_id,crm_user_tbl.display_name',
            'JOIN' => array(
                array(
                    'table' => 'crm_user_tbl',
                    'condition' => 'crm_user_tbl.user_id = crm_broker_personal.user_id',
                    'type' => 'LEFT'
                )
            ),
            'conditions' => array(
                "crm_user_tbl.is_deleted" => 'N',
                "crm_broker_personal.parent_id" => $userID,
            ),
        );
        $downAgents = get_relation($table, $options, FALSE);
        return $downAgents;
    }

}
