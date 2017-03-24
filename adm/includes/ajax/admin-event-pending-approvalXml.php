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
if(isset($_GET['evntid']) && $_GET['evntid'] !=""){
	$event_id = $_GET['evntid'];
	$mode		 = $_GET['mode']; //approve
	$cur_unixtime	= time ();
	if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !=""){
		$cur_user_id 	= $_SESSION['ses_admin_id'];
	}
	else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !=""){
		$cur_user_id 	= $_SESSION['ses_modarator_id'];
	}
	else{
		$cur_user_id 	= "";
	}
/*
	$sql 	= "SELECT * FROM ".TABLE_EVENTS."_admin_reviews WHERE event_id='".$event_id."'";
	$rs 	= $dbObj->createRecordset($sql);
	if($dbObj->getRecordCount($rs) > 0) {
		$arr 		= $dbObj->fetchAssoc($rs);
		$review_id 	= $arr[0]['review_id'];
		$sqlUpdateQuery = "UPDATE ".TABLE_EVENTS."_admin_reviews SET reviewed_by = '" . $cur_user_id . "', reviewed_on='" . $cur_unixtime . "' WHERE event_id='".(int)$event_id."'";
		$dbObj->mySqlSafeQuery($sqlUpdateQuery);
	} else {
		$strInsQuery = "INSERT INTO ".TABLE_EVENTS."_admin_reviews(review_id, event_id, reviewed_on, reviewed_by) ";
		$strInsQuery .= "VALUES(null, '".$event_id."', '".$cur_unixtime."', '".$cur_user_id."')";
		$dbObj->mySqlSafeQuery($strInsQuery);
	}
*/
	switch($mode){
		case 'approve':
			$status 		= 2;
			$active 		= 1;
			$strUpdateQuery = "UPDATE ".TABLE_EVENTS." SET status='$status', active_on='$cur_unixtime', active_by='$cur_user_id', active='$active' WHERE event_id='".$event_id."'";
			if($dbObj->mySqlSafeQuery($strUpdateQuery) == true){
				$strXmlContent .="<event>";
				$strXmlContent .="<eventstatus>Approved</eventstatus>\n";
				$strXmlContent .="</event>";
			}
		break;
		case 'decline':
			$status 		= 3;
			$active 		= 0;
			$strUpdateQuery = "UPDATE ".TABLE_EVENTS." SET status='$status', active_on='$cur_unixtime', active_by='$cur_user_id', active='$active' WHERE event_id='".$event_id."'";
			if($dbObj->mySqlSafeQuery($strUpdateQuery) == true){
				$strXmlContent .="<event>";
				$strXmlContent .="<eventstatus>Declined</eventstatus>\n";
				$strXmlContent .="</event>";
			}
		break;
		case 'suspend':
			$status 		= 4;
			$active 		= 0;
			$strUpdateQuery = "UPDATE ".TABLE_EVENTS." SET status='$status', active_on='$cur_unixtime', active_by='$cur_user_id', active='$active' WHERE event_id='".$event_id."'";
			if($dbObj->mySqlSafeQuery($strUpdateQuery) == true){
				$strXmlContent .="<event>";
				$strXmlContent .="<eventstatus>Suspended</eventstatus>\n";
				$strXmlContent .="</event>";
			}
		break;
	}
}
else{
	$strXmlContent .="<event>";
	$strXmlContent .="<eventstatus>Error.</eventstatus>\n";
	$strXmlContent .="</event>";
}

$strXml ="";
$strXml .='<?xml version="1.0" encoding="ISO-8859-1"?><events>';
$strXml .=$strXmlContent;
$strXml .='</events>';
echo $strXml;
?>
