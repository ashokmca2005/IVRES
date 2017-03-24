<?php	
	require_once("includes/holiday-top.php");
?>
<?php	
	// Form submission
	$form_array 	= array();
	$errorMsg = 'no';
	if($_POST['securityKey']==md5("TELLYOURFRIEND")) {
		if(trim($_POST['txtUserSubject']) == '') {
			$form_array['txtUserSubject'] = 'Please enter subject';
			$errorMsg = 'yes';
		}
		if(trim($_POST['txtUserMessage']) == '') {		
			$form_array['txtUserMessage'] = 'Please enter message';
			$errorMsg = 'yes';
		}
		if(trim($_POST['txtUserEmails']) == '') {
			$form_array['txtUserEmails'] = 'Please enter a valid email address';
			$errorMsg = 'yes';
		} else {
			$txtUserEmails 		= trim($_POST['txtUserEmails']);
			$txtUserEmailsArr = split(",", $txtUserEmails);
			for($i = 0; $i < count($txtUserEmailsArr); $i++) {
				$txtUserEmail = $txtUserEmailsArr[$i];
				if(preg_match(EMAIL_ID_REG_EXP_PATTERN, $txtUserEmail)) {
				} else {
					$form_array['txtUserEmails'] = 'Please enter a valid email address';
					$errorMsg = 'yes';
				}
			}
		}

		if(($errorMsg == 'no') && ($errorMsg != 'yes')){		
			$txtUserSubject 			= trim($_POST['txtUserSubject']);
			$txtUserMessage 			= trim($_POST['txtUserMessage']);
			for($j = 0; $j < count($txtUserEmailsArr); $j++) {
				$txtUserEmail = $txtUserEmailsArr[$j];
				$usersObj->fun_sendTellaFriendEmail($user_id, $users_first_name, $txtUserEmail, fun_db_output($txtUserSubject), fun_db_output($txtUserMessage));
			}
			redirectURL("holiday-tell-a-friends.php?msg=thanks");
		} else {
			$form_array['error_msg'] = "Please submit your form again!";
		}
	}

	// Page details
	$page_id  				= 14;
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
    function validateTellaFriend(){
        if(document.getElementById("txtUserFriendEmailId").value == "") {
            document.getElementById("showErrorUserFriendEmailId").innerHTML = "Enter valid email address";
            document.getElementById("txtUserFriendEmailId").focus();
            return false;
        } else {
            var emailRegxp1 = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if (emailRegxp1.test(document.getElementById("txtUserFriendEmailId").value)!= true){
                document.getElementById("showErrorUserFriendEmailId").innerHTML = "Enter valid email address";
                document.getElementById("txtUserFriendEmailId").value = "";
                document.getElementById("txtUserFriendEmailId").focus();
                return false;
            }
        }
        if(document.getElementById("txtUserSubjectId").value == "") {
            document.getElementById("showErrorUserSubjectId").innerHTML = "Enter subject";
            document.getElementById("txtUserSubjectId").focus();
            return false;
        }
        if(document.getElementById("txtUserMessageId").value == "") {
            document.getElementById("txtErrorUserMessageId").innerHTML = "Enter message";
            document.getElementById("txtUserMessageId").focus();
            return false;
        }
        if(document.getElementById("txtTermConditionsId").checked != true) {
            document.getElementById("txtTermConditionsErrorId").innerHTML = "Please read term and conditions";
            return false;
        }
    }
    function chkblnkTxtError(strFieldId, strErrorFieldId) {
        if(document.getElementById(strFieldId).value != "") {
            document.getElementById(strErrorFieldId).innerHTML = "";
        }
    }
    function cancelTellaFriend(){
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
    <div id="pg-wrapper" align="center"><h1 class="page-heading">Tell your friends</h1></div>
    <div id="main">
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="left" valign="top">
					<?php require_once(SITE_INCLUDES_PATH.'holidayhome-left.php'); ?>
                </td>
                <td width="30" align="left" valign="top" style="border-right:thin #efefef solid;">&nbsp;</td>
                <td align="left" valign="top" class="font12" style="padding-left:10px;">
					<?php require_once(SITE_INCLUDES_PATH.'holidaytellafriends.php'); ?>
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
