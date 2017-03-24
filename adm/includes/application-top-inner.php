<?php
session_start();
/*
error_reporting(E_ALL-E_NOTICE);
ini_set('allow_call_time_pass_reference', true);
ini_set("display_errors", "On");
ini_set("max_execution_time", "0");
*/
set_time_limit(0);

require_once("includes/common.php");
require_once("includes/database-table.php");
require_once("includes/classes/class.DB.php");
require_once("includes/classes/class.System.php");
require_once("includes/classes/class.Pagination.php");
require_once("includes/classes/class.Admins.php");
require_once("includes/classes/class.Property.php");
require_once("includes/classes/class.Location.php");
require_once("includes/classes/class.Event.php");
require_once("includes/classes/class.Travel.php");
require_once("includes/classes/class.Resource.php");
require_once("includes/classes/class.Testimonial.php");
require_once("includes/classes/class.Promo.php");
require_once("includes/classes/class.Cart.php");
require_once("includes/classes/class.Currency.php");
require_once("includes/classes/class.Calender.php");
require_once("includes/classes/class.Product.php");
require_once("includes/classes/class.Users.php");
require_once("includes/classes/class.UserSetting.php");
require_once("includes/classes/class.Image.php");
require_once("includes/classes/class.CMS.php");
require_once("includes/classes/class.Banner.php");
require_once("includes/classes/class.Seo.php");
require_once("includes/functions/general.php");
require_once("includes/functions/form.php");
require_once("includes/functions/html.php");

$dbObj = new DB();
$dbObj->fun_db_connect();

$systemObj 		= new System();
$adminsObj 		= new Admins();
$propertyObj 	= new Property();
$locationObj 	= new Location();
$eventObj 		= new Event();
$tvlguidObj		= new Travel();
$resObj			= new Resource();
$testiObj 		= new Testimonial();
$promoObj 		= new Promo();
$cartObj 		= new Cart();
$currencyObj	= new Currency();
$calendarObj 	= new Calendar();
$productObj		= new Product();
$usersObj 		= new Users();
$userSetting	= new UserSetting();
$imgObj 		= new Image();
$cmsObj         = new Cms();
$bannerObj      = new Banner();
$seoObj         = new Seo();

$adminsObj->CheckAdminLogin();

$siteVariableValueArr 	= $systemObj->fun_getSiteVariableValue();
$twitterlink 	= ($siteVariableValueArr[1] != "")?$siteVariableValueArr[1]:"http://www.twitter.com";
$facebooklink 	= ($siteVariableValueArr[2] != "")?$siteVariableValueArr[2]:"http://www.facebook.com";
$youtubelink 	= ($siteVariableValueArr[3] != "")?$siteVariableValueArr[3]:"http://www.youtube.com";
$paypalid 		= ($siteVariableValueArr[5] != "")?$siteVariableValueArr[5]:"test1@idns-technologies.info";
$gmapapi 		= ($siteVariableValueArr[6] != "")?$siteVariableValueArr[6]:"ABQIAAAAypZhfTxw4x2j67RNkEOYpRSzWlgZvj84bAaEuCUfVbsv7RhUORTNdoKq-btjYqgpJSEGouP5ezwxVQ";
$sitetitle 		= ($siteVariableValueArr[7] != "")?$siteVariableValueArr[7]:$_SERVER["SERVER_NAME"];
?>