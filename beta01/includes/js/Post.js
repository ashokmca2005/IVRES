var Post = new Object();
Post.Send = function(form){
	var query = Post.buildQuery(form);
	var mapurl = form.action.indexOf("property-refine-search-map-ajax");
	//alert(mapurl);
	if(parseInt(mapurl) > 0) {
		Ajax.Request(form.method, form.action, query, Post.OnResponse1);
	} else {
		Ajax.Request(form.method, form.action, query, Post.OnResponse);
	}
}

Post.OnResponse = function(txt){
document.getElementById("showDetails").innerHTML = txt;
}

Post.OnResponse1 = function(txt){
//alert(txt);
showRefinePropertyMarker(txt);
}

Post.buildQuery = function(form){
	var query = "";
	for(var i=0; i<form.elements.length; i++){
		var key = form.elements[i].name;
		var value = Post.getElementValue(form.elements[i]);
		if(key && value){
			query += key +"="+ value +"&";
		}
	}
	return query;
}

Post.getElementValue = function(formElement){
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