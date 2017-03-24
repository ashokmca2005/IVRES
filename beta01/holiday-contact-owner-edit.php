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

	if(isset($_GET['enquiry']) && $_GET['enquiry'] !=""){
		$enquiry_id = $_GET['enquiry'];
		$enquiryInfoArr = $propertyObj->fun_getPropertyEnquiryInfo($enquiry_id);
		if(is_array($enquiryInfoArr) && count($enquiryInfoArr) > 0) {
			$txtUserPhone 			= $enquiryInfoArr['phone'];
			$txtAdults 				= $enquiryInfoArr['adults'];
			$txtChilds 				= $enquiryInfoArr['childs'];
			$txtInfants 			= $enquiryInfoArr['infants'];
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
	
			$txtArriavalDate 		= $enquiryInfoArr['arrival_date'];
			/*
			$arriavalDateArr 		= explode("-", $txtArriavalDate);
			$txtDayArrival0 		= $arriavalDateArr[2];
			$txtMonthArrival0 		= $arriavalDateArr[1];
			$txtYearArrival0 		= $arriavalDateArr[0];
			*/

			$txtDepartDate 			= $enquiryInfoArr['departure_date'];
			/*
			$departurelDateArr 		= explode("-", $txtDepartDate);
			$txtDayDeparture0 		= $departurelDateArr[2];
			$txtMonthDeparture0 	= $departurelDateArr[1];
			$txtYearDeparture0 		= $departurelDateArr[0];
			*/
			$txtDuration 			= $enquiryInfoArr['duration'];
			$txtFlexibleDays 		= $enquiryInfoArr['flexi_day'];
	
			$txtUserEnquiry 		= $enquiryInfoArr['enquiry_txt'];
			$txtCreatedOn	 		= $enquiryInfoArr['created_on'];
			$txtNewLetter 			= $enquiryInfoArr['txtNewLetter'];
	
			// User details
			$enquiryUserInfoArr 	= $usersObj->fun_getUserEnquiryInfo($enquiry_id);
			$txtUserFName 			= $enquiryUserInfoArr['user_fname'];
			$txtUserLName 			= $enquiryUserInfoArr['user_lname'];
			$txtUserEmail 			= $enquiryUserInfoArr['user_email'];
			$txtUserName			= $txtUserFName." ".$txtUserLName;
	
			// Property details
//			$enquiryPropertyInfoArr = $propertyObj->fun_getPropertyEnquiryRelationInfo($enquiry_id, '');
			$propListArr 			= $propertyObj->fun_getEnquiryPropertiesInfo($enquiry_id);
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
	
	if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !=""){
		$user_id 	= $_SESSION['ses_user_id'];
		$users_currency_code= $usersObj->fun_getUserCurrencyCode($user_id);
	} else {
		$user_id 	= "";
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
        var x, y;
        function show_coords(event) {
            x=event.clientX;
            y=event.clientY;
            x = x-160;
            y = y+4;
        //	alert(x);alert(y);
        }
    
        function removeFavourite(favourite_id, p_id, user_id, num){
            var xmlHttp       = ajaxFunction();
            var favPropertyId = favourite_id;
            var Url           = "remove-favourite.php?favId="+favPropertyId;
            xmlHttp.onreadystatechange=function(){
                if(xmlHttp.readyState==4){
                    if(xmlHttp.responseText == "remove successfully"){
                        location.href = window.location;
                    }
                }
            }
            xmlHttp.open("GET", Url ,true);
            xmlHttp.send(null);
        }
    
        function chkAddToEnquiry(strId) {
            var chkBoxId = "txtPropertyCheckId"+strId;
            var propertyId = document.getElementById(chkBoxId).value;
            var strFieldId = "txtPropertyId";
            if(document.getElementById(chkBoxId).checked == true) {
                addPropertyToEnquiry(strFieldId, propertyId);
            } else {
                delPropertyToEnquiry(strFieldId, propertyId);
            }
        }
    
        function addPropertyToEnquiry(strFieldId, strFieldValue) {
            var txtIds = document.getElementById(strFieldId).value;
            if(txtIds != "") {
                document.getElementById(strFieldId).value = txtIds+","+strFieldValue;
            } else {
                document.getElementById(strFieldId).value = strFieldValue;
            }
        }
    
        function delPropertyToEnquiry(strFieldId, strFieldValue) {
            var txtids = document.getElementById(strFieldId).value;
            if(txtids != "") {
                var txtidsarr = new Array();
                var tmptxtids = "";
                txtidsarr = txtids.split(',');
                for(var i = 0; i < txtidsarr.length; i++) {
                    if(parseInt(strFieldValue) != parseInt(txtidsarr[i])) {
                        if(i == 0) {
                            tmptxtids = txtidsarr[i];
                        } else {
                            tmptxtids += ","+txtidsarr[i];
                        }
                    }
                }
                if(tmptxtids.charAt(0) == ",") {
                    tmptxtids = tmptxtids.substring(1, tmptxtids.length);
                }
                document.getElementById(strFieldId).value = tmptxtids;
            }
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
    <div id="pg-wrapper" align="center"><h1 class="page-heading">Edit your enquiry</h1></div>
    <div id="main">
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="left" valign="top">
					<?php require_once(SITE_INCLUDES_PATH.'holidayhotproperty-left.php'); ?>
                </td>
                <td width="30" align="left" valign="top" style="border-right:thin #efefef solid;">&nbsp;</td>
                <td align="left" valign="top" class="font12" style="padding-left:10px;">
					<?php require_once(SITE_INCLUDES_PATH.'contactowneredit.php'); ?>
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
