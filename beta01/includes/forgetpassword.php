<?php
if(isset($frmsubmit) && ($frmsubmit == "success")){
?>
<!-- Forget Password Content: Start Here -->
<script language="javascript" type="text/javascript">
var req = ajaxFunction();

var pwd = "<?php echo $userLoginPass; ?>";
function sendPasswordReminder(strEmail) { 
	req.open('get', 'includes/ajax/sendPasswordReminderXml.php?email=' + strEmail+'&pwd=' + pwd); 
	req.onreadystatechange = handlePasswordReminderResponse; 
	req.send(null); 
} 
function handlePasswordReminderResponse() { 
	if(req.readyState == 4) { 
		var response = req.responseText;
		xmlDoc=req.responseXML;
		var root = xmlDoc.getElementsByTagName('progresses')[0];
		if(root != null) {
			var items = root.getElementsByTagName("progress");
			var item = items[0];
			var status = item.getElementsByTagName("status")[0].firstChild.nodeValue;
			if(status == "done"){
				document.getElementById("displaythanksId").innerHTML = " your new password has been sent again";
			} else {
				document.getElementById("displaythanksId").innerHTML = " your new password has been sent";
			}
		}
	}
}
</script>
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
        <tr>
        <td colspan="2" valign="top" class="pad-top10 pad-rgt10">
        <div class="FloatLft"><span class="latedealPink-20">Thanks ...</span><span style="font-weight:normal; font-size:20px;" id="displaythanksId"> your new password has been sent</span></div>
        </td>
        </tr>
        <tr>
        	<td colspan="2" valign="top" class="pad-rgt10 pad-top20" style="padding-left:5px;">
            <strong>If you don't receive this new password?</strong><br />
            <div class="font12">
				Your new password should be with you in a few minutes. If it isn't then please check your JUNK MAIL folder or SPAM folders. Failing that just add info@rentownersvillas.com to your Email address book or Safe sender list and click the Resend new password button below.
                <br /><br />
                It's useful to do this anyway to ensure future emails arrive in your inbox.
            </div>
            </td>
        </tr>
        <tr><td align="left" colspan="2" valign="top" class="pad-top20" style="padding-left:5px;"><a href="#" onclick="return sendPasswordReminder('<?php echo $txtUserEmail; ?>');" style="text-decoration:none;"><img src="<?php echo SITE_IMAGES;?>resend-new-password.png" /></a></td></tr>
    </table>
<?php
} else {
?>
<!-- Forget Password Content: Start Here -->
<script language="javascript" type="text/javascript">
var req = ajaxFunction(); 
function validate(){
	if(document.getElementById("txtUserEmailId").value == ""){
		document.getElementById("showError").innerHTML = "<span style=\"font-size:12px; color:#FF0000; font-weight:normal;\">Please enter your email address</span>";
		return false;
	} else {
		var emailRegxp = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if (emailRegxp.test(document.getElementById("txtUserEmailId").value)!= true){
			document.getElementById("showError").innerHTML = "<span style=\"font-size:12px; color:#FF0000; font-weight:normal;\">Please enter your email address</span>";
			return false;
		} else {
			document.getElementById("showError").innerHTML = "&nbsp;";
		}
	}
	document.frmForgetPassword.submit();
}
</script>
<form name="frmForgetPassword" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
	<input type="hidden" name="securityKey" value="<?php echo md5(FORGETPASSWORD);?>" />
    <table width="690" border="0" cellspacing="0" cellpadding="0" class="font12">
        <tr>
            <td align="left" valign="top" class="pad-top25 pad-btm20">
                <table border="0" align="left" cellpadding="0" cellspacing="0" class="font12">
                    <tr>
                        <td><?php echo tranText('enter_your_email_address'); ?></td>
                        <td class="pad-lft15"><input name="txtUserEmail" id="txtUserEmailId" type="text" class="width255" /></td>
                        <td><p class="FloatLft pad-lft10"><a href="javascript:void(0);" onclick="return validate();" class="button-blue" style="text-decoration:none; color:#FFFFFF;">Send new Password</a></p></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td class="pad-lft15" id="showError">
                        <?php 
                        if(isset($detail_array['txtUserEmail']) && $detail_array['txtUserEmail'] != "") {
                            echo $detail_array['txtUserEmail'];
                        } else {
                            echo "&nbsp";
                        }
                        ?>
                        </td>
                        <td>&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr><td align="left" valign="top">&nbsp;</td></tr>
        <?php
        if(isset($frmsubmit) && ($frmsubmit == "notfound")){
        ?>
        <tr><td align="left" valign="top" class="red12 pad-btm5"><strong>Sorry, we can't find that email address on your system.</strong></td></tr>
        <tr><td align="left" valign="top">Either <a href="<?php echo SITE_URL; ?>registration" class="blue-link">register</a> as a new member or <a href="<?php echo SITE_URL; ?>contact-us" class="blue-link">send us an email</a> with as much information about your details as you can and we'll see if we can help.</td></tr>
        <tr><td align="left" valign="top">&nbsp;</td></tr>
        <?php
        } else {
        ?>
        <tr>
            <td align="left" valign="top">
                <strong><?php echo tranText('Can_not_remember_your_email_address'); ?>?</strong><br />
                <a href="<?php echo SITE_URL; ?>contact-us" class="blue-link"><?php echo tranText('contact_us'); ?></a> <?php echo tranText('with_as_much_information_as_you_can_and_will_either_send_you_a_reminder_or_issue_you_with_a_new_password'); ?>.
            </td>
        </tr>
        <?php
        }
        ?>
    </table>
</form>
<!-- Forget Password Content: End Here -->
<?php
}
?>