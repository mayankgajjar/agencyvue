<div id="feedbox" class="m-t-20 nicescroll mx-box" style="overflow: hidden;" tabindex="5000">
    <div class="tab-content">
        <div class="tab-pane active" id="feeds">
            <ul class="list-unstyled">
                <?php foreach ($feeds as $feed) { ?>
                    <li class="single-feed">
                        <span class="icon-box"> <i class="<?php echo($feed['feed_icon'] != '') ? $feed['feed_icon'] : 'glyphicon glyphicon-bell'; ?>"></i> </span><span class="feed-text" title="<?php echo $feed['feed_title'] ?>"><?php echo $feed['feed_title'] ?></span>
                        <span><?php echo timespan(strtotime($feed['created']), time(), 2) . ' ago'; ?></span>
                        <span class="clearfix"></span>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <div class="tab-pane" id="system">
            <h5>No System Feeds For Now</h5>
        </div>
    </div>
</div>