<style type="text/css">
.select-product-model .modal-content{background: #2b333b;padding: 20px;}
.select-product-model .modal-header{border: none;padding-bottom: 0px;}
.select-product-model .modal-header .close{ color: #fff !important;opacity: 1;margin-right: 30px;}
.select-product-model .modal-header h4{color: #fff;font-size: 18px;font-weight: 400;padding-left:30px;}
.select-product-model .modal-body{background: #323b44;padding: 20px;margin: 0px 30px;border: 2px solid rgba(255, 255, 255, 0.07);}
.select-product-model .modal-footer{padding-top: 20px;border: none !important}
.select-product-model .modal-footer button{margin-right:30px;}
.select-product-model .modal-body .pro_info label {width: 35%;text-align: right;color: #fff;font-size: 13px;font-weight: bold;margin-right: 15px;}
.select-product-model .modal-body .pro_info span{width: 50%;text-align: left;display: inline-block;font-weight: bold;font-size: 13px;}
.select-product-model .modal .modal-dialog .modal-content .modal-body {padding: 30px;}
.select-product-model .modal-dialog {margin: 50px auto;}
.select-product-model .site-image{min-height: 132px;}
.select-product-model .modal-body .row{border-bottom:2px solid rgba(255, 255, 255, 0.07);padding: 15px 0px;margin: 0 30px;}
.select-product-model .modal-body .row:last-child{border-bottom:none;}
.select-product-model .modal-body button.btn.btn-danger {width: 100px;}
.select-product-model .modal-body button.btn.btn-danger span.btn-label {margin-right: 2px;}
</style>
<?php //echo '<pre>'; print_r($select_product); die; ?>
<div class="modal-dialog modal-full select-product-model">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="full-width-modalLabel">Please Select Product</h4>
                </div>
                  <div class="modal-body">
                    
                        <input type="hidden" name="customerid" value=<?php echo $userid; ?>>
                        <?php if( !empty($product_array) ) {   ?>
                         <?php foreach($product_array as $key=>$product):  ?>   
                           <?php if(($key) % 4 == 0 || $key==0) {?>
                            <div class="row">
                           <?php } ?>
                                <div class ="col-md-3 col-sm-6 col-xs-12 text-center">
                                    <div class="site-image"><img src="<?php echo site_url().'/assets/crm_image/products/'.$product['product_image']; ?>"></div>
                                    <div class="pro_info"> <label>Product Name: </label> <span><?php echo  $product['product_name']; ?></span></div>
                                    <div class="pro_info"> <label>Product Price: </label><span><?php echo  $product['product_price']; ?></span></div>
                                    <div class="pro_info"> <label>Product Coverage: </label> <span><?php echo  $product['product_coverage']; ?></span></div>
                                    <div class="pro_info"> <label>Plan ID: </label> <span><?php echo  $product['plan_id']; ?></span></div>
                                    <div class="button-list pro_info">
                                        <button type="button" class="btn btn-success waves-effect waves-light product-add pro-add-<?=$key?>" data-id="<?=$key?>" data-custom-value-productid="<?php echo  $product['global_product_id']; ?>" data-custom-value-memberid="<?php echo $userid; ?>">
                                            <span class="btn-label"><i class="fa fa-plus"></i>
                                            </span>Add</button>
                                        <button type="button" class="btn btn-danger waves-effect waves-light product-remove pro-remove-<?=$key?>" data-id="<?=$key?>" data-custom-value-productid="<?php echo  $product['global_product_id']; ?>" data-custom-value-memberid="<?php echo $userid; ?>" disabled>
                                            <span class="btn-label"><i class="fa fa-times"></i>
                                            </span>Remove</button>
                                    </div>
                              </div>
                            <?php if(($key+1) % 4 == 0 || count($product_array) == $key+1) {?>
                            </div>
                           <?php } ?>                   
                        <?php endforeach;  } ?>
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light save-changes">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->

