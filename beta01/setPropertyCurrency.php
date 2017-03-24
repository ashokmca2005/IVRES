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

if(isset($_GET['pid']) && $_GET['pid'] !=""){
	$property_id 		= $_GET['pid'];
	$currency_code 		= $_GET['curcode'];
	$dbObj->updateField(TABLE_PROPERTY_PRICES, "property_id", $property_id, "currency_code", $currency_code);
	$strXmlContent .="<currency>";
	$strXmlContent .="<status>Price deleted.</status>\n";
	$strXmlContent .="</currency>";
} else {
	$strXmlContent .="<currency>";
	$strXmlContent .="<status>Error.</status>\n";
	$strXmlContent .="</currency>";
}

$strXml ="";
$strXml .='<?xml version="1.0" encoding="ISO-8859-1"?><currencys>';
$strXml .=$strXmlContent;
$strXml .='</currencys>';
echo $strXml;
?>
