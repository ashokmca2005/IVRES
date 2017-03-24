<?php	
if($_SERVER["SERVER_NAME"] == "localhost") {
	require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
} else {
	require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
}
require_once(SITE_CLASSES_PATH."class.Users.php");
require_once(SITE_CLASSES_PATH."class.Location.php");
$locationObj = new Location();

$usersObj = new Users();

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
	<script type="text/javascript" language="JavaScript" src="<?php echo SITE_JS_INCLUDES_PATH;?>dargPop.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>dhtmlwindow.js"></script>
	<script language="javascript" type="text/javascript">
        var x, y;
        function show_coords(event){	
            x=event.clientX;
            y=event.clientY;
            x = x-160;
            y = y+4;
            //alert(x);alert(y);
        }
    </script>
	<script type="text/javascript">
    function toggleLayer( whichLayer )
    {
      var elem, vis;
      if( document.getElementById ) // this is the way the standards work
        elem = document.getElementById( whichLayer );
      else if( document.all ) // this is the way old msie versions work
          elem = document.all[whichLayer];
      else if( document.layers ) // this is the way nn4 works
        elem = document.layers[whichLayer];
      vis = elem.style;
      // if the style.display value is blank we try to figure it out here
      if(vis.display==''&&elem.offsetWidth!=undefined&&elem.offsetHeight!=undefined)
        vis.display = (elem.offsetWidth!=0&&elem.offsetHeight!=0)?'block':'none';
      vis.display = (vis.display==''||vis.display=='block')?'none':'block';
    }
    </script>

	<script language="javascript" type="text/javascript">
    /*
    * Section for Location control using ajax
    */
    
    var req = ajaxFunction();
    
    function chkRegionMapSearch(obj){
        var regionid = obj.value;
        var act = "add";
    
        if(obj.checked == true) {
            act = "add";
        } else {
            act = "del";
        }
    
    /*
        req.open('get', 'add-map-searchAjax.php?act='+act+'&destinationtype=region&destinationid=' + regionid); 
        req.onreadystatechange = chkClear; 
        req.send(null); 
    */
        showMapSearch ();
    }
    
    function showMapSearch ()
    {
        req.onreadystatechange=function()
        {
            if(req.readyState==1)	//Loading
            {
                document.getElementById("showMapSearchs").innerHTML="Loading...";
            }
            if(req.readyState==4)	//Complete
            {
                document.getElementById("showMapSearchs").innerHTML = req.responseText
            }
        }
    
        url = "show-map-searchs-left.php";
        req.open("GET",url,true);
        req.send(null);
    }
</script>
</head>

<body>
<!-- Main Wrapper Starts Here -->
<div id="wrapper">
    <!-- Header Include Starts Here -->
    <div id="header" align="center">
        <?php require_once(SITE_INCLUDES_PATH.'header.php'); ?>
    </div>
    <!-- Header Include End Here -->
	<?php require_once(SITE_INCLUDES_PATH.'holidayadvsearch.php'); ?>
	<?php //require_once(SITE_INCLUDES_PATH.'breadcrumb.php'); ?>
    <div id="pg-wrapper" align="center"><h1 class="page-heading"><?php echo $page_title; ?></h1></div>
    <div id="main"><?php echo $page_discription; ?></div>
</div>
<!-- Main Wrapper End Here -->
<!-- Footer Include Starts Here -->
<div id="footer">
    <?php require_once(SITE_INCLUDES_PATH.'footer.php'); ?>
</div>
<!-- Footer Include End Here -->
</body>
</html>
