<?php	
	require_once("includes/owner-top.php");
	if(isset($_GET['pid']) && $_GET['pid'] !="") {
		$property_id = $_GET['pid'];
		//Add property fee to cart
		$products_id = 6;
		if($propertyObj->fun_checkPropertyUserBasket($user_id, $products_id, $property_id) == false) {
			$products_price 	= $productObj->fun_getProductPrice($products_id);
			$products_quantity  = 1;
			$propertyObj->fun_addPropertyUserBasket($user_id, $products_id, $property_id, $products_quantity, $products_price);
		}
	} else {
		redirectURL("owner-home.php");
	}

	$usersObj->sendAddPropertyConfirmationEmailToOwner($user_id, $property_id);
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
    <div id="pg-wrapper" align="center"><h1 class="page-heading">Confirmation</h1></div>
    <div id="main">
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="left" valign="top">
					<?php require_once(SITE_INCLUDES_PATH.'owner-left-links.php'); ?>
                </td>
                <td width="30" align="left" valign="top" style="border-right:thin #efefef solid;">&nbsp;</td>
                <td align="left" valign="top" class="font12" style="padding-left:10px;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                        <tr>
                            <td align="left" valign="top" class="pad-btm25 pad-top15">
                                <p>Thanks for adding your property: <strong><?php echo ucfirst($propertyObj->fun_getPropertyName($property_id)); ?></strong> / <strong><?php echo fill_zero_left($property_id, "0", (6-strlen($property_id))); ?></strong> to the site.</p>
                                <p>&nbsp;</p>
                                <p>Our Admin team are now busy checking the details before putting it live on the site. Once we've done this we'll send you an email confirming that it has been approved or in the event it is declined we will email you with our reasons why. This process normally takes no longer than 24 hours.</p>
                                <p>&nbsp;</p>
                                <p>If you do not receive confirmation then please <a href="owner-contact-us.php?sbj=10&pid=<?php echo $property_id; ?>" class="blue-link">contact us</a> quoting reference: <b><?php echo fill_zero_left($property_id, "0", (6-strlen($property_id))); ?></b></p>
                                <p>&nbsp;</p>
                                <p>If you haven't already done so then please remember to <a href="owner-shopping-cart.php" class="blue-link">pay for your property listing</a>. We will not be able to put your property listing live until payment has been received.</p>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" valign="top" class="gray18Arial pad-btm25">
                                <p class="FloatLft"><a href="owner-home.php"><img src="<?php echo SITE_IMAGES;?>myHome-btn1.png" alt="Homepage" border="0" height="27" width="107" /></a></p>
                                <div class="FloatLft pad-lft10"><a href="property.php"><img src="<?php echo SITE_IMAGES;?>addproperty-gray.gif" alt="Add New Property" height="27" width="129"></a></div>
                            </td>
                        </tr>
                        <tr><td height="35" align="left" valign="top">&nbsp;</td></tr>
                    </table>                
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
