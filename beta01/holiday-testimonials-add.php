<?php	
	if($_SERVER["SERVER_NAME"] == "localhost") {
		require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
	} else {
		require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
	}

	require_once(SITE_CLASSES_PATH."class.Users.php");
	require_once(SITE_CLASSES_PATH."class.UserSetting.php");
	require_once(SITE_CLASSES_PATH."class.Property.php");
	require_once(SITE_CLASSES_PATH."class.Testimonial.php");
	require_once(SITE_CLASSES_PATH."class.Pagination.php");
	require_once(SITE_CLASSES_PATH."class.Location.php");
	require_once(SITE_CLASSES_PATH."class.CMS.php");
	require_once(SITE_CLASSES_PATH."class.Message.php");
	require_once(SITE_CLASSES_PATH."class.Email.php");

	$usersObj 		= new Users();
	$userSettingObj	= new UserSetting();
	$propertyObj 	= new Property();
	$locationObj 	= new Location();
	$cmsObj         = new Cms();
	$messageObj 	= new Message();
	$testiObj 		= new Testimonial();


	$form_array 	= array();
	$errorMsg 		= 'no';
	if($_POST['securityKey']==md5(ADDTESTIMONIAL)){		
		if(trim($_POST['txtFName']) == '') {
			$form_array['txtFName'] = 'First Name required';
			$errorMsg = 'yes';
		}
		if(trim($_POST['txtLName']) == '') {		
			$form_array['txtLName'] = 'Last Name required';
			$errorMsg = 'yes';
		}
		if(trim($_POST['txtEmail']) == '') {
			$form_array['txtEmail'] = 'Please enter a valid email address';
			$errorMsg = 'yes';
		} else {
			if(preg_match(EMAIL_ID_REG_EXP_PATTERN, $_POST['txtEmail'])) {
			} else {
				$form_array['txtEmail'] = 'Please enter a valid email address';
				$errorMsg = 'yes';
			}
		}
		if(trim($_POST['txtReviewTitle']) == '') {
			$form_array['txtReviewTitle'] = 'Please enter testimonial title';
			$errorMsg = 'yes';
		}
		if(trim($_POST['txtReviewTxt']) == '') {
			$form_array['txtReviewTxt'] = 'Please enter testimonial description';
			$errorMsg = 'yes';
		}
		if(($_SESSION['security_code'] == $_POST['image_vcode']) && ($errorMsg == 'no') && ($errorMsg != 'yes')){		
			$txtFName 			= trim($_POST['txtFName']);
			$txtLName 			= trim($_POST['txtLName']);
			$txtEmail 			= trim($_POST['txtEmail']);
			$txtCountry 		= trim($_POST['txtCountry']);
			$txtReviewTitle 	= trim($_POST['txtReviewTitle']);
			$txtReviewTxt 		= trim($_POST['txtReviewTxt']);
			$txtRating 			= trim($_POST['txtRating']);
			$txtUserSetting 	= trim($_POST['txtUserSetting']);

			$txtSubject 			= "Request: Add new testimonial!";
$msg = '<table width="600"  border="0" cellspacing="10" cellpadding="0">';
$msg .= '<tr><td align="left"><a href="'.SITE_URL.'"><img src="'.SITE_URL.'images/logo.jpg" border="0"></a></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;Hi Admin,</td></tr>
<tr><td>Add new testimonial request, details are as below:</td></tr>
<tr><td><pre>'.print_r($_POST).'</pre></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>Thanks,</td></tr>
<tr><td>'.SITE_URL.' team</td></tr>
</table>';

			$emailObj = new Email("info@rentownersvillas.com", "Administrator  <".SITE_ADMIN_EMAIL.">", $txtSubject, $msg);
			$emailObj->sendEmail();
			redirectURL("holiday-testimonials-add.php?testi=thanks");

			/*
			$testimonial_id		= $testiObj->fun_addTestimonial($txtReviewTitle, $txtReviewTxt, $txtRating, $txtFName, $txtLName, $txtEmail, $txtCountry);
			// Send mail to owner
			$testiObj->fun_sendTestimonialNotification($testimonial_id, $txtReviewTitle, $txtFName, $txtEmail);
			if($testimonial_id){
				redirectURL("holiday-testimonials-add.php?testi=thanks");
			} else {
				redirectURL("holiday-testimonials-add.php");
			}
			*/
		} else {
		$contactsubmit = "Codes must match!";
		}
	}
	/*
	// For Review submit : End Here
	*/
	// Page details
	$page_id  				= 6;
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
    <div id="pg-wrapper" align="center"><h1 class="page-heading">Testimonials</h1></div>
    <div id="main">
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="left" valign="top">
					<?php require_once(SITE_INCLUDES_PATH.'holidayhotproperty-left.php'); ?>
                </td>
                <td width="30" align="left" valign="top" style="border-right:thin #efefef solid;">&nbsp;</td>
                <td align="left" valign="top" class="font12" style="padding-left:10px;">
					<?php
                    if(isset($_GET['testi']) && $_GET['testi'] == "thanks") {
                        require_once(SITE_INCLUDES_PATH.'holidaytestimonials-thanks.php');
                    } else {
                        require_once(SITE_INCLUDES_PATH.'holidaytestimonials-compose.php');
                    }
                    ?>
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
