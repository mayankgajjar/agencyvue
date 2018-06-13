<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of memberProduct
 *
 * @author dhareen
 */
class Member_product extends CI_Model {

    public function get_total_sales_betweendates($rangStart = null, $rangeEnd = null) {
        $stmt = "SELECT sum(product_price) AS total_sale_amount FROM `crm_member_products` mp LEFT JOIN crm_products p ON mp.product_id = p.global_product_id WHERE added_by = {$this->session->userdata['user_info']['user_id']} AND is_status = 'Y' and ( added_time BETWEEN '$rangStart' AND '$rangeEnd')";
        $query = $this->db->query($stmt);
        $row = $query->row_array();
        return $row['total_sale_amount'];
    }

}
