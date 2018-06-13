<div class="wrapper">
	<div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Fund</h4>
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() . 'agent/dashboard' ?>">Dashboard</a></li>
                    <li class="active">Fund</li>
                </ol>
            </div>
        </div>
        <?php if ($this->session->flashdata('success')) { ?>
            <div class="content pt0">
                <div class="alert alert-success">
                    <a class="close" data-dismiss="alert">×</a>
                    <strong><?= $this->session->flashdata('success') ?></strong>
                </div>
            </div>
            <?php
            $this->session->set_flashdata('success', false);
        } else if ($this->session->flashdata('error')) {
            ?>
            <div class="content pt0">
                <div class="alert alert-danger">
                    <a class="close" data-dismiss="alert">×</a>
                    <strong><?= $this->session->flashdata('error') ?></strong>
                </div>
            </div>

            <?php
            $this->session->set_flashdata('error', false);
        } else if (validation_errors()) {
            ?>
            <div class="content pt0">
                <div class="alert alert-danger">
                    <a class="close" data-dismiss="alert">×</a>
                    <strong><?= validation_errors() ?></strong>
                </div>
            </div>
        <?php } ?>

        <div class="row">
        	<div class="col-lg-12 col-md-12">
    			<div class="card-box">
    				<form method="post">
    					<div class="text-center">
                            <h3><strong><?php echo 'Add Fund To Account' ?></strong></h3>
                        </div>
                        <div class="primary_div">
                    		<div class="form-group clearfix">
                    			
                    		</div>
                        </div>
    				</form>
    			</div>
        	</div>
        </div>        	
	</div>
</div>