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

$usersObj 		= new Users();
$propertyObj 	= new Property();
$strXml ="";
$strXmlContent ="";
if(isset($_GET['booking_id']) && $_GET['booking_id'] !=""){
	$booking_id = $_GET['booking_id'];
	
	if(isset($_GET['owner_id']) && $_GET['owner_id'] !="") {
		$owner_id = $_GET['owner_id'];
		$propertyObj-> fun_delBookingOwner($booking_id);
	} else if(isset($_GET['customer_id']) && $_GET['customer_id'] != "") {
		$customer_id = $_GET['customer_id'];
		$propertyObj->fun_delBookingCustomer($booking_id);
	}

	$strXmlContent .="<booking>";
	$strXmlContent .="<bookingstatus>booking deleted.</bookingstatus>\n";
	$strXmlContent .="</booking>";
} else {
	$strXmlContent .="<booking>";
	$strXmlContent .="<bookingstatus>Error.</bookingstatus>\n";
	$strXmlContent .="</booking>";
}

$strXml ="";
$strXml .='<?xml version="1.0" encoding="ISO-8859-1"?><bookings>';
$strXml .=$strXmlContent;
$strXml .='</bookings>';
echo $strXml;
?>
