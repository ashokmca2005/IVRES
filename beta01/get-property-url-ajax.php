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
	require_once(SITE_CLASSES_PATH."class.Property.php");
	$propertyObj 	= new Property();

	$property_id 	= intval(remove_zero_left($_GET['pid'], "0"));
	//echo $property_id;
	
	$strXml ="";
	$strXmlContent ="";
	if((is_int($property_id) && $property_id !="")){
		$propLocInfoArr 	= $propertyObj->fun_getPropertyLocInfoArr($property_id);
		$fr_url 			= $propertyObj->fun_getPropertyFriendlyLink($property_id);
		if(isset($fr_url) && $fr_url != "") {
			$property_link 		= SITE_URL."vacation-rentals/".strtolower($fr_url);
		} else {
			if(isset($propLocInfoArr['location_name']) && $propLocInfoArr['location_name'] != "") {
				$property_link = SITE_URL."vacation-rentals/in.".str_replace(" ", "-", strtolower($propLocInfoArr['location_name']))."/".fill_zero_left($property_id, "0", (6-strlen($property_id)));
			} else {
				$property_link = SITE_URL."vacation-rentals/in.".str_replace(" ", "-", strtolower($propLocInfoArr['region_name']))."/".fill_zero_left($property_id, "0", (6-strlen($property_id)));
			}
		}
		$strXmlContent .="<property>";
		$strXmlContent .="<link>".$property_link."</link>\n";
		$strXmlContent .="</property>";
	} else {
		$strXmlContent .="<property>";
		$strXmlContent .="<link>no url.</link>\n";
		$strXmlContent .="</property>";
	}
	$strXml ="";
	$strXml .='<?xml version="1.0" encoding="ISO-8859-1"?><properties>';
	$strXml .=$strXmlContent;
	$strXml .='</properties>';
	echo $strXml;
?>
