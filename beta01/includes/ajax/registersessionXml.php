<?php
session_start();
header('Content-Type: text/xml');
header("Cache-Control: no-cache, must-revalidate");
//A date in the past
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

require_once("../../adm/includes/common.php");
require_once("../../adm/includes/database-table.php");
require_once("../../adm/includes/classes/class.DB.php");
require_once("../../adm/includes/functions/general.php");

$dbObj = new DB();
$dbObj->fun_db_connect();

$strXml ="";
$strXmlContent ="";
if(isset($_GET['email']) && $_GET['email'] !=""){
	$user_name 		= $_GET['name'];
	$user_email 	= $_GET['email'];
	$user_session 	= session_id();
	$user_ip 		= $_SERVER['REMOTE_ADDR'];
	$created_on 	= time ();

	$field_names 	= array("user_session", "user_name", "user_email", "user_ip", "created_on");
	$field_values 	= array($user_session, $user_name, $user_email, $user_ip, $created_on);
	$dbObj->insertFields(TABLE_USER_SESSION, $field_names, $field_values);
	$id 			= $dbObj->getIdentity();

	if($id > 0){
		$result = "done";
		$_SESSION['ses_user_session'] = session_id();
	} else {
		$result = "error";
	}
} else {
	$result = "error";
}

$strXml ="";
$strXml .='<?xml version="1.0" encoding="ISO-8859-1"?><progresses>';
$strXml .='<progress>';
$strXml .="<status>".$result."</status>\n";
$strXml .='</progress>';
$strXml .='</progresses>';
echo $strXml;
?>
