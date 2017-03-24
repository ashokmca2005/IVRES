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
if(isset($_GET['vid']) && $_GET['vid'] !=""){
	$vid = $_GET['vid'];
	// Step III: Delete records from database
	$strDelteQuery = "DELETE FROM ".TABLE_PROPERTY_VIDEO_ALL." WHERE video_id='$vid'";
	$dbObj->mySqlSafeQuery($strDelteQuery);

	$strXmlContent .="<video>";
	$strXmlContent .="<videostatus>Video deleted.</videostatus>\n";
	$strXmlContent .="</video>";
}
else{
	$strXmlContent .="<video>";
	$strXmlContent .="<videostatus>Error.</videostatus>\n";
	$strXmlContent .="</video>";
}

$strXml ="";
$strXml .='<?xml version="1.0" encoding="ISO-8859-1"?><videos>';
$strXml .=$strXmlContent;
$strXml .='</videos>';
echo $strXml;
?>
