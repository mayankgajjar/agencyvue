<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Agency Profile
 *
 * @author dhareen
 */
class Profile extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('agency');
    }

    /**
     * @uses AS Index function PROFILE OF ANGECY
     */
    public function index() {
        $data['title'] = "Agency Profile And Setting";
        $data['details'] = $this->agency->get_agency_profile($this->session->userdata['user_info'] ['user_id']);
        $data['state'] = get_all_state();

        $this->db->where('state_code', $data['details'][0]['agency_state']);
        $que = $this->db->get('crm_cities');
        $data['city_list'] = $que->result_array();
        $this->db->where('state_code', $data['details'][0]['bank_state']);
        $que1 = $this->db->get('crm_cities');
        $data['city_list_bank'] = $que1->result_array();
        if ($this->input->post()) {
            $this->form_validation->set_rules('agency_name', 'Agency Name', 'required');
            $this->form_validation->set_rules('contact_email', 'Contact Email', 'required|valid_email');
            $this->form_validation->set_rules('customer_service_number', 'Customer Service Number', 'required');
            $this->form_validation->set_rules('phone_number', 'Phone Number', 'required');
            $this->form_validation->set_rules('address', 'Address', 'required');
            $this->form_validation->set_rules('sel_state', 'State', 'required');
            $this->form_validation->set_rules('sel_city', 'City', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->form_validation->set_error_delimiters();
            } else {
                if (!empty($_FILES['agency_logo']['name'])) {
                    $imagename = 'log' . time() . $_FILES['agency_logo']['name'];
                    $config['upload_path'] = 'assets/crm_image/agencieslogo/';
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['file_name'] = $imagename;
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('agency_logo')) {
                        $error = array('error' => $this->upload->display_errors());
                    } else {
                        if (isset($data['details']['agency_image'])) {
                            $img_path = $_SERVER['DOCUMENT_ROOT'] . '/assets/crm_image/agencieslogo/' . $data['details']['agency_image'];
                            unlink($img_path);
                        }
                        $this->session->unset_userdata['agency_profile_img'];
                        $data = $this->upload->data();
                        $logo = $data['file_name'];
                        $this->session->set_userdata('agency_profile_img', $logo);
                    }
                } else {
                    $logo = $data['details']['agency_image'];
                }
                $user_id = $this->session->userdata['user_info']['user_id'];
                $agencyBasic = array(
                    'agency_name' => $this->input->post('agency_name'),
                    'contact_name' => $this->input->post('contact_name'),
                    'agency_email' => $this->input->post('contact_email'),
                    'agency_phone' => $this->input->post('phone_number'),
                    'agency_address' => $this->input->post('address'),
                    'agency_sub_address' => $this->input->post('address_addtional'),
                    'agency_state' => $this->input->post('sel_state'),
                    'agency_city' => $this->input->post('sel_city'),
                    'agency_zip_code' => $this->input->post('zipcode'),
                    'agency_customer_service_number' => $this->input->post('customer_service_number'),
                    'agency_customer_service_email' => $this->input->post('contact_email'),
                    'agency_image' => $logo
                );
                $agencyTbl = insert_update_data($ins = 0, $table_name = 'crm_agencies_basic', $ins_data = $agencyBasic, array('user_id' => $user_id));
                $agencyBank = array(
                    'bank_name' => $this->input->post('angecy_bank_name'),
                    'bank_add' => $this->input->post('angecy_bank_add'),
                    'bank_city' => $this->input->post('bank_city'),
                    'bank_state' => $this->input->post('bank_state'),
                    'bank_zipcode' => $this->input->post('bank_zipcode'),
                    'agency_name_on_account' => $this->input->post('name_on_account'),
                    'agency_account_number' => $this->input->post('account_number'),
                    'angecy_routing_number' => $this->input->post('routing_number'),
                );
                $agencybankTble = insert_update_data($ins = 0, $table_name = 'crm_agencies_bank_details', $ins_data = $agencyBank, array('agency_id' => $user_id));
                if ($agencyTbl && $agencybankTble) {
                    $msg = "Your Profile Is Successfully Updated";
                    $this->session->set_flashdata('success', $msg);
                    redirect('agency/profile');
                }
            }
        }
        $this->template->load('agency_header', 'agency/profile/index', $data);
    }

}
