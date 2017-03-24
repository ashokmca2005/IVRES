<?php 
	$arrival_date 	= $_POST['arrival_date'];
	$departure_date = $_POST['departure_date'];
	$adults 		= $_POST['adults'];
	$children 		= $_POST['children'];
	$property_id 	= $_POST['property_id'];
	$name 			= $_POST['name'];
	$email 			= $_POST['email'];
	$country_code_phone = isset($_POST['country_code_phone'])  ? $_POST['country_code_phone']: '1';
	$phone 			= $_POST['phone'];
	$ip_address 	= $_SERVER['REMOTE_ADDR'];
	$partner_id 	= isset($_POST['partner_id'])  ? $_POST['partner_id']: '';
	$alias 			= isset($_POST['alias'])  ? $_POST['alias']: '';
	$post 			= $_POST;
	
	// for internal database
	if($_SERVER["SERVER_NAME"] == "localhost") {
		require_once($_SERVER["DOCUMENT_ROOT"]."/a1rentalhome/includes/application-top.php");
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
	} else {
		$user_id 			= "";
	}

	$package_credit 	= $propertyObj->fun_getOwnerPackageCreditByPropertyId($property_id);
	/*
	* Case I: if package credit greater than zero and package inquires greater than zero => Insert it in database and deduct 1 credit
	********************************************************************************************************************/
	if(isset($package_credit) && $package_credit > 0) {
		$enquiry_id = $propertyObj->fun_addPropertyEnquiry("", $phone, $adults, $children, "0", date("Y-m-d", strtotime($arrival_date)), date("Y-m-d", strtotime($departure_date)), "", "", "", "0");
		$propertyObj->fun_addPropertyEnquiryRelation($enquiry_id, $property_id, "a", "0");
		if(isset($user_id) && $user_id != "") {
			// update user details, first name, last name, email id
			//$usersObj->fun_updateUserNameEmail($user_id, $name, "", $email);
		} else {
			// verify email id, if match then update first name, last name and return user_id
			if($usersObj->fun_checkEmailAddress($email) === true) {
				$user_id 	= $dbObj->getField(TABLE_USERS, "user_email", $email, "user_id");
				//$usersObj->fun_updateUserNameEmail($user_id, $name, "", $email);
			} else {
			// if email not matched, add new user
				$password 	= md5('anonymous');
				$user_id		= $usersObj->fun_registerUser($email, $password, $name, "", $email, "", "", "", "", "", "", "", "", "", "", "0");
			}
		}
		//add / update  user enquiry relation
		$usersObj->fun_addUserEnquiryRelation($enquiry_id, $user_id, "0");
		$propertyObj->fun_updateOwnerPackageCreditByOne($property_id);
	/*
	* Case II: if package credit equal to zero and package inquiries greater than zero => Insert it in database and but hide it from owner side
	********************************************************************************************************************/
	} else if(isset($package_credit) && ($package_credit+3) > 0) {
		$enquiry_id = $propertyObj->fun_addPropertyEnquiry("", $phone, $adults, $children, "0", date("Y-m-d", strtotime($arrival_date)), date("Y-m-d", strtotime($departure_date)), "", "", "", "0");
		$propertyObj->fun_addPropertyEnquiryRelation($enquiry_id, $property_id, "a", "0");
		if(isset($user_id) && $user_id != "") {
			// update user details, first name, last name, email id
			//$usersObj->fun_updateUserNameEmail($user_id, $name, "", $email);
		} else {
			// verify email id, if match then update first name, last name and return user_id
			if($usersObj->fun_checkEmailAddress($email) === true) {
				$user_id 	= $dbObj->getField(TABLE_USERS, "user_email", $email, "user_id");
				//$usersObj->fun_updateUserNameEmail($user_id, $name, "", $email);
			} else {
			// if email not matched, add new user
				$password 	= md5('anonymous');
				$user_id		= $usersObj->fun_registerUser($email, $password, $name, "", $email, "", "", "", "", "", "", "", "", "", "", "0");
			}
		}
		//add / update  user enquiry relation
		$usersObj->fun_addUserEnquiryRelation($enquiry_id, $user_id, "0");
		$propertyObj->fun_updatePropertyEnquiryHideOwnerView($enquiry_id);
	
	} else if(isset($package_credit) && ($package_credit+3) <= 0) {
	/*
	* Case III: if package credit equal to zero and package inquires equal to zero=> Don't insert it in database and disbale property
	********************************************************************************************************************/
		$propertyObj->fun_updatePropertyStatus($property_id, "4", "0"); // suspend property
		$propertyObj->fun_updateOwnerPackageByPropertyId($property_id, "0"); // deactivate owner package
	}
	exit();
?>