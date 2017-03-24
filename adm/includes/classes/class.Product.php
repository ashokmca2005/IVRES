<?php
class Product {
	var $dbObj;
	function Product(){ // class constructor
		$this->dbObj = new DB();
		$this->dbObj->fun_db_connect();
	}
	
	// This function will Return Product information in array with front end data	
	function fun_getProductInfo($products_id){
		$sql 	= "SELECT * FROM " . TABLE_PRODUCTS . " WHERE products_id='".$products_id."'";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr 	= $this->dbObj->fetchAssoc($rs);
			return $arr[0];
		} else {
			return false;
		}
	}

	// This function will Return Product price
	function fun_getProductPrice($products_id){
		return $this->dbObj->getField(TABLE_PRODUCTS, "products_id", $products_id, "products_price");
	}

	// This function will Return Product information in array with front end data	
	function fun_getProductRateInfoArr(){
		$sql 	= "SELECT * FROM " . TABLE_PRODUCTS . " WHERE products_id IN (6,12,8,3,1,5) ORDER BY products_id";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr 	= $this->dbObj->fetchAssoc($rs);
			return $arr;
		} else {
			return false;
		}
	}

	// This function will Return Product information in array with front end data	
	function fun_getPackageInfoArr(){
		$sql 	= "SELECT A.*, B.products_price FROM " . TABLE_PACKAGES . " AS A 
		INNER JOIN " . TABLE_PRODUCTS . " AS B ON B.products_id = A.products_id 
		WHERE A.active='1' ";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr 	= $this->dbObj->fetchAssoc($rs);
			return $arr;
		} else {
			return false;
		}
	}

	function fun_getPackageIdByProductId($products_id) {
		$package_id = $this->dbObj->getField(TABLE_PACKAGES, "products_id", $products_id, "package_id");
		return $package_id;
	}

	// This function will Return Product price history information in array
	function fun_getProductRateScheduleInfoArr($schedule_on = ''){
		if($schedule_on == '') {
			return false;
		} else {
			$sql 	= "SELECT A.product_id, A.product_price, B.products_name
			FROM " . TABLE_PRODUCTS_PRICE_HISTORY . " AS A
			INNER JOIN " . TABLE_PRODUCTS . " AS B ON A.product_id = B.products_id
			WHERE B.products_id IN (6,8,3,1,5) AND A.status = '0' AND A.schedule_on = '".$schedule_on."' ORDER BY B.products_id";
			$rs 	= $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr 	= $this->dbObj->fetchAssoc($rs);
				return $arr;
			} else {
				return false;
			}
		}
	}

	// This function will Return Product price history information in array
	function fun_getProductRateHistoryInfoArr(){
		$sql 	= "SELECT A.product_id, A.product_price, A.schedule_on, B.products_name, CONCAT(C.user_fname, ' ', C.user_lname) AS user_name
		FROM " . TABLE_PRODUCTS_PRICE_HISTORY . " AS A
		INNER JOIN " . TABLE_PRODUCTS . " AS B ON A.product_id = B.products_id
		INNER JOIN " . TABLE_USERS . " AS C ON C.user_id = A.created_by
		WHERE B.products_id IN (6,8,3,1,5) AND A.status = '1' ORDER BY A.schedule_on";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr 	= $this->dbObj->fetchAssoc($rs);
			return $arr;
		} else {
			return false;
		}
	}

	// Function for edit product rate
	function fun_editProductsRate($productRateArr) {
		if(!is_array($productRateArr)) {
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

			foreach($productRateArr as $keys => $values) {
				$products_id 	= $keys;
				$products_price = $values;
				$sqlUpdate 		= "UPDATE " . TABLE_PRODUCTS . " SET products_price = '".$values."', updated_on = '".$cur_unixtime."', updated_by = '".$cur_user_id."' WHERE products_id='".$products_id."'";
				$this->dbObj->mySqlSafeQuery($sqlUpdate);
			}
            return true;
		}
	}

	// Function for edit product rate
	function fun_editPackageCredit($packageArr) {
		if(!is_array($packageArr)) {
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

			foreach($packageArr as $keys => $values) {
				$package_id = $keys;
				$credits 	= $values;
				$sqlUpdate 		= "UPDATE " . TABLE_PACKAGES . " SET credits = '".$credits."', updated_on = '".$cur_unixtime."', updated_by = '".$cur_user_id."' WHERE package_id='".$package_id."'";
				$this->dbObj->mySqlSafeQuery($sqlUpdate);
			}
            return true;
		}
	}

	// Function for schedule product rate
	function fun_scheduleProductsRate($productRateArr, $schedule_on = '') {
		if(!is_array($productRateArr) || $schedule_on == '') {
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

			$status = "0";
			foreach($productRateArr as $keys => $values) {
				$product_id 	= $keys;
				$product_price = $values;
				$strInsQuery = "INSERT INTO " . TABLE_PRODUCTS_PRICE_HISTORY . " 
				(product_price_id, product_id, product_price, schedule_on, created_on, created_by, status) 
				VALUES(null, '".$product_id."', '".$product_price."', '".$schedule_on."', '".$cur_unixtime."', '".$cur_user_id."', '".$status."')";
				$this->dbObj->mySqlSafeQuery($strInsQuery);
			}
            return true;
		}
	}

	// Function for creating promos category checkbox section
	function fun_createSchedulePriceChange() {
		$cur_unixtime 	= time ();
		$sql 		= "SELECT A.*, CONCAT(B.user_fname, ' ', B.user_lname) AS user_name
		FROM " . TABLE_PRODUCTS_PRICE_HISTORY . " AS A 
		INNER JOIN " . TABLE_USERS . " AS B ON B.user_id = A.created_by
		WHERE A.schedule_on > ".$cur_unixtime." AND A.status = '0' ORDER BY A.schedule_on DESC LIMIT 0, 1";
		$rs 		= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr 			= $this->dbObj->fetchAssoc($rs);
			$schedule_on 	= date('M d, Y - h:i', $arr[0]['schedule_on']);
			$created_by 	= ucwords($arr[0]['user_name']);
			$strSchedule	= $schedule_on." by ".$created_by;
			$strHTML 	= "";
			$strHTML 	.= "\n<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
			$strHTML 	.= "<tr><td class=\"blackTxt14 pad-btm5\">Scheduled price change</td></tr>\n";
			$strHTML 	.= "<tr>\n";
			$strHTML 	.= "<td>\n";
			$strHTML 	.= "<div class=\"FloatLft\">".$strSchedule."</div>\n";
			$strHTML 	.= "<div class=\"FloatLft pad-lft10\"><a href=\"javascript: showNextSchedule('".$arr[0]['schedule_on']."');\" class=\"blue-link\">view </a>| <a href=\"javascript: sbmtScheduleDelete();\" class=\"blue-link\">delete</a></div>\n";
			$strHTML 	.= "</td>\n";
			$strHTML 	.= "</tr>\n";
			$strHTML 	.= "</table>\n";
			echo $strHTML;
		} else {
			return false;
		}
	}

	// This function will delete shedule
	function fun_delScheduledChangeRate(){
		$strQuery = "DELETE FROM " . TABLE_PRODUCTS_PRICE_HISTORY . " WHERE status = '0'";
		$this->dbObj->mySqlSafeQuery($strQuery);
		return true;
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