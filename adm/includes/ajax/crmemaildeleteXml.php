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
require_once(SITE_CLASSES_PATH."class.Users.php");

$dbObj 		= new DB();
$usersObj 	= new Users();
$dbObj->fun_db_connect();

$strXml ="";
$strXmlContent ="";
if(isset($_GET['id']) && $_GET['id'] !=""){
	$id = $_GET['id'];
	// Step I: Select details of image
	$usersObj->fun_delUserNewsLetter($id);
	$strXmlContent .="<newsletter>";
	$strXmlContent .="<newsletterstatus>newsletter deleted.</newsletterstatus>\n";
	$strXmlContent .="</newsletter>";
} else {
	$strXmlContent .="<newsletter>";
	$strXmlContent .="<newsletterstatus>Error.</newsletterstatus>\n";
	$strXmlContent .="</newsletter>";
}

$strXml ="";
$strXml .='<?xml version="1.0" encoding="ISO-8859-1"?><newsletters>';
$strXml .=$strXmlContent;
$strXml .='</newsletters>';
echo $strXml;
?>
