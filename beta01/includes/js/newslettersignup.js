// JavaScript Document
var req = ajaxFunction(); 
function sendSignUpForNewsletterRequest(strEmail) { 
	req.open('get', 'includes/ajax/signupForNewsletterXml.php?email=' + strEmail); 
	req.onreadystatechange = handleSignUpForNewsletterResponse; 
	req.send(null); 
} 

function handleSignUpForNewsletterResponse() { 
	if(req.readyState == 4) { 
		var response = req.responseText; 
		xmlDoc=req.responseXML;
		//alert(req.responseXML);
		var root = xmlDoc.getElementsByTagName('progresses')[0];
		if(root != null) {
			var items = root.getElementsByTagName("progress");
			var item = items[0];
			var status = item.getElementsByTagName("status")[0].firstChild.nodeValue;
			if(status == "done"){
				document.getElementById("displayfrmId").style.display = "none";
				document.getElementById("displaythanksId").style.display = "block";
			} else if(status == "exist"){
				document.getElementById("displayfrmId").style.display = "none";
				document.getElementById("displayuserexistId").style.display = "block";
			} else {
				document.getElementById("showNewsLetterSignUpError").innerHTML = "<span style=\"font-size:12px; color:#FF0000; font-weight:bold;\">Error, please try again</span>";
			}
		} else {
			document.getElementById("showNewsLetterSignUpError").innerHTML = "<span style=\"font-size:12px; color:#FF0000; font-weight:bold;\">Error, please try again</span>";
		}
	} else {
		document.getElementById("showNewsLetterSignUpError").innerHTML = "<span style=\"font-size:12px; color:#FF0000; font-weight:bold;\">Please Wait...</span>";
	}
} 

function validateSignUpForNewsletters(){
	if((document.getElementById("txtEmailId").value == "Enter your email address") || (document.getElementById("txtEmailId").value == "")){
		document.getElementById("showNewsLetterSignUpError").innerHTML = "<span style=\"font-size:12px; color:#FF0000; font-weight:bold;\">Invalid email address, please try again</span>";
		document.getElementById("txtEmailId").value = "";
		document.getElementById("txtEmailId").focus();
		return false;
	} else {
		var emailRegxp = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if (emailRegxp.test(document.getElementById("txtEmailId").value)!= true){
			document.getElementById("showNewsLetterSignUpError").innerHTML = "<span style=\"font-size:12px; color:#FF0000; font-weight:bold;\">Invalid email address, please try again</span>";
			document.getElementById("txtEmailId").value = "";
			document.getElementById("txtEmailId").focus();
			return false;
		}
	}
	var strEmail = document.getElementById("txtEmailId").value;
	sendSignUpForNewsletterRequest(strEmail);
}

function bnkEmail() {
	if((document.getElementById("txtEmailId").value = "Enter your email address") || (document.getElementById("txtEmailId").value = "")){
		document.getElementById("txtEmailId").value = "";
	}
}

function restoreEmail(){
	var str = document.getElementById("txtEmailId").value;
	if(str == "" ) {
		document.getElementById("txtEmailId").value = "Enter your email address";
		return false;
	}
}

function checksignupEnter(e){ //e is event object passed from function invocation
	var characterCode; //literal character code will be stored in this variable
	if(e && e.which) { //if which property of event object is supported (NN4)
		e = e;
		characterCode = e.which; //character code is contained in NN4's which property
	} else {
		e = event;
		characterCode = e.keyCode; //character code is contained in IE's keyCode property
	}
	if(characterCode == 13){ //if generated character code is equal to ascii 13 (if enter key)
		return validateSignUpForNewsletters(); //submit the form
	} else {
		return true;
	}
}
