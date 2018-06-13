<div class="col-lg-4">
    <div class="card-box">
        <div class="contact-card">
            <a class="pull-left" href="#">
                <img class="img-circle"  src=<?php echo base_url('assets/images/users/avatar-5.jpg') ?> alt="">
            </a>
            <div class="member-info">
                <h4 class="m-t-0 m-b-5 header-title"><b><?php echo $result->customer_first_name . ' ' . $result->customer_last_name ?></b></h4>
                <p class="text-muted lead-mail-id"><?php echo $result->customer_email ?></p>
                <div class="m-t-20">
                    <span  class="btn btn-purple waves-effect waves-light btn-sm send_email_btn">Send email</span>
                    <a href=<?php echo base_url() . 'admin/members/edit_member/' . urlencode(base64_encode($result->customer_id)) ?> class="btn btn-success waves-effect waves-light btn-sm m-l-5">Edit</a>
                    <a href="#" class="btn btn-pink waves-effect waves-light btn-sm m-l-5">Call</a>
                </div>
            </div>
        </div>
        <div class="">
            <div class="p-20">
                <h4 class="m-b-20 header-title"><b>Activities</b></h4>
                <div class="nicescroll p-l-r-10" style="max-height: 555px;">
                    <?php foreach ($lead_log as $key => $value) { ?>
                        <div class="timeline-2">
                            <div class="time-item">
                                <div class="item-info">
                                    <?php if ($value->action == "lead_to_member") { ?>
                                        <div class="text-muted"><small><?php echo $value->log_datetime ?></small></div>
                                        <p><strong>Lead Converted into Member by </strong><strong><a href="#" class="text-info"><?php echo $value->display_name; ?></a></strong></p>
                                    <?php } else if ($value->section == '' && $value->add_product == '' && $value->remove_product == '' && $value->add_billing == '' && $value->remove_billing == '') { ?>
                                        <div class="text-muted"><small><?php echo date('m-d-Y h:i:s a', strtotime($value->log_datetime)); ?></small></div>
                                        <p><strong>Member <?php echo $value->action; ?> by </strong><strong><a href="<?php echo base_url() . 'admin/users/brokerProfile?user_id=' . base64_encode(urlencode($value->action_by)); ?>" class="text-info"><?php echo $value->display_name; ?></a></strong></p>
                                    <?php } else if ($value->add_product == '' && $value->remove_product == '' && $value->add_billing == '' && $value->remove_billing == '') { ?>
                                        <div class="text-muted"><small><?php echo date('m-d-Y h:i:s a', strtotime($value->log_datetime)); ?></small></div>
                                        <p><strong><a href="#" class="text-info"><?php echo $value->display_name; ?></a></strong> <strong><?php echo $value->action; ?> <?php echo $value->section; ?> </strong></p>
                                            <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>