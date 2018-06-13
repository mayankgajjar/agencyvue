<div class="wrapper broker_dashboard_wapper">
    <div class="container">
        <!-- Page-Title -->

        <div class="row">

            <div class="col-sm-12">
                <h4 class="page-title"> Brokers Section </h4>
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() . 'admin/dashboard' ?>">Dashboard</a></li>
                    <li class="active">Brokers Section</li>
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
                                        <div class="col-lg-8">
                                            <h4 class="m-t-0 header-title"><b>Approved Users</b></h4>
                                            <p class="text-muted font-13">
                                            </p>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="link-button-wapper">
                                                <a href="<?= base_url() ?>admin/brokers/manageBrokers" class="btn btn-default waves-effect waves-light">Manage All Approved Users</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-20">
                                    <table class="table table table-hover m-0">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>City</th>
                                                <th>Parent (Upline) Agent</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($approvedUser as $user): ?>
                                                <tr>
                                                    <td><?= $user['first_name'] . ' ' . $user['last_name']; ?></td>
                                                    <td><?= $user['email'] ?></td>
                                                    <td><?= $user['personal_city'] ?></td>
                                                    <td><?= $user['parent_name'] ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-4" style="margin-left: 337px;">
                                <div class="row">
                                    <div class="widget-panel widget-style-2 bg-white">
                                        <i class="md md-account-child text-custom"></i>
                                        <h2 class="m-0 text-dark counter font-600">
                                            <span data-plugin="counterup"><?php echo $approvedBroker; ?></span></h2>
                                        <div class="text-muted m-t-5">Users</div>
                                    </div>
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
                                        <div class="col-lg-8">
                                            <h4 class="m-t-0 header-title"><b>Unapproved Users</b></h4>
                                            <p class="text-muted font-13">

                                            </p>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="link-button-wapper">
                                                <a href="<?= base_url() ?>admin/brokers/unapprovedBrokers" class="btn btn-default waves-effect waves-light">Manage All Unapproved Users</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-20">
                                    <table class="table table table-hover m-0">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>City</th>
                                                <th>Parent (Upline) Agent</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($unapprovedUser as $user): ?>
                                                <tr>
                                                    <td><?= $user['first_name'] . ' ' . $user['last_name']; ?></td>
                                                    <td><?= $user['email']; ?></td>
                                                    <td><?= $user['personal_city']; ?></td>
                                                    <td><?= get_display_name($user['parent_id']); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-4" style="margin-left: 337px;">
                                <div class="row">
                                    <div class="widget-panel widget-style-2 bg-white">
                                        <i class="md md-account-child text-custom"></i>
                                        <h2 class="m-0 text-dark counter font-600">

                                            <span data-plugin="counterup"><?php echo $unapprovedBroker; ?></span></h2>
                                        <div class="text-muted m-t-5">Users</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>