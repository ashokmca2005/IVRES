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
        <td align="left" valign="top">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                	<td align="left" valign="bottom" class="pad-top10">
                    <div id="holidayTxtId" style="display:<?php if(isset($_POST['txtIsOwner']) && $_POST['txtIsOwner'] == "1") { echo "none";} else {echo "block";}?>;">
						<?php echo tranText('by_registering_on_bestbookingsonline_com_you_will_be_able_to'); ?>:<br /><br />
                        <ul style="list-style-type:disc; list-style-position:inside;">
                            <li style="padding-left:15PX;"><?php echo tranText('save_your_favourite_properties_send_them_to_your_friends_so_we_can_credit_you_with_holiday_discount_vouchers'); ?>. .</li>
                            <li style="padding-left:15PX;"><?php echo tranText('send_the_same_enquiry_to_as_many_owners_as_you_like_with_just_one_click_saving_you_time'); ?>.</li>
                            <li style="padding-left:15PX;"><?php echo tranText('be_able_to_see_a_history_of_all_the_enquiries_or_provisional_bookings_you_send_via_the_site'); ?>. </li>
                            <li style="padding-left:15PX;"><?php echo tranText('compare_properties_side_by_side_Its_a_super_user_friendly_way_to_do_a_quick_comparison_of_properties_that_interest_you'); ?>.</li>
                            <li style="padding-left:15PX;"><?php echo tranText('take_part_in_competitions'); ?>.</li>
                        </ul>
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
                        <br />
						<?php echo tranText('and_we_re_adding_super_cool_features_all_the_time_to_make_choosing_your_perfect_holiday_accommodation_worldwide_a_breeze_Subscribe_to_our_newsletter_and_we_ll_send_you_all_the_latest_news_late_deals_and_special_offers_straight_to_your_inbox_that_way_youll_never_miss_a_thing'); ?>
                    </div>
                    <div id="ownerTxtId" style="display:<?php if(isset($_POST['txtIsOwner']) && $_POST['txtIsOwner'] == "1") { echo "block";} else {echo "none";}?>;">
                        <?php echo tranText('by_registering_on_bestbookingsonline_com_as_an_owner_you_get_access_to_one_of_the_mot_powerful_online_holiday_accommodation_systems_in_the_world_as_well_as_uploading_and_managing_your_holiday_home_you_will_get_access_to_lots_of_cool_features_such_as_instant_late_deals_featured_properties_and_comprehensive_stats_packages_theres_also_lots_of_expert_help_and_advice_from_the_friendly_bestbookingsonline_com_team_its_free_to_register_and_the_sooner_you_join_the_quicker_you_will_increase_your_bookings'); ?>
                    </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="left" valign="top">
            <div class="pad-btm20">
            <table width="690" border="0" cellspacing="0" cellpadding="0" class="font12">
                <tr><td width="690" align="left" valign="bottom">&nbsp;</td></tr>
                <tr>
                    <td align="left" valign="bottom">
                        <form name="frmUserProfile" method="post" action="registration">
                        <input type="hidden" name="securityKey" value="<?php echo md5(NEWREGISTRATION);?>" />
                        <input type="hidden" name="txtUserIP" value="<?php echo $_SERVER['REMOTE_ADDR']?>" />
                        <input type="hidden" name="txtIsOwner" id="txtIsOwnerId" value="<?php if(isset($_POST['txtIsOwner']) && $_POST['txtIsOwner'] == "1") { echo "1";} else {echo "0";}?>" />
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="left" valign="bottom">
                                    <div class="gradientBox690thin" style="margin-bottom:10px;">
                                        <div class="top">
                                            <div class="btm">
                                                <div class="content" style=" padding:5px 5px 5px 35px;">
                                                    <table border="0" cellpadding="3" cellspacing="0">
                                                        <tr>
                                                            <td align="left" valign="middle" class="pink14arial pad-rgt5"><?php echo tranText('register_me_as_a'); ?></td>
                                                            <td align="left" valign="middle" class="pad-left5"><input name="txtHoliday" type="checkbox" class="checkbox" id="txtHolidayId" <?php if(isset($_POST['txtIsOwner']) && $_POST['txtIsOwner'] == "1") { echo "";} else {echo "checked=\"checked\"";}?> onclick="return setUserType(0);" value="0" /></td>
                                                            <td align="left" valign="middle" class="blue14 pad-rgt15"><?php echo tranText('holidaymaker'); ?></td>
                                                            <td align="left" valign="middle"><input name="txtOwner" type="checkbox" class="checkbox" id="txtOwnerId" <?php if(isset($_POST['txtIsOwner']) && $_POST['txtIsOwner'] == "1") { echo "checked=\"checked\"";} else {echo "";}?> onclick="return setUserType(1);" value="1" /></td>
                                                            <td align="left" valign="middle" class="blue14"><?php echo tranText('holiday_home_owner'); ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td align="left" valign="top">
                                    <div id="ownerMsgId" style="display:<?php if(isset($_POST['txtIsOwner']) && $_POST['txtIsOwner'] == "1") { echo "block";} else {echo "none";}?>;">
                                    <table width="100%" border="0" cellpadding="5" cellspacing="0">
                                        <tr>
                                            <td width="155" align="right" valign="middle">&nbsp;</td>
                                            <td colspan="2" valign="top"><strong><a href="<?php echo SITE_URL; ?>login" class="blue-link">Sign in</a> to use your existing holidaymaker details</strong></td>
                                        </tr>
                                    </table>
                                    </div>
                                    <table width="100%" border="0" cellpadding="5" cellspacing="0">
                                        <tr>
                                            <td width="155" align="right" valign="middle"><?php echo tranText('first_name'); ?><span class="compulsory">*</span></td>
                                            <td width="235" valign="middle"><span class="RegFormRight"><input name="txtUserFName" type="text" class="RegFormFld" id="txtUserFNameId" value="<?php if(isset($_POST['txtUserFName'])){echo $_POST['txtUserFName'];}else{echo $userInfoArr['user_fname'];}?>" onkeydown="chkblnkTxtError('txtUserFNameId', 'showErrorUserFNameId');" onkeyup="chkblnkTxtError('txtUserFNameId', 'showErrorUserFNameId');" /></span></td>
                                            <td width="274" valign="top"><span class="pdError1" id="showErrorUserFNameId"><?php if(array_key_exists('txtUserFName', $form_array)) echo $form_array['txtUserFName'];?></span></td>
                                        </tr>
                                        <tr>
                                            <td width="155" align="right" valign="middle"><?php echo tranText('last_name'); ?><span class="compulsory">*</span></td>
                                            <td width="235" valign="middle"><span class="RegFormRight"><input name="txtUserLName" type="text" class="RegFormFld" id="txtUserLNameId" value="<?php if(isset($_POST['txtUserLName'])){echo $_POST['txtUserLName'];}else{echo $userInfoArr['user_lname'];}?>" onkeydown="chkblnkTxtError('txtUserLNameId', 'showErrorUserLNameId');" onkeyup="chkblnkTxtError('txtUserLNameId', 'showErrorUserLNameId');" /></span></td>
                                            <td width="274" valign="top"><span class="pdError1" id="showErrorUserLNameId"><?php if(array_key_exists('txtUserLName', $form_array)) echo $form_array['txtUserLName'];?></span></td>
                                        </tr>
                                        <tr>
                                            <td width="155" align="right" valign="middle"><?php echo tranText('email_address'); ?><span class="compulsory">*</span></td>
                                            <td width="235" valign="middle"><span class="RegFormRight"><input name="txtUserEmail" type="text" class="RegFormFld" id="txtUserEmailId" value="<?php if(isset($_POST['txtUserEmail'])){echo $_POST['txtUserEmail'];}else{echo $userInfoArr['user_email'];}?>" /></span></td>
                                            <td width="274" valign="top"><span class="pdError1" id="showErrorUserEmailId"><?php if(array_key_exists('txtUserEmail', $form_array)) echo $form_array['txtUserEmail'];?></span></td>
                                        </tr>
                                        <tr>
                                            <td width="155" align="right" valign="middle"><?php echo tranText('password'); ?><span class="compulsory">*</span></td>
                                            <td width="235" valign="middle"><span class="RegFormRight"><input name="txtUserPasswrd" type="password" class="RegFormFld" id="txtUserPasswrdId" value="<?php echo $_POST['txtUserPasswrd']; ?>" /></span></td>
                                            <td width="274" valign="top"><span class="pdError1" id="showErrorPassword"><?php if(array_key_exists('txtUserPasswrd', $form_array)) echo $form_array['txtUserPasswrd'];?></span></td>
                                        </tr>
                                        <tr>
                                            <td width="155" align="right" valign="middle"><?php echo tranText('confirm_password'); ?><span class="compulsory">*</span></td>
                                            <td width="235" valign="middle"><span class="RegFormRight"><input name="txtConfirmPassword" type="password" class="RegFormFld" id="txtConfirmPasswordId" value="<?php echo $_POST['txtConfirmPassword']; ?>" /></span></td>
                                            <td width="274" valign="top"><span class="pdError1" id="showErrorConfirmPassword"><?php if(array_key_exists('txtConfirmPassword', $form_array)) echo $form_array['txtConfirmPassword'];?></span></td>
                                        </tr>
                                        <!-- Owner Field: Start Here -->
                                        <tr>
                                            <td colspan="3" style="padding:0px;">
                                            <div id="ownerDisplayId" style="display:<?php if(isset($_POST['txtIsOwner']) && $_POST['txtIsOwner'] == "1") { echo "block";} else {echo "none";}?>;">
                                                <table width="100%" border="0" cellpadding="5" cellspacing="0">
                                                    <tr>
                                                        <td width="155" align="right" valign="middle"><?php echo tranText('birthdate'); ?><span class="compulsory">*</span></td>
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
                                                                        <option value="<?php echo $key?>" <? if(isset($_POST['txtDOBMonth']) && ($key == $_POST['txtDOBMonth'])){echo "selected";} elseif(isset($txtDOBMonth) && ($key==$txtDOBMonth)){echo "selected";} else{echo "";}?>><?php echo $value;?></option>
                                                                    <?
                                                                    }
                                                                    ?>
                                                                </select>
                                                                <select name="txtDOBYear" id="txtDOBYearId" class="RegFormBYear">
                                                                    <option value=""> - - </option>
                                                                    <?
                                                                    foreach ($yearname as $value) {
                                                                    ?>
                                                                        <option value="<?php echo $value;?>" <? if(isset($_POST['txtDOBYear']) && ($value == $_POST['txtDOBYear'])){echo "selected";} elseif(isset($txtDOBYear) && ($value==$txtDOBYear)){echo "selected";} else{echo "";}?>><?php echo $value;?></option>
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
                                                        <td width="155" align="right" valign="middle"><?php echo tranText('country_of_residence'); ?><span class="compulsory">*</span></td>
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
                                                        <td width="155" align="right" valign="top"><?php echo tranText('contact_numbers'); ?><span class="compulsory">*</span></td>
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
                                                        <td width="155" align="right" valign="middle"><?php echo tranText('contact_address'); ?></td>
                                                        <td width="235" valign="middle"><span class="RegFormRight"><input name="txtAddress1" type="text" class="RegFormFld" id="txtAddressId1" value="<?php if(isset($_POST['txtAddress1']) && $_POST['txtAddress1'] !=""){echo $_POST['txtAddress1'];}else{echo $userInfoArr['user_address1'];}?>" /></span></td>
                                                        <td width="274" valign="top"><span class="pdError1" id="showErrorAddress1"><?php if(array_key_exists('txtAddress1', $form_array)) echo $form_array['txtAddress1'];?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="155" align="right" valign="middle">&nbsp;</td>
                                                        <td width="235" valign="middle"><span class="RegFormRight"><input name="txtAddress2" type="text" class="RegFormFld" id="txtAddressId2" value="<?php if(isset($_POST['txtAddress2']) && $_POST['txtAddress2'] !=""){echo $_POST['txtAddress2'];}else{echo $userInfoArr['user_address2'];}?>" /></span></td>
                                                        <td width="274" valign="top"><span class="pdError1" id="showErrorAddress1"><?php if(array_key_exists('txtAddress2', $form_array)) echo $form_array['txtAddress2'];?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="155" align="right" valign="middle"><?php echo tranText('town_city'); ?></td>
                                                        <td width="235" valign="middle"><span class="RegFormRight"><input name="txtTown" type="text" class="RegFormFld" id="txtTownId" value="<?php if(isset($_POST['txtTown']) && $_POST['txtTown'] !=""){echo $_POST['txtTown'];}else{echo $userInfoArr['user_town'];}?>" /></span></td>
                                                        <td width="274" valign="top"><span class="pdError1" id="showErrorTown"><?php if(array_key_exists('txtTown', $form_array)) echo $form_array['txtTown'];?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="155" align="right" valign="middle"><?php echo tranText('county_state_province'); ?></td>
                                                        <td width="235" valign="middle"><span class="RegFormRight"><input name="txtState" type="text" class="RegFormFld" id="txtStateId" value="<?php if(isset($_POST['txtState']) && $_POST['txtState'] !=""){echo $_POST['txtState'];}else{echo $userInfoArr['user_state'];}?>" /></span></td>
                                                        <td width="274" valign="top"><span class="pdError1" id="showErrorState"><?php if(array_key_exists('txtState', $form_array)) echo $form_array['txtState'];?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="155" align="right" valign="middle"><?php echo tranText('postcode_zip'); ?></td>
                                                        <td width="235" valign="middle"><span class="RegFormRight"><input name="txtZip" type="text" class="RegFormFld" id="txtZipId" value="<?php if(isset($_POST['txtZip']) && $_POST['txtZip'] !=""){echo $_POST['txtZip'];}else{echo $userInfoArr['user_zip'];}?>" /></span></td>
                                                        <td width="274" valign="top"><span class="pdError1" id="showErrorState"><?php if(array_key_exists('txtZip', $form_array)) echo $form_array['txtZip'];?></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="155" align="right" valign="middle"><?php echo tranText('country'); ?></td>
                                                        <td width="235" valign="middle">
                                                            <span class="RegFormRight">
                                                            <select name="txtCountry" class="select230">
                                                                <option value="" style="font-style:normal; background-color:#D0E0F1;COLOR:#000000" disabled="disabled" selected="selected">Select country...</option>
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
                                                </table>
                                            </div>
                                            </td>
                                        </tr>
                                        <!-- Owner Field: End Here -->
                                        <tr>
                                            <td colspan="3" style="padding:0px;">
                                                <table border="0" cellpadding="5" cellspacing="0">
                                                    <tr>
                                                        <td width="155" align="right" valign="middle"><?php echo tranText('type_this'); ?><span class="compulsory">*</span></td>
                                                        <td align="left" valign="middle" class="pad-lr"><img src="captchacode/securityimage.php?width=120&height=40&characters=5" alt="Word Scramble" class="RegFormScrambleImg" id="image_scode" name="image_scode" /></td>
                                                        <td align="left" valign="middle" class="pad-lft5"><?php echo tranText('into_this_box'); ?></td>
                                                        <td align="left" valign="middle" class="pad-lft5"><input name="image_vcode" id="image_vcode" type="text" class="txtBox100" value="" maxlength="5" autocomplete="off" /></td>
                                                        <td align="left" valign="middle"><div class="pdError1" id="showErrorImgVCode"><?php if(array_key_exists('image_vcode', $form_array)) echo $form_array['image_vcode'];?></div></td>
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
                                                echo "<td align=\"right\" valign=\"middle\" class=\"pad-top15\">&nbsp;</td>";
                                                echo "<td colspan=\"2\" valign=\"middle\">";
                                                echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
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
												echo "<td style=\"padding-right:10px;\">Agree the <a href=\"javascript:popcontact('terms.html')\" class=\"blue-link\">terms and conditions</a>&nbsp;&nbsp;<span class=\"pdError1\" id=\"showErrorTerms\">&nbsp;</span></td>";
												echo "</tr>";
                                                echo "</table>";
                                                echo "</td>";
                                                echo "</tr>";
                                            }
                                        ?>
                                        <tr><td colspan="3" align="right" valign="middle" class="dash25">&nbsp;</td></tr>
                                        <tr>
                                            <td align="right" valign="middle">&nbsp;</td>
                                            <td colspan="2" valign="middle"><a href="javascript:cancelRegistration();" class="button-grey" style="text-decoration:none;">Cancel</a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="return validateRegister();" class="button-blue" style="text-decoration:none;">Submit</a></td>
                                        </tr>
                                    </table>
                                </td>
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
            </div>
        </td>
    </tr>
</table>