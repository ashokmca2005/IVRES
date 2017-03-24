<?php
session_start();
require_once($_SERVER["DOCUMENT_ROOT"]."/adm/includes/common.php");
require_once(SITE_ADMIN_INCLUDES_PATH."database-table.php");
require_once(SITE_CLASSES_PATH."class.DB.php");
require_once(SITE_ADMIN_INCLUDES_PATH."functions/general.php");
require_once(SITE_ADMIN_INCLUDES_PATH."functions/form.php");
require_once(SITE_ADMIN_INCLUDES_PATH."functions/html.php");
require_once(SITE_ADMIN_INCLUDES_PATH."functions/class.Admins.php");
$dbObj = new DB();
$dbObj->fun_db_connect();
?>
