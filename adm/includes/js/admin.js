// JavaScript Document
var statusmsg="";
var newWin = null;
var childwindow = null;
var yourLink = null;

function hidestatus(){
	window.status=statusmsg
	return true
}

/* --------- Script for sort list links : start here ----------- */
function sortList(str){
//	alert(str);
	location.href = str;
}
/* --------- Script for sort list links : end here ----------- */

/* --------- Script for tvl guid search : start here ----------- */
function bnkEvntPhotoLink(){
	if((document.getElementById("txtEvntPhotoLinkId").value == "http://") || (document.getElementById("txtEvntPhotoLinkId").value == "")){
		document.getElementById("txtEvntPhotoLinkId").value = "";
	}
}

function restoreEvntPhotoLink(){
	var str = document.getElementById("txtEvntPhotoLinkId").value;
	if(str == "" ){
		document.getElementById("txtEvntPhotoLinkId").value = "http://";
		return false;
	}
}
/* --------- Script for tvl guid search : start here ----------- */

/* --------- Script for tvl guid search : start here ----------- */
function bnkEvntPhotoBy(){
	if((document.getElementById("txtEvntPhotoById").value == "Photo by") || (document.getElementById("txtEvntPhotoById").value == "")){
		document.getElementById("txtEvntPhotoById").value = "";
	}
}

function restoreEvntPhotoBy(){
	var str = document.getElementById("txtEvntPhotoById").value;
	if(str == "" ){
		document.getElementById("txtEvntPhotoById").value = "Photo by";
		return false;
	}
}
/* --------- Script for tvl guid search : start here ----------- */

/* --------- Script for tvl guid search : start here ----------- */
function bnkTvlGuidPhotoLink(strId){
	if((document.getElementById("txtTvlGuidPhotoLinkId"+strId).value == "http://") || (document.getElementById("txtTvlGuidPhotoLinkId"+strId).value == "")){
		document.getElementById("txtTvlGuidPhotoLinkId"+strId).value = "";
	}
}

function restoreTvlGuidPhotoLink(strId){
	var str = document.getElementById("txtTvlGuidPhotoLinkId"+strId).value;
	if(str == "" ){
		document.getElementById("txtTvlGuidPhotoLinkId"+strId).value = "http://";
		return false;
	}
}
/* --------- Script for tvl guid search : start here ----------- */

/* --------- Script for tvl guid search : start here ----------- */
function bnkTvlGuidPhotoBy(strId){
	if((document.getElementById("txtTvlGuidPhotoById"+strId).value == "Photo by") || (document.getElementById("txtTvlGuidPhotoById"+strId).value == "")){
		document.getElementById("txtTvlGuidPhotoById"+strId).value = "";
	}
}

function restoreTvlGuidPhotoBy(strId){
	var str = document.getElementById("txtTvlGuidPhotoById"+strId).value;
	if(str == "" ){
		document.getElementById("txtTvlGuidPhotoById"+strId).value = "Photo by";
		return false;
	}
}
/* --------- Script for tvl guid search : start here ----------- */

/* --------- Script for tvl guid search : start here ----------- */
function bnkPromoSearch(){
	if((document.getElementById("txtSearchPromoId").value == "Enter promo code") || (document.getElementById("txtSearchTvlGuidId").value == "")){
		document.getElementById("txtSearchPromoId").value = "";
	}
}

function restorePromoSearch(){
	var str = document.getElementById("txtSearchPromoId").value;
	if(str == "" ){
		document.getElementById("txtSearchPromoId").value = "Enter promo code";
		return false;
	}
}
/* --------- Script for tvl guid search : start here ----------- */

/* --------- Script for tvl guid search : start here ----------- */
function bnkTvlGuidSearch(){
	if((document.getElementById("txtSearchTvlGuidId").value == "Enter reference") || (document.getElementById("txtSearchTvlGuidId").value == "")){
		document.getElementById("txtSearchTvlGuidId").value = "";
	}
}

function restoreTvlGuidSearch(){
	var str = document.getElementById("txtSearchTvlGuidId").value;
	if(str == "" ){
		document.getElementById("txtSearchTvlGuidId").value = "Enter reference";
		return false;
	}
}
/* --------- Script for tvl guid search : start here ----------- */

/* --------- Script for Admin left links : start here ----------- */
function changeGeneralMenusImageSrc(strSrc, strId){
	var strSrc = strSrc;
	var strId = strId;
	if(strSrc.indexOf("images/General-close.gif") != -1){
		document.getElementById(strId).src = "images/General-open.gif";
	}
	else if(strSrc.indexOf("images/General-open.gif") != -1){
		document.getElementById(strId).src = "images/General-close.gif";
	}
}

function changeUAMenusImageSrc(strSrc, strId){
	var strSrc = strSrc;
	var strId = strId;
	if(strSrc.indexOf("images/UserAccess-close.gif") != -1){
		document.getElementById(strId).src = "images/UserAccess-open.gif";
	}
	else if(strSrc.indexOf("images/UserAccess-open.gif") != -1){
		document.getElementById(strId).src = "images/UserAccess-close.gif";
	}
}

function changeCRMMenusImageSrc(strSrc, strId){
	var strSrc = strSrc;
	var strId = strId;
	if(strSrc.indexOf("images/CRM-close.gif") != -1){
		document.getElementById(strId).src = "images/CRM-open.gif";
	}
	else if(strSrc.indexOf("images/CRM-open.gif") != -1){
		document.getElementById(strId).src = "images/CRM-close.gif";
	}
}

function changeStatsMenusImageSrc(strSrc, strId){
	var strSrc = strSrc;
	var strId = strId;
	if(strSrc.indexOf("images/Statistics-close.gif") != -1){
		document.getElementById(strId).src = "images/Statistics-open.gif";
	}
	else if(strSrc.indexOf("images/Statistics-open.gif") != -1){
		document.getElementById(strId).src = "images/Statistics-close.gif";
	}
}

function changeSVMenusImageSrc(strSrc, strId){
	var strSrc = strSrc;
	var strId = strId;
	if(strSrc.indexOf("images/SiteVariables-close.gif") != -1){
		document.getElementById(strId).src = "images/SiteVariables-open.gif";
	}
	else if(strSrc.indexOf("images/SiteVariables-open.gif") != -1){
		document.getElementById(strId).src = "images/SiteVariables-close.gif";
	}
}

function changeCMSMenusImageSrc(strSrc, strId){
	var strSrc = strSrc;
	var strId = strId;
	if(strSrc.indexOf("images/cms_straight.jpg") != -1){
		document.getElementById(strId).src = "images/cms_down.jpg";
	}else if(strSrc.indexOf("images/cms_down.jpg") != -1){
		document.getElementById(strId).src = "images/cms_straight.jpg";
	}
}

function changeColMenusImageSrc(strSrc, strId){
	var strSrc = strSrc;
	var strId = strId;
	if(strSrc.indexOf("images/Collateral-close.gif") != -1){
		document.getElementById(strId).src = "images/Collateral-open.gif";
	}
	else if(strSrc.indexOf("images/Collateral-open.gif") != -1){
		document.getElementById(strId).src = "images/Collateral-close.gif";
	}
}

function changePAMenusImageSrc(strSrc, strId){
	var strSrc = strSrc;
	var strId = strId;
	if(strSrc.indexOf("images/PendingApproval-close.gif") != -1){
		document.getElementById(strId).src = "images/PendingApproval-open.gif";
	}
	else if(strSrc.indexOf("images/PendingApproval-open.gif") != -1){
		document.getElementById(strId).src = "images/PendingApproval-close.gif";
	}
}

function showHideAdminMenus(strShowId){
	var strShowId = strShowId;
	var strCookie = "showHide"+strShowId;
	showHideSection(strShowId);
	var strdisplay = document.getElementById(strShowId).style.display;
	SetCookie (strCookie, strdisplay);
}



/*
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
*/
/* --------- Script for Admin left links : end here ----------- */

/* --------- Script for Admin general : start here ----------- */
// function for roll over effect : Start here
/*
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
*/
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
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
  var expMins = 60*24;
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
	document.getElementById(strId).style.display = "none";
}

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

/* --------- Script for travel guide image caption blank: start here ----------- */
function bnkTvlGuidImgCaption(strId) {
	if((document.getElementById("txtTvlGuidPhotoCaptionId"+strId).value.indexOf("Add caption for image ...") != -1) || (document.getElementById("txtTvlGuidPhotoCaptionId"+strId).value == "")){
		document.getElementById("txtTvlGuidPhotoCaptionId"+strId).value = "";
	}
}
/* --------- Script for travel guide image caption blank: start here ----------- */

/* --------- Script for travel guide image caption blank: start here ----------- */
function restoreTvlGuidImgCaption(strId){
	var str = document.getElementById("txtTvlGuidPhotoCaptionId"+strId).value;
	if(str == "" ) {
		document.getElementById("txtTvlGuidPhotoCaptionId"+strId).value = "Add caption for image ...";
		document.getElementById("txtTvlGuidPhotoCaptionId"+strId).value += "\nLeave blank if not required";
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
/* --------- Script for Admin general : end here ----------- */

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
