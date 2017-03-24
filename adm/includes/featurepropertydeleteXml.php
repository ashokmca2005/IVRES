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
if(isset($_GET['prop_id']) && $_GET['prop_id'] !=""){
	$prop_id = $_GET['prop_id'];
	// Step I: Select details of image
	$propertyObj->fun_delProperty($prop_id);
	$strXmlContent .="<feature property>";
	$strXmlContent .="<propertystatus>feature property deleted.</propertystatus>\n";
	$strXmlContent .="</feature property>";
} else {
	$strXmlContent .="<feature property>";
	$strXmlContent .="<propertystatus>Error.</feature propertystatus>\n";
	$strXmlContent .="</feature property>";
}

$strXml ="";
$strXml .='<?xml version="1.0" encoding="ISO-8859-1"?><feature properties>';
$strXml .=$strXmlContent;
$strXml .='</ feature properties>';
echo $strXml;
?>
