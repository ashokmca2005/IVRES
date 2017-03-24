<?php 
$dayname 	= array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');
$monthname 	= array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec');
$yearname 	= array(date('Y')+0,date('Y')+1,date('Y')+2,date('Y')+3);
$stayname 	= array('01','02','03','04','05','06','07','08','09','10','11','12','13','14');
?>
<script language="javascript">
	var req = ajaxFunction();
	var x1 = "";
	var y1 = "";

	function find_cal(a,ct){
		var url="<?php echo SITE_URL; ?>get_cal.php";
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
		var url="<?php echo SITE_URL; ?>get_cal1.php";
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
	}

	function close_calendar(){		
		document.getElementById("CalendarDiv").style.display = "none";
	}
	/*
	* For location refine : Start Here
	*/
/*
	function chkSelectCountry() {
		var getID=document.getElementById("txtcountryid").value;
		if(getID !="" && getID != "0"){
			sendAreaRequest(getID);
		}
		if(getID == "0" || getID =="") {
			document.getElementById("txtareaid").value = "";
			document.getElementById("txtregionid").value = "";
			document.getElementById("txtsubregionid").value = "";
			document.getElementById("txtlocationid").value = "";
		}
	}
*/
	
	function chkSelectArea() {
		var getID=document.getElementById("txtareaid").value;
		if(getID !="" && getID != "0"){
			sendRegionRequest(getID);
			document.getElementById("txtregionid").value = "0";
			document.getElementById("txtsubregionid").value = "0";
			document.getElementById("txtlocationid").value = "0";
		}
		if(getID == "0" || getID =="") {
			document.getElementById("txtareaid").value = "0";
			document.getElementById("txtregionid").value = "0";
			document.getElementById("txtsubregionid").value = "0";
			document.getElementById("txtlocationid").value = "0";
			document.getElementById("txtsubregionid").style.display = "none";
			document.getElementById("txtlocationid").style.display = "none";
		}
	}

	function chkSelectRegion() {
		var getID=document.getElementById("txtregionid").value;
		if(getID !="" && getID != "0"){
			sendSubRegionRequest(getID);
			document.getElementById("txtsubregionid").value = "0";
			document.getElementById("txtlocationid").value = "0";

			var txtDestination = document.getElementById('txtregionid')[document.getElementById('txtregionid').selectedIndex].innerHTML;
			txtDestination = txtDestination.toLowerCase();
			txtDestination = str_replace(" ", "-", txtDestination);
			document.frmEventSearch.action = "<?php echo SITE_URL; ?>events/in."+txtDestination;
		}
		if(getID == "0" || getID =="") {
			document.getElementById("txtregionid").value = "0";
			document.getElementById("txtsubregionid").value = "0";
			document.getElementById("txtlocationid").value = "0";
			document.getElementById("txtsubregionid").style.display = "none";
			document.getElementById("txtlocationid").style.display = "none";

			var txtDestination = document.getElementById('txtareaid')[document.getElementById('txtareaid').selectedIndex].innerHTML;
			txtDestination = txtDestination.toLowerCase();
			txtDestination = str_replace(" ", "-", txtDestination);
			document.frmEventSearch.action = "<?php echo SITE_URL; ?>events/in."+txtDestination;
		}
	}
	
	function chkSelectSubRegion() {
		var getID=document.getElementById("txtsubregionid").value;
		if(getID !="" && getID != "0"){
			sendLocationRequest(getID);
			document.getElementById("txtlocationid").value = "0";

			var txtDestination = document.getElementById('txtsubregionid')[document.getElementById('txtsubregionid').selectedIndex].innerHTML;
			txtDestination = txtDestination.toLowerCase();
			txtDestination = str_replace(" ", "-", txtDestination);
			document.frmEventSearch.action = "<?php echo SITE_URL; ?>events/in."+txtDestination;
		}
		if(getID == "0" || getID =="") {
			document.getElementById("txtsubregionid").value = "0";
			document.getElementById("txtlocationid").value = "0";
			document.getElementById("txtlocationid").style.display = "none";
		}
	}

	function chkSelectLocation() {
		var getID=document.getElementById("txtlocationid").value;
		if(getID !="" && getID != "0"){
			var txtDestination = document.getElementById('txtlocationid')[document.getElementById('txtlocationid').selectedIndex].innerHTML;
			txtDestination = txtDestination.toLowerCase();
			txtDestination = str_replace(" ", "-", txtDestination);
			document.frmEventSearch.action = "<?php echo SITE_URL; ?>events/in."+txtDestination;
		}
		if(getID == "0" || getID =="") {
			document.getElementById("txtlocationid").value = "0";
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
				document.getElementById("txtareaid").style.display = "block";
				document.getElementById("txtregionid").style.display = "none";
				document.getElementById("txtsubregionid").style.display = "none";
				document.getElementById("txtlocationid").style.display = "none";
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
					var p_city=document.getElementById("txtareaid");
					p_city.length=0;
					p_city.options[0]=new Option("Please Select...","");
					for(var j=0; j<arrayOfId.length; j++) {
						p_city.options[j+1]=new Option(arrayOfNames[j], arrayOfId[j]);
					}
				} else {
					document.getElementById("txtareaid").style.display = "none";
				}
			} else {
				document.getElementById("txtareaid").style.display = "none";
				document.getElementById("txtregionid").style.display = "none";
				document.getElementById("txtsubregionid").style.display = "none";
				document.getElementById("txtlocationid").style.display = "none";
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
				document.getElementById("txtregionid").style.display = "block";
				document.getElementById("txtsubregionid").style.display = "none";
				document.getElementById("txtlocationid").style.display = "none";
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
//					var strParent = document.getElementById('txtareaid')[document.getElementById('txtareaid').selectedIndex].innerHTML;

					var p_city=document.getElementById("txtregionid");
					p_city.length=0;
					p_city.options[0]=new Option("All Areas ...","0");
					for(var j=0; j<arrayOfId.length; j++) {
						p_city.options[j+1]=new Option(arrayOfNames[j],arrayOfId[j]);
					}
//					sendSubRegionRequest(1);
				} else {
					document.getElementById("txtregionid").style.display = "none";
	//				sendLocationRequest(document.getElementById("txtregionid").value);
				}
			} else {
				document.getElementById("txtregionid").style.display = "none";
				document.getElementById("txtsubregionid").style.display = "none";
				document.getElementById("txtlocationid").style.display = "none";
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
				document.getElementById("txtsubregionid").style.display = "block";
				document.getElementById("txtlocationid").style.display = "none";
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
/*
					if(document.getElementById("txtregionid").style.display == "block") {
						var strParent = document.getElementById('txtregionid')[document.getElementById('txtregionid').selectedIndex].innerHTML;
					} else {
						var strParent = document.getElementById('txtareaid')[document.getElementById('txtareaid').selectedIndex].innerHTML;
					}
*/
					var p_city=document.getElementById("txtsubregionid");
					p_city.length=0;
					p_city.options[0]=new Option("All Areas ...", "0");
					for(var j=0; j<arrayOfId.length; j++) {
						p_city.options[j+1]=new Option(arrayOfNames[j], arrayOfId[j]);
					}

//					sendLocationRequest(9);
				} else {
					document.getElementById("txtsubregionid").style.display = "none";
					sendLocationRequest(document.getElementById("txtregionid").value);
				}
			} else {
				document.getElementById("txtsubregionid").style.display = "none";
				document.getElementById("txtlocationid").style.display = "none";
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
				document.getElementById("txtlocationid").style.display = "block";
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

/*
					if(document.getElementById("txtsubregionid").style.display == "block") {
						var strParent = document.getElementById('txtsubregionid')[document.getElementById('txtsubregionid').selectedIndex].innerHTML;
					} else {
						var strParent = document.getElementById('txtregionid')[document.getElementById('txtregionid').selectedIndex].innerHTML;
					}
*/
					var p_city=document.getElementById("txtlocationid");
					p_city.length=0;
					p_city.options[0]=new Option("All Areas ...","0");

					for(var j=0; j<arrayOfId.length; j++) {
						p_city.options[j+1]=new Option(arrayOfNames[j], arrayOfId[j]);
					}

				} else {
					document.getElementById("txtlocationid").style.display = "none";
				}
			} else {
				document.getElementById("txtlocationid").style.display = "none";
			}
		} 
	}
	/*
	* For location refine : End Here
	*/
	
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
			alert(document.getElementById("txtAddEventSubRegionId").value);
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
		req.open('get', '<?php echo SITE_URL;?>selectAreaXml.php?id=' + id); 
		req.onreadystatechange = handleAreaResponse4AddEvent; 
		req.send(null); 
	} 
	
	function sendRegionRequest4AddEvent(id) { 
		req.open('get', '<?php echo SITE_URL;?>selectRegionXml.php?id=' + id); 
		req.onreadystatechange = handleRegionResponse4AddEvent; 
		req.send(null); 
	} 
	
	function sendSubRegionRequest4AddEvent(id) { 
		req.open('get', '<?php echo SITE_URL;?>selectSubRegionXml.php?id=' + id); 
		req.onreadystatechange = handleSubRegionResponse4AddEvent; 
		req.send(null); 
	} 
	
	function sendLocationRequest4AddEvent(id) { 
		req.open('get', '<?php echo SITE_URL;?>selectLocationXml.php?id=' + id); 
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
//					var strParent = document.getElementById('txtAddEventAreaId')[document.getElementById('txtAddEventAreaId').selectedIndex].innerHTML;

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
/*
					if(document.getElementById("txtAddEventRegionId").style.display == "block") {
						var strParent = document.getElementById('txtAddEventRegionId')[document.getElementById('txtAddEventRegionId').selectedIndex].innerHTML;
					} else {
						var strParent = document.getElementById('txtAddEventAreaId')[document.getElementById('txtAddEventAreaId').selectedIndex].innerHTML;
					}
*/
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

/*
					if(document.getElementById("txtAddEventSubRegionId").style.display == "block") {
						var strParent = document.getElementById('txtAddEventSubRegionId')[document.getElementById('txtAddEventSubRegionId').selectedIndex].innerHTML;
					} else {
						var strParent = document.getElementById('txtAddEventRegionId')[document.getElementById('txtAddEventRegionId').selectedIndex].innerHTML;
					}
*/
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
/*
* For Add event section : Start here
*/

	function refineEventListByCat(strCat) {
		document.getElementById("txtEventCategoryId").value = strCat;
		document.frmEventSearch.submit();
	}

	function frmValidate(){ 
	
	}
</script>

<link href="<?php echo SITE_CSS_INCLUDES_PATH;?>pop-up-cal.css" rel="stylesheet" type="text/css" />
<form name="frmEventSearch" id="frmEventSearch" action="<?php echo $seo_friendly; ?>" method="post">
<input type="hidden" name="securityKey" value="<?php echo md5("EVENTSEARCH")?>">
<table border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr>
        <td align="left">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr><td class="pad-rgt15 pad-top3"><span class="pink18"><?php echo tranText('find_whats_on'); ?>...</span></td></tr>
                <tr>
                    <td class="pad-top10">
                        <table border="0" cellpadding="1" cellspacing="0">
                            <tr><td colspan="4" class="pad-btm5"><?php echo tranText('starting_from'); ?></td></tr>
                            <tr>
                                <td>
                                    <select name="txtDayFrom0" id="txtDayFrom0" class="PricesDate">
                                        <option value=""> - - </option>
                                        <?
										foreach($dayname as $key => $value) {
										?>
											<option value="<?php echo $value;?>" <? if(isset($txtDayFrom0) && ($value == $txtDayFrom0)){echo "selected";} else{echo "";}?>><?php echo ($key+1)?></option>
											<?
										}
										?>
                                    </select>
                                </td>
                                <td>
                                    <select name="txtMonthFrom0" id="txtMonthFrom0" class="select75">
                                        <option value=""> - - </option>
                                        <?
										foreach ($monthname as $key => $value) {
										?>
											<option value="<?php echo $key?>" <? if(isset($txtMonthFrom0) && ($key==$txtMonthFrom0)){echo "selected";} else{echo "";}?>><?php echo $value;?></option>
											<?
										}
										?>
                                    </select>
                                </td>
                                <td align="right">
                                    <select name="txtYearFrom0" id="txtYearFrom0" class="PricesDate" style="width:55px;">
                                        <option value=""> - - </option>
                                        <?
										foreach ($yearname as $value) {
										?>
											<option value="<?php echo $value;?>" <? if(isset($txtYearFrom0) && ($value==$txtYearFrom0)){echo "selected";} else{echo "";}?>><?php echo $value;?></option>
											<?
										}
										?>
                                    </select>
                                </td>
                                <td align="right"><a href="JavaScript:find_cal(<?php echo time()?>,'From0');"><img src="<?php echo SITE_IMAGES;?>calender.gif" alt="calendar" /></a></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="pad-top10 pad-btm5"><?php echo tranText('and_ending'); ?>...</td>
                            </tr>
                            <tr>
                                <td>
                                    <select name="txtDayTo0" id="txtDayTo0" class="PricesDate">
                                        <option value=""> - - </option>
                                        <?
                                        foreach($dayname as $key => $value) {
                                        ?>
                                        <option value="<?php echo $value;?>" <? if(isset($txtDayTo0) && ($value==$txtDayTo0)){echo "selected";} else{echo "";}?>><?php echo ($key+1)?></option>
                                        <?
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <select name="txtMonthTo0" id="txtMonthTo0" class="select75">
                                        <option value=""> - - </option>
                                        <?
                                        foreach ($monthname as $key => $value) {
                                        ?>
                                        <option value="<?php echo $key?>" <? if(isset($txtMonthTo0) && ($key==$txtMonthTo0)){echo "selected";} else{echo "";}?>><?php echo $value;?></option>
                                        <?
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td align="right">
                                    <select name="txtYearTo0" id="txtYearTo0" class="PricesDate" style="width:55px;">
                                        <option value=""> - - </option>
                                        <?
                                        foreach ($yearname as $value) {
                                        ?>
                                        <option value="<?php echo $value;?>" <? if(isset($txtYearTo0) && ($value==$txtYearTo0)){echo "selected";} else{echo "";}?>><?php echo $value;?></option>
                                        <?
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td align="right"><a href="JavaScript:find_cal(<?php echo time()?>,'To0');"><img src="<?php echo SITE_IMAGES;?>calender.gif" alt="calendar" /></a></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td  class="dash25"></td>
                </tr>
                <tr>
                    <td>
                        <!-- Event Category Selection : Start here -->
                        <table border="0" cellpadding="2" cellspacing="0">
                            <tr>
                                <td class="pad-btm5"><?php echo tranText('select_a_category'); ?></td>
                            </tr>
                            <tr>
                                <td>
                                    <select name="txtEventCategory" class="select175" id="txtEventCategoryId" style="display:block;">
                                        <option value="0">All events</option>
                                        <?php echo $eventObj->fun_getEventCategoryTypeOptionsList($txtEventCategory); ?>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <!-- Event Category Selection : Start here -->
                    </td>
                </tr>
                <tr>
                    <td  class="dash25"></td>
                </tr>
                <tr>
                    <td>
                        <table border="0" cellpadding="2" cellspacing="0">
                            <tr>
                                <td class="pad-btm5"><?php echo tranText('select_a_location'); ?></td>
                            </tr>
                            <tr>
                                <!-- Location : Start here -->
                                <td>
                                    <div id="showtxtlocationcombo">
                                        <?php
									if(($txtareaid > 0) && ($txtregionid > 0) && ($txtsubregionid > 0) && ($txtlocationid > 0)) { // all available
										?>
                                        <select name="txtareaid" id="txtareaid" onchange="return chkSelectArea();" style="display:block;" class="select175">
                                            <?php $locationObj->fun_getAreaListOptions($txtareaid, ''); ?>
                                        </select>
                                        <select name="txtregionid" id="txtregionid" onchange="return chkSelectRegion();" style="display:block;" class="select175">
                                            <option value="0">All Areas ...</option>
                                            <?php $locationObj->fun_getRegionListOptions($txtregionid, '0', $txtareaid);?>
                                        </select>
                                        <select name="txtsubregionid" id="txtsubregionid" onchange="return chkSelectSubRegion();" style="display:block;" class="select175">
                                            <option value="0">All Areas ...</option>
                                            <?php $locationObj->fun_getRegionListOptions($txtsubregionid, $txtregionid, $txtareaid);?>
                                        </select>
                                        <select name="txtlocationid" id="txtlocationid" onchange="return chkSelectLocation();" style="display:block;"  class="select175">
                                            <option value="0">All Areas ...</option>
                                            <?php $locationObj->fun_getLocationListOptions($txtlocationid, $txtsubregionid);?>
                                        </select>
                                        <?php
									} else if(($txtareaid > 0) && !($txtregionid > 0) && ($txtsubregionid > 0) && !($txtlocationid > 0)) { //not region, but all
										?>
                                        <select name="txtareaid" id="txtareaid" onchange="return chkSelectArea();" style="display:block;" class="select175">
                                            <?php $locationObj->fun_getAreaListOptions($txtareaid, ''); ?>
                                        </select>
                                        <select name="txtregionid" id="txtregionid" onchange="return chkSelectRegion();" style="display:none;" class="select175">
                                            <option value="0">All Areas ...</option>
                                        </select>
                                        <select name="txtsubregionid" id="txtsubregionid" onchange="return chkSelectSubRegion();" style="display:block;" class="select175">
                                            <option value="0">All Areas ...</option>
                                            <?php $locationObj->fun_getRegionListOptions($txtsubregionid, '0', $txtareaid);?>
                                        </select>
                                        <select name="txtlocationid" id="txtlocationid" onchange="return chkSelectLocation();" style="display:block;"  class="select175">
                                            <option value="0">All Areas ...</option>
                                            <?php $locationObj->fun_getLocationListOptions('', $txtsubregionid);?>
                                        </select>
                                        <?php
									} else if(($txtareaid > 0) && ($txtregionid > 0) && !($txtsubregionid > 0) && !($txtlocationid > 0)) { //not location && region, but all
										?>
                                        <select name="txtareaid" id="txtareaid" onchange="return chkSelectArea();" style="display:block;" class="select175">
                                            <?php $locationObj->fun_getAreaListOptions($txtareaid, ''); ?>
                                        </select>
                                        <select name="txtregionid" id="txtregionid" onchange="return chkSelectRegion();" style="display:block;" class="select175">
                                            <option value="0">All Areas ...</option>
                                            <?php $locationObj->fun_getRegionListOptions($txtregionid, '0', $txtareaid);?>
                                        </select>
                                        <select name="txtsubregionid" id="txtsubregionid" onchange="return chkSelectSubRegion();" style="display:<?php if($locationObj->fun_countSubRegionByRegionid($txtregionid) == 0){ echo "none";} else {echo "block";} ?>;" class="select175">
                                            <option value="0">All Areas ...</option>
                                            <?php $locationObj->fun_getRegionListOptions('0', $txtregionid, $txtareaid);?>
                                        </select>
                                        <select name="txtlocationid" id="txtlocationid" onchange="return chkSelectLocation();" style="display:<?php if($locationObj->fun_countSubRegionByRegionid($txtregionid) == 0){ echo "block";} else {echo "none";} ?>;"  class="select175">
                                            <option value="0">All Areas ...</option>
                                            <?php $locationObj->fun_getLocationListOptions('', $txtregionid);?>
                                        </select>
                                        <?php
									} else if(($txtareaid > 0) && ($txtregionid > 0) && ($txtsubregionid > 0) && !($txtlocationid > 0)) { //not location, but 
										?>
                                        <select name="txtareaid" id="txtareaid" onchange="return chkSelectArea();" style="display:block;" class="select175">
                                            <?php $locationObj->fun_getAreaListOptions($txtareaid, ''); ?>
                                        </select>
                                        <select name="txtregionid" id="txtregionid" onchange="return chkSelectRegion();" style="display:block;" class="select175">
                                            <option value="0">All Areas ...</option>
                                            <?php $locationObj->fun_getRegionListOptions($txtregionid, '0', $txtareaid);?>
                                        </select>
                                        <select name="txtsubregionid" id="txtsubregionid" onchange="return chkSelectSubRegion();" style="display:block;" class="select175">
                                            <option value="0">All Areas ...</option>
                                            <?php $locationObj->fun_getRegionListOptions($txtsubregionid, $txtregionid, $txtareaid);?>
                                        </select>
                                        <select name="txtlocationid" id="txtlocationid" onchange="return chkSelectLocation();" style="display:block;"  class="select175">
                                            <option value="0">All Areas ...</option>
                                            <?php $locationObj->fun_getLocationListOptions('', $txtsubregionid);?>
                                        </select>
                                        <?php
									} else if(($txtareaid > 0) && ($txtregionid > 0) && !($txtsubregionid > 0) && ($txtlocationid > 0)) { //not location && region, but all
										?>
                                        <select name="txtareaid" id="txtareaid" onchange="return chkSelectArea();" style="display:block;" class="select175">
                                            <?php $locationObj->fun_getAreaListOptions($txtareaid, ''); ?>
                                        </select>
                                        <select name="txtregionid" id="txtregionid" onchange="return chkSelectRegion();" style="display:block;" class="select175">
                                            <option value="0">All Areas ...</option>
                                            <?php $locationObj->fun_getRegionListOptions($txtregionid, '0', $txtareaid);?>
                                        </select>
                                        <select name="txtsubregionid" id="txtsubregionid" onchange="return chkSelectSubRegion();" style="display:<?php if($locationObj->fun_countSubRegionByRegionid($txtregionid) == 0){ echo "none";} else {echo "block";} ?>;" class="select175">
                                            <option value="0">All Areas ...</option>
                                            <?php $locationObj->fun_getRegionListOptions('0', $txtregionid, $txtareaid);?>
                                        </select>
                                        <select name="txtlocationid" id="txtlocationid" onchange="return chkSelectLocation();" style="display:<?php if($locationObj->fun_countSubRegionByRegionid($txtregionid) == 0){ echo "block";} else {echo "none";} ?>;"  class="select175">
                                            <option value="0">All Areas ...</option>
                                            <?php $locationObj->fun_getLocationListOptions($txtlocationid, $txtregionid);?>
                                        </select>
                                        <?php
									} else {
										?>
                                        <select name="txtareaid" id="txtareaid" onchange="return chkSelectArea();" style="display:block;" class="select175">
                                            <?php $locationObj->fun_getAreaListOptions('', ''); ?>
                                        </select>
                                        <select name="txtregionid" id="txtregionid" onchange="return chkSelectRegion();" style="display:block;" class="select175">
                                            <option value="0">All Areas ...</option>
                                            <?php $locationObj->fun_getRegionListOptions('', '0', '');?>
                                        </select>
                                        <select name="txtsubregionid" id="txtsubregionid" onchange="return chkSelectSubRegion();" style="display:none;" class="select175">
                                            <option value="0">All Areas ...</option>
                                        </select>
                                        <select name="txtlocationid" id="txtlocationid" onchange="return chkSelectLocation();" style="display:none;"  class="select175">
                                            <option value="0">All Areas ...</option>
                                        </select>
                                        <?php
									}
									?>
                                    </div>
                                </td>
                                <!-- Location : End here -->
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr><td height="10"></td></tr>
                <tr><td><input type="button" alt="Search" class="button85x30-sign-in" value="Search" onclick="frmValidate();" /></td></tr>
                <tr><td height="10"></td></tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="center">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr><td height="10"></td></tr>
                <tr>
                    <td>
                        <div class="addListing1 clearfix">
                            <div class="addListing2">
                                <table width="100%" border="0" cellpadding="2" cellspacing="0">
                                    <tr>
                                        <td align="left" valign="top" class="pad-btm3">
                                            <div class="gray18Arial"><?php echo tranText('add_an_excursion_or_tourist_attraction'); ?><br />for <span class="pink18"><strong><?php echo tranText('free'); ?></strong></span></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="top" class="blue14 "> <a href="<?php echo SITE_URL; ?>holiday-events-add.php" class="blue-link"><?php echo tranText('add_an_excursion_or_tourist_attraction'); ?></a> </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="addListing1 clearfix">
                            <div class="addListing2">
                                <table width="100%" border="0" cellpadding="2" cellspacing="0">
                                    <tr>
                                        <td align="left" valign="top" class="pad-btm3 gray18Arial">
											<?php echo tranText('search_for'); ?><br />
                                            <?php echo tranText('accommodation'); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="top" class="blue14 "><a href="<?php echo SITE_URL; ?>accommodation" class="blue-link">Search accommodation</a></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <div class="addListing">
                            <table width="100%" border="0" cellpadding="2" cellspacing="0">
                                <tr>
                                    <td colspan="2" align="left" valign="top">
                                        <div style="position:relative; top:0px; left:0px;">
                                            <div style="position:absolute; z-index:9; top:20px; left:90px;"><img src="<?php echo SITE_IMAGES;?>free-icon-pink.png" alt="Free" /></div>
                                        </div>
                                        <h2><?php echo tranText('add_your_holiday_home_for_free'); ?></h2>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="left" valign="top" class="pad-btm3">
                                        <ul>
                                            <li><p><?php echo tranText('complete_control'); ?></p></li>
                                            <li><p>12 <?php echo tranText('supersized_images'); ?></p></li>
                                            <li><p><?php echo tranText('online_availability_calendar'); ?></p></li>
                                            <li><p><?php echo tranText('customer_reviews'); ?></p></li>
                                            <li><p><?php echo tranText('direct_contact_with_holidaymakers'); ?></p></li>
                                        </ul>
                                    </td>
                                </tr>
                            </table>
                            <p style="padding-top:15px; text-align:left; padding-left:20px;">
                            <a href="<?php echo SITE_URL; ?>advertise" style="text-decoration:none;"><div class="button85x30-read-more">Read More</div></a>
                            </p>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</form>
