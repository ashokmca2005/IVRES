<?php	
	if($_SERVER["SERVER_NAME"] == "localhost") {
		require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
	} else {
		require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
	}

	require_once(SITE_CLASSES_PATH."class.Users.php");
	require_once(SITE_CLASSES_PATH."class.UserSetting.php");
	require_once(SITE_CLASSES_PATH."class.Location.php");
	require_once(SITE_CLASSES_PATH."class.Property.php");
	require_once(SITE_CLASSES_PATH."class.Pagination.php");
	require_once(SITE_CLASSES_PATH."class.Message.php");
	require_once(SITE_CLASSES_PATH."class.Testimonial.php");
	require_once(SITE_CLASSES_PATH."class.Promo.php");
	require_once(SITE_CLASSES_PATH."class.Product.php");
	require_once(SITE_CLASSES_PATH."class.Cart.php");
	require_once(SITE_CLASSES_PATH."class.Image.php");
	require_once(SITE_CLASSES_PATH."class.Email.php");
	require_once(SITE_CLASSES_PATH."class.Calender.php");
	require_once(SITE_CLASSES_PATH."class.Travel.php");
	require_once(SITE_CLASSES_PATH."class.CMS.php");
	require_once(SITE_CLASSES_PATH."class.Banner.php");


	$propertyObj 	= new Property();
	$usersObj 		= new Users();
	$userSettingObj	= new UserSetting();
	$locationObj 	= new Location();
	$messageObj 	= new Message();
	$testiObj 		= new Testimonial();
	$productObj		= new Product();
	$promoObj 		= new Promo();
	$cartObj 		= new Cart();
	$imgObj 		= new Image();
	$calendarObj 	= new Calendar();
	$tvlguidObj		= new Travel();
	$cmsObj         = new Cms();
	$bannerObj      = new Banner();
	
	if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !=""){
		$user_id 	= $_SESSION['ses_user_id'];
	} else {
		$user_id 	= "";
		redirectURL("index.php");
	}

	// Owner property list
	$ownerPropertyArr 	= $propertyObj->fun_getPropertyOwnerArr($user_id);
	if(is_array($ownerPropertyArr)&&(count($ownerPropertyArr) > 0)){
		$total_properties = count($ownerPropertyArr);
	} else {
		$total_properties = 0;
	}
	
	// Owner info
	$userInfoArr 		= $usersObj->fun_getUsersInfo($user_id);
	$users_first_name 	= $userInfoArr['user_fname'];
	$users_last_name 	= $userInfoArr['user_lname'];
	$users_email_id 	= $userInfoArr['user_email'];
	$user_full_name 	= $users_first_name." ".$users_last_name;
	$users_password 	= $userInfoArr['user_pass'];
	$country_id 		= $userInfoArr['user_country'];
	$profile_photo 		= $userInfoArr['photo'];
	$profile_story 		= $userInfoArr['story'];

	// Total Enquiries
	$enquiries_total 	= $propertyObj->fun_countPropertyOwnerEnquiries($user_id);
	// Total New Enquiries
	$enquiries_new 		= $propertyObj->fun_countPropertyOwnerNewEnquiries($user_id);


	// Total Bookings
	$bookings_total 	= $propertyObj->fun_countPropertyOwnerBookings($user_id);
	// Total New Bookings
	$bookings_new 		= $propertyObj->fun_countPropertyOwnerNewBookings($user_id);


	// Owner Favourite properties
	$ownerFavouritePropertyArr = $propertyObj->fun_getPropertyUserFavouritesArr($user_id);
	if(is_array($ownerFavouritePropertyArr) && count($ownerFavouritePropertyArr) > 0) {
		$favourite_total 	= count($ownerFavouritePropertyArr);
	} else {
		$favourite_total 	= "0";
	}

	// Owner Cart
	$owner_cart_items	= $cartObj->fun_countCartItems($user_id);
	if($cartObj->fun_getCartAmt($user_id) > 0){
		$owner_cart_amt		= " $".number_format($cartObj->fun_getCartAmt($user_id)).".00";
		$owner_cart_Tamt	= "- total $".number_format($cartObj->fun_getCartAmt($user_id)).".00";
	}
?>
