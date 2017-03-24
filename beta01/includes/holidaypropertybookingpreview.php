<?php
// get booking details
$bookingInfoArr = $propertyObj->fun_getPropertyBookingInfo($booking_id);
//print_r($bookingInfoArr);
if(is_array($bookingInfoArr) && count($bookingInfoArr) > 0) {
	$txtPropertyId 			= $bookingInfoArr['property_id'];
	$txtUserPhone 			= $bookingInfoArr['phone'];
	$txtAdults 				= $bookingInfoArr['adults'];
	$txtChilds 				= $bookingInfoArr['childs'];
	$txtInfants 			= $bookingInfoArr['infants'];
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
	$txtArriavalDate 		= $bookingInfoArr['arrival_date'];
	$arriavalDateArr 		= explode("-", $txtArriavalDate);
	$txtDayArrival0 		= $arriavalDateArr[2];
	$txtMonthArrival0 		= $arriavalDateArr[1];
	$txtYearArrival0 		= $arriavalDateArr[0];
	$txtDepartureDate 		= $bookingInfoArr['departure_date'];
	$departureDateArr 		= explode("-", $txtDepartureDate);
	$txtDayDeparture0 		= $departureDateArr[2];
	$txtMonthDeparture0		= $departureDateArr[1];
	$txtYearDeparture0 		= $departureDateArr[0];
	$txtUserMessage 		= $bookingInfoArr['message'];
	$txtCreatedOn 			= $bookingInfoArr['created_on'];
	// User details
	$bookingUserInfoArr 	= $usersObj->fun_getUserBookingInfo($booking_id);
	$txtUserFName 			= $bookingUserInfoArr['user_fname'];
	$txtUserLName 			= $bookingUserInfoArr['user_lname'];
	$txtUserEmail 			= $bookingUserInfoArr['user_email'];
	$txtUserName			= $txtUserFName." ".$txtUserLName;
	$txtTown                = $bookingUserInfoArr['user_town'];
	$txtZip                 = $bookingUserInfoArr['user_zip'];
	$txtRCountry            = $bookingUserInfoArr['user_rcountry'];
	$txtUserAdrress			= $txtTown ." ".$txtZip;

	// Property details
	$bookingPropertyInfoArr = $propertyObj->fun_getPropertyEnquiryRelationInfo($booking_id, '');
//		$txtPropertyIdArr 		= array();
//		foreach($bookingPropertyInfoArr as $value) {
//			array_push($txtPropertyIdArr, $value['property_id']);
//		}
//		$txtPropertyId 			= implode(",", $txtPropertyIdArr);
//		echo $txtPropertyId;
//		print_r($bookingPropertyInfoArr);
}
//echo "tesing";
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
		req.open('get', '<?php echo SITE_URL;?>bookingdeleteXml.php?booking='+strEnquiryId); 
		req.send(null);   
	}

	function validateSendEnquiry() {
		document.getElementById("txtBookNowId").value = 1;
		
		//alert(document.getElementById("txtBookNowId").value);
		document.frmPropertyBooking.submit();

	}

	function editEnquiry(strEnquiryId) {
		window.location = 'holiday-property-booking-edit.php?booking='+strEnquiryId;
	}

	function handleDeleteEnquiryResponse() {
		if(req.readyState == 4) {
			var response=req.responseText;
			xmlDoc=req.responseXML;
			var root = xmlDoc.getElementsByTagName('enquiries')[0];
			if(root != null){
				var items = root.getElementsByTagName("booking");
                var item = items[0];
                var bookingstatus = item.getElementsByTagName("bookingstatus")[0].firstChild.nodeValue;
                if(bookingstatus == "Enquiry deleted.") {
                    window.location = '<?php if(isset($_SESSION['ses_user_home']) && $_SESSION['ses_user_home'] !=""){echo $_SESSION['ses_user_home'];} else {echo SITE_URL;}?>';
                }
			}
		}
	}
</script>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td valign="top" class="pad-rgt10">
        <div class="FloatLft"><h1 class="page-headingNew">Booking details</h1></div>
        </td>
    </tr>
    <tr>
        <td valign="top" class="pad-rgt10 pad-btm20">
            <div class="gradientBox690" style="margin-top:15px; margin-bottom:5px;">
                <div class="top">
                    <div class="btm">
                        <div class="content">
                            <table width="100%" border="0" cellpadding="2" cellspacing="0">
                                <tr><td colspan="2" align="left" valign="top"><span class="pink16">Is your email address correct?</span>&nbsp;&nbsp;<a href="javascript:void(0);" class="blue-link"><strong><?php echo $txtUserEmail; ?></strong></a></td></tr>
                                <tr><td colspan="2" align="left" valign="top" class="pad-btm3">If it's wrong then click <a href="javascript:editEnquiry(<?php echo $booking_id; ?>);" class="blue-link">edit</a> to change it, otherwise the owners won't be able to contact you!</td></tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td valign="top" class="pad-rgt10">
            <form name="frmPropertyBooking" id="frmPropertyBooking" method="post" action="holiday-property-booking-preview.php?booking=<?php echo $booking_id;?>">
            <input type="hidden" name="securityKey" value="<?php echo md5(BOOKINGENGINE); ?>" />
            <input type="hidden" name="txtPropertyId" id="txtPropertyId" value="<?php echo $txtPropertyId; ?>" />
            <input type="hidden" name="txtUserFName" id="txtUserFNameId" value="<?php echo $txtUserFName; ?>" />
            <input type="hidden" name="txtUserLName" id="txtUserLNameId" value="<?php echo $txtUserLName; ?>" />
            <input type="hidden" name="txtUserEmail" id="txtUserEmailId" value="<?php echo $txtUserEmail; ?>" />
            <input type="hidden" name="txtUserPhone" id="txtUserPhoneId" value="<?php echo $txtUserPhone; ?>" />
            <input type="hidden" name="txtAdults" id="txtAdultsId" value="<?php echo $txtAdults; ?>" />
            <input type="hidden" name="txtChilds" id="txtChildsId" value="<?php echo $txtChilds; ?>" />
            <input type="hidden" name="txtInfants" id="txtInfantsId" value="<?php echo $txtInfants; ?>" />
            <input type="hidden" name="txtDayArrival0" id="txtDayArrival0Id" value="<?php echo $txtDayArrival0; ?>" />
            <input type="hidden" name="txtMonthArrival0" id="txtMonthArrival0Id" value="<?php echo $txtMonthArrival0; ?>" />
            <input type="hidden" name="txtYearArrival0" id="txtYearArrival0Id" value="<?php echo $txtYearArrival0; ?>" />
            <input type="hidden" name="txtDayDeparture0" id="txtDayDeparture0Id" value="<?php echo $txtDayDeparture0; ?>" />
            <input type="hidden" name="txtMonthDeparture0" id="txtMonthDeparture0Id" value="<?php echo $txtMonthDeparture0; ?>" />					
            <input type="hidden" name="txtYearDeparture0" id="txtYearDeparture0Id" value="<?php echo $txtYearDeparture0; ?>" />
            <input type="hidden" name="txtUserMessage" id="txtUserMessageId" value="<?php echo $txtUserMessage; ?>" />
            <input type="hidden" name="txtNewLetter" id="txtNewLetterId" value="<?php echo $txtNewLetter; ?>" />
            <input type="hidden" name="txtBookNow" id="txtBookNowId" value="<?php if(isset($_POST['txtBookNow']) && $_POST['txtBookNow'] > 0) { echo $_POST['txtBookNow'];} else {echo '0';} ?>" />
            <?php
            if(isset($booking_id) && $booking_id != "") {
                echo "<input type=\"hidden\" name=\"txtbookingId\" id=\"txtbookingId\" value=\"".$booking_id."\" />";
            }
            ?>

            <table width="100%" border="0" cellpadding="5" cellspacing="0">
                <tr><td colspan="2" align="left" valign="middle" class="pad-btm20"><span class="gray18">Your booking is as follows</span></td></tr>
                <?php
                if(is_array($bookingPropertyInfoArr) && count($bookingPropertyInfoArr) > 0) {
                    $char = 'a';
                    for($i = 0; $i < count($bookingPropertyInfoArr); $i++) {
                        $property_id 	= $bookingPropertyInfoArr[$i]['property_id'];
                        $property_name 	= $bookingPropertyInfoArr[$i]['property_name'];
                        $property_title	= $bookingPropertyInfoArr[$i]['property_title'];
                
                        $propLocInfoArr 	= $propertyObj->fun_getPropertyLocInfoArr($property_id);
                        $fr_url 			= $propertyObj->fun_getPropertyFriendlyLink($property_id);
                        if(isset($fr_url) && $fr_url != "") {
                            $property_link = SITE_URL."vacation-rentals/".strtolower($property_id);
                        } else {
                            if(isset($propLocInfoArr['location_name']) && $propLocInfoArr['location_name'] != "") {
                                $property_link = SITE_URL."vacation-rentals/in.".str_replace(" ", "-", strtolower($propLocInfoArr['location_name']))."/".fill_zero_left($property_id, "0", (6-strlen($property_id)));
                            } else {
                                $property_link = SITE_URL."vacation-rentals/in.".str_replace(" ", "-", strtolower($propLocInfoArr['region_name']))."/".fill_zero_left($property_id, "0", (6-strlen($property_id)));
                            }
                        }
                
                        echo "<tr>";
                        //Property Image : Start here
                        echo "<td width=\"155\" align=\"right\" valign=\"top\">";
                        $propertyMImgInfo	= $propertyObj->fun_getPropertyMainThumb($txtPropertyId);
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
                        echo "<td width=\"96\" valign=\"top\"><strong>Booking ID</strong></td>";
                        echo "<td width=\"390\" valign=\"top\">".fill_zero_left($booking_id, "0", (9-strlen($booking_id)))."(".($char++).")</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td valign=\"top\"><strong>From</strong></td>";
                        echo "<td valign=\"top\">".$txtUserName."</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td valign=\"top\"><strong>Email</strong></td>";
                        echo "<td valign=\"top\"><a href=\"mailto:".$txtUserEmail."\" class=\"blue-link\">".$txtUserEmail."</a></td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<tr>";
                        echo "<td valign=\"top\"><strong>Phone</strong></td>";
                        echo "<td valign=\"top\">".$txtUserPhone."</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td valign=\"top\"><strong>Property ID</strong></td>";
                        echo "<td valign=\"top\">".fill_zero_left($txtPropertyId, "0", (6-strlen($txtPropertyId)))."</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td valign=\"top\"><strong>Property name</strong></td>";
                        echo "<td valign=\"top\"><a href=\"".$property_link."\" class=\"blue-link\">".ucfirst($property_name)."</a></td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td valign=\"top\"><strong>Booking date</strong></td>";
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
                        echo "<td valign=\"top\"><strong>Arrive</strong> ".date('M j, Y', strtotime($txtArriavalDate))."<strong>&nbsp;&nbsp;&nbsp;Depart</strong> ".date('M j, Y', strtotime($txtDepartureDate))."<br /></td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td valign=\"top\"><strong>Message</strong></td>";
                        echo "<td valign=\"top\">".$txtUserMessage."</td>";
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
                    <td valign="middle"><a href="javascript:cancelEnquiry(<?php echo $booking_id; ?>);"><img src="<?php echo SITE_IMAGES;?>cancel-gray.gif" alt="Cancel" width="81" height="27" /></a>&nbsp;&nbsp;<a href="javascript:editEnquiry(<?php echo $booking_id; ?>);"><img src="<?php echo SITE_IMAGES;?>editnew-gray.gif" alt="Edit" width="50" height="27" /></a>&nbsp;&nbsp;<input type="image" src="<?php echo SITE_IMAGES;?>confirm.gif" alt="Confirm" name="Confirm" id="ConfirmId" onclick="return validateSendEnquiry();" style="border:none;"></td>
                </tr>
            </table>
            </form>

            <!-- PAYPAL FORM -->
            <form id="paypal_form" name="paypal_form" action="https://www.paypal.com/cgi-bin/webscr" method="post">
                <input type="hidden" id="cmd" name="cmd" value="_xclick">
                <input type="hidden" id="business" name="business" value="ashok_shah1091@yahoo.co.in">
                <input type="hidden" id="item_name" name="item_name" value="Item Name Goes Here">
                <input type="hidden" id="item_number" name="item_number" value="Item Number Goes Here">
                <input type="hidden" id="amount" name="amount" value="0.00">
                <input type="hidden" id="no_shipping" name="no_shipping" value="2">
                <input type="hidden" id="no_note" name="no_note" value="1">
                <input type="hidden" id="currency_code" name="currency_code" value="EUR">
                <input type="hidden" id="cancel_return" name="cancel_return" value="">
                <input type="hidden" name="rm" value="2" />
                <input type="hidden" id="cbt" name="cbt" value="Continue">
                <input type="hidden" id="return" name="return" value="">
                <input type="hidden" id="cpp_header_image" name="cpp_header_image" value="<?php echo SITE_URL; ?>/logo_desi.gif">
                <input type="hidden" id="cpp_headerback_color" name="cpp_headerback_color" value="ffffff">
                <input type="hidden" id="cpp_headerborder_color" name="cpp_headerborder_color" value="ffffff">
                <input type="hidden" id="invoice" name="invoice" value="">
                <input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-but23.gif" name="submit" alt="Make payments with payPal - it's fast, free and secure!" style="display:none;">
                <img alt="" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" style="display:none;">
            </form>
        </td>
    </tr>
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
</table>
<script language="javascript" type="text/javascript">
	function payWithPaypal() {
		if(document.getElementById('txtBookNowId').value==1) {
			document.getElementById('item_name').value = 'vacansol property rental.com';
			document.getElementById('item_number').value = 1;
			document.getElementById('amount').value = 400;
//			document.getElementById('amount').value = document.getElementById('grandTotal').innerHTML;
			document.getElementById('no_shipping').value = 1;
			document.getElementById('no_note').value = 1;
			document.getElementById('currency_code').value = 'EUR';
			document.getElementById('cancel_return').value = '<?php echo SITE_URL; ?>booking-cancel.php?'+'booking=<?php echo $booking_id;?>';
			document.getElementById('return').value = '<?php echo SITE_URL; ?>booking-complete.php?'+'booking=<?php echo $booking_id;?>';
			document.paypal_form.submit();
		}
	}
</script>
