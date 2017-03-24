<?php	
     if($_SERVER["SERVER_NAME"] == "localhost") {
		require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
	} else {
		require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
	}
	require_once(SITE_CLASSES_PATH."class.Users.php");
	require_once(SITE_CLASSES_PATH."class.Travel.php");
	require_once(SITE_CLASSES_PATH."class.Property.php");
	require_once(SITE_CLASSES_PATH."class.Pagination.php");
	require_once(SITE_CLASSES_PATH."class.Location.php");
	require_once(SITE_CLASSES_PATH."class.CMS.php");

	$dbObj = new DB();
	$dbObj->fun_db_connect();
	$tvlguidObj		= new Travel();
	$propertyObj 	= new Property();
	$usersObj 		= new Users();
	$locationObj 	= new Location();
	$cmsObj         = new Cms();
	if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !=""){
		$user_id 			= $_SESSION['ses_user_id'];
		$userInfoArr 		= $usersObj->fun_getUsersInfo($user_id);
		$users_first_name 	= $userInfoArr['user_fname'];
		$users_last_name 	= $userInfoArr['user_lname'];
		$users_email_id 	= $userInfoArr['user_email'];
		$user_full_name 	= ucwords($users_first_name." ".$users_last_name);
		$country_id 		= $userInfoArr['user_country'];
		$rcountry_id 		= $userInfoArr['user_rcountry'];
	}
	$page	 = form_int("page",1)+0;
	$sortby  = form_int("sortby",0,0,4);
	$sortdir = form_int("sortdir",0,0,1);
	if (form_isset("reverse")) {
		$sortdir = 1-$sortdir;
	}
	switch($sortdir) {
		case 0 : $orderDir = "ASC"; break;
		case 1 : $orderDir = "DESC"; break;
	}
	
	if(isset($_GET['catid']) && $_GET['catid'] != "") {
		$trvl_guid_categories_id 	= $_GET['catid'];
		$tvlCatInfoArr 				= $tvlguidObj->fun_getTravelGuideCatInfo($trvl_guid_categories_id);
	
		if(!is_array($tvlCatInfoArr)) {
			redirectURL("holiday-travelguides.php");
		} else {
			$tvlInfoByCatArr = $tvlguidObj->fun_getTravelGuidListByCatArr($trvl_guid_categories_id);
		}
	} else if(isset($_GET['tvlguidid']) && $_GET['tvlguidid'] != "") {
		$trvl_guid_id 		= $_GET['tvlguidid'];
		$tvlGuidDetailsArr 	= $tvlguidObj->fun_getTravelInfo($trvl_guid_id);
		if(!is_array($tvlGuidDetailsArr) || count($tvlGuidDetailsArr) < 1) {
			redirectURL("holiday-travelguides.php");
		} else {
			// other details
		}
	} else {
		$trvl_guid_id 		= $tvlguidObj->fun_getLatestTravelId();
		$tvlGuidDetailsArr 	= $tvlguidObj->fun_getTravelInfo($trvl_guid_id);
	}

	// Page details
	$page_id  				= 29;
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
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>dhtmlwindow.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>common.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>pop-up.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>tab_menu.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>dargPop.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>equal_height.js"></script>
    <script language="javascript" type="text/javascript">
        var req = ajaxFunction();
        var x, y;
        function show_coords(event){	
            x=event.clientX;
            y=event.clientY;
            x = x-160;
            y = y+4;
        //	alert(x);alert(y);
        }
        function toggleLayer(whichLayer){
            var output = document.getElementById(whichLayer).innerHTML;
            if(whichLayer == 'ANP-Example')
            {		
                output = '<div style="z-index:5;">'+output+'</div>';
                var googlewin=dhtmlwindow.open("Example", "inline", output, "", "width=295px,height=470px,resize=0,scrolling=0,center=1,xAxis="+x+",yAxis="+y+"", "recal");
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
        
        function shwEventDetails (strEventCode, strEventList) {
            document.getElementById("eventDetailsDivId").style.display = "block";
            document.getElementById("eventsLisitingDivId").style.display = "none";
            req.onreadystatechange=function() {
                if(req.readyState==1) { //Loading
                    document.getElementById("eventDetailsDivId").innerHTML="<table width=\"450\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td align=\"left\" valign=\"top\">Loading...</td></tr></table>";
                }
                if(req.readyState==4) { //Complete
                    document.getElementById("eventDetailsDivId").innerHTML = req.responseText
                }
            }
            url = "showEventDetails.php?ec=" + strEventCode +"&list=" + strEventList;
            req.open("GET",url,true);
            req.send(null);
        }
        
        function backToResult() {
            document.getElementById("eventDetailsDivId").innerHTML="";
            document.getElementById("eventDetailsDivId").style.display = "none";
            document.getElementById("eventsLisitingDivId").style.display = "block";
        }
        function showPropImg(strsrc, strcap, strphotoby, strphotolink){
            document.getElementById("txtTvlGuidPhotoId").src = strsrc;
            document.getElementById("txtTvlGuidPhotoId").alt = strcap;
            document.getElementById("txtTvlGuidPhotoCaptionId").innerHTML = strcap;
            if(strphotoby != "") {
                var strphotolink = strphotolink;
                if(strphotolink.indexOf("http://") == -1) {
                    strphotolink = "http://"+strphotolink;
                }
                if((strphotolink != "") && (strphotolink != "http://")) {
                    document.getElementById("txtTvlGuidPhotoById").innerHTML = "<a href=\""+strphotolink+"\" style=\"text-decoration:none; color:#585858;\" target=\"_blank\">Photo by "+strphotoby+"</a>";
                } else {
                    document.getElementById("txtTvlGuidPhotoById").innerHTML = "Photo by "+strphotoby;
                }
            } else {
                document.getElementById("txtTvlGuidPhotoById").innerHTML = "";
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
    <div id="pg-wrapper" align="center"><h1 class="page-heading">Travel Guide</h1></div>
    <div id="main">
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="left" valign="top">
					<?php require_once(SITE_INCLUDES_PATH.'holiday-travelguides-left-links.php'); ?>
                </td>
                <td width="30" align="left" valign="top" style="border-right:thin #efefef solid;">&nbsp;</td>
                <td align="left" valign="top" class="font12" style="padding-left:10px;">
					<?php require_once(SITE_INCLUDES_PATH.'holidaytravelguides.php'); ?>
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
