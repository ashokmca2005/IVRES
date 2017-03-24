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

$user4NewsLetter 	= new Users();

//$dbObj->mySqlSafeQuery("UPDATE ol_property_photo_all SET photo_caption='test25', photo_url='1_600x450.jpg', photo_thumb='1_88x66.jpg' WHERE photo_id='1'");
$strXml ="";
$strXmlContent ="";
if(isset($_GET['email']) && $_GET['email'] !=""){
	$strEmail = $_GET['email'];
	if($user4NewsLetter->fun_verifyUser4Newsletter($strEmail)){
		$result = "exist";
	} else {
		if($user4NewsLetter->fun_addUser4Newsletter() > 0){
			$result = "done";
		} else {
			$result = "error";
		}
	}
	if(isset($result) && $result == "done"){
		$user4NewsLetterDets = $user4NewsLetter->fun_getUser4NewsletterInfo($strEmail);
		$id = $user4NewsLetterDets['id'];
		$user4NewsLetter->sendNewsletterActivationEmail($id, $strEmail);
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
