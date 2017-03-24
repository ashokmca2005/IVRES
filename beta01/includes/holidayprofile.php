<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr>
        <td align="left" valign="bottom">
            <form name="frmUserProfile" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
            <input type="hidden" name="securityKey" value="<?php echo md5(USERPROFILE);?>" />
            <input type="hidden" name="txtUserId" id="txtUserId" value="<?php echo $user_id;?>" />
            <input type="hidden" name="txtUserChangePassword" id="txtUserChangePasswordId" value="0" />
            <table width="100%" border="0" cellpadding="5" cellspacing="0">
                <tr>
                    <td width="155" align="right" valign="middle">First name</td>
                    <td width="235" valign="middle"><span class="RegFormRight"><input name="txtUserFName" type="text" class="RegFormFld" id="txtUserFNameId" value="<?php if(isset($_POST['txtUserFName'])){echo $_POST['txtUserFName'];}else{echo $userInfoArr['user_fname'];}?>" onkeydown="chkblnkTxtError('txtUserFNameId', 'showErrorUserFNameId');" onkeyup="chkblnkTxtError('txtUserFNameId', 'showErrorUserFNameId');" /></span></td>
                    <td width="274" valign="top"><span class="pdError1" id="showErrorUserFNameId"><?php if(array_key_exists('txtUserFName', $form_array)) echo $form_array['txtUserFName'];?></span></td>
                </tr>
                <tr>
                    <td width="155" align="right" valign="middle">Last name</td>
                    <td width="235" valign="middle"><span class="RegFormRight"><input name="txtUserLName" type="text" class="RegFormFld" id="txtUserLNameId" value="<?php if(isset($_POST['txtUserLName'])){echo $_POST['txtUserLName'];}else{echo $userInfoArr['user_lname'];}?>" onkeydown="chkblnkTxtError('txtUserLNameId', 'showErrorUserLNameId');" onkeyup="chkblnkTxtError('txtUserLNameId', 'showErrorUserLNameId');" /></span></td>
                    <td width="274" valign="top"><span class="pdError1" id="showErrorUserLNameId"><?php if(array_key_exists('txtUserLName', $form_array)) echo $form_array['txtUserLName'];?></span></td>
                </tr>
                <tr>
                    <td width="155" align="right" valign="middle">Email address</td>
                    <td width="235" valign="middle"><span class="RegFormRight"><input name="txtUserEmail" type="text" class="RegFormFld" id="txtUserEmailId" value="<?php if(isset($_POST['txtUserEmail'])){echo $_POST['txtUserEmail'];}else{echo $userInfoArr['user_email'];}?>" /></span></td>
                    <td width="274" valign="top"><span class="pdError1" id="showErrorUserEmailId"><?php if(array_key_exists('txtUserEmail', $form_array)) echo $form_array['txtUserEmail'];?></span></td>
                </tr>
                <tr>
                    <td colspan="3" valign="top" style="padding:0px;">
                        <div id="showchangepassLinkId" style="display:block;">
                            <table width="690" border="0" cellspacing="0" cellpadding="5">
                                <tr>
                                    <td width="155" align="right" valign="middle">Password</td>
                                    <td width="235" valign="middle"><input name="txtUserPasswrd" type="password" class="RegFormFld" id="txtUserPasswrdId" value="*******" /></td>
                                    <td width="274" valign="top"><div id="showchangepassLinkId1" align="left"><a href="javascript:showChangePassword(1);" class="blue-link">Change Password</a></div></td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" valign="top" style="padding:0px;">
                        <div id="showchangepassId" style="display:none; padding-top:5px; padding-bottom:5px; background:#f7f7f7;">
                            <table width="690" border="0" cellspacing="0" cellpadding="5">
                                <tr>
                                    <td width="155" align="right" valign="middle">Current Password</td>
                                    <td width="235" valign="top"><input name="txtOldPassword" id="txtOldPasswordId" type="password" class="RegFormFld" value="" onkeydown="chkblnkTxtError('txtOldPasswordId', 'showErrorOldPassword');" onkeyup="chkblnkTxtError('txtOldPasswordId', 'showErrorOldPassword');" /></td>
                                    <td width="274" valign="top">
                                        <span class="pdError1" id="showErrorOldPassword">&nbsp;</span>                                
                                    </td>
                                </tr>
                                <tr>
                                    <td  width="155" align="right" valign="middle">New password</td>
                                    <td  width="235" valign="top"><input name="txtNewPassword" id="txtNewPasswordId" type="password" class="RegFormFld" value="" onkeydown="chkblnkTxtError('txtNewPasswordId', 'showErrorNewPassword');" onkeyup="chkblnkTxtError('txtNewPasswordId', 'showErrorNewPassword');" /></td>
                                    <td valign="top">
                                        <span class="pdError1" id="showErrorNewPassword">&nbsp;</span>                                
                                    </td>
                                </tr>
                                <tr>
                                    <td width="155" align="right" valign="middle">Repeat new password</td>
                                    <td width="235" valign="top"><input name="txtConfirmPassword" id="txtConfirmPasswordId" type="password" class="RegFormFld" value=""onkeydown="chkblnkTxtError('txtConfirmPasswordId', 'showErrorConfirmPassword');" onkeyup="chkblnkTxtError('txtConfirmPasswordId', 'showErrorConfirmPassword');" /></td>
                                    <td valign="top">
                                        <span class="pdError1" id="showErrorConfirmPassword">&nbsp;</span>                                
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
                <?php
                    $whereUserSettingList 			= array();
                    array_push($whereUserSettingList, "A.setting_id IN (1,3)");
                    $userSettingListArr 	= $userSettingObj->fun_getUserSettingList($whereUserSettingList);
                
                    // Set user setting checked here
                    $UserSetting 		= array();
                    if(isset($userSettingInfoArr) && is_array($userSettingInfoArr)){
                        foreach($userSettingInfoArr as $value){
                            array_push($UserSetting, $value['setting_id']);
                        }
                    }
            
                    if(isset($userSettingListArr) && is_array($userSettingListArr)) {
                        echo "<tr>";
                        echo "<td align=\"right\" valign=\"middle\" class=\"pad-top15\">&nbsp;</td>";
                        echo "<td colspan=\"2\" valign=\"middle\">";
                        echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
            
                        for($j=0; $j < count($userSettingListArr); $j++) {
                            if(in_array($userSettingListArr[$j]['setting_id'], $UserSetting)) {
                                $strChecked = "checked";
                            } else {
                                $strChecked = "";
                            }
                            echo "<tr>";
                            echo "<td width=\"19\"><input name=\"txtUserSetting[]\" id=\"txtUserSettingId".$j."\" type=\"checkbox\" value=\"".$userSettingListArr[$j]['setting_id']."\" class=\"checkbox\" ".$strChecked." /></td>";
                            echo "<td width=\"327\">".ucfirst($userSettingListArr[$j]['setting_name'])."</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                        echo "</td>";
                        echo "</tr>";
                    }
                ?>
                <tr><td colspan="3" align="right" valign="middle" class="line25">&nbsp;</td></tr>
                <tr>
                    <td align="right" valign="middle">&nbsp;</td>
                    <td colspan="2" valign="middle"><a href="javascript:cancelChangeProfile();"><img src="<?php echo SITE_IMAGES;?>cancel-events.gif" alt="Cancel"  /></a>&nbsp;&nbsp;<input type="image" src="<?php echo SITE_IMAGES;?>save-changes-btn.png" alt="Save Changes" name="SaveChange" width="133" height="26" border="0" id="SaveChangeId"  onclick="return validateSaveProfile();"></td>
                </tr>
            </table>
            </form>
        </td>
    </tr>
    <tr><td width="690" valign="top">&nbsp;</td></tr>
    <tr>
        <td align="left" valign="top">
            <div id="MAP-Pop" style="display:none;">
            <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="left"><img src="<?php echo SITE_IMAGES;?>map-left.gif" alt="One"/></td>
                    <td valign="top" class="mapBg">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td><img src="<?php echo SITE_IMAGES;?>capetown.gif" alt="capetown" class="pad-top10 pad-btm12" /></td>
                                <td align="right" valign="top"><a href="#" onclick="javascript:toggleLayer('MAP-Pop');"><img src="<?php echo SITE_IMAGES;?>close.gif" alt="Close" border="0" /></a></td>
                            </tr>
                            <tr><td colspan="2"><img src="<?php echo SITE_IMAGES;?>mapPic.gif" alt="map"/></td></tr>
                            <tr><td colspan="2" class="pad-top10"><a href="#" onclick="javascript:toggleLayer('MAP-Pop');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image17','','<?php echo SITE_IMAGES;?>close-window21-over.gif',1)"><img src="<?php echo SITE_IMAGES;?>close-window21-out.gif" alt="Close window" name="Image17" border="0" id="Image17" /></a></td></tr>
                        </table>
                    </td>
                    <td align="right"><img src="<?php echo SITE_IMAGES;?>map-right.gif" alt="One"/></td>
                </tr>
            </table>
            </div>
        </td>
    </tr>
</table>
