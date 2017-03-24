<div class="pad-top15"><?php echo $page_discription; ?></div>
<?php
$package_credit = $propertyObj->fun_checkOwnerPackageCredit($user_id);
if($package_credit == false) {
?>
<div class="pad-top20"><img src="images/big-img.jpg" usemap="#Map2"/></div>
<map name="Map2" id="Map2">
<area shape="rect" coords="427,90,620,115" href="<?php echo SITE_URL;?>add-a-property" />
<area shape="rect" coords="415,130,658,155" href="<?php echo SITE_URL;?>owner-my-properties" />
<area shape="rect" coords="419,165,547,191" href="<?php echo SITE_URL;?>list-your-property" />
</map>
<?php
} else {
?>
<div class="pad-top20"><img src="images/big-img.jpg" usemap="#Map2"/></div>
<map name="Map2" id="Map2">
<area shape="rect" coords="427,90,620,115" href="<?php echo SITE_URL;?>add-a-property" />
<area shape="rect" coords="415,130,658,155" href="<?php echo SITE_URL;?>owner-my-properties" />
<area shape="rect" coords="419,165,547,191" href="<?php echo SITE_URL;?>list-your-property" />
</map>
<?php
}
?>
<br />
<br />
<h5>Create a FREE Late Deal offer & increase your booking inquiries</h5>
<br />
<img src="<?php echo SITE_IMAGES;?>late-img.jpg" />
<br />
<br />
<br />
<br />
<?php
/*
$bannerLeft = $bannerObj->fun_get_newBannerRandom(4);
if(isset($bannerLeft) && !empty($bannerLeft)) {
	$banner_id 			= $bannerLeft['banner_id'];
	$banner_src 		= SITE_URL."upload/banners-logos/banners/".$bannerLeft['banner_name'];
	$banner_caption  	= $bannerLeft['banner_caption'];
	$banner_link   		= $bannerLeft['banner_link'];
	echo '<p align="center"><a href="'.$banner_link.'"><img src="'.$banner_src.'" width="360px" height="250px" alt="'.$banner_caption.'" border="0" /></a></p>';
}
*/
?>
