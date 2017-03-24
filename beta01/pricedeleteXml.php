<?php
header('Content-Type: text/xml');
header("Cache-Control: no-cache, must-revalidate");
//A date in the past
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
require_once("adm/includes/common.php");
require_once("adm/includes/database-table.php");
require_once("adm/includes/classes/class.DB.php");
require_once("adm/includes/functions/general.php");
$dbObj = new DB();
$dbObj->fun_db_connect();
$strXml ="";
$strXmlContent ="";

if(isset($_GET['priceid']) && $_GET['priceid'] !=""){
	$priceid 		= $_GET['priceid'];
	$dbObj->deleteRow(TABLE_PROPERTY_PRICES, "id", $priceid);
	$strXmlContent .="<price>";
	$strXmlContent .="<status>Price deleted.</status>\n";
	$strXmlContent .="</price>";
} else {
	$strXmlContent .="<price>";
	$strXmlContent .="<status>Error.</status>\n";
	$strXmlContent .="</price>";
}

$strXml ="";
$strXml .='<?xml version="1.0" encoding="ISO-8859-1"?><prices>';
$strXml .=$strXmlContent;
$strXml .='</prices>';
echo $strXml;
?>
