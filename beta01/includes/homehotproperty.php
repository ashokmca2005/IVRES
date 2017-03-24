<?php
$arr = $propertyObj->fun_getHotPropertyArr();
if(isset($arr) && is_array($arr) && count($arr) > 0) {
	$Keys = array_keys($arr);
	shuffle($Keys);
	$hotPropertyArr = array(); //declare a new array
	foreach( $Keys as $key){
		$hotPropertyArr[] = $arr[$key];
	}
}
if(isset($hotPropertyArr) && is_array($hotPropertyArr) && count($hotPropertyArr) > 0){
	$showTotal = (count($hotPropertyArr) > 12) ? 12: count($hotPropertyArr);
	echo '<div class="featured-wrap">';
	echo '<h2>Featured Vacation Rentals</h2>';
	echo '<ul>';
	for($hpCounter = 0; $hpCounter < $showTotal; $hpCounter++){
		$hpPrpId 		= $hotPropertyArr[$hpCounter]['property_id'];
		$hpPrpName 		= ucwords($hotPropertyArr[$hpCounter]['property_name']);
		$hpPrpTitle		= ucfirst($hotPropertyArr[$hpCounter]['property_title']);
		$hpPrpType		= ucfirst($hotPropertyArr[$hpCounter]['property_type']);
		$propLocInfoArr = $propertyObj->fun_getPropertyLocInfoArr($hpPrpId);
		//print_r($propLocInfoArr);
		$hpPrpThumbArr	= $propertyObj->fun_getPropertyMainThumb($hpPrpId);
		if(count($hpPrpThumbArr) > 0){
			$thumb_pid = $hpPrpThumbArr[0]['photo_id'];
			$thumb_cap = $hpPrpThumbArr[0]['photo_caption'];
			$pos = strpos($hpPrpThumbArr[0]['photo_thumb'], "rentalo.com");
			if($pos === false) {
				$thumb_url = PROPERTY_IMAGES_THUMB168x126_PATH.$hpPrpThumbArr[0]['photo_thumb'];
			} else {
				$thumb_url = $hpPrpThumbArr[0]['photo_thumb'];
			}
		} else {
			$thumb_pid = "";
			$thumb_cap = "Image";
			$thumb_url = PROPERTY_IMAGES_THUMB168x126_PATH."no-img.gif";
		}
		$hpPrpPriceArr	= $propertyObj->fun_getPropertyPriceFromInfoArr($hpPrpId);
		if(count($hpPrpPriceArr) > 0){
			$property_currency_symbol 	= $propertyObj->fun_findPropertyCurrencySymbol($hpPrpId);
			$property_currency_id		= $propertyObj->fun_findPropertyCurrencyCode($hpPrpId);
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
			if($hpPrpPriceArr['min_per_week_price'] > 0) {
				$min_per_week_price 		= number_format(($hpPrpPriceArr['min_per_week_price']/$currencyRateArr[$property_currency_code])*$currencyRateArr[$users_currency_code]);
				$show_price 				= $currency_symbol."".$min_per_week_price;
			} else {
				$show_price 				= "";
			}
			/*
			if($hpPrpPriceArr['min_per_night_price'] > 0 && $hpPrpPriceArr['max_per_night_price'] > 0) {
				$min_per_night_price 		= number_format($hpPrpPriceArr['min_per_night_price']);
				$max_per_night_price 		= number_format($hpPrpPriceArr['max_per_night_price']);
				$show_price 				= "From ".$currency_symbol.$min_per_night_price." per night";
			} else if($hpPrpPriceArr['min_per_week_price'] > 0 && $hpPrpPriceArr['max_per_week_price'] > 0) {
				$min_per_week_price 		= number_format($hpPrpPriceArr['min_per_week_price']);
				$max_per_week_price 		= number_format($hpPrpPriceArr['max_per_week_price']);
				$show_price 				= "From ".$currency_symbol.$min_per_week_price." per week";
			} else if($hpPrpPriceArr['min_per_night_price'] > 0) {
				$min_per_night_price 		= number_format($hpPrpPriceArr['min_per_night_price']);
				$show_price 				= "From ".$currency_symbol.$min_per_night_price." per night";
			} else if($hpPrpPriceArr['min_per_week_price'] > 0) {
				$min_per_week_price 		= number_format($hpPrpPriceArr['min_per_week_price']);
				$show_price 				= "From ".$currency_symbol.$min_per_week_price." per week";
			} else {
				$show_price 				= "";
			}
			*/

		} else {
			$show_price 		= "";
		}
		$hpPrpBedArr 		= $propertyObj->fun_getPropertyBedAllInfoArr($hpPrpId);
		if(count($hpPrpBedArr) > 0){
			$total_beds 		= ($hpPrpBedArr[0]['total_beds'] > 1)?$hpPrpBedArr[0]['total_beds']." Bedrooms":$hpPrpBedArr[0]['total_beds']." Bedroom";
			$scomfort_beds 		= ($hpPrpBedArr[0]['scomfort_beds'] > 1)?"Sleeps ".$hpPrpBedArr[0]['scomfort_beds']."":"Sleep ".$hpPrpBedArr[0]['scomfort_beds']."";
		} else {
			$total_beds 		= "";
			$scomfort_beds 		= "";
		}
		$hpPrpBathArr 		= $propertyObj->fun_getPropertyBathAllInfoArr($hpPrpId);
		if(count($hpPrpBathArr) > 0){
			$total_bathrooms 		= ($hpPrpBathArr[0]['total_bathrooms'] > 1)?$hpPrpBathArr[0]['total_bathrooms']." Bathrooms":$hpPrpBathArr[0]['total_bathrooms']." Bathroom";
		} else {
			$total_bathrooms 		= "";
		}
		$fr_url = $propertyObj->fun_getPropertyFriendlyLink($hpPrpId);
		if(isset($fr_url) && $fr_url != "") {
			$property_link = SITE_URL."vacation-rentals/".strtolower($fr_url);
		} else {
			if(isset($hpPrpLocation) && $hpPrpLocation != "") {
				$property_link = SITE_URL."vacation-rentals/in.".str_replace("/", "_", str_replace(" ", "-", strtolower($hpPrpLocation)))."/".fill_zero_left($hpPrpId, "0", (6-strlen($hpPrpId)));
			} else {
				$property_link = SITE_URL."vacation-rentals/in.".str_replace("/", "_", str_replace(" ", "-", strtolower($propLocInfoArr['area_name'])))."/".fill_zero_left($hpPrpId, "0", (6-strlen($hpPrpId)));
			}
		}
	?>
	<li>
        <a href="<?php echo $property_link; ?>" title="<?php echo $hpPrpTitle; ?>"><img src="<?php echo $thumb_url; ?>" alt="<?php echo $thumb_cap." ".$hpPrpName." - ".$hpPrpType; ?>" border="0" /></a>
        <a href="<?php echo $property_link; ?>"><h3><?php echo $hpPrpName;?></h3></a>
        <div class="featured-1">
        <a href="<?php echo SITE_URL; ?>vacation-rentals/in.<?php echo str_replace("&", "", str_replace(",", "_", str_replace(" ", "-", strtolower($propLocInfoArr['area_name'])))); ?>" class="location-1"><?php echo ucwords($propLocInfoArr['area_name'].', '.$propLocInfoArr['countries_name']); ?></a><br />
        <span class="sleeps-1"><?php echo $scomfort_beds; ?></span>
        <br />
        <?php $propertyObj->fun_createPropertyCustomerReview($hpPrpId); ?>
        </div>
        <div class="featured-2">From<br /><span class="price-1"><?php echo $show_price; ?></span></div>
    </li>
	<?php
	}
	echo '</ul>';
	echo '</div>';
}
?>
