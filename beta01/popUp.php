<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="css/owner.css" rel="stylesheet" type="text/css" />
<style type="text/css">
* html img, * html .png {
 behavior: expression((this.runtimeStyle.behavior="none")&&(this.pngSet?this.pngSet=true:(this.nodeName == "IMG" && this.src.toLowerCase().indexOf('.png')>-1?(this.runtimeStyle.backgroundImage = "none",  this.runtimeStyle.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + this.src + "', sizingMethod='image')",  this.src = "blank.gif"):(this.origBg = this.origBg? this.origBg :this.currentStyle.backgroundImage.toString().replace('url("', '').replace('")', ''),  this.runtimeStyle.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + this.origBg + "', sizingMethod='crop')",  this.runtimeStyle.backgroundImage = "none")), this.pngSet=true)  );
}
html {
	height:100%;
}
body {
	background: url(../images/page-bg.gif) repeat;
	margin: 0px;
	padding: 0px;
	font-family: Arial, Helvetica, sans-serif;
	text-decoration: none;
	font-size: 12px;
	height:100%;
}
.cursor1 {
	cursor : url(images/hmove.png), url('images/hmove.cur'), pointer;
}
</style>
<script language="javascript" type="text/javascript"> 
// Script Source: CodeLifter.com
// Copyright 2003
// Do not remove this header

isIE=document.all;
isNN=!document.all&&document.getElementById;
isN4=document.layers;
isHot=false;

function ddInit(e){
  topDog=isIE ? "BODY" : "HTML";
  whichDog=isIE ? document.all.theLayer : document.getElementById("theLayer");  
  hotDog=isIE ? event.srcElement : e.target;  
  while (hotDog.id!="titleBar"&&hotDog.tagName!=topDog){
    hotDog=isIE ? hotDog.parentElement : hotDog.parentNode;
  }  
  if (hotDog.id=="titleBar"){
    offsetx=isIE ? event.clientX : e.clientX;
    offsety=isIE ? event.clientY : e.clientY;
    nowX=parseInt(whichDog.style.left);
    nowY=parseInt(whichDog.style.top);
    ddEnabled=true;
    document.onmousemove=dd;
  }
}

function dd(e){
  if (!ddEnabled) return;
	var cX = isIE? event.clientX: e.clientX;
	var cY = isIE? event.clientY: e.clientY;
	var newX = nowX + cX -offsetx;
	var newY = nowY + cY -offsety;
	whichDog.style.left = newX +"px";
	whichDog.style.top = newY +"px";
  return false;  
}

function ddN4(whatDog){
  if (!isN4) return;
  N4=eval(whatDog);
  N4.captureEvents(Event.MOUSEDOWN|Event.MOUSEUP);
  N4.onmousedown=function(e){
    N4.captureEvents(Event.MOUSEMOVE);
    N4x=e.x;
    N4y=e.y;
  }
  N4.onmousemove=function(e){
    if (isHot){
      N4.moveBy(e.x-N4x,e.y-N4y);
      return false;
    }
  }
  N4.onmouseup=function(){
    N4.releaseEvents(Event.MOUSEMOVE);
  }
}

function hideMe(){
  if (isIE||isNN) whichDog.style.visibility="hidden";
  else if (isN4) document.theLayer.visibility="hide";
}

function showMe(){
  if (isIE||isNN) whichDog.style.visibility="visible";
  else if (isN4) document.theLayer.visibility="show";
}

document.onmousedown=ddInit;
document.onmouseup=Function("ddEnabled=false");

</script>
</head>
<body>
<div id="MainWrapper">
    <!-- BEGIN FLOATING LAYER CODE //-->
    <div id="theLayer" style="position:absolute;width:250px;left:100;top:100;visibility:visible">
        <table border="0" width="250" cellspacing="0" cellpadding="5">
            <tr>
                <td width="100%" id="titleBar" onMouseDown="this.className='cursor1';" onMouseUp="this.className='none';">
                    <table width="320" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td align="right"><img src="images/poplefttop.png" alt="ANP" height="10" width="10"/></td>
                            <td class="topp"></td>
                            <td><img src="images/poprighttop1.png" alt="ANP"  height="10" width="15" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/poprighttop1.png', sizingMethod='scale');"/></td>
                        </tr>
                        <tr>
                            <td class="leftp"></td>
                            <td  align="left" valign="top" bgcolor="#FFFFFF" style="padding:6px;">
                                <table  border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td  align="left" valign="top" class="head"><strong>Tell us where your property is</strong></td>
                                        <td width="15" align="right" valign="top" class="pad-rgt4"><a href="#" onClick="hideMe();return false"><img src="images/pop-up-cross.gif" alt="Close" title="Close" border="0" /></a></td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="top" class="PopTxt" style="padding-top:10px;">If you’re property isn’t on these lists then please tell us where it is and we’ll add it to the site. We will let you know as soon as we have done this and will automatically fill in these details for you.</td>
                                        <td align="left" valign="top">&nbsp;</td>
                                    </tr>
                                    <tr height="18">
                                        <td colspan="2" align="center" valign="middle">
                                            <div id="errorDiv"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="left" valign="top" class="TxtArea">
                                            <textarea name="anp_tell_us" id="anp_tell_us" cols="" rows="" class="ANP"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="15"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="left" valign="top">
                                            <table border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td align="left" valign="top" class="buttons"><a href="javascript:closeWindow();void(0);"><img src="images/ANP-Pop-Cancel.gif" alt="Cancel" name="Cancel" width="48" height="21" border="0" onMouseOver="this.src='images/ANP-Pop-Cancel-Over.gif'" onMouseOut="this.src='images/ANP-Pop-Cancel.gif'" id="Cancel" /></a></td>
                                                    <td align="left" valign="top"><img src="images/spacer.gif" alt="One" width="10" />&nbsp;</td>
                                                    <td align="left" valign="top"><a href="javascript: checkTellUsWhere();void(0);"><img src="images/ANP-Pop-Submit.gif" alt="Submit" name="Submit" width="64" height="21" border="0" onMouseOver="this.src='images/ANP-Pop-Submit-Over.gif'" onMouseOut="this.src='images/ANP-Pop-Submit.gif'" id="Submit" /></a></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td class="rightp" width="10"></td>
                        </tr>
                        <tr>
                            <td align="right"><img src="images/popleftbtm.png" alt="ANP" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/popleftbtm.png', sizingMethod='crop');" width="10" height="10"/></td>
                            <td  class="bottomp"></td>
                            <td align="left"><img src="images/poprightbtm1.png" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/poprightbtm1.png', sizingMethod='crop');" width="15" height="10" alt="ANP"/></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <a href="javascript:showMe();">show</a> To hide the layer: <a href="javascript:hideMe();">hide</a> ============================[end]============================= </div>
</body>
</html>
