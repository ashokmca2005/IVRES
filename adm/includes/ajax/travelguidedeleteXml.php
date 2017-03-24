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
require_once(SITE_CLASSES_PATH."class.Travel.php");

$dbObj 		= new DB();
$tvlguidObj	= new Travel();
$dbObj->fun_db_connect();

$strXml ="";
$strXmlContent ="";
if(isset($_GET['trvl_guid_id']) && $_GET['trvl_guid_id'] !=""){
	$id = $_GET['trvl_guid_id'];
	// Step I: Select details of image
	$tvlguidObj->fun_delTravelGuides($id);
	$strXmlContent .="<travelguide>";
	$strXmlContent .="<travelguidestatus>travelguide deleted.</travelguidestatus>\n";
	$strXmlContent .="</travelguide>";
} else {
	$strXmlContent .="<travelguide>";
	$strXmlContent .="<travelguidestatus>Error.</travelguidestatus>\n";
	$strXmlContent .="</travelguide>";
}

$strXml ="";
$strXml .='<?xml version="1.0" encoding="ISO-8859-1"?><travelguides>';
$strXml .=$strXmlContent;
$strXml .='</travelguides>';
echo $strXml;
?>
