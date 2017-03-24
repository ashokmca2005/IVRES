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
if(isset($_GET['hotpid']) && $_GET['hotpid'] !=""){
	$property_hot_id 	= $_GET['hotpid'];
	$mode		 		= $_GET['mode'];
	$cur_unixtime		= time ();

	if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !=""){
		$cur_user_id 	= $_SESSION['ses_admin_id'];
	} else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !="") {
		$cur_user_id 	= $_SESSION['ses_modarator_id'];
	} else {
		$cur_user_id 	= "";
	}

	switch($mode){
		case 'approve':
			$status 		= 2;
			$active 		= 1;
			$strUpdateQuery = "UPDATE ".TABLE_PROPERTY_HOT_RELATIONS." SET status='$status' WHERE property_hot_id='".$property_hot_id."'";
			if($dbObj->mySqlSafeQuery($strUpdateQuery) == true){
				$strXmlContent .="<hotproperty>";
				$strXmlContent .="<hotpropertystatus>Approved</hotpropertystatus>\n";
				$strXmlContent .="</hotproperty>";
			}
		break;
		case 'decline':
			$status 		= 3;
			$active 		= 0;
			$strUpdateQuery = "UPDATE ".TABLE_PROPERTY_HOT_RELATIONS." SET status='$status' WHERE property_hot_id='".$property_hot_id."'";
			if($dbObj->mySqlSafeQuery($strUpdateQuery) == true){
				$strXmlContent .="<hotproperty>";
				$strXmlContent .="<hotpropertystatus>Declined</hotpropertystatus>\n";
				$strXmlContent .="</hotproperty>";
			}
		break;
		case 'suspend':
			$status 		= 4;
			$active 		= 0;
			$strUpdateQuery = "UPDATE ".TABLE_PROPERTY_HOT_RELATIONS." SET status='$status' WHERE property_hot_id='".$property_hot_id."'";
			if($dbObj->mySqlSafeQuery($strUpdateQuery) == true){
				$strXmlContent .="<hotproperty>";
				$strXmlContent .="<hotpropertystatus>Suspended</hotpropertystatus>\n";
				$strXmlContent .="</hotproperty>";
			}
		break;
	}
} else {
	$strXmlContent .="<hotproperty>";
	$strXmlContent .="<hotpropertystatus>Error.</hotpropertystatus>\n";
	$strXmlContent .="</hotproperty>";
}

$strXml ="";
$strXml .='<?xml version="1.0" encoding="ISO-8859-1"?><hotproperties>';
$strXml .=$strXmlContent;
$strXml .='</hotproperties>';
echo $strXml;
?>
