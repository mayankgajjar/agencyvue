<div class="wrapper employer_master">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title"> Employer Listing </h4>
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() . 'admin/dashboard' ?>">Admin Dashboard</a></li>
                    <li><a href="<?= base_url() . 'admin/employers' ?>">Employer Section</a></li>
                    <li class="active">Manage Employer</li>
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
            <div class="col-lg-12 empmast_list">
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
                        <div class="col-sm-2">
                            <!--<a class="btn btn-primary waves-effect waves-light" href="<?= base_url() . 'admin/employers/add_employer' ?>">Add Employer</a>-->
                        </div>
                        <div class="col-sm-4">
                            <select class="form-control input-sm agent-fliter" id="agent-selector" name="agent-fliter">
                                <option value="">Show All Members</option>
                                <?php
                                foreach ($brokers as $broker):
                                    ?>
                                    <option value="<?= $broker['user_id'] ?>"><?= $broker['display_name'] ?></option>
                                <?php endforeach; ?>
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
                                    <th>Employer Name</th>
                                    <th>Email Address</th>
                                    <th>Created Date</th>
                                    <th>Parent (Upline) Agent</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table> 
                    </div>
                </div>
            </div><!-- end col listing -->
            <div id="employer_info"></div>
        </div>
    </div>
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
                [3, "DESC"]
            ],
            "sAjaxSource": "<?php echo base_url('admin/employers/employerjson'); ?>",
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
                "sAjaxSource": "<?php echo base_url() ?>admin/employers/employerjson?agent_id=" +agent_id,
            });
        });
    });

</script>

<style> 
    .table-action-btn {
        margin-right: 5px;
    }
</style>