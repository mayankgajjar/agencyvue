<div class="wrapper">
    <div class="container">

        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Add New Sub Agency</h4>
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() . 'agent/dashboard' ?>">Dashboard</a></li>
                    <li><a href="<?= base_url() . 'agent/agencies' ?>">Manage Agencies</a></li>
                    <li class="active">Add New Agency</li>
                </ol>
            </div>
        </div>
        <input type="hidden" name="pop-up" id="pop-up">
        <?php
        if ($this->session->flashdata('success')):
            $data_pop = $this->session->flashdata('success');
            ?>
            <script>
                $("#pop-up").val("<?= $data_pop['popup']; ?>");
            </script>
            <?php
            $this->session->set_flashdata('success', false);
        elseif ($this->session->flashdata('error')):
            ?>
            <div class="content pt0">
                <div class="alert alert-danger">
                    <a class="close" data-dismiss="alert">×</a>
                    <strong><?= $this->session->flashdata('error') ?></strong>
                </div>
            </div>
            <?php
            $this->session->set_flashdata('error', false);
        elseif (validation_errors()):
            ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo validation_errors(); ?>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card-box">
                    <form id="wizard-validation-form" method="post" enctype="multipart/form-data" class="myform">
                        <div>
                            <section>
                                <div class="text-center  m-t-20"> <h3> General information </h3> </div>
                                <div class="form-group clearfix">
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <label for="fname">Agency Name * </label>
                                            <input type="text" id="fname" name="agency_name" class="required form-control" autocomplete="off" value="<?php echo set_value('agency_name'); ?>" reuqired>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="cname">Contact Name * </label>
                                            <input type="text" id="cname" name="contact_name" class="required form-control" autocomplete="off" value="<?php echo set_value('contact_name'); ?>" reuqired>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="col-md-12">
                                        <div class="col-lg-6">
                                            <label for="user_phno">Phone Number * </label>
                                            <input type="text" id="user_phno" name="phone_number" class="required form-control child_phone_number" autocomplete="off" value="<?php echo set_value('phone_number'); ?>" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="login_email"> Contact Email * </label>
                                            <input type="email" id="login-email" name="contact_email" class="required form-control" autocomplete="off" value="<?php echo set_value('contact_email'); ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <label for="customer_service_email"> Customer Service Email * </label>
                                            <input type="email" id="customer_service_email" name="customer_service_email" class="required form-control" autocomplete="off" value="<?php echo set_value('customer_service_email'); ?>" required>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="csn"> Customer Service Number </label>
                                            <input type="text" id="csn" name="customer_service_number" class="required form-control customer_service_number_agency" autocomplete="off" value="<?php echo set_value('customer_service_number'); ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="col-lg-12">
                                        <div class="col-lg-8">
                                            <label for="user_add">Address * </label>
                                            <input type="text" id="user_add" name="address" class="required form-control" autocomplete="off" value="<?php echo set_value('address'); ?>" required>
                                        </div>

                                        <div class="col-lg-4">
                                            <label for="user_add_detail"> Unit, Building, Etc. </label>
                                            <input type="text" id="user_add_detail" name="address_addtional" class="form-control" autocomplete="off" value="<?php echo set_value('address_addtional'); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="col-lg-12">
                                        <div class="col-lg-4">
                                            <label for="user_state">State * </label>
                                            <select class="form-control required selstate" id="user_state" name="sel_state">
                                                <option value="">Select State</option>
                                                <?php foreach ($state as $key => $value) { ?>
                                                    <option value="<?php echo $value['state_code']; ?>" ><?php echo $value['state']; ?></option>
                                                <?php } ?>
                                            </select>
                                            <div class="loader-select-city"><img class="loader-image" src="<?= base_url() . 'assets/crm_image/' ?>ring.gif"></div>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="user_city">City * </label>
                                            <select class="form-control required" id="user_city" name="sel_city">
                                                <?php foreach ($city_list as $value) { ?>
                                                    <option value=<?php echo $value['city']; ?>><?php echo $value['city']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="user_zip">Zip Code * </label>
                                            <input type="text" id="user_zip" name="zipcode" class="required form-control custome_zipcode" autocomplete="off" value="<?php echo set_value('zipcode'); ?>" required>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section>
                                <div class="text-center m-t-20"><h3> Bank information </h3></div>
                                <div class="form-group clearfix">
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <label for="angecy_bank_name">Bank Name * </label>
                                            <input type="text" id="angecy_bank_name" name="angecy_bank_name" class="required form-control angecy_bank_name" autocomplete="off" value="<?php echo set_value('angecy_bank_name'); ?>" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="angecy_bank_add">Bank Address * </label>
                                            <input type="text" id="angecy_bank_add" name="angecy_bank_add" class="required form-control angecy_bank_add" autocomplete="off" value="<?php echo set_value('angecy_bank_add'); ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="col-lg-12">
                                        <div class="col-lg-4">
                                            <label for="bank_state">Bank State * </label>
                                            <select class="form-control required selstate" id="bank_state" name="bank_state">
                                                <option value="">Select State</option>
                                                <?php foreach ($state as $key => $value) { ?>
                                                    <option value="<?php echo $value['state_code']; ?>" ><?php echo $value['state']; ?></option>
                                                <?php } ?>
                                            </select>
                                            <div class="loader-select-city"><img class="loader-image" src="<?= base_url() . 'assets/crm_image/' ?>ring.gif"></div>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="bank_city">Bank City * </label>
                                            <select class="form-control required" id="bank_city" name="bank_city">
                                                <?php foreach ($city_list as $value) { ?>
                                                    <option value=<?php echo $value['city']; ?>><?php echo $value['city']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="bank_zipcode">Zip Code * </label>
                                            <input type="text" id="bank_zipcode" name="bank_zipcode" class="required form-control bank_zipcode zipmark" autocomplete="off" value="<?php echo set_value('bank_zipcode'); ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="col-lg-12">
                                        <div class="col-lg-4">
                                            <label for="name_on_account">Name on Account * </label>
                                            <input type="text" id="name_on_account" name="name_on_account" class="required form-control name_on_account" autocomplete="off" value="<?php echo set_value('name_on_account'); ?>" required>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="account_number">Account Number * </label>
                                            <input type="text" id="account_number" name="account_number" class="required form-control account_number" autocomplete="off" value="<?php echo set_value('account_number'); ?>" required>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="routing_number">Routing Number * </label>
                                            <input type="text" id="routing_number" name="routing_number" class="required form-control routing_number" autocomplete="off" value="<?php echo set_value('routing_number'); ?>" required>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section>
                                <div class="text-center  m-t-20"> <h3> Login Information </h3></div>
                                <div class="form-group clearfix">
                                    <div class="col-lg-12">
                                        <div class="col-md-8">
                                            <label for="login_email"> Login Email * </label>
                                            <input type="email" id="login_email" name="login_email" class="required form-control" autocomplete="off" value="<?php echo set_value('login_email'); ?>"  required>
                                            <div id='email_msg' style="margin-top: 10px;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="col-lg-12">
                                        <div class="col-lg-8">
                                            <label for="password">Password * </label>
                                            <input type="password" id="password" name="password" class="required form-control" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="col-lg-12">
                                        <div class="col-lg-8">
                                            <label for="cpassword">Confirm Password * </label>
                                            <input type="password" id="cpassword" name="cpassword" class="required form-control" data-parsley-equalto="#password" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="col-lg-12">
                                        <div class="col-lg-4">
                                            <label for="domain_name">Domain name * </label>
                                            <input type="text" id="domain_name" name="domain_name" class="required form-control" autocomplete="off" value="<?php echo set_value('domain_name'); ?>" required>
                                            <div id='domain_msg' style="margin-top: 10px;"></div>
                                        </div>
                                        <div class="col-lg-4 input_wrapper error-msg-fix">
                                            <label for="zipcode">Upload Agency Logo  </label>
                                            <input type="file" class="filestyle required" name="agency_logo" data-buttonname="btn-default" onchange="ValidateSingleInput1(this);">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="col-md-12 error-msg-fix">
                                        <div class="col-lg-3">
                                            <label for="zipcode">Upload w9 Form  </label>
                                            <input type="file" class="filestyle required" name="agency_w9" data-buttonname="btn-info" onchange="ValidateSingleInput(this);">
                                        </div>
                                        <div class="col-lg-3 col-lg-offset-1">
                                            <label for="zipcode">Upload Direct Deposit Form </label>
                                            <input type="file" class="filestyle required" name="agency_direct_deposit" data-buttonname="btn-info" onchange="ValidateSingleInput(this);">
                                        </div>
                                        <div class="col-lg-3 col-lg-offset-1">
                                            <label for="zipcode">Upload Contract Agreement  </label>
                                            <input type="file" class="filestyle required" name="agency_contract_agreement" data-buttonname="btn-info" onchange="ValidateSingleInput(this);">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="col-lg-12">
                                        <div class="checkbox checkbox-primary text-center">
                                            <input type="submit" class="btn btn-default btn-md" name="save" value="Add Agency">
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="custom-loader" style="display: none">
            <div class="loader"></div>
        </div>
        <!--Payment Pop-up-->
        <div id="panel-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content p-0 b-0">
                    <div class="panel panel-color panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Please Make A Payment For Registering Agency </h3>
                        </div>
                        <div class="panel-body">
                            <div class="card-box">
                                <div class="row">
                                    <form method="post" id="payment_info" novalidate="" class="payment_info">
                                        <div class="">
                                            <div class="tab-content">
                                                <div id="home" class="tab-pane fade in active">
                                                    <div class="credit-card-details">
                                                        <div class="m-b-20">
                                                            <h5>Enter Card Details And Make Payment Of $55 As Registration Fee</h5>
                                                        </div>
                                                        <div class="form-group col-md-8 pad-zero">
                                                            <label>CARD NUMBER</label>
                                                            <div class="detail-box card-valid">
                                                                <input type="hidden" name="naid" value="<?php echo $data_pop['naid']; ?>">
                                                                <input type="text" placeholder="123 123" autocomplete="off" data-parsley-type='number' data-parsley-maxlength="16" class="form-control required" name="card_number" id="card_number" value="">
                                                                <p><i class="fa fa-credit-card" aria-hidden="true"></i></p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-4 pad-zero">
                                                            <label>CARD CVC NUMBER</label>
                                                            <div class="detail-box card-valid">
                                                                <input type="text" placeholder="1234" autocomplete="off" class="form-control required" data-parsley-type='number' name="card_cvc" data-parsley-maxlength="4" data-parsley-minlength="3" id="card_cvc">
                                                                <p><i class="fa fa-credit-card" aria-hidden="true"></i></p>
                                                            </div>
                                                        </div>

                                                        <div class="form-group col-md-6 pad-zero">
                                                            <label>EXPIRATION MONTH</label>
                                                            <div class="detail-box month-valid">
                                                                <select class="form-control required" name="exp_month">
                                                                    <option value="">Select Expiration Month</option>
                                                                    <option value="01">01</option>
                                                                    <option value="02">02</option>
                                                                    <option value="03">03</option>
                                                                    <option value="04">04</option>
                                                                    <option value="05">05</option>
                                                                    <option value="06">06</option>
                                                                    <option value="07">07</option>
                                                                    <option value="08">08</option>
                                                                    <option value="09">09</option>
                                                                    <option value="10">10</option>
                                                                    <option value="11">11</option>
                                                                    <option value="12">12</option>
                                                                </select>
                                                                <p><i class="fa fa-clock-o" aria-hidden="true"></i></p>
                                                            </div>
                                                        </div>

                                                        <div class="form-group col-md-6 pad-zero">
                                                            <label>EXPIRATION YEAR</label>
                                                            <div class="detail-box year-valid">
                                                                <select class="form-control required" name="exp_year">
                                                                    <option value="">Select Expiration Year</option>
                                                                    <option value="2017">2017</option>
                                                                    <option value="2018">2018</option>
                                                                    <option value="2019">2019</option>
                                                                    <option value="2020">2020</option>
                                                                    <option value="2021">2021</option>
                                                                    <option value="2022">2022</option>
                                                                    <option value="2023">2023</option>
                                                                    <option value="2024">2024</option>
                                                                </select>
                                                                <p><i class="fa fa-clock-o" aria-hidden="true"></i></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="proceed-button">
                                                <button type="submit" name="stripe" id="payment" value="check_my">PROCEED TO SECURE PAYMENT<span><i class="fa fa-lock" aria-hidden="true"></i></span></button>
                                            </div>
                                            <div class="payment-content">
                                                <div class="test-mode"><a href="#">Test Mode</a></div>
                                                <ul class="payment-method">
                                                    <li><a href=""><img src="<?php echo base_url(); ?>assets/crm_image/payment/payment-01.jpg" alt=""></a></li>
                                                    <li><a href=""><img src="<?php echo base_url(); ?>assets/crm_image/payment/payment-02.jpg" alt=""></a></li>
                                                    <li><a href=""><img src="<?php echo base_url(); ?>assets/crm_image/payment/payment-03.jpg" alt=""></a></li>
                                                    <li><a href=""><img src="<?php echo base_url(); ?>assets/crm_image/payment/payment-04.jpg" alt=""></a></li>
                                                </ul>
                                            </div>
                                            <p class="powered-by">Powered By <i class="fa fa-cc-stripe"></i></p>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
</div>
<div class="loader-select-city pre-loader-custom"><img class="loader-image" src="<?= base_url() . 'assets/crm_image/' ?>ring.gif"></div>
<style type="text/css">
    label.btn.btn-default {
        margin-top: 0px !important;
    }
    label.btn.btn-default.choose-file-btn {
        margin: 0 !important;
    }
    .date-picker-div {
        position: relative;
    }
    .date-picker-div span {
        height: 32px;
        position: absolute;
        right: 2px;
        top: 2px;
        width: 40px;
    }
    div#sing-up-page {
        padding-top: 80px !important;
    }
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
    input.textInputError {border-color: red;}
    #infoUser {color: red;font-weight: bold;padding-top: 10px;}
</style>
<script type="text/javascript">
    $(document).ready(function () {
        $('form').parsley();
        $("#domain_name").change(function () {
            var domainid = $(this).val();
            if (domainid != "") {
                var regx = /^[A-Za-z0-9]+$/;
                if (!regx.test(domainid)) {
                    swal("error", "Alphabet Numeric Values Are Only Allowed In Domain Name!", "error");
                    $("#domain_name").val('');
                    $("#domain_name").focus();
                } else {
                    $('.custom-loader').show();
                    $.ajax({
                        url: '<?php echo base_url() ?>admin/members/chk_domain',
                        type: 'POST',
                        data: {domain: domainid},
                        success: function (data) {
                            $('#domain_msg').html(data);
                            if (data != '<i>Domain is valid</i>') {
                                $("#domain_name").focus();
                                $("#domain_name").addClass("textInputError");
                            } else {
                                $("#domain_name").removeClass("textInputError");
                            }
                            $('.custom-loader').hide();
                        },
                    });
                }
            }
        });
    });
    $(function () {
        $("#user_state").change(function () {
            $('#user_city').empty();
            var state = $(this).val();
            if (state == '')
            {
                alert("Select State");
            } else {
                $('.custom-loader').show();
                $.ajax({
                    url: '<?php echo base_url() ?>agency/subagencies/getcity',
                    type: 'POST',
                    data: {'ustid': state},
                    success: function (data) {
                        $('#user_city').html(data);
                        $('.custom-loader').hide();
                    },
                });
            }
        });
    });
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
                    swal('File Type Error',
                            'Please Upload PDF,DOC OR DOCX File Type',
                            'error');
                    oInput.value = "";
                    return false;
                }
            }
        }
        return true;
    }
    var _validFileExtensions1 = [".png", ".jpg", ".jpeg"];
    function ValidateSingleInput1(oInput) {
        if (oInput.type == "file") {
            var sFileName = oInput.value;
            if (sFileName.length > 0) {
                var blnValid = false;
                for (var j = 0; j < _validFileExtensions1.length; j++) {
                    var sCurExtension = _validFileExtensions1[j];
                    if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                        blnValid = true;
                        break;
                    }
                }
                if (!blnValid) {
                    swal('Image Type Error',
                            'Please Upload JPG, PNG or JPEG image Type',
                            'error');
                    oInput.value = "";
                }
            }
        }
        return true;
    }
    $(function () {
        $("#login_email").change(function () {
            var emailid = $(this).val();
            $('.custom-loader').show();
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
                    $('.custom-loader').hide();
                },
            });
        });
    });
    $(function () {
        $("#bank_state").change(function () {
            $('#bank_city').empty();
            var state = $(this).val();
            if (state == '')
            {
                alert("Select State");
            } else {
                $('.custom-loader').show();
                $.ajax({
                    url: '<?php echo base_url() ?>agency/subagencies/getcity',
                    type: 'POST',
                    data: {'ustid': state},
                    success: function (data) {
                        $('#bank_city').html(data);
                        $('.custom-loader').hide();
                    },
                });
            }
        });
    });
    if ($("#pop-up").val() != '') {
        //console.log('HEre');
        $('#panel-modal').modal('show');
    }
</script>