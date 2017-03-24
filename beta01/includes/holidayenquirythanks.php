<table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td colspan="2" valign="top" class="pad-top10 pad-rgt10">
            <div class="FloatLft"><span><img src="<?php echo SITE_IMAGES;?>green-arrow-new.png" width="30" />&nbsp;&nbsp;</span><span class="latedealPink-20">Thanks ...</span><span class="latedealGray"><span style="font-weight:normal; font-size:20px;"> you're enquiry has been sent</span></span></div>
        </td>
    </tr>
    <tr>
        <td colspan="2" valign="top" class="pad-top10 pad-rgt10" style="padding-left:30px;">
            <div>
                You're unique enquiry ID is: <?php echo fill_zero_left($_GET['enquiry'], "0", (9-strlen($_GET['enquiry']))); ?>
                <br />
                Please make a note of this for future reference and always quote it in correspondance regarding this enquiry.
                <br /><br />
                Our owners are pretty good at responding to enquiries so please keep an eye on your inbox.
                <br /><br />
                Regards, the <?php echo $sitetitle; ?> team
            </div>
        </td>
    </tr>
    <tr>
        <td align="left" colspan="2" valign="top" class="pad-top10" style="padding-left:30px;">
            <a href="<?php if(isset($_SESSION['ses_user_home']) && $_SESSION['ses_user_home'] !=""){echo $_SESSION['ses_user_home'];} else {echo SITE_URL;}?>" style="text-decoration:none;"><img src="<?php echo SITE_IMAGES;?>returntohomepage-gray.gif" /></a>
        </td>
    </tr>
</table>                    
