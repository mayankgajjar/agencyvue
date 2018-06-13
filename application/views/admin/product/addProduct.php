<style>
    .card-box {overflow: hidden;}
    .checkbox-wapper-custom label { display: block; }
    .checkbox-wapper-custom .checkbox { display: inline-block; }
    span.select2-selection.select2-selection--single {
        background: #323B44 !important;
    }
    .bootstrap-tagsinput {
        background-color: #323B44 !important;
        padding: 7px 6px !important;
        color: #fff !important;
    }
    .checkbox-wapper-custom ul.filled {position: absolute;}
</style>
<script src="<?php echo base_url() ?>assets/plugins/autoNumeric/autoNumeric.js"></script>
<div class="wrapper add-product-page">
    <div class="container">

        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Add New Product</h4>
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() . 'admin/dashboard' ?>">Dashboard</a></li>
                    <li><a href="<?= base_url() . 'admin/products' ?>">Manage Products</a></li>
                    <li class="active">Add New Product</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <?php if (isset($error)) { ?>
                <div class="content pt0">
                    <div class="alert alert-danger">
                        <a class="close" data-dismiss="alert"><i class="fa fa-times"></i></a>
                        <strong><?= $error ?></strong>
                    </div>
                </div>
            <?php } ?>
            <div class="col-lg-12 card-box">
                <form method="post" enctype="multipart/form-data" data-parsley-validate novalidate id="productform">
                    <div class="row">
                        <div class="col-lg-12 form-group clearfix">
                            <div class="col-lg-4">
                                <div class="input_wrapper">
                                    <label>Product ID</label>
                                    <input type="text" id="product_id" maxlength="16" name="product_id" class="required form-control threshold">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="input_wrapper">
                                    <label for="product_name">Product Name</label>
                                    <input id="product_name" type="text" maxlength="25" name="product_name" class="required form-control threshold">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="input_wrapper">
                                    <label>Plan ID</label>
                                    <input type="text" id="plan_id" name="plan_id" maxlength="16" class="required form-control threshold">
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 form-group clearfix">
                            <div class="col-lg-4">
                                <div class="input_wrapper">
                                    <label for="product_price">Product Price / Monthly Premium</label>
                                    <input id="product_price" type="text" name="product_price" data-a-sign="$ " placeholder="$ XXXX.XX" class="autonumber required form-control productprice">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="input_wrapper checkbox-wapper-custom">
                                    <label>Product Type</label>
                                    <select class="form-control required" name="product_type">
                                        <option value="">Select Product Type</option>
                                        <option value="Dental">Dental</option>
                                        <option value="Vision">Vision</option>
                                        <option value="RX">RX</option>
                                        <option value="Life">Life</option>
                                        <option value="Health">Health</option>
                                        <option value="AD&D">AD&D</option>
                                        <option value="Long_Term_Care">Long Term Care</option>
                                        <option value="Limited_Medical">Limited Medical</option>
                                        <option value="Major_Medical">Major Medical</option>
                                        <option value="Medicare">Medicare</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="input_wrapper checkbox-wapper-custom">
                                    <label>Coverage</label>
                                    <select class="form-control required" name="coverage">
                                        <option value="">Select Coverage</option>
                                        <option value="Member">Member</option>
                                        <option value="Member_Spouse">Member + Spouse</option>
                                        <option value="Member_Child">Member + Child</option>
                                        <option value="Member_Children">Member + Children</option>
                                        <option value="Family">Family</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 form-group clearfix">
                            <div class="col-lg-4">
                                <div class="input_wrapper">
                                    <label> No Sale States </label>
                                    <select class="select2 select2-multiple required" multiple="multiple" multiple data-placeholder="Choose state by entering names" name="product_state[]">
                                        <?php foreach ($states as $state): ?>
                                            <option value="<?= $state['state_code']; ?>"><?= $state['state']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div> 
                            </div>
                            <div class="col-lg-4">
                                <div class="input_wrapper">
                                    <label> Average-Savings* </label>
                                    <input id="average_savings" type="text" name="average_savings" class="required form-control"> 
                                </div> 
                            </div>
                            <div class="col-lg-4">
                                <div class="input_wrapper">
                                    <label> Network-Size* </label>
                                    <input id="network_size" type="text" name="network_size" class="required form-control"> 
                                </div> 
                            </div>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-lg-12 form-group clearfix">
                            <div class="col-lg-4">
                                <div class="input_wrapper">
                                    <label> Benefits-Type* </label>
                                    <input id="Benefits_Type" type="text" name="benefits_type" class="required form-control"> 
                                </div> 
                            </div>
                            <div class="col-lg-4">
                                <div class="input_wrapper checkbox-wapper-custom">
                                    <label>Allow Pre-Existing Conditions</label>
                                    <div class="checkbox checkbox-primary">
                                        <input id="allow_conditions_yes" type="checkbox" name="allow_conditions" class="allow_conditions allow_conditions_yes" data-parsley-mincheck="1" data-parsley-validate-if-empty value="yes" checked>
                                        <label for="allow_conditions_yes">Yes</label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input id="allow_conditions_no" type="checkbox" name="allow_conditions" class="allow_conditions allow_conditions_no" value="no">
                                        <label for="allow_conditions_no">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="input_wrapper checkbox-wapper-custom">
                                    <label>Product Status.</label>
                                    <div class="checkbox checkbox-primary">
                                        <input id="product_active" type="checkbox" name="product_status" class="product_status product_status_yes" data-parsley-mincheck="1" data-parsley-validate-if-empty value="active" checked>
                                        <label for="product_active">Active</label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input id="product_inactive" type="checkbox" name="product_status" class="product_status product_status_no" value="inactive">
                                        <label for="product_inactive">Inactive</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 form-group clearfix">
                            <div class="col-lg-6">
                                <label for="range_01" class="control-label">Age Restrictions</label>
                                <input type="text" id="range_01" name="age_restrictions">
                            </div>
                            <div class="col-lg-6">
                                <label for="range_03" class="control-label">Weight Restrictions</label>
                                <input type="text" id="range_03" name="weight_restrictions">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 form-group clearfix">
                            <label for="range_02" class="control-label">Height Restrictions</label>
                            <input type="text" id="range_02" class="range_slider" name="height_restrictions">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 form-group clearfix">
                            <div class="col-lg-4">
                                <div class="input_wrapper checkbox-wapper-custom">
                                    <label>Requires License Type</label>
                                    <div class="checkbox checkbox-primary">
                                        <input id="license_type_health" type="checkbox" name="license_type[]" class="license_type_r" value="health" data-parsley-mincheck="1" data-parsley-validate-if-empty checked>
                                        <label for="license_type_health">Health</label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input id="license_type_accident" type="checkbox" name="license_type[]" class="license_type_r" value="accident">
                                        <label for="license_type_accident">Accident</label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input id="license_type_life" type="checkbox" name="license_type[]" class="license_type_r" value="life">
                                        <label for="license_type_life">Life</label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input id="license_type_pand_c" type="checkbox" name="license_type[]" class="license_type_r" value="propertyandcasualty">
                                        <label for="license_type_pand_c">Property & Casualty</label>
                                    </div>
                                    <div class="error_license_type" style="font-style: italic; color: #f6504d; margin-top: 8px; display: none;">Please select at least one license type.</div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="input_wrapper checkbox-wapper-custom">
                                    <label>Requires Appointment</label>
                                    <div class="checkbox checkbox-primary">
                                        <input id="appointment_yes" type="checkbox" name="appointment" class="appointment appointment_yes" data-parsley-mincheck="1" data-parsley-validate-if-empty value="yes" checked>
                                        <label for="appointment_yes">Yes</label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input id="appointment_no" type="checkbox" name="appointment" class="appointment appointment_no"  value="no">
                                        <label for="appointment_no">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="input_wrapper checkbox-wapper-custom">
                                    <label>Requires License</label>
                                    <div class="checkbox checkbox-primary">
                                        <input id="license_yes" type="checkbox" name="license" class="license license_yes" data-parsley-mincheck="1" data-parsley-validate-if-empty value="yes" checked>
                                        <label for="license_yes">Yes</label>
                                    </div>
                                    <div class="checkbox checkbox-primary">
                                        <input id="license_no" type="checkbox" name="license" class="license license_no" value="no">
                                        <label for="license_no">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group input_wrapper">
                                    <label class="control-label">Product Image</label>
                                    <input type="file" name="product_image" class="filestyle required" data-buttonname="btn-default" onchange="ValidateSingleInput(this);">
                                    <div class="error_image" style="font-style: italic; color: red; margin-top: 8px; display: none;">Please select jpg , png or gif file format.</div>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 form-group clearfix">
                            <div class="col-lg-4">
                                <div class="input_wrapper checkbox-wapper-custom">
                                    <div class="input_wrapper">
                                        <label for="enrollment_fee">Enrollment Fee</label>
                                        <div class="tags-default">
                                            <input id="enrollment_fee" data-role="tagsinput" placeholder="Add Fee Value And Hit Enter" type="text" name="enrollment_fee" class="required form-control numbersOnly">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="input_wrapper checkbox-wapper-custom">
                                    <label>Enrollment Billing Rule</label>
                                    <select class="form-control required" name="enrollment_billing">
                                        <option value="">Select Enrollment Billing Rule</option>
                                        <option value="One_Time">One-Time</option>
                                        <option value="Weekly">Weekly</option>
                                        <option value="Semi_Monthly">Semi-Monthly</option>
                                        <option value="Monthly">Monthly</option>
                                        <option value="Yearly">Yearly</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="input_wrapper">
                                    <label>Select Vendor</label>
                                    <select class="form-control select2" name="vendor" id="vendor-select" data-placeholder="Select Vendor">
                                        <option value="">Select Vendor </option>
                                        <?php foreach ($vendors as $vendor): ?>
                                            <option value="<?= $vendor['vendor_id']; ?>"><?= $vendor['vendor_name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 form-group clearfix">
                            <div class="col-lg-4">
                                <div class="input_wrapper">
                                    <div class="input_wrapper">
                                        <label>Billing Rule</label>
                                        <select class="form-control required" name="billing_rule">
                                            <option value="">Select Billing Rule</option>
                                            <option value="One_Time">One-Time</option>
                                            <option value="Weekly">Weekly</option>
                                            <option value="Semi_Monthly">Semi-Monthly</option>
                                            <option value="Monthly">Monthly</option>
                                            <option value="Yearly">Yearly</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="input_wrapper">
                                    <label>Next Billing Date Rule</label>
                                    <select class="form-control required" name="next_billing_date_rule">
                                        <option value="">Select Next Billing Date Rule</option>
                                        <option value="Same_day_each_month">Same day each month</option>
                                        <option value="1st_of_every_month">1st of every month</option>
                                        <option value="15th_of_every_month">15th of every month</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="input_wrapper">
                                    <label>Activation Date Rule</label>
                                    <select class="form-control required" name="activation_rule">
                                        <option value="">Select Activation Date Rule</option>
                                        <option value="1st_and_15th">1st and 15th</option>
                                        <option value="Next_Day">Next Day</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 form-group clearfix">
                            <div class="col-lg-4">
                                <div class="input_wrapper">
                                    <label>Verification script</label>
                                    <input type="file" name="verification_script" class="filestyle required" data-buttonname="btn-default" onchange="Validateverification(this);">
                                    <div class="error_verification" style="font-style: italic; color: #f6504d; margin-top: 8px; display: none;">Please select only .mp3 file format.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12-md">
                            <div class="col-md-6 text-right">
                                <div class="submit-wapper">
                                    <input type="submit" class="btn btn-success waves-effect waves-light btn-md" name="save" value="Save"/>
                                </div>
                            </div>
                            <div class="col-md-6"> 
                                <a class="btn btn-default btn-md waves-effect waves-light" href="#"> <span class="btn-label"><i class="fa fa-arrow-left"></i>
                                    </span>Back</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(".select2").select2();
    $('.autonumber').autoNumeric('init');
    $("#range_02").ionRangeSlider({keyboard: true,
        type: "double",
        min: 3.0,
        step: 0.1,
        values: [3.0, 3.1, 3.2, 3.3, 3.4, 3.5, 3.6, 3.7, 3.8, 3.9, '3.1O', 3.11, 3.12, 4.0, 4.1, 4.2, 4.3, 4.4, 4.5, 4.6, 4.7, 4.8, 4.9, '4.1O', 4.11, 4.12, 5.0, 5.1, 5.2, 5.3, 5.4, 5.5, 5.6, 5.7, 5.8, 5.9, '5.1O', 5.11, 5.12, 6.0, 6.1, 6.2, 6.3, 6.4, 6.5, 6.6, 6.7, 6.8, 6.9, '6.1O', 6.11, 6.12, 7.0, 7.1, 7.2, 7.3, 7.4, 7.5, 7.6, 7.7, 7.8, 7.9, '7.1O', 7.11, 7.12, 8],
        grid: true});
    $("#range_01").ionRangeSlider({
        type: "double",
        keyboard: true,
        min: 1,
        max: 120,
        grid: true
    });
    $("#range_03").ionRangeSlider({
        type: "double",
        keyboard: true,
        min: 30,
        max: 500,
        grid: true
    });
    $('.threshold').maxlength({
        threshold: 10
    });
    var _validFileExtensionsimg = [".jpeg", ".jpg", ".png"];
    function ValidateSingleInput(oInput) {
        if (oInput.type == "file") {
            var sFileName = oInput.value;
            if (sFileName.length > 0) {
                var blnValid = false;
                for (var j = 0; j < _validFileExtensionsimg.length; j++) {
                    var sCurExtension = _validFileExtensionsimg[j];
                    if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                        blnValid = true;
                        $(".error_image").hide();
                        break
                    }
                }
                if (!blnValid) {
                    $(".error_image").show();
                    oInput.value = "";
                    return false;
                }
            }
        }
        return true;
    }
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
//    $("#productform").submit(function (e) {
//        e.preventDefault();
//        var count_checked = $("[name='license_type[]']:checked").length;
//        if (count_checked == 0) {
//            $('.error_license_type').show();
//            //alert("Please check at least one checkbox");
//            return false;
//        } else {
//            $('.error_license_type').hide();
//            return true;
//        }
//    });
//    $(document).on('click', '.license_type_r', function () {
//        if ($("[name='license_type[]']:checked]")) {
//            $('.error_license_type').hide();
//        } else {
//            $('.error_license_type').show();
//        }
//
//    });
    $(document).on('click', '.allow_conditions', function () {
        var allow_conditions = $(this).val();
        if (allow_conditions == "yes") {
            $('#allow_conditions_no').prop('checked', false); // Unchecks it
        }
        if (allow_conditions == "no") {
            $('#allow_conditions_yes').prop('checked', false); // Unchecks it
        }
    });
    $(document).on('click', '.product_status', function () {
        var product_status = $(this).val();
        if (product_status == "active") {
            $('#product_inactive').prop('checked', false); // Unchecks it
        }
        if (product_status == "inactive") {
            $('#product_active').prop('checked', false); // Unchecks it
        }
    });
    $(document).on('click', '.appointment', function () {
        var appointment = $(this).val();
        if (appointment == "yes") {
            $('#appointment_no').prop('checked', false); // Unchecks it
        }
        if (appointment == "no") {
            $('#appointment_yes').prop('checked', false); // Unchecks it
        }
    });
    $(document).on('click', '.license', function () {
        var license = $(this).val();
        if (license == "yes") {
            $('#license_no').prop('checked', false); // Unchecks it
        }
        if (license == "no") {
            $('#license_yes').prop('checked', false); // Unchecks it
        }
    });
    $('#enrollment_fee').on('itemAdded', function (event) {
        var tag = event.item;
        tag = tag.replace(/[^0-9\.]/g, '');
        if (tag.length <= 0) {
            var removeAble = $('.label-info').length;
            console.log(removeAble);
            $('.label-info').eq((removeAble - 1)).remove();
            return false;
        }
    });
    $('.NumbersAndDot').keyup(function () {
        this.value = this.value.replace(/[^0-9.]/g, '');
        if (this.value.split('.').length > 2) {
            this.value = this.value.replace(/\.+$/, "");
        }
        var price = this.value;
        var is_decimal = 0;
        if (price.indexOf('.') != -1) {
            is_decimal = 1;
        }
        if (price > 7 && is_decimal == 1) {
            this.value = this.value.substring(0, 7);
        } else if (price > 6 && is_decimal == 0) {
            this.value = this.value.substring(0, 6);
        }

    });

//    $("#product_price").blur(function () {
//        if ($(this).val() != '') {
//            var valuePrice = Math.round($(this).val());
//            $(this).val(valuePrice);
//        }
//    });
</script>