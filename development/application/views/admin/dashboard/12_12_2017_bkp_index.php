<style>
    .pagination-info{display: none;}
    .page-list{display: none;}
    .pagination{display: none;}
    i.icon-cart-min.md.md-add-shopping-cart {background: url(http://agencyvue.com/assets/images/ic_32.png);height: 30px;width: 30px;background-size: contain;line-height: 80px;margin: 23px 0 0 0;}
    .icon-cart-min.md-add-shopping-cart:before {content: "";}
    li.single-feed {
        border-bottom: 1px solid #555c62;
        padding-bottom: 10px;
        margin-bottom: 10px;
        position: relative;
        padding-left: 30px;
    }
    .single-feed span:nth-child(3) {
        display: block;
        font-size: 12px;
        padding-top: 5px;
        text-align: right;
    }
    li.single-feed:last-child {
        border: 0;
    }
    li.single-feed span.icon-box {
        height: 20px;
        display: inline-block;
        width: 20px;
        text-align: center;
        line-height: 22px;
        color: #2dc4b9;
        position: absolute;
        left: 0;
        font-size: 16px;
    }
</style>

<div class="wrapper">
    <div class="container">
        <?php
        if ($this->session->flashdata('success')) {
            ?>
            <div class="content pt0">
                <div class="alert alert-success">
                    <a class="close" data-dismiss="alert"><i class="fa fa-times"></i></a>
                    <strong><?= $this->session->flashdata('success') ?></strong>
                </div>
            </div>
            <?php
            $this->session->set_flashdata('success', false);
        }
        ?>
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Dashboard</h4>

                <p class="text-muted page-title-alt">Welcome <?php echo $this->session->userdata['user_info']['display_name']; ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-3">
                <div class="widget-bg-color-icon card-box fadeInDown animated">
                    <div class="bg-icon bg-icon-primary pull-left">
                        <i class="md md-attach-money text-primary"></i>
                    </div>
                    <div class="text-right">
                        <h3 class="text-dark"><b class="counter"><?php echo (isset($productsale)) ? formatMoney($productsale, 2, TRUE) : "0"; ?></b></h3>
                        <p class="text-muted">Total Sales</p>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="widget-bg-color-icon card-box">
                    <div class="bg-icon bg-icon-success pull-left">
                        <i class="md md-add-shopping-cart text-success"></i>
                    </div>
                    <div class="text-right">
                        <h3 class="text-dark"><b class="counter"><?php echo $activemember; ?></b></h3>
                        <p class="text-muted">Total Orders</p>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="widget-bg-color-icon card-box">
                    <div class="bg-icon bg-icon-pink pull-left">
                        <i class="icon-cart-min md md-add-shopping-cart text-pink"></i>
                    </div>
                    <div class="text-right">
                        <h3 class="text-dark"><b class="counter"><?php echo $inactivemember; ?></b></h3>
                        <p class="text-muted">Total Cancels</p>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="widget-bg-color-icon card-box">
                    <div class="bg-icon bg-icon-info pull-left">
                        <i class="glyphicon glyphicon-refresh text-info"></i>
                    </div>
                    <div class="text-right">
                        <h3 class="text-dark"><b class="counter"><?php
                                if ($retention != 0) {
                                    echo round($retention) . ' %';
                                } else {
                                    echo '0 %';
                                }
                                ?></b></h3>
                        <p class="text-muted">Retention Rate</p>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-4">
                <div class="card-box">
                    <h4 class="text-dark header-title m-t-0 m-b-30">Member Target </h4>
                    <div class="widget-chart text-center">
                        <input class="knob dial" data-width="150" data-height="150" data-linecap=round data-fgColor="#2dc4b9" data-bgColor="#505A66" value="<?php echo number_format(floatval($memberRangePercentage)); ?>" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".15" data-max="<?php echo $memberRangePercentage > 100 ? $memberRangePercentage : 100; ?>"/>
                        <h2 class="widget_range_value font-400"> Target Range <?php echo ($memberTargetInfo['target_range'] == null) ? 'Not Set' : $memberTargetInfo['target_range']; ?></h2>
                        <h5 class="text-muted m-t-20">Total Register Members Today</h5>
                        <h2 class="font-600"><?php echo $today_member_count; ?></h2>
                        <ul class="list-inline m-t-15">
                            <li>
                                <h5 class="text-muted m-t-20">Last Week Register Members</h5>
                                <h4 class="m-b-0"><?php echo $last_week_members; ?></h4>
                            </li>
                            <li>
                                <h5 class="text-muted m-t-20">Last Month Register Members</h5>
                                <h4 class="m-b-0"><?php echo $last_month_count; ?></h4>
                            </li>
                            <li>
                                <h5 class="text-muted m-t-20">Total Register Member </h5>
                                <h4 class="m-b-0"><?php echo $all_member_count; ?></h4>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--            <div class="col-lg-4">
                            <div class="card-box">
                                <h4 class="text-dark header-title m-t-0 m-b-30">Weekly Target</h4>
                                <div class="widget-chart text-center">
                                    <input class="knob dial" data-width="150" data-height="150" data-linecap=round data-fgColor="#2dc4b9" data-bgColor="#505A66" value="<?php echo number_format(floatval($salesPercen)); ?>" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".15" data-max="<?php echo $salesPercen > 100 ? $salesPercen : 100; ?>"/>
                                    <h5 class="text-muted m-t-20">Total sales made today</h5>
                                    <h2 class="font-600"><?php echo formatMoney($agentTodaySales, 2, True); ?></h2>
                                    <ul class="list-inline m-t-15">
                                        <li>
                                            <h5 class="text-muted m-t-20">Last week</h5>
                                            <h4 class="m-b-0"><?php echo formatMoney($agentLastweekSales, 2, TRUE); ?></h4>
                                        </li>
                                        <li>
                                            <h5 class="text-muted m-t-20">Last Month</h5>
                                            <h4 class="m-b-0"><?php echo formatMoney($agentLastmonthSales, 2, TRUE); ?></h4>
                                        </li>
                                        <li>
                                            <h5 class="text-muted m-t-20">All Time</h5>
                                            <h4 class="m-b-0"><?php echo formatMoney($agentTotalSales, 2, TRUE); ?></h4>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>-->
            <div class="col-lg-4">
                <div class="card-box">
                    <h4 class="text-dark header-title m-t-0 m-b-30">Commission Target </h4>
                    <div class="widget-chart text-center">
                        <input class="knob dial" data-width="150" data-height="150" data-linecap=round data-fgColor="#2dc4b9" data-bgColor="#505A66" value="<?php echo number_format(floatval(50)); ?>" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".15" data-max="100"/>
                        <h2 class="widget_range_value font-400"> Target Range <?php echo 'Monthly'; ?></h2>
                        <h5 class="text-muted m-t-20">Total Commission Made Today</h5>
                        <h2 class="font-600"><?php echo formatMoney('500', 2, TRUE); ?></h2>
                        <ul class="list-inline m-t-15">
                            <li>
                                <h5 class="text-muted m-t-20">Last week</h5>
                                <h4 class="m-b-0"><?php echo formatMoney('1600', 2, TRUE); ?></h4>
                            </li>
                            <li>
                                <h5 class="text-muted m-t-20">Last Month</h5>
                                <h4 class="m-b-0"><?php echo formatMoney('6000', 2, TRUE); ?></h4>
                            </li>
                            <li>
                                <h5 class="text-muted m-t-20">All Time</h5>
                                <h4 class="m-b-0"><?php echo formatMoney('100000', 2, TRUE); ?></h4>
                            </li>
                        </ul>
                    </div>

                </div>

            </div>
            <div class="col-lg-4">
                <div class="card-box">
                    <h4 class="text-dark header-title m-t-0 m-b-30">Premium Target</h4>
                    <div class="widget-chart text-center">
                        <input class="knob dial" data-width="150" data-height="150" data-linecap=round data-fgColor="#2dc4b9" data-bgColor="#505A66" value="<?php echo number_format(floatval($premiumPercentage)); ?>" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".15" data-max="<?php echo $premiumPercentage > 100 ? $premiumPercentage : 100; ?>"/>
                        <h2 class="widget_range_value font-400"> Target Range <?php echo ($premiumTargetInfo['target_range'] == null) ? 'Not Set' : $premiumTargetInfo['target_range']; ?></h2>
                        <h5 class="text-muted m-t-20">Total Sales Made Today</h5>
                        <h2 class="font-600"><?php echo formatMoney($agentTodaySales, 2, TRUE); ?></h2>
                        <ul class="list-inline m-t-15">
                            <li>
                                <h5 class="text-muted m-t-20">Last week</h5>
                                <h4 class="m-b-0"><?php echo formatMoney($agentLastweekSales, 2, TRUE); ?></h4>
                            </li>
                            <li>
                                <h5 class="text-muted m-t-20">Last Month</h5>
                                <h4 class="m-b-0"><?php echo formatMoney($agentLastmonthSales, 2, TRUE); ?></h4>
                            </li>
                            <li>
                                <h5 class="text-muted m-t-20">All Time</h5>
                                <h4 class="m-b-0"><?php echo formatMoney($agentTotalSales, 2, TRUE); ?></h4>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>


        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="card-box">
                    <h4 class="m-t-0 header-title"><b>Recent Members</b></h4>
                    <div class="bootstrap-table">
                        <table data-toggle="table" data-show-columns="false" data-page-list="[5, 10, 20]" data-page-size="5" data-pagination="true" data-show-pagination-switch="true" id="datatable" class="table-bordered  table table-hover" style="display: table;">
                            <thead style="">
                                <tr>
                                    <th style="" data-field="id" tabindex="0">
                                        <div class="th-inner ">Name</div>
                                        <div class="fht-cell"></div>
                                    </th>
                                    <th style="" data-field="name" tabindex="0">
                                        <div class="th-inner ">Product</div>
                                        <div class="fht-cell"></div>
                                    </th>
                                    <th style="" data-field="date" tabindex="0">
                                        <div class="th-inner ">Email</div>
                                        <div class="fht-cell"></div>
                                    </th>
                                    <th style="" data-field="amount" tabindex="0">
                                        <div class="th-inner ">Status</div>
                                        <div class="fht-cell"></div>
                                    </th>
                                    <th class="text-center" style="" data-field="user-status" tabindex="0">
                                        <div class="th-inner ">Action</div>
                                        <div class="fht-cell"></div>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($memberlist as $list) { ?>
                                    <tr>
                                        <td style=""><?php echo $list['customer_first_name'] . ' ' . $list['customer_last_name']; ?></td>
                                        <td style="">Test Product</td>
                                        <td style=""><?php echo $list['customer_email']; ?></td>
                                        <td class="text-center" style="">
                                            <?php if ($list['is_active'] == "Y") { ?>
                                                <span class="label label-table label label-success"> Active </span>
                                            <?php } else { ?>
                                                <span class="label label-table label label-warning"> Cancelled </span>
                                            <?php } ?>
                                        </td>
                                        <td style="">Action</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table></div>
                    <div class="fixed-table-footer" style="display: none;"><table><tbody><tr></tr></tbody></table></div><div class="fixed-table-pagination"><div class="pull-left pagination-detail"><span class="pagination-info">Showing 1 to 5 of 30 rows</span><span class="page-list"><span class="btn-group dropup"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="page-size">5</span> <span class="caret"></span></button><ul class="dropdown-menu" role="menu"><li class="active"><a href="javascript:void(0)">5</a></li><li><a href="javascript:void(0)">10</a></li><li><a href="javascript:void(0)">20</a></li></ul></span> rows per page</span></div><div class="pull-right pagination"><ul class="pagination"><li class="page-pre"><a href="javascript:void(0)">?</a></li><li class="page-number active"><a href="javascript:void(0)">1</a></li><li class="page-number"><a href="javascript:void(0)">2</a></li><li class="page-number"><a href="javascript:void(0)">3</a></li><li class="page-number"><a href="javascript:void(0)">4</a></li><li class="page-number"><a href="javascript:void(0)">5</a></li><li class="page-last"><a href="javascript:void(0)">6</a></li><li class="page-next"><a href="javascript:void(0)">?</a></li></ul></div></div>

                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card-box">
                    <h4 class="text-dark header-title m-t-0">Pending Verification</h4>
                    <div class="nicescroll mx-box" style="overflow: hidden;" tabindex="5000">
                        <?php foreach ($verification as $script) { ?>
                            <ul class="list-unstyled transaction-list m-r-5">
                                <li>
                                    <i class="ti-download text-success"></i>
                                    <span class="tran-text"><?php echo $script['display_name']; ?></span>
                                    <a class="pull-right text-success btn btn-xs btn-pinterest waves-effect waves-light" href="<?= base_url() . 'agent/members/edit_member/' . urlencode(base64_encode($script["customer_id"]))?>">Upload</a>
                                    <span class="pull-center text-muted"><?php echo date('d-m-Y', strtotime($script['added_time'])); ?></span>
                                    <span class="clearfix"></span>
                                </li>
                            </ul>
                        <?php } ?>
                    </div>


                </div>

            </div>
        </div>
        <div class="row">

            <div class="col-lg-5">
                <div class="card-box">
                    <h4 class="text-dark header-title m-t-0"> Feed </h4>
                    <div class="box-wapper">
                        <!--                        <ul class="list-unstyled transaction-list m-r-5">
                        <?php //foreach ($transactions as $tran) { ?>
                                                        <li>
                        <?php //if ($tran['is_status'] == 'Y') { ?>
                                                                <i class="ti-download text-success"></i>
                        <?php //} else { ?>
                                                                <i class="ti-upload text-danger"></i>
                        <?php //} ?>
                                                            <span class="tran-text" title="<?php //echo $tran['product_name']                                                                                         ?>"><?php //echo $tran['product_name']                                                                                         ?></span>
                        <?php //if ($tran['is_status'] == 'Y') { ?>
                                                                <span class="pull-right text-success tran-price">+<?php //echo $tran['product_price'];                                                                                         ?></span>
                        <?php //} else { ?>
                                                                <span class="pull-right text-danger tran-price">-<?php //echo $tran['product_price'];                                                                                         ?></span>
                        <?php //} ?>
                                                            <span class="pull-right text-muted"><?php //echo date('d-m-Y', strtotime($tran['added_time']));                                                                                         ?></span>
                                                            <span class="clearfix"></span>
                                                        </li>
                        <?php //} ?>
                                                </ul>-->
                        <ul class="feeds-list m-r-5 nav nav-tabs tabs">
                            <li class="active tab">
                                <a href="#feeds" data-toggle="tab" aria-expanded="false">
                                    <span class="visible-xs"><i class="fa fa-home"></i></span>
                                    <span class="hidden-xs"> Activity </span>
                                </a>
                            </li>
                            <li class="tab">
                                <a href="#system" data-toggle="tab" aria-expanded="false">
                                    <span class="visible-xs"><i class="fa fa-user"></i></span>
                                    <span class="hidden-xs"> System </span>
                                </a>
                            </li>
                        </ul>
                        <div id="feedbox" class="m-t-20 nicescroll mx-box" style="overflow: hidden;" tabindex="5000">
                            <div class="tab-content">
                                <div class="tab-pane active" id="feeds">
                                    <ul class="list-unstyled">
                                        <?php foreach ($feeds as $feed) { ?>
                                            <li class="single-feed">
                                                <span class="icon-box"> <i class="<?php echo($feed['feed_icon'] != '') ? $feed['feed_icon'] : 'glyphicon glyphicon-bell'; ?>"></i> </span><span class="feed-text" title="<?php echo $feed['feed_title'] ?>"><?php echo $feed['feed_title'] ?></span>
                                                <span><?php echo timespan(strtotime($feed['created']), time(), 2) . ' ago'; ?></span>
                                                <span class="clearfix"></span>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <div class="tab-pane" id="system">
                                    <h5>No System Feeds For Now</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="card-box">
                    <h4 class="m-t-0 m-b-20 header-title"><b>USA Map</b></h4>
                    <div id="usa" style="height: 400px"></div>
                </div>
            </div>
            <!-- end col -->

        </div>

    </div>
</div>



</div>
<!-- end row -->



<!-- end row -->


<!-- Footer -->

<!-- End Footer -->

</div>
</div>

<script>
    jQuery(function () {
        $(".knob").knob();
    });
//    jQuery(".nicescroll").getNiceScroll().resize()
    jQuery.fn.niceScroll && jQuery(".nicescroll").niceScroll({cursorcolor: '#98a6ad', cursorborder: '#98a6ad', cursorwidth: '5px', cursorborderradius: '5px'});
    jQuery(".dial").knob({
        'format': function (value) {
            return value + '%';
        }
    });
    var mapvalue = <?php echo $mapvalueJson ?>;
    $('#usa').vectorMap({
        map: 'us_aea_en',
        backgroundColor: 'transparent',
        regionStyle: {
            initial: {
                fill: '#fff'
            }
        },
        series: {regions: <?php echo $mapJson ?>},
        onRegionTipShow: function (event, label, code) {
            var customer = mapvalue[code];
            if (typeof customer == 'undefined') {
                customer = 0;
            }
            label.html(
                    '<b>' + label.html() + '</b></br>' +
                    '<b>Total Sales: </b>' + customer
                    );
        }
    });
    setInterval(function () {
        jQuery.ajax({
            type: "POST",
            url: "<?php base_url() ?>dashboard/feeds_updater",
            success: function (data) {
                jQuery("#feedbox").html(data);
            },
        });
    }, 30000);
</script>