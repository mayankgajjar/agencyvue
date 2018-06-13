<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Agency user setup PUBLIC Access
 * @author HAD
 */
class Agencysignup extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('broker');
    }

    /**
     * @method Index Method as class default method
     * @uses Display profile info and load profile view
     * @author HAD
     */
    public function index() {
        $data['title'] = "Agency Setup Form || Agencyvue";
        $data['state'] = get_data($tbl_name = 'crm_states', $single = 0);
        if ($this->input->post()) {
            $this->form_validation->set_rules('agency_name', 'Agency Name', 'required');
            $this->form_validation->set_rules('contact_email', 'Contact Email', 'required|valid_email');
            $this->form_validation->set_rules('customer_service_number', 'Customer Service Number', 'required');
            $this->form_validation->set_rules('phone_number', 'Phone Number', 'required');
            $this->form_validation->set_rules('address', 'Address', 'required');
            $this->form_validation->set_rules('sel_state', 'State', 'required');
            $this->form_validation->set_rules('sel_city', 'City', 'required');
            $this->form_validation->set_rules('domain_name', 'Domain Name', 'required');
            $this->form_validation->set_rules('login_email', 'Login Email ID', 'required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|matches[cpassword]');
            $this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required|min_length[5]|matches[password]');
            if ($this->form_validation->run() == FALSE) {
                $this->form_validation->set_error_delimiters();
            } else {
                $locationImage = "assets/crm_image/agencieslogo/";
                $agnecyLogo = FileInsert($locationImage, "agency_logo", "image", "2097152");
                $location = "assets/crm_docs/agency_uploaded_docs/";
                $agency_w9 = FileInsert($location, "agency_w9", "doc", "2097152");
                $agency_dd = FileInsert($location, "agency_direct_deposit", "doc", "2097152");
                $agency_ca = FileInsert($location, "agency_contract_agreement", "doc", "2097152");
                if ($agency_w9['status'] == 1 && $agency_dd['status'] == 1 && $agency_ca['status'] == 1 && $agnecyLogo['status'] == 1) {
                    $userMst = array('email' => $this->input->post('login_email'), 'display_name' => $this->input->post('agency_name'), 'password' => md5($this->input->post('password')), 'roll_id' => ('5'));
                    $user_tbl = insert_update_data($ins = 1, $table_name = 'crm_user_tbl', $ins_data = $userMst);
                    $user_id = $this->db->insert_id();
                    $data_crm_domain_master = array('user_id' => $user_id, 'domain_name' => $this->input->post('domain_name'));
                    $domain = insert_update_data($ins = 1, $table_name = 'crm_domain_master', $ins_data = $data_crm_domain_master);
                    $agencyBasic = array(
                        'user_id' => $user_id,
                        'agency_name' => $this->input->post('agency_name'),
                        'contact_name' => $this->input->post('contact_name'),
                        'agency_email' => $this->input->post('contact_email'),
                        'agency_phone' => $this->input->post('phone_number'),
                        'agency_address' => $this->input->post('address'),
                        'agency_sub_address' => $this->input->post('address_addtional'),
                        'agency_state' => $this->input->post('sel_state'),
                        'agency_city' => $this->input->post('sel_city'),
                        'agency_zip_code' => $this->input->post('zipcode'),
                        'agency_customer_service_number' => $this->input->post('customer_service_number'),
                        'agency_customer_service_email' => $this->input->post('contact_email'),
                        'agency_image' => $agnecyLogo['msg'],
                        'agency_domain' => $this->input->post('domain_name')
                    );
                    $agencyTbl = insert_update_data($ins = 1, $table_name = 'crm_agencies_basic', $ins_data = $agencyBasic);
                    $agencyBank = array(
                        'agency_id' => $user_id,
                        'bank_name' => $this->input->post('angecy_bank_name'),
                        'bank_add' => $this->input->post('angecy_bank_add'),
                        'bank_city' => $this->input->post('bank_city'),
                        'bank_state' => $this->input->post('bank_state'),
                        'bank_zipcode' => $this->input->post('bank_zipcode'),
                        'agency_name_on_account' => $this->input->post('name_on_account'),
                        'agency_account_number' => $this->input->post('account_number'),
                        'angecy_routing_number' => $this->input->post('routing_number'),
                    );
                    $agencybankTble = insert_update_data($ins = 1, $table_name = 'crm_agencies_bank_details', $ins_data = $agencyBank);
                    $agencyDoc = array(
                        'agency_id' => $user_id,
                        'agency_w9_form' => $agency_w9['msg'],
                        'agency_direct_deposit' => $agency_dd['msg'],
                        'agency_contract_agreement' => $agency_ca['msg']
                    );
                    $agencydocTbl = insert_update_data($ins = 1, $table_name = 'crm_agencies_documents', $ins_data = $agencyDoc);

                    if ($agencyTbl && $domain && $user_tbl && $agencybankTble && $agencydocTbl) {
                        $msg = "Hello," . $this->input->post('agency_name') . "<br><br>
                            Thank You for your registration.<br><br>
                            You are successfully registered in amenitybenefits.<br><br>
                            Once admin approve your registration request, then you able to login in our website.<br><br>
                            Thank You,<br><br>
                            Amenitybenefits";
                        $subject = "Thank You for your registration";
                        $to_email = $this->input->post('contact_email');
                        send_broker_email_process($to_email, $subject, $msg);
                        redirect('agencysignup/payment?naid=' . urlencode(base64_encode($user_id)));
                    }
                } else {
                    $msg = "";
                    if ($agency_w9['status'] == 0) {
                        $msg .= 'Agency W9 Form :' . $agency_w9['msg'] . "<br>";
                    } if ($agency_dd['status'] == 0) {
                        $msg .= 'Agency Direct Deposit Form :' . $agency_dd['msg'] . "<br>";
                    } if ($agency_ca['status'] == 0) {
                        $msg .= 'Agency Contract Agreement :' . $agency_ca['msg'] . "<br>";
                    } if ($agnecyLogo['status'] == 0) {
                        $msg .= 'Agency Logo :' . $agnecyLogo['msg'] . "<br>";
                    }
                    $this->session->set_flashdata('error', $msg);
                }
            }
        }
        $this->template->load('session_less_header', 'public/agencysignup/agencysignup', $data);
    }

    public function getcity() {
        $ust = $this->input->post('ustid');
        $con_array = array('state_code' => $ust);
        $this->db->where($con_array);
        $query = $this->db->get('crm_cities');
        $citylist = $query->result();
        $html = "<select class='form-control required' id='bank_city' name='bank_city'>";
        $html .= "<option value=''>Please Select City</option>";
        foreach ($citylist as $q) {
            $html = $html . "<option value='$q->city'>$q->city</option>";
        }
        $html .= "</select>";
        echo $html;
    }

    public function payment() {
        $data['title'] = "Stripe Payment ||AgencyVUE";
        if (isset($_REQUEST['naid'])) {
            $agency_id = base64_decode(urldecode($_REQUEST['naid']));
            $this->template->load('session_less_header', 'public/agencysignup/payment', $data);
            if ($this->input->post()) {
                $this->form_validation->set_rules('card_number', 'Card Number', 'required');
                $this->form_validation->set_rules('exp_month', 'Expiration Month', 'required');
                $this->form_validation->set_rules('exp_year', 'Expiration Year', 'required');
                if ($this->form_validation->run() == FALSE) {
                    $this->form_validation->set_error_delimiters();
                } else {
                    $cardDetailArray = array('agency_id' => $agency_id,
                        'card_number' => $this->input->post('card_number'),
                        'cvc' => $this->input->post('card_cvc'),
                        'exp_month' => $this->input->post('exp_month'),
                        'exp_year' => $this->input->post('exp_year'));
                    $cardDetailTbl = insert_update_data($ins = 1, $table_name = 'crm_agencies_card_details', $ins_data = $cardDetailArray);
                    if ($cardDetailTbl) {
                        $number = $this->input->post('card_number');
                        $cvc = $this->input->post('card_cvc');
                        $exp_month = $this->input->post('exp_month');
                        $exp_year = $this->input->post('exp_year');
                        $name = "VISA";
                        $agency_name = get_display_name($agency_id);
                        $stripeJson = stripe_payment($number, $cvc, $exp_month, $exp_year, $name, $agency_name);
                        $stripeArray = json_decode($stripeJson);
                        if (isset($stripeArray->id)) {
                            if ($stripeArray->status == 'succeeded') {
                                $updatePayment = array("is_payment" => 'Y', "agency_transaction_id" => $stripeArray->id);
                                $updateBasic = insert_update_data(0, "crm_agencies_basic", $updatePayment, array("user_id" => $agency_id));
                                if ($updateBasic) {
                                    $this->session->set_flashdata('success', "Your Payment Is Success");
                                } else {
                                    $this->session->set_flashdata('error', "Updating Data In System Is Fail");
                                    $this->session->set_flashdata('success', "Your Payment Is Success");
                                }
                                redirect("agencysignup/thankyou");
                            }
                        } elseif (isset($stripeArray->error)) {
                            $this->session->set_flashdata('error', $stripeArray->error->message);
                        } else {
                            $this->session->set_flashdata('error', "Something Went To Wrong");
                        }
                        redirect("agencysignup/payment?naid=" . $_REQUEST['naid']);
                    }
                    $this->session->set_flashdata('error', "Something Went To Wrong!");
                }
            }
        } else {
            exit("Access Denied!");
        }
    }

    public function thankyou() {
        $data['title'] = 'Thanks You || Agency VUE';
        $this->template->load('session_less_header', 'public/agencysignup/thankyou', $data);
    }

}
