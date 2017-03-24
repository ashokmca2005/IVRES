<?php
header('Content-Type: text/xml');
header("Cache-Control: no-cache, must-revalidate");
//A date in the past
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

if($_SERVER["SERVER_NAME"] == "localhost") {
	require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/includes/application-top.php");
} else if ($_SERVER["SERVER_NAME"] == "projects.idns-technologies.info") {
	require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/includes/application-top.php");
} else {
	require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
}
require_once(SITE_CLASSES_PATH."class.CMS.php");

$dbObj 		= new DB();
$cmsObj     = new Cms();
$dbObj->fun_db_connect();

$strXml ="";
$strXmlContent ="";
if(isset($_GET['page_id']) && $_GET['page_id'] !=""){
	$page_id = $_GET['page_id'];
	// Step I: Select details of image
	$cmsObj->fun_delPages($page_id);
	$strXmlContent .="<page>";
	$strXmlContent .="<pagestatus>page deleted.</pagestatus>\n";
	$strXmlContent .="</page>";
} else {
	$strXmlContent .="<page>";
	$strXmlContent .="<pagestatus>Error.</pagestatus>\n";
	$strXmlContent .="</page>";
}

$strXml ="";
$strXml .='<?xml version="1.0" encoding="ISO-8859-1"?><pages>';
$strXml .=$strXmlContent;
$strXml .='</pages>';
echo $strXml;
?>
