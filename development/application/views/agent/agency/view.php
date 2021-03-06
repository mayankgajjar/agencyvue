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

        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Leads</h4>
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() . 'agent/dashboard' ?>">Dashboard</a></li>
                    <li><a href="<?= base_url() . 'agent/agencies' ?>">Manage Agencies</a></li>
                    <li class="active">View <?= $details['agency_name']; ?></li>
                </ol>
            </div>
            <div class="row">
                <div class="col-md-4 col-lg-3">
                    <div class="profile-detail card-box">
                        <div>
                            <img src="<?php echo base_url() ?>assets/crm_image/agencieslogo/<?= $details['agency_image']; ?>" class="img-circle" alt="profile-image">
                            <h4 class="text-uppercase font-600"><strong><?php echo $details['agency_name']; ?>
                                </strong></h4>
                            <ul class="list-inline status-list m-t-20">
                                <div class="text-left">
                                    <p class="text-muted font-13"><strong>Created Date : </strong> <span class="m-l-15"><?= $details['created_date']; ?></span></p>
                                    <p class="text-muted font-13"><strong>Activation Date :</strong><span class="m-l-15"><?= $details['created_date']; ?></span></p>
                                </div>
                            </ul>
                            <hr>
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
                        <form id="frm_lead_edit" method="post" class="data-parsley-validate novalidate">
                            <div class="text-center">
                                <h3><strong><h3 class="section-heading-custom"><span>General Information </span></h3></strong></h3>
                            </div>
                            <div class="primary_div">
                                <div class="form-group clearfix">
                                    <input type="hidden" name="customer_id" value="<?php echo (isset($customer_id)) ? $customer_id : ''; ?>"
                                           <div class="col-lg-12">
                                        <div class="col-lg-6 input_wrapper">
                                            <label for="fname">Agency Name </label>
                                            <p class="lead-profile-view"><?php echo $details['agency_name']; ?></p>
                                        </div>
                                        <div class="col-lg-6 input_wrapper">
                                            <label for="fname">Contact Name </label>
                                            <p class="lead-profile-view"><?php echo $details['contact_name']; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="col-lg-6 input_wrapper">
                                        <label for="fname">Contact Email </label>
                                        <p class="lead-profile-view"><?php echo $details['agency_email']; ?></p>
                                    </div>
                                    <div class="col-lg-6 input_wrapper">
                                        <label for="mname">Phone Number </label>
                                        <p class="lead-profile-view"><?php echo $details['agency_phone']; ?></p>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="col-lg-6 input_wrapper">
                                        <label for="fname">Customer Service Email </label>
                                        <p class="lead-profile-view"><?php echo $details['agency_customer_service_email']; ?></p>
                                    </div>
                                    <div class="col-lg-6 input_wrapper">
                                        <label for="mname">Customer Service Number </label>
                                        <p class="lead-profile-view"><?php echo $details['agency_customer_service_number']; ?></p>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="col-lg-8">
                                        <label for="fname">Address * </label>
                                        <p class="lead-profile-view"><?php echo $details['agency_address']; ?></p>
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Apartment, Suite, etc.* </label>
                                        <p class="lead-profile-view"><?php echo (isset($details['agency_sub_address'])) ? $details['agency_sub_address'] : ''; ?></p>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="mname">State </label>
                                        <p class="lead-profile-view"> <?php echo get_state_name($details['agency_state']); ?> </p>
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">City </label>
                                        <p class="lead-profile-view"> <?php echo $details['agency_city']; ?> </p>
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Zip Code </label>
                                        <p class="lead-profile-view"><?php echo $details['agency_zip_code']; ?></p>
                                    </div>
                                </div>
                                <div class="text-center"><strong><h3 class="section-heading-custom"> Bank information </h3></strong></div>
                                <div class="form-group clearfix">
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <label for="angecy_bank_name">Bank Name  </label>
                                            <p class="lead-profile-view"> <?php echo $details['bank_name']; ?> </p>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="angecy_bank_add">Bank Address  </label>
                                            <p class="lead-profile-view"> <?php echo $details['bank_add']; ?> </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="col-lg-12">
                                        <div class="col-lg-4">
                                            <label for="bank_state">Bank State * </label>
                                            <p class="lead-profile-view"> <?php echo get_state_name($details['bank_state']); ?> </p>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="bank_city">Bank City * </label>
                                            <p class="lead-profile-view"> <?php echo $details['bank_city']; ?> </p>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="bank_zipcode">Zip Code * </label>
                                            <p class="lead-profile-view"> <?php echo $details['bank_zipcode']; ?> </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="col-lg-12">
                                        <div class="col-lg-4">
                                            <label for="name_on_account">Name on Account * </label>
                                            <p class="lead-profile-view"> <?php echo $details['agency_name_on_account']; ?></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="account_number">Account Number * </label>
                                            <p class="lead-profile-view"> <?php echo $details['agency_account_number']; ?></p>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="routing_number">Routing Number * </label>
                                            <p class="lead-profile-view"> <?php echo $details['angecy_routing_number']; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <h3><strong><h3 class="section-heading-custom"><span>Login & Domain Information </span></h3></strong></h3>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="fname">Login Email </label>
                                        <p class="lead-profile-view"><?php echo $details['email']; ?></p>
                                    </div>
                                    <div class="col-lg-4 input_wrapper">
                                        <label for="mname">Domain Name </label>
                                        <p class="lead-profile-view"><?php echo $details['agency_domain']; ?></p>
                                    </div>
                                </div>
                                <div class="form-group bottom-control text-center">
                                    <a class="btn btn-success waves-effect waves-light" href="<?= base_url() . 'agent/agencies/edit?user_id=' . urlencode(base64_encode($details["user_id"])) . '' ?>"> <span class="btn-label"><i class="fa fa-pencil"></i></span>Edit</a>
                                    <a class="btn btn-default waves-effect waves-light" href="<?= base_url() . 'agent/agencies' ?>"> <span class="btn-label"><i class="fa fa-arrow-left"></i>
                                        </span>Back</a>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>