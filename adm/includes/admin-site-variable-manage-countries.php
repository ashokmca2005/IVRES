<?php
// Form submision
$form_array = array();
$errorMsg	= 'no';

if($_POST['securityKey']==md5(RESOURCEDELETE)){
	if(isset($_POST['txtResourceId']) && $_POST['txtResourceId'] != "") {
		$resource_id = $_POST['txtResourceId'];
		$resObj->fun_delResource($resource_id);
	}
	echo "<script> location.href='admin-pending-approval.php?sec=resource';</script>";
}

if($_POST['securityKey'] == md5(ADDRESOURCE)){
	if(isset($_POST['txtResourceId']) && $_POST['txtResourceId'] != "") {
		$resource_id 				= $_POST['txtResourceId'];
		if(trim($_POST['txtUserFName']) == '') {
			$form_array['txtUserFName'] = 'First Name required';
			$errorMsg = 'yes';
		}
		if(trim($_POST['txtUserLName']) == '') {		
			$form_array['txtUserLName'] = 'Last Name required';
			$errorMsg = 'yes';
		}
		if(trim($_POST['txtUserEmail']) == '') {
			$form_array['txtUserEmail'] = 'Please enter a valid email address';
			$errorMsg = 'yes';
		} else {
			if(preg_match(EMAIL_ID_REG_EXP_PATTERN, $_POST['txtUserEmail'])) {
				// Check if email already exist
				/*
				if($usersObj->fun_checkEmailAddress($_POST['txtUserEmail']) === true) {
					$form_array['txtUserEmail'] = 'Email address already exists';
					$errorMsg = 'yes';
				}
				*/
			} else {
				$form_array['txtUserEmail'] = 'Please enter a valid email address';
				$errorMsg = 'yes';
			}
		}

		if(trim($_POST['txtResourceCategory']) == '') {		
			$form_array['txtResourceCategory'] = 'Please select Resource category';
			$errorMsg = 'yes';
		}

		if((trim($_POST['txtResourceUrl']) == '') || (trim($_POST['txtResourceUrl']) == "http://")) {		
			$form_array['txtResourceUrl'] = 'Please enter resource link';
			$errorMsg = 'yes';
		}

		if(trim($_POST['txtResourceTitle']) == '') {
			$form_array['txtResourceTitle'] = 'Please enter resource title';
			$errorMsg = 'yes';
		}

		if(trim($_POST['txtResourceDesc']) == '') {
			$form_array['txtResourceDesc'] = 'Please enter resource description';
			$errorMsg = 'yes';
		}

		if((trim($_POST['txtResourceOLUrl']) == '') || (trim($_POST['txtResourceOLUrl']) == "http://")) {		
			$form_array['txtResourceOLUrl'] = 'Please enter UniqueSleeps link';
			$errorMsg = 'yes';
		}

		if(($errorMsg == 'no') && ($errorMsg != 'yes')){		
			// add resources
			$txtUserFName 			= trim($_POST['txtUserFName']);
			$txtUserLName 			= trim($_POST['txtUserLName']);
			$txtUserEmail 			= trim($_POST['txtUserEmail']);
			$txtResourceCategory	= trim($_POST['txtResourceCategory']);
			$txtArea				= trim($_POST['txtArea']);
			$txtRegion				= trim($_POST['txtRegion']);
			$txtSubRegion			= trim($_POST['txtSubRegion']);
			$txtLocation			= trim($_POST['txtLocation']);
			$txtResourceUrl			= trim($_POST['txtResourceUrl']);
			$txtResourceTitle		= trim($_POST['txtResourceTitle']);
			$txtResourceDesc		= trim($_POST['txtResourceDesc']);
			$txtResourceOLUrl		= trim($_POST['txtResourceOLUrl']);
			$resource_id			= $resObj->fun_editResource($resource_id, $txtResourceCategory, $txtResourceTitle, $txtResourceDesc, $txtArea, $txtRegion, $txtSubRegion, $txtLocation, $txtResourceUrl, $txtResourceOLUrl);
			echo "<script>location.href = window.location;</script>";
		} else {
			$form_array['error_msg'] = "Please submit form again";
		}
	}
}

if(isset($resource_id) && $resource_id !=""){
$resourceInfoArr = $resObj->fun_getResourceInfo($resource_id);
if(is_array($resourceInfoArr) && count($resourceInfoArr) > 0) {
	$resourceUserInfoArr = $resObj->fun_getResourceUserInfo($resource_id);
//	print_r($resourceUserInfoArr);
	$txtUserFName 			= $resourceUserInfoArr['user_fname'];
	$txtUserLName 			= $resourceUserInfoArr['user_lname'];
	$txtUserEmail 			= $resourceUserInfoArr['user_email'];

	$txtResourceCategory	= $resourceInfoArr['resource_cat_ids'];
	$txtArea				= $resourceInfoArr['resource_area_id'];
	$txtRegion				= $resourceInfoArr['resource_region_id'];
	$txtSubRegion			= $resourceInfoArr['resource_sub_region_id'];
	$txtLocation			= $resourceInfoArr['resource_location_id'];
	$txtResourceUrl			= $resourceInfoArr['resource_link'];
	$txtResourceTitle		= fun_db_output($resourceInfoArr['resource_name']);
	$txtResourceDesc		= fun_db_output($resourceInfoArr['resource_description']);
	$txtResourceOLUrl		= $resourceInfoArr['resource_ol_link'];

}
//print_r($resourceInfoArr);
?>
<!-- TinyMCE -->
<script type="text/javascript" src="../tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		mode : "exact",
		elements : "txtResourceDescId",
		handle_resource_callback : "myHandleEvent",
		theme : "simple",
		plugins : 'advlink,advimage',
		relative_urls : false,
		remove_script_host : false
	});

	//resource such as key or mouse press
	function myHandleEvent(e){
		if(e.type=="keyup"){
			chkblnkEditorTxtError("txtResourceDescId", "txtResourceDescErrorId");	
		}
		return true;
	}
</script>
<!-- /TinyMCE -->
<script language="javascript" type="text/javascript">
	var req = ajaxFunction();
	var x1 = "";
	var y1 = "";

	function chkblnkTxtError(strFieldId, strErrorFieldId) {
		if(document.getElementById(strFieldId).value != "") {
			document.getElementById(strErrorFieldId).innerHTML = "";
		}
	}

/*
* For Add resource section : Start here
*/
	function chkSelectArea() {
		var getID=document.getElementById("txtAreaId").value;
		if(getID !="" && getID != "0"){
			sendRegionRequest(getID);
			document.getElementById("txtRegionId").value = "0";
			document.getElementById("txtSubRegionId").value = "0";
			document.getElementById("txtLocationId").value = "0";
		}
		if(getID == "0" || getID =="") {
			document.getElementById("txtAreaId").value = "0";
			document.getElementById("txtRegionId").value = "0";
			document.getElementById("txtSubRegionId").value = "0";
			document.getElementById("txtLocationId").value = "0";
			document.getElementById("txtSubRegionId").style.display = "none";
			document.getElementById("txtLocationId").style.display = "none";
		}
	}
	
	function chkSelectRegion() {
		var getID=document.getElementById("txtRegionId").value;
		if(getID !="" && getID != "0"){
			sendSubRegionRequest(getID);
			document.getElementById("txtSubRegionId").value = "0";
			document.getElementById("txtLocationId").value = "0";
		}
		if(getID == "0" || getID =="") {
			document.getElementById("txtRegionId").value = "0";
			document.getElementById("txtSubRegionId").value = "0";
			document.getElementById("txtLocationId").value = "0";
			document.getElementById("txtSubRegionId").style.display = "none";
			document.getElementById("txtLocationId").style.display = "none";
		}
	}
	
	function chkSelectSubRegion() {
		var getID=document.getElementById("txtSubRegionId").value;
		if(getID !="" && getID != "0"){
			sendLocationRequest(getID);
			document.getElementById("txtLocationId").value = "0";
		}
		if(getID == "0" || getID =="") {
			document.getElementById("txtSubRegionId").value = "0";
			document.getElementById("txtLocationId").value = "0";
			document.getElementById("txtLocationId").style.display = "none";
		}
	}

	function chkSelectLocation() {
		var getID=document.getElementById("txtLocationId").value;
		if(getID !="" && getID != "0"){
		}
		if(getID == "0" || getID =="") {
			document.getElementById("txtLocationId").value = "0";
		}
	}	

	function sendAreaRequest(id) { 
		req.open('get', '../selectAreaXml.php?id=' + id); 
		req.onreadystatechange = handleAreaResponse; 
		req.send(null); 
	} 
	
	function sendRegionRequest(id) { 
		req.open('get', '../selectRegionXml.php?id=' + id); 
		req.onreadystatechange = handleRegionResponse; 
		req.send(null); 
	} 
	
	function sendSubRegionRequest(id) { 
		req.open('get', '../selectSubRegionXml.php?id=' + id); 
		req.onreadystatechange = handleSubRegionResponse; 
		req.send(null); 
	} 
	
	function sendLocationRequest(id) { 
		req.open('get', '../selectLocationXml.php?id=' + id); 
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
				document.getElementById("txtAreaId").style.display = "block";
				document.getElementById("txtRegionId").style.display = "none";
				document.getElementById("txtSubRegionId").style.display = "none";
				document.getElementById("txtLocationId").style.display = "none";
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
					var p_city=document.getElementById("txtAreaId");
					p_city.length=0;
					p_city.options[0]=new Option("Please Select...","");
					for(var j=0; j<arrayOfId.length; j++) {
						p_city.options[j+1]=new Option(arrayOfNames[j], arrayOfId[j]);
					}
				} else {
					document.getElementById("txtAreaId").style.display = "none";
				}
			} else {
				document.getElementById("txtAreaId").style.display = "none";
				document.getElementById("txtRegionId").style.display = "none";
				document.getElementById("txtSubRegionId").style.display = "none";
				document.getElementById("txtLocationId").style.display = "none";
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
				document.getElementById("txtRegionId").style.display = "block";
				document.getElementById("txtSubRegionId").style.display = "none";
				document.getElementById("txtLocationId").style.display = "none";
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

					var p_city=document.getElementById("txtRegionId");

					p_city.length=0;
					p_city.options[0]=new Option("All Areas ...","0");
					for(var j=0; j<arrayOfId.length; j++) {
						p_city.options[j+1]=new Option(arrayOfNames[j],arrayOfId[j]);
					}
//					sendSubRegionRequest(1);
				} else {
					document.getElementById("txtRegionId").style.display = "none";
	//				sendLocationRequest(document.getElementById("txtRegionId").value);
				}
			} else {
				document.getElementById("txtRegionId").style.display = "none";
				document.getElementById("txtSubRegionId").style.display = "none";
				document.getElementById("txtLocationId").style.display = "none";
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
				document.getElementById("txtSubRegionId").style.display = "block";
				document.getElementById("txtLocationId").style.display = "none";
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
					var p_city=document.getElementById("txtSubRegionId");
					p_city.length=0;
					p_city.options[0]=new Option("All Areas ...", "0");
					for(var j=0; j<arrayOfId.length; j++) {
						p_city.options[j+1]=new Option(arrayOfNames[j], arrayOfId[j]);
					}

//					sendLocationRequest(9);
				} else {
					document.getElementById("txtSubRegionId").style.display = "none";
					sendLocationRequest(document.getElementById("txtRegionId").value);
				}
			} else {
				document.getElementById("txtSubRegionId").style.display = "none";
				document.getElementById("txtLocationId").style.display = "none";
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
				document.getElementById("txtLocationId").style.display = "block";
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

					var p_city=document.getElementById("txtLocationId");
					p_city.length=0;
					p_city.options[0]=new Option("All Areas ...","0");

					for(var j=0; j<arrayOfId.length; j++) {
						p_city.options[j+1]=new Option(arrayOfNames[j], arrayOfId[j]);
					}

				} else {
					document.getElementById("txtLocationId").style.display = "none";
				}
			} else {
				document.getElementById("txtLocationId").style.display = "none";
			}
		} 
	}

	function showEventPreview(strEventCode) {
/*
		var newWin = window.open("admin-resource-preview.php?rsid="+ strEventCode +"","HTML",'dependent=1,toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,top=50,left=50,width=500,height=800');
		newWin.window.focus();
*/
	}
/*
* For Add resource section : Start here
*/
/*
* For resource pending - approval section : Start here
*/
	function sbmtResourceApproval(strId){
		var strId = strId;
		req.open('get', 'includes/ajax/admin-resource-pending-approvalXml.php?rsid=' + strId + '&mode=approve'); 
		req.onreadystatechange = handleApprovalResponse; 
		req.send(null); 
	}

	function sbmtResourceDecline(strId){
		document.getElementById("showDeclineReasonId").style.display = "block";
		var strId = strId;
		req.open('get', 'includes/ajax/admin-resource-pending-approvalXml.php?rsid=' + strId + '&mode=decline'); 
		req.onreadystatechange = handleApprovalResponse; 
		req.send(null); 
	}

	function sbmtResourceSuspend(strId){
		var strId = strId;
		req.open('get', 'includes/ajax/admin-resource-pending-approvalXml.php?rsid=' + strId + '&mode=suspend'); 
		req.onreadystatechange = handleApprovalResponse; 
		req.send(null); 
	}

	function sbmtEvntDelete(){
		
		document.getElementById("securityKey").value = "<?php echo md5('RESOURCEDELETE')?>";
		document.frm.submit();
/*
		var strId = strId;
		req.open('get', 'includes/ajax/admin-resource-pending-approvalXml.php?rsid=' + strId + '&mode=suspend'); 
		req.onreadystatechange = handleApprovalResponse; 
		req.send(null); 
*/
	}

	function handleApprovalResponse() { 
		if(req.readyState == 4){ 
			var response = req.responseText; 
			xmlDoc=req.responseXML;
			var root = xmlDoc.getElementsByTagName('resources')[0];
			if(root != null){
				var items = root.getElementsByTagName("resource");
				var item = items[0];
				var resourcestatus = item.getElementsByTagName("resourcestatus")[0].firstChild.nodeValue;
				if(resourcestatus == "Approved"){
					document.getElementById("txtAdminOptionId").innerHTML 	= "<font color='#FFFFFF' size='2'><strong>"+resourcestatus+"</strong></font>";
				}
				else if(resourcestatus == "Declined"){
					document.getElementById("txtAdminOptionId").innerHTML 	= "<font color='#FFFFFF' size='2'><strong>"+resourcestatus+"</strong></font>";
				}
				else if(resourcestatus == "Suspended"){
					document.getElementById("txtAdminOptionId").innerHTML 	= "<font color='#FFFFFF' size='2'><strong>"+resourcestatus+"</strong></font>";
				}
				else{
					document.getElementById("txtAdminOptionId").innerHTML 	= "<font color='#FFFFFF' size='2'><strong>Error, try later!</strong></font>";
				}
			} else {
				document.getElementById("txtAdminOptionId").innerHTML 	= "<font color='#FFFFFF' size='2'><strong>Error, try later!</strong></font>";
			}
		} else {
			document.getElementById("txtAdminOptionId").innerHTML 	= "<font color='#FFFFFF' size='2'><strong>Please wait...</strong></font>";
		}
	} 
/*
* For resource pending - approval section : End here
*/

	function frmValidate() {
        document.frmAddResource.submit();
	}
</script>
<form name="frmAddResource" id="frmAddResource" action="admin-pending-approval.php?sec=resource&rsid=<?php echo $resourceInfoArr['resource_id']; ?>" method="post">
<input type="hidden" name="securityKey" id="securityKey" value="<?php echo md5("ADDRESOURCE")?>">
<input type="hidden" name="txtResourceId" id="txtResourceId" value="<?php echo $resourceInfoArr['resource_id']; ?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr><td height="10" colspan="2" valign="top">&nbsp;</td></tr>
    <tr>
        <td valign="top"><a href="admin-pending-approval.php?sec=resource" class="back">Back to List</a></td>
        <td align="right" valign="top">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2" valign="top" class="pad-top5">
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
                                                    <tr>
                                                        <td>
														<div id="txtAdminOptionId">
														<?php 
															if($resourceInfoArr['status'] == "0" || $resourceInfoArr['status'] == "1" || $resourceInfoArr['status'] == "3" || $resourceInfoArr['status'] == "4") {
														?>
															<a href="javascript:showField('txtshwRjctTblId');" style="text-decoration:none;"><img src="images/rejectN.png" alt="Delete" width="71" height="21" border="0" /></a>&nbsp;<a href="javascript:sbmtResourceApproval(<?php echo $resource_id; ?>);" style="text-decoration:none;"><img src="images/approveN.png" alt="Approve" width="71" height="21" border="0" /></a>
														<?php
															} else {
														?>
															<a href="javascript:sbmtEvntDelete();" style="text-decoration:none;"><img src="images/DeleteN.png" alt="Delete" width="60" height="21" /></a>&nbsp;<a href="javascript:sbmtResourceSuspend(<?php echo $resource_id; ?>);" style="text-decoration:none;"><img src="images/suspendN.png" alt="Suspend" width="74" height="21" /></a>
														<?php
															}
														?>
														</div>
														</td>
<!--                                                        <td align="right" valign="bottom"><img src="images/previousN.png" alt="Preview" width="74" height="21" /> <img src="images/nextN.png" alt="Cancel" width="48" height="21" /></td>
-->                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" valign="top" style="padding:0px;">
												<table width="100%" border="0" cellspacing="0" cellpadding="2" bgcolor="#f5f5f5" id="txtshwRjctTblId" style="display:none;">
													<tr><td colspan="2" class="blackTxt14 pad-btm10 pad-lft10">Reason for rejection</td></tr>
													<tr>
														<td width="15" class="pad-lft10"><input name="checkbox" type="checkbox" class="checkbox" id="checkbox" /></td>
														<td>Inappropriate content for our site</td>
													</tr>
													<tr>
														<td width="15"  class="pad-lft10"><input name="checkbox" type="checkbox" class="checkbox" id="checkbox" /></td>
														<td>Inappropriate picture</td>
													</tr>
													<tr>
														<td width="15" class="pad-lft10"><input name="checkbox" type="checkbox" class="checkbox" id="checkbox" /></td>
														<td>Picture quality and/or cropping is of poor quality</td>
													</tr>
													<tr>
														<td width="15" class="pad-lft10"><input name="checkbox" type="checkbox" class="checkbox" id="checkbox" /></td>
														<td>Information is confusing / dosen't make sense</td>
													</tr>
													<tr>
														<td width="15"  class="pad-lft10"><input name="checkbox" type="checkbox" class="checkbox" id="checkbox" /></td>
														<td>
															<span class="FloatLft">Other, specify reason...</span>
															<span class="FloatLft pad-left12"><input name="users_first_name" class="inpuTxt510" value="Pick and Pay cycle Tour" type="text" /></span>														</td>
													</tr>
													<tr>
														<td colspan="2" class="pad-top10 pad-lft10">
															<a href="javascript:hideField('txtshwRjctTblId');" style="text-decoration:none;"><img src="images/cancelN.png" alt="Cancel" width="66" height="21" /></a>&nbsp;<img src="images/send.png" alt="Cancel" width="66" height="21" />														</td>
													</tr>
												</table>
											</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" align="right" valign="top" class="header">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td>Resource ID : <?php echo fill_zero_left($resourceInfoArr['resource_id'], "0", (6-strlen($resourceInfoArr['resource_id']))); ?></td>
                                                        <td align="right" valign="bottom"><!-- <a href="javascript: showResourcePreview(<?php //echo $resourceInfoArr['resource_id']; ?>);" style="text-decoration:none;"><img src="images/previewN.png" alt="Preview" width="71" height="21" border="0" /></a> -->&nbsp;<a href="admin-pending-approval.php?sec=resource" style="text-decoration:none;"><img src="images/cancelChangesN.png" alt="Cancel" width="119" height="21" border="0" /></a>&nbsp;<a href="javascript:void(0);" onclick="frmValidate();" style="text-decoration:none;"><img src="images/saveChangesN.png" alt="Save Approve" width="108" height="21" border="0" /></a></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="23"  align="right" valign="top" class="admleftBg">First name</td>
                                            <td  valign="top"><input name="txtUserFName" type="text" class="inpuTxt260" id="txtUserFNameId" value="<?php if(isset($_POST['txtUserFName'])){echo $_POST['txtUserFName'];}else{echo $txtUserFName;}?>" onkeydown="chkblnkTxtError('txtUserFNameId', 'showErrorUserFNameId');" onkeyup="chkblnkTxtError('txtUserFNameId', 'showErrorUserFNameId');" /><span class="pdError1 pad-lft10" id="showErrorUserFNameId"><?php if(array_key_exists('txtUserFName', $form_array)) echo $form_array['txtUserFName'];?></span></td>
                                        </tr>
                                        <tr>
                                            <td height="23"  align="right" valign="top" class="admleftBg">Last name</td>
                                            <td  valign="top"><input name="txtUserLName" type="text" class="inpuTxt260" id="txtUserLNameId" value="<?php if(isset($_POST['txtUserFName'])){echo $_POST['txtUserFName'];}else{echo $txtUserLName;}?>" onkeydown="chkblnkTxtError('txtUserLNameId', 'showErrorUserLNameId');" onkeyup="chkblnkTxtError('txtUserLNameId', 'showErrorUserLNameId');" /><span class="pdError1 pad-lft10" id="showErrorUserLNameId"><?php if(array_key_exists('txtUserLName', $form_array)) echo $form_array['txtUserLName'];?></span></td>
                                        </tr>
                                        <tr>
                                            <td height="23"  align="right" valign="top" class="admleftBg">Email address</td>
                                            <td  valign="top"><input name="txtUserEmail" type="text" class="inpuTxt260" id="txtUserEmailId" value="<?php if(isset($_POST['txtUserEmail'])){echo $_POST['txtUserEmail'];}else{echo $txtUserEmail;}?>" onkeydown="chkblnkTxtError('txtUserEmailId', 'showErrorUserEmailId');" onkeyup="chkblnkTxtError('txtUserEmailId', 'showErrorUserEmailId');" /><span class="pdError1 pad-lft10" id="showErrorUserEmailId"><?php if(array_key_exists('txtUserEmail', $form_array)) echo $form_array['txtUserEmail'];?></span></td>
                                        </tr>
                                        <tr>
                                            <td height="23"  align="right" valign="top" class="admleftBg">Choose a category</td>
                                            <td  valign="top">
                                                <select name="txtResourceCategory" class="select230">
                                                    <option value="" disabled="disabled" selected="selected">Select ...</option>
                                                    <?php 
                                                    if(isset($_POST['txtResourceCategory'])){
                                                        $resources_categories_id = $_POST['txtResourceCategory'];
                                                    } else if(isset($txtResourceCategory) && $txtResourceCategory != ""){
                                                        $resources_categories_id = $txtResourceCategory;
                                                    }
                                                    $resObj->fun_getResourcesCatListOptions($resources_categories_id);
                                                    ?>
                                                </select>                    
                                                <span class="pdError1 pad-lft10" id="showErrorResourceCategory">
                                                    <?php 
                                                    if(array_key_exists('txtResourceCategory', $form_array)) { 
                                                        echo $form_array['txtResourceCategory'];
                                                    }
                                                    ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="190" height="23" align="right" valign="top" class="admleftBg">Your resource would be ideal for people visiting which location</td>
                                            <td  valign="top">
                                            <div id="showtxtlocationcombo">
                                            <?php
                                                if(isset($resourceInfoArr['resource_area_id']) && ($resourceInfoArr['resource_area_id'] != "" || $resourceInfoArr['resource_area_id'] != "0")) {
                                                    $resource_area_id = $resourceInfoArr['resource_area_id'];
                                                    ?>
                                                    <select name="txtArea" id="txtAreaId" onchange="return chkSelectArea();" style="display:block;" class="select216">
                                                        <?php 
                                                            $locationObj->fun_getAreaListOptions($resource_area_id, '193');
                                                        ?>
                                                    </select>
                                                    <?php
                                                    if(isset($resourceInfoArr['resource_region_id']) && ($resourceInfoArr['resource_region_id'] != "0" || $resourceInfoArr['resource_region_id'] != "")) {
                                                        $resource_region_id = $resourceInfoArr['resource_region_id'];
                                                    ?>
                                                    <select name="txtRegion" id="txtRegionId" onchange="return chkSelectRegion();" style="display:block;" class="select216">
                                                        <option value="0">All Areas ...</option>
                                                        <?php 
                                                            $locationObj->fun_getRegionListOptions($resource_region_id, '0', $resource_area_id);
                                                        ?>
                                                    </select>
                                                    <?php
                                                        if(isset($resourceInfoArr['resource_sub_region_id']) && ($resourceInfoArr['resource_sub_region_id'] != "0") && ($resourceInfoArr['resource_sub_region_id'] != "")) {
                                                            $resource_sub_region_id = $resourceInfoArr['resource_sub_region_id'];
                                                            ?>
                                                            <select name="txtSubRegion" id="txtSubRegionId" onchange="return chkSelectSubRegion();" style="display:block;" class="select216">
                                                                <option value="0">All Areas ...</option>
                                                                <?php 
                                                                    $locationObj->fun_getRegionListOptions($resource_sub_region_id, $resource_region_id, $resource_area_id);
                                                                ?>
                                                            </select>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <select name="txtSubRegion" id="txtSubRegionId" onchange="return chkSelectSubRegion();" style="display:<?php if(($resource_region_id !="" && $resource_region_id > 0) && (!isset($resourceInfoArr['resource_location_id']) || ($resourceInfoArr['resource_location_id'] == "0") || ($resourceInfoArr['resource_location_id'] == "")) && ($locationObj->fun_countSubRegionByRegionid($resource_region_id) > 0)){echo "block";} else {echo "none";} ?>;" class="select216">
                                                                <option value="0">All Areas ...</option>
                                                                <?php 
                                                                if(($resource_region_id !="" && $resource_region_id > 0) && (!isset($resourceInfoArr['resource_location_id']) || ($resourceInfoArr['resource_location_id'] == "0") || ($resourceInfoArr['resource_location_id'] == ""))){
                                                                    $locationObj->fun_getRegionListOptions('', $resource_region_id, $resource_area_id);
                                                                }
                                                                ?>
                                                            </select>
                                                            <?php
                                                        }
                                                        if(isset($resourceInfoArr['resource_location_id']) && ($resourceInfoArr['resource_location_id'] != "0") && ($resourceInfoArr['resource_location_id'] != "")) {
                                                            $resource_location_id = $resourceInfoArr['resource_location_id'];
                                                            ?>
                                                            <select name="txtLocation" id="txtLocationId" onchange="return chkSelectLocation();" style="display:block;" class="select216">
                                                                <option value="0">All Areas ...</option>
                                                                <?php
                                                                    $locationObj->fun_getLocationListOptions($resource_location_id);
                                                                ?>
                                                            </select>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <select name="txtLocation" id="txtLocationId" onchange="return chkSelectLocation();" style="display:<?php if(((!isset($resource_sub_region_id) || ($resource_sub_region_id =="0")) && ($resource_region_id !="") && ($resource_region_id > 0) && ($locationObj->fun_countLocationsByRegionid($resource_region_id) > 0)) || (($resource_sub_region_id !="") && ($resource_sub_region_id > 0) && ($locationObj->fun_countLocationsByRegionid($resource_sub_region_id) > 0))){echo "block";} else {echo "none";} ?>;" class="select216">
                                                                <option value="0">All Areas ...</option>
                                                                <?php
                                                                if(($resource_sub_region_id !="") && ($resource_sub_region_id > 0) && ($locationObj->fun_countLocationsByRegionid($resource_sub_region_id) > 0)) {
                                                                    $locationObj->fun_getLocationListOptions('', $resource_sub_region_id);
                                                                } else if(($resource_region_id !="") && ($resource_region_id > 0) && ($locationObj->fun_countLocationsByRegionid($resource_region_id) > 0)) {
                                                                    $locationObj->fun_getLocationListOptions('', $resource_region_id);
                                                                }
                                                                ?>
                                                            </select>
                                                            <?php
                                                        }
                                                    }
                                                }
                                            ?>
                                            </div>
                                            <span class="pdError1" id="txtLocationErrorId"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="23"  align="right" valign="top" class="admleftBg">Where do you want your resource to link to?</td>
                                            <td  valign="top"><input name="txtResourceUrl" type="text" class="inpuTxt260" id="txtResourceUrlId" value="<?php if(isset($_POST['txtResourceUrl'])){echo $_POST['txtResourceUrl'];}else{echo $txtResourceUrl;}?>" onkeydown="chkblnkTxtError('txtResourceUrlId', 'showErrorUserFNameId');" onkeyup="chkblnkTxtError('txtResourceUrlId', 'showErrorUserFNameId');" /><span class="pdError1 pad-lft10" id="showErrorResourceUrlId"><?php if(array_key_exists('txtResourceUrl', $form_array)) echo $form_array['txtResourceUrl'];?></span></td>
                                        </tr>
                                        <tr>
                                            <td height="23"  align="right" valign="top" class="admleftBg">Title of your link</td>
                                            <td  valign="top"><input name="txtResourceTitle" type="text" class="inpuTxt260" id="txtResourceTitleId" value="<?php if(isset($_POST['txtResourceTitle'])){echo $_POST['txtResourceTitle'];}else{echo $txtResourceTitle;}?>" onkeydown="chkblnkTxtError('txtResourceTitleId', 'showErrorResourceTitleId');" onkeyup="chkblnkTxtError('txtResourceTitleId', 'showErrorResourceTitleId');" /><span class="pdError1 pad-lft10" id="showErrorResourceTitleId"><?php if(array_key_exists('txtResourceTitle', $form_array)) echo $form_array['txtResourceTitle'];?></span></td>
                                        </tr>
                                        <tr>
                                            <td height="23" align="right" valign="top" class="admleftBg">Description</td>
                                            <td  valign="top">
                                                <textarea name="txtResourceDesc" id="txtResourceDescId" class="textArea460" onkeydown="chkblnkTxtError('txtResourceDescId', 'txtResourceDescErrorId');" onkeyup="chkblnkTxtError('txtResourceDescId', 'txtResourceDescErrorId');" ><?php echo $txtResourceDesc; ?></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="23" align="right" valign="top" class="admleftBg">&nbsp;</td>
                                            <td  valign="top">
                                                <span class="pdError1" id="txtResourceDescErrorId"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="23"  align="right" valign="top" class="admleftBg">Where will our link appear on your website</td>
                                            <td  valign="top"><input name="txtResourceOLUrl" type="text" class="inpuTxt260" id="txtResourceOLUrlId" value="<?php if(isset($_POST['txtResourceOLUrl'])){echo $_POST['txtResourceOLUrl'];}else{echo $txtResourceOLUrl;}?>" onkeydown="chkblnkTxtError('txtResourceOLUrlId', 'showErrorResourceOLUrlId');" onkeyup="chkblnkTxtError('txtResourceOLUrlId', 'showErrorResourceOLUrlId');" /><span class="pdError1 pad-lft10" id="showErrorResourceOLUrlId"><?php if(array_key_exists('txtResourceOLUrl', $form_array)) echo $form_array['txtResourceOLUrl'];?></span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" align="right" valign="top" class="header">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td>Resource ID : <?php echo fill_zero_left($resource_id, "0", (6-strlen($resource_id))); ?></td>
                                                        <td align="right" valign="bottom"><!-- <a href="javascript: showResourcePreview(<?php //echo $resourceInfoArr['resource_id']; ?>);" style="text-decoration:none;"><img src="images/previewN.png" alt="Preview" width="71" height="21" border="0" /></a> -->&nbsp;<a href="admin-pending-approval.php?sec=resource" style="text-decoration:none;"><img src="images/cancelChangesN.png" alt="Cancel" width="119" height="21" border="0" /></a>&nbsp;<a href="javascript:void(0);" onclick="frmValidate();" style="text-decoration:none;"><img src="images/saveChangesN.png" alt="Save Approve" width="108" height="21" border="0" /></a></td>
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
                <tr><td valign="top">&nbsp;</td></tr>
                <tr><td valign="top">&nbsp;</td></tr>
            </table>
        </td>
    </tr>
</table>
</form>

<?php
} else {
	if(isset($_GET['sortby']) && $_GET['sortby'] != ""){
		$strQuery = " ORDER BY ";
		switch($_GET['sortby']){
			case 'countrycode':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$countrycodedr 	= 0;
					$countrynamedr 	= 1;
					$countryisodr	= 1;
					$countryisddr 	= 1;
				}
				else{
					$dr = "DESC";
					$countrycodedr 	= 1;
					$countrynamedr 	= 1;
					$countryisodr	= 1;
					$countryisddr 	= 1;
				}
				$strQuery .= " A.countries_id ".$dr;
			break;
			case 'countryname':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$countrycodedr 	= 1;
					$countrynamedr 	= 0;
					$countryisodr	= 1;
					$countryisddr 	= 1;
				}
				else{
					$dr = "DESC";
					$countrycodedr 	= 1;
					$countrynamedr 	= 1;
					$countryisodr	= 1;
					$countryisddr 	= 1;
				}
				$strQuery .= " A.countries_name ".$dr;
			break;
			case 'countryiso':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$countrycodedr 	= 1;
					$countrynamedr 	= 1;
					$countryisodr	= 0;
					$countryisddr 	= 1;
				}
				else{
					$dr = "DESC";
					$countrycodedr 	= 1;
					$countrynamedr 	= 1;
					$countryisodr	= 1;
					$countryisddr 	= 1;
				}
				$strQuery .= " A.countries_iso_code_3 ".$dr;
			break;
			case 'countryisd':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$countrycodedr 	= 1;
					$countrynamedr 	= 1;
					$countryisodr	= 1;
					$countryisddr 	= 0;
				}
				else{
					$dr = "DESC";
					$countrycodedr 	= 1;
					$countrynamedr 	= 1;
					$countryisodr	= 1;
					$countryisddr 	= 1;
				}
				$strQuery .= " A.countries_isd_code ".$dr;
			break;
		}
	}
	else{
		$countrycodedr 	= 1;
		$countrynamedr 	= 1;
		$countryisodr	= 1;
		$countryisddr 	= 1;
	}
//echo $strQuery;
	$countryListArr = $locationObj->fun_getCountryListArr($strQuery);
//	print_r($countryListArr);
	if(count($countryListArr) > 0){
	?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr><td colspan="2" valign="top">&nbsp;</td></tr>
			<tr>
				<td colspan="2" valign="top">
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EventListing">
						<thead>
							<tr>
								<th width="10%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=resource&sortby=countrycode&dr=".$countrycodedr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "countrycode")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?> ><div>ID</div></th>
								<th width="25%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=resource&sortby=countryname&dr=".$countrynamedr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "countryname")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?> ><div>Country name</div></th>
								<th width="35%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=resource&sortby=countryiso&dr=".$countryisodr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "countryiso")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>ISO code</div></th>
								<th width="30%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=resource&sortby=countryisd&dr=".$countryisddr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "countryisd")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>ISD code</div></th>
							</tr>
						</thead>
						<tbody>
							<?php
                            for($i=0; $i < count($countryListArr); $i++){
								$countries_id 			= $countryListArr[$i]['countries_id'];
								$countries_name 		= $countryListArr[$i]['countries_name'];
								$countries_iso_code_3 	= $countryListArr[$i]['countries_iso_code_3'];
								$countries_isd_code 	= $countryListArr[$i]['countries_isd_code'];
                            ?>
                                <tr>
                                    <td class="left"><a href="admin-pending-approval.php?sec=resource&countryid=<?php echo $countries_id;?>"><?php echo $countries_id;?></a></td>
                                    <td><?php echo $countries_name; ?></td>
                                    <td><?php echo $countries_iso_code_3;?></td>
                                    <td><?php echo $countries_isd_code;?></td>
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
				<td valign="top">No Country Added!</td>
			</tr>
		</table>
		<?php
	}
}
?>