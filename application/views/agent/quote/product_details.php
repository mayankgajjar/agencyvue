<style type="text/css">
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

<div class="wrapper find_product_wapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Available Products</h4>
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() . 'agent/dashboard' ?>">Dashboard</a></li>
                    <li><a href="<?= base_url() . 'admin/quote' ?>">Quote Section</a></li>
                    <li class="active">Find My Plan</li>
                </ol>
            </div>
        </div>
        <?php if ($this->session->flashdata('success')) { ?>
            <div class="content pt0">
                <div class="alert alert-success">
                    <a class="close" data-dismiss="alert">×</a>
                    <strong><?= $this->session->flashdata('success') ?></strong>
                </div>
            </div>
            <?php
            $this->session->set_flashdata('success', false);
        } else if ($this->session->flashdata('error')) {
            ?>
            <div class="content pt0">
                <div class="alert alert-danger">
                    <a class="close" data-dismiss="alert">×</a>
                    <strong><?= $this->session->flashdata('error') ?></strong>
                </div>
            </div>

            <?php
            $this->session->set_flashdata('error', false);
        } else if (validation_errors()) {
            ?>
            <div class="content pt0">
                <div class="alert alert-danger">
                    <a class="close" data-dismiss="alert">×</a>
                    <strong><?= validation_errors() ?></strong>
                </div>
            </div>
        <?php } ?>
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <div class="row card-box">
                        <div class="new_first_section">
                            <h5 class="filter-title">Current Filter</h5>
                            <ul class="current-filter-content">
                                <li><label>Zipcode:</label><span> <?php echo $zip = base64_decode(urldecode($_REQUEST['zipcode'])); ?></span></li>
                                <li><label>State:</label><span><?php echo $state = base64_decode(urldecode($_REQUEST['state'])); ?></span></li>
                                <li><label>Age:</label><span><?php echo $dob = base64_decode(urldecode($_REQUEST['dob'])); ?></span></li>
                            </ul>
                        </div>


                        <div class="second-section">
                            <div class="selected-prduct-content">
                                <div class="table-responsive">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Enrollment Fee</th>
                                                    <th>Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Shun</td>
                                                    <td>Patt</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Michal</td>
                                                    <td>Krown</td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Ricky</td>
                                                    <td>Ponting</td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>Hayden</td>
                                                    <td>Matt</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="select-product-amount">
                                <div class="total_en_fees">
                                    <span>Total Enrollment Fees</span>
                                    <span>$ 0.000</span>
                                </div>
                                <div class="total_month_pay">
                                    <div class="total_en_fees">
                                        <span>Total Enrollment Fees</span>
                                        <span>$ 0.000</span>
                                    </div>
                                </div>
                                <div class="total_due_today">
                                    <div class="total_en_fees">
                                        <span>Total Enrollment Fees</span>
                                        <span>$ 0.000</span>
                                    </div>
                                </div>
                                <div class="product-btn">
                                    <a href="#" class="back"><i class="fa fa-chevron-left"></i>Back</a>
                                    <a href="#" class="checkout">Checkout</a>
                                </div>
                            </div>
                        </div>

                    </div>
            <form action="" method="post" id="filter_product" onsubmit="javascript:formSubmit(event)">
                    <input type="hidden" name="state" id="get_state" value=<?php echo $state; ?>>
                    <input type="hidden" name="age" id="get_age"value=<?php echo $dob; ?>>
                    <div class="row card-box">
                        <div class="filter-by-section">
                            <div class="product-type-filter-section product-type">
                                <h2 style="color:#fff;">Filter By:</h2>
                                <div class="product-type-filter">
                                    <div class="product-type-filter_first_section">
                                        <h4>Product type:</h4>
                                        <div class="checkbox checkbox-custom">
                                            <input id="Producttype"  type="checkbox" class="Producttype"><label style="font-weight:bold;color: #fff;">Select all</label>
                                        </div>
                                    </div>
                                </div>
                                <ul class="product-type-filter1">
                                    <li><div class="checkbox checkbox-custom">
                                        <input id="Helth"  class="Producttype" name="producttype[]" type="checkbox" value="Health"><label>Helth</label>
                                    </div></li>
                                    <li><div class="checkbox checkbox-custom">
                                        <input id="Rx" class="Producttype" name="producttype[]" type="checkbox" value="Rx"><label>Rx</label>
                                    </div></li>
                                    <li><div class="checkbox checkbox-custom">
                                        <input id="Dental" class="Producttype" name="producttype[]" type="checkbox" value="Dental"><label>Dental</label>
                                    </div></li>
                                    <li><div class="checkbox checkbox-custom">
                                        <input id="Life" class="Producttype" name="producttype[]"  type="checkbox" value="Life"><label>Life</label>
                                    </div></li>
                                    <li><div class="checkbox checkbox-custom">
                                        <input id="Medicare" class="Producttype"  name="producttype[]"  type="checkbox" value="Medicare"><label>Medicare</label>
                                    </div></li>
                                    <li><div class="checkbox checkbox-custom">
                                        <input id="Vision"  class="Producttype" name="producttype[]" type="checkbox" value="Vision"><label>Vision</label>
                                    </div></li>
                                    <li><div class="checkbox checkbox-custom">
                                        <input id="Discount" class="Producttype"  name="producttype[]" type="checkbox" value="Discount"><label>Discount</label>
                                    </div></li>
                                    <li><div class="checkbox checkbox-custom">
                                        <input id="AccidentMedical" class="Producttype" name="producttype[]" type="checkbox" value="AccidentMedical"><label>AccidentMedical</label>
                                    </div></li>
                                    <li><div class="checkbox checkbox-custom">
                                        <input id="Telehealth" class="Producttype" name="producttype[]"  type="checkbox" value="Telehealth"><label>Telehealth</label>
                                    </div></li>
                                    <li><div class="checkbox checkbox-custom">
                                        <input id="Criticalillness" class="Producttype" name="producttype[]"  type="checkbox" value="Criticalillness"><label>Criticalillness</label>
                                    </div></li>
                                </ul>
                            </div>
                            <div class="product-type-filter-section benefits-type">
                                <div class="product-type-filter">
                                    <div class="product-type-filter_first_section">
                                        <h4>Benifits Type:</h4>
                                        <div class="checkbox checkbox-custom">
                                            <input id="benifitstype"  type="checkbox" class="benifitstype"><label style="font-weight:bold;color: #fff;">Select All</label>
                                        </div>
                                    </div>
                                </div>
                                <ul class="product-type-filter1 single2">
                                    <li><div class="checkbox checkbox-custom">
                                        <input id="Discount"  type="checkbox" class="benifitstype" name="benifitstype[]" value="Discount"><label>Discount</label>
                                    </div></li>
                                    <li><div class="checkbox checkbox-custom">
                                        <input id="Telehealth" name="benifitstype[]"  type="checkbox" class="benifitstype" value="Telehealth"><label>Telehealth</label>
                                    </div></li>
                                    <li><div class="checkbox checkbox-custom">
                                        <input id="major_medical"  type="checkbox" class="benifitstype" name="benifitstype[]" value="major_medical"><label>Major Medical</label>
                                    </div></li>
                                    <li><div class="checkbox checkbox-custom">
                                        <input id="life"  type="checkbox" class="benifitstype" name="benifitstype[]" value="life"><label>Life</label>
                                    </div></li>
                                    <li><div class="checkbox checkbox-custom">
                                        <input id="ancillary_insurance"  type="checkbox" calss="benifitstype" name="benifitstype[]" value="ancillary_insurance"><label>Ancillary Insurance</label>
                                    </div></li>
                                </ul>
                            </div>
                            <div class="product-type-filter-section monthlycost">
                                <div class="product-type-filter">
                                    <div class="product-type-filter_first_section">
                                        <h4>Monthly Cost:</h4>
                                        <div class="checkbox checkbox-custom">
                                            <input id="checkbox11"  type="checkbox"><label style="font-weight:bold;color: #fff;">Select All</label>
                                        </div>
                                    </div>
                                </div>
                                <ul class="product-type-filter1 single">
                                    <li><div class="checkbox checkbox-custom">
                                        <input id="checkbox11"  type="checkbox" value="100" name="cost[]"><label>Under $100</label>
                                    </div></li>
                                    <li><div class="checkbox checkbox-custom">
                                        <input id="checkbox11"  type="checkbox" name="cost[]" value="100_250"><label>$100 to $250</label>
                                    </div></li>
                                    <li><div class="checkbox checkbox-custom">
                                        <input id="checkbox11"  type="checkbox" name="cost[]" value="250_500"><label>$250 to $500</label>
                                    </div></li>
                                    <li><div class="checkbox checkbox-custom">
                                        <input id="checkbox11"  type="checkbox" name="cost[]" value="500_1000"><label>$500 to $1,000</label>
                                    </div></li>
                                    <li><div class="checkbox checkbox-custom">
                                        <input id="checkbox11"  type="checkbox" name="cost[]" value="1000"><label>$1,000+</label>
                                    </div></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
                <div class="col-md-8 col-sm-9 col-xs-12 filter-product-box">
                    <?php foreach ($stateProducts as $product): ?>
                        <div class='col-md-12 col-sm-12 col-xs-12 card-box product-box' data-ptype="<?= $product['product_type'] ?>">
                            <ul class='product_box_content'>
                                <li class='first-li'>
                                    <div class='site-logo'><img src="<?= site_url() ?>assets/crm_image/products/<?= $product['product_image'] ?>" /></div>
                                    <div class='Details-btn'><a href='#'>Details</a></div>
                                </li>
                                <li class='second-li'>
                                    <div class='product-type'><label>Product-Type:</label><span> <?= $product['product_type'] ?></span></div>
                                    <div class='Benefits-type'><label>Benefits-Type:</label><span><?= $product['product_benefits_type'] ?></span></div>
                                    <div class='average-savings'><label>Average-Savings:</label><span><?= $product['product_average_savings'] ?> </span></div>
                                    <div class='network-size'><label>Network-Size:</label><span><?= $product['product_network_size'] ?> </span></div>
                                    <div class='network-size'><label>Product-Price:</label><span><?= $product['product_price'] ?> </span></div>
                                </li>
                                <li class='third-li'>
                                    <div class='product_prize_total'><p><?= '$'.$product['product_price'] ?></p></div>
                                    <div class='product_prize_total_btns'>
                                        <a href='#' class='btn btn-success waves-effect waves-light'><span class='btn-label'><i class='fa fa-check'></i></span>Add</a>
                                        <a href='#' type='button' class='btn btn-danger waves-effect waves-ligh'><span class='btn-label'><i class='fa fa-times'></i></span>Remove</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="loader-select-city"><img class="loader-image" src="<?= base_url() . 'assets/crm_image/' ?>ring.gif" style="display: none;"></div>
</div>
<script>
    $(document).ready(function () {
        //Call function when checkbox is clicked
        $("input[type='checkbox']").on("click", function () {
            $('#filter_product').submit();
        });
    });
    function formSubmit(e){
        e.preventDefault();
        var postdata = $('#filter_product').serialize();
        $('.loader-select-city').show();
        $.ajax({
            method: "POST",
            url: '<?php echo base_url() ?>admin/products/filters',
            data: postdata,
            success: function (data) {
                $('.product-box').hide();
                $('.loader-select-city').hide();
                $(".filter-product-box").html(data);
                $.fn.niceScroll && $(".nicescroll").niceScroll({cursorcolor: '#98a6ad', cursorborder: '#98a6ad', cursorwidth: '5px', cursorborderradius: '5px'});
            }
        });
    }
</script>




