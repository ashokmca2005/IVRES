<?php	
	require_once("includes/owner-top.php");
?>
<?php	
	if($_POST['securityKey']==md5("USERPAYMENT")) {
		//Posted variables
		$txtOrderId 		= $_POST['txtOrderId'];
		$txtTransStatus 	= $_POST['txtTransStatus'];
		if($txtTransStatus == "C") { // payment fail
			//Payment cancel
			$date_added 		= time ();
			$customer_notified 	= 1;
			$comments 			= "Cancel payment";
			$cartObj->fun_addOrderStatusHistory($txtOrderId, "5", $date_added, $customer_notified, $comments);
			redirectURL(SITE_URL."payment.php?payment=failed");
		} else if($txtTransStatus == "Y") { // payment success
			//Payment success
			$date_added 		= time ();
			$customer_notified 	= 1;
			$comments 			= "Success payment";
			$cartObj->fun_addOrderStatusHistory($txtOrderId, "4", $date_added, $customer_notified, $comments);
			$cartObj->fun_updateOrderStatus($txtOrderId, "4", $date_added);
			$cartObj->fun_emptyUserCart($user_id);
			redirectURL(SITE_URL."payment.php?payment=success");
		} else {
			redirectURL(SITE_URL);
		}
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
//        	alert(x);alert(y);
        }
        function toggleLayer(whichLayer){
            var output = document.getElementById(whichLayer).innerHTML;
            if(whichLayer == 'ANP-Example')
            {		
                output = '<div style="z-index:5;">'+output+'</div>';
                var googlewin=dhtmlwindow.open("Example", "inline", output, "", "width=295px,height=470px,resize=0,scrolling=0,center=1,xAxis="+x+",yAxis="+y+"", "recal");
            }
            else if(whichLayer == 'cart-item-delete-pop')
            {		
                var x1 = x-150;
                var y1 = y-100;
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
    <div id="pg-wrapper" align="center"><h1 class="page-heading">Payment</h1></div>
    <div id="main">
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="left" valign="top">
					<?php require_once(SITE_INCLUDES_PATH.'owner-left-links.php'); ?>
                </td>
                <td width="30" align="left" valign="top" style="border-right:thin #efefef solid;">&nbsp;</td>
                <td align="left" valign="top" class="font12" style="padding-left:10px;">
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
					<?php
                        if(isset($_GET['payment']) && $_GET['payment'] == "success") {
                            require_once(SITE_INCLUDES_PATH.'paymentsuccess.php');
                        } else {
                            require_once(SITE_INCLUDES_PATH.'paymentfail.php');
                        }
                    ?>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
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







<body onmousedown="show_coords(event);" >
<!-- Main Wrapper Starts Here -->
<div id="wrapper">
    <!-- Header Include Starts Here -->
    <div id="header">
        <?php require_once(SITE_INCLUDES_PATH.'header.php'); ?>
    </div>
    <!-- Header Include End Here -->
    <div id="main">
        <div id="forinner">
            <?php require_once(SITE_INCLUDES_PATH.'holidayadvsearch.php'); ?>
            <div class="littlefont nav8">
                <?php require_once(SITE_INCLUDES_PATH.'breadcrumb.php'); ?>
            </div>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="left" valign="top" class="width240">
						<?php require_once(SITE_INCLUDES_PATH.'owner-left-links.php'); ?>
                    </td>
                    <td width="10" align="left" valign="top" style="border-left:1px dashed #44afe1;">&nbsp;</td>
                    <td align="left" valign="top" class="width745 pad-lft15">
						<?php
                            if(isset($_GET['payment']) && $_GET['payment'] == "success") {
                                require_once(SITE_INCLUDES_PATH.'paymentsuccess.php');
                            } else {
                                require_once(SITE_INCLUDES_PATH.'paymentfail.php');
                            }
                        ?>
                    </td>
                </tr>
            </table>
        </div>
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
