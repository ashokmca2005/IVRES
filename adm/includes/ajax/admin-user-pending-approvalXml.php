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
if(isset($_GET['usrid']) && $_GET['usrid'] !=""){
	$user_id 		= $_GET['usrid'];
	$mode		 	= $_GET['mode']; //approve
	switch($mode){
		case 'approve':
			$user_status 	= 1;
			$strUpdateQuery = "UPDATE ".TABLE_USERS." SET user_status='$user_status' WHERE user_id='".$user_id."'";
			if($dbObj->mySqlSafeQuery($strUpdateQuery) == true){
				$strXmlContent .="<user>";
				$strXmlContent .="<userstatus>Approved</userstatus>\n";
				$strXmlContent .="</user>";
			}
		break;
		case 'decline':
			$user_status 	= 0;
			$strUpdateQuery = "UPDATE ".TABLE_USERS." SET user_status='$user_status' WHERE user_id='".$user_id."'";
			if($dbObj->mySqlSafeQuery($strUpdateQuery) == true){
				$strXmlContent .="<user>";
				$strXmlContent .="<userstatus>Declined</userstatus>\n";
				$strXmlContent .="</user>";
			}
		break;
		case 'suspend':
			$user_status 	= 0;
			$strUpdateQuery = "UPDATE ".TABLE_USERS." SET user_status='$user_status' WHERE user_id='".$user_id."'";
			if($dbObj->mySqlSafeQuery($strUpdateQuery) == true){
				$strXmlContent .="<user>";
				$strXmlContent .="<userstatus>Suspended</userstatus>\n";
				$strXmlContent .="</user>";
			}
		break;
		case 'delete':
			$user_status 	= 0;
			$strUpdateQuery = "UPDATE ".TABLE_USERS." SET user_status='$user_status' WHERE user_id='".$user_id."'";
			if($dbObj->mySqlSafeQuery($strUpdateQuery) == true){
				$strXmlContent .="<user>";
				$strXmlContent .="<userstatus>Deleted</userstatus>\n";
				$strXmlContent .="</user>";
			}
		break;
	}
} else {
	$strXmlContent .="<user>";
	$strXmlContent .="<userstatus>Error.</userstatus>\n";
	$strXmlContent .="</user>";
}

$strXml ="";
$strXml .='<?xml version="1.0" encoding="ISO-8859-1"?><users>';
$strXml .=$strXmlContent;
$strXml .='</users>';
echo $strXml;
?>
