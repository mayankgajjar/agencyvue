 <style>
    #cart-table table tbody tr td:nth-child(3) {
        word-break: break-all;
    }
    .card-box{padding: 30px;}
</style>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title"><?php echo $pagetitle ?> </h4>
                <ol class="breadcrumb">
                    <li><a href="<?= base_url() . 'agency/dashboard' ?>">Dashboard</a></li>
                    <li class="active">Lead Store</li>
                </ol>
            </div>
        </div>

    <?php if ($this->session->flashdata('success') != ''): ?>
        <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?php echo $this->session->flashdata('success'); ?>
        </div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error') != ''): ?>
        <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?php echo $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>
     <div class="row">
        <div class="col-lg-12 lead_list">
            <div class="card-box">
                <form action="" method="post" name="cart_list" id="cart_list" onsubmit="remove_list_data(event)">
                    <?php if ($this->session->userdata('lead_cart') != '' && count($this->session->userdata('lead_cart')) > 0): ?>
                        <div class="ajax-cart" id="cart-table"> </div>
                    <?php else: ?>
                        <div class="empy-cart"><h4>Cart Is Empty, Please Go To leads Store By <a href="<?= base_url('agency/checkout/continue_shop'); ?>">Click Here</a> </h4></div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
     </div>
     </div>
</div>

<script type="text/javascript">
    jQuery('#leadstr').addClass('open');
    $('document').ready(function () {
        $.ajax({
            url: '<?= base_url('agency/checkout/ajax_cart') ?>',
            method: 'post',
            success: function (data) {
                $('#cart-table').html(data);
            }
        });
    });
    function remove_list_data(e) {
        e.preventDefault();
        $.post("<?= base_url('agent/checkout/remove_item_list') ?>", $("#cart_list").serialize(), function (data) {
            $.ajax({
                url: '<?= base_url('agent/checkout/ajax_cart') ?>',
                method: 'post',
                success: function (data) {
                    $('#cart-table').html(data);
                }
            });
        });
    }
    function cartCheckout(btn) {
        jsonObj = [];
        var fileName = "";
        var reqType = "";
        reqType = jQuery('#' + btn).attr('data-checkout');
        $('.file_name').each(function () {
            fileName = "";
            fileName = $(this).val();
            if (fileName === "") {
                fileName = "GravityBPX Leads";
            }
            temp = {}
            temp["order_couter"] = $(this).data('couter');
            temp["file_name"] = fileName;
            temp["req_type"] = reqType;
            jsonObj.push(temp);
        });
        jsonString = JSON.stringify(jsonObj);
        $.ajax({
            url: '<?php echo site_url('agent/checkout/filename') ?>',
            method: 'post',
            data: {items: jsonString},
            success: function (data) {
                console.log(data);
                if (data == 'checkout') {
                    window.location.href = "<?= site_url('agent/order/checkout'); ?>";
                } else if (data == 'continue') {
                    window.location.href = "<?= site_url('agent/order/continue_shop'); ?>";
                } else if (data == 'true') {
                    window.location.href = "<?= site_url('agent/order/checkout'); ?>";
                }
            }
        });
    }
</script>

<div class="modal fade" id="ajax" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <img src="<?php echo base_url() ?>assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
                <span> &nbsp;&nbsp;Loading... </span>
            </div>
        </div>
    </div>
</div>