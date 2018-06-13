<style>
    .test-mode-label{display: inline-block;
    float: left;
    vertical-align: middle;
    padding-right: 0;
    width: 26%;
    margin-top: 8px;}
</style>
<div class="wrapper broker_profile_wapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <!--<h4 class="page-title">Edit Profile</h4>-->
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() . 'admin/dashboard' ?>">Dashboard</a></li>
                    <li class="active">Agency Setup</li>
                </ol>
            </div>
        </div>

        <?php if ($this->session->flashdata('success')) { ?>
        <div class="content pt0">
                <div class="alert alert-success">
                    <a class="close" data-dismiss="alert">X</a>
                    <strong><?= $this->session->flashdata('success') ?></strong>
                </div>
            </div>
        <?php $this->session->set_flashdata('success', false);} else if ($this->session->flashdata('error')) {?>
            <div class="content pt0">
                <div class="alert alert-danger">
                    <a class="close" data-dismiss="alert">X</a>
                    <strong><?= $this->session->flashdata('error') ?></strong>
                </div>
            </div>
        <?php $this->session->set_flashdata('error', false);} else if (validation_errors()) {?>
            <div class="content pt0">
                <div class="alert alert-danger">
                    <a class="close" data-dismiss="alert">X</a>
                    <strong><?= validation_errors() ?></strong>
                </div>
            </div>
        <?php } ?>

        <div class="row">
            <div class="col-lg-12 col-md-12 card-box all_details_broker_profile">
                <form method="post" action="" data-parsley-validate novalidate>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group clearfix">
                                <div class="col-lg-4">
                                    <label for="reg_fee">Registration Fee * </label>
                                    <input type="text" id="reg_fee" name="reg_fee" class="required form-control" autocomplete="off" value="<?php echo (isset($data['registration_fee'])) ? $data['registration_fee'] : ''; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group clearfix">
                                <div class="col-lg-4">
                                    <label class="test-mode-label">Test Mode : </label>
                                    <div class="checkbox checkbox-primary">
                                        <input id="test_mode" type="checkbox" name="test_mode" class="test_mode" value="YES" <?php echo ($data['enable_test'] == 'YES') ? 'checked' : ''; ?>>
                                        <label for="test_mode"> Enable Test Mode </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center"><h3><strong>Live Credentials</strong></h3></div>
                        <div class="col-lg-12">
                                <div class="col-lg-4">
                                    <div class="form-group clearfix">
                                      <label for="live_secret">Secret Key</label>
                                     <input type="text" id="live_secret" name="live_secret" class="required form-control" autocomplete="off" value="<?php echo (isset($data['live_secret_key'])) ? $data['live_secret_key'] : ''; ?>">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group clearfix">
                                       <label for="live_publishable">Publishable Key</label>
                                       <input type="text" id="live_publishable" name="live_publishable" class="required form-control" autocomplete="off" value="<?php echo (isset($data['live_publishable_key'])) ? $data['live_publishable_key'] : ''; ?>">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group clearfix">
                                        <label for="live_client">Client ID</label>
                                        <input type="text" id="live_client" name="live_client" class="required form-control" autocomplete="off" value="<?php echo (isset($data['live_client_id'])) ? $data['live_client_id'] : ''; ?>">
                                  </div>
                                </div>
                        </div>
                        
                        <div class="text-center"><h3><strong>Test Credentials</strong></h3></div>
                        <div class="col-lg-12">
                            
                                <div class="col-lg-4">
                                    <div class="form-group clearfix">
                                        <label for="test_secret">Secret Key</label>
                                        <input type="text" id="test_secret" name="test_secret" class="form-control" autocomplete="off" value="<?php echo (isset($data['test_secret_key'])) ? $data['test_secret_key'] : ''; ?>">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group clearfix">
                                        <label for="test_publishable">Publishable Key</label>
                                        <input type="text" id="test_publishable" name="test_publishable" class="form-control" autocomplete="off" value="<?php echo (isset($data['test_publishable_key'])) ? $data['test_publishable_key'] : ''; ?>">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group clearfix">
                                      <label for="test_client">Client ID</label>
                                      <input type="text" id="test_client" name="test_client" class="form-control" autocomplete="off" value="<?php echo (isset($data['test_client_id'])) ? $data['test_client_id'] : ''; ?>">
                                    </div>
                                </div>
                        </div>
                        
                        
                        <div class="form-group clearfix text-center" >
                            <div class="col-lg-12">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-success" name="Save" value="Save">
                                        <a class="btn btn-default waves-effect waves-light" href="<?= base_url() . 'admin/dashboard' ?>"> <span class="btn-label"><i class="fa fa-arrow-left"></i>
                                            </span>Back</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    (function ($) {
        $(document).on('click', '#test_mode', function () {
            
            var Checked = $('input[name="test_mode"]:checked').length;
            
            if(Checked == 1){
                $('#test_secret').addClass('required');
                $('#test_publishable').addClass('required');
                $('#test_client').addClass('required');
                $('#live_secret').removeClass('required');
                $('#live_publishable').removeClass('required');
                $('#live_client').removeClass('required');
            } else {
                $('#live_secret').addClass('required');
                $('#live_publishable').addClass('required');
                $('#live_client').addClass('required');
                $('#test_secret').removeClass('required');
                $('#test_publishable').removeClass('required');
                $('#test_client').removeClass('required');
                
            }
            
            

            /*if (select_account == "checking") {
                $('#saving').prop('checked', false); // Unchecks it
            }

            if (select_account == "saving") {
                $('#checking').prop('checked', false); // Unchecks it
            }*/
        });
    })(jQuery);

</script>

