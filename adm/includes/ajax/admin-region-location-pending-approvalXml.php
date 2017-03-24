<?php
session_start();
header('Content-Type: text/xml');
header("Cache-Control: no-cache, must-revalidate");
//A date in the past
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

require_once("../../includes/common.php");
require_once("../../includes/database-table.php");
require_once("../../includes/classes/class.DB.php");
require_once("../../includes/functions/general.php");

$dbObj = new DB();
$dbObj->fun_db_connect();

$strXml ="";
$strXmlContent ="";

$location_id 	= $_GET['location_id'];
$region_id 		= $_GET['region_id'];
$mode		 	= $_GET['mode']; //approve
if(isset($location_id) && $location_id !="" && isset($region_id) && $region_id !=""){
	switch($mode){
		case 'approve':
			$status 		= 2;
			$strUpdateRegionQuery = "UPDATE ".TABLE_REGION." SET status='$status' WHERE region_id='".$region_id."'";
			$strUpdateLocationQuery = "UPDATE ".TABLE_LOCATION." SET status='$status' WHERE location_id='".$location_id."'";
			$dbObj->mySqlSafeQuery($strUpdateLocationQuery);
			$dbObj->mySqlSafeQuery($strUpdateRegionQuery);
			$strXmlContent .="<property>";
			$strXmlContent .="<propertystatus>Approved</propertystatus>\n";
			$strXmlContent .="</property>";
		break;
	}
} else if(isset($location_id) && $location_id !=""){
	switch($mode){
		case 'approve':
			$status 		= 2;
			$strUpdateLocationQuery = "UPDATE ".TABLE_LOCATION." SET status='$status' WHERE location_id='".$location_id."'";
			$dbObj->mySqlSafeQuery($strUpdateLocationQuery);
			$strXmlContent .="<property>";
			$strXmlContent .="<propertystatus>Approved</propertystatus>\n";
			$strXmlContent .="</property>";
		break;
	}
} else if(isset($region_id) && $region_id !=""){
	switch($mode){
		case 'approve':
			$status 		= 2;
			$strUpdateRegionQuery = "UPDATE ".TABLE_REGION." SET status='$status' WHERE region_id='".$region_id."'";
			$dbObj->mySqlSafeQuery($strUpdateRegionQuery);
			$strXmlContent .="<property>";
			$strXmlContent .="<propertystatus>Approved</propertystatus>\n";
			$strXmlContent .="</property>";
		break;
	}
} else {
	$strXmlContent .="<property>";
	$strXmlContent .="<propertystatus>Error.</propertystatus>\n";
	$strXmlContent .="</property>";
}

$strXml ="";
$strXml .='<?xml version="1.0" encoding="ISO-8859-1"?><properties>';
$strXml .=$strXmlContent;
$strXml .='</properties>';
echo $strXml;
?>
