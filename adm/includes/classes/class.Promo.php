<?php
class Promo {
	var $dbObj;
	function Promo(){ // class constructor
		$this->dbObj = new DB();
		$this->dbObj->fun_db_connect();
	}
	
	// This function will Return Promo information in array with front end data	
	function fun_getPromoInfo($promo_id){		
		$sql 	= "SELECT * FROM " . TABLE_PROMOS . " WHERE promo_id='".$promo_id."'";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr 	= $this->dbObj->fetchAssoc($rs);
			return $arr[0];
		} else {
			return false;
		}
	}

	// This function will Return Promo information in array with front end data	
	function fun_getPromoInfoByCode($promo_code){		
		$sql 	= "SELECT * FROM " . TABLE_PROMOS . " WHERE promo_code='".$promo_code."'";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr 	= $this->dbObj->fetchAssoc($rs);
			return $arr[0];
		} else {
			return false;
		}
	}

	// This function will Return Promo information in array with front end data	
	function fun_getPromoProductsArrByCatIds($promo_cat_ids){
		if($promo_cat_ids =="") {
			return false;
		} else {
			$sql 	= "SELECT product_id FROM " . TABLE_PROMOS_CATEGORY . " WHERE promo_cat_id IN (".$promo_cat_ids.")";
			$rs 	= $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr 	= $this->dbObj->fetchAssoc($rs);
				$productArr = array();
				for($i = 0; $i < count($arr); $i++) {
					$productArr[$i] = $arr[$i]['product_id'];
				}
				return $productArr;
			} else {
				return false;
			}
		}
	}

	// This function will Return Promo information in array with front end data	
	function fun_countPromoUserCode($promo_code, $user_id = '') {
		$sql 	= "SELECT promotion_code FROM " .TABLE_USER_PROMOTION_CODES. " WHERE promotion_code = '".$promo_code."' AND active = '1' ";
		if(isset($user_id) && $user_id != "") {
			$sql 	.= "AND user_id = '".$user_id."'";
		}
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			return $this->dbObj->getRecordCount($rs);
		} else {
			return "0";
		}
	}

	// This function will Return Promo information in array with front end data	
	function fun_getPromoCatInfo($promo_cat_id){		
		$sql 	= "SELECT * FROM " . TABLE_PROMOS_CATEGORY . " WHERE promo_cat_id='".$promo_cat_id."'";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr 	= $this->dbObj->fetchAssoc($rs);
			return $arr[0];
		} else {
			return false;
		}
	}

	function fun_getPromoCatNameByCatId($promo_cat_id) {
		if($promo_cat_id == '') {
			return false;
		} else {
			$sql = "SELECT promo_cat_name FROM " . TABLE_PROMOS_CATEGORY . " WHERE promo_cat_id= '".$promo_cat_id."'";
			$rs = $this->dbObj->createRecordset($sql);
			$arr = $this->dbObj->fetchAssoc($rs);
			if(is_array($arr) && count($arr) > 0) {
				return ucfirst($arr[0]['promo_cat_name']);
			} else {
				return false;
			}
		}
	}

	// Function for creating promos category checkbox section
	function fun_createPromosCategoryCheckbox($promo_id = '') {
		$sqlPromoIds 	= "SELECT promo_cat_ids FROM " . TABLE_PROMOS . " WHERE promo_id='".$promo_id."'";
		$rsPromo 		= $this->dbObj->createRecordset($sqlPromoIds);
		$arrPromo 		= $this->dbObj->fetchAssoc($rsPromo);
		$promoArr 		= explode(",", $arrPromo[0]['promo_cat_ids']);

		$sql 		= "SELECT * FROM " . TABLE_PROMOS_CATEGORY . "  ORDER BY promo_cat_name";
		$strHTML 	= "";
		$strHTML 	.= "\n<table width=\"450\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"font12\"><tbody>\n";
		$strHTML 	.= "<tr><td width=\"20\">&nbsp;</td><td width=\"200\">&nbsp;</td><td width=\"20\">&nbsp;</td><td width=\"200\">&nbsp;</td>\n";
		$rs 		= $this->dbObj->createRecordset($sql);
		$arr 		= $this->dbObj->fetchAssoc($rs);
		$i 			= 0;
		foreach($arr as $value){
			if($i%2 == 0){
				$strHTML .= "</tr><tr>";
			}
			if(array_search($value['promo_cat_id'], $promoArr) === false){
				$checked = "";
			} else {
				$checked = "checked";
			}
			$strHTML .= "<td align=\"left\" valign=\"top\" style=\"padding-bottom:10px;\"><input type=\"checkbox\" name='txtPromo[]' id='txtPromo".$i."' value='". $value['promo_cat_id'] ."' class=\"RegFormChkBox\" " .$checked. "></td>";
			$strHTML .= "<td align=\"left\" valign=\"top\" style=\"padding-bottom:10px;\"> " .ucwords($value['promo_cat_name']). " </td>";
			$i++;
		}
		$strHTML 	.= "<tr><td colspan=\"4\"><span class=\"pdError1\" id=\"txtPromoCategoryErrorId\"></span></td>\n";
		$strHTML .= "</tbody></table>";
		echo $strHTML;
	}


	function fun_getPromoCatNameByCatIdsWithNL($promo_cat_ids) {
		if($promo_cat_ids == '') {
			return false;
		} else {
			$sql = "SELECT promo_cat_name FROM " . TABLE_PROMOS_CATEGORY . " WHERE promo_cat_id IN (".$promo_cat_ids.") ORDER BY promo_cat_name";
			$rs = $this->dbObj->createRecordset($sql);
			$arr = $this->dbObj->fetchAssoc($rs);
			if(is_array($arr) && count($arr) > 0) {
				$strPromoCategorieName = "";
				for($i = 0; $i < count($arr); $i++) {
					if($i == count($arr)-1) {
						$strPromoCategorieName .= ucfirst($arr[$i]['promo_cat_name']);
					} else {
						$strPromoCategorieName .= ucfirst($arr[$i]['promo_cat_name'])."<br />";
					}
				}
				return $strPromoCategorieName;
			} else {
				return false;
			}
		}
	}

	// Function for new user array
	function fun_getPendingApprovalPromosArr($parameter=''){
		$sql = "SELECT 	A.* FROM " . TABLE_PROMOS . " AS A";
		if($parameter!=""){
			$sql .= $parameter;
		} else {
			$sql .= " ORDER BY A.updated_on";		
		}
		$rs = $this->dbObj->createRecordset($sql);
        return $arr = $this->dbObj->fetchAssoc($rs);
	}

	// Function for travel guide add
	function fun_addPromo($promo_cat_ids, $promo_code, $promo_description = '', $promo_reduction = '', $promo_reduction_type = '', $promo_takeup = '', $promo_start_date = '', $promo_end_date = '') {
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
			if($promo_takeup == "0" || $promo_takeup == "") {
				$promo_by_quantity = "0";
			} else {
				$promo_by_quantity = "1";
			}
			$strInsQuery = "INSERT INTO " . TABLE_PROMOS . " 
			(promo_id, promo_cat_ids, promo_code, promo_description, promo_reduction, promo_reduction_type, promo_takeup, promo_by_quantity, promo_start_date, promo_end_date, created_on, created_by, updated_on, updated_by, active) 
			VALUES(null, '".$promo_cat_ids."', '".$promo_code."', '".$promo_description."', '".$promo_reduction."', '".$promo_reduction_type."', '".$promo_takeup."', '".$promo_by_quantity."', '".$promo_start_date."', '".$promo_end_date."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."', '".$active."')";
			$this->dbObj->fun_db_query($strInsQuery);
			return $this->dbObj->getIdentity();
		}
	}

	// Function for travel guide add
	function fun_editPromo($promo_id, $promo_cat_ids, $promo_code, $promo_description = '', $promo_reduction = '', $promo_reduction_type = '', $promo_takeup = '', $promo_start_date = '', $promo_end_date = '') {
		if($promo_id == '') {
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

			$active = "1";
			if($promo_takeup == "0" || $promo_takeup == "") {
				$promo_by_quantity = "0";
			} else {
				$promo_by_quantity = "1";
			}

            $sqlUpdateQuery = "UPDATE " . TABLE_PROMOS . " SET 
            promo_cat_ids = '".$promo_cat_ids."',
            promo_code = '".$promo_code."',
            promo_description = '".$promo_description."',
            promo_reduction = '".$promo_reduction."',
            promo_reduction_type = '".$promo_reduction_type."',
            promo_takeup = '".$promo_takeup."',
            promo_by_quantity = '".$promo_by_quantity."',
            promo_start_date = '".$promo_start_date."',
            promo_end_date = '".$promo_end_date."',
            updated_on = '".$cur_unixtime."',
            updated_by = '".$cur_user_id."',
            active = '".$active."' WHERE promo_id='".$promo_id."'";
            $this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
            return true;
		}
	}

	// Function assign promo code to user
	function fun_addPromoUserTakeup($promo_code, $user_id, $order_id) {
		if($promo_code == '' || $user_id == '' || $order_id == '') {
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

			$active = "1";

			$strInsQuery = "INSERT INTO " . TABLE_USER_PROMOTION_CODES . " 
			(promotion_id, promotion_code, user_id, order_id, created_on, created_by, updated_on, updated_by, active) 
			VALUES(null, '".$promo_code."', '".$user_id."', '".$order_id."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."', '".$active."')";
			$this->dbObj->fun_db_query($strInsQuery);
            return true;
		}
	}

	// Function	for delete Promo
	function fun_delPromo($promo_id = ''){
		if($promo_id == ''){
			return false;
		} else {
			$strDelteQuery = "DELETE FROM " . TABLE_PROMOS . " WHERE promo_id='$promo_id'";
			$this->dbObj->mySqlSafeQuery($strDelteQuery);
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