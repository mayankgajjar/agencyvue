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
</style>

<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Vendors</h4>
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() . 'admin/dashboard' ?>">Admin Dashboard</a></li>
                    <li class="active">Vendor Listing</li>
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
            <?php $this->session->set_flashdata('success', false);
            } else if ($this->session->flashdata('error')) { ?>
                <div class="content pt0">
                    <div class="alert alert-danger">
                        <a class="close" data-dismiss="alert">×</a>
                        <strong><?= $this->session->flashdata('error') ?></strong>
                    </div>
                </div>
            <?php $this->session->set_flashdata('error', false);
            } else if (validation_errors()) {?>
                <div class="content pt0">
                     <div class="alert alert-danger">
                        <a class="close" data-dismiss="alert">×</a>
                        <strong><?= validation_errors(); ?></strong>
                    </div>
                </div>
            <?php  } ?>

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
                            <!--<a class="btn btn-primary waves-effect waves-light" href="<?= base_url() . 'admin/vendors/add_vendor' ?>">Add Vendor</a>-->
                        </div>
                    </div>

                    <div class="table-responsive1">
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
                                    <th>Vendor Name</th>
                                    <th>Email</th>
                                    <th>State</th>
                                    <th>City</th>
                                    <th>Created Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div> <!-- end container -->
</div>

<!-- end wrapper -->


<script type="text/javascript">
    $(document).ready(function () {

        $('#datatable').dataTable({
            "bProcessing": true,
            "bPaginate": true,
            "bServerSide": true,
            "pagingType": "full_numbers",
            "columnDefs": [{
                    'orderable': false,
                    'targets': [0, 6]
                }],
            "order": [
                [5, "DESC"]
            ],
            "sAjaxSource": "<?php echo base_url() ?>admin/vendors/indexJson"
        });

        $('#search').on('keyup click', function () {
            $('#datatable').DataTable().search(
                    $('#search').val()).draw();
        });

       

        $('#action_checkbox').on('click', function () {
            if (this.checked) {
                $('.ch_checkbox').each(function () {
                    this.checked = true;
                });
            } else {
                $('.ch_checkbox').each(function () {
                    this.checked = false;
                });
            }
        });

        $(document).on('click', '.ch_checkbox', function () {
            if ($('.ch_checkbox:checked').length == $('.ch_checkbox').length) {
                $('#action_checkbox').prop('checked', true);
            } else {
                $('#action_checkbox').prop('checked', false);
            }

        });

        $(document).on("click", ".del_vendor", function () {

            var user_id = $(this).data("custom-value");

            swal({
                title: "Are you sure?",
                text: "You want to delete this vendor",
                type: "error",
                showCancelButton: true,
                cancelButtonClass: 'btn-white btn-md waves-effect',
                confirmButtonClass: 'btn-danger btn-md waves-effect waves-light',
                confirmButtonText: 'Yes delete it!'
            }, function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        method: "POST",
                        url: '<?= base_url() . 'admin/vendors/remove_vendor' ?>',
                        data: {user_id: user_id},
                        success: function (data) {
                            swal("success", data, "success");
                            var $lmTable = $("#datatable").dataTable({bRetrieve: true});
                            $lmTable.fnDraw();
                        }
                    });
                }
            });
        });

    });

</script> 