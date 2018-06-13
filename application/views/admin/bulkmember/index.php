<style>
.csv-upload-btn{clear: both;margin: 0;}
.csv-form-title{clear: both;padding-left: 20px;margin-top: 0;font-size: 22px;}
</style>
<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Bulk Member Upload</h4>
                <ol class="breadcrumb">
                </ol>
            </div>
        </div>
        
        <?php if(isset($errors_of_sheet)){?>
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title">No of Error : <?php echo count($errors_of_sheet['result']) ?></h5>
                </div>
                <div class="panel-body">
                    Please find below list of error. Please correct <code>Error Message</code> and upload again this records.
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Date of Birth</th>
                                <th>Error Message</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $i = 1;
                                foreach ($errors_of_sheet['result'] as $key => $value){ 
                                ?>
                                <tr class="danger">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $value['first_name'] ?></td>
                                    <td><?php echo $value['middle_name'] ?></td>
                                    <td><?php echo $value['last_name'] ?></td>
                                    <td><?php echo $value['email'] ?></td>
                                    <td><?php echo $value['phone_number'] ?></td>
                                    <td><?php echo $value['DOB'] ?></td>
                                    <td style="color:red;font-size:16px;"><?php echo $value['error']['error'] ?></td>
                                </tr>
                            <?php $i++; } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } ?>
        
        <div class="row">
            <?php if ($this->session->flashdata('success')) { ?>
                <div class="content pt0">
                    <div class="alert alert-success">
                        <a class="close" data-dismiss="alert">×</a>
                        <strong><?= $this->session->flashdata('success') ?></strong>
                    </div>
                </div>
            <?php $this->session->set_flashdata('success', false);} else if ($this->session->flashdata('error')) {?>
                <div class="content pt0">
                    <div class="alert alert-danger alert-styled-left alert-bordered">
                        <a class="close" data-dismiss="alert">×</a>
                        <strong><?= $this->session->flashdata('error') ?></strong>
                    </div>
                </div>
            <?php $this->session->set_flashdata('error', false);} else if(!isset($errors_of_sheet)){echo validation_errors();}?>

            <div class="col-lg-12 col-md-12 card-box all_details_broker_profile">
                <form method="post" enctype="multipart/form-data" data-parsley-validate novalidate>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group clearfix" >
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <a href="<?php echo site_url().'assets/Download/member_data_format.csv' ?>" class="btn btn-success">Download Member Date Format</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h3 class="csv-form-title"><strong>CSV File Upload</strong></h3>
                        <div class="col-lg-12">
                            <div class="form-group clearfix" >
                                <div class="form-group input_wrapper">
                                    <div class="col-lg-4">
                                        <label class="control-label">Select File</label>
                                        <input type="file" name="file" class="filestyle required" data-buttonname="btn-default" onchange="Validateverification(this);">
                                        <div class="error_csv" style="font-style: italic; color: red; margin-top: 8px; display: none;">Please select CSV file format.</div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <div class="row csv-upload-btn">
                            <div class="col-md-12">
                                <div class="col-md-1">
                                    <div class="submit-wapper">
                                        <input type="submit" class="btn btn-success btn-md" name="Upload" value="Upload" />
                                    </div>
                                </div>
                                <div class="col-md-1"> 
                                    <?php if($this->session->userdata['user_info']['roll_id'] == 1){ ?>
                                        <a class="btn btn-default btn-md waves-effect waves-light" href="<?= base_url() . 'admin/dashboard' ?>"> <span class="btn-label"><i class="fa fa-arrow-left"></i></span>Back</a>
                                    <?php } else if($this->session->userdata['user_info']['roll_id'] == 2) {?>
                                        <a class="btn btn-default btn-md waves-effect waves-light" href="<?= base_url() . 'agent/dashboard' ?>"> <span class="btn-label"><i class="fa fa-arrow-left"></i></span>Back</a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
                </div>
            </div>
        </div>
    </div> <!-- end container -->
</div>
<!-- end wrapper -->

<script type="text/javascript">
    var _validFileExtensions = [".csv"];
    function Validateverification(oInput) {
        if (oInput.type == "file") {
            var sFileName = oInput.value;
            if (sFileName.length > 0) {
                var blnValid = false;
                for (var j = 0; j < _validFileExtensions.length; j++) {
                    var sCurExtension = _validFileExtensions[j];
                    if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                        blnValid = true;
                        $(".error_csv").hide();
                        break
                    }
                }
                if (!blnValid) {
                    $(".error_csv").show();
                    oInput.value = "";
                    return false;
                }
            }
        }
        return true;
    }
</script>

