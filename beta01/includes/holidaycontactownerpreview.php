<?php
if(isset($enquiry_id) && $enquiry_id !="") {
	// get enquiry details
	$enquiryInfoArr = $propertyObj->fun_getPropertyEnquiryInfo($enquiry_id);
	//print_r($enquiryInfoArr);
	if(is_array($enquiryInfoArr) && count($enquiryInfoArr) > 0) {
			$txtUserPhone 			= $enquiryInfoArr['phone'];
			$txtAdults 				= $enquiryInfoArr['adults'];
			$txtChilds 				= $enquiryInfoArr['childs'];
			$txtInfants 			= $enquiryInfoArr['infants'];
			$travelArr = array();
			if(isset($txtAdults) && $txtAdults > 0) {
				array_push($travelArr, ($txtAdults > 1)?$txtAdults." adults":$txtAdults." adult");
			}
			if(isset($txtChilds) && $txtChilds > 0) {
				array_push($travelArr, ($txtChilds > 1)?$txtChilds." children":$txtChilds." children");
			}
			if(isset($txtInfants) && $txtInfants > 0) {
				array_push($travelArr, ($txtInfants > 1)?$txtInfants." infants":$txtInfants." infant");
			}
	
			$txtArriavalDate 		= $enquiryInfoArr['arrival_date'];
			/*
			$arriavalDateArr 		= explode("-", $txtArriavalDate);
			$txtDayArrival0 		= $arriavalDateArr[2];
			$txtMonthArrival0 		= $arriavalDateArr[1];
			$txtYearArrival0 		= $arriavalDateArr[0];
			*/			
			$txtDepartureDate 		= $enquiryInfoArr['departure_date'];
			/*
			$departureDateArr 		= explode("-", $txtDepartureDate);
			$txtDayDeparture0 		= $departureDateArr[2];
			$txtMonthDeparture0 	= $departureDateArr[1];
			$txtYearDeparture0 		= $departureDateArr[0];
			$txtDepartDateTime		= mktime(0,0,0,$txtMonthDeparture0, $txtDayDeparture0, $txtYearDeparture0);
			*/			

			$txtDuration 			= $enquiryInfoArr['duration'];
			$txtFlexibleDays 		= $enquiryInfoArr['flexi_day'];
			$txtUserEnquiry 		= $enquiryInfoArr['enquiry_txt'];
			$txtCreatedOn	 		= $enquiryInfoArr['created_on'];
	
	// User details
			$enquiryUserInfoArr 	= $usersObj->fun_getUserEnquiryInfo($enquiry_id);
	//		print_r($enquiryUserInfoArr);
			$txtUserFName 			= $enquiryUserInfoArr['user_fname'];
			$txtUserLName 			= $enquiryUserInfoArr['user_lname'];
			$txtUserEmail 			= $enquiryUserInfoArr['user_email'];
			$txtUserName			= $txtUserFName." ".$txtUserLName;
	
	// Property details
			$enquiryPropertyInfoArr = $propertyObj->fun_getPropertyEnquiryRelationInfo($enquiry_id, '');
			$txtPropertyIdArr 		= array();
			foreach($enquiryPropertyInfoArr as $value) {
				array_push($txtPropertyIdArr, $value['property_id']);
			}
			$txtPropertyId 			= implode(",", $txtPropertyIdArr);
	//		echo $txtPropertyId;
	//		print_r($enquiryPropertyInfoArr);
	}
?>
<script language="javascript" type="text/javascript">
	var req = ajaxFunction();
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

	function cancelEnquiry(strEnquiryId) {
		req.onreadystatechange = handleDeleteEnquiryResponse;
		req.open('get', '<?php echo SITE_URL;?>enquirydeleteXml.php?enquiry='+strEnquiryId); 
		req.send(null);   
	}

	function validateSendEnquiry() {
		document.getElementById("txtSendMailId").value = 1;
		document.frmPropertyContactOwner.submit();
	}

	function editEnquiry(strEnquiryId) {
		window.location = 'holiday-contact-owner-edit.php?enquiry='+strEnquiryId;
	}

	function handleDeleteEnquiryResponse() {
		if(req.readyState == 4) {
			var response=req.responseText;
			xmlDoc=req.responseXML;
			var root = xmlDoc.getElementsByTagName('enquiries')[0];
			if(root != null){
				var items = root.getElementsByTagName("enquiry");
                var item = items[0];
                var enquirystatus = item.getElementsByTagName("enquirystatus")[0].firstChild.nodeValue;
                if(enquirystatus == "Enquiry deleted.") {
                    window.location = '<?php if(isset($_SESSION['ses_user_home']) && $_SESSION['ses_user_home'] !=""){echo $_SESSION['ses_user_home'];} else {echo SITE_URL;}?>';
                }
			}
		}
	}
</script>
<table width="690" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr>
        <td align="left" valign="top">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <td valign="top" class="pad-rgt10 pad-btm20">
                        <div class="gradientBox690" style="margin-top:15px; margin-bottom:5px;">
                            <div class="top">
                                <div class="btm">
                                    <div class="content">
                                        <table width="100%" border="0" cellpadding="2" cellspacing="0">
                                            <tr><td colspan="2" align="left" valign="top"><span class="pink16">Is your email address correct?</span>&nbsp;&nbsp;<a href="javascript:void(0);" class="blue-link"><strong><?php echo $txtUserEmail; ?></strong></a></td></tr>
                                            <tr><td colspan="2" align="left" valign="top" class="pad-btm3">If it's wrong then click <a href="javascript:editEnquiry(<?php echo $enquiry_id; ?>);" class="blue-link">edit</a> to change it, otherwise the owners won't be able to contact you!</td></tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="pad-rgt10">
                        <form name="frmPropertyContactOwner" id="frmPropertyContactOwner" method="post" action="holiday-contact-owner-preview.php">
                        <input type="hidden" name="securityKey" value="<?php echo md5(OWNERCONTACT); ?>" />
                        <input type="hidden" name="txtPropertyId" value="<?php echo $txtPropertyId; ?>" />
                        <input type="hidden" name="txtUserName" id="txtUserNameId" value="<?php echo $txtUserName; ?>" />
                        <input type="hidden" name="txtUserFName" id="txtUserFNameId" value="<?php echo $txtUserFName; ?>" />
                        <input type="hidden" name="txtUserLName" id="txtUserLNameId" value="<?php echo $txtUserLName; ?>" />
                        <input type="hidden" name="txtUserEmail" id="txtUserEmailId" value="<?php echo $txtUserEmail; ?>" />
                        <input type="hidden" name="txtUserPhone" id="txtUserPhoneId" value="<?php echo $txtUserPhone; ?>" />
                        <input type="hidden" name="txtAdults" id="txtAdultsId" value="<?php echo $txtAdults; ?>" />
                        <input type="hidden" name="txtChilds" id="txtChildsId" value="<?php echo $txtChilds; ?>" />
                        <input type="hidden" name="txtInfants" id="txtInfantsId" value="<?php echo $txtInfants; ?>" />
                        <input type="hidden" name="txtArrival" id="txtArrival" value="<?php echo $txtArriavalDate; ?>" />
                        <input type="hidden" name="txtDeparture" id="txtDeparture" value="<?php echo $txtDepartureDate; ?>" />

						<?php /*?>
                        <input type="hidden" name="txtDayArrival0" id="txtDayArrival0Id" value="<?php echo $txtDayArrival0; ?>" />
                        <input type="hidden" name="txtMonthArrival0" id="txtMonthArrival0Id" value="<?php echo $txtMonthArrival0; ?>" />
                        <input type="hidden" name="txtYearArrival0" id="txtYearArrival0Id" value="<?php echo $txtYearArrival0; ?>" />
                        <input type="hidden" name="txtDayDeparture0" id="txtDayDeparture0Id" value="<?php echo $txtDayDeparture0; ?>" />
                        <input type="hidden" name="txtMonthDeparture0" id="txtMonthDeparture0Id" value="<?php echo $txtMonthDeparture0; ?>" />
                        <input type="hidden" name="txtYearDeparture0" id="txtYearDeparture0Id" value="<?php echo $txtYearDeparture0; ?>" />
						<?php */?>

                        <input type="hidden" name="txtDuration" id="txtDurationId" value="<?php echo $txtDuration; ?>" />
                        <input type="hidden" name="txtFlexibleDays" id="txtFlexibleDaysId" value="<?php echo $txtFlexibleDays; ?>" />
                        <input type="hidden" name="txtUserEnquiry" id="txtUserEnquiryId" value="<?php echo $txtUserEnquiry; ?>" />
                        <input type="hidden" name="txtNewLetter" id="txtNewLetterId" value="<?php echo $txtNewLetter; ?>" />
                        <input type="hidden" name="txtSendMail" id="txtSendMailId" value="0" />
                        <?php
						if(isset($enquiry_id) && $enquiry_id != "") {
							echo "<input type=\"hidden\" name=\"txtEnquiryId\" id=\"txtEnquiryId\" value=\"".$enquiry_id."\" />";
						}
						?>

                        <table width="100%" border="0" cellpadding="5" cellspacing="0">
                            <tr><td colspan="2" align="left" valign="middle" class="pad-btm20"><span class="gray18">Your enquiry is as follows</span></td></tr>
<?php
if(is_array($enquiryPropertyInfoArr) && count($enquiryPropertyInfoArr) > 0) {
	$char = 'a';
	for($i = 0; $i < count($enquiryPropertyInfoArr); $i++) {
		$property_id 	= $enquiryPropertyInfoArr[$i]['property_id'];
		$property_name 	= $enquiryPropertyInfoArr[$i]['property_name'];
		$property_title	= $enquiryPropertyInfoArr[$i]['property_title'];

		$propLocInfoArr 	= $propertyObj->fun_getPropertyLocInfoArr($property_id);
		$fr_url 			= $propertyObj->fun_getPropertyFriendlyLink($property_id);
		if(isset($fr_url) && $fr_url != "") {
			$property_link = SITE_URL."vacation-rentals/".strtolower($property_id);
		} else {
			if(isset($propLocInfoArr['location_name']) && $propLocInfoArr['location_name'] != "") {
				$property_link = SITE_URL."vacation-rentals/in.".str_replace(" ", "^", strtolower($propLocInfoArr['location_name']))."/".fill_zero_left($property_id, "0", (6-strlen($property_id)));
			} else {
				$property_link = SITE_URL."vacation-rentals/in.".str_replace(" ", "^", strtolower($propLocInfoArr['region_name']))."/".fill_zero_left($property_id, "0", (6-strlen($property_id)));
			}
		}

		echo "<tr>";
		//Property Image : Start here
		echo "<td width=\"155\" align=\"right\" valign=\"top\">";
		$propertyMImgInfo	= $propertyObj->fun_getPropertyMainThumb($property_id);
		if(is_array($propertyMImgInfo) && count($propertyMImgInfo) > 0) {
			$imgid 		= $propertyMImgInfo[0]['photo_id'];
			$imgcap 	= ucfirst($propertyMImgInfo[0]['photo_caption']);
			$imgcap		= addslashes($imgcap);
			$imgthumb 	= PROPERTY_IMAGES_THUMB168x126.$propertyMImgInfo[0]['photo_thumb'];
			echo "<img src=\"gd1.php?img_name=".$imgthumb."&w=168&h=126\" alt=\"".$imgcap."\" width=\"168\" height=\"126\" />";
		} else {
			$imgcap		= "No Image";
			$imgthumb 	= PROPERTY_IMAGES_THUMB168x126."no-img.gif";
			echo "<img src=\"gd1.php?img_name=".$imgthumb."&w=168&h=126\" alt=\"".$imgcap."\" width=\"168\" height=\"126\" />";
		}
		//Property Image : End here
		echo "</td>";

		echo "<td valign=\"middle\" class=\"pad-lft15\">";
		echo "<table width=\"490\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
		echo "<tr>";
		echo "<td width=\"96\" valign=\"top\"><strong>Enquiry ID</strong></td>";
		echo "<td width=\"390\" valign=\"top\">".fill_zero_left($enquiry_id, "0", (9-strlen($enquiry_id)))."(".($char++).")</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=\"top\"><strong>From</strong></td>";
		echo "<td valign=\"top\">".$txtUserName."</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=\"top\"><strong>Phone</strong></td>";
		echo "<td valign=\"top\">".$txtUserPhone."</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=\"top\"><strong>Email</strong></td>";
		echo "<td valign=\"top\"><a href=\"mailto:".$txtUserEmail."\" class=\"blue-link\">".$txtUserEmail."</a></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=\"top\"><strong>Property ID</strong></td>";
		echo "<td valign=\"top\">".fill_zero_left($property_id, "0", (6-strlen($property_id)))."</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=\"top\"><strong>Property name</strong></td>";
		echo "<td valign=\"top\"><a href=\"".$property_link."\" class=\"blue-link\">".ucfirst($property_name)."</a></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=\"top\"><strong>Enquiry date</strong></td>";
		echo "<td valign=\"top\">".date('M j, Y', $txtCreatedOn)."</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=\"top\">&nbsp;</td>";
		echo "<td valign=\"top\">&nbsp;</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=\"top\"><strong>Who&rsquo;s travelling</strong></td>";
		echo "<td valign=\"top\">".implode(", ", $travelArr)."</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=\"top\"><strong>When</strong></td>";
		echo "<td valign=\"top\"><strong>Arrive</strong> ".date('M j, Y', strtotime($txtArriavalDate))." for ".$txtDuration." nights, <strong>Depart</strong> ".date('M j, Y', strtotime($txtDepartureDate))."</td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td valign=\"top\"><strong>Message</strong></td>";
		echo "<td valign=\"top\">".$txtUserEnquiry."</td>";
		echo "</tr>";
		echo "</table>";
		echo "</td>";
		echo "</tr>";
		echo "<tr><td colspan=\"2\" align=\"right\" valign=\"middle\" class=\"dash25\">&nbsp;</td></tr>";
	}
}
?>
                            
                            
                            <tr>
                                <td align="right" valign="middle">&nbsp;</td>
                                <td valign="middle">
                                <a href="javascript:cancelEnquiry(<?php echo $enquiry_id; ?>);" class="button-grey" style="text-decoration:none;">Cancel</a>
                                &nbsp;&nbsp;<a href="javascript:editEnquiry(<?php echo $enquiry_id; ?>);" class="button-grey" style="text-decoration:none;">Edit</a>
                                &nbsp;&nbsp;<a href="javascript:void(0);" onclick="return validateSendEnquiry();" class="button-blue" style="text-decoration:none; color:#FFFFFF;">Confirm</a>
                                </td>
                            </tr>
                        </table>
                        </form>
                    </td>
                </tr>
				<?php /*?>
                <tr>
                    <td valign="top" class="pad-rgt10">
                        <table width="690" border="0" cellspacing="0" cellpadding="0" class="font12">
                            <tr>
                                <td>
                                    <div class="gradientBox690" style="margin-top:20px; margin-bottom:10px;">
                                        <div class="top">
                                            <div class="btm">
                                                <div class="content" style="padding-left:35px; padding-top:15px;">
                                                    <table width="100%" border="0" cellpadding="2" cellspacing="0">
                                                        <tr>
                                                        	<td colspan="2" align="left" valign="top">
                                                            	<span class="gray18">Beware of fraudsters when booking!</span>
                                                                <p>We try and check all the owners and their properties on the site but it's best to make sure you check yourself. Below are some simple guidelines to ensure the property you're enquiring about is genuine:</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" align="left" valign="top" class="pad-btm3">
                                                                <ul>
                                                                    <li><p>Speak to the owner directly</p>Give the owner a call ... if you speak to them you'll get a pretty good idea if they are genuine or not.</li>
                                                                    <li><p>Research the property and ask for references</p>Do a google search and ask the owner for references and more details on the property and it's location. Not all the properties have personal websites but you'll nearly always find something on the web about the property.</li>
                                                                    <li><p>Ask for a booking contract</p>All owners should have a booking contract containing all the terms and conditions of booking as well as payment and cencellation terms. If they haven't got one then ask them to contact us and we'll help them.</li>
                                                                    <li><p>Pay using a secure payment option</p>Don't pay in cash or through any untracable method. Either use a cheque, bank transfer (EFT) or a secure online payment system such as PayPal. Be sure that you pay the advertisor or agent and not a third party.</li>
                                                                    <li><p>Tell us if you are unsure</p>In most cases we'll suspend the advert pending an internal investigation as to it's credibility. We take fruad very seriously and will take measures to ensure the safety and security of the holidaymakers and owners on our site.</li>
                                                                </ul>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>                
                    </td>
                </tr>
				<?php */?>
            </table>
        </td>
    </tr>
</table>
<?php
} else {
?>
<table width="690" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr>
        <td align="left" valign="top">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                	<td valign="top" class="pad-rgt10">
                    <div class="FloatLft"><h1 class="page-headingNew"><?php echo $detail_array['error_msg'].' '.$captchaerror;?></h1></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?php
}
?>
