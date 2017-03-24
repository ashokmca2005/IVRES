<?php 
$dayname 	= array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');
$monthname 	= array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec');
$yearname 	= array();
$startYear	= date('Y') - 100;
$endYear	= date('Y') - 16;
for($counter = $endYear; $counter >= $startYear; $counter--) {
	array_push($yearname, $counter);
}
?>
<script language="javascript" type="text/javascript">
	function chkShowSMS() {
		if(document.getElementById("txtPropertySMSId").checked == true) {
			document.getElementById("showSMSID").style.display = "block";
		} else {
			document.getElementById("showSMSID").style.display = "none";
		}
	}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr>
        <td align="left" valign="top" class="pad-top15">
            <form name="frmUserPhoto" id="frmUserPhoto" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
            <input type="hidden" name="securityKey" value="<?php echo md5(USERPHOTO);?>" />
            <input type="hidden" name="txtUserId" id="txtUserId" value="<?php echo $user_id;?>" />
            <table width="100%" border="0" cellpadding="5" cellspacing="0">
                <tr>
                    <td width="155" align="right" valign="middle">Profile photo</td>
                    <td width="300" align="center" valign="middle" style="background-color:#efefef; padding-top:10px; padding-bottom:10px;"><img src="<?php echo SITE_UPLOAD_PATH.$profile_photo;?>" width="163px" height="152px" onError="this.src='<?php echo SITE_IMAGES;?>profile-placer.png';" /></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td width="155" align="right" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle" colspan="2"><input type="file" name="txtFile" id="txtFile" value="" class="inpuTxt"/>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="return editProfilePhoto();" class="button-blue" style="text-decoration:none; color:#FFFFFF;">Upload</a></td>
                </tr>
            </table>
            </form>
        </td>
    </tr>
    <tr>
        <td align="left" valign="top" class="pad-top15">
            <form name="frmUserStory" id="frmUserStory" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
            <input type="hidden" name="securityKey" value="<?php echo md5(USERSTORY);?>" />
            <input type="hidden" name="txtUserId" id="txtUserId" value="<?php echo $user_id;?>" />
            <table width="100%" border="0" cellpadding="5" cellspacing="0">
                <tr>
                    <td width="155" align="right" valign="top">Owner Story</td>
                    <td align="left" valign="middle">
                        <textarea name="txtProfileStory" id="txtProfileStoryId" cols="" rows="" class="txtarea_500x80"><?php if(isset($_POST['txtProfileStory']) && $_POST['txtProfileStory'] != ""){echo $_POST['txtProfileStory'];} else {echo $profile_story;}?></textarea>
                    </td>
                </tr>
                <tr>
                    <td width="155" align="right" valign="middle">&nbsp;</td>
                    <td align="left" valign="middle"><a href="javascript:void(0);" onclick="return editProfileStory();" class="button-blue" style="text-decoration:none; color:#FFFFFF;">Update</a></td>
                </tr>
            </table>
            </form>
        </td>
    </tr>
    <tr>
        <td align="left" valign="top" class="pad-top15">
            <form name="frmUserProfile" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
            <input type="hidden" name="securityKey" value="<?php echo md5(USERPROFILE);?>" />
            <input type="hidden" name="txtUserId" id="txtUserId" value="<?php echo $user_id;?>" />
            <table width="100%" border="0" cellpadding="5" cellspacing="0">
                <tr>
                    <td width="155" align="right" valign="middle"><?php echo tranText('first_name'); ?></td>
                    <td width="235" valign="middle"><span class="RegFormRight"><input name="txtUserFName" type="text" class="RegFormFldowner" id="txtUserFNameId" value="<?php if(isset($_POST['txtUserFName'])){echo $_POST['txtUserFName'];}else{echo $userInfoArr['user_fname'];}?>" onkeydown="chkblnkTxtError('txtUserFNameId', 'showErrorUserFNameId');" onkeyup="chkblnkTxtError('txtUserFNameId', 'showErrorUserFNameId');" /></span></td>
                    <td width="274" valign="top"><span class="pdError1" id="showErrorUserFNameId"><?php if(array_key_exists('txtUserFName', $form_array)) echo $form_array['txtUserFName'];?></span></td>
                </tr>
                <tr>
                    <td width="155" align="right" valign="middle"><?php echo tranText('last_name'); ?></td>
                    <td width="235" valign="middle"><span class="RegFormRight"><input name="txtUserLName" type="text" class="RegFormFldowner" id="txtUserLNameId" value="<?php if(isset($_POST['txtUserLName'])){echo $_POST['txtUserLName'];}else{echo $userInfoArr['user_lname'];}?>" onkeydown="chkblnkTxtError('txtUserLNameId', 'showErrorUserLNameId');" onkeyup="chkblnkTxtError('txtUserLNameId', 'showErrorUserLNameId');" /></span></td>
                    <td width="274" valign="top"><span class="pdError1" id="showErrorUserLNameId"><?php if(array_key_exists('txtUserLName', $form_array)) echo $form_array['txtUserLName'];?></span></td>
                </tr>
                <tr>
                    <td width="155" align="right" valign="middle"><?php echo tranText('email_address'); ?></td>
                    <td width="235" valign="middle"><span class="RegFormRight"><input name="txtUserEmail" type="text" class="RegFormFldowner" id="txtUserEmailId" value="<?php if(isset($_POST['txtUserEmail'])){echo $_POST['txtUserEmail'];}else{echo $userInfoArr['user_email'];}?>" /></span></td>
                    <td width="274" valign="top"><span class="pdError1" id="showErrorUserEmailId"><?php if(array_key_exists('txtUserEmail', $form_array)) echo $form_array['txtUserEmail'];?></span></td>
                </tr>
                <tr>
                    <td colspan="5" valign="top" style="padding:8px;">
                        <div id="showchangepassLinkId" style="display:block;">
                            <table width="690" border="0" cellspacing="0" cellpadding="5">
                                <tr>
                                    <td width="152" align="right" valign="middle"><?php echo tranText('password'); ?></td>
                                    <td width="235" valign="middle"><input name="txtUserPasswrd" type="password" class="RegFormFldowner" id="txtUserPasswrdId" value="*******" /></td>
                                    <td width="274" valign="top"><div id="showchangepassLinkId1" align="left"><a href="javascript:showChangePassword(1);" class="blue-link"><?php echo tranText('change_password'); ?></a></div></td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" valign="top" style="padding:0px;">
                        <div id="showchangepassId" style="display:none; padding-top:5px; padding-bottom:5px; padding-left:0px; background:#f7f7f7;">
                            <table width="690" border="0" cellspacing="0" cellpadding="5">
                                <tr>
                                    <td width="145" align="right" valign="middle"><?php echo tranText('current_password'); ?></td>
                                    <td width="245" valign="top"><input name="txtOldPassword" id="txtOldPasswordId" type="password" class="RegFormFldowner" value="" onkeydown="chkblnkTxtError('txtOldPasswordId', 'showErrorOldPassword');" onkeyup="chkblnkTxtError('txtOldPasswordId', 'showErrorOldPassword');" /></td>
                                    <td width="274" valign="top">
                                        <span class="pdError1" id="showErrorOldPassword">&nbsp;</span>                                
                                    </td>
                                </tr>
                                <tr>
                                    <td  width="145" align="right" valign="middle"><?php echo tranText('new_password'); ?></td>
                                    <td  width="245" valign="top"><input name="txtNewPassword" id="txtNewPasswordId" type="password" class="RegFormFldowner" value="" onkeydown="chkblnkTxtError('txtNewPasswordId', 'showErrorNewPassword');" onkeyup="chkblnkTxtError('txtNewPasswordId', 'showErrorNewPassword');" /></td>
                                    <td valign="top">
                                        <span class="pdError1" id="showErrorNewPassword">&nbsp;</span>                                
                                    </td>
                                </tr>
                                <tr>
                                    <td width="145" align="right" valign="middle"><?php echo tranText('repeat_new_password'); ?></td>
                                    <td width="245" valign="top"><input name="txtConfirmPassword" id="txtConfirmPasswordId" type="password" class="RegFormFldowner" value="" onkeydown="chkblnkTxtError('txtConfirmPasswordId', 'showErrorConfirmPassword');" onkeyup="chkblnkTxtError('txtConfirmPasswordId', 'showErrorConfirmPassword');" /></td>
                                    <td valign="top">
                                        <span class="pdError1" id="showErrorConfirmPassword">&nbsp;</span>                                
                                    </td>
                                </tr>
                                <tr>
                                    <td width="145" align="right" valign="middle">&nbsp;</td>
                                    <td colspan="2" valign="top">
                                        <a href="javascript:showChangePassword(0);"><img src="<?php echo SITE_IMAGES;?>cancel-gray.gif" alt="Cancel" width="81" height="27" /></a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="return changePassword(0);"><img src="<?php echo SITE_IMAGES;?>submit.gif" alt="Change Password" width="81" height="27" /></a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
                <!-- Owner Field: Start Here -->
                <tr>
                    <td width="155" align="right" valign="middle"><?php echo tranText('birthdate'); ?></td>
                    <td width="235" valign="middle">
                        <span class="RegFormRight">
                            <select name="txtDOBDay" id="txtDOBDayId" class="RegFormBDate">
                                <option value=""> - - </option>
                                <?
                                foreach($dayname as $key => $value) {
                                ?>
                                    <option value="<?php echo $value;?>" <?php if(isset($_POST['txtDOBDay']) && ($value == $_POST['txtDOBDay'])){echo "selected";} elseif(isset($txtDOBDay) && ($value == $txtDOBDay)){echo "selected";} else{echo "";}?>><?php echo ($key+1)?></option>
                                <?
                                }
                                ?>
                            </select>										
                            <select name="txtDOBMonth" id="txtDOBMonthId" class="RegFormBMonth">
                                <option value=""> - - </option>
                                <?
                                foreach ($monthname as $key => $value) {
                                ?>
                                    <option value="<?php echo $key?>" <?php if(isset($_POST['txtDOBMonth']) && ($key == $_POST['txtDOBMonth'])){echo "selected";} elseif(isset($txtDOBMonth) && ($key==$txtDOBMonth)){echo "selected";} else{echo "";}?>><?php echo $value;?></option>
                                <?
                                }
                                ?>
                            </select>
                            <select name="txtDOBYear" id="txtDOBYearId" class="RegFormBYear">
                                <option value=""> - - </option>
                                <?
                                foreach ($yearname as $value) {
                                ?>
                                    <option value="<?php echo $value;?>" <?php if(isset($_POST['txtDOBYear']) && ($value == $_POST['txtDOBYear'])){echo "selected";} elseif(isset($txtDOBYear) && ($value==$txtDOBYear)){echo "selected";} else{echo "";}?>><?php echo $value;?></option>
                                <?
                                }
                                ?>
                            </select>
                        </span>
                    </td>
                    <td width="274" valign="top">
                        <span class="pdError1" id="showErrorDOB">
                            <?php 
                            if(array_key_exists('txtDOBDay', $form_array)) { 
                                echo $form_array['txtDOBDay'];
                            } else if(array_key_exists('txtDOBMonth', $form_array)) {
                                echo $form_array['txtDOBMonth'];
                            } else if(array_key_exists('txtDOBYear', $form_array)) {
                                echo $form_array['txtDOBYear'];
                            }
                            ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td width="155" align="right" valign="middle"><?php echo tranText('country_of_residence'); ?></td>
                    <td width="235" valign="middle">
                        <select name="txtRCountry" class="select230">
                            <option value="" style="font-style:normal; background-color:#D0E0F1;COLOR:#000000" disabled="disabled" selected="selected"><?php echo tranText('select_country'); ?>... </option>
                            <?php 
                            $strPopularCountry = " WHERE countries_name IN ('United States', 'United Kingdom') ORDER BY countries_name IN ('United States', 'United Kingdom')";
                            $locationObj->fun_getCountriesOptionsList('', $strPopularCountry);
                            if(isset($_POST['txtRCountry'])){
                                $rcountry_id = $_POST['txtRCountry'];
                            } else if(isset($userInfoArr['user_rcountry']) && $userInfoArr['user_rcountry'] != ""){
                                $rcountry_id = $userInfoArr['user_rcountry'];
                            }
                            $locationObj->fun_getCountriesOptionsList($rcountry_id);
                            ?>
                        </select>                    
                    </td>
                    <td width="274" valign="top">
                        <span class="pdError1" id="showErrorRCountry">
                            <?php 
                            if(array_key_exists('txtRCountry', $form_array)) { 
                                echo $form_array['txtRCountry'];
                            }
                            ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td width="155" align="right" valign="top"><?php echo tranText('contact_numbers'); ?></td>
                    <td colspan="2" valign="top" class="pad-btm10">
                        <table border="0" cellspacing="0" cellpadding="0">
                            <?php
                            if (count($userContactInfoArr) > 0) {
                                for($j = 0; $j < count($userContactInfoArr); $j++){
                                    $contact_numberId 			= $userContactInfoArr[$j]['id'];
                                    $contact_number_typeid 		= $userContactInfoArr[$j]['contact_number_typeid'];
                                    $contact_number_countryid 	= $userContactInfoArr[$j]['contact_number_countryid'];
                                    $contact_number 			= $userContactInfoArr[$j]['contact_number'];
                                    $contact_number_show 		= $userContactInfoArr[$j]['contact_number_show'];
                                    $recordid = "addanothernumberId".$j;
                                ?>
                                <tr>
                                    <td colspan="4">
                                        <table border="0" cellspacing="0" cellpadding="0" id="<?php echo $recordid;?>" style="display:block;">
                                            <tr height="5px"><td colspan="4"></td></tr>
                                            <tr>
                                                <td class="pad-rgt10">
                                                    <select name="txtContactNumberType[]" id="txtContactNumberTypeId<?php echo $j;?>" class="NumberType">
                                                        <?php 
                                                        $usersObj->fun_getUserContactNoTypeOptionsList($contact_number_typeid);
                                                        ?>
                                                    </select>
                                                </td>
                                                <td class="pad-rgt10">
                                                    <select name="txtContactCountry[]" id="txtContactCountryId<?php echo $j;?>" class="select128">
                                                        <option value="" style="font-style:normal; background-color:#D0E0F1;COLOR:#000000" disabled="disabled" selected="selected"><?php echo tranText('select_country'); ?> ... </option>
                                                        <?php 
                                                        $strPopularCountry = " WHERE countries_name IN ('United States', 'United Kingdom') ORDER BY countries_name IN ('United States', 'United Kingdom')";
                                                        $locationObj->fun_getCountriesISDOptionsList('', $strPopularCountry);
                                                        ?>
                                                        <option value="" style="font-style:normal; background-color:#D0E0F1;COLOR:#000000" disabled="disabled"> ---------------------------------------------- </option>
                                                        <?php 
                                                        $locationObj->fun_getCountriesISDOptionsList($contact_number_countryid);
                                                        ?>
                                                    </select>
                                                </td>
                                                <td class="pad-rgt10" valign="middle"><input type="text" name="txtContactNumber[]" id="txtContactNumberId<?php echo $j;?>" class="ContactNumber" maxlength="15" value="<?php echo $contact_number; ?>"/></td>
                                                <td class="pad-top1"><a href="javascript:delOwnrContactNumber('<?php echo $j;?>');" class="delete-photo"><font color=blue><?php echo tranText('delete'); ?></font></a></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <?php
                                }
                            } else {
                            ?>
                            <tr>
                                <td colspan="4">
                                    <table border="0" cellspacing="0" cellpadding="0" id="addanothernumberId0" style="display:block;">
                                        <tr>
                                            <td class="pad-rgt10">
                                                <select name="txtContactNumberType[]" class="NumberType">
                                                    <option value=""><?php echo tranText('select_type'); ?></option>
                                                    <?php 
                                                    $usersObj->fun_getUserContactNoTypeOptionsList($_POST['txtContactNumberType'][0]);
                                                    ?>
                                                </select>                                            
                                            </td>
                                            <td class="pad-rgt10">
                                                <select name="txtContactCountry[]" id="txtContactCountryId" class="select128">
                                                    <option value="" style="font-style:normal; background-color:#D0E0F1;COLOR:#000000" disabled="disabled" selected="selected"><?php echo tranText('select_country'); ?>.. </option>
                                                    <?php 
                                                    $strPopularCountry = " WHERE countries_name IN ('United States', 'United Kingdom') ORDER BY countries_name IN ('United States', 'United Kingdom')";
                                                    $locationObj->fun_getCountriesISDOptionsList('', $strPopularCountry);
                                                    ?>
                                                    <option value="" style="font-style:normal; background-color:#D0E0F1;COLOR:#000000" disabled="disabled"> ---------------------------------------------- </option>
                                                    <?php 
                                                    $locationObj->fun_getCountriesISDOptionsList($_POST['txtContactCountry'][0]);
                                                    ?>
                                                </select>                                            
                                            </td>
                                            <td class="pad-rgt10"><input type="text" name="txtContactNumber[]" class="ContactNumber" maxlength="15" value="<?php if(isset($_POST['txtContactNumber'][0]) && $_POST['txtContactNumber'][0] !="") {echo $_POST['txtContactNumber'][0];}?>" /></td>
                                            <td class="pad-top2">&nbsp;</td>
                                        </tr>
                                    </table>                                
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                            <tr>
                                <td valign="top">
                                <input type="hidden" value="0" id="theValue" />
                                <div id="myDiv"></div>
                                </td>
                            </tr>
                            <tr><td colspan="4" class="pad-top10"><a  href="javascript:void(0);" onclick="addEvent();" class="add-contact"><?php echo tranText('add_another_number'); ?></a></td></tr>
                        </table>                    
                    </td>
                </tr>
                <tr>
                    <td width="155" align="right" valign="top"><?php echo tranText('languages_spoken'); ?></td>
                    <td colspan="2" valign="top" class="pad-btm15">
                        <table border="0" cellspacing="0" cellpadding="0">
                           <?php
                            for($i = 0; $i < count($userLanguageInfoArr); $i++){
                            $contactLanguageId 	= $userLanguageInfoArr[$i]['id'];
                            $language_id 		= $userLanguageInfoArr[$i]['language_id'];
                            $language_show 		= $userLanguageInfoArr[$i]['language_show'];
                            $recordid = "addanotherlanguageId".$i;
                            ?>
                            <tr>
                                <td colspan="2">
                                    <table border="0" cellspacing="0" cellpadding="0" id="<?php echo $recordid;?>" style="display:block;">
                                        <tr><td height="5" ></td></tr>
                                        <tr>
                                            <td class="pad-rgt10">
                                            <select name="txtContactLanguage[]" id="txtContactLanguageId<?php echo $i;?>" class="select230">
                                            <option value="">Select Language ...</option>
                                                <?php 
                                                    $usersObj->fun_getLanguagesOptionsList($language_id);
                                                ?>
                                            </select>
                                            </td>
                                            <td valign="middle" class="pad-top1"><a href="javascript:delOwnrContactLanguage('<?php echo $i;?>');" class="delete-photo"><?php echo tranText('delete'); ?></a></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                            <tr>
                                <td colspan="2">
                                    <table border="0" cellspacing="0" cellpadding="0" id="addanotherlanguageId_0" style="display:<?php if(isset($userLanguageInfoArr) && count($userLanguageInfoArr) > 0) {echo "none";}else {echo "block";}?>;">
                                        <tr>
                                            <td class="pad-rgt10">
                                                <select name="txtContactLanguage[]" class="select230">
                                                    <option value=""><?php echo tranText('select_language'); ?>...</option>
                                                    <?php 
                                                    $usersObj->fun_getLanguagesOptionsList($_POST['txtContactLanguage'][0]);
                                                    ?>
                                                </select>
                                            </td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="hidden" value="0" id="theValue" />
                                    <div id="myDiv1"></div>
                                </td>
                            </tr>
                            <tr><td colspan="2" class="pad-top10"><a href="javascript:;" onclick="addEvent1();" class="add-language"><?php echo tranText('add_another_language'); ?></a></td></tr>
                        </table>                    
                    </td>
                </tr>
                <tr>
                    <td width="155" align="right" valign="middle"><?php echo tranText('contact_address'); ?></td>
                    <td width="235" valign="middle"><span class="RegFormRight"><input name="txtAddress1" type="text" class="RegFormFldowner" id="txtAddressId1" value="<?php if(isset($_POST['txtAddress1']) && $_POST['txtAddress1'] !=""){echo $_POST['txtAddress1'];}else{echo $userInfoArr['user_address1'];}?>" /></span></td>
                    <td width="274" valign="top"><span class="pdError1" id="showErrorAddress1"><?php if(array_key_exists('txtAddress1', $form_array)) echo $form_array['txtAddress1'];?></span></td>
                </tr>
                <tr>
                    <td width="155" align="right" valign="middle">&nbsp;</td>
                    <td width="235" valign="middle"><span class="RegFormRight"><input name="txtAddress2" type="text" class="RegFormFldowner" id="txtAddressId2" value="<?php if(isset($_POST['txtAddress2']) && $_POST['txtAddress2'] !=""){echo $_POST['txtAddress2'];}else{echo $userInfoArr['user_address2'];}?>" /></span></td>
                    <td width="274" valign="top"><span class="pdError1" id="showErrorAddress1"><?php if(array_key_exists('txtAddress2', $form_array)) echo $form_array['txtAddress2'];?></span></td>
                </tr>
                <tr>
                    <td width="155" align="right" valign="middle"><?php echo tranText('town_city'); ?></td>
                    <td width="235" valign="middle"><span class="RegFormRight"><input name="txtTown" type="text" class="RegFormFldowner" id="txtTownId" value="<?php if(isset($_POST['txtTown']) && $_POST['txtTown'] !=""){echo $_POST['txtTown'];}else{echo $userInfoArr['user_town'];}?>" /></span></td>
                    <td width="274" valign="top"><span class="pdError1" id="showErrorTown"><?php if(array_key_exists('txtTown', $form_array)) echo $form_array['txtTown'];?></span></td>
                </tr>
                <tr>
                    <td width="155" align="right" valign="middle"><?php echo tranText('county_state_province'); ?></td>
                    <td width="235" valign="middle"><span class="RegFormRight"><input name="txtState" type="text" class="RegFormFldowner" id="txtStateId" value="<?php if(isset($_POST['txtState']) && $_POST['txtState'] !=""){echo $_POST['txtState'];}else{echo $userInfoArr['user_state'];}?>" /></span></td>
                    <td width="274" valign="top"><span class="pdError1" id="showErrorState"><?php if(array_key_exists('txtState', $form_array)) echo $form_array['txtState'];?></span></td>
                </tr>
                <tr>
                    <td width="155" align="right" valign="middle"><?php echo tranText('postcode_zip'); ?></td>
                    <td width="235" valign="middle"><span class="RegFormRight"><input name="txtZip" type="text" class="RegFormFldowner" id="txtZipId" value="<?php if(isset($_POST['txtZip']) && $_POST['txtZip'] !=""){echo $_POST['txtZip'];}else{echo $userInfoArr['user_zip'];}?>" /></span></td>
                    <td width="274" valign="top"><span class="pdError1" id="showErrorState"><?php if(array_key_exists('txtZip', $form_array)) echo $form_array['txtZip'];?></span></td>
                </tr>
                <tr>
                    <td width="155" align="right" valign="middle"><?php echo tranText('country'); ?></td>
                    <td width="235" valign="middle">
                        <span class="RegFormRight">
                        <select name="txtCountry" class="select230">
                            <option value="" style="font-style:normal; background-color:#D0E0F1;COLOR:#000000" disabled="disabled" selected="selected"><?php echo tranText('select_country'); ?>...</option>
                            <?php 
                            $strPopularCountry = " WHERE countries_name IN ('United States', 'United Kingdom') ORDER BY countries_name IN ('United States', 'United Kingdom')";
                            $locationObj->fun_getCountriesOptionsList('', $strPopularCountry);
							if(isset($_POST['txtCountry']) && $_POST['txtCountry'] !=""){
								$country_id = $_POST['txtCountry'];
							}else{
								$country_id = $userInfoArr['user_rcountry'];
							}
                            $locationObj->fun_getCountriesOptionsList($country_id);
                            ?>
                        </select>                    
                        </span>
                    </td>
                    <td width="274" valign="top"><span class="pdError1" id="showErrorCountry"><?php if(array_key_exists('txtCountry', $form_array)) echo $form_array['txtCountry'];?></span></td>
                </tr>
                <!-- Owner Field: End Here -->
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
                <tr><td colspan="3" align="left" valign="top" class="dash25">&nbsp;</td></tr>
                <?php /*?>
				<tr><td colspan="3" align="left" valign="top" class="pad-top5"><strong>SMS Notifications</strong></td></tr>
                <tr>
                    <td width="155" align="right" valign="middle">&nbsp;</td>
                    <td colspan="2" valign="middle">
                        <?php
                        $whereUserSMSSettingList = array();
                        array_push($whereUserSMSSettingList, "A.setting_id IN (4)");
                        $user_sms_setting_arr = $userSettingObj->fun_getUserSettingList($whereUserSMSSettingList);
                        // Set user setting checked here
                        $UserSMSSettings = array();
                        // Defalut settings
                        if(isset($_POST['txtPropertySMS']) && ($_POST['txtPropertySMS'] != "")){
                            $strSMSSettings = $_POST['txtPropertySMS'];
                            for($k = 0; $k < count($strSMSSettings); $k++){
                                array_push($UserSMSSettings, $strSMSSettings[$k]);
                            }
                        } else{
                            if(isset($userSettingInfoArr) && is_array($userSettingInfoArr)){
                                foreach($userSettingInfoArr as $value){
                                    array_push($UserSMSSettings, $value['setting_id']);
                                }
                            }
                        }
                        if(isset($user_sms_setting_arr) && is_array($user_sms_setting_arr)){
                        ?>
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="19" class="pad-btm10 pad-top3"><input type="checkbox" name="txtPropertySMS" id="txtPropertySMSId" class="checkbox" value="<?php echo $user_sms_setting_arr[0]['setting_id'];?>" <?php if(in_array($user_sms_setting_arr[0]['setting_id'], $UserSMSSettings)){echo "checked";}else{echo "";}?> onclick="return chkShowSMS();" /></td>
                                    <td width="130" align="left" valign="top"><?php echo $user_sms_setting_arr[0]['setting_name'];?></td>
                                    <td width="150" valign="top"><span class="pdError1" id="showErrorSMS"><?php if(array_key_exists('txtSMS', $form_array)) echo $form_array['txtSMS']; else "&nbsp;"; ?></span></td>
                                </tr>
                            </table>
                            <div id="showSMSID" style="display:<?php if(in_array($user_sms_setting_arr[0]['setting_id'], $UserSMSSettings)){echo "block";}else{echo "none";}?>;">
                                <p>Send alerts to</p>
                                <p class="FloatLft">
                                    <select name="txtPropertySMSCountry" id="txtPropertySMSCountryId" class="select200_15">
                                        <?php
                                        $locationObj->fun_getCountriesISDOptionsList($sms_number_countryid);
                                        ?>
                                    </select>										
                                </p>
                                <p class="FloatLft pad-lft5" style="display:none;">
                                <select name="txtPropertySMSCompany" id="txtPropertySMSCompanyId" class="select80">
                                    <option value="Airtel" <?php if($sms_number_company == "Airtel"){echo "selected";} else{echo "";}?>>Airtel</option>
                                    <option value="Vodafone" <?php if($sms_number_company == "Vodafone"){echo "selected";} else{echo "";}?>>Vodafone</option>
                                </select>
                                </p>
                                <p class="FloatLft pad-lft5">
                                <input name="txtPropertySMSNumber" id="txtPropertySMSNumberId" type="text" class="ContactNumber_1" value="<?php echo $sms_number; ?>" />
                                </p>
                                <p class="FloatLft pad-lft5">
                                <a href="javascript:validateSMSNumber();" style="text-decoration:none;"><img src="images/TestNumber-Normal.gif" alt="Test Number" name="TestNumber" id="TestNumber" width="88" height="21" border="0" /></a>
                                </p>
                            </div>
                        <?php
                        }
                        ?>
                    </td>
                </tr>
				<?php */?>
                <tr>
                    <td align="right" valign="middle">&nbsp;</td>
                    <td colspan="2" valign="middle">
                         <a href="#" onclick="cancelChangeProfile(); void(0);" class="button-grey">Cancel</a>&nbsp;<a href="javascript:void(0);" onclick="return validateSaveProfile();" class="button-blue">Submit</a>
                    </td>
                </tr>
            </table>
            </form>
        </td>
    </tr>
</table>