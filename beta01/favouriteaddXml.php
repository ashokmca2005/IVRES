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

if(isset($_GET['property_id']) && ($_GET['property_id'] !="") && isset($_GET['user_id']) && ($_GET['user_id'] !="")){
	$property_id 	= $_GET['property_id'];
	$user_id 		= $_GET['user_id'];
	$cur_unixtime	= time ();
	if(isset($_GET['act']) && $_GET['act'] != "") {
		switch($_GET['act']) {
			case 'del':
				$dbObj->deleteRow(TABLE_USER_FAVOURITE_PROPERTIES, array("user_id", "property_id"), array($user_id, $property_id));
				$strXmlContent .="<favourite>";
				$strXmlContent .="<status>Favourite deleted.</status>\n";
				$strXmlContent .="</favourite>";
			break;
			case 'add':
				$dbObj->insertFields(TABLE_USER_FAVOURITE_PROPERTIES, array("user_id", "property_id", "created_on", "created_by", "updated_on", "updated_by"), array($user_id, $property_id, $cur_unixtime, $user_id, $cur_unixtime, $user_id));
				$strXmlContent .="<favourite>";
				$strXmlContent .="<status>Favourite added.</status>\n";
				$strXmlContent .="</favourite>";
			break;
		}
	}
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
