<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
		<meta name="author" content="Coderthemes">

		<link rel="shortcut icon" href="<?php echo base_url()?>assets/images/favicon_1.ico">

		<title>Forget Password</title>

		<link href="<?php echo base_url()?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url()?>assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url()?>assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url()?>assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url()?>assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url()?>assets/css/responsive.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="<?php echo base_url()?>assets/js/modernizr.min.js"></script>

	</head>
	<body>

		<div class="account-pages"></div>
		<div class="clearfix"></div>
		<div class="wrapper-page">
			<div class=" card-box">
				<div class="panel-heading">
					<h3 class="text-center"> Reset Password </h3>
				</div>
				

				<div class="panel-body">
					<form method="POST" action="" role="form" class="text-center">
						
						<?php if ($this->session->flashdata('success')) {?>
		                    <div class="content pt0">
		                        <div class="alert alert-success">
		                            <a class="close" data-dismiss="alert">×</a>
		                            <strong><?= $this->session->flashdata('success') ?></strong>
		                        </div>
		                    </div>
		                <?php 
		                $this->session->set_flashdata('success', false);
		            	} else if($this->session->flashdata('error')){?>
		                	  <div class="content pt0">
						        <div class="alert alert-danger">
						            <a class="close" data-dismiss="alert">×</a>
						            <strong><?= $this->session->flashdata('error') ?></strong>
						        </div>
						    </div>
						<?php 
						 $this->session->set_flashdata('error', false);
						} else { ?>
						<div class="alert alert-info alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
								×
							</button>
							Enter your <b>Email</b> and instructions will be sent to you!
						</div>
						<?php } ?>
						<div class="form-group m-b-0">
							<div class="input-group">
								<input type="email" class="form-control" placeholder="Enter Email" required="" name="email">
								<span class="input-group-btn">
									<input type="submit" class="btn btn-pink" value="Reset" name="reset"/>
										
								</span>
							</div>
						</div>

					</form>
				</div>
			</div>
			

		</div>

		<script>
			var resizefunc = [];
		</script>

		<!-- jQuery  -->
        <script src="<?php echo base_url()?>assets/js/jquery.min.js"></script>
        <script src="<?php echo base_url()?>assets/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url()?>assets/js/detect.js"></script>
        <script src="<?php echo base_url()?>assets/js/fastclick.js"></script>
        <script src="<?php echo base_url()?>assets/js/jquery.slimscroll.js"></script>
        <script src="<?php echo base_url()?>assets/js/jquery.blockUI.js"></script>
        <script src="<?php echo base_url()?>assets/js/waves.js"></script>
        <script src="<?php echo base_url()?>assets/js/wow.min.js"></script>
        <script src="<?php echo base_url()?>assets/js/jquery.nicescroll.js"></script>
        <script src="<?php echo base_url()?>assets/js/jquery.scrollTo.min.js"></script>


        <script src="<?php echo base_url()?>assets/js/jquery.core.js"></script>
        <script src="<?php echo base_url()?>assets/js/jquery.app.js"></script>

	</body>
</html>