<table border="0" cellspacing="0" cellpadding="0" width="100%" class="font12">
    <tr>
        <td valign="top" class="pad-top10 pad-rgt10">
            <table border="0" cellspacing="2" cellpadding="0" width="100%">
                <tr>
                    <td valign="top" width="30"><img src="<?php echo SITE_IMAGES;?>green-arrow-new.png" width="30" /></td>
                    <td valign="middle"><span class="font18-darkgrey" style="padding-bottom:15px;">Yay ... you're payment was successful ;-)</span></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td valign="top" class="pad-top10 pad-rgt10" style="padding-left:30px;">
            <div>
                We will soon put live and add all the stuff you ordered. If you have any questions relating to your order then please contact us and we'll do our best to help.
                <br /><br />
                Thanks again for using rentownersvillas.com
            </div>
        </td>
    </tr>
    <tr>
        <td align="left" valign="top" class="pad-top10" style="padding-left:30px;">
            <a href="<?php if(isset($_SESSION['ses_user_home']) && $_SESSION['ses_user_home'] !=""){echo $_SESSION['ses_user_home'];} else {echo SITE_URL;}?>" style="text-decoration:none;"><img src="<?php echo SITE_IMAGES;?>myhomepage.gif" /></a>
        </td>
    </tr>
</table>                    
