<!DOCTYPE html>

<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">
        <!-- App Favicon icon -->

        <link rel="shortcut icon" href="<?php echo base_url() ?>assets/logo/favicon.png">

        <!-- App Title -->

        <title><?= $title; ?></title>

        <!--Form Wizard-->
        
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/plugins/jquery.steps/css/jquery.steps.css" />
        <link href="<?php echo base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/css/menu.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/css/ac-style.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/css/responsive.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css" rel="stylesheet" />
        <script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
         <script src="<?php echo base_url() ?>assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js" type="text/javascript"></script>
        <!-- Sweet Alert -->
        <link href="<?php echo base_url() ?>assets/plugins/bootstrap-sweetalert/sweet-alert.css" rel="stylesheet" type="text/css">
        <!-- Sweet-Alert  -->
        <script src="<?php echo base_url() ?>assets/plugins/bootstrap-sweetalert/sweet-alert.min.js"></script>
        <script src="<?php echo base_url() ?>assets/pages/jquery.sweet-alert.init.js"></script>
        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->

        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

        <!--[if lt IE 9]>

        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>

        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>

        <![endif]-->

        <script src="<?php echo base_url() ?>assets/js/modernizr.min.js"></script>
         <!-- Parsly js -->
        <script type="text/javascript" src="<?php echo base_url() ?>assets/plugins/parsleyjs/parsley.min.js"></script>


    </head>

    <body>

        <!-- Navigation Bar-->

        <header id="topnav">

            <div class="topbar-main" style="float: none">

                <div class="container">

                    <!-- Logo container-->

                    <div class="logo text-center">

                        <a href="index.html" class="logo"><img src="<?= base_url() ?>assets/logo/logoVTW.png"></a>

                    </div>

                    <!-- End Logo container-->

                </div>

            </div>

        </header>

        <!-- End Navigation Bar-->

        <?php echo $body ?>

        <!-- Footer -->

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

        <!-- End Footer -->



    </div> <!-- end container -->

</div>

<!-- end wrapper -->

<!-- jQuery  -->

<script src="<?php echo base_url() ?>assets/js/detect.js"></script>
<script src="<?php echo base_url() ?>assets/js/fastclick.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.slimscroll.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.blockUI.js"></script>
<script src="<?php echo base_url() ?>assets/js/waves.js"></script>
<script src="<?php echo base_url() ?>assets/js/wow.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.nicescroll.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<!--Form Wizard-->

<script src="<?php echo base_url() ?>assets/plugins/jquery.steps/js/jquery.steps.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/plugins/jquery-validation/js/jquery.validate.min.js"></script>

<!--jquery validate-->

<script src="<?php echo base_url()?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url()?>assets/js/additional_methods.min.js"></script>

<!--wizard initialization-->

<!--<script src="<?php echo base_url() ?>assets/pages/jquery.wizard-init.js" type="text/javascript"></script>-->
<!-- App core js -->

<script src="<?php echo base_url() ?>assets/js/jquery.core.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.app.js"></script>
<script type="text/javascript">


!function($) {
    "use strict";

    var FormWizard = function() {};

   
    //creates form with validation
    FormWizard.prototype.createValidatorForm = function($form_container) {
        $form_container.validate({
            errorPlacement: function errorPlacement(error, element) {
                element.after(error);
            }
        });
        $form_container.children("div").steps({
            headerTag: "h3",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            onStepChanging: function (event, currentIndex, newIndex) {
                $form_container.validate().settings.ignore = ":disabled,:hidden";
                return $form_container.valid();
            },
            onFinishing: function (event, currentIndex) {
                $form_container.validate().settings.ignore = ":disabled";
                return $form_container.valid();
            },
            onFinished: function (event, currentIndex) {
              $("#wizard-validation-form").submit();

            }
        });

        return $form_container;
    },
    FormWizard.prototype.init = function() {
        
   
        //form with validation
        this.createValidatorForm($("#wizard-validation-form"));

        //vertical form
    },
    //init
    $.FormWizard = new FormWizard, $.FormWizard.Constructor = FormWizard}(window.jQuery),

        //initializing 
        function($) {
            "use strict";
            $.FormWizard.init()
        }
    (window.jQuery);
</script>
</body>
</html>