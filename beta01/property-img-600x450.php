<?php
require_once("adm/includes/common.php");
require_once("adm/includes/database-table.php");
require_once("adm/includes/classes/class.DB.php");
require_once("adm/includes/classes/class.Image.php");
require_once("adm/includes/functions/general.php");

$dbObj = new DB();
$dbObj->fun_db_connect();

$imgObj= new Image();

//Step I: get photo array
$sql 	= "SELECT * FROM " . TABLE_PROPERTY_PHOTO_ALL . " ";
$rs 	= $dbObj->createRecordset($sql);
if($dbObj->getRecordCount($rs) > 0) {
	$arr = $dbObj->fetchAssoc($rs);
	for($i=0; $i < count($arr); $i++) {
		$photo_id 		= $arr[$i]['photo_id'];
		$property_id 	= $arr[$i]['property_id'];
		$photo_url 		= $arr[$i]['photo_url'];

		$uploadphotodir = 'upload/property_images/large';
		$uploadphotofile600x450 	= $uploadphotodir ."/600x450/". $photo_url;
		$imgObj->getCrop($uploadphotodir,$photo_url,600,450,$uploadphotofile600x450);

		echo $i.") ".$photo_url." copied";
		sleep(1);
	}
}
?>