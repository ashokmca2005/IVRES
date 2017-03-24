<?php
require_once("includes/application-top-inner.php");
if(isset($_GET['tvlguidid']) && $_GET['tvlguidid'] !="") $trvl_guid_id = $_GET['tvlguidid'];
$uploadsuccess = false;
if($_POST['securityKey']==md5(TRAVELGUIDEPHOTOSUPLOAD)){
	if(isset($_FILES['txtFile']) && ($_FILES['txtFile'] !="")){ // edit
		if(!isset($trvl_guid_id)) {
			$trvl_guid_id = $_REQUEST[PHPSESSID];
        }
		//for photo caption details
		if(isset($_POST['txtTvlGuidPhotoCaption']) && $_POST['txtTvlGuidPhotoCaption'] != "") {
			$txtTvlGuidPhotoCaption = $_POST['txtTvlGuidPhotoCaption'];
			$photo_caption			= $txtTvlGuidPhotoCaption[0];
		}

		if(isset($_POST['txtTvlGuidPhotoBy']) && $_POST['txtTvlGuidPhotoBy'] != "") {
			$txtTvlGuidPhotoBy 	= $_POST['txtTvlGuidPhotoBy'];
			$photo_by			= $txtTvlGuidPhotoBy[0];
		}

		if(isset($_POST['txtTvlGuidPhotoLink']) && $_POST['txtTvlGuidPhotoLink'] != "") {
			$txtTvlGuidPhotoLink= $_POST['txtTvlGuidPhotoLink'];
			$photo_link			= $txtTvlGuidPhotoLink[0];
		}

        $main_img_id 	= $tvlguidObj->fun_addTvlGuidImg($trvl_guid_id, $photo_caption, '', '', 0);

		$trvl_guid_img 	= basename($_FILES['txtFile']['name']);
		$extn 		= split("\.",$trvl_guid_img);
		
		$photo_main 	= $trvl_guid_id."_".$main_img_id."_photo.".$extn[1];
		$photo_thumb 	= $trvl_guid_id."_".$main_img_id."_photo_thumb.".$extn[1];
		$uploadphotodir = '../upload/tvlguid_images/large';
		$uploadthumbdir = '../upload/tvlguid_images/thumbnail';

		$uploadphotofile = $uploadphotodir ."/". $photo_main;
		$uploadphotofile449x341 	= $uploadphotodir ."/449x341/". $photo_main;
		$uploadphotofile168x127 	= $uploadthumbdir ."/168x127/". $photo_thumb;

		if (move_uploaded_file($_FILES['txtFile']['tmp_name'], $uploadphotofile)){
			//croping done
			$imgObj->getCrop($uploadphotodir,$photo_main,449,341,$uploadphotofile449x341);
			$imgObj->getCrop($uploadphotodir,$photo_main,168,127,$uploadphotofile168x127);

        	$tvlguidObj->fun_updateTvlGuidImg($main_img_id, $trvl_guid_id, $photo_caption, $photo_main, $photo_thumb, $photo_by, $photo_link, 0);
			$uploadsuccess = true;
		}
	}
}

$tvlguidPhotoThumb 	= TVLGUID_IMAGES_THUMB168x127_PATH."main-picture.gif";
$tvlguidPhotoCaption= "Add caption for image ...";
$tvlguidPhotoCaption.= "\nLeave blank if not required";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title><?php echo $sitetitle;?> :: Admin :: Travel Guide Upload Photos</title>
    <link href="includes/css/admin.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>admin.js"></script>
	<script language="JavaScript">
    <!--
		function refreshParent() {
			window.opener.location.href = window.opener.location.href;
			if (window.opener.progressWindow) {
				window.opener.progressWindow.close()
			}
			window.close();
		}
    //-->
    </script>
</head>
<body>
<div align="center" style="padding:0px 10px 0px 10px; font-size:12px; background-color:#FFFFFF;">
<?php
if(isset($uploadsuccess) && $uploadsuccess == true) {
	echo "<script language=\"JavaScript\">refreshParent();</script>";
} else {
?>
<table border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td  valign="top" style="padding:0px;">
            <form name="frmAddTvl" id="frmAddTvl" action="admin-tvl-guide-img-upload.php<?php if(isset($trvl_guid_id) && $trvl_guid_id != "") { echo "?tvlguidid=".$trvl_guid_id; } ?>" method="post" enctype="multipart/form-data" >
            <input type="hidden" name="securityKey" id="securityKey" value="<?php echo md5('TRAVELGUIDEPHOTOSUPLOAD')?>">
            <script language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>si.files.js" type="text/javascript"></script>
            <script type="text/javascript" language="javascript">
                function uploadFile(obj, val) {
                    fileVal 		= "txtFile"+val;
                    filePhotoVal	= "txtPhoto"+val;
                    photoError		= "photoError"+val;
                    fileUrl 		= document.getElementById(fileVal).value;
                    fileUrl				= rm_trim(fileUrl);
                    if(fileUrl == ""){
                        document.getElementById(photoError).innerHTML = "<font color='#BF0000' size='2'><strong>Please select a photo to upload</strong></font>";
                        document.getElementById(filePhotoVal).focus();
                        return false;
                    } else {
                        document.getElementById(photoError).innerHTML = "";
                        obj.submit();
                    }	
                }        
            
                function showValue(val){		
                    var filePath = "txtFile"+val;
                    var file_photo = "txtPhoto"+val;
                    document.getElementById(file_photo).value = document.getElementById(filePath).value;
                }
            </script>
            <style type="text/css" title="text/css">
            .SI-FILES-STYLIZED label.cabinet{
                width: 57px;
                height: 23px;
                background-image: url(images/browse.gif);
                background-repeat: no-repeat;
                display: block;
                overflow: hidden;
                cursor: pointer;
                position: relative;
            }
            .SI-FILES-STYLIZED label.cabinet input.file{
                position: relative;
                width: auto;
                height: 100%;
                _display: block;
                _float: right;
                _height: 23px;
                _width: 57px;
                opacity: 0;
                -moz-opacity: 0;
                filter:progid:DXImageTransform.Microsoft.Alpha(opacity=0);
            }
            </style>
            <table border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
                <tr>
                    <td>
                    <img src="<?php echo $tvlguidPhotoThumb; ?>" name="PreviewImage0" width="199" height="149" class="photo-add" id="PreviewImage0" />
                    </td>
                    <td align="left" valign="top" class="pad-rgt10">
                        <table border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td style="padding-top:13px;">
                                    <div style="width: 57px; height:23px; overflow: hidden;">
                                        <label class="cabinet">
                                            <input type="file" name="txtFile" id="txtFile0" class="file" value="" onchange="return showValue('0');"/>
                                        </label>
                                    </div>
                                </td>
                                <td style="padding-top:13px;"><input name="txtPhoto" type="text" id="txtPhoto0"  style="width:205px; height:17px; border: solid 1px #aeaeae; padding-top:2px; padding-bottom:2px; padding-left:5px;" value="" /></td>
                                <td style="padding-top:13px;"><img src="images/upload.gif" alt="upload" onclick="return uploadFile(document.frmAddTvl, '0');" /></td>
                            </tr>
                            <tr>
                                <td style="padding-top:16px; padding-left:00px;" colspan="3">
                                    <p style="float:left; font-size:12px; padding-top:10px;">
                                        <textarea name="txtTvlGuidPhotoCaption[]" id="txtTvlGuidPhotoCaptionId0" class="textArea260x60" onclick="return bnkTvlGuidImgCaption('0');" onblur="return restoreTvlGuidImgCaption('0');" ><?php echo $tvlguidPhotoCaption; ?></textarea>
                                        <div style=" padding-bottom:10px;">
                                        <input name="txtTvlGuidPhotoBy[]" id="txtTvlGuidPhotoById0" class="inpuTxt270" value="Photo by" type="text" onclick="return bnkTvlGuidPhotoBy('0');" onblur="return restoreTvlGuidPhotoBy('0');"  onkeydown="chkblnkTxtError('txtTvlGuidPhotoById0', 'photoError0');" onkeyup="chkblnkTxtError('txtTvlGuidPhotoById0', 'photoError0');" />
                                        </div>
                                        <input name="txtTvlGuidPhotoLink[]" id="txtTvlGuidPhotoLinkId0" class="inpuTxt270" value="http://" type="text" onclick="return bnkTvlGuidPhotoLink('0');" onblur="return restoreTvlGuidPhotoLink('0');"  onkeydown="chkblnkTxtError('txtTvlGuidPhotoLinkId0', 'photoError0');" onkeyup="chkblnkTxtError('txtTvlGuidPhotoLinkId0', 'photoError0');" />
                                    </p>
                                    <script type="text/javascript" language="javascript">
                                    // <![CDATA[
                                    
                                    SI.Files.stylizeAll();
                                    
                                    /*
                                    --------------------------------
                                    Known to work in:
                                    --------------------------------
                                    - IE 5.5+
                                    - Firefox 1.5+
                                    - Safari 2+
                                    --------------------------------
                                    Known to degrade gracefully in:
                                    --------------------------------
                                    - Opera
                                    - IE 5.01
                                    --------------------------------
                                    Optional configuration:
                                    
                                    Change before making method calls.
                                    --------------------------------
                                    SI.Files.htmlClass = 'SI-FILES-STYLIZED';
                                    SI.Files.fileClass = 'file';
                                    SI.Files.wrapClass = 'cabinet';
                                    
                                    --------------------------------
                                    Alternate methods:
                                    --------------------------------
                                    SI.Files.stylizeById('input-id');
                                    SI.Files.stylize(HTMLInputNode);
                                    
                                    --------------------------------
                                    */
                                    // ]]>
                                    </script>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <table cellpadding="0" cellspacing="0" width="100%" border="0">
                                        <tr>
                                            <td width="240" valign="bottom"><div id="photoError0"></div></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="pad-lft15"><?php if(isset($tvlguidMainPhotoId) && $tvlguidMainPhotoId !="") {echo "<a href=\"JavaScript:delTvlGuidPhoto(".$tvlguidMainPhotoId.");\" class=\"delete-photo\">Remove picture</a>&nbsp;&nbsp;<a href=\"javascript:addNewPhoto();\" class=\"add-photo\">Add new picture</a>";}?></td>
                </tr>
                <tr><td colspan="2">&nbsp;</td></tr>
            </table>
        </form>
        </td>
    </tr>
</table>
<?php
}
?>
</div>
</body>
</html>
