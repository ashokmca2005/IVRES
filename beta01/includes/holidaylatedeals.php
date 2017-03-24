<?php 
$dayname 	= array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');
$monthname 	= array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec');
$yearname 	= array(date('Y')+0,date('Y')+1,date('Y')+2,date('Y')+3);
?>
<script language="javascript" type="text/javascript">
	var req = ajaxFunction();
	var x1 	= "";
	var y1 	= "";

	/*
	* For location : Start here
	*/
	function chkSelectArea() {
		var getID=document.getElementById("txtPropertyAreaId").value;
		if(getID !="" && getID != "0"){
			sendRegionRequest(getID);
			document.getElementById("txtPropertyRegionId").value = "0";
			document.getElementById("txtPropertySubRegionId").value = "0";
			document.getElementById("txtPropertyLocationId").value = "0";
		}
		if(getID == "0" || getID =="") {
			document.getElementById("txtPropertyAreaId").value = "0";
			document.getElementById("txtPropertyRegionId").value = "0";
			document.getElementById("txtPropertySubRegionId").value = "0";
			document.getElementById("txtPropertyLocationId").value = "0";
			document.getElementById("txtPropertySubRegionId").style.display = "none";
			document.getElementById("txtPropertyLocationId").style.display = "none";
		}
	}
	function chkSelectRegion() {
		var getID=document.getElementById("txtPropertyRegionId").value;
		if(getID !="" && getID != "0"){
			sendSubRegionRequest(getID);
			document.getElementById("txtPropertySubRegionId").value = "0";
			document.getElementById("txtPropertyLocationId").value = "0";

			var txtDestination = document.getElementById('txtPropertyRegionId')[document.getElementById('txtPropertyRegionId').selectedIndex].innerHTML;
			txtDestination = txtDestination.toLowerCase();
			txtDestination = str_replace(" ", "-", txtDestination);
			document.frmRefinePropDeals.action = "<?php echo SITE_URL; ?>latedeals/in."+txtDestination;
		}
		if(getID == "0" || getID =="") {
			document.getElementById("txtPropertyRegionId").value = "0";
			document.getElementById("txtPropertySubRegionId").value = "0";
			document.getElementById("txtPropertyLocationId").value = "0";
			document.getElementById("txtPropertySubRegionId").style.display = "none";
			document.getElementById("txtPropertyLocationId").style.display = "none";
		}
	}
	
	function chkSelectSubRegion() {
		var getID=document.getElementById("txtPropertySubRegionId").value;
		if(getID !="" && getID != "0"){
			sendLocationRequest(getID);
			document.getElementById("txtPropertyLocationId").value = "0";

			var txtDestination = document.getElementById('txtPropertySubRegionId')[document.getElementById('txtPropertySubRegionId').selectedIndex].innerHTML;
			txtDestination = txtDestination.toLowerCase();
			txtDestination = str_replace(" ", "-", txtDestination);
			document.frmRefinePropDeals.action = "<?php echo SITE_URL; ?>latedeals/in."+txtDestination;
		}
		if(getID == "0" || getID =="") {
			document.getElementById("txtPropertySubRegionId").value = "0";
			document.getElementById("txtPropertyLocationId").value = "0";
			document.getElementById("txtPropertyLocationId").style.display = "none";
		}
	}

	function chkSelectLocation() {
		var getID=document.getElementById("txtPropertyLocationId").value;
		if(getID !="" && getID != "0"){
			var txtDestination = document.getElementById('txtPropertyLocationId')[document.getElementById('txtPropertyLocationId').selectedIndex].innerHTML;
			txtDestination = txtDestination.toLowerCase();
			txtDestination = str_replace(" ", "-", txtDestination);
			document.frmRefinePropDeals.action = "<?php echo SITE_URL; ?>latedeals/in."+txtDestination;
		}
		if(getID == "0" || getID =="") {
			document.getElementById("txtPropertyLocationId").value = "0";
		}
	}	

	function sendAreaRequest(id) { 
		req.open('get', '<?php echo SITE_URL;?>selectAreaXml.php?id=' + id); 
		req.onreadystatechange = handleAreaResponse; 
		req.send(null); 
	} 
	
	function sendRegionRequest(id) { 
		req.open('get', '<?php echo SITE_URL;?>selectRegionXml.php?id=' + id); 
		req.onreadystatechange = handleRegionResponse; 
		req.send(null); 
	} 
	
	function sendSubRegionRequest(id) { 
		req.open('get', '<?php echo SITE_URL;?>selectSubRegionXml.php?id=' + id); 
		req.onreadystatechange = handleSubRegionResponse; 
		req.send(null); 
	} 
	
	function sendLocationRequest(id) { 
		req.open('get', '<?php echo SITE_URL;?>selectLocationXml.php?id=' + id); 
		req.onreadystatechange = handleLocationResponse; 
		req.send(null); 
	} 
	
	function handleAreaResponse() { 
		var arrayOfId = new Array();
		var arrayOfNames = new Array();
		if(req.readyState == 4) { 
			var response = req.responseText; 
			xmlDoc=req.responseXML;
			var root = xmlDoc.getElementsByTagName('ntowns')[0];
			if(root != null) {
				document.getElementById("txtPropertyAreaId").style.display = "block";
				document.getElementById("txtPropertyRegionId").style.display = "none";
				document.getElementById("txtPropertySubRegionId").style.display = "none";
				document.getElementById("txtPropertyLocationId").style.display = "none";
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
					var p_city=document.getElementById("txtPropertyAreaId");
					p_city.length=0;
					p_city.options[0]=new Option("All Areas ...","");
					for(var j=0; j<arrayOfId.length; j++) {
						p_city.options[j+1]=new Option(arrayOfNames[j], arrayOfId[j]);
					}
				} else {
					document.getElementById("txtPropertyAreaId").style.display = "none";
				}
			} else {
				document.getElementById("txtPropertyAreaId").style.display = "none";
				document.getElementById("txtPropertyRegionId").style.display = "none";
				document.getElementById("txtPropertySubRegionId").style.display = "none";
				document.getElementById("txtPropertyLocationId").style.display = "none";
			}
		} 
	} 
	
	function handleRegionResponse() { 
		var arrayOfId = new Array();
		var arrayOfNames = new Array();
		if(req.readyState == 4) { 
			var response = req.responseText; 
			xmlDoc=req.responseXML;
			var root = xmlDoc.getElementsByTagName('ntowns')[0];
			if(root != null) {
				document.getElementById("txtPropertyRegionId").style.display = "block";
				document.getElementById("txtPropertySubRegionId").style.display = "none";
				document.getElementById("txtPropertyLocationId").style.display = "none";
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

					var p_city=document.getElementById("txtPropertyRegionId");

					p_city.length=0;
					p_city.options[0]=new Option("All Areas ...","0");
					for(var j=0; j<arrayOfId.length; j++) {
						p_city.options[j+1]=new Option(arrayOfNames[j],arrayOfId[j]);
					}
//					sendSubRegionRequest(1);
				} else {
					document.getElementById("txtPropertyRegionId").style.display = "none";
	//				sendLocationRequest(document.getElementById("txtRegionId").value);
				}
			} else {
				document.getElementById("txtPropertyRegionId").style.display = "none";
				document.getElementById("txtPropertySubRegionId").style.display = "none";
				document.getElementById("txtPropertyLocationId").style.display = "none";
			}
		} 
	} 
	
	function handleSubRegionResponse() { 
		var arrayOfId = new Array();
		var arrayOfNames = new Array();
		if(req.readyState == 4) { 
			var response = req.responseText; 
			xmlDoc=req.responseXML;
			var root = xmlDoc.getElementsByTagName('ntowns')[0];
			if(root != null) {
				document.getElementById("txtPropertySubRegionId").style.display = "block";
				document.getElementById("txtPropertyLocationId").style.display = "none";
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
					var p_city=document.getElementById("txtPropertySubRegionId");
					p_city.length=0;
					p_city.options[0]=new Option("All Areas ...", "0");
					for(var j=0; j<arrayOfId.length; j++) {
						p_city.options[j+1]=new Option(arrayOfNames[j], arrayOfId[j]);
					}

//					sendLocationRequest(9);
				} else {
					document.getElementById("txtPropertySubRegionId").style.display = "none";
					sendLocationRequest(document.getElementById("txtPropertyRegionId").value);
				}
			} else {
				document.getElementById("txtPropertySubRegionId").style.display = "none";
				document.getElementById("txtPropertyLocationId").style.display = "none";
			}
		} 
	} 
	
	function handleLocationResponse(){
		var arrayOfId = new Array();
		var arrayOfNames = new Array();
		if(req.readyState == 4) { 
			var response = req.responseText; 
			xmlDoc=req.responseXML;
			var root = xmlDoc.getElementsByTagName('ntowns')[0];
	//		alert(root);
			if(root != null) {
				document.getElementById("txtPropertyLocationId").style.display = "block";
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

					var p_city=document.getElementById("txtPropertyLocationId");
					p_city.length=0;
					p_city.options[0]=new Option("All Areas ...","0");

					for(var j=0; j<arrayOfId.length; j++) {
						p_city.options[j+1]=new Option(arrayOfNames[j], arrayOfId[j]);
					}

				} else {
					document.getElementById("txtPropertyLocationId").style.display = "none";
				}
			} else {
				document.getElementById("txtPropertyLocationId").style.display = "none";
			}
		} 
	}

	function find_cal(a,ct){
		var url="<?php echo SITE_URL; ?>get_cal.php";

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
		var url="<?php echo SITE_URL; ?>get_cal1.php";

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
		var url="<?php echo SITE_URL; ?>get_cal1.php";
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
		var url="<?php echo SITE_URL; ?>get_cal.php";
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

		if(sid == "From0") {
			fill_to_from_date();
		}
	}

	function fill_to_from_date() {
		if(document.getElementById("txtDayFrom0").value != "" && document.getElementById("txtMonthFrom0").value != "" && document.getElementById("txtYearFrom0").value != "") {
			document.getElementById("txtDayTo0").value = document.getElementById("txtDayFrom0").value;
			document.getElementById("txtMonthTo0").value = document.getElementById("txtMonthFrom0").value;
			document.getElementById("txtYearTo0").value = document.getElementById("txtYearFrom0").value;
		}
	} 

	function close_calendar(){		
		document.getElementById("CalendarDiv").style.display = "none";
	}

	function validate() {
		if(document.getElementById("txtExactNightsId").checked == true) {
			if(document.frmRefinePropDeals.txtDayFrom0.value != "" || document.frmRefinePropDeals.txtMonthFrom0.value != "" || document.frmRefinePropDeals.txtYearFrom0.value != "") {
				if(document.frmRefinePropDeals.txtDayFrom0.value == "") {
					document.getElementById("txtDealErrorMsg").innerHTML = "Please select a start date!";
					document.frmRefinePropDeals.txtDayFrom0.focus();
					return false;
				}
		
				if(document.frmRefinePropDeals.txtMonthFrom0.value == "") {
					document.getElementById("txtDealErrorMsg").innerHTML = "Please select a start date!";
					document.frmRefinePropDeals.txtMonthFrom0.focus();
					return false;
				}
		
				if(document.frmRefinePropDeals.txtYearFrom0.value == "") {
					document.getElementById("txtDealErrorMsg").innerHTML = "Please select a start date!";
					document.frmRefinePropDeals.txtYearFrom0.focus();
					return false;
				}
			}
	
			if(document.frmRefinePropDeals.txtDayTo0.value != "" || document.frmRefinePropDeals.txtMonthTo0.value != "" || document.frmRefinePropDeals.txtYearTo0.value != "") {
				if(document.frmRefinePropDeals.txtDayTo0.value == "") {
					document.getElementById("txtDealErrorMsg").innerHTML = "Please select an end date!";
					document.frmRefinePropDeals.txtDayTo0.focus();
					return false;
				}
		
				if(document.frmRefinePropDeals.txtMonthTo0.value == "") {
					document.getElementById("txtDealErrorMsg").innerHTML = "Please select an end date!";
					document.frmRefinePropDeals.txtMonthFrom0.focus();
					return false;
				}
		
				if(document.frmRefinePropDeals.txtYearTo0.value == "") {
					document.getElementById("txtDealErrorMsg").innerHTML = "Please select an end date!";
					document.frmRefinePropDeals.txtYearFrom0.focus();
					return false;
				}
			}
		
			if(document.frmRefinePropDeals.txtDayFrom0.value != "" && document.frmRefinePropDeals.txtMonthFrom0.value != "" && document.frmRefinePropDeals.txtYearFrom0.value != "" && document.frmRefinePropDeals.txtDayTo0.value != "" && document.frmRefinePropDeals.txtMonthTo0.value != "" && document.frmRefinePropDeals.txtYearTo0.value != "") {
				var fromDate = new Date();
				var toDate = new Date();
				fromDate.setYear(document.frmRefinePropDeals.txtYearFrom0.value);
				fromDate.setMonth(document.frmRefinePropDeals.txtMonthFrom0.value - 1);
				fromDate.setDate(document.frmRefinePropDeals.txtDayFrom0.value);
	
				toDate.setYear(document.frmRefinePropDeals.txtYearTo0.value);
				toDate.setMonth(document.frmRefinePropDeals.txtMonthTo0.value - 1);
				toDate.setDate(document.frmRefinePropDeals.txtDayTo0.value);
	
				if(Date.parse(fromDate) > Date.parse(toDate)) {
					document.getElementById("txtDealErrorMsg").innerHTML = "Please select correct end date!";
					document.frmRefinePropDeals.txtYearTo0.focus();
					return false;
				}
			}
		}
		document.frmRefinePropDeals.submit();
	}	

	function chkDateActive() {
		if(document.getElementById("txtExactNightsId").checked == true) {
			document.getElementById("displaydeactivedateId").style.display = "none";
			document.getElementById("displayactivedateId").style.display = "block";
		} else {
			document.getElementById("displayactivedateId").style.display = "none";
			document.getElementById("displaydeactivedateId").style.display = "block";
		}
	}
	/*
	* For location : End here
	*/
</script>
<link href="<?php echo SITE_CSS_INCLUDES_PATH;?>pop-up-cal.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>newslettersignup.js"></script>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr>
        <td width="100%" valign="top" class="pad-top10 pad-rgt10">
            Save money by booking a late last minute deal. Just select the location you're after and the dates you want to travel and then <strong>show me the deals</strong>. Our owners are adding cheap late deals.
        </td>
    </tr>
    <tr>
        <td align="left" colspan="2" valign="top">
		<?php
			if(isset($propDealsListArr) && count($propDealsListArr) > 0) {
		?>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                <tr>
                    <td align="left" valign="bottom">
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td width="41%" align="left" valign="top" class="pad-btm10 pad-left2"><strong><?php if(isset($pagination['total_rows']) && $pagination['total_rows'] > 1) { echo "Showing ".$pagination['first_row']." to ".$pagination['last_row']." of ".$pagination['total_rows']." properties";} else if(isset($pagination['total_rows']) && $pagination['total_rows'] == 1){echo "Showing ".$pagination['first_row']." to ".$pagination['last_row']." of ".$pagination['total_rows']." property";} ?></strong></td>
                                <td width="59%" align="right" valign="top" class="paging pad-btm10 pad-left2">
                                <?php
                                if(isset($pagination['pages']) && $pagination['pages'] != "") {
                                    if(isset($pagination['prev']) && $pagination['prev'] !="") {
                                        echo "<a href=\"".$pagination['prev']."\" class=\"previous\">Previous</a>";
                                    }
                                    if(($pagination['pages'][0]['no']) > 1) {
                                        echo "<span>...</span>";
                                    }
                                    foreach($pagination['pages'] as $key => $value) {
                                        if(isset($value['link']) && $value['link'] != "") {
                                            echo "<a href=\"".$value['link']."\">".($value['no'])."</a>";
                                        } else {
                                            echo "<span>".($value['no'])."</span>";
                                        }
                                    }
                                    if(($pagination['pages'][count($pagination['pages'])-1]['no']) < ($pagination['total_rows']/GLOBAL_RECORDS_PER_PAGE)) {
                                        echo "<span>...</span>";
                                    }
                                    if(isset($pagination['next']) && $pagination['next'] !="") {
                                        echo "<a href=\"".$pagination['next']."\" class=\"next\">Next</a>";
                                    }
                                } else {
                                    echo "&nbsp;";
                                }
                                ?>
                                </td>
                            </tr>                
                        </table>
                    </td>
                </tr>
                <tr><td valign="top" class="dash25">&nbsp;</td></tr>
                <tr>
                    <td align="left" valign="top" class="pad-top2">
                        <?php
                        for($i =0; $i < count($propDealsListArr); $i++) {
                            $property_id 		= $propDealsListArr[$i]['property_id'];
                            $property_name 		= $propDealsListArr[$i]['property_name'];
                            $property_title 	= $propDealsListArr[$i]['property_title'];
                            $description	 	= ucfirst(substr($propDealsListArr[$i]['property_summary'], 0, 150));
                        
                            $strUnixDateFrom 	= strtotime($propDealsListArr[$i]['start_on']);
                            $strUnixDateTo	 	= strtotime($propDealsListArr[$i]['end_on']);
                            $strUnixDateCur 	= time ();
                            $strNights			= (int)(($strUnixDateTo - $strUnixDateFrom) / (60 * 60 * 24));
                        
                            $currency_code		= $propertyObj->fun_findPropertyCurrencyCode($property_id);
                            $txtCurrencySymbol 	= $propertyObj->fun_findPropertyCurrencySymbol('',$currency_code);
                        
                            $strPricePerNight 	= $txtCurrencySymbol.(number_format($propDealsListArr[$i]['sale_price']));
                            $strOrgPricePerNight= $txtCurrencySymbol.(number_format($propDealsListArr[$i]['original_price']));
                            $strPercentSave 	= round(((($propDealsListArr[$i]['original_price'] - $propDealsListArr[$i]['sale_price']) / $propDealsListArr[$i]['original_price'])*100), 0);
                        
                            $propLocInfoArr 	= $propertyObj->fun_getPropertyLocInfoArr($property_id);
                            $propFavArr     	= $propertyObj->fun_checkFavourite($_SESSION['ses_user_id'],$property_id);
                            
                            $propLoc = "";
                            if($propLocInfoArr['area_name'] !=""){
                                $propLoc .= "<a href=\"property-search-results.php?destinations=".str_replace(" ", "-", strtolower($propLocInfoArr['area_name']))."\">".ucwords($propLocInfoArr['area_name'])."</a> > ";
                            }
                            if($propLocInfoArr['region_name'] !=""){
                                $propLoc .= "<a href=\"property-search-results.php?destinations=".str_replace(" ", "-", strtolower($propLocInfoArr['region_name']))."\">".ucwords($propLocInfoArr['region_name'])."</a> > ";
                            }
                            if($propLocInfoArr['subregion_name'] !=""){
                                $propLoc .= "<a href=\"property-search-results.php?destinations=".str_replace(" ", "-", strtolower($propLocInfoArr['subregion_name']))."\">".ucwords($propLocInfoArr['subregion_name'])."</a> > ";
                            }
                            if($propLocInfoArr['location_name'] !=""){
                                $propLoc .= "<a href=\"property-search-results.php?destinations=".str_replace(" ", "-", strtolower($propLocInfoArr['location_name']))."\">".ucwords($propLocInfoArr['location_name'])."</a> > ";
                            }
                            $propLoc .= ucfirst($property_name)." ref:".fill_zero_left($property_id, "0", (6-strlen($property_id)));
                        
                            $propThumbInfoArr = $propertyObj->fun_getPropertyMainThumb($property_id);
                        
                            if(count($propThumbInfoArr) > 0){
                                if($propThumbInfoArr[0]['photo_thumb'] != "") {
                                    $photo_thumb 	= PROPERTY_IMAGES_THUMB168x126_PATH.$propThumbInfoArr[0]['photo_thumb'];
                                } else {
                                    $photo_thumb 	= PROPERTY_IMAGES_THUMB168x126_PATH."no-image-small.gif";
                                }
                                $photo_caption 		= $propThumbInfoArr[0]['photo_caption'];
                            } else {
                                $photo_thumb 	= PROPERTY_IMAGES_THUMB168x126_PATH."no-image-small.gif";
                                $photo_caption 		= "No Image";
                            }
                          //  print_r( $propThumbInfoArr);
                            $propBedInfoArr 		= $propertyObj->fun_getPropertyBedAllInfoArr($property_id);
                            if(is_array($propBedInfoArr) && (count($propBedInfoArr) > 0)){
                                if($propBedInfoArr[0]['total_beds'] > 0) {
                                    $total_beds 	= $propBedInfoArr[0]['total_beds']." Bedrooms<br>";
                                }
                                if($propBedInfoArr[0]['scomfort_beds'] > 0) {
                                    $scomfort_beds 	= "Sleeps ".$propBedInfoArr[0]['scomfort_beds']."<br>";
                                }
                            } else {
                                $total_beds 	= "";
                                $scomfort_beds 	= "";
                            }
                            
                            $propBathInfoArr 	= $propertyObj->fun_getPropertyBathAllInfoArr($property_id);
                            if(is_array($propBathInfoArr) && (count($propBathInfoArr) > 0) && ($propBathInfoArr[0]['total_bathrooms'] > 0)){
                                $total_bathrooms= $propBathInfoArr[0]['total_bathrooms']." Bathrooms <br>";
                            } else {
                                $total_bathrooms= "";
                            }
                        
                            $propPoolInfo	 	= $propertyObj->fun_verifyPropertyByPropertyFacility($property_id, "15");
                            if($propPoolInfo) {
                                $show_swimming	= "<span>Swimming pool</span>";
                            } else {
                                $show_swimming 	= "";
                            }
                        
                            $propPriceInfoArr	= $propertyObj->fun_getPropertyPriceFromInfoArr($property_id);
                            if(is_array($propPriceInfoArr) && (count($propPriceInfoArr) > 0)){
                                $users_currency_symbol	= $propertyObj->fun_findPropertyCurrencySymbol($property_id);
                                $priceHiddenHTML = "";
                                if($propPriceInfoArr['min_per_night_price'] > 0 && $propPriceInfoArr['max_per_night_price'] > 0 && $propPriceInfoArr['min_per_night_price'] != $propPriceInfoArr['max_per_night_price']) {
                                    $min_per_night_price 		= number_format($propPriceInfoArr['min_per_night_price']);
                                    $max_per_night_price 		= number_format($propPriceInfoArr['max_per_night_price']);
                        //			$show_price 				= "<span id=\"price_currency_symbol_id1".$i."\">".$users_currency_symbol."</span><span id=\"price_currency_price_id1".$i."\" >".$min_per_night_price."</span> - <span id=\"price_currency_symbol_id2".$i."\" >".$users_currency_symbol."</span><span id=\"price_currency_price_id2".$i."\">".$max_per_night_price."</span> p/d<br />";
                                    $show_price 				= "From <span id=\"price_currency_symbol_id1".$i."\">".$users_currency_symbol."</span><span id=\"price_currency_price_id1".$i."\" >".$min_per_night_price."</span> per night<br />";
                                } else if($propPriceInfoArr['min_per_week_price'] > 0 && $propPriceInfoArr['max_per_week_price'] > 0 && $propPriceInfoArr['min_per_week_price'] != $propPriceInfoArr['max_per_week_price']) {
                                    $min_per_week_price 		= number_format($propPriceInfoArr['min_per_week_price']);
                                    $max_per_week_price 		= number_format($propPriceInfoArr['max_per_week_price']);
                        //			$show_price 				= "<span id=\"price_currency_symbol_id1".$i."\">".$users_currency_symbol."</span><span id=\"price_currency_price_id1".$i."\" >".$min_per_week_price."</span> - <span id=\"price_currency_symbol_id2".$i."\" >".$users_currency_symbol."</span><span id=\"price_currency_price_id2".$i."\">".$max_per_week_price."</span> p/w<br />";
                                    $show_price 				= "From <span id=\"price_currency_symbol_id1".$i."\">".$users_currency_symbol."</span><span id=\"price_currency_price_id1".$i."\" >".$min_per_week_price."</span> per week<br />";
                                } else if($propPriceInfoArr['min_per_night_price'] > 0) {
                                    $min_per_night_price 		= number_format($propPriceInfoArr['min_per_night_price']);
                                    $show_price 				= "From <span id=\"price_currency_symbol_id1".$i."\">".$users_currency_symbol."</span><span id=\"price_currency_price_id1".$i."\" >".$min_per_night_price."</span> per night<br />";
                                } else if($propPriceInfoArr['min_per_week_price'] > 0) {
                                    $min_per_week_price 		= number_format($propPriceInfoArr['min_per_week_price']);
                                    $show_price 				= "From <span id=\"price_currency_symbol_id1".$i."\">".$users_currency_symbol."</span><span id=\"price_currency_price_id1".$i."\" >".$min_per_week_price."</span> per week<br />";
                                } else {
                                    $show_price 				= "<br />";
                                }
                                echo $priceHiddenHTML;
                            } else {
                                $show_price 		= "<br />";
                            }

                            $fr_url = $propertyObj->fun_getPropertyFriendlyLink($property_id);
                            if(isset($fr_url) && $fr_url != "") {
                                $property_link 		= SITE_URL."vacation-rentals/".strtolower($fr_url);
                                $contact_owner_link = "<a href=\"".$property_link."#showSectionTop\" class=\"blue-link\">Contact owner</a>";
                                $write_review_link  = "<a href=\"".$property_link."#showSectionTop\" class=\"blue-link\">Write Review</a>";
                            } else {
                                if(isset($propLocInfoArr['location_name']) && $propLocInfoArr['location_name'] != "") {
                                    $property_link = SITE_URL."vacation-rentals/in.".str_replace(" ", "-", strtolower($propLocInfoArr['location_name']))."/".fill_zero_left($property_id, "0", (6-strlen($property_id)));
                                } else {
                                    $property_link = SITE_URL."vacation-rentals/in.".str_replace(" ", "-", strtolower($propLocInfoArr['region_name']))."/".fill_zero_left($property_id, "0", (6-strlen($property_id)));
                                }
                                $contact_owner_link = "<a href=\"".$property_link."#showSectionTop\" class=\"blue-link\">Contact owner</a>";
                                $write_review_link  = "<a href=\"".$property_link."#showSectionTop\" class=\"blue-link\">Write Review</a>";
                            }
                        ?>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listingTable">
                            <tr>
                                <td>
                                    <p class="white"><strong>SPECIAL OFFER!</strong> HOLIDAY WEEKS REDUCED BY <?php echo $strPercentSave."%"; ?> (<?php echo date('M d', $strUnixDateFrom); ?> - <?php echo date('M d', $strUnixDateTo); ?>)</p>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listingTable">
                                        <tr>
                                            <td class="border">
                                                <p class="premium_topic" ><?php echo $property_name;?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="middle">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td width="86%">
                                                           <p class="font12-darkgrey"><strong><?php echo $property_title;?></strong></p>
                                                        </td>
                                                        <td width="14%">
                                                            <?php
                                                                $isFeatured = $propertyObj->fun_isPropertyFeatured($property_id);
                                                                if($isFeatured == true) {
                                                                    echo "<img src=\"".SITE_IMAGES."premium.jpg\" />";
                                                                } else {
                                                                    echo "&nbsp;";
                                                                }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="pad-top12">
                                                    <tr>
                                                        <td width="30%" valign="top"><a href="<?php echo $property_link; ?>" onclick="saveSearch();"><img src="<?php echo $photo_thumb;?>" alt="<?php echo $photo_caption;?>" width="244" height="183" /></td>
                                                        <td width="47%" valign="top" class="pad-lft10 pad-rgt10">
                                                            <div style="height:110px;">
                                                            <p><?php echo $description." ... <a href=\"".$property_link."\" onclick=\"saveSearch();\">read more</a>"; ?></p>
                                                            </div>
                                                            <p style="padding-top:5px;">
                                                                <?php $propertyObj->fun_createPropertyCustomerReview($property_id); ?>
                                                            </p>
                                                            <p>
                                                                <div class="clear" style="width:110px;" align="left"><span style="background-image:url(<?php echo SITE_IMAGES;?>review-bacground.gif); display:block; width:98px; height:38px; line-height:38px; text-align:center;"><?php echo $write_review_link; ?></span></div>
                            
                                                            </p>
                                                        </td>
                                                        <td width="23%" valign="top" class="pad-lft15 pad-top5">
                                                            <table width="100%" border="0" cellspacing="0" cellpadding="1">
                                                                <tr>
                                                                    <td style="line-height:20px;" height="148" valign="top">
                                                                        <?php echo $show_price; ?>
                                                                        <?php echo $total_beds; ?>
                                                                        <?php echo $scomfort_beds; ?>
                                                                        <?php echo $total_bathrooms; ?>
                                                                        <?php echo $show_swimming; ?>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <div class=" pad-rgt10"><a href="<?php echo $property_link; ?>" onclick="saveSearch();"><img src="<?php echo SITE_IMAGES;?>viewdetails.gif" alt="View" /></a></div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <?php
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td align="left" valign="bottom">
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td width="41%" align="left" valign="top" class="pad-btm10 pad-left2"><strong><?php if(isset($pagination['total_rows']) && $pagination['total_rows'] > 1) { echo "Showing ".$pagination['first_row']." to ".$pagination['last_row']." of ".$pagination['total_rows']." properties";} else if(isset($pagination['total_rows']) && $pagination['total_rows'] == 1){echo "Showing ".$pagination['first_row']." to ".$pagination['last_row']." of ".$pagination['total_rows']." property";} ?></strong></td>
                                <td width="59%" align="right" valign="top" class="paging pad-btm10 pad-left2">
                                <?php
                                if(isset($pagination['pages']) && $pagination['pages'] != "") {
                                    if(isset($pagination['prev']) && $pagination['prev'] !="") {
                                        echo "<a href=\"".$pagination['prev']."\" class=\"previous\">Previous</a>";
                                    }
                                    if(($pagination['pages'][0]['no']) > 1) {
                                        echo "<span>...</span>";
                                    }
                                    foreach($pagination['pages'] as $key => $value) {
                                        if(isset($value['link']) && $value['link'] != "") {
                                            echo "<a href=\"".$value['link']."\">".($value['no'])."</a>";
                                        } else {
                                            echo "<span>".($value['no'])."</span>";
                                        }
                                    }
                                    if(($pagination['pages'][count($pagination['pages'])-1]['no']) < ($pagination['total_rows']/GLOBAL_RECORDS_PER_PAGE)) {
                                        echo "<span>...</span>";
                                    }
                                    if(isset($pagination['next']) && $pagination['next'] !="") {
                                        echo "<a href=\"".$pagination['next']."\" class=\"next\">Next</a>";
                                    }
                                } else {
                                    echo "&nbsp;";
                                }
                                ?>
                                </td>
                            </tr>                
                        </table>
                    </td>
                </tr>
            </table>
		<?php			
			} else {
		?>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                <tr>
					<td align="left" valign="bottom" class="pad-top20 pad-lft20"><span class="font16-darkgrey">No late deal available ;-(</span></td>
				</tr>
            </table>
		<?php			
			}
		?>
        </td>
    </tr>
</table>
