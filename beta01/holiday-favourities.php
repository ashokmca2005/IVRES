<?php	
	require_once("includes/holiday-top.php");

	// Page details
	$page_id  				= 2;
	$pageInfo 				= $cmsObj->fun_getPageInfo($page_id);
    $page_title 			= fun_db_output($pageInfo['page_title']);
    $page_content_title 	= fun_db_output($pageInfo['page_content_title']);
    $page_discription 		= fun_db_output($pageInfo['page_discription']);    $seo_title 				= ($pageInfo['page_seo_title']!="")?$pageInfo['page_seo_title']:$seo_title;
    $seo_keywords 			= ($pageInfo['page_seo_keyword']!="")?$pageInfo['page_seo_keyword']:$seo_keywords;
    $seo_description 		= ($pageInfo['page_seo_discription']!="")?$pageInfo['page_seo_discription']:$seo_description;
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
    <link rel="stylesheet" type="text/css" href="<?php echo SITE_CSS_INCLUDES_PATH;?>common.css" />
	<script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>common.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>pop-up.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>tab_menu.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>dargPop.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>dhtmlwindow.js"></script>
	<script language="javascript" type="text/javascript">
		var x, y;
        function show_coords(event) {
            x=event.clientX;
            y=event.clientY;
            x = x-160;
            y = y+4;
        //	alert(x);alert(y);
        }
    
		function addFavourite(property_id, user_id, num){
			var xmlHttp = ajaxFunction();
			var p_id    = property_id;
			var userId  = user_id;
			var Url = "add-to-favorite.php?user_id="+userId+"&property_id="+p_id;
			xmlHttp.onreadystatechange=function(){
				if(xmlHttp.readyState==4){
					location.href = window.location;
				}
			}
			xmlHttp.open("GET", Url ,true);
			xmlHttp.send(null);
		}

        function removeFavourite(p_id, user_id, num){
            var xmlHttp       = ajaxFunction();
            var Url           = "remove-favourite.php?user_id="+user_id+"&property_id="+p_id;
            xmlHttp.onreadystatechange=function(){
                if(xmlHttp.readyState==4){
                    if(xmlHttp.responseText == "remove successfully"){
                        location.href = window.location;
                    }
                }
            }
            xmlHttp.open("GET", Url ,true);
            xmlHttp.send(null);
        }
    
        function chkAddToEnquiry(strId) {
            var chkBoxId = "txtPropertyCheckId"+strId;
            var propertyId = document.getElementById(chkBoxId).value;
            var strFieldId = "txtPropertyId";
            if(document.getElementById(chkBoxId).checked == true) {
                addPropertyToEnquiry(strFieldId, propertyId);
            } else {
                delPropertyToEnquiry(strFieldId, propertyId);
            }
        }
    
        function addPropertyToEnquiry(strFieldId, strFieldValue) {
            var txtIds = document.getElementById(strFieldId).value;
            if(txtIds != "") {
                document.getElementById(strFieldId).value = txtIds+","+strFieldValue;
            } else {
                document.getElementById(strFieldId).value = strFieldValue;
            }
        }
    
        function delPropertyToEnquiry(strFieldId, strFieldValue) {
            var txtids = document.getElementById(strFieldId).value;
            if(txtids != "") {
                var txtidsarr = new Array();
                var tmptxtids = "";
                txtidsarr = txtids.split(',');
                for(var i = 0; i < txtidsarr.length; i++) {
                    if(parseInt(strFieldValue) != parseInt(txtidsarr[i])) {
                        if(i == 0) {
                            tmptxtids = txtidsarr[i];
                        } else {
                            tmptxtids += ","+txtidsarr[i];
                        }
                    }
                }
                if(tmptxtids.charAt(0) == ",") {
                    tmptxtids = tmptxtids.substring(1, tmptxtids.length);
                }
                document.getElementById(strFieldId).value = tmptxtids;
            }
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
    <div id="pg-wrapper" align="center"><h1 class="page-heading">My favourites</h1></div>
    <div id="main">
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="left" valign="top">
					<?php require_once(SITE_INCLUDES_PATH.'holidayhome-left.php'); ?>
                </td>
                <td width="30" align="left" valign="top" style="border-right:thin #efefef solid;">&nbsp;</td>
                <td align="left" valign="top" class="font12" style="padding-left:10px;">
					<?php require_once(SITE_INCLUDES_PATH.'holidayfavourities.php'); ?>
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
