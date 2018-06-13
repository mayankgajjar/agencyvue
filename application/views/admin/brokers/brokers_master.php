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
            .m-t-20 .btn-pink{margin-left:0px !important;margin-top:10px;display: block;width: 50px;}
        }
    }
</style>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title"> Brokers Listing </h4>
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() . 'admin/dashboard' ?>">Admin Dashboard</a></li>
                    <li><a href="<?= base_url() . 'admin/brokers' ?>">Brokers Section</a></li>
                    <li class="active">Manage Brokers</li>
                </ol>
            </div>
        </div>

        <!-- Page-Title -->
<!--        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Agents</h4>
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() . 'admin/dashboard' ?>">Dashboard</a></li>
                    <li class="active">Agent Listing</li>
                </ol>
            </div>
        </div>-->

        <?php if ($this->session->flashdata('success')) { ?>
                <div class="content pt0">
                    <div class="alert alert-success">
                        <a class="close" data-dismiss="alert">×</a>
                        <strong><?= $this->session->flashdata('success') ?></strong>
                    </div>
                </div>
        <?php $this->session->set_flashdata('success', false);
        } else if ($this->session->flashdata('error')) {
                ?>
                <div class="content pt0">
                    <div class="alert alert-danger">
                        <a class="close" data-dismiss="alert">×</a>
                        <strong><?= $this->session->flashdata('error') ?></strong>
                    </div>
                </div>

        <?php $this->session->set_flashdata('error', false);
        } else if(validation_errors()) { ?>
                <div class="content pt0">
                    <div class="alert alert-danger">
                        <a class="close" data-dismiss="alert">×</a>
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
                            <a class="btn btn-primary waves-effect waves-light" href="<?= base_url() . 'admin/Brokers/add_broker' ?>">Add Agent</a>
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
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Created Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody> </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end col -->
            <div id="broker_info"></div>
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
            'targets': [0, 4]
        }],
        "order" : [
            [3,"DESC"]
        ],
        "sAjaxSource": "<?php echo base_url('admin/Brokers/agentbrokesJson'); ?>"
    });

    $('#search').on('keyup click', function () {
        $('#datatable').DataTable().search(
                $('#search').val()
                ).draw();
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

    //$('.ch_checkbox').live('click',function(){
    $(document).on('click', '.ch_checkbox', function () {
        if ($('.ch_checkbox:checked').length == $('.ch_checkbox').length) {
            $('#action_checkbox').prop('checked', true);
        } else {
            $('#action_checkbox').prop('checked', false);
        }
    });


      $(document).on("click", ".del_broker", function () {
            var user_id = $(this).data("custom-value");
            swal({
                title: "Are you sure?",
                text: "You want to delete this broker",
                type: "error",
                showCancelButton: true,
                cancelButtonClass: 'btn-white btn-md waves-effect',
                confirmButtonClass: 'btn-danger btn-md waves-effect waves-light',
                confirmButtonText: 'Yes delete it!'
            }, function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        method: "POST",
                        url: '<?= base_url() . 'admin/brokers/removebroker' ?>',
                        data: {user_id: user_id},
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
         $(document).on('click', '.view_log', function () {
            var id = $(this).data("custom-value");
            //console.log(id);
            $(".lead_list").attr("class", "col-lg-9 lead_list");
            $("#datatable").css("width", "980px");
            $('#datatable').find('tr').removeClass('active');
            $(this).parent('td').parent('tr').addClass('active');
            $.ajax({
                method: "POST",
                url: "<?php echo base_url() ?>admin/brokers/show_broker_info",
                data: {empid: id},
                success: function (data) {
                    $("#broker_info").html(data);
                    $.fn.niceScroll && $(".nicescroll").niceScroll({cursorcolor: '#98a6ad', cursorborder: '#98a6ad', cursorwidth: '5px', cursorborderradius: '5px'});
                },
            });
            $('#broker_info').show();
        });

});
</script>


<!--<div class="wrapper">
    <div class="container">
         Page-Title 
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title"> Brokers Listing </h4>
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() . 'admin/dashboard' ?>">Admin Dashboard</a></li>
                    <li><a href="<?= base_url() . 'admin/brokers' ?>">Brokers Section</a></li>
                    <li class="active">Manage Brokers</li>
                </ol>
            </div>
        </div>-->

<!--        <div class="crm_broker_page_wapper" style="margin-top: 25px">
            <div class="row">
                <div class="col-sm-12">
                    <?php if ($this->session->flashdata('success')) { ?>

                        <div class="content pt0">
                            <div class="alert alert-success">
                                <a class="close" data-dismiss="alert">×</a>
                                <strong><?= $this->session->flashdata('success') ?></strong>
                            </div>
                        </div>-->

                    <?php $this->session->set_flashdata('success', false); } else if ($this->session->flashdata('error')) {?>

                        <div class="content pt0">
                            <div class="alert alert-danger">
                                <a class="close" data-dismiss="alert">×</a>
                                <strong><?= $this->session->flashdata('error') ?></strong>
                            </div>
                        </div>

                    <?php } ?>

<!--                    <div class="card-box table-responsive">
                        <h4 class="m-t-0 header-title"><b>All Brokers</b></h4>
                        <p class="text-muted font-13 m-b-30">
                        </p>

                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email Address</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Created Date</th>
                                    <th>Parent (Upline) Agent</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>-->

<!--        <div id="tabs-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content p-0">
                    <div class="modal-body">
                        <img src="<?php base_url(); ?> ?/assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
                        <span> &nbsp;&nbsp;Loading... </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>-->


<!--<script type="text/javascript">
    $(document).ready(function () {

        $('#datatable').dataTable({
            "bProcessing": true,
            "bPaginate": true,
            "bServerSide": true,
            "sAjaxSource": "<?php echo base_url('admin/brokers/brokesJson'); ?>",
            "columnDefs": [{
                    'orderable': false,
                    'targets': [7]
                }],
            "pagingType": "full_numbers",
        });

        $(document).on("click", ".del_broker", function () {
            var user_id = $(this).val();
            swal({
                title: "Are you sure?",
                text: "You want to delete this broker",
                type: "error",
                showCancelButton: true,
                cancelButtonClass: 'btn-white btn-md waves-effect',
                confirmButtonClass: 'btn-danger btn-md waves-effect waves-light',
                confirmButtonText: 'Yes delete it!'

            }, function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        method: "POST",
                        url: '<?= base_url() . 'admin/brokers/removebroker' ?>',
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

<style> 
    .table-action-btn {margin-right: 5px;}
</style>-->