<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title" style="padding-bottom: 30px;">Verification</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="scripts_box">
                    <table id="datatable" class="table">
                        <tbody>     
                        <?php foreach ($scripts_arr as $key => $arr): ?>                       
                            <tr class="trscripts" id="script-<?php echo ($key+1) ?>" <?php echo $key > 0 ? 'style="display: none;"':'' ?>>
                                <td>
                                <div class="main_script">
                                <?php
                                    $phrase = $arr['script_html'];
                                    $customer_name = array("#productname#","#customername#", '#address#');
                                    $value_name = array($arr['product_name'],'<span class="text-pink">'.$arr['customer_name'].'</span>', '<span class="text-pink">'.$arr['customer_address'].','.$arr['customer_city'].', '.$arr['customer_state'].','.$arr['customer_zipcode'].'</span>');
                                    $arr['script_html'] = str_replace($customer_name, $value_name, $phrase);
                                ?>
                                <?php echo $arr['script_html']; ?>
                                <input type="hidden" name="complete-<?php echo ($key+1) ?>" />
                                </div>
                                </td>
                        </tr>
                    <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div style="display: none;" class="dataTables_info" id="datatable_info" role="status" aria-live="polite">Showing 1 to 4 of 4 entries</div>
            </div>
            <div class="col-sm-6">
                <div class="dataTables_paginate paging_full_numbers" id="datatable_paginate">
                    <ul class="pagination">
                        <!-- <li class="paginate_button first disabled" aria-controls="datatable" tabindex="0" id="datatable_first">
                            <a href="#">First</a>
                        </li> -->
                        <li class="paginate_button previous" aria-controls="datatable" tabindex="0" id="datatable_previous">
                            <a href="javascript:prevPage()" id="btn_prev">Previous</a>
                        </li>
                        <?php for($i=1; $i <= count($scripts_arr); $i++): ?>
                        <li class="script-<?php echo ($i) ?> paginate_button <?php echo $i == 1 ? 'active':'' ?>" aria-controls="datatable" tabindex="0">
                            <a href="javascript:changePage('<?php echo $i; ?>')"><?php echo $i ?></a>
                        </li>                            
                        <?php endfor; ?>
                        <li class="paginate_button next" aria-controls="datatable" tabindex="0" id="datatable_next">
                            <a href="javascript:nextPage()" id="btn_next">Next</a>
                        </li>
<!--                         <li class="paginate_button last disabled" aria-controls="datatable" tabindex="0" id="datatable_last">
                            <a href="#">Last</a>
                        </li> -->
                    </ul>
                </div>
            </div>
        </div>        
        <div class="row">
            <div class="col-md-6">
                <a href="<?php echo $backurl ?>" class="btn btn-info"><?php echo 'Back' ?></a>
                <a href="javascript:complte();" class="btn btn-success"><?php echo 'Complete' ?></a>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
var current_page = 1;
var records_per_page = 1; 

function complte(){
    jQuery('[name="complete-'+current_page+'"]').val(true);   
    nextPage();    
    if(jQuery('[name="complete-'+numPages()+'"]').val() == 'true'){
        window.location.href = '<?php echo $completeurl ?>';
    }
}   

function prevPage()
{
    if (current_page > 1) {
        current_page--;
        changePage(current_page);
    }
}

function nextPage()
{
    if (current_page < numPages()) {
        current_page++;
        changePage(current_page);
    }
}
function changePage(page)
{
    current_page = page;
    var btn_next = document.getElementById("btn_next");
    var btn_prev = document.getElementById("btn_prev");
    var listing_table = document.getElementById("listingTable");
    var page_span = document.getElementById("page");
 
    // Validate page
    if (page < 1) page = 1;
    if (page > numPages()) page = numPages();
    jQuery('.trscripts').hide();
    jQuery('#script-'+page).show();
    if (page == 1) {
        //btn_prev.style.visibility = "hidden";
        jQuery('#btn_prev').parent('li').addClass('disabled');
    } else {
        //btn_prev.style.visibility = "visible";
        jQuery('#btn_prev').parent('li').removeClass('disabled');
    }

    if (page == numPages()) {
        //btn_next.style.visibility = "hidden";
        jQuery('#btn_next').parent('li').addClass('disabled');        
    } else {
        //btn_next.style.visibility = "visible";
        jQuery('#btn_next').parent('li').removeClass('disabled');
    }
    jQuery('.paginate_button').removeClass('active');
    jQuery('.script-'+page).addClass('active');
}
function numPages()
{
    return parseInt('<?php echo is_array($scripts_arr) ? count($scripts_arr) : 0 ?>');
}
jQuery(function(){
     changePage(1);
});
</script>
<style type="text/css">
    .scripts_box{background: #fefefe;}
</style>