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
	require_once(SITE_CLASSES_PATH."class.CMS.php");

	$usersObj 		= new Users();
	$propertyObj 	= new Property();
	$locationObj 	= new Location();
	$cmsObj         = new Cms();
	
	if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !=""){
		$user_id 			= $_SESSION['ses_user_id'];
		$userInfoArr 		= $usersObj->fun_getUsersInfo($user_id);
		$users_first_name 	= $userInfoArr['user_fname'];
		$users_last_name 	= $userInfoArr['user_lname'];
		$users_email_id 	= $userInfoArr['user_email'];
		$user_full_name 	= ucwords($users_first_name." ".$users_last_name);
		$country_id 		= $userInfoArr['user_country'];
		$rcountry_id 		= $userInfoArr['user_rcountry'];

		$users_currency_code= $usersObj->fun_getUserCurrencyCode($user_id);
	} else {
		$users_currency_code= $usersObj->fun_getUserCurrencyCode();
	}

	switch($users_currency_code) {
		case 'USD':
			$users_currency_id 	= 1;
		break;
		case 'GBP':
			$users_currency_id 	= 2;
		break;
		case 'EUR':
			$users_currency_id 	= 3;
		break;
		default:
			$users_currency_id 	= DEFAULT_CURRENCY;
	}

	$users_currency_symbol = $usersObj->fun_getUserCurrencySymbol($users_currency_code);
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
    <script language="javascript" type="text/javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>pop-up.js"></script>
    <script language="javascript" type="text/javascript">
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
    <div id="pg-wrapper" align="center"><h1 class="page-heading">Booking details</h1></div>
    <div id="main">
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="left" valign="top">
					<?php require_once(SITE_INCLUDES_PATH.'holidayhotproperty-left.php'); ?>
                </td>
                <td width="30" align="left" valign="top" style="border-right:thin #efefef solid;">&nbsp;</td>
                <td align="left" valign="top" class="font12" style="padding-left:10px;">
                    <div id="showDetails">
                        <?php
                        $error_msg	= 'yes';
                        if($_POST['securityKey']==md5(BOOKINGENGINE)){ // First time post
                            $property_id            = $_POST['txtPropertyId'];
                            $arriavalDate        	= $_POST['txtArriavalDate'];
                            $arrDateArr 			= explode('-', $arriavalDate);
                            $arrangeArrivaldate 	= $arrDateArr[2].'-'.$arrDateArr[1].'-'.$arrDateArr[0];
                            $departureDate          = $_POST['txtDepartureDate'];
                            $depDateArr 			= explode('-', $departureDate);
                            $arrangeDeparturedate= $depDateArr[2].'-'.$depDateArr[1].'-'.$depDateArr[0];
                            if(isset($arriavalDate) && $arriavalDate != "" && isset($departureDate) && $departureDate != "") {
                        
                                $strUnixDateFrom 	= strtotime($arriavalDate);
                                $strUnixDateTo	 	= strtotime($departureDate);
                                if(($test = $propertyObj->fun_checkBookingAvailability($property_id, $arriavalDate, $departureDate)) && ($test == true)) { // if true
                                $error_msg = 'no';
                                }
                            } else {
                                $error_msg = 'yes';
                            }
                        }

                        if($error_msg == 'yes') {
                        ?>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td align="left" valign="top" class="pad-top10">The page you have requested cannot be found or the requested accommodation has been reserved meanwhile. Please try to <a href="javascript:history.go(-1);" class="blue">reload</a> the page or choose another <a href="javascript:history.go(-1);" class="blue">arrival date</a>. </td>
                            </tr>
                        </table>
                        <?php
                        } else {
                            require_once(SITE_INCLUDES_PATH.'propertybookingpreview.php');
                        }
                        ?>
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
