<?php	
	if($_SERVER["SERVER_NAME"] == "localhost") {
		require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
	} else {
		require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
	}

	require_once(SITE_CLASSES_PATH."class.Property.php");
	$propertyObj 	= new Property();

if(isset($_GET['pid']) && $_GET['pid'] !="" && isset($_GET['frm']) && $_GET['frm'] !=""){
	$property_id= $_GET['pid'];
	$date_from 	= $_GET['frm'];
	$date_to 	= $_GET['dep'];
	$mindays 	= $_GET['stay'];
	$currency_code 	= $_GET['currency_code'];
	$propertyObj->fun_createPropertyBookTrip($property_id, $date_from, $date_to, $mindays, $currency_code); 
} else {
	echo "Invalid input";
}
