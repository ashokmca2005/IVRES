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
if(isset($_GET['enquiryid']) && $_GET['enquiryid'] !="") $enquiry_id = $_GET['enquiryid'];
if(isset($_GET['booking_id']) && $_GET['booking_id'] !="") $booking_id = $_GET['booking_id'];

if(isset($_GET['sec']) && $_GET['sec'] !=""){
	switch($_GET['sec']){
		case 'prop':
			$mainPage = "admin-collateral-properties.php";
			$addtitle = "Properties";
		break;
		case 'resuser':
			$mainPage = "admin-collateral-users.php";
			$addtitle = "Users";
		break;
		case 'review':
			$mainPage = "admin-collateral-reviews.php";
			$addtitle = "Reviews";
		break;
		case 'event':
			$mainPage = "admin-collateral-event.php";
			$addtitle = "Event";
		break;
		case 'trvlguide':
			$mainPage = "admin-collateral-travel-guide.php";
			$addtitle = "Travel Guide";
		break;
		case 'ownrlink':
			$mainPage = "admin-collateral-owner-link.php";
			$addtitle = "Owner Link";
		break;
		case 'noticereq':
			$mainPage = "admin-collateral-notice-request.php";
			$addtitle = "Notice Request";
		break;
		case 'enquiries':
			$mainPage = "admin-collateral-user-enquiries.php";
			$addtitle = "Enquiry";
		break;
		case 'booking':
			$mainPage = "admin-collateral-user-booking.php";
			$addtitle = "Bookings";
		break;
		case 'services':
			$mainPage = "admin-collateral-services.php";
			$addtitle = "Services";
		break;
		case 'resource':
			$mainPage = "admin-collateral-resources.php";
			$addtitle = "Resources";
		break;
		case 'quote':
			$mainPage = "admin-collateral-quote.php";
			$addtitle = "Quotes & Testimonials";
		break;
		case 'ownrguide':
			$mainPage = "admin-collateral-owner-guides.php";
			$addtitle = "Owner Guides";
		break;
		case 'hotprop':
			$mainPage = "admin-collateral-hot-properties.php";
			$addtitle = "Feature Properties";
		break;
		case 'backlink':
			$mainPage = "admin-collateral-backlinks.php";
			$addtitle = "Activation Backlinks";
		break;

		default:
			$mainPage = "admin-collateral-properties.php";
			$addtitle = "Properties";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title><?php echo $sitetitle;?> :: Admin :: Collateral <?php if(isset($addtitle) && $addtitle !="") echo ":: ".$addtitle;?></title>
    <link href="includes/css/tab.css" rel="stylesheet" type="text/css" />
    <link href="includes/css/admin.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" language="javascript" src="includes/js/admin.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>dhtmlwindow.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>pop-up.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>tab_menu.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>dargPop.js"></script>
	<script language="javascript" type="text/javascript">
	var x, y;
	function show_coords(event){	
		x=event.clientX;
		y=event.clientY;
		x = x-160;
		y = y+4;
	//	alert(x);alert(y);
	}
	function toggleLayer(whichLayer){
		var output = document.getElementById(whichLayer).innerHTML;
		if(whichLayer == 'ANP-Example')
		{		
			output = '<div style="z-index:5;">'+output+'</div>';
			var googlewin=dhtmlwindow.open("Example", "inline", output, "", "width=295px,height=470px,resize=0,scrolling=0,center=1,xAxis="+x+",yAxis="+y+"", "recal");
		}
		googlewin.onclose=function(){ //Run custom code when window is being closed (return false to cancel action):
			return true
		}
	}
	
	function closeWindow(){	
		document.getElementById("Example").style.display="none";
	}
	
	function closeWindowNRefresh(){
		document.getElementById("Example").style.display="none";
		window.location = location.href;
	}
	</script>
</head>
<body onmousedown="show_coords(event);">
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
            <td valign="top" class="width210">
			<?php require_once(SITE_ADMIN_INCLUDES_PATH.'admin-left-links.php'); ?></td>
            <td valign="top" class="width26">&nbsp;</td>
            <td valign="top" class="width690">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                    <tr>
                        <td valign="top" class="SectionHead">Collateral</td>
                        <td valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                        <td valign="top" class="SectionSubHead"><?php echo $addtitle;?></td>
                        <td valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                        <td valign="top" colspan="2">
						<?php require_once(SITE_ADMIN_INCLUDES_PATH.$mainPage); ?>
                        </td>
                    </tr>
                </table>
            </td><td class="width22">&nbsp;</td>
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
