<div class="wrapper broker_dashboard_wapper">
    <div class="container">
        <!-- Page-Title -->

        <div class="row">

            <div class="col-sm-12">
                <h4 class="page-title"> Employer Section </h4>
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() . 'admin/dashboard' ?>">Dashboard</a></li>
                    <li class="active">Employer Section</li>
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
                                            <h4 class="m-t-0 header-title"><b>Approved Employer</b></h4>
                                            <p class="text-muted font-13">
                                            </p>
                                        </div>
                                        <div class="col-lg-5">
                                            <div class="link-button-wapper">
                                                <a href="<?= base_url() ?>admin/employers/manageEmployer" class="btn btn-default waves-effect waves-light">Manage All Approved Employer</a>
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
                                                <th>Upline</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($approvedUser as $user): ?>
                                                <tr>
                                                    <td><?= $user['employer_name'] ?></td>
                                                    <td><?= $user['email'] ?></td>
                                                    <td><?= $user['broker_name'] ?></td>
                                                </tr>
                                            <?php endforeach; ?>
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
                                            <h4 class="m-t-0 header-title"><b>Unapproved Employer</b></h4>
                                            <p class="text-muted font-13">

                                            </p>
                                        </div>
                                        <div class="col-lg-5">
                                            <div class="link-button-wapper">
                                                <a href="<?= base_url() ?>admin/employers/unapprovedEmployer" class="btn btn-default waves-effect waves-light">Manage All Unapproved Employer</a>
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
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($unapprovedUser as $user): ?>
                                                <tr>
                                                    <td><?= $user['employer_name'] ?></td>
                                                    <td><?= $user['employer_email'] ?></td>
                                                    <td><?= $user['employer_city'] ?></td>
                                                </tr>
                                            <?php endforeach; ?>
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