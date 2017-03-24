<?php	
	require_once("includes/owner-top.php");
?>
<?php	
$page	 = form_int("page",1)+0;
$sortby  = form_int("sortby",0,0,4);
$sortdir = form_int("sortdir",0,0,1);
if (form_isset("reverse")) {
	$sortdir = 1-$sortdir;
}

switch($sortdir) {
	case 0 : $orderDir = "ASC"; break;
	case 1 : $orderDir = "DESC"; break;
}

if(isset($_GET['catid']) && $_GET['catid'] != "") {
	$trvl_guid_categories_id 	= $_GET['catid'];
	$tvlCatInfoArr 				= $tvlguidObj->fun_getTravelGuideCatInfo($trvl_guid_categories_id);
	if(!is_array($tvlCatInfoArr)) {
		redirectURL("owner-travelguides");
	} else {
		$tvlInfoByCatArr = $tvlguidObj->fun_getTravelGuidListByCatArr($trvl_guid_categories_id);
	}
} else if(isset($_GET['tvlguidid']) && $_GET['tvlguidid'] != "") {
	$trvl_guid_id 		= $_GET['tvlguidid'];
	$tvlGuidDetailsArr 	= $tvlguidObj->fun_getTravelInfo($trvl_guid_id);
	if(!is_array($tvlGuidDetailsArr) || count($tvlGuidDetailsArr) < 1) {
		redirectURL("owner-travelguides");
	} else {
	}
} else {
	// cape town category
	$trvl_guid_categories_id = 7;
	$tvlCatInfoArr 				= $tvlguidObj->fun_getTravelGuideCatInfo($trvl_guid_categories_id);
	if(!is_array($tvlCatInfoArr)) {
		redirectURL("owner-travelguides");
	} else {
		$tvlInfoByCatArr = $tvlguidObj->fun_getTravelGuidListByCatArr($trvl_guid_categories_id);
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
    <link href="<?php echo SITE_CSS_INCLUDES_PATH;?>owner.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>common.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>owner.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>pop-up.js"></script>
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
    <div id="pg-wrapper" align="center"><h1 class="page-heading"><?php echo $tvlguidInfoArr['trvl_guid_title']; ?></h1></div>
    <div id="main">
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="left" valign="top" width="230">
					<?php require_once(SITE_INCLUDES_PATH.'owner-left-links.php'); ?>
					<?php require_once(SITE_INCLUDES_PATH.'owner-travelguides-left-links.php'); ?>
                </td>
                <td width="30" align="left" valign="top" style="border-right:thin #efefef solid;">&nbsp;</td>
                <td align="left" valign="top" class="font12" style="padding-left:10px;">
					<?php require_once(SITE_INCLUDES_PATH.'ownertravelguides.php'); ?>
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
