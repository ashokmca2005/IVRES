<?php	
	require_once("includes/owner-top.php");
?>
<?php	
	if(isset($_GET['pid']) && $_GET['pid'] !=""){
		$property_id 		= $_GET['pid'];
		if($propertyObj->fun_checkPropertyOwner($property_id, $user_id) == false) {
			redirectURL(SITE_URL."property-add-more-photos-pop-up.php");
		}


		//form submission
		$form_array = array();
		$errorMsg 	= "no";
		// Owner property photos submit : start here 
		if($_POST['securityKey']==md5(OWNERPROPERTYPHOTOSUPLOAD)){
			if(!isset($_FILES['txtFile0']) || empty($_FILES['txtFile0'])) {
				$errorMsg = 'yes';
			}

			if($errorMsg == 'no' && $errorMsg != 'yes'){
				$total = 0;
				while ($_FILES['txtFile'.$total]['name'] != "") {
					$total++;
					if ($_FILES['txtFile'.$total]['name'] == "") break;
				}

				for($j = 0; $j < $total; $j++) {
					if(($photo_id = $propertyObj->fun_addPropertyPhotos($property_id)) && $photo_id !="") {
						$photo_caption 	= $_POST['txtPhotoCaption'][$j];
						$property_img 	= basename($_FILES['txtFile'.$j]['name']);
						$extn 			= split("\.", $property_img);
						$photo_main 	= $property_id."_".$photo_id."_photo.".$extn[1];
						$photo_thumb 	= $property_id."_".$photo_id."_photo_thumb.".$extn[1];
						
						$uploadphotodir = 'upload/property_images/large';
						$uploadthumbdir = 'upload/property_images/thumbnail';
						$uploadphotofile = $uploadphotodir ."/". $photo_main;
						$uploadphotofile600x450 	= $uploadphotodir ."/600x450/". $photo_main;
						$uploadphotofile480x360 	= $uploadphotodir ."/480x360/". $photo_main;
						$uploadphotofile244x183 	= $uploadphotodir ."/244x183/". $photo_main;
						$uploadthumbfile168x126 	= $uploadthumbdir ."/168x126/". $photo_thumb;
						$uploadthumbfile88x66	 	= $uploadthumbdir ."/88x66/". $photo_thumb;
		
						if (move_uploaded_file($_FILES['txtFile'.$j]['tmp_name'], $uploadphotofile)){
							$imgObj->getCrop($uploadphotodir,$photo_main,600,450,$uploadphotofile600x450);
							$imgObj->getCrop($uploadphotodir,$photo_main,480,360,$uploadphotofile480x360);
							$imgObj->getCrop($uploadphotodir,$photo_main,244,183,$uploadphotofile244x183);
							$imgObj->getCrop($uploadphotodir,$photo_main,168,126,$uploadthumbfile168x126);
							$imgObj->getCrop($uploadphotodir,$photo_main,88,66,$uploadthumbfile88x66);
							if($propertyObj->fun_updatePropertyPhotos($property_id, $photo_id, $photo_caption, $photo_main, $photo_thumb) === true){
								$propertyObj->fun_updatePropertyLastUpdate($property_id);
							}
						} else {
							$propertyObj->fun_delPropertyPhoto($photo_id);
						}
					}
				}
				echo "<script>top.opener.location.reload();</script>";
			} else {
				$detail_array['error_msg'] = "Please submit your form again!";
			}
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo $sitetitle;?> :: Owner :: Add / Edit Property</title>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo tranText('charset'); ?>" />
    <META HTTP-EQUIV="Content-language" CONTENT="<?php echo tranText('lang_iso'); ?>">
    <link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo SITE_URL; ?>favicon.ico" />
    <link rel="SHORTCUT ICON" href="<?php echo SITE_URL; ?>favicon.ico"/>
    <link href="<?php echo SITE_CSS_INCLUDES_PATH;?>owner.css" rel="stylesheet" type="text/css" />
</head>
<body style="color:#585858;">
<table width="560" border="0" align="center" cellpadding="0" cellspacing="5" style="background:#FFFFFF;">
    <tr><td align="left"><img src="<?php echo SITE_IMAGES;?>logo.jpg" /></td></tr>
    <tr>
        <td style="padding:20px;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
			<?php
            if(isset($property_id) && $property_id != "") {
				$photosArray 		= $propertyObj->fun_getPropertyPhotosAllInfoArr($property_id);
				$allowedTotalPhotos = 12;
				$buyTotalPhotos		= $propertyObj->fun_countPropertyBuyPhotos($property_id);
				if($buyTotalPhotos > 0) {
					$allowedTotalPhotos += $buyTotalPhotos;
				}
				$allowedTotalPhotos = ($allowedTotalPhotos - count($photosArray));
				
				if($allowedTotalPhotos > 0) {
				?>
                    <tr><td align="left" valign="top" class="pad-btm18 font14 pad-top10">Browse images from your computer, add title to each photos and click on upload images. Once done close the windows</td></tr>
                    <tr><td align="left" valign="top" class="pink14">Upload Property photos</td></tr>
                    <tr>
                    	<td class="pad-top10" align="left" valign="top">
                        <script language="javascript" type="text/javascript">
							function uploadFileValidate() {
							//	alert("test");
								document.frmPropertyPhoto.submit();
							}

							function bnkPhotoCaption(strId){
								if((document.getElementById(strId).value == "Photo caption ...") || (document.getElementById(strId).value == "")){
									document.getElementById(strId).value = "";
								}
							}
							
							function restorePhotoCaption(strId){
								if(document.getElementById(strId).value == ""){
									document.getElementById(strId).value = "Photo caption ...";
									return false;
								}
							}
                        </script>
                        <form name="frmPropertyPhoto" id="frmPropertyPhotoId" method="post" action="property-add-more-photos-pop-up.php?pid=<?php echo $property_id;?>" onsubmit="return uploadFileValidate();" enctype="multipart/form-data">
                            <input type="hidden" name="securityKey" value="<?php echo md5(OWNERPROPERTYPHOTOSUPLOAD);?>" />
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
								<?php
                                for($i=0; $i < $allowedTotalPhotos; $i++) {
                                ?>
                                <tr>
                                    <td align="left" valign="top"><strong><?php echo ($i+1);?>.</strong></td>
                                    <td align="left" valign="top">
                                    <input type="text" name="txtPhotoCaption[]" id="txtPhtCapId<?php echo $i; ?>" value="Photo caption ..." onclick="return bnkPhotoCaption(this.id);" onblur="return restorePhotoCaption(this.id);" style="width:190px;" /><br /><br />
                                    <input type="file" name="<?php echo "txtFile".$i;?>" id="<?php echo "txtFile".$i;?>" style="width:350px;" />
                                    </td>
                                </tr>
                                <tr><td colspan="2" class="pad-btm10">&nbsp;</td></tr>
                                <?php
                                }
                                ?>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td style="padding-top:5px;"><input type="image" src="<?php echo SITE_IMAGES;?>upload.gif" alt="upload" onmouseover="this.src='<?php echo SITE_IMAGES; ?>upload_h.gif'" onmouseout="this.src='<?php echo SITE_IMAGES; ?>upload.gif'" /></td>
                                </tr>
                            </table>
                        </form>
                        </td>
                    </tr>
                    <tr><td class="pad-btm16" align="left" valign="top">&nbsp;</td></tr>
                <?php
				} else {
				?>
                    <tr><td align="left" valign="top" class="pink14">No more photos allowed to upload for this property. Please buy our package to upload more photos!!!</td></tr>
                    <tr><td class="pad-btm16" align="left" valign="top">&nbsp;</td></tr>
                <?php
				}
            } else {
            ?>
                <tr><td align="left" valign="top" class="pink14">You are not allowed to access this page!!!</td></tr>
                <tr><td class="pad-btm16" align="left" valign="top">&nbsp;</td></tr>
            <?php
            }
            ?>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
