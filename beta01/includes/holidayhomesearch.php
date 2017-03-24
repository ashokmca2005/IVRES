<script language="javascript" type="text/javascript">
function accommodationSearch() {
	var txtneedsleep = document.getElementById("txtneedsleep").value;
	//var txttotalbath = document.getElementById("txttotalbath").value;
	var arrivaldate = document.getElementById("txtArrivaldate").value;
	var arrivalDateString = String(arrivaldate);
	var arrivalDateStringBody = arrivalDateString.split("/");
	var departuredate = document.getElementById("txtDeparturedate").value;
	var departureDateString = String(departuredate);
	var departureDateStringBody = departureDateString.split("/");

	if(document.getElementById('SearchLocFld1').value == "Where do you wanna go?" || document.getElementById('SearchLocFld1').value == ""){
		//var url = "vacation-rentals/page_1/txtavailabilityids_1";
		var url = "vacation-rentals/page_1";
	} else {
		var loc = document.getElementById('SearchLocFld1').value;
		loc = loc.toLowerCase();
		loc = str_replace("/", "_", str_replace(" ", "-", loc));
		var url = "vacation-rentals/in."+loc+"/page_1";
	}

	/*
	if(arrivaldate !="" && arrivaldate != "Check-in"){
		url += "/txtDayFrom0_"+arrivalDateStringBody[1]+"/txtMonthFrom0_"+arrivalDateStringBody[0]+"/txtYearFrom0_"+arrivalDateStringBody[2]+"";
	}

	if(departuredate !="" && departuredate != "Check-out"){
		url += "/txtDayTo0_"+departureDateStringBody[1]+"/txtMonthTo0_"+departureDateStringBody[0]+"/txtYearTo0_"+departureDateStringBody[2]+"";
	}
	*/	

	if(arrivaldate !="" && arrivaldate != "Check-in"){
		url += "/txtDateFrom_"+arrivaldate;
	}

	if(departuredate !="" && departuredate != "Check-out"){
		url += "/txtDateTo_"+departuredate;
	}

	if(txtneedsleep !="" && txtneedsleep != "0" && txtneedsleep != "1"){
		url += "/txtneedsleep_"+txtneedsleep+"";
	}
	/*
	if(txttotalbath !="" && txttotalbath != "0"){
		url += "/txttotalbath_"+txttotalbath+"";
	}
	*/
	location.href = url;
}
</script>
<script type="text/javascript">
	$(document).ready(function(){
		$( "#SearchLocFld1" ).autocomplete({
			source: "<?php echo SITE_URL;?>autocompletelocationsearch.php",
			minLength: 2
		});
	});

	$(document).ready(function(){
		$("#txtArrivaldate").datepicker({
			dateFormat: 'yy-mm-dd',
			minDate: 0,
			showOn: "both",
			buttonImage: "images/calendar.gif",
			buttonImageOnly: true
		});
	});
	$(document).ready(function(){
		$("#txtDeparturedate").datepicker({
			dateFormat: 'yy-mm-dd',
			minDate: 0,
			showOn: "both",
			buttonImage: "images/calendar.gif",
			buttonImageOnly: true
		});
	});

	$(document).ready(function(){
		$('#SearchLocFld1').keypress(function(event){
			var keycode = (event.keyCode ? event.keyCode : event.which);
			if(keycode == '13'){
				accommodationSearch();
				//alert('You pressed a "enter" key in textbox');	
			}
			event.stopPropagation();
		});
	});
	/*
	$(document).keypress(function(event){
		var keycode = (event.keyCode ? event.keyCode : event.which);
		if(keycode == '13'){
			alert('You pressed a "enter" key in somewhere');	
		}
		event.stopPropagation();
	});
	*/
</script>
<style>
.ui-datepicker-trigger { position:relative;top:8px ;right:35px ; height:27px }
 /* {} is the value according to your need */
.bed-select {
	height:42px;
	width:135px;
	font-family:Arial, Helvetica, sans-serif;
	font-size:14px;
	font-weight:bold;
	color:#666;
	-moz-broder-radius:5px;
	-webkit-border-radius:5px;
	border-radius:5px;
	background: rgb(255,255,255); /* Old browsers */
	/* IE9 SVG, needs conditional override of 'filter' to 'none' */
	background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI2ZmZmZmZiIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjY1JSIgc3RvcC1jb2xvcj0iI2U2ZTZlNiIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiNlNGU0ZTQiIHN0b3Atb3BhY2l0eT0iMSIvPgogIDwvbGluZWFyR3JhZGllbnQ+CiAgPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);
	background: -moz-linear-gradient(top,  rgba(255,255,255,1) 0%, rgba(230,230,230,1) 65%, rgba(228,228,228,1) 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255,255,255,1)), color-stop(65%,rgba(230,230,230,1)), color-stop(100%,rgba(228,228,228,1))); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top,  rgba(255,255,255,1) 0%,rgba(230,230,230,1) 65%,rgba(228,228,228,1) 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top,  rgba(255,255,255,1) 0%,rgba(230,230,230,1) 65%,rgba(228,228,228,1) 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top,  rgba(255,255,255,1) 0%,rgba(230,230,230,1) 65%,rgba(228,228,228,1) 100%); /* IE10+ */
	background: linear-gradient(to bottom,  rgba(255,255,255,1) 0%,rgba(230,230,230,1) 65%,rgba(228,228,228,1) 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#e4e4e4',GradientType=0 ); /* IE6-8 */
	padding:10px 5px 5px 10px;
	margin-top:2px;
	margin-left:-25px;
}
.bed-select1 {
	height:42px;
	width:135px;
	font-family:Arial, Helvetica, sans-serif;
	font-size:14px;
	font-weight:bold;
	color:#666;
	-moz-broder-radius:5px;
	-webkit-border-radius:5px;
	border-radius:5px;
	background: rgb(255,255,255); /* Old browsers */
	padding:10px 5px 5px 10px;
	margin-top:2px;
	margin-left:-25px;
}
.customSelectInner {
	position: relative;
	width:31px;
	height:27px;
	display: inline-block;
	top:-4px;
	right:35px;
	background:url(images/guest-icon.gif) no-repeat center right;
}
</style>
<h2>Find the perfect vacation rental</h2>
<div id="bx-search-wrap" style="height:45px;display:none;">
<ul>
<li><input name="txtLocSearch" id="SearchLocFld1" class="searchInput" type="text" placeholder="Where do you wanna go?" autocomplete="off" /></li>
<li><input type="text" name="txtArrivaldate" id="txtArrivaldate" class="dateInput" placeholder="Arrival "></li>
<li><input type="text" name="txtDeparturedate" id="txtDeparturedate" class="dateInput" placeholder="Departure " style="margin-left:-25px;"></li>
<li>
<?php echo $propertyObj->fun_createSelectBedField("txtneedsleep", "txtneedsleep", "bed-select", "", "", 2, 15); ?>
<?php /*?>
<select name="txtneedsleep" id="txtneedsleep" class="bed-select"  onchange="" style="height:42px; width:135px;padding:10px 5px 5px 10px;" >
    <option value="1">1 guest </option>
    <option value="2">2 guests</option>
    <option value="3">3 guests</option>
    <option value="4">4 guests</option>
    <option value="5">5 guests</option>
    <option value="6">6 guests</option>
    <option value="7">7 guests</option>
    <option value="8">8 guests</option>
    <option value="9">9 guests</option>
    <option value="10">10 guests</option>
    <option value="11">11 guests</option>
    <option value="12">12 guests</option>
    <option value="13">13 guests</option>
    <option value="14">14 guests</option>
    <option value="15">15 guests</option>
</select>
<?php */?>
<span class="customSelectInner">&nbsp;</span></li>
<li><a href="javascript:void(0);" onclick="accommodationSearch();" class="searchButton" style="text-decoration:none;"><img src="images/lense-icon.gif" width="25" height="25" border="0" /><div style="margin-left:10px; color:#FFFFFF; display:inline;">Search</div></a></li>
</ul>
<div class="clearfix">&nbsp;</div>
</div>