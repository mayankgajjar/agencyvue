<!--<?php echo "<pre>";print_r($product)?>-->
<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                    <h4 class="custom-modal-title">Product Details</h4>
                    <div class="custom-modal-text">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-5 control-label">Product Name:</label>
                                <div class="col-sm-7">
                                  <p><?php echo $product->product_name?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-5 control-label">Status:</label>
                                <div class="col-sm-7">
                                    <?php if(($product->is_status) == 'Y'):?>
                                        <p>Active</p>
                                    <?php elseif(($product->is_status) == 'W'):?>
                                        <p>Warning</p>
                                    <?php else:?>
                                        <p>Cancelled</p>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-5 control-label">Application Date:</label>
                                <div class="col-sm-7">
                                  <p><?php echo date("Y-m-d", strtotime($product->added_time));?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-5 control-label">Premium:</label>
                                <div class="col-sm-7">
                                  <p><?php echo ($product->product_price != null) ? "$ ".$product->product_price : '$ 12,000'?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-5 control-label">Verification:</label>
                                <h4><a href="#"><?php echo "Uploaded ".date("Y/m/d");?></a>&nbsp;<span class="danger-alert btn btn-primary"><i class="glyphicon glyphicon-eye-open" title="View Log"></i></span></h4>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-5 control-label">Enrollment Fees:</label>
                                <div class="col-sm-7">
                                  <p><?php echo "$ ".$product->enrollment_fee?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-5 control-label">Cancellation Date:</label>
                                <div class="col-sm-7">
                                  <p><?php echo date("Y-m-d");?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-5 control-label">Commision:</label>
                                <div class="col-sm-7">
                                  <p><?php echo "$12,900/one-time"?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-sm-5 control-label">Cancellation Reason:</label>
                                <div class="col-sm-7">
                                  <p>Couldn't afford.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <h4 class="custom-modal-title">Additional Details</h4>
                    <div class="custom-modal-text">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-sm-5 control-label">Vendor:</label>
                                    <div class="col-sm-7">
                                      <p><?php echo $product->vendor_name;?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-sm-5 control-label">Product Category:</label>
                                    <div class="col-sm-7">
                                      <p><?php echo $product->product_type?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-sm-5 control-label">Product Type:</label>
                                    <div class="col-sm-7">
                                      <p><?php echo $product->product_type?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-sm-5 control-label">Coinsurance:</label>
                                    <div class="col-sm-7">
                                      <p>80/20</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-sm-5 control-label">Term Length:</label>
                                    <div class="col-sm-7">
                                      <p><?php echo str_replace("_", " ", $product->product_billing_rule)?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-sm-5 control-label">Coinsurance Limit:</label>
                                    <div class="col-sm-7">
                                      <p>$20,000</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-sm-5 control-label">Out of Packet:</label>
                                    <div class="col-sm-7">
                                      <p>$7000</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h4 class="custom-modal-title">Additional Details</h4>
                    <div class="custom-modal-text">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-sm-5 ">Brochure of Benefits:</label>
                                      <h4><a href="#">Download PDF</a></h4>
                                </div>
                            </div>
                        </div>
                    </div>
