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

	$usersObj 		= new Users();
	$propertyObj 	= new Property();
	$locationObj 	= new Location();
	
	if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !=""){
		$user_id = $_SESSION['ses_user_id'];
	} else {
		$user_id = "";
	}

	$search_query = "";
	$page	 = form_int("page",1)+0;
	$sortby  = form_int("sortby",0,0,5);
	$sortdir = form_int("sortdir",0,0,1);
	if (form_isset("reverse")) {
		$sortdir = 1-$sortdir;
	}
	
	switch($sortdir) {
		case 0 : $orderDir = "ASC"; break;
		case 1 : $orderDir = "DESC"; break;
	}

	switch($sortby) {
		case 0: $sortField  = "A.property_id"; break;
		case 1: $sortField  = "A.property_id"; break;
		default: $sortField = "A.property_id"; break;
	}

	// Read search fields from submitted form
	if(isset($_REQUEST['destinations']) && $_REQUEST['destinations'] != "") { $destinations = form_text("destinations"); $destinations = stripslashes($destinations); }
	if(isset($destinations) && $destinations !="") {
		$seo_friendly 		= SITE_URL."latedeals"; // for seo friendly urls
		$seo_friendly 		.= "/in.".$destinations;
		$destinations		= str_replace("-", " ", $destinations);
		$destinationArr 	= $locationObj->fun_getDestinationInfo($destinations);
		if(isset($destinationArr['area_id']) && $destinationArr['area_id'] != "" && $destinationArr['area_id'] != "0") { $txtPropertyArea = $destinationArr['area_id']; $txtPropertyArea = stripslashes($txtPropertyArea);}
		if(isset($destinationArr['pregion_id']) && $destinationArr['pregion_id'] != "" && $destinationArr['pregion_id'] != "0") { $txtPropertyRegion = $destinationArr['pregion_id']; $txtPropertyRegion = stripslashes($txtPropertyRegion);}
		if(isset($destinationArr['region_id']) && $destinationArr['region_id'] != "" && $destinationArr['region_id'] != "0") { $txtPropertySubRegion = $destinationArr['region_id']; $txtPropertySubRegion = stripslashes($txtPropertySubRegion);}
		if(isset($destinationArr['location_id']) && $destinationArr['location_id'] != "" && $destinationArr['location_id'] != "0") { $txtPropertyLocation = $destinationArr['location_id']; $txtPropertyLocation = stripslashes($txtPropertyLocation);}
	} else {
		$seo_friendly 		= SITE_URL."latedeals"; // for seo friendly urls
//		$seo_friendly 		.= "/";
		if(isset($_REQUEST['txtPropertyArea']) && $_REQUEST['txtPropertyArea'] != "" && $_REQUEST['txtPropertyArea'] != "0") { $txtPropertyArea = form_text("txtPropertyArea"); $txtPropertyArea = stripslashes($txtPropertyArea);}
		if(isset($_REQUEST['txtPropertyRegion']) && $_REQUEST['txtPropertyRegion'] != "" && $_REQUEST['txtPropertyRegion'] != "0") { $txtPropertyRegion = form_text("txtPropertyRegion"); $txtPropertyRegion = stripslashes($txtPropertyRegion);}
		if(isset($_REQUEST['txtPropertySubRegion']) && $_REQUEST['txtPropertySubRegion'] != "" && $_REQUEST['txtPropertySubRegion'] != "0") { $txtPropertySubRegion = form_text("txtPropertySubRegion"); $txtPropertySubRegion = stripslashes($txtPropertySubRegion);}
		if(isset($_REQUEST['txtPropertyLocation']) && $_REQUEST['txtPropertyLocation'] != "" && $_REQUEST['txtPropertyLocation'] != "0") { $txtPropertyLocation = form_text("txtPropertyLocation"); $txtPropertyLocation = stripslashes($txtPropertyLocation);}

		if(isset($txtPropertyArea) && $txtPropertyArea != "") { $search_query .= "&txtPropertyArea=" . html_escapeURL($txtPropertyArea); }
		if(isset($txtPropertyRegion) && $txtPropertyRegion != "") { $search_query .= "&txtPropertyRegion=" . html_escapeURL($txtPropertyRegion); }
		if(isset($txtPropertySubRegion) && $txtPropertySubRegion != "") { $search_query .= "&txtPropertySubRegion=" . html_escapeURL($txtPropertySubRegion); }
		if(isset($txtPropertyLocation) && $txtPropertyLocation != "") { $search_query .= "&txtPropertyLocation=" . html_escapeURL($txtPropertyLocation); }
	}

	if(isset($_REQUEST['txtExactNights']) && $_REQUEST['txtExactNights'] != "") { $txtExactNights = form_text("txtExactNights"); $txtExactNights = stripslashes($txtExactNights);}

	if(isset($txtExactNights) && $txtExactNights == "1") {
		if(isset($txtExactNights) && $txtExactNights != "") { $search_query .= "&txtExactNights=" . html_escapeURL($txtExactNights); }
		if(isset($_REQUEST['txtDayFrom0']) && $_REQUEST['txtDayFrom0'] != "") { $txtDayFrom0 = form_text("txtDayFrom0"); $txtDayFrom0 = stripslashes($txtDayFrom0);}
		if(isset($_REQUEST['txtMonthFrom0']) && $_REQUEST['txtMonthFrom0'] != "") { $txtMonthFrom0 = form_text("txtMonthFrom0"); $txtMonthFrom0 = stripslashes($txtMonthFrom0);}
		if(isset($_REQUEST['txtYearFrom0']) && $_REQUEST['txtYearFrom0'] != "") { $txtYearFrom0 = form_text("txtYearFrom0"); $txtYearFrom0 = stripslashes($txtYearFrom0);}
		if(isset($_REQUEST['txtDayTo0']) && $_REQUEST['txtDayTo0'] != "") { $txtDayTo0 = form_text("txtDayTo0"); $txtDayTo0 = stripslashes($txtDayTo0);}
		if(isset($_REQUEST['txtMonthTo0']) && $_REQUEST['txtMonthTo0'] != "") { $txtMonthTo0 = form_text("txtMonthTo0"); $txtMonthTo0 = stripslashes($txtMonthTo0);}
		if(isset($_REQUEST['txtYearTo0']) && $_REQUEST['txtYearTo0'] != "") { $txtYearTo0 = form_text("txtYearTo0"); $txtYearTo0 = stripslashes($txtYearTo0);}
		if($txtMonthFrom0 != "" && $txtDayFrom0 != "" && $txtYearFrom0 != "") {
			$txtFromUnixTime 		= mktime(0, 0, 0, (int)$txtMonthFrom0, (int)$txtDayFrom0, (int)$txtYearFrom0);
			if(isset($txtDayFrom0) && $txtDayFrom0 != "") { $search_query .= "&txtDayFrom0=" . html_escapeURL($txtDayFrom0); }
			if(isset($txtMonthFrom0) && $txtMonthFrom0 != "") { $search_query .= "&txtMonthFrom0=" . html_escapeURL($txtMonthFrom0); }
			if(isset($txtYearFrom0) && $txtYearFrom0 != "") { $search_query .= "&txtYearFrom0=" . html_escapeURL($txtYearFrom0); }
		}
		if($txtMonthTo0 != "" && $txtDayTo0 != "" && $txtYearTo0 != "") {
			$txtToUnixTime	 		= mktime(0, 0, 0, (int)$txtMonthTo0, (int)$txtDayTo0, (int)$txtYearTo0);
			if(isset($txtDayTo0) && $txtDayTo0 != "") { $search_query .= "&txtDayTo0=" . html_escapeURL($txtDayTo0); }
			if(isset($txtMonthTo0) && $txtMonthTo0 != "") { $search_query .= "&txtMonthTo0=" . html_escapeURL($txtMonthTo0); }
			if(isset($txtYearTo0) && $txtYearTo0 != "") { $search_query .= "&txtYearTo0=" . html_escapeURL($txtYearTo0); }
		}
	}

	$strQueryParameter		= " ORDER BY " . $sortField . " " . $orderDir. " LIMIT ".(int)(($page-1)*(int)GLOBAL_RECORDS_PER_PAGE).", ".GLOBAL_RECORDS_PER_PAGE;
	$strQueryCountParameter	= " ORDER BY " . $sortField . " " . $orderDir;

	$rsQuery				= $propertyObj->fun_getPropertyDeals4HolidayArr($txtPropertyArea, $txtPropertyRegion, $txtPropertySubRegion, $txtPropertyLocation, $txtFromUnixTime, $txtToUnixTime, $strQueryParameter);
	$rsQueryCount			= $propertyObj->fun_getPropertyDeals4HolidayArr($txtPropertyArea, $txtPropertyRegion, $txtPropertySubRegion, $txtPropertyLocation, $txtFromUnixTime, $txtToUnixTime, $strQueryCountParameter);

	$sort_query   = "sortby=" . html_escapeURL($sortby) ."&sortdir=" . html_escapeURL($sortdir);

	if($dbObj->getRecordCount($rsQueryCount) > 0) {
		$propDealsListArr 		= $dbObj->fetchAssoc($rsQuery);
		// Determine the pagination
		$return_query 		= $search_query."&".$sort_query."&page=$page";
		//GLOBAL_RECORDS_PER_PAGE
//		$pag 				= new Pagination($rsQueryCount, $search_query."&".$sort_query, 2);
		$pag 				= new Pagination($rsQueryCount, $search_query."&".$sort_query, GLOBAL_RECORDS_PER_PAGE, $seo_friendly);
		$pag->current_page 	= $page;
		$pagination  		= $pag->Process();
	}
	$currencyRateArr			= $propertyObj->fun_findPropertyCurrencyRate();
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
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>common.js"></script>
	<script type="text/javascript" language="JavaScript" src="<?php echo SITE_JS_INCLUDES_PATH;?>dargPop.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>dhtmlwindow.js"></script>
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
    <div id="pg-wrapper" align="center"><h1 class="page-heading">Late Deal</h1></div>
    <div id="main">
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="left" valign="top">
					<?php require_once(SITE_INCLUDES_PATH.'holiday-left.php'); ?>
                </td>
                <td width="30" align="left" valign="top" style="border-right:thin #efefef solid;">&nbsp;</td>
                <td align="left" valign="top" class="font12" style="padding-left:10px;">
					<?php require_once(SITE_INCLUDES_PATH.'holidaylatedeals.php'); ?>
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
