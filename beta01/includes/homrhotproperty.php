<?php

$hotPropertyArr = $propertyObj->fun_getHotPropertyArr();

if(isset($hotPropertyArr) && is_array($hotPropertyArr) && count($hotPropertyArr) > 0){

if(isset($showTotalHotProp) && $showTotalHotProp > 0) {

	$showTotalHotProp = (count($hotPropertyArr) > $showTotalHotProp) ? $showTotalHotProp: count($hotPropertyArr);

} else {

	$showTotalHotProp = (count($hotPropertyArr) > 5) ? 5: count($hotPropertyArr);

}

?>

    <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr><td valign="top" class="pad-lft20 pad-rgt15 pad-top3 pad-btm10"><h1 class="font16-darkgrey">Featured properties</h1></td></tr>

        <?php

        for($hpCounter = 0; $hpCounter < $showTotalHotProp; $hpCounter++){

            $hpPrpId 		= $hotPropertyArr[$hpCounter]['property_id'];

            $hpPrpName 		= ucwords($hotPropertyArr[$hpCounter]['property_name']);

            $hpPrpTitle		= ucfirst($hotPropertyArr[$hpCounter]['property_title']);

            $hpPrpType		= ucfirst($hotPropertyArr[$hpCounter]['property_type']);

            $hpPrpLocation	= ucwords($hotPropertyArr[$hpCounter]['location_name'])	;

            $hpPrpRegion	= ucwords($hotPropertyArr[$hpCounter]['region_name'])	;

            $hpPrpThumbArr	= $propertyObj->fun_getPropertyMainThumb($hpPrpId);

            if(count($hpPrpThumbArr) > 0){

                $thumb_pid = $hpPrpThumbArr[0]['photo_id'];

                $thumb_cap = $hpPrpThumbArr[0]['photo_caption'];

                $thumb_url = PROPERTY_IMAGES_THUMB168x126_PATH.$hpPrpThumbArr[0]['photo_thumb'];

            } else {

                $thumb_pid = "";

                $thumb_cap = "No Image";

                $thumb_url = PROPERTY_IMAGES_THUMB168x126_PATH."no-img.gif";

            }

			$hpPrpPriceArr	= $propertyObj->fun_getPropertyPriceFromInfoArr($hpPrpId);

			if(is_array($hpPrpPriceArr) && (count($hpPrpPriceArr) > 0)){

				$currency_symbol = $propertyObj->fun_findPropertyCurrencySymbol($hpPrpId);

				if($hpPrpPriceArr['min_per_night_price'] > 0 && $hpPrpPriceArr['max_per_night_price'] > 0) {

					$min_per_night_price 		= number_format($hpPrpPriceArr['min_per_night_price']);

					$max_per_night_price 		= number_format($hpPrpPriceArr['max_per_night_price']);

//					$show_price 				= $currency_symbol.$min_per_night_price." - ".$currency_symbol.$max_per_night_price." per night<br />";

					$show_price 				= "From ".$currency_symbol.$min_per_night_price." per night<br />";

				} else if($hpPrpPriceArr['min_per_week_price'] > 0 && $hpPrpPriceArr['max_per_week_price'] > 0) {

					$min_per_week_price 		= number_format($hpPrpPriceArr['min_per_week_price']);

					$max_per_week_price 		= number_format($hpPrpPriceArr['max_per_week_price']);

//					$show_price 				= $currency_symbol.$min_per_week_price." - ".$currency_symbol.$max_per_week_price." per week<br />";

					$show_price 				= "From ".$currency_symbol.$min_per_week_price." per week<br />";

				} else if($hpPrpPriceArr['min_per_night_price'] > 0) {

					$min_per_night_price 		= number_format($hpPrpPriceArr['min_per_night_price']);

					$show_price 				= "From ".$currency_symbol.$min_per_night_price." per night<br />";

				} else if($hpPrpPriceArr['min_per_week_price'] > 0) {

					$min_per_week_price 		= number_format($hpPrpPriceArr['min_per_week_price']);

					$show_price 				= "From ".$currency_symbol.$min_per_week_price." per week<br />";

				} else {

					$show_price 				= "<br />";

				}

			} else {

				$show_price 		= "<br />";

			}



            $hpPrpBedArr 		= $propertyObj->fun_getPropertyBedAllInfoArr($hpPrpId);

            if(count($hpPrpBedArr) > 0){

                $total_beds 		= ($hpPrpBedArr[0]['total_beds'] > 1)?$hpPrpBedArr[0]['total_beds']." Bedrooms":$hpPrpBedArr[0]['total_beds']." Bedroom";

                $scomfort_beds 		= ($hpPrpBedArr[0]['scomfort_beds'] > 1)?"sleeps ".$hpPrpBedArr[0]['scomfort_beds']."<br />":"sleep ".$hpPrpBedArr[0]['scomfort_beds']."<br>";

            } else {

                $total_beds 		= "";

                $scomfort_beds 		= "";

            }

        

            $hpPrpBathArr 		= $propertyObj->fun_getPropertyBathAllInfoArr($hpPrpId);

            if(count($hpPrpBathArr) > 0){

                $total_bathrooms 		= $hpPrpBathArr[0]['total_bathrooms']." Bathrooms ";

            } else {

                $total_bathrooms 		= "";

            }



			$fr_url = $propertyObj->fun_getPropertyFriendlyLink($hpPrpId);

			if(isset($fr_url) && $fr_url != "") {

				$property_link = SITE_URL."vacation-rentals/".strtolower($fr_url);

			} else {
				if(isset($hpPrpLocation) && $hpPrpLocation != "") {
					$property_link = SITE_URL."vacation-rentals/in.".str_replace(" ", "-", strtolower($hpPrpLocation))."/".fill_zero_left($hpPrpId, "0", (6-strlen($hpPrpId)));
				} else {
					$property_link = SITE_URL."vacation-rentals/in.".str_replace(" ", "-", strtolower($hpPrpRegion))."/".fill_zero_left($hpPrpId, "0", (6-strlen($hpPrpId)));
				}
			}

        ?>

        <tr>

            <td class="pad-btm15 pad-lft20 pad-rgt15 pad-top5">

                <table border="0" cellpadding="0" cellspacing="0">

                    <tr><td ><a href="<?php echo $property_link; ?>"><img src="<?php echo $thumb_url; ?>" alt="<?php echo $thumb_cap." ".$hpPrpName." - ".$hpPrpType; ?>" border="0" width="168" height="126" /></a></td></tr>

                    <tr>

                        <td valign="top" class="font11 pad-top5 pad-rgt15">

                            <a href="<?php echo $property_link; ?>" class="blue-link font12"><strong><?php echo $hpPrpName;?></strong></a><br />

                            <a href="<?php echo SITE_URL; ?>vacation-rentals/in.<?php echo str_replace("&", "", str_replace(",", "_", str_replace(" ", "-", strtolower($hpPrpLocation)))); ?>" class="blue-link"><?php echo $hpPrpLocation; ?></a><br />

                            <?php echo $show_price; ?>

                            <?php echo $total_beds." - ".$scomfort_beds; ?>

                        </td>

                    </tr>

                </table>

            </td>

        </tr>

        <?php

        }

        ?>

    </table>

<?php

}

?>