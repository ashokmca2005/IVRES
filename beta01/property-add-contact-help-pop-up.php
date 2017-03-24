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
    <title><?php echo $sitetitle;?> :: Owner :: Add / Edit Property Contact details</title>
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
                <tr><td align="left" valign="top" class="pink14">Do I have to enter these details?</td></tr>
                <tr><td class="pad-btm16" align="left" valign="top">No but we'd advise that you do. Some people prefer to pick up the phone and call the owner directly rather than waiting for an email reply. By not giving these contact details you could be missing out bookings.</td></tr>
                <tr><td align="left" valign="top" class="pink14">I speak pigeon French, should I add this to the list?</td></tr>
                <tr><td class="pad-btm20" align="left" valign="top">The rule with adding languages is that if you can hold a telephone conversation and answer questions about your property and maybe give travel directions then yes, add that language. If you can't then it's advisable to just add the languages you are comfortable with.</td></tr>

                <tr><td align="left" valign="top" class="pink14">What happens if I'm late responding?</td></tr>
                <tr>
                <td class="pad-btm16" align="left" valign="top">
                The worst that will happen is that you will lose a potential booking. The Enquiry response time is purely a guideline for holidaymakers. We rarely check the accuracy of this and will only question it should we receive any complaints.
                </td>
                </tr>
                <tr><td class="pad-btm16" align="left" valign="top">&nbsp;</td></tr>
                <tr><td class="pad-btm16" align="left" valign="top">&nbsp;</td></tr>
            </table>
        </td>
    </tr>
</table>
<!-- Main Wrapper Ends Here -->
</body>
</html>