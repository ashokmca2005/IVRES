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

//$dbObj->mySqlSafeQuery("UPDATE ".TABLE_PROPERTY_PHOTO_ALL." SET photo_caption='test25', photo_url='1_600x450.jpg', photo_thumb='1_88x66.jpg' WHERE photo_id='1'");
$strXml ="";
$strXmlContent ="";
if(isset($_GET['imgid']) && $_GET['imgid'] !=""){
	$imgid = $_GET['imgid'];

	// Step I: Select details of image 
	$strSelectQuery = "SELECT * FROM ".TABLE_PROPERTY_PHOTO_ALL." WHERE photo_id='$imgid'";
	$rs = $dbObj->createRecordset($strSelectQuery);
	$arr = $dbObj->fetchAssoc($rs);
	if(count($arr) > 0){
		$tempphoto 	= 'upload/'.$arr[0]['photo_url'];
		$photo 		= 'upload/property_images/large/'.$arr[0]['photo_url'];
		$thumb 		= 'upload/property_images/thumbnail/'.$arr[0]['photo_thumb'];
	}
	// Step II: Delete images and thumbnails
	if($tempphoto != ""){
		@unlink($tempphoto);
	}
	if($photo != ""){
		@unlink($photo);
	}
	if($thumb != ""){
		@unlink($thumb);
	}

	// Step III: Delete records from database
	$strDelteQuery = "DELETE FROM ".TABLE_PROPERTY_PHOTO_ALL." WHERE photo_id='$imgid'";
	$dbObj->mySqlSafeQuery($strDelteQuery);

	$strXmlContent .="<photo>";
	$strXmlContent .="<photostatus>Photo deleted.</photostatus>\n";
	$strXmlContent .="</photo>";
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
