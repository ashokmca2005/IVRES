<?php	
	if($_SERVER["SERVER_NAME"] == "localhost") {
		require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
	} else {
		require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
	}
	require_once(SITE_CLASSES_PATH."class.Property.php");
	$propertyObj 	= new Property();
	$friendly_link 	= $_GET['friendly_link'];
	$property_id 	= $_GET['pid'];
	
	if((isset($friendly_link) && $friendly_link !="")){
		if($propertyObj->fun_checkAvailabilityPropertyUrl($property_id, $friendly_link)){
			echo "No";
		} else {
			echo "Yes";
		}
	}
?>