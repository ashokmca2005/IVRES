<?php	
	if($_SERVER["SERVER_NAME"] == "localhost") {
		require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
	} else {
		require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
	}
	require_once(SITE_CLASSES_PATH."class.Users.php");
	require_once(SITE_CLASSES_PATH."class.Property.php");
	require_once(SITE_CLASSES_PATH."class.Email.php");
	$usersObj 		= new Users();
	$propertyObj 	= new Property();
	if(isset($_REQUEST['uId'])){
		$user_id = base64_decode($_REQUEST['uId']);
		if($usersObj->fun_activeUsersLink($user_id)){
			$usersObj->sendWelcomeEmailToUser($user_id);
			$usersDets = $usersObj->fun_getUsersInfo($user_id, '');
			$_SESSION['ses_user_id'] 	= $usersDets['user_id'];
			$_SESSION['ses_user_fname'] = $usersDets['user_fname'];
			$_SESSION['ses_user_email'] = $usersDets['user_email'];
			$_SESSION['ses_user_pass'] 	= $usersDets['user_pass'];

			if(isset($usersDets["is_owner"])) {
				if($usersDets["is_owner"]=="1") { // user is property owner go to add new property page
					$_SESSION['ses_user_home'] = SITE_URL."owner-home";
					//redirectURL(SITE_URL."owner-home"); // owner dashboard
					$owner_package_payment_status = $propertyObj->fun_getUserPackageBasketPaymentStatus($user_id);
					if(isset($owner_package_payment_status) == "1") {
						redirectURL(SITE_URL."owner-shopping-cart");
						exit(0);
					}
				} else { // user is holidaymaker go to checklist page
					$_SESSION['ses_user_home'] = SITE_URL."home";
					//redirectURL("confirmation.php");
					//redirectURL(SITE_URL."home"); // Holiday maker dashboard
				}
			}
		}
		redirectURL("confirmation.php");
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
<body onmousedown="show_coords(event);" >
<!-- Main Wrapper Starts Here -->
<div id="wrapper">
    <!-- Header Include Starts Here -->
    <div id="header" align="center">
        <?php require_once(SITE_INCLUDES_PATH.'header.php'); ?>
    </div>
    <!-- Header Include End Here -->
	<?php require_once(SITE_INCLUDES_PATH.'holidayadvsearch.php'); ?>
	<?php //require_once(SITE_INCLUDES_PATH.'breadcrumb.php'); ?>
    <div id="pg-wrapper" align="center"><h1 class="page-heading">Confirmation!</h1></div>
    <div id="main">
        <!-- confirmation thanks : start here -->
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <table border="0" cellspacing="0" cellpadding="0" width="100%">
            <tr>
                <td valign="top" width="120px">&nbsp;</td>
                <td valign="top" class="pad-top10">
                    <span><img src="<?php echo SITE_IMAGES;?>green-arrow-new.png" width="30" />&nbsp;&nbsp;</span><span class="latedealPink-20">Thanks ...</span><span style="font-weight:normal; font-size:20px;"> Your email address has been confirmed</span>
                </td>
                <td valign="middle" align="left" class="pad-top10 pad-rgt10" width="330px"><a href="<?php echo $_SESSION['ses_user_home']; ?>" class="button-grey" style="text-decoration:none;">Go to homepage</a></td>
            </tr>
        </table>                    
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <!-- confirmation thanks : end here -->
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
