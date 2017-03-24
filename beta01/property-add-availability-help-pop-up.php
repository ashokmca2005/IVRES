<?php
	if($_SERVER["SERVER_NAME"] == "localhost") {
		require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
	} else {
		require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo tranText('charset'); ?>" />
    <META HTTP-EQUIV="Content-language" CONTENT="<?php echo tranText('lang_iso'); ?>">
    <link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo SITE_URL; ?>favicon.ico" />
    <link rel="SHORTCUT ICON" href="<?php echo SITE_URL; ?>favicon.ico"/>
    <title><?php echo $sitetitle;?> :: Owner :: Add / Edit Property Prices</title>
    <link href="css/owner.css" rel="stylesheet" type="text/css" />
</head>
<body style="color:#585858;">
<!-- Main Wrapper Starts Here -->
<table width="560" border="0" align="center" cellpadding="0" cellspacing="5" style="background:#FFFFFF;">
    <tr><td><img src="images/logo.jpg" /></td></tr>
    <tr>
        <td style="padding:20px;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                <tr><td align="left" valign="top" class="pad-btm18 font14 pad-top10">Here&rsquo;s just a few good examples of the sort of thing other people have written in these areas:</td></tr>
                <tr><td align="left" valign="top" class="pink14">How far in advance can I add availability?</td></tr>
                <tr><td class="pad-btm16" align="left" valign="top">You can add availability up to 2012.</td></tr>
                <tr><td align="left" valign="top" class="pink14">What about changeover days?</td></tr>
                <tr><td class="pad-btm20" align="left" valign="top">You'd be surprised how complicated changeover days are. Although as an owner you are familiar with the term (after all you use it all the time), holidaymakers are less savvy and so we've left these off in the hope of simplifying things. Essentially the calendar refers to nights booked. So if April 14 is coloured as booked, this means the property is not available for that night. The next available night would be the 15th which would appear as available on the calendar.</td></tr>

                <tr><td align="left" valign="top" class="pink14">What about marking special offers on the calendar?</td></tr>
                <tr>
                    <td class="pad-btm16" align="left" valign="top">
                    We are currently working on a modified version of the calendar that links directly to the prices chart. If you then add a special offer in the prices section it will replicate this on the availability calendar. We're looking to launch this version mid 2009. We'll keep you posted and let you know as soon as we do.                
                    </td>
                </tr>
                <tr><td align="left" valign="top" class="pink14">Can I have this calendar on my personal site?</td></tr>
                <tr>
                    <td class="pad-btm16" align="left" valign="top">
                    At the moment no but we are planning to launch this functionality in a few months. We'll let you know as soon as we do.
                    </td>
                </tr>
                <tr><td class="pad-btm16" align="left" valign="top">&nbsp;</td></tr>
                <tr><td class="pad-btm16" align="left" valign="top">&nbsp;</td></tr>
                <tr><td class="pad-btm16" align="left" valign="top">&nbsp;</td></tr>
            </table>
        </td>
    </tr>
</table>
<!-- Main Wrapper Ends Here -->
</body>
</html>