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
	$seo_friendly 		= SITE_URL."vacation-rentals"; // for seo friendly urls
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

	if((isset($_REQUEST['txtDateFrom']) && $_REQUEST['txtDateFrom'] != "") || (isset($_COOKIE['cook_txtdatefrom']) && $_COOKIE['cook_txtdatefrom'] != "")) { $txtDateFrom = (form_text("txtDateFrom") != "")?form_text("txtDateFrom"):$_COOKIE['cook_txtdatefrom']; $txtDateFrom = stripslashes($txtDateFrom);}
	if((isset($_REQUEST['txtDateTo']) && $_REQUEST['txtDateTo'] != "") || (isset($_COOKIE['cook_txtdateto']) && $_COOKIE['cook_txtdateto'] != "")) { $txtDateTo = (form_text("txtDateTo") != "")?form_text("txtDateTo"):$_COOKIE['cook_txtdateto']; $txtDateTo = stripslashes($txtDateTo);}
	if((isset($_REQUEST['txtneedsleep']) && $_REQUEST['txtneedsleep'] != "") || (isset($_COOKIE['cook_txtneedsleep']) && $_COOKIE['cook_txtneedsleep'] != "")) { $txtneedsleep = (form_text("txtneedsleep") != "")?form_text("txtneedsleep"):$_COOKIE['cook_txtneedsleep']; $txtneedsleep = stripslashes($txtneedsleep); }
	if((isset($_REQUEST['txttotalbed']) && $_REQUEST['txttotalbed'] != "") || (isset($_COOKIE['cook_txttotalbed']) && $_COOKIE['cook_txttotalbed'] != "")) { $txttotalbed = (form_text("txttotalbed") != "")?form_text("txttotalbed"):$_COOKIE['cook_txttotalbed']; $txttotalbed = stripslashes($txttotalbed); }
	if((isset($_REQUEST['txtpropertytypeids']) && $_REQUEST['txtpropertytypeids'] != "") || (isset($_COOKIE['cook_txtpropertytypeids']) && $_COOKIE['cook_txtpropertytypeids'] != "")) { $txtpropertytypeids = (form_text("txtpropertytypeids") != "")?form_text("txtpropertytypeids"):$_COOKIE['cook_txtpropertytypeids']; $txtpropertytypeids = stripslashes($txtpropertytypeids); }
	if((isset($_REQUEST['txtgeneralids']) && $_REQUEST['txtgeneralids'] != "") || (isset($_COOKIE['cook_txtgeneralids']) && $_COOKIE['cook_txtgeneralids'] != "")) { $txtgeneralids = (form_text("txtgeneralids") != "")?form_text("txtgeneralids"):$_COOKIE['cook_txtgeneralids']; $txtgeneralids = stripslashes($txtgeneralids); }
	if((isset($_REQUEST['txtserviceids']) && $_REQUEST['txtserviceids'] != "") || (isset($_COOKIE['cook_txtserviceids']) && $_COOKIE['cook_txtserviceids'] != "")) { $txtserviceids = (form_text("txtserviceids") != "")?form_text("txtserviceids"):$_COOKIE['cook_txtserviceids']; $txtserviceids = stripslashes($txtserviceids); }
	if((isset($_REQUEST['txtlocationviewids']) && $_REQUEST['txtlocationviewids'] != "") || (isset($_COOKIE['cook_txtlocationviewids']) && $_COOKIE['cook_txtlocationviewids'] != "")) { $txtlocationviewids = (form_text("txtlocationviewids") != "")?form_text("txtlocationviewids"):$_COOKIE['cook_txtlocationviewids']; $txtlocationviewids = stripslashes($txtlocationviewids); }
	if((isset($_REQUEST['txtenterainmentids']) && $_REQUEST['txtenterainmentids'] != "") || (isset($_COOKIE['cook_txtenterainmentids']) && $_COOKIE['cook_txtenterainmentids'] != "")) { $txtenterainmentids = (form_text("txtenterainmentids") != "")?form_text("txtenterainmentids"):$_COOKIE['cook_txtenterainmentids']; $txtenterainmentids = stripslashes($txtenterainmentids); }
	if((isset($_REQUEST['txtheatingcoolingids']) && $_REQUEST['txtheatingcoolingids'] != "") || (isset($_COOKIE['cook_txtheatingcoolingids']) && $_COOKIE['cook_txtheatingcoolingids'] != "")) { $txtheatingcoolingids = (form_text("txtheatingcoolingids") != "")?form_text("txtheatingcoolingids"):$_COOKIE['cook_txtheatingcoolingids']; $txtheatingcoolingids = stripslashes($txtheatingcoolingids); }
	if((isset($_REQUEST['txtactivitynearbyids']) && $_REQUEST['txtactivitynearbyids'] != "") || (isset($_COOKIE['cook_txtactivitynearbyids']) && $_COOKIE['cook_txtactivitynearbyids'] != "")) { $txtactivitynearbyids = (form_text("txtactivitynearbyids") != "")?form_text("txtactivitynearbyids"):$_COOKIE['cook_txtactivitynearbyids']; $txtactivitynearbyids = stripslashes($txtactivitynearbyids); }
	if((isset($_REQUEST['txtoutsideids']) && $_REQUEST['txtoutsideids'] != "") || (isset($_COOKIE['cook_txtoutsideids']) && $_COOKIE['cook_txtoutsideids'] != "")) { $txtoutsideids = (form_text("txtoutsideids") != "")?form_text("txtoutsideids"):$_COOKIE['cook_txtoutsideids']; $txtoutsideids = stripslashes($txtoutsideids); }
	if((isset($_REQUEST['txtkitchenlinenids']) && $_REQUEST['txtkitchenlinenids'] != "") || (isset($_COOKIE['cook_txtkitchenlinenids']) && $_COOKIE['cook_txtkitchenlinenids'] != "")) { $txtkitchenlinenids = (form_text("txtkitchenlinenids") != "")?form_text("txtkitchenlinenids"):$_COOKIE['cook_txtkitchenlinenids']; $txtkitchenlinenids = stripslashes($txtkitchenlinenids); }
	if((isset($_REQUEST['txtholidaytypeids']) && $_REQUEST['txtholidaytypeids'] != "") || (isset($_COOKIE['cook_txtholidaytypeids']) && $_COOKIE['cook_txtholidaytypeids'] != "")) { $txtholidaytypeids = (form_text("txtholidaytypeids") != "")?form_text("txtholidaytypeids"):$_COOKIE['cook_txtholidaytypeids']; $txtholidaytypeids = stripslashes($txtholidaytypeids); }
	if((isset($_REQUEST['txtonlybed']) && $_REQUEST['txtonlybed'] != "") || (isset($_COOKIE['cook_txtonlybed']) && $_COOKIE['cook_txtonlybed'] != "")) { $txtonlybed = (form_text("txtonlybed") != "")?form_text("txtonlybed"):$_COOKIE['cook_txtonlybed']; $txtonlybed = stripslashes($txtonlybed); }
	if((isset($_REQUEST['txtavailabilityids']) && $_REQUEST['txtavailabilityids'] != "") || (isset($_COOKIE['cook_txtavailabilityids']) && $_COOKIE['cook_txtavailabilityids'] != "")) { $txtavailabilityids = (form_text("txtavailabilityids") !="")?form_text("txtavailabilityids"):$_COOKIE['cook_txtavailabilityids']; $txtavailabilityids = stripslashes($txtavailabilityids); } else {$txtavailabilityids = 1;}
	if((isset($_REQUEST['latedeal']) && $_REQUEST['latedeal'] != "") || (isset($_COOKIE['cook_latedealId']) && $_COOKIE['cook_latedealId'] != "")) { $latedeal = (form_text("latedeal") !="")?form_text("latedeal"):$_COOKIE['cook_latedealId']; $latedeal = stripslashes($latedeal); } else {$latedeal = 0;}

	if(isset($txtDateFrom) && $txtDateFrom != "" && isset($txtDateTo) && $txtDateTo != "") {
		$txtFromUnixTime = strtotime($txtDateFrom);
		$search_query 	.= "&txtDateFrom=" . html_escapeURL($txtDateFrom);
		$txtToUnixTime = strtotime($txtDateTo);
		$search_query .= "&txtDateTo=" . html_escapeURL($txtDateTo);
	} else {
		$txtFromUnixTime 	= "";
		$txtToUnixTime 		= "";
	}
	if(isset($txttotalbed) && $txttotalbed != "") { $search_query .= "&txttotalbed=" . html_escapeURL($txttotalbed); }
	if(isset($txtpropertytypeids) && $txtpropertytypeids != "") { $search_query .= "&txtpropertytypeids=" . html_escapeURL($txtpropertytypeids); }
	if(isset($txtneedsleep) && $txtneedsleep != "") { $search_query .= "&txtneedsleep=" . html_escapeURL($txtneedsleep); }
	if(isset($txtkitchenlinenids) && $txtkitchenlinenids != "") { $search_query .= "&txtkitchenlinenids=" . html_escapeURL($txtkitchenlinenids); }
	if(isset($txtoutsideids) && $txtoutsideids != "") { $search_query .= "&txtoutsideids=" . html_escapeURL($txtoutsideids); }
	if(isset($txtactivitynearbyids) && $txtactivitynearbyids != "") { $search_query .= "&txtactivitynearbyids=" . html_escapeURL($txtactivitynearbyids); }
	if(isset($txtenterainmentids) && $txtenterainmentids != "") { $search_query .= "&txtenterainmentids=" . html_escapeURL($txtenterainmentids); }
	if(isset($txtlocationviewids) && $txtlocationviewids != "") { $search_query .= "&txtlocationviewids=" . html_escapeURL($txtlocationviewids); }
	if(isset($txtgeneralids) && $txtgeneralids != "") { $search_query .= "&txtgeneralids=" . html_escapeURL($txtgeneralids); }
	if(isset($txtserviceids) && $txtserviceids != "") { $search_query .= "&txtserviceids=" . html_escapeURL($txtserviceids); }
	if(isset($txtheatingcoolingids) && $txtheatingcoolingids != "") { $search_query .= "&txtheatingcoolingids=" . html_escapeURL($txtheatingcoolingids); }
	if(isset($txtholidaytypeids) && $txtholidaytypeids != "") { $search_query .= "&txtholidaytypeids=" . html_escapeURL($txtholidaytypeids); }
	if(isset($txtonlybed) && $txtonlybed != "") { $search_query .= "&txtonlybed=" . html_escapeURL($txtonlybed); }
	if(isset($featured) && $featured != "") { $search_query .= "&featured=" . html_escapeURL($featured); }
	if(isset($latedeal) && $latedeal != "") { $search_query .= "&latedeal=" . html_escapeURL($latedeal); }

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
		$return_query 		= $search_query."&".$sort_query."&page=$page";
		//$return_query 	= $search_query."&page=$page";
		//$pag 				= new Pagination($rsQueryCount, $search_query."&".$sort_query, GLOBAL_RECORDS_PER_PAGE);
		$pag 				= new Pagination($rsQueryCount, $search_query."&".$sort_query, $records_per_page, $seo_friendly);
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
	$seo_title 				= ($seoArr['seo_title'] != "")?$seoArr['seo_title']:ucfirst($area_name)." vacation rentals on rentownersvillas.com";
	$seo_description		= ($seoArr['seo_description'] != "")?$seoArr['seo_description']:"Find your perfect ".strtolower($area_name)." vacation rentals on rentownersvillas.com, best deals available for all vacationers.";
	$seo_keywords 			= ($seoArr['seo_keywords'] != "")?$seoArr['seo_keywords']:"rentownersvillas.com rentals, ".ucfirst($area_name)." vacation rentals, ".ucfirst($area_name)." rentals price, Perfact ".ucfirst($area_name)." property rentals";
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
		function toggleLayer(whichLayer){
			var output = document.getElementById(whichLayer).innerHTML;
			if(whichLayer == 'ANP-Example')
			{		
				output = '<div style="z-index:5;">'+output+'</div>';
				var googlewin=dhtmlwindow.open("Example", "inline", output, "", "width=295px,height=470px,resize=0,scrolling=0,center=1,xAxis="+x+",yAxis="+y+"", "recal");
			}
			googlewin.onclose=function(){ //Run custom code when window is being closed (return false to cancel action):
				return true
			}
		}
		
		function closeWindow(){	
			document.getElementById("Example").style.display="none";
		}
		
		function closeWindowNRefresh(){
			document.getElementById("Example").style.display="none";
			window.location = location.href;
		}
		
		function addFavourite(property_id, user_id, num){
			var xmlHttp = ajaxFunction();
			var p_id    = property_id;
			var userId  = user_id;
			var Url = "<?php echo SITE_URL; ?>add-to-favorite.php?user_id="+userId+"&property_id="+p_id;
			xmlHttp.onreadystatechange=function(){
				if(xmlHttp.readyState==4){
					document.getElementById('favourite'+num).innerHTML = '<a href=javascript:removeFavourite('+p_id+','+user_id+','+num+');><strong>Remove Shortlist</strong></a>';
				}
			}
			xmlHttp.open("GET", Url ,true);
			xmlHttp.send(null);
		}
		
        function removeFavourite(p_id, user_id, num){
            var xmlHttp       = ajaxFunction();
            var Url           = "<?php echo SITE_URL; ?>remove-favourite.php?user_id="+user_id+"&property_id="+p_id;
            xmlHttp.onreadystatechange=function(){
                if(xmlHttp.readyState==4){
                    if(xmlHttp.responseText == "remove successfully"){
						document.getElementById('favourite'+num).innerHTML = '<a href=javascript:addFavourite('+p_id+','+user_id+','+num+')><strong>Add to Shortlist</strong></a>';
                    }
                }
            }
            xmlHttp.open("GET", Url ,true);
            xmlHttp.send(null);
        }
    </script>
    <script language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>Ajax.js" type="text/javascript"></script>
	<script language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>Post.js" type="text/javascript"></script>
    <script language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>Ajax1.js" type="text/javascript"></script>
    <script language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>Post1.js" type="text/javascript"></script>
    <script language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>Ajax2.js" type="text/javascript"></script>
    <script language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>Post2.js" type="text/javascript"></script>
</head>
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
						<?php require_once(SITE_INCLUDES_PATH.'propertysearchresults-show.php'); ?>
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
