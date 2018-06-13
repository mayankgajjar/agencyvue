<style>
    .cart-data {padding: 30px;background: #2b333b;}
    .filters ul {display: inline-block;padding-left: 0;background: #2b333b;margin-bottom: 0;padding: 5px 20px;}
    .filters ul li p{margin-bottom: 0;}
    .filters ul li:last-child{margin: 0;}
    .table-total tr td:first-child{width: 48%;}
    .table-total tr td {border: 0 !important;padding: 0px 15px !important;color: #fff;}
    .table-total {margin-top: 10px;}
    .cart-buttons{float: right;margin-right: 100px;margin-top: 10px;}
    .cart-buttons .btn.btn-success {padding: 5px 25px;}
    .cart-buttons .btn {background: #909090;color: #fff;padding: 5px 20px;margin-right: 10px;}
</style>
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title" style="padding-bottom: 30px;"><?php echo 'Quote' ?></h4>
            </div>
        </div>
        <div class="row">
            <?php if ($this->session->flashdata('success')): ?>
                <div class="content pt0">
                    <div class="alert alert-success">
                        <a class="close" data-dismiss="alert"><i class="fa fa-times"></i></a>
                        <strong><?= $this->session->flashdata('success') ?></strong>
                    </div>
                </div>
                <?php
                $this->session->set_flashdata('success', false);
            elseif ($this->session->flashdata('error')):
                ?>
                <div class="content pt0">
                    <div class="alert alert-danger">
                        <a class="close" data-dismiss="alert"><i class="fa fa-times"></i></a>
                        <strong><?= $this->session->flashdata('error') ?></strong>
                    </div>
                </div>
                <?php
                $this->session->set_flashdata('error', false);
            elseif (validation_errors()):
                ?>
                <div class="content pt0">
                    <div class="alert alert-danger">
                        <a class="close" data-dismiss="alert"><i class="fa fa-times"></i></a>
                        <strong><?= validation_errors() ?></strong>
                    </div>
                </div>
            <?php endif; ?>
            <div class="col-lg-12">
                <div class="card-box">
                    <div class="row">
                        <div class="filters">
                            <h4><?php echo 'Current Filter:' ?></h4>
                            <?php
                            $birthDate = $customer['customer_dob'];
                            $birthDate = explode("-", $birthDate);
                            $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[2], $birthDate[0]))) > date("md") ? ((date("Y") - $birthDate[0]) - 1) : (date("Y") - $birthDate[0]));
                            ?>
                            <ul>
                                <li><p><?php echo 'Zip Code' ?>&nbsp;&nbsp;&nbsp;&nbsp;<span><?php echo $customer['customer_zipcode'] ?></span></p></li>
                                <li><p><?php echo 'State' ?>&nbsp;&nbsp;&nbsp;&nbsp;<span><?php echo $customer['customer_state'] ?></span></p></li>
                                <li><p><?php echo 'Age' ?>&nbsp;&nbsp;&nbsp;&nbsp;<span><?php echo $age ?></span></p></li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <h4><?php echo 'Selected Products:' ?></h4>
                        <div class="cart-data">
                            <div class="cart-table">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th><?php echo 'Product Name' ?></th>
                                            <th><?php echo 'Product Type' ?></th>
                                            <th><?php echo '# Dependents' ?></th>
                                            <th><?php echo 'Activation Date' ?></th>
                                            <th><?php echo 'Enrollment Fee' ?></th>
                                            <th><?php echo 'Price' ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $cartData = $this->session->userdata('product_data'); ?>
                                        <?php $totalEnrollment = 0; ?>
                                        <?php $totalPrice = 0; ?>
                                        <?php if (count($cartData) > 0): ?>
                                            <?php foreach ($cartData as $cart): ?>
                                                <tr>
                                                    <td><?php echo $cart->product_name ?></td>
                                                    <td><?php echo 'Dentel' ?></td>
                                                    <td><?php echo '5' ?></td>
                                                    <td><?php echo date('m/d/Y') ?></td>
                                                    <td><?php echo formatMoney($cart->product_enrollment, 2, TRUE) ?></td>
                                                    <td><?php echo formatMoney($cart->product_price, 2, TRUE) ?></td>
                                                </tr>
                                                <?php $totalEnrollment = $totalEnrollment + $cart->product_enrollment; ?>
                                                <?php $totalPrice = $totalPrice + $cart->product_price; ?>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">

                            <?php if (count($cartData) > 0): ?>
                                <table class="table table-total">
                                    <tr>
                                        <td></td><td></td><td></td><td></td>
                                        <td style="text-align: right;"><?php echo 'Total Enrollment Fee:' ?></td>
                                        <td><?php echo formatMoney($totalEnrollment, 2, TRUE); ?></td>
                                    </tr>
                                    <tr>
                                        <td></td><td></td><td></td><td></td>
                                        <td style="text-align: right;"><?php echo 'Total Monthly Payment' ?></td>
                                        <td><?php echo formatMoney($totalPrice, 2, TRUE); ?></td>
                                    </tr>
                                    <tr>
                                        <td></td><td></td><td></td><td></td>
                                        <td style="text-align: right;"><?php echo 'Due Today' ?></td>
                                        <td><?php echo formatMoney(($totalEnrollment + $totalPrice), 2, TRUE); ?></td>
                                    </tr>
                                </table>
                            <?php endif; ?>
                            <div class="cart-buttons">
                                <a href="<?php echo $backurl; ?>" class="btn"><?php echo 'Back' ?></a>
                                <button class="btn btn-success" data-toggle="modal" data-target="#verification_script"><?php echo 'Checkout' ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="verification_script" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width:55%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title" id="custom-width-modalLabel">Upload Product Verification Script </h4>
            </div>
            <form id="verification_script" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <h4 class="text-uppercase font-600"><strong>Product(s)</strong></h4>

                    <ul class="list-inline status-list m-t-20">
                        <?php
                        if (isset($member_product_array)) {
                            $i = 0;
                            ?>
                            <?php foreach ($member_product_array as $prodcut) : ?>
                                <input type="hidden" name="product_id[<?php echo $i; ?>]" value="<?php echo $prodcut['global_product_id']; ?>" >
                                <li class="product-list">
                                    <?php
                                    if ($prodcut['is_status'] == 'W') {
                                        $status = '<button type="button" class="btn btn-warning btn-xs" data-target="#add-product-modal" data-toggle="modal"> Verification Pending </button>';
                                    } else {
                                        $status = '<button type="button" class="btn btn-danger btn-xs" data-target="#add-product-modal" data-toggle="modal"> Cancelled </button>';
                                    }
                                    ?>
                                    <?= $prodcut['product_name'] . " - " . $status; ?>
                                    <div class="fileupload btn btn-purple waves-effect waves-light fileupload-new-btn">
                                        <span><i class="ion-upload m-r-5" title="Upload Script"></i></span>
                                        <input type="file" name="verification_scripts[<?php echo $i; ?>]" class="upload required" onchange="Validateverification(this);" required>
                                    </div>
                                </li>
                                <?php
                                $i++;
                            endforeach;
                            ?>
                            <div class="error_verification" style="font-style: italic; color: #f6504d; margin-top: 8px; display: none;">Please select only .mp3 file format.</div>
                        <?php } ?>
                    </ul>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                    <button type="submit" name="checkout" value="checkout" class="btn btn-primary waves-effect waves-light">Checkout</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<style type="text/css">
    .filters ul{list-style: none;}
    .filters ul li{float: left;margin-right: 60px;}
</style>
<script>
    var _validFileExtensions = [".mp3", ".wav"];
    function Validateverification(oInput) {
        if (oInput.type == "file") {
            var sFileName = oInput.value;
            if (sFileName.length > 0) {
                var blnValid = false;
                for (var j = 0; j < _validFileExtensions.length; j++) {
                    var sCurExtension = _validFileExtensions[j];
                    if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                        blnValid = true;
                        $(".error_verification").hide();
                        break
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
