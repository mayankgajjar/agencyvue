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

<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Edit Member</h4>
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() . 'member/dashboard' ?>">Dashboard</a></li>
                    <li class="active"><?php echo $lead_info['customer_first_name'].' '.$lead_info['customer_last_name'] ?></li>
                </ol>
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
                <div class="col-md-4 col-lg-3">
                    <div class="profile-detail card-box">
                        <div>
                             <img src="<?php echo base_url() ?>assets/crm_image/customer_image/<?php echo $lead_info['customer_image']; ?>" alt="user-img" class="img-circle"> 
<!--                            <img src="<?php echo base_url() ?>assets/images/users/avatar-2.jpg" class="img-circle" alt="profile-image">-->
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
                </div>

                <div class="col-lg-9 col-md-8">
                    <div class="card-box">
                        <form id="frm_lead_edit" method="post"  enctype="multipart/form-data">
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
                                            <input type="text" id="cusmname" name="cus_middle_name" class="required form-control" autocomplete="off" value="<?php echo (isset($lead_info['customer_middle_name'])) ? $lead_info['customer_middle_name'] : ''; ?>">
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
                                            <input type="text" id="cusname" name="cus_email" class="required form-control" autocomplete="off" value="<?php echo (isset($lead_info['customer_email'])) ? $lead_info['customer_email'] : ''; ?>" readonly>
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
                                            <input type="text" id="cussubaddress" name="cus_sub_address" class="required form-control" autocomplete="off" value="<?php echo (isset($lead_info['customer_address_details'])) ? $lead_info['customer_address_details'] : ''; ?>">
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
                                                <?php
                                                foreach ($city_pri as $key => $value) { ?>
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
                                </div>
                                  <div class="form-group clearfix">
                                     <div class="col-lg-4 input_wrapper">
                                        <label for="zipcode">Select Profile Photo  </label>
                                        <input class="bootstrap-filestyle input-group" data-buttonname="btn-default choose-file-btn" name="logo" id="filestyle-0" style="position: absolute; clip: rect(0px, 0px, 0px, 0px);" tabindex="-1" type="file" onchange="ValidateSingleInput(this);"><div class="bootstrap-filestyle input-group"><input class="form-control " placeholder="" disabled="" type="text"> <span class="group-span-filestyle input-group-btn" tabindex="0"><label for="filestyle-0" class="btn btn-default choose-file-btn "><span class="icon-span-filestyle glyphicon glyphicon-folder-open"></span> <span class="buttonText">Choose file</span></label></span></div>
                                        <div class="error_image" style="font-style: italic; color: red; margin-top: 8px; display: none;">Please select jpg  , png or gif file format.</div>
                                    </div>
<!--                                    <div class="col-lg-4 input_wrapper">
                                        <label for="zipcode">Upload Logo * </label>
                                        <input type="file" class="filestyle" data-buttonname="btn-default choose-file-btn" name="logo" onchange="ValidateSingleInput(this);">  
                                        <div class="error_image" style="font-style: italic; color: red; margin-top: 8px; display: none;">Please select jpg ,  png  or gif file format.</div>
                                    </div>-->
                                </div>
                               
                                <div class="text-center text-uppercase font-600">
                                    <h3><strong>SPOUSE</strong></h3>
                                </div>

                                <div class="form-group clearfix">
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="fname">First Name  </label>
                                            <input type="text" id="fname" name="spouse_first_name" class="required form-control" autocomplete="off" value="<?php echo (isset($lead_member_spouse_info['customer_spouse_first_name'])) ? $lead_member_spouse_info['customer_spouse_first_name'] : ''; ?>">
                                        </div>
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="mname">Middle Name  </label>
                                            <input type="text" id="mname" name="spouse_middle_name" class="required form-control" autocomplete="off" value="<?php echo (isset($lead_member_spouse_info['customer_spouse_middle_name'])) ? $lead_member_spouse_info['customer_spouse_middle_name'] : ''; ?>">
                                        </div>
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="fname">Last Name  </label>
                                            <input type="text" id="lname" name="spouse_last_name" class="required form-control" autocomplete="off" value="<?php echo (isset($lead_member_spouse_info['customer_spouse_last_name'])) ? $lead_member_spouse_info['customer_spouse_last_name'] : ''; ?>">
                                        </div>
                                </div>

                                <div class="form-group clearfix">
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="fname">Email Address  </label>
                                            <input type="text" id="fname" name="spouse_email_address" class="required form-control" autocomplete="off" value="<?php echo (isset($lead_member_spouse_info['customer_spouse_email'])) ? $lead_member_spouse_info['customer_spouse_email'] : ''; ?>">
                                        </div>
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="mname">Phone Number  </label>
                                            <input type="text" id="mname" name="spouse_phone_no" class="required form-control custom_phone_number_marks" autocomplete="off" value="<?php echo (isset($lead_member_spouse_info['customer_spouse_phone_number'])) ? $lead_member_spouse_info['customer_spouse_phone_number'] : ''; ?>">
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
                                            <input type="text" id="fname" name="spouse_address" class="required form-control" autocomplete="off" value="<?php echo (isset($lead_member_spouse_info['customer_spouse_address'])) ? $lead_member_spouse_info['customer_spouse_address'] : ''; ?>">
                                        </div>
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="fname">Apartment, Suite, etc  </label>
                                            <input type="text" id="lname" name="spouse_sub_address" class="required form-control" autocomplete="off" value="<?php echo (isset($lead_member_spouse_info['customer_spouse_address_details'])) ? $lead_member_spouse_info['customer_spouse_address_details'] : ''; ?>">
                                        </div>
                                </div>

                                <div class="form-group clearfix">
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="mname">State  </label>
                                            <select class="form-control required" id="spo_user_state" name="customer_spouse_state" onchange="selectCity(this.value, 'spo_user_city', 'spouse_city')">
                                                <option value="">Select State</option>
                                                <?php foreach ($state as $key => $value) { ?>
                                                    <option value="<?php echo $value['state_code']; ?>" <?php echo ( $value['state_code'] == $lead_member_spouse_info['customer_spouse_state']) ? 'selected' : ''; ?>><?php echo $value['state']; ?></option>
                                                 <?php  } ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="fname">City  </label>
                                            <select class="form-control required" id="spo_user_city" name="spouse_city">
                                                <?php
                                                foreach ($city_sop as $key => $value) { ?>
                                                    <option value="<?php echo $value['city']; ?>" <?php echo ( $value['city'] == $lead_member_spouse_info['customer_spouse_city']) ? 'selected' : ''; ?>><?php echo $value['city']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="fname">Zip Code  </label>
                                            <input type="text" id="lname" name="spouse_zipcode" class="required form-control custome_zipcode" autocomplete="off" value="<?php echo (isset($lead_member_spouse_info['customer_spouse_zipcode'])) ? $lead_member_spouse_info['customer_spouse_zipcode'] : ''; ?>">
                                        </div>
                                </div>
                                <div class="form-group clearfix">
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="fname">Social Security Number  </label>
                                            <input type="text" id="fname" name="spouse_ssn" class="required form-control securitynumber" autocomplete="off" value="<?php echo (isset($lead_member_spouse_info['customer_spouse_social_security_number'])) ? $lead_member_spouse_info['customer_spouse_social_security_number'] : ''; ?>" placeholder="XXX - XX - XXXX">
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
                                    <button type="submit" class="btn btn-success" >Save</button>
                                    <a class="btn btn-default waves-effect waves-light" href="<?= base_url() . 'member/dashboard' ?>"> <span class="btn-label"><i class="fa fa-arrow-left"></i>
                                            </span>Back</a>
                                </div>
                        </form>    
                    </div>
                </div>
            </div>
        </div>
    </div>

   <script type="text/javascript">
        $(function () {
            $('.dtpicker').datepicker({
                autoclose: true,
                todayHighlight: true,
                Format: 'yyyy-mm-dd',
            });
        });
    </script>

    <script>
        $(document).ready(function () {

            $(document).on('click', '#add_child', function () {
                var html = <?php echo json_encode($this->load->view("member/profile/get_child", $state, true)); ?>;
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
                    url: '<?php echo base_url() ?>member/profile/newcity',
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
            jQuery.ajax({
                url: '<?php echo base_url() ?>member/profile/getcity',
                type: 'POST',
                data: {'sopstid': state},
                success: function (data) {
                    jQuery(parent.next('div').find('select')).html(data);
                },
            });
        }
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



