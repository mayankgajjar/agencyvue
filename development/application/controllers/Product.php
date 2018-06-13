<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {
    function __construct() {
        parent::__construct();
    }

    /**
     * @method index()
     * @uses load dashboard page
     * @author MGA
     */
    
    
    public function add_product() {
        $data['title'] = "Add Product";
        $controller_name = base64_decode(urldecode($_REQUEST['con']));
        $method_name = base64_decode(urldecode($_REQUEST['met']));
        $leadid = base64_decode(urldecode$_REQUEST['lead']));
        
        $this->load->model('common');
        $data['states'] = $this->common->get_all_state();
        $data['vendors'] = $this->common->get_all_vendors();
        //$data['script'] = get_data($tbl_name = 'crm_state_verification_script', $single = 0, $where = array('is_active' => 'YES'));

        if($this->input->post('save_script')){
            $pro_id = $this->input->post('product_id');
            $script_id = $this->input->post('select_script');
            foreach ($script_id as $value) {
              $data = array('global_product_id' => $pro_id,'verification_script_id' => $value);
              $done = insert_update_data($ins = 1, $table_name = 'crm_select_product_verification_script', $ins_data = $data);
            }
            if($done){
              $this->session->set_flashdata('success', 'Product is successfully Insert!');
                if ($this->session->userdata['user_info']['roll_id'] == 1) {
                    redirect(base_url() . 'admin/'.$controller_name.'/'.$method_name.'/'.$leadid);
                } elseif ($this->session->userdata['user_info']['roll_id'] == 2) {
                    redirect(base_url() . 'agent/'.$controller_name.'/'.$method_name.'/'.urlencode(base64_encode($leadid)));
                }elseif ($this->session->userdata['user_info']['roll_id'] == 5) {
                    redirect(base_url() . 'agency/'.$controller_name.'/'.$method_name.'/'.$leadid);
                }
            }
        }


        if ($this->input->post('save')) {

            if (!empty($_FILES['product_image']['name'])) {
                $product_image = time() . $_FILES['product_image']['name'];
                $config['upload_path'] = 'assets/crm_image/products/';
                $config['allowed_types'] = 'jpeg|jpg|png';
                $config['file_name'] = $product_image;
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('product_image')) {
                    $upload_error['error'] = 'Please upload valid Product Image';
                    $this->template->load('admin_header', 'admin/products/addProduct', $upload_error);
                    return FALSE;
                } else {
                    $data = $this->upload->data();
                    $product_image = $data['file_name'];
                }
            } else {
                $product_image = '';
            }
            unset($config);
            if (!empty($_FILES['verification_script']['name'])) {
                $verification_script = time() . $_FILES['verification_script']['name'];
                $config['upload_path'] = 'assets/product_verification_script/';
                $config['allowed_types'] = 'mp3';
                $config['file_name'] = $verification_script;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('verification_script')) {
                    $upload_error['verification_script_error'] = 'Please upload valid Verification Script';
                    $this->template->load('admin_header', 'admin/products/addProduct', $upload_error);
                    return FALSE;
                } else {
                    $data02 = $this->upload->data();
                    $verification_script_data = $data02['file_name'];
                }

            } else {
                $verification_script_data = '';
            }

            $rawPrice = $this->input->post('product_price');
            $productPrice = str_replace("$ ", "", $rawPrice);
            $productPrice = str_replace(",", "", $productPrice);

            $productTable = array(
                'product_id' => $this->input->post('product_id'),
                'plan_id' => $this->input->post('plan_id'),
                'product_name' => $this->input->post('product_name'),
                'product_price' => $productPrice,
                'product_coverage' => $this->input->post('coverage'),
                'product_pre_existing' => $this->input->post('allow_conditions'),
                'product_status' => $this->input->post('product_status'),
                'product_requires_appointment' => $this->input->post('appointment'),
                'product_average_savings' => $this->input->post('average_savings'),
                'product_network_size' => $this->input->post('network_size'),
                'product_benefits_type' => $this->input->post('benefits_type'),
                'product_type' => $this->input->post('product_type'),
                'product_requires_license' => $this->input->post('license'),
                'product_enrollment_billing_rule' => $this->input->post('enrollment_billing'),
                'product_next_billing_date_rule' => $this->input->post('next_billing_date_rule'),
                'product_billing_rule' => $this->input->post('billing_rule'),
                'product_next_billing_date_rule' => $this->input->post('next_billing_date_rule'),
                'product_activation_date_rule' => $this->input->post('activation_rule'),
                'product_image' => $product_image,
                'verification_script' => $verification_script_data,
                'product_vendor' => $this->input->post('vendor')
            );

            $productM = insert_update_data($ins = 1, $table_name = 'crm_products', $ins_data = $productTable);
            $product_id = $this->db->insert_id();

            $productStats = array('product_state' => $this->input->post('product_state'));
            foreach ($productStats['product_state'] as $state) {
                $productState = array('global_product_id' => $product_id, 'state' => $state);
                $productS = insert_update_data($ins = 1, $table_name = 'crm_product_state', $ins_data = $productState);
            }

            $age_restrictions = $this->input->post('age_restrictions');
            $age_restrictions = explode(';', $age_restrictions);
            $weight_restrictions = $this->input->post('weight_restrictions');
            $weight_restrictions = explode(';', $weight_restrictions);
            $height_restrictions = $this->input->post('height_restrictions');
            $height_restrictions = explode(';', $height_restrictions);

            $productAWH = array(
                'global_product_id' => $product_id,
                'max_age' => $age_restrictions[1],
                'min_age' => $age_restrictions[0],
                'max_weight' => $weight_restrictions[1],
                'min_weight' => $weight_restrictions[0],
                'max_height' => $height_restrictions[1],
                'min_height' => $height_restrictions[0],
            );

            $productRES = insert_update_data($ins = 1, $table_name = 'crm_product_age_weight_height', $ins_data = $productAWH);

            $enrollment_fee = $this->input->post('enrollment_fee');
            $enrollment_fee = explode(',', $enrollment_fee);
            foreach ($enrollment_fee as $fee) {
                $enrollmentFee = array('global_product_id' => $product_id, 'enrollment_fee' => $fee);
                $productE = insert_update_data($ins = 1, $table_name = 'crm_product_enrollment_fee', $ins_data = $enrollmentFee);
            }

            $license_type = $this->input->post('license_type');
            foreach ($license_type as $type) {
                $licenseType = array('global_product_id' => $product_id, 'license_type' => $type);
                $productLT = insert_update_data($ins = 1, $table_name = 'crm_product_license_type', $ins_data = $licenseType);
            }

            if ($productM && $productS && $productRES && $productE && $productLT) {
                foreach ($this->input->post('product_state') as $key => $state_list) {
                  $this->db->where('is_active','YES');
                  $this->db->where('state_code',$state_list);
                  if($key == '0'){
                    $this->db->or_where('script_status','all');
                  }
                  $qr = $this->db->get('crm_state_verification_script');
                  $data = $qr->result_array();
                  foreach ($data as $key => $row) {
                    $script_data01[] = $row;
                  }
                }
                $script_data['sdata'] = $script_data01;
                $script_data['popup'] = 'Yes';
                $script_data['last_product_id'] = $product_id;
                $this->session->set_flashdata('success',$script_data);
                redirect(base_url() . 'product/add_product?con='.$_REQUEST['con'].'&met='.$_REQUEST['met'].'&lead='.$_REQUEST['lead']);
            }
        }
        
        if ($this->session->userdata['user_info']['roll_id'] == 1) {
            $this->template->load('admin_header', 'admin/product/addProduct', $data);
        } elseif ($this->session->userdata['user_info']['roll_id'] == 2) {
            $this->template->load('agent_header', 'admin/product/addProduct', $data);
        }elseif ($this->session->userdata['user_info']['roll_id'] == 5) {
            $this->template->load('agency_header', 'admin/product/addProduct', $data);
        }
    }


}
