<?php	
	if($_SERVER["SERVER_NAME"] == "localhost") {
		require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
	} else {
		require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
	}

	require_once(SITE_CLASSES_PATH."class.Users.php");
	require_once(SITE_CLASSES_PATH."class.Property.php");
	require_once(SITE_CLASSES_PATH."class.CMS.php");
	require_once(SITE_CLASSES_PATH."class.Banner.php");

	$usersObj 		= new Users();
	$propertyObj 	= new Property();
	$cmsObj         = new Cms();
	$bannerObj      = new Banner();
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
    <div id="pg-wrapper" align="center"><h1 class="page-heading">Oops, the page you are looking for not found!</h1></div>
    <div id="main">
        <div class="pad-top20 pad-lft10 pad-rgt10 pad-btm20">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="pad-top10">
                <tr><td align="center" valign="middle" height="577px"><img src="images/404.jpg" width="460" height="577" border="none" /></td></tr>
            </table>
            <p>&nbsp;</p>
            <p class="font12">We are sorry the page you wanted does not exists, but if you are looking for a place for stay, you have come to the right place! rentownersvillas.com has many <strong>Vacation Rental Homes</strong>, <strong>Apartments</strong>, <strong>Condo</strong>, <strong>Luxury Villas</strong>, <strong>Cottages</strong> and <strong>Cabin</strong> for rent around the world. <strong>Return to the</strong> <a href="<?php echo SITE_URL; ?>" class="blue-link">Homepage</a>.</p>
            <p>&nbsp;</p>
        </div>
        <div class="clearfix"></div>
        <div class="pad-lft10 pad-rgt10">
            <script type="text/javascript" src="<?php echo SITE_URL;?>jquery/js/jquery.ui.accordion.js"></script>
            <script>
                $(function() {
                    $( "#accordion" ).accordion({
                        autoHeight: false,
                        navigation: true
                    });
                });
            </script>
            <style type="text/css">
            .node-links ul {
                float:left;
                margin-bottom:0px;
                margin-top:0px;
                list-style:none;
                width:260px;
                padding:0 8px;
                margin:0;
                border-left:1px solid #D8E7F2;
                _position:relative;
                _zoom:1;
            }
            
            .node-links ul li {
                text-decoration:none;
                list-style:none;
                margin:0px;
                width:255px;
                display:block;
                padding:2px 2px;
                white-space:nowrap;
                list-style-position:outside;
            }
            
            .node-links ul.first {
                padding-left:0;
                border-left:none;
            }
            
            .node-links ul.first li {
                text-decoration:none;
                list-style:none;
                margin:0px;
                width:255px;
                display:block;
                padding:2px 2px;
                white-space:nowrap;
                list-style-position:outside;
            }
            
            .node-links a {
                color:#0092d6;
                text-decoration:none;
                font-size:12px;
            }
            .node-links a:visited {
                color:#0092d6;
                text-decoration:none;
                font-size:12px;
            }
            .node-links a:hover {
                color:#0092d6;
                text-decoration:underline;
                font-size:12px;
            }
            </style>
            <div id="accordion">
                <h3><a href="#section1">Select a vacation rental location ...</a></h3>
                <div>
                    <p>
                    <?php echo $propertyObj->fun_createDesLstWthPptCntHome(); ?>
                    </p>
                    <p>
                    <?php echo $propertyObj->fun_createDesLstWthPptCntHome(223); ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
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
