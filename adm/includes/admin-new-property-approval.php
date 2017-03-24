<?php
if(isset($property_id) && $property_id !=""){
	//form submission
	$form_array = array();
	$errorMsg 	= "no";

	// Owner property details submit : start here 
	if($_POST['securityKey']==md5(OWNERPROPERTYDETAILS)){		
		if(trim($_POST['txtPropertyName']) == ''){
			$form_array['txtPropertyName'] = 'Please enter a name for your property';
			$errorMsg	= 'yes';
		} else {
			$p_name = trim($_POST['txtPropertyName']);
		}
		if(trim($_POST['txtPropertyTitle']) == ''){
			$form_array['txtPropertyTitle'] = 'Please enter a title for your advert';
			$errorMsg	= 'yes';
		} else {
			$p_title = trim($_POST['txtPropertyTitle']);
		}
		if($_POST['txtPropertyType'] == ''){
			$form_array['txtPropertyType'] = 'Please select a property type';
			$errorMsg	= 'yes';
		} else {
			$p_type = $_POST['txtPropertyType'];
		}

		if($errorMsg == 'no' && $errorMsg != 'yes'){
			if($propertyObj->fun_editProperty($property_id) === true){
				$form_array['error_msg'] = "Property details successfully updated!";
				$propertyObj->fun_updatePropertyLastUpdate($property_id);
				echo "<script> location.href = window.location; </script>";
			} else {
				$form_array['error_msg'] = "Error: We are unable to update your property detail!";
			}
		} else {
			$form_array['error_msg'] = "Please submit your form again!";
		}

	}
	// Owner property details submit : end here 
	// Owner property photos submit : start here 
	if($_POST['securityKey']==md5(OWNERPROPERTYPHOTOS)){		
		if(isset($_POST['txtPhotoCaption']) && $_POST['txtPhotoCaption'] != ''){
			$photo_id_arr 	= $_POST['txtPhotoId'];
			$photo_cap_arr 	= $_POST['txtPhotoCaption'];
			$propertyObj->fun_updatePhotoCaptions($property_id, $photo_id_arr, $photo_cap_arr);
		}
		if(isset($_POST['txtMainPhoto']) && $_POST['txtMainPhoto'] != ''){
			if($propertyObj->fun_updatePhotosMain($property_id, trim($_POST['txtMainPhoto'])) === true){
				$propertyObj->fun_updatePropertyLastUpdate($property_id);
				echo "<script> location.href = window.location; </script>";
			} else {
				$detail_array['error_msg'] = "Error: We are unable to update your property photos detail!";
			}
		} else {
			$detail_array['error_msg'] = "Please submit your form again!";
		}
	}
	// Owner property photos submit : end here 
	// Owner property photos submit : start here 
	if($_POST['securityKey']==md5(OWNERPROPERTYPHOTOSUPLOAD)){		
		if(isset($_POST['txtPhotoId']) && ($_POST['txtPhotoId'] != '') && isset($_FILES['txtFile']) && ($_FILES['txtFile'] !="")){ // edit
			$photo_id 		= $_POST['txtPhotoId'];
			$photo_caption 	= $_POST['txtPhotoCaption'];
			$property_img = basename($_FILES['txtFile']['name']);
			$extn=split("\.",$property_img);
			$photo_main 				= $property_id."_".$photo_id."_photo.".$extn[1];
			$photo_thumb 				= $property_id."_".$photo_id."_photo_thumb.".$extn[1];
			$uploadphotodir 			= '../upload/property_images/large';
			$uploadthumbdir 			= '../upload/property_images/thumbnail';
			$uploadphotofile 			= $uploadphotodir ."/". $photo_main;
			$uploadphotofile600x450 	= $uploadphotodir ."/600x450/". $photo_main;
			$uploadphotofile480x360 	= $uploadphotodir ."/480x360/". $photo_main;
			$uploadphotofile244x183 	= $uploadphotodir ."/244x183/". $photo_main;
			$uploadthumbfile168x126 	= $uploadthumbdir ."/168x126/". $photo_thumb;
			$uploadthumbfile88x66	 	= $uploadthumbdir ."/88x66/". $photo_thumb;
			if (move_uploaded_file($_FILES['txtFile']['tmp_name'], $uploadphotofile)){
				$imgObj->getCrop($uploadphotodir,$photo_main,600,450,$uploadphotofile600x450);
				$imgObj->getCrop($uploadphotodir,$photo_main,480,360,$uploadphotofile480x360);
				$imgObj->getCrop($uploadphotodir,$photo_main,244,183,$uploadphotofile244x183);
				$imgObj->getCrop($uploadphotodir,$photo_main,168,126,$uploadthumbfile168x126);
				$imgObj->getCrop($uploadphotodir,$photo_main,88,66,$uploadthumbfile88x66);
				if($propertyObj->fun_updatePropertyPhotos($property_id, $photo_id, $photo_caption, $photo_main, $photo_thumb) === true){
					$propertyObj->fun_updatePropertyLastUpdate($property_id);
					echo "<script> location.href = window.location; </script>";
				} else {
					$detail_array['error_msg'] = "Error: We are unable to update your property photos detail!";
				}
			} else {
				$detail_array['error_msg'] = "Error: We are unable to update your property photos detail!";
			}
		} else if(isset($_FILES['txtFile']) && ($_FILES['txtFile'] !="")) {
			$photo_caption 	= $_POST['txtPhotoCaption'];
			if(($photo_id = $propertyObj->fun_addPropertyPhotos($property_id)) && $photo_id !="") {
				$property_img = basename($_FILES['txtFile']['name']);
				$extn=split("\.",$property_img);
				$photo_main 				= $property_id."_".$photo_id."_photo.".$extn[1];
				$photo_thumb 				= $property_id."_".$photo_id."_photo_thumb.".$extn[1];
				$uploadphotodir 			= '../upload/property_images/large';
				$uploadthumbdir 			= '../upload/property_images/thumbnail';
				$uploadphotofile 			= $uploadphotodir ."/". $photo_main;
				$uploadphotofile600x450 	= $uploadphotodir ."/600x450/". $photo_main;
				$uploadphotofile480x360 	= $uploadphotodir ."/480x360/". $photo_main;
				$uploadphotofile244x183 	= $uploadphotodir ."/244x183/". $photo_main;
				$uploadthumbfile168x126 	= $uploadthumbdir ."/168x126/". $photo_thumb;
				$uploadthumbfile88x66	 	= $uploadthumbdir ."/88x66/". $photo_thumb;
				if(move_uploaded_file($_FILES['txtFile']['tmp_name'], $uploadphotofile)){
					$imgObj->getCrop($uploadphotodir,$photo_main,600,450,$uploadphotofile600x450);
					$imgObj->getCrop($uploadphotodir,$photo_main,480,360,$uploadphotofile480x360);
					$imgObj->getCrop($uploadphotodir,$photo_main,244,183,$uploadphotofile244x183);
					$imgObj->getCrop($uploadphotodir,$photo_main,168,126,$uploadthumbfile168x126);
					$imgObj->getCrop($uploadphotodir,$photo_main,88,66,$uploadthumbfile88x66);
					if($propertyObj->fun_updatePropertyPhotos($property_id, $photo_id, $photo_caption, $photo_main, $photo_thumb) === true){
					$propertyObj->fun_updatePropertyLastUpdate($property_id);
						echo "<script> location.href = window.location; </script>";
					} else {
						$detail_array['error_msg'] = "Error: We are unable to update your property photos detail!";
					}
				} else {
					$propertyObj->fun_delPropertyPhoto($photo_id);
					$detail_array['error_msg'] = "Error: We are unable to update your property photos detail!";
				}
			}
		} else {
			$detail_array['error_msg'] = "Please submit your form again!";
		}
	}
	// Owner property photos submit : end here 

	// Owner property video submit : start here 
	if($_POST['securityKey']==md5(OWNERPROPERTYVIDEOUPLOAD)){		
		if(isset($_POST['txtVideoCaption']) && $_POST['txtVideoCaption'] != '' && isset($_POST['txtVideoDecription']) && $_POST['txtVideoDecription'] != ''){
			$video_id 		= $_POST['txtVideoId'];
			$video_cap 		= $_POST['txtVideoCaption'];
			$photo_desc 	= $_POST['txtVideoDecription'];
            if(isset($video_id) && $video_id != "") {
                $propertyObj->fun_updatePropertyVideo($property_id, $video_id, $video_cap, $photo_desc);
            } else {
                $propertyObj->fun_addPropertyVideo($property_id, $video_cap, $photo_desc);
            }
		}
	}
	// Owner property video submit : end here 

	// Owner property location submit : start here 
	if($_POST['securityKey']==md5(LOCATIONFORM)){		
		if($errorMsg == 'no' && $errorMsg != 'yes'){
			if($propertyObj->fun_editProperty($property_id) === true){
				$propertyObj->fun_updatePropertyLastUpdate($property_id);
				echo "<script> location.href = window.location; </script>";
			} else {
				$detail_array['error_msg'] = "Error: We are unable to update your property detail!";
			}
		} else {
			$detail_array['error_msg'] = "Please submit your form again!";
		}
	}
	// Owner property location submit : end here 
	// Owner property price submit : start here 
	if($_POST['securityKey'] == md5(OWNERPROPERTYPRICES)){
		if($errorMsg == 'no' && $errorMsg != 'yes'){
			if($propertyObj->fun_editProperty($property_id) === true){
				$propertyObj->fun_updatePropertyLastUpdate($property_id);
				if(isset($_POST['txtPriceId']) && $_POST['txtPriceId'] != "") {
					echo "<script>window.location='admin-pending-approval.php?sec=".$_GET['sec']."&subsec=pri&pid=".$property_id."&msg=updatesuccess'; </script>";
				} else {
					echo "<script>window.location='admin-pending-approval.php?sec=".$_GET['sec']."&subsec=pri&pid=".$property_id."&msg=addsuccess'; </script>";
				}
			} else {
				echo "<script> location.href = window.location; </script>";
			}
		} else {
			$detail_array['error_msg'] = "Please submit your form again!";
		}
	}
	// Owner property price submit : end here 
	// Owner property availablitiy submit : start here 
	if($_POST['securityKey']==md5(OWNERPROPERTYAVAILABILITY)){		
		if($_POST['addAvailablity'] == '1'){
			if($_POST['txtAvailabilityStatus'] == ''){
				$form_array['availabilityError'] = 'Please select availability status';
				$errorMsg	= 'yes';
			} else {
				$txtStatus 	= $_POST['txtAvailabilityStatus'];
			}

			if($_POST['txtYearTo'] == ''){
				$form_array['availabilityError'] = 'Please select year to';
				$errorMsg	= 'yes';
			} else {
				$txtYearTo 	= $_POST['txtYearTo'];
			}

			if($_POST['txtMonthTo'] == ''){
				$form_array['availabilityError'] = 'Please select month to';
				$errorMsg	= 'yes';
			} else {
				$txtMonthTo = $_POST['txtMonthTo'];
			}

			if($_POST['txtDayTo'] == ''){
				$form_array['availabilityError'] = 'Please select date to';
				$errorMsg	= 'yes';
			} else {
				$txtDayTo 	= $_POST['txtDayTo'];
			}

			if($_POST['txtYearFrom'] == ''){
				$form_array['availabilityError'] = 'Please select year from';
				$errorMsg	= 'yes';
			} else {
				$txtYearFrom= $_POST['txtYearFrom'];
			}

			if($_POST['txtMonthFrom'] == ''){
				$form_array['availabilityError'] = 'Please select month from';
				$errorMsg	= 'yes';
			} else {
				$txtMonthFrom= $_POST['txtMonthFrom'];
			}

			if($_POST['txtDayFrom'] == ''){
				$form_array['availabilityError'] = 'Please select date from';
				$errorMsg	= 'yes';
			} else {
				$txtDayFrom = $_POST['txtDayFrom'];
			}
	
			if($errorMsg == 'no' && $errorMsg != 'yes'){
				$txtStartDate 	= date('Y-m-d', strtotime($txtYearFrom."-".$txtMonthFrom."-".$txtDayFrom));
				$txtEndDate 	= date('Y-m-d', strtotime($txtYearTo."-".$txtMonthTo."-".$txtDayTo));
				if($propertyObj->fun_addPropertyAvailablityDetails($property_id, $txtStartDate, $txtEndDate, $txtStatus) === true){
					$propertyObj->fun_updatePropertyLastUpdate($property_id);
					echo "<script>window.location='admin-pending-approval.php?sec=".$_GET['sec']."&subsec=ava&pid=".$property_id."&msg=updatesuccess'; </script>";
				} else {
					echo "<script> location.href = window.location; </script>";
				}
			} else {
				$detail_array['error_msg'] = "Please submit your form again!";
			}
		} else {
			echo "<script> location.href = window.location; </script>";
		}
	}
	// Owner property availablitiy submit : end here 
	// Owner property contact submit : start here 
	if($_POST['securityKey']==md5(OWNERPROPERTYCONTACTS)){		
        if($_POST['txtContactName'] == '') {
            $form_array['contactError'] = 'Please enter contact name';
            $errorMsg	= 'yes';
        }
		if($errorMsg == 'no' && $errorMsg != 'yes'){
			if($propertyObj->fun_editProperty($property_id) === true){
				$propertyObj->fun_updatePropertyLastUpdate($property_id);
				echo "<script> location.href = window.location; </script>";
			} else {
				echo "<script> location.href = window.location; </script>";
			}
		} else {
			$detail_array['error_msg'] = "Please submit your form again!";
		}
	}
	// Owner property contact submit : end here 
	// Owner property decline submit : start here
	if($_POST['securityKey']==md5(OWNERPROPERTYDECLINE)){
		if(!empty($_POST['txtDeclineId'])){
			$owner_id 		= $_POST['owner_id'];
			$ownerArr 		= $usersObj->fun_getUsersInfo($owner_id);
			$owner_fname 	= $ownerArr['user_fname'];
			$owner_lname 	= $ownerArr['user_lname'];
	 		$owner_email 	= trim($ownerArr['user_email']);

			$strMessage = "";
$strMessage .= '<table width="70%"  border="0" cellspacing="10" cellpadding="0">
<tr><td align="center">&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;Hi,</td></tr>
<tr><td> '.trim(ucfirst($owner_fname." ".$owner_lname)).' </td></tr>
<tr><td>&nbsp;Please find reason for decline of your property below:-</td></tr>';
			$txtDeclineId = $_POST['txtDeclineId'];
			for($i = 0; $i < count($txtDeclineId); $i++) {
				$section_id = $txtDeclineId[$i];
				if($section_id == "1") {
					$reason_id 		= $_POST['txtDetailId'];
					$reason_note 	= $_POST['txtDetailNote'];
					$strMessage .= '<tr><td><b>Your property details are incorrect</b><br>'.$reason_note.'</td></tr>';
				} else if($section_id == "2") {
					$reason_id 		= $_POST['txtPhotosId'];
					$reason_note 	= $_POST['txtPhotosNote'];
					$strMessage .= '<tr><td><b>Your property photo details are incorrect</b><br>'.$reason_note.'</td></tr>';
				}  else if($section_id == "3") {
					$reason_id 		= $_POST['txtVideoId'];
					$reason_note 	= $_POST['txtVideoNote'];
					$strMessage .= '<tr><td><b>Your property video details are incorrect</b><br>'.$reason_note.'</td></tr>';
				} else if($section_id == "4") {
					$reason_id 		= $_POST['txtLocationId'];
					$reason_note 	= $_POST['txtLocationNote'];
					$strMessage .= '<tr><td><b>Your property location details are incorrect</b><br>'.$reason_note.'</td></tr>';
				} else if($section_id == "5") {
					$reason_id 		= $_POST['txtPriceId'];
					$reason_note 	= $_POST['txtPriceNote'];
					$strMessage .= '<tr><td><b>Your property price details are incorrect</b><br>'.$reason_note.'</td></tr>';
				} else if($section_id == "6") {
					$reason_id 		= $_POST['txtAvailableId'];
					$reason_note 	= $_POST['txtAvailableNote'];
					$strMessage .= '<tr><td><b>Your property availability details are incorrect</b><br>'.$reason_note.'</td></tr>';
				} else if($section_id == "7") {
					$reason_id 		= $_POST['txtContactId'];
					$reason_note 	= $_POST['txtContactNote'];
					$strMessage .= '<tr><td><b>Your property contact details are incorrect</b><br>'.$reason_note.'</td></tr>';
				} else if($section_id == "8") {
					$reason_id 		= $_POST['txtChklistId'];
					$reason_note 	= $_POST['txtChklistNote'];
					$strMessage .= '<tr><td><b>Your property checklist details are incorrect</b><br>'.$reason_note.'</td></tr>';
				} else if($section_id == "9") {
					$reason_id 		= $_POST['txtLatedealId'];
					$reason_note 	= $_POST['txtLatedealNote'];
					$strMessage .= '<tr><td><b>Your property late deal details are incorrect</b><br>'.$reason_note.'</td></tr>';
				}
				
				// Now add these decline region in the database
				//TABLE_PROPERTY_DECLINE_REASONS
				$propertyObj->fun_addPropertyDeclineReason($property_id, $section_id, $reason_id, $reason_note);
			}

			$section_ids = implode(",", $txtDeclineId);
			$propertyObj->fun_delPropertyDeclineReasonByNotIn($property_id, "$section_ids");
			//TABLE_PROPERTY_ADMIN_REVIEWS
			$propertyObj->fun_updatePropertyReviewedByAdmin($property_id);
			//TABLE_PROPERTY_DECLINE_INFO

$strMessage .= '<tr><td>&nbsp;Best Regards,</td></tr>
</table>';
		require_once("includes/classes/class.Email.php");
		$emailObj = new Email($owner_email, "Manager | rentownersvillas.com <".SITE_ADMIN_EMAIL.">", "Property Decline mail", $strMessage);
		//$emailObj = new Email($owner_email, SITE_ADMIN_EMAIL, "Property Decline mail", $strMessage);
		$emailObj->sendEmail();
		}
	}
	// Owner property decline submit : end here 

	$strQuery = " AND A.property_id='".$property_id."'";
	$propOwnrInfoArr 	= $propertyObj->fun_getPropertyOwnerShortInfoArr($strQuery);
	$propLocInfoArr 	= $propertyObj->fun_getPropertyLocInfoArr($property_id);
	$propAdReviewInfoArr= $propertyObj->fun_getPropertyAdminReviewedInfoArr($property_id);
	$propUpdateInfoArr 	= $propertyObj->fun_getPropertyUpdateInfoArr($property_id);
	$propStatusInfoArr 	= $propertyObj->fun_getPropertyStatusInfoArr($strQuery);

	$sec 				= $_GET['sec'];
	$subsec 			= $_GET['subsec'];
	$strUrlAdd 			= "&pid=".$property_id;
	$propertyInfo 		= $propertyObj->fun_getPropertyInfo($property_id);
	$propertyName 		= $propertyInfo['property_name'];
	$propertyTitle 		= $propertyInfo['property_title'];
	$propertyLatitude 	= $propertyInfo['latitude'];
	$propertyLongitude 	= $propertyInfo['longitude'];

	$linkdet = "admin-pending-approval.php?sec=".$sec."&subsec=det".$strUrlAdd;
	$linkpho = "admin-pending-approval.php?sec=".$sec."&subsec=pho".$strUrlAdd;
	$linkloc = "admin-pending-approval.php?sec=".$sec."&subsec=loc".$strUrlAdd;
	$linkpri = "admin-pending-approval.php?sec=".$sec."&subsec=pri".$strUrlAdd;
	$linkava = "admin-pending-approval.php?sec=".$sec."&subsec=ava".$strUrlAdd;
	$linkcon = "admin-pending-approval.php?sec=".$sec."&subsec=con".$strUrlAdd;

	if($subsec == "det" || $subsec == "") {
		$imgdet = SITE_IMAGES."property-tab/property-detail-tab-cs.gif";
	} else {
		$imgdet = SITE_IMAGES."property-tab/property-detail-tab-ch.gif";
	}
	if($subsec == "pho"){
		$imgpho = SITE_IMAGES."property-tab/property-photo-tab-cs.gif";
	} else {
		$imgpho = SITE_IMAGES."property-tab/property-photo-tab-ch.gif";
	}
	if($subsec == "loc"){
		$imgloc = SITE_IMAGES."property-tab/property-location-tab-cs.gif";
	} else {
		$imgloc = SITE_IMAGES."property-tab/property-location-tab-ch.gif";
	}
	if($subsec == "pri") {
		$imgpri = SITE_IMAGES."property-tab/property-price-tab-cs.gif";
	} else {
		$imgpri = SITE_IMAGES."property-tab/property-price-tab-ch.gif";
	}
	if($subsec == "ava") {
		$imgava = SITE_IMAGES."property-tab/property-availibility-tab-cs.gif";
	} else {
		$imgava = SITE_IMAGES."property-tab/property-availibility-tab-ch.gif";
	}
	if($subsec == "con") {
		$imgcon = SITE_IMAGES."property-tab/property-contact-tab-cs.gif";
	} else {
		$imgcon = SITE_IMAGES."property-tab/property-contact-tab-ch.gif";
	}

	$arrPropertyTab = array(
	array('link'=>$linkdet, 'linktitle'=>'Details', 'imgsrc'=>$imgdet, 'imgwidth'=>'79px', 'imgheight'=>'35px', 'imgalt'=>'Details'),
	array('link'=>$linkpho, 'linktitle'=>'Photos', 'imgsrc'=>$imgpho, 'imgwidth'=>'85px', 'imgheight'=>'35px', 'imgalt'=>'Photos'),
	array('link'=>$linkloc, 'linktitle'=>'Location', 'imgsrc'=>$imgloc, 'imgwidth'=>'95px', 'imgheight'=>'35px', 'imgalt'=>'Location'),
	array('link'=>$linkpri, 'linktitle'=>'Prices', 'imgsrc'=>$imgpri, 'imgwidth'=>'75px', 'imgheight'=>'35px', 'imgalt'=>'Prices'),
	array('link'=>$linkava, 'linktitle'=>'Availability', 'imgsrc'=>$imgava, 'imgwidth'=>'107px', 'imgheight'=>'35px', 'imgalt'=>'Availability'),
	array('link'=>$linkcon, 'linktitle'=>'Contact', 'imgsrc'=>$imgcon, 'imgwidth'=>'89px', 'imgheight'=>'35px', 'imgalt'=>'Contact')
	);

	$pre = '';
	$next= '';
	if(isset($subsec) && $subsec !=""){
		switch($subsec) {
			case 'det':
				$mainPage = "admin-property-details.php";
				$helpPage = SITE_URL."property-add-details-help-pop-up.php";
				$pre = 'det';
				$next= 'pho';
			break;
			case 'pho':
				$mainPage = "admin-property-photos.php";
				$helpPage = SITE_URL."property-add-photo-help-pop-up.php";
				$pre = 'det';
				$next= 'vid';
			break;
			case 'loc':
				$mainPage = "admin-property-location.php";
				$helpPage = SITE_URL."property-add-location-help-pop-up.php";
				$pre = 'vid';
				$next= 'pri';
			break;
			case 'pri':
				$mainPage = "admin-property-prices.php";
				$helpPage = SITE_URL."property-add-price-help-pop-up.php";
				$pre = 'loc';
				$next= 'ava';
			break;
			case 'ava':
				$mainPage = "admin-property-availability.php";
				$helpPage = SITE_URL."property-add-availability-help-pop-up.php";
				$pre = 'pri';
				$next= 'con';
			break;
			case 'con':
				$mainPage = "admin-property-contact.php";
				$helpPage = SITE_URL."property-add-contact-help-pop-up.php";
				$pre = 'ava';
				$next= 'che';
			break;
		}
	} else {
		$subsec = 'det';
		$mainPage = "admin-property-details.php";
		$helpPage = SITE_URL."property-add-details-help-pop-up.php";
		$pre = 'det';
		$next= 'pho';
	}
	set_time_limit(20);
?>

<link href="includes/css/admin-properties.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript">
	var req = ajaxFunction(); 
	function sbmtPropApproval(strId){
		var location_id = '<?php echo $propLocInfoArr['location_id']; ?>';
		var location_name = '<?php echo $propLocInfoArr['location_name']; ?>';
		var location_status = '<?php echo $propLocInfoArr['location_status']; ?>';
		var region_id = '<?php echo $propLocInfoArr['region_id']; ?>';
		var region_name = '<?php echo $propLocInfoArr['region_name']; ?>';
		var region_status = '<?php echo $propLocInfoArr['region_status']; ?>';

		if((location_id != '' && location_name != '' && location_status != '2') || (region_id != '' && region_name != '' && region_status != '2')) {
			var strHTML = "";
			if((location_id != '' && location_name != '' && location_status != '2') && (region_id != '' && region_name != '' && region_status != '2')) {
				strHTML = "Area and location are not approved, to approve <a href='javascript:void(0);' onclick='sbmtLocationApproval(\""+location_id+"\", \""+region_id+"\");'>click here</a>";
			} else if((location_id != '' && location_name != '' && location_status != '2')) {
				strHTML = "Location is not approved, to approve <a href='javascript:void(0);' onclick='sbmtLocationApproval(\""+location_id+"\", \"\");'>click here</a>";
			} else if((region_id != '' && region_name != '' && region_status != '2')) {
				strHTML = "Area is not approved, to approve <a href='javascript:void(0);' onclick='sbmtLocationApproval(\"\", \""+region_id+"\");'>click here</a>";
			}
			document.getElementById("propStatusShowId").innerHTML 	= "<font color='#CF0000' size='2'>"+strHTML+"</font>";
		} else {
			var strId = strId;
			req.open('get', 'includes/ajax/admin-property-pending-approvalXml.php?pid=' + strId + '&mode=approve'); 
			req.onreadystatechange = handleApprovalResponse; 
			req.send(null);
		} 
	}
	
	function sbmtLocationApproval(strLocId, strRegId){
		var strLocId = strLocId;
		var strRegId = strRegId;
		req.open('get', 'includes/ajax/admin-region-location-pending-approvalXml.php?location_id=' + strLocId + '&region_id=' + strRegId + '&mode=approve'); 
		req.onreadystatechange = handleLocationApprovalResponse; 
		req.send(null); 
	}

	function handleLocationApprovalResponse() { 
		if(req.readyState == 4){ 
			var response = req.responseText; 
			xmlDoc=req.responseXML;
			var root = xmlDoc.getElementsByTagName('properties')[0];
			if(root != null){
				var items = root.getElementsByTagName("property");
				var item = items[0];
				var propertystatus = item.getElementsByTagName("propertystatus")[0].firstChild.nodeValue;
				if(propertystatus == "Approved"){
					location.href = window.location;		
				}
			} else {
				document.getElementById("propStatusShowId").innerHTML 	= "<font color='#CF0000' size='2'><strong>Error, try later!</strong></font>";
			}
		} else {
			document.getElementById("propStatusShowId").innerHTML 	= "<font color='#CF0000' size='2'><strong>Please wait...</strong></font>";
		}
	} 

	function sbmtPropDecline(strId){
		document.getElementById("showDeclineReasonId").style.display = "block";
		var strId = strId;
		req.open('get', 'includes/ajax/admin-property-pending-approvalXml.php?pid=' + strId + '&mode=decline'); 
		req.onreadystatechange = handleApprovalResponse; 
		req.send(null); 
	}
	
	function sbmtPropSuspend(strId){
		var strId = strId;
		req.open('get', 'includes/ajax/admin-property-pending-approvalXml.php?pid=' + strId + '&mode=suspend'); 
		req.onreadystatechange = handleApprovalResponse; 
		req.send(null); 
	}
	
	function handleApprovalResponse() { 
		if(req.readyState == 4){ 
			var response = req.responseText; 
			xmlDoc=req.responseXML;
			var root = xmlDoc.getElementsByTagName('properties')[0];
			if(root != null){
				var items = root.getElementsByTagName("property");
				var item = items[0];
				var propertystatus = item.getElementsByTagName("propertystatus")[0].firstChild.nodeValue;
				if(propertystatus == "Approved"){
					document.getElementById("propStatusShowId").innerHTML 	= "<font color='#CF0000' size='2'><strong>"+propertystatus+"</strong></font>";
				} else if(propertystatus == "Declined"){
					document.getElementById("propStatusShowId").innerHTML 	= "<font color='#CF0000' size='2'><strong>"+propertystatus+"</strong></font>";
				} else if(propertystatus == "Suspended"){
					document.getElementById("propStatusShowId").innerHTML 	= "<font color='#CF0000' size='2'><strong>"+propertystatus+"</strong></font>";
				} else {
					document.getElementById("propStatusShowId").innerHTML 	= "<font color='#CF0000' size='2'><strong>Error, try later!</strong></font>";
				}
			} else {
				document.getElementById("propStatusShowId").innerHTML 	= "<font color='#CF0000' size='2'><strong>Error, try later!</strong></font>";
			}
		} else {
			document.getElementById("propStatusShowId").innerHTML 	= "<font color='#CF0000' size='2'><strong>Please wait...</strong></font>";
		}
	} 
	
	function frmSubmitWithTabs(strLink) {
		document.getElementById("frmPropertyId").action = strLink;
		frmSubmit();
	}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td valign="top"><a href="admin-pending-approval.php?sec=<?php echo $sec;?>" class="arrowLinkback">Back to list</a></td>
        <td align="right" valign="top" style="display:none;">
            <a href="#" class="arrowLinkback">Previous</a>&nbsp; <span class="boldblack12">|</span> &nbsp; 
            <a href="#" class="arrowLinkNext">Next</a>
        </td>
    </tr>
    <tr><td colspan="2" valign="top" class="dash15">&nbsp;</td></tr>
    <tr>
        <td colspan="2" valign="top">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td valign="top" width="100">Property ID</td>
                    <td valign="top"><?php echo fill_zero_left($propOwnrInfoArr[0]['property_id'], "0", (6-strlen($propOwnrInfoArr[0]['property_id'])));?></td>
                </tr>
                <tr>
                    <td valign="top" width="100">Owner ID</td>
                    <td valign="top"><a href="#" class="blueTxt"><?php echo fill_zero_left($propOwnrInfoArr[0]['owner_id'], "0", (6-strlen($propOwnrInfoArr[0]['owner_id'])));?></a></td>
                </tr>
                <tr>
                    <td valign="top" width="100">Owner name</td>
                    <td valign="top"><?php echo ucwords($propOwnrInfoArr[0]['user_fname']." ".$propOwnrInfoArr[0]['user_lname']); ?></td>
                </tr>
                <tr>
                    <td valign="top" width="100">Property name</td>
                    <td valign="top"><?php echo ucwords($propOwnrInfoArr[0]['property_name']); ?></td>
                </tr>
                <tr>
                    <td valign="top" width="100">Date added</td>
                    <td valign="top"><?php echo date('M d, Y', strtotime($propOwnrInfoArr[0]['created_on'])); ?></td>
                </tr>
                <tr>
                    <td valign="top" width="100">Paid</td>
                    <td valign="top">
						<?php
						if(($propertyObj->fun_checkPropertyProductPayments("6", $property_id) == true)) {
							echo "Yes";
						} else {
							echo "<span style=\"color:#FF0000;\">No</span>";
						}
						?>
					</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr><td colspan="2" valign="top" class="dash15">&nbsp;</td></tr>
    <tr>
        <td colspan="2" valign="top">
            <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td valign="top" width="100">Last updated</td>
                    <td valign="top" width="80"><strong>Details</strong></td>
                    <td valign="top" width="180"><?php echo date('M d, Y', strtotime($propUpdateInfoArr['details_updated_on'])); if((int)((mktime(0, 0, 0, date('m'), date('d'), date('Y')) - strtotime($propUpdateInfoArr['details_updated_on'])) / (60 * 60 * 24)) < 7) { echo "<img src=\"".SITE_ADMIN_IMAGES."Flag.gif\" class=\"Flag\" alt=\"Flag\" width=\"9\" height=\"15\" />"; } ?></td>
                    <td valign="top" width="80"><strong>Availability</strong></td>
                    <td valign="top" width="180"><?php if(isset($propUpdateInfoArr['availability_updated_on']) && $propUpdateInfoArr['availability_updated_on']!="") {echo date('M d, Y', strtotime($propUpdateInfoArr['availability_updated_on']));  if((int)((mktime(0, 0, 0, date('m'), date('d'), date('Y')) - strtotime($propUpdateInfoArr['availability_updated_on'])) / (60 * 60 * 24)) < 7) { echo "<img src=\"".SITE_ADMIN_IMAGES."Flag.gif\" class=\"Flag\" alt=\"Flag\" width=\"9\" height=\"15\" />"; }} else { echo " ----- ";} ?></td>
                </tr>
                <tr>
                    <td valign="top" width="100">&nbsp;</td>
                    <td valign="top" width="80"><strong>Photos</strong></td>
                    <td valign="top" width="180"><?php if(isset($propUpdateInfoArr['photo_updated_on']) && $propUpdateInfoArr['photo_updated_on']!="") {echo date('M d, Y', strtotime($propUpdateInfoArr['photo_updated_on'])); if((int)((mktime(0, 0, 0, date('m'), date('d'), date('Y')) - strtotime($propUpdateInfoArr['photo_updated_on'])) / (60 * 60 * 24)) < 7) { echo "<img src=\"".SITE_ADMIN_IMAGES."Flag.gif\" class=\"Flag\" alt=\"Flag\" width=\"9\" height=\"15\" />"; }} else { echo " ----- ";} ?></td>
                    <td valign="top" width="80"><strong>Contact</strong></td>
                    <td valign="top" width="180"><?php if(isset($propUpdateInfoArr['contact_updated_on']) && $propUpdateInfoArr['contact_updated_on']!="") {echo date('M d, Y', strtotime($propUpdateInfoArr['contact_updated_on'])); if((int)((mktime(0, 0, 0, date('m'), date('d'), date('Y')) - strtotime($propUpdateInfoArr['contact_updated_on'])) / (60 * 60 * 24)) < 7) { echo "<img src=\"".SITE_ADMIN_IMAGES."Flag.gif\" class=\"Flag\" alt=\"Flag\" width=\"9\" height=\"15\" />"; }} else { echo " ----- ";} ?></td>
                </tr>
                <tr>
                    <td valign="top" width="100">&nbsp;</td>
                    <td valign="top" width="80"><strong>Video</strong></td>
                    <td valign="top" width="180"><?php if(isset($propUpdateInfoArr['video_updated_on']) && $propUpdateInfoArr['video_updated_on']!="") {echo date('M d, Y', strtotime($propUpdateInfoArr['video_updated_on']));  if((int)((mktime(0, 0, 0, date('m'), date('d'), date('Y')) - strtotime($propUpdateInfoArr['video_updated_on'])) / (60 * 60 * 24)) < 7) { echo "<img src=\"".SITE_ADMIN_IMAGES."Flag.gif\" class=\"Flag\" alt=\"Flag\" width=\"9\" height=\"15\" />"; }} else { echo " ----- ";} ?></td>
                    <td valign="top" width="80" style="display:none;"><strong>Checklist</strong></td>
                    <td valign="top" width="180" style="display:none;"><?php if(isset($propUpdateInfoArr['checklist_updated_on']) && $propUpdateInfoArr['checklist_updated_on']!="") {echo date('M d, Y', strtotime($propUpdateInfoArr['checklist_updated_on'])); if((int)((mktime(0, 0, 0, date('m'), date('d'), date('Y')) - strtotime($propUpdateInfoArr['checklist_updated_on'])) / (60 * 60 * 24)) < 7) { echo "<img src=\"".SITE_ADMIN_IMAGES."Flag.gif\" class=\"Flag\" alt=\"Flag\" width=\"9\" height=\"15\" />"; }} else { echo " ----- ";} ?></td>
                </tr>
                <tr>
                    <td valign="top" width="100">&nbsp;</td>
                    <td valign="top" width="80"><strong>Location</strong></td>
                    <td valign="top" width="180"><?php if(isset($propUpdateInfoArr['location_updated_on']) && $propUpdateInfoArr['location_updated_on']!="") {echo date('M d, Y', strtotime($propUpdateInfoArr['location_updated_on']));  if((int)((mktime(0, 0, 0, date('m'), date('d'), date('Y')) - strtotime($propUpdateInfoArr['location_updated_on'])) / (60 * 60 * 24)) < 7) { echo "<img src=\"".SITE_ADMIN_IMAGES."Flag.gif\" class=\"Flag\" alt=\"Flag\" width=\"9\" height=\"15\" />"; }} else { echo " ----- ";} ?></td>
                    <td valign="top" width="80" style="display:none;"><strong>Specials</strong></td>
                    <td valign="top" width="180" style="display:none;"><?php if(isset($propUpdateInfoArr['deal_updated_on']) && $propUpdateInfoArr['deal_updated_on']!="") {echo date('M d, Y', strtotime($propUpdateInfoArr['deal_updated_on']));  if((int)((mktime(0, 0, 0, date('m'), date('d'), date('Y')) - strtotime($propUpdateInfoArr['deal_updated_on'])) / (60 * 60 * 24)) < 7) { echo "<img src=\"".SITE_ADMIN_IMAGES."Flag.gif\" class=\"Flag\" alt=\"Flag\" width=\"9\" height=\"15\" />"; }} else { echo " ----- ";} ?></td>
                </tr>
                <tr>
                    <td valign="top" width="100">&nbsp;</td>
                    <td valign="top" width="80"><strong>Prices</strong></td>
                    <td valign="top" width="180"><?php if(isset($propUpdateInfoArr['price_updated_on']) && $propUpdateInfoArr['price_updated_on']!="") {echo date('M d, Y', strtotime($propUpdateInfoArr['price_updated_on'])); if((int)((mktime(0, 0, 0, date('m'), date('d'), date('Y')) - strtotime($propUpdateInfoArr['price_updated_on'])) / (60 * 60 * 24)) < 7) { echo "<img src=\"".SITE_ADMIN_IMAGES."Flag.gif\" class=\"Flag\" alt=\"Flag\" width=\"9\" height=\"15\" />"; }} else { echo " ----- ";} ?></td>
                    <td valign="top" width="80"><strong>&nbsp;</strong></td>
                    <td valign="top" width="180">&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr><td colspan="2" valign="top" class="dash15">&nbsp;</td></tr>
    <tr>
        <td colspan="2" valign="top" class="pad-btm17">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td valign="top" width="100">Location</td>
                    <td valign="top">
                    <?php
					$propLoc = "";
					if(isset($propLocInfoArr)) {
						if($propLocInfoArr['countries_name'] != "") {
							$propLoc .= ucwords($propLocInfoArr['countries_name'])." > ";
						}
						if($propLocInfoArr['area_name'] != "") {
							$propLoc .= ucwords($propLocInfoArr['area_name'])." > ";
						}
						if($propLocInfoArr['region_name'] != "") {
							$propLoc .= ucwords($propLocInfoArr['region_name'])." > ";
						}
						if($propLocInfoArr['subregion_name'] != "") {
							$propLoc .= ucwords($propLocInfoArr['subregion_name'])." > ";
						}
						if($propLocInfoArr['location_name'] != "") {
							$propLoc .= ucwords($propLocInfoArr['location_name'])."";
						}
					}
					echo $propLoc;
					?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2" valign="top" class="adminBox">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="80" valign="top" class="owner-headings6">Status</td>
                    <td valign="bottom" class="black pad-top2"><div id="propStatusShowId"><strong><?php echo ucfirst($propStatusInfoArr[0]['status_name']);?></strong></div></td>
                </tr>
				<?php
                if(is_array($propAdReviewInfoArr)) {
                ?>
                <tr>
                    <td width="80" valign="top">&nbsp;</td>
                    <td valign="bottom" class="black pad-top2"><div style="float:left;">Last reviewed by <span style="color:#FF0000;"><?php echo ucwords($propAdReviewInfoArr[0]['user_fname']." ".$propAdReviewInfoArr[0]['user_lname']); ?></span></div></td>
                </tr>
                <tr>
                    <td width="80" valign="top">&nbsp;</td>
                    <td valign="bottom" class="black pad-top2"><div style="float:left;">Date Reviewed and updated <span style="color:#FF0000;"><?php echo $propAdReviewInfoArr[0]['reviewed_on']; ?></span></div></td>
                </tr>
				<?php
                }
                ?>
                <tr>
                    <td>&nbsp;</td>
                    <td class="pad-top13">
                        <?php if($propStatusInfoArr[0]['status_id'] != "2"){?><a href="javascript:sbmtPropApproval(<?php echo $property_id;?>);"><img src="<?php echo SITE_ADMIN_IMAGES;?>approve.gif" alt="Approve"/></a><?php } else{?><img src="<?php echo SITE_ADMIN_IMAGES;?>approve.gif" alt="Approve"/><?php }?>
                        <?php if($propStatusInfoArr[0]['status_id'] != "3"){?><a href="javascript:sbmtPropDecline(<?php echo $property_id;?>);"><img src="<?php echo SITE_ADMIN_IMAGES;?>decline.gif" alt="Decline" class="pad-left3"/></a><?php } else{?><img src="<?php echo SITE_ADMIN_IMAGES;?>decline.gif" alt="Decline" class="pad-left3"/><?php }?>
                        <?php if($propStatusInfoArr[0]['status_id'] != "4"){?><a href="javascript:sbmtPropSuspend(<?php echo $property_id;?>);"><img src="<?php echo SITE_ADMIN_IMAGES;?>suspend.gif" class="pad-left3" alt="Suspend"/></a><?php } else{?><img src="<?php echo SITE_ADMIN_IMAGES;?>suspend.gif" class="pad-left3" alt="Suspend"/><?php }?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div id="showDeclineReasonId" style="display:none;">
                        <form name="frmPropDecline" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
                            <input type="hidden" name="securityKey" value="<?php echo md5(OWNERPROPERTYDECLINE);?>" />
                            <input type="hidden" name="owner_id" value="<?php echo $propOwnrInfoArr[0]['owner_id'];?>" />
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td colspan="2" class="pad-top20 pad-lft20"><span class="owner-headings1">Reasons for declining </span> Check box to flag a section </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="pad-top7 pad-btm7 pad-lft20"><a href="#" class="addiconLink">Add new reasons</a></td>
                                </tr>
                                <tr><td height="5" colspan="2" class="dash-top"></td></tr>
                                <tr>
                                    <td colspan="2" class="pad-lft20">
                                        <table border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td colspan="2" class="pad-rgt5 pad-btm7">
                                                    <table border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td align="left"><input name="txtDeclineId[]" type="checkbox" class="checkbox" id="txtDeclineId1" checked="checked" value="1" onclick="showHideSection('txtDetailRowId')"/></td>
                                                            <td class="pad-left3"><span class="chklistQ">Details</span></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="pad-rgt5 pad-btm7">
                                                    <table border="0" cellpadding="0" cellspacing="0" style="display:block;" id="txtDetailRowId">
                                                        <tr>
                                                            <td class="pad-rgt5 pad-lft16">Select reason</td>
                                                            <td align="right">
                                                                <select name="txtDetailId" class="listMenu477" id="txtDetailId">
                                                                    <option value="1">Details are not filled in correctly, spelling and grammar errors</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td class="pad-top7 pad-btm7"><a href="javascript:showHideSection('txtDetailNoteDivId');" class="removeiconLink">Remove notes</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td align="right" class="pad-btm10"><div style="display:block" id="txtDetailNoteDivId"><textarea name="txtDetailNote" cols="45" rows="5" class="Textarea477" id="txtDetailNoteId"></textarea></div></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="dash-top pad-lft20 pad-top7">
                                        <table border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td colspan="2" class="pad-rgt5 pad-btm5">
                                                    <table border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td align="left"><input name="txtDeclineId[]" type="checkbox" class="checkbox" id="txtDeclineId2" value="2" onclick="showHideSection('txtPhotosRowId')"/></td>
                                                            <td class="pad-left3"><span class="chklistQ">Photos</span></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="pad-rgt5">
                                                    <table border="0" cellpadding="0" cellspacing="0" style="display:none;" id="txtPhotosRowId">
                                                        <tr>
                                                            <td class="pad-rgt5 pad-lft16">Select reason</td>
                                                            <td align="right">
                                                                <select name="txtPhotosId" class="listMenu477" id="txtPhotosId">
                                                                    <option value="2">Photos are not uploaded</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td class="pad-top7 pad-btm7"><a href="javascript:showHideSection('txtPhotosNoteDivId');" class="removeiconLink">Remove notes</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td align="right" class="pad-btm10"><div style="display:block" id="txtPhotosNoteDivId"><textarea name="txtPhotosNote" cols="45" rows="5" class="Textarea477" id="txtPhotosNoteId"></textarea></div></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="dash-top pad-lft20 pad-top7">
                                        <table border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td colspan="2" class="pad-rgt5 pad-btm5">
                                                    <table border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td align="left"><input name="txtDeclineId[]" type="checkbox" class="checkbox" id="txtDeclineId3" value="3" onclick="showHideSection('txtVideosRowId')"/></td>
                                                            <td class="pad-left3"><span class="chklistQ">Video</span></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="pad-rgt5">
                                                    <table border="0" cellpadding="0" cellspacing="0" style="display:none;" id="txtVideosRowId">
                                                        <tr>
                                                            <td class="pad-rgt5 pad-lft16">Select reason</td>
                                                            <td align="right">
                                                                <select name="txtVideoId" class="listMenu477" id="txtVideoId">
                                                                    <option value="3">Video is not uploaded</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td class="pad-top7 pad-btm7"><a href="javascript:showHideSection('txtVideoNoteDivId');" class="removeiconLink">Remove notes</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td align="right" class="pad-btm10"><div style="display:block" id="txtVideoNoteDivId"><textarea name="txtVideoNote" cols="45" rows="5" class="Textarea477" id="txtVideoNote"></textarea></div></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2" class="dash-top pad-lft20 pad-top7">
                                        <table border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td colspan="2" class="pad-rgt5 pad-btm5">
                                                    <table border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td align="left"><input name="txtDeclineId[]" type="checkbox" class="checkbox" id="txtDeclineId4" value="4" onclick="showHideSection('txtLocationsRowId')"/></td>
                                                            <td class="pad-left3"><span class="chklistQ">Location</span></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="pad-rgt5">
                                                    <table border="0" cellpadding="0" cellspacing="0" style="display:none;" id="txtLocationsRowId">
                                                        <tr>
                                                            <td class="pad-rgt5 pad-lft16">Select reason</td>
                                                            <td align="right">
                                                                <select name="txtLocationId" class="listMenu477" id="txtLocationId">
                                                                    <option value="4">Location details not entered correctly</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td class="pad-top7 pad-btm7"><a href="javascript:showHideSection('txtLocationNoteDivId');" class="removeiconLink">Remove notes</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td align="right" class="pad-btm10"><div style="display:block" id="txtLocationNoteDivId"><textarea name="txtLocationNote" cols="45" rows="5" class="Textarea477" id="txtLocationNote"></textarea></div></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2" class="dash-top pad-lft20 pad-top7">
                                        <table border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td colspan="2" class="pad-rgt5 pad-btm5">
                                                    <table border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td align="left"><input name="txtDeclineId[]" type="checkbox" class="checkbox" id="txtDeclineId5" value="5" onclick="showHideSection('txtPricesRowId')" /></td>
                                                            <td class="pad-left3"><span class="chklistQ">Prices</span></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="pad-rgt5">
                                                    <table border="0" cellpadding="0" cellspacing="0" style="display:none;" id="txtPricesRowId">
                                                        <tr>
                                                            <td class="pad-rgt5 pad-lft16">Select reason</td>
                                                            <td align="right">
                                                                <select name="txtPriceId" class="listMenu477" id="txtLocationId">
                                                                    <option value="5">Price details not entered correctly</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td class="pad-top7 pad-btm7"><a href="javascript:showHideSection('txtPriceNoteDivId');" class="removeiconLink">Remove notes</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td align="right" class="pad-btm10"><div style="display:block" id="txtPriceNoteDivId"><textarea name="txtPriceNote" cols="45" rows="5" class="Textarea477" id="txtPriceNote"></textarea></div></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2" class="dash-top pad-lft20 pad-top7">
                                        <table border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td colspan="2" class="pad-rgt5 pad-btm5">
                                                    <table border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td align="left"><input name="txtDeclineId[]" type="checkbox" class="checkbox" id="txtDeclineId6" value="6" onclick="showHideSection('txtAvailableRowId')" /></td>
                                                            <td class="pad-left3"><span class="chklistQ">Availability</span></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="2" class="pad-rgt5">
                                                    <table border="0" cellpadding="0" cellspacing="0" style="display:none;" id="txtAvailableRowId">
                                                        <tr>
                                                            <td class="pad-rgt5 pad-lft16">Select reason</td>
                                                            <td align="right">
                                                                <select name="txtAvailableId" class="listMenu477" id="txtAvailableId">
                                                                    <option value="6">Availability details not entered correctly</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td class="pad-top7 pad-btm7"><a href="javascript:showHideSection('txtAvailableNoteDivId');" class="removeiconLink">Remove notes</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td align="right" class="pad-btm10"><div style="display:block" id="txtAvailableNoteDivId"><textarea name="txtAvailableNote" cols="45" rows="5" class="Textarea477" id="txtAvailableNote"></textarea></div></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2" class="dash-top pad-lft20 pad-top7">
                                        <table border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td colspan="2" class="pad-rgt5 pad-btm5">
                                                    <table border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td align="left"><input name="txtDeclineId[]" type="checkbox" class="checkbox" id="txtDeclineId7" value="7" onclick="showHideSection('txtContactRowId')" /></td>
                                                            <td class="pad-left3"><span class="chklistQ">Contact</span></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="pad-rgt5">
                                                    <table border="0" cellpadding="0" cellspacing="0" style="display:none;" id="txtContactRowId">
                                                        <tr>
                                                            <td class="pad-rgt5 pad-lft16">Select reason</td>
                                                            <td align="right">
                                                                <select name="txtContactId" class="listMenu477" id="txtContactId">
                                                                    <option value="7">Contact details not entered correctly</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td class="pad-top7 pad-btm7"><a href="javascript:showHideSection('txtContactNoteDivId');" class="removeiconLink">Remove notes</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td align="right" class="pad-btm10"><div style="display:block" id="txtContactNoteDivId"><textarea name="txtContactNote" cols="45" rows="5" class="Textarea477" id="txtContactNote"></textarea></div></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2" class="dash-top pad-lft20 pad-top7">
                                        <table border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td colspan="2" class="pad-rgt5 pad-btm5">
                                                    <table border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td align="left"><input name="txtDeclineId[]" type="checkbox" class="checkbox" id="txtDeclineId7" value="8" onclick="showHideSection('txtChklistRowId')" /></td>
                                                            <td class="pad-left3"><span class="chklistQ">Checklist</span></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="pad-rgt5">
                                                    <table border="0" cellpadding="0" cellspacing="0" style="display:none;" id="txtChklistRowId">
                                                        <tr>
                                                            <td class="pad-rgt5 pad-lft16">Select reason</td>
                                                            <td align="right">
                                                                <select name="txtChklistId" class="listMenu477" id="txtChklistId">
                                                                    <option value="8">Checklist details not entered correctly</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td class="pad-top7 pad-btm7"><a href="javascript:showHideSection('txtChklistNoteDivId');" class="removeiconLink">Remove notes</a></td>
                                                        </tr>

                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td align="right" class="pad-btm10"><div style="display:block" id="txtChklistNoteDivId"><textarea name="txtChklistNote" cols="45" rows="5" class="Textarea477" id="txtChklistNote"></textarea></div></td>
                                                        </tr>

                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2" class="dash-top pad-lft20 pad-top7">
                                        <table border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td colspan="2" class="pad-rgt5 pad-btm5">
                                                    <table border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td align="left"><input name="txtDeclineId[]" type="checkbox" class="checkbox" id="txtDeclineId7" value="9" onclick="showHideSection('txtLatedealRowId')" /></td>
                                                            <td class="pad-left3"><span class="chklistQ">Late Deal</span></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="pad-rgt5">
                                                    <table border="0" cellpadding="0" cellspacing="0" style="display:none;" id="txtLatedealRowId">
                                                        <tr>
                                                            <td class="pad-rgt5 pad-lft16">Select reason</td>
                                                            <td align="right">
                                                                <select name="txtLatedealId" class="listMenu477" id="txtLatedealId">
                                                                    <option value="9">Late deal details not entered correctly</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td class="pad-top7 pad-btm7"><a href="javascript:showHideSection('txtLatedealNoteDivId');" class="removeiconLink">Remove notes</a></td>
                                                        </tr>

                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td align="right" class="pad-btm10"><div style="display:block" id="txtLatedealNoteDivId"><textarea name="txtLatedealNote" cols="45" rows="5" class="Textarea477" id="txtLatedealNote"></textarea></div></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr><td colspan="2">&nbsp;</td></tr>
                                <tr>
                                    <td colspan="2" class="pad-lft20 pad-rgt20 pad-btm7">
                                        <p class="FloatLft"><a href="<?php echo $_SERVER['REQUEST_URI']; ?>"><img src="<?php echo SITE_ADMIN_IMAGES;?>cancel-admin.gif" alt="cancel"/></a></p>
                                        <span class="FloatRgt">
                                        <input type="image" src="<?php echo SITE_ADMIN_IMAGES;?>send.gif" alt="Send">
                                        </span>
                                    </td>
                                </tr>
                                <tr><td colspan="2">&nbsp;</td></tr>
                            </table>
                        </form>                        
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr><td colspan="2" valign="top">&nbsp;</td></tr>
    <tr>
        <td align="left" valign="top" colspan="2">
			<div class="width690 pad-btm30">
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<td valign="top">
							<div class="FloatLft pad-rgt20 pad-btm20">
								<h1 class="page-headingNew"><?php echo ucfirst($propertyName);?></h1>
								<span class="font14-darkgrey lineHight18" style="clear:both;display:block;"><?php echo ucfirst($propertyTitle);?></span>
								<span class="reference" style="clear:both;display:block;">Property reference: <?php echo fill_zero_left($property_id, "0", (6-strlen($property_id)));?></span>
							</div>
						</td>
					</tr>
				</table>
			</div>
			<div class="width690">
				<table width="690" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td colspan="3" align="left" valign="top">
							<table cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td colspan="3" align="left" class="imgVertical" valign="bottom" style="background:url(<?php echo SITE_IMAGES;?>chklst-bg.gif) repeat-x bottom;">
									<!--Tabbing Starts Here -->
									<ul>
										<li><img src="<?php echo SITE_IMAGES;?>chklst-bg.gif" alt="CheckList" /></li>
										<?php
										foreach($arrPropertyTab as $value){
											$link 		= $value['link'];
											$linktitle 	= $value['linktitle'];
											$imgsrc 	= $value['imgsrc'];
											$imgwidth 	= $value['imgwidth'];
											$imgheight 	= $value['imgheight'];
											$imgalt 	= $value['imgalt'];
											echo "<li><a href='#' onclick=\"return frmSubmitWithTabs('".$link."');\" title='".$linktitle."'><img src='".$imgsrc."' width='".$imgwidth."' height='".$imgheight."' border='0' alt='".$imgalt."' /></a></li>";
										}
										?>
										<li style="padding-top:10px; float:right; padding-right:5px;"><a href="<?php echo SITE_URL."holiday-property-preview.php?pid=".$property_id; ?>" class="blue-link">Preview</a> | <a href="#" onClick="MM_openWindow('<?php echo $helpPage; ?>', 'childwindow', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=700,height=800')" class="blue-link">Help?</a></li>
									</ul>
									<!--Tabbing Ends Here -->
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>
			<?php
            if(isset($mainPage)){
                include_once("includes/".$mainPage);
            }
            ?>
        </td>
    </tr>
</table>
<?php
} else {
	$sec = $_GET['sec'];
	if(isset($_GET['sortby']) && $_GET['sortby'] != ""){
		$strQuery = " ORDER BY ";
		switch($_GET['sortby']){
			case 'propid':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$propiddr 	= 0;
					$ownriddr 	= 1;
					$ownrnamedr = 1;
					$propnamedr = 1;
					$updatedr 	= 1;
					$registerdr = 1;
					$expiredr 	= 1;
					$statusdr 	= 1;
				} else {
					$dr = "DESC";
					$propiddr 	= 1;
					$ownriddr 	= 1;
					$ownrnamedr = 1;
					$propnamedr = 1;
					$updatedr 	= 1;
					$registerdr = 1;
					$expiredr 	= 1;
					$statusdr 	= 1;
				}
				$strQuery .= " A.property_id ".$dr;
			break;
			case 'ownrid':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$propiddr 	= 1;
					$ownriddr 	= 0;
					$ownrnamedr = 1;
					$propnamedr = 1;
					$updatedr 	= 1;
					$registerdr = 1;
					$expiredr 	= 1;
					$statusdr 	= 1;
				} else {
					$dr = "DESC";
					$propiddr 	= 1;
					$ownriddr 	= 1;
					$ownrnamedr = 1;
					$propnamedr = 1;
					$updatedr 	= 1;
					$registerdr = 1;
					$expiredr 	= 1;
					$statusdr 	= 1;
				}
				$strQuery .= " B.owner_id ".$dr;
			break;
			case 'ownrname':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$propiddr 	= 1;
					$ownriddr 	= 1;
					$ownrnamedr = 0;
					$propnamedr = 1;
					$updatedr 	= 1;
					$registerdr = 1;
					$expiredr 	= 1;
					$statusdr 	= 1;
				} else {
					$dr = "DESC";
					$propiddr 	= 1;
					$ownriddr 	= 1;
					$ownrnamedr = 1;
					$propnamedr = 1;
					$updatedr 	= 1;
					$registerdr = 1;
					$expiredr 	= 1;
					$statusdr 	= 1;
				}
				$strQuery .= " D.user_fname ".$dr;
			break;
			case 'propname':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$propiddr 	= 1;
					$ownriddr 	= 1;
					$ownrnamedr = 1;
					$propnamedr = 0;
					$updatedr 	= 1;
					$registerdr = 1;
					$expiredr 	= 1;
					$statusdr 	= 1;
				} else {
					$dr = "DESC";
					$propiddr 	= 1;
					$ownriddr 	= 1;
					$ownrnamedr = 1;
					$propnamedr = 1;
					$updatedr 	= 1;
					$registerdr = 1;
					$expiredr 	= 1;
					$statusdr 	= 1;
				}
				$strQuery .= " A.property_name ".$dr;
			break;
			case 'register':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$propiddr 	= 1;
					$ownriddr 	= 1;
					$ownrnamedr = 1;
					$propnamedr = 1;
					$updatedr 	= 1;
					$registerdr = 0;
					$expiredr 	= 1;
					$statusdr 	= 1;
				} else {
					$dr = "DESC";
					$propiddr 	= 1;
					$ownriddr 	= 1;
					$ownrnamedr = 1;
					$propnamedr = 1;
					$updatedr 	= 1;
					$registerdr = 1;
					$expiredr 	= 1;
					$statusdr 	= 1;
				}
				$strQuery .= " A.created_on ".$dr;
			break;
			case 'expire':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$propiddr 	= 1;
					$ownriddr 	= 1;
					$ownrnamedr = 1;
					$propnamedr = 1;
					$updatedr 	= 1;
					$registerdr = 1;
					$expiredr 	= 0;
					$statusdr 	= 1;
				} else {
					$dr = "DESC";
					$propiddr 	= 1;
					$ownriddr 	= 1;
					$ownrnamedr = 1;
					$propnamedr = 1;
					$updatedr 	= 1;
					$registerdr = 1;
					$expiredr 	= 1;
					$statusdr 	= 1;
				}
				$strQuery .= " A.created_on ".$dr;
			break;
			case 'update':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$propiddr 	= 1;
					$ownriddr 	= 1;
					$ownrnamedr = 1;
					$propnamedr = 1;
					$updatedr 	= 0;
					$registerdr = 1;
					$expiredr 	= 1;
					$statusdr 	= 1;
				} else {
					$dr = "DESC";
					$propiddr 	= 1;
					$ownriddr 	= 1;
					$ownrnamedr = 1;
					$propnamedr = 1;
					$updatedr 	= 1;
					$registerdr = 1;
					$expiredr 	= 1;
					$statusdr 	= 1;
				}
				$strQuery .= " A.updated_on ".$dr;
			break;
			case 'status':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$propiddr 	= 1;
					$ownriddr 	= 1;
					$ownrnamedr = 1;
					$propnamedr = 1;
					$updatedr 	= 1;
					$registerdr = 1;
					$expiredr 	= 1;
					$statusdr 	= 0;
				} else {
					$dr = "DESC";
					$propiddr 	= 1;
					$ownriddr 	= 1;
					$ownrnamedr = 1;
					$propnamedr = 1;
					$updatedr 	= 1;
					$registerdr = 1;
					$expiredr 	= 1;
					$statusdr 	= 1;
				}
				$strQuery .= " C.status_name ".$dr;
			break;
		}
	} else {
		$strQuery 	= "";
		$propiddr 	= 1;
		$ownriddr 	= 1;
		$ownrnamedr = 1;
		$propnamedr = 1;
		$updatedr 	= 1;
		$registerdr = 1;
		$expiredr 	= 1;
		$statusdr 	= 1;
	
	}
	$propListArr = $propertyObj->fun_getPendingApprovalNewPropertyArr($strQuery);
	if(is_array($propListArr) && count($propListArr) > 0){
	?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td valign="top">Display <?php echo count($propListArr); ?>-<?php echo count($propListArr); ?> of <?php echo count($propListArr); ?></td>
				<td align="right" valign="top" class="Paging">
                <!--
                <a href="#">First</a> <a href="#">&lt;</a> <a href="#">1</a> | 2 | <a href="#">3</a> | <a href="#">4</a> | <a href="#">5</a> | <a href="#">6</a> | <a href="#">7</a> | <a href="#">8</a> | <a href="#">9</a> | <a href="#">10</a>...<a href="#">23</a> <a href="#">&gt;</a> <a href="#">Last</a>
                -->
                </td>
			</tr>
			<tr><td colspan="2" valign="top">&nbsp;</td></tr>
			<tr>
				<td colspan="2" valign="top">
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EventListing">
						<thead>
							<tr>
								<th width="2%" class="left" scope="col">&nbsp;</th>
								<th width="2%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=".$sec."&sortby=propid&dr=".$propiddr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "propid")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?> ><div>Prop ID</div></th>
								<th width="2%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=".$sec."&sortby=ownrid&dr=".$ownriddr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "ownrid")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?> ><div>Owner ID</div></th>
								<th width="10%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=".$sec."&sortby=ownrname&dr=".$ownrnamedr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "ownrname")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Owner name</div></th>
								<th width="22%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=".$sec."&sortby=propname&dr=".$propnamedr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "propname")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Property name</div></th>
                                <th width="19%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=".$sec."&sortby=update&dr=".$updatedr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "update")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Registration date</div></th>
                                <th width="19%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=".$sec."&sortby=update&dr=".$updatedr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "update")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Expired date </div></th>
								<th width="19%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=".$sec."&sortby=update&dr=".$updatedr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "update")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Date updated</div></th>
								<th width="5%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=".$sec."&sortby=update&dr=".$updatedr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "update")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Paid</div></th>
								<th width="5%" scope="col" class="right" onmouseover="this.className = 'rightOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=".$sec."&sortby=status&dr=".$statusdr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "status")){echo "class=\"rightOver\" onmouseout=\"this.className = 'rightOver';\" ";}else{echo "onmouseout=\"this.className = 'right';\"";}?>><div>Status</div></th>
							</tr>
						</thead>
						<tbody>
							<?php
                            for($i=0; $i < count($propListArr); $i++){
                            $prop_id 			= $propListArr[$i]['property_id'];
                            $prop_name 			= $propListArr[$i]['property_name'];
                            $prop_updated_on 	= date('M d, Y', strtotime($propListArr[$i]['updated_on']));
							                            $prop_created_on 	= date('M d, Y', strtotime($propListArr[$i]['created_on']));
                            $prop_active_on 	= date('M d, Y', strtotime($propListArr[$i]['active_on']));
							$prop_expire_on 	= date("M d, Y", mktime(0,0,0, date("m", strtotime($propListArr[$i]['active_on'])), date("d", strtotime($propListArr[$i]['active_on'])),date("Y", strtotime($propListArr[$i]['active_on']))+1));

                            $prop_ownr_id 		= $propListArr[$i]['owner_id'];
                            $prop_status 		= ucwords($propListArr[$i]['status_name']);
                            $prop_ownr_name 	= ucwords($propListArr[$i]['user_fname']." ".$propListArr[$i]['user_lname']);
                            ?>
                                <tr>
                                    <td class="left"><a href="admin-pending-approval.php?sec=<?php echo $sec;?>&pid=<?php echo $prop_id;?>">View</a></td>
                                    <td><?php echo fill_zero_left($prop_id, "0", (6-strlen($prop_id)));?></td>
                                    <td><a href="#"><?php echo fill_zero_left($prop_ownr_id, "0", (6-strlen($prop_ownr_id)));?></a></td>
                                    <td><?php echo $prop_ownr_name;?></td>
                                    <td><?php echo $prop_name;?></td>
                                    <td align="center"><?php echo $prop_created_on;?></td>
                                    <td align="center"><?php if($prop_expire_on != 'Jan 01, 1971') {echo $prop_expire_on;} else { echo " -- ";}?></td>
                                    <td align="center"><?php echo $prop_updated_on;?></td>
                                    <td>
										<?php
										if(($propertyObj->fun_checkPropertyProductPayments("6", $prop_id) == true)) {
											echo "Yes";
										} else {
											echo "<span style=\"color:#FF0000;\">No</span>";
										}
										?>
									</td>
                                    <td class="right"><?php echo $prop_status;?></td>
                                </tr>
                            <?php
                            }
                            ?>

						</tbody>
					</table>
				</td>
			</tr>
			<tr><td colspan="2" valign="top">&nbsp;</td></tr>
			<tr>
				<td valign="top">&nbsp;</td>
				<td align="right" valign="top" class="Paging">
                <!--
                <a href="#">First</a> <a href="#">&lt;</a> <a href="#">1</a> | 2 | <a href="#">3</a> | <a href="#">4</a> | <a href="#">5</a> | <a href="#">6</a> | <a href="#">7</a> | <a href="#">8</a> | <a href="#">9</a> | <a href="#">10</a>...<a href="#">23</a> <a href="#">&gt;</a> <a href="#">Last</a>
                -->
                </td>
			</tr>
		</table>
	<?php
	} else {
	?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td valign="top">No new property added!</td>
			</tr>
		</table>
	<?php
	}
}
?>
<div id="delete-unit-names-pop" class="box cursor1" style="display:none; width:422px; left:480px;top:280px;">
<!--[if IE]><iframe frameborder="0" onload="javascript:fheight()" id="iframe" style="position:absolute;top:4px;left:6px;width:402px;height:200px;"></iframe><![endif]--> 
<div class="content">
<div onMouseDown="dragStart(event, 'delete-unit-names-pop');" style="position:relative; z-index:999;left:0px;width:420px;">

<table id="delete" width="420" border="0" cellspacing="0" cellpadding="0">
     <tr>
            <td align="right"><img src="<?php echo SITE_IMAGES;?>poplefttop.png" alt="ANP" height="10" width="10" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo SITE_IMAGES;?>poplefttop.png', sizingMethod='scale');" /></td>
            <td class="topp"></td>
            <td><img src="<?php echo SITE_IMAGES;?>poprighttop1.png" alt="ANP"  height="10" width="15" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo SITE_IMAGES;?>poprighttop1.png', sizingMethod='scale');"/></td>
        </tr>
    <tr>
        <td class="leftp"></td>
        <td width="420" align="left" valign="top" bgcolor="#FFFFFF" style="padding:6px;"> 
            <form name="frmDelUnit" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
            <input type="hidden" name="securityKey" value="<?php echo md5(OWNERPROPERTYDELUNIT);?>" />
            <input type="hidden" name="txtPropertyPId" value="<?php if(isset($property_pid) && $property_pid > 0) { echo $property_pid; } else { echo $property_id; }?>" />
            <table border="0" cellspacing="0" cellpadding="0" style="background-color:#FFFFFF;">
                <tr>
                    <td  colspan="3" class="font16-black pad-rgt4">
                        <p class="FloatLft black">Delete units/rooms</p>
                        <p class="FloatRgt cursor"><a  href="javascript:toggleLayer1('delete-unit-names-pop');"><img src="<?php echo SITE_IMAGES;?>pop-up-cross.gif" class="cursor" alt="Close" title="Close" border="0" /></a></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="pad-btm15 pad-rgt25 lineHight18">
                        Check the tickboxes of the units / rooms you wish to remove. 
                        <br />
                        <strong>PLEASE NOTE:</strong> If you delete a unit you will not be entitled to a
                        refund but you will be able to re-instate a unit / room during the
                        period which you purchased it for. 
                    </td>
                </tr>
                <?php
                for($i = 0; $i < count($propertyUnitTab); $i++){
                    $unit_id 	= $propertyUnitTab[$i]['unit'];
                    $unit_name 	= $propertyUnitTab[$i]['unit_name'];
                ?>
                <tr>
                    <td colspan="3" valign="middle" class="width45">
                        <table border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="40">Unit <?php echo (int)($i+1); ?></td>
                                <td width="210"><strong><?php echo $unit_name; ?></strong></td>
                                <td class="pad-lft20"><input type="checkbox" style="cursor:auto;" name="txtUnitId[]" id="checkbox2" class="checkbox" value="<?php echo $unit_id;?>" /></td>
                                <td class="pad-lft10 black">Delete</td>
                            </tr>
                            <tr><td colspan="4" height="10"></td></tr>
                        </table>
                    </td>
                </tr>
                <?php
                }
                ?>
                <tr>
                    <td colspan="3" valign="middle" class="width45">
                        <table border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td height="10"></td>
                                <td height="10" colspan="3">
                                    <p class="FloatLft"><a href="javascript:toggleLayer1('delete-unit-names-pop');"><img src="<?php echo SITE_IMAGES;?>Cancel-48x21-normal.gif" alt="cancel" name="Image4" id="Image4" onMouseOver="this.src='<?php echo SITE_IMAGES;?>Cancel-48x21-over.gif'" onMouseOut="this.src='<?php echo SITE_IMAGES;?>Cancel-48x21-normal.gif'" /></a></p>
                                    <p class="FloatLft pad-lft5">
                                        <input type="image" src="<?php echo SITE_IMAGES;?>delete-out.gif" class="cursor" alt="Add units" name="Image5" id="Image5" onMouseOver="this.src='<?php echo SITE_IMAGES;?>delete-over.gif'" onMouseOut="this.src='<?php echo SITE_IMAGES;?>delete-out.gif'" >
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>						 
            </table>
            </form>
        </td>
         <td class="rightp" width="15"></td>

    </tr>
    <tr>
            <td align="right"><img src="<?php echo SITE_IMAGES;?>popleftbtm.png" alt="ANP" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo SITE_IMAGES;?>popleftbtm.png', sizingMethod='crop');" width="10" height="10"/></td>

            <td width="270" class="bottomp"></td>
            <td align="left"><img src="<?php echo SITE_IMAGES;?>poprightbtm1.png" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo SITE_IMAGES;?>poprightbtm1.png', sizingMethod='crop');" width="15" height="10" alt="ANP"/></td>
        </tr>
</table>
</div>
</div>
</div> 
<div id="edit-unit-names-pop" class="box cursor1" style="display:none; width:312px; left:400px;top:350px;">
    <!--[if IE]><iframe frameborder="0" onload="javascript:fheight()" id="iframe" style="position:absolute;top:4px;left:6px;width:290px;height:160px;"></iframe><![endif]--> 
    <div class="content">
    <div onMouseDown="dragStart(event, 'edit-unit-names-pop');" style="position:relative; z-index:999;left:0px;width:310px;">
        <table id="edit-unit" width="310" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="right"><img src="<?php echo SITE_IMAGES;?>poplefttop.png" alt="ANP" height="10" width="10" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo SITE_IMAGES;?>poplefttop.png', sizingMethod='scale');" /></td>
                <td class="topp"></td>
                <td><img src="<?php echo SITE_IMAGES;?>poprighttop1.png" alt="ANP"  height="10" width="15" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo SITE_IMAGES;?>poprighttop1.png', sizingMethod='scale');"/></td>
            </tr>
            <tr>
                <td class="leftp"></td>
                <td align="left" valign="top" bgcolor="#FFFFFF" style="padding:6px;"> 
                    <form name="frmEditUnitName" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
                    <input type="hidden" name="securityKey" value="<?php echo md5(OWNERPROPERTYEDITUNITNAME);?>" />
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#FFFFFF;">
                        <tr>
                            <td  colspan="3" class="font16-black pad-rgt4">
                                <p class="FloatLft black">
                                Edit unit / room names
                                </p>
                                <p class="FloatRgt cursor"><a class="cursor" href="javascript:toggleLayer1('edit-unit-names-pop');">
                                <img src="<?php echo SITE_IMAGES;?>pop-up-cross.gif" alt="Close" title="Close" border="0" /></a></p>
                            </td>
                        </tr>
    
                        <?php
                        for($i = 0; $i < count($propertyUnitTab); $i++){
                            $unit_id 	= $propertyUnitTab[$i]['unit'];
                            $unit_name 	= $propertyUnitTab[$i]['unit_name'];
                        ?>
                        <tr>
                            <td colspan="3" valign="middle" class="width45">
                                <table border="0" cellspacing="0" cellpadding="0" class="pad-top10">
                                    <tr>
                                        <td width="40">Unit <?php echo (int)($i+1); ?></td>
                                        <td>
                                            <input type="hidden" name="<?php echo "txtUnitId".(int)($i+1); ?>" value="<?php echo $unit_id;?>" class="Textfield205" />
                                            <input type="text" onMouseDown="this.onkeypress=focus()" name="<?php echo "txtUnit".(int)($i+1); ?>" value="<?php echo $unit_name;?>" class="Textfield205" maxlength="20" />
                                        </td>
                                    </tr>
                                    <tr><td colspan="2" height="10"></td></tr>
                                </table>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                        <tr>
                            <td colspan="3" valign="middle" class="width45">
                                <table border="0" cellspacing="0" cellpadding="0">
                                    <tr><td colspan="2" height="15"></td></tr>
                                    <tr>
                                        <td height="10"></td>
                                        <td height="10">
                                            <p class="FloatLft">
                                            <a class="cursor" href="javascript:toggleLayer1('edit-unit-names-pop');"><img src="<?php echo SITE_IMAGES;?>Cancel-48x21-normal.gif" alt="cancel" name="Image2" id="Image2" onMouseOver="this.src='<?php echo SITE_IMAGES;?>Cancel-48x21-over.gif'" onMouseOut="this.src='<?php echo SITE_IMAGES;?>Cancel-48x21-normal.gif'" /></a></p>
                                            <p class="FloatLft pad-lft5"><input type="image" src="<?php echo SITE_IMAGES;?>update-unit-name.gif" alt="update unit name" name="Image3" id="Image3"  onMouseOver="MM_swapImage('Image3','','<?php echo SITE_IMAGES;?>update-unit-name-over.gif',1)" onMouseOut="MM_swapImgRestore()" ></p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>						 
                    </table>
                    </form>
                </td>
                <td class="rightp" width="10"></td>
            </tr>
            <tr>
                <td align="right"><img src="<?php echo SITE_IMAGES;?>popleftbtm.png" alt="ANP" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo SITE_IMAGES;?>popleftbtm.png', sizingMethod='crop');" width="10" height="10"/></td>

                <td width="270" class="bottomp"></td>
                <td align="left"><img src="<?php echo SITE_IMAGES;?>poprightbtm1.png" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo SITE_IMAGES;?>poprightbtm1.png', sizingMethod='crop');" width="15" height="10" alt="ANP"/></td>
            </tr>
        </table>
        </div>
    </div>
    </div>    
<div id="add-unit-names-pop" class="box cursor1" style="display:none; left:580px;top:680px;">
<!--[if IE]><iframe frameborder="0" onload="javascript:fheight()" id="iframe" style="position:absolute;top:4px;left:6px;width:290px;height:200px;"></iframe><![endif]--> 
<div class="content">
<div onMouseDown="dragStart(event, 'add-unit-names-pop');" style="position:relative; z-index:999;left:0px;width:310px;">
    <table width="310" id="add-unit" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="right"><img src="<?php echo SITE_IMAGES;?>poplefttop.png" alt="ANP" height="10" width="10" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo SITE_IMAGES;?>poplefttop.png', sizingMethod='scale');" /></td>
            <td class="topp"></td>
            <td><img src="<?php echo SITE_IMAGES;?>poprighttop1.png" alt="ANP"  height="10" width="15" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo SITE_IMAGES;?>poprighttop1.png', sizingMethod='scale');"/></td>
        </tr>
        <tr>
            <td class="leftp"></td>
            <td  align="left" valign="top" bgcolor="#FFFFFF" style="padding:6px;"> 
                 <form name="frmAddUnitName" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
                <input type="hidden" name="securityKey" value="<?php echo md5(OWNERPROPERTYADDUNITNAME);?>" />
                <input type="hidden" name="txtPropertyPId" value="<?php if(isset($property_pid) && $property_pid > 0) { echo $property_pid; } else { echo $property_id; }?>" />
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color:#FFFFFF;">
                    <tr>
                        <td  colspan="3" class="font16-black pad-btm20 pad-rgt4">
                            <p class="FloatLft black">
                                Add another<br />unit to this property
                            </p>
                            <p class="FloatRgt cursor"><a class="cursor" href="javascript:toggleLayer1('add-unit-names-pop');">
                            <img src="<?php echo SITE_IMAGES;?>pop-up-cross.gif" alt="Close" title="Close" border="0" /></a></p>
                        </td>
                    </tr>

                   <?php
                    for($i = 0; $i < count($propertyUnitTab); $i++){
                        $unit_id 	= $propertyUnitTab[$i]['unit'];
                        $unit_name 	= $propertyUnitTab[$i]['unit_name'];
                    ?>
                    <tr>
                        <td colspan="3" valign="middle" class="width45">
                            <table border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="40">Unit <?php echo (int)($i+1); ?></td>
                                    <td>
                                        <input type="hidden" name="<?php echo "txtUnitId".(int)($i+1); ?>" value="<?php echo $unit_id;?>" class="Textfield205" />
                                        <strong><?php echo $unit_name;?></strong>
                                    </td>
                                </tr>
                                <tr><td colspan="2" height="10"></td></tr>
                            </table>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                    <?php
                    for($j = (count($propertyUnitTab)+1); $j < 5; $j++){
                    ?>
                    <tr>
                        <td colspan="3" valign="middle" class="width45">
                            <table border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="40">Unit <?php echo (int)($j); ?></td>
                                    <td>
                                        <input type="text" onMouseDown="this.onkeypress=focus()" name="<?php echo "txtUnit".(int)($j); ?>" value="" class="Textfield205" maxlength="20" />
                                    </td>
                                </tr>
                                <tr><td colspan="2" height="10"></td></tr>
                            </table>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                    <tr>
                        <td colspan="3" valign="middle" class="width45">
                            <table border="0" cellspacing="0" cellpadding="0">
                                <tr><td colspan="2" height="15"></td></tr>
                                <tr>
                                    <td height="10"></td>
                                    <td height="10">
                                        <p class="FloatLft"><a href="javascript:toggleLayer1('add-unit-names-pop');"><img src="<?php echo SITE_IMAGES;?>Cancel-48x21-normal.gif" class="cursor" alt="cancel" name="Image2" id="Image2" onMouseOver="this.src='<?php echo SITE_IMAGES;?>Cancel-48x21-over.gif'" onMouseOut="this.src='<?php echo SITE_IMAGES;?>Cancel-48x21-normal.gif'" /></a></p>
                                        <p class="FloatLft pad-lft5"><input type="image" src="<?php echo SITE_IMAGES;?>add-units-out.gif" alt="Add units" name="Image3" id="Image3" onMouseOver="this.src='<?php echo SITE_IMAGES;?>add-units-over.gif'" onMouseOut="this.src='<?php echo SITE_IMAGES;?>add-units-out.gif'" class="cursor" ></p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>						 
                </table>
                </form>
            </td>
            <td class="rightp" width="15"></td>
        </tr>
        <tr>
            <td align="right"><img src="<?php echo SITE_IMAGES;?>popleftbtm.png" alt="ANP" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo SITE_IMAGES;?>popleftbtm.png', sizingMethod='crop');" width="10" height="10"/></td>

            <td width="270" class="bottomp"></td>
            <td align="left"><img src="<?php echo SITE_IMAGES;?>poprightbtm1.png" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo SITE_IMAGES;?>poprightbtm1.png', sizingMethod='crop');" width="15" height="10" alt="ANP"/></td>
        </tr>
    </table>
    </div>
</div>
</div> 