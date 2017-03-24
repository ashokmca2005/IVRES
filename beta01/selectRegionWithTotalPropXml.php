<?php
header('Content-Type: text/xml');
header("Cache-Control: no-cache, must-revalidate");
//A date in the past
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
if($_SERVER["SERVER_NAME"] == "localhost") {
	require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
} else {
	require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
}

require_once(SITE_CLASSES_PATH."class.Property.php");
$propertyObj 	= new Property();

$dbObj = new DB();
$dbObj->fun_db_connect();
if(isset($_REQUEST[id]))
{
	$id = $_REQUEST[id];
	$sql = "SELECT region_id AS id, 
				   region_name AS name
			  FROM " . TABLE_REGION . "
		     WHERE area_id ='".$id."' AND pregion_id='0'
		  ORDER BY region_name";


	$rs = $dbObj->createRecordset($sql);
	$strOpt ="";
	echo '<?xml version="1.0" encoding="ISO-8859-1"?><ntowns>';
	$count=0;
	while($row = mysql_fetch_array($rs))
	{
		echo "<ntown>";
		echo "<id>".$row[id]."</id>";
		echo "<name>".addslashes(ucwords($row[name]))."</name>";
		echo "<totalproperty>".$propertyObj->fun_countPropertyByRegionId($row[id])."</totalproperty>";
		echo "</ntown>";
		$count++;
	}
	echo "</ntowns>";
}
?>