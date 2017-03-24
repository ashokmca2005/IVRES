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
require_once(SITE_CLASSES_PATH."class.Travel.php");

$dbObj = new DB();
$dbObj->fun_db_connect();
$tvlguidObj 		= new Travel();

$strXml ="";
$strXmlContent ="";
if(isset($_GET['tvlguidid']) && $_GET['tvlguidid'] !=""){
	$tvlguidid 	= $_GET['tvlguidid'];
	$featured 	= $_GET['featured'];

	$tvlguidObj->fun_updateTvlGuidFeature($tvlguidid, $featured);
	$strXmlContent .="<tvlguid>";
	$strXmlContent .="<tvlguidfeature>Travel guide updated.</tvlguidfeature>\n";
	$strXmlContent .="</tvlguid>";
} else {
	$strXmlContent .="<tvlguid>";
	$strXmlContent .="<tvlguidfeature>Error.</tvlguidfeature>\n";
	$strXmlContent .="</tvlguid>";
}

$strXml ="";
$strXml .='<?xml version="1.0" encoding="ISO-8859-1"?><tvlguids>';
$strXml .=$strXmlContent;
$strXml .='</tvlguids>';
echo $strXml;
?>
