<?php
header('Content-Type: text/xml');
header("Cache-Control: no-cache, must-revalidate");
//A date in the past
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
require_once("includes/owner-top.php");

$strXml 		= "";
$strXmlContent 	= "";
if(isset($_GET['pid']) && $_GET['pid'] !=""){
	$property_id = $_GET['pid'];
	if($propertyObj->fun_checkPropertyOwner($property_id, $user_id) == false) {
		redirectURL(SITE_URL."index.php");
	}
	$propertyInfo		= $propertyObj->fun_getPropertyInfo($property_id);
	//print_r($propertyInfo);
	$property_type_name	= ucfirst($propertyInfo['property_type_name']);
	$propLocInfoArr 	= $propertyObj->fun_getPropertyLocInfoArr($property_id);
	$arr				= array();
	if($propLocInfoArr['countries_name'] !=""){
		$link1 = "<a href=\"".SITE_URL."vacation-rentals/in.".str_replace("/", "_", str_replace(" ", "-", strtolower($propLocInfoArr['countries_name'])))."\">".$property_type_name." rentals in ".ucwords($propLocInfoArr['countries_name'])."</a>";
		array_push($arr, $link1);
	}
	if($propLocInfoArr['area_name'] !=""){
		$link2 = "<a href=\"".SITE_URL."vacation-rentals/in.".str_replace("/", "_", str_replace(" ", "-", strtolower($propLocInfoArr['area_name'])))."\">".$property_type_name." rentals in ".ucwords($propLocInfoArr['area_name'])."</a>";
		array_push($arr, $link2);
	}

	$links 		= "Find your perfect vacation rentals on rentownersvillas.com, best deals available for ".implode(" and ", $arr).".";
	$backlink 		= '';
	$backlinkcode	= "<!--Begin ".SITE_NAME."-Code -->".$links."<!--End ".SITE_NAME."-Code -->";
	$status 		= 1;
	//Step I: get activation id if already available for this property id
	$activation_id 	= $propertyObj->fun_getActivationIdByPropertyId($property_id);
	if(isset($activation_id) && $activation_id !="") {
		//updates
		$id 		= $propertyObj->fun_editPropertyBackLink($activation_id, $property_id, $backlink, $backlinkcode, $status);
	} else {
		//Add
		$id 		= $propertyObj->fun_addPropertyBackLink($property_id, $backlink, $backlinkcode, $status);
	}
	if(isset($id) && $id != "") {
		$strXmlContent .="<backlink>";
		$strXmlContent .="<backlinkid>".$id."</backlinkid>\n";
		$strXmlContent .="</backlink>";
	} else {
		$strXmlContent .="<backlink>";
		$strXmlContent .="<backlinkid>invalid</backlinkid>\n";
		$strXmlContent .="</backlink>";
	}
} else {
	$strXmlContent .="<backlink>";
	$strXmlContent .="<backlinkid>invalid</backlinkid>\n";
	$strXmlContent .="</backlink>";
}

$strXml ="";
$strXml .='<?xml version="1.0" encoding="ISO-8859-1"?><backlinks>';
$strXml .=$strXmlContent;
$strXml .='</backlinks>';
echo $strXml;
?>