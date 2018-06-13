<?php

class user extends CI_Model {

    function login($email, $password) {
        $where = array('email' => $email,'password' => md5($password),'is_deleted' => 'N','is_approved' => 'Y','is_active' => 'Y');
        $this->db->select()->from('crm_user_tbl')->where($where);
        $query = $this->db->get();
        return $query->first_row('array');
    }

    function getDetails_by_id($userID) {
        $where = array('user_id' => $userID,'is_deleted' => 'N');
        $this->db->select()->from('crm_user_tbl')->where($where);
        $query = $this->db->get();
        return $query->first_row('array');
    }

}
