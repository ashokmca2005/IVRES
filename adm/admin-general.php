<?php
require_once("includes/application-top-inner.php");
if(isset($_GET['pid']) && $_GET['pid'] !=""){
	$property_id = $_GET['pid'];
}
if(isset($_GET['usrid']) && $_GET['usrid'] !=""){
	$user_id = $_GET['usrid'];
}


if(isset($_GET['sec']) && $_GET['sec'] !=""){
	switch($_GET['sec']){
		case 'usr':
			$mainPage = "admin-general-users.php";
			$addtitle = "Automated emails";
		break;
		case 'sms':
			$mainPage = "admin-general-sms.php";
			$addtitle = "SMS";
		break;
		case 'pay':
			$mainPage = "admin-general-payments.php";
			$addtitle = "Payments";
		break;
		default:
			$mainPage = "admin-general-users.php";
			$addtitle = "Users and access - create / edit";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title><?php echo $sitetitle;?> :: Admin :: General <?php if(isset($addtitle) && $addtitle !="") echo ":: ".$addtitle;?></title>
    <link href="includes/css/admin.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" language="JavaScript" src="includes/js/sarissa/sarissa.js"></script>
    <script type="text/javascript" language="JavaScript" src="includes/js/sarissa/sarissa_ieemu_xpath.js"></script>
    <script type="text/javascript" language="JavaScript" src="includes/js/sarissa/sarissa_ieemu_xpath-compressed.js"></script>
    <script type="text/javascript" language="JavaScript" src="includes/js/sarissa/sarissa-compressed.js"></script>
	<script language="javascript" src="includes/js/dhtmlwindow.js" type="text/javascript"></script>
	<script type="text/javascript" language="javascript" src="includes/js/admin.js"></script>
    <script type="text/javascript" language="javascript" src="includes/js/dargPop.js"></script>
</head>
<body onmousedown="show_coords(event);">
<!-- UniqueSleeps Main Wrapper Starts Here -->
<div id="MainWrapper">
    <!-- Header Include Starts Here -->
    <div>
        <?php require_once('includes/admin-header.php'); ?>
    </div>
    <!-- Header Include Ends Here -->
    <div id="div">
    <table width="974" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td class="width18">&nbsp;</td>
            <td valign="top" class="width210"><?php require_once('includes/admin-left-links.php'); ?></td>
            <td valign="top" class="width26">&nbsp;</td>
            <td valign="top" class="width690">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                    <tr>
                        <td valign="top" class="SectionHead">General</td>
                        <td valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                        <td valign="top" colspan="2">
						<?php require_once("includes/".$mainPage); ?>
                        </td>
                    </tr>
                </table>
            </td><td class="width22">&nbsp;</td>
        </tr>
    </table>
    </div>
    <!-- Footer Include Starts Here -->
    <div>
        <?php require_once('includes/admin-footer.php'); ?>
    </div>
    <!-- Footer Include Ends Here -->
</div>
<!-- UniqueSleeps Main Wrapper Ends Here -->
</body>
</html>
