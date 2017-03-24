<?php
header('Content-Type: text/xml');
header("Cache-Control: no-cache, must-revalidate");
//A date in the past
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
require_once("adm/includes/common.php");
require_once("adm/includes/database-table.php");
require_once("adm/includes/classes/class.DB.php");
require_once("adm/includes/functions/general.php");

$dbObj = new DB();
$dbObj->fun_db_connect();
if(isset($_REQUEST[id])) {
	$id = $_REQUEST[id];
	$sql = "SELECT region_id AS id, 
				   region_name AS name
			  FROM " . TABLE_REGION . "
		     WHERE pregion_id ='".$id."'
		  ORDER BY region_name";

	$rs = $dbObj->createRecordset($sql);
	$strOpt ="";
	echo '<?xml version="1.0" encoding="ISO-8859-1"?><ntowns>';
	$count=0;
	while($row = mysql_fetch_array($rs)) {
		echo "<ntown>";
		echo "<id>".$row[id]."</id>";
		echo "<name>".ucwords($row[name])."</name>";
		echo "</ntown>";
		$count++;
	}
	echo "</ntowns>";
}
?>