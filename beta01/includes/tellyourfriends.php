<?php
if(isset($_GET['msg']) && ($_GET['msg'] == "thanks")) {
?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
        <tr><td align="left" valign="bottom" class="pad-top10"><?php echo tranText('site_notes_holiday_tellyourfriends_thanks'); ?></td></tr>
        <tr><td valign="middle" class="pad-top20"><a href="<?php if(isset($_SESSION['ses_user_home']) && $_SESSION['ses_user_home'] != "") {echo $_SESSION['ses_user_home'];} else {echo SITE_URL;} ?>" style="text-decoration:none;"><img src="<?php echo SITE_IMAGES;?>homepage-new.png" alt="Home" width="92" height="27" /></a>&nbsp;&nbsp;<a href="tell-your-friends" style="text-decoration:none;"><img src="images/tellmorefriends-new.png" alt="Tell more friends" /></a></td></tr>
    </table>
<?php
} else {
	$userSubject = "Check out this great site";
	$userMessage = tranText('site_notes_holiday_tellyourfriends');
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
            window.location = 'tell-your-friends';
        }
    
        function validateTellYourFriend() {
        }
    </script>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
        <tr><td align="left" valign="bottom" class="pad-top10"><?php echo tranText('site_notes_holiday_tellyourfriends_thanks'); ?></td></tr>
        <tr>
            <td align="left" valign="top">
                <form name="frmTellOurFriends" method="post" action="tell-your-friends">
                <input type="hidden" name="securityKey" value="<?php echo md5(TELLYOURFRIEND);?>" />
                    <table width="100%" border="0" cellpadding="5" cellspacing="0">
                        <tr>
                            <td width="195" align="right" valign="middle">Friends email</td>
                            <td width="235" valign="middle"><span class="RegFormRight"><input name="txtUserEmails" type="text" class="RegFormFld" id="txtUserEmailsId" value="<?php if(isset($_POST['txtUserEmails'])){echo $_POST['txtUserEmails'];}else{echo "";}?>" onkeydown="chkblnkTxtError('txtUserEmailsId', 'showErrorUserEmailsId');" onkeyup="chkblnkTxtError('txtUserEmailsId', 'showErrorUserEmailsId');" /></span></td>
                            <td width="234" valign="top"><span class="pdError1" id="showErrorUserEmailsId"><?php if(array_key_exists('txtUserEmails', $form_array)) echo $form_array['txtUserEmails'];?></span></td>
                        </tr>
                        <tr>
                            <td align="right" valign="middle">&nbsp;</td>
                            <td valign="middle" colspan="2">
                                <span class="font11 lineHeight13">(To add more than one friend, just separate email<br />addresses with a comma)</span>
                            </td>
                        </tr>
                        <tr>
                            <td align="right" valign="middle">Subject</td>
                            <td valign="middle"><span class="RegFormRight"><input name="txtUserSubject" type="text" class="RegFormFld" id="txtUserSubjectId" value="<?php if(isset($_POST['txtUserSubject'])){echo $_POST['txtUserSubject'];}else{echo $userSubject;}?>" onkeydown="chkblnkTxtError('txtUserSubjectId', 'showErrorUserSubjectId');" onkeyup="chkblnkTxtError('txtUserSubjectId', 'showErrorUserSubjectId');"  onclick="return bnkTellOurFriendSubject();" onblur="return restoreTellOurFriendSubject();" autocomplete="off" /></span></td>
                            <td valign="top"><span class="pdError1" id="showErrorUserSubjectId"><?php if(array_key_exists('txtUserSubject', $form_array)) echo $form_array['txtUserSubject'];?></span></td>
                        </tr>
                        <tr>
                            <td align="right" valign="top">Description</td>
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
                            <td colspan="2" valign="middle">By clicking submit you are agreeing to our <a href="javascript:popcontact('terms.html')" class="blue-link">terms and conditions</a></td>
                        </tr>
                        <tr><td colspan="3" align="right" valign="middle" class="dash25">&nbsp;</td></tr>
                        <tr>
                            <td align="right" valign="middle">&nbsp;</td>
                            <td colspan="2" valign="middle"><a href="javascript:cancelTellYourFriend();"><img src="<?php echo SITE_IMAGES;?>cancel-gray.gif" alt="Cancel" width="81" height="27" /></a>&nbsp;&nbsp;<input type="image" src="<?php echo SITE_IMAGES;?>submit.gif" alt="Submit" name="Submit" width="81" height="27" border="0" id="SubmitId" onclick="return validateTellYourFriend();"></td>
                        </tr>
                    </table>
                </form>
            </td>
        </tr>
    </table>
<?php
}
?>
