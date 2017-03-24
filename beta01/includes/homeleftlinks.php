<div class="left_navigation" >
        <div class="box">
        <div class="box-t">
           <div class="box-r">
                <div class="box-b">
                    <div class="box-l">
                        <div class="box-tr">
                            <div class="box-br">
                                <div class="box-bl">
                                    <div class="box-tl" style="padding-right:10px;">
                                        <h3>Find a Property</h3>
                                        <ul>
                                            <li><a href="<?php echo SITE_URL; ?>vacation-rentals" style="text-decoration:none;">Advanced Search </a></li>
                                            <li><a href="<?php echo SITE_URL; ?>map.vacation-rentals" style="text-decoration:none;">Google Map Search</a></li>
    <?php /*?>
                                        <li><a href="<?php echo SITE_URL; ?>accommodation" style="text-decoration:none;">Standard Search</a></li>
<?php */?>
                                            <li><a href="<?php echo SITE_URL; ?>vacation-rentals/featured/" style="text-decoration:none;">Featured Properties</a></li>
    
<?php /*?>
                                        <li><a href="<?php echo SITE_URL; ?>accommodation" style="text-decoration:none;">Property Reference</a></li>
<?php */?>                                    
                                        </ul>
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
    
     <div class="clear"></div>
    <div class="box">
        <div class="box-t">
            <div class="box-r">
                <div class="box-b">
                    <div class="box-l">
                        <div class="box-tr">
                            <div class="box-br">
                                <div class="box-bl">
                                    <div class="box-tl" style="padding-right:10px;">
                                        <h3>Holiday Information</h3>
                                        <ul>
                                            <li><a href="<?php echo SITE_URL; ?>owner-faqs" style="text-decoration:none;">FAQs</a></li>
                                            <li><a href="<?php echo SITE_URL; ?>travel-guides" style="text-decoration:none;">Holiday Ideas</a></li>
                                            <li><a href="<?php echo SITE_URL; ?>events" style="text-decoration:none;">What is on</a></li>
                                            <li><a href="<?php echo SITE_URL; ?>holiday-planning" style="text-decoration:none;">Planning Your Holiday</a></li>
                                            <li><a href="<?php echo SITE_URL; ?>checklist" style="text-decoration:none;">Checklist</a></li>
                                            <li><a href="<?php echo SITE_URL; ?>home-mod" style="text-decoration:none;">Useful home-mod</a></li>
                                            <li><a href="<?php echo SITE_URL; ?>weather" style="text-decoration:none;">Weather</a></li>
                                            <li><a href="<?php echo SITE_URL; ?>a-to-z-countries" style="text-decoration:none;">A to Z Countries</a></li>
                                        </ul>
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
<div class="clear"></div>
    <div class="box">
        <div class="box-t">
            <div class="box-r">
                <div class="box-b">
                    <div class="box-l">
                        <div class="box-tr">
                            <div class="box-br">
                                <div class="box-bl">
                                    <div class="box-tl" style="padding-right:10px;">
                                        <h3>Owners and Agents</h3>
                                        <ul>
                                            <li><a href="<?php echo SITE_URL; ?>owner-login" style="text-decoration:none;">Register | Logins</a></li>
                                            <li><a href="<?php echo SITE_URL; ?>advertise" style="text-decoration:none;">How to Advertise</a></li>
                                            <li><a href="<?php echo SITE_URL; ?>lettingadvice" style="text-decoration:none;">Letting Advice</a></li>
                                            <li><a href="<?php echo SITE_URL; ?>testimonials" style="text-decoration:none;">Testimonials</a></li>
                                            <li><a href="<?php echo SITE_URL; ?>resources" style="text-decoration:none;">Users Link</a></li>
                                            <li><a href="<?php echo SITE_URL; ?>contact-us" style="text-decoration:none;">Contact Us</a></li>
                                        </ul>
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
</div>
<?php
if(isset($bannerLeft) && !empty($bannerLeft)) {
	$banner_id 			= $bannerLeft['banner_id'];
	$banner_src 		= SITE_URL."upload/banners-logos/banners/200x200/".$bannerLeft['banner_name'];
	$banner_caption  	= $bannerLeft['banner_caption'];
	$banner_link   		= $bannerLeft['banner_link'];
	echo '<div class="pad-top10 pad-btm10" align="center"><a href="'.$banner_link.'" style="test-decoration:none;"><img src="'.$banner_src.'" width="200px" height="200px" alt="'.$banner_caption.'" border="0" /></a></div>';
}
?>
