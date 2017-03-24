<script language="javascript">
	var req = ajaxFunction();
	var x1 = "";
	var y1 = "";

	function refineaccommodation() {
		var t = setTimeout("Post1.Send(document.getElementById('frmRefineSearch'))", 1000);
	}

	function editHidden(strFieldId, strFieldValue){ 
		document.getElementById(strFieldId).value = strFieldValue;
	}

	function addMutualAccomTxt(txtId, txtTxt, strFieldId, strFieldValue) {
		var txtdiv = "<div id=\"div"+txtId+"\" style=\"clear:both; padding-top:3px;display:block;\"><a href=\"Javascript:delMutualAccomTxt('"+txtId+"', '"+strFieldId+"');Post.Send(document.getElementById('frmRefineSearch'));refineaccommodation();void(0);\" onMouseover=\"return hidestatus()\" class=\"blue-link\" style=\"text-decoration:none;\"><span class=\"blackText\">"+txtTxt+"</span>&nbsp;<strong>(x)</strong></a></div>";
		document.getElementById(strFieldId).value = strFieldValue;
		document.getElementById('shwAddedAccomTr').style.display = "block";
		document.getElementById('shwAddedAccom').style.display = "block";
		document.getElementById('shwAddedAccom').innerHTML += txtdiv;
	}

	function addNonMutualAccomTxt(txtId, txtFullItemId, txtTxt, strFieldId, strFieldValue) {
		var txtdiv = "<div id=\"div"+txtId+strFieldValue+"\" style=\"clear:both; padding-top:3px;display:block;\"><a href=\"Javascript:delNonMutualAccomTxt('"+txtId+"', '"+txtFullItemId+"', '"+strFieldId+"',  '"+strFieldValue+"');Post.Send(document.getElementById('frmRefineSearch'));refineaccommodation();void(0);\" onMouseover=\"return hidestatus()\" class=\"blue-link\" style=\"text-decoration:none;\"><span class=\"blackText\">"+txtTxt+"</span>&nbsp;<strong>(x)</strong></a></div>";
		var txtIds = document.getElementById(strFieldId).value;
		if(txtIds != "") {
			document.getElementById(strFieldId).value = txtIds+"-"+strFieldValue;
		} else {
			document.getElementById(strFieldId).value = strFieldValue;
		}

		document.getElementById('shwAddedAccomTr').style.display = "block";
		document.getElementById('shwAddedAccom').style.display = "block";
		document.getElementById('shwAddedAccom').innerHTML += txtdiv;
	}

	function delMutualAccomTxt(txtId, strFieldId) {
		var divTxtId = "div"+txtId;
		removeChildTag("shwAddedAccom", divTxtId);
		document.getElementById(strFieldId).value = "";
		if(document.getElementById("shwAddedAccom") && document.getElementById("shwAddedAccom").innerHTML == "") {
			document.getElementById("shwAddedAccomTr").style.display = "none";
		}
		if(document.getElementById(txtId)) {
			document.getElementById(txtId).style.display = "block";
		}
	}

	function delNonMutualAccomTxt(txtId, txtFullItemId, strFieldId, strFieldValue) {
		var divTxtId = "div"+txtId+strFieldValue;
		removeChildTag("shwAddedAccom", divTxtId);
		if(document.getElementById("shwAddedAccom").innerHTML == "") {
			document.getElementById("shwAddedAccomTr").style.display = "none";
		}
		var txtids = document.getElementById(strFieldId).value;
		if(txtids != "") {
			var txtidsarr = new Array();
			var tmptxtids = "";
			txtidsarr = txtids.split('-');
			for(var i = 0; i < txtidsarr.length; i++) {
				if(parseInt(strFieldValue) != parseInt(txtidsarr[i])) {
					if(i == 0) {
						tmptxtids = txtidsarr[i];
					} else {
						tmptxtids += "-"+txtidsarr[i];
					}
				}
			}
			if(tmptxtids.charAt(0) == "-") {
				tmptxtids = tmptxtids.substring(1, tmptxtids.length);
			}
			document.getElementById(strFieldId).value = tmptxtids;
		}
		if(document.getElementById(txtFullItemId)) {
			document.getElementById(txtFullItemId).style.display = "block";
		}
	}

	function showPage(strInt) {
		document.getElementById('frmRefineSearch').action = "<?php echo SITE_URL; ?>property-refine-search-results-ajax.php?page="+strInt;
		shwSearchResults();
	}

	function addMutualAccomTxt(txtId, txtTxt, strFieldId, strFieldValue) {
		var txtdiv = "<div id=\"div"+txtId+"\" style=\"clear:both; padding-top:3px;display:block;\"><a href=\"Javascript:delMutualAccomTxt('"+txtId+"', '"+strFieldId+"');Post.Send(document.getElementById('frmRefineSearch'));refineaccommodation();void(0);\" onMouseover=\"return hidestatus()\" class=\"blue-link\" style=\"text-decoration:none;\"><span class=\"blackText\">"+txtTxt+"</span>&nbsp;<strong>(x)</strong></a></div>";
		document.getElementById(strFieldId).value = strFieldValue;
		document.getElementById('shwAddedAccomTr').style.display = "block";
		document.getElementById('shwAddedAccom').style.display = "block";
		document.getElementById('shwAddedAccom').innerHTML += txtdiv;
	}

	function addNonMutualAccomTxt(txtId, txtFullItemId, txtTxt, strFieldId, strFieldValue) {
		var txtdiv = "<div id=\"div"+txtId+strFieldValue+"\" style=\"clear:both; padding-top:3px;display:block;\"><a href=\"Javascript:delNonMutualAccomTxt('"+txtId+"', '"+txtFullItemId+"', '"+strFieldId+"',  '"+strFieldValue+"');Post.Send(document.getElementById('frmRefineSearch'));refineaccommodation();void(0);\" onMouseover=\"return hidestatus()\" class=\"blue-link\" style=\"text-decoration:none;\"><span class=\"blackText\">"+txtTxt+"</span>&nbsp;<strong>(x)</strong></a></div>";
		var txtIds = document.getElementById(strFieldId).value;
		if(txtIds != "") {
			document.getElementById(strFieldId).value = txtIds+"-"+strFieldValue;
		} else {
			document.getElementById(strFieldId).value = strFieldValue;
		}

		document.getElementById('shwAddedAccomTr').style.display = "block";
		document.getElementById('shwAddedAccom').style.display = "block";
		document.getElementById('shwAddedAccom').innerHTML += txtdiv;
	}

	function delMutualAccomTxt(txtId, strFieldId) {
		var divTxtId = "div"+txtId;
		removeChildTag("shwAddedAccom", divTxtId);
		document.getElementById(strFieldId).value = "";
		if(document.getElementById("shwAddedAccom") && document.getElementById("shwAddedAccom").innerHTML == "") {
			document.getElementById("shwAddedAccomTr").style.display = "none";
		}
		if(document.getElementById(txtId)) {
			document.getElementById(txtId).style.display = "block";
		}
	}

	function delNonMutualAccomTxt(txtId, txtFullItemId, strFieldId, strFieldValue) {
		var divTxtId = "div"+txtId+strFieldValue;
		removeChildTag("shwAddedAccom", divTxtId);
		if(document.getElementById("shwAddedAccom").innerHTML == "") {
			document.getElementById("shwAddedAccomTr").style.display = "none";
		}
		var txtids = document.getElementById(strFieldId).value;
		if(txtids != "") {
			var txtidsarr = new Array();
			var tmptxtids = "";
			txtidsarr = txtids.split('-');
			for(var i = 0; i < txtidsarr.length; i++) {
				if(parseInt(strFieldValue) != parseInt(txtidsarr[i])) {
					if(i == 0) {
						tmptxtids = txtidsarr[i];
					} else {
						tmptxtids += "-"+txtidsarr[i];
					}
				}
			}
			if(tmptxtids.charAt(0) == "-") {
				tmptxtids = tmptxtids.substring(1, tmptxtids.length);
			}
			document.getElementById(strFieldId).value = tmptxtids;
		}
		if(document.getElementById(txtFullItemId)) {
			document.getElementById(txtFullItemId).style.display = "block";
		}
	}

	function removeChildTag(perentId, childId) {
	  var d = document.getElementById(perentId);
	  var childdiv = document.getElementById(childId);
	  d.removeChild(childdiv);
	}
	
	function shwMapSearch() {
		//Post2.Send(document.getElementById('frmRefineSearch'));
		saveSearch();
		Post.Send(document.getElementById('frmRefineSearch'));
	}

	function shwSearchResults() {
		saveSearch();
		Post.Send(document.getElementById('frmRefineSearch'));
	}

	function sortby() {
		var sortby = document.getElementById('txtSortById').value;
		document.getElementById('sortbyId').value = sortby;
		saveSearch();
		shwSearchResults();
	}

	function records_per_page(str) {
		var cook_records_per_page = str;
		DelCookie('cook_records_per_page');
		SetCookie('cook_records_per_page', cook_records_per_page);
		saveSearch();
		shwSearchResults();
	}
	
	function showlatedeal() {
		if(document.getElementById('txtShowDealId').checked == true) {
			document.getElementById('latedealId').value = "1";
			//SetCookie('cook_latedealId', '1');
		} else {
			document.getElementById('latedealId').value = "0";
			//DelCookie('cook_latedealId');
		}
		saveSearch();
		shwSearchResults();
	}

	function showPage(strInt) {
		document.getElementById('frmRefineSearch').action = "<?php echo SITE_URL; ?>property-refine-search-results-ajax.php?page="+strInt;
		shwSearchResults();
	}
	
	function changeMapMode() {
		if(document.getElementById('SearchLocFld1').value != "Where do you wanna go?" && document.getElementById('SearchLocFld1').value != ""){
			var txtDestination = document.getElementById("SearchLocFld1").value;
			txtDestination = txtDestination.toLowerCase();
			txtDestination = str_replace("/", "_", str_replace(" ", "-", txtDestination));
			document.getElementById('frmRefineSearch').action='<?php echo SITE_URL."map.vacation-rentals/in."; ?>'+txtDestination;
		} else {
			document.getElementById('frmRefineSearch').action='<?php echo SITE_URL; ?>map.vacation-rentals';
		}
		document.getElementById('frmRefineSearch').submit();
	}

	function changeResultsMode() {
		if(document.getElementById('SearchLocFld1').value != "Where do you wanna go?" && document.getElementById('SearchLocFld1').value != ""){
			var txtDestination = document.getElementById("SearchLocFld1").value;
			txtDestination = txtDestination.toLowerCase();
			txtDestination = str_replace("/", "_", str_replace(" ", "-", txtDestination));
			document.getElementById('frmRefineSearch').action='<?php echo SITE_URL."vacation-rentals/in."; ?>'+txtDestination;
		} else {
			document.getElementById('frmRefineSearch').action='<?php echo SITE_URL; ?>vacation-rentals';
		}
		document.getElementById('frmRefineSearch').submit();
	}

	//************ NOTE: DO NOT EDIT THIS FILE MANUALLY *************
	var gh_rates = new Object;
	gh_rates["GBP"]=<?php echo $currencyRateArr['GBP']; ?>;
	gh_rates["USD"]=<?php echo $currencyRateArr['USD']; ?>;
	gh_rates["EUR"]=<?php echo $currencyRateArr['EUR']; ?>;
	//************ NOTE: DO NOT EDIT THIS FILE MANUALLY *************

	function getCurrSymbol(lscurr) {
		var lsOut;
		switch(lscurr) {
			case "GBP": lsOut = "&pound;"; break;
			case "USD": lsOut = "$"; break;
			case "EUR": lsOut = "&euro;"; break;
		}
		return lsOut;
	}

	function roundprice(rprice, rbpence) { 
		//rprice [the full price to be rounded]
		//rbpence flag to specify to round to pence(3.99) or to pound(3)[  1=pence 0=pounds ]
		//rprice=222.5; rbpence=1;
		//alert('roundpence() rprice='+rprice + ' rbpence='+rbpence);
		var mystr = rprice.toString();
		var mypos=mystr.indexOf(".");
		//alert('roundpence() mypos='+mypos);
		if (mypos==-1)  {
			retval=mystr;
			//Put comma in to represent thousand separator - what a pain!!
			//alert('leaving here');
			if (rbpence==1)   {
				//No decimal place, so add the .00
				retval=mystr+'.00'
			}
		} else {	
			if (rbpence==1)  {
				//Add a ZERO if only one number after the decimal place
				//Get the bit before the decimal place
				var after = mystr.slice(mypos+1);
				//alert('a) after='+after);
				if (after.length==1)  {  //dp+1digit==2
					after=after+'0';
					//alert('b) after='+after);
				} else  {
					//Get 3 digits (if they exist) so we can round properly
					//alert('after=' + after);
					
					if (after.length > 2 )  {
						after=after.slice(0,2) + '.' + after.slice(2,3);
						//Rounds to 2 dp
						after=Math.round(after);
					}
					//alert('after slice=' + after);
				}
				retval=mystr.slice(0,mypos) + '.' + after;
			} else  {
				//Just return the bit before the decimal place
				//retval=mystr.slice(0,mypos);
				retval=Math.round(mystr)
			}
		}
		//alert('roundpence() retval='+retval);
		return addCommas(retval);
	}

	function addCommas(nStr) {
		nStr += '';
		x = nStr.split('.');
		x1 = x[0];
		x2 = x.length > 1 ? '.' + x[1] : '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(x1)) {
			x1 = x1.replace(rgx, '$1' + ',' + '$2');
		}
		return x1 + x2;
	}


	function change_currency_symbol_src(curcode) {
		var strHTML = '';
		switch(curcode) {
			case 'GBP':
				strHTML += '<a href="javascript:void(0);" onclick="convertCurrency(\'GBP\');" style="text-decoration:none;"><img id="priceSymbolGBP" src="<?php echo SITE_IMAGES; ?>d-1.jpg" alt="View price in pound" style="padding-left:6px;" border="0" /></a>';
				strHTML += '<a href="javascript:void(0);" onclick="convertCurrency(\'USD\');" style="text-decoration:none;"><img id="priceSymbolUSD" src="<?php echo SITE_IMAGES; ?>d-2.jpg" alt="View price in dollar" style="padding-left:6px;" border="0" /></a>';
				strHTML += '<a href="javascript:void(0);" onclick="convertCurrency(\'EUR\');" style="text-decoration:none;"><img id="priceSymbolEUR" src="<?php echo SITE_IMAGES; ?>d-3.jpg" alt="View price in euro" style="padding-left:6px;" border="0" /></a>';
			break;
			case 'USD':
				strHTML += '<a href="javascript:void(0);" onclick="convertCurrency(\'GBP\');" style="text-decoration:none;"><img id="priceSymbolGBP" src="<?php echo SITE_IMAGES; ?>d-1.jpg" alt="View price in pound" style="padding-left:6px;" border="0" /></a>';
				strHTML += '<a href="javascript:void(0);" onclick="convertCurrency(\'USD\');" style="text-decoration:none;"><img id="priceSymbolUSD" src="<?php echo SITE_IMAGES; ?>d-2.jpg" alt="View price in dollar" style="padding-left:6px;" border="0" /></a>';
				strHTML += '<a href="javascript:void(0);" onclick="convertCurrency(\'EUR\');" style="text-decoration:none;"><img id="priceSymbolEUR" src="<?php echo SITE_IMAGES; ?>d-3.jpg" alt="View price in euro" style="padding-left:6px;" border="0" /></a>';
		    break;
			case 'EUR':
				strHTML += '<a href="javascript:void(0);" onclick="convertCurrency(\'GBP\');" style="text-decoration:none;"><img id="priceSymbolGBP" src="<?php echo SITE_IMAGES; ?>d-1.jpg" alt="View price in pound" style="padding-left:6px;" border="0" /></a>';
				strHTML += '<a href="javascript:void(0);" onclick="convertCurrency(\'USD\');" style="text-decoration:none;"><img id="priceSymbolUSD" src="<?php echo SITE_IMAGES; ?>d-2.jpg" alt="View price in dollar" style="padding-left:6px;" border="0" /></a>';
				strHTML += '<a href="javascript:void(0);" onclick="convertCurrency(\'EUR\');" style="text-decoration:none;"><img id="priceSymbolEUR" src="<?php echo SITE_IMAGES; ?>d-3.jpg" alt="View price in euro" style="padding-left:6px;" border="0" /></a>';
            break;
		}
		document.getElementById('priceSymbolViewId').innerHTML = strHTML;
	}

	//Save their currency preference
	function save_preferred_ccy(curcode) {
		req.open('get', '<?php echo SITE_URL;?>setUserCurrency.php?curcode=' + curcode); 
		req.send(null); 
	}


	function convertCurrency(to_ccy) { 

		var cntPriceArr	= <?php echo count($propListArr); ?>;
		   	if(parseInt(cntPriceArr) > 0) {
				   for (var i = 0; i < cntPriceArr; i++) 
				    {
			  				//Get Amounts
				if(document.getElementById('price_currency_price_id2'+i)) {
					var currencyValueId1 = document.getElementById('price_currency_price_id1'+i);
					var currencyValueId2 = document.getElementById('price_currency_price_id2'+i);
	
					var currencySymbolId1 = document.getElementById('price_currency_symbol_id1'+i);
					var currencySymbolId2 = document.getElementById('price_currency_symbol_id2'+i);
					switch(to_ccy) {
						case 'GBP':
							convertedCurrencyValue1 = roundprice(document.getElementById('price_rate_gbp_id1'+i).value,0);
							convertedCurrencyValue2 = roundprice(document.getElementById('price_rate_gbp_id2'+i).value,0);
						break;
						case 'USD':
							convertedCurrencyValue1 = roundprice(document.getElementById('price_rate_usd_id1'+i).value,0);
							convertedCurrencyValue2 = roundprice(document.getElementById('price_rate_usd_id2'+i).value,0);
						break;
						case 'EUR':
							convertedCurrencyValue1 = roundprice(document.getElementById('price_rate_eur_id1'+i).value,0);
							convertedCurrencyValue2 = roundprice(document.getElementById('price_rate_eur_id2'+i).value,0);
						break;
					}
	
					currencySymbolId1.innerHTML = getCurrSymbol(to_ccy);
					currencySymbolId2.innerHTML = getCurrSymbol(to_ccy);
	
					currencyValueId1.innerHTML = convertedCurrencyValue1;
					currencyValueId2.innerHTML = convertedCurrencyValue2;
				} else {
					var currencyValueId1 = document.getElementById('price_currency_price_id1'+i);
				    var currencySymbolId1 = document.getElementById('price_currency_symbol_id1'+i);
				
					switch(to_ccy) {
						case 'GBP':
							convertedCurrencyValue1 = roundprice(document.getElementById('price_rate_gbp_id1'+i).value,0);
						break;
						case 'USD':
							convertedCurrencyValue1 = roundprice(document.getElementById('price_rate_usd_id1'+i).value,0);
						break;
						case 'EUR':
							convertedCurrencyValue1 = roundprice(document.getElementById('price_rate_eur_id1'+i).value,0);
						break;
					}
					currencySymbolId1.innerHTML = getCurrSymbol(to_ccy);
					currencyValueId1.innerHTML = convertedCurrencyValue1;
				}
			}
		}

		//Save their currency preference
		change_currency_symbol_src(to_ccy);
		save_preferred_ccy(to_ccy);
		return true;
	}

	function saveSearch() {
		var cook_txtbackurl = document.getElementById("txtbackurl").value;
		var cook_txtdatefrom = document.getElementById("txtArrivaldate").value;
		var cook_txtdateto = document.getElementById("txtDeparturedate").value;
		var cook_txtpropertytypeids = document.getElementById("txtpropertytypeids").value;
		var cook_txtonlybed = document.getElementById("txtonlybed").value;
		var cook_txttotalbed = document.getElementById("txttotalbed").value;
		var cook_txtneedsleep = document.getElementById("txtneedsleep").value;
		var cook_txtfacilityids = document.getElementById("txtfacilityids").value;
		var cook_sortbyId = document.getElementById("sortbyId").value;
		var cook_latedealId = document.getElementById("latedealId").value;
		//var cook_worldcupId = document.getElementById("worldcupId").value;
		var cook_featured = document.getElementById("featured").value;
	
		DelCookie('cook_txtbackurl');
		DelCookie('cook_txtdatefrom');
		DelCookie('cook_txtdateto');
		DelCookie('cook_txtpropertytypeids');
		DelCookie('cook_txtonlybed');
		DelCookie('cook_txttotalbed');
		DelCookie('cook_txtneedsleep');
		DelCookie('cook_txtfacilityids');
		DelCookie('cook_sortbyId');
		DelCookie('cook_latedealId');
		//DelCookie('cook_worldcupId');
		DelCookie('cook_featured');

		SetCookie('cook_txtbackurl', cook_txtbackurl);
		SetCookie('cook_txtdatefrom', cook_txtdatefrom);
		SetCookie('cook_txtdateto', cook_txtdateto);
		SetCookie('cook_txtpropertytypeids', cook_txtpropertytypeids);
		SetCookie('cook_txtonlybed', cook_txtonlybed);
		SetCookie('cook_txttotalbed', cook_txttotalbed);
		SetCookie('cook_txtneedsleep', cook_txtneedsleep);
		SetCookie('cook_txtfacilityids', cook_txtfacilityids);
		SetCookie('cook_sortbyId', cook_sortbyId);
		SetCookie('cook_latedealId', cook_latedealId);
		//SetCookie('cook_worldcupId', cook_worldcupId);
		SetCookie('cook_featured', cook_featured);
	}
	
	function showProperty(url) {
		document.getElementById("frmRefineSearch").action = url;
		document.getElementById('frmRefineSearch').submit();
	}
</script>
<form name="frmRefineSearch" id="frmRefineSearch" action="<?php if($mapShowOn == true) {echo SITE_URL."property-refine-search-map-ajax.php";} else {echo SITE_URL."property-refine-search-results-ajax.php";} ?>" method="post"  onSubmit="Post.Send(this); return false;" >
    <input type="hidden" name="securityKey" value="<?php echo md5("REFINESEARCH")?>">
    <input type="hidden" name="txtbackurl" id="txtbackurl" value="<?php echo "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];?>">
    <input type="hidden" name="txtcountryids" id="txtcountryids" value="<?php if(isset($txtcountryids) && $txtcountryids !="") {echo $txtcountryids;}?>">
    <input type="hidden" name="txtareaids" id="txtareaids" value="<?php if(isset($txtareaids) && $txtareaids !="") {echo $txtareaids;}?>">
    <input type="hidden" name="txtregionids" id="txtregionids" value="<?php echo $txtregionids;?>">
    <input type="hidden" name="txtlocationids" id="txtlocationids" value="<?php echo $txtlocationids;?>">
    <input type="hidden" name="txtpropertytypeids" id="txtpropertytypeids" value="<?php echo $txtpropertytypeids;?>">
    <input type="hidden" name="txttotalbed" id="txttotalbed" value="<?php echo $txttotalbed;?>">
    <input type="hidden" name="txtonlybed" id="txtonlybed" value="<?php echo $txtonlybed;?>">
    <input type="hidden" name="txtneedsleep" id="txtneedsleep" value="<?php echo $txtneedsleep;?>">
    <input type="hidden" name="txtholidaytypeids" id="txtholidaytypeids" value="<?php echo $txtholidaytypeids;?>">
    <input type="hidden" name="txtkitchenlinenids" id="txtkitchenlinenids" value="<?php echo $txtkitchenlinenids;?>">
    <input type="hidden" name="txtoutsideids" id="txtoutsideids" value="<?php echo $txtoutsideids;?>">
    <input type="hidden" name="txtactivitynearbyids" id="txtactivitynearbyids" value="<?php echo $txtactivitynearbyids;?>">
    <input type="hidden" name="txtenterainmentids" id="txtenterainmentids" value="<?php echo $txtenterainmentids;?>">
    <input type="hidden" name="txtheatingcoolingids" id="txtheatingcoolingids" value="<?php echo $txtheatingcoolingids;?>">
    <input type="hidden" name="txtlocationviewids" id="txtlocationviewids" value="<?php echo $txtlocationviewids;?>">
    <input type="hidden" name="txtserviceids" id="txtserviceids" value="<?php echo $txtserviceids;?>">
    <input type="hidden" name="txtgeneralids" id="txtgeneralids" value="<?php echo $txtgeneralids;?>">
    <input type="hidden" name="txtfacilityids" id="txtfacilityids" value="<?php echo $txtfacilityids;?>">
    <input type="hidden" name="sortby" id="sortbyId" value="0">
    <input type="hidden" name="latedeal" id="latedealId" value="<?php if(isset($latedeal) && $latedeal != "") {echo $latedeal;} else {echo "0";}?>">
	<?php /*?>
    <input type="hidden" name="worldcup" id="worldcupId" value="<?php if(isset($worldcup) && $worldcup != "") {echo $worldcup;} else {echo "0";}?>">
	<?php */?>
    <input type="hidden" name="showmap" id="showmap" value="<?php if($mapShowOn == true) { echo "1";} else {echo "0";} ?>" />
    <input type="hidden" name="p_map_zoom" value="<?php if(isset($mapZoomLevel)) {echo $mapZoomLevel;} else {echo "2";}?>" id="p_map_zoom" />
    <input type="hidden" name="p_map_map_type" value="G_HYBRID_MAP" id="p_map_map_type" />
    <input type="hidden" name="p_map_latitude" id="p_map_latitude" value="<?php if(isset($mapLatitude) && $mapLatitude !=""){echo $mapLatitude;} else {echo "31.052934";} ?>">
    <input type="hidden" name="p_map_longitude" id="p_map_longitude" value="<?php if(isset($mapLongitude) && $mapLongitude !=""){echo $mapLongitude;} else {echo "10.546875";} ?>">
    <input type="hidden" name="featured" id="featured" value="<?php if(isset($featured) && $featured !=""){echo $featured;} else {echo "0";} ?>" />
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr id="shwAddedAccomTr" style="display:none;">
            <td class="searchBoxAcc" style="height:0px;">
                <div id="shwAddedAccom" style="display:block;padding:0px;">
                <?php
                if(isset($txttotalbed) && $txttotalbed !="") {
                    $txtId 			= "RSBedRoomDivId";
                    $txtTxt 		= "Beds ".$txttotalbed." or more";
                    $strFieldId 	= "txttotalbed";
                    $strFieldValue 	= $txttotalbed;
                    
                    echo "<div id=\"div".$txtId."\" style=\"clear:both; padding-top:3px;display:block;\"><a href=\"Javascript:delMutualAccomTxt('".$txtId."', '".$strFieldId."');Post.Send(document.getElementById('frmRefineSearch'));refineaccommodation();void(0);\" onMouseover=\"return hidestatus()\" class=\"blue-link\" style=\"text-decoration:none;\"><span class=\"blackText\">".$txtTxt."</span>&nbsp;<strong>(x)</strong></a></div>";
                }
                ?>    
                <?php
                if(isset($txtneedsleep) && $txtneedsleep !="") {
                    $txtId 			= "RSNeedSleepDivId";
                    $txtTxt 		= "Sleep ".$txtneedsleep." or more";
                    $strFieldId 	= "txtneedsleep";
                    $strFieldValue 	= $txtneedsleep;
                    
                    echo "<div id=\"div".$txtId."\" style=\"clear:both; padding-top:3px;display:block;\"><a href=\"Javascript:delMutualAccomTxt('".$txtId."', '".$strFieldId."');Post.Send(document.getElementById('frmRefineSearch'));refineaccommodation();void(0);\" onMouseover=\"return hidestatus()\" class=\"blue-link\" style=\"text-decoration:none;\"><span class=\"blackText\">".$txtTxt."</span>&nbsp;<strong>(x)</strong></a></div>";
                }
                ?>    
                <?php
                    if(is_array($txtpropertytypeidsArr) && count($txtpropertytypeidsArr) > 0) {
                        for($i = 0; $i < count($txtpropertytypeidsArr); $i++) {
                            $propTypeId 		= $txtpropertytypeidsArr[$i];
                            $txtId 				= "RSPropTypeSelectedDivId";
                            $txtFullItemId 		= "RSPropTypeDivSelectedItemId".$i;
                            $txtTxt 			= ucfirst($dbObj->getField(TABLE_PROPERTY_TYPE, "pt_id", $propTypeId, "pt_title"));
                            $strFieldId 		= "txtpropertytypeids";
                            $strFieldValue 		= $propTypeId;
                            echo "<div id=\"div".$txtId.$strFieldValue."\" style=\"clear:both; padding-top:3px;display:block;\"><a href=\"Javascript:delNonMutualAccomTxt('".$txtId."', '".$txtFullItemId."', '".$strFieldId."',  '".$strFieldValue."');Post.Send(document.getElementById('frmRefineSearch'));refineaccommodation();void(0);\" onMouseover=\"return hidestatus()\" class=\"blue-link\" style=\"text-decoration:none;\"><span class=\"blackText\">".$txtTxt."</span>&nbsp;<strong>(x)</strong></a></div>";
                        }
                    }
                ?>    
            
                <?php
                    if(is_array($txtholidaytypeidsArr) && count($txtholidaytypeidsArr) > 0) {
                        for($j = 0; $j < count($propertyHolidayTypeArr); $j++) {
                            $featuresId 		= $txtholidaytypeidsArr[$j];
                            $txtId 				= "RSHolidayTypeSelectedDivId";
                            $txtFullItemId 		= "RSHolidayTypeDivSelectedItemId".$j;
                            $txtTxt 			= ucfirst($dbObj->getField(TABLE_PROPERTY_FEATURES, "property_features_id", $featuresId, "property_features_name"));
                            $strFieldId 		= "txtholidaytypeids";
                            $strFieldValue 		= $featuresId;
                            echo "<div id=\"div".$txtId.$strFieldValue."\" style=\"clear:both; padding-top:3px;display:block;\"><a href=\"Javascript:delNonMutualAccomTxt('".$txtId."', '".$txtFullItemId."', '".$strFieldId."', '".$strFieldValue."');Post.Send(document.getElementById('frmRefineSearch'));refineaccommodation();void(0);\" onMouseover=\"return hidestatus()\" class=\"blue-link\" style=\"text-decoration:none;\"><span class=\"blackText\">".$txtTxt."</span>&nbsp;<strong>(x)</strong></a></div>";
                        }
                    }
            
                    if(is_array($txtkitchenlinenidsArr) && count($txtkitchenlinenidsArr) > 0) {
                        for($j = 0; $j < count($txtkitchenlinenidsArr); $j++) {
                            $featuresId 		= $txtkitchenlinenidsArr[$j];
                            $txtId 				= "RSKitchenSelectedDivId";
                            $txtFullItemId 		= "RSKitchenDivSelectedItemId".$j;
                            $txtTxt 			= ucfirst($dbObj->getField(TABLE_PROPERTY_FEATURES, "property_features_id", $featuresId, "property_features_name"));
                            $strFieldId 		= "txtkitchenlinenids";
                            $strFieldValue 		= $featuresId;
                            echo "<div id=\"div".$txtId.$strFieldValue."\" style=\"clear:both; padding-top:3px;display:block;\"><a href=\"Javascript:delNonMutualAccomTxt('".$txtId."', '".$txtFullItemId."', '".$strFieldId."', '".$strFieldValue."');Post.Send(document.getElementById('frmRefineSearch'));refineaccommodation();void(0);\" onMouseover=\"return hidestatus()\" class=\"blue-link\" style=\"text-decoration:none;\"><span class=\"blackText\">".$txtTxt."</span>&nbsp;<strong>(x)</strong></a></div>";
                        }
                    }
            
                    if(is_array($txtoutsideidsArr) && count($txtoutsideidsArr) > 0) {
                        for($j = 0; $j < count($txtoutsideidsArr); $j++) {
                            $featuresId 		= $txtoutsideidsArr[$j];
                            $txtId 				= "RSOutsideSelectedDivId";
                            $txtFullItemId 		= "RSOutsideDivSelectedItemId".$j;
                            $txtTxt 			= ucfirst($dbObj->getField(TABLE_PROPERTY_FEATURES, "property_features_id", $featuresId, "property_features_name"));
                            $strFieldId 		= "txtoutsideids";
                            $strFieldValue 		= $featuresId;
                            echo "<div id=\"div".$txtId.$strFieldValue."\" style=\"clear:both; padding-top:3px;display:block;\"><a href=\"Javascript:delNonMutualAccomTxt('".$txtId."', '".$txtFullItemId."', '".$strFieldId."', '".$strFieldValue."');Post.Send(document.getElementById('frmRefineSearch'));refineaccommodation();void(0);\" onMouseover=\"return hidestatus()\" class=\"blue-link\" style=\"text-decoration:none;\"><span class=\"blackText\">".$txtTxt."</span>&nbsp;<strong>(x)</strong></a></div>";
                        }
                    }
            
                    if(is_array($txtactivitynearbyidsArr) && count($txtactivitynearbyidsArr) > 0) {
                        for($j = 0; $j < count($txtactivitynearbyidsArr); $j++) {
                            $featuresId 		= $txtactivitynearbyidsArr[$j];
                            $txtId 				= "RSActivitiesNearbySelectedDivId";
                            $txtFullItemId 		= "RSActivitiesNearbyDivSelectedItemId".$j;
                            $txtTxt 			= ucfirst($dbObj->getField(TABLE_PROPERTY_FEATURES, "property_features_id", $featuresId, "property_features_name"));
                            $strFieldId 		= "txtactivitynearbyids";
                            $strFieldValue 		= $featuresId;
                            echo "<div id=\"div".$txtId.$strFieldValue."\" style=\"clear:both; padding-top:3px;display:block;\"><a href=\"Javascript:delNonMutualAccomTxt('".$txtId."', '".$txtFullItemId."', '".$strFieldId."', '".$strFieldValue."');Post.Send(document.getElementById('frmRefineSearch'));refineaccommodation();void(0);\" onMouseover=\"return hidestatus()\" class=\"blue-link\" style=\"text-decoration:none;\"><span class=\"blackText\">".$txtTxt."</span>&nbsp;<strong>(x)</strong></a></div>";
                        }
                    }
                    if(is_array($txtheatingcoolingidsArr) && count($txtheatingcoolingidsArr) > 0) {
                        for($j = 0; $j < count($txtheatingcoolingidsArr); $j++) {
                            $featuresId 		= $txtactivitynearbyidsArr[$j];
                            $txtId 				= "RSHeatingCoolingSelectedDivId";
                            $txtFullItemId 		= "RSHeatingCoolingDivSelectedItemId".$j;
                            $txtTxt 			= ucfirst($dbObj->getField(TABLE_PROPERTY_FEATURES, "property_features_id", $featuresId, "property_features_name"));
                            $strFieldId 		= "txtheatingcoolingids";
                            $strFieldValue 		= $featuresId;
                            echo "<div id=\"div".$txtId.$strFieldValue."\" style=\"clear:both; padding-top:3px;display:block;\"><a href=\"Javascript:delNonMutualAccomTxt('".$txtId."', '".$txtFullItemId."', '".$strFieldId."', '".$strFieldValue."');Post.Send(document.getElementById('frmRefineSearch'));refineaccommodation();void(0);\" onMouseover=\"return hidestatus()\" class=\"blue-link\" style=\"text-decoration:none;\"><span class=\"blackText\">".$txtTxt."</span>&nbsp;<strong>(x)</strong></a></div>";
                        }
                    }
                    if(is_array($txtenterainmentidsArr) && count($txtenterainmentidsArr) > 0) {
                        for($j = 0; $j < count($txtenterainmentidsArr); $j++) {
                            $featuresId 		= $txtenterainmentidsArr[$j];
                            $txtId 				= "RSEntertainmentSelectedDivId";
                            $txtFullItemId 		= "RSEntertainmentDivSelectedItemId".$j;
                            $txtTxt 			= ucfirst($dbObj->getField(TABLE_PROPERTY_FEATURES, "property_features_id", $featuresId, "property_features_name"));
                            $strFieldId 		= "txtenterainmentids";
                            $strFieldValue 		= $featuresId;
                            echo "<div id=\"div".$txtId.$strFieldValue."\" style=\"clear:both; padding-top:3px;display:block;\"><a href=\"Javascript:delNonMutualAccomTxt('".$txtId."', '".$txtFullItemId."', '".$strFieldId."', '".$strFieldValue."');Post.Send(document.getElementById('frmRefineSearch'));refineaccommodation();void(0);\" onMouseover=\"return hidestatus()\" class=\"blue-link\" style=\"text-decoration:none;\"><span class=\"blackText\">".$txtTxt."</span>&nbsp;<strong>(x)</strong></a></div>";
                        }
                    }
                    if(is_array($txtlocationviewidsArr) && count($txtlocationviewidsArr) > 0) {
                        for($j = 0; $j < count($txtlocationviewidsArr); $j++) {
                            $featuresId 		= $txtlocationviewidsArr[$j];
                            $txtId 				= "RSLocationViewSelectedDivId";
                            $txtFullItemId 		= "RSLocationViewDivSelectedItemId".$j;
                            $txtTxt 			= ucfirst($dbObj->getField(TABLE_PROPERTY_FEATURES, "property_features_id", $featuresId, "property_features_name"));
                            $strFieldId 		= "txtlocationviewids";
                            $strFieldValue 		= $featuresId;
                            echo "<div id=\"div".$txtId.$strFieldValue."\" style=\"clear:both; padding-top:3px;display:block;\"><a href=\"Javascript:delNonMutualAccomTxt('".$txtId."', '".$txtFullItemId."', '".$strFieldId."', '".$strFieldValue."');Post.Send(document.getElementById('frmRefineSearch'));refineaccommodation();void(0);\" onMouseover=\"return hidestatus()\" class=\"blue-link\" style=\"text-decoration:none;\"><span class=\"blackText\">".$txtTxt."</span>&nbsp;<strong>(x)</strong></a></div>";
                        }
                    }
                    if(is_array($txtserviceidsArr) && count($txtserviceidsArr) > 0) {
                        for($j = 0; $j < count($txtserviceidsArr); $j++) {
                            $featuresId 		= $txtserviceidsArr[$j];
                            $txtId 				= "RSServicesViewSelectedDivId";
                            $txtFullItemId 		= "RSServicesViewDivSelectedItemId".$j;
                            $txtTxt 			= ucfirst($dbObj->getField(TABLE_PROPERTY_FEATURES, "property_features_id", $featuresId, "property_features_name"));
                            $strFieldId 		= "txtserviceids";
                            $strFieldValue 		= $featuresId;
                            echo "<div id=\"div".$txtId.$strFieldValue."\" style=\"clear:both; padding-top:3px;display:block;\"><a href=\"Javascript:delNonMutualAccomTxt('".$txtId."', '".$txtFullItemId."', '".$strFieldId."', '".$strFieldValue."');Post.Send(document.getElementById('frmRefineSearch'));refineaccommodation();void(0);\" onMouseover=\"return hidestatus()\" class=\"blue-link\" style=\"text-decoration:none;\"><span class=\"blackText\">".$txtTxt."</span>&nbsp;<strong>(x)</strong></a></div>";
                        }
                    }
                    if(is_array($txtgeneralidsArr) && count($txtgeneralidsArr) > 0) {
                        for($j = 0; $j < count($txtgeneralidsArr); $j++) {
                            $featuresId 		= $txtgeneralidsArr[$j];
                            $txtId 				= "RSGeneralSelectedDivId";
                            $txtFullItemId 		= "RSGeneralDivSelectedItemId".$j;
                            $txtTxt 			= ucfirst($dbObj->getField(TABLE_PROPERTY_FEATURES, "property_features_id", $featuresId, "property_features_name"));
                            $strFieldId 		= "txtgeneralids";
                            $strFieldValue 		= $featuresId;
                            echo "<div id=\"div".$txtId.$strFieldValue."\" style=\"clear:both; padding-top:3px;display:block;\"><a href=\"Javascript:delNonMutualAccomTxt('".$txtId."', '".$txtFullItemId."', '".$strFieldId."', '".$strFieldValue."');Post.Send(document.getElementById('frmRefineSearch'));refineaccommodation();void(0);\" onMouseover=\"return hidestatus()\" class=\"blue-link\" style=\"text-decoration:none;\"><span class=\"blackText\">".$txtTxt."</span>&nbsp;<strong>(x)</strong></a></div>";
                        }
                    }
                ?>    
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="showAccommodationDetails" class="refine-wrap">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" id="RSAccomShwId" style="display:block; padding:0px; margin:0px;" class="font12">
                        <tr>
                            <td valign="middle" class="pad-btm2">
                                <div id="RSPropTypeDivId" style="display:block;">
                                    <div id="RSPropTypeDivShortId" style="display:<?php if(isset($_COOKIE['showHideRSPropTypeDivShortId']) && $_COOKIE['showHideRSPropTypeDivShortId']=="none" && $_COOKIE['showHideRSPropTypeDivFullId']=="block"){echo "none";} else {echo "block";}?>;">
                                        <div style="background-color:#efefef; height:25px; vertical-align:middle; cursor:pointer;" onclick="SetCookie('showHideRSPropTypeDivFullId', 'block');SetCookie('showHideRSPropTypeDivShortId', 'none');showHideSection('RSPropTypeDivShortId');showHideSection('RSPropTypeDivFullId');" class="refine-wrap-first">
                                            <span class="FloatLft pad-lft10 pad-top5" style="color:#009bd4; font-weight:bold;"><?php echo tranText('property_type'); ?></span>
                                            <span class="FloatRgt pad-rgt10 pad-top10"><img src="<?php echo SITE_IMAGES;?>up-icon.gif" /></span>
                                        </div>
                                    </div>
                                    <div id="RSPropTypeDivFullId" style="display:<?php if(isset($_COOKIE['showHideRSPropTypeDivFullId']) && $_COOKIE['showHideRSPropTypeDivFullId']=="block"){echo "block";} else {echo "none";}?>;">
                                        <div style="background-color:#009bd4; height:25px; vertical-align:middle; cursor:pointer;" onclick="SetCookie('showHideRSPropTypeDivShortId', 'block');SetCookie('showHideRSPropTypeDivFullId', 'none');showHideSection('RSPropTypeDivFullId');showHideSection('RSPropTypeDivShortId');" class="refine-wrap-first">
                                            <span class="FloatLft pad-lft10 pad-top5" style="color:#ffffff; font-weight:bold;"><?php echo tranText('property_type'); ?></span>
                                            <span class="FloatRgt pad-rgt10 pad-top10"><img src="<?php echo SITE_IMAGES;?>down-icon.gif" /></span>
                                        </div>
                                        <?php
                                        for($typeCounter2 = 0; $typeCounter2 < count($propertyTypeArr); $typeCounter2++) {
                                            $typeCounterDisplay2 = (is_array($txtpropertytypeidsArr) && in_array($propertyTypeArr[$typeCounter2]['property_type_id'], $txtpropertytypeidsArr))?"none":"block";
                                            echo "<div id=\"RSPropTypeDivFullItemId".$typeCounter2."\" style=\"display:".$typeCounterDisplay2."; padding:5px 10px 5px 10px;\"><a href=\"javascript:showHideSection('RSPropTypeDivShortItemId".$typeCounter2."');showHideSection('RSPropTypeDivFullItemId".$typeCounter2."');addNonMutualAccomTxt('RSPropTypeDivId', 'RSPropTypeDivFullItemId".$typeCounter2."', '".ucfirst($propertyTypeArr[$typeCounter2]['property_type_name'])."', 'txtpropertytypeids','".$propertyTypeArr[$typeCounter2]['property_type_id']."');Post.Send(document.getElementById('frmRefineSearch'));refineaccommodation();void(0);\" onMouseover=\"return hidestatus()\" style=\"text-decoration:none;\"><strong>(+)</strong>&nbsp;<span class=\"blackText\">".ucfirst($propertyTypeArr[$typeCounter2]['property_type_name'])."</span></a></div>";
                                        }
                                        ?>
                                    </div>
                                </div>                                            
                            </td>
                        </tr>
                        <?php
						/*
                        if(count($propertyTotalBedArr) > 0 && $txttotalbed == "" &&  $txtonlybed == "") {
                        ?>
                        <tr>
                            <td>
                                <div id="RSBedRoomDivId" style="display:block;">
                                    <div id="RSBedRoomDivShortId" style="display:<?php if($txttotalbed != "") {echo "none";} else if(isset($_COOKIE['showHideRSBedRoomDivShortId']) && $_COOKIE['showHideRSBedRoomDivShortId']=="none" && $txttotalbed == ""){echo "none";} else {echo "block";}?>;">
                                        <div style=" background-color:#ccffff; height:21px; width:188px; vertical-align:middle;">
                                            <span class="FloatLft font12-darkgrey pad-lft5"><?php echo tranText('bedrooms'); ?></span>
                                            <span class="FloatRgt pad-rgt10"><img src="<?php echo SITE_IMAGES;?>maximize-icon.gif" alt="Expand" onclick="SetCookie('showHideRSBedRoomDivFullId', 'block');SetCookie('showHideRSBedRoomDivShortId', 'none');showHideSection('RSBedRoomDivShortId');showHideSection('RSBedRoomDivFullId');" class="cursor" width="15" height="15" /></span>
                                        </div>
                                    </div>
                                    <div id="RSBedRoomDivFullId" style="display:<?php if($txttotalbed != "") {echo "none";} else if(isset($_COOKIE['showHideRSBedRoomDivFullId']) && $_COOKIE['showHideRSBedRoomDivFullId']=="block" && $txttotalbed == ""){echo "block";} else {echo "none";}?>;">
                                        <div style="background-color:#ccffff; height:21px; width:188px; vertical-align:middle;">
                                            <span class="FloatLft font12-darkgrey pad-lft5"><?php echo tranText('bedrooms'); ?></span>
                                            <span class="FloatRgt pad-rgt10"><img src="<?php echo SITE_IMAGES;?>minimize-icon.gif" alt="Expand" onclick="SetCookie('showHideRSBedRoomDivShortId', 'block');SetCookie('showHideRSBedRoomDivFullId', 'none');showHideSection('RSBedRoomDivFullId');showHideSection('RSBedRoomDivShortId');" class="cursor" width="15" height="15" /></span>
                                        </div>
                                        <?php
                                        for($totalBedCounter2 = 0; $totalBedCounter2 < count($propertyTotalBedArr); $totalBedCounter2++) {
                                            echo "<div id=\"RSBedRoomDivFullItemId".$totalBedCounter2."\" style=\"display:block;\"><a href=\"javascript:showHideSection('RSBedRoomDivId');addMutualAccomTxt('RSBedRoomDivId', 'Beds ".(int)($totalBedCounter2+1)." or more', 'txttotalbed','".(int)($totalBedCounter2+1)."');Post.Send(document.getElementById('frmRefineSearch'));refineaccommodation();void(0);\" onMouseover=\"return hidestatus()\"  style=\"text-decoration:none;\"><strong>(+)</strong>&nbsp;<span class=\"blackText\">".$propertyTotalBedArr[$totalBedCounter2]['total_bed_text']."</span></a></div>";
                                        }
                                        ?>
                                    </div>
                                </div>                                            
                            </td>
                        </tr>
                        <?php
                        }
						*/
                        ?>
                        <?php
                        if(count($propertyComfortSleepArr) > 0 && $txtneedsleep == "") {
                        ?>
                        <tr>
                            <td valign="middle" class="pad-btm2">
                                <div id="RSNeedSleepDivId" style="display:block;">
                                    <div id="RSNeedSleepDivShortId" style="display:<?php if($txtneedsleep != "") {echo "none";} else if(isset($_COOKIE['showHideRSNeedSleepDivShortId']) && $_COOKIE['showHideRSNeedSleepDivShortId']=="none" && $txtneedsleep == ""){echo "none";} else {echo "block";}?>;">
                                        <div style="background-color:#efefef; height:25px; vertical-align:middle; cursor:pointer;" onclick="SetCookie('showHideRSNeedSleepDivFullId', 'block');SetCookie('showHideRSNeedSleepDivShortId', 'none');showHideSection('RSNeedSleepDivShortId');showHideSection('RSNeedSleepDivFullId');">
                                            <span class="FloatLft pad-lft10 pad-top5" style="color:#009bd4; font-weight:bold;"><?php echo tranText('sleeps'); ?></span>
                                            <span class="FloatRgt pad-rgt10 pad-top10"><img src="<?php echo SITE_IMAGES;?>up-icon.gif" /></span>
                                        </div>
                                    </div>
                                    <div id="RSNeedSleepDivFullId" style="display:<?php if($txtneedsleep != "") {echo "none";} else if(isset($_COOKIE['showHideRSNeedSleepDivFullId']) && $_COOKIE['showHideRSNeedSleepDivFullId']=="block" && $txtneedsleep == ""){echo "block";} else {echo "none";}?>;">
                                        <div style="background-color:#009bd4; height:25px; vertical-align:middle; cursor:pointer;" onclick="SetCookie('showHideRSNeedSleepDivShortId', 'block');SetCookie('showHideRSNeedSleepDivFullId', 'none');showHideSection('RSNeedSleepDivFullId');showHideSection('RSNeedSleepDivShortId');">
                                            <span class="FloatLft pad-lft10 pad-top5" style="color:#ffffff; font-weight:bold;"><?php echo tranText('sleeps'); ?></span>
                                            <span class="FloatRgt pad-rgt10 pad-top10"><img src="<?php echo SITE_IMAGES;?>down-icon.gif" /></span>
                                        </div>
                                        <?php
                                        for($sleepCounter2 = 0; $sleepCounter2 < count($propertyComfortSleepArr); $sleepCounter2++) {
                                            echo "<div id=\"RSNeedSleepDivFullItemId".$sleepCounter2."\" style=\"display:block; padding:5px 10px 5px 10px;\"><a href=\"javascript:showHideSection('RSNeedSleepDivId');addMutualAccomTxt('RSNeedSleepDivId', 'Sleeps ".(int)($sleepCounter2+1)." or more', 'txtneedsleep','".(int)($sleepCounter2+1)."');Post.Send(document.getElementById('frmRefineSearch'));refineaccommodation();void(0);\" onMouseover=\"return hidestatus()\"  style=\"text-decoration:none;\"><strong>(+)</strong>&nbsp;<span class=\"blackText\">".$propertyComfortSleepArr[$sleepCounter2]['comfort_bed_text']."</span></a></div>";
                                        }
                                        ?>
                                    </div>
                                </div>                                            
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                        <?php
						/*
                        if(count($propertyHolidayTypeArr) > 0) {
                        ?>
                        <tr>
                            <td>
                                <div id="RSHolidayTypeDivId" style="display:block;">
                                    <div id="RSHolidayTypeDivShortId" style="display:<?php if(isset($_COOKIE['showHideRSHolidayTypeDivShortId']) && $_COOKIE['showHideRSHolidayTypeDivShortId']=="none" && $_COOKIE['showHideRSHolidayTypeDivFullId']=="block"){echo "none";} else {echo "block";}?>;">
                                        <div style="background-color:#ccffff; height:21px; width:188px; vertical-align:middle;">
                                            <span class="FloatLft font12-darkgrey pad-lft5"><?php echo tranText('holiday_type'); ?></span>
                                            <span class="FloatRgt pad-rgt10"><img src="<?php echo SITE_IMAGES;?>maximize-icon.gif" alt="Expand" onclick="SetCookie('showHideRSHolidayTypeDivFullId', 'block');SetCookie('showHideRSHolidayTypeDivShortId', 'none');showHideSection('RSHolidayTypeDivShortId');showHideSection('RSHolidayTypeDivFullId');" class="cursor" width="15" height="15" /></span>
                                        </div>
                                    </div>
                                    <div id="RSHolidayTypeDivFullId" style="display:<?php if(isset($_COOKIE['showHideRSHolidayTypeDivFullId']) && $_COOKIE['showHideRSHolidayTypeDivFullId']=="block"){echo "block";} else {echo "none";}?>;">
                                        <div style="background-color:#ccffff; height:21px; width:188px; vertical-align:middle;">
                                            <span class="FloatLft font12-darkgrey pad-lft5"><?php echo tranText('holiday_type'); ?></span>
                                            <span class="FloatRgt pad-rgt10"><img src="<?php echo SITE_IMAGES;?>minimize-icon.gif" alt="Expand" onclick="SetCookie('showHideRSHolidayTypeDivShortId', 'block');SetCookie('showHideRSHolidayTypeDivFullId', 'none');showHideSection('RSHolidayTypeDivFullId');showHideSection('RSHolidayTypeDivShortId');" class="cursor" width="15" height="15" /></span>
                                        </div>
                                        <?php
                                        for($HolidayTypeCounter = 0; $HolidayTypeCounter < count($propertyHolidayTypeArr); $HolidayTypeCounter++) {
                                            $property_holidaytype_name 	= ucfirst($propertyHolidayTypeArr[$HolidayTypeCounter]['property_holidaytype_name']);
                                            $facilityCounterDisplay2 = (is_array($txtholidaytypeidsArr) && in_array($propertyHolidayTypeArr[$HolidayTypeCounter]['property_holidaytype_id'], $txtholidaytypeidsArr))?"none":"block";
                                            echo "<div id=\"RSHolidayTypeDivFullItemId".$HolidayTypeCounter."\" style=\"display:".$facilityCounterDisplay2.";\"><a href=\"javascript:showHideSection('RSHolidayTypeDivShortItemId".$HolidayTypeCounter."');showHideSection('RSHolidayTypeDivFullItemId".$HolidayTypeCounter."');addNonMutualAccomTxt('RSHolidayTypeDivId', 'RSHolidayTypeDivFullItemId".$HolidayTypeCounter."', '".$property_holidaytype_name."', 'txtholidaytypeids','".$propertyHolidayTypeArr[$HolidayTypeCounter]['property_holidaytype_id']."');Post.Send(document.getElementById('frmRefineSearch'));refineaccommodation();void(0);\" onMouseover=\"return hidestatus()\"  style=\"text-decoration:none;\"><strong>(+)</strong>&nbsp;<span class=\"blackText\">".$property_holidaytype_name."</span></a></div>";
                                        }
                                        ?>
                                    </div>
                                </div>                                            
                            </td>
                        </tr>
                        <?php
                        }
						*/
                        ?>
                        <?php
                        if(count($propertyKitchenArr) > 0) {
                        ?>
                        <tr>
                            <td valign="middle" class="pad-btm2">
                                <div id="RSKitchenDivId" style="display:block;">
                                    <div id="RSKitchenDivShortId" style="display:<?php if(isset($_COOKIE['showHideRSKitchenDivShortId']) && $_COOKIE['showHideRSKitchenDivShortId']=="none" && $_COOKIE['showHideRSKitchenDivFullId']=="block"){echo "none";} else {echo "block";}?>;">
                                        <div style="background-color:#efefef; height:25px; vertical-align:middle; cursor:pointer;" onclick="SetCookie('showHideRSKitchenDivFullId', 'block');SetCookie('showHideRSKitchenDivShortId', 'none');showHideSection('RSKitchenDivShortId');showHideSection('RSKitchenDivFullId');">
                                            <span class="FloatLft pad-lft10 pad-top5" style="color:#009bd4; font-weight:bold;"><?php echo tranText('kitchen_linen'); ?></span>
                                            <span class="FloatRgt pad-rgt10 pad-top10"><img src="<?php echo SITE_IMAGES;?>up-icon.gif" /></span>
                                        </div>
                                    </div>
                                    <div id="RSKitchenDivFullId" style="display:<?php if(isset($_COOKIE['showHideRSKitchenDivFullId']) && $_COOKIE['showHideRSKitchenDivFullId']=="block"){echo "block";} else {echo "none";}?>;">
                                        <div style="background-color:#009bd4; height:25px; vertical-align:middle; cursor:pointer;" onclick="SetCookie('showHideRSKitchenDivShortId', 'block');SetCookie('showHideRSKitchenDivFullId', 'none');showHideSection('RSKitchenDivFullId');showHideSection('RSKitchenDivShortId');">
                                            <span class="FloatLft pad-lft10 pad-top5" style="color:#ffffff; font-weight:bold;"><?php echo tranText('kitchen_linen'); ?></span>
                                            <span class="FloatRgt pad-rgt10 pad-top10"><img src="<?php echo SITE_IMAGES;?>down-icon.gif" /></span>
                                        </div>
                                        <?php
                                        for($KitchenCounter = 0; $KitchenCounter < count($propertyKitchenArr); $KitchenCounter++) {
                                            $property_kitchen_name 	= ucfirst($propertyKitchenArr[$KitchenCounter]['property_kitchen_name']);
                                            $kitchenCounterDisplay2 = (is_array($txtkitchenlinenidsArr) && in_array($propertyKitchenArr[$KitchenCounter]['property_kitchen_id'], $txtkitchenlinenidsArr))?"none":"block";
                                            echo "<div id=\"RSKitchenDivFullItemId".$KitchenCounter."\" style=\"display:".$kitchenCounterDisplay2."; padding:5px 10px 5px 10px;\"><a href=\"javascript:showHideSection('RSKitchenDivFullItemId".$KitchenCounter."');showHideSection('RSKitchenDivFullItemId".$KitchenCounter."');addNonMutualAccomTxt('RSKitchenDivId', 'RSKitchenDivFullItemId".$KitchenCounter."', '".$property_kitchen_name."', 'txtkitchenlinenids','".$propertyKitchenArr[$KitchenCounter]['property_kitchen_id']."');Post.Send(document.getElementById('frmRefineSearch'));refineaccommodation();void(0);\" onMouseover=\"return hidestatus()\"  style=\"text-decoration:none;\"><strong>(+)</strong>&nbsp;<span class=\"blackText\">".$property_kitchen_name."</span></a></div>";
                                        } 
                                        ?>
                                    </div>
                                </div>                                            
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                        <?php
                        if(count($propertyOutsideArr) > 0) {
                        ?>
                        <tr>
                            <td valign="middle" class="pad-btm2">
                                <div id="RSOutsideDivId" style="display:block;">
                                    <div id="RSOutsideDivShortId" style="display:<?php if(isset($_COOKIE['showHideRSOutsideDivShortId']) && $_COOKIE['showHideRSOutsideDivShortId']=="none" && $_COOKIE['showHideRSOutsideDivFullId']=="block"){echo "none";} else {echo "block";}?>;">
                                        <div style="background-color:#efefef; height:25px; vertical-align:middle; cursor:pointer;" onclick="SetCookie('showHideRSOutsideDivFullId', 'block');SetCookie('showHideRSOutsideDivShortId', 'none');showHideSection('RSOutsideDivShortId');showHideSection('RSOutsideDivFullId');">
                                            <span class="FloatLft pad-lft10 pad-top5" style="color:#009bd4; font-weight:bold;"><?php echo tranText('outside'); ?></span>
                                            <span class="FloatRgt pad-rgt10 pad-top10"><img src="<?php echo SITE_IMAGES;?>up-icon.gif" /></span>
                                        </div>
                                    </div>
                                    <div id="RSOutsideDivFullId" style="display:<?php if(isset($_COOKIE['showHideRSOutsideDivFullId']) && $_COOKIE['showHideRSOutsideDivFullId']=="block"){echo "block";} else {echo "none";}?>;">
                                        <div style="background-color:#009bd4; height:25px; vertical-align:middle; cursor:pointer;" onclick="SetCookie('showHideRSOutsideDivShortId', 'block');SetCookie('showHideRSOutsideDivFullId', 'none');showHideSection('RSOutsideDivFullId');showHideSection('RSOutsideDivShortId');">
                                            <span class="FloatLft pad-lft10 pad-top5" style="color:#ffffff; font-weight:bold;"><?php echo tranText('outside'); ?></span>
                                            <span class="FloatRgt pad-rgt10 pad-top10"><img src="<?php echo SITE_IMAGES;?>down-icon.gif" /></span>
                                        </div>
                                        <?php
                                        for($OutsideCounter = 0; $OutsideCounter < count($propertyOutsideArr); $OutsideCounter++) {
                                            $property_outside_name 	= ucfirst($propertyOutsideArr[$OutsideCounter]['property_outside_name']);
                                            $OutsideCounterDisplay2 = (is_array($txtoutsideidsArr) && in_array($propertyOutsideArr[$OutsideCounter]['property_outside_id'], $txtoutsideidsArr))?"none":"block";
                                            echo "<div id=\"RSOutsideDivFullItemId".$OutsideCounter."\" style=\"display:".$OutsideCounterDisplay2."; padding:5px 10px 5px 10px;\"><a href=\"javascript:showHideSection('RSOutsideDivFullItemId".$OutsideCounter."');showHideSection('RSOutsideDivFullItemId".$OutsideCounter."');addNonMutualAccomTxt('RSOutsideDivId', 'RSOutsideDivFullItemId".$OutsideCounter."', '".$property_outside_name."', 'txtoutsideids','".$propertyOutsideArr[$OutsideCounter]['property_outside_id']."');Post.Send(document.getElementById('frmRefineSearch'));refineaccommodation();void(0);\" onMouseover=\"return hidestatus()\"  style=\"text-decoration:none;\"><strong>(+)</strong>&nbsp;<span class=\"blackText\">".$property_outside_name."</span></a></div>";
                                        } 
                                        ?>
                                    </div>
                                </div>                                            
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                        <?php
                        if(count($propertyActivitiesNearbyArr) > 0) {
                        ?>
                        <tr>
                            <td valign="middle" class="pad-btm2">
                                <div id="RSActivitiesNearbyDivId" style="display:block;">
                                    <div id="RSActivitiesNearbyDivShortId" style="display:<?php if(isset($_COOKIE['showHideRSActivitiesNearbyDivShortId']) && $_COOKIE['showHideRSActivitiesNearbyDivShortId']=="none" && $_COOKIE['showHideRSActivitiesNearbyDivFullId']=="block"){echo "none";} else {echo "block";}?>;">
                                        <div style="background-color:#efefef; height:25px; vertical-align:middle; cursor:pointer;" onclick="SetCookie('showHideRSActivitiesNearbyDivFullId', 'block');SetCookie('showHideRSActivitiesNearbyDivShortId', 'none');showHideSection('RSActivitiesNearbyDivShortId');showHideSection('RSActivitiesNearbyDivFullId');">
                                            <span class="FloatLft pad-lft10 pad-top5" style="color:#009bd4; font-weight:bold;"><?php echo tranText('activities_nearby'); ?></span>
                                            <span class="FloatRgt pad-rgt10 pad-top10"><img src="<?php echo SITE_IMAGES;?>up-icon.gif" /></span>
                                        </div>
                                    </div>
                                    <div id="RSActivitiesNearbyDivFullId" style="display:<?php if(isset($_COOKIE['showHideRSActivitiesNearbyDivFullId']) && $_COOKIE['showHideRSActivitiesNearbyDivFullId']=="block"){echo "block";} else {echo "none";}?>;">
                                        <div style="background-color:#009bd4; height:25px; vertical-align:middle; cursor:pointer;" onclick="SetCookie('showHideRSActivitiesNearbyDivShortId', 'block');SetCookie('showHideRSActivitiesNearbyDivFullId', 'none');showHideSection('RSActivitiesNearbyDivFullId');showHideSection('RSActivitiesNearbyDivShortId');">
                                            <span class="FloatLft pad-lft10 pad-top5" style="color:#ffffff; font-weight:bold;"><?php echo tranText('activities_nearby'); ?></span>
                                            <span class="FloatRgt pad-rgt10 pad-top10"><img src="<?php echo SITE_IMAGES;?>down-icon.gif" /></span>
                                        </div>
                                        <?php
                                        for($ActivitiesNearbyCounter = 0; $ActivitiesNearbyCounter < count($propertyActivitiesNearbyArr); $ActivitiesNearbyCounter++) {
                                            $property_activitiesnearby_name 	= ucfirst($propertyActivitiesNearbyArr[$ActivitiesNearbyCounter]['property_activitiesnearby_name']);
                                            $ActivitiesNearbyCounterDisplay2 = (is_array($txtactivitynearbyidsArr) && in_array($propertyActivitiesNearbyArr[$ActivitiesNearbyCounter]['property_activitiesnearby_id'], $txtactivitynearbyidsArr))?"none":"block";
                                            echo "<div id=\"RSActivitiesNearbyDivFullItemId".$ActivitiesNearbyCounter."\" style=\"display:".$ActivitiesNearbyCounterDisplay2."; padding:5px 10px 5px 10px;\"><a href=\"javascript:showHideSection('RSKitchenDivFullItemId".$ActivitiesNearbyCounter."');showHideSection('RSActivitiesNearbyDivFullItemId".$ActivitiesNearbyCounter."');addNonMutualAccomTxt('RSActivitiesNearbyDivId', 'RSActivitiesNearbyDivFullItemId".$ActivitiesNearbyCounter."', '".$property_activitiesnearby_name."', 'txtactivitynearbyids','".$propertyActivitiesNearbyArr[$ActivitiesNearbyCounter]['property_activitiesnearby_id']."');Post.Send(document.getElementById('frmRefineSearch'));refineaccommodation();void(0);\" onMouseover=\"return hidestatus()\"  style=\"text-decoration:none;\"><strong>(+)</strong>&nbsp;<span class=\"blackText\">".$property_activitiesnearby_name."</span></a></div>";
                                        } 
                                        ?>
                                    </div>
                                </div>                                            
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                        <?php
                        if(count($propertyEntertainmentArr) > 0) {
                        ?>
                        <tr>
                            <td valign="middle" class="pad-btm2">
                                <div id="RSEntertainmentDivId" style="display:block;">
                                    <div id="RSEntertainmentDivShortId" style="display:<?php if(isset($_COOKIE['showHideRSEntertainmentDivShortId']) && $_COOKIE['showHideRSEntertainmentDivShortId']=="none" && $_COOKIE['showHideRSEntertainmentDivFullId']=="block"){echo "none";} else {echo "block";}?>;">
                                        <div style="background-color:#efefef; height:25px; vertical-align:middle; cursor:pointer;" onclick="SetCookie('showHideRSEntertainmentDivFullId', 'block');SetCookie('showHideRSEntertainmentDivShortId', 'none');showHideSection('RSEntertainmentDivShortId');showHideSection('RSEntertainmentDivFullId');">
                                            <span class="FloatLft pad-lft10 pad-top5" style="color:#009bd4; font-weight:bold;"><?php echo tranText('entertainment'); ?></span>
                                            <span class="FloatRgt pad-rgt10 pad-top10"><img src="<?php echo SITE_IMAGES;?>up-icon.gif" /></span>
                                        </div>
                                    </div>
                                    <div id="RSEntertainmentDivFullId" style="display:<?php if(isset($_COOKIE['showHideRSEntertainmentDivFullId']) && $_COOKIE['showHideRSEntertainmentDivFullId']=="block"){echo "block";} else {echo "none";}?>;">
                                        <div style="background-color:#009bd4; height:25px; vertical-align:middle; cursor:pointer;" onclick="SetCookie('showHideRSEntertainmentDivShortId', 'block');SetCookie('showHideRSEntertainmentDivFullId', 'none');showHideSection('RSEntertainmentDivFullId');showHideSection('RSEntertainmentDivShortId');">
                                            <span class="FloatLft pad-lft10 pad-top5" style="color:#ffffff; font-weight:bold;"><?php echo tranText('entertainment'); ?></span>
                                            <span class="FloatRgt pad-rgt10 pad-top10"><img src="<?php echo SITE_IMAGES;?>down-icon.gif" /></span>
                                        </div>
                                        <?php
                                        for($EntertainmentCounter = 0; $EntertainmentCounter < count($propertyEntertainmentArr); $EntertainmentCounter++) {
                                            $property_entertainment_name 	= ucfirst($propertyEntertainmentArr[$EntertainmentCounter]['property_entertainment_name']);
                                            $EntertainmentCounterDisplay2 = (is_array($txtenterainmentidsArr) && in_array($propertyEntertainmentArr[$EntertainmentCounter]['property_entertainment_id'], $txtenterainmentidsArr))?"none":"block";
                                            echo "<div id=\"RSEntertainmentDivFullItemId".$EntertainmentCounter."\" style=\"display:".$EntertainmentCounterDisplay2."; padding:5px 10px 5px 10px;\"><a href=\"javascript:showHideSection('RSKitchenDivFullItemId".$EntertainmentCounter."');showHideSection('RSEntertainmentDivFullItemId".$EntertainmentCounter."');addNonMutualAccomTxt('RSEntertainmentDivId', 'RSEntertainmentDivFullItemId".$EntertainmentCounter."', '".$property_entertainment_name."', 'txtenterainmentids','".$propertyEntertainmentArr[$EntertainmentCounter]['property_entertainment_id']."');Post.Send(document.getElementById('frmRefineSearch'));refineaccommodation();void(0);\" onMouseover=\"return hidestatus()\"  style=\"text-decoration:none;\"><strong>(+)</strong>&nbsp;<span class=\"blackText\">".$property_entertainment_name."</span></a></div>";
                                        } 
                                        ?>
                                    </div>
                                </div>                                            
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                        <?php
						/*
                        if(count($propertyHeatingCoolingArr) > 0) {
                        ?>
                        <tr>
                            <td>
                                <div id="RSHeatingCoolingDivId" style="display:block;">
                                    <div id="RSHeatingCoolingDivShortId" style="display:<?php if(isset($_COOKIE['showHideRSHeatingCoolingDivShortId']) && $_COOKIE['showHideRSHeatingCoolingDivShortId']=="none" && $_COOKIE['showHideRSHeatingCoolingDivFullId']=="block"){echo "none";} else {echo "block";}?>;">
                                        <div style="background-color:#ccffff; height:21px; width:188px; vertical-align:middle;">
                                            <span class="FloatLft font12-darkgrey pad-lft5"><?php echo tranText('heating_cooling'); ?></span>
                                            <span class="FloatRgt pad-rgt10"><img src="<?php echo SITE_IMAGES;?>maximize-icon.gif" alt="Expand" onclick="SetCookie('showHideRSHeatingCoolingDivFullId', 'block');SetCookie('showHideRSHeatingCoolingDivShortId', 'none');showHideSection('RSHeatingCoolingDivShortId');showHideSection('RSHeatingCoolingDivFullId');" class="cursor" width="15" height="15" /></span>
                                        </div>
                                    </div>
                                    <div id="RSHeatingCoolingDivFullId" style="display:<?php if(isset($_COOKIE['showHideRSHeatingCoolingDivFullId']) && $_COOKIE['showHideRSHeatingCoolingDivFullId']=="block"){echo "block";} else {echo "none";}?>;">
                                        <div style="background-color:#ccffff; height:21px; width:188px; vertical-align:middle;">
                                            <span class="FloatLft font12-darkgrey pad-lft5"><?php echo tranText('heating_cooling'); ?></span>
                                            <span class="FloatRgt pad-rgt10"><img src="<?php echo SITE_IMAGES;?>minimize-icon.gif" alt="Expand" onclick="SetCookie('showHideRSHeatingCoolingDivShortId', 'block');SetCookie('showHideRSHeatingCoolingDivFullId', 'none');showHideSection('RSHeatingCoolingDivFullId');showHideSection('RSHeatingCoolingDivShortId');" class="cursor" width="15" height="15" /></span>
                                        </div>
                                        <?php
                                        for($HeatingCoolingCounter = 0; $HeatingCoolingCounter < count($propertyHeatingCoolingArr); $HeatingCoolingCounter++) {
                                            $property_heatingcooling_name 	= ucfirst($propertyHeatingCoolingArr[$HeatingCoolingCounter]['property_heatingcooling_name']);
                                            $HeatingCoolingCounterDisplay2 = (is_array($txtheatingcoolingidsArr) && in_array($propertyHeatingCoolingArr[$HeatingCoolingCounter]['property_heatingcooling_id'], $txtheatingcoolingidsArr))?"none":"block";
                                            echo "<div id=\"RSHeatingCoolingDivFullItemId".$HeatingCoolingCounter."\" style=\"display:".$HeatingCoolingCounterDisplay2.";\"><a href=\"javascript:showHideSection('RSKitchenDivFullItemId".$HeatingCoolingCounter."');showHideSection('RSHeatingCoolingDivFullItemId".$HeatingCoolingCounter."');addNonMutualAccomTxt('RSHeatingCoolingDivId', 'RSHeatingCoolingDivFullItemId".$HeatingCoolingCounter."', '".$property_heatingcooling_name."', 'txtheatingcoolingids','".$propertyHeatingCoolingArr[$HeatingCoolingCounter]['property_heatingcooling_id']."');Post.Send(document.getElementById('frmRefineSearch'));refineaccommodation();void(0);\" onMouseover=\"return hidestatus()\"  style=\"text-decoration:none;\"><strong>(+)</strong>&nbsp;<span class=\"blackText\">".$property_heatingcooling_name."</span></a></div>";
                                        } 
                                        ?>
                                    </div>
                                </div>                                            
                            </td>
                        </tr>
                        <?php
                        }
						*/
                        ?>
                        <?php
                        if(count($propertyLocationViewArr) > 0) {
                        ?>
                        <tr>
                            <td valign="middle" class="pad-btm2">
                                <div id="RSLocationViewDivId" style="display:block;">
                                    <div id="RSLocationViewDivShortId" style="display:<?php if(isset($_COOKIE['showHideRSLocationViewDivShortId']) && $_COOKIE['showHideRSLocationViewDivShortId']=="none" && $_COOKIE['showHideRSLocationViewDivFullId']=="block"){echo "none";} else {echo "block";}?>;">
                                        <div style="background-color:#efefef; height:25px; vertical-align:middle; cursor:pointer;" onclick="SetCookie('showHideRSLocationViewDivFullId', 'block');SetCookie('showHideRSLocationViewDivShortId', 'none');showHideSection('RSLocationViewDivShortId');showHideSection('RSLocationViewDivFullId');">
                                            <span class="FloatLft pad-lft10 pad-top5" style="color:#009bd4; font-weight:bold;"><?php echo tranText('location'); ?></span>
                                            <span class="FloatRgt pad-rgt10 pad-top10"><img src="<?php echo SITE_IMAGES;?>up-icon.gif" /></span>
                                        </div>
                                    </div>
                                    <div id="RSLocationViewDivFullId" style="display:<?php if(isset($_COOKIE['showHideRSLocationViewDivFullId']) && $_COOKIE['showHideRSLocationViewDivFullId']=="block"){echo "block";} else {echo "none";}?>;">
                                        <div style="background-color:#009bd4; height:25px; vertical-align:middle; cursor:pointer;" onclick="SetCookie('showHideRSLocationViewDivShortId', 'block');SetCookie('showHideRSLocationViewDivFullId', 'none');showHideSection('RSLocationViewDivFullId');showHideSection('RSLocationViewDivShortId');">
                                            <span class="FloatLft pad-lft10 pad-top5" style="color:#ffffff; font-weight:bold;"><?php echo tranText('location'); ?></span>
                                            <span class="FloatRgt pad-rgt10 pad-top10"><img src="<?php echo SITE_IMAGES;?>down-icon.gif" /></span>
                                        </div>
                                        <?php
                                        for($LocationViewCounter = 0; $LocationViewCounter < count($propertyLocationViewArr); $LocationViewCounter++) {
                                            $property_locationview_name 	= ucfirst($propertyLocationViewArr[$LocationViewCounter]['property_locationview_name']);
                                            $LocationViewCounterDisplay2 = (is_array($txtlocationviewidsArr) && in_array($propertyLocationViewArr[$LocationViewCounter]['property_locationview_id'], $txtlocationviewidsArr))?"none":"block";
                                            echo "<div id=\"RSLocationViewDivFullItemId".$LocationViewCounter."\" style=\"display:".$LocationViewCounterDisplay2."; padding:5px 10px 5px 10px;\"><a href=\"javascript:showHideSection('RSKitchenDivFullItemId".$LocationViewCounter."');showHideSection('RSLocationViewDivFullItemId".$LocationViewCounter."');addNonMutualAccomTxt('RSLocationViewDivId', 'RSLocationViewDivFullItemId".$LocationViewCounter."', '".$property_locationview_name."', 'txtlocationviewids','".$propertyLocationViewArr[$LocationViewCounter]['property_locationview_id']."');Post.Send(document.getElementById('frmRefineSearch'));refineaccommodation();void(0);\" onMouseover=\"return hidestatus()\"  style=\"text-decoration:none;\"><strong>(+)</strong>&nbsp;<span class=\"blackText\">".$property_locationview_name."</span></a></div>";
                                        } 
                                        ?>
                                    </div>
                                </div>                                            
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                        <?php
						/*
                        if(count($propertyServicesArr) > 0) {
                        ?>
                        <tr>
                            <td>
                                <div id="RSServicesDivId" style="display:block;">
                                    <div id="RSServicesDivShortId" style="display:<?php if(isset($_COOKIE['showHideRSServicesDivShortId']) && $_COOKIE['showHideRSServicesDivShortId']=="none" && $_COOKIE['showHideRSServicesDivFullId']=="block"){echo "none";} else {echo "block";}?>;">
                                        <div style="background-color:#ccffff; height:21px; width:188px; vertical-align:middle;">
                                            <span class="FloatLft font12-darkgrey pad-lft5"><?php echo tranText('services'); ?></span>
                                            <span class="FloatRgt pad-rgt10 "><img src="<?php echo SITE_IMAGES;?>maximize-icon.gif" alt="Expand" onclick="SetCookie('showHideRSServicesDivFullId', 'block');SetCookie('showHideRSServicesDivShortId', 'none');showHideSection('RSServicesDivShortId');showHideSection('RSServicesDivFullId');" class="cursor" width="15" height="15" /></span>
                                        </div>
                                    </div>
                                    <div id="RSServicesDivFullId" style="display:<?php if(isset($_COOKIE['showHideRSServicesDivFullId']) && $_COOKIE['showHideRSServicesDivFullId']=="block"){echo "block";} else {echo "none";}?>;">
                                        <div style="background-color:#ccffff; height:21px; width:188px; vertical-align:middle;">
                                            <span class="FloatLft font12-darkgrey pad-lft5"><?php echo tranText('services'); ?></span>
                                            <span class="FloatRgt pad-rgt10"><img src="<?php echo SITE_IMAGES;?>minimize-icon.gif" alt="Expand" onclick="SetCookie('showHideRSServicesDivShortId', 'block');SetCookie('showHideRSServicesDivFullId', 'none');showHideSection('RSServicesDivFullId');showHideSection('RSServicesDivShortId');" class="cursor" width="15" height="15" /></span>
                                        </div>
                                        <?php
                                        for($ServicesCounter = 0; $ServicesCounter < count($propertyServicesArr); $ServicesCounter++) {
                                            $property_services_name 	= ucfirst($propertyServicesArr[$ServicesCounter]['property_services_name']);
                                            $ServicesCounterDisplay2 = (is_array($txtserviceidsArr) && in_array($propertyServicesArr[$ServicesCounter]['property_services_id'], $txtserviceidsArr))?"none":"block";
                                            echo "<div id=\"RSServicesDivFullItemId".$ServicesCounter."\" style=\"display:".$ServicesCounterDisplay2.";\"><a href=\"javascript:showHideSection('RSKitchenDivFullItemId".$ServicesCounter."');showHideSection('RSServicesDivFullItemId".$ServicesCounter."');addNonMutualAccomTxt('RSServicesDivId', 'RSServicesDivFullItemId".$ServicesCounter."', '".$property_services_name."', 'txtserviceids','".$propertyServicesArr[$ServicesCounter]['property_services_id']."');Post.Send(document.getElementById('frmRefineSearch'));refineaccommodation();void(0);\" onMouseover=\"return hidestatus()\"  style=\"text-decoration:none;\"><strong>(+)</strong>&nbsp;<span class=\"blackText\">".$property_services_name."</span></a></div>";
                                        } 
                                        ?>
                                    </div>
                                </div>                                            
                            </td>
                        </tr>
                        <?php
                        }
						*/
                        ?>
                        <?php
                        if(count($propertyGeneralArr) > 0) {
                        ?>
                        <tr>
                            <td valign="middle">
                                <div id="RSGeneralDivId" style="display:block;">
                                    <div id="RSGeneralDivShortId" style="display:<?php if(isset($_COOKIE['showHideRSGeneralDivShortId']) && $_COOKIE['showHideRSGeneralDivShortId']=="none" && $_COOKIE['showHideRSGeneralDivFullId']=="block"){echo "none";} else {echo "block";}?>;">
                                        <div style="background-color:#efefef; height:25px; vertical-align:middle; cursor:pointer;" onclick="SetCookie('showHideRSGeneralDivFullId', 'block');SetCookie('showHideRSGeneralDivShortId', 'none');showHideSection('RSGeneralDivShortId');showHideSection('RSGeneralDivFullId');">
                                            <span class="FloatLft pad-lft10 pad-top5" style="color:#009bd4; font-weight:bold;"><?php echo tranText('general'); ?></span>
                                            <span class="FloatRgt pad-rgt10 pad-top10"><img src="<?php echo SITE_IMAGES;?>up-icon.gif" /></span>
                                        </div>
                                    </div>
                                    <div id="RSGeneralDivFullId" style="display:<?php if(isset($_COOKIE['showHideRSGeneralDivFullId']) && $_COOKIE['showHideRSGeneralDivFullId']=="block"){echo "block";} else {echo "none";}?>;">
                                        <div style="background-color:#009bd4; height:25px; vertical-align:middle; cursor:pointer;" onclick="SetCookie('showHideRSGeneralDivShortId', 'block');SetCookie('showHideRSGeneralDivFullId', 'none');showHideSection('RSGeneralDivFullId');showHideSection('RSGeneralDivShortId');">
                                            <span class="FloatLft pad-lft10 pad-top5" style="color:#ffffff; font-weight:bold;"><?php echo tranText('general'); ?></span>
                                            <span class="FloatRgt pad-rgt10 pad-top10"><img src="<?php echo SITE_IMAGES;?>down-icon.gif" /></span>
                                        </div>
                                        <?php
                                        for($GeneralCounter = 0; $GeneralCounter < count($propertyGeneralArr); $GeneralCounter++) {
                                            $property_general_name 	= ucfirst($propertyGeneralArr[$GeneralCounter]['property_general_name']);
                                            $GeneralCounterDisplay2 = (is_array($txtgeneralidsArr) && in_array($propertyGeneralArr[$GeneralCounter]['property_general_id'], $txtgeneralidsArr))?"none":"block";
                                            echo "<div id=\"RSGeneralDivFullItemId".$GeneralCounter."\" style=\"display:".$GeneralCounterDisplay2."; padding:5px 10px 5px 10px;\"><a href=\"javascript:showHideSection('RSKitchenDivFullItemId".$GeneralCounter."');showHideSection('RSGeneralDivFullItemId".$GeneralCounter."');addNonMutualAccomTxt('RSGeneralDivId', 'RSGeneralDivFullItemId".$GeneralCounter."', '".$property_general_name."', 'txtgeneralids','".$propertyGeneralArr[$GeneralCounter]['property_general_id']."');Post.Send(document.getElementById('frmRefineSearch'));refineaccommodation();void(0);\" onMouseover=\"return hidestatus()\"  style=\"text-decoration:none;\"><strong>(+)</strong>&nbsp;<span class=\"blackText\">".$property_general_name."</span></a></div>";
                                        } 
                                        ?>
                                    </div>
                                </div>                                            
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
            </td>
        </tr>
    </table>
</form>