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
		$description    = str_replace("é","&#233;",$description);
		$description    = str_replace("ç","c",$description);
		$description    = str_replace("&nbsp;"," ",$description);
		$description    = str_replace("–","-",$description);
		$description    = str_replace("à","a",$description);
		$description    = str_replace("è","e",$description);
		$description    = str_replace("é","e",$description);
		$description    = str_replace("·",".",$description);
		$description    = str_replace("«","&lt;&lt;",$description);
		$description    = str_replace("»","&gt;&gt;",$description);
		$description    = str_replace("ô","o",$description);
		$description    = str_replace("î","i",$description);
		$description    = str_replace("…","...",$description);


		$description    = str_replace("¡","&iexcl;",$description);
		$description    = str_replace("¢","&cent;",$description);
		$description    = str_replace("£","&pound;",$description);
		$description    = str_replace("¤","&curren;",$description);
		$description    = str_replace("¥","&yen;",$description);
		$description    = str_replace("¦","&brvbar;",$description);
		$description    = str_replace("§","&sect;",$description);
		$description    = str_replace("¨","&uml;",$description);
		$description    = str_replace("©","&copy;",$description);
		$description    = str_replace("ª","&ordf;",$description);
		$description    = str_replace("«","&laquo;",$description);
		$description    = str_replace("¬","&not;",$description);
		$description    = str_replace("­","&shy;",$description);
		$description    = str_replace("®","&reg;",$description);
		$description    = str_replace("¯","&macr;",$description);
		$description    = str_replace("°","&deg;",$description);
		$description    = str_replace("±","&plusmn;",$description);
		$description    = str_replace("²","&sup2;",$description);
		$description    = str_replace("³","&sup3;",$description);
		$description    = str_replace("´","&acute;",$description);
		$description    = str_replace("µ","&micro;",$description);
		$description    = str_replace("¶","&para;",$description);
		$description    = str_replace("·","&middot;",$description);
		$description    = str_replace("¸","&cedil;",$description);
		$description    = str_replace("¹","&sup1;",$description);
		$description    = str_replace("º","&ordm;",$description);
		$description    = str_replace("»","&raquo;",$description);
		$description    = str_replace("¼","&frac14;",$description);
		$description    = str_replace("½","&frac12;",$description);
		$description    = str_replace("¾","&frac34;",$description);
		$description    = str_replace("¿","&iquest;",$description);
		$description    = str_replace("À","&Agrave;",$description);
		$description    = str_replace("Á","&Aacute;",$description);
		$description    = str_replace("Â","&Acirc;",$description);
		$description    = str_replace("Ã","&Atilde;",$description);
		$description    = str_replace("Ä","&Auml;",$description);
		$description    = str_replace("Å","&Aring;",$description);
		$description    = str_replace("Æ","&AElig;",$description);
		$description    = str_replace("Ç","&Ccedil;",$description);
		$description    = str_replace("È","&Egrave;",$description);
		$description    = str_replace("É","&Eacute;",$description);
		$description    = str_replace("Ê","&Ecirc;",$description);
		$description    = str_replace("Ë","&Euml;",$description);
		$description    = str_replace("Ì","&Igrave;",$description);
		$description    = str_replace("Í","&Iacute;",$description);
		$description    = str_replace("Î","&Icirc;",$description);
		$description    = str_replace("Ï","&Iuml;",$description);
		$description    = str_replace("Ð","&ETH;",$description);
		$description    = str_replace("Ñ","&Ntilde;",$description);
		$description    = str_replace("Ò","&Ograve;",$description);
		$description    = str_replace("Ó","&Oacute;",$description);
		$description    = str_replace("Ô","&Ocirc;",$description);
		$description    = str_replace("Õ","&Otilde;",$description);
		$description    = str_replace("Ö","&Ouml;",$description);
		$description    = str_replace("×","&times;",$description);
		$description    = str_replace("Ø","&Oslash;",$description);
		$description    = str_replace("Ù","&Ugrave;",$description);
		$description    = str_replace("Ú","&Uacute;",$description);
		$description    = str_replace("Û","&Ucirc;",$description);
		$description    = str_replace("Ü","&Uuml;",$description);
		$description    = str_replace("Ý","&Yacute;",$description);
		$description    = str_replace("Þ","&THORN;",$description);
		$description    = str_replace("ß","&szlig;",$description);
		$description    = str_replace("à","&agrave;",$description);
		$description    = str_replace("á","&aacute;",$description);
		$description    = str_replace("â","&acirc;",$description);
		$description    = str_replace("ã","&atilde;",$description);
		$description    = str_replace("ä","&auml;",$description);
		$description    = str_replace("å","&aring;",$description);
		$description    = str_replace("æ","&aelig;",$description);
		$description    = str_replace("ç","&ccedil;",$description);
		$description    = str_replace("è","&egrave;",$description);
		$description    = str_replace("é","&eacute;",$description);
		$description    = str_replace("ê","&ecirc;",$description);
		$description    = str_replace("ë","&euml;",$description);
		$description    = str_replace("ì","&igrave;",$description);
		$description    = str_replace("í","&iacute;",$description);
		$description    = str_replace("î","&icirc;",$description);
		$description    = str_replace("ï","&iuml;",$description);
		$description    = str_replace("ð","&eth;",$description);
		$description    = str_replace("ñ","&ntilde;",$description);
		$description    = str_replace("ò","&ograve;",$description);
		$description    = str_replace("ó","&oacute;",$description);
		$description    = str_replace("ô","&ocirc;",$description);
		$description    = str_replace("õ","&otilde;",$description);
		$description    = str_replace("ö","&ouml;",$description);
		$description    = str_replace("÷","&divide;",$description);
		$description    = str_replace("ø","&oslash;",$description);
		$description    = str_replace("ù","&ugrave;",$description);
		$description    = str_replace("ú","&uacute;",$description);
		$description    = str_replace("û","&ucirc;",$description);
		$description    = str_replace("ü","&uuml;",$description);
		$description    = str_replace("ý","&yacute;",$description);
		$description    = str_replace("þ","&thorn;",$description);
		$description    = str_replace("ÿ","&yuml;",$description);



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