 <div class="wrapper">
            <div class="container">
                <?php
                    if ($this->session->flashdata('success')) {
                        ?>
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
                } else {
                        ?>
                        <div class="content pt0">
                        <?php
                            echo validation_errors();
                        ?>
                        </div>
                        <?php
                    }
?>
                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="page-title">Dashboard</h4>
                        <p class="text-muted page-title-alt">Welcome <?php echo $this->session->userdata['user_info']['email']; ?></p>
                    </div>
                </div>

            </div>
        </div>