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
    <title><?php echo $sitetitle;?> :: Owner :: Add / Edit Property Photos</title>
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
                <tr><td align="left" valign="top" class="pink14">Uploading photos</td></tr>
                <tr>
                    <td class="pad-btm16" align="left" valign="top">
                        This is by far the easiest way to get your photos on the site and it's very easy to do:
                        <br /><br />
                        1.	Click <strong>Browse</strong>. Then locate the image you want to upload from your PC<br />
                        2.	Click <strong>Upload</strong>. The image will automatically upload to our servers.<br />
                        3.	Add <strong>Photo caption</strong>. Add a line about the picture but remember to make it snappy!
                        <br /><br />
                        Then repeat as above for all the images you want to upload.
                    </td>
                </tr>
                <tr><td align="left" valign="top" class="pink14">What size and format should my photos be?</td></tr>
                <tr><td class="pad-btm20" align="left" valign="top">Photos are displayed in a 4x3 format, which is the size produced by most popular digital cameras. We can accept gifs, jpegs, tiffs and png formats with a maximum file size of 500kb per photo. The maximum size your photo will appear is 600x450 pixels so it's best if you resize it and make it look exactly as you'd like it before you upload. That way it'll also take less time to upload. Therefore the best settings to use are jpeg at 72dpi at "High" quality, 600x450 pixels.</td></tr>
                <tr><td align="left" valign="top" class="pink14">I don't own a digital camera, how do I add photos to my listing?</td></tr>
                <tr><td class="pad-btm16" align="left" valign="top">It will take a little longer to get your property listed but if you're using a film camera (as opposed to a digital camera) then you can send us your printed photos, we'll scan them and add them to your property. We can't return your photos so please make sure you've got some copies or they're not precious. You'll need to print out and fill in this Photo Inclusion form and include it with your photos. Please don't send your photos without a form included. You can then send them to either our UK or SA postal address (printed on the bottom of the form). To ensure we receive your photos it's best if you send via a signed-for service. We are not responsible for deliveries that fail to arrive. Please contact your local postal service should this happen.</td></tr>
                <tr><td align="left" valign="top" class="pink14">Which photo should I choose as my main image?</td></tr>
                <tr><td class="pad-btm16" align="left" valign="top">Use the photo that best shows your property. If it has a pool then it's always good to include this. Don't show a picture of the view no matter how fantastic it is, people will immediately think that your property isn't worth showing. Remember you can change your main photo at any time so you could even try a few and see which one gets the best results.</td></tr>
                <tr><td align="left" valign="top" class="pink14">How many photos can I add to my listing?</td></tr>
                <tr><td class="pad-btm16" align="left" valign="top">You get the first 12 photos FREE with your annual subscription but you can add as many as you like. They cost just R49 each per year and the more great images you have the greater the chance that people will fall in love with your accommodation. Just click on the 'add more photos' link at the top of the photo section, select how many extra pics you need and that's all there is to it.</td></tr>
                <tr><td class="pad-btm16" align="left" valign="top">&nbsp;</td></tr>
                <tr><td class="pad-btm16" align="left" valign="top">&nbsp;</td></tr>
                <tr><td class="pad-btm16" align="left" valign="top">&nbsp;</td></tr>
            </table>
        </td>
    </tr>
</table>
<!-- UniqueSleeps Main Wrapper Ends Here -->
</body>
</html>