// JavaScript Document
function bnkSearch(){
	if((document.getElementById("SearchFld1").value = "Search") || (document.getElementById("SearchFld1").value = "")){
		document.getElementById("SearchFld1").value = "";
	}
}

function restoreSearch(){
	var str = document.getElementById("SearchFld1").value;
	if(str == "" ){
		document.getElementById("SearchFld1").value = "Search";
		return false;
	}
}