// JavaScript Document
var selectedSuggestionIndex;
var content="";
var autoData = new Array();
var tempArray = new Array();
var lastTid = false;
var isBusy = false;
var txtBox;
var txtBoxWidth;
var autocompletelayer;
var focusme=false;
var layerColor1, layerColor1, layerColorSelect, fontColor, tableBorderColor;
var debug=false;
var numRequest=0;
var usedDevice="";
var autocompletelayer1;
//******************* Display Location search field *********//
function displaylocation(e,txtbox)
{
	autocompletelayer = document.getElementById("autocompletedata");
	txtBox = txtbox;
	txtBoxWidth = parseInt(txtBox.style.width)+4;
	var KeyID = (window.event) ? event.keyCode : e.keyCode;
	if(KeyID==38 || KeyID==40 || KeyID==27)
	{
		KeyCheck(KeyID);
	}else
	{
		if(lastTid)
			clearTimeout(lastTid);
			
			lastTid = setTimeout("callHttps("+KeyID+")", 50);
	}
}

/*
function displaydestinationCity(e,txtbox){
	autocompletelayer = document.getElementById("autocompletedata");
	txtBox = txtbox;
	txtBoxWidth = parseInt(txtBox.style.width)+4;
	var KeyID = (window.event) ? event.keyCode : e.keyCode;
	if(KeyID==38 || KeyID==40 || KeyID==27){
		KeyCheck(KeyID);
	}else{
		if(lastTid)
			clearTimeout(lastTid);
			
			lastTid = setTimeout("callHttp1("+KeyID+")", 50);
	}
}
//***************************************************************************Ashish
*/

function displayList(e,txtbox)
{
	autocompletelayer = document.getElementById("autocompletedata");//Div to display results
	autocompletelayer1 = document.getElementById("autocompletedata1");//Div to display results
	txtBox = txtbox; //Typed in value
	txtBoxWidth = parseInt(txtBox.style.width)+4; //width of the box
	var KeyID = (window.event) ? event.keyCode : e.keyCode; //handling IE and firefox
	if(KeyID==38 || KeyID==40 || KeyID==27) //up and down arrow
	{
		KeyCheck(KeyID);
	}
	else
	{
		if(lastTid)
			clearTimeout(lastTid); //If alredy timeout set cleat ir 
	
		lastTid = setTimeout("callHttp("+KeyID+")", 50); //Wait for 50ms and call HTTP Request
		
	}
}

function normal(selectedIndex)
{
	selectedSuggestionIndex = selectedIndex;
	suggestions = content.split(",");
//	alert(suggestions);
	var str="";
	if(suggestions.length > 0 && content.match("[a-zA-Z0-9]"))
	{
		str+='<table BORDER="0" cellspacing="0" cellpadding="2" STYLE="border-color:#808080;border-collapse:collapse;width:318px;" onmouseover="focusme=true;" onmouseout="focusme=false;">'+"\n";
		
		for(i=0;i<suggestions.length;i++)
		{
			if(suggestions[i]!="")
			{
				var bgcolor, fontColor;
				namestrArr = suggestions[i].split("\"");
				namestr = namestrArr[1];
				
				//namestr=namestr.split(":")[0];
				if(i%2==0)
				{
					bgcolor=' BGCOLOR="#FFFFFF"'; //'+layerColor1+'"';
					fontColor='color:#000000;';
				}
				else
				{
					bgcolor=' BGCOLOR="#FFFFFF"'; //'+layerColor2+'"';
					fontColor='color:#000000;';
				}
				if(i==selectedSuggestionIndex)
				{
					bgcolor=' BGCOLOR="#ff9933"'; //'+layerColorSelect+'"';
					fontColor='color:#ffffff;';
				}
				str+='<tr>';
				str+='<td align="left" style="zindex:1;'+fontColor+'padding-left:5px;width:'+txtBoxWidth+'px"'+bgcolor+' onclick="endup(\'m\');autocompletelayer.style.display=\'none\';" onmousemove="normal(\''+i+'\');">'+namestr+'</td>';
				str+='</tr>'+"\n";
			}
			
		}
		str+='</table>';
	}
	//Added by ashish Tripathi on 10-05-2008
	else{
		str+='<table STYLE="border-color:#808080;border-collapse:collapse;width:'+txtBoxWidth+'px;" onmouseover="focusme=true;" onmouseout="focusme=false;">'+"\n";
		str+='<tr>';
		str+='<td align="left" style="z-index:1;color:#FF0000;padding-left:5px;width:'+txtBoxWidth+'px" BGCOLOR="#E7EBF0" onclick="endup(\'m\')">No matches</td>';
		str+='</tr>';
		str+='</table>';
	}//End for else condition
	autocompletelayer.style.display='block';
	autocompletelayer.innerHTML=str;
	autocompletelayer.style.zIndex = '1000';
	autocompletelayer.style.position = 'absolute';
	autocompletelayer.style.left = findPosX(txtBox);
	autocompletelayer.style.top = findPosY(txtBox);
}

function makeHttpObject()
{
	try
	{
		xmlHttpObj = new ActiveXObject("Msxml2.XMLHTTP");
	}
	catch (e)
	{
		try
		{
			xmlHttpObj = new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch (e)
		{
			xmlHttpObj = false;
		}
	}

	if(!xmlHttpObj && typeof XMLHttpRequest !='undefined')
	{
		try
		{
			xmlHttpObj = new XMLHttpRequest();
		}
		catch (e)
		{
			xmlHttpObj = false;
		}
	}
	return xmlHttpObj;
}

var httpObj = makeHttpObject();

function getHttpResponse()
{	
	
	if(httpObj.readyState == 4)
	{
		try
		{
			if(httpObj.status == 200)
			{
				content = httpObj.responseText;
				
				autoData[content.split("~")[1]] = content.split("~")[0];
				content = seprateContent(content.split("~")[0]);
				//content = autoData[content.split("~")[1]];
				isBusy = false;
				// document.forms[0].mylog.value+="Response received and content is "+content+"\n";
				if(matchResponse(content))
				{
					normal(-1);
				}
				else
				{
					autocompletelayer.innerHTML="";
				}
			}
		}
		catch (err)
		{
			try
			{
				if(httpObj.status == 200)
				{
					content = httpObj.responseText;
					autoData[content.split("~")[1]] = content.split("~")[0];
					content = seprateContent(content.split("~")[0]);
					isBusy = false;
					// document.forms[0].mylog.value+="Response received and content is "+content+"\n";
					if(matchResponse(content))
					{
						normal(-1);
					}
					else
					{
						autocompletelayer.innerHTML="";
					}
				}
			}
			catch (err)
			{
				try
				{
					if(httpObj.status == 200)
					{
						content = httpObj.responseText;
						autoData[content.split("~")[1]] = content.split("~")[0];
						content = seprateContent(content.split("~")[0]);
						
						isBusy = false;
						// document.forms[0].mylog.value+="Response received and content is "+content+"\n";
						if(matchResponse(content))
						{
							normal(-1);
						}
						else
						{
							autocompletelayer.innerHTML="";
						}
					}
				}
				catch (err)
				{
				}
			}
		}
	}
}

//*****************************************************************ashish
function callHttps(KeyID)
{
	if(isBusy)
	{
		httpObj = makeHttpObject();
	}

	// Find the value typed in autocomplete text Box	
	var str = txtBox.value.toLowerCase();
	str = refineText(str)
	// Calling when the text in autocomplete box has length > 2 
	if(str.length > 0 && str.match(new RegExp("[a-z]+", "i")) && KeyID!=37 && KeyID!=39)
	{
		if(!checkExists(str))
		{
			autocompletelayer.innerHTML="";
			rand= 10000 * Math.random() ;
			str = str.substring(0,2);
			var regExp = new RegExp('\\#');
			str = str.replace(regExp, '%23');
			var regExp = new RegExp('\\+');
			str = str.replace(regExp, '%2B');
			
			var url = "autocompletelocationsearch.php?part="+str;//added by ashish tripathi on 06-May
			
			try
			{
				isBusy = true;
				numRequest++;				
				httpObj.onreadystatechange = getHttpResponse;
				//alert(getHttpResponse);return false;
				httpObj.open("GET",url,true);
				httpObj.send(null);
				
				if(document.forms[0].ac) document.forms[0].ac.value=usedDevice+"~"+numRequest+"~"+lastSelectedValue;
				return false;
			}
			catch (err)
			{
				// document.forms[0].mylog.value+="Error in sending request "+err+"\n";
			}
		}
	}
	else if(KeyID!=37 && KeyID!=39)
	{
		autocompletelayer.innerHTML="";
	}
}
//****************************************************************************ashish

function checkExists(str)
{
	if(autoData[str.substring(0,2)] == undefined)
	{
		return false;
	}
	else if(autoData[str.substring(0,2)].match(new RegExp("[a-z]+","i")))
	{
		content = seprateContent(autoData[str.substring(0,2)]);
		if(matchResponse(content))
		{
			normal(-1);
		}
		else
		{
			autocompletelayer.innerHTML="";
		}
		return true;
	}
	return false;
}

function seprateContent(str)
{
	var txtData = refineText(txtBox.value);
	var reg = new RegExp('[.]','g');
	txtData = txtData.replace(reg,'\\.');
	reg = new RegExp('[+]','g');
	txtData = txtData.replace(reg,'\\+');
	var freshContent = '';
	var tempStr = '';
	tempArray = str.split('|');
	var countsg = 0;
	for(sg in tempArray)
	{
		tempStr = refineText(tempArray[sg])
		if(tempStr.match(new RegExp('^'+txtData,"i")))
		{
			freshContent+=tempArray[sg]+"|";
			countsg++;
		}
		/*if(countsg==10)
		{
			break;
		}*/
	}
	freshContent = freshContent.replace(/\|$/,"");
	return freshContent;
}

function KeyCheck(KeyID)
{
	var str = txtBox.value;
	var show=1;
	if(str.length > 0)
	{
		suggestions = content.split("|");
		if(KeyID==38)
		{
			if(selectedSuggestionIndex > 0)
			{
				selectedSuggestionIndex--;
			}
			else
			{
				selectedSuggestionIndex = suggestions.length-1;
			}
		}
		else if(KeyID==40)
		{
			if(selectedSuggestionIndex < suggestions.length-1)
			{
				selectedSuggestionIndex++;
			}
			else
			{
				selectedSuggestionIndex = 0;
			}
		}
		else if(KeyID==27)
		{
			show = 0;
			focusme	= false;
			hide();
		}
		
		if(show)
		{
			normal(selectedSuggestionIndex);
			endup('k');
		}
	}
}

function endup(device)
{
//	suggestions = content.split(",|");

	suggestions = content.split(",");
//	suggestionsArr = suggestionsArr1.split("\"");
//	alert(suggestions);
//	suggestions = suggestionsArr[1];

//	txtBox.value = suggestions[selectedSuggestionIndex];
	txtBox.value = suggestions[selectedSuggestionIndex].split("\"")[1];
	lastSelectedValue = suggestions[selectedSuggestionIndex].split("\"")[0];
	usedDevice=device;
	txtBox.focus();
	if(document.forms[0].ac) document.forms[0].ac.value=usedDevice+"~"+numRequest+"~"+lastSelectedValue;
}

function getPos()
{
	var str = txtBox.value;
	var pos = str.lastIndexOf(' ');
	if(str.lastIndexOf(',') > pos)
	{
		pos = str.lastIndexOf(',');
	}
	if(str.lastIndexOf(';') > pos)
	{
		pos = str.lastIndexOf(';');
	}
	return pos;
}

function checkAutoFocus()
{
	suggestions = content.split("|");
	txtBox.value = suggestions[selectedSuggestionIndex];
	txtBox.focus();
}

function findPosX(obj)
{
	var curleft = 0;
	if (obj.offsetParent){
		while (obj.offsetParent){
			curleft += obj.offsetLeft;
			obj = obj.offsetParent;
		}
	}
	else if (obj.x)
		curleft += obj.x;
	return curleft;
}

function findPosY(obj)
{
	var curtop = 0;
	if (obj.offsetParent){
		curtop += obj.offsetHeight;
		while (obj.offsetParent){
			curtop += obj.offsetTop;
			obj = obj.offsetParent;
		}
	}
	else if (obj.y){
		curtop += obj.y;
		curtop += obj.height;
	}
	return curtop;
}

function hide()
{
	if(focusme==false)
	{
		autocompletelayer = document.getElementById("autocompletedata");
		autocompletelayer1 = document.getElementById("autocompletedata1");
		autocompletelayer.style.display='none';
		autocompletelayer1.style.display = 'none';
	}
}

function initAutoComplete(layercolor1, layercolor2, layercolorselect, fontcolor, tablebordercolor)
{
	layerColor1 = layercolor1;
	layerColor2 = layercolor2;
	layerColorSelect = layercolorselect;
	fontColor = fontcolor;
	tableBorderColor = tablebordercolor;
}

function matchResponse(response)
{
	var str="", qvalue=txtBox.value,suggestions=""; 
	qvalue = refineText(qvalue)
	var reg = new RegExp('[.]','g');
	qvalue = qvalue.replace(reg,'\\.');
	reg = new RegExp('[+]','g');
	qvalue = qvalue.replace(reg,'\\+');

	suggestions = response.split("|");
	if(suggestions.length > 0 && response.match("[a-zA-Z0-9]"))
	{
		for(i=0;i<suggestions.length;i++)
		{
			str=suggestions[i];
			str = refineText(str)
			if(!str.match(new RegExp(qvalue, "i")))
			{
				return false;
			}
		}
	}
	return true;
}

function refineText(rStr)
{
	rStr = rStr.replace(/[^a-z0-9_ .+#]+/ig," ");
	// rStr = rStr.replace(/\+/ig,"PLUS");
	// rStr = rStr.replace(/\./ig,"DOT");
	rStr = rStr.replace(/\s+/g," ");
	rStr = rStr.replace(/(^(\s*,\s*)+|(\s*,\s*)+$|^\s+)/g,"");
	return rStr;
}

function Debug()
{
	if(!debug)
	{
		debug=true;
		// document.forms[0].mylog.style.display='block';
	}
	else
	{
		debug=false;
		// document.forms[0].mylog.style.display='none';
	}
}
