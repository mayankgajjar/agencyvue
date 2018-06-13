<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('product');
        $this->load->model('vendor');
        $this->load->model('product');
        $this->load->model('member');
        $this->load->model('common');
    }

    public function index() {
        $data['title'] = 'Product || Agent';
        $this->template->load('agent_header', 'agent/product/index', $data);
    }

    function productJson() {
        $agentId = $this->session->userdata('agent_primary')['broker_id'];
        $aColumns = array("global_product_id", "product_status", "product_id", "plan_id", "product_name", "product_coverage", "product_type", "total_states", "product_requires_license");
        /* Pagination */
        $sLimit = array();
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $sLimit = array("start" => $_GET['iDisplayLength'], "end" => $_GET['iDisplayStart']);
        }

        /* Search */
        $sWhere = " agent_id = {$agentId} ";
        $sColumns = array("product_status", "product_id", "plan_id", "product_name", "product_coverage", "product_type", "product_requires_license");
        if ($_GET['sSearch'] != "") {
            $sWhere .= " (";
            for ($i = 0; $i < count($sColumns); $i++) {
                $sWhere .= $sColumns[$i] . " LIKE '%" . $_GET['sSearch'] . "%' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ') ';
        }
        $sOrder = array();
        if ($_GET['iSortCol_0'] != "") {
            for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                    $sOrder = array("field" => $aColumns[intval($_GET['iSortCol_' . $i])], "order" => $_GET['sSortDir_' . $i]);
                }
            }
        } else {
            $sOrder = array("field" => $aColumns[3], "order" => 'DESC');
        }

        $rResult = $this->product->get_products($sLimit, $sWhere, $sOrder);
        $iTotal_f = count($rResult);
        $iTotal = $this->product->get_products_count($sWhere);
        $output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $iTotal_f,
            "iTotalDisplayRecords" => $iTotal,
            "aaData" => array()
        );
        if ($rResult) {
            foreach ($rResult as $aRow) {
                $row = array();
                for ($i = 0; $i < count($aColumns); $i++) {
                    if ($aColumns[$i] == 'global_product_id') {
                        $row[] = "<div class='checkbox checkbox-primary checkbox-single m-r-15'>
                        <input id='act_checkbox_" . $aRow['global_product_id'] . "' type='checkbox' value=" . urlencode(base64_encode($aRow["global_product_id"])) . " name='act_checkbox[]' class='ch_checkbox'>
                        <label for='act-checkbox'></label>
                    </div>";
                    } elseif ($aColumns[$i] == 'product_coverage') {
                        $row[] = str_replace('_', ' + ', $aRow[$aColumns[$i]]);
                    } elseif ($aColumns[$i] == 'product_type') {
                        $row[] = str_replace('_', ' ', $aRow[$aColumns[$i]]);
                    } elseif ($aColumns[$i] == 'product_status') {
                        if ($aRow[$aColumns[$i]] == "active") {
                            $row[] = '<span class="btn-success btn-xs">' . $aRow[$aColumns[$i]] . '</span>';
                        } else {
                            $row[] = '<span class="btn-danger btn-xs">' . $aRow[$aColumns[$i]] . '</span>';
                        }
                    } else {
                        $row[] = isset($aRow[$aColumns[$i]]) ? $aRow[$aColumns[$i]] : '';
                    }

                }
                $row[] .= '<span style="display:none;" class="btn btn-info btn-xs table-action-btn admin-action-icon-in-data-table copy_product" data-custom-value="' . urlencode(base64_encode($aRow["global_product_id"])) . '" ><i class="fa fa-copy" title="Copy Product"></i></span>'
                        . '<a class="btn btn-default btn-xs table-action-btn admin-action-icon-in-data-table" href="' . site_url('agent/products/addProduct/' . urlencode(base64_encode($aRow["global_product_id"]))) . '"><i class="fa fa-pencil" title="Edit Product"></i></a>'
                        . '<span style="display:none;" class="btn btn-warning btn-xs table-action-btn admin-action-icon-in-data-table product_archived" data-custom-value="' . urlencode(base64_encode($aRow["global_product_id"])) . '"><i class="fa fa-folder" title="Product Archive"></i></span>'
                        . '<span class="danger-alert btn btn-danger btn-xs table-action-btn product_del admin-action-icon-in-data-table remove-span" data-custom-value="' . urlencode(base64_encode($aRow["global_product_id"])) . '"><i class="glyphicon glyphicon-remove" title="Remove Product"></i></span>';
                $output['aaData'][] = $row;

            }

        }

        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));

    }

    public function edit_product($id = null) {
        // echo "here";
        // die;
        $data['title'] = "Edit Product";
        $this->load->model('common');
        $data['states'] = $this->common->get_all_state();
        $data['vendors'] = $this->common->get_all_vendors();
        $global_id = base64_decode(urldecode($id));
        $data['product_details'] = $this->product->product_details($global_id);
        $enrollment_data = $data['product_details']['enrollment_data'];
        foreach ($enrollment_data as $value) {
            $enro_arr[] = $value['enrollment_fee'];
        }
        $data['enroll_data'] = implode(",", $enro_arr);
        $license_data = $data['product_details']['license_data'];
        foreach ($license_data as $value) {
            $lic_arr[] = $value['license_type'];
        }
        $data['lic_data'] = $lic_arr;
        $state_data = $data['product_details']['state_data'];
        foreach ($state_data as $value) {
            $state_arr[] = $value['state'];
        }
        $data['state_dat'] = $state_arr;
        if ($this->input->post('save')) {
            if (!empty($_FILES['product_image']['name'])) {
                $product_image = time() . $_FILES['product_image']['name'];
                $config['upload_path'] = 'assets/crm_image/products/';
                $config['allowed_types'] = 'jpeg|jpg|png';
                $config['file_name'] = $product_image;
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('product_image')) {
                    $data['error'] = 'Please upload valid Image || jpeg|jpg|png';
                    $this->template->load('admin_header', 'admin/products/addProduct', $data);
                    return FALSE;
                } else {
                    if (isset($data['product_details']['product_data']['product_image'])) {
                        $img_path = $_SERVER['DOCUMENT_ROOT'] . '/crm/assets/crm_image/products/' . $data['product_details']['product_data']['product_image'];
                        unlink($img_path);
                    }
                    $data = $this->upload->data();
                    $product_image = $data['file_name'];
                }
            } else {
                $product_image = $data['product_details']['product_data']['product_image'];
            }
            unset($config);
            if (!empty($_FILES['verification_script']['name'])) {
                $verification_script = time() . $_FILES['verification_script']['name'];
                $config['upload_path'] = 'assets/product_verification_script/';
                $config['allowed_types'] = 'mp3';
                $config['file_name'] = $verification_script;
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('verification_script')) {
                    $upload_error['verification_script_error'] = 'Please upload valid Verification Script';
                    $this->template->load('admin_header', 'admin/products/addProduct', $upload_error);
                    return FALSE;
                } else {
                    if (isset($data['product_details']['product_data']['verification_script'])) {
                        $img_path = $_SERVER['DOCUMENT_ROOT'] . '/crm/assets/product_verification_script/' . $data['product_details']['product_data']['verification_script'];
                        unlink($img_path);
                    }
                    $data = $this->upload->data();
                    $verification_script_data = $data['file_name'];
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
                'product_type' => $this->input->post('product_type'),
                'product_category' => $this->input->post('catrgory'),
                'product_coverage' => $this->input->post('coverage'),
                'product_pre_existing' => $this->input->post('allow_conditions'),
                'product_status' => $this->input->post('product_status'),
                'product_requires_appointment' => $this->input->post('appointment'),
                'product_average_savings' => $this->input->post('average_savings'),
                'product_network_size' => $this->input->post('network_size'),
                'product_benefits_type' => $this->input->post('benefits_type'),
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
            $con = array('global_product_id' => $global_id);
            $productM = insert_update_data($ins = 0, $table_name = 'crm_products', $ins_data = $productTable, $where = $con);
            $productStats = $this->input->post('product_state');
            foreach ($productStats as $key => $value) {
                if (!in_array($value, $state_arr)) {
                    $productState = array('global_product_id' => $global_id, 'state' => $value);
                    $productS = insert_update_data($ins = 1, $table_name = 'crm_product_state', $ins_data = $productState);
                }
                $result = array_diff($state_arr, $productStats);

                if (!empty($result)) {
                    foreach ($result as $res) {
                        $del_con = array('state' => $res, 'global_product_id' => $global_id);
                        $productState = array('status' => 'inactive');
                        $productS = insert_update_data($ins = 0, $table_name = 'crm_product_state', $ins_data = $productState, $where = $del_con);
                    }
                }
            }
            $age_restrictions = $this->input->post('age_restrictions');
            $age_restrictions = explode(';', $age_restrictions);
            $weight_restrictions = $this->input->post('weight_restrictions');
            $weight_restrictions = explode(';', $weight_restrictions);
            $height_restrictions = $this->input->post('height_restrictions');
            $height_restrictions = explode(';', $height_restrictions);
            $productAWH = array(
                'global_product_id' => $global_id,
                'max_age' => $age_restrictions[1],
                'min_age' => $age_restrictions[0],
                'max_weight' => $weight_restrictions[1],
                'min_weight' => $weight_restrictions[0],
                'max_height' => $height_restrictions[1],
                'min_height' => $height_restrictions[0],
            );
            $productRES = insert_update_data($ins = 0, $table_name = 'crm_product_age_weight_height', $ins_data = $productAWH, $where = $con);
            $e_fee_data = $this->input->post('enrollment_fee');
            $enrollment_fee_data = (explode(",", $e_fee_data));
            foreach ($enrollment_fee_data as $key => $value) {
                if (!in_array($value, $enro_arr)) {
                    $enrollmentStatus = array('global_product_id' => $global_id, 'enrollment_fee' => $value);
                    $enrollment_fee_status = insert_update_data($ins = 1, $table_name = 'crm_product_enrollment_fee', $ins_data = $enrollmentStatus);
                }
                $result01 = array_diff($enro_arr, $enrollment_fee_data);
                if (!empty($result01)) {
                    foreach ($result01 as $res) {
                        $del_con = array('enrollment_fee' => $res, 'global_product_id' => $global_id);
                        $State = array('status' => 'inactive');
                        $enrollment_fee_status = insert_update_data($ins = 0, $table_name = 'crm_product_enrollment_fee', $ins_data = $State, $where = $del_con);
                    }
                }
            }
            $license_type = $this->input->post('license_type');
            foreach ($license_type as $key => $value) {
                if (!in_array($value, $lic_arr)) {
                    $licenseStatus = array('global_product_id' => $global_id, 'license_type' => $value);
                    $enrollment_fee_status = insert_update_data($ins = 1, $table_name = 'crm_product_license_type', $ins_data = $licenseStatus);
                }
                $result02 = array_diff($lic_arr, $license_type);
                if (!empty($result02)) {
                    foreach ($result02 as $res) {
                        $del_con = array('license_type' => $res, 'global_product_id' => $global_id);
                        $State = array('status' => 'inactive');
                        $license_type_status = insert_update_data($ins = 0, $table_name = 'crm_product_license_type', $ins_data = $State, $where = $del_con);
                    }
                }
            }
            $this->session->set_flashdata('success', 'Product is successfully Updated!');
            redirect(base_url() . 'agent/products');
        }
        $this->template->load('agent_header', 'agent/product/edit_product', $data);
    }

    function reArrayFiles(&$file_post) 
    {
        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);

        for ($i=0; $i<$file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }
        return $file_ary;
    }

    public function get_product_type()
    {
        $category_id = $this->input->post('category_id');   
        $sql = "SELECT * FROM crm_product_type WHERE product_category_id = ". $category_id;
        $product_types = $this->db->query($sql)->result_array();
        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($product_types));
    }

    public function addProduct($id = NULL) 
    {
        if($id){
            $data['title'] = 'Update Product  || Agent';
            $global_id = base64_decode(urldecode($id));
            $data['product_details'] = $this->product->product_details($global_id);
            $enrollment_data = $data['product_details']['enrollment_data'];
            $enro_arr = array();
            foreach ($enrollment_data as $value) {
                $enro_arr[] = $value['enrollment_fee'];
            }
            $data['enroll_data'] = implode(",", $enro_arr);
            $license_data = $data['product_details']['license_data'];
            $lic_arr = array();
            foreach ($license_data as $value) {
                $lic_arr[] = $value['license_type'];
            }
            $data['lic_data'] = $lic_arr;
            $state_data = $data['product_details']['state_data'];
            foreach ($state_data as $value) {
                $state_arr[] = $value['state'];
            }
            $data['state_dat'] = $state_arr;
            $sql = "SELECT * FROM crm_product_commission WHERE product_id = $global_id";
            $query = $this->db->query($sql);
            $data['product_details']['commission'] = $query->row_array();
            $sql = "SELECT * FROM crm_product_alternate_verification_script WHERE product_id = $global_id";
            $query = $this->db->query($sql);
            $data['product_details']['alternate_script'] = $query->result_array();
           // pr_exit($data['product_details']);
            $sql = "SELECT product_category_id FROM crm_product_category WHERE product_category_name LIKE '%".$data['product_details']['product_data']['product_category']. "%'";
            $category_id = $this->db->query($sql)->row()->product_category_id;
            $sql = "SELECT * FROM crm_product_type WHERE product_category_id =".$category_id;
            $data['product_details']['product_types'] = $this->db->query($sql)->result_array();

        }else{
            $data['title'] = 'Add New Product  || Agent';
        }
        if (isset($global_id) && $global_id != null)
        {
            $ins = '';
        }
        else
        {
            $ins = 1;
        }
        $this->load->model('common');
        $data['states'] = $this->common->get_all_state();
        $data['vendors'] = $this->common->get_all_vendors();
        $data['product_categoies'] = get_data('crm_product_category', 0, '');
  //      pr_exit($data['product_categoies']);
        //$data['script'] = get_data($tbl_name = 'crm_state_verification_script', $single = 0, $where = array('is_active' => 'YES'));
        $this->form_validation->set_rules('vendor', 'Vendor', 'trim|required');
        $this->form_validation->set_rules('catrgory', 'Category', 'trim|required');
        $this->form_validation->set_rules('product_type', 'Product Type', 'trim|required');
        $this->form_validation->set_rules('product_name', 'Product Name', 'trim|required');
        $this->form_validation->set_rules('coverage', 'Coverage', 'trim|required');
        $this->form_validation->set_rules('product_price', 'Product Price', 'trim|required');
        if (isset($_FILES['product_image']['name']) && $_FILES['product_image']['name'] != '') {
            $this->form_validation->set_rules('product_image', 'Product Price', 'callback_image_upload');
        }
        if (isset($_FILES['verification_script']['name']) && $_FILES['verification_script']['name'] != '') {
            $this->form_validation->set_rules('verification_script', 'Verification Script', 'callback_verfication_script');
        }
        if ($this->form_validation->run() == TRUE) {
            $post = $this->input->post();
            if (!empty($_FILES['product_image']['name'])) {
                $product_image = time() . $_FILES['product_image']['name'];
                $config['upload_path'] = 'assets/crm_image/products/';
                $config['allowed_types'] = 'jpeg|jpg|png';
                $config['file_name'] = $product_image;
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('product_image')) {
                    $upload_error['error'] = 'Please upload valid Product Image';
                    $this->template->load('agent_header', 'agent/products/addProduct', $upload_error);
                    return FALSE;
                } else {
                    $data = $this->upload->data();
                    $product_image = $data['file_name'];
                }
            } else {
                $product_image = '';
            }
            unset($config);
           // print_r($_FILES);
            if (!empty($_FILES['verification_script']['name'])) {
                $verification_script = time() . $_FILES['verification_script']['name'];
                $config['upload_path'] = 'assets/product_verification_script/';
                $config['allowed_types'] = 'mp3';
                $config['file_name'] = $verification_script;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('verification_script')) {
                    $upload_error['verification_script_error'] = 'Please upload valid Verification Script';
                    //$this->template->load('agent_header', 'agent/products/addProduct', $upload_error);
                    //return FALSE;
                } else {
                    $data02 = $this->upload->data();
                    $verification_script_data = $data02['file_name'];
                }
            } else {
                $verification_script_data = '';
            }
            if (isset($post['product_id']) && $post['product_id'] == '') {
                $post['product_id'] = $this->_generate();
            }
            $rawPrice = $this->input->post('product_price');
            $productPrice = str_replace("$ ", "", $rawPrice);
            $productPrice = str_replace(",", "", $productPrice);
            $productTable = array(
                'product_id' => $post['product_id'],
                'plan_id' => $this->_generate(),
                'product_name' => isset($post['product_name']) ? $post['product_name'] : '',
                'product_price' => $productPrice,
                'product_coverage' =>isset($post['coverage']) ? $post['coverage'] : '',
                'product_pre_existing' => isset($post['allow_conditions']) ? $post['allow_conditions'] : '',
                'product_status' => isset($post['product_status']) ? $post['product_status'] : '',
                'product_requires_appointment' => isset($post['appointment']) ? $post['appointment'] : '',
                'product_average_savings' => isset($post['average_savings']) ? $post['average_savings'] : '',
                'product_network_size' => isset($post['network_size']) ? $post['network_size'] : '',
                'product_benefits_type' => isset($post['benefits_type']) ? $post['benefits_type'] : '',
                'product_type' => isset($post['product_type']) ? $post['product_type'] : '' ,
                'product_category'=>isset($post['catrgory']) ? $post['catrgory'] : '' ,
                'product_requires_license' => isset($post['license']) ? $post['license'] : '',
                'product_enrollment_billing_rule' => isset($post['enrollment_billing']) ? $post['enrollment_billing'] : '',
                'product_next_billing_date_rule' => isset($post['next_billing_date_rule']) ? $post['next_billing_date_rule'] : '',
                'product_billing_rule' => isset($post['billing_rule']) ? $post['billing_rule'] : '',
                'product_next_billing_date_rule' => isset($post['next_billing_date_rule']) ? $post['next_billing_date_rule']  : '',
                'product_activation_date_rule' => isset($post['activation_rule']) ? $post['activation_rule'] : '',
                'product_image' => $product_image,
                'verification_script' => $verification_script_data,
                'product_vendor' => isset($post['vendor']) ? $post['vendor'] : '',
                'agent_id' => $this->session->userdata('agent_primary')['broker_id']
            );
            if (isset($global_id) && $global_id != null)
            {
                $ins = '';
                $where = "global_product_id = ". $global_id;
                $productM = insert_update_data($ins, $table_name = 'crm_products', $ins_data = $productTable, $where);
                $product_id = $global_id;
            }
            else
            {
                $ins = 1;
                $where = '';
                $productM = insert_update_data($ins, $table_name = 'crm_products', $ins_data = $productTable, $where);
                $product_id = $this->db->insert_id();
            }
            $productStats = array('product_state' => $this->input->post('product_state'));
          
            if (isset($productStats['product_state']))
            {
                foreach ($productStats['product_state'] as $state) 
                {
                    $productState = array('global_product_id' => $product_id, 'state' => $state);
                    $productS = insert_update_data($ins, $table_name = 'crm_product_state', $ins_data = $productState, $where);
                } 
            }
            else
            {
                $productS = '';
            }
          
            if (isset($_POST['script_state_rule']))
            {
                $script_state_rule = $this->input->post('script_state_rule');
            }

            if (!empty($_FILES['alternate_script']) && isset($global_id) && $global_id != null ) {

                if (isset($_FILES['alternate_script']))
                {
                    $sql = "SELECT * FROM crm_product_alternate_verification_script WHERE product_id = ".$global_id;
                    $query = $this->db->query($sql)->result_array();
                    foreach ($query as $key => $value) {
                        $img_path =  $_SERVER['DOCUMENT_ROOT'] . '/assets/alternate_product_verification_script/' . $value['script_name'];
                        unlink($img_path);
                    }
                    $sql = "DELETE FROM crm_product_alternate_verification_script WHERE product_id =".$global_id;
                    $this->db->query($sql);
                    //update the details
                    $files = $_FILES['alternate_script'];
                    $this->mp3_upload($files);
                }
            }
            else
            {
                if (isset($_FILES['alternate_script']))
                {
                    $files = $_FILES['alternate_script'];
                    $this->mp3_upload($files);
                }
            }
            $productAWH = array(
                'global_product_id' => $product_id,
                'max_age' => isset($post['max_age']) ? $post['max_age'] : 0,
                'min_age' => isset($post['min_age']) ? $post['min_age'] : 0,
                'max_weight' => isset($post['male_max_weight']) ? $post['male_max_weight'] : 0,
                'min_weight' => isset($post['male_min_weight']) ? $post['male_min_weight'] : 0,
                'female_min_weight' => isset($post['female_min_weight']) ? $post['female_min_weight'] : 0,
                'female_max_weight' => isset($post['female_max_weight']) ? $post['female_max_weight'] : 0,
                'max_height' => isset($post['max_height']) ? $post['max_height'] : 0,
                'min_height' => isset($post['min_height']) ? $post['min_height'] : 0,
            );
            $productRES = insert_update_data($ins, $table_name = 'crm_product_age_weight_height', $ins_data = $productAWH, $where);
            $enrollment_fee = $this->input->post('enrollment_fee');
            $enrollment_fee = explode(',', $enrollment_fee);
            foreach ($enrollment_fee as $fee) {
                $enrollmentFee = array('global_product_id' => $product_id, 'enrollment_fee' => $fee);
                $productE = insert_update_data($ins, $table_name = 'crm_product_enrollment_fee', $ins_data = $enrollmentFee, $where);
            }
            $license_type = $this->input->post('license_type');
            if (isset($license_type) && $license_type != null)
            {
                foreach ($license_type as $type) 
                {
                    $licenseType = array('global_product_id' => $product_id, 'license_type' => $type);
                    $productLT = insert_update_data($ins , $table_name = 'crm_product_license_type', $ins_data = $licenseType, $where);
                }
            }
            else
            {
                $productLT = '';
            }
            if (isset($post['commission_structure']))
            {
                if ($this->input->post('commission_structure') == 'flatfee')
                {
                    $commission_structure = "flatfee";
                    $commission_array = array(
                        "flat_commission"=>$this->input->post("flat_commission"),
                        "flat_renewal"=>$this->input->post("flat_renewal")
                        );
                }
                else if ($this->input->post('commission_structure') == 'percentpremium')
                {
                    $commission_structure = "percentpremium";
                    $commission_array = array(
                        "percent_premium_commsion"=>$this->input->post("percent_premium_commsion"),
                        "percent_premium_duration"=>$this->input->post("percent_premium_duration"),
                        "percent_premium_renewal"=>$this->input->post("percent_premium_renewal"),
                        "percent_noncommissionable_premium"=>$this->input->post("percent_noncommissionable_premium"),
                        "default_percent_premium"=>$this->input->post("default_percent_premium"),
                        );
                }
                else if ($this->input->post('commission_structure') == 'tieryears')
                {
                    $commission_structure = "tieryears";
                    $commission_array = array(
                        "tieryears_premium"=>$this->input->post("tieryears_premium"),
                        "tieryears_premium_duration"=>$this->input->post("tieryears_premium_duration"),
                        "tier1_number_years"=> $this->input->post("tier1_number_years"),
                        "tier1_percent_premium"=> $this->input->post("tier1_percent_premium"),
                        "tier2_number_years"=> $this->input->post("tier2_number_years"),
                        "tier2_percent_premium"=> $this->input->post("tier2_percent_premium"),
                        "tier3_number_years"=> $this->input->post("tier3_number_years"),
                        "tier3_percent_premium"=> $this->input->post("tier3_percent_premium"),
                        );
                }
                else if ($this->input->post('commission_structure') == 'commissionablepremium')
                {
                    $commission_structure = "commissionablepremium";
                    $commission_array = array(
                        "premium"=>$this->input->post("premium"),
                        "premium_duration"=>$this->input->post("premium_duration"),
                        "commissionable_premium"=>$this->input->post("commissionable_premium"),
                        "percent_premium"=>$this->input->post("percent_premium"),
                        );
                }
                else
                {
                    $commission_structure = "calendarpremium";
                    $commission_array = array(
                        "calendarpremium_commission"=>$this->input->post("calendarpremium_commission"),
                        "calendarpremium_renewal"=>$this->input->post("calendarpremium_renewal")
                        );
                }
                $commission_value = serialize($commission_array);
            }
            else
            {
                $commission_structure = '';
                $commission_value = '';
            }
            $productCommssion = array(
                'product_id' => $product_id,
                'commission_paid' => isset($post['commission_paid']) ? $post['commission_paid'] : '',
                'renewals_paid' => isset($post['renewals_paid']) ? $post['renewals_paid'] : '',
                'commission_structure' => $commission_structure,
                'commission_value' => $commission_value,
            );
            if (isset($global_id) && $global_id != null)
            {
                $ins = '';
                $where = "product_id = ".$global_id;
            }
            else
            {
                $ins = 1;
                $where = '';
            }
            $productCOM = insert_update_data($ins, $table_name = 'crm_product_commission', $ins_data = $productCommssion, $where);
            if ($productM && $productS && $productRES && $productE && $productLT) {
                foreach ($this->input->post('product_state') as $key => $state_list) {
                    $this->db->where('is_active', 'YES');
                    $this->db->where('state_code', $state_list);
                    if ($key == '0') {
                        $this->db->or_where('script_status', 'all');
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
                $adminProductFeed = array(
                    'feed_type' => 'feed',
                    'feed_icon' => 'glyphicon glyphicon-ok-circle',
                    'feed_title' => 'New Product Added In System || ' . $this->input->post('product_name'),
                    'is_admin' => 'N'
                );
                insert_update_data(1, 'crm_feeds', $adminProductFeed);
            }
            /* print_r($adminProductFeed);
            die; */
            if ( isset($global_id) && $global_id != '')
            {
                $this->session->set_flashdata("success", "Product Updated Successfully.");
            }
            else
            {
                $this->session->set_flashdata("success", "Product Added Successfully.");
            }
            redirect('agent/products/index');
        }
        $this->template->load('agent_header', 'agent/product/addProduct', $data);
    }

    function mp3_upload($files)
    {
        $ascript = $files;
        $config['upload_path'] = 'assets/alternate_product_verification_script/';
        $config['allowed_types'] = 'mp3';
        foreach ($ascript['name'] as $key => $image) {
            $_FILES['images[]']['name']= $ascript['name'][$key];
            $_FILES['images[]']['type']= $ascript['type'][$key];
            $_FILES['images[]']['tmp_name']= $ascript['tmp_name'][$key];
            $_FILES['images[]']['error']= $ascript['error'][$key];
            $_FILES['images[]']['size']= $ascript['size'][$key];
            //$verification_script = time() . $ascript['name'][$key];
            $images[] = time() . $ascript['name'][$key];
            $config['file_name'] = time() . $ascript['name'][$key];
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('images[]')) {
                $this->upload->data();
            } else {
                return false;
            }
            foreach ($script_state_rule as $key => $value) {
                $alternateData = array(
                'product_id' => $product_id,
                'script_name' => time() . $ascript['name'][$key],
                'states' => $value
                );
                insert_update_data($ins = 1, $table_name = 'crm_product_alternate_verification_script', $ins_data = $alternateData);
            }
        }
    }

    function image_upload() {
        if ($_FILES['product_image']['size'] != 0) {
            $config['allowed_types'] = 'jpeg|jpg|png';
            $extension = explode('.', $_FILES['product_image']['name']);
            if (strtolower($extension[count($extension) - 1]) != 'jpeg' && strtolower($extension[count($extension) - 1]) != 'jpg' && strtolower($extension[count($extension) - 1]) != 'png') {
                $this->form_validation->set_message('image_upload', 'Please upload image file only.');
                return false;
            } else {
                return true;
            }
        } else {
            $this->form_validation->set_message('image_upload', "No file selected");
            return false;
        }
    }
    function verfication_script() {
        if ($_FILES['verification_script']['size'] != 0) {
            $config['allowed_types'] = 'mp3';
            $extension = explode('.', $_FILES['verification_script']['name']);
            if (strtolower($extension[count($extension) - 1]) != 'mp3') {
                $this->form_validation->set_message('verfication_script', 'Please upload mp3 file only.');
                return false;
            } else {
                return true;
            }
        } else {
            $this->form_validation->set_message('verfication_script', "No file selected");
            return false;
        }
    }
    public function copyProduct($global_id = null) 
    {
        $global_id = $_REQUEST['global_id'];
        if ($global_id != "") {
            $global_id = base64_decode(urldecode($global_id));
            $product_details = $this->product->product_details($global_id);
            $lastID = $this->db->query("SELECT global_product_id FROM crm_products ORDER BY global_product_id DESC LIMIT 1")->row_array();
            $global_id_copy = $lastID['global_product_id'] + 1;
            $this->db->query("CREATE TEMPORARY TABLE temp_tbl SELECT * FROM crm_products WHERE global_product_id  = '$global_id'");
            $this->db->query("UPDATE temp_tbl SET global_product_id  = '$global_id_copy'");
            $this->db->query("INSERT INTO crm_products SELECT * FROM temp_tbl");
            $this->db->query("DROP TABLE temp_tbl");
            $state_count = sizeof($product_details['state_data']);
            for ($i = 0; $i < $state_count; $i++) {
                $productState = array('global_product_id' => $global_id_copy, 'state' => $product_details['state_data'][$i]['state']);
                insert_update_data($ins = 1, $table_name = 'crm_product_state', $ins_data = $productState);
            }
            $license_count = sizeof($product_details['license_data']);
            for ($i = 0; $i < $license_count; $i++) {
                $licenseType = array('global_product_id' => $global_id_copy,
                    'license_type' => $product_details['license_data'][$i]['license_type']);
                insert_update_data($ins = 1, $table_name = 'crm_product_license_type', $ins_data = $licenseType);
            }
            $enrollment_count = sizeof($product_details['enrollment_data']);
            for ($i = 0; $i < $enrollment_count; $i++) {
                $enrollmentFee = array('global_product_id' => $global_id_copy,
                    'enrollment_fee' => $product_details['enrollment_data'][$i]['enrollment_fee']);
                insert_update_data($ins = 1, $table_name = 'crm_product_enrollment_fee', $ins_data = $enrollmentFee);
            }
            $productAWH = array(
                'global_product_id' => $global_id_copy,
                'max_age' => $product_details['age_weight_height_data']['max_age'],
                'min_age' => $product_details['age_weight_height_data']['min_age'],
                'max_weight' => $product_details['age_weight_height_data']['max_weight'],
                'min_weight' => $product_details['age_weight_height_data']['min_weight'],
                'max_height' => $product_details['age_weight_height_data']['max_height'],
                'min_height' => $product_details['age_weight_height_data']['min_height'],
            );
            insert_update_data($ins = 1, $table_name = 'crm_product_age_weight_height', $ins_data = $productAWH);
            $adminProductFeed = array(
                'feed_type' => 'feed',
                'feed_icon' => 'fa fa-copy',
                'feed_title' => 'New Product Coppied Into System || ' . get_product_global_id($global_id_copy),
                'is_admin' => 'Y'
            );
            insert_update_data(1, 'crm_feeds', $adminProductFeed);
            echo "Copy DONE !";
        } elseif ($global_id == "" || $global_id == NULL) {
            echo 'Global_id Error || Blank or NULL';
            die();
        } else {
            exit('Error');
        }
        die();
    }

    public function removeProduct() {
        $global_id = $_REQUEST['global_id'];
        $global_id = base64_decode(urldecode($global_id));
        $con = array('global_product_id' => $global_id);
        $data = array('is_deleted' => 'Y');
        $done = insert_update_data($ins = 0, $tbl_name = 'crm_products', $data = $data, $where = $con);
        if ($done) {
            $adminProductFeed = array(
                'feed_type' => 'feed',
                'feed_icon' => 'glyphicon-ban-circle',
                'feed_title' => 'Product Removed From The System || ' . get_product_global_id($global_id),
                'is_admin' => 'Y'
            );
            insert_update_data(1, 'crm_feeds', $adminProductFeed);
            echo "Product Successfully Delete";
        }
        die();
    }

    public function archivedProduct() {
        $global_id = $_REQUEST['global_id'];
        $global_id = base64_decode(urldecode($global_id));
        $con = array('global_product_id' => $global_id);
        $data = array('is_deleted' => 'archived');
        $done = insert_update_data($ins = 0, $tbl_name = 'crm_products', $data = $data, $where = $con);
        if ($done) {
            $adminProductFeed = array(
                'feed_type' => 'feed',
                'feed_icon' => 'fa fa-archive',
                'feed_title' => 'Product Archived || ' . get_product_global_id($global_id),
                'is_admin' => 'Y'
            );
            insert_update_data(1, 'crm_feeds', $adminProductFeed);
            echo "Product Successfully Archived";
        }
        die();
    }



    public function copyProductP($global_id = null) {
        $global_id = $_REQUEST['global_id'];
        if ($global_id != "") {
            $global_id = base64_decode(urldecode($global_id));
            $product_details = $this->product->product_details($global_id);
            //pr_exit($product_details['product_data']);
            $productTable = array(
                'product_id' => $product_details['product_data']['product_id'],
                'plan_id' => $product_details['product_data']['plan_id'],
                'product_name' => $product_details['product_data']['product_name'],
                'product_price' => $product_details['product_data']['product_price'],
                'product_coverage' => $product_details['product_data']['product_coverage'],
                'product_pre_existing' => $product_details['product_data']['product_pre_existing'],
                'product_status' => $product_details['product_data']['product_status'],
                'product_requires_appointment' => $product_details['product_data']['product_requires_appointment'],
                'product_type' => $product_details['product_data']['product_type'],
                'product_requires_license' => $product_details['product_data']['product_requires_license'],
                'product_enrollment_billing_rule' => $product_details['product_data']['product_enrollment_billing_rule'],
                'product_billing_rule' => $product_details['product_data']['product_billing_rule'],
                'product_next_billing_date_rule' => $product_details['product_data']['product_next_billing_date_rule'],
                'product_activation_date_rule' => $product_details['product_data']['product_activation_date_rule'],
                'product_image' => $product_details['product_data']['product_image'],
                'product_vendor' => $product_details['product_data']['product_vendor']
            );
            //  pr_exit($productTable);
            //  $productM = insert_update_data($ins = 1, $table_name = 'crm_products', $ins_data = $productTable);
            //  $product_id = $this->db->insert_id();
            pr_arr($product_details['state_data']);
            $state_count = sizeof($product_details['state_data']);
            for ($i = 0; $i < $state_count; $i++) {
                echo $product_details['state_data'][$i]['state'] . "<br>";
            }
        } elseif ($global_id == "" || $global_id == NULL) {
            echo 'Global_id Error || Blank or NULL';
            die();
        } else {
            exit('Error');
        }
        die();
    }

    public function filters() {
        $data['product_array'] = $this->product->filter_data();
        echo $this->load->view('agent/product/filter_product.php', $data, true);
    }

    private function _generate() {
        for ($i = 1; $i < 10; $i++) {
            $key = strtoupper(substr(sha1(microtime() . $i), rand(0, 5), 25));
            $serial = implode("-", str_split($key, 5));
        }
        return $serial;
    }

    public function add_quick_product()
    {
        $data['vendor_id'] = $this->input->post('vendor_id');
        $data['product_name'] = $this->input->post('product_name'); 
        $data['product_type'] = $this->input->post('product_type');
        $data['product_category'] = $this->input->post('product_category');
        $data['coverage_type'] = $this->input->post('coverage_type'); 
        $data['product_price'] = $this->input->post('product_price'); 
        $data['enrollment_fee'] = $this->input->post('enrollment_fee'); 
        $member_id = base64_decode(urldecode($this->input->post('lead_id')));
        $uid = base64_decode(urldecode($member_id));
        $lead_info = $this->member->get_infos($uid, 'crm_lead_member_primary', 'customer_id');
        $data['state'] = $lead_info[0]['customer_state'];
        $data['agent_id'] = $this->session->userdata('agent_primary')['broker_id'];
        $data['product_id'] = $this->common->generateRandomString(5);
        $jsonArray['global_product_id'] = $this->product->save_quick_product($data);
        $jsonArray['added_by'] = $this->session->userdata('agent_primary')['user_id'];
        $jsonArray['member_id'] = $uid;
        if ($jsonArray['global_product_id'] != '')
        {
            $result = $this->product->save_quick_product_enroll_fee($data['enrollment_fee'],  $jsonArray['global_product_id']);
            if ($result != '')
            {
                $jsonArray['response'] = "Product Added Successfully";
            }
            else
            {
                $jsonArray['response'] = "Something Happens Wrong";
            }
        }
        else
        {
            $jsonArray['response'] = 'Something Happens Wrong';
        }
        return $this->output
                     ->set_content_type('application/json')
                     ->set_output(json_encode($jsonArray));
    }

    public function move_member_product()
    {
        $data['member_id'] = $this->input->post('member_id');
        $data['product_id'] = $this->input->post('product_id');
        $data['added_by'] = $this->input->post('added_by');
        $result = $this->product->save_member_prodduct($data);
        if ($result != '')
        {
            $response = "Product Added into Membor Product Successfully";
        }
        else
        {
            $response = 'Something Happens Wrong';
        }
        return $this->output
                     ->set_content_type('application/json')
                     ->set_output(json_encode($response));

    }


}

