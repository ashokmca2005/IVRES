<!-- TinyMCE -->
<script type="text/javascript" src="<?php echo SITE_URL; ?>tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		mode : "exact",
//		elements : "txtUserMessageId",
		theme : "simple",
		plugins : 'advlink,advimage',
		relative_urls : false,
		remove_script_host : false
	});
</script>
<!-- /TinyMCE -->
<script language="javascript">
	var req       = ajaxFunction();
	function doAvailabilityCheck(txtPropertyId, arrivalDate, departureDate) {
		var url="availabilitycheckXML.php";
		url=url+"?pid="+txtPropertyId+"&frm="+arrivalDate+"&to="+departureDate;
		req.onreadystatechange = handleAvailabilityCheck; 
		req.open("GET",url,true);
		req.send(null);
	}

	function handleAvailabilityCheck(){
		var availabilitystatus = "No";
		if(req.readyState == 4 && req.status == 200) {
			var response = req.responseText; 
			xmlDoc=req.responseXML;
			var root = xmlDoc.getElementsByTagName('availabilities')[0];
			if(root != null) {
				var items = root.getElementsByTagName("availability");
				var item = items[0];
				availabilitystatus = item.getElementsByTagName("availabilitystatus")[0].firstChild.nodeValue;
				if(availabilitystatus == "Yes") {
					document.getElementById("txtPayNow").value = 1;
					document.getElementById("frmPropertyBooking").submit();
				} else if(availabilitystatus == "No") {
					document.getElementById("userBookingErrorId").innerHTML = "The requested accommodation has been reserved meanwhile";
					return false;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	function validate(){


		if(document.getElementById("txtSalutation").value =="") {
			document.getElementById("showErrorSalutationId").innerHTML = "Salutation required";
			document.getElementById("txtSalutation").focus();
			return false;
		}
		if(document.getElementById("txtUserFName").value =="") {
			document.getElementById("showErrorUserFNameId").innerHTML = "First Name required";
			document.getElementById("txtUserFName").focus();
			return false;
		}
		if(document.getElementById("txtUserLName").value =="") {
			document.getElementById("showErrorUserLNameId").innerHTML = "Last Name required";
			document.getElementById("txtUserLName").focus();
			return false;
		}
		if(document.getElementById("txtUserEmail").value == "") {
			document.getElementById("showErrorUserEmailId").innerHTML = "Enter valid email address";
			document.getElementById("txtUserEmail").focus();
			return false;
		}
		if(document.getElementById("txtUserPhone").value == "") {
			document.getElementById("showErrorphone").innerHTML = "Please enter your phone No.";
			document.getElementById("txtUserPhone").focus();
			return false;
		}

		if(document.getElementById("txtUserMessageId").value == "") {
			document.getElementById("userBookingErrorId").innerHTML = "Please enter your message";
			document.getElementById("txtUserMessageId").focus();
			return false;
		}
		if(document.getElementById("txtBudget").value =="") {
			document.getElementById("showErrorBudgetId").innerHTML = "Budget per night &#8364; required";
			document.getElementById("txtBudget").focus();
			return false;
		}

		if(document.getElementById("txtFindUs").value =="") {
			document.getElementById("showErrorFindUsId").innerHTML = "How did you find us?";
			document.getElementById("txtFindUs").focus();
			return false;
		}
		if(document.getElementById("txtRCountry").value =="") {
			document.getElementById("showErrorRCountryId").innerHTML = "Country required";
			document.getElementById("txtRCountry").focus();
			return false;
		}

		if(document.getElementById("txtPayDeposit").value =="") {
			document.getElementById("showErrorPayDepositId").innerHTML = "Pay deposit required";
			document.getElementById("txtPayDeposit").focus();
			return false;
		}

		if(document.getElementById("txtAdultsId").value =="") {
			document.getElementById("showErrorHowManyId").innerHTML = "How many adults?";
			document.getElementById("txtAdultsId").focus();
			return false;
		}
		/*
		if(document.getElementById("txtChildsId").value =="") {
			document.getElementById("showErrorHowManyId").innerHTML = "How many childs?";
			document.getElementById("txtChildsId").focus();
			return false;
		}

		if(document.getElementById("txtInfantsId").value =="") {
			document.getElementById("showErrorHowManyId").innerHTML = "How many infants?";
			document.getElementById("txtInfantsId").focus();
			return false;
		}
		*/

		if((document.getElementById("txtOneBdrApt") == true) && document.getElementById("txtOneBdrApt").value =="") {
			document.getElementById("showErrorOneBdrAptId").innerHTML = "How many One bdr apts?";
			document.getElementById("txtOneBdrApt").focus();
			return false;
		}

		if((document.getElementById("txtTwoBdrApts") == true) && document.getElementById("txtTwoBdrApts").value =="") {
			document.getElementById("showErrorTwoBdrAptsId").innerHTML = "How many Two bdr apts?";
			document.getElementById("txtTwoBdrApts").focus();
			return false;
		}

		if((document.getElementById("txtThreeBdrApts") == true) && document.getElementById("txtThreeBdrApts").value =="") {
			document.getElementById("showErrorThreeBdrAptsId").innerHTML = "How many Three bdr apts?";
			document.getElementById("txtThreeBdrApts").focus();
			return false;
		}

		if((document.getElementById("txtTwinStudio") == true) && document.getElementById("txtTwinStudio").value =="") {
			document.getElementById("showErrorTwinStudioId").innerHTML = "How many Twin studio?";
			document.getElementById("txtTwinStudio").focus();
			return false;
		}

		if((document.getElementById("txtTripleStudio") == true) && document.getElementById("txtTripleStudio").value =="") {
			document.getElementById("showErrorTripleStudioId").innerHTML = "How many Triple studio?";
			document.getElementById("txtTripleStudio").focus();
			return false;
		}

		if((document.getElementById("txtTripleStudio") == true) && document.getElementById("txtTripleStudio").value =="") {
			document.getElementById("showErrorRoomOnly2Id").innerHTML = "How many Triple studio?";
			document.getElementById("txtTripleStudio").focus();
			return false;
		}

		if((document.getElementById("txtRoomOnly2") == true) && document.getElementById("txtRoomOnly2").value =="") {
			document.getElementById("showErrorRoomOnly2Id").innerHTML = "Room only (up to 2)?";
			document.getElementById("txtRoomOnly2").focus();
			return false;
		}

		if((document.getElementById("txtRoomOnly3") == true) && document.getElementById("txtRoomOnly3").value =="") {
			document.getElementById("showErrorRoomOnly3Id").innerHTML = "Room only (up to 3)?";
			document.getElementById("txtRoomOnly3").focus();
			return false;
		}
		<?php /*?>
		if(document.getElementById("txtTownId").value =="") {
			document.getElementById("showErrorTown").innerHTML = "Please enter your address";
			document.getElementById("txtTownId").focus();
			return false;
		}
		if(document.getElementById("txtZipId").value =="") {
			document.getElementById("showErrorzipId").innerHTML = "Please enter your post code.  Please enter your city.";
			document.getElementById("txtZipId").focus();
			return false;
		}
		<?php */?>

		/*	
		if(tinyMCE.get("txtUserMessageId").getContent() == "") {
			document.getElementById("userBookingErrorId").innerHTML = "Please enter your message";
			document.getElementById("txtUserMessageId").focus();
			return false;
		}
		*/

		// Step I: Ajax validation for availability
		var pid = document.getElementById("txtPropertyId").value;
		var arrivalDate = document.getElementById("txtArriavalDate").value;
		var departureDate = document.getElementById("txtDepartureDate").value;
		doAvailabilityCheck(pid, arrivalDate, departureDate);
		if(document.getElementById("txtPayNow").value == 1) {
			return true;
		} else {
			return false;
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
<div><?php echo tranText('site_notes_property_contact'); ?></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr><td valign="top" class="pad-btm10"><div class="pink16arial"><?php echo "Property ref:".fill_zero_left($property_id, "0", (6-strlen($property_id)))." from <u><em>".date('M d, y', strtotime($arrangeArrivaldate))."</em></u> to <u><em>".date('M d, y', strtotime($arrangeDeparturedate))."</em></u>;Total Cost: ".$users_currency_symbol.$propertyObj->fun_getPropertyBookingCostDeposite($property_id, $arriavalDate, $departureDate, $users_currency_code); ?></div></td></tr>
    <tr>
        <td valign="top" class="pad-rgt10 pad-btm20">
            <div id="bookNowId" style="border:1px #999999 solid; padding:5px; background-color:#CCCCCC;">
                <h5>Information about you and your party</h5>
                <br />
                <form name="frmPropertyBooking" id="frmPropertyBooking" method="post" action="<?php echo SITE_URL;?>property-booking-confirm.php" onsubmit="return validate();">
                <input type="hidden" name="securityKey" value="<?php echo md5(BOOKINGENGINECONFIRM); ?>" />
                <input type="hidden" name="txtPropertyId" id="txtPropertyId" value="<?php echo $_POST['txtPropertyId']; ?>" />
                <input type="hidden" name="txtArriavalDate" id="txtArriavalDate" value="<?php echo $_POST['txtArriavalDate']; ?>" />
                <input type="hidden" name="txtDepartureDate" id="txtDepartureDate" value="<?php echo $_POST['txtDepartureDate']; ?>" />
                <input type="hidden" name="txtPayNow" id="txtPayNow" value="0" />
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="90" align="right" valign="top" class="pad-top2">First name</td>
                        <td valign="top" align="left" class="pad-btm5 pad-lft8"><input name="txtUserFName" id="txtUserFName" type="text" class="Textfield210" value="<?php if(isset($_POST['txtUserFName'])) { echo $_POST['txtUserFName']; } else if(isset($users_first_name)) { echo $users_first_name;} ?>"/><p><span class="pdError1" id="showErrorUserFNameId"></span></p></td>
                    </tr>
                    <tr>
                        <td align="right" valign="top" class="pad-top2">Last name</td>
                        <td valign="top" align="left" class="pad-btm5 pad-lft8"><input name="txtUserLName" id="txtUserLName" type="text" class="Textfield210" value="<?php if(isset($_POST['txtUserLName'])) { echo $_POST['txtUserLName']; } else if(isset($users_last_name)) { echo $users_last_name;} ?>" /><p><span class="pdError1" id="showErrorUserLNameId"></span></p></td>
                    </tr>
                    <tr>
                        <td width="90" align="right" valign="top"class="pad-top2">Street / No.* </td>
                        <td  valign="top" class="pad-btm5 pad-lft8"><input name="txtTown" type="text" class="RegFormFld1" id="txtTownId" value="<?php echo $txtTown;?>" /><p><span class="pdError1" id="showErrorTown"></span></p></td>
                    </tr>
                    <tr>
                        <td width="90" align="right" valign="top"class="pad-top2">ZIP code*/City* </td>
                        <td  valign="top"class="pad-btm5 pad-lft8"><input name="txtZip" type="text" class="RegFormFld1" id="txtZipId" value="<?php echo $txtZip;?>" /><p><span class="pdError1" id="showErrorzipId"></span></p></td>
                    </tr>
                    <tr>
                        <td width="90" align="right" valign="top" class="pad-top2" id="txtRCountry">Country</td>
                        <td  valign="top"class="pad-btm5 pad-lft8" >
                        <select name="txtRCountry" class="select215">
                            <option value="" style="font-style:normal; " disabled="disabled" selected="selected">Select country ... </option>
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
                    </tr>
                    <tr>
                        <td align="right" valign="top" class="pad-top2">Your email</td>
                        <td align="left" valign="top" class="pad-btm5 pad-lft8"><input name="txtUserEmail" id="txtUserEmail" type="text" class="Textfield210" value="<?php if(isset($_POST['txtUserEmail'])) { echo $_POST['txtUserEmail']; } else if(isset($users_email_id)) { echo $users_email_id;} ?>" /><p><span class="pdError1" id="showErrorUserEmailId"></span></p></td>
                    </tr>
                    <tr>
                        <td align="right" valign="top" class="pad-top2">Your phone</td>
                        <td align="left" valign="top" class="pad-btm5 pad-lft8"><input name="txtUserPhone" id="txtUserPhone" type="text" class="Textfield210" value="<?php if(isset($_POST['txtUserPhone'])) { echo $_POST['txtUserPhone']; } ?>" /><p><span class="pdError1" id="showErrorphone"></span></p></td>
                    </tr>
                    <tr>
                        <td align="right" class="pad-btm5 ">How many</td>
                        <td class="pad-btm5" valign="top">
                        <p class="FloatLft pad-lft8">
                            <?php
                            $propertyObj->fun_createSelectNumField('txtAdults', 'txtAdultsId', 'adults', '', '', 1, 16);
                            ?>
                        </p>
                        <p class="FloatLft pad-lft5">Adults</p>
                        <p class="FloatLft pad-lft8">
                            <?php
                            $propertyObj->fun_createSelectNumField('txtChilds', 'txtChildsId', 'adults', '', '', 1, 16);
                            ?>
                        </p>
                        <p class="FloatLft pad-lft5">Children (2 -11)</p>
                        <p class="FloatLft pad-lft8">
                            <?php
                            $propertyObj->fun_createSelectNumField('txtInfants', 'txtInfantsId', 'adults', '', '', 1, 16);
                            ?>
                        </p>
                        <p class="FloatLft pad-lft5">Infants (under 2)</p>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" valign="top" class="pad-btm5 ">Message</td>
                        <td class="pad-btm5 pad-lft8"><span style="padding-top:4px;"><textarea name="txtUserMessage" id="txtUserMessageId" cols="" rows="" style="width:260px;"></textarea></span></td>
                    </tr>
                    <tr>
                        <td align="right" valign="top">&nbsp;</td>
                        <td class="pad-lft8"><span class="error" id="userBookingErrorId"></span></td>
                    </tr>
            
                    <tr>
                        <td>&nbsp;</td>
                        <td>
                            <table height="54" width="100%" style="padding:8px;" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="2%" align="left" valign="top"><input name="txtNewLetter" id="txtNewLetterId" type="checkbox" class="checkbox" value="1" <?php if(isset($_POST['txtNewLetter']) && $_POST['txtNewLetter'] == "1") { echo "checked=\"checked\""; } ?> /></td>
                                    <td align="left" valign="top" style="padding-left:5px;"> Would you like to recieve the rentownersvillas.com  newsletter?</td>
                                </tr>
                                <tr><td colspan="2" align="left" valign="top" class="pad-top7"><strong>By clicking send you are agreeing to our <a  href="javascript:popcontact('<?php echo SITE_URL;?>terms.html')" class="blue-link">Terms and conditions</a></strong></td></tr>
                            </table>
                        </td>
                    </tr>
            
                    <tr>
                        <td>&nbsp;</td>
                        <td class="pad-top7 pad-lft8"><input type="image" src="<?php echo SITE_IMAGES;?>Booknow.gif" alt="Book Now" style="border:none;" ></td>
                    </tr>
                </table>    
            </form>
            </div>
        </td>
    </tr>
</table>
