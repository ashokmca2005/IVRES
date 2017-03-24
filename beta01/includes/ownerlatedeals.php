<?php 
$dayname 	= array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');
$monthname 	= array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec');
$yearname 	= array(date('Y')+0,date('Y')+1,date('Y')+2,date('Y')+3);
?>
<script language="javascript">
	var req = ajaxFunction();
	var x1 = "";
	var y1 = "";

	function find_cal(a,ct){
		var url="get_cal.php";
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
		var url="get_cal1.php";
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

		if(document.frmPropDeals.txtOrgWeekPrice0.value == "") {
			document.getElementById("txtDealErrorMsg").innerHTML = "Please enter the original price per week!";
			document.frmPropDeals.txtOrgWeekPrice0.focus();
			return false;
		}

		if(document.frmPropDeals.txtSaleWeekPrice0.value == "") {
			document.getElementById("txtDealErrorMsg").innerHTML = "Please enter the SALE price per week!";
			document.frmPropDeals.txtSaleWeekPrice0.focus();
			return false;
		}

		if(parseInt(document.frmPropDeals.txtSaleWeekPrice0.value) >= parseInt(document.frmPropDeals.txtOrgWeekPrice0.value)) {
			document.getElementById("txtDealErrorMsg").innerHTML = "Your SALE price must be less than your original price!";
			document.frmPropDeals.txtSaleWeekPrice0.focus();
			return false;
		}
		document.frmPropDeals.submit();
	}	
</script>
<?php
if(isset($_GET['dealid']) && ($_GET['dealid'] != "") && empty($_POST)) {
	$deal_id = $_GET['dealid'];
	$propertyDealsArr = $propertyObj->fun_getPropertyDealsShowArr('', $deal_id);
	if(count($propertyDealsArr) > 0) { 
		$strDealId 				= $propertyDealsArr[0]['id'];
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
	}
} else if(isset($_GET['pid']) && ($_GET['pid'] != "") && empty($_POST)) {
	$txtPrpertyRef	= $_GET['pid'];
}	
?>

<link href="css/pop-up-cal.css" rel="stylesheet" type="text/css" />
<form name="frmPropDeals" action="owner-late-deals.php?sec=pre" method="post">
<input type="hidden" name="securityKey" value="<?php echo md5(OWNERPROPERTYDEALS);?>" />
<?php
if(isset($deal_id) && $deal_id !="") {
?>
<input type="hidden" name="txtPropertyDealId" value="<?php echo $deal_id;?>" />
<?php
}
?>
<input type="hidden" name="txtRemoveDealFrom0" id="txtRemoveDealFrom0" value="s" />
<table width="690" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr>
        <td align="left" colspan="2" valign="top">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <td width="66%" valign="top" class="pad-top10 pad-rgt10">
						<?php
                        if(isset($deal_id) && $deal_id !="") {
                        ?>
                            <div class="FloatLft"><span class="latedealGray"><span style="font-weight:normal; font-size:26px;">Edit your</span> Late</span> <span class="latedealPink">deals</span> </div>
                        <?php
                        } else {
                        ?>
                            <div class="FloatLft"><span class="latedealGray"><span style="font-weight:normal; font-size:26px;"><?php echo tranText('add_a'); ?></span> <?php echo tranText('late'); ?></span> <span class="latedealPink">Deal</span> </div>
                        <?php
                        }
                        ?>
                    </td>
                    <td width="34%" valign="top" class="pad-lft20 pad-top12">&nbsp;</td>
                </tr>
                <tr>
                	<td align="left" colspan="2" valign="top">
                        <?php echo stripslashes($addlatedeals['page_discription']);?>
                    </td>
                </tr>
            </table>                    
        </td>
    </tr>
    <tr><td align="left" colspan="2" valign="top">&nbsp;</td></tr>
    <tr>
        <td colspan="2" align="left" valign="top" class="pad-top5">
            <table width="100%" border="0" cellpadding="4" cellspacing="0">
                <tr>
                    <td width="124" align="right" valign="top"><?php echo tranText('select_property'); ?></td>
                    <td width="298" valign="top">
                    <select name="txtPrpertyRef" class="select75" style="width:216px;" id="txtPrpertyRefId">
					<?php
                    for($j = 0; $j < count($ownerPropertyArr); $j++) {
                        $txtPropertyId 		= $ownerPropertyArr[$j]['property_id'];
                        $txtPropertyName 	= $ownerPropertyArr[$j]['property_name'];
                        ?>
                        <option value="<?php echo $txtPropertyId; ?>" <?php if($txtPropertyId == $txtPrpertyRef) { echo " selected"; } ?>><?php echo fill_zero_left($txtPropertyId, "0", (6-strlen($txtPropertyId))). " - ".$txtPropertyName; ?></option>
                        <?php
                    }
                    ?>
                    </select>
                    </td>
                </tr>
                <tr>
                    <td align="right" valign="top"><?php echo tranText('offer_starts'); ?></td>
                    <td valign="top">
                        <table border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
                                    <select name="txtDayFrom0" id="txtDayFrom0" class="Listmenu45">
                                        <option value=""> - - </option>
                                        <?
                                        foreach($dayname as $key => $value)
                                        {
                                        ?>
                                            <option value="<?=$value?>" <? if(isset($txtDayFrom0) && ($value==$txtDayFrom0)){echo "selected";}else{echo "";}?>><?=($key+1)?></option>
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
                                            <option value="<?=$key?>" <? if(isset($txtMonthFrom0) && ($key==$txtMonthFrom0)){echo "selected";}else{echo "";}?>><?=$value?></option>
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
                                            <option value="<?=$value?>" <? if(isset($txtYearFrom0) && ($key==$txtYearFrom0)){echo "selected";}else{echo "";}?>><?=$value?></option>
                                        <?
                                        }
                                        ?>
                                    </select>										
                                </td>
                                <td  class="pad-lft5"><a href="JavaScript:find_cal(<?php echo time()?>,'From0');"><img src="images/calender.gif" alt="calendar" /></a></td>
                                <td class="pad-lft20 pad-rgt5"> <?php echo tranText('ends'); ?></td>
                                <td>
                                    <span class="pad-left7">
                                    <select name="txtDayTo0" id="txtDayTo0" class="Listmenu45">
                                        <option value=""> - - </option>
                                        <?
                                        foreach($dayname as $key => $value)
                                        {
                                        ?>
                                            <option value="<?=$value?>" <? if(isset($txtDayTo0) && ($value==$txtDayTo0)){echo "selected";}else{echo "";}?>><?=($key+1)?></option>
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
                                            <option value="<?=$key?>" <? if(isset($txtMonthTo0) && ($key==$txtMonthTo0)){echo "selected";}else{echo "";}?>><?=$value?></option>
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
                                            <option value="<?=$value?>" <? if(isset($txtYearTo0) && ($key==$txtYearTo0)){echo "selected";}else{echo "";}?>><?=$value?></option>
                                        <?
                                        }
                                        ?>
                                    </select>										
                                </td>
                                <td  class="pad-lft5"><a href="JavaScript:find_cal1(<?php echo time()?>,'To0');"><img src="images/calender.gif" alt="calendar" /></a></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="right" valign="top"><?php echo tranText('select_currency'); ?></td>
                    <td valign="top">
                        <select name="txtCurrencyType" id="txtCurrencyType" class="currency">
                            <option value="">Please Select...</option>
                            <?php 
								if(!isset($txtCurrencyType)) {
									$txtCurrencyType = 4;
								}
								$propertyObj->fun_getCurrenciesOptionsListWithSymbl($txtCurrencyType);
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align="right" valign="top"><?php echo tranText('original_price'); ?></td>
                    <td valign="top"><input name="txtOrgWeekPrice0" id="txtOrgWeekPrice0" type="text" style="font-weight:normal;" class="Textfield100" value="<?php echo $txtOrgWeekPrice0; ?>" onKeyUp="checkNumber('txtOrgWeekPrice0', this.value);" maxlength="5" />&nbsp;&nbsp;<?php echo tranText('per_week'); ?></td>
                </tr>
                <tr>
                    <td align="right" valign="top"><?php echo tranText('offer_price'); ?></td>
                    <td valign="top"><input name="txtSaleWeekPrice0" id="txtSaleWeekPrice0" type="text" style="font-weight:normal;" class="Textfield100" value="<?php echo $txtSaleWeekPrice0; ?>" onKeyUp="checkNumber('txtSaleWeekPrice0', this.value);" maxlength="5" />&nbsp;&nbsp;<?php echo tranText('per_week'); ?></td>
                </tr>
                <tr>
                    <td align="right" valign="top"><?php echo tranText('min_stay'); ?></td>
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
                    <td colspan="2">
                        <div class="FloatLft pad-top3" align="left" style="font-size:12px; color:#FF0000; font-weight:bold;" id="txtDealErrorMsg"></div>
                    </td>
                </tr>
                <tr><td colspan="2" class="dash25">&nbsp;</td></tr>
                <tr>
                    <td align="right" valign="middle" class="pad-top5">&nbsp;</td>
                    <td valign="middle" class="pad-top5">
						<?php
                        if(isset($deal_id) && $deal_id !="") {
                        ?>
                           <a href="owner-late-deals.php?sec=ove" class="button-grey">Cancel</a>&nbsp;&nbsp;
                           <a href="javascript:void(0);" onclick="return validate();" class="button-blue">Submit</a>
						<?php
                        } else {
                        ?>
                           <a href="owner-late-deals.php?sec=ove" class="button-grey">Cancel</a>&nbsp;&nbsp;
                           <a href="javascript:void(0);" onclick="return validate();" class="button-blue">Submit</a>
						<?php
                        }
                        ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</form>
                            