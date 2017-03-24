<?php
header('Content-Type: text/xml');
header("Cache-Control: no-cache, must-revalidate");
//A date in the past
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

if($_SERVER["SERVER_NAME"] == "localhost") {
		require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
	} else {
		require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
	}
require_once(SITE_CLASSES_PATH."class.Users.php");
require_once(SITE_CLASSES_PATH."class.Event.php");

$dbObj = new DB();
$dbObj->fun_db_connect();
$eventObj 		= new Event();

$strXml ="";
$strXmlContent ="";
if(isset($_GET['evtid']) && $_GET['evtid'] !=""){
	$evtid = $_GET['evtid'];

	// Step I: Select details of image
	$eventObj->fun_delEventTemp($evtid); // delete all records

	$strXmlContent .="<event>";
	$strXmlContent .="<eventstatus>Event deleted.</eventstatus>\n";
	$strXmlContent .="</event>";
}
else{
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
