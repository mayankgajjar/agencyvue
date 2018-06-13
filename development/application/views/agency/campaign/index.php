<style>

    .dataTables_filter{ display: none; }

    .card-box ul.pagination{float: right;}

    .lead-page table#datatable {

        width: 100% !important;

    }



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


<?php echo "date".date('Y-m-d H:i:s', time())?>
<div class="wrapper">

    <div class="container">

        <!-- Page-Title -->

        <div class="row">

            <div class="col-sm-12">

                <h4 class="page-title">Lead Store</h4>

                <ol class="breadcrumb">

                    <li><a href="<?= base_url() . 'agent/dashboard' ?>">Dashboard</a></li>

                    <li class="active">Lead Store</li>

                </ol>

            </div>

        </div>



        <?php if ($this->session->flashdata('success')) { ?>

            <div class="content pt0">

                <div class="alert alert-success">

                    <a class="close" data-dismiss="alert">&times;</a>

                    <strong><?= $this->session->flashdata('success') ?></strong>

                </div>

            </div>

            <?php $this->session->set_flashdata('success', false);} else if ($this->session->flashdata('error')) {?>

            <div class="content pt0">

                <div class="alert alert-danger">

                    <a class="close" data-dismiss="alert">&times;</a>

                    <strong><?= $this->session->flashdata('error') ?></strong>

                </div>

            </div>

            <?php $this->session->set_flashdata('error', false);} else if (validation_errors()) {?>

            <div class="content pt0">

                <div class="alert alert-danger">

                    <a class="close" data-dismiss="alert">&times;</a>

                    <strong><?= validation_errors() ?></strong>

                </div>

            </div>

        <?php } ?>



        <div class="row">

            <div class="col-lg-12 lead_list">

                <div class="card-box lead-page">

                    <div class="row">

                        <div class="col-md-11" style="padding-left: 0px;">

                            <p class="text-info" style="font-weight: bold;font-size: 20px;">Total Balance: <?php echo formatMoney($balance, 2, true) ?></p>

                        </div>

                        <div class="col-md-1">

                            <button class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#custom-width-modal">Add Fund</button>

                        </div>

                        <?php /*

                        <div class="col-sm-6">

                            <form role="form">

                                <div class="form-group contact-search m-b-30">

                                    <input type="text" id="search" class="form-control" placeholder="Search..."s>

                                    <button type="submit" class="btn btn-white"><i class="fa fa-search"></i></button>

                                </div> <!-- form-group -->

                            </form>

                        </div>

                        */ ?>

                    </div>

                    <div class='row'>

                        <h3><?php echo 'Real Time Leads' ?></h3>

                    </div>

                    <div class="table-responsive1 table-responsive">

                        <table class="table table-hover" id="datatable">

                            <thead>

                                <tr>

                                    <th>#</th>

                                    <th>Name</th>

                                    <th>Type</th>

                                    <th>Action</th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php $i=1;foreach($campaigns as $campaign): ?>

                                    <tr>

                                        <td><?php echo $i; ?></td>

                                        <td><?php echo $campaign->name; ?></td>

                                        <td><?php echo $campaign->type; ?></td>

                                        <td>

                                            <?php

                                                $checked = '';

                                                if($campaign->status == 'Active'){

                                                    $checked = 'checked';

                                                }

                                            ?>

                                            <input class="js-switch" data-filter="<?php echo $campaign->id; ?>" type="checkbox" data-plugin="switchery"  data-color="#1AB394" data-secondary-color="#ED5565" <?php echo $checked; ?> />

                                        </td>

                                    </tr>

                                    <?php $i++; ?>

                                <?php endforeach; ?>

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



<!-- end wrapper -->



<div id="custom-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">

    <div class="modal-dialog" style="width:35%;">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>

                <h4 class="modal-title" id="custom-width-modalLabel">Add Fund</h4>

            </div>

            <div class="modal-body">

                <form id="frm_lead1" method="POST" class="data-parsley-validate novalidate" onsubmit="javascript:addFund(event)">

                    <!--<form role="form" method="POST" action="" id="frm_lead1" class="data-parsley-validate novalidate">-->

                    <div class="form-group">

                        <label for="name">First Name*</label>

                        <input type="text" class="form-control required" id="amount" placeholder="Enter Amount" name="amount">

                    </div>

                    <div class="form-group">

                        <label for="name">Comment</label>

                        <textarea class="form-control" name="comment"></textarea>

                    </div>

                    <button type="submit" style="display: none;" id="form-submit">Submit</button>

                </form>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-default waves-effect waves-light" id="add_lead" onclick="jQuery('#form-submit').trigger('click')">Submit<i class="spinner fa fa-cog fa-spin fa-fw margin-bottom" style="display: none;"></i></button>

                <button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Close</button>

            </div>

        </div><!-- /.modal-content -->\

    </div><!-- /.modal-dialog -->



</div>
<script type="text/javascript">
    jQuery(function(){
    $('#datatable2').dataTable({
        "pagingType": "full_numbers",
        "columnDefs": [{
                'orderable': false,
                'targets': [0,5]
            }],
    });

    $('#datatable').dataTable({

                "bPaginate": true,

                "pagingType": "full_numbers",

                "columnDefs": [{

                        'orderable': false,

                        'targets': [0,3]

                    }],

                "order": [

                    [1, "DESC"]

                ],

            });



        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

        elems.forEach(function(html) {

            var switchery = new Switchery(html, { color: '#1AB394', secondaryColor: '#ED5565' });

        });



        jQuery(document).on('change', '.js-switch', function(){

            var flag = jQuery(this).is(':checked');

            var postData = {

                status: 0,

                id: jQuery(this).attr('data-filter')

            };

            if(flag == true){

                var postData = {

                    status: 1,

                    id: jQuery(this).attr('data-filter')

                };

            }



            jQuery.ajax({

                url: '<?php echo site_url('agent/campaign/changeStatus') ?>',

                method: 'POST',

                data: postData,

                dataType: 'json',

                success: function(res){

                    location.reload();

                }

            });

        });

    });



    function addFund(event){

        event.preventDefault();

        jQuery('.spinner').show();

        var postData = jQuery('#frm_lead1').serialize();

        jQuery.ajax({

            url: '<?php echo site_url("agency/campaign/addfund") ?>',

            method: 'post',

            data: postData,

            dataType: 'JSON',

            success: function(res){

                jQuery('.spinner').hide();

                location.reload();

            }

        });

    }

</script>



    <div class="container">

        <!-- Page-Title -->

        <style>.breadcrumb > li + li::before {content: "";}</style>

        <div class="row">

            <div class="col-lg-12 lead_list">

                <div class="card-box lead-page">

                    <h4 class="page-title">Aged Leads</h4>

                    <div class="row">

                        <div class="col-md-11"></div>

                        <div class="col-md-1">

                            <button class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#custom-width-modal2">Order</button>

                        </div>

                    </div>

                    <div class="table-responsive1 table-responsive">

                        <table class="table table-hover" id="datatable2">

                            <thead>

                                <tr>

                                    <th>#</th>

                                    <th>Purchased Date</th>

                                    <th>Lead Type</th>

                                    <th>Lead Count</th>

                                    <th>Amount</th>

                                    <th>Action</th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php $i=1;foreach($lead_order as $lorder): ?>

                                <tr>

                                    <td><?php echo $i; ?></td>

                                    <td><?php echo $lorder['created'];  ?></td>

                                    <td><?php echo $lorder['lead_type'];  ?></td>

                                    <td><?php echo $lorder['qty'];  ?></td>

                                    <td><?php echo formatMoney($lorder['total_amount'],2, TRUE);  ?></td>

                                    <td>&nbsp;</td>

                                </tr>

                                <?php $i++; ?>

                                <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div> <!-- end col -->

        </div>

    </div> <!-- end container -->



<div id="custom-width-modal2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">

    <div class="modal-dialog" style="width:35%;">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>

                <h4 class="modal-title" id="custom-width-modalLabel">Select Lead Type</h4>

            </div>

            <div class="modal-body">

                <form id="frm_lead1" method="post" action="<?php echo site_url('agency/checkout/filter') ?>" class="data-parsley-validate novalidate">

                    <!--<form role="form" method="POST" action="" id="frm_lead1" class="data-parsley-validate novalidate">-->

                    <div class="form-group">

                        <label for="name">Lead Type&nbsp;*</label>

                        <select name="leadtype" class="form-control">

                            <option value="">Select Lead Type</option>

                            <option value="Health">Health</option>

                            <option value="Life">Life</option>

                            <option value="Final Expenses">Final Expense</option>

                            <option value="Medicare">Medicare</option>

                        </select>

                    </div>

                    <button type="submit" style="display: none;" id="form-submit2">Submit</button>

                </form>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-default waves-effect waves-light"  onclick="jQuery('#form-submit2').trigger('click')">Submit<i class="spinner fa fa-cog fa-spin fa-fw margin-bottom" style="display: none;"></i></button>

                <button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Close</button>

            </div>

        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->

</div>