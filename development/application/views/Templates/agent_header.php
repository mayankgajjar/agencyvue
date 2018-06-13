<!DOCTYPE html>
<html>
    <?php
    $user = $this->session->userdata('user_info');
    if (empty($user)) {
        redirect(base_url());
    }
    ?>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="<?php echo base_url() ?>assets/logo/favicon.png">
        <title><?php echo $title; ?></title>
        <!-- Sweet Alert -->
        <link href="<?php echo base_url() ?>assets/plugins/jvectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
        <link href="<?php echo base_url() ?>assets/plugins/bootstrap-sweetalert/sweet-alert.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url() ?>assets/plugins/jquery.steps/css/jquery.steps.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/css/menu.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/css/responsive.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url() ?>assets/plugins/datatables/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url() ?>assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/css/ac-style.css" rel="stylesheet" type="text/css" />
        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->


        <!-- jQuery  -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<!--        <script
                          src="https://code.jquery.com/jquery-3.2.1.js"
                          integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
                          crossorigin="anonymous"></script>-->
        <!-- jQuery  -->
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/detect.js"></script>
        <script src="<?php echo base_url() ?>assets/js/fastclick.js"></script>
        <script src="<?php echo base_url() ?>assets/js/jquery.blockUI.js"></script>
        <script src="<?php echo base_url() ?>assets/js/waves.js"></script>
        <script src="<?php echo base_url() ?>assets/js/wow.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/jquery.scrollTo.min.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/jvectormap/gdp-data.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/jvectormap/jquery-jvectormap-us-aea-en.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/jvectormap/jquery-jvectormap-us-il-chicago-mill-en.js"></script>
        <!-- <script src="<?php echo base_url() ?>assets/plugins/jvectormap/jquery-jvectormap-uk-mill-en.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/jvectormap/jquery-jvectormap-au-mill.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/jvectormap/jquery-jvectormap-ca-lcc.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/jvectormap/jquery-jvectormap-de-mill.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/jvectormap/jquery-jvectormap-in-mill.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/jvectormap/jquery-jvectormap-asia-mill.js"></script>
        <script src="<?php echo base_url() ?>assets/pages/jvectormap.init.js"></script>-->
        <script src="<?php echo base_url() ?>assets/js/modernizr.min.js"></script>

        <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
        <!-- jQuery  -->
        <script src="<?php echo base_url() ?>assets/plugins/waypoints/lib/jquery.waypoints.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/counterup/jquery.counterup.min.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/raphael/raphael-min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/jquery.slimscroll.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/jquery-knob/jquery.knob.js"></script>
        <script src="<?php echo base_url() ?>assets/js/jquery.core.js"></script>
        <!-- Parsly js -->
        <script type="text/javascript" src="<?php echo base_url() ?>assets/plugins/parsleyjs/parsley.min.js"></script>
        <!-- Parsly js -->
        <script type="text/javascript" src="<?php echo base_url() ?>assets/plugins/parsleyjs/parsley.min.js"></script>
        <!-- dataTables -->
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
        <!-- Marked Input JS -->
        <script src="<?php echo base_url() ?>assets/js/nipl/marksedinput.js"></script>
        <!-- Marked Input cutome js -->
        <script src="<?php echo base_url() ?>assets/js/nipl/validationmask.js"></script>
        <!-- Tree View Resource -->
        <link href="<?php echo base_url() ?>assets/plugins/jstree/style.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url() ?>assets/plugins/jstree/jstree.min.js"></script>
        <script src="<?php echo base_url() ?>assets/pages/jquery.tree.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js" type="text/javascript"></script>
        <!-- switchery-->
        <link href="<?php echo base_url() ?>assets/plugins/switchery/css/switchery.min.css" rel="stylesheet" />
        <script src="<?php echo base_url() ?>assets/plugins/switchery/js/switchery.min.js"></script>
        <!-- Select 2 resourse -->
        <link href="<?php echo base_url() ?>assets/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url() ?>assets/plugins/select2/js/select2.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>assets/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
        <!-- ION Slider -->
        <link href="<?php echo base_url() ?>assets/plugins/ion-rangeslider/ion.rangeSlider.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url() ?>assets/plugins/ion-rangeslider/ion.rangeSlider.skinFlat.css" rel="stylesheet" type="text/css"/>
        <script src="<?php echo base_url() ?>assets/plugins/ion-rangeslider/ion.rangeSlider.min.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/bootstrap-slider/js/bootstrap-slider.min.js"></script>
        <!-- Input Lenth -->
        <script src="<?php echo base_url() ?>assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
        <!-- tag input -->
        <link href="<?php echo base_url() ?>assets/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css" rel="stylesheet" />
        <script src="<?php echo base_url() ?>assets/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/jquery.app.js"></script>
        <script src="<?php echo base_url() ?>assets/js/jquery.nicescroll.js"></script>
    </head>
    <body>
        <!-- Navigation Bar-->
        <header id="topnav">
            <div class="topbar-main">
                <div class="container">
                    <!-- Logo container-->
                    <div class="logo">
                        <a href="#" class="logo"><img src="<?= base_url() ?>assets/logo/logoVTW.png"></a>
                    </div>
                    <!-- End Logo container-->
                    <?php $boberdooId = getBoberdooUserId() ?>
                    <div class="menu-extras">
                        <ul class="nav navbar-nav navbar-right pull-right">
                            <li class="navbar-c-items">
                                <form role="search" class="navbar-left app-search pull-left hidden-xs">
                                    <input type="text" placeholder="Search..." class="form-control">
                                    <a href=""><i class="fa fa-search"></i></a>
                                </form>
                            </li>

                            <li class="dropdown navbar-c-items">
                                <a href="" class="dropdown-toggle waves-effect waves-light profile" data-toggle="dropdown" aria-expanded="true"><img src="<?php echo base_url() ?>assets/crm_image/agent_profile/<?php echo (isset($this->session->userdata['agent_profile_img']) && $this->session->userdata['agent_profile_img'] != "" ) ? $this->session->userdata['agent_profile_img'] : "basicpc.jpg"; ?>" alt="user-img" class="img-circle"> </a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?= base_url() . 'agent/profile' ?>"><i class="ti-user text-custom m-r-10"></i> Profile & Setting </a></li>
                                    <li><a href="<?= base_url() . 'user/change_password' ?>"><i class="ti-lock text-custom m-r-10"></i> Change Password</a></li>
                                    <?php if($boberdooId == 0): ?>
                                    <li>
                                        <a href="<?php echo site_url('agent/campaign/createpartner') ?>"><i class="ti-user text-custom m-r-10"></i><?php echo 'Create Lead Store Account' ?></a>
                                    </li>
                                    <?php endif; ?>
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
                </div>
            </div>
            <div class="navbar-custom">
                <div class="container">
                    <div id="navigation">
                        <!-- Navigation Menu-->
                        <ul class="navigation-menu">
                            <li class="has-submenu <?php echo ($this->uri->segment(2) == 'dashboard') ? 'active' : ''; ?>">
                                <a href="<?= base_url() . 'agent/dashboard' ?>"><i class="glyphicon glyphicon-stats"></i>Dashboard</a>
                            </li>

                            <li class="">
                                <a href="<?php echo 'http://pd1134.rmsleadconsulting.com/agc/vicidial.php' ?>" target="_blank"><i class="fa fa-phone"></i><?php echo 'Dialer' ?></a>
                            </li>



                            <li class="has-submenu <?php echo ($this->uri->segment(2) == 'leads') ? 'active' : ''; ?>">
                                <a href="<?= base_url() . 'agent/leads' ?>"><i class="glyphicon glyphicon-leaf"></i>Leads</a>
                            </li>

                            <li class="has-submenu <?php echo ($this->uri->segment(2) == 'members') ? 'active' : ''; ?>">
                                <a href="<?= base_url() . 'agent/members' ?>"><i class="glyphicon glyphicon-user"></i>Clients</a>
                            </li>

                            <li class="has-submenu">
                                <a href="<?php echo site_url("agent/campaign/index") ?>"><i class="fa fa-server" aria-hidden="true"></i><?php echo "Lead Store" ?></a>
                            </li>
                            <?php /*
                            <li class="has-submenu <?php echo ($this->uri->segment(2) == 'employers') ? 'active' : ''; ?>">
                                <a href="<?= base_url() . 'agent/employers' ?>"><i class="fa fa-institution"></i>Employers</a>
                            </li>

                            <li class="has-submenu <?php echo ($this->uri->segment(2) == 'ManageAgents') ? 'active' : ''; ?>">
                                <a href="<?= base_url() . 'agent/ManageAgents' ?>"><i class="glyphicon glyphicon-briefcase"></i>Agents</a>
                            </li>
                            <li class="has-submenu <?php echo ($this->uri->segment(2) == 'agencies') ? 'active' : ''; ?>">
                                <a href="<?= base_url() . 'agent/agencies' ?>"><i class="fa fa-sitemap"></i>Agencies</a>
                            </li>
                            */ ?>
                            <li class="has-submenu <?php echo ($this->uri->segment(2) == 'quote') ? 'active' : ''; ?>">
                                <a href="<?= base_url() . 'agent/quote' ?>"><i class="glyphicon glyphicon-usd"></i>Quote/Sale</a>

                            </li>

<!--                             <li class="has-submenu">
                                <a href="#"><i class="glyphicon glyphicon-hdd"></i>Verification </a>
                            </li> -->

                            <li class="has-submenu">
                                <a href="#"><i class="glyphicon glyphicon-list"></i>Report</a>
                            </li>

                            <li class="has-submenu <?php echo ($this->uri->segment(2) == 'settings') ? 'active' : ''; ?>">
                                <a href="#"><i class="fa fa-cog"></i>Settings</a>
                                <ul class="submenu">
                                    <li>
                                        <a href="<?= base_url() . 'agent/ManageAgents' ?>"><i class="glyphicon glyphicon-briefcase"></i>&nbsp;Agents</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url() . 'agent/agencies' ?>"><i class="fa fa-sitemap"></i>&nbsp;Agencies</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url() . 'agent/employers' ?>"><i class="fa fa-institution"></i>&nbsp;Employers</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url() . 'agent/settings/verification' ?>"><i class="glyphicon glyphicon-hdd"></i>&nbsp;Verification</a>
                                    </li>
                                    <li><a class="target_model" data-toggle="modal" data-target="#target_model" style="cursor: pointer;"><i class="fa fa-check-circle-o"></i>&nbsp;Target Setting </a></li>
                                    <li><a href="<?= base_url() . 'admin/settings/blukleadupload' ?>"><i class="fa fa-upload"></i>&nbsp;Bulk Lead Upload</a></li>
                                    <li><a href="<?= base_url() . 'agent/products' ?>"><i class="glyphicon glyphicon-tags"></i>&nbsp;Products</a></li>
                                </ul>
                            </li>
                        </ul>
                        <!-- End navigation menu        -->
                    </div>
                </div> <!-- end container -->
            </div> <!-- end navbar-custom -->
        </header>
        <!-- End Navigation Bar-->
        <?php echo $body ?>
        <div id="target_model" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <form id="target_form" method="post" class="target_form_custom">
                    <div class="modal-content p-0">
                        <ul class="nav nav-tabs navtab-bg nav-justified">
                            <li class="active">
                                <a href="#members" data-toggle="tab" aria-expanded="false">
                                    <span class="visible-xs"><i class="fa fa-envelope-o"></i></span>
                                    <span class="hidden-xs">Client</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="#commission" data-toggle="tab" aria-expanded="false">
                                    <span class="visible-xs"><i class="fa fa-user"></i></span>
                                    <span class="hidden-xs">Commission</span>
                                </a>
                            </li>
                            <li class="">
                                <a href="#premium" data-toggle="tab" aria-expanded="true">
                                    <span class="visible-xs"><i class="fa fa-home"></i></span>
                                    <span class="hidden-xs">Premium</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="members">
                                <div id="type_members_wapper" class="target_setting_wapper">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-8">
                                                <label>Current Clients Target</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <input type="text" class="form-control agent_target_val" id="agent_target_val_members" name="agent_target_members" value="<?php echo(isset($this->session->userdata['member_target'])) ? $this->session->userdata['member_target']['target_value'] : '' ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <select name="members_range" class="form-control">
                                                <option value="daily" <?php
                                                if (isset($this->session->userdata['member_target']['target_range'])) {
                                                    echo ($this->session->userdata['member_target']['target_range'] == 'daily') ? 'selected' : '';
                                                }
                                                ?>> Daily </option>
                                                <option value="weekly" <?php
                                                if (isset($this->session->userdata['member_target']['target_range'])) {
                                                    echo ($this->session->userdata['member_target']['target_range'] == 'weekly') ? 'selected' : '';
                                                }
                                                ?>> Weekly </option>
                                                <option value="monthly" <?php
                                                if (isset($this->session->userdata['member_target']['target_range'])) {
                                                    echo ($this->session->userdata['member_target']['target_range'] == 'monthly') ? 'selected' : '';
                                                }
                                                ?>> Monthly </option>
                                                <option value="quarterly"  <?php
                                                if (isset($this->session->userdata['member_target']['target_range'])) {
                                                    echo ($this->session->userdata['member_target']['target_range'] == 'quarterly') ? 'selected' : '';
                                                }
                                                ?>> Quarterly </option>
                                                <option value="yearly" <?php
                                                if (isset($this->session->userdata['member_target']['target_range'])) {
                                                    echo ($this->session->userdata['member_target']['target_range'] == 'yearly') ? 'selected' : '';
                                                }
                                                ?>> Yearly </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="commission">
                                <div id="type_commission_wapper" class="target_setting_wapper">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-8">
                                                <label>Current Commission Target Value</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <input type="text" class="form-control agent_target_val" id="agent_target_val_commission" name="agent_target_commission" value="">
                                        </div>
                                        <div class="col-md-6">
                                            <select name="commission_range" class="form-control">
                                                <option value="daily"> Daily </option>
                                                <option value="weekly"> Weekly </option>
                                                <option value="monthly"> Monthly </option>
                                                <option value="quarterly"> Quarterly </option>
                                                <option value="yearly"> Yearly </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="premium">
                                <div id="type_premium_wapper" class="target_setting_wapper">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-8">
                                                <label>Current Premium Target</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <input type="text" class="form-control agent_target_val" id="agent_target_val_premium" name="agent_target_premium" value="<?php echo(isset($this->session->userdata['premium_target'])) ? $this->session->userdata['premium_target']['target_value'] : '' ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <select name="premium_range" class="form-control">
                                                <option value="daily" <?php
                                                if (isset($this->session->userdata['premium_target']['target_range'])) {
                                                    echo ($this->session->userdata['premium_target']['target_range'] == 'daily') ? 'selected' : '';
                                                }
                                                ?>> Daily </option>
                                                <option value="weekly" <?php
                                                if (isset($this->session->userdata['premium_target']['target_range'])) {
                                                    echo ($this->session->userdata['premium_target']['target_range'] == 'weekly') ? 'selected' : '';
                                                }
                                                ?>> Weekly </option>
                                                <option value="monthly" <?php
                                                if (isset($this->session->userdata['premium_target']['target_range'])) {
                                                    echo ($this->session->userdata['premium_target']['target_range'] == 'monthly') ? 'selected' : '';
                                                }
                                                ?>> Monthly </option>
                                                <option value="quarterly"  <?php
                                                if (isset($this->session->userdata['premium_target']['target_range'])) {
                                                    echo ($this->session->userdata['premium_target']['target_range'] == 'quarterly') ? 'selected' : '';
                                                }
                                                ?>> Quarterly </option>
                                                <option value="yearly" <?php
                                                if (isset($this->session->userdata['premium_target']['target_range'])) {
                                                    echo ($this->session->userdata['premium_target']['target_range'] == 'yearly') ? 'selected' : '';
                                                }
                                                ?>> Yearly </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn target_set btn-primary waves-effect waves-light">Save changes</button>
                        </div>
                    </div><!-- /.modal-content -->
                </form>
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
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
        <style>
            #target_model .modal-footer {
                border-top: none;
                padding: 26px;
                padding-top: 31px;
                text-align: center;
            }
        </style>
        <script type="text/javascript">
            jQuery(".agent_target_val").on("keyup", function () {
                var valid = /^\d{0,4}(\.\d{0,2})?$/.test(this.value),
                        val = this.value;

                if (!valid) {
                    console.log("Invalid input!");
                    this.value = val.substring(0, val.length - 1);
                }
            });
            jQuery(document).on('submit', "#target_form", function (event) {
                event.preventDefault();
                save_lead('target_form');
            });
            function save_lead(form_id) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() ?>agent/settings/target_setting",
                    data: $(document).find("#" + form_id).serialize(),
                    success: function (data) {
                        $('#target_model').modal('hide');
                        swal({
                            title: "Done",
                            text: "Targets Are Set Successfully",
                            type: "success"
                        }, function () {
                            location.reload();
                        });
                    },
                });
            }
//            jQuery('#target_form').on('submit', function (e) {
//                e.preventDefault();
//                var agent_target = jQuery('#agent_target_val').val();
//                if (agent_target == '') {
//                    swal("error", 'Please Insert Target Value', "error");
//                } else {
//                    jQuery.ajax({
//                        method: "POST",
//                        url: '<?php echo base_url(); ?>agent/profile/set_target_nav_memu',
//                        data: {agent_target: agent_target},
//                        success: function (data) {
//                            if (data) {
//                                swal({title: "Target Updated", text: "Agent Target Value Updated !", type: "success"},
//                                        function () {
//                                            location.reload();
//                                        }
//                                );
//                            } else {
//                                swal("error", 'Something Went Worng ', "error");
//                            }
//                        }
//                    });
//                }
//            });
            jQuery(document).on('click', '#target_set', function (e) {
                var product_id = $(this).data("custom-value-productid");
                var member_id = $(this).data("custom-value-memberid");
                var key_id = $(this).data("id");
                $.ajax({
                    method: "POST",
                    url: '<?php echo base_url() ?>agent/members/removeproduct',
                    data: {product: product_id, member: member_id},
                    success: function (data) {
                        swal("success", data, "success");
                        $(".pro-add-" + key_id).attr("disabled", false);
                        $(".pro-remove-" + key_id).attr("disabled", true);
                        $.fn.niceScroll && $(".nicescroll").niceScroll({cursorcolor: '#98a6ad', cursorborder: '#98a6ad', cursorwidth: '5px', cursorborderradius: '5px'});
                    }
                });
            });
            var today = new Date();
            $(function () {
                $('.dtpicker').datepicker({
                    autoclose: true,
                    todayHighlight: true,
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