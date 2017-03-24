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
<table width="690" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr>
        <td align="left" valign="top" class="pad-top10">
            To add your property we just need a few more details in order to register you as an owner
        </td>
    </tr>
    <tr>
        <td align="left" valign="top">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                <tr>
                    <td align="left" valign="bottom">
                        <form name="frmUserProfile" method="post" action="<?php echo SITE_URL."holiday-register-as-owner";?>">
                        <input type="hidden" name="securityKey" value="<?php echo md5(USEROWNERPROFILE);?>" />
                        <input type="hidden" name="txtUserId" id="txtUserId" value="<?php echo $user_id;?>" />
                        <input type="hidden" name="txtIsOwner" id="txtIsOwnerId" value="1" />
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
                                <td width="155" align="right" valign="middle">Password</td>
                                <td width="235" valign="middle"><span class="RegFormRight"><input name="txtUserPasswrd" type="password" class="RegFormFld" id="txtUserPasswrdId" value="<?php echo $_POST['txtUserPasswrd']; ?>" /></span></td>
                                <td width="274" valign="top"><span class="pdError1" id="showErrorPassword"><?php if(array_key_exists('txtUserPasswrd', $form_array)) echo $form_array['txtUserPasswrd'];?></span></td>
                            </tr>
                            <tr>
                                <td width="155" align="right" valign="middle">Confirm password</td>
                                <td width="235" valign="middle"><span class="RegFormRight"><input name="txtConfirmPassword" type="password" class="RegFormFld" id="txtConfirmPasswordId" value="<?php echo $_POST['txtConfirmPassword']; ?>" /></span></td>
                                <td width="274" valign="top"><span class="pdError1" id="showErrorConfirmPassword"><?php if(array_key_exists('txtConfirmPassword', $form_array)) echo $form_array['txtConfirmPassword'];?></span></td>
                            </tr>
                            <tr>
                                <td width="155" align="right" valign="middle">Birthdate</td>
                                <td width="235" valign="middle">
                                    <span class="RegFormRight">
                                        <select name="txtDOBDay" id="txtDOBDayId" class="RegFormBDate">
                                            <option value=""> - - </option>
                                            <?
                                            foreach($dayname as $key => $value) {
                                            ?>
                                                <option value="<?php echo $value;?>" <? if(isset($txtDOBDay) && ($value == $txtDOBDay)){echo "selected";} else{echo "";}?>><?php echo ($key+1)?></option>
                                            <?
                                            }
                                            ?>
                                        </select>										
                                        <select name="txtDOBMonth" id="txtDOBMonthId" class="RegFormBMonth">
                                            <option value=""> - - </option>
                                            <?
                                            foreach ($monthname as $key => $value) {
                                            ?>
                                                <option value="<?php echo $key?>" <? if(isset($txtDOBMonth) && ($key==$txtDOBMonth)){echo "selected";} else{echo "";}?>><?php echo $value;?></option>
                                            <?
                                            }
                                            ?>
                                        </select>
                                        <select name="txtDOBYear" id="txtDOBYearId" class="RegFormBYear">
                                            <option value=""> - - </option>
                                            <?
                                            foreach ($yearname as $value) {
                                            ?>
                                                <option value="<?php echo $value;?>" <? if(isset($txtDOBYear) && ($value==$txtDOBYear)){echo "selected";} else{echo "";}?>><?php echo $value;?></option>
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
                                <td width="155" align="right" valign="middle">Country of residence</td>
                                <td width="235" valign="middle">
                                    <span class="RegFormRight">
                                        <select name="txtRCountry" class="select230">
                                            <option value="" style="font-style:normal; background-color:#D0E0F1;COLOR:#000000" disabled="disabled" selected="selected">Select country ... </option>
                                            <?php 
                                            $strPopularCountry = " WHERE countries_name IN ('United States', 'United Kingdom') ORDER BY countries_name IN ('United States', 'United Kingdom')";
                                            $locationObj->fun_getCountriesOptionsList('', $strPopularCountry);
                                            if(isset($_POST['txtRCountry'])){
                                                $rcountry_id = $_POST['txtRCountry'];
                                            } else if(isset($txtRCountry) && $txtRCountry != ""){
                                                $rcountry_id = $txtRCountry;
                                            }
                                            $locationObj->fun_getCountriesOptionsList($rcountry_id);
                                            ?>
                                        </select>                    
                                    </span>
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
                                <td width="155" align="right" valign="top">Contact numbers</td>
                                <td colspan="2" valign="middle">
                                    <table border="0" cellspacing="0" cellpadding="0">
                                    <?php
                                    if (count($userContactInfoArr) > 0) {
                                        for($j = 0; $j < count($userContactInfoArr); $j++){
                                        $$contact_numberId 			= $userContactInfoArr[$j]['id'];
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
                                                            <select name="txtContactNumberType[]" id="txtContactNumberTypeId<?php echo $j;?>" class="select94">
                                                                <?php 
                                                                $usersObj->fun_getUserContactNoTypeOptionsList($contact_number_typeid);
                                                                ?>
                                                            </select>                                            
                                                        </td>
                                                        <td class="pad-rgt10">
                                                            <select name="txtContactCountry[]" id="txtContactCountryId<?php echo $j;?>" class="select128">
                                                                <option value="" style="font-style:normal; background-color:#D0E0F1;COLOR:#000000" disabled="disabled" selected="selected">Select country ... </option>
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
                                                        <td class="pad-rgt10" valign="middle"><input type="text" name="txtContactNumber[]" id="txtContactNumberId<?php echo $j;?>" class="txtBox100" maxlength="15" value="<?php echo $contact_number; ?>"/></td>
                                                        <td class="pad-top1"><a href="javascript:delOwnrContactNumber('<?php echo $j;?>');" class="delete-contact">Delete</a></td>
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
                                                            <select name="txtContactNumberType[]" class="select94">
                                                                <option value="">Select Type</option>
                                                                <?php 
                                                                $usersObj->fun_getUserContactNoTypeOptionsList();
                                                                ?>
                                                            </select>                                            
                                                        </td>
                                                        <td class="pad-rgt10">
                                                            <select name="txtContactCountry[]" id="txtContactCountryId" class="select128">
                                                                <option value="" style="font-style:normal; background-color:#D0E0F1;COLOR:#000000" disabled="disabled" selected="selected">Select country... </option>
                                                                <?php 
                                                                $strPopularCountry = " WHERE countries_name IN ('United States', 'United Kingdom') ORDER BY countries_name IN ('United States', 'United Kingdom')";
                                                                $locationObj->fun_getCountriesISDOptionsList('', $strPopularCountry);
                                                                ?>
                                                                <option value="" style="font-style:normal; background-color:#D0E0F1;COLOR:#000000" disabled="disabled"> ---------------------------------------------- </option>
                                                                <?php 
                                                                $locationObj->fun_getCountriesISDOptionsList();
                                                                ?>
                                                            </select>                                            
                                                        </td>
                                                        <td class="pad-rgt10"><input type="text" name="txtContactNumber[]" class="txtBox160" value="Enter Number" maxlength="15" /></td>
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
                                        <tr><td colspan="4" class="pad-top10"><a  href="javascript:void(0);" onclick="addEvent();" class="add-contact">Add another number</a></td></tr>
                                    </table>                    
                                </td>
                            </tr>
                            <tr>
                                <td width="155" align="right" valign="top">Languages spoken</td>
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
                                                        <td valign="middle" class="pad-top1"><a href="javascript:delOwnrContactLanguage('<?php echo $i;?>');" class="delete-contact">Delete</a></td>
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
                                                                <option value="">Select Language ...</option>
                                                                <?php 
                                                                $usersObj->fun_getLanguagesOptionsList();
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
                                        <tr><td colspan="2" class="pad-top10"><a href="javascript:;" onclick="addEvent1();" class="add-language">Add another language</a></td></tr>
                                    </table>                    
                                </td>
                            </tr>
                            <tr>
                                <td width="155" align="right" valign="middle">Contact address</td>
                                <td width="235" valign="middle"><span class="RegFormRight"><input name="txtAddress1" type="text" class="RegFormFld" id="txtAddressId1" value="<?php echo $txtAddress1;?>" /></span></td>
                                <td width="274" valign="top"><span class="pdError1" id="showErrorAddress1"><?php if(array_key_exists('txtAddress1', $form_array)) echo $form_array['txtAddress1'];?></span></td>
                            </tr>
                            <tr>
                                <td width="155" align="right" valign="middle">&nbsp;</td>
                                <td width="235" valign="middle"><span class="RegFormRight"><input name="txtAddress2" type="text" class="RegFormFld" id="txtAddressId2" value="<?php echo $txtAddress2;?>" /></span></td>
                                <td width="274" valign="top"><span class="pdError1" id="showErrorAddress1"><?php if(array_key_exists('txtAddress2', $form_array)) echo $form_array['txtAddress2'];?></span></td>
                            </tr>
                            <tr>
                                <td width="155" align="right" valign="middle">Town / City</td>
                                <td width="235" valign="middle"><span class="RegFormRight"><input name="txtTown" type="text" class="RegFormFld" id="txtTownId" value="<?php echo $txtTown;?>" /></span></td>
                                <td width="274" valign="top"><span class="pdError1" id="showErrorTown"><?php if(array_key_exists('txtTown', $form_array)) echo $form_array['txtTown'];?></span></td>
                            </tr>
                            <tr>
                                <td width="155" align="right" valign="middle">County / State / Province</td>
                                <td width="235" valign="middle"><span class="RegFormRight"><input name="txtState" type="text" class="RegFormFld" id="txtStateId" value="<?php echo $txtState;?>" /></span></td>
                                <td width="274" valign="top"><span class="pdError1" id="showErrorState"><?php if(array_key_exists('txtState', $form_array)) echo $form_array['txtState'];?></span></td>
                            </tr>
                            <tr>
                                <td width="155" align="right" valign="middle">Postcode / ZIP</td>
                                <td width="235" valign="middle"><span class="RegFormRight"><input name="txtZip" type="text" class="RegFormFld" id="txtZipId" value="<?php echo $txtZip;?>" /></span></td>
                                <td width="274" valign="top"><span class="pdError1" id="showErrorState"><?php if(array_key_exists('txtZip', $form_array)) echo $form_array['txtZip'];?></span></td>
                            </tr>
                            <tr>
                                <td width="155" align="right" valign="middle">Country</td>
                                <td width="235" valign="middle">
                                    <span class="RegFormRight">
                                    <select name="txtCountry" class="select230">
                                        <option value="" style="font-style:normal; background-color:#D0E0F1;COLOR:#000000" disabled="disabled" selected="selected">Select country...</option>
                                        <?php 
                                        $strPopularCountry = " WHERE countries_name IN ('United States', 'United Kingdom') ORDER BY countries_name IN ('United States', 'United Kingdom')";
                                        $locationObj->fun_getCountriesOptionsList('', $strPopularCountry);
                                        $locationObj->fun_getCountriesOptionsList($txtCountry);
                                        ?>
                                    </select>                    
                                    </span>
                                </td>
                                <td width="274" valign="top"><span class="pdError1" id="showErrorCountry"><?php if(array_key_exists('txtCountry', $form_array)) echo $form_array['txtCountry'];?></span></td>
                            </tr>
                            <tr>
                                <td colspan="3" style="padding:0px;">
                                    <table border="0" cellpadding="5" cellspacing="0">
                                        <tr>
                                            <td width="155" align="right" valign="middle">Type this</td>
                                            <td align="left" valign="middle" class="pad-lr"><img src="captchacode/securityimage.php?width=120&height=40&characters=5" alt="Word Scramble" class="RegFormScrambleImg" id="image_scode" name="image_scode" /></td>
                                            <td align="left" valign="middle" class="pad-lft5">into this box</td>
                                            <td align="left" valign="middle" class="pad-lft5"><input name="image_vcode" id="image_vcode" type="text" class="txtBox100" value="" maxlength="5" autocomplete="off" /></td>
                                            <td align="left" valign="middle"><span class="pdError1" id="showErrorImgVCode"><?php if(array_key_exists('image_vcode', $form_array)) echo $form_array['image_vcode'];?></span></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td align="left" class="RegFormScrambleLink" style="padding-top:3px;"><a href="void(0);" onclick="document.image_scode.src='captchacode/securityimage.php?width=120&height=40&characters=5&'+Math.random();return false">Refresh this image</a></td>
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
                                    echo "<tr>";
                                    echo "<td colspan=\"2\">By clicking Register you agree to the <a href=\"javascript:popcontact('terms.html')\" class=\"blue-link\">terms and conditions</a></td>";
                                    echo "</tr>";
                                    echo "</table>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            ?>
                            <tr><td colspan="3" align="right" valign="middle" class="dash25">&nbsp;</td></tr>
                            <tr>
                                <td align="right" valign="middle">&nbsp;</td>
                                <td colspan="2" valign="middle"><a href="javascript:cancelRegisterAsOwner();"><img src="<?php echo SITE_IMAGES;?>cancel-gray.gif" alt="Cancel" width="81" height="27" /></a>&nbsp;&nbsp;<input type="image" src="<?php echo SITE_IMAGES;?>register.gif" alt="Register" name="Register" width="81" height="27" border="0" id="RegisterId" onclick="return validateSaveProfile();"></td>
                            </tr>
                        </table>
                        </form>
                    </td>
                </tr>
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
        </td>
    </tr>
</table>