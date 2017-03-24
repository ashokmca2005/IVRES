<?php	
	if($_SERVER["SERVER_NAME"] == "localhost") {
		require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
	} else {
		require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
	}
	require_once(SITE_CLASSES_PATH."class.Users.php");
	require_once(SITE_CLASSES_PATH."class.Property.php");
	require_once(SITE_CLASSES_PATH."class.Email.php");
	
	// Refer page finding functionality
	$referpage 		= ""; // If not any make it null
	$usersObj 		= new Users();
	$propertyObj 	= new Property();
	$u_id 			= $_SESSION['ses_user_id'];
	$usersDets 		= $usersObj->fun_getUsersInfo($u_id, "");
	
	if(isset($usersDets["is_owner"])){
		if($usersDets["is_owner"]=="1"){ // user is property owner go to add new property page
			if($referpage != ""){
				$continuepage = $referpage;  // go to refer page before registration
			} else {
				$continuepage = "property.php";  // go to refer page before registration
			}
			$myhome = "owner-home.php";
		} else { // user is holidaymaker go to checklist page
			if($referpage != ""){
				$continuepage = $referpage;  // go to refer page before registration
			} else {
				$continuepage = "checklist.php";  // go to refer page before registration
			}
			$myhome = "home.php";
		}
	} else {
		$continuepage = "checklist.php"; // go to refer page before registration
		$myhome = "home.php";
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
    <link rel="stylesheet" type="text/css" href="<?php echo SITE_CSS_INCLUDES_PATH;?>common.css" />
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>common.js"></script>
    <script type="text/javascript" language="JavaScript" src="<?php echo SITE_JS_INCLUDES_PATH;?>dargPop.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>dhtmlwindow.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>pop-up.js"></script>
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
    <div id="pg-wrapper" align="center"><h1 class="page-heading">Registration</h1></div>
    <div id="main">
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="left" valign="top">
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tr><td><img src="<?php echo SITE_IMAGES;?>left-panel-top.gif" /></td></tr>
                        <tr>
                            <td class="RegLeftPanel1">
                                <img src="<?php echo SITE_IMAGES;?>why-register.gif" alt="Why Register" />
                                <p class="RegLeftDash">&nbsp;</p>
                                <h1 class="Tick lineHight18">Save your searches</h1>
                                <p class="TickMatter">For the next time you visit the site</p>
                                <p class="RegLeftDash">&nbsp;</p>
                                <h1 class="Tick lineHight18">Fill out multiple enquiry forms</h1>
                                <p class="TickMatter">For the next time you visit the site</p>
                                <p class="RegLeftDash">&nbsp;</p>
                                <h1 class="Tick lineHight18">RSS late deals straight to your desktop</h1>
                                <p class="TickMatter">Be the first to know about late deals and all the latest news from UniqueSleeps.com</p>
                                <p class="RegLeftDash">&nbsp;</p>
                                <h1 class="Tick lineHight18">FREE noticeboard enquiries</h1>
                                <p class="TickMatter">Place a notice on our Owners board and let the owners come to you</p>
                                <p class="RegLeftDash">&nbsp;</p>
                                <h1 class="Tick lineHight18">Pay online</h1>
                                <p class="TickMatter">Use your credit card to pay for properties online. (Only available on properties where indicated)</p>
                                <p class="RegLeftDash">&nbsp;</p>
                                <h1 class="Tick">FREE newsletter</h1>
                                <p class="TickMatter">Get our monthly newslettter packed with deals and ideas</p>
                            </td>
                        </tr>
                        <tr><td><img src="<?php echo SITE_IMAGES;?>left-panel-bottom.gif" /></td></tr>
                    </table>
                </td>
                <td width="30" align="left" valign="top" style="border-right:thin #efefef solid;">&nbsp;</td>
                <td align="left" valign="top" class="font12" style="padding-left:10px;">
                    <div class="RegFormMain"><p class="Registration1"><img src="<?php echo SITE_IMAGES;?>congratulations.gif" alt="Congratulations" class="Registration" /></p></div>
                    <div class="RegFormMain">
                        <h1 class="RegFormH1">You're registration was successful. Welcome to <?php echo $sitetitle;?></h1>
                        <p class="RegFormTxt">You've successfully registered with <?php echo $sitetitle;?>.<br />Now it's time to make use of all the great features we have. Enjoy the site, we're sure you will ...</p>
                        <p class="RegFormDash">&nbsp;</p>
                        <h1 class="RegFormH1">What would you like to do now?</h1>
                        <p class="FloatLft" style="padding-top: 10px;">
                        <?php
                        /*
                        * User Home Page Functionalities: If user is holiday maker it goes to their dashboard, 
                        * If user is property owner than it goes to their dashboard; Otherwise it goes to site
                        * homepage
                        */
                        //				$myhome = "home.php";
                        ?>
                        <a href="<?php echo $myhome;?>"><img src="<?php echo SITE_IMAGES;?>homepage.gif" alt="Go To My Homepag" name="Homepage" width="135" height="30" border="0" id="Homepage" /></a>
                        </p>
                        <p class="FloatLft" style="padding-left: 10px; padding-top: 10px;">
                        <?php
                        /*
                        * Continues Functionalities: If there is any refer page, than it goes to that page; Otherwise, 
                        * if user is holiday maker it goes to checklist page, 
                        * If user is property owner than it goes to add new property page
                        */
                        //				$continuepage = "checklist.php";
                        ?>
                        <a href="<?php echo $continuepage;?>"><img src="<?php echo SITE_IMAGES;?>continue.gif" alt="Continue" name="Continue" border="0" /></a>
                        </p>
                    </div>
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
