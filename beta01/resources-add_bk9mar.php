<?php	
	if($_SERVER["SERVER_NAME"] == "localhost") {
		require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
	} else {
		require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
	}
	require_once(SITE_CLASSES_PATH."class.Users.php");
	require_once(SITE_CLASSES_PATH."class.Resource.php");
	require_once(SITE_CLASSES_PATH."class.Property.php");
	require_once(SITE_CLASSES_PATH."class.Location.php");
	require_once(SITE_CLASSES_PATH."class.Email.php");

	$usersObj 		= new Users();
	$resObj			= new Resource();
	$propertyObj 	= new Property();
	$locationObj 	= new Location();
	if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !=""){
		$user_id 			= $_SESSION['ses_user_id'];
		$userInfoArr 		= $usersObj->fun_getUsersInfo($user_id);
		$users_first_name 	= $userInfoArr['user_fname'];
		$users_last_name 	= $userInfoArr['user_lname'];
		$users_email_id 	= $userInfoArr['user_email'];
		$user_full_name 	= ucwords($users_first_name." ".$users_last_name);
	}

	// Form submission
	$form_array 	= array();
	$errorMsg = 'no';
	if($_POST['securityKey'] == md5("RESOURCES")) {
		if(trim($_POST['txtUserFName']) == '') {
			$form_array['txtUserFName'] = 'Enter first name';
			$errorMsg = 'yes';
		}
		if(trim($_POST['txtUserLName']) == '') {		
			$form_array['txtUserLName'] = 'Enter last name';
			$errorMsg = 'yes';
		}
		if(trim($_POST['txtUserEmail']) == '') {
			$form_array['txtUserEmail'] = 'Enter valid email address';
			$errorMsg = 'yes';
		} else {
			if(preg_match(EMAIL_ID_REG_EXP_PATTERN, $_POST['txtUserEmail'])) {
				// Check if email already exist
				/*
				if($usersObj->fun_checkEmailAddress($_POST['txtUserEmail']) === true) {
					$form_array['txtUserEmail'] = 'Email address already exists';
					$errorMsg = 'yes';
				}
				*/
			} else {
				$form_array['txtUserEmail'] = 'Enter valid email address';
				$errorMsg = 'yes';
			}
		}

		if(trim($_POST['txtResourceCategory']) == '') {		
			$form_array['txtResourceCategory'] = 'Select category';
			$errorMsg = 'yes';
		}
		if((trim($_POST['txtResourceUrl']) == '') || (trim($_POST['txtResourceUrl']) == "http://")) {		
			$form_array['txtResourceUrl'] = 'Enter URL';
			$errorMsg = 'yes';
		}
		if(trim($_POST['txtResourceTitle']) == '') {
			$form_array['txtResourceTitle'] = 'Enter title';
			$errorMsg = 'yes';
		}
		if(trim($_POST['txtResourceDesc']) == '') {
			$form_array['txtResourceDesc'] = 'Enter resource description';
			$errorMsg = 'yes';
		}
		if((trim($_POST['txtResourceOLUrl']) == '') || (trim($_POST['txtResourceOLUrl']) == "http://")) {		
			$form_array['txtResourceOLUrl'] = 'Enter URL';
			$errorMsg = 'yes';
		}
		if(($errorMsg == 'no') && ($errorMsg != 'yes')){		
			// add resources
			$txtUserFName 			= trim($_POST['txtUserFName']);
			$txtUserLName 			= trim($_POST['txtUserLName']);
			$txtUserEmail 			= trim($_POST['txtUserEmail']);
			$txtResourceCategory	= trim($_POST['txtResourceCategory']);
			$txtArea				= trim($_POST['txtArea']);
			$txtRegion				= trim($_POST['txtRegion']);
			$txtSubRegion			= trim($_POST['txtSubRegion']);
			$txtLocation			= trim($_POST['txtLocation']);
			$txtResourceUrl			= trim($_POST['txtResourceUrl']);
			$txtResourceTitle		= trim($_POST['txtResourceTitle']);
			$txtResourceDesc		= trim($_POST['txtResourceDesc']);
			$txtResourceOLUrl		= trim($_POST['txtResourceOLUrl']);
			$resource_id			= $resObj->fun_addResource($txtResourceCategory, $txtResourceTitle, $txtResourceDesc, $txtArea, $txtRegion, $txtSubRegion, $txtLocation, $txtResourceUrl, $txtResourceOLUrl);
			if(isset($user_id) && $user_id != "") {
				// update user details, first name, last name, email id
				$usersObj->fun_updateUserNameEmail($user_id, $txtUserFName, $txtUserLName, $txtUserEmail);
			} else {
				// verify email id, if match then update first name, last name and return user_id
				if($usersObj->fun_checkEmailAddress($txtUserEmail) === true) {
					$user_id 	= $dbObj->getField(TABLE_USERS, "user_email", $txtUserEmail, "user_id");
					$usersObj->fun_updateUserNameEmail($user_id, $txtUserFName, $txtUserLName, $txtUserEmail);
				} else {
				// if email not matched, add new user
					$txtUserPasswd 	= md5('anonymous');
					$user_id		= $usersObj->fun_registerUser($txtUserEmail, $txtUserPasswd, $txtUserFName, $txtUserLName, $txtUserEmail, "", "", "", "", "", "", "", "", "", "", "0");
				}
			}
			//add / update  user resource relation
			$usersObj->fun_addUserResourceRelation($resource_id, $user_id, "0");
			if($resource_id != "") {
				redirectURL("resources-thanks.php?rsid=".$resource_id);
			} else {
				redirectURL("resources.php");
			}
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
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>owner.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>dhtmlwindow.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>pop-up.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>tab_menu.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>dargPop.js"></script>
    <script type="text/javascript" language="javascript">
	var req = ajaxFunction();
	var x, y;
	function show_coords(event){	
		x=event.clientX;
		y=event.clientY;
		x = x-160;
		y = y+4;
	//	alert(x);alert(y);
	}
	function toggleLayer(whichLayer){
		var output = document.getElementById(whichLayer).innerHTML;
		if(whichLayer == 'ANP-Example') {		
			output = '<div style="z-index:5;">'+output+'</div>';
			var googlewin=dhtmlwindow.open("Example", "inline", output, "", "width=295px,height=470px,resize=0,scrolling=0,center=1,xAxis="+x+",yAxis="+y+"", "recal");
		}
		googlewin.onclose=function() { //Run custom code when window is being closed (return false to cancel action):
			return true
		}
	}

	function closeWindow() {	
		document.getElementById("Example").style.display="none";
	}

	function closeWindowNRefresh() {
		document.getElementById("Example").style.display="none";
		window.location = location.href;
	}
</script>
</head>
<body onmousedown="show_coords(event);" onload="setDefaultCountry('223');">
<!-- Main Wrapper Starts Here -->
<div id="wrapper">
    <!-- Header Include Starts Here -->
    <div id="header">
        <?php require_once(SITE_INCLUDES_PATH.'header.php'); ?>
    </div>
    <!-- Header Include End Here -->
    <div id="main">
        <div id="forinner">
            <?php require_once(SITE_INCLUDES_PATH.'holidayadvsearch.php'); ?>
            <div class="littlefont nav8">
                <?php require_once(SITE_INCLUDES_PATH.'breadcrumb.php'); ?>
            </div>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="left" valign="top" class="width240">
                        <?php require_once(SITE_INCLUDES_PATH.'holiday-resources-left-links.php'); ?>
                    </td>
                    <td width="10" align="left" valign="top" style="border-left:1px dashed #44afe1;">&nbsp;</td>
                    <td align="left" valign="top" class="width745 pad-lft15">
                        <?php require_once(SITE_INCLUDES_PATH.'resources-add.php'); ?>
                    </td>
                </tr>
            </table>
        </div>
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
