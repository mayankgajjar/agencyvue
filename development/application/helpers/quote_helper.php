<?php 
/**
 * Description of Quote Helper :- Function which are use Quote PROCESS in whole application.
 *
 * @author dhareen
 */

/**
 * QuoteRequest XML
 */
if (!function_exists('quoteRequest')) {
    function quoteRequest($arr) {
        // print_r($arr);
        // die;
        $url = "http://test1.hiiquote.com/webservice/quote_service.php";
        $xml_data = '<?xml version="1.0" encoding="iso-8859-1"?>
                        <methodCall>
                         <methodName>QuoteRequest</methodName>
                        <params>
                        <param>
                     <value>
                    <string>
                    <![CDATA[<?xml version="1.0" encoding="iso-8859-1" ?>
                    <QuoteRequest>
                        <User_ID>A10000000000</User_ID>
                        <State>' . $arr["state"] . '</State>
                        <Zip_Code>' . $arr["zip"] . '</Zip_Code>
                        <Applicant_Gender>'. ucfirst($arr["gender"]). '</Applicant_Gender>
                        <Applicant_Age>' . $arr["age"] . '</Applicant_Age>
                        <Include_Spouse>' . ucfirst($arr["include_spouse"]) .'</Include_Spouse>
                        <Spouse_Age>'. $arr["spouse_age"] .'</Spouse_Age>
                        <Spouse_Gender>'. ucfirst($arr["spouse_gender"]) .'</Spouse_Gender>
                        <Children_Count>'. $arr['childern_count'] .'</Children_Count>
                        <Tobacco>'. substr(ucfirst($arr['allow_tobacco']), 0, 1).'</Tobacco>
                        <Plan_ID>152</Plan_ID>
                        </QuoteRequest>]]>
                    </string>
                    </value>
                    </param>
                    </params>
                    </methodCall>';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // print_r(curl_getinfo($ch));
        $output = curl_exec($ch);
        curl_close($ch);
        $xml = simplexml_load_string($output);
        $resulut = $xml->params->param->value->string[0];
        $xmll = simplexml_load_string(html_entity_decode($resulut));
        $addOns = array();
        foreach ($xmll as $key => $value) {
            if ($key == 'Add-ons') {
                $addOns = $value;
                break;
            }
        }
        return $addOns;
    }

}
if (!function_exists('match_product')) {

    function match_product($name)
    {
        $CI = & get_instance();
        $query = "SELECT * FROM crm_products WHERE product_name REGEXP '[[:<:]]". $name."[[:>:]]'";
        $result = $CI->db->query($query)->row_array();
        return $result;
    }   
}
if(!function_exists('get_csg_api_token')){

    function get_csg_api_token (){
        $CI = & get_instance();
        $query = "SELECT setting_value FROM crm_settings_tbl WHERE setting_value = 'csg_api_token'";
        $result = $CI->db->query($query)->row_array();
        return $result;
    }
}