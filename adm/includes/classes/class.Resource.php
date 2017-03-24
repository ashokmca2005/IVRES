<?php
class Resource{
	var $dbObj;
	
	function Resource(){ // class constructor
		$this->dbObj = new DB();
		$this->dbObj->fun_db_connect();
	}
	
	// Function for creating Resource category panel
	function fun_createResourceCatLeftPanelById($resources_categories_id = '') {		
		$sql 	= "SELECT resources_categories_id, resources_categories_name FROM " . TABLE_RESOURCES_CATEGORIES . " ORDER BY resources_categories_name";
        $rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
            $arr = $this->dbObj->fetchAssoc($rs);
            $strlinkclass = "";
            echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
            echo "<tr><td valign=\"top\" class=\"pad-lft20 pad-rgt15 pad-top3 pad-btm10\"><span class=\"pink16\">Categories</span></td></tr>";
            for($i = 0; $i < count($arr); $i++) {
                $strlinkclass = "";
                if($arr[$i]['resources_categories_id'] == $resources_categories_id  && $resources_categories_id!=''){
					if($i == (count($arr) -1)) {
						$strlinkclass = " class=\"matter\" style=\"padding-top:4px; padding-left:20px;\"";
					} else {
						$strlinkclass = " class=\"MyPropertiesLeftLink1\" style=\"padding-top:4px; padding-left:20px;\"";
					}
                } else {
					if($i == (count($arr) -1)) {
						$strlinkclass = " class=\"matter\" style=\"padding-top:4px; padding-left:20px;\"";
					} else {
						$strlinkclass = " class=\"MyPropertiesLeftLink1\" style=\"padding-top:4px; padding-left:20px;\"";
					}
                }
				$total_resources = $this->fun_countResourcesByCategory($arr[$i]['resources_categories_id']);
                echo "<tr><td ".$strlinkclass."><a href=\"resources.php?catid=".$arr[$i]['resources_categories_id']."\">".ucfirst($arr[$i]['resources_categories_name'])."<span class=\"gray12\"> (".$total_resources.")</span></a></td></tr>";
            }
            echo "</table>";
        }        
	}

	// Function for creating Resource category panel
	function fun_createResourceCatLeftPanel($resources_categories_id = '') {		
		$sql 	= "SELECT resources_categories_id, resources_categories_name FROM " . TABLE_RESOURCES_CATEGORIES . " ORDER BY resources_categories_name";
        $rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
            $arr = $this->dbObj->fetchAssoc($rs);
            $strlinkclass = "";
            echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
            echo "<tr><td valign=\"top\" class=\"pad-lft20 pad-rgt15 pad-top3 pad-btm10\"><span class=\"pink16\">Categories</span></td></tr>";
            for($i = 0; $i < count($arr); $i++) {
                $strlinkclass = "";
                if($arr[$i]['resources_categories_id'] == $resources_categories_id  && $resources_categories_id!=''){
					if($i == (count($arr) -1)) {
						$strlinkclass = " class=\"matter\" style=\"padding-top:4px; padding-left:20px;\"";
					} else {
						$strlinkclass = " class=\"MyPropertiesLeftLink1\" style=\"padding-top:4px; padding-left:20px;\"";
					}
                } else {
					if($i == (count($arr) -1)) {
						$strlinkclass = " class=\"matter\" style=\"padding-top:4px; padding-left:20px;\"";
					} else {
						$strlinkclass = " class=\"MyPropertiesLeftLink1\" style=\"padding-top:4px; padding-left:20px;\"";
					}
                }
				$total_resources = $this->fun_countResourcesByCategory($arr[$i]['resources_categories_id']);
                echo "<tr><td ".$strlinkclass."><a href=\"".SITE_URL.str_replace(" ", "-", str_replace("/ ", "", strtolower($arr[$i]['resources_categories_name'])))."-resources.html\">".ucfirst($arr[$i]['resources_categories_name'])."<span class=\"gray12\"> (".$total_resources.")</span></a></td></tr>";
            }
            echo "</table>";
        }        
	}

	// This function will Return Enquiry information in array with front end data
	function fun_countResourcesByCategory($resources_categories_id){
        if($resources_categories_id == "") {
            return "0";
        } else {
			$sql 		= "SELECT A.resource_id FROM " . TABLE_RESOURCES . " AS A WHERE A.resource_cat_ids='".$resources_categories_id."' AND A.active ='1' AND A.status ='2'";
			$rs 		= $this->dbObj->createRecordset($sql);
			return $this->dbObj->getRecordCount($rs);
        }
	}

	// This function will Return Resources information in array with front end data
	function fun_getResourcesByCategoryArr($resource_cat_ids, $parameter = ''){
		$sql 		= "SELECT A.resource_id, 
							A.resource_cat_ids, 
							A.resource_name, 
							A.resource_description,
							A.resource_area_id,
							A.resource_region_id,
							A.resource_sub_region_id,
							A.resource_location_id,
							A.resource_link,
							A.resource_mc_link,
							A.status,
							A.active_on,
							A.active_by,
							A.created_on,
							A.created_by,
							A.updated_on,
							A.updated_by,
							A.active
						FROM " . TABLE_RESOURCES . " AS A
						WHERE A.active ='1' AND A.status ='2'";

        if($resource_cat_ids != "") {
			$sql .= " AND A.resource_cat_ids='".$resource_cat_ids."' ";
        }
		if($parameter != ""){
			$sql .= $parameter;
		} else {
			$sql .= " ORDER BY A.enquiry_id";		
		}
		return $rs = $this->dbObj->createRecordset($sql);
	}

	// Function for creating travel guide option list, if id is given it must be selected
	function fun_getResourcesCatListOptions($resources_categories_id = ''){		
		$selected = "";
		$sql 	= "SELECT resources_categories_id, resources_categories_name FROM " . TABLE_RESOURCES_CATEGORIES . " ORDER BY resources_categories_name";
        $rs 	= $this->dbObj->createRecordset($sql);
        $arr 	= $this->dbObj->fetchAssoc($rs);
        foreach($arr as $value) {
			if($value['resources_categories_id'] == $resources_categories_id  && $resources_categories_id!=''){
				$selected = "selected";
			}else{
				$selected = "";
			}
			echo "<option value=\"".$value['resources_categories_id']."\" " .$selected. ">";
			echo ucwords($value['resources_categories_name']);
			echo "</option>";
        }
	}

	// function for user registration
//fun_addResource($txtResourceCategory, $txtResourceTitle, $txtResourceDesc, $txtArea, $txtRegion, $txtSubRegion, $txtLocation, $txtResourceUrl, $txtResourceOLUrl)
	function fun_addResource($resource_cat_ids, $resource_name, $resource_description, $resource_area_id, $resource_region_id, $resource_sub_region_id, $resource_location_id, $resource_link, $resource_mc_link) {
        $status = "1";
        $active = "0";
        $cur_unixtime 			= time ();
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

        $field_names 			= array("resource_cat_ids", "resource_name", "resource_description", "resource_area_id", "resource_region_id", "resource_sub_region_id", "resource_location_id", "resource_link", "resource_mc_link", "status", "active_on", "active_by", "created_on", "created_by", "updated_on", "updated_by", "active");
        $field_values 			= array(fun_db_input($resource_cat_ids), fun_db_input($resource_name), fun_db_input($resource_description), fun_db_input($resource_area_id), fun_db_input($resource_region_id), fun_db_input($resource_sub_region_id), fun_db_input($resource_location_id), fun_db_input($resource_link), fun_db_input($resource_mc_link), fun_db_input($status), fun_db_input($cur_unixtime), fun_db_input($cur_user_id), fun_db_input($cur_unixtime), fun_db_input($cur_user_id), fun_db_input($cur_unixtime), fun_db_input($cur_user_id), fun_db_input($active));
        $this->dbObj->insertFields(TABLE_RESOURCES, $field_names, $field_values);
        $resource_id 			= $this->dbObj->getIdentity();
        return $resource_id;
	}


	function fun_editResource($resource_id, $resource_cat_ids, $resource_name, $resource_description, $resource_area_id, $resource_region_id, $resource_sub_region_id, $resource_location_id, $resource_link, $resource_mc_link) {
        $status = "1";
        $active = "1";
        $cur_unixtime 			= time ();
		if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !="") {
			$cur_user_id 	= $_SESSION['ses_admin_id'];
		} else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !="") {
			$cur_user_id 	= $_SESSION['ses_modarator_id'];
		} else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !="") {
			$cur_user_id 	= $_SESSION['ses_user_id'];
		} else {
			$cur_user_id 	= "";
		}

        $field_names 			= array("resource_cat_ids", "resource_name", "resource_description", "resource_area_id", "resource_region_id", "resource_sub_region_id", "resource_location_id", "resource_link", "resource_mc_link", "status", "active_on", "active_by", "created_on", "created_by", "updated_on", "updated_by", "active");
        $field_values 			= array(fun_db_input($resource_cat_ids), fun_db_input($resource_name), fun_db_input($resource_description), fun_db_input($resource_area_id), fun_db_input($resource_region_id), fun_db_input($resource_sub_region_id), fun_db_input($resource_location_id), fun_db_input($resource_link), fun_db_input($resource_mc_link), fun_db_input($status), fun_db_input($cur_unixtime), fun_db_input($cur_user_id), fun_db_input($cur_unixtime), fun_db_input($cur_user_id), fun_db_input($cur_unixtime), fun_db_input($cur_user_id), fun_db_input($active));
        $this->dbObj->updateFields(TABLE_RESOURCES, "resource_id", $resource_id, $field_names, $field_values);
        return $resource_id;
	}

	// This function will Return Resource information in array with front end data	
	function fun_getResourceInfo($resource_id){		
		$sql 	= "SELECT * FROM " . TABLE_RESOURCES . " WHERE resource_id='".$resource_id."'";
		//echo $sql;
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr 	= $this->dbObj->fetchAssoc($rs);
			return $arr[0];
		} else {
			return false;
		}
	}

	// This function will Return Resource information in array with front end data	
	function fun_getResourceUserInfo($resource_id){		
		$sql 	= "SELECT B.user_fname, B.user_lname, B.user_email 
				FROM " . TABLE_USER_RESOURCES_RELATIONS . " AS A 
				INNER JOIN " . TABLE_USERS . " AS B ON A.user_id = B.user_id 
				WHERE A.resource_id='".$resource_id."'";
		

		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr 	= $this->dbObj->fetchAssoc($rs);
			return $arr[0];
		} else {
			return false;
		}
		}

	function fun_delResource($resource_id){
		$this->dbObj->deleteRow(TABLE_RESOURCES, "resource_id", $resource_id);
		$this->dbObj->deleteRow(TABLE_USER_RESOURCES_RELATIONS, "resource_id", $resource_id);
		return true;
	}

	// Function for new user array
	function fun_getPendingApprovalResourcesArr($parameter=''){
		$sql 		= "SELECT A.resource_id, 
							A.resource_cat_ids, 
							A.resource_name, 
							A.resource_description,
							A.status,
							B.status_name,
							A.created_on,
							A.updated_on,
							A.active
						FROM " . TABLE_RESOURCES . " AS A
						INNER JOIN " . TABLE_RESOURCES_STATUS . " AS B ON A.status = B.status_id 
						";
		if($parameter!=""){
			$sql .= $parameter;
		} else {
			$sql .= " ORDER BY A.updated_on";		
		}
		
		//	echo $sql;
		$rs = $this->dbObj->createRecordset($sql);
        return $arr = $this->dbObj->fetchAssoc($rs);
	}

	function fun_getResourceCatName($resources_categories_id){
		$resources_categories_name = $this->dbObj->getField(TABLE_RESOURCES_CATEGORIES, "resources_categories_id", $resources_categories_id, "resources_categories_name");
		return $resources_categories_name;
	}

// OK

/*
	// This function will Return Resource information in array with front end data	
	function fun_getResourceTmpInfo($trvl_guid_id){		
		$sql 	= "SELECT * FROM " . TABLE_TRAVEL_GUIDES_TMP . " WHERE trvl_guid_id='".$trvl_guid_id."'";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr 	= $this->dbObj->fetchAssoc($rs);
			return $arr[0];
		} else {
			return false;
		}
	}

	// This function will Return Resource information in array with front end data	
	function fun_getResourceGuideCatInfo($trvl_guid_categories_id){		
		$sql 	= "SELECT * FROM " . TABLE_TRAVEL_GUIDES_CATEGORIES . " WHERE trvl_guid_categories_id='".$trvl_guid_categories_id."'";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr 	= $this->dbObj->fetchAssoc($rs);
			return $arr[0];
		} else {
			return false;
		}
	}

	function fun_getTvlGuidCatNameByCatId($trvl_guid_categories_id) {
		if($trvl_guid_categories_id == '') {
			return false;
		} else {
			$sql = "SELECT trvl_guid_categories_name FROM " . TABLE_TRAVEL_GUIDES_CATEGORIES . " WHERE trvl_guid_categories_id= '".$trvl_guid_categories_id."'";
			$rs = $this->dbObj->createRecordset($sql);
			$arr = $this->dbObj->fetchAssoc($rs);
			if(is_array($arr) && count($arr) > 0) {
				return ucfirst($arr[0]['trvl_guid_categories_name']);
			} else {
				return false;
			}
		}
	}

	// Function for new user array
	function fun_getCollateralResourcesArr($parameter=''){
		$sql = "SELECT 	A.trvl_guid_id, 
						A.trvl_guid_categories_id,
						A.trvl_guid_title,
						A.status,
						A.created_on,
						A.updated_on,
						B.status_name,
						A.featured, 
						A.active
				FROM " . TABLE_TRAVEL_GUIDES . " AS A
				INNER JOIN " . TABLE_TRAVEL_GUIDES_STATUS . " AS B ON A.status = B.status_id 
				  ";

		if($parameter!=""){
			$sql .= $parameter;
		} else {
			$sql .= " ORDER BY A.updated_on";		
		}
		
//echo $sql;
		$rs = $this->dbObj->createRecordset($sql);
        return $arr = $this->dbObj->fetchAssoc($rs);
	}

	// Function	for delete travel guide photos and travel guide from table
	function fun_delTvlGuid($trvl_guid_id = ''){
		if($trvl_guid_id == ''){
			return false;
		} else {
			if(($tvlguid_tmp_array = $this->fun_findRelationInfo(TABLE_TRAVEL_GUIDES , " WHERE trvl_guid_id='$trvl_guid_id'")) && (is_array($tvlguid_tmp_array))){
                if(($tvlguid_img_array = $this->fun_findRelationInfo(TABLE_TRAVEL_GUIDES_PHOTOS , " WHERE trvl_guid_id='$trvl_guid_id'")) && (is_array($tvlguid_img_array))){
                    for($i = 0; $i < count($tvlguid_img_array); $i++) {
                        $photo_url 		= $tvlguid_img_array[$i]['photo_url'];
                        $photo_thumb 	= $tvlguid_img_array[$i]['photo_thumb'];

                        $tempphoto 	= '../upload/tvlguid_images/large/'.$photo_url;
                        $photo 		= '../upload/tvlguid_images/large/449x341/'.$photo_url;
                        $thumb 		= '../upload/tvlguid_images/thumbnail/168x127/'.$photo_thumb;
        
                        if($tempphoto != ""){
                            @unlink($tempphoto);
                        }
                        if($photo != ""){
                            @unlink($photo);
                        }
                        if($thumb != ""){
                            @unlink($thumb);
                        }
        
                    }
                    $strDelteQuery = "DELETE FROM " . TABLE_TRAVEL_GUIDES_PHOTOS . " WHERE trvl_guid_id='$trvl_guid_id'";
                    $this->dbObj->mySqlSafeQuery($strDelteQuery);

                    $strDelteQuery = "DELETE FROM " . TABLE_TRAVEL_GUIDES . " WHERE trvl_guid_id='$trvl_guid_id'";
                    $this->dbObj->mySqlSafeQuery($strDelteQuery);
                }
            }
		}
	}

	// Function	for delete travel guide photos and travel guide from temp table
	function fun_delTvlGuidTmp($trvl_guid_id = ''){
		if($trvl_guid_id == ''){
			return false;
		} else {
			if(($tvlguid_tmp_array = $this->fun_findRelationInfo(TABLE_TRAVEL_GUIDES_TMP , " WHERE trvl_guid_id='$trvl_guid_id'")) && (is_array($tvlguid_tmp_array))){
                if(($tvlguid_img_array = $this->fun_findRelationInfo(TABLE_TRAVEL_GUIDES_PHOTOS , " WHERE trvl_guid_id='$trvl_guid_id'")) && (is_array($tvlguid_img_array))){
                    for($i = 0; $i < count($tvlguid_img_array); $i++) {
                        $photo_url 		= $tvlguid_img_array[$i]['photo_url'];
                        $photo_thumb 	= $tvlguid_img_array[$i]['photo_thumb'];

                        $tempphoto 	= 'upload/tvlguid_images/large/'.$photo_url;
                        $photo 		= 'upload/tvlguid_images/large/449x341/'.$photo_url;
                        $thumb 		= 'upload/tvlguid_images/thumbnail/168x127/'.$photo_thumb;
        
                        if($tempphoto != ""){
                            @unlink($tempphoto);
                        }
                        if($photo != ""){
                            @unlink($photo);
                        }
                        if($thumb != ""){
                            @unlink($thumb);
                        }
        
                    }
                    $strDelteQuery = "DELETE FROM " . TABLE_TRAVEL_GUIDES_PHOTOS . " WHERE trvl_guid_id='$trvl_guid_id'";
                    $this->dbObj->mySqlSafeQuery($strDelteQuery);

                    $strDelteQuery = "DELETE FROM " . TABLE_TRAVEL_GUIDES_TMP . " WHERE trvl_guid_id='$trvl_guid_id'";
                    $this->dbObj->mySqlSafeQuery($strDelteQuery);
                }
            }
		}
	}

	// Function for travel guide add
	function fun_addTvlGuid($trvl_guid_categories_id, $trvl_guid_title, $trvl_guid_area_id = '', $trvl_guid_region_id = '', $trvl_guid_sub_region_id = '', $trvl_guid_location_id = '', $trvl_guid_desc, $trvl_guid_dir = '', $trvl_guid_suit = '', $trvl_guid_cost = '', $trvl_guid_long_last = '', $trvl_guid_open_detail = '', $trvl_guid_attraction = '', $trvl_guid_contact_phone = '', $trvl_guid_contact_web = '', $trvl_guid_contact_email = '', $status = '1') {
		if($trvl_guid_categories_id == '' ||  $trvl_guid_title == '' ||  $trvl_guid_desc == '') {
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
			
			if($status == "2") {
				$active = "1";
				$active_on = $cur_unixtime;
				$active_by = $cur_user_id;
			} else if($status == "4") {
				$active = "0";
				$active_on = $cur_unixtime;
				$active_by = $cur_user_id;
			} else {
				$active = "0";
				$active_on = "";
				$active_by = "";
			}
			$featured = "0";

			$strInsQuery = "INSERT INTO " . TABLE_TRAVEL_GUIDES . " 
			(trvl_guid_id, trvl_guid_categories_id, trvl_guid_title, trvl_guid_area_id, trvl_guid_region_id, trvl_guid_sub_region_id, trvl_guid_location_id, trvl_guid_desc, trvl_guid_dir, trvl_guid_suit, trvl_guid_cost, trvl_guid_long_last, trvl_guid_open_detail, trvl_guid_attraction, trvl_guid_contact_phone, trvl_guid_contact_web, trvl_guid_contact_email, status, active_on, active_by, created_on, created_by, updated_on, updated_by, featured, active) 
			VALUES(null, '".$trvl_guid_categories_id."', '".$trvl_guid_title."', '".$trvl_guid_area_id."', '".$trvl_guid_region_id."', '".$trvl_guid_sub_region_id."', '".$trvl_guid_location_id."', '".$trvl_guid_desc."', '".$trvl_guid_dir."', '".$trvl_guid_suit."', '".$trvl_guid_cost."', '".$trvl_guid_long_last."', '".$trvl_guid_open_detail."', '".$trvl_guid_attraction."', '".$trvl_guid_contact_phone."', '".$trvl_guid_contact_web."', '".$trvl_guid_contact_email."', '".$status."', '".$active_on."', '".$active_by."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."', '".$featured."', '".$active."')";
			$this->dbObj->fun_db_query($strInsQuery);
			return $this->dbObj->getIdentity();
		}
	}

	// Function for edit travel guide photos details
	function fun_editTvlGuidPhotos($txtTvlGuidPhotoId, $txtTvlGuidPhotoCaption, $txtTvlGuidPhotoBy, $txtTvlGuidPhotoLink) {
		if(count($txtTvlGuidPhotoId) > 0) {
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

            for($i = 0; $i < count($txtTvlGuidPhotoId); $i++) {
                $photo_id 		= $txtTvlGuidPhotoId[$i];
				if(isset($txtTvlGuidPhotoCaption[$i]) && (strpos("Add caption for image ...", $txtTvlGuidPhotoCaption[$i]) === false)) {
					$photo_caption 	= $txtTvlGuidPhotoCaption[$i];
				} else {
					$photo_caption 	= "";
				}
				if(isset($txtTvlGuidPhotoBy[$i]) && $txtTvlGuidPhotoBy[$i] != "Photo by") {
					$photo_by 	= $txtTvlGuidPhotoBy[$i];
				} else {
					$photo_by 	= "";
				}
				if(isset($txtTvlGuidPhotoLink[$i]) && $txtTvlGuidPhotoLink[$i] != "http://") {
					$photo_link = $txtTvlGuidPhotoLink[$i];
				} else {
					$photo_link = "";
				}
                $sqlUpdateQuery = "UPDATE " . TABLE_TRAVEL_GUIDES_PHOTOS . " SET photo_caption = '".$photo_caption."', photo_by = '".$photo_by."', photo_link = '".$photo_link."', updated_on = '".$cur_unixtime."', updated_by = '".$cur_user_id."' WHERE photo_id='".$photo_id."'";
                $this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
            }			
            return true;
		} else {
			return false;
		}
	}

	// Function for travel guide add
	function fun_editTvlGuid($trvl_guid_id, $trvl_guid_categories_id, $trvl_guid_title, $trvl_guid_area_id = '', $trvl_guid_region_id = '', $trvl_guid_sub_region_id = '', $trvl_guid_location_id = '', $trvl_guid_desc, $trvl_guid_dir = '', $trvl_guid_suit = '', $trvl_guid_cost = '', $trvl_guid_long_last = '', $trvl_guid_open_detail = '', $trvl_guid_attraction = '', $trvl_guid_contact_phone = '', $trvl_guid_contact_web = '', $trvl_guid_contact_email = '', $status = '1') {
		if($trvl_guid_id == '') {
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
			
			if($status == "2") {
				$active = "1";
				$active_on = $cur_unixtime;
				$active_by = $cur_user_id;
			} else {
				$active = "0";
				$active_on = "";
				$active_by = "";
			}
			$featured = "0";

            $sqlUpdateQuery = "UPDATE " . TABLE_TRAVEL_GUIDES . " SET 
            trvl_guid_categories_id = '".$trvl_guid_categories_id."',
            trvl_guid_title = '".$trvl_guid_title."',
            trvl_guid_area_id = '".$trvl_guid_area_id."',
            trvl_guid_region_id = '".$trvl_guid_region_id."',
            trvl_guid_sub_region_id = '".$trvl_guid_sub_region_id."',
            trvl_guid_location_id = '".$trvl_guid_location_id."',
            trvl_guid_desc = '".$trvl_guid_desc."',
            trvl_guid_dir = '".$trvl_guid_dir."',
            trvl_guid_suit = '".$trvl_guid_suit."',
            trvl_guid_cost = '".$trvl_guid_cost."',
            trvl_guid_long_last = '".$trvl_guid_long_last."', 
            trvl_guid_open_detail = '".$trvl_guid_open_detail."', 
            trvl_guid_attraction = '".$trvl_guid_attraction."', 
            trvl_guid_contact_phone = '".$trvl_guid_contact_phone."', 
            trvl_guid_contact_web = '".$trvl_guid_contact_web."', 
            trvl_guid_contact_email = '".$trvl_guid_contact_email."', 
            status = '".$status."', 
            updated_on = '".$cur_unixtime."', 
            updated_by = '".$cur_user_id."', 
            featured = '".$featured."', 
            active = '".$active."' WHERE trvl_guid_id='".$trvl_guid_id."'";
            $this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
            return true;
		}
	}

	// Function	for delete travel guide photos and travel guide from temp table
	function fun_moveTvlGuidFrmTmp($trvl_guid_id, $trvl_guid_id_tmp = ''){
		if($trvl_guid_id == '' || $trvl_guid_id_tmp == ''){
			return false;
		} else {
			if(($tvlguid_img_array = $this->fun_findRelationInfo(TABLE_TRAVEL_GUIDES_PHOTOS , " WHERE trvl_guid_id='$trvl_guid_id_tmp'")) && (is_array($tvlguid_img_array))){
				for($i = 0; $i < count($tvlguid_img_array); $i++) {
					$photo_id 		= $tvlguid_img_array[$i]['photo_id'];

					$photo_url 		= $tvlguid_img_array[$i]['photo_url'];
					$photo_thumb 	= $tvlguid_img_array[$i]['photo_thumb'];

					$extn 			= split("\.",$photo_url);
					$photo_url_new	= $trvl_guid_id."_".$photo_id."_photo.".$extn[1];
					$photo_thumb_new= $trvl_guid_id."_".$photo_id."_photo_thumb.".$extn[1];

					$uploadphotodir = '../upload/tvlguid_images/large';
					$uploadthumbdir = '../upload/tvlguid_images/thumbnail';

					if(@copy($uploadphotodir."/449x341/".$photo_url, $uploadphotodir."/449x341/".$photo_url_new)) {
						@copy($uploadthumbdir."/168x127/".$photo_thumb, $uploadthumbdir."/168x127/".$photo_thumb_new);
						$sqlUpdateImgQuery = "UPDATE " . TABLE_TRAVEL_GUIDES_PHOTOS . " SET trvl_guid_id = '".$trvl_guid_id."', photo_url = '".$photo_url_new."', photo_thumb = '".$photo_thumb_new."' WHERE photo_id='".$photo_id."'";
						$this->dbObj->mySqlSafeQuery($sqlUpdateImgQuery);
					}

					//unlink temp files
					@unlink($uploadphotodir."/449x341/".$photo_url);
					@unlink($uploadthumbdir."/168x127/".$photo_thumb);
					@unlink($uploadphotodir."/".$photo_url);
				}
			}
			$strDelteQuery = "DELETE FROM " . TABLE_TRAVEL_GUIDES_TMP . " WHERE trvl_guid_id='$trvl_guid_id_tmp'";
			$this->dbObj->mySqlSafeQuery($strDelteQuery);
			return true;
		}
	}

	// Function for get array of travel guide main photo
	function fun_getResourceMainImgInfo($trvl_guid_id){
		if($trvl_guid_id == '') {
			return false;
		} else {
            $sql 	= "SELECT * FROM " . TABLE_TRAVEL_GUIDES_PHOTOS . " WHERE trvl_guid_id='".$trvl_guid_id."' AND photo_main='1'";
            $rs 	= $this->dbObj->createRecordset($sql);
            if($this->dbObj->getRecordCount($rs) > 0){
                $arr 	= $this->dbObj->fetchAssoc($rs);
                return $arr[0];
            } else {
                return false;
            }
        }
	}

	// Function for get array of travel guide photos
	function fun_getResourceImgArr($trvl_guid_id){
		if($trvl_guid_id == '') {
			return false;
		} else {
            $sql 	= "SELECT * FROM " . TABLE_TRAVEL_GUIDES_PHOTOS . " WHERE trvl_guid_id='".$trvl_guid_id."' ORDER BY photo_main ASC ";
            $rs 	= $this->dbObj->createRecordset($sql);
            if($this->dbObj->getRecordCount($rs) > 0){
                $arr 	= $this->dbObj->fetchAssoc($rs);
                return $arr;
            } else {
                return false;
            }
        }
	}

	// Function	for delete event photos from temp table
	function fun_delTvlGuidMainImg($trvl_guid_id = '', $main = ''){
		if($trvl_guid_id == ''){
			return false;
		} else {
			$strSelectQuery = "SELECT * FROM " . TABLE_TRAVEL_GUIDES_PHOTOS . " WHERE trvl_guid_id='$trvl_guid_id' AND photo_main='1'";
			$rs = $this->dbObj->createRecordset($strSelectQuery);
			$arr = $this->dbObj->fetchAssoc($rs);
			if(count($arr) > 0){
            	$photo_id 	= $arr[0]['photo_id'];
				$tempphoto 	= 'upload/tvlguid_images/large/'.$arr[0]['event_img'];
				$photo 		= 'upload/tvlguid_images/large/449x341/'.$arr[0]['event_img'];
				$thumb 		= 'upload/tvlguid_images/thumbnail/168x127/'.$arr[0]['event_thumb'];

                // Step II: Delete images and thumbnails
                set_time_limit(20);
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
                $strDelteQuery = "DELETE FROM " . TABLE_TRAVEL_GUIDES_PHOTOS . " WHERE photo_id='$photo_id'";
                $this->dbObj->mySqlSafeQuery($strDelteQuery);
                return true;
			}
		}
	}

	// Function	for delete event photos from temp table
	function fun_delTvlGuidImg($photo_id){
		if($photo_id == ''){
			return false;
		} else {
			$strSelectQuery = "SELECT * FROM " . TABLE_TRAVEL_GUIDES_PHOTOS . " WHERE photo_id='$photo_id'";
			$rs = $this->dbObj->createRecordset($strSelectQuery);
			$arr = $this->dbObj->fetchAssoc($rs);
			if(count($arr) > 0){
            	$photo_id 	= $arr[0]['photo_id'];
				$tempphoto 	= 'upload/tvlguid_images/large/'.$arr[0]['photo_url'];
				$photo 		= 'upload/tvlguid_images/large/449x341/'.$arr[0]['photo_url'];
				$thumb 		= 'upload/tvlguid_images/thumbnail/168x127/'.$arr[0]['photo_thumb'];

                // Step II: Delete images and thumbnails
                set_time_limit(20);
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
                $strDelteQuery = "DELETE FROM " . TABLE_TRAVEL_GUIDES_PHOTOS . " WHERE photo_id='$photo_id'";
                $this->dbObj->mySqlSafeQuery($strDelteQuery);
                return true;
			}
		}
	}

	// Function for travel guide add to temp
	function fun_addTvlGuidTemp($trvl_guid_categories_id, $trvl_guid_title, $trvl_guid_area_id = '', $trvl_guid_region_id = '', $trvl_guid_sub_region_id = '', $trvl_guid_location_id = '', $trvl_guid_desc, $trvl_guid_dir = '', $trvl_guid_suit = '', $trvl_guid_cost = '', $trvl_guid_long_last = '', $trvl_guid_open_detail = '', $trvl_guid_attraction = '', $trvl_guid_contact_phone = '', $trvl_guid_contact_web = '', $trvl_guid_contact_email = '') {
		$trvl_guid_id = $_REQUEST[PHPSESSID];
		if(($tvl_tmp_array = $this->fun_findRelationInfo(TABLE_TRAVEL_GUIDES_TMP , " WHERE trvl_guid_id='".$trvl_guid_id."'")) && (is_array($tvl_tmp_array))){
			$sqlUpdateQuery = "UPDATE " . TABLE_TRAVEL_GUIDES_TMP . " SET 
			trvl_guid_categories_id = '".$trvl_guid_categories_id."',
			trvl_guid_title = '".$trvl_guid_title."',
			trvl_guid_area_id = '".$trvl_guid_area_id."',
			trvl_guid_region_id = '".$trvl_guid_region_id."',
			trvl_guid_sub_region_id = '".$trvl_guid_sub_region_id."',
			trvl_guid_location_id = '".$trvl_guid_location_id."',
			trvl_guid_desc = '".$trvl_guid_desc."',
			trvl_guid_dir = '".$trvl_guid_dir."',
			trvl_guid_suit = '".$trvl_guid_suit."',
			trvl_guid_cost = '".$trvl_guid_cost."', 
			trvl_guid_long_last = '".$trvl_guid_long_last."', 
			trvl_guid_open_detail = '".$trvl_guid_open_detail."', 
			trvl_guid_attraction = '".$trvl_guid_attraction."', 
			trvl_guid_contact_phone = '".$trvl_guid_contact_phone."', 
			trvl_guid_contact_web = '".$trvl_guid_contact_web."', 
			trvl_guid_contact_email = '".$trvl_guid_contact_email."'
			WHERE trvl_guid_id='".$trvl_guid_id."'";

			$this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
			return true;
		} else {
			$strInsQuery = "INSERT INTO " . TABLE_TRAVEL_GUIDES_TMP . " 
			(trvl_guid_id, trvl_guid_categories_id, trvl_guid_title, trvl_guid_area_id, trvl_guid_region_id, trvl_guid_sub_region_id, trvl_guid_location_id, trvl_guid_desc, trvl_guid_dir, trvl_guid_suit, trvl_guid_cost, trvl_guid_long_last, trvl_guid_open_detail, trvl_guid_attraction, trvl_guid_contact_phone, trvl_guid_contact_web, trvl_guid_contact_email) 
			VALUES('".$trvl_guid_id."', '".$trvl_guid_categories_id."', '".$trvl_guid_title."', '".$trvl_guid_area_id."', '".$trvl_guid_region_id."', '".$trvl_guid_sub_region_id."', '".$trvl_guid_location_id."', '".$trvl_guid_desc."', '".$trvl_guid_dir."', '".$trvl_guid_suit."', '".$trvl_guid_cost."', '".$trvl_guid_long_last."', '".$trvl_guid_open_detail."', '".$trvl_guid_attraction."', '".$trvl_guid_contact_phone."', '".$trvl_guid_contact_web."', '".$trvl_guid_contact_email."')";
			$this->dbObj->fun_db_query($strInsQuery);
			return true;
		}
	}

	// Function for creating travel guide category add
	function fun_addTvlCat($trvl_guid_categories_name, $trvl_guid_categories_desc) {
		if($trvl_guid_categories_name == '' ||  $trvl_guid_categories_desc == '') {
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
			$strInsQuery = "INSERT INTO " . TABLE_TRAVEL_GUIDES_CATEGORIES . " (trvl_guid_categories_id, trvl_guid_categories_name, trvl_guid_categories_desc, created_on, created_by, updated_on, updated_by) VALUES(null, '".$trvl_guid_categories_name."', '".$trvl_guid_categories_desc."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."')";
			$this->dbObj->fun_db_query($strInsQuery);
		}
	}

	// Function for creating travel guide category add
	function fun_editTvlCat($trvl_guid_categories_id, $trvl_guid_categories_name, $trvl_guid_categories_desc) {
		if($trvl_guid_categories_id == '' || $trvl_guid_categories_name == '' ||  $trvl_guid_categories_desc == '') {
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

			$sqlUpdateQuery = "UPDATE " . TABLE_TRAVEL_GUIDES_CATEGORIES . " SET trvl_guid_categories_name = '".$trvl_guid_categories_name."', trvl_guid_categories_desc = '".$trvl_guid_categories_desc."', updated_on = '".$cur_unixtime."', updated_by = '".$cur_user_id."' WHERE trvl_guid_categories_id='".$trvl_guid_categories_id."'";
			$this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
		}
	}

	// Function for update travel guide photo
	function fun_updateTvlGuidImg($photo_id, $trvl_guid_id, $photo_caption, $photo_url, $photo_thumb, $photo_by, $photo_link, $photo_main){
		if($photo_id == '') {
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
			if($photo_main == '') {
				$photo_main = '0';
			}
			$sqlUpdateQuery = "UPDATE " . TABLE_TRAVEL_GUIDES_PHOTOS . " SET trvl_guid_id = '".$trvl_guid_id."', photo_caption = '".$photo_caption."', photo_url = '".$photo_url."', photo_thumb = '".$photo_thumb."', photo_by = '".$photo_by."', photo_link = '".$photo_link."', updated_on = '".$cur_unixtime."', updated_by = '".$cur_user_id."', photo_main = '".$photo_main."' WHERE photo_id='".$photo_id."'";
			$this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
		}
	}

	// Function for travel guide main image add
	function fun_addTvlGuidImg($trvl_guid_id, $photo_caption, $photo_url = '', $photo_thumb = '', $photo_main = '') {
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

        $strInsQuery = "INSERT INTO " . TABLE_TRAVEL_GUIDES_PHOTOS . " 
        (photo_id, trvl_guid_id, photo_caption, photo_url, photo_thumb, created_on, created_by, updated_on, updated_by, photo_main) 
        VALUES(null, '".$trvl_guid_id."', '".$photo_caption."', '".$photo_url."', '".$photo_thumb."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."', '1')";
        $this->dbObj->fun_db_query($strInsQuery);
        return $this->dbObj->getIdentity();
	}

	function fun_updateTvlGuidFeature($trvl_guid_id, $featured = '') {
		if($trvl_guid_id == '') {
			return false;
		} else {
			if($featured == '') {
				$featured = '0';
			}
			$sqlUpdateQuery = "UPDATE " . TABLE_TRAVEL_GUIDES . " SET featured = '".$featured."' WHERE trvl_guid_id='".$trvl_guid_id."'";
			$this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
		}
	}

	// Function for list of travel guide by featured
	function fun_getResourceGuidListByFeaturedArr(){
		$sql = "SELECT 	A.trvl_guid_id, 
						A.trvl_guid_categories_id,
						A.trvl_guid_title,
						A.trvl_guid_desc,
						A.trvl_guid_area_id,
						A.trvl_guid_region_id,
						A.trvl_guid_sub_region_id,
						A.trvl_guid_location_id,
						A.status,
						A.created_on,
						A.updated_on,
						A.featured, 
						A.active
				FROM " . TABLE_TRAVEL_GUIDES . " AS A WHERE A.status ='2' AND A.active ='1' AND A.featured='1'";
		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			return $arr = $this->dbObj->fetchAssoc($rs);
		} else {
			return false;
		}
	}

	function fun_getResourceCatIdByTvlId($trvl_guid_id = '') {
		if($trvl_guid_id == '') {
			return false;
		} else {
			$sql = "SELECT trvl_guid_categories_id FROM " . TABLE_TRAVEL_GUIDES . " WHERE trvl_guid_id ='".$trvl_guid_id."'";
			$rs = $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);
				return $arr[0]['trvl_guid_categories_id'];
			} else {
				return false;
			}
		}
	}

	// Function for list of travel guide top attraction
	function fun_getResourceTopAttractionList($category_id = '', $trvl_guid_id = ''){
		$sql = "SELECT 	A.trvl_guid_id, A.trvl_guid_title FROM " . TABLE_TRAVEL_GUIDES . " AS A WHERE A.status ='2' AND A.active ='1' ";
		if(isset($category_id) && ($category_id != "")) {
		$sql .= "AND A.trvl_guid_categories_id ='".$category_id."' ";
		}
		if(isset($trvl_guid_id) && ($trvl_guid_id != "")) {
		$sql .= "AND A.trvl_guid_id NOT IN (".$trvl_guid_id.") ";
		}
		$sql .= "ORDER BY RAND() LIMIT 0, 10";

		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			return $arr = $this->dbObj->fetchAssoc($rs);
		} else {
			return false;
		}
	}

	// Function for list of travel guide by category
	function fun_getResourceGuidListByCatArr($trvl_guid_categories_id){
    	if($trvl_guid_categories_id == '') {
        	return false;
        } else {
            $sql = "SELECT 	A.trvl_guid_id, 
                            A.trvl_guid_categories_id,
                            A.trvl_guid_title,
                            A.trvl_guid_desc,
                            A.trvl_guid_area_id,
                            A.trvl_guid_region_id,
                            A.trvl_guid_sub_region_id,
                            A.trvl_guid_location_id,
                            A.status,
                            A.created_on,
                            A.updated_on,
                            A.featured, 
                            A.active
                    FROM " . TABLE_TRAVEL_GUIDES . " AS A WHERE A.status ='2' AND A.active ='1' AND A.trvl_guid_categories_id='".$trvl_guid_categories_id."'";
            $rs = $this->dbObj->createRecordset($sql);
            if($this->dbObj->getRecordCount($rs) > 0){
                $arr = $this->dbObj->fetchAssoc($rs);
				return $arr;
            } else {
            	return false;
            }
        }
	}

	// Function for creating travel guide category panel
	function fun_createTvlCatLeftPanel($trvl_guid_categories_id=''){		
		$sql 	= "SELECT trvl_guid_categories_id, trvl_guid_categories_name FROM " . TABLE_TRAVEL_GUIDES_CATEGORIES . " ORDER BY trvl_guid_categories_name";
        $rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
            $arr = $this->dbObj->fetchAssoc($rs);
            $strlinkclass = "";
            echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
            echo "<tr><td><img src=\"images/left-panel-top.gif\" alt=\"rentownersvillas.com\" width=\"218\" height=\"20\" /></td></tr>";
            echo "<tr>";
            echo "<td class=\"RegLeftPanelTravel\">";
            echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
            echo "<tr>";
            echo "<td valign=\"top\" class=\"pad-lft15 pad-rgt15\" >";
            echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
            echo "<tr><td><h1 class=\"gray18\">Travel guides</h1></td></tr>";
            echo "</table>";
            echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" id=\"ownerOptionId\">";
            echo "<tr><td><img src=\"images/spacer.gif\" width=\"170\" height=\"10\" /></td></tr>";
//            echo "<tr><td class=\"MyPropertiesLeftLink1\"><a href=\"holiday-travelguides.php\">Top attractions</a></td></tr>";
            for($i = 0; $i < count($arr); $i++) {
                $strlinkclass = "";
                if($arr[$i]['trvl_guid_categories_id'] == $trvl_guid_categories_id  && $trvl_guid_categories_id!=''){
					if($i == (count($arr) -1)) {
						$strlinkclass = " class=\"matter\" style=\"padding-top:4px;\"";
					} else {
						$strlinkclass = " class=\"MyPropertiesLeftLink1\"";
					}
                } else {
					if($i == (count($arr) -1)) {
						$strlinkclass = " class=\"matter\" style=\"padding-top:4px;\"";
					} else {
						$strlinkclass = " class=\"MyPropertiesLeftLink1\"";
					}
                }
                echo "<tr><td ".$strlinkclass."><a href=\"holiday-travelguides.php?catid=".$arr[$i]['trvl_guid_categories_id']."\">".ucfirst($arr[$i]['trvl_guid_categories_name'])."</a></td></tr>";
            }
            echo "</table>";
            echo "</td>";
            echo "</tr>";
            echo "</table>";
            echo "</td>";
            echo "</tr>";
            echo "<tr><td><img src=\"images/left-panel-bottom.gif\" alt=\"rentownersvillas.com\" width=\"218\" height=\"20\" /></td></tr>";
            echo "</table>";
        }        
	}
*/
	// This function will Return data in array
	function fun_findRelationInfo($table, $criteria){		
		$sql = "SELECT * FROM " .$table. " " .$criteria. "";

		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			return $arr = $this->dbObj->fetchAssoc($rs);		
		}
		else{
			return false;
		}
	}
}
?>