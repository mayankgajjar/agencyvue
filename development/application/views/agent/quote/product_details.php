<style type="text/css">
    .loader-select-city {display: none;position: absolute;width: 100%;margin-right: 90px;background: rgba(255,255,255,.2);left: 0;top: 0;right: 0;bottom: 0;z-index: 9999;}
    .loader-image {height: 45px;top: 50%;position: absolute;left: 50%;margin-top: -22px;margin-left: -22px;}
    .btn-label {background: rgba(0, 0, 0, 0.05);display: inline-block;padding: 7px 9px;border-radius: 3px 0 0 3px;margin: -7px -13px;margin-right: 12px;border-radius: 4px;width: 100px;margin-left: 0px;}
    .fa{margin-right: 7px;}
    .product_box_content li.first-li{width:30%;}
    .product_box_content li.second-li{width:40%;}
    .product_box_content li.third-li{width:29%;}
    .clear-btn{display: none;}
    .checkout-btn{display: none;}
    .sub-total{display: none;}
    .cart-total{display: none;}
    .cart-title span {margin-right: 0;width: 30%;display: inline-block;text-align: center;margin-right: 10px;}
    .list-group-item{margin-top: 10px}
    .sc-cart-empty-msg{margin-top: 10px}
    .product-remove-btn{position: absolute;right: 2px;background: transparent;border: none;top: -6px;color: #94a2a8;font-size: 23px;display: none;}
    .sc-cart-item{position:relative;overflow: hidden;    border: none !important;border-bottom: 2px solid #2b333b !important;text-align: left;}
    .sc-cart-item h4.list-group-item-heading{    font-size: 14px;width: 35%;text-align: center;float: left;margin-right: 5px;}
    .sc-cart-item .sc-cart-item-summary{display: inline-block;float: left;}
    .panel-footer.sc-toolbar{padding: 0px;}
    .sc-cart-item-qty{background: #2b333b;margin-right: 13px;}
    button.btn.btn-success.waves-effect.waves-light.checkout.sc-cart-checkout {
        margin-top: 0 !important;
    }
</style>

<div class="wrapper find_product_wapper custom-ac-find-product">
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
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="row card-box">
                        <div class="new_first_section">
                            <h5 class="filter-title">Current Filter</h5>
                            <ul class="current-filter-content">
                                <li><label>Zipcode:</label><span> <?php echo $zip = base64_decode(urldecode($_REQUEST['zip'])); ?></span></li>
                                <li><label>State:</label><span><?php
                                        $state = base64_decode(urldecode($_REQUEST['state']));
                                        echo get_state_name($state);
                                        ?></span></li>
                                <li><label>Age:</label><span><?php echo $dob = base64_decode(urldecode($_REQUEST['age'])); ?></span></li>
                            </ul>
                        </div>

                        <h5 class="filter-title">Selected Product</h5>
                        <form action="<?= base_url() . 'agent/quote/checkout' ?>" method="post">
                            <div class="second-section">
                                <div class="selected-prduct-content">
                                    <div class="table-responsive">
                                        <div class="cart-title">
                                            <span>Product:</span>
                                            <span>Enrollment Fee:</span>
                                            <span>Price:</span>
                                        </div>
                                        <div class="table-responsive">
                                            <div id="agencyvuecart"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="select-product-amount">
                                    <div class="total_en_fees">
                                        <span>Total Enrollment Fees:</span>
                                        <span class="sc-cart-enrollment-fee"></span>
                                    </div>
                                    <div class="total_en_fees">
                                        <span>Total Monthly Payment:</span>
                                        <span class="sc-cart-totalpayment"></span>
                                    </div>
                                    <div class="total_en_fees">
                                        <span>Due Today:</span>
                                        <span class="sc-cart-subtotal"></span>
                                    </div>

                                    <div class="product-btn">
                                        <a href="#" class="back"><i class="fa fa-chevron-left"></i>Back</a>

                                        <button type="submit" class="btn btn-success waves-effect waves-light checkout sc-cart-checkout">Checkout</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                    <form action="" method="post" id="filter_product" onsubmit="javascript:formSubmit(event)">
                        <input type="hidden" name="state" id="get_state" value=<?php echo $state; ?>>
                        <input type="hidden" name="age" id="get_age" value=<?php echo $dob; ?>>
                        <div class="row card-box">
                            <div class="filter-by-section">
                                <div class="product-type-filter-section product-type">
                                    <h2 style="color:#fff;">Filter By:</h2>
                                    <div class="product-type-filter">
                                        <div class="product-type-filter_first_section">
                                            <h4>Product Type:</h4>
                                            <div class="checkbox checkbox-custom">
                                                <input id="producttype_selectall_checkbox"  type="checkbox" class="producttype_selectall_checkbox"><label style="font-weight:bold;color: #fff;">Select all</label>
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
                                                <input id="benifitstype_select_all"  type="checkbox" class="benifitstype_select_all"><label style="font-weight:bold;color: #fff;">Select All</label>
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
                                                <input id="ancillary_insurance"  type="checkbox" class="benifitstype" name="benifitstype[]" value="ancillary_insurance"><label>Ancillary Insurance</label>
                                            </div></li>
                                    </ul>
                                </div>
                                <div class="product-type-filter-section monthlycost">
                                    <div class="product-type-filter">
                                        <div class="product-type-filter_first_section">
                                            <h4>Monthly Cost:</h4>
                                            <div class="checkbox checkbox-custom">
                                                <input id="cost_selectall_checkbox" class="cost_selectall_checkbox" type="checkbox"><label style="font-weight:bold;color: #fff;">Select All</label>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="product-type-filter1 single">
                                        <li><div class="checkbox checkbox-custom">
                                                <input class="cost" id="cost[]" type="checkbox" value="100" name="cost[]"><label>Under $100</label>
                                            </div></li>
                                        <li><div class="checkbox checkbox-custom">
                                                <input class="cost" id="cost[]" type="checkbox" name="cost[]" value="100_250"><label>$100 to $250</label>
                                            </div></li>
                                        <li><div class="checkbox checkbox-custom">
                                                <input class="cost" id="cost[]" type="checkbox" name="cost[]" value="250_500"><label>$250 to $500</label>
                                            </div></li>
                                        <li><div class="checkbox checkbox-custom">
                                                <input class="cost" id="cost[]" type="checkbox" name="cost[]" value="500_1000"><label>$500 to $1,000</label>
                                            </div></li>
                                        <li><div class="checkbox checkbox-custom">
                                                <input class="cost" id="cost[]"  type="checkbox" name="cost[]" value="1000"><label>$1,000+</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                </div>
                </form>
                <div class="col-md-8 col-sm-8 col-xs-12 filter-product-box">
                    <?php foreach ($stateProducts as $product): ?>
                        <div class='col-md-12 col-sm-12 col-xs-12 card-box product-box sc-product-item' data-ptype="<?= $product['product_type'] ?>">
                            <ul class='product_box_content'>
                                <li class='first-li'>
                                    <div class='site-logo'><img src="<?= site_url() ?>assets/crm_image/products/<?= $product['product_image'] ?>" /></div>
                                    <span class='btn btn-success waves-effect waves-light product-details' data-toggle="modal" data-target="#full-width-modal" data-custom-value="<?= $product['global_product_id'] ?>">Details</span>
                                </li>
                                <li class='second-li'>
                                    <div class='product-type'><label>Product Name:</label><span  data-name="product_name" > <?= $product['product_name'] ?></span></div>
                                    <div class='product-type'><label>Product Type:</label><span> <?= (isset($product['product_type']) && $product['product_type'] != '') ? str_replace("_", " ", $product['product_type']) : 'No Data' ?></span></div>
                                    <div class='Benefits-type'><label>Benefits Type:</label><span><?= (isset($product['product_benefits_type']) && $product['product_benefits_type'] != '') ? str_replace("_", " ", $product['product_benefits_type']) : 'No Data' ?></span></div>
                                    <div class='average-savings'><label>Average Savings:</label><span><?= ($product['product_average_savings'] != '') ? $product['product_average_savings'] : 'No Data' ?> </span></div>
                                    <div class='network-size'><label>Network Size:</label><span><?= ($product['product_network_size'] != '') ? $product['product_network_size'] : 'No Data' ?> </span></div>
                                    <div class='network-size'><label>Product Price:</label><span><?= $product['product_price'] ?> </span></div>
                                </li>
                                <li class='third-li'>
                                    <div class='product_prize_total'><p><?= '$ ' . $product['product_price'] ?></p></div>
                                    <input type="hidden" class="product_enrollment" name="product_enrollment" value='<?php echo json_encode(get_enrollment_fee($product['global_product_id'])); ?>'>
                                    <input type="hidden" class="product_price" name="product_price" value="<?= $product['product_price']; ?>">
                                    <input type="hidden" class="product_id"  name="product_id" value="<?= $product['global_product_id']; ?>">
                                    <div class='product_prize_total_btns'>
                                        <button class='btn btn-success waves-effect waves-light btn-label sc-add-to-cart add-product'><i class='fa fa-check'></i>Add</button>
                                        <button class='btn btn-danger waves-effect waves-light btn-label sc-cart-remove remove-product' value="abc"><i class='fa fa-times'></i>Remove</button>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    <?php endforeach; ?>
                    <?php foreach ($api_products as $apiProdoct): ?>
                        <?php
                            $key_exist = array_key_exists('Name', $apiProdoct); 
                            if ($key_exist == 1)
                            {
                                $apiProdoct['product_name'] = $apiProdoct->Name;
                                $apiProdoct['product_price'] = $apiProdoct->Premium;
                                $producttype = explode("~~", $apiProdoct['product_name']);
                              //  $apiProdoct['product_type'] = $producttype[1];
                                $apiProdoct['product_type'] = 'No Data';
                                $apiProdoct['product_benefits_type'] = 'No Data';
                                $apiProdoct['product_average_savings'] = 'No Data';
                                $apiProdoct['product_network_size'] = 'No Data';
                                $apiProdoct['enrollment_fee'] = $apiProdoct->EnrollmentFee;
                                $apiProdoct['product_id'] = rand(1,4); //generate random product
                            }
                          
                        ?>
                        <div class='col-md-12 col-sm-12 col-xs-12 card-box product-box sc-product-item' >
                            <ul class='product_box_content'>
                                <li class='first-li'>
                                    <div class='site-logo'><img src="<?= site_url() ?>assets/crm_image/products/<?= $apiProdoct['product_image'] ?>" /></div>
                                    <span class='btn btn-success waves-effect waves-light product-details' data-toggle="modal" data-target="#full-width-modal" data-custom-value="<?= $apiProdoct['global_product_id'] ?>">Details</span>
                                </li>
                                <li class='second-li'>
                                    <div class='product-type'><label>Product Name:</label><span  data-name="product_name" > <?= $apiProdoct['product_name'] ?></span></div>
                                    <div class='product-type'><label>Product Type:</label><span> <?php echo $apiProdoct['product_type'] != '' ? $apiProdoct['product_type'] : 'No Data' ?></span></div>
                                    <div class='Benefits-type'><label>Benefits Type:</label><span><?=   $apiProdoct['product_benefits_type'] != '' ? str_replace("_", " ", $apiProdoct['product_benefits_type']) : 'No Data'?></span></div>
                                    <div class='average-savings'><label>Average Savings:</label><span><?=  $apiProdoct['product_average_savings'] != '' ? $apiProdoct['product_average_savings'] : 'No Data'?> </span></div>
                                    <div class='network-size'><label>Network Size:</label><span><?=  $apiProdoct['product_network_size'] != '' ? $apiProdoct['product_network_size'] : 'No Data'?> </span></div>
                                    <div class='network-size'><label>Product Price:</label><span><?= $apiProdoct['product_price'] ?> </span></div>
                                </li>
                                <li class='third-li'>
                                    <div class='product_prize_total'><p><?= '$ ' . $apiProdoct['product_price'] ?></p></div>
                                    <input type="hidden" class="product_enrollment" name="product_enrollment" value=<?= $apiProdoct['enrollment_fee'] ?>>
                                    <input type="hidden" class="product_price" name="product_price" value="<?= $apiProdoct['product_price']; ?>">
                                    <input type="hidden" class="product_id"  name="product_id" value="<?= $apiProdoct['global_product_id']; ?>">
                                    <div class='product_prize_total_btns'>
                                        <button class='btn btn-success waves-effect waves-light btn-label sc-add-to-cart add-product'><i class='fa fa-check'></i>Add</button>
                                        <button class='btn btn-danger waves-effect waves-light btn-label sc-cart-remove remove-product' value="abc"><i class='fa fa-times'></i>Remove</button>
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
<div class = "loader-select-city"><img class = "loader-image" src = "<?= base_url() . 'assets/crm_image/' ?>ring.gif" style = "display: none;"></div>
</div>
<div id = "full-width-modal" class = "modal fade" tabindex = "-1" role = "dialog" aria-labelledby = "full-width-modalLabel" aria-hidden = "true" style = "display: none;" >
    <div id = "mga"></div>
</div><!--/.modal -->

<script src = "<?php echo base_url() ?>assets/js/jquery.smartCart.js"></script>
<script>
        $(document).ready(function () {
            var tem = $('.product_price').val();
            $('.remove-product').attr("disabled", true);
            //Call function when checkbox is clicked
            $("input[type='checkbox']").on("click", function () {
                $('#filter_product').submit();
            });
            $('#agencyvuecart').smartCart();
        });
        function formSubmit(e) {
            e.preventDefault();
            var postdata = $('#filter_product').serialize();
            $('.loader-select-city').show();
            $.ajax({
                method: "POST",
                url: '<?php echo base_url() ?>agent/quote/filters',
                data: postdata,
                success: function (data) {
                    $('.product-box').hide();
                    $('.loader-select-city').hide();
                    $(".filter-product-box").html(data);
                    $.fn.niceScroll && $(".nicescroll").niceScroll({cursorcolor: '#98a6ad', cursorborder: '#98a6ad', cursorwidth: '5px', cursorborderradius: '5px'});
                }
            });
        }

        $(document).on('click', '.product-details', function () {
            var globalid = $(this).data("custom-value");
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "<?php echo base_url() ?>agent/quote/product_information",
                data: {productid: globalid},
                success: function (data) {
                    $('#mga').html(data.new_html);
                    $('#full-width-modal').modal('show');
                },
            });
        });

        $(document).on('click', '.add-product', function () {
            $(this).attr("disabled", true);
            $(this).siblings(":button").attr("disabled", false);
            //$(this).siblings(":button").val($('.sc-cart-item').data("unique-key"));
        });

        $(document).on('click', '.remove-product', function () {
            $(this).attr("disabled", true);
            $(this).siblings(":button").attr("disabled", false);
        });


        $('.cost_selectall_checkbox').change(function () {
            if (document.getElementById('cost_selectall_checkbox').checked) 
            {
                $(".cost").prop("checked", true);
            }
            else
            {
                $(".cost").prop("checked", false);
            }
       });

       $('.cost').change(function () {
            var checked_count = $('.cost:checked').length;
            var total_count = $('.cost').length;
            if (total_count == checked_count) 
            {
                 $(".cost_selectall_checkbox").prop("checked", true);
            }
            else
            {
                 $(".cost_selectall_checkbox").prop("checked", false);
            }
       });

        $('#benifitstype_select_all').change(function () {
            if (document.getElementById('benifitstype_select_all').checked) 
            {
                 $(".benifitstype").prop("checked", true);
             }
             else
             {
                 $(".benifitstype").prop("checked", false);
             }
       });

       $('.benifitstype').change(function () {
            var checked_count = $('.benifitstype:checked').length;
            var total_count = $('.benifitstype').length;
            if (total_count == checked_count) 
            {
                $("#benifitstype_select_all").prop("checked", true);
            }
            else
            {
                $("#benifitstype_select_all").prop("checked", false);
            }
       });

        $('#producttype_selectall_checkbox').change(function () {
            if (document.getElementById('producttype_selectall_checkbox').checked) 
            {
                $(".Producttype").prop("checked", true);
            }
            else
            {
                $(".Producttype").prop("checked", false);
            }
       });

       $('.Producttype').change(function () {
            var checked_count = $('.Producttype:checked').length;
            var total_count = $('.Producttype').length;
            if (total_count == checked_count) 
            {
                 $("#producttype_selectall_checkbox").prop("checked", true);
            }
            else
            {
                 $("#producttype_selectall_checkbox").prop("checked", false);
            }
       });
</script>

                                                         


