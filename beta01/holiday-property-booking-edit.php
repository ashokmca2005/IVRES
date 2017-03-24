<?php	
	if($_SERVER["SERVER_NAME"] == "localhost") {
		require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
	} else {
		require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
	}
	require_once(SITE_CLASSES_PATH."class.Users.php");
	require_once(SITE_CLASSES_PATH."class.Property.php");
	require_once(SITE_CLASSES_PATH."class.Location.php");
	$usersObj 		= new Users();
	$propertyObj 	= new Property();
	$locationObj 	= new Location();

	if(isset($_GET['booking']) && $_GET['booking'] !=""){
		$booking_id = $_GET['booking'];
		$bookingInfoArr = $propertyObj->fun_getPropertyBookingInfo($booking_id);
		if(is_array($bookingInfoArr) && count($bookingInfoArr) > 0) {
			$txtPropertyId 			= $bookingInfoArr['property_id'];
			$txtUserPhone 			= $bookingInfoArr['phone'];
			$txtAdults 				= $bookingInfoArr['adults'];
			$txtChilds 				= $bookingInfoArr['childs'];
			$txtInfants 			= $bookingInfoArr['infants'];
			$travelArr = array();
			if(isset($txtAdults) && $txtAdults > 0) {
				array_push($travelArr, ($txtAdults > 1)?$txtAdults." adults":$txtAdults." adult");
			}
			if(isset($txtChilds) && $txtChilds > 0) {
				array_push($travelArr, ($txtChilds > 1)?$txtChilds." children":$txtChilds." children");
			}
			if(isset($txtInfants) && $txtInfants > 0) {
				array_push($travelArr, ($txtInfants > 1)?$txtInfants." infants":$txtInfants." infant");
			}
	
			$txtArriavalDate 		= $bookingInfoArr['arrival_date'];
			$arriavalDateArr 		= explode("-", $txtArriavalDate);
			$txtDayArrival0 		= $arriavalDateArr[2];
			$txtMonthArrival0 		= $arriavalDateArr[1];
			$txtYearArrival0 		= $arriavalDateArr[0];
			$txtDepartureDate 		= $bookingInfoArr['departure_date'];
			$departureDateArr 		= explode("-", $txtDepartureDate);
			$txtDayDeparture0 		= $departureDateArr[2];
			$txtMonthDeparture0		= $departureDateArr[1];
			$txtYearDeparture0 		= $departureDateArr[0];
			$txtUserMessage 		= $bookingInfoArr['message'];
			$txtNewLetter 			= $bookingInfoArr['txtNewLetter'];
	
			// User details
			$bookingUserInfoArr 	= $usersObj->fun_getUserBookingInfo($booking_id);
			$txtUserFName 			= $bookingUserInfoArr['user_fname'];
			$txtUserLName 			= $bookingUserInfoArr['user_lname'];
			$txtUserEmail 			= $bookingUserInfoArr['user_email'];
			$txtUserName			= $txtUserFName." ".$txtUserLName;
			$txtTown                = $bookingUserInfoArr['user_town'];
			$txtZip                 = $bookingUserInfoArr['user_zip'];
			$txtRCountry            = $bookingUserInfoArr['user_rcountry'];
			$txtUserAdrress			= $txtTown ." ".$txtZip;
	
			// Property details
			$propListArr 			= $propertyObj->fun_getBookingPropertiesInfo($booking_id);

			$txtPropertyIdArr 		= array();
			foreach($propListArr as $value) {
				array_push($txtPropertyIdArr, $value['property_id']);
			}
			$txtPropertyId 			= implode(",", $txtPropertyIdArr);
//			print_r($propListArr);
		}
	} else {
		redirectURL('index.php');
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
    <div id="pg-wrapper" align="center"><h1 class="page-heading">Edit your Booking</h1></div>
    <div id="main">
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="left" valign="top">
					<?php require_once(SITE_INCLUDES_PATH.'holiday-left.php'); ?>
                </td>
                <td width="30" align="left" valign="top" style="border-right:thin #efefef solid;">&nbsp;</td>
                <td align="left" valign="top" class="font12" style="padding-left:10px;">
					<?php require_once(SITE_INCLUDES_PATH.'propertybookingedit.php'); ?>
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
