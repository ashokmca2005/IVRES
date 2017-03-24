<?php 
$dayname 	= array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');
$monthname 	= array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec');
$yearname 	= array(date('Y')+0,date('Y')+1,date('Y')+2,date('Y')+3);
$stayname 	= array('1','2','3','4','5','6','7','8','9','10','11','12','13','14');
?>
<script language="javascript">
// JavaScript Document
	var req = ajaxFunction();
	var x1 = "";
	var y1 = "";

	function find_cal(a,ct){
		var url="../get_cal.php";
		url=url+"?timestamp="+a+"&ct="+ct;
		req.onreadystatechange=function(){
			if (req.readyState==4){
				var object;
				object = req.responseText;				
				var x1 = x+160;
				var y1 = y-153;
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
				var x1 = x-75;
				var y1 = y-153;
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

	function frmReset(){
		document.frmPropDeals.reset();
		document.getElementById("txtDealErrorMsg").innerHTML = "";
	}

	function checkNumber(strFiled, strValue) {
		if(isNaN(strValue)) {
			document.getElementById(strFiled).focus();
			document.getElementById("txtDealErrorMsg").innerHTML = "Please enter an Integer!";
			return false;
		} else {
			document.getElementById("txtDealErrorMsg").innerHTML = "";
		}
	}
	
	function validate() {
		if(document.frmPropDeals.txtDayFrom0.value == "") {
			document.getElementById("txtDealErrorMsg").innerHTML = "Please select a start date!";
			document.frmPropDeals.txtDayFrom0.focus();
			return false;
		}

		if(document.frmPropDeals.txtMonthFrom0.value == "") {
			document.getElementById("txtDealErrorMsg").innerHTML = "Please select a start date!";
			document.frmPropDeals.txtMonthFrom0.focus();
			return false;
		}

		if(document.frmPropDeals.txtYearFrom0.value == "") {
			document.getElementById("txtDealErrorMsg").innerHTML = "Please select a start date!";
			document.frmPropDeals.txtYearFrom0.focus();
			return false;
		}

		if(document.frmPropDeals.txtDayTo0.value == "") {
			document.getElementById("txtDealErrorMsg").innerHTML = "Please select an end date!";
			document.frmPropDeals.txtDayTo0.focus();
			return false;
		}

		if(document.frmPropDeals.txtMonthTo0.value == "") {
			document.getElementById("txtDealErrorMsg").innerHTML = "Please select an end date!";
			document.frmPropDeals.txtMonthFrom0.focus();
			return false;
		}

		if(document.frmPropDeals.txtYearTo0.value == "") {
			document.getElementById("txtDealErrorMsg").innerHTML = "Please select an end date!";
			document.frmPropDeals.txtYearFrom0.focus();
			return false;
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
				document.getElementById("txtDealErrorMsg").innerHTML = "Please select correct end date!";
				document.frmPropDeals.txtYearTo0.focus();
				return false;
			}
		}


		if(document.frmPropDeals.txtCurrencyType.value == "") {
			document.getElementById("txtDealErrorMsg").innerHTML = "Please select a currency!";
			document.frmPropDeals.txtCurrencyType.focus();
			return false;
		}

		if(document.frmPropDeals.txtOrgNightPrice0.value == "") {
			document.getElementById("txtDealErrorMsg").innerHTML = "Please enter the original price per night!";
			document.frmPropDeals.txtOrgNightPrice0.focus();
			return false;
		}

		if(document.frmPropDeals.txtSaleNightPrice0.value == "") {
			document.getElementById("txtDealErrorMsg").innerHTML = "Please enter the SALE price per night!";
			document.frmPropDeals.txtSaleNightPrice0.focus();
			return false;
		}

		if(parseInt(document.frmPropDeals.txtSaleNightPrice0.value) >= parseInt(document.frmPropDeals.txtOrgNightPrice0.value)) {
			document.getElementById("txtDealErrorMsg").innerHTML = "Your SALE price must be less than your original price!";
			document.frmPropDeals.txtSaleNightPrice0.focus();
			return false;
		}

		document.frmPropDeals.submit();
	}	
</script>
<?php

$property_prefix = "";
if(strlen((string)$property_id) < 6) {
	for($k = strlen($property_id); $k < 6; $k++) {
		$property_prefix .= "0";
	}
}


if(isset($_GET['dealid']) && ($_GET['dealid'] != "") && empty($_POST)) {
	$deal_id = $_GET['dealid'];
	$propertyDealsArr = $propertyObj->fun_getPropertyDealsShowArr($property_id, $deal_id);
	if(count($propertyDealsArr) > 0) { 
		$strDealId 				= $propertyDealsArr[0]['id'];
		$txtPrpertyRef			= $propertyDealsArr[0]['property_id'];
		$strDateFrom 			= $propertyDealsArr[0]['start_on'];
		$strDateTo 				= $propertyDealsArr[0]['end_on'];
		$txtOrgNightPrice0 		= $propertyDealsArr[0]['original_price'];
		$txtSaleNightPrice0 	= $propertyDealsArr[0]['sale_price'];
		$txtRemoveDealFrom0 	= $propertyDealsArr[0]['remove_from'];

		$txtDayFrom0 	= date('d', strtotime($strDateFrom));
		$txtMonthFrom0 	= date('m', strtotime($strDateFrom));
		$txtYearFrom0 	= date('Y', strtotime($strDateFrom));

		$txtDayTo0 		= date('d', strtotime($strDateTo));
		$txtMonthTo0 	= date('m', strtotime($strDateTo));
		$txtYearTo0 	= date('Y', strtotime($strDateTo));
		$txtCurrencyType = $propertyObj->fun_findPropertyCurrencyCode($txtPrpertyRef);
	}
}
//print_r($_POST);

?>
<link href="<?php echo SITE_URL;?>css/pop-up-cal.css" rel="stylesheet" type="text/css" />
<div style="clear:both;">
<table width="690" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr>
        <td align="left" colspan="2" valign="top">
            <div class="FloatLft"><h2 class="page-heading-red">Late deals</h2></div>
            <div class="FloatRgt"><a href="admin-pending-approval.php?sec=<?php echo $sec;?>&subsec=spe&spe=ove&pid=<?php echo $property_id;?>"><img src="<?php echo SITE_IMAGES;?>view-my-latedeals.png" /></a></div>
        </td>
    </tr>
    <tr><td colspan="2" align="left" valign="top" class="dash25">&nbsp;</td></tr>
    <tr>
        <td colspan="2" valign="top" class="latedealBox">
            <form name="frmPropDeals" action="<?php echo $_SERVER['REQUEST_URI']; ?>&spe=pre" method="post">
            <input type="hidden" name="securityKey" value="<?php echo md5(OWNERPROPERTYDEALS);?>" />
            <?php
			if(isset($deal_id) && $deal_id !="") {
			?>
            <input type="hidden" name="txtPropertyDealId" value="<?php echo $deal_id;?>" />
<!--
            <input type="hidden" name="txtTermsCondition" value="1" />
-->
            <?php
			}
			?>
        
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td colspan="2" valign="top" class="pad-btm5">
                        <span class="owner-headings">
                        <?php 
						if(isset($deal_id) && $deal_id != "") {
							echo "Edit your late deal";
						} else {
							echo "Create a new late deal";
						}
						?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="pad-top13 pad-btm5"><span class="font12-black">Property reference</span></td>
                    <td valign="top" class="pad-lft20 pad-top13 pad-btm5">
                    <select name="txtPrpertyRef" class="Listmenu325" id="txtPrpertyRefId">
                        <option value="<?php echo $property_id; ?>"><?php echo $property_prefix.$property_id. " - ".$propertyName; ?></option>
                    </select>
                    </td>
                </tr>
                <tr>
                    <td width="130" valign="top" class="pad-top13 pad-btm5"><span class="font12-black">Booking start date</span></td>
                    <td valign="top" class="pad-lft20 pad-top13 pad-btm5">
                        <table border="0" cellpadding="0" cellspacing="0" class="font12-black">
                            <tr>
                                <td>
                                    <select name="txtDayFrom0" id="txtDayFrom0" class="Listmenu45">
                                        <option value=""> - - </option>
                                        <?
                                        foreach($dayname as $key => $value)
                                        {
                                        ?>
                                            <option value="<?=$value?>" <? if(isset($txtDayFrom0) && ("$txtDayFrom0" == "$value")){echo "selected";}else if(($value == (date('d')+1)) && !isset($txtDayFrom0)){echo "selected";}else{echo "";}?>><?=($key+1)?></option>
                                        <?
                                        }
                                        ?>
                                    </select>										
                                </td>
                                <td class="pad-lft5">
                                    <select name="txtMonthFrom0" id="txtMonthFrom0" class="Listmenu70">										
                                        <option value=""> - - </option>
                                        <?
                                        foreach ($monthname as $key => $value) 
                                        {
                                        ?>
                                            <option value="<?=$key?>" <? if(isset($txtMonthFrom0) && ($key==$txtMonthFrom0)){echo "selected";}else if(($key==date('m')) && !isset($txtMonthFrom0)){echo "selected";}else{echo "";}?>><?=$value?></option>
                                        <?
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td  class="pad-lft5">
                                    <select name="txtYearFrom0" id="txtYearFrom0" class="Listmenu60">										
                                        <option value=""> - - </option>
                                        <?
                                        foreach ($yearname as $value) 
                                        {
                                        ?>
                                            <option value="<?=$value?>" <? if($value==$txtYearFrom0){echo "selected";}else{echo "";}?>><?=$value?></option>
                                        <?
                                        }
                                        ?>
                                    </select>										
                                </td>
                                <td  class="pad-lft5"><a href="JavaScript:find_cal(<?php echo time()?>,'From0');"><img src="<?php echo SITE_IMAGES;?>calender.gif" alt="calendar" /></a></td>
                                <td class="pad-lft20 pad-rgt5"> End date</td>
                                <td>
                                    <span class="pad-left7">
                                    <select name="txtDayTo0" id="txtDayTo0" class="Listmenu45">
                                        <option value=""> - - </option>
                                        <?
                                        foreach($dayname as $value)
                                        {
                                        ?>
                                            <option value="<?=$value?>" <? if($value==$txtDayTo0){echo "selected";}else{echo "";}?>><?=$value?></option>
                                        <?
                                        }
                                        ?>
                                    </select>										
                                    </span>
                                </td>
                                <td class="pad-lft5">
                                    <select name="txtMonthTo0" id="txtMonthTo0" class="Listmenu70">										
                                        <option value=""> - - </option>
                                        <?
                                        foreach ($monthname as $key => $value) 
                                        {
                                        ?>
                                            <option value="<?=$key?>" <? if($key==$txtMonthTo0){echo "selected";}else{echo "";}?>><?=$value?></option>
                                        <?
                                        }
                                        ?>
                                    </select>										
                                </td>
                                <td  class="pad-lft5">
                                    <select name="txtYearTo0" id="txtYearTo0" class="Listmenu60">										
                                        <option value=""> - - </option>
                                        <?
                                        foreach ($yearname as $value) 
                                        {
                                        ?>
                                            <option value="<?=$value?>" <? if($value==$txtYearTo0){echo "selected";}else{echo "";}?>><?=$value?></option>
                                        <?
                                        }
                                        ?>
                                    </select>										
                                </td>
                                <td  class="pad-lft5"><a href="JavaScript:find_cal1(<?php echo time()?>,'To0');"><img src="<?php echo SITE_IMAGES;?>calender.gif" alt="calendar" /></a></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="pad-top13 pad-btm5"><span class="font12-black">Select currency</span></td>
                    <td valign="top" class="pad-lft20 pad-top13 pad-btm5">
                        <select name="txtCurrencyType" id="txtCurrencyType" class="currency">
                            <option value="">Please Select...</option>
                            <?php 
								$propertyObj->fun_getCurrenciesOptionsListWithSymbl($txtCurrencyType);
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="pad-top13 pad-btm10"><span class="font12-black">Original price per night</span></td>
                    <td valign="top" class="pad-lft20 pad-top13 pad-btm10">
                        <table border="0" cellpadding="0" cellspacing="0" class="font12-black">
                            <tr>
                                <td>
                                <input name="txtOrgNightPrice0" id="txtOrgNightPrice0" style="font-weight:normal;" type="text" class="Textfield100" value="<?php echo $txtOrgNightPrice0; ?>" onKeyUp="checkNumber('txtOrgNightPrice0', this.value);" maxlength="5" />
                                </td>
                                <td class="pad-lft20 pad-rgt5"><span class="red12">SALE</span> price per night</td>
                                <td>
                                    <span class="pad-left7">
                                    <input name="txtSaleNightPrice0" style="font-weight:normal;" id="txtSaleNightPrice0" type="text" class="Textfield100" value="<?php echo $txtSaleNightPrice0; ?>" onKeyUp="checkNumber('txtSaleNightPrice0', this.value);" maxlength="5" />
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="pad-top13 pad-btm10">&nbsp;</td>
                    <td valign="top" class="pad-lft20 pad-top13 pad-btm10">
                        <table border="0" cellpadding="0" cellspacing="0" class="font12-black">
                            <tr>
                                <td class="pad-left7 pad-rgt5" valign="middle">
                                <input name="txtRemoveDealFrom0" id="txtRemoveDealFrom0" type="radio" class="radio" value="s" <?php if(isset($txtRemoveDealFrom0) && ($txtRemoveDealFrom0 != "e")) { echo "checked"; } ?> />
                                </td>
                                <td class="pad-left7 font12-black" valign="middle">
                                Remove this deal on the start date
                                </td>
                                <td class="pad-lft20 pad-rgt5" valign="middle">
                                <input name="txtRemoveDealFrom0" id="txtRemoveDealFrom0" type="radio" class="radio" value="e" <?php if(isset($txtRemoveDealFrom0) && ($txtRemoveDealFrom0 == "e")) { echo "checked"; } ?> /> 
                                </td>
                                <td class="pad-left7 font12-black" valign="middle">
                                Remove this deal on the end date
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr><td colspan="2" class="dash25">&nbsp;</td></tr>
                <tr>
                    <td colspan="2" class="pad-rgt20">
                        <div class="FloatLft"><a href="javascript:location.href='owner-property.php?sec=spe&pid=<?php echo $property_id;?>'"><img src="<?php echo SITE_IMAGES;?>cancel-admin.png"  class="cursor" alt="Cancel"/></a></div>
                        <div class="FloatLft pad-lft10">
                            <input type="image" src="<?php echo SITE_IMAGES;?>preview.png" alt="Submit"  class="cursor" onclick="return validate();" >
                        </div>
                        <div align="left" class="FloatLft pad-lft10 pad-top3" style="font-size:12px; color:#FF0000; font-weight:bold;" id="txtDealErrorMsg">&nbsp;</div>
                    </td>
                </tr>
            </table>    
            </form>
        </td>
    </tr>
    <tr><td colspan="2" align="left" valign="top">&nbsp;</td></tr>
    <tr><td colspan="2" align="left" valign="top">&nbsp;</td></tr>
    <tr><td colspan="2" align="left" valign="top">&nbsp;</td></tr>
</table>
</div>