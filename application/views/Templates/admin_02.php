<!DOCTYPE html>
<html lang="en">
    <head>
        <link href="assets/images/spotfav.png" rel='shortcut icon' type='image/x-icon'/>
        <?php 
            $this->load->view('Templates/admin_common_head');
        ?>
        <!-- <link href="assets/fonts/font-awesome-4.6.3/css/font-awesome.min.css" rel="stylesheet" type="text/css"> -->
        <!-- Core JS files -->
        <script type="text/javascript" src="assets/admin/js/plugins/loaders/pace.min.js"></script>
        <!-- <script type="text/javascript" src="assets/admin/js/jquery.validate.js"></script> -->
        <!-- /core JS files -->
        <script>
            var site_url = "<?php echo site_url() ?>";
            var base_url = "<?php echo base_url() ?>";
        </script>
		
    </head>
    <body>
    <!-- Main navbar -->
    <?php $logged_user_detail = $this->session->userdata('user'); ?>
    <div class="navbar navbar-inverse">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?php echo site_url('admin'); ?>" style="font-size: 17px;">
                <!-- <img width="209" src="assets/images/spotashoot.com.png" alt=""> -->
                Mayank Demo
            </a>
            <ul class="nav navbar-nav visible-xs-block">
                <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
                <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
            </ul>
        </div>
        <div class="navbar-collapse collapse" id="navbar-mobile">
            <ul class="nav navbar-nav">
                <li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown dropdown-user">
                    <a class="dropdown-toggle" data-toggle="dropdown">
                        <img src="assets/admin/images/placeholder.jpg" alt="">
                        <span><?php echo $logged_user_detail['username'] ?></span>
                        <i class="caret"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><a href="<?php echo site_url('change_profile'); ?>"><i class="icon-pencil"></i>Change Profile</a></li>
                        <li><a href="<?php echo site_url('change_password'); ?>"><i class="icon-lock"></i>Change Password</a></li>
                        <li><a href="<?php echo site_url('login/logout'); ?>"><i class="icon-switch2"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <!-- /main navbar -->
    <!-- Page container -->
    <div class="page-container">
        <!-- Page content -->
            <div class="page-content">
            <!-- Main sidebar -->
            <div class="sidebar sidebar-main">
                <div class="sidebar-content">
                    <!-- Main navigation -->
                    <div class="sidebar-category sidebar-category-visible">
                        <div class="category-content no-padding">
                            <?php
                                $logged_user_detail['user_role_id'];
                                $get_links = user_template_links($logged_user_detail['user_role_id']);
                            ?>
                            <ul class="navigation navigation-main navigation-accordion">
                                <?php 
                                    $controller = $this->uri->segment(1); 
                                    $action = $this->router->fetch_method(); 
                                    ?>
                                    <li class="<?php echo ($controller == 'dashboard') ? 'active' : ''; ?>"><a href="dashboard"><i class="icon-home4"></i> <span>Dashboard</span></a></li>
                                    <?php
                                    foreach ($get_links as $key => $value) {
                                        if($value['is_sidebar_link'] == true) {
                                        ?>
                                            <li class="<?php echo ($controller == $value['url']) ? 'active' : ''; ?>"><a href="<?php echo $value['url'] ?>"><i class="<?php echo $value['icon'] ?>"></i> <span><?php echo $value['name'] ?></span></a></li>
                                        <?php
                                        }
                                    }
                                ?>
                                <li class=""><a href="logout"><i class="icon-switch2"></i> <span>Logout</span></a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- /main navigation -->
                </div>
            </div>
            <div class="content-wrapper">
            <!-- Page header -->
            <?php echo $body; ?>
            </div>
        </div>
    </div>
    <!-- <div class="loading"><div class="loading-div"><img src="assets/images/loader1.gif"></div></div> -->
    <!-- /page container -->
</body>
</html>
