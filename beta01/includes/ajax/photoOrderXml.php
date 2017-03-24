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

$strXml 		= "";
$strXmlContent 	= "";
if(isset($_GET['photo_id']) && $_GET['photo_id'] !="" && isset($_GET['property_id']) && $_GET['property_id'] !="" && isset($_GET['mode']) && $_GET['mode'] !=""){
	$mode 			= $_GET['mode'];
	$photo_id 		= $_GET['photo_id'];
	$property_id 	= $_GET['property_id'];
	$photo_order 	= $dbObj->getField(TABLE_PROPERTY_PHOTO_ALL, "photo_id", $photo_id, "photo_order");
	
	//Step I: Get Property Photo Array by property_id
	$sql 			= "SELECT photo_id, photo_order FROM ".TABLE_PROPERTY_PHOTO_ALL." WHERE property_id='".$property_id."' ORDER BY photo_order ASC";
	$rs 			= $dbObj->createRecordset($sql);
	if($dbObj->getRecordCount($rs) > 0){
		$arr 		= $dbObj->fetchAssoc($rs);
		for($i = 0; $i < count($arr); $i++) {
			if($arr[$i]['photo_id'] == $photo_id) {
				$index = $i;
			}
		}

		if(isset($mode) && $mode == "up") {
			//change order of affected row
			$sqlUpdate 			= "UPDATE " . TABLE_PROPERTY_PHOTO_ALL . " SET photo_order ='".$photo_order."' WHERE photo_id='".(int)($arr[$index-1]['photo_id'])."' ";
			$dbObj->mySqlSafeQuery($sqlUpdate);

			//change order of selected row
			$photo_order_new 	= ($photo_order-1);
			$sqlUpdate 			= "UPDATE " . TABLE_PROPERTY_PHOTO_ALL . " SET photo_order ='".$photo_order_new."' WHERE photo_id='".$photo_id."' ";
			$dbObj->mySqlSafeQuery($sqlUpdate);
		}

		if(isset($mode) && $mode == "down") {
			//change order of affected row
			$sqlUpdate 			= "UPDATE " . TABLE_PROPERTY_PHOTO_ALL . " SET photo_order ='".$photo_order."' WHERE photo_id='".(int)($arr[$index+1]['photo_id'])."' ";
			$dbObj->mySqlSafeQuery($sqlUpdate);

			//change order of selected row
			$photo_order_new 	= ($photo_order+1);
			$sqlUpdate 			= "UPDATE " . TABLE_PROPERTY_PHOTO_ALL . " SET photo_order ='".$photo_order_new."' WHERE photo_id='".$photo_id."' ";
			$dbObj->mySqlSafeQuery($sqlUpdate);
		}

		$strXmlContent .="<order>";
		$strXmlContent .="<orderstatus>success</orderstatus>\n";
		$strXmlContent .="</order>";
	} else {
		$strXmlContent .="<order>";
		$strXmlContent .="<orderstatus>error</orderstatus>\n";
		$strXmlContent .="</order>";
	}
} else {
	$strXmlContent .="<order>";
	$strXmlContent .="<orderstatus>error</orderstatus>\n";
	$strXmlContent .="</order>";
}

$strXml ="";
$strXml .='<?xml version="1.0" encoding="ISO-8859-1"?><orders>';
$strXml .=$strXmlContent;
$strXml .='</orders>';
echo $strXml;
?>
