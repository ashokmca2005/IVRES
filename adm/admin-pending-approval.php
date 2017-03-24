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
		case 'newprop':
			$mainPage = "admin-new-property-approval.php";
			$addtitle = "New Properties";
		break;
		case 'updtprop':
			$mainPage = "admin-updated-property-approval.php";
			$addtitle = "Updated Properties";
		break;
		case 'suspendprop':
			$mainPage = "admin-suspended-property-approval.php";
			$addtitle = "Suspended Properties";
		break;
		case 'hotprop':
			$mainPage = "admin-hot-property-approval.php";
			$addtitle = "Featured Properties";
		break;
		case 'dealprop':
			$mainPage = "admin-late-deal-approval.php";
			$addtitle = "Late Deals";
		break;
		case 'newusers':
			$mainPage = "admin-new-user-approval.php";
			$addtitle = "New Users";
		break;
		case 'event':
			$mainPage = "admin-events-approval.php";
			$addtitle = "Events";
		break;
		case 'review':
			$mainPage = "admin-reviews-approval.php";
			$addtitle = "Reviews";
		break;
		case 'testi':
			$mainPage = "admin-testimonials-approval.php";
			$addtitle = "Testimonials";
		break;
		default:
			$mainPage = "admin-new-property-approval.php";
	}
} else {
	$mainPage = "admin-new-property-approval.php";
}

// for unset (null) of property page
if((strpos($_SERVER['HTTP_REFERER'], "holiday-property-preview.php") == true) || (isset($_SESSION['property_preview_close_url']) && $_SESSION['property_preview_close_url'] != "")) {
	$_SESSION['property_preview_close_url'] = "";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title><?php echo $sitetitle;?> :: Admin :: Pending Approvals <?php if(isset($addtitle) && $addtitle !="") echo ":: ".$addtitle;?></title>
    <link href="includes/css/admin.css" rel="stylesheet" type="text/css" />
	<link href="../css/pop-up-cal.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" language="javascript" src="includes/js/admin.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>dhtmlwindow.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>pop-up.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>dargPop.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>tab_menu.js"></script>
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
            <td valign="top" class="width210"><?php require_once(SITE_ADMIN_INCLUDES_PATH.'admin-left-links.php'); ?></td>
            <td valign="top" class="width26">&nbsp;</td>
            <td valign="top" class="width690">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                    <tr>
                        <td valign="top" class="SectionHead">Pending approval</td>
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
