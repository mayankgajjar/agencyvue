<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('send_mail'))
{    
    function send_mail($to, $subject, $body) {
		$CI = & get_instance();
		$CI->load->library('My_PHPMailer');
		$mail = new PHPMailer();
		$mail->debug = 2;
		$mail->IsSMTP(); // we are going to use SMTP
		$mail->SMTPAuth = true; // enabled SMTP authentication
		$mail->SMTPSecure = "ssl";  // prefix for secure protocol to connect to the server
		$mail->Host = "smtp.gmail.com";      // setting GMail as our SMTP server
		$mail->Port = 465;     // SMTP port to connect to GMail
		$mail->Username = "demo.narola@gmail.com";  // user email address
		$mail->Password = "Ke6g7sE70Orq3Rqaqa";	    // password in GMail
		$mail->Transport = 'Smtp';
		$mail->SetFrom('demo.narola@gmail.com', 'Spotashoot Support Team');  //Who is sending the email
		$mail->AddReplyTo("demo.narola@gmail.com", "Spotashoot Support Team");  //email address that receives the response
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
}


/**
 * send_mail_front function
 * this function is used to send email
 * @return void
 * @author 
 **/
function send_mail_front($to, $from, $subject, $body) {
	$CI = & get_instance();
	$CI->load->library('My_PHPMailer');
	$mail = new PHPMailer();
	// $mail->SMTPDebug  = 2;    
	$mail->IsSMTP(); // we are going to use SMTP
	$mail->SMTPAuth = true; // enabled SMTP authentication
	$mail->SMTPSecure = "ssl";  // prefix for secure protocol to connect to the server
	$mail->Host = "smtp.gmail.com";      // setting GMail as our SMTP server
	$mail->Port = 465;     // SMTP port to connect to GMail
	$mail->Username = "demo.narola@gmail.com";  // user email address
	$mail->Password = "Ke6g7sE70Orq3Rqaqa";	    // password in GMail
	$mail->Transport = 'Smtp';
	$mail->SetFrom($from, 'Property Insurance Team');  //Who is sending the email
	$mail->AddReplyTo($from, "");  //email address that receives the response
	$mail->IsHTML(true);
	$mail->Subject = $subject;
	$mail->Body = $body;
	// $mail->AddAddress($to);
	$mail->AddAddress('kap@narola.email');
	if (!$mail->send()) {
	    return 1;
	} else {
	    return 1;
	}
}

/**
 * contact_feedback_mail_send function
 * this function is used to send email with custom sender and attachment
 * @return void
 * @author 
 **/
function contact_feedback_mail_send($to, $from, $from_name, $subject, $body, $attached = null) {
	$CI = & get_instance();
	$CI->load->library('My_PHPMailer');
	$mail = new PHPMailer();
	// $mail->SMTPDebug  = 2;    
	$mail->IsSMTP(); // we are going to use SMTP
	$mail->SMTPAuth = true; // enabled SMTP authentication
	$mail->SMTPSecure = "ssl";  // prefix for secure protocol to connect to the server
	$mail->Host = "	smtp-pulse.com";      // setting GMail as our SMTP server
	$mail->Port = 465;     // SMTP port to connect to GMail
	$mail->Username = "info@spotashoot.com";  // user email address
	$mail->Password = "YL98AqDFC6";    // password in GMail
	$mail->Transport = 'Smtp';
	$mail->SetFrom($from, 'Spotashoot Team');  //Who is sending the email
	$mail->AddReplyTo($from, "");  //email address that receives the response
	if($attached != null){
		$mail->AddAttachment($attached['cover_photo']['tmp_name'], $attached['cover_photo']['name']);
	}
	$mail->IsHTML(true);
	$mail->Subject = $subject;
	$mail->Body = $body;
	// $mail->AddAddress($to);
	$mail->AddAddress('kap@narola.email');
	if (!$mail->send()) {
	    return 1;
	} else {
	    return 1;
	}
}

/**
 * send_newsletter function
 * used send newsletters to set of users
 * @return void
 * @author KAP
 **/
function send_newsletter($to, $from, $subject, $body){
	$CI = & get_instance();
	$CI->load->library('My_PHPMailer');
    $mail = new PHPMailer();
    $mail->IsSMTP(); // we are going to use SMTP
    $mail->SMTPAuth = true; // enabled SMTP authentication
    $mail->SMTPSecure = "ssl";  // prefix for secure protocol to connect to the server
    $mail->Host = "	smtp-pulse.com";      // setting GMail as our SMTP server
	$mail->Port = 465;     // SMTP port to connect to GMail
	$mail->Username = "info@spotashoot.com";  // user email address
	$mail->Password = "YL98AqDFC6";     // password in GMail
    $mail->Transport = 'Smtp';
    $mail->SetFrom($from, 'Spotashoot Team');  //Who is sending the email
    $mail->IsHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $body;
    foreach ($to as $key => $value) {
        $mail->ClearAllRecipients();
        $mail->AddAddress($value['email_id']);
        $mail->send();
    }

    /**
 * send_forget_password function
 * used send Forget Password
 * @return void
 * @author KAP
 **/
function send_forget_password($to, $subject, $body){

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
}