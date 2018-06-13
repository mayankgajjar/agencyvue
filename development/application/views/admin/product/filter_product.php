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