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
if(isset($_GET['latedealid']) && $_GET['latedealid'] !=""){
	$latedealid 		= $_GET['latedealid'];
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
			$strUpdateQuery = "UPDATE ".TABLE_PROPERTY_SPECIAL_DEALS_RELATIONS." SET status='$status' WHERE id='".$latedealid."'";
			if($dbObj->mySqlSafeQuery($strUpdateQuery) == true){
				$strXmlContent .="<latedeal>";
				$strXmlContent .="<latedealstatus>Approved</latedealstatus>\n";
				$strXmlContent .="</latedeal>";
			}
		break;
		case 'decline':
			$status 		= 3;
			$active 		= 0;
			$strUpdateQuery = "UPDATE ".TABLE_PROPERTY_SPECIAL_DEALS_RELATIONS." SET status='$status' WHERE id='".$latedealid."'";
			if($dbObj->mySqlSafeQuery($strUpdateQuery) == true){
				$strXmlContent .="<latedeal>";
				$strXmlContent .="<latedealstatus>Declined</latedealstatus>\n";
				$strXmlContent .="</latedeal>";
			}
		break;
		case 'suspend':
			$status 		= 4;
			$active 		= 0;
			$strUpdateQuery = "UPDATE ".TABLE_PROPERTY_SPECIAL_DEALS_RELATIONS." SET status='$status' WHERE id='".$latedealid."'";
			if($dbObj->mySqlSafeQuery($strUpdateQuery) == true){
				$strXmlContent .="<latedeal>";
				$strXmlContent .="<latedealstatus>Suspended</latedealstatus>\n";
				$strXmlContent .="</latedeal>";
			}
		break;
	}
} else {
	$strXmlContent .="<latedeal>";
	$strXmlContent .="<latedealstatus>Error.</latedealstatus>\n";
	$strXmlContent .="</latedeal>";
}

$strXml ="";
$strXml .='<?xml version="1.0" encoding="ISO-8859-1"?><latedeals>';
$strXml .=$strXmlContent;
$strXml .='</latedeals>';
echo $strXml;
?>
