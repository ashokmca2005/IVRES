<?php	
	if($_SERVER["SERVER_NAME"] == "localhost") {
		require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
	} else {
		require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
	}
	require_once(SITE_CLASSES_PATH."class.Users.php");
	require_once(SITE_CLASSES_PATH."class.Property.php");
	require_once(SITE_CLASSES_PATH."class.Event.php");
	require_once(SITE_CLASSES_PATH."class.CMS.php");

	$usersObj 		= new Users();
	$propertyObj 	= new Property();
	$cmsObj         = new Cms();
	$eventObj 		= new Event();
	
?>
