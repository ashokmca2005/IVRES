<?php
class Currency {
	var $dbObj;
	function Currency(){ // class constructor
		$this->dbObj = new DB();
		$this->dbObj->fun_db_connect();
	}
	
	// This function will Return Currency information in array with front end data	
	function fun_getCurrencyInfo($currency_id){
		$sql 	= "SELECT * FROM " . TABLE_CURRENCIES . " WHERE currency_id='".$currency_id."'";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr 	= $this->dbObj->fetchAssoc($rs);
			return $arr[0];
		} else {
			return false;
		}
	}

	// This function will Return Currency information in array with front end data	
	function fun_getCurrencyValueByCode($currency_code){
		$sql 	= "SELECT currency_rate FROM " . TABLE_CURRENCIES . " WHERE currency_code='".$currency_code."'";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr 	= $this->dbObj->fetchAssoc($rs);
			return $arr[0]['currency_rate'];
		} else {
			return false;
		}
	}

	// This function will Return Currency information in array with front end data	
	function fun_getCurrencyRateInfoArr(){
		$sql 	= "SELECT * FROM " . TABLE_CURRENCIES . "";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr 	= $this->dbObj->fetchAssoc($rs);
			return $arr;
		} else {
			return false;
		}
	}

/*
	// Function for travel guide add
	function fun_addCurrency($promo_cat_ids, $promo_code, $promo_description = '', $promo_reduction = '', $promo_takeup = '', $promo_expiry_date = '') {
		if($promo_cat_ids == '' ||  $promo_code == '' ||  $promo_description == '') {
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
			$active = "1";
			$strInsQuery = "INSERT INTO " . TABLE_PROMOS . " 
			(promo_id, promo_cat_ids, promo_code, promo_description, promo_reduction, promo_takeup, promo_expiry_date, created_on, created_by, updated_on, updated_by, active) 
			VALUES(null, '".$promo_cat_ids."', '".$promo_code."', '".$promo_description."', '".$promo_reduction."', '".$promo_takeup."', '".$promo_expiry_date."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."', '".$active."')";
			$this->dbObj->fun_db_query($strInsQuery);
			return $this->dbObj->getIdentity();
		}
	}
*/
	// Function for currency add
	function fun_editCurrencyRate($usd, $gbp, $eur) {
		if($usd == '' || $gbp == '' || $eur == '') {
			return false;
		} else {
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
			$sqlUpdateQuery1 = "UPDATE " . TABLE_CURRENCIES . " SET currency_rate = '".$usd."', updated_on = '".$cur_unixtime."', updated_by = '".$cur_user_id."' WHERE currency_code='USD'";
			$sqlUpdateQuery2 = "UPDATE " . TABLE_CURRENCIES . " SET currency_rate = '".$gbp."', updated_on = '".$cur_unixtime."', updated_by = '".$cur_user_id."' WHERE currency_code='GBP'";
			$sqlUpdateQuery3 = "UPDATE " . TABLE_CURRENCIES . " SET currency_rate = '".$eur."', updated_on = '".$cur_unixtime."', updated_by = '".$cur_user_id."' WHERE currency_code='EUR'";
            $this->dbObj->mySqlSafeQuery($sqlUpdateQuery1);
            $this->dbObj->mySqlSafeQuery($sqlUpdateQuery2);
            $this->dbObj->mySqlSafeQuery($sqlUpdateQuery3);
            return true;
		}
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
}
?>