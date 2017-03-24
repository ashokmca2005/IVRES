<?php
	if($_SERVER["SERVER_NAME"] == "localhost") {
		require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
	} else {
		require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
	}

	require_once(SITE_CLASSES_PATH."class.Property.php");
	$propertyObj 	= new Property();
	if(isset($_REQUEST['map']) && $_REQUEST['map'] != "") {
		$map 		= $_REQUEST['map'];
		$map 		= str_replace("-", " ", $map);

		$mapInfoArr	= $propertyObj->fun_getPropertyDestinationMapInfo($map);
		if(is_array($mapInfoArr)) {
			$map_output =  $map_output . "<map>";
			$map_output =  $map_output . "<map_img>".$mapInfoArr['map_img']."</map_img>\n";
			$map_output =  $map_output . "<map_title>".$mapInfoArr['map_title']."</map_title>\n";
			$map_output =  $map_output . "<map_total_prop>".$mapInfoArr['map_total_prop']."</map_total_prop>\n";
			$map_output =  $map_output . "<map_p1_img>".$mapInfoArr['map_p1_img']."</map_p1_img>\n";
			$map_output =  $map_output . "<map_p1_title>".$mapInfoArr['map_p1_title']."</map_p1_title>\n";
			$map_output =  $map_output . "<map_p2_img>".$mapInfoArr['map_p2_img']."</map_p2_img>\n";
			$map_output =  $map_output . "<map_p2_title>".$mapInfoArr['map_p2_title']."</map_p2_title>\n";
			if(isset($mapInfoArr['map_area_arr']) && count($mapInfoArr['map_area_arr']) > 0) {
				$map_output =  $map_output . "<map_area_arr>\n";
				for($i = 0; $i < count($mapInfoArr['map_area_arr']); $i++) {
					$map_area_id 		= $mapInfoArr['map_area_arr'][$i]['map_area_id'];
					$map_area_name 		= $mapInfoArr['map_area_arr'][$i]['map_area_name'];
					$total_properties 	= $mapInfoArr['map_area_arr'][$i]['total_properties'];
					
					$map_output =  $map_output . "<map_area_id>".$map_area_id."</map_area_id>\n";
					$map_output =  $map_output . "<map_area_name>".addslashes($map_area_name)."</map_area_name>\n";
					$map_output =  $map_output . "<total_properties>".$total_properties."</total_properties>\n";
				}
				$map_output =  $map_output . "</map_area_arr>\n"; 
			} else if(isset($mapInfoArr['map_region_arr']) && count($mapInfoArr['map_region_arr']) > 0) {
				$map_output =  $map_output . "<map_region_arr>\n";
				for($i = 0; $i < count($mapInfoArr['map_region_arr']); $i++) {
					$map_region_id 		= $mapInfoArr['map_region_arr'][$i]['map_region_id'];
					$map_region_name 		= $mapInfoArr['map_region_arr'][$i]['map_region_name'];
					$total_properties 	= $mapInfoArr['map_region_arr'][$i]['total_properties'];
					
					$map_output =  $map_output . "<map_region_id>".$map_region_id."</map_region_id>\n";
					$map_output =  $map_output . "<map_region_name>".addslashes($map_region_name)."</map_region_name>\n";
					$map_output =  $map_output . "<total_properties>".$total_properties."</total_properties>\n";
				}
				$map_output =  $map_output . "</map_region_arr>\n"; 
			} else if(isset($mapInfoArr['map_location_arr']) && count($mapInfoArr['map_location_arr']) > 0) {
				$map_output =  $map_output . "<map_location_arr>\n";
				for($i = 0; $i < count($mapInfoArr['map_location_arr']); $i++) {
					$map_location_id 		= $mapInfoArr['map_location_arr'][$i]['map_location_id'];
					$map_location_name 		= $mapInfoArr['map_location_arr'][$i]['map_location_name'];
					$total_properties 	= $mapInfoArr['map_location_arr'][$i]['total_properties'];
					
					$map_output =  $map_output . "<map_location_id>".$map_location_id."</map_location_id>\n";
					$map_output =  $map_output . "<map_location_name>".addslashes($map_location_name)."</map_location_name>\n";
					$map_output =  $map_output . "<total_properties>".$total_properties."</total_properties>\n";
				}
				$map_output =  $map_output . "</map_location_arr>\n"; 
			}

			$map_output =  $map_output . "</map>"; 
		
		}
	//print_r($mapInfoArr);
	}
	header('Content-Type: text/xml');
	header("Cache-Control: no-cache, must-revalidate");
	//A date in the past
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	echo '<?xml version="1.0" encoding="ISO-8859-1"?><maps>';
	echo $map_output."\n";
	echo '</maps>';
?>