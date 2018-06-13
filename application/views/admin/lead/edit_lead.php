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


                <h4 class="page-title">Leads</h4>

                <ol class="breadcrumb">
                    <li><a href="<?= base_url() . 'admin/dashboard' ?>">Dashboard</a></li>
                    <li><a href="<?= base_url() . 'admin/leads' ?>">Leads</a></li>
                    <li class="active"><?php echo $lead_info['customer_first_name'] . ' ' . $lead_info['customer_last_name'] ?></li>

                </ol>
            </div>

            <div class="row">
                <div class="col-md-4 col-lg-3">
                    <div class="profile-detail card-box">
                        <div>
                            <img src="<?php echo base_url() ?>assets/images/users/avatar-2.jpg" class="img-circle" alt="profile-image">
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
                                        <button type="button" class="btn btn-success waves-effect waves-light addProduct">
                                            <span class="btn-label"><i 
                                                    class="fa fa-plus"></i>
                                            </span>Add</button>
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
                        <form id="frm_lead_edit" method="post" class="data-parsley-validate novalidate">
                            <div class="text-center">
                                <h3><strong>PRIMARY</strong></h3>
                            </div>   

                           
                            
                                <div class="form-group clearfix">
                                <input type="hidden" name="customer_id" value="<?php echo (isset($customer_id)) ? $customer_id : ''; ?>">
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">First Name * </label>
                                        <input type="text" id="cusfname" name="cus_first_name" class="required form-control" autocomplete="off" value="<?php echo (isset($lead_info['customer_first_name'])) ? $lead_info['customer_first_name'] : ''; ?>">
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="mname">Middle Name </label>
                                        <input type="text" id="cusmname" name="cus_middle_name" class="form-control" autocomplete="off" value="<?php echo (isset($lead_info['customer_middle_name'])) ? $lead_info['customer_middle_name'] : ''; ?>">
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Last Name * </label>
                                        <input type="text" id="cuslname" name="cus_last_name" class="required form-control" autocomplete="off" value="<?php echo (isset($lead_info['customer_last_name'])) ? $lead_info['customer_last_name'] : ''; ?>">
                                    </div>
                                </div>
                                

                                <div class="form-group clearfix">

                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Email Address * </label>
                                        <input type="email" id="login_email" name="cus_email" class="required form-control lead-email-id" autocomplete="off" value="<?php echo (isset($lead_info['customer_email'])) ? $lead_info['customer_email'] : ''; ?>">
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="mname">Phone Number * </label>
                                        <input type="text" id="cuscontact" name="cus_contact" class="required form-control custom_phone_number_marks lead-phone-number" autocomplete="off" value="<?php echo (isset($lead_info['customer_phone_number'])) ? $lead_info['customer_phone_number'] : ''; ?>">
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Date Of Birth * </label>
                                        <div class="date-picker-div">
                                            <input class="form-control dtpicker required lead-dob" placeholder="mm/dd/yyyy" id="datepicker-autoclose" name="cus_dob" type="text" value="<?php echo (isset($lead_info['customer_dob']) && !empty($lead_info['customer_dob'])) ? date('m/d/Y', strtotime($lead_info['customer_dob'])) : ''; ?>">
                                            <span class="input-group-addon bg-custom b-0 text-white"><i class="icon-calender"></i></span>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group clearfix">

                                    <div class="col-lg-8">
                                        <label for="fname">Address * </label>
                                        <input type="text" id="cusaddress" name="cus_address" class="required form-control lead-add" autocomplete="off" value="<?php echo (isset($lead_info['customer_address'])) ? $lead_info['customer_address'] : ''; ?>">
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Apartment, Suite, etc.* </label>
                                        <input type="text" id="cussubaddress" name="cus_sub_address" class="required form-control lead-oadd" autocomplete="off" value="<?php echo (isset($lead_info['customer_address_details'])) ? $lead_info['customer_address_details'] : ''; ?>">
                                    </div>

                                </div>

                                <div class="form-group clearfix">

                                    <div class="col-lg-4 input_wrapper">
                                        <label for="mname">State * </label>
                                        <select class="form-control required" id="user_state" name="cus_state" class="lead-status">
                                            <option value="">Select State</option>
                                            <?php foreach ($state as $key => $value) { ?>  
                                                <option value="<?php echo $value['state_code']; ?>" <?php echo ( $value['state_code'] == $lead_info['customer_state']) ? 'selected' : ''; ?>><?php echo $value['state']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">City * </label>
                                        <select class="form-control required" id="user_city" name="cus_city" class="lead-city">
                                            <?php foreach ($city_pri as $key => $value) { ?>
                                                <option value="<?php echo $value['city']; ?>" <?php echo ( $value['city'] == $lead_info['customer_city']) ? 'selected' : ''; ?>><?php echo $value['city']; ?></option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Zip Code * </label>
                                        <input type="text" id="cuszip" name="cus_zip" class="required form-control custome_zipcode lead-zipcode" autocomplete="off" value="<?php echo (isset($lead_info['customer_zipcode'])) ? $lead_info['customer_zipcode'] : ''; ?>">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Social Security Number * </label>
                                        <input type="text" id="cussecuritynumber" name="cus_security_number" class="required form-control securitynumber" autocomplete="off" value="<?php echo (isset($lead_info['customer_social_security_number'])) ? $lead_info['customer_social_security_number'] : ''; ?>">
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="customer_weight">Customer Weight * </label>
                                        <input type="text" id="customer_weight" name="customer_weight" class="required form-control customer_weight" autocomplete="off" value="<?php echo (isset($lead_info['customer_weight'])) ? $lead_info['customer_weight'] : ''; ?>">
                                    </div>
                                </div>
                                <!--</div>-->
                                <div class="text-center">
                                    <h3><strong>SPOUSE</strong>
                                        <a class="btn btn-primary pull-right remove-spouse"><i class="fa fa-trash"></i> Remove Spouse</a>
                                    </h3>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">First Name </label>
                                        <input type="text" id="fname" name="spouse_first_name" class="form-control" autocomplete="off" value="<?php echo (isset($lead_member_spouse_info['customer_spouse_first_name'])) ? $lead_member_spouse_info['customer_spouse_first_name'] : ''; ?>">
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="mname">Middle Name </label>
                                        <input type="text" id="mname" name="spouse_middle_name" class="form-control" autocomplete="off" value="<?php echo (isset($lead_member_spouse_info['customer_spouse_middle_name'])) ? $lead_member_spouse_info['customer_spouse_middle_name'] : ''; ?>">
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Last Name </label>
                                        <input type="text" id="lname" name="spouse_last_name" class="form-control" autocomplete="off" value="<?php echo (isset($lead_member_spouse_info['customer_spouse_last_name'])) ? $lead_member_spouse_info['customer_spouse_last_name'] : ''; ?>">
                                    </div>

                                </div>

                                <div class="form-group clearfix">

                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Email Address </label>
                                        <input type="email" id="fname" name="spouse_email_address" class="form-control" autocomplete="off" value="<?php echo (isset($lead_member_spouse_info['customer_spouse_email'])) ? $lead_member_spouse_info['customer_spouse_email'] : ''; ?>">
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="mname">Phone Number </label>
                                        <input type="text" id="mname" name="spouse_phone_no" class="form-control custom_phone_number_marks" autocomplete="off" value="<?php echo (isset($lead_member_spouse_info['customer_spouse_phone_number'])) ? $lead_member_spouse_info['customer_spouse_phone_number'] : ''; ?>">
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Date Of Birth </label>
                                        <div class="date-picker-div">
                                            <input class="form-control dtpicker" placeholder="mm/dd/yyyy" id="datepicker-autoclose" name="spouse_dob" type="text" value="<?php echo (isset($lead_member_spouse_info['customer_spouse_dob']) && !empty($lead_member_spouse_info['customer_spouse_dob'])) ? date('m/d/Y', strtotime($lead_member_spouse_info['customer_spouse_dob'])) : ''; ?>">
                                            <span class="input-group-addon bg-custom b-0 text-white"><i class="icon-calender"></i></span>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group clearfix">

                                    <div class="col-lg-8">
                                        <label for="fname">Address </label>
                                        <input type="text" id="fname" name="spouse_address" class="form-control" autocomplete="off" value="<?php echo (isset($lead_member_spouse_info['customer_spouse_address'])) ? $lead_member_spouse_info['customer_spouse_address'] : ''; ?>">
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Apartment, Suite, etc. </label>
                                        <input type="text" id="lname" name="spouse_sub_address" class="form-control" autocomplete="off" value="<?php echo (isset($lead_member_spouse_info['customer_spouse_address_details'])) ? $lead_member_spouse_info['customer_spouse_address_details'] : ''; ?>">
                                    </div>

                                </div>

                                <div class="form-group clearfix">

                                    <div class="col-lg-4 input_wrapper">
                                        <label for="mname">State </label>
                                        <select class="form-control" id="spo_user_state" name="customer_spouse_state">
                                            <option value="">Select State</option>
                                            <?php foreach ($state as $key => $value) { ?>
                                                <option value="<?php echo $value['state_code']; ?>" <?php echo ( $value['state_code'] == (isset($lead_member_spouse_info['customer_spouse_state'])) ? $lead_member_spouse_info['customer_spouse_state'] : '') ? 'selected' : ''; ?>><?php echo $value['state']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">City </label>
                                        <select class="form-control" id="spo_user_city" name="spouse_city">
                                            <?php foreach ($city_sop as $key => $value) { ?>
                                                <option value="<?php echo $value['city']; ?>" <?php echo ( $value['city'] == $lead_member_spouse_info['customer_spouse_city']) ? 'selected' : ''; ?>><?php echo $value['city']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Zip Code </label>
                                        <input type="text" id="lname" name="spouse_zipcode" class="form-control custome_zipcode" autocomplete="off" value="<?php echo (isset($lead_member_spouse_info['customer_spouse_zipcode'])) ? $lead_member_spouse_info['customer_spouse_zipcode'] : ''; ?>">
                                    </div>

                                </div>
                                <div class="form-group clearfix">

                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Social Security Number </label>
                                        <input type="text" id="fname" name="spouse_ssn" class="form-control securitynumber" autocomplete="off" value="<?php echo (isset($lead_member_spouse_info['customer_spouse_social_security_number'])) ? $lead_member_spouse_info['customer_spouse_social_security_number'] : ''; ?>" >
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
                                    <a class="btn btn-default waves-effect waves-light" href="<?= base_url() . 'admin/leads' ?>"> <span class="btn-label"><i class="fa fa-arrow-left"></i>
                                        </span>Back</a>
                                </div>
                        </form>    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="custom-loader" style="display: none">
    <div class="loader"></div>
</div>
<div id="full-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="full-width-modalLabel" aria-hidden="true" style="display: none;">
    <div id="mga"></div>
</div><!-- /.modal -->
<script>
    $(document).ready(function () {
        $('form').parsley();
        $(function () {
            $("#user_state").change(function () {
                $("#user_city").empty();
                var state = $(this).val();
                $('.custom-loader').show();
                $.ajax({
                    url: '<?php echo base_url() ?>admin/leads/getcity',
                    type: 'POST',
                    data: {'ustid': state},
                    success: function (data) {
                        $('#user_city').html(data);
                        $('.custom-loader').hide();
                    },
                });
            });
        });

        $(function () {
            $("#spo_user_state").change(function () {
                $("#spo_user_city").empty();
                var state = $(this).val();
                $('.custom-loader').show();
                $.ajax({
                    url: '<?php echo base_url() ?>admin/leads/getcity',
                    type: 'POST',
                    data: {'sopstid': state},
                    success: function (data) {
                        $('#spo_user_city').html(data);
                        $('.custom-loader').hide();
                    },
                });
            });
        });
        jQuery(document).on('submit', "#frm_lead_edit", function (event) {
            event.preventDefault();
            save_lead('frm_lead_edit');
        });

        function save_lead(form_id) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>admin/leads/save_lead",
                data: $(document).find("#" + form_id).serialize(),
                success: function (data) {
                    window.location.href = "<?php echo base_url() ?>admin/leads";
                },
            });
        }
    });
    $(document).on('click', '#add_child', function () {
        var html = <?php echo json_encode($this->load->view("admin/lead/get_child", $state, true)); ?>;
        html = html.replace(/0/g, key);
        $(document).find(".div_child_block").append(html);
        $(document).find('.dtpicker').datepicker({
            autoclose: true,
            todayHighlight: true,
            Format: 'yyyy-mm-dd',
        });
    });
    function onchange_city(ele) {
        var parent = jQuery(ele).parent('div');
        var state = jQuery(ele).val();
        jQuery.ajax({
            url: '<?php echo base_url() ?>admin/leads/getcity',
            type: 'POST',
            data: {'sopstid': state},
            success: function (data) {
                jQuery(parent.next('div').find('select')).html(data);
            },
        });
    }

    $(".remove-spouse").click(function () {
        $("input[name=spouse_first_name]").val('');
        $("input[name=spouse_middle_name]").val('');
        $("input[name=spouse_last_name]").val('');
        $("input[name=spouse_email_address]").val('');
        $("input[name=spouse_phone_no]").val('');
        $("input[name=spouse_dob]").val('');
        $("input[name=spouse_address]").val('');
        $("input[name=spouse_sub_address]").val('');
        $("#spo_user_state").prop("selectedIndex", 0);
        $("#spo_user_city").prop("selectedIndex", -1);
        $("input[name=spouse_zipcode]").val('');
        $("input[name=spouse_ssn]").val('');
    });

    //-------- for Remove New added child -----------
    function remove_new_child(obj) {
        $(obj).parent().parent().parent('.new-child').remove();
    }

    //-------- for Remove Old added child -----------
    function remove_old_child(obj) {
        var child_id = $(obj).data('child-id');
        if (child_id) {
            $.post("<?= base_url('agent/leads/remove_child/') ?>" + child_id, function (data) {
                if (data) {
                    $(obj).parent().parent().parent('.old-child').remove();
                }
            });
        } else {
            $(obj).parent().parent().parent('.old-child').remove();
        }

    }
    //------------- Add Product IN LEAD ----------------
    $(".addProduct").click(function () {
        var validation = true;
        var $form = $('#frm_lead_edit');
        $form.parsley().validate();
        var parValue = $form.parsley().validate()
        if (parValue == false) {
            swal("You need to fill this details for conventing this lead in member")
            validation = false;
        }
        //------------ Check IS email ID is already in USER LOGIN TABLE
        var emailid = $('#login_email').val();
        $('.loader-select-city').show();
        $.ajax({
            url: '<?php echo base_url() ?>agent/members/chk_email',
            type: 'POST',
            data: {email: emailid},
            success: function (data) {
                $('#email_msg').html(data);
                if (data != '<i>Email address is valid</i>') {
                    $("#login_email").focus();
                    $("#login_email").addClass("textInputError");
                    validation = false;
                    console.log(validation);
                } else {
                    $("#login_email").removeClass("textInputError");
                }
                $('.loader-select-city').hide();
                product_pop_up(validation);
            },
        });
    });
    function product_pop_up(validation) {
        var emailid = $('#login_email').val();
        if (validation === true) {
            var display_name = $("#cusfname").val() + ' ' + $("#cuslname").val();
            var leadID = '<?php echo $lead_info['customer_id']; ?>';
            var add = $('.lead-add').val();
            var oadd = $('.lead-oadd').val();
            var state = $('#user_state').val();
            var city = $('#user_city').val();
            var zipcode = $('.lead-zipcode').val();
            var ssnumber = $('.securitynumber').val();
            var customer_weight = $('.customer_weight').val();
            var dob = $('.lead-dob').val();
            $.ajax({
                url: '<?php echo base_url() ?>admin/leads/lead_cart',
                type: 'POST',
                data: {email: emailid, display_name: display_name, leadID: leadID, add: add, oadd: oadd, state: state, city: city, zipcode: zipcode, ssnumber: ssnumber, customer_weight: customer_weight, dob: dob},
                dataType: "JSON",
                success: function (data) {
                    console.log(data['new_html']);
                    $('#mga').html(data.new_html);
                    $('#full-width-modal').modal('show');
                },
            });
        }
    }
    $(document).on('click', '.product-add', function () {
        var productID = $(this).data("custom-value-productid");
        var key_id = $(this).data("id");
        var memberID = $("#memberid").val();
        var email = $("#login_email").val();
        console.log(memberID);
        var displayname = $('#cusfname').val() + ' ' + $('#cuslname').val();
        $.ajax({
            method: "POST",
            url: '<?php echo base_url() ?>admin/leads/addproduct',
            data: {product: productID, member: memberID, email: email, displayname: displayname},
            success: function (data) {
                console.log($(this));
                $(".pro-add-" + key_id).attr("disabled", 'disabled');
                $(".pro-remove-" + key_id).attr("disabled", false);
                swal("success", data, "success");
                $.fn.niceScroll && $(".nicescroll").niceScroll({cursorcolor: '#98a6ad', cursorborder: '#98a6ad', cursorwidth: '5px', cursorborderradius: '5px'});
            }
        });
    });
    $(document).on('click', '.save-changes', function () {
        window.location.href = "<?php echo base_url() ?>admin/members";
    });
</script>