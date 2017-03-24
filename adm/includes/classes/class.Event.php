<?php
class Event{
	var $dbObj;
	
	function Event(){ // class constructor
		$this->dbObj = new DB();
		$this->dbObj->fun_db_connect();
	}
	
	// This function will Return Event information in array with front end data	
	function fun_getEventInfo($event_id){		
		$sql 	= "SELECT * FROM " . TABLE_EVENTS . " WHERE event_id='".$event_id."'";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr 	= $this->dbObj->fetchAssoc($rs);
			return $arr[0];
		} else {
			return false;
		}
	}

	// This function will Return Event information in array with front end data	
	function fun_getEventDetailsByCode($event_code){		
		$sql 	= "SELECT * FROM " . TABLE_EVENTS . " WHERE event_code='".$event_code."'";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr 	= $this->dbObj->fetchAssoc($rs);
			return $arr[0];
		} else {
			return false;
		}
	}

	// This function will Return Event information in array with front end data	
	function fun_getEventDetailsByName($event){		
		$sql 	= "SELECT * FROM " . TABLE_EVENTS . " WHERE REPLACE(LOWER(event_name), '&', '')='".strtolower($event)."'";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr 	= $this->dbObj->fetchAssoc($rs);
			return $arr[0];
		} else {
			return false;
		}
	}


	// This function will Return Temp Event information in array
	function fun_getEventTmpInfo($event_id){		
		$sql 	= "SELECT * FROM " . TABLE_EVENTS_TMP . " WHERE event_id='".$event_id."'";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr 	= $this->dbObj->fetchAssoc($rs);
			return $arr[0];
		} else {
			return false;
		}
	}

	// Function for creating array of availability
	function fun_getEventCategoryTypeArr(){		
		$sql = "SELECT * FROM " . TABLE_EVENTS_CATEGORIES . " ORDER BY events_categories_name";
		$rs = $this->dbObj->createRecordset($sql);
		return $arr = $this->dbObj->fetchAssoc($rs);		
	}

	function fun_getEventCatNameByCatIdsWithNL($events_categories_ids) {
		if($events_categories_ids == '') {
			return false;
		} else {
			$sql = "SELECT events_categories_name FROM " . TABLE_EVENTS_CATEGORIES . " WHERE events_categories_id IN (".$events_categories_ids.") ORDER BY events_categories_name";
			$rs = $this->dbObj->createRecordset($sql);
			$arr = $this->dbObj->fetchAssoc($rs);
			if(is_array($arr) && count($arr) > 0) {
				$strEventCategorieName = "";
				for($i = 0; $i < count($arr); $i++) {
					if($i == count($arr)-1) {
						$strEventCategorieName .= ucfirst($arr[$i]['events_categories_name']);
					} else {
						$strEventCategorieName .= ucfirst($arr[$i]['events_categories_name'])."<br />";
					}
				}
				return $strEventCategorieName;
			} else {
				return false;
			}
		}
	}
		// Function for email users array
	function fun_delevents($event_id){
		// Delete from TABLE_USER_NEWSLETTER
		$strDelQuery = "DELETE FROM " .TABLE_EVENTS . " WHERE event_id='".$event_id."'";
		$this->dbObj->mySqlSafeQuery($strDelQuery);
		return true;
	}



	function fun_getEventCatNameByCatIdsWithVB($events_categories_ids) {
		if($events_categories_ids == '') {
			return false;
		} else {
			$sql = "SELECT events_categories_name FROM " . TABLE_EVENTS_CATEGORIES . " WHERE events_categories_id IN (".$events_categories_ids.") ORDER BY events_categories_name";
			$rs = $this->dbObj->createRecordset($sql);
			$arr = $this->dbObj->fetchAssoc($rs);
			if(is_array($arr) && count($arr) > 0) {
				$strEventCategorieName = "";
				for($i = 0; $i < count($arr); $i++) {
					if($i == 0) {
						$strEventCategorieName .= "<a href=\"javascript:void(0);\" class=\"blue-link\">".ucfirst($arr[$i]['events_categories_name'])."</a>";
					} else {
						$strEventCategorieName .= "  |  <a href=\"javascript:void(0);\" class=\"blue-link\">".ucfirst($arr[$i]['events_categories_name'])."</a>";
					}
				}
				return $strEventCategorieName;
			} else {
				return false;
			}
		}
	}

	function fun_getEventCatNameByCatIdsWithVBnRS($events_categories_ids) {
		if($events_categories_ids == '') {
			return false;
		} else {
			$sql = "SELECT events_categories_id, events_categories_name FROM " . TABLE_EVENTS_CATEGORIES . " WHERE events_categories_id IN (".$events_categories_ids.") ORDER BY events_categories_name";
			$rs = $this->dbObj->createRecordset($sql);
			$arr = $this->dbObj->fetchAssoc($rs);
			if(is_array($arr) && count($arr) > 0) {
				$strEventCategorieName = "";
				for($i = 0; $i < count($arr); $i++) {
					$events_categories_id = $arr[$i]['events_categories_id'];
					if($i == 0) {
						$strEventCategorieName .= "<a href=\"javascript:void(0);\" class=\"blue-link\" onclick=\"refineEventListByCat(".$events_categories_id.");\" >".ucfirst($arr[$i]['events_categories_name'])."</a>";
					} else {
						$strEventCategorieName .= "  |  <a href=\"javascript:void(0);\" class=\"blue-link\" onclick=\"refineEventListByCat(".$events_categories_id.");\" >".ucfirst($arr[$i]['events_categories_name'])."</a>";
					}
				}
				return $strEventCategorieName;
			} else {
				return false;
			}
		}
	}

	function fun_getEventCatNameByCatIdsWithVBnRSTmp($events_categories_ids) {
		if($events_categories_ids == '') {
			return false;
		} else {
			$sql = "SELECT events_categories_id, events_categories_name FROM " . TABLE_EVENTS_CATEGORIES . " WHERE events_categories_id IN (".$events_categories_ids.") ORDER BY events_categories_name";
			$rs = $this->dbObj->createRecordset($sql);
			$arr = $this->dbObj->fetchAssoc($rs);
			if(is_array($arr) && count($arr) > 0) {
				$strEventCategorieName = "";
				for($i = 0; $i < count($arr); $i++) {
					$events_categories_id = $arr[$i]['events_categories_id'];
					if($i == 0) {
						$strEventCategorieName .= "<a href=\"javascript:void(0);\" class=\"blue-link\" >".ucfirst($arr[$i]['events_categories_name'])."</a>";
					} else {
						$strEventCategorieName .= "  |  <a href=\"javascript:void(0);\" class=\"blue-link\" >".ucfirst($arr[$i]['events_categories_name'])."</a>";
					}
				}
				return $strEventCategorieName;
			} else {
				return false;
			}
		}
	}

	function fun_updateEventFeature($event_id, $featured = '') {
		if($event_id == '') {
			return false;
		} else {
			if($featured == '') {
				$featured = '0';
			}
			$sqlUpdateQuery = "UPDATE " . TABLE_EVENTS . " SET featured = '".$featured."' WHERE event_id='".$event_id."'";
			$this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
		}
	}

	// Function for creating optionlist for languages if language_id is available it must be selected
	function fun_getEventCategoryTypeOptionsList($events_categories_id = ''){		
		$selected = "";
		$sql = "SELECT * FROM " . TABLE_EVENTS_CATEGORIES. " ORDER BY events_categories_name";
		$result = $this->dbObj->fun_db_query($sql);
		while($rowsCon = $this->dbObj->fun_db_fetch_rs_object($result)){
			if($rowsCon->events_categories_id == $events_categories_id  && $events_categories_id!=''){
				$selected = "selected";
			}else{
				$selected = "";
			}
			echo "<option value=".fun_db_output($rowsCon->events_categories_id)." " .$selected. ">";
			echo fun_db_output(ucwords($rowsCon->events_categories_name));
			echo "</option>";
		}
		$this->dbObj->fun_db_free_resultset($result);
	}

	// Function	for moving data from event temp table to actual table
	function fun_moveEventFromEventTmp($event_id_tmp) {
		if($event_id_tmp == '') {
			return false;
		} else {
			if(($tmp_photos_array = $this->fun_findRelationInfo(TABLE_EVENTS_TMP , " WHERE event_id='".$event_id_tmp."'")) && (is_array($tmp_photos_array))){

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

                $event_cat_ids 			= $tmp_photos_array[0]['event_cat_ids'];
                $event_name 			= $tmp_photos_array[0]['event_name'];
                $event_description 		= $tmp_photos_array[0]['event_description'];
                $event_area_id 			= $tmp_photos_array[0]['event_area_id'];
                $event_region_id 		= $tmp_photos_array[0]['event_region_id'];
                $event_sub_region_id 	= $tmp_photos_array[0]['event_sub_region_id'];
                $event_location_id 		= $tmp_photos_array[0]['event_location_id'];
                $event_year_around 		= $tmp_photos_array[0]['event_year_around'];
                $event_start_date 		= $tmp_photos_array[0]['event_start_date'];
                $event_end_date 		= $tmp_photos_array[0]['event_end_date'];
                $event_time 			= $tmp_photos_array[0]['event_time'];
                $event_price 			= $tmp_photos_array[0]['event_price'];
                $event_venue 			= $tmp_photos_array[0]['event_venue'];
                $event_phone 			= $tmp_photos_array[0]['event_phone'];
                $event_email 			= $tmp_photos_array[0]['event_email'];
                $event_website 			= $tmp_photos_array[0]['event_website'];
                $event_img 				= "";
                $event_thumb 			= "";
                $event_img_caption 		= $tmp_photos_array[0]['event_img_caption'];
                $event_img_by 			= $tmp_photos_array[0]['event_img_by'];
                $event_img_link 		= $tmp_photos_array[0]['event_img_link'];
                $event_owner_fname 		= $tmp_photos_array[0]['event_owner_fname'];
                $event_owner_lname 		= $tmp_photos_array[0]['event_owner_lname'];
                $event_owner_email 		= $tmp_photos_array[0]['event_owner_email'];
                $status 				= "1";
                $active_on 				= $cur_unixtime;
                $active_by 				= $cur_user_id;
                $created_on 			= $cur_unixtime;
                $created_by 			= $cur_user_id;
                $updated_on 			= $cur_unixtime;
                $updated_by 			= $cur_user_id;
                $featured 				= "0";
                $active 				= "0";

				$strInsQuery = "INSERT INTO " . TABLE_EVENTS . " (event_id, event_cat_ids, event_code, event_name, event_description, event_area_id, event_region_id, event_sub_region_id, event_location_id, event_year_around, event_start_date, event_end_date, event_time, event_price, event_venue, event_phone, event_email, event_website, event_img, event_thumb, event_img_caption, event_img_by, event_img_link, event_owner_fname, event_owner_lname, event_owner_email, status, active_on, active_by, created_on, created_by, updated_on, updated_by, featured, active) VALUES(null, '".$event_cat_ids."', '', '".$event_name."', '".$event_description."', '".$event_area_id."', '".$event_region_id."', '".$event_sub_region_id."', '".$event_location_id."', '".$event_year_around."', '".$event_start_date."', '".$event_end_date."', '".$event_time."', '".$event_price."', '".$event_venue."', '".$event_phone."', '".$event_email."', '".$event_website."', '".$event_img."', '".$event_thumb."', '".$event_img_caption."',  '".$event_img_by."',  '".$event_img_link."', '".$event_owner_fname."', '".$event_owner_lname."', '".$event_owner_email."', '".$status."', '".$active_on."', '".$active_by."', '".$created_on."', '".$created_by."', '".$updated_on."', '".$updated_by."', '".$featured."', '".$active."')";

				$this->dbObj->mySqlSafeQuery($strInsQuery);

				$event_id 				= $this->dbObj->getIdentity();
                //SAEVNT00000001
				//Algo for unique event code
				$event_code 			= "SAEVNT";
				for($i = strlen($event_id); $i < 8; $i++) {
				$event_code 			.= "0";
				}
				$event_code 			.= $event_id;

				$sqlUpdateQuery = "UPDATE " . TABLE_EVENTS . " SET event_code = '".$event_code."' WHERE event_id='".$event_id."'";
				$this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
				
				$event_img_tmp 			= $tmp_photos_array[0]['event_img'];
                $event_thumb_tmp 		= $tmp_photos_array[0]['event_thumb'];
				$extn 					= split("\.",$event_img_tmp); // find image extn

                $event_img 				= $event_id."_photo.".$extn[1];
                $event_thumb 			= $event_id."_photo_thumb.".$extn[1];


				$photodir = 'upload/event_images/large/449x341';
				$thumbdir = 'upload/event_images/thumbnail/168x127';
				
				if(@copy($photodir."/".$event_img_tmp, $photodir."/".$event_img)) {
					@copy($thumbdir."/".$event_thumb_tmp, $thumbdir."/".$event_thumb);
					$sqlUpdateImgQuery = "UPDATE " . TABLE_EVENTS . " SET event_img = '".$event_img."', event_thumb = '".$event_thumb."' WHERE event_id='".$event_id."'";
					$this->dbObj->mySqlSafeQuery($sqlUpdateImgQuery);
				}
				//unlink temp files
				set_time_limit(20);
				@unlink($photodir."/".$event_img_tmp);
				@unlink($thumbdir."/".$event_thumb_tmp);
				@unlink("upload/event_images/large/".$event_img_tmp);
				// Step III: Delete records from database
				$strDelteQuery = "DELETE FROM " . TABLE_EVENTS_TMP . " WHERE event_id='$event_id_tmp'";
				$this->dbObj->mySqlSafeQuery($strDelteQuery);

				return true;
			} else {
				return false;
			}
		}
	}

	// Function	for updating /adding events
	function fun_addEvent($event_id, $event_cat_ids = '', $event_name = '', $event_description = '', $event_area_id = '', $event_region_id = '', $event_sub_region_id = '', $event_location_id = '', $event_year_around = '', $event_start_date = '', $event_end_date = '', $event_time = '', $event_price = '', $event_venue = '', $event_phone = '', $event_email = '', $event_website = '', $event_img = '', $event_thumb = '', $event_img_caption = '',  $event_img_by = '',  $event_img_link = '', $event_owner_fname = '', $event_owner_lname = '', $event_owner_email = '') {
		if($event_id == '') {
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

			if(($photos_array = $this->fun_findRelationInfo(TABLE_EVENTS , " WHERE event_id='".$event_id."'")) && (is_array($photos_array))){

				if($event_img == "" && $event_thumb == "") {
					$event_img 			= $photos_array[0]['event_img'];
					$event_thumb 		= $photos_array[0]['event_thumb'];
				}

				$sqlUpdateQuery = "UPDATE " . TABLE_EVENTS . " SET 
				event_cat_ids = '".$event_cat_ids."',
				event_name = '".$event_name."',
				event_description = '".$event_description."',
				event_area_id = '".$event_area_id."',
				event_region_id = '".$event_region_id."',
				event_sub_region_id = '".$event_sub_region_id."',
				event_location_id = '".$event_location_id."',
				event_year_around = '".$event_year_around."',
				event_start_date = '".$event_start_date."',
				event_end_date = '".$event_end_date."',
				event_time = '".$event_time."', 
				event_price = '".$event_price."', 
				event_venue = '".$event_venue."', 
				event_phone = '".$event_phone."', 
				event_email = '".$event_email."', 
				event_website = '".$event_website."', 
				event_img = '".$event_img."', 
				event_thumb = '".$event_thumb."', 
				event_img_caption = '".$event_img_caption."', 
				event_img_by = '".$event_img_by."', 
				event_img_link = '".$event_img_link."', 
				event_owner_fname = '".$event_owner_fname."', 
				event_owner_lname = '".$event_owner_lname."', 
				event_owner_email = '".$event_owner_email."',
				updated_on = '".$cur_unixtime."',
				updated_by = '".$cur_user_id."'
				WHERE event_id='".$event_id."'";

				$this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
				return true;
			} else {

/*
event_id
event_cat_ids
event_code
event_name
event_description
event_area_id
event_region_id
event_sub_region_id
event_location_id
event_year_around
event_start_date
event_end_date
event_time
event_price
event_venue
event_phone
event_email
event_website
event_img
event_thumb
event_owner_fname
event_owner_lname
event_owner_email
status
active_on
active_by
created_on
created_by
updated_on
updated_by
featured
active


(event_id, event_cat_ids, event_code, event_name, event_description, 
event_area_id, event_region_id, event_sub_region_id, event_location_id, 
event_year_around, event_start_date, event_end_date, event_time, event_price, 
event_venue, event_phone, event_email, event_website, event_img, event_thumb,
event_owner_fname, event_owner_lname, event_owner_email, status, active_on, 
active_by, created_on, created_by, updated_on, updated_by, featured, active)
VALUES(null, '".$event_cat_ids."', '', '".$event_name."', '".$event_description."', 
'".$event_area_id."', '".$event_region_id."', '".$event_sub_region_id."', '".$event_location_id."', 
'".$event_year_around."', '".$event_start_date."', '".$event_end_date."', '".$event_time."', '".$event_price."', 
'".$event_venue."', '".$event_phone."', '".$event_email."', '".$event_website."', '".$event_img."', '".$event_thumb."', 
'".$event_owner_fname."', '".$event_owner_lname."', '".$event_owner_email."', '".$status."', '',
'', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."',, '0', '0')";

$event_img_by = '',  $event_img_link = '', 
*/

				$strInsQuery = "INSERT INTO " . TABLE_EVENTS . " 
				(event_id, event_cat_ids, event_code, event_name, event_description, 
				event_area_id, event_region_id, event_sub_region_id, event_location_id, 
				event_year_around, event_start_date, event_end_date, event_time, event_price, 
				event_venue, event_phone, event_email, event_website, event_img, event_thumb, event_img_caption, event_img_by, event_img_link,
				event_owner_fname, event_owner_lname, event_owner_email, status, active_on, 
				active_by, created_on, created_by, updated_on, updated_by, featured, active)
				VALUES(null, '".$event_cat_ids."', '', '".$event_name."', '".$event_description."', 
				'".$event_area_id."', '".$event_region_id."', '".$event_sub_region_id."', '".$event_location_id."', 
				'".$event_year_around."', '".$event_start_date."', '".$event_end_date."', '".$event_time."', '".$event_price."', 
				'".$event_venue."', '".$event_phone."', '".$event_email."', '".$event_website."', '".$event_img."', '".$event_thumb."', '".$event_img_caption."', '".$event_img_by."', '".$event_img_link."', 
				'".$event_owner_fname."', '".$event_owner_lname."', '".$event_owner_email."', '".$status."', '',
				'', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."', '0', '0')";
				$this->dbObj->fun_db_query($strInsQuery);
				$event_id 				= $this->dbObj->getIdentity();
                //SAEVNT00000001
				//Algo for unique event code
				$event_code 			= "SAEVNT";
				for($i = strlen($event_id); $i < 8; $i++) {
				$event_code 			.= "0";
				}
				$event_code 			.= $event_id;

				$sqlUpdateQuery = "UPDATE " . TABLE_EVENTS . " SET event_code = '".$event_code."' WHERE event_id='".$event_id."'";
				$this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
				return true;
			}
		}
	}

	// Function	for updating event temp photo
	function fun_addEventTemp($event_id, $event_cat_ids = '', $event_name = '', $event_description = '', $event_area_id = '', $event_region_id = '', $event_sub_region_id = '', $event_location_id = '', $event_year_around = '', $event_start_date = '', $event_end_date = '', $event_time = '', $event_price = '', $event_venue = '', $event_phone = '', $event_email = '', $event_website = '', $event_img = '', $event_thumb = '', $event_img_caption = '',  $event_img_by = '',  $event_img_link = '', $event_owner_fname = '', $event_owner_lname = '', $event_owner_email = '') {
		if($event_id == '') {
			return false;
		} else {
			if(($tmp_photos_array = $this->fun_findRelationInfo(TABLE_EVENTS_TMP , " WHERE event_id='".$event_id."'")) && (is_array($tmp_photos_array))){
				if($event_img == "" && $event_thumb == "") {
					$event_img 		= $tmp_photos_array[0]['event_img'];
					$event_thumb 	= $tmp_photos_array[0]['event_thumb'];
				}
				$sqlUpdateQuery = "UPDATE " . TABLE_EVENTS_TMP . " SET 
				event_cat_ids = '".$event_cat_ids."',
				event_name = '".$event_name."',
				event_description = '".$event_description."',
				event_area_id = '".$event_area_id."',
				event_region_id = '".$event_region_id."',
				event_sub_region_id = '".$event_sub_region_id."',
				event_location_id = '".$event_location_id."',
				event_year_around = '".$event_year_around."',
				event_start_date = '".$event_start_date."',
				event_end_date = '".$event_end_date."',
				event_time = '".$event_time."', 
				event_price = '".$event_price."', 
				event_venue = '".$event_venue."', 
				event_phone = '".$event_phone."', 
				event_email = '".$event_email."', 
				event_website = '".$event_website."', 
				event_img = '".$event_img."', 
				event_thumb = '".$event_thumb."', 
				event_img_caption = '".$event_img_caption."', 
				event_img_by = '".$event_img_by."', 
				event_img_link = '".$event_img_link."', 
				event_owner_fname = '".$event_owner_fname."', 
				event_owner_lname = '".$event_owner_lname."', 
				event_owner_email = '".$event_owner_email."' WHERE event_id='".$event_id."'";
				$this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
				return true;
			} else {
				$strInsQuery = "INSERT INTO " . TABLE_EVENTS_TMP . " (event_id, event_cat_ids, event_name, event_description, event_area_id, event_region_id, event_sub_region_id, event_location_id, event_year_around, event_start_date, event_end_date, event_time, event_price, event_venue, event_phone, event_email, event_website, event_img, event_thumb, event_img_caption, event_img_by, event_img_link, event_owner_fname, event_owner_lname, event_owner_email) VALUES('".$event_id."', '".$event_cat_ids."', '".$event_name."', '".$event_description."', '".$event_area_id."', '".$event_region_id."', '".$event_sub_region_id."', '".$event_location_id."', '".$event_year_around."', '".$event_start_date."', '".$event_end_date."', '".$event_time."', '".$event_price."', '".$event_venue."', '".$event_phone."', '".$event_email."', '".$event_website."', '".$event_img."', '".$event_thumb."', '".$event_img_caption."', '".$event_img_by."', '".$event_img_link."', '".$event_owner_fname."', '".$event_owner_lname."', '".$event_owner_email."')";
				$this->dbObj->fun_db_query($strInsQuery);
				return true;
			}
		}
	}

	// Function	for delete event photos from temp table
	function fun_delEventTemp($event_id = ''){
		if($event_id == ''){
			return false;
		} else {
			$strSelectQuery = "SELECT * FROM " . TABLE_EVENTS_TMP . " WHERE event_id='$event_id'";
			$rs = $this->dbObj->createRecordset($strSelectQuery);
			$arr = $this->dbObj->fetchAssoc($rs);
			if(count($arr) > 0){
				$tempphoto 	= 'upload/event_images/large/'.$arr[0]['event_img'];
				$photo 		= 'upload/event_images/large/449x341/'.$arr[0]['event_img'];
				$thumb 		= 'upload/event_images/thumbnail/168x127/'.$arr[0]['event_thumb'];
			}
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
			$strDelteQuery = "DELETE FROM " . TABLE_EVENTS_TMP . " WHERE event_id='$event_id'";
			$this->dbObj->mySqlSafeQuery($strDelteQuery);
			return true;
		}
	}

	// Function	for delete event photos from event table
	function fun_delEventImg($event_id = ''){
		if($event_id == ''){
			return false;
		} else {
			$strSelectQuery = "SELECT * FROM " . TABLE_EVENTS . " WHERE event_id='$event_id'";
			$rs = $this->dbObj->createRecordset($strSelectQuery);
			$arr = $this->dbObj->fetchAssoc($rs);
//			print_r($arr);
			if(count($arr) > 0){
				$tempphoto 	= '../upload/event_images/large/'.$arr[0]['event_img'];
				$photo 		= '../upload/event_images/large/449x341/'.$arr[0]['event_img'];
				$thumb 		= '../upload/event_images/thumbnail/168x127/'.$arr[0]['event_thumb'];
			}
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
			$sqlUpdateQuery = "UPDATE " . TABLE_EVENTS . " SET event_img = '' AND event_thumb = '' WHERE event_id='".$event_id."'";
			$this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
			return true;
		}
	}


	// Function	for delete event
	function fun_delEvent($event_id = ''){
		if($event_id == ''){
			return false;
		} else {
			$strSelectQuery = "SELECT * FROM " . TABLE_EVENTS . " WHERE event_id='$event_id'";
			$rs = $this->dbObj->createRecordset($strSelectQuery);
			$arr = $this->dbObj->fetchAssoc($rs);
			if(count($arr) > 0){
				$tempphoto 	= '../upload/event_images/large/'.$arr[0]['event_img'];
				$photo 		= '../upload/event_images/large/449x341/'.$arr[0]['event_img'];
				$thumb 		= '../upload/event_images/thumbnail/168x127/'.$arr[0]['event_thumb'];
			}
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
			$strDelteQuery = "DELETE FROM " . TABLE_EVENTS . " WHERE event_id='$event_id'";
			$this->dbObj->mySqlSafeQuery($strDelteQuery);
			return true;
		}
	}

	// Function for refine event search
	function fun_getEventsSearchArr($txtFromDate = '', $txtToDate = '', $txtEventCategory = '', $txtcountryid = '', $txtareaid = '', $txtregionid = '', $txtsubregionid = '', $txtlocationid = '', $strQueryParameter = '') {
/*
echo "<br>";
echo $txtFromDate."<br>";
echo $txtToDate."<br>";
echo $txtEventCategory."<br>";
echo $txtcountryid."<br>";
echo $txtareaid."<br>";
echo $txtregionid."<br>";
echo $txtsubregionid."<br>";
echo $txtlocationid."<br>";
echo $strQueryParameter."<br>";
*/
		$dateParameter 		= false;
		$locationParameter 	= false;
		$categoryParameter 	= false;

		$eventIdArr 			= array();
		$sqlEvnt		= "SELECT event_id FROM " . TABLE_EVENTS . " WHERE status ='2' AND active ='1'";
		$rsEvnt 		= $this->dbObj->createRecordset($sqlEvnt);
		if($this->dbObj->getRecordCount($rsEvnt) > 0) {
			$arrEvnt = $this->dbObj->fetchAssoc($rsEvnt);
			for($i = 0; $i < count($arrEvnt); $i++) {
				array_push($eventIdArr, "'".$arrEvnt[$i]['event_id']."'");
			}
		}
// OK
//print_r($eventIdArr);

		if((isset($txtFromDate) && $txtFromDate !="") && (isset($txtToDate) && $txtToDate !="")) {
			$dateParameter 		= true;
			$eventIdByFromToDateArr = array();
			if($txtFromDate == $txtToDate) {
				if(($date_relation_array = $this->fun_findRelationInfo(TABLE_EVENTS , " WHERE (event_start_date =  '".$txtFromDate."' AND event_end_date = '".$txtFromDate."') OR event_year_around='1' ")) && (is_array($date_relation_array))){
					for($i = 0; $i < count($date_relation_array); $i++) {
						array_push($eventIdByFromToDateArr, "'".$date_relation_array[$i]['event_id']."'");
					}
				}
			} else {
				if(($date_relation_array = $this->fun_findRelationInfo(TABLE_EVENTS , " WHERE ((event_start_date >=  '".$txtFromDate."' AND event_start_date <= '".$txtToDate."') OR (event_end_date >= '".$txtFromDate."' AND event_end_date <=  '".$txtToDate."')) OR event_year_around='1' ")) && (is_array($date_relation_array))){
					for($i = 0; $i < count($date_relation_array); $i++) {
						array_push($eventIdByFromToDateArr, "'".$date_relation_array[$i]['event_id']."'");
					}
				}
			}
        } else if((isset($txtFromDate) && $txtFromDate !="") && !isset($txtToDate)) {
			$dateParameter 		= true;
			$eventIdByFromToDateArr = array();
			if(($date_relation_array = $this->fun_findRelationInfo(TABLE_EVENTS , " WHERE event_start_date >=  '".$txtFromDate."' OR event_year_around='1' ")) && (is_array($date_relation_array))){
				for($i = 0; $i < count($date_relation_array); $i++) {
					array_push($eventIdByFromToDateArr, "'".$date_relation_array[$i]['event_id']."'");
				}
            }
		} else if((isset($txtFromDate) && $txtFromDate !="") && !isset($txtFromDate)) {
			$dateParameter 		= true;
			$eventIdByFromToDateArr = array();
			if(($date_relation_array = $this->fun_findRelationInfo(TABLE_EVENTS , " WHERE (event_end_date >= '".$txtFromDate."' AND event_end_date >=  '".$txtToDate."') OR event_year_around='1' ")) && (is_array($date_relation_array))){
				for($i = 0; $i < count($date_relation_array); $i++) {
					array_push($eventIdByFromToDateArr, "'".$date_relation_array[$i]['event_id']."'");
				}
            }
		}
// OK
//print_r($eventIdByFromToDateArr);
		if((isset($txtEventCategory) && $txtEventCategory > 0)) {
			$categoryParameter 	= true;
			$eventIdByCategoryArr = array();
			if(($category_relation_array = $this->fun_findRelationInfo(TABLE_EVENTS , " WHERE (event_cat_ids LIKE '%,".$txtEventCategory."') OR (event_cat_ids LIKE '".$txtEventCategory.",%') OR (event_cat_ids LIKE '%,".$txtEventCategory.",%') OR (event_cat_ids = '".$txtEventCategory."')")) && (is_array($category_relation_array))){
				for($i = 0; $i < count($category_relation_array); $i++) {
					array_push($eventIdByCategoryArr, "'".$category_relation_array[$i]['event_id']."'");
				}
            }
        }
// OK
		if((isset($txtareaid) && $txtareaid !="" && $txtareaid !="0") && (!isset($txtregionid) || $txtregionid =="") && (!isset($txtsubregionid) || $txtsubregionid =="") && (!isset($txtlocationid) || $txtlocationid =="")) {
			$locationParameter 	= true;
			$eventIdByLocationArr 	= array();
            $sqlAreaEvnt		= "SELECT A.event_id AS event_id FROM " . TABLE_EVENTS . " AS A  WHERE A.event_area_id IN (".$txtareaid.") ";
            $rsAreaEvnt 		= $this->dbObj->createRecordset($sqlAreaEvnt);
            if($this->dbObj->getRecordCount($rsAreaEvnt) > 0) {
                $arrAreaEvnt = $this->dbObj->fetchAssoc($rsAreaEvnt);
                for($i = 0; $i < count($arrAreaEvnt); $i++) {
                    array_push( $eventIdByLocationArr, "'".$arrAreaEvnt[$i]['event_id']."'");
                }
            }
		} else if((isset($txtregionid) && $txtregionid !="" && $txtregionid !="0") && (!isset($txtsubregionid) || $txtsubregionid =="") && (!isset($txtlocationid) || $txtlocationid =="")) {
			$locationParameter 	= true;
			$eventIdByLocationArr 	= array();
            $sqlRegionEvnt		= "SELECT A.event_id AS event_id FROM " . TABLE_EVENTS . " AS A  WHERE A.event_region_id IN (".$txtregionid.") ";
            $rsRegionEvnt 		= $this->dbObj->createRecordset($sqlRegionEvnt);
            if($this->dbObj->getRecordCount($rsRegionEvnt) > 0) {
                $arrRegionEvnt = $this->dbObj->fetchAssoc($rsRegionEvnt);
                for($i = 0; $i < count($arrRegionEvnt); $i++) {
                    array_push( $eventIdByLocationArr, "'".$arrRegionEvnt[$i]['event_id']."'");
                }
            }
        } else if((isset($txtsubregionid) && $txtsubregionid !="" && $txtsubregionid !="0") && (!isset($txtlocationid) || $txtlocationid =="")) {
			$locationParameter 	= true;
			$eventIdByLocationArr 	= array();
            $sqlSubRegionEvnt		= "SELECT A.event_id AS event_id FROM " . TABLE_EVENTS . " AS A  WHERE A.event_sub_region_id IN (".$txtsubregionid.") ";
            $rsSubRegionEvnt 		= $this->dbObj->createRecordset($sqlSubRegionEvnt);
            if($this->dbObj->getRecordCount($rsSubRegionEvnt) > 0) {
                $arrSubRegionEvnt = $this->dbObj->fetchAssoc($rsSubRegionEvnt);
                for($i = 0; $i < count($arrSubRegionEvnt); $i++) {
                    array_push( $eventIdByLocationArr, "'".$arrSubRegionEvnt[$i]['event_id']."'");
                }
            }
        } else if((isset($txtlocationid) && $txtlocationid !="" && $txtlocationid !="0")) {
			$locationParameter 	= true;
			$eventIdByLocationArr 	= array();
            $sqlLocationEvnt		= "SELECT A.event_id AS event_id FROM " . TABLE_EVENTS . " AS A  WHERE A.event_location_id IN (".$txtlocationid.") ";
            $rsLocationEvnt 		= $this->dbObj->createRecordset($sqlLocationEvnt);
            if($this->dbObj->getRecordCount($rsLocationEvnt) > 0) {
                $arrLocationEvnt = $this->dbObj->fetchAssoc($rsLocationEvnt);
                for($i = 0; $i < count($arrLocationEvnt); $i++) {
                    array_push( $eventIdByLocationArr, "'".$arrLocationEvnt[$i]['event_id']."'");
                }
            }
        }
// OK
//print_r($eventIdByFromToDateArr);

		if(is_array($eventIdArr) && count($eventIdArr) > 0) {
			if($locationParameter == true) {
				$eventIdArr = array_intersect($eventIdArr, $eventIdByLocationArr);
			}
			if($dateParameter == true) {
				$eventIdArr = array_intersect($eventIdArr, $eventIdByFromToDateArr);
			}
			if($categoryParameter == true) {
				$eventIdArr = array_intersect($eventIdArr, $eventIdByCategoryArr);
			}
		}

// OK
//print_r($eventIdArr);

		if(count($eventIdArr) > 0) {
			$event_ids = implode(",", array_keys(array_flip($eventIdArr)));
		}

// OK
//echo $event_ids;
		if(isset($event_ids) && $event_ids !="") {
			$sql = "SELECT A.event_id, A.event_cat_ids, A.event_code, A.event_name, A.event_description, A.event_year_around, A.event_start_date, A.event_end_date FROM " . TABLE_EVENTS . " AS A WHERE A.active='1' AND A.event_id IN (".$event_ids.")";

			if($strQueryParameter != ""){
				$sql .= $strQueryParameter;
			} else {
				$sql .= " ORDER BY A.event_year_around DESC";
			}
//echo $sql;
			return $rs = $this->dbObj->createRecordset($sql);
		} else {
			return false;
		}
	}


	function fun_getEventsFeatureArr($limit = '') {
		if($limit !="") {
			$strQuery = "LIMIT 0, ".$limit ;
		} else {
			$strQuery = "LIMIT 0, 5";
		}
		$sqlFeatureEvnt		= "SELECT A.event_id, A.event_cat_ids, A.event_code, A.event_name, A.event_year_around, A.event_start_date, A.event_end_date, A.event_thumb, A.event_img_caption, A.event_img_by, A.event_img_link FROM " . TABLE_EVENTS . " AS A WHERE A.status ='2' AND A.featured ='1' AND A.active ='1' ORDER BY RAND() ".$strQuery;
		$rsFeatureEvnt 		= $this->dbObj->createRecordset($sqlFeatureEvnt);
		if($this->dbObj->getRecordCount($rsFeatureEvnt) > 0) {
			$arrFeatureEvnt = $this->dbObj->fetchAssoc($rsFeatureEvnt);
			return $arrFeatureEvnt;
		} else {
			return false;
		}
	}

	// Function for new user array
	function fun_getPendingApprovalEventsArr($parameter=''){
		$sql = "SELECT 	A.event_id, 
						A.event_cat_ids,
						A.event_code,
						A.event_name,
						A.status,
						A.event_year_around,
						A.event_start_date,
						A.event_end_date,
						B.status_name,
						A.featured, 
						A.active
				FROM " . TABLE_EVENTS . " AS A
				INNER JOIN " . TABLE_EVENTS_STATUS . " AS B ON A.status = B.status_id 
				  ";

		if($parameter!=""){
			$sql .= $parameter;
		} else {
			$sql .= " ORDER BY A.event_code";		
		}
		
//	echo $sql;
		
		$rs = $this->dbObj->createRecordset($sql);
        return $arr = $this->dbObj->fetchAssoc($rs);
	}

	// Function for count live events
	function fun_countLiveEvents(){
        $sql 	= "SELECT A.event_id FROM " . TABLE_EVENTS . " AS A WHERE A.active ='1' AND A.status ='2'";
        $rs 	= $this->dbObj->createRecordset($sql);
        return $this->dbObj->getRecordCount($rs);
	}

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