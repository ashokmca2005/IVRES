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
require_once(SITE_CLASSES_PATH."class.Banner.php");

$dbObj 		= new DB();
$bannerObj  = new Banner();
$dbObj->fun_db_connect();

$strXml ="";
$strXmlContent ="";
if(isset($_GET['banner_id']) && $_GET['banner_id'] !=""){
	$banner_id = $_GET['banner_id'];
	// Step I: Select details of image
	$bannerObj->fun_delBanner($banner_id);
	$strXmlContent .="<banner>";
	$strXmlContent .="<bannerstatus>banner deleted.</bannerstatus>\n";
	$strXmlContent .="</banner>";
} else {
	$strXmlContent .="<banner>";
	$strXmlContent .="<bannerstatus>Error.</bannerstatus>\n";
	$strXmlContent .="</banner>";
}

$strXml ="";
$strXml .='<?xml version="1.0" encoding="ISO-8859-1"?><banners>';
$strXml .=$strXmlContent;
$strXml .='</banners>';
echo $strXml;
?>
