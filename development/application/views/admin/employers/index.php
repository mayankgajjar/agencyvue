<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title"> Manage Employers </h4>
            </div>
        </div>

        <div class="crm_broker_page_wapper" style="margin-top: 25px">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box table-responsive">
                        <h4 class="m-t-0 header-title"><b>New Sign up Employers</b></h4>
                        <p class="text-muted font-13 m-b-30">
                            List of Employers which needs approval for login.
                        </p>
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Employer Name</th>
                                    <th>Email Address</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Created Date</th>
                                    <th>Parent (Upline) Agent</th>
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

        <div id="tabs-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
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
</div>
<script type="text/javascript">
$(document).ready(function () {
    $('#datatable').dataTable({
            "bProcessing": true,
            "bPaginate": true,
            "bServerSide": true,
            "sAjaxSource": "<?php echo base_url('admin/employers/indexJson'); ?>",
            "columnDefs": [{
                    'orderable': false,
                    'targets': [6]
                }],
            "order": [
                [4, "DESC"]
            ],
            "pagingType": "full_numbers",
    });

    $(document).on("click", ".approved", function () {
            var user_id = $(this).val();
            swal({
                title: "Are you sure?",
                text: "You want to approved this employer request",
                type: "success",
                showCancelButton: true,
                cancelButtonClass: 'btn-white btn-md waves-effect',
                confirmButtonClass: 'btn-success btn-md waves-effect waves-light',
                confirmButtonText: 'Approved!'
            }, function (isConfirm) {
                if (isConfirm) {
                   //  console.log('Confirm');
                    $.ajax({
                        method: "POST",
                        url: '<?= base_url() . 'admin/employers/process' ?>',
                        data: {user_id: user_id, req_type: 'approved'},
                        success:
                                function (data) {
                                    var $lmTable = $("#datatable").dataTable({bRetrieve: true});
                                    $lmTable.fnDraw();
                                    //console.log('approved');
                                }
                    });
                }
            });
        });

        $(document).on("click", ".disapproved", function () {
            var user_id = $(this).val();
            swal({
                title: "Are you sure?",
                text: "You want to disapproved this employer request",
                type: "error",
                showCancelButton: true,
                cancelButtonClass: 'btn-white btn-md waves-effect',
                confirmButtonClass: 'btn-danger btn-md waves-effect waves-light',
                confirmButtonText: 'Disapproved!'
            }, function (isConfirm) {
                if (isConfirm) {
                    //console.log('Confirm');
                    $.ajax({
                        method: "POST",
                        url: '<?= base_url() . 'admin/brokers/process' ?>',
                        data: {user_id: user_id, req_type: 'disapproved'},
                        success:
                                function (data) {
                                    var $lmTable = $("#datatable").dataTable({bRetrieve: true});
                                    $lmTable.fnDraw();
                                   // console.log('disapproved');
                                }
                    });
                }
            }
            );
        });
});
</script>

