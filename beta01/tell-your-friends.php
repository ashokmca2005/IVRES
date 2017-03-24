<?php	
	if($_SERVER["SERVER_NAME"] == "localhost") {
		require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
	} else {
		require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
	}

	require_once(SITE_CLASSES_PATH."class.Users.php");
	require_once(SITE_CLASSES_PATH."class.Property.php");
	require_once(SITE_CLASSES_PATH."class.CMS.php");
	require_once(SITE_CLASSES_PATH."class.Email.php");
	$usersObj 		= new Users();
	$propertyObj 	= new Property();
	$cmsObj         = new Cms();
	if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !=""){
		$user_id = $_SESSION['ses_user_id'];
	} else {
		$user_id = "";
	}

	// Form submission
	$form_array 	= array();
	$errorMsg = 'no';
	if($_POST['securityKey'] == md5("TELLYOURFRIEND")) {
		if(trim($_POST['txtUserSubject']) == '') {
			$form_array['txtUserSubject'] = 'Enter subject';
			$errorMsg = 'yes';
		}
		if(trim($_POST['txtUserMessage']) == '') {		
			$form_array['txtUserMessage'] = 'Enter message';
			$errorMsg = 'yes';
		}
		if(trim($_POST['txtUserEmails']) == '') {
			$form_array['txtUserEmails'] = 'Enter valid email address';
			$errorMsg = 'yes';
		} else {
			$txtUserEmails 		= trim($_POST['txtUserEmails']);
			$txtUserEmailsArr = split(",", $txtUserEmails);
			for($i = 0; $i < count($txtUserEmailsArr); $i++) {
				$txtUserEmail = $txtUserEmailsArr[$i];
				if(preg_match(EMAIL_ID_REG_EXP_PATTERN, $txtUserEmail)) {
				} else {
					$form_array['txtUserEmails'] = 'Enter valid email address';
					$errorMsg = 'yes';
				}
			}
		}

		if(($errorMsg == 'no') && ($errorMsg != 'yes')){		
			$txtUserSubject 			= trim($_POST['txtUserSubject']);
			$txtUserMessage 			= trim($_POST['txtUserMessage']);
			for($j = 0; $j < count($txtUserEmailsArr); $j++) {
				$txtUserEmail = $txtUserEmailsArr[$j];
				$usersObj->fun_sendTellOurFriendEmail($txtUserEmail, $txtUserSubject, $txtUserMessage);
			}
			redirectURL("tell-your-friends.php?msg=thanks");
		} else {
			$form_array['error_msg'] = "Please submit form again";
		}
	}
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
	<script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>pop-up.js"></script>
    <script language="javascript" type="text/javascript">
	var x, y;
	function show_coords(event){	
		x=event.clientX;
		y=event.clientY;
		x = x-160;
		y = y+4;
		//alert(x);alert(y);
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
    <div id="pg-wrapper" align="center"><h1 class="page-heading">Tell your friends ...</h1></div>
    <div id="main">
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="left" valign="top">
					<?php require_once(SITE_INCLUDES_PATH.'holidayhotproperty-left.php'); ?>
                </td>
                <td width="30" align="left" valign="top" style="border-right:thin #efefef solid;">&nbsp;</td>
                <td align="left" valign="top" class="font12" style="padding-left:10px;">
					<?php require_once(SITE_INCLUDES_PATH.'tellyourfriends.php'); ?>
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
