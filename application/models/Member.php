<?php

class Member extends CI_Model {
    /* Get All Members */

    public function get_member($sLimit, $sWhere = "", $sOrder, $status = "") {
        $table = 'crm_lead_member_primary as primary';
        if ($status != "") {
            $options = array(
                'fields' => array(
                    'primary.customer_first_name,primary.customer_last_name,primary.customer_email,master.customer_created_date,master.customer_id,master.is_active'
                ),
                'JOIN' => array(
                    array(
                        'table' => 'crm_lead_member_master as master',
                        'condition' => 'master.customer_id = primary.customer_id',
                        'type' => 'FULL'
                    ),
                ),
                'conditions' => array(
                    "master.broker_id" => $this->session->userdata['user_info']['user_id'],
                    "master.is_delete" => 'N',
                    "master.customer_status" => 'memeber',
                    "master.is_active" => $status,
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
        } else {
            $options = array(
                'fields' => array(
                    'primary.customer_first_name,primary.customer_last_name,primary.customer_email,master.customer_created_date,master.customer_id,master.is_active'
                ),
                'JOIN' => array(
                    array(
                        'table' => 'crm_lead_member_master as master',
                        'condition' => 'master.customer_id = primary.customer_id',
                        'type' => 'FULL'
                    ),
                ),
                'conditions' => array(
                    "master.broker_id" => $this->session->userdata['user_info']['user_id'],
                    "master.is_delete" => 'N',
                    "master.customer_status" => 'memeber',
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

        $user_arr = get_relation($table, $options, FALSE);
        return $user_arr;
    }

    public function get_member_count($sWhere, $status) {
        $table = 'crm_lead_member_primary';
        if ($status != "") {
            $options = array(
                'fields' => array(
                    'count(*) as total'
                ),
                'JOIN' => array(
                    array(
                        'table' => 'crm_lead_member_master',
                        'condition' => 'crm_lead_member_master.customer_id = crm_lead_member_primary.customer_id',
                        'type' => 'FULL'
                    ),
                ),
                'conditions' => array(
                    "crm_lead_member_master.broker_id" => $this->session->userdata['user_info']['user_id'],
                    "crm_lead_member_master.is_delete" => 'N',
                    "crm_lead_member_master.customer_status" => 'memeber',
                    "crm_lead_member_master.is_active" => $status,
                ),
            );
        } else {
            $options = array(
                'fields' => array(
                    'count(*) as total'
                ),
                'JOIN' => array(
                    array(
                        'table' => 'crm_lead_member_master',
                        'condition' => 'crm_lead_member_master.customer_id = crm_lead_member_primary.customer_id',
                        'type' => 'FULL'
                    ),
                ),
                'conditions' => array(
                    "crm_lead_member_master.broker_id" => $this->session->userdata['user_info']['user_id'],
                    "crm_lead_member_master.is_delete" => 'N',
                    "crm_lead_member_master.customer_status" => 'memeber',
                ),
            );
        }



        if (strlen($sWhere) > 0) {
            $options['conditions']['or'] = $sWhere;
        }

        $user_count = get_relation($table, $options);
        return $user_count[0]['total'];
    }

    public function get_member_profile($customer_id) {

        $table = 'crm_lead_member_primary';
        $options = array(
            'JOIN' => array(
                array(
                    'table' => 'crm_user_tbl',
                    'condition' => 'crm_lead_member_primary.customer_id = crm_user_tbl.user_id',
                    'type' => 'LEFT'
                ),
                array(
                    'table' => 'crm_lead_member_spouse',
                    'condition' => 'crm_lead_member_spouse.customer_id = crm_lead_member_primary.customer_id',
                    'type' => 'LEFT'
                ),
                array(
                    'table' => 'crm_lead_member_master',
                    'condition' => 'crm_lead_member_master.customer_id = crm_lead_member_primary.customer_id',
                    'type' => 'LEFT'
                ),
                array(
                    'table' => 'crm_lead_member_child',
                    'condition' => 'crm_lead_member_child.customer_id = crm_lead_member_primary.customer_id',
                    'type' => 'LEFT'
                ),
                array(
                    'table' => 'crm_states',
                    'condition' => 'crm_lead_member_primary.customer_state = crm_states.state_code',
                    'type' => 'LEFT'
                ),
            ),
            'conditions' => array(
                "crm_lead_member_primary.customer_id" => $customer_id
            )
        );

        $user_arr = get_relation($table, $options);
        return $user_arr;
    }

    public function get_members_admin($sLimit, $sWhere = "", $sOrder, $agent_id) {
        $table = 'crm_lead_member_primary as primary';
        if ($agent_id != "") {
            $options = array(
                'fields' => array(
                    'primary.customer_first_name,primary.customer_last_name,primary.customer_email,master.customer_created_date,master.customer_id,master.is_active,user_master.display_name'
                ),
                'JOIN' => array(
                    array(
                        'table' => 'crm_lead_member_master as master',
                        'condition' => 'master.customer_id = primary.customer_id',
                        'type' => 'FULL'
                    ),
                    array(
                        'table' => 'crm_user_tbl as user_master',
                        'condition' => 'user_master.user_id = master.broker_id',
                        'type' => 'FULL'
                    ),
                ),
                'conditions' => array(
                    "master.is_delete" => 'N',
                    "master.customer_status" => 'memeber',
                    "master.broker_id" => $agent_id
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
        } else {
            $options = array(
                'fields' => array(
                    'primary.customer_first_name,primary.customer_last_name,primary.customer_email,master.customer_created_date,master.customer_id,master.is_active,user_master.display_name'
                ),
                'JOIN' => array(
                    array(
                        'table' => 'crm_lead_member_master master',
                        'condition' => 'master.customer_id = primary.customer_id',
                        'type' => 'FULL'
                    ),
                    array(
                        'table' => 'crm_user_tbl as user_master',
                        'condition' => 'user_master.user_id = master.broker_id',
                        'type' => 'FULL'
                    ),
                ),
                'conditions' => array(
                    "master.is_delete" => 'N',
                    "master.customer_status" => 'memeber'
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
        $user_arr = get_relation($table, $options, FALSE);
//        if ($agent_id != "")
//          pr_exit($user_arr);
        return $user_arr;
    }

    public function get_member_count_admin($sWhere = "", $agent_id = "") {
        $table = 'crm_lead_member_primary';
        if ($agent_id != "") {
            $options = array(
                'fields' => array(
                    'count(*) as total'
                ),
                'JOIN' => array(
                    array(
                        'table' => 'crm_lead_member_master',
                        'condition' => 'crm_lead_member_master.customer_id = crm_lead_member_primary.customer_id',
                        'type' => 'FULL'
                    ),
                    array(
                        'table' => 'crm_user_tbl',
                        'condition' => 'crm_user_tbl.user_id = crm_lead_member_master.broker_id',
                        'type' => 'FULL'
                    ),
                ),
                'conditions' => array(
                    "crm_lead_member_master.is_delete" => 'N',
                    "crm_lead_member_master.customer_status" => 'memeber',
                    "crm_lead_member_master.broker_id" => $agent_id
                ),
            );
        } else {
            $options = array(
                'fields' => array(
                    'count(*) as total'
                ),
                'JOIN' => array(
                    array(
                        'table' => 'crm_lead_member_master',
                        'condition' => 'crm_lead_member_master.customer_id = crm_lead_member_primary.customer_id',
                        'type' => 'FULL'
                    ),
                    array(
                        'table' => 'crm_user_tbl',
                        'condition' => 'crm_user_tbl.user_id = crm_lead_member_master.broker_id',
                        'type' => 'FULL'
                    ),
                ),
                'conditions' => array(
                    "crm_lead_member_master.is_delete" => 'N',
                    "crm_lead_member_master.customer_status" => 'memeber',
                ),
            );
        }

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

    function master_update($table, $data, $condition) {

        $this->db->where($condition);
        $this->db->update($table, $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }

        return FALSE;
    }

    function master_insert($table, $data) {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    public function get_member_active($sWhere = "") {
        /*$id = $this->session->userdata['user_info']['user_id'];
        $this->db->select("count('member_id') as total_active_member");
        $this->db->from('crm_member_products');
        $this->db->group_by('crm_member_products.member_id'); 
        $this->db->join('crm_user_tbl', 'crm_member_products.member_id = crm_user_tbl.user_id');
        $this->db->where('crm_user_tbl.is_deleted', 'N');
        $this->db->where('crm_member_products.added_by', $id);
        $this->db->where('crm_member_products.is_status', 'Y');
        $data = $this->db->get()->result_array();
        return $data;*/


        $table = 'crm_member_products';
        $id = $this->session->userdata['user_info']['user_id'];
        $options = array(
            'fields' => array(
                'count(*) as total'
            ),
            /*'JOIN' => array(
                array(
                    'table' => 'crm_lead_member_master',
                    'condition' => 'crm_lead_member_master.user_id = crm_member_products.member_id',
                    'type' => 'LEFT'
                ),
            ),*/
            'conditions' => array(
                //"crm_lead_member_master.is_delete" =>'N',
                //"crm_lead_member_master.broker_id" => $id,
                "crm_member_products.added_by" => $id,
                "crm_member_products.is_status" => 'Y',
            ),
        );
        $user_count = get_relation($table, $options);
        return $user_count[0]['total'];
    }

    public function get_member_inactive($sWhere = "") {
        $table = 'crm_member_products';

        $options = array(
            'fields' => array(
                'count(*) as total'
            ),
            'conditions' => array(
                "crm_member_products.added_by" => $this->session->userdata['user_info']['user_id'],
                "crm_member_products.is_status" => 'C',
            ),
        );

        $user_count = get_relation($table, $options);
        return $user_count[0]['total'];
    }

    //------------- Fetch State wise member -----------
    function get_statewise_member() {
        $this->db->select("count('clmp.customer_id') as total_customer,clmp.customer_state as state_code,cs.state as state");
        $this->db->from('crm_member_products cmp');
        $this->db->join('crm_lead_member_master clmm', 'cmp.member_id = clmm.user_id');
        $this->db->join('crm_lead_member_primary clmp', 'clmm.customer_id = clmp.customer_id');
        $this->db->join('crm_states cs', 'clmp.customer_state = cs.state_code');
        $this->db->where('cmp.added_by', $this->session->userdata['user_info']['user_id']);
        $this->db->where('cmp.is_status', 'Y');
        $this->db->group_by('clmp.customer_state');
        $data = $this->db->get()->result_array();
        return $data;
    }

  //------------- Fetch State wise member -----------
    function get_statewise_member_admin() {
        $this->db->select("count('clmp.customer_id') as total_customer,clmp.customer_state as state_code,cs.state as state");
        $this->db->from('crm_member_products cmp');
        $this->db->join('crm_lead_member_master clmm', 'cmp.member_id = clmm.user_id');
        $this->db->join('crm_user_tbl master', 'clmm.user_id = master.user_id','FULL');
        $this->db->join('crm_lead_member_primary clmp', 'clmm.customer_id = clmp.customer_id');
        $this->db->join('crm_states cs', 'clmp.customer_state = cs.state_code');
        $this->db->where('cmp.is_status', 'Y');
        $this->db->where('master.is_deleted', 'N');
        $this->db->where('clmm.is_delete', 'N');
        $this->db->group_by('clmp.customer_state');
        $data = $this->db->get()->result_array();
        return $data;
    }

    

    public function get_pading_varification($sWhere = "") {
        $table = 'crm_lead_member_primary as primary';
        $options = array(
            'fields' => array(
                'primary.customer_first_name,primary.customer_last_name,primary.customer_email,primary.customer_verification,master.customer_created_date,master.customer_id,master.is_active'
            ),
            'JOIN' => array(
                array(
                    'table' => 'crm_lead_member_master as master',
                    'condition' => 'master.customer_id = primary.customer_id',
                    'type' => 'FULL'
                ),
            ),
            'conditions' => array(
                "master.broker_id" => $this->session->userdata['user_info']['user_id'],
                "primary.customer_verification" => NULL,
                "master.is_delete" => 'N',
                "master.customer_status" => 'memeber',
            ),
        );

        if (strlen($sWhere) > 0) {
            $options['conditions']['or'] = $sWhere;
        }

        $pading_arr = get_relation($table, $options, FALSE);
        return $pading_arr;
    }

    public function get_selectble_products($userID) {
        $table = 'crm_member_products as buy_products';
        $options = array(
            'JOIN' => array(
                array(
                    'table' => 'crm_products as selectble',
                    'condition' => 'buy_products.product_id != selectble.global_product_id',
                    'type' => 'FULL'
                ),
            ),
            'conditions' => array(
                "selectble.is_deleted" => 'N',
                "buy_products.is_status" => 'Y',
                "buy_products.member_id" => $userID,
            ),
        );
        $selectble_arr = get_relation($table, $options);
        pr_exit($selectble_arr);
        return $selectble_arr;
    }

}

?>