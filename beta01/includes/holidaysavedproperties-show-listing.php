<?php
    for($i =0; $i < count($propListArr); $i++) {
	$property_id 		= $propListArr[$i]['property_id'];
	$property_name 		= $propListArr[$i]['property_name'];
	$property_title 	= $propListArr[$i]['property_title'];
	$description	 	= ucfirst(substr($propListArr[$i]['description'], 0, 250));

	$propLocInfoArr = $propertyObj->fun_getPropertyLocInfoArr($property_id);
	$propLoc = "";
	if($propLocInfoArr['area_name'] !=""){
		$propLoc .= "<a href=\"property-search-results.php?destination=".str_replace(" ", "^", strtolower($propLocInfoArr['area_name']))."\">".ucwords($propLocInfoArr['area_name'])."</a> > ";
	}
	if($propLocInfoArr['region_pname'] !=""){
		$propLoc .= "<a href=\"property-search-results.php?destination=".str_replace(" ", "^", strtolower($propLocInfoArr['region_pname']))."\">".ucwords($propLocInfoArr['region_pname'])."</a> > ";
	}
	if($propLocInfoArr['region_name'] !=""){
		$propLoc .= "<a href=\"property-search-results.php?destination=".str_replace(" ", "^", strtolower($propLocInfoArr['region_name']))."\">".ucwords($propLocInfoArr['region_name'])."</a> > ";
	}
	if($propLocInfoArr['location_name'] !=""){
		$propLoc .= "<a href=\"property-search-results.php?destination=".str_replace(" ", "^", strtolower($propLocInfoArr['location_name']))."\">".ucwords($propLocInfoArr['location_name'])."</a> ";
	}

	$propThumbInfoArr = $propertyObj->fun_getPropertyMainThumb($property_id);
	if(count($propThumbInfoArr) > 0){
		$photo_thumb 		= PROPERTY_IMAGES_THUMB168x126.$propThumbInfoArr[0]['photo_thumb'];
		$photo_caption 		= $propThumbInfoArr[0]['photo_caption'];
	} else {
		$photo_thumb 		= PROPERTY_IMAGES_THUMB."no-image-small.gif";
		$photo_caption 		= "No Image";
	}

	$propBedInfoArr 		= $propertyObj->fun_getPropertyBedAllInfoArr($property_id);
	if(count($propBedInfoArr) > 0){
		$total_beds 		= $propBedInfoArr[0]['total_beds']." Bedrooms<br>";
		$scomfort_beds 		= "Sleeps ".$propBedInfoArr[0]['scomfort_beds']."<br>";
	} else {
		$total_beds 		= "";
		$scomfort_beds 		= "";
	}
	
	$propBathInfoArr 		= $propertyObj->fun_getPropertyBathAllInfoArr($property_id);
	if(count($propBathInfoArr) > 0){
		$total_bathrooms 		= $propBathInfoArr[0]['total_bathrooms']." Bathrooms <br>";
	} else {
		$total_bathrooms 		= "";
	}

	$propPriceInfoArr	= $propertyObj->fun_getPropertyPriceFromInfoArr($property_id);
	if(is_array($propPriceInfoArr) && (count($propPriceInfoArr) > 0)){
		$users_currency_symbol	= $propertyObj->fun_findPropertyCurrencySymbol($property_id);
		if($propPriceInfoArr['min_per_night_price'] > 0 && $propPriceInfoArr['max_per_night_price'] > 0 && $propPriceInfoArr['min_per_night_price'] != $propPriceInfoArr['max_per_night_price']) {
			$min_per_night_price 		= number_format($propPriceInfoArr['min_per_night_price']);
			$max_per_night_price 		= number_format($propPriceInfoArr['max_per_night_price']);
			$show_price 				= "<span id=\"price_currency_symbol_id1".$i."\">".$users_currency_symbol."</span><span id=\"price_currency_price_id1".$i."\" >".$min_per_night_price."</span> - <span id=\"price_currency_symbol_id2".$i."\" >".$users_currency_symbol."</span><span id=\"price_currency_price_id2".$i."\">".$max_per_night_price." p/d</span><br />";
		} else if($propPriceInfoArr['min_per_week_price'] > 0 && $propPriceInfoArr['max_per_week_price'] > 0 && $propPriceInfoArr['min_per_week_price'] != $propPriceInfoArr['max_per_week_price']) {
			$min_per_week_price 		= number_format($propPriceInfoArr['min_per_week_price']);
			$max_per_week_price 		= number_format($propPriceInfoArr['max_per_week_price']);
			$show_price 				= "<span id=\"price_currency_symbol_id1".$i."\">".$users_currency_symbol."</span><span id=\"price_currency_price_id1".$i."\" >".$min_per_week_price."</span> - <span id=\"price_currency_symbol_id2".$i."\" >".$users_currency_symbol."</span><span id=\"price_currency_price_id2".$i."\">".$max_per_week_price." p/w</span><br />";
		} else if($propPriceInfoArr['min_per_night_price'] > 0) {
			$min_per_night_price 		= number_format($propPriceInfoArr['min_per_night_price']);
			$show_price 				= "From <span id=\"price_currency_symbol_id1".$i."\">".$users_currency_symbol."</span><span id=\"price_currency_price_id1".$i."\" >".$min_per_night_price." per night</span><br />";
		} else if($propPriceInfoArr['min_per_week_price'] > 0) {
			$min_per_week_price 		= number_format($propPriceInfoArr['min_per_week_price']);
			$show_price 				= "From <span id=\"price_currency_symbol_id1".$i."\">".$users_currency_symbol."</span><span id=\"price_currency_price_id1".$i."\" >".$min_per_week_price." per week</span><br />";
		} else {
			$show_price 				= "<br />";
		}
	} else {
		$show_price 		= "<br />";
	}

/*
	$propPriceInfoArr 		= $propertyObj->fun_getPropertyPriceMinMaxInfoArr($property_id);
	if(count($propPriceInfoArr) > 0){
		$currency_symbol = $propertyObj->fun_findPropertyCurrencySymbol($property_id);
		$min_price 		= number_format($propPriceInfoArr['min_price']);
		$max_price 		= number_format($propPriceInfoArr['max_price']);
		$show_price = $currency_symbol.$min_price."-".$currency_symbol.$max_price." p/w <br>";

	} else {
		$show_price 		= "";
	}
*/
//print_r($propPriceInfoArr);
?>
<table width="690" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr>
        <td colspan="2">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td colspan="2" align="left" valign="top" class=" blueBorder">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class=" pad-btm10">
                        <tr>
                            <td colspan="3" align="left" valign="top" class="pad-btm15 pad-top18"><p class="smallFont11">Property location : <?php echo $propLoc; ?></p></td>
                        </tr>
                        <tr>
                            <td width="179" align="left" valign="top" >
                                <div class="photoFrame">
                                <table border="0" cellspacing="0" cellpadding="0">
                                    <tr><td colspan="2"><img src="gd1.php?img_name=<?php echo $photo_thumb;?>&w=168&h=126" alt="<?php echo $photo_caption;?>" /></td></tr>
                                    <tr>
                                        <td class="pad-left7 pad-top3"><img src="images/video-icon.gif" alt="Video"/></td>
                                        <td align="right" class=" pad-top13 pad-btm12 pad-rgt10"><a href="property.php?pid=<?php echo $property_id; ?>" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image70','','images/viewspecial-over.gif',1)"><img src="images/view-out.gif" alt="View" name="Image70"  border="0" id="Image70" /></a></td>
                                    </tr>
                                </table>
                                </div>
                            </td>
                            <td width="347" valign="top" class="pad-top7 pad-lft15 pad-rgt15">
                                <p class="GreyFont16"><?php echo $property_name." : ".$property_title; ?></p>
                                <p class=" pad-top7"><?php echo $description; ?>.... <a href="property.php?pid=<?php echo $property_id; ?>" class="blue-link">read more</a></p>
                            </td>
                            <td width="165" valign="top" class="pad-top2">
                                <table border="0" cellpadding="0" cellspacing="0" class="rounded">
                                    <tr><td><img src="images/roundedTop.gif" alt="One"/></td></tr>
                                    <tr>
                                        <td class="roundedContent">
                                            <table width="100%" border="0" cellpadding="1" cellspacing="0">
                                                <tr><td><a href="#" class="favLink">Remove favourite</a></td></tr>
                                                <tr><td class="dashvk"><img src="images/ANP-LftDash.gif" alt="ANP" width="4" height="8"/></td></tr>
                                                <tr>
                                                    <td class="black pad-top7 pad-btm5">
                                                        <?php echo $show_price; ?>
                                                        <?php echo $total_beds; ?>
                                                        <?php echo $scomfort_beds; ?>
                                                        <?php echo $total_bathrooms; ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr><td bgcolor="#FFFFFF"><img src="images/roundedBottom.gif" alt="One"/></td></tr>
                                </table>
                            </td>
                        </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td> 
    </tr>
</table>
<?php
}
?>