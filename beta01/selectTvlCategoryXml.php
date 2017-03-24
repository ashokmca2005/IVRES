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
	$sql = "SELECT trvl_guid_categories_id AS id, trvl_guid_categories_name AS name, trvl_guid_categories_desc AS description FROM " . TABLE_TRAVEL_GUIDES_CATEGORIES . " WHERE trvl_guid_categories_id ='".$id."'";
	$rs = $dbObj->createRecordset($sql);
	$strOpt ="";
	echo '<?xml version="1.0" encoding="ISO-8859-1"?><tvlcategories>';
	$count=0;
	while($row = mysql_fetch_array($rs)) {
		$name 			= $row[name];
		$name          	= str_replace("&","&amp;",$row[name]);
		$name          	= str_replace("<","&lt;",$name);
		$name          	= str_replace(">","&gt;",$name);
		$name          	= str_replace("\"","&quot;",$name);
		$name          	= str_replace("'","&#39;",$name);
		$name          	= str_replace("é","&#233;",$name);
		$name    		= str_replace("ç","c",$name);
		$name    		= str_replace("°","&deg;",$name);
		$name    		= str_replace("–","-",$name);
		$name    		= str_replace("à","a",$name);
		$name    		= str_replace("è","e",$name);
		$name    		= str_replace("·",".",$name);
		$name    		= str_replace("«","&lt;&lt;",$name);
		$name    		= str_replace("»","&gt;&gt;",$name);
		$name    		= str_replace("ô","o",$name);
		$name    		= str_replace("î","i",$name);


		$description    = str_replace("&","&amp;",$row[description]);
		$description    = str_replace("<","&lt;",$description);
		$description    = str_replace(">","&gt;",$description);
		$description    = str_replace("\"","&quot;",$description);
		$description    = str_replace("'","&#39;",$description);
		$description    = str_replace("é","&#233;",$description);
		$description    = str_replace("ç","c",$description);
		$description    = str_replace("°","&deg;",$description);
		$description    = str_replace("–","-",$description);
		$description    = str_replace("à","a",$description);
		$description    = str_replace("è","e",$description);
		$description    = str_replace("·",".",$description);
		$description    = str_replace("«","&lt;&lt;",$description);
		$description    = str_replace("»","&gt;&gt;",$description);
		$description    = str_replace("ô","o",$description);
		$description    = str_replace("î","i",$description);

		$description = $row[description];
		echo "<tvlcategory>";
		echo "<id>".$row[id]."</id>";
		echo "<name>".addslashes(ucwords($name))."</name>";
		echo "<description><![CDATA[".addslashes($description)."]]></description>";
		echo "</tvlcategory>";
		$count++;
	}
	echo "</tvlcategories>";
}
?>