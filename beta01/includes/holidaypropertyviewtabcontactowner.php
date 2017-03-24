<?php
	$propertyAvailInfo 		= $propertyObj->fun_getPropertyAvailabilityArr($property_id);
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
		$("#arrival_date").datepicker({
			dateFormat: 'mm/dd/yy',
			minDate: 0,
			constrainInput: true,
			beforeShowDay: nationalDays
		});
	});

	$(document).ready(function(){
		$("#departure_date").datepicker({
			dateFormat: 'mm/dd/yy',
			minDate: 0,
			constrainInput: true,
			beforeShowDay: nationalDays
		});
	});
</script>
<script language="javascript">
// JavaScript Document
	var req = new XMLHttpRequest();
	var x1 = "";
	var y1 = "";

	function validate() {
		if(document.getElementById("txtUserFName").value ==""){
			document.getElementById("showErrorUserFNameId").innerHTML = "Please Enter Fist Name";
			document.getElementById("txtUserFName").focus();
			return false;
		}
		if(document.getElementById("txtUserLName").value ==""){
			document.getElementById("showErrorUserLNameId").innerHTML = "Please Enter Last Name";
			document.getElementById("txtUserLName").focus();
			return false;
		}
		if(document.getElementById("txtUserEmail").value ==""){
			document.getElementById("showErrorUserEmailId").innerHTML = "Please Enter EmailId ";
			document.getElementById("txtUserEmail").focus();
			return false;
		}
		if(document.getElementById("txtDeparture").value ==""){
			document.getElementById("arrivalDateError").innerHTML = "Please select arrival date";
			document.getElementById("txtDeparture").focus();
			return false;
		}
		if(document.getElementById("txtUserEnquiryId").value == "") {
			document.getElementById("userEnquiryErrorId").innerHTML = "Please enter your message";
			document.getElementById("txtUserEnquiryId").focus();
			return false;
		}
		document.frmPropertyContactOwner.submit();
	}

	function chkblnkTxtError(strFieldId, strErrorFieldId) {
		if(document.getElementById(strFieldId).value != "") {
			document.getElementById(strErrorFieldId).innerHTML = "";
		}
	}
</script>
<table border="0" align="left" cellpadding="0" cellspacing="0"  width="100%" class="font12">
    <tr>
        <td valign="top">
            <div id="property-list-1">
                <ul>
                    <li style="padding-bottom:12px;">
                        <!-- AddThis Button BEGIN -->
                        <?php /*?>
                        <div style="width:100%;height:25px;margin:0px auto;margin-bottom:5px;margin-top:5px;margin-left:5px;" class="addthis_toolbox addthis_default_style">
                        <a style="width:80px;" class="addthis_button_tweet"></a>
                        <a style="width:70px;" class="addthis_button_google_plusone" g:plusone:size="medium"></a>
                        </div>
                        <?php */?>
                        <a style="width:45px; padding-right:15px;" class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                        <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4eea78bf4f1cc919"></script>
                        <!-- AddThis Button END -->
                    </li>
                    <li style="margin-left:3px; padding-right:3px;">
						<?php
                            if(isset($propFavId) && $propFavId !=""){
                                echo "<a href=\"javascript:addFavourite('".$property_id."', '".$user_id."')\" id=\"showAddFavouriteLinkId\" class=\"property-favlink-1\" style=\"display:none;\">Add to <br>favorites</a>";
                                echo "<a href=\"javascript:removeFavourite('".$property_id."', '".$user_id."')\" id=\"showRemoveFavouriteLinkId\" class=\"property-favlink-1\" style=\"display:block;\">Remove <br>favourite</a>";
                            } else {
                                if(isset($user_id) && $user_id != ""){
                                    echo "<a href=\"javascript:addFavourite('".$property_id."', '".$user_id."')\"  id=\"showAddFavouriteLinkId\" class=\"property-favlink-1\" style=\"display:block;\">Add to <br>favorites</a>";
                                    echo "<a href=\"javascript:removeFavourite('".$property_id."', '".$user_id."')\" id=\"showRemoveFavouriteLinkId\" class=\"property-favlink-1\" style=\"display:none;\">Remove <br>favourite</a>";
                                } else {
                                    echo "<a href=\"".SITE_URL."login\" class=\"property-favlink\">Add to <br>favorites</a>";
                                }
                            }
                        ?>
                    </li>
                    <li style="margin-left:5px;">
                        <a href="javascript:printme();" class="property-printlink"><img src="<?php echo SITE_IMAGES;?>print-icon.png" vspace="3" /></a>
                    </li>
                </ul>
            </div>
        </td>
    </tr>
    <tr>
        <td valign="top">
            <a  href="#showSectionCalendar" onclick="return showSection(5);" style="text-decoration:none; border:none;"><h4>Check availability</h4></a>
        </td>
    </tr>
    <tr>
        <td valign="top" align="center" class="box3">
			<script src="<?php echo SITE_URL;?>submit_inquiry.js"></script>
            <div id="messages" style="display:none">&nbsp;</div>
            <form name="frmPropertyContactOwner" id="inquiry_form" method="post" action="">
			<input type="hidden" name="securityKey" value="<?php echo md5(OWNERCONTACT); ?>" />
			<input type="hidden" name="property_id" id="property_id" value="<?php echo $property_id; ?>" />
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr><td align="left" valign="top"><h5>Contact the Owner</h5></td></tr>
                    <tr>
                        <td align="left" valign="top">
                        <input name="name" id="name" type="text" class="txtBox230" placeholder="name" value="<?php if(isset($_POST['name'])) { echo $_POST['name']; } else if(isset($user_full_name)) { echo $user_full_name;} ?>" onkeydown="chkblnkTxtError('name', 'showErrorUserNameId');" onkeyup="chkblnkTxtError('name', 'showErrorUserNameId');" />
                        <p class="FloatLft error" id="showErrorUserNameId"></p>
                        </td>
                    </tr>
					<?php /*?>
                    <tr>
                        <td align="left" valign="top">
                        <input name="txtUserLName" id="txtUserLName" type="text" class="txtBox230" placeholder="<?php echo tranText('last_name'); ?>" value="<?php if(isset($_POST['txtUserLName'])) { echo $_POST['txtUserLName']; } else if(isset($users_last_name)) { echo $users_last_name;} ?>" onkeydown="chkblnkTxtError('txtUserLName', 'showErrorUserLNameId');" onkeyup="chkblnkTxtError('txtUserLName', 'showErrorUserLNameId');" />
                        <p class="FloatLft error" id="showErrorUserLNameId"></p>
                        </td>
                    </tr>
					<?php */?>
                    <tr>
                        <td align="left" valign="top">
                        <input name="phone" id="phone" type="text" class="txtBox230" placeholder="phone" value="<?php if(isset($_POST['phone'])) { echo $_POST['phone']; } ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top">
                        <input name="email" id="email" type="text" class="txtBox230" placeholder="email" value="<?php if(isset($_POST['email'])) { echo $_POST['email']; } else if(isset($users_email_id)) { echo $users_email_id;} ?>" onkeydown="chkblnkTxtError('email', 'showErrorUserEmailId');" onkeyup="chkblnkTxtError('email', 'showErrorUserEmailId');" />
                        <p class="FloatLft error" id="showErrorUserEmailId"></p>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" class="pad-top10">
                            <p class="FloatLft">
								<?php echo tranText('arrival_date'); ?><br />
                                <input type="text" name="arrival_date" id="arrival_date" class="txtBox80" value="" onchange="chkblnkTxtError('arrival_date', 'arrivalDateError');" onkeydown="chkblnkTxtError('arrival_date', 'arrivalDateError');" onkeyup="chkblnkTxtError('arrival_date', 'arrivalDateError');">
                            </p>
                            <p class="FloatLft pad-lft25">
								<?php echo tranText('departure_date'); ?><br />
                                <input type="text" name="departure_date" id="departure_date" class="txtBox80" value="">
                            </p>
                            <p class="FloatLft error" id="arrivalDateError"></p>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" class="pad-top10">
							<strong><?php echo tranText('how_many'); ?></strong><br />
                            <div class="contactSec" style="margin-left:0px; margin-top:5px;">
                                <label><?php echo tranText('adults'); ?>:</label>
                                <div class="font12">
									<?php
                                    $propertyObj->fun_createSelectNumField('adults', 'adults', 'select80', '', '', 1, 16);
                                    ?>
                                </div>
                            </div>
                            <div class="contactSec" style="margin-left:12px; margin-top:5px;">
                                <label><?php echo tranText('children'); ?>:</label>
                                <div class="font12">
									<?php
                                    $propertyObj->fun_createSelectNumField('children', 'children', 'select80', '', '', 1, 16);
                                    ?>
                                </div>
                            </div>
                            <div class="contactSec" style="margin-left:12px; margin-top:5px; display:none;">
                                <label><?php echo tranText('infants'); ?>:</label>
                                <div class="font12">
									<?php
                                    $propertyObj->fun_createSelectNumField('infants', 'infants', 'select80', '', '', 1, 16);
                                    ?>
                                </div>
                            </div>
                        </td>
                    </tr>
					<?php /*?>
                    <tr>
                        <td align="left" valign="top" class="pad-top10">
						<?php echo tranText('duration'); ?><br />
                        <input type="text" name="txtDuration" id="txtDurationId" class="txtBox25" value="" />&nbsp;nights
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top">
						<?php echo tranText('dates_are_flexible_by'); ?><br />
                        <input type="text" name="txtFlexibleDays" id="txtFlexibleDaysId" class="txtBox25" value="" />&nbsp;days
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" class="pad-top10">
						<?php echo tranText('please_ask_your_question'); ?><br />
                        <textarea name="txtUserEnquiry" id="txtUserEnquiryId" class="txtArea230" onkeydown="chkblnkTxtError('txtUserEnquiryId', 'userEnquiryErrorId');" onkeyup="chkblnkTxtError('txtUserEnquiryId', 'userEnquiryErrorId');"></textarea><br />
                        <span class="error" id="userEnquiryErrorId"></span>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top">
							<script type="text/javascript">
                             var RecaptchaOptions = {
                                theme : 'white',
                                tabindex : 2
                             };
                             </script>
                            <style>
                            #recaptcha_image img{
                                height:46px;
                                width:180px;
                                margin: 0px;
                                padding: 0px;
                            }
                            #recaptcha_container_outer {
                                padding: 0px;
                                width: 215px;
								border-right:thin solid #ccc;
								-moz-border-top-right-radius:5px;
								-moz-border-bottom-right-radius:5px;
								-webkit-border-top-right-radius:5px;
								-webkit-border-bottom-right-radius:5px;
								border-top-right-radius:5px;
								border-bottom-right-radius:5px;
                                overflow:hidden;
                            }
                            #recaptcha_container {
                                margin: 0px;
                                padding: 0px;
                            }
                            #recaptcha_response_field {
                                margin: 0px;
                                padding: 0px;
                                width: 100px;
                            }
                            </style>
                            <div id="recaptcha_container_outer" align="center" style="padding-left:10px; margin-bottom:10px;">
							<?php echo recaptcha_get_html($publickey, $captchaerror); ?>
                            </div>
                        </td>
                    </tr>
					<?php */?>
                    <tr>
                        <td align="left" valign="top" class="pad-top5 pad-btm10">
                        <?php echo tranText('by_clicking_send_you_are_agreeing_to_our'); ?> <a  href="javascript:popcontact('<?php echo SITE_URL;?>terms.html')" class="blue-link"><?php echo tranText('terms_and_conditions'); ?></a>
                        </td>
                    </tr>
                    <tr>
                    <td class="pad-top5 pad-btm10">
                    <input type="button" value="Submit Inquiry" id="submit_inquiry_button" class="button-green" >
					<?php /*?>                    
                    <a href="javascript:void(0);" onclick="return validate();" class="button-green" style="text-decoration:none;padding:10px 90px 10px 90px;">Submit</a>
					<?php */?>                    
                    </td>
                    </tr>
                </table>
			</form>
        </td>
    </tr>
	<?php /*?>
    <tr>
        <td valign="top" class="pad-top10">
            <p><?php echo tranText('site_notes_property_contact'); ?></p>
        </td>
    </tr>
	<?php */?>
    <tr>
        <td valign="top" align="center" class="pad-top10">
			<?php $propertyObj->fun_createPropertyHighlightSectionView($property_id); ?>
        </td>
    </tr>
    <tr>
        <td valign="top" class="pad-top10">
            <?php
            $propertyObj->fun_createPropertyOwnerDetails4PropertyPriview($property_id);
            ?>
        </td>
    </tr>
    <tr>
        <td valign="top" class="pad-top10">
			<?php $propertyObj->fun_createPropertyCustomerReview($property_id); ?>
        </td>
    </tr>
	<?php /*?>
    <tr>
        <td valign="top" class="pad-top10">
            <div class="pad-top5 pad-lft5 pad-btm10 font12">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="30px"><img src="<?php echo SITE_IMAGES;?>t.gif" class="gui-icon-review gui-icon-rw" /></td>
                        <td width="55px"><?php echo tranText('reviews'); ?></td>
                        <td><?php $propertyObj->fun_createPropertyCustomerReview($property_id); ?></td>
                    </tr>
                    <?php if($booking_on == true) {?>
                    <tr><td align="center" colspan="3" class="pad-top10"><a href="<?php echo SITE_URL;?>property-booking-preview.php" target="_top" style="text-decoration:none;"><input type="button" alt="Search" class="button157x32" value="Book now" /></a></td></tr>
                    <?php }?>
                    <?php
                        $videoArray 		= $propertyObj->fun_getPropertyVideoInfoArr($property_id);
                        if(is_array($videoArray) && count($videoArray) > 0) {
                            $video_id 			= $videoArray['video_id'];
                            $video_caption 		= $videoArray['video_caption'];
                            $video_description 	= $videoArray['video_url'];
                            $video_url_arr 		= split("<embed src=\"", $video_description);
                            $video_url_arr1 	= split("\" type=\"application/x-shockwave-flash\"", $video_url_arr[1]);
                            $video_url 			= $video_url_arr1[0];
                            if(isset($video_url) && $video_url != "") { 
                            ?>
                                <tr><td align="center" colspan="3" class="pad-top10"><a href="<?php echo $video_url; ?>" target="_blank" title="<?php echo $video_caption; ?>"><img src="<?php echo SITE_IMAGES;?>youtube-btn.gif" border="0" width="180px" /></a></td></tr>
                            <?
                            }
                        }
                    ?>
                </table>
            </div>
        </td>
    </tr>
	<?php */?>
</table>
