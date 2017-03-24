<?php
session_start();
header('Content-Type: text/xml');
header("Cache-Control: no-cache, must-revalidate");
//A date in the past
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

require_once("../../includes/common.php");
require_once("../../includes/database-table.php");
require_once("../../includes/classes/class.DB.php");
require_once("../../includes/classes/class.Users.php");
require_once("../../includes/functions/general.php");

$dbObj = new DB();
$dbObj->fun_db_connect();

$usersObj = new Users();
if(isset($_GET['usr']) && isset($_GET['newpass']) && $_GET['usr'] != "" && $_GET['newpass'] !=""){		
	$strUser 		= $_GET['usr'];
	$strNewPassword	= $_GET['newpass'];
	if($usersObj->fun_updateUserPassword($strUser, $strNewPassword) === true){
		$result = "password changed";
	}
	else{
		$result = "failed";
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
