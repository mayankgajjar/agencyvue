<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Vendors extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('vendor');
    }

    function index() {
        $data['title'] = 'Vendor || Admin';
        $this->template->load('admin_header', 'admin/vendors/index', $data);
    }
    
     public function add_vendor() {
        $data['title'] = 'Add vendor';
        $data['state'] = get_data($tbl_name = 'crm_states', $single = 0);

        if($this->input->post('save')){

            $date_arr = $this->input->post('invoice_due_date');
            $main_array_date = (explode(",",$date_arr));
            foreach ($main_array_date as $key => $value) {
                $array[] = date('Y-m-d', strtotime($value));
            }

           $due_date = implode(",",$array);
          
            
            
            $this->form_validation->set_rules('ven_first_name', 'Vendor Name', 'required');
            $this->form_validation->set_rules('ven_email', 'Email Address', 'required|valid_email');
            $this->form_validation->set_rules('customerservicenumber', 'Customer Service Number', 'required');
            $this->form_validation->set_rules('ven_address', 'Vendor Address', 'required');
            $this->form_validation->set_rules('ven_state', 'Vendor State', 'required');
            $this->form_validation->set_rules('ven_city', 'Vendor City', 'required');
            $this->form_validation->set_rules('ven_zip', 'Vendor Zip Code', 'required');
            if (empty($_FILES['logo']['name']))
            {
                $this->form_validation->set_rules('logo', 'Logo', 'required');
            }
            $this->form_validation->set_rules('daily_contact_name', 'Daily Contact Name', 'required');
            $this->form_validation->set_rules('daily_contact_email', 'Daily Contact Email Address', 'required');
            $this->form_validation->set_rules('daily_contact_no', 'Daily Contact Number', 'required');
            $this->form_validation->set_rules('invoice_due_date', 'Invoice Due Date', 'required');
            $this->form_validation->set_rules('payment_method', 'Payment Method', 'required');
            $this->form_validation->set_rules('name_on_account', 'Name On Account', 'required');
            $this->form_validation->set_rules('bank_name', 'Bank Name', 'required');
            $this->form_validation->set_rules('payment_address', 'Payment Address', 'required');
            $this->form_validation->set_rules('payment_state', 'Payment State', 'required');
            $this->form_validation->set_rules('payment_city', 'Payment City', 'required');
            $this->form_validation->set_rules('payment_zip', 'payment Zip Code', 'required');
            $this->form_validation->set_rules('routing_number', 'routing number', 'required');
            $this->form_validation->set_rules('account_no', 'Account Number', 'required');
            if (empty($_FILES['img']['name']))
            {
                $this->form_validation->set_rules('img', 'Check', 'required');
            }

            if ($this->form_validation->run() == FALSE) {
                $this->form_validation->set_error_delimiters();

            } else {
                
                if (!empty($_FILES['logo']['name'])) {

                    $imagename = 'logo'.time() . $_FILES['img']['name'];

                    $config['upload_path'] = 'assets/crm_image/vendor/';
                    $config['allowed_types'] = 'gif|jpg|png';
                
                    $config['file_name'] = $imagename;
                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('logo')) {
                        $data['error'] = 'Please upload valid logo file';
                        $this->template->load('admin_header', 'admin/vendors/add_vendor', $data);
                        return FALSE;
                        
                    } else {
                        $data = $this->upload->data();
                        $logo = $data['file_name'];
                    }
                } else {
                    $logo = '';
                }

                if (!empty($_FILES['img']['name'])) {

                    $imagename2 = 'check'.time() . $_FILES['img']['name'];

                    $config['upload_path'] = 'assets/crm_image/vendor/';
                    $config['allowed_types'] = 'gif|jpg|png';
                  
                    $config['file_name'] = $imagename2;
                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('img')) {
                        $data['error'] = 'Please upload valid check file';
                        $this->template->load('admin_header', 'admin/vendors/add_vendor', $data);
                        return FALSE;

                    } else {
                        $data2 = $this->upload->data();
                        $check = $data2['file_name'];
                    }
                } else {
                    $check = '';
                }

                $data_crm_vendor_primary =array(
                    'vendor_name' => $this->input->post('ven_first_name'), 
                    'vendor_website' => $this->input->post('ven_website'), 
                    'vendor_email_address' => $this->input->post('ven_email'), 
                    'vendor_customer_service_number' => $this->input->post('customerservicenumber'), 
                    'vendor_fax_number' => $this->input->post('ven_faxnumber'), 
                    'vendor_address' => $this->input->post('ven_address'), 
                    'vendor_sub_address' => $this->input->post('ven_sub_address'), 
                    'vendor_state' => $this->input->post('ven_state'), 
                    'vendor_city' => $this->input->post('ven_city'), 
                    'vendor_zip_code' => $this->input->post('ven_zip'), 
                    'vendor_logo' => $logo, 
                    'daily_contact_name' => $this->input->post('daily_contact_name'), 
                    'daily_contact_email_address' => $this->input->post('daily_contact_email'), 
                    'daily_contact_contact_number' => $this->input->post('daily_contact_no'), 
                    'daily_contact_extension' => $this->input->post('daily_contact_extension'), 
                );

                $primary = insert_update_data($ins = 1, $table_name = 'crm_vendor_primary', $ins_data = $data_crm_vendor_primary);
                $vendor_id = $this->db->insert_id();

                $data_crm_vendor_payment_terms =array(
                    'vendor_id' => $vendor_id, 
                    'payment_Invoice_due_date' => $due_date,
                    'payment_method' => $this->input->post('payment_method'),
                    'payment_name_on_account' => $this->input->post('name_on_account'),
                    'payment_bank_name' => $this->input->post('bank_name'),
                    'payment_address' => $this->input->post('payment_address'),
                    'payment_sub_address' => $this->input->post('payment_sub_address'),
                    'payment_state' => $this->input->post('payment_state'),
                    'payment_city' => $this->input->post('payment_city'),
                    'payment_zip_code' => $this->input->post('payment_zip'),
                    'payment_account' => $this->input->post('payment_account'),
                    'payment_routing_number' => $this->input->post('routing_number'),
                    'payment_account_number' => $this->input->post('account_no'),
                    'payment_check' =>  $check,
                );

                $payment = insert_update_data($ins = 1, $table_name = 'crm_vendor_payment_terms', $ins_data = $data_crm_vendor_payment_terms);

                if($primary && $payment){
                    $this->session->set_flashdata('success', 'Vendor is successfully Inserted!');
                    redirect(base_url() . 'admin/vendors');
                }

            }

        }

        $this->template->load('admin_header', 'admin/vendors/add_vendor', $data);
    }    

    /**
     * @uses to build JSon for Data-table
     * @author HAD
     */
    function indexJson() {

        $aColumns = array("vendor_id", "vendor_name", "vendor_email_address", "state","vendor_city","created_date");

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

        /* Order */

        $sOrder = array();

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

        $rResult = $this->vendor->get_vendors($sLimit, $sWhere, $sOrder);
        $iTotal_f = count($rResult);
        $iTotal = $this->vendor->get_vendors_count($sWhere);
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
                    if ($aColumns[$i] == 'vendor_id') {
                        $row[] = "<div class='checkbox checkbox-primary checkbox-single m-r-15'>
                        <input id='act_checkbox_" . $aRow['vendor_id'] . "' type='checkbox' value=" . urlencode(base64_encode($aRow["vendor_id"])) . " name='act_checkbox[]' class='ch_checkbox'>
                        <label for='act-checkbox'></label>
                    </div>
                    <img src=" . base_url() . "assets/images/users/avatar-5.jpg alt='contact-img' title='contact-img' class='img-circle thumb-sm' />";
                    } else {
                        $row[] = isset($aRow[$aColumns[$i]]) ? $aRow[$aColumns[$i]] : '';
                    }
                }

                $row[] .= '<a class="btn btn-info btn-xs table-action-btn admin-action-icon-in-data-table" href="' . base_url() . 'admin/vendors/view_profile?vendor_id=' . urlencode(base64_encode($aRow["vendor_id"])) . '"title="View Vendor Profile"><i class="fa fa-eye"></i></a>'
                        . '<a class="btn btn-default btn-xs table-action-btn admin-action-icon-in-data-table" href="' . base_url() . 'admin/vendors/edit_vendor/' . urlencode(base64_encode($aRow["vendor_id"])) . '" title = "Edit Vendor Prfile"><i class="fa fa-pencil"></i></a>'
                        . '<span class="danger-alert btn btn-danger btn-xs table-action-btn del_vendor admin-action-icon-in-data-table remove-span" data-custom-value="' . urlencode(base64_encode($aRow["vendor_id"])) . '"><i class="glyphicon glyphicon-remove" title="Remove Member"></i></span>';
                        ;

                $output['aaData'][] = $row;
            }
        }
        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }



    function view_profile() {

        $data['title'] = 'Vendor Profile';

        $vendor_id = base64_decode(urldecode($_REQUEST['vendor_id']));

        $data['vendor_info'] = $this->vendor->get_vendor_profile($vendor_id);

        $this->template->load('admin_header', 'admin/vendors/view_profile', $data);
    }

    /**
     * @uses remove_vendor is used for remove or delete vendor
     * @author MGA
    */
    public function remove_vendor() {

        $cus_id = base64_decode(urldecode($this->input->post('user_id')));
        $con = array('vendor_id' => $cus_id);
        $data = array('is_deleted' => 'Y');
        $done = insert_update_data($ins = 0, $tbl_name = 'crm_vendor_primary', $data = $data, $where = $con);

        if ($done) {
            $msg = "Vendor Successfully Delete";
            echo $msg;
        }

        die();
    }

    public function edit_vendor($id = null){


        $data['title'] = 'Edit Vendor';
        $vid = base64_decode(urldecode($id));
        $data['state'] = get_data($tbl_name = 'crm_states', $single = 0);

        $data['vendor_info'] = $this->vendor->get_vendor_profile($vid);

        $this->db->where('state_code', $data['vendor_info'][0]['vendor_state']);
        $query = $this->db->get('crm_cities');
        $data['vendor_city'] = $query->result_array();

        $this->db->where('state_code', $data['vendor_info'][0]['payment_state']);
        $query2 = $this->db->get('crm_cities');
        $data['payment_city'] = $query2->result_array();

        $due_array =  $data['vendor_info'][0]['payment_Invoice_due_date'];

        $main_array_date = (explode(",",$due_array));
            foreach ($main_array_date as $key => $value) {
                $array[] = date('m/d/Y', strtotime($value));
            }

        $data['due_date'] = implode(",",$array);


        if($this->input->post('save')){

            $date_arr1 = $this->input->post('invoice_due_date');
            $main_array_date1 = (explode(",",$date_arr1));
            foreach ($main_array_date1 as $key => $value) {
                $array1[] = date('Y-m-d', strtotime($value));
            }

           $final_due_date = implode(",",$array1);
          
            $this->form_validation->set_rules('ven_first_name', 'Vendor Name', 'required');
            $this->form_validation->set_rules('ven_email', 'Email Address', 'required|valid_email');
            $this->form_validation->set_rules('customerservicenumber', 'Customer Service Number', 'required');
            $this->form_validation->set_rules('ven_address', 'Vendor Address', 'required');
            $this->form_validation->set_rules('ven_state', 'Vendor State', 'required');
            $this->form_validation->set_rules('ven_city', 'Vendor City', 'required');
            $this->form_validation->set_rules('ven_zip', 'Vendor Zip Code', 'required');
            $this->form_validation->set_rules('daily_contact_name', 'Daily Contact Name', 'required');
            $this->form_validation->set_rules('daily_contact_email', 'Daily Contact Email Address', 'required');
            $this->form_validation->set_rules('daily_contact_no', 'Daily Contact Number', 'required');
            $this->form_validation->set_rules('invoice_due_date', 'Invoice Due Date', 'required');
            $this->form_validation->set_rules('payment_method', 'Payment Method', 'required');
            $this->form_validation->set_rules('name_on_account', 'Name On Account', 'required');
            $this->form_validation->set_rules('bank_name', 'Bank Name', 'required');
            $this->form_validation->set_rules('payment_address', 'Payment Address', 'required');
            $this->form_validation->set_rules('payment_state', 'Payment State', 'required');
            $this->form_validation->set_rules('payment_city', 'Payment City', 'required');
            $this->form_validation->set_rules('payment_zip', 'payment Zip Code', 'required');
            $this->form_validation->set_rules('routing_number', 'routing number', 'required');
            $this->form_validation->set_rules('account_no', 'Account Number', 'required');
          

            if ($this->form_validation->run() == FALSE) {
                $this->form_validation->set_error_delimiters();

            } else {
               
                $condition = array('vendor_id' => $vid);
                
                if (!empty($_FILES['logo']['name'])) {

                    $imagename = 'logo'.time() . $_FILES['img']['name'];

                    $config['upload_path'] = 'assets/crm_image/vendor/';
                    $config['allowed_types'] = 'gif|jpg|png';
                
                    $config['file_name'] = $imagename;
                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('logo')) {

                        $upload_error['error'] = 'Please upload valid logo file';
                        $this->template->load('admin_header', 'admin/vendors/edit_vendor', $upload_error);
                        return FALSE;

                    } else {
                        $img_path =$_SERVER['DOCUMENT_ROOT'].'/crm/assets/crm_image/vendor/'.$data['vendor_info'][0]['vendor_logo'];
                        unlink($img_path); 

                        $logo_img = $this->upload->data();
                        $logo = $logo_img['file_name'];
                    }
                } else {
                    $logo = $data['vendor_info'][0]['vendor_logo'];
                }




                if (!empty($_FILES['img']['name'])) {

                    $imagename2 = 'check'.time() . $_FILES['img']['name'];

                    $config['upload_path'] = 'assets/crm_image/vendor/';
                    $config['allowed_types'] = 'gif|jpg|png';
                  
                    $config['file_name'] = $imagename2;
                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('img')) {

                        $upload_error['error'] = 'Please upload valid check file';
                        $this->template->load('admin_header', 'admin/vendors/edit_vendor', $upload_error);
                        return FALSE;

                    } else {
                        $img_path2 =$_SERVER['DOCUMENT_ROOT'].'/crm/assets/crm_image/vendor/'.$data['vendor_info'][0]['payment_check'];
                        unlink($img_path2); 

                        $check_img = $this->upload->data();
                        $check = $check_img['file_name'];
                    }
                } else {
                   $check = $data['vendor_info'][0]['payment_check'];
                }

                $data_crm_vendor_primary =array(
                    'vendor_name' => $this->input->post('ven_first_name'), 
                    'vendor_website' => $this->input->post('ven_website'), 
                    'vendor_email_address' => $this->input->post('ven_email'), 
                    'vendor_customer_service_number' => $this->input->post('customerservicenumber'), 
                    'vendor_fax_number' => $this->input->post('ven_faxnumber'), 
                    'vendor_address' => $this->input->post('ven_address'), 
                    'vendor_sub_address' => $this->input->post('ven_sub_address'), 
                    'vendor_state' => $this->input->post('ven_state'), 
                    'vendor_city' => $this->input->post('ven_city'), 
                    'vendor_zip_code' => $this->input->post('ven_zip'), 
                    'vendor_logo' => $logo, 
                    'daily_contact_name' => $this->input->post('daily_contact_name'), 
                    'daily_contact_email_address' => $this->input->post('daily_contact_email'), 
                    'daily_contact_contact_number' => $this->input->post('daily_contact_no'), 
                    'daily_contact_extension' => $this->input->post('daily_contact_extension'), 
                );

                $primary = insert_update_data($ins = 0, $table_name = 'crm_vendor_primary', $ins_data = $data_crm_vendor_primary, $where = $condition);

                $data_crm_vendor_payment_terms =array(
                    'payment_Invoice_due_date' => $final_due_date,
                    'payment_method' => $this->input->post('payment_method'),
                    'payment_name_on_account' => $this->input->post('name_on_account'),
                    'payment_bank_name' => $this->input->post('bank_name'),
                    'payment_address' => $this->input->post('payment_address'),
                    'payment_sub_address' => $this->input->post('payment_sub_address'),
                    'payment_state' => $this->input->post('payment_state'),
                    'payment_city' => $this->input->post('payment_city'),
                    'payment_zip_code' => $this->input->post('payment_zip'),
                    'payment_account' => $this->input->post('payment_account'),
                    'payment_routing_number' => $this->input->post('routing_number'),
                    'payment_account_number' => $this->input->post('account_no'),
                    'payment_check' =>  $check,
                );

                $payment = insert_update_data($ins = 0, $table_name = 'crm_vendor_payment_terms', $ins_data = $data_crm_vendor_payment_terms, $where = $condition);

                if($primary && $payment){
                    $this->session->set_flashdata('success', 'Vendor is successfully Update!');
                    redirect(base_url() . 'admin/vendors');
                }
            }
        }


        $this->template->load('admin_header', 'admin/vendors/edit_vendor', $data);
    }

}
