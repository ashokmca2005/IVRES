<?php 
	$dayname 	= array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');
	$monthname 	= array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec');
	$yearname 	= array(date('Y')+0,date('Y')+1,date('Y')+2,date('Y')+3);
	$propListArr = $propertyObj->fun_getPropertyUserFavouritesArr($user_id);
?>
<!-- TinyMCE -->
<script type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		mode : "exact",
		elements : "txtUserEnquiryId",
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
		var shwError = false;
		var totalFav = <?php echo count($propListArr); ?>;
		var total = 0;
		for (var idx = 0; idx < totalFav; idx++) {
			if (document.getElementById("txtPropertyCheckId"+idx).checked == true) {
				total += 1;
			}
		}
		if(total < 1) {
			document.getElementById("txtPropertyCheckErrorId").innerHTML = "Please select property.";
			shwError = true;
		}

		if(document.getElementById("txtDayArrival0").value ==""){
			document.getElementById("arrivalDateError").innerHTML = "Please select arrival date";
			document.getElementById("txtDayArrival0").focus();
			shwError = true;
		}
		if(document.getElementById("txtMonthArrival0").value ==""){
			document.getElementById("arrivalDateError").innerHTML = "Please select arrival date";
			document.getElementById("txtMonthArrival0").focus();
			shwError = true;
		}
		if(document.getElementById("txtYearArrival0").value ==""){
			document.getElementById("arrivalDateError").innerHTML = "Please select arrival date";
			document.getElementById("txtYearArrival0").focus();
			shwError = true;
		}
		if(tinyMCE.get("txtUserEnquiryId").getContent() == "") {
			document.getElementById("userEnquiryErrorId").innerHTML = "Please enter your message";
			document.getElementById("txtUserEnquiryId").focus();
			shwError = true;
		}

		if(shwError == true) {
			return false;
		} else {
			document.frmPropertyContactOwner.submit();
		}
	}
</script>
<script language="javascript" type="text/javascript">
	function validateFrmLocSearch(){
		if(document.getElementById('SearchLocFld1').value == "eg Camps Bay or Cape Town ..."){
			document.getElementById('SearchLocFld1').value = "";
		}
	}
</script>
<link href="<?php echo SITE_URL;?>css/pop-up-cal.css" rel="stylesheet" type="text/css" />
<table width="690" border="0" cellspacing="0" cellpadding="0" class="font12">
<?php
if(is_array($propListArr) && count($propListArr) > 0) {
?>
    <tr>
        <td align="left" valign="top">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                	<td valign="top" class="pad-rgt10" width="50%">
                    <div class="pad-top15 pad-rgt5">
                    To make things easier, we offer you the opportunity to add as many favourites as you like.<p> Thus, you can always find your favorite holiday rentals and have the opportunity to access them quickly without having to search again. </p>                   
                  </div>
                    </td>
                    <td valign="top" class="pad-rgt10 pad-btm20">
                        <div class="gradientBox330" style="margin-top:15px; margin-bottom:5px;">
                            <div class="top">
                                <div class="btm">
                                    <div class="content">
                                        <table width="100%" border="0" cellpadding="2" cellspacing="0">
                                            <tr><td colspan="2" align="left" valign="top"><span class="pink14arial">Send these favourites to your friends</span></td></tr>
                                            <tr><td colspan="2" align="left" valign="top" class="pad-btm3"><strong>Just send them this link:</strong><br /><a href="<?php echo SITE_URL;?>favourites<?php echo $user_id;?>" class="blue-link"><?php echo SITE_URL;?>favourites<?php echo $user_id;?></a></td></tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" valign="top" class="pad-rgt10">
                        <table width="100%" border="0" cellpadding="5" cellspacing="0">
                            <tr><td align="left" valign="bottom" class="pad-lft5"><strong>Showing <?php echo count($propListArr); ?> of <?php echo count($propListArr); ?> favourites</strong></td></tr>
                            <tr><td valign="top"><?php require_once(SITE_INCLUDES_PATH.'ownerfavourities-show-listing.php'); ?></td></tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" valign="top" class="pad-rgt10" style="display:none;">
                    <a name="enquiryform">&nbsp;</a>
                    <form name="frmPropertyContactOwner" method="post" action="holiday-contact-owner-preview.php">
                    <input type="hidden" name="securityKey" value="<?php echo md5(OWNERCONTACT); ?>" />
                    <input type="hidden" name="txtPropertyId" id="txtPropertyId" value="" />
                        <table width="100%" border="0" cellpadding="5" cellspacing="0">
                            <tr>
                                <td valign="top">
                                    <div><span class="pink16">Contact form ...</span></div>
                                    <div class="pad-top15 pad-rgt5"><strong>Remember to tick the checkboxes next to the properties you wish to send this enquiry form to.</strong></div>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="120" align="right" valign="top" class="pad-top2">First name</td>
                                            <td valign="top" align="left" class="pad-btm10 pad-lft8"><input name="txtUserFName" type="text" class="textField370" value="<?php if(isset($_POST['txtUserFName'])) { echo $_POST['txtUserFName']; } else if(isset($users_first_name)) { echo $users_first_name;} ?>" /></td>
                                        </tr>
                                        <tr>
                                            <td width="120" align="right" valign="top" class="pad-top2">Last name</td>
                                            <td valign="top" align="left" class="pad-btm10 pad-lft8"><input name="txtUserLName" type="text" class="textField370" value="<?php if(isset($_POST['txtUserLName'])) { echo $_POST['txtUserLName']; } else if(isset($users_last_name)) { echo $users_last_name;} ?>" /></td>
                                        </tr>
                                        <tr>
                                            <td align="right" valign="top" class="pad-top2">Your email</td>
                                            <td align="left" valign="top" class="pad-btm12 pad-lft8"><input name="txtUserEmail" type="text" class="textField370" value="<?php if(isset($_POST['txtUserEmail'])) { echo $_POST['txtUserEmail']; } else if(isset($users_email_id)) { echo $users_email_id;} ?>" /></td>
                                        </tr>
                                        <tr>
                                            <td align="right" valign="top" class="pad-btm12 ">How many</td>
                                            <td class="pad-btm12">
                                            <p class="FloatLft pad-lft8">Adults</p>
                                            <p class="FloatLft pad-lft5">
                                                <?php
                                                $propertyObj->fun_createSelectNumField('txtAdults', 'txtAdultsId', 'adults', '', '', 1, 16);
                                                ?>
                                            </p>
                                            <p class="FloatLft pad-lft15">Children (2 -11)</p>
                                            <p class="FloatLft pad-lft5">
                                                <?php
                                                $propertyObj->fun_createSelectNumField('txtChilds', 'txtChildsId', 'adults', '', '', 1, 16);
                                                ?>
                                            </p>
                                            <p class="FloatLft pad-lft15">Infants (under 2)</p>
                                            <p class="FloatLft pad-lft5">
                                                <?php
                                                $propertyObj->fun_createSelectNumField('txtInfants', 'txtInfantsId', 'adults', '', '', 1, 16);
                                                ?>
                                            </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="right" valign="top" class="pad-btm12 ">Arrival date</td>
                                            <td class="pad-btm12 ">
                                                <p class="FloatLft pad-lft8">
                                                    <select name="txtDayArrival0" id="txtDayArrival0" class="PricesDate">
                                                        <option value=""> - - </option>
                                                        <?php
                                                        foreach($dayname as $key=>$value) {
                                                        ?>
                                                            <option value="<?=$value?>" <? if($value==$_POST['txtDayArrival0']){echo "selected";}else{echo "";}?>><?=($key+1)?></option>
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
                                                            <option value="<?=$key?>" <? if($key==$_POST['txtMonthArrival0']){echo "selected";}else{echo "";}?>><?=$value?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>                                        
                                                </p>
                                                <p class="FloatLft pad-lft5">
                                                    <select name="txtYearArrival0" id="txtYearArrival0" class="Listmenu60">										
                                                        <option value=""> - - </option>
                                                        <?php
                                                        foreach ($yearname as $value) {
                                                        ?>
                                                            <option value="<?=$value?>" <? if($value==$_POST['txtYearArrival0']){echo "selected";}else{echo "";}?>><?=$value?></option>
                                                        <?php

                                                        }
                                                        ?>
                                                    </select>                                        
                                                </p>
                                                <p class="FloatLft pad-lft3" style="padding-top:3px;"><a href="JavaScript:find_cal(<?php echo time()?>,'Arrival0');"><img src="<?php echo SITE_IMAGES;?>calender.gif" alt="calendar" /></a></p>
												<p class="FloatLft error" id="arrivalDateError"></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="right" valign="top" class="pad-btm12">Duration</td>
                                            <td class="pad-btm12 pad-lft8"><input type="text" name="txtDuration" id="txtDurationId" class="searchdaysEvents" value="" /> &nbsp;nights</td>
                                        </tr>
                                        <tr>
                                            <td align="right" valign="top" class="pad-btm12">Dates are flexible by</td>
                                            <td class="pad-btm12 pad-lft8"><input type="text" name="txtFlexibleDays" id="txtFlexibleDaysId" class="searchdaysEvents" value="" /> &nbsp;days</td>
                                        </tr>
                                        <tr>
                                            <td align="right" valign="top" class="pad-btm12">Message</td>
                                            <td class="pad-btm12 pad-lft8"><span style="padding-top:4px;"><textarea name="txtUserEnquiry" id="txtUserEnquiryId" cols="" rows="" class="textarea444" style="width:444px;"></textarea></span></td>
                                        </tr>
                                        <tr>
                                            <td align="right" valign="top">&nbsp;</td>
                                            <td class="pad-lft8"><span class="error" id="userEnquiryErrorId"></span></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>
                                                <table height="54" width="100%" style="padding:8px;" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td width="2%" align="left" valign="top"><input name="txtNewLetter" id="txtNewLetterId" type="checkbox" class="checkbox" value="1" checked="checked" /></td>
                                                        <td align="left" valign="top" style="padding-left:5px;"> Would you like to recieve the rentownersvillas.com newsletter?</td>
                                                    </tr>
                                                    <tr><td colspan="2" align="left" valign="top" class="pad-top7"><strong>By clicking send you are agreeing to our <a  href="javascript:popcontact('terms.html')" class="blue-link">Terms and conditions</a></strong></td></tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td class="pad-top7 pad-lft8">
												<div class="FloatLft pad-rgt10"><input type="image" src="images/submit.gif" alt="Send" border="0" onclick="return validate();" ></div>
												<div id="txtPropertyCheckErrorId" class="pad-top5 error" style="padding-left:10px;"></div>
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
        </td>
    </tr>
<?php
} else {
?>
    <tr>
        <td align="left" valign="top">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                	<td valign="top" class="pad-top20">
                        <span class="pink14arial">You currently have no favourite properties <img src="<?php echo SITE_IMAGES;?>smiles/icon_sad.gif" alt="smiles" /></span>
                    </td>
                </tr>
                <tr>
                	<td valign="top" class="pad-top20">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td align="left" valign="top" class="width22">&nbsp;</td>
                                <td align="left" valign="top" class="font12 pad-btm26">
                                    <form action="<?php echo SITE_URL; ?>property-search-results.php" method="post" name="frmLocSearch1" id="frmLocSearch1" onsubmit="validateFrmLocSearch()">
                                    <input type="hidden" name="searchKey" value="<?php echo md5(LOCATIONSEARCH)?>" />
                                    <div class="gradientBox690">
                                        <div class="top">
                                            <div class="btm">
                                                <div class="content" style="padding-left:30px;">
                                                    <table border="0" cellpadding="4" cellspacing="0">
                                                        <tr>
                                                            <td  align="left" valign="middle" class="gray18Arial">Find accommodation in</td>
                                                            <td  align="left" valign="middle"><input type="text" name="txtLocSearch" id="SearchLocFld1" class="searchBox" style="width:300px;" value="" autocomplete="off" /></td>
                                                            <td align="left" valign="middle"><input type="image" class="button-blue" alt="Search" /></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                                </td>
                                <td align="left" valign="top" class="width18">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
<?php
}
?>    
</table>