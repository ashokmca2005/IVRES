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

if(isset($_GET['fav_id']) && $_GET['fav_id'] !=""){
	$id 		= $_GET['fav_id'];
	$dbObj->deleteRow(TABLE_USER_FAVOURITE_PROPERTIES, "id", $id);
	$strXmlContent .="<favourite>";
	$strXmlContent .="<status>Favourite deleted.</status>\n";
	$strXmlContent .="</favourite>";
} else {
	$strXmlContent .="<favourite>";
	$strXmlContent .="<status>Error.</status>\n";
	$strXmlContent .="</favourite>";
}

$strXml ="";
$strXml .='<?xml version="1.0" encoding="ISO-8859-1"?><favourites>';
$strXml .=$strXmlContent;
$strXml .='</favourites>';
echo $strXml;
?>
