<?php 
	$dayname 	= array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');
	$monthname 	= array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec');
	$yearname 	= array(date('Y')+0,date('Y')+1,date('Y')+2,date('Y')+3);
?>
<!-- TinyMCE -->
<script type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		mode : "exact",
		elements : "txtUserMessageId",
		theme : "simple",
		plugins : 'advlink,advimage',
		relative_urls : false,
		remove_script_host : false
	});
</script>
<!-- /TinyMCE -->
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

	function validate() {
	
	
	}

	function cancelEnquiry(strEnquiryId) {
		req.onreadystatechange = handleDeleteEnquiryResponse;
		req.open('get', '<?php echo SITE_URL;?>enquirydeleteXml.php?enquiry='+strEnquiryId); 
		req.send(null);   
	}

	function handleDeleteEnquiryResponse() {
		if(req.readyState == 4) {
			var response=req.responseText;
			xmlDoc=req.responseXML;
			var root = xmlDoc.getElementsByTagName('enquiries')[0];
			if(root != null){
				var items = root.getElementsByTagName("enquiry");
                var item = items[0];
                var enquirystatus = item.getElementsByTagName("enquirystatus")[0].firstChild.nodeValue;
                if(enquirystatus == "Enquiry deleted.") {
                    window.location = '<?php if(isset($_SESSION['ses_user_home']) && $_SESSION['ses_user_home'] !=""){echo $_SESSION['ses_user_home'];} else {echo SITE_URL;}?>';
                }
			}
		}
	}
</script>
<link href="<?php echo SITE_URL;?>css/pop-up-cal.css" rel="stylesheet" type="text/css" />
<table border="0" cellspacing="0" cellpadding="0" width="100%" class="font12">
    <tr>
        <td valign="top" class="pad-rgt10">
            <table width="100%" border="0" cellpadding="5" cellspacing="0">
                <tr><td valign="top"><?php require_once(SITE_INCLUDES_PATH.'bookingedit-show-listing.php'); ?></td></tr>
            </table>
        </td>
    </tr>
    <tr>
        <td valign="top" class="pad-rgt10">
        <a name="enquiryform">&nbsp;</a>
        <form name="frmPropertyContactOwner" method="post" action="holiday-property-booking-preview.php?booking=<?php echo $booking_id;?>">
        <input type="hidden" name="securityKey" value="<?php echo md5(BOOKINGENGINE); ?>" />
        <input type="hidden" name="txtPropertyId" id="txtPropertyId" value="<?php echo $txtPropertyId; ?>" />
            <table width="100%" border="0" cellpadding="5" cellspacing="0">
                <tr>
                    <td valign="top">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="120" align="right" valign="top" class="pad-top2">First name</td>
                                <td valign="top" align="left" class="pad-btm10 pad-lft8"><input name="txtUserFName" id="txtUserFNameId" type="text" class="textField370" value="<?php if(isset($txtUserFName)) { echo $txtUserFName; } ?>" /></td>
                            </tr>
                            <tr>
                                <td width="120" align="right" valign="top" class="pad-top2">Last name</td>
                                <td valign="top" align="left" class="pad-btm10 pad-lft8"><input name="txtUserLName" id="txtUserLNameId" type="text" class="textField370" value="<?php if(isset($txtUserLName)) { echo $txtUserLName; } ?>" /></td>
                            </tr>
                            <tr>
                                <td align="right" valign="top" class="pad-top2">Your email</td>
                                <td align="left" valign="top" class="pad-btm12 pad-lft8"><input name="txtUserEmail" id="txtUserEmailId" type="text" class="textField370" value="<?php if(isset($txtUserEmail)) { echo $txtUserEmail; } ?>" /></td>
                            </tr>
                            <tr>
                                <td align="right" valign="top" class="pad-top2">Your phone</td>
                                <td align="left" valign="top" class="pad-btm12 pad-lft8"><input name="txtUserPhone" id="txtUserPhoneId" type="text" class="textField370" value="<?php if(isset($txtUserPhone)) { echo $txtUserPhone; } ?>" /></td>
                            </tr>
                            <tr>
                                <td align="right" valign="top" class="pad-btm12 " style="padding-top:9px;">How many</td>
                                <td class="pad-btm1">
                                <p class="FloatLft pad-lft8">Adults</p>
                                <p class="FloatLft pad-lft5">
                                    <?php
                                    $propertyObj->fun_createSelectNumField('txtAdults', 'txtAdultsId', 'adults', $txtAdults, '', 1, 16);
                                    ?>
                                </p>
                                <p class="FloatLft pad-lft15">Children (2 -11)</p>
                                <p class="FloatLft pad-lft5">
                                    <?php
                                    $propertyObj->fun_createSelectNumField('txtChilds', 'txtChildsId', 'adults', $txtChilds, '', 1, 16);
                                    ?>
                                </p>
                                <p class="FloatLft pad-lft15">Infants (under 2)</p>
                                <p class="FloatLft pad-lft5">
                                    <?php
                                    $propertyObj->fun_createSelectNumField('txtInfants', 'txtInfantsId', 'adults', $txtInfants, '', 1, 16);
                                    ?>
                                </p>
                                </td>
                            </tr>
                            <tr>
                                <td align="right" valign="top" class="pad-btm12 "style="padding-top:9px;">Arrival date</td>
                                <td class="pad-btm12 ">
                                    <p class="FloatLft pad-lft8">
                                        <select name="txtDayArrival0" id="txtDayArrival0" class="PricesDate">
                                            <option value=""> - - </option>
                                            <?php
                                            foreach($dayname as $key=>$value) {
                                            ?>
                                                <option value="<?=$value?>" <? if($value==$txtDayArrival0){echo "selected";}else{echo "";}?>><?=($key+1)?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>                                        
                                    </p>
                                    <p class="FloatLft pad-lft5">
                                        <select name="txtMonthArrival0" id="txtMonthArrival0" class="PricesDate">										
                                            <option value=""> - - </option>
                                            <?php
                                            foreach ($monthname as $key => $value) {
                                            ?>
                                                <option value="<?=$key?>" <? if($key==$txtMonthArrival0){echo "selected";}else{echo "";}?>><?=$value?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>                                        
                                    </p>
                                    <p class="FloatLft pad-lft5">
                                        <select name="txtYearArrival0" id="txtYearArrival0" class="PricesDate">										
                                            <option value=""> - - </option>
                                            <?php
                                            foreach ($yearname as $value) {
                                            ?>
                                                <option value="<?=$value?>" <? if($value==$txtYearArrival0){echo "selected";}else{echo "";}?>><?=substr($value, 2, strlen($value))?></option>
                                            <?php

                                            }
                                            ?>
                                        </select>                                        
                                    </p>
                                    <p class="FloatLft pad-lft3" style="padding-top:3px;"><a href="JavaScript:find_cal(<?php echo time()?>,'Arrival0');"><img src="<?php echo SITE_IMAGES;?>calender.gif" alt="calendar" /></a></p>
                                </td>
                            </tr>
                            
                            <tr>
                                <td align="right" valign="top" class="pad-btm12 "style="padding-top:9px;">Departure date</td>
                                <td class="pad-btm12 ">
                                   <p class="FloatLft pad-lft8">
                                        <select name="txtDayDeparture0" id="txtDayDeparture0" class="PricesDate">
                                            <option value=""> - - </option>
                                            <?php
                                            foreach($dayname as $key=>$value) {
                                            ?>
                                                <option value="<?=$value?>" <? if($value==$txtDayDeparture0){echo "selected";}else{echo "";}?>><?=($key+1)?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>                                        
                                    </p>
                                    <p class="FloatLft pad-lft5">
                                        <select name="txtMonthDeparture0" id="txtMonthDeparture0" class="PricesDate">										
                                            <option value=""> - - </option>
                                            <?php
                                            foreach ($monthname as $key => $value) {
                                            ?>
                                                <option value="<?=$key?>" <? if($key==$txtMonthDeparture0){echo "selected";}else{echo "";}?>><?=$value?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>                                        
                                    </p>
                                    <p class="FloatLft pad-lft5">
                                        <select name="txtYearDeparture0" id="txtYearDeparture0Id" class="PricesDate">										
                                            <option value=""> - - </option>
                                            <?php
                                            foreach ($yearname as $value) {
                                            ?>
                                                <option value="<?=$value?>" <? if($value==$txtYearDeparture0){echo "selected";}else{echo "";}?>><?=substr($value, 2, strlen($value))?></option>
                                            <?php

                                            }
                                            ?>
                                        </select>                                        
                                    </p>
                                    <p class="FloatLft pad-lft3" style="padding-top:3px;"><a href="JavaScript:find_cal(<?php echo time()?>,'Arrival0');"><img src="<?php echo SITE_IMAGES;?>calender.gif" alt="calendar" /></a></p>
                                </td>
                            </tr>
                            <tr>
                                <td align="right" valign="top" class="pad-btm12 ">Message</td>
                                <td class="pad-btm12 pad-lft8"><span style="padding-top:4px;"><textarea name="txtUserMessage" id="txtUserMessageId" cols="" rows="" class="textarea444" style="width:444px;"><?php if(isset($txtUserMessage)) { echo $txtUserMessage; } ?></textarea></span></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <table height="54" width="100%" style="padding:8px;" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td width="2%" align="left" valign="top"><input name="txtNewLetter" id="txtNewLetterId" type="checkbox" class="checkbox" value="1" <?php if($txtNewLetter==1) { echo "checked=\"checked\"";} ?> /></td>
                                            <td align="left" valign="top" style="padding-left:5px;"> Would you like to recieve the rentownersvillas.com newsletter?</td>
                                        </tr>
                                        <tr><td colspan="2" align="left" valign="top" class="pad-top7"><strong>By clicking send you are agreeing to our <a  href="javascript:popcontact('terms.html')" class="blue-link">Terms and conditions</a></strong></td></tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td class="pad-top7 pad-lft8">
                                <a href="javascript:cancelEnquiry(<?php echo $enquiry_id; ?>);"><img src="<?php echo SITE_IMAGES;?>cancel-gray.gif" alt="Cancel" width="81" height="27" /></a>&nbsp;&nbsp;<input type="image" src="<?php echo SITE_IMAGES;?>submit.gif" alt="Send" border="0" onclick="return validate();" >
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </form>
        </td>
    </tr>
</table>
