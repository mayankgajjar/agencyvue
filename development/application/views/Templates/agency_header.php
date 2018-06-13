<!DOCTYPE html>
<html>
    <?php
    $user = $this->session->userdata('user_info');
    if (empty($user)) {
        redirect(base_url());
    } else if ($this->session->userdata('user_info')['roll_id'] != '5') {
        redirect('/Forbidden');
    }
    ?>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Clayton White">
        <link rel="shortcut icon" href="<?php echo base_url() ?>assets/logo/favicon.png">
        <title><?php echo $title; ?></title>
        <link href="<?php echo base_url() ?>assets/plugins/bootstrap-sweetalert/sweet-alert.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/css/menu.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/css/responsive.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url() ?>assets/plugins/datatables/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url() ?>assets/css/ac-style.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
        <script src="<?php echo base_url() ?>assets/js/modernizr.min.js"></script>
        <link href="<?php echo base_url() ?>assets/plugins/jvectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/waypoints/lib/jquery.waypoints.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/raphael/raphael-min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/jquery.slimscroll.js"></script>
        <script src="<?php echo base_url() ?>assets/js/jquery.nicescroll.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/jquery-knob/jquery.knob.js"></script>
        <script src="<?php echo base_url() ?>assets/js/jquery.core.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/datatables/dataTables.bootstrap.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/datatables/dataTables.buttons.min.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/custombox/js/custombox.min.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/custombox/js/legacy.min.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/bootstrap-sweetalert/sweet-alert.min.js"></script>
        <script src="<?php echo base_url() ?>assets/pages/jquery.sweet-alert.init.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/plugins/parsleyjs/parsley.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/plugins/parsleyjs/parsley.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/nipl/marksedinput.js"></script>
        <script src="<?php echo base_url() ?>assets/js/nipl/validationmask.js"></script>
        <link href="<?php echo base_url() ?>assets/plugins/jstree/style.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url() ?>assets/plugins/jstree/jstree.min.js"></script>
        <script src="<?php echo base_url() ?>assets/pages/jquery.tree.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js" type="text/javascript"></script>
        <link href="<?php echo base_url() ?>assets/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url() ?>assets/plugins/select2/js/select2.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>assets/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
        <link href="<?php echo base_url() ?>assets/plugins/ion-rangeslider/ion.rangeSlider.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url() ?>assets/plugins/ion-rangeslider/ion.rangeSlider.skinFlat.css" rel="stylesheet" type="text/css"/>
        <script src="<?php echo base_url() ?>assets/plugins/ion-rangeslider/ion.rangeSlider.min.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/bootstrap-slider/js/bootstrap-slider.min.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
        <link href="<?php echo base_url() ?>assets/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css" rel="stylesheet" />
        <script src="<?php echo base_url() ?>assets/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.min.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/tinymce/tinymce.min.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/jvectormap/gdp-data.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/jvectormap/jquery-jvectormap-us-aea-en.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/jvectormap/jquery-jvectormap-us-il-chicago-mill-en.js"></script>
    </head>

    <body>
        <header id="topnav">
            <div class="topbar-main">
                <div class="container">
                    <div class="logo">
                        <a href="#" class="logo"><img src="<?= base_url() ?>assets/logo/logoVTW.png"></a>
                    </div>
                    <?php $boberdooId = getBoberdooUserIdForAgency() ?>
                    <div class="menu-extras">
                        <ul class="nav navbar-nav navbar-right pull-right">
                            <li class="navbar-c-items">
                                <form role="search" class="navbar-left app-search pull-left hidden-xs">
                                    <input type="text" placeholder="Search..." class="form-control">
                                    <a href=""><i class="fa fa-search"></i></a>
                                </form>
                            </li>
                            <li class="dropdown navbar-c-items">
                                <a href="" class="dropdown-toggle waves-effect waves-light profile" data-toggle="dropdown" aria-expanded="true"><img src="<?php echo base_url() ?>assets/crm_image/agencieslogo/<?= $this->session->userdata['agency_profile_img']; ?>" alt="user-img" class="img-circle"> </a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?= base_url() . 'agency/profile' ?>"><i class="ti-user text-custom m-r-10"></i> Profile & Setting </a></li>
                                    <li><a href="<?= base_url() . 'agency/members/charges' ?>"><i class="fa fa-cc-stripe text-custom m-r-10"></i> Charges Per Active Member </a></li>
                                    <li><a href="#"><i class="ti-lock text-custom m-r-10"></i> Change Password</a></li>
                                    <?php if($boberdooId == ''): ?>
                                    <li>
                                        <a href="<?php echo site_url('agency/campaign/createpartner') ?>"><i class="ti-user text-custom m-r-10"></i><?php echo 'Create Lead Store Account' ?></a>
                                    </li>
                                    <?php endif; ?>
                                    <li class="divider"></li>
                                    <li><a href="<?= base_url() . 'login/logout' ?>"><i class="ti-power-off text-danger m-r-10"></i> Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                        <div class="menu-item">
                            <a class="navbar-toggle">
                                <div class="lines">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="navbar-custom">
                <div class="container">
                    <div id="navigation">
                        <ul class="navigation-menu">
                            <li class="has-submenu <?php echo ($this->uri->segment(2) == 'dashboard') ? 'active' : ''; ?>">
                                <a href="<?= base_url() . 'agency/dashboard' ?>"><i class="glyphicon glyphicon-stats"></i>Dashboard</a>
                            </li>
                            <li class="has-submenu <?php echo ($this->uri->segment(2) == 'leads') ? 'active' : ''; ?>">
                                <a href="<?= base_url() . 'agency/leads' ?>"><i class="glyphicon glyphicon-leaf"></i>Lead</a>
                            </li>
                            <li class="has-submenu <?php echo ($this->uri->segment(2) == 'members') ? 'active' : ''; ?>">
                                <a href="<?= base_url() . 'agency/members' ?>"><i class="glyphicon glyphicon-user"></i>Clients</a>
                            </li>
                            <li class="has-submenu">
                                <a href="<?php echo site_url("agency/campaign/index") ?>"><i class="fa fa-server" aria-hidden="true"></i><?php echo "Lead Store" ?></a>
                            </li>
                            <li class="has-submenu <?php echo ($this->uri->segment(2) == 'employers') ? 'active' : ''; ?>">
                                <a href="<?php echo base_url() . 'agency/employers' ?>"><i class="fa fa-institution"></i>Employer</a>
                                <ul class="submenu">
                                    <li><a href="#">Manage Employer</a></li>
                                    <li><a href="#">Unapproved Employer</a></li>
                                </ul>
                            </li>

                            <li class="has-submenu <?php echo ($this->uri->segment(2) == 'agents') ? 'active' : ''; ?>">
                                <a href="<?= base_url() . 'agency/agents' ?>"><i class="glyphicon glyphicon-briefcase"></i>Agents</a>
                            </li>

                            <li class="has-submenu <?php echo ($this->uri->segment(2) == 'subagencies') ? 'active' : ''; ?>">
                                <a href="<?= base_url() . 'agency/subagencies' ?>"><i class="fa fa-sitemap"></i>Sub Agencies</a>
                            </li>

<!--                            <li class="has-submenu <?php echo ($this->uri->segment(2) == 'vendors') ? 'active' : ''; ?>">

                                <a href="#"><i class="fa fa-building-o"></i>Vendors</a>

                            </li>

                            <li class="has-submenu <?php echo ($this->uri->segment(2) == 'products') ? 'active' : ''; ?>">

                                <a href="#"><i class="glyphicon glyphicon-tags"></i>Products</a>

                            </li>

                            <li class="has-submenu <?php echo ($this->uri->segment(2) == 'billing') ? 'active' : ''; ?>">

                                <a href="#"><i class="fa fa-credit-card-alt"></i>Billing</a>

                            </li>-->

                            <li class="has-submenu <?php echo ($this->uri->segment(2) == 'verifications') ? 'active' : ''; ?>">
                                <a href="<?= base_url() . 'agency/verification' ?>"><i class="glyphicon glyphicon-hdd"></i>Verifications</a>
                            </li>

                            <li class="has-submenu <?php echo ($this->uri->segment(2) == 'reports') ? 'active' : ''; ?>">
                                <a href="#"><i class="glyphicon glyphicon-list-alt"></i>Report</a>
                            </li>

                            <li class="has-submenu <?php echo ($this->uri->segment(2) == 'settings') ? 'active' : ''; ?>">
                                <a href="#"><i class="fa fa-cog"></i>Settings</a>
                                <ul class="submenu">
                                    <li class="<?php echo ($this->uri->segment(2) == 'products') ? 'active' : ''; ?>"> <a href="<?= base_url() . 'agency/products' ?>"><i class="glyphicon glyphicon-tags"></i> Products </a></li>
                                    <li class="<?php echo ($this->uri->segment(2) == 'products') ? 'active' : ''; ?>"> <a href="<?= base_url() . 'agency/products/categories' ?>"><i class="glyphicon glyphicon-tags"></i> Product Categories </a></li>
                                    <li class="<?php echo ($this->uri->segment(2) == 'products') ? 'active' : ''; ?>"> <a href="<?= base_url() . 'agency/products/types' ?>"><i class="glyphicon glyphicon-tags"></i> Products Types </a></li>
                                    <li class="<?php echo ($this->uri->segment(2) == 'products') ? 'active' : ''; ?>"> <a href="<?= base_url() . 'agency/products/coveragetype' ?>"><i class="glyphicon glyphicon-tags"></i> Products Coverage Type </a></li>
                                    <li class="<?php echo ($this->uri->segment(2) == 'vendors') ? 'active' : ''; ?>"><a href="#"><i class="fa fa-building-o"></i> Vendors </a></li>
                                    <li class="<?php echo ($this->uri->segment(2) == 'billing') ? 'active' : ''; ?>"><a href="#"><i class="fa fa-credit-card-alt"></i> Billing </a></li>
                                    <li class="<?php echo ($this->uri->segment(3) == 'blukleadupload') ? 'active' : ''; ?>"><a href="<?= base_url() . 'admin/settings/blukleadupload' ?>">Bulk Lead Upload</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        <?php echo $body ?>
        <footer class="footer text-right">
            <div class="container">
                <div class="row">
                    <div class="col-xs-6">
                        © 2017. All rights reserved.
                    </div>
                    <div class="col-xs-6">
                        <ul class="pull-right list-inline m-b-0">
                            <li>
                                <a href="#">About</a>
                            </li>
                            <li>
                                <a href="#">Help</a>
                            </li>
                            <li>
                                <a href="#">Contact</a>
                            </li>

                        </ul>

                    </div>

                </div>

            </div>

        </footer>

        <script type="text/javascript">
            var today = new Date();
            $(function () {
                $('.dtpicker').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    endDate: "today",
                    maxDate: today
                });
            });

            $(function () {

                $('.multiple').datepicker({
                    clearBtn: true,
                    multidate: true,
                    multidateSeparator: ",",
                    endDate: "today",
                    maxDate: today
                });

            });

            (function ($) {
                'use strict';
                function initNavbar() {
                    $('.navbar-toggle').on('click', function (event) {
                        $(this).toggleClass('open');
                        $('#navigation').slideToggle(400);
                    });
                    $('.navigation-menu>li').slice(-1).addClass('last-elements');
                    $('.navigation-menu li.has-submenu a[href="#"]').on('click', function (e) {
                        if ($(window).width() < 992) {
                            e.preventDefault();
                            $(this).parent('li').toggleClass('open').find('.submenu:first').toggleClass('open');
                        }
                    });
                }
                function init() {
                    initNavbar();
                }
                init();
            })(jQuery);

        </script>

    </body>

</html>