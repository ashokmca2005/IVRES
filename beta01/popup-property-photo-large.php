<?php
if($_SERVER["SERVER_NAME"] == "localhost") {
	require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
} else {
	require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
}
require_once(SITE_CLASSES_PATH."class.Users.php");
require_once(SITE_CLASSES_PATH."class.Property.php");
$usersObj 		= new Users();
$propertyObj 	= new Property();

//$usersObj->CheckUserLogin();

/*
// For Hot property Section : Start Here
*/
if(isset($_GET['pid']) && $_GET['pid'] !=""){
	$property_id = $_GET['pid'];
	$propertyPhotosInfo	= $propertyObj->fun_getPropertyPhotosAllInfoArr($property_id);
//	print_r($propertyPhotosInfo);

	$total_photos 		= count($propertyPhotosInfo);
	if ( isset ( $_GET['imgid'] ) && $_GET['imgid'] !="" ) {
		$imgid 	= $_GET['imgid'];
//		echo $imgid;
		$propertyPhotoInfo	= $propertyObj->fun_getPropertyPhotoInfoArr($property_id, $imgid);
		$imgid 		= $propertyPhotoInfo[0]['photo_id'];
		$imgcap 	= ucfirst($propertyPhotoInfo[0]['photo_caption']);
		$imgurl 	= PROPERTY_IMAGES_LARGE.$propertyPhotoInfo[0]['photo_url'];
		$imgthumb 	= PROPERTY_IMAGES_THUMB168x126.$propertyPhotoInfo[0]['photo_thumb'];
	
	} else {
		foreach( $propertyPhotosInfo as $value) {
			if ( $value['photo_main'] == 1 ) {
				$imgid 		= $value['photo_id'];
				$imgcap 	= ucfirst($value['photo_caption']);
				$imgurl 	= PROPERTY_IMAGES_LARGE.$value['photo_url'];
				$imgthumb 	= PROPERTY_IMAGES_THUMB168x126.$value['photo_thumb'];
			}
		}
	}
}
/*
// For Hot property Section : End Here
*/
?>
<div id="definition">
<table width="100%" height="200" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
    <tr height="5">
        <td width="15" valign="top"><img src="images/Pop-Up-TopLft.gif" alt="ANP" width="15" height="15" /></td>
        <td class="poptop" valign="top"></td>
        <td width="15" valign="top"><img src="images/Pop-Up-TopRight.gif" alt="ANP" width="15" height="15" /></td>
    </tr>
    <tr>
        <td width="15" valign="top" class="popleft">&nbsp;</td>
        <td  align="left" valign="top">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td colspan="3" align="right" valign="top">
                        <table width="13" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td align="right" width="13" valign="top" class="pad-btm7"><a href="#" class="lbAction" rel="deactivate"><img src="images/pop-up-cross.gif" alt="Close" width="13" height="13" border="0"  title="Close" /></a></td>
                            </tr>
                        </table>                               
                    </td>
                </tr>
                <tr>
                    <td align="left" valign="top" class="boldTitle">Picture 1 of <?php echo $total_photos; ?></td>
                    <td colspan="2" align="right" valign="top" class="font12">
                        <div class="pagination">
                            <a href="#">First</a> <a href="#">&lt;</a> <a href="#">1</a> | 2 | <a href="#">3</a> | <a href="#">4</a> | <a href="#">5</a>... <a href="#">23</a> <a href="#">&gt;</a> <a href="#">Last</a>
                        </div>
                    </td>
                </tr>
                <tr><td colspan="3"  align="left" valign="top" class="dash25">&nbsp;</td></tr>
                <tr>
                    <td colspan="3"  align="left" valign="top" class="font12">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td><span class="PopTxt"><?php echo $imgcap;?></span></td>
                                <td align="right" valign="top" class="font12"><a href="#" class="arrowLinkback">Back</a>&nbsp; <span class="boldblack12">|</span> &nbsp; <a href="#" class="arrowLinkNext">Next</a></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr><td height="12" colspan="3" align="left" valign="top"></td></tr>
                <tr>
                    <td colspan="3" align="center" valign="bottom">
                        <table border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td><img src="<?php echo $imgurl; ?>" /></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
        <td width="15" class="popright"></td>
    </tr>
    <tr height="5">
        <td width="15" valign="bottom"><img src="images/Pop-Up-BtmLft.gif" alt="ANP" width="15" height="15" /></td>
        <td valign="bottom" class="popbtm"></td>
        <td width="15" valign="bottom"><img src="images/Pop-Up-BtmRight.gif" alt="ANP" width="15" height="15" /></td>
    </tr>
</table>
</div>
