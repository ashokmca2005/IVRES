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
<h2 class="font16-darkgrey">Register</h2>
<form name="frmUserProfile" method="post" action="owner-login">
<input type="hidden" name="securityKey" value="<?php echo md5(NEWREGISTRATION);?>" />
<input type="hidden" name="txtUserIP" value="<?php echo $_SERVER['REMOTE_ADDR']?>" />
<input type="hidden" name="products_id" id="products_id" value="<?php echo $_POST['products_id'];?>" />
<input type="hidden" name="txtIsOwner" id="txtIsOwnerId" value="1" />
<table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr><td valign="center" colspan="2"><strong><a href="<?php echo SITE_URL; ?>login" class="blue-link">Sign in</a> to use your existing Traveler details</strong></td></tr>
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
        <input name="txtUserPasswrd" type="password" class="RegFormFld" id="txtUserPasswrdId" value="<?php if(isset($_POST['txtUserPasswrd']) && $_POST['txtUserPasswrd']!=""){echo $_POST['txtUserPasswrd'];}?>" />
        </td>
        <td valign="top"><span class="error" id="showErrorPassword"><?php if(array_key_exists('txtUserPasswrd', $form_array)) echo $form_array['txtUserPasswrd'];?></span></td>
    </tr>
    <tr>
        <td valign="left">
        <?php echo tranText('confirm_password'); ?><span class="compulsory">*</span><br />
        <input name="txtConfirmPassword" type="password" class="RegFormFld" id="txtConfirmPasswordId" value="<?php if(isset($_POST['txtConfirmPassword']) && $_POST['txtConfirmPassword']!=""){echo $_POST['txtConfirmPassword'];}?>" />
        </td>
        <td valign="top"><span class="error" id="showErrorConfirmPassword"><?php if(array_key_exists('txtConfirmPassword', $form_array)) echo $form_array['txtConfirmPassword'];?></span></td>
    </tr>
    <tr>
        <td valign="left">
        <?php echo tranText('birthdate'); ?><span class="compulsory">*</span><br />
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
        </td>
        <td valign="top">
            <span class="error" id="showErrorDOB">
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
        <td valign="left">
        <?php echo tranText('country_of_residence'); ?><span class="compulsory">*</span><br />
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
        </td>
        <td valign="top">
            <span class="error" id="showErrorRCountry">
                <?php 
                if(array_key_exists('txtRCountry', $form_array)) { 
                    echo $form_array['txtRCountry'];
                }
                ?>
            </span>
        </td>
    </tr>
    <tr>
        <td valign="left" colspan="2">
        <?php echo tranText('contact_numbers'); ?><span class="compulsory">*</span><br />
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
                                    $usersObj->fun_getUserContactNoTypeOptionsList($_POST['txtContactNumberType'][0]);
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
                                    $locationObj->fun_getCountriesISDOptionsList($_POST['txtContactCountry'][0]);
                                    ?>
                                </select>                                            
                            </td>
                            <td class="pad-rgt10"><input type="text" name="txtContactNumber[]" id="txtContactNumberId" class="txtBox160" maxlength="15" placeholder="Enter Number" value="<?php if(isset($_POST['txtContactNumber'][0]) && $_POST['txtContactNumber'][0] !="") {echo $_POST['txtContactNumber'][0];}?>" /></td>
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
        <td valign="left" colspan="2">
        <?php echo tranText('languages_spoken'); ?><br />
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
                                    <option value="">Select Language ...</option>
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
        <td valign="left">
        <?php echo tranText('contact_address'); ?><br />
        <input name="txtAddress1" type="text" class="RegFormFld" id="txtAddressId1" value="<?php if(isset($_POST['txtAddress1']) && $_POST['txtAddress1']!=""){echo $_POST['txtAddress1'];}?>" />
        </td>
        <td valign="top"><span class="error" id="showErrorAddress1"><?php if(array_key_exists('txtAddress1', $form_array)) echo $form_array['txtAddress1'];?></span></td>
    </tr>
    <tr>
        <td valign="left">
        <input name="txtAddress2" type="text" class="RegFormFld" id="txtAddressId2" value="<?php if(isset($_POST['txtAddress2']) && $_POST['txtAddress2']!=""){echo $_POST['txtAddress2'];}?>" />
        </td>
        <td valign="top"><span class="error" id="showErrorAddress1"><?php if(array_key_exists('txtAddress2', $form_array)) echo $form_array['txtAddress2'];?></span></td>
    </tr>
    <tr>
        <td valign="left">
        <?php echo tranText('town_city'); ?><br />
        <input name="txtTown" type="text" class="RegFormFld" id="txtTownId" value="<?php if(isset($_POST['txtTown']) && $_POST['txtTown']!=""){echo $_POST['txtTown'];}?>" />
        </td>
        <td valign="top"><span class="error" id="showErrorTown"><?php if(array_key_exists('txtTown', $form_array)) echo $form_array['txtTown'];?></span></td>
    </tr>
    <tr>
        <td valign="left">
        <?php echo tranText('county_state_province'); ?><br />
        <input name="txtState" type="text" class="RegFormFld" id="txtStateId" value="<?php if(isset($_POST['txtState']) && $_POST['txtState']!=""){echo $_POST['txtState'];}?>" />
        </td>
        <td valign="top"><span class="error" id="showErrorState"><?php if(array_key_exists('txtState', $form_array)) echo $form_array['txtState'];?></span></td>
    </tr>
    <tr>
        <td valign="left">
        <?php echo tranText('postcode_zip'); ?><br />
        <input name="txtZip" type="text" class="RegFormFld" id="txtZipId" value="<?php if(isset($_POST['txtZip']) && $_POST['txtZip']!=""){echo $_POST['txtZip'];}?>" />
        </td>
        <td valign="top"><span class="error" id="showErrorState"><?php if(array_key_exists('txtZip', $form_array)) echo $form_array['txtZip'];?></span></td>
    </tr>

    <tr>
        <td valign="left">
        <?php echo tranText('country'); ?><br />
        <select name="txtCountry" class="select230">
            <option value="" style="font-style:normal; background-color:#D0E0F1;COLOR:#000000" disabled="disabled" selected="selected">Select country...</option>
            <?php 
            $strPopularCountry = " WHERE countries_name IN ('United States', 'United Kingdom') ORDER BY countries_name IN ('United States', 'United Kingdom')";
            $locationObj->fun_getCountriesOptionsList('', $strPopularCountry);
            $locationObj->fun_getCountriesOptionsList($_POST['txtCountry']);
            ?>
        </select>                    
        </td>
        <td valign="top"><span class="error" id="showErrorCountry"><?php if(array_key_exists('txtCountry', $form_array)) echo $form_array['txtCountry'];?></span></td>
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