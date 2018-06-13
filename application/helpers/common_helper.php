<?php

/* * * For Printing Array. * @param array value  * @author HAD */

function pr_arr($post) {
    echo'<pre>';
    print_r($post);
    echo'</pre>';
}

/* * * For Printing Array AND DIE * @param array value * @author HAD */

function pr_exit($post) {
    echo'<pre>';
    print_r($post);
    echo'</pre>';
    exit();
}

function state_selector($selected_state, $name) {
    $state_json = file_get_contents(base_url() . '/assets/json_db/states.json');
    $state_json = json_decode($state_json);
    $html_select_box = "<select class='form-control required' name='$name' onchange='city_selector()'>";
    $html_select_box .= "<option value=''>Select State</option>";
    foreach ($state_json as $state) {
        $selected = "";
        if ($selected_state == $state->name) {
            $selected = "selected";
        } $html_select_box .= "<option value='$state->name' $selected>$state->name</option>";
    } $html_select_box .= "</select>";
    return $html_select_box;
}

function city_selector($selected_state, $name) {
    $state_json = file_get_contents(base_url() . '/assets/json_db/states.json');
    $state_json = json_decode($state_json);
    $html_select_box = "<select class='form-control required' name='$name'>";
    $html_select_box .= "<option value=''>Select State</option>";
    foreach ($state_json as $state) {
        $selected = "";
        if ($selected_state == $state->name) {
            $selected = "selected";
        } $html_select_box .= "<option value='$state->name' $selected>$state->name</option>";
    } $html_select_box .= "</select>";
    return $html_select_box;
}

/** For getting all state list * */
function get_all_state() {
    $state = get_data('crm_states', '0');
    return $state;
}

/** For getting SUBDOMAIN VALUE FROM USERID  * */
function get_subdomain_id($user_id = null) {
    if ($user_id != null) {
        $where = array('user_id' => $user_id);
        $data_domain = get_data('crm_domain_master', 1, $where);
        return $data_domain['domain_name'];
    } else {
        return "USER ID NULL ERROR IN SUBDOMAIN FINDER";
    }
}

function subdomain_control() {
    $CI = & get_instance();
    $host = $_SERVER['HTTP_HOST'];
    $host = str_replace("www.", " ", $host);
    $domainValue = explode(".", $host);
    if (count($domainValue) >= 3) {
        $CI->db->select('domain_name');
        $totalDomain = $CI->db->get('crm_domain_master')->result_array();
        if (!empty($totalDomain)) {
            $totalDomain = array_column($totalDomain, 'domain_name');
            if (in_array($domainValue[0], $totalDomain)) {
                redirect($CI->config->item('http') . $domainValue[0] . '.' . $CI->config->item('main_url') . 'login');
            } else {
                redirect();
            }
        }
    }
}

function get_global_userID($memberID = null) {
    if ($memberID == null) {
        exit('MEMBER ID NULL || ERROR');
    } else {
        $tbl_name = "crm_lead_member_master";
        $single = 1;
        $where = array('customer_id' => $memberID);
        $user_id = get_data($tbl_name, $single, $where);
        return $user_id['user_id'];
    }
}
