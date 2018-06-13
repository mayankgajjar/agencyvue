<style>
    .pagination-info{display: none;}
    .page-list{display: none;}
    .pagination{display: none;}
</style>

<div class="wrapper">
    <div class="container">
        <?php
        if ($this->session->flashdata('success')) {
            ?>
            <div class="content pt0">
                <div class="alert alert-success">
                    <a class="close" data-dismiss="alert">X</a>
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
                        <h3 class="text-dark"><b class="counter"><?php echo (isset($productsale)) ? $productsale : "0"; ?></b></h3>
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
                        <i class="md md-add-shopping-cart text-pink"></i>
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
//                                if ($inactivemember <= 0 && $activemember <= 0) {
//                                    $rotation = "Retention Is Not available";
//                                } else {
//                                    $rotation = round((($inactivemember / $activemember)) * 100, 2);
//                                }
//                                echo ($rotation != "Retention Is Not available" ) ? $rotation . '%' : "0";
                                if ($inactivemember != 0 && $activemember != 0) {
                                    echo $rotation = round((($inactivemember / $activemember)) * 100, 2).' %';
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
                    <h4 class="text-dark header-title m-t-0 m-b-30">Weekly Target</h4>
                    <div class="widget-chart text-center">
                        <input class="knob" data-width="150" data-height="150" data-linecap=round data-fgColor="#2dc4b9" data-bgColor="#505A66" value="<?php echo number_format($salesPercen); ?>" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".15" data-max="<?php echo $salesPercen > 100 ? $salesPercen : 100; ?>"/>
                        <h5 class="text-muted m-t-20">Total sales made today</h5>
                        <h2 class="font-600">$<?php echo $agentTodaySales; ?></h2>
                        <ul class="list-inline m-t-15">
                            <li>
                                <h5 class="text-muted m-t-20">Target</h5>
                                <h4 class="m-b-0">$<?php echo $agentTarget; ?></h4>
                            </li>
                            <li>
                                <h5 class="text-muted m-t-20">Last week</h5>
                                <h4 class="m-b-0">$<?php echo $agentLastweekSales ?></h4>
                            </li>
                            <li>
                                <h5 class="text-muted m-t-20">Last Month</h5>
                                <h4 class="m-b-0">$<?php echo $agentLastmonthSales ?></h4>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
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
                                                <?php
                                            } else {
                                                ?>
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
        </div>
        <div class="row">

            <div class="col-lg-3">
                <div class="card-box">
                    <h4 class="text-dark header-title m-t-0">Last Transactions</h4>


                    <div class="nicescroll mx-box" style="overflow: hidden;" tabindex="5000">
                        <ul class="list-unstyled transaction-list m-r-5">
                            <li>
                                <i class="ti-download text-success"></i>
                                <span class="tran-text">Advertising</span>
                                <span class="pull-right text-success tran-price">+$230</span>
                                <span class="pull-right text-muted">07/09/2015</span>
                                <span class="clearfix"></span>
                            </li>

                            <li>
                                <i class="ti-upload text-danger"></i>
                                <span class="tran-text">Support licence</span>
                                <span class="pull-right text-danger tran-price">-$965</span>
                                <span class="pull-right text-muted">07/09/2015</span>
                                <span class="clearfix"></span>
                            </li>

                            <li>
                                <i class="ti-download text-success"></i>
                                <span class="tran-text">Extended licence</span>
                                <span class="pull-right text-success tran-price">+$830</span>
                                <span class="pull-right text-muted">07/09/2015</span>
                                <span class="clearfix"></span>
                            </li>

                            <li>
                                <i class="ti-download text-success"></i>
                                <span class="tran-text">Advertising</span>
                                <span class="pull-right text-success tran-price">+$230</span>
                                <span class="pull-right text-muted">05/09/2015</span>
                                <span class="clearfix"></span>
                            </li>

                            <li>
                                <i class="ti-upload text-danger"></i>
                                <span class="tran-text">New plugins added</span>
                                <span class="pull-right text-danger tran-price">-$452</span>
                                <span class="pull-right text-muted">05/09/2015</span>
                                <span class="clearfix"></span>
                            </li>

                            <li>
                                <i class="ti-download text-success"></i>
                                <span class="tran-text">Google Inc.</span>
                                <span class="pull-right text-success tran-price">+$230</span>
                                <span class="pull-right text-muted">04/09/2015</span>
                                <span class="clearfix"></span>
                            </li>

                            <li>
                                <i class="ti-upload text-danger"></i>
                                <span class="tran-text">Facebook Ad</span>
                                <span class="pull-right text-danger tran-price">-$364</span>
                                <span class="pull-right text-muted">03/09/2015</span>
                                <span class="clearfix"></span>
                            </li>

                            <li>
                                <i class="ti-download text-success"></i>
                                <span class="tran-text">New sale</span>
                                <span class="pull-right text-success tran-price">+$230</span>
                                <span class="pull-right text-muted">03/09/2015</span>
                                <span class="clearfix"></span>
                            </li>

                            <li>
                                <i class="ti-download text-success"></i>
                                <span class="tran-text">Advertising</span>
                                <span class="pull-right text-success tran-price">+$230</span>
                                <span class="pull-right text-muted">29/08/2015</span>
                                <span class="clearfix"></span>
                            </li>

                            <li>
                                <i class="ti-upload text-danger"></i>
                                <span class="tran-text">Support licence</span>
                                <span class="pull-right text-danger tran-price">-$854</span>
                                <span class="pull-right text-muted">27/08/2015</span>
                                <span class="clearfix"></span>
                            </li>


                        </ul>
                    </div>



                </div>

            </div>

            <div class="col-lg-3">
                <div class="card-box">
                    <h4 class="text-dark header-title m-t-0">Pending Verification</h4>
                    <div class="nicescroll mx-box" style="overflow: hidden;" tabindex="5000">
                        <?php foreach ($verification as $script) { ?>
                            <ul class="list-unstyled transaction-list m-r-5">
                                <li>
                                    <i class="ti-download text-success"></i>
                                    <span class="tran-text"><?php echo $script['customer_first_name'] . " " . $script['customer_last_name']; ?></span>
                                    <a class="pull-right text-success btn btn-xs btn-pinterest waves-effect waves-light" href="<?= base_url() . 'agent/members/edit_member/' . urlencode(base64_encode($script["customer_id"])) . '#upload-btn' ?>">Upload Now</a>
                                    <span class="pull-center text-muted"><?php echo date('d-m-Y', strtotime($script['customer_created_date'])); ?></span>
                                    <span class="clearfix"></span>
                                </li>
                            </ul>
                        <?php } ?>
                    </div>


                </div>

            </div>



            <div class="col-lg-6">
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
</script>
