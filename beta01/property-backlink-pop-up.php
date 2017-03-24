<?php	
	require_once("includes/owner-top.php");
?>
<?php	
if(isset($_GET['pid']) && $_GET['pid'] !=""){
	$property_id 		= $_GET['pid'];
	if($propertyObj->fun_checkPropertyOwner($property_id, $user_id) == false) {
		redirectURL(SITE_URL."index.php");
	}
	$propertyInfo		= $propertyObj->fun_getPropertyInfo($property_id);
	$property_type_name	= ucfirst($propertyInfo['property_type_name']);
	$propLocInfoArr 	= $propertyObj->fun_getPropertyLocInfoArr($property_id);
	$arr				= array();
	if($propLocInfoArr['countries_name'] !=""){
		$link1 = "<a href=\"".SITE_URL."vacation-rentals/in.".str_replace("/", "_", str_replace(" ", "-", strtolower($propLocInfoArr['countries_name'])))."\">".$property_type_name." rentals in ".ucwords($propLocInfoArr['countries_name'])."</a>";
		array_push($arr, $link1);
	}
	if($propLocInfoArr['area_name'] !=""){
		$link2 = "<a href=\"".SITE_URL."vacation-rentals/in.".str_replace("/", "_", str_replace(" ", "-", strtolower($propLocInfoArr['area_name'])))."\">".$property_type_name." rentals in ".ucwords($propLocInfoArr['area_name'])."</a>";
		array_push($arr, $link2);
	}
	$links 		= "Find your perfect vacation rentals on rentownersvillas.com, best deals available for ".implode(" and ", $arr).".";
	$strHTML	= "<!--Begin ".SITE_NAME."-Code -->".$links."<!--End ".SITE_NAME."-Code -->";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo $sitetitle;?> :: Owner :: Matching Link codes</title>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo tranText('charset'); ?>" />
    <META HTTP-EQUIV="Content-language" CONTENT="<?php echo tranText('lang_iso'); ?>">
    <link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo SITE_URL; ?>favicon.ico" />
    <link rel="SHORTCUT ICON" href="<?php echo SITE_URL; ?>favicon.ico"/>
    <link href="<?php echo SITE_CSS_INCLUDES_PATH;?>owner.css" rel="stylesheet" type="text/css" />
	<?php /*?>
	<script type="text/javascript" src="<?php echo SITE_URL;?>jquery/js/jquery-1.6.2.js"></script>
	<script type="text/javascript" src="<?php echo SITE_URL;?>jquery/js/jquery.zclip.js"></script>
	<script>
    $(document).ready(function(){
        $('a#copy-backlinkcode').zclip({
            path:'file/ZeroClipboard.swf',
            copy:$('textarea#backlinkcode').val()
        });
        // The link with ID "copy-backlinkcode" will copy
        // the text of the paragraph with ID "backlinkcode"
    });
    </script>
	<?php */?>
</head>
<body style="color:#585858;">
<table width="560" border="0" align="center" cellpadding="0" cellspacing="5" style="background:#FFFFFF;">
    <tr><td align="left"><img src="<?php echo SITE_IMAGES;?>logo.jpg" /></td></tr>
    <tr>
        <td style="padding:20px;">
            <h3>Matching Link codes</h3><br />
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr><td align="left" valign="top">[property type][country] and [property type][region]</td></tr>
                <tr>
                	<td align="left" valign="top">
                    <textarea name="backlinkcode" id="backlinkcode" cols="" rows="" class="txtarea_500x80" onclick="this.select();"><?php echo $strHTML;?></textarea>
					<?php /*?>
                    <br /><a href="#" id="copy-backlinkcode" class="button-blue" style="text-decoration:none;">Copy</a>
					<?php */?>
                    <br /><span class="pdError1"><em>A) Copy &amp; placed the above linkcode to your website.<br />B) Close this window &amp; click on "Activation" button.</em></span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
<?php
} else {
	echo "Access Denied";
}
?>