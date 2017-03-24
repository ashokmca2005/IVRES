<?php	
	require_once("includes/owner-top.php");
	//form submission
	$form_array = array();
	$errorMsg 	= "no";

// Owner property hot property submit : start here
if($_POST['securityKey']==md5(OWNERHOTPROPERTY)){
	if(($_POST['txtPrpertyRef'] == '')){
		$errorMsg	= 'yes';
	} else {
		$txtPrpertyRef = $_POST['txtPrpertyRef'];
	}

	if(($_POST['txtDayFrom0'] == '')){
		$errorMsg	= 'yes';
	} else {
		$txtDayFrom0 = $_POST['txtDayFrom0'];
	}

	if(($_POST['txtMonthFrom0'] == '')){
		$errorMsg	= 'yes';
	} else {
		$txtMonthFrom0 = $_POST['txtMonthFrom0'];
	}

	if(($_POST['txtYearFrom0'] == '')){
		$errorMsg	= 'yes';
	} else {
		$txtYearFrom0 = $_POST['txtYearFrom0'];
	}

	if(($_POST['txtWeeks'] == '')){
		$errorMsg	= 'yes';
	} else {
		$txtWeeks = $_POST['txtWeeks'];
	}

	if($errorMsg == 'no') {
		if(isset($_POST['txtTermsCondition']) && $_POST['txtTermsCondition'] == "1" && $_POST['txtConfirm'] == "1") {
			$txtStartDate 		= $txtYearFrom0."-".$txtMonthFrom0."-".$txtDayFrom0;
			if(isset($_POST['txtPropHotId']) && $_POST['txtPropHotId'] != "") {
				$txtPropHotId 	= $_POST['txtPropHotId'];
				$txtStatus 		= $_POST['txtStatus'];
				$propertyObj->fun_editHotProperty($txtPropHotId, $txtPrpertyRef, $txtStartDate, $txtWeeks, $txtStatus);
				$redirect_url = SITE_URL."owner-featured-properties";
			} else {
				$propertyObj->fun_addHotProperty($txtPrpertyRef, $txtStartDate, $txtWeeks);
				$products_id 		= 3;
				$products_price 	= $productObj->fun_getProductPrice($products_id);

				if($propertyObj->fun_checkPropertyProductPayments($products_id, $txtPrpertyRef) == false) {
					if($propertyObj->fun_checkPropertyUserBasket($user_id, $products_id, $txtPrpertyRef) == false) {
						$propertyObj->fun_addPropertyUserBasket($user_id, $products_id, $txtPrpertyRef, $txtWeeks, $products_price);
					}
				}
//				$redirect_url = SITE_URL."owner-hot-property.php?sec=thk";
				$redirect_url = SITE_URL."owner-shopping-cart";
			}
			redirectURL($redirect_url);
		} else {

		}
	}
}
// Owner property hot property submit : end here

if(isset($_GET['sec']) && $_GET['sec'] != ''){
	switch($_GET['sec']){
		case 'add';
		case 'edit';
			$mainPage = "ownerhotproperty.php";
		break;			
		case 'pre';
			$mainPage = "ownerhotpropertypreview.php";
		break;
		case 'thk';
			$mainPage = "ownerhotpropertythanks.php";
		break;
		default:
			$mainPage = "ownerhotproperty.php";
	}
} else {
	$mainPage = "ownerhotproperty.php";
}

if(isset($_GET['prophotid']) && ($_GET['prophotid'] != "") && empty($_POST)) {
	$property_hot_id 	= $_GET['prophotid'];
	$hotpropertyInfoArr = $propertyObj->fun_getHotPropertyInfo($property_hot_id);
	if(count($hotpropertyInfoArr) > 0) { 
		$txtPropHotId			= $hotpropertyInfoArr['property_hot_id'];
		$txtPrpertyRef			= $hotpropertyInfoArr['property_id'];
		$strDateFrom 			= $hotpropertyInfoArr['start_date'];
		$txtWeeks 				= $hotpropertyInfoArr['total_weeks'];
		$txtStatus 				= $hotpropertyInfoArr['status'];

		$txtDayFrom0 	= date('d', strtotime($strDateFrom));
		$txtMonthFrom0 	= date('m', strtotime($strDateFrom));
		$txtYearFrom0 	= date('Y', strtotime($strDateFrom));
	}
} else if(isset($_GET['pid']) && ($_GET['pid'] != "") && empty($_POST)) {
	$txtPrpertyRef	= $_GET['pid'];
}	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $sitetitle;?> :: Owner :: Add featured property</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo tranText('charset'); ?>" />
<META HTTP-EQUIV="Content-language" CONTENT="<?php echo tranText('lang_iso'); ?>">
    <link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo SITE_URL; ?>favicon.ico" />
    <link rel="SHORTCUT ICON" href="<?php echo SITE_URL; ?>favicon.ico"/>
<link href="<?php echo SITE_CSS_INCLUDES_PATH;?>owner.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>common.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>owner.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>dhtmlwindow.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>pop-up.js"></script>
<script language="javascript" type="text/javascript">
    var x, y;
    function show_coords(event){	
        x=event.clientX;
        y=event.clientY;
        x = x-160;
        y = y+4;
    //	alert(x);alert(y);
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
    <div id="pg-wrapper" align="center"><h1 class="page-heading"><?php echo tranText('my_featured_properties'); ?></h1></div>
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
