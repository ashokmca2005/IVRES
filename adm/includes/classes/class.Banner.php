<?php
class Banner{
	var $dbObj;
	
	function Banner(){//class constructor
		$this->dbObj = new DB();
		$this->dbObj->fun_db_connect();
	}
	
	// Get Banner info array by id
	function fun_getBannerInfo($banner_id){
		$sql 	= "SELECT * FROM " . TABLE_BANNER . " WHERE banner_id='".$banner_id."'";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr 	= $this->dbObj->fetchAssoc($rs);
			return $arr[0];
		} else {
			return false;
		}
	}

	// Get Banners array order by id
	function fun_getBannerArr($parameter = ''){		
		$sql 	= "SELECT A.* FROM " . TABLE_BANNER . " AS A";
		if($parameter != ""){
			$sql .= $parameter;
		} else {
			$sql .= " ORDER BY A.banner_id DESC";		
		}
		return $rs = $this->dbObj->createRecordset($sql);
	}

	// Get Banners array order by id
	function fun_getBannerArr4Home($parameter = ''){
		$sql = "SELECT * FROM " . TABLE_BANNER . " ";
		if($parameter != ""){
			$sql .= $parameter;
		} else {
			$sql .= " ORDER BY RAND() ";
		}
		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			return $arr = $this->dbObj->fetchAssoc($rs);		
		} else {
			return false;
		}
	}

	// Get Banner ifo array order by random
	function fun_getBannerRandom($banner_type = ''){		
		$sql 		= "SELECT * FROM " . TABLE_BANNER . " ";
		if($banner_type != "") {
			$sql 	.= " WHERE banner_type ='".$banner_type."' ";
		}
		$sql 		.= " ORDER BY RAND() LIMIT 0, 1";

		$rs 		= $this->dbObj->createRecordset($sql);
		$arr 		= $this->dbObj->fetchAssoc($rs);
		return $arr[0];
	}

	// Function for add Banner
	function fun_addBanner($banner_title, $banner_desc, $banner_img, $banner_link, $banner_type, $start_date, $end_date, $active) {
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
		
		$strInsQuery = "INSERT INTO " . TABLE_BANNER . " 
		(banner_id, banner_title, banner_desc, banner_img, banner_link, banner_type, start_date, end_date, created_on, created_by, updated_on, updated_by, active) 
		VALUES(null, '".fun_db_input($banner_title)."', '".fun_db_input($banner_desc)."', '".$banner_img."', '".$banner_link."', '".$banner_type."', '".$start_date."', '".$end_date."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."', '".$active."')";
		$this->dbObj->fun_db_query($strInsQuery);
		return $this->dbObj->getIdentity();
	}

	// Function for edit banner
	function fun_editBanner($banner_id, $banner_title ='', $banner_desc ='', $banner_img ='', $banner_link ='', $banner_type ='', $start_date ='', $end_date ='', $active ='') {
		if($banner_id == '') {
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
			
            $sqlUpdateQuery = "UPDATE " . TABLE_BANNER . " SET 
            banner_title = '".fun_db_input($banner_title)."',
            banner_desc = '".fun_db_input($banner_desc)."',
            banner_img = '".$banner_img."',
            banner_link = '".$banner_link."',
            banner_type = '".$banner_type."',
            start_date = '".$start_date."',
            end_date = '".$end_date."',
            updated_on = '".$cur_unixtime."', 
            updated_by = '".$cur_user_id."',
            active = '".$active."'
            WHERE banner_id='".$banner_id."'";
            $this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
            return true;
		}
	}
	
	function fun_delBanner($banner_id){
		$delSql = "DELETE FROM " . TABLE_BANNER . " WHERE banner_id='".$banner_id."'";
		$this->dbObj->mySqlSafeQuery($delSql);
	}
}
?>