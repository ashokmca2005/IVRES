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

if(isset($_GET['id']) && $_GET['id'] !=""){
	$id 		= $_GET['id'];
	$dbObj->deleteRow(TABLE_PROPERTY_CONTACT_LANGUAGES, "id", $id);
	$strXmlContent .="<contact>";
	$strXmlContent .="<status>Contact deleted.</status>\n";
	$strXmlContent .="</contact>";
} else {
	$strXmlContent .="<contact>";
	$strXmlContent .="<status>Error.</status>\n";
	$strXmlContent .="</contact>";
}

$strXml ="";
$strXml .='<?xml version="1.0" encoding="ISO-8859-1"?><contacts>';
$strXml .=$strXmlContent;
$strXml .='</contacts>';
echo $strXml;
?>
