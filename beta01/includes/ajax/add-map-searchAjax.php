<?php
require_once("../../adm/includes/common.php");
require_once("../../adm/includes/database-table.php");
require_once("../../adm/includes/classes/class.DB.php");
require_once("../../adm/includes/functions/general.php");

if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !="") {
	$cur_user = $_SESSION['ses_user_id'];
} else {
	$cur_user = session_id();
}

/*
$dbObj = new DB();
$dbObj->fun_db_connect();
if(isset($_GET['destinationtype']) && ($_GET['destinationtype'] !="") && isset($_GET['destinationid']) && ($_GET['destinationid'] !="")){
	$act = $_GET['act'];
	// Step I: Select select user id 
	$strSelectQuery = "SELECT * FROM ol_user_map_search_settings WHERE user_id='$cur_user'";
	$rs = $dbObj->createRecordset($strSelectQuery);
	$arr = $dbObj->fetchAssoc($rs);
	if(count($arr) > 0){
		$map_search_setting_id 	= $arr[0]['map_search_setting_id'];
		$user_id 				= $arr[0]['user_id'];
		$country_ids 			= $arr[0]['country_ids'];
		$area_ids 				= $arr[0]['area_ids'];
		$region_ids 			= $arr[0]['region_ids'];
		$sub_region_ids 		= $arr[0]['sub_region_ids'];
		$location_ids 			= $arr[0]['location_ids'];
	}
	// Step II: Insert to database
}
*/
echo "test";
?>