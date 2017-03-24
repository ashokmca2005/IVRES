<?php
class Seo{
	var $dbObj;
	
	function Seo(){ // class constructor
		$this->dbObj = new DB();
		$this->dbObj->fun_db_connect();
	}

	// This function will Return seo info in array
	function fun_getSeoInfo($seo_id){		
		$infoArray 		= array();
		$sql 			= "SELECT * FROM " . TABLE_APP_SEO . " AS A WHERE A.seo_id='".$seo_id."'";
		$result 		= $this->dbObj->fun_db_query($sql);
		if($this->dbObj->fun_db_get_num_rows($result) > 0){
			$rowsArray = $this->dbObj->fun_db_fetch_rs_object($result);
			$infoArray['seo_id'] 			= fun_db_output($rowsArray->seo_id);
			$infoArray['seo_url'] 			= fun_db_output($rowsArray->seo_url);
			$infoArray['seo_title'] 		= fun_db_output($rowsArray->seo_title);
			$infoArray['seo_keywords'] 		= fun_db_output($rowsArray->seo_keywords);
			$infoArray['seo_description'] 	= fun_db_output($rowsArray->seo_description);
			$infoArray['created_on'] 		= fun_db_output($rowsArray->created_on);
			$infoArray['created_by'] 		= fun_db_output($rowsArray->created_by);
			$infoArray['updated_on'] 		= fun_db_output($rowsArray->updated_on);
			$infoArray['updated_by'] 		= fun_db_output($rowsArray->updated_by);
			$infoArray['active'] 			= fun_db_output($rowsArray->active);
		}
		$this->dbObj->fun_db_free_resultset($result);
		return $infoArray;
	}

	// This function will Return seo front-end info in array
	function fun_getSeoInfoByURI($seo_url){
		$infoArray 		= array();
		$sql 			= "SELECT * FROM " . TABLE_APP_SEO . " AS A WHERE A.seo_url LIKE '%".$seo_url."' AND A.active='1' ";
		$result 		= $this->dbObj->fun_db_query($sql);
		if($this->dbObj->fun_db_get_num_rows($result) > 0){
			$rowsArray = $this->dbObj->fun_db_fetch_rs_object($result);
			$infoArray['seo_id'] 			= fun_db_output($rowsArray->seo_id);
			$infoArray['seo_url'] 			= fun_db_output($rowsArray->seo_url);
			$infoArray['seo_title'] 		= fun_db_output($rowsArray->seo_title);
			$infoArray['seo_keywords'] 		= fun_db_output($rowsArray->seo_keywords);
			$infoArray['seo_description'] 	= fun_db_output($rowsArray->seo_description);
		}
		$this->dbObj->fun_db_free_resultset($result);
		return $infoArray;
	}

	// Function for user inbox array
	function fun_getSEOArr($parameter = ''){
		$sql = "SELECT A.seo_id, 
				A.seo_url,
				A.seo_title,
				A.updated_on,
				A.active
		FROM " . TABLE_APP_SEO . " AS A ";
		if($parameter != ""){
			$sql .= " ".$parameter;		
		} else {
			$sql .= "ORDER BY A.seo_id";		
		}

		$rs = $this->dbObj->createRecordset($sql);
		return $arr = $this->dbObj->fetchAssoc($rs);		
	}

	// Function for SEO Add
	function fun_addSeo($seo_url, $seo_title, $seo_keywords, $seo_description) {
		if($seo_url == '' ||  $seo_title == '' ||  $seo_keywords == '' ||  $seo_description == '') {
			return false;
		} else {
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
			$active = "1";
			
			$strInsQuery = "INSERT INTO " . TABLE_APP_SEO . " (seo_id, seo_url, seo_title, seo_keywords, seo_description, created_on, created_by, updated_on, updated_by, active) 
			VALUES(null, '".$seo_url."', '".$seo_title."', '".$seo_keywords."', '".$seo_description."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."', '".$active."')";
			$this->dbObj->fun_db_query($strInsQuery);
			return $this->dbObj->getIdentity();
		}
	}

	// Function for SEO Edit
	function fun_editSeo($seo_id, $seo_url, $seo_title, $seo_keywords, $seo_description) {
		if($seo_id == '' || $seo_url == '' || $seo_title == '' || $seo_keywords == '' || $seo_description == '') {
			return false;
		} else {
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
			$active = "1";
			
			$sqlUpdateQuery = "UPDATE " . TABLE_APP_SEO . " SET seo_url = '".$seo_url."', seo_title = '".$seo_title."', seo_keywords = '".$seo_keywords."', seo_description = '".$seo_description."', updated_on = '".$cur_unixtime."', updated_by = '".$cur_user_id."' WHERE seo_id='".$seo_id."'";
			$this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
		}
	}

	function fun_delSeo($seo_id){
		// Delete from TABLE_APP_SEO
		$strDelQuery = "DELETE FROM " . TABLE_APP_SEO . " WHERE seo_id='".$seo_id."'";
		$this->dbObj->mySqlSafeQuery($strDelQuery);
		return true;
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