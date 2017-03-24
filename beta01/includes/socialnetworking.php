<h2>Newsletter</h2>
<div id="displayfrmId" class="newslatter-box" style="display:block;">
	<h3><?php echo tranText('newsletter_sign_up'); ?></h3>
	<?php /*?>
	<p><?php echo tranText('site_notes_sign_up'); ?></p>
	<?php */?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td width="185px" align="right" class="pad-top5">
            <input type="text" name="txtEmail" id="txtEmailId" placeholder="<?php echo tranText('enter_email_address'); ?>..." onKeyPress="checksignupEnter(event)" class="newsLetterSignUp" autocomplete="off" /><input type="button" class="newsLetterSignUp-btn" id="GO" value="Send" onclick="return validateSignUpForNewsletters();"/>
            </td>
        </tr>
    </table>
    <div id="showNewsLetterSignUpError" style="padding-left:0px;"></div>
</div>
<div id="displaythanksId" class="newslatter-box" style="display: none;">
	<h3><?php echo tranText('newsletter_sign_up'); ?></h3>
    <div style="margin-left:75px;"><?php echo tranText('site_notes_sign_up_thanks'); ?></div>
</div>
<div id="displayuserexistId" class="newslatter-box" style="display: none;">
	<h3><?php echo tranText('newsletter_sign_up'); ?></h3>
    <div style="margin-left:75px;"><?php echo tranText('site_notes_sign_up_userexits'); ?></div>
</div>
