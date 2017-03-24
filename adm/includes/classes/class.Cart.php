<?php
class Cart{
	var $dbObj;
	
	function Cart(){ // class constructor
		$this->dbObj = new DB();
		$this->dbObj->fun_db_connect();
	}
	
	// This function will Return message information in array with front end data	
	function fun_getCartInfo($order_id){		
		$messageInfoArray 	= array();		
		$sql = "SELECT A.message_id, 
				A.message_type,
				A.message_subject,
				A.message_body,
				FROM_UNIXTIME(A.message_created_on, '%m/%d/%Y') AS message_created_on,
				B.user_fname,
				B.user_lname,
				C.messages_type_name
		FROM " . TABLE_USER_MESSAGES . " AS A 
		INNER JOIN " . TABLE_USERS . " AS B ON A.message_sender_id = B.user_id 
		INNER JOIN " . TABLE_USER_MESSAGE_TYPE . " AS C ON A.message_type = C.messages_type_id 
		WHERE A.message_id='".$message_id."'";

		$result = $this->dbObj->fun_db_query($sql);
		if($this->dbObj->fun_db_get_num_rows($result) > 0){
			$rowsArray = $this->dbObj->fun_db_fetch_rs_object($result);
			$messageInfoArray['message_id'] 		= fun_db_output($rowsArray->message_id);
			$messageInfoArray['message_type'] 		= fun_db_output($rowsArray->message_type);
			$messageInfoArray['message_subject'] 	= fun_db_output($rowsArray->message_subject);
			$messageInfoArray['message_body'] 		= fun_db_output($rowsArray->message_body);
			$messageInfoArray['message_created_on'] = fun_db_output($rowsArray->message_created_on);
			$messageInfoArray['user_fname'] 		= fun_db_output($rowsArray->user_fname);
			$messageInfoArray['user_lname'] 		= fun_db_output($rowsArray->user_lname);
		}
		$this->dbObj->fun_db_free_resultset($result);
		return $messageInfoArray;
	}

	// Function for user inbox array
	function fun_getUserCartArr($user_id, $extra_parameter=''){
		$sql = "SELECT A.message_id, 
				A.message_type,
				A.message_subject,
				FROM_UNIXTIME(A.message_created_on, '%m/%d/%Y') AS message_created_on,
				A.message_subject,
				A.message_reciever_rflag,
				A.message_reciever_dflag,
				B.user_fname,
				B.user_lname,
				C.messages_type_name
		FROM " . TABLE_USER_MESSAGES . " AS A  
		INNER JOIN " . TABLE_USERS . " AS B ON A.message_sender_id = B.user_id 
		INNER JOIN " . TABLE_USER_MESSAGE_TYPE . " AS C ON A.message_type = C.messages_type_id 
		WHERE A.message_reciever_id='".$user_id."' ";
		if($extra_parameter != ""){
			$sql .= " ".$extra_parameter;		
		}
		else{
			$sql .= "ORDER BY A.message_created_on";		
		}

		$rs = $this->dbObj->createRecordset($sql);
		return $arr = $this->dbObj->fetchAssoc($rs);		
	}

	// Function for user inbox array
	function fun_getOwnerProductsArr($product_id='', $extra_parameter = ''){
		$sql = "SELECT A.products_id, 
				A.products_image,
				A.products_name,
				A.products_summary,
				A.products_description,
				A.products_price,
				FROM_UNIXTIME(A.products_created_on, '%m/%d/%Y') AS products_created_on,
				FROM_UNIXTIME(A.products_modified_on, '%m/%d/%Y') AS products_modified_on,
				A.products_status
		FROM " . TABLE_PRODUCTS . " AS A  ";
/*
		$sql = "INNER JOIN " . TABLE_USERS . " AS B ON A.message_sender_id = B.user_id ";
		$sql = "INNER JOIN " . TABLE_USER_MESSAGE_TYPE . " AS C ON A.message_type = C.messages_type_id ";
*/
		$sql .= "WHERE A.products_status='1' ";


		if($product_id != ""){
			$sql .= " AND products_id='".$product_id."' ";
		} else {
			$sql .= "ORDER BY A.products_id";		
		}

		if($extra_parameter != ""){
			$sql .= " ".$extra_parameter;		
		} else {
			$sql .= "ORDER BY A.products_id";		
		}

		$rs = $this->dbObj->createRecordset($sql);
		return $arr = $this->dbObj->fetchAssoc($rs);		
	}

	// Function for user cart items array
	function fun_getOwnerCartItemsArr($user_id, $extra_parameter =''){
		$sql = "SELECT A.user_basket_id, 
				A.user_id,
				A.products_id,
				A.property_id,
				A.user_basket_quantity,
				A.final_price,
				FROM_UNIXTIME(A.user_basket_date_added, '%m/%d/%Y') AS user_basket_date_added,
				B.products_name,
				B.products_price
		FROM " . TABLE_USER_CART . " AS A  ";
		$sql .= "INNER JOIN " . TABLE_PRODUCTS . " AS B ON A.products_id = B.products_id ";

		$sql .= "WHERE A.user_id='".$user_id."' ";

		if($extra_parameter != ""){
			$sql .= " ".$extra_parameter;		
		} else {
			$sql .= " ORDER BY A.user_basket_date_added";		
		}

		$rs = $this->dbObj->createRecordset($sql);
		return $arr = $this->dbObj->fetchAssoc($rs);		
	}

	// Function for find user products payment status against a property
	function fun_getOwnerPaymentSatusName($user_id, $products_id, $property_id){
		$sql = "SELECT A.user_id,
				A.products_id,
				A.property_id,
				A.payment_status,
				B.payment_status_name
		FROM " . TABLE_USER_CART . " AS A  ";
		$sql .= "INNER JOIN " . TABLE_PAYMENT_STATUS . " AS B ON A.payment_status = B.payment_status_id ";
		$sql .= "WHERE A.user_id='".$user_id."' AND A.products_id='".$products_id."' AND A.property_id='".$property_id."'";
		$rs = $this->dbObj->createRecordset($sql);
		return $arr = $this->dbObj->fetchAssoc($rs);		
	}

	// Function for find user products payment status against a property
	function fun_getOwnerPaymentSatusId($user_id, $products_id, $property_id){
		$sql = "SELECT A.user_id,
				A.products_id,
				A.property_id,
				A.payment_status
		FROM " . TABLE_USER_CART . " AS A  ";
		$sql .= "WHERE A.user_id='".$user_id."' AND A.products_id='".$products_id."' AND A.property_id='".$property_id."'";
		$rs = $this->dbObj->createRecordset($sql);
		$arr = $this->dbObj->fetchAssoc($rs);		
		if(is_array($arr) && count($arr) > 0) {
			return $arr[0]['payment_status'];
		} else {
			return 2;
		}
	}

	// Function for empty user cart
	function fun_emptyUserCart($user_id) {
		$strDelteQuery = "DELETE FROM " . TABLE_USER_CART . " WHERE user_id='$user_id'";
		$this->dbObj->mySqlSafeQuery($strDelteQuery);
		return true;
	}

	// Function for user count cart item
	function fun_countCartItems($user_id){
		$sql = "SELECT COUNT(*) AS total_cart_items
		FROM " . TABLE_USER_CART . "
		WHERE user_id='".$user_id."' ";
		$rs = $this->dbObj->createRecordset($sql);
		$arr = $this->dbObj->fetchAssoc($rs);
		if($arr !=""){
			return $arr[0]['total_cart_items'];
		} else {
			return "0";
		}
	}

	// Function for user total amt in cart
	function fun_getCartPaymentAlert($user_id){
		$sql = "SELECT DATEDIFF(FROM_UNIXTIME(A.user_basket_date_expire, '%Y-%m-%d %H:%i:%s'), NOW()) AS days_diff, B.property_name AS property_name
		FROM " . TABLE_USER_CART . " AS A
		INNER JOIN " . TABLE_PROPERTY . " AS B ON A.property_id = B.property_id 
		WHERE A.user_id ='".$user_id."' 
		AND FROM_UNIXTIME(A.user_basket_date_expire, '%Y-%m-%d %H:%i:%s') > NOW() ORDER BY A.user_basket_date_expire DESC";
		$rs = $this->dbObj->createRecordset($sql);
		$arr = $this->dbObj->fetchAssoc($rs);
		return $arr;
	}


	// Function for user total amt in cart
	function fun_getCartAmtVAT($user_id){
		$vat = 17.5;
		$sql = "SELECT SUM(final_price) AS total_cart_amt
		FROM " . TABLE_USER_CART . "
		WHERE user_id='".$user_id."' ";
		$rs = $this->dbObj->createRecordset($sql);
		$arr = $this->dbObj->fetchAssoc($rs);
		if($arr !=""){
			$total_amt = $arr[0]['total_cart_amt']; 
			return (($total_amt)+(($total_amt*$vat)/100));
		} else {
			return "0";
		}
	}

// Function for user total amt in cart
	function fun_getCartAmt($user_id){
		$sql = "SELECT SUM((A.user_basket_quantity * B.products_price)) AS total_cart_amt
		FROM " . TABLE_USER_CART . " AS A
		INNER JOIN " . TABLE_PRODUCTS . " AS B ON A.products_id = B.products_id 
		WHERE user_id='".$user_id."' ";
		$rs = $this->dbObj->createRecordset($sql);
		$arr = $this->dbObj->fetchAssoc($rs);
		if($arr !=""){
			return $arr[0]['total_cart_amt']; 
		} else {
			return "0";
		}
	}

/*	
// Function for user total amt in cart
	function fun_getCartAmt($user_id){
		$sql = "SELECT SUM(final_price) AS total_cart_amt
		FROM " . TABLE_USER_CART . "
		WHERE user_id='".$user_id."' ";
		$rs = $this->dbObj->createRecordset($sql);
		$arr = $this->dbObj->fetchAssoc($rs);
		if($arr !=""){
			return $arr[0]['total_cart_amt']; 
		} else {
			return "0";
		}
	}
*/

	// This function will add an order
	function fun_addNewOrder($customers_id, $payment_method = '', $currency = '') {
		if($customers_id == '') {
			return false;
		} else {
			$currencyObj	= new Currency();
			$cur_unixtime 	= time ();
			if($payment_method == "") {
				$payment_method = "Paypal";
			}
			$orders_status 	= 1;
			if($currency == "") {
				$currency 	= "GBP";
			}
			$currency_value = $currencyObj->fun_getCurrencyValueByCode($currency);
			$strInsQuery = "INSERT INTO " . TABLE_ORDERS . " 
			(orders_id, customers_id, payment_method, last_modified, date_purchased, orders_status, currency, currency_value) 
			VALUES(null, '".$customers_id."', '".$payment_method."', '".$cur_unixtime."', '".$cur_unixtime."', '".$orders_status."', '".$currency."', '".currency_value."')";
			$this->dbObj->fun_db_query($strInsQuery);
			return $this->dbObj->getIdentity();
		}
	}

	// This function will add an order products
	function fun_addOrderProduct($orders_id, $products_id, $products_price, $final_price, $products_quantity) {
		if($orders_id == '' || $products_id == '') {
			return false;
		} else {
			$strInsQuery = "INSERT INTO " . TABLE_ORDERS_PRODUCTS . " 
			(orders_products_id, orders_id, products_id, products_price, final_price, products_quantity) 
			VALUES(null, '".$orders_id."', '".$products_id."', '".$products_price."', '".$final_price."', '".$products_quantity."')";
			$this->dbObj->fun_db_query($strInsQuery);
			return $this->dbObj->getIdentity();
		}
	}

	// Function for get order paid amount
	function fun_getOrderPaidAmount($orders_id) {
		$sql 	= "SELECT SUM(final_price) AS total_order_amt FROM " . TABLE_ORDERS_PRODUCTS . " WHERE orders_id='".$orders_id."' ";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			$arr = $this->dbObj->fetchAssoc($rs);
			return $arr[0]['total_order_amt'];
		} else {
			return false;
		}
	}

	// Function for order products array
	function fun_getOrderProductsArr($orders_id) {
		$sql 	= "SELECT A.*, B.products_name
		FROM " . TABLE_ORDERS_PRODUCTS . " AS A 
		INNER JOIN " . TABLE_PRODUCTS . " AS B ON A.products_id = B.products_id
		WHERE A.orders_id='".$orders_id."' ";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			$arr = $this->dbObj->fetchAssoc($rs);
			return $arr;
		} else {
			return false;
		}
	}

	// Function for get order paid amount
	function fun_getOrderUserPromoCode($orders_id, $user_id) {
		$sql 	= "SELECT promotion_code FROM " . TABLE_USER_PROMOTION_CODES . " WHERE order_id='".$orders_id."' AND user_id='".$user_id."'";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			$arr = $this->dbObj->fetchAssoc($rs);
			return $arr[0]['promotion_code'];
		} else {
			return false;
		}
	}

	// Function for user order history
	function fun_getUserOrderHistoryArr($user_id, $orders_status = '') {
		$sql 	= "SELECT orders_id FROM " . TABLE_ORDERS . " WHERE customers_id='".$user_id."'";
		if($orders_status != "") {
			$sql 	.= "AND orders_status = '".$orders_status."'";
		}
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			return $arr = $this->dbObj->fetchAssoc($rs);		
		} else {
			return false;
		}
	}

	// Function for user order date
	function fun_getOrderDate($orders_id) {
		return $this->dbObj->getField(TABLE_ORDERS, "orders_id", $orders_id, "date_purchased");
	}

	// Function for user order date
	function fun_getPropertyReference($orders_id, $products_id) {
		$sql 	= "SELECT property_id FROM " . TABLE_ORDERS_PRODUCTS_PROPERTIES . " WHERE orders_id='".$orders_id."' AND products_id='".$products_id."' ";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0) {
			$arr = $this->dbObj->fetchAssoc($rs);
			return $arr[0]['property_id'];
		} else {
			return false;
		}
	}

	// This function will add an order products
	function fun_updateOrderProductProperty($orders_id, $products_id, $property_id) {
		if($orders_id == '' || $products_id == '' || $property_id == '') {
			return false;
		} else {
			if(($property_relation_array = $this->fun_findRelationInfo(TABLE_ORDERS_PRODUCTS_PROPERTIES , " WHERE orders_id='".$orders_id."' AND products_id='".$orders_id."' AND  products_id='".$orders_id."'")) && (is_array($property_relation_array))){
				// do nothing			
			} else {
				// do add new
				$strInsQuery = "INSERT INTO " . TABLE_ORDERS_PRODUCTS_PROPERTIES . " 
				(orders_products_properties_id, orders_id, products_id, property_id) 
				VALUES(null, '".$orders_id."', '".$products_id."', '".$property_id."')";
				$this->dbObj->fun_db_query($strInsQuery);
			}
			return true;
		}
	}

	// This function will add an order status products history
	function fun_addOrderStatusHistory($orders_id, $orders_status_id, $date_added = '', $customer_notified = '', $comments = '') {
		if($orders_id == '' || $orders_status_id == '') {
			return false;
		} else {
			$strInsQuery = "INSERT INTO " . TABLE_ORDERS_STATUS_HISTORY . " 
			(orders_status_history_id, orders_id, orders_status_id, date_added, customer_notified, comments) 
			VALUES(null, '".$orders_id."', '".$orders_status_id."', '".$date_added."', '".$customer_notified."', '".$comments."')";
			$this->dbObj->fun_db_query($strInsQuery);
			return true;
		}
	}

	// This function will update order status
	function fun_updateOrderStatus($orders_id, $orders_status_id, $date_added = '') {
		if($orders_id == '' || $orders_status_id == '') {
			return false;
		} else {
			$sqlUpdateQuery = "UPDATE " . TABLE_ORDERS . " SET orders_status = '".$orders_status_id."', orders_date_finished = '".$date_added."' WHERE orders_id='".$orders_id."'";
			$this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
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