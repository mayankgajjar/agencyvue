<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Products extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('vendor');
        $this->load->model('product');

    }


    public function index(){
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
            $sWhere .= "AND (";
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
                        . '<a class="btn btn-default btn-xs table-action-btn admin-action-icon-in-data-table" href="' . site_url('agent/products/edit_product/' . urlencode(base64_encode($aRow["global_product_id"]))) . '"><i class="fa fa-pencil" title="Edit Product"></i></a>'
                        . '<span class="btn btn-warning btn-xs table-action-btn admin-action-icon-in-data-table product_archived" data-custom-value="' . urlencode(base64_encode($aRow["global_product_id"])) . '"><i class="fa fa-folder" title="Product Archive"></i></span>'
                        . '<span class="danger-alert btn btn-danger btn-xs table-action-btn product_del admin-action-icon-in-data-table remove-span" data-custom-value="' . urlencode(base64_encode($aRow["global_product_id"])) . '"><i class="glyphicon glyphicon-remove" title="Remove Product"></i></span>';

                $output['aaData'][] = $row;
            }
        }

        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }    


    public function addProduct() {
        $data['title'] = 'Products';
        //$data['states'] = get_all_state();
        $data['vendors'] = $this->vendor->get();
        $data['products_category'] = $this->product->get('product_coverage');
        $data['products_type'] = $this->product->get('product_type');

        // echo "<pre>";
        // print_r($data);
        // die;
        $this->template->load('agent_header', 'agent/product/add_product',$data);
    }

    /**
     * @uses add_quote is used for add_quote data and if check box checked then also add in lead
     * @author RRA
     */
    public function add_quote() {
        $data['title'] = 'Add_Product';
        echo "here";
        die;
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
        /* echo $this->db->last_query();
          die; */
        $this->template->load('agent_header', 'agent/quote/product_details', $data);
    }

    public function product_information() {
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
        $this->db->where('vendor_id', $vendor_id);
        $query = $this->db->get();
        $data['vendor_info'] = $query->row_array();
        $new_html = $this->load->view('admin/product/product_info', $data, true);
        echo json_encode(['prod_data' => $data['product_info'], 'new_html' => $new_html]);
        die;
    }

    public function checkout() {
        $user_data = $this->session->userdata('cart_data');
        $product_data = json_decode($_POST['cart_list']);
        $this->session->set_userdata('product_data', $product_data);

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
        $member_products_id = array();
        foreach ($product_data as $pd) {
            $prooductid = $pd->product_id;
            $pro_arr = array('product_id' => $prooductid, 'member_id' => $user_id, 'added_by' => $this->session->userdata['user_info']['user_id'], 'is_status' => 'W');
            $product_info = insert_update_data($ins = 1, $table_name = 'crm_member_products', $ins_data = $pro_arr);
            array_push($member_products_id, $this->db->insert_id());
            //echo $this->db->last_query();
        }
        $this->session->set_userdata('member_products_id', $member_products_id);
        $log = array('action_by' => $this->session->userdata['user_info']['user_id'], 'customer_id' => $customer_id, 'action' => 'created');
        $member_log = insert_update_data($ins = 1, $table_name = 'crm_member_log', $ins_data = $log);
        $msg = "Hello " . $user_data['first_name'] . "<br><br>
                        You are successfully registered in Agency Vue.<br><br>
                        Your Login details:<br><br>
                        <strong> Email Address : </strong>" . $user_data['emailid'] . "<br>
                        <strong> Password : </strong>" . $user_password . "<br><br>
                        Click Below URL for Login <br><br>
                        http://agencyvue.com/login/  <br><br>
                        Thank You,<br><br>
                        Agency Vue";
        $subject = "Thank You for your registration";
        $to_email = $user_data['emailid'];
        $title = 'Agency Vue registration';
        send_email($to_email, $subject, $msg, $title);
        redirect(base_url() . 'agent/quote/member_info/' . urlencode(base64_encode($customer_id)) . '');
        //$this->member_info($customer_id);
    }

    public function member_info($id = null) {

        $data['title'] = 'Member Information || Admin';
        $uid = base64_decode(urldecode($id));

        $lead_member = $this->member->get_infos($uid, 'crm_lead_member_master', 'customer_id');
        $data['lead_member'] = $lead_member[0];

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

        if (($this->input->post('save'))) {
            $product_id = $this->input->post('product_id');
            $customer_id = $this->input->post('customer_id');
            $script_data = array('product_id' => $product_id, 'state' => $this->input->post('cus_state'));
            $this->session->set_userdata('script_data', $script_data);

            if (!empty($_FILES['verification_scripts']['name'])) {
                $filesCount = count($_FILES['verification_scripts']['name']);
                $config['upload_path'] = 'assets/product_verification_script/';
                $config['allowed_types'] = 'mp3|wav';
                $config['max_size'] = 5120;

                for ($i = 0; $i < $filesCount; $i++) {
                    if ($_FILES['verification_scripts']['type'][$i] == 'audio/mp3') {
                        $_FILES['verification_script']['name'] = $i . time() . '.mp3';
                    } else {
                        $_FILES['verification_script']['name'] = $i . time() . '.wav';
                    }
                    $_FILES['verification_script']['type'] = $_FILES['verification_scripts']['type'][$i];
                    $_FILES['verification_script']['tmp_name'] = $_FILES['verification_scripts']['tmp_name'][$i];
                    $_FILES['verification_script']['error'] = $_FILES['verification_scripts']['error'][$i];
                    $_FILES['verification_script']['size'] = $_FILES['verification_scripts']['size'][$i];

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('verification_script')) {
                        $fileData = $this->upload->data();
                        $data_array = array(
                            'script' => $fileData['file_name'],
                            'product_id' => $product_id[$i],
                            'user_id' => $customer_id,
                        );
                        insert_update_data($ins = 1, $table_name = 'crm_member_product_script', $ins_data = $data_array);
                    }
                }
            }
            $data_crm_user_tbl = array(
                'display_name' => $this->input->post('cus_first_name') . " " . $this->input->post('cus_last_name'),
            );
            $condition_crm_user_tbl = array('user_id' => $customer_id);
            $user_table = insert_update_data($ins = 0, $table_name = 'crm_user_tbl', $ins_data = $data_crm_user_tbl, $where = $condition_crm_user_tbl);

            $data_crm_lead_member_primary = array(
                'customer_first_name' => $this->input->post('cus_first_name'),
                'customer_middle_name' => $this->input->post('cus_middle_name'),
                'customer_last_name' => $this->input->post('cus_last_name'),
                'customer_gender' => $this->input->post('gender'),
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
                    //'customer_verification' => $vari_script,
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

            redirect(base_url() . 'agent/quote/checkout_script/' . urlencode(base64_encode($customer_id)));
        }

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
        $data['memberProducts'] = array_column($data['buyProductID'], 'product_id');
        $id_str = implode(',', $data['memberProducts']);

        if (sizeof($data['memberProducts']) > 0) {
            $product_query = $this->db->query('SELECT * FROM `crm_product_state` as `states`
            JOIN `crm_products` as `products` ON `states`.`global_product_id` = `products`.`global_product_id`
            JOIN `crm_product_age_weight_height` as `weight` ON `weight`.`global_product_id` = `states`.`global_product_id`
            WHERE `weight`.`max_age` >= ' . $main_age . ' AND `weight`.`min_age` <= ' . $main_age . ' AND `states`.`state` = "' . $state_id . '"
            AND products.global_product_id NOT IN(' . $id_str . ') AND `products`.`is_deleted` = "N" AND `products`.`product_status` = "active"');
            /* echo $this->db->last_query();
              die; */
            $data['product_array01'] = $product_query->result_array();
        } else {
            $data['product_array01'] = $data['product_array'];
        }
        $this->template->load('agent_header', 'agent/quote/edit_member', $data);
    }

    function checkout_script($customer_id = null) {
        if ($customer_id == null) {
            exit('ERROR IN MEMBER ID || AGENCY VUE');
        }
        $ver_script_data = $this->session->userdata('script_data');
        $user_state = $ver_script_data['state'];
        $this->load->model('verification_script');
        foreach ($ver_script_data['product_id'] as $pro_id) {
            $scripts_data[] = $this->verification_script->get_script_product_id($pro_id, $user_state);
            //echo $this->db->last_query().'<br>';
        }
        $scripts_arr = array();
        $member_details = get_data('crm_lead_member_primary', '1', array('customer_id' => base64_decode(urldecode($customer_id))));
        foreach ($scripts_data as $key => $script) {
            array_push($scripts_arr, array('product_name' => get_product_global_id($script[$key]['global_product_id']), 'script_html' => $script[$key]['script_html'], 'member_id' => base64_decode(urldecode($customer_id)), 'customer_name' => $member_details['customer_first_name'] . ' ' . $member_details['customer_last_name'], 'customer_address' => $member_details['customer_address'], 'customer_address_details' => $member_details['customer_address_details'], 'customer_city' => $member_details['customer_city'], 'customer_state' => $member_details['customer_state'], 'customer_zipcode' => $member_details['customer_zipcode']));
        }
        $data['title'] = 'Verification';
        $data['scripts_arr'] = $scripts_arr;
        $data['backurl'] = site_url('agent/quote/member_info/' . $customer_id);
        $data['completeurl'] = site_url('agent/quote/complete/' . $customer_id);
        $this->template->load('agent_header', 'agent/quote/verification', $data);
    }

    public function complete($customer_id = NULL) {
        if ($customer_id == null) {
            exit('ERROR IN MEMBER ID || AGENCY VUE');
        }
        if ($this->session->userdata('member_products_id') == "") {
            $this->session->set_flashdata('error', 'Please seletect the products');
        }
        $uid = get_global_userID(base64_decode(urldecode($customer_id)));
        $data['member_product_array'] = $this->product->fetch_product_data($uid);
        $data['member_product_ids'] = array_column($data['member_product_array'], 'global_product_id');
        $data['title'] = 'Checkout Process || Quote';
        $table = 'crm_lead_member_primary';
        $results = get_relation($table, array('conditions' => "customer_email= '{$this->session->userdata('cart_data')['emailid']}'"));
        $data['customer'] = $results[0];
        # Save Data Into `crm_member_products`
        $data['backurl'] = site_url('agent/quote/checkout_script/' . $customer_id);
        if (($this->input->post('checkout'))) {
            $product_id = $this->input->post('product_id');
            $customer_id = $this->input->post('customer_id');
            if (!empty($_FILES['verification_scripts']['name'])) {
                $filesCount = count($_FILES['verification_scripts']['name']);
                $config['upload_path'] = 'assets/product_verification_script/';
                $config['allowed_types'] = 'mp3|wav';
                $config['max_size'] = 5120;
                for ($i = 0; $i < $filesCount; $i++) {
                    if ($_FILES['verification_scripts']['type'][$i] == 'audio/mp3') {
                        $_FILES['verification_script']['name'] = $i . time() . '.mp3';
                    } else {
                        $_FILES['verification_script']['name'] = $i . time() . '.wav';
                    }
                    $_FILES['verification_script']['type'] = $_FILES['verification_scripts']['type'][$i];
                    $_FILES['verification_script']['tmp_name'] = $_FILES['verification_scripts']['tmp_name'][$i];
                    $_FILES['verification_script']['error'] = $_FILES['verification_scripts']['error'][$i];
                    $_FILES['verification_script']['size'] = $_FILES['verification_scripts']['size'][$i];

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('verification_script')) {
                        $fileData = $this->upload->data();
                        $data_array = array(
                            'script' => $fileData['file_name'],
                            'product_id' => $product_id[$i],
                            'user_id' => $uid,
                        );
                        $insert = insert_update_data($ins = 1, $table_name = 'crm_member_product_script', $ins_data = $data_array);
                    }
                }
                $scripts = $this->session->userdata('member_products_id');
                foreach ($scripts as $script) {
                    $this->db->set('is_status', 'Y');
                    $this->db->where('member_product_id', $script);
                    $this->db->update('crm_member_products');
                }
                $leadAddFeed = array(
                    'from_id' => $this->session->userdata['user_info']['user_id'],
                    'to_id' => $this->session->userdata['user_info']['user_id'],
                    'feed_type' => 'feed',
                    'feed_icon' => 'fa fa-check-square-o',
                    'feed_title' => 'Checkout Process Completed Successfully',
                );
                insert_update_data(1, 'crm_feeds', $leadAddFeed);
                $this->session->unset_userdata('member_products_id');
                $this->session->set_flashdata('success', 'Member Successfully Added!');
                redirect(base_url('agent/dashboard'));
            } else {
                $this->session->set_flashdata('error', 'Upload Verification Script(s)');
            }
        }
        $this->template->load('agent_header', 'agent/quote/complete', $data);
    }

}
