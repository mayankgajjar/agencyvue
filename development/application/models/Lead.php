<?php



class Lead extends CI_Model {

    /* Get All Leads */



    public function get_leads($sLimit, $sWhere = "", $sOrder) {

        $table = 'crm_lead_member_primary';

        $options = array(

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

                "crm_lead_member_master.customer_status" => 'lead',

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



    private function create_view_lead() {

        $sql = "CREATE OR REPLACE view lead_admin as SELECT CASE WHEN broker_id = '0' THEN useradmin.display_name WHEN broker_id > 0 THEN users.display_name END as lead_add_by,CONCAT (customer_first_name,' ',customer_last_name ) as cname,customer_created_date,`crm_lead_member_master`.customer_id,`crm_lead_member_primary`.customer_email FROM`crm_lead_member_primary` LEFT JOIN `crm_lead_member_master` ON `crm_lead_member_master`.`customer_id` = `crm_lead_member_primary`.`customer_id` LEFT JOIN `crm_user_tbl`as users on users.user_id = `crm_lead_member_master`.broker_id left join `crm_user_tbl` as useradmin on useradmin.user_id = `crm_lead_member_master`.`is_admin` WHERE `crm_lead_member_master`.`is_delete` = 'N' AND `crm_lead_member_master`.`customer_status` = 'lead'";

        $this->db->query($sql);

    }



    public function get_leads_admin($sLimit, $sWhere = "", $sOrder, $agent_id) {

        $this->create_view_lead();

        $table = 'lead_admin';



        if ($agent_id != "") {

            $options = array(

                'conditions' => array(

                    "lead_admin.lead_add_by" => $agent_id,

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

        return $user_arr;

    }



    public function get_leads_count($sWhere) {

        $table = 'crm_lead_member_primary';



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

                "crm_lead_member_master.customer_status" => 'lead',

            ),

        );





        if (strlen($sWhere) > 0) {

            $options['conditions']['or'] = $sWhere;

        }



        $user_count = get_relation($table, $options);

        return $user_count[0]['total'];

    }



    public function get_lead_profile($customer_id) {



        $table = 'crm_lead_member_primary';

        $options = array(

            'JOIN' => array(

                array(

                    'table' => 'crm_lead_member_master',

                    'condition' => 'crm_lead_member_master.customer_id = crm_lead_member_primary.customer_id',

                    'type' => 'LEFT'

                ),

                array(

                    'table' => 'crm_lead_member_spouse',

                    'condition' => 'crm_lead_member_spouse.customer_id = crm_lead_member_master.customer_id',

                    'type' => 'LEFT'

                ),

            ),

            'conditions' => array(

                "crm_lead_member_master.customer_id" => $customer_id

            )

        );



        $user_arr = get_relation($table, $options);

        return $user_arr;

    }



    public function get_leads_count_admin($sWhere, $agent_id) {



        $this->create_view_lead();

        $table = 'lead_admin';



        if ($agent_id != "") {

            $options = array(

                'fields' => array(

                    'count(*) as total'

                ),

                'conditions' => array(

                    "lead_add_by" => $agent_id,

                ),

            );

        } else {

            $options = array(

                'fields' => array(

                    'count(*) as total'

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



    function all_broker_list() {

        $table = "crm_user_tbl";

        $options = array(

            'fields' => array(

                '0' => 'user_id',

                '1' => 'display_name',

            ),

            'conditions' => array(

                "is_deleted" => 'N',

                "roll_id" => '2',

                "is_approved" => 'Y'

            ),

            'ORDER BY' => array(

                'ASC'

            )

        );

        $broker_arr = get_relation($table, $options);

        return $broker_arr;

    }



    function get_leads_agency($sLimit, $sWhere, $sOrder, $leadPerents) {

        $table = 'crm_lead_member_primary as primary';

        $options = array(

            'fields' => array(

                'CONCAT(primary.customer_first_name," ",primary.customer_last_name) AS cname,primary.customer_email,master.customer_created_date,master.customer_id,master.is_active,user_master.display_name'

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

//            'conditions' => array(

//                "master.is_delete = 'N', master.customer_status = 'lead', master.broker_id $agency_id"

//            ),

            'conditions' => "master.is_delete = 'N' AND master.customer_status = 'lead' AND master.broker_id IN(" . $leadPerents . ")",

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



    public function get_leads_count_agency($sWhere, $leadPerents) {

        $table = 'crm_lead_member_primary';

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

            'conditions' => "crm_lead_member_master.is_delete = 'N' AND crm_lead_member_master.customer_status = 'lead' AND crm_lead_member_master.broker_id IN(" . $leadPerents . ")",

        );

        if (strlen($sWhere) > 0) {

            $options['conditions'] = $options['conditions'] . ' AND ' . $sWhere;

        }



        $user_count = get_relation($table, $options);

        return $user_count[0]['total'];

    }



    public function customer_child_count($customer_id = null) {

        if ($customer_id == null) {

            exit('Customer ID ISSUE || AGENCY VUE || ERROR');

        }

        $options = array('fields' => array(

                'CONCAT (customer_child_first_name," ",customer_child_last_name) as child_name'

            ),

            'conditions' => array(

                'customer_id' => $customer_id

            )

        );

        $totalChild = get_relation('crm_lead_member_child', $options);

        if (!empty($totalChild)) {

            return $totalChild;

        }

    }



    public function customer_spouse_count($customer_id = null) {

        if ($customer_id == null) {

            exit('Customer ID ISSUE || AGENCY VUE || ERROR');

        }

        $options = array('fields' => array(

                'CONCAT (customer_spouse_first_name," ",customer_spouse_last_name) as spouse_name'

            ),

            'conditions' => array(

                'customer_id' => $customer_id

            )

        );

        $totalSpouse = get_relation('crm_lead_member_spouse', $options);

        if (!empty($totalSpouse)) {

            return $totalSpouse[0]['spouse_name'];

        }

    }

    //add 22-12-2017
    public function change_lead_status_to_member($customer_id)
    {
        $this->db->set('customer_status','memeber');
        $this->db->where('customer_id', $customer_id);
        $result = $this->db->update('crm_lead_member_master');
        return $result;
    }

    public function add_new_member($userDetail)
    {
        $this->db->set('email', $userDetail['email']);
        $this->db->set('roll_id', $userDetail['roll_id']);
        $this->db->set('password', $userDetail['password']);
        $this->db->set('display_name', $userDetail['display_name']);
        $id = $this->db->insert('crm_user_tbl');

        return $id;
    }

}

