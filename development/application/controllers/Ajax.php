<?php
/**
 * Description of Ajax
 *
 * @author dhareen
 */
class Ajax extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function chk_domain() {
        $domain_name = $this->input->post('domain');
        $con = array('domain_name' => $domain_name, 'is_active' => 'Y');
        $this->db->select('domain_id');
        $this->db->where($con);
        $query = $this->db->get('crm_domain_master');
        if ($query->num_rows() > 0) {
            echo '<p class="error-msg email-custom" style="color: #C44B4D;margin-top: 10px;"><i>Domain is already used by another, please try other domain.</i></p>';
        } else {
            echo '<i>Domain is valid</i>';
        }
    }

    public function chk_email() {
        $email = $this->input->post('email');
        $con = array('email' => $email, 'is_deleted' => 'N');
        $this->db->select('user_id');
        $this->db->where($con);
        $query = $this->db->get('crm_user_tbl');
        if ($query->num_rows() > 0) {
            echo '<p class="error-msg email-custom" style="color: #C44B4D;margin-top: 10px;"><i>Email address is already used by another, please try other email address.</i></p>';
        } else {
            echo '<i>Email address is valid</i>';
        }
    }

    public function getcity() {
        $ust = $this->input->post('ustid');
        $con_array = array('state_code' => $ust);
        $this->db->where($con_array);
        $query = $this->db->get('crm_cities');
        $citylist = $query->result();
        $html = "<select class='form-control required' id='user_city' name='sel_city'>";
        $html .= "<option value=''>Please Select City</option>";
        foreach ($citylist as $q) {
            $html = $html . "<option value='$q->city'>$q->city</option>";
        }
        $html .= "</select>";
        echo $html;
    }

}
