<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Campaign extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->library('boberdoo');
        $partnerId = $this->getBoberdooUserId();
        if($partnerId == ''){
            $this->session->set_flashdata('error', 'Please create Lead Store user by clicking the link from profile menu.');
        }
        $data = $this->boberdoo->getPartnerInfo($partnerId);
    }

    /**
     * @uses open leads index page
     * @author MGA
     */
    public function index() {
        //pr_exit($_SESSION);
        $data['title'] = 'Lead Store';
        $partnerId = $this->getBoberdooUserId();
        $partnerInfo = $this->boberdoo->getPartnerInfo($partnerId);
        if(isset($partnerInfo->response->partner_account_balance)){
            $data['balance'] = $partnerInfo->response->partner_account_balance;
        }else{
            $data['balance'] = '0.00';
        }
        $list = $this->boberdoo->getCampaign($partnerId);
        $this->db->join('crm_lead_order_item', 'crm_lead_order_item.order_id = crm_lead_order.order_id');
        $this->db->order_by("crm_lead_order.order_id", "DESC");
        $data['lead_order'] = $this->db->get('crm_lead_order')->result_array();
        $data['campaigns'] = $list;
        $this->template->load('agency_header', 'agency/campaign/index', $data);
    }

    public function changeStatus(){

        $post = $this->input->post();
        if($post){
            $partnerId = $partnerId = $this->getBoberdooUserId();;
            $status = $post['status'];
            $campaignId = $post['id'];
            $response = $this->boberdoo->setCampaignStatus($partnerId, $campaignId, $status);
            if($response['error'] == true){
                $error = $response['message']->error;
                $this->session->set_flashdata('error', implode("\n", $error));
            }
            if($response['error'] == false){
                $response = $response['message'];
                $msg = $response->result.'!';
                $this->session->set_flashdata('success', $msg);
            }
            return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($response));
        }
    }

    public function createpartner()
    {
        $brokerId = $this->session->userdata('user_info')['user_id'];
        $query = "SELECT * FROM crm_agencies_basic WHERE user_id = {$brokerId}";
        $query = $this->db->query($query);
        $agency_details = $query->row_array();
        $params = array(
            'Login' => $agency_details['agency_email'],
            'Password' => 'Broker#@875',
            'Company_Name' => 'AgencyVUE',
            'First_Name' => $agency_details['agency_name'],
            'Last_Name' => $agency_details['agency_name'],
            'Address' => $agency_details['agency_address'],
            'City' => $agency_details['agency_city'],
            'State' => $agency_details['agency_state'],
            'Country' => 'United States',
            'Zip' => $agency_details['agency_zip_code'],
            'Phone' => substr($agency_details['agency_phone'], 0, 3).'-'.substr($agency_details['agency_phone'], 3, 3).'-'.substr($agency_details['agency_phone'],6).' Ext. 456',
            'Contact_Email' => $agency_details['agency_email'],
            'Lead_Email' => $agency_details['agency_email'],
            'Delivery_Option' => 0,
            'Status' => 2,
        );
        $response = $this->boberdoo->createPartner($params);
        if($response['error'] == true){
            $error = $response['message']->error;
            $this->session->set_flashdata('error', implode("\n", $error)."\n". "Please change the field and click the link again.");
            redirect('agency/profile','refresh');
        }
        if($response['error'] == false){
            $response = $response['message'];
            $boberdooUserId = $response->partner_id;
            $query = "UPDATE crm_agencies_basic SET boberdoo_user_id = {$boberdooUserId} WHERE user_id = {$brokerId}";
            $this->db->query($query);
            $this->session->set_flashdata('success', 'Lead Store successfully created!');
            redirect('agency/campaign/index','refresh');
        }
    }

    public function addfund(){
        $partnerId = $this->getBoberdooUserId();
        $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
        if($this->form_validation->run() == false){
            $errors = validation_errors();
            $this->session->set_flashdata('error', $errors);
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array('success' => false ,'message' => $errors )));
        }else{
            $post = $this->input->post();
            $params = array(
                'Partner_ID' => $partnerId,
                'Amount' => $post['amount'],
                'Operation_Type' => 2,
                'Comments' => $post['comment']
            );

            $response = $this->boberdoo->submtPayment($params);
            pr_exit($response);
            if($response['error'] == true){
                $error = $response['message']->error;
                $this->session->set_flashdata('error', implode("\n", $error));
            }
            if($response['error'] == false){
                $response = $response['message'];
                $msg = $response->result.'! '."\n"." Total Balance:: ".$response->total_balance;
                $this->session->set_flashdata('success', $msg);
            }
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array('success' => true ,'message' => $response )));
        }

    }

    private function getBoberdooUserId(){
        $brokerId = $this->session->userdata('user_info')['user_id'];
        $query = "SELECT boberdoo_user_id FROM crm_agencies_basic WHERE user_id = {$brokerId}";
        $query = $this->db->query($query);
        $row = $query->row_array();
        return $partnerId = $row['boberdoo_user_id'];
    }

}