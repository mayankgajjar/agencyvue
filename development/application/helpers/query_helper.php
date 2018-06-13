<?php

/**
 * @Function: delete_data()
 * @uses: This function is used for delete data in to DB.
 * @param: $tbl_name string name of table.
 * @param: $where condition for delete data.
 * @author: MGA
 */
function delete_data($tbl_name = null, $where = null) {
    $CI = & get_instance();
    $CI->db->where($where);
    $query = $CI->db->delete($tbl_name);
    return $query;
}

/**
 * @Function: insert_update_data()
 * @uses: This function is used to insert and update data.
 * @param: $ins is used for identified data insert or update, $ins 1 is used for insert otherwise update data.
 * @param: $tbl_name string name of table.
 * @param: $ins_data array data posted records.
 * @param: $where condition for update data.
 * @author: MGA
 */
function insert_update_data($ins = 1, $tbl_name = null, $ins_data = null, $where = null) {
    // echo "$ins";
    // echo "<br>";
    // echo $tbl_name;
    // print_r($ins_data);
    // echo $where;
    $CI = & get_instance();
    if ($ins == 1) {
        $query = $CI->db->insert($tbl_name, $ins_data);
    } else {
        $CI->db->where($where);
        $query = $CI->db->update($tbl_name, $ins_data);
    }

    return $query;
}

/**
 * @method: get_data()
 * @uses: This function is used to get any table of data.
 * @param: $tbl_name string name of table.
 * @param: $single is used to identified one record or multipal record, $single 1 is used for get only one record otherwise given multipal record.
 * @param: $where condition for update data.
 * @author: MGA
 */
function get_data($tbl_name = null, $single = 1, $where = null) {
    $CI = & get_instance();
    if ($single == 1) {
        $CI->db->where($where);
        $query = $CI->db->get($tbl_name);
        return $query->row_array();
    } else {
        if ($where != "") {
            $CI->db->where($where);
        }
        $query = $CI->db->get($tbl_name);
        return $query->result_array();
    }
}

/**
 * @method: get_limit_data()
 * @uses: This function is used to get data with limit query.
 * @param: $tbl_name string name of table.
 * @param: $start is used to defind limit.
 * @param: $end is offset of query.
 * @param: $where any where condition in query.
 * @author: MGA
 */
function get_limit_data($tbl_name = null, $start, $end, $where = null) {
    $CI = & get_instance();
    if ($where) { // if any where condition
        $CI->db->where($where);
    }
    $CI->db->limit($start, $end);
    $query = $CI->db->get($tbl_name);
    $result = $query->result();

    return $result;
}

/**
 * @method: get_order_data()
 * @uses: This function is used to get data in order by.
 * @param: $tbl_name string name of table.
 * @param: $field_name is used to defind field name in query.
 * @param: $order is defind order like ASC or DESC.
 * @param: $where any where condition in query.
 * @author: MGA
 */
function get_order_data($tbl_name = null, $field_name = null, $order = null, $where = null) {
    $CI = & get_instance();
    if ($where) { // if any where condition
        $CI->db->where($where);
    }
    $CI->db->order_by($field_name, $order);
    $query = $CI->db->get($tbl_name);
    //echo $CI->db->last_query();
    $result = $query->result();
    return $result;
}

/*
 * @method: Pagination()
 * @uses of method: display all user with search function.
 * @param: tot_row @tot_row given total number of row.
 * @param: url @url URL for pagination.
 * @param: per_page @per_page number of row on page.
 * @author: MGA
 */

function Pagination($tot_row, $url, $per_page) {
    $CI = & get_instance();
    $next = $CI->lang->line('Next');
    $previous = $CI->lang->line('Previous');
    $last = $CI->lang->line('Last');

    $CI->load->library('pagination');
    $config['base_url'] = $url;
    $config['total_rows'] = $tot_row;
    $config['per_page'] = $per_page;
    $config['next_link'] = $next;
    $config['prev_link'] = $previous;
    $config['last_link'] = $last;

    $CI->pagination->initialize($config);
    return $CI->pagination->create_links();
}

/**
 * send_forget_password function
 * used send Forget Password
 * @return void
 * @author MGA
 * */
function send_forget_password($to, $subject, $body) {
    $CI = & get_instance();
    $CI->load->library('My_PHPMailer');
    $mail = new PHPMailer();
    $mail->IsSMTP(); // we are going to use SMTP
    $mail->SMTPAuth = true; // enabled SMTP authentication
    $mail->SMTPSecure = "ssl";  // prefix for secure protocol to connect to the server
    $mail->Host = "mail.amenitybenefits.agencyvue.com";      // setting GMail as our SMTP server
    $mail->Port = 25;     // SMTP port to connect to GMail
    $mail->Username = "admin@amenitybenefits.agencyvue.com";  // user email address
    $mail->Password = '{PXe3iimJDV[';     // password in GMail
    $mail->Transport = 'Smtp';
    $mail->SetFrom('admin@amenitybenefits.agencyvue.com', 'Spotashoot Team');  //Who is sending the email
    $mail->IsHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->AddAddress($to);
    if (!$mail->send()) {
        return 0;
    } else {
        return 1;
    }
}

/**
 * send_forget_password_mail()
 * @uses send email for forget password
 * @author MGA
 */
function send_forget_password_mail($to_email, $subject, $msg) {
    $CI = & get_instance();
    $config['protocol'] = 'smtp';
    $config['smtp_host'] = 'ssl://smtp.gmail.com';
    $config['smtp_port'] = '465';
    $config['smtp_user'] = 'demo.narola@gmail.com';  //change it
    $config['smtp_pass'] = 'narola21'; //change it
    $config['charset'] = 'utf-8';
    $config['newline'] = "\r\n";
    $config['mailtype'] = 'html';
    $config['wordwrap'] = TRUE;

    $CI->load->library('email');
    $CI->email->initialize($config);
    $CI->email->from('demo.narola@gmail.com', 'Amenitybenefits Account'); //sender email,seander name
    $CI->email->to($to_email);   //reciever email
    $CI->email->subject($subject);
    $CI->email->message($msg);

    if ($CI->email->send()) {
        $CI->session->set_flashdata('success', 'Email Sent Successfully ! Please check your inbox');
    } else {
        show_error($this->email->print_debugger());
    }
}

/**
 * send_forget_password_mail()
 * @uses send email for forget password
 * @author MGA
 */
function send_broker_email_process($to_email, $subject, $msg) {
    $CI = & get_instance();
    $config['protocol'] = 'smtp';
    $config['smtp_host'] = 'ssl://smtp.gmail.com';
    $config['smtp_port'] = '465';
    $config['smtp_user'] = 'demo.narola@gmail.com';  //change it
    $config['smtp_pass'] = 'narola21'; //change it
    $config['charset'] = 'utf-8';
    $config['newline'] = "\r\n";
    $config['mailtype'] = 'html';
    $config['wordwrap'] = TRUE;

    $CI->load->library('email');
    $CI->email->initialize($config);
    $CI->email->from('demo.narola@gmail.com', 'Amenitybenefits registration'); //sender email,seander name
    $CI->email->to($to_email);   //reciever email
    $CI->email->subject($subject);
    $CI->email->message($msg);

    if ($CI->email->send()) {
        return 1;
    } else {
        return 0;
    }
}

/**
 * send_email()
 * @uses send email for all type of email
 * @author MGA
 */
function send_email($to_email, $subject, $msg, $title) {
    $CI = & get_instance();
    $config['protocol'] = 'smtp';
    $config['smtp_host'] = 'ssl://smtp.gmail.com';
    $config['smtp_port'] = '465';
    $config['smtp_user'] = 'demo.narola@gmail.com';  //change it
    $config['smtp_pass'] = 'narola21'; //change it
    $config['charset'] = 'utf-8';
    $config['newline'] = "\r\n";
    $config['mailtype'] = 'html';
    $config['wordwrap'] = TRUE;

    $CI->load->library('email');
    $CI->email->initialize($config);
    $CI->email->from('demo.narola@gmail.com', $title); //sender email,seander name
    $CI->email->to($to_email);   //reciever email
    $CI->email->subject($subject);
    $CI->email->message($msg);

    if ($CI->email->send()) {
        return 1;
    } else {
        return 0;
    }
}

function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

/**
 * Get relational array
 * @param type $options
 * @return type
 * @author BS
 */
function get_relation($table, $options = null, $is_esc = TRUE) {

    $ci = &get_instance();
    $default = array("fields" => "*", "conditions" => array(), "JOIN" => array(), "GROUP_BY" => array(), 'LIMIT' => array(), 'ORDER BY' => array());
    if (empty($options))
        $options = $default;
    else
        $options = array_merge($default, $options);

    $ci->db->select($options["fields"], $is_esc);
    $ci->db->from($table);

    foreach ($options["JOIN"] as $join) {
        $ci->db->join($join["table"], $join["condition"], $join["type"]);
    }

    if (!empty($options["GROUP_BY"])) {
        $ci->db->group_by($options["GROUP_BY"]);
    }

    if (count($options["conditions"]) > 0 && $options['conditions'] != "") {
        if (isset($options["conditions"]['or'])) {
            $or = $options["conditions"]['or'];
            unset($options["conditions"]['or']);
        }

        $ci->db->where($options["conditions"]);
        if (isset($or)) {
            // $or = trim($or,'OR');
            $ci->db->where($or);
        }
    }

    if (!empty($options['LIMIT'])) {
        $ci->db->limit($options['LIMIT']['start'], $options['LIMIT']['end']);
    }

    if (!empty($options['ORDER_BY']))
        $ci->db->order_by($options['ORDER_BY']['field'], $options['ORDER_BY']['order']);
    $dbObj = $ci->db->get();

    if ( $dbObj && $dbObj->num_rows() > 0) {
        $data = $dbObj->result_array();

        return $data;
    } else {
        return array();
    }
}
