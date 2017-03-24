<?php
header('Content-Type: text/xml');
header("Cache-Control: no-cache, must-revalidate");
//A date in the past
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

if($_SERVER["SERVER_NAME"] == "localhost") {
	require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/includes/application-top.php");
} else {
	require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
}
require_once(SITE_CLASSES_PATH."class.Property.php");
require_once(SITE_CLASSES_PATH."class.Users.php");

$dbObj 			= new DB();
$usersObj 		= new Users();
$propertyObj	= new Property();
$dbObj->fun_db_connect();

$strXml 		= "";
$strXmlContent 	= "";
if(isset($_GET['id']) && $_GET['id'] !=""){
	$id = $_GET['id'];
	$backlinkstatus = $propertyObj->fun_validatePropertyBackLink($id);
	$strXmlContent .="<backlink>";
	$strXmlContent .="<backlinkstatus>".$backlinkstatus."</backlinkstatus>\n";
	$strXmlContent .="</backlink>";
} else {
	$strXmlContent .="<backlink>";
	$strXmlContent .="<backlinkstatus>invalid</backlinkstatus>\n";
	$strXmlContent .="</backlink>";
}

$strXml ="";
$strXml .='<?xml version="1.0" encoding="ISO-8859-1"?><backlinks>';
$strXml .=$strXmlContent;
$strXml .='</backlinks>';
echo $strXml;
?>
