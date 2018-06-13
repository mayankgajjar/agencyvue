<div class="wrapper broker_profile_wapper">
    <div class="container">
        <?php $profile = $broker_details[0]; ?>
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Profile</h4>
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() . 'agent/dashboard' ?>">Agent Dashboard</a></li>
                    <li class="active">Profile</li>
                </ol>
            </div>
        </div>
        <div class="row">
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
                    <div class="alert alert-danger">
                        <a class="close" data-dismiss="alert"><i class="fa fa-times"></i></a>
                        <strong><?= $this->session->flashdata('error') ?></strong>
                    </div>
                </div>
                <?php
                $this->session->set_flashdata('error', false);
            } else if (validation_errors()) {
                ?>
                <div class="content pt0">
                    <div class="alert alert-danger">
                        <a class="close" data-dismiss="alert"><i class="fa fa-times"></i></a>
                        <strong><?= validation_errors() ?></strong>
                    </div>
                </div>
            <?php } ?>
            <div class="col-md-4 col-lg-3">
                <div class="profile-detail card-box">
                    <div>
                        <img src="<?php echo base_url() ?>assets/crm_image/agent_profile/<?php echo ($profile['agent_image'] != "") ? $profile['agent_image'] : "basicpc.jpg"; ?>" alt="user-img" class="img-circle">

                        <div class="gap_creater" style="padding: 10px"></div>
                        <div class="text-left">
                            <p class="text-muted font-13"><strong>Created Date :</strong> <span class="m-l-15"><?php echo date('m-d-Y h:i:s a', strtotime($profile['created_date'])); ?></span></p>
                            <p class="text-muted font-13"><strong>Active Member :</strong><span class="m-l-15"> <?php echo $activemember; ?> </span></p>
                            <p class="text-muted font-13"><strong>Retension Rate :</strong> <span class="m-l-15"><?php echo round($retention) . '%'; ?>  </span></p>
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
                                        <input type="text" id="user_phno" name="phone_number" class="required form-control" autocomplete="off" value="<?= $profile['personal_phone_number'] ?>">
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="user_dob">Date Of Birth * </label>
                                        <div class="date-picker-div">
                                            <input class="form-control" placeholder="mm/dd/yyyy" id="datepicker-autoclose" name="dob" type="text" value="<?= $profile['dob'] ?>">
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
                                        <select class="form-control required selstate" id="user_state" name="sel_state">
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
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="user_zip">Zip Code * </label>
                                        <input type="text" id="user_zip" name="zipcode" class="required form-control" autocomplete="off" value="<?= $profile['personal_zipcode'] ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group clearfix">
                            <div class="col-lg-12">
                                <div class="col-lg-4">
                                    <label for="zipcode">Upload Profile Image </label>
                                    <input class="bootstrap-filestyle input-group" data-buttonname="btn-default choose-file-btn" name="logo" id="filestyle-0" style="position: absolute; clip: rect(0px, 0px, 0px, 0px);" tabindex="-1" type="file"><div class="bootstrap-filestyle input-group"><input class="form-control " placeholder="" disabled="" type="text"> <span class="group-span-filestyle input-group-btn" tabindex="0"><label for="filestyle-0" class="btn btn-default choose-file-btn "><span class="icon-span-filestyle glyphicon glyphicon-folder-open"></span> <span class="buttonText">Choose file</span></label></span></div>
                                </div>
                                <div class="col-md-4">
                                    <label>Domain Name</label>
                                    <input type="text" class="form-control" disabled="" value="<?= 'agencyvue.com'; ?>">
                                </div>
                                <!--                                <div class="col-md-4">
                                                                    <label>Target</label>
                                                                    <input type="text" class="form-control" name="agent_target" value="<?= $profile['agent_target'] ?>">
                                                                </div> -->
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
                                            <label for="custom_service_name">Custom Service Name</label>
                                            <input type="text" id="custom_service_name" name="custom_service_name" class="form-control" autocomplete="off" value="<?= $profile['custom_service_name'] ?>">
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="fax_number">Fax Number</label>
                                            <input type="text" id="fax_number" name="fax_number" class="form-control" autocomplete="off" value="<?= $profile['business_fax_number'] ?>">
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
                                            <label for="business_add_detail">Unit,Suite,ect. </label>
                                            <input type="text" id="business_add_detail" name="business_address_addtional" class="form-control" autocomplete="off" value="<?= $profile['business_add_addtional'] ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="col-lg-12">
                                        <div class="col-lg-4">
                                            <label for="business_state">State * </label>
                                            <select class="form-control required selstate" id="business_state" name="business_state">
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
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="business_zip">Zip Code * </label>
                                            <input type="text" id="business_zip" name="business_zip" class="required form-control" autocomplete="off" value="<?= $profile['business_zip_code'] ?>">
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
                                                <label for="my_self">
                                                    My Self
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="checkbox checkbox-primary">
                                                <input id="my_business" type="checkbox" class="commision_payto" name="commision_payto" value="my_business" <?php echo ($profile['commision_payto'] == 'my_business') ? 'checked' : ''; ?>>
                                                <label for="my_business">
                                                    My Business
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group clearfix" id="federal_tax_id_wapp" style="<?php echo ($profile['commision_payto'] == 'my_business') ? '' : 'display: none'; ?>">
                                <div class="col-lg-12">
                                    <div class="col-lg-6">
                                        <label for="federal_tax_id">Federal Tax ID</label>
                                        <input type="text" id="federal_tax_id" name="federal_tax_id" class="form-control" autocomplete="off" value="<?= $profile['federal_tax_id'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group clearfix" id="social_security_number_wapp" style="<?php echo ($profile['commision_payto'] == 'my_business') ? 'display: none' : ''; ?>">
                                <div class="col-lg-12">
                                    <div class="col-lg-6">
                                        <label for="social_security_number">Social Security Number</label>
                                        <input type="text" id="social_security_number" name="social_security_number" class="form-control" autocomplete="off" value="<?= $profile['social_security_number'] ?>">
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
                                                <label for="paper_check">
                                                    Paper Check
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="checkbox checkbox-primary">
                                                <input id="direct_deposit" type="checkbox" name="commsion_receive" value="Direct_Deposit" class="commsion_receive" <?php echo ($profile['commsion_receive'] == 'Direct_Deposit') ? 'checked' : ''; ?>>
                                                <label for="direct_deposit">
                                                    Direct Deposit
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <div class="col-lg-12">
                                    <div class="col-lg-8">
                                        <label for="commision_address">Name Of Account * </label>
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
                                        <label for="commision_add_details">Unit,Suite,ect. </label>
                                        <input type="text" id="user_add_detail" name="commision_add_details" class="form-control" autocomplete="off" value="<?= $profile['commision_add_addtional'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <label for="commision_state">State * </label>
                                        <select class="form-control required selstate" id="commision_state" name="commision_state">
                                            <option value="0">Select State</option>
                                            <?php foreach ($state as $key => $value) { ?>
                                                <option value="<?php echo $value['state_code']; ?>" <?php echo ( $value['state_code'] == $profile['commision_state']) ? 'selected' : ''; ?>><?php echo $value['state']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="commision_city">City * </label>
                                        <select class="form-control required selcity" id="commision_city" name="commision_city">
                                            <?php foreach ($city_commision as $key => $value) { ?>
                                                <option value=<?php echo $value['city']; ?> <?php echo($value['city'] == $profile['commision_city']) ? 'selected' : '' ?>><?php echo $value['city']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="commision_zipcode">Zip Code * </label>
                                        <input type="text" id="comm_zip" name="commision_zipcode" class="required form-control" autocomplete="off" value="<?= $profile['commision_zipcode'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="direct_deposit_wapp" style="<?php echo ($profile['commsion_receive'] == 'Direct_Deposit') ? '' : 'display:none'; ?>">
                                <div class="form-group clearfix">
                                    <div class="col-lg-12">
                                        <div class="col-lg-4">
                                            <div class="checkbox checkbox-primary">
                                                <input id="checking" type="checkbox" name="select_account" value="checking" class="select_account" <?php echo ($profile['account_options'] == 'checking') ? 'checked' : ''; ?>>
                                                <label for="checking">
                                                    Checking Account
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="checkbox checkbox-primary">
                                                <input id="saving" type="checkbox" name="select_account" value="saving" class="select_account" <?php echo ($profile['account_options'] == 'saving') ? 'checked' : ''; ?>>
                                                <label for="saving">
                                                    Saving Account
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="col-lg-12">
                                        <div class="col-lg-8">
                                            <label for="rounting_number">Rounting Number</label>
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
                            </div>
                            <div class="form-group clearfix">
                                <div class="col-lg-12">
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success">Save</button>
                                            <a class="btn btn-default waves-effect waves-light" href="<?= base_url() . 'agent/dashboard' ?>"> <span class="btn-label"><i class="fa fa-arrow-left"></i>
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
<style type="text/css">
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
    .datepicker>div {
        display: block;
    }
    .datepicker {
        z-index: 9999999;
    }
</style>
<script type="text/javascript">
    (function ($) {
        $(document).on('click', '.commision_payto', function () {
            var payto = $(this).val();
            if (payto == "my_self") {
                $('#my_business').prop('checked', false); // Unchecks it
                $('#federal_tax_id_wapp').hide();
                $('#social_security_number_wapp').show();
                ;
            }
            if (payto == "my_business") {
                $('#my_self').prop('checked', false); // Unchecks it
                $('#social_security_number_wapp').hide();
                $('#federal_tax_id_wapp').show();
            }
        });
        $(document).on('click', '.commsion_receive', function () {
            console.log('click');
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
    $(function () {
        $('#datepicker-autoclose').datepicker({
            autoclose: true,
            todayHighlight: true,
            Format: 'yyyy-mm-dd',
        });
    });
    $(function () {
        $("#user_state").change(function () {
            $('#user_city').empty();
            //$("#user_city").empty();
            var state = $(this).val();
            if (state == '')
            {
                //alert("Select State");
            } else {
                $.ajax({
                    url: '<?php base_url() ?>profile/getcity',
                    type: 'POST',
                    data: {'ustid': state},
                    success: function (data) {
                        $('#user_city').html(data);
                    },
                });
            }
        });
    });
    $(function () {
        $("#business_state").change(function () {
            $("#business_city").empty();
            var state = $(this).val();
            if (state == '')
            {
                alert("Select State");
            } else {
                $.ajax({
                    url: '<?php base_url() ?>profile/getcity',
                    type: 'POST',
                    data: {'bstid': state},
                    success: function (data) {
                        $('#business_city').html(data);
                    },
                });
            }
        });
    });
    $(function () {
        $("#commision_state").change(function () {
            $("#commision_city").empty();
            var state = $(this).val();
            if (state == '')
            {
                alert("Select State");
            } else {
                $.ajax({
                    url: '<?php base_url() ?>profile/getcity',
                    type: 'POST',
                    data: {'cstid': state},
                    success: function (data) {
                        $('#commision_city').html(data);
                    },
                });
            }
        });
    });
</script>