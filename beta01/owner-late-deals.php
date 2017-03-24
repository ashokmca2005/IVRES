<?php	
	require_once("includes/owner-top.php");
?>
<?php
$detail_array 	= array();
$error_msg		= 'no';
// Owner property special deal submit : start here
if($_POST['securityKey']==md5(OWNERPROPERTYDEALS)){
	if(($_POST['txtPrpertyRef'] == '')){
		$error_msg	= 'yes';
	} else {
		$txtPrpertyRef = $_POST['txtPrpertyRef'];
	}

	if(($_POST['txtDayFrom0'] == '')){
		$error_msg	= 'yes';
	} else {
		$txtDayFrom0 = $_POST['txtDayFrom0'];
	}

	if(($_POST['txtMonthFrom0'] == '')){
		$error_msg	= 'yes';
	} else {
		$txtMonthFrom0 = $_POST['txtMonthFrom0'];
	}

	if(($_POST['txtYearFrom0'] == '')){
		$error_msg	= 'yes';
	} else {
		$txtYearFrom0 = $_POST['txtYearFrom0'];
	}

	if(($_POST['txtDayTo0'] == '')){
		$error_msg	= 'yes';
	} else {
		$txtDayTo0 = $_POST['txtDayTo0'];
	}

	if(($_POST['txtMonthTo0'] == '')){
		$error_msg	= 'yes';
	} else {
		$txtMonthTo0 = $_POST['txtMonthTo0'];
	}

	if(($_POST['txtYearTo0'] == '')){
		$error_msg	= 'yes';
	} else {
		$txtYearTo0 = $_POST['txtYearTo0'];
	}

	if(($_POST['txtCurrencyType'] == '')){
		$error_msg	= 'yes';
	} else {
		$txtCurrencyType = $_POST['txtCurrencyType'];
	}

	if(($_POST['txtOrgWeekPrice0'] == '')){
		$error_msg	= 'yes';
	} else {
		$txtOrgWeekPrice0 = $_POST['txtOrgWeekPrice0'];
	}

	if(($_POST['txtSaleWeekPrice0'] == '')){
		$error_msg	= 'yes';
	} else {
		$txtSaleWeekPrice0 = $_POST['txtSaleWeekPrice0'];
	}

	if(($_POST['txtRemoveDealFrom0'] == '')){
		$error_msg	= 'yes';
	} else {
		$txtRemoveDealFrom0 = $_POST['txtRemoveDealFrom0'];
	}

	if(($_POST['txtMinStay'] == '')){
		$error_msg	= 'yes';
	} else {
		$txtMinStay = $_POST['txtMinStay'];
	}

	if(($_POST['txtMinStayType'] == '')){
		$error_msg	= 'yes';
	} else {
		$txtMinStayType = $_POST['txtMinStayType'];
	}

	if($error_msg == 'no'){
		// Step 1: if T & C is checked, then add it to database and redirect to property deal overview
		if(isset($_POST['txtTermsCondition']) && $_POST['txtTermsCondition'] == "1") {
			$propertyObj->fun_addPropertyDeal($txtPrpertyRef);
			$redirect_url = "owner-late-deals.php?sec=ove&err=adddeal";
			redirectURL($redirect_url);
		} else {
			$strUnixDateFrom 		= mktime(0, 0, 0, (int)$txtMonthFrom0, (int)$txtDayFrom0, (int)$txtYearFrom0);
			$strUnixDateTo	 		= mktime(0, 0, 0, (int)$txtMonthTo0, (int)$txtDayTo0, (int)$txtYearTo0);
			$strUnixDateCur 		= time ();

			$strHrsLeft				= (int)(($strUnixDateFrom - $strUnixDateCur) / (60 * 60));
			$strNights				= (int)(($strUnixDateTo - $strUnixDateFrom) / (60 * 60 * 24));
			$txtCurrencySymbol 		= $propertyObj->fun_findPropertyCurrencySymbol('',$txtCurrencyType);

			$strPricePerNight 		= $txtCurrencySymbol.(number_format($txtSaleWeekPrice0));
			$strOrgPricePerNight 	= $txtCurrencySymbol.(number_format($txtOrgWeekPrice0));
			$strPercentSave 		= round(((($txtOrgWeekPrice0 - $txtSaleWeekPrice0) / $txtOrgWeekPrice0)*100), 0);
			$propertyInfoArr		= $propertyObj->fun_getPropertyInfo($txtPrpertyRef);
			if(count($propertyInfoArr) > 0){
				$strPropertyName 		= ucwords($propertyInfoArr['property_name']);
				$strPropertyTitle	 	= $propertyInfoArr['property_title'];
				$strPropertyDesc	 	= ucfirst(substr($propertyInfoArr['property_summary'], 0, 150));

				$strPropertyTotalBeds	= $propertyInfoArr['total_beds'];
				$strPropertyTotalBaths	= $propertyInfoArr['total_bathrooms'];
			}

			$strThumbArr = $propertyObj->fun_getPropertyMainThumb($txtPrpertyRef);
			if(is_array($strThumbArr)) {
				$strThumbUrl = PROPERTY_IMAGES_THUMB168x126_PATH.$strThumbArr[0]['photo_thumb'];
				$strThumbCap = $strThumbArr[0]['photo_caption'];
			} else {
				$strThumbUrl = PROPERTY_IMAGES_THUMB168x126_PATH."no-image-small.gif";
				$strThumbCap = "No Image";
			}
			$strPropLocArr = $propertyObj->fun_getPropertyLocInfoArr($txtPrpertyRef);
		}
	} else {
		$detail_array['error_msg'] = "Error: We are unable to add your property late deals!";
	}
}
// Owner property special deal submit : end here

// Owner property delete deals submit : start here
if($_POST['securityKey']==md5(OWNERPROPERTYDELDEALS)){
	if(($_POST['txtdelDealId'] == '')){
		$error_msg	= 'yes';
	}
	if($error_msg == 'no'){
		$txtdelDealId = $_POST['txtdelDealId'];
		$propertyObj->fun_delPropertyDeals($txtdelDealId);
	} else {
		$detail_array['error_msg'] = "Error: We are unable to delete your property late deal!";
	}
}

// Owner property delete deals submit : end here 
if(isset($_GET['sec']) && $_GET['sec'] != ''){
	switch($_GET['sec']){
		case 'add';
		case 'edit';
			$mainPage = "ownerlatedeals.php";
		break;			
		case 'pre';
			$mainPage = "ownerlatedealspreview.php";
		break;
		case 'ove';
			if(isset($_GET['err']) && $_GET['err'] == "adddeal") {
				$mainPage = "ownerlatedealsthanks.php";
			} else {
				$mainPage = "ownerlatedealsoverview.php";
			}
		break;
		default:
			$mainPage = "ownerlatedeals.php";
	}
} else {
	$mainPage = "ownerlatedeals.php";
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
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>dhtmlwindow.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>pop-up.js"></script>
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
            else if(whichLayer == 'terms')
            {		
                var x1 = x-270;
                var y1 = y-400;
                output = '<div style="z-index:5;">'+output+'</div>';
                var googlewin=dhtmlwindow.open("Example", "inline", output, "", "width=780px,height=850px,resize=0,scrolling=0,center=1,xAxis="+x1+",yAxis="+y1+"", "recal");
            }
            else if(whichLayer == 'late-deal-cancel-pop')
            {		
                output = '<div style="z-index:5;">'+output+'</div>';
                var googlewin=dhtmlwindow.open("Example", "inline", output, "", "width=298px,height=160px,resize=1,scrolling=0,center=1,xAxis="+x+",yAxis="+y+"", "recal");
            }
            else if(whichLayer == 'late-deal-delete-pop')
            {		
                var x1 = x-100;
                var y1 = y;
                output = '<div style="z-index:5;">'+output+'</div>';
                var googlewin=dhtmlwindow.open("Example", "inline", output, "", "width=298px,height=160px,resize=1,scrolling=0,center=1,xAxis="+x1+",yAxis="+y1+"", "recal");
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
<!-- Main Wrapper Starts Here -->
<div id="wrapper">
    <!-- Header Include Starts Here -->
    <div id="header" align="center">
        <?php require_once(SITE_INCLUDES_PATH.'header.php'); ?>
    </div>
    <!-- Header Include End Here -->
	<?php require_once(SITE_INCLUDES_PATH.'holidayadvsearch.php'); ?>
	<?php //require_once(SITE_INCLUDES_PATH.'breadcrumb.php'); ?>
    <div id="pg-wrapper" align="center"><h1 class="page-heading">Late Deals</h1></div>
    <div id="main">
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="left" valign="top" width="230">
					<?php require_once(SITE_INCLUDES_PATH.'owner-left-links.php'); ?>
                </td>
                <td width="30" align="left" valign="top" style="border-right:thin #efefef solid;">&nbsp;</td>
                <td align="left" valign="top" class="font12" style="padding-left:10px;">
					<?php
                    if(isset($mainPage)){
                        include_once("includes/".$mainPage);
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
