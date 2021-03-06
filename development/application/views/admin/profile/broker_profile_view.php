<div class="wrapper broker_profile_admin_wapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Profile</h4>
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() . 'admin/dashboard' ?>">Dashboard</a></li>
                    <li><a href="<?= base_url() . 'admin/brokers' ?>">Brokers</a></li>
                    <li class="active"><?= $broker['first_name'] . ' ' . $broker['last_name'] ?>'s Profile</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 col-lg-3">
                <div class="profile-detail card-box">
                    <div>
                        <img src="<?= base_url() ?>assets/crm_image/placeholder_agent.png" class="img-circle" alt="profile-image">
                        <div class="gap_creater" style="padding: 10px"></div>
                        <div class="text-left">
                            <p class="text-muted font-13"><strong>Created Date :</strong> <span class="m-l-15"><?= $broker['created_date']; ?></span></p>
                            <p class="text-muted font-13"><strong>Active Member :</strong><span class="m-l-15"> </span></p>
                            <p class="text-muted font-13"><strong>Retension Rate :</strong> <span class="m-l-15"> </span></p>
                        </div>  
                    </div>
                    <hr>
                    <div class="card-box card_box_custom">
                        <h4 class="m-t-0 m-b-20 header-title"> <i class="fa fa-shopping-cart"></i><b> Products</b></h4>
                        <div class="friend-list">
                            <ul>
                                <li>Product One</li>
                                <li>Product Beta</li>
                                <li>Product API</li>
                                <li>Product Two</li>
                            </ul>
                        </div>
                    </div>

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

            <div class="col-lg-9 col-md-8 card-box all_details_broker_profile_admin">
                <div class="row"> </div>
                <div class="col-lg-12">
                    <div class="text-center"><h3 class="section-heading-custom"><span>Personal Information</span></h3></div>
                    <div class="form-group clearfix form_inline">
                        <div class="col-lg-12">
                            <div class="col-lg-4">
                                <label for="fname">First Name : </label>
                                <p class="user-profile-view"><?= $broker['first_name'] ?></p>
                            </div>
                            <div class="col-lg-4">
                                <label for="mname">Middle Name : </label>
                                <p class="user-profile-view"><?= $broker['middle_name'] ?></p>
                            </div>
                            <div class="col-lg-4">
                                <label for="fname">Last Name : </label>
                                <p class="user-profile-view"><?= $broker['last_name'] ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group clearfix form_inline">
                        <div class="col-lg-12">
                            <div class="col-lg-4">
                                <label for="user_email">Email : </label>
                                <p class="user-profile-view"><?= $broker['personal_email_address'] ?></p>
                            </div>

                            <div class="col-lg-4">
                                <label for="user_phno">Phone Number : </label>
                                <p class="user-profile-view"><?= $broker['personal_phone_number'] ?></p>
                            </div>

                            <div class="col-lg-4">
                                <label for="user_dob">Date Of Birth : </label>
                                <p class="user-profile-view"><?= $broker['dob'] ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group clearfix form_inline">
                        <div class="col-lg-12">
                            <div class="col-lg-8">
                                <label for="user_add">Address : </label>
                                <p class="user-profile-view"><?= $broker['personal_address'] ?></p>
                            </div>

                            <div class="col-lg-4">
                                <label for="user_add_detail">Apartment,Suite,ect. : </label>
                                <p class="user-profile-view"><?= $broker['personal_address_addtional'] ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group clearfix form_inline">
                        <div class="col-lg-12">
                            <div class="col-lg-4">
                                <label for="user_state">State : </label>
                                <p class="user-profile-view"><?= $broker['personal_state'] ?></p>
                            </div>

                            <div class="col-lg-4">
                                <label for="user_city">City : </label>
                                <p class="user-profile-view"><?= $broker['personal_city'] ?></p>
                            </div>

                            <div class="col-lg-4">
                                <label for="user_zip">Zip Code : </label>
                                <p class="user-profile-view"><?= $broker['personal_zipcode'] ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center"><h3 class="section-heading-custom"><span>Business Information </span></h3></div>
                            <div class="form-group clearfix form_inline">
                                <div class="col-lg-12">
                                    <div class="col-lg-8">
                                        <label for="lb_name">Legal Business Name : </label>
                                        <p class="user-profile-view"><?= $broker['legal_bussiness_name'] ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group clearfix form_inline">
                                <div class="col-lg-12">
                                    <div class="col-lg-5">
                                        <label for="b_email">Business Email Address : </label>
                                        <p class="user-profile-view"><?= $broker['business_email_address'] ?></p>
                                    </div>

                                    <div class="col-lg-4">
                                        <label for="custom_service_name">Customer Service Number : </label>
                                        <p class="user-profile-view"><?= $broker['custom_service_name'] ?></p>
                                    </div>

                                    <div class="col-lg-3">
                                        <label for="fax_number">Fax Number : </label>
                                        <p class="user-profile-view"><?= $broker['business_fax_number'] ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group clearfix form_inline">
                                <div class="col-lg-12">
                                    <div class="col-lg-8">
                                        <label for="business_add">Address : </label>
                                        <p class="user-profile-view"><?= $broker['business_address'] ?></p>
                                    </div>

                                    <div class="col-lg-4">
                                        <label for="business_add_detail">Unit, Suite, Etc. : </label>
                                        <p class="user-profile-view"><?= $broker['business_add_addtional'] ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group clearfix form_inline">
                                <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <label for="business_state">State : </label>
                                        <p class="user-profile-view"><?= $broker['business_state'] ?></p>
                                    </div>

                                    <div class="col-lg-4">
                                        <label for="business_city">City : </label>
                                        <p class="user-profile-view"><?= $broker['business_city'] ?></p>
                                    </div>

                                    <div class="col-lg-4">
                                        <label for="business_zip">Zip Code : </label>
                                        <p class="user-profile-view"><?= $broker['business_zip_code'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row"> 
                        <div class="col-lg-12"> 
                            <div class="text-center"> <h3 class="section-heading-custom"> <span>Commissions Information</span></h3> </div>
                            <div class="form-group clearfix form_inline">
                                <div class="col-lg-12">
                                    <div class="col-lg-6">
                                        <label>Pay Commissions To : </label>
                                        <p class="user-profile-view">
                                            <?php echo ($broker['commision_payto'] == 'my_self') ? 'My Self' : 'My Business'; ?>
                                        </p>
                                    </div>
                                    <div class="col-lg-6">
                                        <?php if($broker['commision_payto'] == 'my_self') { ?>
                                            <label>Social Security Number : </label>
                                            <p class="user-profile-view"><?= $broker['social_security_number'] ?> </p>
                                        <?php } else { ?>
                                            <label>Federal Tax ID : </label>
                                            <p class="user-profile-view"><?= $broker['federal_tax_id'] ?> </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                           <div class="form-group clearfix form_inline">
                                <div class="col-lg-12">
                                    <div class="col-lg-6">
                                        <label for="commision_address">I would like to receive my money by : </label>
                                        <p class="user-profile-view"> <?php echo ($broker['commsion_receive'] == 'Paper_Check') ? 'Paper Check' : 'Direct Deposit'; ?></p>
                                    </div>    
                                </div>
                            </div>

                            <div class="form-group clearfix form_inline">
                                <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <label for="commision_address">Name on Account : </label>
                                        <p class="user-profile-view"><?= $broker['commision_name_on_account'] ?></p>
                                    </div>
                                    <div class="col-lg-4" id='com_bank_name' style="<?php echo ($broker['commsion_receive'] == 'Direct_Deposit') ? '' : 'display:none'; ?>">
                                        <label for="commision_address">Bank Name : </label>
                                        <p class="user-profile-view"> <?= $broker['commision_bank_name'] ?></p>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="commision_address">Address : </label>
                                        <p class="user-profile-view"><?= $broker['commision_address'] ?></p>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="commision_add_details">Unit, Suite, Etc. : </label>
                                        <p class="user-profile-view"> <?= $broker['commision_add_addtional'] ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group clearfix form_inline">
                                <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <label for="commision_state">State : </label>
                                        <p class="user-profile-view"><?= $broker['commision_state'] ?> </p>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="commision_city">City : </label>
                                        <p class="user-profile-view"><?= $broker['commision_city'] ?> </p>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="commision_zipcode">Zip Code : </label>
                                        <p class="user-profile-view"><?= $broker['commision_zipcode'] ?> </p>
                                    </div>
                                </div>
                            </div>

                            <div class="direct_deposit_wapp" style="<?php echo ($broker['commsion_receive'] == 'Direct_Deposit') ? '' : 'display:none'; ?>">
                                <div class="form-group clearfix form_inline">
                                    <div class="col-lg-12">
                                        <div class="col-lg-4">
                                            <label>Account Type : </label>
                                            <p class="user-profile-view"><?= $broker['account_options'] ?> </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group clearfix form_inline">
                                    <div class="col-lg-12">
                                        <div class="col-lg-8">
                                            <label for="rounting_number">Routing Number : </label>
                                            <p class="user-profile-view"><?= $broker['rounting_number'] ?> </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group clearfix form_inline">
                                    <div class="col-lg-12">
                                        <div class="col-lg-8">
                                            <label for="commision_address">Account Number : </label>
                                            <p class="user-profile-view"><?= $broker['account_number'] ?> </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>