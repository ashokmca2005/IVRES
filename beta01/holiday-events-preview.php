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
	require_once(SITE_CLASSES_PATH."class.Image.php");
	
	$dbObj = new DB();
	$dbObj->fun_db_connect();
	
	$eventObj 		= new Event();
	$propertyObj 	= new Property();
	$usersObj 		= new Users();
	$locationObj 	= new Location();
	$imgObj 		= new Image();
	
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
	
	$detail_array 	= array();
	$error_msg		= 'no';
	//print_r($_POST);
	
	if($_POST['securityKey'] == md5(ADDEVENTCONFIRM)){		
		// Transfer all data from temp table to actual table
		$event_id = $_POST['txtEventId'];
		if($eventObj->fun_moveEventFromEventTmp($event_id)) {
			redirectURL('holiday-events-thanks.php'); // go to thanks page
		} else {
			redirectURL('holiday-events-add.php'); // go to add event page
		}
	}
	
	if($_POST['securityKey'] == md5(ADDEVENT)){		
		$event_id 	= $_REQUEST[PHPSESSID]; // Current PHP Session Id
	//	$eventObj->fun_delEventTemp($event_id);
		$txtEvntPhotoCaption 	= $dbObj->escapeSql($_POST['txtEvntPhotoCaption']);
		$txtEvntPhotoBy 		= "";
		$txtEvntPhotoLink 		= "";
	
		$txtEventOwnerFName 	= $_POST['txtEventOwnerFName'];
		$txtEventOwnerLName 	= $_POST['txtEventOwnerLName'];
		$txtEventOwnerEmail 	= $_POST['txtEventOwnerEmail'];
		if(isset($_POST['txtAddEventArea']) && $_POST['txtAddEventArea'] !="0") {
			$txtAddEventArea 		= $_POST['txtAddEventArea'];
			if(isset($_POST['txtAddEventRegion']) && $_POST['txtAddEventRegion'] !="0") {
				$txtAddEventRegion 		= $_POST['txtAddEventRegion'];
				if(isset($_POST['txtAddEventSubRegion']) && $_POST['txtAddEventSubRegion'] !="0") {
					$txtAddEventSubRegion 	= $_POST['txtAddEventSubRegion'];
					if(isset($_POST['txtAddEventLocation']) && $_POST['txtAddEventLocation'] !="0") {
						$txtAddEventLocation 	= $_POST['txtAddEventLocation'];
					} else {
						$txtAddEventLocation 	= "0";
					}
				} else {
					$txtAddEventSubRegion 	= "0";
					$txtAddEventLocation 	= "0";
				}
			} else {
				$txtAddEventRegion 		= "0";
				$txtAddEventSubRegion 	= "0";
				$txtAddEventLocation 	= "0";
			}
		} else {
			$txtAddEventArea 		= "0";
			$txtAddEventRegion 		= "0";
			$txtAddEventSubRegion 	= "0";
			$txtAddEventLocation 	= "0";
		}
	
		$txtEventName 			= $dbObj->escapeSql($_POST['txtEventName']);
		$txtEventCategory 		= $_POST['txtEventCategory'];
		if(is_array($txtEventCategory)) {
			$txtEventCategoryIds= implode(",", $txtEventCategory);
		}
		
		$txtYearRound 			= $_POST['txtYearRound'];
		if($txtYearRound == "0") {
			$txtDayFrom1 			= $_POST['txtDayFrom1'];
			$txtMonthFrom1 			= $_POST['txtMonthFrom1'];
			$txtYearFrom1 			= $_POST['txtYearFrom1'];
			$txtFromDate 			= $txtYearFrom1."-".$txtMonthFrom1."-".$txtDayFrom1;
			$txtDayTo1 				= $_POST['txtDayTo1'];
			$txtMonthTo1 			= $_POST['txtMonthTo1'];
			$txtYearTo1 			= $_POST['txtYearTo1'];
			$txtToDate 				= $txtYearTo1."-".$txtMonthTo1."-".$txtDayTo1;
		} else {
			$txtFromDate 			= "";
			$txtToDate 				= "";
		}
	
		if(isset($_POST['txtEventTime']) && $_POST['txtEventTime'] != "" && $_POST['txtEventTime'] != "eg opening times or show times") {
			$txtEventTime 			= $dbObj->escapeSql($_POST['txtEventTime']);
		} else {
			$txtEventTime 			= "";
		}
	
		if(isset($_POST['txtEventPrice']) && $_POST['txtEventPrice'] != "" && $_POST['txtEventPrice'] != "These will appear exactly as typed") {
			$txtEventPrice 			= $dbObj->escapeSql($_POST['txtEventPrice']);
		} else {
			$txtEventPrice 			= "";
		}
	
		$txtEventVenue 			= $dbObj->escapeSql($_POST['txtEventVenue']);
		$txtEventPhone 			= $_POST['txtEventPhone'];
		$txtEventEmail 			= $_POST['txtEventEmail'];
		$txtEventWebsite		= $_POST['txtEventWebsite'];
		$txtEventDesc 			= $dbObj->escapeSql($_POST['txtEventDesc']);
		$eventObj->fun_addEventTemp($event_id, $txtEventCategoryIds, $txtEventName, $txtEventDesc, $txtAddEventArea, $txtAddEventRegion, $txtAddEventSubRegion, $txtAddEventLocation, $txtYearRound, $txtFromDate, $txtToDate, $txtEventTime, $txtEventPrice, $txtEventVenue, $txtEventPhone, $txtEventEmail, $txtEventWebsite, '', '', $txtEvntPhotoCaption, $txtEvntPhotoBy, $txtEvntPhotoLink, $txtEventOwnerFName, $txtEventOwnerLName, $txtEventOwnerEmail);
	}
	
	$eventInfoArr = $eventObj->fun_getEventTmpInfo($_REQUEST[PHPSESSID]);
	
	//print_r($eventInfoArr);
	
	if(is_array($eventInfoArr) && count($eventInfoArr) > 0) {
	} else {
		$eventObj->fun_delEventTemp($_REQUEST[PHPSESSID]); // delete all records
		redirectURL('holiday-events-add.php'); // go to add page
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
    <div id="pg-wrapper" align="center"><h1 class="page-heading">Events</h1></div>
    <div id="main">
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="left" valign="top">
					<?php require_once(SITE_INCLUDES_PATH.'holiday-events-view-left-links.php'); ?>
                </td>
                <td width="30" align="left" valign="top" style="border-right:thin #efefef solid;">&nbsp;</td>
                <td align="left" valign="top" class="font12" style="padding-left:10px;">
					<?php require_once(SITE_INCLUDES_PATH.'holidayeventspreview.php'); ?>
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
