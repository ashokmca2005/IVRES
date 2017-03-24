<?php
session_start();
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
if(isset($_GET['curcode']) && $_GET['curcode'] !=""){
	$currencyCode 	= $_GET['curcode'];

	// Step I: find if user is logged in update / insert in database user currency setting table
	if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] != "") {
		$user_id = $_SESSION['ses_user_id'];
		$strSelectQuery = "SELECT * FROM ".TABLE_USER_CURRENCY_SETTINGS." WHERE user_id='".$user_id."'";
		$rs = $dbObj->createRecordset($strSelectQuery);
		if($dbObj->getRecordCount($rs) > 0){
			$strUpdateQuery = "UPDATE ".TABLE_USER_CURRENCY_SETTINGS." SET currency_code='".$currencyCode."' WHERE user_id='".$user_id."'";
			$dbObj->mySqlSafeQuery($strUpdateQuery);
		} else {
			$strInsertQuery = "INSERT INTO ".TABLE_USER_CURRENCY_SETTINGS."(currency_setting_id, user_id, currency_code) VALUES(null, '".$user_id."', '".$currencyCode."')";
			$dbObj->mySqlSafeQuery($strInsertQuery);
		}
	} else {
		$_SESSION['ses_user_cur_code'] = $currencyCode;
	}
	$strXmlContent .="<currency>";
	$strXmlContent .="<currencystatus>currency updated</currencystatus>\n";
	$strXmlContent .="</currency>";
} else {
	$strXmlContent .="<currency>";
	$strXmlContent .="<currencystatus>Error</currencystatus>\n";
	$strXmlContent .="</currency>";
}

$strXml ="";
$strXml .='<?xml version="1.0" encoding="ISO-8859-1"?><currencies>';
$strXml .=$strXmlContent;
$strXml .='</currencies>';
echo $strXml;
?>
