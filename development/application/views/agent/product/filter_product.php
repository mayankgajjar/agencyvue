<?php foreach ($product_array as $product): ?>
    <div class='col-md-12 col-sm-12 col-xs-12 card-box product-box sc-product-item' data-ptype="<?= $product['product_type'] ?>">
        <ul class='product_box_content'>
            <li class='first-li'>
                <div class='site-logo'><img src="<?= site_url() ?>assets/crm_image/products/<?= $product['product_image'] ?>" /></div>
                <span class='btn btn-success waves-effect waves-light product-details' data-toggle="modal" data-target="#full-width-modal" data-custom-value="<?= $product['global_product_id'] ?>">Details</span>
            </li>
            <li class='second-li'>
                 <div class='product_name'><label>Product Name:</label><span  data-name="product_name" > <?= $product['product_name'] ?></span></div>
                <div class='product-type'><label>Product Type:</label><span> <?= $product['product_type'] ?></span></div>
                <div class='Benefits-type'><label>Benefits Type:</label><span><?= $product['product_benefits_type'] ?></span></div>
                <div class='average-savings'><label>Average Savings:</label><span><?= $product['product_average_savings'] ?> </span></div>
                <div class='network-size'><label>Network Size:</label><span><?= $product['product_network_size'] ?> </span></div>
                <div class='network-size'><label>Product Price:</label><span><?= $product['product_price'] ?> </span></div>
            </li>
            <li class='third-li'>
                <div class='product_prize_total'><p><?= '$ '.$product['product_price'] ?></p></div>
                <input type="hidden" class="product_price" name="product_price" value="<?= $product['product_price']; ?>">
                <input type="hidden" class="product_id"  name="product_id" value="<?= $product['global_product_id']; ?>">
                <div class='product_prize_total_btns'>
                    <span class='btn btn-success waves-effect waves-light btn-label sc-add-to-cart add-product' data-product-id = "<?= $product['global_product_id'] ?>" data-product-price="<?= $product['product_price'] ?>"><i class='fa fa-check'></i>Add</span>
                    <span class='btn btn-danger waves-effect waves-light btn-label remove-product'><i class='fa fa-times'></i>Remove</span>
                </div>
            </li>
        </ul>
    </div>
<?php endforeach; ?>
<!--<?php 
    $temp = array();
    $filtered_products = array();
    foreach($cost as $key => $value) {
        $temp[] = $value;
    }
    $str = '';
    $var = 0;
    for ($i = 0; $i < count($temp); $i++) {
        $explode_array = explode("_", $temp[$i]);
        if (count($explode_array) == 1)
        {
            if ($temp[$i] == 100)
            {
                $str = $str . "( var < ".  floatval($explode_array[0]) . ')';
            }
            else
            {
                $str = $str . "( var > ".  floatval($explode_array[0]) . ')';
            }
        }
        else
        {
            $str = $str . " ( var > ".  floatval(explode('_', $temp[$i])[0]) . " AND var < " . floatval(explode('_', $temp[$i])[1]) . ")";
            
        }
        if ($i == count($temp) - 1)
        {
            $str = $str . " ";
        }
        else
        {
            $str = $str . " OR";

        }
    }
?>-->
 <?php foreach ($api_products as $apiProdoct): ?>
    <?php
        $key_exist = array_key_exists('Name', $apiProdoct); 
        if ($key_exist == 1)
        {
            $apiProdoct['product_name'] = $apiProdoct->Name;
            $apiProdoct['product_price'] = $apiProdoct->Premium;
            $producttype = explode("~~", $apiProdoct['product_name']);
            $apiProdoct['product_type'] = 'No Data';
            $apiProdoct['product_benefits_type'] = 'No Data';
            $apiProdoct['product_average_savings'] = 'No Data';
            $apiProdoct['product_network_size'] = 'No Data';
            $apiProdoct['enrollment_fee'] = $apiProdoct->EnrollmentFee;
            $apiProdoct['product_id'] = rand(1,4); //generate random product
        }
        //$var = $apiProdoct['product_price'];
        $match_string =  str_replace("var", floatval($apiProdoct['product_price']), $str);
    ?>
    <?php 
    if (isset($cost)) 
    {
        foreach ($cost as $key => $value) 
        {
            $array = explode('_', $value);
            if (count($array) > 1)
            {
                if ($apiProdoct['product_price'] > $array[0] && $apiProdoct['product_price'] < $array[1])
                {
    ?>
                  <div class='col-md-12 col-sm-12 col-xs-12 card-box product-box sc-product-item' >
                        <ul class='product_box_content'>
                            <li class='first-li'>
                                <div class='site-logo'><img src="<?= site_url() ?>assets/crm_image/products/<?= $apiProdoct['product_image'] ?>" /></div>
                                <span class='btn btn-success waves-effect waves-light product-details' data-toggle="modal" data-target="#full-width-modal" data-custom-value="<?= $apiProdoct['global_product_id'] ?>">Details</span>
                            </li>
                            <li class='second-li'>
                                <div class='product-type'><label>Product Name:</label><span  data-name="product_name" > <?= $apiProdoct['product_name'] ?></span></div>
                                <div class='product-type'><label>Product Type:</label><span> <?php echo $apiProdoct['product_type'] != '' ? $apiProdoct['product_type'] : 'No Data' ?></span></div>
                                <div class='Benefits-type'><label>Benefits Type:</label><span><?= $apiProdoct['product_benefits_type'] != '' ? str_replace("_", " ", $apiProdoct['product_benefits_type']) : 'No Data'?></span></div>
                                <div class='average-savings'><label>Average Savings:</label><span><?=  $apiProdoct['product_average_savings'] != '' ? $apiProdoct['product_average_savings'] : 'No Data'?> </span></div>
                                <div class='network-size'><label>Network Size:</label><span><?=  $apiProdoct['product_network_size'] != '' ? $apiProdoct['product_network_size'] : 'No Data'?> </span></div>
                                <div class='network-size'><label>Product Price:</label><span><?= $apiProdoct['product_price'] ?> </span></div>
                            </li>
                            <li class='third-li'>
                                <div class='product_prize_total'><p><?= '$ ' . $apiProdoct['product_price'] ?></p></div>
                                <input type="hidden" class="product_enrollment" name="product_enrollment" value="<?= $apiProdoct['enrollment_fee'] ?>">
                                <input type="hidden" class="product_price" name="product_price" value="<?= $apiProdoct['product_price']; ?>">
                                <input type="hidden" class="product_id"  name="product_id" value="<?= $apiProdoct['global_product_id']; ?>">
                                <div class='product_prize_total_btns'>
                                    <button class='btn btn-success waves-effect waves-light btn-label sc-add-to-cart add-product'><i class='fa fa-check'></i>Add</button>
                                    <button class='btn btn-danger waves-effect waves-light btn-label sc-cart-remove remove-product' value="abc"><i class='fa fa-times'></i>Remove</button>
                                </div>
                            </li>
                        </ul>
                    </div>
        <?php
                }
            }
            else if ($array[0] == '100')
            {
                 if ($apiProdoct['product_price'] < $array[0])
                {
        ?>
                  <div class='col-md-12 col-sm-12 col-xs-12 card-box product-box sc-product-item' >
                        <ul class='product_box_content'>
                            <li class='first-li'>
                                <div class='site-logo'><img src="<?= site_url() ?>assets/crm_image/products/<?= $apiProdoct['product_image'] ?>" /></div>
                                <span class='btn btn-success waves-effect waves-light product-details' data-toggle="modal" data-target="#full-width-modal" data-custom-value="<?= $apiProdoct['global_product_id'] ?>">Details</span>
                            </li>
                            <li class='second-li'>
                                <div class='product-type'><label>Product Name:</label><span  data-name="product_name" > <?= $apiProdoct['product_name'] ?></span></div>
                                <div class='product-type'><label>Product Type:</label><span> <?php echo $apiProdoct['product_type'] != '' ? $apiProdoct['product_type'] : 'No Data' ?></span></div>
                                <div class='Benefits-type'><label>Benefits Type:</label><span><?= $apiProdoct['product_benefits_type'] != '' ? str_replace("_", " ", $apiProdoct['product_benefits_type']) : 'No Data'?></span></div>
                                <div class='average-savings'><label>Average Savings:</label><span><?=  $apiProdoct['product_average_savings'] != '' ? $apiProdoct['product_average_savings'] : 'No Data'?> </span></div>
                                <div class='network-size'><label>Network Size:</label><span><?=  $apiProdoct['product_network_size'] != '' ? $apiProdoct['product_network_size'] : 'No Data'?> </span></div>
                                <div class='network-size'><label>Product Price:</label><span><?= $apiProdoct['product_price'] ?> </span></div>
                            </li>
                            <li class='third-li'>
                                <div class='product_prize_total'><p><?= '$ ' . $apiProdoct['product_price'] ?></p></div>
                                <input type="hidden" class="product_enrollment" name="product_enrollment" value="<?= $apiProdoct['enrollment_fee'] ?>">
                                <input type="hidden" class="product_price" name="product_price" value="<?= $apiProdoct['product_price']; ?>">
                                <input type="hidden" class="product_id"  name="product_id" value="<?= $apiProdoct['global_product_id']; ?>">
                                <div class='product_prize_total_btns'>
                                    <button class='btn btn-success waves-effect waves-light btn-label sc-add-to-cart add-product'><i class='fa fa-check'></i>Add</button>
                                    <button class='btn btn-danger waves-effect waves-light btn-label sc-cart-remove remove-product' value="abc"><i class='fa fa-times'></i>Remove</button>
                                </div>
                            </li>
                        </ul>
                    </div>
        <?php
                }
            }
            else if ($array[0] == '1000')
            {
                 if ($apiProdoct['product_price'] > $array[0])
                {
        ?>
                  <div class='col-md-12 col-sm-12 col-xs-12 card-box product-box sc-product-item' >
                        <ul class='product_box_content'>
                            <li class='first-li'>
                                <div class='site-logo'><img src="<?= site_url() ?>assets/crm_image/products/<?= $apiProdoct['product_image'] ?>" /></div>
                                <span class='btn btn-success waves-effect waves-light product-details' data-toggle="modal" data-target="#full-width-modal" data-custom-value="<?= $apiProdoct['global_product_id'] ?>">Details</span>
                            </li>
                            <li class='second-li'>
                                <div class='product-type'><label>Product Name:</label><span data-name="product_name" > <?= $apiProdoct['product_name'] ?></span></div>
                                <div class='product-type'><label>Product Type:</label><span> <?php echo $apiProdoct['product_type'] != '' ? $apiProdoct['product_type'] : 'No Data' ?></span></div>
                                <div class='Benefits-type'><label>Benefits Type:</label><span><?= $apiProdoct['product_benefits_type'] != '' ? str_replace("_", " ", $apiProdoct['product_benefits_type']) : 'No Data'?></span></div>
                                <div class='average-savings'><label>Average Savings:</label><span><?=  $apiProdoct['product_average_savings'] != '' ? $apiProdoct['product_average_savings'] : 'No Data'?> </span></div>
                                <div class='network-size'><label>Network Size:</label><span><?=  $apiProdoct['product_network_size'] != '' ? $apiProdoct['product_network_size'] : 'No Data'?> </span></div>
                                <div class='network-size'><label>Product Price:</label><span><?= $apiProdoct['product_price'] ?> </span></div>
                            </li>
                            <li class='third-li'>
                                <div class='product_prize_total'><p><?= '$ ' . $apiProdoct['product_price'] ?></p></div>
                                <input type="hidden" class="product_enrollment" name="product_enrollment" value="<?= $apiProdoct['enrollment_fee'] ?>">
                                <input type="hidden" class="product_price" name="product_price" value="<?= $apiProdoct['product_price']; ?>">
                                <input type="hidden" class="product_id"  name="product_id" value="<?= $apiProdoct['global_product_id']; ?>">
                                <div class='product_prize_total_btns'>
                                    <button class='btn btn-success waves-effect waves-light btn-label sc-add-to-cart add-product'><i class='fa fa-check'></i>Add</button>
                                    <button class='btn btn-danger waves-effect waves-light btn-label sc-cart-remove remove-product' value="abc"><i class='fa fa-times'></i>Remove</button>
                                </div>
                            </li>
                        </ul>
                    </div>
        <?php
                }
            }
        }
    }
    else
    {
?>
        <div class='col-md-12 col-sm-12 col-xs-12 card-box product-box sc-product-item' >
                    <ul class='product_box_content'>
                        <li class='first-li'>
                            <div class='site-logo'><img src="<?= site_url() ?>assets/crm_image/products/<?= $apiProdoct['product_image'] ?>" /></div>
                            <span class='btn btn-success waves-effect waves-light product-details' data-toggle="modal" data-target="#full-width-modal" data-custom-value="<?= $apiProdoct['global_product_id'] ?>">Details</span>
                        </li>
                        <li class='second-li'>
                            <div class='product-type'><label>Product Name:</label><span  data-name="product_name" > <?= $apiProdoct['product_name'] ?></span></div>
                            <div class='product-type'><label>Product Type:</label><span> <?php echo $apiProdoct['product_type'] != '' ? $apiProdoct['product_type'] : 'No Data' ?></span></div>
                            <div class='Benefits-type'><label>Benefits Type:</label><span><?= $apiProdoct['product_benefits_type'] != '' ? str_replace("_", " ", $apiProdoct['product_benefits_type']) : 'No Data'?></span></div>
                            <div class='average-savings'><label>Average Savings:</label><span><?=  $apiProdoct['product_average_savings'] != '' ? $apiProdoct['product_average_savings'] : 'No Data'?> </span></div>
                            <div class='network-size'><label>Network Size:</label><span><?=  $apiProdoct['product_network_size'] != '' ? $apiProdoct['product_network_size'] : 'No Data'?> </span></div>
                            <div class='network-size'><label>Product Price:</label><span><?= $apiProdoct['product_price'] ?> </span></div>
                        </li>
                        <li class='third-li'>
                            <div class='product_prize_total'><p><?= '$ ' . $apiProdoct['product_price'] ?></p></div>
                            <input type="hidden" class="product_enrollment" name="product_enrollment" value="<?= $apiProdoct['enrollment_fee'] ?>">
                            <input type="hidden" class="product_price" name="product_price" value="<?= $apiProdoct['product_price']; ?>">
                            <input type="hidden" class="product_id"  name="product_id" value="<?= $apiProdoct['global_product_id']; ?>">
                            <div class='product_prize_total_btns'>
                                <button class='btn btn-success waves-effect waves-light btn-label sc-add-to-cart add-product'><i class='fa fa-check'></i>Add</button>
                                <button class='btn btn-danger waves-effect waves-light btn-label sc-cart-remove remove-product' value="abc"><i class='fa fa-times'></i>Remove</button>
                            </div>
                        </li>
                    </ul>
                </div>
<?php
    }
?>
<?php endforeach; ?>
