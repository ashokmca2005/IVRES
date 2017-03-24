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
require_once("../../adm/includes/classes/class.Email.php");
require_once("../../adm/includes/classes/class.Users.php");

$usersObj 	= new Users();
$strXml ="";
$strXmlContent ="";
if(isset($_GET['email']) && $_GET['email'] !=""){
	$txtUserEmail 	= $_GET['email'];
	$txtPwd 		= $_GET['pwd'];
	if($usersObj->fun_sendNewPasswordReminderByEmail($txtUserEmail, $txtPwd) === true) {
		$result = "done";
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
