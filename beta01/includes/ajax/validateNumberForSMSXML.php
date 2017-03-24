<?php
session_start();
header('Content-Type: text/xml');
header("Cache-Control: no-cache, must-revalidate");
//A date in the past
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
require_once("../../adm/includes/common.php");
require_once("../../adm/includes/database-table.php");
require_once("../../adm/includes/classes/class.DB.php");
require_once("../../adm/includes/functions/general.php");

$dbObj = new DB();
$dbObj->fun_db_connect();

$strXml ="";
$strXmlContent ="";
if(isset($_GET['mob']) && $_GET['country'] !=""){
	$mob 		= $_GET['mob'];
	$country 	= $_GET['country'];

	$user 		= SMS_USERNAME;
	$password 	= SMS_PASSWORD;
	$api_id 	= SMS_API;

	$baseurl 	= "http://api.clickatell.com";

	$text 		= urlencode("This is a verification message for your <?php echo $sitetitle; ?> SMS setting. Thnx.");
	$isd_code 	= $dbObj->getField(TABLE_COUNTRIES, "countries_id", $country, "countries_isd_code");
	$to 		= trim("+".$isd_code.$mob);
	
	// auth call
	$url 		= "$baseurl/http/auth?user=$user&password=$password&api_id=$api_id";
	// do auth call
	$ret 		= file($url);
	// split our response. return string is on first line of the data returned
	$sess 		= split(":",$ret[0]);
	if ($sess[0] == "OK") {
		$sess_id 	= trim($sess[1]); // remove any whitespace
		$url 		= "$baseurl/http/sendmsg?session_id=$sess_id&to=$to&text=$text";
		// do sendmsg call
		$ret 		= file($url);
		$send 		= split(":",$ret[0]);
		if ($send[0] == "ID")
			$result = "done";
		else
			$result = "error";
	} else {
		$result = "error";
	}
} else {
	$result = "error";
}
$strXml ="";
$strXml .='<?xml version="1.0" encoding="ISO-8859-1"?><validate>';
$strXml .="<status>".$result."</status>\n";
$strXml .='</validate>';
echo $strXml;
?>
