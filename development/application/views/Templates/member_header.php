<!DOCTYPE html>
<html>
    <?php
    $user = $this->session->userdata('user_info');
    if (empty($user)) {
        redirect(base_url());
    }else if($this->session->userdata('user_info')['roll_id'] != '4'){
        redirect('/Forbidden');
    }
    ?>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="<?php echo base_url() ?>assets/logo/favicon.png">
        <title><?php echo $title; ?></title>
        <!-- Sweet Alert -->
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
        <link href="<?php echo base_url() ?>assets/css/nipl/memberstyle.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
        <script src="<?php echo base_url() ?>assets/js/modernizr.min.js"></script>
        <!-- jQuery  -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>       
        <!-- jQuery  -->
        <script src="<?php echo base_url() ?>assets/plugins/counterup/jquery.counterup.min.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/raphael/raphael-min.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/jquery-knob/jquery.knob.js"></script>
        <script src="<?php echo base_url() ?>assets/js/jquery.core.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/datatables/dataTables.bootstrap.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/datatables/dataTables.buttons.min.js"></script>
        <!-- Modal-Effect -->
        <script src="<?php echo base_url() ?>assets/plugins/custombox/js/custombox.min.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/custombox/js/legacy.min.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
        <!-- Sweet-Alert  -->
        <script src="<?php echo base_url() ?>assets/plugins/bootstrap-sweetalert/sweet-alert.min.js"></script>
        <script src="<?php echo base_url() ?>assets/pages/jquery.sweet-alert.init.js"></script>
        <!--jquery validate-->
        <script src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>
        <script src="<?php echo base_url() ?>assets/js/additional_methods.min.js"></script>
         <!-- Marked Input JS -->
        <script src="<?php echo base_url() ?>assets/js/nipl/marksedinput.js"></script>
         <!-- Marked Input cutome js -->
        <script src="<?php echo base_url() ?>assets/js/nipl/validationmask.js"></script>

    </head>
    <body class="member-screen custom-layout">
        <!-- Navigation Bar-->
        <header id="topnav">
            <div class="topbar-main">
                <div class="container">
                    <!-- Logo container-->
                    <div class="logo">
                        <a href="#" class="logo"><img src="<?= base_url() ?>assets/logo/logo2.png"></a>
                    </div>
                    <!-- End Logo container-->
                    <div class="menu-extras">
                        <ul class="nav navbar-nav navbar-right pull-right">
                            <li class="navbar-c-items">
                                <form role="search" class="navbar-left app-search pull-left hidden-xs member-search">
                                    <input type="text" placeholder="Search..." class="form-control">
                                    <a href=""><i class="fa fa-search"></i></a>
                                </form>
                            </li>
                            <li class="dropdown navbar-c-items">
                                <?php 
                                      $customerImage = '';
                                      $sql = "SELECT customer_id FROM crm_lead_member_master WHERE user_id = {$this->session->userdata('user_info')['user_id']}"; 
                                      $row = $this->db->query($sql)->row_array();
                                      if($row['customer_id'] > 0){
                                            $sql = "SELECT customer_image FROM crm_lead_member_primary WHERE customer_id = {$row['customer_id']}";
                                            $row = $this->db->query($sql)->row_array();
                                            $customerImage = $row['customer_image'];
                                      }
                                ?>
                                <a href="" class="dropdown-toggle waves-effect waves-light profile" data-toggle="dropdown" aria-expanded="true"><img src="<?php echo base_url() ?>assets/crm_image/customer_image/<?= $customerImage;?>" alt="user-img" class="img-circle"><i class="fa fa-chevron-down" aria-hidden="true"></i> </a>
                                <!--<a href="" class="dropdown-toggle waves-effect waves-light profile" data-toggle="dropdown" aria-expanded="true"><img src="<?php echo base_url() ?>assets/images/users/avatar-1.jpg" alt="user-img" class="img-circle"> </a>-->
                                <ul class="dropdown-menu">
                                    <li><a href="<?= base_url() . 'member/profile' ?>"><i class="ti-user text-custom m-r-10"></i> Profile & Setting </a></li>
                                    <li><a href="<?= base_url() . 'user/change_password' ?>"><i class="ti-lock text-custom m-r-10"></i> Change Password</a></li>
                                    <li class="divider"></li>
                                    <li><a href="<?= base_url() . 'login/logout' ?>"><i class="ti-power-off text-danger m-r-10"></i> Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                        <div class="menu-item">
                            <!-- Mobile menu toggle-->
                            <a class="navbar-toggle">
                                <div class="lines">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </a>
                            <!-- End mobile menu toggle-->
                        </div>
                    </div>
                    <div class="chat-box">
                        <div class="box-item">
                            <p class="title">Click Here to Chat... </p> <a href="#"><img src="<?php echo base_url() ?>assets/header-images/chat.png" alt="Chat" style="padding: 10px 0px;"></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="navbar-custom custom-header">
                <div class="container">
                    <div id="navigation">
                        <!-- Navigation Menu-->
                        <ul class="navigation-menu">
                            <li class="has-submenu">
                                <a href="<?= base_url() . 'member/dashboard' ?>"><img src="<?php echo base_url() ?>assets/header-images/home.png" alt="dashboard"><span>Dashboard</span></a>
                            </li>

                            <li class="has-submenu">
                                <a href="#"><img src="<?php echo base_url() ?>assets/header-images/price-tag.png" alt="Providers"><span>Providers</span></a>
                            </li>

                            <li class="has-submenu">
                                <a href="#"><img src="<?php echo base_url() ?>assets/header-images/eye.png" alt="Products"></i><span>Products</span></a>
                            </li>

                            <li class="has-submenu">
                                <a href="<?= base_url() . 'member/profile' ?>"><img src="<?php echo base_url() ?>assets/header-images/capsl.png" alt="Profile"><span>Profile<span></a>
                            </li>

                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li><i class="fa fa-phone" aria-hidden="true"></i><span>1(855)460-8953</span></li>
                            <li><i class="fa fa-envelope-o" aria-hidden="true"></i><span><?php echo $this->session->userdata['user_info']['email']; ?></span></li>
                        </ul>

                        <!-- End navigation menu-->
                    </div>
                </div> <!-- end container -->
            </div> <!-- end navbar-custom -->
        </header>
        <!-- End Navigation Bar-->
        <div class="member-body">
        <?php echo $body ?>
        </div>
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

            jQuery(document).ready(function ($) {
                $('.counter').counterUp({
                    delay: 100,
                    time: 1200
                });
                $(".knob").knob();
            });
            (function ($) {

                'use strict';

                function initNavbar() {
                    console.log('method called');
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