<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('vendor');
        $this->load->model('product');
        $this->load->model('member');
        $this->load->model('common');
    }

    public function index() {
        $data['title'] = "Products || AgencyVue";
        $this->template->load('agency_header', 'agency/products/index', $data);
    }

    public function productJson() {
        $agentId = $this->session->userdata('user_info')['user_id'];
        $aColumns = array("global_product_id", "product_status", "product_id", "plan_id", "product_name", "product_coverage", "product_type", "total_states", "product_requires_license");
        /* Pagination */
        $sLimit = array();
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $sLimit = array("start" => $_GET['iDisplayLength'], "end" => $_GET['iDisplayStart']);
        }

        /* Search */
        $sWhere = " agent_id = {$agentId}";
        $sColumns = array("plan_id", "product_name", "product_type");
        if ($_GET['sSearch'] != "") {
            $sWhere .= " AND ( ";
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
                        . '<a class="btn btn-default btn-xs table-action-btn admin-action-icon-in-data-table" href="' . site_url('agency/products/add/' . urlencode(base64_encode($aRow["global_product_id"]))) . '"><i class="fa fa-pencil" title="Edit Product"></i></a>'
                        . '<span style="display:none;" class="btn btn-warning btn-xs table-action-btn admin-action-icon-in-data-table product_archived" data-custom-value="' . urlencode(base64_encode($aRow["global_product_id"])) . '"><i class="fa fa-folder" title="Product Archive"></i></span>'
                        . '<span class="danger-alert btn btn-danger btn-xs table-action-btn product_del admin-action-icon-in-data-table remove-span" data-custom-value="' . urlencode(base64_encode($aRow["global_product_id"])) . '"><i class="glyphicon glyphicon-remove" title="Remove Product"></i></span>';
                $output['aaData'][] = $row;
            }
        }

        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    private function _generate() {
        for ($i = 1; $i < 10; $i++) {
            $key = strtoupper(substr(sha1(microtime() . $i), rand(0, 5), 25));
            $serial = implode("-", str_split($key, 5));
        }
        return $serial;
    }

    function mp3_upload($files) {
        $ascript = $files;
        $config['upload_path'] = 'assets/alternate_product_verification_script/';
        $config['allowed_types'] = 'mp3';
        foreach ($ascript['name'] as $key => $image) {
            $_FILES['images[]']['name'] = $ascript['name'][$key];
            $_FILES['images[]']['type'] = $ascript['type'][$key];
            $_FILES['images[]']['tmp_name'] = $ascript['tmp_name'][$key];
            $_FILES['images[]']['error'] = $ascript['error'][$key];
            $_FILES['images[]']['size'] = $ascript['size'][$key];
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

    public function get_product_type()
    {
        $category_id = $this->input->post('category_id');   
        $sql = "SELECT * FROM crm_product_type WHERE product_category_id = ". $category_id;
        $product_types = $this->db->query($sql)->result_array();
        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($product_types));
    }

    public function add($id = NULL) {
        if ($id) {
            $data['title'] = 'Update Product  || Agency';
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
            $sql = "SELECT * FROM crm_product_commission WHERE product_id = {$global_id}";
            $query = $this->db->query($sql);
            $data['product_details']['commission'] = $query->row_array();
            $sql = "SELECT * FROM crm_product_alternate_verification_script WHERE product_id = {$global_id}";
            $query = $this->db->query($sql);
            $data['product_details']['alternate_script'] = $query->result_array();
            $sql = "SELECT product_category_id FROM crm_product_category WHERE product_category_name LIKE '%".$data['product_details']['product_data']['product_category']. "%'";
            $category_id = $this->db->query($sql)->row()->product_category_id;
            $sql = "SELECT * FROM crm_product_type WHERE product_category_id =".$category_id;
            $data['product_details']['product_types'] = $this->db->query($sql)->result_array();
        } else {
            $data['title'] = 'Add New Product  || Agency';
        }
        if (isset($global_id) && $global_id != null) {
            $ins = '';
        } else {
            $ins = 1;
        }
        $this->load->model('common');
        $data['states'] = $this->common->get_all_state();
        $data['vendors'] = $this->common->get_all_vendors();
        $data['product_categoies'] = get_data('crm_product_category', 0, array('created_by' => $this->session->userdata('user_info')['user_id']));
        $this->form_validation->set_rules('vendor', 'Vendor', 'trim|required');
        $this->form_validation->set_rules('catrgory', 'Category', 'trim|required');
        $this->form_validation->set_rules('product_type', 'Product Type', 'trim|required');
        $this->form_validation->set_rules('product_name', 'Product Name', 'trim|required');
        $this->form_validation->set_rules('coverage', 'Coverage', 'trim|required');
        $this->form_validation->set_rules('product_price', 'Product Price', 'trim|required');
        if (isset($_FILES['product_image']['name']) && $_FILES['product_image']['name'] != '') {
            $this->form_validation->set_rules('product_image', 'Product Price', 'callback_image_upload');
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
                    $this->template->load('agency_header', 'agency/products/add', $upload_error);
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
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('verification_script')) {
                    $upload_error['verification_script_error'] = 'Please upload valid Verification Script';
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
                'product_coverage' => isset($post['coverage']) ? $post['coverage'] : '',
                'product_pre_existing' => isset($post['allow_conditions']) ? $post['allow_conditions'] : '',
                'product_status' => isset($post['product_status']) ? $post['product_status'] : '',
                'product_requires_appointment' => isset($post['appointment']) ? $post['appointment'] : '',
                'product_average_savings' => isset($post['average_savings']) ? $post['average_savings'] : '',
                'product_network_size' => isset($post['network_size']) ? $post['network_size'] : '',
                'product_benefits_type' => isset($post['benefits_type']) ? $post['benefits_type'] : '',
                'product_type' => isset($post['product_type']) ? $post['product_type'] : '',
                'product_category' => isset($post['catrgory']) ? $post['catrgory'] : '',
                'product_requires_license' => isset($post['license']) ? $post['license'] : '',
                'product_enrollment_billing_rule' => isset($post['enrollment_billing']) ? $post['enrollment_billing'] : '',
                'product_next_billing_date_rule' => isset($post['next_billing_date_rule']) ? $post['next_billing_date_rule'] : '',
                'product_billing_rule' => isset($post['billing_rule']) ? $post['billing_rule'] : '',
                'product_next_billing_date_rule' => isset($post['next_billing_date_rule']) ? $post['next_billing_date_rule'] : '',
                'product_activation_date_rule' => isset($post['activation_rule']) ? $post['activation_rule'] : '',
                'product_image' => $product_image,
                'verification_script' => $verification_script_data,
                'product_vendor' => isset($post['vendor']) ? $post['vendor'] : '',
                'agent_id' => $this->session->userdata('user_info')['user_id']
            );
            if (isset($global_id) && $global_id != null) {
                $ins = '';
                $where = "global_product_id = " . $global_id;
                $productM = insert_update_data($ins, $table_name = 'crm_products', $ins_data = $productTable, $where);
                $product_id = $global_id;
            } else {
                $ins = 1;
                $where = '';
                $productM = insert_update_data($ins, $table_name = 'crm_products', $ins_data = $productTable, $where);
                $product_id = $this->db->insert_id();
            }
            $productStats = array('product_state' => $this->input->post('product_state'));

            if (isset($productStats['product_state'])) {
                foreach ($productStats['product_state'] as $state) {

                    $productState = array('global_product_id' => $product_id, 'state' => $state);
                    $productS = insert_update_data($ins, $table_name = 'crm_product_state', $ins_data = $productState, $where);
                }
            } else {
                $productS = '';
            }

            if (isset($_POST['script_state_rule'])) {
                $script_state_rule = $this->input->post('script_state_rule');
            }

            if (!empty($_FILES['alternate_script']) && isset($global_id) && $global_id != null) {

                if (isset($_FILES['alternate_script'])) {
                    $sql = "SELECT * FROM crm_product_alternate_verification_script WHERE product_id = " . $global_id;
                    $query = $this->db->query($sql)->result_array();
                    foreach ($query as $key => $value) {
                        $img_path = $_SERVER['DOCUMENT_ROOT'] . '/assets/alternate_product_verification_script/' . $value['script_name'];
                        unlink($img_path);
                    }
                    $sql = "DELETE FROM crm_product_alternate_verification_script WHERE product_id =" . $global_id;
                    $this->db->query($sql);
                    $files = $_FILES['alternate_script'];
                    $this->mp3_upload($files);
                }
            } else {
                if (isset($_FILES['alternate_script'])) {
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
            if (isset($license_type) && $license_type != null) {
                foreach ($license_type as $type) {
                    $licenseType = array('global_product_id' => $product_id, 'license_type' => $type);
                    $productLT = insert_update_data($ins, $table_name = 'crm_product_license_type', $ins_data = $licenseType, $where);
                }
            } else {
                $productLT = '';
            }
            if (isset($post['commission_structure'])) {
                if ($this->input->post('commission_structure') == 'flatfee') {
                    $commission_structure = "flatfee";
                    $commission_array = array(
                        "flat_commission" => $this->input->post("flat_commission"),
                        "flat_renewal" => $this->input->post("flat_renewal")
                    );
                } else if ($this->input->post('commission_structure') == 'percentpremium') {
                    $commission_structure = "percentpremium";
                    $commission_array = array(
                        "percent_premium_commsion" => $this->input->post("percent_premium_commsion"),
                        "percent_premium_duration" => $this->input->post("percent_premium_duration"),
                        "percent_premium_renewal" => $this->input->post("percent_premium_renewal"),
                        "percent_noncommissionable_premium" => $this->input->post("percent_noncommissionable_premium"),
                        "default_percent_premium" => $this->input->post("default_percent_premium"),
                    );
                } else if ($this->input->post('commission_structure') == 'tieryears') {
                    $commission_structure = "tieryears";
                    $commission_array = array(
                        "tieryears_premium" => $this->input->post("tieryears_premium"),
                        "tieryears_premium_duration" => $this->input->post("tieryears_premium_duration"),
                        "tier1_number_years" => $this->input->post("tier1_number_years"),
                        "tier1_percent_premium" => $this->input->post("tier1_percent_premium"),
                        "tier2_number_years" => $this->input->post("tier2_number_years"),
                        "tier2_percent_premium" => $this->input->post("tier2_percent_premium"),
                        "tier3_number_years" => $this->input->post("tier3_number_years"),
                        "tier3_percent_premium" => $this->input->post("tier3_percent_premium"),
                    );
                } else if ($this->input->post('commission_structure') == 'commissionablepremium') {
                    $commission_structure = "commissionablepremium";
                    $commission_array = array(
                        "premium" => $this->input->post("premium"),
                        "premium_duration" => $this->input->post("premium_duration"),
                        "commissionable_premium" => $this->input->post("commissionable_premium"),
                        "percent_premium" => $this->input->post("percent_premium"),
                    );
                } else {
                    $commission_structure = "calendarpremium";
                    $commission_array = array(
                        "calendarpremium_commission" => $this->input->post("calendarpremium_commission"),
                        "calendarpremium_renewal" => $this->input->post("calendarpremium_renewal")
                    );
                }
                $commission_value = serialize($commission_array);
            } else {
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
            if (isset($global_id) && $global_id != null) {
                $ins = '';
                $where = "product_id = " . $global_id;
            } else {
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
            if (isset($global_id) && $global_id != '') {
                $this->session->set_flashdata("success", "Product Updated Successfully.");
            } else {
                $this->session->set_flashdata("success", "Product Added Successfully.");
            }
            redirect('agency/products/index');
        }
        $this->template->load('agency_header', 'agency/products/add', $data);
    }

    public function categories() {
        $data['title'] = "Products Categories || AgencyVue";
        $data['page_title'] = 'Products Categories';
        $this->template->load('agency_header', 'agency/products/category', $data);
    }

    public function add_edit_category() {
        if ($this->input->post('method') == 'add') {
            if ($this->input->post('name') != '') {
                $dataArr = array('product_category_name' => $this->input->post('name'), 'created_by' => $this->session->userdata('user_info')['user_id']);
                insert_update_data(1, 'crm_product_category', $dataArr);
            } else {
                exit('NAME NULL || Add Edit CATEGORY');
            }
        } elseif ($this->input->post('method') == 'edit') {
            if ($this->input->post('name') != '' && $this->input->post('id') != '') {
                insert_update_data(0, 'crm_product_category', array('product_category_name' => $this->input->post('name')), array('product_category_id' => $this->input->post('id')));
            } else {
                exit('ID OR NAME NULL || Add Edit CATEGORY');
            }
        } else {
            exit('METHOD NULL || Add Edit CATEGORY');
        }
    }

    public function removeCategory() {
        if ($this->input->post('id') != '') {
            delete_data('crm_product_category', array('product_category_id' => $this->input->post('id')));
        } else {
            exit('ID NULL || REMOVE CATEGORY');
        }
    }

    public function get_types() {
        $category_name = $this->input->post('category_name');
        $query = "SELECT * FROM crm_product_type WHERE product_category_name = " . $category_name;
        $output = $this->db->sql($query)->result_array();
        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    public function categoryJson() {
        $aColumns = array("product_category_id", "product_category_name", "created_date");

        /* Pagination */

        $sLimit = array();
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $sLimit = array("start" => $_GET['iDisplayLength'], "end" => $_GET['iDisplayStart']);
        }

        /* Search */

        $sWhere = "";
        if ($_GET['sSearch'] != "") {

            $sWhere .= " (";
            for ($i = 0; $i < count($aColumns); $i++) {
                $sWhere .= $aColumns[$i] . " LIKE '%" . $_GET['sSearch'] . "%' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ') ';
        }
        $sOrder = array();

        if ($_GET['iSortCol_0'] != "") {
            for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                    $sOrder = array("field" => $aColumns[intval($_GET['iSortCol_' . $i])],
                        "order" => $_GET['sSortDir_' . $i]);
                }
            }
        }
        $rResult = $this->product->get_categories($sLimit, $sWhere, $sOrder);
        $iTotal_f = count($rResult);
        $iTotal = $this->product->get_categoriesCount($sWhere);
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
                    if ($aColumns[$i] == 'product_category_id') {
                        $row[] = "<div class='checkbox checkbox-primary checkbox-single m-r-15'>
                        <input id='act_checkbox_" . $aRow['product_category_id'] . "' type='checkbox' value=" . urlencode(base64_encode($aRow["product_category_id"])) . " name='act_checkbox[]' class='ch_checkbox'>
                        <label for='act-checkbox'></label>
                    </div>";
                    } else {
                        $row[] = isset($aRow[$aColumns[$i]]) ? $aRow[$aColumns[$i]] : '';
                    }
                }
                $row[] .= '<span class="btn btn-default btn-xs table-action-btn admin-action-icon-in-data-table edit_product_category" data-cateid = "' . $aRow['product_category_id'] . '" data-catename="' . $aRow['product_category_name'] . '" title = "Edit Category Prfile"><i class="fa fa-pencil"></i></span>'
                        . '<span class="danger-alert btn btn-danger btn-xs table-action-btn admin-action-icon-in-data-table remove-span del_cate" data-id="' . $aRow["product_category_id"] . '"><i class="glyphicon glyphicon-remove" title="Remove Category"></i></span>';
                $output['aaData'][] = $row;
            }
        }
        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    public function types() {
        $data['title'] = "Products Types || AgencyVue";
        $data['page_title'] = 'Products Types';
        $data['product_categoies'] = get_data('crm_product_category', 0, array('created_by' => $this->session->userdata('user_info')['user_id']));
        $this->template->load('agency_header', 'agency/products/types', $data);
    }

    public function add_edit_type() {
        if ($this->input->post('method') == 'add') {
            if ($this->input->post('name') != '') {
                $dataArr = array('product_category_id' => $this->input->post('id'), 'product_type_name' => $this->input->post('name'), 'created_by' => $this->session->userdata('user_info')['user_id']);
                insert_update_data(1, 'crm_product_type', $dataArr);
            } else {
                exit('NAME NULL || Add Edit CATEGORY');
            }
        } elseif ($this->input->post('method') == 'edit') {
            if ($this->input->post('name') != '' && $this->input->post('id') != '') {
                insert_update_data(0, 'crm_product_type', array('product_category_id' => $this->input->post('cate'), 'product_type_name' => $this->input->post('name')), array('product_type_id' => $this->input->post('id')));
            } else {
                exit('ID OR NAME NULL || Add Edit CATEGORY');
            }
        } else {
            exit('METHOD NULL || Add Edit CATEGORY');
        }
    }

    public function typeJson() {
        $aColumns = array("product_type_id", "product_category_name", "product_type_name", "created_date");

        /* Pagination */

        $sLimit = array();
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $sLimit = array("start" => $_GET['iDisplayLength'], "end" => $_GET['iDisplayStart']);
        }

        /* Search */

        $sWhere = "";
        if ($_GET['sSearch'] != "") {

            $sWhere .= " (";
            for ($i = 0; $i < count($aColumns); $i++) {
                $sWhere .= $aColumns[$i] . " LIKE '%" . $_GET['sSearch'] . "%' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ') ';
        }
        $sOrder = array();

        if ($_GET['iSortCol_0'] != "") {
            for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                    $sOrder = array("field" => $aColumns[intval($_GET['iSortCol_' . $i])],
                        "order" => $_GET['sSortDir_' . $i]);
                }
            }
        }

        $rResult = $this->product->get_product_types($sLimit, $sWhere, $sOrder);
        $iTotal_f = count($rResult);
        $iTotal = $this->product->get_typesCount($sWhere);
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
                    if ($aColumns[$i] == 'product_type_id') {
                        $row[] = "<div class='checkbox checkbox-primary checkbox-single m-r-15'>
                        <input id='act_checkbox_" . $aRow['product_type_id'] . "' type='checkbox' value=" . urlencode(base64_encode($aRow["product_type_id"])) . " name='act_checkbox[]' class='ch_checkbox'>
                        <label for='act-checkbox'></label>
                    </div>";
                    } else {
                        $row[] = isset($aRow[$aColumns[$i]]) ? $aRow[$aColumns[$i]] : '';
                    }
                }
                $row[] .= '<span class="btn btn-default btn-xs table-action-btn admin-action-icon-in-data-table edit_product_category" data-typeid = "' . $aRow['product_type_id'] . '" data-typename="' . $aRow['product_type_name'] . '" data-cateid="' . $aRow['product_category_id'] . '" title = "Edit Category Prfile"><i class="fa fa-pencil"></i></span>'
                        . '<span class="danger-alert btn btn-danger btn-xs table-action-btn admin-action-icon-in-data-table remove-span del_cate" data-id="' . $aRow["product_type_id"] . '"><i class="glyphicon glyphicon-remove" title="Remove Category"></i></span>';
                $output['aaData'][] = $row;
            }
        }
        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    public function removeType() {
        if ($this->input->post('id') != '') {
            delete_data('crm_product_type', array('product_type_id' => $this->input->post('id')));
        } else {
            exit('ID NULL || REMOVE CATEGORY');
        }
    }

    public function coveragetype() {
        $data['title'] = "Coverage Types || AgencyVue";
        $data['page_title'] = 'Coverage Types';
        $this->template->load('agency_header', 'agency/products/coveragetype', $data);
    }

    public function add_edit_coverageType() {
        if ($this->input->post('method') == 'add') {
            if ($this->input->post('name') != '') {
                $dataArr = array('coverage_type_name' => $this->input->post('name'), 'created_by' => $this->session->userdata('user_info')['user_id']);
                insert_update_data(1, 'crm_product_coverage_type', $dataArr);
            } else {
                exit('NAME NULL || Add Edit Coverage Type');
            }
        } elseif ($this->input->post('method') == 'edit') {
            if ($this->input->post('name') != '' && $this->input->post('id') != '') {
                insert_update_data(0, 'crm_product_coverage_type', array('coverage_type_name' => $this->input->post('name')), array('coverage_type_id' => $this->input->post('id')));
            } else {
                exit('ID OR NAME NULL || Add Edit Coverage Type');
            }
        } else {
            exit('METHOD NULL || Add Edit Coverage Type');
        }
    }

    public function coverageTypeJson() {
        $aColumns = array("coverage_type_id", "coverage_type_name", "created_date");

        /* Pagination */

        $sLimit = array();
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $sLimit = array("start" => $_GET['iDisplayLength'], "end" => $_GET['iDisplayStart']);
        }

        /* Search */

        $sWhere = "";
        if ($_GET['sSearch'] != "") {

            $sWhere .= " (";
            for ($i = 0; $i < count($aColumns); $i++) {
                $sWhere .= $aColumns[$i] . " LIKE '%" . $_GET['sSearch'] . "%' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ') ';
        }
        $sOrder = array();

        if ($_GET['iSortCol_0'] != "") {
            for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                    $sOrder = array("field" => $aColumns[intval($_GET['iSortCol_' . $i])],
                        "order" => $_GET['sSortDir_' . $i]);
                }
            }
        }

        $rResult = $this->product->get_coverageType($sLimit, $sWhere, $sOrder);
        $iTotal_f = count($rResult);
        $iTotal = $this->product->get_coverageTypeCount($sWhere);
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
                    if ($aColumns[$i] == 'coverage_type_id') {
                        $row[] = "<div class='checkbox checkbox-primary checkbox-single m-r-15'>
                        <input id='act_checkbox_" . $aRow['coverage_type_id'] . "' type='checkbox' value=" . urlencode(base64_encode($aRow["coverage_type_id"])) . " name='act_checkbox[]' class='ch_checkbox'>
                        <label for='act-checkbox'></label>
                    </div>";
                    } else {
                        $row[] = isset($aRow[$aColumns[$i]]) ? $aRow[$aColumns[$i]] : '';
                    }
                }
                $row[] .= '<span class="btn btn-default btn-xs table-action-btn admin-action-icon-in-data-table edit_coverage_type" data-cateid = "' . $aRow['coverage_type_id'] . '" data-catename="' . $aRow['coverage_type_name'] . '" title = "Edit Coverage Type"><i class="fa fa-pencil"></i></span>'
                        . '<span class="danger-alert btn btn-danger btn-xs table-action-btn admin-action-icon-in-data-table remove-span del_cate" data-id="' . $aRow["coverage_type_id"] . '"><i class="glyphicon glyphicon-remove" title="Remove Coverage Type"></i></span>';
                $output['aaData'][] = $row;
            }
        }
        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    public function removecoverageType() {
        if ($this->input->post('id') != '') {
            delete_data('crm_product_coverage_type', array('coverage_type_id' => $this->input->post('id')));
        } else {
            exit('ID NULL || REMOVE CATEGORY');
        }
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
        $data['agent_id'] = $this->session->userdata('user_info')['user_id'];
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
