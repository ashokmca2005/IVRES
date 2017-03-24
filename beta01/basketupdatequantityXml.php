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

$dbObj = new DB();
$dbObj->fun_db_connect();

$strXml ="";
$strXmlContent ="";
if(isset($_GET['quantity']) && $_GET['quantity'] !="" && isset($_GET['basketid']) && $_GET['basketid'] !=""){
	$quantity 	= $_GET['quantity'];
	$basketid 	= $_GET['basketid'];
	$sqlUpdate 	= "UPDATE " . TABLE_USER_CART . " SET user_basket_quantity = '".$quantity."' WHERE user_basket_id='".$basketid."'";
	$dbObj->mySqlSafeQuery($sqlUpdate);

	$strXmlContent .="<basket>";
	$strXmlContent .="<basketstatus>basket updated.</basketstatus>\n";
	$strXmlContent .="</basket>";
} else {
	$strXmlContent .="<basket>";
	$strXmlContent .="<basketstatus>Error.</basketstatus>\n";
	$strXmlContent .="</basket>";
}

$strXml ="";
$strXml .='<?xml version="1.0" encoding="ISO-8859-1"?><baskets>';
$strXml .=$strXmlContent;
$strXml .='</baskets>';
echo $strXml;
?>
