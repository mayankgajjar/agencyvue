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
    .card-box{overflow: hidden;}
    .pull-left{float: none !important;}
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
        <div class="loader-select-city"><img class="loader-image" src="<?= base_url() . 'assets/crm_image/' ?>ring.gif"></div>
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">                
                <h4 class="page-title"> Members </h4>
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() . 'admin/dashboard' ?>">Dashboard</a></li>
                    <li><a href="<?= base_url() . 'admin/members' ?>">Members</a></li>
                   
                    <li class="active"><?php echo $member_info[0]['customer_first_name'].' '.$member_info[0]['customer_last_name'] ?></li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 col-lg-3">
                <div class="profile-detail card-box">
                    <div>
                        <img src="<?php echo base_url() ?>assets/images/users/avatar-2.jpg" class="img-circle" alt="profile-image">
                        <h4 class="text-uppercase font-600"><strong><?php echo $member_info[0]['customer_first_name'] . ' ' . $member_info[0]['customer_last_name'] ?>
                            </strong></h4>
                        <ul class="list-inline status-list m-t-20">
                            <div class="text-left">
                                <p class="text-muted font-13"><strong>Created Date : </strong> <span class="m-l-15">01/13/2017</span></p>
                                <p class="text-muted font-13"><strong>Activation Date :</strong><span class="m-l-15">01/13/2017</span></p>
                                <p class="text-muted font-13"><strong>Next Billing Date :</strong> <span class="m-l-15">01/13/2018</span></p>
                            </div>
                        </ul>
                        <hr>
<!--                        <h4 class="text-uppercase font-600"><strong>Product(s)
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
                        </ul>-->

<!--                        <hr>
                        <h4 class="text-uppercase font-600"><strong>Billing</strong></h4>
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
                        </ul>-->
<!--
                        <hr>
                        <h4 class="text-uppercase font-600"><strong>Dependents
                            </strong></h4>
                        <ul class="list-inline status-list m-t-20">

                            <div class="text-left">
                                <p class="text-muted font-13"><strong>Spouse : </strong> <span class="m-l-15"></span></p>

                                <p class="text-muted font-13"><strong>Children : 
                                    </strong><span class="m-l-15"></span></p>

                            </div>
                        </ul>-->
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
                <div class="card-box frm_lead_edit_new">
                    <form id="frm_lead_edit" method="post" class="navbar-left app-search pull-left">
                        <div class="text-center">
                            <h3><strong><h3 class="section-heading-custom"><span>PRIMARY</span></h3></strong></h3>
                        </div>   
                            <div class="form-group clearfix form_inline">
                            <input type="hidden" name="customer_id" value="<?php echo (isset($customer_id)) ? $customer_id : ''; ?>"
                                   <div class="col-lg-12">
                                <div class="col-lg-4 input_wrapper">
                                    <label for="fname">First Name : </label>
                                    <p class="member-profile-view"><?php echo (isset($member_info[0]['customer_first_name'])) ? $member_info[0]['customer_first_name'] : ''; ?></p>
                                </div>
                                <div class="col-lg-4 input_wrapper">
                                    <label for="mname">Middle Name : </label>
                                    <p class="member-profile-view"><?php echo (isset($member_info[0]['customer_middle_name'])) ? $member_info[0]['customer_middle_name'] : ''; ?></p>
                                </div>
                                <div class="col-lg-4 input_wrapper">
                                    <label for="fname">Last Name : </label>
                                  <p class="member-profile-view"><?php echo (isset($member_info[0]['customer_last_name'])) ? $member_info[0]['customer_last_name'] : ''; ?></p>
                                </div>
                            </div>
                            

                            <div class="form-group clearfix form_inline">
                                <div class="col-lg-4 input_wrapper">
                                    <label for="fname">Email Address : </label>
                                    <p class="member-profile-view"><?php echo (isset($member_info[0]['customer_email'])) ? $member_info[0]['customer_email'] : ''; ?></p>
                                </div>
                                <div class="col-lg-4 input_wrapper">
                                    <label for="mname">Phone Number : </label>
                                    <p class="member-profile-view"><?php echo (isset($member_info[0]['customer_phone_number'])) ? $member_info[0]['customer_phone_number'] : ''; ?></p>
                                </div>
                                <div class="col-lg-4 input_wrapper">
                                    <label for="fname">Date Of Birth : </label>
                                    <div class="date-picker-div">
                                        <p class="member-profile-view"><?php echo (isset($member_info[0]['customer_dob']) && !empty($member_info[0]['customer_dob'])) ? date('m/d/Y', strtotime($member_info[0]['customer_dob'])) : ''; ?></p>
                                      
                                    </div>
                                </div>
                            </div>

                            <div class="form-group clearfix form_inline">
                               
                                    <div class="col-lg-8">
                                        <label for="fname">Address : </label>
                                        <p class="member-profile-view"> <?php echo (isset($member_info[0]['customer_address'])) ? $member_info[0]['customer_address'] : ''; ?></p>
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Apartment, Suite, etc. : </label>
                                        <p class="member-profile-view"> <?php echo (isset($member_info[0]['customer_address_details'])) ? $member_info[0]['customer_address_details'] : ''; ?></p>
                                    </div>
                                
                            </div>

                            <div class="form-group clearfix form_inline">
                                
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="mname">State : </label>
                                        <p class="member-profile-view"><?php echo (isset($member_info[0]['customer_state'])) ? $member_info[0]['customer_state'] : ''; ?></p>
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">City : </label>
                                       <p class="member-profile-view"><?php echo (isset($member_info[0]['customer_city'])) ? $member_info[0]['customer_city'] : ''; ?></p>
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Zip Code : </label>
                                        <p class="member-profile-view"><?php echo (isset($member_info[0]['customer_zipcode'])) ? $member_info[0]['customer_zipcode'] : ''; ?></p>
                                    </div>
                                
                            </div>

                            <div class="form-group clearfix form_inline">
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Social Security Number : </label>
                                        <p class="member-profile-view"><?php echo (isset($member_info[0]['customer_social_security_number'])) ? $member_info[0]['customer_social_security_number'] : ''; ?></p>
                                    </div>
                            </div>
                            <!--</div>-->
                            <div class="text-center">
                                <h3><strong><h3 class="section-heading-custom"><span>SPOUSE</span></h3></strong></h3>
                            </div>

                            <div class="form-group clearfix form_inline">
                                
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">First Name : </label>
                                        <p class="member-profile-view"> <?php echo (isset($member_info[0]['customer_spouse_first_name'])) ? $member_info[0]['customer_spouse_first_name'] : ''; ?></p>
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="mname">Middle Name : </label>
                                        <p class="member-profile-view"><?php echo (isset($member_info[0]['customer_spouse_middle_name'])) ? $member_info[0]['customer_spouse_middle_name'] : ''; ?></p>
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Last Name : </label>
                                        <p class="member-profile-view"> <?php echo (isset($member_info[0]['customer_spouse_last_name'])) ? $member_info[0]['customer_spouse_last_name'] : ''; ?></p>
                                    </div>
                            </div>

                            <div class="form-group clearfix form_inline">
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Email Address : </label>
                                        <p class="member-profile-view"><?php echo (isset($member_info[0]['customer_spouse_email'])) ? $member_info[0]['customer_spouse_email'] : ''; ?></p>
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="mname">Phone Number : </label>
                                        <p class="member-profile-view"><?php echo (isset($member_info[0]['customer_spouse_phone_number'])) ? $member_info[0]['customer_spouse_phone_number'] : ''; ?></p>
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Date Of Birth : </label>
                                        <div class="date-picker-div">
                                            <p class="member-profile-view"><?php echo (isset($member_info[0]['customer_spouse_dob']) && !empty($member_info[0]['customer_spouse_dob'])) ? date('m/d/Y', strtotime($member_info[0]['customer_spouse_dob'])) : ''; ?></p>
                                           
                                        </div>
                                    </div>
                            </div>

                            <div class="form-group clearfix form_inline">
                               
                                    <div class="col-lg-8">
                                        <label for="fname">Address : </label>
                                        <p class="member-profile-view"><?php echo (isset($member_info[0]['customer_spouse_address'])) ? $member_info[0]['customer_spouse_address'] : ''; ?></p>
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Apartment, Suite, etc. : </label>
                                        <p class="member-profile-view"> <?php echo (isset($member_info[0]['customer_spouse_address_details'])) ? $member_info[0]['customer_spouse_address_details'] : ''; ?></p>
                                    </div>
                               
                            </div>

                            <div class="form-group clearfix form_inline">
                               
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="mname">State : </label>
                                       <p class="member-profile-view"> <?php echo (isset($member_info[0]['customer_spouse_state'])) ? $member_info[0]['customer_spouse_state'] : ''; ?></p>
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">City : </label>
                                       <p class="member-profile-view"> <?php echo (isset($member_info[0]['customer_spouse_city'])) ? $member_info[0]['customer_spouse_city'] : ''; ?></p>
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Zip Code : </label>
                                        <p class="member-profile-view"> <?php echo (isset($member_info[0]['customer_spouse_zipcode'])) ? $member_info[0]['customer_spouse_zipcode'] : ''; ?></p>
                                    </div>
                                
                            </div>
                            <div class="form-group clearfix form_inline">
                                <div class="col-lg-4 input_wrapper">
                                    <label for="fname">Social Security Number : </label>
                                    <p class="member-profile-view"> <?php echo (isset($member_info[0]['customer_spouse_social_security_number'])) ? $member_info[0]['customer_spouse_social_security_number'] : ''; ?></p>
                                </div>
                            </div>
                           
                            
                            <div class="form-group bottom-control text-center">
                                <a class="btn btn-success waves-effect waves-light" href="<?= base_url() . 'admin/members/edit_member/' . urlencode(base64_encode($customer_id)) ?>"> <span class="btn-label"><i class="fa fa-pencil"></i></span>Edit</a>     
                                <a class="btn btn-default waves-effect waves-light" href="<?= base_url() . 'admin/members' ?>"> <span class="btn-label"><i class="fa fa-arrow-left"></i>
                                        </span>Back</a>
                            </div>
                    </form>    
                </div>
            </div>
        </div>
    </div>
</div>

    