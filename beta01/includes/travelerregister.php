<script type="text/javascript">
	$(document).ready(function(){
		$('#image_vcode').keypress(function(event){
			var keycode = (event.keyCode ? event.keyCode : event.which);
			if(keycode == '13'){
				validateRegister();
				//alert('You pressed a "enter" key in textbox');	
			}
			event.stopPropagation();
		});
	});
	/*
	$(document).keypress(function(event){
		var keycode = (event.keyCode ? event.keyCode : event.which);
		if(keycode == '13'){
			alert('You pressed a "enter" key in somewhere');	
		}
		event.stopPropagation();
	});
	*/
</script>
<h2 class="font16-darkgrey">Register</h2>
<form name="frmUserProfile" method="post" action="login">
<input type="hidden" name="securityKey" value="<?php echo md5(NEWREGISTRATION);?>" />
<input type="hidden" name="txtUserIP" value="<?php echo $_SERVER['REMOTE_ADDR']?>" />
<input type="hidden" name="txtIsOwner" id="txtIsOwnerId" value="0" />
<table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr>
        <td width="235" valign="left">
        <?php echo tranText('first_name'); ?><span class="compulsory">*</span><br />
        <input name="txtUserFName" type="text" class="RegFormFld" id="txtUserFNameId" value="<?php if(isset($_POST['txtUserFName']) && $_POST['txtUserFName']!=""){echo $_POST['txtUserFName'];}?>" onkeydown="chkblnkTxtError('txtUserFNameId', 'showErrorUserFNameId');" onkeyup="chkblnkTxtError('txtUserFNameId', 'showErrorUserFNameId');" />
        </td>
        <td valign="top"><span class="error" id="showErrorUserFNameId"><?php if(array_key_exists('txtUserFName', $form_array)) echo $form_array['txtUserFName'];?></span></td>
    </tr>
    <tr>
        <td valign="left">
        <?php echo tranText('last_name'); ?><span class="compulsory">*</span><br />
        <input name="txtUserLName" type="text" class="RegFormFld" id="txtUserLNameId" value="<?php if(isset($_POST['txtUserLName']) && $_POST['txtUserLName']!=""){echo $_POST['txtUserLName'];}?>" onkeydown="chkblnkTxtError('txtUserLNameId', 'showErrorUserLNameId');" onkeyup="chkblnkTxtError('txtUserLNameId', 'showErrorUserLNameId');" />
        </td>
        <td valign="top"><span class="error" id="showErrorUserLNameId"><?php if(array_key_exists('txtUserLName', $form_array)) echo $form_array['txtUserLName'];?></span></td>
    </tr>
    <tr>
        <td valign="left">
        <?php echo tranText('email_address'); ?><span class="compulsory">*</span><br />
        <input name="txtUserEmail" type="text" class="RegFormFld" id="txtUserEmailId" value="<?php if(isset($_POST['txtUserEmail']) && $_POST['txtUserEmail']!=""){echo $_POST['txtUserEmail'];}?>" />
        </td>
        <td valign="top"><span class="error" id="showErrorUserEmailId"><?php if(array_key_exists('txtUserEmail', $form_array)) echo $form_array['txtUserEmail'];?></span></td>
    </tr>
    <tr>
        <td valign="left">
        <?php echo tranText('password'); ?><span class="compulsory">*</span><br />
        <input name="txtUserPasswrd" type="password" class="RegFormFld" id="txtUserPasswrdId" value="<?php echo $_POST['txtUserPasswrd']; ?>" />
        </td>
        <td valign="top"><span class="error" id="showErrorPassword"><?php if(array_key_exists('txtUserPasswrd', $form_array)) echo $form_array['txtUserPasswrd'];?></span></td>
    </tr>
    <tr>
        <td valign="left">
        <?php echo tranText('confirm_password'); ?><span class="compulsory">*</span><br />
        <input name="txtConfirmPassword" type="password" class="RegFormFld" id="txtConfirmPasswordId" value="<?php echo $_POST['txtConfirmPassword']; ?>" />
        </td>
        <td valign="top"><span class="error" id="showErrorConfirmPassword"><?php if(array_key_exists('txtConfirmPassword', $form_array)) echo $form_array['txtConfirmPassword'];?></span></td>
    </tr>
    <tr>
        <td colspan="3" style="padding:0px;">
            <table border="0" cellpadding="5" cellspacing="0">
                <tr>
                    <td align="right" valign="middle"><?php echo tranText('type_this'); ?><span class="compulsory">*</span></td>
                    <td align="left" valign="middle" class="pad-lr"><img src="captchacode/securityimage.php?width=120&height=40&characters=5" alt="Word Scramble" class="RegFormScrambleImg" id="image_scode" name="image_scode" /></td>
                    <td align="left" valign="middle" class="pad-lft5"><?php echo tranText('into_this_box'); ?></td>
                    <td align="left" valign="middle" class="pad-lft5"><input name="image_vcode" id="image_vcode" type="text" class="txtBox100" value="" maxlength="5" autocomplete="off" /></td>
                    <td align="left" valign="middle"><div class="error" id="showErrorImgVCode"><?php if(array_key_exists('image_vcode', $form_array)) echo $form_array['image_vcode'];?></div></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="left" class="RegFormScrambleLink" style="padding-top:3px;"><a href="void(0);" onclick="document.image_scode.src='captchacode/securityimage.php?width=120&height=40&characters=5&'+Math.random();return false"><?php echo tranText('refresh_this_image'); ?></a></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
    <?php
        $whereUserSettingList 			= array();
        array_push($whereUserSettingList, "A.setting_id IN (1,3)");
        $userSettingListArr 	= $userSettingObj->fun_getUserSettingList($whereUserSettingList);
        if(isset($userSettingListArr) && is_array($userSettingListArr)) {
            echo "<tr>";
            echo "<td colspan=\"2\" valign=\"middle\">";
            echo "<table border=\"0\" cellspacing=\"4\" cellpadding=\"0\">";
            $strChecked = "";
            for($j=0; $j < count($userSettingListArr); $j++) {
                if(ucfirst($userSettingListArr[$j]['setting_id']) == "1") {
                    $strSettingTxt = "Yes, I would like to receive newsletter.";
                    $strChecked = "checked";
                } else if(ucfirst($userSettingListArr[$j]['setting_id']) == "3") {
                    $strSettingTxt = "Yes, I would like to receive offers from carefully selected partners.";
                    $strChecked = "";
                } else {
                    $strSettingTxt = ucfirst($userSettingListArr[$j]['setting_name']);
                }
                echo "<tr>";
                echo "<td padding-bottom:5px; width=\"19\"><input name=\"txtUserSetting[]\" id=\"txtUserSettingId".$j."\" type=\"checkbox\" value=\"".$userSettingListArr[$j]['setting_id']."\" class=\"checkbox\" ".$strChecked." /></td>";
                echo "<td style=\"padding-right:10px;\">".$strSettingTxt."</td>";
                echo "</tr>";
            }
            echo "<tr>";
            echo "<td padding-bottom:5px; width=\"19\"><input name=\"txtTerms\" id=\"txtTermsId\" type=\"checkbox\" value=\"1\" class=\"checkbox\" /></td>";
            echo "<td style=\"padding-right:10px;\">Agree the <a href=\"javascript:popcontact('terms.html')\" class=\"blue-link\">terms and conditions</a>&nbsp;&nbsp;<span class=\"error\" id=\"showErrorTerms\">&nbsp;</span></td>";
            echo "</tr>";
            echo "</table>";
            echo "</td>";
            echo "</tr>";
        }
    ?>
    <tr>
        <td colspan="2" valign="middle"><a href="javascript:cancelRegistration();" class="button-grey" style="text-decoration:none;">Cancel</a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="return validateRegister();" class="button-blue" style="text-decoration:none;">Submit</a></td>
    </tr>
</table>
</form>