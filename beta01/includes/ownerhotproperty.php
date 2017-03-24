<?php 
$dayname 	= array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');
$monthname 	= array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec');
$yearname 	= array(date('Y')+0,date('Y')+1,date('Y')+2,date('Y')+3);
$stayname 	= array('01','02','03','04','05','06','07','08','09','10','11','12','13','14');
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
		document.frmPropHot.reset();
		document.getElementById("txtHotPropErrorMsg").innerHTML = "";
	}

	function checkNumber(strFiled, strValue) {
		if(isNaN(strValue)) {
			document.getElementById(strFiled).focus();
			document.getElementById("txtHotPropErrorMsg").innerHTML = "Please enter an Integer!";
			return false;
		} else {
			document.getElementById("txtHotPropErrorMsg").innerHTML = "";
		}
	}
	
	function frmValidateAddHotProperty() {
		var shwError = false;
		/*
		if(document.getElementById("txtTermConditionsId").checked != true) {
			document.getElementById("txtErrorId").innerHTML = "Please read term and conditions.";
			shwError = true;
		}
		*/
		if(document.getElementById("txtDayFrom0").value == "" || document.getElementById("txtMonthFrom0").value == "" || document.getElementById("txtYearFrom0").value == "") {
			document.getElementById("txtErrorId").innerHTML = "Invalid date.";
			shwError = true;
		}

		if(document.getElementById("txtWeeksId").value == "") {
			document.getElementById("txtErrorId").innerHTML = "Please enter how many weeks.";
			shwError = true;
		}

		if(shwError == true) {
			return false;
		} else {
			document.frmPropHot.action = "owner-hot-property.php?sec=pre";
			document.frmPropHot.submit();
		}
	}
	
	function cancelAddHotProperty() {
		window.location = 'owner-home.php';	
	}

</script>

<link href="css/pop-up-cal.css" rel="stylesheet" type="text/css" />
<form name="frmPropHot" action="owner-hot-property.php?sec=pre" method="post">
<input type="hidden" name="securityKey" value="<?php echo md5(OWNERHOTPROPERTY);?>" />
<?php
if(isset($property_hot_id) && $property_hot_id !="") {
?>
<input type="hidden" name="txtPropHotId" value="<?php echo $property_hot_id;?>" />
<input type="hidden" name="txtConfirm" value="1" />
<input type="hidden" name="txtTermsCondition" id="txtTermsCondition" value="1" />
<?php
}
?>
<?php
if(isset($txtStatus) && $txtStatus !="") {
?>
<input type="hidden" name="txtStatus" value="<?php echo $txtStatus;?>" />
<?php
}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr>
        <td align="left" valign="top">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="450" align="left" valign="top">
                        <h1 class="page-headingNew"><?php if(isset($property_hot_id) && $property_hot_id !="") { echo "Edit your featured property"; } else { echo "Add a featured property"; } ?></h1>
                    </td>
                </tr>
				<?php
                if(!isset($property_hot_id)) {
                ?>
                <tr><td align="left" valign="top" class="pad-top10 pad-btm10"><?php echo tranText('site_notes_addfeaturedproperty'); ?></td></tr>
                <?php
                }
				?>
                <tr>
                    <td align="left" valign="top" class="pad-top25">
                        <table width="100%" border="0" cellpadding="4" cellspacing="0">
                            <tr>
                                <td width="124" align="right" valign="top">Select your property<span class="red">*</span></td>
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
                                <td align="right" valign="top">Show on the site from<span class="red">*</span></td>
                                <td valign="top">
                                    <table border="0" cellpadding="2" cellspacing="0">
                                        <tr>
                                            <td>
                                                <select name="txtDayFrom0" id="txtDayFrom0" class="HotPropertyDate">
                                                    <option value=""> - - </option>
                                                    <?
                                                    foreach($dayname as $key => $value) {
                                                    ?>
                                                        <option value="<?=$value?>" <? if(isset($txtDayFrom0) && ($value==$txtDayFrom0)){echo "selected";}else{echo "";}?>><?=($key+1)?></option>
                                                    <?
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="txtMonthFrom0" id="txtMonthFrom0" class="HotPropertyMonth">
                                                    <option value=""> - - </option>
                                                    <?
                                                    foreach ($monthname as $key => $value) 
                                                    {
                                                    ?>
                                                        <option value="<?=$key?>" <? if(isset($txtMonthFrom0) && ($key == $txtMonthFrom0)){echo "selected";}else{echo "";}?>><?=$value?></option>
                                                    <?
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td align="right">
                                                <select name="txtYearFrom0" id="txtYearFrom0" class="HotPropertyYear">
                                                    <option value=""> - - </option>
                                                    <?
                                                    foreach ($yearname as $value) 
                                                    {
                                                    ?>
                                                        <option value="<?=$value?>" <? if(isset($txtYearFrom0) && ($value==$txtYearFrom0)){echo "selected";}else{echo "";}?>><?=$value?></option>
                                                    <?
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td align="right"><a href="JavaScript:find_cal(<?php echo time()?>,'From0');"><img src="<?php echo SITE_IMAGES;?>calender.gif" alt="calendar" /></a></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="right" valign="top">For how many weeks<span class="red">*</span></td>
                                <td valign="top">
                                <select name="txtWeeks" id="txtWeeksId" class="PricesDate">
                                    <?
                                    for($k = 1; $k <= 52; $k++) {
                                    ?>
                                        <option value="<?=$k?>" <? if(isset($txtWeeks) && ($k==$txtWeeks)){echo "selected";}?>><?=($k)?></option>
                                    <?
                                    }
                                    ?>
                                </select>
                                </td>
                            </tr>
                            <tr>
                                <td align="right" valign="top" class="pad-topbtm10">&nbsp;</td>
                                <td valign="top" class="pad-topbtm10"><span class="pdError1" id="txtErrorId"></span></td>
                            </tr>
							<?php
                            if(isset($property_hot_id) && $property_hot_id != "") {
                            ?>
                            <tr><td colspan="2" class="dash25">&nbsp;</td></tr>
                            <tr>
                                <td align="right" valign="middle" class="pad-top20">&nbsp;</td>
                                <td valign="middle" class="pad-top20">
                                    <a href="javascript:cancelAddHotProperty();" class="button-grey" style="text-decoration:none;">Cancel</a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="return frmValidateAddHotProperty();" class="button-blue" style="text-decoration:none;">Save Change</a>
                                </td>
                            </tr>
                            <?php
                            } else {
                            ?>
                            <tr class="grayRow">
                                <td colspan="2" valign="middle" align="center">By clicking submit you agree to the <a href="javascript:popcontact('terms.html')" class="blue-link">terms and conditions</a></td>
                            </tr>
                            <tr>
                                <td align="right" valign="middle" class="pad-top20">&nbsp;</td>
                                <td valign="middle" class="pad-top20">
                                    <a href="javascript:cancelAddHotProperty();" class="button-grey" style="text-decoration:none;">Cancel</a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="return frmValidateAddHotProperty();" class="button-blue" style="text-decoration:none;">Submit</a>
                                </td>
                            </tr>
                            <?php
							}
                            ?>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>        
</form>  