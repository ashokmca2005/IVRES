<?php
// Form submision
$detail_array 	= array();
$error_msg		= 'no';
if($_POST['securityKey']==md5(TESTIQUOTEREJECT)){
	if(isset($_POST['txtTestimonialId']) && $_POST['txtTestimonialId'] != "") {
		$testimonial_id = $_POST['txtTestimonialId'];
		if(!empty($_POST['txtDeclineId'])){
			$testimonialInfoArr	  = $testiObj->fun_getTestimonialInfo($testimonial_id);
			$testimonial_id 	 = $testimonialInfoArr['testimonial_id'];
			$ownerArr 			= $testiObj->fun_getTestimonialUserInfo($testimonial_id);
			$owner_fname 		= $ownerArr['user_fname'];
			$owner_lname 		= $ownerArr['user_lname'];
	 		$owner_email 		= trim($ownerArr['user_email']);

			$strMessage = "";
$strMessage .= '<table width="70%"  border="0" cellspacing="10" cellpadding="0">
<tr><td align="center">&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;Hi,</td></tr>
<tr><td>'.trim(ucfirst($owner_fname." ".$owner_lname)).' </td></tr>
<tr><td>&nbsp;Please find reason for decline of your added below:-</td></tr>';
$txtDeclineId = $_POST['txtDeclineId'];
for($i = 0; $i < count($txtDeclineId); $i++) {
	$section_id = $txtDeclineId[$i];
	if($section_id == "1") {
		$strMessage .= '<tr><td><b>Inappropriate content for our site</b></td></tr>';
	} else if($section_id == "2") {
		$strMessage .= '<tr><td><b>Inappropriate picture</b></td></tr>';
	}  else if($section_id == "3") {
		$strMessage .= '<tr><td><b>Picture quality and/or cropping is of poor quality</b></td></tr>';
	} else if($section_id == "4") {
		$strMessage .= '<tr><td><b>Information is confusing</b></td></tr>';
	} else if($section_id == "5") {
		$reason_note 	= $_POST['other_reason'];
		$strMessage .= '<tr><td><b>'.$reason_note.'</b></td></tr>';
	}
}
$strMessage .= '<tr><td>&nbsp;Best Regards,</td></tr>
<tr><td>&nbsp;searchresortrentals.com Team Member</td></tr>	  
</table>';
			require_once("includes/classes/class.Email.php");
			$emailObj = new Email($owner_email , "Manager | rentownersvillas.com <".SITE_INFO_EMAIL.">", "Event Decline mail", $strMessage);
			//$emailObj = new Email($owner_email , SITE_INFO_EMAIL, "Event Decline mail", $strMessage);
			$emailObj->sendEmail();
		}
		$testiObj->fun_delTestimonial($testimonial_id);
	}
	echo "<script> location.href='admin-collateral.php?sec=quote';</script>";
}


if($_POST['securityKey']==md5(REVIEWDELETE)){
	if(isset($_POST['txtTestimonialId']) && $_POST['txtTestimonialId'] != "") {
		$testimonial_id = $_POST['txtTestimonialId'];
		$testiObj->fun_delTestimonial($testimonial_id);
	}
	echo "<script> location.href='admin-collateral.php?sec=quote';</script>";
}

if($_POST['securityKey']==md5(ADDTESTIMONIAL)){		
	$testimonial_id 		= trim($_POST['txtTestimonialId']);
	$txtTestimonialStatusId = trim($_POST['txtTestimonialStatusId']);
	$txtFName 				= trim($_POST['txtFName']);
	$txtLName 				= trim($_POST['txtLName']);
	$txtEmail 				= trim($_POST['txtEmail']);
	$txtCountry 			= trim($_POST['txtCountry']);
	$txtReviewTitle 		= trim($_POST['txtReviewTitle']);
	$txtReviewTxt 			= trim($_POST['txtReviewTxt']);
	$txtRating 				= trim($_POST['txtRating']);
	$txtUserSetting 		= trim($_POST['txtUserSetting']);

	if($error_msg == 'no') {
		$testimonial_id		= $testiObj->fun_editTestimonial($testimonial_id, $txtReviewTitle, $txtReviewTxt, $txtRating, $txtFName, $txtLName, $txtEmail, $txtCountry, $txtTestimonialStatusId);
		if($testimonial_id){
			echo "<script>location.href = window.location;</script>";
		} else {
			$detail_array['error_msg'] = "Error: We are unable to add your review!";
		}
	} else {
		$detail_array['error_msg'] = "Please submit your form again!";
	}
}

if(isset($testimonial_id) && $testimonial_id !=""){
$testimonialInfoArr 	= $testiObj->fun_getTestimonialInfo($testimonial_id);
//print_r($testimonialInfoArr);
?>
<!-- TinyMCE -->
<script type="text/javascript" src="../tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		mode : "exact",
		elements : "txtReviewTxtId",
		handle_event_callback : "myHandleEvent",
		theme : "simple"
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
	var req = ajaxFunction();
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

	/*
	* For Review pending - approval section : Start here
	*/
	function sbmtReviewApproval(strId){
		var strId = strId;
		req.open('get', 'includes/ajax/admin-testimonial-pending-approvalXml.php?testid=' + strId + '&mode=approve'); 
		req.onreadystatechange = handleApprovalResponse; 
		req.send(null); 
	}

	function sbmtReviewDecline(strId){
		document.getElementById("showDeclineReasonId").style.display = "block";
		var strId = strId;
		req.open('get', 'includes/ajax/admin-testimonial-pending-approvalXml.php?testid=' + strId + '&mode=decline'); 
		req.onreadystatechange = handleApprovalResponse; 
		req.send(null); 
	}

	function sbmtReviewSuspend(strId){
		var strId = strId;
		req.open('get', 'includes/ajax/admin-testimonial-pending-approvalXml.php?testid=' + strId + '&mode=suspend'); 
		req.onreadystatechange = handleApprovalResponse; 
		req.send(null); 
	}

	function sbmtReviewDelete(){
		document.getElementById("securityKey").value = "<?php echo md5('REVIEWDELETE')?>";
		document.frmAddTestimonial.submit();
	}
	
	function sbmttestiquoteReject(){
		if(document.getElementById("txtDeclineId5").checked && document.getElementById("other_reason").value != ""){
			document.getElementById("txtDeclineId1").checked = false;
			document.getElementById("txtDeclineId2").checked = false;
			document.getElementById("txtDeclineId3").checked = false;
			document.getElementById("txtDeclineId4").checked = false;

			document.getElementById("securityKey").value = "<?php echo md5('TESTIQUOTEREJECT')?>";
			document.frmAddTestimonial.submit();
		} else if(document.getElementById("txtDeclineId1").checked || document.getElementById("txtDeclineId2").checked || document.getElementById("txtDeclineId3").checked || document.getElementById("txtDeclineId4").checked) {
			document.getElementById("securityKey").value = "<?php echo md5('TESTIQUOTEREJECT')?>";
			document.frmAddTestimonial.submit();
		} else {
			return false;
		}
	}

	function handleApprovalResponse() { 
		if(req.readyState == 4){ 
			var response = req.responseText; 
			xmlDoc=req.responseXML;
			var root = xmlDoc.getElementsByTagName('reviews')[0];
			if(root != null){
				var items = root.getElementsByTagName("review");
				var item = items[0];
				var reviewstatus = item.getElementsByTagName("reviewstatus")[0].firstChild.nodeValue;
				if(reviewstatus == "Approved"){
					document.getElementById("txtAdminOptionId").innerHTML 	= "<font color='#FFFFFF' size='2'><strong>"+reviewstatus+"</strong></font>";
				}
				else if(reviewstatus == "Declined"){
					document.getElementById("txtAdminOptionId").innerHTML 	= "<font color='#FFFFFF' size='2'><strong>"+reviewstatus+"</strong></font>";
				}
				else if(reviewstatus == "Suspended"){
					document.getElementById("txtAdminOptionId").innerHTML 	= "<font color='#FFFFFF' size='2'><strong>"+reviewstatus+"</strong></font>";
				}
				else{
					document.getElementById("txtAdminOptionId").innerHTML 	= "<font color='#FFFFFF' size='2'><strong>Error, try later!</strong></font>";
				}
			}
			else{
				document.getElementById("txtAdminOptionId").innerHTML 	= "<font color='#FFFFFF' size='2'><strong>Error, try later!</strong></font>";
			}
		} 
		else{
			document.getElementById("txtAdminOptionId").innerHTML 	= "<font color='#FFFFFF' size='2'><strong>Please wait...</strong></font>";
		}
	} 
	/*
	* For Review pending - approval section : End here
	*/
			function unCheckOthers() {
		if(document.getElementById("txtDeclineId5").checked){
			document.getElementById("txtDeclineId1").checked = false;
			document.getElementById("txtDeclineId2").checked = false;
			document.getElementById("txtDeclineId3").checked = false;
			document.getElementById("txtDeclineId4").checked = false;
		}
	}

</script>
<form name="frmAddTestimonial" id="frmAddTestimonial" action="admin-collateral.php?sec=quote&testid=<?php echo $testimonialInfoArr['testimonial_id']; ?>" method="post">
<input type="hidden" name="securityKey" id="securityKey" value="<?php echo md5("ADDTESTIMONIAL")?>">
<input type="hidden" name="txtTestimonialId" id="txtTestimonialId" value="<?php echo $testimonialInfoArr['testimonial_id']; ?>">
<input type="hidden" name="txtTestimonialStatusId" id="txtTestimonialStatusId" value="<?php echo $testimonialInfoArr['status']; ?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr><td height="10" colspan="2" valign="top">&nbsp;</td></tr>
    <tr>
        <td valign="top"><a href="admin-collateral.php?sec=quote" class="back">Back to List</a></td>
        <td align="right" valign="top">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2" valign="top" class="pad-top5">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                <tr>
                    <td valign="top" class="pad-top7">
                        <table width="690" border="0" cellspacing="0" cellpadding="0" class="font12">
                            <tr>
                                <td align="left" valign="top">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="10" class="eventForm">
                                        <tr>
                                            <td colspan="2" align="right" valign="top" class="header">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td>
														<div id="txtAdminOptionId">
														<?php 
															if($testimonialInfoArr['status'] == "0" || $testimonialInfoArr['status'] == "1" || $testimonialInfoArr['status'] == "3" || $testimonialInfoArr['status'] == "4") {
														?>
															<a href="javascript:showField('txtshwRjctTblId');" style="text-decoration:none;"><img src="images/rejectN.png" alt="Delete" width="71" height="21" border="0" /></a>&nbsp;<a href="javascript:sbmtReviewApproval(<?php echo $testimonialInfoArr['testimonial_id']; ?>);" style="text-decoration:none;"><img src="images/approveN.png" alt="Approve" width="71" height="21" border="0" /></a>&nbsp;<a href="javascript:sbmtReviewDelete();" style="text-decoration:none;"><img src="images/DeleteN.png" alt="Delete" width="60" height="21" /></a>
														<?php
															} else {
														?>
															<a href="javascript:sbmtReviewDelete();" style="text-decoration:none;"><img src="images/DeleteN.png" alt="Delete" width="60" height="21" /></a>&nbsp;<a href="javascript:sbmtReviewSuspend(<?php echo $testimonialInfoArr['testimonial_id']; ?>);" style="text-decoration:none;"><img src="images/suspendN.png" alt="Suspend" width="74" height="21" /></a>
														<?php
															}
														?>
														</div>
														</td>
<!--                                                        <td align="right" valign="bottom"><img src="images/previousN.png" alt="Preview" width="74" height="21" /> <img src="images/nextN.png" alt="Cancel" width="48" height="21" /></td>
-->                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" valign="top" style="padding:0px;">
												<table width="100%" border="0" cellspacing="0" cellpadding="2" bgcolor="#f5f5f5" id="txtshwRjctTblId" style="display:none;">
													<tr><td colspan="2" class="blackTxt14 pad-btm10 pad-lft10">Reason for rejection</td></tr>
													<tr>
														<td width="15" class="pad-lft10"><input name="txtDeclineId[]" type="checkbox" class="checkbox" id="txtDeclineId1" value="1" /></td>
														<td>Inappropriate content for our site</td>
													</tr>
													<tr>
														<td width="15"  class="pad-lft10"><input  name="txtDeclineId[]" type="checkbox" class="checkbox" id="txtDeclineId2" value="2" /></td>
														<td>Inappropriate picture</td>
													</tr>
													<tr>
														<td width="15" class="pad-lft10"><input  name="txtDeclineId[]" type="checkbox" class="checkbox" id="txtDeclineId3" value="3" /></td>
														<td>Picture quality and/or cropping is of poor quality</td>
													</tr>
													<tr>
														<td width="15" class="pad-lft10"><input  name="txtDeclineId[]" type="checkbox" class="checkbox" id="txtDeclineId4" value="4" /></td>
														<td>Information is confusing / dosen't make sense</td>
													</tr>
													<tr>
														<td width="15"  class="pad-lft10"><input  name="txtDeclineId[]" type="checkbox" class="checkbox" id="txtDeclineId5" value="5" onclick="unCheckOthers()" /></td>
														<td>
															<span class="FloatLft">Other, specify reason...</span>
															<span class="FloatLft pad-left12"><input name="other_reason" id="other_reason" class="inpuTxt510" value="" type="text" /></span>
                                                        </td>
													</tr>
													<tr>
														<td colspan="2" class="pad-top10 pad-lft10">
															<a href="javascript:hideField('txtshwRjctTblId');" style="text-decoration:none;"><img src="images/cancelN.png" alt="Cancel" width="66" height="21" /></a>&nbsp;
                                                            <a href="javascript:sbmttestiquoteReject();" style="text-decoration:none;"><img src="images/send.png" alt="Cancel" width="66" height="21" /></a>
                                                        </td>
													</tr>
												</table>
											</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" align="right" valign="top" class="header">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td>
                                                            Reference ID : <?php echo fill_zero_left($testimonialInfoArr['testimonial_id'], "0", (6-strlen($testimonialInfoArr['testimonial_id'])));?>
                                                        </td>
                                                        <td align="right" valign="bottom"><a href="admin-pending-approval.php?sec=review" style="text-decoration:none;"><img src="images/cancelChangesN.png" alt="Cancel" width="119" height="21" border="0" /></a>&nbsp;<a href="javascript:void(0);" onclick="frmValidateAddReview();" style="text-decoration:none;"><img src="images/saveChangesN.png" alt="Save Approve" width="108" height="21" border="0" /></a></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="23"  align="right" valign="top" class="admleftBg">Last name</td>
                                            <td  valign="top"><input name="txtFName" id="txtFNameId" type="text" class="inpuTxt260" value="<?php echo $testimonialInfoArr['user_fname']; ?>" onkeydown="chkblnkTxtError('txtFNameId', 'txtFNameErrorId');" onkeyup="chkblnkTxtError('txtFNameId', 'txtFNameErrorId');" /><span class="pdError1 pad-lft10" id="txtFNameErrorId"></span></td>
                                        </tr>
                                        <tr>
                                            <td height="23"  align="right" valign="top" class="admleftBg">First name</td>
                                            <td  valign="top"><input name="txtLName" id="txtLNameId" type="text" class="inpuTxt260" value="<?php echo $testimonialInfoArr['user_lname']; ?>" onkeydown="chkblnkTxtError('txtLNameId', 'txtLNameErrorId');" onkeyup="chkblnkTxtError('txtLNameId', 'txtLNameErrorId');" /><span class="pdError1 pad-lft10" id="txtLNameErrorId"></span></td>
                                        </tr>
                                        <tr>
                                            <td height="23"  align="right" valign="top" class="admleftBg">Email address</td>
                                            <td  valign="top"><input name="txtEmail" id="txtEmailId" type="text" class="inpuTxt260" value="<?php echo $testimonialInfoArr['user_email']; ?>" onkeydown="chkblnkTxtError('txtEmailId', 'txtEmailErrorId');" onkeyup="chkblnkTxtError('txtEmailId', 'txtEmailErrorId');" /><span class="pdError1 pad-lft10" id="txtEmailErrorId"></span></td>
                                        </tr>
                                        <tr>
                                            <td height="23"  align="right" valign="top" class="admleftBg">Which country are you from?</td>
                                            <td  valign="top">
                                                <select name="txtCountry" id="txtCountryId" class="select216_0" onchange="chkblnkTxtError('txtCountryId', 'txtCountryErrorId');">
                                                    <option value="">Select country...</option>
                                                    <option value="193">Spain</option>							
                                                    <option value="222">United Kingdom</option>
                                                    <option value="223">United States</option>	
                                                    <option value="81">Germany</option>
                                                    <?php $locationObj->fun_getCountriesOptionsList($testimonialInfoArr['user_country']);?>
                                                </select>
                                                <span class="pdError1" id="txtCountryErrorId"></span>                                            
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="23"  align="right" valign="top" class="admleftBg">Title of your review</td>
                                            <td  valign="top">
												<textarea name="txtReviewTitle" id="txtReviewTitleId" class="textArea260"  onkeydown="chkblnkTxtError('txtReviewTitleId', 'txtReviewTitleErrorId');" onkeyup="chkblnkTxtError('txtReviewTitleId', 'txtReviewTitleErrorId');" ><?php echo $testimonialInfoArr['testimonial_name']; ?></textarea>
                                                <span class="pdError1 pad-lft10" id="txtReviewTitleErrorId"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="23"  align="right" valign="top" class="admleftBg">Write your review</td>
                                            <td  valign="top">
                                                <textarea name="txtReviewTxt" id="txtReviewTxtId" class="textArea460" ><?php echo $testimonialInfoArr['testimonial_description']; ?></textarea>
                                                <br /><br />
                                                <span class="pdError1 pad-lft10" id="txtReviewTxtErrorId"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="23"  align="right" valign="top" class="admleftBg">How would you rate the site</td>
                                            <td  valign="top">
                                                <table border="0" cellspacing="0" cellpadding="2">
                                                    <tr>
                                                        <td>Very poor</td>
                                                        <td class="pad-lft10">1</td>
                                                        <td><input type="radio" name="txtRating" id="txtRatingId1" value="1" <?php if(isset($testimonialInfoArr['site_rating']) && $testimonialInfoArr['site_rating'] == "1") {echo "checked=\"checked\"";} ?> /></td>
                                                        <td class="pad-lft10">2</td>
                                                        <td><input type="radio" name="txtRating" id="txtRatingId2" value="2" <?php if(isset($testimonialInfoArr['site_rating']) && $testimonialInfoArr['site_rating'] == "2") {echo "checked=\"checked\"";} ?> /></td>
                                                        <td class="pad-lft10">3</td>
                                                        <td><input type="radio" name="txtRating" id="txtRatingId3" value="3" <?php if(isset($testimonialInfoArr['site_rating']) && $testimonialInfoArr['site_rating'] == "3") {echo "checked=\"checked\"";} ?> /></td>
                                                        <td class="pad-lft10">4</td>
                                                        <td><input type="radio" name="txtRating" id="txtRatingId4" value="4" <?php if(isset($testimonialInfoArr['site_rating']) && $testimonialInfoArr['site_rating'] == "4") {echo "checked=\"checked\"";} ?> /></td>
                                                        <td class="pad-lft10">5</td>

                                                        <td><input type="radio" name="txtRating" id="txtRatingId5" value="5" <?php if(isset($testimonialInfoArr['site_rating']) && $testimonialInfoArr['site_rating'] == "5") {echo "checked=\"checked\"";} ?> /></td>
                                                        <td>&nbsp;&nbsp;Fantastic</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
										<tr>
											<td colspan="2" align="right" valign="top" class="header">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td>Reference ID : <?php echo fill_zero_left($testimonialInfoArr['testimonial_id'], "0", (6-strlen($testimonialInfoArr['testimonial_id'])));?></td>
														<td align="right" valign="bottom"><a href="admin-collateral.php?sec=quote" style="text-decoration:none;"><img src="images/cancelChangesN.png" alt="Cancel" width="119" height="21" /></a>&nbsp;<a href="javascript:void(0);" onclick="frmValidateAddReview();" style="text-decoration:none;"><img src="images/saveChangesN.png" alt="Save Approve" width="108" height="21" border="0" /></a></td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr><td valign="top">&nbsp;</td></tr>
                <tr><td valign="top">&nbsp;</td></tr>
            </table>
        </td>
    </tr>
</table>
</form>
<?php
} else {
	if(isset($_GET['sortby']) && $_GET['sortby'] != ""){
		$strQuery = " ORDER BY ";
		switch($_GET['sortby']){
			case 'reviewcode':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$reviewcodedr 		= 0;
					$reviewtitledr		= 1;
					$reviewusrdr 		= 1;
					$reviewaddeddatedr 	= 1;
					$reviewstatusdr 	= 1;
				} else {
					$dr = "DESC";
					$reviewcodedr 		= 1;
					$reviewtitledr		= 1;
					$reviewusrdr 		= 1;
					$reviewaddeddatedr 	= 1;
					$reviewstatusdr 	= 1;
				}
				$strQuery .= " A.testimonial_id ".$dr;
			break;
			case 'reviewtitle':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$reviewcodedr 		= 1;
					$reviewtitledr		= 0;
					$reviewusrdr 		= 1;
					$reviewaddeddatedr 	= 1;
					$reviewstatusdr 	= 1;
				} else {
					$dr = "DESC";
					$reviewcodedr 		= 1;
					$reviewtitledr		= 1;
					$reviewusrdr 		= 1;
					$reviewaddeddatedr 	= 1;
					$reviewstatusdr 	= 1;
				}
				$strQuery .= " A.testimonial_name ".$dr;
			break;
			case 'reviewusr':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$reviewcodedr 		= 1;
					$reviewtitledr		= 1;
					$reviewusrdr 		= 0;
					$reviewaddeddatedr 	= 1;
					$reviewstatusdr 	= 1;
				} else {
					$dr = "DESC";
					$reviewcodedr 		= 1;
					$reviewtitledr		= 1;
					$reviewusrdr 		= 1;
					$reviewaddeddatedr 	= 1;
					$reviewstatusdr 	= 1;
				}
				$strQuery .= " A.user_fname ".$dr;
			break;
			case 'reviewaddeddate':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$reviewcodedr 		= 1;
					$reviewtitledr		= 1;
					$reviewusrdr 		= 1;
					$reviewaddeddatedr 	= 0;
					$reviewstatusdr 	= 1;
				} else {
					$dr = "DESC";
					$reviewcodedr 		= 1;
					$reviewtitledr		= 1;
					$reviewusrdr 		= 1;
					$reviewaddeddatedr 	= 1;
					$reviewstatusdr 	= 1;
				}
				$strQuery .= " A.created_on ".$dr;
			break;
			case 'reviewstatus':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$reviewcodedr 		= 1;
					$reviewtitledr		= 1;
					$reviewusrdr 		= 1;
					$reviewaddeddatedr 	= 1;
					$reviewstatusdr 	= 0;
				} else {
					$dr = "DESC";
					$reviewcodedr 		= 1;
					$reviewtitledr		= 1;
					$reviewusrdr 		= 1;
					$reviewaddeddatedr 	= 1;
					$reviewstatusdr 	= 1;
				}
				$strQuery .= " A.status ".$dr;
			break;
		}
	}
	else{
		$reviewcodedr 		= 1;
		$reviewtitledr		= 1;
		$reviewusrdr 		= 1;
		$reviewaddeddatedr 	= 1;
		$reviewstatusdr 	= 1;
	}


	$testimonialsListArr = $testiObj->fun_getPendingApprovalTestimonialsArr($strQuery);
	//print_r($testimonialsListArr);
	if(count($testimonialsListArr) > 0){
	?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr><td colspan="2" valign="top">&nbsp;</td></tr>
			<tr>
				<td colspan="2" valign="top">
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EventListing">
						<thead>
							<tr>
								<th width="10%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=review&sortby=reviewcode&dr=".$reviewcodedr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "reviewcode")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?> ><div>ID</div></th>
								<th width="30%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=review&sortby=reviewtitle&dr=".$reviewtitledr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "reviewtitle")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Title</div></th>
								<th width="30%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=review&sortby=reviewusr&dr=".$reviewusrdr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "reviewusr")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?> ><div>Submitted by</div></th>
								<th width="15%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=review&sortby=reviewaddeddate&dr=".$reviewaddeddatedr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "reviewaddeddate")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Added Date</div></th>
								<th width="15%" scope="col" class="right" onmouseover="this.className = 'rightOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=review&sortby=reviewstatus&dr=".$reviewstatusdr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "reviewstatus")){echo "class=\"rightOver\" onmouseout=\"this.className = 'rightOver';\" ";}else{echo "onmouseout=\"this.className = 'right';\"";}?>><div>Status</div></th>
							</tr>
						</thead>
						<tbody>
							<?php
                            for($i=0; $i < count($testimonialsListArr); $i++){
                            $testimonial_id 	= $testimonialsListArr[$i]['testimonial_id'];
                            $site_rating		= $testimonialsListArr[$i]['site_rating'];
                            $testimonial_name 	= $testimonialsListArr[$i]['testimonial_name'];
                            $user_fname 		= $testimonialsListArr[$i]['user_fname'];
                            $user_lname 		= $testimonialsListArr[$i]['user_lname'];
							$user_email 		= $testimonialsListArr[$i]['user_email'];
							$user_country		= $testimonialsListArr[$i]['user_country'];
							$status				= $testimonialsListArr[$i]['status'];
							$status_name		= $testimonialsListArr[$i]['status_name'];
							$created_on 		= date('M d, Y', $testimonialsListArr[$i]['created_on']);
                            $active 			= $testimonialsListArr[$i]['active'];
                            ?>
                                <tr>
                                    <td class="left"><a href="admin-collateral.php?sec=quote&testid=<?php echo $testimonial_id;?>"><?php echo fill_zero_left($testimonial_id, "0", (6-strlen($testimonial_id)));?></a></td>
                                    <td><?php echo $testimonial_name;?></td>
                                    <td><?php echo $user_fname." ".$user_lname;?></td>
                                    <td><?php echo $created_on;?></td>
                                    <td class="right"><?php echo ucfirst($status_name);?></td>
                                </tr>
                            <?php
                            }
                            ?>
						</tbody>
					</table>
				</td>
			</tr>
			<tr><td colspan="2" valign="top">&nbsp;</td></tr>
		</table>
	<?php
	} else {
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td valign="top">No review Added!</td>
			</tr>
		</table>
		<?php
	}
}
?>