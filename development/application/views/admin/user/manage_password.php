
<div class="page-header page-header-default">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class="icon-lock"></i> <span class="text-semibold"><?php echo $this->lang->line('Change Password'); ?></span></h4>
        </div>
    </div>
    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('dashboard'); ?>"><i class="icon-home2 position-left"></i><?php echo $this->lang->line('Home'); ?></a></li>
            <li class="active"><?php echo $this->lang->line('Change Password'); ?></li>
        </ul>
    </div>
</div>
<?php
if ($this->session->flashdata('success')) {?>
    <div class="content pt0">
        <div class="alert alert-success">
            <a class="close" data-dismiss="alert">×</a>
            <strong><?= $this->session->flashdata('success') ?></strong>
        </div>
    </div>
<?php $this->session->set_flashdata('success', false); } else if ($this->session->flashdata('error')) {?>
    <div class="content pt0">
        <div class="alert alert-danger">
            <a class="close" data-dismiss="alert">×</a>
            <strong><?= $this->session->flashdata('error') ?></strong>
        </div>
    </div>
<?php $this->session->set_flashdata('error', false); } else if(validation_errors()){ ?>
    <div class="content pt0">
            <div class="content pt0">
                <strong><?= validation_errors(); ?></strong>
            </div>   
    </div>
<?php } ?>

    <form class="form-horizontal" action="" id="user_info" method="POST">   
        <div class="card-box text-center">
            <!-- <h4 class="m-t-0 header-title"><b>Change Password</b></h4>-->
            <div class="row">
                <div class="col-md-12">
                         <div class="form-group">
                            <label class="col-md-2 control-label">Old Password</label>
                            <div class="col-md-4">
                                <input type="password" class="form-control" name="old_password">
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="col-md-2 control-label">New Password</label>
                            <div class="col-md-4">
                                <input type="password" class="form-control" name="password" id="password">
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="col-md-2 control-label">Confirm Password</label>
                            <div class="col-md-4">
                                <input type="password" class="form-control" name="confirm_password">
                            </div>
                        </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-3">&nbsp;</div>
                    <div class="col-md-3">
                        <input type="submit" class="btn btn-success" value="Save" name="save">

                        <?php if($this->session->userdata['user_info']['roll_id'] == 1){ ?>
                             <a class="btn btn-default waves-effect waves-light" href="<?= base_url() . 'admin/dashboard' ?>"> <span class="btn-label"><i class="fa fa-arrow-left"></i>
                        </span>Back</a>
                        <?php }elseif ($this->session->userdata['user_info']['roll_id'] == 2) { ?>
                             <a class="btn btn-default waves-effect waves-light" href="<?= base_url() . 'agent/dashboard' ?>"> <span class="btn-label"><i class="fa fa-arrow-left"></i>
                        </span>Back</a>
                        <?php } elseif ($this->session->userdata['user_info']['roll_id'] == 4) { ?>
                             <a class="btn btn-default waves-effect waves-light" href="<?= base_url() . 'member/dashboard' ?>"> <span class="btn-label"><i class="fa fa-arrow-left"></i>
                        </span>Back</a>
                        <?php } ?>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
<script type="text/javascript">
    $('document').ready(function () {
        $("#user_info").validate({
            rules: {
                old_password: {
                    required: true,
                    minlength: 5
                },
                password: {
                    required: true,
                    minlength: 5
                },
                confirm_password: {
                    required: true,
                    equalTo: '#password'
                }
            },
            submitHandler: function (form) {
                form.submit();
            },
        });
    });
</script>        


