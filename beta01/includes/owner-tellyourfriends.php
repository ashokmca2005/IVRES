<?php
if(isset($_GET['msg']) && ($_GET['msg'] == "thanks")) {
?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
        <tr><td align="left" valign="bottom" class="pad-top10"><?php echo tranText('site_notes_owner_tellyourfriends_thanks'); ?></td></tr>
        <tr><td valign="middle" class="pad-top20"><a href="<?php echo SITE_URL."owner-home"; ?>" style="text-decoration:none;" class="button-grey">Homepage</a>&nbsp;&nbsp;<a href="<?php echo SITE_URL."owner-tell-your-friends"; ?>" style="text-decoration:none;" class="button-blue">Tell more friends</a></td></tr>
    </table>
<?php
} else {
	$userSubject = "Check out this great site";
	$userMessage = tranText('site_notes_owner_tellyourfriends');
	?>
	<script language="javascript" type="text/javascript">
        function chkblnkTxtError(strFieldId, strErrorFieldId) {
            if(document.getElementById(strFieldId).value != "") {
                document.getElementById(strErrorFieldId).innerHTML = "";
            }
        }
    
        function chkblnkEditorTxtError(strFieldId, strErrorFieldId) {
            if(tinyMCE.get(strFieldId).getContent() != "") {
                document.getElementById(strErrorFieldId).innerHTML = "";
            }
        }
    
        function cancelTellYourFriend() {
            window.location = 'owner-owner-tell-your-friends.php';
        }
    
        function validateTellYourFriend() {
        }
    </script>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
        <tr><td align="left" valign="bottom" class="pad-top10"><?php echo tranText('site_notes_owner_tellyourfriends_thanks'); ?></td></tr>
        <tr>
            <td align="left" valign="top">
                <form name="frmTellOurFriends" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                <input type="hidden" name="securityKey" value="<?php echo md5(TELLYOURFRIEND);?>" />
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="left" valign="top">
                            <table width="100%" border="0" cellpadding="5" cellspacing="0">
                                <tr>
                                    <td width="195" align="right" valign="middle"><?php echo tranText('friends_email'); ?></td>
                                    <td width="235" valign="middle"><span class="RegFormRight"><input name="txtUserEmails" type="text" class="RegFormFld" id="txtUserEmailsId" value="<?php if(isset($_POST['txtUserEmails'])){echo $_POST['txtUserEmails'];}else{echo "";}?>" onkeydown="chkblnkTxtError('txtUserEmailsId', 'showErrorUserEmailsId');" onkeyup="chkblnkTxtError('txtUserEmailsId', 'showErrorUserEmailsId');" /></span></td>
                                    <td width="234" valign="top"><span class="pdError1" id="showErrorUserEmailsId"><?php if(array_key_exists('txtUserEmails', $form_array)) echo $form_array['txtUserEmails'];?></span></td>
                                </tr>
                                <tr>
                                    <td align="right" valign="middle">&nbsp;</td>
                                    <td valign="middle" colspan="2">
                                        <span class="font11 lineHeight13">(<?php echo tranText('to_add_more_than_one_friend_just_separate_email_addresses_with_a_comma'); ?>)</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right" valign="middle"><?php echo tranText('subject'); ?></td>
                                    <td valign="middle"><span class="RegFormRight"><input name="txtUserSubject" type="text" class="RegFormFld" id="txtUserSubjectId" value="<?php if(isset($_POST['txtUserSubject'])){echo $_POST['txtUserSubject'];}else{echo $userSubject;}?>" onkeydown="chkblnkTxtError('txtUserSubjectId', 'showErrorUserSubjectId');" onkeyup="chkblnkTxtError('txtUserSubjectId', 'showErrorUserSubjectId');"  onclick="return bnkTellOurFriendSubject();" onblur="return restoreTellOurFriendSubject();" autocomplete="off" /></span></td>
                                    <td valign="top"><span class="pdError1" id="showErrorUserSubjectId"><?php if(array_key_exists('txtUserSubject', $form_array)) echo $form_array['txtUserSubject'];?></span></td>
                                </tr>
                                <tr>
                                    <td align="right" valign="top"><?php echo tranText('description'); ?></td>
                                    <td colspan="2" valign="middle">
                                        <textarea name="txtUserMessage" id="txtUserMessageId" class="textArea460" ><?php echo $userMessage; ?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right" valign="top">&nbsp;</td>
                                    <td colspan="2" valign="middle">
                                        <span class="pdError1" id="txtUserMessageErrorId"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right" valign="middle">&nbsp;</td>
                                    <td colspan="2" valign="middle"><?php echo tranText('by_clicking_submit_you_are_agreeing_to_our'); ?> <a href="javascript:popcontact('terms.html')" class="blue-link">terms and conditions</a></td>
                                </tr>
                                <tr><td colspan="3" align="right" valign="middle" class="dash25">&nbsp;</td></tr>
                                <tr>
                                    <td align="right" valign="middle">&nbsp;</td>
                                    <td colspan="2" valign="middle">
                                    <a href="javascript:cancelTellYourFriend();" class="button-grey" style="text-decoration:none;">Cancel</a>&nbsp;<input type="submit" onclick="return validateTellYourFriend();" class="button-blue" value="Submit"/>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                </form>
            </td>
        </tr>
    </table>
<?php
}
?>
