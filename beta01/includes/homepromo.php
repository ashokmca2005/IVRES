<?php
if(isset($bannerInfo) && !empty($bannerInfo)) {
	$banner_id 			= $bannerInfo['banner_id'];
	$banner_src 		= SITE_URL."upload/banners-logos/banners/763x236/".$bannerInfo['banner_name'];
	$banner_caption  	= $bannerInfo['banner_caption'];
	$banner_link   		= $bannerInfo['banner_link'];
	echo '<div class="ad" style="width:763px;"><a href="'.$banner_link.'" style="test-decoration:none;"><img src="'.$banner_src.'" width="763px" height="236px" alt="'.$banner_caption.'" border="0" /></a></div>';
}
?>
