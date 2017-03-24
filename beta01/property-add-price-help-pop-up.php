<?php	
	if($_SERVER["SERVER_NAME"] == "localhost") {
		require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
	} else {
		require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
	}
	require_once(SITE_CLASSES_PATH."class.Users.php");
	require_once(SITE_CLASSES_PATH."class.Property.php");
	require_once(SITE_CLASSES_PATH."class.Event.php");
	require_once(SITE_CLASSES_PATH."class.CMS.php");
	require_once(SITE_CLASSES_PATH."class.Banner.php");

	$usersObj 		= new Users();
	$propertyObj 	= new Property();
	$eventObj 		= new Event();
	$cmsObj         = new Cms();
	$bannerObj      = new Banner();
	$examplepricesnote 	= $cmsObj->fun_getPageInfoById(49);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo tranText('charset'); ?>" />
    <META HTTP-EQUIV="Content-language" CONTENT="<?php echo tranText('lang_iso'); ?>">
    <link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo SITE_URL; ?>favicon.ico" />
    <link rel="SHORTCUT ICON" href="<?php echo SITE_URL; ?>favicon.ico"/>
    <title><?php echo $sitetitle;?> :: Owner :: Add / Edit Property Prices</title>
    <link href="css/owner.css" rel="stylesheet" type="text/css" />
</head>
<body style="color:#585858;">
	<?php echo stripslashes($examplepricesnote['page_discription']);?>
</body>
</html>