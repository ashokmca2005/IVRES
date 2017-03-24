<?php	
	require_once("includes/owner-top.php");
?>
<?php	
	if(isset($_GET['pid']) && $_GET['pid'] !=""){
		$property_id 		= $_GET['pid'];
		$sec 				= $_GET['sec'];
		$strUrlAdd 			= "&pid=".$property_id;

		if($propertyObj->fun_checkPropertyOwner($property_id, $user_id) == false) {
			redirectURL(SITE_URL."owner-my-properties");
		}

		//tab machanism
		$linkdet = "owner-property.php?sec=det".$strUrlAdd;
		$linkpho = "owner-property.php?sec=pho".$strUrlAdd;
		$linkloc = "owner-property.php?sec=loc".$strUrlAdd;
		$linkpri = "owner-property.php?sec=pri".$strUrlAdd;
		$linkava = "owner-property.php?sec=ava".$strUrlAdd;
		$linkcon = "owner-property.php?sec=con".$strUrlAdd;

		if($sec == "det" || $sec == "") {
			$imgdet = "images/property-tab/property-detail-tab-cs.gif";
		} else {
			$imgdet = "images/property-tab/property-detail-tab-ch.gif";
		}
	
		if($sec == "pho"){
			$imgpho = "images/property-tab/property-photo-tab-cs.gif";
		} else {
			$imgpho = "images/property-tab/property-photo-tab-ch.gif";
		}
	
		if($sec == "loc"){
			$imgloc = "images/property-tab/property-location-tab-cs.gif";
		} else {
			$imgloc = "images/property-tab/property-location-tab-ch.gif";
		}
	
		if($sec == "pri") {
			$imgpri = "images/property-tab/property-price-tab-cs1.gif";
		} else {
			$imgpri = "images/property-tab/property-price-tab-ch1.gif";
		}
	
		if($sec == "ava") {
			$imgava = "images/property-tab/property-availibility-tab-cs.gif";
		} else {
			$imgava = "images/property-tab/property-availibility-tab-ch.gif";
		}
	
		if($sec == "con") {
			$imgcon = "images/property-tab/property-contact-tab-cs.gif";
		} else {
			$imgcon = "images/property-tab/property-contact-tab-ch.gif";
		}
	
		$arrPropertyTab = array(
		array('link'=>$linkdet, 'linktitle'=>'Details', 'imgsrc'=>$imgdet, 'imgwidth'=>'79px', 'imgheight'=>'35px', 'imgalt'=>'Details'),
		array('link'=>$linkpho, 'linktitle'=>'Photos', 'imgsrc'=>$imgpho, 'imgwidth'=>'85px', 'imgheight'=>'35px', 'imgalt'=>'Photos'),
		array('link'=>$linkloc, 'linktitle'=>'Location', 'imgsrc'=>$imgloc, 'imgwidth'=>'95px', 'imgheight'=>'35px', 'imgalt'=>'Location'),
		array('link'=>$linkpri, 'linktitle'=>'Prices', 'imgsrc'=>$imgpri, 'imgwidth'=>'77px', 'imgheight'=>'35px', 'imgalt'=>'Prices'),
		array('link'=>$linkava, 'linktitle'=>'Availability', 'imgsrc'=>$imgava, 'imgwidth'=>'107px', 'imgheight'=>'35px', 'imgalt'=>'Availability'),
		array('link'=>$linkcon, 'linktitle'=>'Contact', 'imgsrc'=>$imgcon, 'imgwidth'=>'89px', 'imgheight'=>'35px', 'imgalt'=>'Contact')
		);

		$pre = '';
		$next= '';
		if(isset($sec) && $sec !=""){
			switch($sec) {
				case 'det':
					$mainPage = "owner-property-details.php";
					$helpPage = "property-add-details-help-pop-up.php";
					$pre = 'det';
					$next= 'pho';
				break;
				case 'pho':
					$mainPage = "owner-property-photos.php";
					$helpPage = "property-add-photo-help-pop-up.php";
					$pre = 'det';
					$next= 'vid';
				break;
				case 'loc':
					$mainPage = "owner-property-location.php";
					$helpPage = "property-add-location-help-pop-up.php";
					$pre = 'vid';
					$next= 'pri';
				break;
				case 'pri':
					$mainPage = "owner-property-prices.php";
					$helpPage = "property-add-price-help-pop-up.php";
					$pre = 'loc';
					$next= 'ava';
				break;
				case 'ava':
					$mainPage = "owner-property-availability.php";
					$helpPage = "property-add-availability-help-pop-up.php";
					$pre = 'pri';
					$next= 'con';
				break;
				case 'con':
					$mainPage = "owner-property-contact.php";
					$helpPage = "property-add-contact-help-pop-up.php";
					$pre = 'ava';
					$next= 'che';
				break;
			}
		} else {
			$sec = 'det';
			$mainPage = "owner-property-details.php";
			$helpPage = "property-add-details-help-pop-up.php";
			$pre = 'det';
			$next= 'pho';
		}
	} else {
		//redirect to add property page
		redirectURL(SITE_URL."owner-home");
	}

	//form submission
	$form_array = array();
	$errorMsg 	= "no";

	// Owner property details submit : start here 
	if($_POST['securityKey']==md5(OWNERPROPERTYDETAILS)){		
		if(trim($_POST['txtPropertyName']) == ''){
			$form_array['txtPropertyName'] = 'Please enter a name for your property';
			$errorMsg	= 'yes';
		}else{
			$p_name = trim($_POST['txtPropertyName']);
		}
		if(trim($_POST['txtPropertyTitle']) == ''){
			$form_array['txtPropertyTitle'] = 'Please enter a title for your advert';
			$errorMsg	= 'yes';
		}else{
			$p_title = trim($_POST['txtPropertyTitle']);
		}
		if($_POST['txtPropertyType'] == ''){
			$form_array['txtPropertyType'] = 'Please select a property type';
			$errorMsg	= 'yes';
		}else{
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
				$form_array['error_msg'] = "Error: We are unable to update your property photos detail!";
			}
		} else {
			$form_array['error_msg'] = "Please submit your form again!";
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

	// Owner property photos submit : start here 
	if($_POST['securityKey']==md5(OWNERPROPERTYPHOTOSUPLOAD)){		
		if(isset($_POST['txtPhotoId']) && ($_POST['txtPhotoId'] != '') && isset($_FILES['txtFile']) && ($_FILES['txtFile'] !="")){ // edit

			$photo_id 		= $_POST['txtPhotoId'];
			$photo_caption 	= $_POST['txtPhotoCaption'];

			$property_img = basename($_FILES['txtFile']['name']);
			$extn=split("\.",$property_img);
			
			
			$photo_main 	= $property_id."_".$photo_id."_photo.".$extn[1];
			$photo_thumb 	= $property_id."_".$photo_id."_photo_thumb.".$extn[1];
			
			$uploadphotodir = 'upload/property_images/large';
			$uploadthumbdir = 'upload/property_images/thumbnail';
			$uploadphotofile = $uploadphotodir ."/". $photo_main;
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

//				@copy($uploadphotofile, $uploadthumbfile);

				if($propertyObj->fun_updatePropertyPhotos($property_id, $photo_id, $photo_caption, $photo_main, $photo_thumb) === true){
	//				$propertyObj->fun_updatePropertyStatus($property_id, '1', '0');
					$propertyObj->fun_updatePropertyLastUpdate($property_id);

					echo "<script> location.href = window.location; </script>";
//					redirectURL($linkpho);
//					$form_array['error_msg'] = "Property photos details successfully updated!";
				} else {
					$form_array['error_msg'] = "Error: We are unable to update your property photos detail!";
				}
			} 
			else{
				$form_array['error_msg'] = "Error: We are unable to update your property photos detail!";
			}
		} else if(isset($_FILES['txtFile']) && ($_FILES['txtFile'] !="")) {
			$photo_caption 	= $_POST['txtPhotoCaption'];
			if(($photo_id = $propertyObj->fun_addPropertyPhotos($property_id)) && $photo_id !="") {
				$property_img = basename($_FILES['txtFile']['name']);
				$extn=split("\.",$property_img);
	
				$photo_main 	= $property_id."_".$photo_id."_photo.".$extn[1];
				$photo_thumb 	= $property_id."_".$photo_id."_photo_thumb.".$extn[1];
				
				$uploadphotodir = 'upload/property_images/large';
				$uploadthumbdir = 'upload/property_images/thumbnail';
				$uploadphotofile = $uploadphotodir ."/". $photo_main;
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
		//				$propertyObj->fun_updatePropertyStatus($property_id, '1', '0');
					$propertyObj->fun_updatePropertyLastUpdate($property_id);

						echo "<script> location.href = window.location; </script>";
//						redirectURL($linkpho);
//						$form_array['error_msg'] = "Property photos details successfully updated!";
					} else {
						$form_array['error_msg'] = "Error: We are unable to update your property photos detail!";
					}
				} 
				else{
					$propertyObj->fun_delPropertyPhoto($photo_id);
					$form_array['error_msg'] = "Error: We are unable to update your property photos detail!";
				}
			}
		} else {
			$form_array['error_msg'] = "Please submit your form again!";
		}
	}
	// Owner property photos submit : end here 
	// Owner property location submit : start here 
	if($_POST['securityKey']==md5(LOCATIONFORM)){		
		if($errorMsg == 'no' && $errorMsg != 'yes'){
			if($propertyObj->fun_editProperty($property_id) === true){
				$propertyObj->fun_updatePropertyLastUpdate($property_id);
				echo "<script> location.href = window.location; </script>";
			} else {
				$form_array['error_msg'] = "Error: We are unable to update your property detail!";
			}
		} else {
			$form_array['error_msg'] = "Please submit your form again!";
		}
	}
	// Owner property location submit : end here 

	// Owner property price submit : start here 
	if($_POST['securityKey'] == md5(OWNERPROPERTYPRICES)){
		if($errorMsg == 'no' && $errorMsg != 'yes'){
			if($propertyObj->fun_editProperty($property_id) === true){
				$propertyObj->fun_updatePropertyLastUpdate($property_id);
				if(isset($_POST['txtPriceId']) && $_POST['txtPriceId'] != "") {
					redirectURL("owner-property.php?sec=pri&pid=".$property_id."&msg=updatesuccess");
				} else {
					redirectURL("owner-property.php?sec=pri&pid=".$property_id."&msg=addsuccess");
				}
			} else {
				echo "<script> location.href = window.location; </script>";
			}
		} else {
			$form_array['error_msg'] = "Please submit your form again!";
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
				$txtStatus 		= $_POST['txtAvailabilityStatus'];
			}

			if($_POST['txtYearTo'] == ''){
				$form_array['availabilityError'] = 'Please select year to';
				$errorMsg	= 'yes';
			} else {
				$txtYearTo 		= $_POST['txtYearTo'];
			}

			if($_POST['txtMonthTo'] == ''){
				$form_array['availabilityError'] = 'Please select month to';
				$errorMsg	= 'yes';
			} else {
				$txtMonthTo 	= $_POST['txtMonthTo'];
			}

			if($_POST['txtDayTo'] == ''){
				$form_array['availabilityError'] = 'Please select date to';
				$errorMsg	= 'yes';
			} else {
				$txtDayTo 		= $_POST['txtDayTo'];
			}

			if($_POST['txtYearFrom'] == ''){
				$form_array['availabilityError'] = 'Please select year from';
				$errorMsg	= 'yes';
			} else {
				$txtYearFrom 	= $_POST['txtYearFrom'];
			}

			if($_POST['txtMonthFrom'] == ''){
				$form_array['availabilityError'] = 'Please select month from';
				$errorMsg	= 'yes';
			} else {
				$txtMonthFrom 	= $_POST['txtMonthFrom'];
			}

			if($_POST['txtDayFrom'] == ''){
				$form_array['availabilityError'] = 'Please select date from';
				$errorMsg	= 'yes';
			} else {
				$txtDayFrom 	= $_POST['txtDayFrom'];
			}
	
			if($errorMsg == 'no' && $errorMsg != 'yes'){
				$txtStartDate 	= date('Y-m-d', strtotime($txtYearFrom."-".$txtMonthFrom."-".$txtDayFrom));
				$txtEndDate 	= date('Y-m-d', strtotime($txtYearTo."-".$txtMonthTo."-".$txtDayTo));
				if($propertyObj->fun_addPropertyAvailablityDetails($property_id, $txtStartDate, $txtEndDate, $txtStatus) === true){
					$propertyObj->fun_updatePropertyLastUpdate($property_id);
					redirectURL("owner-property.php?sec=ava&pid=".$property_id."&msg=updatesuccess");
				} else {
					echo "<script> location.href = window.location; </script>";
				}
			} else {
				$form_array['error_msg'] = "Please submit your form again!";
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
			$form_array['error_msg'] = "Please submit your form again!";
		}
	}
	// Owner property contact submit : end here 

	// for unset (null) of property page
	if((strpos($_SERVER['HTTP_REFERER'], "holiday-property-preview.php") == true) || (isset($_SESSION['property_preview_close_url']) && $_SESSION['property_preview_close_url'] != "")) {
		$_SESSION['property_preview_close_url'] = "";
	}

	//property details
	$propertyInfo 		= $propertyObj->fun_getPropertyInfo($property_id);

	//property name
	$propertyName	 	= $propertyObj->fun_getPropertyName($property_id);

	//property title
	$propertyTitle 		= $propertyObj->fun_getPropertyTitleName($property_id);

//print_r($propertyInfo);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo $sitetitle;?> :: Owner :: Add / Edit Property</title>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo tranText('charset'); ?>" />
    <META HTTP-EQUIV="Content-language" CONTENT="<?php echo tranText('lang_iso'); ?>">
    <link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo SITE_URL; ?>favicon.ico" />
    <link rel="SHORTCUT ICON" href="<?php echo SITE_URL; ?>favicon.ico"/>
    <link href="<?php echo SITE_CSS_INCLUDES_PATH;?>owner.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo SITE_CSS_INCLUDES_PATH;?>pop-up-cal.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>common.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>owner.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>dhtmlwindow.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>dargPop.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>pop-up.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>equal_height.js"></script>
	<script language="javascript" type="text/javascript">
		var req = ajaxFunction();
		/*
		* For location : Start here
		*/
		function chkSelectArea() {
			var getID=document.getElementById("txtPropertyAreaId").value;
			if(getID !="" && getID != "0"){
				sendRegionRequest(getID);
				document.getElementById("txtPropertyRegionId").value = "0";
				document.getElementById("txtPropertySubRegionId").value = "0";
				document.getElementById("txtPropertyLocationId").value = "0";
			}
			if(getID == "0" || getID =="") {
				document.getElementById("txtPropertyAreaId").value = "0";
				document.getElementById("txtPropertyRegionId").value = "0";
				document.getElementById("txtPropertySubRegionId").value = "0";
				document.getElementById("txtPropertyLocationId").value = "0";
				document.getElementById("txtPropertySubRegionId").style.display = "none";
				document.getElementById("txtPropertyLocationId").style.display = "none";
			}
		}
		
		function chkSelectRegion() {
			var getID=document.getElementById("txtPropertyRegionId").value;
			if(getID !="" && getID != "0"){
				sendSubRegionRequest(getID);
				document.getElementById("txtPropertySubRegionId").value = "0";
				document.getElementById("txtPropertyLocationId").value = "0";
			}
			if(getID == "0" || getID =="") {
				document.getElementById("txtPropertyRegionId").value = "0";
				document.getElementById("txtPropertySubRegionId").value = "0";
				document.getElementById("txtPropertyLocationId").value = "0";
				document.getElementById("txtPropertySubRegionId").style.display = "none";
				document.getElementById("txtPropertyLocationId").style.display = "none";
			}
		}
		
		function chkSelectSubRegion() {
			var getID=document.getElementById("txtPropertySubRegionId").value;
			if(getID !="" && getID != "0"){
				sendLocationRequest(getID);
				document.getElementById("txtPropertyLocationId").value = "0";
			}
			if(getID == "0" || getID =="") {
				document.getElementById("txtPropertySubRegionId").value = "0";
				document.getElementById("txtPropertyLocationId").value = "0";
				document.getElementById("txtPropertyLocationId").style.display = "none";
			}
		}
	
		function chkSelectLocation() {
			var getID=document.getElementById("txtPropertyLocationId").value;
			if(getID !="" && getID != "0"){
			}
			if(getID == "0" || getID =="") {
				document.getElementById("txtPropertyLocationId").value = "0";
			}
		}	
	
		function sendAreaRequest(id) { 
			req.open('get', '<?php echo SITE_URL;?>selectAreaXml.php?id=' + id); 
			req.onreadystatechange = handleAreaResponse; 
			req.send(null); 
		} 
		
		function sendRegionRequest(id) { 
			req.open('get', '<?php echo SITE_URL;?>selectRegionXml.php?id=' + id); 
			req.onreadystatechange = handleRegionResponse; 
			req.send(null); 
		} 
		
		function sendSubRegionRequest(id) { 
			req.open('get', '<?php echo SITE_URL;?>selectSubRegionXml.php?id=' + id); 
			req.onreadystatechange = handleSubRegionResponse; 
			req.send(null); 
		} 
		
		function sendLocationRequest(id) { 
			req.open('get', '<?php echo SITE_URL;?>selectLocationXml.php?id=' + id); 
			req.onreadystatechange = handleLocationResponse; 
			req.send(null); 
		} 
		
		function handleAreaResponse() { 
			var arrayOfId = new Array();
			var arrayOfNames = new Array();
			if(req.readyState == 4) { 
				var response = req.responseText; 
				xmlDoc=req.responseXML;
				var root = xmlDoc.getElementsByTagName('ntowns')[0];
				if(root != null) {
					document.getElementById("txtPropertyAreaId").style.display = "block";
					document.getElementById("txtPropertyRegionId").style.display = "none";
					document.getElementById("txtPropertySubRegionId").style.display = "none";
					document.getElementById("txtPropertyLocationId").style.display = "none";
					var items = root.getElementsByTagName("ntown");
					for (var i = 0 ; i < items.length ; i++) {
						var item = items[i];
						var id = item.getElementsByTagName("id")[0].firstChild.nodeValue;
						arrayOfId[i] = id;
						var name = item.getElementsByTagName("name")[0].firstChild.nodeValue;

						arrayOfNames[i] = name;
						//alert("item #" + i + ": ID=" + id + " Name=" + name);
					}
					if( arrayOfId.length > 0) {
						var p_city=document.getElementById("txtPropertyAreaId");
						p_city.length=0;
						p_city.options[0]=new Option("Please Select...","");
						for(var j=0; j<arrayOfId.length; j++) {
							p_city.options[j+1]=new Option(arrayOfNames[j], arrayOfId[j]);
						}
					} else {
						document.getElementById("txtPropertyAreaId").style.display = "none";
					}
				} else {
					document.getElementById("txtPropertyAreaId").style.display = "none";
					document.getElementById("txtPropertyRegionId").style.display = "none";
					document.getElementById("txtPropertySubRegionId").style.display = "none";
					document.getElementById("txtPropertyLocationId").style.display = "none";
				}
			} 
		} 
		
		function handleRegionResponse() { 
			var arrayOfId = new Array();
			var arrayOfNames = new Array();
			if(req.readyState == 4) { 
				var response = req.responseText; 
				xmlDoc=req.responseXML;
				var root = xmlDoc.getElementsByTagName('ntowns')[0];
				if(root != null) {
					document.getElementById("txtPropertyRegionId").style.display = "block";
					document.getElementById("txtPropertySubRegionId").style.display = "none";
					document.getElementById("txtPropertyLocationId").style.display = "none";
					var items = root.getElementsByTagName("ntown");
					for (var i = 0 ; i < items.length ; i++) {
						var item = items[i];
						var id = item.getElementsByTagName("id")[0].firstChild.nodeValue;
						arrayOfId[i] = id;
						var name = item.getElementsByTagName("name")[0].firstChild.nodeValue;
						arrayOfNames[i] = name;
						//alert("item #" + i + ": ID=" + id + " Name=" + name);
					}
					if( arrayOfId.length > 0) {
	
						var p_city=document.getElementById("txtPropertyRegionId");
	
						p_city.length=0;
						p_city.options[0]=new Option("All Areas ...","0");
						for(var j=0; j<arrayOfId.length; j++) {
							p_city.options[j+1]=new Option(arrayOfNames[j],arrayOfId[j]);
						}
	//					sendSubRegionRequest(1);
					} else {
						document.getElementById("txtPropertyRegionId").style.display = "none";
		//				sendLocationRequest(document.getElementById("txtRegionId").value);
					}
				} else {
					document.getElementById("txtPropertyRegionId").style.display = "none";
					document.getElementById("txtPropertySubRegionId").style.display = "none";
					document.getElementById("txtPropertyLocationId").style.display = "none";
				}
			} 
		} 
		
		function handleSubRegionResponse() { 
			var arrayOfId = new Array();
			var arrayOfNames = new Array();
			if(req.readyState == 4) { 
				var response = req.responseText; 
				xmlDoc=req.responseXML;
				var root = xmlDoc.getElementsByTagName('ntowns')[0];
				if(root != null) {
					document.getElementById("txtPropertySubRegionId").style.display = "block";
					document.getElementById("txtPropertyLocationId").style.display = "none";
					var items = root.getElementsByTagName("ntown");
					for (var i = 0 ; i < items.length ; i++) {
						var item = items[i];
						var id = item.getElementsByTagName("id")[0].firstChild.nodeValue;
						arrayOfId[i] = id;
						var name = item.getElementsByTagName("name")[0].firstChild.nodeValue;
						arrayOfNames[i] = name;
						//alert("item #" + i + ": ID=" + id + " Name=" + name);
					}
					if( arrayOfId.length > 0) {
						var p_city=document.getElementById("txtPropertySubRegionId");
						p_city.length=0;
						p_city.options[0]=new Option("All Areas ...", "0");
						for(var j=0; j<arrayOfId.length; j++) {
							p_city.options[j+1]=new Option(arrayOfNames[j], arrayOfId[j]);
						}
	
	//					sendLocationRequest(9);
					} else {
						document.getElementById("txtPropertySubRegionId").style.display = "none";
						sendLocationRequest(document.getElementById("txtPropertyRegionId").value);
					}
				} else {
					document.getElementById("txtPropertySubRegionId").style.display = "none";
					document.getElementById("txtPropertyLocationId").style.display = "none";
				}
			} 
		} 
		
		function handleLocationResponse(){
			var arrayOfId = new Array();
			var arrayOfNames = new Array();
			if(req.readyState == 4) { 
				var response = req.responseText; 
				xmlDoc=req.responseXML;
				var root = xmlDoc.getElementsByTagName('ntowns')[0];
		//		alert(root);
				if(root != null) {
					document.getElementById("txtPropertyLocationId").style.display = "block";
					var items = root.getElementsByTagName("ntown");
					for (var i = 0 ; i < items.length ; i++) {
						var item = items[i];
						var id = item.getElementsByTagName("id")[0].firstChild.nodeValue;
						arrayOfId[i] = id;
						var name = item.getElementsByTagName("name")[0].firstChild.nodeValue;
						arrayOfNames[i] = name;
						//alert("item #" + i + ": ID=" + id + " Name=" + name);
					}
					if( arrayOfId.length > 0) {
	
						var p_city=document.getElementById("txtPropertyLocationId");
						p_city.length=0;
						p_city.options[0]=new Option("All Areas ...","0");
	
						for(var j=0; j<arrayOfId.length; j++) {
							p_city.options[j+1]=new Option(arrayOfNames[j], arrayOfId[j]);
						}
	
					} else {
						document.getElementById("txtPropertyLocationId").style.display = "none";
					}
				} else {
					document.getElementById("txtPropertyLocationId").style.display = "none";
				}
			} 
		}
		/*
		* For location : End here
		*/

		function frmSubmitWithThanks() {
			document.frmProperty.action = document.frmProperty.action+"&shw=thanks";
			frmSubmit();
		}

		function frmSubmitWithTabs(strLink) {
			document.getElementById("frmPropertyId").action = strLink;
			frmSubmit();
		}
    </script>
	<script language="javascript" type="text/javascript">
		var x, y;
		function show_coords(event){	
			x=event.clientX;
			y=event.clientY;
			x = x-160;
			y = y+4;
			//alert(x);alert(y);
		}
	
		function toggleLayer(whichLayer){
			var output = document.getElementById(whichLayer).innerHTML;
			if(whichLayer == 'ANP-Example')
			{		
				output = '<div style="z-index:5;">'+output+'</div>';
				var googlewin=dhtmlwindow.open("Example", "inline", output, "", "width=320px,height=300px,resize=0,scrolling=0,center=1,xAxis="+x+",yAxis="+y+"", "recal");
			}
			else if(whichLayer == 'ANP-Pop')
			{
				var googlewin=dhtmlwindow.open("Example", "inline", output, "", "width=320px,height=300px,resize=0,scrolling=0,center=1,xAxis="+x+",yAxis="+y+"", "recal");
			}
			
			googlewin.onclose=function(){ //Run custom code when window is being closed (return false to cancel action):
				return true
			}
		}
		
		function closeWindow(){	
			document.getElementById("Example").style.display="none";
		}
	</script>
</head>
<body onmousedown="show_coords(event);">
<!-- Main Wrapper Starts Here -->
<div id="wrapper">
    <!-- Header Include Starts Here -->
    <div id="header" align="center">
        <?php require_once(SITE_INCLUDES_PATH.'header.php'); ?>
    </div>
    <!-- Header Include End Here -->
	<?php require_once(SITE_INCLUDES_PATH.'holidayadvsearch.php'); ?>
	<?php //require_once(SITE_INCLUDES_PATH.'breadcrumb.php'); ?>
    <div id="pg-wrapper" align="center"><h1 class="page-heading">Edit Property</h1></div>
    <div id="main">
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="left" valign="top">
					<?php require_once(SITE_INCLUDES_PATH.'owner-left-links.php'); ?>
                </td>
                <td width="30" align="left" valign="top" style="border-right:thin #efefef solid;">&nbsp;</td>
                <td align="left" valign="top" class="font12" style="padding-left:10px;">
                    <!-- main page: start here -->
                    <div class="pad-btm30 pad-rgt10 pad-top10">
                        <table border="0" cellspacing="0" cellpadding="0" width="100%">
                            <tr>
                                <td valign="top">
                                    <div class="FloatLft pad-rgt20 pad-btm20">
                                        <h1 class="page-headingNew"><?php echo ucfirst($propertyName);?></h1>
                                        <span class="font14-darkgrey lineHight18" style="clear:both;display:block;"><?php echo ucfirst($propertyTitle);?></span>
                                    </div>
                                </td>
                                <td width="190px" valign="bottom" align="right">
                                    <?php
                                    if(($propertyInfo['status'] != "2") && ($propertyInfo['active'] != "1")) {
                                    ?>
                                        <!--                                    
                                        <div align="right" class="pad-top10 pad-rgt20 pad-btm10" style="width:190px; background:#eaeaea;">
                                            <div class="pad-btm3"><span><img src="<?php echo SITE_IMAGES;?>alert-yellow.png" alt="Alert" style="vertical-align:middle;" />&nbsp;&nbsp;</span><span class="font14-darkgrey">Put your listing live?</span></div>
                                            <div><a href="<?php echo SITE_URL; ?>owner-shopping-cart.php?pid=<?php echo $property_id;?>" class="button-red" style="text-decoration:none;">Activate Now</a></div>
                                        </div>
                                        -->                                        
                                    <?php
                                    }
                                    ?>
                                </td>
                           </tr>
                        </table>
                    </div>
                    <div class="pad-btm5 pad-top50" style="float:left;">
                        <table width="745px" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td colspan="3" align="left" valign="top">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tr>
                                            <td colspan="3" align="left" valign="top" style="background:url(<?php echo SITE_IMAGES;?>chklst-bg.gif) repeat-x bottom;">
                                            <!--Tabbing Starts Here -->
                                            <ul>
												<?php /*?>
                                                <li><img src="<?php echo SITE_IMAGES;?>chklst-bg.gif" /></li>
												<?php */?>
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
                                                <li style="float:right; padding-right:5px;"><a href="javascript:poppropertypreview('holiday-property-preview.php?pid=<?php echo $property_id; ?>')"><img src="<?php echo SITE_IMAGES;?>add-white-icon.jpg" alt="CheckList" width="30" height="31" style="margin-top:-3px;" /></a></li>
                                            </ul>
                                            <!--Tabbing Ends Here -->
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="pad-btm5 font12"  style="float:left;">
                    <?php require_once(SITE_INCLUDES_PATH.$mainPage); ?>
                    </div>
                    <div class="clearfix"></div>
                </td>
            </tr>
        </table>
    </div>
</div>
<!-- Main Wrapper End Here -->
<!-- Footer Include Starts Here -->
<div id="footer">
    <?php require_once(SITE_INCLUDES_PATH.'footer.php'); ?>
</div>
<!-- Footer Include End Here -->
</body>
</html>
