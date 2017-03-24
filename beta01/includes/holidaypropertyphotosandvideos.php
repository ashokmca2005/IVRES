<?php
if(isset($_GET['show']) && $_GET['show'] =="videos"){

	$propertyVideosInfo	= $propertyObj->fun_getPropertyVideosAllInfoArr($property_id);
	$total_videos 		= count($propertyVideosInfo);
	$total_photos 		= $propertyObj->fun_countPropertyPhotosAll($property_id);

	if ( isset ( $_GET['vid'] ) && $_GET['vid'] !="" ) {
	
		$vid 	= $_GET['vid'];
		$propertyVideoInfo	= $propertyObj->fun_getPropertyVideoInfoArr($property_id, $vid);
		$vid 	= $propertyVideoInfo[0]['video_id'];
		$vcap 	= $propertyVideoInfo[0]['video_caption'];
		$vurl 	= PROPERTY_VIDEO_PATH.$propertyVideoInfo[0]['video_url'];
		$vthumb = PROPERTY_VIDEO_THUMB_LARGE.$propertyVideoInfo[0]['video_thumb'];
	
	} else {
	
		foreach( $propertyVideosInfo as $value) {
			if ( $value['video_main'] == 1 ) {
				$vid 	= $value['video_id'];
				$vcap 	= $value['video_caption'];
				$vurl 	= PROPERTY_VIDEO_PATH.$value['video_url'];
				$vthumb = PROPERTY_VIDEO_THUMB_LARGE.$value['video_thumb'];
			}
		}
	
	}
?>
<script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>/swfobject/swfobject.js"></script>
<script src="<?php echo SITE_JS_INCLUDES_PATH;?>AC_RunActiveContent.js" type="text/javascript"></script>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td valign="top">
            <!-- BEGIN VIDEO SECTION -->
            <div class="video-panel">
                <div class="pad-lft3 pad-btm3 white"><?php echo ucfirst($vcap); ?></div>
                <span id="container">
                    We recently encoded our videos in a newer Flash format. You need to 
                    <br />
                    get the latest <a href="http://www.macromedia.com/go/getflashplayer" class="white">Flash Player</a> to see this video.
                </span>
                <script type="text/javascript">
					var s1 = new SWFObject("mediaplayer.swf","mediaplayer","320","260","7");
					s1.addParam("allowfullscreen","true");
					s1.addParam("wmode","transparent");
					s1.addParam("allowscriptaccess","always");
					s1.addVariable("width","320");
					s1.addVariable("height","260");
					s1.addVariable("file","<?php echo $vurl; ?>");
					s1.addVariable("image","<?php echo $vthumb; ?>");
					s1.write("container");
                </script>
            </div>
            <!-- END VIDEO SECTION -->
        </td>
        <td align="left" valign="top" class="pad-lft20">
            <div style="display: block;" id="HolidayPicturesPhoto" class="imgTop">
            <div class="font12">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td>
                        <ul>
                            <li class="VideoTabLeft"><a href="#" class="slideshow">View Slideshow</a></li>
                            <li class="VideoTabS"><a class="VPLink"  href="property.php?pid=<?php echo $property_id;?>&show=videos" title="Property Video"><img src="<?php echo SITE_IMAGES;?>VideoTabS.gif" alt="Video" border="0" /><span class="VPTxt">(<?php echo $total_videos; ?>)</span></a></li>
                            <li class="PhotoTabUS"><a class="VPLink"  href="property.php?pid=<?php echo $property_id;?>" title="Property Photos"><img src="<?php echo SITE_IMAGES;?>PhotoTabUs.gif" alt="Photo" border="0" /><span class="VPTxt-UNS">(<?php echo $total_photos; ?>)</span></a></li>
                            <li class="PhotoTabRight">&nbsp;</li>
                        </ul>
                    </td>
                </tr>
                <tr><td><img src="<?php echo SITE_IMAGES;?>VPTabTop1.gif" alt="Image" /></td></tr>
                <!-- Property video tab : start here -->
                <tr>
                    <td class="VPTabBottom1">
                        <table align="center" width="280" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                            <?php
                                for( $i = 0; $i < count($propertyVideosInfo); $i++) {
                                    $videoid 	= $propertyVideosInfo[$i]['video_id'];
                                    $videocap 	= ucfirst($propertyVideosInfo[$i]['video_caption']);
                                    $videourl 	= PROPERTY_VIDEO_PATH.$propertyVideosInfo[$i]['video_url'];
                                    $videothumb = $propertyVideosInfo[$i]['video_thumb'];
                                    if ( $videothumb != "") {
                                        $videothumbsmallurl = PROPERTY_VIDEO_THUMB_SMALL.$videothumb;
                                    } else {
                                        $videothumbsmallurl = SITE_IMAGES."thumb88x66.gif";
                                    }
                            ?>
                            <tr>
                                <td>
                                    <table border="0" cellpadding="0" cellspacing="0" align="left">
                                    <tbody>
                                        <tr>
                                            <td valign="top"><div><a href="property.php?pid=<?php echo $property_id;?>&show=videos&vid=<?php echo $videoid;?>" style="text-decoration:none;" title="<?php echo $videocap;?>" ><img src="<?php echo $videothumbsmallurl;?>" alt="<?php echo $videocap;?>" height="66" width="88"></a></div></td>
                                            <td class="pad-lft10" align="left" valign="middle">
                                                <table border="0" cellpadding="0" cellspacing="0">
                                                    <tbody>
                                                        <tr><td><?php echo $videocap;?></td></tr>
                                                        <tr><td><a href="#" class="blue-link">Duration 22m 09s</a></td></tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr><td class="dash21">&nbsp;</td></tr>
                        	<?php
							}
							for($j = count($propertyVideosInfo); $j < 3; $j++) {
							$novideothumbsmallurl = PROPERTY_VIDEO_THUMB_SMALL."no-img.gif";
							?>
                            <tr>
                                <td>
                                    <table border="0" cellpadding="0" cellspacing="0" align="left">
                                    <tbody>
                                        <tr>
                                            <td valign="top"><div><img src="<?php echo $novideothumbsmallurl;?>" alt="no video" height="66" width="88"></div></td>
                                        </tr>
                                    </tbody>
                                    </table>
                                </td>
                            </tr>
                            <?php
							if($j < 2) {
							?>
                            <tr><td class="dash21">&nbsp;</td></tr>
                            <?php
							}
							?>
							<?php
                            }
                            ?>
                        </tbody>
                        </table>
                    </td>
                </tr>
                <!-- Property video tab : end here -->
    
            </table>
            </div>
            </div>
        </td>
    </tr>
</table>
<?php
} else {

	$propertyPhotosInfo	= $propertyObj->fun_getPropertyPhotosAllInfoArr($property_id);
	$total_photos 		= count($propertyPhotosInfo);
	$total_videos 		= $propertyObj->fun_countPropertyVideosAll($property_id);

	if ( isset ( $_GET['imgid'] ) && $_GET['imgid'] !="" ) {
	
		$imgid 	= $_GET['imgid'];
		$propertyPhotoInfo	= $propertyObj->fun_getPropertyPhotoInfoArr($property_id, $imgid);
		$imgid 		= $propertyPhotoInfo[0]['photo_id'];
		$imgcap 	= ucfirst($propertyPhotoInfo[0]['photo_caption']);
		$imgurl 	= PROPERTY_IMAGES_LARGE350x264.$propertyPhotoInfo[0]['photo_url'];
		$imgthumb 	= PROPERTY_IMAGES_THUMB88x66.$propertyPhotoInfo[0]['photo_thumb'];
	
	} else {
		foreach( $propertyPhotosInfo as $value) {
			if ( $value['photo_main'] == 1 ) {
				$imgid 		= $value['photo_id'];
				$imgcap 	= ucfirst($value['photo_caption']);
				$imgurl 	= PROPERTY_IMAGES_LARGE350x264.$value['photo_url'];
				$imgthumb 	= PROPERTY_IMAGES_THUMB88x66.$value['photo_thumb'];
			}
		}
	}

?>
<script language="javascript" type="text/javascript">
function showPropImgPreview(strsrc, strcap){
//	var imgsrc = document.getElementById("propertyPhotoId").src;
//	var imgcap = document.getElementById("propertyPhotoId").alt;

	document.getElementById("propertyImgPreviewId").src = strsrc;
	document.getElementById("propertyImgPreviewId").alt = strcap;
	document.getElementById("propertyImgPreviewCapId").innerHTML = strcap;
}

function showPropImg(strsrc, strcap, id, num){
	var imglink = "propertylinkdivid"+ id;

	document.getElementById("propertyPhotoId").src = strsrc;
	document.getElementById("propertyPhotoId").alt = strcap;
	document.getElementById("propertyimagecapId").innerHTML = strcap;

	for(var k = 0; k < num; k++) {
		var linkid = "propertylinkdivid"+ k;
		document.getElementById(linkid).style.display = "none";
	}
	document.getElementById(imglink).style.display = "block";
}
</script>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td valign="top">
            <div class="photo-panel imgVertical">
                <div class="pad-btm3 pad-lft8 white" id="propertyimagecapId" style="height:19px;"><?php echo $imgcap;?></div>
                <div style="height:264px;">
                <img src="gd1.php?img_name=<?php echo $imgurl;?>&w=350&h=264" id="propertyPhotoId" alt="<?php echo $imgcap;?>" width="350" height="264"  />
                </div>
				<?php
                for( $j = 0; $j < count($propertyPhotosInfo); $j++) {
                    $photoid 		= $propertyPhotosInfo[$j]['photo_id'];
					$photocap 		= ucfirst($propertyPhotosInfo[$j]['photo_caption']);
					$photourl 		= PROPERTY_IMAGES_LARGE480x360.$propertyPhotosInfo[$j]['photo_url'];
                    $photomain 		= $propertyPhotosInfo[$j]['photo_main'];
                    $propertylinkdivid= "propertylinkdivid".$j;
                
                    if ( $photomain == 1) {
                        echo "<div id=\"$propertylinkdivid\"  style=\"display:block; padding-bottom:6px; padding-top:6px; padding-left:6px;\" class=\"pad-lft5\"><a href=\"javascript:showPropImgPreview('$photourl', '$photocap'); toggleLayer('largephoto');\" id=\"supersizePictureLinkId\" class=\"superLarge\">supersize picture</a></div>";
                    } else {
                        echo "<div id=\"$propertylinkdivid\" style=\"display:none; padding-bottom:6px; padding-top:5px; padding-left:6px;\"><a href=\"javascript:showPropImgPreview('$photourl', '$photocap'); toggleLayer('largephoto');\" id=\"supersizePictureLinkId\" class=\"superLarge\">supersize picture</a></div>";
                    }
                }
                ?>
            </div>
            <div class="ANP-Pop" id="largephoto" style="position:absolute;top:140px;left:150px;">
               
                
                <table width="620" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td><img src="images/poplefttop.png" alt="ANP" /></td>
                        <td class="topp" height="10"></td>
                        <td valign="bottom"><img src="images/poprighttop.png" alt="ANP"/></td>
                    </tr>
                    <tr>
                        <td class="leftp"></td>
                        <td  align="left" valign="top" style="padding:2px; background:#FFFFFF;">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0"  bgcolor="#FFFFFF">
                                <tr>
                                    <td colspan="3" align="right" valign="top" class="pad-btm7"><a href="javascript:toggleLayer('largephoto');"><img src="images/pop-up-cross.gif" alt="Close" border="0"  title="Close" /></a></td>
                                </tr>
                                <tr>
                                    <td width="188" align="left" valign="top" class="boldTitle">Picture 1 of 23</td>
                                    <td colspan="2" align="right" valign="top" class="font12">
                                        <div class="pagination">
                                            <a href="#">First</a> <a href="#">&lt;</a> <a href="#">1</a> | 2 | <a href="#">3</a> | <a href="#">4</a> | <a href="#">5</a> | <a href="#">6</a> | <a href="#">7</a> | <a href="#">8</a> | <a href="#">9</a> | <a href="#">10 </a>... <a href="#">23</a> <a href="#">&gt;</a> <a href="#">Last</a>
                                        </div>
                                    </td>
                                </tr>
                                <tr><td colspan="3"  align="left" valign="top" class="dash25">&nbsp;</td></tr>
                                <tr>
                                    <td colspan="3"  align="left" valign="top" class="font12">
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td><span class="PopTxt" id="propertyImgPreviewCapId">View from main room balcony over the sea</span></td>
                                                <td align="right" valign="top" class="font12"><a href="#" class="arrowLinkback">Back</a>&nbsp; <span class="boldblack12">|</span> &nbsp; <a href="#" class="arrowLinkNext">Next</a></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr><td height="12" colspan="3" align="left" valign="top"></td></tr>
                                <tr>
                                	<!-- image preview : start here -->
                                    <td colspan="3"  valign="bottom">
                                        <img src="images/video-blank.gif" id="propertyImgPreviewId" width="600" height="450" />
                                    </td>
                                	<!-- image preview : end here -->
                                </tr>
                            </table>
                        </td>
                        <td class="rightp1"><img src="images/popright.png" alt="ANP"/></td>
                    </tr>
                    <tr>
                      <td align="right" valign="top"><img src="images/popleftbtm.png" alt="ANP"/></td>
                        <td width="375"  class="bottomp"  height="10"></td>
                        <td><img src="images/poprightbtm.png" alt="ANP"/></td>
                    </tr>
                </table>
              
                <!-- ################## Pop Table end ################################### -->  
                </div>
        </td>
        <td align="left" valign="top" class="pad-lft20">
        <div style="display: block;" id="HolidayPicturesPhoto" class="imgTop">
        <div class="font12">
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td>
                    <ul>
                        <li class="VideoTabLeft"><a  href="javascript:showPropImgPreview(); toggleLayer('largephoto');" id="supersizePictureLinkId" class="slideshow">View Slideshow</a></li>
                        <?php
						if($total_videos > 0) {
						?>
                        <li class="VideoTabUS"><a class="VPLink"  href="property.php?pid=<?php echo $property_id;?>&show=videos" title="Property Video"><img src="<?php echo SITE_IMAGES;?>VideoTabUs.gif" alt="Video" border="0" /><span class="VPTxt-UNS">(<?php echo $total_videos; ?>)</span></a></li>
                        <?php
						} else {
						?>
                        <li class="VideoTabUS"><a class="VPLink" title="Property Video"><img src="<?php echo SITE_IMAGES;?>VideoTabUs.gif" alt="Video" border="0" /><span class="VPTxt-UNS">(<?php echo $total_videos; ?>)</span></a></li>
						<?php
						}
						?>
                        <li class="PhotoTabS"><a class="VPLink"  href="property.php?pid=<?php echo $property_id;?>" title="Property Photos"><img src="<?php echo SITE_IMAGES;?>PhotoTabS.gif" alt="Photo" border="0" /><span class="VPTxt">(<?php echo $total_photos; ?>)</span></a></li>
                        <li class="PhotoTabRight">&nbsp;</li>
                    </ul>
                </td>
            </tr>
            <tr><td><img src="<?php echo SITE_IMAGES;?>VPTabTop2.gif" alt="Image" /></td></tr>
            <tr>
                <td valign="top" class="VPTabBottom" style="padding-bottom:1px;">
                    <table border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                            <td colspan="3" align="right" class="pad-rgt10 pad-btm3"><div class="pagination">Page&nbsp;&nbsp;&nbsp;<a href="#">1</a>&nbsp;|&nbsp;<a href="#">2</a>&nbsp;|&nbsp;<a href="#">3</a></div></td>
                        </tr>
						<?php
                            for( $i = 0; $i < count($propertyPhotosInfo); $i = $i+3) {
                                $photoid_1 		= $propertyPhotosInfo[$i+0]['photo_id'];
                                $photoid_2 		= $propertyPhotosInfo[$i+1]['photo_id'];
                                $photoid_3 		= $propertyPhotosInfo[$i+2]['photo_id'];

								echo "<tr><td width=\"88\" class=\"pad-top10 pad-rgt10 pad-lft10 pad-btm10\">";
								if( isset( $photoid_1 ) && $photoid_1 !="" ){
									$propertythumbid= "propertythumbid".$photoid_1;
									$photocap_1 	= ucfirst($propertyPhotosInfo[$i+0]['photo_caption']);
									$photourl_1 	= PROPERTY_IMAGES_LARGE350x264.$propertyPhotosInfo[$i+0]['photo_url'];
									$photothumb_1 	= PROPERTY_IMAGES_THUMB88x66.$propertyPhotosInfo[$i+0]['photo_thumb'];
									echo "<img src=\"$photothumb_1\" id=\"$propertythumbid\" alt=\"$photocap_1\" width=\"88\" height=\"66\" onclick=\"showPropImg('$photourl_1', '$photocap_1', '$i', '$total_photos')\" style=\"cursor:pointer\" />";								
								} else {
									$noimg = PROPERTY_IMAGES_THUMB."no-img.gif";
									echo "<img src=\"$noimg\" alt=\"No Image\" width=\"88\" height=\"66\" />";								
								}
								echo "</td><td width=\"88\" class=\"pad-top10 pad-rgt10 pad-btm10\">";
								if( isset( $photoid_2 ) && $photoid_2 !="" ){
									$propertythumbid= "propertythumbid".$photoid_2;
									$photocap_2 	= ucfirst($propertyPhotosInfo[$i+1]['photo_caption']);
									$photourl_2 	= PROPERTY_IMAGES_LARGE350x264.$propertyPhotosInfo[$i+1]['photo_url'];
									$photothumb_2 	= PROPERTY_IMAGES_THUMB88x66.$propertyPhotosInfo[$i+1]['photo_thumb'];
									echo "<img src=\"$photothumb_2\" id=\"$propertythumbid\" alt=\"$photocap_2\" width=\"88\" height=\"66\" onclick=\"showPropImg('$photourl_2', '$photocap_2', '".($i+1)."', '$total_photos')\" style=\"cursor:pointer\" />";								
								} else {
									$noimg = PROPERTY_IMAGES_THUMB."no-img.gif";
									echo "<img src=\"$noimg\" alt=\"No Image\" width=\"88\" height=\"66\" />";								
								}
								echo "</td><td width=\"88\" class=\"pad-top10 pad-rgt10 pad-btm10\">";
								if( isset( $photoid_3 ) && $photoid_3 !="" ){
									$propertythumbid= "propertythumbid".$photoid_3;
									$photocap_3 	= ucfirst($propertyPhotosInfo[$i+2]['photo_caption']);
									$photourl_3 	= PROPERTY_IMAGES_LARGE350x264.$propertyPhotosInfo[$i+2]['photo_url'];
									$photothumb_3 	= PROPERTY_IMAGES_THUMB88x66.$propertyPhotosInfo[$i+2]['photo_thumb'];
									echo "<img src=\"$photothumb_3\" id=\"$propertythumbid\" alt=\"$photocap_3\" width=\"88\" height=\"66\" onclick=\"showPropImg('$photourl_3', '$photocap_3', '".($i+2)."', '$total_photos')\" style=\"cursor:pointer\" />";								
								} else {
									$noimg = PROPERTY_IMAGES_THUMB."no-img.gif";
									echo "<img src=\"$noimg\" alt=\"No Image\" width=\"88\" height=\"66\" />";								
								}
								echo "</td></tr>";
                            }
							if ( count($propertyPhotosInfo) < 4) {
								$noimg = PROPERTY_IMAGES_THUMB."no-img.gif";
								echo "<tr><td width=\"88\" class=\"pad-top10 pad-rgt10 pad-lft10 pad-btm10\"><img src=\"$noimg\" alt=\"No Image\" width=\"88\" height=\"66\" /></td><td width=\"88\" class=\"pad-top10 pad-rgt10 pad-btm10\"><img src=\"$noimg\" alt=\"No Image\" width=\"88\" height=\"66\" /></td><td width=\"88\" class=\"pad-top10 pad-rgt10 pad-btm10\"><img src=\"$noimg\" alt=\"No Image\" width=\"88\" height=\"66\" /></td></tr>";
							}
							if ( count($propertyPhotosInfo) < 7) {
								$noimg = PROPERTY_IMAGES_THUMB."no-img.gif";
								echo "<tr><td width=\"88\" class=\"pad-top10 pad-rgt10 pad-lft10 pad-btm10\"><img src=\"$noimg\" alt=\"No Image\" width=\"88\" height=\"66\" /></td><td width=\"88\" class=\"pad-top10 pad-rgt10 pad-btm10\"><img src=\"$noimg\" alt=\"No Image\" width=\"88\" height=\"66\" /></td><td width=\"88\" class=\"pad-top10 pad-rgt10 pad-btm10\"><img src=\"$noimg\" alt=\"No Image\" width=\"88\" height=\"66\" /></td></tr>";
							}
						?>
                    </table>
                </td>
            </tr>
        </table>
        </div>
        </div>
        <!-- Video Ends Here -->  
        </td>
    </tr>
</table>
<?php
}
?>
