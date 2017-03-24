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
if(isset($_GET['reviewid']) && $_GET['reviewid'] !=""){
	$review_id = $_GET['reviewid'];
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
	switch($mode){
		case 'approve':
			$status 		= 2;
			$active 		= 1;
			$strUpdateQuery = "UPDATE ".TABLE_PROPERTY_REVIEWS_RELATIONS." SET status='$status', active_on='$cur_unixtime', active_by='$cur_user_id', active='$active' WHERE review_id='".$review_id."'";
			if($dbObj->mySqlSafeQuery($strUpdateQuery) == true){
				$strXmlContent .="<review>";
				$strXmlContent .="<reviewstatus>Approved</reviewstatus>\n";
				$strXmlContent .="</review>";
			}
		break;
		case 'decline':
			$status 		= 3;
			$active 		= 0;
			$strUpdateQuery = "UPDATE ".TABLE_PROPERTY_REVIEWS_RELATIONS." SET status='$status', active_on='$cur_unixtime', active_by='$cur_user_id', active='$active' WHERE review_id='".$review_id."'";
			if($dbObj->mySqlSafeQuery($strUpdateQuery) == true){
				$strXmlContent .="<review>";
				$strXmlContent .="<reviewstatus>Declined</reviewstatus>\n";
				$strXmlContent .="</review>";
			}
		break;
		case 'suspend':
			$status 		= 4;
			$active 		= 0;
			$strUpdateQuery = "UPDATE ".TABLE_PROPERTY_REVIEWS_RELATIONS." SET status='$status', active_on='$cur_unixtime', active_by='$cur_user_id', active='$active' WHERE review_id='".$review_id."'";
			if($dbObj->mySqlSafeQuery($strUpdateQuery) == true){
				$strXmlContent .="<review>";
				$strXmlContent .="<reviewstatus>Suspended</reviewstatus>\n";
				$strXmlContent .="</review>";
			}
		break;
	}
}
else{
	$strXmlContent .="<review>";
	$strXmlContent .="<reviewstatus>Error.</reviewstatus>\n";
	$strXmlContent .="</review>";
}

$strXml ="";
$strXml .='<?xml version="1.0" encoding="ISO-8859-1"?><reviews>';
$strXml .=$strXmlContent;
$strXml .='</reviews>';
echo $strXml;
?>
