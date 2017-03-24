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
if(isset($_GET['banner_id']) && $_GET['banner_id'] !="") $banner_id = $_GET['banner_id'];

if(isset($_GET['sec']) && $_GET['sec'] !=""){
	switch($_GET['sec']){
		case 'manloca':
			$mainPage = "admin-site-variable-manage-locations.php";
			$addtitle = "Manage locations";
		break;
		case 'lang':
			$mainPage = "admin-site-variable-languages.php";
			$addtitle = "Manage Languages";
		break;
		case 'loca':
			$mainPage = "admin-site-variable-locations.php";
			$addtitle = "Locations SEO";
		break;
		case 'home':
			$mainPage = "admin-site-variable-home.php";
			$addtitle = "Manage home";
		break;
		case 'foot':
			$mainPage = "admin-site-variable-footers.php";
			$addtitle = "Manage Footers";
		break;
		case 'prom':
			$mainPage = "admin-site-variable-promos.php";
			$addtitle = "Promo panels";
		break;
		case 'banner':
			$mainPage = "admin-site-variable-banner.php";
			$addtitle = "Banners";
		break;
		case 'banneradd':
			$mainPage = "admin-site-variable-banners-add.php";
			$addtitle = "Banners";
		break;
		/*
		case 'tags':
			$mainPage = "admin-site-variable-tags.php";
			$addtitle = "Manage tags";
		break;
		*/
		case 'desc':
			$mainPage = "admin-site-variable-page-descriptions.php";
			$addtitle = "Page descriptions";
		break;
		case 'curr':
			$mainPage = "admin-site-variable-currencies.php";
			$addtitle = "Currencies";
		break;
		/*
		case 'rate':
			$mainPage = "admin-site-variable-rates.php";
			$addtitle = "Site rates and charges";
		break;
		*/
		case 'package':
			$mainPage = "admin-site-variable-packages.php";
			$addtitle = "Site rates and charges";
		break;
		case 'disc':
			$mainPage = "admin-site-variable-discounts.php";
			$addtitle = "Discounts & Promotions";
		break;
		case 'resource':
			$mainPage = "admin-resources-approval.php";
			$addtitle = "Resources";
		break;
		case 'vari':
			$mainPage = "admin-site-variable-variables.php";
			$addtitle = "Variables";
		break;
		case 'seo':
			$mainPage = "admin-site-variable-seo.php";
			$addtitle = "Seo";
		break;
		case 'import':
			$mainPage = "admin-site-variable-import.php";
			$addtitle = "Import Property XML Feed";
		break;
		/*case 'sysv':
			$mainPage = "admin-site-variable-system-variables.php";
			$addtitle = "System variables";
		break;*/
		default:
			$mainPage = "admin-site-variable-locations.php";
			$addtitle = "Locations";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title><?php echo $sitetitle;?> :: Admin :: Collateral <?php if(isset($addtitle) && $addtitle !="") echo ":: ".$addtitle;?></title>
    <link href="includes/css/admin.css" rel="stylesheet" type="text/css" />
	<link href="../css/pop-up-cal.css" rel="stylesheet" type="text/css" />
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
                        <td valign="top" class="SectionHead">Site Variables</td>
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
