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
                            <button class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#custom-width-modal">Add Lead</button>
                        </div>
                        <div class="col-sm-4">
                            <select class="form-control input-sm agent-fliter" id="agent-selector" name="agent-fliter">
                                <option value="">Show All Leads</option>
                                <?php foreach ($agencts as $agencts): ?>
                                    <option value="<?= $agencts['user_id'] ?>"><?= $agencts['display_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <form role="form">
                                <div class="form-group contact-search m-b-30">
                                    <a class="btn btn-success waves-effect waves-light" href="<?= base_url() . 'agency/settings/blukleadupload' ?>">Bulk Lead Upload</a>
                                    <a class="btn btn-success waves-effect waves-light" href="<?= base_url() . 'admin/ExportData/export_lead' ?>">Export Lead</a>
                                </div> <!-- form-group -->
                            </form>
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
                                    <th>Added By</th>
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
            <div id="lead_info">

            </div>
        </div>
    </div> <!-- end container -->
</div>
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
                        <label for="name">Gender*</label>
                        <input type="radio" name="gender" class="gendercheckbox" value="male" checked> Male
                        <input type="radio" name="gender" value="female"> Female
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
                    'targets': [0, 5]
                }],
            "order": [
                [4, "DESC"]
            ],
            "sAjaxSource": "<?php base_url() ?>leads/leadsJson"
        });
        $('#search').on('keyup click', function () {
            $('#datatable').DataTable().search(
                    $('#search').val()
                    ).draw();
        });
        $("#add_lead").click(function (e) {
            e.preventDefault();
            var firstname = $("#first_name1").val();
            var lastname = $("#last_name1").val();
            var email = $("#email1").val();
            var contact = $("#contact1").val();
            var gender = $('input[name=gender]:checked').val();

            var error = 0;
            if (firstname == "") {
                $('#error-fname').show();
                $("#first_name1").addClass("textInputError");
                error = 1;
            }
            if (lastname == "") {
                $('#error-lname').show();
                $("#last_name1").addClass("textInputError");
                error = 1;
            }
            if (email == "") {
                $('#error-email').show();
                $("#email1").addClass("textInputError");
                error = 1;
            }
            if (email != "") {
                var reg = /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/
                if (reg.test(email)) {
                    error = 0;
                } else {
                    $('#error-valid-email').show();
                    $("#email1").addClass("textInputError");
                    error = 1;
                }
            }

            if (contact == "") {
                $('#error-phone').show();
                $("#contact1").addClass("textInputError");
                error = 1;
            }

            if (error == 0) {
                $.ajax({
                    type: "POST",
                    url: "<?php base_url() ?>leads/add_lead",
                    data: {first: firstname, last: lastname, email1: email, con: contact,gender: gender},
                    success: function (data) {
                        swal("success", data, "success");
                        var $lmTable = $("#datatable").dataTable({bRetrieve: true});
                        $lmTable.fnDraw();
                        $("#frm_lead1")[0].reset();
                        $('#custom-width-modal').modal('hide');
                    },
                });
            }

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
        $(document).on('click', '.lead_det', function () {
            //e.preventDefault();
            var id = $(this).data("custom-value");
            $(".lead_list").attr("class", "col-lg-8 lead_list");
            $("#datatable").css("width", "900px");
            $('#datatable').find('tr').removeClass('active');
            $(this).parent('td').parent('tr').addClass('active');
            $.ajax({
                type: "POST",
                url: "<?php base_url() ?>leads/show_lead_info",
                data: {leadid: id},
                success: function (data) {
                    $("#lead_info").html(data);
                    $.fn.niceScroll && $(".nicescroll").niceScroll({cursorcolor: '#98a6ad', cursorborder: '#98a6ad', cursorwidth: '5px', cursorborderradius: '5px'});
                },
            });
            $('#lead_info').show();
        });
        $(document).on("click", ".del_lead", function () {
            var user_id = $(this).data("custom-value");
            ;
            swal({
                title: "Are you sure?",
                text: "You want to delete this lead",
                type: "error",
                showCancelButton: true,
                cancelButtonClass: 'btn-white btn-md waves-effect',
                confirmButtonClass: 'btn-danger btn-md waves-effect waves-light',
                confirmButtonText: 'Yes delete it!'
            }, function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        method: "POST",
                        url: '<?= base_url() . 'agent/leads/removelead' ?>',
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
        $(document).on("click", ".send_email_btn", function () {
            var email_id = $('.lead-mail-id').html();
            window.location.href = "mailto:" + email_id + "?subject=&body=";
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
                "sAjaxSource": "<?php base_url() ?>leads/leadsJson?agent_id=" + agent_id
            });
        });
    });

    $(document).on("click", ".send_email_btn", function () {
        var email_id = $('.lead-mail-id').html();
        window.location.href = "mailto:" + email_id + "?subject=&body=";
    });
    jQuery(document).on("dblclick", "#datatable tbody tr", function (event) {
        var edit_url = $(this).find('.edit_btn').attr('href');
        window.location.href = edit_url;

    });
</script>