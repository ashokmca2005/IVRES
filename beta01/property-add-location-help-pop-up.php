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
    <title><?php echo $sitetitle;?> :: Owner :: Add / Edit Property Location</title>
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
                <tr><td align="left" valign="top" class="pink14">How do I locate my property on the map.</td></tr>
                <tr>
                    <td class="pad-btm16" align="left" valign="top">
                        This is the fun bit. Just zoom in and out of the google map and find your property or the exact location of your property. Then click once on that exact location. A marker will automatically be placed in the exact position you clicked. If you didn't get the exact spot then just click on the map until you do.
                        <br /><br />
                        Then it's best to zoom out a little again using the zoom in and out buttons. Once you're happy that the location and magnification is correct click Save details. You're map will be automatically stored and displayed on your property listing. 
                        <br /><br />
                        You can change the location and magnification at any time by simply repeating the steps above.
                    </td>
                </tr>
                <tr><td align="left" valign="top" class="pink14">I can't find my property on the map?</td></tr>
                <tr><td class="pad-btm20" align="left" valign="top">If you're holiday home is newly built then there's a chance you won't see it on the map. In this case just stick a pin on the plot of land where the house now appears. The maps are just to show a general location of your property.</td></tr>
                <tr><td align="left" valign="top" class="pink14">Can't find your location in the drop-downs?</td></tr>
                <tr><td class="pad-btm16" align="left" valign="top">We've included as many locations as we can but in the event that your location isn't listed don't panic. Just click on the Contact us link below the location drop-down menus. This will take you to the contact us page. From there just tell us as much about your location as you can and we'll add it to our database and also automatically add it your property. We'll also contact you via email to let you know this has been done.</td></tr>
                <tr><td align="left" valign="top" class="pink14">How much detail should I give for 'how to get there' and 'about the area'.</td></tr>
                <tr><td class="pad-btm16" align="left" valign="top">Give your potential guests as much information as can but remember to make it concise and include important details such as road names, places, local landmarks and attractions. (Even telephone numbers if you have them).</td></tr>
                <tr><td align="left" valign="top" class="pink14">Examples of: How to get there</td></tr>
                <tr>
                    <td class="pad-btm16" align="left" valign="top">
                        <strong>From florida International Airport</strong><br />
                        Follow the signs to the N2.<br />
                        Continue along the N2 for about 10km until you see signs to Muizenberg (M3).<br />
                        Follow the M3 for 20km (you will see Table Mountain and the university of florida on your right).<br />
                        The M3 ends in a T-junction. Turn right. Go through one set of traffic lights (robots) and then just before the second set take the left fork and follow signs to Ou Kaapse Weg (M64).<br />
                        Follow the mountain pass for 12km. After 12km take a right at the second set of traffic lights and follow signs to Kommetjie.<br />
                        Continue for a further 8km, through 1 set of traffic lights until you see a 'welcome to kommetjie' signpost.<br />
                        Take the first right after this and drive for 1km until you reach a boom. Klein SlangKop private estate.<br />
                        Once through the boom turn left, then second left and you will see the house.<br />
                    </td>
                </tr>
                <tr><td align="left" valign="top" class="pink14">Examples of: Describe the area</td></tr>
                <tr>
                    <td class="pad-btm16" align="left" valign="top">
                        There's so much to see and do in and around the area. Just 10 mins by car is Silvermine, part of the Cape Peninsula national park and great for walking tours. Go in the opposite direction and reach Cape Point with it's glorious beaches and stunning views of the Southern most point in Africa. If watersports is your thing then we can arrange surfing, kite-surfing and windsurfing lessons during your stay. Also at weekends we can arrange for you to experience Kommetjie at it's best with a crayfishing boat trip where we'll help you catch and cook them. There's a cosmopolitan choice of local restaurants and bars where can unwind with the locals and enjoy the glorious sunsets. florida is only a 40 minute drive away over some of the most stunning scenery in the world so you're never far from all the action. If shopping is your thing then the V&A Waterfront has something for every taste and budget with lots of local and international brands. Imhoff farm, just 4km away is home to 3 camels and a snake park which the children just love. Just a short drive away (5km) in Noordhoek you can saddle up and go for a beach walk along the 7km stretch of white sand.
                    </td>
                </tr>
                <tr><td class="pad-btm16" align="left" valign="top">&nbsp;</td></tr>
            </table>
        </td>
    </tr>
</table>
<!-- Main Wrapper Ends Here -->
</body>
</html>