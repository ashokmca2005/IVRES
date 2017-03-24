<!-- TinyMCE -->
<script type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		mode : "exact",
		elements : "txtReviewTxtId",
		handle_event_callback : "myHandleEvent",
		theme : "simple",
		plugins : 'advlink,advimage',
		relative_urls : false,
		remove_script_host : false
	});

	//event such as key or mouse press
	function myHandleEvent(e){
		if(e.type=="keyup"){
			chkblnkEditorTxtError("txtReviewTxtId", "txtReviewTxtErrorId");	
		}
		return true;
	}
</script>
<!-- /TinyMCE -->
<script language="javascript" type="text/javascript">
	function frmValidateAddReview() {
		var shwError = false;
		document.frmAddTestimonial.txtReviewTxt.value = tinyMCE.get('txtReviewTxtId').getContent();
		if(document.frmAddTestimonial.txtReviewTxt.value == "") {
			document.getElementById("txtReviewTxtErrorId").innerHTML = "Please enter review description.";
			document.frmAddTestimonial.txtReviewTxt.focus();
			shwError = true;
		}

		if(document.frmAddTestimonial.txtReviewTitle.value == "") {
			document.getElementById("txtReviewTitleErrorId").innerHTML = "Please enter review title.";
			document.frmAddTestimonial.txtReviewTitle.focus();
			shwError = true;
		}

		if(document.frmAddTestimonial.txtCountry.value == "") {
			document.getElementById("txtCountryErrorId").innerHTML = "Please select country.";
			document.frmAddTestimonial.txtCountry.focus();
			shwError = true;
		}

		if(document.frmAddTestimonial.txtEmail.value == "") {
			document.getElementById("txtEmailErrorId").innerHTML = "Please enter valid email id.";
			document.frmAddTestimonial.txtEmail.focus();
			shwError = true;
		} else {
			var emailRegxp = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			var txtemail = document.frmAddTestimonial.txtEmail.value;
			if (emailRegxp.test(document.getElementById("txtEmailId").value)!= true){
				document.getElementById("txtEmailErrorId").innerHTML = "Please enter valid email id.";
				document.frmAddTestimonial.txtEmail.value = "";
				document.frmAddTestimonial.txtEmail.focus();
				shwError = true;
			}
		}
		
		if(document.frmAddTestimonial.txtLName.value == "") {
			document.getElementById("txtLNameErrorId").innerHTML = "Please enter last name.";
			document.frmAddTestimonial.txtLName.focus();
			shwError = true;
		}

		if(document.frmAddTestimonial.txtFName.value == "") {
			document.getElementById("txtFNameErrorId").innerHTML = "Please enter first name.";
			document.frmAddTestimonial.txtFName.focus();
			shwError = true;
		}

		if(shwError == true) {
			return false;
		} else {
//			document.frmAddTestimonial.action = "holiday-events-preview.php";
			document.frmAddTestimonial.submit();
		}
	}

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
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr>
        <td align="left" valign="top">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                	<td valign="top" class="pad-rgt10">
                    <div><h1 class="page-headingNew"><?php echo tranText('have_your_say'); ?>: <?php echo tranText('what_do_you_think_of_the_site_and_our_services'); ?>?</h1></div>
                    <div class="pad-top5 pad-rgt5">
                        Write a testimonial below and if it's any good we'll probably publish it on the site for other holidaymakers and holiday home owners to read. (And if it's really really good we may even send one of our team out to give you a big hug and an 'I love <?php echo $sitetitle; ?>' t-shirt ... and yes, before you ask, you get to choose which member of the team does the hugging!).
                        <br /><br />
                        <?php echo tranText('how_would_you_rate_the_site_and_our_services'); ?>
                    </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="left" valign="top" class="pad-btm20">
            <form name="frmAddTestimonial" id="frmAddTestimonial" action="holiday-testimonials-add.php?testi=compose" method="post">
            <input type="hidden" name="securityKey" id="securityKey" value="<?php echo md5("ADDTESTIMONIAL")?>">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <?php
                if(isset($detail_array['error_msg']) && $detail_array['error_msg'] !="") {
                    echo "<tr>";
                    echo "<td class=\"pad-top1 pad-btm15\" align=\"right\" height=\"23\" valign=\"top\" width=\"185\">&nbsp;</td>";
                    echo "<td class=\"pad-btm15 pad-lft5\" valign=\"top\" colspan=\"3\"><span class=\"pdError1\">".$detail_array['error_msg']."</span></td>";
                    echo "</tr>";
                }
                ?>
                <tr>
                    <td class="pad-top1 pad-btm15" align="right" height="23" valign="top" width="185"><?php echo tranText('first_name'); ?></td>
                    <td class="pad-btm15 pad-lft5" valign="top" width="249"><input name="txtFName" id="txtFNameId" type="text" class="inpuTxt260" value="<?php if(isset($_POST['txtFName'])) { echo $_POST['txtFName']; } else if(isset($users_first_name)) { echo $users_first_name;} ?>" onkeydown="chkblnkTxtError('txtFNameId', 'txtFNameErrorId');" onkeyup="chkblnkTxtError('txtFNameId', 'txtFNameErrorId');" /></td>
                    <td valign="top" width="10">&nbsp;</td>
                    <td class="pad-top1 pad-btm15" valign="top" width="240"><span class="pdError1" id="txtFNameErrorId"></span></td>
                </tr>
                <tr>
                    <td class="pad-top1 pad-btm15" align="right" height="23" valign="top"><?php echo tranText('last_name'); ?></td>
                    <td class="pad-btm15 pad-lft5" valign="top"><input name="txtLName" id="txtLNameId" type="text" class="inpuTxt260" value="<?php if(isset($_POST['txtLName'])) { echo $_POST['txtLName']; } else if(isset($users_last_name)) { echo $users_last_name;} ?>" onkeydown="chkblnkTxtError('txtLNameId', 'txtLNameErrorId');" onkeyup="chkblnkTxtError('txtLNameId', 'txtLNameErrorId');" /></td>
                    <td valign="top" width="9"></td>
                    <td class="pad-top1 pad-btm15" valign="top"><span class="pdError1" id="txtLNameErrorId"></span></td>
                </tr>
                <tr>
                    <td class="pad-top1 pad-btm15" align="right" height="23" valign="top"><?php echo tranText('email_address'); ?></td>
                    <td class="pad-btm15 pad-lft5" valign="top"><input name="txtEmail" id="txtEmailId" type="text" class="inpuTxt260" value="<?php if(isset($_POST['txtEmail'])) { echo $_POST['txtEmail']; } else if(isset($users_email_id)) { echo $users_email_id;} ?>" onkeydown="chkblnkTxtError('txtEmailId', 'txtEmailErrorId');" onkeyup="chkblnkTxtError('txtEmailId', 'txtEmailErrorId');" /></td>
                    <td valign="top" width="9"></td>
                    <td class="pad-top1 pad-btm15" valign="top"><span class="pdError1" id="txtEmailErrorId"></span></td>
                </tr>
                <tr>
                    <td class="pad-top1 pad-btm15" align="right" height="23" valign="top"><?php echo tranText('which_country_are_you_from'); ?>?</td>
                    <td class="pad-btm15 pad-lft5" valign="top">
                        <?php 
                        if(isset($_POST['txtCountry'])) {
                            $txtCountry = $_POST['txtCountry'];
                        } else if(isset($country_id)) {
                            $txtCountry = $country_id;
                        }
                        ?>
                        <select name="txtCountry" id="txtCountryId" class="select216_0" onchange="chkblnkTxtError('txtCountryId', 'txtCountryErrorId');">
                            <option value="">Select country...</option>
                            <option value="193">Spain</option>							
                            <option value="222">United Kingdom</option>
                            <option value="223">United States</option>	
                            <option value="81">Germany</option>
                            <?php $locationObj->fun_getCountriesOptionsList($txtCountry); ?>
                        </select>
                    </td>
                    <td valign="top" width="9"></td>
                    <td class="pad-top1 pad-btm15" valign="top"><span class="pdError1" id="txtCountryErrorId"></span></td>
                </tr>
                <tr>
                    <td class="pad-top1 pad-btm15" align="right" height="23" valign="top"><?php echo tranText('title_of_your_review'); ?></td>
                    <td class="pad-btm15 pad-lft5" valign="top">
                        <textarea name="txtReviewTitle" id="txtReviewTitleId" class="textArea260" onkeydown="chkblnkTxtError('txtReviewTitleId', 'txtReviewTitleErrorId');" onkeyup="chkblnkTxtError('txtReviewTitleId', 'txtReviewTitleErrorId');" ><?php echo $_POST['txtReviewTitle']; ?></textarea>
                    </td>
                    <td valign="top" width="9"></td>
                    <td class="pad-top1 pad-btm15" valign="top"><span class="pdError1" id="txtReviewTitleErrorId"></span></td>
                </tr>
                <tr>
                    <td class="pad-top1" align="right" height="23" valign="top"><?php echo tranText('write_your_review'); ?></td>
                    <td class="pad-lft5" colspan="3" valign="top">
                        <textarea name="txtReviewTxt" id="txtReviewTxtId" class="textArea460" ><?php echo $_POST['txtReviewTxt']; ?></textarea>
                    </td>
                <tr>
                    <td colspan="4" style="padding:0px;">
                        <table border="0" cellpadding="5" cellspacing="0">
                            <tr>
                                <td width="175" align="right" valign="middle"><?php echo tranText('type_this'); ?><span class="compulsory">*</span></td>
                                <td align="left" valign="middle" class="pad-lr"><img src="captchacode/securityimage.php?width=120&height=40&characters=5" alt="Word Scramble" class="RegFormScrambleImg" id="image_scode" name="image_scode" /></td>
                                <td align="left" valign="middle" class="pad-lft5"><?php echo tranText('into_this_box'); ?></td>
                                <td align="left" valign="middle" class="pad-lft5"><input name="image_vcode" id="image_vcode" type="text" class="txtBox100" value="" maxlength="5" autocomplete="off" /></td>
                                <td align="left" valign="middle"><div class="pdError1" id="showErrorImgVCode"><?php if($contactsubmit == "Codes must match!") {echo $contactsubmit;} ?></div></td>
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
              </tr>
                <tr>
                    <td class="pad-top1 pad-btm15" align="right" height="23" valign="top">&nbsp;</td>
                    <td colspan="3" valign="top" class="pad-btm15 pad-lft5"><span class="pdError1" id="txtReviewTxtErrorId"></span></td>
                </tr>
                <tr>
                    <td class="pad-top1" align="right" height="23" valign="top"><?php echo tranText('how_would_you_rate_the_site'); ?></td>
                    <td valign="middle" class="pad-lft5 font14" colspan="3">
                        <table border="0" cellspacing="0" cellpadding="2">
                            <tr>
                                <td><?php echo tranText('very_poor'); ?></td>
                                <td class="pad-lft10">1</td>
                                <td><input type="radio" name="txtRating" id="txtRatingId1" value="1" <?php if(isset($_POST['txtRating']) && $_POST['txtRating'] == "1") {echo "checked=\"checked\"";} ?> /></td>
                                <td class="pad-lft10">2</td>
                                <td><input type="radio" name="txtRating" id="txtRatingId2" value="2" <?php if(isset($_POST['txtRating']) && $_POST['txtRating'] == "2") {echo "checked=\"checked\"";} ?> /></td>
                                <td class="pad-lft10">3</td>
                                <td><input type="radio" name="txtRating" id="txtRatingId3" value="3" <?php if(isset($_POST['txtRating']) && $_POST['txtRating'] == "3") {echo "checked=\"checked\"";} ?> /></td>
                                <td class="pad-lft10">4</td>
                                <td><input type="radio" name="txtRating" id="txtRatingId4" value="4" <?php if(isset($_POST['txtRating']) && $_POST['txtRating'] == "4") {echo "checked=\"checked\"";} ?> /></td>
                                <td class="pad-lft10">5</td>
                                <td><input type="radio" name="txtRating" id="txtRatingId5" value="5" <?php if(isset($_POST['txtRating']) && $_POST['txtRating'] == "5") {echo "checked=\"checked\"";} ?> /></td>
                                <td>&nbsp;&nbsp;<?php echo tranText('fantastic'); ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="pad-top1" align="right" valign="top">&nbsp;</td>
                    <td valign="middle" class="pad-lft5" style="padding-bottom:0px;" colspan="3">
                        <table border="0" cellspacing="0" cellpadding="2">
                            <tr>
                                <td width="19"><input type="checkbox" class="checkbox" name="txtUserSetting" id="txtUserSettingId" value="1" <?php if(isset($_POST['txtUserSetting']) && $_POST['txtUserSetting'] == "1") {echo "checked=\"checked\"";} ?> /></td>
                                <td width="327"><?php echo tranText('i_would_like_to_receive'); ?> <strong><?php echo $sitetitle; ?></strong> <?php echo tranText('newsletters'); ?></td>
                            </tr>
                            <tr><td colspan="2"><?php echo tranText('by_clicking_submit_you_are_agreeing_to_our'); ?> <a href="javascript:popcontact('terms.html');" class="blue-link"><?php echo tranText('terms_and_conditions'); ?></a></td></tr>
                        </table>
                    </td>
                </tr>
                <tr><td colspan="4" align="right" valign="middle" class="line25">&nbsp;</td></tr>
                <tr>
                    <td align="right" valign="middle" class="pad-top15">&nbsp;</td>
                    <td valign="middle" class="pad-lft5" colspan="3">
                        <a href="property.php?pid=<?php echo $property_id; ?>" style="text-decoration:none;"><input type="reset" alt="Search" class="button85x30-grey" value="Cancel"/></a>
                        <input type="submit" alt="Search" onclick="return frmValidateAddReview();" class="button85x30" value="Submit"/>
                        <?php /*?>           
                                <img src="<?php echo SITE_IMAGES;?>cancel-gray.gif" onclick="frmReset();" alt="Cancel" width="72" height="27" />&nbsp;
                                <input src="<?php echo SITE_IMAGES;?>submit.gif" onclick="return frmValidateContactUs();" alt="Submit" type="image">
                                
                        <?php */?>
                    </td>
                </tr>
                <?php /*?>
                <tr>
                    <td align="right" valign="middle" class="pad-top15">&nbsp;</td>
                    <td valign="middle" class="pad-lft5" colspan="3">
                        <a href="property.php?pid=<?php echo $property_id; ?>" style="text-decoration:none;"><img src="images/cancel-gray.gif" alt="Cancel" width="72" height="27" /></a>&nbsp;<input src="<?php echo SITE_IMAGES;?>submit.gif" onclick="return frmValidateAddReview();" alt="Submit" type="image">
                    </td>
                </tr>
                <?php */?>
            </table>
            </form>
        </td>
    </tr>
</table>