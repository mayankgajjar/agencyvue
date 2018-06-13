<div class="wrapper thanks_page">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title"> Thank you for signing up with us! </h4>
            </div>
        </div>
        <?php
        if ($this->session->flashdata('success')):
            ?>
            <div class="content pt0">
                <div class="alert alert-success">
                    <a class="close" data-dismiss="alert"><i class="fa fa-times"></i></a>
                    <strong><?= $this->session->flashdata('success') ?></strong>
                </div>
            </div>
            <?php
            $this->session->set_flashdata('success', false);
        elseif ($this->session->flashdata('error')):
            ?>
            <div class="content pt0">
                <div class="alert alert-danger">
                    <a class="close" data-dismiss="alert"><i class="fa fa-times"></i></a>
                    <strong><?= $this->session->flashdata('error') ?></strong>
                </div>
            </div>
        <?php endif; ?>
        <!-- End row -->
        <div class="row thanks-text-row">
            <div class="col-md-12">
                <div class="col-md-8">
                    <div class="thank-you-text-wapper">
                        <h4>
                            Your have successfully registered with Agency Vue.
                        </h4>
                        <p>
                            You get notification as soon as our system admin accept your new agency request!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .wrapper.thanks_page {
        padding-top: 80px !important;
    }
</style>
