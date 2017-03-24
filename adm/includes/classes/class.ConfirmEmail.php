<?php
class ConfirmEmail{	
	var $dbObj;
	
	function ConfirmEmail(){ // class constructor
		$this->dbObj = new DB();
		$this->dbObj->fun_db_connect();
	}
	
	function fun_activeUsersLink($uId){
		$val = 1;
		
		//QUERY FOR ACTIVATE users_activation_link 
		$sqlUpdate = "UPDATE " . TABLE_USERS . " SET user_activation_link = '".$val."' WHERE user_id='".$uId."' ";
		
		$this->dbObj->fun_db_query($sqlUpdate) or die("<font color='#ff0000' face='verdana' size='2'>Error: Unable to execute request!<br>Invalid Query On Users table.</font>");
		
		if($this->dbObj->fun_db_get_affected_rows() > 0){
			return true;
		}else{
			return false;
		}		
	}
}
?>