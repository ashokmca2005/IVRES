<?php	
	if($_SERVER["SERVER_NAME"] == "localhost") {
		require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
	} else {
		require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
	}

	if (!headers_sent()) {
	   header('Content-Type: text/html; charset=ISO-8859-1');
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

	/*
	* Property Search form submmision : Start here
	*/
	$page	 = form_int("page",1)+0;
	$sortby  = form_int("sortby",0,0,7);
	$sortdir = form_int("sortdir",0,0,1);
	if (form_isset("reverse")) {
		$sortdir = 1-$sortdir;
	}
	
	switch($sortdir) {
		case 0 : $orderDir = "ASC"; break;
		case 1 : $orderDir = "DESC"; break;
	}

	switch($sortby) {
		case 0:
			$sortField  = "A.updated_on";
			$orderDir = "DESC";
		break;
		case 1:
			$sortbyidsArr 	= $propertyObj->fun_getPropertyIdsByPriceSort("ASC");
			if(is_array($sortbyidsArr) && count($sortbyidsArr) > 0) {
				$sortbyids 		= implode("','", array_unique($sortbyidsArr));
				$sortField  	= "Field(A.property_id, '".$sortbyids."') ";
				$orderDir 		= "";
			} else {
				$sortField  = "A.updated_on";
				$orderDir = "DESC";
			}
		break;
		case 2:
			$sortbyidsArr 	= $propertyObj->fun_getPropertyIdsByPriceSort("ASC");
			if(is_array($sortbyidsArr) && count($sortbyidsArr) > 0) {
				$sortbyids 		= implode("','", array_reverse(array_unique($sortbyidsArr)));
				$sortField  	= "Field(A.property_id, '".$sortbyids."') ";
				$orderDir 		= "";
			} else {
				$sortField  = "A.updated_on";
				$orderDir = "DESC";
			}
		break;
		case 3:
			$sortbyidsArr 	= $propertyObj->fun_getPropertyIdsByReviewsSort("DESC");
			if(is_array($sortbyidsArr) && count($sortbyidsArr) > 0) {
				$sortbyids 		= implode("','", array_reverse(array_unique($sortbyidsArr)));
				$sortField  	= "Field(A.property_id, '".$sortbyids."') ";
				$orderDir 		= "DESC";
	
				//$sortField  = "C.property_rating";
				//$orderDir = "DESC";
			} else {
				$sortField  = "A.updated_on";
				$orderDir = "DESC";
			}
		break;
		case 4:
			$sortbyidsArr 	= $propertyObj->fun_getPropertyIdsByLateDealSort("DESC");
			if(is_array($sortbyidsArr) && count($sortbyidsArr) > 0) {
				$sortbyids 		= implode("','", $sortbyidsArr);
				$sortField  	= "Field(A.property_id, '".$sortbyids."') ";
				$orderDir 		= "DESC";
	
				//$sortField  = "C.property_rating";
				//$orderDir = "DESC";
			} else {
				$sortField  = "A.updated_on";
				$orderDir = "DESC";
			}
		break;
		case 5:
			$sortField  = "A.property_id";
		break;
		default:
			$sortField = "A.updated_on";
			$orderDir = "DESC";
		break;
	}

//print_r($_REQUEST);

	$seo_friendly 		= SITE_URL."accommodation"; // for seo friendly urls
	if(isset($_REQUEST['destinations']) && $_REQUEST['destinations'] != "") { $destinations = form_text("destinations"); $destinations = stripslashes($destinations); }
	if(isset($_REQUEST['featured']) && $_REQUEST['featured'] != "") { $featured = form_text("featured"); $featured = stripslashes($featured); }
	if(isset($destinations) && $destinations !="") {
		$seo_friendly 		.= "/in.".$destinations;
		$destinations		= str_replace("_", "/", str_replace("-", " ", $destinations));

		if(isset($destinations) && $destinations == "africa") {
			$txtcountryids = '34,37,39,63,79,82,110,127,144,147,155,156,185,187,193,208,210,214,239';
		} else if(isset($destinations) && $destinations == "asia") {
			$txtcountryids = '44,96,107,206';
		} else if(isset($destinations) && $destinations == "australia south pacific") {
			$txtcountryids = '13,71,76,153,227';
		} else if(isset($destinations) && $destinations == "caribbean") {
			$txtcountryids = '7,12,16,19,40,54,59,60,86,87,106,134,143,172,231,232';
		} else if(isset($destinations) && $destinations == "central america") {
			$txtcountryids = '22,51,64,89,95,154,164';
		} else if(isset($destinations) && $destinations == "europe") {
			$txtcountryids = '2,5,14,20,21,33,53,55,56,57,67,72,73,74,81,83,84,97,98,103,105,117,123,132,141,150,151,160,170,171,175,176,182,189,190,195,203,204,215,220,240,241,246';
		} else if(isset($destinations) && $destinations == "indian ocean") {
			$txtcountryids = '31,99,130,136,137,186,196';
		} else if(isset($destinations) && $destinations == "middle east") {
			$txtcountryids = '102,104,161,175,205,221';
		} else if(isset($destinations) && $destinations == "south america") {
			$txtcountryids = '10,30,43,47,62,166,167,225,229';
		} else if(isset($destinations) && $destinations == "southeast asia") {
			$txtcountryids = '100,129,168,188,209';
		} else {
			$destinationArr 	= $locationObj->fun_getDestinationInfo($destinations);
			if(isset($destinationArr['country_id']) && $destinationArr['country_id'] != "" && $destinationArr['country_id'] != "0") { $txtcountryids = $destinationArr['country_id']; $txtcountryids = stripslashes($txtcountryids);}
			if(isset($destinationArr['area_id']) && $destinationArr['area_id'] != "" && $destinationArr['area_id'] != "0") { $txtareaids = $destinationArr['area_id']; $txtareaids = stripslashes($txtareaids);}
			if(isset($destinationArr['pregion_id']) && $destinationArr['pregion_id'] != "" && $destinationArr['pregion_id'] != "0") { $txtregionids = $destinationArr['pregion_id']; $txtregionids = stripslashes($txtregionids);}
			if(isset($destinationArr['region_id']) && $destinationArr['region_id'] != "" && $destinationArr['region_id'] != "0") { $txtsubregionids = $destinationArr['region_id']; $txtsubregionids = stripslashes($txtsubregionids);}
			if(isset($destinationArr['location_id']) && $destinationArr['location_id'] != "" && $destinationArr['location_id'] != "0") { $txtlocationids = $destinationArr['location_id']; $txtlocationids = stripslashes($txtlocationids);}
		}

	} else if(isset($_POST['txtLocSearch']) && $_POST['txtLocSearch'] != "") {
		$destinations = form_text("txtLocSearch");
		$destinations = stripslashes($destinations);
		$destinations = str_replace("/", "_", str_replace(" ", "-", strtolower($destinations)));
		redirectURL(SITE_URL."vacation-rentals/in.".$destinations);
	} else {
		if(isset($_REQUEST['txtcountryids']) && $_REQUEST['txtcountryids'] != "" && $_REQUEST['txtcountryids'] != "0") { $txtcountryids = form_text("txtcountryids"); $txtcountryids = stripslashes($txtcountryids);}
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
	if(isset($txtavailabilityids) && $txtavailabilityids == "1") {
		if(isset($txtavailabilityids) && $txtavailabilityids != "") { $search_query .= "&txtavailabilityids=" . html_escapeURL($txtavailabilityids); }
		if((isset($_REQUEST['txtDayFrom0']) && $_REQUEST['txtDayFrom0'] != "") || (isset($_COOKIE['cook_txtdayfrom0']) && $_COOKIE['cook_txtdayfrom0'] != "")) { $txtDayFrom0 = (form_text("txtDayFrom0") != "")?form_text("txtDayFrom0"):$_COOKIE['cook_txtdayfrom0']; $txtDayFrom0 = stripslashes($txtDayFrom0);}
		if((isset($_REQUEST['txtMonthFrom0']) && $_REQUEST['txtMonthFrom0'] != "") || (isset($_COOKIE['cook_txtmonthfrom0']) && $_COOKIE['cook_txtmonthfrom0'] != "")) { $txtMonthFrom0 = (form_text("txtMonthFrom0") != "")?form_text("txtMonthFrom0"):$_COOKIE['cook_txtmonthfrom0']; $txtMonthFrom0 = stripslashes($txtMonthFrom0);}
		if((isset($_REQUEST['txtYearFrom0']) && $_REQUEST['txtYearFrom0'] != "") || (isset($_COOKIE['cook_txtyearfrom0']) && $_COOKIE['cook_txtyearfrom0'] != "")) { $txtYearFrom0 = (form_text("txtYearFrom0") != "")?form_text("txtYearFrom0"):$_COOKIE['cook_txtyearfrom0']; $txtYearFrom0 = stripslashes($txtYearFrom0);}
		if((isset($_REQUEST['txtDayTo0']) && $_REQUEST['txtDayTo0'] != "") || (isset($_COOKIE['cook_txtdayto0']) && $_COOKIE['cook_txtdayto0'] != "")) { $txtDayTo0 = (form_text("txtDayTo0") != "")?form_text("txtDayTo0"):$_COOKIE['cook_txtdayto0']; $txtDayTo0 = stripslashes($txtDayTo0);}
		if((isset($_REQUEST['txtMonthTo0']) && $_REQUEST['txtMonthTo0'] != "") || (isset($_COOKIE['cook_txtmonthto0']) && $_COOKIE['cook_txtmonthto0'] != "")) { $txtMonthTo0 = (form_text("txtMonthTo0") != "")?form_text("txtMonthTo0"):$_COOKIE['cook_txtmonthto0']; $txtMonthTo0 = stripslashes($txtMonthTo0);}
		if((isset($_REQUEST['txtYearTo0']) && $_REQUEST['txtYearTo0'] != "") || (isset($_COOKIE['cook_txtyearto0']) && $_COOKIE['cook_txtyearto0'] != "")) { $txtYearTo0 = (form_text("txtYearTo0") != "")?form_text("txtYearTo0"):$_COOKIE['cook_txtyearto0']; $txtYearTo0 = stripslashes($txtYearTo0);}

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

	if(isset($destinations) && $destinations == "africa") {
		$txtcountryids = '34,37,39,63,79,82,110,127,144,147,155,156,185,187,193,208,210,214,239';
	} else if(isset($destinations) && $destinations == "asia") {
		$txtcountryids = '44,96,107,206';
	} else if(isset($destinations) && $destinations == "australia south pacific") {
		$txtcountryids = '13,71,76,153,227';
	} else if(isset($destinations) && $destinations == "caribbean") {
		$txtcountryids = '7,12,16,19,40,54,59,60,86,87,106,134,143,172,231,232';
	} else if(isset($destinations) && $destinations == "central america") {
		$txtcountryids = '22,51,64,89,95,154,164';
	} else if(isset($destinations) && $destinations == "europe") {
		$txtcountryids = '2,5,14,20,21,33,53,55,56,57,67,72,73,74,81,83,84,97,98,103,105,117,123,132,141,150,151,160,170,171,175,176,182,189,190,195,203,204,215,220,240,241,246';
	} else if(isset($destinations) && $destinations == "indian ocean") {
		$txtcountryids = '31,99,130,136,137,186,196';
	} else if(isset($destinations) && $destinations == "middle east") {
		$txtcountryids = '102,104,161,175,205,221';
	} else if(isset($destinations) && $destinations == "south america") {
		$txtcountryids = '10,30,43,47,62,166,167,225,229';
	} else if(isset($destinations) && $destinations == "southeast asia") {
		$txtcountryids = '100,129,168,188,209';
	} else if(isset($destinations) && $destinations != "") {
		$destinationsArr 	= $locationObj->fun_getDestinationInfo($destinations);
		$location_id 		= $destinationsArr['location_id'];
		$region_id 			= $destinationsArr['region_id'];
		$pregion_id 		= $destinationsArr['pregion_id'];
		$area_id 			= $destinationsArr['area_id'];
		$country_id			= $destinationsArr['country_id'];
		$txtcountryids = $country_id;
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

	if(isset($_COOKIE['cook_records_per_page']) && $_COOKIE['cook_records_per_page'] != "") {
		$records_per_page = $_COOKIE['cook_records_per_page'];
	} else {
		$records_per_page = GLOBAL_RECORDS_PER_PAGE;
	}

	$strQueryParameter		= " ORDER BY " . $sortField . " " . $orderDir. " LIMIT ".(int)(($page-1)*(int)$records_per_page).", ".$records_per_page;
	$strQueryCountParameter	= " ORDER BY " . $sortField . " " . $orderDir;

	$rsQuery				= $propertyObj->fun_getPropertyRefineSearchArr($txtcountryids, $txtareaids, $txtregionids, $txtlocationids, $txtFromUnixTime, $txtToUnixTime, str_replace("-", ",", $txtpropertytypeids), $txtneedsleep, $txtonlybed, $txttotalbed, str_replace("-", ",",$txtholidaytypeids), str_replace("-", ",", $txtkitchenlinenids), str_replace("-", ",", $txtoutsideids), str_replace("-", ",", $txtactivitynearbyids), str_replace("-", ",", $txtheatingcoolingids), str_replace("-", ",", $txtenterainmentids), str_replace("-", ",", $txtlocationviewids), str_replace("-", ",", $txtserviceids),  str_replace("-", ",", $txtgeneralids), $featured, $latedeal, $strQueryParameter);
	$rsQueryCount			= $propertyObj->fun_getPropertyRefineSearchArr($txtcountryids, $txtareaids, $txtregionids, $txtlocationids, $txtFromUnixTime, $txtToUnixTime, str_replace("-", ",", $txtpropertytypeids), $txtneedsleep, $txtonlybed, $txttotalbed, str_replace("-", ",",$txtholidaytypeids), str_replace("-", ",", $txtkitchenlinenids), str_replace("-", ",", $txtoutsideids), str_replace("-", ",", $txtactivitynearbyids), str_replace("-", ",", $txtheatingcoolingids), str_replace("-", ",", $txtenterainmentids), str_replace("-", ",", $txtlocationviewids), str_replace("-", ",", $txtserviceids),  str_replace("-", ",", $txtgeneralids), $featured, $latedeal, $strQueryCountParameter);

	$sort_query   = "sortby=" . html_escapeURL($sortby) ."&sortdir=" . html_escapeURL($sortdir);

	if($dbObj->getRecordCount($rsQueryCount) > 0) {

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

		$propListArr 				= $dbObj->fetchAssoc($rsQuery);
		$total_properties 			= $dbObj->getRecordCount($rsQueryCount);
		// Determine the pagination
//		$return_query 		= $search_query."&".$sort_query."&page=$page";
		$return_query 		= $search_query."&page=$page";
//		$pag 				= new Pagination($rsQueryCount, $search_query."&".$sort_query, GLOBAL_RECORDS_PER_PAGE);


		$pag 				= new Pagination($rsQueryCount, $search_query, $records_per_page, $seo_friendly);
		$pag->current_page 	= $page;
		$pagination  		= $pag->Process();
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
		$total_properties 			= 0;

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


	if(isset($txtpropertytypeids) && $txtpropertytypeids != "") {
		$txtpropertytypeidsArr 	= split("-", $txtpropertytypeids);
	}
	if(isset($txtholidaytypeids) && $txtholidaytypeids != "") {
		$txtholidaytypeidsArr 		= split("-", $txtholidaytypeids);
	}
	if(isset($txtkitchenlinenids) && $txtkitchenlinenids != "") {
		$txtkitchenlinenidsArr = split("-", $txtkitchenlinenids);
	}
	if(isset($txtoutsideids) && $txtoutsideids != "") {
		$txtoutsideidsArr = split("-", $txtoutsideids);
	}
	if(isset($txtactivitynearbyids) && $txtactivitynearbyids != "") {
		$txtactivitynearbyidsArr = split("-", $txtactivitynearbyids);
	}
	if(isset($txtheatingcoolingids) && $txtheatingcoolingids != "") {
		$txtheatingcoolingidsArr = split("-", $txtheatingcoolingids);
	}
	if(isset($txtenterainmentids) && $txtenterainmentids != "") {
		$txtenterainmentidsArr = split("-", $txtenterainmentids);
	}
	if(isset($txtlocationviewids) && $txtlocationviewids != "") {
		$txtlocationviewidsArr = split("-", $txtlocationviewids);
	}
	if(isset($txtserviceids) && $txtserviceids != "") {
		$txtserviceidsArr = split("-", $txtserviceids);
	}
	if(isset($txtgeneralids) && $txtgeneralids != "") {
		$txtgeneralidsArr = split("-", $txtgeneralids);
	}

	$currencyRateArr			= $propertyObj->fun_findPropertyCurrencyRate();

	$mapShowOn = false;	
	if(strpos($str_url, "property-search-results.php") == true) {
		$mapShowOn = false;	
	} else if(strpos($str_url, "property-map-search.php") == true){
		$mapShowOn = true;	
	}
	//print_r($_REQUEST);
?>
<?php require_once(SITE_INCLUDES_PATH.'propertysearchresults-show.php'); ?>
