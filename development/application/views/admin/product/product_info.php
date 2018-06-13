<style>
     .custom-product-details-box .sale-states {    margin: 30px 0px;
    background: #2b333b;
    padding: 30px;
    border-radius: 4px;}
.custom-product-details-box .sale-states label{    color: #fff;
    font-size: 18px;
    font-weight: 500;}
.custom-product-details-box .sale-states p.lead-profile-view{padding-left: 20px;}
.custom-product-details-box .product-detail-image{    background: #2b333b;
    padding: 15px;
    border-radius: 4px;}
    .custom-product-details-box .product-detail-image img{height: 100%;width:100%;}
    .custom-product-detail-content{    background: #2b333b;
    padding: 20px;
    border-radius: 4px;}
    .custom-product-detail-content label{color: #fff;
    font-size: 13px !important;
    font-weight: normal;}
    .custom-product-detail-content p.lead-profile-view {
    display: block;
    border-bottom: 2px solid rgba(255, 255, 255, 0.07);
    font-size: 14px;
    padding-bottom: 3px;
}
</style>
<div class="modal-dialog modal-lg custom-product-details-box">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="full-width-modalLabel">Product Details</h4>
        </div>
        <?php 
            $llist[] = array();
            $product_data = $product_info['product_data'];
            $product_a_w_h = $product_info['age_weight_height_data'];
            $product_license = $product_info['license_data'];
            if (isset($product_license) && !empty($product_license))
            {
                foreach ($product_license as $key => $lic) {
                    $llist[$key] = $lic['license_type'];
                }
                $license_list = implode(',', $llist);
            }
            $product_enrollment = $product_info['enrollment_data'];
            if (isset($product_enrollment) && !empty($product_enrollment))
            {
                foreach ($product_enrollment as $enroll) {
                    $elist[] = $enroll['enrollment_fee'];
                }
                $enrollment_list = implode(', ', $elist);
            }
            $product_vendor = $vendor_info['vendor_name'];
        ?>
        <div class="modal-body">
            <div class ="row">
                <div class="col-lg-12">
                    <div class="col-lg-4">
                        <?php if($product_data['product_image'] != ''){ ?>
                            <div class="col-lg-12 product-detail-image">
                                <a href="<?php echo site_url() . '/assets/crm_image/products/' . $product_data['product_image']; ?>" target="_blank">
                                    <img src="<?php echo site_url() . '/assets/crm_image/products/' . $product_data['product_image']; ?>"  height="100" width="250">
                                </a>
                            </div>
                        <?php } ?>
                        <div class="">
                            <div class="col-lg-12 input_wrapper sale-states">
                                <label for="fname">Sale States : </label>
                                <p class="lead-profile-view">
                                    <?php if(isset($state_data))
                                    {
                                        foreach ($state_data as $ps) {
                                            echo $ps.'<br>';
                                        } 
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 custom-product-detail-content">
                        <div class="form-group clearfix form_inline">
                            <div class="col-lg-12">
                                <div class="col-lg-6 input_wrapper">
                                    <label for="fname">Product Id : </label>
                                    <p class="lead-profile-view"><?php echo (isset($product_data['product_id'])) ? $product_data['product_id'] : 'No Data'; ?></p>
                                </div>
                                <div class="col-lg-6 input_wrapper">
                                    <label for="mname">Product Name : </label>
                                    <p class="lead-profile-view"><?php echo (isset($product_data['product_name'])) ? $product_data['product_name'] : 'No Data'; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group clearfix form_inline">
                            <div class="col-lg-12">
                                <div class="col-lg-6 input_wrapper">
                                    <label for="fname">Plan ID : </label>
                                    <p class="lead-profile-view"><?php echo (isset($product_data['plan_id'])) ? $product_data['plan_id'] : 'No Data'; ?></p>
                                </div>
                                 <div class="col-lg-6 input_wrapper">
                                    <label for="fname">Product Price / Monthly Premium : </label>
                                    <p class="lead-profile-view"><?php echo (isset($product_data['product_price'])) ? $product_data['product_price'] : 'No Data'; ?></p>
                                </div>
                            </div>
                        </div>
                       <div class="form-group clearfix form_inline">
                            <div class="col-lg-12">
                                <div class="col-lg-6 input_wrapper">
                                    <label for="fname">Product Type : </label>
                                    <p class="lead-profile-view"><?php echo (isset($product_data['product_type'])) ? $product_data['product_type'] : 'No Data'; ?></p>
                                </div>
                                <div class="col-lg-6 input_wrapper">
                                    <label for="mname">Coverage : </label>
                                    <p class="lead-profile-view"><?php echo (isset($product_data['product_coverage'])) ? $product_data['product_coverage'] : 'No Data'; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group clearfix form_inline">
                            <div class="col-lg-12">
                                <div class="col-lg-6 input_wrapper">
                                    <label for="fname">Network-Size : </label>
                                    <p class="lead-profile-view"><?php echo (isset($product_data['product_network_size'])) && $product_data['product_network_size'] != '' ? $product_data['product_network_size'] : 'No Data'; ?></p>
                                </div>
                                <div class="col-lg-6 input_wrapper">
                                    <label for="mname">Benefits-Type : </label>
                                    <p class="lead-profile-view"><?php echo (isset($product_data['product_benefits_type'])) && $product_data['product_benefits_type'] != '' ? $product_data['product_benefits_type'] : 'No Data'; ?></p>
                                </div>
                              </div>
                        </div>
                        <div class="form-group clearfix form_inline">
                            <div class="col-lg-12">
                                <div class="col-lg-6 input_wrapper">
                                    <label for="fname">Allow Pre-Existing Conditions : </label>
                                    <p class="lead-profile-view"><?php echo (isset($product_data['product_pre_existing'])) && $product_data['product_pre_existing'] != '' ? $product_data['product_pre_existing'] : 'No Data'; ?></p>
                                </div>
                                 <div class="col-lg-6 input_wrapper">
                                    <label for="fname">Product Status : </label>
                                    <p class="lead-profile-view"><?php echo (isset($product_data['product_status'])) && $product_data['product_status'] != '' ? $product_data['product_status'] : 'No Data'; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group clearfix form_inline">
                            <div class="col-lg-12">
                                <div class="col-lg-6 input_wrapper">
                                    <label for="fname">Minimum Age : </label>
                                    <p class="lead-profile-view"><?php echo (isset($product_a_w_h['min_age'])) ? $product_a_w_h['min_age'] : 'No Data'; ?></p>
                                </div>
                                <div class="col-lg-6 input_wrapper">
                                    <label for="mname">Maximum Age : </label>
                                    <p class="lead-profile-view"><?php echo (isset($product_a_w_h['max_age'])) ? $product_a_w_h['max_age'] : 'No Data'; ?></p>
                                </div>
                              </div>
                        </div>
                        <div class="form-group clearfix form_inline">
                            <div class="col-lg-12">
                                <div class="col-lg-6 input_wrapper">
                                    <label for="fname">Minimum Weight : </label>
                                    <p class="lead-profile-view"><?php echo (isset($product_a_w_h['min_weight'])) && $product_a_w_h['min_weight'] != '' ? $product_a_w_h['min_weight'] : 'No Data'; ?></p>
                                </div>
                                 <div class="col-lg-6 input_wrapper">
                                    <label for="fname">Maximum Weight : </label>
                                    <p class="lead-profile-view"><?php echo (isset($product_a_w_h['max_weight'])) && $product_a_w_h['max_weight'] != '' ? $product_a_w_h['max_weight'] : 'No Data'; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group clearfix form_inline">
                            <div class="col-lg-12">
                                <div class="col-lg-6 input_wrapper">
                                    <label for="fname">Minimum Height : </label>
                                    <p class="lead-profile-view"><?php echo (isset($product_a_w_h['min_height'])) && $product_a_w_h['min_height'] != '' ? $product_a_w_h['min_height'] : 'No Data'; ?></p>
                                </div>
                                <div class="col-lg-6 input_wrapper">
                                    <label for="mname">Maximum Height : </label>
                                    <p class="lead-profile-view"><?php echo (isset($product_a_w_h['max_height'])) && $product_a_w_h['max_height'] != '' ? $product_a_w_h['max_height'] : 'No Data'; ?></p>
                                </div>
                              </div>
                        </div>
                        <div class="form-group clearfix form_inline">
                            <div class="col-lg-12">
                                <div class="col-lg-6 input_wrapper">
                                    <label for="fname">Requires License Type : </label>
                                    <p class="lead-profile-view"><?php echo (isset($license_list)) ? $license_list : 'No Data'; ?></p>
                                </div>
                                 <div class="col-lg-6 input_wrapper">
                                    <label for="fname">Requires Appointment : </label>
                                    <p class="lead-profile-view"><?php echo (isset($product_data['product_requires_appointment'])) && $product_data['product_requires_appointment'] != '' ? $product_data['product_requires_appointment'] : 'No Data'; ?></p>
                                </div>
                            </div>
                        </div>
                         <div class="form-group clearfix form_inline">
                            <div class="col-lg-12">
                                <div class="col-lg-6 input_wrapper">
                                    <label for="fname">Requires License : </label>
                                    <p class="lead-profile-view"><?php echo (isset($product_data['product_requires_license'])) && $product_data['product_requires_license'] != ''  ? $product_data['product_requires_license'] : 'No Data'; ?></p>
                                </div>
                                <div class="col-lg-6 input_wrapper">
                                    <label for="mname">Enrollment Fee : </label>
                                    <p class="lead-profile-view"><?php echo (isset($enrollment_list)) ? $enrollment_list : 'No Data'; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group clearfix form_inline">
                            <div class="col-lg-12">
                                <div class="col-lg-6 input_wrapper">
                                    <label for="fname">Enrollment Billing Rule: </label>
                                    <p class="lead-profile-view"><?php echo (isset($product_data['product_enrollment_billing_rule'])) && $product_data['product_enrollment_billing_rule'] != '' ?  str_replace('_', ' ', $product_data['product_enrollment_billing_rule']) : 'No Data'; ?></p>
                                </div>
                                 <div class="col-lg-6 input_wrapper">
                                    <label for="fname">Vendor : </label>
                                    <p class="lead-profile-view"><?php echo (isset($product_vendor)) && $product_vendor != '' ? $product_vendor : 'No Data'; ?></p>
                                </div>
                            </div>
                        </div>
                         <div class="form-group clearfix form_inline">
                            <div class="col-lg-12">
                                <div class="col-lg-6 input_wrapper">
                                    <label for="fname">Billing Rule : </label>
                                    <p class="lead-profile-view"><?php echo (isset($product_data['product_billing_rule'])) && $product_data['product_billing_rule'] != '' ? str_replace('_', ' ', $product_data['product_billing_rule']) : 'No Data'; ?></p>
                                </div>
                                <div class="col-lg-6 input_wrapper">
                                    <label for="mname">Next Billing Date Rule : </label>
                                    <p class="lead-profile-view"><?php echo (isset($product_data['product_next_billing_date_rule'])) && $product_data['product_next_billing_date_rule'] != '' ? str_replace('_', ' ', $product_data['product_next_billing_date_rule'])  : 'No Data'; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group clearfix form_inline">
                            <div class="col-lg-12">
                                <div class="col-lg-6 input_wrapper">
                                    <label for="fname">Activation Date Rule: </label>
                                    <p class="lead-profile-view"><?php echo (isset($product_data['product_activation_date_rule'])) && $product_data['product_activation_date_rule'] != '' ?   str_replace('_', ' ', $product_data['product_activation_date_rule']) : 'No Data'; ?></p>
                                </div>
                                 <div class="col-lg-6 input_wrapper">
                                    <label for="fname">Average-Savings : </label>
                                    <p class="lead-profile-view"><?php echo (isset($product_data['product_average_savings'])) && $product_data['product_average_savings'] != '' ? $product_data['product_average_savings'] : 'No Data'; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->