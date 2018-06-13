<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Members</h4>
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() . 'agent/dashboard' ?>">Dashboard</a></li>
                    <li class="active">Members</li>
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
            <?php
            $this->session->set_flashdata('success', false);
        } else if ($this->session->flashdata('error')) {
            ?>
            <div class="content pt0">
                <div class="alert alert-danger">
                    <a class="close" data-dismiss="alert">×</a>
                    <strong><?= $this->session->flashdata('error') ?></strong>
                </div>
            </div>

            <?php
            $this->session->set_flashdata('error', false);
        } else if (validation_errors()) {
            ?>
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
                        <div class="col-sm-3">
                            <a class="btn btn-primary waves-effect waves-light" href="<?= base_url() . 'agent/members/add_member' ?>">Add Members</a>
                        </div>
                        <div class="col-sm-3">
                            <select class="form-control input-sm agent-fliter" id="status-selector" name="agent-fliter">
                                <option value="">Show All Members</option>
                                <option value="Y">Show Active Members Only</option>
                                <option value="N">Show In Active Members Only</option>
                            </select>
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
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Created Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div> <!-- end col -->
            <div id="member_info"></div>
        </div>
    </div> <!-- end container -->
    <div id="custom-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog" style="width:55%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                    <h4 class="modal-title" id="custom-width-modalLabel">Please Give The Reason For Inactive This Member</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <input type="hidden" value="" class="inactive-user-value">
                            <label for="select-reason"> Select Suitable Reason </label>
                            <select id="select-reason" name="reason-for" class="form-control">
                                <option value="">Select Reason</option>
                                <option value="1">Payment Declined</option>
                                <option value="2">Chargeback</option>
                                <option value="3">Cancelled</option>
                                <option value="4">Lost to Competitor</option>
                                <option value="5">Coverage through Employer</option>
                                <option value="6">Unsatisfied</option>
                                <option value="7">Never Received Fulfillment</option>
                                <option value="8">Changed Mind</option>
                                <option value="9">Can't Afford</option>
                                <option value="10">Not Adequate Coverage</option>
                            </select>
                            <div class="error-box-inactive" style="color: red"></div>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger waves-effect waves-light inactive-btn">Inactive Member</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable').dataTable({
            "bProcessing": true,
            "bPaginate": true,
            "bServerSide": true,
            "pagingType": "full_numbers",
            "columnDefs": [{
                    'orderable': false,
                    'targets': [0, 5]
                }],
            "order": [
                [4, "DESC"]
            ],
            "sAjaxSource": "<?php echo base_url() ?>agent/members/indexJson",
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
        $(document).on('click', '.ch_checkbox', function () {
            if ($('.ch_checkbox:checked').length == $('.ch_checkbox').length) {
                $('#action_checkbox').prop('checked', true);
            } else {
                $('#action_checkbox').prop('checked', false);
            }
        });
//        $(document).on("click", ".del_lead", function () {
//            var user_id = $(this).data("custom-value");
//            swal({
//                title: "Are you sure?",
//                text: "You want to delete this Member",
//                type: "error",
//                showCancelButton: true,
//                cancelButtonClass: 'btn-white btn-md waves-effect',
//                confirmButtonClass: 'btn-danger btn-md waves-effect waves-light',
//                confirmButtonText: 'Yes delete it!'
//            }, function (isConfirm) {
//                if (isConfirm) {
//                    $.ajax({
//                        method: "POST",
//                        url: '<?php echo base_url() ?>agent/members/removemember?>',
//                        data: {user_id: user_id},
//                        success: function (data) {
//                            swal("success", data, "success");
//                            var $lmTable = $("#datatable").dataTable({bRetrieve: true});
//                            $lmTable.fnDraw();
//                            // console.log('disapproved');
//                        }
//                    });
//                }
//            });
//        });
        $(document).on("click", ".active-member", function () {
            var user_id = $(this).data("custom-value");
            $.ajax({
                method: "POST",
                url: '<?php echo base_url() ?>agent/members/activemember',
                data: {user_id: user_id},
                success: function (data) {
                    swal("success", data, "success");
                    var $lmTable = $("#datatable").dataTable({bRetrieve: true});
                    $lmTable.fnDraw();
                }
            });
        });

        $(document).on("click", ".inactive-member", function () {
            var user_id = $(this).data("custom-value");
            $('.inactive-user-value').val(user_id);
            $('#custom-width-modal').modal('show');
        });

        $(document).on("click", ".inactive-btn", function () {
            var user_id = $('.inactive-user-value').val();
            var selectReason = $("#select-reason").val();
            if (selectReason == "") {
                $(".error-box-inactive").html("Please Give The Reason For Submit Your Request");
            } else {
                $(".error-box-inactive").html(" ");
                $.ajax({
                    method: "POST",
                    url: '<?php echo base_url() ?>agent/members/inactivemember',
                    data: {user_id: user_id, reason: selectReason},
                    success: function (data) {
                        $('#custom-width-modal').modal('hide');
                        swal("success", data, "success");
                        var $lmTable = $("#datatable").dataTable({bRetrieve: true});
                        $lmTable.fnDraw();
                        // console.log('disapproved');
                    }
                });
            }
        });
        $(document).on('click', '.lead_det', function () {
            var id = $(this).data("custom-value");
            $(".lead_list").attr("class", "col-lg-9 lead_list");
            $("#datatable").css("width", "800px");
            $('#datatable').find('tr').removeClass('active');
            $(this).parent('td').parent('tr').addClass('active');
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>agent/members/show_member_info",
                data: {memberid: id},
                success: function (data) {
                    $("#member_info").html(data);
                    $.fn.niceScroll && $(".nicescroll").niceScroll({cursorcolor: '#98a6ad', cursorborder: '#98a6ad', cursorwidth: '5px', cursorborderradius: '5px'});
                },
            });
            $('#member_info').show();
        });
        $(document).on('change', '#status-selector', function () {
            var valueStatus = $(this).val();
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

                "sAjaxSource": "<?php base_url() ?>members/indexJson?status=" + valueStatus

            });
        });
    });
</script>