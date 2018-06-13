<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
function pr($arr, $exit = 0) {
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
    if ($exit == 1) {
        exit;
    }
}

function upload_image($image_name, $image_path) {
    $CI = & get_instance();
    $extension = explode('/', $_FILES[$image_name]['type']);
    $randname = uniqid() . time() . '.' . $extension[1];
    $config = array('upload_path' => $image_path,
        'allowed_types' => "png|jpg|jpeg|gif",
        // 'max_size' => "700KB",
        // 'max_height'      => "768",
        // 'max_width'       => "1024" ,
        'file_name' => $randname
    );
    #Load the upload library
    $CI->load->library('upload');
    $CI->upload->initialize($config);
    if ($CI->upload->do_upload($image_name)) {
        $img_data = $CI->upload->data();
        $imgname = $img_data['file_name'];
    } else {
        $imgname = array('errors' => $CI->upload->display_errors());
    }
    return $imgname;
}

function image_upload($input_file_name, $upload_path) {
    $filename = time() . $filename;
    $_FILES['p_photo']['name'] = $filename;
    $config['upload_path'] = $upload_path;
    $config['allowed_types'] = 'gif|jpg|png|jpeg';
    /* $config['max_size'] = '1500';
      $config['min_width'] = '460';
      $config['min_height'] = '308'; */
    $this->load->library('upload');
    $this->upload->initialize($config);
    if ($this->upload->do_upload('p_photo')) {
        // Change the filename as Upload library change it.
        $upload_data = $this->upload->data();
        $uploaded_filename = $upload_data['file_name'];
        $this->session->set_flashdata('msg', 'Product Added successfully.');
        $imgMessage = 'Product Added successfully.';
        $imgUpload = 1;
    } else {
        $uploaded_filename = "";
        $this->session->set_flashdata('err_msg', $this->upload->display_errors());
        $imgUpload = 0;
        $imgMessage = $this->upload->display_errors();
    }
}

/**
 * @method : qry
 * @uses : This function simply print last executed query
 * @param : @bool = boolean execution stopped if true 
 * @author : KAP
 */
function qry($bool = false) {
    $CI = & get_instance();
    echo $CI->db->last_query();
    if ($bool)
        die;
}

/**
 *   Print array/string.
 *   @param - data  = data that you want to print
 *   @param -is_die = if true. Excecution will stop after print. 
 *   @author : KAP
 */
function p($data, $is_die = false) {

    if (is_array($data)) {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    } else {
        echo $data;
    }

    if ($is_die)
        die;
}

/**
 * Generate slug
 * @author KAP
 * @param string $text - Text from which slug to be generated
 * @param string $table - Name of the table to check slug is exist or not
 * @param int $id - Id of the table to not check for the slug in that id (Used in Edit)
 * @return string slug 
 */
function slug($text, $table = '', $id = NULL, $category_based_slug = 'test') {
    $ci = & get_instance();
    $ci->load->model('users_model');
    if (strlen($text) != mb_strlen($text, 'utf-8')) {
        $text = $category_based_slug;
    } else {
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        $text = trim($text, '-');
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w\?&]+~', '', $text);
        $text = strtolower($text);
    }
    if (empty($text)) {
        return 'n-a';
    }
    if ($table != '') {
        //--- when text with table name then check generated slug is already exist or not
        for ($i = 0; $i < 1; $i++) {
            if ($id != NULL) {
                $where = 'slug = ' . $ci->db->escape($text) . ' AND id != ' . $id;
            } else {
                $where = 'slug = ' . $ci->db->escape($text);
            }
            $result = $ci->users_model->get_result($table, $where);
            if (sizeof($result) > 0) {
                $explode_slug = explode("-", $text);
                $last_char = $explode_slug[count($explode_slug) - 1];
                if (is_numeric($last_char)) {
                    $last_char++;
                    unset($explode_slug[count($explode_slug) - 1]);
                    $text = implode($explode_slug, "-");
                    $text.="-" . $last_char;
                } else {
                    $text.="-1";
                }
                $i--;
            } else {
                return $text;
            }
        }
    } else {
        return $text;
    }
}

/**
 * Generate slug_page
 * @author KAP
 * @param string $text - Text from which slug to be generated
 * @param string $table - Name of the table to check slug is exist or not
 * @param int $id - Id of the table to not check for the slug in that id (Used in Edit)
 * @return string slug 
 */
function slug_page($text, $table = '', $id = NULL) {
    $ci = & get_instance();
    $ci->load->model('users_model');

    // replace non letter or digits by -
    $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

    // trim
    $text = trim($text, '-');

    if (!mb_ereg('[\x{0600}-\x{06FF}]', $text)) {

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w\?&]+~', '', $text);
    }

    if (empty($text)) {
        return 'n-a';
    }
    if ($table != '') {
        //--- when text with table name then check generated slug is already exist or not
        for ($i = 0; $i < 1; $i++) {
            if ($id != NULL) {
                $where = 'url = ' . $ci->db->escape($text) . ' AND id != ' . $id;
            } else {
                $where = 'url = ' . $ci->db->escape($text);
            }
            $result = $ci->users_model->get_result($table, $where);
            if (sizeof($result) > 0) {
                $explode_slug = explode("-", $text);
                $last_char = $explode_slug[count($explode_slug) - 1];
                if (is_numeric($last_char)) {
                    $last_char++;
                    unset($explode_slug[count($explode_slug) - 1]);
                    $text = implode($explode_slug, "-");
                    $text.="-" . $last_char;
                } else {
                    $text.="-1";
                }
                $i--;
            } else {
                return $text;
            }
        }
    } else {
        return $text;
    }
}

/*
 *   @method : front_pagination
 *   @uses : get pagination setup for front end
 *   (KAP)
 */
function front_pagination() {
    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';
    $config['first_link'] = 'First';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li style="display:none"></li><li class="active"><a data-type="checked" style="background-color:#62a0b4;color:#ffffff; pointer-events: none;">';
    $config['cur_tag_close'] = '</a></li><li style="display:none"></li>';
    $config['prev_link'] = '&laquo;';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['next_link'] = '&raquo;';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['last_link'] = 'Last';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    return $config;
}

/**
 * Resise the image to specified dimensions
 * @author KAP
 * @param string @src - Source of the image
 * @param type @dest - Destination of the image
 * @param type @width - Width of the image
 * @param type @width - Height of the image
 */
function resize_image($src, $dest, $width, $height) {
    $CI = & get_instance();
    $CI->load->library('image_lib');
    $CI->image_lib->clear();
    $config['image_library'] = 'gd2';
    $config['source_image'] = $src;
    $config['maintain_ratio'] = TRUE;
    $config['width'] = $width;
    $config['height'] = $height;
    $config['new_image'] = $dest;
    $CI->image_lib->initialize($config);
    $CI->image_lib->resize();
}

/**
 * get_pages get pages based on perameter
 * @param  @type
 * @author KAP
 */
function get_pages($type) {
    $CI = & get_instance();
    $CI->load->model('CMS_model');
    if ($type == 'header') {
        $result = $CI->CMS_model->get_pages($type);
        if ($result) {
            $menu_array = array();
            foreach ($result as $key => $value) {
                if ($value['parent_id'] == 0 && $value['active'] == 1) {
                    $menu_array[$value['id']] = $value;
                }
            }
            foreach ($result as $key => $value) {
                if ($value['parent_id'] != 0) {
                    if (isset($menu_array[$value['parent_id']])) {
                        $menu_array[$value['parent_id']]['sub_menus'][] = $value;
                    }
                }
            }
            return $menu_array;
        }
    }

    if ($type == 'footer') {
        $result = $CI->CMS_model->get_pages($type);
        if ($result) {
            $menu_array = array();
            foreach ($result as $key => $value) {
                // if($value['parent_id'] == 0){
                $menu_array[$key] = $value;
                // } 
            }
            // foreach ($result as $key => $value) {
            //     if($value['parent_id'] != 0){
            //         $menu_array[$value['parent_id']] = $value;             
            //     } 
            // }
            // p($menu_array);
            return $menu_array;
        }
    }
}

/**
 * Crop Uploaded image in $width & $height and move cropped images to destination
 * @param type $src
 * @param type $destination
 * @param type $width
 * @param type $height
 * @param type $type
 * @author KAP
 */
function crop($src, $width, $height) {
    $destination = $src;
    $type = strtolower(pathinfo($src, PATHINFO_EXTENSION));
    $allowed_type = array('png', 'jpeg', 'gif', 'jpg');
    $return = 0;
    if (in_array($type, $allowed_type)) {
        list($w, $h) = getimagesize($src);

        $sourceRatio = $w / $h;
        $targetRatio = $width / $height;

        if ($sourceRatio < $targetRatio) {
            $scale = $w / $width;
        } else {
            $scale = $h / $height;
        }
        $cropWidth = $width * $scale;
        $cropHeight = $height * $scale;

        $widthPadding = ($w - $cropWidth) / 2;
        $heightPadding = ($h - $cropHeight) / 2;

        if ($type == 'jpg' || $type == 'jpeg') {
            $img_r = imagecreatefromjpeg($src);
            $function = 'imagejpeg';
        } else if ($type == 'png') {
            $img_r = imagecreatefrompng($src);
            $function = 'imagepng';
        } else if ($type == 'gif') {
            $img_r = imagecreatefromgif($src);
            $function = 'imagejgif';
        }
        $dst_r = ImageCreateTrueColor($width, $height);
        imagecopyresampled($dst_r, $img_r, 0, 0, $widthPadding, $heightPadding, $width, $height, $cropWidth, $cropHeight);

        if ($function($dst_r, $destination)) {
            $return = 1;
        }
    }
    return $return;
}

/**
 * @name user_template_links
 * @param int $type 1 = super admin, 2 = client admin, 3 = tenant
 * @author KAP
 */
function user_template_links($type) {

    if ($type == 1) {
	    $array = array(
            array(
                'name' => 'User Management',
                'url' => 'user_list',
				'icon' => 'icon-users4',
                'is_sidebar_link' => true
            ),
//            array(
//                'name' => 'Property Management',
//                'url' => 'property_management',
//                'icon' => 'icon-city',
//                'is_sidebar_link' => true
//            ),
//            array(
//                'name' => 'Tenant Management',
//                'url' => 'tenant_management',
//                'icon' => 'icon-users',
//                'is_sidebar_link' => true
//            ),
//            array(
//                'name' => 'Answers Report',
//                'url' => 'answers_report',
//                'icon' => 'icon-file-stats',
//                'is_sidebar_link' => true
//            ),
//            array(
//                'name' => 'Email Engine',
//                'url' => 'email_engine',
//                'icon' => 'icon-envelop',
//                'is_sidebar_link' => true
//            )
        );
    } elseif ($type == 2) {
        $array = array(
            array(
                'name' => 'Property Management',
                'url' => 'property_management',
                'icon' => 'icon-city',
                'is_sidebar_link' => true
            ),
            array(
                'name' => 'Tenant Management',
                'url' => 'tenant_management',
                'icon' => 'icon-users',
                'is_sidebar_link' => true
            ),
            array(
                'name' => 'Questions Management',
                'url' => 'questions_answers_management',
                'icon' => 'icon-question4',
                'is_sidebar_link' => false
            ),
            array(
                'name' => 'Answers Report',
                'url' => 'answers_report',
                'icon' => 'icon-file-stats',
                'is_sidebar_link' => true
            )
        );
    } else {
        $array = array(
            array(
                'name' => 'Questions Management',
                'url' => 'questions_answers_management',
                'icon' => 'icon-question4',
                'is_sidebar_link' => true
            )
        );
    }
    return $array;
}
