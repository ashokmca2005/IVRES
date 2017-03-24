<?php
if(isset($enquiry_id) && $enquiry_id !=""){
	$enquiryInfoArr = $propertyObj->fun_getPropertyEnquiryInfo($enquiry_id);
	if(is_array($enquiryInfoArr) && count($enquiryInfoArr) > 0) {
		$txtAdults 				= $enquiryInfoArr['adults'];
		$txtChilds 				= $enquiryInfoArr['childs'];
		$txtInfants 			= $enquiryInfoArr['infants'];
		$travelArr 				= array();
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
		$txtDepartDateTime		= mktime(0,0,0,$txtMonthArrival0,(int)($txtDayArrival0+$txtDuration),$txtYearArrival0);
		$txtUserEnquiry 		= $enquiryInfoArr['enquiry_txt'];
		$txtCreatedOn	 		= $enquiryInfoArr['created_on'];
		$txtNewLetter 			= $enquiryInfoArr['txtNewLetter'];
		$enquiryUserInfoArr 	= $usersObj->fun_getUserEnquiryInfo($enquiry_id);
		$txtUserFName 			= $enquiryUserInfoArr['user_fname'];
		$txtUserLName 			= $enquiryUserInfoArr['user_lname'];
		$txtUserEmail 			= $enquiryUserInfoArr['user_email'];
		$txtUserName			= $txtUserFName." ".$txtUserLName;
	
		// Property details
		if(isset($_GET['char']) && $_GET['char'] != "") {
			$enquiry_char 	= $_GET['char'];
		}
		$enquiryPropertyInfoArr = $propertyObj->fun_getPropertyEnquiryRelationAdminInfo($enquiry_id, $property_id, $enquiry_char);
		$txtPropertyIdArr 		= array();
		foreach($enquiryPropertyInfoArr as $value) {
			array_push($txtPropertyIdArr, $value['property_id']);
		}
		$txtPropertyId 			= implode(",", $txtPropertyIdArr);
	}
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr><td height="10" colspan="2" valign="top">&nbsp;</td></tr>
    <tr>
        <td valign="top"><a href="admin-collateral.php?sec=enquiries" class="back">Back to List</a></td>
        <td align="right" valign="top">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2" valign="top" class="pad-top5">
			<table width="100%" border="0" cellpadding="5" cellspacing="0">
<?php
if(is_array($enquiryPropertyInfoArr) && count($enquiryPropertyInfoArr) > 0) {
for($i = 0; $i < count($enquiryPropertyInfoArr); $i++) {
$property_id 	= $enquiryPropertyInfoArr[$i]['property_id'];
$enquiry_char 	= $enquiryPropertyInfoArr[$i]['enquiry_char'];
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
echo "<td width=\"390\" valign=\"top\">".fill_zero_left($enquiry_id, "0", (9-strlen($enquiry_id)))."(".$enquiry_char.")</td>";
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
echo "<tr>";
echo "<td valign=\"top\"><strong>Who&rsquo;s travelling</strong></td>";
echo "<td valign=\"top\">".implode(", ", $travelArr)."</td>";
echo "</tr>";
echo "<tr>";
echo "<td valign=\"top\"><strong>When</strong></td>";
echo "<td valign=\"top\"><strong>Arrive</strong> ".date('M j, Y', strtotime($txtArriavalDate))." for ".$txtDuration." nights, <strong>Depart</strong> ".date('M j, Y', $txtDepartDateTime)."<br />Dates flexible by ".$txtFlexibleDays." days</td>";
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
			</table>
        </td>
    </tr>
</table>
<?php
} else {
	$sec = $_GET['sec'];
	if(isset($_POST['txtFilter']) && $_POST['txtFilter'] == "1"){		
		$txtProp = $_POST['txtProp'];
    	$strQuery = " AND A.property_id='".$txtProp."' ";
	}
	if(isset($_GET['sortby']) && $_GET['sortby'] != ""){
		$strQuery = " ORDER BY ";
		switch($_GET['sortby']){
			case 'enquirycode':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$enquirycodedr 			= 0;
					$enquiryusrdr 			= 1;
					$enquirypropertydr		= 1;
					$enquirypropertynamedr 	= 1;
					$enquiryaddeddatedr 	= 1;
				} else {
					$dr = "DESC";
					$enquirycodedr 			= 1;
					$enquiryusrdr 			= 1;
					$enquirypropertydr		= 1;
					$enquirypropertynamedr 	= 1;
					$enquiryaddeddatedr 	= 1;
				}
				$strQuery .= " A.enquiry_id ".$dr.", A.enquiry_char ".$dr;
			break;
			case 'enquiryusr':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$enquirycodedr 			= 1;
					$enquiryusrdr 			= 0;
					$enquirypropertydr		= 1;
					$enquirypropertynamedr 	= 1;
					$enquiryaddeddatedr 	= 1;
				} else {
					$dr = "DESC";
					$enquirycodedr 			= 1;
					$enquiryusrdr 			= 1;
					$enquirypropertydr		= 1;
					$enquirypropertynamedr 	= 1;
					$enquiryaddeddatedr 	= 1;
				}
				$strQuery .= " E.user_fname ".$dr;
			break;
			case 'enquiryproperty':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$enquirycodedr 			= 1;
					$enquiryusrdr 			= 1;
					$enquirypropertydr		= 0;
					$enquirypropertynamedr 	= 1;
					$enquiryaddeddatedr 	= 1;
				} else {
					$dr = "DESC";
					$enquirycodedr 			= 1;
					$enquiryusrdr 			= 1;
					$enquirypropertydr		= 1;
					$enquirypropertynamedr 	= 1;
					$enquiryaddeddatedr 	= 1;
				}
				$strQuery .= " A.property_id ".$dr;
			break;
			case 'enquirypropertyname':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$enquirycodedr 			= 1;
					$enquiryusrdr 			= 1;
					$enquirypropertydr		= 1;
					$enquirypropertynamedr 	= 0;
					$enquiryaddeddatedr 	= 1;
				} else {
					$dr = "DESC";
					$enquirycodedr 			= 1;
					$enquiryusrdr 			= 1;
					$enquirypropertydr		= 1;
					$enquirypropertynamedr 	= 1;
					$enquiryaddeddatedr 	= 1;
				}
				$strQuery .= " F.property_name ".$dr;
			break;
			case 'enquiryaddeddate':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$enquirycodedr 			= 1;
					$enquiryusrdr 			= 1;
					$enquirypropertydr		= 1;
					$enquirypropertynamedr 	= 1;
					$enquiryaddeddatedr 	= 0;
				} else {
					$dr = "DESC";
					$enquirycodedr 			= 1;
					$enquiryusrdr 			= 1;
					$enquirypropertydr		= 1;
					$enquirypropertynamedr 	= 1;
					$enquiryaddeddatedr 	= 1;
				}
				$strQuery .= " D.created_on ".$dr;
			break;
		}
	} else {
		$enquirycodedr 			= 1;
		$enquiryusrdr 			= 1;
		$enquirypropertydr		= 1;
		$enquirypropertynamedr 	= 1;
		$enquiryaddeddatedr 	= 1;
	}
	$enquiryListArr = $propertyObj->fun_getPropertyEnquiryInfoArr($strQuery);
//	print_r($enquiryListArr);
	if(count($enquiryListArr) > 0){
	?>
		  <script language="javascript" type="text/javascript">
			function getFilter(){
				var id = document.getElementById("txtPropId").value;
				if(id == "") {
					alert("Enter prop id!");
					document.getElementById("txtPropId").focus();
					return false;
				} else {
					document.getElementById("frmFilter").action = "admin-collateral.php?sec=enquiries";
					document.getElementById("frmFilter").submit();
				}
            }

			function showFilter(strInt){
				if(parseInt(strInt) > 0) {
					document.getElementById("filterTbl").style.display = "block";
				} else {
					location.href = "admin-collateral.php?sec=enquiries";
				}
            }
      
        </script>		
        <form name="frmFilter" id="frmFilter" method="post">
       	<input type="hidden" name="txtFilter" id="txtFilter" value="1" />
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
            <tr><td height="10" colspan="2" valign="top" class="dash-top"></td></tr>
            <tr>
                <td valign="top">
                    <table border="0" cellspacing="0" cellpadding="2" class="boldTitle" style="padding-bottom:10px;">
                        <tr>
                            <td><input name="radio" type="radio" class="radio" id="radio1" value="1" <?php if(!isset($_POST['txtFilter']) || $_POST['txtFilter'] != "1") { echo "checked=\"checked\"";} else {echo "";}?> onclick="return showFilter(0);" /></td>
                            <td>View all</td>
                            <td class="pad-lft20"><input name="radio" type="radio" class="radio" id="radio2" value="2" <?php if(isset($_POST['txtFilter']) && $_POST['txtFilter'] == "1") { echo "checked=\"checked\"";} else {echo "";}?> onclick="return showFilter(1);"/></td>
                            <td>Filter Enquiries</td>
                        </tr>
                    </table>
                </td>
                <td align="right" valign="top">
                    <table border="0" cellspacing="0" cellpadding="0" id="filterTbl" style="display:<?php if(isset($_POST['txtFilter']) && $_POST['txtFilter'] == "1") { echo "block";} else {echo "none";}?>">
                        <tr>
                            <td class="blackTxt14 pad-rgt5" style="font-weight:normal;">Prop ID</td>
                            <td class="pad-rgt5"><input type="text" name="txtProp" id="txtPropId" class="Textfield80 blackText" value="<?php if(isset($_POST['txtProp']) && $_POST['txtProp'] != "") { echo $_POST['txtProp'];} else {echo "";}?>" /></td>
                            <td><a href="javascript:void(0);" onclick="return getFilter();"><img src="images/show-admin.gif" alt="Send" border="0" /></a></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr><td height="10" colspan="2" valign="top" class="dash-top"></td></tr>
		</table>
        </form>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr><td colspan="2" valign="top">&nbsp;</td></tr>
			<tr>
				<td colspan="2" valign="top">
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EventListing">
						<thead>
							<tr>
								<th width="10%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-collateral.php?sec=enquiries&sortby=enquirycode&dr=".$enquirycodedr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "enquirycode")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?> ><div>Enquiry ID</div></th>
								<th width="25%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-collateral.php?sec=enquiries&sortby=enquiryusr&dr=".$enquiryusrdr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "enquiryusr")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?> ><div>From</div></th>
								<th width="15%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-collateral.php?sec=enquiries&sortby=enquiryproperty&dr=".$enquirypropertydr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "enquiryproperty")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Prop ID</div></th>
								<th width="35%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-collateral.php?sec=enquiries&sortby=enquirypropertyname&dr=".$enquirypropertynamedr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "enquirypropertyname")){echo "class=\"rightOver\" onmouseout=\"this.className = 'rightOver';\" ";}else{echo "onmouseout=\"this.className = 'right';\"";}?>><div>Property name</div></th>
								<th width="15%" scope="col" class="right" onmouseover="this.className = 'rightOver';" onclick="sortList('<?php echo "admin-collateral.php?sec=enquiries&sortby=enquiryaddeddate&dr=".$enquiryaddeddatedr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "enquiryaddeddate")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Date</div></th>
							</tr>
						</thead>
						<tbody>
							<?php
                            for($i=0; $i < count($enquiryListArr); $i++){
								$enquiry_id 		= $enquiryListArr[$i]['enquiry_id'];
								$enquiry_char 		= $enquiryListArr[$i]['enquiry_char'];
								$user_name 			= $enquiryListArr[$i]['user_name'];
								$property_id 		= $enquiryListArr[$i]['property_id'];
								$property_name 		= $enquiryListArr[$i]['property_name'];
								$created_on 		= date('M d, Y', $enquiryListArr[$i]['created_on']);
                            ?>
                                <tr>
                                    <td class="left"><a href="admin-collateral.php?sec=enquiries&enquiryid=<?php echo $enquiry_id;?>&char=<?php echo $enquiry_char;?>"><?php echo fill_zero_left($enquiry_id, "0", (6-strlen($enquiry_id)))."(".$enquiry_char.")";?></a></td>
                                    <td><?php echo $user_name;?></td>
                                    <td><?php echo fill_zero_left($property_id, "0", (6-strlen($property_id)));?></td>
                                    <td><?php echo $property_name;?></td>
                                    <td class="right"><?php echo $created_on;?></td>
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
				<td valign="top">No enquiry Added!</td>
			</tr>
		</table>
		<?php
	}
}
?>