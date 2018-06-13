 <div class="wrapper custom-member-wrapper">
            <div class="container">
                <?php
                    if ($this->session->flashdata('success')) {
                        ?>
                        <div class="content pt0">
                            <div class="alert alert-success">
                                <a class="close" data-dismiss="alert">×</a>
                                <strong><?= $this->session->flashdata('success') ?></strong>
                            </div>
                        </div>
                <?php $this->session->set_flashdata('success', false);
                } else if ($this->session->flashdata('error')) {?>
                        <div class="content pt0">
                            <div class="alert alert-danger">
                                <a class="close" data-dismiss="alert">×</a>
                                <strong><?= $this->session->flashdata('error') ?></strong>
                            </div>
                        </div>
                <?php $this->session->set_flashdata('error', false);
                } else if(validation_errors()){ ?>
                       <div class="content pt0">
                            <div class="alert alert-danger">
                                <a class="close" data-dismiss="alert">×</a>
                                <strong><?= validation_errors() ?></strong>
                            </div>
                        </div>
                <?php } ?>  
                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="page-title">Dashboard</h4>
                        <p class="text-muted page-title-alt">Welcome <?php echo $this->session->userdata['user_info']['display_name']; ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="mproduct-description">
                            <div class="detail">
                                <span>Full Name :</span>
                                <p><?php echo $this->session->userdata['user_info']['display_name']; ?><p>
                            </div>
                            <div class="detail">
                                <span># of Dependents :</span>
                                <p><?php echo $total_dependents; ?><p>
                            </div>
                            <div class="detail">
                                <span>Member Since :</span>
                                <p><?php echo $this->session->userdata['user_info']['created_date']; ?><p>
                            </div>
                            <div class="detail">
                                <span>next billing Date :</span>
                                <p>3/23/2017<p>
                            </div>
                            <div class="detail">
                                <span>Next Billing amount :</span>
                                <p>$ 64.94<p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="social-media">
                            <span>Follow Us On...</span>
                            <ul class="social-link">
                                <li><a href="https://www.facebook.com/amenitybenefits/"><i class="fa fa-facebook-square" aria-hidden="true"></i></a></li>
                                <li><a href="https://twitter.com/amenitybenefits"><i class="fa fa-twitter-square" aria-hidden="true"></i></a></li>
                                <li><a href="https://www.linkedin.com/company-beta/7583593/"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></li>
                            </ul>
                        </div>
                        <div class="social-media-details">
                            <div class="table-responsive">
                                <table  class="table">
                                    <tr>
                                        <th>Socil</th>
                                        <th>Date</th>
                                        <th>Notifications</th>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-facebook-square" aria-hidden="true"></i></td>
                                        <td>18-03-2017</td>
                                        <td><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-facebook-square" aria-hidden="true"></i></td>
                                        <td>18-03-2017</td>
                                        <td><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-facebook-square" aria-hidden="true"></i></td>
                                        <td>18-03-2017</td>
                                        <td><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-facebook-square" aria-hidden="true"></i></td>
                                        <td>18-03-2017</td>
                                        <td><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-facebook-square" aria-hidden="true"></i></td>
                                        <td>18-03-2017</td>
                                        <td><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-facebook-square" aria-hidden="true"></i></td>
                                        <td>18-03-2017</td>
                                        <td><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-facebook-square" aria-hidden="true"></i></td>
                                        <td>18-03-2017</td>
                                        <td><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-facebook-square" aria-hidden="true"></i></td>
                                        <td>18-03-2017</td>
                                        <td><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="product-heading">
                <div class="container">
                    <h2>SELECT A PRODUCT</h2><span>(You can view productdetails by clicking on product logo)</span>
                </div>
            </div>
            <div class="product-all-details">
                <div class="container">
                    <ul>
                        <?php foreach ($product_data as $key => $value) { 
                            $is_disable = '';
                            $remove_disable = 'disabled';
                            if (in_array($value['global_product_id'], $res_sel_column)) {
                                $is_disable = 'disabled';
                                $remove_disable = '';
                            }
                            ?>
                            <li>
                                <div class="details">
                                    <div class="logo-image"><img src="<?php echo base_url() ?>assets/crm_image/products/<?php echo $value['product_image'] ?>" alt="Products"></div>
                                    <div class="descriptions"><span>Product Name</span><p><?php echo $value['product_name']; ?></p></div>
                                    <div class="descriptions"><span>Product ID</span><p><?php echo $value['product_id']; ?></p></div>
                                    <div class="descriptions"><span>Monthly Payment </span><p><?php echo $value['plan_id']; ?></p></div>
                                    <div class="btns">
                                        <button type="button" class="btn btn-success waves-effect waves-light activate" <?php echo $is_disable; ?>><span class="btn-label"><i class="fa fa-plus"></i></span>Activate</button>
                                        <button type="button" class="btn btn-danger waves-effect waves-light cancel" <?php echo $remove_disable; ?>  ><span class="btn-label"><i class="fa fa-times"></i></span> Cancel</button>
                                    </div>
                                </div>

                            </li>
                        <?php } ?>

                        <?php foreach ($selected_product_data as $key => $value) { ?>
                             <li>
                                <div class="details">
                                    <div class="logo-image"><img src="<?php echo base_url() ?>assets/crm_image/products/<?php echo $value['product_image'] ?>" alt="Products"></div>
                                    <div class="descriptions"><span>Product Name</span><p><?php echo $value['product_name']; ?></p></div>
                                    <div class="descriptions"><span>Product ID</span><p><?php echo $value['product_id']; ?></p></div>
                                    <div class="descriptions"><span>Monthly Payment </span><p><?php echo $value['plan_id']; ?></p></div>
                                    <div class="btns">
                                        <button type="button" class="btn btn-danger waves-effect waves-light cancel" <?php echo $remove_disable; ?>  ><span class="btn-label"><i class="fa fa-times"></i></span> Cancel</button>
                                    </div>
                                </div>
                                
                            </li>

                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>