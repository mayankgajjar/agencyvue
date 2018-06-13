<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function index() {
        //$this->session->set_userdata('user_info', 'test');
        //$this->load->view('welcome_message');
//        $stripeSetting = get_stripe_setting();
//        pr_exit($stripeSetting);
//        if ($stripeSetting['enable_test'] == "YES") {
//            $agenciesFee = $stripeSetting['registration_fee'] * 100;
//            $config['stripe_key_test_public'] = $stripeSetting['test_secret_key'];
//            $config['stripe_key_test_secret'] = $stripeSetting['test_publishable_key'];
//            $config['stripe_test_mode'] = TRUE;
//            $config['stripe_verify_ssl'] = FALSE;
//        }
//        // Create the library object
//        $this->load->library('stripe', $config);
//        $card_data = array(
//            'number' => '4012888888881881',
//            'cvc' => '1234',
//            'exp_month' => 05,
//            'exp_year' => 2020,
//            'name' => 'VISA',
//        );
//
//        $tokenData = $this->stripe->card_token_create($card_data, $agenciesFee);
//        $tokenData = json_decode($tokenData);
//        echo "<pre>";
//        print_r($tokenData);
//        echo "</pre>";
//        $token = $tokenData->id;
//
//        echo $this->stripe->charge_card($agenciesFee, $token, 'Test PAyment');
        //$this->stripe->charge_refund('ch_18CSrpCFXs0qY9IAOGZ5RD5dgsd3');
//        $refund = stripe_refund_registration_agnecy(224);
//        pr_exit($refund);
        exit("H4r3eN || LOOKED");
    }

}
