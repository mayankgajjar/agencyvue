<div class="col-lg-3">
    <div class="card-box">
        <div class="contact-card">
            <a class="pull-left" href="#">
                <img class="img-circle"  src=<?php echo base_url('assets/images/users/avatar-5.jpg') ?> alt="">
            </a>
            <div class="member-info">
                <h4 class="m-t-0 m-b-5 header-title"><b><?php echo $result->first_name ?></b></h4>
                    <p class="text-muted"><?php echo $result->personal_email_address ?></p>
                <div class="m-t-20">
                    <a href="#" class="btn btn-purple waves-effect waves-light btn-sm">Send email</a>

                    <a href=<?php echo base_url() . 'admin/Brokers/brokerEdit?user_id=' . urlencode(base64_encode($result->user_id)) ?> class="btn btn-success waves-effect waves-light btn-sm m-l-5">Edit</a>
                    <a href="#" class="btn btn-pink waves-effect waves-light btn-sm m-l-5">Call</a>
                </div>
            </div>
        </div>
         <div class="">
            <div class="p-20">
                <h4 class="m-b-20 header-title"><b>Activities</b></h4>
                <div class="nicescroll p-l-r-10" style="max-height: 555px;">
                    <div class="timeline-2">
                        <?php foreach ($lead_log as $key => $value) { ?>
                        <div class="time-item">
                            <div class="item-info">
                                <div class="text-muted"><small><?php echo $value['log_datetime']; ?></small></div>
                                <?php if($value['section'] == '' && $value['add_product'] == '' && $value['remove_product'] == '' && $value['add_billing'] == '' && $value['remove_billing'] == ''){ ?>
                                    <p><strong> Employer <?php echo $value['action']; ?> by </strong><strong><a href="#" class="text-info"><?php echo $value['display_name']; ?></a></strong></p>
                                 <?php } else if($value['add_product'] == '' && $value['remove_product'] == '' && $value['add_billing'] == '' && $value['remove_billing'] == ''){ ?>
                                    <p><strong><a href="#" class="text-info"><?php echo $value['display_name']; ?></a></strong> <strong><?php echo $value['action']?> Employer. </strong></p>

                                <?php } ?>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>