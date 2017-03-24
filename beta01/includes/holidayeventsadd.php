<!-- TinyMCE -->
<script type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		mode : "exact",
		elements : "txtEventDescId",
		handle_event_callback : "myHandleEvent",
		theme : "simple",
		plugins : 'advlink,advimage',
		relative_urls : false,
		remove_script_host : false
	});

	//event such as key or mouse press
	function myHandleEvent(e){
		if(e.type=="keyup"){
			chkblnkEditorTxtError("txtEventDescId", "txtEventDescErrorId");	
		}
		return true;
	}
</script>
<!-- /TinyMCE -->
<script language="javascript" type="text/javascript">
	var req = ajaxFunction();
	function addEvent1() {
		var strTable1 = "";
		var ni = document.getElementById('myDiv1');
		var numi = document.getElementById('theValue');
		var num = (document.getElementById("theValue").value -1)+ 2;
		numi.value = num;
		var divIdName = "my"+num+"Div";
		
		var strCat = "<?php $eventObj->fun_getEventCategoryTypeOptionsList(); ?>";
		
		var newdiv = document.createElement('div');
		newdiv.setAttribute("id",divIdName);
		strTable1 += "<table width='100%' cellspacing='0' border='0' cellpadding='0'>";
		strTable1 += "<tr>";
		strTable1 += "<td class='pad-top1' align='right' height='23' valign='top' width='190'>&nbsp;</td>";
		strTable1 += "<td class='pad-lft5' valign='top' width='249'>";
		strTable1 += "<select name='txtEventCategory[]' class='select216'>";
		strTable1 += "<option value=\"\">Select...</option>";
		strTable1 += strCat;
		strTable1 += "</select>";
		strTable1 += "</td>";
		strTable1 += "<td width='10'>&nbsp;</td>";
		strTable1 += "<td class='pad-top1' valign='top' width='240'> <a href=\"javascript:void(0);\" class='delete-evnt-cat' onclick=\"removeElement1(\'"+divIdName+"\')\">Delete</a></td>";
		strTable1 += "</tr>";
		strTable1 += "</table>";
		newdiv.innerHTML = strTable1;
		ni.appendChild(newdiv);
	}

	function removeElement1(divNum) {
		var d = document.getElementById('myDiv1');
		var olddiv = document.getElementById(divNum);
		d.removeChild(olddiv);
	}

	function frmValidateAddEvent() {
		var shwError = false;

//alert(document.getElementById("txtAddEventSubRegionId").value);
/*
		if(document.getElementById("txtTermConditionsId").checked != true) {
			document.getElementById("txtTermConditionsErrorId").innerHTML = "Please read term and conditions.";
			shwError = true;
		}
*/

		if(tinyMCE.get("txtEventDescId").getContent() == "") {
//		alert(document.getElementById("txtEventDescId").value);
//		alert("fjsdfj");
			document.getElementById("txtEventDescErrorId").innerHTML = "Please enter event description.";
			document.getElementById("txtEventDescId").focus();
			shwError = true;
		}

/*
		if(document.frmAddEvent.txtEventWebsite.value == "") {
			document.getElementById("txtEventWebsiteErrorId").innerHTML = "Please enter event website.";
			document.frmAddEvent.txtEventWebsite.focus();
			shwError = true;
		}

		if(document.frmAddEvent.txtEventEmail.value == "") {
			document.getElementById("txtEventEmailErrorId").innerHTML = "Please enter valid email id.";
			document.frmAddEvent.txtEventEmail.focus();
			shwError = true;
		} else {
			var emailRegxp1 = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			if (emailRegxp1.test(document.getElementById("txtEventEmailId").value)!= true){
				document.getElementById("txtEventEmailErrorId").innerHTML = "Please enter valid email id.";
				document.frmAddEvent.txtEventEmail.value = "";
				document.frmAddEvent.txtEventEmail.focus();
				shwError = true;
			}
		}

		if(document.frmAddEvent.txtEventPhone.value == "") {
			document.getElementById("txtEventPhoneErrorId").innerHTML = "Please enter phone number.";
			document.frmAddEvent.txtEventPhone.focus();
			shwError = true;
		}
		if(document.frmAddEvent.txtEventVenue.value == "") {
			document.getElementById("txtEventVenueErrorId").innerHTML = "Please enter event venue.";
			document.frmAddEvent.txtEventVenue.focus();
			shwError = true;
		}
*/

		if(document.getElementById("txtYearRoundId2").checked == true) {
			if(document.frmAddEvent.txtDayFrom1.value == "") {
				document.getElementById("txtDateFromErrorId").innerHTML = "Please select a start date!";
				document.frmAddEvent.txtDayFrom1.focus();
				shwError = true;
			} else if(document.frmAddEvent.txtMonthFrom1.value == "") {
				document.getElementById("txtDateFromErrorId").innerHTML = "Please select a start date!";
				document.frmAddEvent.txtMonthFrom1.focus();
				shwError = true;
			} else if(document.frmAddEvent.txtYearFrom1.value == "") {
				document.getElementById("txtDateFromErrorId").innerHTML = "Please select a start date!";
				document.frmAddEvent.txtYearFrom1.focus();
				shwError = true;
			}

			if(document.frmAddEvent.txtDayTo1.value == "") {
				document.getElementById("txtDateToErrorId").innerHTML = "Please select an end date!";
				document.frmAddEvent.txtDayTo1.focus();
				shwError = true;
			} else if(document.frmAddEvent.txtMonthTo1.value == "") {
				document.getElementById("txtDateToErrorId").innerHTML = "Please select an end date!";
				document.frmAddEvent.txtMonthFrom1.focus();
				shwError = true;
			} else if(document.frmAddEvent.txtYearTo1.value == "") {
				document.getElementById("txtDateToErrorId").innerHTML = "Please select an end date!";
				document.frmAddEvent.txtYearFrom1.focus();
				shwError = true;
			}

			if(document.frmAddEvent.txtDayFrom1.value != "" && document.frmAddEvent.txtMonthFrom1.value != "" && document.frmAddEvent.txtYearFrom1.value != "" && document.frmAddEvent.txtDayTo1.value != "" && document.frmAddEvent.txtMonthTo1.value != "" && document.frmAddEvent.txtYearTo1.value != "") {
				var fromDate = new Date();
				var toDate = new Date();
				fromDate.setYear(document.frmAddEvent.txtYearFrom1.value);
				fromDate.setMonth(document.frmAddEvent.txtMonthFrom1.value - 1);
				fromDate.setDate(document.frmAddEvent.txtDayFrom1.value);
				toDate.setYear(document.frmAddEvent.txtYearTo1.value);
				toDate.setMonth(document.frmAddEvent.txtMonthTo1.value - 1);
				toDate.setDate(document.frmAddEvent.txtDayTo1.value);
	
				if(Date.parse(fromDate) > Date.parse(toDate)) {
					document.getElementById("txtDateToErrorId").innerHTML = "Please select correct end date!";
					document.frmAddEvent.txtYearTo1.focus();
					shwError = true;
				}
			}
		}

		if(document.frmAddEvent.txtEventCategoryId0.value == "") {
			document.getElementById("txtEventCategoryErrorId").innerHTML = "Please select event category.";
			document.frmAddEvent.txtEventCategoryId0.focus();
			shwError = true;
		}

		if(document.frmAddEvent.txtEventName.value == "" || document.frmAddEvent.txtEventName.value == "This will appear on search listings") {
			document.getElementById("txtEventNameErrorId").innerHTML = "Please enter event name.";
			document.frmAddEvent.txtEventName.focus();
			shwError = true;
		}

		if(document.frmAddEvent.txtEventOwnerEmail.value == "") {
			document.getElementById("txtEventOwnerEmailErrorId").innerHTML = "Please enter valid email id.";
			document.frmAddEvent.txtEventOwnerEmail.focus();
			shwError = true;
		} else {
			var emailRegxp = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			var txtemail = document.frmAddEvent.txtEventOwnerEmail.value;
			if (emailRegxp.test(document.getElementById("txtEventOwnerEmailId").value)!= true){
				document.getElementById("txtEventOwnerEmailErrorId").innerHTML = "Please enter valid email id.";
				document.frmAddEvent.txtEventOwnerEmail.value = "";
				document.frmAddEvent.txtEventOwnerEmail.focus();
				shwError = true;
			}
		}
		
		if(document.frmAddEvent.txtEventOwnerLName.value == "") {
			document.getElementById("txtEventOwnerLNameErrorId").innerHTML = "Please enter last name.";
			document.frmAddEvent.txtEventOwnerLName.focus();
			shwError = true;
		}

		if(document.frmAddEvent.txtEventOwnerFName.value == "") {
			document.getElementById("txtEventOwnerFNameErrorId").innerHTML = "Please enter first name.";
			document.frmAddEvent.txtEventOwnerFName.focus();
			shwError = true;
		}

		if(document.frmAddEvent.txtEventPrice.value == "These will appear exactly as typed") {
			document.frmAddEvent.txtEventPrice.value = "";
		}

		if(document.frmAddEvent.txtEventTime.value == "eg opening times or show times") {
			document.frmAddEvent.txtEventTime.value = "";
		}

		if(shwError == true) {
			return false;
		} else {
			document.frmAddEvent.action = "holiday-events-preview.php";
			document.frmAddEvent.submit();
		}
	}

	function chkblnkTxtError(strFieldId, strErrorFieldId) {
		if(document.getElementById(strFieldId).value != "") {
			document.getElementById(strErrorFieldId).innerHTML = "";
		}
	}

	function chkblnkEditorTxtError(strFieldId, strErrorFieldId) {
		if(tinyMCE.get(strFieldId).getContent() != "") {
			document.getElementById(strErrorFieldId).innerHTML = "";
		}
	}

	function cancelAddEvent(strEventTmpId){
		req.onreadystatechange = handleDeleteTmpResponse;
		req.open('get', '<?php echo SITE_URL;?>eventtmpdeleteXml.php?evtid='+strEventTmpId); 
		req.send(null);   
	}

	function handleDeleteTmpResponse(){
		var arrayOfEventStatus 	= new Array();
		if(req.readyState == 4){
			var response=req.responseText;
			xmlDoc=req.responseXML;
			var root = xmlDoc.getElementsByTagName('events')[0];
			if(root != null){
				var items = root.getElementsByTagName("event");
				for (var i = 0 ; i < items.length ; i++){
					var item 				= items[i];
					var eventstatus 		= item.getElementsByTagName("eventstatus")[0].firstChild.nodeValue;
					arrayOfEventStatus[i] 	= eventstatus;
					if(arrayOfEventStatus[i] == "Event deleted."){
						window.location = 'holiday-events-view.php';
					}
				}
			}
		}
	}


//	var req = ajaxFunction();
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

	function chkblnkEditorTxtError(strFieldId, strErrorFieldId) {
		if(tinyMCE.get(strFieldId).getContent() != "") {
			document.getElementById(strErrorFieldId).innerHTML = "";
		}
	}

</script>
<div id="showDetails">
    <form name="frmAddEvent" id="frmAddEvent" action="holiday-events-add.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="securityKey" id="securityKey" value="<?php echo md5("ADDEVENT")?>">
    <input name="txtTermConditions" id="txtTermConditionsId" value="1" type="hidden" />
    <table width="690" border="0" cellspacing="0" cellpadding="0" class="font12">
        <tr>
            <td align="left" valign="top" class="pad-btm15 pad-top20"><p class="FloatLft">&nbsp;</p><h1 class="page-heading"><?php echo tranText('add_your_event_attraction_excursion_for_free'); ?>!</h1></td>
        </tr>
        <tr>
            <td align="left" valign="top" class="pad-btm10"><p>Please note that we advertise events and listings for worldwide.</p><br /> We will be expanding into other parts of world very soon so if you would like to be kept informed just subscribe to our newsletter which contains all the latest rentownersvillas.com news plus great offers and money saving late deals.<br /> </td>
        </tr>
        <tr>
            <td align="left" valign="top" class="pad-btm10">Please note that we will validate all events and listings before they appear on the site which can take up to 48 hours. In the event that your listing is unsuitable we will inform you by email why it has not been accepted.</td>
        </tr>
        <tr>
            <td align="left" valign="top" class="pad-btm3 pad-top10"><span class="owner-headings1 pad-rgt10"><?php echo tranText('about_you'); ?></span>&nbsp;(<?php echo tranText('these_details_will_not_be_displayed'); ?>)</td>
        </tr>
        <tr>
            <td align="left" valign="top" class="pad-top10">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td class="pad-btm15" align="right" height="23" valign="top" width="185"><?php echo tranText('first_name'); ?><span class="red">*</span></td>
                        <td class="pad-btm15 pad-lft5" valign="top" width="249"><input name="txtEventOwnerFName" id="txtEventOwnerFNameId" class="inpuTxt260" type="text" value="<?php echo $eventInfoArr['event_owner_fname']; ?>" onkeydown="chkblnkTxtError('txtEventOwnerFNameId', 'txtEventOwnerFNameErrorId');" onkeyup="chkblnkTxtError('txtEventOwnerFNameId', 'txtEventOwnerFNameErrorId');" /></td>
                        <td valign="top" width="10">&nbsp;</td>
                        <td class="pad-btm15" valign="top" width="240"><span class="pdError1" id="txtEventOwnerFNameErrorId"></span></td>
                    </tr>
                    <tr>
                        <td class="pad-btm15" align="right" height="23" valign="top"><?php echo tranText('last_name'); ?><span class="red">*</span></td>
                        <td class="pad-btm15 pad-lft5" valign="top"><input name="txtEventOwnerLName" id="txtEventOwnerLNameId" class="inpuTxt260" type="text" value="<?php echo $eventInfoArr['event_owner_lname']; ?>" onkeydown="chkblnkTxtError('txtEventOwnerLNameId', 'txtEventOwnerLNameErrorId');" onkeyup="chkblnkTxtError('txtEventOwnerLNameId', 'txtEventOwnerLNameErrorId');" /></td>
                        <td valign="top">&nbsp;</td>
                        <td class="pad-btm15" valign="top"><span class="pdError1" id="txtEventOwnerLNameErrorId"></span></td>
                    </tr>
                    <tr>
                        <td class="pad-btm15" align="right" height="23" valign="top"><?php echo tranText('email_address'); ?><span class="red">*</span></td>
                        <td class="pad-btm15 pad-lft5" valign="top"><input name="txtEventOwnerEmail" id="txtEventOwnerEmailId" class="inpuTxt260" type="text" value="<?php echo $eventInfoArr['event_owner_email']; ?>" onkeydown="chkblnkTxtError('txtEventOwnerEmailId', 'txtEventOwnerEmailErrorId');" onkeyup="chkblnkTxtError('txtEventOwnerEmailId', 'txtEventOwnerEmailErrorId');" /></td>
                        <td valign="top">&nbsp;</td>
                        <td class="pad-btm15" valign="top"><span class="pdError1" id="txtEventOwnerEmailErrorId"></span></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="left" valign="top" class="pad-btm3 pad-top10"><span class="owner-headings1 pad-rgt10"><?php echo tranText('event_attraction_title'); ?> </span></td>
        </tr>
        <tr>
            <td align="left" valign="top" class="pad-top10">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="right" height="23" valign="top" width="185"><?php echo tranText('location'); ?><span class="red">*</span></td>
                        <td class="pad-lft5" valign="top" width="249">
                            <div id="showtxtlocationcombo" class="pad-btm3">
                                <select name="txtAddEventArea" id="txtAddEventAreaId" onchange="return chkSelectArea4AddEvent();" style="display:block;" class="select216">
                                    <?php 
                                    if(isset($eventInfoArr['event_area_id']) && $eventInfoArr['event_area_id'] != "") {
                                        $locationObj->fun_getAreaListOptions($eventInfoArr['event_area_id'], '');
                                    } else {
                                        $locationObj->fun_getAreaListOptions('', '');
                                    }
                                    ?>
                                </select>
                                <select name="txtAddEventRegion" id="txtAddEventRegionId" onchange="return chkSelectRegion4AddEvent();" style="display:<?php if(isset($eventInfoArr['event_region_id']) && ($eventInfoArr['event_region_id'] != "0")) { echo "block";} else { echo "block";} ?>;" class="select216">
                                    <option value="0" <?php if(isset($eventInfoArr['event_region_id']) && ($eventInfoArr['event_region_id'] == "0")) {echo "selected";} ?> >All Areas ...</option>
                                    <?php 
                                    if(isset($eventInfoArr['event_region_id']) && ($eventInfoArr['event_region_id'] != "0") && ($eventInfoArr['event_region_id'] != "") && isset($eventInfoArr['event_area_id']) && ($eventInfoArr['event_area_id'] != "0") && ($eventInfoArr['event_area_id'] != "")) {
                                        $locationObj->fun_getRegionListOptions($eventInfoArr['event_region_id'], '0', $eventInfoArr['event_area_id']);
                                    } else {
                                        $locationObj->fun_getRegionListOptions('', '', '');
                                    }
                                    ?>
                                </select>
                                <?php 
                                if(isset($eventInfoArr['event_region_id']) && ($eventInfoArr['event_region_id'] != "0") && ($locationObj->fun_getRegionPid($eventInfoArr['event_region_id']) == "0") && ($locationObj->fun_countSubRegionByRegionid($eventInfoArr['event_region_id']) > 0) && ((isset($eventInfoArr['event_sub_region_id']) && $eventInfoArr['event_sub_region_id'] == "0") || !isset($eventInfoArr['event_sub_region_id']))) {
                                ?>
                                <select name="txtAddEventSubRegion" id="txtAddEventSubRegionId" onchange="return chkSelectSubRegion4AddEvent();" style="display:block;" class="select216">
                                    <option value="0" selected>All Areas ...</option>
                                    <?php 
                                        $locationObj->fun_getRegionListOptions('', $eventInfoArr['event_region_id'], $eventInfoArr['event_area_id']);
                                    ?>
                                </select>
                                <?php
                                } else {
                                ?>
                                <select name="txtAddEventSubRegion" id="txtAddEventSubRegionId" onchange="return chkSelectSubRegion4AddEvent();" style="display:<?php if(isset($eventInfoArr['event_sub_region_id']) && ($eventInfoArr['event_sub_region_id'] != "0")) { echo "block";} else { echo "none";} ?>;" class="select216">
                                    <option value="0" <?php if(isset($eventInfoArr['event_sub_region_id']) && ($eventInfoArr['event_sub_region_id'] == "0")) {echo "selected";} ?> >All Areas ...</option>
                                    <?php 
                                    if(isset($eventInfoArr['event_sub_region_id']) && ($eventInfoArr['event_sub_region_id'] != "0") && ($eventInfoArr['event_sub_region_id'] != "") && isset($eventInfoArr['event_region_id']) && ($eventInfoArr['event_region_id'] != "0") && ($eventInfoArr['event_region_id'] != "")) {
                                        $locationObj->fun_getRegionListOptions($eventInfoArr['event_sub_region_id'], $eventInfoArr['event_region_id'], $eventInfoArr['event_area_id']);
                                    } else {
                                        $locationObj->fun_getRegionListOptions('', '', '3');
                                    }
                                    ?>
                                </select>
                                <?php
                                }
                                ?>
                                <?php 
                                if(isset($eventInfoArr['event_sub_region_id']) && ($eventInfoArr['event_sub_region_id'] != "0") && ((isset($eventInfoArr['event_location_id']) && $eventInfoArr['event_location_id'] == "0") || !isset($eventInfoArr['event_location_id']))) {
                                ?>
                                <select name="txtAddEventLocation" id="txtAddEventLocationId" onchange="return chkSelectLocation4AddEvent();" style="display:block;" class="select216">
                                    <option value="0" selected>All Areas ...</option>
                                    <?php 
                                        $locationObj->fun_getLocationListOptions('', $eventInfoArr['event_sub_region_id']);
                                    ?>
                                </select>
                                <?php
                                } else if(isset($eventInfoArr['event_region_id']) && ($eventInfoArr['event_region_id'] != "0") && ($locationObj->fun_countSubRegionByRegionid($eventInfoArr['event_region_id']) == 0) && ((isset($eventInfoArr['event_location_id']) && $eventInfoArr['event_location_id'] == "0") || !isset($eventInfoArr['event_location_id']))) {
                                ?>
                                <select name="txtAddEventLocation" id="txtAddEventLocationId" onchange="return chkSelectLocation4AddEvent();" style="display:block;" class="select216">
                                    <option value="0" selected>All Areas ...</option>
                                    <?php 
                                        $locationObj->fun_getLocationListOptions('', $eventInfoArr['event_region_id']);
                                    ?>
                                </select>
                                <?php
                                } else {
                                ?>
                                <select name="txtAddEventLocation" id="txtAddEventLocationId" onchange="return chkSelectLocation4AddEvent();" style="display:<?php if(isset($eventInfoArr['event_location_id']) && ($eventInfoArr['event_location_id'] != "0")) { echo "block";} else { echo "none";} ?>;" class="select216">
                                    <option value="0" <?php if(isset($eventInfoArr['event_location_id']) && ($eventInfoArr['event_location_id'] == "0")) {echo "selected";} ?> >All Areas ...</option>
                                    <?php 
                                    if(isset($eventInfoArr['event_location_id']) && ($eventInfoArr['event_location_id'] != "0") && ($eventInfoArr['event_location_id'] != "")) {
                                        $locationObj->fun_getLocationListOptions($eventInfoArr['event_location_id']);
                                    } else {
                                        $locationObj->fun_getLocationListOptions();
                                    }
                                    ?>
                                </select>
                                <?php
                                }
                                ?>
                            </div>									
                        </td>
                        <td valign="top" width="10">&nbsp;</td>
                        <td valign="top" width="240"><span class="pdError1" id="txtAddEventLocationErrorId"></span></td>
                    </tr>
                    <tr>
                        <td class="pad-btm15" align="right" height="23" valign="top"><?php echo tranText('event_attraction_title'); ?><span class="red">*</span></td>
                        <td class="pad-btm15 pad-lft5" valign="top"><input name="txtEventName" id="txtEventNameId" placeholder="This will appear on search listings" class="inpuTxt260" value="<?php if(isset($eventInfoArr['event_name']) && $eventInfoArr['event_name'] !="") { echo stripcslashes($eventInfoArr['event_name']);} ?>" type="text" onkeydown="chkblnkTxtError('txtEventNameId', 'txtEventNameErrorId');" onkeyup="chkblnkTxtError('txtEventNameId', 'txtEventNameErrorId');" /></td>
                        <td valign="top">&nbsp;</td>
                        <td class="pad-btm15" valign="top"><span class="pdError1" id="txtEventNameErrorId"></span></td>
                    </tr>
                    <?php
                        if(isset($eventInfoArr['event_cat_ids']) && ($eventInfoArr['event_cat_ids'] != "")) {
                            $eventCatArr = explode(",", $eventInfoArr['event_cat_ids']);
                            if(is_array($eventCatArr)) {
                                for($i = 0; $i < count($eventCatArr); $i++) {
                                    $cat_id = $eventCatArr[$i];
                                    if($i == 0) {
                                    ?>
                                        <tr id="rowAddNewEventCategoryId<?php echo $i; ?>">
                                            <td align="right" height="23" valign="top"><?php echo tranText('event_attraction_category'); ?><span class="red">*</span></td>
                                            <td class="pad-lft5" valign="top">
                                                <select class="select216" name="txtEventCategory[]" id="txtEventCategoryId<?php echo $i; ?>" onChange="chkblnkTxtError('txtEventCategoryId<?php echo $i; ?>', 'txtEventCategoryErrorId');">
                                                    <option value="">Select...</option>
                                                    <?php echo $eventObj->fun_getEventCategoryTypeOptionsList($cat_id); ?>
                                                </select>                                                        
                                            </td>
                                            <td valign="top">&nbsp;</td>
                                            <td valign="top">&nbsp;</td>
                                        </tr>
                                    <?php
                                    } else if($i == (count($eventCatArr)-1)) {
                                    ?>
                                        <tr id="rowAddNewEventCategoryId<?php echo $i; ?>">
                                            <td align="right" height="23" valign="top">&nbsp;</td>
                                            <td class="pad-lft5" valign="top">
                                                <select class="select216" name="txtEventCategory[]" id="txtEventCategoryId<?php echo $i; ?>" onChange="chkblnkTxtError('txtEventCategoryId<?php echo $i; ?>', 'txtEventCategoryErrorId');">
                                                    <option value="">Select...</option>
                                                    <?php echo $eventObj->fun_getEventCategoryTypeOptionsList($cat_id); ?>
                                                </select>                                                        
                                            </td>
                                            <td valign="top">&nbsp;</td>
                                            <td valign="top"><span class="pdError1" id="txtEventCategoryErrorId"></span></td>
                                        </tr>
                                    <?php
                                    } else {
                                    ?>
                                        <tr id="rowAddNewEventCategoryId<?php echo $i; ?>">
                                            <td align="right" height="23" valign="top">&nbsp;</td>
                                            <td class="pad-lft5" valign="top">
                                                <select class="select216" name="txtEventCategory[]" id="txtEventCategoryId<?php echo $i; ?>" onChange="chkblnkTxtError('txtEventCategoryId<?php echo $i; ?>', 'txtEventCategoryErrorId');">
                                                    <option value="">Select...</option>
                                                    <?php echo $eventObj->fun_getEventCategoryTypeOptionsList($cat_id); ?>
                                                </select>                                                        
                                            </td>
                                            <td valign="top">&nbsp;</td>
                                            <td valign="top">&nbsp;</td>
                                        </tr>
                                    <?php
                                    }
                                }
                            }
                        } else {
                        ?>
                        <tr id="rowAddNewEventCategoryId0">
                            <td align="right" height="23" valign="top"><?php echo tranText('event_attraction_category'); ?><span class="red">*</span></td>
                            <td class="pad-lft5" valign="top">
                                <select class="select216" name="txtEventCategory[]" id="txtEventCategoryId0" onChange="chkblnkTxtError('txtEventCategoryId0', 'txtEventCategoryErrorId');">
                                    <option value="">Select...</option>
                                    <?php echo $eventObj->fun_getEventCategoryTypeOptionsList(); ?>
                                </select>                                        
                            </td>
                            <td valign="top">&nbsp;</td>
                            <td valign="top"><span class="pdError1" id="txtEventCategoryErrorId">&nbsp;</span></td>
                        </tr>
                        <?php
                        }
                    ?>
                    <tr>
                        <td colspan="4">
                            <input type="hidden" value="0" id="theValue" />
                            <div id="myDiv1"> </div>									
                        </td>
                    </tr>
                    <tr>
                        <td class="pad-btm15" align="right" height="23" valign="top">&nbsp;</td>
                        <td class="pad-btm15 pad-lft5" colspan="3" valign="top">
                            <a href="javascript:void(0);" onClick="addEvent1();" class="add-photo"><?php echo tranText('add_another_category'); ?></a><?php echo tranText('useful_for_events_that_fit_into_more_than_one_category'); ?>									
                        </td>
                    </tr>
                    <tr>
                        <td class="pad-btm15" align="right" height="23" valign="top"><?php echo tranText('is_it_open_all_year_round'); ?>?<span class="red">*</span></td>
                        <td class="pad-btm15 pad-lft5" valign="top">
                            <?php 
                                if(isset($eventInfoArr['event_year_around']) && ($eventInfoArr['event_year_around'] == "1")) { 
                            ?>
                            <span><input type="radio" class="radio" name="txtYearRound" id="txtYearRoundId1" value="1" onclick="hideField('tblShwDateId');void(0);" checked="checked" /></span>
                            <span><strong><?php echo tranText('yes'); ?></strong></span>
                            <span class="pad-lft20"><input type="radio" class="radio" name="txtYearRound" id="txtYearRoundId2" value="0" onclick="showField('tblShwDateId');void(0);" /></span>
                            <span><strong><?php echo tranText('no'); ?></strong></span>									
                            <?php
                                } else { 
                            ?>
                            <span><input type="radio" class="radio" name="txtYearRound" id="txtYearRoundId1" value="1" onclick="hideField('tblShwDateId');void(0);" /></span>
                            <span><strong><?php echo tranText('yes'); ?></strong></span>
                            <span class="pad-lft20"><input type="radio" class="radio" name="txtYearRound" id="txtYearRoundId2" value="0" onclick="showField('tblShwDateId');void(0);" checked="checked" /></span>
                            <span><strong><?php echo tranText('no'); ?></strong></span>									
                            <?php
                                } 
                            ?>
                        </td>
                        <td valign="top">&nbsp;</td>
                        <td class="pad-btm15" valign="top"><span class="pdError1" id="txtYearRoundErrorId">&nbsp;</span></td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <table id="tblShwDateId" border="0" width="100%" cellpadding="0" cellspacing="0" style="display:<?php if((isset($eventInfoArr['event_year_around']) && ($eventInfoArr['event_year_around'] != "1")) || !isset($eventInfoArr['event_year_around'])) { echo "block";} else { echo "none";} ?>;">
                                <tr>
                                    <td class="pad-btm15" align="right" height="23" valign="top" width="185"><?php echo tranText('event_attraction_start_date'); ?><span class="red">*</span> </td>
                                    <td class="pad-btm15" valign="top">
                                        <?php
                                            if(isset($eventInfoArr['event_start_date']) && ($eventInfoArr['event_start_date'] != "")) {
                                                $fromDateArr 		= explode("-", $eventInfoArr['event_start_date']);
                                                $txtDayFrom1 		= $fromDateArr[2];
                                                $txtMonthFrom1 		= $fromDateArr[1];
                                                $txtYearFrom1 		= $fromDateArr[0];
                                            }
                                        ?>
                                        <table border="0" cellpadding="2" cellspacing="0">
                                            <tr>
                                                <td>
                                                <select name="txtDayFrom1" id="txtDayFrom1" class="PricesDate">
                                                    <option value=""> - - </option>
                                                    <?
                                                    foreach($dayname as $key => $value)
                                                    {
                                                    ?>
                                                        <option value="<?=$value?>" <? if(isset($txtDayFrom1) && ($value==$txtDayFrom1)){echo "selected";}else if($value==(date('d'))){echo "selected";}else{echo "";}?>><?=($key+1)?></option>
                                                    <?
                                                    }
                                                    ?>
                                                </select>															
                                                </td>
                                                <td>
                                                <select name="txtMonthFrom1" id="txtMonthFrom1" class="select75">										
                                                    <option value=""> - - </option>
                                                    <?
                                                    foreach ($monthname as $key => $value) 
                                                    {
                                                    ?>
                                                        <option value="<?=$key?>" <? if(isset($txtMonthFrom1) && ($key==$txtMonthFrom1)){echo "selected";}else if($key==date('m')){echo "selected";}else{echo "";}?>><?=$value?></option>
                                                    <?
                                                    }
                                                    ?>
                                                </select>															
                                                </td>
                                                <td align="right">
                                                <select name="txtYearFrom1" id="txtYearFrom1" class="PricesDate" style="width:55px;">										
                                                    <option value=""> - - </option>
                                                    <?
                                                    foreach ($yearname as $value) 
                                                    {
                                                    ?>
                                                        <option value="<?=$value?>" <? if(isset($txtYearFrom1) && ($key==$txtYearFrom1)){echo "selected";}else if($value==date('Y')){echo "selected";}else{echo "";}?>><?=$value?></option>
                                                    <?
                                                    }
                                                    ?>
                                                </select>															
                                                </td>
                                                <td align="right"><a href="JavaScript:find_cal(<?php echo time()?>,'From1');"><img src="<?php echo SITE_IMAGES;?>calender.gif" alt="calendar" /></a></td>
                                            </tr>
                                        </table>												
                                    </td>
                                    <td valign="top">&nbsp;</td>
                                    <td class="pad-btm15" valign="top"><span class="pdError1" id="txtDateFromErrorId"></span></td>
                                </tr>
                                <tr>
                                    <td class="pad-btm15" align="right" height="23" valign="top"><?php echo tranText('event_attraction_end_date'); ?><span class="red">*</span></td>
                                    <td class="pad-btm15" valign="top">
                                        <?php
                                            if(isset($eventInfoArr['event_end_date']) && ($eventInfoArr['event_end_date'] != "")) {
                                                $toDateArr 		= explode("-", $eventInfoArr['event_end_date']);
                                                $$txtDayTo1 		= $toDateArr[2];
                                                $txtMonthTo1 		= $toDateArr[1];
                                                $txtYearTo1 		= $toDateArr[0];
                                            }
                                        ?>
                                        <table border="0" cellpadding="2" cellspacing="0">
                                            <tr>
                                                <td>
                                                    <select name="txtDayTo1" id="txtDayTo1" class="PricesDate">
                                                        <option value=""> - - </option>
                                                        <?
                                                        foreach($dayname as $key => $value)
                                                        {
                                                        ?>
                                                            <option value="<?=$value?>" <? if(isset($txtDayTo1) && ($value==$txtDayTo1)){echo "selected";}else if($value==(date('d')+1)){echo "selected";}else{echo "";}?>><?=($key+1)?></option>
                                                        <?
                                                        }
                                                        ?>
                                                    </select>															
                                                </td>
                                                <td>
                                                    <select name="txtMonthTo1" id="txtMonthTo1" class="select75">										
                                                        <option value=""> - - </option>
                                                        <?
                                                        foreach ($monthname as $key => $value) 
                                                        {
                                                        ?>
                                                            <option value="<?=$key?>" <? if(isset($txtMonthTo1) && ($key==$txtMonthTo1)){echo "selected";}else if($key==date('m')){echo "selected";}else{echo "";}?>><?=$value?></option>
                                                        <?
                                                        }
                                                        ?>
                                                    </select>															
                                                </td>
                                                <td align="right">
                                                    <select name="txtYearTo1" id="txtYearTo1" class="PricesDate" style="width:55px;">										
                                                        <option value=""> - - </option>
                                                        <?
                                                        foreach ($yearname as $value) 
                                                        {
                                                        ?>
                                                            <option value="<?=$value?>" <? if(isset($txtYearTo1) && ($key==$txtYearTo1)){echo "selected";}else if($value==date('Y')){echo "selected";}else{echo "";}?>><?=$value?></option>
                                                        <?
                                                        }
                                                        ?>
                                                    </select>															
                                                </td>
                                                <td align="right"><a href="JavaScript:find_cal(<?php echo time()?>,'To1');"><img src="<?php echo SITE_IMAGES;?>calender.gif" alt="calendar" /></a></td>
                                            </tr>
                                        </table>												
                                    </td>
                                    <td valign="top">&nbsp;</td>
                                    <td class="pad-btm15" valign="top"><span class="pdError1" id="txtDateToErrorId"></span></td>
                                </tr>
                            </table>									
                        </td>
                    </tr>
                    <tr>
                        <td class="pad-btm15" align="right" height="23" valign="top"><?php echo tranText('times'); ?></td>
                        <td class="pad-btm15 pad-lft5" valign="top"><input name="txtEventTime" id="txtEventTimeId" placeholder="eg. opening times or show times" class="inpuTxt260" value="<?php if(isset($eventInfoArr['event_time']) && $eventInfoArr['event_time'] !="") { echo stripcslashes($eventInfoArr['event_time']);} ?>" type="text" /></td>
                        <td valign="top">&nbsp;</td>
                        <td class="pad-btm15" valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="pad-btm15" align="right" height="23" valign="top"><?php echo tranText('prices'); ?></td>
                        <td class="pad-btm15 pad-lft5" valign="top"><input name="txtEventPrice" id="txtEventPriceId" placeholder="These will appear exactly as typed" class="inpuTxt260" value="<?php if(isset($eventInfoArr['event_price']) && $eventInfoArr['event_price'] !="") { echo stripcslashes($eventInfoArr['event_price']);} ?>" type="text" /></td>
                        <td valign="top">&nbsp;</td>
                        <td class="pad-btm15" valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="pad-btm15" align="right" height="23" valign="top"><?php echo tranText('venue'); ?></td>
                        <td class="pad-btm15 pad-lft5" valign="top">
                            <textarea name="txtEventVenue" id="txtEventVenueId" class="textArea260"><?php echo stripcslashes($eventInfoArr['event_venue']); ?></textarea>
                        </td>
                        <td valign="top">&nbsp;</td>
                        <td class="pad-btm15" valign="top"><span class="pdError1" id="txtEventVenueErrorId"></span></td>
                    </tr>
                    <tr>
                        <td class="pad-btm15" align="right" height="23" valign="top"><?php echo tranText('phone_number'); ?></td>
                        <td class="pad-btm15 pad-lft5" valign="top"><input name="txtEventPhone" id="txtEventPhoneId" class="inpuTxt260" value="<?php echo $eventInfoArr['event_phone']; ?>" type="text" onkeydown="chkblnkTxtError('txtEventPhoneId', 'txtEventPhoneErrorId');" onkeyup="chkblnkTxtError('txtEventPhoneId', 'txtEventPhoneErrorId');"/></td>
                        <td valign="top">&nbsp;</td>
                        <td class="pad-btm15" valign="top"><span class="pdError1" id="txtEventPhoneErrorId"></span></td>
                    </tr>
                    <tr>
                        <td class="pad-btm15" align="right" height="23" valign="top"><?php echo tranText('email'); ?></td>
                        <td class="pad-btm15 pad-lft5" valign="top"><input name="txtEventEmail" id="txtEventEmailId" class="inpuTxt260" value="<?php echo $eventInfoArr['event_email']; ?>" type="text" onkeydown="chkblnkTxtError('txtEventEmailId', 'txtEventEmailErrorId');" onkeyup="chkblnkTxtError('txtEventEmailId', 'txtEventEmailErrorId');" /></td>
                        <td valign="top">&nbsp;</td>
                        <td class="pad-btm15" valign="top"><span class="pdError1" id="txtEventEmailErrorId"></span></td>
                    </tr>
                    <tr>
                        <td class="pad-btm15" align="right" height="23" valign="top"><?php echo tranText('website'); ?></td>
                        <td class="pad-btm15 pad-lft5" valign="top"><input name="txtEventWebsite" id="txtEventWebsiteId" class="inpuTxt260" value="<?php echo $eventInfoArr['event_website']; ?>" type="text" onkeydown="chkblnkTxtError('txtEventWebsiteId', 'txtEventWebsiteErrorId');" onkeyup="chkblnkTxtError('txtEventWebsiteId', 'txtEventWebsiteErrorId');" /></td>
                        <td valign="top">&nbsp;</td>
                        <td class="pad-btm15" valign="top"><span class="pdError1" id="txtEventWebsiteErrorId"></span></td>
                    </tr>
                    <tr>
                        <td align="right" height="23" valign="top"><?php echo tranText('description'); ?><span class="red">*</span></td>
                        <td class="pad-lft5" colspan="3" valign="top">
                            <textarea name="txtEventDesc" id="txtEventDescId" class="textArea460" ><?php echo stripcslashes($eventInfoArr['event_description']); ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td class="pad-btm15" align="right" height="23" valign="top">&nbsp;</td>
                        <td colspan="3" valign="top" class="pad-btm15 pad-lft5"><span class="pdError1" id="txtEventDescErrorId"></span></td>
                    </tr>
                </table>
          </td>
        </tr>
        <tr>
            <td align="left" valign="top" class="pad-btm3 pad-top10"><span class="owner-headings1 pad-rgt10"><?php echo tranText('upload_picture'); ?></span> (<?php echo tranText('optional'); ?>)</td>
        </tr>
        <tr>
            <td align="left" valign="top" class="pad-top10"><span class="font12 pad-btm15">Please make sure you&rsquo;re images are in the ratio 4:3 and at least 450 x 336px in size. This is the normal size for most compact digital cameras. The file size should be less than 800k per image and saved as either a JPG, PNG or GIF</span></td>
        </tr>
        <tr>
            <td align="left" valign="top" class="pad-top10">
                <script language="javascript" src="includes/js/si.files.js" type="text/javascript"></script>
                <script type="text/javascript" language="javascript">
                    function uploadFile(obj, val) {
                        fileVal 		= "txtFile"+val;
                        filePhotoVal	= "txtPhoto"+val;
                        photoError		= "photoError"+val;
                        fileUrl 		= document.getElementById(fileVal).value;
                        fileUrl			= rm_trim(fileUrl);
                        if(fileUrl == ""){
                            document.getElementById(photoError).innerHTML = "<font color='#BF0000' size='2'><strong>Please select a photo to upload</strong></font>";
                            document.getElementById(filePhotoVal).focus();
                            return false;
                        } else {
                            document.getElementById(photoError).innerHTML = "";
                            document.getElementById("securityKey").value = "<?php echo md5('EVENTPHOTOSUPLOAD')?>";
                            obj.enctype = "multipart/form-data";
                            obj.submit();
                        }	
                    }        
                
                    function showValue(val){		
                        var filePath = "txtFile"+val;
                        var file_photo = "txtPhoto"+val;
                        document.getElementById(file_photo).value = document.getElementById(filePath).value;
                    }
                </script>
                <style type="text/css" title="text/css">
                .SI-FILES-STYLIZED label.cabinet{
                    width: 57px;
                    height: 23px;
                    background-image: url(<?php echo SITE_IMAGES;?>browse.gif);
                    background-repeat: no-repeat;
                    display: block;
                    overflow: hidden;
                    cursor: pointer;
                    position: relative;
                }
                .SI-FILES-STYLIZED label.cabinet input.file{
                    position: relative;
                    width: auto;
                    height: 100%;
                    _display: block;
                    _float: right;
                    _height: 23px;
                    _width: 57px;
                    opacity: 0;
                    -moz-opacity: 0;
                    filter:progid:DXImageTransform.Microsoft.Alpha(opacity=0);
                }
                </style>
                <table width="645" border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
                    <tr>
                        <td>
                        <?php 
                        if($eventInfoArr['event_thumb'] != "") {
                            $event_thumb 		= EVENT_IMAGES_THUMB168x127_PATH.$eventInfoArr['event_thumb'];
                            $evntPhotoCaption	= $eventInfoArr['event_img_caption'];
                        } else {
                            $event_thumb 		= EVENT_IMAGES_THUMB168x127_PATH."your-picture.gif";
                            $evntPhotoCaption	= "Add caption for image ...";
                            $evntPhotoCaption	.= "\nLeave blank if not required";
                        }
                        ?>
                        <img src="<?php echo $event_thumb; ?>" name="PreviewImage0" width="199" height="149" class="photo-add" id="PreviewImage0" />
                        </td>
                        <td width="24"><img src="<?php echo SITE_IMAGES;?>spacer.gif" alt="One" width="24" /></td>
                        <td align="left" valign="top">
                            <table border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td colspan="3" style="padding-top:13px;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="padding-top:13px;">
                                        <div style="width: 57px; height:23px; overflow: hidden;">
                                            <label class="cabinet">
                                                <input type="file" name="txtFile" id="txtFile0" class="file" value="" onchange="return showValue('0');"/>
                                            </label>
                                        </div>
                                    </td>
                                    <td style="padding-top:13px;"><input name="txtPhoto" type="text" id="txtPhoto0"  style="width:289px; height:17px; border: solid 1px #aeaeae; padding-top:2px; padding-bottom:2px; padding-left:5px;" value="" /></td>
                                    <td style="padding-top:13px;"><img src="<?php echo SITE_IMAGES;?>upload.gif" alt="upload" onclick="return uploadFile(document.frmAddEvent, '0');" /></td>
                                </tr>
                                <tr>
                                    <td style="padding-top:16px; padding-left:30px;" colspan="3">
                                        <textarea name="txtEvntPhotoCaption" id="txtEvntPhotoCaptionId" class="textArea260x60" onclick="return bnkEvntImgCaption();" onblur="return restoreEvntImgCaption();" ><?php echo $evntPhotoCaption; ?></textarea>                                                    
                                        <p style="float:left; font-size:12px; padding-top:10px;">
                                            <strong><?php echo tranText('not_happy_with_this_picture_just'); ?><a href="javascript:void(0);" class="blue-link"> <?php echo tranText('browse'); ?></a> <?php echo tranText('and'); ?> <a href="javascript:void(0);" class="blue-link"><?php echo tranText('upload'); ?></a> <?php echo tranText('again'); ?></strong>
                                        </p>
                                        <script type="text/javascript" language="javascript">
                                        // <![CDATA[
                                        
                                        SI.Files.stylizeAll();
                                        
                                        /*
                                        --------------------------------
                                        Known to work in:
                                        --------------------------------
                                        - IE 5.5+
                                        - Firefox 1.5+
                                        - Safari 2+
                                        --------------------------------
                                        Known to degrade gracefully in:
                                        --------------------------------
                                        - Opera
                                        - IE 5.01
                                        --------------------------------
                                        Optional configuration:
                                        
                                        Change before making method calls.
                                        --------------------------------
                                        SI.Files.htmlClass = 'SI-FILES-STYLIZED';
                                        SI.Files.fileClass = 'file';
                                        SI.Files.wrapClass = 'cabinet';
                                        
                                        --------------------------------
                                        Alternate methods:
                                        --------------------------------
                                        SI.Files.stylizeById('input-id');
                                        SI.Files.stylize(HTMLInputNode);
                                        
                                        --------------------------------
                                        */
                                        // ]]>
                                        </script>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <table cellpadding="0" cellspacing="0" width="100%" border="0">
                                            <tr>
                                                <td width="240" valign="bottom"><div id="photoError0"></div></td>
                                                <td align="right" style="padding-top:20px;">
                                                    <div id="delRow1">
                                                    <table cellpadding="0" cellspacing="0" border="0">
                                                        <tr><td>&nbsp;</td></tr>
                                                    </table>
                                                    </div>
                                                </td>
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
        <tr><td align="left" valign="top" class="pad-top10">&nbsp;</td></tr>
        <tr>
            <td align="left" valign="top">
                <div class="grey-row-box">
                <table border="0" cellpadding="3" cellspacing="0">
                    <tr>
                        <td valign="middle" width="17"><input name="txtNewsLetterChk" id="txtNewsLetterChkId" class="checkbox" value="1" type="checkbox" <?php if(isset($_POST['txtNewsLetterChk']) && $_POST['txtNewsLetterChk'] == "1") {echo "checked";} else if(!isset($_POST['txtNewsLetterChk'])) {echo "checked";} ?> /></td>
                        <td valign="middle"><span class="lineHeight13"><?php echo tranText('i_would_like_to_receive_bestbookingsonline_com_newsletters'); ?></span></td>
                    </tr>
                    <tr><td colspan="2" valign="middle"><?php echo tranText('by_clicking'); ?> <strong><?php echo tranText('submit'); ?></strong> <?php echo tranText('you_are_agreeing_to_the'); ?> <a href="javascript:popcontact('terms.html')" class="blue-link"><?php echo tranText('terms_and_conditions'); ?></a> &nbsp;&nbsp;<span class="pdError1" id="txtTermConditionsErrorId"></span></td></tr>
                </table>
                </div>
            </td>
        </tr>
        <tr><td align="left" valign="top">&nbsp;</td></tr>
        <tr>
            <td align="right" valign="bottom">
                <div class="FloatRgt pad-rgt10">
                <a href="<?php if(isset($eventInfoArr['event_id']) && $eventInfoArr['event_id'] != "") {echo "javascript:cancelAddEvent('".$eventInfoArr['event_id']."');";} else {echo "holiday-events-view.php";} ?>" style="text-decoration:none;"><input type="reset" alt="Search" class="button85x30-grey" value="Cancel"/></a>
                <input type="submit" alt="Search" onclick="return frmValidateAddEvent();" class="button85x30" value="Submit"/>
                <?php /*?>
                    <a href="<?php if(isset($eventInfoArr['event_id']) && $eventInfoArr['event_id'] != "") {echo "javascript:cancelAddEvent('".$eventInfoArr['event_id']."');";} else {echo "holiday-events-view.php";} ?>" style="text-decoration:none;"><img src="<?php echo SITE_IMAGES;?>cancel-gray.gif" alt="Cancel" name="Cancel" border="0" /></a>&nbsp;&nbsp;&nbsp;&nbsp;<input src="<?php echo SITE_IMAGES;?>submit.gif" onclick="return frmValidateAddEvent();"  alt="Preview and Confirm" type="image">
                <?php */?>
                </div>
            </td>
        </tr>
    </table>
    </form>
</div>        
