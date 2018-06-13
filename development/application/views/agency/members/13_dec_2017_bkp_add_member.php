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
<div class="wrapper">
    <div class="container">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title"> Add Member</h4>
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() . 'agency/dashboard' ?>">Dashboard</a></li>
                    <li><a href="<?= base_url() . 'agency/members' ?>">Members</a></li>
                    <li class="active">Add Member</li>
                </ol>
            </div>

            <div class="row">

                <div class="col-lg-12 col-md-12">
                    <div class="card-box">
                        <form id="frm_lead_edit" method="post" class="data-parsley-validate novalidate">
                            <div class="text-center">
                                <h3><strong>PRIMARY</strong></h3>
                            </div>
                                <div class="form-group clearfix">
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="fname">First Name * </label>
                                            <input type="text" id="cusfname" name="cus_first_name" class="required form-control" autocomplete="off" value="<?php echo set_value('cus_first_name'); ?>">
                                        </div>
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="mname">Middle Name </label>
                                            <input type="text" id="cusmname" name="cus_middle_name" class="form-control" autocomplete="off" value="<?php echo set_value('cus_middle_name'); ?>">
                                        </div>
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="fname">Last Name * </label>
                                            <input type="text" id="cuslname" name="cus_last_name" class="required form-control" autocomplete="off" value="<?php echo set_value('cus_last_name'); ?>">
                                        </div>
                                </div>


                                <div class="form-group clearfix">
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Email Address * </label>
                                        <input type="email" id="login_email" name="cus_email" class="required form-control" autocomplete="off" value="<?php echo set_value('cus_email'); ?>">
                                        <div id='email_msg' style="margin-top: 10px;"></div>
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="mname">Phone Number * </label>
                                        <input type="text" id="cuscontact" name="cus_contact" class="required form-control custom_phone_number_marks" autocomplete="off" value="<?php echo set_value('cus_contact'); ?>">
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Date Of Birth * </label>
                                        <div class="date-picker-div">
                                            <input class="form-control dtpicker" required placeholder="mm/dd/yyyy" id="datepicker-autoclose" name="cus_dob" type="text" value="<?php echo set_value('cus_dob'); ?>">
                                            <span class="input-group-addon bg-custom b-0 text-white"><i class="icon-calender"></i></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group clearfix">
                                    <div class="col-lg-8">
                                        <label for="fname">Address * </label>
                                        <input type="text" id="cusaddress" name="cus_address" class="required form-control" autocomplete="off" value="<?php echo set_value('cus_address'); ?>">
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Apartment, Suite, etc. </label>
                                        <input type="text" id="cussubaddress" name="cus_sub_address" class="form-control" autocomplete="off" value="<?php echo set_value('cus_sub_address'); ?>">
                                    </div>
                                </div>

                                <div class="form-group clearfix">
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="mname">State * </label>
                                        <select class="form-control required" id="user_state" name="cus_state" onchange="selectCity(this.value, 'user_city', 'cus_city')">
                                            <option value="">Select State</option>
                                            <?php foreach ($state as $key => $value) { ?>
                                                <option value="<?php echo $value['state_code']; ?>"><?php echo $value['state']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">City * </label>
                                        <select class="form-control required selcity" id="user_city" name="cus_city">
                                        </select>
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Zip Code * </label>
                                        <input type="text" id="cuszip" name="cus_zip" class="required form-control custome_zipcode" autocomplete="off" value="<?php echo set_value('cus_zip'); ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Social Security Number * </label>
                                        <input type="text" id="social_security_number" name="cus_security_number" class="required form-control securitynumber" autocomplete="off" value="<?php echo set_value('cus_security_number'); ?>">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="customer_weight">Customer Weight </label>
                                        <input type="text" id="customer_weight" name="customer_weight" class="form-control customer_weight" autocomplete="off" value="<?php echo set_value('cus_weight'); ?>">
                                    </div>
                                </div>

                            <div class="text-center">
                                <h3><strong>SPOUSE</strong></h3>
                            </div>

                            <div class="form-group clearfix">
                                <div class="col-lg-4 input_wrapper">
                                    <label for="fname">First Name </label>
                                    <input type="text" id="spouse_first_name" name="spouse_first_name" class="form-control" autocomplete="off" value="<?php echo set_value('spouse_first_name'); ?>">
                                </div>
                                <div class="col-lg-4 input_wrapper">
                                    <label for="mname">Middle Name </label>
                                    <input type="text" id="spouse_middle_name" name="spouse_middle_name" class="form-control" autocomplete="off" value="<?php echo set_value('spouse_middle_name'); ?>">
                                </div>
                                <div class="col-lg-4 input_wrapper">
                                    <label for="fname">Last Name </label>
                                    <input type="text" id="spouse_last_name" name="spouse_last_name" class="form-control" autocomplete="off" value="<?php echo set_value('spouse_last_name'); ?>">
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <div class="col-lg-4 input_wrapper">
                                    <label for="fname">Email Address  </label>
                                    <input type="email" id="spouse_email_address" name="spouse_email_address" class="form-control" autocomplete="off" value="<?php echo set_value('spouse_email_address'); ?>">
                                </div>
                                <div class="col-lg-4 input_wrapper">
                                    <label for="mname">Phone Number  </label>
                                    <input type="text" id="phonecontact" name="spouse_phone_no" class="form-control custom_phone_number_marks" autocomplete="off" value="<?php echo set_value('spouse_phone_no'); ?>">
                                </div>
                                <div class="col-lg-4 input_wrapper">
                                    <label for="fname">Date Of Birth  </label>
                                    <div class="date-picker-div">
                                        <input class="form-control dtpicker" placeholder="mm/dd/yyyy" id="datepicker-autoclose" name="spouse_dob" type="text" value="<?php echo set_value('spouse_dob'); ?>">
                                        <span class="input-group-addon bg-custom b-0 text-white"><i class="icon-calender"></i></span>

                                    </div>
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <div class="col-lg-8">
                                    <label for="fname">Address </label>
                                    <input type="text" id="spouse_address" name="spouse_address" class=" form-control" autocomplete="off" value="<?php echo set_value('spouse_address'); ?>">
                                </div>
                                <div class="col-lg-4 input_wrapper">
                                    <label for="fname">Apartment, Suite, etc. </label>
                                    <input type="text" id="spouse_subaddress" name="spouse_sub_address" class=" form-control" autocomplete="off" value="<?php echo set_value('spouse_sub_address'); ?>">
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <div class="col-lg-4 input_wrapper">
                                    <label for="mname">State </label>
                                    <select class="form-control " id="spo_user_state" name="customer_spouse_state" onchange="selectCity(this.value, 'spo_user_city', 'spouse_city')">
                                        <option value="">Select State</option>
                                        <?php foreach ($state as $key => $value) { ?>
                                            <option value="<?php echo $value['state_code']; ?>" ><?php echo $value['state']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-lg-4 input_wrapper">
                                    <label for="fname">City </label>
                                    <select class="form-control " id="spo_user_city" name="spouse_city">

                                    </select>
                                </div>
                                <div class="col-lg-4 input_wrapper">
                                    <label for="fname">Zip Code </label>
                                    <input type="text" id="cus1zip" name="spouse_zipcode" class="form-control custome_zipcode" autocomplete="off" value="<?php echo set_value('spouse_zipcode'); ?>">
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <div class="col-lg-4 input_wrapper">
                                    <label for="fname">Social Security Number </label>
                                    <input type="text" id="social_security_number1" name="spouse_ssn" class=" form-control securitynumber" autocomplete="off" value="<?php echo set_value('spouse_ssn'); ?>">
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
                                <a class="btn btn-default waves-effect waves-light save-button" href="<?= base_url() . 'admin/members' ?>"> <span class="btn-label"><i class="fa fa-arrow-left"></i>
                                    </span>Back</a>
                            </div>
                            <div class="loader-select-city"><img class="loader-image" src="<?= base_url() . 'assets/crm_image/' ?>ring.gif"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="full-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="full-width-modalLabel" aria-hidden="true" style="display: none;">
       <div id="mga"></div>
    </div><!-- /.modal -->


    <script type="text/javascript">
        $(function () {

            $("#login_email").change(function () {
                var emailid = $(this).val();
                $('.loader-select-city').show();
                $.ajax({
                    url: '<?php echo base_url() ?>admin/members/chk_email',
                    type: 'POST',
                    data: {email: emailid},
                    success: function (data) {
                        $('#email_msg').html(data);
                        //console.log(data);
                        if (data != '<i>Email address is valid</i>') {
                            $("#login_email").focus();
                            $("#login_email").addClass("textInputError");
                        } else {
                            $("#login_email").removeClass("textInputError");
                        }
                        $('.loader-select-city').hide();
                    },
                });
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $('form').parsley();
            jQuery(document).on('submit', "#frm_lead_edit", function (event) {
                event.preventDefault();
                save_member('frm_lead_edit');
            });

           function save_member(form_id) {
                $('.loader-select-city').show();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() ?>admin/members/save_member",
                    data: $(document).find("#" + form_id).serialize(),
                    dataType:"JSON",
                    success: function (data) {
                        if (data == 'Email address is already used by another, please try other email address.')
                        {
                            swal("Error!", data, "error");
                            return false;
                            $('.loader-select-city').hide();
                        } else {
                            $('#full-width-modal').html(data['new_html']);
                            $('#full-width-modal').modal('show');
                            $('.loader-select-city').hide();
                        }
                    },
                });
            }

            $(document).on('click', '#add_child', function () {
                var validate = 1;
                $(document).find(".div_child_block").find("input[type = 'text']").each(function () {
                    if ($(this).val() == '') {
                        validate = 0;
                    }
                });
                $(document).find(".div_child_block").find("select").each(function () {
                    if ($(this).val() == '') {
                        validate = 0;
                    }
                });
                if (!validate) {
                    swal("Error!", "Please fill child details.", "error");
                } else {
                    var html = <?php echo json_encode($this->load->view("admin/members/get_child", $state, true)); ?>;
                    html = html.replace(/0/g, key);
                    $(document).find(".div_child_block").append(html);
                    $(document).find('.dtpicker').datepicker({
                        autoclose: true,
                        todayHighlight: true,
                        Format: 'yyyy-mm-dd',
                    });
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

        function onchange_city(ele) {
            var parent = jQuery(ele).parent('div');
            var state = jQuery(ele).val();
            jQuery.ajax({
                url: '<?php echo base_url() ?>/agent/members/getcity',
                type: 'POST',
                data: {'sopstid': state},
                success: function (data) {
                    jQuery(parent.next('div').find('select')).html(data);
                },
            });
        }

        $(document).on('click', '.product-add', function () {
            var product_id = $(this).data("custom-value-productid");
            var member_id = $(this).data("custom-value-memberid");
            var key_id = $(this).data("id");
            $.ajax({
                method: "POST",
                url: '<?php echo base_url() ?>admin/members/addproduct',
                data: {product: product_id,member:member_id},
                success: function (data) {
                    $(".pro-add-"+key_id).attr("disabled", 'disabled');
                    $(".pro-remove-"+key_id).attr("disabled",false);
                    swal("success", data, "success");
                }
            });
        });

        $(document).on('click', '.product-remove', function () {
            var product_id = $(this).data("custom-value-productid");
            var member_id = $(this).data("custom-value-memberid");
            var key_id = $(this).data("id");
            $.ajax({
                method: "POST",
                url: '<?php echo base_url() ?>admin/members/removeproduct',
                data: {product: product_id,member:member_id},
                success: function (data) {
                    swal("success", data, "success");
                    $(".pro-add-"+key_id).attr("disabled",false);
                    $(".pro-remove-"+key_id).attr("disabled",true);
                }
            });
        });
         $(document).on('click', '.save-button', function () {
             window.location="<?php echo base_url() ?>admin/members";
        });

           function remove_new_child(obj){
            $(obj).parent().parent().parent('.new-child').remove();
        }

        //-------- for Remove Old added child -----------
        function remove_old_child(obj){
            var child_id = $(obj).data('child-id');
            if(child_id){
                $.post("<?=base_url('agent/members/remove_child/')?>"+child_id,function(data){
                    if(data){
                        $(obj).parent().parent().parent('.old-child').remove();
                    }
                });
            }else{
                $(obj).parent().parent().parent('.old-child').remove();
            }

        }
    </script>




