<?php
// Form submision
$detail_array 	= array();
$error_msg		= 'no';

if($_POST['securityKey']==md5(LATEDEALDELETE)){
	if($_GET['sec'] == 'dealprop') {
		$property_latedeal_id = $_GET['latedealid'];
		$propertyObj->fun_delPropertyDeals($property_latedeal_id);
		echo "<script> location.href='admin-pending-approval.php?sec=dealprop';</script>";
	}
}

if($_POST['securityKey']==md5(LATEDEALSREJECT)){
	if(isset($_POST['txtPropertyDealId']) && $_POST['txtPropertyDealId'] != "") {
		$property_latedeal_id  = $_POST['txtPropertyDealId'];
		if(!empty($_POST['txtDeclineId'])){
			$propertyDealsArr 	= $propertyObj->fun_getPropertyDealsShowArr('', $property_latedeal_id);
			$property_id		= $propertyDealsArr[0]['property_id'];
			$ownerArr 			= $propertyObj->fun_getPropertyOwnerShortInfoArr(" AND A.property_id='".$property_id."' ");
			$owner_fname 		= $ownerArr['user_fname'];
			$owner_lname 		= $ownerArr['user_lname'];
	 		$owner_email 		= trim($ownerArr['user_email']);

			$strMessage = "";
$strMessage .= '<table width="70%"  border="0" cellspacing="10" cellpadding="0">
<tr><td align="center">&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;Hi,</td></tr>
<tr><td>'.trim(ucfirst($owner_fname." ".$owner_lname)).' </td></tr>
<tr><td>&nbsp;Please find reason for decline of your added below:-</td></tr>';
$txtDeclineId = $_POST['txtDeclineId'];
for($i = 0; $i < count($txtDeclineId); $i++) {
	$section_id = $txtDeclineId[$i];
	if($section_id == "1") {
		$strMessage .= '<tr><td><b>Inappropriate content for our site</b></td></tr>';
	} else if($section_id == "2") {
		$strMessage .= '<tr><td><b>Inappropriate picture</b></td></tr>';
	}  else if($section_id == "3") {
		$strMessage .= '<tr><td><b>Picture quality and/or cropping is of poor quality</b></td></tr>';
	} else if($section_id == "4") {
		$strMessage .= '<tr><td><b>Information is confusing</b></td></tr>';
	} else if($section_id == "5") {
		$reason_note 	= $_POST['other_reason'];
		$strMessage .= '<tr><td><b>'.$reason_note.'</b></td></tr>';
	}
}
$strMessage .= '<tr><td>&nbsp;Best Regards,</td></tr>
<tr><td>&nbsp;rentownersvillas.com Team Member</td></tr>	  
</table>';
			require_once("includes/classes/class.Email.php");
			$emailObj = new Email($owner_email, "Manager | rentownersvillas.com <".SITE_ADMIN_EMAIL.">", "Event Decline mail", $strMessage);
			//$emailObj = new Email($owner_email, SITE_ADMIN_EMAIL, "Event Decline mail", $strMessage);
			$emailObj->sendEmail();
		}
		$propertyObj->fun_delPropertyDeals($property_latedeal_id);
	}
	echo "<script> location.href='admin-pending-approval.php?sec=dealprop';</script>";
}

if($_POST['securityKey']==md5(ADDPROPERTYLATEDEAL)){		
	if(($_POST['txtPropertyDealId'] == '')){
		$error_msg	= 'yes';
	} else {
		$txtPropertyDealId = $_POST['txtPropertyDealId'];
	}

	if(($_POST['txtPrpertyRef'] == '')){
		$error_msg	= 'yes';
	} else {
		$txtPrpertyRef = $_POST['txtPrpertyRef'];
	}

	if(($_POST['txtDayFrom0'] == '')){
		$error_msg	= 'yes';
	} else {
		$txtDayFrom0 = $_POST['txtDayFrom0'];
	}

	if(($_POST['txtMonthFrom0'] == '')){
		$error_msg	= 'yes';
	} else {
		$txtMonthFrom0 = $_POST['txtMonthFrom0'];
	}

	if(($_POST['txtYearFrom0'] == '')){
		$error_msg	= 'yes';
	} else {
		$txtYearFrom0 = $_POST['txtYearFrom0'];
	}

	if(($_POST['txtDayTo0'] == '')){
		$error_msg	= 'yes';
	} else {
		$txtDayTo0 = $_POST['txtDayTo0'];
	}

	if(($_POST['txtMonthTo0'] == '')){
		$error_msg	= 'yes';
	} else {
		$txtMonthTo0 = $_POST['txtMonthTo0'];
	}

	if(($_POST['txtYearTo0'] == '')){
		$error_msg	= 'yes';
	} else {
		$txtYearTo0 = $_POST['txtYearTo0'];
	}

	if(($_POST['txtCurrencyType'] == '')){
		$error_msg	= 'yes';
	} else {
		$txtCurrencyType = $_POST['txtCurrencyType'];
	}

	if(($_POST['txtOrgWeekPrice0'] == '')){
		$error_msg	= 'yes';
	} else {
		$txtOrgWeekPrice0 = $_POST['txtOrgWeekPrice0'];
	}

	if(($_POST['txtSaleWeekPrice0'] == '')){
		$error_msg	= 'yes';
	} else {
		$txtSaleWeekPrice0 = $_POST['txtSaleWeekPrice0'];
	}

	if(($_POST['txtMinStay'] == '')){
		$error_msg	= 'yes';
	} else {
		$txtMinStay = $_POST['txtMinStay'];
	}

	if(($_POST['txtMinStayType'] == '')){
		$error_msg	= 'yes';
	} else {
		$txtMinStayType = $_POST['txtMinStayType'];
	}

	if(($_POST['txtRemoveDealFrom0'] == '')){
		$error_msg	= 'yes';
	} else {
		$txtRemoveDealFrom0 = $_POST['txtRemoveDealFrom0'];
	}

	if(($_POST['txtLateDealStatusId'] == '')){
		$error_msg	= 'yes';
	} else {
		$txtLateDealStatusId = $_POST['txtLateDealStatusId'];
	}

	if($error_msg == 'no'){
        $propertyObj->fun_editPropertyDeal($txtPropertyDealId, $txtPrpertyRef, $txtDayFrom0, $txtMonthFrom0, $txtYearFrom0, $txtDayTo0, $txtMonthTo0, $txtYearTo0, $txtCurrencyType, $txtOrgWeekPrice0, $txtSaleWeekPrice0, $txtMinStay, $txtMinStayType, $txtRemoveDealFrom0, $txtLateDealStatusId);
		echo "<script>location.href = window.location;</script>";
	} else {
		$detail_array['error_msg'] = "Please submit your form again!";
	}
}

if($_POST['securityKey']==md5(LATEDEALDELETE)){
	if(isset($_POST['txtPropertyDealId']) && $_POST['txtPropertyDealId'] != "") {
		$txtPropertyDealId = $_POST['txtPropertyDealId'];
//		$propertyObj->fun_delResource($txtPropertyDealId);
	}
	echo "<script> location.href='admin-pending-approval.php?sec=dealprop';</script>";
}
if(isset($property_latedeal_id) && $property_latedeal_id !=""){
	$dayname 				= array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');
	$monthname 				= array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec');
	$yearname 				= array(date('Y')+0,date('Y')+1,date('Y')+2,date('Y')+3);

	$propertyDealsArr 		= $propertyObj->fun_getPropertyDealsShowArr('', $property_latedeal_id);
//print_r($propertyDealsArr);

	$strDealId 				= $property_latedeal_id;
	$txtPrpertyRef			= $propertyDealsArr[0]['property_id'];
	$strDateFrom 			= $propertyDealsArr[0]['start_on'];
	$strDateTo 				= $propertyDealsArr[0]['end_on'];
	$txtOrgWeekPrice0 		= $propertyDealsArr[0]['original_price'];
	$txtSaleWeekPrice0 		= $propertyDealsArr[0]['sale_price'];
	$txtRemoveDealFrom0 	= $propertyDealsArr[0]['remove_from'];
	$txtMinStay 			= $propertyDealsArr[0]['min_stay'];
	$txtMinStayType 		= $propertyDealsArr[0]['min_stay_type'];

	$txtDayFrom0 	= date('d', strtotime($strDateFrom));
	$txtMonthFrom0 	= date('m', strtotime($strDateFrom));
	$txtYearFrom0 	= date('Y', strtotime($strDateFrom));
	
	$txtDayTo0 		= date('d', strtotime($strDateTo));
	$txtMonthTo0 	= date('m', strtotime($strDateTo));
	$txtYearTo0 	= date('Y', strtotime($strDateTo));
	$txtCurrencyType = $propertyObj->fun_findPropertyCurrencyCode($txtPrpertyRef);
?>
<script language="javascript" type="text/javascript">
	var req = ajaxFunction();
	function frmValidateAddLateDeal() {
		var shwError = false;
		if(document.frmPropDeals.txtDayFrom0.value == "") {
			document.getElementById("txtDateFromErrorId").innerHTML = "Please select a start date!";
			document.frmPropDeals.txtDayFrom0.focus();
			shwError = true;
		}

		if(document.frmPropDeals.txtMonthFrom0.value == "") {
			document.getElementById("txtDateFromErrorId").innerHTML = "Please select a start date!";
			document.frmPropDeals.txtMonthFrom0.focus();
			shwError = true;
		}

		if(document.frmPropDeals.txtYearFrom0.value == "") {
			document.getElementById("txtDateFromErrorId").innerHTML = "Please select a start date!";
			document.frmPropDeals.txtYearFrom0.focus();
			shwError = true;
		}

		if(document.frmPropDeals.txtDayTo0.value == "") {
			document.getElementById("txtDateToErrorId").innerHTML = "Please select an end date!";
			document.frmPropDeals.txtDayTo0.focus();
			shwError = true;
		}

		if(document.frmPropDeals.txtMonthTo0.value == "") {
			document.getElementById("txtDateToErrorId").innerHTML = "Please select an end date!";
			document.frmPropDeals.txtMonthFrom0.focus();
			shwError = true;
		}

		if(document.frmPropDeals.txtYearTo0.value == "") {
			document.getElementById("txtDateToErrorId").innerHTML = "Please select an end date!";
			document.frmPropDeals.txtYearFrom0.focus();
			shwError = true;
		}

		if(document.frmPropDeals.txtDayFrom0.value != "" && document.frmPropDeals.txtMonthFrom0.value != "" && document.frmPropDeals.txtYearFrom0.value != "" && document.frmPropDeals.txtDayTo0.value != "" && document.frmPropDeals.txtMonthTo0.value != "" && document.frmPropDeals.txtYearTo0.value != "") {

			var fromDate = new Date();
			var toDate = new Date();
			fromDate.setYear(document.frmPropDeals.txtYearFrom0.value);
			fromDate.setMonth(document.frmPropDeals.txtMonthFrom0.value - 1);
			fromDate.setDate(document.frmPropDeals.txtDayFrom0.value);

			toDate.setYear(document.frmPropDeals.txtYearTo0.value);
			toDate.setMonth(document.frmPropDeals.txtMonthTo0.value - 1);
			toDate.setDate(document.frmPropDeals.txtDayTo0.value);

			if(Date.parse(fromDate) > Date.parse(toDate)) {
				document.getElementById("txtDateToErrorId").innerHTML = "Please select correct end date!";
				document.frmPropDeals.txtYearTo0.focus();
                shwError = true;
			}
		}


		if(document.frmPropDeals.txtCurrencyType.value == "") {
			document.getElementById("txtCurrencyTypeErrorId").innerHTML = "Please select a currency!";
			document.frmPropDeals.txtCurrencyType.focus();
			shwError = true;
		}

		if(document.frmPropDeals.txtOrgWeekPrice0.value == "") {
			document.getElementById("txtOrgWeekPrice0ErrorId").innerHTML = "Please enter the original price per week!";
			document.frmPropDeals.txtOrgWeekPrice0.focus();
			shwError = true;
		}

		if(document.frmPropDeals.txtSaleWeekPrice0.value == "") {
			document.getElementById("txtSaleWeekPrice0ErrorId").innerHTML = "Please enter the SALE price per week!";
			document.frmPropDeals.txtSaleWeekPrice0.focus();
			shwError = true;
		}

		if(parseInt(document.frmPropDeals.txtSaleWeekPrice0.value) >= parseInt(document.frmPropDeals.txtOrgWeekPrice0.value)) {
			document.getElementById("txtSaleWeekPrice0ErrorId").innerHTML = "Your SALE price must be less than your original price!";
			document.frmPropDeals.txtSaleWeekPrice0.focus();
			shwError = true;
		}
		if(shwError == true) {
			return false;
		} else {
			document.frmPropDeals.submit();
		}
	}

	/*
	* For Review pending - approval section : Start here
	*/
	function sbmtLateDealApproval(strId){
		var strId = strId;
		req.open('get', 'includes/ajax/admin-latedeal-pending-approvalXml.php?latedealid=' + strId + '&mode=approve'); 
		req.onreadystatechange = handleApprovalResponse; 
		req.send(null); 
	}

	function sbmtLateDealDecline(strId){
		document.getElementById("showDeclineReasonId").style.display = "block";
		var strId = strId;
		req.open('get', 'includes/ajax/admin-latedeal-pending-approvalXml.php?latedealid=' + strId + '&mode=decline'); 
		req.onreadystatechange = handleApprovalResponse; 
		req.send(null); 
	}

	function sbmtLateDealSuspend(strId){
		var strId = strId;
		req.open('get', 'includes/ajax/admin-latedeal-pending-approvalXml.php?latedealid=' + strId + '&mode=suspend'); 
		req.onreadystatechange = handleApprovalResponse; 
		req.send(null); 
	}

	function sbmtLateDealDelete(){
		document.getElementById("securityKey").value = "<?php echo md5('LATEDEALDELETE'); ?>";
		document.frmPropDeals.submit();
	}
	function sbmtlatedealsReject(){
		if(document.getElementById("txtDeclineId5").checked && document.getElementById("other_reason").value != ""){
			document.getElementById("txtDeclineId1").checked = false;
			document.getElementById("txtDeclineId2").checked = false;
			document.getElementById("txtDeclineId3").checked = false;
			document.getElementById("txtDeclineId4").checked = false;

			document.getElementById("securityKey").value = "<?php echo md5('LATEDEALSREJECT')?>";
			document.frmPropDeals.submit();
		} else if(document.getElementById("txtDeclineId1").checked || document.getElementById("txtDeclineId2").checked || document.getElementById("txtDeclineId3").checked || document.getElementById("txtDeclineId4").checked) {
			document.getElementById("securityKey").value = "<?php echo md5('LATEDEALSREJECT')?>";
			document.frmPropDeals.submit();
		} else {
			return false;
		}
	}


	function handleApprovalResponse() { 
		if(req.readyState == 4){ 
			var response = req.responseText;
			xmlDoc=req.responseXML;
			var root = xmlDoc.getElementsByTagName('latedeals')[0];
			if(root != null){
				var items = root.getElementsByTagName("latedeal");
				var item = items[0];
				var latedealstatus = item.getElementsByTagName("latedealstatus")[0].firstChild.nodeValue;
				if(latedealstatus == "Approved"){
					document.getElementById("txtAdminOptionId").innerHTML 	= "<font color='#FFFFFF' size='2'><strong>"+latedealstatus+"</strong></font>";
				} else if(latedealstatus == "Declined"){
					document.getElementById("txtAdminOptionId").innerHTML 	= "<font color='#FFFFFF' size='2'><strong>"+latedealstatus+"</strong></font>";
				} else if(latedealstatus == "Suspended"){
					document.getElementById("txtAdminOptionId").innerHTML 	= "<font color='#FFFFFF' size='2'><strong>"+latedealstatus+"</strong></font>";
				} else {
					document.getElementById("txtAdminOptionId").innerHTML 	= "<font color='#FFFFFF' size='2'><strong>Error, try later!</strong></font>";
				}
			} else {
				document.getElementById("txtAdminOptionId").innerHTML 	= "<font color='#FFFFFF' size='2'><strong>Error, try later!</strong></font>";
			}
		} else {
			document.getElementById("txtAdminOptionId").innerHTML 	= "<font color='#FFFFFF' size='2'><strong>Please wait...</strong></font>";
		}
	} 

	function find_cal(a,ct){
		var url="../get_cal.php";
		url=url+"?timestamp="+a+"&ct="+ct;
		req.onreadystatechange=function(){
			if (req.readyState==4){
				var object;
				object = req.responseText;				
				x1 = x+160;
				y1 = y-153;
				var googlewin=dhtmlwindow.open("CalendarDiv", "inline", object, " ", "width=235px,height=285px,resize=0,scrolling=0,center=1,xAxis="+x1+",yAxis="+y1+"", "recal");
				googlewin.onclose=function(){ //Run custom code when window is being closed (return false to cancel action):
					return true
				}
			}
		}
		req.open("GET",url,true);
		req.send(null);
	}

	function find_cal1(a,ct){
		var url="../get_cal1.php";
		url=url+"?timestamp="+a+"&ct="+ct;
		req.onreadystatechange=function(){
			if (req.readyState==4){
				var object;
				object = req.responseText;				
				x1 = x-75;
				y1 = y-153;
				var googlewin=dhtmlwindow.open("CalendarDiv", "inline", object, " ", "width=235px,height=285px,resize=0,scrolling=0,center=1,xAxis="+x1+",yAxis="+y1+"", "recal");
				googlewin.onclose=function(){ //Run custom code when window is being closed (return false to cancel action):
					return true
				}
			}
		}
		req.open("GET",url,true);
		req.send(null);
	}

	function find_cal2(a,ct){
		var url="../get_cal1.php";
		url=url+"?timestamp="+a+"&ct="+ct;
		req.onreadystatechange=function(){
			if (req.readyState==4){
				var object;
				object = req.responseText;				
				var googlewin=dhtmlwindow.open("CalendarDiv", "inline", object, " ", "width=235px,height=285px,resize=0,scrolling=0,center=1,xAxis="+x1+",yAxis="+y1+"", "recal");
				googlewin.onclose=function(){ //Run custom code when window is being closed (return false to cancel action):
					return true
				}
			}
		}
		req.open("GET",url,true);
		req.send(null);
	}

	function find_cal3(a,ct){
		var url="../get_cal.php";
		url=url+"?timestamp="+a+"&ct="+ct;
		req.onreadystatechange=function(){
			if (req.readyState==4){
				var object;
				object = req.responseText;				
				var googlewin=dhtmlwindow.open("CalendarDiv", "inline", object, " ", "width=235px,height=285px,resize=0,scrolling=0,center=1,xAxis="+x1+",yAxis="+y1+"", "recal");
				googlewin.onclose=function(){ //Run custom code when window is being closed (return false to cancel action):
					return true
				}
			}
		}
		req.open("GET",url,true);
		req.send(null);
	}
	
	function insert_date(dt,sid){
		var dateString = String(dt);
		var dateBody = dateString.split("/");
	
		var strDayId = "txtDay"+sid;
		var strMonthId = "txtMonth"+sid;
		var strYearId = "txtYear"+sid;

		document.getElementById(strMonthId).value = String(dateBody[0]);
		document.getElementById(strDayId).value = String(dateBody[1]);
		document.getElementById(strYearId).value = String(dateBody[2]);
		document.getElementById("CalendarDiv").style.display = "none";
	}

	function close_calendar(){		
		document.getElementById("CalendarDiv").style.display = "none";
	}

	/*
	* For Review pending - approval section : End here
	*/
	function unCheckOthers() {
		if(document.getElementById("txtDeclineId5").checked){
			document.getElementById("txtDeclineId1").checked = false;
			document.getElementById("txtDeclineId2").checked = false;
			document.getElementById("txtDeclineId3").checked = false;
			document.getElementById("txtDeclineId4").checked = false;
		}
	}

</script>
<form name="frmPropDeals" id="frmPropDeals" action="admin-pending-approval.php?sec=dealprop&latedealid=<?php echo $strDealId; ?>" method="post">
<input type="hidden" name="securityKey" id="securityKey" value="<?php echo md5("ADDPROPERTYLATEDEAL")?>">
<input type="hidden" name="txtPropertyDealId" value="<?php echo $strDealId;?>" />
<input type="hidden" name="txtRemoveDealFrom0" id="txtRemoveDealFrom0" value="s" />
<input type="hidden" name="txtPrpertyRef" id="txtPrpertyRef" value="<?php echo $txtPrpertyRef; ?>">
<input type="hidden" name="txtLateDealStatusId" id="txtLateDealStatusId" value="<?php echo $propertyDealsArr[0]['status']; ?>">

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr><td height="10" colspan="2" valign="top">&nbsp;</td></tr>
    <tr>
        <td valign="top"><a href="admin-pending-approval.php?sec=dealprop" class="back">Back to List</a></td>
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
															if($propertyDealsArr[0]['status'] == "0" || $propertyDealsArr[0]['status'] == "1" || $propertyDealsArr[0]['status'] == "3" || $propertyDealsArr[0]['status'] == "4") {
														?>
															<a href="javascript:showField('txtshwRjctTblId');" style="text-decoration:none;"><img src="images/rejectN.png" alt="Delete" width="71" height="21" border="0" /></a>&nbsp;<a href="javascript:sbmtLateDealApproval(<?php echo $strDealId; ?>);" style="text-decoration:none;"><img src="images/approveN.png" alt="Approve" width="71" height="21" border="0" /></a>
														<?php
															} else {
														?>
															<a href="javascript:sbmtLateDealDelete();" style="text-decoration:none;"><img src="images/DeleteN.png" alt="Delete" width="60" height="21" /></a>&nbsp;<a href="javascript:sbmtLateDealSuspend(<?php echo $strDealId; ?>);" style="text-decoration:none;"><img src="images/suspendN.png" alt="Suspend" width="74" height="21" /></a>
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
														<td width="15" class="pad-lft10"><input name="txtDeclineId[]" type="checkbox" class="checkbox" id="txtDeclineId1" value="1" /></td>
														<td>Inappropriate content for our site</td>
													</tr>
													<tr>
														<td width="15"  class="pad-lft10"><input  name="txtDeclineId[]" type="checkbox" class="checkbox" id="txtDeclineId2" value="2" /></td>
														<td>Inappropriate picture</td>
													</tr>
													<tr>
														<td width="15" class="pad-lft10"><input  name="txtDeclineId[]" type="checkbox" class="checkbox" id="txtDeclineId3" value="3" /></td>
														<td>Picture quality and/or cropping is of poor quality</td>
													</tr>
													<tr>
														<td width="15" class="pad-lft10"><input  name="txtDeclineId[]" type="checkbox" class="checkbox" id="txtDeclineId4" value="4" /></td>
														<td>Information is confusing / dosen't make sense</td>
													</tr>
													<tr>
														<td width="15"  class="pad-lft10"><input  name="txtDeclineId[]" type="checkbox" class="checkbox" id="txtDeclineId5" value="5" onclick="unCheckOthers()" /></td>
														<td>
															<span class="FloatLft">Other, specify reason...</span>
															<span class="FloatLft pad-left12"><input name="other_reason" id="other_reason" class="inpuTxt510" value="" type="text" /></span>
                                                        </td>
													</tr>
													<tr>
														<td colspan="2" class="pad-top10 pad-lft10">
															<a href="javascript:hideField('txtshwRjctTblId');" style="text-decoration:none;"><img src="images/cancelN.png" alt="Cancel" width="66" height="21" /></a>&nbsp;
                                                            <a href="javascript:sbmtlatedealsReject();" style="text-decoration:none;"><img src="images/send.png" alt="Cancel" width="66" height="21" /></a>
                                                        </td>
													</tr>
												</table>
											</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" align="right" valign="top" class="header">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td>
                                                            Reference ID : <?php echo fill_zero_left($strDealId, "0", (6-strlen($strDealId)));?>
                                                        </td>
                                                        <td align="right" valign="bottom"><a href="admin-pending-approval.php?sec=dealprop" style="text-decoration:none;"><img src="images/cancelChangesN.png" alt="Cancel" width="119" height="21" border="0" /></a>&nbsp;<a href="javascript:void(0);" onclick="frmValidateAddLateDeal();" style="text-decoration:none;"><img src="images/saveChangesN.png" alt="Save Approve" width="108" height="21" border="0" /></a></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            Property reference : <strong><?php echo fill_zero_left($txtPrpertyRef, "0", (6-strlen($txtPrpertyRef))).": ".ucfirst($propertyObj->fun_getPropertyName($txtPrpertyRef)); ?></strong>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="23"  align="right" valign="top" class="admleftBg">Offer starts</td>
                                            <td  valign="top">
                                                <table border="0" cellpadding="2" cellspacing="0">
                                                    <tr>
                                                        <td>
                                                            <select name="txtDayFrom0" id="txtDayFrom0" class="PricesDate">
                                                                <option value=""> - - </option>
                                                                <?
                                                                foreach($dayname as $key => $value) {
                                                                ?>
                                                                <option value="<?=$value?>" <? if(isset($txtDayFrom0) && ($value==$txtDayFrom0)){echo "selected";}?>><?=($key+1)?></option>
                                                                <?
                                                                }
                                                                ?>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select name="txtMonthFrom0" id="txtMonthFrom0" class="select75">
                                                                <option value=""> - - </option>
                                                                <?
                                                                foreach ($monthname as $key => $value) {
                                                                ?>
                                                                <option value="<?=$key?>" <? if(isset($txtMonthFrom0) && ($key==$txtMonthFrom0)){echo "selected";}?>><?=$value?></option>
                                                                <?
                                                                }
                                                                ?>
                                                            </select>
                                                        </td>
                                                        <td align="right">
                                                            <select name="txtYearFrom0" id="txtYearFrom0" class="PricesDate" style="width:55px;">
                                                                <option value=""> - - </option>
                                                                <?
                                                                foreach ($yearname as $value) {
                                                                ?>
                                                                <option value="<?=$value?>" <? if(isset($txtYearFrom0) && ($value==$txtYearFrom0)){echo "selected";}?>><?=$value?></option>
                                                                <?
                                                                }
                                                                ?>
                                                            </select>
                                                        </td>
                                                        <td align="right"><a href="JavaScript:find_cal(<?php echo time()?>,'From0');"><img src="images/calender.gif" alt="calendar" /></a></td>
                                                    </tr>
                                                </table>
                                                <span class="pdError1" id="txtDateFromErrorId"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="23"  align="right" valign="top" class="admleftBg">ends</td>
                                            <td  valign="top">
                                                <table border="0" cellpadding="2" cellspacing="0">
                                                    <tr>
                                                        <td>
                                                            <select name="txtDayTo0" id="txtDayTo0" class="PricesDate">
                                                                <option value=""> - - </option>
                                                                <?
                                                                foreach($dayname as $key => $value)
                                                                {
                                                                ?>
                                                                    <option value="<?=$value?>" <? if(isset($txtDayTo0) && ($value==$txtDayTo0)){echo "selected";}else if($value==(date('d')+1)){echo "selected";}else{echo "";}?>><?=($key+1)?></option>
                                                                <?
                                                                }
                                                                ?>
                                                            </select>										
                                                        </td>
                                                        <td>
                                                            <select name="txtMonthTo0" id="txtMonthTo0" class="select75">										
                                                                <option value=""> - - </option>
                                                                <?
                                                                foreach ($monthname as $key => $value) 
                                                                {
                                                                ?>
                                                                    <option value="<?=$key?>" <? if(isset($txtMonthTo0) && ($key==$txtMonthTo0)){echo "selected";}else if($key==date('m')){echo "selected";}else{echo "";}?>><?=$value?></option>
                                                                <?
                                                                }
                                                                ?>
                                                            </select>										
                                                        </td>
                                                        <td align="right">
                                                            <select name="txtYearTo0" id="txtYearTo0" class="PricesDate" style="width:55px;">
                                                                <option value=""> - - </option>
                                                                <?
                                                                foreach ($yearname as $value) 
                                                                {
                                                                ?>
                                                                    <option value="<?=$value?>" <? if(isset($txtYearTo0) && ($key==$txtYearTo0)){echo "selected";}else if($value==date('Y')){echo "selected";}else{echo "";}?>><?=$value?></option>
                                                                <?
                                                                }
                                                                ?>
                                                            </select>										
                                                        </td>
                                                        <td align="right"><a href="JavaScript:find_cal1(<?php echo time()?>,'To0');"><img src="images/calender.gif" alt="calendar" /></a></td>
                                                    </tr>
                                                </table>
                                                <span class="pdError1" id="txtDateToErrorId"></span>
                                            </td>
                                        </tr>
										<tr>
                                            <td height="23"  align="right" valign="top" class="admleftBg">Select currency</td>
                                            <td  valign="top">
                                                <select name="txtCurrencyType" id="txtCurrencyType" class="currency">
                                                    <option value="">Please Select...</option>
                                                    <?php 
                                                        if(!isset($txtCurrencyType)) {
                                                            $txtCurrencyType = 4;
                                                        }
                                                        $propertyObj->fun_getCurrenciesOptionsListWithSymbl($txtCurrencyType);
                                                    ?>
                                                </select>
                                                <span class="pdError1" id="txtCurrencyTypeErrorId"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="23"  align="right" valign="top" class="admleftBg">Original price</td>
                                            <td  valign="top">
                                                <input name="txtOrgWeekPrice0" id="txtOrgWeekPrice0" type="text" style="font-weight:normal;" class="Textfield100" value="<?php echo $txtOrgWeekPrice0; ?>" onKeyUp="checkNumber('txtOrgWeekPrice0', this.value);" maxlength="5" />&nbsp;&nbsp;per week
                                                <span class="pdError1" id="txtOrgWeekPrice0ErrorId"></span>                                            
                                            </td>
                                        </tr>

                                        <tr>
                                            <td height="23"  align="right" valign="top" class="admleftBg">Offer price</td>
                                            <td  valign="top">
                                                <input name="txtSaleWeekPrice0" id="txtSaleWeekPrice0" type="text" style="font-weight:normal;" class="Textfield100" value="<?php echo $txtSaleWeekPrice0; ?>" onKeyUp="checkNumber('txtSaleWeekPrice0', this.value);" maxlength="5" />&nbsp;&nbsp;per week
                                                <span class="pdError1" id="txtSaleWeekPrice0ErrorId"></span>                                            
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="right" valign="top">Min. stay</td>
                                            <td valign="top">
                                                <table border="0" cellpadding="1" cellspacing="0" class="pink12arial">
                                                    <tr>
                                                        <td>
                                                            <select name="txtMinStay" id="txtMinStay" class="Listmenu45">
                                                                <option value=""> - - </option>
                                                                <?
                                                                for($j = 1; $j <= 31; $j++) {
                                                                ?>
                                                                    <option value="<?php echo $j;?>" <? if(isset($txtMinStay) && ($j==$txtMinStay)){echo "selected";} else{echo "";}?>><?php echo $j;?></option>
                                                                <?
                                                                }
                                                                ?>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select name="txtMinStayType" id="txtMinStayType" class="Listmenu60">
                                                                <?php
                                                                if($txtMinStayType == "w"){
                                                                    echo "<option value=\"n\">Night</option>";
                                                                    echo "<option value=\"w\" selected=\"selected\">Week</option>";
                                                                } else {
                                                                    echo "<option value=\"n\" selected=\"selected\">Night</option>";
                                                                    echo "<option value=\"w\">Week</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
										<tr>
											<td colspan="2" align="right" valign="top" class="header">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td>
                                                            Reference ID : <?php echo fill_zero_left($strDealId, "0", (6-strlen($strDealId)));?>
                                                        </td>
                                                        <td align="right" valign="bottom"><a href="admin-pending-approval.php?sec=dealprop" style="text-decoration:none;"><img src="images/cancelChangesN.png" alt="Cancel" width="119" height="21" border="0" /></a>&nbsp;<a href="javascript:void(0);" onclick="frmValidateAddLateDeal();" style="text-decoration:none;"><img src="images/saveChangesN.png" alt="Save Approve" width="108" height="21" border="0" /></a></td>
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
			case 'dealpropcode':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$latecodedr 		= 0;
					$latesavingdr		= 1;
					$propertytitledr 	= 1;
					$latedatedr 		= 1;
					$latepricedr 		= 1;
					$latestatusdr 		= 1;
				} else {
					$dr = "DESC";
					$latecodedr 		= 1;
					$latesavingdr		= 1;
					$propertytitledr 	= 1;
					$latedatedr 		= 1;
					$latepricedr 		= 1;
					$latestatusdr 		= 1;
				}
				$strQuery .= " A.id ".$dr;
			break;
			case 'dealprice':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$latecodedr 		= 1;
					$latesavingdr		= 1;
					$propertytitledr 	= 1;
					$latedatedr 		= 1;
					$latepricedr 		= 0;
					$latestatusdr 		= 1;
				} else {
					$dr = "DESC";
					$latecodedr 		= 1;
					$latesavingdr		= 1;
					$propertytitledr 	= 1;
					$latedatedr 		= 1;
					$latepricedr 		= 1;
					$latestatusdr 		= 1;
				}
				$strQuery .= " A.original_price ".$dr;
			break;
			case 'dealsaving':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$latecodedr 		= 1;
					$latesavingdr		= 0;
					$propertytitledr 	= 1;
					$latedatedr 		= 1;
					$latepricedr 		= 1;
					$latestatusdr 		= 1;
				} else {
					$dr = "DESC";
					$latecodedr 		= 1;
					$latesavingdr		= 1;
					$propertytitledr 	= 1;
					$latedatedr 		= 1;
					$latepricedr 		= 1;
					$latestatusdr 		= 1;
				}
				$strQuery .= " A.original_price ".$dr;
			break;
			case 'propertytitle':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$latecodedr 		= 1;
					$latesavingdr		= 1;
					$propertytitledr 	= 0;
					$latedatedr 		= 1;
					$latepricedr 		= 1;
					$latestatusdr 		= 1;
				} else {
					$dr = "DESC";
					$latecodedr 		= 1;
					$latesavingdr		= 1;
					$propertytitledr 	= 1;
					$latedatedr 		= 1;
					$latepricedr 		= 1;
					$latestatusdr 		= 1;
				}
				$strQuery .= " A.original_price ".$dr;
			break;
			case 'latedate':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$latecodedr 		= 1;
					$latesavingdr		= 1;
					$propertytitledr 	= 1;
					$latedatedr 		= 0;
					$latepricedr 		= 1;
					$latestatusdr 		= 1;
				} else {
					$dr = "DESC";
					$latecodedr 		= 1;
					$latesavingdr		= 1;
					$propertytitledr 	= 1;
					$latedatedr 		= 1;
					$latepricedr 		= 1;
					$latestatusdr 		= 1;
				}
				$strQuery .= " A.original_price ".$dr;
			break;
			case 'latestatus':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$latecodedr 		= 1;
					$latesavingdr		= 1;
					$propertytitledr 	= 1;
					$latedatedr 		= 1;
					$latepricedr 		= 1;
					$latestatusdr 		= 0;
				} else {
					$dr = "DESC";
					$latecodedr 		= 1;
					$latesavingdr		= 1;
					$propertytitledr 	= 1;
					$latedatedr 		= 1;
					$latepricedr 		= 1;
					$latestatusdr 		= 1;
				}
				$strQuery .= " A.status ".$dr;
			break;
		}
	} else {
		$latecodedr 		= 1;
		$latesavingdr		= 1;
		$propertytitledr 	= 1;
		$latedatedr 		= 1;
		$latepricedr 		= 1;
		$latestatusdr 		= 1;
	}

	$dealListArr			= $propertyObj->fun_getPendingApprovalLateDealsArr($strQuery);
	
//	print_r($dealListArr);
	
	if(is_array($dealListArr) && count($dealListArr) > 0){
	?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr><td colspan="2" valign="top">&nbsp;</td></tr>
			<tr>
				<td colspan="2" valign="top">
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EventListing">
						<thead>
							<tr>
								<th width="10%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=dealprop&sortby=dealpropcode&dr=".$dealpropcodedr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "dealpropcode")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?> ><div>ID</div></th>
								<th width="10%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=dealprop&sortby=dealprice&dr=".$dealpricedr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "dealprice")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Price</div></th>
								<th width="10%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=dealprop&sortby=dealsaving&dr=".$dealsavingdr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "dealsaving")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?> ><div>Savings</div></th>
								<th width="45%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=dealprop&sortby=propertytitle&dr=".$propertytitledr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "propertytitle")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Details</div></th>
								<th width="15%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=dealprop&sortby=latedate&dr=".$latedatedr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "latedate")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Dates</div></th>
								<th width="10%" scope="col" class="right" onmouseover="this.className = 'rightOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=dealprop&sortby=latestatus&dr=".$latestatusdr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "latestatus")){echo "class=\"rightOver\" onmouseout=\"this.className = 'rightOver';\" ";}else{echo "onmouseout=\"this.className = 'right';\"";}?>><div>Status</div></th>
							</tr>
						</thead>
						<tbody>
							<?php
                            for($i=0; $i < count($dealListArr); $i++) {
								$strDealId 				= $dealListArr[$i]['id'];
								$txtPrpertyRef			= $dealListArr[$i]['property_id'];
								$strDateFrom 			= $dealListArr[$i]['start_on'];
								$strDateTo 				= $dealListArr[$i]['end_on'];
								$txtOrgWeekPrice0 		= $dealListArr[$i]['original_price'];
								$txtSaleWeekPrice0 		= $dealListArr[$i]['sale_price'];
								$status 				= $dealListArr[$i]['status'];
								$strUnixDateFrom 		= strtotime($strDateFrom);
								$strUnixDateTo	 		= strtotime($strDateTo);
								$strUnixDateCur 		= time ();
							
								if (($strDateFrom < $strDateTo) && (date("m/d/Y") < $strDateTo)) {

									$startDate = (date("m/d/Y") > $strDateFrom)?date("Y-m-d H:i:s", $strUnixDateCur):date("Y-m-d H:i:s", $strUnixDateFrom);
//									$startDate = date("Y-m-d H:i:s", $strUnixDateCur);
									$endDate = date("Y-m-d H:i:s", $strUnixDateTo);
									 // exploding everything into seperate variabels
									list($startDateDate, $startDateTime) = explode(" ", $startDate);
									list($endDateDate, $endDateTime) = explode(" ", $endDate);
							
									list($startYear, $startMonth, $startDay) = explode("-", $startDateDate);
									list($endYear, $endMonth, $endDay) = explode("-", $endDateDate);
							
									list($startHour, $startMinute, $startSecond) = explode(":", $startDateTime);
									list($endHour, $endMinute, $endSecond) = explode(":", $endDateTime);
							
									 // now we can start calculating
									 // difference in seconds
									$secondDiff	= $endSecond - $startSecond;
									if ($startSecond > $endSecond) {
										 // if the difference is negative, we add 60 seconds and increase the starting minute
										$secondDiff += 60;
										$startMinute++;
									}
									$minuteDiff	= $endMinute - $startMinute;
									if ($startMinute > $endMinute) {
										$minuteDiff += 60;
										$startHour++;
									}
									$hourDiff	= $endHour - $startHour;
									if ($startHour > $endHour) {
										$hourDiff += 24;
										$startDay++;
									}
							
									 // days in starting month
									if ($endMonth > $startMonth || $endYear > $startYear) {
										if ($startDay > $endDay) {
											 // amount of days this month has
											$daysThisMonth = date("t", $startDate);
											 // difference in days to the next month
											$dayDiff	= ($daysThisMonth - $startDay) + $endDay;
											 // compensating for the months
											$startMonth++;
										} else
											$dayDiff = $endDay - $startDay;
									} else {
										$dayDiff = $endDay - $startDay;
									}
									$monthDiff	= $endMonth - $startMonth;
									if ($startMonth > $endMonth) {
										$monthDiff += 12;
										$startYear++;
									}
									$yearDiff	= $endYear - $startYear;
									 // we know all the differences, so we're outputting that
									$strTimeLeft = "";
									if ($yearDiff > 0)
										$strTimeLeft = $yearDiff." yrs";
									elseif ($monthDiff > 0)
										$strTimeLeft = $monthDiff." months";
									elseif ($dayDiff > 0)
										$strTimeLeft = $dayDiff." days";
									elseif ($hourDiff > 0)
										$strTimeLeft = $hourDiff." hrs";
									elseif ($minuteDiff > 0)
										$strTimeLeft = $minuteDiff." mins";
									elseif ($secondDiff > 0)
										$strTimeLeft = $secondDiff." sec";
									else
										$strTimeLeft =  "";
								} else {
									$strTimeLeft =  "";
								}
								
							//	echo $strTimeLeft;
							
								$strHrsLeft				= (int)(($strUnixDateFrom - $strUnixDateCur) / (60 * 60));
								$strNights				= (int)(($strUnixDateTo - $strUnixDateFrom) / (60 * 60 * 24));
								$txtCurrencySymbol 		= $propertyObj->fun_findPropertyCurrencySymbol($ref_id,'');
							//print_r($txtCurrencySymbol);
								$strPricePerNight 		= $txtCurrencySymbol.(number_format($txtOrgWeekPrice0));
								$strPercentSave 		= round(((($txtOrgWeekPrice0 - $txtSaleWeekPrice0) / $txtOrgWeekPrice0)*100), 0);
							
								if($strUnixDateTo > mktime(0, 0, 0, date("m"), date("d"), date("Y"))) {
									switch($status) {
										case '1':
											$strStatus = "Pending";
										break;
										case '2':
											$strStatus = "<span class=\"pink12\">LIVE</span>";
										break;
										case '3':
											$strStatus = "Expired";
										break;
										case '4':
											$strStatus = "Suspended";
										break;
									}
								} else {
									$strStatus = "Expired";
								}
							
								$propertyInfoArr		= $propertyObj->fun_getPropertyInfo($txtPrpertyRef);
								if(count($propertyInfoArr) > 0){
									$strPropertyName 		= ucwords($propertyInfoArr['property_name']);
									$strPropertyTotalBeds	= $propertyInfoArr['total_beds'];
									$strPropertyTotalBaths	= $propertyInfoArr['total_bathrooms'];
								}
							
								$strThumbArr = $propertyObj->fun_getPropertyMainThumb($txtPrpertyRef);
								if(is_array($strThumbArr)) {
									$strThumbUrl = PROPERTY_IMAGES_THUMB88x66_PATH.$strThumbArr[0]['photo_thumb'];
									$strThumbCap = $strThumbArr[0]['photo_caption'];
								} else {
									$strThumbUrl = PROPERTY_IMAGES_THUMB88x66_PATH."no-image-small.gif";
									$strThumbCap = "No Image";
								}
								$strPropLocArr = $propertyObj->fun_getPropertyLocInfoArr($txtPrpertyRef);
                            ?>
                                <tr>
                                    <td class="left"><a href="admin-pending-approval.php?sec=dealprop&latedealid=<?php echo $strDealId; ?>"><?php echo fill_zero_left($strDealId, "0", (6-strlen($strDealId)));?></a></td>
                                    <td align="center"><?php  echo $strPricePerNight; ?></td>
                                    <td align="center"><?php echo $strPercentSave."%"; ?></td>
                                    <td>
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td width="100" valign="top"><div><img src="<?php echo $strThumbUrl;?>" width="88" height="66" alt="<?php echo $strThumbCap;?>" title="<?php echo $strThumbCap;?>" align="middle" /></div></td>
                                                <td width="135" class="dash-right">
                                                    <strong class="black"><?php echo $strPropertyName." - ".fill_zero_left($txtPrpertyRef, "0", (6-strlen($txtPrpertyRef)));?></strong><br />
                                                    <?php echo ucwords($strPropLocArr['region_pname']);?><br />
                                                    <?php echo ucwords($strPropLocArr['region_name']);?><br />
                                                    <?php echo ucwords($strPropLocArr['location_name']);?>
                                                </td>
                                                <td width="95">
                                                    <?php 
                                                    if((int)$strPropertyTotalBeds > 1) {
                                                        echo $strPropertyTotalBeds." beds<br />";
                                                    } else if((int)$strPropertyTotalBeds == 1) {
                                                        echo $strPropertyTotalBeds." bed<br />";
                                                    }
                                                    ?>
                                                    <?php 
                                                    if((int)$strPropertyTotalBaths > 1) {
                                                        echo $strPropertyTotalBaths." bathrooms<br />";
                                                    } else if((int)$strPropertyTotalBaths == 1) {
                                                        echo $strPropertyTotalBaths." bathroom<br />";
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td class="font11">
                                        <strong class="black"><?php echo $strTimeLeft; ?></strong> <br />
                                        <br />
                                        <?php echo date('D M j, Y', $strUnixDateFrom); ?><br />
                                        to<br />
                                        <?php echo date('D M j, Y', $strUnixDateTo); ?>
                                    </td>
                                    <td><?php echo $strStatus; ?></td>
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
            <tr><td valign="top">No late deal added!</td></tr>
		</table>
		<?php
	}
}
?>