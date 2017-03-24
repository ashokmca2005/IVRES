<?php
class Location{
	var $dbObj;
	
	function Location(){ // class constructor
		$this->dbObj = new DB();
		$this->dbObj->fun_db_connect();
	} 

	// Function for location info	
	function fun_getLocationMapInfo($destination_name){
		$destinationMapArray = array();

		if(($area_relation_array = $this->fun_findLocationRelationInfo(TABLE_AREA , " WHERE REPLACE(LOWER(area_name), '\'', '^')='".strtolower(str_replace('\'', '-', $destination_name))."'")) && (is_array($area_relation_array))){

			$country_id		= $area_relation_array[0]['country_id'];
			$area_id		= $area_relation_array[0]['area_id'];
			$area_name		= $area_relation_array[0]['area_name'];
			$map_thumb		= $area_relation_array[0]['map_thumb'];
			$map_large		= $area_relation_array[0]['map_large'];

			$destinationMapArray['map_img']		= $map_large;
			$destinationMapArray['map_title']	= $area_name;
			$destinationMapArray['map_p1_img']	= $map_thumb;
			$destinationMapArray['map_p1_title']= $area_name;
			$destinationMapArray['map_p2_img']	= "africa-south-africa-map.gif";
			$destinationMapArray['map_p2_title']= "Spain";

		} else if(($region_relation_array = $this->fun_findLocationRelationInfo(TABLE_REGION , " WHERE REPLACE(LOWER(region_name), '\'', '^')='".strtolower(str_replace('\'', '-', $destination_name))."'")) && (is_array($region_relation_array))){

			$region_id		= $region_relation_array[0]['region_id'];
			$pregion_id		= $region_relation_array[0]['pregion_id'];
			$area_id		= $region_relation_array[0]['area_id'];
			$region_name	= $region_relation_array[0]['region_name'];
			$map_thumb		= $region_relation_array[0]['map_thumb'];
			$map_large		= $region_relation_array[0]['map_large'];

			$destinationMapArray['map_img']		= $map_large;
			$destinationMapArray['map_title']	= $region_name;
			$destinationMapArray['map_p1_img']	= $map_thumb;
			$destinationMapArray['map_p1_title']= $region_name;

			if($pregion_id == "" || $pregion_id == "0") {
				$area_relation_array = $this->fun_findLocationRelationInfo(TABLE_AREA , " WHERE area_id='".$area_id."'");
				$country_id		= $area_relation_array[0]['country_id'];
				$area_id		= $area_relation_array[0]['area_id'];
				$area_name		= $area_relation_array[0]['area_name'];
				$map_thumb		= $area_relation_array[0]['map_thumb'];
				$map_large		= $area_relation_array[0]['map_large'];

				$destinationMapArray['map_p2_img']	= $map_thumb;
				$destinationMapArray['map_p2_title']= $area_name;
			} else {
				$pregion_relation_array = $this->fun_findLocationRelationInfo(TABLE_REGION , " WHERE region_id='".$pregion_id."'");
				$p_region_id		= $pregion_relation_array[0]['region_id'];
				$p_pregion_id		= $pregion_relation_array[0]['pregion_id'];
				$p_area_id			= $pregion_relation_array[0]['area_id'];
				$p_region_name		= $pregion_relation_array[0]['region_name'];
				$p_map_thumb		= $pregion_relation_array[0]['map_thumb'];
				$p_map_large		= $pregion_relation_array[0]['map_large'];

				$destinationMapArray['map_p2_img']	= $p_map_large;
				$destinationMapArray['map_p2_title']= $p_region_name;
			}
		}
		return $destinationMapArray ;
	}

	// Function for Destination info	
	function fun_getDestinationInfo($destination_name){
		$destinationArray = array();
		if(($country_relation_array = $this->fun_findLocationRelationInfo(TABLE_COUNTRIES , " WHERE REPLACE(LOWER(countries_name), \"\'\", \"^\")='".strtolower(str_replace("'", "-", $destination_name))."' OR REPLACE(LOWER(countries_name), \"\\\'\", \"^\")='".strtolower(str_replace("'", "-", $destination_name))."' ")) && (is_array($country_relation_array))){
			$destinationArray['country_id']		= $country_relation_array[0]['countries_id'];
		} else if(($area_relation_array = $this->fun_findLocationRelationInfo(TABLE_AREA , " WHERE REPLACE(LOWER(area_name), \"\'\", \"^\")='".strtolower(str_replace("'", "-", $destination_name))."' OR REPLACE(LOWER(area_name), \"\\\'\", \"^\")='".strtolower(str_replace("'", "-", $destination_name))."' ")) && (is_array($area_relation_array))){
			$destinationArray['country_id']		= $area_relation_array[0]['country_id'];
			$destinationArray['area_id']		= $area_relation_array[0]['area_id'];
		} else if(($region_relation_array = $this->fun_findLocationRelationInfo(TABLE_REGION , " WHERE REPLACE(LOWER(region_name), \"\'\", \"^\")='".strtolower(str_replace("'", "-", $destination_name))."' OR REPLACE(LOWER(region_name), \"\\\'\", \"^\")='".strtolower(str_replace("'", "-", $destination_name))."' ")) && (is_array($region_relation_array))){
			$destinationArray['country_id']		= $this->fun_getAreaCountryIdById($region_relation_array[0]['area_id']);
			$destinationArray['area_id']		= $region_relation_array[0]['area_id'];
			if($region_relation_array[0]['pregion_id'] == "" || $region_relation_array[0]['pregion_id'] == "0") {
				if($this->fun_countSubRegionByRegionid($region_relation_array[0]['region_id']) > 0) {
					$destinationArray['pregion_id']		= $region_relation_array[0]['region_id'];
					$destinationArray['region_id']		= "0";
				} else {
					$destinationArray['pregion_id']		= "0";
					$destinationArray['region_id']		= $region_relation_array[0]['region_id'];
				}
			} else {
                $destinationArray['pregion_id']		= $region_relation_array[0]['pregion_id'];
                $destinationArray['region_id']		= $region_relation_array[0]['region_id'];
			}
		} else if(($location_relation_array = $this->fun_findLocationRelationInfo(TABLE_LOCATION , " WHERE REPLACE(LOWER(location_name), \"\'\", \"^\")='".strtolower(str_replace("'", "-", $destination_name))."' OR REPLACE(LOWER(location_name), \"\\\'\", \"^\")='".strtolower(str_replace("'", "-", $destination_name))."' ")) && (is_array($location_relation_array))){
			$destinationArray['location_id']	= $location_relation_array[0]['location_id'];
            $region_array 						= $this->fun_findLocationRelationInfo(TABLE_REGION , " WHERE region_id='".$location_relation_array[0]['region_id']."'");
			if($region_array[0]['pregion_id'] == "" || $region_array[0]['pregion_id'] == "0") {
				$destinationArray['region_id']		= "0";
                $destinationArray['pregion_id']		= $location_relation_array[0]['region_id'];
                $destinationArray['area_id']		= $region_array[0]['area_id'];
				$destinationArray['country_id']		= $this->fun_getAreaCountryIdById($destinationArray['area_id']);
			} else {
				$destinationArray['region_id']		= $location_relation_array[0]['region_id'];
                $destinationArray['pregion_id']		= $region_array[0]['pregion_id'];
                $destinationArray['area_id']		= $region_array[0]['area_id'];
				$destinationArray['country_id']		= $this->fun_getAreaCountryIdById($destinationArray['area_id']);
			}
		}

//echo "SELECT * FROM ".TABLE_LOCATION." WHERE REPLACE(LOWER(location_name), \"\'\", \"^\")='".strtolower(str_replace("'", "^", $destination_name))."' OR REPLACE(LOWER(location_name), \"\\\'\", \"^\")='".strtolower(str_replace("'", "^", $destination_name))."' ";
//print_r($destinationArray);
		return $destinationArray;
	}

	// Function for location short info	
	function fun_getLocationShortInfo($destination_name){
		$destinationArray = array();
		if(($area_relation_array = $this->fun_findLocationRelationInfo(TABLE_AREA , " WHERE REPLACE(LOWER(area_name), '\'', '^')='".strtolower(str_replace('\'', '-', $destination_name))."'")) && (is_array($area_relation_array))){
			$area_id								= $area_relation_array[0]['area_id'];
            $country_id								= $area_relation_array[0]['country_id'];
			$area_name								= $area_relation_array[0]['area_name'];
			$area_desc								= $area_relation_array[0]['area_desc'];

			$destinationArray['destination_name']	= $area_name;
			$destinationArray['destination_area']	= $this->dbObj->getField(TABLE_COUNTRIES, "countries_id", $country_id, "countries_name");
			$destinationArray['destination_desc']	= $area_desc;
		} else if(($region_relation_array = $this->fun_findLocationRelationInfo(TABLE_REGION , " WHERE REPLACE(LOWER(region_name), '\'', '^')='".strtolower(str_replace('\'', '-', $destination_name))."'")) && (is_array($region_relation_array))){
			$pregion_id								= $region_relation_array[0]['pregion_id'];
			$area_id								= $region_relation_array[0]['area_id'];
			$area_name								= $region_relation_array[0]['region_name'];
			$area_desc								= $region_relation_array[0]['region_desc'];
			$destinationArray['destination_name']	= $area_name;
			$destinationArray['destination_desc']	= $area_desc;

			if($pregion_id == "" || $pregion_id == "0") {
                $destinationArray['destination_area']	= $this->dbObj->getField(TABLE_AREA, "area_id", $area_id, "area_name");
			} else {
                $destinationArray['destination_area']	= $this->dbObj->getField(TABLE_REGION, "region_id", $pregion_id, "region_name");
			}
		} else if(($location_relation_array = $this->fun_findLocationRelationInfo(TABLE_LOCATION , " WHERE REPLACE(LOWER(location_name), '\'', '^')='".strtolower(str_replace('\'', '-', $destination_name))."'")) && (is_array($location_relation_array))){
			$location_id							= $location_relation_array[0]['location_id'];
			$region_id								= $location_relation_array[0]['region_id'];
			$area_name								= $location_relation_array[0]['location_name'];
			$area_desc								= $location_relation_array[0]['location_desc'];
			$destinationArray['destination_name']	= $area_name;
			$destinationArray['destination_desc']	= $area_desc;
		}
		return $destinationArray;
	}

	// Function for region short info	
	function fun_getLocationShortInfoById($location_id){
		$destinationArray = array();
        if(($location_relation_array = $this->fun_findLocationRelationInfo(TABLE_LOCATION , " WHERE location_id='".$location_id."'")) && (is_array($location_relation_array))){
			$location_id							= $location_relation_array[0]['location_id'];
			$region_id								= $location_relation_array[0]['region_id'];
			$area_name								= $location_relation_array[0]['location_name'];
			$area_desc								= $location_relation_array[0]['location_desc'];
			$area_lat								= $location_relation_array[0]['latitude'];
			$area_lon								= $location_relation_array[0]['longitude'];
			$area_zoom								= ($location_relation_array[0]['zoom_level'])?$location_relation_array[0]['zoom_level']:10;

			$destinationArray['destination_name']	= $area_name;
			$destinationArray['destination_desc']	= $area_desc;
			$destinationArray['destination_lat']	= $area_lat;
			$destinationArray['destination_lon']	= $area_lon;
			$destinationArray['destination_zoom']	= $area_zoom;
			$destinationArray['destination_area']	= $this->dbObj->getField(TABLE_REGION, "region_id", $region_id, "region_name");
		}
		return $destinationArray ;
	}

	// Function for region short info	
	function fun_getRegionShortInfoById($region_id){
		$destinationArray = array();
        if(($region_relation_array = $this->fun_findLocationRelationInfo(TABLE_REGION , " WHERE region_id='".$region_id."'")) && (is_array($region_relation_array))){
			$pregion_id								= $region_relation_array[0]['pregion_id'];
			$area_id								= $region_relation_array[0]['area_id'];
			$area_name								= $region_relation_array[0]['region_name'];
			$area_desc								= $region_relation_array[0]['region_desc'];
			$area_lat								= $region_relation_array[0]['latitude'];
			$area_lon								= $region_relation_array[0]['longitude'];
			$area_zoom								= ($region_relation_array[0]['zoom_level'])?$region_relation_array[0]['zoom_level']:10;

			$destinationArray['destination_name']	= $area_name;
			$destinationArray['destination_desc']	= $area_desc;
			$destinationArray['destination_lat']	= $area_lat;
			$destinationArray['destination_lon']	= $area_lon;
			$destinationArray['destination_zoom']	= $area_zoom;
			if($pregion_id == "" || $pregion_id == "0") {
                $destinationArray['destination_area']	= $this->dbObj->getField(TABLE_AREA, "area_id", $area_id, "area_name");
			} else {
                $destinationArray['destination_area']	= $this->dbObj->getField(TABLE_REGION, "region_id", $pregion_id, "region_name");
			}
		}
		return $destinationArray ;
	}

	// Function for area short info	
	function fun_getAreaShortInfoById($area_id){
		$destinationArray = array();
		if(($area_relation_array = $this->fun_findLocationRelationInfo(TABLE_AREA , " WHERE area_id='".$area_id."'")) && (is_array($area_relation_array))){
			$area_id								= $area_relation_array[0]['area_id'];
            $country_id								= $area_relation_array[0]['country_id'];
			$area_name								= $area_relation_array[0]['area_name'];
			$area_desc								= $area_relation_array[0]['area_desc'];
			$area_lat								= $area_relation_array[0]['latitude'];
			$area_lon								= $area_relation_array[0]['longitude'];
			$area_zoom								= ($area_relation_array[0]['zoom_level'])?$area_relation_array[0]['zoom_level']:10;

			$destinationArray['destination_name']	= $area_name;
			$destinationArray['destination_area']	= $this->dbObj->getField(TABLE_COUNTRIES, "countries_id", $country_id, "countries_name");
			$destinationArray['destination_desc']	= $area_desc;
			$destinationArray['destination_lat']	= $area_lat;
			$destinationArray['destination_lon']	= $area_lon;
			$destinationArray['destination_zoom']	= $area_zoom;
		}
		return $destinationArray ;
	}

	// Function for a country edit
	function fun_editCountry($countries_id, $countries_name, $countries_iso_code_2, $countries_iso_code_3, $countries_isd_code, $countries_desc, $latitude, $longitude, $zoom_level) {
		if($countries_id == '') {
			return false;
		} else {
            $sqlUpdateQuery = "UPDATE " . TABLE_COUNTRIES . " SET 
            countries_name = '".$countries_name."',
            countries_iso_code_2 = '".$countries_iso_code_2."',
            countries_iso_code_3 = '".$countries_iso_code_3."',
            countries_isd_code = '".$countries_isd_code."',
            countries_desc = '".$countries_desc."',
            latitude = '".$latitude."',
            longitude = '".$longitude."',
            zoom_level = '".$zoom_level."' WHERE countries_id='".$countries_id."'";
            $this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
            return true;
		}
	}


	// Function for a country add
	function fun_addCountry($countries_name, $countries_iso_code_2, $countries_iso_code_3, $countries_isd_code, $countries_desc, $latitude, $longitude, $zoom_level) {
		if($countries_name == '' ||  $countries_iso_code_3 == '' ||  $countries_isd_code == '') {
			return false;
		} else {
			$strInsQuery = "INSERT INTO " . TABLE_COUNTRIES . " 
			(countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, countries_isd_code, countries_desc, latitude, longitude, zoom_level) 
			VALUES(null, '".$countries_name."', '".$countries_iso_code_2."', '".$countries_iso_code_3."', '".$countries_isd_code."', '".$countries_desc."', '".$latitude."', '".$longitude."', '".$zoom_level."')";
			$this->dbObj->fun_db_query($strInsQuery);
			return $this->dbObj->getIdentity();
		}
	}

	// Function for countries array
	function fun_getCountriesArr($parameter=''){
		$sql = "SELECT 	A.countries_id, 
						A.countries_name,
						A.countries_iso_code_3,
						A.countries_isd_code,
						A.latitude, 
						A.longitude
				FROM " . TABLE_COUNTRIES . " AS A WHERE A.countries_id > 0 ";

		if($parameter!=""){
			$sql .= $parameter;
		} else{
			$sql .= " ORDER BY A.countries_id";		
		}
		$rs = $this->dbObj->createRecordset($sql);
		return $arr = $this->dbObj->fetchAssoc($rs);		
	}

	// Function for areas array
	function fun_getAreasArr($country_id, $parameter=''){
		$sql = "SELECT 	A.area_id, 
						A.country_id,
						A.area_name,
						A.latitude, 
						A.longitude
				FROM " . TABLE_AREA . " AS A WHERE A.country_id='".$country_id."' ";

		if($parameter!=""){
			$sql .= $parameter;
		} else{
			$sql .= " ORDER BY A.area_id";		
		}

		$rs = $this->dbObj->createRecordset($sql);
		return $arr = $this->dbObj->fetchAssoc($rs);		
	}

	// Function for region array
	function fun_getRegionsArr($area_id, $parameter=''){
		$sql = "SELECT 	A.region_id, 
						A.area_id,
						A.region_name,
						A.latitude, 
						A.longitude
				FROM " . TABLE_REGION . " AS A WHERE A.area_id='".$area_id."' ";

		if($parameter!=""){
			$sql .= $parameter;
		} else{
			$sql .= " ORDER BY A.region_id";		
		}
		$rs = $this->dbObj->createRecordset($sql);
		return $arr = $this->dbObj->fetchAssoc($rs);		
	}

	// Function for region array
	function fun_getLocationArr($region_id, $parameter=''){
		$sql = "SELECT 	A.location_id, 
						A.region_id,
						A.location_name,
						A.latitude, 
						A.longitude
				FROM " . TABLE_LOCATION . " AS A WHERE A.region_id='".$region_id."' ";

		if($parameter!=""){
			$sql .= $parameter;
		} else{
			$sql .= " ORDER BY A.location_id";		
		}
		$rs = $this->dbObj->createRecordset($sql);
		return $arr = $this->dbObj->fetchAssoc($rs);		
	}

	// Function for a country edit
	function fun_editAreas($area_id, $country_id, $area_name, $area_desc, $latitude, $longitude, $zoom_level) {
		if($area_id == '' || $country_id == '' ) {
			return false;
		} else {
            $sqlUpdateQuery = "UPDATE " . TABLE_AREA . " SET 
            country_id = '".$country_id."',
            area_name = '".fun_db_input($area_name)."',
            area_desc = '".fun_db_input($area_desc)."',
            latitude = '".$latitude."',
            longitude = '".$longitude."',
            zoom_level = '".$zoom_level."' WHERE area_id='".$area_id."'";
            $this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
            return true;
		}
	}

	// Function for a country add
	function fun_addAreas($country_id, $area_name, $area_desc, $latitude, $longitude, $zoom_level) {
		if($area_name == '' ||  $country_id == '') {
			return false;
		} else {
			$map_thumb = '';
			$map_large = '';
			$strInsQuery = "INSERT INTO " . TABLE_AREA . " 
			(area_id, country_id, area_name, area_desc, map_thumb, map_large, latitude, longitude, zoom_level) 
			VALUES(null, '".$country_id."', '".fun_db_input($area_name)."', '".fun_db_input($area_desc)."', '".$map_thumb."', '".$map_large."', '".$latitude."', '".$longitude."', '".$zoom_level."')";
			$this->dbObj->fun_db_query($strInsQuery);
			return $this->dbObj->getIdentity();
		}
	}

	// Function for a Region edit
	function fun_editRegions($region_id, $area_id, $region_name, $region_desc, $latitude, $longitude, $zoom_level, $status) {
		if($region_id == '' || $area_id == '' ) {
			return false;
		} else {
            $sqlUpdateQuery = "UPDATE " . TABLE_REGION . " SET 
            area_id = '".$area_id."',
            region_name = '".fun_db_input($region_name)."',
            region_desc = '".fun_db_input($region_desc)."',
            latitude = '".$latitude."',
            longitude = '".$longitude."',
            zoom_level = '".$zoom_level."', status = '".$status."' WHERE region_id='".$region_id."'";
            $this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
            return true;
		}
	}

	// Function for a Region add
	function fun_addRegions($area_id, $region_name, $region_desc, $latitude, $longitude, $zoom_level, $status) {
		if($region_name == '' ||  $area_id == '') {
			return false;
		} else {
			$map_thumb = '';
			$map_large = '';
			$pregion_id = 0;
			$strInsQuery = "INSERT INTO " . TABLE_REGION . " 
			(region_id, pregion_id, area_id, region_name, region_desc, map_thumb, map_large, latitude, longitude, zoom_level, status) 
			VALUES(null, '".$pregion_id."', '".$area_id."', '".fun_db_input($region_name)."', '".fun_db_input($region_desc)."', '".$map_thumb."', '".$map_large."', '".$latitude."', '".$longitude."', '".$zoom_level."', '".$status."')";
			$this->dbObj->fun_db_query($strInsQuery);
			return $this->dbObj->getIdentity();
		}
	}

	// Function for a Region edit
	function fun_editLocations($location_id, $region_id, $location_name, $location_desc, $latitude, $longitude, $zoom_level, $location_zip, $status) {
		if($location_id == '' || $region_id == '' ) {
			return false;
		} else {
            $sqlUpdateQuery = "UPDATE " . TABLE_LOCATION . " SET 
            region_id = '".$region_id."',
            location_name = '".fun_db_input($location_name)."',
            location_desc = '".fun_db_input($location_desc)."',
            latitude = '".$latitude."',
            longitude = '".$longitude."',
            zoom_level = '".$zoom_level."', location_zip = '".$location_zip."', status = '".$status."' WHERE location_id='".$location_id."'";
            $this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
            return true;
		}
	}

	// Function for a Region add
	function fun_addLocations($region_id, $location_name, $location_desc, $latitude, $longitude, $zoom_level, $location_zip, $status) {
		if($location_name == '' ||  $region_id == '') {
			return false;
		} else {
			$strInsQuery = "INSERT INTO " . TABLE_LOCATION . " 
			(location_id, region_id, location_name, location_desc, latitude, longitude, zoom_level, location_zip, status) 
			VALUES(null, '".$region_id."', '".fun_db_input($location_name)."', '".fun_db_input($location_desc)."', '".$latitude."', '".$longitude."', '".$zoom_level."', '".$location_zip."', '".$status."')";
			$this->dbObj->fun_db_query($strInsQuery);
			return $this->dbObj->getIdentity();
		}
	}

	// Function for country info	
	function fun_getCountryInfoById($countries_id){
		$sql 		= "SELECT * FROM " . TABLE_COUNTRIES . " AS A WHERE A.countries_id='".$countries_id."'";
		$rs 		= $this->dbObj->createRecordset($sql);
		return $arr = $this->dbObj->fetchAssoc($rs);		
	}

	// Function for area info	
	function fun_getAreaInfoById($area_id){
		$sql 		= "SELECT * FROM " . TABLE_AREA . " AS A WHERE A.area_id='".$area_id."'";
		$rs 		= $this->dbObj->createRecordset($sql);
		return $arr = $this->dbObj->fetchAssoc($rs);		
	}

	// Function for area info	
	function fun_getRegionInfoById($region_id){
		$sql 		= "SELECT * FROM " . TABLE_REGION . " AS A WHERE A.region_id='".$region_id."'";
		$rs 		= $this->dbObj->createRecordset($sql);
		return $arr = $this->dbObj->fetchAssoc($rs);		
	}

	// Function for area info	
	function fun_getLocationInfoById($location_id){
		$sql 		= "SELECT * FROM " . TABLE_LOCATION . " AS A WHERE A.location_id='".$location_id."'";
		$rs 		= $this->dbObj->createRecordset($sql);
		return $arr = $this->dbObj->fetchAssoc($rs);		
	}

	// Function for area short info	
	function fun_getCountryShortInfoById($countries_id){
		$destinationArray = array();
		if(($country_relation_array = $this->fun_findLocationRelationInfo(TABLE_COUNTRIES , " WHERE countries_id='".$countries_id."'")) && (is_array($country_relation_array))){
			$countries_id							= $country_relation_array[0]['countries_id'];
			$area_name								= $country_relation_array[0]['countries_name'];
			$area_desc								= $country_relation_array[0]['countries_desc'];
			$area_lat								= $country_relation_array[0]['latitude'];
			$area_lon								= $country_relation_array[0]['longitude'];
			$area_zoom								= ($country_relation_array[0]['zoom_level'])?$country_relation_array[0]['zoom_level']:10;

			$destinationArray['destination_name']	= $area_name;
			$destinationArray['destination_area']	= $area_name;
			$destinationArray['destination_desc']	= $area_desc;
			$destinationArray['destination_lat']	= $area_lat;
			$destinationArray['destination_lon']	= $area_lon;
			$destinationArray['destination_zoom']	= $area_zoom;
		}
		return $destinationArray ;
	}

	// Function for region id by location id
	function fun_delLocationById($location_id){
		$this->dbObj->deleteRow(TABLE_LOCATION, "location_id", $location_id);
		return true;
	}

	// Function for area id by region id
	function fun_delRegionById($region_id){
		$this->dbObj->deleteRow(TABLE_REGION, "region_id", $region_id);
		return true;
	}

	// Function for country id by area id
	function fun_delAreaById($area_id){
		$this->dbObj->deleteRow(TABLE_AREA, "area_id", $area_id);
		return true;
	}

	// Function for region id by location id
	function fun_getLocationRegionIdById($location_id){
		return $this->dbObj->getField(TABLE_LOCATION, "location_id", $location_id, "region_id");
	}

	// Function for area id by region id
	function fun_getRegionAreaIdById($region_id){
		return $this->dbObj->getField(TABLE_REGION, "region_id", $region_id, "area_id");
	}

	// Function for country id by area id
	function fun_getAreaCountryIdById($area_id){
		return $this->dbObj->getField(TABLE_AREA, "area_id", $area_id, "country_id");
	}

	// This function will Return data in array
	function fun_findLocationRelationInfo($table, $criteria){		
		$sql = "SELECT * FROM " .$table. " " .$criteria. "";
		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			return $arr = $this->dbObj->fetchAssoc($rs);		
		}
		else{
			return false;
		}
	}

	// Function for edit location
	function fun_editLocation($location_id, $location_name, $location_desc) {
		if($location_id == '' || $location_name == '' ||  $location_desc == '') {
			return false;
		} else {
			$sqlUpdateQuery = "UPDATE " . TABLE_LOCATION . " SET location_name = '".$location_name."', location_desc = '".$location_desc."' WHERE location_id='".$location_id."'";
			$this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
		}
	}

	// Function for edit region
	function fun_editRegion($region_id, $region_name, $region_desc) {
		if($region_id == '' || $region_name == '' ||  $region_desc == '') {
			return false;
		} else {
			$sqlUpdateQuery = "UPDATE " . TABLE_REGION . " SET region_name = '".$region_name."', region_desc = '".$region_desc."' WHERE region_id='".$region_id."'";
			$this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
		}
	}

	// Function for edit Area
	function fun_editArea($area_id, $area_name, $area_desc) {
		if($area_id == '' || $area_name == '' ||  $area_desc == '') {
			return false;
		} else {
			$sqlUpdateQuery = "UPDATE " . TABLE_AREA . " SET area_name = '".$area_name."', area_desc = '".$area_desc."' WHERE area_id='".$area_id."'";
			$this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
		}
	}

	// Function for creating region-location array
	function fun_getRegionLocationSortByNameArr(){
		$listArray = array();
		$sqlLoc 	= "SELECT * FROM " . TABLE_LOCATION . " ORDER BY location_name";
		$rsLoc 		= $this->dbObj->createRecordset($sqlLoc);
		if($this->dbObj->getRecordCount($rsLoc) > 0){
			$arrLoc = $this->dbObj->fetchAssoc($rsLoc);
			foreach ($arrLoc as $valueLoc) {
				$strName = ucfirst($valueLoc['location_name']);
				array_push($listArray, $strName);
			}
		}


		$sqlRegion 	= "SELECT * FROM " . TABLE_REGION . " ORDER BY region_name";
		$rsRegion 	= $this->dbObj->createRecordset($sqlRegion);
		if($this->dbObj->getRecordCount($rsRegion) > 0){
			$arrRegion = $this->dbObj->fetchAssoc($rsRegion);
			foreach ($arrRegion as $valueRegion) {
				$strName = ucfirst($valueRegion['region_name']);
				array_push($listArray, $strName);
			}
		}

		$sqlArea 	= "SELECT * FROM " . TABLE_AREA . " ORDER BY area_name";
		$rsArea 	= $this->dbObj->createRecordset($sqlArea);
		if($this->dbObj->getRecordCount($rsArea) > 0){
			$arrArea = $this->dbObj->fetchAssoc($rsArea);
			foreach ($arrArea as $valueArea) {
				$strName = ucfirst($valueArea['area_name']);
				array_push($listArray, $strName);
			}
		}

		if(count($listArray) > 0){
			return $listArray;
		} else {
			return false;
		}
	}

	// Function for creating region-location array
	function fun_getRegionLocationSortByNameForAutoArr(){
		$listArray = array();
		$sqlLoc 	= "SELECT * FROM " . TABLE_LOCATION . " ORDER BY location_name";
		$rsLoc 		= $this->dbObj->createRecordset($sqlLoc);
		if($this->dbObj->getRecordCount($rsLoc) > 0){
			$arrLoc = $this->dbObj->fetchAssoc($rsLoc);
			foreach ($arrLoc as $valueLoc) {
				$strName = ucfirst($valueLoc['location_name']);
				//array_push($listArray, $strName);
				$listArray[strtolower($strName)] = $strName;
			}
		}


		$sqlRegion 	= "SELECT * FROM " . TABLE_REGION . " ORDER BY region_name";
		$rsRegion 	= $this->dbObj->createRecordset($sqlRegion);
		if($this->dbObj->getRecordCount($rsRegion) > 0){
			$arrRegion = $this->dbObj->fetchAssoc($rsRegion);
			foreach ($arrRegion as $valueRegion) {
				$strName = ucfirst($valueRegion['region_name']);
				//array_push($listArray, $strName);
				$listArray[strtolower($strName)] = $strName;
			}
		}

		$sqlArea 	= "SELECT * FROM " . TABLE_AREA . " ORDER BY area_name";
		$rsArea 	= $this->dbObj->createRecordset($sqlArea);
		if($this->dbObj->getRecordCount($rsArea) > 0){
			$arrArea = $this->dbObj->fetchAssoc($rsArea);
			foreach ($arrArea as $valueArea) {
				$strName = ucfirst($valueArea['area_name']);
				//array_push($listArray, $strName);
				$listArray[strtolower($strName)] = $strName;
			}
		}

		if(count($listArray) > 0){
			return $listArray;
		} else {
			return false;
		}
	}

	// Function for creating region-location array
	function fun_getRegionLocationNameArr(){
		$regionArray = array();
		$sql = "SELECT * FROM " . TABLE_REGION . " ORDER BY region_name";
		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr = $this->dbObj->fetchAssoc($rs);
			foreach ($arr as $value) {
				$strId = $value['region_id'];
				$strName = $value['region_name'];
				array_push($regionArray, $strName);
				$sqlLoc = "SELECT * FROM " . TABLE_LOCATION . " WHERE region_id='$strId' ORDER BY location_name";
				$rsLoc = $this->dbObj->createRecordset($sqlLoc);
				if($this->dbObj->getRecordCount($rsLoc) > 0){
					$arrLoc = $this->dbObj->fetchAssoc($rsLoc);
					foreach ($arrLoc as $valueLoc) {
						$strName = $value['region_name']." - ".$valueLoc['location_name'];
						array_push($regionArray, $strName);
					}
				}
			}
			return $regionArray;
		}
		else{
			return false;
		}
	}
	
	function fun_getCountryIdHavingArea() {
		$countryArray = array();
		$sql = "SELECT country_id FROM " . TABLE_AREA . " GROUP BY country_id";
		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr = $this->dbObj->fetchAssoc($rs);
			foreach ($arr as $value) {
				$strId = $value['country_id'];
				array_push($countryArray, $strId);
			}
			return implode(",", $countryArray);
		}
		else{
			return false;
		}
	}

	// Function for creating optionlist for countries if country_id is available it must be selected
	function fun_getCountriesOptionsList($countries_id='', $queryparameters=''){		
		$selected = "";
		$sql = "SELECT * FROM " . TABLE_COUNTRIES. " ";
		if($queryparameters !=""){
			$sql .= " ".$queryparameters." ";
		} else {
			$sql .= " ORDER BY countries_name";

//			$sql .= " WHERE countries_id IN (".$countryidlist.") ORDER BY countries_name";
		}
		$result = $this->dbObj->fun_db_query($sql);
		while($rowsCon = $this->dbObj->fun_db_fetch_rs_object($result)){
			if($rowsCon->countries_id == $countries_id  && $countries_id!=''){
				$selected = "selected";
			}else{
				$selected = "";
			}
			echo "<option value=\"".fun_db_output($rowsCon->countries_id)."\" " .$selected. ">";
			echo fun_db_output(ucwords($rowsCon->countries_name));
			echo "</option>\n";
		}
		$this->dbObj->fun_db_free_resultset($result);
	}

	// Function for creating optionlist for countries with isd if country_id is available it must be selected
	function fun_getCountriesISDOptionsList($countries_id='', $queryparameters=''){		
		$selected = "";
		$sql = "SELECT * FROM " . TABLE_COUNTRIES. " ";
		if($queryparameters !=""){
		$sql .= " ".$queryparameters." ";
		}
		else{
		$sql .= " ORDER BY countries_name";
		}
		$result = $this->dbObj->fun_db_query($sql);
		while($rowsCon = $this->dbObj->fun_db_fetch_rs_object($result)){
			if($rowsCon->countries_id == $countries_id  && $countries_id!=''){
				$selected = "selected";
			}else{
				$selected = "";
			}
			echo "<option value=\"".fun_db_output($rowsCon->countries_id)."\" " .$selected. ">";
			echo fun_db_output(ucwords($rowsCon->countries_name));
			echo " (+".fun_db_output(ucwords($rowsCon->countries_isd_code)).")";
			echo "</option>\n";
		}
		$this->dbObj->fun_db_free_resultset($result);
	}

/*
	// Function country list array
	function fun_getCountryListArr($parameter=''){
		$sql 		= "SELECT A.countries_id, 
							A.countries_name, 
							A.countries_iso_code_2, 
							A.countries_iso_code_3,
							A.countries_isd_code,
							A.latitude,
							A.longitude
						FROM " . TABLE_COUNTRIES . " AS A
						";
		if($parameter!=""){
			$sql .= $parameter;
		} else {
			$sql .= " ORDER BY A.countries_name";		
		}
		
		$rs = $this->dbObj->createRecordset($sql);
        return $arr = $this->dbObj->fetchAssoc($rs);
	}
*/

/*
Location Functions : End Here
*/
	// Function for location info	
	function fun_getLocationInfo($locID=''){
		$locationArray = array();
		$sql = "SELECT * FROM " . TABLE_LOCATION . " WHERE location_id='".(int)fun_db_input($locID)."'";
		$result = $this->dbObj->fun_db_query($sql);
		if($this->dbObj->fun_db_get_num_rows($result) > 0){
			$rowsArray = $this->dbObj->fun_db_fetch_rs_object($result);
			$locationArray['location_id'] 		= fun_db_output($rowsArray->location_id);
			$locationArray['region_id'] 		= fun_db_output($rowsArray->region_id);
			$locationArray['location_name'] 	= fun_db_output($rowsArray->location_name);
			$locationArray['location_zip'] 		= fun_db_output($rowsArray->location_zip);
		}
		$this->dbObj->fun_db_free_resultset($result);
		return $locationArray ;
	}
	
	// Function for creating location option list, if location id is given it must be selected
	function fun_getLocationListOptions($locID='', $region_id='', $pregion_id=''){		
		$selected = "";
		$where = array();

		$sql = "SELECT * FROM " . TABLE_LOCATION . " ";
		if($region_id !=""){
			array_push($where, "region_id='".(int)fun_db_input($region_id)."' ");
		}

		if($pregion_id != "" && $region_id == "") {
			$subregion_ids 	= "";
			$sqlSubRegion 	= "SELECT region_id FROM " . TABLE_REGION . " WHERE pregion_id ='".$region_id."'";
			$rsSubRegion 	= $this->dbObj->createRecordset($sqlSubRegion);
			if($this->dbObj->getRecordCount($rsSubRegion)) {
				$arr = $this->dbObj->fetchAssoc($rsSubRegion);
				for($i = 0; $i < count($arr); $i++) {
					$subregion_ids .= $arr[$i]['region_id'].",";
				}
				$subregion_ids = (substr($subregion_ids, strlen($subregion_ids)-1, strlen($subregion_ids)) == ",")?substr($subregion_ids, 0, strlen($subregion_ids)-1):$subregion_ids;
				array_push($where, "region_id IN (".$subregion_ids.") ");
			}
		}

		if(sizeof($where) > 0){
			$sql .= " WHERE ".join($where, " AND ");
		}
		$sql .= " ORDER BY location_name";

		$result = $this->dbObj->fun_db_query($sql);
		while($rowsCon = $this->dbObj->fun_db_fetch_rs_object($result)){
			if($rowsCon->location_id == $locID  && $locID!=''){
				$selected = "selected";
			}else{
				$selected = "";
			}
			echo "<option value=\"".fun_db_output($rowsCon->location_id)."\" " .$selected. ">";
			echo fun_db_output(ucwords($rowsCon->location_name));
			echo "</option>\n";
		}		
		$this->dbObj->fun_db_free_resultset($result);
	}
	
	// Function for creating array for javascript code
	function funLocationJavascriptCode(){
		$sql = "SELECT * FROM " . TABLE_LOCATION . " ORDER BY location_name";
		$result = $this->dbObj->fun_db_query($sql);
		$cnt = 0;
		while($rows = $this->dbObj->fun_db_fetch_rs_object($result)){
			echo " locArray[".$cnt ."] = new Array(".(int)$rows->location_id.", \"".fun_db_output($rows->location_name)."\", ".(int)$rows->sr_id.");";
			echo "\n";
			$cnt++;
		}
		$this->dbObj->fun_db_free_resultset($rsDtypes);
	}
/*
Location Functions : End Here
*/


/*
Region Functions : Start Here
*/
	// Function for region info	
	function fun_getRegionInfo($region_id=''){
		$regionArray = array();
		$sql = "SELECT * FROM " . TABLE_REGION . " WHERE region_id='".(int)fun_db_input($region_id)."'";
		$result = $this->dbObj->fun_db_query($sql);
		if($this->dbObj->fun_db_get_num_rows($result) > 0){
			$rowsArray = $this->dbObj->fun_db_fetch_rs_object($result);
			$regionArray['region_id'] 		= fun_db_output($rowsArray->region_id);
			$regionArray['pregion_id'] 		= fun_db_output($rowsArray->pregion_id);
			$regionArray['area_id'] 		= fun_db_output($rowsArray->area_id);
			$regionArray['region_name'] 	= fun_db_output($rowsArray->region_name);
		}
		$this->dbObj->fun_db_free_resultset($result);
		return $regionArray ;
	}

	function fun_getRegionPid($region_id = '') {
		$sql 	= "SELECT pregion_id FROM " . TABLE_REGION . " WHERE region_id ='".$region_id."'";
		$rs 	= $this->dbObj->createRecordset($sql);
		$arr 	= $this->dbObj->fetchAssoc($rs);
		if((count($arr) > 0) && ($arr[0]['pregion_id'] !="")){
			return $arr[0]['pregion_id'];
		} {
			return 0;
		}
	}

	/*
	* Return location name: Start Here
	*/
	function fun_getCountryNameById($countries_id = '') {
		if($countries_id == '') {
			return false;
		} else {
			$sql 	= "SELECT countries_name FROM " . TABLE_COUNTRIES . " WHERE countries_id ='".$countries_id."'";
			$rs 	= $this->dbObj->createRecordset($sql);
			$arr 	= $this->dbObj->fetchAssoc($rs);
			if((count($arr) > 0) && ($arr[0]['countries_name'] !="")){
				return $arr[0]['countries_name'];
			} {
				return false;
			}
		}
	}
	function fun_getAreaNameById($area_id = '') {
		if($area_id == '') {
			return false;
		} else {
			$sql 	= "SELECT area_name FROM " . TABLE_AREA . " WHERE area_id ='".$area_id."'";
			$rs 	= $this->dbObj->createRecordset($sql);
			$arr 	= $this->dbObj->fetchAssoc($rs);
			if((count($arr) > 0) && ($arr[0]['area_name'] !="")){
				return $arr[0]['area_name'];
			} {
				return false;
			}
		}
	}
	function fun_getRegionNameById($region_id = '') {
		if($region_id == '') {
			return false;
		} else {
			$sql 	= "SELECT region_name FROM " . TABLE_REGION . " WHERE region_id ='".$region_id."'";
			$rs 	= $this->dbObj->createRecordset($sql);
			$arr 	= $this->dbObj->fetchAssoc($rs);
			if((count($arr) > 0) && ($arr[0]['region_name'] !="")){
				return $arr[0]['region_name'];
			} {
				return false;
			}
		}
	}

	function fun_getLocationNameById($location_id = '') {
		if($location_id == '') {
			return false;
		} else {
			$sql 	= "SELECT location_name FROM " . TABLE_LOCATION . " WHERE location_id ='".$location_id."'";
			$rs 	= $this->dbObj->createRecordset($sql);
			$arr 	= $this->dbObj->fetchAssoc($rs);
			if((count($arr) > 0) && ($arr[0]['location_name'] !="")){
				return $arr[0]['location_name'];
			} {
				return false;
			}
		}
	}

	/*
	* Return location name: End Here
	*/

	function fun_countLocationsByRegionid($region_id = '') {
		$sql = "SELECT location_id FROM " . TABLE_LOCATION. " WHERE region_id ='".$region_id."'";
		$rs 	= $this->dbObj->createRecordset($sql);
		return $this->dbObj->getRecordCount($rs);
	}

	function fun_countSubRegionByRegionid($region_id = '') {
		$sql 	= "SELECT region_id FROM " . TABLE_REGION . " WHERE pregion_id ='".$region_id."'";
		$rs 	= $this->dbObj->createRecordset($sql);
		return $this->dbObj->getRecordCount($rs);
	}

	function fun_countRegionByAreaid($area_id = '') {
		$sql 	= "SELECT region_id FROM " . TABLE_REGION . " WHERE area_id ='".$area_id."'";
		$rs 	= $this->dbObj->createRecordset($sql);
		return $this->dbObj->getRecordCount($rs);
	}

	// Function for creating region option list, if region id is given it must be selected
	function fun_getRegionListOptionstest($region_id='', $pregion_id='', $area_id=''){		
		$selected = "";
		$where = array();

		$sql = "SELECT * FROM " . TABLE_REGION . " ";
		if($pregion_id !=""){
			array_push($where, "pregion_id='".(int)fun_db_input($pregion_id)."' ");
		}
		if($area_id !=""){
			array_push($where, "area_id='".(int)fun_db_input($area_id)."' ");
		}

		if(sizeof($where) > 0){
			$sql .= " WHERE ".join($where, " AND ");
		}

		echo $sql .= " ORDER BY region_name";

	}

	// Function for creating region option list, if region id is given it must be selected
	function fun_getRegionListOptions($region_id='', $pregion_id='', $area_id=''){		
		$selected = "";
		$where = array();

		$sql = "SELECT * FROM " . TABLE_REGION . " ";
		if($pregion_id !=""){
			array_push($where, "pregion_id='".(int)fun_db_input($pregion_id)."' ");
		}
		if($area_id !=""){
			array_push($where, "area_id='".(int)fun_db_input($area_id)."' ");
		}

		if(sizeof($where) > 0){
			$sql .= " WHERE ".join($where, " AND ");
		}

		$sql .= " ORDER BY region_name";

		$result = $this->dbObj->fun_db_query($sql);
		while($rowsCon = $this->dbObj->fun_db_fetch_rs_object($result)){
			if($rowsCon->region_id == $region_id  && $region_id!=''){
				$selected = "selected";
			}else{
				$selected = "";
			}
			echo "<option value=\"".fun_db_output($rowsCon->region_id)."\" " .$selected. ">";
			echo fun_db_output(ucwords($rowsCon->region_name));
			echo "</option>\n";
		}		
		$this->dbObj->fun_db_free_resultset($result);
	}
	
	// Function for creating array for javascript code
	function funRegionJavascriptCode(){
		$sql = "SELECT * FROM " . TABLE_REGION . " ORDER BY region_name";
		$result = $this->dbObj->fun_db_query($sql);
		$cnt = 0;
		while($rows = $this->dbObj->fun_db_fetch_rs_object($result)){
			echo " regArray[".$cnt ."] = new Array(".(int)$rows->region_id.", \"".fun_db_output($rows->region_name)."\", ".(int)$rows->sr_id.");";
			echo "\n";
			$cnt++;
		}
		$this->dbObj->fun_db_free_resultset($rsDtypes);
	}
/*
Region Functions : End Here
*/

/*
Area Functions : Start Here
*/
	// Function for area info	
	function fun_getAreaInfo($area_id=''){
		$regionArray = array();
		$sql = "SELECT * FROM " . TABLE_AREA . " WHERE area_id='".(int)fun_db_input($area_id)."'";
		$result = $this->dbObj->fun_db_query($sql);
		if($this->dbObj->fun_db_get_num_rows($result) > 0){
			$rowsArray = $this->dbObj->fun_db_fetch_rs_object($result);
			$areaArray['area_id'] 		= fun_db_output($rowsArray->area_id);
			$areaArray['country_id'] 		= fun_db_output($rowsArray->country_id);
			$areaArray['area_name'] 		= fun_db_output($rowsArray->area_name);
		}
		$this->dbObj->fun_db_free_resultset($result);
		return $areaArray ;
	}
	
	// Function for creating area option list, if area id is given it must be selected
	function fun_getAreaListOptions($area_id='', $country_id=''){
		
		$selected = "";
		$where = array();

		$sql = "SELECT * FROM " . TABLE_AREA . " ";
		if($country_id !=""){
			array_push($where, "country_id='".(int)fun_db_input($country_id)."' ");
		}

		if(sizeof($where) > 0){
			$sql .= " WHERE ".join($where, " AND ");
		}

		$sql .= " ORDER BY area_name";

		$result = $this->dbObj->fun_db_query($sql);
		while($rowsCon = $this->dbObj->fun_db_fetch_rs_object($result)){
			if($rowsCon->area_id == $area_id  && $area_id!=''){
				$selected = "selected";
			}else{
				$selected = "";
			}
			echo "<option value=\"".fun_db_output($rowsCon->area_id)."\" " .$selected. ">";
			echo fun_db_output(ucwords($rowsCon->area_name));
			echo "</option>\n";
		}		
		$this->dbObj->fun_db_free_resultset($result);
	}
	
	// Function for creating array for javascript code
	function funAreaJavascriptCode(){
		$sql = "SELECT * FROM " . TABLE_AREA . " ORDER BY area_name";
		$result = $this->dbObj->fun_db_query($sql);
		$cnt = 0;
		while($rows = $this->dbObj->fun_db_fetch_rs_object($result)){
			echo " regArray[".$cnt ."] = new Array(".(int)$rows->area_id.", \"".fun_db_output($rows->area_name)."\", ".(int)$rows->sr_id.");";
			echo "\n";
			$cnt++;
		}
		$this->dbObj->fun_db_free_resultset($rsDtypes);
	}
/*
Area Functions : End Here
*/



	/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
	/*+++   THIS FUNCTION IS FOR LOCATION IN GOOGLE MAP START	+++++++++*/
	function fun_getLocationListOptionsForGMap($locID=''){		
		$selected = "";
		/*if($locID==''){
			$locID = 13;
		}*/
		$sql = trim($sql);
		$sql = "SELECT * FROM " . TABLE_LOCATION. " ORDER BY location_name";
		$result = $this->dbObj->fun_db_query($sql);
		while($rowsCon = $this->dbObj->fun_db_fetch_rs_object($result)){
			if($rowsCon->location_id == $locID  && $locID!=''){
				$selected = "selected";
			}else{
				$selected = "";
			}
			echo "<option value=\"".fun_db_output($rowsCon->location_name)."\" " .$selected. ">";
			echo fun_db_output($rowsCon->location_name);
			echo "</option>\n";
		}		
		$this->dbObj->fun_db_free_resultset($result);
	}
	/*+++   THIS FUNCTION IS FOR LOCATION IN GOOGLE MAP END		+++++++++*/
	/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++====++++++*/


	/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
	/*+++   THIS FUNCTION CREATE LOCATION FOR GOOGLE MAP START	+++++++++*/
	function funLocationJavascriptCode4GoogleMap(){
		$sql = "";
		//"SELECT sr.sr_name, lo.location_name FROM ol_tbl_location lo, ol_tbl_sub_region sr WHERE lo.sr_id = sr.sr_id AND location_status=1 GROUP BY sr.sr_name ORDER BY location_name";
		$sql = "SELECT sr.sr_name, lo.location_name FROM " . TABLE_LOCATION . " lo, ". TABLE_SUB_REGION ." sr WHERE lo.sr_id = sr.sr_id AND location_status=1 ORDER BY lo.location_name";//GROUP BY sr.sr_name
		$result = $this->dbObj->fun_db_query($sql);
		$cnt = 0;
		while($rows = $this->dbObj->fun_db_fetch_rs_object($result)){
			echo " locArray[".$cnt ."] = new Array('".fun_db_output($rows->location_name)."', \"".fun_db_output($rows->location_name)."\", '".fun_db_output($rows->sr_name)."');";
			echo "\n";
			$cnt++;
		}
		$this->dbObj->fun_db_free_resultset($rsDtypes);
	}
	/*+++   THIS FUNCTION CREATE LOCATION FOR GOOGLE MAP END	+++++++++*/
	/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++====++++++*/

	function fun_get_num_rows($sql){
		$totalRows = 0;
		$selected = "";
		$sql = trim($sql);
		if($sql==""){
			die("<font color='#ff0000' face='verdana' face='2'>Error: Query is Empty!</font>");
			exit;
		}
		$result = $this->dbObj->fun_db_query($sql);
		$totalRows = $this->dbObj->fun_db_get_num_rows($result);
		$this->dbObj->fun_db_free_resultset($result);
		return $totalRows;
	}
}
?>