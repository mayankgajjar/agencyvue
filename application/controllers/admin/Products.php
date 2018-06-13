<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Products extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('product');
    }

    public function index() {
        $data['title'] = 'Product || Admin';
        $this->template->load('admin_header', 'admin/product/index', $data);
    }

    /* This function is used for add new product */

    public function addProduct() {
        $data['title'] = 'Add New Product  || Admin';
        $this->load->model('common');
        $data['states'] = $this->common->get_all_state();
        $data['vendors'] = $this->common->get_all_vendors();

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
                $this->session->set_flashdata('success', 'Product is successfully added!');
                redirect(base_url() . 'admin/products');
            }
        }

        $this->template->load('admin_header', 'admin/product/addProduct', $data);
    }

    function productJson() {

        $aColumns = array("global_product_id", "product_status", "product_id", "plan_id", "product_name", "product_coverage", "product_type", "total_states", "product_requires_license");

        /* Pagination */

        $sLimit = array();
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $sLimit = array("start" => $_GET['iDisplayLength'], "end" => $_GET['iDisplayStart']);
        }

        /* Search */

        $sWhere = "";
        $sColumns = array("product_status", "product_id", "plan_id", "product_name", "product_coverage", "product_type", "product_requires_license");

        if ($_GET['sSearch'] != "") {
            $sWhere .= " (";
            for ($i = 0; $i < count($sColumns); $i++) {
                $sWhere .= $sColumns[$i] . " LIKE '%" . $_GET['sSearch'] . "%' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ') ';
        }

        /* Order */

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

                $row[] .= '<span class="btn btn-info btn-xs table-action-btn admin-action-icon-in-data-table copy_product" data-custom-value="' . urlencode(base64_encode($aRow["global_product_id"])) . '" ><i class="fa fa-copy" title="Copy Product"></i></span>'
                        . '<a class="btn btn-default btn-xs table-action-btn admin-action-icon-in-data-table" href="' . base_url() . 'admin/products/edit_product/' . urlencode(base64_encode($aRow["global_product_id"])) . '"><i class="fa fa-pencil" title="Edit Product"></i></a>'
                        . '<span class="btn btn-warning btn-xs table-action-btn admin-action-icon-in-data-table product_archived" data-custom-value="' . urlencode(base64_encode($aRow["global_product_id"])) . '"><i class="fa fa-folder" title="Product Archive"></i></span>'
                        . '<span class="danger-alert btn btn-danger btn-xs table-action-btn product_del admin-action-icon-in-data-table remove-span" data-custom-value="' . urlencode(base64_encode($aRow["global_product_id"])) . '"><i class="glyphicon glyphicon-remove" title="Remove Product"></i></span>';
                ;

                $output['aaData'][] = $row;
            }
        }

        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    /* This function is used for edit product */

    public function edit_product($id = null) {

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

                //$this->upload->initialize($config);
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
            redirect(base_url() . 'admin/products');
        }
        $this->template->load('admin_header', 'admin/product/edit_product', $data);
    }

    public function copyProduct($global_id = null) {
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
            echo "Product Successfully Archived";
        }
        die();
    }

    public function copyProductP($global_id = null) {
        $global_id = $_REQUEST['global_id'];
        if ($global_id != "") {
            $global_id = base64_decode(urldecode($global_id));
            $product_details = $this->product->product_details($global_id);
//            pr_exit($product_details['product_data']);
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
        echo $this->load->view('admin/product/filter_product.php', $data, true);
    }

}
