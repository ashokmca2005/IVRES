<?php	
	if($_SERVER["SERVER_NAME"] == "localhost") {
		require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
	} else {
		require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
	}
	require_once(SITE_CLASSES_PATH."class.Users.php");
	require_once(SITE_CLASSES_PATH."class.UserSetting.php");
	require_once(SITE_CLASSES_PATH."class.Property.php");
	require_once(SITE_CLASSES_PATH."class.Pagination.php");
	require_once(SITE_CLASSES_PATH."class.Location.php");
	require_once(SITE_CLASSES_PATH."class.CMS.php");
	require_once(SITE_CLASSES_PATH."class.Message.php");
	require_once(SITE_CLASSES_PATH."class.Email.php");

	$usersObj 		= new Users();
	$userSettingObj	= new UserSetting();
	$propertyObj 	= new Property();
	$locationObj 	= new Location();
	$cmsObj         = new Cms();
	$messageObj 	= new Message();

	if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !=""){
		$user_id = $_SESSION['ses_user_id'];
	} else {
		$user_id = "";
		redirectURL("index.php");
	}

	// Holiday info
	$userInfoArr 		= $usersObj->fun_getUsersInfo($user_id);
	$users_first_name 	= $userInfoArr['user_fname'];
	$users_last_name 	= $userInfoArr['user_lname'];
	$users_email_id 	= $userInfoArr['user_email'];
	$user_full_name 	= $users_first_name." ".$users_last_name;
	$users_password 	= $userInfoArr['user_pass'];
	$country_id 		= $userInfoArr['user_country'];
	$users_currency_code= $usersObj->fun_getUserCurrencyCode($user_id);

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

	// Total Enquiries
	$enquiries_total 	= $propertyObj->fun_countPropertyUserEnquiries($user_id);

	// Total New Enquiries
	$enquiries_new  	= $propertyObj->fun_countPropertyNewUserEnquiries($user_id);
	
	// Total Bookings
	$bookings_total 	= $propertyObj->fun_countPropertyOwnerBookings($user_id);
	// Total New Bookings
	$bookings_new 		= $propertyObj->fun_countPropertyOwnerNewBookings($user_id);


	// Favourite properties
	$holidayFavouritePropertyArr = $propertyObj->fun_getPropertyUserFavouritesArr($user_id);
	if(is_array($holidayFavouritePropertyArr) && count($holidayFavouritePropertyArr) > 0) {
		$favourite_total 	= count($holidayFavouritePropertyArr);
	} else {
		$favourite_total 	= "0";
	}

?>