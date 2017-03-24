<?php	
	if($_SERVER["SERVER_NAME"] == "localhost") {
		require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
	} else {
		require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
	}
	require_once(SITE_CLASSES_PATH."class.Users.php");
	require_once(SITE_CLASSES_PATH."class.Property.php");
	require_once(SITE_CLASSES_PATH."class.Event.php");

	$usersObj 		= new Users();
	$propertyObj 	= new Property();
	$eventObj 		= new Event();
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
    <div id="pg-wrapper" align="center"><h1 class="page-heading">Enquiry</h1></div>
    <div id="main">
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="left" valign="top">
					<?php require_once(SITE_INCLUDES_PATH.'holidayhotproperty-left.php'); ?>
                </td>
                <td width="30" align="left" valign="top" style="border-right:thin #efefef solid;">&nbsp;</td>
                <td align="left" valign="top" class="font12" style="padding-left:10px;">
					<?php
                    if(isset($_GET['enquiry']) && $_GET['enquiry'] != "") {
                        if(isset($_GET['err']) && $_GET['err'] == "thanks") {
                        ?>
                            <table border="0" cellspacing="0" cellpadding="0" width="100%" class="font12">
                                <tr><td valign="top" class="pad-top10 pad-rgt10"><span><img src="<?php echo SITE_IMAGES;?>green-arrow-new.png" width="30" />&nbsp;&nbsp;</span><span class="latedealPink-20">Thanks ...</span><span class="latedealGray"><span style="font-weight:normal; font-size:20px;"> you're enquiry has been sent, and a copy is also sent to you.</span></span></td></tr>
                                <tr>
                                    <td valign="top" class="pad-top10 pad-rgt10" style="padding-left:30px;">
                                        <div>
                                            You're unique enquiry ID is: <?php echo fill_zero_left($_GET['enquiry'], "0", (9-strlen($_GET['enquiry']))); ?>
                                            <br />
                                            <br />Please make a note of this for future reference and always quote it in correspondance regarding this enquiry.
                                            <br /><br />
                                             Our owners are pretty good at responding to enquiries so please keep an eye on your inbox.
                                            <br /><br />
                                            Regards, the <?php echo $sitetitle; ?> team
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" valign="top" class="pad-top10" style="padding-left:30px;">
                                        <a href="<?php if(isset($_SESSION['ses_user_home']) && $_SESSION['ses_user_home'] !=""){echo $_SESSION['ses_user_home'];} else {echo SITE_URL;}?>" style="text-decoration:none;" class="button-grey">Return to homepage</a>
                                    </td>
                                </tr>
                            </table>                    
                        <?php
                        } else {
                        ?>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                            <tr><td align="left" valign="top"><span class="latedealPink-20">Oh ...</span><span class="latedealGray"><span style="font-weight:normal; font-size:20px;"> you're enquiry has not been sent! try again!</span></span></td></tr>
                        </table>
                        <?php
                        }
                    } else {
					?>
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
						<tr><td align="left" valign="top"><span class="latedealPink-20">Oh ...</span><span class="latedealGray"><span style="font-weight:normal; font-size:20px;"> you're enquiry has not been sent! try again!</span></span></td></tr>
					</table>
					<?php
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
