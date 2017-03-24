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
	require_once('paypal.class.php');  // include the class file

	$usersObj 		= new Users();
	$propertyObj 	= new Property();
	$locationObj 	= new Location();
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
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="left" valign="top" width="90%">
                    <?php
                    // if there is not action variable, set the default action of 'process'
                    if (empty($_GET['action'])) $_GET['action'] = 'process';  
                    switch ($_GET['action']) {
                        case 'process':
                            // Process and order...
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
                            if(isset($_GET['booking']) && $_GET['booking'] != "") {
                                $booking_id 			= $_GET['booking'];
                    
                                //booking details
                                $bookingInfoArr = $propertyObj->fun_getPropertyBookingInfo($booking_id);
                                $property_id 		= $bookingInfoArr['property_id'];
                                $total_amount 		= $bookingInfoArr['total_amount'];
                                $owner_amount 		= $bookingInfoArr['owner_amount'];
                                $currency_code 		= $bookingInfoArr['currency_code'];
                                $arrival_date 		= $bookingInfoArr['arrival_date'];
                                $departure_date 	= $bookingInfoArr['departure_date'];
                                $payment_status 	= $bookingInfoArr['payment_status'];
                                $active 			= $bookingInfoArr['active'];
                                if($payment_status != "4" && $active = "1" ) {
                                    $bookingUserInfoArr = $usersObj->fun_getUserBookingInfo($booking_id);
                                    $txtUserFName 		= $bookingUserInfoArr['user_fname'];
                                    $txtUserLName 		= $bookingUserInfoArr['user_lname'];
                                    $txtUserEmail 		= $bookingUserInfoArr['user_email'];
                                    $txtUserName		= $txtUserFName." ".$txtUserLName;
                                    $item_name 			= "New booking for property id:".fill_zero_left($property_id, "0", (6-strlen($property_id)));
                                    $date_added 		= time ();
                                } else {
                            //	echo "test";
                                redirectURL(SITE_URL);
                                }
                            } else {
                               redirectURL(SITE_URL);
                            } 
                    
                            $p->add_field('business', $paypalid);
                            $p->add_field('return', $this_script.'?action=success&property_id='.$property_id.'&booking_id='.$booking_id);
                            $p->add_field('cancel_return', $this_script.'?action=cancel&property_id='.$property_id.'&booking_id='.$booking_id);
                            $p->add_field('notify_url', $this_script.'?action=ipn&property_id='.$property_id.'&booking_id='.$booking_id.'&arrival_date='.$arrival_date.'&departure_date='.$departure_date);
                    
                            $p->add_field('item_name', $item_name);
                            $p->add_field('amount', $owner_amount);
                            $p->add_field('currency_code', $currency_code);
                            $p->add_field('booking_id', $booking_id);
                            $p->add_field('property_id', $property_id);
                            $p->add_field('arrival_date', $arrival_date);
                            $p->add_field('departure_date', $departure_date);
                            $p->submit_paypal_post(); // submit the fields to paypal
                            //$p->dump_fields();      // for debugging, output a table of all the fields
                        break;
                        case 'success':      
                            // Order was successful...
                            // This is where you would probably want to thank the user for their order
                            // or what have you.  The order information at this point is in POST 
                            // variables.  However, you don't want to "process" the order until you
                            // get validation from the IPN.  That's where you would have the code to
                            // email an admin, update the database with payment status, activate a
                            // membership, etc.  
                            
                            $booking_id				= $_GET['booking_id'];
                            $property_id			= $_GET['property_id'];
                            ?>
                            <div class="conforms"><img src="<?php echo SITE_IMAGES;?>booking-i.gif" alt="check" /></div>
                            <div class="bookingtxt">Congratulations! Your payment has been received! <br />You have successfully booked your Holiday Rental... <br />Your booking id is: <span class="greenbooking"><?php echo fill_zero_left($booking_id, "0", (6-strlen($booking_id)))?></span></div>
                            <div style="clear:both"></div>
                            <br />
                            <?php
                            //foreach ($_POST as $key => $value) { echo "$key: $value<br>"; }
                            // You could also simply re-direct them to another page, or your own 
                            // order status page which presents the user with the status of their
                            // order based on a database (which can be modified with the IPN code 
                            // below).
                        break;
                        case 'cancel':
                            // Order was canceled...
                            // The order was canceled before being completed.
                            $booking_id				= $_GET['booking_id'];
                            $propertyObj->fun_delPropertyBooking($booking_id);
                            echo "<h3>Payment cancelled! Booking failed!.</h3>";
                        //	redirectURL(SITE_URL);
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
                    
                                $booking_id				= $_GET['booking_id'];
                                $property_id			= $_GET['property_id'];
                                $arrival_date			= $_GET['arrival_date'];
                                $departure_date			= $_GET['departure_date'];
                                $date_added 			= time ();
                                 // update payment status.
                                $propertyObj->fun_updateBookingStatus($booking_id, "4", $date_added);
                                
                                 // update booking status.
                                if($propertyObj->fun_addPropertyAvailablityDetails($property_id, $arrival_date, $departure_date, 3) === true){
                                    $propertyObj->fun_updatePropertyLastUpdate($property_id);
                                }
                                
                                $bookingArr 	= $propertyObj->fun_getPropertyBookingInfoArr(" AND A.booking_id = '".$booking_id."' ");

                                $user_name 		= $bookingArr[0]['user_name'];
                                $user_email 	= $bookingArr[0]['user_email'];
                                $user_phone 	= $bookingArr[0]['phone'];
                                $owner_name 	= $bookingArr[0]['owner_name'];
                                $owner_email 	= $bookingArr[0]['owner_email'];

                                // Mail to admin.
                                $subject = $_SERVER['HTTP_HOST'].' - Payment received for property booking';
                                $to = 'info@rentownersvillas.com';    //  your email
                                $emailHeaders = "";
                                $emailHeaders .= "From: " . $p->ipn_data['payer_email'];
                                $emailHeaders .= "\nMIME-Version: 1.0\n";
                                $emailHeaders .= "X-Mailer: PHP 4.x\n";
                                $emailHeaders .= "Content-type: text/html; charset=iso-8859-1 \n";
                                $emailHeaders .= "Content-Transfer-Encoding: 7bit";

                                $body = "<table width=\"600\"  border=\"0\" cellspacing=\"10\" cellpadding=\"0\">";
                                $body .= "<tr><td>&nbsp;</td></tr>";
                                $body .= "<tr><td>&nbsp;Payment received for booking property (".fill_zero_left($property_id, "0", (6-strlen($property_id))).").</td></tr>";
                                $body .= "<tr><td>&nbsp;from ".$p->ipn_data['payer_email']." on ".date('m/d/Y')." at ".date('g:i A')."\n\nBooking details are as below:</td></tr>";
                                $body .= "<tr><td>&nbsp;Property: ".$propertyObj->fun_getPropertyName($property_id)."</td></tr>";
                                $body .= "<tr><td>&nbsp;Customer: ".$p->ipn_data['first_name']." ".$p->ipn_data['last_name'].".</td></tr>";
                                $body .= "<tr><td>&nbsp;Customer telephone number: ".$user_phone.".</td></tr>";
                                $body .= "<tr><td>&nbsp;Date From: ".date('M j, Y', strtotime($arrival_date))."&nbsp;&nbsp;&nbsp;Date To: ".date('M j, Y', strtotime($departure_date))."</td></tr>";
                                $body .= "<tr><td>&nbsp;Booking deposit Paid: ".$p->ipn_data['mc_gross']." ".$p->ipn_data['mc_currency']."</td></tr>";
                                $body .= "<tr><td>&nbsp;</td></tr>";
                                $body .= "<tr><td>Thanks,</td></tr>";
                                $body .= "<tr><td>".$_SERVER['HTTP_HOST']."</td></tr>";
                                $body .= "</table>";
                                @mail($to, $subject, $body, $emailHeaders);
                    
                                // Mail to customer.
                                $subject1 = $_SERVER['HTTP_HOST'].' - property booking confirmed';
                                $to1 = $p->ipn_data['payer_email'];    //  customer email
                                $emailHeaders1 = "";
                                $emailHeaders1 .= "From: info@rentownersvillas.com";
                                $emailHeaders1 .= "\nMIME-Version: 1.0\n";
                                $emailHeaders1 .= "X-Mailer: PHP 4.x\n";
                                $emailHeaders1 .= "Content-type: text/html; charset=iso-8859-1 \n";
                                $emailHeaders1 .= "Content-Transfer-Encoding: 7bit";

                                $body1 = "<table width=\"600\"  border=\"0\" cellspacing=\"10\" cellpadding=\"0\">";
                                $body1 .= "<tr><td>&nbsp;</td></tr>";
                                $body1 .= "<tr><td>&nbsp;Property (".fill_zero_left($property_id, "0", (6-strlen($property_id))).") has booked for you as per requested date. Your booking id is: ".fill_zero_left($booking_id, "0", (6-strlen($booking_id))).".</td></tr>";
                                $body1 .= "<tr><td>&nbsp;Booking details are as below:</td></tr>";
                                $body1 .= "<tr><td>&nbsp;Property: ".$propertyObj->fun_getPropertyName($property_id)."</td></tr>";
                                $body1 .= "<tr><td>&nbsp;Customer: ".$p->ipn_data['first_name']." ".$p->ipn_data['last_name'].".</td></tr>";
                                $body1 .= "<tr><td>&nbsp;Date From: ".date('M j, Y', strtotime($arrival_date))."&nbsp;&nbsp;&nbsp;Date To: ".date('M j, Y', strtotime($departure_date))."</td></tr>";
                                $body1 .= "<tr><td>&nbsp;Booking deposit Paid: ".$p->ipn_data['mc_gross']." ".$p->ipn_data['mc_currency']."</td></tr>";
                                $body1 .= "<tr><td>&nbsp;</td></tr>";
                                $body1 .= "<strong>PLEASE NOTE:</strong> You will be contacted by the owner of this property to arrange payment for the outstanding amount owing for your holiday rental. If you have any questions about your booking you can contact the property owner directly. (Owner contact details can be found under the property listing on rentownersvillas.com) Alternatively you can <a href=".SITE_URL."holiday-contact-us.php?sbj=10&pid=".$property_id." style=\"color:#357bdc; text-decoration: none;\">contact us</a> quoting reference: ".fill_zero_left($booking_id, "0", (6-strlen($booking_id))).".</td></tr>";
                                $body1 .= "<tr><td>&nbsp;</td></tr>";
                                $body1 .= "<tr><td>Thanks,</td></tr>";
                                $body1 .= "<tr><td>".$_SERVER['HTTP_HOST']."</td></tr>";
                                $body1 .= "</table>";
                                @mail($to1, $subject1, $body1, $emailHeaders1);

                                // Mail to Home owner.
                                $subject2 = $_SERVER['HTTP_HOST'].' - Payment received for property booking';
                                $to2 = $owner_email;    //  your email
                                $emailHeaders2 = "";
                                $emailHeaders2 .= "From: " . $p->ipn_data['payer_email'];
                                $emailHeaders2 .= "\nMIME-Version: 1.0\n";
                                $emailHeaders2 .= "X-Mailer: PHP 4.x\n";
                                $emailHeaders2 .= "Content-type: text/html; charset=iso-8859-1 \n";
                                $emailHeaders2 .= "Content-Transfer-Encoding: 7bit";

                                $body2 = "<table width=\"600\"  border=\"0\" cellspacing=\"10\" cellpadding=\"0\">";
                                $body2 .= "<tr><td>&nbsp;</td></tr>";
                                $body2 .= "<tr><td>&nbsp;Payment received for booking property (".fill_zero_left($property_id, "0", (6-strlen($property_id))).").</td></tr>";
                                $body2 .= "<tr><td>&nbsp;from ".$p->ipn_data['payer_email']." on ".date('m/d/Y')." at ".date('g:i A')."\n\nBooking details are as below:</td></tr>";
                                $body2 .= "<tr><td>&nbsp;Property: ".$propertyObj->fun_getPropertyName($property_id)."</td></tr>";
                                $body2 .= "<tr><td>&nbsp;Customer: ".$p->ipn_data['first_name']." ".$p->ipn_data['last_name'].".</td></tr>";
                                $body2 .= "<tr><td>&nbsp;Customer telephone number: ".$user_phone.".</td></tr>";
                                $body2 .= "<tr><td>&nbsp;Date From: ".date('M j, Y', strtotime($arrival_date))."&nbsp;&nbsp;&nbsp;Date To: ".date('M j, Y', strtotime($departure_date))."</td></tr>";
                                $body2 .= "<tr><td>&nbsp;Booking deposit Paid: ".$p->ipn_data['mc_gross']." ".$p->ipn_data['mc_currency']."</td></tr>";
                                $body2 .= "<tr><td>&nbsp;</td></tr>";
                                $body2 .= "<tr><td>Thanks,</td></tr>";
                                $body2 .= "<tr><td>".$_SERVER['HTTP_HOST']."</td></tr>";
                                $body2 .= "</table>";
                                @mail($to2, $subject2, $body2, $emailHeaders2);
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
