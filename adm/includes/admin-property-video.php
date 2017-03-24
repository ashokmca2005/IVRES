<script language="javascript" src="<?php echo SITE_URL;?>includes/js/si.files.js" type="text/javascript"></script>
<style type="text/css" title="text/css">
.SI-FILES-STYLIZED label.cabinet{
	width: 57px;
	height: 23px;
	background-image: url(<?php echo SITE_IMAGES;?>browse.gif);
	background-repeat: no-repeat;
	display: block;
	overflow: hidden;
	cursor: pointer;
}
.SI-FILES-STYLIZED label.cabinet input.file{
	position: relative;
	height: 100%;
	width: auto;
	opacity: 0;
	-moz-opacity: 0;
	filter:progid:DXImageTransform.Microsoft.Alpha(opacity=0);
}
</style>
<!--Video Content Starts Here -->
<form name="videoForm" method="post" enctype="multipart/form-data" action="<?php echo $linkvid;?>">
<input type="hidden" name="securityKey" value="<?php echo md5(OWNERPROPERTYVIDEOS)?>" />
    <div class="width690">
        <div class="FloatLft"><h2 class="page-heading">Video</h2></div>
        <div class="FloatRgt pad-top5"><input type="image" src="<?php echo SITE_IMAGES;?>save-these-details.gif" onmouseover="this.src='<?php echo SITE_IMAGES;?>save-these-details-over.gif'" onmouseout="this.src='<?php echo SITE_IMAGES;?>save-these-details.gif'" alt="Save these details" onclick="return checkVideoForm();" name="Save" width="126" height="21" border="0" id="Save" /></div>
    </div>
	<div class="width690 dash31"></div>
	<div class="width690">
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
                        <td width="34" align="center" valign="middle" class="radiodashbtm"><input type="radio" name="txtMainVideo" id="<?php echo "txtPropertyVideoId0";?>" value="<?php echo $video_id; ?>" class="radio" /></td>
                        <td class="dash-left">
                            <b class="dashtop690"></b>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" style=" margin-left: 12px;">
                                <tr>
                                    <td style="padding-bottom: 12px; padding-top: 12px;">						
                                        <table width="645" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td class="photo-add-bg"><img src="<?php echo SITE_IMAGES;?>video-thumbnail.gif" class="photo-add" alt="Photo" width="168" height="126" /></td>
                                                <td width="24"><img src="<?php echo SITE_IMAGES;?>spacer.gif" alt="One" width="24" /></td>
                                                <td align="left" valign="top">
                                                    <table border="0" cellspacing="0" cellpadding="0">									
                                                        <tr>
                                                            <td style="padding-top:13px;"><label class="cabinet"><input type="file" id="video_file" name="video_file" class="file" onchange="showVideoURL(this);" /></label></td>
                                                            <td style="padding-top:13px;"><input name="video_url" id="video_url" type="text" style="width:289px; height:17px; border: solid 1px #aeaeae; padding-top:2px; padding-bottom:2px; padding-left:5px;" /></td>
                                                            <td style="padding-top:13px;"><img src="<?php echo SITE_IMAGES;?>upload.gif" alt="upload" onclick="submitVideo();" /></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-top:26px;" colspan="3">
                                                                <p style="float:left; font-size:12px; padding-top:10px; width:84px;">Video caption<span class="red">*</span></p>
                                                                <p style="float:left;">
                                                                    <input name="video_caption" id="video_caption" type="text" value="<?php echo $_POST['video_caption']?>" style="width:323px; border: solid 1px #aeaeae; padding:8px; font-size:12px;" maxlength="60"/>
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3">
                                                                <table cellpadding="0" cellspacing="0" width="100%" border="0">
                                                                    <tr>
                                                                        <td width="240" valign="bottom"><div id="videoError"></div></td>
                                                                        <td align="right" style="padding-top:20px;"><a href="#" class="delete-photo">Delete this video</a></td>
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
                        </td>
                    </tr>
                    <!--A single video add module Ends here -->
                </table>
            </td>
        </tr>
        <tr><td align="left" valign="top" style="padding-top:20px; padding-left:50px;"><a href="#" class="add-photo">Add another video (R200 each)</a></td></tr>
        <tr><td align="left" valign="top"><div class="width690 dash41">&nbsp;</div></td></tr>
        <tr><td align="left" valign="top"><div class="FloatRgt"><input type="image" src="<?php echo SITE_IMAGES;?>save-these-details.gif" onmouseover="this.src='<?php echo SITE_IMAGES;?>save-these-details-over.gif'" onmouseout="this.src='<?php echo SITE_IMAGES;?>save-these-details.gif'" alt="Save these details" onclick="return checkPhotoForm();" name="Save" width="126" height="21" border="0" id="Save" /></div></td></tr>
        <tr><td align="left" valign="top"><div class="width690 dash41">&nbsp;</div></td></tr>
    </table>
	</div>
</form>
<!--Video Content Ends Here -->
</div>
<!--Video Ends Here -->

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