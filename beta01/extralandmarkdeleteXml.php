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
	$landmark_id = $_GET['id'];
	// Step III: Delete records from database
	$strDelteQuery = "DELETE FROM ". TABLE_PROPERTY_EXTRA_LANDMARKS ." WHERE landmark_id='".$landmark_id."'";
	$dbObj->mySqlSafeQuery($strDelteQuery);
	$strXmlContent .="<landmark>";
	$strXmlContent .="<landmarkstatus>Landmark deleted.</landmarkstatus>\n";
	$strXmlContent .="</landmark>";
}
else{
	$strXmlContent .="<landmark>";
	$strXmlContent .="<landmarkstatus>Error.</landmarkstatus>\n";
	$strXmlContent .="</landmark>";
}

$strXml ="";
$strXml .='<?xml version="1.0" encoding="ISO-8859-1"?><landmarks>';
$strXml .=$strXmlContent;
$strXml .='</landmarks>';
echo $strXml;
?>
