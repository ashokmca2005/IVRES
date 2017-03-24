<?php
$dayname 	= array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');
$monthname 	= array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec');
$yearname 	= array(date('Y')+0,date('Y')+1,date('Y')+2,date('Y')+3);
$stayname 	= array('01','02','03','04','05','06','07','08','09','10','11','12','13','14');
list($year1, $year2, $year3, $year4) = $yearname;
$propertyAvailInfo = $propertyObj->fun_getPropertyAvailabilityArr($property_id);
if(isset($_COOKIE['showOwnrAvaYear']) && ($_COOKIE['showOwnrAvaYear'] != "") && is_array($propertyAvailInfo) && count($propertyAvailInfo) > 0) {
	$showOwnrAvaYear = $_COOKIE['showOwnrAvaYear'];
}
?>
<script language="javascript" type="text/javascript">
//	var req = ajaxFunction();
	var x1 = "";
	var y1 = "";
	var m_names = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

	function find_cal(a,ct){
		var url="<?php echo SITE_URL;?>get_cal.php";

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
		var url="<?php echo SITE_URL;?>get_cal.php";

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
		var url="<?php echo SITE_URL;?>get_cal1.php";
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
		var url="<?php echo SITE_URL;?>get_cal.php";
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
	
	function find_cal4(a, ct){
		var strDayId = "txtDay"+ct;
		var strMonthId = "txtMonth"+ct;
		var strYearId = "txtYear"+ct;

		var mnt_cal = document.getElementById(strMonthId).value;
		var day_cal = document.getElementById(strDayId).value;
		var yr_cal  = document.getElementById(strYearId).value;
		
		if(mnt_cal != "" && day_cal != "" && yr_cal != "") {
			var url="<?php echo SITE_URL;?>get_cal2.php";
			url=url+"?mnt_cal="+mnt_cal+"&day_cal="+day_cal+"&yr_cal="+yr_cal+"&timestamp="+a+"&ct="+ct;
		} else {
			var url="<?php echo SITE_URL;?>get_cal1.php";
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

	function showYear(str) {
		var theYear = document.getElementById('strShowYearId')[document.getElementById('strShowYearId').selectedIndex].innerHTML;
		SetCookie("showOwnrAvaYear", parseInt(theYear));
		var caldiv = "";
		var calli = "";
		for(var i=1; i<=4; i++) {
			caldiv = "calendarsId"+i;
			calli = "strYearli"+i;
			if(i==str) {
				document.getElementById(caldiv).style.display = "block";
			} else {
				document.getElementById(caldiv).style.display = "none";
			}
		}
	}
	function getNightAlert() {
		var txtDayFrom = "txtDayFrom";
		var txtMonthFrom = "txtMonthFrom";
		var txtYearFrom = "txtYearFrom";
		var txtDayTo = "txtDayTo";
		var txtMonthTo = "txtMonthTo";
		var txtYearTo = "txtYearTo";

		var fromDate = new Date();
		var toDate = new Date();

		if(document.getElementById(txtDayFrom).value ==""){
			document.getElementById("availabilityErrorDiv").innerHTML = "Please select date from";
			document.getElementById(txtDayFrom).focus();
			return false;
		}
		
		if(document.getElementById(txtMonthFrom).value ==""){
			document.getElementById("availabilityErrorDiv").innerHTML = "Please select month from";
			document.getElementById(txtMonthFrom).focus();
			return false;
		}
		
		if(document.getElementById(txtYearFrom).value ==""){
			document.getElementById("availabilityErrorDiv").innerHTML = "Please select year from";
			document.getElementById(txtYearFrom).focus();
			return false;
		}
		
		if(document.getElementById(txtDayTo).value =="") {
			document.getElementById("availabilityErrorDiv").innerHTML = "Please select date to";
			document.getElementById(txtDayTo).focus();
			return false;
		}
		
		if(document.getElementById(txtMonthTo).value =="") {
			document.getElementById("availabilityErrorDiv").innerHTML = "Please select month to";
			document.getElementById(txtMonthTo).focus();
			return false;
		}
		
		if(document.getElementById(txtYearTo).value =="") {
			document.getElementById("availabilityErrorDiv").innerHTML = "Please select year to";
			document.getElementById(txtYearTo).focus();
			return false;
		}

		fromDate.setYear(document.getElementById(txtYearFrom).value);
		fromDate.setMonth(document.getElementById(txtMonthFrom).value - 1);
		fromDate.setDate(document.getElementById(txtDayFrom).value);

		toDate.setYear(document.getElementById(txtYearTo).value);
		toDate.setMonth(document.getElementById(txtMonthTo).value - 1);
		toDate.setDate(document.getElementById(txtDayTo).value);

		for (var i=0; i < document.frmProperty.txtAvailabilityStatus.length; i++){
			if (document.frmProperty.txtAvailabilityStatus[i].checked) {
				var strStatus = document.frmProperty.txtAvailabilityStatus[i].value;
			}
		}

		if(parseInt(strStatus) == 1) {
			var strStatusTxt = "Unknown";
		} else if(parseInt(strStatus) == 2) {
			var strStatusTxt = "Avalable";
		} else if(parseInt(strStatus) == 3) {
			var strStatusTxt = "Booked";
		} else {
			var strStatusTxt = "Unknown";
		}

		//Set 1 day in milliseconds
		var strOneDay = 1000*60*60*24;
		//Calculate difference btw the two dates, and convert to days
		var totalNightDiff = Math.ceil((toDate.getTime()-fromDate.getTime())/(strOneDay));
		if(totalNightDiff == 1) {
			document.getElementById("txtNightId").innerHTML = totalNightDiff+" night to "+strStatusTxt+"!";
			document.getElementById("txtNightDateId").innerHTML = m_names[fromDate.getMonth()]+" "+fromDate.getDate()+", "+fromDate.getFullYear()+" - "+m_names[toDate.getMonth()]+" "+toDate.getDate()+", "+toDate.getFullYear();
			toggleLayer1('changeAvailability-pop-up');
		} else if(totalNightDiff > 1) {
			document.getElementById("txtNightId").innerHTML = totalNightDiff+" nights to  "+strStatusTxt+"!"; 
			document.getElementById("txtNightDateId").innerHTML = m_names[fromDate.getMonth()]+" "+fromDate.getDate()+", "+fromDate.getFullYear()+" - "+m_names[toDate.getMonth()]+" "+toDate.getDate()+", "+toDate.getFullYear();
			toggleLayer1('changeAvailability-pop-up');
		} else {
			document.getElementById("availabilityErrorDiv").innerHTML = "Please select correct date";
			document.getElementById(txtDayFrom).focus();
			return false;
		}
	}

	function submitAvailabilityStatus() {
		document.getElementById("addAvailablityId").value = "1";
		toggleLayer1('changeAvailability-pop-up');
		frmSubmit();
	}

	function frmSubmit(){
		var theYear = document.getElementById('txtYearTo').value;
		if(theYear != "") {
			SetCookie("showOwnrAvaYear", parseInt(theYear));
		}
		document.frmProperty.submit();
	}

</script>
<form name="frmProperty" id="frmPropertyId" action="<?php echo $linkava;?>" method="post">
    <input type="hidden" name="securityKey" value="<?php echo md5(OWNERPROPERTYAVAILABILITY);?>" />
    <input type="hidden" name="addAvailablity" id="addAvailablityId" value="0" />
    <div class="width690" style="padding-top: 15px; padding-bottom:40px;">
        <div id="showAddAvailabilityFrm">
            <div class="width690 pad-btm25">
				<?php /*?>                
                <div class="FloatLft pad-top5"><span class="pink18arial pad-rgt5">Add / edit status of your calender...</span></div>
                <?php */?>                
				<div class="FloatRgt pad-rgt4"><a href="#" onclick="document.getElementById('addAvailablityId').value = '1';return frmSubmit();" class="button-blue">Save details</a></div>
            </div>                
            <div class="width690 dash-top pad-top15">
                <div class="width690 dash-btm pad-btm20">
                    <table width="96%" align="center" border="0" cellpadding="2" cellspacing="0">
                        <?php
                            $msg = $_GET['msg'];
                            if($msg == "updatesuccess") {
                                echo "<tr>";
                                echo "<td colspan=\"3\" align=\"left\" valign=\"top\" class=\"pad-btm20\">";
                                echo "<div id=\"txtAvailabilityHeaderId\" class=\"successHeading\">Successfully updated</div>";
                                echo "</td>";
                                echo "</tr>";
                            } else {
                                echo "<tr>";
                                echo "<td colspan=\"3\" align=\"left\" valign=\"top\" class=\"pad-btm20\">";
                                echo "<div id=\"txtAvailabilityHeaderId\" class=\"font16-darkgrey\">Update your calender</div>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        ?>
                        <tr>
                            <td width="89" align="right" valign="middle" class="pad-btm3 pad-rgt10">Arrival date</td>
                            <td width="637" colspan="2" align="left" valign="top" class="pad-btm3 pad-lft5">
                                <table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td>
                                            <table border="0" cellpadding="1" cellspacing="0">
                                                <tr>
                                                    <td>
                                                    <select name="txtDayFrom" id="txtDayFrom" class="Listmenu45" onchange="fill_to_from_date();">
                                                        <option value=""> - - </option>
                                                        <?
                                                        foreach($dayname as $key => $value) {
                                                        ?>
                                                            <option value="<?=$value?>"><?=($key+1)?></option>
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
                                                            <option value="<?=$key?>"><?=$value?></option>
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
                                                            <option value="<?=$value?>"><?=$value?></option>
                                                        <?
                                                        }
                                                        ?>
                                                    </select>															
                                                    </td>
                                                    <td align="right"><a href="JavaScript:find_cal(<?php echo time()?>, 'From');"><img src="<?php echo SITE_IMAGES;?>calender.gif" alt="calendar" /></a></td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td class="pad-rgt5 pad-lft10">Departure date</td>
                                        <td>
                                            <table border="0" cellpadding="2" cellspacing="0">
                                                <tr>
                                                    <td>
                                                        <select name="txtDayTo" id="txtDayTo" class="Listmenu45">
                                                            <option value=""> - - </option>
                                                            <?
                                                            foreach($dayname as $key => $value) {
                                                            ?>
                                                                <option value="<?=$value?>"><?=($key+1)?></option>
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
                                                                <option value="<?=$key?>"><?=$value?></option>
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
                                                                <option value="<?=$value?>"><?=$value?></option>
                                                            <?
                                                            }
                                                            ?>
                                                        </select>															
                                                    </td>
                                                    <td align="right"><a href="JavaScript:find_cal4(<?php echo time()?>,'To');"><img src="<?php echo SITE_IMAGES;?>calender.gif" alt="calendar" /></a></td>
                                                </tr>
                                            </table>												
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td align="right" valign="top" class="pad-btm3 pad-top10 pad-rgt10">Status</td>
                            <td colspan="2" align="left" valign="top" class="pad-btm3 pad-top10 pad-lft5">
                                <table border="0" cellpadding="0" cellspacing="0" class="blackText">
                                    <tr>
                                        <td><input name="txtAvailabilityStatus" type="radio" value="2" class="radio" id="txtAvailabilityStatusId1" /></td>
                                        <td class="pad-rgt10 pad-left7"><strong>Available</strong></td>
                                        <td><input name="txtAvailabilityStatus" type="radio" value="3" class="radio" id="txtAvailabilityStatusId2" /></td>
                                        <td class="pad-left7 pad-rgt10"><strong>Booked</strong></td>
                                        <td><input name="txtAvailabilityStatus" type="radio" value="1" class="radio" id="txtAvailabilityStatusId3" checked="checked" /></td>
                                        <td class="pad-lft5"><strong>Unknown | Unavailable</strong></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" valign="top" class="pad-btm3 pad-top12">&nbsp;</td>
                            <td colspan="2" align="left" valign="top" class="pad-btm3 pad-top7 pad-lft5">
                            <div class="FloatLft pad-rgt5">
                                <a href="#" onClick="getNightAlert();"><img src="<?php echo SITE_IMAGES;?>updatecalendar.gif" alt="Update Calender" width="117" height="27" /></a>
                            </div>
                            <div id="availabilityErrorDiv" class="pad-top5 error"><?php echo $form_array['availabilityError']; ?></div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="changeAvailability-pop-up" class="box cursor1" style="display:none; background:transparent; position:absolute; left:250px; top:383px;">
        <!--[if IE]><iframe id="iframe" frameborder="0" style="position:absolute;top:4px;left:204px;width:310px; height:180px;"></iframe><![endif]-->
        <div class="content">
            <div onMouseDown="dragStart(event, 'changeAvailability-pop-up');" style="position:relative; z-index:999; left:200px; width:325px;">
                <table width="325" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="right"><img src="<?php echo SITE_IMAGES;?>poplefttop.png" alt="ANP" height="10" width="10" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo SITE_IMAGES;?>poplefttop.png', sizingMethod='scale');" /></td>
                        <td class="topp"></td>
                        <td><img src="<?php echo SITE_IMAGES;?>poprighttop1.png" alt="ANP"  height="10" width="15" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo SITE_IMAGES;?>poprighttop1.png', sizingMethod='scale');"/></td>
                    </tr>
                    <tr>
                        <td class="leftp"></td>
                        <td  align="left" valign="top" bgcolor="#FFFFFF" style="padding:6px; padding-left:15px;">
                            <table width="100%"  border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td   align="left" valign="top" class="pink18arial pad-top7">You are changing...</td>
                                    <td align="right" valign="top" class="pad-rgt4"><a href="javascript:toggleLayer1('changeAvailability-pop-up');"><img src="<?php echo SITE_IMAGES;?>pop-up-cross.gif" alt="Close" title="Close" border="0" /></a></td>
                                </tr>
                                <tr>
                                    <td align="left" valign="top" style="padding-top:20px;"><div class="gray18" id="txtNightId"></div></td>
                                    <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="left" valign="top" style="padding-top:10px;"><div class="PopTxt lineHight18" id="txtNightDateId"></div></td>
                                    <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr><td colspan="2" align="center" valign="middle"><div id="errorDiv"></div></td></tr>
                                <tr>
                                    <td colspan="2" align="left" valign="top">
                                        <table width="94%" border="0" cellpadding="0" cellspacing="0">
                                            <tr><td align="left" valign="top" class="buttons">&nbsp;</td></tr>
                                            <tr><td align="left" valign="top" class="buttons">&nbsp;</td></tr>
                                            <tr>
                                                <td align="left" valign="top" class="buttons">
                                                <a href="javascript:toggleLayer1('changeAvailability-pop-up');void(0);"><img src="<?php echo SITE_IMAGES;?>editnew-gray.gif"  alt="Edit" name="Edit" border="0" /></a>
                                                <img src="<?php echo SITE_IMAGES;?>spacer.gif" alt="One" width="4" />&nbsp;
                                                <a href="JavaScript:submitAvailabilityStatus();"><img src="<?php echo SITE_IMAGES;?>confirm.gif"  alt="Confirm" name="Confirm"  border="0"  /></a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td class="rightp" width="10"></td>
                    </tr>
                    <tr>
                        <td align="right"><img src="<?php echo SITE_IMAGES;?>popleftbtm.png" alt="ANP" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo SITE_IMAGES;?>popleftbtm.png', sizingMethod='crop');" width="10" height="10"/></td>
                        <td  class="bottomp"></td>
                        <td align="left"><img src="<?php echo SITE_IMAGES;?>poprightbtm1.png" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo SITE_IMAGES;?>poprightbtm1.png', sizingMethod='crop');" width="15" height="10" alt="ANP"/></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="calendars">
        <div class="FloatLft">
            <p class="key">View</p>
            <span>
            <select name="strShowYear" id="strShowYearId" onchange="showYear(this.value);" class="Listmenu80 FloatLft">
                <option value="1" <?php if($showOwnrAvaYear == $year1) { echo "selected=\"selected\"";} ?>><?php echo $year1; ?></option>
                <option value="2" <?php if($showOwnrAvaYear == $year2) { echo "selected=\"selected\"";} ?>><?php echo $year2; ?></option>
                <option value="3" <?php if($showOwnrAvaYear == $year3) { echo "selected=\"selected\"";} ?>><?php echo $year3; ?></option>
                <option value="4" <?php if($showOwnrAvaYear == $year4) { echo "selected=\"selected\"";} ?>><?php echo $year4; ?></option>
            </select> 
            </span>
        </div>
        <div class="FloatLft pad-lft15">
            <p class="key1">Key</p>
            <p class="available1">Available</p>
            <p class="booked1">Booked</p>
            <p class="unavailable1">Unknown | Unavailable</p>
        </div>
    </div>

    <div id="showCalenderId">
        <!-- THIS DIV IS FOR SHOW YEAR ONE CALENDAR START -->
        <div class="calendars" id="calendarsId1" style="display:<?php if((isset($showOwnrAvaYear) && ($showOwnrAvaYear != $year2) && ($showOwnrAvaYear != $year3) && ($showOwnrAvaYear != $year4)) || ($showOwnrAvaYear == "")) { echo "block";} else { echo "none";} ?>;">
			<?php echo $calendarObj->getYearPropertyAvailablityHTML($year1, $propertyAvailInfo); ?>
        </div>
        <!-- THIS DIV IS FOR SHOW YEAR ONE CALENDAR END -->
        <!-- THIS DIV IS FOR SHOW YEAR TWO CALENDAR START -->
        <div class="calendars" id="calendarsId2" style="display:<?php if(isset($showOwnrAvaYear) && ($showOwnrAvaYear == $year2)) { echo "block";} else { echo "none";} ?>;">
			<?php echo $calendarObj->getYearPropertyAvailablityHTML($year2, $propertyAvailInfo); ?>
        </div>
        <!-- THIS DIV IS FOR SHOW YEAR TWO CALENDAR END -->
        <!-- THIS DIV IS FOR SHOW YEAR THREE CALENDAR START -->
        <div class="calendars" id="calendarsId3"  style="display:<?php if(isset($showOwnrAvaYear) && ($showOwnrAvaYear == $year3)) { echo "block";} else { echo "none";} ?>;">
			<?php echo $calendarObj->getYearPropertyAvailablityHTML($year3, $propertyAvailInfo); ?>
        </div>
        <!-- THIS DIV IS FOR SHOW YEAR THREE CALENDAR END -->
        <!-- THIS DIV IS FOR SHOW YEAR FOUR CALENDAR START -->
        <div class="calendars" id="calendarsId4" style="display:<?php if(isset($showOwnrAvaYear) && ($showOwnrAvaYear == $year4)) { echo "block";} else { echo "none";} ?>;">
			<?php echo $calendarObj->getYearPropertyAvailablityHTML($year4, $propertyAvailInfo); ?>
        </div>
        <!-- THIS DIV IS FOR SHOW YEAR FOUR CALENDAR END -->
    </div>
    <div class="width690 dash41"></div>
    <div class="width690">
        <div class="pad-btm15" align="right"><a href="#" onclick="document.getElementById('addAvailablityId').value = '1';return frmSubmit();" class="button-blue">Save details</a></div>
    </div>
</form>
