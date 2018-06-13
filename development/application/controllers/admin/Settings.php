<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('Csvimport');
    }

    public function featuredProduct() {
        $data['title'] = 'Featured Product For Configuration || Admin';
        $where = array('setting_name' => 'featured_product');
        $fproduct = get_data('crm_settings_tbl', 1, $where);
        if (sizeof($fproduct) != 0) {
            $data['featuredproduct'] = $fproduct;
        }
        if ($this->input->post()) {
            $featuredValue = $this->input->post('save');
            $data_setting = array(
                'setting_name' => 'featured_product',
                'setting_value' => $this->input->post('area')
            );
            if (sizeof($fproduct) != 0) {
                $setting = insert_update_data($ins = 0, $table_name = 'crm_settings_tbl', $ins_data = $data_setting, $where);
                $this->session->set_flashdata('success', 'Featured Product is successfully Updated!');
            } else {
                $setting = insert_update_data($ins = 1, $table_name = 'crm_settings_tbl', $ins_data = $data_setting);
                $this->session->set_flashdata('success', 'Featured Product is successfully Inserted!');
            }
            if ($setting) {
                redirect(base_url() . 'admin/dashboard');
            }
        }
        $this->template->load('admin_header', 'admin/other/featuredproduct', $data);
    }


    public function dashboard_verification_script(){
      $data['title'] = 'Dashboard Verification Script || Admin';
        $sql = "SELECT script_name, state_code FROM crm_state_verification_script WHERE is_active = 'YES' ORDER BY verification_script_id DESC LIMIT 0, 5";
        $query = $this->db->query($sql);
        $data['all_script'] = $query->result_array();

        $this->db->select('crm_products.product_name,crm_state_verification_script.script_name');
        $this->db->from('crm_select_product_verification_script sel_script');
        $this->db->join('crm_products', 'sel_script.global_product_id = crm_products.global_product_id');
        $this->db->join('crm_state_verification_script', 'sel_script.verification_script_id = crm_state_verification_script.verification_script_id');
        $this->db->where('sel_script.status', 'active');
        $this->db->order_by('sel_script.id', 'ASC');
        $this->db->limit(5,0);
        $query2 = $this->db->get();
        $data['product_script'] = $query2 -> result_array();

      $this->template->load('admin_header', 'admin/verification_script/dashboard', $data);
    }

    /*
      This function is used for edit verification script
    */
    public function edit_verification_script($id = null){
      $data['title'] = 'Edit Verification Script || Admin';
      $script_id = base64_decode(urldecode($id));
      $data['state'] = get_data($tbl_name = 'crm_states', $single = 0);
      $data['script_data'] = get_data($tbl_name = 'crm_state_verification_script', $single = 1, $where = array('verification_script_id' => $script_id));
      /*echo '<pre>';
      print_r($data['script_data']);
      die;*/
      if($this->input->post()){
        $this->form_validation->set_rules('area', 'Script', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->form_validation->set_error_delimiters();
        } else {
          $script_name = $this->input->post('script_name');
          $html = $this->input->post('area');
          $s_type= $this->input->post('state_type');
          $state = $this->input->post('script_state');
          $data['is_all'] = get_data($tbl_name = 'crm_state_verification_script', $single = 1, $where = array('script_status' => 'all','is_active' => 'YES'));

          if(isset($data['is_all']) && $s_type == 'all_state' ){
              if($data['is_all']['verification_script_id'] == $script_id){
                $ins_array = array('script_html' => $html,'script_status' => 'all','script_name' => $script_name);
                $setting = insert_update_data($ins = 0, $table_name = 'crm_state_verification_script', $ins_data = $ins_array ,$where= array('verification_script_id' => $script_id));
              }else{
                $this->session->set_flashdata('error', 'Verification Script for all state is already uploaded!');
                redirect(base_url() . 'admin/settings/edit_verification_script/'.$id);
                return false;
              }
          }else{
              $ins_array = array('script_html' => $html,'script_status' => 'singal','state_code' =>$state,'script_name'=>$script_name);
              $setting = insert_update_data($ins = 0, $table_name = 'crm_state_verification_script', $ins_data = $ins_array ,$where= array('verification_script_id' => $script_id));
          }
          if ($setting) {
              $this->session->set_flashdata('success', 'Verification Script is successfully Updated!');
              redirect(base_url() . 'admin/settings/verification_script');
          }
        }
      }
      $this->template->load('admin_header', 'admin/verification_script/edit_script', $data);
    }

    /**
     * @uses agency_setup is used for set agency payment info
     * @author MGA
     */
    public function stripe() {
        $data['title'] = "Agency Setup || Admin";
        $setup_data = get_data($tbl_name = 'crm_agency_setup', $single = 1, $where = array('setup_id' => '1'));
        if(isset($setup_data)){
            $data['data'] = $setup_data;
        }

        if($this->input->post('Save')){
            $this->form_validation->set_rules('reg_fee', 'Registration Fee', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->form_validation->set_error_delimiters();
            } else {
                $regfee = $this->input->post('reg_fee');
                $enb_test = $this->input->post('test_mode');
                $live_secret = $this->input->post('live_secret');
                $live_publishable = $this->input->post('live_publishable');
                $live_client = $this->input->post('live_client');
                $test_secret = $this->input->post('test_secret');
                $test_publishable = $this->input->post('test_publishable');
                $test_client = $this->input->post('test_client');


               if(isset($enb_test)){
                   $data_setting =  array(
                       'registration_fee' => $regfee,
                       'enable_test' => 'YES',
                       'live_secret_key' => $live_secret,
                       'live_publishable_key' => $live_publishable,
                       'live_client_id' => $live_client,
                       'test_secret_key' => $test_secret,
                       'test_publishable_key' => $test_publishable,
                       'test_client_id' => $test_client,
                   );
               }else{
                    $data_setting =  array(
                       'registration_fee' => $regfee,
                       'enable_test' => 'NO',
                       'live_secret_key' => $live_secret,
                       'live_publishable_key' => $live_publishable,
                       'live_client_id' => $live_client,
                       'test_secret_key' => $test_secret,
                       'test_publishable_key' => $test_publishable,
                       'test_client_id' => $test_client,
                   );
               }

                if(isset($setup_data)){
                    $con_array = array('setup_id' => '1');
                    $setting = insert_update_data($ins = 0, $table_name = 'crm_agency_setup', $ins_data = $data_setting, $con_array);
                    $this->session->set_flashdata('success', 'Agency Setup is successfully Updated!');
                }else{
                    $setting = insert_update_data($ins = 1, $table_name = 'crm_agency_setup', $ins_data = $data_setting);
                    $this->session->set_flashdata('success', 'Agency Setup is successfully Inserted!');
                }
                if($setting){
                    redirect(base_url() . 'admin/settings/stripe');
                }
            }
        }

      $this->template->load('admin_header', 'admin/agency_setup/index', $data);
    }

    /**
     * @uses to build JSon for Data-table
     * @author MGA
     */
    function ProductScriptJson() {
        $aColumns = array("id", "script_name", "state_code", "product_name", "created_date");

        /* Pagination */

        $sLimit = array();

        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $sLimit = array("start" => $_GET['iDisplayLength'], "end" => $_GET['iDisplayStart']);
        }

        /* Search */

        $sWhere = "";
        if ($_GET['sSearch'] != "") {
            $sColumns = array("script_name", "state_code", "product_name", "product.created_date");
            $sWhere .= " (";
            for ($i = 0; $i < count($sColumns); $i++) {
                $sWhere .= $sColumns[$i] . " LIKE '%" . $_GET['sSearch'] . "%' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ') ';
        }

        /* Order */
        if ($_GET['iSortCol_0'] != "") {
            for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                    $sOrder = array("field" => $aColumns[intval($_GET['iSortCol_' . $i])],
                        "order" => $_GET['sSortDir_' . $i]);
                }
            }
        } else {
            $sOrder = array("field" => $aColumns[3],
                "order" => 'DESC');
        }

        $this->load->model('verification_script');
        $rResult = $this->verification_script->get_product_verification_script($sLimit, $sWhere, $sOrder);
        $iTotal_f = count($rResult);
        $iTotal = $this->verification_script->get_product_verification_script_count($sWhere);

        $output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $iTotal_f,
            "iTotalDisplayRecords" => $iTotal,
            "aaData" => array()
        );
       /* echo '<pre>';
        print_r($rResult);
        die;*/

         if ($rResult) {
            foreach ($rResult as $aRow) {
                $row = array();
                for ($i = 0; $i < count($aColumns); $i++) {

                    if ($aColumns[$i] == 'id') {
                        $row[] = "
                    <div class='checkbox checkbox-primary checkbox-single m-r-15'>
                        <input id='act_checkbox_" . $aRow['id'] . "' type='checkbox' value=" . urlencode(base64_encode($aRow["id"])) . " name='act_checkbox[]' class='ch_checkbox'>
                        <label for='act-checkbox'></label>
                    </div>";
                    } elseif ($aColumns[$i] == 'state_code') {
                        if ($aRow[$aColumns[$i]] == "") {
                            $row[] = 'For All State';
                        } else {
                            $row[] = get_state_name($aRow[$aColumns[$i]]);
                        }
                    } else {
                        $row[] = isset($aRow[$aColumns[$i]]) ? $aRow[$aColumns[$i]] : '';
                    }
                }

                $output['aaData'][] = $row;
            }
        }
        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

    public function blukleadupload(){
        $data['title'] = "Bulk Lead Upload || Admin";
        if($this->input->post("Upload"))
            {
                $this->load->library('upload');
                $config['upload_path'] = FCPATH.'assets/Upload_lead_excel/';
                $config['allowed_types'] = 'csv|xls|XLSX';
                $config['max_size'] = '1000000';
                $this->upload->initialize($config);
                if ( ! $this->upload->do_upload('file'))
                {
                    $error = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                } else {

                $filename = $this->upload->file_name;
                $csv_array = $this->csvimport->get_array( "assets/Upload_lead_excel/" . $filename);
                if ($csv_array) {
                        if(isset($csv_array[0]['first_name']) && isset($csv_array[0]['middle_name'])
                        && isset($csv_array[0]['last_name']) && isset($csv_array[0]['email'])
                        && isset($csv_array[0]['phone_number']) && isset($csv_array[0]['DOB'])
                        && isset($csv_array[0]['address']) && isset($csv_array[0]['sub_address'])
                        && isset($csv_array[0]['state']) && isset($csv_array[0]['city'])
                        && isset($csv_array[0]['zip_code']) && isset($csv_array[0]['social_security_number'])
                        && isset($csv_array[0]['customer_weight']) && isset($csv_array[0]['spouse_first_name'])
                        && isset($csv_array[0]['spouse_middle_name']) && isset($csv_array[0]['spouse_last_name'])
                        && isset($csv_array[0]['spouse_email_address']) && isset($csv_array[0]['spouse_phone_number'])
                        && isset($csv_array[0]['spouse_dob']) && isset($csv_array[0]['spouse_address'])
                        && isset($csv_array[0]['spouse_sub_address']) && isset($csv_array[0]['spouse_state'])
                        && isset($csv_array[0]['spouse_city']) && isset($csv_array[0]['spouse_zipcode'])
                        && isset($csv_array[0]['spouse_social_security_number']) && isset($csv_array[0]['child_first_name'])
                        && isset($csv_array[0]['child_middle_name']) && isset($csv_array[0]['child_last_name'])
                        && isset($csv_array[0]['child_email']) && isset($csv_array[0]['child_phone_number'])
                        && isset($csv_array[0]['child_dob']) && isset($csv_array[0]['child_address'])
                        && isset($csv_array[0]['child_address_details']) && isset($csv_array[0]['child_state'])
                        && isset($csv_array[0]['child_city']) && isset($csv_array[0]['child_zipcode'])
                        && isset($csv_array[0]['child_social_security_number'])
                        ){
                        foreach ($csv_array as $key => $importdata) {
                            $array = array();
                            $array = $importdata;
                                if($importdata['first_name'] != "" || $importdata['last_name'] != "" || $importdata['email'] != "" || $importdata['phone_number'] != "" || $importdata['DOB'] != "" || $importdata['address'] != "" || $importdata['state'] != "" ){
                                    $data_crm_lead_member_master = array('customer_status' => 'lead', 'broker_id' => $this->session->userdata['user_info']['user_id']);
                                    $crm_lead_member_master_insert = $this->db->insert('crm_lead_member_master',$data_crm_lead_member_master);
                                    $customer_id = $this->db->insert_id();

                                    $data_crm_lead_member_primary = array(
                                          'customer_first_name' => $importdata['first_name'],
                                          'customer_id' => $customer_id,
                                          'customer_middle_name' =>$importdata['middle_name'],
                                          'customer_last_name' => $importdata['last_name'],
                                          'customer_email' => $importdata['email'],
                                          'customer_phone_number' => $importdata['phone_number'],
                                          'customer_dob' => date('Y-m-d', strtotime($importdata['DOB'])),
                                          'customer_address' => $importdata['address'],
                                          'customer_address_details' => $importdata['sub_address'],
                                          'customer_state' => $importdata['state'],
                                          'customer_city' => $importdata['city'],
                                          'customer_zipcode' => $importdata['zip_code'],
                                          'customer_social_security_number' => $importdata['social_security_number'],
                                          'customer_weight' => $importdata['customer_weight'],
                                    );
                                    $crm_lead_member_primary_insert = $this->db->insert('crm_lead_member_primary',$data_crm_lead_member_primary);
                                }

                                if($importdata['spouse_first_name'] != "" || $importdata['spouse_middle_name'] != "" || $importdata['spouse_last_name'] != "" || $importdata['spouse_email_address'] != "" || $importdata['spouse_phone_number'] != "" || $importdata['spouse_dob'] != "" || $importdata['spouse_address'] != "" || $importdata['spouse_sub_address'] != "" || $importdata['spouse_state'] != "" || $importdata['spouse_city'] != "" || $importdata['spouse_zipcode'] != "" || $importdata['spouse_social_security_number'] != ""){
                                    $data_crm_lead_member_spouse = array(
                                      'customer_id' => $customer_id,
                                      'customer_spouse_first_name' => $importdata['spouse_first_name'],
                                      'customer_spouse_middle_name' =>$importdata['spouse_middle_name'],
                                      'customer_spouse_last_name' => $importdata['spouse_last_name'],
                                      'customer_spouse_email' => $importdata['spouse_email_address'],
                                      'customer_spouse_phone_number' => $importdata['spouse_phone_number'],
                                      'customer_spouse_dob' => date('Y-m-d', strtotime($importdata['spouse_dob'])),
                                      'customer_spouse_address' => $importdata['spouse_address'],
                                      'customer_spouse_address_details' => $importdata['spouse_sub_address'],
                                      'customer_spouse_state' => $importdata['spouse_state'],
                                      'customer_spouse_city' => $importdata['spouse_city'],
                                      'customer_spouse_zipcode' => $importdata['spouse_zipcode'],
                                      'customer_spouse_social_security_number' => $importdata['spouse_social_security_number'],
                                    );
                                    $crm_lead_member_spouse_insert = $this->db->insert('crm_lead_member_spouse',$data_crm_lead_member_spouse);
                                }

                                if($importdata['child_first_name'] != "" || $importdata['child_middle_name'] != "" || $importdata['child_last_name'] != "" || $importdata['child_email'] != "" || $importdata['child_phone_number'] != "" || $importdata['child_dob'] != "" || $importdata['child_address'] != "" || $importdata['child_address_details'] != "" || $importdata['child_state'] != "" || $importdata['child_city'] != "" || $importdata['child_zipcode'] != "" || $importdata['child_social_security_number'] != ""){
                                    if($importdata['first_name'] != "" && $importdata['child_first_name'] != "" || $importdata['child_middle_name'] != "" || $importdata['child_last_name'] != "" || $importdata['child_email'] != "" || $importdata['child_phone_number'] != "" || $importdata['child_dob'] != "" || $importdata['child_address'] != "" || $importdata['child_address_details'] != "" || $importdata['child_state'] != "" || $importdata['child_city'] != "" || $importdata['child_zipcode'] != "" || $importdata['child_social_security_number'] != ""){
                                        $data_crm_lead_member_child = array(
                                          'customer_id' => $customer_id,
                                          'customer_child_first_name' => $importdata['child_first_name'],
                                          'customer_child_middle_name' =>$importdata['child_middle_name'],
                                          'customer_child_last_name' => $importdata['child_last_name'],
                                          'customer_child_email' => $importdata['child_email'],
                                          'customer_child_phone_number' => $importdata['child_phone_number'],
                                          'customer_child_dob' => date('Y-m-d', strtotime($importdata['child_dob'])),
                                          'customer_child_address' => $importdata['child_address'],
                                          'customer_child_address' => $importdata['child_address_details'],
                                          'customer_child_state' => $importdata['child_state'],
                                          'customer_child_city' => $importdata['child_city'],
                                          'customer_child_zipcode' => $importdata['child_zipcode'],
                                          'customer_child_social_security_number' => $importdata['child_social_security_number'],
                                        );
                                    } else if($importdata['first_name'] == "" && $importdata['child_first_name'] != "" || $importdata['child_middle_name'] != "" || $importdata['child_last_name'] != "" || $importdata['child_email'] != "" || $importdata['child_phone_number'] != "" || $importdata['child_dob'] != "" || $importdata['child_address'] != "" || $importdata['child_address_details'] != "" || $importdata['child_state'] != "" || $importdata['child_city'] != "" || $importdata['child_zipcode'] != "" || $importdata['child_social_security_number'] != ""){
                                        $sql = "SELECT customer_id FROM crm_lead_member_master WHERE customer_id=(SELECT MAX(customer_id) FROM crm_lead_member_master)";
                                        $Query55 = $this->db->query($sql);
                                        $data['id'] = $Query55->row_array();
                                        $id =  $data['id']['customer_id'];

                                        $data_crm_lead_member_child = array(
                                          'customer_id' => $id,
                                          'customer_child_first_name' => $importdata['child_first_name'],
                                          'customer_child_middle_name' =>$importdata['child_middle_name'],
                                          'customer_child_last_name' => $importdata['child_last_name'],
                                          'customer_child_email' => $importdata['child_email'],
                                          'customer_child_phone_number' => $importdata['child_phone_number'],
                                          'customer_child_dob' => date('Y-m-d', strtotime($importdata['child_dob'])),
                                          'customer_child_address' => $importdata['child_address'],
                                          'customer_child_address' => $importdata['child_address_details'],
                                          'customer_child_state' => $importdata['child_state'],
                                          'customer_child_city' => $importdata['child_city'],
                                          'customer_child_zipcode' => $importdata['child_zipcode'],
                                          'customer_child_social_security_number' => $importdata['child_social_security_number'],
                                        );
                                    }
                                    $insert = $this->db->insert('crm_lead_member_child',$data_crm_lead_member_child);
                                }
                                $log = array('action_by' => $this->session->userdata['user_info']['user_id'], 'customer_id' => $customer_id, 'action' => 'created');
                                $lead_log = insert_update_data($ins = 1, $table_name = 'crm_lead_log', $ins_data = $log);
                                $this->session->set_flashdata('success', "Lead Data is successfully Upload");
                        }
                        } else {
                            $this->session->set_flashdata('error', "Invalid file format! Please download file format.");
                        }
                    } else {
                        $this->session->set_flashdata('error', "No records! Please add one or more records.");
                    }
                }
            }

        if($this->session->userdata['user_info']['roll_id'] == 1){
            $this->template->load('admin_header', 'admin/bulklead/index', $data);
        }elseif ($this->session->userdata['user_info']['roll_id'] == 2) {
            $this->template->load('agent_header', 'admin/bulklead/index', $data);
        }elseif ($this->session->userdata['user_info']['roll_id'] == 5) {
            $this->template->load('agency_header', 'admin/bulklead/index', $data);
        }
    }


    public function verification_script(){
      $data['title'] = 'Verification Script || Admin';
      $this->template->load('admin_header', 'admin/verification_script/index', $data);
    }

    public function add_verification_script(){
      $data['title'] = 'Add Verification Script || Admin';
      $data['state'] = get_data($tbl_name = 'crm_states', $single = 0);
      $data['is_all'] = get_data($tbl_name = 'crm_state_verification_script', $single = 1, $where = array('script_status' => 'all','is_active' => 'YES'));

      if($this->input->post()){
          $this->form_validation->set_rules('area', 'Script', 'required');
          if ($this->form_validation->run() == FALSE) {
              $this->form_validation->set_error_delimiters();
          } else {
              $script_name = $this->input->post('script_name');
              $html = $this->input->post('area');
              $s_type= $this->input->post('state_type');
              if($s_type = "singal_state"){
                  if(sizeof($this->input->post('script_state') > 0)){
                    $state = $this->input->post('script_state');
                  }
              }
              if(sizeof($state) > 0){
                  foreach ($state as $value) {
                    $ins_array = array('script_html' => $html,'script_status' => 'singal','state_code' =>$value, 'script_name' => $script_name);
                    $setting = insert_update_data($ins = 1, $table_name = 'crm_state_verification_script', $ins_data = $ins_array);
                  }
              }else{
                $ins_array = array('script_html' => $html,'script_status' => 'all', 'script_name' => $script_name);
                $setting = insert_update_data($ins = 1, $table_name = 'crm_state_verification_script', $ins_data = $ins_array);
              }

              if ($setting) {
                  $this->session->set_flashdata('success', 'Verification Script is successfully Inserted!');
                  redirect(base_url() . 'admin/settings/verification_script');
              }
        }
      }
      $this->template->load('admin_header', 'admin/verification_script/add_script', $data);
    }

    /**
     * @uses to build JSon for Data-table
     * @author MGA
     */
    function VerificationJson() {
        $aColumns = array("verification_script_id", "script_name", "state_code", "script_status", "created_date");

        /* Pagination */

        $sLimit = array();

        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $sLimit = array("start" => $_GET['iDisplayLength'], "end" => $_GET['iDisplayStart']);
        }

        /* Search */

        $sWhere = "";
        if ($_GET['sSearch'] != "") {
            $sColumns = array("script_name","state_code", "script_status", "created_date");
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
                    $sOrder = array("field" => $aColumns[intval($_GET['iSortCol_' . $i])],
                        "order" => $_GET['sSortDir_' . $i]);
                }
            }
        }
        $this->load->model('verification_script');
        $rResult = $this->verification_script->get_verification_script($sLimit, $sWhere, $sOrder);
        $iTotal_f = count($rResult);
        $iTotal = $this->verification_script->get_verification_script_count($sWhere);
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
                    if ($aColumns[$i] == 'verification_script_id') {
                        $row[] = "<div class='checkbox checkbox-primary checkbox-single m-r-15'>
                                <input id='act_checkbox_" . $aRow['verification_script_id'] . "' type='checkbox' value=" . urlencode(base64_encode($aRow["verification_script_id"])) . " name='act_checkbox[]' class='ch_checkbox'>
                                <label for='act-checkbox'></label>
                            </div>";
                    } elseif ($aColumns[$i] == 'script_status') {
                        if ($aRow[$aColumns[$i]] == "all") {
                            $row[] = 'All State';
                        } else {
                            $row[] = 'Singal State';
                        }
                    } elseif ($aColumns[$i] == 'state_code') {
                      if ($aRow[$aColumns[$i]] == "") {
                          $row[] = 'All State';
                      } else {
                          $row[] = get_state_name($aRow[$aColumns[$i]]);
                      }
                    }
                    else {
                        $row[] = isset($aRow[$aColumns[$i]]) ? $aRow[$aColumns[$i]] : '';
                    }
                }

                $row[] .='<a href="' . base_url() . 'admin/settings/edit_verification_script/' . urlencode(base64_encode($aRow["verification_script_id"])) . '" " class="btn btn-default btn-xs table-action-btn admin-action-icon-in-data-table"><i class="fa fa-pencil" title="Edit Verification Script"></i></a>'
                        . '<span class="danger-alert btn btn-danger btn-xs table-action-btn del_script admin-action-icon-in-data-table remove-span" data-custom-value="' . $aRow["verification_script_id"] . '"><i class="glyphicon glyphicon-remove" title="Remove Verification Script"></i></span>';
                $output['aaData'][] = $row;
            }
        }
        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }



    /**
     * @uses remove_verification is used for remove or delete script
     * @author MGA
     */
    public function remove_verification() {
        $script_id = $this->input->post('script_id1');
        $data = array('is_active' => 'NO');
        $done = insert_update_data($ins = 0, $table_name = 'crm_state_verification_script', $ins_data = $data, $where = array('verification_script_id' => $script_id));
        echo "Verification script Successfully Delete";
        die();
    }

    /**
     * @uses agency_setup is used for set agency payment info
     * @author MGA
     */
    public function agency_setup() {
        $data['title'] = "Agency Setup || Admin";
        $setup_data = get_data($tbl_name = 'crm_agency_setup', $single = 1, $where = array('setup_id' => '1'));
        if(isset($setup_data)){
            $data['data'] = $setup_data;
        }

        if($this->input->post('Save')){
            $this->form_validation->set_rules('reg_fee', 'Registration Fee', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->form_validation->set_error_delimiters();
            } else {


                $regfee = $this->input->post('reg_fee');
                $enb_test = $this->input->post('test_mode');
                $live_secret = $this->input->post('live_secret');
                $live_publishable = $this->input->post('live_publishable');
                $live_client = $this->input->post('live_client');
                $test_secret = $this->input->post('test_secret');
                $test_publishable = $this->input->post('test_publishable');
                $test_client = $this->input->post('test_client');


               if(isset($enb_test)){
                   $data_setting =  array(
                       'registration_fee' => $regfee,
                       'enable_test' => 'YES',
                       'live_secret_key' => $live_secret,
                       'live_publishable_key' => $live_publishable,
                       'live_client_id' => $live_client,
                       'test_secret_key' => $test_secret,
                       'test_publishable_key' => $test_publishable,
                       'test_client_id' => $test_client,
                   );
               }else{
                    $data_setting =  array(
                       'registration_fee' => $regfee,
                       'enable_test' => 'NO',
                       'live_secret_key' => $live_secret,
                       'live_publishable_key' => $live_publishable,
                       'live_client_id' => $live_client,
                       'test_secret_key' => $test_secret,
                       'test_publishable_key' => $test_publishable,
                       'test_client_id' => $test_client,
                   );
               }

                if(isset($setup_data)){
                    $con_array = array('setup_id' => '1');
                    $setting = insert_update_data($ins = 0, $table_name = 'crm_agency_setup', $ins_data = $data_setting, $con_array);
                    $this->session->set_flashdata('success', 'Agency Setup is successfully Updated!');
                }else{
                    $setting = insert_update_data($ins = 1, $table_name = 'crm_agency_setup', $ins_data = $data_setting);
                    $this->session->set_flashdata('success', 'Agency Setup is successfully Inserted!');
                }
                if($setting){
                    redirect(base_url() . 'admin/settings/agency_setup');
                }
            }
        }

      $this->template->load('admin_header', 'admin/agency_setup/index', $data);
    }

    public function product_verification_script() {
        $data['title'] = 'Product Verification Script || Admin';
        $this->template->load('admin_header', 'admin/verification_script/product_script', $data);
    }

    public function Bluk_Member_Upload(){
        $data['title'] = "Bulk Member Upload || Admin";
        if($this->input->post("Upload"))
            {
                $this->load->library('upload');
                $config['upload_path'] = FCPATH.'assets/upload_member_excel/';
                $config['allowed_types'] = 'csv|xls|XLSX';
                $config['max_size'] = '1000000';
                $this->upload->initialize($config);
                if ( ! $this->upload->do_upload('file'))
                {
                    $error = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                } else {
                $filename = $this->upload->file_name;
                $csv_array = $this->csvimport->get_array( "assets/upload_member_excel/" . $filename);
                if ($csv_array) {

                    //$data['total_records'] = count($csv_array);
                    $data['total_inserted'] = 0;
                    $data['total_records'] =  0;

                        foreach($csv_array as $value){
                            if($value['first_name'] != "" && $value['middle_name'] != ""
                            && $value['last_name'] != "" && $value['email'] != ""
                            && $value['phone_number'] != "" && $value['DOB'] != ""
                            && $value['address'] != "" && $value['sub_address'] != ""
                            && $value['state'] != "" && $value['city'] != ""
                            && $value['zip_code'] != "" && $value['social_security_number'] != ""){
                                $data['total_records'] = $data['total_records'] + 1;
                            }
                        }

                        if(isset($csv_array[0]['first_name']) && isset($csv_array[0]['middle_name'])
                        && isset($csv_array[0]['last_name']) && isset($csv_array[0]['email'])
                        && isset($csv_array[0]['phone_number']) && isset($csv_array[0]['DOB'])
                        && isset($csv_array[0]['address']) && isset($csv_array[0]['sub_address'])
                        && isset($csv_array[0]['state']) && isset($csv_array[0]['city'])
                        && isset($csv_array[0]['zip_code']) && isset($csv_array[0]['social_security_number'])
                        && isset($csv_array[0]['customer_weight']) && isset($csv_array[0]['spouse_first_name'])
                        && isset($csv_array[0]['spouse_middle_name']) && isset($csv_array[0]['spouse_last_name'])
                        && isset($csv_array[0]['spouse_email_address']) && isset($csv_array[0]['spouse_phone_number'])
                        && isset($csv_array[0]['spouse_dob']) && isset($csv_array[0]['spouse_address'])
                        && isset($csv_array[0]['spouse_sub_address']) && isset($csv_array[0]['spouse_state'])
                        && isset($csv_array[0]['spouse_city']) && isset($csv_array[0]['spouse_zipcode'])
                        && isset($csv_array[0]['spouse_social_security_number']) && isset($csv_array[0]['child_first_name'])
                        && isset($csv_array[0]['child_middle_name']) && isset($csv_array[0]['child_last_name'])
                        && isset($csv_array[0]['child_email']) && isset($csv_array[0]['child_phone_number'])
                        && isset($csv_array[0]['child_dob']) && isset($csv_array[0]['child_address'])
                        && isset($csv_array[0]['child_address_details']) && isset($csv_array[0]['child_state'])
                        && isset($csv_array[0]['child_city']) && isset($csv_array[0]['child_zipcode'])
                        && isset($csv_array[0]['child_social_security_number'])
                        ){
                            foreach ($csv_array as $key => $importdata) {
                                $email_arr = array();
                                $array = array();
                                $array = $importdata;
                                $member_password = '123456';

                                        if($importdata['first_name'] != "" || $importdata['middle_name'] != "" || $importdata['last_name'] != "" || $importdata['email'] != "" || $importdata['phone_number'] != "" || $importdata['DOB'] != "" || $importdata['address'] != "" || $importdata['sub_address'] != "" || $importdata['state'] != "" || $importdata['city'] != "" || $importdata['zip_code'] != "" || $importdata['social_security_number'] != "" || $importdata['customer_weight'] != ""){
                                            $check_validate = $this->check_validations($array);
                                            if (!is_array($check_validate)) {

                                                $email_arr[] = $importdata['email'];

                                                $data['total_inserted']++;
                                                $data_crm_user_tbl = array(
                                                    'email' => $importdata['email'],
                                                    'display_name' => $importdata['first_name'] . ' ' . $importdata['last_name'],
                                                    'password' => md5($member_password),
                                                    'roll_id' => '4');

                                                $crm_user_tbl = $this->db->insert('crm_user_tbl', $data_crm_user_tbl);
                                                $userid = $this->db->insert_id();

                                                $email_arr[] = $importdata['email'];

                                                $data_crm_lead_member_master = array(
                                                    'user_id' => $userid,
                                                    'customer_status' => 'memeber',
                                                    'broker_id' => $this->session->userdata['user_info']['user_id']);

                                                $crm_lead_member_master_insert = $this->db->insert('crm_lead_member_master', $data_crm_lead_member_master);
                                                $customer_id = $this->db->insert_id();

                                                $data_crm_lead_member_primary = array(
                                                    'customer_first_name' => $importdata['first_name'],
                                                    'customer_id' => $customer_id,
                                                    'customer_middle_name' => $importdata['middle_name'],
                                                    'customer_last_name' => $importdata['last_name'],
                                                    'customer_email' => $importdata['email'],
                                                    'customer_phone_number' => $importdata['phone_number'],
                                                    'customer_dob' => date('Y-m-d', strtotime($importdata['DOB'])),
                                                    'customer_address' => $importdata['address'],
                                                    'customer_address_details' => $importdata['sub_address'],
                                                    'customer_state' => $importdata['state'],
                                                    'customer_city' => $importdata['city'],
                                                    'customer_zipcode' => $importdata['zip_code'],
                                                    'customer_social_security_number' => $importdata['social_security_number'],
                                                    'customer_weight' => $importdata['customer_weight'],
                                                );
                                                $crm_lead_member_primary_insert = $this->db->insert('crm_lead_member_primary', $data_crm_lead_member_primary);
                                                $this->session->set_flashdata('success', "Total inserted ".$data['total_inserted']." of ".$data['total_records']);
                                        } else {
                                            $importdata['error'] = $check_validate;
                                            $data['errors_of_sheet']['result'][] = $importdata;
                                            $this->session->set_flashdata('error', "Total inserted ".$data['total_inserted']." of ".$data['total_records']);
                                        }
                                    }

                                    if($importdata['spouse_first_name'] != "" || $importdata['spouse_middle_name'] != "" || $importdata['spouse_last_name'] != "" || $importdata['spouse_email_address'] != "" || $importdata['spouse_phone_number'] != "" || $importdata['spouse_dob'] != "" || $importdata['spouse_address'] != "" || $importdata['spouse_sub_address'] != "" || $importdata['spouse_state'] != "" || $importdata['spouse_city'] != "" || $importdata['spouse_zipcode'] != "" || $importdata['spouse_social_security_number'] != ""){
                                        if(isset($customer_id)){
                                            $data_crm_lead_member_spouse = array(
                                                'customer_id' => $customer_id,
                                                'customer_spouse_first_name' => $importdata['spouse_first_name'],
                                                'customer_spouse_middle_name' => $importdata['spouse_middle_name'],
                                                'customer_spouse_last_name' => $importdata['spouse_last_name'],
                                                'customer_spouse_email' => $importdata['spouse_email_address'],
                                                'customer_spouse_phone_number' => $importdata['spouse_phone_number'],
                                                'customer_spouse_dob' => date('Y-m-d', strtotime($importdata['spouse_dob'])),
                                                'customer_spouse_address' => $importdata['spouse_address'],
                                                'customer_spouse_address_details' => $importdata['spouse_sub_address'],
                                                'customer_spouse_state' => $importdata['spouse_state'],
                                                'customer_spouse_city' => $importdata['spouse_city'],
                                                'customer_spouse_zipcode' => $importdata['spouse_zipcode'],
                                                'customer_spouse_social_security_number' => $importdata['spouse_social_security_number'],
                                            );
                                            $crm_lead_member_spouse_insert = $this->db->insert('crm_lead_member_spouse', $data_crm_lead_member_spouse);
                                        }
                                    }
                                    if(isset($customer_id)){
                                        if($importdata['child_first_name'] != "" || $importdata['child_middle_name'] != "" || $importdata['child_last_name'] != "" || $importdata['child_email'] != "" || $importdata['child_phone_number'] != "" || $importdata['child_dob'] != "" || $importdata['child_address'] != "" || $importdata['child_address_details'] != "" || $importdata['child_state'] != "" || $importdata['child_city'] != "" || $importdata['child_zipcode'] != "" || $importdata['child_social_security_number'] != ""){
                                            if($importdata['first_name'] != "" && $importdata['child_first_name'] != "" || $importdata['child_middle_name'] != "" || $importdata['child_last_name'] != "" || $importdata['child_email'] != "" || $importdata['child_phone_number'] != "" || $importdata['child_dob'] != "" || $importdata['child_address'] != "" || $importdata['child_address_details'] != "" || $importdata['child_state'] != "" || $importdata['child_city'] != "" || $importdata['child_zipcode'] != "" || $importdata['child_social_security_number'] != ""){

                                                $data_crm_lead_member_child = array(
                                                  'customer_id' => $customer_id,
                                                  'customer_child_first_name' => $importdata['child_first_name'],
                                                  'customer_child_middle_name' =>$importdata['child_middle_name'],
                                                  'customer_child_last_name' => $importdata['child_last_name'],
                                                  'customer_child_email' => $importdata['child_email'],
                                                  'customer_child_phone_number' => $importdata['child_phone_number'],
                                                  'customer_child_dob' => date('Y-m-d', strtotime($importdata['child_dob'])),
                                                  'customer_child_address' => $importdata['child_address'],
                                                  'customer_child_address' => $importdata['child_address_details'],
                                                  'customer_child_state' => $importdata['child_state'],
                                                  'customer_child_city' => $importdata['child_city'],
                                                  'customer_child_zipcode' => $importdata['child_zipcode'],
                                                  'customer_child_social_security_number' => $importdata['child_social_security_number'],
                                                );
                                            } else if($importdata['first_name'] == "" && $importdata['child_first_name'] != "" || $importdata['child_middle_name'] != "" || $importdata['child_last_name'] != "" || $importdata['child_email'] != "" || $importdata['child_phone_number'] != "" || $importdata['child_dob'] != "" || $importdata['child_address'] != "" || $importdata['child_address_details'] != "" || $importdata['child_state'] != "" || $importdata['child_city'] != "" || $importdata['child_zipcode'] != "" || $importdata['child_social_security_number'] != ""){
                                                $sql = "SELECT customer_id FROM crm_lead_member_master WHERE customer_id=(SELECT MAX(customer_id) FROM crm_lead_member_master)";
                                                $Query55 = $this->db->query($sql);
                                                $data['id'] = $Query55->row_array();
                                                $id =  $data['id']['customer_id'];

                                                $data_crm_lead_member_child = array(
                                                  'customer_id' => $id,
                                                  'customer_child_first_name' => $importdata['child_first_name'],
                                                  'customer_child_middle_name' =>$importdata['child_middle_name'],
                                                  'customer_child_last_name' => $importdata['child_last_name'],
                                                  'customer_child_email' => $importdata['child_email'],
                                                  'customer_child_phone_number' => $importdata['child_phone_number'],
                                                  'customer_child_dob' => date('Y-m-d', strtotime($importdata['child_dob'])),
                                                  'customer_child_address' => $importdata['child_address'],
                                                  'customer_child_address' => $importdata['child_address_details'],
                                                  'customer_child_state' => $importdata['child_state'],
                                                  'customer_child_city' => $importdata['child_city'],
                                                  'customer_child_zipcode' => $importdata['child_zipcode'],
                                                  'customer_child_social_security_number' => $importdata['child_social_security_number'],
                                                );
                                            }
                                            $insert = $this->db->insert('crm_lead_member_child',$data_crm_lead_member_child);
                                        }
                                    }


                                    /*$log = array('action_by' => $this->session->userdata['user_info']['user_id'], 'customer_id' => $customer_id, 'action' => 'created');
                                    $lead_log = insert_update_data($ins = 1, $table_name = 'crm_lead_log', $ins_data = $log);
                                    $this->session->set_flashdata('success', "Member Data is successfully Upload");*/
                            }

                          if(isset($data['errors_of_sheet']['result'])){
                              $this->session->set_userdata('error_row_data', $data['errors_of_sheet']['result']);
                          }
                          
                          if($email_arr){
                              $this->session->set_userdata('email_array', $email_arr);
                          } else {
                              $this->session->set_userdata('email_array', '');
                          }
                          $this->session->set_userdata('email_array', $email_arr);
                          $data['errors_of_sheet']['result'] = $this->send_notification_email();

                        } else {
                            $this->session->set_flashdata('error', "Invalid file format! Please download file format.");
                        }
                    } else {
                        $this->session->set_flashdata('error', "No records! Please add one or more records.");
                    }
                }
            }

            //$this->template->load('admin_header', 'admin/bulkmember/index', $data);

        if($this->session->userdata['user_info']['roll_id'] == 1){
            $this->template->load('admin_header', 'admin/bulkmember/index', $data);
        }elseif ($this->session->userdata['user_info']['roll_id'] == 2) {
            $this->template->load('agent_header', 'admin/bulkmember/index', $data);
        }elseif ($this->session->userdata['user_info']['roll_id'] == 5) {
            $this->template->load('agency_header', 'admin/bulkmember/index', $data);
        }
    }

    /**
    * @method: check_validations()
    * @uses of method: check validation on uploaded sheet records.
    * @param: array @array array for post record
    * @author: MGA
    **/
    public function check_validations($array)
    {
        $_POST = $array;
        $this->form_validation->set_rules('email', 'email id', 'trim|required|valid_email|callback_isEmailExist');

        if ($this->form_validation->run() !== FALSE) {
                return TRUE;
        } else {
        //--- get last error
        $error = $this->form_validation->error_array();
        $error = array_slice($error, 0, 1);
        //--- restore posted form
        $this->form_validation = new CI_Form_validation();
        return array('error' => current($error));
        }
    }

    /**
    * @method: isEmailExist()
    * @uses of method: Check email address is already exist in DB.
    * @param: Email @email email address of  user.
    * @author: MGA
    */
    public function isEmailExist($Email)
    {
        $con = array('email' => $Email, 'is_deleted' => 'N');
        $this->db->select('user_id');
        $this->db->where($con);
        $query = $this->db->get('crm_user_tbl');

        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('isEmailExist', 'Email address is already exist.');
            return false;
        } else {
            return true;
        }
    }

    public function send_notification_email() {
        $email_data = $this->session->userdata('email_array');
        if($this->session->userdata('error_row_data')){
            $data = $this->session->userdata('error_row_data');
        } else {
            $data = '';
        }
     
        
        if(isset($email_data) && $email_data != ''){
            foreach($email_data as $email_adress){
                    $msg = "Hello <br><br>
                                You are successfully registered in amenitybenefits.<br><br>
                                Your Login details:<br><br>
                                <strong> Email Address : </strong>" . $email_adress . "<br>
                                <strong> Password : </strong> 123456 <br><br>
                                Click Below URL for Login <br><br>
                                http://agencyvue.com/login  <br><br>
                                Thank You,<br><br>
                                Amenitybenefits";

                    $subject = "Registered in amenitybenefits";
                    $to_email = $email_adress;
                    $title = 'Amenitybenefits registration';
                    send_email($to_email, $subject, $msg, $title);
            }
            $this->session->unset_userdata('email_array');
            //redirect(base_url() . 'admin/settings/Bluk_Member_Upload');
            return $data;
        } else {
            return $data;
        }


    }

}
