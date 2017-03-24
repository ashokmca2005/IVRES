<?php
	if($_SERVER["SERVER_NAME"] == "localhost") {
		require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
	} else {
		require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
	}
	require_once(SITE_CLASSES_PATH."class.Users.php");
	require_once(SITE_CLASSES_PATH."class.Property.php");
	require_once(SITE_CLASSES_PATH."class.Event.php");
	require_once(SITE_CLASSES_PATH."class.Travel.php");
	require_once(SITE_CLASSES_PATH."class.CMS.php");
	require_once(SITE_CLASSES_PATH."class.Banner.php");

	$usersObj 		= new Users();
	$propertyObj 	= new Property();
	$eventObj 		= new Event();
	$tvlguidObj		= new Travel();
	$cmsObj         = new Cms();
	$bannerObj      = new Banner();

	if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !=""){
		$user_id 			= $_SESSION['ses_user_id'];
		$userInfoArr 		= $usersObj->fun_getUsersInfo($user_id);
		$users_first_name 	= $userInfoArr['user_fname'];
		$users_last_name 	= $userInfoArr['user_lname'];
		$users_email_id 	= $userInfoArr['user_email'];
		$user_full_name 	= ucwords($users_first_name." ".$users_last_name);
		$country_id 		= $userInfoArr['user_country'];
		$rcountry_id 		= $userInfoArr['user_rcountry'];
		$users_currency_code= $usersObj->fun_getUserCurrencyCode($user_id);
	} else {
		$users_currency_code= $usersObj->fun_getUserCurrencyCode();
	}

	switch($users_currency_code) {
		case 'USD':
			$users_currency_id 	= 1;
		break;
		case 'GBP':
			$users_currency_id 	= 2;
		break;
		case 'EUR':
			$users_currency_id 	= 3;
		break;
		default:
			$users_currency_id 	= DEFAULT_CURRENCY;
	}
	$users_currency_symbol 	= $usersObj->fun_getUserCurrencySymbol($users_currency_code);
	$currencyRateArr		= $propertyObj->fun_findPropertyCurrencyRate();

	// Page details
	$page_id  				= 1;
	$pageInfo 				= $cmsObj->fun_getPageInfo($page_id);
    $page_title 			= fun_db_output($pageInfo['page_title']);
    $page_content_title 	= fun_db_output($pageInfo['page_content_title']);
    $page_discription 		= fun_db_output($pageInfo['page_discription']);
    $seo_title 				= ($pageInfo['page_seo_title']!="")?$pageInfo['page_seo_title']:$seo_title;
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
    <meta name="google-site-verification" content="957kTJhIUnHK1pmvR9MPtqkmbRimiGoF586_jTLLMSc" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta http-equiv="expires" content="never" />
    <meta name="copyright" content="(c)Copyright <?php echo date("Y");?> rentownersvillas.com. All rights reserved." />
    <link rel="canonical" href="<?php echo SITE_URL; ?>" />
    <link href="<?php echo SITE_CSS_INCLUDES_PATH;?>common.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>common.js"></script>
</head>
<body>
<!-- Main Wrapper Starts Here -->
<div id="wrapper">
    <!-- Header Include Starts Here -->
    <div id="header" align="center">
        <?php require_once(SITE_INCLUDES_PATH.'header-main.php'); ?>
    </div>
    <!-- Header Include End Here -->
	<?php require_once(SITE_INCLUDES_PATH.'homepagerotator.php'); ?>
    <div id="main">
        <?php require_once(SITE_INCLUDES_PATH.'mainpage.php'); ?>
    </div>
</div>
<!-- Main Wrapper End Here -->
<!-- Footer Include Starts Here -->
<div id="footer">
    <?php require_once(SITE_INCLUDES_PATH.'footer-main.php'); ?>
</div>
<!-- Footer Include End Here -->
</body>
</html>