// JavaScript Document

var statusmsg="";
var newWin = null;
var childwindow = null;
var yourLink = null;

function hidestatus(){
	window.status=statusmsg;
	return true;
}

/* --------- Script for Enter number blank: start here ----------- */
function bnkEntNumber() {
	if((document.getElementById("txtContactNumberId").value.indexOf("Enter Number") != -1) || (document.getElementById("txtContactNumberId").value == "")){
		document.getElementById("txtContactNumberId").value = "";
	}
}
/* --------- Script for Enter number blank: start here ----------- */

/* --------- Script for Enter number restore: start here ----------- */
function restoreEntNumber(){
	var str = document.getElementById("txtContactNumberId").value;
	if(str == "" ) {
		document.getElementById("txtContactNumberId").value = "Enter Number";
		return false;
	}
}
/* --------- Script for Enter number restore: start here ----------- */

/* --------- Script for travel guide image caption blank: start here ----------- */
function bnkEvntImgCaption() {
	if((document.getElementById("txtEvntPhotoCaptionId").value.indexOf("Add caption for image ...") != -1) || (document.getElementById("txtEvntPhotoCaptionId").value == "")){
		document.getElementById("txtEvntPhotoCaptionId").value = "";
	}
}
/* --------- Script for travel guide image caption blank: start here ----------- */

/* --------- Script for travel guide image caption blank: start here ----------- */
function restoreEvntImgCaption(){
	var str = document.getElementById("txtEvntPhotoCaptionId").value;
	if(str == "" ) {
		document.getElementById("txtEvntPhotoCaptionId").value = "Add caption for image ...";
		document.getElementById("txtEvntPhotoCaptionId").value += "\nLeave blank if not required";
		return false;
	}
}
/* --------- Script for travel guide image caption blank: start here ----------- */


/* --------- Script for Event / listing title blank: start here ----------- */
function bnkEventTitle() {
	if((document.getElementById("txtEventNameId").value == "This will appear on search listings") || (document.getElementById("txtEventNameId").value == "")){
		document.getElementById("txtEventNameId").value = "";
	}
}
/* --------- Script for Event / listing title blank: start here ----------- */

/* --------- Script for Event / listing title blank: start here ----------- */
function restoreEventTitle(){
	var str = document.getElementById("txtEventNameId").value;
	if(str == "" ) {
		document.getElementById("txtEventNameId").value = "This will appear on search listings";
		return false;
	}
}
/* --------- Script for Event / listing title blank: start here ----------- */

/* --------- Script for Promotional Code Text blank: start here ----------- */
function bnkPromotionalCode() {
	if((document.getElementById("txtPromotionalCodeId").value == "Enter promo code here") || (document.getElementById("txtPromotionalCodeId").value == "")){
		document.getElementById("txtPromotionalCodeId").value = "";
	}
}
/* --------- Script for Promotional Code Text blank: start here ----------- */

/* --------- Script for Promotional Code Text blank: start here ----------- */
function restorePromotionalCode(){
	var str = document.getElementById("txtPromotionalCodeId").value;
	if(str == "" ) {
		document.getElementById("txtPromotionalCodeId").value = "Enter promo code here";
		return false;
	}
}
/* --------- Script for Promotional Code Text blank: start here ----------- */

/* --------- Script for Event / listing time blank: start here ----------- */
function bnkEventTime() {
	if((document.getElementById("txtEventTimeId").value == "eg opening times or show times") || (document.getElementById("txtEventTimeId").value == "")){
		document.getElementById("txtEventTimeId").value = "";
	}
}
/* --------- Script for Event / listing title blank: start here ----------- */

/* --------- Script for Event / listing title blank: start here ----------- */
function restoreEventTime(){
	var str = document.getElementById("txtEventTimeId").value;
	if(str == "" ) {
		document.getElementById("txtEventTimeId").value = "eg opening times or show times";
		return false;
	}
}
/* --------- Script for Event / listing time blank: start here ----------- */

/* --------- Script for Event / listing price blank: start here ----------- */
function bnkEventPrice() {
	if((document.getElementById("txtEventPriceId").value == "These will appear exactly as typed") || (document.getElementById("txtEventPriceId").value == "")){
		document.getElementById("txtEventPriceId").value = "";
	}
}
/* --------- Script for Event / listing title blank: start here ----------- */

/* --------- Script for Event / listing title blank: start here ----------- */
function restoreEventPrice(){
	var str = document.getElementById("txtEventPriceId").value;
	if(str == "" ) {
		document.getElementById("txtEventPriceId").value = "These will appear exactly as typed";
		return false;
	}
}
/* --------- Script for Event / listing price blank: start here ----------- */

/* --------- Script for home location search : start here ----------- */
function bnkLocSearch(){
	if((document.getElementById("SearchLocFld1").value == "eg Camps Bay or Cape Town ...") || (document.getElementById("SearchLocFld1").value == "")){
		document.getElementById("SearchLocFld1").value = "";
	}
}
function bnkLocSearch1(){
	if((document.getElementById("SearchLocFld1").value == "eg Camps Bay or Cape Town ...") || (document.getElementById("SearchLocFld1").value == "")){
		document.getElementById("SearchLocFld1").value = "";
	}
}


function restoreLocSearch(){
	var str = document.getElementById("SearchLocFld1").value;
	if(str == "" ){
		document.getElementById("SearchLocFld1").value = "eg Camps Bay or Cape Town ...";
		return false;
	}
}
/* --------- Script for home location search : start here ----------- */

/* --------- Script for home location search : start here ----------- */
function bnkAdvSearch(){
	if((document.getElementById("destinations").value == "eg Camps Bay or Cape Town ...") || (document.getElementById("destinations").value == "")){
		document.getElementById("destinations").value = "";
	}
}

function restoreAdvSearch(){
	var str = document.getElementById("destinations").value;
	if(str == "" ){
		document.getElementById("destinations").value = "eg Camps Bay or Cape Town ...";
		return false;
	}
}
/* --------- Script for home location search : start here ----------- */

/* --------- Script for home location search : start here ----------- */
function bnkTellOurFriendSubject(){
	if((document.getElementById("txtUserSubjectId").value == "Check out this great site") || (document.getElementById("txtUserSubjectId").value == "")){
		document.getElementById("txtUserSubjectId").value = "";
	}
}

function restoreTellOurFriendSubject(){
	var str = document.getElementById("txtUserSubjectId").value;
	if(str == "" ){
		document.getElementById("txtUserSubjectId").value = "Check out this great site";
		return false;
	}
}
/* --------- Script for home location search : start here ----------- */

/* --------- Script for home location search : start here ----------- */
function bnkKeywordSearch(){
	if((document.getElementById("SearchLocFld1").value == "Type where you’d like to stay eg. Camps Bay") || (document.getElementById("SearchLocFld1").value == "")){
		document.getElementById("SearchLocFld1").value = "";
	}
}

function restoreKeywordSearch(){
	var str = document.getElementById("SearchLocFld1").value;
	if(str == "" ){
		document.getElementById("SearchLocFld1").value = "Type where you’d like to stay eg. Camps Bay";
		return false;
	}
}
/* --------- Script for home location search : start here ----------- */

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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

function MM_openWindow(theURL,winName,features) {
	if (!childwindow) {
		childwindow = window.open(theURL,winName,features);
	} else {
		if(!childwindow.focus()) {
			childwindow = window.open(theURL,winName,features);
		}
	}
}

// function for roll over effect : End here


// Show Hide functions: Start here
function showHideSection(strShowId){
	var strShowId = strShowId;
//	alert(strShowId);
	if(document.getElementById(strShowId)) {
		if(document.getElementById(strShowId).style.display == "none"){
			document.getElementById(strShowId).style.display = "block";
		}
		else if(document.getElementById(strShowId).style.display == "block"){
			document.getElementById(strShowId).style.display = "none";
		}
   }
}
// Show Hide functions: End here

// Show Hide Refind Search functions: Start here
function changeRSLocImageSrc(strSrc, strId){
	var strSrc = strSrc;
	var strId = strId;
	if(strSrc.indexOf("images/maximize-icon.gif") != -1){
		document.getElementById(strId).src = "images/minimize-icon.gif";
	}
	else if(strSrc.indexOf("images/minimize-icon.gif") != -1){
		document.getElementById(strId).src = "images/maximize-icon.gif";
	}
}

function changeRSDateImageSrc(strSrc, strId){
	var strSrc = strSrc;
	var strId = strId;
	if(strSrc.indexOf("images/maximize-icon.gif") != -1){
		document.getElementById(strId).src = "images/minimize-icon.gif";
	}
	else if(strSrc.indexOf("images/minimize-icon.gif") != -1){
		document.getElementById(strId).src = "images/maximize-icon.gif";
	}
}

function changeRSAccomImageSrc(strSrc, strId){
	var strSrc = strSrc;
	var strId = strId;
	if(strSrc.indexOf("images/maximize-icon.gif") != -1){
		document.getElementById(strId).src = "images/minimize-icon.gif";
	}
	else if(strSrc.indexOf("images/minimize-icon.gif") != -1){
		document.getElementById(strId).src = "images/maximize-icon.gif";
	}
}

function showHideRSMenus(strShowId){
	var strShowId = strShowId;
	var strCookie = "showHide"+strShowId;
	showHideSection(strShowId);
	var strdisplay = document.getElementById(strShowId).style.display;
	SetCookie (strCookie, strdisplay);
}
// Show Hide Refind Search functions: End here

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
	var expMins = 1440;
	var exp = new Date(); 
	exp.setTime(exp.getTime() + (expMins*60*1000));
	expirationDate = exp.toGMTString();
	document.cookie = name + "=" + escape(value)
	document.cookie += "; expires=" + expirationDate;
}
// Cookies functions : End here


function showField(strId){
	var strId = strId;
	if(document.getElementById(strId)) {
		document.getElementById(strId).style.display = "block";
	}
}

function hideField(strId){
	var strId = strId;
	if(document.getElementById(strId)) {
		document.getElementById(strId).style.display = "none";
	}
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

function str_replace(search, replace, subject) {
    // http://kevin.vanzonneveld.net
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Gabriel Paderni
    // +   improved by: Philip Peterson
    // +   improved by: Simon Willison (http://simonwillison.net)
    // +    revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // +   bugfixed by: Anton Ongson
    // +      input by: Onno Marsman
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +    tweaked by: Onno Marsman
    // *     example 1: str_replace(' ', '.', 'Kevin van Zonneveld');
    // *     returns 1: 'Kevin.van.Zonneveld'
    // *     example 2: str_replace(['{name}', 'l'], ['hello', 'm'], '{name}, lars');
    // *     returns 2: 'hemmo, mars'
 
    var f = search, r = replace, s = subject;
    var ra = r instanceof Array, sa = s instanceof Array, f = [].concat(f), r = [].concat(r), i = (s = [].concat(s)).length;
 
    while (j = 0, i--) {
        if (s[i]) {
            while (s[i] = s[i].split(f[j]).join(ra ? r[j] || "" : r[0]), ++j in f){};
        }
    };
 
    return sa ? s : s[0];
}
function stripslashes( str ) {
    // http://kevin.vanzonneveld.net
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Ates Goral (http://magnetiq.com)
    // +      fixed by: Mick@el
    // +   improved by: marrtins
    // +   bugfixed by: Onno Marsman
    // +   improved by: rezna
    // *     example 1: stripslashes('Kevin\'s code');
    // *     returns 1: "Kevin's code"
    // *     example 2: stripslashes('Kevin\\\'s code');
    // *     returns 2: "Kevin\'s code"
 
    return (str+'').replace(/\0/g, '0').replace(/\\([\\'"])/g, '$1');
}

function ajaxFunction(){
	var xmlHttp;
	try{
		// Firefox, Opera 8.0+, Safari
		xmlHttp = new XMLHttpRequest();
	}catch (e){
		// Internet Explorer
		try{
			xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
		}catch (e){
			try{
				xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
			}catch (e){
				alert("Your browser does not support AJAX!");
				return false;
			}
		}
	}
	return xmlHttp;
 }

/********************** For Language Translation: Start *****************/
function setLang(langCode) {
	if(langCode != '') {
		var http = ajaxFunction();
		http.onreadystatechange = function(){
			if(http.readyState == 4){
				// Get the data from the server's response
				var response = http.responseText;
				if(response == 'success') {
					location.href = window.location;
				} else {
					return false;
				}
			}
		}
		http.open('get', 'setSiteLang.php?lang=' + langCode); 
		http.send(null); 
	}
}
/********************** For Language Translation: End *****************/
