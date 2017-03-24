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
require_once(SITE_CLASSES_PATH."class.Property.php");

$dbObj = new DB();
$dbObj->fun_db_connect();
$propertyObj 	= new Property();

$strXml ="";
$strXmlContent ="";
if(isset($_GET['enquiry']) && $_GET['enquiry'] !=""){
	$enquiry_id = $_GET['enquiry'];
	// Step I: Select details of image
	$propertyObj->fun_delPropertyEnquiry($enquiry_id); // delete all records

	$strXmlContent .="<enquiry>";
	$strXmlContent .="<enquirystatus>Enquiry deleted.</enquirystatus>\n";
	$strXmlContent .="</enquiry>";
} else {
	$strXmlContent .="<enquiry>";
	$strXmlContent .="<enquirystatus>Error.</enquirystatus>\n";
	$strXmlContent .="</enquiry>";
}

$strXml ="";
$strXml .='<?xml version="1.0" encoding="ISO-8859-1"?><enquiries>';
$strXml .=$strXmlContent;
$strXml .='</enquiries>';
echo $strXml;
?>
