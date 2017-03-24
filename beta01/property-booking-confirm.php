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

	
	if($_POST['securityKey']==md5(BOOKINGENGINECONFIRM)){ // First time post
		$property_id            = $_POST['txtPropertyId'];
		$arriavalDate        	= $_POST['txtArriavalDate'];
		$departureDate          = $_POST['txtDepartureDate'];
		if(isset($arriavalDate) && $arriavalDate != "" && isset($departureDate) && $departureDate != "") {
			$strUnixDateFrom 	= strtotime($arriavalDate);
			$strUnixDateTo	 	= strtotime($departureDate);

			if($propertyObj->fun_checkBookingAvailability($property_id, $arriavalDate, $departureDate) === true) { // if true
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
				$txtSalutation 			= $_POST['txtSalutation']; // extra
				$txtBudget 				= $_POST['txtBudget']; // extra
				$txtFindUs 				= $_POST['txtFindUs']; // extra
				$txtPayDeposit 			= $_POST['txtPayDeposit']; // extra
				$txtFlexibility			= $_POST['txtFlexibility']; // extra
				$txtOneBdrApt			= $_POST['txtOneBdrApt']; // extra
				$txtTwoBdrApts			= $_POST['txtTwoBdrApts']; // extra
				$txtThreeBdrApts		= $_POST['txtThreeBdrApts']; // extra
				$txtTwinStudio			= $_POST['txtTwinStudio']; // extra
				$txtTripleStudio		= $_POST['txtTripleStudio']; // extra
				$txtRoomOnly2		    = $_POST['txtRoomOnly2']; // extra
				$txtRoomOnly3		    = $_POST['txtRoomOnly3']; // extra
				$message                = $_POST['txtUserMessage'];
				$booking_cost			= $propertyObj->fun_getPropertyBookingCost($property_id, $arriavalDate, $departureDate, $users_currency_code);
				$total_amount           = $booking_cost;
				$bookingCharge 			=  $propertyObj->fun_getBookingCharges($property_id);	
				(!empty($bookingCharge)) ? $bookingCharge : '10';
				$owner_amount			= round(((($booking_cost) * $bookingCharge)/100),0) ;
				$payment_status 		= 1;
				$active 				= 0;

				$booking_id = $propertyObj->fun_addPropertyBooking('', $user_id, $property_id, $phone, $adults, $childs, $infants, $arriavalDate, $departureDate, $message, $total_amount, $owner_amount, $users_currency_code, $txtSalutation, $txtBudget, $txtFindUs, $txtPayDeposit, $txtFlexibility, $txtOneBdrApt, $txtTwoBdrApts, $txtThreeBdrApts, $txtTwinStudio, $txtTripleStudio, $txtRoomOnly2, $txtRoomOnly3, $payment_status, $active);
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
				$usersObj->fun_addUserbookingRelation($booking_id, $user_id, '0');
				$propertyObj->fun_activatePropertyBooking($booking_id);
				// Send notification mail

//				$propertyObj->fun_sendPropertyBookingNotification($booking_id);
				echo "<script> location.href='booking-checkout.php?action=process&booking=".$booking_id."';</script>";
			}
		} else {
//			redirectURL('property-booking-preview.php');
		}
	} else {
//		redirectURL('property-booking-preview.php');
	}
?>
