 <script type="text/javascript" src="<?php echo base_url() ?>assets/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title"><?php echo "Get {$type} Leads" ?></h4>
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() . 'agent/dashboard' ?>">Dashboard</a></li>
                    <li class="active">Lead Filters</li>
                </ol>
            </div>
        </div>
        <style>.tab-content{background: #303841;margin-bottom: 30px; padding: 30px;}</style>
        <div class="row">
            <div class="col-lg-12 lead_list">
                <div class="card-box">
                <div class="tabbable-custom nav-justified">
                    <ul class="nav nav-tabs tabs">
                        <li class="tab  active">
                            <a class="nav-link" href="#tab_lead_type" data-toggle="tab"> <?php echo 'Lead Type' ?> </a>
                        </li>
                        <li class="tab ">
                            <a  href="#tab_states" data-toggle="tab"> <?php echo 'States' ?> </a>
                        </li>
                        <li class="tab ">
                            <a  href="#tab_age" data-toggle="tab"> <?php echo 'Age' ?> </a>
                        </li>
                        <li class="tab ">
                            <a  href="#tab_area" data-toggle="tab"> <?php echo 'Area Codes' ?> </a>
                        </li>
                        <li class="tab ">
                            <a  href="#tab_zip" data-toggle="tab"> <?php echo 'Zip Codes' ?> </a>
                        </li>
                        <li class="tab ">
                            <a href="#tab_phone" data-toggle="tab"> <?php echo 'Phone Options' ?> </a>
                        </li>

                    </ul>
                    <form method="post" id="filteForm" onsubmit="javascript:filterSubmit(event)">
                        <input type="hidden" name="category" value="<?php echo $type ?>" />
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_lead_type">
                                <?php $this->load->view('agent/leadstore/checkout/tabs/leadtype') ?>
                            </div>
                            <div class="tab-pane" id="tab_states">
                               <?php $this->load->view('agent/leadstore/checkout/tabs/states') ?>
                            </div>
                            <div class="tab-pane" id="tab_age">
                                <?php $this->load->view('agent/leadstore/checkout/tabs/age') ?>
                            </div>
                            <div class="tab-pane" id="tab_area">
                               <?php $this->load->view('agent/leadstore/checkout/tabs/area_code') ?>
                            </div>
                            <div class="tab-pane" id="tab_zip">
                                <?php $this->load->view('agent/leadstore/checkout/tabs/zip') ?>
                            </div>
                            <div class="tab-pane" id="tab_phone">
                                <br />
                               <?php $this->load->view('agent/leadstore/checkout/tabs/phone') ?>
                            </div>
                        </div>
                    </form>
                    <div class="text-right">
                        <button type="button" class="btn btn-primary waves-effect waves-light" onclick="jQuery('#filteForm').submit()"><?php echo 'Apply Filters' ?></button>
                    </div>
                </div>
                <div class="filter-result">
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script type="text/javascript">
    function filterSubmit(event){
        event.preventDefault();
        var postData = jQuery('#filteForm').serialize();
        postData += '&is_ajax='+true;
        var totalState = jQuery('.select-state').length;
        var count = 0;
        jQuery('.select-state').each(function(){
          if(jQuery(this).is(':checked')){
            count++;
          }
        });
        if(totalState == count){
            postData += '&filter_by_state=all';
        }
        jQuery('#loading').modal('show');
        jQuery.ajax({
            url : '<?php echo site_url('agent/checkout/filterPost') ?>',
            method : 'post',
            dataType : 'json',
            data : postData,
            success : function(result){
                jQuery('#loading').modal('hide');
                var flag = Boolean(result.success);
                if(flag){
                    jQuery('.filter-result').html(result.html);
                    jQuery('.filter-result').show();
                    jQuery('.tabbable-custom').hide();
                }
            }
        });
    }   
</script>