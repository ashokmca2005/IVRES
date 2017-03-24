<?php	
	if($_SERVER["SERVER_NAME"] == "localhost") {
		require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
	} else {
		require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
	}
	require_once(SITE_CLASSES_PATH."class.Property.php");
	$propertyObj 	= new Property();
	$property_id 	= $_GET['pid'];
	$arrival_date 	= $_GET['frm'];
	$departure_date = $_GET['to'];

	if($propertyObj->fun_checkBookingAvailability($property_id, $arrival_date, $departure_date) === false) { // if false
		echo trim("No");
	} else {
		echo trim("Yes");
	}
?>