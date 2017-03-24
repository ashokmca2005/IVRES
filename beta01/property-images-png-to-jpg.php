<?php
require_once("adm/includes/common.php");
require_once("adm/includes/database-table.php");
require_once("adm/includes/classes/class.DB.php");
require_once("adm/includes/classes/class.Property.php");
$dbObj = new DB();
$dbObj->fun_db_connect();
$propertyObj 	= new Property();
// Step I: get all property images and convert them png to jpg
$propertyObj->fun_convertPropertyImagesPNGtoJPG();
?>
