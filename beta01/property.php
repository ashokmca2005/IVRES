<?php	
	if($_SERVER["SERVER_NAME"] == "localhost") {
		require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
	} else {
		require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
	}
	require_once(SITE_CLASSES_PATH."class.Users.php");
	require_once(SITE_CLASSES_PATH."class.Property.php");
	require_once(SITE_CLASSES_PATH."class.Location.php");
	require_once(SITE_CLASSES_PATH."class.CMS.php");
	$usersObj 		= new Users();
	$propertyObj 	= new Property();
	$cmsObj         = new Cms();
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
			$users_currency_id 	= 1;
		break;
		case 'GBP':
			$users_currency_id 	= 2;
		break;
		case 'EUR':
			$users_currency_id 	= 3;
		break;
		default:
			$users_currency_id 	= DEFAULT_CURRENCY;
	}

	$users_currency_symbol = $usersObj->fun_getUserCurrencySymbol($users_currency_code);

	//echo $users_currency_code;

	if(isset($_GET['name']) && $_GET['name'] !="") {
		$name 			= $_GET['name'];
		$name			= str_replace("_", ",", str_replace("-", " ", $name));
		$property_id	= $propertyObj->fun_getPropertyIdByName($name);
	} else if(isset($_GET['fr_url']) && $_GET['fr_url'] !="") {
		$fr_url			= $_GET['fr_url'];
		$fr_url			= str_replace("_", ",", $fr_url);
		$property_id	= $propertyObj->fun_getPropertyIdByFriendlyURL($fr_url);
	}  else if(isset($_GET['pid']) && $_GET['pid'] !="") {
		$property_id	= $_GET['pid'];
	} else {
		redirectURL(SITE_URL."accommodation");
	}

	/*
	if(isset($_REQUEST['destinations']) && $_REQUEST['destinations'] != "") { $destinations = form_text("destinations"); $destinations = stripslashes($destinations); }
	if((isset($_REQUEST['txtDateFrom']) && $_REQUEST['txtDateFrom'] != "") || (isset($_COOKIE['cook_txtdatefrom']) && $_COOKIE['cook_txtdatefrom'] != "")) { $txtDateFrom = (form_text("txtDateFrom") != "")?form_text("txtDateFrom"):$_COOKIE['cook_txtdatefrom']; $txtDateFrom = stripslashes($txtDateFrom);}
	if((isset($_REQUEST['txtDateTo']) && $_REQUEST['txtDateTo'] != "") || (isset($_COOKIE['cook_txtdateto']) && $_COOKIE['cook_txtdateto'] != "")) { $txtDateTo = (form_text("txtDateTo") != "")?form_text("txtDateTo"):$_COOKIE['cook_txtdateto']; $txtDateTo = stripslashes($txtDateTo);}
	if((isset($_REQUEST['txtneedsleep']) && $_REQUEST['txtneedsleep'] != "") || (isset($_COOKIE['cook_txtneedsleep']) && $_COOKIE['cook_txtneedsleep'] != "")) { $txtneedsleep = (form_text("txtneedsleep") != "")?form_text("txtneedsleep"):$_COOKIE['cook_txtneedsleep']; $txtneedsleep = stripslashes($txtneedsleep); }
	*/

	if(isset($property_id) && $property_id !=""){
		$propertyInfo				= $propertyObj->fun_getPropertyInfo($property_id);
		//print_r($propertyInfo);
		$propertyMImgInfo			= $propertyObj->fun_getPropertyMainThumb($property_id);
//		print_r($propertyMImgInfo);
		$propMImg 					= $propertyMImgInfo[0]['photo_url'];
		$propMImgCap 				= $propertyMImgInfo[0]['photo_caption'];

		$propertyFeatureInfo		= $propertyObj->fun_getPropertyFeatureNameArr($property_id);
		//print_r($propertyFeatureInfo);
	
		if(count($propertyInfo) > 0) {
			$property_name 			= ucfirst($propertyInfo['property_name']);
			$property_title 		= ucfirst($propertyInfo['property_title']);
			$property_type  		= $propertyInfo['property_type'];
			$catering_type			= $propertyInfo['catering_type'];
			$property_summary		= ucfirst($propertyInfo['property_summary']);
			$property_description	= ucfirst($propertyInfo['description']);
			$rating					= $propertyInfo['rating'];
			$friendly_link			= $propertyInfo['friendly_link'];
	
			$total_beds				= $propertyInfo['total_beds'];
			$ensuite_beds			= $propertyInfo['ensuite_beds'];
			$scomfort_beds			= $propertyInfo['scomfort_beds'];
			$double_beds			= $propertyInfo['double_beds'];
			$single_beds			= $propertyInfo['single_beds'];
			$sofa_beds				= $propertyInfo['sofa_beds'];
			$bed_notes				= ucfirst($propertyInfo['bed_notes']);
	
			$total_bathrooms		= $propertyInfo['total_bathrooms'];
			$ensuite_baths			= $propertyInfo['ensuite_baths'];
			$shower_baths			= $propertyInfo['shower_baths'];
			$baths					= $propertyInfo['baths'];
			$toilets				= $propertyInfo['toilets'];
			$bath_notes				= ucfirst($propertyInfo['bath_notes']);
	
			$feature_note			= ucfirst($propertyInfo['feature_note']);
			$requirement_note		= ucfirst($propertyInfo['requirement_note']);
			$area_notes				= ucfirst($propertyInfo['area_notes']);
			$price_notes			= ucfirst($propertyInfo['price_notes']);
			$property_type_name		= ucfirst($propertyInfo['property_type_name']);
			$property_catering_name	= ucfirst($propertyInfo['property_catering_name']);
			$created_on				= date('F j, Y', $propertyInfo['created_on']);
			$updated_on				= date('F j, Y', $propertyInfo['updated_on']);
			$property_link 			= SITE_URL."vacation-rentals/".strtolower($friendly_link);

			$propLocInfoArr = $propertyObj->fun_getPropertyLocInfoArr($property_id);
			$strLoc = "";
			if($propLocInfoArr['area_name'] !=""){
				$strLoc .= ucwords($propLocInfoArr['area_name'])." > ";
			}
			if($propLocInfoArr['region_name'] !=""){
				$strLoc .= ucwords($propLocInfoArr['region_name'])." > ";
			}
			if($propLocInfoArr['subregion_name'] !=""){
				$strLoc .= ucwords($propLocInfoArr['subregion_name'])." > ";
			}
			if($propLocInfoArr['location_name'] !=""){
				$strLoc .= ucwords($propLocInfoArr['location_name'])." > ";
			}
			$strLoc .= ucfirst($propertyObj->fun_getPropertyName($property_id))." ref:".fill_zero_left($property_id, "0", (6-strlen($property_id)));


			$requirementHTML 		= $propertyObj->fun_createPropertySRequirements4PropertyPrint($property_id);
			$featureHTML 			= $propertyObj->fun_createPropertyFacilities4PropertyPrint($property_id);

			$propertyPricesArr 		= $propertyObj->fun_getPropertyPricesArr($property_id);
			$currencyRateArr		= $propertyObj->fun_findPropertyCurrencyRate();

			$property_currency_symbol	= $propertyObj->fun_findPropertyCurrencySymbol($property_id);
			$property_currency_id		= $propertyObj->fun_findPropertyCurrencyCode($property_id);
		
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
					$property_currency_code = "USD";
			}
		
			$currency_symbol	= ($users_currency_symbol == "")?$property_currency_symbol:$users_currency_symbol;
			$currency_code		= ($users_currency_code == "")?$property_currency_code:$users_currency_code;

			$strPriceHTML = "";
			if(count($propertyPricesArr) > 0){
				$strPriceHTML .= "<tr>";
				$strPriceHTML .= "<td>";
				$strPriceHTML .= "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
				$strPriceHTML .= "<tr><td><strong>Prices</strong></td></tr>";
				$strPriceHTML .= "<tr><td>&nbsp;</td></tr>";
				$strPriceHTML .= "<tr>";
				$strPriceHTML .= "<td>";
				$strPriceHTML .= "<table width=\"100%\" border=\"1\" cellpadding=\"4\" cellspacing=\"0\" bordercolor=\"#000000\">";
				$strPriceHTML .= "<tr>";
				$strPriceHTML .= "<th valign=\"top\" bgcolor=\"#bdc0bf\">Date from</th>";
				$strPriceHTML .= "<th valign=\"top\" bgcolor=\"#bdc0bf\">Date to</th>";
				$strPriceHTML .= "<th valign=\"top\" bgcolor=\"#bdc0bf\">Per week</th>";
//				$strPriceHTML .= "<th valign=\"top\" bgcolor=\"#bdc0bf\">Per midweek<br />night</th>";
//				$strPriceHTML .= "<th valign=\"top\" bgcolor=\"#bdc0bf\">Per weekend<br />night</th>";
				$strPriceHTML .= "<th valign=\"top\" bgcolor=\"#bdc0bf\">Minimum stay</th>";
				$strPriceHTML .= "</tr>";
	
				$showSpecialOfferIcon = false;
				for($i=0; $i<count($propertyPricesArr); $i++){
					$property_price_id		= $propertyPricesArr[$i]['id'];
					$dateFrom 				= date('F j, Y', strtotime($propertyPricesArr[$i]['date_from']));
					$dateTo 				= date('F j, Y', strtotime($propertyPricesArr[$i]['date_to']));
					$minStay 				= $propertyPricesArr[$i]['min_stay'];
					$stayType 				= $propertyPricesArr[$i]['min_stay_type'];
					if((int)$minStay > 1) {
						$strMinStay			= $propertyPricesArr[$i]['min_stay'] ." ".(($stayType == "w") ? "Weeks" : "Nights");
					} else if((int)$minStay == 1){
						$strMinStay			= $propertyPricesArr[$i]['min_stay'] ." ".(($stayType == "w") ? "Week" : "Night");
					} else {
						$strMinStay			= "--";
					}
					$specialOffer 			= $propertyPricesArr[$i]['special_offer'];
					if($specialOffer > 0) { 
						$showSpecialOfferIcon = true;
						$tdStyle = "bgcolor=\"#EAEAEA\"";
					} else {
						$tdStyle = "";
					}
					if($propertyPricesArr[$i]['per_week_price'] > 0) {
						$strPerWeekPrice 			= "".$currency_symbol."".number_format($propertyObj->fun_getConvertedCurrency($property_currency_id, $users_currency_id, $propertyPricesArr[$i]['per_week_price']))."";
					} else {
						$strPerWeekPrice 			= "na";
					}
					if($propertyPricesArr[$i]['per_night_midweek_price'] > 0) {
						$strPerNightMidweekPrice	= "".$currency_symbol."".number_format($propertyObj->fun_getConvertedCurrency($property_currency_id, $users_currency_id, $propertyPricesArr[$i]['per_night_midweek_price']))."";
					} else {
						$strPerNightMidweekPrice	= "na";
					}
					if($propertyPricesArr[$i]['per_night_weekend_price'] > 0) {
						$strPerNightWeekendPrice	= "".$currency_symbol."".number_format($propertyObj->fun_getConvertedCurrency($property_currency_id, $users_currency_id, $propertyPricesArr[$i]['per_night_weekend_price']))."";
					} else {
						$strPerNightWeekendPrice	= "na";
					}
					$strPriceHTML .= "<tr>";
					$strPriceHTML .= "<td align=\"center\" valign=\"top\" ".$tdStyle.">".$dateFrom."</td>";
					$strPriceHTML .= "<td align=\"center\" valign=\"top\" ".$tdStyle.">".$dateTo."</td>";
					$strPriceHTML .= "<td align=\"center\" valign=\"top\" ".$tdStyle.">".$strPerWeekPrice."</td>";
//					$strPriceHTML .= "<td align=\"center\" valign=\"top\" ".$tdStyle.">".$strPerNightMidweekPrice."</td>";
//					$strPriceHTML .= "<td align=\"center\" valign=\"top\" ".$tdStyle.">".$strPerNightWeekendPrice."</td>";
					$strPriceHTML .= "<td align=\"center\" valign=\"top\" ".$tdStyle.">".$strMinStay."</td>";
					$strPriceHTML .= "</tr>";
				}
				$strPriceHTML .= "</table>";
				$strPriceHTML .= "</td>";
				$strPriceHTML .= "</tr>";
				$strPriceHTML .= "<tr><td>&nbsp;</td></tr>";
				$strPriceHTML .= "<tr>";
				$strPriceHTML .= "<td>";
				$strPriceHTML .= "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
				$strPriceHTML .= "<tr>";
				$strPriceHTML .= "<td style=\"background:#eaeaea; border:1px #000000 solid; height:25px; width:50px;\">&nbsp;</td>";
				$strPriceHTML .= "<td style=\"padding-left:20px;\">Indicates special deal</td>";
				$strPriceHTML .= "</tr>";
				$strPriceHTML .= "</table>";
				$strPriceHTML .= "</td>";
				$strPriceHTML .= "</tr>";
				$strPriceHTML .= "<tr>";
				$strPriceHTML .= "<td>&nbsp;</td>";
				$strPriceHTML .= "</tr>";
				$strPriceHTML .= "<tr><td><strong>Notes</strong></td></tr>";
				$strPriceHTML .= "<tr><td>&nbsp;</td></tr>";
				$strPriceHTML .= "<tr><td><div align=\"justify\">".$price_notes."</div></td></tr>";
				$strPriceHTML .= "<tr><td>&nbsp;</td></tr>";
				$strPriceHTML .= "</table>";
				$strPriceHTML .= "</td>";
				$strPriceHTML .= "</tr>";
			}
		}
	
		/*
		* Sleeps 12   |   5 bedrooms   |   3 bathrooms : start here
		*/
		
		$strPropSBB			= "";
		if($total_beds !=""){
			$strPropSBB		.= "<span class=\"green\">".(($total_beds > 1)?$total_beds." Bedrooms":$total_beds." Bedroom")."</span>&nbsp;|&nbsp; ";
		} else {
			$strPropSBB		.= "<span class=\"green\">0 Bedroom</span>&nbsp;|&nbsp; ";
		}

		if($scomfort_beds !=""){
			$strPropSBB		.= "<span class=\"green\">Sleeps ".$scomfort_beds."</span>&nbsp;|&nbsp; ";
		} else {
			$strPropSBB		.= "<span class=\"green\">Sleep 0</span>&nbsp;|&nbsp; ";
		}
	
		if($total_bathrooms !=""){
			$strPropSBB		.= "<span class=\"green\">".(($total_bathrooms > 1)?$total_bathrooms." Bathrooms":$total_bathrooms." Bathroom")."</span>";
		} else {
			$strPropSBB		.= "<span class=\"green\">0 Bathroom</span>";
		}
		/*
		* Sleeps 12   |   5 bedrooms   |   3 bathrooms : end here
		*/
	
		/*
		* R1800 - R3000 per week : start here
		*/
/*
		$propPriceInfoArr 		= $propertyObj->fun_getPropertyPriceMinMaxInfoArr($property_id);
		if(count($propPriceInfoArr) > 0){
			$currency_symbol = $propertyObj->fun_findPropertyCurrencySymbol($property_id);
			$min_price 		= number_format($propPriceInfoArr['min_price']);
			$max_price 		= number_format($propPriceInfoArr['max_price']);
			$strPropPriceAvg = $currency_symbol.$min_price."-".$currency_symbol.$max_price." per week";
	
		} else {
			$strPropPriceAvg 		= "";
		}
*/
		/*
		* R1800 - R3000 per week : end here
		*/

		/*
		* From R3,000 per week or R300 per night
		*/
		$propPriceFromInfoArr 		= $propertyObj->fun_getPropertyPriceFromInfoArr($property_id);
		if(is_array($propPriceFromInfoArr) && (count($propPriceFromInfoArr) > 0)){
			/*
			if($propPriceFromInfoArr['min_per_night_price'] > 0 && $propPriceFromInfoArr['min_per_week_price'] > 0) {
				$min_per_night_price 		= number_format($propPriceFromInfoArr['min_per_night_price']);
				$min_per_week_price 		= number_format($propPriceFromInfoArr['min_per_week_price']);
				$strPropPriceAvg 			= "From ".$currency_symbol.$min_per_week_price." per week ";
			} else if($propPriceFromInfoArr['min_per_night_price'] > 0) {
				$min_per_night_price 		= number_format($propPriceFromInfoArr['min_per_night_price']);
				$strPropPriceAvg 			= "From ".$currency_symbol.$min_per_night_price." per night";
			} else if($propPriceFromInfoArr['min_per_week_price'] > 0) {
				$min_per_week_price 		= number_format($propPriceFromInfoArr['min_per_week_price']);
				$strPropPriceAvg 			= "From ".$currency_symbol.$min_per_week_price." per week";
			}
			*/

            if($propPriceFromInfoArr['min_per_week_price'] > 0) {
				$min_per_week_price 		= number_format(($propPriceFromInfoArr['min_per_week_price']/$currencyRateArr[$property_currency_code])*$currencyRateArr[$currency_code]);
				$strPropPriceAvg 			= "From ".$currency_symbol." ".$min_per_week_price." per week";
			}
		} else {


			$strPropPriceAvg 		= "";
		}
		/*
		* From R3,000 per week or R300 per night
		*/
	
		/*
		* Property type: Luxury Villa : start here
		*/
		$strPropType	= "";
		if($property_type_name !=""){
			$strPropType.= "Property type: ".ucwords($property_type_name);
		}
		/*
		* Property type: Luxury Villa : end here
		*/
		
		/*
		* Catering type: Self-catering : start here
		*/
		$strPropCaterType	= "";
		if($property_catering_name !=""){
			$strPropCaterType.= "Catering type: ".ucwords($property_catering_name);
		}
		/*
		* Catering type: Self-catering : end here
		*/

		/*
		* Property type : Catering type: start here
		*/
		$strPropTypeCaterType	= "";
		if($property_type_name !=""){
			$strPropTypeCaterType.= ucwords($property_type_name);
		}
		if($property_catering_name !=""){
			$strPropTypeCaterType.= " - ".ucwords($property_catering_name);
		}
		/*
		* Property type : Catering type: end here
		*/
	
		/*
		* Property review : start here
		*/
		$reviewArr 		= $propertyObj->fun_getPropertyReviewsArr4PropertyPreview($property_id, "2");
		if(is_array($reviewArr) && count($reviewArr) > 0) {
			$total_reviews 	= count($propertyReviewsArr);
		} else {
			$total_reviews 	= "0";
		}
		$total_reviews	= count($reviewArr);
/*
		$propertyReviewsArr 		= $propertyObj->fun_getPropertyReviewsArr($property_id);
		if(is_array($propertyReviewsArr) && count($propertyReviewsArr) > 0) {
			$totalCustomerReview 	= count($propertyReviewsArr);
		} else {
			$totalCustomerReview 	= "0";
		}
*/
		/*
		* Property review : end here
		*/

		/*
		* Property favourite : start here
		*/
		if(isset($user_id) && $user_id != "") {
			$propFavId				= $propertyObj->fun_checkFavourite($user_id, $property_id);
		}
		/*
		* Property favourite : end here
		*/

		/*
		* Property New listing: start here
		*/
		$newListing 				= $propertyObj->fun_checkPropertyIsNewListing($property_id);
		/*
		* Property New listing: end here
		*/

	
	// User property preview vote submit : start here 
		if($_POST['securityKey']==md5(REVIEWS)){		
			if(($_POST['txtReviewId'] != '') && ($_POST['txtVoteType'] != '') && ($_SESSION['ses_user_id'] != '')){
				$propertyObj->fun_addPropertyReviewVote($_POST['txtReviewId'], $_POST['txtVoteType'], $_SESSION['ses_user_id']);
			}
		}
	// User property preview vote submit : end here 
	} else {
		$referpage = SITE_URL;
		redirectURL($referpage);
	}
	$seo_title 				= ($seoArr['seo_title'] != "")?$seoArr['seo_title']:ucfirst($property_title);
	$seo_description		= ($seoArr['seo_description'] != "")?$seoArr['seo_description']:$property_title;
	$seo_keywords 			= ($seoArr['seo_keywords'] != "")?$seoArr['seo_keywords']:"rentownersvillas.com Vacation Rentals, Book ".$property_name.", ".ucwords($property_type_name)." - ".ucwords($property_catering_name)." Rentals, ".ucwords($propLocInfoArr['area_name'])." ".ucwords($property_type_name)." Rental ".$strPropPriceAvg;
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
<link rel="stylesheet" type="text/css" href="<?php echo SITE_CSS_INCLUDES_PATH;?>common.css" />
<!--[if IE 6]><link rel="stylesheet" type="text/css" href="<?php echo SITE_CSS_INCLUDES_PATH;?>ie6.css" /><![endif]-->
<!--[if IE 7]><link rel="stylesheet" type="text/css" href="<?php echo SITE_CSS_INCLUDES_PATH;?>ie7.css" /><![endif]-->
<!--[if IE 8]><link rel="stylesheet" type="text/css" href="<?php echo SITE_CSS_INCLUDES_PATH;?>ie8.css" /><![endif]-->
<link href="<?php echo SITE_CSS_INCLUDES_PATH;?>featuredcontentglider.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>common.js"></script>
<script type="text/javascript" language="JavaScript" src="<?php echo SITE_JS_INCLUDES_PATH;?>dargPop.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>dhtmlwindow.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>pop-up.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>jquery-1.2.2.pack.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>featuredcontentglider.js">
/***********************************************
* Featured Content Glider script- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* Visit http://www.dynamicDrive.com for hundreds of DHTML scripts
* This notice must stay intact for legal use
***********************************************/
</script>
<script type="text/javascript">
	var req = ajaxFunction();
	var x, y;
	function show_coords(event) {
		x=event.clientX;
		y=event.clientY;
		x = x-160;
		y = y+4;
	//	alert(x);alert(y);
	}

	function toggleLayer( whichLayer ) {
		var elem, vis;
		if( document.getElementById ) // this is the way the standards work
			elem = document.getElementById( whichLayer );
		else if( document.all ) // this is the way old msie versions work
			elem = document.all[whichLayer];
		else if( document.layers ) // this is the way nn4 works
			elem = document.layers[whichLayer];
		vis = elem.style;
		// if the style.display value is blank we try to figure it out here
		if(vis.display==''&&elem.offsetWidth!=undefined&&elem.offsetHeight!=undefined)
			vis.display = (elem.offsetWidth!=0&&elem.offsetHeight!=0)?'block':'none';
			vis.display = (vis.display==''||vis.display=='block')?'none':'block';
	}

	function showSection(str){
		for(var i=1; i<=8; i++){
			if(i==str){
				if(document.getElementById("sectionId"+i)) {
					document.getElementById("sectionId"+i).style.display = "block";
				}
			} else {
				if(document.getElementById("sectionId"+i)) {
					document.getElementById("sectionId"+i).style.display = "none";
				}
			}
		}
	}

	function removeFavourite(strPropId, strUserId) {
		req.onreadystatechange = handleResponse;
		req.open('get', '<?php echo SITE_URL;?>favouriteaddXml.php?property_id='+strPropId+'&user_id='+strUserId+'&act=del'); 
		req.send(null);   
	}

	function addFavourite(strPropId, strUserId) {
		req.onreadystatechange = handleResponse;
		req.open('get', '<?php echo SITE_URL;?>favouriteaddXml.php?property_id='+strPropId+'&user_id='+strUserId+'&act=add'); 
		req.send(null);   
	}

	function handleResponse() {
		if(req.readyState == 4) {
			var response=req.responseText;
			xmlDoc=req.responseXML;
			var root = xmlDoc.getElementsByTagName('favourites')[0];
			if(root != null) {
				var items = root.getElementsByTagName("favourite");
                var item = items[0];
                var favouritestatus = item.getElementsByTagName("status")[0].firstChild.nodeValue;
                if(favouritestatus == "Favourite deleted.") {
                	var strHtml = '<?php echo "<a href=\"javascript:addFavourite(\'".$property_id."\', \'".$user_id."\');\" class=\"faviLink\">Add to favourites</a>"; ?>';
					//document.getElementById("showAddFavouritePanelId").style.display = "block";
					document.getElementById("showAddFavouriteLinkId").style.display = "block";
					document.getElementById("showRemoveFavouriteLinkId").style.display = "none";
                } else if(favouritestatus == "Favourite added.") {
                	var strHtml = '<?php echo "<a href=\"javascript:removeFavourite(\'".$property_id."\', \'".$user_id."\');\" class=\"faviLink\">Remove favourite</a>"; ?>';
					//document.getElementById("showAddFavouritePanelId").style.display = "none";
					document.getElementById("showAddFavouriteLinkId").style.display = "none";
					document.getElementById("showRemoveFavouriteLinkId").style.display = "block";
                }
				//document.getElementById("showFavouriteLinkId").innerHTML = strHtml;
			}
		}
	}
</script>
<script language="javascript">
//ASHOK KUMAR 18, jun 2008
//Printing an Image part only of a Web Page
function makepage() {
  // We break the closing script tag in half to prevent
  // the HTML parser from seeing it as a part of
  // the *main* page.

var property_name = '<?php echo ucfirst(str_replace("'", "\'", $property_name)); ?>';
var property_title = '<?php echo ucfirst(str_replace("'", "\'", $property_title)); ?>';
var property_location = '<?php echo $strLoc; ?>';
var property_heading = property_name + ": " + property_title;
var property_propsbb = '<?php echo $strPropSBB; ?>';
var property_type_name = '<?php echo $property_type_name; ?>';
var property_catering_name = '<?php echo $property_catering_name; ?>';
var property_sbb = property_propsbb + " &nbsp;|&nbsp; " + property_type_name + " &nbsp;-&nbsp; " + property_catering_name;

var property_type = '<?php echo $property_type; ?>';
var catering_type = '<?php echo $catering_type; ?>';
var mainimg = '<?php echo PROPERTY_IMAGES_LARGE480x360_PATH.$propMImg; ?>';
var mainimgcap = '<?php echo $propMImgCap; ?>';

var total_beds = '<?php echo $total_beds; ?>';
var ensuite_beds = '<?php echo $ensuite_beds; ?>';
var scomfort_beds = '<?php echo $scomfort_beds; ?>';
var double_beds = '<?php echo $double_beds; ?>';
var single_beds = '<?php echo $single_beds; ?>';
var sofa_beds = '<?php echo $sofa_beds; ?>';

var total_bathrooms = '<?php echo $total_bathrooms; ?>';
var ensuite_baths = '<?php echo $ensuite_baths; ?>';
var shower_baths = '<?php echo $shower_baths; ?>';
var baths = '<?php echo $baths; ?>';
var toilets = '<?php echo $toilets; ?>';
var property_summary = '<?php echo ucfirst(str_replace("'", "\'", str_replace("\r\n", "", $property_summary))); ?>';
var bed_notes = '<?php echo ucfirst(str_replace("'", "\'", str_replace("\r\n", "", $bed_notes))); ?>';
var bath_notes = '<?php echo ucfirst(str_replace("'", "\'", str_replace("\r\n", "", $bath_notes))); ?>';

var featureHTML = '<?php echo str_replace("'", "\'", str_replace("\r\n", "", $featureHTML)); ?>';
var requirementHTML = '<?php echo str_replace("'", "\'", str_replace("\r\n", "", $requirementHTML)); ?>';
var strPriceHTML = '<?php echo str_replace("'", "\'", str_replace("\r\n", "", $strPriceHTML)); ?>';

var area_notes = '<?php echo ucfirst(str_replace("'", "\'", str_replace("\r\n", "", $area_notes))); ?>';

var content = "";
content = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
content += "<html xmlns=\"http://www.w3.org/1999/xhtml\">";
content += "<head>";
content += "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />";
content += "<title><?php echo $_SERVER["SERVER_NAME"];?> Property</title>";
content += "<script>\n";
content += "function step1() {\n";
content += "setTimeout('step2()', 10);\n}\n";
content += "function step2() {\n";
content += "window.print();\n";
content += "window.close();\n";
content += "}\n";
content += "</scr" + "ipt>\n";
content += "<style type=\"text/css\">";
content += "body {margin: 0px;background:#FFFFFF;padding: 0px;font-family: Arial, Helvetica, sans-serif;text-decoration: none;font-size: 12px;}";
content += "h1{font-size:16px;font-weight:bold;margin:0px;padding:0px;}";
content += "</style>";
content += "</head>";
content += "<body onLoad='step1()'>";
content += "<table width=\"670\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">";
content += "<tr><td><img src=\"<?php echo SITE_IMAGES;?>print-property-images/header.jpg\" alt=\"One Location\" width=\"670\" height=\"63\" /></td></tr>";
content += "<tr><td>&nbsp;</td></tr>";
content += "<tr><td><h1>"+property_heading+"</h1></td></tr>";
//content += "<tr><td>&nbsp;</td></tr>";
content += "<tr><td>"+property_location+"</td></tr>";
//content += "<tr><td>Franschoek, florida,  (Reference: 000123)</td></tr>";
//content += "<tr><td>&nbsp;</td></tr>";
content += "<tr><td>"+property_sbb+"</td></tr>";
content += "<tr><td>&nbsp;</td></tr>";
content += "<tr><td align=\"center\"><img src=\""+mainimg+"\" alt=\""+mainimgcap+"\" width=\"600\" height=\"450\" /></td></tr>";
content += "<tr><td>&nbsp;</td></tr>";
content += "<tr><td><h1>Property summary</h1></td></tr>";
content += "<tr><td>&nbsp;</td></tr>";
content += "<tr><td><div align=\"justify\">"+property_summary+"</div></td></tr>";
content += "<tr><td>&nbsp;</td></tr>";
content += "<tr><td>&nbsp;</td></tr>";
content += "<tr><td><h1>Accommodation and facilities</h1></td></tr>";
content += "<tr><td>&nbsp;</td></tr>";
content += "<tr>";
content += "<td>";
content += "<table width=\"300\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
content += "<tr>";
content += "<td><strong>Bedrooms</strong></td>";
content += "<td>&nbsp;</td>";
content += "</tr>";
content += "<tr><td>Number of bedrooms</td><td>"+total_beds+"</td></tr>";
content += "<tr><td>How many have en-suite?</td><td>"+ensuite_beds+"</td></tr>";
content += "<tr><td>Property can comfortably sleep</td><td>"+scomfort_beds+"</td></tr>";
content += "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
content += "<tr><td>Double beds</td><td>"+double_beds+"</td></tr>";
content += "<tr><td>Single beds</td><td>"+single_beds+"</td></tr>";
content += "<tr><td>Sofa beds</td><td>"+sofa_beds+"</td></tr>";
content += "</table>";
content += "</td>";
content += "</tr>";
content += "<tr><td>&nbsp;</td></tr>";
content += "<tr><td><div align=\"justify\">"+bed_notes+"</div></td></tr>";
content += "<tr><td>&nbsp;</td></tr>";
content += "<tr>";
content += "<td>";
content += "<table width=\"300\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
content += "<tr><td><strong>Bathrooms</strong></td><td>&nbsp;</td></tr>";
content += "<tr><td>Number of Bathrooms</td><td>"+total_bathrooms+"</td></tr>";
content += "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
content += "<tr><td>En-suite</td><td>"+ensuite_baths+"</td></tr>";
content += "<tr><td>Baths</td><td>"+baths+"</td></tr>";
content += "<tr><td>Toilets</td><td>"+toilets+"</td></tr>";
content += "</table>";
content += "</td>";
content += "</tr>";
content += "<tr><td>&nbsp;</td></tr>";
content += "<tr>";
content += "<td><div align=\"justify\">"+bath_notes+"</div></td>";
content += "</tr>";
content += "<tr>";
content += "<td>&nbsp;</td>";
content += "</tr>";

content += "<tr>";
content += "<td>";
content += featureHTML;
content += "</td>";
content += "</tr>";
content += "<tr><td>&nbsp;</td></tr>";
content += "<tr>";
content += "<td>";
content += requirementHTML;
content += "</td>";
content += "</tr>";
content += "<tr><td>&nbsp;</td></tr>";
content += "<tr>";
content += "<td>";
content += strPriceHTML;
content += "</td>";
content += "</tr>";
content += "<tr><td>&nbsp;</td></tr>";
content += "</table>";
content += "</body>";
content += "</html>";
return content;
}

function printme() {
  link = "about:blank";
  var pw = window.open(link, "_new");
  pw.document.open();
//  setTimeout("myfunction()", 10);
  pw.document.write(makepage());
  pw.document.close();
}
</script>
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
        <div id="wrapper_property">
            <?php require_once(SITE_INCLUDES_PATH.'holidaypropertypreview.php');?>
        </div>
    </div>
</div>
<!-- Main Wrapper End Here -->
<!-- Footer Include Starts Here -->
<div id="footer">
    <?php require_once(SITE_INCLUDES_PATH.'footer.php'); ?>
</div>
<!-- Footer Include End Here -->
<script>
	$(document).ready(function(){
		var query = location.href.split('#');
		var anchorPart = query[1];
		if(anchorPart == "showSectionReview") {
			showSection(7);
		}
		//alert(anchorPart);
	});
</script>
</body>
</html>
