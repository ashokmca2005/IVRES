<table align="left" border="0" cellspacing="0" cellpadding="0">
    <tr><td class="pad-top15 pad-lft15 pink18arial">Hi <?php echo ucwords($user_full_name);?></td></tr>
	<?php /*?>
    <tr><td class="pad-lft15 pad-btm10 pad-top3">Holidaymaker ID: <?php echo fill_zero_left($user_id, "0", (6-strlen($user_id))); ?></td></tr>
	<?php */?>
    <tr>
        <td class="pad-top3">
            <div class="listing">
            <div class="septab">
            <div class="icon"><img src="<?php echo SITE_IMAGES;?>icon-1.jpg" /></div>
            <div class="icontxt"><a href="<?php echo SITE_URL;?>home">My Homepage</a></div>
            </div><!--septab -->
            
            <div class="septab">
            <div class="icon"><img src="<?php echo SITE_IMAGES;?>icon-2.jpg" /></div>
            <div class="icontxt"><a href="<?php echo SITE_URL;?>holiday-profile-settings">Profile and settings</a></div>
            </div><!--septab -->
            
            <div class="septab">
            <div class="icon"><img src="<?php echo SITE_IMAGES;?>icon-3.jpg" /></div>
            <div class="icontxt"><a href="<?php echo SITE_URL;?>favourities">Favourites <span>(<?php echo $favourite_total;?>)</span></a></div>
            </div><!--septab -->

            <div class="septab">
            <div class="icon"><img src="<?php echo SITE_IMAGES;?>icon-4.jpg" /></div>
            <div class="icontxt"><a href="<?php echo SITE_URL;?>inquiries">My Enquiries <span>(<?php echo $enquiries_total;?>)</span></a></div>
            </div>
			<?php /*?>
            <div class="septab">
            <div class="icon"><img src="<?php echo SITE_IMAGES;?>icon-4.jpg" /></div>
            <div class="icontxt"><a href="<?php echo SITE_URL;?>inquiries">My Inquiries <?php if(isset($enquiries_new) && $enquiries_new > 0) {echo "<span>(".$enquiries_new. " new)</span>";}?></a></div>
            </div>
			<?php */?>

            <div class="septab">
            <div class="icon"><img src="<?php echo SITE_IMAGES;?>icon-5.jpg" /></div>
            <div class="icontxt"><a href="<?php echo SITE_URL;?>holiday-register-as-owner">Add a property</a></div>
            </div>
            </div>
        </td>
    </tr>
   <tr>
        <td align="left" valign="top" class="width240">
			<?php require_once(SITE_INCLUDES_PATH.'holidayhotproperty-left.php'); ?>
        </td>
    </tr>
</table>
