<?php
// Form submision
$detail_array 	= array();
$error_msg		= 'no';

if($_POST['securityKey']==md5(TVLGUIDDELETE)){
	if($_GET['subsec'] == 'edittvlguid') {
		$trvl_guid_id = $_GET['tvlguidid'];
		$tvlguidObj->fun_delTvlGuid($trvl_guid_id);
		echo "<script> location.href='admin-collateral.php?sec=trvlguide';</script>";
	}
}

if($_POST['securityKey']==md5(ADDTVLCAT)){
	$trvl_guid_categories_name = $_POST['txtTvlCatName'];
	$trvl_guid_categories_desc = $_POST['txtTvlCatDesc'];
	if(isset($_POST['txtTvlCategoryId']) && $_POST['txtTvlCategoryId'] > 0) {
		$trvl_guid_categories_id  = $_POST['txtTvlCategoryId'];
		$tvlguidObj->fun_editTvlCat($trvl_guid_categories_id, $trvl_guid_categories_name, $trvl_guid_categories_desc);
	} else {
		$tvlguidObj->fun_addTvlCat($trvl_guid_categories_name, $trvl_guid_categories_desc);
	}
	echo "<script>location.href = window.location;</script>";
}

if($_POST['securityKey']==md5(ADDTVLGUID)){
	$trvl_guid_categories_id 		= $_POST['txtTvlCategoryId'];
	$trvl_guid_title 				= $_POST['txtTvlName'];
	$trvl_guid_area_id 				= $_POST['txtAddTvlGuidArea'];
	$trvl_guid_region_id 			= $_POST['txtAddTvlGuidRegion'];
	$trvl_guid_sub_region_id 		= $_POST['txtAddTvlGuidSubRegion'];
	$trvl_guid_location_id 			= $_POST['txtAddTvlGuidLocation'];
	$trvl_guid_desc 				= $_POST['txtTvlGuidDesc'];
	$trvl_guid_dir 					= $_POST['txtTvlGuidAreaDesc'];
	$trvl_guid_suit 				= $_POST['txtTvlGuidSuitDesc'];
	$trvl_guid_cost 				= $_POST['txtTvlGuidCostDesc'];
	$trvl_guid_long_last 			= $_POST['txtTvlGuidLastDesc'];
	$trvl_guid_open_detail 			= $_POST['txtTvlGuidOpenDesc'];
	$trvl_guid_attraction 			= $_POST['txtTvlGuidLikeDesc'];
	$trvl_guid_contact_phone 		= $_POST['txtTvlGuidContactPhone'];
	$trvl_guid_contact_web 			= $_POST['txtTvlGuidContactWebsite'];
	$trvl_guid_contact_email 		= $_POST['txtTvlGuidContactEmail'];
	$status 						= $_POST['txtTvlGuidStatus'];
	$featured 						= $_POST['txtTvlFeatured'];
	$trvl_guid_id = $tvlguidObj->fun_addTvlGuid($trvl_guid_categories_id, $trvl_guid_title, $trvl_guid_area_id, $trvl_guid_region_id, $trvl_guid_sub_region_id, $trvl_guid_location_id, $trvl_guid_desc, $trvl_guid_dir, $trvl_guid_suit, $trvl_guid_cost, $trvl_guid_long_last, $trvl_guid_open_detail, $trvl_guid_attraction, $trvl_guid_contact_phone, $trvl_guid_contact_web, $trvl_guid_contact_email, $status, $featured);
	$tvlguidObj->fun_moveTvlGuidFrmTmp($trvl_guid_id, $_REQUEST[PHPSESSID]);
	if(isset($trvl_guid_id) && $trvl_guid_id !="") {
		echo "<script>location.href = 'admin-collateral.php?sec=trvlguide&subsec=edittvlguid&tvlguidid=".$trvl_guid_id."';</script>";
	} else {
		echo "<script>location.href = 'admin-collateral.php?sec=trvlguide';</script>";
	}
}

if($_POST['securityKey']==md5(EDITTVLGUID)){
	if(isset($_GET['tvlguidid']) && $_GET['tvlguidid'] != "") {
		$trvl_guid_categories_id 		= $_POST['txtTvlCategoryId'];
		$trvl_guid_title 				= $_POST['txtTvlName'];
		$trvl_guid_area_id 				= $_POST['txtAddTvlGuidArea'];
		$trvl_guid_region_id 			= $_POST['txtAddTvlGuidRegion'];
		$trvl_guid_sub_region_id 		= $_POST['txtAddTvlGuidSubRegion'];
		$trvl_guid_location_id 			= $_POST['txtAddTvlGuidLocation'];
		$trvl_guid_desc 				= $_POST['txtTvlGuidDesc'];
		$trvl_guid_dir 					= $_POST['txtTvlGuidAreaDesc'];
		$trvl_guid_suit 				= $_POST['txtTvlGuidSuitDesc'];
		$trvl_guid_cost 				= $_POST['txtTvlGuidCostDesc'];
		$trvl_guid_long_last 			= $_POST['txtTvlGuidLastDesc'];
		$trvl_guid_open_detail 			= $_POST['txtTvlGuidOpenDesc'];
		$trvl_guid_attraction 			= $_POST['txtTvlGuidLikeDesc'];
		$trvl_guid_contact_phone 		= $_POST['txtTvlGuidContactPhone'];
		$trvl_guid_contact_web 			= $_POST['txtTvlGuidContactWebsite'];
		$trvl_guid_contact_email 		= $_POST['txtTvlGuidContactEmail'];
		$status 						= $_POST['txtTvlGuidStatus'];
		$featured 						= $_POST['txtTvlFeatured'];
		$trvl_guid_id 					= $_GET['tvlguidid'];
		//for photo caption details
		$txtTvlGuidPhotoId 				= $_POST['txtTvlGuidPhotoId'];
		$txtTvlGuidPhotoCaption 		= $_POST['txtTvlGuidPhotoCaption'];
		$txtTvlGuidPhotoBy 				= $_POST['txtTvlGuidPhotoBy'];
		$txtTvlGuidPhotoLink 			= $_POST['txtTvlGuidPhotoLink'];
	
		$tvlguidObj->fun_editTvlGuid($trvl_guid_id, $trvl_guid_categories_id, $trvl_guid_title, $trvl_guid_area_id, $trvl_guid_region_id, $trvl_guid_sub_region_id, $trvl_guid_location_id, $trvl_guid_desc, $trvl_guid_dir, $trvl_guid_suit, $trvl_guid_cost, $trvl_guid_long_last, $trvl_guid_open_detail, $trvl_guid_attraction, $trvl_guid_contact_phone, $trvl_guid_contact_web, $trvl_guid_contact_email, $status, $featured);
		if((count($txtTvlGuidPhotoId) > 0) && (count($txtTvlGuidPhotoCaption) > 0)) {
//			print_r($txtTvlGuidPhotoBy);
			$tvlguidObj->fun_editTvlGuidPhotos($txtTvlGuidPhotoId, $txtTvlGuidPhotoCaption, $txtTvlGuidPhotoBy, $txtTvlGuidPhotoLink);
		}
		echo "<script>location.href = window.location;</script>";
	}
}

if($_POST['securityKey']==md5(TRAVELGUIDEPHOTOSUPLOAD)){

	if(isset($_FILES['txtFile']) && ($_FILES['txtFile'] !="")){ // edit

		if($_GET['subsec'] == 'edittvlguid') {
			$trvl_guid_id = $_GET['tvlguidid'];
        } else {
			$trvl_guid_id = $_REQUEST[PHPSESSID];
        }

        $tvlguidObj->fun_delTvlGuidMainImg($trvl_guid_id, 1);
		//for photo caption details
		if(isset($_POST['txtTvlGuidPhotoCaption']) && $_POST['txtTvlGuidPhotoCaption'] != "") {
			$txtTvlGuidPhotoCaption = $_POST['txtTvlGuidPhotoCaption'];
			$photo_caption			= $txtTvlGuidPhotoCaption[0];
		}

		if(isset($_POST['txtTvlGuidPhotoBy']) && $_POST['txtTvlGuidPhotoBy'] != "") {
			$txtTvlGuidPhotoBy 	= $_POST['txtTvlGuidPhotoBy'];
			$photo_by			= $txtTvlGuidPhotoBy[0];
		}

		if(isset($_POST['txtTvlGuidPhotoLink']) && $_POST['txtTvlGuidPhotoLink'] != "") {
			$txtTvlGuidPhotoLink= $_POST['txtTvlGuidPhotoLink'];
			$photo_link			= $txtTvlGuidPhotoLink[0];
		}

        $main_img_id 	= $tvlguidObj->fun_addTvlGuidImg($trvl_guid_id, $photo_caption, '', '', 1);

		$trvl_guid_img 	= basename($_FILES['txtFile']['name']);
		$extn 		= split("\.",$trvl_guid_img);
		
		$photo_main 	= $trvl_guid_id."_".$main_img_id."_photo.".$extn[1];
		$photo_thumb 	= $trvl_guid_id."_".$main_img_id."_photo_thumb.".$extn[1];
		$uploadphotodir = '../upload/tvlguid_images/large';
		$uploadthumbdir = '../upload/tvlguid_images/thumbnail';

		$uploadphotofile = $uploadphotodir ."/". $photo_main;
		$uploadphotofile449x341 	= $uploadphotodir ."/449x341/". $photo_main;
		$uploadphotofile168x127 	= $uploadthumbdir ."/168x127/". $photo_thumb;

		if (move_uploaded_file($_FILES['txtFile']['tmp_name'], $uploadphotofile)){
			//croping done
			$imgObj->getCrop($uploadphotodir,$photo_main,449,341,$uploadphotofile449x341);
			$imgObj->getCrop($uploadphotodir,$photo_main,168,127,$uploadphotofile168x127);

        	$tvlguidObj->fun_updateTvlGuidImg($main_img_id, $trvl_guid_id, $photo_caption, $photo_main, $photo_thumb, $photo_by, $photo_link, 1);

            $trvl_guid_categories_id 		= $_POST['txtTvlCategoryId'];
            $trvl_guid_title 				= $_POST['txtTvlName'];
            $trvl_guid_area_id 				= $_POST['txtAddTvlGuidArea'];
            $trvl_guid_region_id 			= $_POST['txtAddTvlGuidRegion'];
            $trvl_guid_sub_region_id 		= $_POST['txtAddTvlGuidSubRegion'];
            $trvl_guid_location_id 			= $_POST['txtAddTvlGuidLocation'];
            $trvl_guid_desc 				= $_POST['txtTvlGuidDesc'];
            $trvl_guid_dir 					= $_POST['txtTvlGuidAreaDesc'];
            $trvl_guid_suit 				= $_POST['txtTvlGuidSuitDesc'];
            $trvl_guid_cost 				= $_POST['txtTvlGuidCostDesc'];
            $trvl_guid_long_last 			= $_POST['txtTvlGuidLastDesc'];
            $trvl_guid_open_detail 			= $_POST['txtTvlGuidOpenDesc'];
            $trvl_guid_attraction 			= $_POST['txtTvlGuidLikeDesc'];
            $trvl_guid_contact_phone 		= $_POST['txtTvlGuidContactPhone'];
            $trvl_guid_contact_web 			= $_POST['txtTvlGuidContactWebsite'];
            $trvl_guid_contact_email 		= $_POST['txtTvlGuidContactEmail'];
            $status 						= $_POST['txtTvlGuidStatus'];
            
            //case I: add
            if($_GET['subsec'] == 'edittvlguid') { // edit case
                $tvlguidObj->fun_editTvlGuid($trvl_guid_id, $trvl_guid_categories_id, $trvl_guid_title, $trvl_guid_area_id, $trvl_guid_region_id, $trvl_guid_sub_region_id, $trvl_guid_location_id, $trvl_guid_desc, $trvl_guid_dir, $trvl_guid_suit, $trvl_guid_cost, $trvl_guid_long_last, $trvl_guid_open_detail, $trvl_guid_attraction, $trvl_guid_contact_phone, $trvl_guid_contact_web, $trvl_guid_contact_email, $status);
                echo "<script>location.href = 'admin-collateral.php?sec=trvlguide&subsec=edittvlguid&tvlguidid=".$trvl_guid_id."';</script>";
            } else { // temp case
                $tvlguidObj->fun_addTvlGuidTemp($trvl_guid_categories_id, $trvl_guid_title, $trvl_guid_area_id, $trvl_guid_region_id, $trvl_guid_sub_region_id, $trvl_guid_location_id, $trvl_guid_desc, $trvl_guid_dir, $trvl_guid_suit, $trvl_guid_cost, $trvl_guid_long_last, $trvl_guid_open_detail, $trvl_guid_attraction, $trvl_guid_contact_phone, $trvl_guid_contact_web, $trvl_guid_contact_email);
                echo "<script>location.href = 'admin-collateral.php?sec=trvlguide&subsec=addtvlguid';</script>";
            }
		}
	}
}

if($_POST['securityKey']==md5(TRAVELGUIDEPREVIEW)){
	if($_GET['subsec'] == 'edittvlguid') {
		$trvl_guid_id = $_GET['tvlguidid'];
	} else {
		$trvl_guid_id = $_REQUEST[PHPSESSID];
	}

	$trvl_guid_categories_id 		= $_POST['txtTvlCategoryId'];
	$trvl_guid_title 				= $_POST['txtTvlName'];
	$trvl_guid_area_id 				= $_POST['txtAddTvlGuidArea'];
	$trvl_guid_region_id 			= $_POST['txtAddTvlGuidRegion'];
	$trvl_guid_sub_region_id 		= $_POST['txtAddTvlGuidSubRegion'];
	$trvl_guid_location_id 			= $_POST['txtAddTvlGuidLocation'];
	$trvl_guid_desc 				= $_POST['txtTvlGuidDesc'];
	$trvl_guid_dir 					= $_POST['txtTvlGuidAreaDesc'];
	$trvl_guid_suit 				= $_POST['txtTvlGuidSuitDesc'];
	$trvl_guid_cost 				= $_POST['txtTvlGuidCostDesc'];
	$trvl_guid_long_last 			= $_POST['txtTvlGuidLastDesc'];
	$trvl_guid_open_detail 			= $_POST['txtTvlGuidOpenDesc'];
	$trvl_guid_attraction 			= $_POST['txtTvlGuidLikeDesc'];
	$trvl_guid_contact_phone 		= $_POST['txtTvlGuidContactPhone'];
	$trvl_guid_contact_web 			= $_POST['txtTvlGuidContactWebsite'];
	$trvl_guid_contact_email 		= $_POST['txtTvlGuidContactEmail'];
	$status 						= $_POST['txtTvlGuidStatus'];
	//case I: add
	if($_GET['subsec'] == 'edittvlguid') { // edit case
		$tvlguidObj->fun_editTvlGuid($trvl_guid_id, $trvl_guid_categories_id, $trvl_guid_title, $trvl_guid_area_id, $trvl_guid_region_id, $trvl_guid_sub_region_id, $trvl_guid_location_id, $trvl_guid_desc, $trvl_guid_dir, $trvl_guid_suit, $trvl_guid_cost, $trvl_guid_long_last, $trvl_guid_open_detail, $trvl_guid_attraction, $trvl_guid_contact_phone, $trvl_guid_contact_web, $trvl_guid_contact_email, $status);
		echo "<script>location.href = 'admin-collateral.php?sec=trvlguide&subsec=edittvlguid&tvlguidid=".$trvl_guid_id."';</script>";
	} else { // temp case
		$tvlguidObj->fun_addTvlGuidTemp($trvl_guid_categories_id, $trvl_guid_title, $trvl_guid_area_id, $trvl_guid_region_id, $trvl_guid_sub_region_id, $trvl_guid_location_id, $trvl_guid_desc, $trvl_guid_dir, $trvl_guid_suit, $trvl_guid_cost, $trvl_guid_long_last, $trvl_guid_open_detail, $trvl_guid_attraction, $trvl_guid_contact_phone, $trvl_guid_contact_web, $trvl_guid_contact_email);
		echo "<script>location.href = 'admin-collateral.php?sec=trvlguide&subsec=addtvlguid';</script>";
	}
}

?>
<?php
if(isset($_GET['subsec']) && $_GET['subsec'] !=""){
	switch($_GET['subsec']){ // Add edit section for category
		case 'addcat':
		$addtitle = "Add / Edit Category";
		?>
		<script language="javascript" type="text/javascript">
			var req = ajaxFunction();
            function frmValidateAddTvlCat() {
                var shwError = false;
                if(document.frmAddTvlCat.txtTvlCatName.value == "") {
                    document.getElementById("txtTvlCatNameErrorId").innerHTML = "Please enter category name.";
                    document.frmAddTvlCat.txtTvlCatName.focus();
                    shwError = true;
                }
        
                if(document.frmAddTvlCat.txtTvlCatDesc.value == "") {
                    document.getElementById("txtTvlCatDescErrorId").innerHTML = "Please enter category description.";
                    document.frmAddTvlCat.txtTvlCatDesc.focus();
                    shwError = true;
                }
                
                if(shwError == true) {
                    return false;
                } else {
                    document.frmAddTvlCat.submit();
                }
            }
			
			function chkSelectTvlCategory() {
				var getID=document.getElementById("txtTvlCategoryId").value;
				if(getID !="" && getID != "0"){
					sendTvlCategoryRequest(getID);
				}
				if(getID == "0" || getID =="") {
					document.getElementById("txtTvlCategoryId").value = "0";
				}
			}

			function sendTvlCategoryRequest(id) { 
				req.open('get', '../selectTvlCategoryXml.php?id=' + id); 
				req.onreadystatechange = handleTvlCategoryResponse; 
				req.send(null); 
			} 

			function handleTvlCategoryResponse() { 
				if(req.readyState == 4) { 
					var response = req.responseText; 
					xmlDoc=req.responseXML;
					var root = xmlDoc.getElementsByTagName('tvlcategories')[0];
					if(root != null) {
						var items = root.getElementsByTagName("tvlcategory");
						var item = items[0];
						var id = item.getElementsByTagName("id")[0].firstChild.nodeValue;
						var name = item.getElementsByTagName("name")[0].firstChild.nodeValue;
						var description = item.getElementsByTagName("description")[0].firstChild.nodeValue;
						document.getElementById("txtTvlCatNameId").value = name;
						document.getElementById("txtTvlCatDescId").value = description;
					} else {
						document.getElementById("txtTvlCategoryId").value = "";
						document.getElementById("txtTvlCatNameId").value = "";
						document.getElementById("txtTvlCatDescId").value = "";
					}
				} 
			} 
			function chkblnkTxtError(strFieldId, strErrorFieldId) {
				if(document.getElementById(strFieldId).value != "") {
					document.getElementById(strErrorFieldId).innerHTML = "";
				}
			}
		
        </script>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
            <tr>
                <td valign="top" class="SectionSubHead"><?php echo $addtitle;?></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" valign="top">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                        <tr>
                            <td valign="top">
                                <!-- main body : Start here -->
                                <form name="frmAddTvlCat" id="frmAddTvlCat" action="admin-collateral.php?sec=trvlguide&subsec=addcat" method="post" >
                                <input type="hidden" name="securityKey" id="securityKey" value="<?php echo md5("ADDTVLCAT"); ?>">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                                    <tr><td height="5" colspan="2" valign="top">&nbsp;</td></tr>
                                    <tr>
                                        <td valign="top"><a href="admin-collateral.php?sec=trvlguide" class="back">Back to List</a></td>
                                        <td align="right" valign="top">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" valign="top">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                                                <tr>
                                                    <td valign="top" class="pad-top7">
                                                        <table width="690" border="0" cellspacing="0" cellpadding="0" class="font12">
                                                            <tr>
                                                                <td align="left" valign="top">
                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="10" class="eventForm">
                                                                        <tr>
                                                                            <td colspan="2" align="right" valign="top" class="header">
                                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                    <tr><td align="right" valign="bottom" colspan="2"><a href="admin-collateral.php?sec=trvlguide" style="text-decoration:none;"><img src="images/cancelN.png" alt="Preview" width="66" height="21" border="0" /></a>&nbsp;<a href="javascript:void(0);" onclick="frmValidateAddTvlCat();" style="text-decoration:none;"><img src="images/saveChangesN.png" alt="Save Approve" width="108" height="21" border="0" /></a></td></tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td height="23" align="right" valign="top" class="admleftBg">Select category OR new</td>
                                                                            <td  valign="top">
                                                                                <select class="select216" name="txtTvlCategoryId" id="txtTvlCategoryId" onchange="return chkSelectTvlCategory();" >
                                                                                    <option value="0">Add new...</option>
																					<?php $tvlguidObj->fun_getTvlCatListOptions($tvlguidCatInfoArr['trvl_guid_categories_pid']); ?>
                                                                                </select>
                                                                                <span class="pdError1 pad-lft10" id="txtTvlCategoryErrorId"></span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td height="23" align="right" valign="top" class="admleftBg">Category Name</td>
                                                                            <td  valign="top"><input name="txtTvlCatName" id="txtTvlCatNameId" class="inpuTxt260" value="" type="text" /><span class="pdError1 pad-lft10" id="txtTvlCatNameErrorId"></span></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td height="23" align="right" valign="top" class="admleftBg">Header text</td>
                                                                            <td  valign="top">
                                                                            <textarea name="txtTvlCatDesc" id="txtTvlCatDescId" class="textArea460"></textarea>
                                                                            <span class="pdError1 pad-lft10" id="txtTvlCatDescErrorId"></span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="2" align="right" valign="top" class="header">
                                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                    <tr><td align="right" valign="bottom" colspan="2"><a href="admin-collateral.php?sec=trvlguide" style="text-decoration:none;"><img src="images/cancelN.png" alt="Preview" width="66" height="21" border="0" /></a>&nbsp;<a href="javascript:void(0);" onclick="frmValidateAddTvlCat();" style="text-decoration:none;"><img src="images/saveChangesN.png" alt="Save Approve" width="108" height="21" border="0" /></a></td></tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                </form>
                                <!-- main body : End here -->
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
	<?php
	break;
	case 'addtvlguid':
	case 'edittvlguid':
		if($_GET['subsec'] == 'edittvlguid') {
			$trvl_guid_id = $_GET['tvlguidid'];
//			$trvl_guid_id = 1;
			$tvlguidInfoArr = $tvlguidObj->fun_getTravelInfo($trvl_guid_id);
//			print_r($tvlguidInfoArr);
			if(is_array($tvlguidInfoArr) && count($tvlguidInfoArr) > 0) {
				//find main image
				$tvlguidMainImgInfoArr 	= $tvlguidObj->fun_getTravelMainImgInfo($trvl_guid_id);
				$tvlguidImgInfoArr 		= $tvlguidObj->fun_getTravelImgArr($trvl_guid_id);
			}
			$addtitle = "Travel Guides";
			$edit = TRUE;
		} else {
			$tvlguidInfoArr = $tvlguidObj->fun_getTravelTmpInfo($_REQUEST[PHPSESSID]);
//			print_r($tvlguidInfoArr);
			if(is_array($tvlguidInfoArr) && count($tvlguidInfoArr) > 0) {
				//find main image
				$tvlguidMainImgInfoArr 	= $tvlguidObj->fun_getTravelMainImgInfo($_REQUEST[PHPSESSID]);
				$tvlguidImgInfoArr 		= $tvlguidObj->fun_getTravelImgArr($_REQUEST[PHPSESSID]);
			}
			$addtitle = "Add new travel guide";
			$edit = FALSE;
		}

		if(is_array($tvlguidMainImgInfoArr) && count($tvlguidMainImgInfoArr) > 0) {
			$tvlguidMainPhotoId 	= $tvlguidMainImgInfoArr['photo_id'];
			$tvlguidMainPhotoThumb 	= TVLGUID_IMAGES_THUMB168x127_PATH.$tvlguidMainImgInfoArr['photo_thumb'];
			$tvlguidMainPhotoCaption= $tvlguidMainImgInfoArr['photo_caption'];
			$tvlguidMainPhotoBy		= $tvlguidMainImgInfoArr['photo_by'];
			$tvlguidMainPhotoLink	= $tvlguidMainImgInfoArr['photo_link'];
		} else {
			$tvlguidMainPhotoThumb 		= TVLGUID_IMAGES_THUMB168x127_PATH."main-picture.gif";
			$tvlguidMainPhotoCaption	= "Add caption for image ...";
			$tvlguidMainPhotoCaption	.= "\nLeave blank if not required";
			$tvlguidMainPhotoBy			= "Photo by";
			$tvlguidMainPhotoLink		= "http://";
		}
//		print_r($tvlguidImgInfoArr);
	?>
        <!-- TinyMCE -->
        <script type="text/javascript" src="../tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
        <script type="text/javascript">
            tinyMCE.init({
                mode : "exact",
                elements : "txtTvlGuidDescId",
                theme : "advanced",
				plugins : 'advlink,advimage',
				relative_urls : false,
				remove_script_host : false
            });
        </script>
        <!-- /TinyMCE -->
		<script language="javascript" type="text/javascript">
			var req = ajaxFunction();
            function frmValidateAddTvlGuid() {
                var shwError = false;
				if(tinyMCE.get("txtTvlGuidDescId").getContent() == "") {
                    document.getElementById("txtTvlGuidDescErrorId").innerHTML = "Please enter General description.";
                    document.frmAddTvl.txtTvlGuidDesc.focus();
                    shwError = true;
				}

                if(document.frmAddTvl.txtTvlName.value == "") {
                    document.getElementById("txtTvlNameErrorId").innerHTML = "Please enter travel guide name.";
                    document.frmAddTvl.txtTvlName.focus();
                    shwError = true;
                }
        
                if(document.frmAddTvl.txtTvlCategoryId.value == "" || document.frmAddTvl.txtTvlCategoryId.value == "0") {
                    document.getElementById("txtTvlCategoryErrorId").innerHTML = "Please select category.";
                    document.frmAddTvl.txtTvlCategoryId.focus();
                    shwError = true;
                }
                
                if(shwError == true) {
                    return false;
                } else {
                    document.frmAddTvl.submit();
                }
            }
			
			function chkSelectTvlCategory() {
				var getID=document.getElementById("txtTvlCategoryId").value;
				if(getID !="" && getID != "0"){
					sendTvlCategoryRequest(getID);
				}
				if(getID == "0" || getID =="") {
					document.getElementById("txtTvlCategoryId").value = "0";
				}
			}

			function sendTvlCategoryRequest(id) { 
				req.open('get', '../selectTvlCategoryXml.php?id=' + id); 
				req.onreadystatechange = handleTvlCategoryResponse; 
				req.send(null); 
			} 

			function handleTvlCategoryResponse() { 
				if(req.readyState == 4) { 
					var response = req.responseText; 
					xmlDoc=req.responseXML;
					var root = xmlDoc.getElementsByTagName('tvlcategories')[0];
					if(root != null) {
						var items = root.getElementsByTagName("tvlcategory");
						var item = items[0];
						var id = item.getElementsByTagName("id")[0].firstChild.nodeValue;
						var name = item.getElementsByTagName("name")[0].firstChild.nodeValue;
						var description = item.getElementsByTagName("description")[0].firstChild.nodeValue;
						document.getElementById("txtTvlCatNameId").value = name;
						document.getElementById("txtTvlCatDescId").value = description;
					} else {
						document.getElementById("txtTvlCategoryId").value = "";
						document.getElementById("txtTvlCatNameId").value = "";
						document.getElementById("txtTvlCatDescId").value = "";
					}
				} 
			} 

			/*
			* For location : Start here
			*/
			
			function chkSelectArea4AddTvlGuid() {
				var getID=document.getElementById("txtAddTvlGuidAreaId").value;
				if(getID !="" && getID != "0"){
					sendRegionRequest4AddTvlGuid(getID);
					document.getElementById("txtAddTvlGuidRegionId").value = "0";
					document.getElementById("txtAddTvlGuidSubRegionId").value = "0";
					document.getElementById("txtAddTvlGuidLocationId").value = "0";
				}
				if(getID == "0" || getID =="") {
					document.getElementById("txtAddTvlGuidAreaId").value = "0";
					document.getElementById("txtAddTvlGuidRegionId").value = "0";
					document.getElementById("txtAddTvlGuidSubRegionId").value = "0";
					document.getElementById("txtAddTvlGuidLocationId").value = "0";
					document.getElementById("txtAddTvlGuidSubRegionId").style.display = "none";
					document.getElementById("txtAddTvlGuidLocationId").style.display = "none";
				}
			}
			
			function chkSelectRegion4AddTvlGuid() {
				var getID=document.getElementById("txtAddTvlGuidRegionId").value;
				if(getID !="" && getID != "0"){
					sendSubRegionRequest4AddTvlGuid(getID);
					document.getElementById("txtAddTvlGuidSubRegionId").value = "0";
					document.getElementById("txtAddTvlGuidLocationId").value = "0";
				}
				if(getID == "0" || getID =="") {
					document.getElementById("txtAddTvlGuidRegionId").value = "0";
					document.getElementById("txtAddTvlGuidSubRegionId").value = "0";
					document.getElementById("txtAddTvlGuidLocationId").value = "0";
					document.getElementById("txtAddTvlGuidSubRegionId").style.display = "none";
					document.getElementById("txtAddTvlGuidLocationId").style.display = "none";
				}
			}
			
			function chkSelectSubRegion4AddTvlGuid() {
				var getID=document.getElementById("txtAddTvlGuidSubRegionId").value;
				if(getID !="" && getID != "0"){
					sendLocationRequest4AddTvlGuid(getID);
					document.getElementById("txtAddTvlGuidLocationId").value = "0";
				}
				if(getID == "0" || getID =="") {
					document.getElementById("txtAddTvlGuidSubRegionId").value = "0";
					document.getElementById("txtAddTvlGuidLocationId").value = "0";
					document.getElementById("txtAddTvlGuidLocationId").style.display = "none";
				}
			}
		
			function chkSelectLocation4AddTvlGuid() {
				var getID=document.getElementById("txtAddTvlGuidLocationId").value;
				if(getID !="" && getID != "0"){
				}
				if(getID == "0" || getID =="") {
					document.getElementById("txtAddTvlGuidLocationId").value = "0";
				}
			}	
		
			function sendAreaRequest4AddTvlGuid(id) { 
				req.open('get', '../selectAreaXml.php?id=' + id); 
				req.onreadystatechange = handleAreaResponse4AddTvlGuid; 
				req.send(null); 
			} 
			
			function sendRegionRequest4AddTvlGuid(id) { 
				req.open('get', '../selectRegionXml.php?id=' + id); 
				req.onreadystatechange = handleRegionResponse4AddTvlGuid; 
				req.send(null); 
			} 
			
			function sendSubRegionRequest4AddTvlGuid(id) { 
				req.open('get', '../selectSubRegionXml.php?id=' + id); 
				req.onreadystatechange = handleSubRegionResponse4AddTvlGuid; 
				req.send(null); 
			} 
			
			function sendLocationRequest4AddTvlGuid(id) { 
				req.open('get', '../selectLocationXml.php?id=' + id); 
				req.onreadystatechange = handleLocationResponse4AddTvlGuid; 
				req.send(null); 
			} 
			
			function handleAreaResponse4AddTvlGuid() { 
				var arrayOfId = new Array();
				var arrayOfNames = new Array();
				if(req.readyState == 4) { 
					var response = req.responseText; 
					xmlDoc=req.responseXML;
					var root = xmlDoc.getElementsByTagName('ntowns')[0];
					if(root != null) {
						document.getElementById("txtAddTvlGuidAreaId").style.display = "block";
						document.getElementById("txtAddTvlGuidRegionId").style.display = "none";
						document.getElementById("txtAddTvlGuidSubRegionId").style.display = "none";
						document.getElementById("txtAddTvlGuidLocationId").style.display = "none";
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
							var p_city=document.getElementById("txtAddTvlGuidAreaId");
							p_city.length=0;
							p_city.options[0]=new Option("Please Select...","");
							for(var j=0; j<arrayOfId.length; j++) {
								p_city.options[j+1]=new Option(arrayOfNames[j], arrayOfId[j]);
							}
						} else {
							document.getElementById("txtAddTvlGuidAreaId").style.display = "none";
						}
					} else {
						document.getElementById("txtAddTvlGuidAreaId").style.display = "none";
						document.getElementById("txtAddTvlGuidRegionId").style.display = "none";
						document.getElementById("txtAddTvlGuidSubRegionId").style.display = "none";
						document.getElementById("txtAddTvlGuidLocationId").style.display = "none";
					}
				} 
			} 
			
			function handleRegionResponse4AddTvlGuid() { 
				var arrayOfId = new Array();
				var arrayOfNames = new Array();
				if(req.readyState == 4) { 
					var response = req.responseText; 
					xmlDoc=req.responseXML;
					var root = xmlDoc.getElementsByTagName('ntowns')[0];
					if(root != null) {
						document.getElementById("txtAddTvlGuidRegionId").style.display = "block";
						document.getElementById("txtAddTvlGuidSubRegionId").style.display = "none";
						document.getElementById("txtAddTvlGuidLocationId").style.display = "none";
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
		
							var p_city=document.getElementById("txtAddTvlGuidRegionId");
		
							p_city.length=0;
							p_city.options[0]=new Option("All Areas ...","0");
							for(var j=0; j<arrayOfId.length; j++) {
								p_city.options[j+1]=new Option(arrayOfNames[j],arrayOfId[j]);
							}
		//					sendSubRegionRequest(1);
						} else {
							document.getElementById("txtAddTvlGuidRegionId").style.display = "none";
			//				sendLocationRequest(document.getElementById("txtRegionId").value);
						}
					} else {
						document.getElementById("txtAddTvlGuidRegionId").style.display = "none";
						document.getElementById("txtAddTvlGuidSubRegionId").style.display = "none";
						document.getElementById("txtAddTvlGuidLocationId").style.display = "none";
					}
				} 
			} 
			
			function handleSubRegionResponse4AddTvlGuid() { 
				var arrayOfId = new Array();
				var arrayOfNames = new Array();
				if(req.readyState == 4) { 
					var response = req.responseText; 
					xmlDoc=req.responseXML;
					var root = xmlDoc.getElementsByTagName('ntowns')[0];
					if(root != null) {
						document.getElementById("txtAddTvlGuidSubRegionId").style.display = "block";
						document.getElementById("txtAddTvlGuidLocationId").style.display = "none";
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
							var p_city=document.getElementById("txtAddTvlGuidSubRegionId");
							p_city.length=0;
							p_city.options[0]=new Option("All Areas ...", "0");
							for(var j=0; j<arrayOfId.length; j++) {
								p_city.options[j+1]=new Option(arrayOfNames[j], arrayOfId[j]);
							}
		
		//					sendLocationRequest(9);
						} else {
							document.getElementById("txtAddTvlGuidSubRegionId").style.display = "none";
							sendLocationRequest4AddTvlGuid(document.getElementById("txtAddTvlGuidRegionId").value);
						}
					} else {
						document.getElementById("txtAddTvlGuidSubRegionId").style.display = "none";
						document.getElementById("txtAddTvlGuidLocationId").style.display = "none";
					}
				} 
			} 
			
			function handleLocationResponse4AddTvlGuid(){
				var arrayOfId = new Array();
				var arrayOfNames = new Array();
				if(req.readyState == 4) { 
					var response = req.responseText; 
					xmlDoc=req.responseXML;
					var root = xmlDoc.getElementsByTagName('ntowns')[0];
			//		alert(root);
					if(root != null) {
						document.getElementById("txtAddTvlGuidLocationId").style.display = "block";
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
		
							var p_city=document.getElementById("txtAddTvlGuidLocationId");
							p_city.length=0;
							p_city.options[0]=new Option("All Areas ...","0");
		
							for(var j=0; j<arrayOfId.length; j++) {
								p_city.options[j+1]=new Option(arrayOfNames[j], arrayOfId[j]);
							}
		
						} else {
							document.getElementById("txtAddTvlGuidLocationId").style.display = "none";
						}
					} else {
						document.getElementById("txtAddTvlGuidLocationId").style.display = "none";
					}
				} 
			}
			/*
			* For location : End here
			*/

			/*
			* For Delete Photo : Start here
			*/
			function delTvlGuidPhoto(strId){
				req.open('get', '../tvlguidimgdeleteXml.php?photoid='+strId); 
				req.onreadystatechange = handleDeleteResponse; 
				req.send(null); 
			}
		
			function handleDeleteResponse(){
				if(req.readyState == 4){
					var response=req.responseText;
					xmlDoc=req.responseXML;
					var root = xmlDoc.getElementsByTagName('photos')[0];
					if(root != null){
						var items = root.getElementsByTagName("photo");
						var item = items[0];
						var photostatus = item.getElementsByTagName("photostatus")[0].firstChild.nodeValue;
						if(photostatus == "Photo deleted."){
							window.location = location.href;
						}
					}
				}
			}

			/*
			* For Delete Photo : End here
			*/
			
			/*
			* For cancel add travel guide : Start here
			*/
			function cancelAddTvlGuid(strTvlGuidTmpId){
				req.open("GET", '../tvlguidtmpdeleteXml.php?tvlguidid='+strTvlGuidTmpId); 
				req.onreadystatechange = handleDeleteTmpResponse;
				req.send(null);   
			}

			function handleDeleteTmpResponse(){
				if(req.readyState == 4){
					var response=req.responseText;
					xmlDoc=req.responseXML;
					var root = xmlDoc.getElementsByTagName('travels')[0];
					if(root != null){
						var items = root.getElementsByTagName("travel");
						var item = items[0];
						var travelstatus = item.getElementsByTagName("travelstatus")[0].firstChild.nodeValue;
						if(travelstatus == "Travel guide deleted."){
							window.location = 'admin-collateral.php?sec=trvlguide';
						}
					}
				}
			}

			/*
			* For cancel add travel guide : Start here
			*/
			
			function showTvlGuidPreview(strTvlGuidCode) {
				var newWin = window.open("admin-tvl-guide-preview.php?tvlguidid="+ strTvlGuidCode +"","HTML",'dependent=1,toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,top=50,left=50,width=500,height=800');
				newWin.window.focus();
			}

			function showTvlGuidTmpPreview() {
				document.getElementById("securityKey").value = "<?php echo md5('TRAVELGUIDEPREVIEW')?>";
				document.frmAddTvl.action = "admin-collateral.php?sec=trvlguide&subsec=addtvlguid";
				document.frmAddTvl.submit();
				var newWin = window.open("admin-tvl-guide-preview.php","HTML",'dependent=1,toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,top=50,left=50,width=500,height=800');
				newWin.window.focus();
			}

            function frmAddTvlGuid4Later() {
				document.getElementById("txtTvlGuidStatusId").value = "4";
				frmValidateAddTvlGuid();
            }

            function frmAddTvlGuidNApprove() {
				document.getElementById("txtTvlGuidStatusId").value = "2";
				frmValidateAddTvlGuid();
            }

			/*
			* For travel guide pending - approval section : Start here
			*/
			function sbmtTvlGuidApproval(strId){
				var strId = strId;
				req.open('get', 'includes/ajax/admin-tvlguid-pending-approvalXml.php?tvlguid=' + strId + '&mode=approve'); 
				req.onreadystatechange = handleApprovalResponse; 
				req.send(null); 
			}
		
			function sbmtTvlGuidDecline(strId){
				document.getElementById("showDeclineReasonId").style.display = "block";
				var strId = strId;
				req.open('get', 'includes/ajax/admin-tvlguid-pending-approvalXml.php?tvlguid=' + strId + '&mode=decline'); 
				req.onreadystatechange = handleApprovalResponse; 
				req.send(null); 
			}
		
			function sbmtTvlGuidSuspend(strId){
				var strId = strId;
				req.open('get', 'includes/ajax/admin-tvlguid-pending-approvalXml.php?tvlguid=' + strId + '&mode=suspend'); 
				req.onreadystatechange = handleApprovalResponse; 
				req.send(null); 
			}
		
			function sbmtTvlGuidDelete(){
				
				document.getElementById("securityKey").value = "<?php echo md5('TVLGUIDDELETE')?>";
				document.frmAddTvl.submit();
			}
		
			function handleApprovalResponse() { 
				if(req.readyState == 4){ 
					var response = req.responseText; 
					xmlDoc=req.responseXML;
					var root = xmlDoc.getElementsByTagName('travels')[0];
					if(root != null){
						var items = root.getElementsByTagName("travel");
						var item = items[0];
						var travelstatus = item.getElementsByTagName("travelstatus")[0].firstChild.nodeValue;
						if(travelstatus == "Approved"){
							document.getElementById("txtAdminOptionId").innerHTML 	= "<font color='#FFFFFF' size='2'><strong>"+travelstatus+"</strong></font>";
						}
						else if(travelstatus == "Declined"){
							document.getElementById("txtAdminOptionId").innerHTML 	= "<font color='#FFFFFF' size='2'><strong>"+travelstatus+"</strong></font>";
						}
						else if(travelstatus == "Suspended"){
							document.getElementById("txtAdminOptionId").innerHTML 	= "<font color='#FFFFFF' size='2'><strong>"+travelstatus+"</strong></font>";
						}
						else{
							document.getElementById("txtAdminOptionId").innerHTML 	= "<font color='#FFFFFF' size='2'><strong>Error, try later!</strong></font>";
						}
					}
					else{
						document.getElementById("txtAdminOptionId").innerHTML 	= "<font color='#FFFFFF' size='2'><strong>Error, try later!</strong></font>";
					}
				} 
				else{
					document.getElementById("txtAdminOptionId").innerHTML 	= "<font color='#FFFFFF' size='2'><strong>Please wait...</strong></font>";
				}
			} 
			/*
			* For travel guide pending - approval section : End here
			*/

			/*
			* For travel guide upload new images: End here
			*/
			function addNewPhoto(strId) {
				var newWin = window.open("admin-tvl-guide-img-upload.php?tvlguidid="+strId,"HTML",'dependent=1,toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,top=50,left=50,width=620,height=220');
				newWin.window.focus();
			}

			function addNewPhotoTmp() {
				var newWin = window.open("admin-tvl-guide-img-upload.php","HTML",'dependent=1,toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,top=50,left=50,width=620,height=220');
				newWin.window.focus();
			}
			/*
			* For travel guide upload new images: End here
			*/
			function chkblnkTxtError(strFieldId, strErrorFieldId) {
				if(document.getElementById(strFieldId).value != "") {
					document.getElementById(strErrorFieldId).innerHTML = "";
				}
			}
		

        </script>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
            <tr>
                <td valign="top" class="SectionSubHead"><?php echo $addtitle;?></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" valign="top">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                        <tr>
                            <td valign="top">
                            <input type="hidden" name="txtDelItem" id="txtDelItem" value="" />
                                <!-- main body : Start here -->
                                <form name="frmAddTvl" id="frmAddTvl" action="admin-collateral.php?sec=trvlguide<?php if($edit == true) { echo "&subsec=edittvlguid&tvlguidid=".$trvl_guid_id; } ?>" method="post" enctype="multipart/form-data" >
                                <input type="hidden" name="securityKey" id="securityKey" value="<?php if($edit == true) { echo md5("EDITTVLGUID"); } else { echo md5("ADDTVLGUID"); } ?>">
                                <input type="hidden" name="txtTvlGuidStatus" id="txtTvlGuidStatusId" value="1">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                                    <tr><td height="5" colspan="2" valign="top">&nbsp;</td></tr>
                                    <tr>
                                        <td valign="top"><a href="admin-collateral.php?sec=trvlguide" class="back">Back to List</a></td>
                                        <td align="right" valign="top">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" valign="top">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                                                <tr>
                                                    <td valign="top" class="pad-top7">
                                                        <table width="690" border="0" cellspacing="0" cellpadding="0" class="font12">
                                                            <tr>
                                                                <td align="left" valign="top">
                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="10" class="eventForm">
																	<?php 
                                                                        if(isset($trvl_guid_id) && $trvl_guid_id!= "") {
                                                                        ?>
                                                                        <tr>
                                                                            <td colspan="2" align="right" valign="top" class="header">
                                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                    <tr>
                                                                                        <td>
                                                                                        <div id="txtAdminOptionId">
                                                                                        <?php 
                                                                                            if($tvlguidInfoArr['status'] == "0" || $tvlguidInfoArr['status'] == "1" || $tvlguidInfoArr['status'] == "3" || $tvlguidInfoArr['status'] == "4") {
                                                                                        ?>
                                                                                            <a href="javascript:sbmtTvlGuidDelete();" style="text-decoration:none;"><img src="images/DeleteN.png" alt="Delete" width="60" height="21" /></a>&nbsp;<a href="javascript:sbmtTvlGuidApproval(<?php echo $trvl_guid_id; ?>);" style="text-decoration:none;"><img src="images/approveN.png" alt="Approve" width="71" height="21" border="0" /></a>
                                                                                        <?php
                                                                                            } else {
                                                                                        ?>
                                                                                            <a href="javascript:sbmtTvlGuidDelete();" style="text-decoration:none;"><img src="images/DeleteN.png" alt="Delete" width="60" height="21" /></a>&nbsp;<a href="javascript:sbmtTvlGuidSuspend(<?php echo $trvl_guid_id; ?>);" style="text-decoration:none;"><img src="images/suspendN.png" alt="Suspend" width="74" height="21" /></a>
                                                                                        <?php
                                                                                            }
                                                                                        ?>
                                                                                        </div>
                                                                                        </td>
<!--                                                                                        <td align="right" valign="bottom"><img src="images/previousN.png" alt="Preview" width="74" height="21" /> <img src="images/nextN.png" alt="Cancel" width="48" height="21" /></td>
-->                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
																		<?php
                                                                        }
                                                                    ?>
                                                                        <tr>
                                                                            <td colspan="2" align="right" valign="top" class="header">
                                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                    <tr>
                                                                                        <td align="right" valign="bottom" colspan="2">
                                                                                        	<?php 
																								if(isset($trvl_guid_id) && $trvl_guid_id!= "") {
																								?>
                                                                                                    <a href="javascript:<?php echo "showTvlGuidPreview('".$trvl_guid_id."')"; ?>;" style="text-decoration: none;"><img src="images/previewN.png" alt="Preview" border="0" height="21" width="71"></a>&nbsp;<a href="admin-collateral.php?sec=trvlguide" style="text-decoration: none;"><img src="images/cancelN.png" alt="Preview" border="0" height="21" width="66"></a>&nbsp;<a href="javascript:void(0);" onclick="frmValidateAddTvlGuid();" style="text-decoration:none;"><img src="images/saveChangesN.png" alt="Save Approve" width="108" height="21" border="0" /></a>
                                                                                                <?php
																								} else {
																								?>
                                                                                                    <a href="javascript:<?php echo "showTvlGuidTmpPreview()"; ?>;" style="text-decoration: none;"><img src="images/previewN.png" alt="Preview" border="0" height="21" width="71"></a>&nbsp;<a href="javascript:<?php echo "cancelAddTvlGuid('".$_REQUEST[PHPSESSID]."')"; ?>;" style="text-decoration: none;"><img src="images/cancelN.png" alt="Preview" border="0" height="21" width="66"></a>&nbsp;<a href="javascript:void(0);" onclick="frmAddTvlGuid4Later();" style="text-decoration:none;"><img src="images/saveLaterN.png" alt="Save for later" border="0" height="21" width="102"></a>&nbsp;<a href="javascript:void(0);" onclick="frmAddTvlGuidNApprove();" style="text-decoration:none;"><img src="images/saveApproveN.png" alt="Save & approve" border="0" height="21" width="117"></a>
                                                                                                <?php
																								}
																							?>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td height="23" align="right" valign="top" class="admleftBg">Select category</td>
                                                                            <td  valign="top">
                                                                                <select class="select216" name="txtTvlCategoryId" id="txtTvlCategoryId" onchange="return chkSelectTvlCategory();" >
                                                                                    <option value="0">Select...</option>
																					<?php $tvlguidObj->fun_getTvlCatListOptions($tvlguidInfoArr['trvl_guid_categories_id']); ?>
                                                                                </select><span class="pdError1 pad-lft10" id="txtTvlCategoryErrorId"></span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td height="23" align="right" valign="top" class="admleftBg">Guide titile</td>
                                                                            <td  valign="top"><input name="txtTvlName" id="txtTvlNameId" class="inpuTxt260" value="<?php echo $tvlguidInfoArr['trvl_guid_title']; ?>" type="text" /><span class="pdError1 pad-lft10" id="txtTvlNameErrorId"></span></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="190" height="23" align="right" valign="top" class="admleftBg">Location</td>
                                                                            <td  valign="top">
                                                                            <div id="showtxtlocationcombo">
                                                                            <?php
																				if($edit == TRUE) {
																				// Logic for edit location
																				// if all
																					if(isset($tvlguidInfoArr['trvl_guid_area_id']) && ($tvlguidInfoArr['trvl_guid_area_id'] != "" || $tvlguidInfoArr['trvl_guid_area_id'] != "0")) {
																						$trvl_guid_area_id = $tvlguidInfoArr['trvl_guid_area_id'];
																						?>
																						<select name="txtAddTvlGuidArea" id="txtAddTvlGuidAreaId" onchange="return chkSelectArea4AddTvlGuid();" style="display:block;" class="select216">
																							<?php 
																								$locationObj->fun_getAreaListOptions($trvl_guid_area_id, '');
																							?>
																						</select>
																						<?php
																						if(isset($tvlguidInfoArr['trvl_guid_region_id']) && ($tvlguidInfoArr['trvl_guid_region_id'] != "0" || $tvlguidInfoArr['trvl_guid_region_id'] != "")) {
																							$trvl_guid_region_id = $tvlguidInfoArr['trvl_guid_region_id'];
																						?>
																						<select name="txtAddTvlGuidRegion" id="txtAddTvlGuidRegionId" onchange="return chkSelectRegion4AddTvlGuid();" style="display:block;" class="select216">
																							<option value="0">All Areas ...</option>
																							<?php 
																								$locationObj->fun_getRegionListOptions($trvl_guid_region_id, '0', $trvl_guid_area_id);
																							?>
																						</select>
																						<?php
																							if(isset($tvlguidInfoArr['trvl_guid_sub_region_id']) && ($tvlguidInfoArr['trvl_guid_sub_region_id'] != "0") && ($tvlguidInfoArr['trvl_guid_sub_region_id'] != "")) {
																								$trvl_guid_sub_region_id = $tvlguidInfoArr['trvl_guid_sub_region_id'];
																								?>
																								<select name="txtAddTvlGuidSubRegion" id="txtAddTvlGuidSubRegionId" onchange="return chkSelectSubRegion4AddTvlGuid();" style="display:block;" class="select216">
																									<option value="0">All Areas ...</option>
																									<?php 
																										$locationObj->fun_getRegionListOptions($trvl_guid_sub_region_id, $trvl_guid_region_id, $trvl_guid_area_id);
																									?>
																								</select>
																								<?php
																							} else {
																								?>
																								<select name="txtAddTvlGuidSubRegion" id="txtAddTvlGuidSubRegionId" onchange="return chkSelectSubRegion4AddTvlGuid();" style="display:<?php if(($trvl_guid_region_id !="" && $trvl_guid_region_id > 0) && (!isset($tvlguidInfoArr['trvl_guid_location_id']) || ($tvlguidInfoArr['trvl_guid_location_id'] == "0") || ($tvlguidInfoArr['trvl_guid_location_id'] == "")) && ($locationObj->fun_countSubRegionByRegionid($trvl_guid_region_id) > 0)){echo "block";} else {echo "none";} ?>;" class="select216">
																									<option value="0">All Areas ...</option>
																									<?php 
                                                                                                    if(($trvl_guid_region_id !="" && $trvl_guid_region_id > 0) && (!isset($tvlguidInfoArr['trvl_guid_location_id']) || ($tvlguidInfoArr['trvl_guid_location_id'] == "0") || ($tvlguidInfoArr['trvl_guid_location_id'] == ""))){
                                                                                                        $locationObj->fun_getRegionListOptions('', $trvl_guid_region_id, $trvl_guid_area_id);
                                                                                                    }
                                                                                                    ?>
																								</select>
																								<?php
																							}
																							if(isset($tvlguidInfoArr['trvl_guid_location_id']) && ($tvlguidInfoArr['trvl_guid_location_id'] != "0") && ($tvlguidInfoArr['trvl_guid_location_id'] != "")) {
																								$trvl_guid_location_id = $tvlguidInfoArr['trvl_guid_location_id'];
																								?>
																								<select name="txtAddTvlGuidLocation" id="txtAddTvlGuidLocationId" onchange="return chkSelectLocation4AddTvlGuid();" style="display:block;" class="select216">
																									<option value="0">All Areas ...</option>
																									<?php
																										$locationObj->fun_getLocationListOptions($trvl_guid_location_id);
																									?>
																								</select>
																								<?php
																							} else {
																								?>
																								<select name="txtAddTvlGuidLocation" id="txtAddTvlGuidLocationId" onchange="return chkSelectLocation4AddTvlGuid();" style="display:<?php if(((!isset($trvl_guid_sub_region_id) || ($trvl_guid_sub_region_id =="0")) && ($trvl_guid_region_id !="") && ($trvl_guid_region_id > 0) && ($locationObj->fun_countLocationsByRegionid($trvl_guid_region_id) > 0)) || (($trvl_guid_sub_region_id !="") && ($trvl_guid_sub_region_id > 0) && ($locationObj->fun_countLocationsByRegionid($trvl_guid_sub_region_id) > 0))){echo "block";} else {echo "none";} ?>;" class="select216">
																									<option value="0">All Areas ...</option>
																									<?php
                                                                                                    if(($trvl_guid_sub_region_id !="") && ($trvl_guid_sub_region_id > 0) && ($locationObj->fun_countLocationsByRegionid($trvl_guid_sub_region_id) > 0)) {
                                                                                                        $locationObj->fun_getLocationListOptions('', $trvl_guid_sub_region_id);
                                                                                                    } else if(($trvl_guid_region_id !="") && ($trvl_guid_region_id > 0) && ($locationObj->fun_countLocationsByRegionid($trvl_guid_region_id) > 0)) {
                                                                                                        $locationObj->fun_getLocationListOptions('', $trvl_guid_region_id);
                                                                                                    }
                                                                                                    ?>
																								</select>
																								<?php
																							}
																						}
																					}
																				} else {
																				?>
                                                                                <select name="txtAddTvlGuidArea" id="txtAddTvlGuidAreaId" onchange="return chkSelectArea4AddTvlGuid();" style="display:block;" class="select216">
																				<?php 
                                                                                    $locationObj->fun_getAreaListOptions('', '');
                                                                                ?>
                                                                                </select>
                                                                                <select name="txtAddTvlGuidRegion" id="txtAddTvlGuidRegionId" onchange="return chkSelectRegion4AddTvlGuid();" style="display:block;" class="select216">
                                                                                    <option value="0" selected>All Areas ...</option>
                                                                                    <?php 
                                                                                        $locationObj->fun_getRegionListOptions('', '0', '1');
                                                                                    ?>
                                                                                </select>
                                                                                <select name="txtAddTvlGuidSubRegion" id="txtAddTvlGuidSubRegionId" onchange="return chkSelectSubRegion4AddTvlGuid();" style="display:none;" class="select216">
                                                                                    <option value="0" selected>All Areas ...</option>
                                                                                </select>
                                                                                <select name="txtAddTvlGuidLocation" id="txtAddTvlGuidLocationId" onchange="return chkSelectLocation4AddTvlGuid();" style="display:none;" class="select216">
                                                                                    <option value="0" selected>All Areas ...</option>
                                                                                </select>
                                                                                <?php
																				}
																			?>
                                                                            </div><span class="pdError1" id="txtAddTvlGuidLocationErrorId"></span>
                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td height="23" align="right" valign="top" class="admleftBg">General description</td>
                                                                            <td  valign="top">
                                                                            <textarea name="txtTvlGuidDesc" id="txtTvlGuidDescId" class="textArea460x450"><?php echo $tvlguidInfoArr['trvl_guid_desc']; ?></textarea>
                                                                            <span class="pdError1 pad-lft10" id="txtTvlGuidDescErrorId"></span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td height="23" align="right" valign="top" class="admleftBg">Featured</td>
                                                                            <td  valign="top">
                                                                                <select class="select216" name="txtTvlFeatured" id="txtTvlFeaturedId">
                                                                                    <option value="0">No</option>
                                                                                    <option value="1" <?php if(isset($tvlguidInfoArr['featured']) && ($tvlguidInfoArr['featured'] == "1")) {echo "selected=\"selected\"";}?> >Yes</option>
                                                                                </select><span class="pdError1 pad-lft10" id="txtTvlFeaturedErrorId"></span>
                                                                            </td>
                                                                        </tr>
																		<?php
																		/*
																		?>
                                                                        <tr>
                                                                            <td height="23" align="right" valign="top" class="admleftBg">Getting there</td>
                                                                            <td  valign="top">
                                                                            <textarea name="txtTvlGuidAreaDesc" id="txtTvlGuidAreaDescId" class="textArea460x100"><?php echo $tvlguidInfoArr['trvl_guid_dir']; ?></textarea>
                                                                            <span class="pdError1 pad-lft10" id="txtTvlGuidAreaDescErrorId"></span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td height="23" align="right" valign="top" class="admleftBg">Suitability</td>
                                                                            <td  valign="top">
                                                                            <textarea name="txtTvlGuidSuitDesc" id="txtTvlGuidSuitDescId" class="textArea460x60"><?php echo $tvlguidInfoArr['trvl_guid_suit']; ?></textarea>
                                                                            <span class="pdError1 pad-lft10" id="txtTvlGuidSuitDescErrorId"></span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td height="23" align="right" valign="top" class="admleftBg">Cost</td>
                                                                            <td  valign="top">
                                                                            <textarea name="txtTvlGuidCostDesc" id="txtTvlGuidCostDescId" class="textArea460x60"><?php echo $tvlguidInfoArr['trvl_guid_cost']; ?></textarea>
                                                                            <span class="pdError1 pad-lft10" id="txtTvlGuidCostDescErrorId"></span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td height="23" align="right" valign="top" class="admleftBg">How long does it last?</td>
                                                                            <td  valign="top">
                                                                            <textarea name="txtTvlGuidLastDesc" id="txtTvlGuidLastDescId" class="textArea460x60"><?php echo $tvlguidInfoArr['trvl_guid_long_last']; ?></textarea>
                                                                            <span class="pdError1 pad-lft10" id="txtTvlGuidLastDescErrorId"></span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td height="23" align="right" valign="top" class="admleftBg">When is it open and <br />when should we go?</td>
                                                                            <td  valign="top">
                                                                            <textarea name="txtTvlGuidOpenDesc" id="txtTvlGuidOpenDescId" class="textArea460x60"><?php echo $tvlguidInfoArr['trvl_guid_open_detail']; ?></textarea>
                                                                            <span class="pdError1 pad-lft10" id="txtTvlGuidOpenDescErrorId"></span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td height="23" align="right" valign="top" class="admleftBg">What is it really like?</td>
                                                                            <td  valign="top">
                                                                            <textarea name="txtTvlGuidLikeDesc" id="txtTvlGuidLikeDescId" class="textArea460x60"><?php echo $tvlguidInfoArr['trvl_guid_attraction']; ?></textarea>
                                                                            <span class="pdError1 pad-lft10" id="txtTvlGuidLikeDescErrorId"></span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td height="23" align="right" valign="top" class="admleftBg">Contact</td>
                                                                            <td  valign="top">
                                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                    <tr>
                                                                                        <td align="left" width="60" class="pad-rgt10 pad-btm10" valign="top">Telephone</td>
                                                                                        <td valign="top"><input name="txtTvlGuidContactPhone" id="txtTvlGuidContactPhoneId" class="inpuTxt260" value="<?php echo $tvlguidInfoArr['trvl_guid_contact_phone']; ?>" type="text" /></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td align="left" class="pad-rgt10 pad-btm10" valign="top">Website</td>
                                                                                        <td valign="top"><input name="txtTvlGuidContactWebsite" id="txtTvlGuidContactWebsiteId" class="inpuTxt260" value="<?php echo $tvlguidInfoArr['trvl_guid_contact_web']; ?>" type="text" /></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td align="left" class="pad-rgt10 pad-btm10" valign="top">Email</td>
                                                                                        <td valign="top"><input name="txtTvlGuidContactEmail" id="txtTvlGuidContactEmailId" class="inpuTxt260" value="<?php echo $tvlguidInfoArr['trvl_guid_contact_email']; ?>" type="text" /></td>
                                                                                    </tr>
                                                                                </table>
                                                                                <span class="pdError1 pad-lft10" id="txtTvlGuidContactPhoneErrorId"></span>
                                                                            </td>
                                                                        </tr>
																		<?php
																		*/
																		?>
                                                                        <tr>
                                                                            <td height="23" width="190" align="right" valign="top" class="admleftBg">Picture</td>
                                                                            <td  valign="top" style="padding:0px;">
                                                                                <script language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>si.files.js" type="text/javascript"></script>
                                                                                <script type="text/javascript" language="javascript">
                                                                                    function uploadFile(obj, val) {
                                                                                        fileVal 		= "txtFile"+val;
                                                                                        filePhotoVal	= "txtPhoto"+val;
                                                                                        photoError		= "photoError"+val;
                                                                                        fileUrl 		= document.getElementById(fileVal).value;
                                                                                        fileUrl				= rm_trim(fileUrl);
                                                                                        if(fileUrl == ""){
                                                                                            document.getElementById(photoError).innerHTML = "<font color='#FFFFFF' size='2'><strong>Please select a photo to upload</strong></font>";
                                                                                            document.getElementById(filePhotoVal).focus();
                                                                                            return false;
                                                                                        }
                                                                                        else{
                                                                                            document.getElementById(photoError).innerHTML = "";
                                                                                            document.getElementById("securityKey").value = "<?php echo md5('TRAVELGUIDEPHOTOSUPLOAD')?>";
                                                                                            obj.enctype = "multipart/form-data";
                                                                                            obj.submit();
                                                                                        }	
                                                                                    }        
                                                                                
                                                                                    function showValue(val){		
                                                                                        var filePath = "txtFile"+val;
                                                                                        var file_photo = "txtPhoto"+val;
                                                                                        document.getElementById(file_photo).value = document.getElementById(filePath).value;
                                                                                    }
                                                                                </script>
                                                                                <style type="text/css" title="text/css">
                                                                                .SI-FILES-STYLIZED label.cabinet{
                                                                                    width: 57px;
                                                                                    height: 23px;
                                                                                    background-image: url(images/browse.gif);
                                                                                    background-repeat: no-repeat;
                                                                                    display: block;
                                                                                    overflow: hidden;
                                                                                    cursor: pointer;
                                                                                    position: relative;
                                                                                }
                                                                                .SI-FILES-STYLIZED label.cabinet input.file{
                                                                                    position: relative;
                                                                                    width: auto;
                                                                                    height: 100%;
                                                                                    _display: block;
                                                                                    _float: right;
                                                                                    _height: 23px;
                                                                                    _width: 57px;
                                                                                    opacity: 0;
                                                                                    -moz-opacity: 0;
                                                                                    filter:progid:DXImageTransform.Microsoft.Alpha(opacity=0);
                                                                                }
                                                                                </style>
                                                                                <table border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
                                                                                    <tr>
                                                                                        <td>
                                                                                        <img src="<?php echo $tvlguidMainPhotoThumb; ?>" name="PreviewImage0" width="199" height="149" class="photo-add" id="PreviewImage0" />
                                                                                        </td>
                                                                                        <td align="left" valign="top" class="pad-rgt10">
                                                                                            <table border="0" cellspacing="0" cellpadding="0">
                                                                                                <tr>
                                                                                                    <td style="padding-top:13px;">
                                                                                                        <div style="width: 57px; height:23px; overflow: hidden;">
                                                                                                            <label class="cabinet">
                                                                                                                <input type="file" name="txtFile" id="txtFile0" class="file" value="" onchange="return showValue('0');"/>
                                                                                                            </label>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                    <td style="padding-top:13px;"><input name="txtPhoto" type="text" id="txtPhoto0"  style="width:140px; height:17px; border: solid 1px #aeaeae; padding-top:2px; padding-bottom:2px; padding-left:5px;" value="" /></td>
                                                                                                    <td style="padding-top:13px;"><img src="images/upload.gif" alt="upload" onclick="return uploadFile(document.frmAddTvl, '0');" /></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td style="padding-top:5px; padding-left:00px;" colspan="3">
                                                                                                        <p style="float:left; font-size:12px; padding-top:5px;">
                                                                                                            <input type="hidden" name="txtTvlGuidPhotoId[]" id="txtTvlGuidPhotoId0" value="<?php echo $tvlguidMainPhotoId; ?>">
                                                                                                            <textarea name="txtTvlGuidPhotoCaption[]" id="txtTvlGuidPhotoCaptionId0" class="textArea260x60" onclick="return bnkTvlGuidImgCaption('0');" onblur="return restoreTvlGuidImgCaption('0');" ><?php echo $tvlguidMainPhotoCaption; ?></textarea>
                                                                                                            <div style=" padding-bottom:10px;">
                                                                                                            <input name="txtTvlGuidPhotoBy[]" id="txtTvlGuidPhotoById0" class="inpuTxt270" value="<?php if(isset($tvlguidMainPhotoBy) && $tvlguidMainPhotoBy !="") { echo $tvlguidMainPhotoBy;} else { echo "Photo by"; } ?>" type="text" onclick="return bnkTvlGuidPhotoBy('0');" onblur="return restoreTvlGuidPhotoBy('0');"  onkeydown="chkblnkTxtError('txtTvlGuidPhotoById0', 'photoError0');" onkeyup="chkblnkTxtError('txtTvlGuidPhotoById0', 'photoError0');" />
                                                                                                            </div>
                                                                                                            <input name="txtTvlGuidPhotoLink[]" id="txtTvlGuidPhotoLinkId0" class="inpuTxt270" value="<?php if(isset($tvlguidMainPhotoLink) && $tvlguidMainPhotoLink !="") { echo $tvlguidMainPhotoLink;} else { echo "http://"; } ?>" type="text" onclick="return bnkTvlGuidPhotoLink('0');" onblur="return restoreTvlGuidPhotoLink('0');"  onkeydown="chkblnkTxtError('txtTvlGuidPhotoLinkId0', 'photoError0');" onkeyup="chkblnkTxtError('txtTvlGuidPhotoLinkId0', 'photoError0');" />
                                                                                                        <script type="text/javascript" language="javascript">
                                                                                                        // <![CDATA[
                                                                                                        
                                                                                                        SI.Files.stylizeAll();
                                                                                                        
                                                                                                        /*
                                                                                                        --------------------------------
                                                                                                        Known to work in:
                                                                                                        --------------------------------
                                                                                                        - IE 5.5+
                                                                                                        - Firefox 1.5+
                                                                                                        - Safari 2+
                                                                                                        --------------------------------
                                                                                                        Known to degrade gracefully in:
                                                                                                        --------------------------------
                                                                                                        - Opera
                                                                                                        - IE 5.01
                                                                                                        --------------------------------
                                                                                                        Optional configuration:
                                                                                                        
                                                                                                        Change before making method calls.
                                                                                                        --------------------------------
                                                                                                        SI.Files.htmlClass = 'SI-FILES-STYLIZED';
                                                                                                        SI.Files.fileClass = 'file';
                                                                                                        SI.Files.wrapClass = 'cabinet';
                                                                                                        
                                                                                                        --------------------------------
                                                                                                        Alternate methods:
                                                                                                        --------------------------------
                                                                                                        SI.Files.stylizeById('input-id');
                                                                                                        SI.Files.stylize(HTMLInputNode);
                                                                                                        
                                                                                                        --------------------------------
                                                                                                        */
                                                                                                        // ]]>
                                                                                                        </script>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td colspan="3">
                                                                                                        <table cellpadding="0" cellspacing="0" width="100%" border="0">
                                                                                                            <tr>
                                                                                                                <td width="240" valign="bottom"><div id="photoError0"></div></td>
                                                                                                            </tr>
                                                                                                        </table>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </table>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td colspan="2" class="pad-lft15">
																						<?php if(isset($tvlguidMainPhotoId) && $tvlguidMainPhotoId !="") {echo "<a href=\"JavaScript:delTvlGuidPhoto(".$tvlguidMainPhotoId.");\" class=\"delete-photo\">Remove picture</a>&nbsp;&nbsp;";} ?>
																						<?php
																							if((!is_array($tvlguidImgInfoArr) || count($tvlguidImgInfoArr) < 2) && (isset($tvlguidMainPhotoId) && $tvlguidMainPhotoId !="")) {
																								if(isset($trvl_guid_id) && $trvl_guid_id!= "") {
																								?>
																									<a href="javascript:<?php echo "addNewPhoto('".$trvl_guid_id."')"; ?>;" class="add-photo">Add new picture</a>
																								<?php
																								} else {
																								?>
																									<a href="javascript:<?php echo "addNewPhotoTmp()"; ?>;" class="add-photo">Add new picture</a>
																								<?php
																								}
																							}
                                                                                        ?>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr><td colspan="2">&nbsp;</td></tr>
                                                                                </table>
                                                                                <?php
																				if(is_array($tvlguidImgInfoArr) && count($tvlguidImgInfoArr) > 0) {
																				
																					for($i = 1; $i < count($tvlguidImgInfoArr); $i++) {
																						$tvlguidPhotoId 		= $tvlguidImgInfoArr[$i]['photo_id'];
																						$tvlguidPhotoThumb 		= TVLGUID_IMAGES_THUMB168x127_PATH.$tvlguidImgInfoArr[$i]['photo_thumb'];
																						$tvlguidPhotoCaption	= $tvlguidImgInfoArr[$i]['photo_caption'];
																						$tvlguidPhotoBy			= $tvlguidImgInfoArr[$i]['photo_by'];
																						$tvlguidPhotoLink		= $tvlguidImgInfoArr[$i]['photo_link'];
																				?>
                                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                    <tr>
                                                                                        <td  valign="top" style="padding:0px;">
                                                                                            <table border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
                                                                                                <tr>
                                                                                                    <td>
                                                                                                    <img src="<?php echo $tvlguidPhotoThumb; ?>" name="PreviewImage0" width="199" height="149" class="photo-add" id="PreviewImage0" />
                                                                                                    </td>
                                                                                                    <td align="left" valign="top" class="pad-rgt10">
                                                                                                        <p style="float:left; font-size:12px; padding-top:15px;">
                                                                                                            <input type="hidden" name="txtTvlGuidPhotoId[]" id="txtTvlGuidPhotoId<?php echo $i; ?>" value="<?php echo $tvlguidPhotoId; ?>">
                                                                                                            <textarea name="txtTvlGuidPhotoCaption[]" id="txtTvlGuidPhotoCaptionId<?php echo $i; ?>" class="textArea260x60" onclick="return bnkTvlGuidImgCaption('<?php echo $i; ?>');" onblur="return restoreTvlGuidImgCaption('<?php echo $i; ?>');" ><?php echo $tvlguidPhotoCaption; ?></textarea>
                                                                                                            <div style=" padding-bottom:10px;">
                                                                                                            <input name="txtTvlGuidPhotoBy[]" id="txtTvlGuidPhotoById<?php echo $i; ?>" class="inpuTxt270" value="<?php if(isset($tvlguidPhotoBy) && $tvlguidPhotoBy !="") { echo $tvlguidPhotoBy;} else { echo "Photo by"; } ?>" type="text" onclick="return bnkTvlGuidPhotoBy('<?php echo $i; ?>');" onblur="return restoreTvlGuidPhotoBy('<?php echo $i; ?>');"  onkeydown="chkblnkTxtError('txtTvlGuidPhotoById<?php echo $i; ?>', 'photoError<?php echo $i; ?>');" onkeyup="chkblnkTxtError('txtTvlGuidPhotoById<?php echo $i; ?>', 'photoError<?php echo $i; ?>');" />
                                                                                                            </div>
                                                                                                            <input name="txtTvlGuidPhotoLink[]" id="txtTvlGuidPhotoLinkId<?php echo $i; ?>" class="inpuTxt270" value="<?php if(isset($tvlguidPhotoLink) && $tvlguidPhotoLink !="") { echo $tvlguidPhotoLink;} else { echo "http://"; } ?>" type="text" onclick="return bnkTvlGuidPhotoLink('<?php echo $i; ?>');" onblur="return restoreTvlGuidPhotoLink('<?php echo $i; ?>');"  onkeydown="chkblnkTxtError('txtTvlGuidPhotoLinkId<?php echo $i; ?>', 'photoError<?php echo $i; ?>');" onkeyup="chkblnkTxtError('txtTvlGuidPhotoLinkId<?php echo $i; ?>', 'photoError<?php echo $i; ?>');" />
                                                                                                        </p>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td colspan="2" class="pad-lft15">
																									<?php if(isset($tvlguidPhotoId) && $tvlguidPhotoId !="") {echo "<a href=\"JavaScript:delTvlGuidPhoto(".$tvlguidPhotoId.");\" class=\"delete-photo\">Remove picture</a>&nbsp;&nbsp;";} ?>
                                                                                                    <?php
                                                                                                        if($i == count($tvlguidImgInfoArr) - 1) {
                                                                                                            if(isset($trvl_guid_id) && $trvl_guid_id!= "") {
                                                                                                            ?>
                                                                                                                <a href="javascript:<?php echo "addNewPhoto('".$trvl_guid_id."')"; ?>;" class="add-photo">Add new picture</a>
                                                                                                            <?php
                                                                                                            } else {
                                                                                                            ?>
                                                                                                                <a href="javascript:<?php echo "addNewPhotoTmp()"; ?>;" class="add-photo">Add new picture</a>
                                                                                                            <?php
                                                                                                            }
                                                                                                        }
                                                                                                    ?>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr><td colspan="2">&nbsp;</td></tr>
                                                                                            </table>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                                <?php
																					}
																				}
																				?>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="2" align="right" valign="top" class="header">
                                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                    <tr>
                                                                                        <td align="right" valign="bottom" colspan="2">
                                                                                        	<?php 
																								if(isset($trvl_guid_id) && $trvl_guid_id!= "") {
																								?>
                                                                                                    <a href="javascript:<?php echo "showTvlGuidPreview('".$trvl_guid_id."')"; ?>;" style="text-decoration: none;"><img src="images/previewN.png" alt="Preview" border="0" height="21" width="71"></a>&nbsp;<a href="admin-collateral.php?sec=trvlguide" style="text-decoration: none;"><img src="images/cancelN.png" alt="Preview" border="0" height="21" width="66"></a>&nbsp;<a href="javascript:void(0);" onclick="frmValidateAddTvlGuid();" style="text-decoration:none;"><img src="images/saveChangesN.png" alt="Save Approve" width="108" height="21" border="0" /></a>
                                                                                                <?php
																								} else {
																								?>
                                                                                                    <a href="javascript:<?php echo "showTvlGuidTmpPreview()"; ?>;" style="text-decoration: none;"><img src="images/previewN.png" alt="Preview" border="0" height="21" width="71"></a>&nbsp;<a href="javascript:<?php echo "cancelAddTvlGuid('".$_REQUEST[PHPSESSID]."')"; ?>;" style="text-decoration: none;"><img src="images/cancelN.png" alt="Preview" border="0" height="21" width="66"></a>&nbsp;<a href="javascript:void(0);" onclick="frmAddTvlGuid4Later();" style="text-decoration:none;"><img src="images/saveLaterN.png" alt="Save for later" border="0" height="21" width="102"></a>&nbsp;<a href="javascript:void(0);" onclick="frmAddTvlGuidNApprove();" style="text-decoration:none;"><img src="images/saveApproveN.png" alt="Save & approve" border="0" height="21" width="117"></a>
                                                                                                <?php
																								}
																							?>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                </form>
                                <!-- main body : End here -->
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
	<?php
	break;
	}
} else {

	if(isset($_GET['sortby']) && $_GET['sortby'] != ""){
		$strQuery = " ORDER BY ";
		switch($_GET['sortby']){
			case 'tvlguidcat':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$tvlguidcatdr 			= 0;
					$tvlguidtitledr			= 1;
					$tvlguidfeatureddr 		= 1;
					$tvlguidupdatedatedr 	= 1;
					$tvlguidstatusdr 		= 1;
				}
				else{
					$dr = "DESC";
					$tvlguidcatdr 			= 1;
					$tvlguidtitledr			= 1;
					$tvlguidfeatureddr 		= 1;
					$tvlguidupdatedatedr 	= 1;
					$tvlguidstatusdr 		= 1;
				}
				$strQuery .= " A.trvl_guid_categories_id ".$dr;
			break;
			case 'tvlguidtitle':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$tvlguidcatdr 			= 1;
					$tvlguidtitledr			= 0;
					$tvlguidfeatureddr 		= 1;
					$tvlguidupdatedatedr 	= 1;
					$tvlguidstatusdr 		= 1;
				}
				else{
					$dr = "DESC";
					$tvlguidcatdr 			= 1;
					$tvlguidtitledr			= 1;
					$tvlguidfeatureddr 		= 1;
					$tvlguidupdatedatedr 	= 1;
					$tvlguidstatusdr 		= 1;
				}
				$strQuery .= " A.trvl_guid_title ".$dr;
			break;
			case 'tvlguidfeatured':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$tvlguidcatdr 			= 1;
					$tvlguidtitledr			= 1;
					$tvlguidfeatureddr 		= 0;
					$tvlguidupdatedatedr 	= 1;
					$tvlguidstatusdr 		= 1;
				}
				else{
					$dr = "DESC";
					$tvlguidcatdr 			= 1;
					$tvlguidtitledr			= 1;
					$tvlguidfeatureddr 		= 1;
					$tvlguidupdatedatedr 	= 1;
					$tvlguidstatusdr 		= 1;
				}
				$strQuery .= " A.featured ".$dr;
			break;
			case 'tvlguidupdatedate':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$tvlguidcatdr 			= 1;
					$tvlguidtitledr			= 1;
					$tvlguidfeatureddr 		= 1;
					$tvlguidupdatedatedr 	= 0;
					$tvlguidstatusdr 		= 1;
				}
				else{
					$dr = "DESC";
					$tvlguidcatdr 			= 1;
					$tvlguidtitledr			= 1;
					$tvlguidfeatureddr 		= 1;
					$tvlguidupdatedatedr 	= 1;
					$tvlguidstatusdr 		= 1;
				}
				$strQuery .= " A.updated_on ".$dr;
			break;
			case 'tvlguidstatus':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$tvlguidcatdr 			= 1;
					$tvlguidtitledr			= 1;
					$tvlguidfeatureddr 		= 1;
					$tvlguidupdatedatedr 	= 1;
					$tvlguidstatusdr 		= 0;
				}
				else{
					$dr = "DESC";
					$tvlguidcatdr 			= 1;
					$tvlguidtitledr			= 1;
					$tvlguidfeatureddr 		= 1;
					$tvlguidupdatedatedr 	= 1;
					$tvlguidstatusdr 		= 1;
				}
				$strQuery .= " A.status ".$dr;
			break;
		}
	} else {
		$tvlguidcatdr 			= 1;
		$tvlguidtitledr			= 1;
		$tvlguidfeatureddr 		= 1;
		$tvlguidupdatedatedr 	= 1;
		$tvlguidstatusdr 		= 1;
	}

	$tvlguidListArr = $tvlguidObj->fun_getCollateralTravelsArr($strQuery);
	//print_r($tvlguidListArr);
	if(count($tvlguidListArr) > 0){
	?>
	<?php /*?><script language="javascript" type="text/javascript">
        var req = ajaxFunction();
    
        function chkFeaturedTvlGuid(strCheckboxId){
            var tvlguidId = document.getElementById(strCheckboxId).value;
            
            if(document.getElementById(strCheckboxId).checked == true) {
                var url = "../tvlguidFeaturedXml.php?tvlguidid="+tvlguidId+"&featured=1";
            } else {
                var url = "../tvlguidFeaturedXml.php?tvlguidid="+tvlguidId+"&featured=0";
            }
            req.onreadystatechange = handleTvlGuidFeatureResponse;
            req.open("GET", url); 
            req.send(null);   
        }
    
        function handleTvlGuidFeatureResponse(){
            var arrayOfTvlGuidFeature 	= new Array();
            if(req.readyState == 4){
                var response=req.responseText;
                xmlDoc=req.responseXML;
                var root = xmlDoc.getElementsByTagName('tvlguids')[0];
                if(root != null){
                    var items = root.getElementsByTagName("tvlguid");
                    for (var i = 0 ; i < items.length ; i++){
                        var item 				= items[i];
                        var tvlguidfeature 		= item.getElementsByTagName("tvlguidfeature")[0].firstChild.nodeValue;
                        arrayOfTvlGuidFeature[i] 	= tvlguidfeature;
                        if(arrayOfTvlGuidFeature[i] == "Travel guide updated."){
                            window.location = 'admin-collateral.php?sec=trvlguide';
                        }
                    }
                }
            }
        }
    </script><?php */?>
    <script language="javascript" type="text/javascript">
		var req = ajaxFunction();
		var x, y;
		function toggleLayer(whichLayer){
            var output = document.getElementById(whichLayer).innerHTML;
            if(whichLayer == 'ANP-Example') {		
                output = '<div style="z-index:5;">'+output+'</div>';
                var googlewin=dhtmlwindow.open("Example", "inline", output, "", "width=295px,height=470px,resize=0,scrolling=0,center=1,xAxis="+x+",yAxis="+y+"", "recal");
            } else if(whichLayer == 'tvlguides-delete-pop') {		
                var x1 = x-150;
                var y1 = y-100;
                output = '<div style="z-index:5;">'+output+'</div>';
                var googlewin=dhtmlwindow.open("Example", "inline", output, "", "width=298px,height=160px,resize=1,scrolling=0,center=1,xAxis="+x1+",yAxis="+y1+"", "recal");
            }
        
            googlewin.onclose=function(){ //Run custom code when window is being closed (return false to cancel action):
                return true
            }
        }
        
        function closeWindow(){	
            document.getElementById("Example").style.display="none";
        }
        
        function closeWindowNRefresh(){
            document.getElementById("Example").style.display="none";
            window.location = location.href;
        }
		function delItem(strId) {
			document.getElementById("txtDelItem").value = strId;
		}
		
		function deltvlguidesItem(){
			closeWindow();
			if(document.getElementById("txtDelItem").value != "") {
				var trvl_guid_id = document.getElementById("txtDelItem").value;
				req.onreadystatechange = handleDeletetTravelGuidesResponse;
				req.open('get', 'includes/ajax/travelguidedeleteXml.php?trvl_guid_id='+trvl_guid_id); 
				req.send(null);   
			}
		}
		function handleDeletetTravelGuidesResponse(){
			if(req.readyState == 4){
				var response = req.responseText;
				xmlDoc = req.responseXML;
				var root = xmlDoc.getElementsByTagName('travelguides')[0];
				if(root != null){
					var items = root.getElementsByTagName("travelguide");
					for (var i = 0 ; i < items.length ; i++){
						var item 				= items[i];
						var travelguidestatus 		= item.getElementsByTagName("travelguidestatus")[0].firstChild.nodeValue;
						if(travelguidestatus == "travelguide deleted."){
							window.location = location.href;
						}
					}
				}
			}
		}
        </script>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
        <tr>
            <td valign="top" class="SectionSubHead"><?php echo $addtitle;?></td>
            <td>&nbsp;</td>
        </tr>
        <tr><td height="10" colspan="2" valign="top">&nbsp;</td></tr>
        <tr>
            <td valign="top"><a href="admin-collateral.php?sec=trvlguide&subsec=addcat" title="Add Travel Category"><img src="images/add-edit-category.png" width="140" height="22" alt="Add Category" /></a>&nbsp;<a href="admin-collateral.php?sec=trvlguide&subsec=addtvlguid" title="Add Resources"><img src="images/add-new-guide.png" alt="Add Travel Guide" width="122" height="22" /></a></td>
            <td align="right" valign="top">
            <input type="hidden" name="txtDelItem" id="txtDelItem" value="" />
                <form name="frmSearchTvl" id="frmSearchTvl" action="admin-collateral.php?sec=trvlguide" method="post">
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td class="blackTxt14 pad-rgt5">Search </td>
                        <td class="pad-rgt5"><input name="txtSearchTvlGuid" id="txtSearchTvlGuidId" type="text" class="Textfield210" value="Enter reference" onclick="return bnkTvlGuidSearch();" onblur="return restoreTvlGuidSearch();" autocomplete="off" /></td>
                        <td><a href="#"><img src="images/search-btn.gif" alt="Send"/></a></td>
                    </tr>
                </table>
                </form>
            </td>
        </tr>
        <tr><td  colspan="2" valign="top" class="blueBotBorder"><img src="images/spacer.gif" height="8" alt="One" /></td></tr>
        <tr>
            <td colspan="2" valign="top" class="pad-top15">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                <!--
                    <tr>
                        <td valign="top">
                            <table cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td class="paging pad-btm10 pad-left2" align="left" valign="top"><strong>357 Results</strong> </td>
                                    <td class="paging pad-btm10 pad-left2" align="right" valign="top"><a href="#" class="back">Previous</a><a href="#">1</a><a href="#">2</a><a href="#">3</a><span>4</span><a href="#">5</a><a href="#">6</a> ...<a href="#">23</a><a href="#" class="next">Next</a> </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                 -->
                    <tr>
                        <td valign="top" class="pad-top7">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EventListing">
                                <thead>
                                    <tr>
                                        <th width="25%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-collateral.php?sec=trvlguide&sortby=tvlguidcat&dr=".$tvlguidtitledr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "tvlguidcat")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?> ><div>Category</div></th>
                                        <th width="40%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-collateral.php?sec=trvlguide&sortby=tvlguidtitle&dr=".$tvlguidcatdr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "tvlguidtitle")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Title</div></th>
										<?php
										/*
										?>
                                        <th width="20%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-collateral.php?sec=trvlguide&sortby=tvlguidfeatured&dr=".$tvlguidfeatureddr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "tvlguidfeatured")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Top attraction</div></th>
										<?php
										*/
										?>
										<th width="20%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-collateral.php?sec=trvlguide&sortby=tvlguidupdatedate&dr=".$tvlguidupdatedatedr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "tvlguidupdatedate")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Last updated</div></th>
                                        <th width="15%" scope="col" class="right" onmouseover="this.className = 'rightOver';" onclick="sortList('<?php echo "admin-collateral.php?sec=trvlguide&sortby=tvlguidstatus&dr=".$tvlguidstatusdr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "tvlguidstatus")){echo "class=\"rightOver\" onmouseout=\"this.className = 'rightOver';\" ";}else{echo "onmouseout=\"this.className = 'right';\"";}?>><div>Status</div></th>
                                        <th width="10%" scope="col" class="right" onmouseover="this.className = 'rightOver';" ><div>Action</div></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                for($i=0; $i < count($tvlguidListArr); $i++){
                                $trvl_guid_id 				= $tvlguidListArr[$i]['trvl_guid_id'];
                                $trvl_guid_categories_id 	= $tvlguidListArr[$i]['trvl_guid_categories_id'];
                                $trvl_guid_title 			= $tvlguidListArr[$i]['trvl_guid_title'];
                                $status 					= $tvlguidListArr[$i]['status'];
                                $created_on 				= date('M d, Y', $tvlguidListArr[$i]['created_on']);
                                $updated_on 				= date('M d, Y', $tvlguidListArr[$i]['updated_on']);
                                $status_name 				= $tvlguidListArr[$i]['status_name'];
                                $featured					= $tvlguidListArr[$i]['featured'];
                                $active						= $tvlguidListArr[$i]['active'];
                                ?>
                                    <tr>
                                        <td class="left"><?php echo $tvlguidObj->fun_getTvlGuidCatNameByCatId($trvl_guid_categories_id); ?></td>
                                        <td><a href="admin-collateral.php?sec=trvlguide&subsec=edittvlguid&tvlguidid=<?php echo $trvl_guid_id;?>"><?php echo $trvl_guid_title;?></a></td>
										<?php
										/*
										?>
                                        <td align="center"><input type="checkbox" name="txtFeature[]" id="txtFeatureId<?php echo $i; ?>" value="<?php echo $trvl_guid_id;?>" <?php if($featured == "1"){ echo "checked"; }; ?> onclick="chkFeaturedTvlGuid('txtFeatureId<?php echo $i; ?>');" />
										</td>
										<?php
										*/
										?>
                                        <td><?php echo $updated_on;?></td>
                                        <td class="right"><?php echo ucfirst($status_name);?></td>
                                        <td class="right" align="center"><a href="javascript:delItem(<?php echo $trvl_guid_id ; ?>);toggleLayer('tvlguides-delete-pop');" class="removeText">Delete</a></td>
                                    </tr>
                                <?php
                                }
                                ?>
                                </tbody>
                            </table>
                                <div id="tvlguides-delete-pop" style="display:none; position:absolute; background:transparent; left:300px; top:500px;">
                                <div style="position:relative; z-index:999;left:0px;width:250px;height:170px;">
                                    <table width="230" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td align="right"><img src="<?php echo SITE_IMAGES;?>poplefttop.png" alt="ANP" height="10" width="10" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo SITE_IMAGES;?>poplefttop.png', sizingMethod='scale');" /></td>
                                            <td class="topp"></td>
                                            <td><img src="<?php echo SITE_IMAGES;?>poprighttop1.png" alt="ANP"  height="10" width="15" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo SITE_IMAGES;?>poprighttop1.png', sizingMethod='scale');"/></td>
                                        </tr>
                                        <tr>
                                            <td class="leftp"></td>
                                            <td width="220" align="left" valign="top" bgcolor="#FFFFFF" style="padding:12px;"> 
                                                <table width="220" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td align="left" valign="top" class="head"><span class="pink14arial">Are you sure?</span></td>
                                                        <td width="15" align="right" valign="top"><a href="javascript:closeWindow();void(0);" ><img src="<?php echo SITE_IMAGES;?>pop-up-cross.gif" alt="Close" title="Close" border="0" /></a></td>
                                                    </tr>
                                                    <tr>
                                                        <td  align="left" valign="top" class="PopTxt">
                                                            <table width="98%" border="0" cellpadding="0" cellspacing="0">
                                                                <tr>
                                                                    <td class="pad-rgt10 pad-top5"><strong>You will be delete this travel guides and not be restored!</strong></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="pad-top10">
                                                                        <div class="FloatLft"><a href="javascript:closeWindow();void(0);" ><img src="<?php echo SITE_IMAGES;?>cancel-admin.png" alt="Keep it" /></a></div>
                                                                        <div class="FloatLft pad-lft5"><a href="javascript:deltvlguidesItem();"><img src="<?php echo SITE_IMAGES;?>delete.gif" alt="Delete it" onmouseover="this.src='<?php echo SITE_IMAGES; ?>delete_h.gif'" onmouseout="this.src='<?php echo SITE_IMAGES; ?>delete.gif'" /></a></div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td  align="left" valign="top" class="PopTxt">&nbsp;</td>
                                                    </tr>
                                                </table>                               
                                            </td>
                                            <td class="rightp" width="15"></td>
                                        </tr>
                                        <tr>
                                            <td align="right"><img src="<?php echo SITE_IMAGES;?>popleftbtm.png" alt="ANP" /></td>
                                            <td width="270" class="bottomp"></td>
                                            <td align="left"><img src="<?php echo SITE_IMAGES;?>poprightbtm1.png" alt="ANP"/></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                        </td>
                    </tr>
                    <tr><td valign="top">&nbsp;</td></tr>
                    <!--
                    <tr>
                        <td valign="top">
                            <table cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td class="paging pad-btm10 pad-left2" align="left" valign="top"><strong>357 Results</strong> </td>
                                    <td class="paging pad-btm10 pad-left2" align="right" valign="top"><a href="#" class="back">Previous</a><a href="#">1</a><a href="#">2</a><a href="#">3</a><span>4</span><a href="#">5</a><a href="#">6</a> ...<a href="#">23</a><a href="#" class="next">Next</a> </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    -->
                </table>
            </td>
        </tr>
    </table>
	<?php
	} else {
	?>
    	
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
        <tr>
            <td valign="top" class="SectionSubHead"><?php echo $addtitle;?></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td height="10" colspan="2" valign="top">&nbsp;</td>
        </tr>
        <tr>
            <td valign="top"><a href="admin-collateral.php?sec=trvlguide&subsec=addcat" title="Add Travel Category"><img src="images/add-edit-category.png" width="140" height="22" alt="Add Category" /></a>&nbsp;<a href="admin-collateral.php?sec=trvlguide&subsec=addtvlguid" title="Add Travel Guide"><img src="images/add-new-guide.png" alt="Add Travel Guide" width="122" height="22" /></a></td>
            <td align="right" valign="top">&nbsp;</td>
        </tr>
        <tr>
            <td  colspan="2" valign="top" class="blueBotBorder"><img src="images/spacer.gif" height="8" alt="One" /></td>
        </tr>
        <tr>
            <td colspan="2" valign="top" class="pad-top15">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                    <tr>
                        <td valign="top">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td valign="top">No Travel Guide Added!</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
	<?php
	}
}
?>
