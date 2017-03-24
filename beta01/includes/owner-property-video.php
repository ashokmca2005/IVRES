<?php
	$videosMainArray = $propertyObj->fun_getPropertyVideoMainInfoArr($property_id);
	if(count($videosMainArray) > 0) {
		$propMainVideoId = $videosMainArray[0]['video_id'];
	} else {
		$propMainVideoId = "";
	}

	$THIS_VERSION = '1.5';
	require 'ubr_ini.php';
	require 'ubr_lib.php';
	require 'ubr_video_config.php';
?>
<style>
	.debug {font:12px Arial; background-color:#FFFFFF; border:1px solid #898989; width:700px; height:100px; overflow:auto;}
	.alert {font:12px Arial;}
	.data {background-color:#b3b3b3; border:1px solid #898989; width:350px;}
	.data tr td {background-color:#dddddd; font:13px Arial; width:35%;}
	.bar1 {background-image:url(images/progress_bar_white.gif); layer-background-image:url(images/progress_bar_white.gif); position:relative; text-align:left; height:20px; width:<?php print $_CONFIG['progress_bar_width']; ?>px; border:1px solid #cccccc;}
	.bar2 {background-image:url(images/progress_bar_blue.gif); layer-background-image:url(images/progress_bar_blue.gif); position:relative; text-align:left; height:14px; width:0%; padding-top:3px;}
</style>
<script language="javascript" type="text/javascript">
	var path_to_link_script = "<?php print $PATH_TO_LINK_SCRIPT; ?>";
	var path_to_set_progress_script = "<?php print $PATH_TO_SET_PROGRESS_SCRIPT; ?>";
	var path_to_get_progress_script = "<?php print $PATH_TO_GET_PROGRESS_SCRIPT; ?>";
	var path_to_upload_script = "<?php print $PATH_TO_UPLOAD_SCRIPT; ?>";
	var multi_configs_enabled = <?php print $MULTI_CONFIGS_ENABLED; ?>;
	<?php if($MULTI_CONFIGS_ENABLED){ print "var config_file = \"$config_file\";\n"; } ?>
	var check_allow_extensions_on_client = <?php print $_CONFIG['check_allow_extensions_on_client']; ?>;
	var check_disallow_extensions_on_client = <?php print $_CONFIG['check_disallow_extensions_on_client']; ?>;
	<?php if($_CONFIG['check_allow_extensions_on_client']){ print "var allow_extensions = /" . $_CONFIG['allow_extensions'] . "$/i;\n"; } ?>
	<?php if($_CONFIG['check_disallow_extensions_on_client']){ print "var disallow_extensions = /" . $_CONFIG['disallow_extensions'] . "$/i;\n"; } ?>
	var check_file_name_format = <?php print $_CONFIG['check_file_name_format']; ?>;
	var check_null_file_count = <?php print $_CONFIG['check_null_file_count']; ?>;
	var check_duplicate_file_count = <?php print $_CONFIG['check_duplicate_file_count']; ?>;
	var max_upload_slots = <?php print $_CONFIG['max_upload_slots']; ?>;
	var cedric_progress_bar = <?php print $_CONFIG['cedric_progress_bar']; ?>;
	var progress_bar_width = <?php print $_CONFIG['progress_bar_width']; ?>;
	var show_percent_complete = <?php print $_CONFIG['show_percent_complete']; ?>;
	var show_files_uploaded = <?php print $_CONFIG['show_files_uploaded']; ?>;
	var show_current_position = <?php print $_CONFIG['show_current_position']; ?>;
	var show_elapsed_time = <?php print $_CONFIG['show_elapsed_time']; ?>;
	var show_est_time_left = <?php print $_CONFIG['show_est_time_left']; ?>;
	var show_est_speed = <?php print $_CONFIG['show_est_speed']; ?>;
</script>
<script language="javascript" type="text/javascript" src="<?php print $PATH_TO_JS_SCRIPT; ?>"></script>
<script type="text/javascript" language="javascript">
	// This preserves existing onload functions, but adds in the google handler as well
	function WindowOnload(f){
		var prev = window.onload;
		window.onload = function(){
			if(prev)prev();
			f();
		}
	}
	WindowOnload(iniFilePage);
	onunload = "GUnload";
</script>
<script type="text/javascript" language="javascript">
	function frmVideoFormSubmit(){
		document.frmPropertyVideo.submit();
	}

	function setMainVideo(vid) {
		document.getElementById("txtMainVideoId").value = vid;
	}

	function delThisVideo(strVideoId){
		document.getElementById("txtDelVideoId").value = strVideoId;
		document.frmPropertyVideo.submit();
	}

	function showValue(val){		
alert("test");
/*
		var filePath = "txtFile"+val;
		var file_photo = "txtPhoto"+val;
		document.getElementById(file_photo).value = document.getElementById(filePath).value;
*/
	}

</script>
<!--Video Content Starts Here -->
<form name="frmPropertyVideo" action="<?php echo $_SERVER['PHP_SELF']."?sec=vid&pid=".$propertyInfo['property_id'];?>" method="post">
    <input type="hidden" name="securityKey" value="<?php echo md5(OWNERPROPERTYVIDEOS)?>" />
    <input type="hidden" name="txtMainVideo"  id="txtMainVideoId" value="<?php echo $propMainVideoId; ?>">
    <input type="hidden" name="txtDelVideo"  id="txtDelVideoId" value="">
</form>
    <div class="width690">
        <div class="FloatLft"><h2 class="page-heading">Video</h2>
        </div>
        <div class="FloatRgt pad-top5"><input type="image" src="<?php echo SITE_IMAGES;?>save-these-details.gif" onmouseover="this.src='<?php echo SITE_IMAGES;?>save-these-details-over.gif'" onmouseout="this.src='<?php echo SITE_IMAGES;?>save-these-details.gif'" alt="Save these details" onclick="return frmVideoFormSubmit();" name="Save" width="126" height="21" border="0" id="Save" /></div>
    </div>
	<div class="width690 dash31"></div>
	<div class="width690" style="width:694px;">
    <table width="690" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="left" valign="top" class="font12 pad-btm15 dash-btm">
                Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec <a href="#" class="blue-link">Learn more.</a> Interdum magna sit amet est. Nullam eu tortor. Sed imperdiet suscipit pede. Morbi molestie. Nulla facilisi. Sed tristique libero in sem. Ut velit neque, dignissim at, venenatis<br />
                <br />
                semper at, dui. Praesent in leo at enim feugiat varius. Vivamus in justo. Suspendisse feugiat fringilla orci. uspendisse feugiat fringilla orci.<br />
                <br />
                Praesent in leo at enim feugiat varius. Vivamus in justo.
            </td>
        </tr>
        <tr>
            <td align="left" valign="top" class="dash-btm">
                <table width="690" border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
                    <tr>
                        <td class="font12" style="background-color:#e8eaee; padding-left:12px; padding-top:8px; padding-bottom:8px;" colspan="2">
                            <span class="black"><strong>Select your main video</strong></span> This will show first when holidaymakers select your Video tab
                        </td>
                    </tr>
                    <!--A single video add module Start here -->
                    <tr>
                        <td>
                            <table cellpadding="0" cellspacing="0" border="0" id="videoTblID">
                                <tr>
                                    <td>
                                    <!-- Video Cell : Start here -->
										<?php
										$videosArray = $propertyObj->fun_getPropertyVideosAllInfoArr($property_id);
										if(is_array($videosArray)) {
											for($i=0; $i < count($videosArray); $i++){
												$video_id 		= $videosArray[$i]['video_id'];
												$video_caption 	= $videosArray[$i]['video_caption'];
												$video_url 		= SITE_URL."upload/property_videos/video/".$videosArray[$i]['video_url'];
												$video_thumb 	= SITE_URL."upload/property_videos/frame_small/".$videosArray[$i]['video_thumb'];
												$video_thumb_lrg= PROPERTY_VIDEO_THUMB_LARGE.$videosArray[$i]['video_thumb'];
												$video_main 	= $videosArray[$i]['video_main'];
											?>
											<script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>/swfobject/swfobject.js"></script>
                                            <script src="<?php echo SITE_JS_INCLUDES_PATH;?>AC_RunActiveContent.js" type="text/javascript"></script>
											<table cellpadding="0" cellspacing="0" border="0">
												<tr>
													<td width="34" align="center" valign="middle" class="radiodashbtm"><input type="radio" name="txtMainVideo" id="<?php echo "txtPropertyVideoId".$i;?>" value="<?php echo $video_id; ?>" <?php if($video_main ==1){echo "checked";}else{echo "";}?> onclick="setMainVideo(this.value);"></td>
													<td class="dash-left"><b class="dashtop690"></b>
														<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" margin-left: 12px;">
															<tr>
																<td style="padding-bottom: 12px; padding-top: 12px;">
																	<table width="645" border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
																		<tr>
																			<td valign="top">
                                                                            <div class="photo-add-bg">
																			<img id="<?php echo "PreviewImage".$i;?>" src="<?php echo $video_thumb;?>" class="photo-add" width="168" height="126" />
                                                                            </div>
<div id="property-video-preview" class="box cursor1" style="display:none; position:absolute; left:400px; top:400px;">
                            <!--[if IE]><iframe id="iframe" frameborder="0" style="position:absolute;top:4px;left:4px;width:310px; height:171px;"></iframe><![endif]-->
                                <div class="content">
                                <div onMouseDown="dragStart(event, 'property-video-preview');" style="position:relative; z-index:999;left:0px;width:320px;">
                                        <table width="320" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                            <td align="right"><img src="images/poplefttop.png" alt="ANP" height="10" width="10" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/poplefttop.png', sizingMethod='scale');" /></td>
                                            <td class="topp"></td>
                                            <td><img src="images/poprighttop1.png" alt="ANP"  height="10" width="15" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/poprighttop1.png', sizingMethod='scale');"/></td>
                                        </tr>
                                            <tr>
                                                <td class="leftp"></td>
                                                <td width="290" align="left" valign="top" bgcolor="#FFFFFF" style="padding:6px;"><table width="290" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td align="left" valign="top" ><?php echo $video_caption; ?></td>
                                                            <td align="right" valign="top" class="pad-rgt4"><a href="javascript:toggleLayer1('property-video-preview');"><img src="images/pop-up-cross.gif" alt="Close" title="Close" border="0" /></a></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" align="left" valign="top" style="padding-top:8px; padding-right:4px;">

            <!-- BEGIN VIDEO SECTION -->
            <div class="video-panel">
                <span id="container">
                    We recently encoded our videos in a newer Flash format. You need to 
                    <br />
                    get the latest <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> to see this video.
                </span>
                <script type="text/javascript">
					var s1 = new SWFObject("mediaplayer.swf","mediaplayer","320","280","7");
					s1.addParam("allowfullscreen","true");
					s1.addParam("wmode","transparent");
					s1.addParam("allowscriptaccess","always");
					s1.addVariable("width","320");
					s1.addVariable("height","280");
					s1.addVariable("file","<?php echo $video_url; ?>");
					s1.addVariable("image","<?php echo $video_thumb_lrg; ?>");
					s1.write("container");
                </script>
            </div>
            <!-- END VIDEO SECTION -->
                                                            </td>
                                                        </tr>
                                                        
                                                        
                                                    </table></td>
                                                <td class="rightp" width="10"></td>
                                            </tr>
                                            <tr>
                                    <td align="right"><img src="images/popleftbtm.png" alt="ANP" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/popleftbtm.png', sizingMethod='crop');" width="10" height="10"/></td>
                                
                                    <td  class="bottomp"></td>
                                    <td align="left"><img src="images/poprightbtm1.png" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='images/poprightbtm1.png', sizingMethod='crop');" width="15" height="10" alt="ANP"/></td>
                                </tr>
                                        </table>
                                        </div>
                                </div>
                        	</div>
																			</td>
																			<td width="24"><img src="<?php echo SITE_IMAGES;?>spacer.gif" alt="One" width="24" /></td>
																			<td align="left" valign="top">
                                                                                <table border="0" cellspacing="0" cellpadding="0">
                                                                                    <form name="form_upload" id="form_upload" <?php if($_CONFIG['embedded_upload_results'] || $_CONFIG['opera_browser'] || $_CONFIG['safari_browser']){ print "target=\"upload_iframe\""; } ?> method="post" enctype="multipart/form-data"  action="#" style="margin: 0px; padding: 0px;">
                                                                                    <input type="hidden" name="txtPropertyId" value="<?php echo $property_id; ?>">
                                                                                    <input type="hidden" name="txtVideoId" id="<?php echo "txtVideoId".$i;?>" value="<?php echo $video_id; ?>">
                                                                                    <tr>
                                                                                        <td style="padding-top:13px;">
                                                                                            <div class="example">
                                                                                            <table border="0" cellspacing="0" cellpadding="0">
                                                                                                <tr>
                                                                                                    <td class="pad-btm15">
                                                                                                        <div id="upload_slots"> 
                                                                                                            <table>
                                                                                                                <tr>
                                                                                                                    <td colspan="2">
                                                                                                                        <input name="txtVideo" id="txtVideo0" style="border: 1px solid rgb(174, 174, 174); width: 425px; height: 17px; padding-top: 2px; padding-bottom: 2px; padding-left: 5px;" type="text" value="">
                                                                                                                    </td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td class="pad-top10" width="160">
                                                                                                                        <div class="FloatLft"><img src="images/upload.png" alt="Browse"/> </div> 
                                                                                                                        <input class="file hidden" ContentEditable="false" Unselectable="On" name="upfile_0" noscript="true" style="font-size:24px" <?php if($_CONFIG['multi_upload_slots']){ ?>onChange="addUploadSlot(1)"<?php } ?>  onkeypress="return handleKey(event)" type="file" onChange='txtVideo.value=upfile_0.value;' value="" />
                                                                                                                    </td>
                                                                                                                    <td class="pad-top10" width="270">
                                                                                                                        <div class="FloatLft"><input type="button" class="uploadBtn" id="upload_button" name="upload_button" value="" onClick="linkUpload();"></div>
                                                                                                                    </td>
                                                                                                                </tr>
                                                                                                            </table>
                                                                                                        </div> 
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td class="pad-top5 pad-btm5">
                                                                                                        <div id="videoError0"></div>
                                                                                                        <div>
                                                                                                            <table cellpadding="0" cellspacing="0" width="100%" border="0">
                                                                                                                <tr>
                                                                                                                    <td>
                                                                                                                        <!-- Start Progress Bar -->
                                                                                                                        <div class="alert" id="uploaded_files" style="display:none"></div>
                                                                                                                        <div class="alert" id="ubr_debug" style="display:none"></div>
                                                                                                                        <div class="alert" id="total_uploads" style="display:none"></div>
                                                                                                                        <div class="alert" id="current" style="display:none"></div>
                                                                                                                        <div class="alert" id="total_kbytes" style="display:none"></div>
                                                                                                                        <div class="alert" id="time" style="display:none"></div>
                                                                                                                        <div class="alert" id="remain" style="display:none"></div>
                                                                                                                        <div class="alert" id="speed" style="display:none"></div>
                                                                                                                        <div class="alert FloatLft pad-rgt5" id="ubr_alert"></div>
                                                                                                                        <div id="progress_bar" class="FloatLft" style="display:none">
                                                                                                                            <div class="bar1" id="upload_status_wrap">
                                                                                                                                <div class="bar2" id="upload_status"></div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                        <!-- End Progress Bar -->                                                                                                                                                                                
                                                                                                                        <?php if($_CONFIG['embedded_upload_results'] || $_CONFIG['opera_browser'] || $_CONFIG['safari_browser']){ ?>
                                                                                                                        <div id="upload_div" style="display:block;"><iframe name="upload_iframe" frameborder="0" width="200" height="50" scrolling="auto"></iframe></div>
                                                                                                                        <?php } ?>
                                                                                                                    </td>
                                                                                                                </tr>
                                                                                                            </table>
                                                                                                        </div>    
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                        <p style="float:left;font-size:12px; padding-top:3px; width:84px;">Video caption<span class="red">*</span></p>
                                                                                                        <p style="float:left;">
                                                                                                            <input  name="txtVideoCaption" id="<?php echo "txtVideoCaptionId0";?>" value="<?php echo $video_caption;?>" style="border: 1px solid rgb(174, 174, 174); width: 345px; height: 17px; padding-top: 2px; padding-bottom: 2px; padding-left: 5px;" type="text">
                                                                                                        </p>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </table>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td style="padding-top:13px;"></td>
                                                                                    </tr>
                                                                                    </form>
                                                                                    <tr><td colspan="3">&nbsp;</td></tr>
                                                                                </table>
																			</td>
																		</tr>
                                                                        <tr>
                                                                            <td class="pad-top10 pad-lft15" colspan="3"> 
                                                                                <p class=" FloatLft"><a  href="#top" onclick="javascript:toggleLayer1('property-video-preview');" class="LeftArrow">Preview your video</a></p>
                                                                                <p class="FloatRgt"><a href="JavaScript:delThisVideo('<?php echo $video_id; ?>');" class="delete-photo">Delete this video</a></p>
                                                                            </td>
                                                                        </tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>		 
												</tr>
											</table>										
											<?php
											}
										} else {
											$video_id 		= "";
											$video_caption 	= "";
											$video_url 		= "";
											$video_thumb 	= SITE_URL."images/image-thumbnail.gif";
											$video_main 	= "";
                                        ?>
                                        <table cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td width="34" align="center" valign="middle" class="radiodashbtm"><input type="radio" name="txtMainVideo" id="<?php echo "txtPropertyVideoId0";?>" value=""></td>
                                                <td class="dash-left"><b class="dashtop690"></b>
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style=" margin-left: 12px;">
                                                        <tr>
                                                            <td style="padding-bottom: 12px; padding-top: 12px;">
                                                                <table width="645" border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
                                                                    <tr>
                                                                        <td valign="top">
                                                                        <div class="photo-add-bg">
                                                                        <img id="<?php echo "PreviewImage0";?>" src="<?php echo $video_thumb;?>" class="photo-add" width="168" height="126" />
                                                                        </div>
                                                                        </td>
                                                                        <td width="24"><img src="<?php echo SITE_IMAGES;?>spacer.gif" alt="One" width="24" /></td>
                                                                        <td align="left" valign="top">
                                                                            <table border="0" cellspacing="0" cellpadding="0">
                                                                                <form name="form_upload" id="form_upload" <?php if($_CONFIG['embedded_upload_results'] || $_CONFIG['opera_browser'] || $_CONFIG['safari_browser']){ print "target=\"upload_iframe\""; } ?> method="post" enctype="multipart/form-data"  action="#" style="margin: 0px; padding: 0px;">
                                                                                <input type="hidden" name="txtPropertyId" value="<?php echo $property_id; ?>">
                                                    
                                                                                <tr>
                                                                                    <td style="padding-top:13px;">
                                                                                        <div class="example">
                                                                                        <table border="0" cellspacing="0" cellpadding="0">
                                                                                            <tr>
                                                                                                <td class="pad-btm15">
                                                                                                    <div id="upload_slots"> 
                                                                                                        <table>
                                                                                                            <tr>
                                                                                                                <td colspan="2">
                                                                                                                    <input name="txtVideo" id="txtVideo0" style="border: 1px solid rgb(174, 174, 174); width: 425px; height: 17px; padding-top: 2px; padding-bottom: 2px; padding-left: 5px;" type="text" value="">
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td class="pad-top10" width="160">
                                                                                                                    <div class="Floatlft"><img src="images/upload.png" alt="Browse"/> </div> 
                                                                                                                    <input class="file hidden" ContentEditable="false" Unselectable="On" name="upfile_0" noscript="true" style="font-size:24px" <?php if($_CONFIG['multi_upload_slots']){ ?>onChange="addUploadSlot(1)"<?php } ?>  onkeypress="return handleKey(event)" type="file" onChange='txtVideo.value=upfile_0.value;' value="" />
                                                                                                                </td>
                                                                                                                <td class="pad-top10" width="270">
                                                                                                                    <div class="FloatLft"><input type="button" class="uploadBtn" id="upload_button" name="upload_button" value="" onClick="linkUpload();"></div>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        </table>
                                                                                                    </div> 
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td class="pad-btm8">
																									<?php
                                                                                                    if(isset($errmsg) && $errmsg !="") {
                                                                                                        echo "<div id=\"videoError0\" class=\"red12\" style=\"display:block\">".$errmsg."</div>";
                                                                                                    }
																									else{
                                                                                                        echo "<div id=\"videoError0\" class=\"red12\" style=\"display:block\">&nbsp;</div>";
																									}
                                                                                                    ?>
                                                                                                    <div>
                                                                                                        <table cellpadding="0" cellspacing="0" width="100%" border="0">
                                                                                                            <tr>
                                                                                                                <td>
                                                                                                                    <!-- Start Progress Bar -->
                                                                                                                    <div class="alert" id="uploaded_files" style="display:none"></div>
                                                                                                                    <div class="alert" id="ubr_debug" style="display:none"></div>
                                                                                                                    <div class="alert" id="total_uploads" style="display:none"></div>
                                                                                                                    <div class="alert" id="current" style="display:none"></div>
                                                                                                                    <div class="alert" id="total_kbytes" style="display:none"></div>
                                                                                                                    <div class="alert" id="time" style="display:none"></div>
                                                                                                                    <div class="alert" id="remain" style="display:none"></div>
                                                                                                                    <div class="alert" id="speed" style="display:none"></div>
                                                                                                                    <div class="alert FloatLft pad-rgt5" id="ubr_alert"></div>
                                                                                                                    <div id="progress_bar" class="FloatLft" style="display:none">
                                                                                                                        <div class="bar1" id="upload_status_wrap">
                                                                                                                            <div class="bar2" id="upload_status"></div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <!-- End Progress Bar -->                                                                                                                                                                                
                                                                                                                    <?php if($_CONFIG['embedded_upload_results'] || $_CONFIG['opera_browser'] || $_CONFIG['safari_browser']){ ?>
                                                                                                                    <div id="upload_div" style="display:block;"><iframe name="upload_iframe" frameborder="0" width="200" height="50" scrolling="auto"></iframe></div>
                                                                                                                    <?php } ?>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        </table>
                                                                                                    </div>    
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>
                                                                                                    <p style="float:left;font-size:12px; padding-top:3px; width:84px;">Video caption<span class="red">*</span></p>
                                                                                                    <p style="float:left;">
                                                                                                        <input  name="txtVideoCaption" id="<?php echo "txtVideoCaptionId0";?>" value="<?php echo $video_caption;?>" style="border: 1px solid rgb(174, 174, 174); width: 345px; height: 17px; padding-top: 2px; padding-bottom: 2px; padding-left: 5px;" type="text">
                                                                                                    </p>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td style="padding-top:13px;"></td>
                                                                                </tr>
                                                                                </form>
                                                                                <tr><td colspan="3">&nbsp;</td></tr>
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
										<?php
										}
                                        ?>
                                        <!-- Video Cell : End here -->
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!--A single video add module Ends here -->
                </table>
            </td>
        </tr>
        <tr>
        <td align="left" valign="top" style="padding-top:20px; padding-left:50px;">
            <a href="javascript:toggleLayer('buy-video-pop');" class="add-photo">Add another video (R200 each)</a>
            <!-- THIS DIV IS FOR SHOW BUY MORE VIDEO POPUP PANEL START -->
            <div id="buy-video-pop" style="display:none;">
                <table width="350" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
                    <tr>
                        <td width="15"><img src="<?php echo SITE_IMAGES;?>Pop-Up-TopLft.gif" alt="ANP" width="15" height="15" /></td>
                        <td width="325" class="poptop"></td>
                        <td width="15"><img src="<?php echo SITE_IMAGES;?>Pop-Up-TopRight.gif" alt="ANP" width="15" height="15" /></td>
                    </tr>
                    <tr>
                        <td width="15" class="popleft"></td>
                        <td  align="left" valign="top" id="addtocartsecId">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="305" align="left" valign="top" style="color:#000000; font:Arial, Helvetica, sans-serif; font-size:14px"><strong>Buy More Videos</strong></td>
                                    <td width="15" align="right" valign="top"><a href="javascript:void(0);" onClick="closeWindow();void(0);"><img src="<?php echo SITE_IMAGES;?>pop-up-cross.gif" alt="Close" title="Close" border="0" /></a></td>
                                </tr>
                                <tr>
                                    <td  align="left" valign="top" class="PopTxt">
                                        <p class="grayTxt" style="font:Arial, Helvetica, sans-serif; font-size:12px; color:#585858; padding-top:10px;">Extra videos cost R200 each</p>	
                                        <p class="pad-top10 black" style="font:Arial, Helvetica, sans-serif; font-size:12px; color:#000000; ">I would like to buy 
                                        <select name="txtAddToCart" id="txtAddToCartId">
                                        <?php 
                                        for($i=1; $i<4; $i++){
                                        ?>
                                        <option value="<?php echo $i?>"><?php echo $i?></option>
                                        <?php 
                                        }
                                        ?>
                                        </select>
                                        extra videos at R200 each.                            
                                        </p>
                                    </td>
                                    <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr><td colspan="2" align="left" valign="top" height="12"></td></tr>

                                <tr>
                                    <td colspan="2" align="left" valign="top">
                                        <table width="94%" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td align="left" valign="top" class="buttons"><a href="javascript:closeWindow();void(0);"><img src="<?php echo SITE_IMAGES;?>cancel-57x28-normal.gif" onMouseOut="this.src='<?php echo SITE_IMAGES;?>cancel-57x28-normal.gif'" onMouseOver="this.src='<?php echo SITE_IMAGES;?>cancel-57x28-over.gif'" alt="cancel" name="Image11" border="0" id="Image11" /></a></td>
                                                <td align="left" valign="top"><img src="<?php echo SITE_IMAGES;?>spacer.gif" alt="One" width="10" />&nbsp;</td>
                                                <td align="right" valign="top"><a href="JavaScript:addToCart();"><img src="<?php echo SITE_IMAGES;?>add-to-cart-out.gif" onMouseOver="this.src='<?php echo SITE_IMAGES;?>add-to-cart-over.gif'" onMouseOut="this.src='<?php echo SITE_IMAGES;?>add-to-cart-out.gif'" alt="add" name="Image12"  border="0" id="Image12" /></a></td>
                                            </tr>

                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                            <td width="15" class="popright"></td>
                        </tr>
                    <tr>
                        <td width="15"><img src="<?php echo SITE_IMAGES;?>Pop-Up-BtmLft.gif" alt="ANP" width="15" height="15" /></td>
                        <td width="310" class="popbtm"></td>
                        <td width="15"><img src="<?php echo SITE_IMAGES;?>Pop-Up-BtmRight.gif" alt="ANP" width="15" height="15" /></td>
                    </tr>
                </table>
            </div>
            <!-- THIS DIV IS FOR SHOW BUY MORE VIDEO POPUP PANEL END -->		  
        </td>
        </tr>
        <tr><td align="left" valign="top"><div class="width690 dash41">&nbsp;</div></td></tr>
        <tr><td align="left" valign="top"><div class="FloatRgt"><input type="image" src="<?php echo SITE_IMAGES;?>save-these-details.gif" onmouseover="this.src='<?php echo SITE_IMAGES;?>save-these-details-over.gif'" onmouseout="this.src='<?php echo SITE_IMAGES;?>save-these-details.gif'" alt="Save these details" onclick="return frmVideoFormSubmit();" name="Save" width="126" height="21" border="0" id="Save" /></div></td></tr>
        <tr><td align="left" valign="top" class="dash-btm pad-btm7">&nbsp;</td></tr>
    </table>
	</div>
<!--Video Content Ends Here -->
</div>
<!--Video Ends Here -->