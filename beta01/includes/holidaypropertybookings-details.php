<?php
// get Booking details
$booking_id 	= $_GET['booking'];
if(isset($_GET['pid']) && $_GET['pid'] != "") {
	$property_id = $_GET['pid'];
}
$bookingInfoArr = $propertyObj->fun_getPropertyBookingInfo($booking_id);
//print_r($bookingInfoArr);
if(is_array($bookingInfoArr) && count($bookingInfoArr) > 0) {
		$txtAdults 	= $bookingInfoArr['adults'];
		$txtChilds 	= $bookingInfoArr['childs'];
		$txtInfants = $bookingInfoArr['infants'];
		$travelArr 	= array();
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
		$txtDepartureDate 		= $bookingInfoArr['departure_date'];
		$txtUserMessage 		= $bookingInfoArr['message'];

		$txtSalutation 			= $bookingInfoArr['salutation']; // extra
		$txtBudget 				= $bookingInfoArr['budget']; // extra
		$txtFindUs 				= $bookingInfoArr['findus']; // extra
		$txtPayDeposit 			= $bookingInfoArr['pay_method']; // extra
		$txtFlexibility			= $bookingInfoArr['flexibility']; // extra

		$txtCreatedOn	 		= $bookingInfoArr['created_on'];
		$txtPaymentStatus 		= ($bookingInfoArr['payment_status'] == "2")?"Paid":"Pending";
		$txtNewLetter 			= $bookingInfoArr['txtNewLetter'];
		$bookingUserInfoArr 	= $usersObj->fun_getUserBookingInfo($booking_id);
		$txtUserFName 			= $bookingUserInfoArr['user_fname'];
		$txtUserLName 			= $bookingUserInfoArr['user_lname'];
		$txtUserEmail 			= $bookingUserInfoArr['user_email'];
		$txtUserName			= $txtUserFName." ".$txtUserLName;
		// Property details
		$bookingPropertyInfoArr = $propertyObj->fun_getPropertyBookingRelationInfo($booking_id, $property_id);
		$txtPropertyIdArr 		= array();
		foreach($bookingPropertyInfoArr as $value) {
			array_push($txtPropertyIdArr, $value['property_id']);
		}
		$txtPropertyId 			= implode(",", $txtPropertyIdArr);
}
?>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td align="left" valign="top" class="pad-btm10">
            <a href="<?php echo SITE_URL;?>propertybookings" class="blue-link">Back to property bookings</a>
        </td>
    </tr>
    <tr>
        <td valign="top" class="pad-rgt10 pad-btm20">
            <table width="100%" border="0" cellpadding="5" cellspacing="0">
                <?php
                if(is_array($bookingPropertyInfoArr) && count($bookingPropertyInfoArr) > 0) {
                    for($i = 0; $i < count($bookingPropertyInfoArr); $i++) {
                        $property_id 	= $bookingPropertyInfoArr[$i]['property_id'];
                //		$Booking_char 	= $bookingPropertyInfoArr[$i]['Booking_char'];
                        $property_name 	= $bookingPropertyInfoArr[$i]['property_name'];
                        $property_title	= $bookingPropertyInfoArr[$i]['property_title'];
                        echo "<tr>";
                        //Property Image : Start here
                        echo "<td width=\"155\" align=\"right\" valign=\"top\">";
                        $propertyMImgInfo	= $propertyObj->fun_getPropertyMainThumb($property_id);
                        if(is_array($propertyMImgInfo) && count($propertyMImgInfo) > 0) {
                            $imgid 		= $propertyMImgInfo[0]['photo_id'];
                            $imgcap 	= ucfirst($propertyMImgInfo[0]['photo_caption']);
                            $imgcap		= addslashes($imgcap);
                            $imgthumb 	= PROPERTY_IMAGES_THUMB168x126_PATH.$propertyMImgInfo[0]['photo_thumb'];
                            echo "<img src=\"".$imgthumb."\" alt=\"".$imgcap."\" width=\"168\" height=\"126\" />";
                        } else {
                            $imgcap		= "No Image";
                            $imgthumb 	= PROPERTY_IMAGES_THUMB168x126_PATH."no-img.gif";
                            echo "<img src=\"".$imgthumb."\" alt=\"".$imgcap."\" width=\"168\" height=\"126\" />";
                        }
                        //Property Image : End here
                        echo "</td>";
                
                        echo "<td valign=\"middle\" class=\"pad-lft15\">";
                        echo "<table width=\"490\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
                        echo "<tr>";
                        echo "<td width=\"96\" valign=\"top\"><strong>Booking ID</strong></td>";
                        echo "<td width=\"390\" valign=\"top\">".fill_zero_left($booking_id, "0", (9-strlen($booking_id)))."</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td valign=\"top\"><strong>From</strong></td>";
                        echo "<td valign=\"top\">".$txtSalutation." ".$txtUserName."</td>";
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
                        echo "<td valign=\"top\"><a href=\"property.php?pid=".$property_id."\" class=\"blue-link\">".ucfirst($property_name)."</a></td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td valign=\"top\"><strong>Booking date</strong></td>";
                        echo "<td valign=\"top\">".date('M j, Y', $txtCreatedOn)."</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td valign=\"top\"><strong>Payment status</strong></td>";
                        echo "<td valign=\"top\">".$txtPaymentStatus."</td>";
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
                        echo "<td valign=\"top\"><strong>Arrive</strong> ".date('M j, Y', strtotime($txtArriavalDate)).", <strong>Depart</strong> ".date('M j, Y', strtotime($txtDepartureDate))."</td>";
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
            </table>
        </td>
    </tr>
</table>
<?php $propertyObj->fun_updatePropertyBookingViewStatus($booking_id, "1"); ?>