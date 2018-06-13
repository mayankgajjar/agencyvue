<style type="text/css">
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
    input.textInputError {border-color: red;}
    label.btn.btn-default.choose-file-btn {margin: 0 !important;}
    .date-picker-div {position: relative;}
    .date-picker-div span {height: 32px;position: absolute;right: 2px;top: 2px;width: 40px;}
    .datepicker>div {display: block;}
    .datepicker {z-index: 9999999;}
</style>
<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Quote</h4>
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() . 'agent/dashboard' ?>">Dashboard</a></li>
                    <li><a href="<?= base_url() . 'agent/Quote' ?>">Quote</a></li>
                    <li class="active">Add Quote</li>
                </ol>
            </div>
        </div> 
        <div class="row card-box">
            <form id="frm_add_quote" method="post" action="<?php echo base_url() ?>agent/quote/add_quote" data-parsley-validate novalidate> 
                <div class="col-md-8 col-xs-12">
                    <div class="row">
                        <div class="form-group clearfix">
                            <div class="col-lg-12 ">                       
                                <div class="col-lg-6">
                                    <label for="fname">First Name * </label>

                                    <input type="text" id="fname" name="first_name" class="required form-control" autocomplete="off" value="" value="<?php echo set_value('first_name'); ?>">

                                </div>
                                <div class="col-lg-6">

                                    <label for="mname">Last Name * </label>

                                    <input type="text" id="mname" name="last name" class="required form-control" autocomplete="off" value="" >

                                </div>
                            </div>
                        </div>  
                    </div>
                    <div class="row">
                        <div class="form-group clearfix">
                            <div class="col-lg-12 ">                       
                                <div class="col-lg-6">
                                    <label for="fname">Email Address * </label>

                                    <input type="email" id="fname" name="emailid" class="required form-control" autocomplete="off" value="" >

                                </div>
                                <div class="col-lg-6">
                                    <label for="mname">Brith Date * </label>
                                    <div class="date-picker-div">
                                        <input class="form-control required dtpicker" placeholder="mm/dd/yyyy" id="datepicker-autoclose" name="dob" type="text" value="<?php echo set_value('dob'); ?>">
                                        <span class="input-group-addon bg-custom b-0 text-white"><i class="icon-calender"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </div>
                    <div class="row">
                        <div class="form-group clearfix">
                            <div class="col-md-12">                       
                                <div class="col-md-6">                                    
                                    <label for="fname">Zip Code * </label>
                                    <input type="text" id="fname" name="zipcode" class="required form-control custome_zipcode" autocomplete="off" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="mname">State * </label>
                                    <select class="form-control required" id="emp_state" name="quote_state">
                                        <option value="">Select State</option>
                                        <?php foreach ($states as $state): ?>
                                            <option value="<?php echo $state['state_code']; ?>" ><?php echo $state['state']; ?></option>
                                        <?php endforeach; ?>
                                    </select>

                                </div>
                            </div>
                        </div>  
                    </div>
                    <div class="row">
                        <div class="form-group clearfix">
                            <div class="col-lg-12">
                                <div class="col-lg-6">                                       
                                    <div class="checkbox checkbox-primary">
                                        <input id="e_fulfillment" type="checkbox" name="fulfillment_type" class="fulfillment_type" value="e_fulfillment">
                                        <label>Check this box to save this lead information</label>
                                    </div>
                                </div>
                            </div>                              
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group"><div class="col-md-12">
                                <div class="col-md-6">   
                                    <div style="text-align: left">
                                        <button type="submit" class="btn btn-success btn-lg" name="save" value="save">Find Plan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-xs-12">
                    <div class="featured-product-box">
                        <div class="featuredProduct-title">
                            <h4>Featured Product</h4>
                        </div>
                        <div class="html-featured-product">
                            <?php echo $featuredProduct; ?>
                        </div>
                    </div>
                </div>
            </form>                                          
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('form').parsley();

    });
</script>



