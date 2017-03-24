<?php
class Testimonial{
	var $dbObj;
	
	function Testimonial(){ // class constructor
		$this->dbObj = new DB();
		$this->dbObj->fun_db_connect();
	}
	
	// This function will Return Testimonials information in array with front end data
	function fun_getTestimonialsArr($parameter = '') {
		$sql 		= "SELECT A.testimonial_id, 
							A.testimonial_name, 
							A.testimonial_description,
							A.site_rating,
							A.user_fname,
							A.user_lname,
							A.user_email,
							A.user_country,
							A.status,
							A.active_on,
							A.active_by,
							A.created_on,
							A.created_by,
							A.updated_on,
							A.updated_by,
							A.active
						FROM " . TABLE_TESTIMONIALS . " AS A
						WHERE A.active ='1' AND A.status ='2'";

		if($parameter != ""){
			$sql .= $parameter;
		} else {
			$sql .= " ORDER BY A.testimonial_id";		
		}
		return $rs = $this->dbObj->createRecordset($sql);
	}

	// function for user registration
	function fun_addTestimonial($testimonial_name, $testimonial_description, $site_rating, $user_fname, $user_lname, $user_email, $user_country) {
        $status = "1";
        $active = "0";
        $cur_unixtime 			= time ();
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

        $field_names 			= array("testimonial_name", "testimonial_description", "site_rating", "user_fname", "user_lname", "user_email", "user_country", "status", "active_on", "active_by", "created_on", "created_by", "updated_on", "updated_by", "active");
        $field_values 			= array(fun_db_input($testimonial_name), fun_db_input($testimonial_description), fun_db_input($site_rating), fun_db_input($user_fname), fun_db_input($user_lname), fun_db_input($user_email), fun_db_input($user_country), fun_db_input($status), fun_db_input($cur_unixtime), fun_db_input($cur_user_id), fun_db_input($cur_unixtime), fun_db_input($cur_user_id), fun_db_input($cur_unixtime), fun_db_input($cur_user_id), fun_db_input($active));
        $this->dbObj->insertFields(TABLE_TESTIMONIALS, $field_names, $field_values);
        $testimonial_id 			= $this->dbObj->getIdentity();
        return $testimonial_id;
	}


	function fun_editTestimonial($testimonial_id, $testimonial_name, $testimonial_description, $site_rating, $user_fname, $user_lname, $user_email, $user_country, $status) {
        $status = "1";
        $active = "1";
        $cur_unixtime 			= time ();
		if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !="") {
			$cur_user_id 	= $_SESSION['ses_admin_id'];
		} else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !="") {
			$cur_user_id 	= $_SESSION['ses_modarator_id'];
		} else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !="") {
			$cur_user_id 	= $_SESSION['ses_user_id'];
		} else {
			$cur_user_id 	= "";
		}

        $field_names 			= array("testimonial_name", "testimonial_description", "site_rating", "user_fname", "user_lname", "user_email", "user_country", "status", "active_on", "active_by", "created_on", "created_by", "updated_on", "updated_by", "active");
        $field_values 			= array(fun_db_input($testimonial_name), fun_db_input($testimonial_description), fun_db_input($site_rating), fun_db_input($user_fname), fun_db_input($user_lname), fun_db_input($user_email), fun_db_input($user_country), fun_db_input($status), fun_db_input($cur_unixtime), fun_db_input($cur_user_id), fun_db_input($cur_unixtime), fun_db_input($cur_user_id), fun_db_input($cur_unixtime), fun_db_input($cur_user_id), fun_db_input($active));
        $this->dbObj->updateFields(TABLE_TESTIMONIALS, "testimonial_id", $testimonial_id, $field_names, $field_values);
        return $testimonial_id;
	}

	// This function will Return Testimonial information in array with front end data	
	function fun_getTestimonialInfo($testimonial_id){		
		$sql 	= "SELECT * FROM " . TABLE_TESTIMONIALS . " WHERE testimonial_id='".$testimonial_id."'";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr 	= $this->dbObj->fetchAssoc($rs);
			return $arr[0];
		} else {
			return false;
		}
	}

	// This function will Return Testimonial information in array with front end data	
	function fun_getTestimonialUserInfo($testimonial_id){		
		$sql 	= "SELECT B.user_fname, B.user_lname, B.user_email 
				FROM " . TABLE_USER_TESTIMONIAL_RELATIONS . " AS A 
				INNER JOIN " . TABLE_USERS . " AS B ON A.user_id = B.user_id 
				WHERE A.testimonial_id='".$testimonial_id."'";
		$rs 	= $this->dbObj->createRecordset($sql);
		if($this->dbObj->getRecordCount($rs) > 0){
			$arr 	= $this->dbObj->fetchAssoc($rs);
			return $arr[0];
		} else {
			return false;
		}
	}

	function fun_delTestimonial($testimonial_id){
		$this->dbObj->deleteRow(TABLE_TESTIMONIALS, "testimonial_id", $testimonial_id);
		$this->dbObj->deleteRow(TABLE_USER_TESTIMONIAL_RELATIONS, "testimonial_id", $testimonial_id);
		return true;
	}

	// Function for new user array
	function fun_getPendingApprovalTestimonialsArr($parameter=''){
		$sql 		= "SELECT A.testimonial_id, 
							A.testimonial_name, 
							A.testimonial_description, 
							A.site_rating,
							A.user_fname,
							A.user_lname,
							A.user_email,
							A.user_country,
							A.status,
							B.status_name,
							A.created_on,
							A.updated_on,
							A.active
						FROM " . TABLE_TESTIMONIALS . " AS A
						INNER JOIN " . TABLE_TESTIMONIALS_STATUS . " AS B ON A.status = B.status_id 
						";
		if($parameter!=""){
			$sql .= $parameter;
		} else {
			$sql .= " ORDER BY A.updated_on";		
		}
		
		$rs = $this->dbObj->createRecordset($sql);
        return $arr = $this->dbObj->fetchAssoc($rs);
	}

	function fun_getTestimonialCatName($resources_categories_id){
		$resources_categories_name = $this->dbObj->getField(TABLE_RESOURCES_CATEGORIES, "resources_categories_id", $resources_categories_id, "resources_categories_name");
		return $resources_categories_name;
	}

	function fun_sendTestimonialNotification($testimonial_id, $testimonial_title, $user_fname, $user_email) {
		if($user_email == '' || $user_fname  == '') {
			return false;
		} else {
			$msg = '<table width="600" border="0" cellspacing="0" cellpadding="0">';
//			$msg .= '<tr><td align="center"><img src="'.SITE_URL.'images/banner-560x77.jpg" width="600" height="84"></td></tr>';
			$msg .= '<tr><td>&nbsp;</td></tr>
			<tr><td><strong>Hi '.$user_fname.',</strong></td></tr>
			<tr><td>We have received your testimonial and are now busy processing it. We will send you a confirmation email as soon as we have approved it. This could take up to 48 hours, especially at weekends.</td></tr>
			<tr><td>Thanks for your continued support.</td></tr>
			<tr><td>Regards</td></tr>
			<tr><td>'.$_SERVER["SERVER_NAME"].'</td></tr>';
			$msg .= '</table>';
		
			$emailObj = new Email($user_email, "Manager | rentownersvillas.com <".SITE_INFO_EMAIL.">", $_SERVER["SERVER_NAME"]." confirmation", $msg);
			//$emailObj = new Email($user_email, SITE_INFO_EMAIL, $_SERVER["SERVER_NAME"]." confirmation", $msg);
			if($emailObj->sendEmail()) {
				//$emailObj1 = new Email("info@rentownersvillas.com", SITE_INFO_EMAIL, $_SERVER["SERVER_NAME"]." confirmation", $msg);
				//$emailObj1->sendEmail();
				return true;
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
		}
		else{
			return false;
		}
	}
}
?>