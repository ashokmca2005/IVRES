<?php
require_once("includes/application-top-inner.php");
if(isset($_GET['tvlguidid']) && $_GET['tvlguidid'] !=""){
	$trvl_guid_id = $_GET['tvlguidid'];
//	$eventInfoArr = $eventObj->fun_getEventInfo($trvl_guid_id);
	$tvlguidInfoArr = $tvlguidObj->fun_getTravelInfo($trvl_guid_id);
	if(is_array($tvlguidInfoArr) && count($tvlguidInfoArr) > 0) {
		$tvlguidMainImgInfoArr 	= $tvlguidObj->fun_getTravelMainImgInfo($trvl_guid_id);
		$tvlguidImgInfoArr 		= $tvlguidObj->fun_getTravelImgArr($trvl_guid_id);
	}
} else {
	$tvlguidInfoArr = $tvlguidObj->fun_getTravelTmpInfo($_REQUEST[PHPSESSID]);
//	print_r($tvlguidInfoArr);
	if(is_array($tvlguidInfoArr) && count($tvlguidInfoArr) > 0) {
		$tvlguidMainImgInfoArr 	= $tvlguidObj->fun_getTravelMainImgInfo($_REQUEST[PHPSESSID]);
		$tvlguidImgInfoArr 		= $tvlguidObj->fun_getTravelImgArr($_REQUEST[PHPSESSID]);
	}
}

if(is_array($tvlguidMainImgInfoArr) && count($tvlguidMainImgInfoArr) > 0) {
	$tvlguidMainPhotoId 		= $tvlguidMainImgInfoArr['photo_id'];
	$tvlguidMainPhoto 			= TVLGUID_IMAGES_LARGE449x341_PATH.$tvlguidMainImgInfoArr['photo_url'];
	$tvlguidMainPhotoCaption	= $tvlguidMainImgInfoArr['photo_caption'];
	$tvlguidMainPhotoBy			= $tvlguidMainImgInfoArr['photo_by'];
	$tvlguidMainPhotoLink		= $tvlguidMainImgInfoArr['photo_link'];
} else {
	$tvlguidMainPhoto 			= TVLGUID_IMAGES_THUMB168x127_PATH."main-picture.gif";
	$tvlguidMainPhotoCaption	= "Travel guide";
	$tvlguidMainPhotoBy			= "";
	$tvlguidMainPhotoLink		= "";
}


//print_r($tvlguidImgInfoArr);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title><?php echo $sitetitle;?> :: Admin :: Travel Guide Preview</title>
    <link href="includes/css/admin.css" rel="stylesheet" type="text/css" />
	<script language="javascript" type="text/javascript">
    function showPropImg(strsrc, strcap, strphotoby, strphotolink){
        document.getElementById("txtTvlGuidPhotoId").src = strsrc;
        document.getElementById("txtTvlGuidPhotoId").alt = strcap;
        document.getElementById("txtTvlGuidPhotoCaptionId").innerHTML = strcap;
		if(strphotoby != "") {
			document.getElementById("txtTvlGuidPhotoById").innerHTML = "Photo by "+strphotoby;
		} else {
			document.getElementById("txtTvlGuidPhotoById").innerHTML = "";
		}
    }
    </script>
</head>
<body>
<div align="center" style="padding:0px 10px 0px 10px; font-size:12px; background-color:#FFFFFF;">
<table width="395" border="0" cellspacing="0" cellpadding="0">
    <tr><td colspan="2" align="left" valign="top" class="pad-btm10 pad-top20"><h1 class="page-heading"><?php echo ucwords($tvlguidInfoArr['trvl_guid_title']); ?></h1></td></tr>
    <tr>
        <td colspan="2" align="left" valign="top">
            <table width="395" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td colspan="2" align="left" valign="top" class="pad-top15">
                        <table border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="left" valign="top">
                                    <table border="0" cellpadding="0" cellspacing="0">
										<?php
                                        if(isset($tvlguidMainPhoto) && $tvlguidMainPhoto !="") {
                                            echo "<tr>";
                                            echo "<td valign=\"top\" class=\"pad-btm8\">";
											echo "<img src=\"".$tvlguidMainPhoto."\" alt=\"".$tvlguidMainPhotoCaption."\" id=\"txtTvlGuidPhotoId\" width=\"449\" height=\"341\" />";
											echo "</td>";
											echo "</tr>";
											echo "<tr>";
											echo "<td valign=\"top\" class=\"pad-btm8\">";
											echo "<div id=\"txtTvlGuidPhotoCaptionId\" class=\"font11 FloatLft\">".ucfirst($tvlguidMainPhotoCaption)."</div>";
											if(isset($tvlguidMainPhotoBy) && ($tvlguidMainPhotoBy != "" || $tvlguidMainPhotoBy != "Photo By")) {
											echo "<div id=\"txtTvlGuidPhotoById\" class=\"font11 FloatRgt\">Photo By ".ucfirst($tvlguidMainPhotoBy)."</div>";
											}
											echo "</td>";
											echo "</tr>";
                                        }
										
										for( $i = 0; $i < count($tvlguidImgInfoArr); $i = $i+6) {
											$photoid_1 		= $tvlguidImgInfoArr[$i+0]['photo_id'];
											$photoid_2 		= $tvlguidImgInfoArr[$i+1]['photo_id'];
											$photoid_3 		= $tvlguidImgInfoArr[$i+2]['photo_id'];
											$photoid_4 		= $tvlguidImgInfoArr[$i+3]['photo_id'];
											$photoid_5 		= $tvlguidImgInfoArr[$i+4]['photo_id'];
											$photoid_6 		= $tvlguidImgInfoArr[$i+5]['photo_id'];
			
											echo "<tr><td class=\"pad-btm8\" valign=\"top\">";
											if( isset( $photoid_1 ) && $photoid_1 !="" ){
												$tvlguidthumbid= "tvlguidthumbid".$photoid_1;
												$photocap_1 	= ucfirst($tvlguidImgInfoArr[$i+0]['photo_caption']);
												$photoby_1 		= ucfirst($tvlguidImgInfoArr[$i+0]['photo_by']);
												$photolink_1 	= $tvlguidImgInfoArr[$i+0]['photo_link'];
												$photourl_1 	= TVLGUID_IMAGES_LARGE449x341_PATH.$tvlguidImgInfoArr[$i+0]['photo_url'];
												$photothumb_1 	= TVLGUID_IMAGES_THUMB168x127_PATH.$tvlguidImgInfoArr[$i+0]['photo_thumb'];
												echo "<span class=\"pad-left2\"><img src=\"".$photothumb_1."\" height=\"53\" width=\"69\" onclick=\"showPropImg('".$photourl_1."', '".$photocap_1."', '".$photoby_1."', '".$photolink_1."')\" style=\"cursor: pointer;\"></span>\n";
											}
											if( isset( $photoid_2 ) && $photoid_2 !="" ){
												$tvlguidthumbid= "tvlguidthumbid".$photoid_2;
												$photocap_2 	= ucfirst($tvlguidImgInfoArr[$i+1]['photo_caption']);
												$photoby_2 		= ucfirst($tvlguidImgInfoArr[$i+1]['photo_by']);
												$photolink_2 	= $tvlguidImgInfoArr[$i+1]['photo_link'];
												$photourl_2 	= TVLGUID_IMAGES_LARGE449x341_PATH.$tvlguidImgInfoArr[$i+1]['photo_url'];
												$photothumb_2 	= TVLGUID_IMAGES_THUMB168x127_PATH.$tvlguidImgInfoArr[$i+1]['photo_thumb'];
												echo "<span class=\"pad-left2\"><img src=\"".$photothumb_2."\" height=\"53\" width=\"69\" onclick=\"showPropImg('".$photourl_2."', '".$photocap_2."', '".$photoby_2."', '".$photolink_2."')\" style=\"cursor: pointer;\"></span>\n";
											}
											if( isset( $photoid_3 ) && $photoid_3 !="" ){
												$tvlguidthumbid= "tvlguidthumbid".$photoid_3;
												$photocap_3 	= ucfirst($tvlguidImgInfoArr[$i+2]['photo_caption']);
												$photoby_3 		= ucfirst($tvlguidImgInfoArr[$i+2]['photo_by']);
												$photolink_3 	= $tvlguidImgInfoArr[$i+2]['photo_link'];
												$photourl_3 	= TVLGUID_IMAGES_LARGE449x341_PATH.$tvlguidImgInfoArr[$i+2]['photo_url'];
												$photothumb_3 	= TVLGUID_IMAGES_THUMB168x127_PATH.$tvlguidImgInfoArr[$i+2]['photo_thumb'];
												echo "<span class=\"pad-left2\"><img src=\"".$photothumb_3."\" height=\"53\" width=\"69\" onclick=\"showPropImg('".$photourl_3."', '".$photocap_3."', '".$photoby_3."', '".$photolink_3."')\" style=\"cursor: pointer;\"></span>\n";
											}
											if( isset( $photoid_4 ) && $photoid_4 !="" ){
												$tvlguidthumbid= "tvlguidthumbid".$photoid_4;
												$photocap_4 	= ucfirst($tvlguidImgInfoArr[$i+3]['photo_caption']);
												$photoby_4 		= ucfirst($tvlguidImgInfoArr[$i+3]['photo_by']);
												$photolink_4 	= $tvlguidImgInfoArr[$i+3]['photo_link'];
												$photourl_4 	= TVLGUID_IMAGES_LARGE449x341_PATH.$tvlguidImgInfoArr[$i+3]['photo_url'];
												$photothumb_4 	= TVLGUID_IMAGES_THUMB168x127_PATH.$tvlguidImgInfoArr[$i+3]['photo_thumb'];
												echo "<span class=\"pad-left2\"><img src=\"".$photothumb_4."\" height=\"53\" width=\"69\" onclick=\"showPropImg('".$photourl_4."', '".$photocap_4."', '".$photoby_4."', '".$photolink_4."')\" style=\"cursor: pointer;\"></span>\n";
											}
											if( isset( $photoid_5 ) && $photoid_5 !="" ){
												$tvlguidthumbid= "tvlguidthumbid".$photoid_5;
												$photocap_5 	= ucfirst($tvlguidImgInfoArr[$i+4]['photo_caption']);
												$photoby_5 		= ucfirst($tvlguidImgInfoArr[$i+4]['photo_by']);
												$photolink_5 	= $tvlguidImgInfoArr[$i+4]['photo_link'];
												$photourl_5 	= TVLGUID_IMAGES_LARGE449x341_PATH.$tvlguidImgInfoArr[$i+4]['photo_url'];
												$photothumb_5 	= TVLGUID_IMAGES_THUMB168x127_PATH.$tvlguidImgInfoArr[$i+4]['photo_thumb'];
												echo "<span class=\"pad-left2\"><img src=\"".$photothumb_5."\" height=\"53\" width=\"69\" onclick=\"showPropImg('".$photourl_5."', '".$photocap_5."', '".$photoby_5."', '".$photolink_5."')\" style=\"cursor: pointer;\"></span>\n";
											}
											if( isset( $photoid_6 ) && $photoid_6 !="" ){
												$tvlguidthumbid= "tvlguidthumbid".$photoid_6;
												$photocap_6 	= ucfirst($tvlguidImgInfoArr[$i+5]['photo_caption']);
												$photoby_6 		= ucfirst($tvlguidImgInfoArr[$i+5]['photo_by']);
												$photolink_6 	= $tvlguidImgInfoArr[$i+5]['photo_link'];
												$photourl_6 	= TVLGUID_IMAGES_LARGE449x341_PATH.$tvlguidImgInfoArr[$i+5]['photo_url'];
												$photothumb_6 	= TVLGUID_IMAGES_THUMB168x127_PATH.$tvlguidImgInfoArr[$i+5]['photo_thumb'];
												echo "<span class=\"pad-left2\"><img src=\"".$photothumb_6."\" height=\"53\" width=\"69\" onclick=\"showPropImg('".$photourl_6."', '".$photocap_6."', '".$photoby_6."', '".$photolink_6."')\" style=\"cursor: pointer;\"></span>\n";
											}
											echo "</td></tr>";
										}

										if(is_array($tvlguidImgInfoArr) && count($tvlguidImgInfoArr) > 0) {
                                            echo "<tr><td valign=\"top\">&nbsp;</td></tr>";
										}

										if(isset($tvlguidInfoArr['trvl_guid_desc']) && $tvlguidInfoArr['trvl_guid_desc'] !="") {
											echo "<tr><td valign=\"top\" class=\"pad-btm20\">".$tvlguidInfoArr['trvl_guid_desc']."</td></tr>";
										}
										if(isset($tvlguidInfoArr['trvl_guid_dir']) && $tvlguidInfoArr['trvl_guid_dir'] !="") {
											echo "<tr><td valign=\"top\" class=\"pad-btm5\"><span class=\"pad-btm10\"><span class=\"gray20\">Getting there</span></span></td></tr>";
											echo "<tr><td valign=\"top\" class=\"pad-btm20\">".$tvlguidInfoArr['trvl_guid_dir']."</td></tr>";
										}
										if(isset($tvlguidInfoArr['trvl_guid_suit']) && $tvlguidInfoArr['trvl_guid_suit'] !="") {
											echo "<tr><td valign=\"top\" class=\"pad-btm5\"><span class=\"pad-btm10\"><span class=\"gray20\">Suitability</span></span></td></tr>";
											echo "<tr><td valign=\"top\" class=\"pad-btm20\">".$tvlguidInfoArr['trvl_guid_suit']."</td></tr>";
										}
										if(isset($tvlguidInfoArr['trvl_guid_cost']) && $tvlguidInfoArr['trvl_guid_cost'] !="") {
											echo "<tr><td valign=\"top\" class=\"pad-btm5\"><span class=\"pad-btm10\"><span class=\"gray20\">Cost</span></span></td></tr>";
											echo "<tr><td valign=\"top\" class=\"pad-btm20\">".$tvlguidInfoArr['trvl_guid_cost']."</td></tr>";
										}
										if(isset($tvlguidInfoArr['trvl_guid_long_last']) && $tvlguidInfoArr['trvl_guid_long_last'] !="") {
											echo "<tr><td valign=\"top\" class=\"pad-btm5\"><span class=\"pad-btm10\"><span class=\"gray20\">How long does it last?</span></span></td></tr>";
											echo "<tr><td valign=\"top\" class=\"pad-btm20\">".$tvlguidInfoArr['trvl_guid_long_last']."</td></tr>";
										}
										if(isset($tvlguidInfoArr['trvl_guid_open_detail']) && $tvlguidInfoArr['trvl_guid_open_detail'] !="") {
											echo "<tr><td valign=\"top\" class=\"pad-btm5\"><span class=\"pad-btm10\"><span class=\"gray20\">When is it open and when should we go?</span></span></td></tr>";
											echo "<tr><td valign=\"top\" class=\"pad-btm20\">".$tvlguidInfoArr['trvl_guid_open_detail']."</td></tr>";
										}
										if(isset($tvlguidInfoArr['trvl_guid_attraction']) && $tvlguidInfoArr['trvl_guid_attraction'] !="") {
											echo "<tr><td valign=\"top\" class=\"pad-btm5\"><span class=\"pad-btm10\"><span class=\"gray20\">What is it really like?</span></span></td></tr>";
											echo "<tr><td valign=\"top\" class=\"pad-btm20\">".$tvlguidInfoArr['trvl_guid_attraction']."</td></tr>";
										}
										if((isset($tvlguidInfoArr['trvl_guid_contact_phone']) && $tvlguidInfoArr['trvl_guid_contact_phone'] !="") || (isset($tvlguidInfoArr['trvl_guid_contact_web']) && $tvlguidInfoArr['trvl_guid_contact_web'] !="") || (isset($tvlguidInfoArr['trvl_guid_contact_email']) && $tvlguidInfoArr['trvl_guid_contact_email'] !="")) {

											echo "<tr><td valign=\"top\" class=\"pad-btm5\"><span class=\"pad-btm10\"><span class=\"gray20\">Contact</span></span></td></tr>";
											echo "<tr>";
											echo "<td valign=\"top\" class=\"pad-btm10\">";
											echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
											if(isset($tvlguidInfoArr['trvl_guid_contact_phone']) && $tvlguidInfoArr['trvl_guid_contact_phone'] !="") {
												echo "<tr><td><strong>Telephone : </strong>".$tvlguidInfoArr['trvl_guid_contact_phone']."</td></tr>";
											}
											if(isset($tvlguidInfoArr['trvl_guid_contact_web']) && $tvlguidInfoArr['trvl_guid_contact_web'] !="") {
												if(substr($tvlguidInfoArr['trvl_guid_contact_web'], 0, 7) == "http://") { 
													$weblink = $tvlguidInfoArr['trvl_guid_contact_web']; 
												} else { 
													$weblink = "http://".$tvlguidInfoArr['trvl_guid_contact_web']; 
												}
												echo "<tr><td><strong>Website : </strong><a href=\"".$weblink."\" class=\"blue-link\" target=\"_blank\">".$tvlguidInfoArr['trvl_guid_contact_web']."</a></td></tr>";
											}
											if(isset($tvlguidInfoArr['trvl_guid_contact_email']) && $tvlguidInfoArr['trvl_guid_contact_email'] !="") {
												echo "<tr><td><strong>Email : </strong>".$tvlguidInfoArr['trvl_guid_contact_email']."</td></tr>";
											}
											echo "</table>";
											echo "</td>";
											echo "</tr>";
										}
                                        ?>
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
</div>
</body>
</html>
