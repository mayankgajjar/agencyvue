<div class="wrapper broker_profile_wapper">
    <div class="container">
        <?php $profile = $details[0]; ?>
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Profile</h4>
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() . 'agent/dashboard' ?>">Agency Dashboard</a></li>
                    <li class="active">Profile</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <?php if ($this->session->flashdata('success')) { ?>
                <div class="content pt0">
                    <div class="alert alert-success">
                        <a class="close" data-dismiss="alert">X</a>
                        <strong><?= $this->session->flashdata('success') ?></strong>
                    </div>
                </div>
                <?php
                $this->session->set_flashdata('success', false);
            } else if ($this->session->flashdata('error')) {
                ?>
                <div class="content pt0">
                    <div class="alert alert-danger">
                        <a class="close" data-dismiss="alert">X</a>
                        <strong><?= $this->session->flashdata('error') ?></strong>
                    </div>
                </div>
                <?php
                $this->session->set_flashdata('error', false);
            } else if (validation_errors()) {
                ?>
                <div class="content pt0">
                    <div class="alert alert-danger">
                        <a class="close" data-dismiss="alert">X</a>
                        <strong><?= validation_errors() ?></strong>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="col-md-4 col-lg-3">
                    <div class="profile-detail card-box">
                        <div>
                            <img src="<?php echo base_url() ?>assets/crm_image/agencieslogo/<?php echo ($profile['agency_image'] != "") ? $profile['agency_image'] : "basicpc.jpg"; ?>" alt="user-img" class="img-circle">
                            <div class="gap_creater" style="padding: 10px"></div>
                            <div class="text-left">
                                <p class="text-muted font-13"><strong>Created Date :</strong> <span class="m-l-15"><?php echo date('m-d-Y h:i:s a', strtotime($profile['created_date'])); ?></span></p>
                            </div>
                        </div>
                        <hr>
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
                        <h3> General information </h3>
                        <section>
                            <div class="form-group clearfix">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <label for="fname">Agency Name * </label>
                                        <input type="text" id="fname" name="agency_name" class="required form-control" autocomplete="off" value="<?php echo $profile['agency_name']; ?>" reuqired>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="cname">Contact Name * </label>
                                        <input type="text" id="cname" name="contact_name" class="required form-control" autocomplete="off" value="<?php echo $profile['contact_name']; ?>" reuqired>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <div class="col-md-12">
                                    <div class="col-lg-6">
                                        <label for="user_phno">Phone Number * </label>
                                        <input type="text" id="user_phno" name="phone_number" class="required form-control child_phone_number" autocomplete="off" value="<?php echo $profile['agency_phone']; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="login_email"> Contact Email * </label>
                                        <input type="email" id="login-email" name="contact_email" class="required form-control" autocomplete="off" value="<?php echo $profile['agency_email']; ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <label for="customer_service_email"> Customer Service Email * </label>
                                        <input type="email" id="customer_service_email" name="customer_service_email" class="required form-control" autocomplete="off" value="<?php echo $profile['agency_customer_service_email']; ?>" required>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="csn"> Customer Service Number </label>
                                        <input type="text" id="csn" name="customer_service_number" class="required form-control customer_service_number_agency" autocomplete="off" value="<?php echo $profile['agency_customer_service_number']; ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <div class="col-lg-12">
                                    <div class="col-lg-8">
                                        <label for="user_add">Address * </label>
                                        <input type="text" id="user_add" name="address" class="required form-control" autocomplete="off" value="<?php echo $profile['agency_address']; ?>" required>
                                    </div>

                                    <div class="col-lg-4">
                                        <label for="user_add_detail"> Unit, Building, Etc. </label>
                                        <input type="text" id="user_add_detail" name="address_addtional" class="form-control" autocomplete="off" value="<?php echo $profile['agency_sub_address']; ?>">
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
                                                <option value="<?php echo $value['state_code']; ?>" <?php echo($profile['agency_state'] == $value['state_code']) ? "Selected" : ''; ?> ><?php echo $value['state']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="user_city">City * </label>
                                        <select class="form-control required" id="user_city" name="sel_city">
                                            <?php foreach ($city_list as $value) { ?>
                                                <option value="<?php echo $value['city']; ?>" <?php echo($profile['agency_city'] == $value['city']) ? "selected" : ""; ?>><?php echo $value['city']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="user_zip">Zip Code * </label>
                                        <input type="text" id="user_zip" name="zipcode" class="required form-control custome_zipcode" autocomplete="off" value="<?php echo $profile['agency_zip_code']; ?>" required>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <h3> Bank information </h3>
                        <section>
                            <div class="form-group clearfix">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <label for="angecy_bank_name">Bank Name * </label>
                                        <input type="text" id="angecy_bank_name" name="angecy_bank_name" class="required form-control angecy_bank_name" autocomplete="off" value="<?php echo $profile['bank_name']; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="angecy_bank_add">Bank Address * </label>
                                        <input type="text" id="angecy_bank_add" name="angecy_bank_add" class="required form-control angecy_bank_add" autocomplete="off" value="<?php echo $profile['bank_add']; ?>" required>
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
                                                <option value="<?php echo $value['state_code']; ?>" <?php echo($profile['bank_state'] == $value['state_code']) ? 'Selected' : ''; ?>><?php echo $value['state']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="bank_city">Bank City * </label>
                                        <select class="form-control required" id="bank_city" name="bank_city">
                                            <?php foreach ($city_list_bank as $value) { ?>
                                                <option value="<?php echo $value['city']; ?>" <?php echo($profile['bank_city'] == $value['city']) ? "selected" : ""; ?>><?php echo $value['city']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="bank_zipcode">Zip Code * </label>
                                        <input type="text" id="bank_zipcode" name="bank_zipcode" class="required form-control bank_zipcode zipmark" autocomplete="off" value="<?php echo $profile['bank_zipcode']; ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <label for="name_on_account">Name on Account * </label>
                                        <input type="text" id="name_on_account" name="name_on_account" class="required form-control name_on_account" autocomplete="off" value="<?php echo $profile['agency_name_on_account']; ?>" required>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="account_number">Account Number * </label>
                                        <input type="text" id="account_number" name="account_number" class="required form-control account_number" autocomplete="off" value="<?php echo $profile['agency_account_number']; ?>" required>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="routing_number">Routing Number * </label>
                                        <input type="text" id="routing_number" name="routing_number" class="required form-control routing_number" autocomplete="off" value="<?php echo $profile['angecy_routing_number']; ?>" required>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <h3> Login Information </h3>
                        <section>
                            <div class="form-group clearfix">
                                <div class="col-lg-12">
                                    <div class="col-md-8">
                                        <label for="login_email"> Login Email * </label>
                                        <input type="email" id="login_email" name="login_email" class="required form-control" autocomplete="off" value="<?php echo $profile['email']; ?>" disabled required>
                                        <div id='email_msg' style="margin-top: 10px;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <label for="domain_name">Domain name * </label>
                                        <input type="text" id="domain_name" name="domain_name" class="required form-control" autocomplete="off" value="<?php echo $profile['agency_domain']; ?>" disabled required>
                                        <div id='domain_msg' style="margin-top: 10px;"></div>
                                    </div>
                                    <div class="col-lg-4 input_wrapper error-msg-fix">
                                        <label for="zipcode">Upload Agency Logo  </label>
                                        <input type="file" class="filestyle" name="agency_logo" data-buttonname="btn-default" onchange="ValidateSingleInput1(this);">
                                    </div>
                                </div>
                            </div>
                        </section>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group clearfix">
                                    <div class="col-lg-12">
                                        <div class="form-group text-center">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                            <a class="btn btn-default waves-effect waves-light" href="<?= base_url() . 'agency/dashboard' ?>"> <span class="btn-label"><i class="fa fa-arrow-left"></i></span>Back</a>
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
</div>
<div class="custom-loader" style="display: none">
    <div class="loader"></div>
</div>
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
                    url: '<?php echo base_url() ?>agencysignup/getcity',
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
                    url: '<?php echo base_url() ?>agencysignup/getcity',
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

    var _validFileExtensions = [".doc", ".docx", ".pdf"];
    function ValidateSingleInput(oInput) {
        if (oInput.type == "file") {
            var sFileName = oInput.value;
            if (sFileName.length > 0) {
                var blnValid = false;
                for (var j = 0; j < _validFileExtensions.length; j++) {
                    var sCurExtension = _validFileExtensions[j];
                    if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                        blnValid = true;
                        break;
                    }
                }
                if (!blnValid) {
                    console.log("asas");
                    swal('File Type Error',
                            'Please Upload Docx, Docx or PDF file Type',
                            'error');
                    oInput.value = "";
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
</script>