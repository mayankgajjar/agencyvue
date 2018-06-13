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
    #document_priview {font-size: 50px;}
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
<div class="wrapper broker_profile_wapper">
    <div class="container">
        <div class="loader-select-city"><img class="loader-image" src="<?= base_url() . 'assets/crm_image/' ?>ring.gif"></div>
        <?php $profile = $broker_details[0]; ?>
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Edit Broker</h4>
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() . 'agent/dashboard' ?>">Dashboard</a></li>
                    <li><a href="<?= base_url() . 'agent/ManageAgents' ?>">Manage Brokers</a></li>                    
                    <li class="active"><?= $profile['first_name'] . ' ' . $profile['last_name'] ?></li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 col-lg-3">
                <div class="profile-detail card-box">
                    <div>
                        <img src="<?= base_url() ?>assets/crm_image/placeholder_agent.png" class="img-circle" alt="profile-image">
                        <div class="gap_creater" style="padding: 10px"></div>
                        <div class="text-left">
                            <p class="text-muted font-13"><strong>Created Date :</strong> <span class="m-l-15"><?= $profile['created_date']; ?></span></p>
                            <p class="text-muted font-13"><strong>Active Member :</strong><span class="m-l-15"> </span></p>
                            <p class="text-muted font-13"><strong>Retension Rate :</strong> <span class="m-l-15"> </span></p>
                            <p class="text-muted font-13"><strong>Domain Name :</strong> <span class="m-l-15"><?php if(isset($domain_name)){ echo $domain_name;} else{ } ?></span></p>
                        </div>  
                    </div>
                    <hr>
                    <div class="card-box">
                        <h4 class="m-t-0 m-b-20 header-title"><b> Products <i class="fa fa-shopping-cart"></i></b></h4>
                        <div class="friend-list">
                            <ul>
                                <li>Product One</li>
                                <li>Product Beta</li>
                                <li>Product API</li>
                                <li>Product Two</li>
                            </ul>
                        </div>
                    </div>

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

            <div class="col-lg-9 col-md-8 card-box all_details_broker_profile">
                <form id="broker-profile" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center"><h3>Personal Information</h3></div>
                            <div class="form-group clearfix">
                                <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <label for="fname">First Name * </label>
                                        <input type="text" id="fname" name="first_name" class="required form-control" autocomplete="off" value="<?= $profile['first_name'] ?>">
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="mname">Middle Name * </label>
                                        <input type="text" id="mname" name="middle_name" class="required form-control" autocomplete="off" value="<?= $profile['middle_name'] ?>">
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="fname">Last Name * </label>
                                        <input type="text" id="lname" name="last_name" class="required form-control" autocomplete="off" value="<?= $profile['last_name'] ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <label for="user_email">Email * </label>
                                        <input type="email" id="user_email" name="email_address" class="required form-control" autocomplete="off" value="<?= $profile['personal_email_address'] ?>" disabled>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="user_phno">Phone Number * </label>
                                        <input type="text" id="user_phno" name="phone_number" class="required form-control custom_phone_number_marks" autocomplete="off" value="<?= $profile['personal_phone_number'] ?>">
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="user_dob">Date Of Birth * </label>
                                        <div class="date-picker-div">
                                            <input class="form-control dtpicker" placeholder="mm/dd/yyyy" id="datepicker-autoclose" name="dob" type="text" value="<?= date('m/d/Y', strtotime($profile['dob'])) ?>">
                                            <span class="input-group-addon bg-custom b-0 text-white"><i class="icon-calender"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <div class="col-lg-12">
                                    <div class="col-lg-8">
                                        <label for="user_add">Address * </label>
                                        <input type="text" id="user_add" name="address" class="required form-control" autocomplete="off" value="<?= $profile['personal_address'] ?>">
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="user_add_detail">Apartment,Suite,ect. </label>
                                        <input type="text" id="user_add_detail" name="address_addtional" class="form-control" autocomplete="off" value="<?= $profile['personal_address_addtional'] ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <label for="user_state">State * </label>
                                        <select class="form-control required selstate" id="user_state" name="sel_state" onchange="selectCity(this.value, 'user_city', 'sel_city')">
                                            <option value="0">Select State</option>
                                            <?php foreach ($state as $key => $value) { ?>
                                                <option value="<?php echo $value['state_code']; ?>" <?php echo ( $value['state_code'] == $profile['personal_state']) ? 'selected' : ''; ?>><?php echo $value['state']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-lg-4">
                                        <label for="user_city">City * </label>
                                        <select class="form-control required" id="user_city" name="sel_city">
                                            <?php foreach ($city_pri as $key => $value) { ?>
                                                <option value=<?php echo $value['city']; ?> <?php echo($value['city'] == $profile['personal_city']) ? 'selected' : '' ?>><?php echo $value['city']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-lg-4">
                                        <label for="user_zip">Zip Code * </label>
                                        <input type="text" id="user_zip" name="zipcode" class="required form-control custome_zipcode" autocomplete="off" value="<?= $profile['personal_zipcode'] ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center"><h3> Business Information </h3></div>
                            <div class="form-group clearfix">
                                <div class="col-lg-12">
                                    <div class="col-lg-8">
                                        <label for="lb_name">Legal Business Name * </label>
                                        <input type="text" id="lb_name" name="legal_bussiness_name" class="required form-control" autocomplete="off" value="<?= $profile['legal_bussiness_name'] ?>">
                                    </div>
                                </div>

                                <div class="form-group clearfix">
                                    <div class="col-lg-12">
                                        <div class="col-lg-4">
                                            <label for="b_email">Business Email Address * </label>
                                            <input type="email" id="b_email" name="business_email_address" class="required form-control" autocomplete="off" value="<?= $profile['business_email_address'] ?>">
                                        </div>

                                        <div class="col-lg-4">
                                            <label for="custom_service_name">Customer Service Number</label>
                                            <input type="text" id="custom_service_name" name="custom_service_name" class="form-control custom_phone_number_marks" autocomplete="off" value="<?= $profile['custom_service_name'] ?>">
                                        </div>

                                        <div class="col-lg-4">
                                            <label for="fax_number">Fax Number</label>
                                            <input type="text" id="fax_number" name="fax_number" class="form-control cusfaxnumber" autocomplete="off" value="<?= $profile['business_fax_number'] ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group clearfix">
                                    <div class="col-lg-12">
                                        <div class="col-lg-8">
                                            <label for="business_add">Address * </label>
                                            <input type="text" id="business_add" name="business_address" class="required form-control" autocomplete="off" value="<?= $profile['business_address'] ?>">
                                        </div>

                                        <div class="col-lg-4">
                                            <label for="business_add_detail">Unit, Suite, Etc. </label>
                                            <input type="text" id="business_add_detail" name="business_address_addtional" class="form-control" autocomplete="off" value="<?= $profile['business_add_addtional'] ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group clearfix">
                                    <div class="col-lg-12">
                                        <div class="col-lg-4">
                                            <label for="business_state">State * </label>
                                            <select class="form-control required selstate" id="business_state" name="business_state" onchange="selectCity(this.value, 'business_city', 'business_city')">
                                                <option value="0">Select State</option>
                                                <?php foreach ($state as $key => $value) { ?>
                                                    <option value="<?php echo $value['state_code']; ?>" <?php echo ( $value['state_code'] == $profile['business_state']) ? 'selected' : ''; ?>><?php echo $value['state']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="col-lg-4">
                                            <label for="business_city">City * </label>
                                            <select class="form-control required" id="business_city" name="business_city">
                                                <?php foreach ($city_bussiness as $key => $value) { ?>
                                                    <option value=<?php echo $value['city']; ?> <?php echo($value['city'] == $profile['business_city']) ? 'selected' : '' ?>><?php echo $value['city']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="col-lg-4">
                                            <label for="business_zip">Zip Code * </label>
                                            <input type="text" id="business_zip" name="business_zip" class="required form-control custome_zipcode" autocomplete="off" value="<?= $profile['business_zip_code'] ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row"> 

                        <div class="col-lg-12"> 
                            <div class="text-center"> <h3> Commissions Information </h3> </div>
                            <div class="form-group clearfix">
                                <div class="col-lg-12">
                                    <div class="col-lg-6">
                                        <h4>Pay Commissions To..</h4>
                                        <div class="col-lg-4">
                                            <div class="checkbox checkbox-primary">
                                                <input id="my_self" type="checkbox" name="commision_payto" class="commision_payto" value="my_self" <?php echo ($profile['commision_payto'] == 'my_self') ? 'checked' : ''; ?>>
                                                <label for="my_self"> My Self</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="checkbox checkbox-primary">
                                                <input id="my_business" type="checkbox" class="commision_payto" name="commision_payto" value="my_business" <?php echo ($profile['commision_payto'] == 'my_business') ? 'checked' : ''; ?>>
                                                <label for="my_business"> My Business </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group clearfix" id="federal_tax_id_wapp" style="<?php echo ($profile['commision_payto'] == 'my_business') ? '' : 'display: none'; ?>">
                                <div class="col-lg-12">
                                    <div class="col-lg-6">
                                        <label for="federal_tax_id">Federal Tax ID</label>
                                        <input type="text" id="federal_tax_id" name="federal_tax_id" class="form-control federal_tax_id" autocomplete="off" value="<?= $profile['federal_tax_id'] ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group clearfix" id="social_security_number_wapp" style="<?php echo ($profile['commision_payto'] == 'my_business') ? 'display: none' : ''; ?>">
                                <div class="col-lg-12">
                                    <div class="col-lg-6">
                                        <label for="social_security_number">Social Security Number</label>
                                        <input type="text" id="social_security_number" name="social_security_number" class="form-control securitynumber" autocomplete="off" value="<?= $profile['social_security_number'] ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <div class="col-lg-12">
                                    <div class="col-lg-6">
                                        <h4>I would like to receive my money by...</h4>
                                        <div class="col-lg-4">
                                            <div class="checkbox checkbox-primary">
                                                <input id="paper_check" type="checkbox" name="commsion_receive" value="Paper_Check" class="commsion_receive" <?php echo ($profile['commsion_receive'] == 'Paper_Check') ? 'checked' : ''; ?>>
                                                <label for="paper_check"> Paper Check </label>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="checkbox checkbox-primary">
                                                <input id="direct_deposit" type="checkbox" name="commsion_receive" value="Direct_Deposit" class="commsion_receive" <?php echo ($profile['commsion_receive'] == 'Direct_Deposit') ? 'checked' : ''; ?>>
                                                <label for="direct_deposit"> Direct Deposit </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <div class="col-lg-12">
                                    <div class="col-lg-8">
                                        <label for="commision_address">Name on Account * </label>
                                        <input type="text" id="acc_name" name="acc_name" class="required form-control" autocomplete="off" value="<?= $profile['commision_name_on_account'] ?>">
                                    </div>

                                    <div class="col-lg-8" id='com_bank_name' style="<?php echo ($profile['commsion_receive'] == 'Direct_Deposit') ? '' : 'display:none'; ?>">
                                        <label for="commision_address">Bank Name * </label>
                                        <input type="text" id="bank_name" name="bank_name" class="form-control" autocomplete="off" value="<?= $profile['commision_bank_name'] ?>">
                                    </div>

                                    <div class="col-lg-8">
                                        <label for="commision_address">Address * </label>
                                        <input type="text" id="comm_add" name="commision_address" class="required form-control" autocomplete="off" value="<?= $profile['commision_address'] ?>">
                                    </div>

                                    <div class="col-lg-4">
                                        <label for="commision_add_details">Unit, Suite, Etc. </label>
                                        <input type="text" id="user_add_detail" name="commision_add_details" class="form-control" autocomplete="off" value="<?= $profile['commision_add_addtional'] ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <label for="commision_state">State * </label>
                                        <select class="form-control required selstate" id="commision_state" name="commision_state" onchange="selectCity(this.value, 'commision_city', 'commision_city')">
                                            <option value="0">Select State</option>
                                            <?php foreach ($state as $key => $value): ?>
                                                <option value="<?php echo $value['state_code']; ?>" <?php echo ( $value['state_code'] == $profile['commision_state']) ? 'selected' : ''; ?>><?php echo $value['state']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-lg-4">
                                        <label for="commision_city">City * </label>
                                        <select class="form-control required selcity" id="commision_city" name="commision_city">
                                            <?php foreach ($city_commision as $key => $value): ?>
                                                <option value=<?php echo $value['city']; ?> <?php echo($value['city'] == $profile['commision_city']) ? 'selected' : '' ?>><?php echo $value['city']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="commision_zipcode">Zip Code * </label>
                                        <input type="text" id="comm_zip" name="commision_zipcode" class="required form-control custome_zipcode" autocomplete="off" value="<?= $profile['commision_zipcode'] ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="direct_deposit_wapp" style="<?php echo ($profile['commsion_receive'] == 'Direct_Deposit') ? '' : 'display:none'; ?>">
                                <div class="form-group clearfix">
                                    <div class="col-lg-12">
                                        <div class="col-lg-4">
                                            <div class="checkbox checkbox-primary">
                                                <input id="checking" type="checkbox" name="select_account" value="checking" class="select_account" <?php echo ($profile['account_options'] == 'checking') ? 'checked' : ''; ?>>
                                                <label for="checking"> Checking Account </label>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="checkbox checkbox-primary">
                                                <input id="saving" type="checkbox" name="select_account" value="saving" class="select_account" <?php echo ($profile['account_options'] == 'saving') ? 'checked' : ''; ?>>
                                                <label for="saving"> Saving Account </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group clearfix">
                                    <div class="col-lg-12">
                                        <div class="col-lg-8">
                                            <label for="rounting_number">Routing Number</label>
                                            <input type="text" id="rounting_number" name="rounting_number" class="form-control" autocomplete="off" value="<?= $profile['rounting_number'] ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group clearfix">
                                    <div class="col-lg-12">
                                        <div class="col-lg-8">
                                            <label for="commision_address">Account Number</label>
                                            <input type="text" id="user_add" name="ac_name" class="form-control" autocomplete="off" value="<?= $profile['account_number'] ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group clearfix">
                                    <div class="col-lg-12">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="control-label">Upload Void Check</label>
                                                <input type="file" class="filestyle" data-buttonname="btn-default choose-file-btn" name="img" onchange="ValidateSingleInput(this);" value=<?php echo $profile["upload_void_check"]; ?>>
                                                <div class="error_image" style="font-style: italic; color: red; margin-top: 8px; display: none;">Please select jpg , jpeg , png , bmp , gif  or  pdf file format.</div>
                                            </div>
                                        </div>
                                    </div>       
                                </div>
                                <?php if($profile['upload_void_check'] != ''){ ?>
                                    <div class="form-group clearfix">
                                        <div class="col-lg-12">
                                            <div class="col-lg-10">
                                                <label id="fileLabel">View Selected File : </label>
                                                <a href=<?php echo site_url().'/assets/crm_image/broker/'.$profile["upload_void_check"]; ?> target="_blank"><?php echo $profile["upload_void_check"]; ?></a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                            </div>

                            <div>&nbsp;</div>

                            <div class="form-group clearfix text-center">
                                <div class="col-lg-12">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success">Save</button>
                                            <a class="btn btn-default waves-effect waves-light" href="<?= base_url() . 'agent/ManageAgents' ?>"> <span class="btn-label"><i class="fa fa-arrow-left"></i>
                                                </span>Back</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">

    (function ($) {
        $(document).on('click', '.commision_payto', function () {
            var payto = $(this).val();
           if (payto == "my_self") {
                $('#my_business').prop('checked', false); // Unchecks it
                $('#federal_tax_id_wapp').hide();
                $('#social_security_number_wapp').show();
                $('#social_security_number').addClass("required");
                $('#federal_tax_id').removeClass('required');
            }
            if (payto == "my_business") {
                $('#my_self').prop('checked', false); // Unchecks it
                $('#social_security_number_wapp').hide();
                $('#federal_tax_id_wapp').show();
                $('#federal_tax_id').addClass("required");
                $('#social_security_number').removeClass('required');
            }
        });

        $(document).on('click', '.commsion_receive', function () {
            var commsion_receive = $(this).val();
            if (commsion_receive == null) {
                $('.direct_deposit_wapp').hide();
            }

            if (commsion_receive == "Paper_Check") {
                $('#direct_deposit').prop('checked', false); // Unchecks it
                $('#com_bank_name').hide();
                $('.direct_deposit_wapp').hide();
            }

            if (commsion_receive == "Direct_Deposit") {
                $('#paper_check').prop('checked', false); // Unchecks it
                $('#com_bank_name').show();
                $('.direct_deposit_wapp').show();
            }
        });

        $(document).on('click', '.select_account', function () {
            var select_account = $(this).val();
            if (select_account == "checking") {
                $('#saving').prop('checked', false); // Unchecks it
            }
            if (select_account == "saving") {
                $('#checking').prop('checked', false); // Unchecks it
            }
        });
    })(jQuery);

    function selectCity(state, id, name, city = null) {
        var state = state;
        $('#' + id).empty();
        if (state == '')
        {
            alert("Select State");
        } else {
            $('.loader-select-city').show();
            $.ajax({
                url: '<?php echo base_url() ?>agent/ManageAgents/newCity',
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

<script>
var _validFileExtensions = [".jpg", ".jpeg", ".bmp", ".gif", ".png", ".pdf"];    
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