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
    #datatable_filter {
        display: none;
    }
</style>
<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title"><?php echo $page_title; ?></h4>
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() . 'agency/dashboard' ?>">Dashboard</a></li>
                    <li class="active"><?php echo $page_title; ?></li>
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
            <div class="col-lg-12">
                <div class="card-box">
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
                            <button class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#custom-width-modal">Add Category</button>
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
                                    <th>Category Name</th>
                                    <th>Created Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div> <!-- end container -->
</div>
<div id="custom-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width:35%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title" id="custom-width-modalLabel">Add New Product Category</h4>
            </div>
            <div class="modal-body">
                <form id="frm_add_pcate" method="POST">
                    <div class="form-group">
                        <label for="name">Product Category Name*</label>
                        <input type="text" class="form-control" id="name" placeholder="NAME OF CATEGORY" name="name">
                        <div id="error-name" class="custom-error-note" style="display:none; color: #f6504d; margin-top: 5px; font-style: italic;">This field is required.</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-default waves-effect waves-light" id="add_cate">Add</button>
                <button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div id="edit-custom-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width:35%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title" id="custom-width-modalLabel">Edit Product Category</h4>
            </div>
            <div class="modal-body">
                <form id="frm_add_pcate" method="POST">
                    <input type="hidden" id="cid" name="cateid" value="">
                    <div class="form-group">
                        <label for="name">Product Category Name*</label>
                        <input type="text" class="form-control" id="name-e" placeholder="NAME OF CATEGORY" name="edit_name">
                        <div id="error-name-e" class="custom-error-note" style="display:none; color: #f6504d; margin-top: 5px; font-style: italic;">This field is required.</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-default waves-effect waves-light" id="edit_cate">EDIT</button>
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
            "sAjaxSource": "<?php echo base_url() ?>agency/products/categoryJson"
        });

        $('#search').on('keyup click', function () {
            $('#datatable').DataTable().search(
                    $('#search').val()).draw();
        });
    });
    $("#add_cate").click(function (e) {
        e.preventDefault();
        $("#name").removeClass("textInputError");
        $('#error-name').hide()
        var name = $("#name").val();
        var error = 0;
        if (name == "") {
            $('#error-name').show();
            $("#name").addClass("textInputError");
            error = 1;
        }
        if (error == 0) {
            $.ajax({
                type: "POST",
                url: "<?php base_url() ?>add_edit_category",
                data: {name: name, method: 'add'},
                success: function (data) {
                    swal("success", data, "success");
                    var $lmTable = $("#datatable").dataTable({bRetrieve: true});
                    $lmTable.fnDraw();
                    $("#frm_add_pcate")[0].reset();
                    $('#custom-width-modal').modal('hide');
                },
            });
        }
    });
    jQuery(document).on('click', '.edit_product_category', function () {
        jQuery("#cid").val(jQuery(this).data('cateid'));
        jQuery("#name-e").val(jQuery(this).data('catename'));
        $('#edit-custom-width-modal').modal('show');
    });
    $("#edit_cate").click(function (e) {
        e.preventDefault();
        $("#name-e").removeClass("textInputError");
        $('#error-name-e').hide()
        var name = $("#name-e").val();
        var id = $("#cid").val();
        var error = 0;
        if (name == "") {
            $('#error-name').show();
            $("#name").addClass("textInputError");
            error = 1;
        }
        if (error == 0) {
            $.ajax({
                type: "POST",
                url: "<?php base_url() ?>add_edit_category",
                data: {name: name, id: id, method: 'edit'},
                success: function (data) {
                    swal("success", data, "success");
                    var $lmTable = $("#datatable").dataTable({bRetrieve: true});
                    $lmTable.fnDraw();
                    $("#frm_add_pcate")[0].reset();
                    jQuery("#cid").val(' ');
                    jQuery("#name").val(' ');
                    $('#edit-custom-width-modal').modal('hide');
                },
            });
        }
    });
    $(document).on("click", ".del_cate", function () {
        var id = $(this).data("id");
        swal({
            title: "Are you sure?",
            text: "You want to delete this Category",
            type: "error",
            showCancelButton: true,
            cancelButtonClass: 'btn-white btn-md waves-effect',
            confirmButtonClass: 'btn-danger btn-md waves-effect waves-light',
            confirmButtonText: 'Yes delete it!'
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    method: "POST",
                    url: '<?php base_url() ?>removeCategory',
                    data: {id: id},
                    success: function (data) {
                        swal("success", data, "success");
                        var $lmTable = $("#datatable").dataTable({bRetrieve: true});
                        $lmTable.fnDraw();
                        // console.log('disapproved');
                    }
                });
            }
        });
    });
</script>