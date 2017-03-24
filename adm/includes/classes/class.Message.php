<?php
class Message{
	var $dbObj;
	
	function Message(){ // class constructor
		$this->dbObj = new DB();
		$this->dbObj->fun_db_connect();
	}
	
	// This function will Return message information in array with front end data	
	function fun_getMessageInfo($message_id){		
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
	function fun_getUserInboxArr($user_id, $extra_parameter=''){
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

	// Function for user Outbox array
	function fun_getUserOutboxArr($user_id, $extra_parameter=''){
		$sql = "SELECT A.message_id, 
				A.message_type,
				A.message_subject,
				FROM_UNIXTIME(A.message_created_on, '%m/%d/%Y') AS message_created_on,
				A.message_subject,
				A.message_sender_rflag,
				A.message_sender_dflag,
				B.user_fname,
				B.user_lname,
				C.messages_type_name
		FROM " . TABLE_USER_MESSAGES . " AS A  
		INNER JOIN " . TABLE_USERS . " AS B ON A.message_reciever_id = B.user_id 
		INNER JOIN " . TABLE_USER_MESSAGE_TYPE . " AS C ON A.message_type = C.messages_type_id 
		WHERE A.message_sender_id='".$user_id."' ";
		if($extra_parameter != ""){
			$sql .= " ".$extra_parameter;		
		}
		else{
			$sql .= "ORDER BY A.message_created_on";		
		}

		$rs = $this->dbObj->createRecordset($sql);
		return $arr = $this->dbObj->fetchAssoc($rs);		
	}

	// Function for user Outbox array
	function fun_countNewMessageInbox($user_id, $message_type_id=''){
		$sql = "SELECT COUNT(*) AS total_messages
		FROM " . TABLE_USER_MESSAGES . "
		WHERE message_reciever_id='".$user_id."' AND message_reciever_rflag='0' ";
		if($message_type_id != ""){
			$sql .= " AND message_type='".$message_type_id."'";
		}

		$rs = $this->dbObj->createRecordset($sql);
		$arr = $this->dbObj->fetchAssoc($rs);
		if($arr !=""){
			return $arr[0]['total_messages'];
		}
		else{
			return "0";
		}
	}

}
?>