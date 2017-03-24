var Ajax1 = new Object();
Ajax1.isUpdating = true;

Ajax1.Request = function(method, url, query, callback)
{
	this.isUpdating = true;
	this.callbackMethod = callback;
	this.request = (window.XMLHttpRequest)? new XMLHttpRequest(): new ActiveXObject("MSXML2.XMLHTTP"); 
	this.request.onreadystatechange = function() { Ajax1.checkReadyState(); };
	
	if(method.toLowerCase() == 'get') url = url+"?"+query;
	this.request.open(method, url, true);
	this.request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	this.request.send(query);
}
	
Ajax1.checkReadyState = function(_id)
{
	switch(this.request.readyState)
	{
		case 1: break;
		case 2: break;
		case 3: 
			this.callbackMethod("<strong>Loading ...</strong>");
		break;
		case 4:
			this.isUpdating = false;
			this.callbackMethod(this.request.responseText);
/*
alert(this.request.responseXML);
			this.callbackMethod(this.request.responseXML);
*/
	}
}