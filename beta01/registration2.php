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
	
	if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !=""){ // login then redirect to its home page
		redirectURL($_SESSION['ses_user_home']);
	} else {
		$user_id = "";
		if(!isset($_SESSION['registraton_id'])) {
			redirectURL("index.php");
		}
	}

	if($_POST['securityKey']==md5("NEWREGISTRATION2")){	
		if($usersObj->sendActivationEmailToUserNew($_POST['txtUserId'])){	
			redirectURL("registration2.php");
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
    
        function cancelRegistration() {
            window.location = 'index.php';
        }
        
        function chkblnkTxtError(strFieldId, strErrorFieldId) {
            if(document.getElementById(strFieldId).value != "") {
                document.getElementById(strErrorFieldId).innerHTML = "";
            }
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
    <div id="pg-wrapper" align="center"><h1 class="page-heading">Testimonials</h1></div>
    <div id="main">
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="left" valign="top">
					<?php require_once(SITE_INCLUDES_PATH.'holidayhotproperty-left.php'); ?>
                </td>
                <td width="30" align="left" valign="top" style="border-right:thin #efefef solid;">&nbsp;</td>
                <td align="left" valign="top" class="font12" style="padding-left:10px;">
                    <table border="0" cellspacing="0" cellpadding="0" width="100%">
                        <tr><td valign="top" class="pad-top10 pad-rgt10"><span><img src="<?php echo SITE_IMAGES;?>green-arrow-new.png" width="30" />&nbsp;&nbsp;</span><span class="latedealPink-20">Thanks ...</span><span style="font-weight:normal; font-size:20px;"> you're almost there!</span></td></tr>
                        <tr><td valign="top" class="pad-rgt10 pad-top20" style="padding-left:5px;"><div class="font12 pad-lft20">You will shortly receive a confirmation email. Just click on the link to confirm your email address</div></td></tr>
                        <tr>
                            <td align="left" valign="top" class="pad-top20" style="padding-left:30px;">
                                <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" name="RegForm" id="RegForm">
                                    <input type="hidden" name="securityKey" value="<?php echo md5(NEWREGISTRATION2);?>">
                                    <input type="hidden" name="txtUserId" value="<?php echo $_SESSION['registraton_id']; ?>">
                                    <input type="hidden" name="txtUserPasswrd" value="<?php echo $_SESSION['registraton_pass']; ?>">
                                    <span class="pink18">If you don't receive the email</span>
                                    <br />
                                    <span class="font12">The confirmation email should be with you in a few mintues. If it isn't then check your JUNK MAIL folder or SPAM folders. Failing that add info@rentownersvillas.com to your Email Address Book or Safe Sender list and click the Resend Email button below. <br /><br />It's useful to do this anyway to ensure future emails from us arrive in your inbox.</span>
                                    <p class="pad-top10">
                                        <input src="images/resendemail.gif" type="image" width="128" height="30" />
                                    </p>
                                </form>
                            </td>
                        </tr>
                    </table>                    
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
