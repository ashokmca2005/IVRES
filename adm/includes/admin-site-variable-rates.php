<?php
// Form submision
$detail_array 	= array();
$error_msg		= 'no';

if($_POST['securityKey']==md5(SCHEDULEDELETE)){
	$productObj->fun_delScheduledChangeRate();
	echo "<script>location.href = 'admin-site-variables.php?sec=rate';</script>";
}

if($_POST['securityKey'] == md5(ADDSITERATE)){
	$productRateArr = array_combine($_POST['txtProduct'], $_POST['txtProductRate']);
	if(isset($_POST['txtMakeSchdule']) && $_POST['txtMakeSchdule'] == "1") {
		$txtDayHour 	= $_POST['txtDayHour'];
		$txtDayMinute 	= $_POST['txtDayMinute'];
		$txtDayFrom1 	= $_POST['txtDayFrom1'];
		$txtMonthFrom1 	= $_POST['txtMonthFrom1'];
		$txtYearFrom1 	= $_POST['txtYearFrom1'];
		$schedule_on 	= mktime($txtDayHour, $txtDayMinute, 0, $txtMonthFrom1, $txtDayFrom1, $txtYearFrom1);
		$productObj->fun_scheduleProductsRate($productRateArr, $schedule_on);
		echo "<script>location.href = 'admin-site-variables.php?sec=rate';</script>";
	} else {
		$productObj->fun_editProductsRate($productRateArr);
		echo "<script>location.href = 'admin-site-variables.php?sec=rate';</script>";
	}
}
?>
<?php
$minutename = array('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33','34','35','36','37','38','39','40','41','42','43','44','45','46','47','48','49','50','51','52','53','54','55','56','57','58','59');
$hourname 	= array('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23');
$dayname 	= array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');
$monthname 	= array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec');
$yearname 	= array(date('Y')+0,date('Y')+1,date('Y')+2,date('Y')+3);
$productInfoArr 	= $productObj->fun_getProductRateInfoArr();
?>
<script language="javascript" type="text/javascript">
	var req = ajaxFunction();
	var x1 = "";
	var y1 = "";

	function frmValidateAddSiteRate() {
		var shwError = false;
		if(document.getElementById("txtMakeSchduleId2").checked == true) {
			if(document.frmAddRates.txtDayFrom1.value == "") {
				document.getElementById("txtSchduleDateErrorId").innerHTML = "Please select a date!";
				document.frmAddRates.txtDayFrom1.focus();
				shwError = true;
			} else if(document.frmAddRates.txtMonthFrom1.value == "") {
				document.getElementById("txtSchduleDateErrorId").innerHTML = "Please select a date!";
				document.frmAddRates.txtMonthFrom1.focus();
				shwError = true;
			} else if(document.frmAddRates.txtYearFrom1.value == "") {
				document.getElementById("txtSchduleDateErrorId").innerHTML = "Please select a date!";
				document.frmAddRates.txtYearFrom1.focus();
				shwError = true;
			}
		}
		if(shwError == true) {
			return false;
		} else {
			document.frmAddRates.submit();
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

	function showNextSchedule(strScheduleOn) {
		var newWin = window.open("admin-site-rate-shedule-view.php?schduleon="+ strScheduleOn +"","HTML",'dependent=1,toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,top=50,left=50,width=600,height=300');
		newWin.window.focus();
	}

	function showSiteRateHistory() {
		var newWin = window.open("admin-site-rate-history-view.php","HTML",'dependent=1,toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,top=50,left=50,width=600,height=400');
		newWin.window.focus();
	}

	function sbmtScheduleDelete(){
		document.getElementById("securityKey").value = "<?php echo md5('SCHEDULEDELETE')?>";
		document.frmAddRates.submit();
	}
</script>
<form name="frmAddRates" id="frmAddRates" action="admin-site-variables.php?sec=rate" method="post">
<input type="hidden" name="securityKey" id="securityKey" value="<?php echo md5("ADDSITERATE")?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr><td class="SectionSubHead pad-btm12"><?php echo $addtitle;?></td></tr>
	<tr><td valign="top"><?php $productObj->fun_createSchedulePriceChange(); ?></td></tr>
    <tr><td>&nbsp;</td></tr>
	<tr>
		<td valign="top" class="adminRates" style="padding-top:5px;">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td colspan="2" valign="top">
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td valign="top" class="pad-lft20 pad-top13">
									<div class="FloatLft blackTxt14">Make changes</div>
									<div class="FloatLft pad-lft15"><input name="txtMakeSchdule" type="radio" class="radio1" id="txtMakeSchduleId1" value="0" onclick="hideField('tblShwDateId');void(0);" checked="checked" /><span class="blackTxt14"> Immediately</span></div>
									<div class="FloatLft pad-lft15"><input name="txtMakeSchdule" type="radio" class="radio1" id="txtMakeSchduleId2" value="1" onclick="showField('tblShwDateId');void(0);"  /><span class="blackTxt14"> Scheduled</span></div>
								</td>
							</tr>
							<tr>
								<td valign="top" class="pad-lft20 pad-top15">
									<table id="tblShwDateId" border="0" cellpadding="0" cellspacing="0" class="blackText" style="display:none;">
										<tr>
											<td valign="middle" class="blackTxt14">Changes take effect</td>
											<td valign="middle" class="pad-lft10 blackText">at </td>
											<td valign="middle" class="pad-left7">
												<select name="txtDayHour" id="txtDayHour" class="Listmenu45">
													<?
													foreach($hourname as $value) {
													?>
														<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
													<?
													}
													?>
												</select>															
											</td>
											<td valign="middle"  class="pad-lft5">
												<select name="txtDayMinute" id="txtDayMinute" class="Listmenu45">
													<?
													foreach($minutename as $value) {
													?>
														<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
													<?
													}
													?>
												</select>															
											</td>

											<td valign="middle" class="pad-lft10 pad-rgt5">on</td>
											<td valign="middle">
												<span class="pad-left7">
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
												</span>
											</td>
											<td valign="middle" class="pad-lft5">
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
											<td valign="middle"  class="pad-lft5">
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
											<td valign="middle"  class="pad-lft5"><a href="JavaScript:find_cal(<?php echo time()?>,'From1');"><img src="images/calender.gif" alt="calendar" /></a></td>
										</tr>
									</table>
									<span class="pdError1" id="txtSchduleDateErrorId"></span>
								</td>
							</tr>
							<tr>
								<td valign="top" class="pad-lft20 pad-top15"><a href="admin-site-variables.php?sec=rate" style="text-decoration:none;"><img src="images/cancel-admin.png" alt="Cancel"/></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="frmValidateAddSiteRate();" style="text-decoration:none;"><img src="images/save-changes-admin.png" alt="Save Changes"/></a></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
    <tr><td>&nbsp;</td></tr>
	<tr>
		<td valign="top">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableRates">
				<tr>
					<th align="left"><a href="javascript: showSiteRateHistory();" class="blue-link" style="font-weight:normal;">view history</a></th>
					<th>&nbsp;</th>
					<th align="right" class="blackTxt14 pad-rgt5">USD</th>
				</tr>
				<?php
				for($i = 0; $i < count($productInfoArr); $i++) {
					$products_id 	= $productInfoArr[$i]['products_id'];
					$products_name 	= $productInfoArr[$i]['products_name'];
					if($products_name == "Featured property listing") {
						$products_name = "Featured property listing (per week)";
					} else if($products_name == "Late deal") {
						$products_name = "Late deal (per month)";
					}
					$products_price = $productInfoArr[$i]['products_price'];
					echo "<tr>";
					echo "<td colspan=\"2\" class=\"pad-top7 blackTxt14 pad-btm7\">".ucfirst($products_name)."</td>";
					echo "<td width=\"90\" align=\"right\" class=\"pad-top7 pad-rgt5 pad-btm7\">";
					echo "<input name=\"txtProduct[]\" type=\"hidden\" value=\"".$products_id."\" />";
					echo "<input name=\"txtProductRate[]\" type=\"text\" value=\"".$products_price."\" class=\"Textfield75\" />";
					echo "</td>";
					echo "</tr>";
				}
				?>
			</table>
		</td>
	</tr>
	<tr>
		<td align="right" valign="top" class="pad-top13 pad-rgt5 blueBotBorder pad-btm10">
			<div class="FloatRgt" style="display:block">
				<div class="FloatLft pad-rgt10 blackText font11">Indicates a change has been made</div>
				<div class="ratesBoxChanged FloatLft">000.00</div>
			</div>
		</td>
	</tr>
    <tr><td>&nbsp;</td></tr>

</table>
</form>