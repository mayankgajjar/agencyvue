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
                <h4 class="page-title">Employers</h4>
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() . 'admin/dashboard' ?>">Dashboard</a></li>
                    <li><a href="<?= base_url() . 'admin/employers' ?>">Employers</a></li>
                    <li class="active"><?php echo $emp_info[0]['employer_name']; ?></li>
                </ol>
            </div>
        </div>

        <div class="row">
                <div class="col-md-4 col-lg-3">
                    <div class="profile-detail card-box">
                        <div>
                            <img src="<?php echo base_url() ?>assets/images/users/avatar-2.jpg" class="img-circle" alt="profile-image">
                            <h4 class="text-uppercase font-600"><strong><?php echo (isset($emp_info[0]['employer_name'])) ? $emp_info[0]['employer_name'] : ''; ?>
                                </strong></h4>
                            <ul class="list-inline status-list m-t-20">
                                <div class="text-left">
                                    <p class="text-muted font-13"><strong>Created Date : </strong> <span class="m-l-15">01/13/2017</span></p>
                                    <p class="text-muted font-13"><strong>Active Members :</strong><span class="m-l-15"></span></p>
                                    <p class="text-muted font-13"><strong>Total Employes :</strong> <span class="m-l-15"></span></p>
                                </div>
                            </ul>

                            <hr>
                            <h4 class="text-uppercase font-600"><strong>Products(s)
                                </strong></h4>
                            <ul class="list-inline status-list m-t-20">

                            
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

                <div class="col-lg-9 col-md-8 card-box all_details_broker_profile_admin">

                    <div class="card-box">

                        <div class="text-center"><h3 class="section-heading-custom"><span>EMPLOYER DETAILS</span></h3></div>
                             <input type="hidden" name="user_id" value="<?php echo (isset($user_id)) ? $user_id : ''; ?>"
                                <div class="form-group clearfix form_inline">
                                    <div class="col-lg-12">
                                        <div class="col-lg-6">
                                            <label for="fname">Employer Name : </label>
                                            <p class="user-profile-view"><?php echo (isset($emp_info[0]['employer_name'])) ? $emp_info[0]['employer_name'] : ''; ?></p>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="fname">Website : </label>
                                            <p class="user-profile-view"><?php echo (isset($emp_info[0]['employer_website'])) ? $emp_info[0]['employer_website'] : ''; ?></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group clearfix form_inline">
                                    <div class="col-lg-12">
                                        <div class="col-lg-4">
                                            <label for="fname">Email Address : </label>
                                            <p class="user-profile-view"><?php echo (isset($emp_info[0]['employer_email'])) ? $emp_info[0]['employer_email'] : ''; ?></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="mname">Customer Service Number : </label>
                                            <p class="user-profile-view"><?php echo (isset($emp_info[0]['employer_cus_service_number'])) ? $emp_info[0]['employer_cus_service_number'] : ''; ?></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="fname">Fax Number : </label>
                                            <p class="user-profile-view"><?php echo (isset($emp_info[0]['employer_fax'])) ? $emp_info[0]['employer_fax'] : ''; ?></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group clearfix form_inline">
                                    <div class="col-lg-12">
                                        <div class="col-lg-8">
                                            <label for="fname">Address : </label>
                                            <p class="user-profile-view"><?php echo (isset($emp_info[0]['employer_address'])) ? $emp_info[0]['employer_address'] : ''; ?></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="fname">Apartment, Suite, etc : </label>
                                            <p class="user-profile-view"><?php echo (isset($emp_info[0]['employer_address_details'])) ? $emp_info[0]['employer_address_details'] : ''; ?></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group clearfix form_inline">
                                    <div class="col-lg-12">
                                        <div class="col-lg-4">
                                            <label for="mname">State : </label>
                                            <p class="user-profile-view"><?php echo (isset($emp_info[0]['state'])) ? $emp_info[0]['state'] : ''; ?></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="fname">City : </label>
                                            <p class="user-profile-view"><?php echo (isset($emp_info[0]['employer_city'])) ? $emp_info[0]['employer_city'] : ''; ?></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="fname">Zip Code : </label>
                                            <p class="user-profile-view"><?php echo (isset($emp_info[0]['employer_zipcode'])) ? $emp_info[0]['employer_zipcode'] : ''; ?></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center"><h3 class="section-heading-custom"><span>DAILY CONTACT</span></h3></div>

                                <div class="form-group clearfix form_inline">
                                    <div class="col-lg-12">
                                        <div class="col-lg-4">
                                            <label for="fname">First Name : </label>
                                            <p class="user-profile-view"><?php echo (isset($emp_info[0]['daily_contact_firstname'])) ? $emp_info[0]['daily_contact_firstname'] : ''; ?></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="mname">Last Name : </label>
                                            <p class="user-profile-view"><?php echo (isset($emp_info[0]['daily_contact_lastname'])) ? $emp_info[0]['daily_contact_lastname'] : ''; ?></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="fname">Title : </label>
                                            <p class="user-profile-view"><?php echo (isset($emp_info[0]['daily_contact_title'])) ? $emp_info[0]['daily_contact_title'] : ''; ?></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group clearfix form_inline">
                                    <div class="col-lg-12">
                                        <div class="col-lg-4">
                                            <label for="fname">Email Address : </label>
                                            <p class="user-profile-view"><?php echo (isset($emp_info[0]['daily_contact_email'])) ? $emp_info[0]['daily_contact_email'] : ''; ?></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="mname">Phone Number : </label>
                                            <p class="user-profile-view"><?php echo (isset($emp_info[0]['daily_contact_contact_number'])) ? $emp_info[0]['daily_contact_contact_number'] : ''; ?></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="fname">Extension : </label>
                                            <p class="user-profile-view"><?php echo (isset($emp_info[0]['daily_contact_extension'])) ? $emp_info[0]['daily_contact_extension'] : ''; ?></p>
                                           
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center"><h3 class="section-heading-custom"><span>BILLING CONTACT</span></h3></div>

                                <div class="form-group clearfix form_inline">
                                    <div class="col-lg-12">
                                        <div class="col-lg-4">
                                            <label for="fname">First Name : </label>
                                            <p class="user-profile-view"><?php echo (isset($emp_info[0]['billing_contact_firstname'])) ? $emp_info[0]['billing_contact_firstname'] : ''; ?></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="mname">Last Name : </label>
                                            <p class="user-profile-view"><?php echo (isset($emp_info[0]['billing_contact_lastname'])) ? $emp_info[0]['billing_contact_lastname'] : ''; ?></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="fname">Title : </label>
                                            <p class="user-profile-view"><?php echo (isset($emp_info[0]['billing_contact_title'])) ? $emp_info[0]['billing_contact_title'] : ''; ?></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group clearfix form_inline">
                                    <div class="col-lg-12">
                                        <div class="col-lg-4">
                                            <label for="fname">Email Address : </label>
                                            <p class="user-profile-view"><?php echo (isset($emp_info[0]['billing_contact_email'])) ? $emp_info[0]['billing_contact_email'] : ''; ?></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="mname">Phone Number : </label>
                                            <p class="user-profile-view"><?php echo (isset($emp_info[0]['billing_contact_contact_no'])) ? $emp_info[0]['billing_contact_contact_no'] : ''; ?></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="fname">Extension : </label>
                                            <p class="user-profile-view"><?php echo (isset($emp_info[0]['billing_contact_extension'])) ? $emp_info[0]['billing_contact_extension'] : ''; ?></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center"><h3 class="section-heading-custom"><span>TECHNICAL CONTACT</span></h3></div>

                                <div class="form-group clearfix form_inline">
                                    <div class="col-lg-12">
                                        <div class="col-lg-4">
                                            <label for="fname">First Name : </label>
                                            <p class="user-profile-view"><?php echo (isset($emp_info[0]['technical_contact_firstname'])) ? $emp_info[0]['technical_contact_firstname'] : ''; ?></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="mname">Last Name : </label>
                                            <p class="user-profile-view"><?php echo (isset($emp_info[0]['technical_contact_lastname'])) ? $emp_info[0]['technical_contact_lastname'] : ''; ?></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="fname">Title : </label>
                                            <p class="user-profile-view"><?php echo (isset($emp_info[0]['technical_contact_title'])) ? $emp_info[0]['technical_contact_title'] : ''; ?></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group clearfix form_inline">
                                    <div class="col-lg-12">
                                        <div class="col-lg-4">
                                            <label for="fname">Email Address : </label>
                                            <p class="user-profile-view"><?php echo (isset($emp_info[0]['technical_contact_email'])) ? $emp_info[0]['technical_contact_email'] : ''; ?></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="mname">Phone Number : </label>
                                            <p class="user-profile-view"><?php echo (isset($emp_info[0]['technical_contact_contact_no'])) ? $emp_info[0]['technical_contact_contact_no'] : ''; ?></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="fname">Extension : </label>
                                            <p class="user-profile-view"><?php echo (isset($emp_info[0]['technical_contact_extension'])) ? $emp_info[0]['technical_contact_extension'] : ''; ?></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center"><h3 class="section-heading-custom"><span>FULFILLMENT</span></h3></div>

                                <div class="form-group clearfix form_inline">
                                        <div class="col-lg-12">
                                             <div class="col-lg-4">
                                                <label for="fname">Fulfillment Options : </label>
                                                <p class="user-profile-view"><?php echo (isset($emp_info[0]['technical_contact_extension']) == 'e_fulfillment') ? 'E-Fulfillment' : 'Hard Fulfillment ($5.00 per member)'; ?></p>
                                            </div>
                                        </div>
                                </div>
                             
                               
                                <div>&nbsp;</div>
                                

                                <div class="form-group">
                                    <div style="text-align: center">
                                         <a class="btn btn-success waves-effect waves-light" href="<?= base_url() . 'admin/employers/edit_employer/' . urlencode(base64_encode($emp_info[0]["user_id"])) . '' ?>"> <span class="btn-label"><i class="fa fa-pencil"></i></span>Edit</a>     
                                        <a class="btn btn-default waves-effect waves-light" href="<?= base_url() . 'admin/employers/manageEmployer' ?>"> <span class="btn-label"><i class="fa fa-arrow-left"></i>
                                                </span>Back</a>
                                    </div>
                                </div>

                                 
                        </form>    
                    </div>
                </div>
            </div>
    </div>
</div>



