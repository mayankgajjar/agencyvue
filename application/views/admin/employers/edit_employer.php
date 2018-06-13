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
    input.textInputError {border-color: red;}

</style>


<div class="wrapper">
    <div class="container">
                <?php if ($this->session->flashdata('success')) { ?>
                        <div class="content pt0">
                            <div class="alert alert-success">
                                <a class="close" data-dismiss="alert">×</a>
                                <strong><?= $this->session->flashdata('success') ?></strong>
                            </div>
                        </div>
                <?php $this->session->set_flashdata('success', false);
                } else if ($this->session->flashdata('error')) {
                        ?>
                        <div class="content pt0">
                            <div class="alert alert-danger">
                                <a class="close" data-dismiss="alert">×</a>
                                <strong><?= $this->session->flashdata('error') ?></strong>
                            </div>
                        </div>

                <?php $this->session->set_flashdata('error', false);
                } else if(validation_errors()) { ?>
                        <div class="content pt0">
                            <div class="alert alert-danger">
                                <a class="close" data-dismiss="alert">×</a>
                                <strong><?= validation_errors() ?></strong>
                            </div>
                        </div>
                <?php } ?>
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Employers</h4>
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() . 'agent/dashboard' ?>">Dashboard</a></li>
                    <li><a href="<?= base_url() . 'agent/employers' ?>">Employers</a></li>
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
                                    <p class="text-muted font-13"><strong>Domain Name :</strong> <span class="m-l-15"><?php echo $domain_name; ?></span></p>
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

                <div class="col-lg-9 col-md-8">
                    <div class="card-box">
                        <form id="frm_add_employer" method="post" action="" data-parsley-validate novalidate>
                            <div class="text-center">
                                <div>&nbsp;</div>
                                <h3><strong>EMPLOYER DETAILS</strong></h3>
                                <div>&nbsp;</div>
                            </div>   
                            <div class="primary_div">
                                <div class="form-group clearfix">
                                    <div class="col-lg-12">
                                        <div class="col-lg-6 input_wrapper">
                                            <label for="fname">Employer Name * </label>
                                            <input type="text" id="emp_name" name="emp_name" class="form-control <?php echo (form_error('emp_name') ? 'textInputError' : '') ?>" autocomplete="off" required value="<?php echo (isset($emp_info[0]['employer_name'])) ? $emp_info[0]['employer_name'] : ''; ?>">
                                        </div>
                                        <div class="col-lg-6 input_wrapper">
                                            <label for="fname">Website </label>
                                            <input type="text" id="emp_website" name="emp_website" class="form-control" autocomplete="off"  value="<?php echo (isset($emp_info[0]['employer_website'])) ? $emp_info[0]['employer_website'] : ''; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group clearfix">
                                    <div class="col-lg-12">
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="fname">Email Address * </label>
                                            <input type="email" id="emp_email" name="emp_email" class="form-control <?php echo (form_error('emp_email') ? 'textInputError' : '') ?>" autocomplete="off" required value="<?php echo (isset($emp_info[0]['employer_email'])) ? $emp_info[0]['employer_email'] : ''; ?>">
                                        </div>
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="mname">Customer Service Number * </label>
                                            <input type="text" id="emp_ser_no" name="emp_ser_no" class="form-control <?php echo (form_error('emp_ser_no') ? 'textInputError' : '') ?>" autocomplete="off" required value="<?php echo (isset($emp_info[0]['employer_cus_service_number'])) ? $emp_info[0]['employer_cus_service_number'] : ''; ?>">
                                        </div>
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="fname">Fax Number</label>
                                            <div class="date-picker-div">
                                              <input type="text" id="emp_fax_no" name="emp_fax_no" class="form-control" autocomplete="off"  value="<?php echo (isset($emp_info[0]['employer_fax'])) ? $emp_info[0]['employer_fax'] : ''; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group clearfix">
                                    <div class="col-lg-12">
                                        <div class="col-lg-8">
                                            <label for="fname">Address * </label>
                                            <input type="text" id="emp_address" name="emp_address" class="form-control <?php echo (form_error('emp_address') ? 'textInputError' : '') ?>" autocomplete="off" required value="<?php echo (isset($emp_info[0]['employer_address'])) ? $emp_info[0]['employer_address'] : ''; ?>">
                                        </div>
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="fname">Apartment, Suite, etc </label>
                                            <input type="text" id="emp_address_det" name="emp_address_det" class="form-control" autocomplete="off"  value="<?php echo (isset($emp_info[0]['employer_address_details'])) ? $emp_info[0]['employer_address_details'] : ''; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group clearfix">
                                    <div class="col-lg-12">
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="mname">State * </label>
                                            <select class="form-control required" id="emp_state" name="emp_state">
                                                <option value="0">Select State</option>

                                                <?php foreach ($state as $key => $value) { ?>  
                                                  <option value="<?php echo $value['state_code']; ?>" <?php echo ( $value['state_code'] == $emp_info[0]['employer_state']) ? 'selected' : ''; ?>><?php echo $value['state']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="fname">City * </label>
                                            <select class="form-control required selcity" id="emp_city" name="emp_city">

                                                <?php
                                                foreach ($city_pri as $key => $value) { ?>
                                                    <option value="<?php echo $value['city']; ?>" <?php echo ( $value['city'] == $emp_info[0]['employer_city']) ? 'selected' : ''; ?>><?php echo $value['city']; ?></option>
                                                <?php } ?>
                                                 
                                            </select>
                                        </div>
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="fname">Zip Code * </label>
                                            <input type="text" id="emp_zipcode" name="emp_zipcode" class="form-control <?php echo (form_error('emp_zipcode') ? 'textInputError' : '') ?>" autocomplete="off" required value="<?php echo (isset($emp_info[0]['employer_zipcode'])) ? $emp_info[0]['employer_zipcode'] : ''; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <div>&nbsp;</div>
                                    <h3><strong>DAILY CONTACT</strong></h3>
                                    <div>&nbsp;</div>
                                </div>

                                <div class="form-group clearfix">
                                    <div class="col-lg-12">
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="fname">First Name* </label>
                                            <input type="text" id="daily_contact_firstname" name="daily_contact_firstname" class="form-control <?php echo (form_error('daily_contact_firstname') ? 'textInputError' : '') ?>" autocomplete="off" required value="<?php echo (isset($emp_info[0]['daily_contact_firstname'])) ? $emp_info[0]['daily_contact_firstname'] : ''; ?>">
                                        </div>
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="mname">Last Name * </label>
                                            <input type="text" id="daily_contact_lastname" name="daily_contact_lastname" class="form-control <?php echo (form_error('daily_contact_lastname') ? 'textInputError' : '') ?>" autocomplete="off" required value="<?php echo (isset($emp_info[0]['daily_contact_lastname'])) ? $emp_info[0]['daily_contact_lastname'] : ''; ?>">
                                        </div>
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="fname">Title * </label>
                                            <div class="date-picker-div">
                                              <input type="text" id="daily_contact_title" name="daily_contact_title" class="form-control <?php echo (form_error('daily_contact_title') ? 'textInputError' : '') ?>" autocomplete="off" required value="<?php echo (isset($emp_info[0]['daily_contact_title'])) ? $emp_info[0]['daily_contact_title'] : ''; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group clearfix">
                                    <div class="col-lg-12">
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="fname">Email Address * </label>
                                            <input type="email" id="daily_contact_email" name="daily_contact_email" class="form-control <?php echo (form_error('daily_contact_email') ? 'textInputError' : '') ?>" autocomplete="off" required value="<?php echo (isset($emp_info[0]['daily_contact_email'])) ? $emp_info[0]['daily_contact_email'] : ''; ?>">
                                        </div>
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="mname">Phone Number * </label>
                                            <input type="text" id="daily_contact_contact_no" name="daily_contact_contact_no" class="form-control <?php echo (form_error('daily_contact_contact_no') ? 'textInputError' : '') ?>" autocomplete="off" required value="<?php echo (isset($emp_info[0]['daily_contact_contact_number'])) ? $emp_info[0]['daily_contact_contact_number'] : ''; ?>">
                                        </div>
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="fname">Extension </label>
                                            <div class="date-picker-div">
                                              <input type="text" id="daily_contact_extension" name="daily_contact_extension" class="form-control" autocomplete="off"  value="<?php echo (isset($emp_info[0]['daily_contact_extension'])) ? $emp_info[0]['daily_contact_extension'] : ''; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <div>&nbsp;</div>
                                    <h3><strong>BILLING CONTACT</strong></h3>
                                    <div>&nbsp;</div>
                                </div>

                                <div class="form-group clearfix">
                                    <div class="col-lg-12">
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="fname">First Name * </label>
                                            <input type="text" id="billing_contact_firstname" name="billing_contact_firstname" class="form-control <?php echo (form_error('billing_contact_firstname') ? 'textInputError' : '') ?>" autocomplete="off" required value="<?php echo (isset($emp_info[0]['billing_contact_firstname'])) ? $emp_info[0]['billing_contact_firstname'] : ''; ?>">
                                        </div>
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="mname">Last Name * </label>
                                            <input type="text" id="billing_contact_lastname" name="billing_contact_lastname" class="form-control <?php echo (form_error('billing_contact_lastname') ? 'textInputError' : '') ?>" autocomplete="off" required value="<?php echo (isset($emp_info[0]['billing_contact_lastname'])) ? $emp_info[0]['billing_contact_lastname'] : ''; ?>">
                                        </div>
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="fname">Title * </label>
                                            <div class="date-picker-div">
                                              <input type="text" id="billing_contact_title" name="billing_contact_title" class="form-control <?php echo (form_error('billing_contact_title') ? 'textInputError' : '') ?>" autocomplete="off" required value="<?php echo (isset($emp_info[0]['billing_contact_title'])) ? $emp_info[0]['billing_contact_title'] : ''; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group clearfix">
                                    <div class="col-lg-12">
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="fname">Email Address * </label>
                                            <input type="email" id="billing_contact_email" name="billing_contact_email" class="form-control <?php echo (form_error('billing_contact_email') ? 'textInputError' : '') ?>" autocomplete="off" required value="<?php echo (isset($emp_info[0]['billing_contact_email'])) ? $emp_info[0]['billing_contact_email'] : ''; ?>">
                                        </div>
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="mname">Phone Number * </label>
                                            <input type="text" id="billing_contact_contact_no" name="billing_contact_contact_no" class="form-control <?php echo (form_error('billing_contact_contact_no') ? 'textInputError' : '') ?>" autocomplete="off" required value="<?php echo (isset($emp_info[0]['billing_contact_contact_number'])) ? $emp_info[0]['billing_contact_contact_number'] : ''; ?>">
                                        </div>
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="fname">Extension  </label>
                                            <div class="date-picker-div">
                                              <input type="text" id="billing_contact_extension" name="billing_contact_extension" class="form-control" autocomplete="off"  value="<?php echo (isset($emp_info[0]['billing_contact_extension'])) ? $emp_info[0]['billing_contact_extension'] : ''; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <div>&nbsp;</div>
                                    <h3><strong>TECHNICAL CONTACT</strong></h3>
                                    <div>&nbsp;</div>
                                </div>

                                <div class="form-group clearfix">
                                    <div class="col-lg-12">
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="fname">First Name* </label>
                                            <input type="text" id="technical_contact_firstname" name="technical_contact_firstname" class="form-control <?php echo (form_error('technical_contact_firstname') ? 'textInputError' : '') ?>" autocomplete="off" required value="<?php echo (isset($emp_info[0]['technical_contact_firstname'])) ? $emp_info[0]['technical_contact_firstname'] : ''; ?>">
                                        </div>
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="mname">Last Name * </label>
                                            <input type="text" id="technical_contact_lastname" name="technical_contact_lastname" class="form-control <?php echo (form_error('technical_contact_lastname') ? 'textInputError' : '') ?>" autocomplete="off" required value="<?php echo (isset($emp_info[0]['technical_contact_lastname'])) ? $emp_info[0]['technical_contact_lastname'] : ''; ?>">
                                        </div>
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="fname">Title * </label>
                                            <div class="date-picker-div">
                                              <input type="text" id="technical_contact_title" name="technical_contact_title" class="form-control <?php echo (form_error('technical_contact_title') ? 'textInputError' : '') ?>" autocomplete="off" required value="<?php echo (isset($emp_info[0]['technical_contact_title'])) ? $emp_info[0]['technical_contact_title'] : ''; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group clearfix">
                                    <div class="col-lg-12">
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="fname">Email Address * </label>
                                            <input type="email" id="technical_contact_email" name="technical_contact_email" class="form-control <?php echo (form_error('technical_contact_email') ? 'textInputError' : '') ?>" autocomplete="off" required value="<?php echo (isset($emp_info[0]['technical_contact_email'])) ? $emp_info[0]['technical_contact_email'] : ''; ?>">
                                        </div>
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="mname">Phone Number * </label>
                                            <input type="text" id="technical_contact_contact_no" name="technical_contact_contact_no" class="form-control <?php echo (form_error('technical_contact_contact_no') ? 'textInputError' : '') ?>" autocomplete="off" required value="<?php echo (isset($emp_info[0]['technical_contact_contact_number'])) ? $emp_info[0]['technical_contact_contact_number'] : ''; ?>">
                                        </div>
                                        <div class="col-lg-4 input_wrapper">
                                            <label for="fname">Extension </label>
                                            <div class="date-picker-div">
                                              <input type="text" id="technical_contact_extension" name="technical_contact_extension" class="form-control" autocomplete="off"  value="<?php echo (isset($emp_info[0]['technical_contact_extension'])) ? $emp_info[0]['technical_contact_extension'] : ''; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <div>&nbsp;</div>
                                    <h3><strong>FULFILLMENT</strong></h3>
                                    <div>&nbsp;</div>
                                </div>

                                <div class="form-group clearfix">
                                    
                                        <div class="col-lg-12">
                                             <div class="col-lg-4">
                                            <h4>Fulfillment Options</h4>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="e_fulfillment" type="checkbox" name="fulfillment_type" class="fulfillment_type" value="e_fulfillment"  <?php echo ($emp_info[0]['employer_fulfillment'] == 'e_fulfillment') ? "checked" : ''; ?>>
                                                    <label>E-Fulfillment</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                             <div class="col-lg-4">
                                                <div class="checkbox checkbox-primary">
                                                    <input id="hard_fulfillment" type="checkbox" class="fulfillment_type" name="fulfillment_type" value="hard_fulfillment" <?php echo ($emp_info[0]['employer_fulfillment'] == 'hard_fulfillment') ? "checked" : '' ; ?>>
                                                    <label >Hard Fulfillment ($5.00 per member)</label>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                             
                                 <div class="form-group clearfix">

                                    <label class="col-lg-12 control-label ">
                                        <div class="col-lg-4">
                                            (*) Mandatory
                                        </div>
                                    </label>

                                </div>
                                <div>&nbsp;</div>
                                

                                <div class="form-group">
                                    <div style="text-align: center">
                                        <button type="submit" class="btn btn-success" name="save" value="save">Save</button>
                                        <a class="btn btn-default waves-effect waves-light" href="<?= base_url() . 'agent/employers' ?>"> <span class="btn-label"><i class="fa fa-arrow-left"></i>
                                                </span>Back</a>
                                    </div>
                                </div>

                                 
                        </form>    
                    </div>
                </div>
            </div>
    </div>
</div>


        


            
<script type="text/javascript">
$(document).on('click', '.fulfillment_type', function () {
    var fulfillment = $(this).val();
    if (fulfillment == "e_fulfillment") {
        $('#hard_fulfillment').prop('checked', false); // Unchecks it
    }
    if (fulfillment == "hard_fulfillment") {
        $('#e_fulfillment').prop('checked', false); // Unchecks it
    }
});
</script>


<script>
    $(document).ready(function () {
        $('form').parsley();
        $(function () {
            $("#emp_state").change(function () {
                $("#emp_city").empty();
                var state = $(this).val();
                $.ajax({
                    url: '<?php echo base_url() ?>/agent/employers/getcity',
                    type: 'POST',
                    data: {'ustid': state},
                    success: function (data) {
                        $('#emp_city').html(data);
                    },
                });
            });
        });
    }); 
</script>


   



