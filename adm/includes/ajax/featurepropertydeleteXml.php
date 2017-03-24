<?php
header('Content-Type: text/xml');
header("Cache-Control: no-cache, must-revalidate");
//A date in the past
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

if($_SERVER["SERVER_NAME"] == "localhost") {
	require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/includes/application-top.php");
} else if ($_SERVER["SERVER_NAME"] == "projects.idns-technologies.com") {
	require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/includes/application-top.php");
} else {
	require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
}
require_once(SITE_CLASSES_PATH."class.Property.php");

$dbObj = new DB();
$propertyObj=new Property();
$dbObj->fun_db_connect();
$strXml ="";
$strXmlContent ="";
if(isset($_GET['property_hot_id']) && $_GET['property_hot_id'] !=""){
	$id = $_GET['property_hot_id'];
	// Step I: Select details of image
	$propertyObj->fun_delhotProperty($property_hot_id);


	$strXmlContent .="<featureproperty>";
	$strXmlContent .="<featurepropertystatus>featureproperty deleted.</featurepropertystatus>\n";
	$strXmlContent .="</featureproperty>";
} else {
	$strXmlContent .="<featureproperty>";
	$strXmlContent .="<featurepropertystatus>Error.</featurepropertystatus>\n";
	$strXmlContent .="</featureproperty>";
}

$strXml ="";
$strXml .='<?xml version="1.0" encoding="ISO-8859-1"?><featureproperties>';
$strXml .=$strXmlContent;
$strXml .='</featureproperties>';
echo $strXml;
?>
