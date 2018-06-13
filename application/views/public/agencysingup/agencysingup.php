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
<div class="wrapper broker_profile_wapper">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-8 card-box all_details_broker_profile">
                <form id="broker-profile" method="post" enctype="multipart/form-data" class="data-parsley-validate novalidate">
                    <div class="row">

                        <div class="col-lg-12">

                            <div class="text-center"><h3>Agency Registration</h3></div>

                            <?php
                            if ($this->session->flashdata('success')) {
                                ?>

                                <div class="content pt0">

                                    <div class="alert alert-success">

                                        <a class="close" data-dismiss="alert">×</a>

                                        <strong><?= $this->session->flashdata('success') ?></strong>

                                    </div>

                                </div>

                                <?php
                                $this->session->set_flashdata('success', false);
                            } else if ($this->session->flashdata('error')) {
                                ?>

                                <div class="content pt0">

                                    <div class="alert alert-danger">

                                        <a class="close" data-dismiss="alert">×</a>

                                        <strong><?= $this->session->flashdata('error') ?></strong>

                                    </div>

                                </div>

                                <?php
                                $this->session->set_flashdata('error', false);
                            } else if (validation_errors()) {
                                ?>

                                <div class="content pt0">

                                    <div class="content pt0">

                                        <div class="alert alert-danger">

                                            <a class="close" data-dismiss="alert">×</a>

                                            <strong><?php echo validation_errors(); ?></strong>

                                        </div>

                                    </div> 

                                </div>

                            <?php } ?>
                            <div class="form-group clearfix" style="margin-left: 5px;margin-bottom: 9px;">
                            </div>
                            <div class="form-group clearfix">
                                <div class="col-lg-12">
                                    <div class="col-lg-6">
                                        <label for="fname">Agency Name * </label>
                                        <input type="text" id="fname" name="first_name" class="required form-control" autocomplete="off" value="<?php echo set_value('first_name'); ?>" reuqired>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <div class="col-lg-12">
                                    <div class="col-lg-6">
                                        <label for="user_phno"> email * </label>
                                        <input type="text" id="user_email" name="email" class="required form-control" autocomplete="off" value="<?php echo (isset($profile['admin_email'])) ? $profile['admin_email'] : ''; ?>" required>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="user_phno">Phone Number * </label>
                                        <input type="text" id="user_phno" name="phone_number" class="required form-control" autocomplete="off" value="<?php echo (isset($profile['admin_phone_number'])) ? $profile['admin_phone_number'] : ''; ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <div class="col-lg-12">
                                    <div class="col-lg-8">
                                        <label for="user_add">Address * </label>
                                        <input type="text" id="user_add" name="address"class="required form-control" autocomplete="off" value="<?php echo (isset($profile['admin_address'])) ? $profile['admin_address'] : ''; ?>" required>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="user_add_detail">Apartment,Suite,ect. </label>
                                        <input type="text" id="user_add_detail" name="address_addtional" class="required form-control" autocomplete="off" value="<?php echo (isset($profile['admin_address_details'])) ? $profile['admin_address_details'] : ''; ?>" required>
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
                                                <option value="<?php echo $value['state_code']; ?>" ><?php echo $value['state']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="user_city">City * </label>
                                        <select class="form-control required" id="user_city" name="sel_city">
                                            <?php foreach ($city_list as $value) { ?>
                                                <option value=<?php echo $value['city']; ?> <?php echo($value['city'] == $profile['admin_city']) ? 'selected' : '' ?>><?php echo $value['city']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="user_zip">Zip Code * </label>
                                        <input type="text" id="user_zip" name="zipcode" class="required form-control" autocomplete="off" value="<?php echo (isset($profile['admin_zipcode'])) ? $profile['admin_zipcode'] : ''; ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <div class="col-lg-12">
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="zipcode">Upload Profile Image  </label>
                                        <input class="bootstrap-filestyle input-group" data-buttonname="btn-default choose-file-btn" name="logo" id="filestyle-0" style="position: absolute; clip: rect(0px, 0px, 0px, 0px);" tabindex="-1" type="file"><div class="bootstrap-filestyle input-group"><input class="form-control " placeholder="" disabled="" type="text"> <span class="group-span-filestyle input-group-btn" tabindex="0"><label for="filestyle-0" class="btn btn-default choose-file-btn "><span class="icon-span-filestyle glyphicon glyphicon-folder-open"></span> <span class="buttonText">Choose file</span></label></span></div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="user_zip">Domain name * </label>
                                        <input type="text" id="user_zip" name="zipcode" class="required form-control" autocomplete="off" value="<?php echo (isset($profile['admin_zipcode'])) ? $profile['admin_zipcode'] : ''; ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="col-lg-12">  
                                    <div class="form-group clearfix">
                                        <div class="col-lg-12">
                                            <div class="form-group text-center">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
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
    $(document).ready(function () {
            $('form').parsley();
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

                $('.loader-select-city').show();

                $.ajax({

                    url: '<?php base_url() ?>profile/getcity',

                    type: 'POST',

                    data: {'ustid': state},

                    success: function (data) {

                        $('#user_city').html(data);

                        $('.loader-select-city').hide();

                    },

                });

            }

        });

    });

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