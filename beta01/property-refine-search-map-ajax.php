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
	
	$propertyObj 	= new Property();
	$usersObj 		= new Users();
	$locationObj 	= new Location();
	
	if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !=""){
		$user_id 			= $_SESSION['ses_user_id'];
		$userInfoArr 		= $usersObj->fun_getUsersInfo($user_id);
		$users_first_name 	= $userInfoArr['user_fname'];
		$users_last_name 	= $userInfoArr['user_lname'];
		$users_email_id 	= $userInfoArr['user_email'];
		$user_full_name 	= ucwords($users_first_name." ".$users_last_name);
		$country_id 		= $userInfoArr['user_country'];
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

if(isset($_REQUEST['featured']) && $_REQUEST['featured'] != "") { $featured = form_text("featured"); $featured = stripslashes($featured); }
if(isset($_REQUEST['txtcountryids']) && $_REQUEST['txtcountryids'] != "") { $txtcountryids = form_text("txtcountryids"); $txtcountryids = stripslashes($txtcountryids);}
if(isset($_REQUEST['txtareaids']) && $_REQUEST['txtareaids'] != "" && $_REQUEST['txtareaids'] != "0") { $txtareaids = form_text("txtareaids"); $txtareaids = stripslashes($txtareaids);}
if(isset($_REQUEST['txtregionids']) && $_REQUEST['txtregionids'] != "" && $_REQUEST['txtregionids'] != "0") { $txtregionids = form_text("txtregionids"); $txtregionids = stripslashes($txtregionids);}
if(isset($_REQUEST['txtsubregionids']) && $_REQUEST['txtsubregionids'] != "" && $_REQUEST['txtsubregionids'] != "0") { $txtsubregionids = form_text("txtsubregionids"); $txtsubregionids = stripslashes($txtsubregionids);}
if(isset($_REQUEST['txtlocationids']) && $_REQUEST['txtlocationids'] != "" && $_REQUEST['txtlocationids'] != "0") { $txtlocationids = form_text("txtlocationids"); $txtlocationids = stripslashes($txtlocationids);}

if(isset($txtcountryids) && $txtcountryids != "") { $search_query .= "&txtcountryids=" . html_escapeURL($txtcountryids); }
if(isset($txtareaids) && $txtareaids != "") { $search_query .= "&txtareaids=" . html_escapeURL($txtareaids); }
if(isset($txtregionids) && $txtregionids != "") { $search_query .= "&txtregionids=" . html_escapeURL($txtregionids); }
if(isset($txtsubregionids) && $txtsubregionids != "") { $search_query .= "&txtsubregionids=" . html_escapeURL($txtsubregionids); }
if(isset($txtlocationids) && $txtlocationids != "") { $search_query .= "&txtlocationids=" . html_escapeURL($txtlocationids); }

if(isset($_REQUEST['txtavailabilityids']) && $_REQUEST['txtavailabilityids'] != "") { $txtavailabilityids = form_text("txtavailabilityids"); $txtavailabilityids = stripslashes($txtavailabilityids); }
if(isset($txtavailabilityids) && $txtavailabilityids == "1") {
	if(isset($txtavailabilityids) && $txtavailabilityids != "") { $search_query .= "&txtavailabilityids=" . html_escapeURL($txtavailabilityids); }
	if(isset($_REQUEST['txtDayFrom0']) && $_REQUEST['txtDayFrom0'] != "") { $txtDayFrom0 = form_text("txtDayFrom0"); $txtDayFrom0 = stripslashes($txtDayFrom0);}
	if(isset($_REQUEST['txtMonthFrom0']) && $_REQUEST['txtMonthFrom0'] != "") { $txtMonthFrom0 = form_text("txtMonthFrom0"); $txtMonthFrom0 = stripslashes($txtMonthFrom0);}
	if(isset($_REQUEST['txtYearFrom0']) && $_REQUEST['txtYearFrom0'] != "") { $txtYearFrom0 = form_text("txtYearFrom0"); $txtYearFrom0 = stripslashes($txtYearFrom0);}
	if(isset($_REQUEST['txtDayTo0']) && $_REQUEST['txtDayTo0'] != "") { $txtDayTo0 = form_text("txtDayTo0"); $txtDayTo0 = stripslashes($txtDayTo0);}
	if(isset($_REQUEST['txtMonthTo0']) && $_REQUEST['txtMonthTo0'] != "") { $txtMonthTo0 = form_text("txtMonthTo0"); $txtMonthTo0 = stripslashes($txtMonthTo0);}
	if(isset($_REQUEST['txtYearTo0']) && $_REQUEST['txtYearTo0'] != "") { $txtYearTo0 = form_text("txtYearTo0"); $txtYearTo0 = stripslashes($txtYearTo0);}
	if($txtMonthFrom0 != "" && $txtDayFrom0 != "" && $txtYearFrom0 != "") {
		$txtFromUnixTime 		= mktime(0, 0, 0, (int)$txtMonthFrom0, (int)$txtDayFrom0, (int)$txtYearFrom0);
		$txtFromDate 			= date('Y-m-d', $txtFromUnixTime);
		if(isset($txtDayFrom0) && $txtDayFrom0 != "") { $search_query .= "&txtDayFrom0=" . html_escapeURL($txtDayFrom0); }
		if(isset($txtMonthFrom0) && $txtMonthFrom0 != "") { $search_query .= "&txtMonthFrom0=" . html_escapeURL($txtMonthFrom0); }
		if(isset($txtYearFrom0) && $txtYearFrom0 != "") { $search_query .= "&txtYearFrom0=" . html_escapeURL($txtYearFrom0); }
	}
	if($txtMonthTo0 != "" && $txtDayTo0 != "" && $txtYearTo0 != "") {
		$txtToUnixTime	 		= mktime(0, 0, 0, (int)$txtMonthTo0, (int)$txtDayTo0, (int)$txtYearTo0);
		$txtToDate 				= date('Y-m-d', $txtToUnixTime);
		if(isset($txtDayTo0) && $txtDayTo0 != "") { $search_query .= "&txtDayTo0=" . html_escapeURL($txtDayTo0); }
		if(isset($txtMonthTo0) && $txtMonthTo0 != "") { $search_query .= "&txtMonthTo0=" . html_escapeURL($txtMonthTo0); }
		if(isset($txtYearTo0) && $txtYearTo0 != "") { $search_query .= "&txtYearTo0=" . html_escapeURL($txtYearTo0); }
	}
}

if((isset($_REQUEST['txtgeneralids']) && $_REQUEST['txtgeneralids'] != "") || (isset($_COOKIE['cook_txtgeneralids']) && $_COOKIE['cook_txtgeneralids'] != "")) { $txtgeneralids = (form_text("txtgeneralids") != "")?form_text("txtgeneralids"):$_COOKIE['cook_txtgeneralids']; $txtgeneralids = stripslashes($txtgeneralids); }
if((isset($_REQUEST['txtserviceids']) && $_REQUEST['txtserviceids'] != "") || (isset($_COOKIE['cook_txtserviceids']) && $_COOKIE['cook_txtserviceids'] != "")) { $txtserviceids = (form_text("txtserviceids") != "")?form_text("txtserviceids"):$_COOKIE['cook_txtserviceids']; $txtserviceids = stripslashes($txtserviceids); }
if((isset($_REQUEST['txtlocationviewids']) && $_REQUEST['txtlocationviewids'] != "") || (isset($_COOKIE['cook_txtlocationviewids']) && $_COOKIE['cook_txtlocationviewids'] != "")) { $txtlocationviewids = (form_text("txtlocationviewids") != "")?form_text("txtlocationviewids"):$_COOKIE['cook_txtlocationviewids']; $txtlocationviewids = stripslashes($txtlocationviewids); }
if((isset($_REQUEST['txtenterainmentids']) && $_REQUEST['txtenterainmentids'] != "") || (isset($_COOKIE['cook_txtenterainmentids']) && $_COOKIE['cook_txtenterainmentids'] != "")) { $txtenterainmentids = (form_text("txtenterainmentids") != "")?form_text("txtenterainmentids"):$_COOKIE['cook_txtenterainmentids']; $txtenterainmentids = stripslashes($txtenterainmentids); }
if((isset($_REQUEST['txtheatingcoolingids']) && $_REQUEST['txtheatingcoolingids'] != "") || (isset($_COOKIE['cook_txtheatingcoolingids']) && $_COOKIE['cook_txtheatingcoolingids'] != "")) { $txtheatingcoolingids = (form_text("txtheatingcoolingids") != "")?form_text("txtheatingcoolingids"):$_COOKIE['cook_txtheatingcoolingids']; $txtheatingcoolingids = stripslashes($txtheatingcoolingids); }
if((isset($_REQUEST['txtactivitynearbyids']) && $_REQUEST['txtactivitynearbyids'] != "") || (isset($_COOKIE['cook_txtactivitynearbyids']) && $_COOKIE['cook_txtactivitynearbyids'] != "")) { $txtactivitynearbyids = (form_text("txtactivitynearbyids") != "")?form_text("txtactivitynearbyids"):$_COOKIE['cook_txtactivitynearbyids']; $txtactivitynearbyids = stripslashes($txtactivitynearbyids); }
if((isset($_REQUEST['txtoutsideids']) && $_REQUEST['txtoutsideids'] != "") || (isset($_COOKIE['cook_txtoutsideids']) && $_COOKIE['cook_txtoutsideids'] != "")) { $txtoutsideids = (form_text("txtoutsideids") != "")?form_text("txtoutsideids"):$_COOKIE['cook_txtoutsideids']; $txtoutsideids = stripslashes($txtoutsideids); }
if((isset($_REQUEST['txtkitchenlinenids']) && $_REQUEST['txtkitchenlinenids'] != "") || (isset($_COOKIE['cook_txtkitchenlinenids']) && $_COOKIE['cook_txtkitchenlinenids'] != "")) { $txtkitchenlinenids = (form_text("txtkitchenlinenids") != "")?form_text("txtkitchenlinenids"):$_COOKIE['cook_txtkitchenlinenids']; $txtkitchenlinenids = stripslashes($txtkitchenlinenids); }
if((isset($_REQUEST['txtholidaytypeids']) && $_REQUEST['txtholidaytypeids'] != "") || (isset($_COOKIE['cook_txtholidaytypeids']) && $_COOKIE['cook_txtholidaytypeids'] != "")) { $txtholidaytypeids = (form_text("txtholidaytypeids") != "")?form_text("txtholidaytypeids"):$_COOKIE['cook_txtholidaytypeids']; $txtholidaytypeids = stripslashes($txtholidaytypeids); }
if((isset($_REQUEST['txtneedsleep']) && $_REQUEST['txtneedsleep'] != "") || (isset($_COOKIE['cook_txtneedsleep']) && $_COOKIE['cook_txtneedsleep'] != "")) { $txtneedsleep = (form_text("txtneedsleep") != "")?form_text("txtneedsleep"):$_COOKIE['cook_txtneedsleep']; $txtneedsleep = stripslashes($txtneedsleep); }
if((isset($_REQUEST['txttotalbed']) && $_REQUEST['txttotalbed'] != "") || (isset($_COOKIE['cook_txttotalbed']) && $_COOKIE['cook_txttotalbed'] != "")) { $txttotalbed = (form_text("txttotalbed") != "")?form_text("txttotalbed"):$_COOKIE['cook_txttotalbed']; $txttotalbed = stripslashes($txttotalbed); }
if((isset($_REQUEST['txtonlybed']) && $_REQUEST['txtonlybed'] != "") || (isset($_COOKIE['cook_txtonlybed']) && $_COOKIE['cook_txtonlybed'] != "")) { $txtonlybed = (form_text("txtonlybed") != "")?form_text("txtonlybed"):$_COOKIE['cook_txtonlybed']; $txtonlybed = stripslashes($txtonlybed); }
if((isset($_REQUEST['txtpropertytypeids']) && $_REQUEST['txtpropertytypeids'] != "") || (isset($_COOKIE['cook_txtpropertytypeids']) && $_COOKIE['cook_txtpropertytypeids'] != "")) { $txtpropertytypeids = (form_text("txtpropertytypeids") != "")?form_text("txtpropertytypeids"):$_COOKIE['cook_txtpropertytypeids']; $txtpropertytypeids = stripslashes($txtpropertytypeids); }
if((isset($_REQUEST['txtavailabilityids']) && $_REQUEST['txtavailabilityids'] != "") || (isset($_COOKIE['cook_txtavailabilityids']) && $_COOKIE['cook_txtavailabilityids'] != "")) { $txtavailabilityids = (form_text("txtavailabilityids") !="")?form_text("txtavailabilityids"):$_COOKIE['cook_txtavailabilityids']; $txtavailabilityids = stripslashes($txtavailabilityids); } else {$txtavailabilityids = 1;}
if((isset($_REQUEST['latedeal']) && $_REQUEST['latedeal'] != "") || (isset($_COOKIE['cook_latedealId']) && $_COOKIE['cook_latedealId'] != "")) { $latedeal = (form_text("latedeal") !="")?form_text("latedeal"):$_COOKIE['cook_latedealId']; $latedeal = stripslashes($latedeal); } else {$latedeal = 0;}

if(isset($featured) && $featured != "") { $search_query .= "&featured=" . html_escapeURL($featured); }
if(isset($txtgeneralids) && $txtgeneralids != "") { $search_query .= "&txtgeneralids=" . html_escapeURL($txtgeneralids); }
if(isset($txtserviceids) && $txtserviceids != "") { $search_query .= "&txtserviceids=" . html_escapeURL($txtserviceids); }
if(isset($txtlocationviewids) && $txtlocationviewids != "") { $search_query .= "&txtlocationviewids=" . html_escapeURL($txtlocationviewids); }
if(isset($txtenterainmentids) && $txtenterainmentids != "") { $search_query .= "&txtenterainmentids=" . html_escapeURL($txtenterainmentids); }
if(isset($txtheatingcoolingids) && $txtheatingcoolingids != "") { $search_query .= "&txtheatingcoolingids=" . html_escapeURL($txtheatingcoolingids); }
if(isset($txtactivitynearbyids) && $txtactivitynearbyids != "") { $search_query .= "&txtactivitynearbyids=" . html_escapeURL($txtactivitynearbyids); }
if(isset($txtoutsideids) && $txtoutsideids != "") { $search_query .= "&txtoutsideids=" . html_escapeURL($txtoutsideids); }
if(isset($txtkitchenlinenids) && $txtkitchenlinenids != "") { $search_query .= "&txtkitchenlinenids=" . html_escapeURL($txtkitchenlinenids); }
if(isset($txtholidaytypeids) && $txtholidaytypeids != "") { $search_query .= "&txtholidaytypeids=" . html_escapeURL($txtholidaytypeids); }
if(isset($txtneedsleep) && $txtneedsleep != "") { $search_query .= "&txtneedsleep=" . html_escapeURL($txtneedsleep); }
if(isset($txttotalbed) && $txttotalbed != "") { $search_query .= "&txttotalbed=" . html_escapeURL($txttotalbed); }
if(isset($txtonlybed) && $txtonlybed != "") { $search_query .= "&txtonlybed=" . html_escapeURL($txtonlybed); }
if(isset($txtpropertytypeids) && $txtpropertytypeids != "") { $search_query .= "&txtpropertytypeids=" . html_escapeURL($txtpropertytypeids); }
if(isset($latedeal) && $latedeal != "") { $search_query .= "&latedeal=" . html_escapeURL($latedeal); }

$country_id 	= $_REQUEST['txtcountryid'];
$area_id 		= $_REQUEST['txtareaid'];
$pregion_id 	= $_REQUEST['txtregionid'];
$region_id 		= $_REQUEST['txtsubregionid'];
$location_id 	= $_REQUEST['txtlocationid'];

$strQueryParameter	= " ORDER BY A.area_id, A.region_id, A.subregion_id ASC ";
$rsQuery			= $propertyObj->fun_getPropertyRefineSearchArr($txtcountryids, $txtareaids, $txtregionids, $txtlocationids, $txtFromUnixTime, $txtToUnixTime, str_replace("-", ",", $txtpropertytypeids), $txtneedsleep, $txttotalbed, str_replace("-", ",",$txtholidaytypeids), str_replace("-", ",", $txtkitchenlinenids), str_replace("-", ",", $txtoutsideids), str_replace("-", ",", $txtactivitynearbyids), str_replace("-", ",", $txtheatingcoolingids), str_replace("-", ",", $txtenterainmentids), str_replace("-", ",", $txtlocationviewids), str_replace("-", ",", $txtserviceids),  str_replace("-", ",", $txtgeneralids), $featured, $latedeal, $strQueryParameter);
$strHTML 			= "";

if($dbObj->getRecordCount($rsQuery) > 0) {
	$propListArr 				= $dbObj->fetchAssoc($rsQuery);
	for($j = 0; $j < count($propListArr); $j++) {
		$property_id			= $propListArr[$j]['property_id'];
		$property_name 			= ucfirst($propListArr[$j]['property_name']);
		$property_title			= ucfirst($propListArr[$j]['property_title']);
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
				$total_beds 	= $propBedInfoArr[0]['total_beds']." Bedrooms";
			}
		} else {
			$total_beds 	= "";
		}
		// For bathrooms
		$propBathInfoArr 	= $propertyObj->fun_getPropertyBathAllInfoArr($property_id);
		if(is_array($propBathInfoArr) && (count($propBathInfoArr) > 0) && ($propBathInfoArr[0]['total_bathrooms'] > 0)){
			$total_bathrooms= $propBathInfoArr[0]['total_bathrooms']." Bathrooms";
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
		
		if(is_array($propPriceInfoArr) && (count($propPriceInfoArr) > 0)){
			$users_currency_symbol	= $propertyObj->fun_findPropertyCurrencySymbol($property_id);
			if($propPriceInfoArr['min_per_night_price'] > 0 && $propPriceInfoArr['max_per_night_price'] > 0 && $propPriceInfoArr['min_per_night_price'] != $propPriceInfoArr['max_per_night_price']) {
				$min_per_night_price 	= number_format($propPriceInfoArr['min_per_night_price']);
				$max_per_night_price 	= number_format($propPriceInfoArr['max_per_night_price']);
				$price_txt 				= "From ".$users_currency_symbol."".$min_per_night_price." per night";
			} else if($propPriceInfoArr['min_per_week_price'] > 0 && $propPriceInfoArr['max_per_week_price'] > 0 && $propPriceInfoArr['min_per_week_price'] != $propPriceInfoArr['max_per_week_price']) {
				$min_per_week_price 	= number_format($propPriceInfoArr['min_per_week_price']);
				$max_per_week_price 	= number_format($propPriceInfoArr['max_per_week_price']);
				$price_txt 				= "From ".$users_currency_symbol."".$min_per_week_price." per week";
			} else if($propPriceInfoArr['min_per_night_price'] > 0) {
				$min_per_night_price 	= number_format($propPriceInfoArr['min_per_night_price']);
				$price_txt 				= "From ".$users_currency_symbol."".$min_per_night_price." per night";
			} else if($propPriceInfoArr['min_per_week_price'] > 0) {
				$min_per_week_price 	= number_format($propPriceInfoArr['min_per_week_price']);
				$price_txt 				= "From ".$users_currency_symbol."".$min_per_week_price." per week";
			} else {
				$price_txt 				= "";
			}
		} else {
			$price_txt 		= "";
		}
	
		$fr_url = $propertyObj->fun_getPropertyFriendlyLink($property_id);
		if(isset($fr_url) && $fr_url != "") {
			$property_link = SITE_URL."vacation-rentals/".strtolower($fr_url);
		} else {
			if(isset($propLocInfoArr['location_name']) && $propLocInfoArr['location_name'] != "") {
				$property_link = SITE_URL."vacation-rentals/in.".str_replace(" ", "-", strtolower($propLocInfoArr['location_name']))."/".fill_zero_left($property_id, "0", (6-strlen($property_id)));
			} else {
				if(isset($propLocInfoArr['location_name']) && $propLocInfoArr['location_name'] != "") {
					$property_link = SITE_URL."vacation-rentals/in.".str_replace(" ", "-", strtolower($propLocInfoArr['location_name']))."/".fill_zero_left($property_id, "0", (6-strlen($property_id)));
				} else {
					$property_link = SITE_URL."vacation-rentals/in.".str_replace(" ", "-", strtolower($propLocInfoArr['region_name']))."/".fill_zero_left($property_id, "0", (6-strlen($property_id)));
				}
			}
		}
	
		if($latitude != "" && $longitude != "") {
			$title = $property_name." - click for details";
/*
			$strPropHTML = '<div><div style="float: left; padding-right: 5px; width: 178px;"><a href="javascript:void(0);" onclick="showProperty(\''.$property_link.'\');" style="text-decoration:none;"><img src="'.PROPERTY_IMAGES_THUMB168x126_PATH.$propMImg.'" width="168" height="126" style="filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='.PROPERTY_IMAGES_THUMB168x126_PATH.$propMImg.', sizingMethod=scale);" border="0"  alt="<?php echo $_SERVER["SERVER_NAME"];?>"/></a></div<div style="width: 160px; overflow: hidden; height: 126px; float: left; padding-left: 5px; margin-right: 10px; text-align: left;"><div style="font-size: 15px; font-family: Arial, Helvetica, sans-serif; color: #4c72aa; background-color: #FFFFFF; text-align: left; line-height: 18px; font-weight: bold; overflow: hidden;"><a href="javascript:void(0);" onclick="showProperty(\''.$property_link.'\');" style="font-size: 15px; font-family: Arial, Helvetica, sans-serif; color: #4c72aa; background-color: #FFFFFF; text-align: left; line-height: 18px; font-weight: bold;" onmouseover="this.style.textDecoration=\'underline\';" onmouseout="this.style.textDecoration=\'none\';">'.$property_name.'</a></div<div id="max-gmapLocation"><div style="font-size: 11px; font-family: Arial, Helvetica, sans-serif; color: #666666; background-color: #FFFFFF; text-align: left; line-height: 14px;">'.$strLoc.'</div<div id="max-gmapPrice"><div style="font-size: 13px; font-family: Arial, Helvetica, sans-serif; color: #000000; background-color: #FFFFFF; text-align: left; line-height: 18px; font-weight: bold;">'.$price_txt.'</div</div<div id="max-gmapBeds" style="font-size: 13px; font-family: Arial, Helvetica, sans-serif; color: #666666; background-color: #FFFFFF; text-align: left; line-height: 18px;">'.$total_beds.'</div<div id="max-gmapBaths" style="font-size: 13px; font-family: Arial, Helvetica, sans-serif; color: #666666; background-color: #FFFFFF; text-align: left; line-height: 18px;">'.$total_bathrooms.'</div><div id="max-gmapBaths" style="font-size: 13px; font-family: Arial, Helvetica, sans-serif; color: #666666; background-color: #FFFFFF; text-align: left; line-height: 18px;">'.$show_swimming.'</div></div></div><div style="clear: both;"></div>';
*/	
			//$strHTML .= ":::".$property_id."~~~".$latitude."~~~".$longitude."~~~".$title."~~~".$strPropHTML;
			$strHTML .= ":::".$property_id."~~~".$latitude."~~~".$longitude."~~~".$title;
		}
	}
}

echo $strHTML;
?>