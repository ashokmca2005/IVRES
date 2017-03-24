<?php
require_once("includes/application-top-inner.php");
if(isset($_GET['usrid']) && $_GET['usrid'] !="") $user_id = $_GET['usrid'];
if(isset($_GET['pid']) && $_GET['pid'] !="") $property_id = $_GET['pid'];
if(isset($_GET['hotpid']) && $_GET['hotpid'] !="") $property_hot_id = $_GET['hotpid'];
if(isset($_GET['latedealid']) && $_GET['latedealid'] !="") $property_latedeal_id = $_GET['latedealid'];
if(isset($_GET['evntid']) && $_GET['evntid'] !="") $event_id = $_GET['evntid'];
if(isset($_GET['rsid']) && $_GET['rsid'] !="") $resource_id = $_GET['rsid'];
if(isset($_GET['reviewid']) && $_GET['reviewid'] !="") $review_id = $_GET['reviewid'];
if(isset($_GET['testid']) && $_GET['testid'] !="") $testimonial_id = $_GET['testid'];

if(isset($_GET['sec']) && $_GET['sec'] !=""){
	switch($_GET['sec']){
		case 'over':
			$mainPage = "admin-statistics-overviews.php";
			$addtitle = "Overview";
		break;
		case 'prop':
			$mainPage = "admin-statistics-properties.php";
			$addtitle = "Property stats";
		break;
		case 'user':
			$mainPage = "admin-statistics-users.php";
			$addtitle = "User stats";
		break;
		case 'fina':
			$mainPage = "admin-statistics-financials.php";
			$addtitle = "Financial stats";
		break;
		case 'even':
			$mainPage = "admin-statistics-events.php";
			$addtitle = "Event stats";
		break;
		case 'guid':
			$mainPage = "admin-statistics-travel-guides.php";
			$addtitle = "Travel guide stats";
		break;
		case 'reso':
			$mainPage = "admin-statistics-resource-stats.php";
			$addtitle = "Resource stats";
		break;
		case 'paym':
			$mainPage = "admin-statistics-payments.php";
			$addtitle = "Payments";
		break;
		default:
			$mainPage = "admin-statistics-overviews.php";
			$addtitle = "Overview";
	}
} else {
	$mainPage = "admin-statistics-overviews.php";
	$addtitle = "Overview";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title><?php echo $sitetitle;?> :: Admin :: Statistics <?php if(isset($addtitle) && $addtitle !="") echo ":: ".$addtitle;?></title>
    <link href="includes/css/admin.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" language="JavaScript" src="includes/js/sarissa/sarissa.js"></script>
    <script type="text/javascript" language="JavaScript" src="includes/js/sarissa/sarissa_ieemu_xpath.js"></script>
    <script type="text/javascript" language="JavaScript" src="includes/js/sarissa/sarissa_ieemu_xpath-compressed.js"></script>
    <script type="text/javascript" language="JavaScript" src="includes/js/sarissa/sarissa-compressed.js"></script>
	<script language="javascript" src="includes/js/dhtmlwindow.js" type="text/javascript"></script>
	<script type="text/javascript" language="javascript" src="includes/js/UniqueSleepsadmin.js"></script>
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
                        <td valign="top" class="SectionHead">Statistics</td>
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
