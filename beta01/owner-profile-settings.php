<?php	
	require_once("includes/owner-top.php");
?>
<?php	
	// Form submission
	$form_array 	= array();
	$errorMsg 		= 'no';

	// Owner story submit : start here 
	if($_POST['securityKey']==md5("USERSTORY")){ 
		if(trim($_POST['txtProfileStory']) == ''){		
			$form_array['txtProfileStory'] = 'Story required';
			$errorMsg = 'yes';
		}

		if($errorMsg == 'no' && $errorMsg != 'yes') {
			$story 	= trim($_POST['txtProfileStory']);
			if($usersObj->fun_updateUserStory($user_id, $story) === true){
				echo "<script> location.href = window.location; </script>";
			} else {
				$form_array['error_msg'] = "Error: We are unable to update story!";
			}
		} else {
			$form_array['error_msg'] = "Please submit your form again!";
		}
	}
	// Owner story submit : end here 

	// Owner photos submit : start here 
	if($_POST['securityKey']==md5("USERPHOTO")){ 
		if(isset($_FILES['txtFile']) && ($_FILES['txtFile'] !="")){ // edit
			$profile_img 	= basename($_FILES['txtFile']['name']);
			$extn 			= split("\.", $profile_img);
			//print_r($extn);
			$photo_main 	= $user_id."_profilephoto.".$extn[1];
			$photo_thumb 	= $user_id."_profilethumb.".$extn[1];

			
			$uploadphotodir 	= 'upload';
			$uploadthumbdir 	= 'upload';
			$uploadphotofile 	= $uploadphotodir ."/". $photo_main;
			$uploadthumbfile163x152 	= $uploadthumbdir ."/". $photo_thumb;
			@unlink($uploadphotofile);
			@unlink($uploadthumbfile163x152);
			if (move_uploaded_file($_FILES['txtFile']['tmp_name'], $uploadphotofile)){
				$imgObj->getCrop($uploadphotodir,$photo_main,163,152,$uploadthumbfile163x152);
				if($usersObj->fun_updateUserPhoto($user_id, $photo_thumb) === true){
					echo "<script> location.href = window.location; </script>";
				} else {
					$form_array['error_msg'] = "Error: We are unable to update your photo detail!";
				}
			} else {
				$form_array['error_msg'] = "Error: We are unable to update your photo detail!";
			}
		} else {
			$form_array['error_msg'] = "Please submit your form again!";
		}
	}
	// Owner photos submit : end here 

	if($_POST['securityKey']==md5("USERPROFILE")) {		
		if(trim($_POST['txtUserFName']) == ''){		
			$form_array['txtUserFName'] = 'First Name required';
			$errorMsg = 'yes';
		}
		if(trim($_POST['txtUserLName']) == ''){		
			$form_array['txtUserLName'] = 'Last Name required';
			$errorMsg = 'yes';
		}
		if(trim($_POST['txtUserEmail']) == ''){
			$form_array['txtUserEmail'] = 'Please enter a valid email address';
			$errorMsg = 'yes';
		} else {
			if(preg_match(EMAIL_ID_REG_EXP_PATTERN, $_POST['txtUserEmail'])) {
			} else {
				$form_array['txtUserEmail'] = 'Please enter a valid email address';
				$errorMsg = 'yes';
			}
		}
		if($_POST['txtDOBDay'] == ''){		
			$form_array['txtDOBDay'] = 'Please enter a date';
			$errorMsg = 'yes';
		}
		if($_POST['txtDOBDay'] != '' && $_POST['txtDOBMonth'] == ''){
			$form_array['dobVal'] = 'Please enter a month';
			$errorMsg = 'yes';
		}
		if($_POST['txtDOBDay'] != '' && $_POST['txtDOBMonth'] != '' && $_POST['txtDOBYear'] == ''){
			$form_array['dobVal'] = 'Please enter a year';
			$errorMsg = 'yes';
		}
		if($_POST['txtDOBDay'] != '' && $_POST['txtDOBMonth'] != '' && $_POST['txtDOBYear'] != ''){
			$yyyy	= $_POST['txtDOBYear'];
			$mm		= $_POST['txtDOBMonth'];
			$dd		= $_POST['txtDOBDay'];
			$chkDob = fun_check_date($yyyy, $mm, $dd);
			if($chkDob['code'] == false){
				$form_array['dobVal'] = $chkDob['codemsg'];			
				$errorMsg = 'yes';
			}
		}	
		if($_POST['txtRCountry'] == ''){
			$form_array['txtRCountry'] = 'Please select your country';
			$errorMsg = 'yes';
		}
		if($errorMsg == 'no' && $errorMsg != 'yes') {
			$txtUserFName 	= trim($_POST['txtUserFName']);
			$txtUserLName 	= trim($_POST['txtUserLName']);
			$txtUserEmail 	= trim($_POST['txtUserEmail']);
			$txtDOBDay 		= trim($_POST['txtDOBDay']);
			$txtDOBMonth 	= trim($_POST['txtDOBMonth']);
			$txtDOBYear 	= trim($_POST['txtDOBYear']);
			$txtDOB 		= $txtDOBYear."-".$txtDOBMonth."-".$txtDOBDay;
			$txtAddress1 	= trim($_POST['txtAddress1']);
			$txtAddress2 	= trim($_POST['txtAddress2']);
			$txtTown 		= trim($_POST['txtTown']);
			$txtState 		= trim($_POST['txtState']);
			$txtZip 		= trim($_POST['txtZip']);
			$txtCountry 	= trim($_POST['txtCountry']);
			$txtRCountry 	= trim($_POST['txtRCountry']);
			if($usersObj->fun_updateUserDetails($user_id, $txtUserFName, $txtUserLName, $txtUserEmail, $txtDOB, $txtAddress1, $txtAddress2, $txtTown, $txtState, $txtZip, $txtCountry, $txtRCountry) === true){
				// For user language information
				$txtContactLanguageArr 	= $_POST['txtContactLanguage'];
				$usersObj->fun_updateUserContactLanguages($user_id, $txtContactLanguageArr);
				// For user contact information
				$txtContactNumberType 	= $_POST['txtContactNumberType'];
				$txtContactCountry 		= $_POST['txtContactCountry'];
				$txtContactNumber 		= $_POST['txtContactNumber'];
				$usersObj->fun_updateUserContactNumbers($user_id, $txtContactNumberType, $txtContactCountry, $txtContactNumber);
				// For user settings
				$settingInfoArr		= $usersObj->fun_getUserSettingInfoArr($user_id); // find existing setting
				$arr 				= array();
				for($counter = 0; $counter < count($settingInfoArr); $counter++) {
					array_push($arr, $settingInfoArr[$counter]['setting_id']);
				}
				// remove 1 and 3 from this array
				$arr1 = array_remval("1", $arr);
				$arr2 = array_remval("3", $arr1);
				$arr2 = array_remval("4", $arr2);
				$arr3 = $_POST['txtUserSetting'];
				for($counter1 = 0; $counter1 < count($arr3); $counter1++) {
					array_push($arr2, $arr3[$counter1]);
				}
				$txtPropertySMS 	= $_POST['txtPropertySMS'];
				if($txtPropertySMS !=""){
					array_push($arr2, $txtPropertySMS);
					$sms_number_countryid 	= trim($_POST['txtPropertySMSCountry']);
//					$sms_number_company 	= trim($_POST['txtPropertySMSCompany']);
					$sms_number_company 	= "0";
					$sms_number 			= trim($_POST['txtPropertySMSNumber']);
					if($sms_number != "" && $sms_number_company != "" && $sms_number_countryid != ""){
						$usersObj->fun_updateUserSMSNumber($user_id, $sms_number_countryid, $sms_number_company, $sms_number);
					}
				} else {
					$usersObj->fun_delUserSMSNumber($user_id);
				}
				array_unique($arr2);
				$usersObj->fun_updateUserSettings($user_id, $arr2);
			}
			redirectURL(SITE_URL."owner-profile-settings");
		} else {
			$form_array['error_msg'] = "Please submit your form again!";
		}
	}

	$userInfoArr 		= $usersObj->fun_getUsersInfo($user_id);
	$users_first_name 	= $userInfoArr['user_fname'];
	$users_last_name 	= $userInfoArr['user_lname'];
	$users_email_id 	= $userInfoArr['user_email'];
	$user_full_name 	= $users_first_name." ".$users_last_name;
	list($txtDOBMonth, $txtDOBDay, $txtDOBYear) = split('[/.-]', date('m-d-Y', strtotime($userInfoArr['user_dob'])));			
	$txtAddress1 		= $userInfoArr['user_address1'];
	$txtAddress2 		= $userInfoArr['user_address2'];
	$txtTown 			= $userInfoArr['user_town'];
	$txtState 			= $userInfoArr['user_state'];
	$txtZip 			= $userInfoArr['user_zip'];
	$country_id 		= $userInfoArr['user_country'];
	$rcountry_id 		= $userInfoArr['user_rcountry'];
	//user contact number
	$userContactInfoArr	= $usersObj->fun_getUserContactNumberArr($user_id);
	//user languages
	$userLanguageInfoArr	= $usersObj->fun_getUserContactLanguageArr($user_id);
	//user sms
	$userSMSInfoArr			= $usersObj->fun_getUserSMSNumberArr($user_id);
	$sms_number_countryid 	= $userSMSInfoArr[0]['sms_number_countryid'];
	$sms_number_company	  	= $userSMSInfoArr[0]['sms_number_company'];
	$sms_number 		  	= $userSMSInfoArr[0]['sms_number'];
	$sms_number_active 	  	= $userSMSInfoArr[0]['sms_number_active'];
	//user setting
	$userSettingInfoArr	  = $usersObj->fun_getUserSettingInfoArr($user_id);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo $sitetitle;?> :: Owner :: Profile and Settings</title>
    <link href="<?php echo SITE_CSS_INCLUDES_PATH;?>owner.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>owner.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>pop-up.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>common.js"></script>
    <script type="text/javascript" language="JavaScript" src="<?php echo SITE_JS_INCLUDES_PATH;?>dargPop.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>dhtmlwindow.js"></script>
    <script type="text/javascript" language="javascript">
	var req = ajaxFunction();
	var x, y;
	function show_coords(event){	
		x=event.clientX;
		y=event.clientY;
		x = x-160;
		y = y+4;
		//alert(x);alert(y);
	}

	function validateSMSNumber() { 
		var mob = document.getElementById('txtPropertySMSNumberId').value;
		var country = document.getElementById('txtPropertySMSCountryId').value;
		if(mob != "" && country != "") {
			req.onreadystatechange = function() {
				if (req.readyState==4) {
					var response = req.responseText; 
					xmlDoc = req.responseXML;
					var root = xmlDoc.getElementsByTagName('validate')[0];
					if(root != null) {
						var status = root.getElementsByTagName("status")[0].firstChild.nodeValue;
						if(status == "done"){
							document.getElementById("showErrorSMS").innerHTML = "<span style=\"font-size:12px; color:#FF0000; font-weight:bold;\">Valid number</span>";
						} else {
							document.getElementById("showErrorSMS").innerHTML = "<span style=\"font-size:12px; color:#FF0000; font-weight:bold;\">Invalid number</span>";
						}
					}
				}
			}
			req.open('get', 'includes/ajax/validateNumberForSMSXML.php?mob=' + mob +'&country=' + country); 
			req.send(null); 
		}
	}

    function validateSaveProfile(){
        if(document.getElementById("txtUserFNameId").value == "") {
            document.getElementById("showErrorUserFNameId").innerHTML = "First Name required";
            document.getElementById("txtUserFNameId").focus();
            return false;
        }
        if(document.getElementById("txtUserLNameId").value == "") {
            document.getElementById("showErrorUserLNameId").innerHTML = "Last Name required";
            document.getElementById("txtUserLNameId").focus();
            return false;
        }
        if(document.getElementById("txtUserEmailId").value == "") {
            document.getElementById("showErrorUserEmailId").innerHTML = "Please enter a valid email address";
            document.getElementById("txtUserEmailId").focus();
            return false;
        }
		document.frmUserProfile.submit();
    }

	function showChangePassword(str) {
		var str = str;
		if(str == 1){
			document.getElementById("showchangepassLinkId").style.display = "none";
			document.getElementById("showchangepassId").style.display = "block";
		} else if(str == 0){
			document.getElementById("showchangepassLinkId").style.display = "block";
			document.getElementById("showchangepassId").style.display = "none";
		}
	}
    
    function chkblnkTxtError(strFieldId, strErrorFieldId) {
        if(document.getElementById(strFieldId).value != "") {
            document.getElementById(strErrorFieldId).innerHTML = "";
        }
    }

    function cancelChangeProfile() {
        window.location = '<?php echo SITE_URL."owner-profile-settings"; ?>';
    }

	function changePassword(){
		var strOldPassword = document.getElementById("txtOldPasswordId").value;
		var strNewPassword = document.getElementById("txtNewPasswordId").value;
		var strConfirmPassword = document.getElementById("txtConfirmPasswordId").value;
		var strUserId = document.getElementById("txtUserId").value;
		if(document.getElementById("txtOldPasswordId").value == ""){
			document.getElementById("showErrorOldPassword").innerHTML = "<span style=\"font-size:12px; color:#FF0000; font-weight:normal;\">Incorrect old password: Passwords do not match, please try again</span>";
			document.getElementById("txtOldPasswordId").focus();
			return false;
		}
		if(document.getElementById("txtNewPasswordId").value == ""){
			document.getElementById("showErrorConfirmPassword").innerHTML = "<span style=\"font-size:12px; color:#FF0000; font-weight:normal;\">New passwords is blank: Passwords do not match, please try again</span>";
			document.getElementById("txtNewPasswordId").focus();
			return false;
		}
		if(document.getElementById("txtNewPasswordId").value.length < 6){
			document.getElementById("showErrorConfirmPassword").innerHTML = "<span style=\"font-size:12px; color:#FF0000; font-weight:normal;\">New passwords can not be less than six character, please try again</span>";
			document.getElementById("txtNewPasswordId").focus();
			return false;
		}
		if(document.getElementById("txtConfirmPasswordId").value == ""){
			document.getElementById("showErrorConfirmPassword").innerHTML = "<span style=\"font-size:12px; color:#FF0000; font-weight:normal;\">Confirm passwords do not match: Passwords do not match, please try again</span>";
			document.getElementById("txtConfirmPasswordId").focus();
			return false;
		}
		if(document.getElementById("txtConfirmPasswordId").value != document.getElementById("txtNewPasswordId").value){
			document.getElementById("showErrorConfirmPassword").innerHTML = "<span style=\"font-size:12px; color:#FF0000; font-weight:normal;\">Confirm password not matched</span>";
			document.getElementById("txtConfirmPasswordId").focus();
			return false;
		}
		sendChangePasswordRequest(strUserId, strOldPassword, strNewPassword);
		return false;
	}

	function sendChangePasswordRequest(strUserId, strOldPassword, strNewPassword) { 
		req.open('get', 'changeuserpasswordAjax.php?usr=' + strUserId + '&oldpass=' + strOldPassword + '&newpass=' + strNewPassword); 
		req.onreadystatechange = handleChangePasswordResponse; 
		req.send(null); 
	} 

	function handleChangePasswordResponse() { 
		var arrayOfUserStatus = new Array();
		if(req.readyState == 4)	{
			var response = req.responseText; 
			xmlDoc = req.responseXML;
			var root = xmlDoc.getElementsByTagName('users')[0];
			if(root != null) {
				var items = root.getElementsByTagName("user");
				for (var i = 0 ; i < items.length ; i++) {
					var item = items[i];
					var status = item.getElementsByTagName("status")[0].firstChild.nodeValue;
					arrayOfUserStatus[i] = status;
				}
				if(arrayOfUserStatus[0] == "password changed") {
					showChangePassword(0);
					document.getElementById("showchangepassLinkId1").innerHTML="<span style=\"font-size:12px; color:#FF0000; font-weight:normal;\">Password changed successfully</span>";
					return false;
				} else if(arrayOfUserStatus[0] == "password wrong") {
					document.getElementById("showErrorConfirmPassword").innerHTML="<span style=\"font-size:12px; color:#FF0000; font-weight:normal;\">Incorrect old password: Passwords do not match, please try again</span>";
				} else if(arrayOfUserStatus[0] == "failed") {
					document.getElementById("showErrorConfirmPassword").innerHTML="<span style=\"font-size:12px; color:#FF0000; font-weight:normal;\">New passwords do not match: Passwords do not match, please try again</span>";
				}
			} else {
				document.getElementById("showErrorConfirmPassword").innerHTML="<span style=\"font-size:12px; color:#FF0000; font-weight:normal;\">New passwords do not match: Passwords do not match, please try again</span>";
			}
		} else {
			document.getElementById("showErrorConfirmPassword").innerHTML="<span style=\"font-size:12px; color:#FF0000; font-weight:normal;\">Please wait...</span>";
		}
	} 
    </script>
	<script type="text/javascript" language="javascript">
    function showRow(strId){
        var strId = strId;
        document.getElementById(strId).style.display = "block";
    }

    function removeContactNumber(strId) {
        var strNumberId = "txtContactNumber"+strId;
        document.getElementById(strNumberId).value = "";
        document.frmPropertyContacts.submit();
    }

	function editProfilePhoto() {
        document.frmUserPhoto.submit();
	}

	function editProfileStory() {
        document.frmUserStory.submit();
	}

    function addEvent() {
		var strTable = "";
		var ni = document.getElementById('myDiv');
		var numi = document.getElementById('theValue');
		var num = (document.getElementById("theValue").value -1)+ 2;
		numi.value = num;
		var divIdName = "my"+num+"Div";
		var strcontype = "<?php $propertyObj->fun_getPropertyContactNoTypeOptionsList(); ?>";
		var strconnamefav = "<?php $propertyObj->fun_getCountriesISDOptionsList('', " WHERE countries_name IN ('United States', 'United Kingdom') ORDER BY countries_name IN ('United States', 'United Kingdom')"); ?>";
		var strconname = "<?php $propertyObj->fun_getCountriesISDOptionsList(); ?>";
		var newdiv = document.createElement('div');
		newdiv.setAttribute("id",divIdName);
		strTable += "<table cellspacing='0' cellpadding='0'>";
		strTable += "<tr>";
		strTable += "<td colspan='4' height='5'>";
		strTable += "</td>";
		strTable += "</tr>";
		strTable += "<tr>";
		strTable += "<td align='left'>";
		strTable += "<select name='txtContactNumberType[]' class='NumberType'>";
		strTable += "<option value=''>Select Type</option>";
		strTable += strcontype;
		strTable += "</select>";
		strTable += "<td class='pad-lft10'>";
		strTable += "<select name='txtContactCountry[]' id='txtContactCountryId' class='select128'>";
		strTable += "<option value='' style='font-style:normal; background-color:#D0E0F1;COLOR:#000000' disabled='disabled' selected='selected'>Select Country ...</option>";
		strTable += strconnamefav;
		strTable += "<option value='' style='font-style:normal;background-color:#D0E0F1;COLOR:#000000' disabled='disabled'> ---------------------------------------------- </option>";
		strTable += strconname;
		strTable += "</select>";
		strTable += "</td>";
		strTable += "<td class='pad-lft10'><input type='text' name='txtContactNumber[]' class='ContactNumber' maxlength='15' /></td>";
		strTable += "<td class='pad-lft10 pad-top1' valign='middle'><a href=\"javascript:;\" class='delete-photo' onclick=\"removeElement(\'"+divIdName+"\')\">Delete</a></td>";
		strTable += "</tr>";
		strTable += "</table>";
		newdiv.innerHTML = strTable;
		ni.appendChild(newdiv);
    }

    function removeElement(divNum) {
		var d = document.getElementById('myDiv');
		var olddiv = document.getElementById(divNum);
		d.removeChild(olddiv);
    }

    function addEvent1() {
		var strTable1 = "";
		var ni = document.getElementById('myDiv1');
		var numi = document.getElementById('theValue');
		var num = (document.getElementById("theValue").value -1)+ 2;
		numi.value = num;
		var divIdName = "my"+num+"Div";
		var strlang = "<?php $usersObj->fun_getLanguagesOptionsList(); ?>";
		var newdiv = document.createElement('div');
		newdiv.setAttribute("id",divIdName);
		strTable1 += "<table cellspacing='0' cellpadding='0'>";
		strTable1 += "<tr>";
		strTable1 += "<td height='5'>";
		strTable1 += "</td>";
		strTable1 += "</tr>";
		strTable1 += "<tr>";
		strTable1 += "<td align='left'>";
		strTable1 += "<select name='txtContactLanguage[]' class='select230'>";
		strTable1 += "<option value='' style='font-style:normal; background-color:#D0E0F1;COLOR:#000000' disabled='disabled' selected='selected'>Select Language ...</option>";
		strTable1 += strlang;
		strTable1 += "</select>";
		strTable1 += "</td>";
		strTable1 += "<td class='pad-lft10 pad-top1' valign='middle'> <a href=\"javascript:;\" class='delete-photo' onclick=\"removeElement1(\'"+divIdName+"\')\">Delete</a></td>";
		strTable1 += "</tr>";
		strTable1 += "</table>";
		newdiv.innerHTML = strTable1;
		ni.appendChild(newdiv);
    }

    function removeElement1(divNum) {
		var d = document.getElementById('myDiv1');
		var olddiv = document.getElementById(divNum);
		d.removeChild(olddiv);
    }
    </script>
</head>
<body>
<!-- Main Wrapper Starts Here -->
<div id="wrapper">
    <!-- Header Include Starts Here -->
    <div id="header" align="center">
        <?php require_once(SITE_INCLUDES_PATH.'header.php'); ?>
    </div>
    <!-- Header Include End Here -->
	<?php require_once(SITE_INCLUDES_PATH.'holidayadvsearch.php'); ?>
	<?php //require_once(SITE_INCLUDES_PATH.'breadcrumb.php'); ?>
    <div id="pg-wrapper" align="center"><h1 class="page-heading"><?php echo tranText('my_profile_settings'); ?></h1></div>
    <div id="main">
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="left" valign="top">
					<?php require_once(SITE_INCLUDES_PATH.'owner-left-links.php'); ?>
                </td>
                <td width="30" align="left" valign="top" style="border-right:thin #efefef solid;">&nbsp;</td>
                <td align="left" valign="top" class="font12" style="padding-left:10px;">
					<?php require_once(SITE_INCLUDES_PATH.'ownerprofile.php'); ?>
                </td>
            </tr>
        </table>
    </div>
</div>
<!-- Main Wrapper End Here -->
<!-- Footer Include Starts Here -->
<div id="footer">
    <?php require_once(SITE_INCLUDES_PATH.'footer.php'); ?>
</div>
<!-- Footer Include End Here -->
</body>
</html>
