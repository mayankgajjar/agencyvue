<style type="text/css">
    .validation-error-label{
        color: red !important;
    }
    .product-list .fileupload {
        overflow: visible;
    }
    .product-list .fileupload ul.parsley-errors-list li {
        left: 0;
    }
    label.btn.btn-default.choose-file-btn {margin: 0 !important;}
    .date-picker-div {position: relative;}
    .date-picker-div span {
        height: 32px;
        position: absolute;
        right: 2px;
        top: 2px;
        width: 40px;
    }

    .datepicker>div {display: block;}

    .datepicker {z-index: 9999999;}

    .dataTables_filter{ display: none; }

    .loader-select-city {

        display: none;

        position: absolute;

        width: 100%;

        background: rgba(255,255,255,.2);

        left: 0;

        top: 0;

        right: 0;

        bottom: 0;

        z-index: 9999;

    }

    .loader-image {

        height: 45px;

        top: 50%;

        position: absolute;

        left: 50%;

        margin-top: -22px;

        margin-left: -22px;

    }

    .product-list{margin-bottom:5px;}
    .remove-spouse{margin-top:10px;}
    .select-product-image{text-align: center;margin-bottom: 15px;}
    .select-product-image img{height: auto;width: auto;}
    .select-product-image-desc strong {width: 45%;display: inline-block;text-align: right;color: #fff;}
    .select-product-image-desc span {width: 45%;display: inline-block;text-align:left;font-weight: bold;}
    .select-product-available p{    display: inline-block;float: left;margin-right: 10px;}
    .select-product-available p strong{color:#fff;font-size: 13px;}
    .select-product-available{overflow: hidden;}
    .select-product-title{text-align: left;}
    .select-product-title i{    text-align: right;float: right; color: #2dc4b9;font-size: 18px;}
    .select-product-available p span{font-size: 14px;font-weight:bold;margin-left: 10px;}
    .selected-product{max-height: 400px;overflow: auto;}
    .select-product-model .modal-content{background: #2b333b;padding: 20px;}

    .select-product-model .modal-header{border: none;padding-bottom: 0px;}

    .select-product-model .modal-header .close{ color: #fff !important;opacity: 1;margin-right: 30px;}

    .select-product-model .modal-header h4{color: #fff;font-size: 18px;font-weight: 400;padding-left:30px;}

    .select-product-model .modal-body{background: #323b44;padding: 20px;margin: 0px 30px;border: 2px solid rgba(255, 255, 255, 0.07);}

    .select-product-model .modal-footer{padding-top: 20px;border: none !important}

    /*.select-product-model .modal-footer button{margin-right:30px;}*/

    .select-product-model .modal-body .pro_info label {width: 35%;text-align: right;color: #fff;font-size: 13px;font-weight: bold;margin-right: 15px;}

    .select-product-model .modal-body .pro_info span{width: 50%;text-align: left;display: inline-block;font-weight: bold;font-size: 13px;}

    .select-product-model .modal .modal-dialog .modal-content .modal-body {padding: 30px;}

    .select-product-model .modal-dialog {margin: 50px auto;}

    .select-product-model .site-image{min-height: 50px;}

    .select-product-model .modal-body .row{border-bottom:2px solid rgba(255, 255, 255, 0.07);padding: 15px 0px;margin: 0 30px;}

    .select-product-model .modal-body .row:last-child{border-bottom:none;}

    .select-product-model .modal-body button.btn.btn-danger {width: 100px;}

    .select-product-model .modal-body button.btn.btn-danger span.btn-label {margin-right: 2px;}

    .fa-pencil{cursor: pointer;}



</style>



<div class="wrapper">

    <div class="container">
        <div class="loader-select-city"><img class="loader-image" src="<?= base_url() . 'assets/crm_image/' ?>ring.gif"></div>
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Client Information</h4>
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() . 'agent/dashboard' ?>">Dashboard</a></li>
                    <li><a href="<?= base_url() . 'agent/members' ?>">Clients</a></li>
                    <li class="active"><?php echo $lead_info['customer_first_name'] . ' ' . $lead_info['customer_last_name'] ?></li>
                </ol>
            </div>
            <div class="col-sm-12">
                <?php if ($this->session->flashdata('success')) { ?>
                    <div class="content pt0">
                        <div class="alert alert-success">
                            <a class="close" data-dismiss="alert"><i class="fa fa-times"></i></a>
                            <strong><?= $this->session->flashdata('success') ?></strong>
                        </div>
                    </div>
                    <?php
                    $this->session->set_flashdata('success', false);
                } else if ($this->session->flashdata('error')) {
                    ?>
                    <div class="content pt0">
                        <div class="alert alert-danger alert-styled-left alert-bordered">
                            <a class="close" data-dismiss="alert"><i class="fa fa-times"></i></a>
                            <strong><?= $this->session->flashdata('error') ?></strong>
                        </div>
                    </div>
                    <?php
                    $this->session->set_flashdata('error', false);
                }
                ?>
            </div>
            <input type="hidden" name="controller_name" id="controller_name" value="<?php echo urlencode(base64_encode($this->uri->segment(2))); ?>">
            <input type="hidden" name="method_name" id="method_name" value="<?php echo urlencode(base64_encode($this->uri->segment(3))); ?>">
            <input type="hidden" name="lead_id" id="lead_id" value="<?php echo urlencode(base64_encode($this->uri->segment(4))); ?>">
            <div class="row">
                <div class="col-md-4 col-lg-3">
                    <div class="profile-detail card-box">
                        <div>
                            <img src="<?php echo ($lead_info['customer_gender'] == 'male') ? base_url('assets/crm_image/Male_Placeholder.png') : base_url('assets/crm_image/Female_Placeholder.png'); ?>" class="img-circle" alt="profile-image">
                            <h4 class="text-uppercase font-600"><strong><?php echo $lead_info['customer_first_name'] . ' ' . $lead_info['customer_last_name'] ?>
                                </strong></h4>
                            <ul class="list-inline status-list m-t-20">
                                <div class="text-left">
                                    <p class="text-muted font-13"><strong>Created Date : </strong> <span class="m-l-15">01/13/2017</span></p>
                                    <p class="text-muted font-13"><strong>Activation Date :</strong><span class="m-l-15">01/13/2017</span></p>
                                    <p class="text-muted font-13"><strong>Next Billing Date :</strong> <span class="m-l-15">01/13/2018</span></p>
                                    <p class="text-muted font-13"><strong>Domain Name :</strong> <span class="m-l-15"><?php
                                        if (isset($domain_name)) {
                                            echo $domain_name;
                                        } else {

                                        }
                                        ?></span></p>
                                </div>
                            </ul>
                            <hr>
                            <h4 class="text-uppercase font-600"><strong>Product(s)</strong></h4>
                            <ul class="list-inline status-list m-t-20 profile_products">
                                <?php foreach ($member_product_array as $prodcut) : ?>
                                    <?php $i = 0; ?>
                                    <li class="product-list">
                                        <?php
                                        if ($prodcut['is_status'] == 'Y') {
                                            $status = '<button type="button" class="btn btn-success btn-xs"> Active </button>';
                                        } elseif ($prodcut['is_status'] == 'W') {
                                            $status = '<button type="button" class="btn_product_warning btn btn-warning btn-xs" data-toggle="modal" data-target="#verification_script" data-productid="' . $prodcut['global_product_id'] . '" data-memberproduct="' . $prodcut['member_product_id'] . '"> Warning </button>';
                                        } else {
                                            $status = '<button type="button" class="btn btn-danger btn-xs"> Cancelled </button>';
                                        }
                                        ?>
                                        <?php echo '<div class="li_inner_one">' . $prodcut['product_name'] . '</div> <div class="li_inner_two"> ' . formatMoney($prodcut['product_price'], '2', TRUE) . '</div> <div class="li_inner_three"> ' . $status . '</div> <div class="li_inner_four"> <span data-productid="' . $prodcut['global_product_id'] . '" data-memberproduct="' . $prodcut['member_product_id'] . '" id="product-popup-button"><i class="fa fa-pencil" > </i></span> </div>'; ?>
                                        <?php if ($prodcut['is_status'] == 'W'): ?>
                                        <?php endif; ?>
                                    </li>
                                    <?php
                                    $i++;
                                endforeach;
                                ?>
                                <div class="text-center">
                                    <div class="button-list m-t-10">
                                        <button type="button" class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target="#add-product-modal">
                                            <span class="btn-label"><i
                                                    class="fa fa-plus"></i>
                                            </span>Add</button>
                                        <button type="button" class="btn btn-danger waves-effect waves-light" style="display: none;">
                                            <span class="btn-label"><i class="fa fa-times"></i>
                                            </span>Remove</button>
                                    </div>
                                </div>
                            </ul>
                            <hr>
                            <h4 class="text-uppercase font-600"><strong>Billing
                                </strong></h4>
                            <ul class="list-inline status-list m-t-20">
                                <div class="text-left">
                                    <p class="text-muted font-13"><strong>Payment Type : </strong> <span class="m-l-15"><?php
                                            if ($billing_info['payment_type'] == 1) {
                                                echo 'Credit Card';
                                            } else if ($billing_info['payment_type'] == 2) {
                                                echo 'Paypal';
                                            }
                                            ?></span></p>
                                    <p class="text-muted font-13"><strong>Monthly Premium :</strong><span class="m-l-15"></span></p>
                                </div>
                                <div class="text-center">
                                    <div class="button-list">
                                        <a class="btn btn-success" data-toggle="modal" data-target="#payment-modal">
                                            <span class="btn-label"><i
                                                    class="fa fa-plus"></i>
                                            </span>Add</a>
                                        <button type="button" class="btn btn-danger waves-effect waves-light" style="display: none;">
                                            <span class="btn-label"><i class="fa fa-times"></i>
                                            </span>Remove</button>
                                    </div>
                                </div>
                            </ul>
                            <hr>
                            <h4 class="text-uppercase font-600"><strong>Dependents </strong></h4>
                            <ul class="list-inline status-list m-t-20">
                                <div class="text-left">
                                    <p class="text-muted font-13"><strong>Spouse : </strong> <span class="m-l-15"><?php echo (!empty($spouse_name)) ? $spouse_name : 'No Data Found'; ?></span></p>
                                    <div class="children_wapper">
                                        <p class="text-muted font-13"><strong>Children : </strong></p>
                                        <?php if (isset($child_names)): ?>
                                            <ul>
                                                <?php foreach ($child_names as $child_name): ?>
                                                    <li>  <span><?php echo $child_name['child_name']; ?></span> </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else: ?>
                                            <p class="text-muted font-13"> <span class="m-l-15">No Data Found</span> </p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </ul>
                            <div class="button-list m-t-20">
                                <button type="button" class="btn btn-facebook waves-effect waves-light">
                                    <i class="fa fa-facebook"></i>
                                </button>
                                <button type="button" class="btn btn-twitter waves-effect waves-light">
                                    <i class="fa fa-twitter"></i>
                                </button>
                                <button type="button" class="btn btn-linkedin waves-effect waves-light">
                                    <i class="fa fa-linkedin"></i>
                                </button>
                                <button type="button" class="btn btn-dribbble waves-effect waves-light">
                                    <i class="fa fa-dribbble"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="profile-detail card-box">
                        <div>
                            <h4 class="text-uppercase font-600 select-product-title"><strong>Selected Product</strong><i class="fa fa-pencil" aria-hidden="true" data-toggle="modal" data-target="#full-width-modal"></i></h4>
                            <ul class="list-inline status-list m-t-20">
                                <div class="text-left select-product-available">
                                    <p class="text-muted font-13"><strong>Selectd Product : </strong> <span><?php echo sizeof($sel_product); ?></span></p>
                                    <p class="text-muted font-13"><strong>Available Product :</strong><span><?php echo sizeof($product_array01); ?></span></p>
                                </div>
                            </ul>
                            <div class="selected-product nicescroll">
                                <?php foreach ($sel_product as $key => $value) { ?>
                                    <hr>
                                    <ul class="list-inline status-list m-t-20">
                                        <div class="text-left">
                                            <div class="select-product-image"><img src="<?php echo site_url() . '/assets/crm_image/products/' . $value['product_image']; ?>"></div>
                                            <div class="select-product-image-desc">
                                                <p class="text-muted font-13"><strong>Product ID :</strong><span class="m-l-15"><?php echo $value['product_id']; ?></span></p>
                                                <p class="text-muted font-13"><strong>Product Name : </strong> <span class="m-l-15"><?php echo $value['product_name']; ?></span></p>
                                                <p class="text-muted font-13"><strong>Product Type : </strong> <span class="m-l-15"><?php echo $value['product_type']; ?></span></p>
                                                <p class="text-muted font-13"><strong>Product Coverage : </strong> <span class="m-l-15"><?php echo $value['product_coverage']; ?></span></p>
                                            </div>
                                        </div>
                                    </ul>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="profile-files card-box">
                        <h4 class="text-uppercase font-600 select-product-title"><strong>Files</strong></h4>
                        <div class="verificationFiles-wapper">
                            <?php if (!empty($memberfiles['verificationFiles'])): ?>
                                <h5 class="text-uppercase font-400">Verification Files</h5>
                                <ul class="list-inline status-list m-t-20 file_listing">
                                    <?php foreach ($memberfiles['verificationFiles'] as $verificationFile): ?>
                                        <li class="file_name_verfication profile_file">
                                            <div class="li_inner_one"><?php echo str_replace(".mp3", " ", $verificationFile['script']); ?></div>
                                            <div class="li_inner_two"> .MP3 </div>
                                            <div class="li_inner_three"> <?php
                                                $createDate = new DateTime($verificationFile['created_date']);
                                                echo $createDate->format('m-d-Y');
                                                ?> </div>
                                            <div class="li_inner_four"><div style="cursor: pointer" class="file_edit" data-scriptid="<?php echo $verificationFile['script_id']; ?>" data-action="verificationFile" data-member="<?php echo urlencode(base64_encode($verificationFile["user_id"])); ?>"> <i class="fa fa-pencil" > </i> </div></div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                        <div class="other-files-wapper m-t-20">
                            <!-- IF statement -->
                            <?php if (!empty($memberfiles['otherFiles'])): ?>
                                <h5 class="text-uppercase font-400">Other File(s)</h5>
                                <ul class="list-inline status-list m-t-20 file_listing">
                                    <?php foreach ($memberfiles['otherFiles'] as $otherFile): ?>
                                        <li class="file_name_verfication profile_file">
                                            <div class="li_inner_one"><?php
                                                $timeFinder = strpos($otherFile['file_name'], '_time_');
                                                echo substr($otherFile['file_name'], 0, $timeFinder);
                                                ?></div>
                                            <div class="li_inner_two"> <?php echo '.' . $otherFile['file_extension']; ?> </div>
                                            <div class="li_inner_three"> <?php
                                                $createDate = new DateTime($otherFile['created']);
                                                echo $createDate->format('m-d-Y');
                                                ?> </div>
                                            <div class="li_inner_four"><div style="cursor: pointer" class="file_edit" data-fileid="<?php echo $otherFile['id']; ?>" data-action="otherFiles" data-member="<?php echo urlencode(base64_encode($otherFile["member_id"])); ?>"> <i class="fa fa-pencil" > </i> </div></div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>

                            <div class="text-center m-t-20">
                                <button type="button" class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target="#panel-modal">
                                    <span class="btn-label"> <i class="fa fa-plus"></i> </span>Add</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-8">
                    <div class="card-box">
                        <form id="frm_lead_edit" method="post" enctype="multipart/form-data">
                            <div class="text-center">
                                <h3><strong>PRIMARY</strong></h3>
                            </div>
                            <div class="primary_div">
                                <div class="form-group clearfix">
                                    <input type="hidden" name="customer_id" value="<?php echo (isset($customer_id)) ? $customer_id : ''; ?>">
                                           <div class="col-lg-12">
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="fname">First Name * </label>
                                            <input type="text" id="cusfname" name="cus_first_name" class="required form-control" autocomplete="off" value="<?php echo (isset($lead_info['customer_first_name'])) ? $lead_info['customer_first_name'] : ''; ?>">
                                        </div>
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="mname">Middle Name </label>
                                            <input type="text" id="cusmname" name="cus_middle_name" class="form-control" autocomplete="off" value="<?php echo (isset($lead_info['customer_middle_name'])) ? $lead_info['customer_middle_name'] : ''; ?>">
                                        </div>
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="fname">Last Name * </label>
                                            <input type="text" id="cuslname" name="cus_last_name" class="required form-control" autocomplete="off" value="<?php echo (isset($lead_info['customer_last_name'])) ? $lead_info['customer_last_name'] : ''; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Email Address * </label>
                                        <input type="email" id="cusname" name="cus_email" class="required form-control" autocomplete="off" value="<?php echo (isset($lead_info['customer_email'])) ? $lead_info['customer_email'] : ''; ?>">
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="mname">Phone Number * </label>
                                        <input type="text" id="cuscontact" name="cus_contact" class="required form-control custom_phone_number_marks" autocomplete="off" value="<?php echo (isset($lead_info['customer_phone_number'])) ? $lead_info['customer_phone_number'] : ''; ?>">
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Date Of Birth * </label>
                                        <div class="date-picker-div">
                                            <input class="form-control dtpicker" placeholder="mm/dd/yyyy" id="datepicker-autoclose" name="cus_dob" type="text" value="<?php echo (isset($lead_info['customer_dob']) && !empty($lead_info['customer_dob'])) ? date('m/d/Y', strtotime($lead_info['customer_dob'])) : ''; ?>">
                                            <span class="input-group-addon bg-custom b-0 text-white"><i class="icon-calender"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="col-lg-8">
                                        <label for="fname">Address * </label>
                                        <input type="text" id="cusaddress" name="cus_address" class="required form-control" autocomplete="off" value="<?php echo (isset($lead_info['customer_address'])) ? $lead_info['customer_address'] : ''; ?>">
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Apartment, Suite, etc. </label>
                                        <input type="text" id="cussubaddress" name="cus_sub_address" class="form-control" autocomplete="off" value="<?php echo (isset($lead_info['customer_address_details'])) ? $lead_info['customer_address_details'] : ''; ?>">
                                    </div>
                                </div>
                                <div class="form-group clearfix">

                                    <div class="col-lg-4 input_wrapper">

                                        <label for="mname">State * </label>

                                        <select class="form-control required" id="user_state" name="cus_state" onchange="selectCity(this.value, 'user_city', 'cus_city')">

                                            <option value="0">Select State</option>

                                            <?php foreach ($state as $key => $value) { ?>

                                                <option value="<?php echo $value['state_code']; ?>" <?php echo ( $value['state_code'] == $lead_info['customer_state']) ? 'selected' : ''; ?>><?php echo $value['state']; ?></option>

                                            <?php } ?>

                                        </select>

                                    </div>

                                    <div class="col-lg-4 input_wrapper">

                                        <label for="fname">City * </label>

                                        <select class="form-control required selcity" id="user_city" name="cus_city">

                                            <?php foreach ($city_pri as $key => $value) { ?>

                                                <option value="<?php echo $value['city']; ?>" <?php echo ( $value['city'] == $lead_info['customer_city']) ? 'selected' : ''; ?>><?php echo $value['city']; ?></option>

                                            <?php } ?>

                                        </select>

                                    </div>

                                    <div class="col-lg-4 input_wrapper">

                                        <label for="fname">Zip Code * </label>

                                        <input type="text" id="cuszip" name="cus_zip" class="required form-control custome_zipcode" autocomplete="off" value="<?php echo (isset($lead_info['customer_zipcode'])) ? $lead_info['customer_zipcode'] : ''; ?>">

                                    </div>

                                </div>

                                <div class="form-group clearfix">

                                    <div class="col-lg-4 input_wrapper">

                                        <label for="fname">Social Security Number * </label>

                                        <input type="text" id="cussecuritynumber" name="cus_security_number" class="required form-control securitynumber" autocomplete="off" value="<?php echo (isset($lead_info['customer_social_security_number'])) ? $lead_info['customer_social_security_number'] : ''; ?>" placeholder="XXX - XX - XXXX">

                                    </div>

                                    <div class="col-lg-4 input_wrapper">

                                        <label for="customer_weight">Customer Weight </label>

                                        <input type="text" id="customer_weight" name="customer_weight" class="form-control customer_weight" autocomplete="off" value="<?php echo (isset($lead_info['customer_weight'])) ? $lead_info['customer_weight'] : ''; ?>">

                                    </div>

                                    <div class="col-lg-4 input_wrapper">

                                        <label for="customer_gender">Customer Gender  </label> <br/>

                                        <input type="radio" name="gender" class="gendercheckbox" value="male" <?php echo ($lead_info['customer_gender'] == 'male') ? 'checked' : ''; ?>> Male

                                        <input type="radio" name="gender" class="gendercheckbox" value="female" <?php echo ($lead_info['customer_gender'] == 'female') ? 'checked' : ''; ?>> Female

                                    </div>

                                    <!--                                    <div class="col-lg-4" id="upload-btn">

                                                                            <div class="input_wrapper">

                                                                                <label>Verification script</label>

                                                                                <input type="file" name="verification_script" class="filestyle" data-buttonname="btn-default" onchange="Validateverification(this);">

                                                                                <div class="error_verification" style="font-style: italic; color: #f6504d; margin-top: 8px; display: none;">Please select only .mp3 file format.</div>

                                                                            </div>

                                                                        </div>-->

                                </div>

                                <!--</div>-->
                            <div id="spouse_div" style="display:none">
                                <div class="text-center">
                                    <h3><strong>SPOUSE</strong>
                                        <a class="btn btn-primary pull-right remove-spouse"><i class="fa fa-times"></i></a>
                                    </h3>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">First Name </label>
                                        <input type="text" id="fname" name="spouse_first_name" class="form-control" autocomplete="off" value="<?php echo (isset($lead_member_spouse_info['customer_spouse_first_name'])) ? $lead_member_spouse_info['customer_spouse_first_name'] : ''; ?>">
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="mname">Middle Name </label>
                                        <input type="text" id="mname" name="spouse_middle_name" class="form-control" autocomplete="off" value="<?php echo (isset($lead_member_spouse_info['customer_spouse_middle_name'])) ? $lead_member_spouse_info['customer_spouse_middle_name'] : ''; ?>">
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Last Name </label>
                                        <input type="text" id="lname" name="spouse_last_name" class="form-control" autocomplete="off" value="<?php echo (isset($lead_member_spouse_info['customer_spouse_last_name'])) ? $lead_member_spouse_info['customer_spouse_last_name'] : ''; ?>">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Email Address </label>
                                        <input type="Email" id="fname" name="spouse_email_address" class="form-control" autocomplete="off" value="<?php echo (isset($lead_member_spouse_info['customer_spouse_email'])) ? $lead_member_spouse_info['customer_spouse_email'] : ''; ?>">
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="mname">Phone Number </label>
                                        <input type="text" id="mname" name="spouse_phone_no" class="form-control custom_phone_number_marks" autocomplete="off" value="<?php echo (isset($lead_member_spouse_info['customer_spouse_phone_number'])) ? $lead_member_spouse_info['customer_spouse_phone_number'] : ''; ?>">
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Date Of Birth </label>
                                        <div class="date-picker-div">
                                            <input class="form-control dtpicker" placeholder="mm/dd/yyyy" id="datepicker-autoclose" name="spouse_dob" type="text" value="<?php echo (isset($lead_member_spouse_info['customer_spouse_dob']) && !empty($lead_member_spouse_info['customer_spouse_dob'])) ? date('m/d/Y', strtotime($lead_member_spouse_info['customer_spouse_dob'])) : ''; ?>">
                                            <span class="input-group-addon bg-custom b-0 text-white"><i class="icon-calender"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="col-lg-8">
                                        <label for="fname">Address </label>
                                        <input type="text" id="fname" name="spouse_address" class="form-control" autocomplete="off" value="<?php echo (isset($lead_member_spouse_info['customer_spouse_address'])) ? $lead_member_spouse_info['customer_spouse_address'] : ''; ?>">
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Apartment, Suite, etc. </label>
                                        <input type="text" id="lname" name="spouse_sub_address" class="form-control" autocomplete="off" value="<?php echo (isset($lead_member_spouse_info['customer_spouse_address_details'])) ? $lead_member_spouse_info['customer_spouse_address_details'] : ''; ?>">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="mname">State </label>
                                        <select class="form-control" id="spo_user_state" name="customer_spouse_state" onchange="selectCity(this.value, 'spo_user_city', 'spouse_city')">
                                            <option value="">Select State</option>
                                            <?php foreach ($state as $key => $value) { ?>
                                                <option value="<?php echo $value['state_code']; ?>" <?php echo ( $value['state_code'] == (isset($lead_member_spouse_info['customer_spouse_state'])) ? $lead_member_spouse_info['customer_spouse_state'] : '' ) ? 'selected' : ''; ?>><?php echo $value['state']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">City  </label>
                                        <select class="form-control" id="spo_user_city" name="spouse_city">
                                            <?php foreach ($city_sop as $key => $value) { ?>
                                                <option value="<?php echo $value['city']; ?>" <?php echo ( $value['city'] == $lead_member_spouse_info['customer_spouse_city']) ? 'selected' : ''; ?>><?php echo $value['city']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Zip Code </label>
                                        <input type="text" id="lname" name="spouse_zipcode" class="form-control custome_zipcode" autocomplete="off" value="<?php echo (isset($lead_member_spouse_info['customer_spouse_zipcode'])) ? $lead_member_spouse_info['customer_spouse_zipcode'] : ''; ?>">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Social Security Number </label>
                                        <input type="text" id="fname" name="spouse_ssn" class="form-control securitynumber" autocomplete="off" value="<?php echo (isset($lead_member_spouse_info['customer_spouse_social_security_number'])) ? $lead_member_spouse_info['customer_spouse_social_security_number'] : ''; ?>" placeholder="XXX - XX - XXXX">
                                    </div>
                                </div>
                            </div>
                            <div class="div_child_block" style="display:none">
                                    <script type="text/javascript">
                                        var key = 0;
                                    </script>
                                    <?php echo $add_child_block_html; ?>
                            </div>
                                <ul class="list-inline status-list m-t-20">
                                    <div class="text-center">
                                        <div class="button-list">
                                         <!--<button type="button" id="add_child" class="btn btn-success waves-effect waves-light">
                                             <span class="btn-label"><i class="fa fa-plus"></i>
                                             </span>Add Child</button> -->
                                            <button type="button"  class="btn btn-success waves-effect waves-light new-spouse">Add New Spouse</button>
                                            <button type="button" class="btn btn-success waves-effect waves-light new-child">Add New Child</button>
                                        </div>
                                    </div>
                                </ul>
                                <ul class="list-inline status-list m-t-20">
                                    <div class="text-center">
                                        <div class="button-list">
                                            <button type="button" id="add_child" class="btn btn-success waves-effect waves-light">
                                            <span class="btn-label"><i class="fa fa-plus"></i>
                                            </span>Add Child</button>
                                        </div>
                                    </div>
                                </ul>
                                <div class="form-group bottom-control text-center">
                                    <button type="submit" class="btn btn-success" value="member_vari" name="member_vari">Save</button>
                                    <a class="btn btn-default waves-effect waves-light" href="<?= base_url() . 'agent/members' ?>"> <span class="btn-label"><i class="fa fa-arrow-left"></i></span>Back</a>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="full-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="full-width-modalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-full select-product-model">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                    <h4 class="modal-title" id="full-width-modalLabel">Add Products in Client's Dashboard For Recommendation</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="customerid" value=<?php echo $userid; ?>>
                    <?php if (!empty($product_array01)) { ?>
                        <?php
                        foreach ($product_array01 as $key => $product01):
                            $is_disable = '';
                            $remove_disable = 'disabled';
                            if (in_array($product01['global_product_id'], $res_sel_column)) {
                                $is_disable = 'disabled';
                                $remove_disable = '';
                            }
                            ?>
                            <?php if (($key) % 4 == 0 || $key == 0) { ?>
                                <div class="row">
                                <?php } ?>
                                <div class ="col-md-3 col-sm-6 col-xs-12 text-center">
                                    <div class="site-image"><img src="<?php echo site_url() . '/assets/crm_image/products/' . $product01['product_image']; ?>"></div>
                                    <div class="pro_info"> <label>Product Name: </label> <span><?php echo $product01['product_name']; ?></span></div>
                                    <div class="pro_info"> <label>Product Price: </label><span><?php echo $product01['product_price']; ?></span></div>
                                    <div class="pro_info"> <label>Product Coverage: </label> <span><?php echo $product01['product_coverage']; ?></span></div>
                                    <div class="pro_info"> <label>Plan ID: </label> <span><?php echo $product01['plan_id']; ?></span></div>
                                    <div class="button-list pro_info">
                                        <button type="button" class="btn btn-success waves-effect waves-light product-add pro-add-<?= $key ?>" data-id="<?= $key ?>" data-custom-value-productid="<?php echo $product01['global_product_id']; ?>" data-custom-value-memberid="<?php echo $userid; ?>" <?php echo $is_disable; ?>>
                                            <span class="btn-label"><i class="fa fa-plus"></i>
                                            </span>Add</button>
                                        <button type="button" class="btn btn-danger waves-effect waves-light product-remove pro-remove-<?= $key ?>" data-id="<?= $key ?>" data-custom-value-productid="<?php echo $product01['global_product_id']; ?>" data-custom-value-memberid="<?php echo $userid; ?>" <?php echo $remove_disable; ?>  >
                                            <span class="btn-label"><i class="fa fa-times"></i>
                                            </span> Remove
                                        </button>
                                    </div>
                                </div>
                                <?php if (($key + 1) % 4 == 0 || count($product_array01) == $key + 1) { ?>
                                </div>
                            <?php } ?>
                            <?php
                        endforeach;
                    }
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light save-changes">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <!-- -->
    <div id="product-detail-popup" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog" style="width:70%">
            <div class="modal-content">
                <div class="modal-body" id="product-detail">
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div id="add-product-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="full-width-modalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-full select-product-model">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="full-width-modalLabel">Please Select Product</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="customerid" value=<?php echo $userid; ?>>
                    <?php if (!empty($product_array)) { ?>
                        <?php
                        foreach ($product_array as $key => $product):
                            //pr_arr($product);
                            $is_disable = '';
                            $remove_disable = 'disabled';
                            if (in_array($product['global_product_id'], $member_product_ids)) {
                                $is_disable = 'disabled';
                                $remove_disable = '';
                            }
                            ?>
                            <?php if (($key) % 4 == 0 || $key == 0) { ?>
                                <div class="row">
                                <?php } ?>
                                <div class ="col-md-3 col-sm-6 col-xs-12 text-center">
                                    <div class="site-image"><img src="<?php echo site_url() . '/assets/crm_image/products/' . $product['product_image']; ?>"></div>
                                    <div class="pro_info"> <label>Product Name: </label> <span><?php echo $product['product_name']; ?></span></div>
                                    <div class="pro_info"> <label>Product Price: </label><span><?php echo $product['product_price']; ?></span></div>
                                    <div class="pro_info"> <label>Product Coverage: </label> <span><?php echo $product['product_coverage']; ?></span></div>
                                    <div class="pro_info"> <label>Plan ID: </label> <span><?php echo $product['plan_id']; ?></span></div>
                                    <div class="button-list pro_info">
                                        <button type="button" class="btn btn-success waves-effect waves-light product-purchase-add pro-purchase-add-<?= $key ?>" data-id="<?= $key ?>" data-custom-value-productid="<?php echo $product['global_product_id']; ?>" data-custom-value-memberid="<?php echo $userid; ?>" <?php echo $is_disable; ?>>
                                            <span class="btn-label"><i class="fa fa-plus"></i>
                                            </span>Add</button>
                                        <button type="button" class="btn btn-danger waves-effect waves-light product-purchase-remove pro-purchase-remove-<?= $key ?>" data-id="<?= $key ?>" data-custom-value-productid="<?php echo $product['global_product_id']; ?>" data-custom-value-memberid="<?php echo $userid; ?>" <?php echo $remove_disable; ?>  >
                                            <span class="btn-label"><i class="fa fa-trash"></i>
                                            </span> Remove
                                        </button>
                                        <button type="button" class="btn btn-warning waves-effect waves-light product-purchase-cancel pro-purchase-cancel-<?= $key ?>" data-id="<?= $key ?>" data-custom-value-productid="<?php echo $product['global_product_id']; ?>" data-custom-value-memberid="<?php echo $userid; ?>" <?php echo $remove_disable; ?>  >
                                            <span class="btn-label"><i class="fa fa-times"></i>
                                            </span> Cancel
                                        </button>
                                    </div>
                                </div>
                                <?php if (($key + 1) % 4 == 0 || count($product_array) == $key + 1) { ?>
                                </div>
                            <?php } ?>
                            <?php
                        endforeach;
                    }
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info waves-effect waves-light" data-toggle="modal" data-target="#custom-add-product-modal">Add New Product</button>
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light save-changes">Save changes</button>
                </div>

            </div><!-- /.modal-content -->

        </div><!-- /.modal-dialog -->

    </div><!-- /.modal -->
    <!-- End Add Product -->
    <div id="custom-add-product-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog" style="width:35%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                    <h4 class="modal-title" id="custom-width-modalLabel">Add New Product</h4>
                </div>
                <div class="modal-body">
                    <form id="add_product_form" method="post" action="<?php echo site_url('agent/checkout/filter') ?>" class="data-parsley-validate novalidate">
                        <div class="form-group">
                            <label for="name">Select Vendor&nbsp;*</label>
                            <select name="vendor" class="form-control">
                                <option value="">Select Vendor</option>
                                <?php foreach ($vendors as $vendor): ?>
                                    <?php
                                        $select = '';
                                        if( isset($product['product_vendor']) && $vendor['vendor_id'] == $product['product_vendor']){
                                            $select = 'selected="selected"';
                                        }
                                    ?>
                                    <option value="<?= $vendor['vendor_id']; ?>" <?php echo $select; ?>><?= $vendor['vendor_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Product Category&nbsp;*</label>
                             <select class="form-control required" name="catrgory" id="catrgory">
                                <option value="" selected="">Select Category</option>
                                <option value="Medicare">Medicare</option>
                                <option value="Health">Health</option>
                                <option value="Life">Life</option>
                                <option value="Supplemental">Supplemental</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Product Type&nbsp;*</label>
                            <select class="form-control required" name="product_type" id="product_type">
                                <option value="">Select Product Type</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Coverage Type&nbsp;*</label>
                            <select name="coveragetype" class="form-control">
                                <option value="">Select Coverage</option>
                                <option value="Member" >Member</option>
                                <option value="Member_Spouse">Member + Spouse</option>
                                <option value="Member_Child">Member + Child</option>
                                <option value="Member_Children">Member + Children</option>
                                <option value="Family" >Family</option>
                            </select>
                        </div>
                        <div class="form-group clearfix">
                            <label class="control-label " for="product_name">Product Name&nbsp;*</label>
                            <div class="">
                                <input id="product_name" name="product_name" type="text" class="required form-control" value="">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="control-label " for="product_price">Product Price&nbsp;*</label>
                            <div class="">
                                <input id="product_price" name="product_price" type="number" class="required form-control price_input_mask" value="">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <label class="control-label " for="enrollment_fee">Enrollment Fee&nbsp;*</label>
                            <div class="">
                                <input id="enrollment_fee" data-role="tagsinput" name="enrollment_fee" type="Number" class="required form-control" value="">
                            </div>
                        </div>
                        <button type="submit" style="display: none;" id="form-submit2">Submit</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect waves-light add_new_product"  onclick="jQuery('#add-product-submit').trigger('click')">Submit<i class="spinner fa fa-cog fa-spin fa-fw margin-bottom" style="display: none;"></i></button>
                    <button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <!-- Payment Option Modal -->

    <div id="payment-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog" style="width:55%;">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <form onsubmit="manage_payment_info()" method="post" id="payment_info">
                            <input type="hidden" name="payment_id" value="<?php echo (isset($billing_info['info_id'])) ? $billing_info['info_id'] : ''; ?>">
                            <input type="hidden" name="member_id" value="<?php echo (isset($customer_id)) ? $customer_id : ''; ?>">
                            <div class="">
                                <ul class="nav nav-pills">
                                    <?php
                                    $payment_type = 1;
                                    $class_1 = "active";
                                    $class_2 = "";
                                    if (isset($billing_info['payment_type']) && $billing_info['payment_type'] == 1) {
                                        $payment_type = 1;
                                        $class_1 = "active";
                                    } else if (isset($billing_info['payment_type']) && $billing_info['payment_type'] == 2) {
                                        $payment_type = 2;
                                        $class_1 = "";
                                        $class_2 = "active";
                                    }

                                    ?>
                                    <li class="<?= $class_1 ?>">
                                        <a href="#">
                                            <p><input type="radio" name="payment_type" class="payment_type" value="1" <?php
                                                if ($payment_type == 1) {
                                                    echo "checked";
                                                } else {
                                                    echo "checked";
                                                }
                                                ?> /></p>
                                            <span><i class="fa fa-credit-card" aria-hidden="true"></i></span>
                                            Credit Card</a>
                                    </li>
                                    <li class="<?= $class_2 ?>"><a href="#"><p><input type="radio" name="payment_type" class="payment_type" value="2" <?php
                                                if ($payment_type == 2) {
                                                    echo "checked";
                                                }
                                                ?> /></p><span><i class="fa fa-credit-card" aria-hidden="true"></i></span>Paypal</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div id="home" class="tab-pane fade in active">
                                        <div class="credit-card-details">
                                            <h3>Credit Card Details</h3>
                                            <div class="form-group">
                                                <label>CARD NUMBER</label>
                                                <div class="detail-box card-valid">
                                                    <input type="text" placeholder="123 123" class="form-control" name="card_number" id="card_number" value="<?php echo (isset($billing_info['card_number'])) ? $billing_info['card_number'] : ''; ?>"/>
                                                    <p><i class="fa fa-credit-card" aria-hidden="true"></i></p>
                                                </div>
                                            </div>
                                            <ul>
                                                <li>
                                                    <label>EXPIRATION MONTH</label>
                                                    <div class="detail-box month-valid">
                                                        <input type="text" placeholder="123 123" class="form-control" name="exp_month" id="exp_month" value="<?php echo (isset($billing_info['exp_month'])) ? $billing_info['exp_month'] : ''; ?>"/>
                                                        <p><i class="fa fa-clock-o" aria-hidden="true"></i></p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <label>EXPIRATION YEAR</label>
                                                    <div class="detail-box year-valid">
                                                        <input type="text" placeholder="123 123" class="form-control" name="exp_year" id="exp_year" value="<?php echo (isset($billing_info['exp_year'])) ? $billing_info['exp_year'] : ''; ?>"/>
                                                        <p><i class="fa fa-clock-o" aria-hidden="true"></i></p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <label>SECURITY CODE</label>
                                                    <div class="detail-box code-valid">
                                                        <input type="text" placeholder="123 123" class="form-control" name="s_code" id="s_code" value="<?php echo (isset($billing_info['s_code'])) ? $billing_info['s_code'] : ''; ?>"/>
                                                        <p><i class="fa fa-lock" aria-hidden="true"></i></p>
                                                    </div>
                                                </li>
                                            </ul>
                                            <div class="proceed-button">
                                                <button type="submit" value="check_my">PROCEED TO SECURE PAYMENT<span><i class="fa fa-lock" aria-hidden="true"></i></span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- End Payment Option Modal -->



    <div id="verification_script" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog" style="width:55%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                    <h4 class="modal-title" id="custom-width-modalLabel">Upload Product Verification Script </h4>
                </div>
                <form id="verification_script" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <h4 class="text-uppercase font-600"><strong>Product(s)</strong></h4>
                        <div id="popup_product" class="popup_product">
                            <div class="loader"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" name="upload" value="upload" class="btn btn-primary waves-effect waves-light">Upload</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div id="panel-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-color panel-primary">
                    <div class="panel-heading">
                        <button type="button" class="close m-t-5" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 class="panel-title">Upload File <?php echo (isset($lead_info['customer_first_name'])) ? 'For ' . $lead_info['customer_first_name'] : ''; ?></h3>
                    </div>
                    <div class="panel-body">
                        <form id="frm_member_file_upload" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-4 input_wrapper">
                                    <label for="file_name">First Name * </label>
                                    <input type="text" id="file_name" name="file_name" class="required form-control">
                                </div>
                                <div class="col-lg-8 input_wrapper">
                                    <label for="file_details">File Description</label>
                                    <input type="text" id="file_details" name="file_description" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 input_wrapper m-t-20">
                                    <input type="file" class="filestyle required" name="member_file" data-iconname="fa fa-cloud-upload">
                                </div>
                            </div>
                            <div class="modal-footer m-t-20">
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                                <button type="submit" name="file_upload" value="file_upload" class="btn btn-primary waves-effect waves-light">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div id="script_editor" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-color panel-primary">
                    <div class="panel-heading">
                        <button type="button" class="close m-t-5" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 class="panel-title">Update File <?php echo (isset($lead_info['customer_first_name'])) ? 'For ' . $lead_info['customer_first_name'] : ''; ?></h3>
                    </div>
                    <div class="panel-body">
                        <form id="edit_file" class="file-edit-form" method="post" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="edit-file-wapper m-b-20">
                                    <div id="from_place">
                                        <div class="small-loader loader"> </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary waves-effect waves-light" value="submit" name="file_edit_box">Update File</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/additional-methods.js"></script>
    <script type="text/javascript" src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
    <script>

                            $(document).ready(function () {

                               // $("#spouse_div").hide();

                                $('form').parsley();

                                $.fn.niceScroll && $(".nicescroll").niceScroll({cursorcolor: '#98a6ad', cursorborder: '#98a6ad', cursorwidth: '5px', cursorborderradius: '5px'});

                                //--shivani
                                $(document).on('click', '.new-spouse', function () {
                                    $("#spouse_div").show();
                                    $(".new-spouse").prop("disabled",true);
                                });

                                $(document).on('click', '.new-child', function () {
                                    $(".div_child_block").show();
                                    $(".new-child").prop("disabled",true);
                                });

                                $(document).on('click', '.add_new_product', function () {
                                    var validation = true;
                                    var $form = $('#add_product_form');
                                    $form.parsley().validate();
                                    vendor_id = $("select[name='vendor']").val();
                                    product_type = $("select[name='product_type']").val();
                                    product_category = $("select[name='catrgory']").val();
                                    coverage_type = $("select[name='coveragetype']").val();
                                    product_name = $("input[name='product_name']").val();
                                    product_price = $("input[name='product_price']").val();
                                    product_price = product_price.replace(/[^0-9\.]/g, '');
                                    enrollment_fee = $("input[name='enrollment_fee']").val();
                                    lead_id = $('#lead_id').val();
                                    console.log($("#enrollment_fee").val());
                                    $.ajax({
                                        url: '<?php echo base_url() ?>agent/products/add_quick_product',
                                        type: 'POST',
                                        data: {vendor_id: vendor_id, product_type: product_type,coverage_type:coverage_type,product_name:product_name,product_price:product_price,enrollment_fee:enrollment_fee, lead_id:lead_id, product_category:product_category},
                                       // data: {vendor_id: vendor_id, product_type: product_type,coverage_type:coverage_type,product_name:product_name,product_price:product_price,enrollment_fee:enrollment_fee, lead_id:lead_id},
                                        success: function (data) {
                                            member_id = data.member_id;
                                            product_id = data.global_product_id;
                                            added_by = data.added_by;
                                            swal({
                                                title: "Are you sure?",
                                                text: "You want to move this product into member product.",
                                                type: "success",
                                                showCancelButton: true,
                                                cancelButtonClass: 'btn-white btn-md waves-effect',
                                                confirmButtonClass: 'btn-danger btn-md waves-effect waves-light',
                                                confirmButtonText: 'Yes!'

                                            }, function (isConfirm) {
                                                if (isConfirm) {
                                                    $.ajax({
                                                        method: "POST",
                                                        url: '<?= base_url() . 'agent/products/move_member_product' ?>',
                                                        data: {member_id: member_id,product_id:product_id,added_by:added_by},
                                                        success: function (data) {
                                                            swal("success", data, "success");
                                                            $('#custom-add-product-modal').modal('hide');
                                                        }
                                                    });
                                                }
                                            });
                                        },
                                    });
                                });

                                $(document).on('click', '#product-popup-button', function () {
                                    product_id = $(this).data('productid');
                                    member_product_id = $(this).data('memberproduct');
                                    $.ajax({
                                        method: "POST",
                                        url: '<?= base_url() . 'agent/members/product_detail' ?>',
                                        data: {product_id: product_id, member_product_id:member_product_id},
                                        success:
                                            function (data) {
                                                console.log(data);
                                                $("#product-detail").html(data);
                                                $('#product-detail-popup').modal('show');
                                            }
                                    });
                                });

                                jQuery(document).on('change', '#catrgory', function(){
                                    var value = $(this).val();
                                    if (value == 'Medicare')
                                    {
                                        var options='';
                                        options += "<option value=''>Select Product Type</option>";
                                        options += "<option value='Part_A'>Part A</option>";
                                        options += "<option value='Part_B'>Part B</option>";
                                        options += "<option value='Medicare_Advantage'>Medicare Advantage</option>";
                                        options += "<option value='Part_D'>Part D</option>";
                                        options += "<option value='Supplemental_Plan'>Supplemental Plan</option>";
                                    }
                                    else if(value == 'Health')
                                    {
                                        var options='';
                                        options += "<option value=''>Select Product Type</option>";
                                        options += "<option value='Major_Medical'>Major Medical</option>";
                                        options += "<option value='Short_Term_Medical'>Short Term Medical</option>";
                                        options += "<option value='Medical_Indemnity_Insurance'>Medical Indemnity Insurance</option>";
                                    }
                                    else if (value == 'Life')
                                    { 
                                        var options='';
                                        options += "<option value=''>Select Product Type</option>";
                                        options += "<option value='Term'>Term</option>";
                                        options += "<option value='Permanent'>Permanent</option>";
                                        options += "<option value='Whole'>Whole</option>";
                                        options += "<option value='Universal'>Universal</option>";
                                        options += "<option value='Variable'>Variable</option>";
                                        options += "<option value='Variable_Universal'>Variable Universal</option>";
                                        options += "<option value='Survivorship'>Survivorship</option>";
                                        options += "<option value='Final_Expense'>Final Expense</option>";
                                        options += "<option value='Accidental_Death'>Accidental Death</option>";
                                    }
                                    else if(value == 'Supplemental')
                                    {
                                        var options='';
                                        options += "<option value=''>Select Product Type</option>";
                                        options += "<option value='Accidental_Insurance'>Accidental Insurance</option>";
                                        options += "<option value='Critical_Illness_Insurance'>Critical Illness Insurance</option>";
                                        options += "<option value='Cancer_Insurance'>Cancer Insurance</option>";
                                        options += "<option value='Hospital_Insurance'>Hospital Insurance</option>";
                                        options += "<option value='Short_Term_Disability'>Short Term Disability</option>";
                                        options += "<option value='Medical_Discount_Benefits'>Medical Discount Benefits</option>";
                                        options += "<option value='Dental_Insurance'>Dental Insurance</option>";
                                        options += "<option value='Dental_Discount_Benefits'>Dental Discount Benefits</option>";
                                        options += "<option value='Vision_Insurance'>Vision Insurance</option>";
                                        options += "<option value='Vision_Discount_Benefits'>Vision Discount Benefits</option>";
                                        options += "<option value='Prescription_Insurance'>Prescription Insurance</option>";
                                        options += "<option value='Prescription_Discount_Benefits'>Prescription Discount Benefits</option>";
                                        options += "<option value='Telemedicine'>Telemedicine</option>";
                                        options += "<option value='Pet_Insurance'>Pet Insurance</option>";
                                        options += "<option value='Travel_Insurance'>Travel Insurance</option>";
                                    }
                                    $('select[name="product_type"]').empty();
                                    $('select[name="product_type"]').append( options );
                                });
                                //--end 


                                $(document).on('click', '.add-new-product', function () {
                                    var controller = $('#controller_name').val();
                                    var method = $('#method_name').val();
                                    var lead_id = $('#lead_id').val();
                                    var url = "<?php echo base_url() ?>product/add_product?con=" + controller + "&met=" + method + "&lead=" + lead_id;
                                    window.location.href = url;
                                });

                                $(document).on('click', ".btn_product_warning", function () {
                                    var product_id = $(this).attr("data-productid");
                                    var memberproduct = $(this).attr("data-memberproduct");
                                    $.ajax({
                                        url: '<?php echo base_url() ?>agent/members/product_popup',
                                        type: 'POST',
                                        data: {product_id: product_id, memberproduct: memberproduct},
                                        success: function (data) {
                                            $('#popup_product').html(data);
                                        },
                                    });
                                });
                                $(document).on('click', '#add_child', function () {
                                   length = $(".div_child_block .child_div").length;
                                    if ((length+1) <= 10)
                                    {
                                        var html = <?php echo json_encode($this->load->view("agent/lead/get_child", $state, true)); ?>;
                                        html = html.replace(/0/g, key);
                                        $(document).find(".div_child_block").append(html);
                                        $(".div_child_block").show();
                                        $(document).find('.dtpicker').datepicker({
                                            autoclose: true,
                                            todayHighlight: true,
                                            Format: 'yyyy-mm-dd',
                                        });
                                    }
                                });
                            });
                            function selectCity(state, id, name, city = null) {
                                var state = state;
                                $('#' + id).empty();
                                if (state == '')
                                {
                                    alert("Select State");
                                } else {
                                    $('.loader-select-city').show();
                                    $.ajax({
                                        url: '<?php echo base_url() ?>agent/members/newcity',
                                        type: 'POST',
                                        data: {ustid: state, city: city, id: id, name: name},
                                        success: function (data) {
                                            $('#' + id).html(data);
                                            $('.loader-select-city').hide();
                                        },
                                    });
                                }
                            }

                            function onchange_city(ele) {
                                var parent = jQuery(ele).parent('div');
                                var state = jQuery(ele).val();
                                $('.loader-select-city').show();
                                jQuery.ajax({
                                    url: '<?php echo base_url() ?>/agent/leads/getcity',
                                    type: 'POST',
                                    data: {'sopstid': state},
                                    success: function (data) {
                                        jQuery(parent.next('div').find('select')).html(data);
                                        $('.loader-select-city').hide();
                                    },
                                });
                            }

                            $(document).on('click', '.product-add', function () {
                                var product_id = $(this).data("custom-value-productid");
                                var member_id = $(this).data("custom-value-memberid");
                                var key_id = $(this).data("id");
                                $.ajax({
                                    method: "POST",
                                    url: '<?php echo base_url() ?>agent/members/addproduct',
                                    data: {product: product_id, member: member_id},
                                    success: function (data) {
                                        console.log($(this));
                                        $(".pro-add-" + key_id).attr("disabled", 'disabled');
                                        $(".pro-remove-" + key_id).attr("disabled", false);
                                        swal("success", data, "success");
                                        $.fn.niceScroll && $(".nicescroll").niceScroll({cursorcolor: '#98a6ad', cursorborder: '#98a6ad', cursorwidth: '5px', cursorborderradius: '5px'});
                                    }
                                });
                            });

                            $(document).on('click', '.product-remove', function () {
                                var product_id = $(this).data("custom-value-productid");
                                var member_id = $(this).data("custom-value-memberid");
                                var key_id = $(this).data("id");
                                $.ajax({
                                    method: "POST",
                                    url: '<?php echo base_url() ?>agent/members/removeproduct',
                                    data: {product: product_id, member: member_id},
                                    success: function (data) {
                                        swal("success", data, "success");
                                        $(".pro-add-" + key_id).attr("disabled", false);
                                        $(".pro-remove-" + key_id).attr("disabled", true);
                                        $.fn.niceScroll && $(".nicescroll").niceScroll({cursorcolor: '#98a6ad', cursorborder: '#98a6ad', cursorwidth: '5px', cursorborderradius: '5px'});
                                    }
                                });
                            });

                            $(document).on('click', '.product-purchase-add', function () {
                                var product_id = $(this).data("custom-value-productid");
                                var member_id = $(this).data("custom-value-memberid");
                                var key_id = $(this).data("id");
                                $.ajax({
                                    method: "POST",
                                    url: '<?php echo base_url() ?>agent/members/addmemberproduct',
                                    data: {product: product_id, member: member_id, action: 'checkout'},
                                    success: function (data) {
                                        console.log($(this));
                                        $(".pro-purchase-add-" + key_id).attr("disabled", true);
                                        $(".pro-purchase-remove-" + key_id).attr("disabled", false);
                                        $(".pro-purchase-cancel-" + key_id).attr("disabled", false);
                                        swal("success", data, "success");
                                        $.fn.niceScroll && $(".nicescroll").niceScroll({cursorcolor: '#98a6ad', cursorborder: '#98a6ad', cursorwidth: '5px', cursorborderradius: '5px'});
                                    }
                                });
                            });
                            $(document).on('click', '.product-purchase-remove', function () {
                                var product_id = $(this).data("custom-value-productid");
                                var member_id = $(this).data("custom-value-memberid");
                                var key_id = $(this).data("id");
                                $.ajax({
                                    method: "POST",
                                    url: '<?php echo base_url() ?>agent/members/removememberproduct',
                                    data: {product: product_id, member: member_id},
                                    success: function (data) {
                                        swal("success", data, "success");
                                        $(".pro-purchase-add-" + key_id).attr("disabled", false);
                                        $(".pro-purchase-remove-" + key_id).attr("disabled", true);
                                        $(".pro-purchase-cancel-" + key_id).attr("disabled", true);
                                        $.fn.niceScroll && $(".nicescroll").niceScroll({cursorcolor: '#98a6ad', cursorborder: '#98a6ad', cursorwidth: '5px', cursorborderradius: '5px'});
                                    }
                                });

                            });

                            $(document).on('click', '.product-purchase-cancel', function () {
                                var product_id = $(this).data("custom-value-productid");
                                var member_id = $(this).data("custom-value-memberid");
                                var key_id = $(this).data("id");
                                $.ajax({
                                    method: "POST",
                                    url: '<?php echo base_url() ?>agent/members/cancelmemberproduct',
                                    data: {product: product_id, member: member_id},
                                    success: function (data) {
                                        swal("success", data, "success");
                                        $(".pro-purchase-add-" + key_id).attr("disabled", false);
                                        $(".pro-purchase-remove-" + key_id).attr("disabled", true);
                                        $(".pro-purchase-cancel-" + key_id).attr("disabled", true);
                                        $.fn.niceScroll && $(".nicescroll").niceScroll({cursorcolor: '#98a6ad', cursorborder: '#98a6ad', cursorwidth: '5px', cursorborderradius: '5px'});
                                    }
                                });
                            });

                            $(".remove-spouse").click(function () {
                                $("#spouse_div").hide();
                                $(".new-spouse").prop("disabled",false);
                              /*  $("input[name=spouse_first_name]").val('');
                                $("input[name=spouse_middle_name]").val('');
                                $("input[name=spouse_last_name]").val('');
                                $("input[name=spouse_email_address]").val('');
                                $("input[name=spouse_phone_no]").val('');
                                $("input[name=spouse_dob]").val('');
                                $("input[name=spouse_address]").val('');
                                $("input[name=spouse_sub_address]").val('');
                                $("#spo_user_state").prop("selectedIndex", 0);
                                $("#spo_user_city").prop("selectedIndex", -1);
                                $("input[name=spouse_zipcode]").val('');
                                $("input[name=spouse_ssn]").val('');*/
                            });

                            $(document).on('click', '.save-changes', function () {
                                window.location = "<?php echo base_url() ?>agent/members";
                            });

                            function remove_new_child(obj) {
                                $(obj).parent().parent().parent('.new-child').remove();
                            }

                            function remove_old_child(obj) {
                                /*var child_id = $(obj).data('child-id');
                                if (child_id) {
                                    $.post("<?= base_url('agent/members/remove_child/') ?>" + child_id, function (data) {
                                        if (data) {
                                            $(obj).parent().parent().parent('.old-child').remove();
                                        }
                                    });
                                } else {
                                    $(obj).parent().parent().parent('.old-child').remove();
                                }*/
                                $(".div_child_block").hide();
                                $(".new-child").prop("disabled",false);
                            }

                            $("#payment-modal .payment_type").click(function () {

                                $("#payment-modal .nav.nav-pills li").removeClass('active');

                                $(this).closest('li').addClass('active');

                            });

                            function manage_payment_info() {
                                $.ajax({
                                    method: "POST",
                                    url: '<?php echo base_url() ?>agent/members/manage_payment_info',
                                    data: $("#payment_info").serialize(),
                                    success: function (data) {
                                    }
                                });
                            }

                            $("#payment_info").validate({
                                errorClass: 'validation-error-label',
                                successClass: 'validation-valid-label',
                                highlight: function (element, errorClass) {
                                    $(element).removeClass(errorClass);
                                },
                                unhighlight: function (element, errorClass) {
                                    $(element).removeClass(errorClass);
                                },
                                validClass: "validation-valid-label",
                                ignore: [],
                                rules: {
                                    card_number: {
                                        required: true,
                                    },
                                    exp_month: {
                                        required: true
                                    },
                                    exp_year: {
                                        required: true
                                    },
                                    s_code: {
                                        required: true
                                    }
                                },
                                errorPlacement: function (error, element) {
                                    if (element[0]['id'] == "card_number") {
                                        error.insertAfter(".card-valid");
                                    } else if (element[0]['id'] == "exp_month") {
                                        error.insertAfter(".month-valid");
                                    } else if (element[0]['id'] == "exp_year") {
                                        error.insertAfter(".year-valid");
                                    } else if (element[0]['id'] == "s_code") {
                                        error.insertAfter(".code-valid");
                                    } else {
                                        error.insertAfter(element)
                                    }

                                },
                            });

                            //EDIT FILE

                            $(document).on('click', '.file_edit', function () {
                                var action = $(this).data("action");
                                if (action == "verificationFile") {
                                    var fileID = $(this).data("scriptid");
                                    var member = $(this).data('member')
                                    $('#script_editor').modal('show');
                                    $.ajax({
                                        method: "POST",
                                        url: '<?php echo base_url() ?>agent/members/member_file_data',
                                        data: {fileID: fileID, action: action, member: member},
                                        success: function (data) {
                                            $('#from_place').html(data);
                                        }
                                    });
                                } else if (action == "otherFiles") {
                                    var fileID = $(this).data("fileid");
                                    var member = $(this).data('member');
                                    $('#script_editor').modal('show');
                                    $.ajax({
                                        method: "POST",
                                        url: '<?php echo base_url() ?>agent/members/member_file_data',
                                        data: {fileID: fileID, action: action, member: member},
                                        success: function (data) {
                                            $('#from_place').html(data);
                                        }
                                    });
                                } else {
                                    console.log('Action Not Found');
                                }
                            });
    </script>

    <script>
        var _validFileExtensions = [".mp3"];
        function Validateverification(oInput) {
            if (oInput.type == "file") {
                var sFileName = oInput.value;
                if (sFileName.length > 0) {
                    var blnValid = false;
                    for (var j = 0; j < _validFileExtensions.length; j++) {
                        var sCurExtension = _validFileExtensions[j];
                        if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                            blnValid = true;
                            $(".error_verification").hide();
                            break
                        }
                    }
                    if (!blnValid) {
                        $(".error_verification").show();
                        oInput.value = "";
                        return false;
                    }
                }
            }
            return true;
        }

        $(document).on('click', '.save-changes', function () {
            window.location = "<?php echo base_url() ?>agent/members";
        });

        $('.price_input_mask').inputmask("numeric", {
            radixPoint: ".",
            groupSeparator: ",",
            digits: 2,
            autoGroup: true,
            prefix: '$ ', //Space after $, this will not truncate the first character.
            rightAlign: false,
            oncleared: function () { self.Value(''); }
        });

         jQuery('#enrollment_fee').on('beforeItemAdd', function (event, element) {
                var tag = event.item;
                tag = tag.replace(/[^0-9\.]/g, '');
                event.item = addCommas(tag);
                console.log("before", event.item);
        });

        jQuery('#enrollment_fee').on('itemAdded', function (event, element) {
            console.log(event);
            var tag = event.item;
            tag = tag.replace(/[^0-9\.]/g, 'a');
            tag = addCommas(tag);
          //  event.item = "bnfmb";
            if (tag.length <= 0) {
                var removeAble = jQuery('.label-info').length;
                jQuery('.label-info').eq((removeAble - 1)).remove();
                return false;
            }
        });

         function addCommas(nStr) 
         {
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
        }
    </script>