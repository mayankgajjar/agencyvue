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
                <h4 class="page-title">Vender</h4>
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() . 'admin/dashboard' ?>">Dashboard</a></li>
                    <li><a href="<?= base_url() . 'admin/vendors' ?>">Venders</a></li>
                    <li class="active"><?php echo (isset($vendor_info[0]['vendor_name'])) ? $vendor_info[0]['vendor_name'] : ''; ?></li>
                </ol>
            </div>
        </div>

        <div class="row">
            
                <div class="col-lg-12 col-md-12 card-box all_details_broker_profile_admin">

                    <div class="card-box">

                        <div class="text-center"><h3 class="section-heading-custom"><span>VENDOR DETAILS</span></h3></div>

                                <div class="form-group clearfix form_inline">
                                    <input type="hidden" name="vendor_id" value="<?php echo (isset($vendor_id)) ? $vendor_id : ''; ?>"
                                    <div class="col-lg-12">
                                        <div class="col-lg-4">
                                            <label for="fname">Vendor Name : </label>
                                            <p class="user-profile-view"><?php echo (isset($vendor_info[0]['vendor_name'])) ? $vendor_info[0]['vendor_name'] : ''; ?></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="fname">Website : </label>
                                            <p class="user-profile-view"><?php echo (isset($vendor_info[0]['vendor_website'])) ? $vendor_info[0]['vendor_website'] : ''; ?></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="fname">Email Address : </label>
                                            <p class="user-profile-view"><?php echo (isset($vendor_info[0]['vendor_email_address'])) ? $vendor_info[0]['vendor_email_address'] : ''; ?></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group clearfix form_inline">
                                    <div class="col-lg-12">
                                        <div class="col-lg-4">
                                            <label for="fname">Customer Service Number : </label>
                                            <p class="user-profile-view"><?php echo (isset($vendor_info[0]['vendor_customer_service_number'])) ? $vendor_info[0]['vendor_customer_service_number'] : ''; ?></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="mname">Fax Number : </label>
                                            <p class="user-profile-view"><?php echo (isset($vendor_info[0]['vendor_fax_number'])) ? $vendor_info[0]['vendor_fax_number'] : ''; ?></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group clearfix form_inline">
                                    <div class="col-lg-12">
                                        <div class="col-lg-8">
                                            <label for="fname">Address : </label>
                                            <p class="user-profile-view"><?php echo (isset($vendor_info[0]['vendor_address'])) ? $vendor_info[0]['vendor_address'] : ''; ?></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="fname">Unit, Suite, Etc. : </label>
                                            <p class="user-profile-view"><?php echo (isset($vendor_info[0]['vendor_sub_address'])) ? $vendor_info[0]['vendor_sub_address'] : ''; ?></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group clearfix form_inline">
                                    <div class="col-lg-12">
                                        <div class="col-lg-4">
                                            <label for="mname">State : </label>
                                            <p class="user-profile-view"><?php echo (isset($vendor_info[0]['vendor_state'])) ? $vendor_info[0]['vendor_state'] : ''; ?></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="fname">City : </label>
                                            <p class="user-profile-view"><?php echo (isset($vendor_info[0]['vendor_city'])) ? $vendor_info[0]['vendor_city'] : ''; ?></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="fname">Zip Code : </label>
                                            <p class="user-profile-view"><?php echo (isset($vendor_info[0]['vendor_zip_code'])) ? $vendor_info[0]['vendor_zip_code'] : ''; ?></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group clearfix form_inline">
                                    <div class="col-lg-12">
                                        <div class="col-lg-4">
                                            <label for="mname">Upload Logo : </label>
                                            <p class="user-profile-view">
                                                <img src="<?php echo site_url().'/assets/crm_image/vendor/'.$vendor_info[0]['vendor_logo']; ?>">
                                                
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center"><h3 class="section-heading-custom"><span>DAILY CONTACT</span></h3></div>

                                <div class="form-group clearfix form_inline">
                                    <div class="col-lg-12">
                                        <div class="col-lg-4">
                                            <label for="fname">Contact Name : </label>
                                            <p class="user-profile-view"><?php echo (isset($vendor_info[0]['daily_contact_name'])) ? $vendor_info[0]['daily_contact_name'] : ''; ?></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="mname">Email Address : </label>
                                            <p class="user-profile-view"><?php echo (isset($vendor_info[0]['daily_contact_email_address'])) ? $vendor_info[0]['daily_contact_email_address'] : ''; ?></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="fname">Contact Number : </label>
                                            <p class="user-profile-view"><?php echo (isset($vendor_info[0]['daily_contact_contact_number'])) ? $vendor_info[0]['daily_contact_contact_number'] : ''; ?></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group clearfix form_inline">
                                    <div class="col-lg-12">
                                        <div class="col-lg-4">
                                            <label for="fname">Extension : </label>
                                            <p class="user-profile-view"><?php echo (isset($vendor_info[0]['daily_contact_extension'])) ? $vendor_info[0]['daily_contact_extension'] : ''; ?></p>
                                           
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center"><h3 class="section-heading-custom"><span>PAYMENT TERMS</span></h3></div>

                                <div class="form-group clearfix form_inline">
                                    <div class="col-lg-12">
                                        <div class="col-lg-4">
                                            <label for="fname">Invoice Due Date  : </label>
                                            <p class="user-profile-view"><?php echo (isset($vendor_info[0]['payment_Invoice_due_date'])) ? $vendor_info[0]['payment_Invoice_due_date'] : ''; ?></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="mname">Payment Method : </label>
                                            <p class="user-profile-view"><?php echo (isset($vendor_info[0]['payment_method'])) ? $vendor_info[0]['payment_method'] : ''; ?></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group clearfix form_inline">
                                    <div class="col-lg-12">
                                        <div class="col-lg-4">
                                            <label for="fname">Name On Account : </label>
                                            <p class="user-profile-view"><?php echo (isset($vendor_info[0]['payment_name_on_account'])) ? $vendor_info[0]['payment_name_on_account'] : ''; ?></p>
                                        </div>
                                         <div class="col-lg-4">
                                            <label for="fname">Bank Name : </label>
                                            <p class="user-profile-view"><?php echo (isset($vendor_info[0]['payment_bank_name'])) ? $vendor_info[0]['payment_bank_name'] : ''; ?></p>
                                        </div>
                                    </div>
                                </div>

                                  <div class="form-group clearfix form_inline">
                                    <div class="col-lg-12">
                                        <div class="col-lg-8">
                                            <label for="fname">Address  : </label>
                                            <p class="user-profile-view"><?php echo (isset($vendor_info[0]['payment_address'])) ? $vendor_info[0]['payment_address'] : ''; ?></p>
                                        </div>
                                         <div class="col-lg-4">
                                            <label for="fname">Unit, Suite, Etc : </label>
                                            <p class="user-profile-view"><?php echo (isset($vendor_info[0]['payment_sub_address'])) ? $vendor_info[0]['payment_sub_address'] : ''; ?></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group clearfix form_inline">
                                    <div class="col-lg-12">
                                        <div class="col-lg-4">
                                            <label for="fname">State  : </label>
                                            <p class="user-profile-view"><?php echo (isset($vendor_info[0]['payment_state'])) ? $vendor_info[0]['payment_state'] : ''; ?></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="mname">City : </label>
                                            <p class="user-profile-view"><?php echo (isset($vendor_info[0]['payment_city'])) ? $vendor_info[0]['payment_city'] : ''; ?></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="mname">Zip Code : </label>
                                            <p class="user-profile-view"><?php echo (isset($vendor_info[0]['payment_zip_code'])) ? $vendor_info[0]['payment_zip_code'] : ''; ?></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group clearfix form_inline">
                                    <div class="col-lg-12">
                                        <div class="col-lg-4">
                                            <label for="fname">Account  : </label>
                                            <p class="user-profile-view"><?php echo (isset($vendor_info[0]['payment_account'])) ? $vendor_info[0]['payment_account'] : ''; ?></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="mname">Routing Number : </label>
                                            <p class="user-profile-view"><?php echo (isset($vendor_info[0]['payment_routing_number'])) ? $vendor_info[0]['payment_routing_number'] : ''; ?></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="mname">Account Number  : </label>
                                            <p class="user-profile-view"><?php echo (isset($vendor_info[0]['payment_account_number'])) ? $vendor_info[0]['payment_account_number'] : ''; ?></p>
                                        </div>
                                    </div>
                                </div>

                                  <div class="form-group clearfix form_inline">
                                    <div class="col-lg-12">
                                        <div class="col-lg-8">
                                            <label for="fname">Upload Void Check  : </label>
                                            <a href="<?php echo site_url().'/assets/crm_image/vendor/'.$vendor_info[0]['payment_check']; ?>" target="_blank">
                                                <img src="<?php echo site_url().'/assets/crm_image/vendor/'.$vendor_info[0]['payment_check']; ?>"  height="100" width="180">
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div style="text-align: center">
                                         <a class="btn btn-success waves-effect waves-light" href="<?= base_url() . 'admin/vendors/edit_vendor/' . urlencode(base64_encode($vendor_info[0]["vendor_id"])) . '' ?>"> <span class="btn-label"><i class="fa fa-pencil"></i></span>Edit</a>     
                                        <a class="btn btn-default waves-effect waves-light" href="<?= base_url() . 'admin/vendors' ?>"> <span class="btn-label"><i class="fa fa-arrow-left"></i></span>Back</a>
                                    </div>
                                </div>

                                 
                        </form>    
                    </div>
                </div>
            </div>
    </div>
</div>
