<?php
	$pageInfo = $cmsObj->fun_getPageInfo(40);
	if(isset($pageInfo) && is_array($pageInfo)) {
	?>
    <div class="ad" style="width:763px;">
        <div class="box-t_ad">
            <div class="box-r_ad">
                <div class="box-b_ad">
                    <div class="box-l_ad">
                        <div class="box-tr_ad">
                            <div class="box-br_ad">
                                <div class="box-bl_ad">
                                    <div class="box-tl_ad">
                                        <div class="ad_inner" >
                                            <?php echo stripslashes($pageInfo['page_discription']);?>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
	}
?>


