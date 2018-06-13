<div id="custom-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width:55%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="custom-width-modalLabel">Select Verification Script</h4>
            </div>
            <div class="modal-body">
              <?php foreach ($script as $vs) {?>
                <span class="script_status"><input id="select_script" type="checkbox" name="select_script[]" class="product_select_script" value="<?php echo $vs['verification_script_id'] ?>"></span>
                <p><?php echo $vs['script_html']; ?></p>
                <hr>
              <?php } ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary waves-effect waves-light">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
