/**
 * AutoComplete Field - JavaScript Code
 *
 * This is a sample source code provided by fromvega.
 * Search for the complete article at http://www.fromvega.com
 *
 * Enjoy!
 *
 * @author fromvega
 *
 */

// global variables for general
var acListTotal   =  0;
var acListCurrent = -1;
var acDelay		  = 500;
var acURL		  = null;
var acSearchId	  = null;
var acResultsId	  = null;
var acSearchField = null;
var acResultsDiv  = null;


// global variables for location
var acLocListTotal		=  0;
var acLocListCurrent	 = -1;
var acLocURL	  		= null;
var acLocSearchId 		= null;
var acLocResultsId		= null;
var acLocSearchField 	= null;
var acLocResultsDiv  	= null;


function setAutoComplete(field_id, results_id, get_url){

	// initialize vars
	acSearchId  = "#" + field_id;
	acResultsId = "#" + results_id;
	acURL 		= get_url;

	// create the results div
	$("body").append('<div id="' + results_id + '"></div>');

	// register mostly used vars
	acSearchField	= $(acSearchId);
	acResultsDiv	= $(acResultsId);

	// reposition div
	repositionResultsDiv();
	
	// on blur listener
	acSearchField.blur(function(){ setTimeout("clearAutoComplete()", 200) });

	// on key up listener
	acSearchField.keyup(function (e) {

		// get keyCode (window.event is for IE)
		var keyCode = e.keyCode || window.event.keyCode;
		var lastVal = acSearchField.val();

		// check an treat up and down arrows
		if(updownArrow(keyCode)){
			return;
		}

		// check for an ENTER or ESC
		if(keyCode == 13 || keyCode == 27){
			clearAutoComplete();
			return;
		}

		// if is text, call with delay
		setTimeout(function () {autoComplete(lastVal)}, acDelay);
	});
}

// treat the auto-complete action (delayed function)
function autoComplete(lastValue)
{
	// get the field value
	var part = acSearchField.val();

	// if it's empty clear the resuts box and return
	if(part == ''){
		clearAutoComplete();
		return;
	}

	// if it's equal the value from the time of the call, allow
	if(lastValue != part){
		return;
	}

	// get remote data as JSON
	$.getJSON(acURL + part, function(json){

		// get the total of results
		var ansLength = acListTotal = json.length;

		// if there are results populate the results div
		if(ansLength > 0){

			var newData = '';

			// create a div for each result
			for(i=0; i < ansLength; i++) {
				newData += '<div class="unselected">' + json[i] + '</div>';
			}

			// update the results div
			acResultsDiv.html(newData);
			acResultsDiv.css("display","block");
			
			// for all divs in results
			var divs = $(acResultsId + " > div");
		
			// on mouse over clean previous selected and set a new one
			divs.mouseover( function() {
				divs.each(function(){ this.className = "unselected"; });
				this.className = "selected";
			})
		
			// on click copy the result text to the search field and hide
			divs.click( function() {
				acSearchField.val(this.childNodes[0].nodeValue);
				clearAutoComplete();
			});

		} else {
			clearAutoComplete();
		}
	});
}

// clear auto complete box
function clearAutoComplete()
{
//	alert(acResultsDiv);
	acResultsDiv.html('');
	acResultsDiv.css("display","none");
}

// reposition the results div accordingly to the search field
function repositionResultsDiv()
{
	// get the field position
	var sf_pos    = acSearchField.offset();
	var sf_top    = sf_pos.top;
	var sf_left   = sf_pos.left;

	// get the field size
	var sf_height = acSearchField.height();
	var sf_width  = acSearchField.width();

	// apply the css styles - optimized for Firefox
	acResultsDiv.css("position","absolute");
	acResultsDiv.css("left", sf_left - 2);
	acResultsDiv.css("top", sf_top + sf_height + 5);
	acResultsDiv.css("width", sf_width - 2);
}

// treat up and down key strokes defining the next selected element
function updownArrow(keyCode) {
	if(keyCode == 40 || keyCode == 38){

		if(keyCode == 38){ // keyUp
			if(acListCurrent == 0 || acListCurrent == -1){
				acListCurrent = acListTotal-1;
			}else{
				acListCurrent--;
			}
		} else { // keyDown
			if(acListCurrent == acListTotal-1){
				acListCurrent = 0;
			}else {
				acListCurrent++;
			}
		}

		// loop through each result div applying the correct style
		acResultsDiv.children().each(function(i){
			if(i == acListCurrent){
				acSearchField.val(this.childNodes[0].nodeValue);
				this.className = "selected";
			} else {
				this.className = "unselected";
			}
		});

		return true;
	} else {
		// reset
		acListCurrent = -1;
		return false;
	}
}


function setAutoCompleteLoc(field_id, results_id, get_url){

	// initialize vars
	acLocSearchId  = "#" + field_id;
	acLocResultsId = "#" + results_id;
	acLocURL 		= get_url;

	// create the results div
	$("body").append('<div id="' + results_id + '"></div>');

	// register mostly used vars
	acLocSearchField= $(acLocSearchId);
	acLocResultsDiv	= $(acLocResultsId);

	// reposition div
	repositionResultsDivLoc();
	
	// on blur listener
	acLocSearchField.blur(function(){ setTimeout("clearAutoCompleteLoc()", 200) });

	// on key up listener
	acLocSearchField.keyup(function (e) {

		// get keyCode (window.event is for IE)
		var keyCode = e.keyCode || window.event.keyCode;
		var lastVal = acLocSearchField.val();

		// check an treat up and down arrows
		if(updownArrowLoc(keyCode)){
			return;
		}

		// check for an ENTER or ESC
		if(keyCode == 13 || keyCode == 27){
			clearAutoCompleteLoc();
			return;
		}

		// if is text, call with delay
		setTimeout(function () {autoCompleteLoc(lastVal)}, acDelay);
	});
}

// treat the auto-complete action (delayed function)
function autoCompleteLoc(lastValue)
{
	// get the field value
	var part = acLocSearchField.val();

	// if it's empty clear the resuts box and return
	if(part == ''){
		clearAutoCompleteLoc();
		return;
	}

	// if it's equal the value from the time of the call, allow
	if(lastValue != part){
		return;
	}

	// get remote data as JSON
	$.getJSON(acLocURL + part, function(json){

		// get the total of results
		var ansLength = acListTotal = json.length;

		// if there are results populate the results div
		if(ansLength > 0){

			var newData = '';

			// create a div for each result
			for(i=0; i < ansLength; i++) {
				newData += '<div class="unselected">' + json[i] + '</div>';
			}

			// update the results div
			acLocResultsDiv.html(newData);
			acLocResultsDiv.css("display","block");
			
			// for all divs in results
			var divs = $(acLocResultsId + " > div");
		
			// on mouse over clean previous selected and set a new one
			divs.mouseover( function() {
				divs.each(function(){ this.className = "unselected"; });
				this.className = "selected";
			})
		
			// on click copy the result text to the search field and hide
			divs.click( function() {
				acLocSearchField.val(this.childNodes[0].nodeValue);
				clearAutoCompleteLoc();
			});

		} else {
			clearAutoCompleteLoc();
		}
	});
}

// clear auto complete box
function clearAutoCompleteLoc()
{
//	alert(acResultsDiv);
	acLocResultsDiv.html('');
	acLocResultsDiv.css("display","none");
}


// reposition the results div accordingly to the search field
function repositionResultsDivLoc()
{
	// get the field position
	var sf_pos    = acLocSearchField.offset();
	var sf_top    = sf_pos.top;
	var sf_left   = sf_pos.left;

	// get the field size
	var sf_height = acLocSearchField.height();
	var sf_width  = acLocSearchField.width();

	// apply the css styles - optimized for Firefox
	acLocResultsDiv.css("position","absolute");
	acLocResultsDiv.css("left", sf_left - 2);
	acLocResultsDiv.css("top", sf_top + sf_height + 5);
	acLocResultsDiv.css("width", sf_width - 2);
}


// treat up and down key strokes defining the next selected element
function updownArrowLoc(keyCode) {
	if(keyCode == 40 || keyCode == 38){

		if(keyCode == 38){ // keyUp
			if(acLocListCurrent == 0 || acLocListCurrent == -1){
				acLocListCurrent = acLocListTotal-1;
			}else{
				acLocListCurrent--;

			}
		} else { // keyDown
			if(acLocListCurrent == acLocListTotal-1){
				acLocListCurrent = 0;
			}else {
				acLocListCurrent++;
			}
		}

		// loop through each result div applying the correct style
		acLocResultsDiv.children().each(function(i){
			if(i == acLocListCurrent){
				acSearchField.val(this.childNodes[0].nodeValue);
				this.className = "selected";
			} else {
				this.className = "unselected";
			}
		});

		return true;
	} else {
		// reset
		acLocListCurrent = -1;
		return false;
	}
}

