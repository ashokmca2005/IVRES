<?php
if($_POST['securityKey']==md5(CONTACTUS)){		
	$detail_array 	= array();
	$error_msg		= 'no';
	if(trim($_POST['txtFName']) == ''){
		$detail_array['txtFName'] = '<span style=\"font-size:12px; color:#FF0000; font-weight:normal;\">Enter first name</span>';
		$error_msg	= 'yes';
	}
	if(trim($_POST['txtLName']) == ''){
		$detail_array['txtLName'] = '<span style=\"font-size:12px; color:#FF0000; font-weight:normal;\">Enter last name</span>';
		$error_msg	= 'yes';
	}
	if($_POST['txtContactEmail'] == ''){
		$detail_array['txtContactEmail'] = '<span style=\"font-size:12px; color:#FF0000; font-weight:normal;\">Enter valid email address</span>';
		$error_msg	= 'yes';
	}
	if($_POST['txtMessage'] == ''){
		$detail_array['txtMessage'] = '<span style=\"font-size:12px; color:#FF0000; font-weight:normal;\">Enter message</span>';
		$error_msg	= 'yes';
	}

	if(($_SESSION['security_code'] == $_POST['image_vcode']) && ($error_msg == 'no')){		
		// send mail now
		if($usersObj->sendContactUsRequestEmail() === true){
			if($usersObj->fun_verifyUser4Newsletter($_POST['txtContactEmail'])){
				$result = "exist";
			} else {
				if($usersObj->fun_addUserNewsletterSignup($_POST['txtContactEmail']) > 0){
					$result = "done";
				} else {
					$result = "error";
				}
			}
			if(isset($result) && $result == "done"){
				$user4NewsLetterDets = $usersObj->fun_getUser4NewsletterInfo($_POST['txtContactEmail']);
				$id = $user4NewsLetterDets['id'];
				$usersObj->sendNewsletterActivationEmail($id, $_POST['txtContactEmail']);
			}
			$contactsubmit = "success";
		} else {
			$contactsubmit = "failed";
		}
	} else {
		$contactsubmit = "Codes must match!";
	}
}
if(isset($contactsubmit) && ($contactsubmit != "Codes must match!")){
?>
<!-- Message sent successfully: Starts Here -->
<table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td colspan="2" valign="top" class="pad-top10 pad-rgt10">
            <div class="FloatLft"><span><img src="<?php echo SITE_IMAGES;?>green-arrow-new.png" width="30" />&nbsp;&nbsp;</span><span class="latedealPink-20">Thanks ...</span><span style="font-weight:normal; font-size:20px;"> you're message has been sent</span></div>
        </td>
    </tr>
    <tr><td colspan="2" valign="top" class="pad-rgt10" style="padding-left:35px;"><div class="font12">One of our trained staff, will get back to you shortly regarding your inquiry. </div></td></tr>
    <tr>
        <td align="left" colspan="2" valign="top" class="pad-top20" style="padding-left:35px;">
            <a href="<?php if(isset($_SESSION['ses_user_home']) && $_SESSION['ses_user_home'] !=""){echo $_SESSION['ses_user_home'];} else {echo SITE_URL;}?>" style="text-decoration:none;"><img src="<?php echo SITE_IMAGES;?>returntohomepage-gray.gif" /></a>
        </td>
    </tr>
</table>
<!-- Message sent successfully: End Here -->
<?php
} else {
?>
<!-- TinyMCE -->
<script type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		mode : "exact",
		elements : "txtMessageId",
		handle_event_callback : "myHandleEvent",
		theme : "simple",
		plugins : 'advlink,advimage',
		relative_urls : false,
		remove_script_host : false
	});

	//event such as key or mouse press
	function myHandleEvent(e){
		if(e.type=="keyup"){
			chkblnkEditorTxtError("txtMessageId", "txtMessageErrorId");	
		}
		return true;
	}
</script>
<!-- /TinyMCE -->
<script language="javascript" type="text/javascript">
	function frmValidateContactUs() {
		var shwError = false;
		document.frmContactUs.txtMessage.value = tinyMCE.get('txtMessageId').getContent();
		if(document.frmContactUs.txtMessage.value == "") {
			document.getElementById("txtMessageErrorId").innerHTML = "Enter your message";
			document.frmContactUs.txtMessage.focus();
			shwError = true;
		}

		if(document.frmContactUs.txtContactEmail.value == "") {
			document.getElementById("txtContactEmailErrorId").innerHTML = "Enter valid email address";
			document.frmContactUs.txtContactEmail.focus();
			shwError = true;
		} else {
			var emailRegxp = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			var txtemail = document.frmContactUs.txtContactEmail.value;
			if (emailRegxp.test(document.getElementById("txtContactEmailId").value)!= true){
				document.getElementById("txtContactEmailErrorId").innerHTML = "Enter valid email address";
				document.frmContactUs.txtContactEmail.value = "";
				document.frmContactUs.txtContactEmail.focus();
				shwError = true;
			}
		}
		
		if(document.frmContactUs.txtLName.value == "") {
			document.getElementById("txtLNameErrorId").innerHTML = "Enter last name";
			document.frmContactUs.txtLName.focus();
			shwError = true;
		}

		if(document.frmContactUs.txtFName.value == "") {
			document.getElementById("txtFNameErrorId").innerHTML = "Enter first name";
			document.frmContactUs.txtFName.focus();
			shwError = true;
		}

		if(shwError == true) {
			return false;
		} else {
			document.frmContactUs.submit();
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

	function frmReset(){
		document.frmContactUs.reset();
		return false;
	}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr>
        <td align="left" valign="top" class="pad-top15 pad-rgt10">
			<?php echo $page_discription; ?>
        </td>
    </tr>
    <tr>
        <td align="left" valign="top" class="pad-btm20 pad-top10">
            <form name="frmContactUs" id="frmContactUs" action="contact-us" method="post">
            <input type="hidden" name="securityKey" id="securityKey" value="<?php echo md5("CONTACTUS")?>">
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
                    <td class="pad-btm15 pad-lft5" valign="top"><input name="txtContactEmail" id="txtContactEmailId" type="text" class="inpuTxt260" value="<?php if(isset($_POST['txtContactEmail'])) { echo $_POST['txtContactEmail']; } else if(isset($users_email_id)) { echo $users_email_id;} ?>" onkeydown="chkblnkTxtError('txtContactEmailId', 'txtContactEmailErrorId');" onkeyup="chkblnkTxtError('txtContactEmailId', 'txtContactEmailErrorId');" /></td>
                    <td valign="top" width="9"></td>
                    <td class="pad-top1 pad-btm15" valign="top"><span class="pdError1" id="txtContactEmailErrorId"></span></td>
                </tr>
                <tr>
                    <td class="pad-top1 pad-btm15" align="right" height="23" valign="top"><?php echo tranText('reference_number_id'); ?></td>
                    <td class="pad-btm15 pad-lft5" valign="top"><input type="text" name="txtPropId" id="txtPropId" class="Ref-No" maxlength="11px"/></td>
                    <td valign="top" width="9"></td>
                    <td class="pad-top1 pad-btm15" valign="top">&nbsp;</td>
                </tr>
                <tr>
                    <td class="pad-top1 pad-btm15" align="right" height="23" valign="top">&nbsp;</td>
                    <td class="pad-btm15 pad-lft5" valign="top" colspan="3"><span class="font11"><?php echo tranText('this_is_important_and_helps_us_deal_with_your_inquiry_quicker_all_properties_accommodation_enquiries_and_events_will_have_a_reference_number'); ?>.</span></td>
                </tr>
                <tr>
                    <td class="pad-top1 pad-btm15" align="right" height="23" valign="top"><?php echo tranText('subject_of_query'); ?></td>
                    <td class="pad-btm15 pad-lft5" valign="top">
                        <select name="txtEnquiryType" id="txtEnquiryTypeId" class="select216_0">
                            <option value="1" <?php if(isset($_REQUEST['sbj']) && $_REQUEST['sbj'] == "1") {echo " selected=\"selected\"";} ?> >General inquiry</option>
                            <option value="2" <?php if(isset($_REQUEST['sbj']) && $_REQUEST['sbj'] == "2") {echo " selected=\"selected\"";} ?> >Advertising my property</option>
                            <option value="3" <?php if(isset($_REQUEST['sbj']) && $_REQUEST['sbj'] == "3") {echo " selected=\"selected\"";} ?> >Advertising for agents</option>
                            <option value="4" <?php if(isset($_REQUEST['sbj']) && $_REQUEST['sbj'] == "4") {echo " selected=\"selected\"";} ?> >Complaints</option>
                            <option value="5" <?php if(isset($_REQUEST['sbj']) && $_REQUEST['sbj'] == "5") {echo " selected=\"selected\"";} ?> >Feedback/Testimonials</option>
                            <option value="6" <?php if(isset($_REQUEST['sbj']) && $_REQUEST['sbj'] == "6") {echo " selected=\"selected\"";} ?> >Job Opportunities</option>
                            <option value="7" <?php if(isset($_REQUEST['sbj']) && $_REQUEST['sbj'] == "7") {echo " selected=\"selected\"";} ?> >Link exchange requests</option>
                            <option value="8" <?php if(isset($_REQUEST['sbj']) && $_REQUEST['sbj'] == "8") {echo " selected=\"selected\"";} ?> >Partner/Affiliate Enquiry</option>
                            <option value="9" <?php if(isset($_REQUEST['sbj']) && $_REQUEST['sbj'] == "9") {echo " selected=\"selected\"";} ?> >Press Enquiry</option>
                            <option value="10" <?php if(isset($_REQUEST['sbj']) && $_REQUEST['sbj'] == "10") {echo " selected=\"selected\"";} ?> >Regarding a Property on the site</option>
                            <option value="11" <?php if(isset($_REQUEST['sbj']) && $_REQUEST['sbj'] == "11") {echo " selected=\"selected\"";} ?> >Technical Support</option>
                            <option value="12" <?php if(isset($_REQUEST['sbj']) && $_REQUEST['sbj'] == "12") {echo " selected=\"selected\"";} ?> >Other...</option>
                        </select>
                    </td>
                    <td valign="top" width="9"></td>
                    <td class="pad-top1 pad-btm15" valign="top">&nbsp;</td>
                </tr>
                <tr>
                    <td class="pad-top1" align="right" height="23" valign="top"><?php echo tranText('message'); ?></td>
                    <td class="pad-lft5" colspan="3" valign="top">
                        <textarea name="txtMessage" id="txtMessageId" class="textArea460" ><?php echo $_POST['txtMessage']; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td class="pad-top1 pad-btm15" align="right" height="23" valign="top">&nbsp;</td>
                    <td colspan="3" valign="top" class="pad-btm15 pad-lft5"><span class="pdError1" id="txtMessageErrorId"></span></td>
                </tr>
                <?php /*?>
                <tr>
                    <td class="pad-top1" align="right" height="23" valign="top">How would you rate the site</td>
                    <td valign="middle" class="pad-lft5 font14" colspan="3">
                        <table border="0" cellspacing="0" cellpadding="2">
                            <tr>
                                <td>Very poor</td>
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
                                <td>&nbsp;&nbsp;Fantastic</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php */?>
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
                <tr>
                    <td class="pad-top1" align="right" valign="top">&nbsp;</td>
                    <td valign="middle" class="pad-lft5" style="padding-bottom:0px;" colspan="3">
                        <table border="0" cellspacing="0" cellpadding="2" width="100%">
                            <tr>
                                <td width="19"><input type="checkbox" class="checkbox" name="txtUserSetting" id="txtUserSettingId" value="1" <?php if(isset($_POST['txtUserSetting']) && $_POST['txtUserSetting'] == "1") {echo "checked=\"checked\"";} ?> /></td>
                                <td width="350"><?php echo tranText('i_would_like_to_receive_bestbookingsonline_com_newsletters'); ?></td>
                            </tr>
                            <tr><td colspan="2" valign="middle"><?php echo tranText('by_clicking'); ?>&nbsp;<strong><?php echo tranText('submit'); ?></strong> <?php echo tranText('you_are_agreeing_to_the'); ?> <a href="javascript:popcontact('terms.html')" class="blue-link"><?php echo tranText('terms_and_conditions'); ?></a> &nbsp;&nbsp;<span class="pdError1" id="txtTermConditionsErrorId"></span></td></tr>
                        </table>
                    </td>
                </tr>
                <tr><td colspan="4" align="right" valign="middle" class="line25">&nbsp;</td></tr>
                <tr>
                    <td align="right" valign="middle" class="pad-top15">&nbsp;</td>
                    <td valign="middle" class="pad-lft5" colspan="3">
                         <a href="#" onclick="frmReset(); void(0);" class="button-grey">Cancel</a>&nbsp;<a href="javascript:void(0);" onclick="return frmValidateContactUs();" class="button-blue">Submit</a>
                    </td>
                </tr>
            </table>
            </form>
        </td>
    </tr>
</table>
<!-- Holiday contact us Content: End Here -->
<?php
}
?>