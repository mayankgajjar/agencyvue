<script src="<?php echo base_url() ?>assets/plugins/jquery.steps/js/jquery.steps.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/autoNumeric/autoNumeric.js"></script>
<link href="http://dev.agencyvue.com/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="http://dev.agencyvue.com/assets/css/core.css" rel="stylesheet" type="text/css" />
<link href="http://dev.agencyvue.com/assets/css/components.css" rel="stylesheet" type="text/css" />
<link href="http://dev.agencyvue.com/assets/css/icons.css" rel="stylesheet" type="text/css" />
<link href="http://dev.agencyvue.com/assets/css/pages.css" rel="stylesheet" type="text/css" />
<link href="http://dev.agencyvue.com/assets/css/menu.css" rel="stylesheet" type="text/css" />
<link href="http://dev.agencyvue.com/assets/css/responsive.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url() ?>assets/plugins/jquery.steps/js/jquery.steps.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/autoNumeric/autoNumeric.js"></script>
<script type="text/javascript" src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
<style type="text/css">
    .wizard > .steps > ul > li{width: 10%; text-align: center;}
    .group-span-filestyle label{margin-top: 0px!important;}
    .wizard > .steps .number{display: none;}
    .wizard > .steps .disabled a, .wizard > .steps .done a{border-bottom: 2px solid #2DC4B9;border-top: none;border-left: none;border-right: none;margin: 0 0em 0.5em;border-radius: 0px;}
    .wizard > .steps a, .wizard > .steps a:hover, .wizard > .steps a:active{margin: 0 0em 0.5em;border-radius: 0px;}
    .wizard > .steps .disabled a:hover,.wizard > .steps .done a:hover{border-bottom: 2px solid #2DC4B9;border-top: none;border-left: none;border-right: none;margin: 0 0em 0.5em;border-radius: 0px;}
    .wizard > .steps .current a{border-top-left-radius: 5px; border-top-right-radius: 5px;border-bottom: 2px #2dc4b9 !important;}
    .select2-container--default .select2-selection--single, .select2-container--default .select2-selection--multiple{background-color: #323B44;}
    .span-label{font-size: 10px; font-weight: normal;}
</style>
<?php
$product = array();
$statesData = array();
$vStatesData = array();
$filterData = array();
$commissionData = array();
if(isset($product_details['product_data'])){
    $product = $product_details['product_data'];
}
if(isset($product_details['state_data'])){
    $statesData = array_column($product_details['state_data'], 'state');
}
if(isset($product_details['age_weight_height_data'])){
    $filterData = $product_details['age_weight_height_data'];
}
if(isset($product_details['commission'])){
    $commissionData = $product_details['commission'];
    $commissionDataArray = unserialize($commissionData['commission_value']);
}
if(isset($product_details['alternate_script'])){
    $alternate_script = $product_details['alternate_script'];
    $vStatesData = array_column($product_details['alternate_script'], 'states');
}
if(isset($product_details['product_types'])){
    $product_types = $product_details['product_types'];
}
?>
     <div class="wrapper">
            <div class="container">
                <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="page-title">Add New Product</h4>
                    <?php if(!isset($_REQUEST['con'])){ ?>
                        <ol class="breadcrumb">
                            <li><a href="<?= base_url() . 'admin/dashboard' ?>">Dashboard</a></li>
                            <li><a href="<?= base_url() . 'admin/products' ?>">Manage Products</a></li>
                            <li class="active">Add New Product</li>
                        </ol>
                    <?php } else { ?>
                        <style>
                              .page-title {margin-bottom: 10px;}
                        </style>
                    <?php } ?>
                </div>
            </div>
                <!-- end page title end breadcrumb -->
                <!-- Basic Form Wizard -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box">
                        <?php if ((validation_errors())) { ?>
                            <div class="content pt0">
                                <div class="alert alert-danger">
                                    <a class="close" data-dismiss="alert">X</a>
                                    <strong><?= validation_errors() ?></strong>
                                </div>
                            </div>
                      <?php } elseif ($this->session->flashdata('success')) {
                          $data = $this->session->flashdata('success'); ?>
                          <script>
                              $("#verification_script_id").val("<?=$data['popup'];?>");
                          </script>
                       <?php }  ?>
                            <form id="wizard-validation-form" action="#" method="post" enctype="multipart/form-data">
                                <div>
                                    <h3>Vendor</h3>
                                    <section>
                                        <div class="form-group clearfix">
                                            <label class="control-label col-md-12" for="userName">Select Vendor:&nbsp;*</label>
                                            <div class="col-md-4">
                                                <select class="form-control select2 required" name="vendor" id="vendor-select" data-placeholder="Select Vendor">
                                                    <option value="">Select Vendor:*</option>
                                                    <?php foreach ($vendors as $vendor): ?>
                                                        <?php
                                                            $select = '';
                                                            if( isset($product['product_vendor']) && $vendor['vendor_id'] == $product['product_vendor']){
                                                                $select = 'selected="selected"';
                                                            }
                                                        ?>
                                                        <option value="<?= $vendor['vendor_id']; ?>" <?php echo $select; ?>><?= $vendor['vendor_name']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                     <!--   <?php print_r($product_categoies);?>-->
                                          <div class="form-group clearfix">
                                            <label class="control-label col-md-12" for="catrgory">Product Category:&nbsp;*</label>
                                            <div class="col-md-4">
                                                <select class="form-control required" name="catrgory" id="catrgory">
                                                    <option value="">Select Product Category</option>
                                                    <?php foreach ($product_categoies as $key => $value) :?>
                                                        <option value="<?php echo $value['product_category_id']?>" <?php echo isset($product['product_category']) && ($product['product_category'] == $value['product_category_name']) ? 'selected="selected"':''; ?>><?php echo $value['product_category_name']?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <label class="control-label col-md-12" for="product_types">Product Type:&nbsp;*</label>
                                            <div class="col-md-4">
                                            <?php if (isset($product_types) && $product_types != '') :?>
                                                <select class="form-control required" name="product_type" id="product_type">
                                                    <option value="">Select Product Type</option>
                                                      <?php foreach ($product_types as $key => $value) :?>
                                                        <option value="<?php echo $value['product_type_name']?>" <?php echo isset($product['product_type']) && ($product['product_type'] == $value['product_type_name']) ? 'selected="selected"':''; ?>><?php echo $value['product_type_name']?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            <?php else: ?>
                                                <select class="form-control required" name="product_type" id="product_type">
                                                    <option value="">Select Product Type</option>
                                                </select>
                                            <?php endif;?>
                                            </div>
                                        </div>
                                    </section>
                                    <h3>Product</h3>
                                    <section>
                                        <div class="col-md-6">
                                            <div class="form-group clearfix">
                                                <label class="control-label" for="name"> Product ID:&nbsp;<span class="span-label">If you leave this area blank, the system will auto-generate an ID for you.</span></label>
                                                <div class="">
                                                    <input id="product_id" name="product_id" type="text" class="form-control" value="<?php echo isset($product['product_id']) ?  $product['product_id'] : '' ?>"/>
                                                </div>
                                            </div>
                                            <div class="form-group clearfix">
                                                <label class="control-label " for="product_name"> Product Name:&nbsp;*</label>
                                                <div class="">
                                                    <input id="product_name" name="product_name" type="text" class="required form-control" value="<?php echo isset($product['product_name']) ?  $product['product_name'] : '' ?>">
                                                </div>
                                            </div>

                                            <div class="form-group clearfix">
                                                <label class="control-label " for="email">Coverage Type:&nbsp;*</label>
                                                <div class="">
                                                    <select class="form-control required" name="coverage">
                                                        <option value="">Select Coverage</option>
                                                        <option value="Member" <?php echo isset($product['product_coverage']) && $product['product_coverage'] == 'Member' ? 'selected="selected"':''; ?>>Member</option>
                                                        <option value="Member_Spouse" <?php echo isset($product['product_coverage']) && $product['product_coverage'] == 'Member_Spouse' ? 'selected="selected"':''; ?>>Member + Spouse</option>
                                                        <option value="Member_Child" <?php echo isset($product['product_coverage']) && $product['product_coverage'] == 'Member_Child' ? 'selected="selected"':''; ?>>Member + Child</option>
                                                        <option value="Member_Children" <?php echo isset($product['product_coverage']) && $product['product_coverage'] == 'Member_Children' ? 'selected="selected"':''; ?>>Member + Children</option>
                                                        <option value="Family" <?php echo isset($product['product_coverage']) && $product['product_coverage'] == 'Family' ? 'selected="selected"':''; ?>>Family</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label"><?php echo "Product Status" ?></label>
                                                <div class="">
                                                    <select name="product_status" id="product_status" class="form-control">
                                                        <option value="active" <?php echo isset($product['product_status']) && trim($product['product_status']) == 'active' ? 'selected="selected"':'' ?>><?php echo 'Active' ?></option>
                                                        <option value="inactive" <?php echo isset($product['product_status']) && trim($product['product_status']) == 'inactive' ? 'selected="selected"':'' ?>><?php echo 'Inactive' ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <?php if(isset($product['product_image']) && $product['product_image'] != ''): ?>
                                                <img src="<?php echo base_url() ?>assets/crm_image/products/<?php echo $product['product_image'] ?>" alt="image" class="img-fluid img-thumbnail" width="90px" height="90px" id="product_image" name="product_image">
                                            <?php else: ?>
                                                <img src="<?php echo base_url() ?>assets/images/users/avatar-2.jpg" alt="image" class="img-fluid img-thumbnail" width="90px" height="90px" id="product_image" name="product_image">
                                            <?php endif; ?>
                                            <div class="form-group clearfix">
                                                <label class="control-label">Product Image:</label>
                                                <div class="">
                                                    <input type="file" name="product_image" class="filestyle" data-buttonname="btn-default" onchange="displayimage(this)">
                                                    <div class="error_image" style="font-style: italic; color: red; margin-top: 8px; display: none;">Please select jpg ,  png  or gif file format.</div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                    <h3>Filters</h3>
                                    <section>
                                        <div class="col-md-6">
                                        <div class="form-group clearfix">
                                                <div class="form-group clearfix">
                                                    <label class="control-label col-md-12">No Sales State(s): *</label>
                                                    <div class="col-md-6">
                                                        <select class="select2 select2-multiple required" multiple="multiple" multiple data-placeholder="Choose state" name="product_state[]" id="product_state">
                                                            <?php foreach ($states as $state): ?>
                                                            <option value="<?= $state['state_code']; ?>" <?php echo in_array($state['state_code'], $statesData) ? 'selected="selected"':'' ?>><?= $state['state']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group clearfix">
                                                    <label class="control-label col-sm-12"><?php echo "Age Restriction" ?>:</label>
                                                    <div class="col-sm-12">
                                                        <input style="display: inline-block; width: 20%" type="number" name="min_age" class="form-control" value="<?php echo isset($filterData['min_age']) ? $filterData['min_age'] :'' ?>"/>&nbsp;
                                                        <span>To</span>
                                                        &nbsp;<input style="display: inline-block; width: 20%" type="number" name="max_age" class="form-control" value="<?php echo isset($filterData['max_age']) ? $filterData['max_age'] :'' ?>"/>
                                                    </div>
                                                </div>
                                                <div class="form-group clearfix">
                                                    <label class="control-label col-sm-12"><?php echo "Male Weight Restriction" ?>:</label>
                                                    <div class="col-sm-12">
                                                        <input style="display: inline-block; width: 20%" type="number" name="male_min_weight" class="form-control" value="<?php echo isset($filterData['min_weight']) ? $filterData['min_weight'] :'' ?>"/>&nbsp;
                                                        <span>To</span>
                                                        &nbsp;<input style="display: inline-block; width: 20%" type="number" name="male_max_weight" class="form-control" value="<?php echo isset($filterData['max_weight']) ? $filterData['max_weight'] :'' ?>"/>
                                                    </div>
                                                </div>
                                                <div class="form-group clearfix">
                                                    <label class="control-label col-sm-12"><?php echo "Female Weight Restriction" ?>:</label>
                                                    <div class="col-sm-12">
                                                        <input style="display: inline-block; width: 20%" type="number" name="female_min_weight" class="form-control" value="<?php echo isset($filterData['female_min_weight']) ? $filterData['female_min_weight'] :'' ?>"/>&nbsp;
                                                        <span>To</span>
                                                        &nbsp;<input style="display: inline-block; width: 20%" type="number" name="female_max_weight" class="form-control" value="<?php echo isset($filterData['female_max_weight']) ? $filterData['female_max_weight'] :'' ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group clearfix">
                                                <label class="control-label"><?php echo "Allow Pre-Existing Conditions?" ?>:</label>
                                                <div class="" style="display: inline-block;">
                                                    <div class="checkbox checkbox-primary checkbox-inline">
                                                        <input id="allow_conditions_yes" type="checkbox" class="allow_conditions allow_conditions_yes" value="yes" name="allow_conditions" <?php echo isset($product['product_pre_existing']) && $product['product_pre_existing'] =='yes' ? 'checked="checked"':''; ?> />
                                                        <label for="allow_conditions_yes">
                                                            <?php echo "Yes" ?>
                                                        </label>
                                                    </div>
                                                    <div class="checkbox checkbox-primary checkbox-inline">
                                                        <input id="allow_conditions_no" type="checkbox" class="allow_conditions allow_conditions_no" value="no" <?php echo isset($product['product_pre_existing']) && $product['product_pre_existing'] =='no' ? 'checked="checked"':''; ?> <?php echo empty($product) ? 'checked="checked"':'' ?>>
                                                        <label for="allow_conditions_no" name="allow_conditions">
                                                            <?php echo "No" ?>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group clearfix">
                                                <label class="control-label"><?php echo "Allow Tobacco Use?" ?>:</label>
                                                <div class="" style="display: inline-block;">
                                                    <div class="checkbox checkbox-primary checkbox-inline">
                                                        <input id="allow_tobacco_yes" type="checkbox" name="allow_tobacco" value="yes" class="allow_tobacco allow_tobacco_yes" <?php echo isset($product['product_requires_license']) && $product['product_requires_license'] =='no' ? 'checked="checked"':''; ?>/>
                                                        <label for="allow_tobacco_yes">
                                                            <?php echo "Yes" ?>
                                                        </label>
                                                    </div>
                                                    <div class="checkbox checkbox-primary checkbox-inline">
                                                        <input id="allow_tobacco_no" type="checkbox" name="allow_tobacco" value="no" class="allow_tobacco allow_tobacco_no"  <?php echo isset($product['product_requires_license']) && $product['product_requires_license'] =='no' ? 'checked="checked"':''; ?> <?php echo empty($product) ? 'checked="checked"':'' ?>/>
                                                        <label for="allow_tobacco_no">
                                                            <?php echo "No" ?>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group clearfix">
                                                <label class="control-label"><?php echo "Requires License?" ?>:</label>
                                                <div class="" style="display: inline-block;">
                                                    <div class="checkbox checkbox-primary checkbox-inline">
                                                        <input id="license_yes" type="checkbox" name="license" class="license license_yes" value="yes" checked=""/>
                                                        <label for="license_yes">
                                                            <?php echo 'Yes' ?>
                                                        </label>
                                                    </div>
                                                    <div class="checkbox checkbox-primary checkbox-inline">
                                                        <input id="license_no" type="checkbox" name="license" class="license license_no" value="no" />
                                                        <label for="license_no">
                                                            <?php echo 'No' ?>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group clearfix">
                                                <label class="control-label"><?php echo "Required License(s):" ?>:</label>
                                                <div class="" style="display: inline-block;">
                                                    <div class="checkbox checkbox-primary checkbox-inline">
                                                        <input type="checkbox" name="license_type[]" id="license_health" value="health" class="license_type"/>
                                                        <label for="license_health">
                                                            <?php echo 'Health' ?>
                                                        </label>
                                                    </div>
                                                    <div class="checkbox checkbox-primary checkbox-inline">
                                                        <input id="license_accident" type="checkbox" name="license_type[]" value="accident" class="license_type"/>
                                                        <label for="license_accident">
                                                            <?php echo 'Accident' ?>
                                                        </label>
                                                    </div>
                                                    <div class="checkbox checkbox-primary checkbox-inline">
                                                        <input id="license_life" type="checkbox" name="license_type[]" value="life" class="license_type"/>
                                                        <label for="license_life">
                                                            <?php echo 'Life' ?>
                                                        </label>
                                                    </div>
                                                    <div class="checkbox checkbox-primary checkbox-inline">
                                                        <input id="license_property" type="checkbox" name="license_type[]" value="propertyandcasualty" class="license_type" />
                                                        <label for="license_property">
                                                            <?php echo 'Property & Casualty' ?>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group clearfix">
                                                <label class="control-label"><?php echo "Requires Appointment?" ?>:</label>
                                                <div class="" style="display: inline-block;">
                                                    <div class="checkbox checkbox-primary checkbox-inline">
                                                        <input id="appointment_yes" type="checkbox" class="appointment appointment_yes" value="yes" name="appointment" />
                                                        <label for="appointment_yes">
                                                            <?php echo 'Yes' ?>
                                                        </label>
                                                    </div>
                                                    <div class="checkbox checkbox-primary checkbox-inline">
                                                        <input id="appointment_no" type="checkbox" class="appointment appointment_no" name="appointment" value="no" checked="" />
                                                        <label for="appointment_no">
                                                            <?php echo 'No' ?>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                    <h3>Billing</h3>
                                    <section>
                                        <div class="col-md-6">
                                            <div class="form-group clearfix">
                                                <label class="control-label"><?php echo 'Product Price:' ?>&nbsp;*</label>
                                                <div class="">
                                                    <input type="text" name="product_price" class="form-control required price_input_mask" placeholder="$ XXXX.XX" value="<?php echo isset($product['product_price']) ? formatMoney($product['product_price'], 2, TRUE) :'' ?>"/>                                                </div>
                                            </div>
                                            <div class="form-group clearfix">
                                                <label class="control-label"><?php echo 'Enrollment Fee(s):' ?>&nbsp;*</label>
                                                <div class="">
                                                    <input data-role="tagsinput" required type="text" name="enrollment_fee" id="enrollment_fee" class="form-control  numbersOnly " value="<?php echo isset($enroll_data) ? $enroll_data : '' ; ?>"/>
                                                </div>
                                            </div>
                                            <div class="form-group clearfix">
                                                <label class="control-label"><?php echo 'Enrollment Billing Rule:' ?></label>
                                                <div class="">
                                                     <select class="form-control" name="enrollment_billing">
                                                         <option value=""><?php echo "Please Select" ?></option>
                                                         <option value="One Time" <?php echo isset($product['product_enrollment_billing_rule']) && trim($product['product_enrollment_billing_rule']) == 'One Time' ? 'selected="selected"':'' ?>><?php echo "One Time"; ?></option>
                                                         <option value="Weekly" <?php echo isset($product['product_enrollment_billing_rule']) && trim($product['product_enrollment_billing_rule']) == 'Weekly' ? 'selected="selected"':'' ?>><?php echo "Weekly"; ?></option>
                                                         <option value="Semi-Montly" <?php echo isset($product['product_enrollment_billing_rule']) && trim($product['product_enrollment_billing_rule']) == 'Semi-Montly' ? 'selected="selected"':'' ?>><?php echo "Semi-Montly"; ?></option>
                                                         <option value="Montly" <?php echo isset($product['product_enrollment_billing_rule']) && trim($product['product_enrollment_billing_rule']) == 'Montly' ? 'selected="selected"':'' ?>><?php echo "Montly"; ?></option>
                                                         <option value="Yearly" <?php echo isset($product['product_enrollment_billing_rule']) && trim($product['product_enrollment_billing_rule']) == 'Yearly' ? 'selected="selected"':'' ?>><?php echo "Yearly"; ?></option>
                                                     </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group clearfix">
                                                <label class="control-label"><?php echo 'Billing Rule:' ?></label>
                                                <div class="">
                                                     <select class="form-control" name="billing_rule">
                                                         <option value=""><?php echo "Please Select" ?></option>
                                                         <option value="One Time" <?php echo isset($product['product_billing_rule']) && trim($product['product_billing_rule']) == 'One Time' ? 'selected="selected"':'' ?>><?php echo "One Time"; ?></option>
                                                         <option value="Weekly" <?php echo isset($product['product_billing_rule']) && trim($product['product_billing_rule']) == 'Weekly' ? 'selected="selected"':'' ?>><?php echo "Weekly"; ?></option>
                                                         <option value="Semi-Montly" <?php echo isset($product['product_billing_rule']) && trim($product['product_billing_rule']) == 'Semi-Montly' ? 'selected="selected"':'' ?>><?php echo "Semi-Montly"; ?></option>
                                                         <option value="Montly" <?php echo isset($product['product_billing_rule']) && trim($product['product_billing_rule']) == 'Montly' ? 'selected="selected"':'' ?>><?php echo "Montly"; ?></option>
                                                         <option value="Yearly" <?php echo isset($product['product_billing_rule']) && trim($product['product_billing_rule']) == 'Yearly' ? 'selected="selected"':'' ?>><?php echo "Yearly"; ?></option>
                                                     </select>
                                                </div>
                                            </div>
                                            <div class="form-group clearfix">
                                                <label class="control-label"><?php echo 'Next Billing Date Rule:' ?></label>
                                                <div class="">
                                                     <select class="form-control" name="next_billing_date_rule">
                                                         <option value=""><?php echo "Please Select" ?></option>
                                                         <option value="Same day each month" <?php echo isset($product['product_next_billing_date_rule']) && trim($product['product_next_billing_date_rule']) == 'One Time' ? 'selected="selected"':'' ?>><?php echo "Same day each month" ?></option>
                                                         <option value="1st of every month" <?php echo isset($product['product_next_billing_date_rule']) && trim($product['product_next_billing_date_rule']) == '1st of every month' ? 'selected="selected"':'' ?>><?php echo "1st of every month" ?></option>
                                                         <option value="15th of every month" <?php echo isset($product['product_next_billing_date_rule']) && trim($product['product_next_billing_date_rule']) == '15th of every month' ? 'selected="selected"':'' ?>><?php echo "15th of every month" ?></option>
                                                     </select>
                                                </div>
                                            </div>
                                            <div class="form-group clearfix">
                                                <label class="control-label"><?php echo 'Activation Date Rule:' ?></label>
                                                <div class="">
                                                    <select name="activation_rule" class="form-control">
                                                        <option value=""><?php echo 'Please Select' ?></option>
                                                        <option value="Next Day" <?php echo isset($product['product_activation_date_rule']) && trim($product['product_activation_date_rule']) == 'Next Day' ? 'selected="selected"':'' ?>><?php echo 'Next Day' ?></option>
                                                        <option value="1st & 15th of the month" <?php echo isset($product['product_activation_date_rule']) && trim($product['product_activation_date_rule']) == '1st & 15th of the month' ? 'selected="selected"':'' ?>><?php echo '1st & 15th of the month' ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                    <h3>Verification</h3>
                                    <section>
                                        <div class="form-group clearfix">
                                            <label class="control-label col-md-12"><?php echo 'Master Verification Script:' ?></label>
                                            <div class="col-md-4">
                                                  <input type="file" name="verification_script" required class="filestyle" data-icon="false" data-buttonname="btn-default">
                                            </div>
                                            <?php if(isset($product['verification_script']) && $product['verification_script'] != '' ): ?>
                                            <div class="col-md-4">
                                                <audio controls>
                                                    <source src="<?php echo base_url() ?>assets/product_verification_script/<?php echo $product['verification_script'] ?>" >
                                                </audio>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-sm-12" id="script-tag"  style="padding: 0 !important;">
                                            <div class="col-md-4">
                                                <div class="form-group clearfix">
                                                    <label class="control-label col-md-12"><?php echo 'Alternate Verification Script:' ?></label>
                                                    <div class="col-md-12" style="padding: 0px !important;">
                                                           <input type="file" name="alternate_script[]" id="alternate_script" class="filestyle" required data-icon="false" data-buttonname="btn-default">
                                                    </div>
                                                     <?php if(isset($alternate_script)): ?>
                                                        <?php foreach ($alternate_script as $key=>$value): ?>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <audio controls>
                                                                    <source src="<?php echo base_url() ?>assets/alternate_product_verification_script/<?php echo $value['script_name']?>" >
                                                                </audio>
                                                            </div>
                                                        </div>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group clearfix">
                                                    <label class="control-label col-md-12"><?php echo 'State Rule:' ?></label>
                                                    <div class="col-md-12">
                                                        <select class="select2 select2-multiple required" multiple="multiple" multiple data-placeholder="Choose state" name="script_state_rule[]" id="product_state_rule">
                                                            <?php foreach ($states as $state): ?>
                                                                <option value="<?= $state['state_code']; ?>" <?php echo in_array($state['state_code'], $vStatesData) ? 'selected="selected"':'' ?>><?= $state['state']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group clearfix">
                                                    <label class="control-label col-md-12"><?php echo 'Status:' ?></label>
                                                    <div class="" style="display: inline-block;">
                                                       <div class="checkbox checkbox-primary checkbox-inline">
                                                        <input id="status_active" type="checkbox" name="script_rule_status" class="status status_active" value="active" checked="">
                                                            <label for="status_active">
                                                                <?php echo 'Active' ?>
                                                            </label>
                                                       </div>
                                                       <div class="checkbox checkbox-primary checkbox-inline">
                                                        <input id="status_inactive" type="checkbox" name="script_rule_status" class="status status_inactive" value="inactive" />
                                                            <label for="status_inactive">
                                                                <?php echo 'Inactive' ?>
                                                            </label>
                                                       </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix col-md-4">
                                            <button type="button" onclick="javascript:addVerificationRule()" class="btn btn-default btn-md waves-effect waves-light" id="add_script_rule_btn">Add Script Rule</button>
                                        </div>
                                        <div class="rules">

                                        </div>
                                    </section>
                                    <h3>Commission</h3>
                                    <section>
                                        <div class="col-md-4">
                                        <div class="form-group clearfix">
                                            <label class="control-label"><?php echo 'Commission are paid' ?>:</label>
                                            <div class="">
                                                <div class="checkbox checkbox-primary">
                                                    <input id="commision_paid_1" type="checkbox" name="commission_paid" value="ontime" class="commision-paid" <?php echo isset($commissionData['commission_paid']) && $commissionData['commission_paid'] == 'ontime' ? 'checked="checked"':'' ?>  <?php echo empty($commissionData) ? 'checked=""':'' ?>>
                                                    <label for="commision_paid_1">
                                                        <?php echo 'On-Time' ?>
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="commision_paid_2" type="checkbox" name="commission_paid" value="weekly" class="commision-paid" <?php echo isset($commissionData['commission_paid']) && $commissionData['commission_paid'] == 'weekly' ? 'checked="checked"':'' ?>/>
                                                    <label for="commision_paid_2">
                                                        <?php echo 'Weekly' ?>
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="commision_paid_3" type="checkbox" class="commission_paid" value="bimonthly" name="commision_paid" <?php echo isset($commissionData['commission_paid']) && $commissionData['commission_paid'] == 'bimonthly' ? 'checked="checked"':'' ?> />
                                                    <label for="commision_paid_3">
                                                        <?php echo 'Bi-Monthly' ?>
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="commision_paid_4" type="checkbox" class="commission_paid" value="montly" name="commision_paid" <?php echo isset($commissionData['commission_paid']) && $commissionData['commission_paid'] == 'montly' ? 'checked="checked"':'' ?>/>
                                                    <label for="commision_paid_4">
                                                        <?php echo 'Monthly' ?>
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="commision_paid_5" type="checkbox" class="commission_paid" value="yearly" name="commision_paid" <?php echo isset($commissionData['commission_paid']) && $commissionData['commission_paid'] == 'yearly' ? 'checked="checked"':'' ?>/>
                                                    <label for="commision_paid_5">
                                                        <?php echo 'Yearly' ?>
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="commision_paid_6" type="checkbox" name="commision_paid" class="commision-paid" value="everydays" <?php echo isset($commissionData['commission_paid']) && $commissionData['commission_paid'] == 'everydays' ? 'checked="checked"':'' ?>/>
                                                    <label for="commision_paid_6">
                                                        <?php echo 'Every' ?>&nbsp;<input class="form-control" style="display: inline-block;width: 25%;" type="" name="everyday" />&nbsp;Days
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="commision_paid_7" type="checkbox" name="commision_paid" class="commision-paid" value="everymonth" <?php echo isset($commissionData['commission_paid']) && $commissionData['commission_paid'] == 'everymonth' ? 'checked="checked"':'' ?> />
                                                    <label for="commision_paid_7">
                                                        <?php echo 'Every' ?>&nbsp;<input class="form-control" style="display: inline-block;width: 25%;" type="" name="everymonth" />&nbsp;Months
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group clearfix">
                                            <label class="control-label"><?php echo 'Renewals are paid' ?>:</label>
                                            <div class="">
                                                <div class="checkbox checkbox-primary">
                                                    <input id="renewal_paid_1" type="checkbox" name="renewals_paid" class="renewal-paid" value="ontime" <?php echo isset($commissionData['renewals_paid']) && $commissionData['renewals_paid'] == 'ontime' ? 'checked="checked"':'' ?>  <?php echo empty($commissionData) ? 'checked=""':'' ?> />
                                                    <label for="renewal_paid_1">
                                                        <?php echo 'On-Time' ?>
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="renewal_paid_2" type="checkbox" name="renewals_paid" class="renewal-paid" value="weekly" <?php echo isset($commissionData['renewals_paid']) && $commissionData['renewals_paid'] == 'weekly' ? 'checked="checked"':'' ?>/>
                                                    <label for="renewal_paid_2">
                                                        <?php echo 'Weekly' ?>
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="renewal_paid_3" type="checkbox" name="renewals_paid" class="renewal-paid" value="bimonthly" <?php echo isset($commissionData['renewals_paid']) && $commissionData['renewals_paid'] == 'bimonthly' ? 'checked="checked"':'' ?>/>
                                                    <label for="renewal_paid_3">
                                                        <?php echo 'Bi-Monthly' ?>
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="renewal_paid_4" type="checkbox" name="renewals_paid" class="renewal-paid" value="monthly" <?php echo isset($commissionData['renewals_paid']) && $commissionData['renewals_paid'] == 'monthly' ? 'checked="checked"':'' ?>/>
                                                    <label for="renewal_paid_4">
                                                        <?php echo 'Monthly' ?>
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="renewal_paid_5" type="checkbox" name="renewals_paid" class="renewal-paid" value="yearly" <?php echo isset($commissionData['renewals_paid']) && $commissionData['renewals_paid'] == 'yearly' ? 'checked="checked"':'' ?>/>
                                                    <label for="renewal_paid_5">
                                                        <?php echo 'Yerly' ?>
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="renewal_paid_6" type="checkbox" name="renewals_paid" class="renewal-paid" value="everydays" <?php echo isset($commissionData['renewals_paid']) && $commissionData['renewals_paid'] == 'everydays' ? 'checked="checked"':'' ?>/>
                                                    <label for="renewal_paid_6">
                                                        <?php echo 'Every' ?>&nbsp;<input class="form-control" style="display: inline-block;width: 25%;" type="" name="renewal_every_days" />&nbsp;Days
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="renewal_paid_7" type="checkbox" name="renewals_paid" class="renewal-paid" value="everymonth" <?php echo isset($commissionData['renewals_paid']) && $commissionData['renewals_paid'] == 'everymonth' ? 'checked="checked"':'' ?>/>
                                                    <label for="renewal_paid_7">
                                                        <?php echo 'Every' ?>&nbsp;<input class="form-control" style="display: inline-block; width: 25%;" type="" name="renewal_every_month" />&nbsp;Months
                                                    </label>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="control-label"><?php echo 'Commision Structure' ?>:</label>
                                            <div class="">
                                                <div class="checkbox checkbox-primary">
                                                    <input id="structure_1" type="checkbox" required name="commission_structure" class="commision-structure" value="flatfee" <?php echo isset($commissionData['commission_structure']) && $commissionData['commission_structure'] == 'flatfee' ? 'checked="checked"':'' ?>  <?php echo empty($commissionData) ? 'checked=""':'' ?> />
                                                    <label for="structure_1">
                                                        <?php echo 'Flat Fee' ?>
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="structure_2" type="checkbox" name="commission_structure" class="commision-structure" value="percentpremium" <?php echo isset($commissionData['commission_structure']) && $commissionData['commission_structure'] == 'percentpremium' ? 'checked="checked"':'' ?>/>
                                                    <label for="structure_2">
                                                        <?php echo 'Percent of Premium' ?>
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="structure_3" type="checkbox" name="commission_structure" class="commision-structure" value="tieryears" <?php echo isset($commissionData['commission_structure']) && $commissionData['commission_structure'] == 'tieryears' ? 'checked="checked"':'' ?>/>
                                                    <label for="structure_3">
                                                        <?php echo 'Tier Years' ?>
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="structure_4" type="checkbox" name="commission_structure" class="commision-structure" value="commissionablepremium" <?php echo isset($commissionData['commission_structure']) && $commissionData['commission_structure'] == 'commissionablepremium' ? 'checked="checked"':'' ?>/>
                                                    <label for="structure_4">
                                                        <?php echo 'Commissionable Premiums' ?>
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="structure_5" type="checkbox" name="commission_structure" class="commision-structure" value="calendarpremium" <?php echo isset($commissionData['commission_structure']) && $commissionData['commission_structure'] == 'calendarpremium' ? 'checked="checked"':'' ?>/>
                                                    <label for="structure_5">
                                                        <?php echo 'Prorated Calendar Premiums (Medicare Advantage)' ?>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div id="flatfree_div">
                                            <h4><?php echo 'Flat Free Commission Structure' ?></h4>
                                            <div class="form-group row">
                                                <label class="col-md-2 control-label">Commission:</label>
                                                <div class="col-md-2">
                                                    <input class="form-control" required type="number" name="flat_commission" value="<?php echo isset($commissionDataArray['flat_commission']) ? $commissionDataArray['flat_commission'] : ''?>"/>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-2 control-label">Renewal:</label>
                                                <div class="col-md-2">
                                                    <input class="form-control" required type="number" name="flat_renewal" value="<?php echo isset($commissionDataArray['flat_renewal']) ? $commissionDataArray['flat_renewal'] : ''?>"/>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <!-- End row -->
            </div> <!-- end container -->
        </div>

<script type="text/javascript">
var count = 1;
function addVerificationRule(){
    if(count == 52){
        return false;
    }
    //var html = jQuery("#script-tag").clone();
    var html = '<div class="col-sm-12" id="script-tag"  style="padding: 0 !important;"><div class="col-md-4"><div class="form-group clearfix"><label class="control-label col-md-12"><?php echo 'Alternate Verification Script:' ?></label><div class="col-md-12" style="padding: 0px !important;"><input type="file" name="alternate_script[]" id="alter_file_'+count+'" class="filestyle" data-icon="false" data-buttonname="btn-default"></div></div></div></div>';
    jQuery('.rules').append(html);
    jQuery('#script_state_'+count).select2();
    jQuery("#alter_file_"+count).filestyle();
    count++;
}
//initializing
var _validFileExtensions = [".png",".jpg",".jpeg"];
function displayimage(oInput)
{
     if (oInput.type == "file") {
            var sFileName = oInput.value;
            if (sFileName.length > 0) {
                var blnValid = false;
                for (var j = 0; j < _validFileExtensions.length; j++) {
                    var sCurExtension = _validFileExtensions[j];
                    if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                        blnValid = true;
                        $(".error_verification").hide();
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $('#product_image')
                                .attr('src', e.target.result)
                        };
                        reader.readAsDataURL(oInput.files[0]);
                        $('#product_image').attr('src', sFileName);
                        break;
                    }
                }

                if (!blnValid) {
                    $(".error_verification").show();
                    oInput.value = "";
                    return false;
                }
            }
        }
        return true;
}
!function($) {
    "use strict";

    var FormWizard = function() {};

    FormWizard.prototype.createBasic = function($form_container) {
        $form_container.children("div").steps({
            headerTag: "h3",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            onFinishing: function (event, currentIndex) {
                //NOTE: Here you can do form validation and return true or false based on your validation logic
                console.log("Form has been validated!");
                return true;
            },
            onFinished: function (event, currentIndex) {
               //NOTE: Submit the form, if all validation passed.
                console.log("Form can be submitted using submit method. E.g. $('#basic-form').submit()");
                $("#basic-form").submit();

            }
        });
        return $form_container;
    },
    //creates form with validation
    FormWizard.prototype.createValidatorForm = function($form_container) {
        $form_container.validate({
            errorPlacement: function errorPlacement(error, element) {
                console.log("1");
                var id = jQuery(element).attr('id');
                if(id === 'vendor-select'){
                    jQuery(element).parent('div').append(error);
                }else{
                    element.after(error);
                }
            }
        });
        $form_container.children("div").steps({
            headerTag: "h3",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            onStepChanging: function (event, currentIndex, newIndex) {
                var fee = $("#enrollment_fee").val();
                if (fee == '' && currentIndex == '3')
                {
                    window.alert("Please enter enrollment fee.");
                    $( "#enrollment_fee" ).focus();
                    return false;
                }
               // $('input, select, textarea').removeAttr('required');
                $form_container.validate().settings.ignore = ":disabled,:hidden";
                return $form_container.valid();
            },
            onFinishing: function (event, currentIndex) {
                $form_container.validate().settings.ignore = ":disabled";
                return $form_container.valid();
            },
             onFinished: function (event, currentIndex) {
                 $("#wizard-validation-form").submit();
             }
        });

        return $form_container;
    },
    //creates vertical form
    FormWizard.prototype.createVertical = function($form_container) {
                console.log("5");
        $form_container.steps({
            headerTag: "h3",
            bodyTag: "section",
            transitionEffect: "fade",
            stepsOrientation: "vertical"
        });
        return $form_container;
    },
    FormWizard.prototype.init = function() {
        this.createBasic($("#basic-form"));
        this.createValidatorForm($("#wizard-validation-form"));
        this.createVertical($("#wizard-vertical"));
    },
    //init
    $.FormWizard = new FormWizard, $.FormWizard.Constructor = FormWizard
}(window.jQuery),
function($) {
     var structure = "<?php echo isset($commissionData['commission_structure']) ? $commissionData['commission_structure'] : 'flatfee'?>";
      retriveHTMLContent(structure);

    //
    "use strict";
    $.FormWizard.init();
    $(".select2").select2();
    jQuery(document).on('click', '.allow_conditions', function () {
        var allow_conditions = jQuery(this).val();
        if (allow_conditions == "yes") {
            jQuery('#allow_conditions_no').prop('checked', false); // Unchecks it
        }
        if (allow_conditions == "no") {
            jQuery('#allow_conditions_yes').prop('checked', false); // Unchecks it
        }
    });
    jQuery(document).on('click', '.allow_tobacco', function () {
        var allow_conditions = jQuery(this).val();
        if (allow_conditions == "yes") {
            jQuery('#allow_tobacco_no').prop('checked', false); // Unchecks it
        }
        if (allow_conditions == "no") {
            jQuery('#allow_tobacco_yes').prop('checked', false); // Unchecks it
        }
    });

    jQuery(document).on('change', 'input[name=commission_structure]', function () {
        var structure = jQuery(this).val();
        retriveHTMLContent(structure);
        //$(structure_string).css({"display":"block"});
    });
    jQuery(document).on('click', '.license', function () {
        var license = jQuery(this).val();
        if (license == "yes") {
            jQuery('#license_no').prop('checked', false); // Unchecks it
        }
        if (license == "no") {
            jQuery('#license_yes').prop('checked', false); // Unchecks it
        }
    });

    jQuery(document).on('click', '.appointment', function () {
        var appointment = $(this).val();
        if (appointment == "yes") {
            jQuery('#appointment_no').prop('checked', false); // Unchecks it
        }
        if (appointment == "no") {
            jQuery('#appointment_yes').prop('checked', false); // Unchecks it
        }
    });
    jQuery(document).on('click', '.status', function () {
        var appointment = $(this).val();
        if (appointment == "active") {
            jQuery('#status_inactive').prop('checked', false); // Unchecks it
        }
        if (appointment == "inactive") {
            jQuery('#status_active').prop('checked', false); // Unchecks it
        }
    });
    jQuery(document).on('click', '.commision-paid', function(){
        jQuery('.commision-paid').prop('checked', false);
        jQuery(this).prop('checked', true);
    });
    jQuery(document).on('click', '.renewal-paid', function(){
        jQuery('.renewal-paid').prop('checked', false);
        jQuery(this).prop('checked', true);
    });

    jQuery(document).on('click', '.commision-structure', function(){
        jQuery('.commision-structure').prop('checked', false);
        jQuery(this).prop('checked', true);
    });
    jQuery(document).on('click', '.commissionablepremiumtime', function(){
        jQuery('.commissionablepremiumtime').prop('checked', false);
        jQuery(this).prop('checked', true);
    });
    jQuery('#enrollment_fee').on('itemAdded', function (event, element) {
        console.log(event);
        var tag = event.item;
        tag = tag.replace(/[^0-9\.]/g, '');
      //  event.item = "bnfmb";
        if (tag.length <= 0) {
            var removeAble = jQuery('.label-info').length;
            jQuery('.label-info').eq((removeAble - 1)).remove();
            return false;
        }
    });

    jQuery(document).on('change', 'input[name=license]', function(){
        var value = $(this).val();
        if (value == 'no')
        {
            $('.license_type').prop("disabled",true);
        }
        else
        {
            $('.license_type').prop("disabled",false);
        }
    });

    $('.price_input_mask').inputmask("numeric", {
        radixPoint: ".",
        groupSeparator: ",",
        digits: 2,
        autoGroup: true,
        prefix: '$ ', //Space after $, this will not truncate the first character.
        rightAlign: false,
        oncleared: function () { self.Value(''); }
    });
    jQuery(document).on('change', 'input[name=script_rule_status]', function () {
        var script_rule_status = jQuery(this).val();
        if (script_rule_status == 'inactive')
        {
            document.getElementById("alternate_script").disabled = true;
            document.getElementById("product_state_rule").disabled = true;
            document.getElementById("add_script_rule_btn").disabled = true;
            $("#product_state_rule-error").attr("style","display:none") ;
            $("#alternate_script-error").attr("style","display:none") ;
        }
        else
        {
            document.getElementById("alternate_script").disabled = false;
            document.getElementById("product_state_rule").disabled = false;
            document.getElementById("add_script_rule_btn").disabled = false;
        }
    });

    function retriveHTMLContent(structure)
    {
        if (structure == 'percentpremium')
        {
            var html = '<div id="percentpremium_div">\
                            <h4><?php echo 'Variable Percentage of Premium Structure' ?></h4>\
                            <div class="form-group row">\
                                <label class="col-md-4 control-label">% of Premium (Commission) </label>\
                                <div class="col-md-2">\
                                    <input class="form-control" type="number" required name="percent_premium_commsion" value="<?php echo isset($commissionDataArray['percent_premium_commsion']) ? $commissionDataArray['percent_premium_commsion'] : ''?>">\
                                </div>\
                                <div class="col-md-6">\
                                   <div class="checkbox checkbox-primary checkbox-inline">\
                                       <input id="monthly" type="checkbox" name="percent_premium_duration" value="monthly" class="commissionablepremiumtime" <?php echo isset($commissionDataArray['percent_premium_duration']) && $commissionDataArray['percent_premium_duration'] == 'monthly' ? 'checked="checked"':''?> />\
                                        <label for="monthly">\
                                            <?php echo 'Monthly' ?>\
                                        </label>\
                                   </div>\
                                   <div class="checkbox checkbox-primary checkbox-inline">\
                                    <input id="annual" type="checkbox" name="percent_premium_duration" value="annual" class="commissionablepremiumtime" <?php echo isset($commissionDataArray['percent_premium_duration']) && $commissionDataArray['percent_premium_duration'] == 'annual' ? 'checked="checked"':'' ?>/>\
                                        <label for="annual">\
                                            <?php echo 'Annual' ?>\
                                        </label>\
                                   </div>\
                                </div>\
                            </div>\
                            <div class="form-group row" >\
                                <label class="col-md-4 control-label">% of Preminum(Renewal)</label>\
                                <div class="col-md-2">\
                                    <input class="form-control" required type="number" name="percent_premium_renewal" value="<?php echo isset($commissionDataArray['percent_premium_renewal']) ? $commissionDataArray['percent_premium_renewal'] : ''?>"/>\
                                </div>\
                            </div>\
                            <div class="form-group row">\
                                <label class="col-md-4 control-label">Non-Commissionable Amount</label>\
                                <div class="col-md-2">\
                                    <input class="form-control" required type="number" name="percent_noncommissionable_premium" value="<?php echo isset($commissionDataArray['percent_noncommissionable_premium']) ? $commissionDataArray['percent_noncommissionable_premium'] : ''?>" />\
                                </div>\
                            </div>\
                            <div class="form-group row">\
                                <label class="col-md-4 control-label">Default Premium</label>\
                                <div class="col-md-2">\
                                    <input class="form-control" required type="number" name="default_percent_premium" value="<?php echo isset($commissionDataArray['default_percent_premium']) ? $commissionDataArray['default_percent_premium'] : ''?>"/>\
                                </div>\
                            </div>\
                        </div>';
        }
        else if (structure == 'flatfee')
        {
            var html = '<div id="flatfree_div">\
                                            <h4>Flat Free Commission Structure</h4>\
                                            <div class="form-group row">\
                                                <label class="col-md-2 control-label">Commission:</label>\
                                                <div class="col-md-2">\
                                                    <input class="form-control" required="" name="flat_commission" value="<?php echo isset($commissionDataArray['flat_commission']) ? $commissionDataArray['flat_commission']: '' ?>" aria-required="true" type="number">\
                                                </div>\
                                            </div>\
                                            <div class="form-group row">\
                                                <label class="col-md-2 control-label">Renewal:</label>\
                                                <div class="col-md-2">\
                                                    <input class="form-control" required="" name="flat_renewal" value="<?php echo isset($commissionDataArray['flat_renewal']) ? $commissionDataArray['flat_renewal']: '' ?>" aria-required="true" type="number">\
                                                </div>\
                                            </div>\
                                        </div>';
        }
        else if (structure == 'tieryears')
        {
            var html = '<div id="tieryears_div">\
                        <h4><?php echo 'Standard Percentage of Premium' ?></h4>\
                        <div class="form-group row">\
                            <label class="col-md-2 control-label">Premium</label>\
                            <div class="col-md-2">\
                                <input class="form-control" type="text" required name="tieryears_premium" value="<?php echo isset($commissionDataArray['tieryears_premium']) ? $commissionDataArray['tieryears_premium'] : ''?>">\
                            </div>\
                            <div class="col-md-8">\
                               <div class="checkbox checkbox-primary checkbox-inline">\
                                   <input id="monthly" type="checkbox"  name="tieryears_premium_duration" value="monthly" class="commissionablepremiumtime" <?php echo isset($commissionDataArray['tieryears_premium_duration']) && trim($commissionDataArray['tieryears_premium_duration']) == 'monthly' ? 'checked="checked"':'' ?>/>\
                                    <label for="monthly">\
                                        <?php echo 'Monthly' ?>\
                                    </label>\
                               </div>\
                               <div class="checkbox checkbox-primary checkbox-inline">\
                                <input id="annual" type="checkbox"  name="tieryears_premium_duration" value="annual" class="commissionablepremiumtime" <?php echo isset($commissionDataArray['tieryears_premium_duration']) && trim($commissionDataArray['tieryears_premium_duration']) == 'annual' ? 'checked="checked"':'' ?>/>\
                                    <label for="annual">\
                                        <?php echo 'Annual' ?>\
                                    </label>\
                               </div>\
                            </div>\
                        </div>\
                        <div class="form-group row">\
                            <label class="col-md-2 control-label">Tier-1 Number of Years</label>\
                            <div class="col-md-2">\
                                <input class="form-control" type="number" name="tier1_number_years" value="<?php echo isset($commissionDataArray['tier1_number_years']) ? $commissionDataArray['tier1_number_years'] : ''?>">\
                            </div>\
                             <label class="col-md-2 control-label">% of Premium Per Year</label>\
                            <div class="col-md-2">\
                                <input class="form-control" type="number" name="tier1_percent_premium" value="<?php echo isset($commissionDataArray['tier1_percent_premium']) ? $commissionDataArray['tier1_percent_premium'] : ''?>">\
                            </div>\
                        </div>\
                        <div class="form-group row">\
                            <label class="col-md-2 control-label">Tier-2 Number of Years</label>\
                            <div class="col-md-2">\
                                <input class="form-control" type="number" name="tier2_number_years" value="<?php echo isset($commissionDataArray['tier2_percent_premium']) ? $commissionDataArray['tier2_percent_premium'] : ''?>">\
                            </div>\
                             <label class="col-md-2 control-label">% of Premium Per Year</label>\
                            <div class="col-md-2">\
                                <input class="form-control" type="number" name="tier2_percent_premium" value="<?php echo isset($commissionDataArray['tier2_percent_premium']) ? $commissionDataArray['tier2_percent_premium'] : ''?>">\
                            </div>\
                        </div>\
                          <div class="form-group row">\
                            <label class="col-md-2 control-label">Tier-3 Number of Years</label>\
                            <div class="col-md-2">\
                                <input class="form-control" type="number" name="tier3_number_years" value="<?php echo isset($commissionDataArray['tier3_percent_premium']) ? $commissionDataArray['tier3_percent_premium'] : ''?>">\
                            </div>\
                            <label class="col-md-2 control-label">% of Premium Per Year</label>\
                            <div class="col-md-2">\
                                <input class="form-control" type="number" name="tier3_percent_premium" value="<?php echo isset($commissionDataArray['tier3_percent_premium']) ? $commissionDataArray['tier3_percent_premium'] : ''?>">\
                            </div>\
                        </div>\
                    </div>';
        }
        else if(structure == 'commissionablepremium')
        {
           var html = '<div id="commissionablepremium_div">\
                            <h4><?php echo 'Commissionale Premium:' ?></h4>\
                            <div class="form-group row">\
                                <label class="col-md-2 control-label">Premium:</label>\
                                <div class="col-md-2">\
                                    <input class="form-control" type="number" name="premium" required value="<?php echo isset($commissionDataArray['flat_renewal']) ? $commissionDataArray['flat_renewal'] : ''?>">\
                                </div>\
                                <div class="col-md-8">\
                                   <div class="checkbox checkbox-primary checkbox-inline">\
                                       <input id="monthly" type="checkbox" name="premium_duration" required value="monthly" class="commissionablepremiumtime" <?php echo isset($commissionDataArray['premium_duration']) && $commissionDataArray['premium_duration'] == 'monthly' ? 'checked="checked"':'' ?> <?php echo empty($commissionData) ? 'checked=""' :'' ?> />\
                                        <label for="monthly">\
                                            <?php echo 'Monthly' ?>\
                                        </label>\
                                   </div>\
                                   <div class="checkbox checkbox-primary checkbox-inline">\
                                    <input id="annual" type="checkbox" name="premium_duration" value="annual" class="commissionablepremiumtime" <?php echo isset($commissionDataArray['premium_duration']) && $commissionDataArray['premium_duration'] == 'annual' ? 'checked="checked"':'' ?>/>\
                                        <label for="annual">\
                                            <?php echo 'Annual' ?>\
                                        </label>\
                                   </div>\
                                </div>\
                            </div>\
                            <div class="form-group row">\
                                <label class="col-md-2 control-label">Commissionable Premium:</label>\
                                <div class="col-md-2">\
                                    <input class="form-control" type="number" name="commissionable_premium" value="<?php echo isset($commissionDataArray['commissionable_premium']) ? $commissionDataArray['commissionable_premium'] : '' ?>"/>\
                                </div>\
                            </div>\
                            <div class="form-group row">\
                                <label class="col-md-2 control-label">% of Premium:</label>\
                                <div class="col-md-2">\
                                    <input class="form-control" type="number" name="percent_premium" value="<?php echo isset($commissionDataArray['percent_premium']) ? $commissionDataArray['percent_premium'] : '' ?>"/>\
                                </div>\
                            </div>\
                        </div>';
        }
        else
        {
            var html = '<div id="calendarpremium_div" style="display:none">\
                            <h4><?php echo 'Prorated Calender (Medicare Advantage) Commission Structure' ?></h4>\
                            <div class="form-group row">\
                                <label class="col-md-2 control-label">Commission:</label>\
                                <div class="col-md-2">\
                                    <input class="form-control" type="number" required name="calendarpremium_commission" value="<?php echo isset($commissionDataArray['calendarpremium_commission']) ? $commissionDataArray['calendarpremium_commission'] : ''?>"/>\
                                </div>\
                            </div>\
                            <div class="form-group row">\
                                <label class="col-md-2 control-label">Renewal:</label>\
                                <div class="col-md-2">\
                                    <input class="form-control" type="number" required name="calendarpremium_renewal" value="<?php echo isset($commissionDataArray['calendarpremium_renewal']) ? $commissionDataArray['calendarpremium_renewal'] : ''?>"/>\
                                </div>\
                            </div>\
                        </div>';
        }
       $("#flatfree_div").html(html);
    }

  jQuery(document).on('change', '#catrgory', function(){
        var value = $(this).val();
         jQuery.ajax({
              type: "POST",
                url: "<?php base_url() ?>get_product_type",
                data: {category_id : value},
                dataType: 'json',
                success: function (data) {
                    var product_options = '';
                    product_options += "<option value=''>Select Product Type</option>";
                    for(i=0;i<data.length;i++)
                    {
                        product_options += "<option value="+data[i].product_type_name+" <?php echo isset($product['product_type']) && $product['product_type'] != '' ? 'selected' : ''?>>"+data[i].product_type_name+"</option>";
                    }
                    $('select[name="product_type"]').empty();
                    $('select[name="product_type"]').append( product_options );
                },
        });    
    });

}(window.jQuery);
</script>