<?php	
	if($_SERVER["SERVER_NAME"] == "localhost") {
		require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
	} else {
		require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
	}

	require_once(SITE_CLASSES_PATH."class.Users.php");
	require_once(SITE_CLASSES_PATH."class.Property.php");
	require_once(SITE_CLASSES_PATH."class.Location.php");
	require_once(SITE_CLASSES_PATH."class.Email.php");
	require_once(SITE_CLASSES_PATH."class.Currency.php");
	require_once(SITE_CLASSES_PATH."class.Promo.php");
	require_once(SITE_CLASSES_PATH."class.Product.php");
	require_once(SITE_CLASSES_PATH."class.Cart.php");
	require_once('paypal.class.php');  // include the class file

	$usersObj 		= new Users();
	$propertyObj 	= new Property();
	$locationObj 	= new Location();
	$promoObj 		= new Promo();
	$productObj 	= new Product();
	$cartObj 		= new Cart();
	$p 				= new paypal_class;// initiate an instance of the class
	
	if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !=""){
		$user_id 			= $_SESSION['ses_user_id'];
	} else {
		$user_id = "";
	}

	//$p->paypal_url 	= 'https://www.sandbox.paypal.com/cgi-bin/webscr';   // testing paypal url
	$p->paypal_url= 'https://www.paypal.com/cgi-bin/webscr';     // paypal url
            
	// setup a variable for this script (ie: 'http://www.micahcarrick.com/paypal.php')
	$this_script 	= 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
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
    <link rel="stylesheet" type="text/css" href="<?php echo SITE_CSS_INCLUDES_PATH;?>common.css" />
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>common.js"></script>
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
    <div id="pg-wrapper" align="center"><h1 class="page-heading">Payment</h1></div>
    <div id="main">
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="left" valign="top" width="90%">
                <?php
                // if there is not action variable, set the default action of 'process'
                if (empty($_GET['action'])) $_GET['action'] = 'process';  
                switch ($_GET['action']) {
                    case 'process':      // Process and order...
                        // There should be no output at this point.  To process the POST data,
                        // the submit_paypal_post() function will output all the HTML tags which
                        // contains a FORM which is submited instantaneously using the BODY onload
                        // attribute.  In other words, don't echo or printf anything when you're
                        // going to be calling the submit_paypal_post() function.
                        
                        // This is where you would have your form validation  and all that jazz.
                        // You would take your POST vars and load them into the class like below,
                        // only using the POST values instead of constant string expressions.
                        
                        // For example, after ensureing all the POST variables from your custom
                        // order form are valid, you might have:
                        //
                        // $p->add_field('first_name', $_POST['first_name']);
                        // $p->add_field('last_name', $_POST['last_name']);
                        if($_POST['securityKey']==md5("CHECKOUT")) {
                            //Posted variables
                            $propertyIdsArr			= $_POST['txtPropertyIds'];
                            $productIdsArr 			= $_POST['txtProductIds'];
                            $productPriceArr 		= $_POST['txtProductPrice'];
                            $productFinalPriceArr 	= $_POST['txtProductFinalPrice'];
                            $productQuantityArr 	= $_POST['txtProductQuantity'];
                            $txtPromoApply 			= $_POST['txtPromoApply'];
        
                            $item_name 				= "";
                            //Step I: enter in order table and get order id
                            $orders_id = $cartObj->fun_addNewOrder($user_id, "Paypal", "USD");
                            //Step II: enter in the order product table with the relation of order id
                            $total_payble_amt = 0;
                            for($i = 0; $i < count($productIdsArr); $i++) {
                                $products_id 		= $productIdsArr[$i];
                                $products_price 	= $productPriceArr[$i];
                                $final_price 		= $productFinalPriceArr[$i];
                                $total_payble_amt 	+= $final_price;
                                $products_quantity 	= $productQuantityArr[$i];
                                $item_arr 			= $productObj->fun_getProductInfo($products_id);
                                if(count($item_name) < 50) {
                                    $item_name 			.= $item_arr['products_name']." - qty ".$products_quantity.";";
                                }
                                $cartObj->fun_addOrderProduct($orders_id, $products_id, $products_price, $final_price, $products_quantity);
                                if(isset($propertyIdsArr[$i]) && $propertyIdsArr[$i] != "") {
                                    $property_id	= $propertyIdsArr[$i];
                                    $cartObj->fun_updateOrderProductProperty($orders_id, $products_id, $property_id);
                                }
                            }
                        
                            //Step III: enter in the order status history table with the relation of order id
                            $date_added 		= time ();
                            $customer_notified 	= 1;
                            $comments 			= "New order posted";
                            $cartObj->fun_addOrderStatusHistory($orders_id, "1", $date_added, $customer_notified, $comments);
                        
                            //Step IV: update promocode take-up
                            if(isset($txtPromoApply) && $txtPromoApply =="1") {
                                $txtPromotionalCode 	= $_POST['txtPromotionalCode'];
                                $promoObj->fun_addPromoUserTakeup($txtPromotionalCode, $user_id, $orders_id);
                            }
                        } else {
                            redirectURL(SITE_URL);
                        }
                        
                        if($total_payble_amt == 0) {
                            $cartObj->fun_addOrderStatusHistory($orders_id, "4", $date_added, $customer_notified, $comments);
                            $cartObj->fun_updateOrderStatus($orders_id, "4", $date_added);
                            $cartObj->fun_emptyUserCart($user_id);
                            echo '<h3>Thank you for your order. Go to <a href="'.SITE_URL.'owner-my-properties" class="button-grey" style="text-decoration:none; color:#fff;">My Properties</a></h3>';
                        } else {
        
                            $p->add_field('business', $paypalid);
                            $p->add_field('return', $this_script.'?action=success&orders_id='.$orders_id.'&user_id='.$user_id);
                            $p->add_field('cancel_return', $this_script.'?action=cancel&orders_id='.$orders_id.'&user_id='.$user_id);
                            $p->add_field('notify_url', $this_script.'?action=ipn&orders_id='.$orders_id.'&user_id='.$user_id);
                            $p->add_field('item_name', $item_name);
                            $p->add_field('amount', $total_payble_amt);
                            $p->add_field('currency_code', 'USD');
                            $p->add_field('orders_id', $orders_id);
                            $p->submit_paypal_post(); // submit the fields to paypal
                            //$p->dump_fields();      // for debugging, output a table of all the fields
                        }
                    break;
                    case 'success':      // Order was successful...
                        // This is where you would probably want to thank the user for their order
                        // or what have you.  The order information at this point is in POST 
                        // variables.  However, you don't want to "process" the order until you
                        // get validation from the IPN.  That's where you would have the code to
                        // email an admin, update the database with payment status, activate a
                        // membership, etc.  
                        
                        
                        $customer_notified 		= 1;
                        $orders_id 				= $_GET['orders_id'];
                        $comments 				= "Success payment";
                        $$date_added 			= time ();
                        $cartObj->fun_addOrderStatusHistory($orders_id, "4", $date_added, $customer_notified, $comments);
                        $cartObj->fun_updateOrderStatus($orders_id, "4", $date_added);
                        $cartObj->fun_emptyUserCart($user_id);
                        
						echo '<h3>Thank you for your order. Go to <a href="'.SITE_URL.'owner-my-properties" class="button-grey" style="text-decoration:none; color:#fff;">My Properties</a></h3>';
        
        //				foreach ($_POST as $key => $value) { echo "$key: $value<br>"; }
                        // You could also simply re-direct them to another page, or your own 
                        // order status page which presents the user with the status of their
                        // order based on a database (which can be modified with the IPN code 
                        // below).
                    break;
                    case 'cancel':       // Order was canceled...
                        // The order was canceled before being completed.
                        echo "<h3>The order was canceled.</h3>";
                    break;
                      
                    case 'ipn':          // Paypal is calling page for IPN validation...
                        // It's important to remember that paypal calling this script.  There
                        // is no output here.  This is where you validate the IPN data and if it's
                        // valid, update your database to signify that the user has payed.  If
                        // you try and use an echo or printf function here it's not going to do you
                        // a bit of good.  This is on the "backend".  That is why, by default, the
                        // class logs all IPN data to a text file.
                        
                        if ($p->validate_ipn()) {
                             // Payment has been received and IPN is verified.  This is where you
                             // update your database to activate or process the order, or setup
                             // the database with the user's order details, email an administrator,
                             // etc.  You can access a slew of information via the ipn_data() array.
                            
                             // Check the paypal documentation for specifics on what information
                             // is available in the IPN POST variables.  Basically, all the POST vars
                             // which paypal sends, which we send back for validation, are now stored
                             // in the ipn_data() array.
                            
                             // For this example, we'll just email ourselves ALL the data.
                             $subject = $_SERVER['HTTP_HOST'].' - Recieved Payment';
        
                             $emailHeaders = "";
                             $emailHeaders .= "From: " . $p->ipn_data['payer_email'];
                             $emailHeaders .= "\nMIME-Version: 1.0\n";
                             $emailHeaders .= "X-Mailer: PHP 4.x\n";
                             $emailHeaders .= "Content-type: text/html; charset=iso-8859-1 \n";
                             $emailHeaders .= "Content-Transfer-Encoding: 7bit";
        
                             $to = 'info@rentownersvillas.com';    //  your email
                             $body =  "We received your payment. Thank you\n";
                             $body .= "from ".$p->ipn_data['payer_email']." on ".date('m/d/Y');
                             $body .= " at ".date('g:i A')."\n\nDetails:\n";
                             $body .= " Amount Paid: ".$p->ipn_data['mc_gross']." ".$p->ipn_data['mc_currency'].".\n\n";
                             $body .= "Thanks,\n Team ".$_SERVER['HTTP_HOST']." \n";
                             //foreach ($p->ipn_data as $key => $value) { $body .= "\n$key: $value"; }
                             @mail($to, $subject, $body, $emailHeaders);
                        }
                    break;
                }     
                ?>
                </td>
            </tr>
        </table>
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
