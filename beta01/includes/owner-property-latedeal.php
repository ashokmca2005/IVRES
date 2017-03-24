<?php 
$dayname 	= array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');
$monthname 	= array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec');
$yearname 	= array(date('Y')+0,date('Y')+1,date('Y')+2,date('Y')+3);
$stayname 	= array('1','2','3','4','5','6','7','8','9','10','11','12','13','14');

$property_prefix = "";
if(strlen((string)$property_id) < 6) {
	for($k = strlen($property_id); $k < 6; $k++) {
		$property_prefix .= "0";
	}
}

?>
<script language="javascript">
// JavaScript Document
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

<link href="css/pop-up-cal.css" rel="stylesheet" type="text/css" />

<div style="clear:both;" >
<table width="694" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr>
        <td align="left" colspan="2" valign="top" class="pad-btm3">
            <div class="FloatLft">
            <h2 class="page-heading-red">Late deals</h2>
            </div>
			<?php
                $propertyDeals = $propertyObj->fun_getPropertyDealsShowArr($property_id, '');
                if(count($propertyDeals) > 0) { 
            ?>            
            <div class="FloatRgt pad-top3"><a href="owner-property.php?sec=spe&spe=ove&pid=<?php echo $property_id;?>"><img src="<?php echo SITE_IMAGES;?>view-my-latedeals.png" /></a></div>
			<?php
            }
            ?>            
        </td>
    </tr>
    <tr><td colspan="2" align="left" valign="top" class="dash25">&nbsp;</td></tr>
    <tr>
        <td colspan="2" align="left" valign="top">
            <p class="pad-btm10 pad-top3">Do you ever have last minute cancellations or space to fill. Why not offer it at a cut price and fill your property rather than leaving it empty. The more reduction you give the greater the chances of filling the vacancy. We know from experience how difficult it is finding a space last minute so we've made it easy. As long as you're a registered owner on rentownersvillas.com you can advertise your late late deals completely FREE of charge.</p>
            <p class="pad-btm10">It's so simple, just tell us when the booking is, how much the price reduction is and we'll put you on the board. It takes two minutes and you can change it at any time. For instance as the booking time draws near and you still haven't filled the spot you can actually edit the details online yourself and then post it again. </p>
            <p class="pad-btm10">You can ALSO have up to two entries at any one time. Maybe you have two vacancies at any one time.</p>
            <p class="pad-btm10">What have you got to lose, as well as all the other fantastic benefits of advertising on rentownersvillas.com you will now get the chance to fill your property ALL YEAR ROUND. </p>
        </td>
    </tr>
    <tr>
        <td colspan="2" valign="top" class="latedealBox">
            <form name="frmPropDeals" action="<?php echo $_SERVER['REQUEST_URI']; ?>&spe=pre" method="post">
            <input type="hidden" name="securityKey" value="<?php echo md5(OWNERPROPERTYDEALS);?>" />
        
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr><td colspan="2" valign="top" class="pad-btm5"><span class="owner-headings">Create a new late deal</span></td></tr>
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
                                            <option value="<?=$value?>" <?php if($value==(date('d')+1)){echo "selected";}else{echo "";} ?>><?=($key+1)?></option>
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
                                            <option value="<?=$key?>" <?php if($key==(date('m'))){echo "selected";}else{echo "";} ?>><?=$value?></option>
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
                                            <option value="<?=$value?>" <?php if($value==(date('Y'))){echo "selected";}else{echo "";} ?>><?=$value?></option>
                                        <?
                                        }
                                        ?>
                                    </select>										
                                </td>
                                <td  class="pad-lft5"><a href="JavaScript:find_cal(<?php echo time()?>,'From0');"><img src="<?php echo SITE_IMAGES;?>calender.gif" alt="calendar" /></a></td>
                                <td class="pad-lft20 pad-rgt5"> End date</td>
                                <td>
                                    
                                    <select name="txtDayTo0" id="txtDayTo0" class="Listmenu45">
                                        <option value=""> - - </option>
                                        <?
                                        foreach($dayname as $key => $value)
                                        {
                                        ?>
                                            <option value="<?=$value?>" <?php if($value==(date('d')+1)){echo "selected";}else{echo "";} ?>><?=($key+1)?></option>
                                        <?
                                        }
                                        ?>
                                    </select>										
                                  
                                </td>
                                <td class="pad-lft5">
                                    <select name="txtMonthTo0" id="txtMonthTo0" class="Listmenu70">										
                                        <option value=""> - - </option>
                                        <?
                                        foreach ($monthname as $key => $value) 
                                        {
                                        ?>
                                            <option value="<?=$key?>" <?php if($key==(date('m'))){echo "selected";}else{echo "";} ?>><?=$value?></option>
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
                                            <option value="<?=$value?>" <?php if($value==(date('Y'))){echo "selected";}else{echo "";} ?>><?=$value?></option>
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
                            $propertyObj->fun_getCurrenciesOptionsListWithSymbl(4);
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="pad-top13 pad-btm5"><span class="font12-black">Original price per night</span></td>
                    <td valign="top" class="pad-lft20 pad-top13 pad-btm5">
                        <table border="0" cellpadding="0" cellspacing="0" class="font12-black">
                            <tr>
                                <td>
                                <input name="txtOrgNightPrice0" id="txtOrgNightPrice0" style="font-weight:normal;" type="text" class="Textfield100" value="" onKeyUp="checkNumber('txtOrgNightPrice0', this.value);" maxlength="5" />
                                </td>
                                <td class="pad-lft20 pad-rgt5"><span class="red12">SALE</span> price per night</td>
                                <td>
                                    <span class="pad-left7">
                                    <input name="txtSaleNightPrice0" id="txtSaleNightPrice0" style="font-weight:normal;" type="text" class="Textfield100" value="" onKeyUp="checkNumber('txtSaleNightPrice0', this.value);" maxlength="5" />
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
                                <input name="txtRemoveDealFrom0" id="txtRemoveDealFrom0" type="radio" class="radio" value="s" checked />
                                </td>
                                <td class="pad-left7 font12-black" valign="middle">
                                Remove this deal on the start date
                                </td>
                                <td class="pad-lft20 pad-rgt5" valign="middle">
                                <input name="txtRemoveDealFrom0" id="txtRemoveDealFrom0" type="radio" class="radio" value="e" /> 
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
                        <div class="FloatLft"><a href="owner-property.php?sec=spe&spe=ove&pid=<?php echo $property_id;?>"><img src="<?php echo SITE_IMAGES;?>cancel-admin.png" alt="Cancel" class="cursor" onclick="frmReset();"/></a></div>
                        <div class="FloatLft pad-lft10">
                            <input type="image" src="<?php echo SITE_IMAGES;?>preview.png" alt="Submit" class="cursor" onclick="return validate();" >
                        </div>
                        <div class="FloatLft pad-lft5 pad-top3" align="left" style="font-size:12px; color:#FF0000; font-weight:bold;" id="txtDealErrorMsg">&nbsp;</div>
                    </td>
                </tr>
            </table>    

            </form>
        </td>
    </tr>
   
</table>
</div>
