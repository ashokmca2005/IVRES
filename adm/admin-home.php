<?php
require_once("includes/application-top-inner.php");
// for unset (null) of property page
if((strpos($_SERVER['HTTP_REFERER'], "holiday-property-preview.php") == true) || (isset($_SESSION['property_preview_close_url']) && $_SESSION['property_preview_close_url'] != "")) {
	$_SESSION['property_preview_close_url'] = "";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title><?php echo $sitetitle;?> :: Admin :: Home</title>
    <link href="includes/css/admin.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" language="javascript" src="includes/js/admin.js"></script>
</head>
<body>
<!-- UniqueSleeps Main Wrapper Starts Here -->
<div id="MainWrapper">
    <!-- Header Include Starts Here -->
    <div>
        <?php require_once(SITE_ADMIN_INCLUDES_PATH.'admin-header.php'); ?>
    </div>
    <!-- Header Include Ends Here -->
    <div id="div">
    <table width="974" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td class="width18">&nbsp;</td>
            <td valign="top" class="width210"><?php require_once(SITE_ADMIN_INCLUDES_PATH.'admin-left-links.php'); ?></td>
            <td valign="top" class="width26">&nbsp;</td>
            <!-- Main body should be added here : Start Here -->
            <td valign="top">&nbsp;</td>
            <!-- Main body should be added here : End Here -->
            <td class="width22">&nbsp;</td>
        </tr>
    </table>
    </div>
    <!-- Footer Include Starts Here -->
    <div>
        <?php require_once(SITE_ADMIN_INCLUDES_PATH.'admin-footer.php'); ?>
    </div>
    <!-- Footer Include Ends Here -->
</div>
<!-- UniqueSleeps Main Wrapper Ends Here -->
</body>
</html>
