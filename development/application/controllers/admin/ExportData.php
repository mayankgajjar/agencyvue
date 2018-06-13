<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class ExportData extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('export_data');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->dbutil();
    }
    
    public function export_lead(){
        $delimiter = ",";
        $newline = "\r\n";
        $filename = "lead.csv";
        
        if ($this->session->userdata['user_info']['roll_id'] == 1) {
            $query = "SELECT p.customer_id,p.customer_first_name,p.customer_middle_name,p.customer_last_name,p.customer_email ,p.customer_phone_number,p.customer_dob,p.customer_address,p.customer_address_details,p.customer_state,p.customer_city,p.customer_zipcode,p.customer_social_security_number,
                spouse.customer_spouse_first_name,spouse.customer_spouse_middle_name,spouse.customer_spouse_last_name,spouse.customer_spouse_email,spouse.customer_spouse_phone_number,spouse.customer_spouse_dob,spouse.customer_spouse_address,spouse.customer_spouse_address_details,spouse.customer_spouse_state,spouse.customer_spouse_city,spouse.customer_spouse_zipcode,spouse.customer_spouse_social_security_number
                FROM `crm_lead_member_master` as master
                LEFT JOIN `crm_lead_member_primary` as p ON master.customer_id = p.customer_id
                LEFT JOIN `crm_lead_member_spouse` as spouse ON spouse.customer_id = master.customer_id
                WHERE master.is_delete = 'N' AND master.customer_status = 'lead'
                ORDER BY p.customer_id ASC";
        } elseif ($this->session->userdata['user_info']['roll_id'] == 2) {
            $query = "SELECT p.customer_id,p.customer_first_name,p.customer_middle_name,p.customer_last_name,p.customer_email ,p.customer_phone_number,p.customer_dob,p.customer_address,p.customer_address_details,p.customer_state,p.customer_city,p.customer_zipcode,p.customer_social_security_number,
                spouse.customer_spouse_first_name,spouse.customer_spouse_middle_name,spouse.customer_spouse_last_name,spouse.customer_spouse_email,spouse.customer_spouse_phone_number,spouse.customer_spouse_dob,spouse.customer_spouse_address,spouse.customer_spouse_address_details,spouse.customer_spouse_state,spouse.customer_spouse_city,spouse.customer_spouse_zipcode,spouse.customer_spouse_social_security_number
                FROM `crm_lead_member_master` as master
                LEFT JOIN `crm_lead_member_primary` as p ON master.customer_id = p.customer_id
                LEFT JOIN `crm_lead_member_spouse` as spouse ON spouse.customer_id = master.customer_id
                WHERE master.is_delete = 'N' AND master.customer_status = 'lead' AND master.broker_id =".$this->session->userdata['user_info']['user_id']."
                ORDER BY p.customer_id ASC";
        } elseif ($this->session->userdata['user_info']['roll_id'] == 5) {
            $agents = get_agents($this->session->userdata['user_info']['user_id']);
            $leadPerents = $this->session->userdata['user_info']['user_id'] . ',';
            foreach ($agents as $agents) {
                $leadPerents .= $agents['user_id'] . ',';
        } 
            $leadPerents01 = rtrim($leadPerents,',');
            
            $query = "SELECT p.customer_id,p.customer_first_name,p.customer_middle_name,p.customer_last_name,p.customer_email ,p.customer_phone_number,p.customer_dob,p.customer_address,p.customer_address_details,p.customer_state,p.customer_city,p.customer_zipcode,p.customer_social_security_number,
                spouse.customer_spouse_first_name,spouse.customer_spouse_middle_name,spouse.customer_spouse_last_name,spouse.customer_spouse_email,spouse.customer_spouse_phone_number,spouse.customer_spouse_dob,spouse.customer_spouse_address,spouse.customer_spouse_address_details,spouse.customer_spouse_state,spouse.customer_spouse_city,spouse.customer_spouse_zipcode,spouse.customer_spouse_social_security_number
                FROM `crm_lead_member_master` as master
                LEFT JOIN `crm_lead_member_primary` as p ON master.customer_id = p.customer_id
                LEFT JOIN `crm_lead_member_spouse` as spouse ON spouse.customer_id = master.customer_id
                WHERE `master`.`is_delete` = 'N' AND `master`.`customer_status` = 'lead' AND `master`.`broker_id` IN(".$leadPerents01.") 
                ORDER BY p.customer_id ASC";
        }
        $result = $this->db->query($query);
        $lead_data = $result->result_array();
        
        foreach ($lead_data as $key => $ld){
            $this->db->where('customer_id',$ld['customer_id']);
            $chi_query = $this->db->get('crm_lead_member_child');
            $ch_data = $chi_query->result_array();
            $lead_data[$key]['child'] = $ch_data; 
         }
           
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=Lead_'.date('Y-m-d-H:i:s').'.csv');
        $handle = fopen('php://output', 'w');
        fputcsv($handle, array('First_Name', 'Middle_Name','Last_Name','Email', 'Phone_Number',
            'Date_Of_Birth', 'Address', 'Address_Detail','State','City', 'Zipcode','Social_Security_Number', 
            'Spouse_First_Name', 'Spouse_Middle_Name','Spouse_Last_Name','Spouse_Email', 'Spouse_Phone_Number',
            'Spouse_Date_Of_Birth', 'Spouse_Address','Spouse_Address_Details','Spouse_State', 'Spouse_City','Spouse_Zipcode', 'Spouse_Social_Security_Number','Child_First_Name',
            'Child_Middle_Name', 'Child_Last_Name','Child_Email', 'Child_Phone_Number','Child_Date_Of_Birth', 'Child_Address',
            'Child_Address_Detail', 'Child_State','Child_City', 'Child_Zipcode','Child_Social_Security_Number'));

        foreach($lead_data as $row)
        {   
            if(empty($row['child'])){
                fputcsv($handle, array(
                     $row['customer_first_name'],$row['customer_middle_name'],$row['customer_last_name'],$row['customer_email'], $row['customer_phone_number'],
                     $row['customer_dob'], $row['customer_address'], $row['customer_address_details'],$row['customer_state'],$row['customer_city'], $row['customer_zipcode'],$row['customer_social_security_number'], 
                     $row['customer_spouse_first_name'], $row['customer_spouse_middle_name'],$row['customer_spouse_last_name'],$row['customer_spouse_email'],$row['customer_spouse_phone_number'],
                     $row['customer_spouse_dob'], $row['customer_spouse_address'],$row['customer_spouse_address_details'],$row['customer_spouse_state'], $row['customer_spouse_city'],$row['customer_spouse_zipcode'], 
                     $row['customer_spouse_social_security_number'],
                ));       
            }else {
                foreach($row['child'] as $key => $child){
                    if($key == 0){
                          fputcsv($handle, array(
                             $row['customer_first_name'],$row['customer_middle_name'],$row['customer_last_name'],$row['customer_email'], $row['customer_phone_number'],
                             $row['customer_dob'], $row['customer_address'], $row['customer_address_details'],$row['customer_state'],$row['customer_city'], $row['customer_zipcode'],$row['customer_social_security_number'], 
                             $row['customer_spouse_first_name'], $row['customer_spouse_middle_name'],$row['customer_spouse_last_name'],$row['customer_spouse_email'],$row['customer_spouse_phone_number'],
                             $row['customer_spouse_dob'], $row['customer_spouse_address'],$row['customer_spouse_address_details'],$row['customer_spouse_state'], $row['customer_spouse_city'],$row['customer_spouse_zipcode'], 
                             $row['customer_spouse_social_security_number'],
                             $child['customer_child_first_name'],
                             $child['customer_child_middle_name'], $child['customer_child_last_name'],$child['customer_child_email'], $child['customer_child_phone_number'],$child['customer_child_dob'], $child['customer_child_address'],
                             $child['customer_child_address_details'], $child['customer_child_state'],$child['customer_child_city'], $child['customer_child_zipcode'],$child['customer_child_social_security_number']
                         ));       
                     } else{
                         fputcsv($handle, array(
                             '','','','','','', '','','','','','','','','','','','','','','','','','',
                             $child['customer_child_first_name'],
                             $child['customer_child_middle_name'], $child['customer_child_last_name'],$child['customer_child_email'], $child['customer_child_phone_number'],$child['customer_child_dob'], $child['customer_child_address'],
                             $child['customer_child_address_details'], $child['customer_child_state'],$child['customer_child_city'], $child['customer_child_zipcode'],$child['customer_child_social_security_number']
                         ));       
                    }
                }
            }

        }
        
        fputcsv($handle, array());
        fclose($handle);
        $headers = array('Content-Type' => 'text/csv');
        
    }
    
    public function export_member(){
        $delimiter = ",";
        $newline = "\r\n";
        $filename = "member.csv";
            if ($this->session->userdata['user_info']['roll_id'] == 1) {
                $query = "SELECT p.customer_id,p.customer_first_name,p.customer_middle_name,p.customer_last_name,p.customer_email ,p.customer_phone_number,p.customer_dob,p.customer_address,p.customer_address_details,p.customer_state,p.customer_city,p.customer_zipcode,p.customer_social_security_number,
                    spouse.customer_spouse_first_name,spouse.customer_spouse_middle_name,spouse.customer_spouse_last_name,spouse.customer_spouse_email,spouse.customer_spouse_phone_number,spouse.customer_spouse_dob,spouse.customer_spouse_address,spouse.customer_spouse_address_details,spouse.customer_spouse_state,spouse.customer_spouse_city,spouse.customer_spouse_zipcode,spouse.customer_spouse_social_security_number
                    FROM `crm_lead_member_master` as master
                    LEFT JOIN `crm_lead_member_primary` as p ON master.customer_id = p.customer_id
                    LEFT JOIN `crm_lead_member_spouse` as spouse ON spouse.customer_id = master.customer_id
                    WHERE master.is_delete = 'N' AND master.customer_status = 'memeber' AND master.user_id != '0' AND p.customer_first_name != ''
                    ORDER BY p.customer_id ASC";
            } elseif ($this->session->userdata['user_info']['roll_id'] == 2) {
                $query = "SELECT p.customer_id,p.customer_first_name,p.customer_middle_name,p.customer_last_name,p.customer_email ,p.customer_phone_number,p.customer_dob,p.customer_address,p.customer_address_details,p.customer_state,p.customer_city,p.customer_zipcode,p.customer_social_security_number,
                    spouse.customer_spouse_first_name,spouse.customer_spouse_middle_name,spouse.customer_spouse_last_name,spouse.customer_spouse_email,spouse.customer_spouse_phone_number,spouse.customer_spouse_dob,spouse.customer_spouse_address,spouse.customer_spouse_address_details,spouse.customer_spouse_state,spouse.customer_spouse_city,spouse.customer_spouse_zipcode,spouse.customer_spouse_social_security_number
                    FROM `crm_lead_member_master` as master
                    LEFT JOIN `crm_lead_member_primary` as p ON master.customer_id = p.customer_id
                    LEFT JOIN `crm_lead_member_spouse` as spouse ON spouse.customer_id = master.customer_id
                    WHERE `master`.`broker_id` = ".$this->session->userdata['user_info']['user_id']." AND `master`.`is_delete` = 'N' AND `master`.`customer_status` = 'memeber' AND p.customer_first_name != ''
                    ORDER BY p.customer_id ASC";
            } elseif ($this->session->userdata['user_info']['roll_id'] == 5) {

                $agents = get_agents($this->session->userdata['user_info']['user_id']);
                $leadPerents = $this->session->userdata['user_info']['user_id'] . ',';
                foreach ($agents as $agents) {
                    $leadPerents .= $agents['user_id'] . ',';
                }
                $leadPerents01 = rtrim($leadPerents, ',');

                $query = "SELECT p.customer_id,p.customer_first_name,p.customer_middle_name,p.customer_last_name,p.customer_email ,p.customer_phone_number,p.customer_dob,p.customer_address,p.customer_address_details,p.customer_state,p.customer_city,p.customer_zipcode,p.customer_social_security_number,
                        spouse.customer_spouse_first_name,spouse.customer_spouse_middle_name,spouse.customer_spouse_last_name,spouse.customer_spouse_email,spouse.customer_spouse_phone_number,spouse.customer_spouse_dob,spouse.customer_spouse_address,spouse.customer_spouse_address_details,spouse.customer_spouse_state,spouse.customer_spouse_city,spouse.customer_spouse_zipcode,spouse.customer_spouse_social_security_number
                        FROM `crm_lead_member_master` as master
                        LEFT JOIN `crm_lead_member_primary` as p ON master.customer_id = p.customer_id
                        LEFT JOIN `crm_lead_member_spouse` as spouse ON spouse.customer_id = master.customer_id
                        WHERE `master`.`is_delete` = 'N' AND `master`.`customer_status` = 'memeber' AND `master`.`broker_id` IN(" . $leadPerents01 . ") 
                        ORDER BY `customer_created_date` ";
            }


        $result = $this->db->query($query);
        $lead_data = $result->result_array();
        
        foreach ($lead_data as $key => $ld){
            $this->db->where('customer_id',$ld['customer_id']);
            $chi_query = $this->db->get('crm_lead_member_child');
            $ch_data = $chi_query->result_array();
            $lead_data[$key]['child'] = $ch_data; 
         }
           
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=Member_'.date('Y-m-d-H:i:s').'.csv');
        $handle = fopen('php://output', 'w');
        fputcsv($handle, array('First_Name', 'Middle_Name','Last_Name','Email', 'Phone_Number',
            'Date_Of_Birth', 'Address', 'Address_Detail','State','City', 'Zipcode','Social_Security_Number', 
            'Spouse_First_Name', 'Spouse_Middle_Name','Spouse_Last_Name','Spouse_Email', 'Spouse_Phone_Number',
            'Spouse_Date_Of_Birth', 'Spouse_Address','Spouse_Address_Details','Spouse_State', 'Spouse_City','Spouse_Zipcode', 'Spouse_Social_Security_Number','Child_First_Name',
            'Child_Middle_Name', 'Child_Last_Name','Child_Email', 'Child_Phone_Number','Child_Date_Of_Birth', 'Child_Address',
            'Child_Address_Detail', 'Child_State','Child_City', 'Child_Zipcode','Child_Social_Security_Number'));

        foreach($lead_data as $row)
        {   
            if(empty($row['child'])){
                fputcsv($handle, array(
                     $row['customer_first_name'],$row['customer_middle_name'],$row['customer_last_name'],$row['customer_email'], $row['customer_phone_number'],
                     $row['customer_dob'], $row['customer_address'], $row['customer_address_details'],$row['customer_state'],$row['customer_city'], $row['customer_zipcode'],$row['customer_social_security_number'], 
                     $row['customer_spouse_first_name'], $row['customer_spouse_middle_name'],$row['customer_spouse_last_name'],$row['customer_spouse_email'],$row['customer_spouse_phone_number'],
                     $row['customer_spouse_dob'], $row['customer_spouse_address'],$row['customer_spouse_address_details'],$row['customer_spouse_state'], $row['customer_spouse_city'],$row['customer_spouse_zipcode'], 
                     $row['customer_spouse_social_security_number'],
                ));       
            }else {
                foreach($row['child'] as $key => $child){
                    if($key == 0){
                          fputcsv($handle, array(
                             $row['customer_first_name'],$row['customer_middle_name'],$row['customer_last_name'],$row['customer_email'], $row['customer_phone_number'],
                             $row['customer_dob'], $row['customer_address'], $row['customer_address_details'],$row['customer_state'],$row['customer_city'], $row['customer_zipcode'],$row['customer_social_security_number'], 
                             $row['customer_spouse_first_name'], $row['customer_spouse_middle_name'],$row['customer_spouse_last_name'],$row['customer_spouse_email'],$row['customer_spouse_phone_number'],
                             $row['customer_spouse_dob'], $row['customer_spouse_address'],$row['customer_spouse_address_details'],$row['customer_spouse_state'], $row['customer_spouse_city'],$row['customer_spouse_zipcode'], 
                             $row['customer_spouse_social_security_number'],
                             $child['customer_child_first_name'],
                             $child['customer_child_middle_name'], $child['customer_child_last_name'],$child['customer_child_email'], $child['customer_child_phone_number'],$child['customer_child_dob'], $child['customer_child_address'],
                             $child['customer_child_address_details'], $child['customer_child_state'],$child['customer_child_city'], $child['customer_child_zipcode'],$child['customer_child_social_security_number']
                         ));       
                     } else{
                         fputcsv($handle, array(
                             '','','','','','', '','','','','','','','','','','','','','','','','','',
                             $child['customer_child_first_name'],
                             $child['customer_child_middle_name'], $child['customer_child_last_name'],$child['customer_child_email'], $child['customer_child_phone_number'],$child['customer_child_dob'], $child['customer_child_address'],
                             $child['customer_child_address_details'], $child['customer_child_state'],$child['customer_child_city'], $child['customer_child_zipcode'],$child['customer_child_social_security_number']
                         ));       
                    }
                }
            }

        }
        
        fputcsv($handle, array());
        fclose($handle);
        $headers = array('Content-Type' => 'text/csv');
        
    }
   
}
