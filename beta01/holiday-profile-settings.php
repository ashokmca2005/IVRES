<?php	
	require_once("includes/holiday-top.php");
?>
<?php	
	// Form submission
	$form_array 	= array();
	$errorMsg = 'no';

	if($_POST['securityKey']==md5("USERPROFILE")) {		
	/*
		$txtUserSetting 		= $_POST['txtUserSetting'];
	*/
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

		if($errorMsg == 'no' && $errorMsg != 'yes'){		
			if($usersObj->fun_updateUserName($user_id, $_POST['txtUserFName'], $_POST['txtUserLName']) === true){
				$usersObj->fun_updateUserEmail($user_id, $_POST['txtUserEmail']);
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
				// For password changes
				if((isset($_POST['txtOldPassword']) && $_POST['txtOldPassword'] !="") && (isset($_POST['txtNewPassword']) && $_POST['txtNewPassword'] !="")) {
					$txtOldPassword	= $_POST['txtOldPassword'];
					$txtNewPassword	= $_POST['txtNewPassword'];
					if($usersObj->fun_verifyUserPassword($user_id, $txtOldPassword) === true){
						$usersObj->fun_updateUserPassword($user_id, $txtNewPassword);
					}
				}
			}
			redirectURL("holiday-profile-settings.php");
		} else {
			$form_array['error_msg'] = "Please submit your form again!";
		}
	}


	$userInfoArr 		= $usersObj->fun_getUsersInfo($user_id);
//	echo $user_id;
	$userSettingInfoArr	= $usersObj->fun_getUserSettingInfoArr($user_id);
	$users_first_name 	= $userInfoArr['user_fname'];
	$users_last_name 	= $userInfoArr['user_lname'];
	$users_email_id 	= $userInfoArr['user_email'];
	$user_full_name 	= $users_first_name." ".$users_last_name;

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
    <script type="text/javascript" language="javascript">
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
        
            if(document.getElementById("txtUserChangePasswordId").value == "1") {
                if(document.getElementById("txtOldPasswordId").value == "") {
                    document.getElementById("showErrorOldPassword").innerHTML = "Please enter current password";
                    document.getElementById("txtOldPasswordId").focus();
                    return false;
                } else {
                    document.getElementById("showErrorOldPassword").innerHTML = "";
                }
        
                if(document.getElementById("txtNewPasswordId").value == "") {
                    document.getElementById("showErrorNewPassword").innerHTML = "Please enter new password";
                    document.getElementById("txtNewPasswordId").focus();
                    return false;
                } else {
                    document.getElementById("showErrorNewPassword").innerHTML = "";
                }
        
                if(document.getElementById("txtConfirmPasswordId").value == "") {
                    document.getElementById("showErrorConfirmPassword").innerHTML = "Please confirm new password";
                    document.getElementById("txtConfirmPasswordId").focus();
                    return false;
                } else {
                    document.getElementById("showErrorConfirmPassword").innerHTML = "";
                }
        
                if(document.getElementById("txtNewPasswordId").value != document.getElementById("txtConfirmPasswordId").value) {
                    document.getElementById("showErrorConfirmPassword").innerHTML = "Please confirm new password";
                    document.getElementById("txtConfirmPasswordId").focus();
                    return false;
                } else {
                    document.getElementById("showErrorConfirmPassword").innerHTML = "";
                }
            }
        }
        
        function showChangePassword(str) {
            var str = str;
            if(str == 1) {
                document.getElementById("showchangepassLinkId").style.display = "none";
                document.getElementById("showchangepassId").style.display = "block";
                document.getElementById("txtUserChangePasswordId").value = "1";
            } else if(str == 0) {
                document.getElementById("showchangepassLinkId").style.display = "block";
                document.getElementById("showchangepassId").style.display = "none";
                document.getElementById("txtUserChangePasswordId").value = "0";
            }
        }
        
        function chkblnkTxtError(strFieldId, strErrorFieldId) {
            if(document.getElementById(strFieldId).value != "") {
                document.getElementById(strErrorFieldId).innerHTML = "";
            }
        }
        
        function cancelChangeProfile(){
            window.location = 'holiday-profile-settings.php';
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
    <div id="pg-wrapper" align="center"><h1 class="page-heading">My profile and settings</h1></div>
    <div id="main">
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="left" valign="top">
					<?php require_once(SITE_INCLUDES_PATH.'holidayhome-left.php'); ?>
                </td>
                <td width="30" align="left" valign="top" style="border-right:thin #efefef solid;">&nbsp;</td>
                <td align="left" valign="top" class="font12" style="padding-left:10px;">
					<?php require_once(SITE_INCLUDES_PATH.'holidayprofile.php'); ?>
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
