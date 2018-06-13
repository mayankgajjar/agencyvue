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

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title"> Add Product</h4>
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() . 'agent/dashboard' ?>">Dashboard</a></li>
                    <li><a href="<?= base_url() . 'agent/products' ?>">Products</a></li>
                    <li class="active">Add Product</li>
                </ol>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <form role="form" novalidate="">
                    <div class="card-box">
                            <ul class="nav nav-tabs">
                                <li class="nav-item active">
                                    <a href="#vendor" data-toggle="tab" aria-expanded="true" class="nav-link">
                                        Vendor
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#profile" data-toggle="tab" aria-expanded="false" class="nav-link">
                                        Product
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#messages" data-toggle="tab" aria-expanded="false" class="nav-link">
                                        Filters
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#settings" data-toggle="tab" aria-expanded="true" class="nav-link active">
                                        Billing
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#verification" data-toggle="tab" aria-expanded="true" class="nav-link active">
                                        Verification
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#commissions" data-toggle="tab" aria-expanded="true" class="nav-link active">
                                        Commissions
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade active in" id="vendor" aria-expanded="true">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Select Vendor</label>
                                                <select class="form-control" id="vendor_name" name="vendor_name">
                                                    <option value="">Select Vendor</option>
                                                    <?php foreach($vendors as $vendor):?>
                                                        <option><?php echo($vendor['vendor_name'])?></option>
                                                    <?php endforeach;?>
                                                </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Product Category </label>
                                            <select class="form-control" id="product_category" name="product_category">
                                                <option value="">Select Product Category</option>
                                                <?php foreach($products_category as $product):?>
                                                    <option><?php echo(str_replace('_', ' + ', $product['product_coverage']))?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Product Type</label>
                                            <select  class="form-control" id="product_type" name="product_type">
                                                <option value="">Select Product Type</option>
                                                <?php foreach($products_type as $product):?>
                                                    <option><?php echo(str_replace('_', ' ', $product['product_type']))?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="col-md-2 col-md-offset-10">
                                                <button type="button" class="btn btn-white btn-lg" name="save" value="save">Next</button>
                                                <button type="button" class="btn btn-default waves-effect btn-lg" name="save" value="save">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="profile" aria-expanded="false">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <label>Product ID:</label>
                                                    <input type="text"  id="product_id" name="product_id" class="form-control" >
                                                </div>
                                            </div>
                                             <div class="row">
                                                <div class="col-md-8">
                                                    <label>Product Name:</label>
                                                    <input type="text"  id="product_name" name="product_name" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <label>Product Category </label>
                                                    <select class="form-control" id="product_category" name="product_coverage">
                                                        <option value="">Select Product Category</option>
                                                        <?php foreach($products_category as $product):?>
                                                            <option><?php echo(str_replace('_', ' + ', $product['product_coverage']))?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-md-6" >
                                                    <img src="http://local.agencyvue.dev/assets/images/users/avatar-2.jpg" alt="image" class="img-fluid img-thumbnail" width="200px" height="200px" id="product_image" name="product_image">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-6 input_wrapper">
                                                    <label>Upload Product Image</label>
                                                    <input type="file" name="product_image" class="filestyle" data-buttonname="btn-default" id="filestyle-0" onchange="displayimage(this)" tabindex="-1" style="position: absolute; clip: rect(0px 0px 0px 0px);">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="error_verification" style="font-style: italic; color: rgb(246, 80, 77); margin-top: 8px;">Please select only .png, .jpg, .jpeg file format.</div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="col-md-2 col-md-offset-10">
                                                <button type="button" class="btn btn-white btn-lg" name="save" value="save">Back</button>
                                                <button type="button" class="btn btn-default waves-effect btn-lg" name="save" value="save">Next</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <div class="tab-pane fade" id="messages" aria-expanded="false">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Product Category </label>
                                                    <select class="form-control" id="product_category" name="product_coverage">
                                                        <option value="">Select Product Category</option>
                                                        <?php foreach($products_category as $product):?>
                                                            <option><?php echo(str_replace('_', ' + ', $product['product_coverage']))?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Age Restriction</label>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <input type="Number"  id="age_from" name="age_from" class="form-control" >
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label>To</label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="Number"  id="age_to" name="age_to" class="form-control" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Male Weight Restriction</label>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <input type="Number" id="male_weight_from" name="male_weight_from" class="form-control" >
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label>To</label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="Number"  id="male_weight_to" name="male_weight_to" class="form-control" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Female Weight Restriction</label>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <input type="Number" id="female_weight_from" name="female_weight_from" class="form-control" >
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label>To</label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="Number"  id="female_weight_to" name="female_weight_to" class="form-control" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                   </div>
                                   <div class="col-lg-6">
                                        <div class="row">
                                            <label><h4>Allow Pre-Existing Conditions? </h4></label>
                                            <div class="checkbox checkbox-primary checkbox-inline">
                                                <input id="checkbox11" type="checkbox" >
                                                <label for="checkbox11">
                                                    Yes
                                                </label>
                                            </div>
                                            <div class="checkbox checkbox-primary checkbox-inline">
                                                <input id="checkbox11" type="checkbox" checked="">
                                                <label for="checkbox11">
                                                    No
                                                </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label><h4>Allow Tobacco Use? </h4></label>
                                             <div class="checkbox checkbox-primary checkbox-inline">
                                                <input id="checkbox11" type="checkbox">
                                                <label for="checkbox11">
                                                    Yes
                                                </label>
                                            </div>
                                            <div class="checkbox checkbox-primary checkbox-inline">
                                                <input id="checkbox11" type="checkbox" checked="">
                                                <label for="checkbox11">
                                                    No
                                                </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label><h4>Required License?</h4></label>
                                            <div class="checkbox checkbox-primary checkbox-inline" >
                                                <input id="checkbox11" type="checkbox" checked="">
                                                <label for="checkbox11">
                                                    Yes
                                                </label>
                                            </div>
                                            <div class="checkbox checkbox-primary checkbox-inline">
                                                <input id="checkbox11" type="checkbox" >
                                                <label for="checkbox11">
                                                    No
                                                </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label><h4>Allow Pre-Existing Conditions?</h4></label>
                                            <div class="checkbox checkbox-primary checkbox-inline">
                                                <input id="checkbox11" type="checkbox" checked="">
                                                <label for="checkbox11">
                                                    Health
                                                </label>
                                            </div>
                                            <div class="checkbox checkbox-primary checkbox-inline">
                                                <input id="checkbox11" type="checkbox" >
                                                <label for="checkbox11">
                                                    Accident
                                                </label>
                                            </div>
                                            <div class="checkbox checkbox-primary checkbox-inline">
                                                <input id="checkbox11" type="checkbox" >
                                                <label for="checkbox11">
                                                    Life
                                                </label>
                                            </div>
                                            <div class="checkbox checkbox-primary checkbox-inline">
                                                <input id="checkbox11" type="checkbox" >
                                                <label for="checkbox11">
                                                    Property & Casuality
                                                </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label><h4>Requires Appointment?</h4></label>
                                            <div class="checkbox checkbox-primary checkbox-inline" >
                                                <input id="checkbox11" type="checkbox" checked="">
                                                <label for="checkbox11">
                                                    Yes
                                                </label>
                                            </div>
                                            <div class="checkbox checkbox-primary checkbox-inline">
                                                <input id="checkbox11" type="checkbox" >
                                                <label for="checkbox11">
                                                    No
                                                </label>
                                            </div>
                                        </div>
                                   </div>
                                   <div class="row">
                                        <div class="col-lg-12">
                                            <div class="col-md-2 col-md-offset-10">
                                                <button type="button" class="btn btn-white btn-lg" name="save" value="save">Back</button>
                                                <button type="button" class="btn btn-default waves-effect btn-lg" name="save" value="save">Next</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="settings" aria-expanded="true">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Product Price:</label>
                                                <input type="number"  id="product_price" name="product_price" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Enrollment Fee(s):</label>
                                                <input type="number"  id="enrollment_fees" name="enrollment_fees" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Enrollment Billing Rule:</label>
                                                <select class="form-control" id="product_category" name="product_coverage">
                                                    <option value=""></option>
                                                    <option value="">One Time</option>
                                                    <option value="">Weekly</option>
                                                    <option value="">Semi Monthly</option>
                                                    <option value="">Monthly</option>
                                                    <option value="">Yearly</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Billing Rule:</label>
                                                <select class="form-control" id="product_category" name="product_coverage">
                                                    <option value=""></option>
                                                    <option value="">One-Time</option>
                                                    <option value="">Weekly</option>
                                                    <option value="">Semi-Monthly</option>
                                                    <option value="">Monthly</option>
                                                    <option value="">Yearly</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Next Billing Date Rule:</label>
                                                <select class="form-control" id="product_category" name="product_coverage">
                                                    <option value=""></option>
                                                    <option value="">Same day each month</option>
                                                    <option value="">1st of every month</option>
                                                    <option value="">15th of every month</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Activation Date Rule:</label>
                                                <select class="form-control" id="product_category" name="product_coverage">
                                                    <option value=""></option>
                                                    <option value="">Next Day</option>
                                                    <option value="">1st & 15th of the month</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="col-md-2 col-md-offset-10">
                                                <button type="button" class="btn btn-white btn-lg" name="save" value="save">Back</button>
                                                <button type="button" class="btn btn-default waves-effect btn-lg" name="save" value="save">Next</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="verification" aria-expanded="true">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Master Verification script</label>
                                                <input type="file" name="product_image" class="filestyle" data-buttonname="btn-default" >
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Alternative Verification script</label>
                                                <input type="file" name="product_image" class="filestyle" data-buttonname="btn-default" >
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <br>
                                                <button type="button" class="btn btn-default" name="addScriptRuleBtn" value="addScriptRuleBtn">Add Script Rule</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                       <div class="row">
                                            <div class="col-md-6">
                                                <label>State Rule:</label>
                                                <select multiple id="e1" class="form-control">
                                                    <option value="AL">Alabama</option>
                                                    <option value="Am">Amalapuram</option>
                                                    <option value="An">Anakapalli</option>
                                                    <option value="Ak">Akkayapalem</option>
                                                    <option value="WY">Wyoming</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                       <div class="row">
                                            <div class="col-md-6">
                                                <label>Status:</label>
                                                <div class="row">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" value="active" checked>Active
                                                </label>
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" value="active">Inactive
                                                </label>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="col-md-2 col-md-offset-10">
                                            <button type="button" class="btn btn-white btn-lg" name="save" value="save">Back</button>
                                            <button type="button" class="btn btn-default waves-effect btn-lg" name="save" value="save">Next</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                             <div class="tab-pane fade" id="commissions" aria-expanded="true">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label><h4>Commisions are paid:</h4></label>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="checkbox11" type="checkbox" >
                                                    <label for="checkbox11">
                                                        One-Time
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="checkbox11" type="checkbox" >
                                                    <label for="checkbox11">
                                                        Weekly
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="checkbox11" type="checkbox" >
                                                    <label for="checkbox11">
                                                        Bi-monthly
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="checkbox11" type="checkbox" >
                                                    <label for="checkbox11">
                                                        Monthly
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="checkbox11" type="checkbox" >
                                                    <label for="checkbox11">
                                                        Yearly
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="inlineCheckbox1" type="checkbox" class="checkbox-inline" >
                                                    <label for="inlineCheckbox1">
                                                        Every
                                                    </label>
                                                    <input type="number" class="checkbox-inline form-control" >
                                                    <span>
                                                        Days
                                                    </span>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="inlineCheckbox1" type="checkbox" checked="" class="checkbox-inline" >
                                                    <label for="inlineCheckbox1">
                                                        Every
                                                    </label>
                                                    <input type="number" class="checkbox-inline form-control" >
                                                    <span>
                                                        Months
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label><h4>Renewals are paid:</h4></label>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="checkbox11" type="checkbox" checked="">
                                                    <label for="checkbox11">
                                                        Never
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="checkbox11" type="checkbox" >
                                                    <label for="checkbox11">
                                                        Weekly
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="checkbox11" type="checkbox" >
                                                    <label for="checkbox11">
                                                        Bi-monthly
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="checkbox11" type="checkbox" >
                                                    <label for="checkbox11">
                                                        Monthly
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="checkbox11" type="checkbox" >
                                                    <label for="checkbox11">
                                                        Yearly
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="inlineCheckbox1" type="checkbox" class="checkbox-inline" >
                                                    <label for="inlineCheckbox1">
                                                        Every
                                                    </label>
                                                    <input type="number" class="checkbox-inline form-control" >
                                                    <span>
                                                        Days
                                                    </span>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="inlineCheckbox1" type="checkbox" class="checkbox-inline" >
                                                    <label for="inlineCheckbox1">
                                                        Every
                                                    </label>
                                                    <input type="number" class="checkbox-inline form-control" >
                                                    <span>
                                                        Months
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="col-lg-4">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label><h4>Commision Structure:</h4></label>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="flat_fee" name="com_structure[]" type="checkbox" class="com_structure">
                                                    <label for="flat_fee">
                                                        Flat Fee
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="perc_of_preminim" name="com_structure[]" type="checkbox" class="com_structure">
                                                    <label for="perc_of_preminim">
                                                        Percent of Preminum
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="tier_years" name="com_structure[]" type="checkbox" checked="" class="com_structure">
                                                    <label for="tier_years">
                                                        Tier Years
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="comiss_prem" name="com_structure[]" type="checkbox" class="com_structure">
                                                    <label for="comiss_prem">
                                                        Commisionable Preminums
                                                    </label>
                                                </div>
                                                <div class="checkbox checkbox-primary">
                                                    <input id="cal_prem" name="com_structure[]" type="checkbox" class="com_structure">
                                                    <label for="cal_prem">
                                                        Prorated Calender Preminums (Medicare Advantage)
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row" id="tier_years">
                                    <label><h4>Standard Percentage of Preminum:</h4></label>
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="col-md-2">
                                                    <label for="1"> Preminum</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" id="1" class="form-control">
                                                </div>
                                                <div class="col-md-8">
                                                    <label >Monthly </label>
                                                    <input type="checkbox" value="option1">
                                                    <label> Annual </label>
                                                    <input type="checkbox" value="option1">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="col-md-2">
                                                    <label for="1"> Tier-1 Number of Years</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" id="1" class="form-control">
                                                </div>
                                                <div class="col-md-2">
                                                    <label>%of preminum per year </label>
                                                    <input type="text" class="form-control" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="col-md-2">
                                                    <label for="1"> Tier-2 Number of Years</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" id="1" class="form-control">
                                                </div>
                                                <div class="col-md-2">
                                                    <label>%of preminum per year </label>
                                                    <input type="text" class="form-control" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="col-md-2">
                                                    <label for="1"> Tier-3 Number of Years</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" id="1" class="form-control">
                                                </div>
                                                <div class="col-md-2">
                                                    <label>%of preminum per year </label>
                                                    <input type="text" class="form-control" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="cal_prem">
                                    <label><h4>Prorated Calender (Medicare Advantage) Commision Structure:</h4></label>
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="form-group clearfix col-md-4">
                                                <label class="control-label " for="userName">Commision</label>
                                                <div class="">
                                                    <input class="form-control required" id="userName" name="userName" type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class="form-group clearfix col-md-4">
                                                <label class="control-label " for="userName">Renewal</label>
                                                <div class="">
                                                    <input class="form-control required" id="userName" name="userName" type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="perc_of_preminim">
                                    <label><h4>Variable Percentage of Premium Structure:</h4></label>
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="col-md-2">
                                                    <label for="1"> %of Premium (commsion)</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" id="1" class="form-control">
                                                </div>
                                                <div class="col-md-8">
                                                    <label >Monthly </label>
                                                    <input type="checkbox" value="option1">
                                                    <label> Annual </label>
                                                    <input type="checkbox" value="option1">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="col-md-2">
                                                    <label for="1"> %of Premium (Renewal)</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" id="1" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="col-md-2">
                                                    <label for="1"> non-Commisionable Account</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" id="1" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="col-md-2">
                                                    <label for="1"> Default Premium</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" id="1" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="flat_fee">
                                    <label><h4>Flat Fee Commision Structure:</h4></label>
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="form-group clearfix col-md-4">
                                                <label class="control-label " for="userName">Commision</label>
                                                <div class="">
                                                    <input class="form-control required" id="userName" name="userName" type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class="form-group clearfix col-md-4">
                                                <label class="control-label " for="userName">Renewal</label>
                                                <div class="">
                                                    <input class="form-control required" id="userName" name="userName" type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                             </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="full-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="full-width-modalLabel" aria-hidden="true" style="display: none;">
        <div id="mga"></div>
    </div><!-- /.modal -->

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".error_verification").hide();
    });

    $(document).on('click', '.com_structure', function (ele) {
            var element = ele.target;
            var id = $(element).attr('id');
            console.log(id);
            $(id).hide();

    });

    $("#e1").select2();

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
</script>



