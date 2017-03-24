<?php
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

//$dbObj->mySqlSafeQuery("UPDATE ol_property_photo_all SET photo_caption='test25', photo_url='1_600x450.jpg', photo_thumb='1_88x66.jpg' WHERE photo_id='1'");
$strXml ="";
$strXmlContent ="";
if(isset($_GET['pid']) && $_GET['pid'] !=""){
	$property_id = $_GET['pid'];
	$add_photos	 = $_GET['addphoto'];

	// Step I: Select select user id 
	$strSelectQuery = "SELECT * FROM ".TABLE_PROPERTY_OWNER_RELATIONS." WHERE property_id='$property_id'";
	$rs = $dbObj->createRecordset($strSelectQuery);
	$arr = $dbObj->fetchAssoc($rs);
	if(count($arr) > 0){
		$property_id 	= $arr[0]['property_id'];
		$user_id 		= $arr[0]['owner_id'];
	}
	// Step II: Insert to cart 
	if(($add_photos >0) && $property_id !="" && $user_id !=""){
		$user_basket_date_added	= time ();
		$user_basket_date_expire= mktime(0, 0, 0, date("m")  , date("d")+15, date("Y"));
		$strInsertQuery = "INSERT INTO ol_user_basket(user_basket_id, user_id, products_id, property_id, user_basket_quantity, final_price, user_basket_date_added, user_basket_date_expire) VALUES (null, '".$user_id."', 1, '".$property_id."', '".$add_photos."', '50.0000', '".$user_basket_date_added."', '".$user_basket_date_expire."')";
		$dbObj->mySqlSafeQuery($strInsertQuery);

		$strXmlContent .="<photo>";
		$strXmlContent .="<photostatus>Photos added.</photostatus>\n";
		$strXmlContent .="</photo>";
	}
	else{
		$strXmlContent .="<photo>";
		$strXmlContent .="<photostatus>Error.</photostatus>\n";
		$strXmlContent .="</photo>";
	}
}
else{
	$strXmlContent .="<photo>";
	$strXmlContent .="<photostatus>Error.</photostatus>\n";
	$strXmlContent .="</photo>";
}

$strXml ="";
$strXml .='<?xml version="1.0" encoding="ISO-8859-1"?><photos>';
$strXml .=$strXmlContent;
$strXml .='</photos>';
echo $strXml;
?>
