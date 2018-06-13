<div class="wrapper broker_dashboard_wapper">
    <div class="container">
        <!-- Page-Title -->

        <div class="row">

            <div class="col-sm-12">
                <h4 class="page-title"> Verification Script </h4>
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() . 'admin/dashboard' ?>">Dashboard</a></li>
                    <li class="active">Verification Script</li>
                </ol>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="col-sm-6">
                    <div class="card-box">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="col-lg-7">
                                            <h4 class="m-t-0 header-title"><b>All Verification Script</b></h4>
                                            <p class="text-muted font-13">
                                            </p>
                                        </div>
                                        <div class="col-lg-5">
                                            <div class="link-button-wapper">
                                                <a href="<?= base_url() ?>admin/settings/verification_script" class="btn btn-default waves-effect waves-light">Manage All Verification Script</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-20">
                                    <table class="table table table-hover m-0">
                                        <thead>
                                            <tr>
                                                <th>Script Name</th>
                                                <th>State Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <?php foreach($all_script as $all){ ?>
                                                <tr>
                                                    <td><?= $all['script_name'] ?></td>
                                                    <td><?php if($all['state_code'] == ""){echo "All State";} else {echo get_state_name($all['state_code']);}?></td>
                                                </tr>
                                           <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card-box">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="col-lg-7">
                                            <h4 class="m-t-0 header-title"><b>Product Verification Script</b></h4>
                                            <p class="text-muted font-13">

                                            </p>
                                        </div>
                                        <div class="col-lg-5">
                                            <div class="link-button-wapper">
                                                <a href="<?= base_url() ?>admin/settings/product_verification_script" class="btn btn-default waves-effect waves-light">Product Verification Script</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-20">
                                    <table class="table table table-hover m-0">
                                        <thead>
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Script Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($product_script as $pro_script){ ?>
                                                <tr>
                                                    <td><?= $pro_script['product_name'] ?></td>
                                                    <td><?= $pro_script['script_name'] ?></td>
                                                </tr>
                                           <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>