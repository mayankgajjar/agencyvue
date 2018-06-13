 <script src="<?php echo base_url() ?>assets/plugins/jquery.steps/js/jquery.steps.min.js" type="text/javascript"></script>
 <script type="text/javascript" src="<?php echo base_url() ?>assets/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/autoNumeric/autoNumeric.js"></script> 
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
                                                        <option value="<?= $vendor['vendor_id']; ?>"><?= $vendor['vendor_name']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <label class="control-label col-md-12" for="catrgory">Product Category:&nbsp;*</label>
                                            <div class="col-md-4">
                                                <select class="form-control required" name="catrgory" id="catrgory">
                                                    <option value="">Select Coverage</option>
                                                    <option value="Member">Member</option>
                                                    <option value="Member_Spouse">Member + Spouse</option>
                                                    <option value="Member_Child">Member + Child</option>
                                                    <option value="Member_Children">Member + Children</option>
                                                    <option value="Family">Family</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group clearfix">
                                            <label class="control-label col-md-12" for="product_types">Product Type:&nbsp;*</label>
                                            <div class="col-md-4">
                                            <select class="form-control required" name="product_type" id="product_type">
                                                <option value="">Select Product Type</option>
                                                <option value="Dental">Dental</option>
                                                <option value="Vision">Vision</option>
                                                <option value="RX">RX</option>
                                                <option value="Life">Life</option>
                                                <option value="Health">Health</option>
                                                <option value="AD&amp;D">AD&amp;D</option>
                                                <option value="Long_Term_Care">Long Term Care</option>
                                                <option value="Limited_Medical">Limited Medical</option>
                                                <option value="Major_Medical">Major Medical</option>
                                                <option value="Medicare">Medicare</option>
                                            </select>
                                            </div>
                                        </div>

                                    </section>
                                    <h3>Product</h3>
                                    <section>
                                        <div class="col-md-6">
                                            <div class="form-group clearfix">
                                                <label class="control-label" for="name"> Product ID:&nbsp;<span class="span-label">If you leave this area blank, the system will auto-generate an ID for you.</span></label>
                                                <div class="">
                                                    <input id="product_id" name="product_id" type="text" class="form-control" />
                                                </div>
                                            </div>
                                            <div class="form-group clearfix">
                                                <label class="control-label " for="product_name"> Product Name:&nbsp;*</label>
                                                <div class="">
                                                    <input id="product_name" name="product_name" type="text" class="required form-control">
                                                </div>
                                            </div>

                                            <div class="form-group clearfix">
                                                <label class="control-label " for="email">Coverage Type:&nbsp;*</label>
                                                <div class="">
                                                    <select class="form-control required" name="coverage">
                                                        <option value="">Select Coverage</option>
                                                        <option value="Member">Member</option>
                                                        <option value="Member_Spouse">Member + Spouse</option>
                                                        <option value="Member_Child">Member + Child</option>
                                                        <option value="Member_Children">Member + Children</option>
                                                        <option value="Family">Family</option>
                                                    </select>                                                
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <img src="<?php echo base_url() ?>assets/images/users/avatar-2.jpg" alt="image" class="img-fluid img-thumbnail" width="90px" height="90px" id="product_image" name="product_image">
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
                                                    <label class="control-label col-md-12">No Sales States:</label>
                                                    <div class="col-md-6">
                                                        <select class="select2 select2-multiple" multiple="multiple" multiple data-placeholder="Choose state" name="product_state[]" id="product_state">
                                                            <?php foreach ($states as $state): ?>
                                                                <option value="<?= $state['state_code']; ?>"><?= $state['state']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>                                                 
                                                    </div>
                                                </div>
                                                <div class="form-group clearfix">
                                                    <label class="control-label col-sm-12"><?php echo "Age Restriction" ?>:</label>
                                                    <div class="col-sm-12">
                                                        <input style="display: inline-block; width: 20%" type="number" name="min_age" class="form-control" />&nbsp;
                                                        <span>To</span>
                                                        &nbsp;<input style="display: inline-block; width: 20%" type="number" name="max_age" class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="form-group clearfix">
                                                    <label class="control-label col-sm-12"><?php echo "Male Weight Restriction" ?>:</label>
                                                    <div class="col-sm-12">
                                                        <input style="display: inline-block; width: 20%" type="number" name="male_min_weight" class="form-control" />&nbsp;
                                                        <span>To</span>
                                                        &nbsp;<input style="display: inline-block; width: 20%" type="number" name="male_max_weight" class="form-control" />
                                                    </div>
                                                </div>                                                  
                                                <div class="form-group clearfix">
                                                    <label class="control-label col-sm-12"><?php echo "Female Weight Restriction" ?>:</label>
                                                    <div class="col-sm-12">
                                                        <input style="display: inline-block; width: 20%" type="number" name="female_min_weight" class="form-control" />&nbsp;
                                                        <span>To</span>
                                                        &nbsp;<input style="display: inline-block; width: 20%" type="number" name="female_max_weight" class="form-control" />
                                                    </div>
                                                </div>                                                
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group clearfix">
                                                <label class="control-label"><?php echo "Allow Pre-Existing Conditions?" ?>:</label>
                                                <div class="" style="display: inline-block;">
                                                    <div class="checkbox checkbox-primary checkbox-inline">
                                                        <input id="allow_conditions_yes" type="checkbox" class="allow_conditions allow_conditions_yes" value="yes" name="allow_conditions" checked="" />
                                                        <label for="allow_conditions_yes">
                                                            <?php echo "Yes" ?>
                                                        </label>
                                                    </div>
                                                    <div class="checkbox checkbox-primary checkbox-inline">
                                                        <input id="allow_conditions_no" type="checkbox" class="allow_conditions allow_conditions_no" value="no" checked="">
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
                                                        <input id="allow_tobacco_yes" type="checkbox" name="allow_tobacco" value="yes" class="allow_tobacco allow_tobacco_yes" />
                                                        <label for="allow_tobacco_yes">
                                                            <?php echo "Yes" ?>
                                                        </label>
                                                    </div>
                                                    <div class="checkbox checkbox-primary checkbox-inline">
                                                        <input id="allow_tobacco_no" type="checkbox" name="allow_tobacco" value="no" class="allow_tobacco allow_tobacco_no" checked="" />
                                                        <label for="allow_tobacco_no">
                                                            <?php echo "No" ?>
                                                        </label>
                                                    </div>                                                    
                                                </div>
                                            </div>                                                                                        
                                            <div class="form-group clearfix">
                                                <label class="control-label"><?php echo "Require License?" ?>:</label>
                                                <div class="" style="display: inline-block;">
                                                    <div class="checkbox checkbox-primary checkbox-inline">
                                                        <input id="license_yes" type="checkbox" name="license" class="license license_yes" value="yes" />
                                                        <label for="license_yes">
                                                            <?php echo 'Yes' ?>
                                                        </label>
                                                    </div>
                                                    <div class="checkbox checkbox-primary checkbox-inline">
                                                        <input id="license_no" type="checkbox" name="license" class="license license_no" value="no" checked="" />
                                                        <label for="license_no">
                                                            <?php echo 'No' ?>
                                                        </label>
                                                    </div>                                                    
                                                </div>
                                            </div>
                                            <div class="form-group clearfix">
                                                <label class="control-label"><?php echo "Require License:" ?>:</label>
                                                <div class="" style="display: inline-block;">
                                                    <div class="checkbox checkbox-primary checkbox-inline">
                                                        <input type="checkbox" name="license_type[]" id="license_health" value="health" />
                                                        <label for="license_health">
                                                            <?php echo 'Health' ?>
                                                        </label>
                                                    </div>
                                                    <div class="checkbox checkbox-primary checkbox-inline">
                                                        <input id="license_accident" type="checkbox" name="license_type[]" value="accident" />
                                                        <label for="license_accident">
                                                            <?php echo 'Accident' ?>
                                                        </label>
                                                    </div>
                                                    <div class="checkbox checkbox-primary checkbox-inline">
                                                        <input id="license_life" type="checkbox" name="license_type[]" value="life" />
                                                        <label for="license_life">
                                                            <?php echo 'Life' ?>
                                                        </label>
                                                    </div>
                                                    <div class="checkbox checkbox-primary checkbox-inline">
                                                        <input id="license_property" type="checkbox" name="license_type[]" value="propertyandcasualty" />
                                                        <label for="license_property">
                                                            <?php echo 'Property & Casualty' ?>
                                                        </label>
                                                    </div>                                                                                       
                                                </div>
                                            </div>                                                                               
                                            <div class="form-group clearfix">
                                                <label class="control-label"><?php echo "Require Appointment?" ?>:</label>
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
                                                     <input type="text" name="product_price" class="form-control required" placeholder="$ XXXX.XX" />                                                 
                                                </div>
                                            </div>
                                            <div class="form-group clearfix">
                                                <label class="control-label"><?php echo 'Enrollment Fee(s):' ?>&nbsp;*</label>
                                                <div class="">
                                                     <input data-role="tagsinput"  type="text" name="enrollment_fee" id="enrollment_fee" class="form-control required numbersOnly" />
                                                </div>
                                            </div>
                                            <div class="form-group clearfix">
                                                <label class="control-label"><?php echo 'Enrollment Billing Rule:' ?></label>
                                                <div class="">
                                                     <select class="form-control" name="enrollment_billing">
                                                         <option value=""><?php echo "Please Select" ?></option>
                                                         <option><?php echo "One Time"; ?></option>
                                                         <option><?php echo "Weekly"; ?></option>
                                                         <option><?php echo "Semi-Montly"; ?></option>
                                                         <option><?php echo "Montly"; ?></option>
                                                         <option><?php echo "Yearly"; ?></option>
                                                     </select>                                                 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label"><?php echo "Product Status" ?></label>
                                                <div class="">
                                                    <select name="product_status" id="product_status" class="form-control">
                                                        <option value="active"><?php echo 'Active' ?></option>
                                                        <option value="inactive"><?php echo 'Inactive' ?></option>
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
                                                         <option><?php echo "One Time"; ?></option>
                                                         <option><?php echo "Weekly"; ?></option>
                                                         <option><?php echo "Semi-Montly"; ?></option>
                                                         <option><?php echo "Montly"; ?></option>
                                                         <option><?php echo "Yearly"; ?></option>
                                                     </select>   
                                                </div>
                                            </div>
                                            <div class="form-group clearfix">
                                                <label class="control-label"><?php echo 'Next Billing Date Rule:' ?></label>
                                                <div class="">
                                                     <select class="form-control" name="next_billing_date_rule">
                                                         <option value=""><?php echo "Please Select" ?></option>
                                                         <option><?php echo "Same day each month" ?></option>
                                                         <option><?php echo "1st of every month" ?></option>
                                                         <option><?php echo "15th of every month" ?></option>
                                                     </select>   
                                                </div>
                                            </div>                                                                
                                            <div class="form-group clearfix">
                                                <label class="control-label"><?php echo 'Activation Date Rule:' ?></label>
                                                <div class="">
                                                    <select name="activation_rule" class="form-control">
                                                        <option value=""><?php echo 'Please Select' ?></option>
                                                        <option><?php echo 'Next Day' ?></option>
                                                        <option><?php echo '1st & 15th of the month' ?></option>
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
                                                  <input type="file" name="verification_script" class="filestyle" data-icon="false" data-buttonname="btn-default">
                                            </div>
                                        </div>
                                        <div class="col-sm-12" id="script-tag"  style="padding: 0 !important;"> 
                                            <div class="col-md-4">
                                                <div class="form-group clearfix">
                                                    <label class="control-label col-md-12"><?php echo 'Alternate Verification Script:' ?></label>
                                                    <div class="col-md-12" style="padding: 0px !important;">
                                                           <input type="file" name="alternate_script[]" class="filestyle" data-icon="false" data-buttonname="btn-default">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group clearfix">
                                                    <label class="control-label col-md-12"><?php echo 'State Rule:' ?></label>
                                                    <div class="col-md-12">
                                                        <select class="select2 select2-multiple" multiple="multiple" multiple data-placeholder="Choose state" name="script_state_rule[][]" id="product_state">
                                                            <?php foreach ($states as $state): ?>
                                                                <option value="<?= $state['state_code']; ?>"><?= $state['state']; ?></option>
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
                                                        <input id="status_active" type="checkbox" name="script_rule_status[][]" class="status status_active" value="active" checked="">
                                                            <label for="status_active">
                                                                <?php echo 'Active' ?>
                                                            </label>
                                                       </div>
                                                       <div class="checkbox checkbox-primary checkbox-inline">
                                                        <input id="status_inactive" type="checkbox" name="script_rule_status[][]" class="status status_inactive" value="inactive" />
                                                            <label for="status_inactive">
                                                                <?php echo 'Inactive' ?>
                                                            </label>
                                                       </div>
                                                    </div>                                                    
                                                </div>
                                            </div>
                                        </div>                              
                                        <div class="form-group clearfix col-md-4">
                                            <button type="button" onclick="javascript:addVerificationRule()" class="btn btn-default btn-md waves-effect waves-light">Add Script Rule</button>
                                        </div>
                                        <div class="rules">

                                        </div>                                                                    
                                    </section>
                                    <h3>Commission</h3>
                                    <section>
                                        <div class="col-md-4">
                                        <div class="form-group clearfix">
                                            <label class="control-label"><?php echo 'Commission are paid:' ?>:</label>
                                            <div class="">
                                                <div class="checkbox checkbox-primary">
                                                    <input id="commision_paid_1" type="checkbox" name="commission_paid" value="ontime" class="commision-paid" checked="">
                                                    <label for="commision_paid_1">
                                                        <?php echo 'On-Time' ?>
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="commision_paid_2" type="checkbox" name="commission_paid" value="weekly" class="commision-paid" />
                                                    <label for="commision_paid_2">
                                                        <?php echo 'Weekly' ?>
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="commision_paid_3" type="checkbox" class="commission_paid" value="bimonthly" name="commision_paid" />
                                                    <label for="commision_paid_3">
                                                        <?php echo 'Bi-Monthly' ?>
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="commision_paid_4" type="checkbox" class="commission_paid" value="montly" name="commision_paid" />
                                                    <label for="commision_paid_4">
                                                        <?php echo 'Monthly' ?>
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="commision_paid_5" type="checkbox" class="commission_paid" value="yearly" name="commision_paid" />
                                                    <label for="commision_paid_5">
                                                        <?php echo 'Yearly' ?>
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="commision_paid_6" type="checkbox" name="commision_paid" class="commision-paid" value="everydays" />
                                                    <label for="commision_paid_6">
                                                        <?php echo 'Every' ?>&nbsp;<input class="form-control" style="display: inline-block;width: 25%;" type="" name="everyday" />&nbsp;Days
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="commision_paid_7" type="checkbox" name="commision_paid" class="commision-paid" value="everymonth" />
                                                    <label for="commision_paid_7">
                                                        <?php echo 'Every' ?>&nbsp;<input class="form-control" style="display: inline-block;width: 25%;" type="" name="everymonth" />&nbsp;Months
                                                    </label>
                                                </div>                                                
                                            </div>
                                        </div>   
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group clearfix">
                                            <label class="control-label"><?php echo 'Renewals are paid:' ?>:</label>
                                            <div class="">
                                                <div class="checkbox checkbox-primary">
                                                    <input id="renewal_paid_1" type="checkbox" name="renewals_paid" class="renewal-paid" value="ontime" checked="" />
                                                    <label for="renewal_paid_1">
                                                        <?php echo 'On-Time' ?>
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="renewal_paid_2" type="checkbox" name="renewals_paid" class="renewal-paid" value="weekly"/>
                                                    <label for="renewal_paid_2">
                                                        <?php echo 'Weekly' ?>
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="renewal_paid_3" type="checkbox" name="renewals_paid" class="renewal-paid" value="bimonthly"/>
                                                    <label for="renewal_paid_3">
                                                        <?php echo 'Bi-Monthly' ?>
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="renewal_paid_4" type="checkbox" name="renewals_paid" class="renewal-paid" value="monthly"/>
                                                    <label for="renewal_paid_4">
                                                        <?php echo 'Monthly' ?>
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="renewal_paid_5" type="checkbox" name="renewals_paid" class="renewal-paid" value="yearly"/>
                                                    <label for="renewal_paid_5">
                                                        <?php echo 'Yerly' ?>
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="renewal_paid_6" type="checkbox" name="renewals_paid" class="renewal-paid" value="everydays"/>
                                                    <label for="renewal_paid_6">
                                                        <?php echo 'Every' ?>&nbsp;<input class="form-control" style="display: inline-block;width: 25%;" type="" name="renewal_every_days" />&nbsp;Days
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="renewal_paid_7" type="checkbox" name="renewals_paid" class="renewal-paid" value="everymonth"/>
                                                    <label for="renewal_paid_7">
                                                        <?php echo 'Every' ?>&nbsp;<input class="form-control" style="display: inline-block; width: 25%;" type="" name="renewal_every_month" />&nbsp;Months
                                                    </label>
                                                </div>                                                
                                            </div>                                                
                                            </div>
                                        </div>  
                                        <div class="col-md-4">
                                            <label class="control-label"><?php echo 'Commision Structure:' ?>:</label>
                                            <div class="">
                                                <div class="checkbox checkbox-primary">
                                                    <input id="structure_1" type="checkbox" name="commission_structure" class="commision-structure" value="flatfee" checked="" />
                                                    <label for="structure_1">
                                                        <?php echo 'Flat Fee' ?>
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="structure_2" type="checkbox" name="commission_structure" class="commision-structure" value="percentpremium" />
                                                    <label for="structure_2">
                                                        <?php echo 'Percent of Premium' ?>
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="structure_3" type="checkbox" name="commission_structure" class="commision-structure" value="tieryears" />
                                                    <label for="structure_3">
                                                        <?php echo 'Tier Years' ?>
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="structure_4" type="checkbox" name="commission_structure" class="commision-structure" value="commissionablepremium" />
                                                    <label for="structure_4">
                                                        <?php echo 'Commissionable Premiums' ?>
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="structure_5" type="checkbox" name="commission_structure" class="commision-structure" value="calendarpremium" />
                                                    <label for="structure_5">
                                                        <?php echo 'Prorated Calendar Premiums (Medicare Advantage)' ?>
                                                    </label>
                                                </div>
                                            </div>                                            
                                        </div>
                                        <div class="clearfix"></div>
                                        <h4><?php echo 'Commissionale Premium:' ?></h4>
                                        <div class="form-group row">
                                            <label class="col-md-2 control-label">Premium:</label>
                                            <div class="col-md-2">
                                                <input class="form-control" type="" name="premium">
                                            </div>
                                            <div class="col-md-8">
                                               <div class="checkbox checkbox-primary checkbox-inline">
                                                <input id="monthly" type="checkbox" name="premium_duration" value="monthly" class="commissionablepremiumtime" checked="" />
                                                    <label for="monthly">
                                                        <?php echo 'Monthly' ?>
                                                    </label>
                                               </div>                                                
                                               <div class="checkbox checkbox-primary checkbox-inline">
                                                <input id="annual" type="checkbox" name="premium_duration" value="annual" class="commissionablepremiumtime"/>
                                                    <label for="annual">
                                                        <?php echo 'Annual' ?>
                                                    </label>
                                               </div>                                               
                                            </div>                                            
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-2 control-label">Commissionable Premium:</label>
                                            <div class="col-md-2">
                                                <input class="form-control" type="text" name="commissionable_premium" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-2 control-label">% of Premium:</label>
                                            <div class="col-md-2">
                                                <input class="form-control" type="text" name="percent_premium" />
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
    var html = '<div class="col-sm-12" id="script-tag"  style="padding: 0 !important;"><div class="col-md-4"><div class="form-group clearfix"><label class="control-label col-md-12"><?php echo 'Alternate Verification Script:' ?></label><div class="col-md-12" style="padding: 0px !important;"><input type="file" name="alternate_script[]" id="alter_file_'+count+'" class="filestyle" data-icon="false" data-buttonname="btn-default"></div></div></div><div class="col-md-4"><div class="form-group clearfix"><label class="control-label col-md-12"><?php echo 'State Rule:' ?></label><div class="col-md-12"><select id="script_state_'+count+'" class="select2 select2-multiple" multiple="multiple" multiple data-placeholder="Choose state" name="script_state_rule[][]" id="product_state"><?php foreach ($states as $state): ?><option value="<?= $state['state_code']; ?>"><?= $state['state']; ?></option><?php endforeach; ?></select></div></div></div><div class="col-md-4"><div class="form-group clearfix"><label class="control-label col-md-12"><?php echo 'Status:' ?></label><div class="" style="display: inline-block;"><div class="checkbox checkbox-primary checkbox-inline"><input id="status_active_'+count+'" type="checkbox" name="script_rule_status[][]" class="status_'+count+' status_active" value="active" checked=""><label for="status_active_'+count+'"><?php echo 'Active' ?></label></div><div class="checkbox checkbox-primary checkbox-inline"><input id="status_inactive_'+count+'" type="checkbox" name="script_rule_status[][]" class="status_'+count+' status_inactive" value="inactive" /><label for="status_inactive_'+count+'"><?php echo 'Inactive' ?></label></div></div></div></div></div>';
    jQuery('.rules').append(html);
    jQuery('#script_state_'+count).select2();
    jQuery("#alter_file_"+count).filestyle();
    count++;
}
//initializing 
var _validFileExtensions = [".png",".jpg",".jpeg"];
function displayimage(oInput)
{
    console.log(oInput);
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
        $form_container.steps({
            headerTag: "h3",
            bodyTag: "section",
            transitionEffect: "fade",
            stepsOrientation: "vertical"
        });
        return $form_container;
    },
    FormWizard.prototype.init = function() {
        //initialzing various forms

        //basic form
        this.createBasic($("#basic-form"));

        //form with validation
        this.createValidatorForm($("#wizard-validation-form"));

        //vertical form
        this.createVertical($("#wizard-vertical"));
    },
    //init
    $.FormWizard = new FormWizard, $.FormWizard.Constructor = FormWizard
}(window.jQuery),
function($) {
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
    jQuery('#enrollment_fee').on('itemAdded', function (event) {
        var tag = event.item;
        tag = tag.replace(/[^0-9\.]/g, '');
        if (tag.length <= 0) {
            var removeAble = jQuery('.label-info').length;           
            jQuery('.label-info').eq((removeAble - 1)).remove();
            return false;
        }
    });    
}(window.jQuery);                    

        </script>