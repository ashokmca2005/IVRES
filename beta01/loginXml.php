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

$strXml 		= "";
$strXmlContent 	= "";
$referpage 		= "index.php";

if(isset($_GET['usr']) && ($_GET['usr'] !="") && isset($_GET['pass']) && ($_GET['pass'] !="")){
	$userName 		= $_GET['usr'];
	$userPassword 	= $_GET['pass'];
	$userRemember 	= $_GET['rm'];

	if($usersObj->fun_verifyUsers($userName, $userPassword)){			
		$usersDets = $usersObj->fun_getUsersInfo(0, $userName);
		if($usersDets["user_status"] == "1"){
			$_SESSION['ses_user_id'] 	= $usersDets["user_id"];
			$_SESSION['ses_user_fname'] = $usersDets["user_fname"];
			$_SESSION['ses_user_email'] = $usersDets["user_email"];
			$_SESSION['ses_user_pass'] 	= $usersDets["user_pass"];
			if(isset($usersDets["is_owner"]) && ($usersDets["is_owner"]=="1")){
				$_SESSION['ses_user_home'] = SITE_URL."owner-home";
				if(($referpage != "") || ($referpage == "index.php")){
					$referpage = $_SESSION['ses_user_home'];
				} else {
					$referpage = SITE_URL."owner-home";
				}
			} else {
				$_SESSION['ses_user_home'] = SITE_URL."home";
				if(($referpage != "") || ($referpage == "index.php")){
					$referpage = SITE_URL."home";
				}
			}
		}
	}
	$strXmlContent .="<user>";
	if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] != "") {
		$strXmlContent .="<userstatus>User Login Success</userstatus>\n";
	} else {
		$strXmlContent .="<userstatus>User Name Error</userstatus>\n";
	}
	$strXmlContent .="<userurl>".$referpage."</userurl>\n";
	$strXmlContent .="</user>";

} else {
	$strXmlContent .="<user>";
	$strXmlContent .="<userstatus>User Name Error</userstatus>\n";
	$strXmlContent .="<userurl>".$referpage."</userurl>\n";
	$strXmlContent .="</user>";
}

$strXml ="";
$strXml .='<?xml version="1.0" encoding="ISO-8859-1"?><users>';
$strXml .=$strXmlContent;
$strXml .='</users>';
echo $strXml;
?>
