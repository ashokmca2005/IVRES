<?php
session_start();
/*
ini_set('memory_limit', '-1');
error_reporting(E_ALL-E_NOTICE);
ini_set('allow_call_time_pass_reference', true);
ini_set("display_errors", "On");
ini_set("max_execution_time", "0");
*/

// General Variable
define("SITE_NAME", "yourdomain.com"); // Site Name 
define("SITE_URL", "http://localhost/ivres/beta01/"); // Site URL
define("SITE_SECURE_URL", "https://localhost/ivres/beta01/"); // Secure Site URL
define("SITE_ADMIN_URL", "https://localhost/ivres/adm/"); // Site Admin URL
define("SITE_DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/"); // Site DOC ROOT

define("SITE_INCLUDES_PATH", SITE_DOC_ROOT . "includes/");
define("SITE_ADMIN_INCLUDES_PATH", $_SERVER["DOCUMENT_ROOT"]."/ivres/adm/includes/");
define("SITE_ADMIN_INCLUDES_PATH", SITE_DOC_ROOT . "adm/includes/");
define("SITE_CLASSES_PATH", SITE_ADMIN_INCLUDES_PATH . "classes/");
define("SITE_JS_INCLUDES_PATH", SITE_URL . "includes/js/");
define("SITE_CSS_INCLUDES_PATH", SITE_URL . "css/");

// Upload Path Variable
define("SITE_UPLOAD_DIR", SITE_DOC_ROOT . "upload/");

define("PROPERTY_IMAGES", SITE_UPLOAD_DIR . "property_images/");
define("PROPERTY_IMAGES_LARGE", PROPERTY_IMAGES . "large/");
define("PROPERTY_IMAGES_THUMB", PROPERTY_IMAGES . "thumbnail/");
define("PROPERTY_IMAGES_LARGE600x450", PROPERTY_IMAGES . "large/600x450/");
define("PROPERTY_IMAGES_LARGE480x360", PROPERTY_IMAGES . "large/480x360/");
define("PROPERTY_IMAGES_LARGE244x183", PROPERTY_IMAGES . "large/244x183/");
define("PROPERTY_IMAGES_THUMB168x126", PROPERTY_IMAGES . "thumbnail/168x126/");
define("PROPERTY_IMAGES_THUMB88x66", PROPERTY_IMAGES . "thumbnail/88x66/");

define("PROPERTY_VIDEO_DIR", SITE_UPLOAD_DIR . "property_videos/video/");
define("PROPERTY_VIDEO_THUMB_SMALL", PROPERTY_VIDEO_DIR . "property_videos/frame_small/");
define("PROPERTY_VIDEO_THUMB_LARGE", PROPERTY_VIDEO_DIR . "property_videos/frame_large/");

define("EVENT_IMAGES", SITE_UPLOAD_DIR . "event_images/");
define("EVENT_IMAGES_LARGE", EVENT_IMAGES . "large/");
define("EVENT_IMAGES_THUMB", EVENT_IMAGES . "thumbnail/");
define("EVENT_IMAGES_LARGE449x341", EVENT_IMAGES_LARGE . "449x341/");
define("EVENT_IMAGES_THUMB168x127", EVENT_IMAGES_THUMB . "168x127/");

define("TVLGUID_IMAGES", SITE_UPLOAD_DIR . "tvlguid_images/");
define("TVLGUID_IMAGES_LARGE", TVLGUID_IMAGES . "large/");
define("TVLGUID_IMAGES_THUMB", TVLGUID_IMAGES . "thumbnail/");
define("TVLGUID_IMAGES_LARGE690x300", TVLGUID_IMAGES_LARGE . "690x300/");
define("TVLGUID_IMAGES_LARGE449x341", TVLGUID_IMAGES_LARGE . "449x341/");
define("TVLGUID_IMAGES_THUMB168x127", TVLGUID_IMAGES_THUMB . "168x127/");

define("SITE_DOWNLOAD_DIR", SITE_DOC_ROOT . "download/");
define("SITE_DOWNLOAD_PDF_DIR", SITE_DOWNLOAD_DIR . "pdf/");

// Absolute Path Variable
define("SITE_UPLOAD_PATH", SITE_URL . "upload/");
define("SITE_IMAGES", SITE_URL . "images/");
define("SITE_ADMIN_IMAGES", SITE_ADMIN_URL . "images/");

define("PROPERTY_IMAGES_PATH", SITE_UPLOAD_PATH . "property_images/");
define("PROPERTY_IMAGES_LARGE_PATH", PROPERTY_IMAGES_PATH . "large/");
define("PROPERTY_IMAGES_THUMB_PATH", PROPERTY_IMAGES_PATH . "thumbnail/");
define("PROPERTY_IMAGES_LARGE600x450_PATH", PROPERTY_IMAGES_LARGE_PATH . "600x450/");
define("PROPERTY_IMAGES_LARGE480x360_PATH", PROPERTY_IMAGES_LARGE_PATH . "480x360/");
define("PROPERTY_IMAGES_LARGE244x183_PATH", PROPERTY_IMAGES_LARGE_PATH . "244x183/");
define("PROPERTY_IMAGES_THUMB168x126_PATH", PROPERTY_IMAGES_THUMB_PATH . "168x126/");
define("PROPERTY_IMAGES_THUMB88x66_PATH", PROPERTY_IMAGES_THUMB_PATH . "88x66/");

define("PROPERTY_VIDEO_THUMB_SMALL_PATH", SITE_UPLOAD_PATH . "property_videos/frame_small/");
define("PROPERTY_VIDEO_THUMB_LARGE_PATH", SITE_UPLOAD_PATH . "property_videos/frame_large/");

define("EVENT_IMAGES_PATH", SITE_UPLOAD_PATH . "event_images/");
define("EVENT_IMAGES_LARGE_PATH", EVENT_IMAGES_PATH . "large/");
define("EVENT_IMAGES_THUMB_PATH", EVENT_IMAGES_PATH . "thumbnail/");
define("EVENT_IMAGES_LARGE449x341_PATH", EVENT_IMAGES_LARGE_PATH . "449x341/");
define("EVENT_IMAGES_THUMB168x127_PATH", EVENT_IMAGES_THUMB_PATH . "168x127/");

define("TVLGUID_IMAGES_PATH", SITE_UPLOAD_PATH . "tvlguid_images/");
define("TVLGUID_IMAGES_LARGE_PATH", TVLGUID_IMAGES_PATH . "large/");
define("TVLGUID_IMAGES_THUMB_PATH", TVLGUID_IMAGES_PATH . "thumbnail/");
define("TVLGUID_IMAGES_LARGE690x300_PATH", TVLGUID_IMAGES_LARGE_PATH . "690x300/");
define("TVLGUID_IMAGES_LARGE449x341_PATH", TVLGUID_IMAGES_LARGE_PATH . "449x341/");
define("TVLGUID_IMAGES_THUMB168x127_PATH", TVLGUID_IMAGES_THUMB_PATH . "168x127/");

define("SITE_DOWNLOAD_PATH", SITE_URL . "download/");
define("SITE_DOWNLOAD_PDF_PATH", SITE_DOWNLOAD_PATH . "pdf/");


define("SITE_INFO_EMAIL", "info@yourdomain.com");
define("SITE_ADMIN_EMAIL", "admin@yourdomain.com");
define("SITE_SUPPORT_EMAIL", "info@yourdomain.com");
define("SITE_ENQUIRY_EMAIL", "info@yourdomain.com");
define("SITE_MYPROPERTY_EMAIL", "info@yourdomain.com");
define("SITE_AGENTS_EMAIL", "info@yourdomain.com");
define("SITE_COMPLAINTS_EMAIL", "info@yourdomain.com");
define("SITE_FEADBACK_EMAIL", "info@yourdomain.com");
define("SITE_JOBS_EMAIL", "info@yourdomain.com");
define("SITE_LINKS_EMAIL", "info@yourdomain.com");
define("SITE_PARTNER_EMAIL", "info@yourdomain.com");
define("SITE_PRESS_EMAIL", "info@yourdomain.com");
define("SITE_TECH_EMAIL", "info@yourdomain.com");
define("SITE_REGISTER_EMAIL", "info@yourdomain.com");

define('MAIL_SERVER', 'webmail.yourdomain.com');
define('MAIL_USERNAME', 'info@yourdomain.com');
define('MAIL_PASSWORD', '');
define('MAIL_METHOD', 'smtp');
define('MAIL_SENDER', 'info@yourdomain.com');
define('MAIL_SERVER_SENDER', $_SERVER['SERVER_NAME']);

//require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/adm/includes/common.php");
//require_once($_SERVER["DOCUMENT_ROOT"]."/adm/includes/common.php");
require_once(SITE_ADMIN_INCLUDES_PATH."database-table.php");
require_once(SITE_CLASSES_PATH."class.DB.php");
require_once(SITE_CLASSES_PATH."class.System.php");
require_once(SITE_CLASSES_PATH."class.Seo.php");
require_once(SITE_ADMIN_INCLUDES_PATH."functions/general.php");
require_once(SITE_ADMIN_INCLUDES_PATH."functions/form.php");
require_once(SITE_ADMIN_INCLUDES_PATH."functions/html.php");
require_once(SITE_DOC_ROOT."recaptchalib.php");
$publickey 	= "6LfFdt0SAAAAAHkXvKXGjy_w20bUXQ7Ju6dvF4gF";
$privatekey = "6LfFdt0SAAAAAKwtpveNsCTL-DUQnsay_ddBxNLi";
# the response from reCAPTCHA
$resp 		= null;
# the error code from reCAPTCHA, if any
$captchaerror = null;

if(isset($_SESSION['lang_code']) && $_SESSION['lang_code'] != '') {
	$lang_code = $_SESSION['lang_code'];
	$lang_name = $_SESSION['lang_name'];
	$lang_file = $lang_code.'.php';
	require_once(SITE_INCLUDES_PATH."lang/".$lang_file);
	define('SITELANG', $lang_code);
} else {
	$lang_code = 'en';
	$lang_name = 'English (US)';
	$lang_file = $lang_code.'.php';
	require_once(SITE_INCLUDES_PATH."lang/".$lang_file);
	define('SITELANG', $lang_code);
}

/*
* Security: Don't delete following line
*/
//if(!is_file("/home/rentownersvillas/public_html/includes/head.php")) { die();}

$dbObj = new DB();
$dbObj->fun_db_connect();

$systemObj 	= new System();
$siteVariableValueArr 	= $systemObj->fun_getSiteVariableValue();
$twitterlink 	= ($siteVariableValueArr[1] != "")?$siteVariableValueArr[1]:"http://www.twitter.com";
$facebooklink 	= ($siteVariableValueArr[2] != "")?$siteVariableValueArr[2]:"http://www.facebook.com";
$youtubelink 	= ($siteVariableValueArr[3] != "")?$siteVariableValueArr[3]:"http://www.youtube.com";
$paypalid 		= ($siteVariableValueArr[5] != "")?$siteVariableValueArr[5]:"silvestersykora@gmail.com";
$gmapapi 		= ($siteVariableValueArr[6] != "")?$siteVariableValueArr[6]:"ABQIAAAAypZhfTxw4x2j67RNkEOYpRRQRJGADDfmp_B2vQF9snU7JigJ_hRmcD5VJQXh3VfcPoAo-EXVNkcDbQ";
$sitetitle 		= ($siteVariableValueArr[7] != "")?$siteVariableValueArr[7]:$_SERVER["SERVER_NAME"];
$sitedescription= ($siteVariableValueArr[9] != "")?$siteVariableValueArr[9]:$_SERVER["SERVER_NAME"];
$sitekeywords 	= ($siteVariableValueArr[10] != "")?$siteVariableValueArr[10]:$_SERVER["SERVER_NAME"];

$seoObj         = new Seo();
$seoArr 		= $seoObj->fun_getSeoInfoByURI($_SERVER['REQUEST_URI']);

//print_r($seoArr);
$seo_title 		= ($seoArr['seo_title'] != "")?$seoArr['seo_title']:$sitetitle;
$seo_description= ($seoArr['seo_description'] != "")?$seoArr['seo_description']:$sitedescription;
$seo_keywords 	= ($seoArr['seo_keywords'] != "")?$seoArr['seo_keywords']:$sitekeywords;

$display_lang 		= $systemObj->fun_getDisplayLang();
$display_lang_arr 	= $systemObj->fun_getDisplayLangArr();
?>
