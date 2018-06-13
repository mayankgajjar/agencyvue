<style type="text/css">
    .validation-error-label{
        color: red !important;
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
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">


                <h4 class="page-title">Edit Member</h4>

                <ol class="breadcrumb">
                    <li><a href="<?= base_url() . 'agent/dashboard' ?>">Dashboard</a></li>
                    <li><a href="<?= base_url() . 'agent/members' ?>">Members</a></li>
                    <li class="active"><?php echo $lead_info['customer_first_name'] . ' ' . $lead_info['customer_last_name'] ?></li>
                </ol>
            </div>

            <div class="row">
                <div class="col-md-4 col-lg-3">
                    <div class="profile-detail card-box">
                        <div>
                            <img src="<?php echo base_url() ?>assets/images/users/avatar-2.jpg" class="img-circle" alt="profile-image">
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
                            <ul class="list-inline status-list m-t-20">
                                <?php foreach ($member_product_array as $prodcut) : ?>
                                    <li class="product-list">
                                        <?php
                                        if ($prodcut['is_status'] == 'Y') {
                                            $status = '<button type="button" class="btn btn-success btn-xs" data-target="#add-product-modal" data-toggle="modal"> Active </button>';
                                        } else {
                                            $status = '<button type="button" class="btn btn-danger btn-xs" data-target="#add-product-modal" data-toggle="modal"> Cancelled </button>';
                                        }
                                        ?>
                                        <?= $prodcut['product_name'] . " - " . $status; ?>
                                    </li> 
                                <?php endforeach; ?>

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
                            <h4 class="text-uppercase font-600"><strong>Dependents
                                </strong></h4>
                            <ul class="list-inline status-list m-t-20">

                                <div class="text-left">
                                    <p class="text-muted font-13"><strong>Spouse : </strong> <span class="m-l-15"></span></p>

                                    <p class="text-muted font-13"><strong>Children : 
                                        </strong><span class="m-l-15"></span></p>

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
                                    <p class="text-muted font-13"><strong>Available Product :</strong><span><?php echo sizeof($product_array); ?></span></p>
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

                </div>


                <div class="col-lg-9 col-md-8">
                    <div class="card-box">
                        <form id="frm_lead_edit" method="post" enctype="multipart/form-data">
                            <div class="text-center">
                                <h3><strong>PRIMARY</strong></h3>
                            </div>   
                            <div class="primary_div">
                                <div class="form-group clearfix">
                                    <input type="hidden" name="customer_id" value="<?php echo (isset($customer_id)) ? $customer_id : ''; ?>"
                                           <div class="col-lg-12">
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="fname">First Name * </label>
                                            <input type="text" id="cusfname" name="cus_first_name" class="required form-control" autocomplete="off" value="<?php echo (isset($lead_info['customer_first_name'])) ? $lead_info['customer_first_name'] : ''; ?>">
                                        </div>
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="mname">Middle Name * </label>
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
                                        <label for="fname">Apartment, Suite, etc.* </label>
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
                                        <input type="text" id="cussecuritynumber" name="cus_security_number" class="form-control securitynumber" autocomplete="off" value="<?php echo (isset($lead_info['customer_social_security_number'])) ? $lead_info['customer_social_security_number'] : ''; ?>" placeholder="XXX - XX - XXXX">
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="customer_weight">Customer Weight * </label>
                                        <input type="text" id="customer_weight" name="customer_weight" class="form-control customer_weight" autocomplete="off" value="<?php echo (isset($lead_info['customer_weight'])) ? $lead_info['customer_weight'] : ''; ?>">
                                    </div>

                                    <div class="col-lg-4" id="upload-btn">
                                        <div class="input_wrapper">
                                            <label>Verification script</label>
                                            <input type="file" name="verification_script" class="filestyle" data-buttonname="btn-default" onchange="Validateverification(this);">
                                            <div class="error_verification" style="font-style: italic; color: #f6504d; margin-top: 8px; display: none;">Please select only .mp3 file format.</div>
                                        </div>
                                    </div>
                                </div>
                                <!--</div>-->
                                <div class="text-center">
                                    <h3><strong>SPOUSE</strong>
                                        <a class="btn btn-primary pull-right remove-spouse"><i class="fa fa-trash"></i> Remove Spouse</a>
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
                                <div class="div_child_block">
                                    <script type="text/javascript">
                                        var key = 0;
                                    </script>
                                    <?php echo $add_child_block_html; ?>
                                </div>
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
                                    <a class="btn btn-default waves-effect waves-light" href="<?= base_url() . 'agent/members' ?>"> <span class="btn-label"><i class="fa fa-arrow-left"></i>
                                        </span>Back</a>
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
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="full-width-modalLabel">Please Select Product</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="customerid" value=<?php echo $userid; ?>>
                    <?php if (!empty($product_array)) { ?>
                        <?php
                        foreach ($product_array as $key => $product):
                            // pr_arr($product);
                            $is_disable = '';
                            $remove_disable = 'disabled';
                            if (in_array($product['global_product_id'], $res_sel_column)) {
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
                                        <button type="button" class="btn btn-success waves-effect waves-light product-add pro-add-<?= $key ?>" data-id="<?= $key ?>" data-custom-value-productid="<?php echo $product['global_product_id']; ?>" data-custom-value-memberid="<?php echo $userid; ?>" <?php echo $is_disable; ?>>
                                            <span class="btn-label"><i class="fa fa-plus"></i>
                                            </span>Add</button>
                                        <button type="button" class="btn btn-danger waves-effect waves-light product-remove pro-remove-<?= $key ?>" data-id="<?= $key ?>" data-custom-value-productid="<?php echo $product['global_product_id']; ?>" data-custom-value-memberid="<?php echo $userid; ?>" <?php echo $remove_disable; ?>  >
                                            <span class="btn-label"><i class="fa fa-times"></i>
                                            </span> Remove
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
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light save-changes">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Add Product -->
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
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light save-changes">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- End Add Product -->


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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/additional-methods.js"></script>
    <script>
                            $(document).ready(function () {
                                $('form').parsley();
                                $.fn.niceScroll && $(".nicescroll").niceScroll({cursorcolor: '#98a6ad', cursorborder: '#98a6ad', cursorwidth: '5px', cursorborderradius: '5px'});

                                $(document).on('click', '#add_child', function () {
                                    var html = <?php echo json_encode($this->load->view("agent/member/get_child", $state, true)); ?>;
                                    html = html.replace(/0/g, key);
                                    $(document).find(".div_child_block").append(html);
                                    $(document).find('.dtpicker').datepicker({
                                        autoclose: true,
                                        todayHighlight: true,
                                        Format: 'yyyy-mm-dd',
                                    });
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
                                    data: {product: product_id, member: member_id},
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
                                $("input[name=spouse_first_name]").val('');
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
                                $("input[name=spouse_ssn]").val('');
                            });


                            $(document).on('click', '.save-changes', function () {
                                window.location = "<?php echo base_url() ?>agent/members";
                            });

                            //-------- for Remove New added child -----------
                            function remove_new_child(obj) {
                                $(obj).parent().parent().parent('.new-child').remove();
                            }

                            //-------- for Remove Old added child -----------
                            function remove_old_child(obj) {
                                var child_id = $(obj).data('child-id');
                                if (child_id) {
                                    $.post("<?= base_url('agent/members/remove_child/') ?>" + child_id, function (data) {
                                        if (data) {
                                            $(obj).parent().parent().parent('.old-child').remove();
                                        }
                                    });
                                } else {
                                    $(obj).parent().parent().parent('.old-child').remove();
                                }
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
                                        // swal("success", data, "success");
                                    }
                                });
                            }

                            //---------- Form Validation ----------------------
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
    </script>






