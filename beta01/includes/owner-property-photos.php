<?php
	$photosArray 		= $propertyObj->fun_getPropertyPhotosAllInfoArr($property_id);
	$allowedTotalPhotos = 20;
	$buyTotalPhotos		= $propertyObj->fun_countPropertyBuyPhotos($property_id);
	if($buyTotalPhotos > 0) {
		$allowedTotalPhotos += $buyTotalPhotos;
	}

	$videoArray 		= $propertyObj->fun_getPropertyVideoInfoArr($property_id);
	if(is_array($videoArray) && count($videoArray) > 0) {
		$video_id 			= $videoArray['video_id'];
		$video_caption 		= $videoArray['video_caption'];
		$video_description 	= $videoArray['video_url'];
	}
?>
<script language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>si.files.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript">
	function uploadFile(obj, val) {
		fileVal 		= "txtFile"+val;
		filePhotoVal	= "txtPhoto"+val;
		photoError		= "photoError"+val;
		photoCaption	= "txtPhotoCaptionId"+val;
		fileUrl 		= document.getElementById(fileVal).value;

		fileUrl			= rm_trim(fileUrl);
		if(fileUrl == "") {
			document.getElementById(photoError).innerHTML = "<font color='#BF0000' size='2'><strong>Please select a photo to upload</strong></font>";
			document.getElementById(filePhotoVal).focus();
			return false;
		} else {
			document.getElementById(photoError).innerHTML = "";
			obj.enctype = "multipart/form-data";
			obj.submit();
		}	
	}        

	function showValue(val) {		
		var filePath = "txtFile"+val;
		var file_photo = "txtPhoto"+val;
		document.getElementById(file_photo).value = document.getElementById(filePath).value;
	}

	function frmSubmit() {
		var cnt_photos = <?php echo count($photosArray); ?>;
		for (var cnt = 0; cnt < parseInt(cnt_photos); cnt++) {
			var phCapId1 = "txtPhotoCaptionId"+cnt;
			var phCapId2 = "txtPhtCapId"+cnt;
			document.getElementById(phCapId2).value = document.getElementById(phCapId1).value;
		}
		document.frmProperty.submit();
	}

	function frmSubmitVideo() {
		if(document.getElementById("txtVideoCaptionId").value == "") {
			document.getElementById("videoError").innerHTML = "Video Caption required";
			document.getElementById("txtVideoCaptionId").focus();
			return false;
		}
		if(document.getElementById("txtVideoDecriptionId").value == "") {
			document.getElementById("videoError").innerHTML = "Video Code required";
			document.getElementById("txtVideoDecriptionId").focus();
			return false;
		}
		document.frmPropertyVideo.submit();
	}

	function goUpOrder(photo_id) {
		req.onreadystatechange = handlePhotoOrderResponse;
		req.open('get', '<?php echo SITE_URL;?>includes/ajax/photoOrderXml.php?mode=up&photo_id='+photo_id+'&property_id='+<?php echo $property_id; ?>);
		req.send(null);   
	}

	function goDownOrder(photo_id) {
		req.onreadystatechange = handlePhotoOrderResponse;
		req.open('get', '<?php echo SITE_URL;?>includes/ajax/photoOrderXml.php?mode=down&photo_id='+photo_id+'&property_id='+<?php echo $property_id; ?>);
		req.send(null);   
	}

	function handlePhotoOrderResponse(){
		if(req.readyState == 4){
			var response = req.responseText;
			//alert(response);
			xmlDoc = req.responseXML;
			var root = xmlDoc.getElementsByTagName('orders')[0];
			if(root != null){
				var items = root.getElementsByTagName("order");
				for (var i = 0 ; i < items.length ; i++){
					var item = items[i];
					var orderstatus = item.getElementsByTagName("orderstatus")[0].firstChild.nodeValue;
					if(orderstatus == "success"){
						window.location = location.href;
					}
				}
			}
		}
	}

	function setMainPhoto(photoid) {
		document.getElementById("txtMainPhotoId").value = photoid;
	}

	function handleDeleteResponse() {
		var arrayOfPhotoStatus 	= new Array();
		if(req.readyState == 4) {
			var response=req.responseText;
			xmlDoc=req.responseXML;
			var root = xmlDoc.getElementsByTagName('photos')[0];
			if(root != null) {
				var items = root.getElementsByTagName("photo");
				for (var i = 0 ; i < items.length ; i++) {
					var item 				= items[i];
					var photostatus 		= item.getElementsByTagName("photostatus")[0].firstChild.nodeValue;
					arrayOfPhotoStatus[i] 	= photostatus;
					if(arrayOfPhotoStatus[i] == "Photo deleted.") {
						document.getElementById(uploaderId).innerHTML 	= "<font color='#BF0000' size='2'><strong>"+arrayOfPhotoStatus[i]+"</strong></font>";
						window.location = location.href;
					} else {
						document.getElementById(uploaderId).innerHTML 	= "<img src='loading.gif' alt='loading...' />";
					}
				}
			}
		}
	}

	function handleAddToCartResponse() {
		var arrayOfPhotoStatus 	= new Array();
		if(req.readyState == 4) {
			var response=req.responseText;
			xmlDoc=req.responseXML;
			var root = xmlDoc.getElementsByTagName('photos')[0];
			if(root != null) {
				var items = root.getElementsByTagName("photo");
				for (var i = 0 ; i < items.length ; i++) {
					var item 				= items[i];
					var photostatus 		= item.getElementsByTagName("photostatus")[0].firstChild.nodeValue;
					arrayOfPhotoStatus[i] 	= photostatus;
					if(arrayOfPhotoStatus[i] == "Photos added.") {
						
						//To update cart
						var strCartTxt = "";
						var cart_itms = "<?php echo $cartObj->fun_countCartItems($user_id); ?>";
						var cart_amt = "<?php echo round($cartObj->fun_getCartAmt($user_id),2); ?>";
						var add_photo_total = document.getElementById("txtAddToCartId").value;
						var add_photo_rate = "49";
						var vat_percent = "17.5";
						var add_photo_price = parseInt(add_photo_total)*parseInt(add_photo_rate);
						cart_itms = parseInt(cart_itms)+1;
						cart_amt = parseFloat(cart_amt)+add_photo_price;
						cart_amt = parseFloat(cart_amt + ((cart_amt*vat_percent)/100));
						var strCartTxt = "("+cart_itms+" items: "+cart_amt.toFixed(2)+")";

						var strHtmlTxt = "";
strHtmlTxt += "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
strHtmlTxt += "<tr>";
strHtmlTxt += "<td width=\"279\" rowspan=\"2\" align=\"left\" valign=\"bottom\" class=\"pink18 pad-top15\">Confirmation</td>";
strHtmlTxt += "<td align=\"right\" valign=\"top\"><a href=\"javascript:toggleLayer1('buy-more-image-pop');void(0);\"><img src=\"<?php echo SITE_IMAGES;?>pop-up-cross.gif\" alt=\"Close\" title=\"Close\" border=\"0\" /></a></td>";
strHtmlTxt += "</tr>";
strHtmlTxt += "<tr><td width=\"36\" align=\"right\" valign=\"top\">&nbsp;</td></tr>";
strHtmlTxt += "<tr>";
strHtmlTxt += "<td  align=\"left\" valign=\"top\" class=\"PopTxt\">";
strHtmlTxt += "<p class=\"grayTxt\" style=\"font:Arial, Helvetica, sans-serif; font-size:12px; color:#585858; padding-top:10px;\"><strong>Your extra images have now been added to your shopping basket.</strong></p>";
strHtmlTxt += "<p>&nbsp;</p>";
strHtmlTxt += "<p class=\"grayTxt\" style=\"font:Arial, Helvetica, sans-serif; font-size:12px; color:#585858; padding-top:2px;\">Once they have been paid for you will be able to upload and use them.</p>";
strHtmlTxt += "<p>&nbsp;</p>";
strHtmlTxt += "</td>";
strHtmlTxt += "<td align=\"left\" valign=\"top\">&nbsp;</td>";
strHtmlTxt += "</tr>";
strHtmlTxt += "<tr><td colspan=\"2\" align=\"left\" valign=\"top\" height=\"12\"></td></tr>";
strHtmlTxt += "<tr>";
strHtmlTxt += "<td colspan=\"2\" align=\"left\" valign=\"top\">";
strHtmlTxt += "<table width=\"94%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
strHtmlTxt += "<tr>";
strHtmlTxt += "<td align=\"left\" valign=\"top\" class=\"buttons\"><a href=\"javascript:toggleLayer1('buy-more-image-pop');void(0);\"><img src=\"<?php echo SITE_IMAGES;?>close-gray.gif\"  alt=\"cancel\" name=\"Image11\" border=\"0\" id=\"Image11\" /></a><img src=\"<?php echo SITE_IMAGES;?>spacer.gif\" alt=\"One\" width=\"4\" />&nbsp;<a href=\"owner-shopping-cart.php\"><img src=\"<?php echo SITE_IMAGES;?>paynow.gif\"  alt=\"add\" name=\"Image12\"  border=\"0\" id=\"Image12\" /></a></td>";
strHtmlTxt += "</tr>";
strHtmlTxt += "</table>";
strHtmlTxt += "</td>";
strHtmlTxt += "</tr>";
strHtmlTxt += "</table>";
//						document.getElementById("showBasketId").innerHTML = "";
//						document.getElementById("showBasketId").innerHTML = "<a href=\"owner-shopping-cart.php\">View basket &nbsp;<span class=\"red\">"+strCartTxt+"</span></a></div>";
						document.getElementById("addtocartsecId").innerHTML = strHtmlTxt;
					}
				}
			}
		}
	}	

	function delThisPhoto(strPhotoId, val) {
		val = val;
		uploaderId = 'photoError'+val;
		req.onreadystatechange = handleDeleteResponse;
		req.open('GET', '<?php echo SITE_URL;?>imagedeleteXml.php?imgid='+strPhotoId); 
		req.send(null);   
	}

	function delMainPhoto(strPhotoId, val) {
		val = val;
		uploaderId = 'photoError'+val;
		document.getElementById(uploaderId).innerHTML = "<font color='#BF0000'>Sorry, you cannot delete main photo. Please change main photo and try again.</font>";
	}

	function addToCart() {
		var strPropertyId = <?php echo $property_id;?>;
		var strTotalPhoto = document.getElementById("txtAddToCartId").value;
		req.onreadystatechange = handleAddToCartResponse;
		req.open('GET', '<?php echo SITE_URL;?>imageaddtocartXml.php?pid='+strPropertyId+'&addphoto='+strTotalPhoto); 
		req.send(null);   
	}

	function savePhotoCaption(photoId, photoCaption) {
		req.open('get', '<?php echo SITE_URL;?>savePhotoCaptionXML.php?imgid=' + photoId + '&caption=' + photoCaption); 
		req.onreadystatechange = handleSaveCaption; 
		req.send(null); 
	
	}
	
	function handleSaveCaption() {
		var arrayOfPhotoCaptionStatus = new Array();
		if(req.readyState == 4) {
			var response = req.responseText;
			xmlDoc = req.responseXML;
			var root = xmlDoc.getElementsByTagName('photos')[0];
			if(root != null) {
				var items = root.getElementsByTagName("photo");
				var item = items[0];
				var status = item.getElementsByTagName("status")[0].firstChild.nodeValue;
//				alert(status);
			}
		}
	}

	function delThisVideo(strVideoId) {
		req.onreadystatechange = handleDeleteVideoResponse;
		req.open('GET', '<?php echo SITE_URL;?>videodeleteXml.php?vid='+strVideoId); 
		req.send(null);   
	}


	function handleDeleteVideoResponse() {
		var arrayOfPhotoStatus 	= new Array();
		if(req.readyState == 4) {
			var response=req.responseText;
			xmlDoc=req.responseXML;
			var root = xmlDoc.getElementsByTagName('videos')[0];
			if(root != null) {
				var items = root.getElementsByTagName("video");
				for (var i = 0 ; i < items.length ; i++) {
					var item 				= items[i];
					var videostatus 		= item.getElementsByTagName("videostatus")[0].firstChild.nodeValue;
					arrayOfPhotoStatus[i] 	= videostatus;
					if(arrayOfPhotoStatus[i] == "Video deleted.") {
						window.location = location.href;
					}
				}
			}
		}
	}

</script>
<style type="text/css" title="text/css">
.SI-FILES-STYLIZED label.cabinet{
	width: 57px;
	height: 23px;
	background-image: url(<?php echo SITE_IMAGES;?>browse.gif);
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
<!--Photo Content Starts Here -->
<?php
	$photosMainArray = $propertyObj->fun_getPropertyMainThumb($property_id);
	if(count($photosMainArray) > 0) {
		$propMainPhotoId = $photosMainArray[0]['photo_id'];
	} else {
		$propMainPhotoId = "";
	}
?>
<form name="frmProperty" id="frmPropertyId" method="post" action="<?php echo $_SERVER['PHP_SELF']."?sec=pho&pid=".$property_id;?>">
    <input type="hidden" name="securityKey" value="<?php echo md5(OWNERPROPERTYPHOTOS);?>" />
    <input type="hidden" name="txtMainPhoto"  id="txtMainPhotoId" value="<?php echo $propMainPhotoId; ?>">
	<?php
    for($j=0; $j < count($photosArray); $j++) {
    ?>
    <input type="hidden" name="txtPhotoId[]"  id="txtPhotoId<?php echo $j; ?>" value="<?php echo $photosArray[$j]['photo_id']; ?>">
    <input type="hidden" name="txtPhotoCaption[]"  id="txtPhtCapId<?php echo $j; ?>" value="<?php echo $photosArray[$j]['photo_caption']; ?>">
	<?php
    }
    ?>                                                                                      
</form>
<div class="width690 pad-top20">
    <table width="690" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="left" valign="top" class="font16-darkgrey pad-btm5"><?php echo tranText('instructions_for_uploading_your_photos'); ?></td>
            <td align="right" valign="top" class="font16-darkgrey pad-btm5"><span class="FloatRgt"><a href="#" onclick="return frmSubmit();" class="button-blue">Save details</a></span></td>
        </tr>
        <tr>
            <td colspan="2" align="left" valign="top" class="font12 pad-btm25">
			1. <?php echo tranText('click_the_browse_button_below'); ?><br />
			2. <?php echo tranText('find_the_photo_you_d_like_to_upload_on_your_pc'); ?><br />
			3. <?php echo tranText('click_the_blue_upload_button'); ?><br /><br />
			<span class="pink14arial"><?php echo tranText('please_note'); ?>:</span> The maximum filesize of your images should be <strong>less than 5MB</strong>. Uploading large files will take a very long time so be sure to check the filesize first or email <a href="mailto:info@rentownersvillas.com?subject=<?php echo ucfirst($propertyName)." / ".fill_zero_left($property_id, "0", (6-strlen($property_id)));?>" class="blue-link">info@rentownersvillas.com</a> for help
            </td>
        </tr>
		<?php /*?>
        <tr>
            <td colspan="2" align="left" valign="top" class="grayTd">
                <table width="100%" border="0" cellspacing="0" cellpadding="4">
                   <tr>
                        <td width="112"><img src="<?php echo SITE_IMAGES;?>photoBand-thumb.gif" alt="Photo" width="112" height="76" /></td>
                        <td width="522">
                            <?php echo tranText('site_notes_extra_photo'); ?>
                        </td>
                        <td width="164" align="right" valign="bottom" class="pad-btm15">
                        <a href="javascript:toggleLayer1('buy-more-image-pop');void(0);" class="blue-link"><img src="<?php echo SITE_IMAGES;?>addmorephotos-gray.gif" alt="Add more photo" width="128" height="27" /></a>
                        </td>
                    </tr>
                </table>
                <div id="buy-more-image-pop" class="box" style="display:none; z-index:5; position:relative; left:0px; top:0px;">
                    <!--[if IE]><iframe id="iframe" frameborder="0" style="position:absolute;top:-56px;left:204px;width:345px; height:132px;"></iframe><![endif]-->
                    <div style="z-index:5; position:absolute; left:150px; top:-135px;">
                        <table width="380" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td align="right"><img src="<?php echo SITE_IMAGES;?>poplefttop.png" alt="ANP" height="10" width="10" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo SITE_IMAGES;?>poplefttop.png', sizingMethod='scale');" /></td>
                                <td class="topp"></td>
                                <td><img src="<?php echo SITE_IMAGES;?>poprighttop1.png" alt="ANP"  height="10" width="15" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo SITE_IMAGES;?>poprighttop1.png', sizingMethod='scale');"/></td>
                            </tr>
                            <tr>
                                <td class="leftp"></td>
                                <td width="380" align="left" valign="top" bgcolor="#FFFFFF" style="padding:6px 10px 15px 20px">
                                <div id="addtocartsecId">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="279" rowspan="2" align="left" valign="bottom" class="pink18 pad-top15">Add images</td>
                                            <td align="right" valign="top"><a href="javascript:toggleLayer1('buy-more-image-pop');void(0);"><img src="<?php echo SITE_IMAGES;?>pop-up-cross.gif" alt="Close" title="Close" border="0" /></a></td>
                                        </tr>
                                        <tr>
                                            <td width="36" align="right" valign="top">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td  align="left" valign="top" class="PopTxt">
                                                <p class="grayTxt" style="font:Arial, Helvetica, sans-serif; font-size:12px; color:#585858; padding-top:10px;"><strong>Each additonal image costs $5 per year.</strong></p>	
                                                <p class="grayTxt" style="font:Arial, Helvetica, sans-serif; font-size:12px; color:#585858; padding-top:2px;">Please note that you will not be able to upload these extra images until they have been paid for.</p>	
                                                <p class="pad-top18 pad-btm10" style="font:Arial, Helvetica, sans-serif; font-size:14px; color:#585858; font-weight:bold; ">Add
                                                <select name="txtAddToCart" id="txtAddToCartId">
                                                <?php 
                                                for($i=1; $i<33; $i++){
                                                ?>
                                                <option value="<?php echo $i?>"><?php echo $i?></option>
                                                <?php 
                                                }
                                                ?>
                                                </select>
                                                extra images
                                                </p>
                                            </td>
                                            <td align="left" valign="top">&nbsp;</td>
                                        </tr>
                                        <tr><td colspan="2" align="left" valign="top" height="12"></td></tr>
                                        <tr>
                                            <td colspan="2" align="left" valign="top">
                                                <table width="94%" border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td align="left" valign="top" class="buttons"><a href="javascript:toggleLayer1('buy-more-image-pop');void(0);"><img src="<?php echo SITE_IMAGES;?>cancel-gray.gif"  alt="cancel" name="Image11" border="0" id="Image11" /></a><img src="<?php echo SITE_IMAGES;?>spacer.gif" alt="One" width="4" />&nbsp;<a href="JavaScript:addToCart();"><img src="<?php echo SITE_IMAGES;?>addtobasket.gif"  alt="add" name="Image12"  border="0" id="Image12" /></a></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                </td>
                                <td class="rightp" width="10"></td>
                            </tr>
                            <tr>
                                <td align="right"><img src="<?php echo SITE_IMAGES;?>popleftbtm.png" alt="ANP" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo SITE_IMAGES;?>popleftbtm.png', sizingMethod='crop');" width="10" height="10"/></td>
                                <td  class="bottomp"></td>
                                <td align="left"><img src="<?php echo SITE_IMAGES;?>poprightbtm1.png" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo SITE_IMAGES;?>poprightbtm1.png', sizingMethod='crop');" width="15" height="10" alt="ANP"/></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </td>
        </tr>
		<?php */?>
        <tr><td colspan="2" align="left" valign="top" class="dash-btm">&nbsp;</td></tr>
        <tr>
        	<td colspan="2" align="right" valign="top" class="pad-top10">
                <a href="javascript:void(0);" onclick="MM_openWindow('property-add-more-photos-pop-up.php?pid=<?php echo $property_id;?>', 'childwindow', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=700,height=800')" style="text-decoration:none;">
                <img src="<?php echo SITE_IMAGES;?>uploadmultiplephotos.gif" alt="Add multiple photo" width="160" height="30" onmouseover="this.src='<?php echo SITE_IMAGES; ?>uploadmultiplephotos_h.gif'" onmouseout="this.src='<?php echo SITE_IMAGES; ?>uploadmultiplephotos.gif'" border="0" />
                </a>
            </td>
        </tr>
       <tr><td colspan="2" align="left" valign="top" class="dash-btm">&nbsp;</td></tr>
        <tr>
            <td colspan="2" align="left" valign="top" class="pad-top15">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;" id="photoTableID">
                    <!--A single photo add module Start here -->
                    <tr>
                        <td>
                            <table cellpadding="0" width="100%" cellspacing="0" border="0" id="photoTblID">
                                <tr>
                                    <td>
                                    <!-- Photo Cell : Start here -->
										<?php
                                        /*
                                        if($display_lang == 1) {
                                            echo '<br />';
                                            for($i = 0; $i < count($display_lang_arr); $i++) {
                                                $lang_code = $display_lang_arr[$i]['lang_code'];
                                                $lang_name = $display_lang_arr[$i]['name'];
                                                echo '<a href="#" onclick="MM_openWindow(\'translation.php?property_id='.$property_id.'&lang_code='.$lang_code.'&field=property_name&type=textbox&limit=25\', \'childwindow\', \'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=800,height=600\')" class="blue-link"  title="'.$lang_name.'"><img src="images/flag/'.$lang_code.'.png" width="15" border="0" alt="'.$lang_name.'" /></a>&nbsp;';
                                            }
                                        }
                                        */
                                        ?>
                                        <?php
                                        for($i=0; $i < $allowedTotalPhotos; $i++){
											if(isset($photosArray[$i]) && count($photosArray[$i]) > 0){
												$photo_id 		= $photosArray[$i]['photo_id'];
												$photo_caption 	= $photosArray[$i]['photo_caption'];
												$photo_main 	= $photosArray[$i]['photo_main'];
												//$photo_thumb 	= PROPERTY_IMAGES_LARGE244x183_PATH.$photosArray[$i]['photo_url'];
												$pos = strpos($photosArray[$i]['photo_url'], "rentalo.com");
												if($pos === false) {
													$photo_thumb = PROPERTY_IMAGES_LARGE244x183_PATH.$photosArray[$i]['photo_url'];
												} else {
													$photo_thumb = $photosArray[$i]['photo_url'];
												}
											} else{
												$photo_id 		= "";
												$photo_caption 	= "";
												$photo_thumb 	= PROPERTY_IMAGES_LARGE244x183_PATH."image-thumbnail.gif";
												$photo_main 	= "";
											}
                                        ?>
                                        <table cellpadding="0" width="690" cellspacing="0" border="0">
                                            <tr>
                                                <td width="125" align="center" <?php if($i == 0) { echo "valign=\"top\""; } else { echo "valign=\"middle\""; }?> class="pad-top3 pad-rgt15 <?php if($i < ($allowedTotalPhotos - 0)) { echo " dash-btm"; } else { echo ""; }?>">
													<?php
                                                    if($i == 0) {
                                                        echo "<div class=\"font12-darkgrey pad-top5\">Main photo</div><div class=\"pad-btm15\">This will appear on search results</div>";
                                                    }
                                                    ?>
                                                    <input type="radio" name="txtMainPhoto" id="<?php echo "txtPropertyPhotoId".$i;?>" value="<?php echo $photo_id; ?>" <?php if($photo_main ==1){echo "checked";}else{echo "";}?> onclick="setMainPhoto(this.value);">
                                                    <div class="re-order-list" style="margin-top:10px; border-top:#999999 thin solid; padding-top:5px;">
                                                        <ul>
															<?php 
                                                            if(($i > 0) && ($i < count($photosArray))) { 
                                                            ?>
                                                            <li><a href="javascript:void(0);" onclick="goUpOrder(<?php echo $photo_id; ?>);" title="Up" style="text-decoration:none; color:#357bdc; font-size:11px;">Up <span style="color:#357bdc; font-size:16px; font-weight:bold;">&and;</span></a></li>
                                                            <li>&nbsp;&nbsp;</li>
                                                            <?php
                                                            }

                                                            if($i < (count($photosArray)-1)) { 
                                                            ?>
                                                            <li><a href="javascript:void(0);" onclick="goDownOrder(<?php echo $photo_id; ?>);" title="Down" style="text-decoration:none; color:#357bdc; font-size:11px;">Down <span style="color:#357bdc; font-size:16px; font-weight:bold;">&or;</span></a></li>
                                                            <?php
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                </td>
                                                <td class="pad-top3  <?php if($i < ($allowedTotalPhotos - 0)) { echo " dash-btm"; } else { echo ""; }?>">
                                                    <form name="<?php echo "frmProperty".$i;?>" action="<?php echo $_SERVER['PHP_SELF']."?sec=pho&pid=".$property_id;?>" method="post" enctype="multipart/form-data">
                                                    <input type="hidden" name="securityKey" value="<?php echo md5(OWNERPROPERTYPHOTOSUPLOAD);?>" />
                                                    <input type="hidden" name="txtPhotoId" id="<?php echo "txtPhotoId".$i;?>" value="<?php echo $photo_id; ?>">
													<table width="100%" border="0" cellspacing="0" cellpadding="0">
														<tr>
															<td style="padding-bottom:12px; padding-top:8px;">
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
                                                                    <tr>
                                                                        <td valign="top" class="pad-rgt15">
                                                                        <img id="<?php echo "PreviewImage".$i;?>" src="<?php echo $photo_thumb;?>" width="244" height="183" />
                                                                        </td>
                                                                        <td align="right" valign="top">
                                                                            <table border="0" width="100%" cellspacing="0" cellpadding="0">
                                                                                <tr>
                                                                                    <td style="padding-top:5px;"><div style="width: 57px; height:23px; overflow: hidden;"><label class="cabinet"><input type="file" name="txtFile" id="<?php echo "txtFile".$i;?>" class="file" value="" onchange="return showValue('<?php echo $i;?>');"/></label></div></td>
                                                                                    <td style="padding-top:5px;"><input type="text" name="txtPhoto" id="<?php echo "txtPhoto".$i;?>"  style="width:205px; height:17px; border: solid 1px #aeaeae; padding-top:2px; padding-bottom:2px; padding-left:5px;" /></td>
                                                                                    <td style="padding-top:5px;"><img src="<?php echo SITE_IMAGES;?>upload.gif" alt="upload" onclick="return uploadFile(<?php echo "document.frmProperty".$i;?>, '<?php echo $i;?>');" /></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="padding-top:26px;" colspan="3">
                                                                                        <p style="float:left; font-size:12px; padding-top:10px; width:75px;"><?php echo tranText('photo_caption'); ?></p>
                                                                                        <p style="float:right;">
                                                                                        <input type="text" name="txtPhotoCaption" id="<?php echo "txtPhotoCaptionId".$i;?>" value="<?php echo $photo_caption;?>" style="width:242px; border: solid 1px #aeaeae; padding:8px; font-size:12px;" maxlength="60" <?php if($photo_id !="") { echo "onblur=\"return savePhotoCaption('".$photo_id."', this.value);\""; }?> >
                                                                                        </p>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td colspan="3">
                                                                                        <table cellpadding="0" cellspacing="0" width="100%" border="0">
                                                                                            <tr>
																								<?php
                                                                                                if($photo_id !="") {
                                                                                                ?>
                                                                                                <td align="left" width="120" style="padding-top:20px;">
                                                                                                    <div id="delRow1">
                                                                                                    <table cellpadding="0" cellspacing="0" border="0">
                                                                                                        <tr><td>&nbsp;</td></tr>
                                                                                                        <tr>
                                                                                                        
                                                                                                            <td>
                                                                                                                <?php 
                                                                                                                if($photo_main ==1) {
                                                                                                                ?>
                                                                                                                    <a href="JavaScript:delMainPhoto('<?php echo $photo_id;?>', <?php echo $i;?>);" class="removeText"><?php echo tranText('remove_picture'); ?></a>
                                                                                                                <?php
                                                                                                                } else {
                                                                                                                ?>
                                                                                                                    <a href="JavaScript:delThisPhoto('<?php echo $photo_id;?>', <?php echo $i;?>);" class="removeText"><?php echo tranText('remove_picture'); ?></a>
                                                                                                                <?php
                                                                                                                }
                                                                                                                ?> 
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </table>
                                                                                                    </div>
                                                                                                </td>
                                                                                                <?php
                                                                                                }
                                                                                                ?>
                                                                                                
                                                                                                <td style="padding-top:20px;" valign="bottom">
                                                                                                <div id="<?php echo "photoError".$i;?>"></div>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>								  		
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
														</tr>
													</table>
                                                    </form>
                                                </td>		 
                                            </tr>
                                        </table>										
										<?php
                                        }
										?>
                                        <!-- Photo Cell : End here -->
                                    </td>
                                </tr>
                            </table>
                            <table cellpadding="0" width="100%" cellspacing="0" border="0" id="photoTblID">
                                <tr>
                                    <td width="123" align="center" valign="top" class="pad-top3 pad-rgt10">
                                    <div class="font12-darkgrey pad-top5"><?php echo tranText('add_youtube_video'); ?></div>
                                    <em><?php echo tranText('note_not_include_embed_tag_in_youtube_code'); ?>. Example youtube code is as below:</em>
                                    <br />
                                    <br /><br />
                                    <font color="#000"><em>&lt;iframe width="560" height="315" src="http://www.youtube.com/embed/-5MiPd8VjN8" frameborder="0" allowfullscreen&gt;&lt;/iframe&gt;</em></font>
                                    </td>
                                    <td class="pad-top3">
                                        <form name="frmPropertyVideo" action="<?php echo $_SERVER['PHP_SELF']."?sec=pho&pid=".$property_id;?>" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="securityKey" value="<?php echo md5(OWNERPROPERTYVIDEOUPLOAD);?>" />
                                        <input type="hidden" name="txtVideoId" id="txtVideoId" value="<?php echo $video_id; ?>">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td style="padding-bottom:12px; padding-top:8px;">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
                                                        <tr>
                                                            <td valign="top" class="pad-rgt15 pad-btm10">
                                                            <?php 
																//$video_description = "<param name=\"movie\" value=\"http://www.youtube.com/v/qXzkQHLOMgA&hl=en_US&fs=1&\"></param><param name=\"allowFullScreen\" value=\"true\"></param><param name=\"allowscriptaccess\" value=\"always\"></param><embed src=\"http://www.youtube.com/v/qXzkQHLOMgA&hl=en_US&fs=1&\" type=\"application/x-shockwave-flash\" allowscriptaccess=\"always\" allowfullscreen=\"true\" width=\"199\" height=\"149\"></embed>";
																if(isset($video_description) && $video_description != "") {
																	echo "<object width=\"199\" height=\"149\">".$video_description."</object>";
																} else {
																	echo "<img id=\"PreviewVide\" src=\"".PROPERTY_VIDEO_THUMB_SMALL_PATH."novideo.gif\" width=\"199\" height=\"149\" />";
																}
															?>
                                                            </td>
                                                        </tr>
                                                        <tr><td valign="top" style="clear:both;"></td></tr>
                                                        <tr>
                                                            <td align="left" valign="top">
                                                                <table border="0" width="70%" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td style="padding-top:5px;" colspan="3">
                                                                            <p style="float:left; font-size:12px; padding-top:0px; width:75px;"><?php echo tranText('video_caption'); ?></p>
                                                                            <p style="float:right;">
                                                                            <input type="text" name="txtVideoCaption" id="txtVideoCaptionId" value="<?php echo $video_caption;?>" style="width:242px; border: solid 1px #aeaeae; padding:8px; font-size:12px;" maxlength="60" >
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="padding-top:10px;" colspan="3">
                                                                            <p style="float:left; font-size:12px; padding-top:0px; width:75px;">Youtube code</p>
                                                                            <p style="float:right;">
                                                                            <textarea name="txtVideoDecription" id="txtVideoDecriptionId" style="width:242px; border: solid 1px #aeaeae; padding:8px; font-size:12px;"><?php echo $video_description;?></textarea>
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="padding-top:10px;" colspan="3">
                                                                            <p style="float:left; font-size:12px; padding-top:0px; width:75px;">&nbsp;</p>
                                                                            <p style="float:right;">
                                                                            <a href="javascript:void(0);" onclick="return frmSubmitVideo();"><img src="<?php echo SITE_IMAGES;?>submit.gif" alt="save" border="0" /></a>
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="3">
                                                                            <table cellpadding="0" cellspacing="0" width="100%" border="0">
                                                                                <tr>
                                                                                    <?php
                                                                                    if($video_id !="") {
                                                                                    ?>
                                                                                    <td align="left" width="120" style="padding-top:5px;">
                                                                                        <div id="delRow0">
                                                                                        <table cellpadding="0" cellspacing="0" border="0">
                                                                                            <tr><td>&nbsp;</td></tr>
                                                                                            <tr>
                                                                                                <td>
                                                                                                    <a href="JavaScript:delThisVideo('<?php echo $video_id;?>');" class="removeText">Remove Video</a>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                        </div>
                                                                                    </td>
                                                                                    <?php
                                                                                    }
                                                                                    ?>
                                                                                    <td style="padding-top:5px;" valign="bottom">
                                                                                    <div id="videoError"></div>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>								  		
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                        </form>
                                    </td>		 
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!--A single photo add module Ends here -->
                </table>
            </td>
        </tr>
    </table>
	</div>
	<div class="width690 dash41"></div>
	<div class="width690">
        <div class="FloatRgt">
        <a href="#" onclick="return frmSubmit();" class="button-blue">Save details</a>
        </div>
	</div>
<!--Photo Content Ends Here -->
</div>
                                                                                       
<!--Photo Ends Here -->

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