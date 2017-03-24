<?php
class Admins{
	var $dbObj;
	function Admins(){ // class constructor
		$this->dbObj = new DB();
		$this->dbObj->fun_db_connect();
	}
	
	function CheckAdminLogin(){
		if(!isset($_SESSION['ses_admin_id']) || $_SESSION['ses_admin_id'] == ""){
			$_SESSION['ses_admin_id'] 	= "";
			$_SESSION['ses_admin_fname']= "";
			$_SESSION['ses_admin_email']= "";
			$_SESSION['ses_admin_pass'] = "";
			header('Location: login.php');
		}
	}

	function fun_getAdminInfo($AdminID=0, $AdminLogin=''){
		$AdminArray = array();
		$sql = "SELECT * FROM " . TABLE_USERS . " WHERE ";
		if($AdminLogin!=""){
			$sql .= "user_login='".fun_db_input($AdminLogin)."' ";
		}else{
			$sql .= "user_id='".(int)fun_db_input($AdminID)."' ";
		}
		$result = $this->dbObj->fun_db_query($sql);
		if($this->dbObj->fun_db_get_num_rows($result) > 0){
			$rowsArray = $this->dbObj->fun_db_fetch_rs_object($result);
			$AdminArray['user_id'] 		= fun_db_output($rowsArray->user_id);
			$AdminArray['user_pass'] 	= fun_db_output($rowsArray->user_pass);
			$AdminArray['user_fname'] 	= fun_db_output($rowsArray->user_fname);
			$AdminArray['user_lname'] 	= fun_db_output($rowsArray->user_lname);
			$AdminArray['user_email'] 	= fun_db_output($rowsArray->user_email);
			$AdminArray['user_dob'] 	= fun_db_output($rowsArray->user_dob);
			$AdminArray['user_address1']= fun_db_output($rowsArray->user_address1);
			$AdminArray['user_address2']= fun_db_output($rowsArray->user_address2);
			$AdminArray['user_town'] 	= fun_db_output($rowsArray->user_town);
			$AdminArray['user_state'] 	= fun_db_output($rowsArray->user_state);
			$AdminArray['user_zip'] 	= fun_db_output($rowsArray->user_zip);
			$AdminArray['user_country'] = fun_db_output($rowsArray->user_country);
			$AdminArray['user_rcountry']= fun_db_output($rowsArray->user_rcountry);
			$AdminArray['user_status'] 	= fun_db_output($rowsArray->user_status);
			$AdminArray['user_ip'] 		= fun_db_output($rowsArray->user_ip);			
			$AdminArray['is_admin'] 	= fun_db_output($rowsArray->is_admin);
			$AdminArray['is_owner'] 	= fun_db_output($rowsArray->is_owner);
			$AdminArray['updated_on'] 	= fun_db_output($rowsArray->updated_on);
			$AdminArray['created_on'] 	= fun_db_output($rowsArray->created_on);
		}
		$this->dbObj->fun_db_free_resultset($result);
		return $AdminArray;
	}

	// function for update user password
	function fun_updateAdminPassword($strAdmin, $strNewPassword){
		$sqlUpdate = "UPDATE " . TABLE_USERS . " SET user_pass='".md5($strNewPassword)."' WHERE user_id='".(int)$strAdmin."'";
		if($this->dbObj->mySqlSafeQuery($sqlUpdate)){
			return true;		
		} else {
			return false;
		}

	}

	function fun_verifyAdmins($login, $pass){		
		$AdminsFound = false;
		$val = 1;
		$sqlCheck = "SELECT user_login FROM " . TABLE_USERS . " WHERE md5(user_login)='".md5(trim($login))."' ";
		$sqlCheck .= " AND user_pass='".md5($pass)."' AND user_activation_link='".$val."' AND user_activation_link='".$val."' AND user_status='".$val."'";		
		$rs 	= $this->dbObj->createRecordset($sqlCheck);
		if($this->dbObj->getRecordCount($rs) > 0){
			$AdminsFound = true;
		}
		return $AdminsFound;
	}


}
?>