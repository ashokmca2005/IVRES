<script language="javascript" type="text/javascript">
	function showHomeRgtSection(str){
		for(var i=1; i<=2; i++){
			if(i==str){
				if(document.getElementById("homeRgtSectionId"+i)) {
					document.getElementById("homeRgtSectionId"+i).style.display = "block";
				}
			} else {
				if(document.getElementById("homeRgtSectionId"+i)) {
					document.getElementById("homeRgtSectionId"+i).style.display = "none";
				}
			}
		}
	}
</script>

<style type="text/css">
</style>
<?php //require_once(SITE_INCLUDES_PATH.'holidayhomesearch.php'); ?>
<div>
    <?php $propertyObj->fun_createPropertyPopularDestination(); ?>
    <div class="clearfix"></div>
</div>
<div class="rightbar-wrap">
    <div id="homeRgtSectionId1" class="rightbar-wrap-head" style="display:block;">
        <div id="tab_menu-2">
            <ul>
                <li><a href="javascript:void(0);" onclick="return showHomeRgtSection(1);" class="current-2" style="text-decoration:none;">Newest Vacation Rentals</a></li>
                <li><a href="javascript:void(0);" onclick="return showHomeRgtSection(2);" style="text-decoration:none;">Popular Vacation Rentals</a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="rightbar-wrap-list">
        <?php
        $arr = $propertyObj->fun_getNewPropertyArr();
        if(isset($arr) && is_array($arr) && count($arr) > 0) {
            $Keys = array_keys($arr);
            shuffle($Keys);
            $hotPropertyArr = array(); //declare a new array
            foreach($Keys as $key){
                $hotPropertyArr[] = $arr[$key];
            }
        }
        if(isset($hotPropertyArr) && is_array($hotPropertyArr) && count($hotPropertyArr) > 0){
            $showTotal = (count($hotPropertyArr) > 5) ? 5: count($hotPropertyArr);
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
                    //$thumb_url = PROPERTY_IMAGES_THUMB168x126_PATH.$hpPrpThumbArr[0]['photo_thumb'];
					$pos 		= strpos($hpPrpThumbArr[0]['photo_thumb'], "rentalo.com");
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
                    $currency_symbol = $propertyObj->fun_findPropertyCurrencySymbol($hpPrpId);
                    if($hpPrpPriceArr['min_per_week_price'] > 0) {
                        $min_per_week_price 		= number_format($hpPrpPriceArr['min_per_week_price'], 2);
                        $show_price 				= $currency_symbol."".$min_per_week_price;
                    } else {
                        $show_price 				= "";
                    }
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
                <a href="<?php echo SITE_URL; ?>vacation-rentals/in.<?php echo str_replace("&", "", str_replace(",", "_", str_replace(" ", "-", strtolower($propLocInfoArr['area_name'])))); ?>" class="location-2"><?php echo ucwords($propLocInfoArr['area_name'].', '.$propLocInfoArr['countries_name']); ?></a><br />
                <?php $propertyObj->fun_createPropertyCustomerReview($hpPrpId); ?>
            </li>
            <?php
            }
            echo '</ul>';
        }
        ?>
        </div>
    </div>
    <div id="homeRgtSectionId2" class="rightbar-wrap-head" style="display:none;">
        <div id="tab_menu-2">
            <ul>
                <li><a href="javascript:void(0);" onclick="return showHomeRgtSection(1);" style="text-decoration:none;">Newest Vacation Rentals</a></li>
                <li><a href="javascript:void(0);" onclick="return showHomeRgtSection(2);" class="current-2" style="text-decoration:none;">Popular Vacation Rentals</a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="rightbar-wrap-list">
        <?php
        $arr = $propertyObj->fun_getPopularPropertyArr();
        if(isset($arr) && is_array($arr) && count($arr) > 0) {
            $Keys = array_keys($arr);
            shuffle($Keys);
            $hotPropertyArr = array(); //declare a new array
            foreach( $Keys as $key){
                $hotPropertyArr[] = $arr[$key];
            }
        }
        if(isset($hotPropertyArr) && is_array($hotPropertyArr) && count($hotPropertyArr) > 0){
            $showTotal = (count($hotPropertyArr) > 5) ? 5: count($hotPropertyArr);
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
                    //$thumb_url = PROPERTY_IMAGES_THUMB168x126_PATH.$hpPrpThumbArr[0]['photo_thumb'];
					$pos 		= strpos($hpPrpThumbArr[0]['photo_thumb'], "rentalo.com");
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
                    $currency_symbol = $propertyObj->fun_findPropertyCurrencySymbol($hpPrpId);
                    if($hpPrpPriceArr['min_per_week_price'] > 0) {
                        $min_per_week_price 		= number_format($hpPrpPriceArr['min_per_week_price'], 2);
                        $show_price 				= $currency_symbol."".$min_per_week_price;
                    } else {
                        $show_price 				= "";
                    }
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
                <a href="<?php echo SITE_URL; ?>vacation-rentals/in.<?php echo str_replace("&", "", str_replace(",", "_", str_replace(" ", "-", strtolower($propLocInfoArr['area_name'])))); ?>" class="location-2"><?php echo ucwords($propLocInfoArr['area_name'].', '.$propLocInfoArr['countries_name']); ?></a><br />
                <?php $propertyObj->fun_createPropertyCustomerReview($hpPrpId); ?>
            </li>
            <?php
            }
            echo '</ul>';
        }
        ?>
        </div>
    </div>
    <div class="clearfix"></div>
</div>

<div class="newslatter" style="margin-top:20px;">
    <?php require_once(SITE_INCLUDES_PATH.'socialnetworking.php'); ?>
    <div class="clearfix"></div>
</div>
<div>
    <?php require_once(SITE_INCLUDES_PATH.'homeadvertisement.php'); ?>
    <div class="clearfix"></div>
</div>
<?php /*?>
<div>
    <?php $tvlguidObj->fun_createTravelGuide4Home(); ?>
    <div class="clearfix"></div>
</div>
<div class="rightmenubox">
    <?php $cmsObj->fun_createRightMenu4Home(); ?>
    <div class="clearfix"></div>
</div>
<?php */?>