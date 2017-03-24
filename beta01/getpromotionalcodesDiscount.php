<?php
if($_SERVER["SERVER_NAME"] == "localhost") {
	require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
} else {
	require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
}
$dbObj = new DB();
$dbObj->fun_db_connect();

if(isset($_GET['usr']) && $_GET['usr'] != "" && isset($_GET['pcodes']) && $_GET['pcodes'] !="") {
	$user_id = trim($_GET['usr']);
	$promotion_code = trim($_GET['pcodes']);
	// Query 1
	$sql 	= "SELECT final_price FROM " . TABLE_USER_CART . " WHERE user_id='".$user_id."' ";
	$rs 	= $dbObj->createRecordset($sql);
	$arr 	= $dbObj->fetchAssoc($rs);
	$total_payble_amt = 0;
	for($i=0; $i<count($arr); $i++){
		$total_payble_amt += (float)($arr[$i]['final_price']);
	}
	if($total_payble_amt > 0) {
		// add vat charges
		$total_payble_amt += (($total_payble_amt*17.5)/100);
	}

	// Query 2
	$strQuery 	= "SELECT promotion_value FROM " .TABLE_USER_PROMOTION_CODES. " WHERE promotion_code IN (".$promotion_code.")";
	$rdoQuery 	= $dbObj->createRecordset($strQuery);
	$rsQuery	= $dbObj->fetchAssoc($rdoQuery);
	$promotion_value = 0;
	for($j=0; $j<count($rsQuery); $j++){
		$promotion_value += (float)($rsQuery[$j]['promotion_value']);
	}
	$total_discount = ($total_payble_amt*($promotion_value/100));
	echo number_format(($total_payble_amt - $total_discount), 2)."~".number_format($total_discount, 2);
}
?>
