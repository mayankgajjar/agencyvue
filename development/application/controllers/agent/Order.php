<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Order extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('leadorder_m');
        $this->load->model('leadorderitem_m');
        $this->data['lead_type'] = array(
            '2to30' => array(
                'name' => 'Medicare Supplement 2 To 30 Days Old',
                '249' => 2.00,
                '999' => 1.50,
                '4999' => 1.20,
                '9999' => 1.00,
                '24999' => 0.75,
                '25000' => 0.60,
            ),
            '31to85' => array(
                'name' => 'Medicare Supplement 31 To 85 Days Old',
                '249' => 1.50,
                '999' => 1.20,
                '4999' => 1.00,
                '9999' => 0.75,
                '24999' => 0.60,
                '25000' => 0.40,
            ),
            '86to365' => array(
                'name' => 'Medicare Supplement 86 To 365 Days Old',
                '249' => 0.40,
                '999' => 0.40,
                '4999' => 0.30,
                '9999' => 0.25,
                '24999' => 0.15,
                '25000' => 0.12,
            ),
            '366+' => array(
                'name' => 'Medicare Supplement 366+ Days Old',
                '249' => 0.25,
                '999' => 0.25,
                '4999' => 0.20,
                '9999' => 0.15,
                '24999' => 0.12,
                '25000' => 0.10,
            )
        );
    }

    public function checkout_temp() {

        if ($this->session->userdata('lead_cart') != '') {
            $this->load->model('templeadconvert_m');
            $grand_total = "0";
            foreach ($this->session->userdata('lead_cart') as $key => $cart_data) {
                $grand_total = $grand_total + $cart_data['sub_total'];
            }
            $grand_total1 = $grand_total * 100; // Payable Amount IN USD CENT
            $payable = $grand_total1;
            $data['transaction_id'] = '';
            $data['total_amount'] = $grand_total;
            $data['lead_type'] = $this->session->userdata('lead_type');
            $data['agent_id'] = $this->session->userdata("agent_primary")['broker_id'];
            $res = $this->leadorder_m->save($data);
            if ($res) {
                /* Lead ORDER ITEM TABLE */
                $orderId = $this->db->insert_id();
                $item_data = array();
                foreach ($this->session->userdata('lead_cart') as $key => $cart_data) {

                    $item_data['order_id'] = $orderId;
                    $item_data['qty'] = $cart_data['quantity'];
                    $item_data['item_price'] = $cart_data['lead_price'];
                    $item_data['total_price'] = $cart_data['sub_total'];
                    $item_data['csv_file_name'] = $cart_data['filename'];
                    /* $item_desc = array(
                      'ltype' => $cart_data['ltype'],
                      'filter_by_state' => $cart_data['filter_by_state'],
                      'state_code' => $cart_data['state_code'],
                      'min_age' => $cart_data['min_age'],
                      'max_age' => $cart_data['max_age'],
                      'filter_by_area_code' => $cart_data['filter_by_area_code'],
                      'filter_by_zip_code' => $cart_data['filter_by_zip_code'],
                      'cell_phone_land_line' => $cart_data['cell_phone_land_line']
                      ); */
                    $item_desc = $cart_data;
                    $item_data['item_desc'] = serialize($item_desc);
                    $resItem = $this->leadorderitem_m->save($item_data);
                    if ($resItem) {
                        $this->leadTransfer($this->session->userdata('lead_cart')[$key]['lead_ids']);
                        $orderItem_id = $this->db->insert_id();
                        $agentDetails = array('agent_id' => $this->session->userdata('agent_primary')['broker_id'], 'email' => $this->session->userdata('agent_primary')['personal_email_address']);
                        $tempData = array(
                            'agent_id' => $this->session->userdata("agent_primary")['broker_id'],
                            'agent_details' => serialize($agentDetails),
                            'lead_ids' => $this->session->userdata('lead_cart')[$key]['lead_ids'],
                            'order_item_id' => $orderItem_id
                        );
                        $tempItem = $this->templeadconvert_m->save($tempData);
                    }
                }
                // Lead Transfer Method
                $this->session->set_flashdata('success', 'Payment Successful! Your leads are being transferred.');
                $this->session->unset_userdata('lead_cart');
                //$this->leadTransfer(); //CRON JOB RUN TRANSFER PROCESS
                redirect('agent/campaign/index');
            } else {
                $this->session->set_flashdata('error', "Something Went To Wrong");
            }
        }
    }

    public function leadTransfer($leadIds){
       $table = 'crm_lead_member_master';
       $ids = explode(',',$leadIds);
       foreach ($ids as $id){
           if(intval($id) && intval($id) > 0){
           $sql = "SELECT customer_id FROM crm_lead_member_primary where member_primary_id={$id}";
           $query = $this->db->query($sql);
           $row = $query->row_array();
           $customerId = $row['customer_id'];
           if($customerId && intval($customerId) > 0){
               $brokerID = $this->session->userdata['user_info']['user_id'];
               $sql = "UPDATE {$table} SET broker_id = {$brokerID} WHERE customer_id ={$customerId}";
               $this->db->query($sql);
           }
         }
       }
    }

    public function checkout() {
        // Check condition for your cart is empty or not
        if ($this->session->userdata('lead_cart') != '') {
            $this->load->model('templeadconvert_m');

            $this->data['title'] = 'Agent | Lead Store Checkout';
            $this->data['pagetitle'] = 'Checkout';
            $this->data['validation'] = TRUE;
            $this->data['sweetAlert'] = TRUE;
            $this->data['mask'] = TRUE;
            $this->data['label'] = 'Checkout';
            $this->data['country'] = array();
            //------ For Fetch 20 Year Array
            $curyear = date("Y");
            for ($i = 0; $i < 15; $i++) {
                $year[$i] = $curyear + $i;
            }
            $this->data['year'] = $year;
            //------ End For Fetch 20 Year Array
            $this->form_validation->set_rules('card_number', 'Card Number', 'trim|required|min_length[16]|max_length[16]|numeric');
            $this->form_validation->set_rules('card_expiration_month', 'Card Expiration Month', 'trim|required');
            $this->form_validation->set_rules('card_expiration_year', 'Card Expiration Year', 'trim|required');
            $this->form_validation->set_rules('card_security_code', 'Card Security Code', 'trim|required|min_length[3]|max_length[4]|numeric');
            if ($this->form_validation->run() == TRUE) {
                // Cart Total
                $grand_total = "0";
                foreach ($this->session->userdata('lead_cart') as $key => $cart_data) {
                    $grand_total = $grand_total + $cart_data['sub_total'];
                }
                $grand_total1 = $grand_total * 100; // Payable Amount IN USD CENT
                $payable = $grand_total1;
                /**
                 * CARD info for Stripe
                 */
                $number = $this->input->post('card_number');
                $cvc = $this->input->post('card_security_code');
                $exp_month = $this->input->post('card_expiration_month');
                $exp_year = $this->input->post('card_expiration_year');
                $name = $this->input->post('card_type');
                $paymentNote = "Lead Store Purchase";
                // Stripe call
                $stripeRes = payable_stripe($payable, $number, $cvc, $exp_month, $exp_year, $name, $paymentNote);
                $stripeArray = json_decode($stripeRes);
                //if paymenet made
                if (isset($stripeArray->id)) {
                    /* Lead ORDER TABLE */
                    $data['transaction_id'] = $stripeArray->id;
                    $data['total_amount'] = $grand_total;
                    $data['lead_type'] = $this->session->userdata('lead_type');
                    $data['agent_id'] = $this->session->userdata("agent_primary")['broker_id'];
                    $res = $this->leadorder_m->save($data);
                    if ($res) {
                        /* Lead ORDER ITEM TABLE */
                        $orderId = $this->db->insert_id();
                        $item_data = array();
                        foreach ($this->session->userdata('lead_cart') as $key => $cart_data) {

                            $item_data['order_id'] = $orderId;
                            $item_data['qty'] = $cart_data['quantity'];
                            $item_data['item_price'] = $cart_data['lead_price'];
                            $item_data['total_price'] = $cart_data['sub_total'];
                            $item_data['csv_file_name'] = isset($cart_data['filename']) ? $cart_data['filename'] : 'Lead';
                            /* $item_desc = array(
                              'ltype' => $cart_data['ltype'],
                              'filter_by_state' => $cart_data['filter_by_state'],
                              'state_code' => $cart_data['state_code'],
                              'min_age' => $cart_data['min_age'],
                              'max_age' => $cart_data['max_age'],
                              'filter_by_area_code' => $cart_data['filter_by_area_code'],
                              'filter_by_zip_code' => $cart_data['filter_by_zip_code'],
                              'cell_phone_land_line' => $cart_data['cell_phone_land_line']
                              ); */
                            $item_desc = $cart_data;
                            $item_data['item_desc'] = serialize($item_desc);
                            $resItem = $this->leadorderitem_m->save($item_data);
                            if ($resItem) {
                                $this->leadTransfer($this->session->userdata('lead_cart')[$key]['lead_ids']);
                                $orderItem_id = $this->db->insert_id();
                                $agentDetails = array('agent_id' => $this->session->userdata('agent_primary')['broker_id'], 'email' => $this->session->userdata('agent_primary')['personal_email_address']);
                                $tempData = array(
                                    'agent_id' => $this->session->userdata("agent_primary")['broker_id'],
                                    'agent_details' => serialize($agentDetails),
                                    'lead_ids' => $this->session->userdata('lead_cart')[$key]['lead_ids'],
                                    'order_item_id' => $orderItem_id
                                );
                                $tempItem = $this->templeadconvert_m->save($tempData);
                            }
                        }

                        // Lead Transfer Method
                        $this->session->set_flashdata('success', 'Payment Done And System Start Lead Transfer Process');
                        $this->session->unset_userdata('lead_cart');
                        //   $this->leadTransfer(); CRON JOB RUN TRANSFER PROCESS
                        redirect('agent/campaign/index');
                    } else {
                        $this->session->set_flashdata('error', "Something Went To Wrong");
                    }
                } elseif (isset($stripeArray->error)) {
                    $this->session->set_flashdata('error', $stripeArray->error->message);
                } else {
                    $this->session->set_flashdata('error', "Something Went To Wrong");
                }
                redirect('agent/checkout/cart');
            } else {
                $this->load->view("agent/leadstore/checkout/payment", $this->data);
            }
        } else {
            $this->session->set_flashdata('error', "Sorry, Your cart is empty please add item into your card.");
            redirect('agent/checkout/cart');
        }
    }

    public function continue_shop() {
        $this->session->set_flashdata('conti_shop', 'yes');
        // For open popup according to category wise.
        $data = $this->session->userdata('lead_cart');
        $last_cart = end($data);
        $this->session->set_flashdata('conti_cat', $last_cart['category']);
        redirect('agent/campaign/index');
    }

}
