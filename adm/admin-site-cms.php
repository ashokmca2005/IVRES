<?php
require_once("includes/application-top-inner.php");
if(isset($_GET['page_id']) && $_GET['page_id'] !="") $page_id = $_GET['page_id'];

$mainPage = "admin-site-cms-pages.php";
$addtitle = "CMS";

//form submission
$form_array = array();
$errorMsg 	= "no";

// Edit page submit : Start here 
if($_POST['securityKey']==md5("EDITPAGE")){	
	if(trim($_POST['page_title']) == '') {
		$form_array['page_title_error'] = 'Page title required';
		$errorMsg = 'yes';
	}

	if(trim($_POST['page_content_title']) == '') {
		$form_array['page_content_title_error'] = 'Content title required';
		$errorMsg = 'yes';
	}

	if(trim($_POST['page_discription']) == '') {
		$form_array['page_discription_error'] = 'Page description required';
		$errorMsg = 'yes';
	}

	if(trim($_POST['page_seo_title']) == '') {
		$form_array['page_seo_title_error'] = 'SEO title required';
		$errorMsg = 'yes';
	}

	if(trim($_POST['page_seo_keyword']) == '') {
		$form_array['page_seo_keyword_error'] = 'SEO Keyword required';
		$errorMsg = 'yes';
	}

	if(trim($_POST['page_seo_discription']) == '') {
		$form_array['page_seo_discription_error'] = 'SEO description required';
		$errorMsg = 'yes';
	}

   if($errorMsg == 'no' && $errorMsg != 'yes') {
		$page_id 				= $_POST['page_id'];
		$page_title 			= $_POST['page_title'];
		$page_content_title 	= $_POST['page_content_title'];
		$page_discription 		= $_POST['page_discription'];
		$page_seo_title 		= $_POST['page_seo_title'];
		$page_seo_keyword 		= $_POST['page_seo_keyword'];
		$page_seo_discription 	= $_POST['page_seo_discription'];
		$page_type 				= $_POST['page_type'];

		$cmsObj->fun_editPage($page_id, $page_title, $page_content_title, $page_discription, $page_seo_title, $page_seo_keyword, $page_seo_discription, $page_type);
		$redirect_url 			= "admin-site-cms.php?page_type=".$page_type."&sec=edit&page_id=".$page_id;
		redirectURL($redirect_url);
	} else {
		$form_array['error_msg'] = "Please submit your form again!";
	}	
}
// Edit restaurant details submit : End here 

// add a new page submit : Start here 
if($_POST['securityKey']==md5("ADDPAGE")){	

	if(trim($_POST['page_title']) == '') {
		$form_array['page_title_error'] = 'Page title required';
		$errorMsg = 'yes';
	}

	if(trim($_POST['page_content_title']) == '') {
		$form_array['page_content_title_error'] = 'Content title required';
		$errorMsg = 'yes';
	}

	if(trim($_POST['page_discription']) == '') {
		$form_array['page_discription_error'] = 'Page description required';
		$errorMsg = 'yes';
	}

	if(trim($_POST['page_seo_title']) == '') {
		$form_array['page_seo_title_error'] = 'SEO title required';
		$errorMsg = 'yes';
	}

	if(trim($_POST['page_seo_keyword']) == '') {
		$form_array['page_seo_keyword_error'] = 'SEO Keyword required';
		$errorMsg = 'yes';
	}

	if(trim($_POST['page_seo_discription']) == '') {
		$form_array['page_seo_discription_error'] = 'SEO description required';
		$errorMsg = 'yes';
	}

   if($errorMsg == 'no' && $errorMsg != 'yes') {
		$page_title 			= $_POST['page_title'];
		$page_content_title 	= $_POST['page_content_title'];
		$page_discription 		= $_POST['page_discription'];
		$page_seo_title 		= $_POST['page_seo_title'];
		$page_seo_keyword 		= $_POST['page_seo_keyword'];
		$page_seo_discription 	= $_POST['page_seo_discription'];
		$page_type 				= $_POST['page_type'];

		$page_id 				= $cmsObj->fun_addPage($page_title, $page_content_title, $page_discription, $page_seo_title, $page_seo_keyword, $page_seo_discription, $page_type);
		$redirect_url 			= "admin-site-cms.php?page_type=".$page_type."&sec=edit&page_id=".$page_id;
		
		redirectURL($redirect_url);
	} else {
		$form_array['error_msg'] = "Please submit your form again!";
	}	
}
// add a new page submit : End here 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title><?php echo $sitetitle;?> :: Admin :: <?php if(isset($addtitle) && $addtitle !="") echo ":: ".$addtitle;?></title>
    <link href="includes/css/admin.css" rel="stylesheet" type="text/css" />
	<link href="../css/pop-up-cal.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" language="javascript" src="includes/js/admin.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>dhtmlwindow.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>pop-up.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>tab_menu.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>dargPop.js"></script>
	<script language="javascript" type="text/javascript">
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
		if(whichLayer == 'page-delete-pop')
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
	</script>
</head>
<body onmousedown="show_coords(event);">
<!-- Main Wrapper Starts Here -->
<div id="MainWrapper">
    <!-- Header Include Starts Here -->
    <div>
        <?php require_once('includes/admin-header.php'); ?>
    </div>
    <!-- Header Include Ends Here -->
    <div id="div">
    <table width="974" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td class="width18">&nbsp;</td>
            <td valign="top" class="width210"><?php require_once('includes/admin-left-links.php'); ?></td>
            <td valign="top" class="width26">&nbsp;</td>
            <td valign="top" class="width690">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                    <tr>
                        <td valign="top" class="SectionHead">Site CMS</td>
                        <td valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                        <td valign="top" colspan="2">
						<?php require_once("includes/".$mainPage); ?>
                        </td>
                    </tr>
                </table>
            </td><td class="width22">&nbsp;</td>
        </tr>
    </table>
    </div>
    <!-- Footer Include Starts Here -->
    <div>
        <?php require_once('includes/admin-footer.php'); ?>
    </div>
    <!-- Footer Include Ends Here -->
</div>
<!-- Main Wrapper Ends Here -->
</body>
</html>
