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
require_once(SITE_CLASSES_PATH."class.Event.php");

$dbObj = new DB();
$eventObj = new Event();
$dbObj->fun_db_connect();
$strXml ="";
$strXmlContent ="";
if(isset($_GET['event_id']) && $_GET['event_id'] !=""){
	$event_id = $_GET['event_id'];
	// Step I: Select details of image
	$eventObj ->fun_delevents($event_id);


	$strXmlContent .="<event>";
	$strXmlContent .="<eventstatus>event deleted.</eventstatus>\n";
	$strXmlContent .="</event>";
} else {
	$strXmlContent .="<event>";
	$strXmlContent .="<eventstatus>Error.</eventstatus>\n";
	$strXmlContent .="</event>";
}

$strXml ="";
$strXml .='<?xml version="1.0" encoding="ISO-8859-1"?><events>';
$strXml .=$strXmlContent;
$strXml .='</events>';
echo $strXml;
?>
