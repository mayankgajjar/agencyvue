<style type="text/css">
    .date-picker-div { position: relative; }
    .date-picker-div span { height: 32px;position: absolute;right: 2px;top: 2px;width: 40px; }
    .loader-select-city { display: none;position: absolute;width: 100%;background: rgba(255,255,255,.2);left: 0;top: 0;right: 0;bottom: 0;z-index: 9999; }
    .loader-image { height: 45px;top: 50%;position: absolute;left: 50%;margin-top: -22px;margin-left: -22px; }
    input.textInputError {border-color: red;}
    label.btn.btn-default.choose-file-btn {margin: 0 !important;}
    .date-picker-div {position: relative;}
    .date-picker-div span {height: 32px;position: absolute;right: 2px;top: 2px;width: 40px;}
    .datepicker>div {display: block;}
    .datepicker {z-index: 9999999;}
    input.textInputError {border-color: #C44B4D;}
</style>
<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Quote</h4>
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() . 'agent/dashboard' ?>">Dashboard</a></li>
                    <li><a href="<?= base_url() . 'agent/Quote' ?>">Quote</a></li>
                    <li class="active">Add Quote</li>
                </ol>
            </div>
        </div>
        <div class="row card-box">
            <form id="frm_add_quote" method="post" action="<?php echo base_url() ?>agent/quote/add_quote" data-parsley-validate novalidate>
                <div class="col-md-8 col-xs-12">
                    <div class="row">
                        <div class="form-group clearfix">
                            <div class="col-lg-12 ">
                                <div class="col-lg-6">
                                    <label for="fname">First Name * </label>
                                    <input type="text" id="fname" name="first_name" class="required form-control" autocomplete="off" value="" value="<?php echo set_value('first_name'); ?>">
                                </div>
                                <div class="col-lg-6">
                                    <label for="mname">Last Name * </label>
                                    <input type="text" id="mname" name="last name" class="required form-control" autocomplete="off" value="" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group clearfix">
                            <div class="col-lg-12 ">
                                <div class="col-lg-6">
                                    <label for="fname">Email Address * </label>
                                    <input type="email" name="emailid" class="required form-control" autocomplete="off" value="" id="login_email" >
                                    <div id='email_msg' style="margin-top: 10px;"></div>
                                </div>
                                <div class="col-lg-6">
                                    <label for="mname">Birth Date * </label>
                                    <div class="date-picker-div">
                                        <input class="form-control required dtpicker" placeholder="mm/dd/yyyy" id="datepicker-autoclose" name="dob" type="text" value="<?php echo set_value('dob'); ?>">
                                        <span class="input-group-addon bg-custom b-0 text-white"><i class="icon-calender"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group clearfix">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="fname">Zip Code * </label>
                                    <input type="text" id="fname" name="zipcode" class="required form-control custome_zipcode" autocomplete="off" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="mname">State * </label>
                                    <select class="form-control required" id="emp_state" name="quote_state">
                                        <option value="">Select State</option>
                                        <?php foreach ($states as $state): ?>
                                            <option value="<?php echo $state['state_code']; ?>" ><?php echo $state['state']; ?></option>
                                        <?php endforeach; ?>
                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group clearfix">
                            <div class="col-md-12">
                                <div class="col-lg-4">
                                    <label for="mname">Gender * </label>
                                    <div class="" style="display: inline-block;">
                                        <div class="checkbox checkbox-primary checkbox-inline">
                                            <input id="gender_male" type="checkbox" name="gender" value="male" class="gender gender_male" checked/>
                                            <label for="gender_male">
                                                <?php echo "Male" ?>
                                            </label>
                                        </div>
                                        <div class="checkbox checkbox-primary checkbox-inline">
                                            <input id="gender_female" type="checkbox" name="gender" value="female" class="gender gender_female"/>
                                            <label for="spouse_gender_female">
                                                <?php echo "Female" ?>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label"><?php echo "Allow Tobacco Use?" ?>:</label>
                                    <div class="" style="display: inline-block;">
                                        <div class="checkbox checkbox-primary checkbox-inline">
                                            <input id="allow_tobacco_yes" type="checkbox" name="allow_tobacco" value="yes" class="allow_tobacco allow_tobacco_yes" <?php echo isset($product['product_requires_license']) && $product['product_requires_license'] == 'no' ? 'checked="checked"' : ''; ?>/>
                                            <label for="allow_tobacco_yes">
                                                <?php echo "Yes" ?>
                                            </label>
                                        </div>
                                        <div class="checkbox checkbox-primary checkbox-inline">
                                            <input id="allow_tobacco_no" type="checkbox" name="allow_tobacco" value="no" class="allow_tobacco allow_tobacco_no"  <?php echo isset($product['product_requires_license']) && $product['product_requires_license'] == 'no' ? 'checked="checked"' : ''; ?> <?php echo empty($product) ? 'checked="checked"' : '' ?>/>
                                            <label for="allow_tobacco_no">
                                                <?php echo "No" ?>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label"><?php echo "Have Spouse?" ?>:</label>
                                    <div class="" style="display: inline-block;">
                                        <div class="checkbox checkbox-primary checkbox-inline">
                                            <input id="spouse_yes" type="checkbox" name="spouse" value="yes" class="spouse_yes spouse_checkbox" />
                                            <label for="spouse_yes">
                                                <?php echo "Yes" ?>
                                            </label>
                                        </div>
                                        <div class="checkbox checkbox-primary checkbox-inline">
                                            <input id="spouse_no" type="checkbox" name="spouse" value="no" class="spouse_no spouse_checkbox" checked/>
                                            <label for="spouse_no">
                                                <?php echo "No" ?>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group clearfix">
                            <div class="col-md-12">
                                <div class="col-md-4" id="childern_wrapper">
                                    <label for="childern_count"> No. of Childern</label>
                                    <input type="number" id="childern_count" max="20" name="childern_count" class="required form-control" autocomplete="off" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="spouse_wapper" style="display: none">
                        <div class="form-group clearfix">
                            <div class="col-md-12">
                                <div class="col-lg-6">
                                    <label for="mname">Spouse Birth Date </label>
                                    <div class="date-picker-div">
                                        <input class="form-control dtpicker spouse_dob" placeholder="mm/dd/yyyy" id="datepicker-autoclose" name="spouse_dob" type="text" class="spouse_dob">
                                        <span class="input-group-addon bg-custom b-0 text-white"><i class="icon-calender"></i></span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label for="nanm">Spouse Gender</label>
                                    <div class="" style="display: inline-block;">
                                        <div class="checkbox checkbox-primary checkbox-inline">
                                            <input id="spouse_gender_male" type="checkbox" name="spouse_gender" value="male" class="spouse_gender spouse_gender_male" />
                                            <label for="spouse_gender_male">
                                                <?php echo "Male" ?>
                                            </label>
                                        </div>
                                        <div class="checkbox checkbox-primary checkbox-inline">
                                            <input id="spouse_gender_female" type="checkbox" name="spouse_gender" value="female" class="spouse_gender spouse_gender_female" checked/>
                                            <label for="spouse_gender_female">
                                                <?php echo "Female" ?>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group clearfix">
                            <div class="col-lg-12">
                                <div class="col-lg-6">
                                    <div class="checkbox checkbox-primary">
                                        <input id="e_fulfillment" type="checkbox" name="fulfillment_type" class="fulfillment_type" value="e_fulfillment">
                                        <label>Check this box to save this lead information</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group"><div class="col-md-12">
                                <div class="col-md-6">
                                    <div style="text-align: left">
                                        <button type="submit" class="btn btn-success btn-lg" name="save" value="save">Find Plan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-xs-12">
                    <div class="featured-product-box">
                        <div class="featuredProduct-title">
                            <h4>Featured Product</h4>
                        </div>
                        <div class="html-featured-product">
                            <?php echo $featuredProduct; ?>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('form').parsley();
        $("#login_email").change(function () {
            var emailid = $(this).val();
            $('.loader-select-city').show();
            $.ajax({
                url: '<?php echo base_url() ?>admin/employers/chk_email',
                type: 'POST',
                data: {email: emailid},
                success: function (data) {
                    $('#email_msg').html(data);
                    if (data != '<i>Email address is valid</i>') {
                        $("#login_email").focus();
                        $("#login_email").addClass("textInputError");
                        $(':input[type="submit"]').prop('disabled', true);
                    } else {
                        $("#login_email").removeClass("textInputError");
                        $(':input[type="submit"]').prop('disabled', false);
                    }
                    $('.loader-select-city').hide();
                },
            });
        });
        jQuery(document).on('click', '.allow_tobacco', function () {
            var allow_conditions = jQuery(this).val();
            if (allow_conditions == "yes") {
                jQuery('#allow_tobacco_no').prop('checked', false); // Unchecks it
            }
            if (allow_conditions == "no") {
                jQuery('#allow_tobacco_yes').prop('checked', false); // Unchecks it
            }
        });
        jQuery(document).on('click', '.spouse_checkbox', function () {
            var allow_conditions = jQuery(this).val();
            if (allow_conditions == "yes") {
                jQuery('#spouse_no').prop('checked', false); // Unchecks it
                jQuery('#spouse_wapper').show();
                $(".spouse_dob").attr("required", true);
            }
            if (allow_conditions == "no") {
                jQuery('#spouse_yes').prop('checked', false); // Unchecks it
                jQuery('#spouse_wapper').hide();
                $(".spouse_dob").attr("required", false);
            }
        });
        jQuery(document).on('click', '.spouse_gender', function () {
            var allow_conditions = jQuery(this).val();
            if (allow_conditions == "male") {
                jQuery('#spouse_gender_female').prop('checked', false); // Unchecks it
            }
            if (allow_conditions == "female") {
                jQuery('#spouse_gender_male').prop('checked', false); // Unchecks it
            }
        });
        jQuery(document).on('click', '.gender', function () {
            var allow_conditions = jQuery(this).val();
            if (allow_conditions == "male") {
                jQuery('#gender_female').prop('checked', false); // Unchecks it
            }
            if (allow_conditions == "female") {
                jQuery('#gender_male').prop('checked', false); // Unchecks it
            }
        });
    });
</script>



