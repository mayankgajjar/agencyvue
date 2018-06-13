<?php

class Verification extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('Csvimport');
        $this->load->model('member');
    }

    public function index() {
        $data['title'] = 'Client Verification';
        //pr_exit($agentMember);
        $data['agencts'] = get_agents($this->session->userdata['user_info']['user_id']);
        $this->template->load('agency_header', 'agency/settings/verification', $data);
    }

    public function verificationJson() {

        $aColumns = array("client_id", "name", "product_name", "script_name");
        /* Pagination */
        $sLimit = array();
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $sLimit = array("start" => $_GET['iDisplayLength'], "end" => $_GET['iDisplayStart']);
        }
        
        $agents = get_agents($this->session->userdata['user_info']['user_id']);
        $leadPerents = $this->session->userdata['user_info']['user_id'] . ',';
        foreach ($agents as $agents) {
            $leadPerents .= $agents['user_id'] . ',';
        }
        $agent_id = "";
        if (isset($_REQUEST['agent_id'])) {
            $agent_id = $_REQUEST['agent_id'];
        }
        /* Search */

        $sWhere = "";

        if ($_GET['sSearch'] != "") {
            $sColumns = array("display_name", "product_name");

            $sWhere .= " (";
            for ($i = 0; $i < count($sColumns); $i++) {
                $sWhere .= $sColumns[$i] . " LIKE '%" . $_GET['sSearch'] . "%' OR ";
                //$sWhere[$aColumns[$i]] = $_GET['sSearch'];
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ') ';
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
      //  $rResult = $this->member->get_member_script_agency($sLimit, $sWhere, $sOrder);
      //  $iTotal_f = count($rResult);

        if ($agent_id != "") {
            $rResult = $this->member->get_member_script_agency_basedon_agent($sLimit, $sWhere, $sOrder, $agent_id);
            $iTotal_f = count($rResult);
            $iTotal = $this->member->get_member_script_count($sWhere, $agent_id);
        } else {
            $rResult = $this->member->get_member_script_agency_basedon_agent($sLimit, $sWhere, $sOrder, rtrim($leadPerents, ","));
            $iTotal_f = count($rResult);
            $iTotal = $this->member->get_member_script_count($sWhere, rtrim($leadPerents, ","));
        }

        $output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $iTotal_f,
            "iTotalDisplayRecords" =>$iTotal,
            "aaData" => array()
        );
        if ($rResult) {
            foreach ($rResult as $aRow) {
                $row = array();
                for ($i = 0; $i < count($aColumns); $i++) {
                    if ($aColumns[$i] == 'client_id') {
                        if ($aRow['gender'] == 'male') {
                            $row[] = "
                    <div class='checkbox checkbox-primary checkbox-single m-r-15'>
                        <input id='act_checkbox_" . $aRow['client_id'] . "' type='checkbox' value=" . urlencode(base64_encode($aRow["client_id"])) . " name='act_checkbox[]' class='ch_checkbox profile_checkbox'>
                        <label for='act-checkbox'></label>
                    </div>
                    <img src=" . base_url() . "assets/crm_image/Male_Placeholder.png alt='contact-img' title='contact-img' class='img-circle thumb-sm' />";
                        } else {
                            $row[] = "
                    <div class='checkbox checkbox-primary checkbox-single m-r-15'>
                        <input id='act_checkbox_" . $aRow['client_id'] . "' type='checkbox' value=" . urlencode(base64_encode($aRow["client_id"])) . " name='act_checkbox[]' class='ch_checkbox profile_checkbox'>
                        <label for='act-checkbox'></label>
                    </div>
                    <img src=" . base_url() . "assets/crm_image/Female_Placeholder.png alt='contact-img' title='contact-img' class='img-circle thumb-sm' />";
                        }
                    } elseif ($aColumns[$i] == 'script_name') {
                        $row[] .= '<audio controls="">
                            <source src="' . base_url() . 'assets/member_verification_script/' . $aRow['script_name'] . '" type="audio/mpeg">
                      </audio>';
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
}