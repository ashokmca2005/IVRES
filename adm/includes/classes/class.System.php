<?php
class System{
	var $dbObj;
	
	function System(){//class constructor
		$this->dbObj = new DB();
		$this->dbObj->fun_db_connect();
	}
	
	function fun_getSiteVariableValue(){
		$sql 	= "SELECT * FROM " . TABLE_SITE_VARIABLE . " ";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			$arr 	= $this->dbObj->fetchAssoc($rs);
			foreach($arr as $keys => $vals) {
				$site_variable_id 		= $vals['site_variable_id'];
				$site_variable_value 	= $vals['site_variable_value'];
				$sysArr[$site_variable_id] = $site_variable_value;
			}
			return $sysArr;
		} else {
			return false;
		}
	}	

	// Function for Site variable array
	function fun_getSiteVariableArr($parameter){
        $sql 	= "SELECT A.* FROM " . TABLE_SITE_VARIABLE . " AS A ";
		if($parameter != ""){
			$sql .= $parameter;
		} else {
			$sql .= " ORDER BY A.site_variable_id";		
		}

		$rs 	= $this->dbObj->createRecordset($sql);
		$arr 	= $this->dbObj->fetchAssoc($rs);
		return $arr;
	}
	
	function fun_getSiteVariableInfo($site_variable_id){		
		$sql 	= "SELECT * FROM " . TABLE_SITE_VARIABLE . " WHERE site_variable_id='".$site_variable_id."'";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr 	= $this->dbObj->fetchAssoc($rs);
			return $arr[0];
		} else {
			return false;
		}
	}

	function fun_editSiteVariable($txtSiteVariableId, $txtValue){
        $field_names 			= array("site_variable_value");
        $field_values 			= array(fun_db_input($txtValue));
        $this->dbObj->updateFields(TABLE_SITE_VARIABLE, "site_variable_id", $txtSiteVariableId, $field_names, $field_values);
        return $site_variable_id;
	}

	function fun_getLangArr(){
		$sql 	= "SELECT * FROM " . TABLE_LANGUAGE . " ORDER BY id";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			return $arr = $this->dbObj->fetchAssoc($rs);
		} else {
			return false;
		}
	}

	function fun_getLangInfo($lang_code){
		$langArray 	= array();
		$sql 		= "SELECT * FROM " . TABLE_LANGUAGE . " WHERE lang_code='".fun_db_input($lang_code)."' ";
		$result 	= $this->dbObj->fun_db_query($sql);

		if($this->dbObj->fun_db_get_num_rows($result) > 0){
			$rowsArray 				= $this->dbObj->fun_db_fetch_rs_object($result);
			$langArray['id'] 			= fun_db_output($rowsArray->id);
			$langArray['lang_code'] 	= fun_db_output($rowsArray->lang_code);
			$langArray['name'] 			= fun_db_output($rowsArray->name);
			$langArray['display_status']= fun_db_output($rowsArray->display_status);
		}
		$this->dbObj->fun_db_free_resultset($result);
		return $langArray;
	}

	function fun_setLanguageDisplay($display_arr){
		$cur_unixtime 	= time ();
		$cur_user_id 	= $_SESSION['ses_user_id'];

		$sqlUpdate = "UPDATE " . TABLE_LANGUAGE . " SET display_status='0', updated_by='" . $cur_user_id . "', updated_on='" . $cur_unixtime . "' WHERE lang_code NOT IN ('en') ";
		$this->dbObj->mySqlSafeQuery($sqlUpdate);

		for($i=0; $i < count($display_arr); $i++) {
			$lang_code 	= $display_arr[$i];
			$sql 		= "UPDATE " . TABLE_LANGUAGE . " SET display_status='1', updated_by='" . $cur_user_id . "', updated_on='" . $cur_unixtime . "' WHERE lang_code='" . $lang_code . "' ";
			$this->dbObj->mySqlSafeQuery($sql);
		}
	}

	function fun_getDisplayLang() {
		$sql 	= "SELECT * FROM " . TABLE_LANGUAGE . " WHERE display_status='1' AND lang_code NOT IN ('en') ";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0)
			return 1;
		else
		return 0;
	}

	function fun_getDisplayLangArr() {
		$sql 	= "SELECT * FROM " . TABLE_LANGUAGE . " WHERE display_status='1' AND lang_code NOT IN ('en') ";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			$arr 	= $this->dbObj->fetchAssoc($rs);
			return $arr;
		} else {
			return 0;
		}
	}

	function fun_createSelectTranlation(){
		$sql 	= "SELECT * FROM " . TABLE_LANGUAGE . " WHERE display_status='1' ";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			$arr 	= $this->dbObj->fetchAssoc($rs);
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">';
			for($i=0; $i < count($arr); $i++) {
				$lang_code 	= $arr[$i]['lang_code'];
				$name 		= $arr[$i]['name'];

				echo '<tr>';
				echo '<td><a href="javascript:void(0);" onclick="setLang(\''.$lang_code.'\');"><img src="'.SITE_IMAGES.'flag/'.$lang_code.'.png" alt="'.$name.'"/>&nbsp;&nbsp;'.$name.'</a></td>';
				echo '</tr>';

			}
			echo '</table>';
		}   
	}


}
?>