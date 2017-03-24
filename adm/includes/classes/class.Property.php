<?php
class Property{
	var $dbObj;
	
	function Property(){ // class constructor
		$this->dbObj = new DB();
		$this->dbObj->fun_db_connect();
	}
	
	// This function will Return property information in array with front end data	
	function fun_getPropertyInfo($property_id){		
		$propertyInfoArray 	= array();		
		$sql = "SELECT * FROM " . TABLE_PROPERTY . " WHERE property_id='".$property_id."'";
		$result = $this->dbObj->fun_db_query($sql);
		if($this->dbObj->fun_db_get_num_rows($result) > 0){
			$rowsArray = $this->dbObj->fun_db_fetch_rs_object($result);
			$propertyInfoArray['property_id'] 		= fun_db_output($rowsArray->property_id);
			$propertyInfoArray['property_pid'] 		= fun_db_output($rowsArray->property_pid);
			$propertyInfoArray['property_type'] 	= fun_db_output($rowsArray->property_type);
			$propertyInfoArray['catering_type'] 	= fun_db_output($rowsArray->catering_type);
			$propertyInfoArray['property_name'] 	= fun_db_output($rowsArray->property_name);
			$propertyInfoArray['property_title'] 	= fun_db_output($rowsArray->property_title);
			$propertyInfoArray['property_summary'] 	= fun_db_output($rowsArray->property_summary);
			$propertyInfoArray['description'] 		= fun_db_output($rowsArray->description);
			$propertyInfoArray['country_id'] 		= fun_db_output($rowsArray->country_id);
			$propertyInfoArray['area_id'] 			= fun_db_output($rowsArray->area_id);
			$propertyInfoArray['region_id'] 		= fun_db_output($rowsArray->region_id);
			$propertyInfoArray['subregion_id'] 		= fun_db_output($rowsArray->subregion_id);
			$propertyInfoArray['location_id'] 		= fun_db_output($rowsArray->location_id);
			$propertyInfoArray['zip'] 				= fun_db_output($rowsArray->zip);
			$propertyInfoArray['latitude'] 			= fun_db_output($rowsArray->latitude);
			$propertyInfoArray['longitude'] 		= fun_db_output($rowsArray->longitude);
			$propertyInfoArray['map_zoom_level'] 	= fun_db_output($rowsArray->map_zoom_level);
			$propertyInfoArray['status'] 			= fun_db_output($rowsArray->status);
			$propertyInfoArray['rating'] 			= fun_db_output($rowsArray->rating);
			$propertyInfoArray['friendly_link'] 	= fun_db_output($rowsArray->friendly_link);
			$propertyInfoArray['created_on'] 		= fun_db_output($rowsArray->created_on);
			$propertyInfoArray['created_by'] 		= fun_db_output($rowsArray->created_by);
			$propertyInfoArray['updated_on'] 		= fun_db_output($rowsArray->updated_on);
			$propertyInfoArray['updated_by'] 		= fun_db_output($rowsArray->updated_by);
			$propertyInfoArray['featured'] 			= fun_db_output($rowsArray->featured);
			$propertyInfoArray['active'] 			= fun_db_output($rowsArray->active);

			/*
			* Extended functionalitiy : This is process to search if any relation table value exist
			* then add these results to info array
			*/
			
			// For Bed rooms
			if(($bed_relation_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_BEDROOM_RELATIONS , " WHERE property_id='".$property_id."'")) && (is_array($bed_relation_array))){
			$propertyInfoArray['total_beds'] 			= $bed_relation_array[0]['total_beds'];
			$propertyInfoArray['ensuite_beds'] 			= $bed_relation_array[0]['ensuite_beds'];
			$propertyInfoArray['scomfort_beds']			= $bed_relation_array[0]['scomfort_beds'];
			$propertyInfoArray['double_beds'] 			= $bed_relation_array[0]['double_beds'];
			$propertyInfoArray['single_beds'] 			= $bed_relation_array[0]['single_beds'];
			$propertyInfoArray['sofa_beds'] 			= $bed_relation_array[0]['sofa_beds'];
			$propertyInfoArray['cots'] 					= $bed_relation_array[0]['cots'];
			$propertyInfoArray['bdrapts1'] 				= $bed_relation_array[0]['bdrapts1'];
			$propertyInfoArray['bdrapts2'] 				= $bed_relation_array[0]['bdrapts2'];
			$propertyInfoArray['bdrapts3'] 				= $bed_relation_array[0]['bdrapts3'];
			$propertyInfoArray['bdrapts4'] 				= $bed_relation_array[0]['bdrapts4'];
			$propertyInfoArray['bdrapts5'] 				= $bed_relation_array[0]['bdrapts5'];
			$propertyInfoArray['complex_unit_type'] 	= $bed_relation_array[0]['complex_unit_type'];
			$propertyInfoArray['bed_notes'] 			= fun_db_output($bed_relation_array[0]['notes']);
			}

			// For Bath rooms
			if(($bath_relation_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_BATHROOM_RELATIONS , " WHERE property_id='".$property_id."'")) && (is_array($bath_relation_array))){

			$propertyInfoArray['total_bathrooms'] 		= $bath_relation_array[0]['total_bathrooms'];
			$propertyInfoArray['ensuite_baths'] 		= $bath_relation_array[0]['ensuite_baths'];
			$propertyInfoArray['shower_baths']			= $bath_relation_array[0]['shower_baths'];
			$propertyInfoArray['baths'] 				= $bath_relation_array[0]['baths'];


			$propertyInfoArray['toilets'] 				= $bath_relation_array[0]['toilets'];
			$propertyInfoArray['bath_notes'] 			= fun_db_output($bath_relation_array[0]['notes']);
			}

			// For feature notes
			if(($feature_note_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_FEATURES_RELATIONS , " WHERE property_id='".$property_id."'")) && (is_array($feature_note_array))){
			$propertyInfoArray['feature_note'] 		= fun_db_output($feature_note_array[0]['feature_notes']);
			}

			// For requiremnt notes
			if(($requiremnt_note_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_SPECIAL_REQUIREMENTS_RELATIONS , " WHERE property_id='".$property_id."'")) && (is_array($requiremnt_note_array))){
			$propertyInfoArray['requirement_note'] 		= fun_db_output($requiremnt_note_array[0]['srequirement_notes']);
			}
			
			// Selling points
			
			if(($selling_points_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_SELLING_POINTS_RELATIONS , " WHERE property_id='".$property_id."'")) && (is_array($selling_points_array))){
			$propertyInfoArray['selling_point1'] 		= fun_db_output($selling_points_array[0]['selling_point']);
			$propertyInfoArray['selling_point2'] 		= fun_db_output($selling_points_array[1]['selling_point']);
			$propertyInfoArray['selling_point3'] 		= fun_db_output($selling_points_array[2]['selling_point']);
			$propertyInfoArray['selling_point4'] 		= fun_db_output($selling_points_array[3]['selling_point']);
			$propertyInfoArray['selling_point5'] 		= fun_db_output($selling_points_array[4]['selling_point']);
			$propertyInfoArray['selling_point6'] 		= fun_db_output($selling_points_array[5]['selling_point']);
			$propertyInfoArray['selling_point7'] 		= fun_db_output($selling_points_array[6]['selling_point']);
			$propertyInfoArray['selling_point8'] 		= fun_db_output($selling_points_array[7]['selling_point']);
			$propertyInfoArray['selling_point9'] 		= fun_db_output($selling_points_array[8]['selling_point']);
			$propertyInfoArray['selling_point10'] 		= fun_db_output($selling_points_array[9]['selling_point']);
			}

			// Prooperty tag
			
			if(($tags_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_TAGS , " WHERE property_id='".$property_id."'")) && (is_array($tags_array))){
				$propertyInfoArray['tagid1'] 		= fun_db_output($tags_array[0]['id']);
				$propertyInfoArray['tagid2'] 		= fun_db_output($tags_array[1]['id']);
				$propertyInfoArray['tagid3'] 		= fun_db_output($tags_array[2]['id']);
				$propertyInfoArray['tagid4'] 		= fun_db_output($tags_array[3]['id']);
				$propertyInfoArray['tagid5'] 		= fun_db_output($tags_array[4]['id']);

				$propertyInfoArray['tag1'] 		= fun_db_output($this->fun_getPropertyTagNameByCode($tags_array[0]['tag_name']));
				$propertyInfoArray['tag2'] 		= fun_db_output($this->fun_getPropertyTagNameByCode($tags_array[1]['tag_name']));
				$propertyInfoArray['tag3'] 		= fun_db_output($this->fun_getPropertyTagNameByCode($tags_array[2]['tag_name']));
				$propertyInfoArray['tag4'] 		= fun_db_output($this->fun_getPropertyTagNameByCode($tags_array[3]['tag_name']));
				$propertyInfoArray['tag5'] 		= fun_db_output($this->fun_getPropertyTagNameByCode($tags_array[4]['tag_name']));
			}


			// area notes
			if(($area_notes_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_AREA_NOTES , " WHERE property_id='".$property_id."'")) && (is_array($area_notes_array))){
				$propertyInfoArray['area_notes'] 		= fun_db_output($area_notes_array[0]['area_notes']);
			}

			// price notes
			if(($price_notes_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_PRICE_NOTES , " WHERE property_id='".$property_id."'")) && (is_array($price_notes_array))){
				$propertyInfoArray['price_notes'] 		= fun_db_output($price_notes_array[0]['price_notes']);
				$propertyInfoArray['owner_notes'] 		= fun_db_output($price_notes_array[0]['owner_notes']);
			}

			// area location guide
			if(($location_guides_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_LOCATION_GUIDES , " WHERE property_id='".$property_id."'")) && (is_array($location_guides_array))){
				$propertyInfoArray['location_guide'] 	= fun_db_output($location_guides_array[0]['location_guide']);
			}

			// property unit info
			if(($property_unit_relation_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY , " WHERE property_pid='".$property_id."' ORDER BY property_id LIMIT 0, 4")) && (is_array($property_unit_relation_array))){
				for ( $k = 0; $k < count($property_unit_relation_array) ; $k++) {
					$str = "unit_name".($k+1);
					$str1 = "unit_id".($k+1);
					$propertyInfoArray[$str] 		= fun_db_output($property_unit_relation_array[$k]['property_name']);
					$propertyInfoArray[$str1] 		= $property_unit_relation_array[$k]['property_id'];
				}
			}

			// property contacts
			if(($contacts_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_CONTACTS , " WHERE property_id='".$property_id."'")) && (is_array($contacts_array))){
				$propertyInfoArray['contact_name'] 		= $contacts_array[0]['contact_name'];
				$propertyInfoArray['contact_name_show']	= $contacts_array[0]['contact_name_show'];
				$propertyInfoArray['response_time'] 	= $contacts_array[0]['response_time'];
				$propertyInfoArray['response_time_type']= $contacts_array[0]['response_time_type'];
				$propertyInfoArray['response_time_show']= $contacts_array[0]['response_time_show'];
			}

			// property type name
			if(($property_type_name_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_TYPE , " WHERE pt_id='".$propertyInfoArray['property_type']."'")) && (is_array($property_type_name_array))){
				$propertyInfoArray['property_type_name']= $property_type_name_array[0]['pt_title'];
			}

			// property catering name
			if(($property_catering_name_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_CATERING , " WHERE catering_id='".$propertyInfoArray['catering_type']."'")) && (is_array($property_catering_name_array))){
				$propertyInfoArray['property_catering_name']= $property_catering_name_array[0]['catering_name'];
			}
		}
		$this->dbObj->fun_db_free_resultset($result);
		return $propertyInfoArray;
	}

	// This function will Return property information in array other rental
	function fun_getPropertyInfoByFieldName($field_name, $field_value, $exclude_ids = '', $status = ''){		
		$propertyInfoArray 	= array();		
		$sql = "SELECT * FROM " . TABLE_PROPERTY . " WHERE ".$field_name." ='".$field_value."' " ; 

		if(isset($exclude_ids) && $exclude_ids != "")
			$sql .= "AND property_id NOT IN (".$exclude_ids.") ";

		if(isset($status) && $status != "")
			$sql .= "AND status ='".$status."' ";

		$sql .= " ORDER BY RAND() ";

		$result = $this->dbObj->fun_db_query($sql);
		if($this->dbObj->fun_db_get_num_rows($result) > 0){
			$rowsArray = $this->dbObj->fun_db_fetch_rs_object($result);
			$propertyInfoArray['property_id'] 		= fun_db_output($rowsArray->property_id);
			$propertyInfoArray['property_pid'] 		= fun_db_output($rowsArray->property_pid);
			$propertyInfoArray['property_type'] 	= fun_db_output($rowsArray->property_type);
			$propertyInfoArray['catering_type'] 	= fun_db_output($rowsArray->catering_type);
			$propertyInfoArray['property_name'] 	= fun_db_output($rowsArray->property_name);
			$propertyInfoArray['property_title'] 	= fun_db_output($rowsArray->property_title);
			$propertyInfoArray['property_summary'] 	= fun_db_output($rowsArray->property_summary);
			$propertyInfoArray['country_id'] 		= fun_db_output($rowsArray->country_id);
			$propertyInfoArray['area_id'] 			= fun_db_output($rowsArray->area_id);
			$propertyInfoArray['region_id'] 		= fun_db_output($rowsArray->region_id);
			$propertyInfoArray['subregion_id'] 		= fun_db_output($rowsArray->subregion_id);
			$propertyInfoArray['location_id'] 		= fun_db_output($rowsArray->location_id);
			$propertyInfoArray['status'] 			= fun_db_output($rowsArray->status);
			$propertyInfoArray['rating'] 			= fun_db_output($rowsArray->rating);
			$propertyInfoArray['friendly_link'] 	= fun_db_output($rowsArray->friendly_link);
			$property_id 							= $propertyInfoArray['property_id'];
			/*
			* Extended functionalitiy : This is process to search if any relation table value exist
			* then add these results to info array
			*/
			
			// For Bed rooms
			if(($bed_relation_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_BEDROOM_RELATIONS , " WHERE property_id='".$property_id."'")) && (is_array($bed_relation_array))){
				$propertyInfoArray['total_beds'] 			= $bed_relation_array[0]['total_beds'];
				$propertyInfoArray['ensuite_beds'] 			= $bed_relation_array[0]['ensuite_beds'];
				$propertyInfoArray['scomfort_beds']			= $bed_relation_array[0]['scomfort_beds'];
				$propertyInfoArray['double_beds'] 			= $bed_relation_array[0]['double_beds'];
				$propertyInfoArray['single_beds'] 			= $bed_relation_array[0]['single_beds'];
				$propertyInfoArray['sofa_beds'] 			= $bed_relation_array[0]['sofa_beds'];
				$propertyInfoArray['cots'] 					= $bed_relation_array[0]['cots'];
				$propertyInfoArray['bdrapts1'] 				= $bed_relation_array[0]['bdrapts1'];
				$propertyInfoArray['bdrapts2'] 				= $bed_relation_array[0]['bdrapts2'];
				$propertyInfoArray['bdrapts3'] 				= $bed_relation_array[0]['bdrapts3'];
				$propertyInfoArray['bdrapts4'] 				= $bed_relation_array[0]['bdrapts4'];
				$propertyInfoArray['bdrapts5'] 				= $bed_relation_array[0]['bdrapts5'];
				$propertyInfoArray['complex_unit_type'] 	= $bed_relation_array[0]['complex_unit_type'];
			}

			// For Bath rooms
			if(($bath_relation_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_BATHROOM_RELATIONS , " WHERE property_id='".$property_id."'")) && (is_array($bath_relation_array))){
				$propertyInfoArray['total_bathrooms'] 		= $bath_relation_array[0]['total_bathrooms'];
				$propertyInfoArray['ensuite_baths'] 		= $bath_relation_array[0]['ensuite_baths'];
				$propertyInfoArray['shower_baths']			= $bath_relation_array[0]['shower_baths'];
				$propertyInfoArray['baths'] 				= $bath_relation_array[0]['baths'];
				$propertyInfoArray['toilets'] 				= $bath_relation_array[0]['toilets'];
			}

			// Selling points
			if(($selling_points_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_SELLING_POINTS_RELATIONS , " WHERE property_id='".$property_id."'")) && (is_array($selling_points_array))){
				$propertyInfoArray['selling_point1'] 		= fun_db_output($selling_points_array[0]['selling_point']);
				$propertyInfoArray['selling_point2'] 		= fun_db_output($selling_points_array[1]['selling_point']);
				$propertyInfoArray['selling_point3'] 		= fun_db_output($selling_points_array[2]['selling_point']);
				$propertyInfoArray['selling_point4'] 		= fun_db_output($selling_points_array[3]['selling_point']);
				$propertyInfoArray['selling_point5'] 		= fun_db_output($selling_points_array[4]['selling_point']);
				$propertyInfoArray['selling_point6'] 		= fun_db_output($selling_points_array[5]['selling_point']);
				$propertyInfoArray['selling_point7'] 		= fun_db_output($selling_points_array[6]['selling_point']);
				$propertyInfoArray['selling_point8'] 		= fun_db_output($selling_points_array[7]['selling_point']);
				$propertyInfoArray['selling_point9'] 		= fun_db_output($selling_points_array[8]['selling_point']);
				$propertyInfoArray['selling_point10'] 		= fun_db_output($selling_points_array[9]['selling_point']);
			}
		}
		$this->dbObj->fun_db_free_resultset($result);
		return $propertyInfoArray;
	}

	// This function will Return property information in array with front end data	
	function fun_getPropertyStatSummaryInfo($property_id){		
		$propertyStatSummaryInfoArray 	= array();		
		$sql = "SELECT 	A.*
						A.property_name,
						A.property_title,
						A.property_summary,
						A.location_id,
						A.latitude,
						A.longitude,
						A.status,
						A.rating,
						A.friendly_link,
						FROM_UNIXTIME(A.created_on, '%m/%d/%Y') AS created_on,
						A.created_by,
						FROM_UNIXTIME(A.active_on, '%m/%d/%Y') AS active_on,
						A.active_by,
						FROM_UNIXTIME(A.updated_on, '%m/%d/%Y') AS updated_on,
						A.updated_by,
						A.featured,
						A.active,
						B.location_name
		FROM " . TABLE_PROPERTY . " AS A 
		INNER JOIN " . TABLE_LOCATION . " AS B ON A.location_id = B.location_id 
		WHERE property_id='".$property_id."'";

		$result = $this->dbObj->fun_db_query($sql);
		if($this->dbObj->fun_db_get_num_rows($result) > 0){
			$rowsArray = $this->dbObj->fun_db_fetch_rs_object($result);
			$propertyStatSummaryInfoArray['property_id']		= fun_db_output($rowsArray->property_id);
			$propertyStatSummaryInfoArray['property_name'] 		= fun_db_output($rowsArray->property_name);
			$propertyStatSummaryInfoArray['property_title'] 	= fun_db_output($rowsArray->property_title);
			$propertyStatSummaryInfoArray['property_summary'] 	= fun_db_output($rowsArray->property_summary);
			$propertyStatSummaryInfoArray['location_id'] 		= fun_db_output($rowsArray->location_id);
			$propertyStatSummaryInfoArray['location_name'] 		= fun_db_output($rowsArray->location_name);
			$propertyStatSummaryInfoArray['latitude'] 			= fun_db_output($rowsArray->latitude);
			$propertyStatSummaryInfoArray['longitude'] 			= fun_db_output($rowsArray->longitude);
			$propertyStatSummaryInfoArray['created_on'] 		= fun_db_output($rowsArray->created_on);
			$propertyStatSummaryInfoArray['active_on'] 			= fun_db_output($rowsArray->active_on);
			$propertyStatSummaryInfoArray['updated_on'] 		= fun_db_output($rowsArray->updated_on);
			$propertyStatSummaryInfoArray['featured'] 			= fun_db_output($rowsArray->featured);
			$propertyStatSummaryInfoArray['active'] 			= fun_db_output($rowsArray->active);

			/*
			* Extended functionalitiy : This is process to search if any relation table value exist
			* then add these results to info array
			*/
			
			// For checklist status
			if(($checklist_relation_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_CHECKLIST_SETTINGS , " WHERE property_id='".$property_id."'")) && (is_array($checklist_relation_array))){
				if(($checklist_relation_array[0]['holiday_ptype'] != "") && ($checklist_relation_array[0]['holiday_type'] != "") && ($checklist_relation_array[0]['accommodation_type'] != "") && ($checklist_relation_array[0]['amenities_type'] != "")){
					$propertyStatSummaryInfoArray['checklist_status'] = "1";
				}
				else{
					$propertyStatSummaryInfoArray['checklist_status'] = "0";
				}
			}
			else{
				$propertyStatSummaryInfoArray['checklist_status'] = "0";
			}

			// For property main photo info
			if(($photo_relation_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_PHOTO_ALL , " WHERE property_id='".$property_id."' AND photo_main='1' ")) && (is_array($photo_relation_array))){
				$propertyStatSummaryInfoArray['photo_caption'] 	= $photo_relation_array[0]['photo_caption'];
				$propertyStatSummaryInfoArray['photo_url'] 		= $photo_relation_array[0]['photo_url'];
				$propertyStatSummaryInfoArray['photo_thumb'] 	= $photo_relation_array[0]['photo_thumb'];
			}

		}
		$this->dbObj->fun_db_free_resultset($result);
		return $propertyStatSummaryInfoArray;
	}

	// Function to add property owner web info array
	function fun_addPropertyOwnerWebInfo($property_id, $owner_website_url, $ol_link_url, $website_type) {
		if($property_id == ''){
			return false;
		} else {
			$cur_unixtime 	= time ();
			$cur_user_id 	= $_SESSION['ses_user_id'];
			if(($ownerweb_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_OWNERWEBSITE_RELATIONS , " WHERE property_id='".$property_id."'")) && (is_array($ownerweb_array))){
				$id = $ownerweb_array[0]['id'];
				$sqlUpdateQuery = "UPDATE " . TABLE_PROPERTY_OWNERWEBSITE_RELATIONS . " SET owner_website_url='".$owner_website_url."', ol_link_url='".$ol_link_url."', website_type='".$website_type."', updated_by='" . $cur_user_id . "', updated_on='" . $cur_unixtime . "', status='0' WHERE property_id='".(int)$property_id."' AND id='".(int)$id."'";
				$this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
				return true;
			} else {
				$strInsQuery = "INSERT INTO " . TABLE_PROPERTY_OWNERWEBSITE_RELATIONS . "(id, property_id, owner_website_url, ol_link_url, website_type, created_on, created_by, updated_on, updated_by, status) ";
				$strInsQuery .= "VALUES(null, '".$property_id."', '".$owner_website_url."', '".$ol_link_url."', '".$website_type."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."', '0')";
				$this->dbObj->mySqlSafeQuery($strInsQuery);
				return true;
			}
		}
	}

	// Function to get property owner web info array
	function fun_getPropertyOwnerWebInfo($property_id = ''){	
		if($property_id == ''){
			return false;
		} else {
			if(($ownerweb_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_OWNERWEBSITE_RELATIONS , " WHERE property_id='".$property_id."'")) && (is_array($ownerweb_array))){
				return $ownerweb_array;
			} else {
				return false;
			}
		}
	}

	// Function to check property owner 
	function fun_checkPropertyOwner($property_id, $user_id) {
		$sql 	= "SELECT B.property_id 
		FROM " . TABLE_PROPERTY_OWNER_RELATIONS . " AS A
		LEFT JOIN " . TABLE_PROPERTY . " AS B ON A.property_id = B.property_id
		WHERE B.property_id='".$property_id."' AND A.owner_id='".$user_id."'";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			return true;
		} else {
			return false;
		}
	}

	function fun_checkPropertyLive($property_id) {
		if($property_id != ''){
			$sql 	= "SELECT property_id FROM " . TABLE_PROPERTY . " WHERE property_id='".$property_id."' AND status='2' AND active='1' ";
			$rs 	= $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				return true;
			} else {
				redirectURL(SITE_URL."accommodation");
			}
		} else {
			redirectURL(SITE_URL."accommodation");
		}
	}

	// Function for get property added date
	function fun_getPropertyAddedDate($property_id){
		if($property_id ==""){
			return "";
		}
		else{
            $sql = "SELECT FROM_UNIXTIME(created_on, '%m/%d/%Y') AS created_on FROM " . TABLE_PROPERTY . " WHERE property_id='".$property_id."'";
            $rs = $this->dbObj->createRecordset($sql);
            $arr = $this->dbObj->fetchAssoc($rs);
            return $arr[0]['created_on'];
        }
	}

	// Function for get property last updated date
	function fun_getPropertyUpdatedDate($property_id){
		if($property_id ==""){
			return "";
		}
		else{
            $sql = "SELECT FROM_UNIXTIME(updated_on, '%m/%d/%Y') AS updated_on FROM " . TABLE_PROPERTY . " WHERE property_id='".$property_id."'";
            $rs = $this->dbObj->createRecordset($sql);
            $arr = $this->dbObj->fetchAssoc($rs);
            return $arr[0]['updated_on'];
        }
	}

	// This function will convert currency values
	function fun_getConvertedCurrency($act_currency_id, $res_currency_id, $currency_value){
		if(($act_currency_id =="") || ($res_currency_id =="") || ($currency_value =="")){
			return 0;
		} else {
			$sql = "SELECT * FROM " . TABLE_CURRENCIES . " WHERE currency_id IN ('".$act_currency_id."','".$res_currency_id."')";
			$rs = $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);
				foreach($arr as $value) {
					if($value['currency_id'] == $act_currency_id) {
						$act_currency_rate = $value['currency_rate'];
					}
					if($value['currency_id'] == $res_currency_id) {
						$res_currency_rate = $value['currency_rate'];
					}
				}
				return (($currency_value / $act_currency_rate)*$res_currency_rate);
			} else {
				return "0";
			}
		}
	}

	function fun_findCurrencyCodeName($currency_id){
		$currency_code = $this->dbObj->getField(TABLE_CURRENCIES, "currency_id", $currency_id, "currency_code");
		return $currency_code;
	}

	// This function will Return currency code of property
	function fun_findPropertyCurrencyCode($property_id){
		if($property_id ==""){
			return "1";
		} else {
			if(($property_currency_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_PRICES , " WHERE property_id='".$property_id."'")) && (is_array($property_currency_array))){
				return $property_currency_array[0]['currency_code'];
			} else {
				return "1";
			}
		}
	}

	// This function will Return currency code of property
	function fun_findPropertyPriceCode($property_id){
		if($property_id ==""){
			return "1";
		} else {
			if(($property_currency_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_PRICES , " WHERE property_id='".$property_id."'")) && (is_array($property_currency_array))){
				return $property_currency_array[0]['price_type'];
			} else {
				return "1";
			}
		}
	}


	// This function will Return currency symbol of property
	function fun_findPropertyCurrencySymbol($property_id, $currency_code = '') {
		if($property_id !="" && $currency_code == "" &&  ($property_currency_id_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_PRICES , " WHERE property_id='".$property_id."'")) && (is_array($property_currency_id_array))){
			$currency_code = $property_currency_id_array[0]['currency_code'];
			$property_currency_array = $this->fun_findPropertyRelationInfo(TABLE_CURRENCIES , " WHERE currency_id='".$currency_code."'");
	//	echo $property_currency_array ;
			return $property_currency_array[0]['currency_symbol'];
		} else if($property_id =="" && $currency_code !="" && ($property_currency_array = $this->fun_findPropertyRelationInfo(TABLE_CURRENCIES , " WHERE currency_id='".$currency_code."'")) && (is_array($property_currency_array))){
			return $property_currency_array[0]['currency_symbol'];
		} else {
			return "$";
		}
	}

	// This function will Return currency name of property
	function fun_findPropertyCurrencyName($property_id) {
		if($property_id !="" && ($property_currency_id_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_PRICES , " WHERE property_id='".$property_id."'")) && (is_array($property_currency_id_array))){
			$currency_code = $property_currency_id_array[0]['currency_code'];
			$property_currency_array = $this->fun_findPropertyRelationInfo(TABLE_CURRENCIES , " WHERE currency_id='".$currency_code."'");
			return $property_currency_array[0]['currency_name'];;
		} else {
			return "american dollar";
		}
	}

	// This function will Return property name
	function fun_getPropertyName($property_id){		
		$propertyName 	= "";		
		$property_relation_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY , " WHERE property_id='".$property_id."'");
		
//		print_r($property_relation_array);
		if ( $property_relation_array[0]['property_pid'] != "0") {
			$property_pid = $property_relation_array[0]['property_pid'];
			$property_prelation_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY , " WHERE property_id='".$property_pid."'");
			$propertyName 	= $property_prelation_array[0]['property_name'];
		} else {
			$propertyName 	= $property_relation_array[0]['property_name'];
		}
		return fun_db_output($propertyName);
	}

	// This function will Return property name
	function fun_getPropertyUnitId($property_id){		
		if(($property_relation_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY , " WHERE property_pid='".$property_id."' ORDER BY property_id LIMIT 0, 1")) && (is_array($property_relation_array))){
			$propertyUnitId = $property_relation_array[0]['property_id'];
		} else {
			$propertyUnitId = $property_id;
		}
		return $propertyUnitId;
	}

	// This function will Return property title
	function fun_getPropertyTitleName($property_id){		
		$propertyTitleName 	= "";		
		$property_relation_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY , " WHERE property_id='".$property_id."'");
		if ( $property_relation_array[0]['property_pid'] != "0") {
			$property_pid = $property_relation_array[0]['property_pid'];
			$property_prelation_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY , " WHERE property_id='".$property_pid."'");
			$propertyTitleName 	= $property_prelation_array[0]['property_title'];
		} else {
			$propertyTitleName 	= $property_relation_array[0]['property_title'];
		}
		return fun_db_output($propertyTitleName);
	}

	// This function will Return data in array
	function fun_findPropertyRelationInfo($table, $criteria){		
		$sql = "SELECT * FROM " .$table. " " .$criteria. "";
		//echo($sql);
		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			return $arr = $this->dbObj->fetchAssoc($rs);	
		} else {
			return false;
		}
	}

	// This function will find availability of friendly link for propertis
	function fun_suggestPropertyFriendlyLinks($property_id){
		$sql 	= "SELECT property_name FROM " . TABLE_PROPERTY . " WHERE property_id='".$property_id."'";
		$rs 	= $this->dbObj->createRecordset($sql);
		$arr 	= $this->dbObj->fetchAssoc($rs);		
		$friendly_link 	= replace_NonAlphaNumChars(strtolower($arr[0]['property_name']), TABLE_PROPERTY, "property_id", $property_id, "friendly_link");
		if($this->fun_checkAvailabilityPropertyUrl($property_id, $friendly_link) == false) {
			return $friendly_link;
		} else {
			$i = 1;
			while ($this->fun_checkAvailabilityPropertyUrl($property_id, $friendly_link) == false) {
			   $friendly_link = $friendly_link."-".$i++;
			}
			return $friendly_link;
		}
	}

	// This function will find availability of friendly link for propertis
	function fun_checkAvailabilityPropertyUrl($property_id = '', $friendly_link){
		$sql = "SELECT friendly_link FROM " . TABLE_PROPERTY . " WHERE friendly_link='".$friendly_link."'";
		if($property_id != "") {
		$sql .= " AND property_id NOT IN (".$property_id.")";
		}
		$result = $this->dbObj->fun_db_query($sql);
		if($this->dbObj->fun_db_get_num_rows($result) > 0){
			return true;
		} else {
			return false;
		}
	}

	// This function will Return property information in array with back end data (eg, location_id of property table)
	function fun_getPropertyRawInfo($property_id){		
		$propertyInfoRawArray 	= array();		
		$sql = "";
		$result = $this->dbObj->fun_db_query($sql);
		if($this->dbObj->fun_db_get_num_rows($result) > 0){
			$rowsArray = $this->dbObj->fun_db_fetch_rs_object($result);
			$propertyInfoRawArray['property_id'] = fun_db_output($rowsArray->property_id);
		}
		$this->dbObj->fun_db_free_resultset($result);
		return $propertyInfoRawArray;
	}

	//Add New property
	function fun_addProperty($property_pid ='', $property_type ='', $catering_type ='', $property_name ='', $property_title ='', $property_summary ='', $description ='', $country_id ='', $area_id ='', $region_id ='', $subregion_id ='', $location_id =''){
		if($property_type == '' || $property_title == '') {
			return false;
		} else {
			$cur_unixtime 	= time ();
			if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !="") {
				$cur_user_id 	= $_SESSION['ses_admin_id'];
			} else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !="") {
				$cur_user_id 	= $_SESSION['ses_modarator_id'];
			} else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !="") {
				$cur_user_id 	= $_SESSION['ses_user_id'];
			} else {
				$cur_user_id 	= "";
			}
	
			if($property_pid !=""){
				$property_pid	= $property_pid;
			} else {
				$property_pid	= 0;
			}

			$field_names 	= array("property_pid", "property_type", "catering_type", "property_name", "property_title", "property_summary", "description", "country_id", "area_id", "region_id", "subregion_id", "location_id", "zip", "latitude", "longitude", "status", "statuschanged_on", "rating", "friendly_link", "created_on", "created_by", "active_on", "active_by", "updated_on", "updated_by", "featured", "active");
			$field_values 	= array($property_pid, $property_type, $catering_type, $property_name, $property_title, $property_summary, $description, $country_id, $area_id, $region_id, $subregion_id, $location_id, '', '', '', '1', $cur_unixtime, '0', '', $cur_unixtime, $cur_user_id, '', '', $cur_unixtime, $cur_user_id, '0', '0');
			$this->dbObj->insertFields(TABLE_PROPERTY, $field_names, $field_values);
			return $this->dbObj->getIdentity();
		}
	}

	//Add New property by Feed
	function fun_importPropertyFromFeed($item){
		$cur_unixtime 		= time ();
		if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !=""){
			$cur_user_id 	= $_SESSION['ses_admin_id'];
		} else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !=""){
			$cur_user_id 	= $_SESSION['ses_modarator_id'];
		} else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !=""){
			$cur_user_id 	= $_SESSION['ses_user_id'];
		} else {
			$cur_user_id 	= "";
		}

		$property_id 	= $item->id;
		$url 			= $item->url;
		$inquiry_url 	= $item->inquiry_url;
		$property_type	= ($item->category == "housing/rent/vacation")?"27":"17";
		$catering_type 	= "1";
		$expire_time 	= $item->expire_time;
		$property_name	= $item->title;
		$property_title	= $item->title;
		$property_summary 	= ucfirst(substr($item->description, 0, 210));
		$description 	= $item->description;

		foreach($item->location as $loc) {
			$country_id = $this->dbObj->getField(TABLE_COUNTRIES, "countries_iso_code_2", $loc->country_code, "countries_id");
			switch($loc->state_code) {
				case 'AL': $area_name = "Alabama";break;
				case 'AK': $area_name = "Alaska";break;
				case 'AZ': $area_name = "Arizona";break;
				case 'AR': $area_name = "Arkansas";break;
				case 'CA': $area_name = "California";break;
				case 'CO': $area_name = "Colorado";break;
				case 'CT': $area_name = "Connecticut";break;
				case 'DE': $area_name = "Delaware";break;
				case 'FL': $area_name = "Florida";break;
				case 'GA': $area_name = "Georgia";break;
				case 'HI': $area_name = "Hawaii";break;
				case 'ID': $area_name = "Idaho";break;
				case 'IL': $area_name = "Illinois";break;
				case 'IN': $area_name = "Indiana";break;
				case 'IA': $area_name = "Iowa";break;
				case 'KS': $area_name = "Kansas";break;
				case 'KY': $area_name = "Kentucky";break;
				case 'LA': $area_name = "Louisiana";break;
				case 'ME': $area_name = "Maine";break;
				case 'MD': $area_name = "Maryland";break;
				case 'MA': $area_name = "Massachusetts";break;
				case 'MI': $area_name = "Michigan";break;
				case 'MN': $area_name = "Minnesota";break;
				case 'MS': $area_name = "Mississippi";break;
				case 'MO': $area_name = "Missouri";break;
				case 'MT': $area_name = "Montana";break;
				case 'NE': $area_name = "Nebraska";break;
				case 'NV': $area_name = "Nevada";break;
				case 'NH': $area_name = "New Hampshire";break;
				case 'NJ': $area_name = "New Jersey";break;
				case 'NM': $area_name = "New Mexico";break;
				case 'NY': $area_name = "New York";break;
				case 'NC': $area_name = "North Carolina";break;
				case 'ND': $area_name = "North Dakota";break;
				case 'OH': $area_name = "Ohio";break;
				case 'OK': $area_name = "Oklahoma";break;
				case 'OR': $area_name = "Oregon";break;
				case 'PA': $area_name = "Pennsylvania";break;
				case 'RI': $area_name = "Rhode Island";break;
				case 'SC': $area_name = "South Carolina";break;
				case 'SD': $area_name = "South Dakota";break;
				case 'TN': $area_name = "Tennessee";break;
				case 'TX': $area_name = "Texas";break;
				case 'UT': $area_name = "Utah";break;
				case 'VT': $area_name = "Vermont";break;
				case 'VA': $area_name = "Virginia";break;
				case 'WA': $area_name = "Washington";break;
				case 'WV': $area_name = "West Virginia";break;
				case 'WI': $area_name = "Wisconsin";break;
				case 'WY': $area_name = "Wyoming";break;
			}
			$area_id 		= $this->dbObj->getField(TABLE_AREA, "area_name", $area_name, "area_id");
			$region_id 		= $this->fun_getRegionId($area_id, $loc->city);
			$location_id 	= $this->fun_getLocationId($region_id, $loc->address, $loc->zip_code);
			$zip 			= $loc->zip_code;
			$latitude 		= $loc->latitude;
			$longitude 		= $loc->longitude;
			$map_zoom_level = "10";
		}

		$sql 	= "SELECT * FROM " . TABLE_PROPERTY . " WHERE property_id ='".(int)$property_id."'";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) { //Update property
			$propArray = array(							
				"property_id" 		=> $property_id,
				"property_type" 	=> $property_type,
				"catering_type" 	=> $catering_type,
				"property_name" 	=> $property_name,
				"property_title"	=> $property_title,
				"property_summary" 	=> $property_summary,
				"description" 		=> $description,
				"country_id" 		=> $country_id,
				"area_id" 			=> $area_id,
				"region_id" 		=> $region_id,
				"subregion_id" 		=> $subregion_id,
				"location_id" 		=> $location_id,
				"zip" 				=> $zip,
				"latitude" 			=> $latitude,
				"longitude" 		=> $longitude,
				"map_zoom_level" 	=> $map_zoom_level,
				"status" 			=> "2",
				"statuschanged_on"	=> $cur_unixtime,
				"created_on" 		=> $cur_unixtime,
				"created_by" 		=> $cur_user_id,
				"active_on" 		=> $cur_unixtime,
				"active_by" 		=> $cur_user_id,
				"updated_on" 		=> $cur_unixtime,
				"updated_by" 		=> $cur_user_id,
				"active"	 		=> "1"
			);
	
			$fields = "";
			foreach($propArray as $keys => $vals){
				$fields .= $keys . "='" . fun_db_input($vals). "', ";
			}
			if($fields!=""){
				$fields = substr($fields,0,strlen($fields)-2);
				$sqlUpdate = "UPDATE " . TABLE_PROPERTY . " SET " . $fields . " WHERE property_id='".(int)$property_id."'";
				$this->dbObj->mySqlSafeQuery($sqlUpdate);
			}
		} else {
			$field_names 	= array("property_id", "property_pid", "property_type", "catering_type", "property_name", "property_title", "property_summary", "description", "country_id", "area_id", "region_id", "subregion_id", "location_id", "zip", "latitude", "longitude", "map_zoom_level", "status", "statuschanged_on", "rating", "friendly_link", "created_on", "created_by", "active_on", "active_by", "updated_on", "updated_by", "featured", "active");
			$field_values 	= array($property_id, "0", $property_type, $catering_type, $property_name, $property_title, $property_summary, $description, $country_id, $area_id, $region_id, $subregion_id, $location_id, $zip, $latitude, $longitude, $map_zoom_level, '2', $cur_unixtime, '0', '', $cur_unixtime, $cur_user_id, $cur_unixtime, $cur_user_id, $cur_unixtime, $cur_user_id, '0', '1');
			$this->dbObj->insertFields(TABLE_PROPERTY, $field_names, $field_values);
			//$property_id 	= $this->dbObj->getIdentity();
		}

		// Update friendly_link
		$friendly_link 	= $property_name;
		$this->fun_generateFriendlyLink($property_id, $friendly_link);

		// Delete from TABLE_PROPERTY_SELLING_POINTS_RELATIONS
		$strDelQuery = "DELETE FROM " . TABLE_PROPERTY_CONTACTS . " WHERE property_id='".$property_id."'";
		$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

		// Delete from TABLE_PROPERTY_SELLING_POINTS_RELATIONS
		$strDelQuery = "DELETE FROM " . TABLE_PROPERTY_PRICES . " WHERE property_id='".$property_id."'";
		$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

		// Delete from TABLE_PROPERTY_SELLING_POINTS_RELATIONS
		$strDelQuery = "DELETE FROM " . TABLE_PROPERTY_CONTACT_NUMBERS . " WHERE property_id='".$property_id."'";
		$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

		// Delete from TABLE_PROPERTY_SELLING_POINTS_RELATIONS
		$strDelQuery = "DELETE FROM " . TABLE_PROPERTY_CONTACT_LANGUAGES . " WHERE property_id='".$property_id."'";
		$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

		// Delete from TABLE_PROPERTY_SELLING_POINTS_RELATIONS
		$strDelQuery = "DELETE FROM " . TABLE_PROPERTY_AVAILABILITY_RELATIONS . " WHERE property_id='".$property_id."'";
		$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

		// Delete from TABLE_PROPERTY_SELLING_POINTS_RELATIONS
		$strDelQuery = "DELETE FROM " . TABLE_PROPERTY_PRICE_NOTES . " WHERE property_id='".$property_id."'";
		$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

		// Delete from TABLE_PROPERTY_SELLING_POINTS_RELATIONS
		$strDelQuery = "DELETE FROM " . TABLE_PROPERTY_CHECKLIST_SETTINGS . " WHERE property_id='".$property_id."'";
		$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

		// Delete from TABLE_PROPERTY_SELLING_POINTS_RELATIONS
		$strDelQuery = "DELETE FROM " . TABLE_PROPERTY_EXTRA_LANDMARKS . " WHERE property_id='".$property_id."'";
		$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

		// Delete from TABLE_PROPERTY_SELLING_POINTS_RELATIONS
		$strDelQuery = "DELETE FROM " . TABLE_PROPERTY_LANDMARK_RELATIONS . " WHERE property_id='".$property_id."'";
		$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

		// Delete from TABLE_PROPERTY_SELLING_POINTS_RELATIONS
		$strDelQuery = "DELETE FROM " . TABLE_PROPERTY_AREA_NOTES . " WHERE property_id='".$property_id."'";
		$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

		// Delete from TABLE_PROPERTY_SELLING_POINTS_RELATIONS
		$strDelQuery = "DELETE FROM " . TABLE_PROPERTY_LOCATION_GUIDES . " WHERE property_id='".$property_id."'";
		$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

		// Delete from TABLE_PROPERTY_SELLING_POINTS_RELATIONS
		$strDelQuery = "DELETE FROM " . TABLE_PROPERTY_SELLING_POINTS_RELATIONS . " WHERE property_id='".$property_id."'";
		$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

		// Delete from TABLE_PROPERTY_SELLING_POINTS_RELATIONS
		$strDelQuery = "DELETE FROM " . TABLE_PROPERTY_BEDROOM_RELATIONS . " WHERE property_id='".$property_id."'";
		$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

		// Delete from TABLE_PROPERTY_SELLING_POINTS_RELATIONS
		$strDelQuery = "DELETE FROM " . TABLE_PROPERTY_BATHROOM_RELATIONS . " WHERE property_id='".$property_id."'";
		$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

		// Delete from TABLE_PROPERTY_SELLING_POINTS_RELATIONS
		$strDelQuery = "DELETE FROM " . TABLE_PROPERTY_FEATURES_RELATIONS . " WHERE property_id='".$property_id."'";
		$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

		// Delete from TABLE_PROPERTY_SELLING_POINTS_RELATIONS
		$strDelQuery = "DELETE FROM " . TABLE_PROPERTY_SPECIAL_REQUIREMENTS_RELATIONS . " WHERE property_id='".$property_id."'";
		$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

		// Delete from TABLE_PROPERTY_PHOTO_ALL
		$strDelPhotoQuery = "DELETE FROM " . TABLE_PROPERTY_PHOTO_ALL . " WHERE property_id='".$property_id."'";
		$this->dbObj->mySqlSafeQuery($strDelPhotoQuery); // delete previous relations

		// Delete from TABLE_PROPERTY_OWNER_RELATIONS
		$strDelQuery = "DELETE FROM " . TABLE_PROPERTY_OWNER_RELATIONS . " WHERE property_id='".$property_id."'";
		$this->dbObj->mySqlSafeQuery($strDelQuery);

		// Delete from TABLE_PROPERTY_REVIEWS_RELATIONS
		$strDelQuery = "DELETE FROM " . TABLE_PROPERTY_REVIEWS_RELATIONS . " WHERE property_id='".$property_id."'";
		$this->dbObj->mySqlSafeQuery($strDelQuery);

		// Delete from TABLE_PROPERTY_SPECIAL_DEALS_RELATIONS
		$strDelQuery = "DELETE FROM " . TABLE_PROPERTY_SPECIAL_DEALS_RELATIONS . " WHERE property_id='".$property_id."'";
		$this->dbObj->mySqlSafeQuery($strDelQuery);

		// Update photo
		foreach($item->images->image_url as $image) {
			$photo_id 	= $this->fun_addPropertyPhotos($property_id);
			$this->fun_updatePropertyPhotos($property_id, $photo_id, '', $image, $image);
		}

		// Update photo
		$keywords 		= $item->keywords;
		$price 			= $item->price;
		$price_period 	= $item->price_period;
		//$currency 		= $item->currency;
		$currency 		= $this->dbObj->getField(TABLE_CURRENCIES, "currency_code", $item->currency, "currency_id");
		$secondary_source= $item->secondary_source;

		// Update Attribute
		$this->dbObj->insertOrUpdateFields(TABLE_PROPERTY_BATHROOM_RELATIONS, "property_id", $property_id, array("property_id", "total_bathrooms", "ensuite_baths", "shower_baths", "baths", "toilets", "notes", "created_on", "created_by", "updated_on", "updated_by"), array($property_id, $item->attribute->bathrooms, "", "", "", "", $item->attribute->condition, $cur_unixtime, $cur_user_id, $cur_unixtime, $cur_user_id));
		$this->dbObj->insertOrUpdateFields(TABLE_PROPERTY_BEDROOM_RELATIONS, "property_id", $property_id, array("property_id", "total_beds", "ensuite_beds", "scomfort_beds", "double_beds", "single_beds", "notes", "created_on", "created_by", "updated_on", "updated_by"), array($property_id, $item->attribute->bedrooms, "", $item->attribute->sleeps, "", "", $item->attribute->disclaimer, $cur_unixtime, $cur_user_id, $cur_unixtime, $cur_user_id));

		// Update Not Available Dates
		if($item->not_available_dates->not_available_date != "") {
			$field_names 	= array("property_id", "startdate", "enddate", "created_on", "created_by", "updated_on", "updated_by", "status");
			$field_values 	= array($property_id, $item->not_available_dates->not_available_date, $item->not_available_dates->not_available_date, $cur_unixtime, $cur_user_id, $cur_unixtime, $cur_user_id, '3');
			$this->dbObj->insertFields(TABLE_PROPERTY_AVAILABILITY_RELATIONS, $field_names, $field_values);
			$id 			= $this->dbObj->getIdentity();
			foreach($item->not_available_dates->not_available_date as $unavailable_date) {
				$enddate = $this->dbObj->getField(TABLE_PROPERTY_AVAILABILITY_RELATIONS, "id", $id, "enddate");
				if(strtotime($unavailable_date) == strtotime('+1 day', strtotime($enddate))) {
					$this->dbObj->updateField(TABLE_PROPERTY_AVAILABILITY_RELATIONS, "id", $id, "enddate", $unavailable_date);
				} else {
					$field_names 	= array("property_id", "startdate", "enddate", "created_on", "created_by", "updated_on", "updated_by", "status");
					$field_values 	= array($property_id, $unavailable_date, $unavailable_date, $cur_unixtime, $cur_user_id, $cur_unixtime, $cur_user_id, '3');
					$this->dbObj->insertFields(TABLE_PROPERTY_AVAILABILITY_RELATIONS, $field_names, $field_values);
					$id 			= $this->dbObj->getIdentity();
				}
			}
		}
		foreach($item->pricing->price_range as $price) {
			$field_names 	= array("property_id", "price_name", "date_from", "date_to", "min_stay", "min_stay_type", "per_month_price", "per_week_price", "per_night_midweek_price", "per_night_weekend_price", "currency_code", "special_offer", "price_type", "created_on", "created_by", "updated_on", "updated_by");
			$field_values 	= array($property_id, $price->name, strtotime($price->from_date), strtotime($price->to_date), $price->min_stay, "n", $price->per_month, $price->per_week, $price->per_night, $price->per_night_weekend, $currency, "0", "2", $cur_unixtime, $cur_user_id, $cur_unixtime, $cur_user_id);
			$this->dbObj->insertFields(TABLE_PROPERTY_PRICES, $field_names, $field_values);
			//$id 			= $this->dbObj->getIdentity();
		}
		$this->dbObj->insertOrUpdateFields(TABLE_PROPERTY_OWNER_RELATIONS, "property_id", $property_id, array("property_id", "owner_id"), array($property_id, $cur_user_id));
		//sleep(5);//seconds to wait..
	}

	function fun_generateFriendlyLink($property_id, $friendly_link){
		$friendly_link = replace_NonAlphaNumChars($friendly_link, TABLE_PROPERTY, "property_id", $property_id, "friendly_link");
		$this->dbObj->updateField(TABLE_PROPERTY, "property_id", $property_id, "friendly_link", $friendly_link.".html");
	}

	//Edit existing property information in database
	function fun_editProperty($property_id){
		$cur_unixtime 	= time ();
		if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !=""){
			$cur_user_id 	= $_SESSION['ses_admin_id'];
		} else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !="") {
			$cur_user_id 	= $_SESSION['ses_modarator_id'];
		} else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !="") {
			$cur_user_id 	= $_SESSION['ses_user_id'];
		} else {
			$cur_user_id 	= "";
		}

		if($property_id =="" || $cur_user_id =="") {
			return false;
		} else {
			//Upadate updated by, updated on
			$sqlUpdate = "UPDATE " . TABLE_PROPERTY . " SET updated_on='" . $cur_unixtime . "', updated_by='" . $cur_user_id . "' WHERE property_id='".(int)$property_id."'";
			$this->dbObj->mySqlSafeQuery($sqlUpdate);
			// Updates from details page
			if($_POST['securityKey']==md5(OWNERPROPERTYDETAILS)){		
				// Step I : if general details available update it
				$property_type			= $_POST['txtPropertyType'];
				$catering_type 			= $_POST['txtCateringType'];
				$property_name 			= $_POST['txtPropertyName'];
				$property_title 		= $_POST['txtPropertyTitle'];
				$property_summary		= $_POST['txtPropertySummary'];
				$description 			= $_POST['txtPropertyDescription'];

				if(isset($_POST['txtFriendlyLink']) && ($_POST['txtFriendlyLink'] != "")) {
					$friendly_link 		= $_POST['txtFriendlyLink'];
				} else {
					$friendly_link 		= "";
				}

				$propertyArray = array(							
					"property_type" 	=> $property_type,
					"catering_type" 	=> $catering_type,
					"property_name" 	=> $property_name,
					"property_title" 	=> $property_title,

					"property_summary" 	=> $property_summary,
					"description" 		=> $description,
					"friendly_link" 	=> $friendly_link,
					"updated_on" 		=> $cur_unixtime,
					"updated_by" 		=> $cur_user_id
				);
		
				$fields = "";
				foreach($propertyArray as $keys => $vals){
					$fields .= $keys . "='" . fun_db_input($vals). "', ";
				}
				if($fields!=""){
					$fields = substr($fields,0,strlen($fields)-2);
					$sqlUpdate = "UPDATE " . TABLE_PROPERTY . " SET " . $fields . " WHERE property_id='".(int)$property_id."'";
					$this->dbObj->mySqlSafeQuery($sqlUpdate);
					// property owner id
					$owner_id 	= $this->dbObj->getField(TABLE_PROPERTY_OWNER_RELATIONS, "property_id", $property_id, "owner_id");
					// if friendly_link will not be null
					if($friendly_link != "") {
						// find wether it is present in user basket or not
						/*
						if($this->fun_checkPropertyProductPayments("5", $property_id) == false) {
							if($this->fun_checkPropertyUserBasket($owner_id, "5", $property_id) == false) {
								$products_id 	= 5;
								$products_price = $this->dbObj->getField(TABLE_PRODUCTS, "products_id", $products_id, "products_price");
								$this->fun_addPropertyUserBasket($owner_id, "5", $property_id, "1", $products_price);
							}
						}
						*/
					} else {
						// delete such items from cart
						if($this->fun_checkPropertyUserBasket($owner_id, "5", $property_id) == true) {
							$this->fun_deletePropertyUserBasket($owner_id, "5", $property_id);
						}
					}
				}
				// Step II : if bed details available update it
				if(isset($_POST['txtTotalBeds'])){
					$total_beds 	= $_POST['txtTotalBeds'];
					$ensuite_beds 	= $_POST['txtEnsuiteBeds'];
					$scomfort_beds 	= $_POST['txtcomfortBeds'];
					$double_beds 	= $_POST['txtdoubleBeds'];
					$single_beds 	= $_POST['txtsingleBeds'];
					$sofa_beds 		= $_POST['txtsofaBeds'];
					$cots 			= $_POST['txtcotsBeds'];
					$bdrapts1 		= $_POST['txt1BdrApts'];
					$bdrapts2 		= $_POST['txt2BdrApts'];
					$bdrapts3 		= $_POST['txt3BdrApts'];
					$bdrapts4 		= $_POST['txt4BdrApts'];
					$bdrapts5 		= $_POST['txt5BdrApts'];
					$complex_unit_type 	= $_POST['txtUnitType'];
					$bed_notes 		= $_POST['txtBedroomsNote'];
	
					if(($bed_relation_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_BEDROOM_RELATIONS , " WHERE property_id='".$property_id."'")) && (is_array($bed_relation_array))){
						$bed_created_on		= $bed_relation_array[0]['created_on'];
						$bed_created_by		= $bed_relation_array[0]['created_by'];

						$strDelBedQuery = "DELETE FROM " . TABLE_PROPERTY_BEDROOM_RELATIONS . " WHERE property_id='".$property_id."'";
						$this->dbObj->mySqlSafeQuery($strDelBedQuery); // delete previous relations
					} else {
						$bed_created_on		= $cur_unixtime;
						$bed_created_by		= $cur_user_id;
					}

					$propertyBedArray = array(							
						"total_beds" 	=> $total_beds,
						"ensuite_beds" 	=> $ensuite_beds,
						"scomfort_beds" => $scomfort_beds,
						"double_beds" 	=> $double_beds,
						"single_beds" 	=> $single_beds,
						"sofa_beds" 	=> $sofa_beds,
						"cots" 			=> $cots,
						"bdrapts1" 		=> $bdrapts1,
						"bdrapts2" 		=> $bdrapts2,
						"bdrapts3" 		=> $bdrapts3,
						"bdrapts4" 		=> $bdrapts4,
						"bdrapts5" 		=> $bdrapts5,
						"complex_unit_type" => $complex_unit_type,
						"notes" 		=> $bed_notes,
						"created_on" 	=> $bed_created_on,
						"created_by"	=> $bed_created_by,
						"updated_on"	=> $cur_unixtime,
						"updated_by"	=> $cur_user_id
					);
	
					$bedfields = "";
					$bedfieldsVals = "";
					$bedcnt = 0;
					foreach($propertyBedArray as $keys => $values){
						$bedfields .= $keys;
						$bedfieldsVals .= "'" . fun_db_input($values) . "'";
						if($bedcnt < sizeof($propertyBedArray)-1){
							$bedfields .= ", ";
							$bedfieldsVals .= ", ";
						}
						$bedcnt++;
					}
					$strInsBedQuery = "INSERT INTO " . TABLE_PROPERTY_BEDROOM_RELATIONS . "(id, property_id, ".$bedfields.") ";
					$strInsBedQuery .= "VALUES(null, '".$property_id."', ".$bedfieldsVals.")";
					$this->dbObj->mySqlSafeQuery($strInsBedQuery);
				}
				// Step III : if bath details available update it
				if(isset($_POST['txtTotalBaths'])){
					$total_bathrooms 	= $_POST['txtTotalBaths'];
					$ensuite_baths 		= $_POST['txtEnsuiteBaths'];
					$shower_baths 		= $_POST['txtShowerBaths'];
					$baths 				= $_POST['txtBaths'];
					$toilets 			= $_POST['txtToilets'];
					$bath_notes 		= $_POST['txtBathroomsNotes'];
	
					if(($bath_relation_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_BATHROOM_RELATIONS , " WHERE property_id='".$property_id."'")) && (is_array($bath_relation_array))){
						$bath_created_on		= $bath_relation_array[0]['created_on'];
						$bath_created_by		= $bath_relation_array[0]['created_by'];

						$strDelBathQuery = "DELETE FROM " . TABLE_PROPERTY_BATHROOM_RELATIONS . " WHERE property_id='".$property_id."'";
						$this->dbObj->mySqlSafeQuery($strDelBathQuery); // delete previous relations
					} else {
						$bath_created_on		= $cur_unixtime;
						$bath_created_by		= $cur_user_id;
					}
					
					$propertyBathArray = array(							
						"total_bathrooms" 	=> $total_bathrooms,
						"ensuite_baths" 	=> $ensuite_baths,
						"shower_baths" 		=> $shower_baths,
						"baths" 			=> $baths,
						"toilets" 			=> $toilets,
						"notes" 			=> $bath_notes,
						"created_on" 		=> $bath_created_on,
						"created_by"		=> $bath_created_by,
						"updated_on"		=> $cur_unixtime,
						"updated_by"		=> $cur_user_id
					);

					$bathfields = "";
					$bathfieldsVals = "";
					$bathcnt = 0;
					foreach($propertyBathArray as $keys => $values){
						$bathfields .= $keys;
						$bathfieldsVals .= "'" . fun_db_input($values) . "'";
						if($bathcnt < sizeof($propertyBathArray)-1){
							$bathfields .= ", ";
							$bathfieldsVals .= ", ";
						}
						$bathcnt++;
					}
					$strInsBathQuery = "INSERT INTO " . TABLE_PROPERTY_BATHROOM_RELATIONS . "(id, property_id, ".$bathfields.") ";
					$strInsBathQuery .= "VALUES(null, '".$property_id."', ".$bathfieldsVals.")";
					$this->dbObj->mySqlSafeQuery($strInsBathQuery);
				}
				// Step IV : if features details available update it
				if(isset($_POST['txtFeatures'])){
					$txtFeatures	 	= $_POST['txtFeatures']; // array
					if(is_array($txtFeatures)){
						$feature_ids = implode(",", $txtFeatures);
					} else {
						$feature_ids = "";
					}

					if(isset($_POST['txtLinenProvided']) && $_POST['txtLinenProvided'] == "1"){
						if($feature_ids == ""){
							$feature_ids = "25";
						} else {
							$feature_ids = $feature_ids.",25";
						}
					}
	
					if(isset($_POST['txtTowelProvided']) && $_POST['txtTowelProvided'] == "1"){
						if($feature_ids == ""){
							$feature_ids = "26";
						} else {
							$feature_ids = $feature_ids.",26";
						}
					}
	
					if(isset($_POST['txtBeachTowelProvided']) && $_POST['txtBeachTowelProvided'] == "1"){
						if($feature_ids == ""){
							$feature_ids = "27";
						} else {
							$feature_ids = $feature_ids.",27";
						}
					}
					$feature_note 			= fun_db_input($_POST['txtFeatureNotes']);
					$holiday_type_note 		= fun_db_input($_POST['txtHolidayTypeNote']);
					$kitchen_note 			= fun_db_input($_POST['txtKitchenNote']);
					$entertainment_note 	= fun_db_input($_POST['txtEntertainmentNote']);
					$outside_note 			= fun_db_input($_POST['txtOutsideNote']);
					$general_note 			= fun_db_input($_POST['txtGeneralNote']);
					$activities_note 		= fun_db_input($_POST['txtActivitiesNote']);
					$heating_cooling_note 	= fun_db_input($_POST['txtHeatingCoolingNote']);
					$services_note 			= fun_db_input($_POST['txtServicesNote']);
					$location_note 			= fun_db_input($_POST['txtLocationNote']);





					if(($feature_relation_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_FEATURES_RELATIONS , " WHERE property_id='".$property_id."'")) && (is_array($feature_relation_array))){
						$feature_relation_id	= $feature_relation_array[0]['id'];
						$sqlUpdate = "UPDATE " . TABLE_PROPERTY_FEATURES_RELATIONS . " SET feature_ids='" . $feature_ids . "', feature_notes='" . $feature_note . "', holiday_type_note='" . $holiday_type_note . "', kitchen_note='" . $kitchen_note . "', entertainment_note='" . $entertainment_note . "', outside_note='" . $outside_note . "', general_note='" . $general_note . "', activities_note='" . $activities_note . "', heating_cooling_note='" . $heating_cooling_note . "', services_note='" . $services_note . "', location_note='" . $location_note . "', updated_on='" . $cur_unixtime . "', updated_by='" . $cur_user_id . "'  WHERE id='".(int)$feature_relation_id."'";
						$rdoUpdate = $this->dbObj->mySqlSafeQuery($sqlUpdate);
					} else {
						$strInsFeaturesQuery = "INSERT INTO " . TABLE_PROPERTY_FEATURES_RELATIONS . "(id, property_id, feature_ids, feature_notes, holiday_type_note, kitchen_note, entertainment_note, outside_note, general_note, activities_note, heating_cooling_note, services_note, location_note, created_on, created_by, updated_on, updated_by) ";
						$strInsFeaturesQuery .= "VALUES(null, '".$property_id."', '".$feature_ids."', '".$feature_note."', '".$holiday_type_note."', '".$kitchen_note."', '".$entertainment_note."', '".$outside_note."', '".$general_note."', '".$activities_note."', '".$heating_cooling_note."', '".$services_note."', '".$location_note."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."')";
						$this->dbObj->mySqlSafeQuery($strInsFeaturesQuery);
					}
				}


				/*
				// Step V : if special requirements details available update it
				if(isset($_POST['txtSRequirements'])){
					$txtSRequirements	 	= $_POST['txtSRequirements']; // array
					if(is_array($txtFeatures)){
						$srequirement_ids = implode(",", $txtSRequirements);
					} else {
						$srequirement_ids = "";
					}
					$srequirement_note = fun_db_input($_POST['txtSRequirementNotes']);
					if(($srequirement_relation_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_SPECIAL_REQUIREMENTS_RELATIONS , " WHERE property_id='".$property_id."'")) && (is_array($srequirement_relation_array))){
						$srequirement_relation_id		= $srequirement_relation_array[0]['id'];
						$sqlUpdate = "UPDATE " . TABLE_PROPERTY_SPECIAL_REQUIREMENTS_RELATIONS . " SET srequirement_ids='" . $srequirement_ids . "', srequirement_notes='" . $srequirement_note . "', updated_on='" . $cur_unixtime . "', updated_by='" . $cur_user_id . "'  WHERE id='".(int)$srequirement_relation_id."'";
						$rdoUpdate = $this->dbObj->mySqlSafeQuery($sqlUpdate);
					} else {
						$strInsSrequirementQuery = "INSERT INTO " . TABLE_PROPERTY_SPECIAL_REQUIREMENTS_RELATIONS . "(id, property_id, srequirement_ids, srequirement_notes, created_on, created_by, updated_on, updated_by) ";
						$strInsSrequirementQuery .= "VALUES(null, '".$property_id."', '".$srequirement_ids."', '".$srequirement_note."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."')";
						$this->dbObj->mySqlSafeQuery($strInsSrequirementQuery);
					}
				}
				*/

				// Step VI : if selling points details available update it
				if(isset($_POST['txtSellingPoint1']) || isset($_POST['txtSellingPoint2']) || isset($_POST['txtSellingPoint3']) || isset($_POST['txtSellingPoint4']) || isset($_POST['txtSellingPoint5'])){
					//delete all previous relation
					$strDelSellingPointsQuery = "DELETE FROM " . TABLE_PROPERTY_SELLING_POINTS_RELATIONS . " WHERE property_id='".$property_id."'";
					$this->dbObj->mySqlSafeQuery($strDelSellingPointsQuery); // delete previous relations
	
					if(isset($_POST['txtSellingPoint1']) && $_POST['txtSellingPoint1'] != ""){
						$selling_point = fun_db_input($_POST['txtSellingPoint1']);
						$strInsSellingPointsQuery = "INSERT INTO " . TABLE_PROPERTY_SELLING_POINTS_RELATIONS . "(id, property_id, selling_point, created_on, created_by, updated_on, updated_by) ";
						$strInsSellingPointsQuery .= "VALUES(null, '".$property_id."', '".$selling_point."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."')";
						$this->dbObj->mySqlSafeQuery($strInsSellingPointsQuery);
					}
					if(isset($_POST['txtSellingPoint2']) && $_POST['txtSellingPoint2'] != ""){
						$selling_point = $_POST['txtSellingPoint2'];
						$strInsSellingPointsQuery = "INSERT INTO " . TABLE_PROPERTY_SELLING_POINTS_RELATIONS . "(id, property_id, selling_point, created_on, created_by, updated_on, updated_by) ";
						$strInsSellingPointsQuery .= "VALUES(null, '".$property_id."', '".$selling_point."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."')";
						$this->dbObj->mySqlSafeQuery($strInsSellingPointsQuery);
					}
					if(isset($_POST['txtSellingPoint3']) && $_POST['txtSellingPoint3'] != ""){
						$selling_point = fun_db_input($_POST['txtSellingPoint3']);
						$strInsSellingPointsQuery = "INSERT INTO " . TABLE_PROPERTY_SELLING_POINTS_RELATIONS . "(id, property_id, selling_point, created_on, created_by, updated_on, updated_by) ";
						$strInsSellingPointsQuery .= "VALUES(null, '".$property_id."', '".$selling_point."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."')";
						$this->dbObj->mySqlSafeQuery($strInsSellingPointsQuery);
					}
					if(isset($_POST['txtSellingPoint4']) && $_POST['txtSellingPoint4'] != ""){
						$selling_point = fun_db_input($_POST['txtSellingPoint4']);
						$strInsSellingPointsQuery = "INSERT INTO " . TABLE_PROPERTY_SELLING_POINTS_RELATIONS . "(id, property_id, selling_point, created_on, created_by, updated_on, updated_by) ";
						$strInsSellingPointsQuery .= "VALUES(null, '".$property_id."', '".$selling_point."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."')";
						$this->dbObj->mySqlSafeQuery($strInsSellingPointsQuery);
					}
					if(isset($_POST['txtSellingPoint5']) && $_POST['txtSellingPoint5'] != ""){
						$selling_point = fun_db_input($_POST['txtSellingPoint5']);
						$strInsSellingPointsQuery = "INSERT INTO " . TABLE_PROPERTY_SELLING_POINTS_RELATIONS . "(id, property_id, selling_point, created_on, created_by, updated_on, updated_by) ";
						$strInsSellingPointsQuery .= "VALUES(null, '".$property_id."', '".$selling_point."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."')";
						$this->dbObj->mySqlSafeQuery($strInsSellingPointsQuery);
					}
					if(isset($_POST['txtSellingPoint6']) && $_POST['txtSellingPoint6'] != ""){
						$selling_point = fun_db_input($_POST['txtSellingPoint6']);
						$strInsSellingPointsQuery = "INSERT INTO " . TABLE_PROPERTY_SELLING_POINTS_RELATIONS . "(id, property_id, selling_point, created_on, created_by, updated_on, updated_by) ";
						$strInsSellingPointsQuery .= "VALUES(null, '".$property_id."', '".$selling_point."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."')";
						$this->dbObj->mySqlSafeQuery($strInsSellingPointsQuery);
					}
					if(isset($_POST['txtSellingPoint7']) && $_POST['txtSellingPoint7'] != ""){
						$selling_point = fun_db_input($_POST['txtSellingPoint7']);
						$strInsSellingPointsQuery = "INSERT INTO " . TABLE_PROPERTY_SELLING_POINTS_RELATIONS . "(id, property_id, selling_point, created_on, created_by, updated_on, updated_by) ";
						$strInsSellingPointsQuery .= "VALUES(null, '".$property_id."', '".$selling_point."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."')";
						$this->dbObj->mySqlSafeQuery($strInsSellingPointsQuery);
					}
					if(isset($_POST['txtSellingPoint8']) && $_POST['txtSellingPoint8'] != ""){
						$selling_point = fun_db_input($_POST['txtSellingPoint8']);
						$strInsSellingPointsQuery = "INSERT INTO " . TABLE_PROPERTY_SELLING_POINTS_RELATIONS . "(id, property_id, selling_point, created_on, created_by, updated_on, updated_by) ";
						$strInsSellingPointsQuery .= "VALUES(null, '".$property_id."', '".$selling_point."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."')";
						$this->dbObj->mySqlSafeQuery($strInsSellingPointsQuery);
					}
					if(isset($_POST['txtSellingPoint9']) && $_POST['txtSellingPoint9'] != ""){
						$selling_point = fun_db_input($_POST['txtSellingPoint9']);
						$strInsSellingPointsQuery = "INSERT INTO " . TABLE_PROPERTY_SELLING_POINTS_RELATIONS . "(id, property_id, selling_point, created_on, created_by, updated_on, updated_by) ";
						$strInsSellingPointsQuery .= "VALUES(null, '".$property_id."', '".$selling_point."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."')";
						$this->dbObj->mySqlSafeQuery($strInsSellingPointsQuery);
					}
					if(isset($_POST['txtSellingPoint10']) && $_POST['txtSellingPoint10'] != ""){
						$selling_point = fun_db_input($_POST['txtSellingPoint10']);
						$strInsSellingPointsQuery = "INSERT INTO " . TABLE_PROPERTY_SELLING_POINTS_RELATIONS . "(id, property_id, selling_point, created_on, created_by, updated_on, updated_by) ";
						$strInsSellingPointsQuery .= "VALUES(null, '".$property_id."', '".$selling_point."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."')";
						$this->dbObj->mySqlSafeQuery($strInsSellingPointsQuery);
					}
				}
				// Step VII : if property tags available update it
				if(isset($_POST['txtTag1']) || isset($_POST['txtTag2']) || isset($_POST['txtTag3']) || isset($_POST['txtTag4']) || isset($_POST['txtTag5'])){
/*
					//delete all previous relation
					$strDelTagQuery = "DELETE FROM " . TABLE_PROPERTY_TAGS . " WHERE property_id='".$property_id."'";
					$this->dbObj->mySqlSafeQuery($strDelTagQuery); // delete previous relations
*/	
					if(isset($_POST['txtTag1']) && ($_POST['txtTag1'] != "") && isset($_POST['txtTagsid1']) && ($_POST['txtTagsid1'] != "")){
						$tag_id 	= fun_db_input($_POST['txtTagsid1']);
						$tag_name 	= fun_db_input($_POST['txtTag1']);
						$tag_code 	= $this->fun_getPropertyTagCodeByName($tag_name);
						$sqlUpdateQuery = "UPDATE " . TABLE_PROPERTY_TAGS . " SET tag_name = '".$tag_code."', updated_on = '".$cur_unixtime."', updated_by = '".$cur_user_id."' WHERE id='".$tag_id."'";
						$this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
					} else if(isset($_POST['txtTag1']) && ($_POST['txtTag1'] != "") && (!isset($_POST['txtTagsid1']) || ($_POST['txtTagsid1'] == ""))) {
						$tag_name = fun_db_input($_POST['txtTag1']);
						$tag_code 	= $this->fun_getPropertyTagCodeByName($tag_name);
						$strInsTagQuery = "INSERT INTO " . TABLE_PROPERTY_TAGS . "(id, property_id, tag_name, tag_counter, created_on, created_by, updated_on, updated_by) ";
						$strInsTagQuery .= "VALUES(null, '".$property_id."', '".$tag_code."', '0', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."')";
						$this->dbObj->mySqlSafeQuery($strInsTagQuery);
					}

					if(isset($_POST['txtTag2']) && ($_POST['txtTag2'] != "") && isset($_POST['txtTagsid2']) && ($_POST['txtTagsid2'] != "")){
						$tag_id 	= fun_db_input($_POST['txtTagsid2']);
						$tag_name 	= fun_db_input($_POST['txtTag2']);
						$tag_code 	= $this->fun_getPropertyTagCodeByName($tag_name);
						$sqlUpdateQuery = "UPDATE " . TABLE_PROPERTY_TAGS . " SET tag_name = '".$tag_code."', updated_on = '".$cur_unixtime."', updated_by = '".$cur_user_id."' WHERE id='".$tag_id."'";
						$this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
					} else if(isset($_POST['txtTag2']) && ($_POST['txtTag2'] != "") && (!isset($_POST['txtTagsid2']) || ($_POST['txtTagsid2'] == ""))) {
						$tag_name = fun_db_input($_POST['txtTag2']);
						$tag_code 	= $this->fun_getPropertyTagCodeByName($tag_name);
						$strInsTagQuery = "INSERT INTO " . TABLE_PROPERTY_TAGS . "(id, property_id, tag_name, tag_counter, created_on, created_by, updated_on, updated_by) ";
						$strInsTagQuery .= "VALUES(null, '".$property_id."', '".$tag_code."', '0', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."')";
						$this->dbObj->mySqlSafeQuery($strInsTagQuery);
					}

					if(isset($_POST['txtTag3']) && ($_POST['txtTag3'] != "") && isset($_POST['txtTagsid3']) && ($_POST['txtTagsid3'] != "")){
						$tag_id 	= fun_db_input($_POST['txtTagsid3']);
						$tag_name 	= fun_db_input($_POST['txtTag3']);
						$tag_code 	= $this->fun_getPropertyTagCodeByName($tag_name);
						$sqlUpdateQuery = "UPDATE " . TABLE_PROPERTY_TAGS . " SET tag_name = '".$tag_code."', updated_on = '".$cur_unixtime."', updated_by = '".$cur_user_id."' WHERE id='".$tag_id."'";
						$this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
					} else if(isset($_POST['txtTag3']) && ($_POST['txtTag3'] != "") && (!isset($_POST['txtTagsid3']) || ($_POST['txtTagsid3'] == ""))) {
						$tag_name = fun_db_input($_POST['txtTag3']);
						$tag_code 	= $this->fun_getPropertyTagCodeByName($tag_name);
						$strInsTagQuery = "INSERT INTO " . TABLE_PROPERTY_TAGS . "(id, property_id, tag_name, tag_counter, created_on, created_by, updated_on, updated_by) ";
						$strInsTagQuery .= "VALUES(null, '".$property_id."', '".$tag_code."', '0', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."')";
						$this->dbObj->mySqlSafeQuery($strInsTagQuery);
					}
					
					if(isset($_POST['txtTag4']) && ($_POST['txtTag4'] != "") && isset($_POST['txtTagsid4']) && ($_POST['txtTagsid4'] != "")){
						$tag_id 	= fun_db_input($_POST['txtTagsid4']);
						$tag_name 	= fun_db_input($_POST['txtTag4']);
						$tag_code 	= $this->fun_getPropertyTagCodeByName($tag_name);
						$sqlUpdateQuery = "UPDATE " . TABLE_PROPERTY_TAGS . " SET tag_name = '".$tag_code."', updated_on = '".$cur_unixtime."', updated_by = '".$cur_user_id."' WHERE id='".$tag_id."'";
						$this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
					} else if(isset($_POST['txtTag4']) && ($_POST['txtTag4'] != "") && (!isset($_POST['txtTagsid4']) || ($_POST['txtTagsid4'] == ""))) {
						$tag_name = fun_db_input($_POST['txtTag4']);
						$tag_code 	= $this->fun_getPropertyTagCodeByName($tag_name);
						$strInsTagQuery = "INSERT INTO " . TABLE_PROPERTY_TAGS . "(id, property_id, tag_name, tag_counter, created_on, created_by, updated_on, updated_by) ";
						$strInsTagQuery .= "VALUES(null, '".$property_id."', '".$tag_code."', '0', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."')";
						$this->dbObj->mySqlSafeQuery($strInsTagQuery);
					}
					
					if(isset($_POST['txtTag5']) && ($_POST['txtTag5'] != "") && isset($_POST['txtTagsid5']) && ($_POST['txtTagsid5'] != "")){
						$tag_id 	= fun_db_input($_POST['txtTagsid5']);
						$tag_name 	= fun_db_input($_POST['txtTag5']);
						$tag_code 	= $this->fun_getPropertyTagCodeByName($tag_name);
						$sqlUpdateQuery = "UPDATE " . TABLE_PROPERTY_TAGS . " SET tag_name = '".$tag_code."', updated_on = '".$cur_unixtime."', updated_by = '".$cur_user_id."' WHERE id='".$tag_id."'";
						$this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
					} else if(isset($_POST['txtTag5']) && ($_POST['txtTag5'] != "") && (!isset($_POST['txtTagsid5']) || ($_POST['txtTagsid5'] == ""))) {
						$tag_name = fun_db_input($_POST['txtTag5']);
						$tag_code 	= $this->fun_getPropertyTagCodeByName($tag_name);
						$strInsTagQuery = "INSERT INTO " . TABLE_PROPERTY_TAGS . "(id, property_id, tag_name, tag_counter, created_on, created_by, updated_on, updated_by) ";
						$strInsTagQuery .= "VALUES(null, '".$property_id."', '".$tag_code."', '0', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."')";
						$this->dbObj->mySqlSafeQuery($strInsTagQuery);
					}
				}
			}
			// End of details page updates
	
			// start of location page updates
			if($_POST['securityKey']==md5(LOCATIONFORM)){		
				// Step I : if p_map_latitude and p_map_longitude details available update it
				if(isset($_POST['p_map_latitude']) && isset($_POST['p_map_longitude'])){
					$latitude 		= $_POST['p_map_latitude'];
					$longitude 		= $_POST['p_map_longitude'];
					$map_zoom_level	= $_POST['p_map_zoom'];
					$country_id		= $_POST['txtPropertyCountry'];
					$area_id 		= $_POST['txtPropertyArea'];
					$subregion_id 	= $_POST['txtPropertySubRegion'];
					$zip 			= trim($_POST['txtPropertyPostcode']);

					// region - location machenism
					if(isset($_POST['txtPropertyRegionId']) && $_POST['txtPropertyRegionId'] > 0) {
						$region_id 		= $_POST['txtPropertyRegionId'];
					} else {
						$region_id 		= $this->fun_getRegionId($area_id, trim($_POST['txtPropertyRegion']));
					}
					
					if(trim($_POST['txtPropertyLocation']) != "") {
						$location_id 	= $this->fun_getLocationId($region_id, trim($_POST['txtPropertyLocation']), $zip);
					}

					$propertyLocationArray = array(							
						"latitude" 			=> $latitude,
						"longitude" 		=> $longitude,
						"map_zoom_level" 	=> $map_zoom_level,
						"country_id" 		=> $country_id,
						"area_id" 			=> $area_id,
						"region_id" 		=> $region_id,
						"subregion_id" 		=> $subregion_id,
						"location_id" 		=> $location_id,
						"zip" 				=> $zip
					);

					$fields = "";
					foreach($propertyLocationArray as $keys => $vals){
						$fields .= $keys . "='" . fun_db_input($vals). "', ";
					}
					if($fields!=""){
						$fields = substr($fields,0,strlen($fields)-2);
						$sqlUpdateLocation = "UPDATE " . TABLE_PROPERTY . " SET " . $fields . " WHERE property_id='".(int)$property_id."'";
						$this->dbObj->mySqlSafeQuery($sqlUpdateLocation);
					}
					if(isset($_POST['textPropertyLocationGuideNote']) && $_POST['textPropertyLocationGuideNote'] != ""){
						/*
						$strDelLocationGuidesQuery = "DELETE FROM " . TABLE_PROPERTY_LOCATION_GUIDES . " WHERE property_id='".$property_id."'";
						$this->dbObj->mySqlSafeQuery($strDelLocationGuidesQuery); // delete previous relations
	
						$location_guide = fun_db_input($_POST['textPropertyLocationGuideNote']);
						$strInsLocationGuidesQuery = "INSERT INTO " . TABLE_PROPERTY_LOCATION_GUIDES . "(id, property_id, location_guide, created_on, created_by, updated_on, updated_by) ";
						$strInsLocationGuidesQuery .= "VALUES(null, '".$property_id."', '".$location_guide."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."')";
						$this->dbObj->mySqlSafeQuery($strInsLocationGuidesQuery);
						*/

						$this->dbObj->insertOrUpdateFields(TABLE_PROPERTY_LOCATION_GUIDES, "property_id", $property_id, array("property_id", "location_guide", "created_on", "created_by", "updated_on", "updated_by"),  array($property_id, $_POST['textPropertyLocationGuideNote'], $cur_unixtime, $cur_user_id, $cur_unixtime, $cur_user_id));
					}
					if(isset($_POST['textPropertyAreaNote']) && $_POST['textPropertyAreaNote'] != ""){
						/*
						//delete all previous relation
						$strDelAreaNotesQuery = "DELETE FROM " . TABLE_PROPERTY_AREA_NOTES . " WHERE property_id='".$property_id."'";
						$this->dbObj->mySqlSafeQuery($strDelAreaNotesQuery); // delete previous relations
		
						$area_notes = fun_db_input($_POST['textPropertyAreaNote']);
						$strInsAreaNotesQuery = "INSERT INTO " . TABLE_PROPERTY_AREA_NOTES . "(id, property_id, area_notes, created_on, created_by, updated_on, updated_by) ";
						$strInsAreaNotesQuery .= "VALUES(null, '".$property_id."', '".$area_notes."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."')";
						$this->dbObj->mySqlSafeQuery($strInsAreaNotesQuery);
						*/

						$this->dbObj->insertOrUpdateFields(TABLE_PROPERTY_AREA_NOTES, "property_id", $property_id, array("property_id", "area_notes", "created_on", "created_by", "updated_on", "updated_by"),  array($property_id, $_POST['textPropertyAreaNote'], $cur_unixtime, $cur_user_id, $cur_unixtime, $cur_user_id));
					}
				}
	
				// Step II : if Land Marks details available update it
				if(isset($_POST['txtLandmarkDistance']) && $_POST['txtLandmarkDistance'] != ""){
					$txtDistanceType 		= $_POST['txtDistanceType'];
					$txtLandmarkDistance 	= $_POST['txtLandmarkDistance'];
					$txtLandmarkId 			= $_POST['txtLandmarkId'];
					for ($i = 0; $i < count($txtLandmarkDistance); $i++) {
						$distance 		= $txtLandmarkDistance[$i];
						$landmark_id 	= $txtLandmarkId[$i];
						// Step 1: Find the landmark relation array
						if(($landmark_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_LANDMARK_RELATIONS , " WHERE property_id='".$property_id."' AND landmark_id='".$landmark_id."'")) && (is_array($landmark_array))){
							$id = $landmark_array[0]['id'];
							if (count($landmark_array) > 1) {
								for ($j = 1; $j < count($landmark_array); $j++) {
									$delid = $landmark_array[$j]['id'];
									$strDelLandMarkRelationQuery = "DELETE FROM " . TABLE_PROPERTY_LANDMARK_RELATIONS . " WHERE id='".$delid."'";
									$this->dbObj->mySqlSafeQuery($strDelLandMarkRelationQuery); // delete previous relations
								}
							}
					
							$sqlUpdateLandMarkRelation = "UPDATE " . TABLE_PROPERTY_LANDMARK_RELATIONS . " SET distance='" . $distance . "', distance_type='" .$txtDistanceType. "', updated_on='" .$cur_unixtime. "', updated_by='" .$cur_user_id. "' WHERE id='".(int)$id."'";
							$this->dbObj->mySqlSafeQuery($sqlUpdateLandMarkRelation);
						} else { // insert new data
							$strInsLandMarkRelationQuery = "INSERT INTO " . TABLE_PROPERTY_LANDMARK_RELATIONS . "(id, property_id, landmark_id, distance, distance_type, created_on, created_by, updated_on, updated_by) ";
							$strInsLandMarkRelationQuery .= "VALUES(null, '".$property_id."', '".$landmark_id."', '".$distance."', '".$txtDistanceType."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."')";
							$this->dbObj->mySqlSafeQuery($strInsLandMarkRelationQuery);
						}
					}

				}

				// Step III : if Extra Land Marks details available update it
				if(isset($_POST['txtExtraLandmarks']) && $_POST['txtExtraLandmarks'] != ""){
					$txtDistanceType 		= $_POST['txtDistanceType'];
					$extraLandmarksArr 		= $_POST['txtExtraLandmarks'];
					$extraLandmarksDistArr 	= $_POST['txtExtraLandmarkDist'];
	
					$strDelExtraLandMarksQuery = "DELETE FROM " . TABLE_PROPERTY_EXTRA_LANDMARKS . " WHERE property_id='".$property_id."'";
					$this->dbObj->mySqlSafeQuery($strDelExtraLandMarksQuery); // delete previous relations
					for($j=0;$j<count($_POST['txtExtraLandmarks']);$j++){
						$extra_landmark_name 	= $extraLandmarksArr[$j];
						$extra_landmark_dist 	= $extraLandmarksDistArr[$j];
	
						$strInsExtraLandMarksQuery = "INSERT INTO " . TABLE_PROPERTY_EXTRA_LANDMARKS . "(landmark_id, property_id, landmark_name, distance, distance_type, created_on, created_by, updated_on, updated_by) ";
						$strInsExtraLandMarksQuery .= "VALUES(null, '".$property_id."', '".$extra_landmark_name."', '".$extra_landmark_dist."', '".$txtDistanceType."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."')";
						$this->dbObj->mySqlSafeQuery($strInsExtraLandMarksQuery);
					}
				}
				
				// For deleting worng entries
				$strDelGarbageLandMarkRelationQuery = "DELETE FROM " . TABLE_PROPERTY_LANDMARK_RELATIONS . " WHERE property_id='".$property_id."' AND distance =''";
				$this->dbObj->mySqlSafeQuery($strDelGarbageLandMarkRelationQuery); // delete previous relations
			}
	
			if($_POST['securityKey']==md5(OWNERPROPERTYCHECKLIST)){		
				// Step I : if checklist type of people details available update it
				if(isset($_POST['txtPeopleType']) && $_POST['txtPeopleType'] != ""){
					//delete all previous relation
					$txtPeopleTypeArr	= $_POST['txtPeopleType'];
					$strPeopleType 		= implode(",",$txtPeopleTypeArr);
					
					// Select relation 
					$sql = "SELECT * FROM " . TABLE_PROPERTY_CHECKLIST_SETTINGS . " WHERE property_id='".(int)$property_id."'";
					$rdo = $this->dbObj->mySqlSafeQuery($sql);
					if(mysql_num_rows($rdo) > 0){
						$sqlUpdate = "UPDATE " . TABLE_PROPERTY_CHECKLIST_SETTINGS . " SET holiday_ptype='" . $strPeopleType . "' WHERE property_id='".(int)$property_id."'";
						$rdoUpdate = $this->dbObj->mySqlSafeQuery($sqlUpdate);
					}
					else{
						$strInsQuery = "INSERT INTO " . TABLE_PROPERTY_CHECKLIST_SETTINGS . "(checklist_setting_id, property_id, holiday_ptype) ";
						$strInsQuery .= "VALUES(null, '".$property_id."', '".$strPeopleType."')";
						$this->dbObj->mySqlSafeQuery($strInsQuery);
					}
				}
	
				// Step II : if checklist type of holiday details available update it
				if(isset($_POST['txtHolidayType']) && $_POST['txtHolidayType'] != ""){
					//delete all previous relation
					$txtHolidayTypeArr	= $_POST['txtHolidayType'];
					$strHolidayType 		= implode(",",$txtHolidayTypeArr);
					
					// Select relation 
					$sql = "SELECT * FROM " . TABLE_PROPERTY_CHECKLIST_SETTINGS . " WHERE property_id='".(int)$property_id."'";
					$rdo = $this->dbObj->mySqlSafeQuery($sql);
					if(mysql_num_rows($rdo) > 0){
						$sqlUpdate = "UPDATE " . TABLE_PROPERTY_CHECKLIST_SETTINGS . " SET holiday_type='" . $strHolidayType . "' WHERE property_id='".(int)$property_id."'";
						$rdoUpdate = $this->dbObj->mySqlSafeQuery($sqlUpdate);
					}
					else{
						$strInsQuery = "INSERT INTO " . TABLE_PROPERTY_CHECKLIST_SETTINGS . "(checklist_setting_id, property_id, holiday_type) ";
						$strInsQuery .= "VALUES(null, '".$property_id."', '".$strHolidayType."')";
						$this->dbObj->mySqlSafeQuery($strInsQuery);
					}
				}

				// Step III : if checklist type of accomadation details available update it
				if(isset($_POST['txtAccommodationType']) && $_POST['txtAccommodationType'] != ""){
					//delete all previous relation
					$txtAccommodationTypeArr	= $_POST['txtAccommodationType'];
					$strAccommodationType 		= implode(",",$txtAccommodationTypeArr);
					
					// Select relation 
					$sql = "SELECT * FROM " . TABLE_PROPERTY_CHECKLIST_SETTINGS . " WHERE property_id='".(int)$property_id."'";
					$rdo = $this->dbObj->mySqlSafeQuery($sql);
					if(mysql_num_rows($rdo) > 0){
						$sqlUpdate = "UPDATE " . TABLE_PROPERTY_CHECKLIST_SETTINGS . " SET accommodation_type='" . $strAccommodationType . "' WHERE property_id='".(int)$property_id."'";
						$rdoUpdate = $this->dbObj->mySqlSafeQuery($sqlUpdate);
					}
					else{
						$strInsQuery = "INSERT INTO " . TABLE_PROPERTY_CHECKLIST_SETTINGS . "(checklist_setting_id, property_id, accommodation_type) ";
						$strInsQuery .= "VALUES(null, '".$property_id."', '".$strAccommodationType."')";
						$this->dbObj->mySqlSafeQuery($strInsQuery);
					}
				}


				// Step IV : if checklist amenities and features details available update it
				if(isset($_POST['txtAmenitiesFeatures']) && $_POST['txtAmenitiesFeatures'] != ""){
					//delete all previous relation
					$txtAmenitiesFeaturesArr	= $_POST['txtAmenitiesFeatures'];
					$strAmenitiesFeatures 		= implode(",",$txtAmenitiesFeaturesArr);
					
					// Select relation 
					$sql = "SELECT * FROM " . TABLE_PROPERTY_CHECKLIST_SETTINGS . " WHERE property_id='".(int)$property_id."'";
					$rdo = $this->dbObj->mySqlSafeQuery($sql);
					if(mysql_num_rows($rdo) > 0){
						$sqlUpdate = "UPDATE " . TABLE_PROPERTY_CHECKLIST_SETTINGS . " SET amenities_type='" . $strAmenitiesFeatures . "' WHERE property_id='".(int)$property_id."'";
						$rdoUpdate = $this->dbObj->mySqlSafeQuery($sqlUpdate);
					}
					else{
						$strInsQuery = "INSERT INTO " . TABLE_PROPERTY_CHECKLIST_SETTINGS . "(checklist_setting_id, property_id, amenities_type) ";
						$strInsQuery .= "VALUES(null, '".$property_id."', '".$strAmenitiesFeatures."')";
						$this->dbObj->mySqlSafeQuery($strInsQuery);
					}
				}

			}

			if($_POST['securityKey']==md5(OWNERPROPERTYPRICES)){		

                $txtDayFrom 			= $_POST['txtDayFrom'];
                $txtMonthFrom 			= $_POST['txtMonthFrom'];
                $txtYearFrom 			= $_POST['txtYearFrom'];
                $txtDayTo 				= $_POST['txtDayTo'];
                $txtMonthTo 			= $_POST['txtMonthTo'];
                $txtYearTo 				= $_POST['txtYearTo'];
                $txtRateType 			= $_POST['txtRateType'];
                $txtRateName 			= $_POST['txtRateName'];
				if(isset($_POST['txtDayFrom']) && $_POST['txtDayFrom'] !="") {
	//				list($txtMonthFrom, $txtDayFrom, $txtYearFrom) = split('[/.-]', $_POST['txtDateFrom']);
	                $strUnixDateFrom 		= mktime(0, 0, 0, (int)$txtMonthFrom, (int)$txtDayFrom, (int)$txtYearFrom);
				} 
				if(isset($_POST['txtDayTo']) && $_POST['txtDayTo'] !="") {
//					list($txtMonthTo, $txtDayTo, $txtYearTo) = split('[/.-]', $_POST['txtDateTo']);
	                $strUnixDateTo	 		= mktime(0, 0, 0, (int)$txtMonthTo, (int)$txtDayTo, (int)$txtYearTo);
				} 

/*
                $txtDayFrom 			= $_POST['txtDayFrom'];
                $txtMonthFrom 			= $_POST['txtMonthFrom'];
                $txtYearFrom 			= $_POST['txtYearFrom'];
                $txtDayTo 				= $_POST['txtDayTo'];
                $txtMonthTo 			= $_POST['txtMonthTo'];
                $txtYearTo 				= $_POST['txtYearTo'];
*/

				if(isset($_POST['txtMinStay']) && $_POST['txtMinStay'] != "") {
					$txtMinStay			= $_POST['txtMinStay'];
				} else {
					$txtMinStay			= "0";
				}
                $txtMinStayType 		= $_POST['txtMinStayType'];

				if(isset($_POST['txtMonthPrice']) && $_POST['txtMonthPrice'] != "") {
					$txtMonthPrice 		= $_POST['txtMonthPrice'];
				} else {
					$txtMonthPrice 		= "0";
				}

				if(isset($_POST['txtWeekPrice']) && $_POST['txtWeekPrice'] != "") {
					$txtWeekPrice 		= $_POST['txtWeekPrice'];
				} else {
					$txtWeekPrice 		= "0";
				}

				if(isset($_POST['txtNightMidweekPrice']) && $_POST['txtNightMidweekPrice'] != "") {
					$txtNightMidweekPrice 	= $_POST['txtNightMidweekPrice'];
				} else {
					$txtNightMidweekPrice 	= "0";
				}

				if(isset($_POST['txtNightWeekendPrice']) && $_POST['txtNightWeekendPrice'] != "") {
					$txtNightWeekendPrice 	= $_POST['txtNightWeekendPrice'];
				} else {
					$txtNightWeekendPrice 	= "0";
				}

                $special_offer 			= $_POST['txtSpecialOffer'];
				if(isset($_POST['txtCurrencyType']) && $_POST['txtCurrencyType'] != "" && $_POST['txtCurrencyType'] != "0"){
					$currency_code = $_POST['txtCurrencyType'];
                } else {
					$currency_code = "1";
                }

				// Step II : if price note details available update it
				if(isset($_POST['txtOwnerNotes'])){
                    $owner_notes = fun_db_input($_POST['txtOwnerNotes']);
					$this->dbObj->insertOrUpdateFields(TABLE_PROPERTY_PRICE_NOTES, "property_id", $property_id, array("property_id", "owner_notes", "created_on", "created_by",  "updated_on",  "updated_by"),  array($property_id, $owner_notes, $cur_unixtime, $cur_user_id, $cur_unixtime, $cur_user_id));
				}

				// Step II : if price note details available update it
				if(isset($_POST['txtPriceNotes'])){
                    $price_notes = fun_db_input($_POST['txtPriceNotes']);
					$this->dbObj->insertOrUpdateFields(TABLE_PROPERTY_PRICE_NOTES, "property_id", $property_id, array("property_id", "price_notes", "created_on", "created_by",  "updated_on",  "updated_by"),  array($property_id, $price_notes, $cur_unixtime, $cur_user_id, $cur_unixtime, $cur_user_id));
				}

				// Step III : if accept_credit_card details available update it
				$accept_credit_card = $_POST['txtAcceptCreditCard'];
				$tax_rate 			= (is_numeric($_POST['txtTaxRate'])==true)?$_POST['txtTaxRate']:"";
				$cleaning_charge 	= (is_numeric($_POST['txtCleaning'])==true)?$_POST['txtCleaning']:"";
				$required_gratuity 	= (is_numeric($_POST['txtReqGratuity'])==true)?$_POST['txtReqGratuity']:"";
				$this->dbObj->insertOrUpdateFields(TABLE_PROPERTY_PRICE_NOTES, "property_id", $property_id, array("property_id", "accept_credit_card", "tax_rate", "cleaning_charge", "required_gratuity", "created_on", "created_by",  "updated_on",  "updated_by"),  array($property_id, $accept_credit_card, $tax_rate, $cleaning_charge, $required_gratuity, $cur_unixtime, $cur_user_id, $cur_unixtime, $cur_user_id));

				// Step III : if accept_credit_card details available update it
				if(isset($_POST['txtAcceptCreditCard'])){
                    $accept_credit_card = $_POST['txtAcceptCreditCard'];
					$this->dbObj->insertOrUpdateFields(TABLE_PROPERTY_PRICE_NOTES, "property_id", $property_id, array("property_id", "accept_credit_card", "created_on", "created_by",  "updated_on",  "updated_by"),  array($property_id, $accept_credit_card, $cur_unixtime, $cur_user_id, $cur_unixtime, $cur_user_id));
				}

				// Step III : if Currency Type details available update it
				if(isset($currency_code) && $currency_code != ""){
                    $sqlUpdate = "UPDATE " . TABLE_PROPERTY_PRICES . " SET currency_code='" . $currency_code . "' WHERE property_id='".(int)$property_id."'";
                    $rdoUpdate = $this->dbObj->mySqlSafeQuery($sqlUpdate);
				}

				// Step I : if price detail available update / insert it
				if($txtRateName != "" && $txtRateName != "" && $strUnixDateFrom !="" && $strUnixDateTo !="") {
                    if(isset($_POST['txtPriceId']) && $_POST['txtPriceId'] != ""){
                        $txtPriceId = $_POST['txtPriceId'];
                        $this->dbObj->updateFields(TABLE_PROPERTY_PRICES, "id", $txtPriceId, array("price_name", "date_from", "date_to", "min_stay", "min_stay_type", "per_month_price", "per_week_price", "per_night_midweek_price", "per_night_weekend_price", "currency_code", "special_offer", "price_type", "updated_on", "updated_by"), array($txtRateName, $strUnixDateFrom, $strUnixDateTo, $txtMinStay, $txtMinStayType, $txtMonthPrice, $txtWeekPrice, $txtNightMidweekPrice, $txtNightWeekendPrice, $currency_code, $special_offer, $txtRateType, $cur_unixtime, $cur_user_id));
                    } else {
                        $this->dbObj->insertFields(TABLE_PROPERTY_PRICES, array("property_id", "price_name", "date_from", "date_to", "min_stay", "min_stay_type", "per_month_price", "per_week_price", "per_night_midweek_price", "per_night_weekend_price",  "currency_code", "special_offer", "price_type", "created_on", "created_by", "updated_on", "updated_by"), array($property_id, $txtRateName, $strUnixDateFrom, $strUnixDateTo, $txtMinStay, $txtMinStayType, $txtMonthPrice, $txtWeekPrice, $txtNightMidweekPrice, $txtNightWeekendPrice, $currency_code, $special_offer, $txtRateType, $cur_unixtime, $cur_user_id, $cur_unixtime, $cur_user_id));
                    }
					return true;
                } else {
					return false;
				}
			}

			if($_POST['securityKey']==md5(OWNERPROPERTYCONTACTS)){		
				// Step I: if contact details available update it
				if(isset($_POST['txtContactName']) && $_POST['txtContactName'] != ""){
					//Step I: insert / update contact details
					$contact_name 		= fun_db_input($_POST['txtContactName']);
					if(isset($_POST['txtContactResponceShow']) && $_POST['txtContactResponceShow'] != "") {
						$contact_name_show 	= $_POST['txtContactNameShow'];


					} else {
						$contact_name_show 	= 1;
					}
			
					$response_time 			= $_POST['txtContactResponce'];
					$response_time_type 	= $_POST['txtContactResponceType'];
					if(isset($_POST['txtContactResponceShow']) && $_POST['txtContactResponceShow'] != "") {
						$response_time_show = $_POST['txtContactResponceShow'];

					} else {
						$response_time_show = 1;
					}
					$this->dbObj->insertOrUpdateFields(TABLE_PROPERTY_CONTACTS, "property_id", $property_id, array("property_id", "contact_name", "contact_name_show", "response_time",  "response_time_type",  "response_time_show", "created_on", "created_by",  "updated_on",  "updated_by"),  array($property_id, $contact_name, $contact_name_show, $response_time, $response_time_type, $response_time_show, $cur_unixtime, $cur_user_id, $cur_unixtime, $cur_user_id));
			
					//Step II: delete / update contact number details
					$strDelContactNumbersQuery = "DELETE FROM " . TABLE_PROPERTY_CONTACT_NUMBERS . " WHERE property_id='".$property_id."'";
					$this->dbObj->mySqlSafeQuery($strDelContactNumbersQuery); // delete previous relations
			
					$txtContactNumber		= $_POST['txtContactNumber'];
					$txtContactNumberShow 	= $_POST['txtContactNumberShow'];
					$txtContactNumberType 	= $_POST['txtContactNumberType'];
					$txtCountry 			= $_POST['txtCountry'];
			
					if($txtContactNumber !=""){
						for($i=0; $i<count($txtContactNumber); $i++){
							$contact_number 			= $txtContactNumber[$i];
							$contact_number_show 		= $txtContactNumberShow[$i];
							$contact_number_typeid 		= $txtContactNumberType[$i];
							$contact_number_countryid 	= $txtCountry[$i];
							
							if($contact_number != "" && $contact_number != "Enter Number" && is_numeric($contact_number)){
								$strInsContactNumbersQuery = "INSERT INTO " . TABLE_PROPERTY_CONTACT_NUMBERS . "(id, property_id, contact_number_typeid, contact_number_countryid, contact_number, contact_number_show, created_on, created_by, updated_on, updated_by) ";
								$strInsContactNumbersQuery .= "VALUES(null, '".$property_id."', '".$contact_number_typeid."', '".$contact_number_countryid."', '".$contact_number."', '".$contact_number_show."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."')";
								$this->dbObj->mySqlSafeQuery($strInsContactNumbersQuery);
							}
						}
					}
			
					//Step III: delete / update contact language details
					$strDelContactLanguagesQuery = "DELETE FROM " . TABLE_PROPERTY_CONTACT_LANGUAGES . " WHERE property_id='".$property_id."'";
					$this->dbObj->mySqlSafeQuery($strDelContactLanguagesQuery); // delete previous relations
//					$txtContactLanguageShow	= $_POST['txtContactLanguageShow'];
//					$txtContactLanguageShow	= 1;
					$txtContactLanguageArr 	= $_POST['txtContactLanguage'];
					if($txtContactLanguageArr !=""){
						for($j=0; $j < count($txtContactLanguageArr); $j++){
							$txtContactLanguage 		= $txtContactLanguageArr[$j];
							$txtContactLanguageShow		= 1;
//							$txtContactLanguageShow 	= $txtContactLanguageShow[$j];
							if($txtContactLanguage !=""){
								$strInsContactLanguagesQuery = "INSERT INTO " . TABLE_PROPERTY_CONTACT_LANGUAGES . "(id, property_id, language_id, language_show, created_on, created_by, updated_on, updated_by) ";
								$strInsContactLanguagesQuery .= "VALUES(null, '".$property_id."', '".$txtContactLanguage."', '".$txtContactLanguageShow."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."')";
								$this->dbObj->mySqlSafeQuery($strInsContactLanguagesQuery);
							}
						}
					}
				}
				return true;

			}
			return true;
		}
	}

	// Function for find tagcode
	function fun_getPropertyTagCodeByName($tag_name){		
		if($tag_name == '') {
			return false;
		} else {
			$sql 	= "SELECT id FROM " . TABLE_TAGS . " WHERE tag_name ='".$tag_name."'";
			$rs 	= $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0) {
				$arr 	= $this->dbObj->fetchAssoc($rs);
				return $arr[0]['id'];
			} else {
				$cur_unixtime 	= time ();
				if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !=""){
					$cur_user_id 	= $_SESSION['ses_admin_id'];
				} else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !="") {
					$cur_user_id 	= $_SESSION['ses_modarator_id'];
				} else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !="") {
					$cur_user_id 	= $_SESSION['ses_user_id'];
				} else {
					$cur_user_id 	= "";
				}
	
				$strInsQuery = "INSERT INTO " . TABLE_TAGS . " (id, tag_name, tag_counter, created_on, created_by, updated_on, updated_by) VALUES(null, '".fun_db_input($tag_name)."', '0', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."')";
				$this->dbObj->mySqlSafeQuery($strInsQuery);
				$id = $this->dbObj->getIdentity();
				return $id;
			}
		}
	}

	// Function for find tagname
	function fun_getPropertyTagNameByCode($tag_code){		
		if($tag_code == '') {
			return false;
		} else {
			$sql 	= "SELECT tag_name FROM " . TABLE_TAGS . " WHERE id ='".$tag_code."'";
			$rs 	= $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0) {
				$arr 	= $this->dbObj->fetchAssoc($rs);
				return $arr[0]['tag_name'];
			} else {
				return false;
			}
		}
	}

	// Function	for updating property rating
	function fun_edittags($id = '', $tag_name = ''){
		if($id == '' || $tag_name == ''){
			return false;
		} else {
			$sqlUpdate = "UPDATE " . TABLE_TAGS . " SET tag_name = '" . fun_db_input($tag_name) . "' WHERE id='".(int)$id."'";
			$this->dbObj->mySqlSafeQuery($sqlUpdate);
			return true;
		}
	}

	// Function	for updating property rating
	function fun_updateRating($property_id = '', $sa_rating = ''){
		if($property_id == '' || $sa_rating == ''){
			return false;
		}
		else{
			$propertyArray = array(							
				"rating" 			=> $sa_rating,
			);

			$fields = "";
			foreach($propertyArray as $keys => $vals){
				$fields .= $keys . "='" . fun_db_input($vals). "', ";
			}
			if($fields!=""){
				$fields = substr($fields,0,strlen($fields)-2);
				$sqlUpdate = "UPDATE " . TABLE_PROPERTY . " SET " . $fields . " WHERE property_id='".(int)$property_id."'";
				$this->dbObj->mySqlSafeQuery($sqlUpdate);
				return true;
			}
		}
	}

	//Add Unit to the property
	function fun_addPropertyUnit($property_pid, $unit_name){
		if($property_pid == '' || $unit_name == ''){
			return false;
		}
		else{
			$cur_unixtime 			= time ();
			$cur_user_id 			= $_SESSION['ses_user_id'];
			$status 				= 1;
			$rating 				= 0;
			$featured 				= 0;
			$active 				= 0;

			$propertyArray = array(							
				"property_pid" 		=> $property_pid,
				"property_type" 	=> $property_type,
				"property_name" 	=> $unit_name,
				"status" 			=> $status,
				"rating" 			=> $rating,
				"created_on" 		=> $cur_unixtime,
				"created_by" 		=> $cur_user_id,
				"updated_on" 		=> $cur_unixtime,
				"updated_by" 		=> $cur_user_id,
				"featured" 			=> $featured,
				"active" 			=> $active
			);

			$fields = "";
			$fieldsVals = "";
			$cnt = 0;
			foreach($propertyArray as $keys => $values){
				$fields .= $keys;
				$fieldsVals .= "'" . fun_db_input($values) . "'";
				if($cnt < sizeof($propertyArray)-1){
					$fields .= ", ";
					$fieldsVals .= ", ";
				}
				$cnt++;
			}
			$sqlInsert = "INSERT INTO " . TABLE_PROPERTY . "(property_id, ".$fields.") ";
			$sqlInsert .= "VALUES(null, ".$fieldsVals.")";
			$this->dbObj->fun_db_query($sqlInsert);
			return $this->dbObj->fun_db_last_inserted_id();
		}
    }

	//Add property deals
	function fun_addPropertyDeal($property_id) {
		// Step I : if propoerty deal available update it
		$txtDayFrom0 		= $_POST['txtDayFrom0'];
		$txtMonthFrom0 		= $_POST['txtMonthFrom0'];
		$txtYearFrom0 		= $_POST['txtYearFrom0'];
		$txtDayTo0 			= $_POST['txtDayTo0'];
		$txtMonthTo0 		= $_POST['txtMonthTo0'];
		$txtYearTo0 		= $_POST['txtYearTo0'];
		$txtCurrencyType 	= $_POST['txtCurrencyType'];
		$txtOrgWeekPrice0 	= $_POST['txtOrgWeekPrice0'];
		$txtSaleWeekPrice0 	= $_POST['txtSaleWeekPrice0'];
		$txtRemoveDealFrom0 = $_POST['txtRemoveDealFrom0'];
		$min_stay 			= $_POST['txtMinStay'];
		$min_stay_type 		= $_POST['txtMinStayType'];
		
		$special_deal_type 	= 1;
		$special_deal_title = "late deal";
		$special_deal_desc 	= "late deal";
//		$min_stay_type 		= "n";

		$strUnixDateFrom 	= mktime(0, 0, 0, (int)$txtMonthFrom0, (int)$txtDayFrom0, (int)$txtYearFrom0);
		$strUnixDateTo	 	= mktime(0, 0, 0, (int)$txtMonthTo0, (int)$txtDayTo0, (int)$txtYearTo0);
		$cur_unixtime 	= time ();
		if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !=""){
			$cur_user_id 	= $_SESSION['ses_admin_id'];
		} else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !=""){
			$cur_user_id 	= $_SESSION['ses_modarator_id'];
		} else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !=""){
			$cur_user_id 	= $_SESSION['ses_user_id'];
		} else {
			$cur_user_id 	= "";
		}
		
		$status = 2;
//		$strNights				= (int)(($strUnixDateTo - $strUnixDateFrom) / (60 * 60 * 24));
//		$strNights = 1;
		$specialDealArray = array(							
			"property_id" 				=> $property_id,
			"special_deal_type" 		=> $special_deal_type,
			"special_deal_title" 		=> $special_deal_title,
			"special_deal_desc" 		=> $special_deal_desc,
			"start_on"			 		=> $strUnixDateFrom,
			"end_on" 					=> $strUnixDateTo,
			"original_price" 			=> $txtOrgWeekPrice0,
			"sale_price" 				=> $txtSaleWeekPrice0,
			"min_stay" 					=> $min_stay,
			"min_stay_type" 			=> $min_stay_type,
			"created_on" 				=> $cur_unixtime,
			"created_by" 				=> $cur_user_id,
			"updated_on" 				=> $cur_unixtime,
			"updated_by" 				=> $cur_user_id,
			"remove_from" 				=> $txtRemoveDealFrom0,
			"status"	 				=> $status
		);

		$priceArray = array(							
			"property_id" 				=> $property_id,
			"date_from" 				=> $strUnixDateFrom,
			"date_to" 					=> $strUnixDateTo,
			"min_stay" 					=> $min_stay,
			"min_stay_type" 			=> $min_stay_type,
			"per_week_price" 			=> $txtSaleWeekPrice0,
			"per_night_midweek_price" 	=> "",
			"per_night_weekend_price" 	=> "",
			"currency_code" 			=> $txtCurrencyType,
			"created_on" 				=> $cur_unixtime,
			"created_by" 				=> $cur_user_id,
			"updated_on" 				=> $cur_unixtime,
			"updated_by" 				=> $cur_user_id
		);
		
		
		if(isset($_POST['txtPropertyDealId']) && $_POST['txtPropertyDealId'] != ""){
			//then edit
			$txtPropertyDealId = $_POST['txtPropertyDealId'];
			$fields = "";
			foreach($specialDealArray as $keys => $vals){
				$fields .= $keys . "='" . fun_db_input($vals). "', ";
			}
			if($fields!=""){
				$fields = substr($fields,0,strlen($fields)-2);
				$sqlUpdate = "UPDATE " . TABLE_PROPERTY_SPECIAL_DEALS_RELATIONS . " SET " . $fields . " WHERE id='".(int)$txtPropertyDealId."'";
				$this->dbObj->mySqlSafeQuery($sqlUpdate);
			}

			$fields = "";
			foreach($priceArray as $keys => $vals){
				$fields .= $keys . "='" . fun_db_input($vals). "', ";
			}
			if($fields!=""){
				$fields = substr($fields,0,strlen($fields)-2);
				$sqlUpdate = "UPDATE " . TABLE_PROPERTY_PRICES . " SET " . $fields . " WHERE special_offer='".(int)$txtPropertyDealId."'";
				$this->dbObj->mySqlSafeQuery($sqlUpdate);
			}
		} else {
			$specialDealArray['created_on'] = $cur_unixtime;
			$specialDealArray['created_by'] = $cur_user_id;

			$fields = "";
			$fieldsVals = "";
			$cnt = 0;
			foreach($specialDealArray as $keys => $values){
				$fields .= $keys;
				$fieldsVals .= "'" . fun_db_input($values) . "'";
				if($cnt < sizeof($specialDealArray)-1){
					$fields .= ", ";
					$fieldsVals .= ", ";
				}
				$cnt++;
			}
			$sqlInsert = "INSERT INTO " . TABLE_PROPERTY_SPECIAL_DEALS_RELATIONS . "(id, ".$fields.") ";
			$sqlInsert .= "VALUES(null, ".$fieldsVals.")";
			$this->dbObj->fun_db_query($sqlInsert);
			$txtPropertyDealId = $this->dbObj->fun_db_last_inserted_id();
			$priceArray['special_offer'] = $txtPropertyDealId;
			$fields = "";
			$fieldsVals = "";
			$cnt = 0;
			foreach($priceArray as $keys => $values){
				$fields .= $keys;
				$fieldsVals .= "'" . fun_db_input($values) . "'";
				if($cnt < sizeof($priceArray)-1){
					$fields .= ", ";
					$fieldsVals .= ", ";
				}
				$cnt++;
			}
			$sqlInsert = "INSERT INTO " . TABLE_PROPERTY_PRICES . "(id, ".$fields.") ";
			$sqlInsert .= "VALUES(null, ".$fieldsVals.")";
			$this->dbObj->fun_db_query($sqlInsert);
		}
	}

	//Edit property deals
	function fun_editPropertyDeal($txtPropertyDealId, $txtPrpertyRef, $txtDayFrom0, $txtMonthFrom0, $txtYearFrom0, $txtDayTo0, $txtMonthTo0, $txtYearTo0, $txtCurrencyType, $txtOrgWeekPrice0, $txtSaleWeekPrice0, $txtMinStay, $txtMinStayType, $txtRemoveDealFrom0, $txtLateDealStatusId) {
		// Step I : if propoerty deal available update it
		$special_deal_type 	= 1;
		$special_deal_title = "late deal";
		$special_deal_desc 	= "late deal";
		$min_stay 			= $txtMinStay;
		$min_stay_type 		= $txtMinStayType;

		$strUnixDateFrom 	= mktime(0, 0, 0, (int)$txtMonthFrom0, (int)$txtDayFrom0, (int)$txtYearFrom0);
		$strUnixDateTo	 	= mktime(0, 0, 0, (int)$txtMonthTo0, (int)$txtDayTo0, (int)$txtYearTo0);
		$cur_unixtime 		= time ();
		if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !=""){
			$cur_user_id 	= $_SESSION['ses_admin_id'];
		} else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !=""){
			$cur_user_id 	= $_SESSION['ses_modarator_id'];
		} else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !=""){
			$cur_user_id 	= $_SESSION['ses_user_id'];
		} else {
			$cur_user_id 	= "";
		}
		
		$status 			= $txtLateDealStatusId;
//		$strNights			= (int)(($strUnixDateTo - $strUnixDateFrom) / (60 * 60 * 24));
		$strNights			= 1;
		$specialDealArray = array(							
			"property_id" 				=> $txtPrpertyRef,
			"special_deal_type" 		=> $special_deal_type,
			"special_deal_title" 		=> $special_deal_title,
			"special_deal_desc" 		=> $special_deal_desc,
			"start_on"			 		=> $strUnixDateFrom,
			"end_on" 					=> $strUnixDateTo,
			"original_price" 			=> $txtOrgWeekPrice0,
			"sale_price" 				=> $txtSaleWeekPrice0,
			"min_stay" 					=> $min_stay,
			"min_stay_type" 			=> $min_stay_type,
			"created_on" 				=> $cur_unixtime,
			"created_by" 				=> $cur_user_id,
			"updated_on" 				=> $cur_unixtime,
			"updated_by" 				=> $cur_user_id,
			"remove_from" 				=> $txtRemoveDealFrom0,
			"status"	 				=> $status
		);

        $fields = "";
        foreach($specialDealArray as $keys => $vals){
            $fields .= $keys . "='" . fun_db_input($vals). "', ";
        }
        if($fields!=""){
            $fields = substr($fields,0,strlen($fields)-2);
            $sqlUpdate = "UPDATE " . TABLE_PROPERTY_SPECIAL_DEALS_RELATIONS . " SET " . $fields . " WHERE id='".(int)$txtPropertyDealId."'";
            $this->dbObj->mySqlSafeQuery($sqlUpdate);
        }
    }

	//Edit property name
	function fun_editPropertyName($property_id, $property_name){
		if($property_id == '' || $property_name == ''){
			return false;
		}
		else{
			$propertyArray = array(							
				"property_name" 			=> $property_name,
			);

			$fields = "";
			foreach($propertyArray as $keys => $vals){
				$fields .= $keys . "='" . fun_db_input($vals). "', ";
			}
			if($fields!=""){
				$fields = substr($fields,0,strlen($fields)-2);
				$sqlUpdate = "UPDATE " . TABLE_PROPERTY . " SET " . $fields . " WHERE property_id='".(int)$property_id."'";
				$this->dbObj->mySqlSafeQuery($sqlUpdate);
				return true;
			}
		}
    }

	function fun_copyPropertyDetails($property_id, $unit_id){
		if($property_id == '' || $unit_id == ''){
			return false;
		} else {
			$cur_unixtime 	= time ();
			if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !=""){
				$cur_user_id 	= $_SESSION['ses_admin_id'];
			}
			else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !=""){
				$cur_user_id 	= $_SESSION['ses_modarator_id'];
			}
			else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !=""){
				$cur_user_id 	= $_SESSION['ses_user_id'];
			}
			else{
				$cur_user_id 	= "";
			}

			/*
			* For (1) Property name, (2)Property title, (3)Property type, (4) Catering type, (5) Property summary, (6) Property description
			*(7) SA Tourism rating, (8) URL for this property
			* : Start Here 
			*/
			// Step 1: select details from property where property id == unit id and update it
			$propertyInfoArray 	= array();		
			$sql = "SELECT * FROM " . TABLE_PROPERTY . " WHERE property_id='".$unit_id."'";
			$result = $this->dbObj->fun_db_query($sql);
			if($this->dbObj->fun_db_get_num_rows($result) > 0){
				$rowsArray = $this->dbObj->fun_db_fetch_rs_object($result);
				$propertyInfoArray['property_type'] 	= fun_db_output($rowsArray->property_type);
				$propertyInfoArray['catering_type'] 	= fun_db_output($rowsArray->catering_type);
				$propertyInfoArray['property_title'] 	= fun_db_output($rowsArray->property_title);
				$propertyInfoArray['property_summary'] 	= fun_db_output($rowsArray->property_summary);
				$propertyInfoArray['description'] 		= fun_db_output($rowsArray->description);
				$propertyInfoArray['region_id'] 		= fun_db_output($rowsArray->region_id);
				$propertyInfoArray['subregion_id'] 		= fun_db_output($rowsArray->subregion_id);
				$propertyInfoArray['location_id'] 		= fun_db_output($rowsArray->location_id);
				$propertyInfoArray['zip'] 				= fun_db_output($rowsArray->zip);
				$propertyInfoArray['latitude'] 			= fun_db_output($rowsArray->latitude);
				$propertyInfoArray['longitude'] 		= fun_db_output($rowsArray->longitude);
				$propertyInfoArray['rating'] 			= fun_db_output($rowsArray->rating);
				$propertyInfoArray['friendly_link'] 	= fun_db_output($rowsArray->friendly_link);
				$propertyInfoArray['updated_on'] 		= $cur_unixtime;
				$propertyInfoArray['updated_by'] 		= $cur_user_id;

				$fields = "";
				foreach($propertyInfoArray as $keys => $vals){
					$fields .= $keys . "='" . fun_db_input($vals). "', ";
				}
				if($fields!=""){
					$fields = substr($fields,0,strlen($fields)-2);
					$sqlUpdate = "UPDATE " . TABLE_PROPERTY . " SET " . $fields . " WHERE property_id='".(int)$property_id."'";
					$this->dbObj->mySqlSafeQuery($sqlUpdate);
				}
			}
			/*
			* For (1) Property name, (2)Property title, (3)Property type, (4) Catering type, (5) Property summary, (6) Property description
			*(7) SA Tourism rating, (8) URL for this property
			* : End Here 

			*/

			/*
			* For Bedrooms details : Start here
			*/
			if(($bedInfoArray = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_BEDROOM_RELATIONS , " WHERE property_id='".$unit_id."'")) && (is_array($bedInfoArray))){
				$propertyBedInfoArray['property_id'] 		= $property_id;
				$propertyBedInfoArray['total_beds'] 		= $bedInfoArray[0]['total_beds'];
				$propertyBedInfoArray['ensuite_beds'] 		= $bedInfoArray[0]['ensuite_beds'];
				$propertyBedInfoArray['scomfort_beds']		= $bedInfoArray[0]['scomfort_beds'];
				$propertyBedInfoArray['double_beds'] 		= $bedInfoArray[0]['double_beds'];
				$propertyBedInfoArray['single_beds'] 		= $bedInfoArray[0]['single_beds'];
				$propertyBedInfoArray['sofa_beds'] 			= $bedInfoArray[0]['sofa_beds'];
				$propertyBedInfoArray['cots'] 				= $bedInfoArray[0]['cots'];
				$propertyBedInfoArray['notes'] 			= $bedInfoArray[0]['notes'];
				$propertyBedInfoArray['updated_on'] 		= $cur_unixtime;
				$propertyBedInfoArray['updated_by'] 		= $cur_user_id;

				if(($bed_relation_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_BEDROOM_RELATIONS , " WHERE property_id='".$property_id."'")) && (is_array($bed_relation_array))){
					$bed_relation_id 		= $bed_relation_array[0]['id'];
	
					$fields = "";
					foreach($propertyBedInfoArray as $keys => $vals){
						$fields .= $keys . "='" . fun_db_input($vals). "', ";
					}
					if($fields!=""){
						$fields = substr($fields,0,strlen($fields)-2);
						$sqlUpdate = "UPDATE " . TABLE_PROPERTY_BEDROOM_RELATIONS . " SET " . $fields . " WHERE id='".(int)$bed_relation_id."'";
						$this->dbObj->mySqlSafeQuery($sqlUpdate);
					}
				} else { // insert new relation
					$propertyBedInfoArray['created_on'] 		= $cur_unixtime;
					$propertyBedInfoArray['created_by'] 		= $cur_user_id;
	
					$fields = "";
					$fieldsVals = "";
					$cnt = 0;
					foreach($propertyBedInfoArray as $keys => $values){
						$fields .= $keys;
						$fieldsVals .= "'" . fun_db_input($values) . "'";
						if($cnt < sizeof($propertyBedInfoArray)-1){
							$fields .= ", ";
							$fieldsVals .= ", ";
						}
						$cnt++;
					}
					$sqlInsert = "INSERT INTO " . TABLE_PROPERTY_BEDROOM_RELATIONS . "(id, ".$fields.") ";
					$sqlInsert .= "VALUES(null, ".$fieldsVals.")";
					$this->dbObj->fun_db_query($sqlInsert);
				}
			}
			/*
			* For Bedrooms details : End here
			*/

			/*
			* For Bathrooms details : Start here
			*/
			if(($bathInfoArray = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_BATHROOM_RELATIONS , " WHERE property_id='".$unit_id."'")) && (is_array($bathInfoArray))){
				$propertyBathInfoArray['property_id'] 		= $property_id;
				$propertyBathInfoArray['total_bathrooms'] 	= $bathInfoArray[0]['total_bathrooms'];
				$propertyBathInfoArray['ensuite_baths'] 	= $bathInfoArray[0]['ensuite_baths'];
				$propertyBathInfoArray['shower_baths']		= $bathInfoArray[0]['shower_baths'];
				$propertyBathInfoArray['baths'] 			= $bathInfoArray[0]['baths'];
				$propertyBathInfoArray['toilets'] 			= $bathInfoArray[0]['toilets'];
				$propertyBathInfoArray['notes'] 			= $bathInfoArray[0]['notes'];

				$propertyBathInfoArray['updated_on'] 		= $cur_unixtime;
				$propertyBathInfoArray['updated_by'] 		= $cur_user_id;

				if(($bath_relation_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_BATHROOM_RELATIONS , " WHERE property_id='".$property_id."'")) && (is_array($bath_relation_array))){
					$bath_relation_id 		= $bath_relation_array[0]['id'];
	
					$fields = "";
					foreach($propertyBathInfoArray as $keys => $vals){
						$fields .= $keys . "='" . fun_db_input($vals). "', ";
					}
					if($fields!=""){
						$fields = substr($fields,0,strlen($fields)-2);
						$sqlUpdate = "UPDATE " . TABLE_PROPERTY_BATHROOM_RELATIONS . " SET " . $fields . " WHERE id='".(int)$bath_relation_id."'";
						$this->dbObj->mySqlSafeQuery($sqlUpdate);
					}
				} else { // insert new relation
					$propertyBathInfoArray['created_on'] 		= $cur_unixtime;
					$propertyBathInfoArray['created_by'] 		= $cur_user_id;
	
					$fields = "";
					$fieldsVals = "";
					$cnt = 0;
					foreach($propertyBathInfoArray as $keys => $values){
						$fields .= $keys;
						$fieldsVals .= "'" . fun_db_input($values) . "'";
						if($cnt < sizeof($propertyBathInfoArray)-1){
							$fields .= ", ";
							$fieldsVals .= ", ";
						}
						$cnt++;
					}
					$sqlInsert = "INSERT INTO " . TABLE_PROPERTY_BATHROOM_RELATIONS . "(id, ".$fields.") ";
					$sqlInsert .= "VALUES(null, ".$fieldsVals.")";
					$this->dbObj->fun_db_query($sqlInsert);
				}
			}
			/*
			* For Bathrooms details : End here
			*/
			
			/*
			* For Facilities details : Start here
			*/
			if(($featureInfoArray = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_FEATURES_RELATIONS , " WHERE property_id='".$unit_id."'")) && (is_array($featureInfoArray))){
				$propertyFeatureInfoArray['property_id'] 	= $property_id;
				$propertyFeatureInfoArray['feature_ids'] 	= $featureInfoArray[0]['feature_ids'];
				$propertyFeatureInfoArray['feature_notes'] 	= $featureInfoArray[0]['feature_notes'];

				$propertyFeatureInfoArray['updated_on'] 	= $cur_unixtime;
				$propertyFeatureInfoArray['updated_by'] 	= $cur_user_id;

				if(($feature_note_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_FEATURES_RELATIONS , " WHERE property_id='".$property_id."'")) && (is_array($feature_note_array))){
					$feature_relation_id 		= $feature_note_array[0]['id'];
	
					$fields = "";
					foreach($propertyFeatureInfoArray as $keys => $vals){
						$fields .= $keys . "='" . fun_db_input($vals). "', ";
					}
					if($fields!=""){
						$fields = substr($fields,0,strlen($fields)-2);
						$sqlUpdate = "UPDATE " . TABLE_PROPERTY_FEATURES_RELATIONS . " SET " . $fields . " WHERE id='".(int)$feature_relation_id."'";
						$this->dbObj->mySqlSafeQuery($sqlUpdate);
					}
				} else { // insert new relation
					$propertyFeatureInfoArray['created_on'] 	= $cur_unixtime;
					$propertyFeatureInfoArray['created_by'] 	= $cur_user_id;
	
					$fields = "";
					$fieldsVals = "";
					$cnt = 0;
					foreach($propertyFeatureInfoArray as $keys => $values){
						$fields .= $keys;
						$fieldsVals .= "'" . fun_db_input($values) . "'";
						if($cnt < sizeof($propertyFeatureInfoArray)-1){
							$fields .= ", ";
							$fieldsVals .= ", ";
						}
						$cnt++;
					}
					$sqlInsert = "INSERT INTO " . TABLE_PROPERTY_FEATURES_RELATIONS . "(id, ".$fields.") ";
					$sqlInsert .= "VALUES(null, ".$fieldsVals.")";
					$this->dbObj->fun_db_query($sqlInsert);
				}
			}
			/*
			* For Facilities details : End here
			*/
			
			/*
			* For Special requirements details : Start here
			*/
			if(($requiremntInfoArray = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_SPECIAL_REQUIREMENTS_RELATIONS , " WHERE property_id='".$unit_id."'")) && (is_array($requiremntInfoArray))){
				$propertyRequirementInfoArray['property_id'] 		= $property_id;
				$propertyRequirementInfoArray['srequirement_ids'] 	= $requiremntInfoArray[0]['srequirement_ids'];
				$propertyRequirementInfoArray['srequirement_notes'] = $requiremntInfoArray[0]['srequirement_notes'];

				$propertyRequirementInfoArray['updated_on'] 	= $cur_unixtime;
				$propertyRequirementInfoArray['updated_by'] 	= $cur_user_id;

				if(($requiremnt_note_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_SPECIAL_REQUIREMENTS_RELATIONS , " WHERE property_id='".$property_id."'")) && (is_array($requiremnt_note_array))){
					$requiremnt_relation_id 		= $requiremnt_note_array[0]['id'];
	
					$fields = "";
					foreach($propertyRequirementInfoArray as $keys => $vals){
						$fields .= $keys . "='" . fun_db_input($vals). "', ";
					}
					if($fields!=""){
						$fields = substr($fields,0,strlen($fields)-2);
						$sqlUpdate = "UPDATE " . TABLE_PROPERTY_SPECIAL_REQUIREMENTS_RELATIONS . " SET " . $fields . " WHERE id='".(int)$requiremnt_relation_id."'";
						$this->dbObj->mySqlSafeQuery($sqlUpdate);
					}
				} else { // insert new relation
					$propertyRequirementInfoArray['created_on'] 	= $cur_unixtime;
					$propertyRequirementInfoArray['created_by'] 	= $cur_user_id;
	
					$fields = "";
					$fieldsVals = "";
					$cnt = 0;
					foreach($propertyRequirementInfoArray as $keys => $values){
						$fields .= $keys;
						$fieldsVals .= "'" . fun_db_input($values) . "'";
						if($cnt < sizeof($propertyRequirementInfoArray)-1){
							$fields .= ", ";
							$fieldsVals .= ", ";
						}
						$cnt++;
					}
					$sqlInsert = "INSERT INTO " . TABLE_PROPERTY_SPECIAL_REQUIREMENTS_RELATIONS . "(id, ".$fields.") ";
					$sqlInsert .= "VALUES(null, ".$fieldsVals.")";
					$this->dbObj->fun_db_query($sqlInsert);
				}
			}
			/*
			* For Special requirements details : End here
			*/
			
			/*
			* For Highlights details : Start here
			*/
			$strDelSellPointsQuery = "DELETE FROM " . TABLE_PROPERTY_SELLING_POINTS_RELATIONS . " WHERE property_id='".$property_id."'";
			$this->dbObj->mySqlSafeQuery($strDelSellPointsQuery); // delete previous relations

			if(($selling_points_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_SELLING_POINTS_RELATIONS , " WHERE property_id='".$unit_id."'")) && (is_array($selling_points_array))){
				$selling_point1 		= $selling_points_array[0]['selling_point'];
				$selling_point2 		= $selling_points_array[1]['selling_point'];
				$selling_point3 		= $selling_points_array[2]['selling_point'];
				$selling_point4 		= $selling_points_array[3]['selling_point'];
				$selling_point5 		= $selling_points_array[4]['selling_point'];
				$selling_point6 		= $selling_points_array[5]['selling_point'];
				$selling_point7 		= $selling_points_array[6]['selling_point'];
				$selling_point8 		= $selling_points_array[7]['selling_point'];
				$selling_point9 		= $selling_points_array[8]['selling_point'];
				$selling_point10 		= $selling_points_array[9]['selling_point'];

				if(isset($selling_point1) && $selling_point1 !="") {
					$sqlInsert = "INSERT INTO " . TABLE_PROPERTY_SELLING_POINTS_RELATIONS . "(id, property_id, selling_point, created_on, created_by, updated_on, updated_by) ";
					$sqlInsert .= "VALUES(null, '".$property_id."', '".$selling_point1."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."')";
					$this->dbObj->fun_db_query($sqlInsert);
				}

				if(isset($selling_point2) && $selling_point2 !="") {
					$sqlInsert = "INSERT INTO " . TABLE_PROPERTY_SELLING_POINTS_RELATIONS . "(id, property_id, selling_point, created_on, created_by, updated_on, updated_by) ";
					$sqlInsert .= "VALUES(null, '".$property_id."', '".$selling_point2."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."')";
					$this->dbObj->fun_db_query($sqlInsert);
				}

				if(isset($selling_point3) && $selling_point3 !="") {
					$sqlInsert = "INSERT INTO " . TABLE_PROPERTY_SELLING_POINTS_RELATIONS . "(id, property_id, selling_point, created_on, created_by, updated_on, updated_by) ";
					$sqlInsert .= "VALUES(null, '".$property_id."', '".$selling_point3."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."')";
					$this->dbObj->fun_db_query($sqlInsert);
				}

				if(isset($selling_point4) && $selling_point4 !="") {
					$sqlInsert = "INSERT INTO " . TABLE_PROPERTY_SELLING_POINTS_RELATIONS . "(id, property_id, selling_point, created_on, created_by, updated_on, updated_by) ";
					$sqlInsert .= "VALUES(null, '".$property_id."', '".$selling_point4."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."')";
					$this->dbObj->fun_db_query($sqlInsert);
				}

				if(isset($selling_point5) && $selling_point5 !="") {
					$sqlInsert = "INSERT INTO " . TABLE_PROPERTY_SELLING_POINTS_RELATIONS . "(id, property_id, selling_point, created_on, created_by, updated_on, updated_by) ";
					$sqlInsert .= "VALUES(null, '".$property_id."', '".$selling_point5."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."')";
					$this->dbObj->fun_db_query($sqlInsert);
				}

				if(isset($selling_point6) && $selling_point6 !="") {
					$sqlInsert = "INSERT INTO " . TABLE_PROPERTY_SELLING_POINTS_RELATIONS . "(id, property_id, selling_point, created_on, created_by, updated_on, updated_by) ";
					$sqlInsert .= "VALUES(null, '".$property_id."', '".$selling_point6."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."')";
					$this->dbObj->fun_db_query($sqlInsert);
				}
				if(isset($selling_point7) && $selling_point7 !="") {
					$sqlInsert = "INSERT INTO " . TABLE_PROPERTY_SELLING_POINTS_RELATIONS . "(id, property_id, selling_point, created_on, created_by, updated_on, updated_by) ";
					$sqlInsert .= "VALUES(null, '".$property_id."', '".$selling_point7."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."')";
					$this->dbObj->fun_db_query($sqlInsert);
				}
				if(isset($selling_point8) && $selling_point8 !="") {
					$sqlInsert = "INSERT INTO " . TABLE_PROPERTY_SELLING_POINTS_RELATIONS . "(id, property_id, selling_point, created_on, created_by, updated_on, updated_by) ";
					$sqlInsert .= "VALUES(null, '".$property_id."', '".$selling_point8."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."')";
					$this->dbObj->fun_db_query($sqlInsert);
				}
				if(isset($selling_point9) && $selling_point9 !="") {
					$sqlInsert = "INSERT INTO " . TABLE_PROPERTY_SELLING_POINTS_RELATIONS . "(id, property_id, selling_point, created_on, created_by, updated_on, updated_by) ";
					$sqlInsert .= "VALUES(null, '".$property_id."', '".$selling_point9."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."')";
					$this->dbObj->fun_db_query($sqlInsert);
				}
				if(isset($selling_point10) && $selling_point10 !="") {
					$sqlInsert = "INSERT INTO " . TABLE_PROPERTY_SELLING_POINTS_RELATIONS . "(id, property_id, selling_point, created_on, created_by, updated_on, updated_by) ";
					$sqlInsert .= "VALUES(null, '".$property_id."', '".$selling_point10."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."')";
					$this->dbObj->fun_db_query($sqlInsert);
				}
			}
			
			/*
			* For Highlights details : End here
			*/
			return true;
		}
	}

/*
	// Function	for updating property units
	function fun_updatePropertyUnits($property_id = ''){
		$anp_unit1 	= $_POST['anp_unit1'];
		$anp_unit2 	= $_POST['anp_unit2'];
		$anp_unit3 	= $_POST['anp_unit3'];
		$anp_unit4 	= $_POST['anp_unit4'];

		if($property_id == '' && $anp_unit1 == '' && $anp_unit2 == '' && $anp_unit3 == '' && $anp_unit4 == ''){
			return false;
		}
		else{
			if(($unit_relation_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_UNITS , " WHERE property_id='".$property_id."'")) && (is_array($unit_relation_array))){
				$strDelUnitQuery = "DELETE FROM " . TABLE_PROPERTY_UNITS . " WHERE property_id='".$property_id."'";
				$this->dbObj->mySqlSafeQuery($strDelUnitQuery); // delete previous relations
			}
			if($anp_unit1 !=""){
				$strInsUnitQuery1 = "INSERT INTO " . TABLE_PROPERTY_UNITS . "(id, property_id, unit_no, unit_name) VALUES(null, '".$property_id."', '1', '".$anp_unit1."')";
				$this->dbObj->mySqlSafeQuery($strInsUnitQuery1);
			}
			if($anp_unit2 !=""){
				$strInsUnitQuery2 = "INSERT INTO " . TABLE_PROPERTY_UNITS . "(id, property_id, unit_no, unit_name) VALUES(null, '".$property_id."', '2', '".$anp_unit2."')";
				$this->dbObj->mySqlSafeQuery($strInsUnitQuery2);
			}
			if($anp_unit3 !=""){
				$strInsUnitQuery3 = "INSERT INTO " . TABLE_PROPERTY_UNITS . "(id, property_id, unit_no, unit_name) VALUES(null, '".$property_id."', '3', '".$anp_unit3."')";
				$this->dbObj->mySqlSafeQuery($strInsUnitQuery3);
			}
			if($anp_unit4 !=""){
				$strInsUnitQuery4 = "INSERT INTO " . TABLE_PROPERTY_UNITS . "(id, property_id, unit_no, unit_name) VALUES(null, '".$property_id."', '4', '".$anp_unit4."')";
				$this->dbObj->mySqlSafeQuery($strInsUnitQuery4);
			}
		}
	}
*/

	// Function for deleting proeprties of a owner
	function fun_delPropertyByUserId($user_id){
		if($user_id == ''){
			return false;
		} else {
			//Step 1 : Select all properties
			$sql 	= "SELECT property_id FROM ". TABLE_PROPERTY_OWNER_RELATIONS." WHERE owner_id='".$user_id."'";
			$rs 	= $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr 				= $this->dbObj->fetchAssoc($rs);
				for($i = 0; $i < count($arr); $i++) {
					$property_id = $arr[$i]['property_id'];
					$this->fun_delProperty($property_id);
				}
         	}
			return true;
		}
	}
	
		// Function for delete hot property
	function fun_delhotProperty($property_hot_id){
		// Delete from TABLE_PROPERTY_HOT_RELATIONS
		$strDelQuery = "DELETE FROM " . TABLE_PROPERTY_HOT_RELATIONS . " WHERE property_hot_id='".$property_hot_id."'";
		$this->dbObj->mySqlSafeQuery($strDelQuery);
		return true;
	}

	// Function for deleting proeprties
	function fun_delProperty($property_id){
		if($property_id == ''){
			return false;
		} else {
			//Step 1 : Delete any relational data available
			// Delete from TABLE_PROPERTY_SELLING_POINTS_RELATIONS
			$strDelQuery = "DELETE FROM " . TABLE_PROPERTY_CONTACTS . " WHERE property_id='".$property_id."'";
			$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

			// Delete from TABLE_PROPERTY_SELLING_POINTS_RELATIONS
			$strDelQuery = "DELETE FROM " . TABLE_PROPERTY_PRICES . " WHERE property_id='".$property_id."'";
			$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

			// Delete from TABLE_PROPERTY_SELLING_POINTS_RELATIONS
			$strDelQuery = "DELETE FROM " . TABLE_PROPERTY_CONTACT_NUMBERS . " WHERE property_id='".$property_id."'";
			$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

			// Delete from TABLE_PROPERTY_SELLING_POINTS_RELATIONS
			$strDelQuery = "DELETE FROM " . TABLE_PROPERTY_CONTACT_LANGUAGES . " WHERE property_id='".$property_id."'";
			$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

			// Delete from TABLE_PROPERTY_SELLING_POINTS_RELATIONS
			$strDelQuery = "DELETE FROM " . TABLE_PROPERTY_AVAILABILITY_RELATIONS . " WHERE property_id='".$property_id."'";
			$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

			// Delete from TABLE_PROPERTY_SELLING_POINTS_RELATIONS
			$strDelQuery = "DELETE FROM " . TABLE_PROPERTY_PRICE_NOTES . " WHERE property_id='".$property_id."'";
			$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

			// Delete from TABLE_PROPERTY_SELLING_POINTS_RELATIONS
			$strDelQuery = "DELETE FROM " . TABLE_PROPERTY_CHECKLIST_SETTINGS . " WHERE property_id='".$property_id."'";
			$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

			// Delete from TABLE_PROPERTY_SELLING_POINTS_RELATIONS
			$strDelQuery = "DELETE FROM " . TABLE_PROPERTY_EXTRA_LANDMARKS . " WHERE property_id='".$property_id."'";
			$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

			// Delete from TABLE_PROPERTY_SELLING_POINTS_RELATIONS
			$strDelQuery = "DELETE FROM " . TABLE_PROPERTY_LANDMARK_RELATIONS . " WHERE property_id='".$property_id."'";
			$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

			// Delete from TABLE_PROPERTY_SELLING_POINTS_RELATIONS
			$strDelQuery = "DELETE FROM " . TABLE_PROPERTY_AREA_NOTES . " WHERE property_id='".$property_id."'";
			$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

			// Delete from TABLE_PROPERTY_SELLING_POINTS_RELATIONS
			$strDelQuery = "DELETE FROM " . TABLE_PROPERTY_LOCATION_GUIDES . " WHERE property_id='".$property_id."'";
			$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

			// Delete from TABLE_PROPERTY_SELLING_POINTS_RELATIONS
			$strDelQuery = "DELETE FROM " . TABLE_PROPERTY_SELLING_POINTS_RELATIONS . " WHERE property_id='".$property_id."'";
			$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

			// Delete from TABLE_PROPERTY_SELLING_POINTS_RELATIONS
			$strDelQuery = "DELETE FROM " . TABLE_PROPERTY_BEDROOM_RELATIONS . " WHERE property_id='".$property_id."'";
			$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

			// Delete from TABLE_PROPERTY_SELLING_POINTS_RELATIONS
			$strDelQuery = "DELETE FROM " . TABLE_PROPERTY_BATHROOM_RELATIONS . " WHERE property_id='".$property_id."'";
			$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

			// Delete from TABLE_PROPERTY_SELLING_POINTS_RELATIONS
			$strDelQuery = "DELETE FROM " . TABLE_PROPERTY_FEATURES_RELATIONS . " WHERE property_id='".$property_id."'";
			$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

			// Delete from TABLE_PROPERTY_SELLING_POINTS_RELATIONS
			$strDelQuery = "DELETE FROM " . TABLE_PROPERTY_SPECIAL_REQUIREMENTS_RELATIONS . " WHERE property_id='".$property_id."'";
			$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

			// For property main photo info
			if(($photo_relation_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_PHOTO_ALL , " WHERE property_id='".$property_id."'")) && (is_array($photo_relation_array))){
				for ($i = 0; $i < count($photo_relation_array); $i++) {
					$photo_id 		= $photo_relation_array[$i]['photo_id'];
					$photo_url 		= PROPERTY_IMAGES_LARGE.$photo_relation_array[$i]['photo_url'];
					$photo_thumb 	= PROPERTY_IMAGES_THUMB168x126.$photo_relation_array[$i]['photo_thumb'];
					@unlink($photo_url);
					@unlink($photo_thumb);
					// Delete from TABLE_PROPERTY_PHOTO_ALL
					$strDelPhotoQuery = "DELETE FROM " . TABLE_PROPERTY_PHOTO_ALL . " WHERE photo_id='".$photo_id."'";
					$this->dbObj->mySqlSafeQuery($strDelPhotoQuery); // delete previous relations
				}			
			}

			if(($videos_relation_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_VIDEO_ALL , " WHERE property_id='".$property_id."'")) && (is_array($videos_relation_array))){
				for ($i = 0; $i < count($videos_relation_array); $i++) {
					$video_id 			= $videos_relation_array[$i]['video_id'];
					$video_url 			= PROPERTY_VIDEO_PATH.$videos_relation_array[$i]['video_url'];
					$video_thumb_small 	= PROPERTY_VIDEO_THUMB_SMALL.$videos_relation_array[$i]['video_thumb'];
					$video_thumb_large 	= PROPERTY_VIDEO_THUMB_LARGE.$videos_relation_array[$i]['video_thumb'];
					@unlink($video_url);
					@unlink($video_thumb_small);
					@unlink($video_thumb_large);
					// Delete from TABLE_PROPERTY_VIDEO_ALL
					$strDelVideoQuery = "DELETE FROM " . TABLE_PROPERTY_VIDEO_ALL . " WHERE video_id='".$video_id."'";
					$this->dbObj->mySqlSafeQuery($strDelVideoQuery);
				}			
			}

			// Delete from TABLE_PROPERTY_OWNER_RELATIONS
			$strDelQuery = "DELETE FROM " . TABLE_PROPERTY_OWNER_RELATIONS . " WHERE property_id='".$property_id."'";
			$this->dbObj->mySqlSafeQuery($strDelQuery);

			// Delete from TABLE_PROPERTY_REVIEWS_RELATIONS
			$strDelQuery = "DELETE FROM " . TABLE_PROPERTY_REVIEWS_RELATIONS . " WHERE property_id='".$property_id."'";
			$this->dbObj->mySqlSafeQuery($strDelQuery);

			// Delete from TABLE_PROPERTY_SPECIAL_DEALS_RELATIONS
			$strDelQuery = "DELETE FROM " . TABLE_PROPERTY_SPECIAL_DEALS_RELATIONS . " WHERE property_id='".$property_id."'";
			$this->dbObj->mySqlSafeQuery($strDelQuery);



			//Step 2 : Now Delete property details
			// Delete from TABLE_PROPERTY_OWNER_RELATIONS
			$strDelQuery = "DELETE FROM " . TABLE_PROPERTY . " WHERE property_id='".$property_id."'";
			$this->dbObj->mySqlSafeQuery($strDelQuery);

			return true;
		}
	}
	// Function for deleting proeprties


	// Function	for updating property status
	function fun_updatePropertyStatus($property_id, $status_id, $active_id){
		if($property_id == '' || $status_id == ''){
			return false;
		} else {
			$cur_unixtime 	= time ();
			if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !=""){
				$cur_user_id 	= $_SESSION['ses_admin_id'];
			}
			else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !=""){
				$cur_user_id 	= $_SESSION['ses_modarator_id'];
			}
			else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !=""){
				$cur_user_id 	= $_SESSION['ses_user_id'];
			}
			else{
				$cur_user_id 	= "";
			}
			$strUpdateQuery = "UPDATE " . TABLE_PROPERTY . " SET status='".$status_id."', statuschanged_on='".$cur_unixtime."', updated_on='".$cur_unixtime."', updated_by='".$cur_user_id."', active='".$active_id."' WHERE property_id='".(int)$property_id."'";
			$this->dbObj->fun_db_query($strUpdateQuery);
			return true;
		}
	}


	// Function	for updating property status
	function fun_updatePropertyLastUpdate($property_id){
		if($property_id == ''){
			return false;
		} else {
			$cur_unixtime 		= time ();
			if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !="") {
				$cur_user_id 	= $_SESSION['ses_admin_id'];
			} else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !=""){
				$cur_user_id 	= $_SESSION['ses_modarator_id'];
			} else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !="") {
				$cur_user_id 	= $_SESSION['ses_user_id'];
			} else {
				$cur_user_id 	= "";
			}

			$strUpdateQuery = "UPDATE " . TABLE_PROPERTY . " SET updated_on='".$cur_unixtime."', updated_by='".$cur_user_id."' WHERE property_id='".(int)$property_id."'";
			$this->dbObj->mySqlSafeQuery($strUpdateQuery);
			return true;
		}
	}

	// Function	for updating property status
	function fun_updatePropertyChangeOver($property_id, $changeover){
		if($property_id == ''){
			return false;
		} else {
			$cur_unixtime 		= time ();
			if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !="") {
				$cur_user_id 	= $_SESSION['ses_admin_id'];
			} else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !=""){
				$cur_user_id 	= $_SESSION['ses_modarator_id'];
			} else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !="") {
				$cur_user_id 	= $_SESSION['ses_user_id'];
			} else {
				$cur_user_id 	= "";
			}

			if(($changeover_relation_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_AVAILABILITY_CHANGEOVER_RELATIONS , " WHERE property_id='".$property_id."'")) && (is_array($changeover_relation_array))){
				$strUpdateQuery = "UPDATE " . TABLE_PROPERTY_AVAILABILITY_CHANGEOVER_RELATIONS . " SET changeover='".$changeover."', updated_on='".$cur_unixtime."', updated_by='".$cur_user_id."' WHERE property_id='".(int)$property_id."'";
				$this->dbObj->mySqlSafeQuery($strUpdateQuery);
			} else { // insert
				$sqlInsert = "INSERT INTO " . TABLE_PROPERTY_AVAILABILITY_CHANGEOVER_RELATIONS . "(id, property_id, changeover, created_on, created_by, updated_on, updated_by) VALUES(null, ".(int)$property_id.", '".$changeover."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."')";
				$this->dbObj->fun_db_query($sqlInsert);
			}
			return true;
		}
	}

	// Function	for updating property status
	function fun_getPropertyChangeOver($property_id){
		if(($changeover_relation_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_AVAILABILITY_CHANGEOVER_RELATIONS , " WHERE property_id='".$property_id."'")) && (is_array($changeover_relation_array))){
			$changeover = $changeover_relation_array[0]['changeover'];
			return $changeover;
		}
	}

	function fun_delPropertyPrice($price_id){
		if(($price_relation_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_PRICES , " WHERE id='".$price_id."'")) && (is_array($price_relation_array))){
			$strDelPriceQuery = "DELETE FROM " . TABLE_PROPERTY_PRICES . " WHERE id='".$price_id."'";
			$this->dbObj->mySqlSafeQuery($strDelPriceQuery); // delete previous relations
			return true;
		}
		else{
			return false;
		}
	}

	// Function for deleting proeprty deals
	function fun_delPropertyDeals($deal_id){
		if($deal_id == ''){
			return false;
		} else {

/*
			$sqlUpdatePrice = "UPDATE " . TABLE_PROPERTY_PRICES . " SET special_offer = '0' WHERE special_offer='".(int)$deal_id."'";
			$this->dbObj->mySqlSafeQuery($sqlUpdatePrice);
*/
            $strDelPriceQuery = "DELETE FROM " . TABLE_PROPERTY_PRICES . " WHERE special_offer='".$deal_id."'";
            $this->dbObj->mySqlSafeQuery($strDelPriceQuery);

            // Delete from TABLE_PROPERTY_SPECIAL_DEALS_RELATIONS
            $strDelDealQuery = "DELETE FROM " . TABLE_PROPERTY_SPECIAL_DEALS_RELATIONS . " WHERE id='".$deal_id."'";
            $this->dbObj->mySqlSafeQuery($strDelDealQuery);
			return true;
		}
	}
	// Function for deleting proeprty deals

	
	// Function for assigning property
	function fun_assignPropertyToOwner($property_id, $user_id){
		$sqlInsert = "INSERT INTO " . TABLE_PROPERTY_OWNER_RELATIONS . "(property_id, owner_id) VALUES(".(int)$property_id.", ".(int)$user_id.")";
		$this->dbObj->fun_db_query($sqlInsert);
		return $this->dbObj->fun_db_get_affected_rows();
	}

	// This function will Return array of property updates date
	function fun_getPropertyUpdateInfoArr($property_id){
		if($property_id ==""){
			return false;
		} else {
			$propertyUpdateInfoArray 	= array();		
			$sqlDetails 				= "SELECT FROM_UNIXTIME(A.updated_on, '%m/%d/%Y') AS details_updated_on FROM " . TABLE_PROPERTY . " AS A  WHERE A.updated_on !='' AND property_id='".$property_id."'";
			$rsDetails 					= $this->dbObj->createRecordset($sqlDetails);
			$arrDetails 				= $this->dbObj->fetchAssoc($rsDetails);
			if(is_array($arrDetails) && $arrDetails[0]['details_updated_on'] != "") {
			$updateOnDetails 			= $arrDetails[0]['details_updated_on'];
			} else {
			$updateOnDetails 			= "";
			}

			$sqlAvailable 				= "SELECT FROM_UNIXTIME(A.updated_on, '%m/%d/%Y') AS availability_updated_on FROM " . TABLE_PROPERTY_AVAILABILITY_RELATIONS . " AS A  WHERE A.updated_on !='' AND property_id='".$property_id."' ORDER BY A.updated_on DESC LIMIT 0, 1";
			$rsAvailable 				= $this->dbObj->createRecordset($sqlAvailable);
			$arrAvailable 				= $this->dbObj->fetchAssoc($rsAvailable);
			if(is_array($arrAvailable) && $arrAvailable[0]['availability_updated_on'] != "") {
			$updateOnAvailable 			= $arrAvailable[0]['availability_updated_on'];

			} else {
			$updateOnAvailable 			= "";
			}

			$sqlPhoto	 				= "SELECT FROM_UNIXTIME(A.updated_on, '%m/%d/%Y') AS photo_updated_on FROM " . TABLE_PROPERTY_PHOTO_ALL . " AS A  WHERE A.updated_on !='' AND property_id='".$property_id."' ORDER BY A.updated_on DESC LIMIT 0, 1";
			$rsPhoto 					= $this->dbObj->createRecordset($sqlPhoto);
			$arrPhoto 					= $this->dbObj->fetchAssoc($rsPhoto);
			if(is_array($arrPhoto) && $arrPhoto[0]['photo_updated_on'] != "") {
			$updateOnPhoto 				= $arrPhoto[0]['photo_updated_on'];
			} else {
			$updateOnPhoto 				= "";
			}

			$sqlContact	 				= "SELECT FROM_UNIXTIME(A.updated_on, '%m/%d/%Y') AS contact_updated_on FROM " . TABLE_PROPERTY_CONTACT_NUMBERS . " AS A  WHERE A.updated_on !='' AND property_id='".$property_id."' ORDER BY A.updated_on DESC LIMIT 0, 1";
			$rsContact 					= $this->dbObj->createRecordset($sqlContact);
			$arrContact					= $this->dbObj->fetchAssoc($rsContact);
			if(is_array($arrContact) && $arrContact[0]['contact_updated_on'] != "") {
			$updateOnContact 				= $arrContact[0]['contact_updated_on'];
			} else {
			$updateOnContact 				= "";
			}

			$sqlVideo	 				= "SELECT FROM_UNIXTIME(A.updated_on, '%m/%d/%Y') AS video_updated_on FROM " . TABLE_PROPERTY_VIDEO_ALL . " AS A  WHERE A.updated_on !='' AND property_id='".$property_id."' ORDER BY A.updated_on DESC LIMIT 0, 1";
			$rsVideo 					= $this->dbObj->createRecordset($sqlVideo);
			$arrVideo					= $this->dbObj->fetchAssoc($rsVideo);
			if(is_array($arrVideo) && $arrVideo[0]['video_updated_on'] != "") {
			$updateOnVideo 				= $arrVideo[0]['video_updated_on'];
			} else {
			$updateOnVideo 				= "";
			}

			$sqlChecklist	 				= "SELECT FROM_UNIXTIME(A.updated_on, '%m/%d/%Y') AS checklist_updated_on FROM " . TABLE_PROPERTY_CHECKLIST_SETTINGS . " AS A  WHERE A.updated_on !='' AND property_id='".$property_id."' ORDER BY A.updated_on DESC LIMIT 0, 1";
			$rsChecklist 					= $this->dbObj->createRecordset($sqlChecklist);
			$arrChecklist					= $this->dbObj->fetchAssoc($rsChecklist);
			if(is_array($arrChecklist) && $arrChecklist[0]['checklist_updated_on'] != "") {
			$updateOnChecklist 				= $arrChecklist[0]['checklist_updated_on'];
			} else {
			$updateOnChecklist 				= "";
			}

			$sqlLocation	 				= "SELECT FROM_UNIXTIME(A.updated_on, '%m/%d/%Y') AS location_updated_on FROM " . TABLE_PROPERTY_LANDMARK_RELATIONS . " AS A  WHERE A.updated_on !='' AND property_id='".$property_id."' ORDER BY A.updated_on DESC LIMIT 0, 1";
			$rsLocation 					= $this->dbObj->createRecordset($sqlLocation);
			$arrLocation					= $this->dbObj->fetchAssoc($rsLocation);
			if(is_array($arrLocation) && $arrLocation[0]['location_updated_on'] != "") {
			$updateOnLocation 				= $arrLocation[0]['location_updated_on'];
			} else {
			$updateOnLocation 				= "";
			}

			$sqlSpecials	 				= "SELECT FROM_UNIXTIME(A.updated_on, '%m/%d/%Y') AS deal_updated_on FROM " . TABLE_PROPERTY_SPECIAL_DEALS_RELATIONS . " AS A  WHERE A.updated_on !='' AND property_id='".$property_id."' ORDER BY A.updated_on DESC LIMIT 0, 1";
			$rsSpecials 					= $this->dbObj->createRecordset($sqlSpecials);
			$arrSpecials					= $this->dbObj->fetchAssoc($rsSpecials);
			if(is_array($arrSpecials) && $arrSpecials[0]['deal_updated_on'] != "") {
			$updateOnSpecials 				= $arrSpecials[0]['deal_updated_on'];
			} else {
			$updateOnSpecials 				= "";
			}

			$sqlPrices	 					= "SELECT FROM_UNIXTIME(A.updated_on, '%m/%d/%Y') AS price_updated_on FROM " . TABLE_PROPERTY_PRICES . " AS A  WHERE A.updated_on !='' AND property_id='".$property_id."' ORDER BY A.updated_on DESC LIMIT 0, 1";
			$rsPrices 						= $this->dbObj->createRecordset($sqlPrices);
			$arrPrices						= $this->dbObj->fetchAssoc($rsPrices);
			if(is_array($arrPrices) && $arrPrices[0]['price_updated_on'] != "") {
			$updateOnPrices 				= $arrPrices[0]['price_updated_on'];
			} else {
			$updateOnPrices 				= "";
			}

			$propertyUpdateInfoArray['details_updated_on'] 		= $updateOnDetails;
			$propertyUpdateInfoArray['availability_updated_on'] = $updateOnAvailable;
			$propertyUpdateInfoArray['photo_updated_on'] 		= $updateOnPhoto;
			$propertyUpdateInfoArray['contact_updated_on'] 		= $updateOnContact;
			$propertyUpdateInfoArray['video_updated_on'] 		= $updateOnVideo;
			$propertyUpdateInfoArray['checklist_updated_on'] 	= $updateOnChecklist;
			$propertyUpdateInfoArray['location_updated_on'] 	= $updateOnLocation;
			$propertyUpdateInfoArray['deal_updated_on'] 		= $updateOnSpecials;
			$propertyUpdateInfoArray['price_updated_on'] 		= $updateOnPrices;
			
			return $propertyUpdateInfoArray;
		}
	}

	// Function for user saved property info array
	function fun_getPropertyUserSavedArr($user_id = ''){
		if($user_id == "") {
			return false;
		} else {
			// Step I : find the destination id and type
			if(($favourite_relation_array = $this->fun_findPropertyRelationInfo(TABLE_USER_SAVED_PROPERTIES , " WHERE user_id='".$user_id."'")) && (is_array($favourite_relation_array))){
				$property_ids		= $favourite_relation_array[0]['property_ids'];
				$sql = "SELECT 	A.property_id, A.property_name, A.property_title, A.description FROM " . TABLE_PROPERTY . " AS A  WHERE A.property_id IN ( ".$property_ids." ) ";
			}
	
			if(isset($sql) && $sql !="") {
				$sql .= " AND A.active='1'";
			// Step II : Then create query based on this
				if($parameter!=""){
					$sql .= $parameter." ORDER BY A.property_id";
				} else {
					$sql .= " ORDER BY A.property_id";		
				}
				//echo $sql;
				// Step III : Return the result		$rs = $this->dbObj->createRecordset($sql);
				if($this->dbObj->getRecordCount($rs) > 0) {
					return $arr = $this->dbObj->fetchAssoc($rs);
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
	}

	// Function for user favourite property ids array
	function fun_getPropertyUserFavouritesPropIdsArr($user_id = ''){
		if($user_id == "") {
			return false;
		} else {
			if(($favourite_relation_array = $this->fun_findPropertyRelationInfo(TABLE_USER_FAVOURITE_PROPERTIES , " WHERE user_id='".$user_id."'")) && (is_array($favourite_relation_array))){
				$arr = array();
				foreach($favourite_relation_array as $key=>$value) {
					array_push($arr, $value['property_id']);
				}
				return $arr;
			} else {
				return false;
			}
		}
	}

	// Function for user favourite property info array
	function fun_getPropertyUserFavouritesArr($user_id = ''){
		if($user_id == "") {
			return false;
		} else {
			// Step I : find the destination id and type
			if(($favourite_relation_array = $this->fun_findPropertyRelationInfo(TABLE_USER_FAVOURITE_PROPERTIES , " WHERE user_id='".$user_id."'")) && (is_array($favourite_relation_array))){
				$arr = array();
				foreach($favourite_relation_array as $key=>$value) {
					array_push($arr, $value['property_id']);
				}
				$property_ids = implode(",", $arr);
				$sql = "SELECT 	A.property_id, A.property_name, A.property_title, A.property_summary FROM " . TABLE_PROPERTY . " AS A  WHERE A.property_id IN ( ".$property_ids." ) ";
			}
	
			if(isset($sql) && $sql !="") {
				$sql .= " AND A.active='1'";
			// Step II : Then create query based on this
				if($parameter!=""){
					$sql .= $parameter." ORDER BY A.property_id";
				} else {
					$sql .= " ORDER BY A.property_id";		
				}
//				echo $sql;
			// Step III : Return the result
				$rs = $this->dbObj->createRecordset($sql);
				//return $arr = $this->dbObj->fetchAssoc($rs);	
				$arr = $this->dbObj->fetchAssoc($rs);
				//print_r($arr);
				return $arr;		
			} else {
				return false;
			}
		}
	}

	// Function for creating covering country or region with count property
	function fun_createDesLstWthPptCnt($country_id = '', $area_id = '', $region_id = ''){
		$strHTML ='';
		$strHTML .='<div class="pad-top5">';

		if($region_id != "") {

			$where 	= array();
			$sql = "SELECT * FROM " . TABLE_LOCATION . " ";
			if($region_id !=""){
				array_push($where, "region_id='".(int)fun_db_input($region_id)."' ");
			}
			array_push($where, "(location_id IN (SELECT distinct location_id FROM " . TABLE_PROPERTY . " WHERE active='1' AND status='2')) ");
			if(sizeof($where) > 0){
				$sql .= " WHERE ".join($where, " AND ");
			}
			$sql .= " ORDER BY location_name";
			$rs 	= $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);
				$strHTML .='<div class="node-links">';
				$strHTML .='<ul class="first">';
				$counter = 0;
				if(count($arr) > 3) {
					for($i = $counter; $i < ((count($arr)/3)*1); $i++) {
						$location_id 		= $arr[$i]['location_id'];
						$location_name 		= $arr[$i]['location_name'];
						$total_properties	= $this->fun_countPropertyByDestination($country_id, $area_id, $region_id, $location_id);
						$counter = $i;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($location_name))).'" onclick="removeSearch();">'.ucwords($location_name).' Rentals ('.$total_properties.') </a></li>';
					}
				} else {
					for($i = $counter; $i < count($arr); $i++) {
						$location_id 		= $arr[$i]['location_id'];
						$location_name 		= $arr[$i]['location_name'];
						$total_properties	= $this->fun_countPropertyByDestination($country_id, $area_id, $region_id, $location_id);
						$counter = $i;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($location_name))).'" onclick="removeSearch();">'.ucwords($location_name).' Rentals ('.$total_properties.') </a></li>';
					}
				}
				$strHTML .='</ul>';
				$strHTML .='</div>';
				
				if(count($arr) > 6) {
					$strHTML .='<div class="node-links">';
					$strHTML .='<ul>';
					for($j = $counter+1; $j < ((count($arr)/3)*2); $j++) {
						$location_id 		= $arr[$i]['location_id'];
						$location_name 		= $arr[$i]['location_name'];
						$total_properties	= $this->fun_countPropertyByDestination($country_id, $area_id, $region_id, $location_id);
						$counter = $j;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($location_name))).'" onclick="removeSearch();">'.ucwords($location_name).' Rentals ('.$total_properties.') </a></li>';
					}
					$strHTML .='</ul>';
					$strHTML .='</div>';
				} else if(count($arr) > 3){
					$strHTML .='<div class="node-links">';
					$strHTML .='<ul>';
					for($j = $counter+1; $j < count($arr); $j++) {
						$location_id 		= $arr[$j]['location_id'];
						$location_name 		= $arr[$j]['location_name'];
						$total_properties	= $this->fun_countPropertyByDestination($country_id, $area_id, $region_id, $location_id);
						$counter = $j;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($location_name))).'" onclick="removeSearch();">'.ucwords($location_name).' Rentals ('.$total_properties.') </a></li>';
					}
					$strHTML .='</ul>';
					$strHTML .='</div>';
				}

				if(count($arr) > 9) {
					$strHTML .='<div class="node-links">';
					$strHTML .='<ul>';
					for($k = $counter+1; $k < ((count($arr)/3)*3); $k++) {
						$location_id 		= $arr[$k]['location_id'];
						$location_name 		= $arr[$k]['location_name'];
						$total_properties	= $this->fun_countPropertyByDestination($country_id, $area_id, $region_id, $location_id);
						$counter = $k;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($location_name))).'" onclick="removeSearch();">'.ucwords($location_name).' Rentals ('.$total_properties.') </a></li>';
					}
					$strHTML .='</ul>';
					$strHTML .='</div>';
				} else if(count($arr) > 6) {
					$strHTML .='<div class="node-links">';
					$strHTML .='<ul>';
					for($k = $counter+1; $k < count($arr); $k++) {
						$location_id 		= $arr[$k]['location_id'];
						$location_name 		= $arr[$k]['location_name'];
						$total_properties	= $this->fun_countPropertyByDestination($country_id, $area_id, $region_id, $location_id);
						$counter = $k;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($location_name))).'" onclick="removeSearch();">'.ucwords($location_name).' Rentals ('.$total_properties.') </a></li>';
					}
					$strHTML .='</ul>';
					$strHTML .='</div>';
				}
			}
		} else if($area_id != "" && $region_id == "") {
			$where 	= array();
			$sql = "SELECT * FROM " . TABLE_REGION . " ";
			if($area_id !=""){
				array_push($where, "area_id='".(int)fun_db_input($area_id)."' ");
			}
			array_push($where, "((region_id IN (SELECT distinct region_id FROM " . TABLE_PROPERTY . " WHERE active='1' AND status='2')) OR (region_id IN (SELECT distinct subregion_id FROM " . TABLE_PROPERTY . " WHERE active='1' AND status='2'))) ");
			if(sizeof($where) > 0){
				$sql .= " WHERE ".join($where, " AND ");
			}
			$sql .= " ORDER BY region_name";
			$rs 	= $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);
				$strHTML .='<div class="node-links">';
				$strHTML .='<ul class="first">';
				$counter = 0;
				if(count($arr) > 3) {
					for($i = $counter; $i < ((count($arr)/3)*1); $i++) {
						$region_id 			= $arr[$i]['region_id'];
						$region_name 		= $arr[$i]['region_name'];
						$total_properties	= $this->fun_countPropertyByDestination($country_id, $area_id, $region_id);
						$counter = $i;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($region_name))).'" onclick="removeSearch();">'.ucwords($region_name).' Rentals ('.$total_properties.') </a></li>';
					}
				} else {
					for($i = $counter; $i < count($arr); $i++) {
						$region_id 			= $arr[$i]['region_id'];
						$region_name 		= $arr[$i]['region_name'];
						$total_properties	= $this->fun_countPropertyByDestination($country_id, $area_id, $region_id);
						$counter = $i;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($region_name))).'" onclick="removeSearch();">'.ucwords($region_name).' Rentals ('.$total_properties.') </a></li>';
					}
				}
				$strHTML .='</ul>';
				$strHTML .='</div>';
				
				if(count($arr) > 6) {
					$strHTML .='<div class="node-links">';
					$strHTML .='<ul>';
					for($j = $counter+1; $j < ((count($arr)/3)*2); $j++) {
						$region_id 			= $arr[$j]['region_id'];
						$region_name 		= $arr[$j]['region_name'];
						$total_properties	= $this->fun_countPropertyByDestination($country_id, $area_id, $region_id);
						$counter = $j;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($region_name))).'" onclick="removeSearch();">'.ucwords($region_name).' Rentals ('.$total_properties.') </a></li>';
					}
					$strHTML .='</ul>';
					$strHTML .='</div>';
				} else if(count($arr) > 3){
					$strHTML .='<div class="node-links">';
					$strHTML .='<ul>';
					for($j = $counter+1; $j < count($arr); $j++) {
						$region_id 			= $arr[$j]['region_id'];
						$region_name 		= $arr[$j]['region_name'];
						$total_properties	= $this->fun_countPropertyByDestination($country_id, $area_id, $region_id);
						$counter = $j;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($region_name))).'" onclick="removeSearch();">'.ucwords($region_name).' Rentals ('.$total_properties.') </a></li>';
					}
					$strHTML .='</ul>';
					$strHTML .='</div>';
				}

				if(count($arr) > 9) {
					$strHTML .='<div class="node-links">';
					$strHTML .='<ul>';
					for($k = $counter+1; $k < ((count($arr)/3)*3); $k++) {
						$region_id 			= $arr[$k]['region_id'];
						$region_name 		= $arr[$k]['region_name'];
						$total_properties	= $this->fun_countPropertyByDestination($country_id, $area_id, $region_id);
						$counter = $k;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($region_name))).'" onclick="removeSearch();">'.ucwords($region_name).' Rentals ('.$total_properties.') </a></li>';
					}
					$strHTML .='</ul>';
					$strHTML .='</div>';
				} else if(count($arr) > 6) {
					$strHTML .='<div class="node-links">';
					$strHTML .='<ul>';
					for($k = $counter+1; $k < count($arr); $k++) {
						$region_id 			= $arr[$k]['region_id'];
						$region_name 		= $arr[$k]['region_name'];
						$total_properties	= $this->fun_countPropertyByDestination($country_id, $area_id, $region_id);
						$counter = $k;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($region_name))).'" onclick="removeSearch();">'.ucwords($region_name).' Rentals ('.$total_properties.') </a></li>';
					}
					$strHTML .='</ul>';
					$strHTML .='</div>';
				}
			}
		} else if($country_id != "" && $area_id == "" && $region_id == "") {
			$where 	= array();
			$sql 	= "SELECT * FROM " . TABLE_AREA . " ";
			if($country_id !=""){
				array_push($where, "country_id='".(int)fun_db_input($country_id)."' ");
			}
			array_push($where, "area_id IN (SELECT distinct area_id FROM " . TABLE_PROPERTY . " WHERE active='1' AND status='2') ");
			if(sizeof($where) > 0){
				$sql .= " WHERE ".join($where, " AND ");
			}
			$sql .= " ORDER BY area_name";
			$rs 	= $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);
				$strHTML .='<div class="node-links">';
				$strHTML .='<ul class="first">';
				$counter = 0;
				if(count($arr) > 3) {
					for($i = $counter; $i < ((count($arr)/3)*1); $i++) {
						$area_id 			= $arr[$i]['area_id'];
						$area_name 			= $arr[$i]['area_name'];
						$total_properties	= $this->fun_countPropertyByDestination($country_id, $area_id);
						$counter = $i;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($area_name))).'" onclick="removeSearch();">'.ucwords($area_name).' Rentals ('.$total_properties.') </a></li>';
					}
				} else {
					for($i = $counter; $i < count($arr); $i++) {
						$area_id 			= $arr[$i]['area_id'];
						$area_name 			= $arr[$i]['area_name'];
						$total_properties	= $this->fun_countPropertyByDestination($country_id, $area_id);
						$counter = $i;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($area_name))).'" onclick="removeSearch();">'.ucwords($area_name).' Rentals ('.$total_properties.') </a></li>';
					}
				}
				$strHTML .='</ul>';
				$strHTML .='</div>';
				
				if(count($arr) > 6) {
					$strHTML .='<div class="node-links">';
					$strHTML .='<ul>';
					for($j = $counter+1; $j < ((count($arr)/3)*2); $j++) {
						$area_id 			= $arr[$j]['area_id'];
						$area_name 			= $arr[$j]['area_name'];
						$total_properties	= $this->fun_countPropertyByDestination($country_id, $area_id);
						$counter = $j;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($area_name))).'" onclick="removeSearch();">'.ucwords($area_name).' Rentals ('.$total_properties.') </a></li>';
					}
					$strHTML .='</ul>';
					$strHTML .='</div>';
				} else if(count($arr) > 3){
					$strHTML .='<div class="node-links">';
					$strHTML .='<ul>';
					for($j = $counter+1; $j < count($arr); $j++) {
						$area_id 			= $arr[$j]['area_id'];
						$area_name 			= $arr[$j]['area_name'];
						$total_properties	= $this->fun_countPropertyByDestination($country_id, $area_id);
						$counter = $j;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($area_name))).'" onclick="removeSearch();">'.ucwords($area_name).' Rentals ('.$total_properties.') </a></li>';
					}
					$strHTML .='</ul>';
					$strHTML .='</div>';
				}

				if(count($arr) > 9) {
					$strHTML .='<div class="node-links">';
					$strHTML .='<ul>';
					for($k = $counter+1; $k < ((count($arr)/3)*3); $k++) {
						$area_id 			= $arr[$k]['area_id'];
						$area_name 			= $arr[$k]['area_name'];
						$total_properties	= $this->fun_countPropertyByDestination($country_id, $area_id);
						$counter = $k;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($area_name))).'" onclick="removeSearch();">'.ucwords($area_name).' Rentals ('.$total_properties.') </a></li>';
					}
					$strHTML .='</ul>';
					$strHTML .='</div>';
				} else if(count($arr) > 6) {
					$strHTML .='<div class="node-links">';
					$strHTML .='<ul>';
					for($k = $counter+1; $k < count($arr); $k++) {
						$area_id 			= $arr[$k]['area_id'];
						$area_name 			= $arr[$k]['area_name'];
						$total_properties	= $this->fun_countPropertyByDestination($country_id, $area_id);
						$counter = $k;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($area_name))).'" onclick="removeSearch();">'.ucwords($area_name).' Rentals ('.$total_properties.') </a></li>';
					}
					$strHTML .='</ul>';
					$strHTML .='</div>';
				}
			}
		} else {
			$sql = "SELECT * FROM " . TABLE_COUNTRIES. " ";
			$sql .= " WHERE countries_id IN (SELECT distinct country_id FROM " . TABLE_PROPERTY . " WHERE active='1' AND status='2') ORDER BY countries_name";

			$rs = $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);
				$strHTML .='<div class="node-links">';
				$strHTML .='<ul class="first">';
				$counter = 0;
				if(count($arr) > 3) {
					for($i = $counter; $i < ((count($arr)/3)*1); $i++) {
						$countries_id 		= $arr[$i]['countries_id'];
						$countries_name 	= $arr[$i]['countries_name'];
						$total_properties	= $this->fun_countPropertyByDestination($countries_id);
						$counter = $i;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($countries_name))).'" onclick="removeSearch();">'.ucwords($countries_name).' Rentals ('.$total_properties.') </a></li>';
					}
				} else {
					for($i = $counter; $i < count($arr); $i++) {
						$countries_id 	= $arr[$i]['countries_id'];
						$countries_name = $arr[$i]['countries_name'];
						$total_properties	= $this->fun_countPropertyByDestination($countries_id);
						$counter = $i;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($countries_name))).'" onclick="removeSearch();">'.ucwords($countries_name).' Rentals ('.$total_properties.') </a></li>';
					}
				}
				$strHTML .='</ul>';
				$strHTML .='</div>';
				
				if(count($arr) > 6) {
					$strHTML .='<div class="node-links">';
					$strHTML .='<ul>';
					for($j = $counter+1; $j < ((count($arr)/3)*2); $j++) {
						$countries_id 		= $arr[$j]['countries_id'];
						$countries_name 	= $arr[$j]['countries_name'];
						$total_properties	= $this->fun_countPropertyByDestination($countries_id);
						$counter = $j;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($countries_name))).'" onclick="removeSearch();">'.ucwords($countries_name).' Rentals ('.$total_properties.') </a></li>';
					}
					$strHTML .='</ul>';
					$strHTML .='</div>';
				} else if(count($arr) > 3){
					$strHTML .='<div class="node-links">';
					$strHTML .='<ul>';
					for($j = $counter+1; $j < count($arr); $j++) {
						$countries_id 	= $arr[$j]['countries_id'];
						$countries_name = $arr[$j]['countries_name'];
						$total_properties	= $this->fun_countPropertyByDestination($countries_id);
						$counter = $j;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($countries_name))).'" onclick="removeSearch();">'.ucwords($countries_name).' Rentals ('.$total_properties.') </a></li>';
					}
					$strHTML .='</ul>';
					$strHTML .='</div>';
				}

				if(count($arr) > 9) {
					$strHTML .='<div class="node-links">';
					$strHTML .='<ul>';
					for($k = $counter+1; $k < ((count($arr)/3)*3); $k++) {
						$countries_id 		= $arr[$k]['countries_id'];
						$countries_name 	= $arr[$k]['countries_name'];
						$total_properties	= $this->fun_countPropertyByDestination($countries_id);
						$counter = $k;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($countries_name))).'" onclick="removeSearch();">'.ucwords($countries_name).' Rentals ('.$total_properties.') </a></li>';
					}
					$strHTML .='</ul>';
					$strHTML .='</div>';
				} else if(count($arr) > 6) {
					$strHTML .='<div class="node-links">';
					$strHTML .='<ul>';
					for($k = $counter+1; $k < count($arr); $k++) {
						$countries_id 	= $arr[$k]['countries_id'];
						$countries_name = $arr[$k]['countries_name'];
						$total_properties	= $this->fun_countPropertyByDestination($countries_id);
						$counter = $k;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($countries_name))).'" onclick="removeSearch();">'.ucwords($countries_name).' Rentals ('.$total_properties.') </a></li>';
					}
					$strHTML .='</ul>';
					$strHTML .='</div>';
				}
			}
		}
		$strHTML .='</div>';
		return $strHTML;
	}

	// Function for creating covering country or region with count property
	function fun_createDesLstWthPptCntHome($country_id = '', $area_id = '', $region_id = ''){
		$strHTML ='';
		$strHTML .='<div class="pad-top5">';

		if($region_id != "") {

			$where 	= array();
			$sql = "SELECT * FROM " . TABLE_LOCATION . " ";
			if($region_id !=""){
				array_push($where, "region_id='".(int)fun_db_input($region_id)."' ");
			}
			array_push($where, "(location_id IN (SELECT distinct location_id FROM " . TABLE_PROPERTY . " WHERE active='1' AND status='2')) ");
			if(sizeof($where) > 0){
				$sql .= " WHERE ".join($where, " AND ");
			}
			$sql .= " ORDER BY location_name";
			$rs 	= $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);
				$strHTML .='<div class="node-links">';
				$strHTML .='<ul class="first">';
				$counter = 0;
				if(count($arr) > 3) {
					for($i = $counter; $i < ((count($arr)/3)*1); $i++) {
						$location_id 		= $arr[$i]['location_id'];
						$location_name 		= $arr[$i]['location_name'];
						$total_properties	= $this->fun_countPropertyByDestination($country_id, $area_id, $region_id, $location_id);
						$counter = $i;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($location_name))).'" onclick="removeSearch();">'.ucwords($location_name).' Vacation Rentals ('.$total_properties.') </a></li>';
					}
				} else {
					for($i = $counter; $i < count($arr); $i++) {
						$location_id 		= $arr[$i]['location_id'];
						$location_name 		= $arr[$i]['location_name'];
						$total_properties	= $this->fun_countPropertyByDestination($country_id, $area_id, $region_id, $location_id);
						$counter = $i;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($location_name))).'" onclick="removeSearch();">'.ucwords($location_name).' Vacation Rentals ('.$total_properties.') </a></li>';
					}
				}
				$strHTML .='</ul>';
				$strHTML .='</div>';
				
				if(count($arr) > 6) {
					$strHTML .='<div class="node-links">';
					$strHTML .='<ul>';
					for($j = $counter+1; $j < ((count($arr)/3)*2); $j++) {
						$location_id 		= $arr[$i]['location_id'];
						$location_name 		= $arr[$i]['location_name'];
						$total_properties	= $this->fun_countPropertyByDestination($country_id, $area_id, $region_id, $location_id);
						$counter = $j;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($location_name))).'" onclick="removeSearch();">'.ucwords($location_name).' Vacation Rentals ('.$total_properties.') </a></li>';
					}
					$strHTML .='</ul>';
					$strHTML .='</div>';
				} else if(count($arr) > 3){
					$strHTML .='<div class="node-links">';
					$strHTML .='<ul>';
					for($j = $counter+1; $j < count($arr); $j++) {
						$location_id 		= $arr[$j]['location_id'];
						$location_name 		= $arr[$j]['location_name'];
						$total_properties	= $this->fun_countPropertyByDestination($country_id, $area_id, $region_id, $location_id);
						$counter = $j;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($location_name))).'" onclick="removeSearch();">'.ucwords($location_name).' Vacation Rentals ('.$total_properties.') </a></li>';
					}
					$strHTML .='</ul>';
					$strHTML .='</div>';
				}

				if(count($arr) > 9) {
					$strHTML .='<div class="node-links">';
					$strHTML .='<ul>';
					for($k = $counter+1; $k < ((count($arr)/3)*3); $k++) {
						$location_id 		= $arr[$k]['location_id'];
						$location_name 		= $arr[$k]['location_name'];
						$total_properties	= $this->fun_countPropertyByDestination($country_id, $area_id, $region_id, $location_id);
						$counter = $k;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($location_name))).'" onclick="removeSearch();">'.ucwords($location_name).' Vacation Rentals ('.$total_properties.') </a></li>';
					}
					$strHTML .='</ul>';
					$strHTML .='</div>';
				} else if(count($arr) > 6) {
					$strHTML .='<div class="node-links">';
					$strHTML .='<ul>';
					for($k = $counter+1; $k < count($arr); $k++) {
						$location_id 		= $arr[$k]['location_id'];
						$location_name 		= $arr[$k]['location_name'];
						$total_properties	= $this->fun_countPropertyByDestination($country_id, $area_id, $region_id, $location_id);
						$counter = $k;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($location_name))).'" onclick="removeSearch();">'.ucwords($location_name).' Vacation Rentals ('.$total_properties.') </a></li>';
					}
					$strHTML .='</ul>';
					$strHTML .='</div>';
				}
			}
		} else if($area_id != "" && $region_id == "") {
			$where 	= array();
			$sql = "SELECT * FROM " . TABLE_REGION . " ";
			if($area_id !=""){
				array_push($where, "area_id='".(int)fun_db_input($area_id)."' ");
			}
			array_push($where, "((region_id IN (SELECT distinct region_id FROM " . TABLE_PROPERTY . " WHERE active='1' AND status='2')) OR (region_id IN (SELECT distinct subregion_id FROM " . TABLE_PROPERTY . " WHERE active='1' AND status='2'))) ");
			if(sizeof($where) > 0){
				$sql .= " WHERE ".join($where, " AND ");
			}
			$sql .= " ORDER BY region_name";
			$rs 	= $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);
				$strHTML .='<div class="node-links">';
				$strHTML .='<ul class="first">';
				$counter = 0;
				if(count($arr) > 3) {
					for($i = $counter; $i < ((count($arr)/3)*1); $i++) {
						$region_id 			= $arr[$i]['region_id'];
						$region_name 		= $arr[$i]['region_name'];
						$total_properties	= $this->fun_countPropertyByDestination($country_id, $area_id, $region_id);
						$counter = $i;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($region_name))).'" onclick="removeSearch();">'.ucwords($region_name).' Vacation Rentals ('.$total_properties.') </a></li>';
					}
				} else {
					for($i = $counter; $i < count($arr); $i++) {
						$region_id 			= $arr[$i]['region_id'];
						$region_name 		= $arr[$i]['region_name'];
						$total_properties	= $this->fun_countPropertyByDestination($country_id, $area_id, $region_id);
						$counter = $i;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($region_name))).'" onclick="removeSearch();">'.ucwords($region_name).' Vacation Rentals ('.$total_properties.') </a></li>';
					}
				}
				$strHTML .='</ul>';
				$strHTML .='</div>';
				
				if(count($arr) > 6) {
					$strHTML .='<div class="node-links">';
					$strHTML .='<ul>';
					for($j = $counter+1; $j < ((count($arr)/3)*2); $j++) {
						$region_id 			= $arr[$j]['region_id'];
						$region_name 		= $arr[$j]['region_name'];
						$total_properties	= $this->fun_countPropertyByDestination($country_id, $area_id, $region_id);
						$counter = $j;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($region_name))).'" onclick="removeSearch();">'.ucwords($region_name).' Vacation Rentals ('.$total_properties.') </a></li>';
					}
					$strHTML .='</ul>';
					$strHTML .='</div>';
				} else if(count($arr) > 3){
					$strHTML .='<div class="node-links">';
					$strHTML .='<ul>';
					for($j = $counter+1; $j < count($arr); $j++) {
						$region_id 			= $arr[$j]['region_id'];
						$region_name 		= $arr[$j]['region_name'];
						$total_properties	= $this->fun_countPropertyByDestination($country_id, $area_id, $region_id);
						$counter = $j;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($region_name))).'" onclick="removeSearch();">'.ucwords($region_name).' Vacation Rentals ('.$total_properties.') </a></li>';
					}
					$strHTML .='</ul>';
					$strHTML .='</div>';
				}

				if(count($arr) > 9) {
					$strHTML .='<div class="node-links">';
					$strHTML .='<ul>';
					for($k = $counter+1; $k < ((count($arr)/3)*3); $k++) {
						$region_id 			= $arr[$k]['region_id'];
						$region_name 		= $arr[$k]['region_name'];
						$total_properties	= $this->fun_countPropertyByDestination($country_id, $area_id, $region_id);
						$counter = $k;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($region_name))).'" onclick="removeSearch();">'.ucwords($region_name).' Vacation Rentals ('.$total_properties.') </a></li>';
					}
					$strHTML .='</ul>';
					$strHTML .='</div>';
				} else if(count($arr) > 6) {
					$strHTML .='<div class="node-links">';
					$strHTML .='<ul>';
					for($k = $counter+1; $k < count($arr); $k++) {
						$region_id 			= $arr[$k]['region_id'];
						$region_name 		= $arr[$k]['region_name'];
						$total_properties	= $this->fun_countPropertyByDestination($country_id, $area_id, $region_id);
						$counter = $k;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($region_name))).'" onclick="removeSearch();">'.ucwords($region_name).' Vacation Rentals ('.$total_properties.') </a></li>';
					}
					$strHTML .='</ul>';
					$strHTML .='</div>';
				}
			}
		} else if($country_id != "" && $area_id == "" && $region_id == "") {
			$where 	= array();
			$sql 	= "SELECT * FROM " . TABLE_AREA . " ";
			if($country_id !=""){
				array_push($where, "country_id='".(int)fun_db_input($country_id)."' ");
			}
			array_push($where, "area_id IN (SELECT distinct area_id FROM " . TABLE_PROPERTY . " WHERE active='1' AND status='2') ");
			if(sizeof($where) > 0){
				$sql .= " WHERE ".join($where, " AND ");
			}
			$sql .= " ORDER BY area_name";
			$rs 	= $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);
				$strHTML .='<div class="node-links">';
				$strHTML .='<ul class="first">';
				$counter = 0;
				if(count($arr) > 3) {
					for($i = $counter; $i < ((count($arr)/3)*1); $i++) {
						$area_id 			= $arr[$i]['area_id'];
						$area_name 			= $arr[$i]['area_name'];
						$total_properties	= $this->fun_countPropertyByDestination($country_id, $area_id);
						$counter = $i;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($area_name))).'" onclick="removeSearch();">'.ucwords($area_name).' Vacation Rentals ('.$total_properties.') </a></li>';
					}
				} else {
					for($i = $counter; $i < count($arr); $i++) {
						$area_id 			= $arr[$i]['area_id'];
						$area_name 			= $arr[$i]['area_name'];
						$total_properties	= $this->fun_countPropertyByDestination($country_id, $area_id);
						$counter = $i;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($area_name))).'" onclick="removeSearch();">'.ucwords($area_name).' Vacation Rentals ('.$total_properties.') </a></li>';
					}
				}
				$strHTML .='</ul>';
				$strHTML .='</div>';
				
				if(count($arr) > 6) {
					$strHTML .='<div class="node-links">';
					$strHTML .='<ul>';
					for($j = $counter+1; $j < ((count($arr)/3)*2); $j++) {
						$area_id 			= $arr[$j]['area_id'];
						$area_name 			= $arr[$j]['area_name'];
						$total_properties	= $this->fun_countPropertyByDestination($country_id, $area_id);
						$counter = $j;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($area_name))).'" onclick="removeSearch();">'.ucwords($area_name).' Vacation Rentals ('.$total_properties.') </a></li>';
					}
					$strHTML .='</ul>';
					$strHTML .='</div>';
				} else if(count($arr) > 3){
					$strHTML .='<div class="node-links">';
					$strHTML .='<ul>';
					for($j = $counter+1; $j < count($arr); $j++) {
						$area_id 			= $arr[$j]['area_id'];
						$area_name 			= $arr[$j]['area_name'];
						$total_properties	= $this->fun_countPropertyByDestination($country_id, $area_id);
						$counter = $j;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($area_name))).'" onclick="removeSearch();">'.ucwords($area_name).' Vacation Rentals ('.$total_properties.') </a></li>';
					}
					$strHTML .='</ul>';
					$strHTML .='</div>';
				}

				if(count($arr) > 9) {
					$strHTML .='<div class="node-links">';
					$strHTML .='<ul>';
					for($k = $counter+1; $k < ((count($arr)/3)*3); $k++) {
						$area_id 			= $arr[$k]['area_id'];
						$area_name 			= $arr[$k]['area_name'];
						$total_properties	= $this->fun_countPropertyByDestination($country_id, $area_id);
						$counter = $k;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($area_name))).'" onclick="removeSearch();">'.ucwords($area_name).' Vacation Rentals ('.$total_properties.') </a></li>';
					}
					$strHTML .='</ul>';
					$strHTML .='</div>';
				} else if(count($arr) > 6) {
					$strHTML .='<div class="node-links">';
					$strHTML .='<ul>';
					for($k = $counter+1; $k < count($arr); $k++) {
						$area_id 			= $arr[$k]['area_id'];
						$area_name 			= $arr[$k]['area_name'];
						$total_properties	= $this->fun_countPropertyByDestination($country_id, $area_id);
						$counter = $k;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($area_name))).'" onclick="removeSearch();">'.ucwords($area_name).' Vacation Rentals ('.$total_properties.') </a></li>';
					}
					$strHTML .='</ul>';
					$strHTML .='</div>';
				}
			}
		} else {
			$sql = "SELECT * FROM " . TABLE_COUNTRIES. " ";
			$sql .= " WHERE countries_id IN (SELECT distinct country_id FROM " . TABLE_PROPERTY . " WHERE active='1' AND status='2') ORDER BY countries_name";

			$rs = $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);
				$strHTML .='<div class="node-links">';
				$strHTML .='<ul class="first">';
				$counter = 0;
				if(count($arr) > 3) {
					for($i = $counter; $i < ((count($arr)/3)*1); $i++) {
						$countries_id 		= $arr[$i]['countries_id'];
						$countries_name 	= $arr[$i]['countries_name'];
						$total_properties	= $this->fun_countPropertyByDestination($countries_id);
						$counter = $i;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($countries_name))).'" onclick="removeSearch();">'.ucwords($countries_name).' Vacation Rentals ('.$total_properties.') </a></li>';
					}
				} else {
					for($i = $counter; $i < count($arr); $i++) {
						$countries_id 	= $arr[$i]['countries_id'];
						$countries_name = $arr[$i]['countries_name'];
						$total_properties	= $this->fun_countPropertyByDestination($countries_id);
						$counter = $i;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($countries_name))).'" onclick="removeSearch();">'.ucwords($countries_name).' Vacation Rentals ('.$total_properties.') </a></li>';
					}
				}
				$strHTML .='</ul>';
				$strHTML .='</div>';
				
				if(count($arr) > 6) {
					$strHTML .='<div class="node-links">';
					$strHTML .='<ul>';
					for($j = $counter+1; $j < ((count($arr)/3)*2); $j++) {
						$countries_id 		= $arr[$j]['countries_id'];
						$countries_name 	= $arr[$j]['countries_name'];
						$total_properties	= $this->fun_countPropertyByDestination($countries_id);
						$counter = $j;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($countries_name))).'" onclick="removeSearch();">'.ucwords($countries_name).' Vacation Rentals ('.$total_properties.') </a></li>';
					}
					$strHTML .='</ul>';
					$strHTML .='</div>';
				} else if(count($arr) > 3){
					$strHTML .='<div class="node-links">';
					$strHTML .='<ul>';
					for($j = $counter+1; $j < count($arr); $j++) {
						$countries_id 	= $arr[$j]['countries_id'];
						$countries_name = $arr[$j]['countries_name'];
						$total_properties	= $this->fun_countPropertyByDestination($countries_id);
						$counter = $j;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($countries_name))).'" onclick="removeSearch();">'.ucwords($countries_name).' Vacation Rentals ('.$total_properties.') </a></li>';
					}
					$strHTML .='</ul>';
					$strHTML .='</div>';
				}

				if(count($arr) > 9) {
					$strHTML .='<div class="node-links">';
					$strHTML .='<ul>';
					for($k = $counter+1; $k < ((count($arr)/3)*3); $k++) {
						$countries_id 		= $arr[$k]['countries_id'];
						$countries_name 	= $arr[$k]['countries_name'];
						$total_properties	= $this->fun_countPropertyByDestination($countries_id);
						$counter = $k;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($countries_name))).'" onclick="removeSearch();">'.ucwords($countries_name).' Vacation Rentals ('.$total_properties.') </a></li>';
					}
					$strHTML .='</ul>';
					$strHTML .='</div>';
				} else if(count($arr) > 6) {
					$strHTML .='<div class="node-links">';
					$strHTML .='<ul>';
					for($k = $counter+1; $k < count($arr); $k++) {
						$countries_id 	= $arr[$k]['countries_id'];
						$countries_name = $arr[$k]['countries_name'];
						$total_properties	= $this->fun_countPropertyByDestination($countries_id);
						$counter = $k;
						$strHTML .='<li><a href="'.SITE_URL.'vacation-rentals/in.'.str_replace("/", "_", str_replace(" ", "-", strtolower($countries_name))).'" onclick="removeSearch();">'.ucwords($countries_name).' Vacation Rentals ('.$total_properties.') </a></li>';
					}
					$strHTML .='</ul>';
					$strHTML .='</div>';
				}
			}
		}
		$strHTML .='</div>';
		return $strHTML;
	}

	// Function for count properties by destination
	function fun_countPropertyByDestination($country_id = '', $area_id = '', $region_id = '', $location_id = ''){
		$sql = "SELECT count(*) AS total_properties FROM " . TABLE_PROPERTY . " WHERE active='1' AND status='2' ";
		if($country_id != ""){
			$sql .= " AND country_id='".$country_id."' ";
		}
		if($area_id != ""){
			$sql .= " AND area_id='".$area_id."' ";
		}
		if($region_id != ""){
			$sql .= " AND region_id='".$region_id."' ";
		}
		if($location_id != ""){
			$sql .= " AND location_id='".$location_id."' ";
		}

		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			$arr = $this->dbObj->fetchAssoc($rs);
			$total_properties = $arr[0]['total_properties'];
		} else {
			$total_properties = "0";
		}
		return $total_properties;
	}

	// Function for count properties by destination
	function fun_countPropertyByDestinations($country_ids = '', $area_ids = '', $region_ids = '', $location_ids = ''){
		$sql = "SELECT count(*) AS total_properties FROM " . TABLE_PROPERTY . " WHERE active='1' AND status='2' ";
		if($country_ids != ""){
			$sql .= " AND country_id IN (".$country_ids.") ";
		}
		if($area_ids != ""){
			$sql .= " AND area_id IN (".$area_ids.") ";
		}
		if($region_ids != ""){
			$sql .= " AND region_id IN (".$region_ids.") ";
		}
		if($location_ids != ""){
			$sql .= " AND location_id IN (".$location_ids.") ";
		}
		//echo $sql;

		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			$arr = $this->dbObj->fetchAssoc($rs);
			$total_properties = $arr[0]['total_properties'];
		} else {
			$total_properties = "0";
		}
		return $total_properties;
	}

	// Function for refine property search
	function fun_getPropertyRefineSearchArr($txtcountryids = '', $txtareaids = '', $txtregionids = '', $txtlocationids = '',  $txtFromUnixTime = '', $txtToUnixTime = '', $txtpropertytypeids = '', $txtneedsleep = '', $txtonlybed = '', $txttotalbed = '', $txtholidaytypeids = '', $txtkitchenlinenids = '', $txtoutsideids = '', $txtactivitynearbyids = '', $txtheatingcoolingids = '', $txtenterainmentids = '', $txtlocationviewids = '', $txtserviceids = '', $txtgeneralids = '', $featured ='', $latedeal ='', $parameter = ''){
		$property_ids = $this->fun_getPropertyIdsByRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids,  $txtFromUnixTime, $txtToUnixTime, $txtpropertytypeids, $txtneedsleep, $txtonlybed, $txttotalbed, $txtholidaytypeids, $txtkitchenlinenids, $txtoutsideids, $txtactivitynearbyids, $txtheatingcoolingids, $txtenterainmentids, $txtlocationviewids, $txtserviceids, $txtgeneralids, $featured, $latedeal, $parameter);
		if(isset($property_ids) && $property_ids !="") {
			$sql = "SELECT distinct A.property_id, 
					A.property_name, 
					A.property_name, 
					A.property_title, 
					A.property_summary,
					A.country_id, 
					A.area_id, 
					A.region_id, 
					A.subregion_id, 
					A.location_id, 
					A.property_summary,
					D.pt_title AS property_type, 
					E.catering_name 
					FROM " . TABLE_PROPERTY . " AS A 
					LEFT JOIN " . TABLE_PROPERTY_PRICES . " AS B ON B.property_id = A.property_id
					LEFT JOIN " . TABLE_PROPERTY_REVIEWS_RELATIONS . " AS C ON C.property_id = A.property_id
					LEFT JOIN " . TABLE_PROPERTY_TYPE . " AS D ON D.pt_id = A.property_type
					LEFT JOIN " . TABLE_PROPERTY_CATERING . " AS E ON E.catering_id = A.catering_type
					WHERE A.active='1' AND A.property_id IN (".$property_ids.") AND  A.property_pid='0'";
			if($parameter != ""){
				$sql .= $parameter;
			} else {
				$sql .= " ORDER BY A.updated_on DESC";		
			}
			//echo $sql;
			return $rs = $this->dbObj->createRecordset($sql);
		} else {
			return false;
		}
	}

	function fun_getPropertyIdsByRefineByCriteria($txtcountryids = '', $txtareaids = '', $txtregionids = '', $txtlocationids = '',  $txtFromUnixTime = '', $txtToUnixTime = '', $txtpropertytypeids = '', $txtneedsleep = '', $txtonlybed = '', $txttotalbed = '', $txtholidaytypeids = '', $txtkitchenlinenids = '', $txtoutsideids = '', $txtactivitynearbyids = '', $txtheatingcoolingids = '', $txtenterainmentids = '', $txtlocationviewids = '', $txtserviceids = '', $txtgeneralids = '', $featured ='', $latedeal ='', $parameter = ''){
		$propertyIdArr =  array();
		if((isset($txtcountryids) && $txtcountryids !="") && (!isset($txtareaids) || $txtareaids =="") && (!isset($txtregionids) || $txtregionids =="") && (!isset($txtlocationids) || $txtlocationids =="")) {
			$propertyIdByCountryArr = array();
			if(substr($txtcountryids, 0,1) == ",") {
				$txtcountryids = substr($txtcountryids, 1,strlen($txtcountryids));
			}
			if(substr($txtcountryids, strlen($txtcountryids)-1, strlen($txtcountryids)) == ",") {
				$txtcountryids = substr($txtcountryids, 0,strlen($txtcountryids)-1);
			}
			//Step I: select areas of that country
			if(($area_relation_array = $this->fun_findPropertyRelationInfo(TABLE_AREA , " WHERE country_id IN (".$txtcountryids.")")) && (is_array($area_relation_array))){
				$areaidsByCountryArr		= array();
				for($i = 0; $i < count($area_relation_array); $i++) {
					array_push($areaidsByCountryArr, "'".$area_relation_array[$i]['area_id']."'");
				}
				$areaids = implode(",", array_unique($areaidsByCountryArr));
				
				//Step II: select regions of that area
				if(($region_relation_array = $this->fun_findPropertyRelationInfo(TABLE_REGION , " WHERE area_id IN (".$areaids.")")) && (is_array($region_relation_array))){
					$regionidsByCountryArr		= array();
					for($j = 0; $j < count($region_relation_array); $j++) {
						array_push($regionidsByCountryArr, "'".$region_relation_array[$j]['region_id']."'");
					}
					$regionids = implode(",", array_unique($regionidsByCountryArr));

					//Step III: select locations of that region
					if(($regionids != "") && ($loc_relation_array = $this->fun_findPropertyRelationInfo(TABLE_LOCATION , " WHERE region_id IN (".$regionids.")")) && (is_array($loc_relation_array))){
						$locationidsArr		= array();
						for($j = 0; $j < count($loc_relation_array); $j++) {
							array_push($locationidsArr, "'".$loc_relation_array[$j]['location_id']."'");
						}
						$locationids = implode(",", array_unique($locationidsArr));
					}
				}
			}

			if(isset($locationids) && $locationids != "") {
				//Step IV: select properties by locationids
				$sqlCountryProp		= "SELECT DISTINCT A.property_id AS property_id FROM " . TABLE_PROPERTY . " AS A  WHERE A.location_id IN (".$locationids.") OR A.region_id IN (".$regionids.") OR A.area_id IN (".$areaids.") OR A.country_id IN (".$txtcountryids.") ";
				$rsCountryProp 		= $this->dbObj->createRecordset($sqlCountryProp);
				if($this->dbObj->getRecordCount($rsCountryProp) > 0) {
					$arrCountryProp = $this->dbObj->fetchAssoc($rsCountryProp);
					for($i = 0; $i < count($arrCountryProp); $i++) {
						//Step IV: Push it to array
						array_push($propertyIdByCountryArr, "'".$arrCountryProp[$i]['property_id']."'");
					}
				}
			} else if(isset($regionids) && $regionids != "") {
				//Step IV: select properties by locationids
				$sqlCountryProp		= "SELECT DISTINCT A.property_id AS property_id FROM " . TABLE_PROPERTY . " AS A  WHERE A.region_id IN (".$regionids.") OR A.area_id IN (".$areaids.") OR A.country_id IN (".$txtcountryids.") ";
				$rsCountryProp 		= $this->dbObj->createRecordset($sqlCountryProp);
				if($this->dbObj->getRecordCount($rsCountryProp) > 0) {
					$arrCountryProp = $this->dbObj->fetchAssoc($rsCountryProp);
					for($i = 0; $i < count($arrCountryProp); $i++) {
						//Step IV: Push it to array
						array_push($propertyIdByCountryArr, "'".$arrCountryProp[$i]['property_id']."'");
					}
				}
			} else if(isset($areaids) && $areaids != "") {
				//Step IV: select properties by locationids
				$sqlCountryProp		= "SELECT DISTINCT A.property_id AS property_id FROM " . TABLE_PROPERTY . " AS A  WHERE A.area_id IN (".$areaids.") OR A.country_id IN (".$txtcountryids.") ";
				$rsCountryProp 		= $this->dbObj->createRecordset($sqlCountryProp);
				if($this->dbObj->getRecordCount($rsCountryProp) > 0) {
					$arrCountryProp = $this->dbObj->fetchAssoc($rsCountryProp);
					for($i = 0; $i < count($arrCountryProp); $i++) {
						//Step IV: Push it to array
						array_push($propertyIdByCountryArr, "'".$arrCountryProp[$i]['property_id']."'");
					}
				}
			} else if(isset($txtcountryids) && $txtcountryids != "") {
				//Step IV: select properties by locationids
				$sqlCountryProp		= "SELECT DISTINCT A.property_id AS property_id FROM " . TABLE_PROPERTY . " AS A  WHERE A.country_id IN (".$txtcountryids.") ";
				$rsCountryProp 		= $this->dbObj->createRecordset($sqlCountryProp);
				if($this->dbObj->getRecordCount($rsCountryProp) > 0) {
					$arrCountryProp = $this->dbObj->fetchAssoc($rsCountryProp);
					for($i = 0; $i < count($arrCountryProp); $i++) {
						//Step IV: Push it to array
						array_push($propertyIdByCountryArr, "'".$arrCountryProp[$i]['property_id']."'");
					}
				}
			}
		}

		if((isset($txtareaids) && $txtareaids !="") && (!isset($txtregionids) || $txtregionids =="") && (!isset($txtlocationids) || $txtlocationids =="")) {
			$propertyIdByAreaArr = array();
			if(substr($txtareaids, 0,1) == ",") {
				$txtareaids = substr($txtareaids, 1,strlen($txtareaids));
			}
			if(substr($txtareaids, strlen($txtareaids)-1, strlen($txtareaids)) == ",") {
				$txtareaids = substr($txtareaids, 0,strlen($txtareaids)-1);
			}
			//Step II: select regions of that area
			if(($region_relation_array = $this->fun_findPropertyRelationInfo(TABLE_REGION , " WHERE area_id IN (".$txtareaids.")")) && (is_array($region_relation_array))){
				$regionidsByAreaArr		= array();
				for($j = 0; $j < count($region_relation_array); $j++) {
					array_push($regionidsByAreaArr, "'".$region_relation_array[$j]['region_id']."'");
				}
				$regionids = implode(",", array_unique($regionidsByAreaArr));
				//Step III: select locations of that region
				if(($regionids != "") && ($loc_relation_array = $this->fun_findPropertyRelationInfo(TABLE_LOCATION , " WHERE region_id IN (".$regionids.")")) && (is_array($loc_relation_array))){
					$locationidsArr		= array();
					for($j = 0; $j < count($loc_relation_array); $j++) {
						array_push($locationidsArr, "'".$loc_relation_array[$j]['location_id']."'");
					}
					$locationids = implode(",", array_unique($locationidsArr));
				}
			}

			if(isset($locationids) && $locationids != "") {
				//Step IV: select properties by locationids
				$sqlAreaProp		= "SELECT DISTINCT A.property_id AS property_id FROM " . TABLE_PROPERTY . " AS A  WHERE A.location_id IN (".$locationids.") OR A.region_id IN (".$regionids.") OR A.area_id IN (".$txtareaids.") ";
				$rsAreaProp 		= $this->dbObj->createRecordset($sqlAreaProp);
				if($this->dbObj->getRecordCount($rsAreaProp) > 0) {
					$arrAreaProp = $this->dbObj->fetchAssoc($rsAreaProp);
					for($i = 0; $i < count($arrAreaProp); $i++) {
						//Step IV: Push it to array
						array_push($propertyIdByAreaArr, "'".$arrAreaProp[$i]['property_id']."'");
					}
				}
			} else if(isset($regionids) && $regionids != "") {
				//Step IV: select properties by locationids
				$sqlAreaProp		= "SELECT DISTINCT A.property_id AS property_id FROM " . TABLE_PROPERTY . " AS A  WHERE A.region_id IN (".$regionids.") OR A.area_id IN (".$txtareaids.") ";
				$rsAreaProp 		= $this->dbObj->createRecordset($sqlAreaProp);
				if($this->dbObj->getRecordCount($rsAreaProp) > 0) {
					$arrAreaProp = $this->dbObj->fetchAssoc($rsAreaProp);
					for($i = 0; $i < count($arrAreaProp); $i++) {
						//Step IV: Push it to array
						array_push($propertyIdByAreaArr, "'".$arrAreaProp[$i]['property_id']."'");
					}
				}
			} else if(isset($txtareaids) && $txtareaids != "") {
				//Step IV: select properties by locationids
				$sqlAreaProp		= "SELECT DISTINCT A.property_id AS property_id FROM " . TABLE_PROPERTY . " AS A  WHERE A.area_id IN (".$txtareaids.") ";
				$rsAreaProp 		= $this->dbObj->createRecordset($sqlAreaProp);
				if($this->dbObj->getRecordCount($rsAreaProp) > 0) {
					$arrAreaProp = $this->dbObj->fetchAssoc($rsAreaProp);
					for($i = 0; $i < count($arrAreaProp); $i++) {
						//Step IV: Push it to array
						array_push($propertyIdByAreaArr, "'".$arrAreaProp[$i]['property_id']."'");
					}
				}
			}
		}

		if((isset($txtregionids) && $txtregionids !="") && (!isset($txtlocationids) || $txtlocationids =="")) {
			$propertyIdByRegionArr = array();
			if(substr($txtregionids, 0,1) == ",") {
				$txtregionids = substr($txtregionids, 1,strlen($txtregionids));
			}
			if(substr($txtregionids, strlen($txtregionids)-1, strlen($txtregionids)) == ",") {
				$txtregionids = substr($txtregionids, 0,strlen($txtregionids)-1);
			}
			//Step III: select locations of that region
            if(($txtregionids != "")) {
                $locationidsArr		= array();
                $regionidsArr		= array();
                if(($subregion_relation_array = $this->fun_findPropertyRelationInfo(TABLE_REGION , " WHERE pregion_id IN (".$txtregionids.")")) && (is_array($subregion_relation_array))){
                    for($i = 0; $i < count($subregion_relation_array); $i++) {
                        array_push($regionidsArr, $subregion_relation_array[$i]['region_id']);
                    }
                }
                $regionidsArrTemp = explode(",", $txtregionids);
                for($k = 0; $k < count($regionidsArrTemp); $k++) {
                    array_push($regionidsArr, $regionidsArrTemp[$k]);
                }
                $txtregionids = implode(",", array_unique($regionidsArr));
                if(($loc_relation_array = $this->fun_findPropertyRelationInfo(TABLE_LOCATION , " WHERE region_id IN (".$txtregionids.")")) && (is_array($loc_relation_array))){
                    for($j = 0; $j < count($loc_relation_array); $j++) {
                        array_push($locationidsArr, "'".$loc_relation_array[$j]['location_id']."'");
                    }
                    $locationids = implode(",", array_unique($locationidsArr));
                }
            }

			if(isset($locationids) && $locationids != "") {
				//Step IV: select properties by locationids
				$sqlRegionProp		= "SELECT DISTINCT A.property_id AS property_id FROM " . TABLE_PROPERTY . " AS A  WHERE A.location_id IN (".$locationids.") OR A.region_id IN (".$txtregionids.") ";
				$rsRegionProp 		= $this->dbObj->createRecordset($sqlRegionProp);
				if($this->dbObj->getRecordCount($rsRegionProp) > 0) {
					$arrRegionProp = $this->dbObj->fetchAssoc($rsRegionProp);
					for($i = 0; $i < count($arrRegionProp); $i++) {
						//Step IV: Push it to array
						array_push($propertyIdByRegionArr, "'".$arrRegionProp[$i]['property_id']."'");
					}
				}
			} else if(isset($txtregionids) && $txtregionids != "") {
				//Step IV: select properties by locationids
				$sqlRegionProp		= "SELECT DISTINCT A.property_id AS property_id FROM " . TABLE_PROPERTY . " AS A  WHERE A.region_id IN (".$txtregionids.") ";
				$rsRegionProp 		= $this->dbObj->createRecordset($sqlRegionProp);
				if($this->dbObj->getRecordCount($rsRegionProp) > 0) {
					$arrRegionProp = $this->dbObj->fetchAssoc($rsRegionProp);
					for($i = 0; $i < count($arrRegionProp); $i++) {
						//Step IV: Push it to array
						array_push($propertyIdByRegionArr, "'".$arrRegionProp[$i]['property_id']."'");
					}
				}
			}
		}

		if((isset($txtlocationids) && $txtlocationids !="")) {
			$propertyIdByLocationArr = array();
			if(substr($txtlocationids, 0,1) == ",") {
				$txtlocationids = substr($txtlocationids, 1,strlen($txtlocationids));
			}
			if(substr($txtlocationids, strlen($txtlocationids)-1, strlen($txtlocationids)) == ",") {
				$txtlocationids = substr($txtlocationids, 0,strlen($txtlocationids)-1);
			}

			$sqlLocProp		= "SELECT A.property_id AS property_id FROM " . TABLE_PROPERTY . " AS A  WHERE A.location_id IN (".$txtlocationids.") ";
			$rsLocProp 		= $this->dbObj->createRecordset($sqlLocProp);
			if($this->dbObj->getRecordCount($rsLocProp) > 0) {
				$arrLocProp = $this->dbObj->fetchAssoc($rsLocProp);
				for($i = 0; $i < count($arrLocProp); $i++) {
					array_push($propertyIdByLocationArr, "'".$arrLocProp[$i]['property_id']."'");
				}
			}
		}

		if((isset($txtFromUnixTime) && $txtFromUnixTime !="") && (isset($txtToUnixTime) && $txtToUnixTime !="")) {
			$propertyIdByAvailableArr = array();
			$startDate 		= date('Y-m-d', $txtFromUnixTime);
			$endDate 		= date('Y-m-d', $txtToUnixTime);
			$sqlAvailProp	= "SELECT 
				A.property_id AS property_id 
				FROM " . TABLE_PROPERTY_AVAILABILITY_RELATIONS . " AS A 
                WHERE A.status='2' AND ((A.startdate BETWEEN '" . $startDate . "' AND '" . $endDate . "') OR (A.enddate BETWEEN '" . $startDate . "' AND '" . $endDate . "') OR (A.startdate >='" . $startDate . "' AND A.enddate <='" . $endDate . "') OR (A.startdate <'" . $startDate . "' AND A.startdate <'" . $endDate . "' AND A.enddate >'" . $startDate . "'AND A.enddate >'" . $endDate . "')) 
                GROUP BY A.property_id";
			$rsAvailProp 	= $this->dbObj->createRecordset($sqlAvailProp);
			if($this->dbObj->getRecordCount($rsAvailProp) > 0) {
				$arrAvailProp = $this->dbObj->fetchAssoc($rsAvailProp);
				for($i = 0; $i < count($arrAvailProp); $i++) {
					array_push($propertyIdByAvailableArr, "'".$arrAvailProp[$i]['property_id']."'");
				}
				$propertyIdByAvailableArr = array_keys(array_flip($propertyIdByAvailableArr));;
			}
		}

		if(isset($txtpropertytypeids) && $txtpropertytypeids !="") {
			$propertyIdByTypeArr = array();
			$propertytypeidArr = explode(",", $txtpropertytypeids);
			$propertytype_ids = "";
			for($i = 0; $i < count($propertytypeidArr); $i++) {
				$propertytype_ids .= ",'".$propertytypeidArr[$i]."'";
			}
			if(substr($propertytype_ids, 0, 1) == ",") {
				$propertytype_ids = substr($propertytype_ids, 1, strlen($propertytype_ids));
			}
			if($propertytype_ids != "") {
				$sql = "SELECT A.property_id AS property_id 
				FROM  " . TABLE_PROPERTY . " AS A
				WHERE A.active='1' AND property_type IN (".$propertytype_ids.")";
				$rs = $this->dbObj->createRecordset($sql);
				if($this->dbObj->getRecordCount($rs) > 0){
					$arr = $this->dbObj->fetchAssoc($rs);
				}
				for($j = 0; $j < count($arr); $j++) {
					array_push($propertyIdByTypeArr, "'".$arr[$j]['property_id']."'");
				}
			}
		}

		if(isset($featured) && $featured =="yes") {
			$propertyIdByFeaturedArr = array();
            $currentdate = date('Y-m-d');
            $sql	= "SELECT A.property_id FROM " . TABLE_PROPERTY_HOT_RELATIONS . " AS A WHERE A.status ='2' AND (A.start_date < '".$currentdate."' OR  A.start_date = '".$currentdate."') AND (DATE_ADD(A.start_date, INTERVAL A.total_weeks WEEK) > '".$currentdate."')";
            $rs 	= $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);
			}
			for($j = 0; $j < count($arr); $j++) {
				array_push($propertyIdByFeaturedArr, "'".$arr[$j]['property_id']."'");
			}
		}

		if(isset($latedeal) && $latedeal =="1") {
            $propertyIdByLatedealArr = array();
            $sql = "SELECT A.property_id As property_id
                FROM ". TABLE_PROPERTY_SPECIAL_DEALS_RELATIONS ." AS A
                INNER JOIN " . TABLE_PROPERTY . " AS B ON A.property_id = B.property_id
                WHERE A.special_deal_type='1' AND A.status = '2' AND B.active = '1' GROUP BY A.property_id";
            $rs = $this->dbObj->createRecordset($sql);
            if($this->dbObj->getRecordCount($rs) > 0){
                $arr = $this->dbObj->fetchAssoc($rs);
                for($j = 0; $j < count($arr); $j++) {
                    array_push($propertyIdByLatedealArr, "'".$arr[$j]['property_id']."'");
                }
            }
        }

		if(isset($txtneedsleep) && $txtneedsleep !="") {
			$propertyIdByNeedSleepArr = array();
			$sqlNeedBedProp		= "SELECT A.property_id AS property_id FROM " . TABLE_PROPERTY_BEDROOM_RELATIONS . " AS A  WHERE A.scomfort_beds >= ".$txtneedsleep." ";
			$rsNeedBedProp 		= $this->dbObj->createRecordset($sqlNeedBedProp);
			if($this->dbObj->getRecordCount($rsNeedBedProp) > 0) {
				$arrNeedBedProp = $this->dbObj->fetchAssoc($rsNeedBedProp);
				for($i = 0; $i < count($arrNeedBedProp); $i++) {
					array_push($propertyIdByNeedSleepArr, "'".$arrNeedBedProp[$i]['property_id']."'");
				}
			}
		}

		if(isset($txtonlybed) && $txtonlybed !="") {
			$propertyIdByOnlyBedArr = array();
			$sqlOnlyBedProp		= "SELECT A.property_id AS property_id FROM " . TABLE_PROPERTY_BEDROOM_RELATIONS . " AS A  WHERE A.total_beds = ".$txtonlybed." ";
			$rsOnlyBedProp 		= $this->dbObj->createRecordset($sqlOnlyBedProp);
			if($this->dbObj->getRecordCount($rsOnlyBedProp) > 0) {
				$arrOnlyBedProp = $this->dbObj->fetchAssoc($rsOnlyBedProp);
				for($i = 0; $i < count($arrOnlyBedProp); $i++) {
					array_push($propertyIdByOnlyBedArr, "'".$arrOnlyBedProp[$i]['property_id']."'");
				}
			}
		}

		if(isset($txttotalbed) && $txttotalbed !="") {
			$propertyIdByTotalBedArr = array();
			$sqlTotalBedProp		= "SELECT A.property_id AS property_id FROM " . TABLE_PROPERTY_BEDROOM_RELATIONS . " AS A  WHERE A.total_beds >= ".$txttotalbed." ";
			$rsTotalBedProp 		= $this->dbObj->createRecordset($sqlTotalBedProp);
			if($this->dbObj->getRecordCount($rsTotalBedProp) > 0) {
				$arrTotalBedProp = $this->dbObj->fetchAssoc($rsTotalBedProp);
				for($i = 0; $i < count($arrTotalBedProp); $i++) {
					array_push($propertyIdByTotalBedArr, "'".$arrTotalBedProp[$i]['property_id']."'");
				}
			}
		}
		
		$featureArr = array();
		if(isset($txtholidaytypeids) && $txtholidaytypeids != "")
			array_push($featureArr, $txtholidaytypeids);

		if(isset($txtkitchenlinenids) && $txtkitchenlinenids != "")
			array_push($featureArr, $txtkitchenlinenids);

		if(isset($txtoutsideids) && $txtoutsideids != "")
			array_push($featureArr, $txtoutsideids);

		if(isset($txtactivitynearbyids) && $txtactivitynearbyids != "")
			array_push($featureArr, $txtactivitynearbyids);

		if(isset($txtheatingcoolingids) && $txtheatingcoolingids != "")
			array_push($featureArr, $txtheatingcoolingids);

		if(isset($txtenterainmentids) && $txtenterainmentids != "")
			array_push($featureArr, $txtenterainmentids);

		if(isset($txtlocationviewids) && $txtlocationviewids != "")
			array_push($featureArr, $txtlocationviewids);

		if(isset($txtserviceids) && $txtserviceids != "")
			array_push($featureArr, $txtserviceids);

		if(isset($txtgeneralids) && $txtgeneralids != "")
			array_push($featureArr, $txtgeneralids);
			
		$txtfacilityids = implode(",", $featureArr);

		if(isset($txtfacilityids) && $txtfacilityids !="") {
			$propertyIdByFacilityArr = array();
			$facilityArr = explode(",", $txtfacilityids);
			$where = array();
			for($i = 0; $i < count($facilityArr); $i++) {
				$facility_id = $facilityArr[$i];
				array_push($where, "((B.feature_ids like '%,".$facility_id .",%') OR (B.feature_ids like '".$facility_id .",%') OR (B.feature_ids like '%,".$facility_id ."'))");
			}
			if(is_array($where) && !empty($where)) {
				$strWhere = implode(" AND ", $where);			
				$sql = "SELECT A.property_id AS property_id 
				FROM  " . TABLE_PROPERTY . " AS A
				INNER JOIN " . TABLE_PROPERTY_FEATURES_RELATIONS . " AS B ON B.property_id = A.property_id
				WHERE A.active='1' AND ".$strWhere;
				$rs = $this->dbObj->createRecordset($sql);
				if($this->dbObj->getRecordCount($rs) > 0){
					$arr = $this->dbObj->fetchAssoc($rs);
				}
				for($j = 0; $j < count($arr); $j++) {
					array_push($propertyIdByFacilityArr, "'".$arr[$j]['property_id']."'");
				}
			}
		}

		if(is_array($propertyIdByLocationArr)) {
			$propertyIdArr = $propertyIdByLocationArr;
		} else if(is_array($propertyIdByRegionArr)) {
			$propertyIdArr = $propertyIdByRegionArr;
		} else if(is_array($propertyIdByAreaArr)) {
			$propertyIdArr = $propertyIdByAreaArr;
		} else if(is_array($propertyIdByCountryArr)) {
			$propertyIdArr = $propertyIdByCountryArr;
		} else {
			$sqlProp		= "SELECT A.property_id AS property_id FROM " . TABLE_PROPERTY . " AS A ";
			$rsProp 		= $this->dbObj->createRecordset($sqlProp);
			if($this->dbObj->getRecordCount($rsProp) > 0) {
				$arrProp = $this->dbObj->fetchAssoc($rsProp);
				for($i = 0; $i < count($arrProp); $i++) {
					array_push($propertyIdArr, "'".$arrProp[$i]['property_id']."'");
				}
			}
		}

		if(is_array($propertyIdArr) && count($propertyIdArr) > 0) {
			if(is_array($propertyIdByAvailableArr)) {
				$propertyIdArr = array_intersect($propertyIdArr, $propertyIdByAvailableArr);
			}
			if(is_array($propertyIdByWCAvailableArr)) {
				$propertyIdArr = array_intersect($propertyIdArr, $propertyIdByWCAvailableArr);
			}
			if(is_array($propertyIdByTypeArr)) {
				$propertyIdArr = array_intersect($propertyIdArr, $propertyIdByTypeArr);
			}
			if(is_array($propertyIdByNeedSleepArr)) {
				$propertyIdArr = array_intersect($propertyIdArr, $propertyIdByNeedSleepArr);
			}
			if(is_array($propertyIdByOnlyBedArr)) {
				$propertyIdArr = array_intersect($propertyIdArr, $propertyIdByOnlyBedArr);
			}
			if(is_array($propertyIdByTotalBedArr)) {
				$propertyIdArr = array_intersect($propertyIdArr, $propertyIdByTotalBedArr);
			}
			if(is_array($propertyIdByFacilityArr)) {
				$propertyIdArr = array_intersect($propertyIdArr, $propertyIdByFacilityArr);
			}
			if(is_array($propertyIdBySRequirementArr)) {
				$propertyIdArr = array_intersect($propertyIdArr, $propertyIdBySRequirementArr);
			}
			if(is_array($propertyIdByLatedealArr)) {
				$propertyIdArr = array_intersect($propertyIdArr, $propertyIdByLatedealArr);
			}
			if(is_array($propertyIdByFeaturedArr)) {
				$propertyIdArr = array_intersect($propertyIdArr, $propertyIdByFeaturedArr);
			}
		}
		if(count($propertyIdArr) > 0) {
			$property_ids = implode(",", array_keys(array_flip($propertyIdArr)));
			return $property_ids;
		} else {
			return false;
		}
	}

	// Function for count refined properties
	function fun_countRefineProperty($txtcountryids = '', $txtareaids = '', $txtregionids = '', $txtlocationids = '',  $txtFromUnixTime = '', $txtToUnixTime = '', $txtpropertytypeids = '', $txtneedsleep = '', $txtonlybed = '', $txttotalbed = '', $txtholidaytypeids = '', $txtkitchenlinenids = '', $txtoutsideids = '', $txtactivitynearbyids = '', $txtheatingcoolingids = '', $txtenterainmentids = '', $txtlocationviewids = '', $txtserviceids = '', $txtgeneralids = '', $parameter = ''){
		$propertyIdArr =  array();
		if((isset($txtcountryids) && $txtcountryids !="") && (!isset($txtareaids) && $txtareaids =="") && (!isset($txtregionids) && $txtregionids =="") && (!isset($txtlocationids) && $txtlocationids =="")) {
			$propertyIdByCountryArr = array();
			if(substr($txtcountryids, 0,1) == ",") {
				$txtcountryids = substr($txtcountryids, 1,strlen($txtcountryids));
			}
			if(substr($txtcountryids, strlen($txtcountryids)-1, strlen($txtcountryids)) == ",") {
				$txtcountryids = substr($txtcountryids, 0,strlen($txtcountryids)-1);
			}

			//Step I: select areas of that country
			if(($area_relation_array = $this->fun_findPropertyRelationInfo(TABLE_AREA , " WHERE country_id IN (".$txtcountryids.")")) && (is_array($area_relation_array))){
				$areaidsByCountryArr		= array();
				for($i = 0; $i < count($area_relation_array); $i++) {
					array_push($areaidsByCountryArr, "'".$area_relation_array[$i]['area_id']."'");
				}

				$areaids = implode(",", array_unique($areaidsByCountryArr));
				//Step II: select regions of that area
				if(($region_relation_array = $this->fun_findPropertyRelationInfo(TABLE_REGION , " WHERE area_id IN (".$areaids.")")) && (is_array($region_relation_array))){
					$regionidsByCountryArr		= array();
					for($j = 0; $j < count($region_relation_array); $j++) {
						array_push($regionidsByCountryArr, "'".$region_relation_array[$j]['region_id']."'");
					}

					$regionids = implode(",", array_unique($regionidsByCountryArr));
					//Step III: select locations of that region
					if(($regionids != "") && ($loc_relation_array = $this->fun_findPropertyRelationInfo(TABLE_LOCATION , " WHERE region_id IN (".$regionids.")")) && (is_array($loc_relation_array))){
						$locationidsArr		= array();
						for($j = 0; $j < count($loc_relation_array); $j++) {
							array_push($locationidsArr, "'".$loc_relation_array[$j]['location_id']."'");
						}
						$locationids = implode(",", array_unique($locationidsArr));
					}
				}
			}
			
			if(isset($locationids) && $locationids != "") {
				//Step IV: select properties by locationids
				$sqlCountryProp		= "SELECT A.property_id AS property_id FROM " . TABLE_PROPERTY . " AS A  WHERE A.location_id IN (".$locationids.") ";
				$rsCountryProp 		= $this->dbObj->createRecordset($sqlCountryProp);
				if($this->dbObj->getRecordCount($rsCountryProp) > 0) {
					$arrCountryProp = $this->dbObj->fetchAssoc($rsCountryProp);
					for($i = 0; $i < count($arrCountryProp); $i++) {
						//Step IV: Push it to array
						array_push($propertyIdByCountryArr, "'".$arrCountryProp[$i]['property_id']."'");
					}
				}
			}
		}

		if((isset($txtareaids) && $txtareaids !="") && (!isset($txtregionids) && $txtregionids =="") && (!isset($txtlocationids) && $txtlocationids =="")) {
			$propertyIdByAreaArr = array();
			if(substr($txtareaids, 0,1) == ",") {
				$txtareaids = substr($txtareaids, 1,strlen($txtareaids));
			}

			if(substr($txtareaids, strlen($txtareaids)-1, strlen($txtareaids)) == ",") {
				$txtareaids = substr($txtareaids, 0,strlen($txtareaids)-1);
			}

			//Step II: select regions of that area
			if(($region_relation_array = $this->fun_findPropertyRelationInfo(TABLE_REGION , " WHERE area_id IN (".$txtareaids.")")) && (is_array($region_relation_array))){
				$regionidsByAreaArr		= array();
				for($j = 0; $j < count($region_relation_array); $j++) {
					array_push($regionidsByAreaArr, "'".$region_relation_array[$j]['region_id']."'");
				}

				$regionids = implode(",", array_unique($regionidsByAreaArr));
				//Step III: select locations of that region
				if(($regionids != "") && ($loc_relation_array = $this->fun_findPropertyRelationInfo(TABLE_LOCATION , " WHERE region_id IN (".$regionids.")")) && (is_array($loc_relation_array))){
					$locationidsArr		= array();
					for($j = 0; $j < count($loc_relation_array); $j++) {
						array_push($locationidsArr, "'".$loc_relation_array[$j]['location_id']."'");
					}
					$locationids = implode(",", array_unique($locationidsArr));
				}
			}
			if(isset($locationids) && $locationids != "") {
				//Step IV: select properties by locationids
				$sqlAreaProp		= "SELECT A.property_id AS property_id FROM " . TABLE_PROPERTY . " AS A  WHERE A.location_id IN (".$locationids.") ";
				$rsAreaProp 		= $this->dbObj->createRecordset($sqlAreaProp);
				if($this->dbObj->getRecordCount($rsAreaProp) > 0) {
					$arrAreaProp = $this->dbObj->fetchAssoc($rsAreaProp);
					for($i = 0; $i < count($arrAreaProp); $i++) {
						//Step IV: Push it to array
						array_push($propertyIdByAreaArr, "'".$arrAreaProp[$i]['property_id']."'");
					}
				}
			}
		}

		if((isset($txtregionids) && $txtregionids !="") && (!isset($txtlocationids) && $txtlocationids =="")) {
			$propertyIdByRegionArr = array();
			if(substr($txtregionids, 0,1) == ",") {
				$txtregionids = substr($txtregionids, 1,strlen($txtregionids));
			}

			if(substr($txtregionids, strlen($txtregionids)-1, strlen($txtregionids)) == ",") {
				$txtregionids = substr($txtregionids, 0,strlen($txtregionids)-1);
			}


			//Step III: select locations of that region
			if(($txtregionids != "") && ($loc_relation_array = $this->fun_findPropertyRelationInfo(TABLE_LOCATION , " WHERE region_id IN (".$txtregionids.")")) && (is_array($loc_relation_array))){
				$locationidsArr		= array();
				for($j = 0; $j < count($loc_relation_array); $j++) {
					array_push($locationidsArr, "'".$loc_relation_array[$j]['location_id']."'");
				}
				$locationids = implode(",", array_unique($locationidsArr));
			}

			if(isset($locationids) && $locationids != "") {
				//Step IV: select properties by locationids
				$sqlRegionProp		= "SELECT A.property_id AS property_id FROM " . TABLE_PROPERTY . " AS A  WHERE A.location_id IN (".$locationids.") ";
				$rsRegionProp 		= $this->dbObj->createRecordset($sqlRegionProp);
				if($this->dbObj->getRecordCount($rsRegionProp) > 0) {
					$arrRegionProp = $this->dbObj->fetchAssoc($rsRegionProp);
					for($i = 0; $i < count($arrRegionProp); $i++) {
						//Step IV: Push it to array
						array_push($propertyIdByRegionArr, "'".$arrRegionProp[$i]['property_id']."'");
					}
				}
			}
		}

		if((isset($txtlocationids) && $txtlocationids !="")) {
			$propertyIdByLocationArr = array();

			if(substr($txtlocationids, 0,1) == ",") {
				$txtlocationids = substr($txtlocationids, 1,strlen($txtlocationids));
			}

			if(substr($txtlocationids, strlen($txtlocationids)-1, strlen($txtlocationids)) == ",") {
				$txtlocationids = substr($txtlocationids, 0,strlen($txtlocationids)-1);
			}

			$sqlLocProp		= "SELECT A.property_id AS property_id FROM " . TABLE_PROPERTY . " AS A  WHERE A.location_id IN (".$txtlocationids.") ";
			$rsLocProp 		= $this->dbObj->createRecordset($sqlLocProp);
			if($this->dbObj->getRecordCount($rsLocProp) > 0) {
				$arrLocProp = $this->dbObj->fetchAssoc($rsLocProp);
				for($i = 0; $i < count($arrLocProp); $i++) {
					array_push($propertyIdByLocationArr, "'".$arrLocProp[$i]['property_id']."'");
				}
			}
		}

		if((isset($txtFromUnixTime) && $txtFromUnixTime !="") && (isset($txtToUnixTime) && $txtToUnixTime !="")) {
			$propertyIdByAvailableArr = array();

			$startDate 		= date('Y-m-d', $txtFromUnixTime);
			$endDate 		= date('Y-m-d', $txtToUnixTime);
			$sqlAvailProp	= "SELECT A.property_id AS property_id FROM " . TABLE_PROPERTY_AVAILABILITY_RELATIONS . " AS A  WHERE A.startdate >= '".$startDate."' AND A.enddate <= '".$endDate."' AND A.status='2'";
			$rsAvailProp 	= $this->dbObj->createRecordset($sqlAvailProp);
			if($this->dbObj->getRecordCount($rsAvailProp) > 0) {
				$arrAvailProp = $this->dbObj->fetchAssoc($rsAvailProp);
				for($i = 0; $i < count($arrAvailProp); $i++) {
					array_push($propertyIdByAvailableArr, "'".$arrAvailProp[$i]['property_id']."'");
				}

				$propertyIdByAvailableArr = array_keys(array_flip($propertyIdByAvailableArr));;
			}
		}


		if(isset($txtpropertytypeids) && $txtpropertytypeids !="") {
			$propertyIdByTypeArr = array();

			$propertytypeidArr = explode(",", $txtpropertytypeids);
			$propertytype_ids = "";
			for($i = 0; $i < count($propertytypeidArr); $i++) {
				$propertytype_ids .= ",'".$propertytypeidArr[$i]."'";
			}
			if(substr($propertytype_ids, 0, 1) == ",") {
				$propertytype_ids = substr($propertytype_ids, 1, strlen($propertytype_ids));
			}

			if($propertytype_ids != "") {
				$sql = "SELECT A.property_id AS property_id 
				FROM  " . TABLE_PROPERTY . " AS A
				WHERE A.active='1' AND property_type IN (".$propertytype_ids.")";
				$rs = $this->dbObj->createRecordset($sql);
				if($this->dbObj->getRecordCount($rs) > 0){
					$arr = $this->dbObj->fetchAssoc($rs);
				}
				for($j = 0; $j < count($arr); $j++) {
					array_push($propertyIdByTypeArr, "'".$arr[$j]['property_id']."'");
				}
			}
		}

		if(isset($txtneedsleep) && $txtneedsleep !="") {
			$propertyIdByNeedSleepArr = array();
			$sqlNeedBedProp		= "SELECT A.property_id AS property_id FROM " . TABLE_PROPERTY_BEDROOM_RELATIONS . " AS A  WHERE A.scomfort_beds >= ".$txtneedsleep." ";
			$rsNeedBedProp 		= $this->dbObj->createRecordset($sqlNeedBedProp);
			if($this->dbObj->getRecordCount($rsNeedBedProp) > 0) {
				$arrNeedBedProp = $this->dbObj->fetchAssoc($rsNeedBedProp);
				for($i = 0; $i < count($arrNeedBedProp); $i++) {
					array_push($propertyIdByNeedSleepArr, "'".$arrNeedBedProp[$i]['property_id']."'");
				}
			}
		}

		if(isset($txttotalbed) && $txttotalbed !="") {
			$propertyIdByTotalBedArr = array();

			$sqlTotalBedProp		= "SELECT A.property_id AS property_id FROM " . TABLE_PROPERTY_BEDROOM_RELATIONS . " AS A  WHERE A.total_beds >= ".$txttotalbed." ";
			$rsTotalBedProp 		= $this->dbObj->createRecordset($sqlTotalBedProp);
			if($this->dbObj->getRecordCount($rsTotalBedProp) > 0) {
				$arrTotalBedProp = $this->dbObj->fetchAssoc($rsTotalBedProp);
				for($i = 0; $i < count($arrTotalBedProp); $i++) {
					array_push($propertyIdByTotalBedArr, "'".$arrTotalBedProp[$i]['property_id']."'");
				}
			}
		}

		if(isset($txtfacilityids) && $txtfacilityids !="") {
			$propertyIdByFacilityArr = array();

			$facilityArr = explode(",", $txtfacilityids);
			$where = array();
			for($i = 0; $i < count($facilityArr); $i++) {
				$facility_id = $facilityArr[$i];
				array_push($where, "((B.feature_ids like '%,".$facility_id .",%') OR (B.feature_ids like '".$facility_id .",%') OR (B.feature_ids like '%,".$facility_id ."'))");
			}
			
			if(is_array($where) && !empty($where)) {
				$strWhere = implode(" AND ", $where);			
				$sql = "SELECT A.property_id AS property_id 
				FROM  " . TABLE_PROPERTY . " AS A
				INNER JOIN " . TABLE_PROPERTY_FEATURES_RELATIONS . " AS B ON B.property_id = A.property_id
				WHERE A.active='1' AND ".$strWhere;
				$rs = $this->dbObj->createRecordset($sql);
				if($this->dbObj->getRecordCount($rs) > 0){
					$arr = $this->dbObj->fetchAssoc($rs);
				}
				for($j = 0; $j < count($arr); $j++) {
					array_push($propertyIdByFacilityArr, "'".$arr[$j]['property_id']."'");
				}
			}
		}

		if(isset($txtspecialrequirmentids) && $txtspecialrequirmentids !="") {
			$propertyIdBySRequirementArr = array();

			$specialrequirmentidArr = explode(",", $txtspecialrequirmentids);
			$srwhere = array();
			for($i = 0; $i < count($specialrequirmentidArr); $i++) {
				$property_requirement_id = $specialrequirmentidArr[$i];
				array_push($srwhere, "((B.srequirement_ids like '%,".$property_requirement_id .",%') OR (B.srequirement_ids like '".$property_requirement_id .",%') OR (B.srequirement_ids like '%,".$property_requirement_id ."'))");
			}
			if(is_array($srwhere) && !empty($srwhere)) {
				$strWhere = implode(" AND ", $srwhere);			
				$sql = "SELECT A.property_id AS property_id 
				FROM  " . TABLE_PROPERTY . " AS A
				INNER JOIN " . TABLE_PROPERTY_SPECIAL_REQUIREMENTS_RELATIONS . " AS B ON B.property_id = A.property_id
				WHERE A.active='1' AND ".$strWhere;
				$rs = $this->dbObj->createRecordset($sql);
				if($this->dbObj->getRecordCount($rs) > 0){
					$arr = $this->dbObj->fetchAssoc($rs);
				}
				for($j = 0; $j < count($arr); $j++) {
					array_push($propertyIdBySRequirementArr, "'".$arr[$j]['property_id']."'");
				}
			}
		}

		if(isset($txtholidaytypeids) && $txtholidaytypeids !="") {
			$propertyIdByHolidayArr = array();

			$holidaytypeidArr = explode(",", $txtholidaytypeids);
			$hdwhere = array();
			for($i = 0; $i < count($holidaytypeidArr); $i++) {
				$property_holiday_id = $holidaytypeidArr[$i];
				array_push($hdwhere, "((B.holiday_type like '%,".$property_holiday_id .",%') OR (B.holiday_type like '".$property_holiday_id .",%') OR (B.holiday_type like '%,".$property_holiday_id ."'))");
			}
			if(is_array($hdwhere) && !empty($hdwhere)) {
				$strWhere = implode(" AND ", $hdwhere);			
				$sql = "SELECT A.property_id AS property_id 
				FROM  " . TABLE_PROPERTY . " AS A
				INNER JOIN " . TABLE_PROPERTY_CHECKLIST_SETTINGS . " AS B ON B.property_id = A.property_id
				WHERE A.active='1' AND ".$strWhere;
				$rs = $this->dbObj->createRecordset($sql);
				if($this->dbObj->getRecordCount($rs) > 0){
					$arr = $this->dbObj->fetchAssoc($rs);
				}
				for($j = 0; $j < count($arr); $j++) {
					array_push($propertyIdByHolidayArr, "'".$arr[$j]['property_id']."'");
				}
			}
		}

		if(is_array($propertyIdByLocationArr) && count($propertyIdByLocationArr) > 0) {
			$propertyIdArr = $propertyIdByLocationArr;
		} else if(is_array($propertyIdByRegionArr) && count($propertyIdByRegionArr) > 0) {
			$propertyIdArr = $propertyIdByRegionArr;
		} else if(is_array($propertyIdByAreaArr) && count($propertyIdByAreaArr) > 0) {
			$propertyIdArr = $propertyIdByAreaArr;
		} else if(is_array($propertyIdByCountryArr) && count($propertyIdByCountryArr) > 0) {
			$propertyIdArr = $propertyIdByCountryArr;
		}

		if(is_array($propertyIdArr) && count($propertyIdArr) > 0) {
			if(is_array($propertyIdByAvailableArr)) {
				$propertyIdArr = array_intersect($propertyIdArr, $propertyIdByAvailableArr);
			}
			if(is_array($propertyIdByTypeArr)) {
				$propertyIdArr = array_intersect($propertyIdArr, $propertyIdByTypeArr);
			}
			if(is_array($propertyIdByNeedSleepArr)) {
				$propertyIdArr = array_intersect($propertyIdArr, $propertyIdByNeedSleepArr);
			}
			if(is_array($propertyIdByTotalBedArr)) {
				$propertyIdArr = array_intersect($propertyIdArr, $propertyIdByTotalBedArr);
			}
			if(is_array($propertyIdByFacilityArr)) {
				$propertyIdArr = array_intersect($propertyIdArr, $propertyIdByFacilityArr);
			}
			if(is_array($propertyIdBySRequirementArr)) {
				$propertyIdArr = array_intersect($propertyIdArr, $propertyIdBySRequirementArr);
			}
			if(is_array($propertyIdByHolidayArr)) {
				$propertyIdArr = array_intersect($propertyIdArr, $propertyIdByHolidayArr);
			}
		}

		if(count($propertyIdArr) > 0) {
			return count($propertyIdArr);
		} else {
			return "0";
		}
	}

	// Function for property-update info array
	function fun_getPropertySearchByLocArr($destination_name, $parameter=''){
		// Step I : find the destination id and type
		//echo $destination_name;
		$location_ids		= "";
		$region_ids			= "";

		if(($area_relation_array = $this->fun_findPropertyRelationInfo(TABLE_AREA , " WHERE LOWER(area_name)='".strtolower(trim($destination_name))."'")) && (is_array($area_relation_array))){
			$area_id		= $area_relation_array[0]['area_id'];

			if(($pregion_relation_array = $this->fun_findPropertyRelationInfo(TABLE_REGION , " WHERE area_id='".$area_id."'")) && (is_array($pregion_relation_array))){
				$region_ids		= "";
				for($i = 0; $i < count($pregion_relation_array); $i++) {
					$region_id 		= $pregion_relation_array[$i]['region_id'];
					$region_ids		.= "'".$region_id."',";
				}

				if (substr($region_ids, -1) == ",") {
					$region_ids	= substr(trim($region_ids), 0, (strlen($region_ids)-1));
				}
				if(($region_ids != "") && ($loc_relation_array = $this->fun_findPropertyRelationInfo(TABLE_LOCATION , " WHERE region_id IN (".$region_ids.")")) && (is_array($loc_relation_array))){
					for($j = 0; $j < count($loc_relation_array); $j++) {
						$location_id 		= $loc_relation_array[$j]['location_id'];
						$location_ids		.= "'".$location_id."',";
					}
	
					if (substr($location_ids, -1) == ",") {
						$location_ids	= substr(trim($location_ids), 0, (strlen($location_ids)-1));
					}
				}
			}
						
		} else if(($pregion_relation_array = $this->fun_findPropertyRelationInfo(TABLE_REGION , " WHERE LOWER(region_name)='".strtolower($destination_name)."'")) && (is_array($pregion_relation_array))){
			$region_id		= $pregion_relation_array[0]['region_id'];
			$pregion_id		= $pregion_relation_array[0]['pregion_id'];
			$region_ids		= $region_id;
			if(($pregion_id == "0") && ($region_relation_array = $this->fun_findPropertyRelationInfo(TABLE_REGION , " WHERE pregion_id='".$region_id."'")) && is_array($region_relation_array)) {

				$region_ids		= "";
				for($i = 0; $i < count($region_relation_array); $i++) {
					$region_id 		= $region_relation_array[$i]['region_id'];
					$region_ids		.= "'".$region_id."',";
				}

				if (substr($region_ids, -1) == ",") {
					$region_ids	= substr(trim($region_ids), 0, (strlen($region_ids)-1));
				}

//				$sql = "SELECT 	A.property_id, A.property_name, A.property_title, A.description FROM " . TABLE_PROPERTY . " AS A  WHERE A.subregion_id IN (".$region_ids.") ";
			} else {
				$region_ids = $region_id;
//				$sql = "SELECT 	A.property_id, A.property_name, A.property_title, A.description FROM " . TABLE_PROPERTY . " AS A  WHERE A.region_id IN (".$region_ids.") ";
			}
			if(($region_ids != "") && ($loc_relation_array = $this->fun_findPropertyRelationInfo(TABLE_LOCATION , " WHERE region_id IN (".$region_ids.")")) && (is_array($loc_relation_array))){
				for($j = 0; $j < count($loc_relation_array); $j++) {
					$location_id 		= $loc_relation_array[$j]['location_id'];
					$location_ids		.= "'".$location_id."',";
				}

				if (substr($location_ids, -1) == ",") {
					$location_ids	= substr(trim($location_ids), 0, (strlen($location_ids)-1));
				}
			}

		} else if(($loc_relation_array = $this->fun_findPropertyRelationInfo(TABLE_LOCATION , " WHERE LOWER(location_name)='".strtolower($destination_name)."'")) && (is_array($loc_relation_array))){
			$location_id		= $loc_relation_array[0]['location_id'];
			$location_ids		= "'".$location_id."'";
		}

		if($area_id  !="" || $region_id !="" || $region_ids !="" || $location_id !="" || $location_ids !="") {
			$sql = "SELECT 	
				A.property_id, 
				A.property_name, 
				A.property_title, 
				A.property_summary,
				A.description 
			FROM " . TABLE_PROPERTY . " AS A  WHERE A.active='1' AND ";

			$sqlDes = " ";
			$arr1 	=  array();
			if($area_id != ""){
				array_push($arr1, " A.area_id IN (".$area_id.") ");
			}
			if($region_id != ""){
				array_push($arr1, " A.region_id IN (".$region_id.") ");
			}
			if($region_ids != ""){
				array_push($arr1, " A.region_id IN (".$region_ids.") ");
			}
			if($location_id != ""){
				array_push($arr1, " A.location_id IN (".$location_id.") ");
			}
			if($location_ids != ""){
				array_push($arr1, " A.location_id IN (".$location_ids.") ");
			}
			$sqlDes .= implode(" OR ", array_unique($arr1));

			if($sqlDes != ""){
				$sql .= " (".$sqlDes.") ";
			}

		// Step II : Then create query based on this
			if($parameter!=""){
				$sql .= $parameter;
			} else {
				$sql .= " ORDER BY A.property_id";		
			}
		//$sql;
		// Step III : Return the result
			return $rs = $this->dbObj->createRecordset($sql);
//			 $arr = $this->dbObj->fetchAssoc($rs);		
		} else {
			return false;
		}
	}

	// Function for get property ids sort by price
	function fun_getPropertyIdsByPriceSort($dr = ''){
		$sql = "SELECT A.property_id, MIN(CAST((A.per_week_price/B.currency_rate) AS DECIMAL(10,2))) AS week_price FROM " . TABLE_PROPERTY_PRICES . " AS A, " . TABLE_CURRENCIES . " AS B WHERE A.per_week_price !='' AND B.currency_id=A.currency_code GROUP BY A.property_id ";

		if($dr!=""){
			$sql .= " ORDER BY week_price ".$dr;
		} else {
			$sql .= "  ORDER BY week_price";		
		}
		//echo $sql;
		
		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			$arr = $this->dbObj->fetchAssoc($rs);
			$idsArray =  array();
			for($i = 0; $i < count($arr); $i++) {
				array_push($idsArray, $arr[$i]['property_id']);
			}
			return $idsArray;
		} else {
			return false;
		}
	}

	// Function for get property ids sort by total reviews
	function fun_getPropertyIdsByReviewsSort($dr = ''){
		$sql = "SELECT 	A.property_id, COUNT(*) AS total_reviews FROM " . TABLE_PROPERTY_REVIEWS_RELATIONS . " AS A  WHERE A.status='2' GROUP BY A.property_id ";
		if($dr!=""){
			$sql .= " ORDER BY total_reviews ".$dr;
		} else {
			$sql .= " ORDER BY total_reviews ";		
		}
		//echo $sql;
		
		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			$arr = $this->dbObj->fetchAssoc($rs);
			$idsArray =  array();
			for($i = 0; $i < count($arr); $i++) {
				array_push($idsArray, $arr[$i]['property_id']);
			}
			return $idsArray;
		} else {
			return false;
		}
	}

	// Function for get property ids sort by percentage save
	function fun_getPropertyIdsByLateDealSort($dr = ''){
		$sql = "SELECT 	A.property_id, (((CAST(A.original_price AS SIGNED) - CAST(A.sale_price AS SIGNED))/CAST(A.original_price AS SIGNED))*100) AS percent_save FROM " . TABLE_PROPERTY_SPECIAL_DEALS_RELATIONS . " AS A  
				INNER JOIN " . TABLE_PROPERTY . " AS B ON A.property_id = B.property_id
				WHERE A.status='2' AND B.status='2' AND B.active='1' GROUP BY A.property_id
				";

		if($dr!=""){
			$sql .= " ORDER BY percent_save ".$dr;
		} else {
			$sql .= " ORDER BY percent_save ";		
		}
		//echo $sql;
		
		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			$arr = $this->dbObj->fetchAssoc($rs);
			$idsArray =  array();
			for($i = 0; $i < count($arr); $i++) {
				array_push($idsArray, $arr[$i]['property_id']);
			}
			return $idsArray;
		} else {
			return false;
		}
	}

	// Function for property-status array
	function fun_getPropertyStatusInfoArr($parameter=''){
		$sql = "SELECT 	A.property_id, 
						A.property_name,
						A.status AS status_id,
						B.status_name
				FROM " . TABLE_PROPERTY . " AS A  
				INNER JOIN " . TABLE_PROPERTY_STATUS . " AS B ON A.status = B.status_id
				WHERE A.status !=''
				";

		if($parameter!=""){
			$sql .= $parameter." ORDER BY A.property_id";
		}
		else{
			$sql .= " ORDER BY A.property_id";		
		}		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			return $arr = $this->dbObj->fetchAssoc($rs);
		} else {
			return false;
		}
	}

	// Function for get property status id
	function fun_getPropertyStatusId($property_id){
		$status = $this->dbObj->getField(TABLE_PROPERTY, "property_id", $property_id, "status");
		return $status;
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

	// Function for property-owner array
	function fun_getPropertyLocInfoArr($property_id = ''){
		/*
		$sqlLoc = "SELECT A.country_id, 
		A.area_id, 
		A.region_id, 
		A.subregion_id, 
		A.location_id, 
		B.countries_name, 
		C.area_name, 
		D.region_name, 
		E.location_name 
		FROM " . TABLE_PROPERTY . " AS A  
		INNER JOIN " . TABLE_COUNTRIES . " AS B ON A.country_id = B.countries_id 
		INNER JOIN " . TABLE_AREA . " AS C ON A.area_id = C.area_id 
		INNER JOIN " . TABLE_REGION . " AS D ON A.region_id = D.region_id 
		INNER JOIN " . TABLE_LOCATION . " AS E ON A.location_id = E.location_id 
		WHERE A.property_id ='".$property_id."'";
		*/

		$sqlLoc = "SELECT A.country_id, A.area_id, A.region_id, A.subregion_id, A.location_id FROM " . TABLE_PROPERTY . " AS A  WHERE A.property_id ='".$property_id."'";
		$rsLoc 					= $this->dbObj->createRecordset($sqlLoc);
		$arrLoc 				= $this->dbObj->fetchAssoc($rsLoc);
		if(is_array($arrLoc) && count($arrLoc) > 0) {
			$locationinfoArray =  array();
			$locationinfoArray['location_id'] 	= $arrLoc[0]['location_id'];
			$locationinfoArray['location_name'] = $this->fun_getLocationNameById($arrLoc[0]['location_id']);
			$locationinfoArray['location_status'] = $this->dbObj->getField(TABLE_LOCATION, "location_id", $arrLoc[0]['location_id'], "status");
			$locationinfoArray['region_id'] 	= $arrLoc[0]['region_id'];
			$locationinfoArray['region_name'] 	= $this->fun_getRegionNameById($arrLoc[0]['region_id']);
			$locationinfoArray['region_status'] = $this->dbObj->getField(TABLE_REGION, "region_id", $arrLoc[0]['region_id'], "status");
			$locationinfoArray['area_id'] 		= $arrLoc[0]['area_id'];
			$locationinfoArray['area_name'] 	= $this->fun_getAreaNameById($arrLoc[0]['area_id']);
			$locationinfoArray['countries_id'] 	= $arrLoc[0]['country_id'];
			$locationinfoArray['countries_name']= $this->fun_getCountryNameById($arrLoc[0]['country_id']);
			return $locationinfoArray;
		} else {
			return false;
		}
	}

	/*
	// Function for property-owner array
	function fun_getPropertyLocInfoArr($property_id = ''){
		$sqlLoc = "SELECT A.country_id, A.area_id, A.region_id, A.subregion_id, A.location_id FROM " . TABLE_PROPERTY . " AS A  WHERE A.property_id ='".$property_id."'";
		//echo($sqlLoc);
		$rsLoc 					= $this->dbObj->createRecordset($sqlLoc);
		$arrLoc 				= $this->dbObj->fetchAssoc($rsLoc);

		if(is_array($arrLoc) && $arrLoc[0]['location_id'] > 0) {
			$locationinfoArray =  array();
			$location_id 			= $arrLoc[0]['location_id'];
			$location_status 		= $this->dbObj->getField(TABLE_LOCATION, "location_id", $location_id, "status");
			$location_name 			= $this->fun_getLocationNameById($location_id);
			$location_regid 		= $arrLoc[0]['region_id'];
			if(($region_relation_array = $this->fun_findPropertyRelationInfo(TABLE_REGION , " WHERE region_id='".$location_regid."'")) && (is_array($region_relation_array))){
				$region_id 		= $region_relation_array[0]['region_id'];
				$region_pid 	= $region_relation_array[0]['pregion_id'];
				$region_pstatus	= $region_relation_array[0]['status'];
				$region_pname 	= $this->fun_getRegionNameById($region_pid);
				$region_parea_id= $region_relation_array[0]['area_id'];
	
				if($region_pid  > 0) {
					if(($pregion_relation_array = $this->fun_findPropertyRelationInfo(TABLE_REGION , " WHERE region_id='".$region_pid."'")) && (is_array($pregion_relation_array))){
						$region_id 		= $pregion_relation_array[0]['region_id'];
						$region_status	= $pregion_relation_array[0]['status'];
						$region_name 	= $this->fun_getRegionNameById($region_id);
						$region_area_id = $pregion_relation_array[0]['area_id'];
					}
				} else {
					$region_id 		= $region_id;
					$region_status	= $region_pstatus;
					$region_name 	= $this->fun_getRegionNameById($region_id);
					$region_area_id = $region_parea_id;
				}
				if(($area_relation_array = $this->fun_findPropertyRelationInfo(TABLE_AREA , " WHERE area_id='".$region_area_id."'")) && (is_array($area_relation_array))){
					$area_id	 	= $area_relation_array[0]['area_id'];
					$area_name	 	= $this->fun_getAreaNameById($area_id);
					$area_country_id= $area_relation_array[0]['country_id'];
					if(($country_relation_array = $this->fun_findPropertyRelationInfo(TABLE_COUNTRIES , " WHERE countries_id='".$area_country_id."'")) && (is_array($country_relation_array))){
						$countries_id	 	= $country_relation_array[0]['countries_id'];
						$countries_name	 	= $this->fun_getCountryNameById($countries_id);
					}
				}

				$locationinfoArray['location_id'] 	= $location_id;
				$locationinfoArray['location_status'] = $location_status;
				$locationinfoArray['location_name'] = $location_name;
				if($region_pid != "0") {
					$locationinfoArray['region_pid'] 	= $region_pid;
					$locationinfoArray['region_pstatus']= $region_pstatus;
					$locationinfoArray['region_pname'] 	= $region_pname;
				}
				$locationinfoArray['region_id'] 	= $region_id;
				$locationinfoArray['region_status'] = $region_status;
				$locationinfoArray['region_name'] 	= $region_name;
				$locationinfoArray['area_id'] 		= $area_id;
				$locationinfoArray['area_name'] 	= $area_name;
				$locationinfoArray['countries_id'] 	= $countries_id;
				$locationinfoArray['countries_name']= $countries_name;
			} 
			return $locationinfoArray;
		} else if($arrLoc[0]['region_id']  > 0){
			$location_regid 		= $arrLoc[0]['region_id'];
			if(($region_relation_array = $this->fun_findPropertyRelationInfo(TABLE_REGION , " WHERE region_id='".$location_regid."'")) && (is_array($region_relation_array))){
				$region_id 		= $region_relation_array[0]['region_id'];
				$region_pid 	= $region_relation_array[0]['pregion_id'];
				$region_pstatus	= $region_relation_array[0]['status'];
				$region_pname 	= $this->fun_getRegionNameById($region_pid);
				$region_parea_id= $region_relation_array[0]['area_id'];
	
				if($region_pid  > 0) {
					if(($pregion_relation_array = $this->fun_findPropertyRelationInfo(TABLE_REGION , " WHERE region_id='".$region_pid."'")) && (is_array($pregion_relation_array))){
						$region_id 		= $pregion_relation_array[0]['region_id'];
						$region_status	= $pregion_relation_array[0]['status'];
						$region_name 	= $this->fun_getRegionNameById($region_id);
						$region_area_id = $pregion_relation_array[0]['area_id'];
					}
				} else {
					$region_id 		= $region_id;
					$region_status	= $region_pstatus;
					$region_name 	= $this->fun_getRegionNameById($region_id);
					$region_area_id = $region_parea_id;
				}
				if(($area_relation_array = $this->fun_findPropertyRelationInfo(TABLE_AREA , " WHERE area_id='".$region_area_id."'")) && (is_array($area_relation_array))){
					$area_id	 	= $area_relation_array[0]['area_id'];
					$area_name	 	= $this->fun_getAreaNameById($area_id);
					$area_country_id= $area_relation_array[0]['country_id'];
					if(($country_relation_array = $this->fun_findPropertyRelationInfo(TABLE_COUNTRIES , " WHERE countries_id='".$area_country_id."'")) && (is_array($country_relation_array))){
						$countries_id	 	= $country_relation_array[0]['countries_id'];
						$countries_name	 	= $this->fun_getCountryNameById($countries_id);
					}
				}

				$locationinfoArray['region_id'] 	= $region_id;
				$locationinfoArray['region_status'] = $region_status;
				$locationinfoArray['region_name'] 	= $region_name;
				$locationinfoArray['area_id'] 		= $area_id;
				$locationinfoArray['area_name'] 	= $area_name;
				$locationinfoArray['countries_id'] 	= $countries_id;
				$locationinfoArray['countries_name']= $countries_name;
			}

			return $locationinfoArray;
		} else {
			return false;
		}
	}
	*/

	// Function for property-owner array
	function fun_getPropertyOwnerShortInfoArr($parameter=''){
		$sql = "SELECT 	A.property_id, 
						A.property_name,
						A.status,
						FROM_UNIXTIME(A.updated_on, '%m/%d/%Y') AS updated_on,
						FROM_UNIXTIME(A.created_on, '%m/%d/%Y') AS created_on,
						B.owner_id, 
						C.status_name, 
						D.user_fname, 
						D.user_lname,
						D.user_email 
				FROM " . TABLE_PROPERTY . " AS A  
				LEFT JOIN " . TABLE_PROPERTY_OWNER_RELATIONS . " AS B ON A.property_id = B.property_id
				LEFT JOIN " . TABLE_PROPERTY_STATUS . " AS C ON A.status = C.status_id,
				".TABLE_USERS." AS D WHERE D.user_id=B.owner_id ";

		if($parameter!=""){
			$sql .= $parameter." ORDER BY A.property_id";
		}
		else{
			$sql .= " ORDER BY A.property_id";		
		}		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			return $arr = $this->dbObj->fetchAssoc($rs);
		} else {
			return false;
		}
	}

	// Function for property-owner array
	function fun_getNewPropertyOwnerShortInfoArr($parameter=''){
		$sql = "SELECT 	A.property_id, 
						A.property_name,
						A.status,
						FROM_UNIXTIME(A.updated_on, '%m/%d/%Y') AS updated_on,
						FROM_UNIXTIME(A.created_on, '%m/%d/%Y') AS created_on,
						B.owner_id, 
						C.status_name, 
						D.user_fname, 
						D.user_lname
				FROM " . TABLE_PROPERTY . " AS A  
				LEFT JOIN " . TABLE_PROPERTY_OWNER_RELATIONS . " AS B ON A.property_id = B.property_id
				LEFT JOIN " . TABLE_PROPERTY_STATUS . " AS C ON A.status = C.status_id,
				".TABLE_USERS." AS D WHERE D.user_id=B.owner_id ";

		if($parameter!=""){
			$sql .= $parameter." ORDER BY A.property_id";
		}
		else{
			$sql .= " ORDER BY A.property_id";		
		}		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			return $arr = $this->dbObj->fetchAssoc($rs);
		} else {
			return false;
		}
	}

	// Function for pending approval property array
	/*
	Items that have been approved, declined, or suspended that are included in the Pending Approval list remain 
	in this section for a period of 7 days from the date the status was applied.
	All items with a Pending approval status remain in the list until a new status has been applied.
	*/
	function fun_getPendingApprovalNewPropertyArr($parameter=''){
		$sql = "SELECT 	A.property_id, 
						A.property_name,
						A.status,
						FROM_UNIXTIME(A.statuschanged_on, '%m/%d/%Y') AS statuschanged_on,
						FROM_UNIXTIME(A.created_on, '%m/%d/%Y') AS created_on,
						FROM_UNIXTIME(A.updated_on, '%m/%d/%Y') AS updated_on,
						FROM_UNIXTIME(A.active_on, '%m/%d/%Y') AS active_on,
						B.owner_id, 
						C.status_name, 
						D.user_fname, 
						D.user_lname
				FROM " . TABLE_PROPERTY . " AS A  
				LEFT JOIN " . TABLE_PROPERTY_OWNER_RELATIONS . " AS B ON A.property_id = B.property_id
				LEFT JOIN " . TABLE_PROPERTY_STATUS . " AS C ON A.status = C.status_id,
				".TABLE_USERS." AS D
				WHERE D.user_id=B.owner_id 
				AND (DATEDIFF(NOW() , FROM_UNIXTIME(A.created_on, '%Y-%m-%d')) < 8) 
				AND (DATEDIFF(FROM_UNIXTIME(A.updated_on, '%Y-%m-%d'), FROM_UNIXTIME(A.created_on, '%Y-%m-%d')) < 8) 
				";
		if($parameter!=""){
			$sql .= $parameter;		
		} else {
			$sql .= " ORDER BY A.created_on DESC";		
		}		
		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			return $arr = $this->dbObj->fetchAssoc($rs);
		} else {
			return false;
		}
    }

	function fun_checkPropertyIsNewListing($property_id = '') {
        if($property_id == '') {
            return false;
        } else {

            $sql = "SELECT DATEDIFF(NOW() , FROM_UNIXTIME(A.created_on, '%Y-%m-%d')) AS totalDays FROM " . TABLE_PROPERTY . " AS A WHERE A.property_id = '".$property_id."'";
            $rs = $this->dbObj->createRecordset($sql);
            if($this->dbObj->getRecordCount($rs) > 0) {
                $arr 		= $this->dbObj->fetchAssoc($rs);
                $totalDays 	= $arr[0]['totalDays'];
                if($totalDays < 30) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }


	function fun_getPendingApprovalUpdatedPropertyArr($parameter=''){
		$sql = "SELECT 	A.property_id, 
						A.property_name,
						A.status,
						FROM_UNIXTIME(A.statuschanged_on, '%m/%d/%Y') AS statuschanged_on,
						FROM_UNIXTIME(A.created_on, '%m/%d/%Y') AS created_on,
						FROM_UNIXTIME(A.updated_on, '%m/%d/%Y') AS updated_on,
						FROM_UNIXTIME(A.active_on, '%m/%d/%Y') AS active_on,
						B.owner_id, 
						C.status_name, 
						D.user_fname, 
						D.user_lname
				FROM " . TABLE_PROPERTY . " AS A  
				LEFT JOIN " . TABLE_PROPERTY_OWNER_RELATIONS . " AS B ON A.property_id = B.property_id
				LEFT JOIN " . TABLE_PROPERTY_STATUS . " AS C ON A.status = C.status_id,

				".TABLE_USERS." AS D
				WHERE D.user_id=B.owner_id AND 
				(A.updated_on >= A.created_on) AND 
				(DATEDIFF(FROM_UNIXTIME(A.updated_on, '%Y-%m-%d'), FROM_UNIXTIME(A.created_on, '%Y-%m-%d')) >= 8)
				";
		if($parameter!=""){
			$sql .= $parameter;		
		} else {
			$sql .= "ORDER BY A.created_on DESC";		
		}		
		//echo $sql;
		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			return $arr = $this->dbObj->fetchAssoc($rs);
		} else {
			return false;
		}
	}

	function fun_getPendingApprovalSuspendedPropertyArr($parameter=''){
		$sql = "SELECT 	A.property_id, 
						A.property_name,
						A.status,
						FROM_UNIXTIME(A.statuschanged_on, '%m/%d/%Y') AS statuschanged_on,
						FROM_UNIXTIME(A.created_on, '%m/%d/%Y') AS created_on,
						FROM_UNIXTIME(A.updated_on, '%m/%d/%Y') AS updated_on,
						FROM_UNIXTIME(A.active_on, '%m/%d/%Y') AS active_on,
						B.owner_id, 
						C.status_name, 
						D.user_fname, 
						D.user_lname
				FROM " . TABLE_PROPERTY . " AS A  
				LEFT JOIN " . TABLE_PROPERTY_OWNER_RELATIONS . " AS B ON A.property_id = B.property_id
				LEFT JOIN " . TABLE_PROPERTY_STATUS . " AS C ON A.status = C.status_id,
				".TABLE_USERS." AS D
				WHERE D.user_id=B.owner_id AND 
				(A.status ='4') ";
		if($parameter!=""){
			$sql .= $parameter;		
		} else {
			$sql .= " ORDER BY A.created_on DESC";		
		}		
//echo $sql;

		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			return $arr = $this->dbObj->fetchAssoc($rs);
		} else {
			return false;
		}
	}

	// Function for owner property array
	function fun_getPropertyOwnerArr($owner_id){
		$sql = "SELECT A.property_id, B.property_name FROM " . TABLE_PROPERTY_OWNER_RELATIONS . " AS A  INNER JOIN " . TABLE_PROPERTY . " AS B ON A.property_id = B.property_id WHERE A.owner_id='".$owner_id."' ORDER BY A.property_id";		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			return $arr = $this->dbObj->fetchAssoc($rs);
		} else {
			return false;
		}
	}

	// This function will Return Property information in array with front end data
	function fun_getOwnerPropertiesArr($owner_id, $parameter = ''){
        if($owner_id == "") {
            return false;
        } else {
            $sql = "SELECT A.property_id, 
						B.property_name,
						B.property_title,
						B.status,
						B.rating,
						B.friendly_link,
						B.created_on,
						B.created_by,
						B.active_on,
						B.active_by,
						B.updated_on,
						B.updated_by,
						B.featured,
						B.active
                    FROM " . TABLE_PROPERTY_OWNER_RELATIONS . " AS A 
                    INNER JOIN " . TABLE_PROPERTY . " AS B ON A.property_id = B.property_id 
                    WHERE A.owner_id='".$owner_id."'";
            if($parameter != ""){
                $sql .= $parameter;
            } else {
                $sql .= " ORDER BY A.property_id";		
            }
            return $rs = $this->dbObj->createRecordset($sql);
        }
	}

	// Function for hot property array
	function fun_getHotPropertyArr(){
		$sql = "SELECT  A.property_id, 
						B.property_name,
						B.property_title,
						C.pt_title as property_type
				FROM " . TABLE_PROPERTY_HOT_RELATIONS . " AS A  
				INNER JOIN " . TABLE_PROPERTY . " AS B ON A.property_id = B.property_id, 
				" . TABLE_PROPERTY_TYPE . " AS C
				WHERE A.status='2' AND A.start_date < NOW() AND (A.start_date + INTERVAL A.total_weeks WEEK) > NOW() AND B.active='1' AND B.status='2' AND C.pt_id = B.property_type 
				ORDER BY RAND()";		
		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			return $arr = $this->dbObj->fetchAssoc($rs);
		} else {
			return false;
		}
	}

	// Function for new property array
	function fun_getNewPropertyArr(){
		$sql = "SELECT distinct A.property_id, 
						A.property_name,
						A.property_title
				FROM " . TABLE_PROPERTY . " AS A WHERE A.active='1' AND A.status='2' AND (DATEDIFF(NOW() , FROM_UNIXTIME(A.created_on, '%Y-%m-%d')) < 60) AND (DATEDIFF(FROM_UNIXTIME(A.updated_on, '%Y-%m-%d'), FROM_UNIXTIME(A.created_on, '%Y-%m-%d')) < 60) 
				ORDER BY A.created_on";
		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			$arr = $this->dbObj->fetchAssoc($rs);
			return $arr;
		} else {
			return false;
		}
	}

	// Function for populer property array
	function fun_getPopularPropertyArr(){
		$sql = "SELECT distinct A.property_id, 
						A.property_name,
						A.property_title
				FROM " . TABLE_PROPERTY . " AS A WHERE A.active='1' AND A.status='2' AND A.property_id IN ( SELECT property_id FROM " . TABLE_PROPERTY_VISIT_RELATIONS . " GROUP BY property_id )  
				ORDER BY A.created_on";
		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			$arr = $this->dbObj->fetchAssoc($rs);
			return $arr;
		} else {
			return false;
		}
	}

	// Function for hot property array
	function fun_getHomeHotPropertyArr(){
/*
		$sql = "SELECT  A.property_id, 
						A.property_hot_id,
						B.property_name,
						B.property_title,
						C.region_name
				FROM " . TABLE_PROPERTY_HOT_RELATIONS . " AS A  
				INNER JOIN " . TABLE_PROPERTY . " AS B ON A.property_id = B.property_id,
				" . TABLE_REGION . " AS C
				WHERE B.active='1' AND B.status='2' AND A.start_date < NOW() AND (A.start_date + INTERVAL A.total_weeks WEEK) > NOW() AND C.region_id = B.region_id
				ORDER BY RAND()";		
*/


		$sql = "SELECT distinct A.property_id, 
						A.property_name,
						A.property_title,
						B.region_name
				FROM " . TABLE_PROPERTY . " AS A ,
				" . TABLE_REGION . " AS B
				WHERE A.active='1' AND A.status='2' AND A.property_id IN ( SELECT property_id FROM " . TABLE_PROPERTY_HOT_RELATIONS . " WHERE start_date < NOW() AND (start_date + INTERVAL total_weeks WEEK) > NOW() AND status ='2' ) AND B.region_id = A.region_id
				ORDER BY RAND()";		

//echo $sql;

		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			$arr = $this->dbObj->fetchAssoc($rs);
			return $arr;
		} else {
			return false;
		}
	}

	// Function for is proeprty featured
	function fun_isPropertyFeatured($property_id){
		if($property_id == ''){
			return false;
		} else {
            $currentdate = date('Y-m-d');
            $sql	= "SELECT A.property_hot_id FROM " . TABLE_PROPERTY_HOT_RELATIONS . " AS A WHERE A.property_id = '".$property_id."' AND A.status ='2' AND (A.start_date < '".$currentdate."' OR  A.start_date = '".$currentdate."') AND (DATE_ADD(A.start_date, INTERVAL A.total_weeks WEEK) > '".$currentdate."')";
           // print_r( $sql);
			$rs 	= $this->dbObj->createRecordset($sql);
            if($this->dbObj->getRecordCount($rs) > 0) {
                return true;
            } else {
                return false;
            }
        }
	}

	// Function for deleting proeprty featured
	function fun_delPropertyFeatured($property_hot_id){
		if($property_hot_id == ''){
			return false;
		} else {
            // Delete from Feature property
            $strDelDealQuery = "DELETE FROM " . TABLE_PROPERTY_HOT_RELATIONS . " WHERE property_hot_id='".$property_hot_id."'";
            $this->dbObj->mySqlSafeQuery($strDelDealQuery);
			return true;
		}
	}
	// Function for deleting proeprty featured

	// This function will Return Enquiry information in array with front end data
	function fun_getOwnerHotPropertyArr($owner_id = '', $parameter = ''){
		$sql	= "SELECT A.property_hot_id, A.property_id, A.start_date, A.total_weeks, A.status
					FROM " . TABLE_PROPERTY_HOT_RELATIONS . " AS A 
					INNER JOIN " . TABLE_PROPERTY_OWNER_RELATIONS . " AS B ON A.property_id = B.property_id
					WHERE A.property_hot_id > 0 ";
        if($owner_id != "") {
			$sql .= "AND B.owner_id = '".$owner_id."'";
        }
		if($parameter != ""){
			$sql .= $parameter;
		} else {
			$sql .= " ORDER BY A.property_id";		
		}
		return $rs = $this->dbObj->createRecordset($sql);
	}

	/*	
	// This function will Return Enquiry information in array with front end data
	function fun_getHotPropertyInfo($property_hot_id){
		$sql = "SELECT A.property_hot_id, A.property_id, A.start_date, A.total_weeks, A.status FROM " . TABLE_PROPERTY_HOT_RELATIONS . " AS A WHERE A.property_hot_id = ".$property_hot_id."";
		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			$arr = $this->dbObj->fetchAssoc($rs);
			return $arr[0];
		} else {
			return false;
		}
	}
	*/

	function fun_getPendingApprovalHotPropertyArr($parameter=''){
		$sql	= "SELECT A.property_hot_id, A.property_id, A.start_date, A.total_weeks, A.status, C.property_name
					FROM " . TABLE_PROPERTY_HOT_RELATIONS . " AS A 
					INNER JOIN " . TABLE_PROPERTY_OWNER_RELATIONS . " AS B ON A.property_id = B.property_id
					INNER JOIN " . TABLE_PROPERTY . " AS C ON A.property_id = C.property_id
					WHERE A.property_hot_id > 0 AND (DATEDIFF(NOW() , FROM_UNIXTIME(A.created_on, '%Y-%m-%d')) < 8)";
		if($parameter != ""){
			$sql .= $parameter;
		} else {
			$sql .= " ORDER BY A.property_id";		
		}

		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			return $arr = $this->dbObj->fetchAssoc($rs);
		} else {
			return false;
		}
	}


	function fun_getCollateralHotPropertyArr($parameter=''){
		$sql	= "SELECT A.property_hot_id, A.property_id, A.start_date, A.total_weeks, A.status, C.property_name
					FROM " . TABLE_PROPERTY_HOT_RELATIONS . " AS A 
					INNER JOIN " . TABLE_PROPERTY_OWNER_RELATIONS . " AS B ON A.property_id = B.property_id
					INNER JOIN " . TABLE_PROPERTY . " AS C ON A.property_id = C.property_id
					WHERE A.property_hot_id > 0 ";
		if($parameter != ""){
			$sql .= $parameter;
		} else {
			$sql .= " ORDER BY A.property_id";		
		}
		//echo $sql;
		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			return $arr = $this->dbObj->fetchAssoc($rs);
		} else {
			return false;
		}
	}

	// Function for tags array
	function fun_getCollateralTagsArr($parameter=''){
		$sql = "SELECT 	A.* FROM " . TABLE_TAGS . " AS A ";
		if($parameter!=""){
			$sql .= $parameter;
		} else {
			$sql .= " ORDER BY A.updated_on DESC";		
		}
	//	echo $sql;
		$rs = $this->dbObj->createRecordset($sql);
        return $arr = $this->dbObj->fetchAssoc($rs);
	}

	// This function will Return tag  information in array with front end data	
	function fun_getTagInfo($id){		
		$sql 	= "SELECT * FROM " . TABLE_TAGS . " WHERE id='".$id."'";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr 	= $this->dbObj->fetchAssoc($rs);
			return $arr[0];
		} else {
			return false;
		}
	}

	function fun_getPendingApprovalLateDealsArr($parameter = '') {
		$sql = "SELECT 
				A.id,
				A.property_id,
				A.special_deal_type,
				FROM_UNIXTIME(A.start_on, '%m/%d/%Y') AS start_on,
				FROM_UNIXTIME(A.end_on, '%m/%d/%Y') AS end_on,
				A.original_price,
				A.sale_price,
				A.created_on,
				A.created_by,
				A.updated_on,
				A.updated_by,
				A.remove_from,
				A.status
				FROM " . TABLE_PROPERTY_SPECIAL_DEALS_RELATIONS . " AS A ";
//		$sql .= " WHERE A.id > 0 ";
//		$sql .= " AND A.status='2' ";
//		$sql .= " AND C.active='1' ";

		if($parameter != ""){
			$sql .= $parameter;
		} else {
			$sql .= " ORDER BY A.created_on DESC";
		}
	//	echo $sql;
		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			return $arr = $this->dbObj->fetchAssoc($rs);
		} else {
			return false;
		}

	}

	function fun_getHotPropertyInfo($property_hot_id){
		$sql	= "SELECT A.property_hot_id, A.property_id, A.start_date, A.total_weeks, A.status, C.property_name
					FROM " . TABLE_PROPERTY_HOT_RELATIONS . " AS A 
					INNER JOIN " . TABLE_PROPERTY_OWNER_RELATIONS . " AS B ON A.property_id = B.property_id
					INNER JOIN " . TABLE_PROPERTY . " AS C ON A.property_id = C.property_id
					WHERE A.property_hot_id = '".$property_hot_id."'";
		//echo $sql;
		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			$arr = $this->dbObj->fetchAssoc($rs);
			return $arr[0];
		} else {
			return false;
		}
	}

	// This function will Return Enquiry information in array with front end data
	function fun_countOwnerHotProperty($owner_id = ''){
		$sql	= "SELECT A.property_hot_id, A.property_id, A.start_date, A.total_weeks, A.status
					FROM " . TABLE_PROPERTY_HOT_RELATIONS . " AS A 
					INNER JOIN " . TABLE_PROPERTY_OWNER_RELATIONS . " AS B ON A.property_id = B.property_id
					WHERE A.property_hot_id > 0 ";
        if($owner_id != "") {
			$sql .= "AND B.owner_id = '".$owner_id."'";
        }
		$rs = $this->dbObj->createRecordset($sql);
		return $this->dbObj->getRecordCount($rs);
	}

	// Function for hot property array
	function fun_addHotProperty($property_id, $start_date, $total_weeks) {
        $status = "1";
        $cur_unixtime 		= time ();
		if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !="") {
			$cur_user_id 	= $_SESSION['ses_admin_id'];
		} else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !="") {
			$cur_user_id 	= $_SESSION['ses_modarator_id'];
		} else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !="") {
			$cur_user_id 	= $_SESSION['ses_user_id'];
		} else {
			$cur_user_id 	= "";
		}

        $field_names 			= array("property_id", "start_date", "total_weeks", "status", "created_on", "created_by", "updated_on", "updated_by");
        $field_values 			= array(fun_db_input($property_id), fun_db_input($start_date), fun_db_input($total_weeks), fun_db_input($status), fun_db_input($cur_unixtime), fun_db_input($cur_user_id), fun_db_input($cur_unixtime), fun_db_input($cur_user_id));
        $this->dbObj->insertFields(TABLE_PROPERTY_HOT_RELATIONS, $field_names, $field_values);
        $property_hot_id 			= $this->dbObj->getIdentity();
        return $property_hot_id;
	}

	// Function for hot property array
	function fun_editHotProperty($property_hot_id, $property_id, $start_date, $total_weeks, $status) {
        $cur_unixtime 		= time ();
		if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !="") {
			$cur_user_id 	= $_SESSION['ses_admin_id'];
		} else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !="") {
			$cur_user_id 	= $_SESSION['ses_modarator_id'];
		} else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !="") {
			$cur_user_id 	= $_SESSION['ses_user_id'];
		} else {
			$cur_user_id 	= "";
		}

        $field_names 			= array("property_id", "start_date", "total_weeks", "status", "updated_on", "updated_by");
        $field_values 			= array(fun_db_input($property_id), fun_db_input($start_date), fun_db_input($total_weeks), fun_db_input($status), fun_db_input($cur_unixtime), fun_db_input($cur_user_id));
        $this->dbObj->updateFields(TABLE_PROPERTY_HOT_RELATIONS, "property_hot_id", $property_hot_id, $field_names, $field_values);
        return $property_hot_id;
	}

	// Function for creating array of bedroom text
	function fun_getPropertyBedOptionsArray(){		
		$sql = "SELECT * FROM " . TABLE_PROPERTY_BEDROOM . " ORDER BY option_id";		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			return $arr = $this->dbObj->fetchAssoc($rs);
		} else {
			return false;
		}
	}

	// Function for creating array of bathroom text
	function fun_getPropertyBathOptionsArray(){		
		$sql = "SELECT * FROM " . TABLE_PROPERTY_BATHROOM . " ORDER BY option_id";
		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			return $arr = $this->dbObj->fetchAssoc($rs);
		} else {
			return false;
		}
	}

	// Function for creating array of property contact languages
	function fun_getPropertyContactLanguageArr($property_id){		
		$sql = "SELECT * FROM " . TABLE_PROPERTY_CONTACT_LANGUAGES . " WHERE property_id ='".$property_id."' ORDER BY id";
		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			return $arr = $this->dbObj->fetchAssoc($rs);
		} else {
			return false;
		}
	}

	// Function for creating array of property contact numbers
	function fun_getPropertyContactNumberArr($property_id){		
		$sql = "SELECT * FROM " . TABLE_PROPERTY_CONTACT_NUMBERS . " WHERE property_id ='".$property_id."' ORDER BY id";		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			return $arr = $this->dbObj->fetchAssoc($rs);
		} else {
			return false;
		}
	}


	// Function for creating array of property prices
	function fun_getPropertyPricesArr($property_id){
		/*
		$sql = "SELECT 
				A.id,
				A.price_name,
				A.property_id,
				FROM_UNIXTIME(A.date_from, '%m/%d/%Y') AS date_from,
				FROM_UNIXTIME(A.date_to, '%m/%d/%Y') AS date_to,
				A.min_stay,
				A.min_stay_type,
				A.per_month_price,
				A.per_week_price,
				A.per_night_midweek_price,
				A.per_night_weekend_price,
				A.currency_code,
				A.special_offer,
				A.price_type 
				FROM " . TABLE_PROPERTY_PRICES . " AS A 
				WHERE A.property_id ='".$property_id."' 
				ORDER BY A.date_from";
				*/

		$sql = "SELECT 
				A.id,
				A.price_name,
				A.property_id,
				A.date_from,
				A.date_to,
				A.min_stay,
				A.min_stay_type,
				A.per_month_price,
				A.per_week_price,
				A.per_night_midweek_price,
				A.per_night_weekend_price,
				A.currency_code,
				A.special_offer,
				A.price_type 
				FROM " . TABLE_PROPERTY_PRICES . " AS A 
				WHERE A.property_id ='".$property_id."' 
				ORDER BY A.date_from";
		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			return $arr = $this->dbObj->fetchAssoc($rs);
		} else {
			return false;
		}
}

	// This function will Return price notes of property
	function fun_getPropertyPriceNotes($property_id){
		if($property_id ==""){
			return "";
		}
		else{
			if(($property_price_note_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_PRICE_NOTES , " WHERE property_id='".$property_id."'")) && (is_array($property_price_note_array))){
				return $property_price_note_array[0]['price_notes'];
			}
			else{
				return "";
			}
		}
	}


	// Function for creating array of availability
	function fun_getAvailabilityArr(){		
		$sql = "SELECT * FROM " . TABLE_PROPERTY_AVAILABILITY . " ORDER BY availability_id";
		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			return $arr = $this->dbObj->fetchAssoc($rs);
		} else {
			return false;
		}
	}

	/*
	* Function for creating array of landmarks : start here
	*/
	function fun_getPropertyLandmarkArr(){		
		$sql = "SELECT * FROM " . TABLE_PROPERTY_LANDMARKS . " ORDER BY landmark_id";
		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			return $arr = $this->dbObj->fetchAssoc($rs);
		} else {
			return false;
		}
	}
	/*
	* Function for creating array of landmarks : end here
	*/

	/*
	* Function for finding landmark distance info : start here
	*/
	function fun_getPropertyLandmarkDistanceInfo($property_id, $landmark_id = ''){		
		if($property_id == "") {
			return false;
		} else {
			if(($landmark_id !='') && ($landmark_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_LANDMARK_RELATIONS , " WHERE property_id='".$property_id."' AND landmark_id = '".$landmark_id."'")) && (is_array($landmark_array))){
				return $landmark_array;
			} else if(($landmark_id =='') && ($landmark_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_LANDMARK_RELATIONS , " WHERE property_id='".$property_id."'")) && (is_array($landmark_array))){
				return $landmark_array;
			} else {
				return false;
			}
		}	
	}
	/*
	* Function for finding landmark distance info : end here
	*/

	/*
	* Function for finding landmark distance type : start here
	*/
	function fun_getPropertyLandmarkDistanceType($property_id){		
		$sqlLandmarksIds 	= "SELECT distance_type FROM " . TABLE_PROPERTY_LANDMARK_RELATIONS . " WHERE property_id='".$property_id."' LIMIT 0,1";
		$rsLandmarks 		= $this->dbObj->createRecordset($sqlLandmarksIds);
		$arrLandmarks 		= $this->dbObj->fetchAssoc($rsLandmarks);
		if($arrLandmarks[0]['distance_type'] != "") {
			return 	trim($arrLandmarks[0]['distance_type']);
		} else {
			return 	"k";
		}
	}
	/*
	* Function for finding landmark distance type : end here
	*/

	function fun_updateLandmarkDistanceType($property_id, $distance_type = ''){
		if($property_id == '' || $distance_type == ''){
			return false;
		} else {
			$this->dbObj->updateField(TABLE_PROPERTY_LANDMARK_RELATIONS, "property_id", $property_id, "distance_type", $distance_type);
			$this->dbObj->updateField(TABLE_PROPERTY_EXTRA_LANDMARKS, "property_id", $property_id, "distance_type", $distance_type);
			return true;
		}
	}

	/*
	* Function for creating array of special deals for property : Start here
	*/
	function fun_getPropertyTopLateDealArr($property_id= ''){
        $sql = "SELECT 
                A.id,
                A.property_id,
                A.special_deal_type,
                A.start_on,
                A.end_on,
                A.original_price,
                A.sale_price,
				A.min_stay,
				A.min_stay_type,
                A.created_on,
                A.created_by,
                A.updated_on,
                A.updated_by,
                A.remove_from,
                A.status
                FROM " . TABLE_PROPERTY_SPECIAL_DEALS_RELATIONS . " AS A ";
		$sql .= " WHERE A.id > 0 ";
		$sql .= " AND A.status='2' ";
		$sql .= " AND A.end_on>UNIX_TIMESTAMP() ";
		$sql .= " AND A.property_id='".$property_id."' ";
		//echo $sql;
		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			$arr = $this->dbObj->fetchAssoc($rs);
			return $arr[0];
		} else {
			return false;
		}
	}
	/*
	* Function for creating array of special deals for property : End here
	*/

	/*
	* Function for creating array of property for holiday special deals : Start here
	*/
	function fun_getPropertyDeals4HolidayArr($txtPropertyArea = '', $txtPropertyRegion = '', $txtPropertySubRegion = '', $txtPropertyLocation = '', $txtFromUnixTime = '', $txtToUnixTime = '', $parameter = ''){		
			$sql = "SELECT 
					A.id, 
					A.property_id, 
					A.special_deal_type, 
					A.start_on, 
					A.end_on, 
					A.original_price, 
					A.sale_price, 
					A.min_stay,
					A.min_stay_type,
					A.created_on, 
					A.created_by, 
					A.updated_on, 
					A.updated_by, 
					A.remove_from, 
					A.status, 
					B.property_name, 
					B.property_title, 
					B.property_summary, 
					B.active, 
					B.location_id, 
					B.status 
					FROM mc_property_special_deals_relations AS A 
					INNER JOIN mc_property AS B ON A.property_id = B.property_id";
			$sql .= " WHERE A.id > 0 ";
			$sql .= " AND A.status='2' ";
			$sql .= " AND B.active='1' ";
		
		if($txtPropertyArea != "") {
//		$sql .= " AND C.active='1' ";
		}

		if($txtPropertyRegion != "") {
//			$sql .= " AND C.region_id='".$txtPropertyRegion."' ";
		}
		if($txtPropertySubRegion != "") {
//			$sql .= " AND C.subregion_id='".$txtPropertySubRegion."' ";
		}
		if($txtPropertyLocation != "") {
//			$sql .= " AND C.location_id='".$txtPropertyLocation."' ";
		}

		if($txtFromUnixTime != "") {
			$sql .= " AND A.start_on >= '".$txtFromUnixTime."' ";
		}
		if($txtToUnixTime != "") {
			$sql .= " AND A.end_on <= '".$txtToUnixTime."' ";
		}

//		$sql .= " AND D.location_id = C.location_id ";
		if($parameter != ""){
			$sql .= " $parameter";
		} else {
			$sql .= " ORDER BY (A.original_price - A.sale_price), A.start_on";
		}
//echo $sql;

		return $rs = $this->dbObj->createRecordset($sql);
	}
	/*
	* Function for creating array of property  for holiday special deals : End here
	*/

	/*
	* Function for creating array of property special deals : Start here
	*/
	function fun_getPropertyDealsArr($property_id = '', $deal_id = ''){		
		$sql = "SELECT 
				A.id,
				A.property_id,
                A.special_deal_type,
                A.special_deal_title,
                A.special_deal_desc,
				A.start_on,
				A.end_on,
				A.original_price,
				A.sale_price,
				A.min_stay,
				A.min_stay_type,
				A.created_on,
				A.created_by,
				A.updated_on,
				A.updated_by,
				A.remove_from,
				A.status 
				FROM " . TABLE_PROPERTY_SPECIAL_DEALS_RELATIONS . " AS A 
				WHERE A.id > 0 ";

		if($property_id != "") {
		$sql .= " AND A.property_id ='".$property_id."' ";
		}

		if($deal_id != "") {
		$sql .= " AND A.id ='".$deal_id."' ";
		}

		$sql .= " ORDER BY A.id";		
		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			return $arr = $this->dbObj->fetchAssoc($rs);

		} else {
			return false;
		}
	}
	/*
	* Function for creating array of property special deals : End here
	*/

	/*
	* Function for creating array of property special deals : Start here
	*/
	function fun_getPropertyDealsShowArr($property_id = '', $deal_id = ''){		
		if((isset($_SESSION['ses_admin_id']) && ($_SESSION['ses_admin_id'] !="")) || (isset($_SESSION['ses_modarator_id']) && ($_SESSION['ses_modarator_id'] !=""))){
		$sql = "SELECT 
				A.id,
				A.property_id,
                A.special_deal_type,
                A.special_deal_title,
                A.special_deal_desc,
				A.start_on,
				A.end_on,
				A.original_price,
				A.sale_price,
				A.min_stay,
				A.min_stay_type,
				A.created_on,
				A.created_by,
				A.updated_on,
				A.updated_by,
				A.remove_from,
				A.status 
				FROM " . TABLE_PROPERTY_SPECIAL_DEALS_RELATIONS . " AS A 
				WHERE A.id > 0 ";

		} else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !=""){
			$cur_user_id 	= $_SESSION['ses_user_id'];
			$sql = "SELECT 
					A.id,
					A.property_id,
					A.special_deal_type,
					A.special_deal_title,
					A.special_deal_desc,
					A.start_on,
					A.end_on,
					A.original_price,
					A.sale_price,
					A.min_stay,
					A.min_stay_type,
					A.created_on,
					A.created_by,
					A.updated_on,
					A.updated_by,
					A.remove_from,
					A.status 
					FROM " . TABLE_PROPERTY_SPECIAL_DEALS_RELATIONS . " AS A 
					INNER JOIN " . TABLE_PROPERTY_OWNER_RELATIONS . " AS B ON A.property_id = B.property_id 
					WHERE A.id > 0 AND B.owner_id='".$cur_user_id."'";
		} else {
			return false;
		}

		if($property_id != "") {
			$sql .= " AND A.property_id ='".$property_id."' ";
		}
		if($deal_id != "") {
			$sql .= " AND A.id ='".$deal_id."' ";
		}

		$sql .= " ORDER BY A.id";

		$rs = $this->dbObj->createRecordset($sql);
		$arr = $this->dbObj->fetchAssoc($rs);
//		echo count($arr);
		return $arr;
/*
		$j = 0;
		for($i = 0; $i < count($arr); $i++) {
			$removeDealType = $arr[$i]['remove_from'];
			switch($removeDealType) {
				case 's':
					if(strtotime($arr[$i]['start_on']) > time ()) {
						$arr1[$j] 				= $arr[$i];
						$j++;
					}
				break;

				case 'e':
						$dayafterUnix 			= mktime(0,0,0,date('m'),date('d')+1,date('Y'));
						$arr[$i]['start_on'] 	= date('m/d/Y', $dayafterUnix);
						$arr1[$j] 				= $arr[$i];
						$j++;
				break;
			}
		}
*/
//		print_r($arr1);
//		return $arr1;
	}


	function fun_getOwnerPropertyDealsShowArr($owner_id, $property_id = '', $deal_id = ''){		
		$sql = "SELECT 
				A.id,
				A.property_id,
				A.special_deal_type,
				A.special_deal_title,
				A.special_deal_desc,
				A.start_on,
				A.end_on,
				A.original_price,
				A.sale_price,
				A.min_stay,
				A.min_stay_type,
				A.created_on,
				A.created_by,
				A.updated_on,
				A.updated_by,
				A.remove_from,
				A.status 
				FROM " . TABLE_PROPERTY_SPECIAL_DEALS_RELATIONS . " AS A 
				INNER JOIN " . TABLE_PROPERTY_OWNER_RELATIONS . " AS B ON A.property_id = B.property_id 
				WHERE A.id > 0 AND B.owner_id='".$owner_id."'";

		if($property_id != "") {
			$sql .= " AND A.property_id ='".$property_id."' ";
		}
		if($deal_id != "") {
			$sql .= " AND A.id ='".$deal_id."' ";
		}

		$sql .= " ORDER BY A.id";
		$rs = $this->dbObj->createRecordset($sql);
		$arr = $this->dbObj->fetchAssoc($rs);
		return $arr;
	}

	/*
	* Function for creating array of property special deals : End here
	*/

	/*
	* Function for creating array of property special deals : Start here
	*/
	function fun_getPropertyDealsHolidayShowArr($property_id = '', $deal_id = '',  $pregion_id = '', $region_id = '', $location_id = '', $txtExactNumber = '', $strUnixDateFrom = '', $strUnixDateTo = ''){		
			$sql = "SELECT 
					A.id,
					A.property_id,
					A.special_deal_type,
					A.special_deal_title,
					A.special_deal_desc,
					A.start_on,
					A.end_on,
					A.original_price,
					A.sale_price,
					A.min_stay,
					A.min_stay_type,
					A.created_on,
					A.created_by,
					A.updated_on,
					A.updated_by,
					A.remove_from,
					A.status,
					C.active
					FROM " . TABLE_PROPERTY_SPECIAL_DEALS_RELATIONS . " AS A 
					INNER JOIN " . TABLE_PROPERTY_OWNER_RELATIONS . " AS B ON A.property_id = B.property_id 
					INNER JOIN " . TABLE_PROPERTY . " AS C ON A.property_id = C.property_id 
					WHERE A.id > 0 AND A.status='2' AND C.active='1' AND  A.start_on > UNIX_TIMESTAMP()";

		if($property_id != "") {
		$sql .= " AND A.property_id ='".$property_id."' ";
		}

		if($deal_id != "") {
		$sql .= " AND A.id ='".$deal_id."' ";
		}

		if($pregion_id != "") {
		$sql .= " AND C.region_id ='".$pregion_id."' ";
		}

		if($region_id != "") {
		$sql .= " AND C.subregion_id ='".$region_id."' ";
		}

		if($location_id != "") {
		$sql .= " AND C.location_id ='".$location_id."' ";
		}

		if($strUnixDateFrom != "") {
		$sql .= " AND A.start_on > '".$strUnixDateFrom."' ";
		}

		if($strUnixDateTo != "") {
		$sql .= " AND A.end_on < '".$strUnixDateTo."' ";
		}

		$sql .= " ORDER BY A.id";

		$rs = $this->dbObj->createRecordset($sql);
		$arr = $this->dbObj->fetchAssoc($rs);
		return $arr;
	}
	/*
	* Function for creating array of property special deals : End here
	*/

	/*
	* Function for creating array of property special deals for home : Start here
	*/

	function fun_getPropertyDeals4HomeArr(){		
			$sql = "SELECT 
					A.id,
					A.property_id,
					A.special_deal_type,
					A.start_on,
					A.end_on,
					A.original_price,
					A.sale_price,
					A.min_stay,
					A.min_stay_type,
					A.created_on,
					A.created_by,
					A.updated_on,
					A.updated_by,
					A.remove_from,
					A.status,
					B.property_name, 
					B.property_title, 
					C.pt_title as property_type, 
					D.region_name
					FROM " . TABLE_PROPERTY_SPECIAL_DEALS_RELATIONS . " AS A 
					INNER JOIN " . TABLE_PROPERTY . " AS B ON A.property_id = B.property_id,
					" . TABLE_PROPERTY_TYPE . " AS C,
					" . TABLE_REGION . " AS D";
		$sql .= " WHERE A.status='2' ";
		$sql .= " AND A.start_on < unix_timestamp(now()) ";
		$sql .= " AND A.end_on > unix_timestamp(now()) ";
		$sql .= " AND B.active='1' ";
		$sql .= " AND B.status='2' ";
		$sql .= " AND C.pt_id = B.property_type ";
		$sql .= " AND D.region_id = B.region_id ";
		$sql .= " ORDER BY (A.original_price - A.sale_price), A.start_on";

		//echo $sql;
		$rs = $this->dbObj->createRecordset($sql);
		$arr = $this->dbObj->fetchAssoc($rs);
		return $arr;
	}
	/*
	* Function for creating array of property special deals  for home : End here
	*/

	// Function for creating array of availability
	function fun_getContactNoTypeArr(){		
		$sql = "SELECT * FROM " . TABLE_CONTACT_NO_TYPE . " ORDER BY no_type_id";		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			return $arr = $this->dbObj->fetchAssoc($rs);
		} else {
			return false;
		}
	}



	// Function for creating optionlist for languages if language_id is available it must be selected
	function fun_getLanguagesOptionsList($language_id=''){		
		$selected = "";
		$sql = "SELECT * FROM " . TABLE_LANGUAGES. " ORDER BY language_name";
		$result = $this->dbObj->fun_db_query($sql);
		while($rowsCon = $this->dbObj->fun_db_fetch_rs_object($result)){
			if($rowsCon->language_id == $language_id  && $language_id!=''){
				$selected = " selected";
			}else{
				$selected = "";
			}
			echo "<option value=".fun_db_output($rowsCon->language_id)."" .$selected. ">";
			echo fun_db_output(ucwords($rowsCon->language_name));
			echo "</option>";
		}
		$this->dbObj->fun_db_free_resultset($result);
	}

	// Function for count property of a area
	function fun_countPropertyByCountryId($countries_id){		
		$total_properties = 0;
		if($countries_id == "") {
			return $total_properties;
		} else {
			//Step I: select areas of that country
			if(($area_relation_array = $this->fun_findPropertyRelationInfo(TABLE_AREA , " WHERE country_id ='".$countries_id."'")) && (is_array($area_relation_array))){
				$areaidsByCountryArr		= array();
				for($i = 0; $i < count($area_relation_array); $i++) {
					array_push($areaidsByCountryArr, "'".$area_relation_array[$i]['area_id']."'");
				}
				$areaids = implode(",", array_unique($areaidsByCountryArr));
				//Step II: select regions of that area
				if(($region_relation_array = $this->fun_findPropertyRelationInfo(TABLE_REGION , " WHERE area_id IN (".$areaids.")")) && (is_array($region_relation_array))){
					$regionidsByCountryArr		= array();
					for($j = 0; $j < count($region_relation_array); $j++) {
						array_push($regionidsByCountryArr, "'".$region_relation_array[$j]['region_id']."'");
					}
					$regionids = implode(",", array_unique($regionidsByCountryArr));
					//Step III: select locations of that region
					if(($regionids != "") && ($loc_relation_array = $this->fun_findPropertyRelationInfo(TABLE_LOCATION , " WHERE region_id IN (".$regionids.")")) && (is_array($loc_relation_array))){
						$locationidsArr		= array();
						for($j = 0; $j < count($loc_relation_array); $j++) {
							array_push($locationidsArr, "'".$loc_relation_array[$j]['location_id']."'");
						}
						$locationids = implode(",", array_unique($locationidsArr));
					}
				}
			}
			if(isset($locationids) && $locationids != "") {
				$sql 	= "SELECT COUNT(*) total_result FROM  " . TABLE_PROPERTY . " WHERE location_id IN (".$locationids.") AND active='1'";
				$rs 	= $this->dbObj->createRecordset($sql);
				if($this->dbObj->getRecordCount($rs) > 0){
					$arr = $this->dbObj->fetchAssoc($rs);
					$total_properties = $arr[0]['total_result'];
				}
				else{
					$total_properties = 0;
				}
			}
			return $total_properties;
		}
	}

	// Function for creating optionlist for countries with total no. of properties if country_id is available it must be selected
	function fun_getCountriesListOptionsWithTotalProp($countries_id = ''){		
		$selected = "";
		$sql = "SELECT * FROM " . TABLE_COUNTRIES. " ORDER BY countries_name";
		$result = $this->dbObj->fun_db_query($sql);
		while($rowsCon = $this->dbObj->fun_db_fetch_rs_object($result)){
			if($rowsCon->countries_id == $countries_id  && $countries_id!=''){
				$selected = "selected";
			}else{
				$selected = "";
			}
			echo "<option value=\"".fun_db_output($rowsCon->countries_id)."\" " .$selected. ">";
			echo fun_db_output(ucwords($rowsCon->countries_name))." (".$this->fun_countPropertyByCountryId($rowsCon->countries_id).")";
			echo "</option>\n";
		}
		$this->dbObj->fun_db_free_resultset($result);
	}


	// Function for creating optionlist for countries if country_id is available it must be selected
	function fun_getCountriesOptionsList($countries_id=''){		
		$selected = "";
		$sql = "SELECT * FROM " . TABLE_COUNTRIES. " ORDER BY countries_name";
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

	// Function for creating optionlist for countries if country_id is available it must be selected
	function fun_getPropertyCountriesOptionsList($countries_id='', $queryparameters=''){		
		$selected = "";
		$sql = "SELECT * FROM " . TABLE_COUNTRIES. " ";
		if($queryparameters !=""){
			$sql .= " ".$queryparameters." AND countries_id IN (SELECT distinct country_id FROM " . TABLE_PROPERTY . " WHERE active='1' AND status='2') ORDER BY countries_name";
		} else {
			$sql .= " WHERE countries_id IN (SELECT distinct country_id FROM " . TABLE_PROPERTY . " WHERE active='1' AND status='2') ORDER BY countries_name";
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

	// Function for creating area option list, if area id is given it must be selected
	function fun_getPropertyAreaListOptions($area_id='', $country_id=''){		
		$selected = "";
		$where = array();

		$sql = "SELECT * FROM " . TABLE_AREA . " ";
		if($country_id !=""){
			array_push($where, "country_id='".(int)fun_db_input($country_id)."' ");
		}
		array_push($where, "area_id IN (SELECT distinct area_id FROM " . TABLE_PROPERTY . " WHERE active='1' AND status='2') ");
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

	// Function for creating region option list, if region id is given it must be selected
	function fun_getPropertyRegionListOptions($region_id='', $pregion_id='', $area_id=''){		
		$selected = "";
		$where = array();

		$sql = "SELECT * FROM " . TABLE_REGION . " ";
		if($pregion_id !=""){
			array_push($where, "pregion_id='".(int)fun_db_input($pregion_id)."' ");
		}
		if($area_id !=""){
			array_push($where, "area_id='".(int)fun_db_input($area_id)."' ");
		}
		array_push($where, "((region_id IN (SELECT distinct region_id FROM " . TABLE_PROPERTY . " WHERE active='1' AND status='2')) OR (region_id IN (SELECT distinct subregion_id FROM " . TABLE_PROPERTY . " WHERE active='1' AND status='2'))) ");

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

	// Function for creating optionlist for countries if country_id is available it must be selected
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
				$selected = " selected";
			}else{
				$selected = "";
			}
			echo "<option value=".fun_db_output($rowsCon->countries_id)."" .$selected. ">";
			echo fun_db_output(ucwords($rowsCon->countries_name));
			if($rowsCon->countries_isd_code != "0"){
			echo " (+".fun_db_output(ucwords($rowsCon->countries_isd_code)).")";
			}
			echo "</option>";
		}
		$this->dbObj->fun_db_free_resultset($result);
	}

	// Function for creating area with total no. of properties option list, if area id is given it must be selected
	function fun_getAreasArrWithTotalProp($area_id='', $country_id=''){		
		$AreasArr 	= array();		
		$where = array();
		$sql = "SELECT * FROM " . TABLE_AREA . " ";
		if($country_id !=""){
			array_push($where, "country_id='".(int)fun_db_input($country_id)."' ");
		}

		if(sizeof($where) > 0){
			$sql .= " WHERE ".join($where, " AND ");
		}

		$sql .= " ORDER BY area_name";
		$rs		= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			$arr	= $this->dbObj->fetchAssoc($rs);
			for($i = 0; $i < count($arr); $i++) {
				$area_id 							= $arr[$i]['area_id'];
				$area_name 							= $arr[$i]['area_name'];
				$total_property 					= $this->fun_countPropertyByAreaId($area_id);
				$AreasArr[$i]['area_id'] 			= $area_id;
				$AreasArr[$i]['area_name']			= $area_name;
				$AreasArr[$i]['total_properties']	= $total_property;
			}
		}
		return $AreasArr;
	}

	// Function for creating area with total no. of properties option list, if area id is given it must be selected
	function fun_getAreasListOptions($area_id='', $country_id=''){		
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


	// Function for creating area with total no. of properties option list, if area id is given it must be selected
	function fun_getAreasListOptionsWithTotalProp($area_id='', $country_id=''){		
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
			echo fun_db_output(ucwords($rowsCon->area_name))." (".$this->fun_countPropertyByAreaId($rowsCon->area_id).")";
			echo "</option>\n";
		}		
		$this->dbObj->fun_db_free_resultset($result);
	}

	// Function for creating area with total no. of properties option list, if area id is given it must be selected
	function fun_getRegionArrWithTotalProp($region_id='', $pregion_id='', $area_id=''){		

		$RegionArr 	= array();		
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
		$rs		= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			$arr	= $this->dbObj->fetchAssoc($rs);
			for($i = 0; $i < count($arr); $i++) {
				$region_id 							= $arr[$i]['region_id'];
				$region_name 						= $arr[$i]['region_name'];
				$total_property 					= $this->fun_countPropertyByRegionId($region_id);
				$RegionArr[$i]['region_id'] 		= $region_id;
				$RegionArr[$i]['region_name']		= $region_name;
				$RegionArr[$i]['total_properties']	= $total_property;
			}
		}
		return $RegionArr;
	}

	// Function for creating region with total no. of properties option list, if region id is given it must be selected
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

	// Function for creating region with total no. of properties option list, if region id is given it must be selected
	function fun_getRegionListOptionsWithTotalProp($region_id='', $pregion_id='', $area_id=''){		
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
			echo fun_db_output(ucwords($rowsCon->region_name))." (".$this->fun_countPropertyByRegionId($rowsCon->region_id).")";
			echo "</option>\n";
		}		
		$this->dbObj->fun_db_free_resultset($result);
	}

	// Function for creating location with total no. of properties option list, if location id is given it must be selected
	function fun_getLocationListOptions($location_id='', $region_id=''){		
		$selected = "";
		$where = array();

		$sql = "SELECT * FROM " . TABLE_LOCATION . " ";
		if($region_id !=""){
			array_push($where, "region_id='".(int)fun_db_input($region_id)."' ");
		}

		if(sizeof($where) > 0){
			$sql .= " WHERE ".join($where, " AND ");
		}
		$sql .= " ORDER BY location_name";

		$result = $this->dbObj->fun_db_query($sql);
		while($rowsCon = $this->dbObj->fun_db_fetch_rs_object($result)){
			if($rowsCon->location_id == $location_id  && $location_id!=''){
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

	// Function for creating location option list, if location id is given it must be selected
	function fun_getPropertyLocationListOptions($locID='', $region_id='', $pregion_id=''){		
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

		array_push($where, "location_id IN (SELECT distinct location_id FROM " . TABLE_PROPERTY . " WHERE active='1' AND status='2') ");

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

	// Function for creating location with total no. of properties option list, if location id is given it must be selected
	function fun_getLocationListOptionsWithTotalProp($location_id='', $region_id=''){		
		$selected = "";
		$where = array();

		$sql = "SELECT * FROM " . TABLE_LOCATION . " ";
		if($region_id !=""){
			array_push($where, "region_id='".(int)fun_db_input($region_id)."' ");
		}

		if(sizeof($where) > 0){
			$sql .= " WHERE ".join($where, " AND ");
		}
		$sql .= " ORDER BY location_name";

		$result = $this->dbObj->fun_db_query($sql);
		while($rowsCon = $this->dbObj->fun_db_fetch_rs_object($result)){
			if($rowsCon->location_id == $location_id  && $location_id!=''){
				$selected = "selected";
			}else{
				$selected = "";
			}
			echo "<option value=\"".fun_db_output($rowsCon->location_id)."\" " .$selected. ">";
			echo fun_db_output(ucwords($rowsCon->location_name))." (".$this->fun_countPropertyByLocationId($rowsCon->location_id).")";
			echo "</option>\n";
		}		
		$this->dbObj->fun_db_free_resultset($result);
	}

	function fun_getPropertyDestinationMapInfo($destination_name){
		$destinationMapArray = array();

		if(($area_relation_array = $this->fun_findPropertyRelationInfo(TABLE_AREA , " WHERE LOWER(area_name)='".strtolower($destination_name)."'")) && (is_array($area_relation_array))){

			$country_id		= $area_relation_array[0]['country_id'];
			$area_id		= $area_relation_array[0]['area_id'];
			$area_name		= $area_relation_array[0]['area_name'];
			$map_thumb		= $area_relation_array[0]['map_thumb'];
			$map_large		= $area_relation_array[0]['map_large'];

			$AreaArr 		= $this->fun_getAreasArrWithTotalProp($area_id);
			$regionArr 		= $this->fun_getRegionArrWithTotalProp('', '0', $area_id);

			$destinationMapArray['map_img']			= $map_large;
			$destinationMapArray['map_title']		= $area_name;
			$destinationMapArray['map_total_prop']	= $AreaArr[0]['total_properties'];
			for($j = 0; $j < count($regionArr);  $j++) {
				$destinationMapArray['map_region_arr'][$j]['map_region_id'] = $regionArr[$j]['region_id'];
				$destinationMapArray['map_region_arr'][$j]['map_region_name'] = $regionArr[$j]['region_name'];
				$destinationMapArray['map_region_arr'][$j]['total_properties'] = $regionArr[$j]['total_properties'];
			}
			$destinationMapArray['map_p1_img']		= $map_thumb;
			$destinationMapArray['map_p1_title']	= $area_name;
			$destinationMapArray['map_p2_img']		= "africa-south-africa-map.gif";
			$destinationMapArray['map_p2_title']	= "Spain";

			

		} else if(($region_relation_array = $this->fun_findPropertyRelationInfo(TABLE_REGION , " WHERE LOWER(region_name)='".strtolower($destination_name)."'")) && (is_array($region_relation_array))){

			$region_id		= $region_relation_array[0]['region_id'];
			$pregion_id		= $region_relation_array[0]['pregion_id'];
			$area_id		= $region_relation_array[0]['area_id'];
			$region_name	= $region_relation_array[0]['region_name'];
			$map_thumb		= $region_relation_array[0]['map_thumb'];
			$map_large		= $region_relation_array[0]['map_large'];

			$destinationMapArray['map_img']			= $map_large;
			$destinationMapArray['map_title']		= $region_name;
			$destinationMapArray['map_p1_img']		= $map_thumb;
			$destinationMapArray['map_p1_title']	= $region_name;

			$regionArr 		= $this->fun_getRegionArrWithTotalProp($region_id, '', '');
			$destinationMapArray['map_total_prop']	= $regionArr[0]['total_properties'];

			if($pregion_id == "" || $pregion_id == "0") {

				$area_relation_array = $this->fun_findPropertyRelationInfo(TABLE_AREA , " WHERE area_id='".$area_id."'");
				$country_id		= $area_relation_array[0]['country_id'];
				$area_id		= $area_relation_array[0]['area_id'];
				$area_name		= $area_relation_array[0]['area_name'];
				$map_thumb		= $area_relation_array[0]['map_thumb'];
				$map_large		= $area_relation_array[0]['map_large'];

				$subregionArr 	= $this->fun_getRegionArrWithTotalProp('', $region_id, '');
				
				if(count($subregionArr) > 0) {
					for($j = 0; $j < count($subregionArr);  $j++) {
						$destinationMapArray['map_region_arr'][$j]['map_region_id'] = $subregionArr[$j]['region_id'];
						$destinationMapArray['map_region_arr'][$j]['map_region_name'] = $subregionArr[$j]['region_name'];
						$destinationMapArray['map_region_arr'][$j]['total_properties'] = $subregionArr[$j]['total_properties'];
					}
				} else {
					$locationArr	= $this->fun_getLocationArrWithTotalProp('', $region_id);
					for($j = 0; $j < count($locationArr);  $j++) {
						$destinationMapArray['map_location_arr'][$j]['map_location_id'] = $locationArr[$j]['location_id'];
						$destinationMapArray['map_location_arr'][$j]['map_location_name'] = $locationArr[$j]['location_name'];
						$destinationMapArray['map_location_arr'][$j]['total_properties'] = $locationArr[$j]['total_properties'];
					}
				}

				$destinationMapArray['map_p2_img']	= $map_thumb;
				$destinationMapArray['map_p2_title']= $area_name;
			} else {
				$pregion_relation_array = $this->fun_findPropertyRelationInfo(TABLE_REGION , " WHERE region_id='".$pregion_id."'");
				$p_region_id		= $pregion_relation_array[0]['region_id'];
				$p_pregion_id		= $pregion_relation_array[0]['pregion_id'];
				$p_area_id			= $pregion_relation_array[0]['area_id'];
				$p_region_name		= $pregion_relation_array[0]['region_name'];
				$p_map_thumb		= $pregion_relation_array[0]['map_thumb'];
				$p_map_large		= $pregion_relation_array[0]['map_large'];

				$locationArr	= $this->fun_getLocationArrWithTotalProp('', $region_id);
				for($j = 0; $j < count($locationArr);  $j++) {
					$destinationMapArray['map_location_arr'][$j]['map_location_id'] = $locationArr[$j]['location_id'];
					$destinationMapArray['map_location_arr'][$j]['map_location_name'] = $locationArr[$j]['location_name'];
					$destinationMapArray['map_location_arr'][$j]['total_properties'] = $locationArr[$j]['total_properties'];
				}

				$destinationMapArray['map_p2_img']	= $p_map_large;
				$destinationMapArray['map_p2_title']= $p_region_name;
			}
		}
		return $destinationMapArray ;
	}

	// Function for creating optionlist for property_contact_type id if no_type_id id is available it must be selected
	function fun_getPropertyContactNoTypeOptionsList($no_type_id=''){		
		$selected = "";
		$sql = "SELECT * FROM " . TABLE_CONTACT_NO_TYPE. " ORDER BY no_type_id";
		$result = $this->dbObj->fun_db_query($sql);
		while($rowsCon = $this->dbObj->fun_db_fetch_rs_object($result)){
			if($rowsCon->no_type_id == $no_type_id  && $no_type_id!=''){
				$selected = " selected";
			}else{
				$selected = "";
			}
			echo "<option value=".fun_db_output($rowsCon->no_type_id)."" .$selected. ">";
			echo fun_db_output(ucwords($rowsCon->no_type_name));
			echo "</option>";
		}
		$this->dbObj->fun_db_free_resultset($result);
	}

	// Function for creating optionlist for property_type id property_type id is available it must be selected
	function fun_getPropertyTypeOptionsList($property_type_id=''){		
		$selected = "";
		$sql = "SELECT * FROM " . TABLE_PROPERTY_TYPE. " ORDER BY pt_id";
		$result = $this->dbObj->fun_db_query($sql);
		while($rowsCon = $this->dbObj->fun_db_fetch_rs_object($result)){
			if($rowsCon->pt_id == $property_type_id  && $property_type_id!=''){
				$selected = "selected";
			}else{
				$selected = "";
			}
			echo "<option value=\"".fun_db_output($rowsCon->pt_id)."\" " .$selected. ">";
			echo fun_db_output(ucwords($rowsCon->pt_title));
			echo "</option>\n";
		}
		$this->dbObj->fun_db_free_resultset($result);
	}

	function fun_countPropertyByPropertyType ( $property_type_id = '' ) {
		if ( $property_type_id == '' ) {
			return false;
		} else {
			$sql = "SELECT COUNT(*) total_result FROM  " . TABLE_PROPERTY . " WHERE property_type='".$property_type_id."' AND active='1'";
			$rs = $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);
				$total_result = $arr[0]['total_result'];
			}
			else{
				$total_result = 0;
			}
			return $total_result;
		}
	}

	// Function for creating array for refine property_type along with total no. of actice property
	function fun_getRefinePropertyTypeArrayWithTotalProp($txtcountryids = '', $txtareaids = '', $txtregionids = '', $txtlocationids = '',  $txtFromUnixTime = '', $txtToUnixTime = '', $txtpropertytypeids = '', $txtneedsleep = '', $txtonlybed = '', $txttotalbed = '', $txtholidaytypeids = '', $txtkitchenlinenids = '', $txtoutsideids = '', $txtactivitynearbyids = '', $txtheatingcoolingids = '', $txtenterainmentids = '', $txtlocationviewids = '', $txtserviceids = '', $txtgeneralids = '', $parameter = ''){		
		$propertyTypeArray 	= array();		
		$sqlPropType = "SELECT * FROM " . TABLE_PROPERTY_TYPE. " ORDER BY pt_title";

		$rsPropType		= $this->dbObj->createRecordset($sqlPropType);
		if($this->dbObj->getRecordCount($rsPropType) > 0) {
			$arrReview	= $this->dbObj->fetchAssoc($rsPropType);
			for($i = 0; $i < count($arrReview); $i++) {
				$type_id 									= $arrReview[$i]['pt_id'];
				$type_name 									= $arrReview[$i]['pt_title'];
				$total_property 							= $this->fun_countRefinePropertyByPropertyType($type_id, $txtcountryids, $txtareaids, $txtregionids, $txtlocationids,  $txtFromUnixTime, $txtToUnixTime, $txtpropertytypeids, $txtneedsleep, $txtonlybed, $txttotalbed, $txtholidaytypeids, $txtkitchenlinenids, $txtoutsideids, $txtactivitynearbyids, $txtheatingcoolingids, $txtenterainmentids, $txtlocationviewids, $txtserviceids, $txtgeneralids, $parameter);
				$propertyTypeArray[$i]['property_type_id'] 	= $type_id;
				$propertyTypeArray[$i]['property_type_name']= $type_name;
				$propertyTypeArray[$i]['total_properties']	= $total_property;
			}
			return $propertyTypeArray;
		}
	}

	function fun_countRefinePropertyByPropertyType ( $type_id = '', $txtcountryids = '', $txtareaids = '', $txtregionids = '', $txtlocationids = '',  $txtFromUnixTime = '', $txtToUnixTime = '', $txtpropertytypeids = '', $txtneedsleep = '', $txtonlybed = '', $txttotalbed = '', $txtholidaytypeids = '', $txtkitchenlinenids = '', $txtoutsideids = '', $txtactivitynearbyids = '', $txtheatingcoolingids = '', $txtenterainmentids = '', $txtlocationviewids = '', $txtserviceids = '', $txtgeneralids = '', $parameter = '') {
		if ( $type_id == '' ) {
			return false;
		} else {
			$sql = "SELECT COUNT(*) total_result FROM  " . TABLE_PROPERTY . " WHERE property_type='".$type_id."' AND active='1'";
			$rs = $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);
				$refine_prop = $this->fun_countRefineProperty($txtcountryids, $txtareaids, $txtregionids, $txtlocationids,  $txtFromUnixTime, $txtToUnixTime, $txtpropertytypeids, $txtneedsleep, $txtonlybed, $txttotalbed, $txtholidaytypeids, $txtkitchenlinenids, $txtoutsideids, $txtactivitynearbyids, $txtheatingcoolingids, $txtenterainmentids, $txtlocationviewids, $txtserviceids, $txtgeneralids, $parameter);
				if(((int)$arr[0]['total_result'] > (int)$refine_prop) && ($refine_prop > 0) ) {
					$total_result = $refine_prop;
				} else {
					$total_result = $arr[0]['total_result'];
				}
			}
			else{
				$total_result = 0;
			}
			return $total_result;
		}
	}

	// Function for creating array for property_type along with total no. of actice property
	function fun_getPropertyTypeArrayWithTotalProp($property_type_id=''){		
		$propertyTypeArray 	= array();		
		if($property_type_id !="") {
        	//Find all query
            $sqlPropType = "SELECT * FROM " . TABLE_PROPERTY_TYPE. " WHERE pt_id='".$property_type_id."' ORDER BY pt_title";
		} else {
            $sqlPropType = "SELECT * FROM " . TABLE_PROPERTY_TYPE. " ORDER BY pt_title";
		}

		$rsPropType		= $this->dbObj->createRecordset($sqlPropType);
		if($this->dbObj->getRecordCount($rsPropType) > 0) {
			$arrReview	= $this->dbObj->fetchAssoc($rsPropType);
			for($i = 0; $i < count($arrReview); $i++) {
				$type_id 									= $arrReview[$i]['pt_id'];
				$type_name 									= $arrReview[$i]['pt_title'];
				$total_property 							= $this->fun_countPropertyByPropertyType($type_id);
				$propertyTypeArray[$i]['property_type_id'] 	= $type_id;
				$propertyTypeArray[$i]['property_type_name']= $type_name;
				$propertyTypeArray[$i]['total_properties']	= $total_property;
			}
			return $propertyTypeArray;
		}
	}

	// Function for creating array for property_type along with total no. of actice property
	function fun_getPropertyTypeArrayWithRefineByCriteria($txtcountryids = '', $txtareaids = '', $txtregionids = '', $txtlocationids = '', $txtFromUnixTime = '', $txtToUnixTime = '', $txtpropertytypeids = '', $txtneedsleep = '', $txtonlybed = '', $txttotalbed = '', $txtholidaytypeids = '', $txtkitchenlinenids = '', $txtoutsideids = '', $txtactivitynearbyids = '', $txtheatingcoolingids = '', $txtenterainmentids = '', $txtlocationviewids = '', $txtserviceids = '', $txtgeneralids = '', $featured ='', $latedeal ='', $parameter = '') {
		$property_ids = $this->fun_getPropertyIdsByRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids,  $txtFromUnixTime, $txtToUnixTime, "", $txtneedsleep, $txtonlybed, $txttotalbed, $txtholidaytypeids, $txtkitchenlinenids, $txtoutsideids, $txtactivitynearbyids, $txtheatingcoolingids, $txtenterainmentids, $txtlocationviewids, $txtserviceids, $txtgeneralids, $featured, $latedeal, $parameter);
		if(isset($property_ids) && $property_ids !="") {
			$sql = "SELECT distinct A.property_type FROM " . TABLE_PROPERTY . " AS A LEFT JOIN " . TABLE_PROPERTY_TYPE . " AS B ON B.pt_id = A.property_type WHERE A.active='1' AND A.property_id IN (".$property_ids.")";
		} else {
			$sql = "SELECT distinct A.property_type FROM " . TABLE_PROPERTY . " AS A LEFT JOIN " . TABLE_PROPERTY_TYPE . " AS B ON B.pt_id = A.property_type WHERE A.active='1'";
		}
		$rs 				= $this->dbObj->createRecordset($sql);
		$arr 				= $this->dbObj->fetchAssoc($rs);
		$propertyTypeArr 	= array();
		for($j = 0; $j < count($arr); $j++) {
			array_push($propertyTypeArr, "'".$arr[$j]['property_type']."'");
		}
		if(count($propertyTypeArr) > 0) {
			$property_type_ids = implode(",", array_keys(array_flip($propertyTypeArr)));
		}
		$propertyTypeArray 	= array();
		if($property_type_ids !="") {
            $sqlPropType = "SELECT * FROM " . TABLE_PROPERTY_TYPE. " WHERE pt_id IN (".$property_type_ids.") ORDER BY pt_title";
		} else {
            $sqlPropType = "SELECT * FROM " . TABLE_PROPERTY_TYPE. " ORDER BY pt_title";
		}
		$rsPropType		= $this->dbObj->createRecordset($sqlPropType);
		if($this->dbObj->getRecordCount($rsPropType) > 0) {
			$arrReview	= $this->dbObj->fetchAssoc($rsPropType);
			for($i = 0; $i < count($arrReview); $i++) {
				$type_id 									= $arrReview[$i]['pt_id'];
				$type_name 									= $arrReview[$i]['pt_title'];
				$total_property 							= $this->fun_countRefinePropertyByPropertyType($type_id, $txtcountryids, $txtareaids, $txtregionids, $txtlocationids,  $txtFromUnixTime, $txtToUnixTime, $txtpropertytypeids, $txtneedsleep, $txtonlybed, $txttotalbed, $txtholidaytypeids, $txtkitchenlinenids, $txtoutsideids, $txtactivitynearbyids, $txtheatingcoolingids, $txtenterainmentids, $txtlocationviewids, $txtserviceids, $txtgeneralids, $parameter);
				$propertyTypeArray[$i]['property_type_id'] 	= $type_id;
				$propertyTypeArray[$i]['property_type_name']= $type_name;
				$propertyTypeArray[$i]['total_properties']	= $total_property;
			}
			return $propertyTypeArray;
		}
	}

	// Function for currency rates
	function fun_findPropertyCurrencyRate(){		
		$currencyRate 	= array();		
		$sql 	= "SELECT * FROM " . TABLE_CURRENCIES. " ORDER BY currency_name";
		$rs 	= $this->dbObj->createRecordset($sql);
		$arr 	= $this->dbObj->fetchAssoc($rs);
		
		for($i=0; $i < count($arr); $i++) {
			$currencyRate[$arr[$i]['currency_code']] = $arr[$i]['currency_rate'];
		}
		return $currencyRate;		
	}


	// Function for creating optionlist for currencies if currencies id is available it must be selected
	function fun_getCurrenciesOptionsList($currency_id = ''){		
		$selected = "";
		$sql = "SELECT * FROM " . TABLE_CURRENCIES. " ORDER BY currency_name";
		$result = $this->dbObj->fun_db_query($sql);
		while($rowsCon = $this->dbObj->fun_db_fetch_rs_object($result)){
			if($rowsCon->currency_id == $currency_id  && $currency_id!=''){
				$selected = "selected";
			}else{
				$selected = "";
			}
			echo "<option value=\"".fun_db_output($rowsCon->currency_id)."\" " .$selected. ">";
			echo fun_db_output(ucwords($rowsCon->currency_name));
			echo "</option>\n";
		}
		$this->dbObj->fun_db_free_resultset($result);
	}

	// Function for creating optionlist for currencies if currencies id is available it must be selected
	function fun_getCurrenciesOptionsListWithCodeSymbl($currency_code = ''){	
		$selected = "";
		$sql = "SELECT * FROM " . TABLE_CURRENCIES. " ORDER BY  FIELD(currency_name, 'british pounds','euro','american dollar')	";
		$result = $this->dbObj->fun_db_query($sql);
		while($rowsCon = $this->dbObj->fun_db_fetch_rs_object($result)){
			if($rowsCon->currency_code == $currency_code  && $currency_code!=''){
				$selected = "selected";
			}else{
				$selected = "";
			}
			echo "<option value=\"".fun_db_output($rowsCon->currency_code)."\" " .$selected. ">";
			echo fun_db_output($rowsCon->currency_symbol." ".ucwords($rowsCon->currency_name));
			echo "</option>\n";
		}
		$this->dbObj->fun_db_free_resultset($result);
	}

	// Function for creating optionlist for currencies if currencies id is available it must be selected
	function fun_getCurrenciesOptionsListWithSymbl($currency_id = ''){		
		$selected = "";
		$sql = "SELECT * FROM " . TABLE_CURRENCIES. " ORDER BY currency_name";
		$result = $this->dbObj->fun_db_query($sql);
		while($rowsCon = $this->dbObj->fun_db_fetch_rs_object($result)){
			if($rowsCon->currency_id == $currency_id  && $currency_id!=''){
				$selected = "selected";
			}else{
				$selected = "";
			}
			echo "<option value=\"".fun_db_output($rowsCon->currency_id)."\" " .$selected. ">";
			echo fun_db_output($rowsCon->currency_symbol." ".ucwords($rowsCon->currency_name));
			echo "</option>\n";
		}
		$this->dbObj->fun_db_free_resultset($result);
	}


	// Function for creating optionlist for catering_type id; if property_type id is available it must be selected
	function fun_getCateringTypeOptionsList($catering_type_id=''){		
		$selected = "";
		$sql = "SELECT * FROM " . TABLE_PROPERTY_CATERING . " ORDER BY catering_name";
		$result = $this->dbObj->fun_db_query($sql);
		while($rowsCon = $this->dbObj->fun_db_fetch_rs_object($result)){
			if($rowsCon->catering_id == $catering_type_id  && $catering_type_id!=''){
				$selected = "selected";
			}else{
				$selected = "";
			}
			echo "<option value=\"".fun_db_output($rowsCon->catering_id)."\" " .$selected. ">";
			echo fun_db_output(ucwords($rowsCon->catering_name));
			echo "</option>\n";
		}
		$this->dbObj->fun_db_free_resultset($result);
	}

	// Function for creating Unit type for complex
	function fun_createUnitTypeField($selected=''){		
		echo "<select name='txtUnitType' id='txtUnitType' class='select216'>";
		echo "<option value=\"\">Please Select</option>";
		if($selected == 1)
		echo "<option value=\"1\" selected>Two bdr apts & studios.</option>";
		else
		echo "<option value=\"1\">Two bdr apts & studios.</option>";

		if($selected == 2)
		echo "<option value=\"2\" selected>One bdr apts, two bdr apts & studios.</option>";
		else
		echo "<option value=\"2\">One bdr apts, two bdr apts & studios.</option>";

		if($selected == 3)
		echo "<option value=\"3\" selected>One bdr apts,  & two bdr apts.</option>";
		else
		echo "<option value=\"3\">One bdr apts,  & two bdr apts.</option>";

		if($selected == 4)
		echo "<option value=\"4\" selected>One bdr apts, two bdr apts, Three bdr apts.</option>";
		else
		echo "<option value=\"4\">One bdr apts, two bdr apts, Three bdr apts.</option>";


		if($selected == 5)
		echo "<option value=\"5\" selected>One bdr apts, & Three bdr apts.</option>";
		else
		echo "<option value=\"5\">One bdr apts, & Three bdr apts.</option>";

		if($selected == 6)
		echo "<option value=\"6\" selected>Two bdr apts, three bdr apts, & studios.</option>";
		else
		echo "<option value=\"6\">Two bdr apts, three bdr apts, & studios.</option>";

		if($selected == 7)
		echo "<option value=\"7\" selected>One bedroom apts.</option>";
		else
		echo "<option value=\"7\">One bedroom apts.</option>";

		if($selected == 8)
		echo "<option value=\"8\" selected>Two bedroom apts.</option>";
		else
		echo "<option value=\"8\">Two bedroom apts.</option>";
		
		if($selected == 9)
		echo "<option value=\"9\" selected>Three bedroom apts.</option>";
		else
		echo "<option value=\"9\">Three bedroom apts.</option>";
		
		if($selected == 10)
		echo "<option value=\"10\" selected>Four bedrooms apts.</option>";
		else
		echo "<option value=\"10\">Four bedrooms apts.</option>";


        if($selected == 11)
		echo "<option value=\"11\" selected>Studios.</option>";
		else
		echo "<option value=\"11\">Studios.</option>";
		
		if($selected == 12)
		echo "<option value=\"12\" Twin & tripple rooms.</option>";
		else
		echo "<option value=\"12\">Twin & tripple rooms.</option>";
		
		if($selected == 13)
		echo "<option value=\"13\" selected>Rooms only.</option>";
		else
		echo "<option value=\"13\">Rooms only.</option>";

		if($selected == 14)
		echo "<option value=\"14\" selected>Villas.</option>";
		else
		echo "<option value=\"14\">Villas.</option>";
		
		if($selected == 15)
		echo "<option value=\"15\" selected>House.</option>";
		else
		echo "<option value=\"15\">House.</option>";
		if($selected == 16)
		echo "<option value=\"16\" selected>Apartment.</option>";
		else
		echo "<option value=\"16\">Apartment.</option>";



		echo "</select>";
	}

	// Function for creating Numeric Select field for various property attributes
	function fun_createSelectBedField($name='', $id='', $class='', $selected='', $onchange='', $from='', $to=''){
		$strHTML = "";
		$strHTML .= "<select name='".$name."' id='".$id."' class='".$class."'  onchange='".$onchange."' >";
		$strHTML .= "<option value='1'>1 guest </option>";
		for($i=$from; $i <= $to; $i++){
			if($i == $selected){
				$strHTML .= "<option value='$i' selected>$i guests</option>";
			} else {
				$strHTML .= "<option value='$i'>$i guests</option>";
			}
		}
		$strHTML .= "</select>";
		return $strHTML;
	}


	// Function for creating Numeric Select field for various property attributes
	function fun_createSelectNumField($name='', $id='', $class='', $selected='', $onchange='', $from='', $to=''){		
		echo "<select name='".$name."' id='".$id."' class='".$class."'  onchange='".$onchange."' >";
		echo "<option value=\"\">---</option>";
		for($i=$from; $i <= $to; $i++){
			if($i == $selected){
				echo "<option value='$i' selected>$i</option>";
			}
			else{
				echo "<option value='$i'>$i</option>";
			}
		}
		echo "</select>";
	}

	// Function for creating Yes / No Select field for various property attributes
	function fun_createSelectYesNoField($name='', $id='', $class='', $selected='', $onchange=''){		
		echo "<select name='".$name."' id='".$id."' class='".$class."'  onchange='".$onchange."' >";
			if($selected == "1"){
				echo "<option value='1' selected>Yes</option>";
				echo "<option value='0'>No</option>";
			}
			else{
				echo "<option value='1'>Yes</option>";
				echo "<option value='0' selected>No</option>";
			}
		echo "</select>";
	}

	function fun_getPropertyArrByPropertyHolidayType( $property_holiday_id = '' ) {
		if ( $property_holiday_id == '' ) {
			return false;
		} else {
			$sql = "SELECT A.property_id AS property_id 
			FROM  " . TABLE_PROPERTY . " AS A
			INNER JOIN " . TABLE_PROPERTY_CHECKLIST_SETTINGS . " AS B ON B.property_id = A.property_id
			WHERE ((B.holiday_type like '%,".$property_holiday_id .",%') OR (B.holiday_type like '".$property_holiday_id .",%') OR (B.holiday_type like '%,".$property_holiday_id ."')) AND A.active='1'";

			$rs = $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);
				return $arr;
			}
			else{
				return false;
			}
		}
	}



	// Function for creating array for property_type along with total no. of actice property
	function fun_getPropertyHolidayArrayWithTotalProp($property_holiday_id=''){		
		$propertyHolidayArray 	= array();		
		if($property_holiday_id !="") {
        	//Find all query
            $sqlPropHoliday = "SELECT * FROM " .TABLE_HOLIDAY. " WHERE holiday_id='".$property_holiday_id."' ORDER BY holiday_name";
		} else {
            $sqlPropHoliday = "SELECT * FROM " .TABLE_HOLIDAY. " ORDER BY holiday_name";
		}

		$rsPropHoliday		= $this->dbObj->createRecordset($sqlPropHoliday);
		if($this->dbObj->getRecordCount($rsPropHoliday) > 0) {
			$arrHoliday	= $this->dbObj->fetchAssoc($rsPropHoliday);
			for($i = 0; $i < count($arrHoliday); $i++) {
				$holiday_id 							= $arrHoliday[$i]['holiday_id'];
				$holiday_name							= $arrHoliday[$i]['holiday_name'];
				$total_property 						= $this->fun_countPropertyByPropertyHoliday($holiday_id);
				$propertyHolidayArray[$i]['property_holiday_id'] 	= $holiday_id;
				$propertyHolidayArray[$i]['property_holiday_name']	= $holiday_name;
				$propertyHolidayArray[$i]['total_properties']		= $total_property;
			}
			return $propertyHolidayArray;
		}
	}

	function fun_countPropertyByPropertyHoliday( $property_holiday_id = '' ) {
		if ( $property_holiday_id == '' ) {
			return false;
		} else {
			$sql = "SELECT COUNT(*) total_result 
			FROM  " . TABLE_PROPERTY . " AS A
			INNER JOIN " . TABLE_PROPERTY_CHECKLIST_SETTINGS . " AS B ON B.property_id = A.property_id
			WHERE ((B.holiday_type like '%,".$property_holiday_id .",%') OR (B.holiday_type like '".$property_holiday_id .",%') OR (B.holiday_type like '%,".$property_holiday_id ."')) AND A.active='1'";

			$rs = $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);
				$total_result = $arr[0]['total_result'];
			}
			else{
				$total_result = 0;
			}
			return $total_result;
		}
	}

	// Function for creating array for property_type along with total no. of actice property

	function fun_getRefinePropertyHolidayArrayWithTotalProp($txtcountryids = '', $txtareaids = '', $txtregionids = '', $txtlocationids = '',  $txtFromUnixTime = '', $txtToUnixTime = '', $txtpropertytypeids = '', $txtneedsleep = '', $txtonlybed = '', $txttotalbed = '', $txtholidaytypeids = '', $txtkitchenlinenids = '', $txtoutsideids = '', $txtactivitynearbyids = '', $txtheatingcoolingids = '', $txtenterainmentids = '', $txtlocationviewids = '', $txtserviceids = '', $txtgeneralids = '', $parameter = ''){		
		$propertyHolidayArray 	= array();		
		$sqlPropHoliday = "SELECT * FROM " .TABLE_HOLIDAY. " ORDER BY holiday_name";
		$rsPropHoliday		= $this->dbObj->createRecordset($sqlPropHoliday);
		if($this->dbObj->getRecordCount($rsPropHoliday) > 0) {
			$arrHoliday	= $this->dbObj->fetchAssoc($rsPropHoliday);
			for($i = 0; $i < count($arrHoliday); $i++) {
				$holiday_id 							= $arrHoliday[$i]['holiday_id'];
				$holiday_name							= $arrHoliday[$i]['holiday_name'];
				$total_property 						= $this->fun_countRefinePropertyByPropertyHoliday($holiday_id, $txtcountryids, $txtareaids, $txtregionids, $txtlocationids,  $txtFromUnixTime, $txtToUnixTime, $txtpropertytypeids, $txtneedsleep, $txtonlybed, $txttotalbed, $txtholidaytypeids, $txtkitchenlinenids, $txtoutsideids, $txtactivitynearbyids, $txtheatingcoolingids, $txtenterainmentids, $txtlocationviewids, $txtserviceids, $txtgeneralids, $parameter);
				$propertyHolidayArray[$i]['property_holiday_id'] 	= $holiday_id;
				$propertyHolidayArray[$i]['property_holiday_name']	= $holiday_name;
				$propertyHolidayArray[$i]['total_properties']		= $total_property;
			}
			return $propertyHolidayArray;
		}
	}

	function fun_countRefinePropertyByPropertyHoliday( $property_holiday_id = '', $txtcountryids = '', $txtareaids = '', $txtregionids = '', $txtlocationids = '',  $txtFromUnixTime = '', $txtToUnixTime = '', $txtpropertytypeids = '', $txtneedsleep = '', $txtonlybed = '', $txttotalbed = '', $txtholidaytypeids = '', $txtkitchenlinenids = '', $txtoutsideids = '', $txtactivitynearbyids = '', $txtheatingcoolingids = '', $txtenterainmentids = '', $txtlocationviewids = '', $txtserviceids = '', $txtgeneralids = '', $parameter = '') {
		if ( $property_holiday_id == '' ) {
			return false;
		} else {
			$sql = "SELECT COUNT(*) total_result 
			FROM  " . TABLE_PROPERTY . " AS A
			INNER JOIN " . TABLE_PROPERTY_CHECKLIST_SETTINGS . " AS B ON B.property_id = A.property_id
			WHERE ((B.holiday_type like '%,".$property_holiday_id .",%') OR (B.holiday_type like '".$property_holiday_id .",%') OR (B.holiday_type like '%,".$property_holiday_id ."')) AND A.active='1'";

			$rs = $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);
				$refine_prop = $this->fun_countRefineProperty($txtcountryids, $txtareaids, $txtregionids, $txtlocationids,  $txtFromUnixTime, $txtToUnixTime, $txtpropertytypeids, $txtneedsleep, $txtonlybed, $txttotalbed, $txtholidaytypeids, $txtkitchenlinenids, $txtoutsideids, $txtactivitynearbyids, $txtheatingcoolingids, $txtenterainmentids, $txtlocationviewids, $txtserviceids, $txtgeneralids, $parameter);
				if(((int)$arr[0]['total_result'] > (int)$refine_prop) && ($refine_prop > 0) ) {
					$total_result = $refine_prop;
				} else {
					$total_result = $arr[0]['total_result'];
				}
			}
			else{
				$total_result = 0;
			}
			return $total_result;
		}
	}

	// Function for creating property check list : type of people section
	function fun_createPropertyCheckListPeopleType($property_id = ''){		
		$sqlCheckListPeopleTypeIds 	= "SELECT holiday_ptype FROM " . TABLE_PROPERTY_CHECKLIST_SETTINGS . " WHERE property_id='".$property_id."'";
		$rsCheckListPeopleTypeIds 	= $this->dbObj->createRecordset($sqlCheckListPeopleTypeIds);
		$arrCheckListPeopleTypeIds 	= $this->dbObj->fetchAssoc($rsCheckListPeopleTypeIds);
		$checkListPeopleTypeIds = "";

		foreach($arrCheckListPeopleTypeIds as $val){
			$checkListPeopleTypeIds = $val['holiday_ptype'];
		}

		$checkListPeopleTypeIdsArr = explode(",", $checkListPeopleTypeIds);
		
		$sql = "SELECT * FROM " . TABLE_HOLIDAY_MAKER . " ORDER BY holiday_maker_name";
		echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
		echo "<tr>";
		$rs = $this->dbObj->createRecordset($sql);
		$arr = $this->dbObj->fetchAssoc($rs);
		$i = 0;
		foreach($arr as $value){
			if($i%2 == 0){
				echo "</tr><tr>";
			}
			if(array_search($value['holiday_maker_id'], $checkListPeopleTypeIdsArr) === false){
				$checked = "";
			}
			else{
				$checked = "checked";
			}
			echo "<td width=\"24\" valign=\"top\" class=\"pad-btm5 pad-top3\"><input type=\"checkbox\" name='txtPeopleType[]' value='". $value['holiday_maker_id'] ."' class=\"RegFormChkBox\" " .$checked. "></td>";
			echo "<td width=\"260\" valign=\"top\" class=\"pad-btm5\"> " .ucwords($value['holiday_maker_name']). " </td>";
			$i++;
		}
		echo "</table>";
	}

	// Function for creating property check list Review: type of people section
	function fun_createPropertyCheckListPeopleTypeReview($property_id = ''){		
		$sqlCheckListPeopleTypeIds 	= "SELECT holiday_ptype FROM " . TABLE_PROPERTY_CHECKLIST_SETTINGS . " WHERE property_id='".$property_id."'";
		$rsCheckListPeopleTypeIds 	= $this->dbObj->createRecordset($sqlCheckListPeopleTypeIds);
		$arrCheckListPeopleTypeIds 	= $this->dbObj->fetchAssoc($rsCheckListPeopleTypeIds);
		$checkListPeopleTypeIds = "";

		foreach($arrCheckListPeopleTypeIds as $val){
			$checkListPeopleTypeIds = $val['holiday_ptype'];
		}

		echo "<table width=\"298\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
		echo "<tr>";
		echo "<td valign=\"top\" class=\"chklistQ dash-btm\">Type of people</td>";
		echo "<td align=\"right\" valign=\"top\" class=\"dash-btm\"><a href=\"javascript:open_div('ChecklistSubTab', '1');void(0);\" class=\"Update\">Edit</a></td>";
		echo "</tr>";

		if($checkListPeopleTypeIds !=""){
			$sql = "SELECT * FROM " . TABLE_HOLIDAY_MAKER . " WHERE holiday_maker_id IN (".$checkListPeopleTypeIds.") ORDER BY holiday_maker_name";
			$rs = $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);
				$i = 0;
				foreach($arr as $value){
					if($i%1 == 0){
						echo "</tr><tr>";
					}
					echo "<td colspan=\"2\" valign=\"top\" class=\"dash-btm\"><p class=\"ChecklistSubTabTick\">" .ucfirst(strtolower($value['holiday_maker_name'])). "</p></td>";
					$i++;
				}
			}
			else{
			echo "<tr>";
			echo "<td colspan=\"2\" valign=\"top\" class=\"dash-btm\"><p class=\"ChecklistSubTabCross\"><span class=\"red\">None selected:</span> <a href=\"javascript:open_div('ChecklistSubTab', '1');void(0);\" class=\"blue-link\">Please select</a></p></td>";
			echo "</tr>";
			}
		}
		else{
		echo "<tr>";
		echo "<td colspan=\"2\" valign=\"top\" class=\"dash-btm\"><p class=\"ChecklistSubTabCross\"><span class=\"red\">None selected:</span> <a href=\"javascript:open_div('ChecklistSubTab', '1');void(0);\" class=\"blue-link\">Please select</a></p></td>";
		echo "</tr>";
		}
		echo "</table>";
	}

	// Function for creating property check list : type of people section
	function fun_createPropertyCheckListHolidayType($property_id = ''){		
		$sqlCheckListHolidayTypeIds 	= "SELECT holiday_type FROM " . TABLE_PROPERTY_CHECKLIST_SETTINGS . " WHERE property_id='".$property_id."'";
		$rsCheckListHolidayTypeIds 		= $this->dbObj->createRecordset($sqlCheckListHolidayTypeIds);
		$arrCheckListHolidayTypeIds 	= $this->dbObj->fetchAssoc($rsCheckListHolidayTypeIds);
		$checkListHolidayTypeIds 		= "";

		foreach($arrCheckListHolidayTypeIds	 as $val){
			$checkListHolidayTypeIds = $val['holiday_type'];
		}

		$checkListHolidayTypeIdsArr = explode(",", $checkListHolidayTypeIds);
		
		$sql = "SELECT * FROM " . TABLE_HOLIDAY . " ORDER BY holiday_name";
		echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
		echo "<tr>";
		$rs = $this->dbObj->createRecordset($sql);
		$arr = $this->dbObj->fetchAssoc($rs);
		$i = 0;
		foreach($arr as $value){
			if($i%2 == 0){
				echo "</tr><tr>";
			}
			if(array_search($value['holiday_id'], $checkListHolidayTypeIdsArr) === false){
				$checked = "";
			}
			else{
				$checked = "checked";
			}
			echo "<td width=\"24\" valign=\"top\" class=\"pad-btm5 pad-top3\"><input type=\"checkbox\" name='txtHolidayType[]' value='". $value['holiday_id'] ."' class=\"RegFormChkBox\" " .$checked. "></td>";
			echo "<td width=\"260\" valign=\"top\" class=\"pad-btm5\"> " .ucwords($value['holiday_name']). " </td>";
			$i++;
		}
		echo "</table>";
	}

	// Function for creating property check list Review: type of people section
	function fun_createPropertyCheckListHolidayTypeReview($property_id = ''){		
		$sqlCheckListHolidayTypeIds 	= "SELECT holiday_type FROM " . TABLE_PROPERTY_CHECKLIST_SETTINGS . " WHERE property_id='".$property_id."'";
		$rsCheckListHolidayTypeIds 	= $this->dbObj->createRecordset($sqlCheckListHolidayTypeIds);
		$arrCheckListHolidayTypeIds 	= $this->dbObj->fetchAssoc($rsCheckListHolidayTypeIds);
		$checkListHolidayTypeIds = "";

		foreach($arrCheckListHolidayTypeIds as $val){
			$checkListHolidayTypeIds = $val['holiday_type'];
		}

		echo "<table width=\"298\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
		echo "<tr>";
		echo "<td valign=\"top\" class=\"chklistQ dash-btm\">Type of holiday</td>";
		echo "<td align=\"right\" valign=\"top\" class=\"dash-btm\"><a href=\"javascript:open_div('ChecklistSubTab', '2');void(0);\" class=\"Update\">Edit</a></td>";
		echo "</tr>";

		if($checkListHolidayTypeIds !=""){
			$sql = "SELECT * FROM " . TABLE_HOLIDAY . " WHERE holiday_id IN (".$checkListHolidayTypeIds.") ORDER BY holiday_name";
			$rs = $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);
				$i = 0;
				foreach($arr as $value){
					if($i%1 == 0){
						echo "</tr><tr>";
					}
					echo "<td colspan=\"2\" valign=\"top\" class=\"dash-btm\"><p class=\"ChecklistSubTabTick\">" .ucfirst(strtolower($value['holiday_name'])). "</p></td>";
					$i++;
				}
			}
			else{
			echo "<tr>";
			echo "<td colspan=\"2\" valign=\"top\" class=\"dash-btm\"><p class=\"ChecklistSubTabCross\"><span class=\"red\">None selected:</span> <a href=\"javascript:open_div('ChecklistSubTab', '2');void(0);\" class=\"blue-link\">Please select</a></p></td>";
			echo "</tr>";
			}
		}
		else{
		echo "<tr>";
		echo "<td colspan=\"2\" valign=\"top\" class=\"dash-btm\"><p class=\"ChecklistSubTabCross\"><span class=\"red\">None selected:</span> <a href=\"javascript:open_div('ChecklistSubTab', '2');void(0);\" class=\"blue-link\">Please select</a></p></td>";
		echo "</tr>";
		}
		echo "</table>";
	}

	// Function for creating property check list : type of holiday section
	function fun_createPropertyCheckListAccommodationType($property_id = ''){		
		$sqlCheckListAccommodationTypeIds 	= "SELECT accommodation_type FROM " . TABLE_PROPERTY_CHECKLIST_SETTINGS . " WHERE property_id='".$property_id."'";
		$rsCheckListAccommodationTypeIds 		= $this->dbObj->createRecordset($sqlCheckListAccommodationTypeIds);
		$arrCheckListAccommodationTypeIds 	= $this->dbObj->fetchAssoc($rsCheckListAccommodationTypeIds);
		$checkListAccommodationTypeIds 		= "";

		foreach($arrCheckListAccommodationTypeIds	 as $val){
			$checkListAccommodationTypeIds = $val['accommodation_type'];
		}

		$checkListAccommodationTypeIdsArr = explode(",", $checkListAccommodationTypeIds);
		
		$sql = "SELECT * FROM " . TABLE_PROPERTY_ACCOMMODATION . " ORDER BY accommodation_name";
		echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
		echo "<tr>";
		$rs = $this->dbObj->createRecordset($sql);
		$arr = $this->dbObj->fetchAssoc($rs);
		$i = 0;
		foreach($arr as $value){
			if($i%2 == 0){
				echo "</tr><tr>";
			}
			if(array_search($value['accommodation_id'], $checkListAccommodationTypeIdsArr) === false){
				$checked = "";
			}
			else{
				$checked = "checked";
			}
			echo "<td width=\"24\" valign=\"top\" class=\"pad-btm5 pad-top3\"><input type=\"checkbox\" name='txtAccommodationType[]' value='". $value['accommodation_id'] ."' class=\"RegFormChkBox\" " .$checked. "></td>";
			echo "<td width=\"260\" valign=\"top\" class=\"pad-btm5\"> " .ucwords($value['accommodation_name']). " </td>";
			$i++;
		}
		echo "</table>";
	}

	// Function for creating property check list Review: type of accomadation section
	function fun_createPropertyCheckListAccommodationTypeReview($property_id = ''){		
		$sqlCheckListAccommodationTypeIds 	= "SELECT accommodation_type FROM " . TABLE_PROPERTY_CHECKLIST_SETTINGS . " WHERE property_id='".$property_id."'";
		$rsCheckListAccommodationTypeIds 	= $this->dbObj->createRecordset($sqlCheckListAccommodationTypeIds);
		$arrCheckListAccommodationTypeIds 	= $this->dbObj->fetchAssoc($rsCheckListAccommodationTypeIds);
		$checkListAccommodationTypeIds = "";

		foreach($arrCheckListAccommodationTypeIds as $val){
			$checkListAccommodationTypeIds = $val['accommodation_type'];
		}

		echo "<table width=\"298\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
		echo "<tr>";
		echo "<td valign=\"top\" class=\"chklistQ dash-btm\">Accommodation type</td>";
		echo "<td align=\"right\" valign=\"top\" class=\"dash-btm\"><a href=\"javascript:open_div('ChecklistSubTab', '3');void(0);\" class=\"Update\">Edit</a></td>";
		echo "</tr>";

		if($checkListAccommodationTypeIds !=""){
			$sql = "SELECT * FROM " . TABLE_PROPERTY_ACCOMMODATION . " WHERE accommodation_id IN (".$checkListAccommodationTypeIds.") ORDER BY accommodation_name";
			$rs = $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);
				$i = 0;
				foreach($arr as $value){
					if($i%1 == 0){
						echo "</tr><tr>";
					}
					echo "<td colspan=\"2\" valign=\"top\" class=\"dash-btm\"><p class=\"ChecklistSubTabTick\">" .ucfirst(strtolower($value['accommodation_name'])). "</p></td>";
					$i++;
				}
			}
			else{
			echo "<tr>";
			echo "<td colspan=\"2\" valign=\"top\" class=\"dash-btm\"><p class=\"ChecklistSubTabCross\"><span class=\"red\">None selected:</span> <a href=\"javascript:open_div('ChecklistSubTab', '3');void(0);\" class=\"blue-link\">Please select</a></p></td>";
			echo "</tr>";
			}
		}
		else{
		echo "<tr>";
		echo "<td colspan=\"2\" valign=\"top\" class=\"dash-btm\"><p class=\"ChecklistSubTabCross\"><span class=\"red\">None selected:</span> <a href=\"javascript:open_div('ChecklistSubTab', '3');void(0);\" class=\"blue-link\">Please select</a></p></td>";
		echo "</tr>";
		}
		echo "</table>";
	}


	// Function for creating property Distances in holiday priview section
	function fun_createPropertyPropertyDistances($property_id = ''){		
		echo "<table width=\"190\" cellpadding=\"0\" cellspacing=\"0\">";
		echo "<tr><td colspan=\"2\" class=\"owner-headings1 pad-btm8 dash-btm\">Distances</td></tr>";
		$sql = "SELECT * FROM " . TABLE_PROPERTY_LANDMARKS . " WHERE landmark_id IN (1,3,6,9,11) ORDER BY landmark_name";
		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr = $this->dbObj->fetchAssoc($rs);
			$i = 0;
			foreach($arr as $value){
				if(($distanceArr = $this->fun_getPropertyLandmarkDistanceInfo($property_id, $value['landmark_id'])) && is_array($distanceArr) && ($distanceArr[0]['distance'] !="")) {
					$distanceValue = $distanceArr[0]['distance'];
					if($distanceArr[0]['distance_type'] !="" && $distanceArr[0]['distance_type'] =="m") {
						$distanceUnit = "miles";
					} else {
						$distanceUnit = "km";
					}
					$strDistance = $distanceValue."".$distanceUnit;
				} else {
					$strDistance = "";
				}
				if($i%1 == 0){
					echo "</tr><tr class=\"Summary\">";
				}
                echo "<td>" .ucwords($value['landmark_name']). "</td><td align=\"right\">".$strDistance."</td>";
				$i++;
			}
		}
		else{
			echo "<tr class=\"Summary\"><td>&nbsp;</td><td>&nbsp;</td></tr>";
		}
		echo "<tr><td colspan=\"2\" class=\"pad-top5\"><a href=\"javascript:showSection(4);\"  class=\"Update\">View more distances</a></td></tr>";
		echo "</table>";
	}

	// Function for creating property Need To Know section
	function fun_createPropertyHighlightView($property_id = ''){		
		$selling_points_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_SELLING_POINTS_RELATIONS , " WHERE property_id='".$property_id."'");
		echo "<table width=\"190\" cellpadding=\"0\" cellspacing=\"0\">";
		if ( is_array($selling_points_array) && count($selling_points_array) > 0) {
			echo "<tr><td class=\"owner-headings1 pad-btm8 pad-top12 dash-btm\">Highlights</td></tr>";
			for ($i = 0; $i < count($selling_points_array); $i++) {
				$strSellingPoint = ucfirst($selling_points_array[$i]['selling_point']);
				echo "<tr class=\"Summary\"><td>".$strSellingPoint."</td></tr>";
			}
		} else {
			echo "<tr class=\"Summary\"><td>&nbsp;</td></tr>";
		}
		echo "</table>";
	}

	// Function for creating property Need To Know section
	function fun_createPropertyHighlightSectionView($property_id = ''){		
		$selling_points_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_SELLING_POINTS_RELATIONS , " WHERE property_id='".$property_id."' ORDER BY RAND() LIMIT 0, 5");
		if ( is_array($selling_points_array) && count($selling_points_array) > 0) {
			echo '<div class="box3 tick-list" align="left">';
			echo '<span style="font-size:18px; font-wieght:bold;">Highlights...</span>';
			echo '<ul>';
			for ($i = 0; $i < count($selling_points_array); $i++) {
				$strSellingPoint = ucfirst($selling_points_array[$i]['selling_point']);
				echo '<li><p> '.$strSellingPoint.'</p></li>';
			}
			echo '</ul>';
			echo '</div>';
		}
	}

	function fun_createPropertyOtherVacationProperties($property_id = '') {
		if($property_id == ''){
			return false;
		} else {
			// Find location info
			$propLocInfoArr = $this->fun_getPropertyLocInfoArr($property_id);
			
			$location_id		= $propLocInfoArr['location_id'];
			$subregion_id		= $propLocInfoArr['subregion_id'];
			$region_id 			= $propLocInfoArr['region_id'];
			$area_id 			= $propLocInfoArr['area_id'];
			
			if($location_id !="" && $location_id !="0" && $this->fun_countPropertyByLocationId($location_id) > 1){
				$destinations_name	= $propLocInfoArr['location_name'];
				$destinations		= str_replace("/", "_", str_replace(" ", "-", $destinations_name));
				$link_others 		= SITE_URL."vacation-rentals/in.".$destinations;
				$propInfoArr 		= $this->fun_getPropertyInfoByFieldName("location_id", $location_id, $property_id, 2);
			} else if ($subregion_id !="" && $subregion_id != "0" && $this->fun_countPropertyByRegionId($subregion_id) > 1) {
				$destinations_name	= $propLocInfoArr['subregion_name'];
				$destinations		= str_replace("/", "_", str_replace(" ", "-", $destinations_name));
				$link_others 		= SITE_URL."vacation-rentals/in.".$destinations;
				$propInfoArr 		= $this->fun_getPropertyInfoByFieldName("subregion_id", $subregion_id, $property_id, 2);
			} else if ($region_id !="" && $region_id != "0" && $this->fun_countPropertyByRegionId($region_id) > 1) {
				$destinations_name	= $propLocInfoArr['region_name'];
				$destinations		= str_replace("/", "_", str_replace(" ", "-", $destinations_name));
				$link_others 		= SITE_URL."vacation-rentals/in.".$destinations;
				$propInfoArr 		= $this->fun_getPropertyInfoByFieldName("region_id", $region_id, $property_id, 2);
			} else if ($area_id !="" && $area_id != "0" && $this->fun_countPropertyByAreaId($area_id) > 1) {
				$destinations_name	= $propLocInfoArr['area_name'];
				$destinations		= str_replace("/", "_", str_replace(" ", "-", $destinations_name));
				$link_others 		= SITE_URL."vacation-rentals/in.".$destinations;
				$propInfoArr 		= $this->fun_getPropertyInfoByFieldName("area_id", $area_id, $property_id, 2);
			}
			
			if(is_array($propInfoArr) && count($propInfoArr) > 0) {
				$p_id 			= $propInfoArr['property_id'];
				$p_name 		= $propInfoArr['property_name'];
				$p_title 		= $propInfoArr['property_title'];
				$p_summary 		= $propInfoArr['property_summary'];
				$p_beds 		= ($propInfoArr['total_beds'] > 0)?$propInfoArr['total_beds']:0;
				$p_baths 		= ($propInfoArr['total_bathrooms'] > 0)?$propInfoArr['total_bathrooms']:0;
				$p_sbeds 		= ($propInfoArr['scomfort_beds'] > 0)?$propInfoArr['scomfort_beds']:0;

				$selling_point1 = $propInfoArr['selling_point1'];
				$selling_point2 = $propInfoArr['selling_point2'];
				$selling_point3 = $propInfoArr['selling_point3'];
				$selling_point4 = $propInfoArr['selling_point4'];
				$selling_point5 = $propInfoArr['selling_point5'];
				$selling_point6 = $propInfoArr['selling_point6'];
				$selling_point7 = $propInfoArr['selling_point7'];
				$selling_point8 = $propInfoArr['selling_point8'];
				$selling_point9 = $propInfoArr['selling_point9'];
				$selling_point10 = $propInfoArr['selling_point10'];

				$currency_symbol= $this->fun_findPropertyCurrencySymbol($p_id);
				$priceInfoArr	= $this->fun_getPropertyPriceFromInfoArr($p_id);
				$min_per_night_price 	= number_format($priceInfoArr['min_per_night_price']);
				$max_per_night_price 	= number_format($priceInfoArr['max_per_night_price']);
				$min_per_week_price 	= number_format($priceInfoArr['min_per_week_price']);
				$max_per_week_price 	= number_format($priceInfoArr['max_per_week_price']);

				echo "<table width=\"1005\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
				echo "<tr>";
				echo "<td>";
				echo "<div class=\"info_bottom\">";
				echo "<p><strong class=\"black\">Other vacation properties in ".ucwords($destinations_name)."</strong></p>";
				echo "<p><strong>".$p_name."</strong></p>";
				echo "<p>".$p_title." - <span>Property ".fill_zero_left($p_id, "0", (6-strlen($p_id)))."</span></p>";
				echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
				echo "<tr>";
				echo "<td width=\"49%\">";
				echo "<table width=\"88%\" border=\"0\" cellspacing=\"5\" cellpadding=\"0\" class=\"circle\">";
				echo "<tr>";
				echo "<td class=\"noimage\" colspan=\"2\">";
				echo "<p><strong class=\"black\">".$p_beds." Bedroom, ".$p_baths." Bathrooms, sleeps ".$p_sbeds." </strong></p>";
				echo "</td>";
				echo "</tr>";

				echo "<tr>";
				echo "<tr>";
				echo "<td width=\"5%\" class=\"noimage\">&nbsp;</td>";
				echo "<td width=\"95%\"> ".substr($p_summary, 0, 200)." ...</td>";
				echo "</tr>";
				echo "</tr>";
				if($selling_point1 != "") {
					echo "<tr>";
					echo "<td class=\"noimage\">&nbsp;</td>";
					echo "<td> ".$selling_point1." </td>";
					echo "</tr>";
				}
				if($selling_point2 != "") {
					echo "<tr>";
					echo "<td class=\"noimage\">&nbsp;</td>";
					echo "<td> ".$selling_point2." </td>";
					echo "</tr>";
				}
				if($selling_point3 != "") {
					echo "<tr>";
					echo "<td class=\"noimage\">&nbsp;</td>";
					echo "<td> ".$selling_point3." </td>";
					echo "</tr>";
				}
				if($selling_point4 != "") {
					echo "<tr>";
					echo "<td class=\"noimage\">&nbsp;</td>";
					echo "<td> ".$selling_point4." </td>";
					echo "</tr>";
				}
				if($selling_point5 != "") {
					echo "<tr>";
					echo "<td class=\"noimage\">&nbsp;</td>";
					echo "<td> ".$selling_point5." </td>";
					echo "</tr>";
				}

				if($selling_point6 != "") {
					echo "<tr>";
					echo "<td class=\"noimage\">&nbsp;</td>";
					echo "<td> ".$selling_point6." </td>";
					echo "</tr>";
				}
				if($selling_point7 != "") {
					echo "<tr>";
					echo "<td class=\"noimage\">&nbsp;</td>";
					echo "<td> ".$selling_point7." </td>";
					echo "</tr>";
				}
				if($selling_point8 != "") {
					echo "<tr>";
					echo "<td class=\"noimage\">&nbsp;</td>";
					echo "<td> ".$selling_point8." </td>";
					echo "</tr>";
				}
				if($selling_point9 != "") {
					echo "<tr>";
					echo "<td class=\"noimage\">&nbsp;</td>";
					echo "<td> ".$selling_point9." </td>";
					echo "</tr>";
				}
				if($selling_point10 != "") {
					echo "<tr>";
					echo "<td class=\"noimage\">&nbsp;</td>";
					echo "<td> ".$selling_point10." </td>";
					echo "</tr>";
				}
				echo "</table>";
				echo "</td>";
				echo "<td width=\"51%\" valign=\"top\">";
				echo "<table width=\"88%\" border=\"0\" cellspacing=\"5\" cellpadding=\"0\">";
				echo "<tr>";
				echo "<td>";
				echo "<p><strong class=\"blue_text\">Rates per property (EUR) </strong></p>";
				echo "</td>";
				echo "</tr>";
				echo "<tr>";
				$min_per_night_price 	= number_format($priceInfoArr['min_per_night_price']);
				$max_per_night_price 	= number_format($priceInfoArr['max_per_night_price']);
				$min_per_week_price 	= number_format($priceInfoArr['min_per_week_price']);
				$max_per_week_price 	= number_format($priceInfoArr['max_per_week_price']);

				echo "<td>".$currency_symbol."".$min_per_night_price." - ".$currency_symbol."".$max_per_night_price."/ night</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td>".$currency_symbol."".$min_per_week_price." - ".$currency_symbol."".$max_per_week_price."/ week</td>";
				echo "</tr>";
/*
				echo "<tr>";
				echo "<td>$1500/month</td>";
				echo "</tr>";
*/
				echo "</table>";
				echo "</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td class=\"border\">&nbsp;</td>";
				echo "</tr>";
				echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"border_full\">";
				echo "<tr>";
				echo "<td>";
				echo "<p><strong><a href=\"".$link_others."\">See more vacation rental in ".ucwords($destinations_name)."</a></strong></p>";
				echo "</td>";
				echo "</tr>";
				echo "</table>";
				echo "</table>";
				echo "<div class=\"clear\"></div>";
				echo "</div>";
				echo "</td>";
				echo "</tr>";
				echo "</table>";
			}
		}
	}

/*
* Property Photos spific functions : start here
*/


	// Function	for updating property photos main
	function fun_delPropertyPhoto($photo_id = ''){
		if($photo_id == ''){
			return false;
		} else{
			$strSelectQuery = "SELECT * FROM " . TABLE_PROPERTY_PHOTO_ALL . " WHERE photo_id ='".$photo_id."'";
			$rs = $this->$dbObj->createRecordset($strSelectQuery);
			$arr = $this->$dbObj->fetchAssoc($rs);
			if(count($arr) > 0){
				$tempphoto 	= 'upload/'.$arr[0]['photo_url'];
				$photo 		= 'upload/property_images/large/'.$arr[0]['photo_url'];
				$thumb 		= 'upload/property_images/thumbnail/'.$arr[0]['photo_thumb'];
			}
			// Step II: Delete images and thumbnails
			if($tempphoto != ""){
				@unlink($tempphoto);
			}
			if($photo != ""){
				@unlink($photo);
			}
			if($thumb != ""){
				@unlink($thumb);
			}
		
			// Step III: Delete records from database
			$strDelteQuery = "DELETE FROM " . TABLE_PROPERTY_PHOTO_ALL . " WHERE photo_id='".$photo_id."'";
			$this->$dbObj->mySqlSafeQuery($strDelteQuery);
			return true;
		}
	}

	// Function	for updating property photos main
	function fun_addPropertyPhotos($property_id){
		if($property_id == ''){
			return false;
		} else {
			$photo_caption 	= $_POST['txtPhotoCaption'];
			$cur_unixtime 	= time ();
			if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !=""){
				$cur_user_id 	= $_SESSION['ses_admin_id'];
			} else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !=""){
				$cur_user_id 	= $_SESSION['ses_modarator_id'];
			} else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !=""){
				$cur_user_id 	= $_SESSION['ses_user_id'];
			} else{
				$cur_user_id 	= "";
			}

			$photo_order = $this->dbObj->getField(TABLE_PROPERTY_PHOTO_ALL, "property_id", $property_id, "MAX(photo_order)");
			$strInsQuery = "INSERT INTO " . TABLE_PROPERTY_PHOTO_ALL . " (property_id, photo_caption, photo_url, photo_thumb, photo_order, created_on, created_by, updated_on, updated_by, photo_main) VALUES('".(int)$property_id."', '', '', '', '".((int)$photo_order+1)."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."', '0')";
			$this->dbObj->fun_db_query($strInsQuery);
			return $this->dbObj->fun_db_last_inserted_id();
		}
	}

	// Function	for updating property photos main
	function fun_updatePropertyPhotos($property_id, $photo_id, $photo_caption = '', $photo_main = '', $photo_thumb = ''){
		if($property_id == '' || $photo_id == ''){
			return false;
		} else{
			$strUpdateQuery = "UPDATE " . TABLE_PROPERTY_PHOTO_ALL . " SET photo_caption='".$photo_caption."', photo_url='".$photo_main."', photo_thumb='".$photo_thumb."' WHERE photo_id='".(int)$photo_id."' AND property_id='".(int)$property_id."'";
			$this->dbObj->fun_db_query($strUpdateQuery);
			return true;
		}
	}

	// Function	for updating property photos captions
	function fun_updatePhotoCaptions($property_id, $photo_id_arr = '', $photo_cap_arr = ''){
		if($property_id == '' || $photo_cap_arr == '' || $photo_id_arr == ''){
			return false;
		} else {
			for($i = 0; $i < count($photo_id_arr); $i++) {
				$photo_id 	= $photo_id_arr[$i];
				$photo_cap 	= $photo_cap_arr[$i];

				$sqlUpdateMain = "UPDATE " . TABLE_PROPERTY_PHOTO_ALL . " SET photo_caption = '".$photo_cap."' WHERE photo_id='".(int)$photo_id."' AND property_id='".(int)$property_id."'";
				$this->dbObj->mySqlSafeQuery($sqlUpdateMain);
			}
			return true;
		}
	}


	// Function	for updating property photos main
	function fun_updatePhotosMain($property_id = '', $photo_id = ''){
		if($property_id == '' || $photo_id == ''){
			return false;
		}
		else{

			$sqlUpdate = "UPDATE " . TABLE_PROPERTY_PHOTO_ALL . " SET photo_main = '0' WHERE property_id='".(int)$property_id."'";
			$this->dbObj->fun_db_query($sqlUpdate);

			$sqlUpdateMain = "UPDATE " . TABLE_PROPERTY_PHOTO_ALL . " SET photo_main = '1' WHERE photo_id='".(int)$photo_id."' AND property_id='".(int)$property_id."'";
			$this->dbObj->mySqlSafeQuery($sqlUpdateMain);
			return true;
		}
	}

	// Function	for updating property video
	function fun_updatePropertyVideo($property_id, $video_id, $video_cap, $photo_desc){
		if($property_id == '' || $video_id == ''){
			return false;
		} else {
			$cur_unixtime 	= time ();
			if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !=""){
				$cur_user_id 	= $_SESSION['ses_admin_id'];
			} else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !="") {
				$cur_user_id 	= $_SESSION['ses_modarator_id'];
			} else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !="") {
				$cur_user_id 	= $_SESSION['ses_user_id'];
			} else {
				$cur_user_id 	= "";
			}
			$sqlUpdateMain = "UPDATE " . TABLE_PROPERTY_VIDEO_ALL . " SET video_caption = '".$video_cap."', video_caption = '".$video_cap."', updated_on = '".$cur_unixtime."', updated_by = '".$cur_user_id."' WHERE video_id='".(int)$video_id."' AND property_id='".(int)$property_id."'";
			$this->dbObj->mySqlSafeQuery($sqlUpdateMain);
			return true;
		}
	}

	// Function	for add property video
	function fun_addPropertyVideo($property_id, $video_cap, $photo_desc){
		if($property_id == ''){
			return false;
		} else {
			$cur_unixtime 	= time ();
			if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !=""){
				$cur_user_id 	= $_SESSION['ses_admin_id'];
			} else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !="") {
				$cur_user_id 	= $_SESSION['ses_modarator_id'];
			} else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !="") {
				$cur_user_id 	= $_SESSION['ses_user_id'];
			} else {
				$cur_user_id 	= "";
			}
			$strInsQuery = "INSERT INTO " . TABLE_PROPERTY_VIDEO_ALL . "(video_id, property_id, video_caption, video_url, video_thumb, created_on, created_by, updated_on, updated_by, video_main) ";
			$strInsQuery .= "VALUES(null, '".$property_id."', '".$video_cap."', '".$photo_desc."', '', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."', '1')";
			$this->dbObj->mySqlSafeQuery($strInsQuery);
			return true;
		}
	}

	function fun_getPropertyVideoInfoArr($property_id = ''){	
		if($property_id == ''){
			return false;
		} else {
			if(($video_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_VIDEO_ALL , " WHERE property_id='".$property_id."'")) && (is_array($video_array))){
				return $video_array[0];
			} else {
				return false;
			}
		}
	}

	function fun_getPropertyPhotosAllInfoArr($property_id = ''){	
		// Property photos
		if($property_id == ''){
			return false;
		} else {
			if(($photos_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_PHOTO_ALL , " WHERE property_id='".$property_id."' ORDER BY photo_main, photo_order ASC ")) && (is_array($photos_array))){
				return $photos_array;
			} else {
				return false;
			}
		}
	}

	function fun_countPropertyPhotosAll ( $property_id = '' ) {
		if ( $property_id == '' ) {
			return false;
		} else {
			$sql = "SELECT COUNT(*) total_result FROM  " . TABLE_PROPERTY_PHOTO_ALL . " WHERE property_id='".$property_id."'";
			$rs = $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);
				$total_result = $arr[0]['total_result'];
			}
			else{
				$total_result = 0;
			}
			return $total_result;
		}
	}

	function fun_getPropertyPhotoInfoArr($property_id = '', $imgid = ''){		
		if($property_id == '' || $imgid == ''){
			return false;
		}
		else{
			if(($photo_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_PHOTO_ALL , " WHERE property_id='".$property_id."' AND photo_id='".$imgid."'")) && (is_array($photo_array))){
			return $photo_array;
			}
			else{
				return false;
			}
		}
	}

	// Function to get property main thumbnail image
	function fun_getPropertyMainThumb($property_id = ''){		
		// Property photos
		if($property_id == ''){
			return false;
		}
		else{
			if(($thumb_main_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_PHOTO_ALL , " WHERE property_id='".$property_id."' AND photo_main='1'")) && (is_array($thumb_main_array))){
			//	print_r($thumb_main_array);
				//echo $property_id ; 
				return $thumb_main_array;	
			}
			else if(($thumb_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_PHOTO_ALL , " WHERE property_id='".$property_id."' LIMIT 0, 1")) && (is_array($thumb_array))){
				return $thumb_array;
			}
			else{
				return false;
			}
		}

	}

	// Function for get property last updated date
	function fun_getPropertyLatLong($property_id){
		if($property_id ==""){
			return "";
		} else{
            $sql 	= "SELECT latitude, longitude FROM " . TABLE_PROPERTY . " WHERE property_id='".$property_id."'";
            $rs 	= $this->dbObj->createRecordset($sql);
            $arr 	= $this->dbObj->fetchAssoc($rs);

            return $arr;
        }
	}

	// Function to convert property png image to jpg image
	function fun_convertPropertyImagesPNGtoJPG(){		
		if(($image_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_PHOTO_ALL , " WHERE photo_url LIKE '%.png' ORDER BY created_on")) && (is_array($image_array))){
			foreach($image_array as $value) {
				// image information
				$photo_id 		= $value['photo_id'];
				$photo_url 		= $value['photo_url'];
				$photo_thumb 	= $value['photo_thumb'];
				$photo_url_jpg 	= str_replace(".png", ".jpg", $photo_url);
				$photo_thumb_jpg= str_replace(".png", ".jpg", $photo_thumb);

				// image paths
				$uploadphotodir = 'upload/property_images/large';
				$uploadthumbdir = 'upload/property_images/thumbnail';

				// images
				$uploadphotofile600x450 	= $uploadphotodir ."/600x450/". $photo_url;
				$uploadphotofile480x360 	= $uploadphotodir ."/480x360/". $photo_url;
				$uploadphotofile244x183 	= $uploadphotodir ."/244x183/". $photo_url;

				$convertphotofile480x360 	= $uploadphotodir ."/480x360/". $photo_url_jpg;
				$convertphotofile244x183 	= $uploadphotodir ."/244x183/". $photo_url_jpg;

				// thumbnails
				$uploadthumbfile168x126 	= $uploadthumbdir ."/168x126/". $photo_thumb;
				$uploadthumbfile88x66	 	= $uploadthumbdir ."/88x66/". $photo_thumb;

				$convertthumbfile168x126 	= $uploadthumbdir ."/168x126/". $photo_thumb_jpg;
				$convertthumbfile88x66	 	= $uploadthumbdir ."/88x66/". $photo_thumb_jpg;
				// convert png to jpg

				$image1 			= imagecreatefrompng($uploadphotofile480x360);
				imagejpeg($image1, $convertphotofile480x360);
				imagedestroy($image1);
	
				$image2 			= imagecreatefrompng($uploadphotofile244x183);
				imagejpeg($image2, $convertphotofile244x183);
				imagedestroy($image2);
	
				$image3 			= imagecreatefrompng($uploadthumbfile168x126);
				imagejpeg($image3, $convertthumbfile168x126);
				imagedestroy($image3);

				$image4 			= imagecreatefrompng($uploadthumbfile88x66);
				imagejpeg($image4, $convertthumbfile88x66);
				imagedestroy($image4);

				@unlink($uploadphotofile480x360);
				@unlink($uploadphotofile244x183);

				// thumbnails
				@unlink($uploadthumbfile168x126);
				@unlink($uploadthumbfile88x66);

				$sqlUpdate = "UPDATE " . TABLE_PROPERTY_PHOTO_ALL . " SET photo_url = '".$photo_url_jpg."', photo_thumb = '".$photo_thumb_jpg."' WHERE photo_id='".(int)$photo_id."'";
				$this->dbObj->mySqlSafeQuery($sqlUpdate);
			}
			return true;
		}
	}

/*
* Property Photos spific functions : end here
*/

/*
* Property Video spific functions : start here
*/

	// Function	for delete property video
	function fun_delPropertyVideo($video_id = ''){
		if($video_id == ''){
			return false;
		}
		else{
			$strSelectQuery = "SELECT * FROM " . TABLE_PROPERTY_VIDEO_ALL . " WHERE video_id='".(int)$video_id."'";
			$rs = $this->dbObj->createRecordset($strSelectQuery);
			$arr = $this->dbObj->fetchAssoc($rs);
			if(count($arr) > 0){
				$tempvideo 	= 'upload/'.$arr[0]['video_url'];
				$video 		= 'upload/property_videos/video/'.$arr[0]['video_url'];
				$frame_large= 'upload/property_videos/frame_large/'.$arr[0]['video_thumb'];
				$frame_small= 'upload/property_videos/frame_small/'.$arr[0]['video_thumb'];
			}
			// Step II: Delete images and thumbnails
			if($tempvideo != ""){
				@unlink($tempvideo);
			}
			if($video != ""){
				@unlink($video);
			}
			if($frame_large != ""){
				@unlink($frame_large);
			}
			if($frame_small != ""){
				@unlink($frame_small);
			}
		
			// Step III: Delete records from database
			$strDelteQuery = "DELETE FROM " . TABLE_PROPERTY_VIDEO_ALL . " WHERE video_id='$video_id'";
			$this->dbObj->mySqlSafeQuery($strDelteQuery);
			return true;
		}
	}

	// Function	for updating property videos main
	function fun_updateVideosMain($property_id = '', $video_id = ''){
		if($property_id == '' || $video_id == ''){
			return false;
		}
		else{

			$sqlUpdate = "UPDATE " . TABLE_PROPERTY_VIDEO_ALL . " SET video_main = '0' WHERE property_id='".(int)$property_id."'";
			$this->dbObj->fun_db_query($sqlUpdate);

			$sqlUpdateMain = "UPDATE " . TABLE_PROPERTY_VIDEO_ALL . " SET video_main = '1' WHERE video_id='".(int)$video_id."' AND property_id='".(int)$property_id."'";
			$this->dbObj->mySqlSafeQuery($sqlUpdateMain);
			return true;
		}
	}

	// Function	for updating property videos main
	function fun_updateVideos($property_id = '', $video_id = '', $video_caption = '', $video_main = '', $video_thumb = ''){
		if($property_id == '' || $video_id == ''){
			return false;
		}
		else{
			$sqlUpdate = "UPDATE " . TABLE_PROPERTY_VIDEO_ALL . " SET video_main = '0' WHERE property_id='".(int)$property_id."'";
			$this->dbObj->fun_db_query($sqlUpdate);

			$strUpdateQuery = "UPDATE " . TABLE_PROPERTY_VIDEO_ALL . " SET video_caption='".$video_caption."', video_url='".$video_main."', video_thumb='".$video_thumb."', video_main = '1' WHERE video_id='".(int)$video_id."' AND property_id='".(int)$property_id."'";
			$this->dbObj->fun_db_query($strUpdateQuery);
			return true;
		}
	}

	function fun_getPropertyVideosAllInfoArr($property_id = ''){		
		if($property_id == ''){
			return false;
		}
		else{
			if(($videos_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_VIDEO_ALL , " WHERE property_id='".$property_id."'")) && (is_array($videos_array))){
			return $videos_array;
			}
			else{
				return false;
			}
		}
	}

	function fun_countPropertyVideosAll ( $property_id = '' ) {
		if ( $property_id == '' ) {
			return false;
		} else {
			$sql = "SELECT COUNT(*) total_result FROM  " . TABLE_PROPERTY_VIDEO_ALL . " WHERE property_id='".$property_id."'";
			$rs = $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);
				$total_result = $arr[0]['total_result'];
			}
			else{
				$total_result = 0;
			}
			return $total_result;
		}
	}

	// Function to get property main video info
	function fun_getPropertyVideoMainInfoArr($property_id = ''){		
		if($property_id == ''){
			return false;
		}
		else{
			if(($video_main_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_VIDEO_ALL , " WHERE property_id='".$property_id."' AND video_main='1'")) && (is_array($video_main_array))){
				return $video_main_array;
			}
			else if(($video_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_VIDEO_ALL , " WHERE property_id='".$property_id."' LIMIT 0, 1")) && (is_array($video_array))){
				return $video_array;
			}
			else{
				return false;
			}
		}
	}

/*
* Property Video spific functions : end here
*/

/*
* Property Bed spific functions : start here
*/

	// Function for creating array for bedrooms along with total no. of active property
	function fun_getPropertyBedArrayWithTotalProp(){		
		$propertyBedArray 	= array();		
		$sqlComfortBed = "SELECT MAX(total_beds) AS total_beds FROM " . TABLE_PROPERTY_BEDROOM_RELATIONS. "";
		$rsComfortBed  = $this->dbObj->createRecordset($sqlComfortBed);
		if($this->dbObj->getRecordCount($rsComfortBed) > 0){
			$arr 			= $this->dbObj->fetchAssoc($rsComfortBed);
			$total_beds 	= $arr[0]['total_beds'];
		}
		else{
			$total_beds 	= 0;
		}

		if($total_beds > 0) {

			for($i = 1; $i <= $total_beds; $i++) {
				$total_property 							= $this->fun_countPropertyByPropertyTotalBed($i);
				$propertyBedArray[$i-1]['total_bed'] 		= $i;
				$propertyBedArray[$i-1]['total_bed_text']	= $i." or more ";
				$propertyBedArray[$i-1]['total_properties']	= $total_property;
			}
		}
		return $propertyBedArray;
	}

	// Function for creating array for bedrooms along with total no. of active property
	function fun_getPropertyBedArrayRefineByCriteria($txtcountryids = '', $txtareaids = '', $txtregionids = '', $txtlocationids = '', $txtFromUnixTime = '', $txtToUnixTime = '', $txtpropertytypeids = '', $txtneedsleep = '', $txtonlybed = '', $txttotalbed = '', $txtholidaytypeids = '', $txtkitchenlinenids = '', $txtoutsideids = '', $txtactivitynearbyids = '', $txtheatingcoolingids = '', $txtenterainmentids = '', $txtlocationviewids = '', $txtserviceids = '', $txtgeneralids = '', $featured ='', $latedeal ='', $parameter = '') {
		$property_ids 		= $this->fun_getPropertyIdsByRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids,  $txtFromUnixTime, $txtToUnixTime, $txtpropertytypeids, $txtneedsleep, $txtonlybed, $txttotalbed, $txtholidaytypeids, $txtkitchenlinenids, $txtoutsideids, $txtactivitynearbyids, $txtheatingcoolingids, $txtenterainmentids, $txtlocationviewids, $txtserviceids, $txtgeneralids, $featured, $latedeal, $parameter);
		$propertyBedArray 	= array();
		if(isset($property_ids) && $property_ids !="") {
			$sqlComfortBed 	= "SELECT MAX(B.total_beds) AS total_beds 
			FROM " . TABLE_PROPERTY . " AS A 
			LEFT JOIN " . TABLE_PROPERTY_BEDROOM_RELATIONS . " AS B ON B.property_id = A.property_id 
			WHERE A.active='1' AND A.property_id IN (".$property_ids.")";
		} else {
			$sqlComfortBed 	= "SELECT MAX(total_beds) AS total_beds FROM " . TABLE_PROPERTY_BEDROOM_RELATIONS. "";
		}

		$rsComfortBed  = $this->dbObj->createRecordset($sqlComfortBed);
		if($this->dbObj->getRecordCount($rsComfortBed) > 0){
			$arr 			= $this->dbObj->fetchAssoc($rsComfortBed);
			if($arr[0]['total_beds'] > 0) {
				$total_beds 	= $arr[0]['total_beds'];
			} else {
				$total_beds 	= 12;
			}
		} else {
			$total_beds 	= 12;
		}

		if($total_beds > 0) {
			for($i = 1; $i <= $total_beds; $i++) {
				$total_property 							= $this->fun_countRefinePropertyByPropertyTotalBed($i, $txtcountryids, $txtareaids, $txtregionids, $txtlocationids,  $txtFromUnixTime, $txtToUnixTime, $txtpropertytypeids, $txtneedsleep, $txtonlybed, $txttotalbed, $txtholidaytypeids, $txtkitchenlinenids, $txtoutsideids, $txtactivitynearbyids, $txtheatingcoolingids, $txtenterainmentids, $txtlocationviewids, $txtserviceids, $txtgeneralids, $parameter);
				$propertyBedArray[$i-1]['total_bed'] 		= $i;
				$propertyBedArray[$i-1]['total_bed_text']	= $i." or more ";
				$propertyBedArray[$i-1]['total_properties']	= $total_property;
			}
		}
		return $propertyBedArray;
	}

	function fun_getPropertyIdsRefineByLocation($txtareaids = '', $txtregionids = '', $txtlocationids = '') {
		if((isset($txtareaids) && $txtareaids !="") && (!isset($txtregionids) && $txtregionids =="") && (!isset($txtlocationids) && $txtlocationids =="")) {
			$propertyIdByAreaArr = array();
			if(substr($txtareaids, 0,1) == ",") {
				$txtareaids = substr($txtareaids, 1,strlen($txtareaids));
			}
			if(substr($txtareaids, strlen($txtareaids)-1, strlen($txtareaids)) == ",") {
				$txtareaids = substr($txtareaids, 0,strlen($txtareaids)-1);
			}
			//Step II: select regions of that area
			if(($region_relation_array = $this->fun_findPropertyRelationInfo(TABLE_REGION , " WHERE area_id IN (".$txtareaids.")")) && (is_array($region_relation_array))){
				$regionidsByAreaArr		= array();
				for($j = 0; $j < count($region_relation_array); $j++) {
					array_push($regionidsByAreaArr, "'".$region_relation_array[$j]['region_id']."'");
				}
				$regionids = implode(",", array_unique($regionidsByAreaArr));
				//Step III: select locations of that region
				if(($regionids != "") && ($loc_relation_array = $this->fun_findPropertyRelationInfo(TABLE_LOCATION , " WHERE region_id IN (".$regionids.")")) && (is_array($loc_relation_array))){
					$locationidsArr		= array();
					for($j = 0; $j < count($loc_relation_array); $j++) {
						array_push($locationidsArr, "'".$loc_relation_array[$j]['location_id']."'");
					}
					$locationids = implode(",", array_unique($locationidsArr));
				}
			}
			if(isset($locationids) && $locationids != "") {
				//Step IV: select properties by locationids
				$sqlAreaProp		= "SELECT A.property_id AS property_id FROM " . TABLE_PROPERTY . " AS A  WHERE A.location_id IN (".$locationids.") ";
				$rsAreaProp 		= $this->dbObj->createRecordset($sqlAreaProp);
				if($this->dbObj->getRecordCount($rsAreaProp) > 0) {
					$arrAreaProp = $this->dbObj->fetchAssoc($rsAreaProp);
					for($i = 0; $i < count($arrAreaProp); $i++) {
						//Step IV: Push it to array
						array_push($propertyIdByAreaArr, "'".$arrAreaProp[$i]['property_id']."'");
					}
				}
			}
		}
		if((isset($txtregionids) && $txtregionids !="") && (!isset($txtlocationids) && $txtlocationids =="")) {
			$propertyIdByRegionArr = array();
			if(substr($txtregionids, 0,1) == ",") {
				$txtregionids = substr($txtregionids, 1,strlen($txtregionids));
			}
			if(substr($txtregionids, strlen($txtregionids)-1, strlen($txtregionids)) == ",") {
				$txtregionids = substr($txtregionids, 0,strlen($txtregionids)-1);
			}
			//Step III: select locations of that region
            if(($txtregionids != "")) {
                $locationidsArr		= array();
                $regionidsArr		= array();
                if(($subregion_relation_array = $this->fun_findPropertyRelationInfo(TABLE_REGION , " WHERE pregion_id IN (".$txtregionids.")")) && (is_array($subregion_relation_array))){
                    for($i = 0; $i < count($subregion_relation_array); $i++) {
                        array_push($regionidsArr, $subregion_relation_array[$i]['region_id']);
                    }
                }
                $regionidsArrTemp = explode(",", $txtregionids);
                for($k = 0; $k < count($regionidsArrTemp); $k++) {
                    array_push($regionidsArr, $regionidsArrTemp[$k]);
                }
                $txtregionids = implode(",", array_unique($regionidsArr));
                if(($loc_relation_array = $this->fun_findPropertyRelationInfo(TABLE_LOCATION , " WHERE region_id IN (".$txtregionids.")")) && (is_array($loc_relation_array))){
                    for($j = 0; $j < count($loc_relation_array); $j++) {
                        array_push($locationidsArr, "'".$loc_relation_array[$j]['location_id']."'");
                    }
                    $locationids = implode(",", array_unique($locationidsArr));
                }
            }
			if(isset($locationids) && $locationids != "") {
				//Step IV: select properties by locationids
				$sqlRegionProp		= "SELECT A.property_id AS property_id FROM " . TABLE_PROPERTY . " AS A  WHERE A.location_id IN (".$locationids.") ";
				$rsRegionProp 		= $this->dbObj->createRecordset($sqlRegionProp);
				if($this->dbObj->getRecordCount($rsRegionProp) > 0) {
					$arrRegionProp = $this->dbObj->fetchAssoc($rsRegionProp);
					for($i = 0; $i < count($arrRegionProp); $i++) {
						//Step IV: Push it to array
						array_push($propertyIdByRegionArr, "'".$arrRegionProp[$i]['property_id']."'");
					}
				}
			}
		}
		if((isset($txtlocationids) && $txtlocationids !="")) {
			$propertyIdByLocationArr = array();
			if(substr($txtlocationids, 0,1) == ",") {
				$txtlocationids = substr($txtlocationids, 1,strlen($txtlocationids));
			}
			if(substr($txtlocationids, strlen($txtlocationids)-1, strlen($txtlocationids)) == ",") {
				$txtlocationids = substr($txtlocationids, 0,strlen($txtlocationids)-1);
			}
			$sqlLocProp		= "SELECT A.property_id AS property_id FROM " . TABLE_PROPERTY . " AS A  WHERE A.location_id IN (".$txtlocationids.") ";
			$rsLocProp 		= $this->dbObj->createRecordset($sqlLocProp);
			if($this->dbObj->getRecordCount($rsLocProp) > 0) {
				$arrLocProp = $this->dbObj->fetchAssoc($rsLocProp);
				for($i = 0; $i < count($arrLocProp); $i++) {
					array_push($propertyIdByLocationArr, "'".$arrLocProp[$i]['property_id']."'");
				}
			}
		}

		$propertyIdArr = array();
		if(is_array($propertyIdByLocationArr) && count($propertyIdByLocationArr) > 0) {
			$propertyIdArr = $propertyIdByLocationArr;
		} else if(is_array($propertyIdByRegionArr) && count($propertyIdByRegionArr) > 0) {
			$propertyIdArr = $propertyIdByRegionArr;
		} else if(is_array($propertyIdByAreaArr) && count($propertyIdByAreaArr) > 0) {
			$propertyIdArr = $propertyIdByAreaArr;
		}
		$property_ids = "";
		if(count($propertyIdArr) > 0) {
			$property_ids = implode(",", array_keys(array_flip($propertyIdArr)));
		}
		return $property_ids;
	}

	function fun_countPropertyByPropertyTotalBed ( $total_bed = '' ) {
		if ( $total_bed == '' ) {
			return false;
		} else {
			$sql = "SELECT COUNT(*) total_result 
			FROM  " . TABLE_PROPERTY . " AS A
			INNER JOIN " . TABLE_PROPERTY_BEDROOM_RELATIONS . " AS B ON B.property_id = A.property_id
			WHERE B.total_beds >= ".$total_bed." AND A.active='1'";

			$rs = $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);
				$total_result = $arr[0]['total_result'];
			}
			else{
				$total_result = 0;
			}
			return $total_result;
		}
	}
	// Function for creating array for bedrooms along with total no. of active property
	function fun_getRefinePropertyBedArrayWithTotalProp($txtcountryids = '', $txtareaids = '', $txtregionids = '', $txtlocationids = '',  $txtFromUnixTime = '', $txtToUnixTime = '', $txtpropertytypeids = '', $txtneedsleep = '', $txtonlybed = '', $txttotalbed = '', $txtholidaytypeids = '', $txtkitchenlinenids = '', $txtoutsideids = '', $txtactivitynearbyids = '', $txtheatingcoolingids = '', $txtenterainmentids = '', $txtlocationviewids = '', $txtserviceids = '', $txtgeneralids = '', $parameter = ''){		
		$propertyBedArray 	= array();		
		$sqlComfortBed = "SELECT MAX(total_beds) AS total_beds FROM " . TABLE_PROPERTY_BEDROOM_RELATIONS. "";
		$rsComfortBed  = $this->dbObj->createRecordset($sqlComfortBed);
		if($this->dbObj->getRecordCount($rsComfortBed) > 0){
			$arr 			= $this->dbObj->fetchAssoc($rsComfortBed);
			$total_beds 	= $arr[0]['total_beds'];
		}
		else{
			$total_beds 	= 0;
		}

		if($total_beds > 0) {

			for($i = 1; $i <= $total_beds; $i++) {
				$total_property 							= $this->fun_countRefinePropertyByPropertyTotalBed($i, $txtcountryids, $txtareaids, $txtregionids, $txtlocationids,  $txtFromUnixTime, $txtToUnixTime, $txtpropertytypeids, $txtneedsleep, $txtonlybed, $txttotalbed, $txtholidaytypeids, $txtkitchenlinenids, $txtoutsideids, $txtactivitynearbyids, $txtheatingcoolingids, $txtenterainmentids, $txtlocationviewids, $txtserviceids, $txtgeneralids, $parameter);
				$propertyBedArray[$i-1]['total_bed'] 		= $i;
				$propertyBedArray[$i-1]['total_bed_text']	= $i." or more ";
				$propertyBedArray[$i-1]['total_properties']	= $total_property;
			}
		}
		return $propertyBedArray;
	}


	function fun_countRefinePropertyByPropertyTotalBed ( $total_bed = '', $txtcountryids = '', $txtareaids = '', $txtregionids = '', $txtlocationids = '',  $txtFromUnixTime = '', $txtToUnixTime = '', $txtpropertytypeids = '', $txtneedsleep = '', $txtonlybed = '', $txttotalbed = '', $txtholidaytypeids = '', $txtkitchenlinenids = '', $txtoutsideids = '', $txtactivitynearbyids = '', $txtheatingcoolingids = '', $txtenterainmentids = '', $txtlocationviewids = '', $txtserviceids = '', $txtgeneralids = '', $parameter = '') {
		if ( $total_bed == '' ) {
			return false;
		} else {
			$sql = "SELECT COUNT(*) total_result 
			FROM  " . TABLE_PROPERTY . " AS A
			INNER JOIN " . TABLE_PROPERTY_BEDROOM_RELATIONS . " AS B ON B.property_id = A.property_id
			WHERE B.total_beds >= ".$total_bed." AND A.active='1'";

			$rs = $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);
				$refine_prop = $this->fun_countRefineProperty($txtcountryids, $txtareaids, $txtregionids, $txtlocationids,  $txtFromUnixTime, $txtToUnixTime, $txtpropertytypeids, $txtneedsleep, $txtonlybed, $txttotalbed, $txtholidaytypeids, $txtkitchenlinenids, $txtoutsideids, $txtactivitynearbyids, $txtheatingcoolingids, $txtenterainmentids, $txtlocationviewids, $txtserviceids, $txtgeneralids, $parameter);
				if(((int)$arr[0]['total_result'] > (int)$refine_prop) && ($refine_prop > 0) ) {
					$total_result = $refine_prop;
				} else {
					$total_result = $arr[0]['total_result'];
				}
			}
			else{
				$total_result = 0;
			}
			return $total_result;
		}
	}

	function fun_countPropertyByPropertyComfortSleep ( $min_comfort_sleep = '' ) {
		if ( $min_comfort_sleep == '' ) {
			return false;
		} else {
			$sql = "SELECT COUNT(*) total_result 
			FROM  " . TABLE_PROPERTY . " AS A
			INNER JOIN " . TABLE_PROPERTY_BEDROOM_RELATIONS . " AS B ON B.property_id = A.property_id
			WHERE B.scomfort_beds >= ".$min_comfort_sleep." AND A.active='1'";

			$rs = $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);
				$total_result = $arr[0]['total_result'];
			}
			else{
				$total_result = 0;
			}
			return $total_result;
		}
	}

	// Function for creating array for property_type along with total no. of actice property
	function fun_getPropertySleepArrayWithTotalProp(){		
		$propertySleepArray 	= array();		
		$sqlComfortSleep = "SELECT MAX(scomfort_beds) AS maximum_sleep FROM " . TABLE_PROPERTY_BEDROOM_RELATIONS. "";
		$rsComfortSleep  = $this->dbObj->createRecordset($sqlComfortSleep);
		if($this->dbObj->getRecordCount($rsComfortSleep) > 0){
			$arr 			= $this->dbObj->fetchAssoc($rsComfortSleep);
			$maximum_sleep 	= $arr[0]['maximum_sleep'];
		}
		else{
			$maximum_sleep 	= 0;
		}

		if($maximum_sleep > 0) {

			for($i = 1; $i <= $maximum_sleep; $i++) {
				$total_property 							= $this->fun_countPropertyByPropertyComfortSleep($i);
				$propertySleepArray[$i-1]['comfort_bed'] 		= $i;
				$propertySleepArray[$i-1]['comfort_bed_text']	= $i." or more ";
				$propertySleepArray[$i-1]['total_properties']	= $total_property;
			}
		}
		return $propertySleepArray;
	}

	// Function for creating array for property_type along with total no. of actice property
	function fun_getRefinePropertySleepArrayWithTotalProp($txtcountryids = '', $txtareaids = '', $txtregionids = '', $txtlocationids = '',  $txtFromUnixTime = '', $txtToUnixTime = '', $txtpropertytypeids = '', $txtneedsleep = '', $txtonlybed = '', $txttotalbed = '', $txtholidaytypeids = '', $txtkitchenlinenids = '', $txtoutsideids = '', $txtactivitynearbyids = '', $txtheatingcoolingids = '', $txtenterainmentids = '', $txtlocationviewids = '', $txtserviceids = '', $txtgeneralids = '', $parameter = ''){		
		$propertySleepArray 	= array();		
		$sqlComfortSleep = "SELECT MAX(scomfort_beds) AS maximum_sleep FROM " . TABLE_PROPERTY_BEDROOM_RELATIONS. "";
		$rsComfortSleep  = $this->dbObj->createRecordset($sqlComfortSleep);
		if($this->dbObj->getRecordCount($rsComfortSleep) > 0){
			$arr 			= $this->dbObj->fetchAssoc($rsComfortSleep);
			$maximum_sleep 	= $arr[0]['maximum_sleep'];
		} else {
			$maximum_sleep 	= 0;
		}

		if($maximum_sleep > 0) {

			for($i = 1; $i <= $maximum_sleep; $i++) {
				$total_property 							= $this->fun_countRefinePropertyByPropertyComfortSleep($i, $txtcountryids, $txtareaids, $txtregionids, $txtlocationids,  $txtFromUnixTime, $txtToUnixTime, $txtpropertytypeids, $txtneedsleep, $txtonlybed, $txttotalbed, $txtholidaytypeids, $txtkitchenlinenids, $txtoutsideids, $txtactivitynearbyids, $txtheatingcoolingids, $txtenterainmentids, $txtlocationviewids, $txtserviceids, $txtgeneralids, $parameter);
				$propertySleepArray[$i-1]['comfort_bed'] 		= $i;
				$propertySleepArray[$i-1]['comfort_bed_text']	= $i." or more ";
				$propertySleepArray[$i-1]['total_properties']	= $total_property;
			}
		}
		return $propertySleepArray;
	}

	// Function for creating array for property_type along with total no. of actice property
	function fun_getPropertySleepArrayRefineByCriteria($txtcountryids = '', $txtareaids = '', $txtregionids = '', $txtlocationids = '', $txtFromUnixTime = '', $txtToUnixTime = '', $txtpropertytypeids = '', $txtneedsleep = '', $txtonlybed = '', $txttotalbed = '', $txtholidaytypeids = '', $txtkitchenlinenids = '', $txtoutsideids = '', $txtactivitynearbyids = '', $txtheatingcoolingids = '', $txtenterainmentids = '', $txtlocationviewids = '', $txtserviceids = '', $txtgeneralids = '', $featured ='', $latedeal ='', $parameter = '') {
		$property_ids = $this->fun_getPropertyIdsByRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids,  $txtFromUnixTime, $txtToUnixTime, $txtpropertytypeids, $txtneedsleep, $txtonlybed, $txttotalbed, $txtholidaytypeids, $txtkitchenlinenids, $txtoutsideids, $txtactivitynearbyids, $txtheatingcoolingids, $txtenterainmentids, $txtlocationviewids, $txtserviceids, $txtgeneralids, $featured, $latedeal, $parameter);
		$propertySleepArray 	= array();
		if(isset($property_ids) && $property_ids !="") {
			$sqlComfortSleep = "SELECT MAX(B.scomfort_beds) AS maximum_sleep 
			FROM " . TABLE_PROPERTY . " AS A 
			LEFT JOIN " . TABLE_PROPERTY_BEDROOM_RELATIONS . " AS B ON B.property_id = A.property_id 
			WHERE A.active='1' AND A.property_id IN (".$property_ids.")";
		} else {
			$sqlComfortSleep = "SELECT MAX(scomfort_beds) AS maximum_sleep FROM " . TABLE_PROPERTY_BEDROOM_RELATIONS. "";
		}
		$rsComfortSleep  = $this->dbObj->createRecordset($sqlComfortSleep);
		if($this->dbObj->getRecordCount($rsComfortSleep) > 0){
			$arr 			= $this->dbObj->fetchAssoc($rsComfortSleep);
			if($arr[0]['maximum_sleep'] > 0) {
				$maximum_sleep 	= $arr[0]['maximum_sleep'];
			} else {
				$maximum_sleep 	= 12;
			}
		} else {
			$maximum_sleep 	= 12;
		}

		if($maximum_sleep > 0) {

			for($i = 1; $i <= $maximum_sleep; $i++) {
				$total_property 								= $this->fun_countRefinePropertyByPropertyComfortSleep($i, $txtcountryids, $txtareaids, $txtregionids, $txtlocationids,  $txtFromUnixTime, $txtToUnixTime, $txtpropertytypeids, $txtneedsleep, $txtonlybed, $txttotalbed, $txtholidaytypeids, $txtkitchenlinenids, $txtoutsideids, $txtactivitynearbyids, $txtheatingcoolingids, $txtenterainmentids, $txtlocationviewids, $txtserviceids, $txtgeneralids, $parameter);
				$propertySleepArray[$i-1]['comfort_bed'] 		= $i;
				$propertySleepArray[$i-1]['comfort_bed_text']	= $i." or more ";
				$propertySleepArray[$i-1]['total_properties']	= $total_property;
			}
		}
		return $propertySleepArray;
	}

	function fun_countRefinePropertyByPropertyComfortSleep ( $min_comfort_sleep = '', $txtcountryids = '', $txtareaids = '', $txtregionids = '', $txtlocationids = '',  $txtFromUnixTime = '', $txtToUnixTime = '', $txtpropertytypeids = '', $txtneedsleep = '', $txtonlybed = '', $txttotalbed = '', $txtholidaytypeids = '', $txtkitchenlinenids = '', $txtoutsideids = '', $txtactivitynearbyids = '', $txtheatingcoolingids = '', $txtenterainmentids = '', $txtlocationviewids = '', $txtserviceids = '', $txtgeneralids = '', $parameter = '') {
		if ( $min_comfort_sleep == '' ) {
			return false;
		} else {
			$sql = "SELECT COUNT(*) total_result 
			FROM  " . TABLE_PROPERTY . " AS A
			INNER JOIN " . TABLE_PROPERTY_BEDROOM_RELATIONS . " AS B ON B.property_id = A.property_id
			WHERE B.scomfort_beds >= ".$min_comfort_sleep." AND A.active='1'";

			$rs = $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);
				$refine_prop = $this->fun_countRefineProperty($txtcountryids, $txtareaids, $txtregionids, $txtlocationids,  $txtFromUnixTime, $txtToUnixTime, $txtpropertytypeids, $txtneedsleep, $txtonlybed, $txttotalbed, $txtholidaytypeids, $txtkitchenlinenids, $txtoutsideids, $txtactivitynearbyids, $txtheatingcoolingids, $txtenterainmentids, $txtlocationviewids, $txtserviceids, $txtgeneralids, $parameter);
				if(((int)$arr[0]['total_result'] > (int)$refine_prop) && ($refine_prop > 0) ) {
					$total_result = $refine_prop;
				} else {
					$total_result = $arr[0]['total_result'];
				}
			}
			else{
				$total_result = 0;
			}
			return $total_result;
		}
	}

	function fun_getPropertyBedAllInfoArr($property_id = ''){	
		if($property_id == ''){
			return false;
		}
		else{
			if(($bed_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_BEDROOM_RELATIONS , " WHERE property_id='".$property_id."'")) && (is_array($bed_array))){
			return $bed_array;
			}
			else{
				return false;
			}
		}
	}

	// Function for creating property features section
	function fun_createPropertyBedroom4PropertyPriview($property_id){		
		$bedArr = $this->fun_getPropertyBedAllInfoArr($property_id);
		$total_beds 	= $bedArr[0]['total_beds'];
		$ensuite_beds 	= $bedArr[0]['ensuite_beds'];
		$scomfort_beds 	= $bedArr[0]['scomfort_beds'];
		$double_beds 	= $bedArr[0]['double_beds'];
		$single_beds 	= $bedArr[0]['single_beds'];
		$sofa_beds 		= $bedArr[0]['sofa_beds'];
		$cots 			= $bedArr[0]['cots'];
		$notes 			= $bedArr[0]['notes'];
		$bdrapts1       = $bedArr[0]['bdrapts1'];
		$bdrapts2       = $bedArr[0]['bdrapts2'];
		$bdrapts3       = $bedArr[0]['bdrapts3'];
		$bdrapts4       = $bedArr[0]['bdrapts4'];
		$bdrapts5       = $bedArr[0]['bdrapts5'];
		$complex_unit_type= $bedArr[0]['complex_unit_type'];

		echo "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">";
		echo "<tr><td colspan=\"2\" class=\"owner-headings1 pad-btm8 dash-btm\">Bedrooms</td></tr>";
		if($total_beds > 0) {
			echo "<tr class=\"Summary\">";
			echo "<td>Number of bedrooms</td>";
			echo "<td class=\"pad-rgt10\">".$total_beds."</td>";
			echo "</tr>";
		}
		
		if($ensuite_beds > 0) {
			echo "<tr class=\"Summary\">";
			echo "<td>How many have en-suite?</td>";
			echo "<td class=\"pad-rgt10\">".$ensuite_beds."</td>";
			echo "</tr>";
		}
		
		if($scomfort_beds > 0) {
			echo "<tr class=\"Summary\">";
			echo "<td>The property can comfortably sleeps</td>";
			echo "<td class=\"pad-rgt10\">".$scomfort_beds."</td>";
			echo "</tr>";
		}

		echo "<tr><td colspan=\"2\" class=\"grey-txt14 pad-btm8 pad-top15 dash-btm\">Details</td></tr>";
		if($double_beds > 0) {
			echo "<tr class=\"Summary\">";
			echo "<td>Double beds</td>";
			echo "<td class=\"pad-rgt10\">".$double_beds."</td>";
			echo "</tr>";
		}
		if($single_beds > 0) {
			echo "<tr class=\"Summary\">";
			echo "<td>Single beds</td>";
			echo "<td class=\"pad-rgt10\">".$single_beds."</td>";
			echo "</tr>";
		}
		if($sofa_beds > 0) {
			echo "<tr class=\"Summary\">";
			echo "<td>Twin beds</td>";
			echo "<td class=\"pad-rgt10\">".$sofa_beds."</td>";
			echo "</tr>";
		}
				if($bdrapts1 > 0) {
			echo "<tr class=\"Summary\">";
			echo "<td>1 bdr apts</td>";
			echo "<td class=\"pad-rgt10\">".$bdrapts1."</td>";
			echo "</tr>";
		}
		if($bdrapts2  > 0) {
			echo "<tr class=\"Summary\">";
			echo "<td>2 bdr apts</td>";
			echo "<td class=\"pad-rgt10\">".$bdrapts2 ."</td>";
			echo "</tr>";
		}
		if($bdrapts3   > 0) {
			echo "<tr class=\"Summary\">";
			echo "<td>3 bdr apts</td>";
			echo "<td class=\"pad-rgt10\">".$bdrapts3  ."</td>";
			echo "</tr>";
		}
		if($bdrapts4   > 0) {
			echo "<tr class=\"Summary\">";
			echo "<td>4 bdr apts</td>";
			echo "<td class=\"pad-rgt10\">".$bdrapts4  ."</td>";
			echo "</tr>";
		}
		
		if($bdrapts5  > 0) {
			echo "<tr class=\"Summary\">";
			echo "<td>Studio</td>";
			echo "<td class=\"pad-rgt10\">".$bdrapts5 ."</td>";
			echo "</tr>";
		}

		/*
		if($complex_unit_type  > 0) {
			echo "<tr class=\"Summary\">";
			echo "<td>Unit types of the complex</td>";
			echo "<td class=\"pad-rgt10\">";
			switch($complex_unit_type) {
				case 1:
				echo "Two bdr apts & studios";
				break;
			
				case 2:
				echo "One bdr apts, two bdr apts & studios";
				break;
			
				case 3:
				echo "One bdr apts, & two bdr apts";
				break;
			
				case 4:
				echo "One bdr apts, two bdr apts, Three bdr apts";
				break;
			
				case 5:
				echo "One bdr apts, & Three bdr apts";
				break;
			
				case 6:
				echo "Two bdr apts, three bdr apts, & studios";
				break;
			
				case 7:
				echo "One bedroom apts";
				break;
			
				case 8:
				echo "Two bedroom apts";
				break;

			    case 9:
				echo "Three bedroom apts";
				break;

			    case 10:
				echo "Four bedrooms apts";
				break;

			    case 11:
				echo "Studios";
				break;

			    case 12:
				echo "Twin & tripple rooms";
				break;

			    case 13:
				echo "Rooms only";
				break;

			}
			echo "</td>";
			echo "</tr>";
		}
		*/

		if($cots > 0) {
			echo "<tr class=\"Summary\">";
			echo "<td>Cots</td>";
			echo "<td class=\"pad-rgt10\">".$cots."</td>";
			echo "</tr>";
		}
		
		echo "<tr>";
		echo "<td class=\"pad-top18 pad-btm20 editor-txt\">".$notes."</td>";
		echo "</tr>";
		echo "</table>";
	}

/*
* Property Bed spific functions : end here
*/

/*
* Property Bath spific functions : start here
*/
	function fun_getPropertyBathAllInfoArr($property_id = ''){	
		if($property_id == ''){
			return false;
		} else{
			if(($bath_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_BATHROOM_RELATIONS , " WHERE property_id='".$property_id."'")) && (is_array($bath_array))){
			return $bath_array;
			} else{
				return false;
			}
		}
	}

	// Function for creating property bathroom section for property priview
	function fun_createPropertyBathroom4PropertyPriview($property_id){		
		$bathArr = $this->fun_getPropertyBathAllInfoArr($property_id);

		$total_bathrooms 	= $bathArr[0]['total_bathrooms'];
		$ensuite_baths 		= $bathArr[0]['ensuite_baths'];
		$shower_baths 		= $bathArr[0]['shower_baths'];
		$baths 				= $bathArr[0]['baths'];
		$toilets 			= $bathArr[0]['toilets'];
		$notes 				= $bathArr[0]['notes'];

		echo "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
		echo "<tr><td colspan=\"2\" class=\"owner-headings1 pad-btm8 dash-btm\">Bathroom</td></tr>";
		if($total_bathrooms > 0) {
			echo "<tr class=\"Summary\">";
			echo "<td>Number of bathrooms</td>";
			echo "<td class=\"pad-rgt10\">".$total_bathrooms."</td>";
			echo "</tr>";
		}

		echo "<tr><td colspan=\"2\" class=\"grey-txt14 pad-btm10 pad-top15 dash-btm\">Details</td></tr>";
		if($ensuite_baths > 0) {
			echo "<tr class=\"Summary\">";
			echo "<td>En-suite</td>";
			echo "<td class=\"pad-rgt10\">".$ensuite_baths."</td>";
			echo "</tr>";
		}
		if($shower_baths > 0) {
			echo "<tr class=\"Summary\">";
			echo "<td>Shower rooms</td>";
			echo "<td class=\"pad-rgt10\">".$shower_baths."</td>";
			echo "</tr>";
		}
		if($baths > 0) {
			echo "<tr class=\"Summary\">";
			echo "<td>Baths</td>";
			echo "<td class=\"pad-rgt10\">".$baths."</td>";
			echo "</tr>";
		}
		if($toilets > 0) {
			echo "<tr class=\"Summary\">";
			echo "<td>Toilets</td>";
			echo "<td class=\"pad-rgt10\">".$toilets."</td>";
			echo "</tr>";
		}
		echo "<tr>";
		echo "<td class=\"pad-top15 editor-txt\">".$notes."</td>";
		echo "</tr>";
		echo "</table>";
	}

	// Function for creating property Distances in holiday priview section
	function fun_createPropertyStat4Owner($property_id) {
		if($property_id == "") {
			return false;
		} else {
			$sql = "SELECT A.property_id, 
				A.property_name, 
				A.property_title,
				A.status,
				A.rating,
				A.friendly_link,
				A.created_on,
				A.created_by,
				A.active_on,
				A.active_by,
				A.updated_on,
				A.updated_by,
				A.featured,
				A.active
				FROM " . TABLE_PROPERTY . " AS A 
				WHERE A.property_id='".$property_id."'";
			$rs 		= $this->dbObj->createRecordset($sql);
			$arr 		= $this->dbObj->fetchAssoc($rs);
			$active_on 	= $arr[0]['active_on'];
			$updated_on	= $arr[0]['updated_on'];

			$propLocInfoArr = $this->fun_getPropertyLocInfoArr($property_id);
			$location_name = "";
			if($propLocInfoArr['location_name'] !=""){
				$location_name = $propLocInfoArr['location_name'];
			} else if ($propLocInfoArr['subregion_name'] !="") {
				$location_name = $propLocInfoArr['subregion_name'];
			} else if ($propLocInfoArr['region_name'] !="") {
				$location_name = $propLocInfoArr['region_name'];
			} else if ($propLocInfoArr['area_name'] !="") {
				$location_name = $propLocInfoArr['area_name'];
			}

			$total_views 			= $this->fun_countPropertyVisit($property_id);
//			$total_views 			= $this->fun_countPropertyTotalViews($property_id);
//			$avg_month_views 		= number_format(round(($total_views/12), 2));
			$total_favourite_saved 	= $this->fun_countPropertySavedAsFavourites($property_id);
			$total_enquiries 		= $this->fun_countPropertyEnquiries($property_id);
			$avg_month_enquiries 	= number_format(round(($total_enquiries/12), 2));
			$cur_year_booked_days 	= $this->fun_countPropertyCurrentYearBooking($property_id);

			echo "<table width=\"210\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"propListing\">\n";
			if($active_on > 0) {
				$first_advertised		= date('M j, y', $active_on);
				$days_advertised		= (int)((time () - $active_on) / (60 * 60 * 24));
				echo "<tr><td class=\"dashed\" valign=\"top\" width=\"120px\"><span>First advertised</span></td><td>".$first_advertised."</td></tr>\n";
				echo "<tr><td class=\"dashed\" valign=\"top\"><span>Total days advertised</span></td><td>".$days_advertised."</td></tr>\n";
			} else {
				echo "<tr><td class=\"dashed\" valign=\"top\" width=\"120px\"><span>First advertised</span></td><td> -- </td></tr>\n";
				echo "<tr><td class=\"dashed\" valign=\"top\"><span>Total days advertised</span></td><td>0</td></tr>\n";
			}

			if($updated_on != "") {
				$last_updated		= date('M j, y', $updated_on);
				echo "<tr><td class=\"dashed\" valign=\"top\"><span>Last updated</span></td><td>".$last_updated."</td></tr>\n";
			}
			if($location_name != "") {
				echo "<tr><td class=\"dashed\" valign=\"top\"><span>Location</span></td><td align=\"left\">".trim($location_name)."</td></tr>";
			}
			if($total_views != "") {
				echo "<tr><td class=\"dashed\" valign=\"top\"><span>Total views</span></td><td>".$total_views."</td></tr>\n";
			} else {
				echo "<tr><td class=\"dashed\" valign=\"top\"><span>Total views</span></td><td>0</td></tr>\n";
			}
			if($avg_month_views != "") {
				echo "<tr><td class=\"dashed\" valign=\"top\"><span>Avg views per month</span></td><td>".$avg_month_views."</td></tr>\n";
			} else {
				echo "<tr><td class=\"dashed\" valign=\"top\"><span>Avg views per month</span></td><td>0</td></tr>\n";
			}
			if($total_favourite_saved != "") {
				echo "<tr><td class=\"dashed\" valign=\"top\"><span>Total saved as favourite</span></td><td>".number_format($total_favourite_saved)."</td></tr>\n";
			} else {
				echo "<tr><td class=\"dashed\" valign=\"top\"><span>Total saved as favourite</span></td><td>0</td></tr>\n";
			}
			if($total_enquiries != "") {
				echo "<tr><td class=\"dashed\" valign=\"top\"><span>Total enquiries</span></td><td>".number_format($total_enquiries)."</td></tr>\n";
			} else {
				echo "<tr><td class=\"dashed\" valign=\"top\"><span>Total enquiries</span></td><td>0</td></tr>\n";
			}
			if($avg_month_enquiries != "") {
				echo "<tr><td class=\"dashed\" valign=\"top\"><span>Avg enquiries per month</span></td><td>".number_format($avg_month_enquiries)."</td></tr>\n";
			} else {
				echo "<tr><td class=\"dashed\" valign=\"top\"><span>Avg enquiries per month</span></td><td>0</td></tr>\n";
			}
			if($cur_year_booked_days != "") {
				echo "<tr><td class=\"dashed\" valign=\"top\"><span>Days booked ".date('Y')."</span></td><td>".number_format($cur_year_booked_days)."</td></tr>\n";
			} else {
				echo "<tr><td class=\"dashed\" valign=\"top\"><span>Days booked ".date('Y')."</span></td><td>0</td></tr>\n";
			}
			/*
			if($cur_year_booked_days != "") {
				echo "<tr><td class=\"dashed\"><span>Days booked ".date('Y')."</span></td><td>".number_format($cur_year_booked_days)."</td></tr>\n";
			} else {
				echo "<tr><td class=\"dashed\"><span>Days booked ".date('Y')."</span></td><td>0</td></tr>\n";
			}
			*/
			echo "</table>";
		}
	}


	function fun_countPropertySavedAsFavourites($property_id){	
		$sql 	= "SELECT * FROM " . TABLE_USER_FAVOURITE_PROPERTIES . " WHERE property_id ='".$property_id."'";
		$rs 	= $this->dbObj->createRecordset($sql);
		return $this->dbObj->getRecordCount($rs);		
	}

	/*
	function fun_countPropertyTotalViews($property_id){	
		$sql 	= "SELECT * FROM " . TABLE_PMV_LINK_VPV . " AS A
					INNER JOIN " . TABLE_PMV_LINK_VP . " AS B ON A.idlink_vp = B.idlink_vp 
					INNER JOIN " . TABLE_PMV_A_VARS_VALUE . " AS C ON A.idvars = C.id 
					WHERE  C.name = '".$property_id."'";
		$rs 	= $this->dbObj->createRecordset($sql);
		return $this->dbObj->getRecordCount($rs);		
	}
	*/
	function fun_countPropertyVisit($property_id){	
		$sql 	= "SELECT * FROM " . TABLE_PROPERTY_VISIT_RELATIONS . " WHERE property_id ='".$property_id."'";
		$rs 	= $this->dbObj->createRecordset($sql);
		return $this->dbObj->getRecordCount($rs);		
	}


	function fun_countPropertyEnquiries($property_id){	
		$sql 	= "SELECT * FROM " . TABLE_PROPERTY_ENQUIRIES_RELATIONS . " WHERE property_id ='".$property_id."'";
		$rs 	= $this->dbObj->createRecordset($sql);
		return $this->dbObj->getRecordCount($rs);		
	}

	function fun_countPropertyCurrentYearBooking($property_id){	
		$availabilityArr 	= $this->fun_getPropertyAvailabilityArr($property_id);
		$totalDays			= 0;
		if(is_array($availabilityArr) && count($availabilityArr) > 0) {
			foreach($availabilityArr as $value) {
				if($value['status'] == "3") {
					$sdate 	= $value['startdate'];
					$edate 	= $value['enddate'];
					//case I: start date and end date have different years
	
					//case II: start date and end date have same years
					if((date('Y', strtotime($sdate)) == date('Y', strtotime($edate))) && (date('Y', strtotime($sdate)) == "2009")) { // only 2009 booking details
						$totalDays += (int)((strtotime($edate) - strtotime($sdate)) / (60 * 60 * 24));
						$totalDays += 1;
					}
				}
			}
		}
		return $totalDays;
	}
/*
* Property Bath spific functions : end here
*/

/*
* Property admin specific funtion : Start here
*/
	// Function to add property decline reason
	function fun_addPropertyDeclineReason($property_id, $section_id, $reason_id, $reason_note) {
		if($property_id == ''){
			return false;
		} else {
			$cur_unixtime 	= time ();
			if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !=""){
				$cur_user_id 	= $_SESSION['ses_admin_id'];
			}
			else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !=""){
				$cur_user_id 	= $_SESSION['ses_modarator_id'];
			}
			else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !=""){
				$cur_user_id 	= $_SESSION['ses_user_id'];
			}
			else{
				$cur_user_id 	= "";
			}

			if(($declinereg_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_DECLINE_INFO , " WHERE property_id='".$property_id."' AND section_id='".$section_id."' AND reason_id='".$reason_id."'")) && (is_array($declinereg_array))){
				$decline_id		= $declinereg_array[0]['decline_id'];
				$sqlUpdateQuery = "UPDATE " . TABLE_PROPERTY_DECLINE_INFO . " SET reason_note='".$reason_note."', updated_by='" . $cur_user_id . "', updated_on='" . $cur_unixtime . "' WHERE property_id='".(int)$property_id."' AND decline_id='".(int)$decline_id."'";
				$this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
				return true;
			} else {
				$strInsQuery = "INSERT INTO " . TABLE_PROPERTY_DECLINE_INFO . "(decline_id, property_id, section_id, reason_id, reason_note, created_on, created_by, updated_on, updated_by) ";
				$strInsQuery .= "VALUES(null, '".$property_id."', '".$section_id."', '".$reason_id."', '".$reason_note."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."')";
				$this->dbObj->mySqlSafeQuery($strInsQuery);
				return true;
			}
		}
	}
	// Function for deleting proeprty decline reasons
	function fun_delPropertyDeclineReasonByNotIn($property_id, $section_ids){
		if($section_ids == ''){
			return false;
		} else {
             $strDelRegQuery = "DELETE FROM " . TABLE_PROPERTY_DECLINE_INFO . " WHERE property_id='".$property_id."' AND section_id NOT IN (".$section_ids.")";
            $this->dbObj->mySqlSafeQuery($strDelRegQuery);
			return true;
		}
	}
	// Function for deleting proeprty decline reasons

	// This function will Return array of property updates date
	function fun_getPropertyAdminReviewedInfoArr($property_id) {
		if($property_id =="") {
			return false;
		} else {
			$sqlReview 		= "SELECT FROM_UNIXTIME(A.reviewed_on, '%M %d, %Y - %H:%i:%s') AS reviewed_on, B.user_fname, B.user_lname  FROM " . TABLE_PROPERTY_ADMIN_REVIEWS . " AS A  INNER JOIN  " . TABLE_USERS . " AS B ON B.user_id = A.reviewed_by WHERE property_id='".$property_id."'";
			$rsReview 		= $this->dbObj->createRecordset($sqlReview);
			if($this->dbObj->getRecordCount($rsReview) > 0) {
				$arrReview	= $this->dbObj->fetchAssoc($rsReview);
				return $arrReview;
			} else {
				return false;
			}
		}
	}

	// Function	for updating property review by admin
	function fun_updatePropertyReviewedByAdmin($property_id){
		if($property_id == ''){
			return false;
		} else {
			$cur_unixtime 	= time ();
			if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !=""){
				$cur_user_id 	= $_SESSION['ses_admin_id'];
			}
			else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !=""){
				$cur_user_id 	= $_SESSION['ses_modarator_id'];
			}
			else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !=""){
				$cur_user_id 	= $_SESSION['ses_user_id'];
			}
			else{
				$cur_user_id 	= "";
			}

			if(($adreview_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_ADMIN_REVIEWS , " WHERE property_id='".$property_id."'")) && (is_array($adreview_array))){
				$review_id		= $adreview_array[0]['review_id'];
				$sqlUpdateQuery = "UPDATE " . TABLE_PROPERTY_ADMIN_REVIEWS . " SET reviewed_by='" . $cur_user_id . "', reviewed_on='" . $cur_unixtime . "' WHERE property_id='".(int)$property_id."' AND review_id='".(int)$review_id."'";
				$this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
				return true;
			} else {
				$strInsQuery = "INSERT INTO " . TABLE_PROPERTY_ADMIN_REVIEWS . "(review_id, property_id, reviewed_on, reviewed_by) ";
				$strInsQuery .= "VALUES(null, '".$property_id."', '".$cur_unixtime."', '".$cur_user_id."')";
				$this->dbObj->mySqlSafeQuery($strInsQuery);
				return true;
			}
		}
	}

/*
* Property admin specific funtion : End here
*/


/*
* Property location specific functions : start here
*/

	// Function for creating location with total no. of properties option list, if location id is given it must be selected
	function fun_getLocationArrWithTotalProp($location_id='', $region_id=''){		
		$LocationArr 	= array();		
		$where = array();
		$sql = "SELECT * FROM " . TABLE_LOCATION . " ";
		if($region_id !=""){
			array_push($where, "region_id='".(int)fun_db_input($region_id)."' ");
		}
		if($location_id !=""){
			array_push($where, "location_id='".(int)fun_db_input($location_id)."' ");
		}

		if(sizeof($where) > 0){
			$sql .= " WHERE ".join($where, " AND ");
		}
		$sql .= " ORDER BY location_name";

		$rs	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			$arr	= $this->dbObj->fetchAssoc($rs);
			for($i = 0; $i < count($arr); $i++) {
				$location_id 						= $arr[$i]['location_id'];
				$location_name 						= $arr[$i]['location_name'];
				$total_property 					= $this->fun_countPropertyByLocationId($location_id);
				$LocationArr[$i]['location_id'] 		= $location_id;
				$LocationArr[$i]['location_name']		= $location_name;
				$LocationArr[$i]['total_properties']	= $total_property;
			}
		}
		return $LocationArr;
	}

	// Function for count property of a location
	function fun_countPropertyByLocationId($location_id){		
		if($location_id == "") {
			return false;
		} else {
			$total_properties = 0;
			if(($property_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY , " WHERE location_id='".$location_id."' AND active='1'")) && (is_array($property_array))){
				$total_properties += count($property_array);
			}
			return $total_properties;
		}
	}

	// Function for count property of a region
	function fun_countPropertyByRegionId($region_id){		
		if($region_id == "") {
			return false;
		} else {
			$total_properties = 0;
			if(($sub_region_array = $this->fun_findPropertyRelationInfo(TABLE_REGION , " WHERE pregion_id='".$region_id."'")) && (is_array($sub_region_array))){
				for($i = 0; $i < count($sub_region_array); $i++) {
					$rsRegionId = $sub_region_array[$i]['region_id'];
					if(($location_array = $this->fun_findPropertyRelationInfo(TABLE_LOCATION , " WHERE region_id='".$rsRegionId."'")) && (is_array($location_array))){

						foreach($location_array as $key => $value) {
							$locationids_array[$key] = $value['location_id'];
						}

						$locationids = implode(",", $locationids_array);
						if(($property_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY , " WHERE location_id IN (".$locationids.") AND active='1'")) && (is_array($property_array))){
							$total_properties += count($property_array);
						}
					}
				}
			} else if(($location_array = $this->fun_findPropertyRelationInfo(TABLE_LOCATION , " WHERE region_id='".$region_id."'")) && (is_array($location_array))){


				foreach($location_array as $key => $value) {
					$locationids_array[$key] = $value['location_id'];
				}
				
				$locationids = implode(",", $locationids_array);
				if(($property_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY , " WHERE location_id IN (".$locationids.") AND active='1'")) && (is_array($property_array))){
				$total_properties += count($property_array);
				}
			}
			return $total_properties;
		}
	}

/*
	// Function for count property of a area
	//OLD
	function fun_countPropertyByAreaId($area_id){		
		$total_properties = 0;
		if($area_id == "") {
			return $total_properties;
		} else {
			$total_properties = 0;
			if(($region_relation_array = $this->fun_findPropertyRelationInfo(TABLE_REGION , " WHERE area_id ='".$area_id."'")) && (is_array($region_relation_array))){
				$regionidsByCountryArr		= array();
				for($j = 0; $j < count($region_relation_array); $j++) {
					array_push($regionidsByCountryArr, "'".$region_relation_array[$j]['region_id']."'");
				}
				$regionids = implode(",", array_unique($regionidsByCountryArr));
				//Step III: select locations of that region
				if(($regionids != "") && ($loc_relation_array = $this->fun_findPropertyRelationInfo(TABLE_LOCATION , " WHERE region_id IN (".$regionids.")")) && (is_array($loc_relation_array))){
					$locationidsArr		= array();
					for($j = 0; $j < count($loc_relation_array); $j++) {
						array_push($locationidsArr, "'".$loc_relation_array[$j]['location_id']."'");
					}
					$locationids = implode(",", array_unique($locationidsArr));
				}
			}
			if(isset($locationids) && $locationids != "") {
				$sql 	= "SELECT COUNT(*) total_result FROM  " . TABLE_PROPERTY . " WHERE location_id IN (".$locationids.") AND active='1'";
				$rs 	= $this->dbObj->createRecordset($sql);
				if($this->dbObj->getRecordCount($rs) > 0){
					$arr = $this->dbObj->fetchAssoc($rs);
					$total_properties = $arr[0]['total_result'];
				}
				else{
					$total_properties = 0;
				}
			}
			return $total_properties;
		}
	}
*/

	// Function for count property of a area
	function fun_countPropertyByAreaId($area_id){		
		$total_properties = 0;
		if($area_id == "") {
			return $total_properties;
		} else {
			$total_properties = 0;
			$sql 	= "SELECT COUNT(*) total_result FROM  " . TABLE_PROPERTY . " WHERE area_id IN (".$area_id.") AND active='1'";
			$rs 	= $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);
				$total_properties = $arr[0]['total_result'];
			} else {
				$total_properties = 0;
			}
			return $total_properties;
		}
	}


	// Function for count property of countries
	function fun_countPropertyByCountriesIds($country_ids){		
		$total_properties = 0;
		if($country_ids == "") {
			return $total_properties;
		} else {
			$total_properties = 0;
			$sql 	= "SELECT COUNT(*) total_result FROM  " . TABLE_PROPERTY . " WHERE country_id IN (".$country_ids.") AND active='1'";
			$rs 	= $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);
				$total_properties = $arr[0]['total_result'];
			} else {
				$total_properties = 0;
			}
			return $total_properties;
		}
	}

	function fun_createPropertyCountriesList4Africa(){
		$country_ids = '34,37,39,63,79,82,110,127,144,147,155,156,185,187,193,208,210,214,239';
		$sql 	= "SELECT A.country_id, B.countries_name FROM  " . TABLE_PROPERTY . " AS A INNER JOIN " . TABLE_COUNTRIES . " AS B ON A.country_id = B.countries_id WHERE A.country_id IN (".$country_ids.") AND active='1' GROUP BY A.country_id";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr = $this->dbObj->fetchAssoc($rs);
			echo '<tr><td><div class="pad-lft15 pad-rgt10 pad-top10"><span class="font14-darkgrey">By location</span></div></td></tr>';
			echo '<tr><td class="searchBoxgrayevents">';
			for($i = 0; $i < count($arr); $i++) {
				$country_id		= $arr[$i]['country_id'];
				$destinations	= str_replace("/", "_", str_replace(" ", "-", $arr[$i]['countries_name']));
				echo '<a href="'.SITE_URL.'vacation-rentals/in.'.strtolower($destinations).'" style="text-decoration: none;"><span class="blue_txt">'.$arr[$i]['countries_name'].' rentals</span> ('.number_format($this->fun_countPropertyByCountriesIds($country_id)).')</a><br />';
			}
			echo '</td>';
			echo '</tr>';
		} else {
			return false;
		}
	}

	function fun_createPropertyCountriesList4Asia(){
		$country_ids = '44,96,107,206';
		$sql 	= "SELECT A.country_id, B.countries_name FROM  " . TABLE_PROPERTY . " AS A INNER JOIN " . TABLE_COUNTRIES . " AS B ON A.country_id = B.countries_id WHERE A.country_id IN (".$country_ids.") AND active='1' GROUP BY A.country_id";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr = $this->dbObj->fetchAssoc($rs);
			echo '<tr><td><div class="pad-lft15 pad-rgt10 pad-top10"><span class="font14-darkgrey">By location</span></div></td></tr>';
			echo '<tr><td class="searchBoxgrayevents">';
			for($i = 0; $i < count($arr); $i++) {
				$country_id		= $arr[$i]['country_id'];
				$destinations	= str_replace("/", "_", str_replace(" ", "-", $arr[$i]['countries_name']));
				echo '<a href="'.SITE_URL.'vacation-rentals/in.'.strtolower($destinations).'" style="text-decoration: none;"><span class="blue_txt">'.$arr[$i]['countries_name'].' rentals</span> ('.number_format($this->fun_countPropertyByCountriesIds($country_id)).')</a><br />';
			}
			echo '</td>';
			echo '</tr>';
		} else {
			return false;
		}
	}

	function fun_createPropertyCountriesList4AustraliaSouthPacific(){
		$country_ids = '13,71,76,153,227';
		$sql 	= "SELECT A.country_id, B.countries_name FROM  " . TABLE_PROPERTY . " AS A INNER JOIN " . TABLE_COUNTRIES . " AS B ON A.country_id = B.countries_id WHERE A.country_id IN (".$country_ids.") AND active='1' GROUP BY A.country_id";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr = $this->dbObj->fetchAssoc($rs);
			echo '<tr><td><div class="pad-lft15 pad-rgt10 pad-top10"><span class="font14-darkgrey">By location</span></div></td></tr>';
			echo '<tr><td class="searchBoxgrayevents">';
			for($i = 0; $i < count($arr); $i++) {
				$country_id		= $arr[$i]['country_id'];
				$destinations	= str_replace("/", "_", str_replace(" ", "-", $arr[$i]['countries_name']));
				echo '<a href="'.SITE_URL.'vacation-rentals/in.'.strtolower($destinations).'" style="text-decoration: none;"><span class="blue_txt">'.$arr[$i]['countries_name'].' rentals</span> ('.number_format($this->fun_countPropertyByCountriesIds($country_id)).')</a><br />';
			}
			echo '</td>';
			echo '</tr>';
		} else {
			return false;
		}
	}

	function fun_createPropertyCountriesList4Caribbean(){
		$country_ids = '7,12,16,19,40,54,59,60,86,87,106,134,143,172,231,232';
		$sql 	= "SELECT A.country_id, B.countries_name FROM  " . TABLE_PROPERTY . " AS A INNER JOIN " . TABLE_COUNTRIES . " AS B ON A.country_id = B.countries_id WHERE A.country_id IN (".$country_ids.") AND active='1' GROUP BY A.country_id";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr = $this->dbObj->fetchAssoc($rs);
			echo '<tr><td><div class="pad-lft15 pad-rgt10 pad-top10"><span class="font14-darkgrey">By location</span></div></td></tr>';
			echo '<tr><td class="searchBoxgrayevents">';
			for($i = 0; $i < count($arr); $i++) {
				$country_id		= $arr[$i]['country_id'];
				$destinations	= str_replace("/", "_", str_replace(" ", "-", $arr[$i]['countries_name']));
				echo '<a href="'.SITE_URL.'vacation-rentals/in.'.strtolower($destinations).'" style="text-decoration: none;"><span class="blue_txt">'.$arr[$i]['countries_name'].' rentals</span> ('.number_format($this->fun_countPropertyByCountriesIds($country_id)).')</a><br />';
			}
			echo '</td>';
			echo '</tr>';
		} else {
			return false;
		}
	}

	function fun_createPropertyCountriesList4CentralAmerica(){
		$country_ids = '22,51,64,89,95,154,164';
		$sql 	= "SELECT A.country_id, B.countries_name FROM  " . TABLE_PROPERTY . " AS A INNER JOIN " . TABLE_COUNTRIES . " AS B ON A.country_id = B.countries_id WHERE A.country_id IN (".$country_ids.") AND active='1' GROUP BY A.country_id";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr = $this->dbObj->fetchAssoc($rs);
			echo '<tr><td><div class="pad-lft15 pad-rgt10 pad-top10"><span class="font14-darkgrey">By location</span></div></td></tr>';
			echo '<tr><td class="searchBoxgrayevents">';
			for($i = 0; $i < count($arr); $i++) {
				$country_id		= $arr[$i]['country_id'];
				$destinations	= str_replace("/", "_", str_replace(" ", "-", $arr[$i]['countries_name']));
				echo '<a href="'.SITE_URL.'vacation-rentals/in.'.strtolower($destinations).'" style="text-decoration: none;"><span class="blue_txt">'.$arr[$i]['countries_name'].' rentals</span> ('.number_format($this->fun_countPropertyByCountriesIds($country_id)).')</a><br />';
			}
			echo '</td>';
			echo '</tr>';
		} else {
			return false;
		}
	}

	function fun_createPropertyCountriesList4Europe(){
		$country_ids = '2,5,14,20,21,33,53,55,56,57,67,72,73,74,81,83,84,97,98,103,105,117,123,132,141,150,151,160,170,171,175,176,182,189,190,195,203,204,215,220,240,241,246';
		$sql 	= "SELECT A.country_id, B.countries_name FROM  " . TABLE_PROPERTY . " AS A INNER JOIN " . TABLE_COUNTRIES . " AS B ON A.country_id = B.countries_id WHERE A.country_id IN (".$country_ids.") AND active='1' GROUP BY A.country_id";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr = $this->dbObj->fetchAssoc($rs);
			echo '<tr><td><div class="pad-lft15 pad-rgt10 pad-top10"><span class="font14-darkgrey">By location</span></div></td></tr>';
			echo '<tr><td class="searchBoxgrayevents">';
			for($i = 0; $i < count($arr); $i++) {
				$country_id		= $arr[$i]['country_id'];
				$destinations	= str_replace("/", "_", str_replace(" ", "-", $arr[$i]['countries_name']));
				echo '<a href="'.SITE_URL.'vacation-rentals/in.'.strtolower($destinations).'" style="text-decoration: none;"><span class="blue_txt">'.$arr[$i]['countries_name'].' rentals</span> ('.number_format($this->fun_countPropertyByCountriesIds($country_id)).')</a><br />';
			}
			echo '</td>';
			echo '</tr>';
		} else {
			return false;
		}
	}

	function fun_createPropertyCountriesList4IndianOcean(){
		$country_ids = '31,99,130,136,137,186,196';
		$sql 	= "SELECT A.country_id, B.countries_name FROM  " . TABLE_PROPERTY . " AS A INNER JOIN " . TABLE_COUNTRIES . " AS B ON A.country_id = B.countries_id WHERE A.country_id IN (".$country_ids.") AND active='1' GROUP BY A.country_id";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr = $this->dbObj->fetchAssoc($rs);
			echo '<tr><td><div class="pad-lft15 pad-rgt10 pad-top10"><span class="font14-darkgrey">By location</span></div></td></tr>';
			echo '<tr><td class="searchBoxgrayevents">';
			for($i = 0; $i < count($arr); $i++) {
				$country_id		= $arr[$i]['country_id'];
				$destinations	= str_replace("/", "_", str_replace(" ", "-", $arr[$i]['countries_name']));
				echo '<a href="'.SITE_URL.'vacation-rentals/in.'.strtolower($destinations).'" style="text-decoration: none;"><span class="blue_txt">'.$arr[$i]['countries_name'].' rentals</span> ('.number_format($this->fun_countPropertyByCountriesIds($country_id)).')</a><br />';
			}
			echo '</td>';
			echo '</tr>';
		} else {
			return false;
		}
	}

	function fun_createPropertyCountriesList4MiddleEast(){
		$country_ids = '102,104,161,175,205,221';
		$sql 	= "SELECT A.country_id, B.countries_name FROM  " . TABLE_PROPERTY . " AS A INNER JOIN " . TABLE_COUNTRIES . " AS B ON A.country_id = B.countries_id WHERE A.country_id IN (".$country_ids.") AND active='1' GROUP BY A.country_id";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr = $this->dbObj->fetchAssoc($rs);
			echo '<tr><td><div class="pad-lft15 pad-rgt10 pad-top10"><span class="font14-darkgrey">By location</span></div></td></tr>';
			echo '<tr><td class="searchBoxgrayevents">';
			for($i = 0; $i < count($arr); $i++) {
				$country_id		= $arr[$i]['country_id'];
				$destinations	= str_replace("/", "_", str_replace(" ", "-", $arr[$i]['countries_name']));
				echo '<a href="'.SITE_URL.'vacation-rentals/in.'.strtolower($destinations).'" style="text-decoration: none;"><span class="blue_txt">'.$arr[$i]['countries_name'].' rentals</span> ('.number_format($this->fun_countPropertyByCountriesIds($country_id)).')</a><br />';
			}
			echo '</td>';
			echo '</tr>';
		} else {
			return false;
		}
	}

	function fun_createPropertyCountriesList4SouthAmerica(){
		$country_ids = '10,30,43,47,62,166,167,225,229';
		$sql 	= "SELECT A.country_id, B.countries_name FROM  " . TABLE_PROPERTY . " AS A INNER JOIN " . TABLE_COUNTRIES . " AS B ON A.country_id = B.countries_id WHERE A.country_id IN (".$country_ids.") AND active='1' GROUP BY A.country_id";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr = $this->dbObj->fetchAssoc($rs);
			echo '<tr><td><div class="pad-lft15 pad-rgt10 pad-top10"><span class="font14-darkgrey">By location</span></div></td></tr>';
			echo '<tr><td class="searchBoxgrayevents">';
			for($i = 0; $i < count($arr); $i++) {
				$country_id		= $arr[$i]['country_id'];
				$destinations	= str_replace("/", "_", str_replace(" ", "-", $arr[$i]['countries_name']));
				echo '<a href="'.SITE_URL.'vacation-rentals/in.'.strtolower($destinations).'" style="text-decoration: none;"><span class="blue_txt">'.$arr[$i]['countries_name'].' rentals</span> ('.number_format($this->fun_countPropertyByCountriesIds($country_id)).')</a><br />';
			}
			echo '</td>';
			echo '</tr>';
		} else {
			return false;
		}
	}

	function fun_createPropertyCountriesList4SoutheastAsia(){
		$country_ids = '100,129,168,188,209';
		$sql 	= "SELECT A.country_id, B.countries_name FROM  " . TABLE_PROPERTY . " AS A INNER JOIN " . TABLE_COUNTRIES . " AS B ON A.country_id = B.countries_id WHERE A.country_id IN (".$country_ids.") AND active='1' GROUP BY A.country_id";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr = $this->dbObj->fetchAssoc($rs);
			echo '<tr><td><div class="pad-lft15 pad-rgt10 pad-top10"><span class="font14-darkgrey">By location</span></div></td></tr>';
			echo '<tr><td class="searchBoxgrayevents">';
			for($i = 0; $i < count($arr); $i++) {
				$country_id		= $arr[$i]['country_id'];
				$destinations	= str_replace("/", "_", str_replace(" ", "-", $arr[$i]['countries_name']));
				echo '<a href="'.SITE_URL.'vacation-rentals/in.'.strtolower($destinations).'" style="text-decoration: none;"><span class="blue_txt">'.$arr[$i]['countries_name'].' rentals</span> ('.number_format($this->fun_countPropertyByCountriesIds($country_id)).')</a><br />';
			}
			echo '</td>';
			echo '</tr>';
		} else {
			return false;
		}
	}


	function fun_createPropertyAreaListByCountryId($country_id){
		$sql 	= "SELECT A.area_id, B.area_name FROM  " . TABLE_PROPERTY . " AS A INNER JOIN " . TABLE_AREA . " AS B ON A.area_id = B.area_id WHERE A.country_id IN (".$country_id.") AND active='1' GROUP BY A.area_id";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr = $this->dbObj->fetchAssoc($rs);
			echo '<tr><td><div class="pad-lft15 pad-rgt10 pad-top10"><span class="font14-darkgrey">By location</span></div></td></tr>';
			echo '<tr><td class="searchBoxgrayevents">';
			for($i = 0; $i < count($arr); $i++) {
				$area_id		= $arr[$i]['area_id'];
				$destinations	= str_replace("/", "_", str_replace(" ", "-", $arr[$i]['area_name']));
				echo '<a href="'.SITE_URL.'vacation-rentals/in.'.strtolower($destinations).'" style="text-decoration: none;"><span class="blue_txt">'.$arr[$i]['area_name'].' rentals</span> ('.number_format($this->fun_countPropertyByAreaId($area_id)).')</a><br />';
			}
			echo '</td>';
			echo '</tr>';
		} else {
			return false;
		}
	}

	// Function for creating covering region by ol and count property
	function fun_createPropertyByRegion4PropertyPriview($region_id){		
		if($region_id == "") {
			return false;
		} else {
			if(($sub_region_array = $this->fun_findPropertyRelationInfo(TABLE_REGION , " WHERE pregion_id='".$region_id."'")) && (is_array($sub_region_array))){
				echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
				echo "<tr>";
				echo "<td>";
				$regionName = ucwords($this->fun_getPropertyRegionNameById($region_id));
				if($this->fun_countPropertyByRegionId($region_id) > 0) {
					echo "<a href=\"".SITE_URL."vacation-rentals/in.".str_replace(" ", "-", strtolower($this->fun_getPropertyRegionNameById($region_id)))."\" class=\"grey-link\"><span class=\"font14\">".$regionName."</span>&nbsp;<span class=\"blue14\">(".$this->fun_countPropertyByRegionId($region_id).")</span></a>&nbsp;";
                    echo "<a href=\"javascript:toggleLayer1('map-pop1');\" class=\"blue-link\">View map</a>";
				} else {
					echo "<span class=\"font14\">".$regionName."</span>&nbsp;<span class=\"blue14\">(0)</span>";
                    echo "<a href=\"javascript:toggleLayer1('map-pop1');\" class=\"blue-link\">View map</a>";
                }
				echo "</td>";
				echo "</tr>";

				echo "<tr><td>&nbsp;</td></tr>";

				for($i = 0; $i < count($sub_region_array); $i++) {
					$rsRegionId = $sub_region_array[$i]['region_id'];
					echo "<tr>";
					echo "<td>";
                    if($this->fun_countPropertyByRegionId($rsRegionId) > 0) {
						echo "<a href=\"".SITE_URL."vacation-rentals/in.".str_replace(" ", "-", strtolower($this->fun_getPropertyRegionNameById($rsRegionId)))."\" class=\"grey-link\"><span class=\"font12\"><strong>".ucwords($this->fun_getPropertyRegionNameById($rsRegionId))."</strong></span>&nbsp;<span class=\"blue12normal\">(<strong>".$this->fun_countPropertyByRegionId($rsRegionId)."</strong>)</span></a>&nbsp;";
                        echo "<a href=\"javascript:toggleLayer1('map-pop1');\" class=\"blue-link\">View map</a>";
                    } else {
						echo "<span class=\"font12\"><strong>".ucwords($this->fun_getPropertyRegionNameById($rsRegionId))."</strong></span>&nbsp;<span class=\"blue12normal\"><strong>(0)</strong></span>&nbsp;";
                        echo "<a href=\"javascript:toggleLayer1('map-pop1');\" class=\"blue-link\">View map</a>";
                    }
					echo "</td>";
					echo "</tr>";
					echo "<tr>";
					echo "<td>";

					if(($location_array = $this->fun_findPropertyRelationInfo(TABLE_LOCATION , " WHERE region_id='".$rsRegionId."'")) && (is_array($location_array))){
						for($j=0; $j < count($location_array); $j++) {
							$location_id 	= $location_array[$j]['location_id'];
							$location_name 	= ucwords($location_array[$j]['location_name']);
							if($this->fun_countPropertyByLocationId($location_id) > 0) {
								echo "<a href=\"".SITE_URL."vacation-rentals/in.".str_replace(" ", "-", strtolower($location_name))."\" class=\"grey-link\"><span class=\"blackText\">".$location_name."</span>&nbsp;<span style=\"color:#357bdc\">(".$this->fun_countPropertyByLocationId($location_id).")</span></a>";
							} else {
								echo "<span style=\"color:#585858\">".$location_name."</span>&nbsp;<span style=\"color:#357bdc\">(".$this->fun_countPropertyByLocationId($location_id).")</span>";
							}
							if($j < count($location_array)-1) {
								echo "<br />";
							}
						}
					}
					echo "</td>";
					echo "</tr>";
					if($i < count($sub_region_array)-1) {
						echo "<tr><td>&nbsp;</td></tr>";
					} else {
						echo "<tr><td>&nbsp;</td></tr>";
					}
				}
				echo "</table>";
			
			} else if(($location_array = $this->fun_findPropertyRelationInfo(TABLE_LOCATION , " WHERE region_id='".$region_id."'")) && (is_array($location_array))){
				echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
                echo "<td>";
				if($this->fun_countPropertyByRegionId($region_id) > 0) {
					echo "<a href=\"".SITE_URL."vacation-rentals/in.".str_replace(" ", "-", strtolower($this->fun_getPropertyRegionNameById($region_id)))."\" class=\"grey-link\"><span class=\"font14\">".ucwords($this->fun_getPropertyRegionNameById($region_id))."</span>&nbsp;<span class=\"blue14\">(".$this->fun_countPropertyByRegionId($region_id).")</span></a>&nbsp;";
                    echo "<a href=\"javascript:toggleLayer1('map-pop1');\" class=\"blue-link\">View map</a>";
				} else {
					echo "<span class=\"font14\">".ucwords($this->fun_getPropertyRegionNameById($region_id))."</span>&nbsp;<span class=\"blue14\">(0)</span>&nbsp;";
                    echo "<a href=\"javascript:toggleLayer1('map-pop1');\" class=\"blue-link\">View map</a>";
                }
                echo "</td>";
//				echo "<tr><td>&nbsp;</td></tr>";
				echo "<tr>";
				echo "<td>";
				for($j=0; $j < count($location_array); $j++) {
					$location_id 	= $location_array[$j]['location_id'];
					$location_name 	= ucwords($location_array[$j]['location_name']);
					if($this->fun_countPropertyByLocationId($location_id) > 0) {
						echo "<a href=\"".SITE_URL."vacation-rentals/in.".str_replace(" ", "-", strtolower($location_name))."\" class=\"grey-link\"><span class=\"blackText\">".$location_name."</span>&nbsp;<span style=\"color:#357bdc\">(".$this->fun_countPropertyByLocationId($location_id).")</span></a>";
					} else {
						echo "<span style=\"color:#585858\">".$location_name."</span>&nbsp;<span style=\"color:#357bdc\">(".$this->fun_countPropertyByLocationId($location_id).")</span>";
					}
					if($j < count($location_array)-1) {
						echo "<br />";
					}
				}
				echo "</td>";
				echo "</tr>";
				if($i == count($sub_region_array)-1) {
					echo "<tr><td>&nbsp;</td></tr>";
				}
				echo "</table>";
			} else {
				return false;
			}
		}
	}

	// Function for creating Map Breadcrumb
	function fun_createPropertyMapBreadCrumbId($destinationArr){		
		if(is_array($destinationArr)) {
		/*
            echo "<a href=\"".SITE_URL."map.vacation-rentals/in.western-cape\" class=\"blue-link\">florida</a>&nbsp;/&nbsp;";
			if(($region_array = $this->fun_findPropertyRelationInfo(TABLE_REGION , " WHERE region_id='".$region_id."'")) && (is_array($region_array))){
				$pregion_id 	= $region_array[0]['pregion_id'];
                if($pregion_id > 0) {
                    if(ucwords($this->fun_getPropertyRegionNameById($pregion_id)) == "Cape Peninsula") {
                        $regionName = "florida (".ucwords($this->fun_getPropertyRegionNameById($pregion_id)).")";
                    } else {
                        $regionName = ucwords($this->fun_getPropertyRegionNameById($pregion_id));
                    }
                    echo "<a href=\"".SITE_URL."map.vacation-rentals/in.".str_replace(" ", "-", strtolower($this->fun_getPropertyRegionNameById($pregion_id)))."\" class=\"blue-link\">".$regionName."</a>&nbsp;/&nbsp;";
                    echo ucwords($region_array[0]['region_name']);
                } else {
                    if(ucwords($region_array[0]['region_name']) == "Cape Peninsula") {
                        echo "florida (".ucwords($region_array[0]['region_name']).")";
                    } else {
                        echo ucwords($region_array[0]['region_name']);
                    }
                }
			}
		*/
		} else {
            echo "";
		}
	}

	// Function for creating Map Breadcrumb
	function fun_createPropertyRegionMapBreadCrumbId($region_id){		
		if($region_id == "") {
            echo "";
		} else {
            echo "<a href=\"".SITE_URL."map.vacation-rentals/\" class=\"blue-link\">Wordwide</a>&nbsp;/&nbsp;";
			if(($region_array = $this->fun_findPropertyRelationInfo(TABLE_REGION , " WHERE region_id='".$region_id."'")) && (is_array($region_array))){
				$pregion_id 	= $region_array[0]['pregion_id'];
                if($pregion_id > 0) {
					$regionName = ucwords($this->fun_getPropertyRegionNameById($pregion_id));
                    echo "<a href=\"".SITE_URL."map.vacation-rentals/in.".str_replace(" ", "-", strtolower($this->fun_getPropertyRegionNameById($pregion_id)))."\" class=\"blue-link\">".$regionName."</a>&nbsp;/&nbsp;";
                    echo ucwords($region_array[0]['region_name']);
                } else {
					echo ucwords($region_array[0]['region_name']);
                }
			}
		}
	}

	function fun_getPropertyLocationGuide($property_id){	
		if($property_id == ''){
			return false;
		} else {
			if(($location_guides_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_LOCATION_GUIDES , " WHERE property_id='".$property_id."'")) && (is_array($location_guides_array))){
				return $location_guides_array[0]['location_guide'];
			} else {
				return false;
			}
		}
	}

	function fun_getPropertyLocationOwnerGuide($property_id){	
		if($property_id == ''){
			return false;
		} else {
			if(($location_owner_guides_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_AREA_NOTES , " WHERE property_id='".$property_id."'")) && (is_array($location_owner_guides_array))){
				return $location_owner_guides_array[0]['area_notes'];
			} else {
				return false;
			}
		}
	}

	// Function for get area description
	function fun_getPropertyLocationDesc($property_id){		
		if($property_id == "") {
			return false;
		} else {
            $sqlDesc 	= "SELECT A.area_notes AS locationDesc FROM " . TABLE_PROPERTY_AREA_NOTES . " AS A WHERE A.property_id ='".$property_id."'";
			$rsDesc 	= $this->dbObj->createRecordset($sqlDesc);
			if($this->dbObj->getRecordCount($rsDesc) > 0){
				$arrDesc 		= $this->dbObj->fetchAssoc($rsDesc);
                $locationDesc 	= $arrDesc[0]['locationDesc'];
				return $locationDesc;
			} else {
				$sql 	= "SELECT A.region_id, A.subregion_id, A.location_id FROM " . TABLE_PROPERTY . " AS A WHERE A.property_id ='".$property_id."'";
				$rs 	= $this->dbObj->createRecordset($sql);
				if($this->dbObj->getRecordCount($rs) > 0){
					$arr 			= $this->dbObj->fetchAssoc($rs);
					$region_id 		= $arr[0]['region_id'];
					$subregion_id 	= $arr[0]['subregion_id'];
					$location_id	= $arr[0]['location_id'];
					if($location_id > 0) {
						$locationDesc = $this->dbObj->getField(TABLE_LOCATION, "location_id", $location_id, "location_desc");
					} else if($subregion_id > 0) {
						$locationDesc = $this->dbObj->getField(TABLE_REGION, "region_id", $subregion_id, "region_desc");
					} else if($region_id > 0) {
						$locationDesc = $this->dbObj->getField(TABLE_REGION, "region_id", $region_id, "region_desc");
					} else {
						$locationDesc = $this->dbObj->getField(TABLE_AREA, "area_id", "1", "area_desc");
					}
					return $locationDesc;
				} else {
					return false;
				}
			}
		}
	}

	// Function for creating property landmarks distance section : start here
	function fun_createPropertyLandmarks4PropertyPriview($property_id){		
		// Step 1: Find the landmark relation array
		$sql 	= "SELECT A.distance, A.distance_type, B.landmark_name AS landmark_name 
					FROM " . TABLE_PROPERTY_LANDMARK_RELATIONS . " AS A
					INNER JOIN " . TABLE_PROPERTY_LANDMARKS . " AS B ON A.landmark_id=B.landmark_id
					WHERE property_id='".$property_id."'";
		$rs 	= $this->dbObj->createRecordset($sql);
		$arr 	= $this->dbObj->fetchAssoc($rs);

		$sqlExtraLandmarks 	= "SELECT landmark_name, distance, distance_type FROM " . TABLE_PROPERTY_EXTRA_LANDMARKS . " WHERE property_id='".$property_id."'";
		$rsExtraLandmarks 	= $this->dbObj->createRecordset($sqlExtraLandmarks);
		if($this->dbObj->getRecordCount($rsExtraLandmarks) >0) {
			$arrExtraLandmarks 	= $this->dbObj->fetchAssoc($rsExtraLandmarks);
			$counter = count($arr);
			foreach($arrExtraLandmarks as $value) {
				$arr[$counter]['landmark_name'] 	= $value['landmark_name'];
				$arr[$counter]['distance'] 			= $value['distance'];
				$arr[$counter]['distance_type'] 	= $value['distance_type'];
				$counter++;
			}
		}
		$total_landmarks		= count($arr);
		$location_guide 		= $this->fun_getPropertyLocationGuide($property_id);
		$location_owner_guide 	= $this->fun_getPropertyLocationOwnerGuide($property_id);
		$location_desc 			= $this->fun_getPropertyLocationDesc($property_id);
		echo "<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
		if($total_landmarks > 0) {
			echo "<tr><td valign=\"top\" align=\"left\" class=\"owner-headings1\">Distances</td></tr>";
			echo "<tr>";
			echo "<td valign=\"top\" align=\"left\" class=\"pad-btm25\">";
			echo "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
			echo "<tr>";
			echo "<td width=\"210\">";
			echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">";
			echo "<tr><td colspan=\"2\" height=\"8\" class=\"dash-btm\"></td></tr>";
			if($total_landmarks % 2 == 0) {
				//even condition
				$first_cell_num = $total_landmarks - ((int)($total_landmarks)/2);
			} else {
				//odd condition
				$first_cell_num = $total_landmarks - ((int)($total_landmarks-1)/2);
			}
			for($i = 0; $i < $first_cell_num; $i++) {
				$txtLandmarkName	= $arr[$i]['landmark_name'];
				$txtLandmarkDist	= $arr[$i]['distance'];
				$txtLandmarkType 	= (trim($arr[$i]['distance_type']) == "m")?'miles':'km';
				echo "<tr class=\"Summary\"><td>".ucwords($txtLandmarkName)."</td><td align=\"right\">".$txtLandmarkDist."&nbsp;".$txtLandmarkType."</td></tr>";
			}
			echo "</table>";
			echo "</td>";
			echo "<td width=\"30\"><img src=\"".SITE_IMAGES."spacer.gif\" alt=\"Location\" width=\"25\" height=\"30\" /></td>";
			echo "<td width=\"210\" valign=\"top\">";
			echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">";
			echo "<tr><td colspan=\"2\" height=\"8\" class=\"dash-btm\"></td></tr>";
			for($j = $first_cell_num; $j < count($arr); $j++) {
				$txtLandmarkName	= $arr[$j]['landmark_name'];
				$txtLandmarkDist	= $arr[$j]['distance'];
				$txtLandmarkType 	= (trim($arr[$j]['distance_type']) == "m")?'miles':'km';
				echo "<tr class=\"Summary\"><td>".ucwords($txtLandmarkName)."</td><td align=\"right\">".$txtLandmarkDist."&nbsp;".$txtLandmarkType."</td></tr>";
			}
			echo "</table>";
			echo "</td>";
			echo "</tr>";
			echo "</table>";
			echo "</td>";
			echo "</tr>";
		}

		if(isset($location_guide) && $location_guide != "") {
			echo "<tr><td class=\"owner-headings1\">How to get there</td></tr>";
			echo "<tr><td class=\"pad-top10 pad-btm25 editor-txt\">".$location_guide."</td></tr>";
		}
		if(isset($location_desc) && $location_desc != "") {
			echo "<tr><td class=\"owner-headings1\">About the area</td></tr>";
			echo "<tr><td class=\"pad-top10 pad-btm25 editor-txt\">".$location_desc."</td></tr>";
		}
//		echo "<tr><td class=\"owner-headings1\">What the owner says about the area</td></tr>";
//		echo "<tr><td class=\"pad-top10 pad-btm25\">".$location_owner_guide."</td></tr>";
		echo "</table>";

	}
	// Function for creating property landmarks distance section : end here


	// Function for creating property about area section
	function fun_createPropertyAboutArea4PropertyPriview($property_id){		
		if($property_id == "") {
			return false;
		} else {
			$sql 				= "SELECT A.region_id, 
									B.area_id AS area_id, 
									B.region_name AS region_name, 
									B.region_desc AS region_desc, 
									B.img_avg_monthly_temp AS img_avg_monthly_temp, 
									B.img_avg_monthly_rainfall AS img_avg_monthly_rainfall, 
									B.img_avg_daily_sunshine_hours AS img_avg_daily_sunshine_hours, 
									C.area_notes AS owner_area_desc,
									D.country_id AS country_id,
									D.area_name AS area_name,
									E.countries_name AS country_name
									FROM " . TABLE_PROPERTY . " AS A
									INNER JOIN " . TABLE_REGION . " AS B ON A.region_id = B.region_id
									INNER JOIN " . TABLE_PROPERTY_AREA_NOTES . " AS C ON A.property_id = C.property_id,
									" . TABLE_AREA . " AS D
									INNER JOIN " . TABLE_COUNTRIES . " AS E ON E.countries_id = D.country_id
									WHERE A.property_id ='".$property_id."' AND D.area_id = B.area_id";
			$rs 				= $this->dbObj->createRecordset($sql);
			$arr 				= $this->dbObj->fetchAssoc($rs);
			
//			print_r($arr);

			if(is_array($arr) && count($arr) > 0) {
				$region_id 						= $arr[0]['region_id'];
				$region_name 					= $arr[0]['region_name'];
				$area_name 						= $arr[0]['area_name'];
				$country_name 					= $arr[0]['country_name'];
				$region_desc 					= $arr[0]['region_desc'];
				$owner_area_desc 				= $arr[0]['owner_area_desc'];

				$txtRegion = ucwords($region_name).", ".ucwords($area_name).", ".ucwords($country_name);

				$img_avg_monthly_temp 			= SITE_IMAGES."weather/img_avg_monthly_temp/".$arr[0]['img_avg_monthly_temp'];

				$img_avg_monthly_rainfall 		= SITE_IMAGES."weather/img_avg_monthly_rainfall/".$arr[0]['img_avg_monthly_rainfall'];

				$img_avg_daily_sunshine_hours 	= SITE_IMAGES."weather/img_avg_daily_sunshine_hours/".$arr[0]['img_avg_daily_sunshine_hours'];
			
				echo "<table cellspacing=\"0\" border=\"0\" cellpadding=\"0\" class=\"pad-btm10\">";
				echo "<tr>";
				echo "<td align=\"Left\" valign=\"Top\">";
				echo "<table cellspacing=\"0\" cellpadding=\"0\">";
				echo "<tr><td class=\"pad-btm15\"><div class=\"blackHeadtab\">About the area</div></td></tr>";
				echo "<tr>";
				echo "<td class=\"pad-btm25\">".ucfirst($region_desc)."</td>";
				echo "</tr>";
				echo "<tr><td class=\"owner-headings1\">What the owner says about the area</td></tr>";
				echo "<tr>";
				echo "<td class=\"pad-top10\">".ucfirst($owner_area_desc)."</td>";
				echo "</tr>";
				echo "</table>";
				echo "</td>";
				echo "<td><img src=\"".SITE_IMAGES."spacer.gif\" alt=\"Image\" width=\"30\" height=\"30\" /></td>";
				echo "<td>";
				echo "<table cellspacing=\"0\" cellpadding=\"0\">";
				echo "<tr><td><img src=\"".SITE_IMAGES."spacer.gif\" alt=\"Image\" width=\"50\" height=\"36\" /></td></tr>";
				echo "<tr>";
				echo "<td class=\"pad-btm5\">";
				echo "<span class=\"black\"><strong>Average monthly temp</strong> (ºC)</span> <br />".$txtRegion;
				echo "</td>";
				echo "</tr>";
				echo "<tr><td class=\"pad-btm15\"><img src=\"".$img_avg_monthly_temp."\" alt=\"Image\" /></td></tr>";
				echo "<tr>";
				echo "<td class=\"pad-btm5\">";
				echo "<span class=\"black\"><strong>Average monthly rainfall</strong> (mm)</span><br />".$txtRegion;
				echo "</td>";
				echo "</tr>";
				echo "<tr><td class=\"pad-btm15\"><img src=\"".$img_avg_monthly_rainfall."\" alt=\"Image\" /></td></tr>";
				echo "<tr>";
				echo "<td class=\"pad-btm5\">";
				echo "<span class=\"bold black\">Average daily sunshine hours</span><br />".$txtRegion;
				echo "</td>";
				echo "</tr>";
				echo "<tr><td><img src=\"".$img_avg_daily_sunshine_hours."\" alt=\"Image\" /></td></tr>";
				echo "</table>";
				echo "</td>";
				echo "</tr>";
				echo "</table>";
			}
		}
	}


	// Function for creating property map section
	function fun_createPropertyLocationMap4PropertyPriview($property_id){		
		if($property_id == "") {
			return false;
		} else {
			$sql 				= "SELECT A.region_id, 
									B.region_name AS region_name, 
									B.map_thumb AS region_small_map, 
									B.map_large AS region_large_map, 
									C.area_name AS area_name, 
									C.map_thumb AS area_small_map, 
									C.map_large AS area_large_map
									FROM " . TABLE_PROPERTY . " AS A
									INNER JOIN " . TABLE_REGION . " AS B ON A.region_id = B.region_id,
									" . TABLE_AREA . " AS C
									WHERE A.property_id ='".$property_id."' AND C.area_id = B.area_id ";
			$rs 				= $this->dbObj->createRecordset($sql);
			$arr 				= $this->dbObj->fetchAssoc($rs);
			

			if(is_array($arr)) {
				$region_name 		= $arr[0]['region_name'];
				$region_small_map 	= SITE_IMAGES."maps/small-gifs/".$arr[0]['region_small_map'];
				$region_large_map 	= SITE_IMAGES."maps/large-gifs/".$arr[0]['region_large_map'];
				$area_name 			= $arr[0]['area_name'];
				$area_small_map 	= SITE_IMAGES."maps/small-gifs/".$arr[0]['area_small_map'];
				$area_large_map 	= SITE_IMAGES."maps/large-gifs/".$arr[0]['area_large_map'];
			
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
				echo "<tr>";
				echo "<td class=\"pad-btm30\" align=\"center\" valign=\"top\" width=\"406\"><div id=\"p_map_map\" style=\"overflow: hidden; width: 406px; height: 404px; float:left; border:1px solid #999999;\"></div></td>";
				echo "</tr>";
/*
				echo "<tr>";
				echo "<td align=\"left\" valign=\"Top\">";
				echo "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">";
				echo "<tr>";
				echo "<td><div style=\"width:188px; height:188px; overflow:hidden;\"><img src=\"".$region_small_map."\" alt=\"".$region_name."\" /></div></td>";
				echo "<td>&nbsp;</td>";
				echo "<td><div style=\"width:188px; height:188px; overflow:hidden;\"><img src=\"".$area_small_map."\" alt=\"".$area_name."\" /></div></td>";
				echo "</tr>";

				echo "<tr>";
				echo "<td>&nbsp;</td>";
				echo "<td><img src=\"".SITE_IMAGES."spacer.gif\" alt=\"Location\" width=\"30\" height=\"30\" /></td>";
				echo "<td>&nbsp;</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td><span style=\"width:188px; height:188px; overflow:hidden;\"><img src=\"images/maps/small-gifs/western-cape-winelands-map.gif\" alt=\"cape winelands\" /></span></td>";
				echo "<td>&nbsp;</td>";
				echo "<td><span style=\"width:188px; height:188px; overflow:hidden;\"><img src=\"images/maps/small-gifs/western-cape-winelands-map.gif\" alt=\"cape winelands\" /></span></td>";
				echo "</tr>";
				echo "</table>";
				echo "</td>";
				echo "</tr>";
*/
				echo "</table>";
/*
				echo "<table cellspacing=\"0\" cellpadding=\"0\">";
				echo "<tr>";
				echo "<td class=\"pad-btm20\">";
				echo "<div class=\"blackHeadtab\">Location</div>";
				echo "</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td class=\"pad-btm30\"><div  id=\"p_map_map\" style=\"overflow: hidden; width: 406px; height: 404px; float:left; border:1px solid #999999;\"></div></td>";
//				echo "<td class=\"pad-btm30\"><div style=\"width:406px; overflow:hidden;\"><img src=\"".$region_large_map."\" alt=\"".$region_name."\" /></div></td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td align=\"left\" valign=\"Top\">";
				echo "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">";
				echo "<tr>";
				echo "<td><div style=\"width:188px; height:188px; overflow:hidden;\"><img src=\"".$region_small_map."\" alt=\"".$region_name."\" /></div></td>";
				echo "<td><img src=\"".SITE_IMAGES."spacer.gif\" alt=\"Location\" width=\"30\" height=\"30\" /></td>";
				echo "<td><div style=\"width:188px; height:188px; overflow:hidden;\"><img src=\"".$area_small_map."\" alt=\"".$area_name."\" /></div></td>";
				echo "</tr>";
				echo "</table>";
				echo "</td>";
				echo "</tr>";
				echo "</table>";
*/
			}
		}
	}

	// Function for creating property landmarks distance section : start here
	function fun_createPropertyLandmarks($property_id = '', $distance_type = ''){		
    	if($property_id == "") {
        	return false;
        } else {
            if($distance_type != "") {
                // change distance type for all
                $this->fun_updateLandmarkDistanceType($property_id, $distance_type);
                $txtDistanceType 	= ($distance_type == "m")?'miles':'km';
            }

            // Step 1: Find the landmark relation array
            $sqlLandmarksIds 	= "SELECT * FROM " . TABLE_PROPERTY_LANDMARK_RELATIONS . " WHERE property_id='".$property_id."'";
            $rsLandmarks 		= $this->dbObj->createRecordset($sqlLandmarksIds);
            $arrLandmarks 		= $this->dbObj->fetchAssoc($rsLandmarks);

			if(!isset($txtDistanceType)) {
				if($arrLandmarks[0]['distance_type'] != "") {
					$txtDistanceType 	= (trim($arrLandmarks[0]['distance_type']) == "m")?'miles':'km';
				} else {
					$txtDistanceType 	= 'km';
				}
			}

            // Step 2: Find the available landmark names array
            $sql = "SELECT * FROM " . TABLE_PROPERTY_LANDMARKS . " ORDER BY landmark_name";
    
            // Step 3: Create property landmark section
            echo "<table border='0' cellpadding='0' cellspacing='0'>";
            echo "<tr>";
            $rs = $this->dbObj->createRecordset($sql);
            $arr = $this->dbObj->fetchAssoc($rs);
    
            
            $distance = "";
            $i = 0;
            foreach($arr as $value){
                if(count($arrLandmarks) > 0){
                    foreach($arrLandmarks as $key=>$landmarkValue){
                        if($value['landmark_id'] == $arrLandmarks[$key]['landmark_id']){
                            $value['landmark_distance'] = $arrLandmarks[$key]['distance'];
                        }
                    }
                }
    
                if($i%3 == 0){
                    echo "</tr><tr height='5px'></tr><tr>";
                    $td_attr = " width='80' align='right' valign='top' class='pad-rgt10 pad-top3'";
                }
                if($i%3 == 1){
                    $td_attr = " width='135' align='right' valign='top' class='pad-rgt10 pad-top3'";
                }
                if($i%3 == 2){
                    $td_attr = " width='135' align='right' valign='top' class='pad-rgt10 pad-top3'";
                }
    
                echo "<td ".$td_attr.">" .ucwords($value['landmark_name']). " </td>";
                echo "<td><input type='hidden' name='txtLandmarkId[]' value='".$value['landmark_id']."'><input type='text' name='txtLandmarkDistance[]' maxlength='5' class='Distances' value='".$value['landmark_distance']."' /></td>";
                echo "<td width='40' align='left' valign='top' class='pad-lft10 pad-top3' id='landMarkCellId".$i."'>".$txtDistanceType."</td>";
                $i++;
            }
            echo "</table>";
        }
	}
	// Function for creating property landmarks distance section : end here

	// Function for creating property landmarks distance section
	function fun_countPropertyExtraLandmarks($property_id = ''){
		if($property_id == '') {
			return 0;
		} else {
			$sql = "SELECT landmark_name FROM " . TABLE_PROPERTY_EXTRA_LANDMARKS . " WHERE property_id='".$property_id."'";
			$rs = $this->dbObj->createRecordset($sql);
			return $this->dbObj->getRecordCount($rs);
		}
	}

	// Function for creating property landmarks distance section
	// Function for creating property landmarks distance section
	function fun_createPropertyExtraLandmarks($property_id = '', $distance_type = ''){
    	if($property_id == "") {
        	return false;
        } else {
            if($distance_type != "") {
                // change distance type for all
                $this->fun_updateLandmarkDistanceType($property_id, $distance_type);
                $txtDistanceType 	= ($distance_type == "m")?'miles':'km';
            }

            $sqlExtraLandmarks 	= "SELECT * FROM " . TABLE_PROPERTY_EXTRA_LANDMARKS . " WHERE property_id='".$property_id."'";
            $rsExtraLandmarks 	= $this->dbObj->createRecordset($sqlExtraLandmarks);
            if($this->dbObj->getRecordCount($rsExtraLandmarks) >0) {
                $arrExtraLandmarks 	= $this->dbObj->fetchAssoc($rsExtraLandmarks);
                if(!isset($txtDistanceType)) {
                    if($arrExtraLandmarks[0]['distance_type'] != "") {
                        $txtDistanceType 	= (trim($arrExtraLandmarks[0]['distance_type']) == "m")?'miles':'km';
                    } else {
                        $txtDistanceType 	= 'km';
                    }
                }

                echo "<div style=\"padding: 5px 10px 5px 5px;\">";
                echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"675\">";
                echo "<tr><td colspan=\"5\"></td></tr>";
                echo "<tr>";
                $landmark_name = "";
                $landmark_distance = "";
                $i = 0;
                foreach($arrExtraLandmarks as $key=>$value){
                    $landmark_id 		= $value['landmark_id'];
                    $landmark_name 		= $value['landmark_name'];
                    $landmark_distance 	= $value['distance'];
                    if($i%1 == 0){
                        echo "</tr><tr>";
                    }
                    echo "<td height=\"25\"><input type=\"text\" style=\"width:147px; border: solid 1px #9F9F9F; font-size:12px; padding-top:2px; padding-bottom:2px; padding-left:5px;\" name=\"txtExtraLandmarks[]\" id=\"txtExtraLandmarks\" value=\"".$landmark_name."\" /></td>";
                    echo "<td>&nbsp;is &nbsp;</td>";
                    echo "<td><input type=\"text\" style=\"width:49px; border: solid 1px #9F9F9F; font-size:12px; padding-top:2px; padding-bottom:2px; text-align:center;\" name=\"txtExtraLandmarkDist[]\" id=\"txtExtraLandmarkDist\" maxlength=\"5\" value=\"".$landmark_distance."\" /></td>";
                    echo "<td style=\"width:380px;\">&nbsp; <span id='extraLandMarkCellId".$i."'>".$txtDistanceType."</span> from my property</td>";
                    echo "<td><a href=\"JavaScript:void(0);\" onClick=\"JavaScript:deleteExtraLandmark('".$landmark_id."');\" class=\"delete-photo\">Delete</a></td>";
                    $i++;
                }
                echo "</table>";
                echo "</div>";
            }
        }
	}

	// Function for find country name
	function fun_getPropertyCountryNameById($countries_id){		
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

	// Function for find area name
	function fun_getPropertyAreaNameById($area_id){		
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

	// Function for find region name
	function fun_getPropertyRegionNameById($region_id){		
		if($region_id == "") {
			return false;
		} else {
			if(($region_array = $this->fun_findPropertyRelationInfo(TABLE_REGION , " WHERE region_id='".$region_id."'")) && (is_array($region_array))){
				$region_name = $region_array[0]['region_name'];	
				return fun_db_output($region_name);
			} else {
				return "";
			}
		}
	}

	function fun_getPropertyLocationNameById($location_id){		
		if($location_id == "") {
			return false;
		} else {
			if(($location_array = $this->fun_findPropertyRelationInfo(TABLE_LOCATION , " WHERE location_id='".$location_id."'")) && (is_array($location_array))) {
				$location_name = $location_array[0]['location_name'];
				return fun_db_output($location_name);
			} else {
				return "";
			}
		
		}
	}

/*
* Property location specific functions : end here
*/


/*
* Property Price spific functions : start here
*/
	function fun_getPropertyPriceAllInfoArr($property_id = ''){	
		if($property_id == ''){
			return false;
		}
		else{
			if(($price_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_PRICES , " WHERE property_id='".$property_id."'")) && (is_array($price_array))){
			return $price_array;
			}
			else{
				return false;
			}
		}
	}

	function fun_getPropertyPriceMinMaxInfoArr($property_id = ''){	
		if($property_id == ''){
			return false;
		}
		else{
			if(($price_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_PRICES , " WHERE property_id='".$property_id."'")) && (is_array($price_array))){
				$min_price = $price_array[0]['per_week_price'];
				$max_price = $price_array[0]['per_week_price'];
				for($i=0; $i <count($price_array); $i++) {
					$price = $price_array[$i]['per_week_price'];
					if((int)$price < (int)$min_price) {
						$min_price = $price;
					}
					if((int)$price > (int)$max_price) {
						$max_price = $price;
					}
				}
				if($max_price > 0) {
					$propertyPriceArr['property_id'] 	= $property_id;
					$propertyPriceArr['min_price'] 		= $min_price;
					$propertyPriceArr['max_price'] 		= $max_price;
					return $propertyPriceArr;
				} else {
					return false;
				}
				
			} else {
				return false;
			}
		}
	}

	function fun_getPropertyPriceFromInfoArr($property_id = ''){	
		if($property_id == ''){
			return false;
		} else {
			if(($price_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_PRICES , " WHERE property_id='".$property_id."'")) && (is_array($price_array))){
				$min_per_week_priceArr 		= array();
				$min_per_night_priceArr 	= array();
				$min_per_endnight_priceArr 	= array();
				for($i=0; $i <count($price_array); $i++) {
					if($price_array[$i]['per_week_price'] > 0) {
						array_push($min_per_week_priceArr, $price_array[$i]['per_week_price']);
					}
					if($price_array[$i]['per_night_midweek_price'] > 0) {
						array_push($min_per_night_priceArr, $price_array[$i]['per_night_midweek_price']);
					}
					if($price_array[$i]['per_night_weekend_price'] > 0) {
						array_push($min_per_endnight_priceArr, $price_array[$i]['per_night_weekend_price']);
					}
				}
				$propertyPriceArr['property_id'] 		= $property_id;
				if(is_array($min_per_night_priceArr) && count($min_per_night_priceArr) > 0) {
					$propertyPriceArr['min_per_night_price'] = min($min_per_night_priceArr);
					$propertyPriceArr['max_per_night_price'] = max($min_per_night_priceArr);
				}

				if(is_array($min_per_week_priceArr) && count($min_per_week_priceArr) > 0) {
					$propertyPriceArr['min_per_week_price'] = min($min_per_week_priceArr);
					$propertyPriceArr['max_per_week_price'] = max($min_per_week_priceArr);
				}

				if(is_array($min_per_endnight_priceArr) && count($min_per_endnight_priceArr) > 0) {
					$propertyPriceArr['min_per_endnight_price'] = min($min_per_endnight_priceArr);
					$propertyPriceArr['max_per_endnight_price'] = max($min_per_endnight_priceArr);
				}

				if(isset($propertyPriceArr['min_per_endnight_price']) && (!isset($propertyPriceArr['min_per_night_price']) || ($propertyPriceArr['min_per_night_price'] > $propertyPriceArr['min_per_endnight_price']))) {
					$propertyPriceArr['min_per_night_price'] = $propertyPriceArr['min_per_endnight_price'];
				}
				if(isset($propertyPriceArr['max_per_night_price']) && (!isset($propertyPriceArr['max_per_night_price']) || ($propertyPriceArr['max_per_night_price'] < $propertyPriceArr['max_per_night_price']))) {
					$propertyPriceArr['max_per_night_price'] = $propertyPriceArr['max_per_night_price'];
				}

				return $propertyPriceArr;
			} else {
				return false;
			}
		}
	}

/*
* Property Price spific functions : end here
*/

/*
* Property user basket specific functions : start here
*/
	// This function will find payment done for the products
	function fun_countPropertyBuyPhotos($property_id) {
		$sql = "SELECT SUM(B.products_quantity) AS total_buy_photos
		FROM " . TABLE_ORDERS_PRODUCTS_PROPERTIES . " AS A
		LEFT JOIN " . TABLE_ORDERS_PRODUCTS . " AS B ON A.products_id = B.products_id 
		WHERE A.orders_id = B.orders_id AND A.property_id='".$property_id."' AND A.products_id='1'";
        $rs = $this->dbObj->createRecordset($sql);
        if($this->dbObj->getRecordCount($rs) > 0) {
			$arr = $this->dbObj->fetchAssoc($rs);
			return $arr[0]['total_buy_photos']; 
        } else {
			return "0";
        }
	}

	// This function will find payment done for the products
	function fun_checkPropertyProductPayments($products_id, $property_id) {
		$sql = "SELECT B.orders_status 
		FROM " . TABLE_ORDERS_PRODUCTS_PROPERTIES . " AS A
		INNER JOIN " . TABLE_ORDERS . " AS B ON A.orders_id = B.orders_id 
		WHERE A.products_id='".$products_id."' AND A.property_id='".$property_id."' AND B.orders_status = '4'";
        $rs = $this->dbObj->createRecordset($sql);
        if($this->dbObj->getRecordCount($rs) > 0) {
			return true;
        } else {
            return false;
        }
	}

	// This function will find availability of Product in Property User Basket
	function fun_checkPropertyUserBasket($user_id, $products_id, $property_id) {
		$sql = "SELECT payment_status FROM " . TABLE_USER_CART . " WHERE user_id='".$user_id."' AND products_id='".$products_id."' AND property_id='".$property_id."'";
        $rs = $this->dbObj->createRecordset($sql);
        if($this->dbObj->getRecordCount($rs) > 0) {
			return true;
        } else {
            return false;
        }
	}

	// This function will add Product in Property User Basket
	function fun_addPropertyUserBasket($user_id, $products_id, $property_id, $user_basket_quantity, $final_price){
		if($user_id =='' || $products_id == '' || $property_id == '') {
			return false;
		} else {
			$cur_unixtime = time ();
			$exp_unixtime = mktime(0, 0, 0, (int)date('m')+1, (int)date('d'), (int)date('Y'));
			$strInsQuery = "INSERT INTO " . TABLE_USER_CART . "(user_basket_id, user_id, products_id, property_id, user_basket_quantity, final_price, user_basket_date_added, user_basket_date_expire, payment_status) ";
			$strInsQuery .= "VALUES(null, '".$user_id."', ".$products_id.", ".$property_id.", ".$user_basket_quantity.", ".$final_price.", ".$cur_unixtime.",  ".$exp_unixtime.", '1')";
			$this->dbObj->mySqlSafeQuery($strInsQuery);
			return true;
		}
	}

	// This function will add Product in Property User Basket
	function fun_addProductUserBasket($user_id, $products_id, $user_basket_quantity, $final_price){
		if($user_id =='' || $products_id == '') {
			return false;
		} else {
			$cur_unixtime = time ();
			$exp_unixtime = mktime(0, 0, 0, (int)date('m')+1, (int)date('d'), (int)date('Y'));
			$strInsQuery = "INSERT INTO " . TABLE_USER_CART . "(user_basket_id, user_id, products_id, property_id, user_basket_quantity, final_price, user_basket_date_added, user_basket_date_expire, payment_status) ";
			$strInsQuery .= "VALUES(null, '".$user_id."', ".$products_id.", '', ".$user_basket_quantity.", ".$final_price.", ".$cur_unixtime.",  ".$exp_unixtime.", '1')";
			$this->dbObj->mySqlSafeQuery($strInsQuery);
			return true;
		}
	}

	// This function will delete Product in Property User Basket
	function fun_deletePropertyUserBasket($user_id, $products_id, $property_id){
		if($user_id =='' || $products_id == '' || $property_id == '') {
			return false;
		} else {
			$this->dbObj->deleteRow(TABLE_USER_CART, array("user_id", "products_id", "property_id"), array($user_id, $products_id, $property_id));
			return true;
		}
	}

/*
* Property user basket specific functions : end here
*/


/*
* Owner package specific functions : start here
*/
	function fun_getOwnerPackageCreditByPropertyId($property_id) {
		if($property_id ==""){
			return false;
		} else{
			$package_credit = 0;
			$owner_id = $this->dbObj->getField(TABLE_PROPERTY_OWNER_RELATIONS, "property_id", $property_id, "owner_id");
			if(isset($owner_id) && $owner_id !="") {
				$sql = "SELECT B.credits, A.credit_used FROM " . TABLE_PACKAGE_OWNER_RELATIONS . " AS A
				INNER JOIN " . TABLE_PACKAGES . " AS B ON B.package_id = A.package_id 
				WHERE A.owner_id='".$owner_id."' AND A.active='1' AND B.active='1'";
				$rs = $this->dbObj->createRecordset($sql);
				if($this->dbObj->getRecordCount($rs) > 0){
					$arr = $this->dbObj->fetchAssoc($rs);	
					$package_credit = ($arr[0]['credits'] - $arr[0]['credit_used']);
				}
			}
			return $package_credit;
		}
	}
	
	function fun_updateOwnerPackageByPropertyId($property_id, $active) {
		if($property_id == "" && $active == ""){
			return false;
		} else {
			$cur_unixtime 	= time ();
			if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !=""){
				$cur_user_id 	= $_SESSION['ses_admin_id'];
			} else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !="") {
				$cur_user_id 	= $_SESSION['ses_modarator_id'];
			} else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !="") {
				$cur_user_id 	= $_SESSION['ses_user_id'];
			} else {
				$cur_user_id 	= "";
			}
			$owner_id = $this->dbObj->getField(TABLE_PROPERTY_OWNER_RELATIONS, "property_id", $property_id, "owner_id");
			if(isset($owner_id) && $owner_id !="") {
				$field_names 	= array("active", "updated_on", "updated_by");
				$field_values 	= array($active, $cur_unixtime, $cur_user_id);
				$this->dbObj->updateFields(TABLE_PACKAGE_OWNER_RELATIONS, "owner_id", $owner_id, $field_names, $field_values);
			}
			return true;
		}
	}

	function fun_updateOwnerPackageCreditByOne($property_id) {
		if($property_id == ""){
			return false;
		} else {
			$cur_unixtime 	= time ();
			if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !=""){
				$cur_user_id 	= $_SESSION['ses_admin_id'];
			} else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !="") {
				$cur_user_id 	= $_SESSION['ses_modarator_id'];
			} else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !="") {
				$cur_user_id 	= $_SESSION['ses_user_id'];
			} else {
				$cur_user_id 	= "";
			}
			$owner_id = $this->dbObj->getField(TABLE_PROPERTY_OWNER_RELATIONS, "property_id", $property_id, "owner_id");
			if(isset($owner_id) && $owner_id !="") {
				$field_names 	= array("credit_used", "updated_on", "updated_by");
				$field_values 	= array("credit_used + 1", $cur_unixtime, $cur_user_id);
				$this->dbObj->updateFields(TABLE_PACKAGE_OWNER_RELATIONS, "owner_id", $owner_id, $field_names, $field_values);
			}
			return true;
		}
	}
	
	function fun_addOwnerPackage($owner_id, $package_id) {
		if($owner_id == "" || $package_id == ""){
			return false;
		} else {
			$cur_unixtime 	= time ();
			if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !=""){
				$cur_user_id 	= $_SESSION['ses_admin_id'];
			} else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !="") {
				$cur_user_id 	= $_SESSION['ses_modarator_id'];
			} else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !="") {
				$cur_user_id 	= $_SESSION['ses_user_id'];
			} else {
				$cur_user_id 	= "";
			}
			$field_names 	= array("owner_id", "package_id", "credit_used", "created_on", "created_by", "updated_on", "updated_by", "active");
			$field_values 	= array($owner_id, $package_id, "0", $cur_unixtime, $cur_user_id, $cur_unixtime, $cur_user_id, "1");
			$this->dbObj->insertFields(TABLE_PACKAGE_OWNER_RELATIONS, $field_names, $field_values);
			return true;
		}
	}

	function fun_checkOwnerPackageCredit($owner_id, $products_id = "") { //check if owner has any active package subscribed with available credit
		if($owner_id == ""){
			return false;
		} else {
			$sql = "SELECT B.credits, A.credit_used FROM " . TABLE_PACKAGE_OWNER_RELATIONS . " AS A
			INNER JOIN " . TABLE_PACKAGES . " AS B ON B.package_id = A.package_id 
			WHERE A.owner_id='".$owner_id."' AND A.active='1' AND B.active='1'";
			if (isset($products_id) && $products_id !="") {
				$sql .= " AND B.products_id='".$products_id."'";
			}
			$rs = $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);	
				$package_credit = ($arr[0]['credits'] - $arr[0]['credit_used']);
				if($package_credit > 0) {
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
	}

	function fun_getUserPackageBasketPaymentStatus($user_id) {
		if($user_id == ""){
			return false;
		} else {
			$sql = "SELECT B.products_id, B.credits, A.credit_used FROM " . TABLE_PACKAGE_OWNER_RELATIONS . " AS A
			INNER JOIN " . TABLE_PACKAGES . " AS B ON B.package_id = A.package_id 
			WHERE A.owner_id='".$user_id."' AND A.active='1' AND B.active='1'";
			$rs = $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);	
				$package_credit = ($arr[0]['credits'] - $arr[0]['credit_used']);
				$products_id 	= $arr[0]['products_id'];
				if($package_credit > 0) {
					$sqlPay = "SELECT payment_status FROM " . TABLE_USER_CART . " WHERE user_id='".$user_id."' AND products_id='".$products_id."' ";
					$rsPay = $this->dbObj->createRecordset($sqlPay);
					if($this->dbObj->getRecordCount($rsPay) > 0) {
						$arrPay 		= $this->dbObj->fetchAssoc($rsPay);	
						$payment_status = $arrPay[0]['payment_status'];
						return $payment_status;
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
	}

/*
* Owner package specific functions : end here
*/

/*
* Property owner contact specific functions : start here
*/

	// Function for creating property owner details section 4 property preview
	// Function for creating property owner details section 4 property preview
	function fun_createPropertyOwnerDetails4PropertyPriview($property_id = ''){		
		if($property_id == ''){
			return false;
		} else {

			$owner_id = $this->dbObj->getField(TABLE_PROPERTY_OWNER_RELATIONS, "property_id", $property_id, "owner_id");
			if($owner_id !="") {
				$photo 			= $this->dbObj->getField(TABLE_USERS, "user_id", $owner_id, "photo");
				$profile_photo 	= SITE_UPLOAD_PATH.$photo;
			}

			$sqlQuery 	= "SELECT A.contact_name, A.contact_name_show, A.response_time, A.response_time_type, A.response_time_show FROM " . TABLE_PROPERTY_CONTACTS . " AS A WHERE A.property_id='".$property_id."'";
			$rsQuery 	= $this->dbObj->createRecordset($sqlQuery);
			if($this->dbObj->getRecordCount($rsQuery) > 0) {
				$arrQuery	= $this->dbObj->fetchAssoc($rsQuery);
				$contact_name 			= ucwords($arrQuery[0]['contact_name']);
				$contact_name_show 		= $arrQuery[0]['contact_name_show'];
				$response_time 			= $arrQuery[0]['response_time'];
				$response_time_type 	= $arrQuery[0]['response_time_type'];
				$response_time_show 	= $arrQuery[0]['response_time_show'];
				if($response_time > 1) {
					$txtResponseTime = ($response_time_type == 'H')? $response_time." hours":(($response_time_type == 'D')? $response_time." days":$response_time." months");
				} else {
					$txtResponseTime = ($response_time_type == 'H')? $response_time." hour":(($response_time_type == 'D')? $response_time." day":$response_time." month");
				}
				// Other details
				$sqlWebsite	= "SELECT A.* FROM " . TABLE_PROPERTY_OWNERWEBSITE_RELATIONS . " AS A WHERE A.property_id='".$property_id."' AND A.status='1'";
				$rsWebsite 	= $this->dbObj->createRecordset($sqlWebsite);
				$arrWebsite	= $this->dbObj->fetchAssoc($rsWebsite);
				if(is_array($arrWebsite)) {
					$owner_website_url 		= $arrWebsite[0]['owner_website_url'];
				}
	
				$sqlPhone	= "SELECT A.*,
								B.countries_isd_code
								FROM " . TABLE_PROPERTY_CONTACT_NUMBERS . " AS A 
								INNER JOIN " . TABLE_COUNTRIES . " AS B ON A.contact_number_countryid = B.countries_id
								WHERE A.property_id='".$property_id."'";
	/*
				$sqlPhone	= "SELECT A.*,
								B.countries_isd_code
								FROM " . TABLE_PROPERTY_CONTACT_NUMBERS . " AS A 
								INNER JOIN " . TABLE_COUNTRIES . " AS B ON A.contact_number_typeid = B.countries_id
								WHERE A.property_id='".$property_id."' AND A.contact_number_show='1'
								";
	*/
				$rsPhone 	= $this->dbObj->createRecordset($sqlPhone);
				if($this->dbObj->getRecordCount($rsPhone) > 0){
					$arrPhone	= $this->dbObj->fetchAssoc($rsPhone);
					$arrPh 		= array();
					for($j = 0; $j < count($arrPhone); $j++) {
						array_push($arrPh, "+".$arrPhone[$j]['countries_isd_code']." - ".$arrPhone[$j]['contact_number']);
					}
					$txtPhone 	= implode(", ", $arrPh);
				}
	
				$sqlLang	= "SELECT A.*,
								B.language_name
								FROM " . TABLE_PROPERTY_CONTACT_LANGUAGES . " AS A 
								INNER JOIN " . TABLE_LANGUAGES . " AS B ON A.language_id = B.language_id
								WHERE A.property_id='".$property_id."'";
	/*
				$sqlLang	= "SELECT A.*,
								B.language_name
								FROM " . TABLE_PROPERTY_CONTACT_LANGUAGES . " AS A 
								INNER JOIN " . TABLE_LANGUAGES . " AS B ON A.language_id = B.language_id
								WHERE A.property_id='".$property_id."' AND A.language_show='1'
								";
	*/
				$rsLang 	= $this->dbObj->createRecordset($sqlLang);
				if($this->dbObj->getRecordCount($rsLang) > 0){
					$arrLang	= $this->dbObj->fetchAssoc($rsLang);
					$arr 		= array();
					for($i = 0; $i < count($arrLang); $i++) {
						array_push($arr, $arrLang[$i]['language_name']);
					}
					$txtLang 	= implode(", ", $arr);
				}

				echo '<div class="box3" align="center">';
				echo '<table align="left" width="100%" cellspacing="0" cellpadding="0">';
				//if(isset($contact_photo) && ($contact_photo != "")) {
					echo '<tr>';
					echo '<td colspan="2" align="center" valign="top" style="background-color:#efefef; padding-top:10px; padding-bottom:10px;">';
					echo '<img src="'.$profile_photo.'" onerror="this.src=\''.SITE_IMAGES.'profile-placer.png\'" />';
					echo '</td>';
					echo '</tr>';
				//}

				echo '<tr><td colspan="2" height="30px">&nbsp;</td></tr>';
				if(isset($contact_name_show) && ($contact_name_show == "1")) {
					echo '<tr>';
					echo '<td align="left" valign="top" style="padding-bottom:10px;"><strong>'.$contact_name.'</strong></td>';
					//echo '<td align="right" valign="top" style="padding-bottom:10px;"><a href="'.SITE_URL.'property-owner-profile.php?pid='.$property_id.'" class="button-blue-square" style="padding:10px 15px 10px 15px; font-size:12px; text-decoration:none;">View Profile</a></td>';
					echo '<td align="right" valign="top" style="padding-bottom:10px;"><a  href="#showSectionOwner" onclick="return showSection(8);" class="button-blue-square" style="padding:10px 15px 10px 15px; font-size:12px; text-decoration:none;">View Profile</a></td>';
					echo '</tr>';
				}
				echo '<tr><td colspan="2" height="20px">&nbsp;</td></tr>';
				/*
				if(isset($owner_website_url) && ($owner_website_url != "")) {
					echo '<tr><td align="left" valign="top">Website : <a href="'.$owner_website_url.'" class="blue-link">Visit owners website</a></td></tr>';
				}
				if(isset($txtPhone) && ($txtPhone != "")) {
					echo '<tr><td align="left" valign="top">Telephone : '.$txtPhone.'</td></tr>';
				}
				if(isset($response_time_show) && ($response_time_show == "1")) {
					echo '<tr><td align="left" valign="top">Response time : Normaly within '.$txtResponseTime.'</td></tr>';
				}
				if(isset($txtLang) && $txtLang !="") {
					echo '<tr><td align="left" valign="top">Languages spoken : '.$txtLang.'</td></tr>';
				}
				*/
				echo '</table>';
				echo '</div>';
			}
		}
	}

	function fun_createPropertyOwnerProfileDetails($property_id = ''){		
		if($property_id == ''){
			return false;
		} else {
			$owner_id = $this->dbObj->getField(TABLE_PROPERTY_OWNER_RELATIONS, "property_id", $property_id, "owner_id");
			if($owner_id !="") {
				$photo 			= $this->dbObj->getField(TABLE_USERS, "user_id", $owner_id, "photo");
				$story 			= $this->dbObj->getField(TABLE_USERS, "user_id", $owner_id, "story");
				$profile_photo 	= SITE_UPLOAD_PATH.$photo;
			}

			$propLocInfoArr = $this->fun_getPropertyLocInfoArr($property_id);
			$fr_url = $this->fun_getPropertyFriendlyLink($property_id);
			if(isset($fr_url) && $fr_url != "") {
				$property_link = SITE_URL."vacation-rentals/".strtolower($fr_url);
			} else {
				if(isset($propLocInfoArr['region_name']) && $propLocInfoArr['region_name'] != "") {
					$property_link = SITE_URL."vacation-rentals/in.".str_replace("/", "_", str_replace(" ", "-", strtolower($propLocInfoArr['region_name'])))."/".fill_zero_left($property_id, "0", (6-strlen($property_id)));
				} else {
					$property_link = SITE_URL."vacation-rentals/in.".str_replace("/", "_", str_replace(" ", "-", strtolower($propLocInfoArr['area_name'])))."/".fill_zero_left($property_id, "0", (6-strlen($property_id)));
				}
			}

			$sqlQuery 	= "SELECT A.contact_name, A.contact_name_show, A.response_time, A.response_time_type, A.response_time_show FROM " . TABLE_PROPERTY_CONTACTS . " AS A WHERE A.property_id='".$property_id."'";
			$rsQuery 	= $this->dbObj->createRecordset($sqlQuery);
			if($this->dbObj->getRecordCount($rsQuery) > 0) {
				$arrQuery	= $this->dbObj->fetchAssoc($rsQuery);
				$contact_name 			= ucwords($arrQuery[0]['contact_name']);
				$contact_name_show 		= $arrQuery[0]['contact_name_show'];
				$response_time 			= $arrQuery[0]['response_time'];
				$response_time_type 	= $arrQuery[0]['response_time_type'];
				$response_time_show 	= $arrQuery[0]['response_time_show'];
				if($response_time > 1) {
					$txtResponseTime = ($response_time_type == 'H')? $response_time." hours":(($response_time_type == 'D')? $response_time." days":$response_time." months");
				} else {
					$txtResponseTime = ($response_time_type == 'H')? $response_time." hour":(($response_time_type == 'D')? $response_time." day":$response_time." month");
				}
				// Other details
				$sqlWebsite	= "SELECT A.* FROM " . TABLE_PROPERTY_OWNERWEBSITE_RELATIONS . " AS A WHERE A.property_id='".$property_id."' AND A.status='1'";
				$rsWebsite 	= $this->dbObj->createRecordset($sqlWebsite);
				$arrWebsite	= $this->dbObj->fetchAssoc($rsWebsite);
				if(is_array($arrWebsite)) {
					$owner_website_url 		= $arrWebsite[0]['owner_website_url'];
				}
	
				//For Phone
				$arrPh 		= array();
				$sqlPhone	= "SELECT A.*,
								B.countries_isd_code
								FROM " . TABLE_PROPERTY_CONTACT_NUMBERS . " AS A 
								INNER JOIN " . TABLE_COUNTRIES . " AS B ON A.contact_number_countryid = B.countries_id
								WHERE A.property_id='".$property_id."'";
				$rsPhone 	= $this->dbObj->createRecordset($sqlPhone);
				if($this->dbObj->getRecordCount($rsPhone) > 0){
					$arrPhone	= $this->dbObj->fetchAssoc($rsPhone);
					for($j = 0; $j < count($arrPhone); $j++) {
						array_push($arrPh, "+".$arrPhone[$j]['countries_isd_code']." - ".$arrPhone[$j]['contact_number']);
					}
				}
				/*
	
				$sqlPhoneOwr	= "SELECT A.*,
								B.countries_isd_code
								FROM " . TABLE_USER_CONTACT_NUMBERS . " AS A 
								INNER JOIN " . TABLE_COUNTRIES . " AS B ON A.contact_number_countryid = B.countries_id
								WHERE A.user_id='".$owner_id."'";
				$rsPhoneOwr 	= $this->dbObj->createRecordset($sqlPhoneOwr);
				if($this->dbObj->getRecordCount($rsPhoneOwr) > 0){
					$arrPhoneOwr	= $this->dbObj->fetchAssoc($rsPhoneOwr);
					for($j = 0; $j < count($arrPhoneOwr); $j++) {
						array_push($arrPh, "+".$arrPhoneOwr[$j]['countries_isd_code']." - ".$arrPhoneOwr[$j]['contact_number']);
					}
				}
				*/
	
				$txtPhone 	= implode(", ", array_unique($arrPh));

				//For Languages
				$arrLn 		= array();
				$sqlLang	= "SELECT A.*,
								B.language_name
								FROM " . TABLE_PROPERTY_CONTACT_LANGUAGES . " AS A 
								INNER JOIN " . TABLE_LANGUAGES . " AS B ON A.language_id = B.language_id
								WHERE A.property_id='".$property_id."'";
				$rsLang 	= $this->dbObj->createRecordset($sqlLang);
				if($this->dbObj->getRecordCount($rsLang) > 0){
					$arrLang	= $this->dbObj->fetchAssoc($rsLang);
					for($i = 0; $i < count($arrLang); $i++) {
						array_push($arrLn, $arrLang[$i]['language_name']);
					}
				}
				/*
				$sqlLangOwr	= "SELECT A.*,
								B.language_name
								FROM " . TABLE_USER_CONTACT_LANGUAGES . " AS A 
								INNER JOIN " . TABLE_LANGUAGES . " AS B ON A.language_id = B.language_id
								WHERE A.user_id='".$owner_id."'";
				$rsLangOwr 	= $this->dbObj->createRecordset($sqlLangOwr);
				if($this->dbObj->getRecordCount($rsLangOwr) > 0){
					$arrLangOwr	= $this->dbObj->fetchAssoc($rsLangOwr);
					for($i = 0; $i < count($arrLangOwr); $i++) {
						array_push($arrLn, $arrLangOwr[$i]['language_name']);
					}
				}
				*/
				$txtLang 	= implode(", ", array_unique($arrLn));

				echo '<div class="pad-top10" align="left">';
				echo '<table align="left" width="100%" cellspacing="0" cellpadding="0">';
				//if(isset($contact_photo) && ($contact_photo != "")) {
					echo '<tr>';
					echo '<td align="center" valign="top" style="background-color:#efefef; padding-top:10px; padding-bottom:10px; width:240px;">';
					echo '<img src="'.$profile_photo.'" onerror="this.src=\''.SITE_IMAGES.'profile-placer.png\'" />';
					echo '</td>';
					echo '<td align="left" valign="top" style="padding-bottom:10px; padding-left:10px;">';
					if(isset($contact_name_show) && ($contact_name_show == "1")) {
						echo '<br><strong>'.$contact_name.'</strong>';
					}
					if(isset($story) && ($story != "")) {
						echo '<br>'.$story.'<br>';
					}
					
					//echo '<br><br><a href="'.$property_link.'" class="button-blue-square" style="padding:10px 15px 10px 15px; font-size:12px; text-decoration:none;">Return to property</a>';
					echo '</td>';
					echo '</tr>';
				//}


				echo '<tr><td colspan="2" height="20px">&nbsp;</td></tr>';
				if(isset($owner_website_url) && ($owner_website_url != "")) {
					echo '<tr><td align="right" valign="top">Website :</td><td align="left" valign="top" class="pad-lft10"><a href="'.$owner_website_url.'" class="blue-link">Visit owners website</a></td></tr>';
				}
				if(isset($txtPhone) && ($txtPhone != "")) {
					echo '<tr><td align="right" valign="top">Telephone : </td><td align="left" valign="top" class="pad-lft10">'.$txtPhone.'</td></tr>';
				}
				if(isset($response_time_show) && ($response_time_show == "1")) {
					echo '<tr><td align="right" valign="top">Response time : </td><td align="left" valign="top" class="pad-lft10">Normaly within '.$txtResponseTime.'</td></tr>';
				}
				if(isset($txtLang) && $txtLang !="") {
					echo '<tr><td align="right" valign="top">Languages spoken : </td><td align="left" valign="top" class="pad-lft10">'.$txtLang.'</td></tr>';
				}

				echo '</table>';
				echo '</div>';
			}
		}
	}

/*
* Property owner contact specific functions : end here
*/


/*
* Property Features / Aminities spific functions : start here
*/

	function fun_getPropertyArrByPropertyFacility( $property_facility_id = '' ) {
		if ( $property_facility_id == '' ) {
			return false;
		} else {
			$sql = "SELECT A.property_id AS property_id 
			FROM  " . TABLE_PROPERTY . " AS A
			INNER JOIN " . TABLE_PROPERTY_FEATURES_RELATIONS . " AS B ON B.property_id = A.property_id
			WHERE ((B.feature_ids like '%,".$property_facility_id .",%') OR (B.feature_ids like '".$property_facility_id .",%') OR (B.feature_ids like '%,".$property_facility_id ."')) AND A.active='1'";

			$rs = $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);
				return $arr;
			}
			else{
				return false;
			}
		}
	}

	// Function for creating array for property_type along with total no. of actice property
	function fun_getPropertyFacilityArrayWithTotalProp($property_facility_id=''){		
		$propertyFacilityArray 	= array();		
		if($property_facility_id !="") {
        	//Find all query
            $sqlPropFacility = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE property_features_id='".$property_facility_id."' ORDER BY property_features_name";
		} else {
            $sqlPropFacility = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " ORDER BY property_features_name";
		}

		$rsPropFacility		= $this->dbObj->createRecordset($sqlPropFacility);
		if($this->dbObj->getRecordCount($rsPropFacility) > 0) {
			$arrFacility	= $this->dbObj->fetchAssoc($rsPropFacility);
			for($i = 0; $i < count($arrFacility); $i++) {
				$facility_id 										= $arrFacility[$i]['property_features_id'];
				$facility_name 										= $arrFacility[$i]['property_features_name'];
				$total_property 									= $this->fun_countPropertyByPropertyFacility($facility_id);
				$propertyFacilityArray[$i]['property_facility_id'] 	= $facility_id;
				$propertyFacilityArray[$i]['property_facility_name']= $facility_name;
				$propertyFacilityArray[$i]['total_properties']		= $total_property;
			}
			return $propertyFacilityArray;
		}
	}

	// Function for creating array for property_type along with total no. of actice property
	function fun_getPropertyHolidayTypeWithTotalProp($property_features_id=''){		
		$propertyHolidayTypeArray 	= array();		
		if($property_features_id !="") {
        	//Find all query
            $sqlPropHolidayType = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE property_features_id='".$property_features_id."' AND property_features_group_id='1' ORDER BY property_features_name";
		} else {
            $sqlPropHolidayType = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE property_features_group_id='1' ORDER BY property_features_name";
		}

		$rsPropHolidayType		= $this->dbObj->createRecordset($sqlPropHolidayType);
		if($this->dbObj->getRecordCount($rsPropHolidayType) > 0) {
			$arrHolidayType	= $this->dbObj->fetchAssoc($rsPropHolidayType);
			for($i = 0; $i < count($arrHolidayType); $i++) {
				$property_features_id 										= $arrHolidayType[$i]['property_features_id'];
				$property_features_name 									= $arrHolidayType[$i]['property_features_name'];
				$total_property 											= $this->fun_countPropertyByPropertyFacility($holidaytype_id);
				$propertyHolidayTypeArray[$i]['property_holidaytype_id'] 	= $holidaytype_id;
				$propertyHolidayTypeArray[$i]['property_holidaytype_name'] 	= $holidaytype_name;
				$propertyHolidayTypeArray[$i]['total_properties']			= $total_property;
			}
			return $propertyHolidayTypeArray;
		}
	}

	function fun_getPropertyKitchenArrayWithTotalProp($property_features_id=''){		
		$propertyKitchenArray 	= array();		
		if($property_features_id !="") {
        	//Find all query
            $sqlPropKitchen = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE property_features_id='".$property_features_id."' AND property_features_group_id='2' ORDER BY property_features_name";
		} else {
            $sqlPropKitchen = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE property_features_group_id='2' ORDER BY property_features_name";
		}

		$rsPropKitchen		= $this->dbObj->createRecordset($sqlPropKitchen);
		if($this->dbObj->getRecordCount($rsPropKitchen) > 0) {
			$arrKitchen	= $this->dbObj->fetchAssoc($rsPropKitchen);
			for($i = 0; $i < count($arrKitchen); $i++) {
				$kitchen_id 											= $arrKitchen[$i]['property_features_id'];
				$kitchen_name 											= $arrKitchen[$i]['property_features_name'];
				$total_property 										= $this->fun_countPropertyByPropertyFacility($kitchen_id);
				$propertyKitchenArray[$i]['property_kitchen_id'] 		= $kitchen_id;
				$propertyKitchenArray[$i]['property_kitchen_name']		= $kitchen_name;
				$propertyKitchenArray[$i]['total_properties']			= $total_property;
			}
			return $propertyKitchenArray;
		}
	}

	function fun_getPropertyOutsideArrayWithTotalProp($property_features_id=''){		
		$propertyOutsideArray 	= array();		
		if($property_features_id !="") {
        	//Find all query
            $sqlPropOutside = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE property_features_id='".$property_features_id."' AND property_features_group_id='4' ORDER BY property_features_name";
		} else {
            $sqlPropOutside = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE property_features_group_id='4' ORDER BY property_features_name";
		}

		$rsPropOutside		= $this->dbObj->createRecordset($sqlPropOutside);
		if($this->dbObj->getRecordCount($rsPropOutside) > 0) {
			$arrOutside	= $this->dbObj->fetchAssoc($rsPropOutside);
			for($i = 0; $i < count($arrOutside); $i++) {
				$outside_id 											= $arrOutside[$i]['property_features_id'];
				$outside_name 											= $arrOutside[$i]['property_features_name'];
				$total_property 										= $this->fun_countPropertyByPropertyFacility($outside_id);
				$propertyOutsideArray[$i]['property_outside_id'] 		= $outside_id;
				$propertyOutsideArray[$i]['property_outside_name']		= $outside_name;
				$propertyOutsideArray[$i]['total_properties']			= $total_property;
			}
			return $propertyOutsideArray;
		}
	}
	function fun_getPropertyActivitiesNearbyArrayWithTotalProp($property_features_id=''){		
		$propertyActivitiesNearbyArray 	= array();		
		if($property_features_id !="") {
        	//Find all query
            $sqlPropActivitiesNearby = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE property_features_id='".$property_features_id."' AND property_features_group_id='6' ORDER BY property_features_name";
		} else {
            $sqlPropActivitiesNearby = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE property_features_group_id='6' ORDER BY property_features_name";
		}

		$rsPropActivitiesNearby		= $this->dbObj->createRecordset($sqlPropActivitiesNearby);
		if($this->dbObj->getRecordCount($rsPropActivitiesNearby) > 0) {
			$arrActivitiesNearby	= $this->dbObj->fetchAssoc($rsPropActivitiesNearby);
			for($i = 0; $i < count($arrActivitiesNearby); $i++) {
				$activitiesnearby_id 													= $arrActivitiesNearby[$i]['property_features_id'];
				$activitiesnearby_name 													= $arrActivitiesNearby[$i]['property_features_name'];
				$total_property 														= $this->fun_countPropertyByPropertyFacility($activitiesnearby_id);
				$propertyActivitiesNearbyArray[$i]['property_activitiesnearby_id'] 		= $activitiesnearby_id;
				$propertyActivitiesNearbyArray[$i]['property_activitiesnearby_name']	= $activitiesnearby_name;
				$propertyActivitiesNearbyArray[$i]['total_properties']					= $total_property;
			}
			return $propertyActivitiesNearbyArray;
		}
	}
	function fun_getPropertyHeatingCoolingArrayWithTotalProp($property_features_id=''){		
		$propertyHeatingCoolingArray 	= array();		
		if($property_features_id !="") {
        	//Find all query
            $sqlPropHeatingCooling = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE property_features_id='".$property_features_id."' AND property_features_group_id='7' ORDER BY property_features_name";
		} else {
            $sqlPropHeatingCooling = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE property_features_group_id='7' ORDER BY property_features_name";
		}

		$rsPropHeatingCooling		= $this->dbObj->createRecordset($sqlPropHeatingCooling);
		if($this->dbObj->getRecordCount($rsPropHeatingCooling) > 0) {
			$arrHeatingCooling	= $this->dbObj->fetchAssoc($rsPropHeatingCooling);
			for($i = 0; $i < count($arrHeatingCooling); $i++) {
				$heatingcooling_id 													= $arrHeatingCooling[$i]['property_features_id'];
				$heatingcooling_name 												= $arrHeatingCooling[$i]['property_features_name'];
				$total_property 													= $this->fun_countPropertyByPropertyFacility($heatingcooling_id);
				$propertyHeatingCoolingArray[$i]['property_heatingcooling_id'] 		= $heatingcooling_id;
				$propertyHeatingCoolingArray[$i]['property_heatingcooling_name']	= $heatingcooling_name;
				$propertyHeatingCoolingArray[$i]['total_properties']				= $total_property;
			}
			return $propertyHeatingCoolingArray;
		}
	}
	function fun_getPropertyEntertainmentArrayWithTotalProp($property_features_id=''){		
		$propertyEntertainmentArray 	= array();		
		if($property_features_id !="") {
        	//Find all query
            $sqlPropEntertainment = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE property_features_id='".$property_features_id."' AND property_features_group_id='3' ORDER BY property_features_name";
		} else {
            $sqlPropEntertainment = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE property_features_group_id='3' ORDER BY property_features_name";
		}

		$rsPropEntertainment		= $this->dbObj->createRecordset($sqlPropEntertainment);
		if($this->dbObj->getRecordCount($rsPropEntertainment) > 0) {
			$arrEntertainment	= $this->dbObj->fetchAssoc($rsPropEntertainment);
			for($i = 0; $i < count($arrEntertainment); $i++) {
				$entertainment_id 													= $arrEntertainment[$i]['property_features_id'];
				$entertainment_name 												= $arrEntertainment[$i]['property_features_name'];
				$total_property 													= $this->fun_countPropertyByPropertyFacility($entertainment_id);
				$propertyEntertainmentArray[$i]['property_entertainment_id'] 		= $entertainment_id;
				$propertyEntertainmentArray[$i]['property_entertainment_name']		= $entertainment_name;
				$propertyEntertainmentArray[$i]['total_properties']					= $total_property;
			}
			return $propertyEntertainmentArray;
		}
	}
	function fun_getPropertyLocationViewArrayWithTotalProp($property_features_id=''){		
		$propertyLocationViewArray 	= array();		
		if($property_features_id !="") {
        	//Find all query
            $sqlPropLocationView = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE property_features_id='".$property_features_id."' AND property_features_group_id='9' ORDER BY property_features_name";
		} else {
            $sqlPropLocationView = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE property_features_group_id='9' ORDER BY property_features_name";
		}

		$rsPropLocationView		= $this->dbObj->createRecordset($sqlPropLocationView);
		if($this->dbObj->getRecordCount($rsPropLocationView) > 0) {
			$arrLocationView	= $this->dbObj->fetchAssoc($rsPropLocationView);
			for($i = 0; $i < count($arrLocationView); $i++) {
				$locationview_id 													= $arrLocationView[$i]['property_features_id'];
				$locationview_name 													= $arrLocationView[$i]['property_features_name'];
				$total_property 													= $this->fun_countPropertyByPropertyFacility($locationview_id);
				$propertyLocationViewArray[$i]['property_locationview_id'] 			= $locationview_id;
				$propertyLocationViewArray[$i]['property_locationview_name']		= $locationview_name;
				$propertyLocationViewArray[$i]['total_properties']					= $total_property;
			}
			return $propertyLocationViewArray;
		}
	}
	function fun_getPropertyServicesArrayWithTotalProp($property_features_id=''){		
		$propertyServicesArray 	= array();		
		if($property_features_id !="") {
        	//Find all query
            $sqlPropServices = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE property_features_id='".$property_features_id."' AND property_features_group_id='8' ORDER BY property_features_name";
		} else {
            $sqlPropServices = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE property_features_group_id='8' ORDER BY property_features_name";
		}

		$rsPropServices		= $this->dbObj->createRecordset($sqlPropServices);
		if($this->dbObj->getRecordCount($rsPropServices) > 0) {
			$arrServices	= $this->dbObj->fetchAssoc($rsPropServices);
			for($i = 0; $i < count($arrServices); $i++) {
				$services_id 													= $arrServices[$i]['property_features_id'];
				$services_name 													= $arrServices[$i]['property_features_name'];
				$total_property 												= $this->fun_countPropertyByPropertyFacility($services_id);
				$propertyServicesArray[$i]['property_services_id'] 				= $services_id;
				$propertyServicesArray[$i]['property_services_name']			= $services_name;
				$propertyServicesArray[$i]['total_properties']					= $total_property;
			}
			return $propertyServicesArray;
		}
	}
	function fun_getPropertyGeneralArrayWithTotalProp($property_features_id=''){		
		$propertyGeneralArray 	= array();		
		if($property_features_id !="") {
        	//Find all query
            $sqlPropGeneral = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE property_features_id='".$property_features_id."' AND property_features_group_id='5' ORDER BY property_features_name";
		} else {
            $sqlPropGeneral = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE property_features_group_id='5' ORDER BY property_features_name";
		}

		$rsPropGeneral		= $this->dbObj->createRecordset($sqlPropGeneral);
		if($this->dbObj->getRecordCount($rsPropGeneral) > 0) {
			$arrGeneral	= $this->dbObj->fetchAssoc($rsPropGeneral);
			for($i = 0; $i < count($arrGeneral); $i++) {
				$general_id 													= $arrGeneral[$i]['property_features_id'];
				$general_name 													= $arrGeneral[$i]['property_features_name'];
				$total_property 												= $this->fun_countPropertyByPropertyFacility($general_id);
				$propertyGeneralArray[$i]['property_general_id'] 				= $general_id;
				$propertyGeneralArray[$i]['property_general_name']				= $general_name;
				$propertyGeneralArray[$i]['total_properties']					= $total_property;
			}
			return $propertyGeneralArray;
		}
	}


	function fun_countPropertyByPropertyFacility( $property_facility_id = '' ) {
		if ( $property_facility_id == '' ) {
			return false;
		} else {
			$sql = "SELECT COUNT(*) total_result 
			FROM  " . TABLE_PROPERTY . " AS A
			INNER JOIN " . TABLE_PROPERTY_FEATURES_RELATIONS . " AS B ON B.property_id = A.property_id
			WHERE ((B.feature_ids like '%,".$property_facility_id .",%') OR (B.feature_ids like '".$property_facility_id .",%') OR (B.feature_ids like '%,".$property_facility_id ."')) AND A.active='1'";

			$rs = $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);
				$total_result = $arr[0]['total_result'];
			}
			else{
				$total_result = 0;
			}
			return $total_result;
		}
	}

// MC Ver 2.0 Function : Start Here
	// Function for creating array for property_type along with total no. of actice property
	function fun_getPropertyHolidayTypeArrayRefineByCriteria($txtcountryids = '', $txtareaids = '', $txtregionids = '', $txtlocationids = '', $txtFromUnixTime = '', $txtToUnixTime = '', $txtpropertytypeids = '', $txtneedsleep = '', $txtonlybed = '', $txttotalbed = '', $txtholidaytypeids = '', $txtkitchenlinenids = '', $txtoutsideids = '', $txtactivitynearbyids = '', $txtheatingcoolingids = '', $txtenterainmentids = '', $txtlocationviewids = '', $txtserviceids = '', $txtgeneralids = '', $featured ='', $latedeal ='', $parameter = '') {
		$property_ids = $this->fun_getPropertyIdsByRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids,  $txtFromUnixTime, $txtToUnixTime, $txtpropertytypeids, $txtneedsleep, $txtonlybed, $txttotalbed, $txtholidaytypeids, $txtkitchenlinenids, $txtoutsideids, $txtactivitynearbyids, $txtheatingcoolingids, $txtenterainmentids, $txtlocationviewids, $txtserviceids, $txtgeneralids, $featured, $latedeal, $parameter);
		$propertyHolidayTypeArray 	= array();
		if(isset($property_ids) && $property_ids !="") {
			$sql = "SELECT B.feature_ids AS feature_ids
			FROM " . TABLE_PROPERTY . " AS A 
			LEFT JOIN " . TABLE_PROPERTY_FEATURES_RELATIONS . " AS B ON B.property_id = A.property_id 
			WHERE A.active='1' AND A.property_id IN (".$property_ids.")";
			$rs	= $this->dbObj->createRecordset($sql);
			$feature_ids = "";
			if($this->dbObj->getRecordCount($rs) > 0) {
				$arr	= $this->dbObj->fetchAssoc($rs);
				for($i = 0; $i < count($arr); $i++) {
					if($arr[$i]['feature_ids'] != "") {
						$feature_ids .= $arr[$i]['feature_ids'].",";
					}
				}
				$feature_ids = (substr($feature_ids, strlen($feature_ids)-1, strlen($feature_ids)) == ",")?substr($feature_ids, 0, strlen($feature_ids)-1):$feature_ids;
			}
			if($feature_ids !="") {
				$sqlPropHolidayType = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE property_features_id IN (".$feature_ids.") AND property_features_group_id='1' ORDER BY property_features_name";
			} else {
				$sqlPropHolidayType = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE  property_features_group_id='1' ORDER BY property_features_name";
			}
		} else {
            $sqlPropHolidayType = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE  property_features_group_id='1' ORDER BY property_features_name";
		}

		$rsPropHolidayType		= $this->dbObj->createRecordset($sqlPropHolidayType);
		if($this->dbObj->getRecordCount($rsPropHolidayType) > 0) {
			$arrHolidayType	= $this->dbObj->fetchAssoc($rsPropHolidayType);
			for($i = 0; $i < count($arrHolidayType); $i++) {
				$holidaytype_id 											= $arrHolidayType[$i]['property_features_id'];
				$holidaytype_name 											= $arrHolidayType[$i]['property_features_name'];
				$total_property 											= $this->fun_countRefinePropertyByPropertyFacility($holidaytype_id, $txtcountryids, $txtareaids, $txtregionids, $txtlocationids,  $txtFromUnixTime, $txtToUnixTime, $txtpropertytypeids, $txtneedsleep, $txtonlybed, $txttotalbed, $txtholidaytypeids, $txtkitchenlinenids, $txtoutsideids, $txtactivitynearbyids, $txtheatingcoolingids, $txtenterainmentids, $txtlocationviewids, $txtserviceids, $txtgeneralids, $parameter);
				$propertyHolidayTypeArray[$i]['property_holidaytype_id'] 	= $holidaytype_id;
				$propertyHolidayTypeArray[$i]['property_holidaytype_name']	= $holidaytype_name;
				$propertyHolidayTypeArray[$i]['total_properties']			= $total_property;
			}
			return $propertyHolidayTypeArray;
		}
	}

	function fun_getPropertyKitchenArrayRefineByCriteria($txtcountryids = '', $txtareaids = '', $txtregionids = '', $txtlocationids = '', $txtFromUnixTime = '', $txtToUnixTime = '', $txtpropertytypeids = '', $txtneedsleep = '', $txtonlybed = '', $txttotalbed = '', $txtholidaytypeids = '', $txtkitchenlinenids = '', $txtoutsideids = '', $txtactivitynearbyids = '', $txtheatingcoolingids = '', $txtenterainmentids = '', $txtlocationviewids = '', $txtserviceids = '', $txtgeneralids = '', $featured ='', $latedeal ='', $parameter = '') {
		$property_ids = $this->fun_getPropertyIdsByRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids,  $txtFromUnixTime, $txtToUnixTime, $txtpropertytypeids, $txtneedsleep, $txtonlybed, $txttotalbed, $txtholidaytypeids, $txtkitchenlinenids, $txtoutsideids, $txtactivitynearbyids, $txtheatingcoolingids, $txtenterainmentids, $txtlocationviewids, $txtserviceids, $txtgeneralids, $featured, $latedeal, $parameter);
		$propertyKitchenArray 	= array();
		if(isset($property_ids) && $property_ids !="") {
			$sql = "SELECT B.feature_ids AS feature_ids
			FROM " . TABLE_PROPERTY . " AS A 
			LEFT JOIN " . TABLE_PROPERTY_FEATURES_RELATIONS . " AS B ON B.property_id = A.property_id 
			WHERE A.active='1' AND A.property_id IN (".$property_ids.")";
			$rs	= $this->dbObj->createRecordset($sql);
			$feature_ids = "";
			if($this->dbObj->getRecordCount($rs) > 0) {
				$arr	= $this->dbObj->fetchAssoc($rs);
				for($i = 0; $i < count($arr); $i++) {
					if($arr[$i]['feature_ids'] != "") {
						$feature_ids .= $arr[$i]['feature_ids'].",";
					}
				}
				$feature_ids = (substr($feature_ids, strlen($feature_ids)-1, strlen($feature_ids)) == ",")?substr($feature_ids, 0, strlen($feature_ids)-1):$feature_ids;
			}
			if($feature_ids !="") {
				$sqlPropKitchen = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE property_features_id IN (".$feature_ids.") AND property_features_group_id='2' ORDER BY property_features_name";

			} else {
				$sqlPropKitchen = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE  property_features_group_id='2' ORDER BY property_features_name";
			}
		} else {
            $sqlPropKitchen = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE  property_features_group_id='2' ORDER BY property_features_name";
		}

		$rsPropKitchen		= $this->dbObj->createRecordset($sqlPropKitchen);
		if($this->dbObj->getRecordCount($rsPropKitchen) > 0) {
			$arrKitchen	= $this->dbObj->fetchAssoc($rsPropKitchen);
			for($i = 0; $i < count($arrKitchen); $i++) {
				$kitchen_id 											= $arrKitchen[$i]['property_features_id'];
				$kitchen_name 											= $arrKitchen[$i]['property_features_name'];
				$total_property 										= $this->fun_countRefinePropertyByPropertyFacility($kitchen_id, $txtcountryids, $txtareaids, $txtregionids, $txtlocationids,  $txtFromUnixTime, $txtToUnixTime, $txtpropertytypeids, $txtneedsleep, $txtonlybed, $txttotalbed, $txtholidaytypeids, $txtkitchenlinenids, $txtoutsideids, $txtactivitynearbyids, $txtheatingcoolingids, $txtenterainmentids, $txtlocationviewids, $txtserviceids, $txtgeneralids, $parameter);
				$propertyKitchenArray[$i]['property_kitchen_id'] 		= $kitchen_id;
				$propertyKitchenArray[$i]['property_kitchen_name']		= $kitchen_name;
				$propertyKitchenArray[$i]['total_properties']			= $total_property;
			}
			return $propertyKitchenArray;
		}
	}

	function fun_getPropertyOutsideArrayRefineByCriteria($txtcountryids = '', $txtareaids = '', $txtregionids = '', $txtlocationids = '', $txtFromUnixTime = '', $txtToUnixTime = '', $txtpropertytypeids = '', $txtneedsleep = '', $txtonlybed = '', $txttotalbed = '', $txtholidaytypeids = '', $txtkitchenlinenids = '', $txtoutsideids = '', $txtactivitynearbyids = '', $txtheatingcoolingids = '', $txtenterainmentids = '', $txtlocationviewids = '', $txtserviceids = '', $txtgeneralids = '', $parameter = '') {
		$property_ids = $this->fun_getPropertyIdsByRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids,  $txtFromUnixTime, $txtToUnixTime, $txtpropertytypeids, $txtneedsleep, $txtonlybed, $txttotalbed, $txtholidaytypeids, $txtkitchenlinenids, $txtoutsideids, $txtactivitynearbyids, $txtheatingcoolingids, $txtenterainmentids, $txtlocationviewids, $txtserviceids, $txtgeneralids, $parameter);
		$propertyOutsideArray 	= array();
		if(isset($property_ids) && $property_ids !="") {
			$sql = "SELECT B.feature_ids AS feature_ids
			FROM " . TABLE_PROPERTY . " AS A 
			LEFT JOIN " . TABLE_PROPERTY_FEATURES_RELATIONS . " AS B ON B.property_id = A.property_id 
			WHERE A.active='1' AND A.property_id IN (".$property_ids.")";
			$rs	= $this->dbObj->createRecordset($sql);
			$feature_ids = "";
			if($this->dbObj->getRecordCount($rs) > 0) {
				$arr	= $this->dbObj->fetchAssoc($rs);
				for($i = 0; $i < count($arr); $i++) {
					if($arr[$i]['feature_ids'] != "") {
						$feature_ids .= $arr[$i]['feature_ids'].",";
					}
				}
				$feature_ids = (substr($feature_ids, strlen($feature_ids)-1, strlen($feature_ids)) == ",")?substr($feature_ids, 0, strlen($feature_ids)-1):$feature_ids;
			}
			if($feature_ids !="") {
				$sqlPropOutside = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE property_features_id IN (".$feature_ids.") AND property_features_group_id='4' ORDER BY property_features_name";
			} else {
				$sqlPropOutside = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE  property_features_group_id='4' ORDER BY property_features_name";
			}
		} else {
            $sqlPropOutside = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE  property_features_group_id='4' ORDER BY property_features_name";
		}

		$rsPropOutside		= $this->dbObj->createRecordset($sqlPropOutside);
		if($this->dbObj->getRecordCount($rsPropOutside) > 0) {
			$arrOutside	= $this->dbObj->fetchAssoc($rsPropOutside);
			for($i = 0; $i < count($arrOutside); $i++) {
				$outside_id 											= $arrOutside[$i]['property_features_id'];
				$outside_name 											= $arrOutside[$i]['property_features_name'];
				$total_property 										= $this->fun_countRefinePropertyByPropertyFacility($outside_id, $txtcountryids, $txtareaids, $txtregionids, $txtlocationids,  $txtFromUnixTime, $txtToUnixTime, $txtpropertytypeids, $txtneedsleep, $txtonlybed, $txttotalbed, $txtholidaytypeids, $txtkitchenlinenids, $txtoutsideids, $txtactivitynearbyids, $txtheatingcoolingids, $txtenterainmentids, $txtlocationviewids, $txtserviceids, $txtgeneralids, $parameter);
				$propertyOutsideArray[$i]['property_outside_id'] 		= $outside_id;
				$propertyOutsideArray[$i]['property_outside_name']		= $outside_name;
				$propertyOutsideArray[$i]['total_properties']			= $total_property;
			}
			return $propertyOutsideArray;
		}
	}

	function fun_getPropertyActivitiesNearbyArrayRefineByCriteria($txtcountryids = '', $txtareaids = '', $txtregionids = '', $txtlocationids = '', $txtFromUnixTime = '', $txtToUnixTime = '', $txtpropertytypeids = '', $txtneedsleep = '', $txtonlybed = '', $txttotalbed = '', $txtholidaytypeids = '', $txtkitchenlinenids = '', $txtoutsideids = '', $txtactivitynearbyids = '', $txtheatingcoolingids = '', $txtenterainmentids = '', $txtlocationviewids = '', $txtserviceids = '', $txtgeneralids = '', $featured ='', $latedeal ='', $parameter = '') {
		$property_ids = $this->fun_getPropertyIdsByRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids,  $txtFromUnixTime, $txtToUnixTime, $txtpropertytypeids, $txtneedsleep, $txtonlybed, $txttotalbed, $txtholidaytypeids, $txtkitchenlinenids, $txtoutsideids, $txtactivitynearbyids, $txtheatingcoolingids, $txtenterainmentids, $txtlocationviewids, $txtserviceids, $txtgeneralids, $featured, $latedeal, $parameter);
		$propertyActivitiesNearbyArray 	= array();
		if(isset($property_ids) && $property_ids !="") {
			$sql = "SELECT B.feature_ids AS feature_ids
			FROM " . TABLE_PROPERTY . " AS A 
			LEFT JOIN " . TABLE_PROPERTY_FEATURES_RELATIONS . " AS B ON B.property_id = A.property_id 
			WHERE A.active='1' AND A.property_id IN (".$property_ids.")";
			$rs	= $this->dbObj->createRecordset($sql);
			$feature_ids = "";
			if($this->dbObj->getRecordCount($rs) > 0) {
				$arr	= $this->dbObj->fetchAssoc($rs);
				for($i = 0; $i < count($arr); $i++) {
					if($arr[$i]['feature_ids'] != "") {
						$feature_ids .= $arr[$i]['feature_ids'].",";
					}
				}
				$feature_ids = (substr($feature_ids, strlen($feature_ids)-1, strlen($feature_ids)) == ",")?substr($feature_ids, 0, strlen($feature_ids)-1):$feature_ids;
			}
			if($feature_ids !="") {
				$sqlPropActivitiesNearby = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE property_features_id IN (".$feature_ids.") AND property_features_group_id='6' ORDER BY property_features_name";
			} else {
				$sqlPropActivitiesNearby = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE  property_features_group_id='6' ORDER BY property_features_name";
			}
		} else {
            $sqlPropActivitiesNearby = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE  property_features_group_id='6' ORDER BY property_features_name";
		}

		$rsPropActivitiesNearby		= $this->dbObj->createRecordset($sqlPropActivitiesNearby);
		if($this->dbObj->getRecordCount($rsPropActivitiesNearby) > 0) {
			$arrActivitiesNearby	= $this->dbObj->fetchAssoc($rsPropActivitiesNearby);
			for($i = 0; $i < count($arrActivitiesNearby); $i++) {
				$activitiesnearby_id 													= $arrActivitiesNearby[$i]['property_features_id'];
				$activitiesnearby_name 													= $arrActivitiesNearby[$i]['property_features_name'];
				$total_property 														= $this->fun_countRefinePropertyByPropertyFacility($activitiesnearby_id, $txtcountryids, $txtareaids, $txtregionids, $txtlocationids,  $txtFromUnixTime, $txtToUnixTime, $txtpropertytypeids, $txtneedsleep, $txtonlybed, $txttotalbed, $txtholidaytypeids, $txtkitchenlinenids, $txtoutsideids, $txtactivitynearbyids, $txtheatingcoolingids, $txtenterainmentids, $txtlocationviewids, $txtserviceids, $txtgeneralids, $parameter);
				$propertyActivitiesNearbyArray[$i]['property_activitiesnearby_id'] 		= $activitiesnearby_id;
				$propertyActivitiesNearbyArray[$i]['property_activitiesnearby_name']	= $activitiesnearby_name;
				$propertyActivitiesNearbyArray[$i]['total_properties']					= $total_property;
			}
			return $propertyActivitiesNearbyArray;
		}
	}
	function fun_getPropertyHeatingCoolingArrayRefineByCriteria($txtcountryids = '', $txtareaids = '', $txtregionids = '', $txtlocationids = '', $txtFromUnixTime = '', $txtToUnixTime = '', $txtpropertytypeids = '', $txtneedsleep = '', $txtonlybed = '', $txttotalbed = '', $txtholidaytypeids = '', $txtkitchenlinenids = '', $txtoutsideids = '', $txtactivitynearbyids = '', $txtheatingcoolingids = '', $txtenterainmentids = '', $txtlocationviewids = '', $txtserviceids = '', $txtgeneralids = '', $featured ='', $latedeal ='', $parameter = '') {
		$property_ids = $this->fun_getPropertyIdsByRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids,  $txtFromUnixTime, $txtToUnixTime, $txtpropertytypeids, $txtneedsleep, $txtonlybed, $txttotalbed, $txtholidaytypeids, $txtkitchenlinenids, $txtoutsideids, $txtactivitynearbyids, $txtheatingcoolingids, $txtenterainmentids, $txtlocationviewids, $txtserviceids, $txtgeneralids, $featured, $latedeal, $parameter);
		$propertyHeatingCoolingArray 	= array();
		if(isset($property_ids) && $property_ids !="") {
			$sql = "SELECT B.feature_ids AS feature_ids
			FROM " . TABLE_PROPERTY . " AS A 
			LEFT JOIN " . TABLE_PROPERTY_FEATURES_RELATIONS . " AS B ON B.property_id = A.property_id 
			WHERE A.active='1' AND A.property_id IN (".$property_ids.")";
			$rs	= $this->dbObj->createRecordset($sql);
			$feature_ids = "";
			if($this->dbObj->getRecordCount($rs) > 0) {
				$arr	= $this->dbObj->fetchAssoc($rs);
				for($i = 0; $i < count($arr); $i++) {
					if($arr[$i]['feature_ids'] != "") {
						$feature_ids .= $arr[$i]['feature_ids'].",";
					}
				}
				$feature_ids = (substr($feature_ids, strlen($feature_ids)-1, strlen($feature_ids)) == ",")?substr($feature_ids, 0, strlen($feature_ids)-1):$feature_ids;
			}
			if($feature_ids !="") {
				$sqlPropHeatingCooling = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE property_features_id IN (".$feature_ids.") AND property_features_group_id='7' ORDER BY property_features_name";
			} else {
				$sqlPropHeatingCooling = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE  property_features_group_id='7' ORDER BY property_features_name";
			}
		} else {
            $sqlPropHeatingCooling = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE  property_features_group_id='7' ORDER BY property_features_name";
		}

		$rsPropHeatingCooling		= $this->dbObj->createRecordset($sqlPropHeatingCooling);
		if($this->dbObj->getRecordCount($rsPropHeatingCooling) > 0) {
			$arrHeatingCooling	= $this->dbObj->fetchAssoc($rsPropHeatingCooling);
			for($i = 0; $i < count($arrHeatingCooling); $i++) {
				$heatingcooling_id 													= $arrHeatingCooling[$i]['property_features_id'];
				$heatingcooling_name 												= $arrHeatingCooling[$i]['property_features_name'];
				$total_property 													= $this->fun_countRefinePropertyByPropertyFacility($heatingcooling_id, $txtcountryids, $txtareaids, $txtregionids, $txtlocationids,  $txtFromUnixTime, $txtToUnixTime, $txtpropertytypeids, $txtneedsleep, $txtonlybed, $txttotalbed, $txtholidaytypeids, $txtkitchenlinenids, $txtoutsideids, $txtactivitynearbyids, $txtheatingcoolingids, $txtenterainmentids, $txtlocationviewids, $txtserviceids, $txtgeneralids, $parameter);
				$propertyHeatingCoolingArray[$i]['property_heatingcooling_id'] 		= $heatingcooling_id;
				$propertyHeatingCoolingArray[$i]['property_heatingcooling_name']	= $heatingcooling_name;
				$propertyHeatingCoolingArray[$i]['total_properties']				= $total_property;
			}
			return $propertyHeatingCoolingArray;
		}
	}

	function fun_getPropertyEntertainmentArrayRefineByCriteria($txtcountryids = '', $txtareaids = '', $txtregionids = '', $txtlocationids = '', $txtFromUnixTime = '', $txtToUnixTime = '', $txtpropertytypeids = '', $txtneedsleep = '', $txtonlybed = '', $txttotalbed = '', $txtholidaytypeids = '', $txtkitchenlinenids = '', $txtoutsideids = '', $txtactivitynearbyids = '', $txtheatingcoolingids = '', $txtenterainmentids = '', $txtlocationviewids = '', $txtserviceids = '', $txtgeneralids = '', $featured ='', $latedeal ='', $parameter = '') {
		$property_ids = $this->fun_getPropertyIdsByRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids,  $txtFromUnixTime, $txtToUnixTime, $txtpropertytypeids, $txtneedsleep, $txtonlybed, $txttotalbed, $txtholidaytypeids, $txtkitchenlinenids, $txtoutsideids, $txtactivitynearbyids, $txtheatingcoolingids, $txtenterainmentids, $txtlocationviewids, $txtserviceids, $txtgeneralids, $featured, $latedeal, $parameter);
		$propertyEntertainmentArray 	= array();
		if(isset($property_ids) && $property_ids !="") {
			$sql = "SELECT B.feature_ids AS feature_ids
			FROM " . TABLE_PROPERTY . " AS A 
			LEFT JOIN " . TABLE_PROPERTY_FEATURES_RELATIONS . " AS B ON B.property_id = A.property_id 
			WHERE A.active='1' AND A.property_id IN (".$property_ids.")";
			$rs	= $this->dbObj->createRecordset($sql);
			$feature_ids = "";
			if($this->dbObj->getRecordCount($rs) > 0) {
				$arr	= $this->dbObj->fetchAssoc($rs);
				for($i = 0; $i < count($arr); $i++) {
					if($arr[$i]['feature_ids'] != "") {
						$feature_ids .= $arr[$i]['feature_ids'].",";
					}
				}
				$feature_ids = (substr($feature_ids, strlen($feature_ids)-1, strlen($feature_ids)) == ",")?substr($feature_ids, 0, strlen($feature_ids)-1):$feature_ids;
			}
			if($feature_ids !="") {
				$sqlPropEntertainment = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE property_features_id IN (".$feature_ids.") AND property_features_group_id='3' ORDER BY property_features_name";
			} else {
				$sqlPropEntertainment = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE  property_features_group_id='3' ORDER BY property_features_name";
			}
		} else {
            $sqlPropEntertainment = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE  property_features_group_id='3' ORDER BY property_features_name";
		}

		$rsPropEntertainment		= $this->dbObj->createRecordset($sqlPropEntertainment);
		if($this->dbObj->getRecordCount($rsPropEntertainment) > 0) {
			$arrEntertainment	= $this->dbObj->fetchAssoc($rsPropEntertainment);
			for($i = 0; $i < count($arrEntertainment); $i++) {
				$entertainment_id 													= $arrEntertainment[$i]['property_features_id'];
				$entertainment_name 												= $arrEntertainment[$i]['property_features_name'];
				$total_property 													= $this->fun_countRefinePropertyByPropertyFacility($entertainment_id, $txtcountryids, $txtareaids, $txtregionids, $txtlocationids,  $txtFromUnixTime, $txtToUnixTime, $txtpropertytypeids, $txtneedsleep, $txtonlybed, $txttotalbed, $txtholidaytypeids, $txtkitchenlinenids, $txtoutsideids, $txtactivitynearbyids, $txtheatingcoolingids, $txtenterainmentids, $txtlocationviewids, $txtserviceids, $txtgeneralids, $parameter);
				$propertyEntertainmentArray[$i]['property_entertainment_id'] 		= $entertainment_id;
				$propertyEntertainmentArray[$i]['property_entertainment_name']		= $entertainment_name;
				$propertyEntertainmentArray[$i]['total_properties']					= $total_property;
			}
			return $propertyEntertainmentArray;
		}
	}
	function fun_getPropertyLocationViewArrayRefineByCriteria($txtcountryids = '', $txtareaids = '', $txtregionids = '', $txtlocationids = '', $txtFromUnixTime = '', $txtToUnixTime = '', $txtpropertytypeids = '', $txtneedsleep = '', $txtonlybed = '', $txttotalbed = '', $txtholidaytypeids = '', $txtkitchenlinenids = '', $txtoutsideids = '', $txtactivitynearbyids = '', $txtheatingcoolingids = '', $txtenterainmentids = '', $txtlocationviewids = '', $txtserviceids = '', $txtgeneralids = '', $featured ='', $latedeal ='', $parameter = '') {
		$property_ids = $this->fun_getPropertyIdsByRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids,  $txtFromUnixTime, $txtToUnixTime, $txtpropertytypeids, $txtneedsleep, $txtonlybed, $txttotalbed, $txtholidaytypeids, $txtkitchenlinenids, $txtoutsideids, $txtactivitynearbyids, $txtheatingcoolingids, $txtenterainmentids, $txtlocationviewids, $txtserviceids, $txtgeneralids, $featured, $latedeal, $parameter);
		$propertyLocationViewArray 	= array();
		if(isset($property_ids) && $property_ids !="") {
			$sql = "SELECT B.feature_ids AS feature_ids
			FROM " . TABLE_PROPERTY . " AS A 
			LEFT JOIN " . TABLE_PROPERTY_FEATURES_RELATIONS . " AS B ON B.property_id = A.property_id 
			WHERE A.active='1' AND A.property_id IN (".$property_ids.")";
			$rs	= $this->dbObj->createRecordset($sql);
			$feature_ids = "";
			if($this->dbObj->getRecordCount($rs) > 0) {
				$arr	= $this->dbObj->fetchAssoc($rs);
				for($i = 0; $i < count($arr); $i++) {
					if($arr[$i]['feature_ids'] != "") {
						$feature_ids .= $arr[$i]['feature_ids'].",";
					}
				}
				$feature_ids = (substr($feature_ids, strlen($feature_ids)-1, strlen($feature_ids)) == ",")?substr($feature_ids, 0, strlen($feature_ids)-1):$feature_ids;
			}
			if($feature_ids !="") {
				$sqlPropLocationView = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE property_features_id IN (".$feature_ids.") AND property_features_group_id='9' ORDER BY property_features_name";
			} else {
				$sqlPropLocationView = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE  property_features_group_id='9' ORDER BY property_features_name";
			}
		} else {
            $sqlPropLocationView = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE  property_features_group_id='9' ORDER BY property_features_name";
		}

		$rsPropLocationView		= $this->dbObj->createRecordset($sqlPropLocationView);
		if($this->dbObj->getRecordCount($rsPropLocationView) > 0) {
			$arrLocationView	= $this->dbObj->fetchAssoc($rsPropLocationView);
			for($i = 0; $i < count($arrLocationView); $i++) {
				$locationview_id 													= $arrLocationView[$i]['property_features_id'];
				$locationview_name 													= $arrLocationView[$i]['property_features_name'];
				$total_property 													= $this->fun_countRefinePropertyByPropertyFacility($locationview_id, $txtcountryids, $txtareaids, $txtregionids, $txtlocationids,  $txtFromUnixTime, $txtToUnixTime, $txtpropertytypeids, $txtneedsleep, $txtonlybed, $txttotalbed, $txtholidaytypeids, $txtkitchenlinenids, $txtoutsideids, $txtactivitynearbyids, $txtheatingcoolingids, $txtenterainmentids, $txtlocationviewids, $txtserviceids, $txtgeneralids, $parameter);
				$propertyLocationViewArray[$i]['property_locationview_id'] 		   	= $locationview_id;
				$propertyLocationViewArray[$i]['property_locationview_name']		= $locationview_name;
				$propertyLocationViewArray[$i]['total_properties']					= $total_property;
			}
			return $propertyLocationViewArray;
		}
	}

	function fun_getPropertyServicesArrayRefineByCriteria($txtcountryids = '', $txtareaids = '', $txtregionids = '', $txtlocationids = '', $txtFromUnixTime = '', $txtToUnixTime = '', $txtpropertytypeids = '', $txtneedsleep = '', $txtonlybed = '', $txttotalbed = '', $txtholidaytypeids = '', $txtkitchenlinenids = '', $txtoutsideids = '', $txtactivitynearbyids = '', $txtheatingcoolingids = '', $txtenterainmentids = '', $txtlocationviewids = '', $txtserviceids = '', $txtgeneralids = '', $featured ='', $latedeal ='', $parameter = '') {
		$property_ids = $this->fun_getPropertyIdsByRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids,  $txtFromUnixTime, $txtToUnixTime, $txtpropertytypeids, $txtneedsleep, $txtonlybed, $txttotalbed, $txtholidaytypeids, $txtkitchenlinenids, $txtoutsideids, $txtactivitynearbyids, $txtheatingcoolingids, $txtenterainmentids, $txtlocationviewids, $txtserviceids, $txtgeneralids, $featured, $latedeal, $parameter);

		$propertyServicesArray 	= array();
		if(isset($property_ids) && $property_ids !="") {
			$sql = "SELECT B.feature_ids AS feature_ids
			FROM " . TABLE_PROPERTY . " AS A 
			LEFT JOIN " . TABLE_PROPERTY_FEATURES_RELATIONS . " AS B ON B.property_id = A.property_id 
			WHERE A.active='1' AND A.property_id IN (".$property_ids.")";
			$rs	= $this->dbObj->createRecordset($sql);
			$feature_ids = "";
			if($this->dbObj->getRecordCount($rs) > 0) {
				$arr	= $this->dbObj->fetchAssoc($rs);
				for($i = 0; $i < count($arr); $i++) {
					if($arr[$i]['feature_ids'] != "") {
						$feature_ids .= $arr[$i]['feature_ids'].",";
					}
				}
				$feature_ids = (substr($feature_ids, strlen($feature_ids)-1, strlen($feature_ids)) == ",")?substr($feature_ids, 0, strlen($feature_ids)-1):$feature_ids;
			}
			if($feature_ids !="") {
				$sqlPropServices = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE property_features_id IN (".$feature_ids.") AND property_features_group_id='8' ORDER BY property_features_name";
			} else {
				$sqlPropServices = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE  property_features_group_id='8' ORDER BY property_features_name";
			}
		} else {
            $sqlPropServices = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE  property_features_group_id='8' ORDER BY property_features_name";
		}

		$rsPropServices		= $this->dbObj->createRecordset($sqlPropServices);
		if($this->dbObj->getRecordCount($rsPropServices) > 0) {
			$arrServices	= $this->dbObj->fetchAssoc($rsPropServices);
			for($i = 0; $i < count($arrServices); $i++) {
				$services_id 													= $arrServices[$i]['property_features_id'];
				$services_name 													= $arrServices[$i]['property_features_name'];
				$total_property 												= $this->fun_countRefinePropertyByPropertyFacility($services_id, $txtcountryids, $txtareaids, $txtregionids, $txtlocationids,  $txtFromUnixTime, $txtToUnixTime, $txtpropertytypeids, $txtneedsleep, $txtonlybed, $txttotalbed, $txtholidaytypeids, $txtkitchenlinenids, $txtoutsideids, $txtactivitynearbyids, $txtheatingcoolingids, $txtenterainmentids, $txtlocationviewids, $txtserviceids, $txtgeneralids, $parameter);
				$propertyServicesArray[$i]['property_services_id'] 		      	= $services_id;
				$propertyServicesArray[$i]['property_services_name']			= $services_name;
				$propertyServicesArray[$i]['total_properties']					= $total_property;
			}
			return $propertyServicesArray;
		}
	}
	function fun_getPropertyGeneralArrayRefineByCriteria($txtcountryids = '', $txtareaids = '', $txtregionids = '', $txtlocationids = '', $txtFromUnixTime = '', $txtToUnixTime = '', $txtpropertytypeids = '', $txtneedsleep = '', $txtonlybed = '', $txttotalbed = '', $txtholidaytypeids = '', $txtkitchenlinenids = '', $txtoutsideids = '', $txtactivitynearbyids = '', $txtheatingcoolingids = '', $txtenterainmentids = '', $txtlocationviewids = '', $txtserviceids = '', $txtgeneralids = '', $featured ='', $latedeal ='', $parameter = '') {
		$property_ids = $this->fun_getPropertyIdsByRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids,  $txtFromUnixTime, $txtToUnixTime, $txtpropertytypeids, $txtneedsleep, $txtonlybed, $txttotalbed, $txtholidaytypeids, $txtkitchenlinenids, $txtoutsideids, $txtactivitynearbyids, $txtheatingcoolingids, $txtenterainmentids, $txtlocationviewids, $txtserviceids, $txtgeneralids, $featured, $latedeal, $parameter);
		$propertyGeneralArray 	= array();
		if(isset($property_ids) && $property_ids !="") {
			$sql = "SELECT B.feature_ids AS feature_ids
			FROM " . TABLE_PROPERTY . " AS A 
			LEFT JOIN " . TABLE_PROPERTY_FEATURES_RELATIONS . " AS B ON B.property_id = A.property_id 
			WHERE A.active='1' AND A.property_id IN (".$property_ids.")";
			$rs	= $this->dbObj->createRecordset($sql);
			$feature_ids = "";
			if($this->dbObj->getRecordCount($rs) > 0) {
				$arr	= $this->dbObj->fetchAssoc($rs);
				for($i = 0; $i < count($arr); $i++) {
					if($arr[$i]['feature_ids'] != "") {
						$feature_ids .= $arr[$i]['feature_ids'].",";
					}
				}
				$feature_ids = (substr($feature_ids, strlen($feature_ids)-1, strlen($feature_ids)) == ",")?substr($feature_ids, 0, strlen($feature_ids)-1):$feature_ids;
			}
			if($feature_ids !="") {
				$sqlPropGeneral = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE property_features_id IN (".$feature_ids.") AND property_features_group_id='5' ORDER BY property_features_name";
			} else {
				$sqlPropGeneral = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE  property_features_group_id='5' ORDER BY property_features_name";
			}
		} else {
            $sqlPropGeneral = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE  property_features_group_id='5' ORDER BY property_features_name";
		}

		$rsPropGeneral		= $this->dbObj->createRecordset($sqlPropGeneral);
		if($this->dbObj->getRecordCount($rsPropGeneral) > 0) {
			$arrGeneral	= $this->dbObj->fetchAssoc($rsPropGeneral);
			for($i = 0; $i < count($arrGeneral); $i++) {
				$general_id 													= $arrGeneral[$i]['property_features_id'];
				$general_name 													= $arrGeneral[$i]['property_features_name'];
				$total_property 												= $this->fun_countRefinePropertyByPropertyFacility($general_id, $txtcountryids, $txtareaids, $txtregionids, $txtlocationids,  $txtFromUnixTime, $txtToUnixTime, $txtpropertytypeids, $txtneedsleep, $txtonlybed, $txttotalbed, $txtholidaytypeids, $txtkitchenlinenids, $txtoutsideids, $txtactivitynearbyids, $txtheatingcoolingids, $txtenterainmentids, $txtlocationviewids, $txtserviceids, $txtgeneralids, $parameter);
				$propertyGeneralArray[$i]['property_general_id'] 				= $general_id;
				$propertyGeneralArray[$i]['property_general_name']	            = $general_name;
				$propertyGeneralArray[$i]['total_properties']					= $total_property;
			}
			return $propertyGeneralArray;
		}
	}

// MC Ver 2.0 Function : End Here

	// Function for creating array for property_type along with total no. of actice property
	function fun_getPropertyFacilityArrayRefineByCriteria($txtcountryids = '', $txtareaids = '', $txtregionids = '', $txtlocationids = '', $txtFromUnixTime = '', $txtToUnixTime = '', $txtpropertytypeids = '', $txtneedsleep = '', $txtonlybed = '', $txttotalbed = '', $txtholidaytypeids = '', $txtkitchenlinenids = '', $txtoutsideids = '', $txtactivitynearbyids = '', $txtheatingcoolingids = '', $txtenterainmentids = '', $txtlocationviewids = '', $txtserviceids = '', $txtgeneralids = '', $parameter = '') {
		$property_ids = $this->fun_getPropertyIdsByRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids,  $txtFromUnixTime, $txtToUnixTime, $txtpropertytypeids, $txtneedsleep, $txtonlybed, $txttotalbed, $txtholidaytypeids, $txtkitchenlinenids, $txtoutsideids, $txtactivitynearbyids, $txtheatingcoolingids, $txtenterainmentids, $txtlocationviewids, $txtserviceids, $txtgeneralids, $parameter);
		$propertyFacilityArray 	= array();
		if(isset($property_ids) && $property_ids !="") {
			$sql = "SELECT B.feature_ids AS feature_ids
			FROM " . TABLE_PROPERTY . " AS A 
			LEFT JOIN " . TABLE_PROPERTY_FEATURES_RELATIONS . " AS B ON B.property_id = A.property_id 
			WHERE A.active='1' AND A.property_id IN (".$property_ids.")";
			$rs	= $this->dbObj->createRecordset($sql);
			$feature_ids = "";
			if($this->dbObj->getRecordCount($rs) > 0) {
				$arr	= $this->dbObj->fetchAssoc($rs);
				for($i = 0; $i < count($arr); $i++) {
					if($arr[$i]['feature_ids'] != "") {
						$feature_ids .= $arr[$i]['feature_ids'].",";
					}
				}
				$feature_ids = (substr($feature_ids, strlen($feature_ids)-1, strlen($feature_ids)) == ",")?substr($feature_ids, 0, strlen($feature_ids)-1):$feature_ids;
			}
			if($feature_ids !="") {
				$sqlPropFacility = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " WHERE property_features_id IN (".$feature_ids.") ORDER BY property_features_name";
			} else {
				$sqlPropFacility = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " ORDER BY property_features_name";
			}
		} else {
            $sqlPropFacility = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " ORDER BY property_features_name";
		}

		$rsPropFacility		= $this->dbObj->createRecordset($sqlPropFacility);
		if($this->dbObj->getRecordCount($rsPropFacility) > 0) {
			$arrFacility	= $this->dbObj->fetchAssoc($rsPropFacility);
			for($i = 0; $i < count($arrFacility); $i++) {
				$facility_id 											= $arrFacility[$i]['property_features_id'];
				$facility_name 											= $arrFacility[$i]['property_features_name'];
				$total_property 										= $this->fun_countRefinePropertyByPropertyFacility($facility_id, $txtcountryids, $txtareaids, $txtregionids, $txtlocationids,  $txtFromUnixTime, $txtToUnixTime, $txtpropertytypeids, $txtneedsleep, $txtonlybed, $txttotalbed, $txtholidaytypeids, $txtkitchenlinenids, $txtoutsideids, $txtactivitynearbyids, $txtheatingcoolingids, $txtenterainmentids, $txtlocationviewids, $txtserviceids, $txtgeneralids, $parameter);
				$propertyFacilityArray[$i]['property_facility_id'] 		= $facility_id;
				$propertyFacilityArray[$i]['property_facility_name']	= $facility_name;
				$propertyFacilityArray[$i]['total_properties']			= $total_property;
			}
			return $propertyFacilityArray;
		}
	}

	function fun_verifyPropertyByPropertyFacility($property_id, $property_facility_id = '' ) {
		if ( $property_id == '' || $property_facility_id == '' ) {
			return false;
		} else {
			$sql = "SELECT COUNT(*) total_result 
			FROM  " . TABLE_PROPERTY . " AS A
			INNER JOIN " . TABLE_PROPERTY_FEATURES_RELATIONS . " AS B ON B.property_id = A.property_id
			WHERE ((B.feature_ids like '%,".$property_facility_id .",%') OR (B.feature_ids like '".$property_facility_id .",%') OR (B.feature_ids like '%,".$property_facility_id ."')) AND A.property_id = '".$property_id."' AND A.active='1'";
			$rs 	= $this->dbObj->createRecordset($sql);
			$arr 	= $this->dbObj->fetchAssoc($rs);
			$total_result = $arr[0]['total_result'];
			if($total_result > 0){
                return true;
			} else {
                return false;
			}
		}
	}

	// Function for creating array for property_type along with total no. of actice property
	function fun_getRefinePropertyFacilityArrayWithTotalProp($txtcountryids = '', $txtareaids = '', $txtregionids = '', $txtlocationids = '',  $txtFromUnixTime = '', $txtToUnixTime = '', $txtpropertytypeids = '', $txtneedsleep = '', $txtonlybed = '', $txttotalbed = '', $txtholidaytypeids = '', $txtkitchenlinenids = '', $txtoutsideids = '', $txtactivitynearbyids = '', $txtheatingcoolingids = '', $txtenterainmentids = '', $txtlocationviewids = '', $txtserviceids = '', $txtgeneralids = '', $parameter = ''){		
		$propertyFacilityArray 	= array();		
		$sqlPropFacility = "SELECT * FROM " . TABLE_PROPERTY_FEATURES. " ORDER BY property_features_name";
		$rsPropFacility		= $this->dbObj->createRecordset($sqlPropFacility);
		if($this->dbObj->getRecordCount($rsPropFacility) > 0) {
			$arrFacility	= $this->dbObj->fetchAssoc($rsPropFacility);
			for($i = 0; $i < count($arrFacility); $i++) {
				$facility_id 											= $arrFacility[$i]['property_features_id'];
				$facility_name 											= $arrFacility[$i]['property_features_name'];
				$total_property 										= $this->fun_countRefinePropertyByPropertyFacility($facility_id, $txtcountryids, $txtareaids, $txtregionids, $txtlocationids,  $txtFromUnixTime, $txtToUnixTime, $txtpropertytypeids, $txtneedsleep, $txtonlybed, $txttotalbed, $txtholidaytypeids, $txtkitchenlinenids, $txtoutsideids, $txtactivitynearbyids, $txtheatingcoolingids, $txtenterainmentids, $txtlocationviewids, $txtserviceids, $txtgeneralids, $parameter);
				$propertyFacilityArray[$i]['property_facility_id'] 		= $facility_id;
				$propertyFacilityArray[$i]['property_facility_name']	= $facility_name;
				$propertyFacilityArray[$i]['total_properties']			= $total_property;
			}
			return $propertyFacilityArray;
		}
	}

	function fun_countRefinePropertyByPropertyFacility( $property_facility_id = '', $txtcountryids = '', $txtareaids = '', $txtregionids = '', $txtlocationids = '',  $txtFromUnixTime = '', $txtToUnixTime = '', $txtpropertytypeids = '', $txtneedsleep = '', $txtonlybed = '', $txttotalbed = '', $txtholidaytypeids = '', $txtkitchenlinenids = '', $txtoutsideids = '', $txtactivitynearbyids = '', $txtheatingcoolingids = '', $txtenterainmentids = '', $txtlocationviewids = '', $txtserviceids = '', $txtgeneralids = '', $parameter = '') {
		if ( $property_facility_id == '' ) {
			return false;
		} else {
			$sql = "SELECT COUNT(*) total_result 
			FROM  " . TABLE_PROPERTY . " AS A
			INNER JOIN " . TABLE_PROPERTY_FEATURES_RELATIONS . " AS B ON B.property_id = A.property_id
			WHERE ((B.feature_ids like '%,".$property_facility_id .",%') OR (B.feature_ids like '".$property_facility_id .",%') OR (B.feature_ids like '%,".$property_facility_id ."')) AND A.active='1'";

			$rs = $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);
				$refine_prop = $this->fun_countRefineProperty($txtcountryids, $txtareaids, $txtregionids, $txtlocationids,  $txtFromUnixTime, $txtToUnixTime, $txtpropertytypeids, $txtneedsleep, $txtonlybed, $txttotalbed, $txtholidaytypeids, $txtkitchenlinenids, $txtoutsideids, $txtactivitynearbyids, $txtheatingcoolingids, $txtenterainmentids, $txtlocationviewids, $txtserviceids, $txtgeneralids, $parameter);
				if(((int)$arr[0]['total_result'] > (int)$refine_prop) && ($refine_prop > 0) ) {
					$total_result = $refine_prop;
				} else {
					$total_result = $arr[0]['total_result'];
				}
			}
			else{
				$total_result = 0;
			}
			return $total_result;
		}
	}

	// Function to get property feature array
	function fun_getPropertyFeaturesArr($property_id = ''){	
		if($property_id == ''){
			return false;
		} else {
			if(($features_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_FEATURES_RELATIONS , " WHERE property_id='".$property_id."'")) && (is_array($features_array))){
				return $features_array;
			} else {
				return false;
			}
		}
	}

	// Check property Feature by feature name if exist then return true otherwise return false
	function fun_getPropertyFeatureNameArr($property_id){
		if($property_id == ''){
			return false;
		}
		else{
			if(($feature_relation_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_FEATURES_RELATIONS , " WHERE property_id='".$property_id."'")) && (is_array($feature_relation_array))){
				$feature_ids	= $feature_relation_array[0]['feature_ids'];
				
				if($feature_ids != "") {
					$sql 	= "SELECT A.* FROM  " . TABLE_PROPERTY_FEATURES . " AS A WHERE (A.property_features_id IN (".$feature_ids."))";
					$rs 	= $this->dbObj->createRecordset($sql);
					$arr 	= $this->dbObj->fetchAssoc($rs);
					return $arr;
				} else {
					return false;
				}
			}
		}
	}

	// Function for creating property Need To Know section
	function fun_createCompareProperties($property_arr) {
		if(is_array($property_arr) && count($property_arr) > 1) {
			$total_properties = (count($property_arr) <= 4)?count($property_arr):4;
			$showAmenities 		= false;

			$property_ids 		= implode(",", $property_arr);
			$sql 				= "SELECT DISTINCT(feature_ids) FROM " . TABLE_PROPERTY_FEATURES_RELATIONS . " WHERE property_id IN (" .$property_ids. ")";
			$rs 				= $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0) {
				$showAmenities 		= true;
				$amenities_arr 		= array();
				$arr 				= $this->dbObj->fetchAssoc($rs);
				foreach($arr as $key=>$value) {
					array_push($amenities_arr, $value['feature_ids']);
				}
				$amenities_ids 		= implode(",", $amenities_arr);

				$sqlAmenities 		= "SELECT A.* FROM  " . TABLE_PROPERTY_FEATURES . " AS A WHERE (A.property_features_id IN (".$amenities_ids.")) AND  A.property_features_group_id NOT IN (1,2,5,7,9,10) ORDER BY A.property_features_group_id, A.property_features_name ";
				$rsAmenities 		= $this->dbObj->createRecordset($sqlAmenities);
				if($this->dbObj->getRecordCount($rsAmenities) > 0) {
					$arrAmenities	= $this->dbObj->fetchAssoc($rsAmenities);
				}
			}
			
			$strHTML 	= '';
			$strHTML 	.= '<table border="0" cellspacing="0" cellpadding="0" width="100%">';
			$strHTML 	.= '<tr>';
			$strHTML 	.= '<tr>';
			$strHTML 	.= '<td height="40" valign="top" class="pad-rgt0 pad-btm10">';
			$strHTML 	.= '<div class="border">';
			$strHTML 	.= '<h1 class="page-headingNew inline">Comparing '.$total_properties.' Properties</h1>';
			$strHTML 	.= '</div>';
			$strHTML 	.= '</td>';
			$strHTML 	.= '</tr>';
			$strHTML 	.= '</table>';

			$strHTML 	.= '<table width="100%" height="1020" border="0" cellspacing="0" cellpadding="0" class="font12">';
			$strHTML 	.= '<tr>';
			$strHTML 	.= '<td valign="top" class="pad-rgt10" width="180">';
			$strHTML 	.= '<div>';
			$strHTML 	.= '<div style="width:180px; height:200px;">&nbsp;</div>';
			$strHTML 	.= '<div>';
			$strHTML 	.= '<div style="height:22px;"><strong>Property Details</strong></div>';
			$strHTML 	.= '<div style="height:23px; background-color:#f0f5f8; padding-left:5px;">Rental rate</div>';
			$strHTML 	.= '<div style="height:23px; background-color:#ffffff; padding-left:5px;">Location</div>';
			$strHTML 	.= '<div style="height:23px; background-color:#f0f5f8; padding-left:5px;">Property type</div>';
			$strHTML 	.= '<div style="height:23px; background-color:#ffffff; padding-left:5px;">Bedrooms</div>';
			$strHTML 	.= '<div style="height:23px; background-color:#f0f5f8; padding-left:5px;">Bathrooms</div>';
			$strHTML 	.= '<div style="height:23px; background-color:#ffffff; padding-left:5px; border-bottom:1px solid #99CCFF;">Sleeps</div>';
			$strHTML 	.= '<div style="height:23px; padding-top:15px;"><strong>Amenities</strong></div>';
			for($i=0; $i < count($arrAmenities); $i++) {
				if($i%2 != 0) 
					$strHTML 	.= '<div style="height:23px; background-color:#ffffff; padding-left:5px;">'.ucfirst($arrAmenities[$i]['property_features_name']).'</div>';
				else 
					$strHTML 	.= '<div style="height:23px; background-color:#f0f5f8; padding-left:5px;">'.ucfirst($arrAmenities[$i]['property_features_name']).'</div>';
			}
			$strHTML 	.= '</div>';
			$strHTML 	.= '</div>';
			$strHTML 	.= '</td>';

			for($i = 0; $i < $total_properties; $i++) {
				$property_id 		= $property_arr[$i];
				$propertyInfo 		= $this->fun_getPropertyInfo($property_id);
				$property_name 		= ucfirst($propertyInfo['property_name']);
				$property_type_name = $this->fun_getPropertyTypeNameById($propertyInfo['property_type']);				
				$total_beds			= ($propertyInfo['total_beds'] != '')?$propertyInfo['total_beds']:'0';
				$total_bathrooms	= ($propertyInfo['total_bathrooms'] != '')?$propertyInfo['total_bathrooms']:'0';
				$scomfort_beds		= ($propertyInfo['scomfort_beds'] != '')?$propertyInfo['scomfort_beds']:'0';

				// Image details
				$propertyMImgInfo	= $this->fun_getPropertyMainThumb($property_id);
				$propMImg 			= $propertyMImgInfo[0]['photo_thumb'];
				$propMImgCap 		= $propertyMImgInfo[0]['photo_caption'];

				$propPriceInfoArr	= $this->fun_getPropertyPriceFromInfoArr($property_id);
				if(is_array($propPriceInfoArr) && (count($propPriceInfoArr) > 0)){
					$users_currency_symbol	= $this->fun_findPropertyCurrencySymbol($property_id);
					if($propPriceInfoArr['min_per_night_price'] > 0 && $propPriceInfoArr['max_per_night_price'] > 0 && $propPriceInfoArr['min_per_night_price'] != $propPriceInfoArr['max_per_night_price']) {
						$min_per_night_price 	= number_format($propPriceInfoArr['min_per_night_price']);
						$max_per_night_price 	= number_format($propPriceInfoArr['max_per_night_price']);
						$show_price 			= "From <span>".$users_currency_symbol."</span><span>".$min_per_night_price."</span> per night";
					} else if($propPriceInfoArr['min_per_week_price'] > 0 && $propPriceInfoArr['max_per_week_price'] > 0 && $propPriceInfoArr['min_per_week_price'] != $propPriceInfoArr['max_per_week_price']) {
						$min_per_week_price 	= number_format($propPriceInfoArr['min_per_week_price']);
						$show_price 			= "From <span>".$users_currency_symbol."</span><span>".$min_per_week_price."</span> per week";
					} else if($propPriceInfoArr['min_per_night_price'] > 0) {
						$min_per_night_price 	= number_format($propPriceInfoArr['min_per_night_price']);
						$show_price 			= "From <span>".$users_currency_symbol."</span><span>".$min_per_night_price."</span> per night";
					} else if($propPriceInfoArr['min_per_week_price'] > 0) {
						$min_per_week_price 	= number_format($propPriceInfoArr['min_per_week_price']);
						$show_price 			= "From <span>".$users_currency_symbol."</span><span>".$min_per_week_price."</span> per week";
					} else {
						$show_price 			= "<br />";
					}
				} else {
					$show_price 		= "<br />";
				}

				$propLocInfoArr 	= $this->fun_getPropertyLocInfoArr($property_id);

				$fr_url = $this->fun_getPropertyFriendlyLink($property_id);
				if(isset($fr_url) && $fr_url != "") {
					$property_link 		= SITE_URL."vacation-rentals/".strtolower($fr_url);
				} else {
					if(isset($propLocInfoArr['location_name']) && $propLocInfoArr['location_name'] != "") {
						$property_link = SITE_URL."vacation-rentals/in.".str_replace(" ", "-", strtolower($propLocInfoArr['location_name']))."/".fill_zero_left($property_id, "0", (6-strlen($property_id)));
					} else {
						$property_link = SITE_URL."vacation-rentals/in.".str_replace(" ", "-", strtolower($propLocInfoArr['region_name']))."/".fill_zero_left($property_id, "0", (6-strlen($property_id)));
					}
				}

				if(isset($propLocInfoArr['location_name']) && $propLocInfoArr['location_name'] != "") {
					$property_loc = ucfirst($propLocInfoArr['location_name']);
				} else if(isset($propLocInfoArr['region_name']) && $propLocInfoArr['region_name'] != ""){
					$property_loc = ucfirst($propLocInfoArr['region_name']);
				} else if(isset($propLocInfoArr['area_name']) && $propLocInfoArr['area_name'] != ""){
					$property_loc = ucfirst($propLocInfoArr['area_name']);
				} else if(isset($propLocInfoArr['countries_name']) && $propLocInfoArr['countries_name'] != ""){
					$property_loc = ucfirst($propLocInfoArr['countries_name']);
				} else {
					$property_loc = "&nbsp;";
				}

				$strHTML 	.= '<td valign="top" style="background:url('.SITE_IMAGES.'compare-listing-card.png) no-repeat;" width="170px">';
				$strHTML 	.= '<div class="remove-compare" onclick="removeCompare('.$property_id.');">Remove from compare</div>';
				$strHTML 	.= '<div class="photo-compare"><a href="'.$property_link.'"><img src="'.PROPERTY_IMAGES_THUMB168x126_PATH.$propMImg.'" title="'.$propMImgCap.'" width="133" height="100" alt="'.$propMImgCap.'"/></a></div>';
				$strHTML 	.= '<div class="summary-compare" style="height:53px;"><a href="'.$property_link.'" class="blue-link">'.$property_name.'</a></div>';
				$strHTML 	.= '<div class="propertyid-compare">ID 224719</div>';
				$strHTML 	.= '<div class="rentaldetail-compare" style="background-color:#f0f5f8;">'.$show_price.'</div>';
				$strHTML 	.= '<div class="detail-compare">'.$property_loc.'</div>';
				$strHTML 	.= '<div class="detail-compare" style="background-color:#f0f5f8;">'.$property_type_name.'</div>';
				$strHTML 	.= '<div class="detail-compare">'.$total_beds.'</div>';
				$strHTML 	.= '<div class="detail-compare" style="background-color:#f0f5f8;">'.$total_bathrooms.'</div>';
				$strHTML 	.= '<div class="detail-compare" style="border-bottom:1px solid #99CCFF;">'.$scomfort_beds.'</div>';
				$strHTML 	.= '<div class="detail-compare" style="height:33px;">&nbsp;</div>';

				for($j=0; $j < count($arrAmenities); $j++) {
					if($this->fun_verifyPropertyByPropertyFacility($property_id, $arrAmenities[$j]['property_features_id']) == true) {
						$strTick = "<img src=\"".SITE_IMAGES."Tick.gif\" />";
					} else {
						$strTick = "&nbsp;";
					}
					if($j%2 != 0)


						$strHTML 	.= '<div style="height:18px;vertical-align:middle;padding-left:5px;padding-top:5px;margin-right:10px;padding-bottom:0px;">'.$strTick.'</div>';
					else
						$strHTML 	.= '<div style="height:18px; background-color:#f0f5f8;vertical-align:middle;padding-left:5px;padding-top:5px;margin-right:10px;padding-bottom:0px;">'.$strTick.'</div>';
				}

				$strHTML 	.= '<div class="clear"></div>';
				$strHTML 	.= '</td>';
			}

			$strHTML 	.= '<td>&nbsp;</td>';
			$strHTML 	.= '</tr>';
			$strHTML 	.= '</table>';


		} else {
			$strHTML 	= '';
			$strHTML 	.= '<table border="0" cellspacing="0" cellpadding="0" width="100%">';
			$strHTML 	.= '<tr>';
			$strHTML 	.= '<tr>';
			$strHTML 	.= '<td height="40" valign="top" class="pad-rgt0 pad-btm10">';
			$strHTML 	.= '<div class="border">';

			$strHTML 	.= '<h1 class="page-headingNew inline">Comparing 0 Properties</h1>';
			$strHTML 	.= '</div>';
			$strHTML 	.= '</td>';
			$strHTML 	.= '</tr>';
			$strHTML 	.= '<tr>';
			$strHTML 	.= '<td valign="top" class="pad-lft10 pad-top10">';
			$strHTML 	.= '<span class="font14">We are sorry but no properties were found that match your selections.</span>';
			$strHTML 	.= '</td>';
			$strHTML 	.= '</tr>';
			$strHTML 	.= '<tr>';
			$strHTML 	.= '<td valign="top" class="pad-lft10 pad-top10">';
			$strHTML 	.= '<span class="font12">Please <a href="'.SITE_URL.'accommodation" class="blue-link">go to the search results page</a> and check that properties were selected for comparison.</span>';
			$strHTML 	.= '</td>';
			$strHTML 	.= '</tr>';
			$strHTML 	.= '</table>';
		}

/*
		$sqlFeaturesIds 	= "SELECT feature_ids FROM " . TABLE_PROPERTY_FEATURES_RELATIONS . " WHERE property_id='".$property_id."'";
		$rsFeaturesIds 	= $this->dbObj->createRecordset($sqlFeaturesIds);
		$arrFeaturesIds 	= $this->dbObj->fetchAssoc($rsFeaturesIds);
		foreach($arrFeaturesIds as $val){
			$featuresIdsArr = explode(",", $val['feature_ids']);
		}
		$sql = "SELECT * FROM " . TABLE_PROPERTY_FEATURES . " ORDER BY property_features_name";
		$rs = $this->dbObj->createRecordset($sql);
        $total_features	= $this->dbObj->getRecordCount($rs);
		if($total_features > 0){
			$arr = $this->dbObj->fetchAssoc($rs);
            if($total_features > 0) {
                if($total_features % 2 == 0) {
                    //even condition
                    $first_cell_num = $total_features - ((int)($total_features)/2);
                } else {
                    //odd condition
                    $first_cell_num = $total_features - ((int)($total_features-1)/2);
                }
            }

            echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" class=\"font12\">";
            echo "<tr>";
            echo "<td width=\"47%\" valign=\"top\">";
            echo "<table width=\"190\" cellpadding=\"0\" cellspacing=\"0\">";
            echo "<tr><td class=\"owner-headings1 pad-top2 pad-btm8 dash-btm\">Need to know</td></tr>";
			for($i = 0; $i < $first_cell_num; $i++) {
				$txtTxt = ucfirst($arr[$i]['property_features_name']);
				if($txtTxt == "Are beach towels provided?") $txtTxt = "Beach towels provided";
				if($txtTxt == "Are towels provided?") $txtTxt = "Towels provided";
				if($txtTxt == "Is linen provided?") $txtTxt = "Linen provided";
				if(is_array($featuresIdsArr) && in_array($arr[$i]['property_features_id'], $featuresIdsArr)) {
					echo "<tr class=\"Summary\"><td><p class=\"SummaryTick\">" .$txtTxt. "</p></td></tr>";
				} else {
					echo "<tr class=\"Summary\"><td><p class=\"SummaryCross\">" .$txtTxt. "</p></td></tr>";
				}
			}
            echo "</table>";
            echo "</td>";
            echo "<td width=\"6%\" valign=\"top\"><img src=\"".SITE_IMAGES."spacer.gif\" alt=\"Summary\" width=\"28\" height=\"30\" /></td>";
            echo "<td width=\"47%\" valign=\"top\">";
            echo "<table width=\"190\" cellpadding=\"0\" cellspacing=\"0\">";
            echo "<tr><td class=\"owner-headings1 pad-top2 pad-btm8 dash-btm\">&nbsp;</td></tr>";
			for($j = $first_cell_num; $j < $total_features; $j++) {
				$txtTxt = ucfirst($arr[$j]['property_features_name']);
				if($txtTxt == "Are beach towels provided?") $txtTxt = "Beach towels provided";
				if($txtTxt == "Are towels provided?") $txtTxt = "Towels provided";
				if($txtTxt == "Is linen provided?") $txtTxt = "Linen provided";

				if(is_array($featuresIdsArr) && in_array($arr[$j]['property_features_id'], $featuresIdsArr)) {
					echo "<tr class=\"Summary\"><td><p class=\"SummaryTick\">" .$txtTxt. "</p></td></tr>";
				} else {
					echo "<tr class=\"Summary\"><td><p class=\"SummaryCross\">" .$txtTxt. "</p></td></tr>";
				}
			}
            echo "</table>";
            echo "</td>";
            echo "</tr>";
            echo "</table>";
		} else {
			echo "&nbsp;";
		}
*/

		echo $strHTML;
	}


	// Function for creating property Need To Know section
	function fun_createPropertyNeedToKnow($property_id = ''){		
		$sqlFeaturesIds 	= "SELECT feature_ids FROM " . TABLE_PROPERTY_FEATURES_RELATIONS . " WHERE property_id='".$property_id."'";
		$rsFeaturesIds 	= $this->dbObj->createRecordset($sqlFeaturesIds);
		$arrFeaturesIds 	= $this->dbObj->fetchAssoc($rsFeaturesIds);
		foreach($arrFeaturesIds as $val){
			$featuresIdsArr = explode(",", $val['feature_ids']);
		}
		$sql = "SELECT * FROM " . TABLE_PROPERTY_FEATURES . " ORDER BY property_features_name";
		$rs = $this->dbObj->createRecordset($sql);
        $total_features	= $this->dbObj->getRecordCount($rs);
		if($total_features > 0){
			$arr = $this->dbObj->fetchAssoc($rs);
            if($total_features > 0) {
                if($total_features % 2 == 0) {
                    //even condition
                    $first_cell_num = $total_features - ((int)($total_features)/2);
                } else {
                    //odd condition
                    $first_cell_num = $total_features - ((int)($total_features-1)/2);
                }
            }

            echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" class=\"font12\">";
            echo "<tr>";
            echo "<td width=\"47%\" valign=\"top\">";
            echo "<table width=\"190\" cellpadding=\"0\" cellspacing=\"0\">";
            echo "<tr><td class=\"owner-headings1 pad-top2 pad-btm8 dash-btm\">Need to know</td></tr>";
			for($i = 0; $i < $first_cell_num; $i++) {
				$txtTxt = ucfirst($arr[$i]['property_features_name']);
				if($txtTxt == "Are beach towels provided?") $txtTxt = "Beach towels provided";
				if($txtTxt == "Are towels provided?") $txtTxt = "Towels provided";
				if($txtTxt == "Is linen provided?") $txtTxt = "Linen provided";
				if(is_array($featuresIdsArr) && in_array($arr[$i]['property_features_id'], $featuresIdsArr)){
					echo "<tr class=\"Summary\"><td><p class=\"SummaryTick\">" .$txtTxt. "</p></td></tr>";
				} 
			}
            echo "</table>";
            echo "</td>";
            echo "<td width=\"6%\" valign=\"top\"><img src=\"".SITE_IMAGES."spacer.gif\" alt=\"Summary\" width=\"28\" height=\"30\" /></td>";
            echo "<td width=\"47%\" valign=\"top\">";
            echo "<table width=\"190\" cellpadding=\"0\" cellspacing=\"0\">";
            echo "<tr><td class=\"owner-headings1 pad-top2 pad-btm8 dash-btm\">&nbsp;</td></tr>";
			for($j = $first_cell_num; $j < $total_features; $j++) {
				$txtTxt = ucfirst($arr[$j]['property_features_name']);
				if($txtTxt == "Are beach towels provided?") $txtTxt = "Beach towels provided";
				if($txtTxt == "Are towels provided?") $txtTxt = "Towels provided";
				if($txtTxt == "Is linen provided?") $txtTxt = "Linen provided";

				if(is_array($featuresIdsArr) && in_array($arr[$j]['property_features_id'], $featuresIdsArr)) {
					echo "<tr class=\"Summary\"><td><p class=\"SummaryTick\">" .$txtTxt. "</p></td></tr>";
				} 
			}
            echo "</table>";
            echo "</td>";
            echo "</tr>";
            echo "</table>";
		} else {
			echo "&nbsp;";
		}
	}

	// Check property Feature by feature name if exist then return true otherwise return false
	function fun_createPropertyFeatureByName($property_id='', $feature_name=''){
		if($property_id == '' || $feature_name ==''){
			return false;
		}
		else{
			if(($feature_relation_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_FEATURES_RELATIONS , " WHERE property_id='".$property_id."'")) && (is_array($feature_relation_array))){
				$feature_ids	= $feature_relation_array[0]['feature_ids'];
				
				if($feature_ids != "") {
					$sql = "SELECT A.* 
					FROM  " . TABLE_PROPERTY_FEATURES . " AS A 
					WHERE (A.property_features_name LIKE '".$feature_name."') AND (A.property_features_id IN (".$feature_ids."))";
					$rs = $this->dbObj->createRecordset($sql);
					if($this->dbObj->getRecordCount($rs) > 0){
						return true;
					}
					else{
						return false;
					}
				} else {
					return false;
				}
			}
		}
	}





	// Function for creating property check list : type of people section
	function fun_createPropertyCheckListAmenitiesFeatures($property_id = ''){		
		$sqlCheckListAmenitiesFeaturesIds 	= "SELECT amenities_type FROM " . TABLE_PROPERTY_CHECKLIST_SETTINGS . " WHERE property_id='".$property_id."'";
		$rsCheckListAmenitiesFeaturesIds 		= $this->dbObj->createRecordset($sqlCheckListAmenitiesFeaturesIds);
		$arrCheckListAmenitiesFeaturesIds 	= $this->dbObj->fetchAssoc($rsCheckListAmenitiesFeaturesIds);
		$checkListAmenitiesFeaturesIds 		= "";

		foreach($arrCheckListAmenitiesFeaturesIds	 as $val){
			$checkListAmenitiesFeaturesIds = $val['amenities_type'];
		}

		$checkListAmenitiesFeaturesIdsArr = explode(",", $checkListAmenitiesFeaturesIds);
		
		$sql = "SELECT * FROM " . TABLE_PROPERTY_FEATURES . " ORDER BY property_features_name";
		echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
		echo "<tr>";
		$rs = $this->dbObj->createRecordset($sql);
		$arr = $this->dbObj->fetchAssoc($rs);
		$i = 0;
		foreach($arr as $value){
			if($i%3 == 0){
				echo "</tr><tr>";
			}
			if(array_search($value['property_features_id'], $checkListAmenitiesFeaturesIdsArr) === false){
				$checked = "";
			}
			else{
				$checked = "checked";
			}
			echo "<td width=\"24\" valign=\"top\" class=\"pad-btm5 pad-top3\"><input type=\"checkbox\" name='txtAmenitiesFeatures[]' value='". $value['property_features_id'] ."' class=\"RegFormChkBox\" " .$checked. "></td>";
			echo "<td width=\"260\" valign=\"top\" class=\"pad-btm5\"> " .ucwords($value['property_features_name']). " </td>";

			$i++;
		}
		echo "</table>";
	}

	// Function for creating property check list Review: type of accomadation section
	function fun_createPropertyCheckListAmenitiesFeaturesReview($property_id = ''){		
		$sqlCheckListAmenitiesFeaturesIds 	= "SELECT amenities_type FROM " . TABLE_PROPERTY_CHECKLIST_SETTINGS . " WHERE property_id='".$property_id."'";
		$rsCheckListAmenitiesFeaturesIds 	= $this->dbObj->createRecordset($sqlCheckListAmenitiesFeaturesIds);
		$arrCheckListAmenitiesFeaturesIds 	= $this->dbObj->fetchAssoc($rsCheckListAmenitiesFeaturesIds);
		$checkListAmenitiesFeaturesIds = "";

		foreach($arrCheckListAmenitiesFeaturesIds as $val){
			$checkListAmenitiesFeaturesIds = $val['amenities_type'];
		}

		echo "<table width=\"298\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
		echo "<tr>";
		echo "<td valign=\"top\" class=\"chklistQ dash-btm\">Amenities and Features</td>";
		echo "<td align=\"right\" valign=\"top\" class=\"dash-btm\"><a href=\"javascript:open_div('ChecklistSubTab', '4');void(0);\" class=\"Update\">Edit</a></td>";
		echo "</tr>";

		if($checkListAmenitiesFeaturesIds !=""){
			$sql = "SELECT * FROM " . TABLE_PROPERTY_FEATURES . " WHERE property_features_id IN (".$checkListAmenitiesFeaturesIds.") ORDER BY property_features_name";
			$rs = $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);
				$i = 0;
				foreach($arr as $value){
					if($value['property_features_name'] == "Is linen provided?") {
						$property_features_name = "linen provided";
					} else if($value['property_features_name'] == "Are towels provided?") {
						$property_features_name = "towels provided";
					} else if($value['property_features_name'] == "Are beach towels provided?") {
						$property_features_name = "beach towels provided";
					} else {
						$property_features_name = $value['property_features_name'];
					}
				
					if($i%1 == 0){
						echo "</tr><tr>";
					}
					echo "<td colspan=\"2\" valign=\"top\" class=\"dash-btm\"><p class=\"ChecklistSubTabTick\">" .ucfirst(strtolower($property_features_name)). "</p></td>";
					$i++;
				}
			}
			else{
			echo "<tr>";
			echo "<td colspan=\"2\" valign=\"top\" class=\"dash-btm\"><p class=\"ChecklistSubTabCross\"><span class=\"red\">None selected:</span> <a href=\"javascript:open_div('ChecklistSubTab', '4');void(0);\" class=\"blue-link\">Please select</a></p></td>";
			echo "</tr>";
			}
		}
		else{
		echo "<tr>";
		echo "<td colspan=\"2\" valign=\"top\" class=\"dash-btm\"><p class=\"ChecklistSubTabCross\"><span class=\"red\">None selected:</span> <a href=\"javascript:open_div('ChecklistSubTab', '4');void(0);\" class=\"blue-link\">Please select</a></p></td>";
		echo "</tr>";
		}
		echo "</table>";
	}

	// Function for creating property features section
	function fun_createPropertyFeatures($property_id = ''){		
		$sqlFeaturesIds = "SELECT feature_ids FROM " . TABLE_PROPERTY_FEATURES_RELATIONS . " WHERE property_id='".$property_id."'";
		$rsFeatures = $this->dbObj->createRecordset($sqlFeaturesIds);
		$arrFeatures = $this->dbObj->fetchAssoc($rsFeatures);

		$featureArr = explode(",", $arrFeatures[0]['feature_ids']);

		$sql = "SELECT * FROM " . TABLE_PROPERTY_FEATURES . " WHERE property_features_name NOT IN ('Is linen provided?', 'Are towels provided?', 'Are beach towels provided?') ORDER BY property_features_name";

		$strHTML = "";
		$strHTML .= "\n<table width=\"690\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"font12\"><tbody>\n";
		$strHTML .= "<tr><td width=\"20\">&nbsp;</td><td width=\"240\">&nbsp;</td><td width=\"20\">&nbsp;</td><td width=\"230\">&nbsp;</td><td width=\"20\">&nbsp;</td><td width=\"160\">&nbsp;</td>\n";
		$rs = $this->dbObj->createRecordset($sql);
		$arr = $this->dbObj->fetchAssoc($rs);
		$i = 0;
		foreach($arr as $value){
			if($i%3 == 0){
				$strHTML .= "</tr>\n<tr>";
//				$td_class = "details-240";
			}
/*
			if($i%3 == 1){
				$td_class = "details-230";
			}
			if($i%3 == 2){
				$td_class = "details-160";
			}
*/

			if(array_search($value['property_features_id'], $featureArr) === false){
				$checked = "";
			}
			else{
				$checked = "checked";
			}
			$strHTML .= "<td align=\"left\" valign=\"top\" style=\"padding-bottom:10px;\"><input type=\"checkbox\" name='txtFeatures[]' value='". $value['property_features_id'] ."' class=\"RegFormChkBox\" " .$checked. "></td>\n";
			$strHTML .= "<td align=\"left\" valign=\"top\" style=\"padding-bottom:10px;\"> " .ucwords($value['property_features_name']). " </td>\n";
			$i++;
		}
		$strHTML .= "</tbody></table>\n";
		echo $strHTML;
	}

	// Function for creating property features section
	function fun_createPropertyFacilities4PropertyPrint($property_id){		
		$FeaturesArr 	= $this->fun_getPropertyFeaturesArr($property_id);
		$feature_ids 	= $FeaturesArr[0]['feature_ids'];
		$feature_note 	= $FeaturesArr[0]['feature_notes'];
		if(isset($feature_ids) && $feature_ids != "") {
            $strHTML = "";
			$featureArr = explode(",", $feature_ids);
			$sql 				= "SELECT * FROM " . TABLE_PROPERTY_FEATURES . " WHERE property_features_name NOT IN ('Is linen provided?', 'Are towels provided?', 'Are beach towels provided?') AND property_features_id IN (" .$feature_ids. ") ORDER BY property_features_name";
			$rs 				= $this->dbObj->createRecordset($sql);
			$arr 				= $this->dbObj->fetchAssoc($rs);
			$total_featrures 	= count($arr);

            $strHTML .= "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
            $strHTML .= "<tr>";
            $strHTML .= "<td valign=\"top\" align=\"left\">";
            $strHTML .= "<table width=\"150\" cellspacing=\"0\" cellpadding=\"0\">";
            $strHTML .= "<tr><td><strong>Facilities</strong></td></tr>";

			if($total_featrures > 0) {
				if($total_featrures % 2 == 0) {
					//even condition
					$first_cell_num = $total_featrures - ((int)($total_featrures)/2);
				} else {
					//odd condition
					$first_cell_num = $total_featrures - ((int)($total_featrures-1)/2);
				}
				for($i = 0; $i < $first_cell_num; $i++) {
					$feature_name = $arr[$i]['property_features_name'];
                    $strHTML .= "</tr><tr><td>".ucwords($feature_name)."</td></tr>";
				}
			}
			
            $strHTML .= "</table>";
            $strHTML .= "</td>";
            $strHTML .= "<td valign=\"top\" align=\"left\">";
            $strHTML .= "<table width=\"190\" cellspacing=\"0\" cellpadding=\"0\">";
            $strHTML .= "<tr><td>&nbsp;</td></tr>";
			if($total_featrures > 0) {
				for($j = $first_cell_num; $j < $total_featrures; $j++) {
					$feature_name = $arr[$j]['property_features_name'];
                    $strHTML .= "</tr><tr><td>".ucwords($feature_name)."</td></tr>";
				}
			}
            $strHTML .= "</table>";
            $strHTML .= "</td>";
            $strHTML .= "<td width=\"55%\">&nbsp;</td>";
            $strHTML .= "</tr>";
            $strHTML .= "<tr><td colspan=\"3\">".$feature_note."</td></tr>";
            $strHTML .= "</table>";
			return $strHTML;
		} else {
			return false;
		}
	}

	// Function for creating property "Does it have" section
	function fun_createPropertyDoesItHave($property_id = ''){		
		$sqlFeaturesIds = "SELECT feature_ids FROM " . TABLE_PROPERTY_FEATURES_RELATIONS . " WHERE property_id='".$property_id."'";
		$rsFeatures = $this->dbObj->createRecordset($sqlFeaturesIds);
		$arrFeatures = $this->dbObj->fetchAssoc($rsFeatures);

		$featureArr = explode(",", $arrFeatures[0]['feature_ids']);

		$sql = "SELECT * FROM " . TABLE_PROPERTY_FEATURES . " WHERE property_features_id IN (28,3,29,11,18,30) ORDER BY property_features_name";
		$strHTML = "";
		$strHTML .= "\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"font12\"><tbody>\n";
		$strHTML .= "<tr height=\"2px\"><td width=\"20px\"></td><td width=\"110px\"></td><td width=\"20px\"></td><td></td>\n";
		$rs = $this->dbObj->createRecordset($sql);
		$arr = $this->dbObj->fetchAssoc($rs);
		$i = 0;
		foreach($arr as $value){
			if($i%2 == 0){
				$strHTML .= "</tr>\n<tr>";
			}
			if(array_search($value['property_features_id'], $featureArr) === false){
				$checked = "";
			} else {
				$checked = "checked";
			}
			$strHTML .= "<td align=\"left\" valign=\"middle\" class=\"pad-btm5\"><input type=\"checkbox\" name='txtFeatures[]' value='". $value['property_features_id'] ."' class=\"RegFormChkBox\" " .$checked. "></td>\n";
			$strHTML .= "<td align=\"left\" valign=\"middle\" class=\"pad-btm5\"> " .ucwords($value['property_features_name']). " </td>\n";
			$i++;
		}
		$strHTML .= "</tbody></table>\n";
		echo $strHTML;
	}

	// Function for creating property "Further Details" section
	function fun_createPropertyFurtherDetails($property_id = ''){		
		$sqlFeaturesIds 	= "SELECT * FROM " . TABLE_PROPERTY_FEATURES_RELATIONS . " WHERE property_id='".$property_id."'";
		$rsFeatures 		= $this->dbObj->createRecordset($sqlFeaturesIds);
		$arrFeatures 		= $this->dbObj->fetchAssoc($rsFeatures);
		$featureArr 		= explode(",", $arrFeatures[0]['feature_ids']);

		$strHTML = "";
		$strHTML .= "\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";

		$strHTML .= "\n<tr>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" width=\"230px\">\n";
		$strHTML .= "\n<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:1px solid #9F9F9F;\">\n";
		$strHTML .= "\n<tr><td align=\"left\" valign=\"top\" class=\"font16-darkgrey pad-lft10 pad-top10 pad-btm5\"><strong>Holiday type</strong></td></tr>\n";
		// For Holiday type
		$sql = "SELECT * FROM " . TABLE_PROPERTY_FEATURES . " WHERE property_features_group_id ='1' ORDER BY property_features_name";
		$strHTML .= "\n<tr>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" class=\"pad-lft10 pad-top10 pad-btm5\">\n";
		$strHTML .= "\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"font12\"><tbody>\n";
		$strHTML .= "<tr height=\"2px\"><td width=\"20px\"></td><td></td>\n";

		$rs = $this->dbObj->createRecordset($sql);
		$arr = $this->dbObj->fetchAssoc($rs);
		$i = 0;
		foreach($arr as $value){
			if($i%1 == 0){
				$strHTML .= "</tr>\n<tr>";
			}
			if(array_search($value['property_features_id'], $featureArr) === false){
				$checked = "";
			} else {
				$checked = "checked";
			}
			$strHTML .= "<td align=\"left\" valign=\"middle\" class=\"pad-btm5\"><input type=\"checkbox\" name='txtFeatures[]' value='". $value['property_features_id'] ."' class=\"RegFormChkBox\" " .$checked. "></td>\n";
			$strHTML .= "<td align=\"left\" valign=\"middle\" class=\"pad-btm5\"> " .ucwords($value['property_features_name']). " </td>\n";
			$i++;
		}
		$strHTML .= "</tbody></table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "</tr>\n";
		// Note
		$strHTML .= "\n<tr>\n";
		$strHTML .= "\n<td valign=\"top\" colspan=\"2\">\n";
		$strHTML .= "\n<table width=\"150px\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
		$strHTML .= "\n<tr><td align=\"left\" valign=\"top\" class=\"font14 pad-lft10 pad-btm5 pad-top5\">Add some notes</td></tr>\n";
		$strHTML .= "\n<tr>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" class=\"pad-lft10 pad-btm15\">\n";
		$strHTML .= "\n<textarea name=\"txtHolidayTypeNote\" id=\"txtHolidayTypeId\" cols=\"\" rows=\"\" class=\"txtarea_200x90\">".$arrFeatures[0]['holiday_type_note']."</textarea>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "\n</tr>\n";
		$strHTML .= "\n</table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "\n</tr>\n";
		
		$strHTML .= "\n</table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\">&nbsp;</td>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" width=\"230px\">\n";
		$strHTML .= "\n<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:1px solid #9F9F9F;\">\n";
		$strHTML .= "\n<tr><td align=\"left\" colspan=\"2\" valign=\"top\" class=\"font16-darkgrey pad-lft10 pad-top10 pad-btm5\"><strong>Location</strong></td></tr>\n";
		// For Kitchen / Linen
		$sql = "SELECT * FROM " . TABLE_PROPERTY_FEATURES . " WHERE property_features_group_id ='9' ORDER BY property_features_name";
		$strHTML .= "\n<tr>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" class=\"pad-lft10 pad-top10 pad-btm5\">\n";
		$strHTML .= "\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"font12\"><tbody>\n";
		$strHTML .= "<tr height=\"2px\"><td width=\"20px\"></td><td></td>\n";

		$rs = $this->dbObj->createRecordset($sql);
		$arr = $this->dbObj->fetchAssoc($rs);
		$i = 0;
		foreach($arr as $value){
			if($i%1 == 0){
				$strHTML .= "</tr>\n<tr>";
			}
			if(array_search($value['property_features_id'], $featureArr) === false){
				$checked = "";
			} else {
				$checked = "checked";
			}
			$strHTML .= "<td align=\"left\" valign=\"middle\" class=\"pad-btm5\"><input type=\"checkbox\" name='txtFeatures[]' value='". $value['property_features_id'] ."' class=\"RegFormChkBox\" " .$checked. "></td>\n";
			$strHTML .= "<td align=\"left\" valign=\"middle\" class=\"pad-btm5\"> " .ucwords($value['property_features_name']). " </td>\n";
			$i++;
		}
		$strHTML .= "</tbody></table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "</tr>\n";
		// Note
		$strHTML .= "\n<tr>\n";
		$strHTML .= "\n<td valign=\"bottom\" colspan=\"2\" height=\"198px\">\n";
		$strHTML .= "\n<table width=\"150px\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
		$strHTML .= "\n<tr><td align=\"left\" valign=\"top\" class=\"font14 pad-lft10 pad-btm5 pad-top5\">Add some notes</td></tr>\n";
		$strHTML .= "\n<tr>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" class=\"pad-lft10 pad-btm15\">\n";
		$strHTML .= "\n<textarea name=\"txtLocationNote\" id=\"txtLocationNoteId\" cols=\"\" rows=\"\" class=\"txtarea_200x90\">".$arrFeatures[0]['location_note']."</textarea>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "\n</tr>\n";
		$strHTML .= "\n</table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "\n</tr>\n";

		$strHTML .= "\n</table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\">&nbsp;</td>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" width=\"230px\">\n";
		$strHTML .= "\n<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:1px solid #9F9F9F;\">\n";
		$strHTML .= "\n<tr><td align=\"left\" colspan=\"2\" valign=\"top\" class=\"font16-darkgrey pad-lft10 pad-top10 pad-btm5\"><strong>General</strong></td></tr>\n";
		// For Entertainment
		$sql = "SELECT * FROM " . TABLE_PROPERTY_FEATURES . " WHERE property_features_group_id ='5' AND property_features_id NOT IN (3,18,23,28,29,30) ORDER BY property_features_name";
		$strHTML .= "\n<tr>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" class=\"pad-lft10 pad-top10 pad-btm5\">\n";
		$strHTML .= "\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"font12\"><tbody>\n";
		$strHTML .= "<tr height=\"2px\"><td width=\"20px\"></td><td></td>\n";

		$rs = $this->dbObj->createRecordset($sql);
		$arr = $this->dbObj->fetchAssoc($rs);
		$i = 0;
		foreach($arr as $value){
			if($i%1 == 0){
				$strHTML .= "</tr>\n<tr>";
			}
			if(array_search($value['property_features_id'], $featureArr) === false){
				$checked = "";
			} else {
				$checked = "checked";
			}
			$strHTML .= "<td align=\"left\" valign=\"middle\" class=\"pad-btm5\"><input type=\"checkbox\" name='txtFeatures[]' value='". $value['property_features_id'] ."' class=\"RegFormChkBox\" " .$checked. "></td>\n";
			$strHTML .= "<td align=\"left\" valign=\"middle\" class=\"pad-btm5\"> " .ucwords($value['property_features_name']). " </td>\n";
			$i++;
		}
		$strHTML .= "</tbody></table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "</tr>\n";
		// Note
		$strHTML .= "\n<tr>\n";
		$strHTML .= "\n<td valign=\"bottom\" colspan=\"2\" height=\"100px\">\n";
		$strHTML .= "\n<table width=\"150px\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
		$strHTML .= "\n<tr><td align=\"left\" valign=\"top\" class=\"font14 pad-lft10 pad-btm5 pad-top5\">Add some notes</td></tr>\n";
		$strHTML .= "\n<tr>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" class=\"pad-lft10 pad-btm15\">\n";
		$strHTML .= "\n<textarea name=\"txtGeneralNote\" id=\"txtGeneralNoteId\" cols=\"\" rows=\"\" class=\"txtarea_200x90\">".$arrFeatures[0]['general_note']."</textarea>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "\n</tr>\n";
		$strHTML .= "\n</table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "\n</tr>\n";

		$strHTML .= "\n</table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "\n</tr>\n";
		
		
		$strHTML .= "\n<tr height=\"10px\"><td align=\"left\" valign=\"top\"></td></tr>\n";
		// Next row

		$strHTML .= "\n<tr>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" width=\"230px\">\n";
		$strHTML .= "\n<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:1px solid #9F9F9F;\">\n";
		$strHTML .= "\n<tr><td align=\"left\" valign=\"top\" class=\"font16-darkgrey pad-lft10 pad-top10 pad-btm5\"><strong>Services</strong></td></tr>\n";
		// For Holiday type
		$sql = "SELECT * FROM " . TABLE_PROPERTY_FEATURES . " WHERE property_features_group_id ='8' ORDER BY property_features_name";
		$strHTML .= "\n<tr>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" class=\"pad-lft10 pad-top10 pad-btm5\">\n";
		$strHTML .= "\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"font12\"><tbody>\n";
		$strHTML .= "<tr height=\"2px\"><td width=\"20px\"></td><td></td>\n";

		$rs = $this->dbObj->createRecordset($sql);
		$arr = $this->dbObj->fetchAssoc($rs);
		$i = 0;
		foreach($arr as $value){
			if($i%1 == 0){
				$strHTML .= "</tr>\n<tr>";
			}
			if(array_search($value['property_features_id'], $featureArr) === false){
				$checked = "";
			} else {
				$checked = "checked";
			}
			$strHTML .= "<td align=\"left\" valign=\"middle\" class=\"pad-btm5\"><input type=\"checkbox\" name='txtFeatures[]' value='". $value['property_features_id'] ."' class=\"RegFormChkBox\" " .$checked. "></td>\n";
			$strHTML .= "<td align=\"left\" valign=\"middle\" class=\"pad-btm5\"> " .ucwords($value['property_features_name']). " </td>\n";
			$i++;
		}
		$strHTML .= "</tbody></table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "</tr>\n";
		// Note
		$strHTML .= "\n<tr>\n";
		$strHTML .= "\n<td valign=\"bottom\" colspan=\"2\" height=\"198px\">\n";
		$strHTML .= "\n<table width=\"150px\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
		$strHTML .= "\n<tr><td align=\"left\" valign=\"top\" class=\"font14 pad-lft10 pad-btm5 pad-top5\">Add some notes</td></tr>\n";
		$strHTML .= "\n<tr>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" class=\"pad-lft10 pad-btm15\">\n";
		$strHTML .= "\n<textarea name=\"txtServicesNote\" id=\"txtServicesNoteId\" cols=\"\" rows=\"\" class=\"txtarea_200x90\">".$arrFeatures[0]['services_note']."</textarea>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "\n</tr>\n";
		$strHTML .= "\n</table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "\n</tr>\n";
		
		$strHTML .= "\n</table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\">&nbsp;</td>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" width=\"230px\">\n";
		$strHTML .= "\n<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:1px solid #9F9F9F;\">\n";
		$strHTML .= "\n<tr><td align=\"left\" colspan=\"2\" valign=\"top\" class=\"font16-darkgrey pad-lft10 pad-top10 pad-btm5\"><strong>Kitchen/Linen</strong></td></tr>\n";
		// For Kitchen / Linen
		$sql = "SELECT * FROM " . TABLE_PROPERTY_FEATURES . " WHERE property_features_group_id ='2' ORDER BY property_features_name";
		$strHTML .= "\n<tr>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" class=\"pad-lft10 pad-top10 pad-btm5\">\n";
		$strHTML .= "\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"font12\"><tbody>\n";
		$strHTML .= "<tr height=\"2px\"><td width=\"20px\"></td><td></td>\n";

		$rs = $this->dbObj->createRecordset($sql);
		$arr = $this->dbObj->fetchAssoc($rs);
		$i = 0;
		foreach($arr as $value){
			if($i%1 == 0){
				$strHTML .= "</tr>\n<tr>";
			}
			if(array_search($value['property_features_id'], $featureArr) === false){
				$checked = "";
			} else {
				$checked = "checked";
			}
			$strHTML .= "<td align=\"left\" valign=\"middle\" class=\"pad-btm5\"><input type=\"checkbox\" name='txtFeatures[]' value='". $value['property_features_id'] ."' class=\"RegFormChkBox\" " .$checked. "></td>\n";
			$strHTML .= "<td align=\"left\" valign=\"middle\" class=\"pad-btm5\"> " .ucwords($value['property_features_name']). " </td>\n";
			$i++;
		}
		$strHTML .= "</tbody></table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "</tr>\n";
		// Note
		$strHTML .= "\n<tr>\n";
		$strHTML .= "\n<td valign=\"bottom\" colspan=\"2\" height=\"130px\">\n";
		$strHTML .= "\n<table width=\"150px\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
		$strHTML .= "\n<tr><td align=\"left\" valign=\"top\" class=\"font14 pad-lft10 pad-btm5 pad-top5\">Add some notes</td></tr>\n";
		$strHTML .= "\n<tr>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" class=\"pad-lft10 pad-btm15\">\n";
		$strHTML .= "\n<textarea name=\"txtKitchenNote\" id=\"txtKitchenNoteId\" cols=\"\" rows=\"\" class=\"txtarea_200x90\">".$arrFeatures[0]['kitchen_note']."</textarea>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "\n</tr>\n";
		$strHTML .= "\n</table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "\n</tr>\n";

		$strHTML .= "\n</table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\">&nbsp;</td>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" width=\"230px\">\n";
		$strHTML .= "\n<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:1px solid #9F9F9F;\">\n";
		$strHTML .= "\n<tr><td align=\"left\" colspan=\"2\" valign=\"top\" class=\"font16-darkgrey pad-lft10 pad-top10 pad-btm5\"><strong>Entertainment</strong></td></tr>\n";
		// For Entertainment
		$sql = "SELECT * FROM " . TABLE_PROPERTY_FEATURES . " WHERE property_features_group_id ='3' ORDER BY FIELD('property_features_name', 'Television (TV)', 'Public satelite TV', 'Satellite TV in rooms', 'DVD Player', 'Blue Ray Player', 'Wi-Fi', 'Internet Access', 'Greek evenings', 'Board games (i.e. chess, cards)', 'Karaoke nights', 'Animation shows', 'Tribute nights', 'Children entertainment', 'Live music', 'Play station', 'Pool table', 'Table tennis', 'Beach games')";
		$strHTML .= "\n<tr>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" class=\"pad-lft10 pad-top10 pad-btm5\">\n";
		$strHTML .= "\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"font12\"><tbody>\n";
		$strHTML .= "<tr height=\"2px\"><td width=\"20px\"></td><td></td>\n";

		$rs = $this->dbObj->createRecordset($sql);
		$arr = $this->dbObj->fetchAssoc($rs);
		$i = 0;
		foreach($arr as $value){
			if($i%1 == 0){
				$strHTML .= "</tr>\n<tr>";
			}
			if(array_search($value['property_features_id'], $featureArr) === false){
				$checked = "";
			} else {
				$checked = "checked";
			}
			$strHTML .= "<td align=\"left\" valign=\"middle\" class=\"pad-btm5\"><input type=\"checkbox\" name='txtFeatures[]' value='". $value['property_features_id'] ."' class=\"RegFormChkBox\" " .$checked. "></td>\n";
			$strHTML .= "<td align=\"left\" valign=\"middle\" class=\"pad-btm5\"> " .ucwords($value['property_features_name']). " </td>\n";
			$i++;
		}
		$strHTML .= "</tbody></table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "</tr>\n";
		// Note
		$strHTML .= "\n<tr>\n";
		$strHTML .= "\n<td valign=\"bottom\" colspan=\"2\" height=\"195px\">\n";
		$strHTML .= "\n<table width=\"150px\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
		$strHTML .= "\n<tr><td align=\"left\" valign=\"top\" class=\"font14 pad-lft10 pad-btm5 pad-top5\">Add some notes</td></tr>\n";
		$strHTML .= "\n<tr>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" class=\"pad-lft10 pad-btm15\">\n";
		$strHTML .= "\n<textarea name=\"txtEntertainmentNote\" id=\"txtEntertainmentNoteId\" cols=\"\" rows=\"\" class=\"txtarea_200x90\">".$arrFeatures[0]['entertainment_note']."</textarea>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "\n</tr>\n";
		$strHTML .= "\n</table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "\n</tr>\n";

		$strHTML .= "\n</table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "\n</tr>\n";

		$strHTML .= "\n<tr height=\"10px\"><td align=\"left\" valign=\"top\"></td></tr>\n";
		// Next row
		$strHTML .= "\n<tr>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" width=\"230px\">\n";
		$strHTML .= "\n<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:1px solid #9F9F9F;\">\n";
		$strHTML .= "\n<tr><td align=\"left\" valign=\"top\" class=\"font16-darkgrey pad-lft10 pad-top10 pad-btm5\"><strong>Outdoors facilities</strong></td></tr>\n";
		// For Holiday type
		$sql = "SELECT * FROM " . TABLE_PROPERTY_FEATURES . " WHERE property_features_group_id ='4' ORDER BY property_features_name";
		$strHTML .= "\n<tr>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" class=\"pad-lft10 pad-top10 pad-btm5\">\n";
		$strHTML .= "\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"font12\"><tbody>\n";
		$strHTML .= "<tr height=\"2px\"><td width=\"20px\"></td><td></td>\n";

		$rs = $this->dbObj->createRecordset($sql);
		$arr = $this->dbObj->fetchAssoc($rs);
		$i = 0;
		foreach($arr as $value){
			if($i%1 == 0){
				$strHTML .= "</tr>\n<tr>";
			}
			if(array_search($value['property_features_id'], $featureArr) === false){
				$checked = "";
			} else {
				$checked = "checked";
			}
			$strHTML .= "<td align=\"left\" valign=\"middle\" class=\"pad-btm5\"><input type=\"checkbox\" name='txtFeatures[]' value='". $value['property_features_id'] ."' class=\"RegFormChkBox\" " .$checked. "></td>\n";
			$strHTML .= "<td align=\"left\" valign=\"middle\" class=\"pad-btm5\"> " .ucwords($value['property_features_name']). " </td>\n";
			$i++;
		}
		$strHTML .= "</tbody></table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "</tr>\n";
		// Note
		$strHTML .= "\n<tr>\n";
		$strHTML .= "\n<td valign=\"bottom\" colspan=\"2\" height=\"160px\">\n";
		$strHTML .= "\n<table width=\"150px\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
		$strHTML .= "\n<tr><td align=\"left\" valign=\"top\" class=\"font14 pad-lft10 pad-btm5 pad-top5\">Add some notes</td></tr>\n";
		$strHTML .= "\n<tr>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" class=\"pad-lft10 pad-btm15\">\n";
		$strHTML .= "\n<textarea name=\"txtOutsideNote\" id=\"txtOutsideNoteId\" cols=\"\" rows=\"\" class=\"txtarea_200x90\">".$arrFeatures[0]['outside_note']."</textarea>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "\n</tr>\n";
		$strHTML .= "\n</table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "\n</tr>\n";
		
		$strHTML .= "\n</table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\">&nbsp;</td>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" width=\"230px\">\n";
		$strHTML .= "\n<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:1px solid #9F9F9F;\">\n";
		$strHTML .= "\n<tr><td align=\"left\" colspan=\"2\" valign=\"top\" class=\"font16-darkgrey pad-lft10 pad-top10 pad-btm5\"><strong>Heating/Cooling</strong></td></tr>\n";
		// For Kitchen / Linen
		$sql = "SELECT * FROM " . TABLE_PROPERTY_FEATURES . " WHERE property_features_group_id ='7' ORDER BY property_features_name";
		$strHTML .= "\n<tr>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" class=\"pad-lft10 pad-top10 pad-btm5\">\n";
		$strHTML .= "\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"font12\"><tbody>\n";
		$strHTML .= "<tr height=\"2px\"><td width=\"20px\"></td><td></td>\n";

		$rs = $this->dbObj->createRecordset($sql);
		$arr = $this->dbObj->fetchAssoc($rs);
		$i = 0;
		foreach($arr as $value){
			if($i%1 == 0){
				$strHTML .= "</tr>\n<tr>";
			}
			if(array_search($value['property_features_id'], $featureArr) === false){
				$checked = "";
			} else {
				$checked = "checked";
			}
			$strHTML .= "<td align=\"left\" valign=\"middle\" class=\"pad-btm5\"><input type=\"checkbox\" name='txtFeatures[]' value='". $value['property_features_id'] ."' class=\"RegFormChkBox\" " .$checked. "></td>\n";
			$strHTML .= "<td align=\"left\" valign=\"middle\" class=\"pad-btm5\"> " .ucwords($value['property_features_name']). " </td>\n";
			$i++;
		}
		$strHTML .= "</tbody></table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "</tr>\n";
		// Note
		$strHTML .= "\n<tr>\n";
		$strHTML .= "\n<td valign=\"bottom\" colspan=\"2\" height=\"220px\">\n";
		$strHTML .= "\n<table width=\"150px\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
		$strHTML .= "\n<tr><td align=\"left\" valign=\"top\" class=\"font14 pad-lft10 pad-btm5 pad-top5\">Add some notes</td></tr>\n";
		$strHTML .= "\n<tr>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" class=\"pad-lft10 pad-btm15\">\n";
		$strHTML .= "\n<textarea name=\"txtHeatingCoolingNote\" id=\"txtHeatingCoolingNoteId\" cols=\"\" rows=\"\" class=\"txtarea_200x90\">".$arrFeatures[0]['heating_cooling_note']."</textarea>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "\n</tr>\n";
		$strHTML .= "\n</table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "\n</tr>\n";

		$strHTML .= "\n</table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\">&nbsp;</td>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" width=\"230px\">\n";
		$strHTML .= "\n<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:1px solid #9F9F9F;\">\n";
		$strHTML .= "\n<tr><td align=\"left\" colspan=\"2\" valign=\"top\" class=\"font16-darkgrey pad-lft10 pad-top10 pad-btm5\"><strong>Activities Nearby</strong></td></tr>\n";
		// For Entertainment
		$sql = "SELECT * FROM " . TABLE_PROPERTY_FEATURES . " WHERE property_features_group_id ='6' ORDER BY property_features_name";
		$strHTML .= "\n<tr>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" class=\"pad-lft10 pad-top10 pad-btm5\">\n";
		$strHTML .= "\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"font12\"><tbody>\n";
		$strHTML .= "<tr height=\"2px\"><td width=\"20px\"></td><td></td>\n";

		$rs = $this->dbObj->createRecordset($sql);
		$arr = $this->dbObj->fetchAssoc($rs);
		$i = 0;
		foreach($arr as $value){
			if($i%1 == 0){
				$strHTML .= "</tr>\n<tr>";
			}
			if(array_search($value['property_features_id'], $featureArr) === false){
				$checked = "";
			} else {
				$checked = "checked";
			}
			$strHTML .= "<td align=\"left\" valign=\"middle\" class=\"pad-btm5\"><input type=\"checkbox\" name='txtFeatures[]' value='". $value['property_features_id'] ."' class=\"RegFormChkBox\" " .$checked. "></td>\n";
			$strHTML .= "<td align=\"left\" valign=\"middle\" class=\"pad-btm5\"> " .ucwords($value['property_features_name']). " </td>\n";
			$i++;
		}
		$strHTML .= "</tbody></table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "</tr>\n";
		// Note
		$strHTML .= "\n<tr>\n";
		$strHTML .= "\n<td valign=\"bottom\" colspan=\"2\" height=\"160px\">\n";
		$strHTML .= "\n<table width=\"150px\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
		$strHTML .= "\n<tr><td align=\"left\" valign=\"top\" class=\"font14 pad-lft10 pad-btm5 pad-top5\">Add some notes</td></tr>\n";
		$strHTML .= "\n<tr>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" class=\"pad-lft10 pad-btm15\">\n";

		$strHTML .= "\n<textarea name=\"txtActivitiesNote\" id=\"txtActivitiesNoteId\" cols=\"\" rows=\"\" class=\"txtarea_200x90\">".$arrFeatures[0]['activities_note']."</textarea>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "\n</tr>\n";
		$strHTML .= "\n</table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "\n</tr>\n";

		$strHTML .= "\n</table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "\n</tr>\n";
		$strHTML .= "\n</table>\n";

		echo $strHTML;
	}

	// Function for creating property headline
	function fun_getPropertyHeadline($property_id){
		if($property_id == ''){
			return false;
		} else {
//			$sql 		= "SELECT A.country_id, A.area_id, A.region_id, A.location_id, A.property_type, A.catering_type, B.pt_title, C.catering_name FROM " . TABLE_PROPERTY . " AS A INNER JOIN " . TABLE_PROPERTY_TYPE . " AS B ON B.pt_id=A.property_type INNER JOIN " . TABLE_PROPERTY_CATERING . " AS C ON C.catering_id=A.catering_type WHERE A.property_id='".$property_id."'";

			$sql 		= "SELECT A.country_id, A.area_id, A.region_id, A.location_id, A.property_type, A.catering_type FROM " . TABLE_PROPERTY . " AS A WHERE A.property_id='".$property_id."'";
			$rs 		= $this->dbObj->createRecordset($sql);
			$arr 		= $this->dbObj->fetchAssoc($rs);
			
			if(isset($arr[0]['catering_type']) && $arr[0]['catering_type'] > 0) {
				$catering_type_name = $this->fun_getPropertyCateringNameById($arr[0]['catering_type']);
			}

			if(isset($arr[0]['property_type']) && $arr[0]['property_type'] > 0) {
				$property_type_name = $this->fun_getPropertyTypeNameById($arr[0]['property_type']);
			}

			if(isset($arr[0]['location_id']) && $arr[0]['location_id'] > 0) {
				$property_location_name = $this->fun_getPropertyLocationNameById($arr[0]['location_id']);
			} else if(isset($arr[0]['region_id']) && $arr[0]['region_id'] > 0) {
				$property_location_name = $this->fun_getPropertyRegionNameById($arr[0]['region_id']);
			} else if(isset($arr[0]['area_id']) && $arr[0]['area_id'] > 0) {
				$property_location_name = $this->fun_getPropertyAreaNameById($arr[0]['area_id']);
			} else if(isset($arr[0]['region_id']) && $arr[0]['region_id'] > 0) {
				$property_location_name = $this->fun_getPropertyCountryNameById($arr[0]['country_id']);
			}

			$strHeadline = ucwords($catering_type_name).' '.ucwords($property_type_name).' in '.ucwords($property_location_name);
			return $strHeadline;
		}
	}

	function fun_getPropertyCateringNameById($catering_id){		
		if($catering_id == "") {
			return false;
		} else {
			if(($catering_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_CATERING , " WHERE catering_id='".$catering_id."'")) && (is_array($catering_array))) {
				$catering_name = $catering_array[0]['catering_name'];
				return fun_db_output($catering_name);
			} else {
				return "";
			}
		
		}
	}


	function fun_getPropertyTypeNameById($pt_id){		
		if($pt_id == "") {
			return false;
		} else {
			if(($property_type_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_TYPE , " WHERE pt_id='".$pt_id."'")) && (is_array($property_type_array))) {
				$property_type_name = $property_type_array[0]['pt_title'];
				return fun_db_output($property_type_name);
			} else {
				return "";
			}
		
		}
	}


	// Function for creating property features section
	function fun_createPropertyFacilities4PropertyPriview($property_id){		
		$FeaturesArr 	= $this->fun_getPropertyFeaturesArr($property_id);
		$feature_ids 	= $FeaturesArr[0]['feature_ids'];
		$feature_note 	= $FeaturesArr[0]['feature_notes'];
		if(isset($feature_ids) && $feature_ids != "") {

			$featureArr = explode(",", $feature_ids);
			$feature_group_ids = "1";
			$feature_name_no = "'Is linen provided?', 'Are towels provided?', 'Are beach towels provided?', 'close to the ariport', 'close to the shops', 'close to the beach', 'child friendly'";
			$sql 				= "SELECT * FROM " . TABLE_PROPERTY_FEATURES . " WHERE property_features_name NOT IN (" .$feature_name_no. ") AND property_features_id IN (" .$feature_ids. ") AND property_features_group_id NOT IN (" .$feature_group_ids. ") ORDER BY property_features_name";
//			$sql 				= "SELECT * FROM " . TABLE_PROPERTY_FEATURES . " WHERE property_features_name NOT IN ('Is linen provided?', 'Are towels provided?', 'Are beach towels provided?') AND property_features_id IN (" .$feature_ids. ") AND property_features_group_id  IN (" .$feature_group_ids. ") ORDER BY property_features_name";
//			$sql 				= "SELECT * FROM " . TABLE_PROPERTY_FEATURES . " WHERE property_features_name NOT IN ('Is linen provided?', 'Are towels provided?', 'Are beach towels provided?') AND property_features_id IN (" .$feature_ids. ") ORDER BY property_features_name";
			$rs 				= $this->dbObj->createRecordset($sql);
			$arr 				= $this->dbObj->fetchAssoc($rs);
			$total_featrures 	= count($arr);

			// For linen
			if($this->fun_createPropertyFeatureByName($property_id, "Is linen provided?") === true){
				$linenstyle = "SummaryTick";
			} else {
				$linenstyle = "SummaryCross";
			}
		
			// For towels
			if($this->fun_createPropertyFeatureByName($property_id, "Are towels provided?") === true){
				$towelstyle = "SummaryTick";
			} else {
				$towelstyle = "SummaryCross";
			}
		
			// For beach towels
			if($this->fun_createPropertyFeatureByName($property_id, "Are beach towels provided?") === true){
				$beachtowelstyle = "SummaryTick";
			} else {
				$beachtowelstyle = "SummaryCross";
			}

			if($this->fun_createPropertyFeatureByName($property_id, "general") === true){
				$generalstyle = "SummaryTick";
			} else {
				$generalstyle = "SummaryCross";
			}

			echo "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
			echo "<tr><td colspan=\"3\" class=\"owner-headingsfacilities\">Facilities</td></tr>";

			echo "<tr>";
			echo "<td valign=\"top\" align=\"Left\">";
			echo "<table width=\"190\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
			echo "<tr height=\"11px\">";
			echo "<td class=\"dash-btm\"></td>";
			if($total_featrures > 5) {
				if($total_featrures % 2 == 0) {
					//even condition
					$first_cell_num = $total_featrures - ((int)($total_featrures-6)/2);
				} else {
					//odd condition
					$first_cell_num = $total_featrures - ((int)($total_featrures-5)/2);
				}
				for($i = 0; $i < $first_cell_num; $i++) {
					$feature_name = $arr[$i]['property_features_name'];
					echo "</tr><tr class=\"Summary\"><td>".ucwords($feature_name)."</td></tr>";
				}
			} else {
				for($i = 0; $i < count($arr); $i++) {
					$feature_name = $arr[$i]['property_features_name'];
					echo "</tr><tr class=\"Summary\"><td>".ucwords($feature_name)."</td></tr>";
				}
			}
			echo "</table>";
			echo "</td>";
			echo "<td><img src=\"".SITE_IMAGES."spacer.gif\" alt=\"Summary\" width=\"30\" height=\"30\" /></td>";
			echo "<td valign=\"top\" align=\"Left\">";
			if($total_featrures > 5) {
				echo "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
				echo "<tr height=\"11px\">";
				echo "<td class=\"dash-btm\"></td>";
				echo "</tr>";
				for($j = $first_cell_num; $j < count($arr); $j++) {
					$feature_name = $arr[$j]['property_features_name'];
					echo "</tr><tr class=\"Summary\"><td>".ucwords($feature_name)."</td></tr>";
				}
				echo "</table>";
			}

/*
			echo "<table width=\"190\" cellspacing=\"0\" cellpadding=\"0\">";

			if($total_featrures <= 5) {
				$tpstyle = "pad-top5 ";
			} else {
				$tpstyle = "pad-top15 ";
			}
			echo "<tr>";
			echo "<td colspan=\"2\" class=\"grey-txt14 pad-btm10 ".$tpstyle." dash-btm\">Details</td>";
			echo "</tr>";
			echo "<tr class=\"Summary\">";
			echo "<td colspan=\"2\"><p class=\"".$linenstyle."\">Linen provided</p></td>";
			echo "</tr>";
			echo "<tr class=\"Summary\">";
			echo "<td colspan=\"2\"><p class=\"".$towelstyle."\">Towels provided</p></td>";
			echo "</tr>";
			echo "<tr class=\"Summary\">";
			echo "<td colspan=\"2\"><p class=\"".$beachtowelstyle."\">Beach towels provided</p></td>";
			echo "</tr>";
			echo "</table>";
*/
			echo "</td>";
			echo "</tr>";
			echo "<tr><td class=\"pad-top15 pad-btm20 editor-txt\" colspan=\"3\">".$feature_note."</td></tr>";
			echo "</table>";
		} else {
			return false;
		}
	}
/*
* Property Features / Aminities specific functions : end here
*/

/*
* Property Accommodation / Aminities specific functions : start here
*/
	function fun_createPropertyAmenities4PropertyPreview($property_id){	
		if(isset($property_id) && $property_id != '') {
			echo '<table border="0" align="left" cellpadding="0" cellspacing="0" width="100%" class="font12 dyn-row">';
			$propertyInfo			= $this->fun_getPropertyInfo($property_id);
			$property_type_name		= $propertyInfo['property_type_name'];
			$property_catering_name	= $propertyInfo['property_catering_name'];

			//Property Type
			echo '<tr>';
			echo '<td width="180px" align="right" valign="top" class="pad-top10 pad-btm10 pad-rgt10">';
			echo '<h2>'.ucwords(tranText('property type')).':</h2>';
			echo '</td>';
			echo '<td valign="top" class="pad-top10 pad-btm10">';
			echo ucwords(tranText($property_type_name));
			echo '</td>';
			echo '</tr>';

			//Accommodation Type
			echo '<tr>';
			echo '<td align="right" valign="top" class="pad-top10 pad-btm10 pad-rgt10">';
			echo '<h2>'.ucwords(tranText('accommodation type')).':</h2>';
			echo '</td>';
			echo '<td valign="top" class="pad-top10 pad-btm10">';
			echo ucwords(tranText($property_catering_name));
			echo '</td>';
			echo '</tr>';

			$FeaturesArr 			= $this->fun_getPropertyFeaturesArr($property_id);
			$feature_ids 			= $FeaturesArr[0]['feature_ids'];
			$feature_note 			= $FeaturesArr[0]['feature_notes'];
			$holiday_type_note 		= $FeaturesArr[0]['holiday_type_note'];
			$kitchen_note 			= $FeaturesArr[0]['kitchen_note'];
			$entertainment_note 	= $FeaturesArr[0]['entertainment_note'];
			$outside_note 			= $FeaturesArr[0]['outside_note'];
			$general_note 			= $FeaturesArr[0]['general_note'];
			$activities_note 		= $FeaturesArr[0]['activities_note'];
			$heating_cooling_note 	= $FeaturesArr[0]['heating_cooling_note'];
			$services_note 			= $FeaturesArr[0]['services_note'];
			$location_note 			= $FeaturesArr[0]['location_note'];

			if(isset($feature_ids) && $feature_ids != "") {
				$featureArr = explode(",", $feature_ids);

				//Location Type
				$feature_group_ids = "9";
				$feature_name_no = "'Is linen provided?', 'Are towels provided?', 'Are beach towels provided?'";
				$sql 				= "SELECT * FROM " . TABLE_PROPERTY_FEATURES . " WHERE property_features_name NOT IN (" .$feature_name_no. ") AND property_features_id IN (" .$feature_ids. ") AND property_features_group_id IN (" .$feature_group_ids. ") ORDER BY property_features_name";
				$rs 				= $this->dbObj->createRecordset($sql);
				$arr 				= $this->dbObj->fetchAssoc($rs);
				$total_featrures 	= count($arr);
				if($total_featrures > 0) {
					echo '<tr>';
					echo '<td align="right" valign="top" class="pad-top10 pad-btm10 pad-rgt10">';
					echo '<h2>'.ucwords(tranText('location type')).':</h2>';
					echo '</td>';
					echo '<td valign="top" class="pad-top10 pad-btm10">';
					echo '<div class="list-1">';
					echo '<ul>';
					for($i = 0; $i < $total_featrures; $i++) {
						$feature_name = $arr[$i]['property_features_name'];
						echo "<li>".ucwords(tranText($feature_name))."</li>";
					}
					echo '</ul>';
					echo '<div class="clearfix">&nbsp;</div>';
					echo '<div align="left" class="pad-top10 pad-btm10"><br>'.$location_note.'</div>';
					echo '</div>';
					echo '</td>';
					echo '</tr>';
				}

				//Holiday Type
				$feature_group_ids = "1";
				$feature_name_no = "'Is linen provided?', 'Are towels provided?', 'Are beach towels provided?'";
				$sql 				= "SELECT * FROM " . TABLE_PROPERTY_FEATURES . " WHERE property_features_name NOT IN (" .$feature_name_no. ") AND property_features_id IN (" .$feature_ids. ") AND property_features_group_id IN (" .$feature_group_ids. ") ORDER BY property_features_name";
				$rs 				= $this->dbObj->createRecordset($sql);

				$arr 				= $this->dbObj->fetchAssoc($rs);
				$total_featrures 	= count($arr);
				if($total_featrures > 0) {
					echo '<tr>';
					echo '<td align="right" valign="top" class="pad-top10 pad-btm10 pad-rgt10">';
					echo '<h2>'.ucwords(tranText('theme')).':</h2>';
					echo '</td>';
					echo '<td valign="top" class="pad-top10 pad-btm10">';
					echo '<div class="list-1">';
					echo '<ul>';
					for($i = 0; $i < $total_featrures; $i++) {
						$feature_name = $arr[$i]['property_features_name'];
						echo "<li>".ucwords(tranText($feature_name))."</li>";
					}
					echo '</ul>';
					echo '<div class="clearfix">&nbsp;</div>';
					echo '<div align="left" class="pad-top10 pad-btm10"><br>'.$holiday_type_note.'</div>';
					echo '</div>';
					echo '</td>';
					echo '</tr>';
				}

				//General
				$feature_group_ids = "5";
				$feature_name_no = "'Is linen provided?', 'Are towels provided?', 'Are beach towels provided?'";
				$sql 				= "SELECT * FROM " . TABLE_PROPERTY_FEATURES . " WHERE property_features_name NOT IN (" .$feature_name_no. ") AND property_features_id IN (" .$feature_ids. ") AND property_features_group_id IN (" .$feature_group_ids. ") ORDER BY property_features_name";
				$rs 				= $this->dbObj->createRecordset($sql);
				$arr 				= $this->dbObj->fetchAssoc($rs);
				$total_featrures 	= count($arr);
				if($total_featrures > 0) {
					echo '<tr>';
					echo '<td align="right" valign="top" class="pad-top10 pad-btm10 pad-rgt10">';
					echo '<h2>'.ucwords(tranText('general')).':</h2>';
					echo '</td>';
					echo '<td valign="top" class="pad-top10 pad-btm10">';
					echo '<div class="list-1">';
					echo '<ul>';
					for($i = 0; $i < $total_featrures; $i++) {
						$feature_name = $arr[$i]['property_features_name'];
						echo "<li>".ucwords(tranText($feature_name))."</li>";
					}
					echo '</ul>';
					echo '<div class="clearfix">&nbsp;</div>';
					echo '<div align="left" class="pad-top10 pad-btm10"><br>'.$general_note.'</div>';
					echo '</div>';
					echo '</td>';
					echo '</tr>';
				}

				//Kitchen
				$feature_group_ids = "2";
				$feature_name_no = "'Is linen provided?', 'Are towels provided?', 'Are beach towels provided?'";
				$sql 				= "SELECT * FROM " . TABLE_PROPERTY_FEATURES . " WHERE property_features_name NOT IN (" .$feature_name_no. ") AND property_features_id IN (" .$feature_ids. ") AND property_features_group_id IN (" .$feature_group_ids. ") ORDER BY property_features_name";
				$rs 				= $this->dbObj->createRecordset($sql);
				$arr 				= $this->dbObj->fetchAssoc($rs);
				$total_featrures 	= count($arr);
				if($total_featrures > 0) {
					echo '<tr>';
					echo '<td align="right" valign="top" class="pad-top10 pad-btm10 pad-rgt10">';
					echo '<h2>'.ucwords(tranText('kitchen')).':</h2>';
					echo '</td>';
					echo '<td valign="top" class="pad-top10 pad-btm10">';
					echo '<div class="list-1">';
					echo '<ul>';
					for($i = 0; $i < $total_featrures; $i++) {
						$feature_name = $arr[$i]['property_features_name'];
						echo "<li>".ucwords(tranText($feature_name))."</li>";
					}
					echo '</ul>';
					echo '<div class="clearfix">&nbsp;</div>';
					echo '<div align="left" class="pad-top10 pad-btm10">'.$kitchen_note.'</div>';
					echo '</div>';
					echo '</td>';
					echo '</tr>';
				}

				//Services
				$feature_group_ids = "8";
				$feature_name_no = "'Is linen provided?', 'Are towels provided?', 'Are beach towels provided?'";
				$sql 				= "SELECT * FROM " . TABLE_PROPERTY_FEATURES . " WHERE property_features_name NOT IN (" .$feature_name_no. ") AND property_features_id IN (" .$feature_ids. ") AND property_features_group_id IN (" .$feature_group_ids. ") ORDER BY property_features_name";
				$rs 				= $this->dbObj->createRecordset($sql);
				$arr 				= $this->dbObj->fetchAssoc($rs);
				$total_featrures 	= count($arr);
				if($total_featrures > 0) {
					echo '<tr>';
					echo '<td align="right" valign="top" class="pad-top10 pad-btm10 pad-rgt10">';
					echo '<h2>'.ucwords(tranText('services')).':</h2>';
					echo '</td>';
					echo '<td valign="top" class="pad-top10 pad-btm10">';
					echo '<div class="list-1">';
					echo '<ul>';
					for($i = 0; $i < $total_featrures; $i++) {
						$feature_name = $arr[$i]['property_features_name'];
						echo "<li>".ucwords(tranText($feature_name))."</li>";
					}
					echo '</ul>';
					echo '<div class="clearfix">&nbsp;</div>';
					echo '<div align="left" class="pad-top10 pad-btm10">'.$services_note.'</div>';
					echo '</div>';
					echo '</td>';
					echo '</tr>';
				}

				//Heating/Cooling
				$feature_group_ids = "7";
				$feature_name_no = "'Is linen provided?', 'Are towels provided?', 'Are beach towels provided?'";
				$sql 				= "SELECT * FROM " . TABLE_PROPERTY_FEATURES . " WHERE property_features_name NOT IN (" .$feature_name_no. ") AND property_features_id IN (" .$feature_ids. ") AND property_features_group_id IN (" .$feature_group_ids. ") ORDER BY property_features_name";
				$rs 				= $this->dbObj->createRecordset($sql);
				$arr 				= $this->dbObj->fetchAssoc($rs);
				$total_featrures 	= count($arr);
				if($total_featrures > 0) {
					echo '<tr>';
					echo '<td align="right" valign="top" class="pad-top10 pad-btm10 pad-rgt10">';
					echo '<h2>'.ucwords(tranText('heating/cooling')).':</h2>';
					echo '</td>';
					echo '<td valign="top" class="pad-top10 pad-btm10">';
					echo '<div class="list-1">';
					echo '<ul>';
					for($i = 0; $i < $total_featrures; $i++) {
						$feature_name = $arr[$i]['property_features_name'];
						echo "<li>".ucwords(tranText($feature_name))."</li>";
					}
					echo '</ul>';
					echo '<div class="clearfix">&nbsp;</div>';
					echo '<div align="left" class="pad-top10 pad-btm10">'.$heating_cooling_note.'</div>';
					echo '</div>';
					echo '</td>';
					echo '</tr>';
				}

				//Entertainment
				$feature_group_ids = "3";
				$feature_name_no = "'Is linen provided?', 'Are towels provided?', 'Are beach towels provided?'";
				$sql 				= "SELECT * FROM " . TABLE_PROPERTY_FEATURES . " WHERE property_features_name NOT IN (" .$feature_name_no. ") AND property_features_id IN (" .$feature_ids. ") AND property_features_group_id IN (" .$feature_group_ids. ") ORDER BY property_features_name";
				$rs 				= $this->dbObj->createRecordset($sql);
				$arr 				= $this->dbObj->fetchAssoc($rs);
				$total_featrures 	= count($arr);
				if($total_featrures > 0) {
					echo '<tr>';
					echo '<td align="right" valign="top" class="pad-top10 pad-btm10 pad-rgt10">';
					echo '<h2>'.ucwords(tranText('entertainment')).':</h2>';
					echo '</td>';
					echo '<td valign="top" class="pad-top10 pad-btm10">';
					echo '<div class="list-1">';
					echo '<ul>';
					for($i = 0; $i < $total_featrures; $i++) {
						$feature_name = $arr[$i]['property_features_name'];
						echo "<li>".ucwords(tranText($feature_name))."</li>";
					}
					echo '</ul>';
					echo '<div class="clearfix">&nbsp;</div>';
					echo '<div align="left" class="pad-top10 pad-btm10">'.$entertainment_note.'</div>';
					echo '</div>';
					echo '</td>';
					echo '</tr>';
				}

				//Outdoors facilities
				$feature_group_ids = "4";
				$feature_name_no = "'Is linen provided?', 'Are towels provided?', 'Are beach towels provided?'";
				$sql 				= "SELECT * FROM " . TABLE_PROPERTY_FEATURES . " WHERE property_features_name NOT IN (" .$feature_name_no. ") AND property_features_id IN (" .$feature_ids. ") AND property_features_group_id IN (" .$feature_group_ids. ") ORDER BY property_features_name";
				$rs 				= $this->dbObj->createRecordset($sql);
				$arr 				= $this->dbObj->fetchAssoc($rs);
				$total_featrures 	= count($arr);
				if($total_featrures > 0) {
					echo '<tr>';
					echo '<td align="right" valign="top" class="pad-top10 pad-btm10 pad-rgt10">';
					echo '<h2>'.ucwords(tranText('outdoors facilities')).':</h2>';
					echo '</td>';
					echo '<td valign="top" class="pad-top10 pad-btm10">';
					echo '<div class="list-1">';
					echo '<ul>';
					for($i = 0; $i < $total_featrures; $i++) {
						$feature_name = $arr[$i]['property_features_name'];
						echo "<li>".ucwords(tranText($feature_name))."</li>";
					}
					echo '</ul>';
					echo '<div class="clearfix">&nbsp;</div>';
					echo '<div align="left" class="pad-top10 pad-btm10">'.$outside_note.'</div>';
					echo '</div>';
					echo '</td>';
					echo '</tr>';
				}

				//Activities Nearby
				$feature_group_ids = "6";
				$feature_name_no = "'Is linen provided?', 'Are towels provided?', 'Are beach towels provided?'";
				$sql 				= "SELECT * FROM " . TABLE_PROPERTY_FEATURES . " WHERE property_features_name NOT IN (" .$feature_name_no. ") AND property_features_id IN (" .$feature_ids. ") AND property_features_group_id IN (" .$feature_group_ids. ") ORDER BY property_features_name";
				$rs 				= $this->dbObj->createRecordset($sql);
				$arr 				= $this->dbObj->fetchAssoc($rs);
				$total_featrures 	= count($arr);
				if($total_featrures > 0) {
					echo '<tr>';
					echo '<td align="right" valign="top" class="pad-top10 pad-btm10 pad-rgt10">';
					echo '<h2>'.ucwords(tranText('activities nearby')).':</h2>';
					echo '</td>';
					echo '<td valign="top" class="pad-top10 pad-btm10">';
					echo '<div class="list-1">';
					echo '<ul>';
					for($i = 0; $i < $total_featrures; $i++) {
						$feature_name = $arr[$i]['property_features_name'];
						echo "<li>".ucwords(tranText($feature_name))."</li>";
					}
					echo '</ul>';
					echo '<div class="clearfix">&nbsp;</div>';
					echo '<div align="left" class="pad-top10 pad-btm10">'.$activities_note.'</div>';
					echo '</div>';
					echo '</td>';
					echo '</tr>';
				}

			}

			//Bedroom
			$bedArr = $this->fun_getPropertyBedAllInfoArr($property_id);
			if(is_array($bedArr) && count($bedArr) > 0) {
				$total_beds 	= $bedArr[0]['total_beds'];
				$ensuite_beds 	= $bedArr[0]['ensuite_beds'];
				$scomfort_beds 	= $bedArr[0]['scomfort_beds'];
				$double_beds 	= $bedArr[0]['double_beds'];
				$single_beds 	= $bedArr[0]['single_beds'];
				$sofa_beds 		= $bedArr[0]['sofa_beds'];
				$cots 			= $bedArr[0]['cots'];
				$notes 			= $bedArr[0]['notes'];
				echo '<tr>';
				echo '<td align="right" valign="top" class="pad-top10 pad-btm10 pad-rgt10">';
				echo '<h2>'.ucwords(tranText('bedrooms')).':</h2>';
				echo '</td>';
				echo '<td valign="top" class="pad-top10 pad-btm10 clearfix">';
				echo $total_beds.' Bedroom(s), ';
				if($scomfort_beds !='')
					echo $scomfort_beds.' Sleeps<br>';
				if($ensuite_beds > 0)
					echo 'Number of en-suite - '.$ensuite_beds.'<br>';
				if($double_beds > 0)
					echo 'Number of double beds - '.$double_beds.'<br>';
				if($single_beds > 0)
					echo 'Number of single beds - '.$single_beds.'<br>';
				if($sofa_beds > 0)
					echo 'Number of sofa beds - '.$sofa_beds.'<br>';
				if($cots > 0)
					echo 'Number of cots - '.$cots.'<br>';
				if($notes !='')
					echo '<br><br>'.$notes.'<br>';
				echo '</td>';
				echo '</tr>';
			}
			
			//Bathroom
			$bathArr = $this->fun_getPropertyBathAllInfoArr($property_id);

			if(is_array($bathArr) && count($bathArr) > 0) {
				$total_bathrooms 	= $bathArr[0]['total_bathrooms'];
				$ensuite_baths 		= $bathArr[0]['ensuite_baths'];
				$shower_baths 		= $bathArr[0]['shower_baths'];
				$baths 				= $bathArr[0]['baths'];
				$toilets 			= $bathArr[0]['toilets'];
				$notes 				= $bathArr[0]['notes'];

				echo '<tr>';
				echo '<td align="right" valign="top" class="pad-top10 pad-btm10 pad-rgt10">';
				echo '<h2>'.ucwords(tranText('bathrooms')).':</h2>';
				echo '</td>';
				echo '<td valign="top" class="pad-top10 pad-btm10">';
				echo $total_bathrooms.' Bathroom(s)<br>';
				if($ensuite_baths > 0)
					echo 'Number of en-suite - '.$ensuite_baths.'<br>';
				if($shower_baths > 0)
					echo 'Number of shower baths - '.$shower_baths.'<br>';
				if($baths > 0)
					echo 'Number of baths - '.$baths.'<br>';
				if($toilets > 0)
					echo 'Number of toilets - '.$toilets.'<br>';
				if($notes !='')
					echo '<br>'.$notes.'<br>';
				echo '</td>';
				echo '</tr>';
			}
			echo '</table>';
		} else {
			return false;
		}
	}
/*
* Property Accommodation / Aminities specific functions : end here
*/

/*
* Property Special Requirements specific functions : start here
*/

	function fun_getPropertyArrByPropertySRequirment( $property_requirement_id = '' ) {
		if ( $property_requirement_id == '' ) {
			return false;
		} else {
			$sql = "SELECT A.property_id AS property_id 
			FROM  " . TABLE_PROPERTY . " AS A
			INNER JOIN " . TABLE_PROPERTY_SPECIAL_REQUIREMENTS_RELATIONS . " AS B ON B.property_id = A.property_id
			WHERE ((B.srequirement_ids like '%,".$property_requirement_id .",%') OR (B.srequirement_ids like '".$property_requirement_id .",%') OR (B.srequirement_ids like '%,".$property_requirement_id ."')) AND A.active='1'";

			$rs = $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);
				return $arr;
			}
			else{
				return false;
			}
		}
	}

	// Function for creating array for property_type along with total no. of actice property
	function fun_getPropertyRequirementArrayWithTotalProp($property_requirement_id=''){		
		$propertyRequirementArray 	= array();		
		if($property_requirement_id !="") {

        	//Find all query
            $sqlPropRequirement = "SELECT * FROM " .TABLE_PROPERTY_SPECIAL_REQUIREMENTS. " WHERE property_srequirements_id='".$property_requirement_id."' ORDER BY property_srequirements_name";
		} else {
            $sqlPropRequirement = "SELECT * FROM " .TABLE_PROPERTY_SPECIAL_REQUIREMENTS. " ORDER BY property_srequirements_name";
		}

		$rsPropRequirement		= $this->dbObj->createRecordset($sqlPropRequirement);
		if($this->dbObj->getRecordCount($rsPropRequirement) > 0) {
			$arrRequirement	= $this->dbObj->fetchAssoc($rsPropRequirement);
			for($i = 0; $i < count($arrRequirement); $i++) {
				$requirement_id 							= $arrRequirement[$i]['property_srequirements_id'];
				$requirement_name							= $arrRequirement[$i]['property_srequirements_name'];
				$total_property 							= $this->fun_countPropertyByPropertyRequirement($requirement_id);
				$propertyRequirementArray[$i]['property_requirement_id'] 	= $requirement_id;
				$propertyRequirementArray[$i]['property_requirement_name']	= $requirement_name;
				$propertyRequirementArray[$i]['total_properties']		= $total_property;
			}
			return $propertyRequirementArray;
		}
	}

	function fun_countPropertyByPropertyRequirement( $property_requirement_id = '' ) {
		if ( $property_requirement_id == '' ) {
			return false;
		} else {
			$sql = "SELECT COUNT(*) total_result 
			FROM  " . TABLE_PROPERTY . " AS A
			INNER JOIN " . TABLE_PROPERTY_SPECIAL_REQUIREMENTS_RELATIONS . " AS B ON B.property_id = A.property_id
			WHERE ((B.srequirement_ids like '%,".$property_requirement_id .",%') OR (B.srequirement_ids like '".$property_requirement_id .",%') OR (B.srequirement_ids like '%,".$property_requirement_id ."')) AND A.active='1'";

			$rs = $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);
				$total_result = $arr[0]['total_result'];
			}
			else{
				$total_result = 0;
			}
			return $total_result;
		}
	}

	// Function for creating array for property_type along with total no. of actice property
	function fun_getPropertyRequirementArrayRefineByCriteria($txtcountryids = '', $txtareaids = '', $txtregionids = '', $txtlocationids = '', $txtFromUnixTime = '', $txtToUnixTime = '', $txtpropertytypeids = '', $txtneedsleep = '', $txtonlybed = '', $txttotalbed = '', $txtholidaytypeids = '', $txtkitchenlinenids = '', $txtoutsideids = '', $txtactivitynearbyids = '', $txtheatingcoolingids = '', $txtenterainmentids = '', $txtlocationviewids = '', $txtserviceids = '', $txtgeneralids = '', $parameter = '') {
		$property_ids = $this->fun_getPropertyIdsByRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids,  $txtFromUnixTime, $txtToUnixTime, $txtpropertytypeids, $txtneedsleep, $txtonlybed, $txttotalbed, $txtholidaytypeids, $txtkitchenlinenids, $txtoutsideids, $txtactivitynearbyids, $txtheatingcoolingids, $txtenterainmentids, $txtlocationviewids, $txtserviceids, $txtgeneralids, $parameter);
		$propertyRequirementArray 	= array();		
		if(isset($property_ids) && $property_ids !="") {
			$sql = "SELECT B.srequirement_ids AS srequirement_ids
			FROM " . TABLE_PROPERTY . " AS A 
			LEFT JOIN " . TABLE_PROPERTY_SPECIAL_REQUIREMENTS_RELATIONS . " AS B ON B.property_id = A.property_id 
			WHERE A.active='1' AND A.property_id IN (".$property_ids.")";
			$rs	= $this->dbObj->createRecordset($sql);

			$srequirement_ids = "";
			if($this->dbObj->getRecordCount($rs) > 0) {
				$arr	= $this->dbObj->fetchAssoc($rs);
				for($i = 0; $i < count($arr); $i++) {
					if($arr[$i]['srequirement_ids'] !="") {
						$srequirement_ids .= $arr[$i]['srequirement_ids'].",";
					}
				}
				$srequirement_ids = (substr($srequirement_ids, strlen($srequirement_ids)-1, strlen($srequirement_ids)) == ",")?substr($srequirement_ids, 0, strlen($srequirement_ids)-1):$srequirement_ids;
			}
			if($srequirement_ids !="") {
				$sqlPropRequirement = "SELECT * FROM " . TABLE_PROPERTY_SPECIAL_REQUIREMENTS. " WHERE property_srequirements_id IN (".$srequirement_ids.") ORDER BY property_srequirements_name";
			} else {
				$sqlPropRequirement = "SELECT * FROM " .TABLE_PROPERTY_SPECIAL_REQUIREMENTS. " ORDER BY property_srequirements_name";
			}
		} else {
			$sqlPropRequirement = "SELECT * FROM " .TABLE_PROPERTY_SPECIAL_REQUIREMENTS. " ORDER BY property_srequirements_name";
		}

		$rsPropRequirement		= $this->dbObj->createRecordset($sqlPropRequirement);
		if($this->dbObj->getRecordCount($rsPropRequirement) > 0) {
			$arrRequirement	= $this->dbObj->fetchAssoc($rsPropRequirement);
			for($i = 0; $i < count($arrRequirement); $i++) {
				$requirement_id 							= $arrRequirement[$i]['property_srequirements_id'];
				$requirement_name							= $arrRequirement[$i]['property_srequirements_name'];
				$total_property 							= $this->fun_countPropertyByPropertyRequirement($requirement_id);
				$propertyRequirementArray[$i]['property_requirement_id'] 	= $requirement_id;
				$propertyRequirementArray[$i]['property_requirement_name']	= $requirement_name;
				$propertyRequirementArray[$i]['total_properties']		= $total_property;
			}
			return $propertyRequirementArray;
		}
	}

	// Function for creating array for property_type along with total no. of actice property
	function fun_getRefinePropertyRequirementArrayWithTotalProp($txtcountryids = '', $txtareaids = '', $txtregionids = '', $txtlocationids = '',  $txtFromUnixTime = '', $txtToUnixTime = '', $txtpropertytypeids = '', $txtneedsleep = '', $txtonlybed = '', $txttotalbed = '', $txtholidaytypeids = '', $txtkitchenlinenids = '', $txtoutsideids = '', $txtactivitynearbyids = '', $txtheatingcoolingids = '', $txtenterainmentids = '', $txtlocationviewids = '', $txtserviceids = '', $txtgeneralids = '', $parameter = ''){		
		$propertyRequirementArray 	= array();		
		$sqlPropRequirement = "SELECT * FROM " .TABLE_PROPERTY_SPECIAL_REQUIREMENTS. " ORDER BY property_srequirements_name";

		$rsPropRequirement		= $this->dbObj->createRecordset($sqlPropRequirement);
		if($this->dbObj->getRecordCount($rsPropRequirement) > 0) {
			$arrRequirement	= $this->dbObj->fetchAssoc($rsPropRequirement);
			for($i = 0; $i < count($arrRequirement); $i++) {
				$requirement_id 							= $arrRequirement[$i]['property_srequirements_id'];
				$requirement_name							= $arrRequirement[$i]['property_srequirements_name'];
				$total_property 							= $this->fun_countRefinePropertyByPropertyRequirement($requirement_id, $txtcountryids, $txtareaids, $txtregionids, $txtlocationids,  $txtFromUnixTime, $txtToUnixTime, $txtpropertytypeids, $txtneedsleep, $txtonlybed, $txttotalbed, $txtholidaytypeids, $txtkitchenlinenids, $txtoutsideids, $txtactivitynearbyids, $txtheatingcoolingids, $txtenterainmentids, $txtlocationviewids, $txtserviceids, $txtgeneralids, $parameter);
				$propertyRequirementArray[$i]['property_requirement_id'] 	= $requirement_id;
				$propertyRequirementArray[$i]['property_requirement_name']	= $requirement_name;
				$propertyRequirementArray[$i]['total_properties']		= $total_property;
			}
			return $propertyRequirementArray;
		}
	}

	function fun_countRefinePropertyByPropertyRequirement( $property_requirement_id = '', $txtcountryids = '', $txtareaids = '', $txtregionids = '', $txtlocationids = '',  $txtFromUnixTime = '', $txtToUnixTime = '', $txtpropertytypeids = '', $txtneedsleep = '', $txtonlybed = '', $txttotalbed = '', $txtholidaytypeids = '', $txtkitchenlinenids = '', $txtoutsideids = '', $txtactivitynearbyids = '', $txtheatingcoolingids = '', $txtenterainmentids = '', $txtlocationviewids = '', $txtserviceids = '', $txtgeneralids = '', $parameter = '') {
		if ( $property_requirement_id == '' ) {
			return false;
		} else {
			$sql = "SELECT COUNT(*) total_result 
			FROM  " . TABLE_PROPERTY . " AS A
			INNER JOIN " . TABLE_PROPERTY_SPECIAL_REQUIREMENTS_RELATIONS . " AS B ON B.property_id = A.property_id
			WHERE ((B.srequirement_ids like '%,".$property_requirement_id .",%') OR (B.srequirement_ids like '".$property_requirement_id .",%') OR (B.srequirement_ids like '%,".$property_requirement_id ."')) AND A.active='1'";

			$rs = $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);
				$refine_prop = $this->fun_countRefineProperty($txtcountryids, $txtareaids, $txtregionids, $txtlocationids,  $txtFromUnixTime, $txtToUnixTime, $txtpropertytypeids, $txtneedsleep, $txtonlybed, $txttotalbed, $txtholidaytypeids, $txtkitchenlinenids, $txtoutsideids, $txtactivitynearbyids, $txtheatingcoolingids, $txtenterainmentids, $txtlocationids, $txtserviceids, $txtgeneralids, $parameter);
				if(((int)$arr[0]['total_result'] > (int)$refine_prop) && ($refine_prop > 0) ) {
					$total_result = $refine_prop;
				} else {
					$total_result = $arr[0]['total_result'];
				}
			}
			else{
				$total_result = 0;
			}
			return $total_result;
		}
	}

	// Function for creating property Special Requirements Print section
	function fun_createPropertySRequirements4PropertyPrint($property_id){		
		$SRequirementArr	= $this->fun_getPropertySRequirementsArr($property_id);
		$srequirement_ids 	= $SRequirementArr[0]['srequirement_ids'];
		$srequirement_notes	= $SRequirementArr[0]['srequirement_notes'];
		if(isset($srequirement_ids) && $srequirement_ids != "") {
            $strHTML = "";
			$srequirementArr = explode(",", $srequirement_ids);
			$sql 				= "SELECT * FROM " . TABLE_PROPERTY_SPECIAL_REQUIREMENTS . " WHERE property_srequirements_id IN (".$srequirement_ids. ") ORDER BY property_srequirements_name";
			$rs 				= $this->dbObj->createRecordset($sql);
			$arr 				= $this->dbObj->fetchAssoc($rs);
			$total_srequirement	= count($arr);
            $strHTML .= "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
            $strHTML .= "<tr>";
            $strHTML .= "<td valign=\"top\" align=\"left\">";
            $strHTML .= "<table width=\"150\" cellspacing=\"0\" cellpadding=\"0\">";
            $strHTML .= "<tr><td><strong>Special requirements</strong></td></tr>";

			if($total_srequirement > 0) {
				if($total_srequirement % 2 == 0) {
					//even condition
					$first_cell_num = $total_srequirement - ((int)($total_srequirement)/2);
				} else {
					//odd condition
					$first_cell_num = $total_srequirement - ((int)($total_srequirement-1)/2);
				}
				for($i = 0; $i < $first_cell_num; $i++) {
					$srequirement_name = $arr[$i]['property_srequirements_name'];
                    $strHTML .= "</tr><tr><td>".ucwords($srequirement_name)."</td></tr>";
				}
			}
			
            $strHTML .= "</table>";
            $strHTML .= "</td>";
//            $strHTML .= "<td><img src=\"".SITE_IMAGES."spacer.gif\" alt=\"Summary\" width=\"30\" height=\"30\" /></td>";
            $strHTML .= "<td valign=\"top\" align=\"left\">";
            $strHTML .= "<table width=\"190\" cellspacing=\"0\" cellpadding=\"0\">";
            $strHTML .= "<tr><td>&nbsp;</td></tr>";
			if($total_srequirement > 0) {
				for($j = $first_cell_num; $j < $total_srequirement; $j++) {
					$srequirement_name = $arr[$j]['property_srequirements_name'];
                    $strHTML .= "</tr><tr><td>".ucwords($srequirement_name)."</td></tr>";
				}
			}
            $strHTML .= "</table>";
            $strHTML .= "</td>";
            $strHTML .= "<td width=\"55%\">&nbsp;</td>";
            $strHTML .= "</tr>";
            $strHTML .= "<tr><td colspan=\"3\">".$srequirement_notes."</td></tr>";
            $strHTML .= "</table>";
			return $strHTML;
		} else {
			return false;
		}
	}

	// Function for creating property features section
	function fun_createPropertySRequirements4PropertyPriview($property_id){		
		$SRequirementArr	= $this->fun_getPropertySRequirementsArr($property_id);
		$srequirement_ids 	= $SRequirementArr[0]['srequirement_ids'];
		$srequirement_notes	= $SRequirementArr[0]['srequirement_notes'];
		if(isset($srequirement_ids) && $srequirement_ids != "") {

			$srequirementArr = explode(",", $srequirement_ids);
			$sql 				= "SELECT * FROM " . TABLE_PROPERTY_SPECIAL_REQUIREMENTS . " WHERE property_srequirements_id IN (".$srequirement_ids. ") ORDER BY property_srequirements_name";
			$rs 				= $this->dbObj->createRecordset($sql);
			$arr 				= $this->dbObj->fetchAssoc($rs);
			$total_srequirement	= count($arr);
			echo "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">";
			echo "<tr>";
			echo "<td valign=\"Top\" align=\"left\">";
			echo "<table width=\"190\" cellspacing=\"0\" cellpadding=\"0\">";
			echo "<tr><td class=\"owner-headings1 pad-btm8 dash-btm\">Special requirements</td></tr>";

			if($total_srequirement > 0) {
				if($total_srequirement % 2 == 0) {
					//even condition
					$first_cell_num = $total_srequirement - ((int)($total_srequirement)/2);
				} else {
					//odd condition
					$first_cell_num = $total_srequirement - ((int)($total_srequirement-1)/2);
				}
				for($i = 0; $i < $first_cell_num; $i++) {
					$srequirement_name = $arr[$i]['property_srequirements_name'];
					echo "</tr><tr class=\"Summary\"><td>".ucwords($srequirement_name)."</td></tr>";
				}
			}
			
			echo "</table>";
			echo "</td>";
			echo "<td><img src=\"".SITE_IMAGES."spacer.gif\" alt=\"Summary\" width=\"30\" height=\"30\" /></td>";
			echo "<td valign=\"Top\" align=\"left\">";
			echo "<table width=\"190\" cellspacing=\"0\" cellpadding=\"0\">";
			echo "<tr><td colspan=\"2\" class=\"pad-top8 dash-btm\">&nbsp;</td></tr>";

			if($total_srequirement > 0) {
				for($j = $first_cell_num; $j < $total_srequirement; $j++) {
					$srequirement_name = $arr[$j]['property_srequirements_name'];
					echo "</tr><tr class=\"Summary\"><td>".ucwords($srequirement_name)."</td></tr>";
				}
			}
			echo "</table>";
			echo "</td>";
			echo "</tr>";
			echo "<tr><td class=\"pad-top18 editor-txt\" colspan=\"3\">".$srequirement_notes."</td></tr>";
			echo "</table>";
		} else {
			return false;
		}
	}

	// Function to get property special requirements array
	function fun_getPropertySRequirementsArr($property_id = ''){	
		if($property_id == ''){
			return false;
		} else {
			if(($srequirements_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_SPECIAL_REQUIREMENTS_RELATIONS , " WHERE property_id='".$property_id."'")) && (is_array($srequirements_array))){
				return $srequirements_array;
			} else {
				return false;
			}
		}
	}

	// Function for creating property Is It Suitable section
	function fun_createPropertyIsSuitable($property_id = ''){		
		$sqlIsSuitableIds 	= "SELECT srequirement_ids FROM " . TABLE_PROPERTY_SPECIAL_REQUIREMENTS_RELATIONS . " WHERE property_id='".$property_id."'";
		$rsIsSuitableIds 	= $this->dbObj->createRecordset($sqlIsSuitableIds);
		$arrIsSuitableIds 	= $this->dbObj->fetchAssoc($rsIsSuitableIds);

		foreach($arrIsSuitableIds as $val){
			$isSuitableIdsArr = explode(",", $val['srequirement_ids']);
		}

		echo "<table width=\"190\" cellpadding=\"0\" cellspacing=\"0\">";
		echo "<tr><td class=\"owner-headings1 pad-top2 pad-btm8 dash-btm\">Is it suitable?</td></tr>";
//		$sql = "SELECT * FROM " . TABLE_PROPERTY_SPECIAL_REQUIREMENTS . " WHERE property_srequirements_id IN (1,2,6,7,9,12,13,14,15) ORDER BY property_srequirements_name";
		$sql = "SELECT * FROM " . TABLE_PROPERTY_SPECIAL_REQUIREMENTS . " ORDER BY property_srequirements_name";
		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr = $this->dbObj->fetchAssoc($rs);
			$i = 0;
			foreach($arr as $value){
				if($i%1 == 0){
					echo "</tr><tr class=\"Summary\">";
				}

				if(is_array($isSuitableIdsArr) && in_array($value['property_srequirements_id'], $isSuitableIdsArr)) {
					echo "<td><p class=\"SummaryTick\">" .ucwords($value['property_srequirements_name']). "</p></td>";
				} else {
					echo "<td><p class=\"SummaryCross\">" .ucwords($value['property_srequirements_name']). "</p></td>";
				}
				$i++;
			}
		}
		else{
			echo "<tr class=\"Summary\"><td>&nbsp;</td></tr>";
		}
		echo "</table>";
	}

	// Function for creating property Special requirements section
	function fun_createPropertySpecialRequirements($property_id = ''){		
		$sqlRequirementsIds = "SELECT srequirement_ids FROM " . TABLE_PROPERTY_SPECIAL_REQUIREMENTS_RELATIONS . " WHERE property_id='".$property_id."'";
		$rsRequirements = $this->dbObj->createRecordset($sqlRequirementsIds);
		$arrRequirements = $this->dbObj->fetchAssoc($rsRequirements);
		$requirementArr = explode(",", $arrRequirements[0]['srequirement_ids']);

		$sql = "SELECT * FROM " . TABLE_PROPERTY_SPECIAL_REQUIREMENTS . "  ORDER BY property_srequirements_name";
		$strHTML = "";
		$strHTML .= "\n<table width=\"690\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"font12\"><tbody>\n";
		$strHTML .= "<tr><td width=\"20\">&nbsp;</td><td width=\"240\">&nbsp;</td><td width=\"20\">&nbsp;</td><td width=\"230\">&nbsp;</td><td width=\"20\">&nbsp;</td><td width=\"160\">&nbsp;</td>\n";
		$rs = $this->dbObj->createRecordset($sql);
		$arr = $this->dbObj->fetchAssoc($rs);
		$i = 0;
		foreach($arr as $value){
			if($i%3 == 0){
				$strHTML .= "</tr><tr>";
			}
			if(array_search($value['property_srequirements_id'], $requirementArr) === false){
				$checked = "";
			}
			else{
				$checked = "checked";
			}
			$strHTML .= "<td align=\"left\" valign=\"top\" style=\"padding-bottom:10px;\"><input type=\"checkbox\" name='txtSRequirements[]' value='". $value['property_srequirements_id'] ."' class=\"RegFormChkBox\" " .$checked. "></td>";
			$strHTML .= "<td align=\"left\" valign=\"top\" style=\"padding-bottom:10px;\"> " .ucwords($value['property_srequirements_name']). " </td>";
			$i++;
		}
		$strHTML .= "</tbody></table>";
		echo $strHTML;
	}

/*
* Property Special Requirements specific functions : end here
*/

/*
* Property reviews specific functions : start here
*/

	function fun_addPropertyReview($review_id, $property_id, $property_rating = '', $review_title = '', $review_txt = '', $user_fname = '', $user_lname = '', $user_email = '', $user_country = '', $status = '') {
		if($property_id == '') {
			return false;
		} else {
			$cur_unixtime 	= time ();
			if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !=""){
				$cur_user_id 	= $_SESSION['ses_admin_id'];
			} else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !="") {
				$cur_user_id 	= $_SESSION['ses_modarator_id'];
			} else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !="") {
				$cur_user_id 	= $_SESSION['ses_user_id'];
			} else {
				$cur_user_id 	= "";
			}

			if($review_id != ""){
				$sqlUpdateQuery = "UPDATE " . TABLE_PROPERTY_REVIEWS_RELATIONS . " SET 
				property_id = '".$property_id."',
				property_rating = '".$property_rating."',
				review_title = '".fun_db_input($review_title)."',
				review_txt = '".fun_db_input($review_txt)."',
				user_fname = '".$user_fname."',
				user_lname = '".$user_lname."',
				user_email = '".$user_email."',
				user_country = '".$user_country."',
				status = '".$status."',
				updated_on = '".$cur_unixtime."',
				updated_by = '".$cur_user_id."'
				WHERE review_id='".$review_id."'";
				$this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
				return true;
			} else {
				if($this->fun_verifyPropertyReviewUserEmail($property_id, $user_email) == true) {
				// do nothing
				
				} else {
					$strInsQuery = "INSERT INTO " . TABLE_PROPERTY_REVIEWS_RELATIONS . " 
					(review_id, property_id, property_rating, review_title, review_txt, user_fname, user_lname, user_email, user_country, status, active_on, active_by, created_on, created_by, updated_on, updated_by, active)
					VALUES(null, '".$property_id."', '".$property_rating."', '".fun_db_input($review_title)."', '".fun_db_input($review_txt)."', '".$user_fname."', '".$user_lname."', '".$user_email."', '".$user_country."', '".$status."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."', '0')";
					$this->dbObj->mySqlSafeQuery($strInsQuery);
				}
				return true;
			}
		}
	}

	//function to verify review email
	function fun_verifyPropertyReviewUserEmail($property_id, $strEmail){		
		$usersFound = false;
		$sqlCheck = "SELECT * FROM " . TABLE_PROPERTY_REVIEWS_RELATIONS . " WHERE user_email='".trim($strEmail)."' AND property_id='".$property_id."'";		
		if($this->fun_get_num_rows($sqlCheck) > 0){
			$usersFound = true;
		}
		return $usersFound;
	}

	// Function to add vote for property reviews
	function fun_addPropertyReviewVote($review_id, $vote_type, $user_id){	
		if(($review_id != '')&& ($vote_type != '') && ($user_id != '')){
			$cur_unixtime 	= time (); // Current time
			// Current User
			if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !="") {
				$cur_user_id 	= $_SESSION['ses_admin_id'];
			} else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !="") {
				$cur_user_id 	= $_SESSION['ses_modarator_id'];
			} else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !="") {
				$cur_user_id 	= $_SESSION['ses_user_id'];
			} else {
				$cur_user_id 	= "";
			}
			if(($review_vote_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_REVIEWVOTES_RELATIONS , " WHERE review_id='".(int)$review_id."' AND user_id='".(int)$user_id."'")) && (is_array($review_vote_array))){
			//Update the entry
				$sqlUpdate = "UPDATE " . TABLE_PROPERTY_REVIEWVOTES_RELATIONS . " SET review_vote_log ='".trim($vote_type)."', updated_on='".$cur_unixtime."', updated_by='".$cur_user_id."' WHERE review_id='".(int)$review_id."' AND user_id='".(int)$user_id."'";
				$this->dbObj->mySqlSafeQuery($sqlUpdate);
			}
			else{
			//add new entry
				$strInsQuery = "INSERT INTO " . TABLE_PROPERTY_REVIEWVOTES_RELATIONS . "(id, review_id, user_id, review_vote_log, created_on, created_by, updated_on, updated_by) ";
				$strInsQuery .= "VALUES (null, '".$review_id."', '".$user_id."', '".$vote_type."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."')";
				$this->dbObj->mySqlSafeQuery($strInsQuery);
			}

		} else {
			return false;
		}
	}

	// Function to get property reviews array
	function fun_getPropertyReviewsArr($property_id = ''){	
		if($property_id == ''){
			return false;
		} else {
			if(($reviews_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_REVIEWS_RELATIONS , " WHERE property_id='".$property_id."' AND status ='2'")) && (is_array($reviews_array))){
				return $reviews_array;
			} else {
				return false;
			}
		}
	}

	// Function	for delete review
	function fun_delPropertyReview($review_id = ''){
		if($review_id == ''){
			return false;
		} else {
            $this->dbObj->deleteRow(TABLE_PROPERTY_REVIEWS_RELATIONS, "review_id", $review_id);
			return true;
		}
	}

	// Function for property review array
	function fun_getPendingApprovalPropertyReviewsArr($parameter=''){
		$sql = "SELECT 	A.review_id, 
						A.property_id,
						A.property_rating,
						A.review_title,
						A.user_fname,
						A.user_lname,
						A.user_email,
						A.user_country,
						A.status,
						B.status_name,
						A.created_on,
						A.active
				FROM " . TABLE_PROPERTY_REVIEWS_RELATIONS . " AS A
				INNER JOIN " . TABLE_PROPERTY_REVIEWS_STATUS . " AS B ON A.status = B.status_id 
				  ";
		if($parameter!=""){
			$sql .= $parameter;
		} else {
			$sql .= " ORDER BY A.property_id";		
		}
//		echo $sql;
		$rs = $this->dbObj->createRecordset($sql);
        return $arr = $this->dbObj->fetchAssoc($rs);
	}

/*
	// Function to get property reviews array
	function fun_getPropertyReviewsArr4PropertyPreview($property_id = ''){	
		if($property_id == ''){
			return false;
		} else {
			$sql = "SELECT A.review_id,
					A.property_id,
					A.user_id,
					A.review_title,
					A.review_txt,
					A.created_on,
					B.user_fname,
					B.user_lname,
					C.countries_name
					FROM ". TABLE_PROPERTY_REVIEWS_RELATIONS ." AS A
					INNER JOIN ". TABLE_USERS ." AS B ON B.user_id = A.user_id,
					". TABLE_COUNTRIES ." AS C
					WHERE A.property_id='".(int)$property_id."' AND C.countries_id = B.user_country 
					ORDER BY A.updated_on DESC";
			$rs = $this->dbObj->createRecordset($sql);
			$arr = $this->dbObj->fetchAssoc($rs);
			if(is_array($arr)){
				return $arr;
			} else {
				return false;
			}
		}
	}
*/
	// Function to get property reviews array
	function fun_getPropertyReviewsArr4PropertyPreview($property_id = '', $status = ''){	
		if($property_id == ''){
			return false;
		} else {
            $sql 	= "SELECT * FROM ". TABLE_PROPERTY_REVIEWS_RELATIONS ." WHERE property_id='".(int)$property_id."' AND status ='2' AND active ='1' ";
			if($status != "") {
				$sql 	.= "AND status ='".$status."' ";
			}
            $sql 	.= "ORDER BY updated_on DESC";
			$rs 	= $this->dbObj->createRecordset($sql);
			$arr 	= $this->dbObj->fetchAssoc($rs);
			if(is_array($arr)){
				return $arr;
			} else {
				return false;
			}
		}
	}

	function fun_createPropertyReviewAvgScore($property_id) {
		if($property_id == ''){
			return false;
		} else {
            $sql 	= "SELECT property_rating FROM ". TABLE_PROPERTY_REVIEWS_RELATIONS ." WHERE property_id='".(int)$property_id."' AND status ='2' AND active ='1' ";
			$rs 	= $this->dbObj->createRecordset($sql);
			$arr 	= $this->dbObj->fetchAssoc($rs);
			if(is_array($arr) && count($arr) > 0){
				$total_reviews 		= count($arr);
				$total_reviews_txt 	= ($total_reviews > 1)?$total_reviews." reviews":$total_reviews." review";
				$total_score 		= 0;
				foreach($arr as $value) {
					$total_score += (int)$value['property_rating'];
				}
				$avg_score = (int)($total_score/$total_reviews);
				$percent_score = round(((($total_score/$total_reviews)/5)*100), 1);
				echo "<span class=\"font14\">Average customer rating</span>";
				echo "<span class=\"pad-lft10 pad-top5\">";
				for ($k=0; $k < $avg_score; $k++ ) {
					echo "<img src=\"".SITE_IMAGES."star-rated.gif\" alt=\"yellow star\" /> ";
				}
				for ($l = $avg_score; $l < 5; $l++ ) {
					echo "<img src=\"".SITE_IMAGES."star-notrated.gif\" alt=\"yellow star\" /> ";
				}
				echo "</span>";
				if($total_reviews > 0 ) {
					echo "<span class=\"font11 pad-left3\">".$percent_score."% </span>(".$total_reviews_txt.")";
				} else {
					echo "<span class=\"pad-left3\"> Not yet reviewed</span>";
				}
			} else {
				return false;
			}
		}
	}

	function fun_createPropertyCustomerRating($property_id) {
		if($property_id == ''){
			return false;
		} else {
            $sql 	= "SELECT property_rating FROM ". TABLE_PROPERTY_REVIEWS_RELATIONS ." WHERE property_id='".(int)$property_id."' AND status ='2' AND active ='1' ";
			$rs 	= $this->dbObj->createRecordset($sql);
			$arr 	= $this->dbObj->fetchAssoc($rs);
			if(is_array($arr) && count($arr) > 0){
				$total_reviews 		= count($arr);
				$total_reviews_txt 	= ($total_reviews > 1)?$total_reviews." reviews":$total_reviews." review";
				$total_score 		= 0;
				foreach($arr as $value) {
					$total_score += (int)$value['property_rating'];
				}
				$avg_score = (int)($total_score/$total_reviews);
				$percent_score = round(((($total_score/$total_reviews)/5)*100), 1);
				echo "<div class=\"FloatLft\"><strong>Customer Reviews =</strong></div>";
				echo "<div class=\"FloatLft pad-lft10\">";
				for ($k=0; $k < $avg_score; $k++ ) {
					echo "<img src=\"".SITE_IMAGES."star-rated.gif\" alt=\"yellow star\" /> ";
				}
				for ($l = $avg_score; $l < 5; $l++ ) {
					echo "<img src=\"".SITE_IMAGES."star-notrated.gif\" alt=\"yellow star\" /> ";
				}
				echo "</div>";
				
			} else {
				echo "<div class=\"FloatLft\"><strong>Customer Reviews =</strong></div>";
				echo "<div class=\"FloatLft pad-lft10\">";
				for ($l = 0; $l < 5; $l++ ) {
					echo "<img src=\"".SITE_IMAGES."star-notrated.gif\" alt=\"yellow star\" /> ";
				}
				echo "</div>";
				//echo "<span class=\"pad-left3\"> Not yet reviewed</span>";
//				return false;
			}
		}
	}

	function fun_createPropertyCustomerReview($property_id) {
		if($property_id == ''){
			return false;
		} else {
            $sql 	= "SELECT property_rating FROM ". TABLE_PROPERTY_REVIEWS_RELATIONS ." WHERE property_id='".(int)$property_id."' AND status ='2' AND active ='1' ";
			$rs 	= $this->dbObj->createRecordset($sql);
			$arr 	= $this->dbObj->fetchAssoc($rs);
			if(is_array($arr) && count($arr) > 0){
				$total_reviews 		= count($arr);
				$total_reviews_txt 	= ($total_reviews > 1)?$total_reviews." reviews":$total_reviews." review";
				$total_score 		= 0;
				foreach($arr as $value) {
					$total_score += (int)$value['property_rating'];
				}
				$avg_score 		= (int)($total_score/$total_reviews);
				$percent_score 	= round(((($total_score/$total_reviews)/5)*100), 1);
				echo '<div id="review-icn1" class="FloatLft">';
				for ($k=0; $k < $avg_score; $k++ ) {
					echo '<img src="'.SITE_IMAGES.'star-rated1.gif" border="0" width="19" height="19">';
				}
				for ($l = $avg_score; $l < 5; $l++ ) {
					echo '<img src="'.SITE_IMAGES.'star-notrated1.gif" border="0" width="19" height="19">';
				}
				if($total_reviews > 0 ) {
					echo '<span class="font14 pad-lft5" style=" line-height:18px;" >('.$total_reviews.')</span>';
				} else {
					echo '<span class="font14 pad-lft5" style=" line-height:18px;" >(0)</span>';
				}
				echo '</div>';
			} else {
				echo '<div id="review-icn1" class="FloatLft">';
				for ($l = 0; $l < 5; $l++ ) {
					echo '<img src="'.SITE_IMAGES.'star-notrated1.gif" border="0" width="19" height="19">';
				}
				echo '<span class="font14 pad-lft5" style=" line-height:18px;" >(0)</span>';
				echo '</div>';
			}
		}
	}

	function fun_createPropertyCustomerWriteReview($property_id) {
		if($property_id == ''){
			return false;
		} else {
			$strHTML = '';
            $sql 	= "SELECT property_rating FROM ". TABLE_PROPERTY_REVIEWS_RELATIONS ." WHERE property_id='".(int)$property_id."' AND status ='2' AND active ='1' ";
			$rs 	= $this->dbObj->createRecordset($sql);
			$arr 	= $this->dbObj->fetchAssoc($rs);
			if(is_array($arr) && count($arr) > 0){

				$propLocInfoArr 	= $this->fun_getPropertyLocInfoArr($property_id);
				$fr_url = $this->fun_getPropertyFriendlyLink($property_id);
				if(isset($fr_url) && $fr_url != "") {
					$property_link 		= SITE_URL."vacation-rentals/".strtolower($fr_url);
				} else {
					if(isset($propLocInfoArr['location_name']) && $propLocInfoArr['location_name'] != "") {
						$property_link = SITE_URL."vacation-rentals/in.".str_replace(" ", "-", strtolower($propLocInfoArr['location_name']))."/".fill_zero_left($property_id, "0", (6-strlen($property_id)));
					} else {
						$property_link = SITE_URL."vacation-rentals/in.".str_replace(" ", "-", strtolower($propLocInfoArr['region_name']))."/".fill_zero_left($property_id, "0", (6-strlen($property_id)));
					}
				}
				$total_reviews 		= count($arr);
				$total_reviews_txt 	= ($total_reviews > 1)?$total_reviews." reviews":$total_reviews." review";
				$total_score 		= 0;
				foreach($arr as $value) {
					$total_score += (int)$value['property_rating'];
				}
				$avg_score = (int)($total_score/$total_reviews);
				$percent_score = round(((($total_score/$total_reviews)/5)*100), 1);
				if($total_reviews > 0 ) {
					$strHTML .= '<div class="clear" style="width:98px;" align="left"><div style="background-image:url('.SITE_IMAGES.'review-bacground.gif); display:block; width:98px; height:38px; line-height:38px; text-align:center;"><span class="review-count"><a href="'.$property_link.'#showSectionTop" class="blue-link">'.$total_reviews.'</a></span><span class="review-text"><a href="'.$property_link.'#showSectionTop" class="blue-link">Read<br>Reviews</a></span></div></div>';
				} else {
					$strHTML .= '';
				}
			} else {
				$strHTML .= '';
			}
			echo $strHTML;
		}
	}

	// This function will Return Review information in array with front end data	
	function fun_getPropertyReviewInfo($review_id){		
		$sql 	= "SELECT * FROM " . TABLE_PROPERTY_REVIEWS_RELATIONS . " WHERE review_id='".$review_id."'";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr 	= $this->dbObj->fetchAssoc($rs);
			return $arr[0];
		} else {
			return false;
		}
	}

	// Function to get property reviews Vote Info array
	function fun_getPropertyReviewsVoteInfo($review_id = ''){	
		if($review_id == ''){
			return false;
		} else {
			$sqlTotalVote 	= "SELECT COUNT(*) AS total_vote FROM ". TABLE_PROPERTY_REVIEWVOTES_RELATIONS ." WHERE review_id='".(int)$review_id."'";
			$rsTotalVote 	= $this->dbObj->createRecordset($sqlTotalVote);
			$arrTotalVote 	= $this->dbObj->fetchAssoc($rsTotalVote);
			if(is_array($arrTotalVote)){
				$reviewsVoteArr['total_vote'] = $arrTotalVote[0]['total_vote'];

				$sqlYesVote 	= "SELECT COUNT(*) AS total_yes_vote FROM ". TABLE_PROPERTY_REVIEWVOTES_RELATIONS ." WHERE review_id='".(int)$review_id."' AND review_vote_log='y'";
				$rsYesVote 		= $this->dbObj->createRecordset($sqlYesVote);
				$arrYesVote 	= $this->dbObj->fetchAssoc($rsYesVote);
				if(is_array($arrYesVote)) {
					$reviewsVoteArr['yes_vote'] = $arrYesVote[0]['total_yes_vote'];
				} else {
					$reviewsVoteArr['yes_vote'] = "0";
				}

				$sqlNoVote 	= "SELECT COUNT(*) AS total_no_vote FROM ". TABLE_PROPERTY_REVIEWVOTES_RELATIONS ." WHERE review_id='".(int)$review_id."' AND review_vote_log='n'";
				$rsNoVote 		= $this->dbObj->createRecordset($sqlNoVote);
				$arrNoVote 	= $this->dbObj->fetchAssoc($rsNoVote);
				if(is_array($arrNoVote)) {
					$reviewsVoteArr['no_vote'] = $arrNoVote[0]['total_no_vote'];
				} else {
					$reviewsVoteArr['no_vote'] = "0";
				}

				$sqlVoterId 	= "SELECT user_id FROM ". TABLE_PROPERTY_REVIEWVOTES_RELATIONS ." WHERE review_id='".(int)$review_id."'";
				$rsVoterId 		= $this->dbObj->createRecordset($sqlVoterId);
				$arrVoterIds 	= $this->dbObj->fetchAssoc($rsVoterId);
				
				foreach($arrVoterIds as $key => $value) {
					$arrVoterId[$key] = $value['user_id'];
				}
				
				if(is_array($arrVoterId)) {
					$reviewsVoteArr['voter_ids'] = $arrVoterId;
				} else {
					$reviewsVoteArr['voter_ids'] = "";
				}
				return	$reviewsVoteArr;
			} else {
				return false;
			}
		}
	}


/*
* Property reviews specific functions : end here
*/

/*
* Property Availablity specific functions : Start here
*/

	// Function for get property added date
	function fun_getPropertyAvailablityAddedDate($property_id){
		if($property_id ==""){
			return "";
		} else {
            $sql = "SELECT MIN(created_on) AS created_on FROM " . TABLE_PROPERTY_AVAILABILITY_RELATIONS . " WHERE property_id='".$property_id."'";
            $rs = $this->dbObj->createRecordset($sql);
            $arr = $this->dbObj->fetchAssoc($rs);
            return $arr[0]['created_on'];
        }
	}

	// Function for get property last updated date
	function fun_getPropertyAvailablityUpdatedDate($property_id){
		if($property_id ==""){
			return "";
		} else {
            $sql = "SELECT MAX(updated_on) AS updated_on FROM " . TABLE_PROPERTY_AVAILABILITY_RELATIONS . " WHERE property_id='".$property_id."'";
            $rs = $this->dbObj->createRecordset($sql);
            $arr = $this->dbObj->fetchAssoc($rs);
            return $arr[0]['updated_on'];
        }
	}

	// Function for creating array of property availability
	function fun_getPropertyAvailabilityArr($property_id, $year ='', $month ='', $day =''){		
		$sql = "SELECT 
				A.id,
				A.property_id,
				A.startdate,
				A.enddate,
				A.created_on,
				A.status
				FROM " . TABLE_PROPERTY_AVAILABILITY_RELATIONS . " AS A ";

		$sql .= "WHERE A.property_id ='".$property_id."' ";
		

		if($year !="" && $month =='' && $day =='') {
			$sDate = $year."-01-01";
			$eDate = $year."-12-31";
		} else if($year !="" && $month !='' && $day =='') {
			$sDate = $year."-".$month."-01";
			$eDate = $year."-".$month."-31";
		} else if ($year !="" && $month !='' && $day !='') {
			$sDate = $year."-".$month."-".$day;
			$eDate = $year."-".$month."-".$day;
		}
		
		if(isset($sDate) && ($sDate != "") && isset($eDate) && ($eDate != "")) {
			$sql .= " AND A.startdate >= '".$sDate."' AND A.enddate <= '".$eDate."' ";
		}
		$sql .= "ORDER BY A.startdate, A.enddate";		
		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			return $arr = $this->dbObj->fetchAssoc($rs);
		} else {
			return false;
		}
	}

	// Function for add / update property availablity
	function fun_addPropertyAvailablityDetails($property_id, $startDate, $endDate, $txtStatus){
		if(($property_id == "") || ($startDate == "") || ($endDate == "") || ($txtStatus == "")){
			return false;
		} else {
			$cur_unixtime 	= time (); // Current time
			// Current User
			if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !="") {
				$cur_user_id 	= $_SESSION['ses_admin_id'];
			} else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !="") {
				$cur_user_id 	= $_SESSION['ses_modarator_id'];
			} else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !="") {
				$cur_user_id 	= $_SESSION['ses_user_id'];
			} else {
				$cur_user_id 	= "";
			}
	
			// Posted data

            if(strtotime($startDate) < strtotime($endDate)) {
                $y2 			= date('Y', strtotime($endDate));
                $m2 			= date('m', strtotime($endDate));
                $d2 			= date('d', strtotime($endDate))-1;
                $startDate 		= date('Y-m-d', strtotime($startDate));
                $endDate 		= date('Y-m-d', strtotime($y2."-".$m2."-".$d2));
            } else {
                $startDate 		= date('Y-m-d', strtotime($startDate));
                $endDate 		= date('Y-m-d', strtotime($startDate));
            }

            $arr1['startdate'] 	= $startDate;
            $arr1['enddate'] 	= $endDate;
            $arr1['created_on'] = $cur_unixtime;
            $arr1['created_by'] = $cur_user_id;
            $arr1['updated_on'] = $cur_unixtime;
            $arr1['updated_by'] = $cur_user_id;
            $arr1['status'] 	= $txtStatus;

			$arrNewAvailablity	= array(); // create array of new updates
	
            if(isset($arr1) && is_array($arr1)) {
                array_push($arrNewAvailablity, $arr1);
            }

			// Step I : check database whether any privous related status available
			$sqlSdate 	= "SELECT * FROM " . TABLE_PROPERTY_AVAILABILITY_RELATIONS . " WHERE property_id='".(int)$property_id."'";
			$sqlSdate 	.= " AND ((startdate BETWEEN '" . $startDate . "' AND '" . $endDate . "') OR (enddate BETWEEN '" . $startDate . "' AND '" . $endDate . "') OR (startdate >='" . $startDate . "' AND enddate <='" . $endDate . "') OR (startdate <'" . $startDate . "' AND startdate <'" . $endDate . "' AND enddate >'" . $startDate . "'AND enddate >'" . $endDate . "'))";
			$sqlSdate 	.= " GROUP BY id";
	
			$rdoSdate = $this->dbObj->mySqlSafeQuery($sqlSdate);
			if(($this->dbObj->getRecordCount($rdoSdate))>0) { // falls with other status
				$rsAvailablity 	= $this->dbObj->createRecordset($sqlSdate);
				$arrAvailablity = $this->dbObj->fetchAssoc($rsAvailablity);
				$strAvailablityIds = "";
				// inserting in temp table
				foreach($arrAvailablity as $value) {
					$availablityId 		= $value['id'];
					$strAvailablityIds	.= ",'".$availablityId."'";
				}

				// delete previous relations
				$strAvailablityIds = substr($strAvailablityIds, 1, strlen($strAvailablityIds)); // ids
				$strDelAvailablityQuery = "DELETE FROM " . TABLE_PROPERTY_AVAILABILITY_RELATIONS . " WHERE id IN (".$strAvailablityIds.")";
				$this->dbObj->mySqlSafeQuery($strDelAvailablityQuery);
				//array function

				for($i=0; $i<count($arrAvailablity); $i++) {
					$sDate = date('Y-m-d', strtotime($arrAvailablity[$i]['startdate']));
					$eDate = date('Y-m-d', strtotime($arrAvailablity[$i]['enddate']));
					$createdOn = $arrAvailablity[$i]['created_on'];
					$createdBy = $arrAvailablity[$i]['created_by'];
					$updatedOn = $cur_unixtime;
					$updatedBy = $cur_user_id;
					$statusAva = $arrAvailablity[$i]['status'];
				
					//Case I: When sDate < startDate and eDate > endDate : UPPER LIMIT
					// in this case only one value will be there but now it will split 
					if($sDate < $startDate && $eDate > $endDate) {
                        $y1 = date('Y', strtotime($startDate));
                        $m1 = date('m', strtotime($startDate));
                        $d1 = date('d', strtotime($startDate))-1;
                        $strDayBeforNSDate = date('Y-m-d', strtotime($y1."-".$m1."-".$d1)); //one day befor from new start date//
                
                        $y2 = date('Y', strtotime($endDate));
                        $m2 = date('m', strtotime($endDate));
                        $d2 = date('d', strtotime($endDate))+1;
                        $strDayAfterNEDate = date('Y-m-d', strtotime($y2."-".$m2."-".$d2)); //one day after from new end date//
            
                        $arr1['startdate'] 	= $sDate;
                        $arr1['enddate'] 	= $strDayBeforNSDate;
                        $arr1['created_on'] = $createdOn;
                        $arr1['created_by'] = $createdBy;
                        $arr1['updated_on'] = $cur_unixtime;
                        $arr1['updated_by'] = $cur_user_id;
                        $arr1['status'] 	= $statusAva;
            
                        $arr2['startdate'] 	= $strDayAfterNEDate;
                        $arr2['enddate'] 	= $eDate;
                        $arr2['created_on'] = $createdOn;
                        $arr2['created_by'] = $createdBy;
                        $arr2['updated_on'] = $cur_unixtime;
                        $arr2['updated_by'] = $cur_user_id;
                        $arr2['status'] 	= $statusAva;
            
                        array_push($arrNewAvailablity, $arr1);
                        array_push($arrNewAvailablity, $arr2);
					}
                    //Ok
					//Case II: When sDate == startDate and eDate > endDate : UPPER LIMIT LEFT EQUAL
					// in this case only one value will be there but now it will split 
					else if($sDate == $startDate && $eDate > $endDate) {
                        $y2 = date('Y', strtotime($endDate));
                        $m2 = date('m', strtotime($endDate));
                        $d2 = date('d', strtotime($endDate))+1;
                        $strDayAfterNEDate = date('Y-m-d', strtotime($y2."-".$m2."-".$d2)); //one day after from new end date//
				
                        $arr2['startdate'] 	= $strDayAfterNEDate;
                        $arr2['enddate'] 	= $eDate;
                        $arr2['created_on'] = $createdOn;
                        $arr2['created_by'] = $createdBy;
                        $arr2['updated_on'] = $cur_unixtime;
                        $arr2['updated_by'] = $cur_user_id;
                        $arr2['status'] 	= $statusAva;

                        array_push($arrNewAvailablity, $arr2);
					}
					//Case III: When sDate < startDate and eDate == endDate : UPPER LIMIT
					// in this case only one value will be there but now it will split 
					else if($sDate < $startDate && $eDate == $endDate){
                        $y1 = date('Y', strtotime($startDate));
                        $m1 = date('m', strtotime($startDate));
                        $d1 = date('d', strtotime($startDate))-1;
                        $strDayBeforNSDate = date('Y-m-d', strtotime($y1."-".$m1."-".$d1)); //one day befor from new start date//
                
                        $arr1['startdate'] 	= $sDate;
                        $arr1['enddate'] 	= $strDayBeforNSDate;
                        $arr1['created_on'] = $createdOn;
                        $arr1['created_by'] = $createdBy;
                        $arr1['updated_on'] = $cur_unixtime;
                        $arr1['updated_by'] = $cur_user_id;

                        $arr1['status'] 	= $statusAva;
                        array_push($arrNewAvailablity, $arr1);
					}
					//Case IV: When sDate > startDate and sDate < endDate and eDate > startDate and eDate > endDate : LEFT HAND LIMIT
					// in this case only sDate will sift forward
					else if($sDate > $startDate && $sDate < $endDate && $eDate > $startDate && $eDate > $endDate){
                        $y1 = date('Y', strtotime($endDate));
                        $m1 = date('m', strtotime($endDate));
                        $d1 = date('d', strtotime($endDate))+1;
                        $strDayAfterNEDate = date('Y-m-d', strtotime($y1."-".$m1."-".$d1)); //one day after from new end date//
                        $arr1['startdate'] 	= $strDayAfterNEDate;
                        $arr1['enddate'] 	= $eDate;
                        $arr1['created_on'] = $createdOn;
                        $arr1['created_by'] = $createdBy;
                        $arr1['updated_on'] = $cur_unixtime;
                        $arr1['updated_by'] = $cur_user_id;
                        $arr1['status'] 	= $statusAva;

                        array_push($arrNewAvailablity, $arr1);
					}
					//Case V: When sDate < startDate and sDate < endDate and eDate > startDate and eDate < endDate : LEFT HAND LIMIT
					// in this case only sDate will sift forward
					else if($sDate < $startDate && $sDate < $endDate && $eDate > $startDate && $eDate < $endDate){
                        $y1 = date('Y', strtotime($startDate));
                        $m1 = date('m', strtotime($startDate));
                        $d1 = date('d', strtotime($startDate))-1;
                        $strDayBeforNSDate = date('Y-m-d', strtotime($y1."-".$m1."-".$d1)); //one day befor from new start date//
                        $arr1['startdate'] 	= $sDate;
                        $arr1['enddate'] 	= $strDayBeforNSDate;
                        $arr1['created_on'] = $createdOn;
                        $arr1['created_by'] = $createdBy;
                        $arr1['updated_on'] = $cur_unixtime;
                        $arr1['updated_by'] = $cur_user_id;
                        $arr1['status'] 	= $statusAva;
                        array_push($arrNewAvailablity, $arr1);
					}
				}
            }

            foreach($arrNewAvailablity as $value){
                $startdate 		= $value['startdate'];
                $enddate		= $value['enddate'];
                $created_on 	= $value['created_on'];
                $created_by 	= $value['created_by'];
                $updated_on 	= $value['updated_on'];
                $updated_by 	= $value['updated_by'];
                $status			= $value['status'];
            
                $strInsAvailablityQuery = "INSERT INTO " . TABLE_PROPERTY_AVAILABILITY_RELATIONS . "(id, property_id, startdate, enddate, created_on, created_by, updated_on, updated_by, status) ";
                $strInsAvailablityQuery .= "VALUES 
                (null, '".$property_id."', '".$startdate."', '".$enddate."', '".$created_on."', '".$created_by."', '".$updated_on."', '".$updated_by."', '".$status."')
                ";
/*
echo $strInsAvailablityQuery;
die;
*/
                $this->dbObj->mySqlSafeQuery($strInsAvailablityQuery);
            }
			return true;
        }
    }
	
	//add property in your favourite
	function fun_addToFavourite($user_id, $property_id){
		$cur_unixtime = time();
		$this->dbObj->insertFields(TABLE_USER_FAVOURITE_PROPERTIES, array("user_id", "property_id", "created_on", "created_by", "updated_on", "updated_by"), array($user_id, $property_id, $cur_unixtime, $user_id, $cur_unixtime, $user_id));
		$lastInsertId = $this->dbObj->fun_db_last_inserted_id();
		return $lastInsertId;
	}
	
	//delete property from your favourite
	function fun_removeFavourite($user_id, $property_id){
		$this->dbObj->deleteRow(TABLE_USER_FAVOURITE_PROPERTIES, array("user_id", "property_id"), array($user_id, $property_id));
		return true;
	}
	
	//check Availability of favourite
	function fun_checkFavourite($user_id, $property_id){
		$strQuery 	= "SELECT id, property_id FROM " . TABLE_USER_FAVOURITE_PROPERTIES . " WHERE property_id = '".$property_id."' AND user_id='".$user_id."'";
		$rs 		= $this->dbObj->createRecordset($strQuery);
		if($this->dbObj->getRecordCount($rs) > 0) {
			$arr = $this->dbObj->fetchAssoc($rs);
			return $arr[0]['id'];
		} else {
			return false;
		}
	}
	
	
	
	/*
	* Property Availablity spific functions : end here
	*/

	/*
	* Property Enquiry spific functions : start here
	*/
	function fun_addPropertyEnquiry($enquiry_id = '', $phone ='', $adults = '', $childs = '', $infants = '', $arrival_date = '', $departure_date = '', $duration = '', $flexi_day = '', $enquiry_txt = '', $active = '') {
        $cur_unixtime 	= time ();
        if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !=""){
            $cur_user_id 	= $_SESSION['ses_admin_id'];
        } else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !="") {
            $cur_user_id 	= $_SESSION['ses_modarator_id'];
        } else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !="") {
            $cur_user_id 	= $_SESSION['ses_user_id'];
        } else {
            $cur_user_id 	= "";
        }

        if($enquiry_id != "") {
            $sqlUpdateQuery = "UPDATE " . TABLE_ENQUIRIES . " SET 
            phone = '".$phone."',
            adults = '".$adults."',
            childs = '".$childs."',
            infants = '".$infants."',
            arrival_date = '".$arrival_date."',
            departure_date = '".$departure_date."',
            duration = '".$duration."',
            flexi_day = '".$flexi_day."',
            enquiry_txt = '".$enquiry_txt."',
            updated_on = '".$cur_unixtime."',
            updated_by = '".$cur_user_id."',
            active = '".$active."'
            WHERE enquiry_id='".$enquiry_id."'";
            $this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
            return $enquiry_id;
        } else {

            $strInsQuery = "INSERT INTO " . TABLE_ENQUIRIES . " 
            (enquiry_id, phone, adults, childs, infants, arrival_date, departure_date, duration, flexi_day, enquiry_txt, created_on, created_by, updated_on, updated_by, view_status, active)
            VALUES(null, '".$phone."', '".$adults."', '".$childs."', '".$infants."', '".fun_db_input($arrival_date)."', '".fun_db_input($departure_date)."', '".$duration."', '".$flexi_day."', '".$enquiry_txt."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."', '0', '0')";
            $this->dbObj->mySqlSafeQuery($strInsQuery);
            $enquiry_id = $this->dbObj->getIdentity();
            return $enquiry_id;
        }
	}
		
	function fun_addPropertyEnquiryRelation($enquiry_id, $property_id, $enquiry_char = '', $active = '') {
        if($enquiry_id =="" || $property_id =="") {
            return false;
        } else {
            $cur_unixtime 	= time ();
            if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !=""){
                $cur_user_id 	= $_SESSION['ses_admin_id'];
            } else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !="") {
                $cur_user_id 	= $_SESSION['ses_modarator_id'];
            } else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !="") {
                $cur_user_id 	= $_SESSION['ses_user_id'];
            } else {
                $cur_user_id 	= "";
            }
			if($enquiry_char == "") {
				$enquiry_char = 'a';
			}

			if(($property_enquiry_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY_ENQUIRIES_RELATIONS , " WHERE property_id='".$property_id."' AND enquiry_id='".$enquiry_id."'")) && (is_array($property_enquiry_array))){
				$property_enquiry_id 	= $property_enquiry_array[0]['property_enquiry_id'];
                $field_names 			= array("updated_on", "updated_by");
                $field_values 			= array($cur_unixtime, $cur_user_id);
                $this->dbObj->updateFields(TABLE_PROPERTY_ENQUIRIES_RELATIONS, "property_enquiry_id", $property_enquiry_id, $field_names, $field_values);
			} else {
                $field_names 	= array("property_id", "enquiry_id", "enquiry_char", "created_on", "created_by", "updated_on", "updated_by", "active");
                $field_values 	= array($property_id, $enquiry_id, $enquiry_char, $cur_unixtime, $cur_user_id, $cur_unixtime, $cur_user_id, $active);
                $this->dbObj->insertFields(TABLE_PROPERTY_ENQUIRIES_RELATIONS, $field_names, $field_values);
			}
            return true;
        }
    }

	// Function	for delete enquiry
	function fun_delPropertyEnquiry($enquiry_id) {
		if($enquiry_id == '') {
			return false;
		} else {
			// Step I: Delete records property relation from database
			$this->dbObj->deleteRow(TABLE_PROPERTY_ENQUIRIES_RELATIONS, "enquiry_id", $enquiry_id);
			// Step II: Delete records user relation from database
			$this->dbObj->deleteRow(TABLE_USER_ENQUIRIES_RELATIONS, "enquiry_id", $enquiry_id);
			// Step III: Delete records enquiry from database
			$this->dbObj->deleteRow(TABLE_ENQUIRIES, "enquiry_id", $enquiry_id);
			return true;
		}
	}

	// Function	for delete enquiry
	function fun_delEnquiryProperties($enquiry_id) {
		if($enquiry_id == '') {
			return false;
		} else {
			// Step I: Delete records property relation from database
			$this->dbObj->deleteRow(TABLE_PROPERTY_ENQUIRIES_RELATIONS, "enquiry_id", $enquiry_id);
			return true;
		}
	}

	// Function	for activate enquiry properties
	function fun_activateEnquiryProperties($enquiry_id) {
		if($enquiry_id == '') {
			return false;
		} else {
			$this->dbObj->updateField(TABLE_PROPERTY_ENQUIRIES_RELATIONS, "enquiry_id", $enquiry_id, "active", "1");
			return true;
		}
	}

	// Function	for activate enquiry
	function fun_activatePropertyEnquiry($enquiry_id) {
		if($enquiry_id == '') {
			return false;
		} else {
			$this->dbObj->updateField(TABLE_ENQUIRIES, "enquiry_id", $enquiry_id, "active", "1");
			return true;
		}
	}

	// This function will Return Enquiry information in array with front end data
	function fun_getPropertyEnquiryInfo($enquiry_id){		
        if($enquiry_id == "") {
            return false;
        } else {
            $sql 		= "SELECT * FROM " . TABLE_ENQUIRIES . " WHERE enquiry_id='".$enquiry_id."'";
            $rs 		= $this->dbObj->createRecordset($sql);
            if($this->dbObj->getRecordCount($rs) > 0){
                $arr 	= $this->dbObj->fetchAssoc($rs);
                return $arr[0];
            } else {
                return false;
            }
        }
	}

	// This function will Return Enquiry User information in array with front end data	
	function fun_getPropertyEnquiryRelationInfo($enquiry_id, $property_id = ''){		
        if($enquiry_id == "") {
            return false;
        } else {
            $sql 	= "SELECT A.enquiry_id, A.enquiry_char, B.property_id, B.property_name, B.property_title 
            FROM " . TABLE_PROPERTY_ENQUIRIES_RELATIONS . " AS A 
            INNER JOIN " . TABLE_PROPERTY . " AS B ON A.property_id = B.property_id 
            WHERE A.enquiry_id='".$enquiry_id."'";
			if($property_id != "") {
				$sql .=" AND B.property_id='".$property_id."'";
			}
            $rs 	= $this->dbObj->createRecordset($sql);
            if($this->dbObj->getRecordCount($rs) > 0){
                $arr 	= $this->dbObj->fetchAssoc($rs);
                return $arr;
            } else {
                return false;
            }
        }
	}

	// This function will Return Enquiry User information in array with front end data	
	function fun_getPropertyEnquiryRelationAdminInfo($enquiry_id, $property_id = '', $enquiry_char = ''){		
        if($enquiry_id == "") {
            return false;
        } else {
            $sql 	= "SELECT A.enquiry_id, A.enquiry_char, B.property_id, B.property_name, B.property_title 
            FROM " . TABLE_PROPERTY_ENQUIRIES_RELATIONS . " AS A 
            INNER JOIN " . TABLE_PROPERTY . " AS B ON A.property_id = B.property_id 
            WHERE A.enquiry_id='".$enquiry_id."'";
			if($enquiry_char != "") {
				$sql .=" AND A.enquiry_char='".$enquiry_char."'";
			}
			if($property_id != "") {
				$sql .=" AND B.property_id='".$property_id."'";
			}
            $rs 	= $this->dbObj->createRecordset($sql);
            if($this->dbObj->getRecordCount($rs) > 0){
                $arr 	= $this->dbObj->fetchAssoc($rs);
                return $arr;
            } else {
                return false;
            }
        }
	}

	// This function will Return Enquiry information in array with front end data
	function fun_getPropertyUserEnquiryArr($user_id, $parameter = ''){
        if($user_id == "") {
            return false;
        } else {
            $sql 		= "SELECT A.user_id, A.enquiry_id, B.enquiry_char, B.property_id, C.created_on, C.delete_status
							FROM " . TABLE_USER_ENQUIRIES_RELATIONS . " AS A, 
							" . TABLE_PROPERTY_ENQUIRIES_RELATIONS . " AS B,
							" . TABLE_ENQUIRIES . " AS C
							WHERE A.user_id='".$user_id."' AND A.active ='1' AND B.enquiry_id = A.enquiry_id AND C.enquiry_id = A.enquiry_id";
			if($parameter != ""){
				$sql .= $parameter;
			} else {
				$sql .= " ORDER BY A.enquiry_id";		
			}
			//echo $sql;
			return $rs = $this->dbObj->createRecordset($sql);
        }
	}

	// This function will Return Enquiry information in array with front end data
	function fun_getPropertyOwnerEnquiryArr($owner_id, $parameter = ''){
        if($owner_id == "") {
            return false;
        } else {
            $sql 		= "SELECT C.user_id, A.enquiry_id, A.property_id, A.enquiry_char, B.owner_id, D.created_on, CONCAT(RTRIM(E.user_fname), ' ', RTRIM(E.user_lname)) AS user_name, D.delete_status
							FROM " . TABLE_PROPERTY_ENQUIRIES_RELATIONS . " AS A 
                            INNER JOIN " . TABLE_PROPERTY_OWNER_RELATIONS . " AS B ON A.property_id = B.property_id,
                            " . TABLE_USER_ENQUIRIES_RELATIONS . " AS C,
                            " . TABLE_ENQUIRIES . " AS D,
                            " . TABLE_USERS . " AS E
                            WHERE B.owner_id = '".$owner_id."' AND D.active ='1' AND D.view_status !='2' AND C.enquiry_id = A.enquiry_id AND D.enquiry_id = A.enquiry_id AND E.user_id = C.user_id ";
			if($parameter != ""){
				$sql .= $parameter;
			} else {
				$sql .= " ORDER BY D.created_on";		
			}
			return $rs = $this->dbObj->createRecordset($sql);
        }
	}

	// This function will Return Enquiry information in array with front end data
	function fun_getPropertyEnquiryInfoArr($parameter = '') {
		$sql = "SELECT C.user_id, A.enquiry_id, A.property_id, F.property_name, A.enquiry_char, B.owner_id, D.created_on, CONCAT(RTRIM(E.user_fname), ' ', RTRIM(E.user_lname)) AS user_name
			FROM " . TABLE_PROPERTY_ENQUIRIES_RELATIONS . " AS A 
			INNER JOIN " . TABLE_PROPERTY_OWNER_RELATIONS . " AS B ON A.property_id = B.property_id
			INNER JOIN " . TABLE_PROPERTY . " AS F ON A.property_id = F.property_id,
			" . TABLE_USER_ENQUIRIES_RELATIONS . " AS C,
			" . TABLE_ENQUIRIES . " AS D,
			" . TABLE_USERS . " AS E
			WHERE  D.active ='1' AND C.enquiry_id = A.enquiry_id AND D.enquiry_id = A.enquiry_id AND E.user_id = C.user_id ";
		if($parameter != ""){
			$sql .= $parameter;
		} else {
			$sql .= " ORDER BY D.created_on";		
		}
	//	echo $sql;
		$rs = $this->dbObj->createRecordset($sql);
        return $arr = $this->dbObj->fetchAssoc($rs);
	}

	// This function will Return Enquiry information in array with front end data
	function fun_countPropertyUserEnquiries($user_id){
        if($user_id == "") {
            return false;
        } else {
			$sql 		= "SELECT A.user_id, A.enquiry_id, B.property_id FROM " . TABLE_USER_ENQUIRIES_RELATIONS . " AS A, " . TABLE_PROPERTY_ENQUIRIES_RELATIONS . " AS B WHERE A.user_id='".$user_id."' AND A.active ='1' AND B.enquiry_id = A.enquiry_id";
			$rs 		= $this->dbObj->createRecordset($sql);
			return $this->dbObj->getRecordCount($rs);
        }
	}

	// This function will Return New inquiry
	function fun_countPropertyNewUserEnquiries($user_id){
        if($user_id == "") {
            return false;
        } else {
            $sql = "SELECT A.enquiry_id
				FROM " . TABLE_ENQUIRIES . " AS A 
                INNER JOIN " . TABLE_USER_ENQUIRIES_RELATIONS . " AS B ON A.enquiry_id = B.enquiry_id
                WHERE B.user_id = '".$user_id."' AND A.active ='1' AND A.view_status ='0' ";
			$rs = $this->dbObj->createRecordset($sql);
            if($this->dbObj->getRecordCount($rs) > 0){
                return $this->dbObj->getRecordCount($rs);
            } else {
                return "0";
            }
        }
	}

	// This function will Return Enquiry information in array with front end data
	function fun_countPropertyOwnerEnquiries($owner_id){
        if($owner_id == "") {
            return false;
        } else {
            $sql 		= "SELECT C.user_id, A.enquiry_id, A.property_id, B.owner_id, D.created_on, CONCAT(RTRIM(E.user_fname), ' ', RTRIM(E.user_lname)) AS user_name
							FROM " . TABLE_PROPERTY_ENQUIRIES_RELATIONS . " AS A 
                            INNER JOIN " . TABLE_PROPERTY_OWNER_RELATIONS . " AS B ON A.property_id = B.property_id,
                            " . TABLE_USER_ENQUIRIES_RELATIONS . " AS C,
                            " . TABLE_ENQUIRIES . " AS D,
                            " . TABLE_USERS . " AS E
                            WHERE B.owner_id = '".$owner_id."' AND D.active ='1' AND C.enquiry_id = A.enquiry_id AND D.enquiry_id = A.enquiry_id AND E.user_id = C.user_id ";
			$rs 		= $this->dbObj->createRecordset($sql);
            if($this->dbObj->getRecordCount($rs) > 0){
                return $this->dbObj->getRecordCount($rs);
            } else {
                return "0";
            }
        }
	}

	// This function will Return New Enquiry information in array with front end data
	function fun_countPropertyOwnerNewEnquiries($owner_id){
        if($owner_id == "") {
            return false;
        } else {
            $sql 		= "SELECT C.user_id, A.enquiry_id, A.property_id, B.owner_id, D.created_on, CONCAT(RTRIM(E.user_fname), ' ', RTRIM(E.user_lname)) AS user_name
							FROM " . TABLE_PROPERTY_ENQUIRIES_RELATIONS . " AS A 
                            INNER JOIN " . TABLE_PROPERTY_OWNER_RELATIONS . " AS B ON A.property_id = B.property_id,
                            " . TABLE_USER_ENQUIRIES_RELATIONS . " AS C,
                            " . TABLE_ENQUIRIES . " AS D,
                            " . TABLE_USERS . " AS E
                            WHERE B.owner_id = '".$owner_id."' AND D.active ='1' AND D.view_status ='0' AND C.enquiry_id = A.enquiry_id AND D.enquiry_id = A.enquiry_id AND E.user_id = C.user_id ";
			$rs 		= $this->dbObj->createRecordset($sql);
            if($this->dbObj->getRecordCount($rs) > 0){
                return $this->dbObj->getRecordCount($rs);
            } else {
                return "0";
            }
        }
	}

	// Function for creating property owner details section 4 property preview

	function fun_getPropertyContactOwnerName($property_id){		
		if($property_id == ''){
			return false;
		} else {
			return $contact_name = $this->dbObj->getField(TABLE_PROPERTY_CONTACTS, "property_id", $property_id, "contact_name");
		}
	}

	// This function will Return Enquiry User information in array with front end data	
	function fun_getEnquiryPropertiesInfo($enquiry_id){		
        if($enquiry_id == "") {
            return false;
        } else {
            $sql 	= "SELECT B.property_id, B.property_name, B.property_title, B.property_summary  
            FROM " . TABLE_PROPERTY_ENQUIRIES_RELATIONS . " AS A 
            INNER JOIN " . TABLE_PROPERTY . " AS B ON A.property_id = B.property_id 
            WHERE A.enquiry_id='".$enquiry_id."'";
			$sql .= " AND B.active='1'";
            $rs = $this->dbObj->createRecordset($sql);
            if($this->dbObj->getRecordCount($rs) > 0){
                $arr = $this->dbObj->fetchAssoc($rs);
                return $arr;
            } else {
                return false;
            }
        }
	}

	function fun_updatePropertyEnquiryViewStatus($enquiry_id, $view_status = '') {
        if($enquiry_id == "") {
        	return false;
        } else {
            $sqlUpdateQuery = "UPDATE " . TABLE_ENQUIRIES . " SET view_status = '".$view_status."' WHERE enquiry_id='".$enquiry_id."'";
            $this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
        	return true;
        }
	}

	function fun_getPropertyEnquiryViewStatus($enquiry_id) {
		if($enquiry_id == ''){
			return false;
		} else {
			return $view_status = $this->dbObj->getField(TABLE_ENQUIRIES, "enquiry_id", $enquiry_id, "view_status");
		}
	}

	function fun_delPropertyEnquiryOwner($enquiry_id) {
		if($enquiry_id == ''){
			return false;
		} else {
			$delet_status = $this->dbObj->getField(TABLE_ENQUIRIES, "enquiry_id", $enquiry_id, "delete_status");
			if($delet_status > 1) {
				$sqlUpdateQuery = "UPDATE " . TABLE_ENQUIRIES . " SET delete_status = '3' WHERE enquiry_id='".$enquiry_id."'";
				$this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
				return true;
			} else {
				$sqlUpdateQuery = "UPDATE " . TABLE_ENQUIRIES . " SET delete_status = '1' WHERE enquiry_id='".$enquiry_id."'";
				$this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
				return true;
			}
		}
	}

	function fun_delPropertyEnquiryCustomer($enquiry_id) {
		if($enquiry_id == ''){
			return false;
		} else {
			$delet_status = $this->dbObj->getField(TABLE_ENQUIRIES, "enquiry_id", $enquiry_id, "delete_status");
			if($delet_status > 2) {
				$sqlUpdateQuery = "UPDATE " . TABLE_ENQUIRIES . " SET delete_status = '3' WHERE enquiry_id='".$enquiry_id."'";
				$this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
				return true;
			} else {
				$sqlUpdateQuery = "UPDATE " . TABLE_ENQUIRIES . " SET delete_status = '2' WHERE enquiry_id='".$enquiry_id."'";
				$this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
				return true;
			}
		}
	}

	function fun_delBookingOwner($booking_id) {
		if($booking_id == ''){
			return false;
		} else {
			$delete_status = $this->dbObj->getField(TABLE_PROPERTY_BOOKINGS, "booking_id", $booking_id, "delete_status");
			if($delete_status > 1) {
				$sqlUpdateQuery = "UPDATE " . TABLE_PROPERTY_BOOKINGS . " SET delete_status = '3' WHERE booking_id='".$booking_id."'";
				$this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
				return true;
			} else {
				$sqlUpdateQuery = "UPDATE " . TABLE_PROPERTY_BOOKINGS . " SET delete_status = '1' WHERE booking_id='".$booking_id."'";
				$this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
				return true;
			}
		}
	}

	function fun_updatePropertyEnquiryHideOwnerView($enquiry_id) {
		if($enquiry_id == ""){
			return false;
		} else {
			$cur_unixtime 	= time ();
			if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !=""){
				$cur_user_id 	= $_SESSION['ses_admin_id'];
			} else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !="") {
				$cur_user_id 	= $_SESSION['ses_modarator_id'];
			} else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !="") {
				$cur_user_id 	= $_SESSION['ses_user_id'];
			} else {
				$cur_user_id 	= "";
			}
			$field_names 	= array("view_status", "updated_on", "updated_by");
			$field_values 	= array("2", $cur_unixtime, $cur_user_id);
			$this->dbObj->updateFields(TTABLE_ENQUIRIES, "enquiry_id", $enquiry_id, $field_names, $field_values);
			return true;
		}
	}

	function fun_delBookingCustomer($booking_id) {
		if($booking_id == ''){
			return false;
		} else {
			$delete_status = $this->dbObj->getField(TABLE_PROPERTY_BOOKINGS, "booking_id", $booking_id, "delete_status");
			if($delete_status > 2) {
				$sqlUpdateQuery = "UPDATE " . TABLE_PROPERTY_BOOKINGS . " SET delete_status = '3' WHERE booking_id='".$booking_id."'";
				$this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
				return true;
			} else {
				$sqlUpdateQuery = "UPDATE " .TABLE_PROPERTY_BOOKINGS . " SET delete_status = '2' WHERE booking_id='".$booking_id."'";
				$this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
				return true;
			}
		}
	}



	function fun_sendPropertyEnquiryNotification($enquiry_id) {
		if($enquiry_id == false) {
			return false;		
		} else {
			$usersObj 				= new Users();
			$enquiryInfoArr = $this->fun_getPropertyEnquiryInfo($enquiry_id);
			/*
			$txtAdults 				= $enquiryInfoArr['adults'];
			$txtChilds 				= $enquiryInfoArr['childs'];
			$txtInfants 			= $enquiryInfoArr['infants'];
			$travelArr = array();
			if(isset($txtAdults) && $txtAdults > 0) {
				array_push($travelArr, ($txtAdults > 1)?$txtAdults." adults":$txtAdults." adult");
			}
			if(isset($txtChilds) && $txtChilds > 0) {
				array_push($travelArr, ($txtChilds > 1)?$txtChilds." children":$txtChilds." children");
			}
			if(isset($txtInfants) && $txtInfants > 0) {
				array_push($travelArr, ($txtInfants > 1)?$txtInfants." infants":$txtInfants." infant");
			}

			$txtArriavalDate 		= $enquiryInfoArr['arrival_date'];
			$arriavalDateArr 		= explode("-", $txtArriavalDate);
			$txtDayArrival0 		= $arriavalDateArr[2];
			$txtMonthArrival0 		= $arriavalDateArr[1];
			$txtYearArrival0 		= $arriavalDateArr[0];
			$txtDuration 			= $enquiryInfoArr['duration'];
			$txtFlexibleDays 		= $enquiryInfoArr['flexi_day'];
			$txtDepartDateTime		= mktime(0, 0, 0, $txtMonthArrival0, (int)($txtDayArrival0+$txtDuration), $txtYearArrival0);
			*/

			$txtPhone 				= $enquiryInfoArr['phone'];
			$txtUserEnquiry 		= $enquiryInfoArr['enquiry_txt'];
			$txtCreatedOn	 		= $enquiryInfoArr['created_on'];

			$enquiryUserInfoArr 	= $usersObj->fun_getUserEnquiryInfo($enquiry_id);
			$txtUserId 				= $enquiryUserInfoArr['user_id'];
			$txtUserFName 			= $enquiryUserInfoArr['user_fname'];
			$txtUserLName 			= $enquiryUserInfoArr['user_lname'];
			$txtUserEmail 			= $enquiryUserInfoArr['user_email'];
			$txtUserName			= $txtUserFName." ".$txtUserLName;
			$enquiryPropertyInfoArr 	= $this->fun_getPropertyEnquiryRelationInfo($enquiry_id, '');
			if(is_array($enquiryPropertyInfoArr) && count($enquiryPropertyInfoArr) > 0) {
				$enquiry_html = "";
				for($i = 0; $i < count($enquiryPropertyInfoArr); $i++) {
					$property_id 	= $enquiryPropertyInfoArr[$i]['property_id'];
					$owner_id 		= $this->dbObj->getField(TABLE_PROPERTY_OWNER_RELATIONS, "property_id", $property_id, "owner_id");

					$property_name 	= $enquiryPropertyInfoArr[$i]['property_name'];
					$property_title	= $enquiryPropertyInfoArr[$i]['property_title'];
					$enquiry_html .= "<table width=\"580\" border=\"0\" cellpadding=\"5\" cellspacing=\"0\">";
					$enquiry_html .= "<tr>";
					$enquiry_html .= "<td width=\"155\" align=\"right\" valign=\"top\">";
					/*
					$propertyMImgInfo	= $this->fun_getPropertyMainThumb($property_id);
					if(is_array($propertyMImgInfo) && count($propertyMImgInfo) > 0) {
						$imgid 		= $propertyMImgInfo[0]['photo_id'];
						$imgcap 	= ucfirst($propertyMImgInfo[0]['photo_caption']);
						$imgcap		= addslashes($imgcap);
						$imgthumb 	= SITE_URL."upload/property_images/thumbnail/168x126/".$propertyMImgInfo[0]['photo_thumb'];
						$enquiry_html .= "<img src=\"".$imgthumb."\" alt=\"".$imgcap."\" width=\"168\" height=\"126\" />";
					} else {
						$imgcap		= "No Image";
						$imgthumb 	= SITE_URL."upload/property_images/thumbnail/168x126/no-img.gif";
						$enquiry_html .= "<img src=\"".$imgthumb."\" alt=\"".$imgcap."\" width=\"168\" height=\"126\" />";
					}
					*/
					$enquiry_html .= "</td>";
					$enquiry_html .= "<td valign=\"middle\" style=\"padding-left:15px;\">";
					$enquiry_html .= "<table width=\"490\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
					$enquiry_html .= "<tr>";
					$enquiry_html .= "<td width=\"96\" valign=\"top\"><strong>Enquiry ID</strong></td>";
					$enquiry_html .= "<td width=\"390\" valign=\"top\">".fill_zero_left($enquiry_id, "0", (9-strlen($enquiry_id)))."</td>";
					$enquiry_html .= "</tr>";
					$enquiry_html .= "<tr>";
					$enquiry_html .= "<td valign=\"top\"><strong>From</strong></td>";
					$enquiry_html .= "<td valign=\"top\">".$txtUserName."</td>";
					$enquiry_html .= "</tr>";
					$enquiry_html .= "<tr>";
					$enquiry_html .= "<td valign=\"top\"><strong>Phone </strong></td>";
					$enquiry_html .= "<td valign=\"top\">".$txtPhone."</td>";
					$enquiry_html .= "</tr>";
					$enquiry_html .= "<tr>";
					$enquiry_html .= "<td valign=\"top\"><strong>Email</strong></td>";
					$enquiry_html .= "<td valign=\"top\"><a href=\"mailto:".$txtUserEmail."\" style=\"color:#357bdc; text-decoration: none;\" >".$txtUserEmail."</a></td>";
					$enquiry_html .= "</tr>";
					$enquiry_html .= "<tr>";
					$enquiry_html .= "<td valign=\"top\"><strong>Property ID</strong></td>";
					$enquiry_html .= "<td valign=\"top\">".fill_zero_left($property_id, "0", (6-strlen($property_id)))."</td>";
					$enquiry_html .= "</tr>";
					$enquiry_html .= "<tr>";
					$enquiry_html .= "<td valign=\"top\"><strong>Property name</strong></td>";
					$enquiry_html .= "<td valign=\"top\"><a href=\"".SITE_URL."property.php?pid=".$property_id."\" style=\"color:#357bdc; text-decoration: none;\" >".ucfirst($property_name)."</a></td>";
					$enquiry_html .= "</tr>";
					$enquiry_html .= "<tr>";
					$enquiry_html .= "<td valign=\"top\"><strong>Enquiry date</strong></td>";
					$enquiry_html .= "<td valign=\"top\">".date('M j, Y', $txtCreatedOn)."</td>";
					$enquiry_html .= "</tr>";
					$enquiry_html .= "<tr>";
					$enquiry_html .= "<td valign=\"top\">&nbsp;</td>";
					$enquiry_html .= "<td valign=\"top\">&nbsp;</td>";
					$enquiry_html .= "</tr>";
					/*
					$enquiry_html .= "<tr>";
					$enquiry_html .= "<td valign=\"top\"><strong>Who&rsquo;s travelling</strong></td>";
					$enquiry_html .= "<td valign=\"top\">".implode(", ", $travelArr)."</td>";
					$enquiry_html .= "</tr>";
					$enquiry_html .= "<tr>";
					$enquiry_html .= "<td valign=\"top\"><strong>When</strong></td>";
					$enquiry_html .= "<td valign=\"top\"><strong>Arrive</strong> ".date('M j, Y', strtotime($txtArriavalDate))." for ".$txtDuration." nights, <strong>Depart</strong> ".date('M j, Y', $txtDepartDateTime)."<br />Dates flexible by ".$txtFlexibleDays." days</td>";
					$enquiry_html .= "</tr>";
					$enquiry_html .= "<tr>";
					*/
					$enquiry_html .= "<td valign=\"top\"><strong>Message</strong></td>";
					$enquiry_html .= "<td valign=\"top\">".$txtUserEnquiry."</td>";
					$enquiry_html .= "</tr>";
					$enquiry_html .= "</table>";
					$enquiry_html .= "</td>";
					$enquiry_html .= "</tr>";
					$enquiry_html .= "<tr><td colspan=\"2\" align=\"right\" valign=\"middle\">&nbsp;</td></tr>";
					$enquiry_html .= "</table>";

					$this->sendEnquiryEmailToOwner($owner_id, $enquiry_html, '', $txtUserEmail);
					$this->sendEnquiryEmailToUser($txtUserId, $enquiry_html, '');
					$enquiry_html = "";
				}
			} else {
				return false;		
			}
		}
	}

	function sendEnquiryEmailToOwner($owner_id, $enquiry_txt = '', $enquiry_footer = '', $reply_to) {
		// Step 1: Find user details
		$usersObj 		= new Users();
		$userDats 		= $usersObj->fun_getUsersInfo($owner_id);
		$user_fname		= ucfirst($userDats['user_fname']);
		$user_email		= $userDats['user_email'];

$msg = '<table width="600"  border="0" cellspacing="10" cellpadding="0">';
//$msg .= '<tr><td align="left"><a href="'.SITE_URL.'"><img src="'.SITE_URL.'images/logo.jpg" border="0"></a></td></tr>';
/*
$msg .= '<tr><td>&nbsp;</td></tr>
<tr><td><strong>Dear '.$user_fname.', you\'ve just received an enquiry ...</strong></td></tr>
<tr><td>Please remember to reply even if you can\'t accommodate it this time.</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>Regards,</td></tr>
<tr><td>The '.$_SERVER["SERVER_NAME"].' team</td></tr>';
*/
if($enquiry_txt != "") {
	$msg .= '<tr><td style=\"padding-left:20px; padding-right:20px;\" ><hr>'.$enquiry_txt.'</td></tr>';
}
if($enquiry_footer != "") {
	$msg .= '<tr><td style=\"padding-left:20px; padding-right:20px;\" ><hr>'.$enquiry_footer.'</td></tr>';
}
$msg .= '</table>';

		$emailObj = new Email($user_email, "Administrator | rentownersvillas.com <".SITE_INFO_EMAIL.">", "You've just received a new enquiry on ".$_SERVER["SERVER_NAME"], $msg, '', '', '', $reply_to);
		//$emailObj = new Email($user_email, SITE_INFO_EMAIL, "You've just received a new enquiry on ".$_SERVER["SERVER_NAME"], $msg);
		if($emailObj->sendEmail()) {
			$emailObj1 = new Email("admin@rentownersvillas.com", SITE_INFO_EMAIL, "You've just received a new enquiry on ".$_SERVER["SERVER_NAME"], $msg);
			$emailObj1->sendEmail();
			return true;
		} else {
			return false;
		}
	}

	function sendEnquiryEmailToUser($user_id, $enquiry_txt = '', $enquiry_footer = '') {
		// Step 1: Find user details
		$usersObj 		= new Users();
		$userDats 		= $usersObj->fun_getUsersInfo($user_id);
		$user_fname		= ucfirst($userDats['user_fname']);
		$user_email		= $userDats['user_email'];

$msg = '<table width="600"  border="0" cellspacing="10" cellpadding="0">';
//$msg .= '<tr><td align="left"><a href="'.SITE_URL.'"><img src="'.SITE_URL.'images/logo.jpg" border="0"></a></td></tr>';
$msg .= '<tr><td>&nbsp;</td></tr>
<tr><td><strong>Dear '.$user_fname.', thanks for using rentownersvillas.com.</strong></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><strong>Below is a copy of your enquiry.</strong></td></tr>
<tr><td>Please keep this email and the Enquiry ID for future reference. We will need this information if you ever need to contact us about your enquiry.</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>Our owners are pretty good at getting in touch so keep an eye on your inbox. If they do not respond then try calling them using the contact number quoted on their listing.</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>We hope you\'ve found the perfect holiday accommodation.</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>Regards,</td></tr>
<tr><td>The '.$_SERVER["SERVER_NAME"].' team</td></tr>';
if($enquiry_txt != "") {
	$msg .= '<tr><td style=\"padding-left:20px; padding-right:20px;\" ><hr>'.$enquiry_txt.'</td></tr>';
}
if($enquiry_footer != "") {
	$msg .= '<tr><td style=\"padding-left:20px; padding-right:20px;\" ><hr>'.$enquiry_footer.'</td></tr>';
}
$msg .= '</table>';

		$emailObj = new Email($user_email, "Administrator | rentownersvillas.com <".SITE_INFO_EMAIL.">", "Your enquiry has been sent on ".$_SERVER["SERVER_NAME"], $msg);
		//$emailObj = new Email($user_email, SITE_INFO_EMAIL, "Your enquiry has been sent on ".$_SERVER["SERVER_NAME"], $msg);
		if($emailObj->sendEmail()) {
			$emailObj1 = new Email("admin@rentownersvillas.com", SITE_INFO_EMAIL, "Your enquiry has been sent on ".$_SERVER["SERVER_NAME"], $msg);
			$emailObj1->sendEmail();
			return true;
		} else {
			return false;
		}
	}

	/*
	* Property Enquiry specific functions : end here
	*/

	/*
	* For Property visit : Start Here
	*/
	function fun_addPropertyVisit($property_id) {
        if($property_id == "") {
        	return false;
        } else {
			$visiter_ip 	= $_SERVER['REMOTE_ADDR'];
			$visiter_data 	= implode("; ", $_SERVER)."::".implode("; ", $_REQUEST)."::".implode("; ", $_COOKIE);
			$created_on 	= time ();
		
			$field_names 	= array("property_id", "visiter_ip", "visiter_data", "created_on");
			$field_values 	= array($property_id, $visiter_ip, fun_db_input($visiter_data), $created_on);
			$this->dbObj->insertFields(TABLE_PROPERTY_VISIT_RELATIONS, $field_names, $field_values);
			//$id 			= $this->dbObj->getIdentity();
        	return true;
        }
	}
	/*
	* For Property visit : End Here
	*/

	/*
	* Property sitemap links generator functions : start here
	*/
	function fun_createPropertyLinkContentByRegion($region_id){		
		if($region_id == "") {
			return false;
		} else {
			$contents = "";
			if($this->fun_countPropertyByRegionId($region_id) > 0) {
				$contents .= "http://".$_SERVER["SERVER_NAME"]."/vacation-rentals/in.".str_replace(" ", "-", strtolower($this->fun_getPropertyRegionNameById($region_id)))."\n";
				if(($sub_region_array = $this->fun_findPropertyRelationInfo(TABLE_REGION , " WHERE pregion_id='".$region_id."'")) && (is_array($sub_region_array))){
					for($i = 0; $i < count($sub_region_array); $i++) {
						$rsRegionId = $sub_region_array[$i]['region_id'];
						if($this->fun_countPropertyByRegionId($rsRegionId) > 0) {
							$contents .= "http://".$_SERVER["SERVER_NAME"]."/vacation-rentals/in.".str_replace(" ", "-", strtolower($this->fun_getPropertyRegionNameById($rsRegionId)))."\n";
							if(($location_array = $this->fun_findPropertyRelationInfo(TABLE_LOCATION , " WHERE region_id='".$rsRegionId."'")) && (is_array($location_array))){
								for($j=0; $j < count($location_array); $j++) {
									$location_id 	= $location_array[$j]['location_id'];
									$location_name 	= ucwords($location_array[$j]['location_name']);
									if($this->fun_countPropertyByLocationId($location_id) > 0) {
										$contents .= "http://".$_SERVER["SERVER_NAME"]."/vacation-rentals/in.".str_replace(" ", "-", strtolower($location_name))."\n";
									}
								}
							}
						}
					}
				} else if(($location_array = $this->fun_findPropertyRelationInfo(TABLE_LOCATION , " WHERE region_id='".$region_id."'")) && (is_array($location_array))){
					for($j=0; $j < count($location_array); $j++) {
						$location_id 	= $location_array[$j]['location_id'];
						$location_name 	= ucwords($location_array[$j]['location_name']);
						if($this->fun_countPropertyByLocationId($location_id) > 0) {
							$contents .= "http://".$_SERVER["SERVER_NAME"]."/vacation-rentals/in.".str_replace(" ", "-", strtolower($location_name))."\n";
						}
					}
				}
			}
			return $contents;
		}
	}

	function fun_createPropertyLinkContentByArea($area_id){		
		if($area_id == "") {
			return false;
		} else {
			$contentbyarea = "";
			if(($region_array = $this->fun_findPropertyRelationInfo(TABLE_REGION , " WHERE area_id='".$area_id."' AND pregion_id='0'")) && (is_array($region_array))){
				for($k = 0; $k < count($region_array); $k++) {
					$rsRegionId = $region_array[$k]['region_id'];
					$contentbyarea .= $this->fun_createPropertyLinkContentByRegion($rsRegionId);
				}
			}
			return $contentbyarea;
		}
	}

	function fun_createPropertyPreviewLinkContent(){		
		$contents = "";
		if(($property_array = $this->fun_findPropertyRelationInfo(TABLE_PROPERTY , " WHERE status='2' AND active='1'")) && (is_array($property_array))){
			for($i = 0; $i < count($property_array); $i++) {
				$property_id = $property_array[$i]['property_id'];
				$location_id = $property_array[$i]['location_id'];
				$location_name = $this->dbObj->getField(TABLE_LOCATION, "location_id", $location_id, "location_name");
				$fr_url = $this->fun_getPropertyFriendlyLink($property_id);
				if(isset($fr_url) && $fr_url != "") {
					$contents .= "http://".$_SERVER["SERVER_NAME"]."/vacation-rentals/".strtolower($fr_url)."\n";
				} else {
					$contents .= "http://".$_SERVER["SERVER_NAME"]."/vacation-rentals/in.".str_replace(" ", "-", strtolower($location_name))."/".fill_zero_left($property_id, "0", (6-strlen($property_id)))."\n";
				}
			}
		}
		return $contents;
	}

	// Function for creating property tag view
	function fun_createPropertyTagView($property_id) {		
		$sql 		= "SELECT A.id AS tag_id, A.tag_name FROM " . TABLE_TAGS . " AS A INNER JOIN " . TABLE_PROPERTY_TAGS . " AS B ON A.id=B.tag_name WHERE B.property_id='".$property_id."'";
		$rs 		= $this->dbObj->createRecordset($sql);
		$strHTML 	= "Tags: ";
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr 		= $this->dbObj->fetchAssoc($rs);
			foreach($arr as $key=>$value) {
				$tag_id 	= $value['tag_id'];
				$tag_name 	= $value['tag_name'];
				$strHTML 	.= '<a href="javascript:void(0);" class="blue-link">'.ucfirst($tag_name).'</a>, ';
			}
		}
		echo $strHTML."Property id ".fill_zero_left($property_id, "0", (6-strlen($property_id)));
	}

	/*
	* Property sitemap links generator functions : end here
	*/

	/*
	* Property collateral functions : start here
	*/
	function fun_getCollateralPropertyArr($parameter=''){
		$sql = "SELECT 	A.property_id, 
						A.property_name,
						A.status,
						FROM_UNIXTIME(A.statuschanged_on, '%m/%d/%Y') AS statuschanged_on,
						FROM_UNIXTIME(A.created_on, '%m/%d/%Y') AS created_on,
						FROM_UNIXTIME(A.updated_on, '%m/%d/%Y') AS updated_on,
						FROM_UNIXTIME(A.active_on, '%m/%d/%Y') AS active_on,
						B.owner_id, 
						C.status_name, 
						D.user_fname, 
						D.user_lname
				FROM " . TABLE_PROPERTY . " AS A  
				LEFT JOIN " . TABLE_PROPERTY_OWNER_RELATIONS . " AS B ON A.property_id = B.property_id
				LEFT JOIN " . TABLE_PROPERTY_STATUS . " AS C ON A.status = C.status_id,
				".TABLE_USERS." AS D WHERE D.user_id=B.owner_id ";
		if($parameter!=""){
			$sql .= $parameter;		
		} else {
			$sql .= " ORDER BY A.created_on DESC";		
		}		
		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			return $arr = $this->dbObj->fetchAssoc($rs);
		} else {
			return false;
		}
    }

	/*
	* Property collateral functions : end here
	*/

	function fun_getPropertyIdByName($property_name) {
		if($property_name == ''){
			return false;
		} else {
			if($this->dbObj->getField(TABLE_PROPERTY, "REPLACE(REPLACE(REPLACE(LOWER(property_name), '&', ''), '-', ''), \"\'\", \"-\")", strtolower(str_replace("'", "-", $property_name)), "property_id") != "") {
				$property_id = $this->dbObj->getField(TABLE_PROPERTY, "REPLACE(REPLACE(REPLACE(LOWER(property_name), '&', ''), '-', ''), \"\'\", \"-\")", strtolower(str_replace("'", "-", $property_name)), "property_id");
			} else if($this->dbObj->getField(TABLE_PROPERTY, "REPLACE(REPLACE(REPLACE(LOWER(property_name), '&', ''), '-', ''), \"\\\'\", \"-\")", strtolower(str_replace("'", "-", $property_name)), "property_id") != "") {
				$property_id = $this->dbObj->getField(TABLE_PROPERTY, "REPLACE(REPLACE(REPLACE(LOWER(property_name), '&', ''), '-', ''), \"\\\'\", \"-\")", strtolower(str_replace("'", "-", $property_name)), "property_id");
			} else if($this->dbObj->getField(TABLE_PROPERTY, "REPLACE(REPLACE(REPLACE(LOWER(property_name), '&', ''), '-', ''), \"\'\", \"-\")", strtolower(str_replace("\'", "-", $property_name)), "property_id") != "") {
				$property_id = $this->dbObj->getField(TABLE_PROPERTY, "REPLACE(REPLACE(REPLACE(LOWER(property_name), '&', ''), '-', ''), \"\'\", \"-\")", strtolower(str_replace("\'", "-", $property_name)), "property_id");
			} else if($this->dbObj->getField(TABLE_PROPERTY, "REPLACE(REPLACE(REPLACE(LOWER(property_name), '&', ''), '-', ''), \"\\\'\", \"-\")", strtolower(str_replace("\'", "-", $property_name)), "property_id") != "") {
				$property_id = $this->dbObj->getField(TABLE_PROPERTY, "REPLACE(REPLACE(REPLACE(LOWER(property_name), '&', ''), '-', ''), \"\\\'\", \"-\")", strtolower(str_replace("\'", "-", $property_name)), "property_id");
			}
			return $property_id;
		}
	}

	function fun_getPropertyIdByFriendlyURL($friendly_link) {
		if($friendly_link == ''){
			return false;
		} else {
			if($this->dbObj->getField(TABLE_PROPERTY, "REPLACE(REPLACE(LOWER(friendly_link), '&', ''), \"\'\", \"-\")", strtolower(str_replace("'", "-", $friendly_link)), "property_id") != "") {
				$property_id = $this->dbObj->getField(TABLE_PROPERTY, "REPLACE(REPLACE(LOWER(friendly_link), '&', ''), \"\'\", \"-\")", strtolower(str_replace("'", "-", $friendly_link)), "property_id");
			} else if($this->dbObj->getField(TABLE_PROPERTY, "REPLACE(REPLACE(LOWER(friendly_link), '&', ''), \"\\\'\", \"-\")", strtolower(str_replace("'", "-", $friendly_link)), "property_id") != "") {
				$property_id = $this->dbObj->getField(TABLE_PROPERTY, "REPLACE(REPLACE(LOWER(friendly_link), '&', ''), \"\\\'\", \"-\")", strtolower(str_replace("'", "-", $friendly_link)), "property_id");
			} else if($this->dbObj->getField(TABLE_PROPERTY, "REPLACE(REPLACE(LOWER(friendly_link), '&', ''), \"\'\", \"-\")", strtolower(str_replace("\'", "-", $friendly_link)), "property_id") != "") {
				$property_id = $this->dbObj->getField(TABLE_PROPERTY, "REPLACE(REPLACE(LOWER(friendly_link), '&', ''), \"\'\", \"-\")", strtolower(str_replace("\'", "-", $friendly_link)), "property_id");
			} else if($this->dbObj->getField(TABLE_PROPERTY, "REPLACE(REPLACE(LOWER(friendly_link), '&', ''), \"\\\'\", \"^\")", strtolower(str_replace("\'", "-", $friendly_link)), "property_id") != "") {
				$property_id = $this->dbObj->getField(TABLE_PROPERTY, "REPLACE(REPLACE(LOWER(friendly_link), '&', ''), \"\\\'\", \"^\")", strtolower(str_replace("\'", "-", $friendly_link)), "property_id");
			}
			return $property_id;
		}
	}

	function fun_getPropertyFriendlyLink($property_id) {
		if($property_id == ''){
			return false;
		} else {
			return $friendly_link = $this->dbObj->getField(TABLE_PROPERTY, "property_id", $property_id, "friendly_link");
		}
	}

	/*
	* Added on 17 Nov, 2009: Start
	*/
	function fun_getRegionId($area_id, $region_name) {
		if($region_name != "") {
			if(($region_relation_array = $this->fun_findPropertyRelationInfo(TABLE_REGION , " WHERE area_id='".$area_id."' AND LOWER(region_name)='".strtolower($region_name)."'")) && (is_array($region_relation_array))){
				$region_id	= $region_relation_array[0]['region_id'];
			} else {
				$strInsQuery = "INSERT INTO " . TABLE_REGION . "(region_id, pregion_id, area_id, region_name, region_desc, map_thumb, map_large, latitude, longitude, zoom_level, status) ";
				$strInsQuery .= "VALUES(null, '0', '".$area_id."', '".strtolower($region_name)."', '', '', '', '', '', '', '1')";
				$this->dbObj->mySqlSafeQuery($strInsQuery);
				$region_id	= $this->dbObj->getIdentity();
			}
			return $region_id;
		} else {
			return "";
		}
	}
	
	function fun_getLocationId($region_id, $location_name, $zip = '') {
		if($location_name != "") {
			if(($location_relation_array = $this->fun_findPropertyRelationInfo(TABLE_LOCATION , " WHERE region_id='".$region_id."' AND LOWER(location_name)='".strtolower($location_name)."'")) && (is_array($location_relation_array))){
				$location_id	= $location_relation_array[0]['location_id'];
			} else {
				$strInsQuery = "INSERT INTO " . TABLE_LOCATION . "(location_id, region_id, location_name, location_desc, latitude, longitude, zoom_level, location_zip, status) ";
				$strInsQuery .= "VALUES(null, '".$region_id."', '".strtolower($location_name)."', '', '', '', '', '".$zip."', '1')";
				$this->dbObj->mySqlSafeQuery($strInsQuery);
				$location_id	= $this->dbObj->getIdentity();
			}
			return $location_id;
		} else {
			return "";
		}
	}
	/*
	* Added on 17 Nov, 2009: End
	*/

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

	/*
	* Property Booking spific functions : start here Added on 21 Aug   **************************
	*/
	
	// Function for check property availability
	function fun_checkBookingAvailability($property_id, $startdate='', $enddate=''){		
		$sql = "SELECT 
				A.id,
				A.property_id,
				A.startdate,
				A.enddate,
				A.status
				FROM " . TABLE_PROPERTY_AVAILABILITY_RELATIONS . " AS A ";

		$sql .= "WHERE A.property_id ='".$property_id."' ";
		
		if(isset($startdate) && ($startdate != "")) {
			$sql .= " AND (A.startdate = '".$startdate."' OR A.startdate > '".$startdate."' OR A.enddate = '".$startdate."' OR A.enddate > '".$startdate."') ";
		}

		if(isset($enddate) && ($enddate != "")) {
			$sql .= " AND A.enddate >= '".$enddate."' ";
		}

		$sql .= "AND A.status = '2' ORDER BY A.id";		
		$rs   = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			return true;
		} else {
			return false;
		}
	}

	function fun_updatePropertyBookingUser($booking_id, $user_id) {
        if($booking_id == "" || $user_id == "") {
        	return false;
        } else {
            $sqlUpdateQuery = "UPDATE " . TABLE_PROPERTY_BOOKINGS . " SET user_id = '".$user_id."' WHERE booking_id='".$booking_id."'";
            $this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
        	return true;
        }
	}
	

	function fun_addPropertyBooking($booking_id = '', $user_id = '', $property_id = '', $phone = '',  $adults = '', $childs = '', $infants = '', $arrival_date = '', $departure_date = '', $message = '', $total_amount = '', $owner_amount = '', $currency_code = '', $payment_status = '', $active = '') {
		$cur_unixtime 	= time ();
        if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !=""){

            $cur_user_id 	= $_SESSION['ses_admin_id'];
        } else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !="") {
            $cur_user_id 	= $_SESSION['ses_modarator_id'];
        } else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !="") {
            $cur_user_id 	= $_SESSION['ses_user_id'];
        } else {
            $cur_user_id 	= "";
        }

        if($booking_id != "") {
            $sqlUpdateQuery = "UPDATE " . TABLE_PROPERTY_BOOKINGS . " SET 
			user_id = '".$user_id."',
			property_id = '".$property_id."',
			phone = '".$phone."',
            adults = '".$adults."',
            childs = '".$childs."',
            infants = '".$infants."',
            arrival_date = '".$arrival_date."',
            departure_date = '".$departure_date."',
            message = '".fun_db_input($message)."',
            total_amount = '".$total_amount."',
            owner_amount = '".$owner_amount."',
            currency_code = '".$currency_code."',
            payment_status = '".$payment_status."',
            updated_on = '".$cur_unixtime."',
            updated_by = '".$cur_user_id."',
            active = '".$active."'
            WHERE booking_id='".$booking_id."'";
            $this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
            return $booking_id;
        } else {

            $strInsQuery = "INSERT INTO " . TABLE_PROPERTY_BOOKINGS . " 
            (booking_id, user_id , property_id , phone, adults, childs, infants, arrival_date, departure_date,  message, total_amount, owner_amount, currency_code, payment_status, created_on, created_by, updated_on, updated_by, active)
            VALUES(null, '".$user_id."',  '".$property_id."' , '".$phone."', '".$adults."', '".$childs."', '".$infants."', '".$arrival_date."', '".$departure_date."',  '".fun_db_input($message)."', '".$total_amount."', '".$owner_amount."', '".$currency_code."', '".$payment_status."','".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."','".$cur_user_id."', '".$active."')";
            $this->dbObj->mySqlSafeQuery($strInsQuery);
            $booking_id = $this->dbObj->getIdentity();
            return $booking_id;
        }
	}

/*
	function fun_addPropertyBooking($booking_id = '', $user_id = '', $property_id = '', $phone = '',  $adults = '', $childs = '', $infants = '', $arrival_date = '', $departure_date = '', $message = '', $total_amount = '', $owner_amount = '', $currency_code = '', $salutation = '', $budget = '', $findus = '', $pay_method = '', $flexibility = '', $one_bdr_apt = '', $two_bdr_apts = '', $three_bdr_apts = '', $twin_studio = '', $triple_studio = '', $room_only_2 = '', $room_only_3 = '', $payment_status = '', $active = '') {
		$cur_unixtime 	= time ();
        if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !=""){

            $cur_user_id 	= $_SESSION['ses_admin_id'];
        } else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !="") {
            $cur_user_id 	= $_SESSION['ses_modarator_id'];
        } else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !="") {
            $cur_user_id 	= $_SESSION['ses_user_id'];
        } else {
            $cur_user_id 	= "";
        }

        if($booking_id != "") {
            $sqlUpdateQuery = "UPDATE " . TABLE_PROPERTY_BOOKINGS . " SET 
			user_id = '".$user_id."',
			property_id = '".$property_id."',
			phone = '".$phone."',
            adults = '".$adults."',
            childs = '".$childs."',
            infants = '".$infants."',
            arrival_date = '".$arrival_date."',
            departure_date = '".$departure_date."',
            message = '".fun_db_input($message)."',
            total_amount = '".$total_amount."',
            owner_amount = '".$owner_amount."',
            currency_code = '".$currency_code."',
            salutation = '".$salutation."',
            budget = '".$budget."',
            findus = '".$findus."',
            pay_method = '".$pay_method."',
            flexibility = '".$flexibility."',
            one_bdr_apt = '".$one_bdr_apt."',
            two_bdr_apts = '".$two_bdr_apts."',
            three_bdr_apts = '".$three_bdr_apts."',
            twin_studio = '".$twin_studio."',
            triple_studio = '".$triple_studio."',
            room_only_2 = '".$room_only_2."',
            room_only_3 = '".$room_only_3."',
            payment_status = '".$payment_status."',
            updated_on = '".$cur_unixtime."',
            updated_by = '".$cur_user_id."',
            active = '".$active."'
            WHERE booking_id='".$booking_id."'";
            $this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
            return $booking_id;
        } else {
            $strInsQuery = "INSERT INTO " . TABLE_PROPERTY_BOOKINGS . " 
            (booking_id, user_id , property_id , phone, adults, childs, infants, arrival_date, departure_date,  message, total_amount, owner_amount, currency_code, salutation, budget, findus, pay_method, flexibility, one_bdr_apt, two_bdr_apts, three_bdr_apts, twin_studio, triple_studio, room_only_2, room_only_3, payment_status, created_on, created_by, updated_on, updated_by, active)
            VALUES(null, '".$user_id."',  '".$property_id."' , '".$phone."', '".$adults."', '".$childs."', '".$infants."', '".$arrival_date."', '".$departure_date."',  '".fun_db_input($message)."', '".$total_amount."', '".$owner_amount."', '".$currency_code."', '".$salutation."', '".$budget."', '".$findus."', '".$pay_method."', '".$flexibility."' , '".$one_bdr_apt."' , '".$two_bdr_apts."' , '".$three_bdr_apts."' , '".$twin_studio."' , '".$triple_studio."' , '".$room_only_2."' , '".$room_only_3."' , '".$payment_status."','".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."','".$cur_user_id."', '".$active."')";
            $this->dbObj->mySqlSafeQuery($strInsQuery);
            $booking_id = $this->dbObj->getIdentity();
            return $booking_id;
        }
	}
	*/
	// This function will update booking status
	function fun_updateBookingStatus($booking_id, $booking_status_id, $date_added = '') {
		if($booking_id == '' && $booking_status_id == '') {
			return false;
		} else {
			$sqlUpdateQuery = "UPDATE " . TABLE_PROPERTY_BOOKINGS . " SET payment_status = '".$booking_status_id."', updated_on = '".$date_added."' WHERE booking_id='".$booking_id."'";
			$this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
			return true;
		}
	}

	// This function will Return Booking information in array with front end data
	function fun_getPropertyBookingInfo($booking_id){		
        if($booking_id == "") {
            return false;
        } else {
            $sql 		= "SELECT * FROM " . TABLE_PROPERTY_BOOKINGS . " WHERE booking_id='".$booking_id."'";
            $rs 		= $this->dbObj->createRecordset($sql);
            if($this->dbObj->getRecordCount($rs) > 0){
                $arr 	= $this->dbObj->fetchAssoc($rs);
                return $arr[0];
            } else {
                return false;
            }
        }
	}

	// Function	for delete booking
	function fun_delPropertyBooking($booking_id) {
		if($booking_id == '') {
			return false;
		} else {
			// Step I: Delete records booking from database
			$this->dbObj->deleteRow(TABLE_PROPERTY_BOOKINGS, "booking_id", $booking_id);
			return true;
		}
	}

	// Function	for activate booking
	function fun_activatePropertyBooking($booking_id) {
		if($booking_id == '') {
			return false;
		} else {

			$this->dbObj->updateField(TABLE_PROPERTY_BOOKINGS, "booking_id", $booking_id, "active", "1");
			return true;
		}
	}

	// This function will Return Booking User information in array with front end data	
	function fun_getBookingPropertiesInfo($booking_id){		
        if($booking_id == "") {
            return false;
        } else {
            $sql 	= "SELECT B.property_id, B.property_name, B.property_title, B.property_summary  
            FROM " . TABLE_PROPERTY_BOOKINGS . " AS A 
            INNER JOIN " . TABLE_PROPERTY . " AS B ON A.property_id = B.property_id 
            WHERE A.booking_id='".$booking_id."'";
			$sql .= " AND B.active='1'";
            $rs = $this->dbObj->createRecordset($sql);
            if($this->dbObj->getRecordCount($rs) > 0){
                $arr = $this->dbObj->fetchAssoc($rs);
                return $arr;
            } else {
                return false;
            }
        }
	}

	// This function will Return Booking User information in array with front end data	
	function fun_getPropertyBookingRelationInfo($booking_id, $property_id = ''){		
        if($booking_id == "") {
            return false;
        } else {
            $sql 	= "SELECT A.booking_id, A.message, B.property_id, B.property_name, B.property_title 
            FROM " . TABLE_PROPERTY_BOOKINGS . " AS A 
            INNER JOIN " . TABLE_PROPERTY . " AS B ON A.property_id = B.property_id 
            WHERE A.booking_id='".$booking_id."'";
			if($property_id != "") {
				$sql .=" AND B.property_id='".$property_id."'";
			}
            $rs 	= $this->dbObj->createRecordset($sql);
            if($this->dbObj->getRecordCount($rs) > 0){
                $arr 	= $this->dbObj->fetchAssoc($rs);
                return $arr;
            } else {
                return false;
            }
        }
	}

	// This function will Return Booking User information in array with front end data	
	function fun_getPropertyBookingRelationAdminInfo($booking_id, $property_id = ''){		
        if($booking_id == "") {
            return false;
        } else {
            $sql 	= "SELECT A.booking_id, B.property_id, B.property_name, B.property_title 
            FROM " . TABLE_PROPERTY_BOOKINGS . " AS A 
            INNER JOIN " . TABLE_PROPERTY . " AS B ON A.property_id = B.property_id 
            WHERE A.booking_id='".$booking_id."'";
			if($property_id != "") {
				$sql .=" AND B.property_id='".$property_id."'";
			}
            $rs 	= $this->dbObj->createRecordset($sql);
            if($this->dbObj->getRecordCount($rs) > 0){
                $arr 	= $this->dbObj->fetchAssoc($rs);
                return $arr;
            } else {
                return false;
            }
        }
	}

	// This function will Return Booking information in array with front end data
	function fun_getPropertyUserBookingArr($user_id, $parameter = ''){
        if($user_id == "") {
            return false;
        } else {
            $sql = "SELECT A.user_id, A.booking_id, A.property_id, B.owner_id, A.created_on, CONCAT(RTRIM(C.user_fname), ' ', RTRIM(C.user_lname)) AS user_name
				FROM " . TABLE_PROPERTY_BOOKINGS . " AS A 
                INNER JOIN " . TABLE_PROPERTY_OWNER_RELATIONS . " AS B ON A.property_id = B.property_id,
                " . TABLE_USERS . " AS C
                WHERE C.user_id = '".$user_id."' AND A.active ='1' AND C.user_id = A.user_id ";
			if($parameter != ""){
				$sql .= $parameter;
			} else {
				$sql .= " ORDER BY A.booking_id";		
			}
			return $rs = $this->dbObj->createRecordset($sql);
        }
	}

	// This function will Return Booking information in array with front end data
	function fun_getPropertyOwnerBookingArr($owner_id, $parameter = ''){
        if($owner_id == "") {
            return false;
        } else {
            $sql = "SELECT A.user_id, A.booking_id, A.property_id, B.owner_id, A.created_on, CONCAT(RTRIM(C.user_fname), ' ', RTRIM(C.user_lname)) AS user_name,delete_status
				FROM " . TABLE_PROPERTY_BOOKINGS . " AS A 
                INNER JOIN " . TABLE_PROPERTY_OWNER_RELATIONS . " AS B ON A.property_id = B.property_id,
                " . TABLE_USERS . " AS C
                WHERE B.owner_id = '".$owner_id."' AND A.active ='1' AND C.user_id = A.user_id ";
			if($parameter != ""){
				$sql .= $parameter;
			} else {
				$sql .= " ORDER BY A.created_on DESC";		
			}
			return $rs = $this->dbObj->createRecordset($sql);
        }
	}

	// This function will Return Booking information in array with front end data
	function fun_getPropertyBookingInfoArr($parameter = '') {

		$sql = "SELECT 
			A.*, 
			C.property_name, 
			B.owner_id, 
			CONCAT(RTRIM(D.user_fname), ' ', RTRIM(D.user_lname)) AS user_name,
			D.user_email AS user_email, 
			CONCAT(RTRIM(E.user_fname), ' ', RTRIM(E.user_lname)) AS owner_name,
			E.user_email AS owner_email
			FROM " . TABLE_PROPERTY_BOOKINGS . " AS A 
			INNER JOIN " . TABLE_PROPERTY_OWNER_RELATIONS . " AS B ON A.property_id = B.property_id
			INNER JOIN " . TABLE_PROPERTY . " AS C ON A.property_id = C.property_id,
			" . TABLE_USERS . " AS D,
			" . TABLE_USERS . " AS E
			WHERE  A.active ='1' AND D.user_id = A.user_id AND E.user_id = B.owner_id ";
		if($parameter != ""){
			$sql .= $parameter;
		} else {
			$sql .= " ORDER BY A.created_on DESC";		
		}
		$rs = $this->dbObj->createRecordset($sql);
        return $arr = $this->dbObj->fetchAssoc($rs);
	}

	// This function will Return Booking information in array with front end data
	function fun_countPropertyUserBooking($user_id){
        if($user_id == "") {
            return false;
        } else {
			$sql 		= "SELECT A.user_id, A.booking_id, A.property_id FROM " . TABLE_PROPERTY_BOOKINGS . " AS A WHERE A.user_id='".$user_id."' AND A.active ='1'";
			$rs 		= $this->dbObj->createRecordset($sql);
			return $this->dbObj->getRecordCount($rs);
        }
	}

	// This function will Return Booking information in array with front end data
	function fun_countPropertyOwnerBookings($owner_id){
        if($owner_id == "") {
            return false;
        } else {
            $sql = "SELECT A.user_id, A.booking_id, A.property_id, B.owner_id, A.created_on, CONCAT(RTRIM(C.user_fname), ' ', RTRIM(C.user_lname)) AS user_name
				FROM " . TABLE_PROPERTY_BOOKINGS . " AS A 
                INNER JOIN " . TABLE_PROPERTY_OWNER_RELATIONS . " AS B ON A.property_id = B.property_id,
                " . TABLE_USERS . " AS C
                WHERE B.owner_id = '".$owner_id."' AND A.active ='1' AND C.user_id = A.user_id ";
			$rs = $this->dbObj->createRecordset($sql);
            if($this->dbObj->getRecordCount($rs) > 0){
                return $this->dbObj->getRecordCount($rs);
            } else {
                return "0";
            }
        }
	}

	// This function will Return New Booking information in array with front end data
	function fun_countPropertyOwnerNewBookings($owner_id){
        if($owner_id == "") {
            return false;
        } else {
            $sql = "SELECT A.user_id, A.booking_id, A.property_id, B.owner_id, A.created_on, CONCAT(RTRIM(C.user_fname), ' ', RTRIM(C.user_lname)) AS user_name
				FROM " . TABLE_PROPERTY_BOOKINGS . " AS A 
                INNER JOIN " . TABLE_PROPERTY_OWNER_RELATIONS . " AS B ON A.property_id = B.property_id,
                " . TABLE_USERS . " AS C
                WHERE B.owner_id = '".$owner_id."' AND A.active ='1' AND C.user_id = A.user_id AND A.view_status ='0' ";
			$rs = $this->dbObj->createRecordset($sql);
            if($this->dbObj->getRecordCount($rs) > 0){
                return $this->dbObj->getRecordCount($rs);
            } else {
                return "0";
            }

        }
	}

	// Function for creating property owner details section 4 property preview
	function fun_getPropertyContactOwnerBookingName($property_id){		
		if($property_id == ''){
			return false;
		} else {
			return $contact_name = $this->dbObj->getField(TABLE_PROPERTY_CONTACTS, "property_id", $property_id, "contact_name");
		}
	}

	
	function fun_updatePropertyBookingViewStatus($booking_id, $payment_status = '') {
        if($booking_id == "") {
        	return false;
        } else {
            $sqlUpdateQuery = "UPDATE " . TABLE_PROPERTY_BOOKINGS . " SET payment_status = '".$payment_status."' WHERE booking_id='".$booking_id."'";
            $this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
        	return true;
        }
	}

	function fun_getPropertyBookingViewStatus($booking_id) {
		if($booking_id == ''){
			return false;
		} else {
			return $payment_status = $this->dbObj->getField(TABLE_PROPERTY_BOOKINGS, "booking_id", $booking_id, "payment_status");
		}
	}

	function fun_sendPropertyBookingNotification($booking_id) {
		if($booking_id == '') {
			return false;		
		} else {
			$usersObj 				= new Users();
			$bookingInfoArr 		= $this->fun_getPropertyBookingInfo($booking_id);
			$txtPhone 				= $bookingInfoArr['phone'];
			$txtAdults 				= $bookingInfoArr['adults'];
			$txtChilds 				= $bookingInfoArr['childs'];
			$txtInfants 			= $bookingInfoArr['infants'];
			$travelArr = array();
			if(isset($txtAdults) && $txtAdults > 0) {
				array_push($travelArr, ($txtAdults > 1)?$txtAdults." adults":$txtAdults." adult");
			}
			if(isset($txtChilds) && $txtChilds > 0) {
				array_push($travelArr, ($txtChilds > 1)?$txtChilds." children":$txtChilds." children");
			}
			if(isset($txtInfants) && $txtInfants > 0) {
				array_push($travelArr, ($txtInfants > 1)?$txtInfants." infants":$txtInfants." infant");
			}

			$txtArriavalDate 		= $bookingInfoArr['arrival_date'];
			$arriavalDateArr 		= explode("-", $txtArriavalDate);
			$txtDayArrival0 		= $arriavalDateArr[2];
			$txtMonthArrival0 		= $arriavalDateArr[1];
			$txtYearArrival0 		= $arriavalDateArr[0];

			$txtDepartureDate 		= $bookingInfoArr['departure_date'];
			$departureDateArr 		= explode("-", $txtArriavalDate);
			$txtDayDeparture0 		= $departureDateArr[2];
			$txtMonthDeparture0 	= $departureDateArr[1];
			$txtYearDeparture0 		= $departureDateArr[0];

	
	//		$txtDuration 			= $bookingInfoArr['duration'];
			
			$txtDepartDateTime		= mktime(0, 0, 0, $txtMonthArrival0, (int)($txtDayArrival0+$txtDuration), $txtYearArrival0);
			$txtUserBooking 		= $bookingInfoArr['message'];
			$txtCreatedOn	 		= $bookingInfoArr['created_on'];

			$bookingUserInfoArr 	= $usersObj->fun_getUserBookingInfo($booking_id);
			$txtUserId 				= $bookingUserInfoArr['user_id'];
			$txtUserFName 			= $bookingUserInfoArr['user_fname'];
			$txtUserLName 			= $bookingUserInfoArr['user_lname'];
			$txtUserEmail 			= $bookingUserInfoArr['txtUserEmail'];
			$UserName				= $txtUserFName." ".$txtUserLName;
			$bookingPropertyInfoArr 	= $this->fun_getPropertyBookingRelationInfo($booking_id, '');
			if(is_array($bookingPropertyInfoArr) && count($bookingPropertyInfoArr) > 0) {
				$booking_html = "";
				for($i = 0; $i < count($bookingPropertyInfoArr); $i++) {
					$property_id 	= $bookingPropertyInfoArr[$i]['property_id'];
					$owner_id 		= $this->dbObj->getField(TABLE_PROPERTY_OWNER_RELATIONS, "property_id", $property_id, "owner_id");

					$property_name 	= $bookingPropertyInfoArr[$i]['property_name'];
					$property_title	= $bookingPropertyInfoArr[$i]['property_title'];
					$booking_html .= "<table width=\"580\" border=\"0\" cellpadding=\"5\" cellspacing=\"0\">";
					$booking_html .= "<tr>";
					$booking_html .= "<td width=\"155\" align=\"right\" valign=\"top\">";
					$propertyMImgInfo	= $this->fun_getPropertyMainThumb($property_id);
					if(is_array($propertyMImgInfo) && count($propertyMImgInfo) > 0) {
						$imgid 		= $propertyMImgInfo[0]['photo_id'];
						$imgcap 	= ucfirst($propertyMImgInfo[0]['photo_caption']);
						$imgcap		= addslashes($imgcap);
						$imgthumb 	= SITE_URL."upload/property_images/thumbnail/168x126/".$propertyMImgInfo[0]['photo_thumb'];
						$booking_html .= "<img src=\"".$imgthumb."\" alt=\"".$imgcap."\" width=\"168\" height=\"126\" />";
					} else {
						$imgcap		= "No Image";
						$imgthumb 	= SITE_URL."upload/property_images/thumbnail/168x126/no-img.gif";
						$booking_html .= "<img src=\"".$imgthumb."\" alt=\"".$imgcap."\" width=\"168\" height=\"126\" />";
					}
					$booking_html .= "</td>";
					$booking_html .= "<td valign=\"middle\" style=\"padding-left:15px;\">";
					$booking_html .= "<table width=\"490\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
					$booking_html .= "<tr>";
					$booking_html .= "<td width=\"96\" valign=\"top\"><strong>Booking ID</strong></td>";
					$booking_html .= "<td width=\"390\" valign=\"top\">".fill_zero_left($booking_id, "0", (9-strlen($booking_id)))."</td>";
					$booking_html .= "</tr>";
					$booking_html .= "<tr>";
					$booking_html .= "<td valign=\"top\"><strong>From</strong></td>";
					$booking_html .= "<td valign=\"top\">".$txtUserName."</td>";
					$booking_html .= "</tr>";
					$booking_html .= "<tr>";
					$booking_html .= "<td valign=\"top\"><strong>Email</strong></td>";
					$booking_html .= "<td valign=\"top\"><a href=\"mailto:".$txtUserEmail."\" style=\"color:#357bdc; text-decoration: none;\" >".$txtUserEmail."</a></td>";
					$booking_html .= "</tr>";
					$booking_html .= "<tr>";
					$booking_html .= "<td valign=\"top\"><strong>Phone </strong></td>";
					$booking_html .= "<td valign=\"top\">".$txtPhone."</td>";
					$booking_html .= "</tr>";
					$booking_html .= "<tr>";
					$booking_html .= "<td valign=\"top\"><strong>Property ID</strong></td>";
					$booking_html .= "<td valign=\"top\">".fill_zero_left($property_id, "0", (6-strlen($property_id)))."</td>";
					$booking_html .= "</tr>";
					$booking_html .= "<tr>";
					$booking_html .= "<td valign=\"top\"><strong>Property name</strong></td>";
					$booking_html .= "<td valign=\"top\"><a href=\"".SITE_URL."property.php?pid=".$property_id."\" style=\"color:#357bdc; text-decoration: none;\" >".ucfirst($property_name)."</a></td>";
					$booking_html .= "</tr>";
					$booking_html .= "<tr>";
					$booking_html .= "<td valign=\"top\"><strong>Booking date</strong></td>";
					$booking_html .= "<td valign=\"top\">".date('M j, Y', $txtCreatedOn)."</td>";
					$booking_html .= "</tr>";
					$booking_html .= "<tr>";
					$booking_html .= "<td valign=\"top\">&nbsp;</td>";
					$booking_html .= "<td valign=\"top\">&nbsp;</td>";
					$booking_html .= "</tr>";
					$booking_html .= "<tr>";
					$booking_html .= "<td valign=\"top\"><strong>Who&rsquo;s travelling</strong></td>";
					$booking_html .= "<td valign=\"top\">".implode(", ", $travelArr)."</td>";
					$booking_html .= "</tr>";
					$booking_html .= "<tr>";
					$booking_html .= "<td valign=\"top\"><strong>When</strong></td>";
					$booking_html .= "<td valign=\"top\"><strong>Arrive</strong> ".date('M j, Y', strtotime($txtArriavalDate))." for ".$txtDuration." nights, <strong>Depart</strong> ".date('M j, Y', $txtDepartDateTime)."<br />Dates flexible by ".$txtFlexibleDays." days</td>";
					$booking_html .= "</tr>";
					$booking_html .= "<tr>";
					$booking_html .= "<td valign=\"top\"><strong>Message</strong></td>";
					$booking_html .= "<td valign=\"top\">".$txtUserBooking."</td>";
					$booking_html .= "</tr>";
					$booking_html .= "</table>";
					$booking_html .= "</td>";
					$booking_html .= "</tr>";
					$booking_html .= "<tr><td colspan=\"2\" align=\"right\" valign=\"middle\">&nbsp;</td></tr>";
					$booking_html .= "</table>";

					if($this->sendBookingEmailToOwner($owner_id, $booking_html, '') && $this->sendBookingEmailToUser($txtUserId, $booking_html, '')) {
						$booking_html = "";
						return true;
					}
				}
			} else {
				return false;		
			}
		}
	}

	function sendBookingEmailToOwner($owner_id, $message = '', $booking_footer = '') {
		// Step 1: Find user details
		$usersObj 		= new Users();
		$userDats 		= $usersObj->fun_getUsersInfo($owner_id);
		$user_fname		= ucfirst($userDats['user_fname']);
		$txtUserEmail= $userDats['txtUserEmail'];

$msg = '<table width="600"  border="0" cellspacing="10" cellpadding="0">';
$msg .= '<tr><td align="left"><a href="'.SITE_URL.'"><img src="'.SITE_URL.'images/logo.jpg" border="0"></a></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><strong>Dear '.$user_fname.', you\'ve just received an booking ...</strong></td></tr>
<tr><td>Please remember to reply even if you can\'t accommodate it this time.</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>Regards,</td></tr>
<tr><td>The '.$_SERVER["SERVER_NAME"].' team</td></tr>';
if($message != "") {
	$msg .= '<tr><td style=\"padding-left:20px; padding-right:20px;\" ><hr>'.$message.'</td></tr>';
}
if($booking_footer != "") {
	$msg .= '<tr><td style=\"padding-left:20px; padding-right:20px;\" ><hr>'.$booking_footer.'</td></tr>';
}
$msg .= '</table>';

		$emailObj = new Email($txtUserEmail , "Administrator | rentownersvillas.com <".SITE_INFO_EMAIL.">", "You've just received a new booking on ".$_SERVER["SERVER_NAME"], $msg);
		//$emailObj = new Email($txtUserEmail , SITE_INFO_EMAIL, "You've just received a new booking on ".$_SERVER["SERVER_NAME"], $msg);
		if($emailObj->sendEmail()) {
			$emailObj1 = new Email("admin@rentownersvillas.com", SITE_INFO_EMAIL, "You've just received a new booking on ".$_SERVER["SERVER_NAME"], $msg);
			$emailObj1->sendEmail();
			return true;
		} else {
			return false;
		}
	}

	function sendBookingEmailToUser($user_id, $message = '', $booking_footer = '') {
		// Step 1: Find user details
		$usersObj 		= new Users();
		$userDats 		= $usersObj->fun_getUsersInfo($user_id);
		$user_fname		= ucfirst($userDats['user_fname']);
		$txtUserEmail	= $userDats['txtUserEmail'];

$msg = '<table width="600"  border="0" cellspacing="10" cellpadding="0">';
$msg .= '<tr><td align="left"><a href="'.SITE_URL.'"><img src="'.SITE_URL.'images/logo.jpg" border="0"></a></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><strong>Dear '.$user_fname.', thanks for using rentownersvillas.com.</strong></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><strong>Below is a copy of your booking.</strong></td></tr>
<tr><td>Please keep this email and the Booking ID for future reference. We will need this information if you ever need to contact us about your booking.</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>Our owners are pretty good at getting in touch so keep an eye on your inbox. If they do not respond then try calling them using the contact number quoted on their listing.</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>We hope you\'ve found the perfect holiday accommodation.</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>Regards,</td></tr>
<tr><td>rentownersvillas.com team</td></tr>';
if($message != "") {
	$msg .= '<tr><td style=\"padding-left:20px; padding-right:20px;\" ><hr>'.$message.'</td></tr>';
}
if($booking_footer != "") {
	$msg .= '<tr><td style=\"padding-left:20px; padding-right:20px;\" ><hr>'.$booking_footer.'</td></tr>';
}
$msg .= '</table>';

		$emailObj = new Email($txtUserEmail , "Administrator | rentownersvillas.com <".SITE_INFO_EMAIL.">", "Your booking has been sent on rentownersvillas.com", $msg);
		//$emailObj = new Email($txtUserEmail , SITE_INFO_EMAIL, "Your booking has been sent on rentownersvillas.com", $msg);
		if($emailObj->sendEmail()) {
			$emailObj1 = new Email("admin@rentownersvillas.com", SITE_INFO_EMAIL, "Your booking has been sent on rentownersvillas.com", $msg);
			$emailObj1->sendEmail();
			return true;
		} else {
			return false;
		}
	}

	function fun_createPropertySelectTripDuration($property_id, $name='', $id='', $class='', $selected='', $onchange=''){
		if($property_id == '') {
			return false;
		} else {
			$cur_unixtime 	= time ();
			$sql 	= "SELECT min_stay AS stay FROM " . TABLE_PROPERTY_PRICES . " WHERE property_id='".$property_id."' ORDER BY min_stay LIMIT 0,1";
			$rs 	= $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);
				$min_stay = $arr[0]['stay'];
				echo "<select name='".$name."' id='".$id."' class='".$class."'  onchange='".$onchange."'>";
				echo "<option value=''>Select Duration...</option>";
				for($i=$min_stay; $i <= 90; $i++){
					if($i == $selected){
						echo "<option value='$i' selected>$i nights</option>";
					} else {
						echo "<option value='$i'>$i nights</option>";
					}
				}
				echo "</select>";
			}
		}
	}

	function fun_createPropertyBookTrip($property_id, $date_from = '', $date_to = '', $mindays = '', $currency_code = ''){
		if($property_id == '') {
			return false;
		} else {
			$cur_unixtime 	= time();
			if(isset($date_from) && $date_from != "") {
				list($year, $month, $day) = explode("-", $date_from);
			} else {
				$year 	= date("Y");
				$month 	= date("m");
				$day 	= date("d");
			}
			$currency_code = ($currency_code != "")?$currency_code:1;
			$currency_symbol = $this->dbObj->getField(TABLE_CURRENCIES, "currency_code", $currency_code, "currency_symbol");

			$availabilityArr 	= $this->fun_getPropertyAvailabilityArr($property_id, $year, $month, $day);
			// From date
			$date_arrival = (strtotime($availabilityArr[0]['startdate']) > $cur_unixtime)?((strtotime($availabilityArr[0]['startdate']) > strtotime($date_from))?$availabilityArr[0]['startdate']:$date_from):(($cur_unixtime > strtotime($date_from))?date("Y-m-d"):$date_from);

			if(isset($date_to) && $date_to != "") {
				$date_departure = $date_to;
			} else if(isset($mindays) && $mindays != ""){
				$date_departure = date("Y-m-d", (strtotime($date_arrival)+($mindays*24*60*60)));
			}
			
			$booking_cost = $this->fun_getPropertyBookingCost($property_id, $date_arrival, $date_departure, $currency_code);
			$bookingCharge =  $this->fun_getBookingCharges($property_id);	
			(!empty($bookingCharge)) ? $bookingCharge : '10';

			$deposite_cost= round(((($booking_cost) * $bookingCharge)/100),0) ;

			echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
			echo '<tr>';

            echo '<td style="border-bottom:1px solid #d2d2d2;"><strong>From: </strong></td>';
            echo '<td style="border-bottom:1px solid #d2d2d2;"><strong>To: </strong></td>';
            echo '<td style="border-bottom:1px solid #d2d2d2;"><strong>Cost: </strong></td>';
            echo '<td style="border-bottom:1px solid #d2d2d2;"><strong>Deposit:</strong></td>';
       		echo '</tr>';
			echo '<tr>';
			echo '<td>'.date("M d, y", strtotime($date_arrival)).'</td>';
			echo '<td>'.date("M d, y", strtotime($date_departure)).'</td>';
			echo '<td>'.$currency_symbol;
			echo $booking_cost;
			echo '</td>';
			echo '<td>'.$currency_symbol;
			echo $deposite_cost;
		//	echo '<td><div class="buttonBook"><a href="javascript:void(0);" onclick="submitTripDuration(\''.$date_arrival.'\', \''.$date_departure.'\')"><img src="'.SITE_IMAGES.'Booknow.gif" alt="Book now" /></a></div></td>';
			echo '</td>';
			echo '</tr>';
			echo '</table>';
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
			echo '<tr>';
			echo '<td colspan="4" align="left" valign="top" class="pad-top10 pad-btm10"><strong>By submit this booking form, you understand that reservations are NOT guaranteed until you get a confirmation email and send a deposit to the owner.<br>Property rental prices are subject to change without notice until a reservation is guaranteed in this manner.</strong></td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td height="65" colspan="4" align="center" valign="bottom"><div class="buttonBook"><a href="javascript:void(0);" onclick="submitTripDuration(\''.$date_arrival.'\', \''.$date_departure.'\')" class="button-blue">Book this property now</a></div></td>';
			echo '</tr>';
			echo '</table>';
	
		}
	}

	function fun_getPropertyBookingCost($property_id, $date_arrival, $date_departure, $currency_code){		
		if($property_id == '') {
			return false;
		} else {
			$dateArr = createDateRangeArray($date_arrival, $date_departure);
			if(is_array($dateArr) && !empty($dateArr)) {
				$cost = 0;
				foreach($dateArr as $key => $value) {
				 $cost += $this->fun_getPropertyBookingCostByDate($property_id, $value, $currency_code);
				}
				$tax_rate 			= $this->dbObj->getField(TABLE_PROPERTY_PRICE_NOTES, "property_id", $property_id, "tax_rate");
				$cleaning_charge 	= $this->dbObj->getField(TABLE_PROPERTY_PRICE_NOTES, "property_id", $property_id, "cleaning_charge");
				$final_cost 		= ($cost+(($cost*$tax_rate)/100)+$cleaning_charge);
				return $final_cost;
			} else {
				return false;
			}
		}
	}	

	function fun_getPropertyBookingCostDeposite($property_id, $date_arrival, $date_departure, $currency_code){		
		if($property_id == '') {
			return false;
		} else {
			$dateArr = createDateRangeArray($date_arrival, $date_departure);
			if(is_array($dateArr) && !empty($dateArr)) {
				$cost = 0;
				foreach($dateArr as $key => $value) {
					$cost += $this->fun_getPropertyBookingCostByDate($property_id, $value, $currency_code);
				}
				$bookingCharge =  $this->fun_getBookingCharges($property_id);	
				(!empty($bookingCharge)) ? $bookingCharge : '50';

				$tax_rate 			= $this->dbObj->getField(TABLE_PROPERTY_PRICE_NOTES, "property_id", $property_id, "tax_rate");
				$cleaning_charge 	= $this->dbObj->getField(TABLE_PROPERTY_PRICE_NOTES, "property_id", $property_id, "cleaning_charge");
				$final_cost 		= ($cost+(($cost*$tax_rate)/100)+$cleaning_charge);
				$deposite 			= round(((($final_cost) * $bookingCharge)/100),0) ;
				return $deposite;
			} else {
				return false;
			}
		}
	}	


	function fun_getPropertyBookingCostByDate($property_id, $date, $currency_code){
		if($property_id == '' || $date == '') {
			return 0;
		} else {
			$sql 	= "SELECT per_week_price, currency_code FROM " . TABLE_PROPERTY_PRICES . " WHERE property_id ='".$property_id."' AND (FROM_UNIXTIME(date_from, '%Y-%m-%d')='".$date."' OR FROM_UNIXTIME(date_from, '%Y-%m-%d')<'".$date."') AND (FROM_UNIXTIME(date_to, '%Y-%m-%d')='".$date."' OR FROM_UNIXTIME(date_to, '%Y-%m-%d')>'".$date."') ";
			$rs 	= $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);
				$user_currency_id = $this->dbObj->getField(TABLE_CURRENCIES, "currency_code", $currency_code, "currency_id");
				$price = (($arr[0]['per_week_price'])/7);
				$price = $this->fun_getConvertedCurrency($arr[0]['currency_code'], $user_currency_id, $price);
				//echo $price;
				return round($price, 2);
			} else {
				return 0;
			}
		}
	}	
	
		// This function will Return Booking information in array with front end data
	function fun_getPropertyBookingInfoByPropertyId($property_id){		
        if($property_id == "") {
            return false;
        } else {
            $sql 		= "SELECT * FROM " . TABLE_PROPERTY_BOOKINGS . " WHERE property_id='".$property_id."'";
            $rs 		= $this->dbObj->createRecordset($sql);
            if($this->dbObj->getRecordCount($rs) > 0){
                $arr 	= $this->dbObj->fetchAssoc($rs);
				$arr1 = array();
				
                foreach($arr as $value) {
					array_push($arr1, $value);
				}	
				return $arr1;
            } else {
                return false;
            }
        }
	}

/*
* Property Booking specific functions : end here
*/

/*
* Home module (Popular destinations) : start here
*/
	function fun_createPropertyPopularDestination(){		
		$strHTML 	= '';
		$arrPopular = array();
		$sql 	= "SELECT DISTINCT B.area_id, B.area_name, B.country_id FROM " . TABLE_PROPERTY . " AS A 
					INNER JOIN " . TABLE_AREA . " AS B ON A.area_id = B.area_id 
					WHERE A.active='1' AND A.status='2' AND A.area_id > 0 ORDER BY RAND() LIMIT 0,5";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			$arr 	= $this->dbObj->fetchAssoc($rs);
			foreach($arr as $value) {
			//print_r($value);
				$total_properties	= $this->fun_countPropertyByDestination($value['country_id'], $value['area_id']);
				$location_name		= $value['area_name'].', '.$this->dbObj->getField(TABLE_COUNTRIES, "countries_id", $value['country_id'], "countries_name");
				array_push($arrPopular, array($value['area_name'], $location_name, $total_properties));
			}
		}
		
		if(is_array($arrPopular) && count($arrPopular) <5) {
			$sql1 	= "SELECT DISTINCT B.region_id, B.region_name FROM " . TABLE_PROPERTY . " AS A 
						INNER JOIN " . TABLE_REGION . " AS B ON A.region_id = B.region_id 
						WHERE A.active='1' AND A.status='2' AND A.region_id > 0 ORDER BY RAND() LIMIT 0,5";
			$rs1 	= $this->dbObj->createRecordset($sql1);
			if($this->dbObj->getRecordCount($rs1) > 0) {
				$arr1 	= $this->dbObj->fetchAssoc($rs1);
				foreach($arr1 as $value1) {
					$area_id 	= $this->dbObj->getField(TABLE_REGION, "region_id", $value1['region_id'], "area_id");
					$country_id = $this->dbObj->getField(TABLE_AREA, "area_id", $area_id, "country_id");
					$total_properties	= $this->fun_countPropertyByDestination($country_id, $area_id, $value1['region_id']);
					$location_name		= $value1['region_name'].', '.$this->dbObj->getField(TABLE_COUNTRIES, "countries_id", $country_id, "countries_name");
					array_push($arrPopular, array($value1['region_name'], $location_name, $total_properties));
				}
			}
		}

		if(is_array($arrPopular) && count($arrPopular) >0) {
			$strHTML 	.= '<div class="popular-dest list-2">';
			$strHTML 	.= '<h2>'.ucwords(tranText('popular_destinations')).'</h2>';
			$strHTML 	.= '<ul>';
			for($i=0; $i < count($arrPopular); $i++) {
				$region_name 		= $arrPopular[$i][0];
				$location_name 		= $arrPopular[$i][1];
				$total_properties 	= $arrPopular[$i][2];
				$link 			= SITE_URL."vacation-rentals/in.".str_replace("/", "_", str_replace(" ", "-", strtolower($region_name)));
				$strHTML 		.= '<li><a href="'.$link.'">'.ucfirst($location_name).'</a><span>('.$total_properties.')</span></li>';
			}
			$strHTML 	.= '</ul>';
			$strHTML 	.= '</div>';
		}
		echo $strHTML;
	}


	function fun_createPropertyPopularDestination4Footer(){		
		$strHTML 	= '';
		$arrPopular = array();
		$sql 	= "SELECT DISTINCT B.area_id, B.area_name, B.country_id FROM " . TABLE_PROPERTY . " AS A 
					INNER JOIN " . TABLE_AREA . " AS B ON A.area_id = B.area_id 
					WHERE A.active='1' AND A.status='2' AND A.area_id > 0 ORDER BY RAND() LIMIT 0,5";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			$arr 	= $this->dbObj->fetchAssoc($rs);
			foreach($arr as $value) {
			//print_r($value);
				$total_properties	= $this->fun_countPropertyByDestination($value['country_id'], $value['area_id']);
				$location_name		= $value['area_name'].', '.$this->dbObj->getField(TABLE_COUNTRIES, "countries_id", $value['country_id'], "countries_name");
				array_push($arrPopular, array($value['area_name'], $location_name));
			}
		}
		
		if(is_array($arrPopular) && count($arrPopular) <3) {
			$sql1 	= "SELECT DISTINCT B.region_id, B.region_name FROM " . TABLE_PROPERTY . " AS A 
						INNER JOIN " . TABLE_REGION . " AS B ON A.region_id = B.region_id 
						WHERE A.active='1' AND A.status='2' AND A.region_id > 0 ORDER BY RAND() LIMIT 0,5";
			$rs1 	= $this->dbObj->createRecordset($sql1);
			if($this->dbObj->getRecordCount($rs1) > 0) {
				$arr1 	= $this->dbObj->fetchAssoc($rs1);
				foreach($arr1 as $value1) {
					$area_id 	= $this->dbObj->getField(TABLE_REGION, "region_id", $value1['region_id'], "area_id");
					$country_id = $this->dbObj->getField(TABLE_AREA, "area_id", $area_id, "country_id");
					$location_name		= $value1['region_name'].', '.$this->dbObj->getField(TABLE_COUNTRIES, "countries_id", $country_id, "countries_name");
					array_push($arrPopular, array($value1['region_name'], $location_name));
				}
			}
		}

		if(is_array($arrPopular) && count($arrPopular) >0) {
			$strHTML 	= '';
			for($i=0; $i < count($arrPopular); $i++) {
				$region_name 		= $arrPopular[$i][0];
				$location_name 		= $arrPopular[$i][1];
				$link 			= SITE_URL."vacation-rentals/in.".str_replace("/", "_", str_replace(" ", "-", strtolower($region_name)));
				$strHTML 		.= '<li><a href="'.$link.'"><strong>'.ucfirst($location_name).'</strong></a></li>';
			}
		}
		echo $strHTML;
	}

/*
* Home module (Popular destinations) : start here
*/

	// Function for property stat: Start Here
	function fun_countPropertyRegistr($year, $month = '', $day = '', $active = '', $status = ''){
		if($year == ''){
			return false;
		} else {
			$start_date = mktime(0, 0, 0, (($month != "")?$month:1), (($day != "")?$day:1), $year);
			$end_date = mktime(23, 59, 59, (($month != "")?$month:12), (($day != "")?$day:31), $year);
			$sql = "SELECT COUNT(*) total_result FROM  " . TABLE_PROPERTY . " WHERE created_on > ".$start_date." AND created_on < ".$end_date." ";

			if($active != "") {
				$sql .= " AND active ='".$active."' ";
			}
			if($status != "") {
				$sql .= " AND status ='".$status."' ";
			}
	
			$rs = $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);
				$total_result = $arr[0]['total_result'];
			} else {
				$total_result = 0;
			}
			return $total_result;
		}
	}

	function fun_createPropertyStats($year){
		if($year == ''){
			return false;
		} else {
			$strHTML 	= '';
			$strHTML 	.= '<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EventListing2">';
			$strHTML 	.= '<thead>';
			$strHTML 	.= '<tr>';
			$strHTML 	.= '<th class="left tableHeader" scope="col">&nbsp;</th>';
			$strHTML 	.= '<th align="center" class="tableHeader" scope="col">Jan</th>';
			$strHTML 	.= '<th align="center" scope="col" class="tableHeader">Feb</th>';
			$strHTML 	.= '<th align="center" scope="col" class="tableHeader">Mar</th>';
			$strHTML 	.= '<th align="center" scope="col" class="tableHeader">Apr</th>';
			$strHTML 	.= '<th align="center" scope="col" class="tableHeader">May</th>';
			$strHTML 	.= '<th align="center" scope="col" class="tableHeader">Jun</th>';
			$strHTML 	.= '<th align="center" scope="col" class="tableHeader">Jul</th>';
			$strHTML 	.= '<th align="center" scope="col" class="tableHeader">Aug</th>';
			$strHTML 	.= '<th align="center" scope="col" class="tableHeader">Sep</th>';
			$strHTML 	.= '<th align="center" scope="col" class="tableHeader">Oct</th>';
			$strHTML 	.= '<th align="center" scope="col" class="tableHeader">Nov</th>';
			$strHTML 	.= '<th align="center" class="right tableHeader" scope="col">Dec</th>';
			$strHTML 	.= '</tr>';
			$strHTML 	.= '</thead>';
			$strHTML 	.= '<tbody>';
			$strHTML 	.= '<tr>';
			$strHTML 	.= '<td align="left" class="left" width="125">Total number of NEW<br />properties</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countPropertyRegistr($year, 1, "", "", "").'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countPropertyRegistr($year, 2, "", "", "").'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countPropertyRegistr($year, 3, "", "", "").'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countPropertyRegistr($year, 4, "", "", "").'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countPropertyRegistr($year, 5, "", "", "").'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countPropertyRegistr($year, 6, "", "", "").'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countPropertyRegistr($year, 7, "", "", "").'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countPropertyRegistr($year, 8, "", "", "").'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countPropertyRegistr($year, 9, "", "", "").'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countPropertyRegistr($year, 10, "", "", "").'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countPropertyRegistr($year, 11, "", "", "").'</td>';
			$strHTML 	.= '<td align="center" class="right">'.$this->fun_countPropertyRegistr($year, 12, "", "", "").'</td>';
			$strHTML 	.= '</tr>';
			$strHTML 	.= '<tr>';
			$strHTML 	.= '<td align="left" class="left">Total number of NEW<br />approved properties</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countPropertyRegistr($year, 1, "", 1, "").'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countPropertyRegistr($year, 2, "", 1, "").'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countPropertyRegistr($year, 3, "", 1, "").'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countPropertyRegistr($year, 4, "", 1, "").'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countPropertyRegistr($year, 5, "", 1, "").'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countPropertyRegistr($year, 6, "", 1, "").'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countPropertyRegistr($year, 7, "", 1, "").'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countPropertyRegistr($year, 8, "", 1, "").'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countPropertyRegistr($year, 9, "", 1, "").'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countPropertyRegistr($year, 10, "", 1, "").'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countPropertyRegistr($year, 11, "", 1, "").'</td>';
			$strHTML 	.= '<td align="center" class="right">'.$this->fun_countPropertyRegistr($year, 12, "", 1, "").'</td>';
			$strHTML 	.= '</tr>';
			$strHTML 	.= '</tbody>';
			$strHTML 	.= '</table>';
			echo $strHTML;
		}
	}

	// Function for creating property "Further Details" section
	function fun_createPropertyOverviewDetails($property_id = ''){		
		$sqlFeaturesIds 	= "SELECT * FROM " . TABLE_PROPERTY_FEATURES_RELATIONS . " WHERE property_id='".$property_id."'";
		$rsFeatures 		= $this->dbObj->createRecordset($sqlFeaturesIds);
		$arrFeatures 		= $this->dbObj->fetchAssoc($rsFeatures);
		$featureArr 		= explode(",", $arrFeatures[0]['feature_ids']);

		$holiday_type_note 	= $arrFeatures[0]['holiday_type_note'];
		$kitchen_note 		= $arrFeatures[0]['kitchen_note'];
		$entertainment_note = $arrFeatures[0]['entertainment_note'];
		$outside_note 		= $arrFeatures[0]['outside_note'];
		$general_note 		= $arrFeatures[0]['general_note'];
		$activities_note 	= $arrFeatures[0]['activities_note'];
		$heating_cooling_note= $arrFeatures[0]['heating_cooling_note'];
		$services_note 		= $arrFeatures[0]['services_note'];
		$location_note 		= $arrFeatures[0]['location_note'];

		$strHTML = "";
		$strHTML .= "\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
		$strHTML .= "\n<tr>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" width=\"230px\">\n";
		$strHTML .= "\n<table width=\"100%\" cellpadding=\"0\" valign=\"top\" height=\"327px\" cellspacing=\"0\" style=\"border:1px solid #9F9F9F;\">\n";
		$strHTML .= "\n<tr><td align=\"left\" valign=\"top\" class=\"font16-darkgrey pad-lft10 pad-top10 pad-btm5\"><strong>Holiday type</strong></td></tr>\n";
		// For Holiday type
		$sql = "SELECT * FROM " . TABLE_PROPERTY_FEATURES . " WHERE property_features_group_id ='1' ORDER BY property_features_name";
		$strHTML .= "\n<tr>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" class=\"pad-lft10 pad-top5 pad-btm15\">\n";
		$strHTML .= "\n<table width=\"100%\" valign=\"top\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"font12\"><tbody>\n";
		$strHTML .= "<tr height=\"2px\"><td width=\"20px\"></td><td></td>\n";

		$rs = $this->dbObj->createRecordset($sql);
		$arr = $this->dbObj->fetchAssoc($rs);
		$i = 0;
		foreach($arr as $value){
			if($i%1 == 0){
				$strHTML .= "</tr>\n<tr class=\"Summary\">";
			}
			if(array_search($value['property_features_id'], $featureArr) === false){
				$strHTML .= "<td><p class=\"SummaryCross dash-btm\" name='txtFeatures[]'>" .ucwords($value['property_features_name']). "</p></td>";
			} else {
				$strHTML .=	"<td><p class=\"dash-btm SummaryTick\" name='txtFeatures[]'>" .ucwords($value['property_features_name']). "</p></td>";
			}
			
			$i++;
		}
		$strHTML .= "</tbody></table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "</tr>\n";
		// Note

		if($holiday_type_note !="") {
			$strHTML .= "\n<tr>\n";
			$strHTML .= "\n<td valign=\"top\" colspan=\"2\" >\n";
			$strHTML .= "\n<table width=\"150px\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
			$strHTML .= "\n<tr>\n";
			$strHTML .= "\n<td align=\"left\" height=\"445px\" valign=\"top\" class=\"pad-lft10 pad-btm15\">\n";
			$strHTML .= $holiday_type_note;
			$strHTML .= "\n</td>\n";
			$strHTML .= "\n</tr>\n";
			$strHTML .= "\n</table>\n";
			$strHTML .= "\n</td>\n";
			$strHTML .= "\n</tr>\n";
		}

		$strHTML .= "\n<tr><td valign=\"top\" colspan=\"2\">&nbsp;</td></tr>\n";
		$strHTML .= "\n</table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\">&nbsp;</td>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" width=\"230px\">\n";
		$strHTML .= "\n<table width=\"100%\" cellpadding=\"0\" valign=\"top\" height=\"327px\" cellspacing=\"0\" style=\"border:1px solid #9F9F9F;\">\n";
		$strHTML .= "\n<tr><td align=\"left\" valign=\"top\" class=\"font16-darkgrey pad-lft10 pad-top10\"><strong>Location</strong></td></tr>\n";
		// For Holiday type
		$sql = "SELECT * FROM " . TABLE_PROPERTY_FEATURES . " WHERE property_features_group_id ='9' ORDER BY property_features_name";
		$strHTML .= "\n<tr>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" class=\"pad-lft10 pad-btm15\">\n";
		$strHTML .= "\n<table width=\"100%\" valign=\"top\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"font12\"><tbody>\n";
		$strHTML .= "<tr height=\"2px\"><td width=\"20px\"></td><td></td>\n";

		$rs = $this->dbObj->createRecordset($sql);
		$arr = $this->dbObj->fetchAssoc($rs);
		$i = 0;
		foreach($arr as $value){
			if($i%1 == 0){
				$strHTML .= "</tr>\n<tr class=\"Summary\">";
			}
			if(array_search($value['property_features_id'], $featureArr) === false){
				$strHTML .= "<td><p class=\"SummaryCross\" name='txtFeatures[]'>" .ucwords($value['property_features_name']). "</p></td>";
			} else {
				$strHTML .= "<td><p class=\"SummaryTick\" name='txtFeatures[]'>" .ucwords($value['property_features_name']). "</p></td>";
			}
			$i++;
		}
		$strHTML .= "</tbody></table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "</tr>\n";
		// Note
		if($location_note !="") {
			$strHTML .= "\n<tr>\n";
			$strHTML .= "\n<td valign=\"top\" colspan=\"2\" >\n";
			$strHTML .= "\n<table width=\"150px\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
			$strHTML .= "\n<tr>\n";
			$strHTML .= "\n<td align=\"left\" valign=\"top\" class=\"pad-lft10 pad-btm15\">\n";
			$strHTML .= $location_note;
			$strHTML .= "\n</td>\n";
			$strHTML .= "\n</tr>\n";
			$strHTML .= "\n</table>\n";
			$strHTML .= "\n</td>\n";
			$strHTML .= "\n</tr>\n";
		}

		$strHTML .= "\n<tr><td valign=\"top\" colspan=\"2\">&nbsp;</td></tr>\n";
		$strHTML .= "\n</table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\">&nbsp;</td>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" width=\"230px\">\n";
		$strHTML .= "\n<table width=\"100%\" height=\"327\" cellpadding=\"0\" valign=\"top\"height=\"500px\"cellspacing=\"0\" style=\"border:1px solid #9F9F9F;\">\n";
		$strHTML .= "\n<tr><td align=\"left\" colspan=\"2\" valign=\"top\" class=\"font16-darkgrey pad-lft10 pad-top10 \"><strong>General</strong></td></tr>\n";
		// For General
		$sql = "SELECT * FROM " . TABLE_PROPERTY_FEATURES . " WHERE property_features_group_id ='5' AND property_features_id NOT IN (3,18,23,28,29,30) ORDER BY property_features_name";
		$strHTML .= "\n<tr>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" class=\"pad-lft10 pad-top2 pad-btm10\">\n";
		$strHTML .= "\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"font12\"><tbody>\n";
		$strHTML .= "<tr height=\"2px\"><td width=\"20px\"></td><td></td>\n";

		$rs = $this->dbObj->createRecordset($sql);
		$arr = $this->dbObj->fetchAssoc($rs);
		$i = 0;
		foreach($arr as $value){
			if($i%1 == 0){
				$strHTML .= "</tr>\n<tr class=\"Summary\">";
			}
			if(array_search($value['property_features_id'], $featureArr) === false){
				$strHTML .= "<td><p class=\"SummaryCross\" name='txtFeatures[]'>" .ucwords($value['property_features_name']). "</p></td>";
			} else {
				$strHTML .= "<td><p class=\"SummaryTick\" name='txtFeatures[]'>" .ucwords($value['property_features_name']). "</p></td>";
			}
			$i++;
		}
		$strHTML .= "</tbody></table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "</tr>\n";
		// Note
		if($general_note !="") {
			$strHTML .= "\n<tr>\n";
			$strHTML .= "\n<td valign=\"top\" colspan=\"2\">\n";
			$strHTML .= "\n<table width=\"150px\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
			$strHTML .= "\n<tr>\n";
			$strHTML .= "\n<td align=\"left\" valign=\"top\" class=\"pad-lft10 pad-btm15\">\n";
			$strHTML .= $general_note;
			$strHTML .= "\n</td>\n";
			$strHTML .= "\n</tr>\n";
			$strHTML .= "\n</table>\n";
			$strHTML .= "\n</td>\n";
			$strHTML .= "\n</tr>\n";
		}

		$strHTML .= "\n<tr><td valign=\"top\" colspan=\"2\">&nbsp;</td></tr>\n";

		$strHTML .= "\n</table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "\n</tr>\n";
		
		
		$strHTML .= "\n<tr height=\"10px\"><td align=\"left\" valign=\"top\"></td></tr>\n";
		// Next row

		$strHTML .= "\n<tr>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" width=\"230px\">\n";
		$strHTML .= "\n<table width=\"100%\" cellpadding=\"0\" valign=\"top\" height=\"327px\" cellspacing=\"0\" style=\"border:1px solid #9F9F9F;\">\n";
		$strHTML .= "\n<tr><td align=\"left\" valign=\"top\" class=\"font16-darkgrey pad-lft10 pad-top10\"><strong>Services</strong></td></tr>\n";
		// For Services
		$sql = "SELECT * FROM " . TABLE_PROPERTY_FEATURES . " WHERE property_features_group_id ='8' ORDER BY property_features_name";
		$strHTML .= "\n<tr>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" class=\"pad-lft10 pad-btm15\">\n";
		$strHTML .= "\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"font12\"><tbody>\n";
		$strHTML .= "<tr height=\"2px\"><td width=\"20px\"></td><td></td>\n";

		$rs = $this->dbObj->createRecordset($sql);
		$arr = $this->dbObj->fetchAssoc($rs);
		$i = 0;
		foreach($arr as $value){
			if($i%1 == 0){
				$strHTML .= "</tr>\n<tr class=\"Summary\">";
			}
			if(array_search($value['property_features_id'], $featureArr) === false){
				$strHTML .= "<td><p class=\"SummaryCross\" name='txtFeatures[]'>" .ucwords($value['property_features_name']). "</p></td>";
			} else {
				$strHTML .= "<td><p class=\"SummaryTick\" name='txtFeatures[]'>" .ucwords($value['property_features_name']). "</p></td>";
			}
			$i++;
		}
		$strHTML .= "</tbody></table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "</tr>\n";
		// Note
		if($services_note !="") {
			$strHTML .= "\n<tr>\n";
			$strHTML .= "\n<td valign=\"top\" colspan=\"2\">\n";
			$strHTML .= "\n<table width=\"150px\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
			$strHTML .= "\n<tr>\n";
			$strHTML .= "\n<td align=\"left\" valign=\"top\" class=\"pad-lft10 pad-btm15\">\n";
			$strHTML .= $services_note;
			$strHTML .= "\n</td>\n";
			$strHTML .= "\n</tr>\n";
			$strHTML .= "\n</table>\n";
			$strHTML .= "\n</td>\n";
			$strHTML .= "\n</tr>\n";
		}

		$strHTML .= "\n<tr><td valign=\"top\" colspan=\"2\">&nbsp;</td></tr>\n";
		$strHTML .= "\n</table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\">&nbsp;</td>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" width=\"230px\" height=\"400px\">\n";
		$strHTML .= "\n<table width=\"100%\" cellpadding=\"0\" valign=\"top\" height=\"327px\" cellspacing=\"0\" style=\"border:1px solid #9F9F9F;\">\n";
		$strHTML .= "\n<tr><td align=\"left\" colspan=\"2\" valign=\"top\" class=\"font16-darkgrey pad-lft10 pad-top10\"><strong>Kitchen/Linen</strong></td></tr>\n";
		// For Kitchen / Linen
		$sql = "SELECT * FROM " . TABLE_PROPERTY_FEATURES . " WHERE property_features_group_id ='2' ORDER BY property_features_name";
		$strHTML .= "\n<tr>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" class=\"pad-lft10 pad-top10 pad-btm15\">\n";
		$strHTML .= "\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"font12\"><tbody>\n";
		$strHTML .= "<tr height=\"2px\"><td width=\"20px\"></td><td></td>\n";

		$rs = $this->dbObj->createRecordset($sql);
		$arr = $this->dbObj->fetchAssoc($rs);
		$i = 0;
		foreach($arr as $value){
			if($i%1 == 0){
				$strHTML .= "</tr>\n<tr class=\"Summary\">";
			}
			if(array_search($value['property_features_id'], $featureArr) === false){
				$strHTML .= "<td><p class=\"SummaryCross\" name='txtFeatures[]'>" .ucwords($value['property_features_name']). "</p></td>";
			} else {
				$strHTML .= "<td><p class=\"SummaryTick\" name='txtFeatures[]'>" .ucwords($value['property_features_name']). "</p></td>";
			}
			$i++;
		}
		$strHTML .= "</tbody></table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "</tr>\n";
		// Note
		if($kitchen_note !="") {
			$strHTML .= "\n<tr>\n";
			$strHTML .= "\n<td valign=\"top\" colspan=\"2\">\n";
			$strHTML .= "\n<table width=\"150px\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
			$strHTML .= "\n<tr>\n";
			$strHTML .= "\n<td align=\"left\" valign=\"top\" class=\"pad-lft10 pad-btm15\">\n";
			$strHTML .= $kitchen_note;
			$strHTML .= "\n</td>\n";
			$strHTML .= "\n</tr>\n";
			$strHTML .= "\n</table>\n";
			$strHTML .= "\n</td>\n";
			$strHTML .= "\n</tr>\n";
		}

		$strHTML .= "\n<tr><td valign=\"top\" colspan=\"2\">&nbsp;</td></tr>\n";
		$strHTML .= "\n</table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\">&nbsp;</td>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" width=\"230px\">\n";
		$strHTML .= "\n<table width=\"100%\" cellpadding=\"0\" valign=\"top\" height=\"327px\" cellspacing=\"0\" style=\"border:1px solid #9F9F9F;\">\n";
		$strHTML .= "\n<tr><td align=\"left\" colspan=\"2\" valign=\"top\" class=\"font16-darkgrey pad-lft10 pad-top10\"><strong>Entertainment</strong></td></tr>\n";
		// For Entertainment
		$sql = "SELECT * FROM " . TABLE_PROPERTY_FEATURES . " WHERE property_features_group_id ='3' ORDER BY property_features_name";
		$strHTML .= "\n<tr>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" class=\"pad-lft10 pad-top10 pad-btm15\">\n";
		$strHTML .= "\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"font12\"><tbody>\n";
		$strHTML .= "<tr height=\"2px\"><td width=\"20px\"></td><td></td>\n";

		$rs = $this->dbObj->createRecordset($sql);
		$arr = $this->dbObj->fetchAssoc($rs);
		$i = 0;
		foreach($arr as $value){
			if($i%1 == 0){
				$strHTML .= "</tr>\n<tr class=\"Summary\">";
			}
			if(array_search($value['property_features_id'], $featureArr) === false){
				$strHTML .= "<td><p class=\"SummaryCross\" name='txtFeatures[]'>" .ucwords($value['property_features_name']). "</p></td>";
			} else {
				$strHTML .= "<td><p class=\"SummaryTick\" name='txtFeatures[]'>" .ucwords($value['property_features_name']). "</p></td>";
			}
			$i++;
		}
		$strHTML .= "</tbody></table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "</tr>\n";
		// Note
		if($entertainment_note !="") {
			$strHTML .= "\n<tr>\n";
			$strHTML .= "\n<td valign=\"top\" colspan=\"2\">\n";
			$strHTML .= "\n<table width=\"150px\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
			$strHTML .= "\n<tr>\n";
			$strHTML .= "\n<td align=\"left\" valign=\"top\" class=\"pad-lft10 pad-btm15\">\n";
			$strHTML .= $entertainment_note;
			$strHTML .= "\n</td>\n";
			$strHTML .= "\n</tr>\n";
			$strHTML .= "\n</table>\n";
			$strHTML .= "\n</td>\n";
			$strHTML .= "\n</tr>\n";
		}

		$strHTML .= "\n<tr><td valign=\"top\" colspan=\"2\">&nbsp;</td></tr>\n";
		$strHTML .= "\n</table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "\n</tr>\n";

		// Next row
		$strHTML .= "\n<tr>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" width=\"230px\">\n";
		$strHTML .= "\n<table width=\"100%\" cellpadding=\"0\" valign=\"top\" height=\"327px\" cellspacing=\"0\" style=\"border:1px solid #9F9F9F;\">\n";
		$strHTML .= "\n<tr><td align=\"left\" valign=\"top\" class=\"font16-darkgrey pad-lft10 pad-top10 pad-btm5\"><strong>Outdoors facilities</strong></td></tr>\n";
		// For Holiday type
		$sql = "SELECT * FROM " . TABLE_PROPERTY_FEATURES . " WHERE property_features_group_id ='4' ORDER BY property_features_name";
		$strHTML .= "\n<tr>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" class=\"pad-lft10 pad-top10 pad-btm15\">\n";
		$strHTML .= "\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"font12\"><tbody>\n";
		$strHTML .= "<tr height=\"2px\"><td width=\"20px\"></td><td></td>\n";

		$rs = $this->dbObj->createRecordset($sql);
		$arr = $this->dbObj->fetchAssoc($rs);
		$i = 0;
		foreach($arr as $value){
			if($i%1 == 0){
				$strHTML .= "</tr>\n<tr class=\"Summary\">";
			}
			if(array_search($value['property_features_id'], $featureArr) === false){
				$strHTML .= "<td><p class=\"SummaryCross\" name='txtFeatures[]'>" .ucwords($value['property_features_name']). "</p></td>";
			} else {
				$strHTML .= "<td><p class=\"SummaryTick\" name='txtFeatures[]'>" .ucwords($value['property_features_name']). "</p></td>";
			}
			$i++;
		}
		$strHTML .= "</tbody></table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "</tr>\n";
		// Note

		if($outside_note !="") {
			$strHTML .= "\n<tr>\n";
			$strHTML .= "\n<td valign=\"top\" colspan=\"2\">\n";
			$strHTML .= "\n<table width=\"150px\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
			$strHTML .= "\n<tr>\n";
			$strHTML .= "\n<td align=\"left\" valign=\"top\" class=\"pad-lft10 pad-btm15\">\n";
			$strHTML .= $outside_note;
			$strHTML .= "\n</td>\n";
			$strHTML .= "\n</tr>\n";
			$strHTML .= "\n</table>\n";
			$strHTML .= "\n</td>\n";
			$strHTML .= "\n</tr>\n";
		}

		$strHTML .= "\n<tr><td valign=\"top\" colspan=\"2\">&nbsp;</td></tr>\n";
		$strHTML .= "\n</table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\">&nbsp;</td>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" width=\"230px\">\n";
		$strHTML .= "\n<table width=\"100%\" cellpadding=\"0\" valign=\"top\" height=\"327px\" cellspacing=\"0\" style=\"border:1px solid #9F9F9F;\">\n";
		$strHTML .= "\n<tr><td align=\"left\" colspan=\"2\" valign=\"top\" class=\"font16-darkgrey pad-lft10 pad-top10\"><strong>Heating/Cooling</strong></td></tr>\n";
		// For Kitchen / Linen
		$sql = "SELECT * FROM " . TABLE_PROPERTY_FEATURES . " WHERE property_features_group_id ='7' ORDER BY property_features_name";
		$strHTML .= "\n<tr>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" class=\"pad-lft10 pad-btm15\">\n";
		$strHTML .= "\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"font12\"><tbody>\n";
		$strHTML .= "<tr height=\"2px\"><td width=\"20px\"></td><td></td>\n";

		$rs = $this->dbObj->createRecordset($sql);
		$arr = $this->dbObj->fetchAssoc($rs);
		$i = 0;
		foreach($arr as $value){
			if($i%1 == 0){
				$strHTML .= "</tr>\n<tr class=\"Summary\">";
			}
			if(array_search($value['property_features_id'], $featureArr) === false){
				$strHTML .= "<td><p class=\"SummaryCross\" name='txtFeatures[]'>" .ucwords($value['property_features_name']). "</p></td>";
			} else {
				$strHTML .= "<td><p class=\"SummaryTick\" name='txtFeatures[]'>" .ucwords($value['property_features_name']). "</p></td>";
			}
			$i++;
		}
		$strHTML .= "</tbody></table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "</tr>\n";
		// Note
		if($heating_cooling_note !="") {
			$strHTML .= "\n<tr>\n";
			$strHTML .= "\n<td valign=\"top\" colspan=\"2\">\n";
			$strHTML .= "\n<table width=\"150px\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
			$strHTML .= "\n<tr>\n";
			$strHTML .= "\n<td align=\"left\" valign=\"top\" class=\"pad-lft10 pad-btm15\">\n";
			$strHTML .= $heating_cooling_note;
			$strHTML .= "\n</td>\n";
			$strHTML .= "\n</tr>\n";
			$strHTML .= "\n</table>\n";
			$strHTML .= "\n</td>\n";
			$strHTML .= "\n</tr>\n";
		}
		$strHTML .= "\n<tr><td valign=\"top\" colspan=\"2\">&nbsp;</td></tr>\n";
		$strHTML .= "\n</table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\">&nbsp;</td>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" width=\"230px\">\n";
		$strHTML .= "\n<table width=\"100%\" cellpadding=\"0\" valign=\"top\" height=\"327px\" cellspacing=\"0\" style=\"border:1px solid #9F9F9F;\">\n";
		$strHTML .= "\n<tr><td align=\"left\" colspan=\"2\" valign=\"top\" class=\"font16-darkgrey pad-lft10 pad-top10\"><strong>Activities Nearby</strong></td></tr>\n";
		// For Entertainment
		$sql = "SELECT * FROM " . TABLE_PROPERTY_FEATURES . " WHERE property_features_group_id ='6' ORDER BY property_features_name";
		$strHTML .= "\n<tr>\n";
		$strHTML .= "\n<td align=\"left\" valign=\"top\" class=\"pad-lft10 pad-top10 pad-btm15\">\n";
		$strHTML .= "\n<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"font12\"><tbody>\n";
		$strHTML .= "<tr height=\"2px\"><td width=\"20px\"></td><td></td>\n";

		$rs = $this->dbObj->createRecordset($sql);
		$arr = $this->dbObj->fetchAssoc($rs);
		$i = 0;
		foreach($arr as $value){
			if($i%1 == 0){
				$strHTML .= "</tr>\n<tr class=\"Summary\">";
			}
			if(array_search($value['property_features_id'], $featureArr) === false){
				$strHTML .= "<td><p class=\"SummaryCross\" name='txtFeatures[]'>" .ucwords($value['property_features_name']). "</p></td>";
			} else {
				$strHTML .= "<td><p class=\"SummaryTick\" name='txtFeatures[]'>" .ucwords($value['property_features_name']). "</p></td>";
			}
			$i++;
		}
		$strHTML .= "</tbody></table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "</tr>\n";
		// Note
		if($activities_note !="") {
			$strHTML .= "\n<tr>\n";
			$strHTML .= "\n<td valign=\"top\" colspan=\"2\">\n";
			$strHTML .= "\n<table width=\"150px\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
			$strHTML .= "\n<tr>\n";
			$strHTML .= "\n<td align=\"left\" valign=\"top\" class=\"pad-lft10 pad-btm15\">\n";
			$strHTML .= $activities_note;
			$strHTML .= "\n</td>\n";
			$strHTML .= "\n</tr>\n";
			$strHTML .= "\n</table>\n";
			$strHTML .= "\n</td>\n";
			$strHTML .= "\n</tr>\n";
		}

		$strHTML .= "\n</table>\n";
		$strHTML .= "\n</td>\n";
		$strHTML .= "\n</tr>\n";
		$strHTML .= "\n</table>\n";

		echo $strHTML;
	}

	function fun_getBookingCharges($property_id = ''){
		$sql 	= "SELECT site_variable_value FROM " . TABLE_SITE_VARIABLE . " WHERE site_variable_id='4'";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr 	= $this->dbObj->fetchArray($rs);
			return $arr[0];
		} else {
			return false;
		}
	}	

/*
* For backlink activation: Start here
*/
	// Function for new user array
	function fun_getPropertyBackLinkArr($parameter=''){
		$sql = "SELECT 	A.* FROM " . TABLE_PROPERTY_BACKLINK_RELATIONS . " AS A WHERE A.id >0 ";
		if($parameter!=""){
			$sql .= $parameter;
		} else {
			$sql .= " ORDER BY A.property_id DESC";		
		}
		//echo $sql;
		$rs = $this->dbObj->createRecordset($sql);
		return $arr = $this->dbObj->fetchAssoc($rs);		
	}

	// Function for add backlink
	function fun_addPropertyBackLink($property_id, $backlink, $backlinkcode, $status) {
		if($property_id == '') {
			return false;
		} else {
			$cur_unixtime 	= time ();
			if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !=""){
				$cur_user_id 	= $_SESSION['ses_admin_id'];
			} else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !=""){
				$cur_user_id 	= $_SESSION['ses_modarator_id'];
			} else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !=""){
				$cur_user_id 	= $_SESSION['ses_user_id'];
			} else {
				$cur_user_id 	= "";
			}
			if(isset($backlink) && $backlink !="") {
				$onlyHostName 	= implode('.', array_slice(explode('.', parse_url($backlink, PHP_URL_HOST)), -2));
				$sql 	= "SELECT id FROM " . TABLE_PROPERTY_BACKLINK_RELATIONS . " WHERE ((backlink LIKE '%".$onlyHostName."') OR (backlink LIKE '".$onlyHostName."%') OR (backlink LIKE '%".$onlyHostName."%') OR (backlink = '".$onlyHostName."'))";
			} else {
				$sql 	= "SELECT id FROM " . TABLE_PROPERTY_BACKLINK_RELATIONS . " WHERE property_id='".$property_id."'";
			}
			$rs 	= $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0) {
				return false;
			} else {
				$strInsQuery = "INSERT INTO " . TABLE_PROPERTY_BACKLINK_RELATIONS . " 
				(id, property_id, backlink, backlinkcode, crawldate, crawlfailed, status, created_on, created_by, updated_on, updated_by) 
				VALUES(null, '".$property_id."', '".fun_db_input($backlink)."', '".fun_db_input($backlinkcode)."', '', '0', '".$status."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."')";
				$this->dbObj->mySqlSafeQuery($strInsQuery);
				return $this->dbObj->getIdentity();
			}
		}
	}

	// Function for edit backlink
	function fun_editPropertyBackLink($id, $property_id, $backlink, $backlinkcode, $status) {
		if($id == '') {
			return false;
		} else {
			$cur_unixtime 	= time ();
			if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !=""){
				$cur_user_id 	= $_SESSION['ses_admin_id'];
			} else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !=""){
				$cur_user_id 	= $_SESSION['ses_modarator_id'];
			} else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !=""){
				$cur_user_id 	= $_SESSION['ses_user_id'];
			} else {
				$cur_user_id 	= "";
			}
			
			if(isset($backlink) && $backlink !="") {
				$onlyHostName 	= implode('.', array_slice(explode('.', parse_url($backlink, PHP_URL_HOST)), -2));
				$sql 	= "SELECT id FROM " . TABLE_PROPERTY_BACKLINK_RELATIONS . " WHERE id!='".$id."' AND ((backlink LIKE '%".$onlyHostName."') OR (backlink LIKE '".$onlyHostName."%') OR (backlink LIKE '%".$onlyHostName."%') OR (backlink = '".$onlyHostName."'))";
				$rs 	= $this->dbObj->createRecordset($sql);
				if($this->dbObj->getRecordCount($rs) > 0) {
					return false;
				} else {
					$sqlUpdateQuery = "UPDATE " . TABLE_PROPERTY_BACKLINK_RELATIONS . " SET property_id = '".$property_id."', backlink = '".fun_db_input($backlink)."', backlinkcode = '".fun_db_input($backlinkcode)."', status = '".$status."', updated_on = '".$cur_unixtime."', updated_by = '".$cur_user_id."' WHERE id='".$id."'";
					$this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
					return $id;
				}
			} else {
				$sqlUpdateQuery = "UPDATE " . TABLE_PROPERTY_BACKLINK_RELATIONS . " SET property_id = '".$property_id."', backlink = '".fun_db_input($backlink)."', backlinkcode = '".fun_db_input($backlinkcode)."', status = '".$status."', updated_on = '".$cur_unixtime."', updated_by = '".$cur_user_id."' WHERE id='".$id."'";
				$this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
				return $id;
			}
		}
	}

	// Function for return backlink information in array
	function fun_getPropertyBacklinkInfo($id){		
		$sql 	= "SELECT * FROM " . TABLE_PROPERTY_BACKLINK_RELATIONS . " WHERE id='".$id."'";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr 	= $this->dbObj->fetchAssoc($rs);
			return $arr[0];
		} else {
			return false;
		}
	}

	// Function for delete backlink
	function fun_delPropertyBacklink($id){
		// Delete from TABLE_PROPERTY_BACKLINK_RELATIONS
		$strDelQuery = "DELETE FROM " . TABLE_PROPERTY_BACKLINK_RELATIONS . " WHERE id='".$id."'";
		$this->dbObj->mySqlSafeQuery($strDelQuery);
		return true;
	}

	// Function for return backlink information in array
	function fun_validatePropertyBackLink($id){		
		if($id == '') {
			return "invalid";
		} else {
			$sql 	= "SELECT * FROM " . TABLE_PROPERTY_BACKLINK_RELATIONS . " WHERE id='".$id."'";
			$rs 	= $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr 		= $this->dbObj->fetchAssoc($rs);
				$backlink 	= $arr[0]['backlink'];
				if(isset($backlink) && $backlink !="") {
					// make the cURL request to $search_url
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_USERAGENT, 'Firefox (WindowsXP) - Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6');
					curl_setopt($ch, CURLOPT_URL,$backlink);
					curl_setopt($ch, CURLOPT_FAILONERROR, true);
					curl_setopt($ch, CURLOPT_AUTOREFERER, true);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
					curl_setopt($ch, CURLOPT_TIMEOUT, 30);
					$html= curl_exec($ch);
					if (!$html) {
						return "invalid";
						/*
						echo "<br />cURL error number:" .curl_errno($ch);
						echo "<br />cURL error:" . curl_error($ch);
						exit;
						*/
					}
					curl_close($ch); 
					// parse the html into a DOMDocument  
					$dom = new DOMDocument();
					@$dom->loadHTML($html);
					$strHTML 	= $dom->saveHTML();
					//$pos 		= strpos($strHTML, "www.rentownersvillas.com");
					$pos 		= strpos($strHTML, $_SERVER["SERVER_NAME"]);
					$cur_time 	= date("Y-m-d H:i:s");
					if($pos !== false) {
						$this->dbObj->updateField(TABLE_PROPERTY_BACKLINK_RELATIONS, "id", $id, "crawldate", $cur_time);
						$this->dbObj->updateField(TABLE_PROPERTY_BACKLINK_RELATIONS, "id", $id, "crawlfailed", "0");
						$this->dbObj->updateField(TABLE_PROPERTY_BACKLINK_RELATIONS, "id", $id, "status", "2");
						return "valid";
					} else {
						$this->dbObj->updateField(TABLE_PROPERTY_BACKLINK_RELATIONS, "id", $id, "crawldate", $cur_time);
						$this->dbObj->updateField(TABLE_PROPERTY_BACKLINK_RELATIONS, "id", $id, "crawlfailed", "(crawlfailed+1)");
						return "invalid";
					}
				} else {
					return "invalid";
				}
			} else {
				return "invalid";
			}
		}
	}

	function fun_updatePropertyBackLink($id, $backlink){
		if($id == '' || $backlink == '') {
			return "invalid";
		} else {
			$onlyHostName 	= implode('.', array_slice(explode('.', parse_url($backlink, PHP_URL_HOST)), -2));
			$sql 	= "SELECT id FROM " . TABLE_PROPERTY_BACKLINK_RELATIONS . " WHERE id !='".$id."' AND ((backlink LIKE '%".$onlyHostName."') OR (backlink LIKE '".$onlyHostName."%') OR (backlink LIKE '%".$onlyHostName."%') OR (backlink = '".$onlyHostName."'))";
			$rs 	= $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0) {
				return "invalid";
			} else {
				$cur_unixtime 	= time ();
				if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !=""){
					$cur_user_id 	= $_SESSION['ses_admin_id'];
				} else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !=""){
					$cur_user_id 	= $_SESSION['ses_modarator_id'];
				} else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !=""){
					$cur_user_id 	= $_SESSION['ses_user_id'];
				} else {
					$cur_user_id 	= "";
				}
				//Step I: Select backlink details by id
				$infoArr = $this->fun_getPropertyBacklinkInfo($id);
				//Step II: update backlink
				$sqlUpdateQuery = "UPDATE " . TABLE_PROPERTY_BACKLINK_RELATIONS . " SET backlink = '".fun_db_input($backlink)."', status = '".$status."', updated_on = '".$cur_unixtime."', updated_by = '".$cur_user_id."' WHERE id='".$id."'";
				$this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
				//Step III: deleted owners cart item based on property id
				$strDelQuery = "DELETE FROM " . TABLE_USER_CART . " WHERE property_id='".$infoArr['property_id']."' AND products_id IN (5,6) ";
				$this->dbObj->mySqlSafeQuery($strDelQuery);
				//Step IV: validate backlink id
				$strValidate = $this->fun_validatePropertyBackLink($id);
				if($strValidate == "valid") {
					//Step V: update property status property id
					$strUpdateQuery = "UPDATE ".TABLE_PROPERTY." SET status='2', statuschanged_on='".$cur_unixtime."', active_on='".$cur_unixtime."', active_by='".$cur_user_id."', active='1' WHERE property_id='".$infoArr['property_id']."'";
					$this->dbObj->mySqlSafeQuery($strUpdateQuery);
				}
				return $strValidate;
			}
		}
	}

	function fun_getActivationIdByPropertyId($property_id){
		$id = $this->dbObj->getField(TABLE_PROPERTY_BACKLINK_RELATIONS, "property_id", $property_id, "id");
		return $id;
	}

/*
* For backlink activation: Start here
*/
	
}
?>