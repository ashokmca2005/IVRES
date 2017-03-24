<?php
// get enquiry details
$enquiry_id 	= $_GET['enquiry'];
if(isset($_GET['pid']) && $_GET['pid'] != "") {
	$property_id = $_GET['pid'];
}
$enquiryInfoArr = $propertyObj->fun_getPropertyEnquiryInfo($enquiry_id);
//print_r($enquiryInfoArr);
if(is_array($enquiryInfoArr) && count($enquiryInfoArr) > 0) {
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
		$arriavalDateArr 		= explode("-", $txtArriavalDate);
		$txtDayArrival0 		= $arriavalDateArr[2];
		$txtMonthArrival0 		= $arriavalDateArr[1];
		$txtYearArrival0 		= $arriavalDateArr[0];
		$txtDuration 			= $enquiryInfoArr['duration'];
		$txtFlexibleDays 		= $enquiryInfoArr['flexi_day'];

		$txtDayDepart0 			= (int)($txtDayArrival0+$txtDuration);
		$txtMonthDepart0 		= $txtMonthArrival0;
		$txtYearDepart0 		= $txtYearArrival0;
		$txtDepartDate 			= $txtYearDepart0."-".$txtMonthDepart0."-".$txtDayDepart0;
		$txtUserEnquiry 		= $enquiryInfoArr['enquiry_txt'];
		$txtCreatedOn	 		= $enquiryInfoArr['created_on'];

		$txtNewLetter 			= $enquiryInfoArr['txtNewLetter'];

		$enquiryUserInfoArr 	= $usersObj->fun_getUserEnquiryInfo($enquiry_id);
		$txtUserFName 			= $enquiryUserInfoArr['user_fname'];
		$txtUserLName 			= $enquiryUserInfoArr['user_lname'];
		$txtUserEmail 			= $enquiryUserInfoArr['user_email'];
		$txtUserName			= $txtUserFName." ".$txtUserLName;

		// Property details
		$enquiryPropertyInfoArr = $propertyObj->fun_getPropertyEnquiryRelationInfo($enquiry_id, $property_id);
		$txtPropertyIdArr 		= array();
		foreach($enquiryPropertyInfoArr as $value) {
			array_push($txtPropertyIdArr, $value['property_id']);
		}
		$txtPropertyId 			= implode(",", $txtPropertyIdArr);
}
?>
<table width="690" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr>
        <td align="left" valign="top">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <td align="left" valign="top" class="pad-btm10">
                        <a href="<?php echo SITE_URL;?>holiday-enquiries.php" class="blue-link">Back to enquiries</a>
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="pad-rgt10 pad-btm20">
                        <table width="100%" border="0" cellpadding="5" cellspacing="0">
<?php
if(is_array($enquiryPropertyInfoArr) && count($enquiryPropertyInfoArr) > 0) {
	for($i = 0; $i < count($enquiryPropertyInfoArr); $i++) {
		$property_id 	= $enquiryPropertyInfoArr[$i]['property_id'];
		$property_name 	= $enquiryPropertyInfoArr[$i]['property_name'];
		$property_title	= $enquiryPropertyInfoArr[$i]['property_title'];
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
		echo "<td width=\"96\" valign=\"top\"><strong>Enquiry ID</strong></td>";
		echo "<td width=\"390\" valign=\"top\">".fill_zero_left($enquiry_id, "0", (9-strlen($enquiry_id)))."</td>";
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
		echo "<td valign=\"top\"><strong>Property ID</strong></td>";
		echo "<td valign=\"top\">".fill_zero_left($property_id, "0", (6-strlen($property_id)))."</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=\"top\"><strong>Property name</strong></td>";
		echo "<td valign=\"top\"><a href=\"property.php?pid=".$property_id."\" class=\"blue-link\">".ucfirst($property_name)."</a></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=\"top\"><strong>Enquiry date</strong></td>";
		echo "<td valign=\"top\">".date('M j, Y', $txtCreatedOn)."</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=\"top\">&nbsp;</td>";
		echo "<td valign=\"top\">&nbsp;</td>";
		echo "</tr>";

		/*
		echo "<tr>";
		echo "<td valign=\"top\"><strong>Who&rsquo;s travelling</strong></td>";
		echo "<td valign=\"top\">".implode(", ", $travelArr)."</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td valign=\"top\"><strong>When</strong></td>";
		echo "<td valign=\"top\"><strong>Arrive</strong> ".date('M j, Y', strtotime($txtArriavalDate))." for ".$txtDuration." nights, <strong>Depart</strong> ".date('M j, Y', strtotime($txtDepartDate))."<br />Dates flexible by ".$txtFlexibleDays." days</td>";
		echo "</tr>";
		*/
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
                            
                            
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<?php $propertyObj->fun_updatePropertyEnquiryViewStatus($enquiry_id, "1"); ?>
