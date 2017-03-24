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

$dbObj = new DB();
$dbObj->fun_db_connect();

$strXml ="";
$strXmlContent ="";
if(isset($_GET['pcode']) && $_GET['pcode'] !=""){
	$promotion_code 	= trim($_GET['pcode']);
	$user_id 			= trim($_GET['usr']);
	$cur_date 			= date('Y-m-d');
	$status 			= "1";
	$active 			= "1";

	// Query
	$sql 	= "SELECT * FROM " .TABLE_USER_PROMOTION_CODES. " WHERE promotion_code = '".$promotion_code."' AND user_id = '".$user_id."' AND status = '".$status."' AND active = '".$active."' AND valid_from <='".$cur_date."' AND valid_to >='".$cur_date."'";
	$rs 	= $dbObj->createRecordset($sql);
	$total 	= $dbObj->getRecordCount($rs);
	if($total > 0) {
		$strXmlContent .="<itm>";
		$strXmlContent .="<itmstatus>available.</itmstatus>\n";
		$strXmlContent .="</itm>";
	} else {
		$strXmlContent .="<itm>";
		$strXmlContent .="<itmstatus>Error.</itmstatus>\n";
		$strXmlContent .="</itm>";
	}
} else {
	$strXmlContent .="<itm>";
	$strXmlContent .="<itmstatus>Error.</itmstatus>\n";
	$strXmlContent .="</itm>";
}

$strXml ="";
$strXml .='<?xml version="1.0" encoding="ISO-8859-1"?><itms>';
$strXml .=$strXmlContent;
$strXml .='</itms>';
echo $strXml;
?>
