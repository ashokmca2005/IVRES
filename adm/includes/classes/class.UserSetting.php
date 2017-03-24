<?php
class UserSetting{
	var $dbObj;
	
	function UserSetting(){ // class constructor
		$this->dbObj = new DB();
		$this->dbObj->fun_db_connect();
	} 
	
	function fun_getUserSettingInfo($userID=''){
		$userSettingArray = array();
		$sql = "SELECT A.*, B.setting_name
		FROM " . TABLE_USER_SETTING_RELATIONS . " AS A 
		INNER JOIN " . TABLE_USER_SETTINGS . " AS B ON B.setting_id = A.setting_id
		WHERE A.user_id='".(int)fun_db_input($userID)."'";

		$result = $this->dbObj->fun_db_query($sql);
		if($this->dbObj->fun_db_get_num_rows($result) > 0){
			$i=0;
			while($rowsArray = $this->dbObj->fun_db_fetch_rs_object($result)){
				$userSettingArray[$i]['user_id'] = fun_db_output($rowsArray->user_id);
				$userSettingArray[$i]['setting_id'] = fun_db_output($rowsArray->setting_id);
				$userSettingArray[$i]['setting_name'] = fun_db_output($rowsArray->setting_name);
				$i++;
			}
		}
		$this->dbObj->fun_db_free_resultset($result);
		return $userSettingArray;
	}

	function fun_getUserSettingList($where = ''){
		$userSettingListArray = array();
		$sql = "SELECT A.* FROM  " . TABLE_USER_SETTINGS . " AS A WHERE A.active='1'";
		if($where != "")
		{
			$sql .= " AND ".join($where, " AND ");
		}

		$result = $this->dbObj->fun_db_query($sql);
		if($this->dbObj->fun_db_get_num_rows($result) > 0){
			$i=0;
			while($rowsArray = $this->dbObj->fun_db_fetch_rs_object($result)){
				$userSettingListArray[$i]['setting_id'] = fun_db_output($rowsArray->setting_id);
				$userSettingListArray[$i]['setting_name'] = fun_db_output($rowsArray->setting_name);
				$i++;
			}
		}
		$this->dbObj->fun_db_free_resultset($result);
		return $userSettingListArray;
	}


	// Function to update user's settings
	function fun_getUserSettingUpdate($userId, $strSettingsArr = ''){
		if($userId == "" || $strSettingsArr == ""){
			return true;
		}
		else{
		// Step I : delete existing settings
			for($k = 0; $k < count($strSettingsArr); $k++){
				$setting_id = $strSettingsArr[$k];
				$strDelQuery = "DELETE FROM " . TABLE_USER_SETTING_RELATIONS . " WHERE `user_id` = '" . $userId . "' and `setting_id` = '" . $setting_id . "'";
				$this->dbObj->fun_db_query($strDelQuery);
			}
			// Step II : insert new settings
			reset($strSettingsArr);
			for($j = 0; $j < count($strSettingsArr); $j++){
				$setting_id = $strSettingsArr[$j];
				$strInsQuery = "INSERT INTO " . TABLE_USER_SETTING_RELATIONS . "(`user_id`, `setting_id`) VALUES ('" . $userId . "', '" . $setting_id . "')";
				$this->dbObj->fun_db_query($strInsQuery);
			}
		}
		return true;
	}

	// Function to update user's hear about settings
	function fun_getUserHearAboutUpdate($userId, $strSettingsHearAbout = ''){
		if($userId == "" || $strSettingsHearAbout == ""){
			return true;
		}
		else{
			$strDelQuery = "DELETE FROM " . TABLE_USER_HEARABOUTUS . " WHERE `user_id` = '" . $userId . "'";
			$this->dbObj->fun_db_query($strDelQuery);

//			$strSettingsHearAbout = $this->dbObj->escapeSql($strSettingsHearAbout);
			$strUpdateQuery = "INSERT INTO " . TABLE_USER_HEARABOUTUS . "(`hearabout_id`, `user_id`, `hearaboutus_txt`) VALUES (null, '" . $userId . "', '" . $strSettingsHearAbout . "')";
			$this->dbObj->fun_db_query($strUpdateQuery);
		}
		return true;
	}
}
?>