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
if(isset($_GET['pid']) && $_GET['pid'] !=""){
	$property_id = $_GET['pid'];
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

	$sql 	= "SELECT * FROM ".TABLE_PROPERTY_ADMIN_REVIEWS." WHERE property_id='".$property_id."'";
	$rs 	= $dbObj->createRecordset($sql);
	if($dbObj->getRecordCount($rs) > 0) {
		$arr 		= $dbObj->fetchAssoc($rs);
		$review_id 	= $arr[0]['review_id'];
		$sqlUpdateQuery = "UPDATE ".TABLE_PROPERTY_ADMIN_REVIEWS." SET reviewed_by = '" . $cur_user_id . "', reviewed_on='" . $cur_unixtime . "' WHERE property_id='".(int)$property_id."'";
		$dbObj->mySqlSafeQuery($sqlUpdateQuery);
	} else {
		$strInsQuery = "INSERT INTO ".TABLE_PROPERTY_ADMIN_REVIEWS."(review_id, property_id, reviewed_on, reviewed_by) ";
		$strInsQuery .= "VALUES(null, '".$property_id."', '".$cur_unixtime."', '".$cur_user_id."')";
		$dbObj->mySqlSafeQuery($strInsQuery);
	}

	switch($mode){
		case 'approve':
			$status 		= 2;
			$active 		= 1;
			$strUpdateQuery = "UPDATE ".TABLE_PROPERTY." SET status='$status', statuschanged_on='$cur_unixtime',  active_on='$cur_unixtime', active_by='$cur_user_id', active='$active' WHERE property_id='".$property_id."'";
			if($dbObj->mySqlSafeQuery($strUpdateQuery) == true){
				$strXmlContent .="<property>";
				$strXmlContent .="<propertystatus>Approved</propertystatus>\n";
				$strXmlContent .="</property>";
			}
		break;
		case 'decline':
			$status 		= 3;
			$active 		= 0;
			$strUpdateQuery = "UPDATE ".TABLE_PROPERTY." SET status='$status', statuschanged_on='$cur_unixtime', active='$active' WHERE property_id='".$property_id."'";
			if($dbObj->mySqlSafeQuery($strUpdateQuery) == true){
				$strXmlContent .="<property>";
				$strXmlContent .="<propertystatus>Declined</propertystatus>\n";
				$strXmlContent .="</property>";
			}
		break;
		case 'suspend':
			$status 		= 4;
			$active 		= 0;
			$strUpdateQuery = "UPDATE ".TABLE_PROPERTY." SET status='$status', statuschanged_on='$cur_unixtime', active='$active' WHERE property_id='".$property_id."'";
			if($dbObj->mySqlSafeQuery($strUpdateQuery) == true){
				$strXmlContent .="<property>";
				$strXmlContent .="<propertystatus>Suspended</propertystatus>\n";
				$strXmlContent .="</property>";
			}
		break;
	}
}
else{
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
