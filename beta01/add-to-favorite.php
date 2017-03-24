<?php
require_once("adm/includes/common.php");
require_once("adm/includes/database-table.php");
require_once("adm/includes/classes/class.DB.php");
require_once("adm/includes/functions/general.php");
$dbObj = new DB();
$dbObj->fun_db_connect();

if(isset($_GET['property_id']) && ($_GET['property_id'] !="") && isset($_GET['user_id']) && ($_GET['user_id'] !="")){
	$property_id 	= $_GET['property_id'];
	$user_id 		= $_GET['user_id'];
	$cur_unixtime	= time ();
	$dbObj->insertFields(TABLE_USER_FAVOURITE_PROPERTIES, array("user_id", "property_id", "created_on", "created_by", "updated_on", "updated_by"), array($user_id, $property_id, $cur_unixtime, $user_id, $cur_unixtime, $user_id));
	$lastInsertId = $dbObj->fun_db_last_inserted_id();
	echo $lastInsertId;
}
?>
