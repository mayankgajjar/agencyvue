<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
		<meta name="author" content="Coderthemes">

		<link rel="shortcut icon" href="<?php echo base_url() ?>assets/images/favicon_1.ico">

		<title>Change Password</title>

		<link href="<?php echo base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>assets/css/responsive.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="<?php echo base_url() ?>assets/js/modernizr.min.js"></script>

	</head>
	<body>

		<div class="account-pages"></div>
		<div class="clearfix"></div>
		<div class="wrapper-page">
			<div class=" card-box">
				<div class="panel-heading">
					<h3 class="text-center"> Change Password </h3>
				</div>

				<?php if ($this->session->flashdata('success')) { ?>
                    <div class="content pt0">
                        <div class="alert">
                            <a class="close" data-dismiss="alert">×</a>
                            <strong><?= $this->session->flashdata('success') ?></strong>
                        </div>
                    </div>
                <?php } else if(validation_errors()) {?>
                    <div class="alert alert-danger">
                        <a class="close" data-dismiss="alert">×</a>
                            <?php echo validation_errors(); ?>
                    </div>
                <?php } ?>
					<form method="post" action="" role="form" class="text-center">
						<div class="panel-body">
							<div class="form-group">
	                            <label class="col-md-6 control-label">New Password</label>
	                            <div class="col-md-6">
	                                <input type="password" class="form-control" name="password" id="password" required>
	                            </div>
                        	</div>
                        </div>
                        <div class="panel-body">
	                        <div class="form-group">
	                            <label class="col-md-6 control-label">Confirm Password</label>
	                            <div class="col-md-6">
	                                <input type="password" class="form-control" name="confirm_password" required>
	                            </div>
	                        </div>
	                    </div>  

	                    <div class="panel-body">
	                    	<div class="form-group">
	                            <label class="col-md-6">&nbsp;</label>
	                            <div class="col-md-6">
	                                <input type="submit" class="btn btn-success" value="Save" name="save">
	                            </div>
	                        </div>
	                    </div>	
					</form>
				</div>
			</div>
		

		<script>
			var resizefunc = [];
		</script>

		<!-- jQuery  -->
        <script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/detect.js"></script>
        <script src="<?php echo base_url() ?>assets/js/fastclick.js"></script>
        <script src="<?php echo base_url() ?>assets/js/jquery.slimscroll.js"></script>
        <script src="<?php echo base_url() ?>assets/js/jquery.blockUI.js"></script>
        <script src="<?php echo base_url() ?>assets/js/waves.js"></script>
        <script src="<?php echo base_url() ?>assets/js/wow.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/jquery.nicescroll.js"></script>
        <script src="<?php echo base_url() ?>assets/js/jquery.scrollTo.min.js"></script>


        <script src="<?php echo base_url() ?>assets/js/jquery.core.js"></script>
        <script src="<?php echo base_url() ?>assets/js/jquery.app.js"></script>

	</body>
</html>