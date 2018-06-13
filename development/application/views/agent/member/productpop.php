<div id="popup_product" class="popup_product">
    <ul class="list-inline status-list m-t-20">
        <?php if (isset($productArray)): ?>
            <input type="hidden" name="product_id" value="<?php echo $productArray['product_data']['global_product_id']; ?>" >
            <input type="hidden" name="memberproduct" value="<?php echo $memberproduct; ?>">
            <li class="product-list">
                <?php echo $productArray['product_data']['product_name'] . " ||  " . '<button type="button" class="btn btn-warning btn-xs" > Verification Pending </button>'; ?>
                <div class="fileupload btn btn-purple waves-effect waves-light fileupload-new-btn">
                    <span><i class="ion-upload m-r-5" title="Upload Script"></i></span>
                    <input type="file" name="verification_scripts" class="upload required" onchange="Validateverification(this);" required>
                </div>
            </li>
            <div class="error_verification" style="font-style: italic; color: #f6504d; margin-top: 8px; display: none;">Please select only .mp3 file format.</div>
        <?php endif; ?>
    </ul>
</div>