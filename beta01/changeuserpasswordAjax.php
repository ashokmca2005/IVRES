<?php
header('Content-Type: text/xml');
header("Cache-Control: no-cache, must-revalidate");
//A date in the past
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

if($_SERVER["SERVER_NAME"] == "localhost") {
	require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
} else {
	require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
}
require_once(SITE_CLASSES_PATH."class.Users.php");
$usersObj = new Users();

if(isset($_GET['usr']) && isset($_GET['oldpass']) && isset($_GET['newpass']) && $_GET['usr'] != "" && $_GET['oldpass'] !="" && $_GET['newpass'] !=""){		
	$strUser 		= $_GET['usr'];
	$strOldPassword	= $_GET['oldpass'];
	$strNewPassword	= $_GET['newpass'];

	if($usersObj->fun_verifyUserPassword($strUser, $strOldPassword) === true){
		if($usersObj->fun_updateUserPassword($strUser, $strNewPassword) === true){
			$result = "password changed";
		} else {
			$result = "failed";
		}
	} else { // passowrd wrong
		$result = "password wrong";
	}
} else {
	$result = "failed";
}
echo '<?xml version="1.0" encoding="ISO-8859-1"?><users>';
echo "<user>";
echo "<status>".trim($result)."</status>";
echo "</user>";
echo "</users>";
?>