<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description: Controller is user for Cron JOBS
 *
 * @author dhareen
 */
class Cron extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * @uses Send Mail For Active Members Charges
     * @author HAD
     */
    public function agencies_mail_cron() {
        $this->load->model('agency');
        $agencies = $this->agency->get_agencies();
        foreach ($agencies as $agency) {
            $agencyMembers = get_agency_members($agency['id']);
            $agencyMembersCount = $activeMember = count($agencyMembers);
            $agencyAgents = get_agents($agency['id']);
            if ($agencyAgents != "") {
                foreach ($agencyAgents as $key => $agent) {
                    $totalMembers = count(get_agent_member($agent['user_id']));
                    $agentMembers[$key] = array("parent_id" => $agent['user_id'], "total_members" => $totalMembers);
                    $activeMember = $activeMember + $totalMembers;
                }
            }
            if ($activeMember > 0) {
                $msg = "Hello " . $agency['display_name'] . "<br><br>
                           Your payment for Active Members Charge is<strong> $" . $activeMember . "</strong>.<br><br>
                            You have Totals <strong> " . $activeMember . " </strong> Active Members in your profile. <br><br>
                            As per our policy, we may charge you <strong> $1 </strong> per active member <br><br>
                            Total Active Member (" . $activeMember . ") * 1 = $" . $activeMember . "<br> <br>
                            You can see your all active members details on this <a href='" . base_url() . "'agency/members/charges'>link</a><br>
                            Would you please pay your remaining amount by click this <a href='" . base_url() . "'agency/members/charges'>link</a> ?
                            <br><i>NOTE: Please do login before accesing this URL.</i><br>
                            <br> Thank You,<br><br>
                            AgencyVUE";
                $subject = "Active Members Charges Payment Due|| AgencyVUE";
                $to_email = $agency['email'];
                $title = 'Active Members Charges';
                $invoice = send_email($to_email, $subject, $msg, $title);
                if ($invoice == 1) {
                    echo'SEND <br>';
                } else {
                    echo 'FAIL';
                }
            }
        }
    }

    /**
     * @uses Refreshing Value of CSG API TOKEN
     * @author HAD
     */
    public function csgapi_token_cron() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://csgapi.appspot.com/v1/auth.json");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{ \"api_key\": \"32ad0d705a0dd18ce997f1e94921476d7c4d2087cc8efa25fe2f333cc35cc5ad\" }");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json"
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        $tokenArr = json_decode($response, true);
        if ($tokenArr['token'] != '') {
            //write the content into json
            $file_name = 'rawAPI';
            if (file_exists('assets/json_temp/' . $file_name . '.json')) {
                unlink('assets/json_temp/' . $file_name . '.json');
            }
            $fp = fopen('assets/json_temp/' . $file_name . '.json', 'w+');
            fwrite($fp, $response);
            fclose($fp);
            // end of json writing into file

            /*
             * DATABASE TOKEN UPDATE
             */
            $getSettingToken = get_data('crm_settings_tbl', 1, array('setting_name' => 'csg_api_token'));
            if (!empty($getSettingToken)) {
                $updater = insert_update_data(0, 'crm_settings_tbl', array('setting_value' => $tokenArr['token'], 'created_date' => date('Y-d-m H:i:s', time())), array('setting_name' => 'csg_api_token'));
                if ($updater) {
                    return true;
                }
            } else {
                $inserter = insert_update_data(1, 'crm_settings_tbl', array('setting_name' => 'csg_api_token', 'setting_value' => $tokenArr['token']));
                if ($inserter) {
                    return true;
                }
            }
        } else {
            $file_name = 'rawAPI_fail';
            if (file_exists('assets/json_temp/' . $file_name . '.json')) {
                unlink('assets/json_temp/' . $file_name . '.json');
            }
            $fp = fopen('assets/json_temp/' . $file_name . '.json', 'w+');
            fwrite($fp, $response);
            fclose($fp);
        }
    }

}
