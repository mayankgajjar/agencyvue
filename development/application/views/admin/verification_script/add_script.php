
<div class="wrapper featured-product-custom-editor">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Verification Script</h4>
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() . 'admin/dashboard' ?>">Dashboard</a></li>
                    <li><a href="#">Settings</a></li>
                    <li class="active">Verification Script</li>
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
            <div class="col-sm-12">
                <div class="card-box">
                        <form method="post" name="" class="data-parsley-validate novalidate">
                            <div class="row">
                                <div class="col-sm-8"><textarea id="elm1" name="area"></textarea></div>
                                <div class="col-sm-4">
                                  <div class="row">
                                    <div class="col-lg-12">
                                      <div class="input_wrapper">
                                          <label>Verification Script Name * </label>
                                          <input type="text" id="script_name" name="script_name" class="form-control required" autocomplete="off" value="<?php echo set_value('script_name'); ?>">
                                      </div>
                                    </div>
                                  </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="checkbox checkbox-primary">
                                                <input id="singal_state" type="checkbox" name="state_type" value="singal_state" class="state_type" checked>
                                                <label for="singal_state">Singal State</label>
                                            </div>
                                        </div>
                                        <?php if(sizeof($is_all) == 0) { ?>
                                          <div class="col-lg-6">
                                              <div class="checkbox checkbox-primary">
                                                  <input id="all_state" type="checkbox" name="state_type" value="all_state" class="state_type">
                                                  <label for="all_state">All State</label>
                                              </div>
                                          </div>
                                        <?php } ?>
                                    </div>
                                    <div class="row sel-state">
                                        <div class="col-lg-12">
                                            <div class="input_wrapper">
                                                <label>Select States</label>
                                                <select class="select2 select2-multiple state-list required" multiple="multiple" multiple data-placeholder="Choose state names" name="script_state[]">
                                                    <?php foreach ($state as $state): ?>
                                                        <option value="<?= $state['state_code']; ?>"><?= $state['state']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 m-t-30">
                                    <div class="form-group tex-center">
                                        <button type="submit" id="add-script" class="btn btn-success waves-effect waves-light" name="save" value="save"> Create Product Verification Script </button>
                                        <a class="btn btn-default waves-effect waves-light save-button" href="<?= base_url() . 'admin/settings/verification_script' ?>"> <span class="btn-label"><i class="fa fa-arrow-left"></i></span>Back</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('form').parsley();
        $('.select2-multiple').select2();

        $(document).on('click', '.state_type', function () {
            var type = $(this).val();
            if (type == "all_state") {
              $('.state-list').removeClass('required');
                $('.sel-state').hide();
                $('#singal_state').prop('checked', false); // Unchecks it
            }
            if (type == "singal_state") {
                $('.state-list').addClass('required');
                $('.sel-state').show();
                $('#all_state').prop('checked', false); // Unchecks it
            }
        });

        if ($("#elm1").length > 0) {
            tinymce.init({
                selector: "textarea#elm1",
                theme: "modern",
                height: 300,
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                    "save table contextmenu directionality emoticons template paste textcolor"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
                style_formats: [
                    {title: 'Bold text', inline: 'b'},
                    {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                    {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                    {title: 'Example 1', inline: 'span', classes: 'example1'},
                    {title: 'Example 2', inline: 'span', classes: 'example2'},
                    {title: 'Table styles'},
                    {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
                ]
            });
        }
    });
</script>
