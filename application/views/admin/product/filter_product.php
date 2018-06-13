  <?php foreach ($product_array as $product): ?>
    <div class='col-md-12 col-sm-12 col-xs-12 card-box product-box' data-ptype="<?= $product['product_type'] ?>">
        <ul class='product_box_content'>
            <li class='first-li'>
                <div class='site-logo'><img src="<?= site_url() ?>assets/crm_image/products/<?= $product['product_image'] ?>" /></div>
                <div class='Details-btn'><a href='#'>Details</a></div>
            </li>
            <li class='second-li'>
                <div class='product-type'><label>Product-Type:</label><span> <?= $product['product_type'] ?></span></div>
                <div class='Benefits-type'><label>Benefits-Type:</label><span><?= $product['product_benefits_type'] ?></span></div>
                <div class='average-savings'><label>Average-Savings:</label><span><?= $product['product_average_savings'] ?> </span></div>
                <div class='network-size'><label>Network-Size:</label><span><?= $product['product_network_size'] ?> </span></div>
                <div class='network-size'><label>Product-Price:</label><span><?= $product['product_price'] ?> </span></div>
            </li>
            <li class='third-li'>
                <div class='product_prize_total'><p><?= '$'.$product['product_price'] ?></p></div>
                <div class='product_prize_total_btns'>
                    <a href='#' class='btn btn-success waves-effect waves-light'><span class='btn-label'><i class='fa fa-check'></i></span>Add</a>
                    <a href='#' type='button' class='btn btn-danger waves-effect waves-ligh'><span class='btn-label'><i class='fa fa-times'></i></span>Remove</a>
                </div>
            </li>
        </ul>
    </div>
<?php endforeach; ?>