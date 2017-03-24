<?php
// Form submision
$detail_array 	= array();
$error_msg		= 'no';

if($_POST['securityKey']==md5(REVIEWDELETE)){
	if($_GET['sec'] == 'hotprop') {
		$property_hot_id = $_GET['hotpid'];
		$propertyObj->fun_delPropertyFeatured($property_hot_id);
		echo "<script> location.href='admin-pending-approval.php?sec=hotprop';</script>";
	}
}

if($_POST['securityKey']==md5(ADDHOTPROPERTY)){		
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
	if(($_POST['txtWeeks'] == '')){
		$error_msg	= 'yes';
	} else {
		$txtWeeks = $_POST['txtWeeks'];
	}
	if($error_msg == 'no') {
		$txtPropertyHotId 		= $_POST['txtPropertyHotId'];
		$txtPropertyId 			= $_POST['txtPropertyId'];
		$txtStartDate 			= $txtYearFrom0."-".$txtMonthFrom0."-".$txtDayFrom0;
		$txtPropertyHotStatusId = $_POST['txtPropertyHotStatusId'];
	
		$propertyObj->fun_editHotProperty($txtPropertyHotId, $txtPropertyId, $txtStartDate, $txtWeeks, $txtPropertyHotStatusId);
		echo "<script>location.href = window.location;</script>";
	} else {
		$detail_array['error_msg'] = "Please submit your form again!";
	}
}

if(isset($property_hot_id) && $property_hot_id !=""){
$dayname 	= array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');
$monthname 	= array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec');
$yearname 	= array(date('Y')+0,date('Y')+1,date('Y')+2,date('Y')+3);

$hotpropertyInfoArr 	= $propertyObj->fun_getHotPropertyInfo($property_hot_id);
//print_r($hotpropertyInfoArr);

?>
<script language="javascript" type="text/javascript">
	var req = ajaxFunction();
	function frmValidateAddHotProperty() {
		var shwError = false;
		if(document.frmAddHotProperty.txtWeeks.value == "") {
			document.getElementById("txtWeeksErrorId").innerHTML = "Please enter weeks.";
			document.frmAddHotProperty.txtWeeks.focus();
			shwError = true;
		}
		if(document.frmAddHotProperty.txtDayFrom0.value == "") {
			document.getElementById("txtDateFromErrorId").innerHTML = "Please select a start date!";
			document.frmAddHotProperty.txtDayFrom0.focus();
			shwError = true;
		} else if(document.frmAddHotProperty.txtMonthFrom0.value == "") {
			document.getElementById("txtDateFromErrorId").innerHTML = "Please select a start date!";
			document.frmAddHotProperty.txtMonthFrom0.focus();
			shwError = true;
		} else if(document.frmAddHotProperty.txtYearFrom0.value == "") {
			document.getElementById("txtDateFromErrorId").innerHTML = "Please select a start date!";
			document.frmAddHotProperty.txtYearFrom0.focus();
			shwError = true;
		}
		if(shwError == true) {
			return false;
		} else {
			document.frmAddHotProperty.submit();
		}
	}

	/*
	* For Review pending - approval section : Start here
	*/
	function sbmtHotPropertyApproval(strId){
		var strId = strId;
		req.open('get', 'includes/ajax/admin-hotproperty-pending-approvalXml.php?hotpid=' + strId + '&mode=approve'); 
		req.onreadystatechange = handleApprovalResponse; 
		req.send(null); 
	}

	function sbmtHotPropertyDecline(strId){
		document.getElementById("showDeclineReasonId").style.display = "block";
		var strId = strId;
		req.open('get', 'includes/ajax/admin-hotproperty-pending-approvalXml.php?hotpid=' + strId + '&mode=decline'); 
		req.onreadystatechange = handleApprovalResponse; 
		req.send(null); 
	}

	function sbmtHotPropertySuspend(strId){
		var strId = strId;
		req.open('get', 'includes/ajax/admin-hotproperty-pending-approvalXml.php?hotpid=' + strId + '&mode=suspend'); 
		req.onreadystatechange = handleApprovalResponse; 
		req.send(null); 
	}

	function sbmtReviewDelete(){
		document.getElementById("securityKey").value = "<?php echo md5('REVIEWDELETE')?>";
		document.frmAddHotProperty.submit();
	}

	function handleApprovalResponse() { 
		if(req.readyState == 4){ 
			var response = req.responseText;
			xmlDoc=req.responseXML;
			var root = xmlDoc.getElementsByTagName('hotproperties')[0];
			if(root != null){
				var items = root.getElementsByTagName("hotproperty");
				var item = items[0];
				var hotpropertystatus = item.getElementsByTagName("hotpropertystatus")[0].firstChild.nodeValue;
				if(hotpropertystatus == "Approved"){
					document.getElementById("txtAdminOptionId").innerHTML 	= "<font color='#FFFFFF' size='2'><strong>"+hotpropertystatus+"</strong></font>";
				} else if(hotpropertystatus == "Declined"){
					document.getElementById("txtAdminOptionId").innerHTML 	= "<font color='#FFFFFF' size='2'><strong>"+hotpropertystatus+"</strong></font>";
				} else if(hotpropertystatus == "Suspended"){
					document.getElementById("txtAdminOptionId").innerHTML 	= "<font color='#FFFFFF' size='2'><strong>"+hotpropertystatus+"</strong></font>";
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
</script>
<form name="frmAddHotProperty" id="frmAddHotProperty" action="admin-pending-approval.php?sec=hotprop&hotpid=<?php echo $hotpropertyInfoArr['property_hot_id']; ?>" method="post">
<input type="hidden" name="securityKey" id="securityKey" value="<?php echo md5("ADDHOTPROPERTY")?>">
<input type="hidden" name="txtPropertyHotId" id="txtPropertyHotId" value="<?php echo $hotpropertyInfoArr['property_hot_id']; ?>">
<input type="hidden" name="txtPropertyId" id="txtPropertyId" value="<?php echo $hotpropertyInfoArr['property_id']; ?>">
<input type="hidden" name="txtPropertyHotStatusId" id="txtPropertyHotStatusId" value="<?php echo $hotpropertyInfoArr['status']; ?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr><td height="10" colspan="2" valign="top">&nbsp;</td></tr>
    <tr>
        <td valign="top"><a href="admin-pending-approval.php?sec=hotprop" class="back">Back to List</a></td>
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
															if($hotpropertyInfoArr['status'] == "0" || $hotpropertyInfoArr['status'] == "1" || $hotpropertyInfoArr['status'] == "3" || $hotpropertyInfoArr['status'] == "4") {
														?>
															<a href="javascript:showField('txtshwRjctTblId');" style="text-decoration:none;"><img src="images/rejectN.png" alt="Delete" width="71" height="21" border="0" /></a>&nbsp;<a href="javascript:sbmtHotPropertyApproval(<?php echo $hotpropertyInfoArr['property_hot_id']; ?>);" style="text-decoration:none;"><img src="images/approveN.png" alt="Approve" width="71" height="21" border="0" /></a>
														<?php
															} else {
														?>
															<a href="javascript:sbmtReviewDelete();" style="text-decoration:none;"><img src="images/DeleteN.png" alt="Delete" width="60" height="21" /></a>&nbsp;<a href="javascript:sbmtHotPropertySuspend(<?php echo $hotpropertyInfoArr['property_hot_id']; ?>);" style="text-decoration:none;"><img src="images/suspendN.png" alt="Suspend" width="74" height="21" /></a>
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
                                                        <td>
                                                            Reference ID : <?php echo fill_zero_left($hotpropertyInfoArr['property_hot_id'], "0", (6-strlen($hotpropertyInfoArr['property_hot_id'])));?>
                                                        </td>
                                                        <td align="right" valign="bottom"><a href="admin-pending-approval.php?sec=hotprop" style="text-decoration:none;"><img src="images/cancelChangesN.png" alt="Cancel" width="119" height="21" border="0" /></a>&nbsp;<a href="javascript:void(0);" onclick="frmValidateAddHotProperty();" style="text-decoration:none;"><img src="images/saveChangesN.png" alt="Save Approve" width="108" height="21" border="0" /></a></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
															<?php
															if(($propertyObj->fun_checkPropertyProductPayments("3", $hotpropertyInfoArr['property_id']) == true)) {
																echo "<strong>Payment : Paid</strong>";
															} else {
																echo "<strong>Payment : Unpaid</strong>";
															}
															?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            Property reference : <strong><?php echo fill_zero_left($hotpropertyInfoArr['property_id'], "0", (6-strlen($hotpropertyInfoArr['property_id']))).": ".ucfirst($propertyObj->fun_getPropertyName($hotpropertyInfoArr['property_id'])); ?></strong>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td height="23"  align="right" valign="top" class="admleftBg">Property name</td>
                                            <td  valign="top"><strong><?php echo ucfirst($hotpropertyInfoArr['property_name']); ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td height="23"  align="right" valign="top" class="admleftBg">Show on the site from</td>
                                            <td  valign="top">
												<?php
                                                    if(isset($hotpropertyInfoArr['start_date']) && ($hotpropertyInfoArr['start_date'] != "")) {
														list($txtYearFrom0, $txtMonthFrom0, $txtDayFrom0) = split("-", trim($hotpropertyInfoArr['start_date']));
                                                    }
                                                ?>
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
                                            <td height="23"  align="right" valign="top" class="admleftBg">For how many months</td>
                                            <td  valign="top">
                                                <select name="txtWeeks" id="txtWeeksId" class="PricesDate">
                                                    <?
                                                    for($k = 1; $k <= 52; $k++) {
                                                    ?>
                                                        <option value="<?=$k?>" <? if(isset($hotpropertyInfoArr['total_weeks']) && ($k==$hotpropertyInfoArr['total_weeks'])){echo "selected";}?>><?=($k)?></option>
                                                    <?
                                                    }
                                                    ?>
                                                </select>
                                                <span class="pdError1" id="txtWeeksErrorId"></span>                                            
                                            </td>
                                        </tr>
										<tr>
											<td colspan="2" align="right" valign="top" class="header">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td>
                                                            Reference ID : <?php echo fill_zero_left($hotpropertyInfoArr['property_hot_id'], "0", (6-strlen($hotpropertyInfoArr['property_hot_id'])));?>
                                                        </td>
                                                        <td align="right" valign="bottom"><a href="admin-pending-approval.php?sec=hotprop" style="text-decoration:none;"><img src="images/cancelChangesN.png" alt="Cancel" width="119" height="21" border="0" /></a>&nbsp;<a href="javascript:void(0);" onclick="frmValidateAddHotProperty();" style="text-decoration:none;"><img src="images/saveChangesN.png" alt="Save Approve" width="108" height="21" border="0" /></a></td>
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
			case 'hotpropcode':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$hotpropcodedr 		= 0;
					$hotproptitledr		= 1;
					$hotproplivedr 		= 1;
					$hotpropexpirydr 	= 1;
					$hotpropweekdr 		= 1;
					$hotpropstatusdr 	= 1;
				} else {
					$dr = "DESC";
					$hotpropcodedr 		= 1;
					$hotproptitledr		= 1;
					$hotproplivedr 		= 1;
					$hotpropexpirydr 	= 1;
					$hotpropweekdr 		= 1;
					$hotpropstatusdr 	= 1;
				}
				$strQuery .= " A.property_id ".$dr;
			break;
			case 'hotproptitle':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$hotpropcodedr 		= 1;
					$hotproptitledr		= 0;
					$hotproplivedr 		= 1;
					$hotpropexpirydr 	= 1;
					$hotpropweekdr 		= 1;
					$hotpropstatusdr 	= 1;
				} else {
					$dr = "DESC";
					$hotpropcodedr 		= 1;
					$hotproptitledr		= 1;
					$hotproplivedr 		= 1;
					$hotpropexpirydr 	= 1;
					$hotpropweekdr 		= 1;
					$hotpropstatusdr 	= 1;
				}
				$strQuery .= " C.property_name ".$dr;
			break;
			case 'hotproplive':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$hotpropcodedr 		= 1;
					$hotproptitledr		= 1;
					$hotproplivedr 		= 0;
					$hotpropexpirydr 	= 1;
					$hotpropweekdr 		= 1;
					$hotpropstatusdr 	= 1;
				} else {
					$dr = "DESC";
					$hotpropcodedr 		= 1;
					$hotproptitledr		= 1;
					$hotproplivedr 		= 1;
					$hotpropexpirydr 	= 1;
					$hotpropweekdr 		= 1;
					$hotpropstatusdr 	= 1;
				}
				$strQuery .= " A.start_date ".$dr;
			break;
			case 'hotpropexpiry':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$hotpropcodedr 		= 1;
					$hotproptitledr		= 1;
					$hotproplivedr 		= 1;
					$hotpropexpirydr 	= 0;
					$hotpropweekdr 		= 1;
					$hotpropstatusdr 	= 1;
				} else {
					$dr = "DESC";
					$hotpropcodedr 		= 1;
					$hotproptitledr		= 1;
					$hotproplivedr 		= 1;
					$hotpropexpirydr 	= 1;
					$hotpropweekdr 		= 1;
					$hotpropstatusdr 	= 1;
				}
				$strQuery .= " (A.start_date + INTERVAL A.total_weeks WEEK) ".$dr;
			break;
			case 'hotpropweek':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$hotpropcodedr 		= 1;
					$hotproptitledr		= 1;
					$hotproplivedr 		= 1;
					$hotpropexpirydr 	= 1;
					$hotpropweekdr 		= 0;
					$hotpropstatusdr 	= 1;
				} else {
					$dr = "DESC";
					$hotpropcodedr 		= 1;
					$hotproptitledr		= 1;
					$hotproplivedr 		= 1;
					$hotpropexpirydr 	= 1;
					$hotpropweekdr 		= 1;
					$hotpropstatusdr 	= 1;
				}
				$strQuery .= " A.total_weeks ".$dr;
			break;
			case 'hotpropstatus':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$hotpropcodedr 		= 1;
					$hotproptitledr		= 1;
					$hotproplivedr 		= 1;
					$hotpropexpirydr 	= 1;
					$hotpropweekdr 		= 1;
					$hotpropstatusdr 	= 0;
				} else {
					$dr = "DESC";
					$hotpropcodedr 		= 1;
					$hotproptitledr		= 1;
					$hotproplivedr 		= 1;
					$hotpropexpirydr 	= 1;
					$hotpropweekdr 		= 1;
					$hotpropstatusdr 	= 1;
				}
				$strQuery .= " A.status ".$dr;
			break;
		}
	} else {
		$hotpropcodedr 		= 1;
		$hotproptitledr		= 1;
		$hotproplivedr 		= 1;
		$hotpropexpirydr 	= 1;
		$hotpropweekdr 		= 1;
		$hotpropstatusdr 	= 1;
	}

	$hotpropArr				= $propertyObj->fun_getPendingApprovalHotPropertyArr($strQuery);
	if(is_array($hotpropArr) && count($hotpropArr) > 0){
	?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr><td colspan="2" valign="top">&nbsp;</td></tr>
			<tr>
				<td colspan="2" valign="top">
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EventListing">
						<thead>
							<tr>
								<th width="10%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=hotprop&sortby=hotpropcode&dr=".$hotpropcodedr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "hotpropcode")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?> ><div>Prop ID</div></th>
								<th width="30%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=hotprop&sortby=hotproptitle&dr=".$hotproptitledr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "hotproptitle")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Property Name</div></th>
								<th width="15%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=hotprop&sortby=hotproplive&dr=".$hotproplivedr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "hotproplive")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?> ><div>Live date</div></th>
								<th width="15%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=hotprop&sortby=hotpropexpiry&dr=".$hotpropexpirydr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "hotpropexpiry")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Expiry date</div></th>
								<th width="10%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=hotprop&sortby=hotpropweek&dr=".$hotpropweekdr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "hotpropweek")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>No. of weeks</div></th>
								<th width="10%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=".$sec."&sortby=update&dr=".$updatedr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "update")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Paid</div></th>
								<th width="10%" scope="col" class="right" onmouseover="this.className = 'rightOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=hotprop&sortby=hotpropstatus&dr=".$hotpropstatusdr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "hotpropstatus")){echo "class=\"rightOver\" onmouseout=\"this.className = 'rightOver';\" ";}else{echo "onmouseout=\"this.className = 'right';\"";}?>><div>Status</div></th>
							</tr>
						</thead>
						<tbody>
							<?php
                            for($i=0; $i < count($hotpropArr); $i++){
                                $property_hot_id 	= $hotpropArr[$i]['property_hot_id'];
                                $property_id 		= $hotpropArr[$i]['property_id'];
                                $start_date 		= $hotpropArr[$i]['start_date'];
                                $total_weeks		= $hotpropArr[$i]['total_weeks'];
                                $property_name 		= $propertyObj->fun_getPropertyName($property_id);
								$property_status 	= $propertyObj->fun_getPropertyStatusId($property_id);
                                $status 			= $hotpropArr[$i]['status'];
                                list($y, $m, $d) = split("-", $start_date);
								if(mktime(0, 0, 0, $m, ($d+(7*$total_weeks)), $y) > mktime(0, 0, 0, date("m"), date("d"), date("Y")) && $property_status=="2") {
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
                                    }
                                } else {
                                    $strStatus = "Expired";
                                }
                            ?>
                                <tr>
                                    <td class="left"><a href="admin-pending-approval.php?sec=hotprop&hotpid=<?php echo $property_hot_id; ?>"><?php echo fill_zero_left($property_id, "0", (6-strlen($property_id)));?></a></td>
                                    <td><?php echo $property_name; ?></td>
                                    <td><?php echo date('M j, Y', strtotime($start_date)); ?></td>
                                    <td><?php echo date('M j, Y', mktime(0, 0, 0, $m, ($d+(7*$total_weeks)), $y)); ?></td>
                                    <td><?php echo $total_weeks; ?></td>
                                    <td>
										<?php
										if(($propertyObj->fun_checkPropertyProductPayments("3", $prop_id) == true)) {
											echo "Yes";
										} else {
											echo "<span style=\"color:#FF0000;\">No</span>";
										}
										?>
									</td>
                                    <td class="right"><?php echo $strStatus; ?></td>
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
            <tr><td valign="top">No featured property added!</td></tr>
		</table>
		<?php
	}
}
?>