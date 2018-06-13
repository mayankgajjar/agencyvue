<?php

class Employer extends CI_Model {
    /* Get All Leads */

    public function get_employer($sLimit, $sWhere = "", $sOrder) {
        $table = 'crm_employers_primary';
        $options = array(
            'JOIN' => array(
                array(
                    'table' => 'crm_user_tbl',
                    'condition' => 'crm_employers_primary.user_id = crm_user_tbl.user_id',
                    'type' => 'FULL'
                ),
            ),
            'conditions' => array(
                "crm_employers_primary.broker_id" => $this->session->userdata['user_info']['user_id'],
                "crm_user_tbl.is_deleted" => 'N'
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

    public function get_employers_count($sWhere) {
        $table = 'crm_employers_primary';
        $options = array(
            'fields' => array(
                'count(*) as total'
            ),
            'JOIN' => array(
                array(
                    'table' => 'crm_user_tbl',
                    'condition' => 'crm_employers_primary.user_id = crm_user_tbl.user_id',
                    'type' => 'FULL'
                ),
            ),
            'conditions' => array(
                "crm_employers_primary.broker_id" => $this->session->userdata['user_info']['user_id'],
                "crm_user_tbl.is_deleted" => 'N'
            ),
        );

        if (strlen($sWhere) > 0) {
            $options['conditions']['or'] = $sWhere;
        }

        $user_count = get_relation($table, $options);
        return $user_count[0]['total'];
    }

    function get_infos($id, $tablename, $field = 'id') {
        $this->db->select('*');
        $this->db->where($field, $id);
        $this->db->from($tablename);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    /*

     * Get All unaproved employer

     */

    public function get_unaproved_employer($sLimit, $sWhere = "", $sOrder) {

//        $raw_sql = "";

        $table = 'crm_employers_primary';

        $options = array(
            'fields' => '*, crm_user_tbl.user_id as emp_id, CONCAT(crm_broker_personal.first_name," ",crm_broker_personal.last_name) as broker_name',
            'JOIN' => array(
                array(
                    'table' => 'crm_user_tbl',
                    'condition' => 'crm_employers_primary.user_id = crm_user_tbl.user_id',
                    'type' => 'FULL'
                ),
                array(
                    'table' => 'crm_broker_personal',
                    'condition' => 'crm_broker_personal.user_id = crm_employers_primary.broker_id',
                    'type' => 'FULL'
                ),
                array(
                    'table' => 'crm_states',
                    'condition' => 'crm_employers_primary.employer_state = crm_states.state_code',
                    'type' => 'FULL'
                ),
            ),
            'conditions' => array(
                "crm_user_tbl.is_approved" => 'NA',
                "crm_user_tbl.is_deleted" => 'N'
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
//        pr_exit($user_arr);
        return $user_arr;
    }

    public function get_unaproved_employer_count($sWhere) {

        $table = 'crm_employers_primary';

        $options = array(
            'fields' => array(
                'count(*) as total'
            ),
            'JOIN' => array(
                array(
                    'table' => 'crm_user_tbl',
                    'condition' => 'crm_employers_primary.user_id = crm_user_tbl.user_id',
                    'type' => 'FULL'
                ),
                array(
                    'table' => 'crm_broker_personal',
                    'condition' => 'crm_broker_personal.user_id = crm_employers_primary.broker_id',
                    'type' => 'FULL'
                ),
            ),
            'conditions' => array(
                "crm_user_tbl.is_approved" => 'NA',
                "crm_user_tbl.is_deleted" => 'N'
            )
        );

        if (strlen($sWhere) > 0) {
            $options['conditions']['or'] = $sWhere;
        }
        $user_count = get_relation($table, $options);
        return $user_count[0]['total'];
    }

    public function get_employer_profile($user_id) {

        $table = 'crm_employers_primary';
        $options = array(
            'JOIN' => array(
                array(
                    'table' => 'crm_user_tbl',
                    'condition' => 'crm_employers_primary.user_id = crm_user_tbl.user_id',
                    'type' => 'FULL'
                ),
                array(
                    'table' => 'crm_employers_daily_contact',
                    'condition' => 'crm_employers_daily_contact.user_id = crm_employers_primary.user_id',
                    'type' => 'FULL'
                ),
                array(
                    'table' => 'crm_employers_billing_contact',
                    'condition' => 'crm_employers_billing_contact.user_id = crm_employers_primary.user_id',
                    'type' => 'FULL'
                ),
                array(
                    'table' => 'crm_employers_technical_contact',
                    'condition' => 'crm_employers_technical_contact.user_id = crm_employers_primary.user_id',
                    'type' => 'FULL'
                ),
                array(
                    'table' => 'crm_states',
                    'condition' => 'crm_employers_primary.employer_state = crm_states.state_code',
                    'type' => 'FULL'
                ),
            ),
            'conditions' => array(
                "crm_employers_primary.user_id" => $user_id
            )
        );

        $user_arr = get_relation($table, $options);
        return $user_arr;
    }
        public function get_all_approved_employer($sLimit, $sWhere = "", $sOrder,$agent_id) {
        $table = 'crm_employers_primary';
         if ($agent_id != "") {
        $options = array(
            'fields' => 'crm_employers_primary.employers_primary_id,crm_employers_primary.employer_name,crm_user_tbl.email, crm_user_tbl.created_date, crm_user_tbl.user_id as emp_id, user_master.display_name as broker_name',
            'JOIN' => array(
                array(
                    'table' => 'crm_user_tbl',
                    'condition' => 'crm_employers_primary.user_id = crm_user_tbl.user_id',
                    'type' => 'FULL'
                ),
                array(
                    'table' => 'crm_user_tbl user_master',
                    'condition' => 'user_master.user_id = crm_employers_primary.broker_id',
                    'type' => 'LEFT'
                )
            ),
            'conditions' => array(
                "crm_user_tbl.is_approved" => 'Y',
                "crm_user_tbl.is_deleted" => 'N',
                "crm_employers_primary.broker_id"=>$agent_id
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
   }else
   {
       $options = array(
            'fields' => 'crm_employers_primary.employers_primary_id,crm_employers_primary.employer_name,crm_user_tbl.email, crm_user_tbl.created_date, crm_user_tbl.user_id as emp_id, user_master.display_name as broker_name',
            'JOIN' => array(
                array(
                    'table' => 'crm_user_tbl',
                    'condition' => 'crm_employers_primary.user_id = crm_user_tbl.user_id',
                    'type' => 'FULL'
                ),
                array(
                    'table' => 'crm_user_tbl user_master',
                    'condition' => 'user_master.user_id = crm_employers_primary.broker_id',
                    'type' => 'LEFT'
                )
            ),
            'conditions' => array(
                "crm_user_tbl.is_approved" => 'Y',
                "crm_user_tbl.is_deleted" => 'N',
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
   }
        if (strlen($sWhere) > 0) {
            $options['conditions']['or'] = $sWhere;
        }

        $user_arr = get_relation($table, $options);
//        pr_exit($user_arr);
        return $user_arr;
    }

    /**
     * @uses Getting all approved employer list
     * @author MGA
     */
//    public function get_all_approved_employer($sLimit, $sWhere = "", $sOrder) {
//        $table = 'crm_employers_primary';
//
//        $options = array(
//            'fields' => 'crm_employers_primary.employers_primary_id,crm_employers_primary.employer_name,crm_user_tbl.email, crm_user_tbl.created_date, crm_user_tbl.user_id as emp_id, user_master.display_name as broker_name',
//            'JOIN' => array(
//                array(
//                    'table' => 'crm_user_tbl',
//                    'condition' => 'crm_employers_primary.user_id = crm_user_tbl.user_id',
//                    'type' => 'FULL'
//                ),
//                array(
//                    'table' => 'crm_user_tbl user_master',
//                    'condition' => 'user_master.user_id = crm_employers_primary.broker_id',
//                    'type' => 'LEFT'
//                )
//            ),
//            'conditions' => array(
//                "crm_user_tbl.is_approved" => 'Y',
//                "crm_user_tbl.is_deleted" => 'N'
//            ),
//            'LIMIT' => array(
//                "start" => $sLimit['start'],
//                "end" => $sLimit['end']
//            ),
//            'ORDER_BY' => array(
//                "field" => $sOrder['field'],
//                "order" => $sOrder['order']
//            )
//        );
//
//        if (strlen($sWhere) > 0) {
//            $options['conditions']['or'] = $sWhere;
//        }
//
//        $user_arr = get_relation($table, $options);
////        pr_exit($user_arr);
//        return $user_arr;
//    }

//    public function get_all_approved_employer_count($sWhere="") {
//
//        $table = 'crm_employers_primary';
//
//        $options = array(
//            'fields' => array(
//                'count(*) as total'
//            ),
//            'JOIN' => array(
//                array(
//                    'table' => 'crm_user_tbl',
//                    'condition' => 'crm_employers_primary.user_id = crm_user_tbl.user_id',
//                    'type' => 'FULL'
//                ),
//                array(
//                    'table' => 'crm_broker_personal',
//                    'condition' => 'crm_broker_personal.user_id = crm_employers_primary.broker_id',
//                    'type' => 'FULL'
//                ),
//            ),
//            'conditions' => array(
//                "crm_user_tbl.is_approved" => 'Y',
//                "crm_user_tbl.is_deleted" => 'N'
//            )
//        );
//
//        if (strlen($sWhere) > 0) {
//            $options['conditions']['or'] = $sWhere;
//        }
//        $user_count = get_relation($table, $options);
//        return $user_count[0]['total'];
//    }
     public function get_all_approved_employer_count($sWhere="",$agent_id="") {

        $table = 'crm_employers_primary';

         if ($agent_id != "") {

        $options = array(
            'fields' => array(
                'count(*) as total'
            ),
            'JOIN' => array(
                array(
                    'table' => 'crm_user_tbl',
                    'condition' => 'crm_employers_primary.user_id = crm_user_tbl.user_id',
                    'type' => 'FULL'
                ),
                array(
                    'table' => 'crm_broker_personal',
                    'condition' => 'crm_broker_personal.user_id = crm_employers_primary.broker_id',
                    'type' => 'FULL'
                ),
            ),
            'conditions' => array(
                "crm_user_tbl.is_approved" => 'Y',
                "crm_user_tbl.is_deleted" => 'N',
                "crm_employers_primary.broker_id" => $agent_id
            )
        );
         }else
         {
            $options = array(
            'fields' => array(
                'count(*) as total'
            ),
            'JOIN' => array(
                array(
                    'table' => 'crm_user_tbl',
                    'condition' => 'crm_employers_primary.user_id = crm_user_tbl.user_id',
                    'type' => 'FULL'
                ),
                array(
                    'table' => 'crm_broker_personal',
                    'condition' => 'crm_broker_personal.user_id = crm_employers_primary.broker_id',
                    'type' => 'FULL'
                ),
            ),
            'conditions' => array(
                "crm_user_tbl.is_approved" => 'Y',
                "crm_user_tbl.is_deleted" => 'N'

            )
        );
         }

        if (strlen($sWhere) > 0) {
            $options['conditions']['or'] = $sWhere;
        }
        $user_count = get_relation($table, $options);
        return $user_count[0]['total'];
    }

}
