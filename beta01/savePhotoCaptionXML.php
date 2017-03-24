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
if(isset($_GET['imgid']) && $_GET['imgid'] !=""){
	$imgid 		= $_GET['imgid'];
	$caption 	= $_GET['caption'];
	$dbObj->updateField(TABLE_PROPERTY_PHOTO_ALL, "photo_id", $imgid, "photo_caption", $caption);
	$strXmlContent .="<photo>";
	$strXmlContent .="<status>Caption updated.</status>\n";
	$strXmlContent .="</photo>";
} else {
	$strXmlContent .="<photo>";
	$strXmlContent .="<status>Error.</status>\n";
	$strXmlContent .="</photo>";
}

$strXml ="";
$strXml .='<?xml version="1.0" encoding="ISO-8859-1"?><photos>';
$strXml .=$strXmlContent;
$strXml .='</photos>';
echo $strXml;
?>
