<div style="clear:both;">
<table width="690" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr>
        <td align="left" colspan="2" valign="top">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <td colspan="2" valign="top" class="pad-top10 pad-rgt10">
						<table border="0" cellspacing="2" cellpadding="0" width="100%">
							<tr>
								<td valign="top" width="62"><img src="<?php echo SITE_IMAGES;?>red-cross.png" width="62" /></td>
								<td valign="middle"><span class="font18-darkgrey" style="padding-bottom:15px;">Shame ... you're payment failed ;-(</span></td>
							</tr>
						</table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" valign="top" class="pad-top10 pad-rgt10" style="padding-left:30px;">
                        <div>
							This could be for a number or reasons. Dodgy card, error on the payment system or you have fat thumbs and typed the card info wrongly. Either way the best thing to do is a) try and checkout again or b) use a different card. 
							<br /><br />
							There's not a whole lot we can do about payment failures I'm afraid as all our payments are handled by WorldPay and if they decline it then there's usually a very good reason. However if you'd like us to shrug shoulders together or maybe find another way of paying then please <a href="<?php echo SITE_URL;?>contact-us" class="blue-link">contact us</a>. As always we'll do our best to help.
                        </div>
                    </td>
                </tr>
                <tr>
                	<td align="left" colspan="2" valign="top" class="pad-top10" style="padding-left:30px;">
						<a href="<?php echo SITE_URL."owner-shopping-cart"; ?>" style="text-decoration:none;"><img src="<?php echo SITE_IMAGES;?>try-again.png" /></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php if(isset($_SESSION['ses_user_home']) && $_SESSION['ses_user_home'] !=""){echo $_SESSION['ses_user_home'];} else {echo SITE_URL;}?>" style="text-decoration:none;"><img src="<?php echo SITE_IMAGES;?>myhome-gray.png" /></a>
                    </td>
                </tr>
            </table>                    
        </td>
    </tr>
    <tr><td align="left" colspan="2" valign="top">&nbsp;</td></tr>
</table>
</div>
