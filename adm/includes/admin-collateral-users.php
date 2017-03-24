<?php 
$dayname 	= array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');
$monthname 	= array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec');
$yearname 	= array();
$yearname1 	= array(date('Y')+0,date('Y')+1,date('Y')+2,date('Y')+3);
$startYear	= date('Y') - 100;
$endYear	= date('Y') - 16;
for($counter = $endYear; $counter >= $startYear; $counter--) {
	array_push($yearname, $counter);
}
?>
<?php	
// Form submission
$form_array = array();
$errorMsg 	= 'no';
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
		$user_id 		= trim($_POST['txtUserId']);
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
		echo "<script>location.href = window.location;</script>";
	} else {
		$form_array['error_msg'] = "Please submit your form again!";
	}
}

if(isset($user_id) && $user_id !=""){
	if(isset($_GET['act']) && $_GET['act'] =="edit") {
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
		<script language="javascript" type="text/javascript">
			var req = ajaxFunction();
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
					req.open('get', '../includes/ajax/validateNumberForSMSXML.php?mob=' + mob +'&country=' + country); 
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
			function changePassword(){
//				var strOldPassword = document.getElementById("txtOldPasswordId").value;
				var strNewPassword = document.getElementById("txtNewPasswordId").value;
				var strConfirmPassword = document.getElementById("txtConfirmPasswordId").value;
				var strUserId = document.getElementById("txtUserId").value;
/*
				if(document.getElementById("txtOldPasswordId").value == ""){
					document.getElementById("showErrorOldPassword").innerHTML = "<span style=\"font-size:12px; color:#FF0000; font-weight:normal;\">Incorrect old password: Passwords do not match, please try again</span>";
					document.getElementById("txtOldPasswordId").focus();
					return false;
				}
*/
				if(document.getElementById("txtNewPasswordId").value == ""){
					document.getElementById("showErrorConfirmPassword").innerHTML = "<span style=\"font-size:12px; color:#FF0000; font-weight:normal;\">New passwords do not match: Passwords do not match, please try again</span>";
					document.getElementById("txtNewPasswordId").focus();
					return false;
				}
				if(document.getElementById("txtNewPasswordId").value.length < 6){
					document.getElementById("showErrorConfirmPassword").innerHTML = "<span style=\"font-size:12px; color:#FF0000; font-weight:normal;\">New passwords can not be less than six character, please try again</span>";
					document.getElementById("txtNewPasswordId").focus();
					return false;
				}
				if(document.getElementById("txtConfirmPasswordId").value == ""){
					document.getElementById("showErrorConfirmPassword").innerHTML = "<span style=\"font-size:12px; color:#FF0000; font-weight:normal;\">New passwords do not match: Passwords do not match, please try again</span>";
					document.getElementById("txtConfirmPasswordId").focus();
					return false;
				}
				if(document.getElementById("txtConfirmPasswordId").value != document.getElementById("txtNewPasswordId").value){
					document.getElementById("showErrorConfirmPassword").innerHTML = "<span style=\"font-size:12px; color:#FF0000; font-weight:normal;\">Confirm password not matched</span>";
					document.getElementById("txtConfirmPasswordId").focus();
					return false;
				}
				sendChangePasswordRequest(strUserId, strNewPassword);
				return false;
			}
			function sendChangePasswordRequest(strUserId, strNewPassword) { 
				req.open('get', 'includes/ajax/admin-user-passwordAjax.php?usr=' + strUserId + '&newpass=' + strNewPassword); 
				req.onreadystatechange = handleChangePasswordResponse; 
				req.send(null); 
			} 
			function handleChangePasswordResponse() { 
				var arrayOfUserStatus = new Array();
				if(req.readyState == 4)	{
					var response=req.responseText; 
					xmlDoc=req.responseXML;
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
		<form name="frmEditUser" id="frmEditUser" method="post" action="admin-collateral.php?sec=resuser" enctype="multipart/form-data">
		<input type="hidden" name="securityKey" id="securityKey" value="<?php echo md5("USERPROFILE")?>">
		<input type="hidden" name="txtUserId" id="txtUserId" value="<?php echo $user_id; ?>">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
			<tr><td height="10" colspan="2" valign="top">&nbsp;</td></tr>
			<tr>
				<td valign="top"><a href="admin-collateral.php?sec=resuser" class="back">Back to List</a></td>
				<td align="right" valign="top">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2" valign="top" class="pad-top5">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
						<tr>
							<td valign="top" class="pad-top7">
								<table width="690" border="0" cellspacing="0" cellpadding="0" class="font12">
									<tr>
										<td align="left" valign="top">
											<table width="100%" border="0" cellspacing="0" cellpadding="10" class="eventForm">
                                                <tr>
                                                    <td colspan="2" align="right" valign="top" class="header">
														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td align="right" valign="bottom" colspan="2">
																	<a href="admin-collateral.php?sec=resuser" style="text-decoration: none;"><img src="images/cancelN.png" alt="Cancel" border="0" height="21" width="66"></a>&nbsp;<input type="image" src="images/saveChangesN.png" alt="Save approve" name="SaveChange" width="108" height="21" border="0" id="SaveChangeId"  onclick="return validateSaveProfile();">
																</td>
															</tr>
														</table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" valign="top">
                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td valign="top">
<!-- Edit section start here -->
<table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr>
        <td width="155" align="right" valign="middle">First name</td>
        <td width="235" valign="middle"><span class="RegFormRight"><input name="txtUserFName" type="text" class="RegFormFldowner" id="txtUserFNameId" value="<?php if(isset($_POST['txtUserFName'])){echo $_POST['txtUserFName'];}else{echo $userInfoArr['user_fname'];}?>" onkeydown="chkblnkTxtError('txtUserFNameId', 'showErrorUserFNameId');" onkeyup="chkblnkTxtError('txtUserFNameId', 'showErrorUserFNameId');" /></span></td>
        <td width="274" valign="top"><span class="pdError1" id="showErrorUserFNameId"><?php if(array_key_exists('txtUserFName', $form_array)) echo $form_array['txtUserFName'];?></span></td>
    </tr>
    <tr>
        <td width="155" align="right" valign="middle">Last name</td>
        <td width="235" valign="middle"><span class="RegFormRight"><input name="txtUserLName" type="text" class="RegFormFldowner" id="txtUserLNameId" value="<?php if(isset($_POST['txtUserLName'])){echo $_POST['txtUserLName'];}else{echo $userInfoArr['user_lname'];}?>" onkeydown="chkblnkTxtError('txtUserLNameId', 'showErrorUserLNameId');" onkeyup="chkblnkTxtError('txtUserLNameId', 'showErrorUserLNameId');" /></span></td>
        <td width="274" valign="top"><span class="pdError1" id="showErrorUserLNameId"><?php if(array_key_exists('txtUserLName', $form_array)) echo $form_array['txtUserLName'];?></span></td>
    </tr>
    <tr>
        <td width="155" align="right" valign="middle">Email address</td>
        <td width="235" valign="middle"><span class="RegFormRight"><input name="txtUserEmail" type="text" class="RegFormFldowner" id="txtUserEmailId" value="<?php if(isset($_POST['txtUserEmail'])){echo $_POST['txtUserEmail'];}else{echo $userInfoArr['user_email'];}?>" /></span></td>
        <td width="274" valign="top"><span class="pdError1" id="showErrorUserEmailId"><?php if(array_key_exists('txtUserEmail', $form_array)) echo $form_array['txtUserEmail'];?></span></td>
    </tr>
    <tr>
        <td colspan="3" valign="top" style="padding:0px;">
            <div id="showchangepassLinkId" style="display:block;">
                <table width="690" border="0" cellspacing="0" cellpadding="5">
                    <tr>
                        <td width="145" align="right" valign="middle">Password</td>
                        <td width="245" valign="middle"><input name="txtUserPasswrd" type="password" class="RegFormFldowner" id="txtUserPasswrdId" value="*******" readonly="readonly" /></td>
                        <td width="274" valign="top"><div id="showchangepassLinkId1" align="left"><a href="javascript:showChangePassword(1);" class="blue-link">Change Password</a></div></td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="3" valign="top" style="padding:0px;">
            <div id="showchangepassId" style="display:none; padding-top:5px; padding-bottom:5px; padding-left:0px; background:#f7f7f7;">
                <table width="690" border="0" cellspacing="0" cellpadding="5">
                    <tr>
                        <td width="145" align="right" valign="middle">Current Password</td>
                        <td width="245" valign="top"><input name="txtOldPassword" id="txtOldPasswordId" type="password" class="RegFormFldowner" value="*******" readonly="readonly" /></td>
                        <td width="274" valign="top">
                            <span class="pdError1" id="showErrorOldPassword">&nbsp;</span>                                
                        </td>
                    </tr>
                    <tr>
                        <td  width="145" align="right" valign="middle">New password</td>
                        <td  width="245" valign="top"><input name="txtNewPassword" id="txtNewPasswordId" type="password" class="RegFormFldowner" value="" onkeydown="chkblnkTxtError('txtNewPasswordId', 'showErrorNewPassword');" onkeyup="chkblnkTxtError('txtNewPasswordId', 'showErrorNewPassword');" /></td>
                        <td valign="top">
                            <span class="pdError1" id="showErrorNewPassword">&nbsp;</span>                                
                        </td>
                    </tr>
                    <tr>
                        <td width="145" align="right" valign="middle">Repeat new password</td>
                        <td width="245" valign="top"><input name="txtConfirmPassword" id="txtConfirmPasswordId" type="password" class="RegFormFldowner" value=""onkeydown="chkblnkTxtError('txtConfirmPasswordId', 'showErrorConfirmPassword');" onkeyup="chkblnkTxtError('txtConfirmPasswordId', 'showErrorConfirmPassword');" /></td>
                        <td valign="top">
                            <span class="pdError1" id="showErrorConfirmPassword">&nbsp;</span>                                
                        </td>
                    </tr>
                    <tr>
                        <td width="145" align="right" valign="middle">&nbsp;</td>
                        <td colspan="2" valign="top">
                            <a href="javascript:showChangePassword(0);"><img src="<?php echo SITE_IMAGES;?>cancel-gray.gif" alt="Cancel" width="81" height="27" /></a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="return changePassword(0);"><img src="<?php echo SITE_IMAGES;?>submit.gif" alt="Change Password" width="81" height="27" /></a>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
    <!-- Owner Field: Start Here -->
    <tr>
        <td width="155" align="right" valign="middle">Birthdate</td>
        <td width="235" valign="middle">
            <span class="RegFormRight">
                <select name="txtDOBDay" id="txtDOBDayId" class="RegFormBDate">
                    <option value=""> - - </option>
                    <?
                    foreach($dayname as $key => $value) {
                    ?>
                        <option value="<?php echo $value;?>" <? if(isset($txtDOBDay) && ($value == $txtDOBDay)){echo "selected";} else{echo "";}?>><?php echo ($key+1)?></option>
                    <?
                    }
                    ?>
                </select>										
                <select name="txtDOBMonth" id="txtDOBMonthId" class="RegFormBMonth">
                    <option value=""> - - </option>
                    <?
                    foreach ($monthname as $key => $value) {
                    ?>
                        <option value="<?php echo $key?>" <? if(isset($txtDOBMonth) && ($key==$txtDOBMonth)){echo "selected";} else{echo "";}?>><?php echo $value;?></option>
                    <?
                    }
                    ?>
                </select>
                <select name="txtDOBYear" id="txtDOBYearId" class="RegFormBYear">
                    <option value=""> - - </option>
                    <?
                    foreach ($yearname as $value) {
                    ?>
                        <option value="<?php echo $value;?>" <? if(isset($txtDOBYear) && ($value==$txtDOBYear)){echo "selected";} else{echo "";}?>><?php echo $value;?></option>
                    <?
                    }
                    ?>
                </select>
            </span>
        </td>
        <td width="274" valign="top">
            <span class="pdError1" id="showErrorDOB">
                <?php 
                if(array_key_exists('txtDOBDay', $form_array)) { 
                    echo $form_array['txtDOBDay'];
                } else if(array_key_exists('txtDOBMonth', $form_array)) {
                    echo $form_array['txtDOBMonth'];
                } else if(array_key_exists('txtDOBYear', $form_array)) {
                    echo $form_array['txtDOBYear'];
                }
                ?>
            </span>
        </td>
    </tr>
    <tr>
        <td width="155" align="right" valign="middle">Country of residence</td>
        <td width="235" valign="middle">
            <select name="txtRCountry" class="select230">
                <option value="" style="font-style:normal; background-color:#D0E0F1;COLOR:#000000" disabled="disabled" selected="selected">Select country ... </option>
                <?php 
                $strPopularCountry = " WHERE countries_name IN ('United States', 'United Kingdom') ORDER BY countries_name IN ('United States', 'United Kingdom')";
                $locationObj->fun_getCountriesOptionsList('', $strPopularCountry);
                if(isset($_POST['txtRCountry'])){
                    $rcountry_id = $_POST['txtRCountry'];
                } else if(isset($userInfoArr['user_rcountry']) && $userInfoArr['user_rcountry'] != ""){
                    $rcountry_id = $userInfoArr['user_rcountry'];
                }
                $locationObj->fun_getCountriesOptionsList($rcountry_id);
                ?>
            </select>                    
        </td>
        <td width="274" valign="top">
            <span class="pdError1" id="showErrorRCountry">
                <?php 
                if(array_key_exists('txtRCountry', $form_array)) { 
                    echo $form_array['txtRCountry'];
                }
                ?>
            </span>
        </td>
    </tr>
    <tr>
        <td width="155" align="right" valign="top">Contact numbers</td>
        <td colspan="2" valign="top" class="pad-btm10">
            <table border="0" cellspacing="0" cellpadding="0">
                <?php
                if (count($userContactInfoArr) > 0) {
                    for($j = 0; $j < count($userContactInfoArr); $j++){
                        $contact_numberId 			= $userContactInfoArr[$j]['id'];
                        $contact_number_typeid 		= $userContactInfoArr[$j]['contact_number_typeid'];
                        $contact_number_countryid 	= $userContactInfoArr[$j]['contact_number_countryid'];
                        $contact_number 			= $userContactInfoArr[$j]['contact_number'];
                        $contact_number_show 		= $userContactInfoArr[$j]['contact_number_show'];
                        $recordid = "addanothernumberId".$j;
                    ?>
                    <tr>
                        <td colspan="4">
                            <table border="0" cellspacing="0" cellpadding="0" id="<?php echo $recordid;?>" style="display:block;">
                                <tr height="5px"><td colspan="4"></td></tr>
                                <tr>
                                    <td class="pad-rgt10">
                                        <select name="txtContactNumberType[]" id="txtContactNumberTypeId<?php echo $j;?>" class="NumberType">
                                            <?php 
                                            $usersObj->fun_getUserContactNoTypeOptionsList($contact_number_typeid);
                                            ?>
                                        </select>
                                    </td>
                                    <td class="pad-rgt10">
                                        <select name="txtContactCountry[]" id="txtContactCountryId<?php echo $j;?>" class="select128">
                                            <option value="" style="font-style:normal; background-color:#D0E0F1;COLOR:#000000" disabled="disabled" selected="selected">Select country ... </option>
                                            <?php 
                                            $strPopularCountry = " WHERE countries_name IN ('United States', 'United Kingdom') ORDER BY countries_name IN ('United States', 'United Kingdom')";
                                            $locationObj->fun_getCountriesISDOptionsList('', $strPopularCountry);
                                            ?>
                                            <option value="" style="font-style:normal; background-color:#D0E0F1;COLOR:#000000" disabled="disabled"> ---------------------------------------------- </option>
                                            <?php 
                                            $locationObj->fun_getCountriesISDOptionsList($contact_number_countryid);
                                            ?>
                                        </select>
                                    </td>
                                    <td class="pad-rgt10" valign="middle"><input type="text" name="txtContactNumber[]" id="txtContactNumberId<?php echo $j;?>" class="ContactNumber" maxlength="15" value="<?php echo $contact_number; ?>"/></td>
                                    <td class="pad-top1"><a href="javascript:delOwnrContactNumber('<?php echo $j;?>');" class="delete-photo">Delete</a></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <?php
                    }
                } else {
                ?>
                <tr>
                    <td colspan="4">
                        <table border="0" cellspacing="0" cellpadding="0" id="addanothernumberId0" style="display:block;">
                            <tr>
                                <td class="pad-rgt10">
                                    <select name="txtContactNumberType[]" class="NumberType">
                                        <option value="">Select Type</option>

                                        <?php 
                                        $usersObj->fun_getUserContactNoTypeOptionsList();
                                        ?>
                                    </select>                                            
                                </td>
                                <td class="pad-rgt10">
                                    <select name="txtContactCountry[]" id="txtContactCountryId" class="select128">
                                        <option value="" style="font-style:normal; background-color:#D0E0F1;COLOR:#000000" disabled="disabled" selected="selected">Select country... </option>
                                        <?php 
                                        $strPopularCountry = " WHERE countries_name IN ('United States', 'United Kingdom') ORDER BY countries_name IN ('United States', 'United Kingdom')";
                                        $locationObj->fun_getCountriesISDOptionsList('', $strPopularCountry);
                                        ?>
                                        <option value="" style="font-style:normal; background-color:#D0E0F1;COLOR:#000000" disabled="disabled"> ---------------------------------------------- </option>
                                        <?php 
                                        $locationObj->fun_getCountriesISDOptionsList();
                                        ?>
                                    </select>                                            
                                </td>
                                <td class="pad-rgt10"><input type="text" name="txtContactNumber[]" class="ContactNumber" maxlength="15" value=""/></td>
                                <td class="pad-top2">&nbsp;</td>
                            </tr>
                        </table>                                
                    </td>
                </tr>
                <?php
                }
                ?>
                <tr>
                    <td valign="top">
                    <input type="hidden" value="0" id="theValue" />
                    <div id="myDiv"></div>
                    </td>
                </tr>
                <tr><td colspan="4" class="pad-top10"><a  href="javascript:void(0);" onclick="addEvent();" class="add-contact">Add another number</a></td></tr>
            </table>                    
        </td>
    </tr>
    <tr>
        <td width="155" align="right" valign="top">Languages spoken</td>
        <td colspan="2" valign="top" class="pad-btm15">
            <table border="0" cellspacing="0" cellpadding="0">
               <?php
                for($i = 0; $i < count($userLanguageInfoArr); $i++){
                $contactLanguageId 	= $userLanguageInfoArr[$i]['id'];
                $language_id 		= $userLanguageInfoArr[$i]['language_id'];
                $language_show 		= $userLanguageInfoArr[$i]['language_show'];
                $recordid = "addanotherlanguageId".$i;
                ?>
                <tr>
                    <td colspan="2">
                        <table border="0" cellspacing="0" cellpadding="0" id="<?php echo $recordid;?>" style="display:block;">
                            <tr><td height="5" ></td></tr>
                            <tr>
                                <td class="pad-rgt10">
                                <select name="txtContactLanguage[]" id="txtContactLanguageId<?php echo $i;?>" class="select230">
                                <option value="">Select Language ...</option>
                                    <?php 
                                        $usersObj->fun_getLanguagesOptionsList($language_id);
                                    ?>
                                </select>
                                </td>
                                <td valign="middle" class="pad-top1"><a href="javascript:delOwnrContactLanguage('<?php echo $i;?>');" class="delete-photo">Delete</a></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php
                }
                ?>
                <tr>
                    <td colspan="2">
                        <table border="0" cellspacing="0" cellpadding="0" id="addanotherlanguageId_0" style="display:<?php if(isset($userLanguageInfoArr) && count($userLanguageInfoArr) > 0) {echo "none";}else {echo "block";}?>;">
                            <tr>
                                <td class="pad-rgt10">
                                    <select name="txtContactLanguage[]" class="select230">
                                        <option value="">Select Language ...</option>
                                        <?php 
                                        $usersObj->fun_getLanguagesOptionsList();
                                        ?>
                                    </select>
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" value="0" id="theValue" />
                        <div id="myDiv1"></div>
                    </td>
                </tr>
                <tr><td colspan="2" class="pad-top10"><a href="javascript:;" onclick="addEvent1();" class="add-language">Add another language</a></td></tr>
            </table>                    
        </td>
    </tr>
    <tr>
        <td width="155" align="right" valign="middle">Contact address</td>
        <td width="235" valign="middle"><span class="RegFormRight"><input name="txtAddress1" type="text" class="RegFormFldowner" id="txtAddressId1" value="<?php echo $txtAddress1;?>" /></span></td>
        <td width="274" valign="top"><span class="pdError1" id="showErrorAddress1"><?php if(array_key_exists('txtAddress1', $form_array)) echo $form_array['txtAddress1'];?></span></td>
    </tr>
    <tr>
        <td width="155" align="right" valign="middle">&nbsp;</td>
        <td width="235" valign="middle"><span class="RegFormRight"><input name="txtAddress2" type="text" class="RegFormFldowner" id="txtAddressId2" value="<?php echo $txtAddress2;?>" /></span></td>
        <td width="274" valign="top"><span class="pdError1" id="showErrorAddress1"><?php if(array_key_exists('txtAddress2', $form_array)) echo $form_array['txtAddress2'];?></span></td>
    </tr>
    <tr>
        <td width="155" align="right" valign="middle">Town / City</td>
        <td width="235" valign="middle"><span class="RegFormRight"><input name="txtTown" type="text" class="RegFormFldowner" id="txtTownId" value="<?php echo $txtTown;?>" /></span></td>
        <td width="274" valign="top"><span class="pdError1" id="showErrorTown"><?php if(array_key_exists('txtTown', $form_array)) echo $form_array['txtTown'];?></span></td>
    </tr>
    <tr>
        <td width="155" align="right" valign="middle">County / State / Province</td>
        <td width="235" valign="middle"><span class="RegFormRight"><input name="txtState" type="text" class="RegFormFldowner" id="txtStateId" value="<?php echo $txtState;?>" /></span></td>
        <td width="274" valign="top"><span class="pdError1" id="showErrorState"><?php if(array_key_exists('txtState', $form_array)) echo $form_array['txtState'];?></span></td>
    </tr>
    <tr>
        <td width="155" align="right" valign="middle">Postcode / ZIP</td>
        <td width="235" valign="middle"><span class="RegFormRight"><input name="txtZip" type="text" class="RegFormFldowner" id="txtZipId" value="<?php echo $txtZip;?>" /></span></td>
        <td width="274" valign="top"><span class="pdError1" id="showErrorState"><?php if(array_key_exists('txtZip', $form_array)) echo $form_array['txtZip'];?></span></td>
    </tr>
    <tr>
        <td width="155" align="right" valign="middle">Country</td>
        <td width="235" valign="middle">
            <span class="RegFormRight">
            <select name="txtCountry" class="select230">
                <option value="" style="font-style:normal; background-color:#D0E0F1;COLOR:#000000" disabled="disabled" selected="selected">Select country...</option>
                <?php 
                $strPopularCountry = " WHERE countries_name IN ('United States', 'United Kingdom') ORDER BY countries_name IN ('United States', 'United Kingdom')";
                $locationObj->fun_getCountriesOptionsList('', $strPopularCountry);
                $locationObj->fun_getCountriesOptionsList($rcountry_id);
                ?>
            </select>                    
            </span>
        </td>
        <td width="274" valign="top"><span class="pdError1" id="showErrorCountry"><?php if(array_key_exists('txtCountry', $form_array)) echo $form_array['txtCountry'];?></span></td>
    </tr>
    <!-- Owner Field: End Here -->
    <?php
        $whereUserSettingList 			= array();
        array_push($whereUserSettingList, "A.setting_id IN (1,3)");
        $userSettingListArr 	= $userSetting->fun_getUserSettingList($whereUserSettingList);
        // Set user setting checked here
        $UserSetting 		= array();
        if(isset($userSettingInfoArr) && is_array($userSettingInfoArr)){
            foreach($userSettingInfoArr as $value){
                array_push($UserSetting, $value['setting_id']);
            }
        }
        if(isset($userSettingListArr) && is_array($userSettingListArr)) {
            echo "<tr>";
            echo "<td align=\"right\" valign=\"middle\" class=\"pad-top15\">&nbsp;</td>";
            echo "<td colspan=\"2\" valign=\"middle\">";
            echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
            for($j=0; $j < count($userSettingListArr); $j++) {
                if(in_array($userSettingListArr[$j]['setting_id'], $UserSetting)) {
                    $strChecked = "checked";
                } else {
                    $strChecked = "";
                }
                echo "<tr>";
                echo "<td width=\"19\"><input name=\"txtUserSetting[]\" id=\"txtUserSettingId".$j."\" type=\"checkbox\" value=\"".$userSettingListArr[$j]['setting_id']."\" class=\"checkbox\" ".$strChecked." /></td>";
                echo "<td width=\"327\">".ucfirst($userSettingListArr[$j]['setting_name'])."</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "</td>";
            echo "</tr>";
        }
    ?>
    <tr><td colspan="3" align="left" valign="top" class="dash25">&nbsp;</td></tr>
    <tr><td colspan="3" align="left" valign="top" class="pad-top5"><strong>SMS Notifications</strong></td></tr>
    <tr>
        <td width="155" align="right" valign="middle">&nbsp;</td>
        <td colspan="2" valign="middle">
            <?php
            $whereUserSMSSettingList = array();
            array_push($whereUserSMSSettingList, "A.setting_id IN (4)");
            $user_sms_setting_arr = $userSetting->fun_getUserSettingList($whereUserSMSSettingList);
            // Set user setting checked here
            $UserSMSSettings = array();
            // Defalut settings
            if(isset($_POST['txtPropertySMS']) && ($_POST['txtPropertySMS'] != "")){
                $strSMSSettings = $_POST['txtPropertySMS'];
                for($k = 0; $k < count($strSMSSettings); $k++){
                    array_push($UserSMSSettings, $strSMSSettings[$k]);
                }
            } else{
                if(isset($userSettingInfoArr) && is_array($userSettingInfoArr)){
                    foreach($userSettingInfoArr as $value){
                        array_push($UserSMSSettings, $value['setting_id']);
                    }
                }
            }
            if(isset($user_sms_setting_arr) && is_array($user_sms_setting_arr)){
            ?>
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="19" class="pad-btm10 pad-top3"><input type="checkbox" name="txtPropertySMS" id="txtPropertySMSId" class="checkbox" value="<?php echo $user_sms_setting_arr[0]['setting_id'];?>" <?php if(in_array($user_sms_setting_arr[0]['setting_id'], $UserSMSSettings)){echo "checked";}else{echo "";}?> onclick="return chkShowSMS();" /></td>
                        <td width="130" align="left" valign="top"><?php echo $user_sms_setting_arr[0]['setting_name'];?></td>
                        <td width="150" valign="top"><span class="pdError1" id="showErrorSMS"><?php if(array_key_exists('txtSMS', $form_array)) echo $form_array['txtSMS']; else "&nbsp;"; ?></span></td>
                    </tr>
                </table>
                <div id="showSMSID" style="display:<?php if(in_array($user_sms_setting_arr[0]['setting_id'], $UserSMSSettings)){echo "block";}else{echo "none";}?>;">
                    <p>Send alerts to</p>
                    <p class="FloatLft">
                        <select name="txtPropertySMSCountry" id="txtPropertySMSCountryId" class="select200_15">
                            <?php
                            $locationObj->fun_getCountriesISDOptionsList($sms_number_countryid);
                            ?>
                        </select>										
                    </p>
                    <p class="FloatLft pad-lft5" style="display:none;">
                    <select name="txtPropertySMSCompany" id="txtPropertySMSCompanyId" class="select80">
                        <option value="Airtel" <?php if($sms_number_company == "Airtel"){echo "selected";} else{echo "";}?>>Airtel</option>
                        <option value="Vodafone" <?php if($sms_number_company == "Vodafone"){echo "selected";} else{echo "";}?>>Vodafone</option>
                    </select>
                    </p>
                    <p class="FloatLft pad-lft5">
                    <input name="txtPropertySMSNumber" id="txtPropertySMSNumberId" type="text" class="ContactNumber_1" value="<?php echo $sms_number; ?>" />
                    </p>
                    <p class="FloatLft pad-lft5">
                    <a href="javascript:validateSMSNumber();" style="text-decoration:none;"><img src="images/TestNumber-Normal.gif" alt="Test Number" name="TestNumber" id="TestNumber" width="88" height="21" border="0" /></a>
                    </p>
                </div>
            <?php
            }
            ?>
        </td>
    </tr>
    <tr><td colspan="3" align="right" valign="middle" class="line25">&nbsp;</td></tr>
</table>
<!-- Edit section end here -->


                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
												<tr>
													<td colspan="2" align="right" valign="top" class="header">
														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td align="right" valign="bottom" colspan="2">
																	<a href="admin-collateral.php?sec=resuser" style="text-decoration: none;"><img src="images/cancelN.png" alt="Cancel" border="0" height="21" width="66"></a>&nbsp;<input type="image" src="images/saveChangesN.png" alt="Save approve" name="SaveChange" width="108" height="21" border="0" id="SaveChangeId"  onclick="return validateSaveProfile();">
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr><td valign="top">&nbsp;</td></tr>
						<tr><td valign="top">&nbsp;</td></tr>
					</table>
				</td>
			</tr>
		</table>
		</form>
	<?php
    } else {
		$strQuery = " AND A.user_id='".$user_id."'";
		$usrInfoArr = $usersObj->fun_getUserShortInfoArr($strQuery);
		$usr_id 			= $usrInfoArr[0]['user_id'];
		$usr_fname			= ucwords($usrInfoArr[0]['user_fname']);
		$usr_lname			= ucwords($usrInfoArr[0]['user_lname']);
		$usr_name 			= ucwords($usrInfoArr[0]['user_fname']." ".$usrInfoArr[0]['user_lname']);
		$usr_email 			= $usrInfoArr[0]['user_email'];
		$usr_registered_on 	= date('M d, Y', strtotime($usrInfoArr[0]['registered_on']));
		$is_admin 			= $usrInfoArr[0]['is_admin'];
		$is_moderator 		= $usrInfoArr[0]['is_moderator'];
		$is_owner 			= $usrInfoArr[0]['is_owner'];
		if($is_owner == "1") {
			$usr_dob 			= date('M d, Y', strtotime($usrInfoArr[0]['user_dob']));
			$usr_address1		= $usrInfoArr[0]['user_address1'];
			$usr_address2		= $usrInfoArr[0]['user_address2'];
			$usr_town			= $usrInfoArr[0]['user_town'];
			$usr_state			= $usrInfoArr[0]['user_state'];
			$usr_zip			= $usrInfoArr[0]['user_zip'];
			$usr_country		= $usrInfoArr[0]['user_country'];
			$usr_rcountry		= $usrInfoArr[0]['user_rcountry'];
		
			if($usr_country > 0) {
				$usr_country_name	= $locationObj->fun_getCountryNameById($usr_country);
			} else {
				$usr_country_name	= "";
			}
			if($usr_rcountry > 0) {
				$usr_rcountry_name	= $locationObj->fun_getCountryNameById($usr_rcountry);
			} else {
				$usr_rcountry_name	= "";
			}
		
			//user contact number
			$userContactInfoArr	= $usersObj->fun_getUserContactNumberArr($user_id);
			if(is_array($userContactInfoArr) && count($userContactInfoArr) > 0) {
				$contact_number = $userContactInfoArr[0]['contact_number'];	
			}
			//user languages
			$userLanguageInfoArr= $usersObj->fun_getUserContactLanguageArr($user_id);
			if(is_array($userLanguageInfoArr) && count($userLanguageInfoArr) > 0) {
				$language_id 		= $userLanguageInfoArr[0]['language_id'];
				$language_name 		= $usersObj->fun_getLanguageNameById($language_id);
			}
		}
	
        $usr_type	 		= ($is_admin == 1 ? "Admin" : ($is_moderator == 1 ? "Moderator" : ($is_owner == 1 ? "Owner" : "Holiday Maker")));
		$usr_status 		= ($usrInfoArr[0]['user_status']=='1' ? "Approved" : "Pending approval");
		//User setting array
		$userSettingInfoArr	  = $userSetting->fun_getUserSettingInfo($usr_id);
		//print_r($userSettingInfoArr);
    ?>
		<script language="javascript" type="text/javascript">
        var req = ajaxFunction(); 
        function sbmtUsrApproval(strId){
            var strId = strId;
            req.open('get', '../includes/ajax/admin-user-pending-approvalXml.php?usrid=' + strId + '&mode=approve'); 
            req.onreadystatechange = handleApprovalResponse; 
            req.send(null); 
        }
        function sbmtUsrDecline(strId){
            document.getElementById("showDeclineReasonId").style.display = "block";
            var strId = strId;
            req.open('get', '../includes/ajax/admin-user-pending-approvalXml.php?usrid=' + strId + '&mode=decline'); 
            req.onreadystatechange = handleApprovalResponse; 
            req.send(null); 
        }
        
        function sbmtUsrSuspend(strId) {
            var strId = strId;
            req.open('get', '../includes/ajax/admin-user-pending-approvalXml.php?usrid=' + strId + '&mode=suspend'); 
            req.onreadystatechange = handleApprovalResponse; 
            req.send(null); 
        }
        
        function sbmtUsrDelete(strId) {
        /*
            var strId = strId;
            req.open('get', 'includes/ajax/admin-user-pending-approvalXml.php?usrid=' + strId + '&mode=delete'); 
            req.onreadystatechange = handleApprovalResponse; 
            req.send(null); 
        */
        }
        
        function handleApprovalResponse() { 
            if(req.readyState == 4){ 
                var response = req.responseText; 
                xmlDoc=req.responseXML;
                var root = xmlDoc.getElementsByTagName('users')[0];
                if(root != null){
                    var items = root.getElementsByTagName("user");
                    var item = items[0];
                    var userstatus = item.getElementsByTagName("userstatus")[0].firstChild.nodeValue;
                    if(userstatus == "Approved") {
                        document.getElementById("userStatusShowId").innerHTML 	= "<font color='#CF0000' size='2'><strong>"+userstatus+"</strong></font>";
                    } else if(userstatus == "Declined") {
                        document.getElementById("userStatusShowId").innerHTML 	= "<font color='#CF0000' size='2'><strong>"+userstatus+"</strong></font>";
                    } else if(userstatus == "Suspended") {
                        document.getElementById("userStatusShowId").innerHTML 	= "<font color='#CF0000' size='2'><strong>"+userstatus+"</strong></font>";
                    } else if(userstatus == "Deleted") {
                        window.location = 'admin-collateral.php?sec=resuser';
                    } else{
                        document.getElementById("userStatusShowId").innerHTML 	= "<font color='#CF0000' size='2'><strong>Error, try later!</strong></font>";
                    }
                } else {
                    document.getElementById("userStatusShowId").innerHTML 	= "<font color='#CF0000' size='2'><strong>Error, try later!</strong></font>";
                }
            } else {
                document.getElementById("userStatusShowId").innerHTML 	= "<font color='#CF0000' size='2'><strong>Please wait...</strong></font>";
            }
        } 

		function loginAsOwner(strId) {
            var strId = strId;
            req.open('get', '<?php echo SITE_ADMIN_URL;?>includes/ajax/admin-user-login-as-ownerXml.php?usrid=' + strId); 
            req.onreadystatechange = handleLoginAsOwnerResponse; 
            req.send(null); 
		}

        function handleLoginAsOwnerResponse() { 
            if(req.readyState == 4){ 
                var response = req.responseText; 
                xmlDoc = req.responseXML;
				//alert(response);
                var root = xmlDoc.getElementsByTagName('users')[0];
                if(root != null){
                    var items = root.getElementsByTagName("user");
                    var item = items[0];
                    var userstatus = item.getElementsByTagName("userstatus")[0].firstChild.nodeValue;
                    if(userstatus == "Success.") {
						popownerpanel();
                        document.getElementById("showLoginAsOwnerId").innerHTML = "&nbsp;";
                    } else{
                        document.getElementById("showLoginAsOwnerId").innerHTML = "<font color='#CF0000' size='2'><strong>Error, try later!</strong></font>";
                    }
                } else {
                    document.getElementById("showLoginAsOwnerId").innerHTML = "<font color='#CF0000' size='2'><strong>Error, try later!</strong></font>";
                }
            } else {
                document.getElementById("showLoginAsOwnerId").innerHTML = "<font color='#CF0000' size='2'><strong>Please wait...</strong></font>";
            }
        } 

		function popownerpanel() {
			window.open('<?php echo SITE_URL;?>owner-home', 'OwnerPanel', 'left=0,top=0,channelmode=1,titlebar=1,toolbar=1,scrollbars=1,location=1,statusbar=1,menubar=1,resizable=1,copyhistory=0,directories=0,status=1,width=1024,height=800');
		}

        </script>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td valign="top"><a href="admin-collateral.php?sec=resuser" class="arrowLinkback">Back to list</a></td>
                <td align="right" valign="top">&nbsp;
					<?php /*?>
                    <a href="#" class="arrowLinkback">Previous</a>&nbsp; <span class="boldblack12">|</span> &nbsp; 
                    <a href="#" class="arrowLinkNext">Next</a>
					<?php */?>
                </td>
            </tr>
            <tr><td colspan="2" valign="top" class="dash15">&nbsp;</td></tr>
            <tr><td colspan="2" valign="top" align="right" ><a href="admin-collateral.php?sec=resuser&usrid=<?php echo $user_id; ?>&act=edit"><img src="images/edit-admin.gif" alt="Preview" width="74" height="21" /> </a></td></tr>
            <tr>
                <td colspan="2" valign="top">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td valign="top" width="150">Type</td>
                            <td valign="top">
							<?php
							echo $usr_type;
							if(isset($is_owner) && $is_owner =="1" && isset($usrInfoArr[0]['user_status']) && $usrInfoArr[0]['user_status'] == "1") {
								echo '&nbsp;&nbsp;-&nbsp;&nbsp;';
								echo '<span id="showLoginAsOwnerId"><a href="#" class="blueTxt" onclick="loginAsOwner('.$user_id.');">Login as this owner</a></span>';
							}
							?>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">ID</td>
                            <td valign="top"><a href="#" class="blueTxt"><?php echo fill_zero_left($usr_id, "0", (6-strlen($usr_id))); ?></a></td>
                        </tr>
                        <tr>
                            <td valign="top">Date added</td>
                            <td valign="top"><?php echo $usr_registered_on; ?></td>
                        </tr>
                        <tr>
                            <td valign="top">First name</td>
                            <td valign="top"><?php echo $usr_fname; ?></td>
        
                        </tr>
                        <tr>
                            <td valign="top">Last name</td>
                            <td valign="top"><?php echo $usr_lname; ?></td>
                        </tr>
                        <tr>
                            <td valign="top">Email address</td>
                            <td valign="top"><?php echo $usr_email; ?></td>
                        </tr>
                        <tr>
                            <td valign="top">Birthdate</td>
                            <td valign="top"><?php echo $usr_dob; ?></td>
                        </tr>
                        <tr>
                            <td valign="top">Country of residence</td>
                            <td valign="top"><?php echo $usr_rcountry_name; ?></td>
                        </tr>
                        <tr>
                            <td valign="top">Contact numbers</td>
                            <td valign="top"><?php echo $contact_number; ?></td>
                        </tr>
                        <tr>
                            <td valign="top">Languages spoken</td>
                            <td valign="top"><?php echo $language_name; ?></td>
                        </tr>
                        <tr>
                            <td valign="top">Contact address</td>
                            <td valign="top"><?php echo $usr_address1." ".$usr_address2; ?></td>
                        </tr>
                        <tr>
                            <td valign="top">Town / City</td>
                            <td valign="top"><?php echo $usr_town; ?></td>
                        </tr>
                        <tr>
                            <td valign="top">County / state / province</td>
                            <td valign="top"><?php echo $usr_state; ?></td>
                        </tr>
                        <tr>
                            <td valign="top">Postcode / ZIP</td>
                            <td valign="top"><?php echo $usr_zip; ?></td>
                        </tr>
                        <tr>
                            <td valign="top">Country</td>
                            <td valign="top"><?php echo $usr_rcountry_name; ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        <?php
            if(is_array($userSettingInfoArr) && count($userSettingInfoArr) > 0) {
            ?>
                <tr><td colspan="2" valign="top" class="dash15">&nbsp;</td></tr>
                <tr>
                    <td colspan="2" valign="top">
                        <table border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td valign="top" width="150"><strong>User Settings</strong></td>
                                <td valign="top">&nbsp;</td>
                            </tr>
                            <?php
                                for($j=0; $j < count($userSettingInfoArr); $j++) {
                                    echo "<tr>";
                                    echo "<td valign=\"top\" width=\"150\">&nbsp;</td>";
                                    echo "<td>".$userSettingInfoArr[$j]['setting_name']."</td>";
                                    echo "</tr>";
                                }
                            ?>
                        </table>
                    </td>
                </tr>
            <?php
            }
            ?>
            <tr><td colspan="2" valign="top" class="dash15">&nbsp;</td></tr>
            <tr>
                <td colspan="2" valign="top" class="adminBox">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="80" valign="top" class="owner-headings6">Status</td>
                            <td valign="bottom" class="black pad-top2"><div id="userStatusShowId"><strong><?php echo ucfirst($usr_status);?></strong></div></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td class="pad-top13">
                                <?php if($usrInfoArr[0]['user_status'] != "1"){?><a href="javascript:sbmtUsrApproval(<?php echo $usr_id;?>);"><img src="<?php echo SITE_ADMIN_IMAGES;?>approve.gif" alt="Approve"/></a><?php } else{?><img src="<?php echo SITE_ADMIN_IMAGES;?>approve.gif" alt="Approve"/><?php }?>
                                <?php if($usrInfoArr[0]['user_status'] != "0"){?><a href="javascript:sbmtUsrSuspend(<?php echo $usr_id;?>);"><img src="<?php echo SITE_ADMIN_IMAGES;?>suspend.gif" class="pad-left3" alt="Suspend"/></a><?php } else{?><img src="<?php echo SITE_ADMIN_IMAGES;?>suspend.gif" class="pad-left3" alt="Suspend"/><?php }?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr><td colspan="2" valign="top">&nbsp;</td></tr>
            <?php
            $userOrderHistoryArr 	= $cartObj->fun_getUserOrderHistoryArr($usr_id, "4");
            if(is_array($userOrderHistoryArr) && count($userOrderHistoryArr)) {
            ?>
                <tr><td colspan="2" valign="top" class="font18-darkgrey" style="padding-bottom:20px;">Payment history</td></tr>
                <?php
                $offer_code = "";
                for($i = 0; $i < count($userOrderHistoryArr); $i++) {
                    $orders_id 				= $userOrderHistoryArr[$i]['orders_id'];
                    $orderProductsArr 		= $cartObj->fun_getOrderProductsArr($orders_id);
                    $offer_code 			= $cartObj->fun_getOrderUserPromoCode($orders_id, $usr_id);
                ?>
                    <tr>
                        <td colspan="2" valign="top">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td valign="top" bgcolor="#e2e2e2">
                                        <table width="100%" border="0" cellpadding="0" cellspacing="5">
                                            <tr>
                                                <td width="130" valign="top" style="padding-left:5px;"><strong>Date purchased</strong></td>
                                                <td><?php echo date('M d, Y', $cartObj->fun_getOrderDate($orders_id)); ?></td>
                                            </tr>
                                            <tr>
                                                <td valign="top" style="padding-left:5px;"><strong>Total amount paid</strong></td>
                                                <td><?php echo number_format($cartObj->fun_getOrderPaidAmount($orders_id), 2); ?></td>
                                            </tr>
                                            <tr>
                                                <td valign="top" style="padding-left:5px;"><strong>Offer code</strong></td>
                                                <td><?php echo $offer_code; ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr><td valign="top">&nbsp;</td></tr>
                                <?php
                                if(is_array($orderProductsArr) && count($orderProductsArr)) {
                                ?>
                                    <tr>
                                        <td valign="top">
                                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                <tbody style="font-size:11px;">
                                                <tr class="font12-darkgrey">
                                                    <td width="20%" style="padding-left:10px;">Reference</td>
                                                    <td width="35%">Description</td>
                                                    <td width="20%" align="right">Cost per unit</td>
                                                    <td width="10%" align="center">Units</td>
                                                    <td width="15%" align="right" style="padding-right:10px;">Total cost</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <?php
                                    for($j = 0; $j < count($orderProductsArr); $j++) {
                                        $products_id 		= $orderProductsArr[$j]['products_id'];
                                        $products_name 		= $orderProductsArr[$j]['products_name'];
                                        $products_price 	= number_format($orderProductsArr[$j]['products_price'], 2);
                                        $final_price 		= number_format($orderProductsArr[$j]['final_price'], 2);
                                        $products_quantity 	= $orderProductsArr[$j]['products_quantity'];
                                        $reference 			= $cartObj->fun_getPropertyReference($orders_id, $products_id);
                                    ?>
                                        <tr>
                                            <td valign="top">
                                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                    <tbody style="font-size:11px;">
                                                    <tr>
                                                        <td width="20%" style="padding-left:10px;"><?php echo fill_zero_left($reference, "0", (6-strlen($reference))); ?></td>
                                                        <td width="35%"><?php echo $products_name; ?></td>
                                                        <td width="20%" align="right"><?php echo $products_price; ?></td>
                                                        <td width="10%" align="center"><?php echo $products_quantity; ?></td>
                                                        <td width="15%" align="right" style="padding-right:10px;"><?php echo $final_price; ?></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                }
                                ?>
                            </table>
                        </td>
                    </tr>
                    <tr><td colspan="2" valign="top">&nbsp;</td></tr>
                <?php
                }
                ?>
            <?php
            }
            ?>
            <tr><td colspan="2" valign="top">&nbsp;</td></tr>
        </table>
	<?php
	}
} else {
	$sec = $_GET['sec'];
	if(isset($_POST['txtFilter']) && $_POST['txtFilter'] == "1"){		
		$txtUser = $_POST['txtUser'];
    	$strQuery = " AND A.user_id='".$txtUser."' ";
	}
	if(isset($_GET['sortby']) && $_GET['sortby'] != "") {
		$strQuery = " ORDER BY ";
		switch($_GET['sortby']){
			case 'usrid':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$usriddr 	= 0;
					$usrnamedr	= 1;
					$usremaildr = 1;
					$usrtypedr 	= 1;
					$usradddr 	= 1;
					$statusdr 	= 1;
				}
				else{
					$dr = "DESC";
					$usriddr 	= 1;
					$usrnamedr	= 1;
					$usremaildr = 1;
					$usrtypedr 	= 1;
					$usradddr 	= 1;
					$statusdr 	= 1;
				}
				$strQuery .= " A.user_id ".$dr;
			break;
			case 'usrname':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$usriddr 	= 1;
					$usrnamedr	= 0;
					$usremaildr = 1;
					$usrtypedr 	= 1;
					$usradddr 	= 1;
					$statusdr 	= 1;
				}
				else{
					$dr = "DESC";
					$usriddr 	= 1;
					$usrnamedr	= 1;
					$usremaildr = 1;
					$usrtypedr 	= 1;
					$usradddr 	= 1;
					$statusdr 	= 1;
				}
				$strQuery .= " A.user_fname ".$dr;
			break;
			case 'usremail':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$usriddr 	= 1;
					$usrnamedr	= 1;
					$usremaildr = 0;
					$usrtypedr 	= 1;
					$usradddr 	= 1;
					$statusdr 	= 1;
				}
				else{
					$dr = "DESC";
					$usriddr 	= 1;
					$usrnamedr	= 1;
					$usremaildr = 1;
					$usrtypedr 	= 1;
					$usradddr 	= 1;
					$statusdr 	= 1;
				}
				$strQuery .= " A.user_email ".$dr;
			break;
			case 'usrtype':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$usriddr 	= 1;
					$usrnamedr	= 1;
					$usremaildr = 1;
					$usrtypedr 	= 0;
					$usradddr 	= 1;
					$statusdr 	= 1;
				}
				else{
					$dr = "DESC";
					$usriddr 	= 1;
					$usrnamedr	= 1;
					$usremaildr = 1;
					$usrtypedr 	= 1;
					$usradddr 	= 1;
					$statusdr 	= 1;
				}
				$strQuery .= " A.is_admin ".$dr.", A.is_moderator ".$dr.", A.is_owner ".$dr;
			break;
			case 'added':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$usriddr 	= 1;
					$usrnamedr	= 1;
					$usremaildr = 1;
					$usrtypedr 	= 1;
					$usradddr 	= 0;
					$statusdr 	= 1;
				}
				else{
					$dr = "DESC";
					$usriddr 	= 1;
					$usrnamedr	= 1;
					$usremaildr = 1;
					$usrtypedr 	= 1;
					$usradddr 	= 1;
					$statusdr 	= 1;
				}
				$strQuery .= " A.created_on ".$dr;
			break;
			case 'status':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$usriddr 	= 1;
					$usrnamedr	= 1;
					$usremaildr = 1;
					$usrtypedr 	= 1;
					$usradddr 	= 1;
					$statusdr 	= 0;
				}
				else{
					$dr = "DESC";
					$usriddr 	= 1;
					$usrnamedr	= 1;
					$usremaildr = 1;
					$usrtypedr 	= 1;
					$usradddr 	= 1;
					$statusdr 	= 1;
				}
				$strQuery .= " A.user_status ".$dr;
			break;
		}
	} else {
//		$strQuery 	= "";
		$usriddr 	= 1;
		$usrnamedr	= 1;
		$usremaildr = 1;
		$usrtypedr 	= 1;
		$usradddr 	= 1;
		$statusdr 	= 1;
	}
	 $usrListArr = $usersObj->fun_getCollateralUserArr($strQuery);
	if(is_array($usrListArr) && count($usrListArr) > 0){
	?>
		<script language="javascript" type="text/javascript">
			/* --------- Script for sort list links : start here ----------- */
			function sortList(str){
			//	alert(str);
				location.href = str;
			}
			/* --------- Script for sort list links : end here ----------- */
        </script>
        <script language="javascript" type="text/javascript">
			var req = ajaxFunction();
		 	var x, y;	
			function getFilter(){
				var id = document.getElementById("txtUserId").value;
				if(id == "") {
					alert("Enter user id!");
					document.getElementById("txtUserId").focus();
					return false;
				} else {
					document.getElementById("frmFilter").action = "admin-collateral.php?sec=resuser";
					document.getElementById("frmFilter").submit();
				}
            }

		   function toggleLayer(whichLayer){
				var output = document.getElementById(whichLayer).innerHTML;
				if(whichLayer == 'ANP-Example') {		
					output = '<div style="z-index:5;">'+output+'</div>';
					var googlewin=dhtmlwindow.open("Example", "inline", output, "", "width=295px,height=470px,resize=0,scrolling=0,center=1,xAxis="+x+",yAxis="+y+"", "recal");
				} else if(whichLayer == 'user-delete-pop') {		
					var x1 = x-150;
					var y1 = y-100;
					output = '<div style="z-index:5;">'+output+'</div>';
					var googlewin=dhtmlwindow.open("Example", "inline", output, "", "width=298px,height=160px,resize=1,scrolling=0,center=1,xAxis="+x1+",yAxis="+y1+"", "recal");
				}
				
				googlewin.onclose=function(){ //Run custom code when window is being closed (return false to cancel action):
					return true
				}
			}
        
			function closeWindow(){	
				document.getElementById("Example").style.display="none";
			}
			
			function closeWindowNRefresh(){
				document.getElementById("Example").style.display="none";
				window.location = location.href;
			}

			function delItem(strId) {
				document.getElementById("txtDelItem").value = strId;
			}
			
			function delUserItem(){
				closeWindow();
				if(document.getElementById("txtDelItem").value != "") {
					var strUserId = document.getElementById("txtDelItem").value;
					req.onreadystatechange = handleDeleteUserItemResponse;
					req.open('get', 'includes/ajax/userdeleteXml.php?usr_id='+strUserId); 
					req.send(null);   
				}
			}

			function handleDeleteUserItemResponse(){
				if(req.readyState == 4){
					var response = req.responseText;
					xmlDoc = req.responseXML;
					var root = xmlDoc.getElementsByTagName('users')[0];
					if(root != null){
						var items = root.getElementsByTagName("user");
						for (var i = 0 ; i < items.length ; i++){
							var item 				= items[i];
							var userstatus 		= item.getElementsByTagName("userstatus")[0].firstChild.nodeValue;
							if(userstatus == "user deleted."){
								window.location = location.href;
							}
						}
					}
				}
			}

			function getFilter(){
				var id = document.getElementById("txtUserId").value;
				if(id == "") {
					alert("Enter user id!");
					document.getElementById("txtUserId").focus();
					return false;
				} else {
					document.getElementById("frmFilter").action = "admin-collateral.php?sec=resuser";
					document.getElementById("frmFilter").submit();
				}
            }

			function showFilter(strInt){
				if(parseInt(strInt) > 0) {
					document.getElementById("filterTbl").style.display = "block";
				} else {
					location.href = "admin-collateral.php?sec=resuser";
				}
            }
        </script>		
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
            <td colspan="2" valign="top">
                <form name="frmFilter" id="frmFilter" method="post">
                <input type="hidden" name="txtFilter" id="txtFilter" value="1" />
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                    <tr><td height="10" colspan="2" valign="top" class="dash-top"></td></tr>
                    <tr>
                        <td valign="top">
                            <table border="0" cellspacing="0" cellpadding="2" class="boldTitle" style="padding-bottom:10px;">
                                <tr>
                                    <td><input name="radio" type="radio" class="radio" id="radio1" value="1" <?php if(!isset($_POST['txtFilter']) || $_POST['txtFilter'] != "1") { echo "checked=\"checked\"";} else {echo "";}?> onclick="return showFilter(0);" /></td>
                                    <td>View all</td>
                                    <td class="pad-lft20"><input name="radio" type="radio" class="radio" id="radio2" value="2" <?php if(isset($_POST['txtFilter']) && $_POST['txtFilter'] == "1") { echo "checked=\"checked\"";} else {echo "";}?> onclick="return showFilter(1);"/></td>
                                    <td>Filter Users</td>
                                </tr>
                            </table>
                        </td>
                        <td align="right" valign="top">
                            <table border="0" cellspacing="0" cellpadding="0" id="filterTbl" style="display:<?php if(isset($_POST['txtFilter']) && $_POST['txtFilter'] == "1") { echo "block";} else {echo "none";}?>">
                                <tr>
                                    <td class="blackTxt14 pad-rgt5" style="font-weight:normal;">Users ID</td>
                                    <td class="pad-rgt5"><input type="text" name="txtUser" id="txtUserId" class="Textfield80 blackText" value="<?php if(isset($_POST['txtUser']) && $_POST['txtUser'] != "") { echo $_POST['txtUser'];} else {echo "";}?>" /></td>
                                    <td><a href="javascript:void(0);" onclick="return getFilter();"><img src="images/show-admin.gif" alt="Send" border="0" /></a></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr><td height="10" colspan="2" valign="top" class="dash-top"></td></tr>
                </table>
            </form>
            </td>
        </tr>
            <tr><td colspan="2" valign="top">&nbsp;</td></tr>
            <tr>
                <td valign="top">Display <?php echo count($usrListArr); ?>-<?php echo count($usrListArr); ?> of <?php echo count($usrListArr); ?></td>
                <td align="right" valign="top" class="Paging">
                <!--
                <a href="#">First</a> <a href="#">&lt;</a> <a href="#">1</a> | 2 | <a href="#">3</a> | <a href="#">4</a> | <a href="#">5</a> | <a href="#">6</a> | <a href="#">7</a> | <a href="#">8</a> | <a href="#">9</a> | <a href="#">10</a>...<a href="#">23</a> <a href="#">&gt;</a> <a href="#">Last</a>
                -->
                </td>
            </tr>
            <tr><td colspan="2" valign="top">&nbsp;</td></tr>
            <tr>
                <td colspan="2" valign="top">
                    <input type="hidden" name="txtDelItem" id="txtDelItem" value="" />
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EventListing">
                        <thead>
                            <tr>
                                <th width="7%" class="left" scope="col">&nbsp;</th>
                                <th width="9%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-collateral.php?sec=resuser&sortby=usrid&dr=".$usriddr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "usrid")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?> ><div>ID</div></th>
                                <th width="14%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-collateral.php?sec=resuser&sortby=usrname&dr=".$usrnamedr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "usrname")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?> ><div>Name</div></th>
                                <th width="22%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-collateral.php?sec=resuser&sortby=usremail&dr=".$usremaildr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "usremail")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Email address</div></th>
                                <th width="15%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-collateral.php?sec=resuser&sortby=usrtype&dr=".$usrtypedr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "usrtype")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Type</div></th>
                                <th width="15%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-collateral.php?sec=resuser&sortby=added&dr=".$usradddr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "added")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Date registered</div></th>
                                <th width="18%" scope="col" class="right" onmouseover="this.className = 'rightOver';" onclick="sortList('<?php echo "admin-collateral.php?sec=resuser&sortby=status&dr=".$statusdr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "status")){echo "class=\"rightOver\" onmouseout=\"this.className = 'rightOver';\" ";}else{echo "onmouseout=\"this.className = 'right';\"";}?>><div>Status</div></th>
                                <th width="10%" scope="col"><div>Action</div></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            for($i=0; $i < count($usrListArr); $i++){
                            $usr_id 			= $usrListArr[$i]['user_id'];
                            $usr_name 			= ucwords($usrListArr[$i]['user_fname']." ".$usrListArr[$i]['user_lname']);
                            $usr_email 			= $usrListArr[$i]['user_email'];
                            $usr_registered_on 	= date('M d, Y', strtotime($usrListArr[$i]['registered_on']));
                            $is_admin 			= $usrListArr[$i]['is_admin'];
                            $is_moderator 		= $usrListArr[$i]['is_moderator'];
                            $is_owner 			= $usrListArr[$i]['is_owner'];
                            $usr_type	 		= ($is_admin == 1 ? "Admin" : ($is_moderator == 1 ? "Moderator" : ($is_owner == 1 ? "Owner" : "Holiday Maker")));
                            $usr_status 		= ($usrListArr[$i]['user_status']=='1' ? "Approved" : "Pending approval");
                            ?>
                                <tr>
                                    <td class="left"><a href="admin-collateral.php?sec=resuser&usrid=<?php echo $usr_id;?>">View </a></td>
                                    <td><?php echo fill_zero_left($usr_id, "0", (6-strlen($usr_id)));?></td>
                                    <td><?php echo $usr_name;?></td>
                                    <td><?php echo $usr_email;?></td>
                                    <td><?php echo $usr_type;?></td>
                                    <td><?php echo $usr_registered_on;?></td>
                                    <td class="right"><?php echo $usr_status;?></td>
                                    <td><a href="javascript:delItem(<?php echo $usr_id; ?>);toggleLayer('user-delete-pop');" class="removeText">Delete</a></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <div id="user-delete-pop" style="display:none; position:absolute; background:transparent; left:300px; top:500px;">
                        <div style="position:relative; z-index:999;left:0px;width:250px;height:170px;">
                            <table width="230" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td align="right"><img src="<?php echo SITE_IMAGES;?>poplefttop.png" alt="ANP" height="10" width="10" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo SITE_IMAGES;?>poplefttop.png', sizingMethod='scale');" /></td>
                                    <td class="topp"></td>
                                    <td><img src="<?php echo SITE_IMAGES;?>poprighttop1.png" alt="ANP"  height="10" width="15" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo SITE_IMAGES;?>poprighttop1.png', sizingMethod='scale');"/></td>
                                </tr>
                                <tr>
                                    <td class="leftp"></td>
                                    <td width="220" align="left" valign="top" bgcolor="#FFFFFF" style="padding:12px;"> 
                                        <table width="220" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td align="left" valign="top" class="head"><span class="pink14arial">Are you sure?</span></td>
                                                <td width="15" align="right" valign="top"><a href="javascript:closeWindow();void(0);" ><img src="<?php echo SITE_IMAGES;?>pop-up-cross.gif" alt="Close" title="Close" border="0" /></a></td>
                                            </tr>
                                            <tr>
                                                <td  align="left" valign="top" class="PopTxt">
                                                    <table width="98%" border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td class="pad-rgt10 pad-top5"><strong>You will be delete the User & information related to this User !</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="pad-top10">
                                                                <div class="FloatLft"><a href="javascript:closeWindow();void(0);" ><img src="<?php echo SITE_IMAGES;?>cancel-admin.png" alt="Keep it" /></a></div>
                                                                <div class="FloatLft pad-lft5"><a href="javascript:delUserItem();"><img src="<?php echo SITE_IMAGES;?>delete.gif" alt="Delete it" onmouseover="this.src='<?php echo SITE_IMAGES; ?>delete_h.gif'" onmouseout="this.src='<?php echo SITE_IMAGES; ?>delete.gif'" /></a></div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td  align="left" valign="top" class="PopTxt">&nbsp;</td>
                                            </tr>
                                        </table>                               
                                    </td>
                                    <td class="rightp" width="15"></td>
                                </tr>
                                <tr>
                                    <td align="right"><img src="<?php echo SITE_IMAGES;?>popleftbtm.png" alt="ANP" /></td>
                                    <td width="270" class="bottomp"></td>
                                    <td align="left"><img src="<?php echo SITE_IMAGES;?>poprightbtm1.png" alt="ANP"/></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </td>
            </tr>
            <tr><td colspan="2" valign="top">&nbsp;</td></tr>
        </table>
	<?php
	} else {
	?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr><td valign="top">No new user registered!</td></tr>
        </table>
	<?php
	}
}

?>
