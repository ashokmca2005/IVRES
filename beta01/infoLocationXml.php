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
	$id 	= $_REQUEST[id];
	$sql 	= "SELECT location_id AS id, location_name AS name, location_desc AS description FROM " . TABLE_LOCATION . " WHERE location_id ='".$id."'";
	$rs 	= $dbObj->createRecordset($sql);
	$strOpt ="";
	echo '<?xml version="1.0" encoding="ISO-8859-1"?><locations>';
	$count=0;
	while($row = mysql_fetch_array($rs)) {
		$id 			= $row[id];
		$name 			= addslashes(ucwords($row[name]));
		$description 	= $row[description];

//		$description    = htmlentities(addslashes(ucfirst($description)));

		$description    = addslashes(ucfirst($description));
		$description    = str_replace("&","&amp;",$description);
		$description    = str_replace("<","&lt;",$description);
		$description    = str_replace(">","&gt;",$description);
		$description    = str_replace("\"","&quot;",$description);
		$description    = str_replace("'","&#39;",$description);
		$description    = str_replace("�","&#233;",$description);
		$description    = str_replace("�","c",$description);
		$description    = str_replace("&nbsp;"," ",$description);
		$description    = str_replace("�","-",$description);
		$description    = str_replace("�","a",$description);
		$description    = str_replace("�","e",$description);
		$description    = str_replace("�","e",$description);
		$description    = str_replace("�",".",$description);
		$description    = str_replace("�","&lt;&lt;",$description);
		$description    = str_replace("�","&gt;&gt;",$description);
		$description    = str_replace("�","o",$description);
		$description    = str_replace("�","i",$description);
		$description    = str_replace("�","...",$description);


		$description    = str_replace("�","&iexcl;",$description);
		$description    = str_replace("�","&cent;",$description);
		$description    = str_replace("�","&pound;",$description);
		$description    = str_replace("�","&curren;",$description);
		$description    = str_replace("�","&yen;",$description);
		$description    = str_replace("�","&brvbar;",$description);
		$description    = str_replace("�","&sect;",$description);
		$description    = str_replace("�","&uml;",$description);
		$description    = str_replace("�","&copy;",$description);
		$description    = str_replace("�","&ordf;",$description);
		$description    = str_replace("�","&laquo;",$description);
		$description    = str_replace("�","&not;",$description);
		$description    = str_replace("�","&shy;",$description);
		$description    = str_replace("�","&reg;",$description);
		$description    = str_replace("�","&macr;",$description);
		$description    = str_replace("�","&deg;",$description);
		$description    = str_replace("�","&plusmn;",$description);
		$description    = str_replace("�","&sup2;",$description);
		$description    = str_replace("�","&sup3;",$description);
		$description    = str_replace("�","&acute;",$description);
		$description    = str_replace("�","&micro;",$description);
		$description    = str_replace("�","&para;",$description);
		$description    = str_replace("�","&middot;",$description);
		$description    = str_replace("�","&cedil;",$description);
		$description    = str_replace("�","&sup1;",$description);
		$description    = str_replace("�","&ordm;",$description);
		$description    = str_replace("�","&raquo;",$description);
		$description    = str_replace("�","&frac14;",$description);
		$description    = str_replace("�","&frac12;",$description);
		$description    = str_replace("�","&frac34;",$description);
		$description    = str_replace("�","&iquest;",$description);
		$description    = str_replace("�","&Agrave;",$description);
		$description    = str_replace("�","&Aacute;",$description);
		$description    = str_replace("�","&Acirc;",$description);
		$description    = str_replace("�","&Atilde;",$description);
		$description    = str_replace("�","&Auml;",$description);
		$description    = str_replace("�","&Aring;",$description);
		$description    = str_replace("�","&AElig;",$description);
		$description    = str_replace("�","&Ccedil;",$description);
		$description    = str_replace("�","&Egrave;",$description);
		$description    = str_replace("�","&Eacute;",$description);
		$description    = str_replace("�","&Ecirc;",$description);
		$description    = str_replace("�","&Euml;",$description);
		$description    = str_replace("�","&Igrave;",$description);
		$description    = str_replace("�","&Iacute;",$description);
		$description    = str_replace("�","&Icirc;",$description);
		$description    = str_replace("�","&Iuml;",$description);
		$description    = str_replace("�","&ETH;",$description);
		$description    = str_replace("�","&Ntilde;",$description);
		$description    = str_replace("�","&Ograve;",$description);
		$description    = str_replace("�","&Oacute;",$description);
		$description    = str_replace("�","&Ocirc;",$description);
		$description    = str_replace("�","&Otilde;",$description);
		$description    = str_replace("�","&Ouml;",$description);
		$description    = str_replace("�","&times;",$description);
		$description    = str_replace("�","&Oslash;",$description);
		$description    = str_replace("�","&Ugrave;",$description);
		$description    = str_replace("�","&Uacute;",$description);
		$description    = str_replace("�","&Ucirc;",$description);
		$description    = str_replace("�","&Uuml;",$description);
		$description    = str_replace("�","&Yacute;",$description);
		$description    = str_replace("�","&THORN;",$description);
		$description    = str_replace("�","&szlig;",$description);
		$description    = str_replace("�","&agrave;",$description);
		$description    = str_replace("�","&aacute;",$description);
		$description    = str_replace("�","&acirc;",$description);
		$description    = str_replace("�","&atilde;",$description);
		$description    = str_replace("�","&auml;",$description);
		$description    = str_replace("�","&aring;",$description);
		$description    = str_replace("�","&aelig;",$description);
		$description    = str_replace("�","&ccedil;",$description);
		$description    = str_replace("�","&egrave;",$description);
		$description    = str_replace("�","&eacute;",$description);
		$description    = str_replace("�","&ecirc;",$description);
		$description    = str_replace("�","&euml;",$description);
		$description    = str_replace("�","&igrave;",$description);
		$description    = str_replace("�","&iacute;",$description);
		$description    = str_replace("�","&icirc;",$description);
		$description    = str_replace("�","&iuml;",$description);
		$description    = str_replace("�","&eth;",$description);
		$description    = str_replace("�","&ntilde;",$description);
		$description    = str_replace("�","&ograve;",$description);
		$description    = str_replace("�","&oacute;",$description);
		$description    = str_replace("�","&ocirc;",$description);
		$description    = str_replace("�","&otilde;",$description);
		$description    = str_replace("�","&ouml;",$description);
		$description    = str_replace("�","&divide;",$description);
		$description    = str_replace("�","&oslash;",$description);
		$description    = str_replace("�","&ugrave;",$description);
		$description    = str_replace("�","&uacute;",$description);
		$description    = str_replace("�","&ucirc;",$description);
		$description    = str_replace("�","&uuml;",$description);
		$description    = str_replace("�","&yacute;",$description);
		$description    = str_replace("�","&thorn;",$description);
		$description    = str_replace("�","&yuml;",$description);



		echo "<location>";
		echo "<id>".$id."</id>";
		echo "<name>".$name."</name>";
		echo "<description>".$description."</description>";
		echo "</location>";
		$count++;
	}
	echo "</locations>";
}
?>