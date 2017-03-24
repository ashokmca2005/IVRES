<?php
for($i =0; $i < count($propListArr); $i++) {
	$property_id 		= $propListArr[$i]['property_id'];
	$property_name 		= $propListArr[$i]['property_name'];
	$property_title 	= $propListArr[$i]['property_title'];
	$description	 	= ucfirst(substr($propListArr[$i]['property_summary'], 0, 150));
	$propLocInfoArr = $propertyObj->fun_getPropertyLocInfoArr($property_id);
	$propFavArr     = $propertyObj->fun_checkFavourite($user_id, $property_id);
	$propLoc = "";
	if($propLocInfoArr['area_name'] !=""){
		$propLoc .= "<a href=\"property-search-results.php?destinations=".str_replace(" ", "^", strtolower($propLocInfoArr['area_name']))."\">".ucwords($propLocInfoArr['area_name'])."</a> > ";
	}
	if($propLocInfoArr['region_name'] !=""){
		$propLoc .= "<a href=\"property-search-results.php?destinations=".str_replace(" ", "^", strtolower($propLocInfoArr['region_name']))."\">".ucwords($propLocInfoArr['region_name'])."</a> > ";
	}
	if($propLocInfoArr['subregion_name'] !=""){
		$propLoc .= "<a href=\"property-search-results.php?destinations=".str_replace(" ", "^", strtolower($propLocInfoArr['subregion_name']))."\">".ucwords($propLocInfoArr['subregion_name'])."</a> > ";
	}
	if($propLocInfoArr['location_name'] !=""){
		$propLoc .= "<a href=\"property-search-results.php?destinations=".str_replace(" ", "^", strtolower($propLocInfoArr['location_name']))."\">".ucwords($propLocInfoArr['location_name'])."</a> > ";
	}
	$propLoc .= ucfirst($property_name)." ref:".fill_zero_left($property_id, "0", (6-strlen($property_id)));

	$propThumbInfoArr = $propertyObj->fun_getPropertyMainThumb($property_id);
	if(count($propThumbInfoArr) > 0){
		if($propThumbInfoArr[0]['photo_thumb'] != "") {
			$photo_thumb 	= PROPERTY_IMAGES_THUMB168x126_PATH.$propThumbInfoArr[0]['photo_thumb'];
		} else {
			$photo_thumb 	= PROPERTY_IMAGES_THUMB_PATH."no-image-small.gif";
		}
		$photo_caption 		= $propThumbInfoArr[0]['photo_caption'];
	} else {
		$photo_thumb 		= PROPERTY_IMAGES_THUMB_PATH."no-image-small.gif";
		$photo_caption 		= "No Image";
	}

	$propBedInfoArr 		= $propertyObj->fun_getPropertyBedAllInfoArr($property_id);
	if(is_array($propBedInfoArr) && (count($propBedInfoArr) > 0)){
		if($propBedInfoArr[0]['total_beds'] > 0) {
			$total_beds 	= $propBedInfoArr[0]['total_beds']." Bedrooms<br>";
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
		$total_bathrooms= $propBathInfoArr[0]['total_bathrooms']." Bathrooms <br>";
	} else {
		$total_bathrooms= "";
	}
	$propPoolInfo	 	= $propertyObj->fun_verifyPropertyByPropertyFacility($property_id, "15");
	if($propPoolInfo) {
		$show_swimming= "<span>Swimming pool</span>";
	} else {
		$show_swimming 	= "";
	}

	$propPriceInfoArr	= $propertyObj->fun_getPropertyPriceFromInfoArr($property_id);
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

	if(is_array($propPriceInfoArr) && (count($propPriceInfoArr) > 0)){
		if($propPriceInfoArr['min_per_night_price'] > 0 && $propPriceInfoArr['max_per_night_price'] > 0 && $propPriceInfoArr['min_per_night_price'] != $propPriceInfoArr['max_per_night_price']) {
			$min_per_night_price 		= number_format($propPriceInfoArr['min_per_night_price']);
			$max_per_night_price 		= number_format($propPriceInfoArr['max_per_night_price']);
			$show_price 				= "<span id=\"price_currency_symbol_id1".$i."\">".$currency_symbol."</span><span id=\"price_currency_price_id1".$i."\" >".$min_per_night_price."</span> - <span id=\"price_currency_symbol_id2".$i."\" >".$currency_symbol."</span><span id=\"price_currency_price_id2".$i."\">".$max_per_night_price." p/d</span><br />";
		} else if($propPriceInfoArr['min_per_week_price'] > 0 && $propPriceInfoArr['max_per_week_price'] > 0 && $propPriceInfoArr['min_per_week_price'] != $propPriceInfoArr['max_per_week_price']) {
			$min_per_week_price 		= number_format($propPriceInfoArr['min_per_week_price']);
			$max_per_week_price 		= number_format($propPriceInfoArr['max_per_week_price']);
			$show_price 				= "<span id=\"price_currency_symbol_id1".$i."\">".$currency_symbol."</span><span id=\"price_currency_price_id1".$i."\" >".$min_per_week_price."</span> - <span id=\"price_currency_symbol_id2".$i."\" >".$currency_symbol."</span><span id=\"price_currency_price_id2".$i."\">".$max_per_week_price." p/w</span><br />";
		} else if($propPriceInfoArr['min_per_night_price'] > 0) {
			$min_per_night_price 		= number_format($propPriceInfoArr['min_per_night_price']);
			$show_price 				= "From <span id=\"price_currency_symbol_id1".$i."\">".$currency_symbol."</span><span id=\"price_currency_price_id1".$i."\" >".$min_per_night_price." per night</span><br />";
		} else if($propPriceInfoArr['min_per_week_price'] > 0) {
			$min_per_week_price 		= number_format($propPriceInfoArr['min_per_week_price']);
			$show_price 				= "From <span id=\"price_currency_symbol_id1".$i."\">".$currency_symbol."</span><span id=\"price_currency_price_id1".$i."\" >".$min_per_week_price." per week</span><br />";
		} else {
			$show_price 				= "<br />";
		}
	} else {
		$show_price 		= "<br />";
	}

/*
	$propPriceInfoArr 	= $propertyObj->fun_getPropertyPriceMinMaxInfoArr($property_id);
	if(is_array($propPriceInfoArr) && (count($propPriceInfoArr) > 0)){
		$currency_code	= $propertyObj->fun_findPropertyCurrencyCode($property_id);
		$min_price 		= number_format($propertyObj->fun_getConvertedCurrency($property_currency_id, $users_currency_id, $propPriceInfoArr['min_price']));
		$max_price 		= number_format($propertyObj->fun_getConvertedCurrency($property_currency_id, $users_currency_id, $propPriceInfoArr['max_price']));
		$show_price 	= "<span id=\"price_currency_symbol_id1".$i."\">".$users_currency_symbol."</span><span id=\"price_currency_price_id1".$i."\" >".$min_price."</span>-<span id=\"price_currency_symbol_id2".$i."\" >".$users_currency_symbol."</span><span id=\"price_currency_price_id2".$i."\">".$max_price."</span> p/w <br>";
	} else {
		$show_price 	= "";
	}
*/
	//$count_video		= $propertyObj->fun_countPropertyVideosAll($property_id);
	//print_r($propPriceInfoArr);
?>
<input name="<?php echo "price_rate_usd_1".$i;?>"  id="<?php echo "price_rate_usd_id1".$i;?>" type="hidden" value="<?php echo (($min_price/$currencyRateArr[$users_currency_code])*$currencyRateArr['USD']); ?>" />
<input name="<?php echo "price_rate_usd_2".$i;?>"  id="<?php echo "price_rate_usd_id2".$i;?>" type="hidden" value="<?php echo (($max_price/$currencyRateArr[$users_currency_code])*$currencyRateArr['USD']); ?>" />

<input name="<?php echo "price_rate_gbp_1".$i;?>"  id="<?php echo "price_rate_gbp_id1".$i;?>" type="hidden" value="<?php echo (($min_price/$currencyRateArr[$users_currency_code])*$currencyRateArr['GBP']); ?>" />
<input name="<?php echo "price_rate_gbp_2".$i;?>"  id="<?php echo "price_rate_gbp_id2".$i;?>" type="hidden" value="<?php echo (($max_price/$currencyRateArr[$users_currency_code])*$currencyRateArr['GBP']); ?>" />

<input name="<?php echo "price_rate_eur_1".$i;?>"  id="<?php echo "price_rate_eur_id1".$i;?>" type="hidden" value="<?php echo (($min_price/$currencyRateArr[$users_currency_code])*$currencyRateArr['EUR']); ?>" />
<input name="<?php echo "price_rate_eur_2".$i;?>"  id="<?php echo "price_rate_eur_id2".$i;?>" type="hidden" value="<?php echo (($max_price/$currencyRateArr[$users_currency_code])*$currencyRateArr['EUR']); ?>" />
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="listingTable">
    <tr>
        <td colspan="2" align="left" valign="top" class="pad-top5"><p class="smallFont11">Location <?php echo $propLoc; ?></p></td>
    </tr>
    <tr><td colspan="2" align="left" valign="top" class=" pad-btm5"></td></tr>
    <tr>
        <td colspan="2" align="left" valign="top" class="pad-top10 pad-btm10">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listingTable">
                <tr>
                    <td width="35%" valign="top"><img src="<?php echo $photo_thumb;?>" alt="<?php echo $photo_caption;?>" width="244" height="183" /></td>
                    <td width="42%" valign="top" class="pad-lft15 pad-rgt10">
                        <div class="pink16arial pad-top7 pad-btm7"><?php echo $property_name;?></div>
                        <p class="font14"><strong><?php echo $property_title;?></strong></p>
                        <p><?php echo $description." ... <a href=\"property.php?pid=".$property_id."\">read more</a>"; ?></p>
                        <p style="padding-top:5px;">
							<?php $propertyObj->fun_createPropertyCustomerReview($property_id); ?>
                        </p>
                    </td>
                    <td width="23%" valign="top" class="pad-lft15 pad-top5">
                        <table width="100%" border="0" cellspacing="0" cellpadding="1">
                            <tr><td class="lateDealFavourites"id="favourite<?php echo $i;?>"><?php if($propFavArr){?><a href="javascript:removeFavourite('<?php echo $property_id;?>', '<?php echo $_SESSION['ses_user_id'];?>', '<?php echo $i;?>')">Remove favourite</a><?php }else{if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] != ""){?><a href="javascript:addFavourite('<?php echo $property_id;?>', '<?php echo $_SESSION['ses_user_id'];?>', '<?php echo $i;?>')"><?php }else{?><a href="javascript:toggleLayer1('signup');"><?php }?>Add to favourites</a><?php }?></td></tr>
                            <tr><td height="10"></td></tr>
                            <tr>
                            	<td style="line-height:20px;" height="122" valign="top">
								<?php echo $show_price; ?>
                                <?php echo $total_beds; ?>
                                <?php echo $scomfort_beds; ?>
                                <?php echo $total_bathrooms; ?>
                                <?php echo $show_swimming; ?>
                                <?php /*?><?php echo "<br /><input name=\"txtPropertyCheck".$i."\" id=\"txtPropertyCheckId".$i."\" type=\"checkbox\" value=\"".$property_id."\" onclick=\"chkAddToEnquiry(".$i.");\" />&nbsp;Contact owner"; ?><?php */?>
                                </td>
                            </tr>
                        </table>
                        <div><a href="property.php?pid=<?php echo $property_id; ?>"><img src="images/viewdetails.gif" alt="View" width="88" height="27" /></a></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr><td valign="top" class="dash25">&nbsp;</td></tr>
</table>
<?php
}
?>