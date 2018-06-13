<div class="child_div">
    <div class="text-center">
        <h3><strong>CHILD </strong><a class="btn btn-sm btn-danger pull-right" onclick="remove_new_child(this)" title="Remove Child"><i class="fa fa-times"></i></a></h3>
    </div>

    <div class="form-group clearfix">
        <div class="col-lg-4 input_wrapper">
            <label for="fname">First Name </label>
            <input type="hidden" name="new_child" value="child">
            <input type="text" id="fname" name="form[0][customer_child_first_name]" class="required form-control child_data" autocomplete="off" value="">
        </div>
        <div class="col-lg-4 input_wrapper">
            <label for="mname">Middle Name </label>
            <input type="text" id="mname" name="form[0][customer_child_middle_name]" class="required form-control " autocomplete="off" value="">
        </div>
        <div class="col-lg-4 input_wrapper">
            <label for="fname">Last Name </label>
            <input type="text" id="lname" name="form[0][customer_child_last_name]" class="required form-control" autocomplete="off" value="">
        </div>
    </div>

    <div class="form-group clearfix">
        <div class="col-lg-4 input_wrapper">
            <label for="fname">Email Address </label>
            <input type="email" id="fname" name="form[0][customer_child_email]" class="required form-control" autocomplete="off" value="">
        </div>
        <div class="col-lg-4 input_wrapper">
            <label for="mname">Phone Number </label>
            <input type="text" id="mname" name="form[0][customer_child_phone_number]" class="required form-control child_phone_number" autocomplete="off" value="">
        </div>
        <div class="col-lg-4 input_wrapper">
            <label for="fname">Date Of Birth </label>
            <div class="date-picker-div">
                <input class="form-control dtpicker" placeholder="mm/dd/yyyy" id="datepicker-autoclose" name="form[0][customer_child_dob]" type="text" value="">
                <span class="input-group-addon bg-custom b-0 text-white"><i class="icon-calender"></i></span>
            </div>
        </div>
    </div>

    <div class="form-group clearfix">
        <div class="col-lg-8">
            <label for="fname">Address </label>
            <input type="text" id="fname" name="form[0][customer_child_address]" class="required form-control" autocomplete="off" value="">
        </div>
        <div class="col-lg-4 input_wrapper">
            <label for="fname">Apartment, Suite, etc. </label>
            <input type="text" id="lname" name="form[0][customer_child_address_details]" class="required form-control" autocomplete="off" value="">
        </div>
    </div>

    <div class="form-group clearfix">
        <div class="col-lg-4 input_wrapper">
            <label for="mname">State * </label>
            <select class="form-control  child_state" name="form[0][customer_child_state]" value="" onchange="onchange_city(this)">
                <option value="">Select State</option>
                <?php foreach ($state as $value): ?>
                    <option value=<?php echo $value['state_code'] ?>><?php echo $value['state'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-lg-4 input_wrapper">
            <label for="fname">City * </label>
            <select class="form-control  child_city" name="form[0][customer_child_city]">
                <option value="">Select City</option>
            </select>
        </div>

        <div class="col-lg-4 input_wrapper">
            <label for="fname">Zip Code * </label>
            <input type="text" id="lname" name="form[0][customer_child_zipcode]" class="required form-control child_zipcode" autocomplete="off" value="">
        </div>
    </div>

    <div class="form-group clearfix">
        <div class="col-lg-4 input_wrapper">
            <label for="fname">Social Security Number * </label>
            <input type="text" id="fname" name="form[0][customer_child_social_security_number]" class="required form-control child_social_security_number" autocomplete="off" value="" placeholder="XXX - XX - XXXX">
        </div>
    </div>
</div>
<!--<script>
    $(".child_zipcode").mask("99999");
    </script>
    -->