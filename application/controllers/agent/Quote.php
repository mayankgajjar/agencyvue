<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Quote extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('member');
    }

    public function index() {
        $data['title'] = 'Quote';
        $data['states'] = get_all_state();
        $this->load->model('product');
        $data['featuredProduct'] = $this->product->get_featured_product();
        $this->template->load('agent_header', 'agent/quote/add_quote', $data);
    }

    /**
     * @uses add_quote is used for add_quote data and if check box checked then also add in lead
     * @author RRA
     */
    public function add_quote() {
        $data['title'] = 'Add_Quote';
        if ($this->input->post('save')) {
            $this->session->set_userdata('cart_data', $this->input->post());
            $first_name = $this->input->post('first_name');
            $last_name = $this->input->post('last name');
            $emailid = $this->input->post('emailid');
            $dob1 = $this->input->post('dob');
            $Age = ((time() - strtotime($dob1)) / (3600 * 24 * 365));
            $age = round($Age);
            $state1 = $this->input->post('quote_state');
            $zipcode1 = $this->input->post('zipcode');
            $ful_type = $this->input->post('fulfillment_type');
            $state_id = urlencode(base64_encode($state1));
            $dob = urlencode(base64_encode($age));
            $zipcode = urlencode(base64_encode($zipcode1));
            if (isset($ful_type)) {
                $member_data = array('customer_status' => 'lead', 'broker_id' => $this->session->userdata['user_info'] ['user_id']);
                $lead_member_master = insert_update_data($ins = 1, $table_name = 'crm_lead_member_master', $ins_data = $member_data);
                $customer_id = $this->db->insert_id();
                $log = array('action_by' => $this->session->userdata['user_info']['user_id'], 'customer_id' => $customer_id, 'action' => 'created');
                $lead_log = insert_update_data($ins = 1, $table_name = 'crm_lead_log', $ins_data = $log);
                $member_primary = array('customer_id' => $customer_id,
                    'customer_first_name' => $this->input->post('first_name'),
                    'customer_last_name' => $this->input->post('last name'),
                    'customer_email' => $this->input->post('emailid'),
                    'customer_phone_number' => "",
                    'customer_dob' => $this->input->post('dob'),
                    'customer_state' => $this->input->post('quote_state'),
                    'customer_zipcode' => $this->input->post('zipcode'),
                );
                $lead_member_primary = insert_update_data($ins = 1, $table_name = 'crm_lead_member_primary', $ins_data = $member_primary);
                $this->session->set_flashdata('success', 'Lead successfully Insert!');
            }
            redirect(base_url() . 'agent/quote/find_product?state=' . $state_id . '&dob=' . $dob . '&zipcode=' . $zipcode);
        }
    }

    /**
     * @uses find_product is used for find_product data
     * @author RRA
     */
    public function find_product() {
        $data['title'] = 'Find Product';
        $state_id = base64_decode(urldecode($_REQUEST['state']));
        $age = base64_decode(urldecode($_REQUEST['dob']));
        $zip = base64_decode(urldecode($_REQUEST['zipcode']));
        $this->load->model('product');
        $data['stateProducts'] = $this->product->findproduct($state_id, $age, $zip);
       
        $this->template->load('agent_header', 'agent/quote/product_details', $data);
    }

    public function product_information(){
        $this->load->model('product');
        $globalproductid = $this->input->post('productid');
        $data['product_info'] = $this->product->product_details($globalproductid);

        $state = $data['product_info']['state_data'];
        foreach ($state as $value) {
            $statedata[] = get_state_name($value['state']);
        }
        $data['state_data'] = $statedata;


        $vendor_id = $data['product_info']['product_data']['product_vendor'];
        $this->db->select('vendor_name');
        $this->db->from('crm_vendor_primary');
        $this->db->where('vendor_id',$vendor_id);
        $query = $this->db->get();
        $data['vendor_info'] = $query->row_array();


        $new_html = $this->load->view('admin/product/product_info', $data, true);
        echo json_encode(['prod_data' => $data['product_info'], 'new_html' => $new_html]);
        die;
    }

    public function checkout(){
        $user_data = $this->session->userdata('cart_data');
        $product_data = json_decode($_POST['cart_list']);
        $this->session->set_userdata('product_data',$product_data);
              
            $user_password = randomPassword();
            $user_array = array(
                'email' => $user_data['emailid'],
                'display_name' => $user_data['first_name'] . ' ' . $user_data['last_name'],
                'password' => md5($user_password),
                'roll_id' => '4',
            );

            $user_table = insert_update_data($ins = 1, $table_name = 'crm_user_tbl', $ins_data = $user_array);
            $user_id = $this->db->insert_id();

            $master_array = array('customer_status' => 'memeber', 'broker_id' => $this->session->userdata['user_info'] ['user_id'],
                'user_id' => $user_id);

            $lead_member_master = insert_update_data($ins = 1, $table_name = 'crm_lead_member_master', $ins_data = $master_array);
            $customer_id = $this->db->insert_id();

            $data_crm_lead_member_primary = array(
                'customer_id' => $customer_id,
                'customer_first_name' => $user_data['first_name'],
                'customer_last_name' => $user_data['last_name'],
                'customer_email' => $user_data['emailid'],
                'customer_dob' => date('Y-m-d', strtotime($user_data['dob'])),
                'customer_state' => $user_data['quote_state'],
                'customer_zipcode' => $user_data['zipcode'],
            );

            $primary = insert_update_data($ins = 1, $table_name = 'crm_lead_member_primary', $ins_data = $data_crm_lead_member_primary);
            
            foreach ($product_data as $pd) {
                $prooductid = $pd->product_id;
                $pro_arr= array('product_id' => $prooductid,'member_id'=>$user_id,'added_by' => $this->session->userdata['user_info']['user_id']);
                $product_info = insert_update_data($ins = 1, $table_name = 'crm_member_products', $ins_data = $pro_arr);
                echo $this->db->last_query();
            }
            
            redirect(base_url() . 'agent/quote/member_info/'.urlencode(base64_encode($customer_id)).'');
            
            //$this->member_info($customer_id);
    }
    
    
    public function member_info($id = null) {
        $data['title'] = 'Member Information || Admin';
        $uid = base64_decode(urldecode($id));
        
        $lead_info = $this->member->get_infos($uid, 'crm_lead_member_primary', 'customer_id');
      
        $data['lead_info'] = $lead_info[0];
        

        $lead_member_spouse_info = $this->member->get_infos($uid, 'crm_lead_member_spouse', 'customer_id');
        $data['lead_member_spouse_info'] = isset($lead_member_spouse_info[0]) ? $lead_member_spouse_info[0] : array();
        $data['customer_id'] = $uid;

        $new_block['member_child'] = array();
        $new_block['customer_id'] = $uid;
        $new_block['state'] = get_data($tbl_name = 'crm_states', $single = 0);

        $child_arr = $this->member->get_infos($uid, 'crm_lead_member_child', 'customer_id', array('child_id', 'ASC'));

        if (!empty($child_arr)) {
            $i = 0;
            foreach ($child_arr as $value) {
                $select_state = $value['customer_child_state'];
                $this->db->where('state_code', $select_state);
                $query = $this->db->get('crm_cities');
                $new_block['get_city'][$i] = $query->result_array();
                $i = $i + 1;
            }

            $new_block['add_child_block_arr'] = $child_arr;
        } else {
            $new_block['add_child_block_arr'] = array();
        }

        $data['add_child_block_html'] = $this->load->view('agent/quote/get_child_view', $new_block, true);

        $data['state'] = get_data($tbl_name = 'crm_states', $single = 0);

        $con_pri = array('state_code' => $data['lead_info']['customer_state']);
        $this->db->where($con_pri);
        $query = $this->db->get('crm_cities');
        $data['city_pri'] = $query->result_array();

        if ($data['lead_member_spouse_info']) {
            $con_sop = array('state_code' => $data['lead_member_spouse_info']['customer_spouse_state']);
            $this->db->where($con_sop);
            $query = $this->db->get('crm_cities');
            $data['city_sop'] = $query->result_array();
        }
        $user = get_global_userID($uid);

        $select_product_con = array('crm_member_product_config.member_id' => $user, 'crm_member_product_config.is_active' => 'Y');
        $this->db->select('*');
        $this->db->from('crm_member_product_config');
        $this->db->where($select_product_con);
        $this->db->join('crm_products', 'crm_member_product_config.product_id = crm_products.global_product_id');
        $s_product = $this->db->get();
        $data['sel_product'] = $s_product->result_array();
        $data['res_sel_column'] = array_column($data['sel_product'], 'global_product_id');
        //$data['domain_name'] = get_subdomain_id($uid);

        $dob = date('m/d/Y', strtotime($data['lead_info']['customer_dob']));
        $cus_age = ((time() - strtotime($dob)) / (3600 * 24 * 365));
        $main_age = round($cus_age);
        $state_id = $data['lead_info']['customer_state'];
        $zip = '';
        $weights = round($data['lead_info']['customer_weight']);
        $this->load->model('product');
        $data['userid'] = get_global_userID($uid);
        $data['product_array'] = $this->product->findproduct($state_id, $main_age, $zip, $weights);
        $data['member_product_array'] = $this->product->fetch_product_data($uid);
        $data['member_product_ids'] = array_column($data['member_product_array'], 'global_product_id');
        $data['billing_info'] = get_data('crm_member_payment_info', '1', ['member_id' => $uid]);

        /*if (($this->input->post('member_vari'))) {
            $customer_id = $this->input->post('customer_id');

            $data_crm_user_tbl = array(
                'display_name' => $this->input->post('cus_first_name') . " " . $this->input->post('cus_last_name'),
            );

            $condition_crm_user_tbl = array('user_id' => $customer_id);

            $user_table = insert_update_data($ins = 0, $table_name = 'crm_user_tbl', $ins_data = $data_crm_user_tbl, $where = $condition_crm_user_tbl);
            if (!empty($_FILES['verification_script']['name'])) {

                $imagename = 'verification_script' . time() . $_FILES['verification_script']['name'];
                $config['upload_path'] = 'assets/member_verification_script/';
                $config['allowed_types'] = 'mp3';
                $config['file_name'] = $imagename;
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('verification_script')) {
                    $data['verification_script_error'] = 'Please upload valid Verification Script || mp3';
                    $this->template->load('admin_header', 'agent/quote/edit_member/<?php echo $id; ?>', $data);
                    return FALSE;
                } else {
                    if (isset($lead_info[0]['customer_verification'])) {
                        $img_path = $_SERVER['DOCUMENT_ROOT'] . '/crm/assets/member_verification_script/' . $lead_info[0]['customer_verification'];
                        unlink($img_path);
                    }
                    $data = $this->upload->data();
                    $vari_script = $data['file_name'];
                   
                }
            } else {
                $vari_script = $lead_info[0]['customer_verification'];
            }



            $data_crm_lead_member_primary = array(
                'customer_first_name' => $this->input->post('cus_first_name'),
                'customer_middle_name' => $this->input->post('cus_middle_name'),
                'customer_last_name' => $this->input->post('cus_last_name'),
                'customer_email' => $this->input->post('cus_email'),
                'customer_phone_number' => $this->input->post('cus_contact'),
                'customer_dob' => date('Y-m-d', strtotime($this->input->post('cus_dob'))),
                'customer_address' => $this->input->post('cus_address'),
                'customer_address_details' => $this->input->post('cus_sub_address'),
                'customer_city' => $this->input->post('cus_city'),
                'customer_state' => $this->input->post('cus_state'),
                'customer_zipcode' => $this->input->post('cus_zip'),
                'customer_weight' => $this->input->post('customer_weight'),
                'customer_social_security_number' => $this->input->post('cus_security_number'),
                'customer_verification' => $vari_script,
            );
           

            $condition_crm_lead_member_primary = array('customer_id' => $customer_id);

            insert_update_data($ins = 0, $table_name = 'crm_lead_member_primary', $ins_data = $data_crm_lead_member_primary, $where = $condition_crm_lead_member_primary);

            $lead_info = $this->member->get_infos($customer_id, 'crm_lead_member_spouse', 'customer_id');

            if ($this->input->post('spouse_first_name') != "") {

                if (empty($lead_info)) {

                    $data_crm_lead_member_spouse = array(
                        'customer_id' => $customer_id,
                        'customer_spouse_first_name' => $this->input->post('spouse_first_name'),
                        'customer_spouse_middle_name' => $this->input->post('spouse_middle_name'),
                        'customer_spouse_last_name' => $this->input->post('spouse_last_name'),
                        'customer_spouse_email' => $this->input->post('spouse_email_address'),
                        'customer_spouse_phone_number' => $this->input->post('spouse_phone_no'),
                        'customer_spouse_dob' => date('Y-m-d', strtotime($this->input->post('spouse_dob'))),
                        'customer_spouse_address' => $this->input->post('spouse_address'),
                        'customer_spouse_address_details' => $this->input->post('spouse_sub_address'),
                        'customer_spouse_city' => $this->input->post('spouse_city'),
                        'customer_spouse_state' => $this->input->post('customer_spouse_state'),
                        'customer_spouse_zipcode' => $this->input->post('spouse_zipcode'),
                        'customer_spouse_social_security_number' => $this->input->post('spouse_ssn'),
                    );

                    insert_update_data($ins = 1, $table_name = 'crm_lead_member_spouse', $ins_data = $data_crm_lead_member_spouse);
                } else {

                    $data_crm_lead_member_spouse = array(
                        'customer_spouse_first_name' => $this->input->post('spouse_first_name'),
                        'customer_spouse_middle_name' => $this->input->post('spouse_middle_name'),
                        'customer_spouse_last_name' => $this->input->post('spouse_last_name'),
                        'customer_spouse_email' => $this->input->post('spouse_email_address'),
                        'customer_spouse_phone_number' => $this->input->post('spouse_phone_no'),
                        'customer_spouse_dob' => date('Y-m-d', strtotime($this->input->post('spouse_dob'))),
                        'customer_spouse_address' => $this->input->post('spouse_address'),
                        'customer_spouse_address_details' => $this->input->post('spouse_sub_address'),
                        'customer_spouse_city' => $this->input->post('spouse_city'),
                        'customer_spouse_state' => $this->input->post('customer_spouse_state'),
                        'customer_spouse_zipcode' => $this->input->post('spouse_zipcode'),
                        'customer_spouse_social_security_number' => $this->input->post('spouse_ssn'),
                    );

                    $condition_crm_lead_member_spouse = array('customer_id' => $customer_id);
                    insert_update_data($ins = 0, $table_name = 'crm_lead_member_spouse', $ins_data = $data_crm_lead_member_spouse, $where = $condition_crm_lead_member_spouse);
                }
            }

            $list = $this->input->post('form');

            foreach ($list as $key => $value) {
                if ($value['customer_child_first_name'] != "") {

                    $child_array = array(
                        'customer_id' => $customer_id,
                        'customer_child_first_name' => $value['customer_child_first_name'],
                        'customer_child_middle_name' => $value['customer_child_middle_name'],
                        'customer_child_last_name' => $value['customer_child_last_name'],
                        'customer_child_email' => $value['customer_child_email'],
                        'customer_child_phone_number' => $value['customer_child_phone_number'],
                        'customer_child_dob' => date('Y-m-d', strtotime($value['customer_child_dob'])),
                        'customer_child_address' => $value['customer_child_address'],
                        'customer_child_address_details' => $value['customer_child_address_details'],
                        'customer_child_city' => $value['customer_child_city'],
                        'customer_child_state' => $value['customer_child_state'],
                        'customer_child_zipcode' => $value['customer_child_zipcode'],
                        'customer_child_social_security_number' => $value['customer_child_social_security_number'],
                    );

                    if ($value['status'] == 'new') {
                        insert_update_data($ins = 1, $table_name = 'crm_lead_member_child', $ins_data = $child_array);
                    }
                    if ($value['status'] == 'old') {
                        $condition_crm_lead_member_child = array('child_id' => $value['child_id']);
                        insert_update_data($ins = 0, $table_name = 'crm_lead_member_child', $ins_data = $child_array, $where = $condition_crm_lead_member_child);
                    }
                }
            }


            $log = array('action_by' => $this->session->userdata['user_info']['user_id'], 'customer_id' => $customer_id, 'action' => 'Update');
            $member_log = insert_update_data($ins = 1, $table_name = 'crm_member_log', $ins_data = $log);

            $this->session->set_flashdata('success', 'Member Successfully Updated!');
            echo redirect(base_url() . 'agent/members');
        }*/


        $data['member_product_array'] = $this->product->fetch_product_data($user);
        $data['member_product_ids'] = array_column($data['member_product_array'], 'global_product_id');
        $data['billing_info'] = get_data('crm_member_payment_info', '1', ['member_id' => $uid]);

     
        $uid1 = get_global_userID($uid);
       
        $PC = array('member_id' => $uid1, 'is_status' => 'Y');
        $this->db->select('product_id');
        $this->db->from('crm_member_products');
        $this->db->where($PC);
        $buyProductID = $this->db->get();

        $data['buyProductID'] = $buyProductID->result_array();
       
        $data['memberProducts'] = array_column($data['buyProductID'],'product_id');

        $id_str = implode(',',$data['memberProducts'] );

        if(sizeof($data['memberProducts'])>0){
             $product_query = $this->db->query('SELECT * FROM `crm_product_state` as `states` 
            JOIN `crm_products` as `products` ON `states`.`global_product_id` = `products`.`global_product_id` 
            JOIN `crm_product_age_weight_height` as `weight` ON `weight`.`global_product_id` = `states`.`global_product_id` 
            WHERE `weight`.`max_age` >= '.$main_age.' AND `weight`.`min_age` <= '.$main_age.' AND `states`.`state` = "'.$state_id.'" AND `weight`.`max_weight` >= '.$weights.' 
            AND `weight`.`min_weight` <= '.$weights.' AND products.global_product_id NOT IN('.$id_str.') AND `products`.`is_deleted` = "N" AND `products`.`product_status` = "active"');
            $data['product_array01'] = $product_query->result_array();
        }else{
            $data['product_array01'] = $data['product_array'];
        }
        
        $this->template->load('agent_header', 'agent/quote/edit_member', $data);
        
    }
    
}

?>