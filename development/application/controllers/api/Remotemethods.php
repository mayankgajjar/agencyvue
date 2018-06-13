<?php

defined('BASEPATH') OR exit('No direct script access allowed');
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class Remotemethods extends REST_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function testing_get() {
        $id = (int) $this->get('id');
        $message = ['Success'];
        $this->set_response($message, REST_Controller::HTTP_OK); // NO_CONTENT (204) being the HTTP response code
    }

    public function loginmed360_get() {
        $encodeChecker = 0;
        $username = base64_decode(urldecode($this->get('username')));
        $password = base64_decode(urldecode($this->get('password')));
//        $username = $this->get('username');
//        $password = $this->get('password');
//        if (base64_decode(urldecode($this->get('username')), true) === false) {
//            echo 'Not a Base64-encoded Username';
//            $encodeChecker = 1;
//        }
//        if (base64_decode(urldecode($this->get('password')), true) === false) {
//            echo 'Not a Base64-encoded Password';
//            $encodeChecker = $encodeChecker + 1;
//        }
//        if ($encodeChecker > 0) {
//            exit("EncodeCheker is NOT Zero");
//        }
//        if ($encodeChecker == 0) {
//            exit("WORKING");
//        }
        if ($username != "" && $password != "") {
            if (base64_decode($this->get('username'), true) === false) {
                $encodeChecker = 1;
            }
            if (base64_decode($this->get('password'), true) === false) {
                $encodeChecker = $encodeChecker + 1;
            }
            if ($encodeChecker == 0) {
                $this->load->model('user');
                $user = $this->user->login($username, $password);
                $msg = "";
                if ($user != "") {
                    if ($user['roll_id'] == 4) {
                        $msg = ["status" => "true", "userID" => urlencode(base64_encode($user['user_id'])), "userEmail" => urlencode(base64_encode($user['email'])), "methodID" => "loginmed360"];
                        $this->set_response($msg, REST_Controller::HTTP_OK);
                    } else {
                        $msg = ["status" => "member_login_only"];
                        $this->set_response($msg, REST_Controller::HTTP_OK);
                    }
                } else {
                    $msg = ["status" => "error_details"];
                    $this->set_response($msg, REST_Controller::HTTP_OK);
                }
            } elseif ($encodeChecker > 0) {
                $msg = ["status" => "access_denied", "code" => "Encoding_Issue"];
                $this->set_response($msg, REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $msg = ["status" => "access_denied"];
            $this->set_response($msg, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function logoutmed360_get() {
        $methodID = base64_decode(urldecode($this->get('methodID')));
        if ($methodID == "logoutmed360") {
            $this->session->unset_userdata('user_info');
            $msg = ["status" => "logout"];
            $this->set_response($msg, REST_Controller::HTTP_OK);
        } else {
            $msg = ["status" => "access_denied"];
            $this->set_response($msg, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

}
