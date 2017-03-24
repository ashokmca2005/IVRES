<?php	
	if($_SERVER["SERVER_NAME"] == "localhost") {
		require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
	} else {
		require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
	}
	require_once(SITE_CLASSES_PATH."class.Users.php");
	require_once(SITE_CLASSES_PATH."class.Event.php");
	require_once(SITE_CLASSES_PATH."class.Property.php");
	require_once(SITE_CLASSES_PATH."class.Pagination.php");
	require_once(SITE_CLASSES_PATH."class.Location.php");
	$eventObj 		= new Event();
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
	$seo_friendly 		= SITE_URL."events"; // for seo friendly urls
	if(isset($_GET['evntcode']) && $_GET['evntcode'] !="" && !isset($_POST['securityKey']) && $_POST['securityKey'] != md5(EVENTSEARCH)) {
		$event_code 	= $_GET['evntcode'];
		$evntDetails	= $eventObj->fun_getEventDetailsByCode($event_code);
		if(!is_array($evntDetails)) {
			redirectURL(SITE_URL.'events'); // go to event listing page
		}
	} else {
		/*
		* Event Search form submmision : Start here
		*/
		$search_query = "";
		$page	 = form_int("page",1)+0;
		$sortby  = form_int("sortby",0,0,4);
		$sortdir = form_int("sortdir",0,0,1);
		if (form_isset("reverse")) {
			$sortdir = 1-$sortdir;
		}
		switch($sortdir) {
			case 0 : $orderDir = "DESC"; break;
			case 1 : $orderDir = "ASC"; break;
		}
		
		switch($sortby) {
			case 0: $sortField  = "A.event_year_around"; break;
			case 1: $sortField  = "A.event_year_around"; break;
			default: $sortField = "A.event_year_around"; break;
		}
	
		if(isset($_REQUEST['destinations']) && $_REQUEST['destinations'] != "") { $destinations = form_text("destinations"); $destinations = stripslashes($destinations); }
		if(isset($destinations) && $destinations !="") {
			$seo_friendly 		.= "/in.".$destinations;
			$destinations		= str_replace("-", " ", $destinations);
			$destinationArr 	= $locationObj->fun_getDestinationInfo($destinations);
			if(isset($destinationArr['area_id']) && $destinationArr['area_id'] != "" && $destinationArr['area_id'] != "0") { $txtareaid = $destinationArr['area_id']; $txtareaid = stripslashes($txtareaid);}
			if(isset($destinationArr['pregion_id']) && $destinationArr['pregion_id'] != "" && $destinationArr['pregion_id'] != "0") { $txtregionid = $destinationArr['pregion_id']; $txtregionid = stripslashes($txtregionid);}
			if(isset($destinationArr['region_id']) && $destinationArr['region_id'] != "" && $destinationArr['region_id'] != "0") { $txtsubregionid = $destinationArr['region_id']; $txtsubregionid = stripslashes($txtsubregionid);}
			if(isset($destinationArr['location_id']) && $destinationArr['location_id'] != "" && $destinationArr['location_id'] != "0") { $txtlocationid = $destinationArr['location_id']; $txtlocationid = stripslashes($txtlocationid);}
		} else {
			if(isset($_REQUEST['txtareaid']) && $_REQUEST['txtareaid'] != "" && $_REQUEST['txtareaid'] != "0") { $txtareaid = form_text("txtareaid"); $txtareaid = stripslashes($txtareaid);}
			if(isset($_REQUEST['txtregionid']) && $_REQUEST['txtregionid'] != "" && $_REQUEST['txtregionid'] != "0") { $txtregionid = form_text("txtregionid"); $txtregionid = stripslashes($txtregionid);}
			if(isset($_REQUEST['txtsubregionid']) && $_REQUEST['txtsubregionid'] != "" && $_REQUEST['txtsubregionid'] != "0") { $txtsubregionid = form_text("txtsubregionid"); $txtsubregionid = stripslashes($txtsubregionid);}
			if(isset($_REQUEST['txtlocationid']) && $_REQUEST['txtlocationid'] != "" && $_REQUEST['txtlocationid'] != "0") { $txtlocationid = form_text("txtlocationid"); $txtlocationid = stripslashes($txtlocationid);}
			if(isset($txtareaid) && $txtareaid != "") { $search_query .= "&txtareaid=" . html_escapeURL($txtareaid); }
			if(isset($txtregionid) && $txtregionid != "") { $search_query .= "&txtregionid=" . html_escapeURL($txtregionid); }
			if(isset($txtsubregionid) && $txtsubregionid != "") { $search_query .= "&txtsubregionid=" . html_escapeURL($txtsubregionid); }
			if(isset($txtlocationid) && $txtlocationid != "") { $search_query .= "&txtlocationid=" . html_escapeURL($txtlocationid); }
		}
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
		if(isset($_REQUEST['txtEventCategory']) && $_REQUEST['txtEventCategory'] > 0) { $txtEventCategory = form_text("txtEventCategory"); $txtEventCategory = stripslashes($txtEventCategory); }
		if(isset($txtEventCategory) && $txtEventCategory != "") { $search_query .= "&txtEventCategory=" . html_escapeURL($txtEventCategory); }
		$strQueryParameter		= " ORDER BY " . $sortField . " " . $orderDir. " LIMIT ".(int)(($page-1)*(int)GLOBAL_RECORDS_PER_PAGE).", ".GLOBAL_RECORDS_PER_PAGE;
		$strQueryCountParameter	= " ORDER BY " . $sortField . " " . $orderDir;
		$rsQuery				= $eventObj->fun_getEventsSearchArr($txtFromDate, $txtToDate, $txtEventCategory, '', $txtareaid, $txtregionid, $txtsubregionid, $txtlocationid, $strQueryParameter);
		$rsQueryCount			= $eventObj->fun_getEventsSearchArr($txtFromDate, $txtToDate, $txtEventCategory, '', $txtareaid, $txtregionid, $txtsubregionid, $txtlocationid, $strQueryCountParameter);
		$sort_query   = "sortby=" . html_escapeURL($sortby) ."&sortdir=" . html_escapeURL($sortdir);
		if($dbObj->getRecordCount($rsQueryCount) > 0) {
			$evntListArr 		= $dbObj->fetchAssoc($rsQuery);
			// Determine the pagination
			$return_query 		= $search_query."&".$sort_query."&page=$page";
	//		$pag 				= new Pagination($rsQueryCount, $search_query."&".$sort_query, GLOBAL_RECORDS_PER_PAGE);
			$pag 				= new Pagination($rsQueryCount, $search_query."&".$sort_query, GLOBAL_RECORDS_PER_PAGE, $seo_friendly);
			$pag->current_page 	= $page;
			$pagination  		= $pag->Process();
		}
	/*
	* Event Search form submmision : Start here
	*/
	}
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
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>dhtmlwindow.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>pop-up.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>tab_menu.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>dargPop.js"></script>
    <script language="javascript" type="text/javascript">
		var req = ajaxFunction();
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
		function shwEventDetails (strEventCode, strEventList) {
			document.getElementById("eventDetailsDivId").style.display = "block";
			document.getElementById("eventsLisitingDivId").style.display = "none";
			req.onreadystatechange=function() {
				if(req.readyState==1) { //Loading
					document.getElementById("eventDetailsDivId").innerHTML="<table width=\"450\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td align=\"left\" valign=\"top\">Loading...</td></tr></table>";
				}
				if(req.readyState==4) { //Complete
					document.getElementById("eventDetailsDivId").innerHTML = req.responseText
				}
			}
			url = "<?php echo SITE_URL; ?>showEventDetails.php?ec=" + strEventCode +"&list=" + strEventList;
			req.open("GET",url,true);
			req.send(null);
		}
		function backToResult() {
			document.getElementById("eventDetailsDivId").innerHTML="";
			document.getElementById("eventDetailsDivId").style.display = "none";
			document.getElementById("eventsLisitingDivId").style.display = "block";
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
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="left" valign="top">
					<?php require_once(SITE_INCLUDES_PATH.'holiday-events-view-left-links.php'); ?>
                </td>
                <td width="30" align="left" valign="top" style="border-right:thin #efefef solid;">&nbsp;</td>
                <td align="left" valign="top" class="font12" style="padding-left:10px;">
					<?php require_once(SITE_INCLUDES_PATH.'eventsearchresults-show.php'); ?>
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
