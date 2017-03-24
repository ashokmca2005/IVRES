<?php	
	if($_SERVER["SERVER_NAME"] == "localhost") {
		require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
	} else {
		require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
	}
	require_once(SITE_CLASSES_PATH."class.Users.php");
	require_once(SITE_CLASSES_PATH."class.Property.php");
	require_once(SITE_CLASSES_PATH."class.Location.php");
	require_once(SITE_CLASSES_PATH."class.Email.php");

	$usersObj 		= new Users();
	$propertyObj 	= new Property();
	$locationObj 	= new Location();

	if(isset($_GET['enquiry']) && $_GET['enquiry'] !=""){
		$enquiry_id 			= $_GET['enquiry'];
	} else {
		if(!isset($_POST['txtPropertyId']) || $_POST['txtPropertyId'] == ""){ // if property id is not available then redirect to index.php
		//	redirectURL('index.php');
		}
		$enquiry_id 			= "";
	}
	
	if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !=""){
		$user_id 			= $_SESSION['ses_user_id'];
	} else {
		$user_id 			= "";
	}

	/*
	// For Review submit : Start Here
	*/
	$detail_array 	= array();
	$error_msg		= 'no';
	if($_POST['securityKey']==md5(OWNERCONTACT)){ // First time post
		/*
		$txtUserName 			= $_POST['txtUserName'];
		$txtUserNameArr 		= explode(" ", $txtUserName);
		$txtUserFName 			= $txtUserNameArr[0];
		$txtUserLName 			= $txtUserNameArr[1];
		*/
		$txtUserFName 			= $_POST['txtUserFName'];
		$txtUserLName 			= $_POST['txtUserLName'];
		$txtUserPhone 			= $_POST['txtUserPhone'];
		$txtUserEmail 			= $_POST['txtUserEmail'];

		$txtAdults 				= $_POST['txtAdults'];
		$txtChilds 				= $_POST['txtChilds'];
		$txtInfants 			= $_POST['txtInfants'];

		/*
		$txtDayArrival0 		= $_POST['txtDayArrival0'];
		$txtMonthArrival0 		= $_POST['txtMonthArrival0'];
		$txtYearArrival0 		= $_POST['txtYearArrival0'];
		$txtArriavalDate 		= $txtYearArrival0."-".$txtMonthArrival0."-".$txtDayArrival0;
		$strUnixDateFrom 		= strtotime($txtArriavalDate);
		*/		
		$txtArriavalDate 		= $_POST['txtArrival'];
		$strUnixDateFrom 		= strtotime($txtArriavalDate);
		/*
		$txtDayDeparture0 		= $_POST['txtDayDeparture0'];
		$txtMonthDeparture0 	= $_POST['txtMonthDeparture0'];
		$txtYearDeparture0 		= $_POST['txtYearDeparture0'];
		$txtDepartureDate 		= $txtYearDeparture0."-".$txtMonthDeparture0."-".$txtDayDeparture0;
		$strUnixDateTo 			= strtotime($txtDepartureDate);
		*/
		$txtDepartureDate		= $_POST['txtDeparture'];
		$strUnixDateTo 			= strtotime($txtDepartureDate);

		$txtDuration 			= $_POST['txtDuration'];
		$txtFlexibleDays 		= $_POST['txtFlexibleDays'];
		$txtUserEnquiry 		= $_POST['txtUserEnquiry'];
		$txtNewLetter 			= $_POST['txtNewLetter'];

		/*
		# was there a reCAPTCHA response?
		if ($_POST["recaptcha_response_field"]) {
			$resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
		}
		*/

		//if((($resp->is_valid) && ($error_msg == 'no')) || (isset($_POST['txtSendMail']) && $_POST['txtSendMail'] == "1" && ($error_msg == 'no'))){		
		if(($error_msg == 'no') || (isset($_POST['txtSendMail']) && $_POST['txtSendMail'] == "1" && ($error_msg == 'no'))){		
			if(isset($_POST['txtEnquiryId']) && $_POST['txtEnquiryId'] != "") { 
				// update
				$enquiry_id = $propertyObj->fun_addPropertyEnquiry($_POST['txtEnquiryId'], $txtUserPhone, $txtAdults, $txtChilds, $txtInfants, $txtArriavalDate, $txtDepartureDate, $txtDuration, $txtFlexibleDays, $txtUserEnquiry, "0");

				//$enquiry_id = $propertyObj->fun_addPropertyEnquiry($_POST['txtEnquiryId'], $txtUserPhone, $txtUserEnquiry, "0");
				// del property relation
				//$propertyObj->fun_delEnquiryProperties($enquiry_id);
			} else {
				// new entry
				$enquiry_id = $propertyObj->fun_addPropertyEnquiry("", $txtUserPhone, $txtAdults, $txtChilds, $txtInfants, $txtArriavalDate, $txtDepartureDate, $txtDuration, $txtFlexibleDays, $txtUserEnquiry, "0");
				//$enquiry_id = $propertyObj->fun_addPropertyEnquiry("", $txtUserPhone, $txtUserEnquiry, "0");
			}

			//add / update property enquiry relation
			$property_idArr = explode(",", $_POST['txtPropertyId']);
			$char = 'a';
			if(is_array($property_idArr) && count($property_idArr) > 0) {
				for($j = 0; $j < count($property_idArr); $j++) {
					$property_id = $property_idArr[$j];
					$propertyObj->fun_addPropertyEnquiryRelation($enquiry_id, $property_id, $char, "0");
					$char++;
				}
			} else {
				$property_id = $_POST['txtPropertyId'];
				$propertyObj->fun_addPropertyEnquiryRelation($enquiry_id, $property_id, $char, "0");
			}

			if(isset($user_id) && $user_id != "") {
				// update user details, first name, last name, email id
				$usersObj->fun_updateUserNameEmail($user_id, $txtUserFName, $txtUserLName, $txtUserEmail);
			} else {
				// verify email id, if match then update first name, last name and return user_id
				if($usersObj->fun_checkEmailAddress($txtUserEmail) === true) {
					$user_id 	= $dbObj->getField(TABLE_USERS, "user_email", $txtUserEmail, "user_id");
					$usersObj->fun_updateUserNameEmail($user_id, $txtUserFName, $txtUserLName, $txtUserEmail);
				} else {
				// if email not matched, add new user
					$txtUserPasswd 	= md5('anonymous');
					$user_id		= $usersObj->fun_registerUser($txtUserEmail, $txtUserPasswd, $txtUserFName, $txtUserLName, $txtUserEmail, "", "", "", "", "", "", "", "", "", "", "0");
				}
			}
			//add / update  user enquiry relation
			$usersObj->fun_addUserEnquiryRelation($enquiry_id, $user_id, "0");

			if(isset($_POST['txtSendMail']) && $_POST['txtSendMail'] == "1") {
				//activate enquiry
				$propertyObj->fun_activateEnquiryProperties($enquiry_id);
				$propertyObj->fun_activatePropertyEnquiry($enquiry_id);
				$usersObj->fun_activateEnquiryUser($enquiry_id);
				// Send notification mail
				$propertyObj->fun_sendPropertyEnquiryNotification($enquiry_id);
				$userDets 	= $usersObj->fun_getUsersInfo($user_id, '');
				/*
				if($userDets['user_status'] == "1") {
					if($userDets['is_owner'] == "1") {
						redirectURL('owner-enquiries.php?enquiry='.$enquiry_id.'&err=thanks');
					} else {
						redirectURL('holiday-enquiries.php?enquiry='.$enquiry_id.'&err=thanks');
					}
				} else {
					//redirectURL('index.php');
				}
				*/
				redirectURL('enquiries.php?enquiry='.$enquiry_id.'&err=thanks');
			} else {
				redirectURL('holiday-contact-owner-preview.php?enquiry='.$enquiry_id);
			}
		} else {
			$form_array['error_msg'] = "Please submit your form again!";
			//$captchaerror = $resp->error;
		}
	}
	/*
	// For Review submit : End Here
	*/
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
    <script language="javascript" type="text/javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>pop-up.js"></script>
	<script language="javascript" type="text/javascript">
        var x, y;
        function show_coords(event){	
            x=event.clientX;
            y=event.clientY;
            x = x-160;
            y = y+4;
            //alert(x);alert(y);
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
    <div id="pg-wrapper" align="center"><h1 class="page-heading">Enquiry details</h1></div>
    <div id="main">
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="left" valign="top">
					<?php require_once(SITE_INCLUDES_PATH.'holidayhotproperty-left.php'); ?>
                </td>
                <td width="30" align="left" valign="top" style="border-right:thin #efefef solid;">&nbsp;</td>
                <td align="left" valign="top" class="font12" style="padding-left:10px;">
					<?php require_once(SITE_INCLUDES_PATH.'holidaycontactownerpreview.php'); ?>
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
