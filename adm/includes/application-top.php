<?php
session_start();
require_once("adm/includes/common.php");
require_once("adm/includes/database-table.php");
require_once("adm/includes/classes/class.DB.php");
require_once("adm/includes/functions/general.php");
require_once("adm/includes/functions/form.php");
require_once("adm/includes/functions/html.php");

$dbObj = new DB();
$dbObj->fun_db_connect();
?>