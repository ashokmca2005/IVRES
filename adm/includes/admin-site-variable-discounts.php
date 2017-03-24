<?php
// Form submision
$detail_array 	= array();
$error_msg		= 'no';
if($_POST['securityKey']==md5(PROMODELETE)){
	if(isset($_POST['txtPromoId']) && $_POST['txtPromoId'] != "") {
		$txtPromoId = $_POST['txtPromoId'];
		$promoObj->fun_delPromo($txtPromoId);
	}
	echo "<script> location.href='admin-site-variables.php?sec=disc';</script>";
}

if($_POST['securityKey'] == md5(ADDPROMOCODE)){
	$edit = false;
	if(isset($_POST['txtPromoId']) && $_POST['txtPromoId'] != "") {
		$txtPromoId			= $_POST['txtPromoId'];
		$edit = true;
	}
	$txtPromoCode 			= $_POST['txtPromoCode'];
	$txtPromoDesc 			= $_POST['txtPromoDesc'];
	$txtPromoReduction 		= $_POST['txtPromoReduction'];
	$txtPromoReductionType	= $_POST['txtPromoReductionType'];
	$txtPromoTakeUp 		= $_POST['txtPromoTakeUp'];
	$txtPromo 				= $_POST['txtPromo'];
	$tmpArr					= array();
	for($i = 0; $i < count($txtPromo); $i++) {
		if(($txtPromo[$i] != "") && !in_array($txtPromo[$i], $tmpArr)) {
			array_push($tmpArr, $txtPromo[$i]);
		}
	}
	$txtPromoCategoryIds= "";
	$txtPromoCategoryIds= implode(",", $tmpArr);

	$txtDayFrom1 			= $_POST['txtDayFrom1'];
	$txtMonthFrom1 			= $_POST['txtMonthFrom1'];
	$txtYearFrom1 			= $_POST['txtYearFrom1'];
	$txtFromDate 			= $txtYearFrom1."-".$txtMonthFrom1."-".$txtDayFrom1;

	$txtDayTo1 				= $_POST['txtDayTo1'];
	$txtMonthTo1 			= $_POST['txtMonthTo1'];
	$txtYearTo1 			= $_POST['txtYearTo1'];
	$txtToDate 				= $txtYearTo1."-".$txtMonthTo1."-".$txtDayTo1;

	if($edit == true) {
		$promoObj->fun_editPromo($txtPromoId, $txtPromoCategoryIds, $txtPromoCode, $txtPromoDesc, $txtPromoReduction, $txtPromoReductionType, $txtPromoTakeUp, $txtFromDate, $txtToDate);
	} else {
		$txtPromoId = $promoObj->fun_addPromo($txtPromoCategoryIds, $txtPromoCode, $txtPromoDesc, $txtPromoReduction, $txtPromoReductionType, $txtPromoTakeUp, $txtFromDate, $txtToDate);
	}
	echo "<script>location.href = 'admin-site-variables.php?sec=disc&subsec=editdisc&promoid=".$txtPromoId."';</script>";
}
if(isset($_GET['subsec']) && $_GET['subsec'] !=""){
	switch($_GET['subsec']) { // Add edit section for promos
		case 'adddisc':
		case 'editdisc':
			if($_GET['subsec'] == 'editdisc') {
				$promo_id 		= $_GET['promoid'];
				$promoInfoArr 	= $promoObj->fun_getPromoInfo($promo_id);
				$addtitle 		= "Edit promo code";
				$edit 			= TRUE;
			} else {
				$addtitle 		= "Add new promo code";
				$edit 			= FALSE;
			}
		break;
	}
	$dayname 	= array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');
	$monthname 	= array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec');
	$yearname 	= array(date('Y')+0,date('Y')+1,date('Y')+2,date('Y')+3);
?>
<!-- TinyMCE -->
<script type="text/javascript" src="../tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		mode : "exact",
		elements : "txtPromoDescId",
		handle_event_callback : "myHandleEvent",
		theme : "simple",
		plugins : 'advlink,advimage',
		relative_urls : false,
		remove_script_host : false
	});

	//event such as key or mouse press
	function myHandleEvent(e){
		if(e.type=="keyup"){
			chkblnkEditorTxtError("txtPromoDescId", "txtPromoDescErrorId");	
		}
		return true;
	}
</script>
<!-- /TinyMCE -->
<script language="javascript" type="text/javascript">
	var req = ajaxFunction();
	var x1 = "";
	var y1 = "";

	function frmValidateAddPromo() {
		var shwError = false;
		if(document.frmAddPromo.txtDayFrom1.value == "") {
			document.getElementById("txtDateFromErrorId").innerHTML = "Please select a start date!";
			document.frmAddPromo.txtDayFrom1.focus();
			shwError = true;
		} else if(document.frmAddPromo.txtMonthFrom1.value == "") {
			document.getElementById("txtDateFromErrorId").innerHTML = "Please select a start date!";
			document.frmAddPromo.txtMonthFrom1.focus();
			shwError = true;
		} else if(document.frmAddPromo.txtYearFrom1.value == "") {
			document.getElementById("txtDateFromErrorId").innerHTML = "Please select a start date!";
			document.frmAddPromo.txtYearFrom1.focus();
			shwError = true;
		}

		if(document.frmAddPromo.txtDayTo1.value == "") {
			document.getElementById("txtDateToErrorId").innerHTML = "Please select an end date!";
			document.frmAddPromo.txtDayTo1.focus();
			shwError = true;
		} else if(document.frmAddPromo.txtMonthTo1.value == "") {
			document.getElementById("txtDateToErrorId").innerHTML = "Please select an end date!";
			document.frmAddPromo.txtMonthFrom1.focus();
			shwError = true;
		} else if(document.frmAddPromo.txtYearTo1.value == "") {
			document.getElementById("txtDateToErrorId").innerHTML = "Please select an end date!";
			document.frmAddPromo.txtYearFrom1.focus();
			shwError = true;
		}

		if(document.frmAddPromo.txtDayFrom1.value != "" && document.frmAddPromo.txtMonthFrom1.value != "" && document.frmAddPromo.txtYearFrom1.value != "" && document.frmAddPromo.txtDayTo1.value != "" && document.frmAddPromo.txtMonthTo1.value != "" && document.frmAddPromo.txtYearTo1.value != "") {
			var fromDate = new Date();
			var toDate = new Date();
			fromDate.setYear(document.frmAddPromo.txtYearFrom1.value);
			fromDate.setMonth(document.frmAddPromo.txtMonthFrom1.value - 1);
			fromDate.setDate(document.frmAddPromo.txtDayFrom1.value);

			toDate.setYear(document.frmAddPromo.txtYearTo1.value);
			toDate.setMonth(document.frmAddPromo.txtMonthTo1.value - 1);
			toDate.setDate(document.frmAddPromo.txtDayTo1.value);

			if(Date.parse(fromDate) > Date.parse(toDate)) {
				document.getElementById("txtDateToErrorId").innerHTML = "Please select correct end date!";
				document.frmAddPromo.txtYearTo1.focus();
				shwError = true;
			}
		}

/*
		if(document.frmAddPromo.txtPromoTakeUp.value == "" || isNaN(document.frmAddPromo.txtPromoTakeUp.value) == true) {
			document.getElementById("txtPromoTakeUpErrorId").innerHTML = "Please enter total take up";
			document.frmAddPromo.txtPromoTakeUp.focus();
			shwError = true;
		}
*/

		if(document.frmAddPromo.txtPromoReduction.value == "" || isNaN(document.frmAddPromo.txtPromoReduction.value) == true) {
			document.getElementById("txtPromoReductionErrorId").innerHTML = "Please enter reduction";
			document.frmAddPromo.txtPromoReduction.focus();
			shwError = true;
		}

		if(document.frmAddPromo.txtPromoCode.value == "") {
			document.getElementById("txtPromoCodeErrorId").innerHTML = "Please enter promo code.";
			document.frmAddPromo.txtPromoCode.focus();
			shwError = true;
		}
		if(tinyMCE.get("txtPromoDescId").getContent() == "") {
			document.getElementById("txtPromoDescErrorId").innerHTML = "Please enter promo description.";
			document.frmAddPromo.txtPromoDescId.focus();
			shwError = true;
		}

		if(document.frmAddPromo.txtPromoReductionType.value == "1") {
			var total = 0;
			for (var idx = 0; idx < 5; idx++) {
				if (document.getElementById("txtPromo"+idx).checked == true) {
					total += 1;
				}
			}
			if(total != 1) {
				document.getElementById("txtPromoCategoryErrorId").innerHTML = "Please select only one promo type.";
				shwError = true;
			}
		}

		if(document.frmAddPromo.txtPromoReductionType.value == "0") {
			var total = 0;
			for (var idx = 0; idx < 5; idx++) {
				if (document.getElementById("txtPromo"+idx).checked == true) {
					total += 1;
				}
			}
			if(total < 1) {
				document.getElementById("txtPromoCategoryErrorId").innerHTML = "Please select promo type.";
				shwError = true;
			}
		}

		if(shwError == true) {
			return false;
		} else {
			document.frmAddPromo.submit();
		}
	}

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
* For event pending - approval section : Start here
*/
	function sbmtPromoApproval(strId){
		var strId = strId;
		req.open('get', 'includes/ajax/admin-promo-pending-approvalXml.php?promoid=' + strId + '&mode=approve'); 
		req.onreadystatechange = handleApprovalResponse; 
		req.send(null); 
	}

	function sbmtPromoDecline(strId){
		document.getElementById("showDeclineReasonId").style.display = "block";
		var strId = strId;
		req.open('get', 'includes/ajax/admin-promo-pending-approvalXml.php?promoid=' + strId + '&mode=decline'); 
		req.onreadystatechange = handleApprovalResponse; 
		req.send(null); 
	}

	function sbmtPromoSuspend(strId){
		var strId = strId;
		req.open('get', 'includes/ajax/admin-promo-pending-approvalXml.php?promoid=' + strId + '&mode=suspend'); 
		req.onreadystatechange = handleApprovalResponse; 
		req.send(null); 
	}

	function sbmtPromoDelete(){
		document.getElementById("securityKey").value = "<?php echo md5('PROMODELETE')?>";
		document.frmAddPromo.submit();
	}

	function handleApprovalResponse() { 
		if(req.readyState == 4){ 
			var response = req.responseText; 
			xmlDoc=req.responseXML;
			var root = xmlDoc.getElementsByTagName('promos')[0];
			if(root != null){
				var items = root.getElementsByTagName("promo");
				var item = items[0];
				var promostatus = item.getElementsByTagName("promostatus")[0].firstChild.nodeValue;
				if(promostatus == "Approved"){
					document.getElementById("txtAdminOptionId").innerHTML 	= "<font color='#FFFFFF' size='2'><strong>"+promostatus+"</strong></font>";
				} else if(promostatus == "Declined"){
					document.getElementById("txtAdminOptionId").innerHTML 	= "<font color='#FFFFFF' size='2'><strong>"+promostatus+"</strong></font>";
				} else if(promostatus == "Suspended"){
					document.getElementById("txtAdminOptionId").innerHTML 	= "<font color='#FFFFFF' size='2'><strong>"+promostatus+"</strong></font>";
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
/*
* For promo pending - approval section : End here
*/
</script>


<form name="frmAddPromo" id="frmAddPromo" action="admin-site-variables.php?sec=disc" method="post" enctype="multipart/form-data">
<input type="hidden" name="securityKey" id="securityKey" value="<?php echo md5("ADDPROMOCODE")?>">
<input type="hidden" name="txtPromoId" id="txtPromoId" value="<?php echo $promo_id; ?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr>
        <td valign="top" class="SectionSubHead"><?php echo $addtitle;?></td>
        <td>&nbsp;</td>
    </tr>
    <tr><td height="10" colspan="2" valign="top">&nbsp;</td></tr>
    <tr>
        <td valign="top"><a href="admin-site-variables.php?sec=disc" class="back">Back to List</a></td>
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
										<?php 
                                            if(isset($promo_id) && $promo_id!= "") {
                                            ?>
                                            <tr>
                                                <td colspan="2" align="right" valign="top" class="header">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td>
                                                            <div id="txtAdminOptionId">
                                                            <?php 
                                                                if($promoInfoArr['active'] == "0") {
                                                            ?>
                                                                <a href="javascript:sbmtPromoDelete();" style="text-decoration:none;"><img src="images/DeleteN.png" alt="Delete" width="60" height="21" /></a>&nbsp;<a href="javascript:sbmtPromoApproval(<?php echo $promo_id; ?>);" style="text-decoration:none;"><img src="images/approveN.png" alt="Approve" width="71" height="21" border="0" /></a>
                                                            <?php
                                                                } else {
                                                            ?>
                                                                <a href="javascript:sbmtPromoDelete();" style="text-decoration:none;"><img src="images/DeleteN.png" alt="Delete" width="60" height="21" /></a>&nbsp;<a href="javascript:sbmtPromoSuspend(<?php echo $promo_id; ?>);" style="text-decoration:none;"><img src="images/suspendN.png" alt="Suspend" width="74" height="21" /></a>
                                                            <?php
                                                                }
                                                            ?>
                                                            </div>
                                                            </td>
<!--                                                            <td align="right" valign="bottom"><img src="images/previousN.png" alt="Preview" width="74" height="21" /> <img src="images/nextN.png" alt="Cancel" width="48" height="21" /></td>
-->                                                        </tr>
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
                                                            <a href="admin-site-variables.php?sec=disc" style="text-decoration: none;"><img src="images/cancelN.png" alt="Cancel" border="0" height="21" width="66"></a>&nbsp;<a href="javascript:void(0);" onclick="frmValidateAddPromo();" style="text-decoration:none;"><img src="images/saveChangesN.png" alt="Save Approve" width="108" height="21" border="0" /></a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="23"  align="right" valign="top" class="admleftBg">Promo Code</td>
                                            <td  valign="top"><input name="txtPromoCode" id="txtPromoCodeId" type="text" class="inpuTxt260" value="<?php echo $promoInfoArr['promo_code']; ?>" onkeydown="chkblnkTxtError('txtPromoCodeId', 'txtPromoCodeErrorId');" onkeyup="chkblnkTxtError('txtPromoCodeId', 'txtPromoCodeErrorId');" /><span class="pdError1 pad-lft10" id="txtPromoCodeErrorId"></span></td>
                                        </tr>
                                        <tr>
                                            <td height="23" align="right" valign="top" class="admleftBg">Description</td>
                                            <td  valign="top">
												<textarea name="txtPromoDesc" id="txtPromoDescId" class="textArea460" onkeydown="chkblnkTxtError('txtPromoDescId', 'txtPromoDescErrorId');" onkeyup="chkblnkTxtError('txtPromoDescId', 'txtPromoDescErrorId');" ><?php echo $promoInfoArr['promo_description']; ?></textarea>
                                                <span class="pdError1 pad-lft10" id="txtPromoDescErrorId"></span>
											</td>
                                        </tr>
                                        <tr>
                                            <td height="23" align="right" valign="top" class="admleftBg">Promo type</td>
                                            <td valign="top">
												<?php $promoObj->fun_createPromosCategoryCheckbox($promo_id); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="23" align="right" valign="top" class="admleftBg">Reduction</td>
                                            <td  valign="top">
											<input name="txtPromoReduction" id="txtPromoReductionId" class="inpuTxt260" value="<?php echo $promoInfoArr['promo_reduction'];?>" type="text" />
											&nbsp;&nbsp;Type&nbsp;:&nbsp;&nbsp;
											<select name="txtPromoReductionType">
												<option value="0" selected="selected">Percentage</option>
												<option value="1" <?php if(isset($promoInfoArr['promo_reduction_type']) && ($promoInfoArr['promo_reduction_type'] == "1")) { echo "selected=\"selected\"";}?> >Fixed</option>
											</select>
											&nbsp;
											<span class="pdError1" id="txtPromoReductionErrorId"></span>
											</td>
                                        </tr>
                                        <tr>
                                            <td height="23" align="right" valign="top" class="admleftBg">Quantity</td>
                                            <td  valign="top">
                                                <input name="txtPromoTakeUp" id="txtPromoTakeUpId" class="inpuTxt260" value="<?php echo $promoInfoArr['promo_takeup'];?>" type="text" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" colspan="2" style="padding:0px;">
												<table id="tblShwDateId" border="0" width="100%" cellspacing="0"  cellpadding="10" class="eventForm" >
													<tr>
														<td width="82" height="23" align="right" valign="top" class="admleftBg" style="border-right:1px solid #bdbdbd;">Start date</td>
														<td  valign="top">
															<?php
																if(isset($promoInfoArr['promo_start_date']) && ($promoInfoArr['promo_start_date'] != "")) {
																	$fromDateArr 		= explode("-", $promoInfoArr['promo_start_date']);
																	$txtDayFrom1 		= $fromDateArr[2];
																	$txtMonthFrom1 		= $fromDateArr[1];
																	$txtYearFrom1 		= $fromDateArr[0];
																}
															?>
															<table border="0" cellpadding="2" cellspacing="0">
																<tr>
																	<td>
																	<select name="txtDayFrom1" id="txtDayFrom1" class="PricesDate">
																		<option value=""> - - </option>
																		<?
																		foreach($dayname as $key => $value) {
																		?>
																			<option value="<?=$value?>" <? if(isset($txtDayFrom1) && ($value==$txtDayFrom1)){echo "selected";}else{echo "";}?>><?=($key+1)?></option>
																		<?
																		}
																		?>
																	</select>															
																	</td>
																	<td>
																	<select name="txtMonthFrom1" id="txtMonthFrom1" class="select75">										
																		<option value=""> - - </option>
																		<?
																		foreach ($monthname as $key => $value) {
																		?>
																			<option value="<?=$key?>" <? if(isset($txtMonthFrom1) && ($key==$txtMonthFrom1)){echo "selected";}else{echo "";}?>><?=$value?></option>
																		<?
																		}
																		?>
																	</select>															
																	</td>
																	<td align="right">
																	<select name="txtYearFrom1" id="txtYearFrom1" class="PricesDate" style="width:55px;">										
																		<option value=""> - - </option>
																		<?
																		foreach ($yearname as $value) {
																		?>
																			<option value="<?=$value?>" <? if(isset($txtYearFrom1) && ($value==$txtYearFrom1)){echo "selected";}else{echo "";}?>><?=$value?></option>
																		<?
																		}
																		?>
																	</select>															
																	</td>
																	<td align="right"><a href="JavaScript:find_cal(<?php echo time()?>,'From1');"><img src="images/calender.gif" alt="calendar" /></a></td>
																</tr>
															</table>
															<span class="pdError1" id="txtDateFromErrorId"></span>														</td>
													</tr>
													<tr>
														<td height="23" align="right" valign="top" class="admleftBg" style="border-right:1px solid #bdbdbd;">End date</td>
														<td  valign="top">
															<?php
																if(isset($promoInfoArr['promo_end_date']) && ($promoInfoArr['promo_end_date'] != "")) {
																	$toDateArr 		= explode("-", $promoInfoArr['promo_end_date']);
 																	$txtDayTo1 		= $toDateArr[2];
																	$txtMonthTo1 	= $toDateArr[1];
																	$txtYearTo1 	= $toDateArr[0];
																}
															?>
															<table border="0" cellpadding="2" cellspacing="0">
																<tr>
																	<td>
																		<select name="txtDayTo1" id="txtDayTo1" class="PricesDate">
																			<option value=""> - - </option>
																			<?
																			foreach($dayname as $key => $value) {
																			?>
																				<option value="<?=$value?>" <? if(isset($txtDayTo1) && ($value == $txtDayTo1)){echo "selected";}else{echo "";}?>><?=($key+1)?></option>
																			<?
																			}
																			?>
																		</select>															
																	</td>
																	<td>
																		<select name="txtMonthTo1" id="txtMonthTo1" class="select75">										
																			<option value=""> - - </option>
																			<?
																			foreach ($monthname as $key => $value) {
																			?>
																				<option value="<?=$key?>" <? if(isset($txtMonthTo1) && ($key==$txtMonthTo1)){echo "selected";}else{echo "";}?>><?=$value?></option>
																			<?
																			}
																			?>
																		</select>															
																	</td>
																	<td align="right">
																		<select name="txtYearTo1" id="txtYearTo1" class="PricesDate" style="width:55px;">										
																			<option value=""> - - </option>
																			<?
																			foreach ($yearname as $value) {
																			?>
																				<option value="<?=$value?>" <? if(isset($txtYearTo1) && ($value==$txtYearTo1)){echo "selected";}else{echo "";}?>><?=$value?></option>
																			<?
																			}
																			?>
																		</select>															
																	</td>
																	<td align="right"><a href="JavaScript:find_cal(<?php echo time()?>,'To1');"><img src="images/calender.gif" alt="calendar" /></a></td>
																</tr>
															</table>
															<span class="pdError1" id="txtDateToErrorId"></span>														</td>
													</tr>
												</table>
											</td>
										</tr>
                                        <tr>
                                            <td colspan="2" align="right" valign="top" class="header">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td align="right" valign="bottom" colspan="2">
                                                            <a href="admin-site-variables.php?sec=disc" style="text-decoration: none;"><img src="images/cancelN.png" alt="Cancel" border="0" height="21" width="66"></a>&nbsp;<a href="javascript:void(0);" onclick="frmValidateAddPromo();" style="text-decoration:none;"><img src="images/saveChangesN.png" alt="Save Approve" width="108" height="21" border="0" /></a>
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
			case 'promoid':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$promoiddr 			= 0;
					$promocatdr 		= 1;
					$promocodedr		= 1;
					$promotakeupdr 		= 1;
					$promoexpirydatedr 	= 1;
					$promostatusdr 		= 1;
				} else {
					$dr = "DESC";
					$promoiddr 			= 1;
					$promocatdr 		= 1;
					$promocodedr		= 1;
					$promotakeupdr 		= 1;
					$promoexpirydatedr 	= 1;
					$promostatusdr 		= 1;
				}
				$strQuery .= " A.promo_id ".$dr;
			break;
			case 'promocat':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$promoiddr 			= 1;
					$promocatdr 		= 0;
					$promocodedr		= 1;
					$promotakeupdr 		= 1;
					$promoexpirydatedr 	= 1;
					$promostatusdr 		= 1;
				} else {
					$dr = "DESC";
					$promoiddr 			= 1;
					$promocatdr 		= 1;
					$promocodedr		= 1;
					$promotakeupdr 		= 1;
					$promoexpirydatedr 	= 1;
					$promostatusdr 		= 1;
				}
				$strQuery .= " A.promo_cat_ids ".$dr;
			break;
			case 'promocode':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$promoiddr 			= 1;
					$promocatdr 		= 1;
					$promocodedr		= 0;
					$promotakeupdr 		= 1;
					$promoexpirydatedr 	= 1;
					$promostatusdr 		= 1;
				} else {
					$dr = "DESC";
					$promoiddr 			= 1;
					$promocatdr 		= 1;
					$promocodedr		= 1;
					$promotakeupdr 		= 1;
					$promoexpirydatedr 	= 1;
					$promostatusdr 		= 1;
				}
				$strQuery .= " A.promo_code ".$dr;
			break;
			case 'promotakeup':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$promoiddr 			= 1;
					$promocatdr 		= 1;
					$promocodedr		= 1;
					$promotakeupdr 		= 0;
					$promoexpirydatedr 	= 1;
					$promostatusdr 		= 1;
				} else {
					$dr = "DESC";
					$promoiddr 			= 1;
					$promocatdr 		= 1;
					$promocodedr		= 1;
					$promotakeupdr 		= 1;
					$promoexpirydatedr 	= 1;
					$promostatusdr 		= 1;
				}
				$strQuery .= " A.promo_takeup ".$dr;
			break;
			case 'promoexpirydate':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$promoiddr 			= 1;
					$promocatdr 		= 1;
					$promocodedr		= 1;
					$promotakeupdr 		= 1;
					$promoexpirydatedr 	= 0;
					$promostatusdr 		= 1;
				} else {
					$dr = "DESC";
					$promoiddr 			= 1;
					$promocatdr 		= 1;
					$promocodedr		= 1;
					$promotakeupdr 		= 1;
					$promoexpirydatedr 	= 1;
					$promostatusdr 		= 1;
				}
				$strQuery .= " A.promo_end_date ".$dr;
			break;
			case 'promostatus':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$promoiddr 			= 1;
					$promocatdr 		= 1;
					$promocodedr		= 1;
					$promotakeupdr 		= 1;
					$promoexpirydatedr 	= 1;
					$promostatusdr 		= 0;
				} else {
					$dr = "DESC";
					$promoiddr 			= 1;
					$promocatdr 		= 1;
					$promocodedr		= 1;
					$promotakeupdr 		= 1;
					$promoexpirydatedr 	= 1;
					$promostatusdr 		= 1;
				}
				$strQuery .= " A.active ".$dr;
			break;
		}
	} else {
		$promoiddr 			= 1;
		$promocatdr 		= 1;
		$promocodedr		= 1;
		$promotakeupdr 		= 1;
		$promoexpirydatedr 	= 1;
		$promostatusdr 		= 1;
	}

	$promoListArr = $promoObj->fun_getPendingApprovalPromosArr($strQuery);
//	print_r($promoListArr);
	if(count($promoListArr) > 0){
	?>
		<script language="javascript" type="text/javascript">
            var req = ajaxFunction();
        
            function chkFeaturedEvent(strCheckboxId){
                var eventId = document.getElementById(strCheckboxId).value;
                
                if(document.getElementById(strCheckboxId).checked == true) {
                    var url = "../eventFeaturedXml.php?evtid="+eventId+"&featured=1";
                } else {
                    var url = "../eventFeaturedXml.php?evtid="+eventId+"&featured=0";
                }
                req.onreadystatechange = handleEventFeatureResponse;
                req.open("GET", url); 
                req.send(null);   
            }
        
            function handleEventFeatureResponse(){
                var arrayOfEventFeature 	= new Array();
                if(req.readyState == 4){
                    var response=req.responseText;
                    xmlDoc=req.responseXML;
                    var root = xmlDoc.getElementsByTagName('events')[0];
                    if(root != null){
                        var items = root.getElementsByTagName("event");
                        for (var i = 0 ; i < items.length ; i++){
                            var item 				= items[i];
                            var eventfeature 		= item.getElementsByTagName("eventfeature")[0].firstChild.nodeValue;
                            arrayOfEventFeature[i] 	= eventfeature;
                            if(arrayOfEventFeature[i] == "Event updated."){
                                window.location = 'admin-site-variables.php?sec=disc';
                            }
                        }
                    }
                }
            }
        </script>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td valign="top" class="SectionSubHead"><?php echo $addtitle;?></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td valign="top"><a href="admin-site-variables.php?sec=disc&subsec=adddisc" title="Add Promotional code"><img src="images/add-new-promo-code.png" alt="Add Travel Guide" width="148" height="21" /></a></td>
                <td align="right" valign="top">
                    <form name="frmSearchPromo" id="frmSearchPromo" action="admin-site-variables.php?sec=disc" method="post">
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td class="blackTxt14 pad-rgt5">Search </td>
                            <td class="pad-rgt5"><input name="txtSearchPromo" id="txtSearchPromoId" type="text" class="Textfield210" value="Enter promo code" onclick="return bnkPromoSearch();" onblur="return restorePromoSearch();" autocomplete="off" /></td>
                            <td><a href="#"><img src="images/search-btn.gif" alt="Send"/></a></td>
                        </tr>
                    </table>
                    </form>
                </td>
            </tr>
            <tr><td  colspan="2" valign="top" class="blueBotBorder"><img src="images/spacer.gif" height="8" alt="One" /></td></tr>
<!--
			<tr>
				<td valign="top">Display 11-20 of 230</td>
				<td align="right" valign="top" class="Paging"><a href="#">First</a> <a href="#">&lt;</a> <a href="#">1</a> | 2 | <a href="#">3</a> | <a href="#">4</a> | <a href="#">5</a> | <a href="#">6</a> | <a href="#">7</a> | <a href="#">8</a> | <a href="#">9</a> | <a href="#">10</a>...<a href="#">23</a> <a href="#">&gt;</a> <a href="#">Last</a></td>
			</tr>
-->
			<tr><td colspan="2" valign="top">&nbsp;</td></tr>
			<tr>
				<td colspan="2" valign="top">
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EventListing">
						<thead>
							<tr>
								<th width="10%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-site-variables.php?sec=disc&sortby=promoid&dr=".$promoiddr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "promoid")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?> ><div>ID</div></th>
								<th width="15%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-site-variables.php?sec=disc&sortby=promocat&dr=".$promocodedr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "promocat")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?> ><div>Promo type</div></th>
								<th width="10%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-site-variables.php?sec=disc&sortby=promocode&dr=".$promocatdr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "promocode")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Promo code</div></th>
								<th width="15%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-site-variables.php?sec=disc&sortby=promotakeup&dr=".$promotakeupdr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "promotakeup")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Description</div></th>
								<th width="10%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-site-variables.php?sec=disc&sortby=promotakeup&dr=".$promotakeupdr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "promotakeup")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Number</div></th>
								<th width="10%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-site-variables.php?sec=disc&sortby=promotakeup&dr=".$promotakeupdr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "promotakeup")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Take up</div></th>
								<th width="10%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-site-variables.php?sec=disc&sortby=promoexpirydate&dr=".$promoexpirydatedr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "promoexpirydate")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Start Date</div></th>
								<th width="10%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-site-variables.php?sec=disc&sortby=promoexpirydate&dr=".$promoexpirydatedr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "promoexpirydate")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>End Date</div></th>
								<th width="10%" scope="col" class="right" onmouseover="this.className = 'rightOver';" onclick="sortList('<?php echo "admin-site-variables.php?sec=disc&sortby=promostatus&dr=".$promostatusdr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "promostatus")){echo "class=\"rightOver\" onmouseout=\"this.className = 'rightOver';\" ";}else{echo "onmouseout=\"this.className = 'right';\"";}?>><div>Active</div></th>
							</tr>
						</thead>
						<tbody>
							<?php
                            for($i=0; $i < count($promoListArr); $i++){
								$promo_id 			= $promoListArr[$i]['promo_id'];
								$promo_cat_ids 		= $promoListArr[$i]['promo_cat_ids'];
								$promo_code 		= $promoListArr[$i]['promo_code'];
								$promo_description 	= $promoListArr[$i]['promo_description'];
								$promo_takeup 		= $promoListArr[$i]['promo_takeup']; // total number
								$user_takeup 		= $promoObj->fun_countPromoUserCode($promo_code); // total takeup by users
								$promo_start_date	= $promoListArr[$i]['promo_start_date'];
								$promo_end_date		= $promoListArr[$i]['promo_end_date'];
								$start_date 		= date('M d, Y', strtotime($promo_start_date));
								$end_date 			= date('M d, Y', strtotime($promo_end_date));
								$active 			= $promoListArr[$i]['active'];
								if($active == "1") {
									$txtactive = "Yes";
								} else {
									$txtactive = "No";
								}
                            ?>
                                <tr>
                                    <td class="left"><a href="admin-site-variables.php?sec=disc&subsec=editdisc&promoid=<?php echo $promo_id;?>"><?php echo fill_zero_left($promo_id, "0", (6-strlen($promo_id))); ?></a></td>
                                    <td><?php echo $promoObj->fun_getPromoCatNameByCatIdsWithNL($promo_cat_ids); ?></td>
                                    <td><?php echo $promo_code;?></td>
                                    <td><?php echo $promo_description;?></td>
                                    <td><?php echo $promo_takeup;?></td>
                                    <td align="center"><?php echo $user_takeup;?></td>
                                    <td align="center"><?php echo $start_date;?></td>
                                    <td align="center"><?php echo $end_date;?></td>
                                    <td class="right"><?php echo ucfirst($txtactive);?></td>
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
                <td valign="top" class="SectionSubHead"><?php echo $addtitle;?></td>
                <td>&nbsp;</td>
            </tr>
			<tr>
				<td valign="top">No promocode Added!<br /><br /><a href="admin-site-variables.php?sec=disc&subsec=adddisc" title="Add Promotional code"><img src="images/add-new-promo-code.png" alt="Add Promotional code" width="148" height="21" /></a></td>
			</tr>
		</table>
		<?php
	}
}
?>