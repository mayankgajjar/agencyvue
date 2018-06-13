<?php

class Member extends CI_Model {
    /* Get All Members */

    public function get_member($sLimit, $sWhere = "", $sOrder, $status = "") {
        $table = 'crm_lead_member_primary as primary';
        if ($status != "") {
            $options = array(
                'fields' => array(
                    'primary.customer_first_name,primary.customer_gender,primary.customer_last_name,primary.customer_email,master.customer_created_date,master.customer_id,master.is_active'
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
                    'primary.customer_first_name,primary.customer_gender,primary.customer_last_name,primary.customer_email,master.customer_created_date,master.customer_id,master.is_active'
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

    /*
     * Fetch Member Data Grid Array for Admin user
     */

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

    /*
     * Member Counter for admin in each case
     */

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
        $table = 'crm_member_products';

        $options = array(
            'fields' => array(
                'count(*) as total'
            ),
            'conditions' => array(
                "crm_member_products.added_by" => $this->session->userdata['user_info']['user_id'],
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

    public function get_total_members() {
        $table = 'crm_member_products';

        $options = array(
            'fields' => array(
                'count(*) as total'
            ),
            'conditions' => array(
                "crm_member_products.added_by" => $this->session->userdata['user_info']['user_id'],
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
        $this->db->join('crm_user_tbl master', 'clmm.user_id = master.user_id', 'FULL');
        $this->db->join('crm_lead_member_primary clmp', 'clmm.customer_id = clmp.customer_id');
        $this->db->join('crm_states cs', 'clmp.customer_state = cs.state_code');
        $this->db->where('cmp.is_status', 'Y');
        $this->db->where('master.is_deleted', 'N');
        $this->db->where('clmm.is_delete', 'N');
        $this->db->group_by('clmp.customer_state');
        $data = $this->db->get()->result_array();
        return $data;
    }

    //------------- Fetch State wise member -----------
    function get_statewise_member_agency() {
        $agents = get_agents($this->session->userdata['user_info']['user_id']);
        $leadPerents = $this->session->userdata['user_info']['user_id'];

        $where_in_arr = [];
        if (!empty($agents)) {
            $all_agents_ids = array_column($agents, 'user_id');
            $where_in_arr = $all_agents_ids;
        }
        array_push($where_in_arr, $leadPerents);

        $this->db->select("count('clmp.customer_id') as total_customer,clmp.customer_state as state_code,cs.state as state", FALSE);
        $this->db->from('crm_member_products cmp');
        $this->db->join('crm_lead_member_master clmm', 'cmp.member_id = clmm.user_id');
        $this->db->join('crm_lead_member_primary clmp', 'clmm.customer_id = clmp.customer_id');
        $this->db->join('crm_states cs', 'clmp.customer_state = cs.state_code');
        //$this->db->where('cmp.added_by', $this->session->userdata['user_info']['user_id']);
        $this->db->where_in('cmp.added_by', $where_in_arr);
        $this->db->where('cmp.is_status', 'Y');
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

    public function get_pading_varification_v2() {
        $table = 'crm_member_products as product';
        $options = array(
            'fields' => array(
                'DISTINCT master.display_name,members.customer_id,product.added_time'
            ),
            'JOIN' => array(
                array(
                    'table' => 'crm_user_tbl as master',
                    'condition' => 'master.user_id = product.member_id',
                    'type' => 'FULL'
                ),
                array(
                    'table' => 'crm_lead_member_master as members',
                    'condition' => 'members.user_id = product.member_id',
                    'type' => 'FULL'
                )
            ),
            'GROUP_BY' => 'members.customer_id',
            'conditions' => array(
                "product.added_by" => $this->session->userdata['user_info']['user_id'],
                "product.is_status" => 'W',
                "master.is_deleted" => 'N',
            ),
            'ORDER_BY' => array(
                "field" => 'added_time',
                "order" => 'DESC'
            )
        );
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

        return $selectble_arr;
    }

    /*
     * Fetch Members Data Grid Array for Agency user
     */

    public function get_member_agency($sLimit, $sWhere = "", $sOrder, $leadPerents) {
        $table = 'crm_lead_member_primary as primary';
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
            'conditions' => "master.is_delete = 'N' AND master.customer_status = 'memeber' AND master.broker_id IN(" . $leadPerents . ")",
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
            $options['conditions'] = $options['conditions'] . ' AND ' . $sWhere;
        }
        $user_arr = get_relation($table, $options, FALSE);
//        if ($agent_id != "")
//          pr_exit($user_arr);
        return $user_arr;
    }

    public function get_member_agency_count($sWhere = "", $leadPerents) {
        $table = 'crm_lead_member_primary';
        $options = array(
            'fields' => array(
                'count(*) as total'
            ),
            'JOIN' => array(
                array(
                    'table' => 'crm_lead_member_master as master',
                    'condition' => 'master.customer_id = crm_lead_member_primary.customer_id',
                    'type' => 'FULL'
                ),
                array(
                    'table' => 'crm_user_tbl',
                    'condition' => 'crm_user_tbl.user_id = master.broker_id',
                    'type' => 'FULL'
                ),
            ),
            'conditions' => "master.is_delete = 'N' AND master.customer_status = 'memeber' AND master.broker_id IN(" . $leadPerents . ")",
        );

        if (strlen($sWhere) > 0) {
            $options['conditions'] = $options['conditions'] . ' AND ' . $sWhere;
        }

        $user_count = get_relation($table, $options);
        return $user_count[0]['total'];
    }

    public function get_member_betweendates($rangStart = null, $rangeEnd = null) {
        $agentID = $this->session->userdata['user_info']['user_id'];
        $stmt = "SELECT count(*) as members_count FROM `crm_lead_member_master` WHERE `customer_status`='memeber'AND `is_active` = 'Y' AND `is_delete` = 'N' AND `broker_id` = '$agentID' and ( customer_created_date BETWEEN '$rangStart' AND '$rangeEnd')";
        $query = $this->db->query($stmt);
        $row = $query->row_array();
        return $row['members_count'];
    }

    public function get_today_member_count() {
        $agentID = $this->session->userdata['user_info']['user_id'];
        $rawSql = "SELECT count(*) as today_members_count FROM `crm_lead_member_master` WHERE `customer_status`='memeber' AND `is_active` = 'Y' AND `is_delete` = 'N' AND `broker_id` = '$agentID' and customer_created_date LIKE '%" . date("Y-m-d") . "%'";
        $query = $this->db->query($rawSql);
        $row = $query->row_array();
        return $row['today_members_count'];
    }

    public function get_member_file($id = null) {
        if ($id == null) {
            exit('ID ERROR IN GET_MEMBER_FILE METHOD || ERROR || AGENCY VUE');
        }
        $totalFiles['verificationFiles'] = array();
        $verificationFile = get_data('crm_member_product_script', '0', array('user_id' => $id));
        $totalFiles['verificationFiles'] = $verificationFile;
        $otherFiles = get_data('crm_member_file', '0', array('member_id' => $id));
        $totalFiles['otherFiles'] = $otherFiles;
        return $totalFiles;
    }

    public function get_verification_file($id = null) {
        if ($id == null) {
            exit('ID ERROR IN get_verification_file METHOD || ERROR || AGENCY VUE');
        }
        $file = get_data('crm_member_product_script', 1, array('script_id' => $id));
        return $file;
    }

    public function get_member_other_file($id = null) {
        if ($id == null) {
            exit('ID ERROR IN get_member_other_file METHOD || ERROR || AGENCY VUE');
        }
        $file = get_data('crm_member_file', 1, array('id' => $id));
        return $file;
    }

    public function get_member_script($sLimit, $sWhere = "", $sOrder) {
        $table = 'crm_lead_member_master as member';
        $options = array(
            'fields' => array("member.customer_id AS client_id", "umaster.display_name AS name", "primary.customer_gender AS gender", "primary.customer_image AS image", "product.product_name AS product_name", "script.script AS script_name"),
            'JOIN' => array(
                array(
                    'table' => 'crm_member_product_script script',
                    'condition' => 'script.user_id = member.customer_id',
                    'type' => 'FULL'
                ),
                array(
                    'table' => 'crm_products product',
                    'condition' => 'product.global_product_id = script.product_id',
                    'type' => 'FULL'
                ),
                array(
                    'table' => 'crm_lead_member_primary primary',
                    'condition' => 'primary.customer_id = member.customer_id',
                    'type' => 'FULL'
                ),
                array(
                    'table' => 'crm_user_tbl umaster',
                    'condition' => 'umaster.user_id = member.user_id',
                    'type' => 'FULL'
                )
            ),
            'conditions' => array(
                "member.broker_id" => $this->session->userdata('user_info')['user_id'],
                "member.customer_status" => 'memeber',
                "member.is_delete" => 'N',
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
        $scriptArr = get_relation($table, $options);
        return $scriptArr;
    }

    public function get_member_script_count($sWhere) {
        $table = 'crm_lead_member_master as member';
        $options = array(
            'fields' => array("count(*) as total_script"),
            'JOIN' => array(
                array(
                    'table' => 'crm_member_product_script script',
                    'condition' => 'script.user_id = member.customer_id',
                    'type' => 'FULL'
                ),
                array(
                    'table' => 'crm_products product',
                    'condition' => 'product.global_product_id = script.product_id',
                    'type' => 'FULL'
                ),
                array(
                    'table' => 'crm_lead_member_primary primary',
                    'condition' => 'primary.customer_id = member.customer_id',
                    'type' => 'FULL'
                ),
                array(
                    'table' => 'crm_user_tbl umaster',
                    'condition' => 'umaster.user_id = member.user_id',
                    'type' => 'FULL'
                )
            ),
            'conditions' => array(
                "member.broker_id" => $this->session->userdata('user_info')['user_id'],
                "member.customer_status" => 'memeber',
                "member.is_delete" => 'N',
            ),
        );
        if (strlen($sWhere) > 0) {
            $options['conditions']['or'] = $sWhere;
        }
        $scriptCount = get_relation($table, $options);
        return $scriptCount[0]['total_script'];
    }

    public function get_member_script_agency($sLimit, $sWhere = "", $sOrder) {

        $agents = get_agents($this->session->userdata['user_info']['user_id']);

        $agents_ids = array();

        foreach ($agents as $key => $value) {
            $agents_ids[] = $value['user_id'];
        }

        $agents_ids = implode(",", $agents_ids);
    
        $table = 'crm_lead_member_master as member';
        $options = array(
            'fields' => array("member.customer_id AS client_id", "umaster.display_name AS name", "primary.customer_gender AS gender", "primary.customer_image AS image", "product.product_name AS product_name", "script.script AS script_name"),
            'JOIN' => array(
                array(
                    'table' => 'crm_member_product_script script',
                    'condition' => 'script.user_id = member.customer_id',
                    'type' => 'FULL'
                ),
                array(
                    'table' => 'crm_products product',
                    'condition' => 'product.global_product_id = script.product_id',
                    'type' => 'FULL'
                ),
                array(
                    'table' => 'crm_lead_member_primary primary',
                    'condition' => 'primary.customer_id = member.customer_id',
                    'type' => 'FULL'
                ),
                array(
                    'table' => 'crm_user_tbl umaster',
                    'condition' => 'umaster.user_id = member.user_id',
                    'type' => 'FULL'
                )
            ),
            'conditions' => "member.customer_status = 'memeber' AND  member.is_delete = 'N' AND member.broker_id IN (".$agents_ids.")",
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
        $scriptArr = get_relation($table, $options);
        return $scriptArr;
    }

    public function get_member_script_agency_basedon_agent($sLimit, $sWhere, $sOrder, $leadPerents) {
    
        $table = 'crm_lead_member_master as member';
        $options = array(
            'fields' => array("member.customer_id AS client_id", "umaster.display_name AS name", "primary.customer_gender AS gender", "primary.customer_image AS image", "product.product_name AS product_name", "script.script AS script_name"),
            'JOIN' => array(
                array(
                    'table' => 'crm_member_product_script script',
                    'condition' => 'script.user_id = member.customer_id',
                    'type' => 'FULL'
                ),
                array(
                    'table' => 'crm_products product',
                    'condition' => 'product.global_product_id = script.product_id',
                    'type' => 'FULL'
                ),
                array(
                    'table' => 'crm_lead_member_primary primary',
                    'condition' => 'primary.customer_id = member.customer_id',
                    'type' => 'FULL'
                ),
                array(
                    'table' => 'crm_user_tbl umaster',
                    'condition' => 'umaster.user_id = member.user_id',
                    'type' => 'FULL'
                )
            ),
         
            'conditions' => "member.customer_status = 'memeber' AND  member.is_delete = 'N' AND member.broker_id IN (".$leadPerents.")",
            'LIMIT' => array(
                "start" => $sLimit['start'],
                "end" => $sLimit['end']
            )
        );

        if (strlen($sWhere) > 0) {
            $options['conditions'] = $options['conditions'] . ' AND ' . $sWhere;
        }
        $scriptArr = get_relation($table, $options);
        return $scriptArr;
    }
}
?>