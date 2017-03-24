<?php	
	require_once("includes/owner-top.php");
	if(isset($_GET['id']) && $_GET['id'] !=""){
		$id 	= $_GET['id'];
	} else {
		redirectURL(SITE_URL."index.php");
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo $seo_title;?></title>
    <meta name="description" content="<?php echo $seo_description;?>" />
    <meta name="keywords" content="<?php echo $seo_keywords;?>" />
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo tranText('charset'); ?>" />
    <META HTTP-EQUIV="Content-language" CONTENT="<?php echo tranText('lang_iso'); ?>">
    <link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo SITE_URL; ?>favicon.ico" />
    <link rel="SHORTCUT ICON" href="<?php echo SITE_URL; ?>favicon.ico"/>
    <link href="<?php echo SITE_CSS_INCLUDES_PATH;?>owner.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>common.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>owner.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>dhtmlwindow.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>pop-up.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>dargPop.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>equal_height.js"></script>
    <script language="javascript" type="text/javascript">
		var x, y;
        function show_coords(event){	
            x=event.clientX;
            y=event.clientY;
            x = x-160;
            y = y+4;
//        	alert(x);alert(y);
        }
        function toggleLayer(whichLayer){
            var output = document.getElementById(whichLayer).innerHTML;
            if(whichLayer == 'ANP-Example')
            {		
                output = '<div style="z-index:5;">'+output+'</div>';
                var googlewin=dhtmlwindow.open("Example", "inline", output, "", "width=295px,height=470px,resize=0,scrolling=0,center=1,xAxis="+x+",yAxis="+y+"", "recal");
            }
            else if(whichLayer == 'cart-item-delete-pop')
            {		
                var x1 = x-150;
                var y1 = y-100;
                output = '<div style="z-index:5;">'+output+'</div>';
                var googlewin=dhtmlwindow.open("Example", "inline", output, "", "width=298px,height=160px,resize=1,scrolling=0,center=1,xAxis="+x1+",yAxis="+y1+"", "recal");
            }
        
            googlewin.onclose=function(){ //Run custom code when window is being closed (return false to cancel action):
                return true
            }
        }
        
        function closeWindow(){	
            document.getElementById("Example").style.display="none";
        }
        
        function closeWindowNRefresh(){
            document.getElementById("Example").style.display="none";
            window.location = location.href;
        }
    </script>
	<script language="javascript" type="text/javascript">
        var req = ajaxFunction();
        function updateBacklink() { 
            var id = document.getElementById('id').value;
            var backlink = document.getElementById('backlink').value;
			//alert('updateBacklinkXml.php?id=' + id +'&backlink=' + backlink);
            if(id != "" && backlink != "") {
                req.onreadystatechange = function() {
                    if (req.readyState==4) {
                        var response = req.responseText; 
                        xmlDoc = req.responseXML;
                        var root = xmlDoc.getElementsByTagName('backlinks')[0];
                        if(root != null) {
                            var items = root.getElementsByTagName("backlink");
                            var item = items[0];
                            var backlinkstatus = item.getElementsByTagName("backlinkstatus")[0].firstChild.nodeValue;
                            if(backlinkstatus == "valid"){
                                document.getElementById("tblBacklinkId").style.display = "none";
                                document.getElementById("showErrorValidStatus").innerHTML = "Validation succussfully completed!";

                            } else {
                                document.getElementById("showErrorValidStatus").innerHTML = "Error: Invalid or duplicate backlink";
                            }
                        }
                    }
                }
                req.open('get', 'updateBacklinkXml.php?id=' + id +'&backlink=' + backlink);
                req.send(null); 
            } else {
				document.getElementById("showErrorValidStatus").innerHTML = "<strong>Error: Please insert the link, where you placed the linkcode to <?php echo SITE_URL;?></strong>";
			}
        }

        function validate(){
            if(document.getElementById("property_id").value == "") {
                document.getElementById("showErrorPropertyId").innerHTML = "Property id required";
                document.getElementById("property_id").focus();
                return false;
            }
            if(document.getElementById("backlink").value == "") {
                document.getElementById("showErrorBacklinkId").innerHTML = "Backlink required";
                document.getElementById("backlink").focus();
                return false;
            }
            if(document.getElementById("status").value == "") {
                document.getElementById("showErrorStatusId").innerHTML = "Status required";
                document.getElementById("status").focus();
                return false;
            }
            document.frmBacklink.submit();
        }
    </script>
</head>
<body onmousedown="show_coords(event);">
<!-- Main Wrapper Starts Here -->
<div id="wrapper">
    <!-- Header Include Starts Here -->
    <div id="header" align="center">
        <?php require_once(SITE_INCLUDES_PATH.'header.php'); ?>
    </div>
    <!-- Header Include End Here -->
	<?php require_once(SITE_INCLUDES_PATH.'holidayadvsearch.php'); ?>
	<?php //require_once(SITE_INCLUDES_PATH.'breadcrumb.php'); ?>
    <div id="pg-wrapper" align="center"><h1 class="page-heading">Shopping cart</h1></div>
    <div id="main">
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="left" valign="top" width="230">
					<?php require_once(SITE_INCLUDES_PATH.'owner-left-links.php'); ?>
                </td>
                <td width="30" align="left" valign="top" style="border-right:thin #efefef solid;">&nbsp;</td>
                <td align="left" valign="top" class="font12" style="padding-left:10px;">
                    <table width="700px" border="0" cellspacing="0" cellpadding="0" class="font12">
                        <tr><td class="pad-top5">&nbsp;</td></tr>
                        <tr>
                            <td align="left" valign="top" style="border:#CCCCCC thin solid; padding:5px;">
                                <h3>Activation</h3>
                                <span class="pdError1" id="showErrorValidStatus"><strong>Please insert the link, where you placed the linkcode to <?php echo SITE_URL;?></strong></span>
                                <br /><br />
                                <form name="frmBacklink" id="frmBacklink" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12" id="tblBacklinkId">
                                    <tr>
                                        <td class="pad-lft15">Backlink</td>
                                        <td class="pad-lft5"><input type="text" name="backlink" id="backlink" class="Textfield280" value="" /></td>
                                        <td class="pad-lft10"><a href="javascript:void(0);" onclick="return updateBacklink();" class="button-blue" style="text-decoration:none;">Check!</a></td>
                                        <td width="225px">&nbsp;</td>
                                    </tr>
                                </table>
                                </form>
                                <br /><br />
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</div>
<!-- Main Wrapper End Here -->
<!-- Footer Include Starts Here -->
<div id="footer">
    <?php require_once(SITE_INCLUDES_PATH.'footer.php'); ?>
</div>
<!-- Footer Include End Here -->
</body>
</html>
