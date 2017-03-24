<?php
header('Content-Type: text/xml');
header("Cache-Control: no-cache, must-revalidate");
//A date in the past
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

if($_SERVER["SERVER_NAME"] == "localhost") {
	require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/includes/application-top.php");
} else if ($_SERVER["SERVER_NAME"] == "projects.idns-technologies.com") {
	require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/includes/application-top.php");
} else {
	require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
}
require_once(SITE_CLASSES_PATH."class.Property.php");
require_once(SITE_CLASSES_PATH."class.Users.php");

$dbObj = new DB();
$usersObj 		= new Users();
$propertyObj	= new Property();
$dbObj->fun_db_connect();

$strXml ="";
$strXmlContent ="";
if(isset($_GET['usr_id']) && $_GET['usr_id'] !=""){
	$usr_id = $_GET['usr_id'];
	// Step I: if user is owner delete prperty first
	$userInfo = $usersObj->fun_getUsersInfo($usr_id);
	if(isset($userInfo['is_owner']) && $userInfo['is_owner'] == "1") {
		// delete owner property
		$propertyObj->fun_delPropertyByUserId($usr_id);
	}
	// Step I: Select details of image
	$usersObj->fun_delUser($usr_id);
	$strXmlContent .="<user>";
	$strXmlContent .="<userstatus>user deleted.</userstatus>\n";
	$strXmlContent .="</user>";
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
