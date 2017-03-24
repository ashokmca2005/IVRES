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
	$active 			= "1";

	// Query
	$sql 	= "SELECT * FROM " .TABLE_PROMOS. " WHERE promo_code = '".$promotion_code."' AND active = '".$active."' AND promo_start_date <='".$cur_date."' AND promo_end_date >='".$cur_date."'";
	$rs 	= $dbObj->createRecordset($sql);
	if($dbObj->getRecordCount($rs) > 0) {
		$arr = $dbObj->fetchAssoc($rs);
		$promo_takeup 		= $arr[0]['promo_takeup'];
		$promo_by_quantity 	= $arr[0]['promo_by_quantity'];
		if($promo_by_quantity == "0") {
			$strXmlContent .="<itm>";
			$strXmlContent .="<itmstatus>available.</itmstatus>\n";
			$strXmlContent .="</itm>";
		} else if($promo_by_quantity == "1" && $promo_takeup > 0) {
			//Check if user already taken this promo code
			$sqlUsr = "SELECT * FROM " .TABLE_USER_PROMOTION_CODES. " WHERE promotion_code = '".$promotion_code."' AND active = '1' AND user_id = '".$user_id."'";
			$rsUsr 	= $dbObj->createRecordset($sqlUsr);
			if($dbObj->getRecordCount($rsUsr) > 0) { // User can take only one promotion code in this case
				$strXmlContent .="<itm>";
				$strXmlContent .="<itmstatus>Error.</itmstatus>\n";
				$strXmlContent .="</itm>";
			} else {
				$strXmlContent .="<itm>";
				$strXmlContent .="<itmstatus>available.</itmstatus>\n";
				$strXmlContent .="</itm>";
			}
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
