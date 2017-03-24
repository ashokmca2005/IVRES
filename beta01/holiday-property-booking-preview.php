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
	if(isset($_GET['booking']) && $_GET['booking'] !=""){
		$booking_id 	= $_GET['booking'];
	} else {
		if(!isset($_POST['txtPropertyId']) || $_POST['txtPropertyId'] == ""){ // if property id is not available then redirect to index.php
			redirectURL('index.php');
		}
		$booking_id 			= "";
	}
	
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


	/*
	// For Review submit : Start Here
	*/
	$detail_array 	= array();
	$error_msg		= 'no';
	if($_POST['securityKey']==md5(BOOKINGENGINE)){ // First time post

		$property_id            = $_POST['txtPropertyId'];
		$txtUserFName 			= $_POST['txtUserFName'];
		$txtUserLName 			= $_POST['txtUserLName'];
		$txtUserName			= $txtUserFName." ".$txtUserLName;
		$txtUserEmail 			= $_POST['txtUserEmail'];
		$txtTown                = $_POST['txtTown'];
	    $txtZip                 = $_POST['txtZip'];
	    $txtRCountry            = $_POST['txtRCountry'];
	    $txtUserAdrress			= $txtTown ." ".$txtZip;
		$phone 					= $_POST['txtUserPhone'];
		$adults 				= $_POST['txtAdults'];
		$childs 				= $_POST['txtChilds'];
		$infants 				= $_POST['txtInfants'];
    	$txtNewLetter 			= $_POST['txtNewLetter'];
		$message                = $_POST['txtUserMessage'];
		$total_amount           = $_POST['total_amount'];
		$owner_amount           = $_POST['owner_amount'];
		
		if(isset($_POST['txtDayArrival0']) && $_POST['txtDayArrival0'] > 0 && isset($_POST['txtMonthArrival0']) && $_POST['txtMonthArrival0'] > 0 && isset($_POST['txtYearArrival0']) && $_POST['txtYearArrival0'] > 0 && isset($_POST['txtDayDeparture0']) && $_POST['txtDayDeparture0'] > 0 && isset($_POST['txtMonthDeparture0']) && $_POST['txtMonthDeparture0'] > 0 && isset($_POST['txtYearDeparture0']) && $_POST['txtYearDeparture0'] > 0) {
	
			$txtDayArrival0 		= $_POST['txtDayArrival0'];
			$txtMonthArrival0 		= $_POST['txtMonthArrival0'];
			$txtYearArrival0 		= $_POST['txtYearArrival0'];
			$arrival_date 		    = $txtYearArrival0."-".$txtMonthArrival0."-".$txtDayArrival0;
			$strUnixDateFrom 		= strtotime($arrival_date);
	
			$txtDayDeparture0 		= $_POST['txtDayDeparture0'];
			$txtMonthDeparture0 	= $_POST['txtMonthDeparture0'];
			$txtYearDeparture0 		= $_POST['txtYearDeparture0'];
			$departure_date 		= $txtYearDeparture0."-".$txtMonthDeparture0."-".$txtDayDeparture0;
			$strUnixDateTo	 		= strtotime($departure_date);
			
			// Step I: Check availability
			if($propertyObj->fun_checkBookingAvailability($property_id, $arrival_date, $departure_date) === false) { // if true
				$error_msg == 'yes';
				$detail_array['error_msg'] = "Booking are not avalaible from ".$arrival_date." to ".$departure_date." Please submit your form again!";
			}
			
		} else {
			$error_msg == 'yes';
			$detail_array['error_msg'] = "Booking dates are not missing; Please submit your form again!";
		}

		if($error_msg == 'no') {
			if(isset($booking_id) && $booking_id != "") { 
				// update
				$propertyObj->fun_addPropertyBooking($booking_id, $user_id, $property_id, $phone, $adults, $childs, $infants, $arrival_date, $departure_date, $message, $total_amount, $owner_amount, $payment_status, $active);
			} else { 
				// new entry
				$booking_id = $propertyObj->fun_addPropertyBooking('', $user_id, $property_id, $phone, $adults, $childs, $infants, $arrival_date, $departure_date, $message, $total_amount, $owner_amount, $payment_status, $active);
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
					$user_id		= $usersObj->fun_registerUser($txtUserEmail, $txtUserPasswd, $txtUserFName, $txtUserLName, $txtUserEmail, "", "", "", "", "", $txtTown, "", $txtZip, "", $txtRCountry, "0");
				}
			}
			// update user id in property booking table
			$propertyObj->fun_updatePropertyBookingUser($booking_id, $user_id);
			
			if(isset($_POST['txtBookNow']) && $_POST['txtBookNow'] == "1") {
				//activate booking
/*
				$propertyObj->fun_activatebookingProperties($booking_id);
				$propertyObj->fun_activatePropertyBooking($booking_id);
				$usersObj->fun_activatebookingUser($booking_id);
				// Send notification mail
				$propertyObj->fun_sendPropertyBookingNotification($booking_id);
				$userDets 	= $usersObj->fun_getUsersInfo($user_id, '');
				if($userDets['user_status'] == "1") {
					if($userDets['is_owner'] == "1") {
						redirectURL('owner-bookings.php?booking='.$booking_id.'&err=thanks');
					} else {
						redirectURL('holiday-bookings.php?booking='.$booking_id.'&err=thanks');
					}
				} else {
					redirectURL('index.php');
				}
*/

			} else {
				redirectURL('holiday-property-booking-preview.php?booking='.$booking_id);
			}
		} else {
			$detail_array['error_msg'] = "Please submit your form again!";
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
    <script language="javascript" type="text/javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>pop-up.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>dhtmlwindow.js"></script>
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
    <div id="pg-wrapper" align="center"><h1 class="page-heading">Bookings</h1></div>
    <div id="main">
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="left" valign="top">
					<?php require_once(SITE_INCLUDES_PATH.'holidayhotproperty-left.php'); ?>
                </td>
                <td width="30" align="left" valign="top" style="border-right:thin #efefef solid;">&nbsp;</td>
                <td align="left" valign="top" class="font12" style="padding-left:10px;">
					<?php require_once(SITE_INCLUDES_PATH.'holidaypropertybookingpreview.php'); ?>
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
