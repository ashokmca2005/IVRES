<?php
	header('Content-Type: text/xml');
	header("Cache-Control: no-cache, must-revalidate");
	//A date in the past
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	require_once("adm/includes/common.php");
	require_once("adm/includes/database-table.php");
	require_once("adm/includes/classes/class.DB.php");
	require_once("adm/includes/classes/class.Location.php");
	$dbObj = new DB();
	$dbObj->fun_db_connect();

	$locationObj 	= new Location();

	if(isset($_REQUEST[destinations])){
		$destinations 	= str_replace("-", " ", $_REQUEST[destinations]);
	} else {
		$destinations 	= "florida";
	}

	$destinationArr 	= $locationObj->fun_getLocationShortInfo($destinations);
    if(is_array($destinationArr) && count($destinationArr) > 0) {
		$area_name 		= ucwords($destinationArr['destination_name']);
		$area_desc 		= ucfirst($destinationArr['destination_desc']);
		$strXmlContent .="<destination>";
		$strXmlContent .="<name>".$area_name."</name>";
		$strXmlContent .="<desc>".$area_desc."</desc>";
		$strXmlContent .="</destination>";
	}

	$strXml ="";
	$strXml .='<?xml version="1.0" encoding="ISO-8859-1"?><destinations>';
	$strXml .=$strXmlContent;
	$strXml .='</destinations>';
	echo $strXml;
?>