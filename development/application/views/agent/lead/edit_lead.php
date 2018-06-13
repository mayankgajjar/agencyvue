<style type="text/css">
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
</style>
<input type="hidden" name="controller_name" id="controller_name" value="<?php echo urlencode(base64_encode($this->uri->segment(2))); ?>">
<input type="hidden" name="method_name" id="method_name" value="<?php echo urlencode(base64_encode($this->uri->segment(3))); ?>">
<input type="hidden" name="lead_id" id="lead_id" value="<?php echo urlencode(base64_encode($this->uri->segment(4))); ?>">
<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Leads</h4>
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() . 'agent/dashboard' ?>">Dashboard</a></li>
                    <li><a href="<?= base_url() . 'agent/leads' ?>">Leads</a></li>
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

            <div class="row">
                <div class="col-md-4 col-lg-3">
                    <div class="profile-detail card-box">
                        <div>
                            <img src="<?php echo($lead_info['customer_gender'] == 'male') ? base_url() . 'assets/crm_image/Male_Placeholder.png' : base_url() . 'assets/crm_image/Female_Placeholder.png' ?>" class="img-circle" alt="profile-image">
                            <h4 class="text-uppercase font-600"><strong><?php echo $lead_info['customer_first_name'] . ' ' . $lead_info['customer_last_name'] ?>
                                </strong></h4>
                            <ul class="list-inline status-list m-t-20">
                                <div class="text-left">
                                    <p class="text-muted font-13"><strong>Created Date : </strong> <span class="m-l-15">01/13/2017</span></p>
                                    <p class="text-muted font-13"><strong>Activation Date :</strong><span class="m-l-15">01/13/2017</span></p>
                                    <p class="text-muted font-13"><strong>Next Billing Date :</strong> <span class="m-l-15">01/13/2018</span></p>
                                </div>
                            </ul>
                            <hr>
                            <h4 class="text-uppercase font-600"><strong>Product(s)
                                </strong></h4>
                            <ul class="list-inline status-list m-t-20">
                                <div class="text-center">
                                    <div class="button-list">
                                        <button type="button" class="btn btn-success waves-effect waves-light addProduct">
                                            <span class="btn-label"><i class="fa fa-plus"></i>
                                            </span>Add</button>
                                    </div>
                                </div>
                            </ul>

                            <hr>
                            <h4 class="text-uppercase font-600"><strong>Billing
                                </strong></h4>
                            <ul class="list-inline status-list m-t-20">

                                <div class="text-left">
                                    <p class="text-muted font-13"><strong>Payment Type : </strong> <span class="m-l-15"></span></p>

                                    <p class="text-muted font-13"><strong>Monthly Premium :</strong><span class="m-l-15"></span></p>

                                </div>

                                <div class="text-center">
                                    <div class="button-list">
                                        <button type="button" class="btn btn-success waves-effect waves-light">
                                            <span class="btn-label"><i
                                                    class="fa fa-plus"></i>
                                            </span>Add</button>

                                        <button type="button" class="btn btn-danger waves-effect waves-light">
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
                </div>
                <div class="col-lg-9 col-md-8">
                    <div class="card-box">
                        <form id="frm_lead_edit" method="post" class="data-parsley-validate novalidate">
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
                                        <input type="email" id="login_email" name="cus_email" class="required form-control lead-email-id" autocomplete="off" value="<?php echo (isset($lead_info['customer_email'])) ? $lead_info['customer_email'] : ''; ?>">
                                        <div id='email_msg' style="margin-top: 10px;"></div>
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="mname">Phone Number * </label>
                                        <input type="text" id="cuscontact" name="cus_contact" class="required form-control custom_phone_number_marks lead-phone-number" autocomplete="off" value="<?php echo (isset($lead_info['customer_phone_number'])) ? $lead_info['customer_phone_number'] : ''; ?>">
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Date Of Birth * </label>
                                        <div class="date-picker-div">
                                            <input class="form-control dtpicker required lead-dob" placeholder="mm/dd/yyyy" id="datepicker-autoclose" name="cus_dob" type="text" value="<?php echo (isset($lead_info['customer_dob']) && !empty($lead_info['customer_dob'])) ? date('m/d/Y', strtotime($lead_info['customer_dob'])) : ''; ?>">
                                            <span class="input-group-addon bg-custom b-0 text-white"><i class="icon-calender"></i></span>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group clearfix">

                                    <div class="col-lg-8">
                                        <label for="fname">Address * </label>
                                        <input type="text" id="cusaddress" name="cus_address" class="required form-control lead-add" autocomplete="off" value="<?php echo (isset($lead_info['customer_address'])) ? $lead_info['customer_address'] : ''; ?>">
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Apartment, Suite, etc.  </label>
                                        <input type="text" id="cussubaddress" name="cus_sub_address" class="form-control lead-oadd" autocomplete="off" value="<?php echo (isset($lead_info['customer_address_details'])) ? $lead_info['customer_address_details'] : ''; ?>">
                                    </div>

                                </div>

                                <div class="form-group clearfix">

                                    <div class="col-lg-4 input_wrapper">
                                        <label for="mname">State * </label>
                                        <select class="form-control required" id="user_state" name="cus_state" class="lead-status">
                                            <option value="">Select State</option>

                                            <?php foreach ($state as $key => $value) { ?>
                                                <option value="<?php echo $value['state_code']; ?>" <?php echo ( $value['state_code'] == $lead_info['customer_state']) ? 'selected' : ''; ?>><?php echo $value['state']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">City * </label>
                                        <select class="form-control  selcity required" id="user_city" name="cus_city" class="lead-city">

                                            <?php foreach ($city_pri as $key => $value) { ?>
                                                <option value="<?php echo $value['city']; ?>" <?php echo ( $value['city'] == $lead_info['customer_city']) ? 'selected' : ''; ?>><?php echo $value['city']; ?></option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Zip Code * </label>
                                        <input type="text" id="cuszip" name="cus_zip" class="required form-control custome_zipcode lead-zipcode" autocomplete="off" value="<?php echo (isset($lead_info['customer_zipcode'])) ? $lead_info['customer_zipcode'] : ''; ?>">
                                    </div>

                                </div>

                                <div class="form-group clearfix">

                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Social Security Number * </label>
                                        <input type="text" id="cussecuritynumber" name="cus_security_number" class="form-control securitynumber required" autocomplete="off" value="<?php echo (isset($lead_info['customer_social_security_number'])) ? $lead_info['customer_social_security_number'] : ''; ?>" >
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="customer_weight">Customer Weight  </label>
                                        <input type="text" id="customer_weight" name="customer_weight" class="form-control customer_weight" autocomplete="off" value="<?php echo (isset($lead_info['customer_weight'])) ? $lead_info['customer_weight'] : ''; ?>">
                                    </div>

                                    <div class="col-lg-4 input_wrapper">
                                        <label for="customer_gender">Customer Gender  </label> <br/>
                                        <input type="radio" name="gender" class="gendercheckbox" value="male" <?php echo ($lead_info['customer_gender'] == 'male') ? 'checked' : ''; ?>> Male
                                        <input type="radio" name="gender" class="gendercheckbox" value="female" <?php echo ($lead_info['customer_gender'] == 'female') ? 'checked' : ''; ?>> Female
                                    </div>

                                </div>
                                <!--</div>-->
                                <div id="spouse_div" style="display:none">
                                <div class="text-center">
                                    <h3><strong>SPOUSE</strong>
                                        <a class="btn btn-primary pull-right remove-spouse"><i class="fa fa-trash"></i> Remove Spouse</a>
                                    </h3>
                                </div>

                                <div class="form-group clearfix">

                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">First Name  </label>
                                        <input type="text" id="fname" name="spouse_first_name" class=" form-control" autocomplete="off" value="<?php echo (isset($lead_member_spouse_info['customer_spouse_first_name'])) ? $lead_member_spouse_info['customer_spouse_first_name'] : ''; ?>">
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="mname">Middle Name  </label>
                                        <input type="text" id="mname" name="spouse_middle_name" class=" form-control" autocomplete="off" value="<?php echo (isset($lead_member_spouse_info['customer_spouse_middle_name'])) ? $lead_member_spouse_info['customer_spouse_middle_name'] : ''; ?>">
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Last Name  </label>
                                        <input type="text" id="lname" name="spouse_last_name" class=" form-control" autocomplete="off" value="<?php echo (isset($lead_member_spouse_info['customer_spouse_last_name'])) ? $lead_member_spouse_info['customer_spouse_last_name'] : ''; ?>">
                                    </div>

                                </div>

                                <div class="form-group clearfix">

                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Email Address  </label>
                                        <input type="email" id="fname" name="spouse_email_address" class=" form-control" autocomplete="off" value="<?php echo (isset($lead_member_spouse_info['customer_spouse_email'])) ? $lead_member_spouse_info['customer_spouse_email'] : ''; ?>">
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="mname">Phone Number  </label>
                                        <input type="text" id="mname" name="spouse_phone_no" class=" form-control custom_phone_number_marks" autocomplete="off" value="<?php echo (isset($lead_member_spouse_info['customer_spouse_phone_number'])) ? $lead_member_spouse_info['customer_spouse_phone_number'] : ''; ?>">
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Date Of Birth  </label>
                                        <div class="date-picker-div">
                                            <input class="form-control dtpicker" placeholder="mm/dd/yyyy" id="datepicker-autoclose" name="spouse_dob" type="text" value="<?php echo (isset($lead_member_spouse_info['customer_spouse_dob']) && !empty($lead_member_spouse_info['customer_spouse_dob'])) ? date('m/d/Y', strtotime($lead_member_spouse_info['customer_spouse_dob'])) : ''; ?>">
                                            <span class="input-group-addon bg-custom b-0 text-white"><i class="icon-calender"></i></span>

                                        </div>
                                    </div>

                                </div>

                                <div class="form-group clearfix">

                                    <div class="col-lg-8">
                                        <label for="fname">Address  </label>
                                        <input type="text" id="fname" name="spouse_address" class=" form-control" autocomplete="off" value="<?php echo (isset($lead_member_spouse_info['customer_spouse_address'])) ? $lead_member_spouse_info['customer_spouse_address'] : ''; ?>">
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Apartment, Suite, etc. </label>
                                        <input type="text" id="lname" name="spouse_sub_address" class=" form-control" autocomplete="off" value="<?php echo (isset($lead_member_spouse_info['customer_spouse_address_details'])) ? $lead_member_spouse_info['customer_spouse_address_details'] : ''; ?>">
                                    </div>

                                </div>

                                <div class="form-group clearfix">

                                    <div class="col-lg-4 input_wrapper">
                                        <label for="mname">State </label>
                                        <select class="form-control " id="spo_user_state" name="customer_spouse_state">
                                            <option value="">Select State</option>
                                            <?php foreach ($state as $key => $value) { ?>
                                                <option value="<?php echo $value['state_code']; ?>" <?php echo ( $value['state_code'] == (isset($lead_member_spouse_info['customer_spouse_state'])) ? $lead_member_spouse_info['customer_spouse_state'] : '') ? 'selected' : '' ?>><?php echo $value['state']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">City  </label>
                                        <select class="form-control " id="spo_user_city" name="spouse_city">
                                            <?php foreach ($city_sop as $key => $value) { ?>
                                                <option value="<?php echo $value['city']; ?>" <?php echo ( $value['city'] == $lead_member_spouse_info['customer_spouse_city']) ? 'selected' : ''; ?>><?php echo $value['city']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Zip Code  </label>
                                        <input type="text" id="lname" name="spouse_zipcode" class="form-control custome_zipcode" autocomplete="off" value="<?php echo (isset($lead_member_spouse_info['customer_spouse_zipcode'])) ? $lead_member_spouse_info['customer_spouse_zipcode'] : ''; ?>">
                                    </div>

                                </div>
                                <div class="form-group clearfix">
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Social Security Number  </label>
                                        <input type="text" id="fname" name="spouse_ssn" class="form-control securitynumber" autocomplete="off" value="<?php echo (isset($lead_member_spouse_info['customer_spouse_social_security_number'])) ? $lead_member_spouse_info['customer_spouse_social_security_number'] : ''; ?>" >
                                    </div>
                                </div>
                            </div>
                                <div class="div_child_block" style="display:none">
                                    <script type="text/javascript">
                                        var key = 0;
                                    </script>
                                    <?php echo $add_child_block_html; ?>
                                </div>
                                 <!-- <div class="div_child_blockk" style="display:none">
                                    <script type="text/javascript">
                                        var key = 0;
                                    </script>
                                   <?php echo $add_child_block_html; ?>
                                                                 </div> -->
                                <ul class="list-inline status-list m-t-20">
                                    <div class="text-center">
                                        <div class="button-list">
                                                <button type="button" id="add_spouse" class="btn btn-success waves-effect waves-light add-new-spouse">Add New Spouse</button>
                                                <button type="button" class="btn btn-success waves-effect waves-light add-new-child">Add New Child</button>
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
                                    <button type="submit" class="btn btn-success" >Save</button>
                                    <a class="btn btn-default waves-effect waves-light" href="<?= base_url() . 'agent/leads' ?>"> <span class="btn-label"><i class="fa fa-arrow-left"></i>
                                        </span>Back</a>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="full-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="full-width-modalLabel" aria-hidden="true" style="display: none;">
        <div id="mga"></div>
    </div><!-- /.modal -->

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
                            <select name="vendor" class="form-control required">
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
                                <input id="product_price" name="product_price" type="Text" class="required form-control price_input_mask" autocomplete="off" value="">
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
    <script type="text/javascript" src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
    <script>
        $(document).ready(function () {
            $('form').parsley();
            $(function () {
                $("#user_state").change(function () {
                    $("#user_city").empty();
                    var state = $(this).val();
                    $.ajax({
                        url: '<?php echo base_url() ?>agent/leads/getcity',
                        type: 'POST',
                        data: {'ustid': state},
                        success: function (data) {
                            $('#user_city').html(data);
                        },
                    });
                });
            });

            $(function () {
                $("#spo_user_state").change(function () {
                    $("#spo_user_city").empty();
                    var state = $(this).val();
                    $.ajax({
                        url: '<?php echo base_url() ?>agent/leads/getcity',
                        type: 'POST',
                        data: {'sopstid': state},
                        success: function (data) {
                            $('#spo_user_city').html(data);
                        },
                    });
                });
            });


            jQuery(document).on('submit', "#frm_lead_edit", function (event) {
                event.preventDefault();
                save_lead('frm_lead_edit');
            });

            function save_lead(form_id) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() ?>agent/leads/save_lead",
                    data: $(document).find("#" + form_id).serialize(),
                    success: function (data) {
                        window.location.reload();
                        //console.log(data);
                        //swal("success", data, "success");
                    },
                });
            }

            $(document).on('click', '#add_child', function () {
//               var total_blocks = $(".div_child_block .child_div").length;
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
        function onchange_city(ele) {
            var parent = jQuery(ele).parent('div');
            var state = jQuery(ele).val();
            jQuery.ajax({
                url: '<?php echo base_url() ?>agent/leads/getcity',
                type: 'POST',
                data: {'sopstid': state},
                success: function (data) {
                    jQuery(parent.next('div').find('select')).html(data);
                },
            });
        }
         $(document).on('click', '.add-new-spouse', function () {
            $("#spouse_div").show();
            $(".add-new-spouse").prop("disabled",true);
        });

         $(document).on('click', '.add-new-child', function () {
            $(".div_child_block").show();
            $(".add-new-child").prop("disabled",true);
        });

        $(".remove-spouse").click(function () {
            /*$("input[name=spouse_first_name]").val('');
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
            $("#spouse_div").hide();
            $(".add-new-spouse").prop("disabled",false);
        });

        //-------- for Remove New added child -----------
        function remove_new_child(obj) {
            $(obj).parent().parent().parent('.new-child').remove();
        }

        //-------- for Remove Old added child -----------
        function remove_old_child(obj) {
            /*var child_id = $(obj).data('child-id');
            if (child_id) {
                $.post("<?= base_url('agent/leads/remove_child/') ?>" + child_id, function (data) {
                    if (data) {
                        $(obj).parent().parent().parent('.old-child').remove();
                    }
                });
            } else {
                $(obj).parent().parent().parent('.old-child').remove();
            }*/
            $(".div_child_block").hide();
            $(".add-new-child").prop("disabled",false);
        }
        //------------- Add Product IN LEAD ----------------
        $(".addProduct").click(function () {
            /*var validation = true;
            var $form = $('#frm_lead_edit');
            $form.parsley().validate();
            var parValue = $form.parsley().validate()
            if (parValue == false) {
                swal("You need to fill this details for conventing this lead in member")
                validation = false;
            }*/
                    product_pop_up();

            //------------ Check IS email ID is already in USER LOGIN TABLE
          /*  var emailid = $('#login_email').val();
            $('.loader-select-city').show();
            $.ajax({
                url: '<?php echo base_url() ?>agent/members/chk_email',
                type: 'POST',
                data: {email: emailid},
                success: function (data) {
                    $('#email_msg').html(data);
                    if (data != '<i>Email address is valid</i>') {
                        $("#login_email").focus();
                        $("#login_email").addClass("textInputError");
                        validation = false;
                        console.log(validation);
                    } else {
                        $("#login_email").removeClass("textInputError");
                    }
                    $('.loader-select-city').hide();
                    product_pop_up(validation);
                },
            });*/
        });
        function product_pop_up(validation='') {
            var emailid = $('#login_email').val();
            /*if (validation === true) {*/
                var display_name = $("#cusfname").val() + ' ' + $("#cuslname").val();
                var leadID = '<?php echo $lead_info['customer_id']; ?>';
                var add = $('.lead-add').val();
                var oadd = $('.lead-oadd').val();
                var state = $('#user_state').val();
                var city = $('#user_city').val();
                var zipcode = $('.lead-zipcode').val();
                var ssnumber = $('.securitynumber').val();
                var customer_weight = $('.customer_weight').val();
                var dob = $('.lead-dob').val();
                $.ajax({
                    url: '<?php echo base_url() ?>agent/leads/lead_cart',
                    type: 'POST',
                    data: {email: emailid, display_name: display_name, leadID: leadID, add: add, oadd: oadd, state: state, city: city, zipcode: zipcode, ssnumber: ssnumber, customer_weight: customer_weight, dob: dob},
                    dataType: "JSON",
                    success: function (data) {
                        console.log("data", data);
                        $('#mga').html(data.new_html);
                        $('#full-width-modal').modal('show');
                    },
                });
           // }
        }
        $(document).on('click', '.product-add', function () {
            alert("here");
            var productID = $(this).data("custom-value-productid");
            var key_id = $(this).data("id");
            var memberID = $("#memberid").val();
            var email = $("#login_email").val();
            var displayname = $('#cusfname').val() + ' ' + $('#cuslname').val();
            $.ajax({
                method: "POST",
                url: '<?php echo base_url() ?>agent/leads/addproduct',
                data: {product: productID, member: memberID, email: email, displayname: displayname},
                success: function (data) {
                    console.log($(this));
                    $(".pro-add-" + key_id).attr("disabled", 'disabled');
                    $(".pro-remove-" + key_id).attr("disabled", false);
                    swal("success", data, "success");
                    $.fn.niceScroll && $(".nicescroll").niceScroll({cursorcolor: '#98a6ad', cursorborder: '#98a6ad', cursorwidth: '5px', cursorborderradius: '5px'});
                }
            });
        });
        $(document).on('click', '.save-changes', function () {
            window.location.href = "<?php echo base_url() ?>agent/members";
        });

        /*$(document).on('click', '.add-new-product', function () {
            alert("here");
            var controller = $('#controller_name').val();
            var method = $('#method_name').val();
            var lead_id = $('#lead_id').val();
            var url = "<?php echo base_url() ?>product/add_product?con=" + controller + "&met=" + method + "&lead=" + lead_id;

            window.location.href = url;
        });*/
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
//  added-22-12-2017
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
        $(document).on('click', '.add_new_product', function () {
            vendor_id = $("select[name='vendor']").val();
            product_type = $("select[name='product_type']").val();
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
                data: {vendor_id: vendor_id, product_type: product_type,coverage_type:coverage_type,product_name:product_name,product_price:product_price,enrollment_fee:enrollment_fee, lead_id:lead_id},
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
          var leadID = '<?php echo $lead_info['customer_id']; ?>';
            $.ajax({
                url: '<?php echo base_url() ?>agent/leads/change_lead_status',
                type: 'POST',
                data: {leadID: leadID},
                success: function (data) {
                    console.log(data);
                }
            });
            
        });
    </script>



