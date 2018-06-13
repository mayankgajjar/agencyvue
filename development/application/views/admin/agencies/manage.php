<style>
     .loader-select-city {
        position: absolute;
        width: 100%;
        background: rgba(255,255,255,.2);
        left: 0;
        top: 0;
        right: 0;
        bottom: 0;
        z-index: 9999;   
    }
    .loader-image {
        height: 45px;
        top: 50%;
        position: absolute;
        left: 50%;
        margin-top: -22px;
        margin-left: -22px;
    }
</style>
<div class="wrapper employer_master">
    <div class="container">
        <div class="loader-select-city" style="display: none"><img class="loader-image" src="<?= base_url() . 'assets/crm_image/' ?>ring.gif"></div>
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title"> Employer Listing </h4>
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() . 'admin/dashboard' ?>">Dashboard</a></li>
                    <li><a href="<?= base_url() . 'admin/agencies/manage' ?>">Agencies</a></li>
                    <li class="active">Manage Agencies</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="content pt0">
                        <div class="alert alert-success">
                            <a class="close" data-dismiss="alert">×</a>
                            <strong><?= $this->session->flashdata('success') ?></strong>
                        </div>
                    </div>
                    <?php
                    $this->session->set_flashdata('success', false);
                elseif ($this->session->flashdata('error')):
                    ?>
                    <div class="content pt0">
                        <div class="alert alert-danger">
                            <a class="close" data-dismiss="alert">×</a>
                            <strong><?= $this->session->flashdata('error') ?></strong>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 agencies_list">
                <div class="card-box employer-master-page">
                    <div class="row">
                        <div class="col-sm-6">
                            <form role="form">
                                <div class="form-group contact-search m-b-30">
                                    <input type="text" id="search" class="form-control" placeholder="Search..."s>
                                    <button type="submit" class="btn btn-white"><i class="fa fa-search"></i></button>
                                </div> <!-- form-group -->
                            </form>
                        </div>
                    </div>
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
                                    <th>Agency Name</th>
                                    <th>Email Address</th>
                                    <th>City</th>
                                    <th>Created Date</th>
                                    <th>Up Line</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div><!-- end col listing -->
             <div id="agency_log"></div>
        </div>
    </div>
</div>

<div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                    <h4 class="modal-title">Change Password</h4>
                </div>
                <form id="frm-save-password" action="" method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" value="" class="change-password-user-id">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">New Password</label>
                                    <input type="password" class="form-control password required" id="password" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="field-3" class="control-label">Confirm Password</label>
                                    <input type="password" class="form-control cpassword required" id="cpassword" data-parsley-equalto="#password" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info waves-effect waves-light save-change-password">Save Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- /.modal -->
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('form').parsley();
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
                [3, "DESC"]
            ],
            "sAjaxSource": "<?php echo base_url('admin/agencies/agenciesJson'); ?>",
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
        $(document).on("click", ".del_broker", function () {

            var user_id = $(this).val();
            swal({
                title: "Are you sure?",
                text: "You want to delete this Employer",
                type: "error",
                showCancelButton: true,
                cancelButtonClass: 'btn-white btn-md waves-effect',
                confirmButtonClass: 'btn-danger btn-md waves-effect waves-light',
                confirmButtonText: 'Yes delete it!'

            }, function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        method: "POST",
                        url: '<?= base_url() . 'admin/employers/removeemp' ?>',
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
        $(document).on('click', '.view_log', function () {
            var id = $(this).data("custom-value");
            console.log(id);
            $(".empmast_list").attr("class", "col-lg-9 empmast_list");
            $("#datatable").css("width", "980px");
            $('#datatable').find('tr').removeClass('active');
            $(this).parent('td').parent('tr').addClass('active');
            $.ajax({
                method: "POST",
                url: "<?php echo base_url() ?>admin/employers/show_employer_info",
                data: {empid: id},
                success: function (data) {
                    $("#employer_info").html(data);
                    $.fn.niceScroll && $(".nicescroll").niceScroll({cursorcolor: '#98a6ad', cursorborder: '#98a6ad', cursorwidth: '5px', cursorborderradius: '5px'});
                },
            });
            $('#employer_info').show();
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
                        'targets': [0, 4]
                    }],
                "order": [
                    [3, "DESC"]
                ],
                "sAjaxSource": "<?php echo base_url() ?>admin/employers/employerjson?agent_id=" + agent_id,
            });
        });
    });
    $(document).on("click", ".del_agency", function () {
        var user_id = $(this).val();

        swal({
            title: "Are you sure?",
            text: "You want to delete this agency",
            type: "error",
            showCancelButton: true,
            cancelButtonClass: 'btn-white btn-md waves-effect',
            confirmButtonClass: 'btn-danger btn-md waves-effect waves-light',
            confirmButtonText: 'Yes delete it!'
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    method: "POST",
                    url: '<?= base_url() . 'admin/agencies/remove' ?>',
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
    
        $(document).on("click", ".change-password", function () {
            var user_id = $(this).data("custom-value");
            $('.change-password-user-id').val(user_id);
            $('#con-close-modal').modal('show');
        });
        
        $(function() { 
            $('#frm-save-password').submit(function(e) { 
                e.preventDefault();
                if ( $(this).parsley().isValid() ) {
                    var user_id = $('.change-password-user-id').val();
                    var new_password = $('.password').val();
                    $('.loader-select-city').show();
                        $.ajax({
                        method: "POST",
                        url: '<?php echo base_url() ?>admin/agencies/change_password_by_admin',
                        data: {user_id: user_id, password : new_password},
                        success: function (data) {
                            $('.loader-select-city').hide();
                            $('#con-close-modal').modal('hide');
                            if(data = 'Password Successfully Change'){
                                swal("success", data, "success");
                            } else {
                                swal("error", data, "error");
                            }
                            $('.password').val();
                            $('.cpassword').val();
                            var $lmTable = $("#datatable").dataTable({bRetrieve: true});
                            $lmTable.fnDraw();
                        }
                    });
                }
            });
        });
    
    $(document).on('click', '.show_log', function () {
        var id = $(this).data("custom-value");
        $(".agencies_list").attr("class", "col-lg-9 agencies_list");
        $("#datatable").css("width", "900px");
        $('#datatable').find('tr').removeClass('active');
        $(this).parent('td').parent('tr').addClass('active');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>agency/subagencies/show_agency_log",
            data: {agencyid: id},
            success: function (data) {
                $("#agency_log").html(data);
                $.fn.niceScroll && $(".nicescroll").niceScroll({cursorcolor: '#98a6ad', cursorborder: '#98a6ad', cursorwidth: '5px', cursorborderradius: '5px'});
            },
        });
        $('#agency_log').show();
    });
    $(document).on("click", ".send_email_btn", function () {
        var email_id = $('.lead-mail-id').html();
        window.location.href = "mailto:" + email_id + "?subject=&body=";
    });
</script>

<style>
    .table-action-btn {
        margin-right: 5px;
    }
</style>