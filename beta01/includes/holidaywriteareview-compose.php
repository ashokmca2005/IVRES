<!-- TinyMCE -->
<script type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		mode : "exact",
//		elements : "txtReviewTxtId",
//		handle_event_callback : "myHandleEvent",
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
	function ratingChk(str) {
		var rating = false;
		var array = document.getElementsByName(str);
		for(var i = 0; i < array.length; i++) {
			if (array[i].checked) {
				//alert("I am here 2");
				rating = true;
				break;
			}
		}
		return rating;
	}

	function frmValidateAddReview() {
		var shwError = false;
		if(ratingChk('txtRating') == false) {
			document.getElementById("txtRatingErrorId").innerHTML = "Please enter your rating.";
			document.frmAddReview.txtReviewTxt.focus();
			shwError = true;
		}

		//document.frmAddReview.txtReviewTxt.value = tinyMCE.get('txtReviewTxtId').getContent();
		if(document.frmAddReview.txtReviewTxt.value == "") {
			document.getElementById("txtReviewTxtErrorId").innerHTML = "Please enter review description.";
			document.frmAddReview.txtReviewTxt.focus();
			shwError = true;
		}

		if(document.frmAddReview.txtReviewTitle.value == "") {
			document.getElementById("txtReviewTitleErrorId").innerHTML = "Please enter review title.";
			document.frmAddReview.txtReviewTitle.focus();
			shwError = true;
		}

		if(document.frmAddReview.txtCountry.value == "") {
			document.getElementById("txtCountryErrorId").innerHTML = "Please select country.";
			document.frmAddReview.txtCountry.focus();
			shwError = true;
		}

		if(document.getElementById("txtUserReviewEmailId").value == "") {
			document.getElementById("txtUserReviewEmailErrorId").innerHTML = "Enter valid email address";
			document.getElementById("txtUserReviewEmailId").focus();
			shwError = true;
		} else {
			var emailRegxp = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			var txtemail = document.getElementById("txtUserReviewEmailId").value;
			if (emailRegxp.test(txtemail)!= true){
				document.getElementById("txtUserReviewEmailErrorId").innerHTML = "Enter valid email address";
				document.getElementById("txtUserReviewEmailId").value = "";
				document.getElementById("txtUserReviewEmailId").focus();
				shwError = true;
			}
		}

		if(document.frmAddReview.txtLName.value == "") {
			document.getElementById("txtLNameErrorId").innerHTML = "Please enter last name.";
			document.frmAddReview.txtLName.focus();
			shwError = true;
		}

		if(document.frmAddReview.txtFName.value == "") {
			document.getElementById("txtFNameErrorId").innerHTML = "Please enter first name.";
			document.frmAddReview.txtFName.focus();
			shwError = true;
		}

		if(shwError == true) {
			return false;
		} else {
			//document.frmAddReview.action = "holiday-events-preview.php";
			document.frmAddReview.submit();
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
        <td align="left" valign="top" class="pad-top15">
            <a href="<?php echo $review_property_link; ?>" class="blue-link">Back to property</a>
            <p> We only accept reviews of vacation rentals from people who actually stayed at that property. <br />Guest of record and date of stay will be presented to the manager to verify your stay. We will not share the content <br />or rating of the review with the manager.<br /><br />
            <p><strong>Note: </strong>if you are an owner who would like to submit reviews on behalf of guests, instead please ask your guests to <br />submit their reviews directly to rentownersvillas.com<br />
        </td>
    </tr>
    <tr>
        <td align="left" valign="top" class="pad-btm20 pad-top10">
            <form name="frmAddReview" id="frmAddReview" action="<?php echo SITE_URL; ?>holiday-write-review.php?pid=<?php echo $property_id; ?>&review=compose" method="post">
            <input type="hidden" name="securityKey" id="securityKey" value="<?php echo md5("HOLIDAYPROPERTYREVIEW")?>">
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
                    <td class="pad-top1 pad-btm15" align="right" height="23" valign="top" width="185">Property reference</td>
                    <td class="pad-btm15 pad-lft5" valign="top" colspan="3"><strong><?php echo fill_zero_left($property_id, "0", (6-strlen($property_id))).": ".ucfirst($propertyInfo['property_name']); ?></strong></td>
                </tr>
                <tr>
                    <td class="pad-top1 pad-btm15" align="right" height="23" valign="top" width="185"><?php echo tranText('first_name'); ?></td>
                    <td class="pad-btm15 pad-lft5" valign="top" width="249"><input name="txtFName" id="txtFNameId" type="text" class="inpuTxt260" value="<?php if(isset($_POST['txtFName']) && $_POST['txtFName']!=""){echo $_POST['txtFName'];} else {echo $userInfoArr['user_fname'];} ?>" onkeydown="chkblnkTxtError('txtFNameId', 'txtFNameErrorId');" onkeyup="chkblnkTxtError('txtFNameId', 'txtFNameErrorId');" /></td>
                    <td valign="top" width="10">&nbsp;</td>
                    <td class="pad-top1 pad-btm15" valign="top" width="240"><span class="pdError1" id="txtFNameErrorId"></span></td>
                </tr>
                <tr>
                    <td class="pad-top1 pad-btm15" align="right" height="23" valign="top"><?php echo tranText('last_name'); ?></td>
                    <td class="pad-btm15 pad-lft5" valign="top"><input name="txtLName" id="txtLNameId" type="text" class="inpuTxt260" value="<?php if(isset($_POST['txtLName']) && $_POST['txtLName']!=""){echo $_POST['txtLName'];} else {echo $userInfoArr['user_lname'];} ?>" onkeydown="chkblnkTxtError('txtLNameId', 'txtLNameErrorId');" onkeyup="chkblnkTxtError('txtLNameId', 'txtLNameErrorId');" /></td>
                    <td valign="top" width="9"></td>
                    <td class="pad-top1 pad-btm15" valign="top"><span class="pdError1" id="txtLNameErrorId"></span></td>
                </tr>
                <tr>
                    <td class="pad-top1 pad-btm15" align="right" height="23" valign="top"><?php echo tranText('email_address'); ?></td>
                    <td class="pad-btm15 pad-lft5" valign="top"><input name="txtUserReviewEmail" id="txtUserReviewEmailId" type="text" class="inpuTxt260" value="<?php if(isset($_POST['txtUserReviewEmail']) && $_POST['txtUserReviewEmail']!=""){echo $_POST['txtUserReviewEmail'];} else {echo $userInfoArr['user_email'];} ?>" onkeydown="chkblnkTxtError('txtUserReviewEmailId', 'txtUserReviewEmailErrorId');" onkeyup="chkblnkTxtError('txtUserReviewEmailId', 'txtUserReviewEmailErrorId');" /></td>
                    <td valign="top" width="9"></td>
                    <td class="pad-top1 pad-btm15" valign="top"><span class="pdError1" id="txtUserReviewEmailErrorId"></span></td>
                </tr>
                <tr>
                    <td class="pad-top1 pad-btm15" align="right" height="23" valign="top"><?php echo tranText('which_country_are_you_from'); ?>?</td>
                    <td class="pad-btm15 pad-lft5" valign="top">
                        <select name="txtCountry" id="txtCountryId" class="select216_0" onchange="chkblnkTxtError('txtCountryId', 'txtCountryErrorId');">
                            <option value="">Select country...</option>
                            <option value="222">United Kingdom</option>
                            <option value="223">United States</option>	
                            <option value="81">Germany</option>
                            <?php $locationObj->fun_getCountriesOptionsList($_POST['txtCountry']);?>
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
                        <textarea name="txtReviewTxt" id="txtReviewTxtId" class="textArea460"  onkeydown="chkblnkTxtError('txtReviewTxtId', 'txtReviewTxtErrorId');" onkeyup="chkblnkTxtError('txtReviewTxtId', 'txtReviewTxtErrorId');" ><?php echo $_POST['txtReviewTxt']; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td align="right" height="23" valign="top">&nbsp;</td>
                    <td colspan="3" valign="top" class="pad-btm15 pad-lft5"><span class="pdError1" id="txtReviewTxtErrorId"></span></td>
                </tr>
                <tr>
                    <td align="right" valign="top" class="pad-top2"><?php echo tranText('rate_this_property'); ?></td>
                    <td valign="top" class="pad-lft5" colspan="3">
                        <table border="0" cellspacing="0" cellpadding="2" class="font12">
                            <tr>
                                <td><?php echo tranText('very_poor'); ?></td>
                                <td class="pad-lft10">1</td>
                                <td><input type="radio" name="txtRating" id="txtRatingId1" value="1" <?php if(isset($_POST['txtRating']) && $_POST['txtRating'] == "1") {echo "checked=\"checked\"";} ?> onclick="chkblnkTxtError('txtRatingId1', 'txtRatingErrorId');" /></td>
                                <td class="pad-lft10">2</td>
                                <td><input type="radio" name="txtRating" id="txtRatingId2" value="2" <?php if(isset($_POST['txtRating']) && $_POST['txtRating'] == "2") {echo "checked=\"checked\"";} ?> onclick="chkblnkTxtError('txtRatingId2', 'txtRatingErrorId');" /></td>
                                <td class="pad-lft10">3</td>
                                <td><input type="radio" name="txtRating" id="txtRatingId3" value="3" <?php if(isset($_POST['txtRating']) && $_POST['txtRating'] == "3") {echo "checked=\"checked\"";} ?> onclick="chkblnkTxtError('txtRatingId3', 'txtRatingErrorId');" /></td>
                                <td class="pad-lft10">4</td>
                                <td><input type="radio" name="txtRating" id="txtRatingId4" value="4" <?php if(isset($_POST['txtRating']) && $_POST['txtRating'] == "4") {echo "checked=\"checked\"";} ?> onclick="chkblnkTxtError('txtRatingId4', 'txtRatingErrorId');" /></td>
                                <td class="pad-lft10">5</td>
                                <td><input type="radio" name="txtRating" id="txtRatingId5" value="5" <?php if(isset($_POST['txtRating']) && $_POST['txtRating'] == "5") {echo "checked=\"checked\"";} ?> onclick="chkblnkTxtError('txtRatingId5', 'txtRatingErrorId');" /></td>
                                <td>&nbsp;&nbsp;<?php echo tranText('fantastic'); ?></td>
                            </tr>
                        </table>
                        <span class="pdError1" id="txtRatingErrorId"></span>
                    </td>
                </tr>
                <tr>
                    <td align="right" valign="top">&nbsp;</td>
                    <td valign="top" class="pad-lft5 pad-top15" colspan="3">
                        <table border="0" cellspacing="0" cellpadding="2">
                            <tr>
                                <td width="19"><input type="checkbox" class="checkbox" name="txtUserSetting" id="txtUserSettingId" value="1" <?php if(isset($_POST['txtUserSetting']) && $_POST['txtUserSetting'] == "1") {echo "checked=\"checked\"";} ?> /></td>
                                <td width="327"><?php echo tranText('i_would_like_to_receive_bestbookingsonline_com_newsletters'); ?></td>
                            </tr>
                            <tr><td colspan="2"><?php echo tranText('by_clicking_submit_you_are_agreeing_to_our'); ?> <a href="javascript:popcontact('terms.html')" class="blue-link"><?php echo tranText('terms_and_conditions'); ?></a></td></tr>
                        </table>
                    </td>
                </tr>
                <tr><td colspan="4" align="right" valign="middle" class="line25">&nbsp;</td></tr>
                <tr>
                    <td align="right" valign="middle" class="pad-top15">&nbsp;</td>
                    <td valign="middle" class="pad-lft5" colspan="3">
                        <a href="<?php echo SITE_URL; ?>property.php?pid=<?php echo $property_id; ?>" class="button-grey" style="text-decoration:none;">Cancel</a>&nbsp;&nbsp;
                        <a href="javascript:void(0);" onclick="return frmValidateAddReview();" class="button-blue" style="text-decoration:none;">Submit</a>
                        <?php /*?>
                        <input type="submit" alt="Search" onclick="return frmValidateAddReview();" class="button85x30" value="Submit"/>
                        <a href="<?php echo SITE_URL; ?>property.php?pid=<?php echo $property_id; ?>" style="text-decoration:none;"><img src="images/cancel-gray.gif" alt="Cancel" width="72" height="27" /></a>&nbsp;<input src="<?php echo SITE_IMAGES;?>submit.gif" onclick="return frmValidateAddReview();" alt="Submit" type="image">
                        <?php */?>
                    </td>
                </tr>
            </table>
            </form>
        </td>
    </tr>
</table>
