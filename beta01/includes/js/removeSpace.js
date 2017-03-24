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