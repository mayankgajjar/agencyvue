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
    input.textInputError {border-color: red;}
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
</style>
	<!-- Marked Input JS -->

<div class="wrapper">
    <div class="container">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Vendor</h4>
                <ol class="breadcrumb">
                <li><a href="<?= base_url() . 'admin/dashboard' ?>">Admin Dashboard</a></li>
                    <li><a href="<?= base_url() . 'admin/vendors' ?>">Vendors</a></li>
                    <li class="active"><?php echo (isset($vendor_info[0]['vendor_name'])) ? $vendor_info[0]['vendor_name'] : ''; ?></li>
                </ol>
            </div>
        </div>


            <div class="row">

                 <?php  if (isset($error)) { ?>
                    <div class="content pt0">
                        <div class="alert alert-danger">
                            <a class="close" data-dismiss="alert">×</a>
                            <strong><?= $error ?></strong>
                        </div>
                    </div>
                <?php  } ?>

           

                <div class="col-lg-12 col-md-12">
                    <div class="card-box">
                        <form id="frm_save_vendor" method="post" class="data-parsley-validate novalidate" enctype="multipart/form-data">
                            <div class="text-center">
                                <h3><strong>VENDOR DETAILS</strong></h3>
                            </div>   
                            <div class="primary_div">
                                <div class="form-group clearfix">
                                    <div class="col-lg-12">
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="fname">Vendor Name * </label>
                                            <input type="text" id="fname" name="ven_first_name" class="required form-control " autocomplete="off" value="<?php echo (isset($vendor_info[0]['vendor_name'])) ? $vendor_info[0]['vendor_name'] : ''; ?>">
                                        </div>
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="Website">Website </label>
                                            <input type="text" id="website" name="ven_website" class="form-control" autocomplete="off" value="<?php echo (isset($vendor_info[0]['vendor_website'])) ? $vendor_info[0]['vendor_website'] : ''; ?>">
                                        </div>
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="Email Address">Email Address * </label>
                                            <input type="email" id="email" name="ven_email" class="required form-control" autocomplete="off" value="<?php echo (isset($vendor_info[0]['vendor_email_address'])) ? $vendor_info[0]['vendor_email_address'] : ''; ?>">
                                            <div id='email_msg' style="margin-top: 10px;"></div>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group clearfix">
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="customerservicenumber">Customer Service Number * </label>
                                        <input type="text" id="customerservicenumber" name="customerservicenumber" class="form-control required" autocomplete="off" value="<?php echo (isset($vendor_info[0]['vendor_customer_service_number'])) ? $vendor_info[0]['vendor_customer_service_number'] : ''; ?>">

                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="faxnumber">Fax Number  </label>
                                        <input type="text" id="venfaxnumber" name="ven_faxnumber" class="form-control" autocomplete="off" value="<?php echo (isset($vendor_info[0]['vendor_fax_number'])) ? $vendor_info[0]['vendor_fax_number'] : ''; ?>">
                                    </div>

                                </div>

                                <div class="form-group clearfix">
                                    <div class="col-lg-8">
                                        <label for="Address">Address * </label>
                                        <input type="text" id="ven_address" name="ven_address" class="required form-control" autocomplete="off" value="<?php echo (isset($vendor_info[0]['vendor_address'])) ? $vendor_info[0]['vendor_address'] : ''; ?>">
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="Apartment">Unit, Suite, Etc.  </label>
                                        <input type="text" id="ven_sub_address" name="ven_sub_address" class="form-control" autocomplete="off" value="<?php echo (isset($vendor_info[0]['vendor_sub_address'])) ? $vendor_info[0]['vendor_sub_address'] : ''; ?>">
                                    </div>
                                </div>

                                <div class="form-group clearfix">
                                     <div class="col-lg-4 input_wrapper">
                                        <label for="State">State * </label>
                                        <select class="form-control required" id="user_state" name="ven_state" onchange="selectCity(this.value, 'ven_city', 'ven_city')">
                                            <option value="">Select State</option>
                                            <?php foreach ($state as $key => $value) { ?>  
                                                 <option value="<?php echo $value['state_code']; ?>" <?php echo ( $value['state_code'] == $vendor_info[0]['vendor_state']) ? 'selected' : ''; ?>><?php echo $value['state']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-lg-4 input_wrapper">
                                        <label for="City">City * </label>
                                        <select class="form-control required selcity" id="ven_city" name="ven_city">
                                            <?php foreach ($vendor_city as $key => $value) { ?>
                                                <option value="<?php echo $value['city']; ?>" <?php echo ( $value['city'] == $vendor_info[0]['vendor_city']) ? 'selected' : ''; ?>><?php echo $value['city']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                   
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="zipcode">Zip Code * </label>
                                        <input type="text" id="cuszip" name="ven_zip" class="required form-control" autocomplete="off" value="<?php echo (isset($vendor_info[0]['vendor_zip_code'])) ? $vendor_info[0]['vendor_zip_code'] : ''; ?>">
                                    </div>
                                </div>

                                <div class="form-group clearfix">
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="zipcode">Upload Logo * </label>
                                        <input type="file" class="filestyle" data-buttonname="btn-default choose-file-btn" name="logo" onchange="ValidateSingleInput(this);">  
                                        <div class="error_image" style="font-style: italic; color: red; margin-top: 8px; display: none;">Please select jpg ,  png  or gif file format.</div>


                                    </div>
                                </div>

                                <div class="form-group clearfix">
                                    <div class="col-lg-4 input_wrapper">
                                        <img src="<?php echo site_url().'/assets/crm_image/vendor/'.$vendor_info[0]['vendor_logo']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <h3><strong>DAILY CONTACT</strong></h3>
                            </div>
                            <div class="form-group clearfix">
                                <div class="col-lg-4 input_wrapper">
                                    <label for="fname">Contact Name * </label>
                                    <input type="text" id="daily_contact_name" name="daily_contact_name" class="required form-control " autocomplete="off" value="<?php echo (isset($vendor_info[0]['daily_contact_name'])) ? $vendor_info[0]['daily_contact_name'] : ''; ?>">
                                </div>

                                <div class="col-lg-4 input_wrapper">
                                    <label for="fname">Email Address * </label>
                                    <input type="email" id="daily_contact_email" name="daily_contact_email" class="required form-control " autocomplete="off" value="<?php echo (isset($vendor_info[0]['daily_contact_email_address'])) ? $vendor_info[0]['daily_contact_email_address'] : ''; ?>">
                                </div>
                                <div class="col-lg-4 input_wrapper">
                                    <label for="mname">Contact Number * </label>
                                    <input type="text" id="daily_contact_no" name="daily_contact_no" class="required form-control " autocomplete="off" value="<?php echo (isset($vendor_info[0]['daily_contact_contact_number'])) ? $vendor_info[0]['daily_contact_contact_number'] : ''; ?>">
                                </div>
                                <div class="col-lg-4 input_wrapper">
                                    <label for="fname">Extension </label>
                                    <input type="text" id="daily_contact_extension" name="daily_contact_extension" class="form-control " autocomplete="off" value="<?php echo (isset($vendor_info[0]['daily_contact_extension'])) ? $vendor_info[0]['daily_contact_extension'] : ''; ?>">
                                </div>

                            </div>
                            <div class="text-center">
                                <h3><strong>PAYMENT TERMS</strong></h3>
                            </div>
                            <div class="form-group clearfix">
                                <div class="col-lg-4 input_wrapper">
                                    <label for="fname">Invoice Due Date *  </label>
                                    <div class="date-picker-div">
                                        <input class="form-control multiple required" placeholder="mm/dd/yyyy" id="invoice_due_date" name="invoice_due_date" type="text"class="required form-control" value=<?php echo $due_date; ?>>
                                        <span class="input-group-addon bg-custom b-0 text-white"><i class="icon-calender"></i></span>

                                    </div>
                                </div>
                                <div class="col-lg-4 input_wrapper">
                                    <label for="State">Payment Method * </label>
                                    <select class="form-control required" id="payment_method" name="payment_method">
                                        <option value="">Select Payment Method</option>
                                        <option value="Invoice" <?php echo ($vendor_info[0]['payment_method'] == 'Invoice') ? "Selected" : ''; ?>>Invoice</option>
                                        <option value="Wire" <?php echo ($vendor_info[0]['payment_method'] == 'Wire') ? "Selected" : ''; ?>>Wire</option>
                                        <option value="ACH" <?php echo ($vendor_info[0]['payment_method'] == 'ACH') ? "Selected" : ''; ?>>ACH</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <div class="col-lg-4 input_wrapper">
                                    <label for="fname">Name On Account * </label>
                                    <input type="text" id="name_on_account" name="name_on_account" class="required form-control "autocomplete="off" value="<?php echo (isset($vendor_info[0]['payment_name_on_account'])) ? $vendor_info[0]['payment_name_on_account'] : ''; ?>">
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <div class="col-lg-4 input_wrapper">
                                    <label for="fname">Bank Name * </label>
                                    <input type="text" id="bank_name" name="bank_name" class="required form-control " autocomplete="off" value="<?php echo (isset($vendor_info[0]['payment_bank_name'])) ? $vendor_info[0]['payment_bank_name'] : ''; ?>">
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <div class="col-lg-8">
                                    <label for="fname">Address * </label>
                                    <input type="text" id="payment_address" name="payment_address" class="required form-control " autocomplete="off" value="<?php echo (isset($vendor_info[0]['payment_address'])) ? $vendor_info[0]['payment_address'] : ''; ?>">
                                </div>

                                <div class="col-lg-4 input_wrapper">
                                    <label for="fname">Unit, Suite, Etc. </label>
                                    <input type="text" id="payment_sub_address" name="payment_sub_address" class="form-control " autocomplete="off" value="<?php echo (isset($vendor_info[0]['payment_sub_address'])) ? $vendor_info[0]['payment_sub_address'] : ''; ?>">
                                </div>
                            </div>
                            <div class="form-group clearfix">

                                <div class="col-lg-4 input_wrapper">
                                    <label for="State">State * </label>
                                    <select class="form-control required" id="payment_state" name="payment_state" onchange="selectCity(this.value, 'payment_city', 'payment_city')">
                                        <option value="">Select State</option>
                                        <?php foreach ($state as $key => $value) { ?>  
                                                <option value="<?php echo $value['state_code']; ?>" <?php echo ( $value['state_code'] == $vendor_info[0]['payment_state']) ? 'selected' : ''; ?>><?php echo $value['state']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="col-lg-4 input_wrapper">
                                    <label for="City">City * </label>
                                    <select class="form-control required selcity" id="payment_city" class="required form-control" name="payment_city">
                                            <?php foreach ($payment_city as $key => $value) { ?>
                                                <option value="<?php echo $value['city']; ?>" <?php echo ( $value['city'] == $vendor_info[0]['payment_city']) ? 'selected' : ''; ?>><?php echo $value['city']; ?></option>
                                            <?php } ?>
                                    </select>
                                </div>
                                
                                <div class="col-lg-4 input_wrapper">
                                    <label for="zipcode">Zip Code * </label>
                                    <input type="text" id="payment_zip" name="payment_zip" class="required form-control " autocomplete="off" value="<?php echo (isset($vendor_info[0]['payment_zip_code'])) ? $vendor_info[0]['payment_zip_code'] : ''; ?>">
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <div class="col-lg-6">

                                    <div class="col-lg-4">
                                        <div class="checkbox checkbox-primary">
                                            <input id="Checking" type="checkbox" name="payment_account" class="payment_account" class="required form-control " value="Checking" <?php echo ($vendor_info[0]['payment_account'] == 'Checking') ? "checked" : ''; ?>>
                                            <label for="Checking">Checking Account </label>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="checkbox checkbox-primary">
                                            <input id="Saving" type="checkbox" class="payment_account" class="required form-control " name="payment_account" value="Saving" <?php echo ($vendor_info[0]['payment_account'] == 'Saving') ? "checked" : ''; ?>>
                                            <label for="Saving"> Saving Account </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <div class="col-lg-4 input_wrapper">
                                    <label for="fname">Routing Number * </label>
                                    <input type="text" id="routing number" name="routing_number" class="required form-control " autocomplete="off" value="<?php echo (isset($vendor_info[0]['payment_routing_number'])) ? $vendor_info[0]['payment_routing_number'] : ''; ?>">
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <div class="col-lg-4 input_wrapper">
                                    <label for="fname">Account Number * </label>
                                    <input type="text" id="account_no" name="account_no" class="required form-control " autocomplete="off" value="<?php echo (isset($vendor_info[0]['payment_account_number'])) ? $vendor_info[0]['payment_account_number'] : ''; ?>">
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <div class="col-lg-4 input_wrapper">
                                    <label for="fname">Upload Void Check * </label>
                                    <input type="file" class="filestyle" data-buttonname="btn-default choose-file-btn" name="img" onchange="ValidateSingleInput(this);">
                                    <div class="error_image" style="font-style: italic; color: red; margin-top: 8px; display: none;">Please select jpg ,  png  or gif file format.</div>
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <div class="col-lg-4 input_wrapper">
                                    <a href="<?php echo site_url().'/assets/crm_image/vendor/'.$vendor_info[0]['payment_check']; ?>" target="_blank">
                                        <img src="<?php echo site_url().'/assets/crm_image/vendor/'.$vendor_info[0]['payment_check']; ?>"  height="100" width="180">
                                    </a>
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <label class="col-lg-12 control-label ">(*) Mandatory</label>
                            </div>

                            <div>&nbsp;</div>

                            <div class="form-group clearfix">
                                <div class="form-group bottom-control text-center">
                                    <button type="submit" class="btn btn-success" name="save" value="save">Save</button>
                                    <a class="btn btn-default waves-effect waves-light" href="<?= base_url() . 'admin/vendors' ?>"> <span class="btn-label"><i class="fa fa-arrow-left"></i>
                                        </span>Back</a>
                                </div>
                            </div>
                            </form> 
                    </div>
                    <div class="loader-select-city"><img class="loader-image" src="<?= base_url() . 'assets/crm_image/' ?>ring.gif"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('form').parsley();

        $(document).on('click', '.payment_account', function () {
            var payment_account = $(this).val();
            if (payment_account == "Checking") {
                $('#Saving').prop('checked', false); // Unchecks it
            }
            if (payment_account == "Saving") {
                $('#Checking').prop('checked', false); // Unchecks it
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
  
</script>

<script type="text/javascript">
    jQuery(function ($) {
        $("#customerservicenumber").mask("(999) 999-9999");
        $("#daily_contact_no").mask("(999) 999-9999");        
        $("#cuszip").mask("99999");
        $("#payment_zip").mask("99999");
        $("#venfaxnumber").mask("(999) 999-9999");
    });
</script>

<script>
var _validFileExtensions = [".gif", ".jpg", ".png"];    
function ValidateSingleInput(oInput) {
    if (oInput.type == "file") {
        var sFileName = oInput.value;
         if (sFileName.length > 0) {
            var blnValid = false;
            for (var j = 0; j < _validFileExtensions.length; j++) {
                var sCurExtension = _validFileExtensions[j];
                if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                    blnValid = true;
                    $(".error_image").hide();
                    break;
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
</script>





