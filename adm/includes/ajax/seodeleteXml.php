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

require_once(SITE_CLASSES_PATH."class.Seo.php");

$dbObj 		= new DB();
$seoObj		= new Seo();
$dbObj->fun_db_connect();

$strXml 		= "";
$strXmlContent 	= "";
if(isset($_GET['seo_id']) && $_GET['seo_id'] !=""){
	$seo_id 	= $_GET['seo_id'];
	// Step I: Select details of image
	$seoObj->fun_delSeo($seo_id);
	$strXmlContent .="<seo>";
	$strXmlContent .="<seostatus>seo deleted.</seostatus>\n";
	$strXmlContent .="</seo>";
} else {
	$strXmlContent .="<seo>";
	$strXmlContent .="<seostatus>Error.</seostatus>\n";
	$strXmlContent .="</seo>";
}

$strXml ="";
$strXml .='<?xml version="1.0" encoding="ISO-8859-1"?><seos>';
$strXml .=$strXmlContent;
$strXml .='</seos>';
echo $strXml;
?>
