// JavaScript Document

/* --------- Script for Owner profile and settings : start here ----------- */
function addAnotherNumber() {
	if(document.getElementById("addanothernumberId_0").style.display == "none") {
		document.getElementById("addanothernumberId_0").style.display = "block";
	} else if(document.getElementById("addanothernumberId_1").style.display == "none") {
		document.getElementById("addanothernumberId_1").style.display = "block";
	} else if(document.getElementById("addanothernumberId_2").style.display == "none") {
		document.getElementById("addanothernumberId_2").style.display = "block";
	} else if(document.getElementById("addanothernumberId_3").style.display == "none") {
		document.getElementById("addanothernumberId_3").style.display = "block";
	}  
}

function addAnotherLanguage() {
	if(document.getElementById("addanotherlanguageId_0").style.display == "none") {
		document.getElementById("addanotherlanguageId_0").style.display = "block";
	} else if(document.getElementById("addanotherlanguageId_1").style.display == "none") {
		document.getElementById("addanotherlanguageId_1").style.display = "block";
	} else if(document.getElementById("addanotherlanguageId_2").style.display == "none") {
		document.getElementById("addanotherlanguageId_2").style.display = "block";
	} else if(document.getElementById("addanotherlanguageId_3").style.display == "none") {
		document.getElementById("addanotherlanguageId_3").style.display = "block";
	}  
}

/* --------- Script for Owner profile and settings : end here ----------- */

// function for delete owner contact language
function delOwnrContactLanguage(strid){
	if(parseInt(strid) != 0) {
		var txtContactLanguageId = "txtContactLanguageId"+strid;
		var addanotherlanguageId = "addanotherlanguageId"+strid;
	
		document.getElementById(txtContactLanguageId).value = "";
		document.getElementById(addanotherlanguageId).style.display = "none";
	}
}

// function for delete owner contact numbers
function delOwnrContactNumber(strid){
	if(parseInt(strid) != 0) {
		var txtContactNumberTypeId = "txtContactNumberTypeId"+strid;
		var txtContactCountryId = "txtContactCountryId"+strid;
		var txtContactNumberId = "txtContactNumberId"+strid;
		var addanothernumberId = "addanothernumberId"+strid;
	
		document.getElementById(txtContactNumberTypeId).value = "";
		document.getElementById(txtContactCountryId).value = "";
		document.getElementById(txtContactNumberId).value = "";
		document.getElementById(addanothernumberId).style.display = "none";
	}
}
/* --------- Script for Owner left links : start here ----------- */
function showHideOptionTab(strShowId){
	var strShowId = strShowId;
	showHideSection(strShowId);
	var strdisplay = document.getElementById(strShowId).style.display;
	SetCookie ("showHideOptionTab", strdisplay);
}

function changeOptionImageSrc(strSrc, strId){
	var strSrc = strSrc;
	var strId = strId;
	if(strSrc.indexOf("images/options-left-close.gif") != -1){
		document.getElementById(strId).src = "images/options-left-open.gif";
	}
	else if(strSrc.indexOf("images/options-left-open.gif") != -1){
		document.getElementById(strId).src = "images/options-left-close.gif";
	}
}
/* --------- Script for Owner left links : end here ----------- */

/* --------- Script for Owner general : start here ----------- */
// function for roll over effect : Start here

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
// function for roll over effect : End here


// Show Hide functions: Start here
function showHideSection(strShowId){
	var strShowId = strShowId;
	if(document.getElementById(strShowId).style.display == "none"){
		document.getElementById(strShowId).style.display = "block";
	}
	else if(document.getElementById(strShowId).style.display == "block"){
		document.getElementById(strShowId).style.display = "none";
	}
}
// Show Hide functions: End here

// Cookies functions : Start here
function GetCookie(c_name){
	if (document.cookie.length>0){
		c_start=document.cookie.indexOf(c_name + "=");
		if (c_start!=-1){ 
			c_start=c_start + c_name.length+1; 
			c_end=document.cookie.indexOf(";",c_start);
			if (c_end==-1) c_end=document.cookie.length;
			return unescape(document.cookie.substring(c_start,c_end));
		} 
	}
return "";
}

function DelCookie( name, path, domain ) {
	if ( GetCookie( name ) ) document.cookie = name + "=" +
	( ( path ) ? ";path=" + path : "") +
	( ( domain ) ? ";domain=" + domain : "" ) +
	";expires=Thu, 01-Jan-1970 00:00:01 GMT";
}

function SetCookie (name, value) {
  var expMins = 5;
  var exp = new Date(); 
  exp.setTime(exp.getTime() + (expMins*60*1000));
  expirationDate = exp.toGMTString();
  document.cookie = name + "=" + escape(value)
  document.cookie += "; expires=" + expirationDate;
}
// Cookies functions : End here


function showField(strId){
	var strId = strId;
	document.getElementById(strId).style.display = "block";
}

function hideField(strId){
	var strId = strId;
//	alert(strId);
	document.getElementById(strId).style.display = "none";
}

function limitText(limitField, limitCount, limitNum)
{
	if (limitField.value.length > limitNum){
		limitField.value = limitField.value.substring(0, limitNum);
	}
	else{
		limitCount.value = limitNum - limitField.value.length;
	}
}
// Remove space from text fields
function rm_trim(inputString){
	if (typeof inputString != "string") { return inputString;}

	var temp_str = '';
	temp_str = inputString.replace(/[\s]+/g,"");
	if(temp_str == '')
		return "";
	
	var retValue = inputString;
	var ch = retValue.substring(0, 1);
	while (ch == " "){
		retValue = retValue.substring(1, retValue.length);
		ch = retValue.substring(0, 1);
	}
	ch = retValue.substring(retValue.length-1, retValue.length);
	while (ch == " "){
		retValue = retValue.substring(0, retValue.length-1);
		ch = retValue.substring(retValue.length-1, retValue.length);
	}
	while (retValue.indexOf("  ") != -1){
	  retValue = retValue.substring(0, retValue.indexOf("  ")) + retValue.substring(retValue.indexOf("  ")+1, retValue.length);
	}
	return retValue;
}

// tab menu opener
function open_div(mainDiv, sourceDiv)
{
	if (document.getElementById(mainDiv) && document.getElementById(sourceDiv))
	{
		document.getElementById(mainDiv).innerHTML = document.getElementById(sourceDiv).innerHTML;
	}
}
/* --------- Script for Owner general : end here ----------- */
