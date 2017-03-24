<?php	
if($_SERVER["SERVER_NAME"] == "localhost") {
	require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
} else {
	require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
}
require_once(SITE_CLASSES_PATH."class.Users.php");
require_once(SITE_CLASSES_PATH."class.Property.php");
require_once(SITE_CLASSES_PATH."class.Pagination.php");
require_once(SITE_CLASSES_PATH."class.Location.php");
require_once(SITE_CLASSES_PATH."class.Banner.php");
require_once(SITE_CLASSES_PATH."class.CMS.php");

$dbObj = new DB();
$dbObj->fun_db_connect();

$propertyObj 	= new Property();
$usersObj 		= new Users();
$locationObj 	= new Location();
$bannerObj      = new Banner();
$cmsObj         = new Cms();
if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !=""){
	$user_id 			= $_SESSION['ses_user_id'];
	$userInfoArr 		= $usersObj->fun_getUsersInfo($user_id);
	$users_first_name 	= $userInfoArr['user_fname'];
	$users_last_name 	= $userInfoArr['user_lname'];
	$users_email_id 	= $userInfoArr['user_email'];
	$user_full_name 	= ucwords($users_first_name." ".$users_last_name);
//	$country_id 		= $userInfoArr['user_country'];
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

$seo_friendly 		= SITE_URL."map.vacation-rentals"; // for seo friendly urls
if(isset($_REQUEST['destinations']) && $_REQUEST['destinations'] != "") { $destinations = form_text("destinations"); $destinations = stripslashes($destinations); }
if(isset($destinations) && $destinations !="") {
	$seo_friendly 		.= "/in.".$destinations;
	$destinations		= str_replace("_", "/", str_replace("-", " ", $destinations));
	$destinationArr 	= $locationObj->fun_getDestinationInfo($destinations);
	if(isset($destinationArr['country_id']) && $destinationArr['country_id'] != "" && $destinationArr['country_id'] != "0") { $txtcountryids = $destinationArr['country_id']; $txtcountryids = stripslashes($txtcountryids);}
	if(isset($destinationArr['area_id']) && $destinationArr['area_id'] != "" && $destinationArr['area_id'] != "0") { $txtareaids = $destinationArr['area_id']; $txtareaids = stripslashes($txtareaids);}
	if(isset($destinationArr['pregion_id']) && $destinationArr['pregion_id'] != "" && $destinationArr['pregion_id'] != "0") { $txtregionids = $destinationArr['pregion_id']; $txtregionids = stripslashes($txtregionids);}
	if(isset($destinationArr['region_id']) && $destinationArr['region_id'] != "" && $destinationArr['region_id'] != "0") { $txtsubregionids = $destinationArr['region_id']; $txtsubregionids = stripslashes($txtsubregionids);}
	if(isset($destinationArr['location_id']) && $destinationArr['location_id'] != "" && $destinationArr['location_id'] != "0") { $txtlocationids = $destinationArr['location_id']; $txtlocationids = stripslashes($txtlocationids);}
} else if(isset($_POST['txtLocSearch']) && $_POST['txtLocSearch'] != "") {
	$destinations = form_text("txtLocSearch");
	$destinations = stripslashes($destinations);
	$destinationArr 	= $locationObj->fun_getDestinationInfo($destinations);
	if(isset($destinationArr['country_id']) && $destinationArr['country_id'] != "" && $destinationArr['country_id'] != "0") { $txtcountryids = $destinationArr['country_id']; $txtcountryids = stripslashes($txtcountryids);}
	if(isset($destinationArr['area_id']) && $destinationArr['area_id'] != "" && $destinationArr['area_id'] != "0") { $txtareaids = $destinationArr['area_id']; $txtareaids = stripslashes($txtareaids);}
	if(isset($destinationArr['pregion_id']) && $destinationArr['pregion_id'] != "" && $destinationArr['pregion_id'] != "0") { $txtregionids = $destinationArr['pregion_id']; $txtregionids = stripslashes($txtregionids);}
	if(isset($destinationArr['region_id']) && $destinationArr['region_id'] != "" && $destinationArr['region_id'] != "0") { $txtsubregionids = $destinationArr['region_id']; $txtsubregionids = stripslashes($txtsubregionids);}
	if(isset($destinationArr['location_id']) && $destinationArr['location_id'] != "" && $destinationArr['location_id'] != "0") { $txtlocationids = $destinationArr['location_id']; $txtlocationids = stripslashes($txtlocationids);}
} else {
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
}

if(isset($_REQUEST['txtavailabilityids']) && $_REQUEST['txtavailabilityids'] != "") { $txtavailabilityids = form_text("txtavailabilityids"); $txtavailabilityids = stripslashes($txtavailabilityids); }
if(isset($txtavailabilityids) && $txtavailabilityids == "1") {
	if(isset($txtavailabilityids) && $txtavailabilityids != "") { $search_query .= "&txtavailabilityids=" . html_escapeURL($txtavailabilityids); }

	// For jQuery date picker
	if((isset($_REQUEST['txtArrivaldate']) && $_REQUEST['txtArrivaldate'] != "") || (isset($_COOKIE['cook_txtarrivaldate']) && $_COOKIE['cook_txtarrivaldate'] != "")) { $txtArrivaldate = (form_text("txtArrivaldate") != "")?form_text("txtArrivaldate"):$_COOKIE['cook_txtarrivaldate']; $txtArrivaldate = stripslashes($txtArrivaldate);}
	if((isset($_REQUEST['txtDeparturedate']) && $_REQUEST['txtDeparturedate'] != "") || (isset($_COOKIE['cook_txtdeparturedate']) && $_COOKIE['cook_txtdeparturedate'] != "")) { $txtDeparturedate = (form_text("txtDeparturedate") != "")?form_text("txtDeparturedate"):$_COOKIE['cook_txtdeparturedate']; $txtDeparturedate = stripslashes($txtDeparturedate);}

	if($txtArrivaldate != "") {
		list($txtMonthFrom0, $txtDayFrom0, $txtYearFrom0) = split('[/.-]', $txtArrivaldate);
		$txtFromUnixTime 		= mktime(0, 0, 0, (int)$txtMonthFrom0, (int)$txtDayFrom0, (int)$txtYearFrom0);
		$txtFromDate 			= date('Y-m-d', $txtFromUnixTime);
		if(isset($txtArrivaldate) && $txtArrivaldate != "") { $search_query .= "&txtArrivaldate=" . html_escapeURL($txtArrivaldate); }
	}
	if($txtDeparturedate != "") {
		list($txtMonthTo0, $txtDayTo0, $txtYearTo0) = split('[/.-]', $txtDeparturedate);
		$txtToUnixTime	 		= mktime(0, 0, 0, (int)$txtMonthTo0, (int)$txtDayTo0, (int)$txtYearTo0);
		$txtToDate 				= date('Y-m-d', $txtToUnixTime);
		if(isset($txtDeparturedate) && $txtDeparturedate != "") { $search_query .= "&txtDeparturedate=" . html_escapeURL($txtDeparturedate); }
	}
/*
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
*/

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
if((isset($_REQUEST['txtavailabilityids']) && $_REQUEST['txtavailabilityids'] != "") || (isset($_COOKIE['cook_txtavailabilityids']) && $_COOKIE['cook_txtavailabilityids'] != "")) { $txtavailabilityids = (form_text("txtavailabilityids") !="")?form_text("txtavailabilityids"):$_COOKIE['cook_txtavailabilityids']; $txtavailabilityids = stripslashes($txtavailabilityids); }

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
if(isset($txtavailabilityids) && $txtavailabilityids != "") { $search_query .= "&txtavailabilityids=" . html_escapeURL($txtavailabilityids); }

if(isset($destinations) && $destinations != "") {
	$destinationsArr 	= $locationObj->fun_getDestinationInfo($destinations);

//print_r($destinationsArr);

	$location_id 		= $destinationsArr['location_id'];
	$region_id 			= $destinationsArr['region_id'];
	$pregion_id 		= $destinationsArr['pregion_id'];
	$area_id 			= $destinationsArr['area_id'];
	$country_id			= $destinationsArr['country_id'];
	$txtcountryids 		= $country_id;
	$txtareaids = $area_id;
	if($region_id != "" && $region_id != "0") {
		$txtregionids = $region_id;
	} else {
		$txtregionids = $pregion_id;
	}
	$txtlocationids = $location_id;
} else {
	$country_id 	= $_REQUEST['txtcountryid'];
	$area_id 		= $_REQUEST['txtareaid'];
	$pregion_id 	= $_REQUEST['txtregionid'];
	$region_id 		= $_REQUEST['txtsubregionid'];
	$location_id 	= $_REQUEST['txtlocationid'];
}
$strQueryParameter	= " ORDER BY A.area_id, A.region_id, A.subregion_id ASC ";
$rsQuery                                = $propertyObj->fun_getPropertyRefineSearchArr($txtcountryids, $txtareaids, $txtregionids, $txtlocationids, $txtFromUnixTime, $txtToUnixTime, str_replace("-", ",", $txtpropertytypeids), $txtneedsleep, $txtonlybed, $txttotalbed, str_replace("-", ",",$txtholidaytypeids), str_replace("-", ",", $txtkitchenlinenids), str_replace("-", ",", $txtoutsideids), str_replace("-", ",", $txtactivitynearbyids), str_replace("-", ",", $txtheatingcoolingids), str_replace("-", ",", $txtenterainmentids), str_replace("-", ",", $txtlocationviewids), str_replace("-", ",", $txtserviceids),  str_replace("-", ",", $txtgeneralids), $featured, $latedeal, $strQueryParameter);
if($dbObj->getRecordCount($rsQuery) > 0) {

	$propertyTypeArr 			= $propertyObj->fun_getPropertyTypeArrayWithRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids, $txtFromUnixTime, $txtToUnixTime, str_replace("-", ",", $txtpropertytypeids), $txtneedsleep, $txtonlybed, $txttotalbed, str_replace("-", ",",$txtholidaytypeids), str_replace("-", ",", $txtkitchenlinenids), str_replace("-", ",", $txtoutsideids), str_replace("-", ",", $txtactivitynearbyids), str_replace("-", ",", $txtheatingcoolingids), str_replace("-", ",", $txtenterainmentids), str_replace("-", ",", $txtlocationviewids), str_replace("-", ",", $txtserviceids),  str_replace("-", ",", $txtgeneralids), $featured, $latedeal, "");
	$propertyTotalBedArr	 	= $propertyObj->fun_getPropertyBedArrayRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids, $txtFromUnixTime, $txtToUnixTime, str_replace("-", ",", $txtpropertytypeids), $txtneedsleep, $txtonlybed, $txttotalbed, str_replace("-", ",",$txtholidaytypeids), str_replace("-", ",", $txtkitchenlinenids), str_replace("-", ",", $txtoutsideids), str_replace("-", ",", $txtactivitynearbyids), str_replace("-", ",", $txtheatingcoolingids), str_replace("-", ",", $txtenterainmentids), str_replace("-", ",", $txtlocationviewids), str_replace("-", ",", $txtserviceids),  str_replace("-", ",", $txtgeneralids), $featured, $latedeal, "");
	$propertyComfortSleepArr 	= $propertyObj->fun_getPropertySleepArrayRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids, $txtFromUnixTime, $txtToUnixTime, str_replace("-", ",", $txtpropertytypeids), $txtneedsleep, $txtonlybed, $txttotalbed, str_replace("-", ",",$txtholidaytypeids), str_replace("-", ",", $txtkitchenlinenids), str_replace("-", ",", $txtoutsideids), str_replace("-", ",", $txtactivitynearbyids), str_replace("-", ",", $txtheatingcoolingids), str_replace("-", ",", $txtenterainmentids), str_replace("-", ",", $txtlocationviewids), str_replace("-", ",", $txtserviceids),  str_replace("-", ",", $txtgeneralids), $featured, $latedeal, "");
	$propertyHolidayTypeArr	 	= $propertyObj->fun_getPropertyHolidayTypeArrayRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids, $txtFromUnixTime, $txtToUnixTime, str_replace("-", ",", $txtpropertytypeids), $txtneedsleep, $txtonlybed, $txttotalbed, str_replace("-", ",",$txtholidaytypeids), str_replace("-", ",", $txtkitchenlinenids), str_replace("-", ",", $txtoutsideids), str_replace("-", ",", $txtactivitynearbyids), str_replace("-", ",", $txtheatingcoolingids), str_replace("-", ",", $txtenterainmentids), str_replace("-", ",", $txtlocationviewids), str_replace("-", ",", $txtserviceids),  str_replace("-", ",", $txtgeneralids), $featured, $latedeal, "");
	$propertyKitchenArr	 		= $propertyObj->fun_getPropertyKitchenArrayRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids, $txtFromUnixTime, $txtToUnixTime, str_replace("-", ",", $txtpropertytypeids), $txtneedsleep, $txtonlybed, $txttotalbed, str_replace("-", ",",$txtholidaytypeids), str_replace("-", ",", $txtkitchenlinenids), str_replace("-", ",", $txtoutsideids), str_replace("-", ",", $txtactivitynearbyids), str_replace("-", ",", $txtheatingcoolingids), str_replace("-", ",", $txtenterainmentids), str_replace("-", ",", $txtlocationviewids), str_replace("-", ",", $txtserviceids),  str_replace("-", ",", $txtgeneralids), $featured, $latedeal, "");
	$propertyOutsideArr	 		= $propertyObj->fun_getPropertyOutsideArrayRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids, $txtFromUnixTime, $txtToUnixTime, str_replace("-", ",", $txtpropertytypeids), $txtneedsleep, $txtonlybed, $txttotalbed, str_replace("-", ",",$txtholidaytypeids), str_replace("-", ",", $txtkitchenlinenids), str_replace("-", ",", $txtoutsideids), str_replace("-", ",", $txtactivitynearbyids), str_replace("-", ",", $txtheatingcoolingids), str_replace("-", ",", $txtenterainmentids), str_replace("-", ",", $txtlocationviewids), str_replace("-", ",", $txtserviceids),  str_replace("-", ",", $txtgeneralids), $featured, $latedeal, "");
	$propertyActivitiesNearbyArr= $propertyObj->fun_getPropertyActivitiesNearbyArrayRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids, $txtFromUnixTime, $txtToUnixTime, str_replace("-", ",", $txtpropertytypeids), $txtneedsleep, $txtonlybed, $txttotalbed, str_replace("-", ",",$txtholidaytypeids), str_replace("-", ",", $txtkitchenlinenids), str_replace("-", ",", $txtoutsideids), str_replace("-", ",", $txtactivitynearbyids), str_replace("-", ",", $txtheatingcoolingids), str_replace("-", ",", $txtenterainmentids), str_replace("-", ",", $txtlocationviewids), str_replace("-", ",", $txtserviceids),  str_replace("-", ",", $txtgeneralids), $featured, $latedeal, "");
	$propertyHeatingCoolingArr 	= $propertyObj->fun_getPropertyHeatingCoolingArrayRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids, $txtFromUnixTime, $txtToUnixTime, str_replace("-", ",", $txtpropertytypeids), $txtneedsleep, $txtonlybed, $txtonlybed, $txttotalbed, str_replace("-", ",",$txtholidaytypeids), str_replace("-", ",", $txtkitchenlinenids), str_replace("-", ",", $txtoutsideids), str_replace("-", ",", $txtactivitynearbyids), str_replace("-", ",", $txtheatingcoolingids), str_replace("-", ",", $txtenterainmentids), str_replace("-", ",", $txtlocationviewids), str_replace("-", ",", $txtserviceids),  str_replace("-", ",", $txtgeneralids), $featured, $latedeal, "");
	$propertyEntertainmentArr 	= $propertyObj->fun_getPropertyEntertainmentArrayRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids, $txtFromUnixTime, $txtToUnixTime, str_replace("-", ",", $txtpropertytypeids), $txtneedsleep, $txtonlybed, $txttotalbed, str_replace("-", ",",$txtholidaytypeids), str_replace("-", ",", $txtkitchenlinenids), str_replace("-", ",", $txtoutsideids), str_replace("-", ",", $txtactivitynearbyids), str_replace("-", ",", $txtheatingcoolingids), str_replace("-", ",", $txtenterainmentids), str_replace("-", ",", $txtlocationviewids), str_replace("-", ",", $txtserviceids),  str_replace("-", ",", $txtgeneralids), $featured, $latedeal, "");
	$propertyLocationViewArr 	= $propertyObj->fun_getPropertyLocationViewArrayRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids, $txtFromUnixTime, $txtToUnixTime, str_replace("-", ",", $txtpropertytypeids), $txtneedsleep, $txtonlybed, $txttotalbed, str_replace("-", ",",$txtholidaytypeids), str_replace("-", ",", $txtkitchenlinenids), str_replace("-", ",", $txtoutsideids), str_replace("-", ",", $txtactivitynearbyids), str_replace("-", ",", $txtheatingcoolingids), str_replace("-", ",", $txtenterainmentids), str_replace("-", ",", $txtlocationviewids), str_replace("-", ",", $txtserviceids),  str_replace("-", ",", $txtgeneralids), $featured, $latedeal, "");
	$propertyServicesArr 		= $propertyObj->fun_getPropertyServicesArrayRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids, $txtFromUnixTime, $txtToUnixTime, str_replace("-", ",", $txtpropertytypeids), $txtneedsleep, $txtonlybed, $txttotalbed, str_replace("-", ",",$txtholidaytypeids), str_replace("-", ",", $txtkitchenlinenids), str_replace("-", ",", $txtoutsideids), str_replace("-", ",", $txtactivitynearbyids), str_replace("-", ",", $txtheatingcoolingids), str_replace("-", ",", $txtenterainmentids), str_replace("-", ",", $txtlocationviewids), str_replace("-", ",", $txtserviceids),  str_replace("-", ",", $txtgeneralids), $featured, $latedeal, "");
	$propertyGeneralArr 		= $propertyObj->fun_getPropertyGeneralArrayRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids, $txtFromUnixTime, $txtToUnixTime, str_replace("-", ",", $txtpropertytypeids), $txtneedsleep, $txtonlybed, $txttotalbed, str_replace("-", ",",$txtholidaytypeids), str_replace("-", ",", $txtkitchenlinenids), str_replace("-", ",", $txtoutsideids), str_replace("-", ",", $txtactivitynearbyids), str_replace("-", ",", $txtheatingcoolingids), str_replace("-", ",", $txtenterainmentids), str_replace("-", ",", $txtlocationviewids), str_replace("-", ",", $txtserviceids),  str_replace("-", ",", $txtgeneralids), $featured, $latedeal, "");

	
//	$propertyTypeArr 			= $propertyObj->fun_getPropertyTypeArrayWithRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids, $txtFromUnixTime, $txtToUnixTime, str_replace("-", ",", $txtpropertytypeids), $txtneedsleep, $txtonlybed, $txttotalbed, str_replace("-", ",",$txtholidaytypeids), str_replace("-", ",", $txtkitchenlinenids), str_replace("-", ",", $txtoutsideids), str_replace("-", ",", $txtactivitynearbyids), str_replace("-", ",", $txtheatingcoolingids), str_replace("-", ",", $txtenterainmentids), str_replace("-", ",", $txtlocationviewids), str_replace("-", ",", $txtserviceids),  str_replace("-", ",", $txtgeneralids), "");
//	$propertyTotalBedArr	 	= $propertyObj->fun_getPropertyBedArrayRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids, $txtFromUnixTime, $txtToUnixTime, str_replace("-", ",", $txtpropertytypeids), $txtneedsleep, $txtonlybed, $txttotalbed, str_replace("-", ",",$txtholidaytypeids), str_replace("-", ",", $txtkitchenlinenids), str_replace("-", ",", $txtoutsideids), str_replace("-", ",", $txtactivitynearbyids), str_replace("-", ",", $txtheatingcoolingids), str_replace("-", ",", $txtenterainmentids), str_replace("-", ",", $txtlocationviewids), str_replace("-", ",", $txtserviceids),  str_replace("-", ",", $txtgeneralids), "");
//	$propertyComfortSleepArr 	= $propertyObj->fun_getPropertySleepArrayRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids, $txtFromUnixTime, $txtToUnixTime, str_replace("-", ",", $txtpropertytypeids), $txtneedsleep, $txtonlybed, $txttotalbed, str_replace("-", ",",$txtholidaytypeids), str_replace("-", ",", $txtkitchenlinenids), str_replace("-", ",", $txtoutsideids), str_replace("-", ",", $txtactivitynearbyids), str_replace("-", ",", $txtheatingcoolingids), str_replace("-", ",", $txtenterainmentids), str_replace("-", ",", $txtlocationviewids), str_replace("-", ",", $txtserviceids),  str_replace("-", ",", $txtgeneralids), "");
//	$propertyHolidayTypeArr	 	= $propertyObj->fun_getPropertyHolidayTypeArrayRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids, $txtFromUnixTime, $txtToUnixTime, str_replace("-", ",", $txtpropertytypeids), $txtneedsleep, $txtonlybed, $txttotalbed, str_replace("-", ",",$txtholidaytypeids), str_replace("-", ",", $txtkitchenlinenids), str_replace("-", ",", $txtoutsideids), str_replace("-", ",", $txtactivitynearbyids), str_replace("-", ",", $txtheatingcoolingids), str_replace("-", ",", $txtenterainmentids), str_replace("-", ",", $txtlocationviewids), str_replace("-", ",", $txtserviceids),  str_replace("-", ",", $txtgeneralids), "");
//	$propertyKitchenArr	 		= $propertyObj->fun_getPropertyKitchenArrayRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids, $txtFromUnixTime, $txtToUnixTime, str_replace("-", ",", $txtpropertytypeids), $txtneedsleep, $txtonlybed, $txttotalbed, str_replace("-", ",",$txtholidaytypeids), str_replace("-", ",", $txtkitchenlinenids), str_replace("-", ",", $txtoutsideids), str_replace("-", ",", $txtactivitynearbyids), str_replace("-", ",", $txtheatingcoolingids), str_replace("-", ",", $txtenterainmentids), str_replace("-", ",", $txtlocationviewids), str_replace("-", ",", $txtserviceids),  str_replace("-", ",", $txtgeneralids), "");
//	$propertyOutsideArr	 		= $propertyObj->fun_getPropertyOutsideArrayRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids, $txtFromUnixTime, $txtToUnixTime, str_replace("-", ",", $txtpropertytypeids), $txtneedsleep, $txtonlybed, $txttotalbed, str_replace("-", ",",$txtholidaytypeids), str_replace("-", ",", $txtkitchenlinenids), str_replace("-", ",", $txtoutsideids), str_replace("-", ",", $txtactivitynearbyids), str_replace("-", ",", $txtheatingcoolingids), str_replace("-", ",", $txtenterainmentids), str_replace("-", ",", $txtlocationviewids), str_replace("-", ",", $txtserviceids),  str_replace("-", ",", $txtgeneralids), "");
//	$propertyActivitiesNearbyArr= $propertyObj->fun_getPropertyActivitiesNearbyArrayRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids, $txtFromUnixTime, $txtToUnixTime, str_replace("-", ",", $txtpropertytypeids), $txtneedsleep, $txtonlybed, $txttotalbed, str_replace("-", ",",$txtholidaytypeids), str_replace("-", ",", $txtkitchenlinenids), str_replace("-", ",", $txtoutsideids), str_replace("-", ",", $txtactivitynearbyids), str_replace("-", ",", $txtheatingcoolingids), str_replace("-", ",", $txtenterainmentids), str_replace("-", ",", $txtlocationviewids), str_replace("-", ",", $txtserviceids),  str_replace("-", ",", $txtgeneralids), "");
//	$propertyHeatingCoolingArr 	= $propertyObj->fun_getPropertyHeatingCoolingArrayRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids, $txtFromUnixTime, $txtToUnixTime, str_replace("-", ",", $txtpropertytypeids), $txtneedsleep, $txtonlybed, $txttotalbed, str_replace("-", ",",$txtholidaytypeids), str_replace("-", ",", $txtkitchenlinenids), str_replace("-", ",", $txtoutsideids), str_replace("-", ",", $txtactivitynearbyids), str_replace("-", ",", $txtheatingcoolingids), str_replace("-", ",", $txtenterainmentids), str_replace("-", ",", $txtlocationviewids), str_replace("-", ",", $txtserviceids),  str_replace("-", ",", $txtgeneralids), "");
//	$propertyEntertainmentArr 	= $propertyObj->fun_getPropertyEntertainmentArrayRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids, $txtFromUnixTime, $txtToUnixTime, str_replace("-", ",", $txtpropertytypeids), $txtneedsleep, $txtonlybed, $txttotalbed, str_replace("-", ",",$txtholidaytypeids), str_replace("-", ",", $txtkitchenlinenids), str_replace("-", ",", $txtoutsideids), str_replace("-", ",", $txtactivitynearbyids), str_replace("-", ",", $txtheatingcoolingids), str_replace("-", ",", $txtenterainmentids), str_replace("-", ",", $txtlocationviewids), str_replace("-", ",", $txtserviceids),  str_replace("-", ",", $txtgeneralids), "");
//	$propertyLocationViewArr 	= $propertyObj->fun_getPropertyLocationViewArrayRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids, $txtFromUnixTime, $txtToUnixTime, str_replace("-", ",", $txtpropertytypeids), $txtneedsleep, $txtonlybed, $txttotalbed, str_replace("-", ",",$txtholidaytypeids), str_replace("-", ",", $txtkitchenlinenids), str_replace("-", ",", $txtoutsideids), str_replace("-", ",", $txtactivitynearbyids), str_replace("-", ",", $txtheatingcoolingids), str_replace("-", ",", $txtenterainmentids), str_replace("-", ",", $txtlocationviewids), str_replace("-", ",", $txtserviceids),  str_replace("-", ",", $txtgeneralids), "");
//	$propertyServicesArr 		= $propertyObj->fun_getPropertyServicesArrayRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids, $txtFromUnixTime, $txtToUnixTime, str_replace("-", ",", $txtpropertytypeids), $txtneedsleep, $txtonlybed, $txttotalbed, str_replace("-", ",",$txtholidaytypeids), str_replace("-", ",", $txtkitchenlinenids), str_replace("-", ",", $txtoutsideids), str_replace("-", ",", $txtactivitynearbyids), str_replace("-", ",", $txtheatingcoolingids), str_replace("-", ",", $txtenterainmentids), str_replace("-", ",", $txtlocationviewids), str_replace("-", ",", $txtserviceids),  str_replace("-", ",", $txtgeneralids), "");
//	$propertyGeneralArr 		= $propertyObj->fun_getPropertyGeneralArrayRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids, $txtFromUnixTime, $txtToUnixTime, str_replace("-", ",", $txtpropertytypeids), $txtneedsleep, $txtonlybed, $txttotalbed, str_replace("-", ",",$txtholidaytypeids), str_replace("-", ",", $txtkitchenlinenids), str_replace("-", ",", $txtoutsideids), str_replace("-", ",", $txtactivitynearbyids), str_replace("-", ",", $txtheatingcoolingids), str_replace("-", ",", $txtenterainmentids), str_replace("-", ",", $txtlocationviewids), str_replace("-", ",", $txtserviceids),  str_replace("-", ",", $txtgeneralids), "");

	$propListArr 				= $dbObj->fetchAssoc($rsQuery);
} else {
	$propertyTypeArr 			= $propertyObj->fun_getPropertyTypeArrayWithTotalProp();
	$propertyTotalBedArr	 	= $propertyObj->fun_getPropertyBedArrayWithTotalProp();
	$propertyComfortSleepArr 	= $propertyObj->fun_getPropertySleepArrayWithTotalProp();
	$propertyHolidayTypeArr	 	= $propertyObj->fun_getPropertyHolidayTypeWithTotalProp();
	$propertyKitchenArr	 		= $propertyObj->fun_getPropertyKitchenArrayWithTotalProp();
	$propertyOutsideArr	 		= $propertyObj->fun_getPropertyOutsideArrayWithTotalProp();
	$propertyActivitiesNearbyArr= $propertyObj->fun_getPropertyActivitiesNearbyArrayWithTotalProp();
	$propertyHeatingCoolingArr 	= $propertyObj->fun_getPropertyHeatingCoolingArrayWithTotalProp();
	$propertyEntertainmentArr 	= $propertyObj->fun_getPropertyEntertainmentArrayWithTotalProp();
	$propertyLocationViewArr 	= $propertyObj->fun_getPropertyLocationViewArrayWithTotalProp();
	$propertyServicesArr 		= $propertyObj->fun_getPropertyServicesArrayWithTotalProp();
	$propertyGeneralArr 		= $propertyObj->fun_getPropertyGeneralArrayWithTotalProp();

	$shwnoresults = "yes";
}

/*

* Property Search form submmision : End here

*/
if(isset($txtlocationids) && $txtlocationids !="") {
	$destinationInfoArr 		= $locationObj->fun_getLocationShortInfoById($txtlocationids);
} else if(isset($txtsubregionids) && $txtsubregionids !="") {
	$destinationInfoArr 		= $locationObj->fun_getRegionShortInfoById($txtsubregionids);
} else if(isset($txtregionids) && $txtregionids !="") {
	$destinationInfoArr 		= $locationObj->fun_getRegionShortInfoById($txtregionids);
} else if(isset($txtareaids) && $txtareaids !="") {
	$destinationInfoArr 		= $locationObj->fun_getAreaShortInfoById($txtareaids);
} else if(isset($txtcountryids) && $txtcountryids !="") {
	$destinationInfoArr 		= $locationObj->fun_getCountryShortInfoById($txtcountryids);
}

$mapZoomLevel 	= ($_POST['p_map_zoom'] !="")?$_POST['p_map_zoom']:$destinationInfoArr['destination_zoom'];
$mapLatitude 	= ($_POST['p_map_latitude'] !="")?$_POST['p_map_latitude']:$destinationInfoArr['destination_lat'];
$mapLongitude 	= ($_POST['p_map_longitude'] !="")?$_POST['p_map_longitude']:$destinationInfoArr['destination_lon'];

//print_r($destinationInfoArr);
if(is_array($destinationInfoArr) && count($destinationInfoArr) > 0) {
	$area_name = ucwords($destinationInfoArr['destination_name']);
	$area_desc = ucfirst($destinationInfoArr['destination_desc']);
} else {
	$area_name = tranText('worldwide');
	$area_desc = tranText('site_notes_worldwide_accommodation');
}

if(isset($txtpropertytypeids) && $txtpropertytypeids != "") {
	$txtpropertytypeidsArr 	= split("-", $txtpropertytypeids);
}
if(isset($txtholidaytypeids) && $txtholidaytypeids != "") {
	$txtholidaytypeidsArr 		= split("-", $txtholidaytypeids);
}
if(isset($txtspecialrequirmentids) && $txtspecialrequirmentids != "") {
	$txtspecialrequirmentidsArr = split("-", $txtspecialrequirmentids);
}
$currencyRateArr			= $propertyObj->fun_findPropertyCurrencyRate();
$mapShowOn = true;	
$seo_title 				= ($seoArr['seo_title'] != "")?$seoArr['seo_title']:ucfirst($area_name)." Vacation Rentals";
$seo_description		= ($seoArr['seo_description'] != "")?$seoArr['seo_description']:"Find & Book Best ".ucfirst($area_name)." Vacation Rentals";
$seo_keywords 			= ($seoArr['seo_keywords'] != "")?$seoArr['seo_keywords']:"rentownersvillas.com Rentals, ".ucfirst($area_name)." Vacation Rentals, ".ucfirst($area_name)." Rentals Price, Top ".ucfirst($area_name)." Property Rentals";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo $seo_title;?></title>
    <meta name="description" content="<?php echo $seo_description;?>" />
    <meta name="keywords" content="<?php echo $seo_keywords;?>" />
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo tranText('charset'); ?>" />
    <META HTTP-EQUIV="Content-language" CONTENT="<?php echo tranText('lang_iso'); ?>">
    <link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo SITE_URL; ?>favicon.ico" />
    <link rel="SHORTCUT ICON" href="<?php echo SITE_URL; ?>favicon.ico"/>
    <link href="<?php echo SITE_CSS_INCLUDES_PATH;?>common.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>common.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>dhtmlwindow.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>pop-up.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>dargPop.js"></script>
    <script language="javascript" type="text/javascript">
        var x, y;
        function show_coords(event){	
            x=event.clientX;
            y=event.clientY;
            x = x-160;
            y = y+4;
        //	alert(x);alert(y);
        }
    </script>
    <script language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>Ajax.js" type="text/javascript"></script>
    <script language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>Post.js" type="text/javascript"></script>
    <script language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>Ajax1.js" type="text/javascript"></script>
    <script language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>Post1.js" type="text/javascript"></script>
    <script language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>Ajax2.js" type="text/javascript"></script>
    <script language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>Post2.js" type="text/javascript"></script>
</head>
<body onmousedown="show_coords(event)">
<body onmousedown="show_coords(event);">
<!-- Main Wrapper Starts Here -->
<div id="wrapper">
    <!-- Header Include Starts Here -->
    <div id="header" align="center">
        <?php require_once(SITE_INCLUDES_PATH.'header.php'); ?>
    </div>
    <!-- Header Include End Here -->
	<?php require_once(SITE_INCLUDES_PATH.'holidayadvsearch.php'); ?>
	<?php //require_once(SITE_INCLUDES_PATH.'breadcrumb.php'); ?>
    <div id="main">
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="left" valign="top">
                    <?php require_once(SITE_INCLUDES_PATH.'propertysearchresults-left-links.php'); ?>
                </td>
                <td width="30" align="left" valign="top" style="border-right:thin #efefef solid;">&nbsp;</td>
                <td align="left" valign="top" class="font12" style="padding-left:40px;">
                    <div id="showDetails">
                        <?php require_once(SITE_INCLUDES_PATH.'propertymap-show.php'); ?>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>
<!-- Main Wrapper End Here -->
<!-- Footer Include Starts Here -->
<div id="footer">
    <?php require_once(SITE_INCLUDES_PATH.'footer.php'); ?>
</div>
<!-- Footer Include End Here -->
</body>
</html>
