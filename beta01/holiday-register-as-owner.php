<?php	
	require_once("includes/holiday-top.php");
?>
<?php	
	// Form submission
	$form_array 	= array();
	$errorMsg = 'no';
	
	if($_POST['securityKey']==md5("USEROWNERPROFILE")) {		
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

		if((trim($_POST['txtUserPasswrd']) == '') || (strlen($_POST['txtUserPasswrd']) < 6)){
			$form_array['txtUserPasswrd'] = 'Minimum of 6 character password required';
			$errorMsg = 'yes';
		}

		if((trim($_POST['txtConfirmPassword']) == '') || (trim($_POST['txtConfirmPassword']) != trim($_POST['txtUserPasswrd']))){
			$form_array['txtConfirmPassword'] = 'Please confirm your password';
			$errorMsg = 'yes';
		}

		if($usersObj->fun_verifyUserPassword($user_id, $_POST['txtUserPasswrd']) === true){
		} else {
			$form_array['txtConfirmPassword'] = 'Please confirm your password';
			$errorMsg = 'yes';
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

		if(($_SESSION['security_code'] == $_POST['image_vcode']) && ($errorMsg == 'no') && ($errorMsg != 'yes')){		
			// register as owner
			$txtUserFName 	= trim($_POST['txtUserFName']);
			$txtUserLName 	= trim($_POST['txtUserLName']);
			$txtUserEmail 	= trim($_POST['txtUserEmail']);
			$txtDOBDay 		= trim($_POST['txtDOBDay']);
			$txtDOBMonth 	= trim($_POST['txtDOBMonth']);
			$txtDOBYear 	= trim($_POST['txtDOBYear']);
			$txtAddress1 	= trim($_POST['txtAddress1']);
			$txtAddress2 	= trim($_POST['txtAddress2']);
			$txtTown 		= trim($_POST['txtTown']);
			$txtState 		= trim($_POST['txtState']);
			$txtZip 		= trim($_POST['txtZip']);
			$txtCountry 	= trim($_POST['txtCountry']);
			$txtRCountry 	= trim($_POST['txtRCountry']);
			$txtIsOwner 	= trim($_POST['txtIsOwner']);

			if($usersObj->fun_updateHolidayAsOwner($user_id, $txtUserFName, $txtUserLName, $txtUserEmail, $txtDOBDay, $txtDOBMonth, $txtDOBYear, $txtAddress1, $txtAddress2, $txtTown, $txtState, $txtZip, $txtCountry, $txtRCountry, $txtIsOwner) === true){
				// for contact numbers
				$txtContactNumberType 	= $_POST['txtContactNumberType'];
				$txtContactCountry 		= $_POST['txtContactCountry'];
				$txtContactNumber 		= $_POST['txtContactNumber'];
				$usersObj->fun_updateUserContactNumbers($user_id, $txtContactNumberType, $txtContactCountry, $txtContactNumber);				

				// for contact languages
				$txtContactLanguage 	= $_POST['txtContactLanguage'];
				$usersObj->fun_updateUserContactLanguages($user_id, $txtContactLanguage);

				// For user settings
				$settingInfoArr	= $usersObj->fun_getUserSettingInfoArr($user_id); // find existing setting
				$arr = array();
				for($counter = 0; $counter < count($settingInfoArr); $counter++) {
					array_push($arr, $settingInfoArr[$counter]['setting_id']);
				}
				// remove 1 and 3 from this array
				$arr1 = array_remval("1", $arr);
				$arr2 = array_remval("3", $arr1);
				$arr3 = $_POST['txtUserSetting'];
				for($counter1 = 0; $counter1 < count($arr3); $counter1++) {
					array_push($arr2, $arr3[$counter1]);
				}
				array_unique($arr2);
				$usersObj->fun_updateUserSettings($user_id, $arr2);
				// Send welcome mail
				$usersObj->sendWelcomeEmailToUser($user_id);

				redirectURL(SITE_URL."owner-home");
			} else {
				redirectURL(SITE_URL."holiday-profile-settings");
			}
			
		} else {
			$form_array['error_msg'] = "Please submit your form again!";
		}


	}


	$userInfoArr 		= $usersObj->fun_getUsersInfo($user_id);
	//user setting
	$userSettingInfoArr	= $usersObj->fun_getUserSettingInfoArr($user_id);
	//user contact number
	$userContactInfoArr	= $usersObj->fun_getUserContactNumberArr($user_id);
	//user languages
	$userLanguageInfoArr= $usersObj->fun_getUserContactLanguageArr($user_id);

	$users_first_name 	= $userInfoArr['user_fname'];
	$users_last_name 	= $userInfoArr['user_lname'];
	$users_email_id 	= $userInfoArr['user_email'];
	$user_full_name 	= $users_first_name." ".$users_last_name;
	
	// Profile info
	if(isset($userInfoArr['user_dob']) && ($userInfoArr['user_dob'] != "0000-00-00") && ($userInfoArr['user_dob'] != "")) {
		$user_dob 			= $userInfoArr['user_dob'];
		list($txtDOBMonth, $txtDOBDay, $txtDOBYear) = split('[/.-]', date('m-d-Y', strtotime($user_dob)));			
	}
	$txtAddress1 		= $userInfoArr['user_address1'];
	$txtAddress2 		= $userInfoArr['user_address2'];
	$txtTown 			= $userInfoArr['user_town'];
	$txtState 			= $userInfoArr['user_state'];
	$txtZip 			= $userInfoArr['user_zip'];
	$txtCountry 		= $userInfoArr['user_country'];
	$txtRCountry 		= $userInfoArr['user_rcountry'];

	// Page details
	$page_id  				= 2;
	$pageInfo 				= $cmsObj->fun_getPageInfo($page_id);
    $page_title 			= fun_db_output($pageInfo['page_title']);
    $page_content_title 	= fun_db_output($pageInfo['page_content_title']);
    $page_discription 		= fun_db_output($pageInfo['page_discription']);    $seo_title 				= ($pageInfo['page_seo_title']!="")?$pageInfo['page_seo_title']:$seo_title;
    $seo_keywords 			= ($pageInfo['page_seo_keyword']!="")?$pageInfo['page_seo_keyword']:$seo_keywords;
    $seo_description 		= ($pageInfo['page_seo_discription']!="")?$pageInfo['page_seo_discription']:$seo_description;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo $seo_title;?></title>
    <meta name="description" content="<?php echo $seo_description;?>" />
    <meta name="keywords" content="<?php echo $seo_keywords;?>" />
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo tranText('charset'); ?>" />
    <META HTTP-EQUIV="Content-language" CONTENT="<?php echo tranText('lang_iso'); ?>">
    <link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo SITE_URL; ?>favicon.ico" />
    <link rel="SHORTCUT ICON" href="<?php echo SITE_URL; ?>favicon.ico"/>
    <link rel="stylesheet" type="text/css" href="<?php echo SITE_CSS_INCLUDES_PATH;?>common.css" />
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>common.js"></script>
    <script type="text/javascript" language="JavaScript" src="<?php echo SITE_JS_INCLUDES_PATH;?>dargPop.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>dhtmlwindow.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>required_functions.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>pop-up.js"></script>
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
            strTable += "<select name='txtContactNumberType[]' class='select94'>";
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
            strTable += "<td class='pad-lft10'><input type='text' name='txtContactNumber[]' class='txtBox160' maxlength='15' /></td>";
            strTable += "<td class='pad-lft10 pad-top1' valign='middle'><a href=\"javascript:;\" class='delete-contact' onclick=\"removeElement(\'"+divIdName+"\')\">Delete</a></td>";
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
            strTable1 += "<td class='pad-lft10 pad-top1' valign='middle'> <a href=\"javascript:;\" class='delete-language' onclick=\"removeElement1(\'"+divIdName+"\')\">Delete</a></td>";
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
    
        function cancelRegisterAsOwner(){
            window.location = 'home.php';
        }
    </script>
</head>
<body onmousedown="show_coords(event);">
<!-- Main Wrapper Starts Here -->
<div id="wrapper">
    <!-- Header Include Starts Here -->
    <div id="header" align="center">
        <?php require_once(SITE_INCLUDES_PATH.'header.php'); ?>
    </div>
    <!-- Header Include End Here -->
	<?php require_once(SITE_INCLUDES_PATH.'holidayadvsearch.php'); ?>
	<?php //require_once(SITE_INCLUDES_PATH.'breadcrumb.php'); ?>
    <div id="pg-wrapper" align="center"><h1 class="page-heading">Register as an owner</h1></div>
    <div id="main">
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="left" valign="top">
					<?php require_once(SITE_INCLUDES_PATH.'holidayhome-left.php'); ?>
                </td>
                <td width="30" align="left" valign="top" style="border-right:thin #efefef solid;">&nbsp;</td>
                <td align="left" valign="top" class="font12" style="padding-left:10px;">
					<?php require_once(SITE_INCLUDES_PATH.'holidayregisterasowner.php'); ?>
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
