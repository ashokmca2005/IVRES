<?php	
if($_SERVER["SERVER_NAME"] == "localhost") {
	require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
} else {
	require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
}
require_once(SITE_CLASSES_PATH."class.Users.php");
require_once(SITE_CLASSES_PATH."class.Property.php");
require_once(SITE_CLASSES_PATH."class.Location.php");

$dbObj = new DB();
$dbObj->fun_db_connect();

$usersObj 		= new Users();
$propertyObj 	= new Property();
$locationObj 	= new Location();
if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !=""){
	$user_id 			= $_SESSION['ses_user_id'];
	$userInfoArr 		= $usersObj->fun_getUsersInfo($user_id);
	$users_first_name 	= $userInfoArr['user_fname'];
	$users_last_name 	= $userInfoArr['user_lname'];
	$users_email_id 	= $userInfoArr['user_email'];
	$user_full_name 	= ucwords($users_first_name." ".$users_last_name);
	$rcountry_id 		= $userInfoArr['user_rcountry'];
	$users_currency_code= $usersObj->fun_getUserCurrencyCode($user_id);
} else {
	$users_currency_code= $usersObj->fun_getUserCurrencyCode();
}

switch($users_currency_code) {
	case 'USD':
		$users_currency_id = 1;
	break;
	case 'GBP':
		$users_currency_id = 2;
	break;
	case 'EUR':
		$users_currency_id = 3;
	break;
	default:
		$users_currency_id = DEFAULT_CURRENCY;
}

$users_currency_symbol = $usersObj->fun_getUserCurrencySymbol($users_currency_code);

if(isset($_GET['pid']) && $_GET['pid']!= "") {
	$property_id 	= $_GET['pid'];
	$propertyInfo	= $propertyObj->fun_getPropertyInfo($property_id);
	$property_name 			= ucfirst($propertyInfo['property_name']);
	$property_title 		= ucfirst($propertyInfo['property_title']);
	//for location
	$propLocInfoArr 		= $propertyObj->fun_getPropertyLocInfoArr($property_id);
	$strLocArr 				= array();
	if($propLocInfoArr['location_name'] !=""){
		array_push($strLocArr, ucwords($propLocInfoArr['location_name']));
	}
	if($propLocInfoArr['subregion_name'] !=""){
		array_push($strLocArr, ucwords($propLocInfoArr['subregion_name']));
	}
	if($propLocInfoArr['region_name'] !=""){
		array_push($strLocArr, ucwords($propLocInfoArr['region_name']));
	}
	if($propLocInfoArr['area_name'] !=""){
		array_push($strLocArr, ucwords($propLocInfoArr['area_name']));
	}
	$strLoc 				= implode(", ", $strLocArr);
	$propLatLonArr 			= $propertyObj->fun_getPropertyLatLong($property_id);
	$latitude				= $propLatLonArr[0]['latitude'];
	$longitude				= $propLatLonArr[0]['longitude'];
	$propertyMImgInfo		= $propertyObj->fun_getPropertyMainThumb($property_id);
	$propMImg 				= $propertyMImgInfo[0]['photo_thumb'];
	$propBedInfoArr 		= $propertyObj->fun_getPropertyBedAllInfoArr($property_id);
	// For bedrooms
	if(is_array($propBedInfoArr) && (count($propBedInfoArr) > 0)){
		if($propBedInfoArr[0]['total_beds'] > 0) {
			$total_beds 		= ($propBedInfoArr[0]['total_beds'] > 1)?$propBedInfoArr[0]['total_beds']." Bedrooms":$propBedInfoArr[0]['total_beds']." Bedroom";
		}
	} else {
		$total_beds 	= "";
	}
	// For bathrooms
	$propBathInfoArr 	= $propertyObj->fun_getPropertyBathAllInfoArr($property_id);
	if(is_array($propBathInfoArr) && (count($propBathInfoArr) > 0) && ($propBathInfoArr[0]['total_bathrooms'] > 0)){
		$total_bathrooms 		= ($propBathInfoArr[0]['total_bathrooms'] > 1)?$propBathInfoArr[0]['total_bathrooms']." Bathrooms":$propBathInfoArr[0]['total_bathrooms']." Bathrooms";
	} else {
		$total_bathrooms= "";
	}

	$propPoolInfo	 	= $propertyObj->fun_verifyPropertyByPropertyFacility($property_id, "15");
	if($propPoolInfo) {
		$show_swimming 	= "Swimming pool";
	} else {
		$show_swimming 	= "";
	}

	// For Prices
	$propPriceInfoArr	= $propertyObj->fun_getPropertyPriceFromInfoArr($property_id);

	$currency_symbol = $propertyObj->fun_findPropertyCurrencySymbol($property_id);
	if($propPriceInfoArr['min_per_week_price'] > 0) {
		$min_per_week_price 		= number_format($propPriceInfoArr['min_per_week_price']);
		$price_txt 				= "From ".$currency_symbol.$min_per_week_price." per week";
	} else {
		$price_txt 				= "";
	}

	$fr_url = $propertyObj->fun_getPropertyFriendlyLink($property_id);
	if(isset($fr_url) && $fr_url != "") {
		$property_link = SITE_URL."vacation-rentals/".strtolower($fr_url);
	} else {
		if(isset($propLocInfoArr['location_name']) && $propLocInfoArr['location_name'] != "") {
			$property_link = SITE_URL."vacation-rentals/in.".str_replace(" ", "^", strtolower($propLocInfoArr['location_name']))."/".fill_zero_left($property_id, "0", (6-strlen($property_id)));
		} else {
			$property_link = SITE_URL."vacation-rentals/in.".str_replace(" ", "^", strtolower($propLocInfoArr['region_name']))."/".fill_zero_left($property_id, "0", (6-strlen($property_id)));
		}
	}

$strhtml = '<div><div style="float: left; padding-right: 5px; width: 178px;"><a href="javascript:void(0);" onclick="showProperty(\''.$property_link.'\');" style="text-decoration:none;"><img src="'.PROPERTY_IMAGES_THUMB168x126_PATH.$propMImg.'" width="168" height="126" style="filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='.PROPERTY_IMAGES_THUMB168x126_PATH.$propMImg.', sizingMethod=scale);" border="0"  alt="'.$property_name.'"/></a></div><div style="width: 160px; overflow: hidden; height: 126px; float: left; padding-left: 5px; margin-right: 10px; text-align: left;"><div style="font-size: 15px; font-family: Arial, Helvetica, sans-serif; color: #4c72aa; background-color: #FFFFFF; text-align: left; line-height: 18px; font-weight: bold; overflow: hidden;"><a  href="javascript:void(0);" onclick="showProperty(\''.$property_link.'\');" style="font-size: 15px; font-family: Arial, Helvetica, sans-serif; color: #4c72aa; background-color: #FFFFFF; text-align: left; line-height: 18px; font-weight: bold;" onmouseover="this.style.textDecoration=\'underline\';" onmouseout="this.style.textDecoration=\'none\';">'.$property_name.'</a></div><div id="max-gmapLocation"><div style="font-size: 11px; font-family: Arial, Helvetica, sans-serif; color: #666666; background-color: #FFFFFF; text-align: left; line-height: 14px;">'.$strLoc.'</div><div id="max-gmapPrice"><div style="font-size: 13px; font-family: Arial, Helvetica, sans-serif; color: #000000; background-color: #FFFFFF; text-align: left; line-height: 18px; font-weight: bold;">'.$price_txt.'</div></div><div id="max-gmapBeds" style="font-size: 13px; font-family: Arial, Helvetica, sans-serif; color: #666666; background-color: #FFFFFF; text-align: left; line-height: 18px;">'.$total_beds.'</div><div id="max-gmapBaths" style="font-size: 13px; font-family: Arial, Helvetica, sans-serif; color: #666666; background-color: #FFFFFF; text-align: left; line-height: 18px;">'.$total_bathrooms.'</div><div id="max-gmapBaths" style="font-size: 13px; font-family: Arial, Helvetica, sans-serif; color: #666666; background-color: #FFFFFF; text-align: left; line-height: 18px;">'.$show_swimming.'</div></div></div><div style="clear: both;"></div>';

	echo $strhtml;
}
?>
