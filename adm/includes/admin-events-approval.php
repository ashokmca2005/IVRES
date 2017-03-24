<?php
// Form submision
$detail_array 	= array();
$error_msg		= 'no';

if($_POST['securityKey']==md5(EVENTDELETE)){
	if(isset($_POST['txtEventId']) && $_POST['txtEventId'] != "") {
		$event_id = $_POST['txtEventId'];
		$eventObj->fun_delEvent($event_id);
	}
	echo "<script> location.href='admin-pending-approval.php?sec=event';</script>";
}


if($_POST['securityKey']==md5(EVENTREJECT)){
	if(isset($_POST['txtEventId']) && $_POST['txtEventId'] != "") {
		$event_id = $_POST['txtEventId'];
		if(!empty($_POST['txtDeclineId'])){
			$eventArr 		= $eventObj->fun_getEventInfo($event_id);
			$owner_fname 	= $eventArr['event_owner_fname'];
			$owner_lname 	= $eventArr['event_owner_lname'];
	 		$owner_email 	= trim($eventArr['event_owner_email']);

			$strMessage = "";
$strMessage .= '<table width="70%"  border="0" cellspacing="10" cellpadding="0">
<tr><td align="center">&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;Hi,</td></tr>
<tr><td>'.trim(ucfirst($owner_fname." ".$owner_lname)).' </td></tr>
<tr><td>&nbsp;Please find reason for decline of your added below:-</td></tr>';
$txtDeclineId = $_POST['txtDeclineId'];
for($i = 0; $i < count($txtDeclineId); $i++) {
	$section_id = $txtDeclineId[$i];
	if($section_id == "1") {
		$strMessage .= '<tr><td><b>Inappropriate content for our site</b></td></tr>';
	} else if($section_id == "2") {
		$strMessage .= '<tr><td><b>Inappropriate picture</b></td></tr>';
	}  else if($section_id == "3") {
		$strMessage .= '<tr><td><b>Picture quality and/or cropping is of poor quality</b></td></tr>';
	} else if($section_id == "4") {
		$strMessage .= '<tr><td><b>Information is confusing</b></td></tr>';
	} else if($section_id == "5") {
		$reason_note 	= $_POST['other_reason'];
		$strMessage .= '<tr><td><b>'.$reason_note.'</b></td></tr>';
	}
}
$strMessage .= '<tr><td>&nbsp;Best Regards,</td></tr>
<tr><td>&nbsp;rentownersvillas.com Team Member</td></tr>	  
</table>';
			require_once("includes/classes/class.Email.php");
			$emailObj = new Email($owner_email, "Manager | rentownersvillas.com <".SITE_ADMIN_EMAIL.">", "Event Decline mail", $strMessage);
			//$emailObj = new Email($owner_email, SITE_ADMIN_EMAIL, "Event Decline mail", $strMessage);
			$emailObj->sendEmail();
		}
		$eventObj->fun_delEvent($event_id);
	}
	echo "<script> location.href='admin-pending-approval.php?sec=event';</script>";
}


if($_POST['securityKey']==md5(EVENTPHOTOSUPLOAD)){		
	if(isset($_FILES['txtFile']) && ($_FILES['txtFile'] !="")){ // edit

		if(isset($_POST['txtEventId']) && $_POST['txtEventId'] != "") {
			$event_id 				= $_POST['txtEventId'];
		} else {
			$event_id 				= $_REQUEST[PHPSESSID];
		}
		$event_img 	= basename($_FILES['txtFile']['name']);
		$extn 		= split("\.",$event_img);
		
		$photo_main 	= $event_id."_photo.".$extn[1];
		$photo_thumb 	= $event_id."_photo_thumb.".$extn[1];
		$uploadphotodir = '../upload/event_images/large';
		$uploadthumbdir = '../upload/event_images/thumbnail';

		$uploadphotofile = $uploadphotodir ."/". $photo_main;
		$uploadphotofile449x341 	= $uploadphotodir ."/449x341/". $photo_main;
		$uploadphotofile168x127 	= $uploadthumbdir ."/168x127/". $photo_thumb;

		if (move_uploaded_file($_FILES['txtFile']['tmp_name'], $uploadphotofile)){

			if(isset($_POST['txtEventId']) && $_POST['txtEventId'] != "") {
//				$eventObj->fun_delEventImg($event_id);
			} else {
				$eventObj->fun_delEventTemp($event_id);
			}

			$imgObj->getCrop($uploadphotodir,$photo_main,449,341,$uploadphotofile449x341);
			$imgObj->getCrop($uploadphotodir,$photo_main,168,127,$uploadphotofile168x127);

			$txtEvntPhotoCaption 	= $_POST['txtEvntPhotoCaption'];

			if(isset($_POST['txtEvntPhotoBy']) && $_POST['txtEvntPhotoBy'] != "" && $_POST['txtEvntPhotoBy'] !="Photo by") {
				$txtEvntPhotoBy 	= $_POST['txtEvntPhotoBy'];
			} else {
				$txtEvntPhotoBy 	= "";
			}

			if(isset($_POST['txtEvntPhotoLink']) && $_POST['txtEvntPhotoLink'] != "" && $_POST['txtEvntPhotoLink'] !="http://") {
				$txtEvntPhotoLink 	= $_POST['txtEvntPhotoLink'];
			} else {
				$txtEvntPhotoLink 	= "";
			}

			$txtEventOwnerFName 	= $_POST['txtEventOwnerFName'];
			$txtEventOwnerLName 	= $_POST['txtEventOwnerLName'];
			$txtEventOwnerEmail 	= $_POST['txtEventOwnerEmail'];
			$txtAddEventArea 		= $_POST['txtAddEventArea'];
			$txtAddEventRegion 		= $_POST['txtAddEventRegion'];
			$txtAddEventSubRegion 	= $_POST['txtAddEventSubRegion'];
			$txtAddEventLocation 	= $_POST['txtAddEventLocation'];
			$txtEventName 			= $_POST['txtEventName'];
			$txtEventCategory 		= $_POST['txtEventCategory'];
			$tmpArr					= array();
			for($i = 0; $i < count($txtEventCategory); $i++) {
				if(($txtEventCategory[$i] != "") && !in_array($txtEventCategory[$i], $tmpArr)) {
					array_push($tmpArr, $txtEventCategory[$i]);
				}
			}
			$txtEventCategoryIds= "";
			$txtEventCategoryIds= implode(",", $tmpArr);
			
			$txtYearRound 			= $_POST['txtYearRound'];
			if($txtYearRound == "0") {
				$txtDayFrom1 			= $_POST['txtDayFrom1'];
				$txtMonthFrom1 			= $_POST['txtMonthFrom1'];
				$txtYearFrom1 			= $_POST['txtYearFrom1'];
				$txtFromDate 			= $txtYearFrom1."-".$txtMonthFrom1."-".$txtDayFrom1;
				$txtDayTo1 				= $_POST['txtDayTo1'];
				$txtMonthTo1 			= $_POST['txtMonthTo1'];
				$txtYearTo1 			= $_POST['txtYearTo1'];
				$txtToDate 				= $txtYearTo1."-".$txtMonthTo1."-".$txtDayTo1;
			} else {
				$txtFromDate 			= "";
				$txtToDate 				= "";
			}

			if(isset($_POST['txtEventTime']) && $_POST['txtEventTime'] != "" && $_POST['txtEventTime'] != "eg opening times or show times") {
				$txtEventTime 			= $_POST['txtEventTime'];
			} else {
				$txtEventTime 			= "";
			}
		
			if(isset($_POST['txtEventPrice']) && $_POST['txtEventPrice'] != "" && $_POST['txtEventPrice'] != "These will appear exactly as typed") {
				$txtEventPrice 			= $_POST['txtEventPrice'];
			} else {
				$txtEventPrice 			= "";
			}

			$txtEventVenue 			= $_POST['txtEventVenue'];

			$txtEventPhone 			= $_POST['txtEventPhone'];
			$txtEventEmail 			= $_POST['txtEventEmail'];
			$txtEventWebsite		= $_POST['txtEventWebsite'];
			$txtEventDesc 			= $_POST['txtEventDesc'];

			if(isset($_POST['txtEventId']) && $_POST['txtEventId'] != "") {
				$eventObj->fun_addEvent($event_id, $txtEventCategoryIds, $txtEventName, $txtEventDesc, $txtAddEventArea, $txtAddEventRegion, $txtAddEventSubRegion, $txtAddEventLocation, $txtYearRound, $txtFromDate, $txtToDate, $txtEventTime, $txtEventPrice, $txtEventVenue, $txtEventPhone, $txtEventEmail, $txtEventWebsite, $photo_main, $photo_thumb, $txtEvntPhotoCaption, $txtEvntPhotoBy, $txtEvntPhotoLink, $txtEventOwnerFName, $txtEventOwnerLName, $txtEventOwnerEmail);
			} else {
				$eventObj->fun_addEventTemp($event_id, $txtEventCategoryIds, $txtEventName, $txtEventDesc, $txtAddEventArea, $txtAddEventRegion, $txtAddEventSubRegion, $txtAddEventLocation, $txtYearRound, $txtFromDate, $txtToDate, $txtEventTime, $txtEventPrice, $txtEventVenue, $txtEventPhone, $txtEventEmail, $txtEventWebsite, $photo_main, $photo_thumb, $txtEvntPhotoCaption, $txtEvntPhotoBy, $txtEvntPhotoLink, $txtEventOwnerFName, $txtEventOwnerLName, $txtEventOwnerEmail);
			}
			echo "<script>location.href = window.location;</script>";
		}
	}
}

if($_POST['securityKey'] == md5(ADDEVENT)){
	$edit = false;
	if(isset($_POST['txtEventId']) && $_POST['txtEventId'] != "") {
		$event_id 				= $_POST['txtEventId'];
		$edit = true;
	} else {
		$event_id 				= $_REQUEST[PHPSESSID];
	}

//print_r($_POST);
	$txtEvntPhotoCaption 	= $_POST['txtEvntPhotoCaption'];
	if(isset($_POST['txtEvntPhotoBy']) && $_POST['txtEvntPhotoBy'] != "" && $_POST['txtEvntPhotoBy'] !="Photo by") {
		$txtEvntPhotoBy 	= $_POST['txtEvntPhotoBy'];
	} else {
		$txtEvntPhotoBy 	= "";
	}

	if(isset($_POST['txtEvntPhotoLink']) && $_POST['txtEvntPhotoLink'] != "" && $_POST['txtEvntPhotoLink'] !="http://") {
		$txtEvntPhotoLink 	= $_POST['txtEvntPhotoLink'];
	} else {
		$txtEvntPhotoLink 	= "";
	}

	$txtEventOwnerFName 	= $_POST['txtEventOwnerFName'];
	$txtEventOwnerLName 	= $_POST['txtEventOwnerLName'];
	$txtEventOwnerEmail 	= $_POST['txtEventOwnerEmail'];
	$txtAddEventArea 		= $_POST['txtAddEventArea'];
	$txtAddEventRegion 		= $_POST['txtAddEventRegion'];
	$txtAddEventSubRegion 	= $_POST['txtAddEventSubRegion'];
	$txtAddEventLocation 	= $_POST['txtAddEventLocation'];
	$txtEventName 			= $_POST['txtEventName'];
	$txtEventCategory 		= $_POST['txtEventCategory'];
	$tmpArr					= array();
	for($i = 0; $i < count($txtEventCategory); $i++) {
		if(($txtEventCategory[$i] != "") && !in_array($txtEventCategory[$i], $tmpArr)) {
			array_push($tmpArr, $txtEventCategory[$i]);
		}
	}
	$txtEventCategoryIds= "";
	$txtEventCategoryIds= implode(",", $tmpArr);
	
	$txtYearRound 			= $_POST['txtYearRound'];
	if($txtYearRound == "0") {
		$txtDayFrom1 			= $_POST['txtDayFrom1'];
		$txtMonthFrom1 			= $_POST['txtMonthFrom1'];
		$txtYearFrom1 			= $_POST['txtYearFrom1'];
		$txtFromDate 			= $txtYearFrom1."-".$txtMonthFrom1."-".$txtDayFrom1;
		$txtDayTo1 				= $_POST['txtDayTo1'];
		$txtMonthTo1 			= $_POST['txtMonthTo1'];
		$txtYearTo1 			= $_POST['txtYearTo1'];
		$txtToDate 				= $txtYearTo1."-".$txtMonthTo1."-".$txtDayTo1;
	} else {
		$txtFromDate 			= "";
		$txtToDate 				= "";
	}

	$txtEventTime 			= $_POST['txtEventTime'];
	$txtEventPrice 			= $_POST['txtEventPrice'];
	$txtEventVenue 			= $_POST['txtEventVenue'];
	$txtEventPhone 			= $_POST['txtEventPhone'];
	$txtEventEmail 			= $_POST['txtEventEmail'];
	$txtEventWebsite		= $_POST['txtEventWebsite'];
	$txtEventDesc 			= $_POST['txtEventDesc'];

	if($edit == true) {
		$eventObj->fun_addEvent($event_id, $txtEventCategoryIds, $txtEventName, $txtEventDesc, $txtAddEventArea, $txtAddEventRegion, $txtAddEventSubRegion, $txtAddEventLocation, $txtYearRound, $txtFromDate, $txtToDate, $txtEventTime, $txtEventPrice, $txtEventVenue, $txtEventPhone, $txtEventEmail, $txtEventWebsite, '', '', $txtEvntPhotoCaption, $txtEvntPhotoBy,  $txtEvntPhotoLink, $txtEventOwnerFName, $txtEventOwnerLName, $txtEventOwnerEmail);
	} else {
		$eventObj->fun_addEventTemp($event_id, $txtEventCategoryIds, $txtEventName, $txtEventDesc, $txtAddEventArea, $txtAddEventRegion, $txtAddEventSubRegion, $txtAddEventLocation, $txtYearRound, $txtFromDate, $txtToDate, $txtEventTime, $txtEventPrice, $txtEventVenue, $txtEventPhone, $txtEventEmail, $txtEventWebsite, '', '', $txtEvntPhotoCaption, $txtEvntPhotoBy,  $txtEvntPhotoLink, $txtEventOwnerFName, $txtEventOwnerLName, $txtEventOwnerEmail);
	}
	echo "<script>location.href = window.location;</script>";
}

if(isset($_GET['status']) && $_GET['status'] > 0) {
	$statusTxt = "&status=".$_GET['status'];
} else {
	$statusTxt = "";
}

if(isset($event_id) && $event_id !=""){
$dayname 	= array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');
$monthname 	= array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec');
$yearname 	= array(date('Y')+0,date('Y')+1,date('Y')+2,date('Y')+3);
$stayname 	= array('01','02','03','04','05','06','07','08','09','10','11','12','13','14');

$eventInfoArr 	= $eventObj->fun_getEventInfo($event_id);
?>
<!-- TinyMCE -->
<script type="text/javascript" src="../tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
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
	var x1 = "";
	var y1 = "";

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
		strTable1 += "<td valign='top' width='249'>";
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

		if(document.frmAddEvent.txtEventDesc.value == "") {
			document.getElementById("txtEventDescErrorId").innerHTML = "Please enter event description.";
			document.frmAddEvent.txtEventDesc.focus();
			shwError = true;
		}

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

		if(document.frmAddEvent.txtEvntPhotoCaption.value.indexOf("Add caption for image ...") != -1){
            document.frmAddEvent.txtEvntPhotoCaption.value = "";
		}

		if(document.frmAddEvent.txtEvntPhotoBy.value == "Photo by") {
			document.frmAddEvent.txtEvntPhotoBy.value = "";
		}

		if(document.frmAddEvent.txtEvntPhotoLink.value == "http://") {
			document.frmAddEvent.txtEvntPhotoLink.value = "";
		}

		if(shwError == true) {
			return false;
		} else {
			document.frmAddEvent.submit();
		}
	}

	function chkblnkTxtError(strFieldId, strErrorFieldId) {
		if(document.getElementById(strFieldId).value != "") {
			document.getElementById(strErrorFieldId).innerHTML = "";
		}
	}

	function cancelAddEvent(strEventTmpId){
		req.onreadystatechange = handleDeleteTmpResponse;
		req.open("GET", '../eventtmpdeleteXml.php?evtid='+strEventTmpId); 
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
						window.location = 'admin-pending-approval.php?sec=event';
					}
				}
			}
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
/*
* For Add event section : Start here
*/
	function chkSelectArea4AddEvent() {
		var getID=document.getElementById("txtAddEventAreaId").value;
		if(getID !="" && getID != "0"){
			sendRegionRequest4AddEvent(getID);
			document.getElementById("txtAddEventRegionId").value = "0";
			document.getElementById("txtAddEventSubRegionId").value = "0";
			document.getElementById("txtAddEventLocationId").value = "0";
		}
		if(getID == "0" || getID =="") {
			document.getElementById("txtAddEventAreaId").value = "0";
			document.getElementById("txtAddEventRegionId").value = "0";
			document.getElementById("txtAddEventSubRegionId").value = "0";
			document.getElementById("txtAddEventLocationId").value = "0";
			document.getElementById("txtAddEventSubRegionId").style.display = "none";
			document.getElementById("txtAddEventLocationId").style.display = "none";
		}
	}
	
	function chkSelectRegion4AddEvent() {
		var getID=document.getElementById("txtAddEventRegionId").value;
		if(getID !="" && getID != "0"){
			sendSubRegionRequest4AddEvent(getID);
			document.getElementById("txtAddEventSubRegionId").value = "0";
			document.getElementById("txtAddEventLocationId").value = "0";
		}
		if(getID == "0" || getID =="") {
			document.getElementById("txtAddEventRegionId").value = "0";
			document.getElementById("txtAddEventSubRegionId").value = "0";
			document.getElementById("txtAddEventLocationId").value = "0";
			document.getElementById("txtAddEventSubRegionId").style.display = "none";
			document.getElementById("txtAddEventLocationId").style.display = "none";
		}
	}
	
	function chkSelectSubRegion4AddEvent() {
		var getID=document.getElementById("txtAddEventSubRegionId").value;
		if(getID !="" && getID != "0"){
			sendLocationRequest4AddEvent(getID);
			document.getElementById("txtAddEventLocationId").value = "0";
		}
		if(getID == "0" || getID =="") {
			document.getElementById("txtAddEventSubRegionId").value = "0";
			document.getElementById("txtAddEventLocationId").value = "0";
			document.getElementById("txtAddEventLocationId").style.display = "none";
		}
	}

	function chkSelectLocation4AddEvent() {
		var getID=document.getElementById("txtAddEventLocationId").value;
		if(getID !="" && getID != "0"){
		}
		if(getID == "0" || getID =="") {
			document.getElementById("txtAddEventLocationId").value = "0";
		}
	}	

	function sendAreaRequest4AddEvent(id) { 
		req.open('get', '../selectAreaXml.php?id=' + id); 
		req.onreadystatechange = handleAreaResponse4AddEvent; 
		req.send(null); 
	} 
	
	function sendRegionRequest4AddEvent(id) { 
		req.open('get', '../selectRegionXml.php?id=' + id); 
		req.onreadystatechange = handleRegionResponse4AddEvent; 
		req.send(null); 
	} 
	
	function sendSubRegionRequest4AddEvent(id) { 
		req.open('get', '../selectSubRegionXml.php?id=' + id); 
		req.onreadystatechange = handleSubRegionResponse4AddEvent; 
		req.send(null); 
	} 
	
	function sendLocationRequest4AddEvent(id) { 
		req.open('get', '../selectLocationXml.php?id=' + id); 
		req.onreadystatechange = handleLocationResponse4AddEvent; 
		req.send(null); 
	} 
	
	function handleAreaResponse4AddEvent() { 
		var arrayOfId = new Array();
		var arrayOfNames = new Array();
		if(req.readyState == 4) { 
			var response = req.responseText; 
			xmlDoc=req.responseXML;
			var root = xmlDoc.getElementsByTagName('ntowns')[0];
			if(root != null) {
				document.getElementById("txtAddEventAreaId").style.display = "block";
				document.getElementById("txtAddEventRegionId").style.display = "none";
				document.getElementById("txtAddEventSubRegionId").style.display = "none";
				document.getElementById("txtAddEventLocationId").style.display = "none";
				var items = root.getElementsByTagName("ntown");
				for (var i = 0 ; i < items.length ; i++) {
					var item = items[i];
					var id = item.getElementsByTagName("id")[0].firstChild.nodeValue;
					arrayOfId[i] = id;
					var name = item.getElementsByTagName("name")[0].firstChild.nodeValue;
					arrayOfNames[i] = name;
					//alert("item #" + i + ": ID=" + id + " Name=" + name);
				}
				if( arrayOfId.length > 0) {
					var p_city=document.getElementById("txtAddEventAreaId");
					p_city.length=0;
					p_city.options[0]=new Option("Please Select...","");
					for(var j=0; j<arrayOfId.length; j++) {
						p_city.options[j+1]=new Option(arrayOfNames[j], arrayOfId[j]);
					}
				} else {
					document.getElementById("txtAddEventAreaId").style.display = "none";
				}
			} else {
				document.getElementById("txtAddEventAreaId").style.display = "none";
				document.getElementById("txtAddEventRegionId").style.display = "none";
				document.getElementById("txtAddEventSubRegionId").style.display = "none";
				document.getElementById("txtAddEventLocationId").style.display = "none";
			}
		} 
	} 
	
	function handleRegionResponse4AddEvent() { 
		var arrayOfId = new Array();
		var arrayOfNames = new Array();
		if(req.readyState == 4) { 
			var response = req.responseText; 
			xmlDoc=req.responseXML;
			var root = xmlDoc.getElementsByTagName('ntowns')[0];
			if(root != null) {
				document.getElementById("txtAddEventRegionId").style.display = "block";
				document.getElementById("txtAddEventSubRegionId").style.display = "none";
				document.getElementById("txtAddEventLocationId").style.display = "none";
				var items = root.getElementsByTagName("ntown");
				for (var i = 0 ; i < items.length ; i++) {
					var item = items[i];
					var id = item.getElementsByTagName("id")[0].firstChild.nodeValue;
					arrayOfId[i] = id;
					var name = item.getElementsByTagName("name")[0].firstChild.nodeValue;
					arrayOfNames[i] = name;
					//alert("item #" + i + ": ID=" + id + " Name=" + name);
				}
				if( arrayOfId.length > 0) {

					var p_city=document.getElementById("txtAddEventRegionId");

					p_city.length=0;
					p_city.options[0]=new Option("All Areas ...","0");
					for(var j=0; j<arrayOfId.length; j++) {
						p_city.options[j+1]=new Option(arrayOfNames[j],arrayOfId[j]);
					}
//					sendSubRegionRequest(1);
				} else {
					document.getElementById("txtAddEventRegionId").style.display = "none";
	//				sendLocationRequest(document.getElementById("txtRegionId").value);
				}
			} else {
				document.getElementById("txtAddEventRegionId").style.display = "none";
				document.getElementById("txtAddEventSubRegionId").style.display = "none";
				document.getElementById("txtAddEventLocationId").style.display = "none";
			}
		} 
	} 
	
	function handleSubRegionResponse4AddEvent() { 
		var arrayOfId = new Array();
		var arrayOfNames = new Array();
		if(req.readyState == 4) { 
			var response = req.responseText; 
			xmlDoc=req.responseXML;
			var root = xmlDoc.getElementsByTagName('ntowns')[0];
			if(root != null) {
				document.getElementById("txtAddEventSubRegionId").style.display = "block";
				document.getElementById("txtAddEventLocationId").style.display = "none";
				var items = root.getElementsByTagName("ntown");
				for (var i = 0 ; i < items.length ; i++) {
					var item = items[i];
					var id = item.getElementsByTagName("id")[0].firstChild.nodeValue;
					arrayOfId[i] = id;
					var name = item.getElementsByTagName("name")[0].firstChild.nodeValue;
					arrayOfNames[i] = name;
					//alert("item #" + i + ": ID=" + id + " Name=" + name);
				}
				if( arrayOfId.length > 0) {
					var p_city=document.getElementById("txtAddEventSubRegionId");
					p_city.length=0;
					p_city.options[0]=new Option("All Areas ...", "0");
					for(var j=0; j<arrayOfId.length; j++) {
						p_city.options[j+1]=new Option(arrayOfNames[j], arrayOfId[j]);
					}

//					sendLocationRequest(9);
				} else {
					document.getElementById("txtAddEventSubRegionId").style.display = "none";
					sendLocationRequest4AddEvent(document.getElementById("txtAddEventRegionId").value);
				}
			} else {
				document.getElementById("txtAddEventSubRegionId").style.display = "none";
				document.getElementById("txtAddEventLocationId").style.display = "none";
			}
		} 
	} 
	
	function handleLocationResponse4AddEvent(){
		var arrayOfId = new Array();
		var arrayOfNames = new Array();
		if(req.readyState == 4) { 
			var response = req.responseText; 
			xmlDoc=req.responseXML;
			var root = xmlDoc.getElementsByTagName('ntowns')[0];
	//		alert(root);
			if(root != null) {
				document.getElementById("txtAddEventLocationId").style.display = "block";
				var items = root.getElementsByTagName("ntown");
				for (var i = 0 ; i < items.length ; i++) {
					var item = items[i];
					var id = item.getElementsByTagName("id")[0].firstChild.nodeValue;
					arrayOfId[i] = id;
					var name = item.getElementsByTagName("name")[0].firstChild.nodeValue;
					arrayOfNames[i] = name;
					//alert("item #" + i + ": ID=" + id + " Name=" + name);
				}
				if( arrayOfId.length > 0) {

					var p_city=document.getElementById("txtAddEventLocationId");
					p_city.length=0;
					p_city.options[0]=new Option("All Areas ...","0");

					for(var j=0; j<arrayOfId.length; j++) {
						p_city.options[j+1]=new Option(arrayOfNames[j], arrayOfId[j]);
					}

				} else {
					document.getElementById("txtAddEventLocationId").style.display = "none";
				}
			} else {
				document.getElementById("txtAddEventLocationId").style.display = "none";
			}
		} 
	}

	function showEventPreview(strEventCode) {
		var newWin = window.open("admin-event-preview.php?evntid="+ strEventCode +"","HTML",'dependent=1,toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,top=50,left=50,width=500,height=800');
		newWin.window.focus();
	}
/*
* For Add event section : Start here
*/
/*
* For event pending - approval section : Start here
*/
	function sbmtEvntApproval(strId){
		var strId = strId;
		req.open('get', 'includes/ajax/admin-event-pending-approvalXml.php?evntid=' + strId + '&mode=approve'); 
		req.onreadystatechange = handleApprovalResponse; 
		req.send(null); 
	}

	function sbmtEvntDecline(strId){
		document.getElementById("showDeclineReasonId").style.display = "block";
		var strId = strId;
		req.open('get', 'includes/ajax/admin-event-pending-approvalXml.php?evntid=' + strId + '&mode=decline'); 
		req.onreadystatechange = handleApprovalResponse; 
		req.send(null); 
	}

	function sbmtEvntSuspend(strId){
		var strId = strId;
		req.open('get', 'includes/ajax/admin-event-pending-approvalXml.php?evntid=' + strId + '&mode=suspend'); 
		req.onreadystatechange = handleApprovalResponse; 
		req.send(null); 
	}

	function sbmtEvntDelete(){
		
		document.getElementById("securityKey").value = "<?php echo md5('EVENTDELETE')?>";
		document.frmAddEvent.submit();

/*
		var strId = strId;
		req.open('get', 'includes/ajax/admin-event-pending-approvalXml.php?evntid=' + strId + '&mode=suspend'); 
		req.onreadystatechange = handleApprovalResponse; 
		req.send(null); 
*/
	}

	function sbmtEvntReject(){
		if(document.getElementById("txtDeclineId5").checked && document.getElementById("other_reason").value != ""){
			document.getElementById("txtDeclineId1").checked = false;
			document.getElementById("txtDeclineId2").checked = false;
			document.getElementById("txtDeclineId3").checked = false;
			document.getElementById("txtDeclineId4").checked = false;

			document.getElementById("securityKey").value = "<?php echo md5('EVENTREJECT')?>";
			document.frmAddEvent.submit();
		} else if(document.getElementById("txtDeclineId1").checked || document.getElementById("txtDeclineId2").checked || document.getElementById("txtDeclineId3").checked || document.getElementById("txtDeclineId4").checked) {
			document.getElementById("securityKey").value = "<?php echo md5('EVENTREJECT')?>";
			document.frmAddEvent.submit();
		} else {
			return false;
		}
	}

	function handleApprovalResponse() { 
		if(req.readyState == 4){ 
			var response = req.responseText; 
			xmlDoc=req.responseXML;
			var root = xmlDoc.getElementsByTagName('events')[0];
			if(root != null){
				var items = root.getElementsByTagName("event");
				var item = items[0];
				var eventstatus = item.getElementsByTagName("eventstatus")[0].firstChild.nodeValue;
				if(eventstatus == "Approved"){
					document.getElementById("txtAdminOptionId").innerHTML 	= "<font color='#FFFFFF' size='2'><strong>"+eventstatus+"</strong></font>";
				} else if(eventstatus == "Declined"){
					document.getElementById("txtAdminOptionId").innerHTML 	= "<font color='#FFFFFF' size='2'><strong>"+eventstatus+"</strong></font>";
				} else if(eventstatus == "Suspended"){
					document.getElementById("txtAdminOptionId").innerHTML 	= "<font color='#FFFFFF' size='2'><strong>"+eventstatus+"</strong></font>";
				} else {
					document.getElementById("txtAdminOptionId").innerHTML 	= "<font color='#FFFFFF' size='2'><strong>Error, try later!</strong></font>";
				}
			} else {
				document.getElementById("txtAdminOptionId").innerHTML 	= "<font color='#FFFFFF' size='2'><strong>Error, try later!</strong></font>";
			}
		} else {
			document.getElementById("txtAdminOptionId").innerHTML 	= "<font color='#FFFFFF' size='2'><strong>Please wait...</strong></font>";
		}
	} 
/*
* For event pending - approval section : End here
*/

function unCheckOthers() {
	if(document.getElementById("txtDeclineId5").checked){
		document.getElementById("txtDeclineId1").checked = false;
		document.getElementById("txtDeclineId2").checked = false;
		document.getElementById("txtDeclineId3").checked = false;
		document.getElementById("txtDeclineId4").checked = false;
    }
}
</script>
<form name="frmAddEvent" id="frmAddEvent" action="admin-pending-approval.php?sec=event&evntid=<?php echo $eventInfoArr['event_id'].$statusTxt; ?>" method="post" enctype="multipart/form-data">
<input type="hidden" name="securityKey" id="securityKey" value="<?php echo md5("ADDEVENT")?>">
<input type="hidden" name="txtEventId" id="txtEventId" value="<?php echo $eventInfoArr['event_id']; ?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr><td height="10" colspan="2" valign="top">&nbsp;</td></tr>
    <tr>
        <td valign="top"><a href="admin-pending-approval.php?sec=event<?php echo $statusTxt;?>" class="back">Back to List</a></td>
        <td align="right" valign="top">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2" valign="top" class="pad-top5">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                <tr>
                    <td valign="top" class="pad-top7">
                        <table width="690" border="0" cellspacing="0" cellpadding="0" class="font12">
                            <tr>
                                <td align="left" valign="top">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="10" class="eventForm">
                                        <tr>
                                            <td colspan="2" align="right" valign="top" class="header">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td>
														<div id="txtAdminOptionId">
														<?php 
															if($eventInfoArr['status'] == "0" || $eventInfoArr['status'] == "1" || $eventInfoArr['status'] == "3" || $eventInfoArr['status'] == "4") {
														?>
															<a href="javascript:showField('txtshwRjctTblId');" style="text-decoration:none;"><img src="images/rejectN.png" alt="Delete" width="71" height="21" border="0" /></a>&nbsp;<a href="javascript:sbmtEvntApproval(<?php echo $eventInfoArr['event_id']; ?>);" style="text-decoration:none;"><img src="images/approveN.png" alt="Approve" width="71" height="21" border="0" /></a>
														<?php
															} else {
														?>
															<a href="javascript:sbmtEvntDelete();" style="text-decoration:none;"><img src="images/DeleteN.png" alt="Delete" width="60" height="21" /></a>&nbsp;<a href="javascript:sbmtEvntSuspend(<?php echo $eventInfoArr['event_id']; ?>);" style="text-decoration:none;"><img src="images/suspendN.png" alt="Suspend" width="74" height="21" /></a>
														<?php
															}
														?>
														</div>
														</td>
<!--                                                        <td align="right" valign="bottom"><img src="images/previousN.png" alt="Preview" width="74" height="21" /> <img src="images/nextN.png" alt="Cancel" width="48" height="21" /></td>
-->                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" valign="top" style="padding:0px;">
												<table width="100%" border="0" cellspacing="0" cellpadding="2" bgcolor="#f5f5f5" id="txtshwRjctTblId" style="display:none;">
													<tr><td colspan="2" class="blackTxt14 pad-btm10 pad-lft10">Reason for rejection</td></tr>
													<tr>
														<td width="15" class="pad-lft10"><input name="txtDeclineId[]" type="checkbox" class="checkbox" id="txtDeclineId1" value="1" /></td>
														<td>Inappropriate content for our site</td>
													</tr>
													<tr>
														<td width="15"  class="pad-lft10"><input  name="txtDeclineId[]" type="checkbox" class="checkbox" id="txtDeclineId2" value="2" /></td>
														<td>Inappropriate picture</td>
													</tr>
													<tr>
														<td width="15" class="pad-lft10"><input  name="txtDeclineId[]" type="checkbox" class="checkbox" id="txtDeclineId3" value="3" /></td>
														<td>Picture quality and/or cropping is of poor quality</td>
													</tr>
													<tr>
														<td width="15" class="pad-lft10"><input  name="txtDeclineId[]" type="checkbox" class="checkbox" id="txtDeclineId4" value="4" /></td>
														<td>Information is confusing / dosen't make sense</td>
													</tr>
													<tr>
														<td width="15"  class="pad-lft10"><input  name="txtDeclineId[]" type="checkbox" class="checkbox" id="txtDeclineId5" value="5" onclick="unCheckOthers()" /></td>
														<td>
															<span class="FloatLft">Other, specify reason...</span>
															<span class="FloatLft pad-left12"><input name="other_reason" id="other_reason" class="inpuTxt510" value="" type="text" /></span>
                                                        </td>
													</tr>
													<tr>
														<td colspan="2" class="pad-top10 pad-lft10">
															<a href="javascript:hideField('txtshwRjctTblId');" style="text-decoration:none;"><img src="images/cancelN.png" alt="Cancel" width="66" height="21" /></a>&nbsp;
                                                            <a href="javascript:sbmtEvntReject();" style="text-decoration:none;"><img src="images/send.png" alt="Cancel" width="66" height="21" /></a>
                                                        </td>
													</tr>
												</table>
											</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" align="right" valign="top" class="header">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td>Reference ID : <?php echo $eventInfoArr['event_code']; ?></td>
                                                        <td align="right" valign="bottom"><a href="javascript: showEventPreview(<?php echo $eventInfoArr['event_id']; ?>);" style="text-decoration:none;"><img src="images/previewN.png" alt="Preview" width="71" height="21" border="0" /></a>&nbsp;<a href="admin-pending-approval.php?sec=event" style="text-decoration:none;"><img src="images/cancelChangesN.png" alt="Cancel" width="119" height="21" border="0" /></a>&nbsp;<a href="javascript:void(0);" onclick="frmValidateAddEvent();" style="text-decoration:none;"><img src="images/saveChangesN.png" alt="Save Approve" width="108" height="21" border="0" /></a></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="23"  align="right" valign="top" class="admleftBg">First name</td>
                                            <td  valign="top"><input name="txtEventOwnerFName" id="txtEventOwnerFNameId" type="text" class="inpuTxt260" value="<?php echo $eventInfoArr['event_owner_fname']; ?>" onkeydown="chkblnkTxtError('txtEventOwnerFNameId', 'txtEventOwnerFNameErrorId');" onkeyup="chkblnkTxtError('txtEventOwnerFNameId', 'txtEventOwnerFNameErrorId');" /><span class="pdError1 pad-lft10" id="txtEventOwnerFNameErrorId"></span></td>
                                        </tr>
                                        <tr>
                                            <td height="23"  align="right" valign="top" class="admleftBg">Last name</td>
                                            <td  valign="top"><input name="txtEventOwnerLName" id="txtEventOwnerLNameId" type="text" class="inpuTxt260" value="<?php echo $eventInfoArr['event_owner_lname']; ?>" onkeydown="chkblnkTxtError('txtEventOwnerLNameId', 'txtEventOwnerLNameErrorId');" onkeyup="chkblnkTxtError('txtEventOwnerLNameId', 'txtEventOwnerLNameErrorId');" /><span class="pdError1" id="txtEventOwnerLNameErrorId"></span></td>
                                        </tr>
                                        <tr>
                                            <td height="23"  align="right" valign="top" class="admleftBg">Last name</td>
                                            <td  valign="top"><input name="txtEventOwnerEmail" id="txtEventOwnerEmailId" type="text" class="inpuTxt260" value="<?php echo $eventInfoArr['event_owner_email']; ?>" onkeydown="chkblnkTxtError('txtEventOwnerEmailId', 'txtEventOwnerEmailErrorId');" onkeyup="chkblnkTxtError('txtEventOwnerEmailId', 'txtEventOwnerEmailErrorId');" /><span class="pdError1" id="txtEventOwnerEmailErrorId"></span></td>
                                        </tr>
                                        <tr>
                                            <td width="190" height="23" align="right" valign="top" class="admleftBg">Location</td>
                                            <td  valign="top">
                                            <div id="showtxtlocationcombo">
                                            <?php
                                                if(isset($eventInfoArr['event_area_id']) && ($eventInfoArr['event_area_id'] != "" || $eventInfoArr['event_area_id'] != "0")) {
                                                    $event_area_id = $eventInfoArr['event_area_id'];
                                                    ?>
                                                    <select name="txtAddEventArea" id="txtAddEventAreaId" onchange="return chkSelectArea4AddEvent();" style="display:block;" class="select216">
                                                        <?php 
                                                            $locationObj->fun_getAreaListOptions($event_area_id, '84');
                                                        ?>
                                                    </select>
                                                    <?php
                                                    if(isset($eventInfoArr['event_region_id']) && ($eventInfoArr['event_region_id'] != "0" || $eventInfoArr['event_region_id'] != "")) {
                                                        $event_region_id = $eventInfoArr['event_region_id'];
                                                    ?>
                                                    <select name="txtAddEventRegion" id="txtAddEventRegionId" onchange="return chkSelectRegion4AddEvent();" style="display:block;" class="select216">
                                                        <option value="0">All Areas ...</option>
                                                        <?php 
                                                            $locationObj->fun_getRegionListOptions($event_region_id, '0', $event_area_id);
                                                        ?>
                                                    </select>
                                                    <?php
                                                        if(isset($eventInfoArr['event_sub_region_id']) && ($eventInfoArr['event_sub_region_id'] != "0") && ($eventInfoArr['event_sub_region_id'] != "")) {
                                                            $event_sub_region_id = $eventInfoArr['event_sub_region_id'];
                                                            ?>
                                                            <select name="txtAddEventSubRegion" id="txtAddEventSubRegionId" onchange="return chkSelectSubRegion4AddEvent();" style="display:block;" class="select216">
                                                                <option value="0">All Areas ...</option>
                                                                <?php 
                                                                    $locationObj->fun_getRegionListOptions($event_sub_region_id, $event_region_id, $event_area_id);
                                                                ?>
                                                            </select>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <select name="txtAddEventSubRegion" id="txtAddEventSubRegionId" onchange="return chkSelectSubRegion4AddEvent();" style="display:<?php if(($event_region_id !="" && $event_region_id > 0) && (!isset($eventInfoArr['event_location_id']) || ($eventInfoArr['event_location_id'] == "0") || ($eventInfoArr['event_location_id'] == "")) && ($locationObj->fun_countSubRegionByRegionid($event_region_id) > 0)){echo "block";} else {echo "none";} ?>;" class="select216">
                                                                <option value="0">All Areas ...</option>
                                                                <?php 
                                                                if(($event_region_id !="" && $event_region_id > 0) && (!isset($eventInfoArr['event_location_id']) || ($eventInfoArr['event_location_id'] == "0") || ($eventInfoArr['event_location_id'] == ""))){
                                                                    $locationObj->fun_getRegionListOptions('', $event_region_id, $event_area_id);
                                                                }
                                                                ?>
                                                            </select>
                                                            <?php
                                                        }
                                                        if(isset($eventInfoArr['event_location_id']) && ($eventInfoArr['event_location_id'] != "0") && ($eventInfoArr['event_location_id'] != "")) {
                                                            $event_location_id = $eventInfoArr['event_location_id'];
                                                            ?>
                                                            <select name="txtAddEventLocation" id="txtAddEventLocationId" onchange="return chkSelectLocation4AddEvent();" style="display:block;" class="select216">
                                                                <option value="0">All Areas ...</option>
                                                                <?php
                                                                    $locationObj->fun_getLocationListOptions($event_location_id);
                                                                ?>
                                                            </select>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <select name="txtAddEventLocation" id="txtAddEventLocationId" onchange="return chkSelectLocation4AddEvent();" style="display:<?php if(((!isset($event_sub_region_id) || ($event_sub_region_id =="0")) && ($event_region_id !="") && ($event_region_id > 0) && ($locationObj->fun_countLocationsByRegionid($event_region_id) > 0)) || (($event_sub_region_id !="") && ($event_sub_region_id > 0) && ($locationObj->fun_countLocationsByRegionid($event_sub_region_id) > 0))){echo "block";} else {echo "none";} ?>;" class="select216">
                                                                <option value="0">All Areas ...</option>
                                                                <?php
                                                                if(($event_sub_region_id !="") && ($event_sub_region_id > 0) && ($locationObj->fun_countLocationsByRegionid($event_sub_region_id) > 0)) {
                                                                    $locationObj->fun_getLocationListOptions('', $event_sub_region_id);
                                                                } else if(($event_region_id !="") && ($event_region_id > 0) && ($locationObj->fun_countLocationsByRegionid($event_region_id) > 0)) {
                                                                    $locationObj->fun_getLocationListOptions('', $event_region_id);
                                                                }
                                                                ?>
                                                            </select>
                                                            <?php
                                                        }
                                                    }
                                                }
                                            ?>
                                            </div>
                                            <span class="pdError1" id="txtAddEventLocationErrorId"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="23" align="right" valign="top" class="admleftBg">Event / listing title</td>
                                            <td  valign="top"><input name="txtEventName" id="txtEventNameId" class="inpuTxt260" value="<?php if(isset($eventInfoArr['event_name']) && $eventInfoArr['event_name'] !="") { echo $eventInfoArr['event_name'];} else { echo "This will appear on search listings"; } ?>" type="text" onclick="return bnkEventTitle();" onblur="return restoreEventTitle();"  onkeydown="chkblnkTxtError('txtEventNameId', 'txtEventNameErrorId');" onkeyup="chkblnkTxtError('txtEventNameId', 'txtEventNameErrorId');" /></td>
                                        </tr>
                                        <tr>
                                            <td height="23" align="right" valign="top" class="admleftBg">Event / listing category</td>
                                            <td  valign="top">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<?php
													if(isset($eventInfoArr['event_cat_ids']) && ($eventInfoArr['event_cat_ids'] != "")) {
														$eventCatArr = explode(",", $eventInfoArr['event_cat_ids']);
														if(is_array($eventCatArr)) {
															for($i = 0; $i < count($eventCatArr); $i++) {
																$cat_id = $eventCatArr[$i];
																if($i == (count($eventCatArr)-1)) {
																?>
																	<tr id="rowAddNewEventCategoryId<?php echo $i; ?>">
																		<td valign="top">
																			<select class="select216" name="txtEventCategory[]" id="txtEventCategoryId<?php echo $i; ?>" onChange="chkblnkTxtError('txtEventCategoryId<?php echo $i; ?>', 'txtEventCategoryErrorId');">
																				<option value="">Select...</option>
																				<?php echo $eventObj->fun_getEventCategoryTypeOptionsList($cat_id); ?>
																			</select>                                                        
																		</td>
																		<td valign="top" width="9"></td>
																		<td class="pad-top1" valign="top"><span class="pdError1" id="txtEventCategoryErrorId"></span></td>
																	</tr>
																<?php
																} else {
																?>
																	<tr id="rowAddNewEventCategoryId<?php echo $i; ?>">
																		<td valign="top">
																			<select class="select216" name="txtEventCategory[]" id="txtEventCategoryId<?php echo $i; ?>" onChange="chkblnkTxtError('txtEventCategoryId<?php echo $i; ?>', 'txtEventCategoryErrorId');">
																				<option value="">Select...</option>
																				<?php echo $eventObj->fun_getEventCategoryTypeOptionsList($cat_id); ?>
																			</select>                                                        
																		</td>
																		<td valign="top" width="9"></td>
																		<td class="pad-top1" valign="top"></td>
																	</tr>
																<?php
																}
															}
														}
													} else {
													?>
													<tr id="rowAddNewEventCategoryId0">
														<td valign="top">
															<select class="select216" name="txtEventCategory[]" id="txtEventCategoryId0" onChange="chkblnkTxtError('txtEventCategoryId0', 'txtEventCategoryErrorId');">
																<option value="">Select...</option>
																<?php echo $eventObj->fun_getEventCategoryTypeOptionsList(); ?>
															</select>                                        
														</td>
														<td valign="top" width="9"></td>
														<td class="pad-top1" valign="top"><span class="pdError1" id="txtEventCategoryErrorId"></span></td>
													</tr>
													<?php
													}
													?>
													<tr>
														<td colspan="3">
															<input type="hidden" value="0" id="theValue" />
															<div id="myDiv1"> </div>									
														</td>
													</tr>
													<tr>
														<td class="pad-btm15 pad-left7" colspan="3" valign="top">
															<a href="javascript:void(0);" onClick="addEvent1();" class="add-photo">Add another category </a> (Useful for events that fit into more than one category)														</td>
													</tr>
												</table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="23" align="right" valign="top" class="admleftBg">Is it open all year round?</td>
                                            <td  valign="top">
												<?php 
                                                    if(isset($eventInfoArr['event_year_around']) && ($eventInfoArr['event_year_around'] == "1")) { 
                                                ?>
                                                <span><input type="radio" class="radio" name="txtYearRound" id="txtYearRoundId1" value="1" onclick="hideField('tblShwDateId');void(0);" checked="checked" /></span>
                                                <span><strong>YES</strong></span>
                                                <span class="pad-lft20"><input type="radio" class="radio" name="txtYearRound" id="txtYearRoundId2" value="0" onclick="showField('tblShwDateId');void(0);" /></span>
                                                <span><strong>NO</strong></span>									
                                                <?php
                                                    } else { 
                                                ?>
                                                <span><input type="radio" class="radio" name="txtYearRound" id="txtYearRoundId1" value="1" onclick="hideField('tblShwDateId');void(0);" /></span>
                                                <span><strong>YES</strong></span>
                                                <span class="pad-lft20"><input type="radio" class="radio" name="txtYearRound" id="txtYearRoundId2" value="0" onclick="showField('tblShwDateId');void(0);" checked="checked" /></span>
                                                <span><strong>NO</strong></span>									
                                                <?php
                                                    } 
                                                ?>
												<span class="pdError1" id="txtYearRoundErrorId"></span>                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" colspan="2" style="padding:0px;">
												<table id="tblShwDateId" border="0" width="100%" cellspacing="0"  cellpadding="10" class="eventForm" style="display:<?php if((isset($eventInfoArr['event_year_around']) && ($eventInfoArr['event_year_around'] != "1")) || !isset($eventInfoArr['event_year_around'])) { echo "block";} else { echo "none";} ?>;">
													<tr>
														<td width="155" height="23" align="right" valign="top" class="admleftBg" style="border-right:1px solid #bdbdbd;">Event / listing start date<span class="red">*</span></td>
														<td  valign="top">
															<?php
																if(isset($eventInfoArr['event_start_date']) && ($eventInfoArr['event_start_date'] != "")) {
																	$fromDateArr 		= explode("-", $eventInfoArr['event_start_date']);
																	$txtDayFrom1 		= $fromDateArr[2];
																	$txtMonthFrom1 		= $fromDateArr[1];
																	$txtYearFrom1 		= $fromDateArr[0];
//																	echo $txtDayFrom1."tsjkjsdkj<br>";
																	/*
																	foreach($monthname as $key => $value)
																	{
																		echo $key."<br>";
																	}
																	*/

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
																			<option value="<?=$value?>" <? if(isset($txtDayFrom1) && ($value==$txtDayFrom1)){echo "selected";}else{echo "";}?>><?=($key+1)?></option>
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
																			<option value="<?=$key?>" <? if(isset($txtMonthFrom1) && ($key==$txtMonthFrom1)){echo "selected";}else{echo "";}?>><?=$value?></option>
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
																			<option value="<?=$value?>" <? if(isset($txtYearFrom1) && ($value==$txtYearFrom1)){echo "selected";}else{echo "";}?>><?=$value?></option>
																		<?
																		}
																		?>
																	</select>															
																	</td>
																	<td align="right"><a href="JavaScript:find_cal(<?php echo time()?>,'From1');"><img src="images/calender.gif" alt="calendar" /></a></td>
																</tr>
															</table>
															<span class="pdError1" id="txtDateFromErrorId"></span>														</td>
													</tr>
													<tr>
														<td height="23" align="right" valign="top" class="admleftBg" style="border-right:1px solid #bdbdbd;">Event / listing end date</td>
														<td  valign="top">
															<?php
																if(isset($eventInfoArr['event_end_date']) && ($eventInfoArr['event_end_date'] != "")) {
																	$toDateArr 		= explode("-", $eventInfoArr['event_end_date']);
 																	$txtDayTo1 		= $toDateArr[2];
																	$txtMonthTo1 	= $toDateArr[1];
																	$txtYearTo1 	= $toDateArr[0];
//																	echo $txtMonthTo1."tsjkjsdkj<br>";
																	/*
																	echo $txtMonthTo1."tsjkjsdkj<br>";
																	foreach($monthname as $key => $value)
																	{
																		echo $key."<br>";
																	}
																	*/
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
																				<option value="<?=$value?>" <? if(isset($txtDayTo1) && ($value == $txtDayTo1)){echo "selected";}else{echo "";}?>><?=($key+1)?></option>
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
																				<option value="<?=$key?>" <? if(isset($txtMonthTo1) && ($key==$txtMonthTo1)){echo "selected";}else{echo "";}?>><?=$value?></option>
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
																				<option value="<?=$value?>" <? if(isset($txtYearTo1) && ($value==$txtYearTo1)){echo "selected";}else{echo "";}?>><?=$value?></option>
																			<?
																			}
																			?>
																		</select>															
																	</td>
																	<td align="right"><a href="JavaScript:find_cal(<?php echo time()?>,'To1');"><img src="images/calender.gif" alt="calendar" /></a></td>
																</tr>
															</table>
															<span class="pdError1" id="txtDateToErrorId"></span>														</td>
													</tr>
												</table>
											</td>
										</tr>
                                        <tr>
                                            <td height="23" align="right" valign="top" class="admleftBg">Times</td>
                                            <td  valign="top"><input name="txtEventTime" id="txtEventTimeId" class="inpuTxt260" value="<?php if(isset($eventInfoArr['event_time']) && $eventInfoArr['event_time'] !="") { echo $eventInfoArr['event_time'];} else { echo "eg opening times or show times"; } ?>" type="text" onclick="return bnkEventTime();" onblur="return restoreEventTime();" /></td>
                                        </tr>
                                        <tr>
                                            <td height="23" align="right" valign="top" class="admleftBg">Prices</td>
                                            <td  valign="top"><input name="txtEventPrice" id="txtEventPriceId" class="inpuTxt260" value="<?php if(isset($eventInfoArr['event_price']) && $eventInfoArr['event_price'] !="") { echo $eventInfoArr['event_price'];} else { echo "These will appear exactly as typed"; } ?>" type="text" onclick="return bnkEventPrice();" onblur="return restoreEventPrice();"  /></td>
                                        </tr>
                                        <tr>
                                            <td height="23" align="right" valign="top" class="admleftBg">Venue</td>
                                            <td  valign="top">
												<textarea name="txtEventVenue" id="txtEventVenueId" class="textArea260"><?php echo $eventInfoArr['event_venue']; ?></textarea>
												<span class="pdError1" id="txtEventVenueErrorId"></span>											
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="23" align="right" valign="top" class="admleftBg">Phone Number</td>
                                            <td  valign="top"><input name="txtEventPhone" id="txtEventPhoneId" class="inpuTxt260" value="<?php echo $eventInfoArr['event_phone']; ?>" type="text" onkeydown="chkblnkTxtError('txtEventPhoneId', 'txtEventPhoneErrorId');" onkeyup="chkblnkTxtError('txtEventPhoneId', 'txtEventPhoneErrorId');"/><span class="pdError1" id="txtEventPhoneErrorId"></span></td>
                                        </tr>
                                        <tr>
                                            <td height="23" align="right" valign="top" class="admleftBg">Email</td>
                                            <td  valign="top"><input name="txtEventEmail" id="txtEventEmailId" class="inpuTxt260" value="<?php echo $eventInfoArr['event_email']; ?>" type="text" onkeydown="chkblnkTxtError('txtEventEmailId', 'txtEventEmailErrorId');" onkeyup="chkblnkTxtError('txtEventEmailId', 'txtEventEmailErrorId');" /></td>
                                        </tr>
                                        <tr>
                                            <td height="23" align="right" valign="top" class="admleftBg">Website</td>
                                            <td  valign="top"><input name="txtEventWebsite" id="txtEventWebsiteId" class="inpuTxt260" value="<?php echo $eventInfoArr['event_website']; ?>" type="text" /></td>
                                        </tr>
                                        <tr>
                                            <td height="23" align="right" valign="top" class="admleftBg">Description</td>
                                            <td  valign="top">
												<textarea name="txtEventDesc" id="txtEventDescId" class="textArea460" onkeydown="chkblnkTxtError('txtEventDescId', 'txtEventDescErrorId');" onkeyup="chkblnkTxtError('txtEventDescId', 'txtEventDescErrorId');" ><?php echo $eventInfoArr['event_description']; ?></textarea>
											</td>
                                        </tr>
										<tr>
											<td height="23" width="190" align="right" valign="top" class="admleftBg">Picture</td>
											<td  valign="top" style="padding:0px;">
												<script language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>si.files.js" type="text/javascript"></script>
												<script type="text/javascript" language="javascript">
													function uploadFile(obj, val) {
														fileVal 		= "txtFile"+val;
														filePhotoVal	= "txtPhoto"+val;
														photoError		= "photoError"+val;
														fileUrl 		= document.getElementById(fileVal).value;
														fileUrl				= rm_trim(fileUrl);
														if(fileUrl == ""){
															document.getElementById(photoError).innerHTML = "<font color='#FFFFFF' size='2'><strong>Please select a photo to upload</strong></font>";
															document.getElementById(filePhotoVal).focus();
															return false;
														}
														else{
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
													background-image: url(images/browse.gif);
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
												<table border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
													<tr>
														<td>
														<?php 
														if($eventInfoArr['event_thumb'] != "") {
															$event_thumb 		= EVENT_IMAGES_THUMB168x127_PATH.$eventInfoArr['event_thumb'];
															$evntPhotoCaption	= $eventInfoArr['event_img_caption'];
															$evntPhotoBy		= $eventInfoArr['event_img_by'];
															$evntPhotoLink		= $eventInfoArr['event_img_link'];
														} else {
															$event_thumb = EVENT_IMAGES_THUMB168x127_PATH."your-picture.gif";
															$evntPhotoCaption	= "Add caption for image ...";
															$evntPhotoCaption	.= "\nLeave blank if not required";
															$evntPhotoBy		= "Photo by";
															$evntPhotoLink		= "http://";
														}
														?>
														<img src="<?php echo $event_thumb; ?>" name="PreviewImage0" width="199" height="149" class="photo-add" id="PreviewImage0" />														</td>
														<td align="left" valign="top" class="pad-rgt10">
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
																	<td style="padding-top:13px;"><input name="txtPhoto" type="text" id="txtPhoto0"  style="width:140px; height:17px; border: solid 1px #aeaeae; padding-top:2px; padding-bottom:2px; padding-left:5px;" value="" /></td>
																	<td style="padding-top:13px;"><img src="images/upload.gif" alt="upload" onclick="return uploadFile(document.frmAddEvent, '0');" /></td>
																</tr>
																<tr>
																	<td style="padding-top:16px; padding-left:10px;" colspan="3">
                                                                        <textarea name="txtEvntPhotoCaption" id="txtEvntPhotoCaptionId" class="textArea260x60" onclick="return bnkEvntImgCaption();" onblur="return restoreEvntImgCaption();" ><?php echo $evntPhotoCaption; ?></textarea>                                                    
                                                                        <div style=" padding-bottom:10px;">
                                                                        <input name="txtEvntPhotoBy" id="txtEvntPhotoById" class="inpuTxt270" value="<?php if(isset($evntPhotoBy) && $evntPhotoBy !="") { echo $evntPhotoBy;} else { echo "Photo by"; } ?>" type="text" onclick="return bnkEvntPhotoBy();" onblur="return restoreEvntPhotoBy();"  onkeydown="chkblnkTxtError('txtEvntPhotoById', 'photoError0');" onkeyup="chkblnkTxtError('txtEvntPhotoById', 'photoError0');" />
                                                                        </div>
                                                                        <input name="txtEvntPhotoLink" id="txtEvntPhotoLinkId" class="inpuTxt270" value="<?php if(isset($evntPhotoLink) && $evntPhotoLink !="") { echo $evntPhotoLink;} else { echo "http://"; } ?>" type="text" onclick="return bnkEvntPhotoLink();" onblur="return restoreEvntPhotoLink();"  onkeydown="chkblnkTxtError('txtEvntPhotoLinkId', 'photoError0');" onkeyup="chkblnkTxtError('txtEvntPhotoLinkId', 'photoError0');" />
                                                                        <p style="float:left; font-size:12px; padding-top:10px;"><strong>Not happy with this picture ? Just<a href="javascript:void(0);" class="blue-link"> Browse</a> and <a href="javascript:void(0);" class="blue-link">Upload</a> again</strong></p>

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
										<tr>
											<td height="23" align="right" valign="top" class="admleftBg">Receive newsletters</td>
											<td  valign="top">
												<span><input name="txtNewsLetterChk" id="txtNewsLetterChkId" type="radio" class="radio" value="1" <?php if(isset($_POST['txtNewsLetterChk']) && $_POST['txtNewsLetterChk'] == "1") {echo "checked";} ?> /></span>
												<span class="pad-left3"><strong>YES</strong></span>
												<span class="pad-lft20"><input name="txtNewsLetterChk" id="txtNewsLetterChkId" type="radio" class="radio" value="0" <?php if((isset($_POST['txtNewsLetterChk']) && $_POST['txtNewsLetterChk'] == "0") || (!isset($_POST['txtNewsLetterChk']))) {echo "checked";} ?> /></span>
												<span class="pad-left3"><strong>NO</strong></span>											</td>
										</tr>
										<tr>
											<td colspan="2" align="right" valign="top" class="header">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td>Reference ID : <?php echo $eventInfoArr['event_code']; ?></td>
														<td align="right" valign="bottom"><a href="javascript: showEventPreview(<?php echo $eventInfoArr['event_id']; ?>);" style="text-decoration:none;"><img src="images/previewN.png" alt="Preview" width="71" height="21" border="0" /></a>&nbsp;<a href="admin-pending-approval.php?sec=event" style="text-decoration:none;"><img src="images/cancelChangesN.png" alt="Cancel" width="119" height="21" /></a>&nbsp;<a href="javascript:void(0);" onclick="frmValidateAddEvent();" style="text-decoration:none;"><img src="images/saveChangesN.png" alt="Save Approve" width="108" height="21" border="0" /></a></td>
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
                <tr><td valign="top">&nbsp;</td></tr>
                <tr><td valign="top">&nbsp;</td></tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2" valign="top">
            <div id="event-pop" class="box cursor1" style="display:none; position:relative; z-index:5; left:0px; top:0px;">
            <!--[if IE]><iframe id="iframe" frameborder="0" style="position:relative; top:-405px; left:205px; width:332px; height:200px;"></iframe><![endif]-->
            <div class="content">
            <div onMouseDown="dragStart(event, 'event-pop');" style="position:absolute; z-index:999; top:-410px; left:200px;width:350px;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="right"><img src="images/poplefttop.png" alt="ANP" height="10" width="10" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/poplefttop.png', sizingMethod='scale');" /></td>
                    <td class="topp"></td>
                    <td><img src="images/poprighttop1.png" alt="ANP"  height="10" width="15" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/poprighttop1.png', sizingMethod='scale');"/></td>
                </tr>
                <tr>
                    <td class="leftp"></td>
                    <td align="left" valign="top" bgcolor="#FFFFFF" style="padding:6px;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="375" align="left" valign="top" class="head">Add an event</td>
                                <td width="15" align="right" valign="top"><a href="#" onclick="javascript:toggleLayer1('event-pop');"><img src="images/pop-up-cross.gif" alt="Close" title="Close" border="0" /></a></td>
                            </tr>
                            <tr>
                                <td  align="left" valign="top" class="PopTxt pad-top10">
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td width="135" valign="top" class="pad-rgt10 pad-btm15">Type of user</td>
                                            <td valign="top" class="pad-btm15 pad-top2">
                                                <table border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td valign="middle" class="pad-btm10"><input name="radio" type="radio" class="radio" id="radio" value="radio" checked="checked" /></td>
                                                        <td valign="top" class="pad-left3 pad-btm10">FREE</td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="middle" class="pad-btm10"><input name="radio" type="radio" class="radio" id="radio2" value="radio" /></td>
                                                        <td valign="top" class="pad-left3 pad-btm10">Featured</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" valign="top" class="pad-rgt10 pad-btm10">Event title</td>
                                            <td align="right" valign="top" class="pad-btm10"><input name="textfield3" type="text" class="Textfield195" id="textfield3" /></td>
                                        </tr>
                                        <tr>
                                            <td align="left" valign="top" class="pad-rgt10">Category</td>
                                            <td align="left" valign="top">
                                                <select name="select8" class="Listmenu170" id="select3">
                                                    <option>Art &amp; Culture</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="pad-rgt10">&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td class="pad-rgt10">&nbsp;</td>
                                            <td align="right"><span class="pad-rgt10"> <a href="#" onclick="javascript:toggleLayer1('event-pop');" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image26','','images/Cancel-48x21-over.gif',1)"><img src="images/Cancel-48x21-normal.gif" alt="Cancel" name="Image26" width="48" height="21" border="0" id="Image26" /></a></span><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image27','','images/add-event-over.gif',1)"><img src="images/add-event-out.gif" alt="Add event" name="Image27" width="84" height="21" border="0" id="Image27" /></a></td>
                                        </tr>
                                    </table>
                                </td>
                                <td  align="left" valign="top" class="PopTxt">&nbsp;</td>
                            </tr>
                            <tr><td colspan="2" align="left" valign="top" height="8"></td></tr>
                        </table>
                    </td>
                    <td class="rightp" width="10"></td>
                </tr>
                <tr>
                    <td align="right"><img src="images/popleftbtm.png" alt="ANP" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/popleftbtm.png', sizingMethod='crop');" width="10" height="10"/></td>
                    <td  class="bottomp"></td>
                    <td align="left"><img src="images/poprightbtm1.png" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/poprightbtm1.png', sizingMethod='crop');" width="15" height="10" alt="ANP"/></td>
                </tr>
            </table>
            </div>
            </div>
            </div>
        </td>
    </tr>
</table>
</form>
<?php
} else {
	if(isset($_GET['status']) && $_GET['status'] > 0) {
		$strQuery = " WHERE A.status='".$_GET['status']."' ";
	}
	if(isset($_GET['sortby']) && $_GET['sortby'] != ""){
		$strQuery .= " ORDER BY ";
		switch($_GET['sortby']){
			case 'evntcode':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$evntcodedr 		= 0;
					$evntcatdr 			= 1;
					$evnttitledr		= 1;
					$evntfeatureddr 	= 1;
					$evntstartdatedr 	= 1;
					$evntstatusdr 		= 1;
				}
				else{
					$dr = "DESC";
					$evntcodedr 		= 1;
					$evntcatdr 			= 1;
					$evnttitledr		= 1;
					$evntfeatureddr 	= 1;
					$evntstartdatedr 	= 1;
					$evntstatusdr 		= 1;
				}
				$strQuery .= " A.event_code ".$dr;
			break;
			case 'evntcat':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$evntcodedr 		= 1;
					$evntcatdr 			= 0;
					$evnttitledr		= 1;
					$evntfeatureddr 	= 1;
					$evntstartdatedr 	= 1;
					$evntstatusdr 		= 1;
				}
				else{
					$dr = "DESC";
					$evntcodedr 		= 1;
					$evntcatdr 			= 1;
					$evnttitledr		= 1;
					$evntfeatureddr 	= 1;
					$evntstartdatedr 	= 1;
					$evntstatusdr 		= 1;
				}
				$strQuery .= " A.event_cat_ids ".$dr;
			break;
			case 'evnttitle':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$evntcodedr 		= 1;
					$evntcatdr 			= 1;
					$evnttitledr		= 0;
					$evntfeatureddr 	= 1;
					$evntstartdatedr 	= 1;
					$evntstatusdr 		= 1;
				}
				else{
					$dr = "DESC";
					$evntcodedr 		= 1;
					$evntcatdr 			= 1;
					$evnttitledr		= 1;
					$evntfeatureddr 	= 1;
					$evntstartdatedr 	= 1;
					$evntstatusdr 		= 1;
				}
				$strQuery .= " A.event_name ".$dr;
			break;
			case 'evntfeatured':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$evntcodedr 	= 1;
					$evntcatdr 		= 1;
					$evnttitledr	= 1;
					$evntfeatureddr 	= 0;
					$evntstartdatedr 	= 1;
					$evntstatusdr 	= 1;
				}
				else{
					$dr = "DESC";
					$evntcodedr 		= 1;
					$evntcatdr 			= 1;
					$evnttitledr		= 1;
					$evntfeatureddr 	= 1;
					$evntstartdatedr 	= 1;
					$evntstatusdr 		= 1;
				}
				$strQuery .= " A.featured ".$dr;
			break;
			case 'evntstartdate':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$evntcodedr 		= 1;
					$evntcatdr 			= 1;
					$evnttitledr		= 1;
					$evntfeatureddr 	= 1;
					$evntstartdatedr 	= 0;
					$evntstatusdr 		= 1;
				}
				else{
					$dr = "DESC";
					$evntcodedr 		= 1;
					$evntcatdr 			= 1;
					$evnttitledr		= 1;
					$evntfeatureddr 	= 1;
					$evntstartdatedr 	= 1;
					$evntstatusdr 		= 1;
				}
				$strQuery .= " A.created_on ".$dr;
			break;
			case 'evntstatus':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$evntcodedr 		= 1;
					$evntcatdr 			= 1;
					$evnttitledr		= 1;
					$evntfeatureddr 	= 1;
					$evntstartdatedr 	= 1;
					$evntstatusdr 		= 0;
				}
				else{
					$dr = "DESC";
					$evntcodedr 		= 1;
					$evntcatdr 			= 1;
					$evnttitledr		= 1;
					$evntfeatureddr 	= 1;
					$evntstartdatedr 	= 1;
					$evntstatusdr 		= 1;
				}
				$strQuery .= " A.status ".$dr;
			break;
		}
	} else {
		$evntcodedr 		= 1;
		$evntcatdr 			= 1;
		$evnttitledr		= 1;
		$evntfeatureddr 	= 1;
		$evntstartdatedr 	= 1;
		$evntstatusdr 		= 1;
	}

	$evntListArr = $eventObj->fun_getPendingApprovalEventsArr($strQuery);
	//print_r($evntListArr);
	if(count($evntListArr) > 0){
	?>
		<script language="javascript" type="text/javascript">
            var req = ajaxFunction();
        
            function chkFeaturedEvent(strCheckboxId){
                var eventId = document.getElementById(strCheckboxId).value;
                
                if(document.getElementById(strCheckboxId).checked == true) {
                    var url = "../eventFeaturedXml.php?evtid="+eventId+"&featured=1";
                } else {
                    var url = "../eventFeaturedXml.php?evtid="+eventId+"&featured=0";
                }
                req.onreadystatechange = handleEventFeatureResponse;
                req.open("GET", url); 
                req.send(null);   
            }
        
            function handleEventFeatureResponse(){
                var arrayOfEventFeature 	= new Array();
                if(req.readyState == 4){
                    var response=req.responseText;
                    xmlDoc=req.responseXML;
                    var root = xmlDoc.getElementsByTagName('events')[0];
                    if(root != null){
                        var items = root.getElementsByTagName("event");
                        for (var i = 0 ; i < items.length ; i++){
                            var item 				= items[i];
                            var eventfeature 		= item.getElementsByTagName("eventfeature")[0].firstChild.nodeValue;
                            arrayOfEventFeature[i] 	= eventfeature;
                            if(arrayOfEventFeature[i] == "Event updated."){
                                window.location = 'admin-pending-approval.php?sec=event';
                            }
                        }
                    }
                }
            }
            
            function listByEventStatus(id) {
                var statusId = id;
                var url = 'admin-pending-approval.php?sec=event';
                if(parseInt(statusId) > 0) {
                    url += '&status='+id;
                }
                window.location = url;
    //			alert(id);
            }
        </script>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr><td colspan="2" valign="top">&nbsp;</td></tr>
			<tr>
				<td colspan="2" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
						<tr><td height="10" colspan="2" valign="top" class="dash-top"></td></tr>
						<tr>
							<td valign="top" class="boldTitle" width="90">
							Filter events
							</td>
							<td align="left" valign="top">
								<select class="select216" name="txtEventStatus" id="txtEventStatusId" onChange="listByEventStatus(this.value);">
									<option value="0">View all</option>
									<option value="1" <?php if(isset($_GET['status']) && $_GET['status'] == "1") {echo " selected=\"selected\"";} ?>>Pending approval</option>
									<option value="2" <?php if(isset($_GET['status']) && $_GET['status'] == "2") {echo " selected=\"selected\"";} ?>>Approved</option>
									<option value="3" <?php if(isset($_GET['status']) && $_GET['status'] == "3") {echo " selected=\"selected\"";} ?>>Archived</option>
									<option value="4" <?php if(isset($_GET['status']) && $_GET['status'] == "4") {echo " selected=\"selected\"";} ?>>Suspended</option>
								</select>                                                        
							</td>
						</tr>
						<tr><td height="10" colspan="2" valign="top" class="dash-top"></td></tr>
					</table>
				</td>
			</tr>
			<tr><td colspan="2" valign="top">&nbsp;</td></tr>
			<tr>
				<td valign="top">Display <?php echo count($evntListArr); ?>-<?php echo count($evntListArr); ?> of <?php echo count($evntListArr); ?></td>
				<td align="right" valign="top" class="Paging">
                <!--
                <a href="#">First</a> <a href="#">&lt;</a> <a href="#">1</a> | 2 | <a href="#">3</a> | <a href="#">4</a> | <a href="#">5</a> | <a href="#">6</a> | <a href="#">7</a> | <a href="#">8</a> | <a href="#">9</a> | <a href="#">10</a>...<a href="#">23</a> <a href="#">&gt;</a> <a href="#">Last</a>
                -->
                </td>
			</tr>
			<tr><td colspan="2" valign="top">&nbsp;</td></tr>
			<tr>
				<td colspan="2" valign="top">
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EventListing">
						<thead>
							<tr>
								<th width="10%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=event&sortby=evntcode&dr=".$evntcodedr.$statusTxt;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "evntcode")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?> ><div>ID</div></th>
								<th width="25%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=event&sortby=evntcat&dr=".$evntcatdr.$statusTxt;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "evntcat")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?> ><div>Category</div></th>
								<th width="25%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=event&sortby=evnttitle&dr=".$evnttitledr.$statusTxt;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "evnttitle")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Title</div></th>
								<th width="10%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=event&sortby=evntfeatured&dr=".$evntfeatureddr.$statusTxt;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "evntfeatured")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Featured</div></th>
								<th width="15%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=event&sortby=evntstartdate&dr=".$evntstartdatedr.$statusTxt;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "evntstartdate")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Start Date</div></th>
								<th width="15%" scope="col" class="right" onmouseover="this.className = 'rightOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=event&sortby=evntstatus&dr=".$evntstatusdr.$statusTxt;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "evntstatus")){echo "class=\"rightOver\" onmouseout=\"this.className = 'rightOver';\" ";}else{echo "onmouseout=\"this.className = 'right';\"";}?>><div>Status</div></th>
							</tr>
						</thead>
						<tbody>
							<?php
                            for($i=0; $i < count($evntListArr); $i++){
                            $event_id 			= $evntListArr[$i]['event_id'];
                            $event_cat_ids 		= $evntListArr[$i]['event_cat_ids'];
                            $event_code 		= $evntListArr[$i]['event_code'];
                            $event_name 		= $evntListArr[$i]['event_name'];
                            $status 			= $evntListArr[$i]['status'];
                            $status_name 		= $evntListArr[$i]['status_name'];
							$event_year_around 	= $evntListArr[$i]['event_year_around'];
							$event_start_date	= $evntListArr[$i]['event_start_date'];
							if(isset($event_year_around) && $event_year_around == "1") {
							$event_start 		= "All year round";
							} else {
							$event_start 		= date('M d, Y', strtotime($event_start_date));
							}
							
//                          $created_on 		= date('M d, Y', strtotime($evntListArr[$i]['created_on']));
                            $featured 			= $evntListArr[$i]['featured'];
                            $active 			= $evntListArr[$i]['active'];
                            ?>
                                <tr>
                                    <td class="left"><a href="admin-pending-approval.php?sec=event&evntid=<?php echo $event_id.$statusTxt;?>"><?php echo $event_code;?></a></td>
                                    <td><?php echo $eventObj->fun_getEventCatNameByCatIdsWithNL($event_cat_ids); ?></td>
                                    <td><?php echo $event_name;?></td>
                                    <td align="center">
                                    <input type="checkbox" name="txtFeature[]" id="txtFeatureId<?php echo $i; ?>" value="<?php echo $event_id;?>" <?php if($featured == "1"){ echo "checked"; }; ?> onclick="chkFeaturedEvent('txtFeatureId<?php echo $i; ?>');" />
                                    </td>
                                    <td><?php echo $event_start;?></td>
                                    <td class="right"><?php echo ucfirst($status_name);?></td>
                                </tr>
                            <?php
                            }
                            ?>
						</tbody>
					</table>
				</td>
			</tr>
			<tr><td colspan="2" valign="top">&nbsp;</td></tr>
            <!--
			<tr>
				<td valign="top">&nbsp;</td>
				<td align="right" valign="top" class="Paging"><a href="#">First</a> <a href="#">&lt;</a> <a href="#">1</a> | 2 | <a href="#">3</a> | <a href="#">4</a> | <a href="#">5</a> | <a href="#">6</a> | <a href="#">7</a> | <a href="#">8</a> | <a href="#">9</a> | <a href="#">10</a>...<a href="#">23</a> <a href="#">&gt;</a> <a href="#">Last</a></td>
			</tr>
            -->
		</table>
	<?php
	} else {
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td valign="top">No event Added!</td>
			</tr>
		</table>
		<?php
	}
}
?>