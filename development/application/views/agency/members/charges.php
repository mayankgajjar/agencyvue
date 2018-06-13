<?php
//echo 'Agency Members';
//pr_arr($agencyMembers);
//echo 'Agent Members';
//pr_arr($agentMembers);
//echo 'Total Count';
//pr_exit($activeMembersCount);
?>
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Charges Par Active Users</h4>
                <ol class="breadcrumb">
                    <li>
                        <a href="#">Manager Members</a>
                    </li>
                    <li class="active">
                        Charges Par Active Members
                    </li>
                </ol>
            </div>
        </div>
        <?php if ($this->session->flashdata('success')) { ?>
            <div class="content pt0">
                <div class="alert alert-success">
                    <a class="close" data-dismiss="alert"><i class="fa fa-times"></i></a>
                    <strong><?= $this->session->flashdata('success') ?></strong>
                </div>
            </div>
            <?php
            $this->session->set_flashdata('success', false);
        } else if ($this->session->flashdata('error')) {
            ?>
            <div class="content pt0">
                <div class="alert alert-danger">
                    <a class="close" data-dismiss="alert"><i class="fa fa-times"></i></a>
                    <strong><?= $this->session->flashdata('error') ?></strong>
                </div>
            </div>
            <?php
            $this->session->set_flashdata('error', false);
        } else if (validation_errors()) {
            ?>
            <div class="content pt0">
                <div class="alert alert-danger">
                    <a class="close" data-dismiss="alert"><i class="fa fa-times"></i></a>
                    <strong><?= validation_errors() ?></strong>
                </div>
            </div>
        <?php } ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="charges-box">
                    <div class="row">
                        <div class="col-lg-8 card-box">
                            <h4 class="m-t-0 header-title"><b>Counts Of Members</b></h4>
                            <p class="text-muted font-13">
                                Counts of all members which are active in your profile Total Active is <code><?php echo $activeMembersCount; ?></code> <br>
                                Below Summery of active members Agent wise <?php echo ($agencyMembers > 0) ? '|| And your Total Active Members is <code>' . $agencyMembers . '</code>' : ''; ?>
                            </p>
                            <div class="p-20">
                                <table id="datatable" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Agent Name</th>
                                            <th>Total Active Members</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($agentMembers as $agentMember):
                                            ?>
                                            <tr>
                                                <th scope="row"><?= $i; ?></th>
                                                <td><?php echo get_display_name($agentMember['parent_id']); ?></td>
                                                <td><?php echo $agentMember['total_members']; ?></td>
                                            </tr>
                                            <?php
                                            $i = $i + 1;
                                        endforeach;
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <?php if ($activeMembersCount > 0): ?>
                                <?php if ($last_paymonth != date('F')): ?>
                                    <div class="card-box">
                                        <div class="p-20">
                                            <div class="text-muted font-13">
                                                <p>As per our policy you need to pay $1 per active member. <br> Your Payable Amount is <?= '$' . $activeMembersCount ?> </p>
                                            </div>
                                            <button class="btn btn-success waves-effect waves-light stripe-pop-up" type="button">
                                                <span class="btn-label"><i class="fa fa-cc-stripe"></i>
                                                </span>Make Payment</button>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="charges-box">
                    <div class="row">

                    </div>
                </div>
            </div>
        </div>
        <div class="custom-loader" style="display: none">
            <div class="loader"></div>
        </div>
        <!--Payment Pop-up-->
        <div id="panel-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content p-0 b-0">
                    <div class="panel panel-color panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Please Make A Payment For Registering Agency </h3>
                        </div>
                        <div class="panel-body">
                            <div class="card-box">
                                <div class="row">
                                    <form method="post" id="payment_info" novalidate="" class="payment_info">
                                        <div class="">
                                            <div class="tab-content">
                                                <div id="home" class="tab-pane fade in active">
                                                    <div class="credit-card-details">
                                                        <div class="m-b-20">
                                                            <h5>Enter Card Details And Make Payment Of $55 As Registration Fee</h5>
                                                        </div>
                                                        <div class="form-group col-md-8 pad-zero">
                                                            <label>CARD NUMBER</label>
                                                            <div class="detail-box card-valid">
                                                                <input type="text" placeholder="123 123" autocomplete="off" data-parsley-type='number' data-parsley-maxlength="16" class="form-control required" name="card_number" id="card_number" value="">
                                                                <p><i class="fa fa-credit-card" aria-hidden="true"></i></p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-4 pad-zero">
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
                                                <button type="submit" name="stripe" id="payment" value="check_my">PROCEED TO SECURE PAYMENT<span><i class="fa fa-lock" aria-hidden="true"></i></span></button>
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
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
</div>
<style type="text/css">
    .payment_info {
        padding: 0px 0px !important;
    }
    .payment-method {
        width: 50%;
    }
    .test-mode {
        width: 30%;
    }
    label.btn.btn-default {
        margin-top: 0px !important;
    }
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
    #infoUser {color: red;font-weight: bold;padding-top: 10px;}
</style>
<script type="text/javascript">
    $('#datatable').dataTable();
    $('form').parsley();
    $(document).on("click", ".stripe-pop-up", function () {
        $('#panel-modal').modal('show');
    });
</script>