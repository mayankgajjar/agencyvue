<?php

/**
 * Description of Common Helper :- Function which are use commonly in whole application.
 *
 * @author dhareen
 */

/**
 * For Printing Array.
 * @param array value
 * @author HAD
 */
function pr_arr($post) {
    echo'<pre>';
    print_r($post);
    echo'</pre>';
}

/**
 * For Printing Array AND DIE
 * @param array value
 * @author HAD
 */
function pr_exit($post) {
    echo'<pre>';
    print_r($post);
    echo'</pre>';
    exit();
}

function state_selector($selected_state, $name) {
    $state_json = file_get_contents(base_url() . '/assets/json_db/states.json');
    $state_json = json_decode($state_json);
    $html_select_box = "<select class='form-control required' name='$name' onchange='city_selector()'>";
    $html_select_box .= "<option value=''>Select State</option>";
    foreach ($state_json as $state) {
        $selected = "";
        if ($selected_state == $state->name) {
            $selected = "selected";
        } $html_select_box .= "<option value='$state->name' $selected>$state->name</option>";
    } $html_select_box .= "</select>";
    return $html_select_box;
}

function city_selector($selected_state, $name) {
    $state_json = file_get_contents(base_url() . '/assets/json_db/states.json');
    $state_json = json_decode($state_json);
    $html_select_box = "<select class='form-control required' name='$name'>";
    $html_select_box .= "<option value=''>Select State</option>";
    foreach ($state_json as $state) {
        $selected = "";
        if ($selected_state == $state->name) {
            $selected = "selected";
        } $html_select_box .= "<option value='$state->name' $selected>$state->name</option>";
    } $html_select_box .= "</select>";
    return $html_select_box;
}

/** For getting all state list * */
function get_all_state() {
    $state = get_data('crm_states', '0');
    return $state;
}

/** For getting SUBDOMAIN VALUE FROM USERID  * */
/* function get_subdomain_id($user_id = null) {
  if ($user_id != null) {
  $where = array('user_id' => $user_id);
  $data_domain = get_data('crm_domain_master', 1, $where);
  return $data_domain['domain_name'];
  } else {
  return "USER ID NULL ERROR IN SUBDOMAIN FINDER";
  }
  }

  function subdomain_control() {
  $CI = & get_instance();
  $host = $_SERVER['HTTP_HOST'];
  $host = str_replace("www.", " ", $host);
  $domainValue = explode(".", $host);
  if (count($domainValue) >= 3) {
  $CI->db->select('domain_name');
  $totalDomain = $CI->db->get('crm_domain_master')->result_array();
  if (!empty($totalDomain)) {
  $totalDomain = array_column($totalDomain, 'domain_name');
  if (in_array($domainValue[0], $totalDomain)) {
  redirect($CI->config->item('http') . $domainValue[0] . '.' . $CI->config->item('main_url') . 'login');
  } else {
  redirect();
  }
  }
  }
  } */

/**
 * Get Global USER ID OF USER MASTER TABLE BY PASSING MEMBER ID ( of any member table ).
 * @param $memberID Id form lead_member_mester table.
 */
function get_global_userID($memberID = null) {
    if ($memberID == null) {
        exit('MEMBER ID NULL || ERROR');
    } else {
        $tbl_name = "crm_lead_member_master";
        $single = 1;
        $where = array('customer_id' => $memberID);
        $user_id = get_data($tbl_name, $single, $where);
        return $user_id['user_id'];
    }
}

/**
 * @uses Get Full state name from state code.
 * @param $stateCode State Short Value ( EG. CA = California ).
 */
function get_state_name($stateCode = null) {
    if ($stateCode == null) {
        exit('State Code NULL || ERROR ');
    } else {
        $tbl_name = "crm_states";
        $single = 1;
        $where = array('state_code' => $stateCode);
        $stateName = get_data($tbl_name, $single, $where);
        return $stateName['state'];
    }
}

/**
 * @uses element Description GET All Cities FROM STATE CODE
 * @param type $state_code USA state code EG. NY = New YORK
 * @return Array All cities of given state code
 */
function get_state_city($state_code = null) {
    $CI = & get_instance();
    if ($state_code == null) {
        exit('STATE CODE NULL || HELPER ERROR');
    }
    $con_pri = array('state_code' => $state_code);
    $CI->db->select('city');
    $CI->db->where($con_pri);
    $query = $CI->db->get('crm_cities');
    $cities = $query->result_array();
    return $cities;
}

/**
 * Get Enrollment Fee Values from Product ID
 */
function get_enrollment_fee($globel_product_id = null) {
    if ($globel_product_id == null) {
        exit('Product ID NULL || ERROR ');
    }
    $table = 'crm_product_enrollment_fee as fee';
    $options = array(
        'fields' => array("fee.enrollment_fee"),
        'conditions' => array(
            "fee.global_product_id" => $globel_product_id,
            "fee.status" => "active",
        ),
    );
    $feeProducts = get_relation($table, $options, FALSE);
    $enrollmentFee = array();
    foreach ($feeProducts as $feeProduct) {
        $temp = $feeProduct['enrollment_fee'];
        array_push($enrollmentFee, $temp);
    }
    return $enrollmentFee;
}

/**
 * Get Display Name from ID
 * @param $userID USER ID from USER MASTER DATE.
 * @author HAD
 */
function get_display_name($useID = null) {
    if ($useID == null) {
        return "USER ID ISSUE || ERROR";
    } else {
        $tbl_name = "crm_user_tbl";
        $single = 1;
        $where = array('user_id' => $useID);
        $displayName = get_data($tbl_name, $single, $where);
        return $displayName['display_name'];
    }
}

/**
 * Function Name : File Array Insert
 * @Param : Location
 * @Param : HTML File ControlName
 * @Param : Extension
 * @Param : Size Limit
 * @Param : Image Array Key
 * @Return : FileName
 * @uses  For MUIPLE file upload
 */
function FileArrayInsert($location, $controlname, $type, $size, $key) {
    $type = strtolower($type);
    $return = array();
    if (isset($_FILES[$controlname]['name'][$key]) && $_FILES[$controlname]['name'][$key]) {
        $filename = $_FILES[$controlname]['name'][$key];
        $file_extension = pathinfo($filename, PATHINFO_EXTENSION);
        $filesize = $_FILES[$controlname]["size"][$key];
        if ($type == 'image') {
            if ($file_extension == 'jpg' || $file_extension == 'jpeg' || $file_extension == 'png' || $file_extension == 'gif') {
                if ($filesize <= $size) {
                    $return['msg'] = $CI->FileArrayUpload($location, $controlname, $key);
                    $return['status'] = 1;
                } else {
                    $size = $size / 1024;
                    $return['msg'] = 'File Is Larger than ' . $size . ' KB';
                    $return['status'] = 0;
                }
            } else {
                $return['msg'] = 'File Must Be In jpg,jpeg,png,gif Format';
                $return['status'] = 0;
            }
        } elseif ($type == 'pdf') {
            if ($file_extension == 'pdf') {
                if ($filesize <= $size) {
                    $return['msg'] = $CI->FileArrayUpload($location, $controlname, $key);
                    $return['status'] = 1;
                } else {
                    $size = $size / 1024;
                    $return['msg'] = 'File Is Larger than ' . $size . ' KB';
                    $return['status'] = 0;
                }
            } else {
                $return['msg'] = 'File Must Be In PDF Format';
                $return['status'] = 0;
            }
        } elseif ($type == 'excel') {
            if ($file_extension == 'xlsx' || $file_extension == 'xls') {
                if ($filesize <= $size) {
                    $return['msg'] = $CI->FileArrayUpload($location, $controlname, $key);
                    $return['status'] = 1;
                } else {
                    $size = $size / 1024;
                    $return['msg'] = 'File Is Larger than ' . $size . ' KB';
                    $return['status'] = 0;
                }
            } else {
                $return['msg'] = 'File Must Be In Excel Format Only allow .xlsx and .xls extension';
                $return['status'] = 0;
            }
        } elseif ($type == 'doc') {
            if ($file_extension == 'doc' || $file_extension == 'docx' || $file_extension == 'txt' || $file_extension == 'rtf') {
                if ($filesize <= $size) {
                    $return['msg'] = $CI->FileArrayUpload($location, $controlname, $key);
                    $return['status'] = 1;
                } else {
                    $size = $size / 1024;
                    $return['msg'] = 'File Is Larger than ' . $size . ' KB';
                    $return['status'] = 0;
                }
            } else {

                $return['msg'] = 'File Must Be In doc,docx,txt,rtf Format';
                $return['status'] = 0;
            }
        } else {
            $return['msg'] = 'Not Allow other than image,pdf,excel,doc file..';
            $return['status'] = 0;
        }
    }
    return $return;
}

/**
 * Function Name : File Insert
 * @Param : Location
 * @Param : HTML File ControlName
 * @Param : Extension
 * @Param : Size Limit
 * @Param : Old File Name
 * @Return : FileName
 * @uses For Single Image upload
 */
function FileInsert($location, $controlname, $type, $size, $oldfile = '') {
    $CI = & get_instance();
    $type = strtolower($type);
    $return = array();
    if (isset($_FILES[$controlname]) && $_FILES[$controlname]['name']) {
        $filename = $_FILES[$controlname]['name'];
        $file_extension = pathinfo($filename, PATHINFO_EXTENSION);
        $filesize = $_FILES[$controlname]["size"];
        if ($type == 'image') {
            if ($file_extension == 'jpg' || $file_extension == 'jpeg' || $file_extension == 'png' || $file_extension == 'gif') {
                if ($filesize <= $size) {
                    $return['msg'] = FileUpload($location, $controlname);
                    $return['status'] = 1;
                    if (isset($oldfile) && $oldfile != NULL) {
                        DeleteImage($location, $oldfile);
                    }
                } else {
                    $size = $size / 1024;
                    $return['msg'] = 'File Is Larger than ' . $size . ' KB';
                    $return['status'] = 0;
                }
            } else {
                $return['msg'] = 'File Must Be In jpg,jpeg,png,gif Format';
                $return['status'] = 0;
            }
        } elseif ($type == 'pdf') {
            if ($file_extension == 'pdf') {
                if ($filesize <= $size) {
                    $return['msg'] = FileUpload($location, $controlname);
                    $return['status'] = 1;
                    if (isset($oldfile) && $oldfile != NULL) {
                        DeleteImage($location, $oldfile);
                    }
                } else {

                    $size = $size / 1024;
                    $return['msg'] = 'File Is Larger than ' . $size . ' KB';
                    $return['status'] = 0;
                }
            } else {
                $return['msg'] = 'File Must Be In PDF Format';
                $return['status'] = 0;
            }
        } elseif ($type == 'excel') {
            if ($file_extension == 'xlsx' || $file_extension == 'xls') {
                if ($filesize <= $size) {
                    $return['msg'] = FileUpload($location, $controlname);
                    $return['status'] = 1;
                    if (isset($oldfile) && $oldfile != NULL) {
                        DeleteImage($location, $oldfile);
                    }
                } else {
                    $size = $size / 1024;
                    $return['msg'] = 'File Is Larger than ' . $size . ' KB';
                    $return['status'] = 0;
                }
            } else {
                $return['msg'] = 'File Must Be In Excel Format Only allow .xlsx and .xls extension';
                $return['status'] = 0;
            }
        } elseif ($type == 'doc') {
            if ($file_extension == 'doc' || $file_extension == 'docx' || $file_extension == 'txt' || $file_extension == 'rtf' || $file_extension == 'pdf') {
                if ($filesize <= $size) {
                    $return['msg'] = FileUpload($location, $controlname);
                    $return['status'] = 1;
                    if (isset($oldfile) && $oldfile != NULL) {
                        DeleteImage($location, $oldfile);
                    }
                } else {
                    $size = $size / 1024;
                    $return['msg'] = 'File Is Larger than ' . $size . ' KB';
                    $return['status'] = 0;
                }
            } else {
                $return['msg'] = 'File Must Be In doc,docx,txt,rtf Format';
                $return['status'] = 0;
            }
        } elseif ($type == 'audio') {
            if ($file_extension == 'mp3' || $file_extension == 'wav') {
                if ($filesize <= $size) {
                    $return['msg'] = FileUpload($location, $controlname);
                    $return['status'] = 1;
                    if (isset($oldfile) && $oldfile != NULL) {
                        DeleteImage($location, $oldfile);
                    }
                } else {
                    $size = $size / 1024;
                    $return['msg'] = 'File Is Larger than ' . $size . ' KB';
                    $return['status'] = 0;
                }
            } else {
                $return['msg'] = 'File Must Be In Mp3 Or WAV Format';
                $return['status'] = 0;
            }
        } else {
            $return['msg'] = 'Not Allow other than image,pdf,excel,doc file..';
            $return['status'] = 0;
        }
    } else {
        $return['msg'] = $oldfile;
        $return['status'] = 1;
    }
    return $return;
}

/**
 * Function Name : File Upload
 * @Param : Location
 * @Param : HTML File ControlName
 * @Return : FileName
 */
function FileUpload($location, $controlname) {
    $CI = & get_instance();
    if (!file_exists(FCPATH . $location)) {
        $create = mkdir(FCPATH . $location, 0777, TRUE);
        if (!$create)
            return '';
    }

    $newFileName = RenameImage($_FILES[$controlname]['name']);
    if (move_uploaded_file(realpath($_FILES[$controlname]['tmp_name']), $location . $newFileName)) {
        return $newFileName;
    } else {
        return '';
    }
}

/**
 * Function Name : File Delete
 * @Param : Location
 * @Param : OLD Image Name
 */
function DeleteImage($location, $oldfile) {
    if (file_exists(FCPATH . $location . $oldfile)) {
        unlink(FCPATH . $location . $oldfile);
    }
}

/**
 * Function Name : Rename Image
 * @Param : FileName
 * @Return : FileName
 */
function RenameImage($imageName) {
    $random = rand(1, 99);
    $randString = md5(time() . $imageName . $random);
    $fileName = $imageName;
    $splitName = explode(".", $fileName);
    $fileExt = end($splitName);
    return strtolower($randString . '.' . $fileExt);
}

/**
 * @uses Get Stripe Setting
 * @return Array Stripe Setting Details
 */
function get_stripe_setting() {
    $where = array("setup_id" => 1);
    return $stripe_setting = get_data("crm_agency_setup", 1, $where);
}

/**
 * @uses Stripe Payment Method For Agency FEE
 * @param $number Card Number
 * @param $cvc Card CVC
 * @param $exp_month Card Expiration Month
 * @param $exp_year Expiration Year
 * @param $name Card Name Ex. VISA
 * @param $agency_name Agency Name for passing as payment note || optional
 * @param $paymentNote Insert some payment note along with || optional
 * @return JSON Payment Gateway Response
 */
function stripe_payment($number, $cvc, $exp_month, $exp_year, $name, $agency_name = "", $paymentNote = "") {
    $CI = & get_instance();
    $stripeNote = "";
    $stripeSetting = get_stripe_setting();
    if ($stripeSetting['enable_test'] == "YES") {
        $agenciesFee = $stripeSetting['registration_fee'] * 100;
        $config['stripe_key_test_public'] = $stripeSetting['test_publishable_key'];
        $config['stripe_key_test_secret'] = $stripeSetting['test_secret_key'];
        $config['stripe_test_mode'] = TRUE;
        $config['stripe_verify_ssl'] = FALSE;
//        pr_arr($config);
//        echo '<br> FEE-' . $agenciesFee . '<br>';
//        echo 'Number: ' . $number . ' CVC: ' . $cvc . ' exp_month: ' . $exp_month . ' exp_year: ' . $exp_year . ' name: ' . $name;
//        pr_exit($_POST);
    }
    $CI->load->library('stripe', $config);
    $card_data = array(
        'number' => $number,
        'cvc' => $cvc,
        'exp_month' => $exp_month,
        'exp_year' => $exp_year,
        'name' => $name,
    );
    $tokenData = $CI->stripe->card_token_create($card_data, $agenciesFee);
    $tokenData = json_decode($tokenData);
    if (isset($tokenData->id)) {
        $token = $tokenData->id;
        if ($agency_name != "") {
            $stripeNote = $agency_name . "'s Registration fee";
        } elseif ($paymentNote != "") {
            $stripeNote = $paymentNote;
        } else {
            $stripeNote = "Test Payment";
        }
        $statusJson = $CI->stripe->charge_card($agenciesFee, $token, $stripeNote);
        return $statusJson;
    } else {
        return $tokenData;
    }
}

/**
 * @uses Stripe Payment Method For Any Payable amount
 * @param $payable Payable Amount IN USD CENT
 * @param $number Card Number
 * @param $cvc Card CVC
 * @param $exp_month Card Expiration Month
 * @param $exp_year Expiration Year
 * @param $name Card Name Ex. VISA
 * @param $paymentNote Insert some payment note along with || optional
 * @return JSON Payment Gateway Response
 */
function payable_stripe($payable = null, $number, $cvc, $exp_month, $exp_year, $name, $paymentNote = "") {
    if ($payable == null) {
        exit('Agency FEE NULL || Error');
    }
    $CI = & get_instance();
    $stripeNote = "";
    $stripeSetting = get_stripe_setting();
    if ($stripeSetting['enable_test'] == "YES") {
        $config['stripe_key_test_public'] = $stripeSetting['test_publishable_key'];
        $config['stripe_key_test_secret'] = $stripeSetting['test_secret_key'];
        $config['stripe_test_mode'] = TRUE;
        $config['stripe_verify_ssl'] = FALSE;
    }
    $CI->load->library('stripe', $config);
    $card_data = array(
        'number' => $number,
        'cvc' => $cvc,
        'exp_month' => $exp_month,
        'exp_year' => $exp_year,
        'name' => $name,
    );
    $tokenData = $CI->stripe->card_token_create($card_data, $payable);
    $tokenData = json_decode($tokenData);
    if (isset($tokenData->id)) {
        $token = $tokenData->id;
        if ($paymentNote != "") {
            $stripeNote = $paymentNote;
        } else {
            $stripeNote = "Test Payment";
        }
        $statusJson = $CI->stripe->charge_card($payable, $token, $stripeNote);
        return $statusJson;
    } else {
        return $tokenData;
    }
}

/**
 * @uses Refund Registration fee
 * @param $agencyId Agency ID || user_id from User Table
 * @param type $paymentNote Insert some payment note along with || optional
 */
function stripe_refund_registration_agency($agency_transaction_id = null) {
    if ($agency_transaction_id == null) {
        exit('Agency Transaction ID NULL || ERROR');
    }
    $CI = & get_instance();
    $stripeSetting = get_stripe_setting();
    if ($stripeSetting['enable_test'] == "YES") {
        $agenciesFee = $stripeSetting['registration_fee'] * 100;
        $config['stripe_key_test_public'] = $stripeSetting['test_publishable_key'];
        $config['stripe_key_test_secret'] = $stripeSetting['test_secret_key'];
        $config['stripe_test_mode'] = TRUE;
        $config['stripe_verify_ssl'] = FALSE;
//        pr_arr($config);
//        echo '<br> FEE-' . $agenciesFee . '<br>';
//        echo 'Number: ' . $number . ' CVC: ' . $cvc . ' exp_month: ' . $exp_month . ' exp_year: ' . $exp_year . ' name: ' . $name;
//        pr_exit($_POST);
    }
    $CI->load->library('stripe', $config);
    $requestJson = $CI->stripe->charge_refund($agency_transaction_id);
    return $requestJson;
}

/**
 * @uses Get All agent of given Agency
 * @param INIT $agnecyID ID of agency from User Table
 * @return Array List of ID and Display Name Of Agency's Agents
 */
function get_agents($agencyID = null) {
    if ($agencyID == null) {
        exit("Agnecy ID NULL || ERROR ");
    }
    $table = 'crm_broker_personal as agent';
    $options = array(
        'fields' => array("master.user_id,master.display_name"),
        'JOIN' => array(
            array(
                'table' => 'crm_user_tbl master',
                'condition' => 'agent.user_id = master.user_id',
                'type' => 'FULL'
            )
        ),
        'conditions' => array(
            "agent.parent_id" => $agencyID,
            "master.is_approved" => "Y",
            "master.is_deleted" => "N",
        ),
        'ORDER BY' => array(
            'ASC'
        )
    );
    $agents = get_relation($table, $options, FALSE);
    return $agents;
}

/**
 * @uses Agency's Active Member
 * @param INIT $agencyID Agency ID
 * @return type Description
 */
function get_agency_members($agencyID = null) {
    if ($agencyID == null) {
        exit("Agnecy ID NULL || ERROR ");
    }
    $table = 'crm_lead_member_master as mtbl';
    $options = array(
        'fields' => array("mtbl.user_id as member_id,mtbl.broker_id as parent_id ,master.display_name as perent_name"),
        'JOIN' => array(
            array(
                'table' => 'crm_user_tbl master',
                'condition' => 'mtbl.broker_id = master.user_id',
                'type' => 'FULL'
            )
        ),
        'conditions' => array(
            "mtbl.broker_id" => $agencyID,
            "mtbl.customer_status" => 'memeber',
            "mtbl.is_delete" => 'N',
            "mtbl.is_active" => 'Y',
            "master.is_approved" => "Y",
            "master.is_deleted" => "N",
        ),
        'ORDER BY' => array(
            'ASC'
        )
    );
    $agencyMember = get_relation($table, $options, FALSE);
    return $agencyMember;
}

/**
 * @uses  Agent's Sub agent
 * @param INIT $agentID
 * @return Array
 */
function get_agent_subagent($agent = null) {
    if ($agent == null) {
        exit("Agent ID NULL || ERROR ");
    }
    $table = 'crm_broker_personal as agent';
    $options = array(                                                                                                                            
        'fields' => array("master.user_id,master.display_name"),
        'JOIN' => array(
            array(
                'table' => 'crm_user_tbl master',
                'condition' => 'agent.user_id = master.user_id',
                'type' => 'FULL'
            )
        ),
        'conditions' => array(
            "agent.parent_id" => $agent,
            "master.is_approved" => "Y",
            "master.is_deleted" => "N",
        ),
        'ORDER BY' => array(
            'ASC'
        )
    );
    $agents = get_relation($table, $options, FALSE);
    return $agents;
}

/**
 * @uses Get Agent's Active members
 * @param $agentID User ID Of Agent
 * @return Array
 */
function get_agent_member($agent = null) {
    if ($agent == null) {
        exit("Agent ID NULL || ERROR ");
    }
    $table = 'crm_lead_member_master as mtbl';
    $options = array(
        'fields' => array("mtbl.user_id as member_id,mtbl.broker_id as parent_id ,master.display_name as perent_name"),
        'JOIN' => array(
            array(
                'table' => 'crm_user_tbl master',
                'condition' => 'mtbl.broker_id = master.user_id',
                'type' => 'FULL'
            )
        ),
        'conditions' => array(
            "mtbl.broker_id" => $agent,
            "mtbl.customer_status" => 'memeber',
            "mtbl.is_delete" => 'N',
            "mtbl.is_active" => 'Y',
            "master.is_approved" => "Y",
            "master.is_deleted" => "N",
        ),
        'ORDER BY' => array(
            'ASC'
        )
    );
    $agentMember = get_relation($table, $options, FALSE);
    return $agentMember;
}

/**
 * @uses Get Members count agent wise From Agency ID
 * @param INIT $agencyID ID Of agency from USER TABLE
 * @return Array Agent ID and Active Member Count
 */
function get_agency_active_members($agencyID = null) {
    if ($agencyID == null) {
        exit('Agency ID NULL || ERROR');
    }
}

/**
 * get_product_name from ID
 * @param $userID USER ID from USER MASTER DATE.
 * @author HAD
 */
function get_product_name($ProductID = null) {
    if ($ProductID == null) {
        return "Product ID ISSUE || ERROR";
    } else {
        $tbl_name = "crm_products";
        $single = 1;
        $where = array('member_product_id' => $ProductID);
        $ProductName = get_data($tbl_name, $single, $where);
        return $ProductName['product_name'];
    }
}

if (!function_exists('formatMoney')) {

    function formatMoney($number, $cents = 1, $symbol = FALSE) {
        if (is_numeric($number)) {
            if (!$number) {
                $money = ($cents == 2 ? '0.00' : '0');
            } else {
                if (floor($number) == $number) {
                    $money = number_format($number, ($cents == 2 ? 2 : 0));
                } else {
                    $money = number_format(round($number, 2), ($cents == 0 ? 0 : 2));
                }
            }
            if ($symbol == TRUE) {
                return '$' . $money;
            }
            return $money;
        }
    }

}

/**
 * get_product_name from ID
 * @param $userID USER ID from USER MASTER DATE.
 * @author HAD
 */
function get_product_global_id($ProductID = null) {
    if ($ProductID == null) {
        return "Product ID ISSUE || ERROR";
    } else {
        $tbl_name = "crm_products";
        $single = 1;
        $where = array('global_product_id' => $ProductID);
        $ProductName = get_data($tbl_name, $single, $where);
        return $ProductName['product_name'];
    }
}

function get_agent_target($agent_user_id = null) {
    if ($agent_user_id == null) {
        return "USER ID ISSUE || ERROR";
    }
    $where = array('user_id' => $agent_user_id);
    $agent_primary = get_data('crm_broker_personal', '1', $where);
    return $agent_primary['agent_target'];
}

/**
 * Get Member ID From Global USER ID
 * @param $userID Id form lead_member_mester table.
 */
function get_member_from_userID($userID = null) {
    if ($userID == null) {
        exit('MEMBER ID NULL || ERROR');
    } else {
        $tbl_name = "crm_lead_member_master";
        $single = 1;
        $where = array('user_id' => $userID);
        $user_id = get_data($tbl_name, $single, $where);
        return $user_id['customer_id'];
    }
}

/**
 * @uses get_feeds
 * @param UserID $userId
 */
function get_feeds($userId = null) {
    if ($userId == null) {
        exit('USER ID NULL || ERROR');
    }
    $table = 'crm_feeds';
    $options = array('conditions' => '(to_id = ' . $userId . ' AND status = "unreed") OR (to_id = "0" AND status = "unreed" AND from_id ="0" )',
        "ORDER_BY" => array(
            "field" => 'created',
            "order" => 'DESC'
        )
    );
    $feeds = get_relation($table, $options, FALSE);
    return $feeds;
}

/*  For time Ago
 *   Param 1 : DateTime
 */

function time_ago($date) {

    if (empty($date)) {
        return "No date provided";
    }

    $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
    $lengths = array("60", "60", "24", "7", "4.35", "12", "10");
    $now = time();
    $unix_date = strtotime($date);

    // check validity of date

    if (empty($unix_date)) {
        return "";
    }

    // is it future date or past date
    if ($now > $unix_date) {
        $difference = $now - $unix_date;
        $tense = "ago";
    } else {
        $difference = $unix_date - $now;
        $tense = "from now";
    }
    for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
        $difference /= $lengths[$j];
    }
    $difference = round($difference);
    if ($difference != 1) {
        $periods[$j] .= "s";
    }
    return "$difference $periods[$j] {$tense}";
}

if (!function_exists('getBoberdooUserId')) {

    function getBoberdooUserId() {
        $CI = & get_instance();
        $brokerId = $CI->session->userdata('agent_primary')['broker_id'];
        $query = "SELECT boberdoo_user_id FROM crm_broker_personal WHERE broker_id = {$brokerId}";
        $query = $CI->db->query($query);
        $row = $query->row_array();
        return $partnerId = $row['boberdoo_user_id'];
    }

}

if (!function_exists('getBoberdooUserIdForAgency')) {

    function getBoberdooUserIdForAgency() {
        $CI = & get_instance();
        $brokerId = $CI->session->userdata('user_info')['user_id'];
        $query = "SELECT boberdoo_user_id FROM crm_agencies_basic WHERE user_id = {$brokerId}";
        $query = $CI->db->query($query);
        $row = $query->row_array();
        return $partnerId = $row['boberdoo_user_id'];
    }

}