<?php
$arr 	= $propertyObj->fun_getPropertyDeals4HomeArr();
if(isset($arr) && is_array($arr) && count($arr) > 0) {
	$Keys 	= array_keys($arr);
	shuffle($Keys);
	$propertyDeals4HomeArr = array(); //declare a new array
	foreach( $Keys as $key){
		$propertyDeals4HomeArr[] = $arr[$key];
	}
}
if(isset($propertyDeals4HomeArr) && is_array($propertyDeals4HomeArr) && count($propertyDeals4HomeArr) > 0){
	$showTotal = (count($propertyDeals4HomeArr) > 6) ? 6: count($propertyDeals4HomeArr);
	echo '<div class="pad-top10" style="clear:both;">';
	echo '<h3>Last Minute Deals <span class="font12">- - - - - - - - - - - - - - - - - - - - - - - - - -  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  </span></h3>';
	for($ldCounter = 0; $ldCounter < $showTotal; $ldCounter++) {
		$ldPrpId 				= $propertyDeals4HomeArr[$ldCounter]['property_id'];
		$ldPrpName 				= ucwords($propertyDeals4HomeArr[$ldCounter]['property_name']);
		$ldPrpTitle				= ucfirst($propertyDeals4HomeArr[$ldCounter]['property_title']);
		$ldPrpType				= ucfirst($propertyDeals4HomeArr[$ldCounter]['property_type']);
		$ldOrgPrice				= $propertyDeals4HomeArr[$ldCounter]['original_price'];
		$ldSalePrice			= $propertyDeals4HomeArr[$ldCounter]['sale_price'];
		$start_on				= $propertyDeals4HomeArr[$ldCounter]['start_on'];
		$end_on					= $propertyDeals4HomeArr[$ldCounter]['end_on'];
		$strDuration 			= date('M d', strtotime($start_on))." - ".date('M d', strtotime($end_on));
		$ldRegionName			= ucwords($propertyDeals4HomeArr[$ldCounter]['region_name']);
		$ldPercentSave 			= round(((($ldOrgPrice - $ldSalePrice) / $ldOrgPrice)*100), 0);
		$propertyMainThumbArr 	= $propertyObj->fun_getPropertyMainThumb($ldPrpId);
		$strThumbUrl = PROPERTY_IMAGES_THUMB168x126_PATH.$propertyMainThumbArr[0]['photo_thumb'];
		$strThumbCap = $propertyMainThumbArr[0]['photo_caption'];
	
		$propBedInfoArr 		= $propertyObj->fun_getPropertyBedAllInfoArr($ldPrpId);
		if(is_array($propBedInfoArr) && (count($propBedInfoArr) > 0)){
			if($propBedInfoArr[0]['total_beds'] > 0) {
				$total_beds 	= $propBedInfoArr[0]['total_beds'].(($propBedInfoArr[0]['total_beds'] > 1)?" beds":" bed");
			}
			if($propBedInfoArr[0]['scomfort_beds'] > 0) {
				$scomfort_beds 	= (($propBedInfoArr[0]['scomfort_beds'] > 1)?" sleeps ":" sleeps ").$propBedInfoArr[0]['scomfort_beds'];
			}
			$strBeds = $total_beds." - ".$scomfort_beds;
		} else {
			$total_beds 	= "";
			$scomfort_beds 	= "";
			$strBeds 		= "";
		}
	
		$fr_url = $propertyObj->fun_getPropertyFriendlyLink($ldPrpId);
		if(isset($fr_url) && $fr_url != "") {
			$property_link = SITE_URL."vacation-rentals/".strtolower($fr_url);
		} else {
			$property_link = SITE_URL."vacation-rentals/in.".str_replace("/", "_", str_replace(" ", "^", strtolower($ldLocName)))."/".fill_zero_left($ldPrpId, "0", (6-strlen($ldPrpId)));
		}
		?>
        <div class="box1">
            <a href="<?php echo $property_link; ?>" title="<?php echo $ldPrpTitle; ?>"><img src="<?php echo $strThumbUrl; ?>" alt="<?php echo $strThumbCap." ".$ldPrpName." - ".$ldPrpType; ?>" border="0" width="165px" height="128px" class="image-border"/></a><br />
            <a href="<?php echo $property_link; ?>" class="blue"><strong><?php echo $ldPrpName;?></strong></a><br />
            <strong class="green"><?php echo $strDuration; ?></strong><br /><?php echo $strBeds; ?> <br />(Save <?php echo $ldPercentSave; ?>%)
        </div>
	<?php 
    }
	echo '</div>';
}
?>           
