<?php

class Check_user_login {

    /**
     * @name initialize()
     * @uses used to check user is login or not if login then redirect to requested page else redirect to login page
     * @author KAP
     **/
    function initialize() {
        $CI = & get_instance();
        $user = $CI->session->userdata('user_info');
        $controller = $CI->router->fetch_class();
        //$action     = $CI->router->fetch_method();
    
            if(empty($user) && $controller != 'login'){
                redirect('crm');
            }

        }
    

    /**
     * @name merge_array()
     * @uses merge link array, if used this one with array_map we no need to use foreach loop
     * @param array @check_links array value
     * @author KAP
     **/
    function merge_array($check_links){
        return $check_links['url'];
    }
}
?>