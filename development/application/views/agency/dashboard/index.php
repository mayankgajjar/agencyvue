<div class="wrapper">
    <div class="container">
        <?php if ($this->session->flashdata('success')) { ?>
            <div class="content pt0">
                <div class="alert alert-success">
                    <a class="close" data-dismiss="alert">?</a>
                    <strong><?= $this->session->flashdata('success') ?></strong>
                </div>
            </div>
        <?php $this->session->set_flashdata('success', false);} else if ($this->session->flashdata('error')) {?>
            <div class="content pt0">
                <div class="alert alert-danger">
                    <a class="close" data-dismiss="alert">?</a>
                    <strong><?= $this->session->flashdata('error') ?></strong>
                </div>
            </div>
        <?php $this->session->set_flashdata('error', false);} else if (validation_errors()) {?>
            <div class="content pt0">
                <div class="alert alert-danger">
                    <a class="close" data-dismiss="alert">?</a>
                    <strong><?= validation_errors() ?></strong>
                </div>
            </div>
        <?php } ?>
        
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Dashboard</h4>
                <p class="text-muted page-title-alt">Welcome <?php echo $this->session->userdata['user_info']['display_name']; ?></p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="col-lg-3">
                    <div class="widget-bg-color-icon card-box fadeInDown animated">
                        <div class="bg-icon bg-icon-primary pull-left">
                            <i class="glyphicon glyphicon-briefcase text-primary"></i>
                        </div>
                        <div class="text-right">
                            <h3 class="text-dark"><b class="counter"><?php echo count($approvedBroker); ?> </b></h3>
                            <p class="text-muted">Brokers Approved</p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="widget-bg-color-icon card-box">
                        <div class="bg-icon bg-icon-success pull-left">
                            <i class="glyphicon glyphicon-user text-success"></i>
                        </div>
                        <div class="text-right">
                            <h3 class="text-dark"><b class="counter"><?php echo $members ?></b></h3>
                            <p class="text-muted">Members Approved</p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="widget-bg-color-icon card-box">
                        <div class="bg-icon bg-icon-pink pull-left">
                            <i class="fa fa-institution text-pink"></i>
                        </div>
                        <div class="text-right">
                            <h3 class="text-dark"><b class="counter"><?php echo $subagency; ?></b></h3>
                            <p class="text-muted">Sub-Agency</p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="widget-bg-color-icon card-box">
                        <div class="bg-icon bg-icon-info pull-left">
                            <i class="glyphicon glyphicon-tags text-info"></i>
                        </div>
                        <div class="text-right">
                            <h3 class="text-dark"><b class="counter"><?php echo $products ?></b></h3>
                            <p class="text-muted">Product</p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card-box">
                    <h4 class="m-t-0 m-b-20 header-title"><b>USA Map</b></h4>
                    <div id="usa" style="height: 400px"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var mapvalue = <?php echo $mapvalueJson ?>;
    $('#usa').vectorMap({
            map : 'us_aea_en',
            backgroundColor : 'transparent',
            regionStyle : {
                    initial : {
                            fill : '#fff'
                    }
            },
            series: {regions: <?php echo $mapJson ?>},
            onRegionTipShow: function(event, label, code){
                var customer = mapvalue[code];
                if(typeof customer == 'undefined'){
                    customer = 0;
                }
                label.html(
                    '<b>'+label.html()+'</b></br>'+ 
                    '<b>Total Sales: </b>'+ customer
                );
            }            
    });
</script>  