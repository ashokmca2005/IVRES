<?php
header('Content-Type: text/xml');
header("Cache-Control: no-cache, must-revalidate");
//A date in the past
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
require_once("includes/owner-top.php");

$strXml 		= "";
$strXmlContent 	= "";
if(isset($_GET['id']) && $_GET['id'] !="" && isset($_GET['backlink']) && $_GET['backlink'] !=""){
	$id 		= $_GET['id'];
	$backlink 	= $_GET['backlink'];
	$strValidate= $propertyObj->fun_updatePropertyBackLink($id, $backlink);
	if(isset($strValidate) && $strValidate == "valid") {
		$strXmlContent .="<backlink>";
		$strXmlContent .="<backlinkstatus>".$strValidate."</backlinkstatus>\n";
		$strXmlContent .="</backlink>";
	} else {
		$strXmlContent .="<backlink>";
		$strXmlContent .="<backlinkstatus>invalid</backlinkstatus>\n";
		$strXmlContent .="</backlink>";
	}
} else {
	$strXmlContent .="<backlink>";
	$strXmlContent .="<backlinkstatus>invalid</backlinkstatus>\n";
	$strXmlContent .="</backlink>";
}

$strXml ="";
$strXml .='<?xml version="1.0" encoding="ISO-8859-1"?><backlinks>';
$strXml .=$strXmlContent;
$strXml .='</backlinks>';
echo $strXml;
?>