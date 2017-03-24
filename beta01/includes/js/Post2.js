var Post2 = new Object();
Post2.Send = function(form){
	var query = Post2.buildQuery(form);
	var domain = "http://" + window.location.toString().split("//")[1].split("/")[0] + "/";
	//domain += "rentownersvillas/";
	Ajax2.Request(form.method, domain+"property-refine-search-map-ajax.php", query, Post2.OnResponse);
}

Post2.OnResponse = function(txt){
	document.getElementById("showDetails").innerHTML = txt;
}

Post2.buildQuery = function(form){
	var query = "";
	for(var i=0; i<form.elements.length; i++){
		var key = form.elements[i].name;
		var value = Post2.getElementValue(form.elements[i]);
		if(key && value){
			query += key +"="+ value +"&";
		}
	}
	return query;
}

Post2.getElementValue = function(formElement){
	if(formElement.length != null) var type = formElement[0].type;
	if((typeof(type) == 'undefined') || (type == 0)) var type = formElement.type;

	switch(type){
		case 'undefined': return;

		case 'radio':
			for(var x=0; x < formElement.length; x++) 
				if(formElement[x].checked == true)
			return formElement[x].value;

		case 'select-multiple':
			var myArray = new Array();
			for(var x=0; x < formElement.length; x++) 
				if(formElement[x].selected == true)
					myArray[myArray.length] = formElement[x].value;
			return myArray;

		case 'checkbox': return formElement.checked;
	
		default: return formElement.value;
	}
}