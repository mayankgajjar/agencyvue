<style type="text/css">
label.btn.btn-default.choose-file-btn {
    margin: 0 !important;
}
.date-picker-div {
    position: relative;
}
.date-picker-div span {
    height: 32px;
    position: absolute;
    right: 2px;
    top: 2px;
    width: 40px;
}
div#sing-up-page {
    padding-top: 80px !important;
}
 #employee_info.wrapper {
  padding-top: 65px !important;
}
</style>
<div id="employee_info" class="wrapper">

    <div class="container">

        <!-- Page-Title -->

        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Employer Information</h4>
                <ol class="breadcrumb"></ol>
            </div>
        </div>

        <!-- Basic Form Wizard -->
        <div class="row">
            <div class="col-lg-12">
                <div class="portlet">
                    <div class="portlet-heading bg-info">
                        <h3 class="portlet-title">
                            EMPLOYER DETAILS
                        </h3>
                        <div class="portlet-widgets">
                            <a data-toggle="collapse" data-parent="#accordion1" href="#bg-info1"><i class="ion-minus-round"></i></a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div id="bg-info1" class="panel-collapse collapse in">
                        <div class="portlet-body">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Employer Name : </label>
                                    <div class="col-md-3">
                                       <p><?php echo (isset($emp_info[0]['employer_name'])) ? $emp_info[0]['employer_name'] : ''; ?></p>
                                    </div>
                                    <label class="col-md-2 control-label">Website : </label>
                                    <div class="col-md-2">
                                        <p><?php echo (isset($emp_info[0]['employer_website'])) ? $emp_info[0]['employer_website'] : ''; ?></p>
                                    </div>
                                </div>
                            </div>
                             <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Email Address  : </label>
                                    <div class="col-md-3">
                                        <p><?php echo (isset($emp_info[0]['employer_email'])) ? $emp_info[0]['employer_email'] : ''; ?></p>
                                    </div>
                                    <label class="col-md-2 control-label">Customer Service Number : </label>
                                    <div class="col-md-2">
                                        <p><?php echo (isset($emp_info[0]['employer_cus_service_number'])) ? $emp_info[0]['employer_cus_service_number'] : ''; ?></p>
                                    </div>
                                    <label class="col-md-2 control-label">Fax Number : </label>
                                    <div class="col-md-1">
                                        <p><?php echo (isset($emp_info[0]['employer_fax'])) ? $emp_info[0]['employer_fax'] : ''; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Address   : </label>
                                    <div class="col-md-3">
                                        <p><?php echo (isset($emp_info[0]['employer_address'])) ? $emp_info[0]['employer_address'] : ''; ?></p>
                                    </div>
                                    <label class="col-md-2 control-label">Apartment, Suite, etc. : </label>
                                    <div class="col-md-2">
                                        <p><?php echo (isset($emp_info[0]['employer_address_details'])) ? $emp_info[0]['employer_address_details'] : ''; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">State : </label>
                                    <div class="col-md-3">
                                        <p>Gujarat</p>
                                    </div>
                                    <label class="col-md-2 control-label">City : </label>
                                    <div class="col-md-2">
                                        <p><?php echo (isset($emp_info[0]['employer_city'])) ? $emp_info[0]['employer_city'] : ''; ?></p>
                                    </div>
                                    <label class="col-md-2 control-label">Zip Code : </label>
                                    <div class="col-md-1">
                                        <p><?php echo (isset($emp_info[0]['employer_zipcode'])) ? $emp_info[0]['employer_zipcode'] : ''; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

             <div class="col-lg-12">
                <div class="portlet">
                    <div class="portlet-heading bg-info">
                        <h3 class="portlet-title">
                            DAILY CONTACT
                        </h3>
                        <div class="portlet-widgets">
                            <a data-toggle="collapse" data-parent="#accordion1" href="#bg-info2"><i class="ion-minus-round"></i></a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div id="bg-info2" class="panel-collapse collapse in">
                        <div class="portlet-body">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">First Name  : </label>
                                    <div class="col-md-3">
                                        <p><?php echo (isset($emp_info[0]['daily_contact_firstname'])) ? $emp_info[0]['daily_contact_firstname'] : ''; ?></p>
                                    </div>
                                    <label class="col-md-2 control-label">Last Name : </label>
                                    <div class="col-md-2">
                                        <p><?php echo (isset($emp_info[0]['daily_contact_lastname'])) ? $emp_info[0]['daily_contact_lastname'] : ''; ?></p>
                                    </div>
                                    <label class="col-md-2 control-label">Title : </label>
                                    <div class="col-md-1">
                                        <p><?php echo (isset($emp_info[0]['daily_contact_title'])) ? $emp_info[0]['daily_contact_title'] : ''; ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Email Address : </label>
                                    <div class="col-md-3">
                                        <p><?php echo (isset($emp_info[0]['daily_contact_email'])) ? $emp_info[0]['daily_contact_email'] : ''; ?></p>
                                    </div>
                                    <label class="col-md-2 control-label">Phone Number : </label>
                                    <div class="col-md-2">
                                        <p><?php echo (isset($emp_info[0]['daily_contact_contact_number'])) ? $emp_info[0]['daily_contact_contact_number'] : ''; ?></p>
                                    </div>
                                    <label class="col-md-2 control-label">Extension : </label>
                                    <div class="col-md-1">
                                        <p><?php echo (isset($emp_info[0]['daily_contact_extension'])) ? $emp_info[0]['daily_contact_extension'] : ''; ?></p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

             <div class="col-lg-12">
                <div class="portlet">
                    <div class="portlet-heading bg-info">
                        <h3 class="portlet-title">
                            BILLING CONTACT
                        </h3>
                        <div class="portlet-widgets">
                            <a data-toggle="collapse" data-parent="#accordion1" href="#bg-info3"><i class="ion-minus-round"></i></a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div id="bg-info3" class="panel-collapse collapse in">
                        <div class="portlet-body">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">First Name  : </label>
                                    <div class="col-md-3">
                                        <p><?php echo (isset($emp_info[0]['billing_contact_firstname'])) ? $emp_info[0]['billing_contact_firstname'] : ''; ?></p>
                                    </div>
                                    <label class="col-md-2 control-label">Last Name : </label>
                                    <div class="col-md-2">
                                        <p><?php echo (isset($emp_info[0]['billing_contact_lastname'])) ? $emp_info[0]['billing_contact_lastname'] : ''; ?></p>
                                    </div>
                                    <label class="col-md-2 control-label">Title : </label>
                                    <div class="col-md-1">
                                        <p><?php echo (isset($emp_info[0]['billing_contact_title'])) ? $emp_info[0]['billing_contact_title'] : ''; ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Email Address : </label>
                                    <div class="col-md-3">
                                        <p><?php echo (isset($emp_info[0]['billing_contact_email'])) ? $emp_info[0]['billing_contact_email'] : ''; ?></p>
                                    </div>
                                    <label class="col-md-2 control-label">Phone Number : </label>
                                    <div class="col-md-2">
                                        <p><?php echo (isset($emp_info[0]['billing_contact_contact_number'])) ? $emp_info[0]['billing_contact_contact_number'] : ''; ?></p>
                                    </div>
                                    <label class="col-md-2 control-label">Extension : </label>
                                    <div class="col-md-1">
                                        <p><?php echo (isset($emp_info[0]['billing_contact_extension'])) ? $emp_info[0]['billing_contact_extension'] : ''; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

             <div class="col-lg-12">
                <div class="portlet">
                    <div class="portlet-heading bg-info">
                        <h3 class="portlet-title">
                            TECHNICAL CONTACT
                        </h3>
                        <div class="portlet-widgets">
                            <a data-toggle="collapse" data-parent="#accordion1" href="#bg-info4"><i class="ion-minus-round"></i></a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div id="bg-info4" class="panel-collapse collapse in">
                        <div class="portlet-body">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">First Name  : </label>
                                    <div class="col-md-3">
                                        <p><?php echo (isset($emp_info[0]['technical_contact_firstname'])) ? $emp_info[0]['technical_contact_firstname'] : ''; ?></p>
                                    </div>
                                    <label class="col-md-2 control-label">Last Name : </label>
                                    <div class="col-md-2">
                                        <p><?php echo (isset($emp_info[0]['technical_contact_lastname'])) ? $emp_info[0]['technical_contact_lastname'] : ''; ?></p>
                                    </div>
                                    <label class="col-md-2 control-label">Title : </label>
                                    <div class="col-md-1">
                                        <p><?php echo (isset($emp_info[0]['technical_contact_title'])) ? $emp_info[0]['technical_contact_title'] : ''; ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-2 control-label">Email Address : </label>
                                    <div class="col-md-3">
                                        <p><?php echo (isset($emp_info[0]['technical_contact_email'])) ? $emp_info[0]['technical_contact_email'] : ''; ?></p>
                                    </div>
                                    <label class="col-md-2 control-label">Phone Number : </label>
                                    <div class="col-md-2">
                                        <p><?php echo (isset($emp_info[0]['technical_contact_contact_number'])) ? $emp_info[0]['technical_contact_contact_number'] : ''; ?></p>
                                    </div>
                                    <label class="col-md-2 control-label">Extension : </label>
                                    <div class="col-md-1">
                                        <p><?php echo (isset($emp_info[0]['technical_contact_extension'])) ? $emp_info[0]['technical_contact_extension'] : ''; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

             <div class="col-lg-12">
                <div class="portlet">
                    <div class="portlet-heading bg-info">
                        <h3 class="portlet-title">
                            FULFILLMENT
                        </h3>
                        <div class="portlet-widgets">
                            <a data-toggle="collapse" data-parent="#accordion1" href="#bg-info5"><i class="ion-minus-round"></i></a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div id="bg-info5" class="panel-collapse collapse in">
                        <div class="portlet-body">
                            <div class="col-lg-12">
                                <div class="col-md-12">
                                    <p><?php echo ($emp_info[0]['employer_fulfillment'] == 'hard_fulfillment') ? 'Hard Fulfillment ($5.00 per member)' : 'E-Fulfillment'; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="portlet">
                    <div class="portlet-heading bg-info">
                        <h3 class="portlet-title">
                           USER SETUP
                        </h3>
                        <div class="portlet-widgets">
                            <a data-toggle="collapse" data-parent="#accordion1" href="#bg-info6"><i class="ion-minus-round"></i></a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div id="bg-info6" class="panel-collapse collapse in">
                        <div class="portlet-body">
                              <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-6 control-label">Login Email Address : </label>
                                    <div class="col-md-6">
                                        <p><?php echo (isset($emp_info[0]['email'])) ? $emp_info[0]['email'] : ''; ?></p>
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

       