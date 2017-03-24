<?php
session_start();
ob_start();
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

$strXml 					= "";
$strXmlContent 				= "";
$_SESSION['ses_user_id'] 	= "";
$_SESSION['ses_user_fname'] = "";
$_SESSION['ses_user_email'] = "";
$_SESSION['ses_user_pass'] 	= "";
$_SESSION['ses_user_home'] 	= "";

if(isset($_GET['usrid']) && $_GET['usrid'] !=""){
	$user_id 		= $_GET['usrid'];
	$sql 			= "SELECT * FROM " . TABLE_USERS . " WHERE user_id='".(int)fun_db_input($user_id)."' ";
	$result 		= $dbObj->fun_db_query($sql);

	if($dbObj->fun_db_get_num_rows($result) > 0){
		$rowsArray = $dbObj->fun_db_fetch_rs_object($result);
		if(isset($rowsArray->is_owner) && ($rowsArray->is_owner == "1")){
			$_SESSION['ses_user_id'] 	= $rowsArray->user_id;
			$_SESSION['ses_user_fname'] = $rowsArray->user_fname;
			$_SESSION['ses_user_email'] = $rowsArray->user_email;
			$_SESSION['ses_user_pass'] 	= $rowsArray->user_pass;
			$_SESSION['ses_user_home'] 	= SITE_URL."owner-home";

			$strXmlContent .="<user>";
			$strXmlContent .="<userstatus>Success.</userstatus>\n";
			$strXmlContent .="</user>";
		} else {
			$strXmlContent .="<user>";
			$strXmlContent .="<userstatus>Error.</userstatus>\n";
			$strXmlContent .="</user>";
		}
	} else {
		$strXmlContent .="<user>";
		$strXmlContent .="<userstatus>Error.</userstatus>\n";
		$strXmlContent .="</user>";
	}
	$dbObj->fun_db_free_resultset($result);
} else {
	$strXmlContent .="<user>";
	$strXmlContent .="<userstatus>Error.</userstatus>\n";
	$strXmlContent .="</user>";
}

$strXml ="";
$strXml .='<?xml version="1.0" encoding="ISO-8859-1"?><users>';
$strXml .=$strXmlContent;
$strXml .='</users>';
ob_clean();
echo $strXml;
ob_end_flush();
flush();
?>
