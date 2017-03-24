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

$strXml 		="";
$strXmlContent 	="";
if(isset($_GET['pid']) && $_GET['pid'] !="" && isset($_GET['frm']) && $_GET['frm'] !="" && isset($_GET['to']) && $_GET['to'] !=""){
	$property_id 	= $_GET['pid'];
	$arrival_date 	= $_GET['frm'];
	$departure_date = $_GET['to'];
	$sql = "SELECT A.id, A.property_id, A.startdate, A.enddate, A.status FROM " . TABLE_PROPERTY_AVAILABILITY_RELATIONS . " AS A WHERE A.property_id ='".$property_id."' ";
	if(isset($startdate) && ($startdate != "")) {
		$sql .= " AND (A.startdate = '".$startdate."' OR A.startdate > '".$startdate."' OR A.enddate = '".$startdate."' OR A.enddate > '".$startdate."') ";
	}
	if(isset($enddate) && ($enddate != "")) {
		$sql .= " AND A.enddate >= '".$enddate."' ";
	}
	$sql .= "AND A.status = '2' ORDER BY A.id";		
	$rs   = $dbObj->createRecordset($sql);
	if($dbObj->getRecordCount($rs) > 0) {
		$strXmlContent .="<availability>";
		$strXmlContent .="<availabilitystatus>Yes</availabilitystatus>\n";
		$strXmlContent .="</availability>";
	} else {
		$strXmlContent .="<availability>";
		$strXmlContent .="<availabilitystatus>No</availabilitystatus>\n";
		$strXmlContent .="</availability>";
	}
} else {
	$strXmlContent .="<availability>";
	$strXmlContent .="<availabilitystatus>No</availabilitystatus>\n";
	$strXmlContent .="</availability>";
}

$strXml ="";
$strXml .='<?xml version="1.0" encoding="ISO-8859-1"?><availabilities>';
$strXml .=$strXmlContent;
$strXml .='</availabilities>';
echo $strXml;
?>