<div id="from_place">
    <?php if ($method == 'verificationFile'): ?>
        <h4>Verification Script Of <?php echo $product_name; ?></h4>
        <div class="row">
            <div class="col-lg-4 input_wrapper">
                <audio controls>
                    <source src="<?php echo base_url('assets/member_verification_script/') . $file['script'] ?>" type="audio/mpeg">
                </audio>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($method == 'otherFiles'): ?>
        <div class="row">
            <div class="col-lg-4 input_wrapper">
                <label for="filename">File Name </label>
                <input name="old_file_name" value="<?php echo $file['file_name']; ?>" type="hidden">
                <input name="file_id" value="<?php echo $file['id']; ?>" type="hidden">
                <input name="file_extension" value="<?php echo $file['file_extension']; ?>" type="hidden">
                <input class="form-control" id="filename" name="file_name" value="<?php
                $timeFinder = strpos($file['file_name'], '_time_');
                echo substr($file['file_name'], 0, $timeFinder);
                ?>" required>
            </div>
            <div class="col-lg-8 input_wrapper">
                <label for="filedis">File Description </label>
                <input class="form-control" id="filedis" name="file_description" value="<?php echo $file['file_description']; ?>" required>
            </div>
        </div>
        <div class="row">
            <div class="file-action m-t-20">
                <?php if ($file['file_extension'] == 'mp3'): ?>
                    <div class="col-lg-6 input_wrapper">
                        <audio controls>
                            <source src="<?php echo base_url('assets/member_files/') . $file['file_name'] ?>" type="audio/mpeg">
                        </audio>
                    </div>
                <?php elseif ($file['file_extension'] == 'pdf'): ?>
                    <div class="col-lg-6">
                        <a class="btn btn-purple" href="<?php echo base_url('assets/member_files/') . $file['file_name'] ?>" target="blank">Visit File</a>
                    </div>
                <?php elseif ($file['file_extension'] == 'doc' || $file['file_extension'] == 'docx'): ?>
                    <div class="col-lg-6">
                        <a class="btn btn-purple" href="<?php echo base_url('assets/member_files/') . $file['file_name'] ?>" download>Download File</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>