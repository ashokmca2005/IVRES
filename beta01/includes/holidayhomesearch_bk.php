<script language="javascript" type="text/javascript">
function accommodationSearch() {
	var txttotalbed = document.getElementById("txttotalbed").value;
	//var txttotalbath = document.getElementById("txttotalbath").value;
	var arrivaldate = document.getElementById("txtArrivaldate").value;
	var arrivalDateString = String(arrivaldate);
	var arrivalDateStringBody = arrivalDateString.split("/");
	var departuredate = document.getElementById("txtDeparturedate").value;
	var departureDateString = String(departuredate);
	var departureDateStringBody = departureDateString.split("/");

	if(document.getElementById('SearchLocFld1').value == "Location in London" || document.getElementById('SearchLocFld1').value == ""){
		//var url = "houseboat/page_1/txtavailabilityids_1";
		var url = "houseboat/page_1";
	} else {
		var loc = document.getElementById('SearchLocFld1').value;
		loc = loc.toLowerCase();
		loc = str_replace("/", "_", str_replace(" ", "-", loc));
		var url = "houseboat/in."+loc+"/page_1";
	}

	if(arrivaldate !="" && arrivaldate != "Check-in"){
		url += "/txtDayFrom0_"+arrivalDateStringBody[1]+"/txtMonthFrom0_"+arrivalDateStringBody[0]+"/txtYearFrom0_"+arrivalDateStringBody[2]+"";
	}

	if(departuredate !="" && departuredate != "Check-out"){
		url += "/txtDayTo0_"+departureDateStringBody[1]+"/txtMonthTo0_"+departureDateStringBody[0]+"/txtYearTo0_"+departureDateStringBody[2]+"";
	}
	
	if(txttotalbed !="" && txttotalbed != "0"){
		url += "/txttotalbed_"+txttotalbed+"";
	} else if (txttotalbed !="" && txttotalbed == "0") {
		url += "/complex_unit_type_11";
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
		$("#txtArrivaldate").datepicker();
	});
	$(document).ready(function(){
		$("#txtDeparturedate").datepicker();
	});
</script>
<!-- holiday maker home search : start here -->
<input name="txtLocSearch" id="SearchLocFld1" class="searchInput" type="text" placeholder="Location in London" autocomplete="off" />
<div class="searchButton"><a href="javascript:void(0);" onclick="accommodationSearch();">Search</a></div>
<div class="clearfix"></div>
<div class="datesSections" style="margin-left:203px;">
    <label>Check in</label>
    <div class="date-from">
        <input type="text" name="txtArrivaldate" class="checkinput" id="txtArrivaldate" placeholder="Arrival" style="background-image: url(images/calander.gif);background-repeat:no-repeat;background-position: 70px ;">
    </div>
</div>
<div class="datesSections" style="margin-left:-40px;">
    <label style="padding-left:40px;">Check out</label>
    <div class="date-to" style="margin-left:40px;">
        <input type="text" name="txtDeparturedate" class="checkinput"  id="txtDeparturedate" placeholder="Departure" style="background-image: url(images/calander.gif);background-repeat:no-repeat;background-position: 70px ;">
    </div>
</div>
<div class="datesSections" style="margin-left:40px;">
    <label style="margin-left:-25px;">Bedroom</label>
    <div class="font14">
		<?php $propertyObj->fun_createSelectBedField("txttotalbed", "txttotalbed", "bed-select", "", "", 2, 5); ?>
    </div>
</div>
<?php /*?>
<div class="datesSections" style="margin-left:10px;">
    <label>Bathroom</label>
    <div class="font14">
		<?php $propertyObj->fun_createSelectNumField("txttotalbath", "txttotalbath", "dates-select", "", "", 1, 10); ?>
    </div>
</div>
<?php */?>

<div class="clearfix"></div>
<?php /*?>
<div class="ie-pad-top25" style="clear:both;">
    <div class="searchSec" style="margin-top:-18px;">
        <label>Start Date :</label>
        <div class="font14" >
            <input type="text" name="txtArrivaldate" id="txtArrivaldate" placeholder="Check-in" class="txtBox75">
        </div>
    </div>
    <div class="searchSec" style="margin-left:15px; margin-top:-18px;">
        <label>End Date :</label>
        <div class="font14" >
            <input type="text" name="txtDeparturedate" id="txtDeparturedate" placeholder="Check-out" class="txtBox75">
        </div>
    </div>
    <div class="searchSec" style="margin-left:15px; margin-top:-18px;">
        <label>Bedroom :</label>
        <div class="font14" >
            <?php $propertyObj->fun_createSelectNumField("txttotalbed", "txttotalbed", "select70", "", "", 1, 10); ?>
        </div>
    </div>
    <div class="searchSec" style="margin-left:15px; margin-top:-18px;">
        <label>Bathroom :</label>
        <div class="font14" >
            <?php $propertyObj->fun_createSelectNumField("txttotalbath", "txttotalbath", "select70", "", "", 1, 10); ?>
        </div>
    </div>
</div>
<div class="pad-top10" style="clear:both;"> </div>
<div class="datesSections">
    <label>Check in</label>
    <div class="date-from">
        <input type="text" name="txtArrivaldate" id="txtArrivaldate" placeholder="mm/dd/yyyy">
    </div>
</div>
<div class="datesSections" style="margin-left:23px;">
    <label>Check out</label>
    <div class="date-to">
        <input type="text" name="txtDeparturedate" id="txtDeparturedate" placeholder="mm/dd/yyyy">
    </div>
</div>
<div class="datesSections1">
    <label>Guest</label>
    <select class="dates-select" style="position:relative; top:7px; margin-left:-5px;">
        <option>1</option>
        <option>2</option>
        <option>3</option>
    </select>
</div>
<?php */?>
<!-- holiday maker home search : End here -->
