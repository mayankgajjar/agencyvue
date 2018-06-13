<style>
    .card-box ul.pagination{float: right;}
    @media(max-width:767px){
        .card-box .table-responsive1{overflow: auto;}
        .card-box .table-responsive1 #datatable_wrapper{width:800px;}
        .checkbox, .radio {
            position: relative;
            display: inline-block;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        @media(max-width:370px){
            .m-t-20 .btn-pink{margin-left:0px !important;margin-top:10px;display: block;
                              width: 50px;}
        }
    }

    input.textInputError {border-color: red;}
   .dataTables_filter{ display: none; }


</style>
<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Leads</h4>
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() . 'agency/dashboard' ?>">Dashboard</a></li>
                    <li class="active">Leads Management</li>
                </ol>
            </div>
        </div>
        <?php if ($this->session->flashdata('success')) { ?>
            <div class="content pt0">
                <div class="alert alert-success">
                    <a class="close" data-dismiss="alert"><i class="fa fa-times"></i></a>
                    <strong><?= $this->session->flashdata('success') ?></strong>
                </div>
            </div>
            <?php
            $this->session->set_flashdata('success', false);
        } else if ($this->session->flashdata('error')) {
            ?>
            <div class="content pt0">
                <div class="alert alert-danger">
                    <a class="close" data-dismiss="alert"><i class="fa fa-times"></i></a>
                    <strong><?= $this->session->flashdata('error') ?></strong>
                </div>
            </div>

            <?php
            $this->session->set_flashdata('error', false);
        } else if (validation_errors()) {
            ?>
            <div class="content pt0">
                <div class="alert alert-danger">
                    <a class="close" data-dismiss="alert"><i class="fa fa-times"></i></a>
                    <strong><?= validation_errors() ?></strong>
                </div>
            </div>
        <?php } ?>
        <div class="row">
            <div class="col-lg-12 lead_list">
                <div class="card-box lead-page">
                    <div class="row">
                        <div class="col-sm-6">
                            <form role="form">
                                <div class="form-group contact-search m-b-30">
                                    <input type="text" id="search" class="form-control" placeholder="Search..."s>
                                    <button type="submit" class="btn btn-white"><i class="fa fa-search"></i></button>
                                </div> <!-- form-group -->
                            </form>
                        </div>
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-4">
                            <select class="form-control input-sm agent-fliter" id="agent-selector" name="agent-fliter">
                                <option value="">Show All Verifications</option>
                                <?php foreach ($agencts as $agencts): ?>
                                    <option value="<?= $agencts['user_id'] ?>"><?= $agencts['display_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 lead_list">
                            <div class="table-responsive1 table-responsive">
                                <table class="table table-hover" id="datatable">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="checkbox checkbox-primary checkbox-single m-r-15">
                                                    <input id="action_checkbox" type="checkbox">
                                                    <label for="action-checkbox"></label>
                                                </div>
                                                <div class="btn-group dropdown">
                                                    <button type="button" class="btn btn-white btn-xs dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false"><i class="caret"></i></button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a href="#">Action</a></li>
                                                        <li><a href="#">Another action</a></li>
                                                        <li><a href="#">Something else here</a></li>
                                                        <li class="divider"></li>
                                                        <li><a href="#">Separated link</a></li>
                                                    </ul>
                                                </div>
                                            </th>
                                            <th>Client Name</th>
                                            <th>Product Name</th>
                                            <th>Script</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
            <div id="lead_info">

            </div>
        </div>
    </div> <!-- end container -->
</div>
<!-- end wrapper -->
<div id="custom-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width:35%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title" id="custom-width-modalLabel">Add New Lead</h4>
            </div>
            <div class="modal-body">
                <form id="frm_lead1" method="POST" class="data-parsley-validate novalidate">
                    <!--<form role="form" method="POST" action="" id="frm_lead1" class="data-parsley-validate novalidate">-->
                    <div class="form-group">
                        <label for="name">First Name*</label>
                        <input type="text" class="form-control required" id="first_name1" placeholder="Enter First Name" name="first_name">
                        <div id="error-fname" class="custom-error-note" style="display:none; color: #f6504d; margin-top: 5px; font-style: italic;">This field is required.</div>
                    </div>
                    <div class="form-group">
                        <label for="name">Last Name*</label>
                        <input type="text" class="form-control required" id="last_name1" placeholder="Enter Last Name" name="last_name">
                        <div id="error-lname" class="custom-error-note" style="display:none; color: #f6504d; margin-top: 5px; font-style: italic;"> This field is required.</div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address*</label>
                        <input type="email" class="form-control required" id="email1" placeholder="Enter email" name="email">
                        <div id="error-email" class="custom-error-note" style="display:none; color: #f6504d; margin-top: 5px; font-style: italic;">This field is required.</div>
                        <div id="error-valid-email" class="custom-error-note" style="display:none; color: #f6504d; margin-top: 5px; font-style: italic;">Email address is not valid.</div>
                    </div>
                    <div class="form-group">
                        <label for="position">Contact number*</label>
                        <input type="text" class="form-control required custom_phone_number_marks" id="contact1" placeholder="Enter number" name="contact">
                        <div id="error-phone" class="custom-error-note" style="display:none; color: #f6504d; margin-top: 5px; font-style: italic;">This field is required.</div>
                    </div>
                    <!--<input type="submit" class="btn btn-default" id="submit" name="submit" value="Save">-->
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-default waves-effect waves-light" id="add_lead">Save changes</button>
                <button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
         $(document).ready(function () {
        $('#datatable').dataTable({
            "bProcessing": true,
            "bPaginate": true,
            "bServerSide": true,
            "pagingType": "full_numbers",
            "columnDefs": [{
                    'orderable': false,
                    'targets': [0, 3]
                }],
            "order": [
                [1, "DESC"]
            ],
            "sAjaxSource": "<?php base_url() ?>verification/verificationJson"
        });
        $('#search').on('keyup click', function () {
            $('#datatable').DataTable().search(
                    $('#search').val()
                    ).draw();
        });
        $(document).on('change', '#agent-selector', function () {
            var agent_id = $(this).val();
            var table = $('#datatable').DataTable();
            table.destroy();
            $('#datatable').dataTable({
                "bProcessing": true,
                "bPaginate": true,
                "bServerSide": true,
                "pagingType": "full_numbers",
                "columnDefs": [{
                        'orderable': false,
                        'targets': [0, 3]
                    }],
                "order": [
                    [3, "DESC"]
                ],
                "sAjaxSource": "<?php base_url() ?>verification/verificationJson?agent_id=" + agent_id
            });
        });

         });
</script>