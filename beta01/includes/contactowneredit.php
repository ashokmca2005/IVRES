<?php
	$propertyAvailInfo 		= $propertyObj->fun_getPropertyAvailabilityArr($txtPropertyId);
?>
<script type="text/javascript">
	/* create an array of days which need to be disabled */
	<?php 
	//var disabledDays = ["5-23-2013","5-24-2013","5-25-2013"];
	$bookedDate = '';
	for($i = 0; $i < count($propertyAvailInfo); $i++) {
		if($propertyAvailInfo[$i]['status'] == "3") {
			$bookedArr 	= createDateRangeArrayJs($propertyAvailInfo[$i]['startdate'], $propertyAvailInfo[$i]['enddate']);
			$bookedDate .= implode('","', $bookedArr).'","';
		}
	}
	if(isset($bookedDate) && $bookedDate != "") {
		$bookedDate = substr($bookedDate, 0, -3);
		$bookedDate = '["'.$bookedDate.'"]';
		echo "var disabledDays = ".$bookedDate.";";
	} else {
		echo "var disabledDays = [];";
	}
	?>

	/* utility functions */
	function nationalDays(date) {
		var m = date.getMonth(), d = date.getDate(), y = date.getFullYear();
		//console.log('Checking (raw): ' + m + '-' + d + '-' + y);
		for (i = 0; i < disabledDays.length; i++) {
			if(ArrayContains(disabledDays,(m+1) + '-' + d + '-' + y) || new Date() > date) {
				//console.log('bad:  ' + (m+1) + '-' + d + '-' + y + ' / ' + disabledDays[i]);
				return [false];
			}
		}
		//console.log('good:  ' + (m+1) + '-' + d + '-' + y);
		return [true];
	}

	function noWeekendsOrHolidays(date) {
		var noWeekend = jQuery.datepicker.noWeekends(date);
		return noWeekend[0] ? nationalDays(date) : noWeekend;
	}

	/* taken from mootools */
	function ArrayIndexOf(array,item,from){
		var len = array.length;
		for (var i = (from < 0) ? Math.max(0, len + from) : from || 0; i < len; i++){
			if (array[i] === item) return i;
		}
		return -1;
	}
	/* taken from mootools */
	function ArrayContains(array,item,from){
		return ArrayIndexOf(array,item,from) != -1;
	}

	$(document).ready(function(){
		$("#txtArrival").datepicker({
			dateFormat: 'yy-mm-dd',
			minDate: 0,
			constrainInput: true,
			beforeShowDay: nationalDays
		});
	});

	$(document).ready(function(){
		$("#txtDeparture").datepicker({
			dateFormat: 'yy-mm-dd',
			minDate: 0,
			constrainInput: true,
			beforeShowDay: nationalDays
		});
	});
</script>
<!-- TinyMCE -->
<script type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		mode : "exact",
		elements : "txtUserEnquiryId",
		theme : "simple",
		plugins : 'advlink,advimage',
		relative_urls : false,
		remove_script_host : false
	});
</script>
<!-- /TinyMCE -->
<script language="javascript">
// JavaScript Document
	var req = ajaxFunction();
	var x1 = "";
	var y1 = "";
	function validate() {
	}

	function cancelEnquiry(strEnquiryId) {
		req.onreadystatechange = handleDeleteEnquiryResponse;
		req.open('get', '<?php echo SITE_URL;?>enquirydeleteXml.php?enquiry='+strEnquiryId); 
		req.send(null);   
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
<table border="0" cellspacing="0" cellpadding="0" width="100%" class="font12">
<tr>
    <td valign="top" class="pad-rgt10">
        <table width="100%" border="0" cellpadding="5" cellspacing="0">
            <tr><td valign="top"><?php require_once(SITE_INCLUDES_PATH.'contactowneredit-show-listing.php'); ?></td></tr>
        </table>
    </td>
</tr>
<tr>
    <td valign="top" class="pad-rgt10">
    <a name="enquiryform">&nbsp;</a>
    <form name="frmPropertyContactOwner" method="post" action="holiday-contact-owner-preview.php">
    <input type="hidden" name="securityKey" value="<?php echo md5(OWNERCONTACT); ?>" />
    <input type="hidden" name="txtPropertyId" id="txtPropertyId" value="<?php echo $txtPropertyId; ?>" />
    <input type="hidden" name="txtEnquiryId" id="txtEnquiryId" value="<?php echo $enquiry_id; ?>" />
        <table width="100%" border="0" cellpadding="5" cellspacing="0">
            <?php /*?>                            
            <tr>
                <td valign="top">
                    <div><h1 class="page-headingNew">Contact form ...</h1></div>
                    <div class="pad-top15 pad-rgt5"><strong>Remember to tick the checkboxes next to the properties you wish to send this enquiry form to.</strong></div>
                </td>
            </tr>
            <?php */?>                            
            <tr>
                <td valign="top">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="120" align="right" valign="top" class="pad-top2">First name</td>
                            <td valign="top" align="left" class="pad-btm10 pad-lft8"><input name="txtUserFName" type="text" class="textField370" value="<?php if(isset($txtUserFName)) { echo $txtUserFName; } ?>" /></td>
                        </tr>
                        <tr><td colspan="2">&nbsp;</td></tr>
                        <tr>
                            <td width="120" align="right" valign="top" class="pad-top2">Last name</td>
                            <td valign="top" align="left" class="pad-btm10 pad-lft8"><input name="txtUserLName" type="text" class="textField370" value="<?php if(isset($txtUserLName)) { echo $txtUserLName; } ?>" /></td>
                        </tr>
                        <tr><td colspan="2">&nbsp;</td></tr>
                        <tr>
                            <td align="right" valign="top" class="pad-top2">Phone</td>
                            <td align="left" valign="top" class="pad-btm12 pad-lft8"><input name="txtUserPhone" type="text" class="textField370" value="<?php if(isset($txtUserPhone)) { echo $txtUserPhone; } ?>" /></td>
                        </tr>
                        <tr><td colspan="2">&nbsp;</td></tr>
                        <tr>
                            <td align="right" valign="top" class="pad-top2">Email</td>
                            <td align="left" valign="top" class="pad-btm12 pad-lft8"><input name="txtUserEmail" type="text" class="textField370" value="<?php if(isset($txtUserEmail)) { echo $txtUserEmail; } ?>" /></td>
                        </tr>
                        <tr><td colspan="2">&nbsp;</td></tr>
                        <tr>
                            <td align="right" valign="top" class="pad-btm12" style="padding-top:9px;">How many</td>
                            <td class="pad-btm1">
                            <p class="FloatLft pad-lft8">Adults</p>
                            <p class="FloatLft pad-lft5">
                                <?php
                                $propertyObj->fun_createSelectNumField('txtAdults', 'txtAdultsId', 'adults', $txtAdults, '', 1, 16);
                                ?>
                            </p>
                            <p class="FloatLft pad-lft15">Children (2 -11)</p>
                            <p class="FloatLft pad-lft5">
                                <?php
                                $propertyObj->fun_createSelectNumField('txtChilds', 'txtChildsId', 'adults', $txtChilds, '', 1, 16);
                                ?>
                            </p>
                            <p class="FloatLft pad-lft15">Infants (under 2)</p>
                            <p class="FloatLft pad-lft5">
                                <?php
                                $propertyObj->fun_createSelectNumField('txtInfants', 'txtInfantsId', 'adults', $txtInfants, '', 1, 16);
                                ?>
                            </p>
                            </td>
                        </tr>
                        <tr><td colspan="2">&nbsp;</td></tr>
                        <tr>
                            <td align="right" valign="top" class="pad-btm12"><?php echo tranText('arrival_date'); ?></td>
                            <td class="pad-btm12">
                                <p class="FloatLft pad-lft5">
                                    <input type="text" name="txtArrival" id="txtArrival" class="txtBox80" value="">
                                </p>
                            </td>
                        </tr>
                        <tr><td colspan="2">&nbsp;</td></tr>
                        <tr>
                            <td align="right" valign="top" class="pad-btm10"><?php echo tranText('departure_date'); ?></td>
                            <td class="pad-btm10">
                                <p class="FloatLft pad-lft5">
                                    <input type="text" name="txtDeparture" id="txtDeparture" class="txtBox80" value="">
                                </p>
                                <p class="FloatLft error" id="arrivalDateError"></p>
                            </td>
                        </tr>
                        <tr><td colspan="2">&nbsp;</td></tr>
                        <tr>
                            <td align="right" valign="top" class="pad-btm12 ">Duration</td>
                            <td class="pad-btm12 pad-lft8"><input type="text" name="txtDuration" id="txtDurationId" class="searchdaysEvents" value="<?php if(isset($txtDuration)) { echo $txtDuration; } ?>" /> &nbsp;nights</td>
                        </tr>
                        <tr><td colspan="2">&nbsp;</td></tr>
                        <tr>
                            <td align="right" valign="top" class="pad-btm12 ">Dates are flexible by</td>
                            <td class="pad-btm12 pad-lft8"><input type="text" name="txtFlexibleDays" id="txtFlexibleDaysId" class="searchdaysEvents" value="<?php if(isset($txtFlexibleDays)) { echo $txtFlexibleDays; } ?>" /> &nbsp;days</td>
                        </tr>
                        <tr><td colspan="2">&nbsp;</td></tr>
                        <tr>
                            <td align="right" valign="top" class="pad-btm12 ">Please ask your question</td>
                            <td class="pad-btm12 pad-lft8"><span style="padding-top:4px;"><textarea name="txtUserEnquiry" id="txtUserEnquiryId" cols="" rows="" class="textarea444" style="width:444px;"><?php if(isset($txtUserEnquiry)) { echo $txtUserEnquiry; } ?></textarea></span></td>
                        </tr>
                        <tr><td colspan="2">&nbsp;</td></tr>
						<?php /*?>
                        <tr>
                            <td align="right" valign="top">&nbsp;</td>
                            <td style="padding:0px;">
                                <?php echo recaptcha_get_html($publickey, $captchaerror); ?>
                            </td>
                        </tr>
                        <tr><td colspan="2">&nbsp;</td></tr>
						<?php */?>
                        <tr>
                            <td>&nbsp;</td>
                            <td>
                                <table height="54" width="100%" style="padding:8px;" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="2%" align="left" valign="top"><input name="txtNewLetter" id="txtNewLetterId" type="checkbox" class="checkbox" value="1" checked="checked" /></td>
                                        <td align="left" valign="top" style="padding-left:5px;"> Would you like to recieve the rentownersvillas.com newsletter?</td>
                                    </tr>
                                    <tr><td colspan="2" align="left" valign="top" class="pad-top7"><strong>By clicking send you are agreeing to our <a  href="javascript:popcontact('terms.html')" class="blue-link">Terms and conditions</a></strong></td></tr>
                                </table>
                            </td>
                        </tr>
                        <tr><td colspan="2">&nbsp;</td></tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td class="pad-top7 pad-lft8">
                            <a href="javascript:cancelEnquiry(<?php echo $enquiry_id; ?>);"><img src="<?php echo SITE_IMAGES;?>cancel-gray.gif" alt="Cancel" width="81" height="27" /></a>&nbsp;&nbsp;<input type="image" src="<?php echo SITE_IMAGES;?>submit.gif" alt="Send" border="0" onclick="return validate();" >
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </form>
    </td>
</tr>
</table>
