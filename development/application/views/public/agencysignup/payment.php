<div class="wrapper payment-wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row title-text-color">
            <div class="col-sm-12">
                <h4 class="page-title"> Final Step For Creating Agency </h4>
                <ol class="breadcrumb">
                    <P>Enter Card Details And Make Payment Of <strong>$55</strong> As Registration Fee</P>
                </ol>
            </div>
        </div>
        <?php if (validation_errors()):
            ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times"></i></button>
                <?php echo validation_errors(); ?>
            </div>
        <?php endif; ?>
        <div class="card-box">
            <div class="row">
                <form method="post" id="payment_info" novalidate="" class="payment_info">
                    <div class="">
                        <div class="tab-content">
                            <div id="home" class="tab-pane fade in active">
                                <div class="credit-card-details">
                                    <h3>Credit Card Details</h3>
                                    <div class="form-group col-md-9 pad-zero">
                                        <label>CARD NUMBER</label>
                                        <div class="detail-box card-valid">
                                            <input type="text" placeholder="123 123" autocomplete="off" data-parsley-type='number' data-parsley-maxlength="16" class="form-control required" name="card_number" id="card_number" value="">
                                            <p><i class="fa fa-credit-card" aria-hidden="true"></i></p>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3 pad-zero">
                                        <label>CARD CVC NUMBER</label>
                                        <div class="detail-box card-valid">
                                            <input type="text" placeholder="1234" autocomplete="off" class="form-control required" data-parsley-type='number' name="card_cvc" data-parsley-maxlength="4" data-parsley-minlength="3" id="card_cvc">
                                            <p><i class="fa fa-credit-card" aria-hidden="true"></i></p>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6 pad-zero">
                                        <label>EXPIRATION MONTH</label>
                                        <div class="detail-box month-valid">
                                           <select class="form-control required" name="exp_month">
                                                <option value="">Select Expiration Month</option>
                                                <option value="01">01</option>
                                                <option value="02">02</option>
                                                <option value="03">03</option>
                                                <option value="04">04</option>
                                                <option value="05">05</option>
                                                <option value="06">06</option>
                                                <option value="07">07</option>
                                                <option value="08">08</option>
                                                <option value="09">09</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                            </select>
                                            <p><i class="fa fa-clock-o" aria-hidden="true"></i></p>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6 pad-zero">
                                        <label>EXPIRATION YEAR</label>
                                        <div class="detail-box year-valid">
                                            <select class="form-control required" name="exp_year">
                                                <option value="">Select Expiration Year</option>
                                                <option value="2017">2017</option>
                                                <option value="2018">2018</option>
                                                <option value="2019">2019</option>
                                                <option value="2020">2020</option>
                                                <option value="2021">2021</option>
                                                <option value="2022">2022</option>
                                                <option value="2023">2023</option>
                                                <option value="2024">2024</option>
                                            </select>
                                            <p><i class="fa fa-clock-o" aria-hidden="true"></i></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="proceed-button">
                            <button type="submit" id="payment" value="check_my">PROCEED TO SECURE PAYMENT<span><i class="fa fa-lock" aria-hidden="true"></i></span></button>
                        </div>
                        <div class="payment-content">
                            <div class="test-mode"><a href="#">Test Mode</a></div>
                            <ul class="payment-method">
                                <li><a href=""><img src="<?php echo base_url(); ?>assets/crm_image/payment/payment-01.jpg" alt=""></a></li>
                                <li><a href=""><img src="<?php echo base_url(); ?>assets/crm_image/payment/payment-02.jpg" alt=""></a></li>
                                <li><a href=""><img src="<?php echo base_url(); ?>assets/crm_image/payment/payment-03.jpg" alt=""></a></li>
                                <li><a href=""><img src="<?php echo base_url(); ?>assets/crm_image/payment/payment-04.jpg" alt=""></a></li>
                            </ul>
                        </div>
                        <p class="powered-by">Powered By <i class="fa fa-cc-stripe"></i></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('form').parsley();
    });
</script>
<style>

</style>