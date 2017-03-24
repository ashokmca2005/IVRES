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
	$dbObj->deleteRow(TABLE_USER_FAVOURITE_PROPERTIES, array("user_id", "property_id"), array($user_id, $property_id));
	$message = "remove successfully";
}
echo $message;
?>