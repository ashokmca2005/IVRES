<style>
#header-group {
	background: url(<?php echo SITE_IMAGES;?>latedeal-1.png) no-repeat top center;
	width: 62px;
	height: 62px;
	position:relative;
	z-index:2999px;
	margin-top:10px;
	margin-bottom:-70px;
}
#header-group img.inside-image {
	position:absolute;
	margin-left:0px;
	margin-top:0px;
}
</style>
<?php
echo '<div class="listing-wrap">';
echo '<ul>';
for($i =0; $i < count($propListArr); $i++) {
	$property_id 		= $propListArr[$i]['property_id'];
	$property_name 		= $propListArr[$i]['property_name'];
	$property_title 	= $propListArr[$i]['property_title'];
	$description	 	= ucfirst(substr($propListArr[$i]['property_summary'], 0, 210));
	$property_currency_symbol	= $propertyObj->fun_findPropertyCurrencySymbol($property_id);
	$property_currency_id		= $propertyObj->fun_findPropertyCurrencyCode($property_id);

	switch($property_currency_id) {
		case '1':
			$property_currency_code = "USD";
		break;
		case '2':
			$property_currency_code = "GBP";
		break;
		case '3':
			$property_currency_code = "EUR";
		break;
		default:
			$property_currency_code = "EUR";
	}

	$currency_symbol	= ($users_currency_symbol == "")?$property_currency_symbol:$users_currency_symbol;
	$currency_code		= ($users_currency_code == "")?$property_currency_code:$users_currency_code;

	$propLocInfoArr 	= $propertyObj->fun_getPropertyLocInfoArr($property_id);
	$propFavId     		= $propertyObj->fun_checkFavourite($_SESSION['ses_user_id'], $property_id);
	$propLateDealArr 	= $propertyObj->fun_getPropertyTopLateDealArr($property_id);
	if(is_array($propLateDealArr) && count($propLateDealArr) > 0) {
		$strUnixDateFrom 	= strtotime($propLateDealArr['start_on']);
		$strUnixDateTo	 	= strtotime($propLateDealArr['end_on']);
		$strUnixDateCur 	= time ();
		$strNights			= (int)(($strUnixDateTo - $strUnixDateFrom) / (60 * 60 * 24));
		$strPricePerWeek 	= $currency_symbol.(number_format(($propLateDealArr['sale_price']/$currencyRateArr[$property_currency_code])*$currencyRateArr[$users_currency_code]));
		$strOrgPricePerWeek	= $currency_symbol.(number_format(($propLateDealArr['original_price']/$currencyRateArr[$property_currency_code])*$currencyRateArr[$users_currency_code]));
		$strPercentSave 	= round(((((($propLateDealArr['original_price']/$currencyRateArr[$property_currency_code])*$currencyRateArr[$users_currency_code]) - (($propLateDealArr['sale_price']/$currencyRateArr[$property_currency_code])*$currencyRateArr[$users_currency_code])) / (($propLateDealArr['original_price']/$currencyRateArr[$property_currency_code])*$currencyRateArr[$users_currency_code]))*100), 0);
	}
	/*
	$propLoc = "";
	if($propLocInfoArr['area_name'] !=""){
		$propLoc .= "<a href=\"".SITE_URL."vacation-rentals/in.".str_replace("/", "_", str_replace(" ", "-", strtolower($propLocInfoArr['area_name'])))."\" onclick=\"removeSearch();\">".ucwords($propLocInfoArr['area_name'])."</a> > ";
	}
	if($propLocInfoArr['region_name'] !=""){
		$propLoc .= "<a href=\"".SITE_URL."vacation-rentals/in.".str_replace("/", "_", str_replace(" ", "-", strtolower($propLocInfoArr['region_name'])))."\" onclick=\"removeSearch();\">".ucwords($propLocInfoArr['region_name'])."</a> > ";
	}
	if($propLocInfoArr['subregion_name'] !=""){
		$propLoc .= "<a href=\"".SITE_URL."vacation-rentals/in.".str_replace("/", "_", str_replace(" ", "-", strtolower($propLocInfoArr['subregion_name'])))."\" onclick=\"removeSearch();\">".ucwords($propLocInfoArr['subregion_name'])."</a> > ";
	}
	if($propLocInfoArr['location_name'] !=""){
		$propLoc .= "<a href=\"".SITE_URL."vacation-rentals/in.".str_replace("/", "_", str_replace(" ", "-", strtolower($propLocInfoArr['location_name'])))."\" onclick=\"removeSearch();\">".ucwords($propLocInfoArr['location_name'])."</a> > ";
	}
	
	$propLoc .= ucfirst($property_name)." ref:".fill_zero_left($property_id, "0", (6-strlen($property_id)));
	*/
	$propThumbInfoArr = $propertyObj->fun_getPropertyMainThumb($property_id);
	if(count($propThumbInfoArr) > 0){
		if($propThumbInfoArr[0]['photo_url'] != "") {
			//$photo_thumb 	= PROPERTY_IMAGES_LARGE244x183_PATH.$propThumbInfoArr[0]['photo_url'];
			$pos 		= strpos($propThumbInfoArr[0]['photo_url'], "rentalo.com");
			if($pos === false) {
				$photo_thumb = PROPERTY_IMAGES_LARGE244x183_PATH.$propThumbInfoArr[0]['photo_url'];
			} else {
				$photo_thumb = $propThumbInfoArr[0]['photo_url'];
			}
		} else {
			$photo_thumb 	= PROPERTY_IMAGES_LARGE244x183_PATH."no-image-small.gif";
		}
		$photo_caption 		= $propThumbInfoArr[0]['photo_caption'];
	} else {
		$photo_thumb 	= PROPERTY_IMAGES_LARGE244x183_PATH."no-image-small.gif";
		$photo_caption 		= "No Image";
	}
	$propBedInfoArr 		= $propertyObj->fun_getPropertyBedAllInfoArr($property_id);
	if(is_array($propBedInfoArr) && (count($propBedInfoArr) > 0)){
		if($propBedInfoArr[0]['total_beds'] > 0) {
			$total_beds 		= ($propBedInfoArr[0]['total_beds'] > 1)?$propBedInfoArr[0]['total_beds']." Bedrooms":$propBedInfoArr[0]['total_beds']." Bedroom";
			$total_beds .=" <br>";
		}
		if($propBedInfoArr[0]['scomfort_beds'] > 0) {
			$scomfort_beds 	= "Sleeps ".$propBedInfoArr[0]['scomfort_beds']."<br>";
		}
	} else {
		$total_beds 	= "";
		$scomfort_beds 	= "";
	}
	$propBathInfoArr 	= $propertyObj->fun_getPropertyBathAllInfoArr($property_id);
	if(is_array($propBathInfoArr) && (count($propBathInfoArr) > 0) && ($propBathInfoArr[0]['total_bathrooms'] > 0)){
		$total_bathrooms 		= ($propBathInfoArr[0]['total_bathrooms'] > 1)?$propBathInfoArr[0]['total_bathrooms']." Bathrooms":$propBathInfoArr[0]['total_bathrooms']." Bathroom";
		$total_bathrooms .=" <br>";
	} else {
		$total_bathrooms= "";
	}
	$propPoolInfo	 	= $propertyObj->fun_verifyPropertyByPropertyFacility($property_id, "15");
	if($propPoolInfo) {
		$show_swimming= "<span>Swimming pool</span><br>";
	} else {
		$show_swimming 	= "<br>";
	}
	
	$propPriceInfoArr	= $propertyObj->fun_getPropertyPriceFromInfoArr($property_id);
	if(is_array($propPriceInfoArr) && (count($propPriceInfoArr) > 0)){
		$priceHiddenHTML = "";
		if($propPriceInfoArr['min_per_week_price'] > 0) {
			$min_per_week_price 		= number_format(($propPriceInfoArr['min_per_week_price']/$currencyRateArr[$property_currency_code])*$currencyRateArr[$currency_code]);
			$show_price 				= "<span id=\"price_currency_symbol_id1".$i."\" class=\"price-2\">".$currency_symbol."</span><span id=\"price_currency_price_id1".$i."\" class=\"price-2\">".$min_per_week_price."</span><br />";
			$priceHiddenHTML .= "<input name=\"price_rate_usd_1".$i."\"  id=\"price_rate_usd_id1".$i."\" type=\"hidden\" value=\"".(($propPriceInfoArr['min_per_week_price']/$currencyRateArr[$property_currency_code])*$currencyRateArr['USD'])."\" />";
			$priceHiddenHTML .= "<input name=\"price_rate_gbp_1".$i."\"  id=\"price_rate_gbp_id1".$i."\" type=\"hidden\" value=\"".(($propPriceInfoArr['min_per_week_price']/$currencyRateArr[$property_currency_code])*$currencyRateArr['GBP'])."\" />";
			$priceHiddenHTML .= "<input name=\"price_rate_eur_1".$i."\"  id=\"price_rate_eur_id1".$i."\" type=\"hidden\" value=\"".(($propPriceInfoArr['min_per_week_price']/$currencyRateArr[$property_currency_code])*$currencyRateArr['EUR'])."\" />";
		} else {
			$show_price 				= "";
		}
		echo $priceHiddenHTML;
	} else {
		$show_price 		= "";
	}
	//$count_video		= $propertyObj->fun_countPropertyVideosAll($property_id);
	//print_r($propPriceInfoArr);
	$fr_url = $propertyObj->fun_getPropertyFriendlyLink($property_id);
	if(isset($fr_url) && $fr_url != "") {
		$property_link 		= SITE_URL."vacation-rentals/".strtolower($fr_url);
		$contact_owner_link = "<a href=\"".$property_link."#showSectionTop\" class=\"blue-link\">Contact owner</a>";
		$write_review_link  = "<a href=\"".$property_link."#showSectionTop\" class=\"blue-link\">Write Review</a>";
	} else {
		if(isset($propLocInfoArr['location_name']) && $propLocInfoArr['location_name'] != "") {
			$property_link = SITE_URL."vacation-rentals/in.".str_replace(" ", "-", strtolower($propLocInfoArr['location_name']))."/".fill_zero_left($property_id, "0", (6-strlen($property_id)));
		} else {
			$property_link = SITE_URL."vacation-rentals/in.".str_replace(" ", "-", strtolower($propLocInfoArr['region_name']))."/".fill_zero_left($property_id, "0", (6-strlen($property_id)));
		}
		$contact_owner_link = "<a href=\"".$property_link."#showSectionTop\" class=\"blue-link\">Contact owner</a>";
		$write_review_link  = "<a href=\"".$property_link."#showSectionTop\" class=\"blue-link\">Write Review</a>";
	}
	$isFeatured = $propertyObj->fun_isPropertyFeatured($property_id);
	$read_review_link  = "&nbsp;";
	?>
	<?php
	if(is_array($propLateDealArr) && count($propLateDealArr) > 0) {
		$strLateStyle 	= 'style="background-color:#f2f7eb;padding-right:10px;padding-left:10px;"';
		$strLateDeal 	= '<div id="header-group">&nbsp;</div>';
		$strShowPrice 	= '<div class="listing-4">From<br /><font size="+1.5">'.$strPricePerWeek.'</font></div>';
		$strShowPrice 	.= '<div class="listing-3">From<br /><font color="#FF0000" size="+1.5"><strong><del>'.$strOrgPricePerWeek.'</del></strong></font><br><strong>save '.$strPercentSave.'%</strong></div>';
	/*
    ?>
    <div class="titlebg4">
        <div class="innertxt"><span class="black pad-lft15"><?php echo tranText('save'); ?>&nbsp;<?php echo $strPercentSave."%"; ?>&nbsp;-&nbsp;<?php echo tranText('was'); ?>&nbsp;<span class="red"><?php echo $strOrgPricePerWeek; ?></span>&nbsp;<?php echo tranText('now'); ?>&nbsp;<span class="green"><?php echo $strPricePerWeek; ?></span>&nbsp;<?php echo tranText('per_week!'); ?>&nbsp;</span><div class="pad-rgt15" style="text-align:right; display:inline; float:right; height:20px;"><?php echo tranText('dates'); ?>&nbsp;<?php echo date('M d', $strUnixDateFrom); ?> - <?php echo date('M d', $strUnixDateTo); ?></div></div>
    </div>
    <?php
	*/
    } else if($isFeatured == true) {
		$strLateStyle 	= 'style="padding-right:10px;padding-left:10px;"';
		$strLateDeal 	= '';
		if(isset($show_price) && $show_price !="") {
			$strShowPrice 	= '<div class="listing-2">From<br />'.$show_price.'</div>';
		} else {
			$strShowPrice 	= '';
		}
    ?>
    <?php
    } else {
		$strLateStyle 	= 'style="padding-right:10px;padding-left:10px;"';
		$strLateDeal 	= '';
		if(isset($show_price) && $show_price !="") {
			$strShowPrice 	= '<div class="listing-2">From<br />'.$show_price.'</div>';
		} else {
			$strShowPrice 	= '';
		}
    ?>
    <?php
    }
    ?>
	<li <?php echo $strLateStyle; ?>>
        <?php echo $strLateDeal; ?>
        <a href="<?php echo $property_link; ?>" title="<?php echo $property_name.": ".$property_title;?>" style="text-decoration:none;" onclick="saveSearch();"><img src="<?php echo $photo_thumb;?>" alt="<?php echo $photo_caption;?>" title="<?php echo $property_name.": ".$property_title;?>" onerror="this.src='<?php echo SITE_IMAGES;?>no-image-small.gif';" /></a>
        <a href="<?php echo $property_link; ?>" style="text-decoration:none;" onclick="saveSearch();"><br /><h3><?php echo $property_name ?></h3></a>
        <div class="listing-1">
        <a href="<?php echo SITE_URL; ?>vacation-rentals/in.<?php echo str_replace("&", "", str_replace(",", "_", str_replace(" ", "-", strtolower($propLocInfoArr['area_name'])))); ?>" class="location-1" style="text-decoration:none;"><?php echo ucwords($propLocInfoArr['area_name'].', '.$propLocInfoArr['countries_name']); ?></a><br />
        <span class="sleeps-1" style="display:block; width:100%;padding-bottom:0px;"><?php echo $scomfort_beds; ?></span>
  		<a href="<?php echo $property_link; ?>#showSectionReview" style="text-decoration:none;" onclick="saveSearch();"><?php $propertyObj->fun_createPropertyCustomerReview($property_id); ?></a>
        </div>
        <?php echo $strShowPrice; ?>
    </li>
	<?php
}
echo '</ul>';
echo '</div>';
?>