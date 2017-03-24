<?php
class Users{
	var $dbObj;
	function Users(){ // class constructor
		$this->dbObj = new DB();
		$this->dbObj->fun_db_connect();
	}
	function fun_getUsersInfo($usersID=0, $usersLogin=''){
		$usersArray = array();
		$sql = "SELECT * FROM " . TABLE_USERS . " WHERE ";
		if($usersLogin!=""){
			$sql .= "user_login='".fun_db_input($usersLogin)."' ";
		}else{
			$sql .= "user_id='".(int)fun_db_input($usersID)."' ";
		}
		$result = $this->dbObj->fun_db_query($sql);
		if($this->dbObj->fun_db_get_num_rows($result) > 0){
			$rowsArray = $this->dbObj->fun_db_fetch_rs_object($result);
			$usersArray['user_id'] 		= fun_db_output($rowsArray->user_id);
			$usersArray['user_login'] 	= fun_db_output($rowsArray->user_login);
			$usersArray['user_pass'] 	= fun_db_output($rowsArray->user_pass);
			$usersArray['user_fname'] 	= fun_db_output($rowsArray->user_fname);
			$usersArray['user_lname'] 	= fun_db_output($rowsArray->user_lname);
			$usersArray['user_email'] 	= fun_db_output($rowsArray->user_email);
			$usersArray['user_dob'] 	= fun_db_output($rowsArray->user_dob);
			$usersArray['user_address1']= fun_db_output($rowsArray->user_address1);
			$usersArray['user_address2']= fun_db_output($rowsArray->user_address2);
			$usersArray['user_town'] 	= fun_db_output($rowsArray->user_town);
			$usersArray['user_state'] 	= fun_db_output($rowsArray->user_state);
			$usersArray['user_zip'] 	= fun_db_output($rowsArray->user_zip);
			$usersArray['user_country'] = fun_db_output($rowsArray->user_country);
			$usersArray['user_rcountry']= fun_db_output($rowsArray->user_rcountry);
			$usersArray['user_status'] 	= fun_db_output($rowsArray->user_status);
			$usersArray['user_ip'] 		= fun_db_output($rowsArray->user_ip);			
			$usersArray['is_admin'] 	= fun_db_output($rowsArray->is_admin);
			$usersArray['is_owner'] 	= fun_db_output($rowsArray->is_owner);
			$usersArray['photo'] 		= fun_db_output($rowsArray->photo);
			$usersArray['story'] 		= fun_db_output($rowsArray->story);
			$usersArray['updated_on'] 	= fun_db_output($rowsArray->updated_on);
			$usersArray['created_on'] 	= fun_db_output($rowsArray->created_on);
		}
		$this->dbObj->fun_db_free_resultset($result);
		return $usersArray;
	}
	
	//function to get user registered for newsletter info array
	function fun_getUser4NewsletterInfo($strEmail){
		$User4NewsletterArray = array();
		$sql = "SELECT * FROM " . TABLE_USER_NEWSLETTER . " WHERE user_email='".trim($strEmail)."'";		
		$result = $this->dbObj->fun_db_query($sql);
		if($this->dbObj->fun_db_get_num_rows($result) > 0){
			$rowsArray = $this->dbObj->fun_db_fetch_rs_object($result);
			$User4NewsletterArray['id'] 		= fun_db_output($rowsArray->id);
			$User4NewsletterArray['user_id'] 	= fun_db_output($rowsArray->user_id);
			$User4NewsletterArray['user_email'] = fun_db_output($rowsArray->user_email);
			$User4NewsletterArray['created_on'] = fun_db_output($rowsArray->created_on);
			$User4NewsletterArray['active'] 	= fun_db_output($rowsArray->active);
		}
		$this->dbObj->fun_db_free_resultset($result);
		return $User4NewsletterArray;
	}

	//function to verify user registered for newsletter
	function fun_verifyUser4Newsletter($strEmail){		
		$usersFound = false;
		$sqlCheck = "SELECT * FROM " . TABLE_USER_NEWSLETTER . " WHERE user_email='".trim($strEmail)."'";		
		if($this->fun_get_num_rows($sqlCheck) > 0){
			$usersFound = true;
		}
		return $usersFound;
	}

	// Function for email users array
	function fun_getUser4NewsLeterListArr(){
        $sql1 	= "SELECT 	* FROM " . TABLE_USERS_NEWSLETTER . " AS A ORDER BY A.created_on";
		$rs1 	= $this->dbObj->createRecordset($sql1);
		$arr1 	= $this->dbObj->fetchAssoc($rs1);


        $sql2 	= "SELECT 	* FROM " . TABLE_USER_NEWSLETTER . " AS A ORDER BY A.created_on";
		$rs2 	= $this->dbObj->createRecordset($sql2);
        $arr2 	= $this->dbObj->fetchAssoc($rs2);

		$j 		= count($arr1);
		for($i = 0; $i < count($arr2); $i++) {
			$arr1[$j] = $arr2[$i];
			$j++;
		}
		return $arr1;
	}

	function fun_updateUserPhoto($user_id, $photo_thumb) {
		if($user_id == '' || $photo_thumb == ''){
			return false;
		} else {
            $sqlUpdateQuery = "UPDATE " . TABLE_USERS . " SET photo = '".fun_db_input($photo_thumb)."' WHERE user_id='".$user_id."'";
            $this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
            return true;
		}
	}

	function fun_updateUserStory($user_id, $story) {
		if($user_id == '' || $story == ''){
			return false;
		} else {
            $sqlUpdateQuery = "UPDATE " . TABLE_USERS . " SET story = '".fun_db_input($story)."' WHERE user_id='".$user_id."'";
            $this->dbObj->mySqlSafeQuery($sqlUpdateQuery);
            return true;
		}
	}

	// Function for email users array
	function fun_delUserNewsLetter($id){
		// Delete from TABLE_USER_NEWSLETTER
		$strDelQuery = "DELETE FROM " . TABLE_USER_NEWSLETTER . " WHERE id='".$id."'";
		$this->dbObj->mySqlSafeQuery($strDelQuery);
		return true;
	}

	// Function for email users array
	function fun_getUserNewsLetterArr($parameter){
        $sql 	= "SELECT A.* FROM " . TABLE_USER_NEWSLETTER . " AS A ";
		if($parameter != ""){
			$sql .= $parameter;
		} else {
			$sql .= " ORDER BY A.id";		
		}

		$rs 	= $this->dbObj->createRecordset($sql);
		$arr 	= $this->dbObj->fetchAssoc($rs);
		return $arr;
	}

	// Function for email users array
	function fun_getNewsLetterArr($parameter){
        $sql 	= "SELECT A.* FROM " . TABLE_NEWSLETTER . " AS A ";
		if($parameter != ""){
			$sql .= $parameter;
		} else {
			$sql .= " ORDER BY A.id";		
		}

		$rs 	= $this->dbObj->createRecordset($sql);
		$arr 	= $this->dbObj->fetchAssoc($rs);
		return $arr;
	}



	//function to add user for newsletter
	function fun_addUser4Newsletter(){
		if(isset($_SESSION['ses_user_id'])){			
			$user_id = $_SESSION['ses_user_id'];
		}
		else{
			$user_id = "";
		}

		$user_email 	= trim($_GET['email']);
		$created_on 	= time ();
		$val = '0';
		
		$usersArray = array(
							"user_id" 			=> $user_id,
							"user_email" 			=> $user_email,
							"created_on" 			=> $created_on,
							"active" 				=> $val
						);		
		if(is_array($usersArray)){
			$fields = "";
			$fieldsVals = "";
			$cnt = 0;
			foreach($usersArray as $keys => $values){
				$fields .= $keys;
				$fieldsVals .= "'" . fun_db_input($values) . "'";
				if($cnt < sizeof($usersArray)-1){
					$fields .= ", ";
					$fieldsVals .= ", ";
				}
				$cnt++;
			}
			$sqlInsert = "INSERT INTO " . TABLE_USER_NEWSLETTER . "(id, ".$fields.") ";
	 		$sqlInsert .= "VALUES(null, ".$fieldsVals.")";
			$this->dbObj->fun_db_query($sqlInsert);
			return $this->dbObj->fun_db_get_affected_rows();
		}
	}

	//function to add user for newsletter
	function fun_addUserNewsletterSignup($email_id){
		if(isset($_SESSION['ses_user_id'])){			
			$user_id = $_SESSION['ses_user_id'];
		} else {
			$user_id = "";
		}

		$user_email 	= trim($email_id);
		$created_on 	= time ();
		$val = '0';
		$usersArray = array(
							"user_id" 			=> $user_id,
							"user_email" 			=> $user_email,
							"created_on" 			=> $created_on,
							"active" 				=> $val
						);		
		if(is_array($usersArray)){
			$fields = "";
			$fieldsVals = "";
			$cnt = 0;
			foreach($usersArray as $keys => $values){
				$fields .= $keys;
				$fieldsVals .= "'" . fun_db_input($values) . "'";
				if($cnt < sizeof($usersArray)-1){
					$fields .= ", ";
					$fieldsVals .= ", ";
				}
				$cnt++;
			}
			$sqlInsert = "INSERT INTO " . TABLE_USER_NEWSLETTER . "(id, ".$fields.") ";
	 		$sqlInsert .= "VALUES(null, ".$fieldsVals.")";
			$this->dbObj->fun_db_query($sqlInsert);
			return $this->dbObj->fun_db_get_affected_rows();
		}
	}

	function fun_sendTellaFriendEmail($user_id, $user_full_name, $user_femail_id, $user_subject = '', $user_message = ''){
        if($user_id == "" || $user_full_name == "" || $user_femail_id == "") {
			return false;
        } else {
            $body ='<table width="70%"  border="0" cellspacing="10" cellpadding="0">
				<tr style="height:10px;"><td></td></tr>
				<tr>
				<td style="padding-left:5px;">Your friend, '.$user_full_name.' thought you might be interested in '.$_SERVER["SERVER_NAME"].'. If you own a holiday property then advertising it on '.$_SERVER["SERVER_NAME"].' you will increase your chances of it being fully booked whenever available.</td>
				</tr>
				<tr>
				<td style="padding-left:5px;"><strong>Your friend\'s message:</strong>'.$user_message.'</td>
				</tr>
				<tr>
				<td style="padding-left:5px;">Thanks,</td>
				</tr>
				<tr>
				<td style="padding-left:5px;">'.$_SERVER["SERVER_NAME"].'</td>
				</tr>	  
            </table>
            ';
            $emailObj = new Email($user_femail_id , "Administrator | rentownersvillas.com <".SITE_INFO_EMAIL.">", $user_subject, $body);
            //$emailObj = new Email($user_femail_id , SITE_INFO_EMAIL, $user_subject, $body);
            if($emailObj->sendEmail()){
				$emailObj1 = new Email("admin@rentownersvillas.com", "Administrator | rentownersvillas.com <".SITE_INFO_EMAIL.">", $user_subject, $body);
				$emailObj1->sendEmail();
                return true;
            }else{
                return false;
            }
        }
	}

	function fun_sendTellOurFriendEmail($user_femail_id, $user_subject = '', $user_message = ''){
        if($user_femail_id == "") {
			return false;
        } else {
            $body ='<table width="70%"  border="0" cellspacing="10" cellpadding="0">
				<tr style="height:10px;"><td></td></tr>
				<tr>
				<td style="padding-left:5px;">Your friend thought you might be interested in '.$_SERVER["SERVER_NAME"].'. If you own a vacation rental home, then advertising it on '.$_SERVER["SERVER_NAME"].' you will increase your chances of it being fully booked whenever available.</td>
				</tr>
				<tr>
				<td style="padding-left:5px;"><strong>Your friend\'s message:</strong>'.$user_message.'</td>
				</tr>
				<tr>
				<td style="padding-left:5px;">Thanks,</td>
				</tr>
				<tr>
				<td style="padding-left:5px;">'.$_SERVER["SERVER_NAME"].'</td>
				</tr>	  
            </table>
            ';
            $emailObj = new Email($user_femail_id, "rentownersvillas.com <".SITE_INFO_EMAIL.">", $user_subject, $user_message);
            if($emailObj->sendEmail()){
				$emailObj1 = new Email("admin@rentownersvillas.com", "rentownersvillas.com <".SITE_INFO_EMAIL.">", $user_subject, $body);
				$emailObj1->sendEmail();
                return true;
            } else {
                return false;
            }
        }
	}

	function sendNewsletterActivationEmail($u_id, $uEmailId){
		$uid 	= base64_encode($u_id);		
		$link 	= SITE_URL."confirm.php?uId=".$uid."";

$body ='<table width="70%"  border="0" cellspacing="10" cellpadding="0">
<tr style="height:10px;"><td></td></tr>
<tr><td style="padding-left:5px;"><strong>Thanks for signing up to the '.$_SERVER["SERVER_NAME"].' newsletter.</strong></td></tr>
<tr><td style="padding-left:5px;">Confirm your email address by <a href="'.$link.'">clicking here</a></td></tr>
<tr><td style="padding-left:5px;">Once you confirm your email address our latest feature packed newsletter will be winging it\'s way to your inbox shortly.</td></tr>
<tr><td style="padding-left:5px;">If you didn\'t request this email or don\'t want to receive the '.$_SERVER["SERVER_NAME"].' newsletter just ignore this email and nothing more will happen.</td></tr>
<tr><td style="padding-left:5px;">Thanks again for your support,</td></tr>
<tr><td style="padding-left:5px;">Team,</td></tr>	  
<tr><td style="padding-left:5px;">'.$_SERVER["SERVER_NAME"].'</td></tr>	  
</table>
';
		$emailObj = new Email($uEmailId, "Administrator | rentownersvillas.com <".SITE_ADMIN_EMAIL.">", "Welcome to ".$_SERVER["SERVER_NAME"], $body);
		//$emailObj = new Email($uEmailId, SITE_ADMIN_EMAIL, "Welcome to ".$_SERVER["SERVER_NAME"], $body);
		if($emailObj->sendEmail()){
			$emailObj1 = new Email("admin@rentownersvillas.com", "Administrator | rentownersvillas.com <".SITE_ADMIN_EMAIL.">", "Welcome to ".$_SERVER["SERVER_NAME"], $body);
			$emailObj1->sendEmail();
			return true;
		}else{
			return false;
		}
	}

	function fun_activateUser4NewsletterLink($uId){
		$val = 1;
		$sqlUpdate = "UPDATE " . TABLE_USER_NEWSLETTER . " SET active = '".$val."' WHERE id='".$uId."' ";
		
		$this->dbObj->fun_db_query($sqlUpdate) or die("<font color='#ff0000' face='verdana' size='2'>Error: Unable to execute request!<br>Invalid Query On Users table.</font>");
		
		if($this->dbObj->fun_db_get_affected_rows()){
			return true;
		}else{
			return false;
		}		
	}


	
	// function for adding new user
	function fun_addNewUsers(){
		$dobDay = trim($_POST['dobDay']);
		$dobMonth = trim($_POST['dobMonth']);
		$dobYear = trim($_POST['dobYear']);
		$users_dob = "";
		if($dobDay!='' && $dobMonth!='' && $dobYear!=''){
			$users_dob = $dobYear . "-" . $dobMonth . "-" .$dobDay;
		}
		$user_status = 1;
		$users_activation_link = 0;
		$user_pass = trim($_POST['users_password']);
		if(isset($_POST['users_house_property_rental']) && $_POST['users_house_property_rental'] == "1"){
			$is_owner = "1";
		}
		else{
			$is_owner = "0";
		}
		$user_email 	= trim($_POST['users_email_id']);
		$is_admin 		= "0";
		$user_fname 	= trim($_POST['users_first_name']);
		$user_lname 	= trim($_POST['users_last_name']);
		$user_country 	= trim($_POST['country_id']);
		$user_ip 		= trim($_POST['users_ip']);
		$created_on 	= time ();
		$created_by 	= "SELF";
		$updated_on 	=  time ();
		$updated_by 	= "SELF";
		$last_login 	= time ();
		$usersArray = array(
							"user_login" 			=> $user_email,
							"user_pass" 			=> md5($user_pass),
							"user_fname" 			=> $user_fname,
							"user_lname" 			=> $user_lname,
							"user_email" 			=> $user_email,
							"user_dob" 				=> $users_dob,
							"user_country" 			=> $user_country,
							"user_ip" 				=> $user_ip,
							"is_admin"				=> $is_admin,
							"is_owner"				=> $is_owner,
							"created_on" 			=> $created_on,
							"created_by" 			=> $created_by,
							"updated_on" 			=> $updated_on,
							"updated_by" 			=> $updated_by,
							"last_login" 			=> $last_login,
							"user_activation_link" 	=> $users_activation_link,
							"user_status" 			=> $user_status
						);		

		$fields = "";
		$fieldsVals = "";
		$cnt = 0;
		foreach($usersArray as $keys => $values){
			$fields .= $keys;
			$fieldsVals .= "'" . fun_db_input($values) . "'";
			if($cnt < sizeof($usersArray)-1){
				$fields .= ", ";
				$fieldsVals .= ", ";
			}
			$cnt++;
		}
		$sqlInsert = "INSERT INTO " . TABLE_USERS . "(user_id, ".$fields.") ";
		$sqlInsert .= "VALUES(null, ".$fieldsVals.")";
		$this->dbObj->fun_db_query($sqlInsert);
		return $this->dbObj->fun_db_get_affected_rows();
	}

	// function for update user details
	function fun_updateUserDetails($user_id, $user_fname, $user_lname, $user_email, $user_dob, $user_address1, $user_address2, $user_town, $user_state, $user_zip, $user_country, $user_rcountry){
        if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !="") {
            $cur_user_id 	= $_SESSION['ses_admin_id'];
        } else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !="") {
            $cur_user_id 	= $_SESSION['ses_modarator_id'];
        } else {
            $cur_user_id 	= $user_id;
        }
        $cur_unixtime 			= time ();

        $field_names 			= array("user_fname", "user_lname", "user_email", "user_dob", "user_address1", "user_address2", "user_town", "user_state", "user_zip", "user_country", "user_rcountry", "updated_on", "updated_by");
        $field_values 			= array(fun_db_input($user_fname), fun_db_input($user_lname), fun_db_input($user_email), fun_db_input($user_dob), fun_db_input($user_address1), fun_db_input($user_address2), fun_db_input($user_town), fun_db_input($user_state), fun_db_input($user_zip), fun_db_input($user_country), fun_db_input($user_rcountry), fun_db_input($cur_unixtime), fun_db_input($cur_user_id));
        $this->dbObj->updateFields(TABLE_USERS, "user_id", $user_id, $field_names, $field_values);
        return true;
	}

	// function for update holiday to owner
	function fun_updateHolidayAsOwner($user_id, $user_fname, $user_lname, $user_email, $dobDay, $dobMonth, $dobYear, $user_address1, $user_address2, $user_town, $user_state, $user_zip, $user_country, $user_rcountry, $is_owner){
        if($user_id == "") {
            return false;
        } else {
            $updated_on 		= time ();
            if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !="") {
                $updated_by 	= $_SESSION['ses_admin_id'];
            } else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !="") {
                $updated_by 	= $_SESSION['ses_modarator_id'];
            } else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !="") {
                $updated_by 	= $_SESSION['ses_user_id'];
            } else {
                $updated_by 	= "";
            }

            $users_dob = "";
            if($dobDay!='' && $dobMonth!='' && $dobYear!=''){
                $users_dob = $dobYear . "-" . $dobMonth . "-" .$dobDay;
            }

            $usersArray = array(
                                "user_fname" 			=> $user_fname,
                                "user_lname" 			=> $user_lname,
                                "user_email" 			=> $user_email,
                                "user_dob" 				=> $users_dob,
                                "user_address1" 		=> $user_address1,
                                "user_address2" 		=> $user_address2,
                                "user_town" 			=> $user_town,
                                "user_state" 			=> $user_state,
                                "user_zip" 				=> $user_zip,
                                "user_country" 			=> $user_country,
                                "user_rcountry" 		=> $user_rcountry,
                                "is_owner" 				=> $is_owner,
                                "updated_on" 			=> $updated_on,
                                "updated_by" 			=> $updated_by
                            );		
    
            $fields = "";
            $fieldsVal = "";
            foreach($usersArray as $keys => $vals){
                $fields .= $keys . "='" . fun_db_input($vals). "', ";
            }
    
            $fields = trim($fields);
            if($fields!=""){
                $fields = substr($fields,0,strlen($fields)-1);
                $sqlUpdate = "UPDATE " . TABLE_USERS . " SET " . $fields . " WHERE user_id='".(int)$user_id."'";
                $this->dbObj->fun_db_query($sqlUpdate);
            }
            return true;
        }
	}

	// function for user registration
	function fun_registerUser($user_login, $user_pass, $user_fname, $user_lname, $user_email, $dobDay, $dobMonth, $dobYear, $user_address1, $user_address2, $user_town, $user_state, $user_zip, $user_country, $user_rcountry, $is_owner){
        $cur_unixtime 			= time ();
        $user_dob = "";
        if($dobDay!='' && $dobMonth!='' && $dobYear!='') {
            $user_dob = $dobYear . "-" . $dobMonth . "-" .$dobDay;
        }
        $user_activation_link 	= "0";
        $user_status 			= "1";
        $field_names 			= array("user_login", "user_pass", "user_fname", "user_lname", "user_email", "user_dob", "user_address1", "user_address2", "user_town", "user_state", "user_zip", "user_country", "user_rcountry", "is_owner", "user_activation_link", "user_status");
        $field_values 			= array(fun_db_input($user_login), md5($user_pass), fun_db_input($user_fname), fun_db_input($user_lname), fun_db_input($user_email), fun_db_input($user_dob), fun_db_input($user_address1), fun_db_input($user_address2), fun_db_input($user_town), fun_db_input($user_state), fun_db_input($user_zip), fun_db_input($user_country), fun_db_input($user_rcountry), fun_db_input($is_owner), fun_db_input($user_activation_link), fun_db_input($user_status));
        $this->dbObj->insertFields(TABLE_USERS, $field_names, $field_values);
        $user_id 				= $this->dbObj->getIdentity();

        if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !="") {
            $cur_user_id 	= $_SESSION['ses_admin_id'];
        } else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !="") {
            $cur_user_id 	= $_SESSION['ses_modarator_id'];
        } else {
            $cur_user_id 	= $user_id;
        }

        $field_names 			= array("created_on", "created_by", "updated_on", "updated_by");
        $field_values 			= array($cur_unixtime, $cur_user_id, $cur_unixtime, $cur_user_id);
		$this->dbObj->updateFields(TABLE_USERS, "user_id", $user_id, $field_names, $field_values);
        return $user_id;
	}

	// function for user detail update
	function fun_updateUserNameEmail($user_id, $user_fname = '', $user_lname = '', $user_email = ''){
		if($user_id == ""){
			return false;
		} else {
            $field_names 		= array("user_fname", "user_lname", "user_email");
            $field_values 		= array($user_fname, $user_lname, $user_email);
            $this->dbObj->updateFields(TABLE_USERS, "user_id", $user_id, $field_names, $field_values);
			return true;
		}
	}

	// Function	for activate enquiry user
	function fun_activateEnquiryUser($enquiry_id) {
		if($enquiry_id == '') {
			return false;
		} else {
			$this->dbObj->updateField(TABLE_USER_ENQUIRIES_RELATIONS, "enquiry_id", $enquiry_id, "active", "1");
			return true;
		}
	}

	// function for update users contact languagea
	function fun_updateUserContactLanguages($user_id, $txtContactLanguageArr){
        if($user_id == "") {
            return false;
        } else {
            $strDelContactLanguagesQuery = "DELETE FROM " . TABLE_USER_CONTACT_LANGUAGES . " WHERE user_id='".$user_id."'";
            $this->dbObj->mySqlSafeQuery($strDelContactLanguagesQuery); // delete previous relations
            if(is_array($txtContactLanguageArr) && count($txtContactLanguageArr)) {
                for($j=0; $j<count($txtContactLanguageArr); $j++){
                    $txtContactLanguage 	= $txtContactLanguageArr[$j];
                    $txtContactLanguageShow = 1;
                    if($txtContactLanguage !=""){
                        $strInsContactLanguagesQuery = "INSERT INTO " . TABLE_USER_CONTACT_LANGUAGES . "(id, user_id, language_id, language_show) ";
                        $strInsContactLanguagesQuery .= "VALUES(null, '".$user_id."', '".$txtContactLanguage."', '".$txtContactLanguageShow."')";
                        $this->dbObj->mySqlSafeQuery($strInsContactLanguagesQuery);
                    }
                }
            }
            return true;
        }
	}


	// function for update users contact languagea
	function fun_updateUserContactNumbers($user_id, $txtContactNumberType, $txtContactCountry, $txtContactNumber){
        if($user_id == "") {
            return false;
        } else {
            $strDelContactNumbersQuery = "DELETE FROM " . TABLE_USER_CONTACT_NUMBERS . " WHERE user_id='".$user_id."'";
            $this->dbObj->mySqlSafeQuery($strDelContactNumbersQuery); // delete previous relations
            if(is_array($txtContactNumber) && count($txtContactNumber)) {
                for($i=0; $i<count($txtContactNumber); $i++){
                    $contact_number_typeid 		= $txtContactNumberType[$i];
                    $contact_number_countryid 	= $txtContactCountry[$i];
                    $contact_number 			= $txtContactNumber[$i];
                    $contact_number_show		= 1;
                    if($contact_number != ""){
                        $strInsContactNumbersQuery = "INSERT INTO " . TABLE_USER_CONTACT_NUMBERS . "(id, user_id, contact_number_typeid, contact_number_countryid, contact_number, contact_number_show) ";
                        $strInsContactNumbersQuery .= "VALUES(null, '".$user_id."', '".$contact_number_typeid."', '".$contact_number_countryid."', '".$contact_number."', '".$contact_number_show."')";
                        $this->dbObj->mySqlSafeQuery($strInsContactNumbersQuery);
                    }
                }
            }
            return true;
		}
    }

	// function for update user name
	function fun_updateUserName($user_id, $user_fname = '', $user_lname = ''){
        if($user_id == "") {
            return false;
        } else {
            $cur_unixtime 	= time ();
            if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !=""){
                $cur_user_id 	= $_SESSION['ses_admin_id'];
            }
            else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !=""){
                $cur_user_id 	= $_SESSION['ses_modarator_id'];
            }
            else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !=""){
                $cur_user_id 	= $_SESSION['ses_user_id'];
            }
            else{
                $cur_user_id 	= "";
            }

            $usersArray = array(
                                "user_fname" 			=> $user_fname,
                                "user_lname" 			=> $user_lname,
                                "updated_on" 			=> $cur_unixtime,
                                "updated_by" 			=> $cur_user_id
                            );		
    
            $fields = "";
            $fieldsVal = "";
            foreach($usersArray as $keys => $vals){
                $fields .= $keys . "='" . fun_db_input($vals). "', ";
            }
    
            $fields = trim($fields);
            if($fields!=""){
                $fields = substr($fields,0,strlen($fields)-1);
                $sqlUpdate = "UPDATE " . TABLE_USERS . " SET " . $fields . " WHERE user_id='".(int)$user_id."'";
                $this->dbObj->fun_db_query($sqlUpdate);
            }
            return true;
        }
	}

	// function for update user name
	function fun_updateUserEmail($user_id, $user_email = ''){
        if($user_id == "") {
            return false;
        } else {
            $cur_unixtime 	= time ();
            if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !=""){
                $cur_user_id 	= $_SESSION['ses_admin_id'];
            }
            else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !=""){
                $cur_user_id 	= $_SESSION['ses_modarator_id'];
            }
            else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !=""){
                $cur_user_id 	= $_SESSION['ses_user_id'];
            }
            else{
                $cur_user_id 	= "";
            }

            $usersArray = array(
                                "user_email" 			=> $user_email,
                                "updated_on" 			=> $cur_unixtime,
                                "updated_by" 			=> $cur_user_id
                            );		
    
            $fields = "";
            $fieldsVal = "";
            foreach($usersArray as $keys => $vals){
                $fields .= $keys . "='" . fun_db_input($vals). "', ";
            }
    
            $fields = trim($fields);
            if($fields!=""){
                $fields = substr($fields,0,strlen($fields)-1);
                $sqlUpdate = "UPDATE " . TABLE_USERS . " SET " . $fields . " WHERE user_id='".(int)$user_id."'";
                $this->dbObj->fun_db_query($sqlUpdate);
            }
            return true;
        }
	}

	// function for update user name
	function fun_updateUserSettings($user_id, $userSettingsArr) {
        if($user_id == "") {
            return false;
        } else {
            $strDelUserSettingQuery = "DELETE FROM " . TABLE_USER_SETTING_RELATIONS . " WHERE user_id='".$user_id."'";
            $this->dbObj->mySqlSafeQuery($strDelUserSettingQuery); // delete previous relations
            if(is_array($userSettingsArr)) {
                for($j = 0; $j < count($userSettingsArr); $j++){
                    $setting_id = $userSettingsArr[$j];
                    $strInsQuery = "INSERT INTO " . TABLE_USER_SETTING_RELATIONS . "(`user_id`, `setting_id`) VALUES ('" . $user_id . "', '" . $setting_id . "')";
                    $this->dbObj->mySqlSafeQuery($strInsQuery);
                }
            }
            return true;
        }
	}

	// Function for short user info array
	function fun_getUserShortInfoArr($parameter=''){
		$sql = "SELECT 	A.*, FROM_UNIXTIME(A.created_on, '%m/%d/%Y') AS registered_on FROM " . TABLE_USERS . " AS A WHERE A.is_admin !='1'";
		if($parameter!=""){
			$sql .= $parameter;
		}
		else{
			$sql .= " ORDER BY A.user_id";		
		}
		$rs = $this->dbObj->createRecordset($sql);
		return $arr = $this->dbObj->fetchAssoc($rs);		
	}

	/*
	*  User Checklist Function : Start Here
	*/

	function fun_setUserChecklistSetting($user_id = ''){
		if ( $user_id == '' ) {
			$tbl = TABLE_USER_CHECKLIST_SETTINGS_TMP;
			$id = $_REQUEST['PHPSESSID'];
		} else {
			$tbl = TABLE_USER_CHECKLIST_SETTINGS;
			$id = $user_id;
		}

		// Step I : if user checklist type of people details available update it
		if( isset ( $_POST['txtPeopleType'] ) && $_POST['txtPeopleType'] != "" ) {
			$strPeopleType 		= $_POST['txtPeopleType'];
			// Select relation 
			$sql = "SELECT * FROM " . $tbl . " WHERE user_id='".$id."'";
			$rdo = $this->dbObj->mySqlSafeQuery($sql);
			if ( mysql_num_rows ( $rdo ) > 0 ) {
				$sqlUpdate = "UPDATE " . $tbl . " SET holiday_ptype='" . $strPeopleType . "' WHERE user_id='".$id."'";
				$rdoUpdate = $this->dbObj->mySqlSafeQuery($sqlUpdate);
			} else {
				$strInsQuery = "INSERT INTO " . $tbl . "(checklist_setting_id, user_id, holiday_ptype) ";
				$strInsQuery .= "VALUES(null, '".$id."', '".$strPeopleType."')";
				$this->dbObj->mySqlSafeQuery($strInsQuery);
			}
		}

		// Step II : if user checklist type of holiday details available update it
		if(isset($_POST['txtHolidayType']) && $_POST['txtHolidayType'] != ""){
			//delete all previous relation
			$txtHolidayTypeArr	= $_POST['txtHolidayType'];
			$strHolidayType 		= implode(",",$txtHolidayTypeArr);
			
			// Select relation 
			$sql = "SELECT * FROM " . $tbl . " WHERE user_id='".$id."'";
			$rdo = $this->dbObj->mySqlSafeQuery($sql);
			if(mysql_num_rows($rdo) > 0){
				$sqlUpdate = "UPDATE " . $tbl . " SET holiday_type='" . $strHolidayType . "' WHERE user_id='".$id."'";
				$rdoUpdate = $this->dbObj->mySqlSafeQuery($sqlUpdate);
			}
			else{
				$strInsQuery = "INSERT INTO " . $tbl . "(checklist_setting_id, user_id, holiday_type) ";
				$strInsQuery .= "VALUES(null, '".$id."', '".$strHolidayType."')";
				$this->dbObj->mySqlSafeQuery($strInsQuery);
			}
		}

		// Step III : if user checklist type of accomadation details available update it
		if(isset($_POST['txtAccommodationType']) && $_POST['txtAccommodationType'] != ""){
			//delete all previous relation
			$strAccommodationType = $_POST['txtAccommodationType'];
			
			// Select relation 
			$sql = "SELECT * FROM " . $tbl . " WHERE user_id='".$id."'";
			$rdo = $this->dbObj->mySqlSafeQuery($sql);
			if(mysql_num_rows($rdo) > 0){
				$sqlUpdate = "UPDATE " . $tbl . " SET accommodation_type='" . $strAccommodationType . "' WHERE user_id='".$id."'";
				$rdoUpdate = $this->dbObj->mySqlSafeQuery($sqlUpdate);
			}
			else{
				$strInsQuery = "INSERT INTO " . $tbl . "(checklist_setting_id, user_id, accommodation_type) ";
				$strInsQuery .= "VALUES(null, '".$id."', '".$strAccommodationType."')";
				$this->dbObj->mySqlSafeQuery($strInsQuery);
			}
		}

		// Step IV : if checklist amenities and features details available update it
		if(isset($_POST['txtAmenitiesFeatures']) && $_POST['txtAmenitiesFeatures'] != ""){
			//delete all previous relation
			$txtAmenitiesFeaturesArr	= $_POST['txtAmenitiesFeatures'];
			$strAmenitiesFeatures 		= implode(",",$txtAmenitiesFeaturesArr);
			
			$sql = "SELECT * FROM " . $tbl . " WHERE user_id='".$id."'";
			$rdo = $this->dbObj->mySqlSafeQuery($sql);
			if(mysql_num_rows($rdo) > 0){
				$sqlUpdate = "UPDATE " . $tbl . " SET amenities_type='" . $strAmenitiesFeatures . "' WHERE user_id='".$id."'";
				$rdoUpdate = $this->dbObj->mySqlSafeQuery($sqlUpdate);
			}
			else{
				$strInsQuery = "INSERT INTO " . $tbl . "(checklist_setting_id, user_id, amenities_type) ";
				$strInsQuery .= "VALUES(null, '".$id."', '".$strAmenitiesFeatures."')";
				$this->dbObj->mySqlSafeQuery($strInsQuery);
			}
		}

		// Step I : if user checklist type of people details available update it
		if( isset ( $_POST['txtClearChecklist'] ) && $_POST['txtClearChecklist'] == "yes" ) {

			$strDelQuery = "DELETE FROM " . $tbl . " WHERE user_id='".$id."'";
			$this->dbObj->mySqlSafeQuery($strDelQuery);
		}
	}

	// Function for creating user check list : type of people section
	function fun_createHolidayCheckListPeopleType($user_id = ''){		
		$sqlCheckListPeopleTypeIds 	= "SELECT holiday_ptype FROM " . TABLE_USER_CHECKLIST_SETTINGS . " WHERE user_id='".$user_id."'";
		$rsCheckListPeopleTypeIds 	= $this->dbObj->createRecordset($sqlCheckListPeopleTypeIds);
		$arrCheckListPeopleTypeIds 	= $this->dbObj->fetchAssoc($rsCheckListPeopleTypeIds);
		$checkListPeopleTypeIds = "";

		foreach($arrCheckListPeopleTypeIds as $val){
			$checkListPeopleTypeIds = $val['holiday_ptype'];
		}

		$checkListPeopleTypeIdsArr = explode(",", $checkListPeopleTypeIds);
		
		$sql = "SELECT * FROM " . TABLE_HOLIDAY_MAKER . " ORDER BY holiday_maker_name";
		echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
		echo "<tr>";
		$rs = $this->dbObj->createRecordset($sql);
		$arr = $this->dbObj->fetchAssoc($rs);
		$i = 0;
		foreach($arr as $value){
			if($i%2 == 0){
				echo "</tr><tr>";
			}
			if(array_search($value['holiday_maker_id'], $checkListPeopleTypeIdsArr) === false){
				$checked = "";
			}
			else{
				$checked = "checked";
			}
			echo "<td width=\"24\" valign=\"top\" class=\"pad-btm5 pad-top3\"><input type=\"radio\" name='txtPeopleType' value='". $value['holiday_maker_id'] ."' class=\"RegFormChkBox\" " .$checked. "></td>";
			echo "<td width=\"260\" valign=\"top\" class=\"pad-btm5\"> " .ucwords($value['holiday_maker_name']). " </td>";
			$i++;
		}
		echo "</table>";
	}

	// Function for creating user check list : type of holiday
	function fun_createHolidayCheckListHolidayType($user_id = ''){		
		$sqlCheckListHolidayTypeIds 	= "SELECT holiday_type FROM " . TABLE_USER_CHECKLIST_SETTINGS . " WHERE user_id='".$user_id."'";
		$rsCheckListHolidayTypeIds 		= $this->dbObj->createRecordset($sqlCheckListHolidayTypeIds);
		$arrCheckListHolidayTypeIds 	= $this->dbObj->fetchAssoc($rsCheckListHolidayTypeIds);
		$checkListHolidayTypeIds 		= "";

		foreach($arrCheckListHolidayTypeIds	 as $val){
			$checkListHolidayTypeIds = $val['holiday_type'];
		}

		$checkListHolidayTypeIdsArr = explode(",", $checkListHolidayTypeIds);
		
		$sql = "SELECT * FROM " . TABLE_HOLIDAY . " ORDER BY holiday_name";
		echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
		echo "<tr>";
		$rs = $this->dbObj->createRecordset($sql);
		$arr = $this->dbObj->fetchAssoc($rs);
		$i = 0;
		foreach($arr as $value){
			if($i%2 == 0){
				echo "</tr><tr>";
			}
			if(array_search($value['holiday_id'], $checkListHolidayTypeIdsArr) === false){
				$checked = "";
			}
			else{
				$checked = "checked";
			}
			echo "<td width=\"24\" valign=\"top\" class=\"pad-btm5 pad-top3\"><input type=\"checkbox\" name='txtHolidayType[]' value='". $value['holiday_id'] ."' class=\"RegFormChkBox\" " .$checked. "></td>";
			echo "<td width=\"260\" valign=\"top\" class=\"pad-btm5\"> " .ucwords($value['holiday_name']). " </td>";
			$i++;
		}
		echo "</table>";
	}

	// Function for creating property check list : type of holiday section
	function fun_createHolidayCheckListAccommodationType($user_id = ''){		
		$sqlCheckListAccommodationTypeIds 	= "SELECT accommodation_type FROM " . TABLE_USER_CHECKLIST_SETTINGS . " WHERE user_id='".$user_id."'";
		$rsCheckListAccommodationTypeIds 	= $this->dbObj->createRecordset($sqlCheckListAccommodationTypeIds);
		$arrCheckListAccommodationTypeIds 	= $this->dbObj->fetchAssoc($rsCheckListAccommodationTypeIds);
		$checkListAccommodationTypeIds 		= "";

		foreach($arrCheckListAccommodationTypeIds	 as $val){
			$checkListAccommodationTypeIds = $val['accommodation_type'];
		}

		$checkListAccommodationTypeIdsArr = explode(",", $checkListAccommodationTypeIds);
		
		$sql = "SELECT * FROM " . TABLE_PROPERTY_ACCOMMODATION . " ORDER BY accommodation_name";
		echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
		echo "<tr>";
		$rs = $this->dbObj->createRecordset($sql);
		$arr = $this->dbObj->fetchAssoc($rs);
		$i = 0;
		foreach($arr as $value){
			if($i%2 == 0){
				echo "</tr><tr>";
			}
			if(array_search($value['accommodation_id'], $checkListAccommodationTypeIdsArr) === false){
				$checked = "";
			}
			else{
				$checked = "checked";
			}
			echo "<td width=\"24\" valign=\"top\" class=\"pad-btm5 pad-top3\"><input type=\"radio\" name='txtAccommodationType' value='". $value['accommodation_id'] ."' class=\"RegFormChkBox\" " .$checked. "></td>";
			echo "<td width=\"260\" valign=\"top\" class=\"pad-btm5\"> " .ucwords($value['accommodation_name']). " </td>";
			$i++;
		}
		echo "</table>";
	}

	// Function for creating user check list : amenities features section
	function fun_createHolidayCheckListAmenitiesFeatures($user_id = ''){		
		$sqlCheckListAmenitiesFeaturesIds 	= "SELECT amenities_type FROM " . TABLE_USER_CHECKLIST_SETTINGS . " WHERE user_id='".$user_id."'";
		$rsCheckListAmenitiesFeaturesIds 		= $this->dbObj->createRecordset($sqlCheckListAmenitiesFeaturesIds);
		$arrCheckListAmenitiesFeaturesIds 	= $this->dbObj->fetchAssoc($rsCheckListAmenitiesFeaturesIds);
		$checkListAmenitiesFeaturesIds 		= "";

		foreach($arrCheckListAmenitiesFeaturesIds	 as $val){
			$checkListAmenitiesFeaturesIds = $val['amenities_type'];
		}

		$checkListAmenitiesFeaturesIdsArr = explode(",", $checkListAmenitiesFeaturesIds);
		
		$sql = "SELECT * FROM " . TABLE_PROPERTY_FEATURES . " ORDER BY property_features_name";
		echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
		echo "<tr>";
		$rs = $this->dbObj->createRecordset($sql);
		$arr = $this->dbObj->fetchAssoc($rs);
		$i = 0;
		foreach($arr as $value){
			if($i%3 == 0){
				echo "</tr><tr>";
			}
			if(array_search($value['property_features_id'], $checkListAmenitiesFeaturesIdsArr) === false){
				$checked = "";
			}
			else{
				$checked = "checked";
			}
			echo "<td width=\"24\" valign=\"top\" class=\"pad-btm5 pad-top3\"><input type=\"checkbox\" name='txtAmenitiesFeatures[]' value='". $value['property_features_id'] ."' class=\"RegFormChkBox\" " .$checked. "></td>";
			echo "<td width=\"260\" valign=\"top\" class=\"pad-btm5\"> " .ucwords($value['property_features_name']). " </td>";
			$i++;
		}
		echo "</table>";
	}

	// Function for creating property check list Review: type of people section
	function fun_createHolidayCheckListPeopleTypeReview($user_id = ''){		
		$sqlCheckListPeopleTypeIds 	= "SELECT holiday_ptype FROM " . TABLE_USER_CHECKLIST_SETTINGS . " WHERE user_id='".$user_id."'";
		$rsCheckListPeopleTypeIds 	= $this->dbObj->createRecordset($sqlCheckListPeopleTypeIds);
		$arrCheckListPeopleTypeIds 	= $this->dbObj->fetchAssoc($rsCheckListPeopleTypeIds);
		$checkListPeopleTypeIds = "";

		foreach($arrCheckListPeopleTypeIds as $val){
			$checkListPeopleTypeIds = $val['holiday_ptype'];
		}

		echo "<table width=\"298\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
		echo "<tr>";
		echo "<td valign=\"top\" class=\"chklistQ dash-btm\">Type of people</td>";
		echo "<td align=\"right\" valign=\"top\" class=\"dash-btm\"><a href=\"holiday-create-checklist.php?chklst=aboutyou\" class=\"Update\">Edit</a></td>";
		echo "</tr>";

		if($checkListPeopleTypeIds !=""){
			$sql = "SELECT * FROM " . TABLE_HOLIDAY_MAKER . " WHERE holiday_maker_id IN (".$checkListPeopleTypeIds.") ORDER BY holiday_maker_name";
			$rs = $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);
				$i = 0;
				foreach($arr as $value){
					if($i%1 == 0){
						echo "</tr><tr>";
					}
					echo "<td colspan=\"2\" valign=\"top\" class=\"dash-btm\"><p class=\"ChecklistSubTabTick\">" .ucwords($value['holiday_maker_name']). "</p></td>";
					$i++;
				}
			}
			else{
			echo "<tr>";
			echo "<td colspan=\"2\" valign=\"top\" class=\"dash-btm\"><p class=\"ChecklistSubTabCross\"><span class=\"red\">None selected:</span> <a href=\"holiday-create-checklist.php?chklst=aboutyou\" class=\"blue-link\">Please select</a></p></td>";
			echo "</tr>";
			}
		}
		else{
		echo "<tr>";
		echo "<td colspan=\"2\" valign=\"top\" class=\"dash-btm\"><p class=\"ChecklistSubTabCross\"><span class=\"red\">None selected:</span> <a href=\"holiday-create-checklist.php?chklst=aboutyou\" class=\"blue-link\">Please select</a></p></td>";
		echo "</tr>";
		}
		echo "</table>";
	}

	// Function for creating property check list Review: type of people section
	function fun_createHolidayCheckListHolidayTypeReview($user_id = ''){		
		$sqlCheckListHolidayTypeIds 	= "SELECT holiday_type FROM " . TABLE_USER_CHECKLIST_SETTINGS . " WHERE user_id='".$user_id."'";
		$rsCheckListHolidayTypeIds 	= $this->dbObj->createRecordset($sqlCheckListHolidayTypeIds);
		$arrCheckListHolidayTypeIds 	= $this->dbObj->fetchAssoc($rsCheckListHolidayTypeIds);
		$checkListHolidayTypeIds = "";

		foreach($arrCheckListHolidayTypeIds as $val){
			$checkListHolidayTypeIds = $val['holiday_type'];
		}

		echo "<table width=\"298\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
		echo "<tr>";
		echo "<td valign=\"top\" class=\"chklistQ dash-btm\">Type of holiday</td>";
		echo "<td align=\"right\" valign=\"top\" class=\"dash-btm\"><a href=\"holiday-create-checklist.php?chklst=holiday\" class=\"Update\">Edit</a></td>";
		echo "</tr>";

		if($checkListHolidayTypeIds !=""){
			$sql = "SELECT * FROM " . TABLE_HOLIDAY . " WHERE holiday_id IN (".$checkListHolidayTypeIds.") ORDER BY holiday_name";
			$rs = $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);
				$i = 0;
				foreach($arr as $value){
					if($i%1 == 0){
						echo "</tr><tr>";
					}
					echo "<td colspan=\"2\" valign=\"top\" class=\"dash-btm\"><p class=\"ChecklistSubTabTick\">" .ucwords($value['holiday_name']). "</p></td>";
					$i++;
				}
			}
			else{
			echo "<tr>";
			echo "<td colspan=\"2\" valign=\"top\" class=\"dash-btm\"><p class=\"ChecklistSubTabCross\"><span class=\"red\">None selected:</span> <a href=\"holiday-create-checklist.php?chklst=holiday\" class=\"blue-link\">Please select</a></p></td>";
			echo "</tr>";
			}
		}
		else{
		echo "<tr>";
		echo "<td colspan=\"2\" valign=\"top\" class=\"dash-btm\"><p class=\"ChecklistSubTabCross\"><span class=\"red\">None selected:</span> <a href=\"holiday-create-checklist.php?chklst=holiday\" class=\"blue-link\">Please select</a></p></td>";
		echo "</tr>";
		}
		echo "</table>";
	}


	// Function for creating property check list Review: type of accomadation section
	function fun_createHolidayCheckListAccommodationTypeReview($user_id = ''){		
		$sqlCheckListAccommodationTypeIds 	= "SELECT accommodation_type FROM " . TABLE_USER_CHECKLIST_SETTINGS . " WHERE user_id='".$user_id."'";
		$rsCheckListAccommodationTypeIds 	= $this->dbObj->createRecordset($sqlCheckListAccommodationTypeIds);
		$arrCheckListAccommodationTypeIds 	= $this->dbObj->fetchAssoc($rsCheckListAccommodationTypeIds);
		$checkListAccommodationTypeIds = "";

		foreach($arrCheckListAccommodationTypeIds as $val){
			$checkListAccommodationTypeIds = $val['accommodation_type'];
		}

		echo "<table width=\"298\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
		echo "<tr>";
		echo "<td valign=\"top\" class=\"chklistQ dash-btm\">Accommodation type</td>";
		echo "<td align=\"right\" valign=\"top\" class=\"dash-btm\"><a href=\"holiday-create-checklist.php?chklst=accommodation\" class=\"Update\">Edit</a></td>";
		echo "</tr>";

		if($checkListAccommodationTypeIds !=""){
			$sql = "SELECT * FROM " . TABLE_PROPERTY_ACCOMMODATION . " WHERE accommodation_id IN (".$checkListAccommodationTypeIds.") ORDER BY accommodation_name";
			$rs = $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);
				$i = 0;
				foreach($arr as $value){
					if($i%1 == 0){
						echo "</tr><tr>";
					}
					echo "<td colspan=\"2\" valign=\"top\" class=\"dash-btm\"><p class=\"ChecklistSubTabTick\">" .ucwords($value['accommodation_name']). "</p></td>";
					$i++;
				}
			}
			else{
			echo "<tr>";
			echo "<td colspan=\"2\" valign=\"top\" class=\"dash-btm\"><p class=\"ChecklistSubTabCross\"><span class=\"red\">None selected:</span> <a href=\"javascript:open_div('ChecklistSubTab', '3');void(0);\" class=\"blue-link\">Please select</a></p></td>";
			echo "</tr>";
			}
		}
		else{
		echo "<tr>";
		echo "<td colspan=\"2\" valign=\"top\" class=\"dash-btm\"><p class=\"ChecklistSubTabCross\"><span class=\"red\">None selected:</span> <a href=\"holiday-create-checklist.php?chklst=accommodation\" class=\"blue-link\">Please select</a></p></td>";
		echo "</tr>";
		}
		echo "</table>";
	}


	// Function for creating holiday check list Review: type of features section
	function fun_createHolidayCheckListAmenitiesFeaturesReview($user_id = ''){		
		$sqlCheckListAmenitiesFeaturesIds 	= "SELECT amenities_type FROM " . TABLE_USER_CHECKLIST_SETTINGS . " WHERE user_id='".$user_id."'";
		$rsCheckListAmenitiesFeaturesIds 	= $this->dbObj->createRecordset($sqlCheckListAmenitiesFeaturesIds);
		$arrCheckListAmenitiesFeaturesIds 	= $this->dbObj->fetchAssoc($rsCheckListAmenitiesFeaturesIds);
		$checkListAmenitiesFeaturesIds = "";

		foreach($arrCheckListAmenitiesFeaturesIds as $val){
			$checkListAmenitiesFeaturesIds = $val['amenities_type'];
		}

		echo "<table width=\"298\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
		echo "<tr>";
		echo "<td valign=\"top\" class=\"chklistQ dash-btm\">Amenities and Features</td>";
		echo "<td align=\"right\" valign=\"top\" class=\"dash-btm\"><a href=\"holiday-create-checklist.php?chklst=feature\" class=\"Update\">Edit</a></td>";
		echo "</tr>";

		if($checkListAmenitiesFeaturesIds !=""){
			$sql = "SELECT * FROM " . TABLE_PROPERTY_FEATURES . " WHERE property_features_id IN (".$checkListAmenitiesFeaturesIds.") ORDER BY property_features_name";
			$rs = $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);
				$i = 0;
				foreach($arr as $value){
					if($i%1 == 0){
						echo "</tr><tr>";
					}
					echo "<td colspan=\"2\" valign=\"top\" class=\"dash-btm\"><p class=\"ChecklistSubTabTick\">" .ucwords($value['property_features_name']). "</p></td>";
					$i++;
				}
			}
			else{
			echo "<tr>";
			echo "<td colspan=\"2\" valign=\"top\" class=\"dash-btm\"><p class=\"ChecklistSubTabCross\"><span class=\"red\">None selected:</span> <a href=\"holiday-create-checklist.php?chklst=feature\" class=\"blue-link\">Please select</a></p></td>";
			echo "</tr>";
			}
		}
		else{
		echo "<tr>";
		echo "<td colspan=\"2\" valign=\"top\" class=\"dash-btm\"><p class=\"ChecklistSubTabCross\"><span class=\"red\">None selected:</span> <a href=\"holiday-create-checklist.php?chklst=feature\" class=\"blue-link\">Please select</a></p></td>";
		echo "</tr>";
		}
		echo "</table>";
	}

	/*
	*  User Checklist Function : End Here
	*/

	// Function for new user array
	function fun_getPendingApprovalNewUserArr($parameter=''){
		$sql = "SELECT 	A.user_id, 
						A.user_fname,
						A.user_lname,
						A.user_email,
						FROM_UNIXTIME(A.created_on, '%m/%d/%Y') AS registered_on,
						A.is_admin, 
						A.is_moderator, 
						A.is_owner,
						A.user_status
				FROM " . TABLE_USERS . " AS A  
				WHERE A.is_admin !='1' AND 
				(DATEDIFF(FROM_UNIXTIME(A.updated_on, '%Y-%m-%d'), FROM_UNIXTIME(A.created_on, '%Y-%m-%d')) >= 8)
				";

		if($parameter!=""){
			$sql .= $parameter;
		}
		else{
			$sql .= " ORDER BY A.user_id";		
		}
		$rs = $this->dbObj->createRecordset($sql);
		return $arr = $this->dbObj->fetchAssoc($rs);		
	}

	// Function for new user array
	function fun_getCollateralUserArr($parameter=''){
		$sql = "SELECT 	A.user_id, 
						A.user_fname,
						A.user_lname,
						A.user_email,
						FROM_UNIXTIME(A.created_on, '%m/%d/%Y') AS registered_on,
						A.is_admin, 
						A.is_moderator, 
						A.is_owner,
						A.user_status
				FROM " . TABLE_USERS . " AS A  
				WHERE A.is_admin !='1'";

		if($parameter!=""){
			$sql .= $parameter;
		}
		else{
			$sql .= " ORDER BY A.user_id DESC";		
		}
//		echo $sql;
		$rs = $this->dbObj->createRecordset($sql);
		return $arr = $this->dbObj->fetchAssoc($rs);		
	}

	function fun_checkEmailAddress($emailID, $memID = ''){
		$emailFound = false;
		$sqlCheck = "SELECT user_email FROM " . TABLE_USERS . " WHERE user_email = '".fun_db_input($emailID)."' ";
		if($memID !="" && $memID > 0){
			$sqlCheck .= " AND user_id = '".fun_db_input($memID)."'";
		}				
		if($this->fun_get_num_rows($sqlCheck) > 0){
			$emailFound = true;
		}
		return $emailFound;
	}
	
	// Function for creating optionlist for languages if language_id is available it must be selected
	function fun_getLanguagesOptionsList($language_id=''){		
		$selected = "";
		$sql = "SELECT * FROM " . TABLE_LANGUAGES. " ORDER BY language_name";
		$result = $this->dbObj->fun_db_query($sql);
		while($rowsCon = $this->dbObj->fun_db_fetch_rs_object($result)){
			if($rowsCon->language_id == $language_id  && $language_id!=''){
				$selected = " selected";
			}else{
				$selected = "";
			}
			echo "<option value=".fun_db_output($rowsCon->language_id)."" .$selected. ">";
			echo fun_db_output(ucwords($rowsCon->language_name));
			echo "</option>";
		}
		$this->dbObj->fun_db_free_resultset($result);
	}

	function fun_getLanguageNameById($language_id = '') {
		if($language_id == '') {
			return false;
		} else {
			$sql = "SELECT * FROM " . TABLE_LANGUAGES. " WHERE language_id ='".$language_id."'";
			$rs 	= $this->dbObj->createRecordset($sql);
			$arr 	= $this->dbObj->fetchAssoc($rs);
			if((count($arr) > 0) && ($arr[0]['language_name'] !="")){
				return $arr[0]['language_name'];
			} {
				return false;
			}
		}
	}

	// Function for creating optionlist for property_contact_type id if no_type_id id is available it must be selected
	function fun_getUserContactNoTypeOptionsList($no_type_id=''){		
		$selected = "";
		$sql = "SELECT * FROM " . TABLE_CONTACT_NO_TYPE. " ORDER BY no_type_id";
		$result = $this->dbObj->fun_db_query($sql);
		while($rowsCon = $this->dbObj->fun_db_fetch_rs_object($result)){
			if($rowsCon->no_type_id == $no_type_id  && $no_type_id!=''){
				$selected = "selected";
			}else{
				$selected = "";
			}
			echo "<option value=\"".fun_db_output($rowsCon->no_type_id)."\" " .$selected. ">";
			echo fun_db_output(ucwords($rowsCon->no_type_name));
			echo "</option>\n";
		}
		$this->dbObj->fun_db_free_resultset($result);
	}

	// Function for creating array of user contact languages
	function fun_getUserSettingInfoArr($user_id){		
		$sql = "SELECT setting_id FROM " . TABLE_USER_SETTING_RELATIONS . " WHERE user_id ='".$user_id."' ORDER BY setting_id";
		$rs = $this->dbObj->createRecordset($sql);
		return $arr = $this->dbObj->fetchAssoc($rs);		
	}

	// Function for creating array of user contact languages
	function fun_getUserContactLanguageArr($user_id){		
		$sql = "SELECT * FROM " . TABLE_USER_CONTACT_LANGUAGES . " WHERE user_id ='".$user_id."' ORDER BY id";
		$rs = $this->dbObj->createRecordset($sql);
		return $arr = $this->dbObj->fetchAssoc($rs);		
	}

	// Function for creating array of user contact numbers
	function fun_getUserSMSNumberArr($user_id){		
		$sql = "SELECT * FROM " . TABLE_USER_SMS_NUMBERS . " WHERE user_id ='".$user_id."' ORDER BY id";
		$rs = $this->dbObj->createRecordset($sql);
		return $arr = $this->dbObj->fetchAssoc($rs);		
	}

	// Function for creating array of user contact numbers
	function fun_getUserContactNumberArr($user_id){		
		$sql = "SELECT * FROM " . TABLE_USER_CONTACT_NUMBERS . " WHERE user_id ='".$user_id."' ORDER BY id";
		$rs = $this->dbObj->createRecordset($sql);
		return $arr = $this->dbObj->fetchAssoc($rs);		
	}

	// Function for find user currency code
	function fun_getUserCurrencySymbol($currency_code){		
		$sql = "SELECT currency_symbol FROM " . TABLE_CURRENCIES . " WHERE currency_code ='".$currency_code."'";
		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr = $this->dbObj->fetchAssoc($rs);		
			return $arr[0]['currency_symbol'];		
		} else {
			return "$";
		}
	}

	// Function for find user currency code
	function fun_getUserCurrencyCode($user_id = ''){		
		if($user_id !=""){
			$sql = "SELECT currency_code FROM " . TABLE_USER_CURRENCY_SETTINGS . " WHERE user_id ='".$user_id."'";
			$rs = $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);		
				return $arr[0]['currency_code'];		
			} else {
				$sql = "SELECT user_rcountry FROM " . TABLE_USERS . " WHERE user_id ='".$user_id."'";
				$rs = $this->dbObj->createRecordset($sql);
				$arr = $this->dbObj->fetchAssoc($rs);
				
				if($arr[0]['user_rcountry'] == "195") { // USA
					return "USD";
				} else if($arr[0]['user_rcountry'] == "222") { // United Kingdom
					return "GBP";
				} else {
					return "USD";
				}
			}
		} else {
			if(isset($_SESSION['ses_user_cur_code']) && $_SESSION['ses_user_cur_code'] != "") {
				return $_SESSION['ses_user_cur_code'];
			} else {
				//$country_code = getIPCountry();
				$country_code = "USA";
				
				if(($country_code == "USA") || ($country_code == "ZZZ")) { // south africa
					return "USD";
				} else if($country_code == "GBR") { // United Kingdom
					return "GBP";
				} else {
					return "USD";
				}
			}
		}
	}


	// function for verifying user password
	function fun_verifyUserPassword($strUser, $strOldPassword){
		$sql = "SELECT * FROM " .TABLE_USERS. " WHERE user_pass='".md5($strOldPassword)."' AND user_id='".fun_db_input($strUser)."' ";
		$rs = $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			return true;		
		}
		else{
			return false;
		}
	}

	// function for update user password
	function fun_updateUserPassword($strUser, $strNewPassword){	
		$sqlUpdate = "UPDATE " . TABLE_USERS . " SET user_pass='".md5($strNewPassword)."' WHERE user_id='".(int)$strUser."'";
		if($this->dbObj->mySqlSafeQuery($sqlUpdate)){
			return true;		
		} else {
			return false;
		}

	}

	function fun_addUserEnquiryRelation($enquiry_id, $user_id, $active = '') {
        if($enquiry_id =="" || $user_id =="") {
            return false;
        } else {
            $cur_unixtime 	= time ();
            if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !=""){
                $cur_user_id 	= $_SESSION['ses_admin_id'];
            } else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !="") {
                $cur_user_id 	= $_SESSION['ses_modarator_id'];
            } else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !="") {
                $cur_user_id 	= $_SESSION['ses_user_id'];
            } else {
                $cur_user_id 	= "";
            }

			if(($user_enquiry_array = $this->fun_findRelationInfo(TABLE_USER_ENQUIRIES_RELATIONS , " WHERE user_id='".$user_id."' AND enquiry_id='".$enquiry_id."'")) && (is_array($user_enquiry_array))){
				$user_enquiry_id 		= $user_enquiry_array[0]['user_enquiry_id'];
                $field_names 			= array("updated_on", "updated_by");
                $field_values 			= array($cur_unixtime, $cur_user_id);
                $this->dbObj->updateFields(TABLE_USER_ENQUIRIES_RELATIONS, "user_enquiry_id", $user_enquiry_id, $field_names, $field_values);
			} else {
                $field_names 	= array("user_id", "enquiry_id", "created_on", "created_by", "updated_on", "updated_by", "active");
                $field_values 	= array($user_id, $enquiry_id, $cur_unixtime, $cur_user_id, $cur_unixtime, $cur_user_id, $active);
                $this->dbObj->insertFields(TABLE_USER_ENQUIRIES_RELATIONS, $field_names, $field_values);
			}
            return true;
        }
    }

	// function for update user name
	function fun_addUserbookingRelation($booking_id, $user_id, $active = '') {
        if($booking_id =="" || $user_id =="") {
            return false;
        } else {
            $cur_unixtime 	= time ();
            if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !=""){
                $cur_user_id 	= $_SESSION['ses_admin_id'];
            } else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !="") {
                $cur_user_id 	= $_SESSION['ses_modarator_id'];
            } else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !="") {
                $cur_user_id 	= $_SESSION['ses_user_id'];
            } else {
                $cur_user_id 	= "";
            }

			if(($user_booking_array = $this->fun_findRelationInfo(TABLE_USER_BOOKING_RELATIONS , " WHERE user_id='".$user_id."' AND booking_id='".$booking_id."'")) && (is_array($user_booking_array))){
				$user_booking_id 		= $user_booking_array[0]['user_booking_id'];
                $field_names 			= array("updated_on", "updated_by");
                $field_values 			= array($cur_unixtime, $cur_user_id);
                $this->dbObj->updateFields(TABLE_USER_BOOKING_RELATIONS, "user_booking_id", $user_booking_id, $field_names, $field_values);
			} else {
                $field_names 	= array("user_id", "booking_id", "created_on", "created_by", "updated_on", "updated_by", "active");
                $field_values 	= array($user_id, $booking_id, $cur_unixtime, $cur_user_id, $cur_unixtime, $cur_user_id, $active);
                $this->dbObj->insertFields(TABLE_USER_BOOKING_RELATIONS, $field_names, $field_values);
			}
            return true;
        }
    }

	// function for update user name


	function fun_updateUserSMSNumber($user_id, $sms_number_countryid, $sms_number_company, $sms_number) {
        if($user_id == "") {
            return false;
        } else {
            $cur_unixtime 	= time ();
            if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !=""){
                $cur_user_id 	= $_SESSION['ses_admin_id'];
            } else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !="") {
                $cur_user_id 	= $_SESSION['ses_modarator_id'];
            } else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !="") {
                $cur_user_id 	= $_SESSION['ses_user_id'];
            } else {
                $cur_user_id 	= "";
            }
			
			//Step I: Check if available, then update
			$sql 	= "SELECT * FROM " . TABLE_USER_SMS_NUMBERS . " WHERE user_id='".$user_id."'";
			$rs 	= $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr 	= $this->dbObj->fetchAssoc($rs);
				$id 	= $arr[0]['id'];
				$field_names 			= array("sms_number_countryid" , "sms_number_company", "sms_number", "updated_on", "updated_by");
				$field_values 			= array($sms_number_countryid, $sms_number_company, $sms_number, $cur_unixtime, $cur_user_id);
				$this->dbObj->updateFields(TABLE_USER_SMS_NUMBERS, "id", $id, $field_names, $field_values);
			} else {
			//Step II: Or Insert
				$active 		= "1";
                $field_names 	= array("id", "user_id", "sms_number_countryid", "sms_number_company", "sms_number", "created_on", "created_by", "updated_on", "updated_by", "active");
                $field_values 	= array($id, $user_id, $sms_number_countryid, $sms_number_company, $sms_number, $cur_unixtime, $cur_user_id, $cur_unixtime, $cur_user_id, $active);
                $this->dbObj->insertFields(TABLE_USER_SMS_NUMBERS, $field_names, $field_values);
			}
            return true;
        }
	}

	// function for delete user SMS number
	function fun_delUserSMSNumber($user_id) {
        if($user_id == "") {
            return false;
        } else {
			$this->dbObj->deleteRow(TABLE_USER_SMS_NUMBERS, "user_id", $user_id);
            return true;
        }
	}

	function fun_addUserResourceRelation($resource_id, $user_id, $active = '') {
        if($resource_id =="" || $user_id =="") {
            return false;
        } else {
            $cur_unixtime 	= time ();
            if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !=""){
                $cur_user_id 	= $_SESSION['ses_admin_id'];
            } else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !="") {
                $cur_user_id 	= $_SESSION['ses_modarator_id'];
            } else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !="") {
                $cur_user_id 	= $_SESSION['ses_user_id'];
            } else {
                $cur_user_id 	= "";
            }

			if(($user_resource_array = $this->fun_findRelationInfo(TABLE_USER_RESOURCES_RELATIONS , " WHERE user_id='".$user_id."' AND resource_id='".$resource_id."'")) && (is_array($user_resource_array))){
				$user_resource_id 		= $user_resource_array[0]['user_resource_id'];
                $field_names 			= array("updated_on", "updated_by");
                $field_values 			= array($cur_unixtime, $cur_user_id);
                $this->dbObj->updateFields(TABLE_USER_RESOURCES_RELATIONS, "user_resource_id", $user_resource_id, $field_names, $field_values);
			} else {
                $field_names 	= array("user_id", "resource_id", "created_on", "created_by", "updated_on", "updated_by", "active");
                $field_values 	= array($user_id, $resource_id, $cur_unixtime, $cur_user_id, $cur_unixtime, $cur_user_id, $active);
                $this->dbObj->insertFields(TABLE_USER_RESOURCES_RELATIONS, $field_names, $field_values);
			}
            return true;
        }
    }

	// This function will Return Enquiry User information in array with front end data	
	function fun_getUserEnquiryInfo($enquiry_id){		
        if($enquiry_id == "") {
            return false;
        } else {
            $sql 	= "SELECT A.enquiry_id, B.user_id, B.user_fname, B.user_lname, B.user_email 
            FROM " . TABLE_USER_ENQUIRIES_RELATIONS . " AS A 
            INNER JOIN " . TABLE_USERS . " AS B ON A.user_id = B.user_id 
            WHERE A.enquiry_id='".$enquiry_id."'";
            $rs 	= $this->dbObj->createRecordset($sql);
            if($this->dbObj->getRecordCount($rs) > 0){
                $arr 	= $this->dbObj->fetchAssoc($rs);
                return $arr[0];
            } else {
                return false;
            }
        }
	}

	function CheckUserLogin(){
		if(!isset($_SESSION['ses_user_id']) || ($_SESSION['ses_user_id'] == "")){			

			$_SESSION['ses_user_id'] 	= "";
			$_SESSION['ses_user_fname']	= "";
			$_SESSION['ses_user_email']	= "";
			$_SESSION['ses_user_pass'] 	= "";
	
			header('Location: login.php');
		}
	}

	function fun_verifyUsers($login, $pass){		
		$usersFound = false;
		$val = 1;
		$sqlCheck = "SELECT user_login FROM " . TABLE_USERS . " WHERE md5(user_login)='".md5(trim($login))."' ";
		$sqlCheck .= " AND user_pass='".md5($pass)."' AND user_activation_link='".$val."' AND user_status='".$val."'";		
		if($this->fun_get_num_rows($sqlCheck) > 0){
			$usersFound = true;
		}
		return $usersFound;
	}
	
	function fun_get_num_rows($sql){
		$totalRows = 0;
		$selected = "";
		$sql = trim($sql);
		if($sql==""){
			die("<font color='#ff0000' face='verdana' face='2'>Error: Query is Empty!</font>");
			exit;
		}
		$result = $this->dbObj->fun_db_query($sql);
		$totalRows = $this->dbObj->fun_db_get_num_rows($result);
		$this->dbObj->fun_db_free_resultset($result);
		return $totalRows;
	}

	function fun_sendNewPasswordReminderByEmail($userEmail, $userLoginPass){
		if(($user_array = $this->fun_findRelationInfo(TABLE_USERS , " WHERE user_email='".fun_db_input($userEmail)."' AND is_admin='0' ")) && (is_array($user_array))){
			//Process then
			$user_id 		= $user_array[0]['user_id'];
			$userFirstName 	= $user_array[0]['user_fname'];
			$userLoginName 	= $user_array[0]['user_login'];
			$txtSubject 	= "New User id and Password!";

$msg = '<table width="600"  border="0" cellspacing="10" cellpadding="0">';
$msg .= '<tr><td align="left"><a href="'.SITE_URL.'"><img src="'.SITE_URL.'images/logo.jpg" border="0"></a></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;Hi '.trim(ucfirst($userFirstName)).',</td></tr>
<tr><td>You recently requested a new password.</td></tr>
<tr><td>&nbsp;Login id: '.$userLoginName.'</td></tr>
<tr><td>&nbsp;Password: '.$userLoginPass.'</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>Once you have <a href="'.SITE_URL.'" style="font-family: Arial, Helvetica, sans-serif; color: #357bdc; font-size: 12px; font-weight: normal; text-decoration:none;">logged in</a> with your new password go to your homepage and click Profile and settings and then change password to something more memorable.</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>If you have any problems please <a href="'.SITE_URL.'contact-us" style="font-family: Arial, Helvetica, sans-serif; color: #357bdc; font-size: 12px; font-weight: normal; text-decoration:none;">contact us</a> and we\'ll do our best to help.</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>Thanks,</td></tr>
<tr><td>rentownersvillas.com team</td></tr>
</table>';

			$emailObj = new Email($userEmail, "Administrator | rentownersvillas.com <".SITE_ADMIN_EMAIL.">", $txtSubject, $msg);
			//$emailObj = new Email($userEmail, SITE_ADMIN_EMAIL, $txtSubject, $msg);
			if($emailObj->sendEmail()) {
				$emailObj1 = new Email("admin@rentownersvillas.com", "Administrator | rentownersvillas.com <".SITE_ADMIN_EMAIL.">", $txtSubject, $msg);
				$emailObj1->sendEmail();
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	function fun_setUserNewPasswordByEmail($userEmail){
		if(($user_array = $this->fun_findRelationInfo(TABLE_USERS , " WHERE user_email='".fun_db_input($userEmail)."' AND is_admin='0' ")) && (is_array($user_array))){
			//Process then
			$user_id 		= $user_array[0]['user_id'];
			$userFirstName 	= $user_array[0]['user_fname'];
			$userLoginName 	= $user_array[0]['user_login'];
			$userLoginPass 	= generatePassword(8);
			$this->fun_updateUserPassword($user_id, $userLoginPass);

			$txtSubject 	= "New User id and Password!";
			$txtSubject1 	= "New User id and Password!";

$msg = '<table width="600"  border="0" cellspacing="10" cellpadding="0">';
$msg .= '<tr><td align="left"><a href="'.SITE_URL.'"><img src="'.SITE_URL.'images/logo.jpg" border="0"></a></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;Hi '.trim(ucfirst($userFirstName)).',</td></tr>
<tr><td>You recently requested a new password.</td></tr>
<tr><td>&nbsp;Login id: '.$userLoginName.'</td></tr>
<tr><td>&nbsp;Password: '.$userLoginPass.'</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>Once you have <a href="'.SITE_URL.'" style="font-family: Arial, Helvetica, sans-serif; color: #357bdc; font-size: 12px; font-weight: normal; text-decoration:none;">logged in</a> with your new password go to your homepage and click Profile and settings and then change password to something more memorable.</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>If you have any problems please <a href="'.SITE_URL.'contact-us" style="font-family: Arial, Helvetica, sans-serif; color: #357bdc; font-size: 12px; font-weight: normal; text-decoration:none;">contact us</a> and we\'ll do our best to help.</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>Thanks,</td></tr>
<tr><td>rentownersvillas.com team</td></tr>
</table>';

$msg1 = '<table width="600"  border="0" cellspacing="10" cellpadding="0">';
$msg1 .= '<tr><td align="left"><a href="'.SITE_URL.'"><img src="'.SITE_URL.'images/logo.jpg" border="0"></a></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;Hi '.trim(ucfirst($userFirstName)).',</td></tr>
<tr><td>You recently requested a password reminder.</td></tr>
<tr><td>&nbsp;Login id: '.$userLoginName.'</td></tr>
<tr><td>&nbsp;Password: '.$userLoginPass.'</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>Once you have <a href="'.SITE_URL.'" style="font-family: Arial, Helvetica, sans-serif; color: #357bdc; font-size: 12px; font-weight: normal; text-decoration:none;">logged in</a> with your new password go to your homepage and click Profile and settings and then change password to something more memorable.</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>If you have any problems please <a href="'.SITE_URL.'contact-us" style="font-family: Arial, Helvetica, sans-serif; color: #357bdc; font-size: 12px; font-weight: normal; text-decoration:none;">contact us</a> and we\'ll do our best to help.</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>Thanks,</td></tr>
<tr><td>rentownersvillas.com team</td></tr>
</table>';
			$emailObj = new Email($userEmail, "Administrator | rentownersvillas.com <".SITE_ADMIN_EMAIL.">", $txtSubject, $msg);
			//$emailObj = new Email($userEmail, SITE_ADMIN_EMAIL, $txtSubject, $msg);
			if($emailObj->sendEmail()) {
				$emailObj1 = new Email("admin@rentownersvillas.com", "Administrator | rentownersvillas.com <".SITE_ADMIN_EMAIL.">", $txtSubject, $msg);
				$emailObj1->sendEmail();
				return $userLoginPass;
			} else {
				return false;
			}
/*
			$toEmail = "ashok.kumar@idns-technologies.info";
			$emailObj1 = new Email($toEmail, SITE_INFO_EMAIL, $txtSubject1, $msg1);
			if($emailObj1->sendEmail()){
				return true;
			} else {
				return false;
			}
*/
		} else {
			return false;
		}
	}

	function sendActivationEmailToUserNew($user_id) {
		if($user_id == ""){
			return false;
		} else {
			$user 		= $this->fun_getUsersInfo($user_id, '');
			$uFirstName = $user['user_fname'];
			$uEmailId 	= $user['user_email'];
			$is_owner 	= $user['is_owner'];
			$uPassword 	= $_POST['txtUserPasswrd'];
			$uid 		= base64_encode($user_id);		
			$link 		= SITE_URL."confirmation.php?uId=".$uid."";

if($is_owner == "1") { // owner message
$body = '<table width="70%"  border="0" cellspacing="10" cellpadding="0">
<tr><td>Hi '.trim(ucfirst($uFirstName)).' and thanks for registering as a holiday home owner on rentownersvillas.com.</td></tr>
<tr><td>There\'s just one more thing we need you to do.</td></tr>
<tr><td>Click this link to <a href="'.$link.'">confirm your email address</a></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>Once you do this you\'ll become a registered owner on '.$_SERVER["SERVER_NAME"].' and have access to one of the mot powerful online holiday accommodation systems in the world. As well as uploading and managing your holiday home 24.7 you\'ll have access to your very own comprehensive stats package so you can see exactly how many people are looking, saving to favourites and enquiring about your property. There\'s also lots of expert help and advice from the friendly '.$_SERVER["SERVER_NAME"].' team.</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>Thanks again</td></tr>
<tr><td>Team,</td></tr>
<tr><td>rentownersvillas.com</td></tr>
</table>';
} else {  // holiday message
$body = '<table width="70%"  border="0" cellspacing="10" cellpadding="0">
<tr><td>Hi '.trim(ucfirst($uFirstName)).' and thanks for registering as a holidaymaker on rentownersvillas.com.</td></tr>
<tr><td>There\'s just one more thing we need you to do.</td></tr>
<tr><td>Click this link to <a href="'.$link.'">confirm your email address</a></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>Once you do this you\'ll become a registered holidaymaker on '.$_SERVER["SERVER_NAME"].' and you\'ll be able to save your favourites, send them to your friends and contact lots of owners with a single enquiry. And we\'re adding super cool features all the time to make choosing your perfect holiday accommodation a breeze.</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>Thanks again</td></tr>
<tr><td>Team,</td></tr>
<tr><td>rentownersvillas.com</td></tr>
</table>';
}

			$emailObj = new Email($uEmailId, "Administrator | rentownersvillas.com <".SITE_INFO_EMAIL.">", $_SERVER["SERVER_NAME"]." registration - you're almost there!", $body);
			//$emailObj = new Email($uEmailId, SITE_INFO_EMAIL, $_SERVER["SERVER_NAME"]." registration - you're almost there!", $body);
			if($emailObj->sendEmail()){
				$emailObj1 = new Email("admin@rentownersvillas.com", SITE_INFO_EMAIL, $_SERVER["SERVER_NAME"]." registration - you're almost there!", $body);
				$emailObj1->sendEmail();
				return true;
			} else {
				return false;
			}
		}
	}

	function sendWelcomeEmailToUser($user_id) {
		if($user_id == ""){
			return false;
		} else {
			$user 		= $this->fun_getUsersInfo($user_id, '');
			$uFirstName = $user['user_fname'];
			$uEmailId 	= $user['user_email'];
			$is_owner 	= $user['is_owner'];
			$login_name	= $user['user_login'];

if($is_owner == "1") { // owner message
$body = '<table width="70%"  border="0" cellspacing="10" cellpadding="0">
<tr><td>Hi '.trim(ucfirst($uFirstName)).', congratulations and welcome to rentownersvillas.com.</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>You are now a registered owner.</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><strong>Your username is:</strong> '.$login_name.'</td></tr>
<tr><td>Adding your property to the site is super quick so login below to get started. If you have all the information at hand then you could be live within an hour. (Our record time is 18 minutes !!). And if you don\'t finish your listing this time you can save it and come back to it later.<br /><a href="'.SITE_URL.'login.php">'.SITE_URL.'login.php</a></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><strong>Add a late deal</strong></td></tr>
<tr><td>Once you\'ve uploaded a property it only takes around 2 mins to create a late deal listing. Just enter the dates and late deal price and hit submit. You\'re property then instantly goes onto our late deals board and is added to the regular late deals newsletter and RSS feeds so you\'re offer is seen by literally thousands of holidaymakers within minutes.<br /><a href="'.SITE_URL.'login.php">'.SITE_URL.'login.php</a></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><strong>Featured property</strong></td></tr>
<tr><td>One of the best ways to get seen on the site and to increase your enquiries is to create a featured property. It only takes 2 minutes to create and instantly puts you in prime position and in front of the holidaymakers who are looking for your type of accommodation.<br /><a href="'.SITE_URL.'login.php">'.SITE_URL.'login.php</a></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><strong>Tell your friends</strong></td></tr>
<tr><td>We know you\'ll love the site and we know your friends will too. Why not make their day and tell them about '.$_SERVER["SERVER_NAME"].'.</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><strong>Send us your feedback</strong></td></tr>
<tr><td>We\'d love to hear what you think about '.$_SERVER["SERVER_NAME"].'. So please send us your feedback, both good and bad, and we promise to listen.</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>Thanks again and welcome to the '.$_SERVER["SERVER_NAME"].' family</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>Team</td></tr>
<tr><td>rentownersvillas.com</td></tr>
</table>';
} else {  // holiday message
$body = '<table width="70%"  border="0" cellspacing="10" cellpadding="0">
<tr><td>Hi '.trim(ucfirst($uFirstName)).', congratulations and welcome to rentownersvillas.com.</td></tr>
<tr><td>You are now a registered holidaymaker on '.$_SERVER["SERVER_NAME"].'.</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><strong>Your username is:</strong> '.$login_name.'</td></tr>
<tr><td>So now that you\'re a registered holidaymaker probably the best way to enjoy the site is to check it out for yourself. <a href="'.SITE_URL.'">'.SITE_URL.'login.php</a></td></tr>
<tr><td>From your homepage you\'ll be able to search and save your favourites, send them to your friends and then contact owners with a single enquiry. You\'ll also have a complete history of all the enquiries you\'ve made to help you keep track of who you\'ve contacted and what you\'re enquiry said.</a></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><strong>Tell your friends</strong></td></tr>
<tr><td>We know you\'ll love the site and we know your friends will too. Why not make their day and <a href="'.SITE_URL.'">tell them about '.$_SERVER["SERVER_NAME"].'.</a></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><strong>Send us your feedback</strong></td></tr>
<tr><td>We\'d love to hear what you think about '.$_SERVER["SERVER_NAME"].'. So please <a href="'.SITE_URL.'">send us your feedback</a>, both good and bad, and we promise to listen.</td></tr>
<tr><td>Thanks again and welcome to the '.$_SERVER["SERVER_NAME"].' family</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>Team</td></tr>
<tr><td>rentownersvillas.com</td></tr>
</table>';
}
			$emailObj = new Email($uEmailId, "Administrator | rentownersvillas.com <".SITE_INFO_EMAIL.">", "Thanks for registering with ".$_SERVER["SERVER_NAME"], $body);
			//$emailObj = new Email($uEmailId, SITE_INFO_EMAIL, "Thanks for registering with ".$_SERVER["SERVER_NAME"], $body);
			if($emailObj->sendEmail()){
				$emailObj1 = new Email("admin@rentownersvillas.com", SITE_INFO_EMAIL, "Thanks for registering with ".$_SERVER["SERVER_NAME"], $body);
				$emailObj1->sendEmail();
				return true;
			} else {
				return false;
			}
		}
	}

	function sendRegistrationCompleteEmailToUser($user_id){
		if($user_id == ""){
			return false;
		} else {
			// get user info by user id
			$user 		= $this->fun_getUsersInfo($user_id, '');
			$uFirstName = $user['user_fname'];
			$uEmailId 	= $user['user_email'];
			if(isset($user['is_owner']) && $user['is_owner'] == "1") {
				$link 		= SITE_URL."owner-home.php";
			} else {
				$link 		= SITE_URL."home.php";
			}
			$uPassword 	= $_POST['txtUserPasswrd'];
			$uid 		= base64_encode($user_id);		
$body = '<table width="70%"  border="0" cellspacing="10" cellpadding="0">
<tr><td>Hi '.trim(ucfirst($uFirstName)).'. Thanks for registering and welcome to rentownersvillas.com.</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>You may have already seen the benefits of being a registered user of the site. If not, then it\'s worth taking a look <a href="'.$link.'">benefits page url here</a>.</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>If you click \'My homepage\' after you sign in you\'ll be directed to your very own homepage where you can view favourite properties, saved searches, edit your profile and settings as well as other useful stuff.</td></tr>
<tr><td>Thanks and enjoy the site,</td></tr>
<tr><td>rentownersvillas.com team</td></tr>
</table>';

			$emailObj = new Email($uEmailId, "Administrator | rentownersvillas.com <".SITE_INFO_EMAIL.">", "Thanks for registering with rentownersvillas.com", $body);
			//$emailObj = new Email($uEmailId, SITE_INFO_EMAIL, "Thanks for registering with rentownersvillas.com", $body);
			if($emailObj->sendEmail()){
				$emailObj1 = new Email("admin@rentownersvillas.com", SITE_INFO_EMAIL, "Thanks for registering with rentownersvillas.com", $body);
				$emailObj1->sendEmail();
				return true;
			} else {
				return false;
			}
		}
	}

	function sendContactUsRequestEmail(){
		$txtUsrId 		= $_POST['txtUsrId'];
		if(isset($_POST['txtPropId']) && $_POST['txtPropId'] !=""){
			$txtPropId 		= $_POST['txtPropId'];
		} else {
			$txtPropId 		= "";
		}
		
		$txtFName 		= $_POST['txtFName'];
		$txtLName 		= $_POST['txtLName'];
		$txtEmail 		= $_POST['txtContactEmail'];
		$txtEnquiryType = $_POST['txtEnquiryType'];
		switch($txtEnquiryType){
			case '1':
				$txtSubject = "General enquiry";
				$emailTo = SITE_ADMIN_EMAIL;
			break;
			case '2':
				$txtSubject = "Advertising my property";
				$emailTo = SITE_ADMIN_EMAIL;
			break;
			case '3':
				$txtSubject = "Advertising for agents";
				$emailTo = SITE_ADMIN_EMAIL;
			break;
			case '4':
				$txtSubject = "Complaints";
				$emailTo = SITE_ADMIN_EMAIL;
			break;
			case '5':
				$txtSubject = "Feedback/Testimonials";
				$emailTo = SITE_ADMIN_EMAIL;
			break;
			case '6':
				$txtSubject = "Job Opportunities";
				$emailTo = SITE_ADMIN_EMAIL;
			break;
			case '7':
				$txtSubject = "Link exchange requests";
				$emailTo = SITE_ADMIN_EMAIL;
			break;
			case '8':
				$txtSubject = "Partner/Affiliate Enquiry";
				$emailTo = SITE_ADMIN_EMAIL;
			break;
			case '9':
				$txtSubject = "Press Enquiry";
				$emailTo = SITE_ADMIN_EMAIL;
			break;
			case '10':
				$txtSubject = "Regarding a Property on the site";
				$emailTo = SITE_ADMIN_EMAIL;
			break;
			case '11':
				$txtSubject = "Technical Support";
				$emailTo = SITE_ADMIN_EMAIL;
			break;
			case '12':
				$txtSubject = "Other...";
				$emailTo = SITE_ADMIN_EMAIL;
			break;
			default:
				$txtSubject = "Other...";
				$emailTo = SITE_ADMIN_EMAIL;
		}

		// for testing
		//$emailTo 		= "info@rentownersvillas.com";

		$txtMessage 	= $_POST['txtMessage'];
$msg ='<table width="600"  border="0" cellspacing="10" cellpadding="0">';
//$msg .='<tr><td align="left"><a href="'.SITE_URL.'"><img src="'.SITE_URL.'images/logo.jpg" border="0"></a></td></tr>';
$msg .='<tr><td>&nbsp;</td></tr>
    <tr><td>&nbsp;Hi,</td></tr>
    <tr>
        <td>You have new <b>message via contact us form.</b> :- </td>
    </tr>

    <tr height="5px"><td></td></tr>
	<tr><td>&nbsp;First Name: '.$txtFName.' </td></tr>
	<tr><td>&nbsp;Last Name: '.$txtLName.' </td></tr>
	<tr><td>&nbsp;Email: '.$txtEmail.' </td></tr>
	<tr><td>&nbsp;Property Ref.: '.$txtPropId.' </td></tr>
	<tr><td>&nbsp;Subject: '.$txtSubject.' </td></tr>
    <tr height="5px"><td></td></tr>
	<tr><td>&nbsp;Message:<br>'.$txtMessage.'</td></tr>
	<tr height="10px"><td></td></tr>
</table>';
		$emailObj = new Email($emailTo, SITE_INFO_EMAIL, $txtSubject, $msg);
		if($emailObj->sendEmail()){
			return true;
		}else{
			return false;
		}
	}

	function fun_activeUsersLink($uId){
		$val = 1;
		
		//QUERY FOR ACTIVATE users_activation_link 
		$sqlUpdate = "UPDATE " . TABLE_USERS . " SET user_activation_link = '".$val."' WHERE user_id='".$uId."' ";
		
//		$this->dbObj->fun_db_query($sqlUpdate) or die("<font color='#ff0000' face='verdana' size='2'>Error: Unable to execute request!<br>Invalid Query On Users table.</font>");
		
		if($this->dbObj->fun_db_query($sqlUpdate)){
			return true;
		}else{
			return false;
		}		
	}

	function sendAddPropertyConfirmationEmailToOwner($owner_id, $property_id){
		// Step 1: Find user details
		$userDats 		= $this->fun_getUsersInfo($owner_id);
		$propertyObj 	= new Property();
		$user_fname		= ucfirst($userDats['user_fname']);
		$toMail			= ucfirst($userDats['user_email']);
/*
$msg ='<table width=\"70%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"background-color:#FFFFFF;\">
<tr>
<td align=\"left\" valign=\"top\" style=\"padding-bottom:25px;\">
<p>Dear '.$user_fname.',</p>
<p>Thanks for adding your property: <b>'.ucfirst($propertyObj->fun_getPropertyName($property_id)).' / '.fill_zero_left($property_id, "0", (6-strlen($property_id))).'</b> to '.$_SERVER["SERVER_NAME"].'.</p>
<p>Once you\'ve added your accommodation details our admin team will check your listing before putting it live on the site. Once we\'ve done this we\'ll send you an email confirming that it has been approved or in the event it is declined we will email you with our reasons why. This process normally takes no longer than 24 hours.</p>
<p>If you have any queries regarding your property then please <a href='.SITE_URL.'owner-contact-us.php?sbj=10&pid='.$property_id.' style=\"color:#357bdc; text-decoration: none;\">contact us</a> quoting reference: <b>'.fill_zero_left($property_id, "0", (6-strlen($property_id))).'</b></p>
<p><b>NOTE ABOUT PROPERTY LISTING UPGRADES:</b> If you haven\'t already done so, please remember to <a href='.SITE_URL.'owner-shopping-cart.php style=\"color: #357bdc; text-decoration: none;\">pay for your property listing upgrades</a>. We will not be able to put your &quot;featured property&quot; or &quot;Late deal&quot; listing live until you\'ve done this. If you have a promo code, then enter the code in the <b>shopping basket</b> and then <b>checkout</b>.
<p>Thanks again for adding your property; we promise to make a difference.</p>
<p>Kind regards,<br>Team,<br>'.$_SERVER["SERVER_NAME"].'</p>

<p>
Follow us on:<br>
<b>Twitter</b>: <a href=\"http://twitter.com/'.$_SERVER["SERVER_NAME"].'\" style=\"color:#357bdc; text-decoration: none;\">http://twitter.com/'.$_SERVER["SERVER_NAME"].'</a><br>
<b>Facebook</b>: <a href=\"http://www.facebook.com/pages/'.$_SERVER["SERVER_NAME"].'/116317805053042\" style=\"color:#357bdc; text-decoration: none;\">http://www.facebook.com/pages/'.$_SERVER["SERVER_NAME"].'/116317805053042</a><br>
<b>Blog</b>: <a href=\"http://blog.'.$_SERVER["SERVER_NAME"].'\" style=\"color:#357bdc; text-decoration: none;\">http://blog.'.$_SERVER["SERVER_NAME"].'</a><br>
</p>

</td>
</tr>
</table>';
*/

$msg ='<table width=\"70%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"background-color:#FFFFFF;\">
<tr>
<td align=\"left\" valign=\"top\" style=\"padding-bottom:25px;\">
<p>Dear '.$user_fname.',</p>
<p>Thanks for adding your property: <b>'.ucfirst($propertyObj->fun_getPropertyName($property_id)).' / '.fill_zero_left($property_id, "0", (6-strlen($property_id))).'</b> to '.$_SERVER["SERVER_NAME"].'.</p>
<p>Once you\'ve added your accommodation details our admin team will check your listing before putting it live on the site. Once we\'ve done this we\'ll send you an email confirming that it has been approved or in the event it is declined we will email you with our reasons why. This process normally takes no longer than 24 hours.</p>
<p>If you have any queries regarding your property then please <a href='.SITE_URL.'owner-contact-us.php?sbj=10&pid='.$property_id.' style=\"color:#357bdc; text-decoration: none;\">contact us</a> quoting reference: <b>'.fill_zero_left($property_id, "0", (6-strlen($property_id))).'</b></p>
<p><b>NOTE ABOUT PROPERTY LISTING UPGRADES:</b> If you haven\'t already done so, please remember to <a href='.SITE_URL.'owner-shopping-cart.php style=\"color: #357bdc; text-decoration: none;\">pay for your property listing upgrades</a>. We will not be able to put your &quot;featured property&quot; or &quot;Late deal&quot; listing live until you\'ve done this. If you have a promo code, then enter the code in the <b>shopping basket</b> and then <b>checkout</b>.
<p>Thanks again for adding your property; we promise to make a difference.</p>
<p>Kind regards,<br>Team,<br>'.$_SERVER["SERVER_NAME"].'</p>
</td>
</tr>
</table>';

		$emailObj = new Email($toMail , "Administrator | rentownersvillas.com <".SITE_INFO_EMAIL.">", "Property successfully added to ".$_SERVER["SERVER_NAME"], $msg);
		//$emailObj = new Email($toMail , SITE_INFO_EMAIL, "Property successfully added to ".$_SERVER["SERVER_NAME"], $msg);
		if($emailObj->sendEmail()) {
			$emailObj1 = new Email(SITE_ADMIN_EMAIL , "Administrator | rentownersvillas.com <".SITE_INFO_EMAIL.">", "Property successfully added to ".$_SERVER["SERVER_NAME"], $msg);
			$emailObj1->sendEmail();
			return true;
		} else {
			return false;
		}
	}

	function sendActivationEmail(){
		$u_id 		= $_SESSION['ses_user_id'];
		$uFirstName = $_SESSION['ses_user_fname'];
		$uEmailId 	= $_SESSION['ses_user_email'];
		$uPassword 	= $_POST['users_password'];
		$uid 		= base64_encode($u_id);		
		$link 		= SITE_URL."confirmation.php?uId=".$uid."";

$body = '<table width="70%"  border="0" cellspacing="10" cellpadding="0">
  <tr>
	<td><img src="'.SITE_URL.'images/logo.jpg" ></td>
  </tr>
  <tr>
	<td>&nbsp;Hi '.trim(ucfirst($uFirstName)).',</td>
  </tr>
  <tr>
	<td>&nbsp;Welcome to rentownersvillas.com</td>
  </tr>
   <tr>
	<td>&nbsp;Your Username: '.trim($uEmailId).' </td>
  </tr>
  <tr>
	<td>&nbsp;Your Password: '.trim($uPassword).' </td>
  </tr>
  <tr>
	<td>&nbsp;To activate your account click on this link <a href="'.$link.'">Active Account</a></td>
  </tr>
   <tr>
	<td>&nbsp;Best Regards,</td>
  </tr>
   <tr>
	<td>&nbsp;Team,<br>'.$_SERVER["SERVER_NAME"].'</td>
  </tr>	  
</table>';

/*		
		$emailTemplateFile 	= SITE_EMAIL_TAMPLATE . "activation-mail.html";
		$templateContent 	= fun_getFileContent($emailTemplateFile);
		
		$templateContent = str_replace("[%IMAGE_PATH%]", SITE_URL, $templateContent);
		$templateContent = str_replace("[%FIRST_NAME%]", trim(ucfirst($uFirstName)), $templateContent);
		$templateContent = str_replace("[%USER_NAME%]", trim($uEmailId), $templateContent);
		$templateContent = str_replace("[%PASSWORD%]", trim($uPassword), $templateContent);
		$templateContent = str_replace("[%LINK%]", $link, $templateContent);
*/
				
		$emailObj = new Email($uEmailId , "Administrator | rentownersvillas.com <".SITE_INFO_EMAIL.">", "Account Confirmation mail", $body);
		//$emailObj = new Email($uEmailId , SITE_INFO_EMAIL, "Account Confirmation mail", $body);
		if($emailObj->sendEmail()){
			$emailObj1 = new Email("admin@rentownersvillas.com", "Administrator | rentownersvillas.com <".SITE_INFO_EMAIL.">", "Account Confirmation mail", $body);
			$emailObj1->sendEmail();
			return true;
		}else{
			return false;
		}
	}

	// Function for deleting user
	function fun_delUser($user_id){
		if($user_id == ''){
			return false;
		} else {
			//Step 1 : Delete any relational data available
			// Delete from TABLE_USERS_NEWSLETTER
			$strDelQuery = "DELETE FROM " . TABLE_USER_NEWSLETTER . " WHERE user_id='".$user_id."'";
			$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

			// Delete from TABLE_USER_CONTACT_LANGUAGES
			$strDelQuery = "DELETE FROM " . TABLE_USER_CONTACT_LANGUAGES . " WHERE user_id='".$user_id."'";
			$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

			// Delete from TABLE_USER_CONTACT_NUMBERS
			$strDelQuery = "DELETE FROM " . TABLE_USER_CONTACT_NUMBERS . " WHERE user_id='".$user_id."'";
			$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

			// Delete from TABLE_USER_SMS_NUMBERS
			$strDelQuery = "DELETE FROM " . TABLE_USER_SMS_NUMBERS . " WHERE user_id='".$user_id."'";
			$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

			// Delete from TABLE_USER_CART
			$strDelQuery = "DELETE FROM " . TABLE_USER_CART . " WHERE user_id='".$user_id."'";
			$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

			// Delete from TABLE_USER_CHECKLIST_SETTINGS
			$strDelQuery = "DELETE FROM " . TABLE_USER_CHECKLIST_SETTINGS . " WHERE user_id='".$user_id."'";
			$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

			// Delete from TABLE_USER_HEARABOUTUS
			$strDelQuery = "DELETE FROM " . TABLE_USER_HEARABOUTUS . " WHERE user_id='".$user_id."'";
			$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

			// Delete from TABLE_USER_SETTING_RELATIONS
			$strDelQuery = "DELETE FROM " . TABLE_USER_SETTING_RELATIONS . " WHERE user_id='".$user_id."'";
			$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

			// Delete from TABLE_USER_FAVOURITE_PROPERTIES
			$strDelQuery = "DELETE FROM " . TABLE_USER_FAVOURITE_PROPERTIES . " WHERE user_id='".$user_id."'";
			$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

			// Delete from TABLE_USER_CURRENCY_SETTINGS
			$strDelQuery = "DELETE FROM " . TABLE_USER_CURRENCY_SETTINGS . " WHERE user_id='".$user_id."'";
			$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

			// Delete from TABLE_USER_CHECKLIST_SETTINGS_TMP
			$strDelQuery = "DELETE FROM " . TABLE_USER_CHECKLIST_SETTINGS_TMP . " WHERE user_id='".$user_id."'";
			$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

			// Delete from TABLE_USER_PROMOTION_CODES
			$strDelQuery = "DELETE FROM " . TABLE_USER_PROMOTION_CODES . " WHERE user_id='".$user_id."'";
			$this->dbObj->mySqlSafeQuery($strDelQuery); // delete previous relations

			//Step 2 : Now Delete user details
			// Delete from TABLE_USERS
			$strDelQuery = "DELETE FROM " . TABLE_USERS . " WHERE user_id='".$user_id."'";
			$this->dbObj->mySqlSafeQuery($strDelQuery);
			return true;
		}
	}
	// Function for deleting user: End Here

	// Function for user stat: Start Here
	function fun_countUserRegistrations($year, $month = '', $day = '', $confimred = '', $status = '', $is_owner = ''){
		if($year == ''){
			return false;
		} else {
			$start_date = mktime(0, 0, 0, (($month != "")?$month:1), (($day != "")?$day:1), $year);
			$end_date = mktime(23, 59, 59, (($month != "")?$month:12), (($day != "")?$day:31), $year);
			$sql = "SELECT COUNT(*) total_result FROM  " . TABLE_USERS . " WHERE created_on > ".$start_date." AND created_on < ".$end_date." ";

			if($confimred != "") {
				$sql .= " AND user_activation_link ='".$confimred."' ";
			}
			if($status != "") {
				$sql .= " AND user_status ='".$status."' ";
			}
	
			if($is_owner != "") {
				$sql .= " AND is_owner ='".$is_owner."' ";
			}

			$rs = $this->dbObj->createRecordset($sql);
			if($this->dbObj->getRecordCount($rs) > 0){
				$arr = $this->dbObj->fetchAssoc($rs);
				$total_result = $arr[0]['total_result'];
			} else {
				$total_result = 0;
			}
			return $total_result;
		}
	}


	function fun_createUserStats($year){
		if($year == ''){
			return false;
		} else {
			$strHTML 	= '';
			$strHTML 	.= '<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EventListing2">';
			$strHTML 	.= '<thead>';
			$strHTML 	.= '<tr>';
			$strHTML 	.= '<th class="left tableHeader" scope="col">&nbsp;</th>';
			$strHTML 	.= '<th align="center" class="tableHeader" scope="col">Jan</th>';
			$strHTML 	.= '<th align="center" scope="col" class="tableHeader">Feb</th>';
			$strHTML 	.= '<th align="center" scope="col" class="tableHeader">Mar</th>';
			$strHTML 	.= '<th align="center" scope="col" class="tableHeader">Apr</th>';
			$strHTML 	.= '<th align="center" scope="col" class="tableHeader">May</th>';
			$strHTML 	.= '<th align="center" scope="col" class="tableHeader">Jun</th>';
			$strHTML 	.= '<th align="center" scope="col" class="tableHeader">Jul</th>';
			$strHTML 	.= '<th align="center" scope="col" class="tableHeader">Aug</th>';
			$strHTML 	.= '<th align="center" scope="col" class="tableHeader">Sep</th>';
			$strHTML 	.= '<th align="center" scope="col" class="tableHeader">Oct</th>';
			$strHTML 	.= '<th align="center" scope="col" class="tableHeader">Nov</th>';
			$strHTML 	.= '<th align="center" class="right tableHeader" scope="col">Dec</th>';
			$strHTML 	.= '</tr>';
			$strHTML 	.= '</thead>';
			$strHTML 	.= '<tbody>';
			$strHTML 	.= '<tr>';
			$strHTML 	.= '<td align="left" class="left" width="125">Total number of NEW<br />registrations</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 1, "", "", "", "").'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 2, "", "", "", "").'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 3, "", "", "", "").'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 4, "", "", "", "").'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 5, "", "", "", "").'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 6, "", "", "", "").'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 7, "", "", "", "").'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 8, "", "", "", "").'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 9, "", "", "", "").'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 10, "", "", "", "").'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 11, "", "", "", "").'</td>';
			$strHTML 	.= '<td align="center" class="right">'.$this->fun_countUserRegistrations($year, 12, "", "", "", "").'</td>';
			$strHTML 	.= '</tr>';
			$strHTML 	.= '<tr>';
			$strHTML 	.= '<td align="left" class="left">Total number of NEW<br />confirmed registrations</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 1, "", 1, "", "").'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 2, "", 1, "", "").'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 3, "", 1, "", "").'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 4, "", 1, "", "").'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 5, "", 1, "", "").'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 6, "", 1, "", "").'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 7, "", 1, "", "").'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 8, "", 1, "", "").'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 9, "", 1, "", "").'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 10, "", 1, "", "").'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 11, "", 1, "", "").'</td>';
			$strHTML 	.= '<td align="center" class="right">'.$this->fun_countUserRegistrations($year, 12, "", 1, "", "").'</td>';
			$strHTML 	.= '</tr>';
			$strHTML 	.= '</tbody>';
			$strHTML 	.= '</table>';
			echo $strHTML;
		}
	}

	function fun_createOwnerStats($year){
		if($year == ''){
			return false;
		} else {
			$strHTML 	= '';
			$strHTML 	.= '<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EventListing2">';
			$strHTML 	.= '<thead>';
			$strHTML 	.= '<tr>';
			$strHTML 	.= '<th class="left tableHeader" scope="col">&nbsp;</th>';
			$strHTML 	.= '<th align="center" class="tableHeader" scope="col">Jan</th>';
			$strHTML 	.= '<th align="center" scope="col" class="tableHeader">Feb</th>';
			$strHTML 	.= '<th align="center" scope="col" class="tableHeader">Mar</th>';
			$strHTML 	.= '<th align="center" scope="col" class="tableHeader">Apr</th>';
			$strHTML 	.= '<th align="center" scope="col" class="tableHeader">May</th>';
			$strHTML 	.= '<th align="center" scope="col" class="tableHeader">Jun</th>';
			$strHTML 	.= '<th align="center" scope="col" class="tableHeader">Jul</th>';
			$strHTML 	.= '<th align="center" scope="col" class="tableHeader">Aug</th>';
			$strHTML 	.= '<th align="center" scope="col" class="tableHeader">Sep</th>';
			$strHTML 	.= '<th align="center" scope="col" class="tableHeader">Oct</th>';
			$strHTML 	.= '<th align="center" scope="col" class="tableHeader">Nov</th>';
			$strHTML 	.= '<th align="center" class="right tableHeader" scope="col">Dec</th>';
			$strHTML 	.= '</tr>';
			$strHTML 	.= '</thead>';
			$strHTML 	.= '<tbody>';
			$strHTML 	.= '<tr>';
			$strHTML 	.= '<td align="left" class="left" width="125">Total number of NEW<br />owners</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 1, "", "", "", 1).'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 2, "", "", "", 1).'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 3, "", "", "", 1).'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 4, "", "", "", 1).'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 5, "", "", "", 1).'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 6, "", "", "", 1).'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 7, "", "", "", 1).'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 8, "", "", "", 1).'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 9, "", "", "", 1).'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 10, "", "", "", 1).'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 11, "", "", "", 1).'</td>';
			$strHTML 	.= '<td align="center" class="right">'.$this->fun_countUserRegistrations($year, 12, "", "", "", 1).'</td>';
			$strHTML 	.= '</tr>';
			$strHTML 	.= '<tr>';
			$strHTML 	.= '<td align="left" class="left">Total number of NEW<br />confirmed owners</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 1, "", 1, "", 1).'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 2, "", 1, "", 1).'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 3, "", 1, "", 1).'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 4, "", 1, "", 1).'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 5, "", 1, "", 1).'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 6, "", 1, "", 1).'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 7, "", 1, "", 1).'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 8, "", 1, "", 1).'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 9, "", 1, "", 1).'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 10, "", 1, "", 1).'</td>';
			$strHTML 	.= '<td align="center">'.$this->fun_countUserRegistrations($year, 11, "", 1, "", 1).'</td>';
			$strHTML 	.= '<td align="center" class="right">'.$this->fun_countUserRegistrations($year, 12, "", 1, "", 1).'</td>';
			$strHTML 	.= '</tr>';
			$strHTML 	.= '</tbody>';
			$strHTML 	.= '</table>';
			echo $strHTML;
		}
	}

// This function will Return Enquiry User information in array with front end data	
	function fun_getUserBookingInfo($booking_id){		
        if($booking_id == "") {
            return false;
        } else {
            $sql 	= "SELECT A.booking_id, B.user_id, B.user_fname, B.user_lname, B.user_email 
            FROM " . TABLE_PROPERTY_BOOKINGS . " AS A 
            INNER JOIN " . TABLE_USERS . " AS B ON A.user_id = B.user_id
            WHERE A.booking_id='".$booking_id."'";
            $rs 	= $this->dbObj->createRecordset($sql);
            if($this->dbObj->getRecordCount($rs) > 0){
                $arr 	= $this->dbObj->fetchAssoc($rs);
                return $arr[0];
            } else {
                return false;
            }
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