<?php	
if($_SERVER["SERVER_NAME"] == "localhost") {
	require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
} else {
	require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
}

require_once(SITE_CLASSES_PATH."class.Property.php");
require_once(SITE_CLASSES_PATH."class.Location.php");

$propertyObj 	= new Property();
$locationObj 	= new Location();

echo '('.$propertyObj->fun_countPropertyByDestinations("2,5,14,20,21,33,53,55,56,57,67,72,73,74,81,83,84,97,98,103,105,117,123,132,141,150,151,160,170,171,175,176,182,189,190,195,203,204,215,220,222,240,241,246").')';
?>
