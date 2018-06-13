<?php
if (count($add_child_block_arr) < 1) {
    $add_child_block_arr = array(
        array(
            'customer_id' => $customer_id,
            'customer_child_first_name' => '',
            'customer_child_middle_name' => '',
            'customer_child_last_name' => '',
            'customer_child_email' => '',
            'customer_child_phone_number' => '',
            'customer_child_dob' => '',
            'customer_child_address' => '',
            'customer_child_address_details' => '',
            'customer_child_city' => '',
            'customer_child_state' => '',
            'customer_child_zipcode' => '',
            'customer_child_social_security_number' => '',
        )
    );
}
?>
<?php
foreach ($add_child_block_arr as $key => $add_child_block) {
//    pr_exit($add_child_block);
    ?>
    <div class="child_div">
        <div class="text-center">
            <h3><strong>CHILD </strong> <a class="btn btn-sm btn-danger pull-right" onclick="remove_old_child(this)" title="Remove Child" data-child-id="<?php echo (isset($add_child_block['child_id'])) ? $add_child_block['child_id'] : ''; ?>"><i class="fa fa-times"></i></a></h3>
        </div>
        <div class="form-group clearfix">
            <div class="col-lg-4 input_wrapper">
                <label for="fname">First Name </label>
                <input type="hidden" name="form[<?php echo $key; ?>][child_id]" value="<?php echo (isset($add_child_block['child_id'])) ? $add_child_block['child_id'] : ''; ?>">
                <input type="hidden" name="form[<?=$key?>][status]" value="<?php echo (isset($add_child_block['child_id'])) ? 'old' : 'new'; ?>">
                <input type="text" id="fname" name="form[<?php echo $key; ?>][customer_child_first_name]" class="form-control child_data" autocomplete="off" value="<?php echo $add_child_block['customer_child_first_name'] ?>">
            </div>
            <div class="col-lg-4 input_wrapper">
                <label for="mname">Middle Name </label>
                <input type="text" id="mname" name="form[<?php echo $key; ?>][customer_child_middle_name]" class="form-control  " autocomplete="off" value="<?php echo $add_child_block['customer_child_middle_name'] ?>">
            </div>
            <div class="col-lg-4 input_wrapper">
                <label for="fname">Last Name </label>
                <input type="text" id="lname" name="form[<?php echo $key; ?>][customer_child_last_name]" class="form-control" autocomplete="off" value="<?php echo $add_child_block['customer_child_last_name'] ?>">
            </div>
        </div>
        <div class="form-group clearfix">
            <div class="col-lg-4 input_wrapper">
                <label for="fname">Email Address </label>
                <input type="email" id="fname" name="form[<?php echo $key; ?>][customer_child_email]" class="form-control" autocomplete="off" value="<?php echo $add_child_block['customer_child_email'] ?>">
            </div>
            <div class="col-lg-4 input_wrapper">
                <label for="mname">Phone Number  </label>
                <input type="text" id="mname" name="form[<?php echo $key; ?>][customer_child_phone_number]" class="form-control child_phone_number" autocomplete="off" value="<?php echo $add_child_block['customer_child_phone_number'] ?>">
            </div>
            <div class="col-lg-4 input_wrapper">
                <label for="fname">Date Of Birth  </label>
                <div class="date-picker-div">
                    <input class="form-control dtpicker" placeholder="mm/dd/yyyy" id="datepicker-autoclose" name="form[<?php echo $key; ?>][customer_child_dob]" type="text" value="<?php echo (isset($add_child_block['customer_child_dob']) && !empty($add_child_block['customer_child_dob'])) ? date('m/d/Y', strtotime($add_child_block['customer_child_dob'])) : ''; ?>">
                    <span class="input-group-addon bg-custom b-0 text-white"><i class="icon-calender"></i></span>
                </div>
            </div>
        </div>
        <div class="form-group clearfix">
            <div class="col-lg-8">
                <label for="fname">Address </label>
                <input type="text"  name="form[<?php echo $key; ?>][customer_child_address]" class="form-control" autocomplete="off" value="<?php echo $add_child_block['customer_child_address'] ?>">
            </div>
            <div class="col-lg-4 input_wrapper">
                <label for="fname">Apartment, Suite, etc. </label>
                <input type="text"  name="form[<?php echo $key; ?>][customer_child_address_details]" class="form-control" autocomplete="off" value="<?php echo $add_child_block['customer_child_address_details'] ?>">
            </div>

        </div>
        <div class="form-group clearfix">
            <div class="col-lg-4 input_wrapper">
                <label for="mname">State </label>
                <select class="form-control  child_state" name="form[<?php echo $key; ?>][customer_child_state]" onchange="onchange_city(this)">
                    <option value="">Select State</option>
                    <?php foreach ($state as $value): ?>
                        <option <?php echo ($add_child_block['customer_child_state'] == $value['state_code']) ? "selected" : ""; ?> value=<?php echo $value['state_code'] ?>><?php echo $value['state'] ?></option>
                    <?php endforeach; ?> 
                </select>
            </div>
            <div class="col-lg-4 input_wrapper">
                <label for="fname">City </label>
                <select class="form-control child_city"  name="form[<?php echo $key; ?>][customer_child_city]">
                    <?php if($add_child_block['customer_child_city'] != ''){ ?>
                        <?php foreach (array_values($get_city[$key]) as $val):  ?>
                            <option <?php echo ($add_child_block['customer_child_city'] == $val['city']) ? "selected" : ""; ?> value=<?php echo isset($val['city'])?$val['city']:''; ?>><?php echo isset($val['city'])?$val['city']:''; ?></option>
                        <?php endforeach; ?> 
                    <?php } else { ?>
                            <option value="">Select City</option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-lg-4 input_wrapper">
                <label for="fname"> Zip Code </label>
                <input type="text" name="form[<?php echo $key; ?>][customer_child_zipcode]" class="form-control child_zipcode" autocomplete="off" value="<?php echo $add_child_block['customer_child_zipcode'] ?>">
            </div>
        </div>

        <div class="form-group clearfix">
            <div class="col-lg-4 input_wrapper">
                <label>Social Security Number </label>
                <input type="text" name="form[<?php echo $key; ?>][customer_child_social_security_number]" class="form-control child_social_security_number" autocomplete="off" value="<?php echo $add_child_block['customer_child_social_security_number'] ?>">
            </div>
        </div>
    </div>
    <script type="text/javascript">key++;</script>
<?php } ?>