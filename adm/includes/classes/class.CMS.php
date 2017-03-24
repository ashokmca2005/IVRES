<?php
class Cms{
	var $dbObj;
	
	function Cms(){//class constructor
		$this->dbObj = new DB();
		$this->dbObj->fun_db_connect();
	}

	// This function will Return page information in array with front end data	

	function fun_getPageInfo($page_id){		
		$sql 	= "SELECT * FROM " . TABLE_CMS . " WHERE page_id='".$page_id."'";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr 	= $this->dbObj->fetchAssoc($rs);
			return $arr[0];
		} else {
			return false;
		}
	}

	function fun_delPages($page_id){
		// Delete from TABLE_CMS
		$strDelQuery = "DELETE FROM " . TABLE_CMS . " WHERE page_id='".$page_id."'";
		$this->dbObj->mySqlSafeQuery($strDelQuery);
		return true;
	}
	function fun_getPageInfoById($id){
		$sql       = "SELECT * FROM " . TABLE_CMS . " WHERE page_id='".$id."'";
		$result    = $this->dbObj->fun_db_query($sql) or die(mysql_error());
		$resultSet = $this->dbObj->fun_db_fetch_rs_array($result);
		return $resultSet;
	}

	function fun_updatePage($pageArr){
		$time   = time();
		$sql    = "UPDATE " . TABLE_CMS . " SET page_title='".addslashes($pageArr['txtPageTitle'])."', page_discription='".addslashes($pageArr['txtPageDescription'])."', updated_on='".$time."' WHERE md5(page_id)='".$pageArr['pageId']."'";
		$result = $this->dbObj->fun_db_query($sql) or die(mysql_error()); 
	}

	function fun_getPageInfoByName($page_title){
		$sql       	= "SELECT * FROM " . TABLE_CMS . " WHERE LOWER(page_title)='".strtolower(trim($page_title))."'";
		$rs 		= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr 	= $this->dbObj->fetchAssoc($rs);
			return $arr[0];
		} else {
			return false;
		}
	}

	// Function for page Arrary list
	function fun_getPageArr($parameter = ''){
		$sql 	= "SELECT * FROM " . TABLE_CMS . " AS A ";
		if($parameter != ""){
			$sql .= $parameter;
		} else {
			$sql .= " ORDER BY A.updated_on DESC";		
		}
		return $rs = $this->dbObj->createRecordset($sql);
	}

	// Function for edit page 
	function fun_addPage($page_title, $page_content_title, $page_discription, $page_seo_title, $page_seo_keyword, $page_seo_discription, $page_type) {
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
		$active = 1;
		
		$strInsQuery = "INSERT INTO " . TABLE_CMS . " 
		(page_id, page_title, page_content_title, page_discription, page_seo_title, page_seo_keyword, page_seo_discription, page_type, created_on, created_by, updated_on, updated_by, active) 
		VALUES(null, '".fun_db_input($page_title)."', '".fun_db_input($page_content_title)."', '".fun_db_input($page_discription)."', '".fun_db_input($page_seo_title)."', '".fun_db_input($page_seo_keyword)."', '".fun_db_input($page_seo_discription)."', '".$page_type."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."', '".$active."')";
		$this->dbObj->fun_db_query($strInsQuery);
		return $this->dbObj->getIdentity();
	}

	// Function for edit page 
	function fun_editPage($page_id, $page_title ='', $page_content_title ='', $page_discription ='', $page_seo_title ='', $page_seo_keyword ='', $page_seo_discription ='', $page_type ='') {
		if($page_id == '') {
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
			$active = 1;
			
            $sqlUpdateQuery = "UPDATE " . TABLE_CMS . " SET 
            page_title = '".fun_db_input($page_title)."',
            page_content_title = '".fun_db_input($page_content_title)."',
            page_discription = '".fun_db_input($page_discription)."',
            page_seo_title = '".fun_db_input($page_seo_title)."',
            page_seo_keyword = '".fun_db_input($page_seo_keyword)."',
            page_seo_discription = '".fun_db_input($page_seo_discription)."',
            page_type = '".$page_type."',
            updated_on = '".$cur_unixtime."', 
            updated_by = '".$cur_user_id."'
            WHERE page_id='".$page_id."'";

            $this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
            return true;
		}
	}

	function fun_createRightMenu4Home(){		
		$strHTML 	= '';
		$arrRightLinks = array();
		$sql 	= "SELECT A.* FROM " . TABLE_CMS . " AS A WHERE A.active='1' AND A.page_type='1' ORDER BY page_id LIMIT 0,5";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			$arr 	= $this->dbObj->fetchAssoc($rs);
			foreach($arr as $value) {
				$page_title 	= $value['page_title'];
				array_push($arrRightLinks, $page_title);
			}
		}
		
		if(is_array($arrRightLinks) && count($arrRightLinks) >0) {
			$strHTML 	.= '<h3>'.ucwords(tranText('right_links')).'</h3><br />';
			$strHTML 	.= '<div class="nav1 pad-btm20 pad-lft10 font14">';
			$strHTML 	.= '<ul>';
			for($i=0; $i < count($arrRightLinks); $i++) {
				$title 	 = $arrRightLinks[$i];
				$link 	 = SITE_URL."pages/".str_replace("_", "/", str_replace(" ", "-", $title));
				$strHTML .= '<li><a href="'.$link.'">'.ucfirst($title).'</a></li>';
			}
			$strHTML 	.= '</li>';
			$strHTML 	.= '</div>';
		}
		echo $strHTML;
	}


	// This function will Return data in array
	function fun_findRelationInfo($table, $criteria){		
		$sql = "SELECT * FROM " .$table. " " .$criteria. "";
		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			return $arr = $this->dbObj->fetchAssoc($rs);		
		} else {
			return false;
		}
	}

	function fun_get_num_rows($sql){
		$totalRows 	= 0;
		$selected 	= "";
		$sql 		= trim($sql);
		if($sql==""){
			die("<font color='#ff0000' face='verdana' face='2'>Error: Query is Empty!</font>");
			exit;
		}
		$result 	= $this->dbObj->fun_db_query($sql);
		$totalRows 	= $this->dbObj->fun_db_get_num_rows($result);
		$this->dbObj->fun_db_free_resultset($result);
		return $totalRows;
	}	
}
?>