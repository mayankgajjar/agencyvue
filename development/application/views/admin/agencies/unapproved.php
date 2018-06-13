<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title"> Manage Un-approved Agencies </h4>
            </div>
        </div>
        <div class="crm_broker_page_wapper" style="margin-top: 25px">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box table-responsive">
                        <h4 class="m-t-0 header-title"><b>New Sign up Agencies</b></h4>
                        <p class="text-muted font-13 m-b-30">
                            List of Agencies which needs approval for login.
                        </p>
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Agency Name</th>
                                    <th>Email Address</th>
                                    <th>City</th>
                                    <th>Created Date</th>
                                    <th>Up Line</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div id="tabs-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content p-0">
                    <div class="modal-body">
                        <div class="placeholder-div" id="profile-data"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="custom-loader" style="display: none">
        <div class="loader"></div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable').dataTable({
            "bProcessing": true,
            "bPaginate": true,
            "bServerSide": true,
            "sAjaxSource": "<?php echo base_url('admin/agencies/unapprovedJson'); ?>",
            "columnDefs": [{
                    'orderable': false,
                    'targets': [5]
                }],
            "order": [
                [3, "DESC"]
            ],
            "pagingType": "full_numbers",
        });

        $(document).on("click", ".approved", function () {
            var user_id = $(this).val();
            swal({
                title: "Are you sure?",
                text: "You want to approved this Agency request",
                type: "success",
                showCancelButton: true,
                cancelButtonClass: 'btn-white btn-md waves-effect',
                confirmButtonClass: 'btn-success btn-md waves-effect waves-light',
                confirmButtonText: 'Approved!'
            }, function (isConfirm) {
                if (isConfirm) {
                    // console.log('Confirm');
                    $(".custom-loader").show();
                    $.ajax({
                        method: "POST",
                        url: '<?= base_url() . 'admin/agencies/process' ?>',
                        data: {user_id: user_id, req_type: 'approved'},
                        success:
                                function (data) {
                                    $(".custom-loader").hide();
                                    var $lmTable = $("#datatable").dataTable({bRetrieve: true});
                                    $lmTable.fnDraw();
                                }
                    });
                }
            });
        });
        $(document).on("click", ".view_profile", function () {
            var userID = $(this).val();
            $(".custom-loader").show();
            $.ajax({
                method: "POST",
                url: '<?= base_url() . 'admin/agencies/profile' ?>',
                data: {user_id: userID, req_type: 'disapproved'},
                success:
                        function (data) {
                            $("#profile-data").html(data);
                            $('#tabs-modal').modal('show');
                            $(".custom-loader").hide();
                        }
            });
        });
        $(document).on("click", ".disapproved", function () {
            var user_id = $(this).val();
            swal({
                title: "Are you sure?",
                text: "You want to disapproved this Agency request",
                type: "error",
                showCancelButton: true,
                cancelButtonClass: 'btn-white btn-md waves-effect',
                confirmButtonClass: 'btn-danger btn-md waves-effect waves-light',
                confirmButtonText: 'Disapproved!'
            }, function (isConfirm) {
                if (isConfirm) {
                    $(".custom-loader").show();
                    $.ajax({
                        method: "POST",
                        url: '<?= base_url() . 'admin/agencies/process' ?>',
                        data: {user_id: user_id, req_type: 'disapproved'},
                        success:
                                function (data) {
                                    swal("success", data, "success");
                                    $(".custom-loader").hide();
                                    var $lmTable = $("#datatable").dataTable({bRetrieve: true});
                                    $lmTable.fnDraw();
                                }
                    });
                }
            }
            );
        });
    });
</script>