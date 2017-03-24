<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr>
        <td align="left" colspan="2" valign="top">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <td colspan="2" valign="top" class="pad-top10 pad-rgt10">
                        <div class="FloatLft"><span><img src="<?php echo SITE_IMAGES;?>green-arrow-new.png" width="30" />&nbsp;&nbsp;</span><span class="latedealPink-20">Thanks ...</span><span style="font-weight:normal; font-size:20px;"> you're almost there!</span></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" valign="top" class="pad-rgt10 pad-top20" style="padding-left:5px;">
                        <div class="font12 pad-lft20">You will shortly receive a confirmation email. Just click on the link to confirm your email address</div>
                    </td>
                </tr>
                </div>
                
                <tr>
                    <td align="left" colspan="2" valign="top" class="pad-top20" style="padding-left:30px;">
                        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" name="RegForm" id="RegForm">
                            <input type="hidden" name="securityKey" value="<?php echo md5(NEWREGISTRATION2);?>">
                            <input type="hidden" name="txtUserId" value="<?php echo $_SESSION['registraton_id']; ?>">
                            <input type="hidden" name="txtUserPasswrd" value="<?php echo $_SESSION['registraton_pass']; ?>">
                            <span class="pink18">If you don't receive the email</span> <br />
                            <span class="font12">The confirmation email should be with you in a few mintues. If it isn't then check your JUNK MAIL folder or SPAM folders. Failing that add info@rentownersvillas.com to your Email Address Book or Safe Sender list and click the Resend Email button below. <br />
                            <br />
                            It's useful to do this anyway to ensure future emails from us arrive in your inbox.</span>
                            <p class="pad-top10">
                                <input src="images/resendemail.gif" type="image" width="128" height="30" />
                            </p>
                        </form>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="left" colspan="2" valign="top">&nbsp;</td>
    </tr>
</table>
