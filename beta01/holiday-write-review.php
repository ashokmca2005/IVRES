<?php	
	if($_SERVER["SERVER_NAME"] == "localhost") {
		require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
	} else {
		require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
	}
	require_once(SITE_CLASSES_PATH."class.Users.php");
	require_once(SITE_CLASSES_PATH."class.Property.php");
	require_once(SITE_CLASSES_PATH."class.Location.php");
	require_once(SITE_CLASSES_PATH."class.CMS.php");

	$usersObj 		= new Users();
	$propertyObj 	= new Property();
	$locationObj 	= new Location();
	$cmsObj         = new Cms();

	if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !=""){
		$user_id = $_SESSION['ses_user_id'];
		$userInfoArr 		= $usersObj->fun_getUsersInfo($user_id);
		$users_email_id 	= $userInfoArr['user_email'];
	} else {
		$user_id = "";
	}

	if(isset($_GET['pid']) && $_GET['pid'] !=""){
		$property_id 		= $_GET['pid'];
		$propertyInfo		= $propertyObj->fun_getPropertyInfo($property_id);
		$propLocInfoArr 	= $propertyObj->fun_getPropertyLocInfoArr($property_id);
		$fr_url 			= $propertyObj->fun_getPropertyFriendlyLink($property_id);
		if(isset($fr_url) && $fr_url != "") {
			$review_property_link 		= SITE_URL."vacation-rentals/".strtolower($fr_url);
		} else {
			if(isset($propLocInfoArr['location_name']) && $propLocInfoArr['location_name'] != "") {
				$review_property_link = SITE_URL."vacation-rentals/in.".str_replace(" ", "-", strtolower($propLocInfoArr['location_name']))."/".fill_zero_left($property_id, "0", (6-strlen($property_id)));
			} else {
				$review_property_link = SITE_URL."vacation-rentals/in.".str_replace(" ", "-", strtolower($propLocInfoArr['region_name']))."/".fill_zero_left($property_id, "0", (6-strlen($property_id)));
			}
		}
		//print_r($propertyInfo);
	}
	/*
	// For Review submit : Start Here
	*/
	$detail_array 	= array();
	$error_msg		= 'no';
	if($_POST['securityKey']==md5(HOLIDAYPROPERTYREVIEW)){		
		$txtFName 			= $_POST['txtFName'];
		$txtLName 			= $_POST['txtLName'];
		$txtUserReviewEmail = $_POST['txtUserReviewEmail'];
		$txtCountry 		= $_POST['txtCountry'];
		$txtReviewTitle 	= $_POST['txtReviewTitle'];
		$txtReviewTxt 		= $_POST['txtReviewTxt'];
		$txtRating 			= $_POST['txtRating'];
		$txtUserSetting 	= $_POST['txtUserSetting'];
		if($error_msg == 'no') {
			if($propertyObj->fun_verifyPropertyReviewUserEmail($property_id, $txtUserReviewEmail) == true) {
				$detail_array['error_msg'] = "Error: already review added for this email id, use any other mail id!";
			} else {
				if($propertyObj->fun_addPropertyReview("", $property_id, $txtRating, $txtReviewTitle, $txtReviewTxt, $txtFName, $txtLName, $txtUserReviewEmail, $txtCountry, "1") === true){
					redirectURL("holiday-write-review.php?pid=".$property_id."&review=thanks");
				} else {
					$detail_array['error_msg'] = "Error: We are unable to add your review!";
				}
			}
		} else {
			$detail_array['error_msg'] = "Please submit your form again!";
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
    <div id="pg-wrapper" align="center"><h1 class="page-heading">Write a review</h1></div>
    <div id="main">
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="left" valign="top">
					<?php require_once(SITE_INCLUDES_PATH.'holidayhotproperty-left.php'); ?>
                </td>
                <td width="30" align="left" valign="top" style="border-right:thin #efefef solid;">&nbsp;</td>
                <td align="left" valign="top" class="font12" style="padding-left:10px;">
					<?php 
                    if(isset($_GET['review']) && $_GET['review'] == "thanks") {
                        require_once(SITE_INCLUDES_PATH.'holidaywriteareview-thanks.php');
                    } else {
                        require_once(SITE_INCLUDES_PATH.'holidaywriteareview-compose.php');
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
