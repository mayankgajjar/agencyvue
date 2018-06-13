<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Product Verification Script</h4>
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() . 'admin/dashboard' ?>">Dashboard</a></li>
                    <li class="active">Product Verification Script</li>
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
        <?php $this->session->set_flashdata('success', false);} else if ($this->session->flashdata('error')) {?>
            <div class="content pt0">
                <div class="alert alert-danger">
                    <a class="close" data-dismiss="alert">×</a>
                    <strong><?= $this->session->flashdata('error') ?></strong>
                </div>
            </div>
        <?php } else if (validation_errors()) { ?>
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
                                    </th>
                                    <th>Script Name</th>
                                    <th>State</th>
                                    <th>Product Name</th>
                                    <th>Created Date</th>
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

<script type="text/javascript">
    $(document).ready(function () {

      $('#datatable').dataTable({
          "bProcessing": true,
          "bPaginate": true,
          "bServerSide": true,
          "pagingType": "full_numbers",
          "columnDefs": [{
                  'orderable': false,
                  'targets': [0]
              }],
          "order": [
              [3, "DESC"]
          ],
          "sAjaxSource": "<?php echo base_url() ?>admin/settings/ProductScriptJson"
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
        //$('.ch_checkbox').live('click',function(){
        $(document).on('click', '.ch_checkbox', function () {
            if ($('.ch_checkbox:checked').length == $('.ch_checkbox').length) {
                $('#action_checkbox').prop('checked', true);
            } else {
                $('#action_checkbox').prop('checked', false);
            }
        });

        $(document).on("click", ".del_script", function () {
            var script_id = $(this).data("custom-value");
            swal({
                title: "Are you sure?",
                text: "You want to delete this verification script",
                type: "error",
                showCancelButton: true,
                cancelButtonClass: 'btn-white btn-md waves-effect',
                confirmButtonClass: 'btn-danger btn-md waves-effect waves-light',
                confirmButtonText: 'Yes delete it!'
            }, function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        method: "POST",
                        url: '<?= base_url() . 'admin/settings/remove_verification' ?>',
                        data: {script_id1: script_id},
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


