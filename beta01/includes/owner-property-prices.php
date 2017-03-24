<?php 
$dayname 	= array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');
$monthname 	= array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec');
$yearname 	= array(date('Y')+0,date('Y')+1,date('Y')+2,date('Y')+3);
$stayname 	= array('01','02','03','04','05','06','07','08','09','10','11','12','13','14');

$propertyPricesArr 	= $propertyObj->fun_getPropertyPricesArr($property_id);
$currency_id 		= $propertyObj->fun_findPropertyCurrencyCode($property_id);
$price_type 		= $propertyObj->fun_findPropertyPriceCode($property_id);

$currencySymbol		= $propertyObj->fun_findPropertyCurrencySymbol($property_id, '');
$currencyRateArr	= $propertyObj->fun_findPropertyCurrencyRate();

if(isset($_GET['edit']) && $_GET['edit'] != "") {
	$property_price_id = $_GET['edit'];
	foreach($propertyPricesArr as $vaule) {
		if($vaule['id'] == $property_price_id) {
			$e_rateName				= $vaule['price_name'];
			$e_minStay				= $vaule['min_stay'];
			$e_stayType 			= $vaule['min_stay_type'];
			$e_perMonthPrice		= $vaule['per_month_price'];
			$e_perWeekPrice 		= $vaule['per_week_price'];
			$e_perNightMidweekPrice = $vaule['per_night_midweek_price'];
			$e_perNightWeekendPrice = $vaule['per_night_weekend_price'];
			$e_specialOffer 		= $vaule['special_offer'];
			$e_rateType				= $vaule['price_type'];

			list($txtMonthFrom, $txtDayFrom, $txtYearFrom) = split('[/.-]', date('m-d-Y', $vaule['date_from']));			
			list($txtMonthTo, $txtDayTo, $txtYearTo) = split('[/.-]', date('m-d-Y', $vaule['date_to']));
			$dateFromUnix 			= mktime(0, 0, 0, $txtMonthFrom, $txtDayFrom, $txtYearFrom);
			$dateToUnix	 			= mktime(0, 0, 0, $txtMonthTo, $txtDayTo, $txtYearTo);
			$dateFrom 				= date('m/d/Y', $vaule['date_from']);
			$dateTo 				= date('m/d/Y', $vaule['date_to']);
		}
	}
}

?>
<!-- TinyMCE -->
<script type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		mode : "exact",
		elements : "txtPriceNotesId, txtOwnerNotesId",
		theme : "simple",
		plugins : 'advlink,advimage',
		relative_urls : false,
		remove_script_host : false
	});
</script>
<!-- /TinyMCE -->
<script language="javascript">
// JavaScript Document
//	var req = ajaxFunction();
	var x1 = "";
	var y1 = "";

	function find_cal(a,ct){
		var url="get_cal.php";

		var strDayId = "txtDay"+ct;
		var strMonthId = "txtMonth"+ct;
		var strYearId = "txtYear"+ct;

		var mnt_cal = document.getElementById(strMonthId).value;
		var day_cal = document.getElementById(strDayId).value;
		var yr_cal  = document.getElementById(strYearId).value;
		
		if(mnt_cal != "" && day_cal != "" && yr_cal != "") {
			url=url+"?mnt_cal="+mnt_cal+"&day_cal="+day_cal+"&yr_cal="+yr_cal+"&timestamp="+a+"&ct="+ct;
		} else {
			url=url+"?timestamp="+a+"&ct="+ct;
		}

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
		var url="get_cal.php";

		var strDayId = "txtDay"+ct;
		var strMonthId = "txtMonth"+ct;
		var strYearId = "txtYear"+ct;

		var mnt_cal = document.getElementById(strMonthId).value;
		var day_cal = document.getElementById(strDayId).value;
		var yr_cal  = document.getElementById(strYearId).value;
		
		if(mnt_cal != "" && day_cal != "" && yr_cal != "") {
			url=url+"?mnt_cal="+mnt_cal+"&day_cal="+day_cal+"&yr_cal="+yr_cal+"&timestamp="+a+"&ct="+ct;
		} else {
			url=url+"?timestamp="+a+"&ct="+ct;
		}

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
		var url="get_cal1.php";
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
		var url="get_cal.php";
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

		if(sid == "From") {
			fill_to_from_date();
		}
		document.getElementById("CalendarDiv").style.display = "none";
	}

	function fill_to_from_date() {
		if(document.getElementById("txtDayFrom").value != "" && document.getElementById("txtMonthFrom").value != "" && document.getElementById("txtYearFrom").value != "") {
			document.getElementById("txtDayTo").value = document.getElementById("txtDayFrom").value;
			document.getElementById("txtMonthTo").value = document.getElementById("txtMonthFrom").value;
			document.getElementById("txtYearTo").value = document.getElementById("txtYearFrom").value;
		}
	} 

	function close_calendar(){		
		document.getElementById("CalendarDiv").style.display = "none";
	}

	/*
	* For location refine : Start Here
	*/

	function addPrice(){

		var txtRateName = "txtRateName";
		var txtRateType = "txtRateType";
//		var txtDateFrom = "txtDateFrom";
//		var txtDateTo = "txtDateTo";
		var txtCurrencyType	= "txtCurrencyType";
		var txtDayFrom = "txtDayFrom";
		var txtMonthFrom = "txtMonthFrom";
		var txtYearFrom = "txtYearFrom";
		var txtDayTo = "txtDayTo";
		var txtMonthTo = "txtMonthTo";
		var txtYearTo = "txtYearTo";
		var txtMinStay = "txtMinStay";
		var txtMinStayType = "txtMinStayType";
		var txtMonthPrice = "txtMonthPrice";
		var txtWeekPrice = "txtWeekPrice";
		var txtNightMidweekPrice = "txtNightMidweekPrice";
		var txtNightWeekendPrice = "txtNightWeekendPrice";

		if(document.getElementById(txtCurrencyType).value =="0"){
			document.getElementById("priceErrorDiv").innerHTML = "Please select currency type";
			document.getElementById(txtCurrencyType).focus();
			return false;
		}

		if(document.getElementById(txtRateType).value =="0"){
			document.getElementById("priceErrorDiv").innerHTML = "Please select rate type";
			document.getElementById(txtRateType).focus();
			return false;
		}

		if(document.getElementById(txtRateName).value ==""){
			document.getElementById("priceErrorDiv").innerHTML = "Please enter rental period";
			document.getElementById(txtRateName).focus();
			return false;
		}

		/*
		if(document.getElementById(txtDateFrom).value ==""){
			document.getElementById("priceErrorDiv").innerHTML = "Please select date from";
			document.getElementById(txtDateFrom).focus();
			return false;
		}

		if(document.getElementById(txtDateTo).value ==""){
			document.getElementById("priceErrorDiv").innerHTML = "Please enter date to";
			document.getElementById(txtDateTo).focus();
			return false;
		}

		if(document.getElementById(txtDateTo).value ==""){
			document.getElementById("priceErrorDiv").innerHTML = "Please enter date to";
			document.getElementById(txtDateTo).focus();
			return false;
		}
		*/

		//if((document.getElementById(txtWeekPrice).value =="")&&(document.getElementById(txtNightMidweekPrice).value =="")&&(document.getElementById(txtNightWeekendPrice).value ==""&&(document.getElementById(txtMonthPrice).value =="")){
		//if((document.getElementById(txtWeekPrice).value =="")&&(document.getElementById(txtNightMidweekPrice).value =="")&&(document.getElementById(txtMonthPrice).value =="")){
		if(document.getElementById(txtNightMidweekPrice).value ==""){
			document.getElementById("priceErrorDiv").innerHTML = "Please enter price per night";
			document.getElementById(txtNightMidweekPrice).focus();
			return false;
		}

		if(document.getElementById(txtWeekPrice).value ==""){
			document.getElementById("priceErrorDiv").innerHTML = "Please enter price per week";
			document.getElementById(txtWeekPrice).focus();
			return false;
		}

		if(document.getElementById(txtDayFrom).value ==""){
			document.getElementById("priceErrorDiv").innerHTML = "Please select date from";
			document.getElementById(txtDayFrom).focus();
			return false;
		}
		
		if(document.getElementById(txtMonthFrom).value ==""){
			document.getElementById("priceErrorDiv").innerHTML = "Please select month from";
			document.getElementById(txtMonthFrom).focus();
			return false;
		}
		
		if(document.getElementById(txtYearFrom).value ==""){
			document.getElementById("priceErrorDiv").innerHTML = "Please select year from";
			document.getElementById(txtYearFrom).focus();
			return false;
		}
		
		if(document.getElementById(txtDayTo).value ==""){
			document.getElementById("priceErrorDiv").innerHTML = "Please select date to";
			document.getElementById(txtDayTo).focus();
			return false;
		}
		
		if(document.getElementById(txtMonthTo).value ==""){
			document.getElementById("priceErrorDiv").innerHTML = "Please select month to";
			document.getElementById(txtMonthTo).focus();
			return false;
		}
		
		if(document.getElementById(txtYearTo).value ==""){
			document.getElementById("priceErrorDiv").innerHTML = "Please select year to";
			document.getElementById(txtYearTo).focus();
			return false;
		}

		frmSubmit();
	}

	function addDelPriceId(strPriceId){
		document.getElementById("txtDelPriceId").value = strPriceId;
	}

	function removeDelPriceId(){
		document.getElementById("txtDelPriceId").value = "";
	}

	function delPrice() {
		var strPriceId = document.getElementById("txtDelPriceId").value;
		req.onreadystatechange = handleDeleteResponse;
		req.open('get', '<?php echo SITE_URL;?>pricedeleteXml.php?priceid='+strPriceId); 
		req.send(null);   
	}

	function handleDeleteResponse() {
		if(req.readyState == 4) {
			var response=req.responseText;
			xmlDoc=req.responseXML;
			var root = xmlDoc.getElementsByTagName('prices')[0];
			if(root != null) {
				var items = root.getElementsByTagName("price");
                var item = items[0];
                var pricestatus = item.getElementsByTagName("status")[0].firstChild.nodeValue;
                if(pricestatus == "Price deleted.") {
                    window.location = location.href;
                }
			}
		}
	}

	function cancelPrice(){
        location.href = "<?php echo $linkpri;?>";
    }

	function frmSubmit(){
		document.frmProperty.submit();
	}
</script>
<!--Details Content Starts Here -->
<form name="frmProperty" id="frmPropertyId" method="post" action="<?php echo $linkpri;?>">
<input type="hidden" name="securityKey" value="<?php echo md5(OWNERPROPERTYPRICES);?>" />
<input type="hidden" name="txtPriceId" id="txtPriceId" value="<?php echo $property_price_id;?>" />
<input type="hidden" name="txtDelPriceId" id="txtDelPriceId" value="" />
<div class="width690 pad-top20">
	<table width="690" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td align="left" valign="top" class="pad-btm10">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td valign="middle" align="right" width="120" class="pad-rgt5"><?php echo tranText('select_a_currency'); ?></td>
						<td valign="middle">
							<select name="txtCurrencyType" id="txtCurrencyType" class="selectBox175" >
								<option value="0">Please Select...</option>
								<?php 
								$propertyObj->fun_getCurrenciesOptionsListWithSymbl($currency_id);
								?>
							</select>
						</td>
						<td valign="middle" align="right" class="pad-rgt4"><a href="#" onclick="return frmSubmit();" class="button-blue">Save details</a></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr style="display:none">
			<td align="left" valign="top" class="pad-btm25">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td valign="middle" align="right" width="100" class="pad-rgt5">Rates are</td>
						<td valign="middle">
							<select name="txtRateType" id="txtRateType" class="selectBox175" >
								<option value="2" <?php if(isset($price_type) && ($price_type=='2')){echo "selected";} ?>>Per night</option>
								<option value="1" <?php if(isset($price_type) && ($price_type=='1')){echo "selected";} ?>>Per person per night</option>
								<option value="4" <?php if(isset($price_type) && ($price_type=='4')){echo "selected";} ?>>Per week</option>
								<option value="3" <?php if(isset($price_type) && ($price_type=='3')){echo "selected";} ?>>Per person per week</option>
							</select>
						</td>
						<td valign="middle" align="right" class="pad-rgt4">&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>

		<tr>
			<td align="left" valign="top" <?php if(isset($_GET['edit']) && $_GET['edit'] != "") { echo "style=\"background-color:#f4f4f4;\"";} ?> >
            <div id="showAddPriceFrm" class="width690 dash-top pad-top15">
                <div class="width690 <?php if(is_array($propertyPricesArr) && count($propertyPricesArr) > 0) { echo " dash-btm pad-btm20";} ?>">
                    <table width="96%" align="center" border="0" cellpadding="0" cellspacing="0">
                        <?php
                        $msg = $_GET['msg'];
                        if($msg == "delsuccess") {
                            echo "<tr>";
                            echo "<td colspan=\"3\" align=\"left\" valign=\"top\" class=\"pad-btm10\">";
                            echo "<span class=\"font16-darkgrey\">Add a rates</span>";
                            echo "</td>";
                            echo "</tr>";
                        } else if($msg == "updatesuccess") {
                            echo "<tr>";
                            echo "<td colspan=\"3\" align=\"left\" valign=\"top\" class=\"pad-btm10\">";
                            echo "<div class=\"successHeading\">Price successfully updated, <span class=\"font16-darkgrey\">add another ...</span></div>";
                            echo "</td>";
                            echo "</tr>";
                        } else if($msg == "addsuccess") {
                            echo "<tr>";
                            echo "<td colspan=\"3\" align=\"left\" valign=\"top\" class=\"pad-btm10\">";
                            echo "<div class=\"successHeading\">Price successfully updated, <span class=\"gray18Arial\">add another ...</span></div>";
                            echo "</td>";
                            echo "</tr>";
                        } else if(isset($_GET['edit']) && $_GET['edit'] != "") {
                            echo "<tr>";
                            echo "<td colspan=\"3\" align=\"left\" valign=\"top\" class=\"pad-btm10\">";
                            echo "<span class=\"font16-darkgrey\">Edit price</span>";
                            echo "</td>";
                            echo "</tr>";
                        } else {
                            echo "<tr>";
                            echo "<td colspan=\"3\" align=\"left\" valign=\"top\" class=\"pad-btm10\">";
                            echo "<span class=\"font16-darkgrey\">Add a rates</span>";
                            echo "</td>";
                            echo "</tr>";
                        }
						
						if(isset($_GET['edit']) && $_GET['edit'] != "")
							$counterBgColor = "#f4f4f4";
						else
							$counterBgColor = "#ffffff";
                        ?>
                        <tr>
                            <td class="pad-rgt5" width="89" align="right" valign="middle">Seasonal Rate</td>
                            <td width="637" colspan="2" align="left" valign="middle">
                                <span style="float:left;">
                                <input name="txtRateName" id="txtRateName" type="text" class="inpuTxt260" value="<?php if(isset($_POST['txtRateName'])){echo $_POST['txtRateName'];}else{echo $e_rateName;}?>" maxlength="35" onkeydown="limitText(this.form.txtRateName,this.form.txtNameCountdown,35);" onkeyup="limitText(this.form.txtRateName,this.form.txtNameCountdown,35);" onfocus="showField('txtNameCountdownId');" />
                                </span>
                                <span class="error" id="txtNameCountdownId" style="float:left;"><?php if(array_key_exists('txtRateName', $form_array)) {echo $form_array['txtRateName'];} else { echo "<input readonly type=\"text\" name=\"txtNameCountdown\" onfocus=\"this.form.txtRateName.focus();\" size=\"1\" value=\"".(35-strlen($e_rateName))."\" style=\"padding:0 0px 0 2px;background-color:".$counterBgColor."; top:1px; left:-1px; position:relative; text-align:left; width: 15px; border:0px solid #FFFFFF; color:#333333;\">";}?> <font color="#333333">characters remaining</font></span>
                            </td>
                        </tr>
                        <tr><td class="pad-btm10" colspan="3"></td></tr>
                    <tr>
                        <td class="pad-rgt5" width="89" align="right">Date from</td>
                        <td width="637" colspan="2" align="left" valign="top" class="pad-btm3">
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <table border="0" cellpadding="1" cellspacing="0">
                                            <tr>
                                                <td>
                                                <select name="txtDayFrom" id="txtDayFrom" class="Listmenu45" onchange="fill_to_from_date();">
                                                    <option value=""> - - </option>
                                                    <?
                                                    foreach($dayname as $key => $value)	{
                                                    ?>
                                                        <option value="<?php echo $value;?>" <? if(isset($txtDayFrom) && ($value == $txtDayFrom)){echo "selected";} else{echo "";}?>><?php echo ($key+1)?></option>
                                                    <?
                                                    }
                                                    ?>
                                                </select>										
                                                </td>
                                                <td>
                                                <select name="txtMonthFrom" id="txtMonthFrom" class="Listmenu55" onchange="fill_to_from_date();">										
                                                    <option value=""> - - </option>
                                                    <?
                                                    foreach ($monthname as $key => $value) {
                                                    ?>
                                                        <option value="<?php echo $key?>" <? if(isset($txtMonthFrom) && ($key==$txtMonthFrom)){echo "selected";} else{echo "";}?>><?php echo $value;?></option>
                                                    <?
                                                    }
                                                    ?>
                                                </select>
                                                </td>
                                                <td align="right">
                                                <select name="txtYearFrom" id="txtYearFrom" class="Listmenu60" onchange="fill_to_from_date();">
                                                    <option value=""> - - </option>
                                                    <?
                                                    foreach ($yearname as $value) {
                                                    ?>
                                                        <option value="<?php echo $value;?>" <? if(isset($txtYearFrom) && ($value==$txtYearFrom)){echo "selected";} else{echo "";}?>><?php echo $value;?></option>
                                                    <?
                                                    }
                                                    ?>
                                                </select>										
                                                </td>
                                                <td align="right"><a href="JavaScript:find_cal(<?php if(isset($dateFromUnix)) {echo $dateFromUnix;} else {echo time();} ?>, 'From');"><img src="<?php echo SITE_IMAGES;?>calender.gif" alt="calendar" /></a></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td class="pad-rgt5 pad-lft10">to</td>
                                    <td>
                                        <table border="0" cellpadding="1" cellspacing="0" class="pink12arial">
                                            <tr>
                                                <td>
                                                    <select name="txtDayTo" id="txtDayTo" class="Listmenu45">
                                                        <option value=""> - - </option>
                                                        <?
                                                        foreach($dayname as $key => $value)	{
                                                        ?>
                                                            <option value="<?php echo $value;?>" <? if(isset($txtDayTo) && ($value==$txtDayTo)){echo "selected";} else{echo "";}?>><?php echo ($key+1)?></option>
                                                        <?
                                                        }
                                                        ?>
                                                    </select>										
                                                </td>
                                                <td>
                                                    <select name="txtMonthTo" id="txtMonthTo" class="Listmenu55">										
                                                        <option value=""> - - </option>
                                                        <?
                                                        foreach ($monthname as $key => $value) {
                                                        ?>
                                                            <option value="<?php echo $key?>" <? if(isset($txtMonthTo) && ($key==$txtMonthTo)){echo "selected";} else{echo "";}?>><?php echo $value;?></option>
                                                        <?
                                                        }
                                                        ?>
                                                    </select>										
                                                </td>
                                                <td align="right">
                                                    <select name="txtYearTo" id="txtYearTo" class="Listmenu60">
                                                        <option value=""> - - </option>
                                                        <?
                                                        foreach ($yearname as $value) {
                                                        ?>
                                                            <option value="<?php echo $value;?>" <? if(isset($txtYearTo) && ($value==$txtYearTo)){echo "selected";} else{echo "";}?>><?php echo $value;?></option>
                                                        <?
                                                        }
                                                        ?>
                                                    </select>										
                                                </td>
                                                <td align="right"><a href="JavaScript:find_cal(<?php if(isset($dateToUnix)) {echo $dateToUnix;} else {echo time();} ?>,'To');"><img src="<?php echo SITE_IMAGES;?>calender.gif" alt="calendar" /></a></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td class="pad-rgt5 pad-lft10">Min stay</td>
                                    <td>
                                        <table border="0" cellpadding="1" cellspacing="0" class="pink12arial">
                                            <tr>
                                                <td>
                                                    <select name="txtMinStay" id="txtMinStay" class="Listmenu45">
                                                        <option value=""> - - </option>
                                                        <?
                                                        for($j = 1; $j <= 31; $j++) {
                                                        ?>
                                                            <option value="<?php echo $j;?>" <? if(isset($e_minStay) && ($j==$e_minStay)){echo "selected";} else{echo "";}?>><?php echo $j;?></option>
                                                        <?
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="txtMinStayType" id="txtMinStayType" class="Listmenu60">
                                                        <?php
                                                        if($e_stayType == "w"){
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
                            </table>
                        </td>
                    </tr>
					<?php /*?>
                        <tr>
                            <td class="pad-rgt5" width="89" align="right" valign="middle">Date from</td>
                            <td width="637" colspan="2" align="left" valign="middle">
                                <table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td>
                                            <input type="text" name="txtDateFrom" id="txtDateFrom" class="txtBox55" style="width:125px" value="<?php if(isset($dateFrom) && $dateFrom!="") { echo $dateFrom;} else {echo "mm/dd/yyyy";}?>">
                                        </td>
                                        <td class="pad-rgt5 pad-lft10">Date to</td>
                                        <td>
                                            <input type="text" name="txtDateTo" id="txtDateTo" class="txtBox55" style="width:125px" value="<?php if(isset($dateTo) && $dateTo!="") { echo $dateTo;} else {echo "mm/dd/yyyy";}?>">
                                        </td>
                                        <td class="pad-rgt5 pad-lft10">Min stay</td>
                                        <td>
                                            <table border="0" cellpadding="1" cellspacing="0" class="pink12arial">
                                                <tr>
                                                    <td>
                                                        <select name="txtMinStay" id="txtMinStay" class="Listmenu45">
                                                            <option value=""> - - </option>
                                                            <?
                                                            for($j = 1; $j <= 31; $j++) {
                                                            ?>
                                                                <option value="<?php echo $j;?>" <? if(isset($e_minStay) && ($j==$e_minStay)){echo "selected";} else{echo "";}?>><?php echo $j;?></option>
                                                            <?
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="txtMinStayType" id="txtMinStayType" class="Listmenu60">
                                                            <?php
                                                            if($e_stayType == "w"){
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
                                </table>
                            </td>
                        </tr>
						<?php */?>                        
						<tr><td class="pad-btm10" colspan="3"></td></tr>
						<?php /*?>
                        <tr style="display:none;">
                            <td class="pad-rgt5 pad-top3" align="right" valign="top">Rates: from</td>
                            <td colspan="2" align="left" valign="middle">
                                <table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td><input type="text" name="txtNightMidweekPrice" id="txtNightMidweekPrice" class="txtBox55" value="<?php echo $e_perNightMidweekPrice;?>" style="width:125px" /></td>
                                        <td class="pad-rgt15 pad-lft5">to</td>
                                        <td><input type="text" name="txtNightWeekendPrice" id="txtNightWeekendPrice" class="txtBox55" value="<?php echo $e_perNightWeekendPrice;?>" style="width:125px" /></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="pad-top3"><strong>NOTE:</strong>&nbsp;Leave 2nd box empty if your rates are fixed</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
						<?php */?>
                        <tr>
                            <td class="pad-rgt5" align="right">Price</td>
                            <td colspan="2" align="left" valign="top" class="pad-btm3 pad-top10">
                                <table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td><input type="text" name="txtNightMidweekPrice" id="txtNightMidweekPrice" class="txtBox55" value="<?php echo $e_perNightMidweekPrice;?>" /></td>
                                        <td class="pad-lft5 pad-rgt15">per<!-- midweek--> night</td>
										<?php /*?>
                                        <td><input type="text" name="txtNightWeekendPrice" id="txtNightWeekendPrice" class="txtBox55" value="<?php echo $e_perNightWeekendPrice;?>" /></td>
                                        <td class="pad-lft5 pad-rgt15">per weekend night</td>
										<?php */?>
                                        <td><input type="text" name="txtWeekPrice" id="txtWeekPrice" class="txtBox55" value="<?php echo $e_perWeekPrice;?>" /></td>
                                        <td class="pad-rgt15 pad-lft5">per week</td>
                                        <td><input type="text" name="txtMonthPrice" id="txtMonthPrice" class="txtBox55" value="<?php echo $e_perMonthPrice;?>" /></td>
                                        <td class="pad-lft5">per month</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr><td class="pad-btm10" colspan="3"></td></tr>
                        <tr>
                            <td class="pad-rgt5" align="right" valign="middle"><?php echo tranText('special_offer'); ?>?</td>
                            <td colspan="2" align="left" valign="middle" class="pad-btm3">
                                <table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td valign="middle"><input name="txtSpecialOffer" type="radio" class="radio" id="txtSpecialOfferId2" value="1" <?php if(isset($e_specialOffer) && $e_specialOffer == "1") {echo "checked=\"checked\"";}?> /></td>
                                        <td class="pad-rgt15 pad-lft5" valign="middle"><strong>YES</strong></td>
                                        <td valign="middle"><input name="txtSpecialOffer" type="radio" class="radio" id="txtSpecialOfferId1" value="0" <?php if(!isset($e_specialOffer) || $e_specialOffer != "1") {echo "checked=\"checked\"";}?> /></td>
                                        <td class="pad-lft5" valign="middle"><strong>NO</strong><span class="pad-lft5 font11"><?php echo tranText('special_offer_will_be_highlighted_on_your_listing'); ?></span></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class="pad-rgt5" align="right">&nbsp;</td>
                            <td colspan="2" align="left" valign="top" class="pad-btm3 pad-top7">
                            <div class="FloatLft pad-rgt5">
                                <?php 
                                if(isset($_GET['edit']) && $_GET['edit'] != "") {
                                    echo "<a href=\"JavaScript:void(0);\" onClick=\"addPrice();\"><img src=\"".SITE_IMAGES."updateprice.gif\" alt=\"Update price\" border=\"0\" /></a>&nbsp;&nbsp;<a href=\"JavaScript:void(0);\" onClick=\"cancelPrice();\"><img src=\"".SITE_IMAGES."cancel-gray.gif\" alt=\"Cancel price\" border=\"0\" /></a>";
                                } else {
                                    echo "<a href=\"JavaScript:void(0);\" onClick=\"addPrice();\"><img src=\"".SITE_IMAGES."addprice.gif\" alt=\"Add price bracket\" width=\"90\" height=\"27\" border=\"0\" /></a>";
                                }
                                ?>
                            </div>
                            <div id="priceErrorDiv" class="pad-top5 error"></div>
                            </td>
                        </tr>
                    </table>
                </div>
			</div>
			</td>
        </tr>
			<!-- price info: Start here -->
			<?php 
			if(is_array($propertyPricesArr) && count($propertyPricesArr) > 0) {
				echo "<tr>";
				echo "<td align=\"left\" valign=\"top\">";
				echo "<div id=\"showPriceDetails\">";

				echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">";
				echo "<tr>";
				echo "<td align=\"left\" valign=\"top\" class=\"pad-top25\">";
				echo "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
				echo "<tr>";
				echo "<td class=\"PricesHeadV\" style=\"width:85px;\">Name</td>";
				echo "<td class=\"PricesHeadV\" style=\"width:100px;\">Date from</td>";
				echo "<td class=\"PricesHeadV\" style=\"width:100px;\">Date to</td>";
				echo "<td align=\"center\" class=\"PricesHeadV\" style=\"width:60px;\">Min stay</td>";
				echo "<td align=\"center\" class=\"PricesHeadV\" style=\"width:80px;\">Price/month</td>";
				echo "<td align=\"center\" class=\"PricesHeadV\" style=\"width:80px;\">Price/week</td>";
				echo "<td align=\"center\" class=\"PricesHeadV\" style=\"width:80px;\">Price/night</td>";
				echo "<td align=\"center\" class=\"PricesHeadV\" style=\"width:90px;\">Action</td>";
				echo "</tr>";
			
				for($i=0; $i<count($propertyPricesArr); $i++){
					$property_price_id		= $propertyPricesArr[$i]['id'];
					$property_price_name	= $propertyPricesArr[$i]['price_name'];
					$dateFrom 				= date('j M, Y', $propertyPricesArr[$i]['date_from']);
					$dateTo 				= date('j M, Y', $propertyPricesArr[$i]['date_to']);
					$minStay 				= $propertyPricesArr[$i]['min_stay'];
					$stayType 				= $propertyPricesArr[$i]['min_stay_type'];
					if((int)$minStay > 1) {
						$strMinStay			= $propertyPricesArr[$i]['min_stay'] ." ".(($stayType == "w") ? "Weeks" : "Nights");
					} else if((int)$minStay == 1) {
						$strMinStay			= $propertyPricesArr[$i]['min_stay'] ." ".(($stayType == "w") ? "Week" : "Night");
					} else {
						$strMinStay			= "--";
					}

					$perMonthPrice 			= $propertyPricesArr[$i]['per_month_price'];
					if($perMonthPrice != "" && $perMonthPrice != "0") {
						$strPerMonthPrice 	= "<span id=\"price_currency_symbol_id0".$i."\">".$currencySymbol."</span><span id=\"price_currency_value_id0".$i."\">".number_format($perMonthPrice)."</span>";
					} else {
						$strPerMonthPrice 	= "<span id=\"price_currency_symbol_id0".$i."\">&nbsp;</span><span id=\"price_currency_value_id0".$i."\">--</span>";
					}

					$perWeekPrice 			= $propertyPricesArr[$i]['per_week_price'];
					if($perWeekPrice != "" && $perWeekPrice != "0") {
						$strPerWeekPrice 	= "<span id=\"price_currency_symbol_id1".$i."\">".$currencySymbol."</span><span id=\"price_currency_value_id1".$i."\">".number_format($perWeekPrice)."</span>";
					} else {
						$strPerWeekPrice 	= "<span id=\"price_currency_symbol_id1".$i."\">&nbsp;</span><span id=\"price_currency_value_id1".$i."\">--</span>";
					}

					$perNightMidweekPrice 	= $propertyPricesArr[$i]['per_night_midweek_price'];
					if($perNightMidweekPrice != "" && $perNightMidweekPrice != "0") {
						$strPerNightMidweekPrice 	= "<span id=\"price_currency_symbol_id2".$i."\">".$currencySymbol."</span><span id=\"price_currency_value_id2".$i."\">".number_format($perNightMidweekPrice)."</span>";
					} else {
						$strPerNightMidweekPrice 	= "<span id=\"price_currency_symbol_id2".$i."\">&nbsp;</span><span id=\"price_currency_value_id2".$i."\">--</span>";
					}

					$perNightWeekendPrice 	= $propertyPricesArr[$i]['per_night_weekend_price'];
					if($perNightWeekendPrice != "" && $perNightWeekendPrice != "0") {
						$strPerNightWeekendPrice 	= "<span id=\"price_currency_symbol_id3".$i."\">".$currencySymbol."</span><span id=\"price_currency_value_id3".$i."\">".number_format($perNightWeekendPrice)."</span>";
					} else {
						$strPerNightWeekendPrice 	= "<span id=\"price_currency_symbol_id3".$i."\">&nbsp;</span><span id=\"price_currency_value_id3".$i."\">--</span>";
					}

					$specialOffer 			= $propertyPricesArr[$i]['special_offer'];
					if($specialOffer > 0) { 
					 $rowStyle = "pricesSpecialV"; 
					} else {
					 $rowStyle = "PricesBlankV";
					}
					echo "<tr id=\"price_row_id".$property_price_id."\">";
					echo "<td align=\"left\" class=\"".$rowStyle."\">".$property_price_name."</td>";
					echo "<td align=\"left\" class=\"".$rowStyle."\">".$dateFrom."</td>";
					echo "<td align=\"left\" class=\"".$rowStyle."\">".$dateTo."</td>";
					echo "<td align=\"center\" class=\"".$rowStyle."\">".$strMinStay."</td>";
					echo "<td align=\"center\" class=\"".$rowStyle."\" id=\"price_cell_id0".$i."\">".$strPerMonthPrice."</td>";
					echo "<td align=\"center\" class=\"".$rowStyle."\" id=\"price_cell_id1".$i."\">".$strPerWeekPrice."</td>";
					echo "<td align=\"center\" class=\"".$rowStyle."\" id=\"price_cell_id2".$i."\">".$strPerNightMidweekPrice."</td>";
				//	echo "<td align=\"center\" class=\"".$rowStyle."\" id=\"price_cell_id3".$i."\">".$strPerNightWeekendPrice."</td>";
					echo "<td align=\"right\" class=\"".$rowStyle."\" id=\"price_cell_id4".$i."\"><a href=\"owner-property.php?sec=pri&pid=".$property_id."&edit=".$property_price_id."\">edit</a> | <a href=\"JavaScript:void(0);\" onClick=\"addDelPriceId('".$property_price_id."');toggleLayer1('delete-pop');\">remove</a></td>";
					echo "</tr>";
				}
				echo "</table>";
				echo "</td>";
				echo "</tr>";

				// Notes for holiday maker
				echo "<tr><td>&nbsp;</td></tr>";
				echo "<tr>";
				echo "<td align=\"left\" valign=\"top\" class=\"pad-top5\"><span class=\"font16-darkgrey\">Add notes on these prices</span> These notes will appear on your property listing</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td align=\"left\" valign=\"top\" class=\"pad-top15\">";
				echo "<span style=\"float:left;\"><textarea name=\"txtPriceNotes\" id=\"txtPriceNotesId\" cols=\"\" rows=\"\" class=\"PricesNotes\">".$propertyInfo['price_notes']."</textarea></span>";
				echo "</td>";
				echo "</tr>";
				
				// Notes for Owner
				echo "<tr><td>&nbsp;</td></tr>";
				echo "<tr>";
				echo "<td align=\"left\" valign=\"top\" class=\"pad-top5\"><span class=\"font16-darkgrey\">Internal notes on these prices</span>( only owners/agents can see these notes )</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td align=\"left\" valign=\"top\" class=\"pad-top15\">";
				echo "<span style=\"float:left;\"><textarea name=\"txtOwnerNotes\" id=\"txtOwnerNotesId\" cols=\"\" rows=\"\" class=\"PricesNotes\">".$propertyInfo['owner_notes']."</textarea></span>";
				echo "</td>";
				echo "</tr>";

				echo "</table>";

				echo "</div>";
				echo "</td>";
				echo "</tr>";
				?>
				<tr>
					<td align="left" valign="top" class="font12">
					<div id="delete-pop" class="box cursor1" style="display:none; z-index:5; position:relative; left:0px; top:0px;">
						<!--[if IE]><iframe id="iframe" frameborder="0" style="position:absolute;top:-56px;left:204px;width:363px; height:210px;"></iframe><![endif]-->
						<div class="content">
						<div onMouseDown="dragStart(event, 'delete-pop');" style="position:absolute; z-index:999;left:200px; top:-460px; width:370px;">
							<table width="380" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td align="right"><img src="<?php echo SITE_IMAGES;?>poplefttop.png" alt="ANP" height="10" width="10" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/poplefttop.png', sizingMethod='scale');" /></td>
									<td class="topp"></td>
									<td><img src="<?php echo SITE_IMAGES;?>poprighttop1.png" alt="ANP"  height="10" width="15" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/poprighttop1.png', sizingMethod='scale');"/></td>
								</tr>
								<tr>
									<td class="leftp"></td>
									<td width="380" align="left" valign="top" bgcolor="#FFFFFF" style="padding:6px 10px 15px 20px">
										<div id="delpriceId">
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td width="279" rowspan="2" align="left" valign="bottom" class="pink18arial pad-top15">Are you sure?</td>
												<td align="right" valign="top"><a href="javascript:toggleLayer1('delete-pop');void(0);"><img src="<?php echo SITE_IMAGES;?>pop-up-cross.gif" alt="Close" title="Close" border="0" /></a></td>
											</tr>
											<tr><td width="36" align="right" valign="top">&nbsp;</td></tr>
											<tr>
												<td  align="left" valign="top" class="PopTxt">
													<p class="grayTxt" style="font:Arial, Helvetica, sans-serif; font-size:12px; color:#585858; padding-top:10px;"><strong>You will not be able to retrieve this information once you delete it ...</strong></p>
													<p class="grayTxt" style="font:Arial, Helvetica, sans-serif; font-size:12px; color:#585858; padding-top:2px;">&nbsp;</p>	
												</td>
												<td align="left" valign="top">&nbsp;</td>
											</tr>
											<tr><td colspan="2" align="left" valign="top" height="12"></td></tr>
											<tr>
												<td colspan="2" align="left" valign="top">
													<table width="94%" border="0" cellpadding="0" cellspacing="0">
														<tr><td align="left" valign="top" class="buttons">&nbsp;</td></tr>
														<tr><td align="left" valign="top" class="buttons">&nbsp;</td></tr>
														<tr>
														<td align="left" valign="top" class="buttons">
														<a href="javascript:toggleLayer1('delete-pop');void(0);" class="button-grey">Cancel</a>
														<img src="<?php echo SITE_IMAGES;?>spacer.gif" alt="One" width="4" />&nbsp;
														<a href="JavaScript:delPrice();" class="button-blue">Yes delete now</a>
														</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>
										</div>
									</td>
									<td class="rightp" width="10"></td>
								</tr>
								<tr>
									<td align="right"><img src="<?php echo SITE_IMAGES;?>popleftbtm.png" alt="ANP" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/popleftbtm.png', sizingMethod='crop');" width="10" height="10"/></td>
									<td  class="bottomp"></td>
									<td align="left"><img src="<?php echo SITE_IMAGES;?>poprightbtm1.png" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/poprightbtm1.png', sizingMethod='crop');" width="15" height="10" alt="ANP"/></td>
								</tr>
							</table>
		
						</div>
						</div>
					</div>
					</td>
				</tr>
				<?php
			}
			?>
			<!-- price info: End here -->
    </table>
</div>
<div class="width690 dash41"></div>
<div class="width690">
	<div class="FloatRgt">
        <a href="#" onclick="return frmSubmit();"class="button-blue">Save details</a>
    </div>
</div>
</form>