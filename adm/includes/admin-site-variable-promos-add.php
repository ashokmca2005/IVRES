<?php
if(isset($_GET['id']) && $_GET['id'] <> ''){
	$securityKey = "Update";
	$banner_id   = $_GET['id'];
	$banner_info = $bannerObj->fun_getBannerInfo($banner_id);
	$banner_name = SITE_URL."upload/banners-logos/banners/120x60/".$banner_info[0]['banner_name'];
	
} else {
	$securityKey = "Add";
}
if(isset($_REQUEST['securityKey'])){
	if($_REQUEST['securityKey'] == md5("Add")){
		$rand       = rand(00000,99999);
		$photo_id   = $_FILES['img_banner']['name'];
		$photo_id   = $rand.$photo_id;
		$photo_main = $photo_id;

		$uploadphotodir  = '../upload/banners-logos/banners';
		$uploadphotofile = $uploadphotodir ."/". $photo_main;


		$uploadphotofile763x236 = $uploadphotodir ."/763x236/". $photo_main;
		$uploadphotofile658x270 = $uploadphotodir ."/658x270/". $photo_main;
		$uploadphotofile480x360 = $uploadphotodir ."/562x332/". $photo_main;
		$uploadphotofile244x183 = $uploadphotodir ."/120x60/". $photo_main;
		$uploadthumbfile168x126 = $uploadphotodir ."/200x200/". $photo_main;
		$uploadthumbfile88x66   = $uploadphotodir ."/468x60/". $photo_main;

		$photo_offer_id   = $_FILES['img_offer']['name'];
		$photo_offer_id   = $rand.$photo_offer_id;
		$photo_offer_main = $photo_offer_id;

		$uploadphotoofferdir  = '../upload/banners-logos/banners';
		$uploadphotoofferfile = $uploadphotoofferdir ."/". $photo_offer_main;


		$uploadphotoofferfile763x236 = $uploadphotoofferdir ."/763x236/". $photo_offer_main;
		$uploadphotoofferfile658x270 = $uploadphotoofferdir ."/658x270/". $photo_offer_main;
		$uploadphotoofferfile480x360 = $uploadphotoofferdir ."/562x332/". $photo_offer_main;
		$uploadphotoofferfile244x183 = $uploadphotoofferdir ."/120x60/". $photo_offer_main;
		$uploadthumbofferfile168x126 = $uploadphotoofferdir ."/200x200/". $photo_offer_main;
		$uploadthumbofferfile88x66   = $uploadphotoofferdir ."/468x60/". $photo_offer_main;


		if(move_uploaded_file($_FILES['img_banner']['tmp_name'], $uploadphotofile)){
			$imgObj->getCrop($uploadphotodir,$photo_main,763,236,$uploadphotofile763x236);
			$imgObj->getCrop($uploadphotodir,$photo_main,658,270,$uploadphotofile658x270);
			$imgObj->getCrop($uploadphotodir,$photo_main,562,332,$uploadphotofile480x360);
			$imgObj->getCrop($uploadphotodir,$photo_main,120,60,$uploadphotofile244x183);
			$imgObj->getCrop($uploadphotodir,$photo_main,200,200,$uploadthumbfile168x126);
			$imgObj->getCrop($uploadphotodir,$photo_main,468,60,$uploadthumbfile88x66);
			
			if(move_uploaded_file($_FILES['img_offer']['tmp_name'], $uploadphotoofferfile)){
			$imgObj->getCrop($uploadphotoofferdir,$photo_offer_main,763,236,$uploadphotoofferfile763x236);
			$imgObj->getCrop($uploadphotoofferdir,$photo_offer_main,658,270,$uploadphotoofferfile658x270);
			$imgObj->getCrop($uploadphotoofferdir,$photo_offer_main,562,332,$uploadphotoofferfile480x360);
			$imgObj->getCrop($uploadphotoofferdir,$photo_offer_main,120,60,$uploadphotoofferfile244x183);
			$imgObj->getCrop($uploadphotoofferdir,$photo_offer_main,200,200,$uploadthumbofferfile168x126);
			$imgObj->getCrop($uploadphotoofferdir,$photo_offer_main,468,60,$uploadthumbofferfile88x66);
			}
			
			$banner_id = $bannerObj->fun_processBanner($_POST);
			if($banner_id <> ''){
				$bannerObj->fun_updateBanner($banner_id, $photo_main, $photo_offer_main);
			}
		} else {
			$message = "Error: We are unable to update your property photos detail!";
		}

		echo "<script>location.href='admin-site-variables.php?sec=prom'</script>";
	} else if($_REQUEST['securityKey'] == md5("Update")){
		if($_POST['image_action'] == 2){
			unlink("../upload/banners-logos/banners/".$_POST['image_name']);
			unlink("../upload/banners-logos/banners/120x60/".$_POST['image_name']);
			unlink("../upload/banners-logos/banners/200x200/".$_POST['image_name']);
			unlink("../upload/banners-logos/banners/468x60/".$_POST['image_name']);
			unlink("../upload/banners-logos/banners/562x332/".$_POST['image_name']);
			unlink("../upload/banners-logos/banners/763x236/".$_POST['image_name']);
			$photo_main = '';

			$bannerObj->fun_updateBannerById($_POST, $photo_main);
		} else if($_POST['image_action'] == 1) {
			unlink("../upload/banners-logos/banners/".$_POST['image_name']);
			unlink("../upload/banners-logos/banners/120x60/".$_POST['image_name']);
			unlink("../upload/banners-logos/banners/200x200/".$_POST['image_name']);
			unlink("../upload/banners-logos/banners/468x60/".$_POST['image_name']);
			unlink("../upload/banners-logos/banners/562x332/".$_POST['image_name']);
			unlink("../upload/banners-logos/banners/763x236/".$_POST['image_name']);
			$rand = rand(00000,99999);
			$photo_id   = $_FILES['img_banner']['name'];
			$photo_id   = $rand.$photo_id;
			$photo_main = $photo_id;

			$uploadphotodir  = '../upload/banners-logos/banners';
			$uploadphotofile = $uploadphotodir ."/". $photo_main;

			$uploadphotofile763x236 = $uploadphotodir ."/763x236/". $photo_main;
			$uploadphotofile480x360 = $uploadphotodir ."/562x332/". $photo_main;
			$uploadphotofile244x183 = $uploadphotodir ."/120x60/". $photo_main;
			$uploadthumbfile168x126 = $uploadphotodir ."/200x200/". $photo_main;
			$uploadthumbfile88x66   = $uploadphotodir ."/468x60/". $photo_main;
			if(move_uploaded_file($_FILES['img_banner']['tmp_name'], $uploadphotofile)){
				$imgObj->getCrop($uploadphotodir,$photo_main,763,236,$uploadphotofile763x236);
				$imgObj->getCrop($uploadphotodir,$photo_main,562,332,$uploadphotofile480x360);
				$imgObj->getCrop($uploadphotodir,$photo_main,120,60,$uploadphotofile244x183);
				$imgObj->getCrop($uploadphotodir,$photo_main,200,200,$uploadthumbfile168x126);
				$imgObj->getCrop($uploadphotodir,$photo_main,468,60,$uploadthumbfile88x66);
				$bannerObj->fun_updateBannerById($_POST, $photo_main);
			}else{
				$message = "Error: We are unable to update your property photos detail!";
			}
			echo "<script>location.href='admin-site-variables.php?sec=prom'</script>";
		} else {
			$message = "Error: Please choose one image action";
		}
	}
}
echo "<b>".$addtitle."</b>";
?>
<form name="frm_update_banner" id="frm_update_banner" action="admin-site-variables.php?sec=promadd" method="post" enctype="multipart/form-data">
	<input type="hidden" name="securityKey" id="securityKey" value="<?php echo md5($securityKey);?>">
	<input type="hidden" name="ban_id" id="ban_id" value="<?php echo $banner_id;?>" />
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
		<tr><td height="10" colspan="2" valign="top">&nbsp;</td></tr>
		<tr>
			<td valign="top"><a href="javascript: history.go(-1)" class="back">Back to List</a></td>
			<td align="right" valign="top">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2" valign="top" class="pad-top5">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
					<tr>
						<td valign="top" class="pad-top7">
							<table width="690" border="0" cellspacing="0" cellpadding="0" class="font12">
								<tr>
									<td align="left" valign="top">
										<table width="100%" border="0" cellspacing="0" cellpadding="10" class="eventForm">
											<tr>
												<td colspan="2" align="right" valign="top" class="header">
													<table width="100%" border="0" cellspacing="0" cellpadding="0">
														<tr><td align="right" valign="bottom">&nbsp;</td></tr>
													</table>
												</td>
											</tr>
											<tr>
												<td colspan="2" align="right" valign="top" class="header">
													<table width="100%" border="0" cellspacing="0" cellpadding="0">
														<tr>
															<td>&nbsp;</td>
															<td align="right" valign="bottom">&nbsp;<a href="javascript: history.go(-1);" style="text-decoration:none;"><img src="images/cancelChangesN.png" alt="Cancel" width="119" height="21" border="0" /></a>&nbsp;<a href="javascript:void(0);" onClick="frmValidate();" style="text-decoration:none;"><img src="images/saveChangesN.png" alt="Save Approve" width="108" height="21" border="0" /></a></td>
														</tr>
													</table>
												</td>
											</tr>
											<?php if(isset($message)){?>
											<tr>
												<td colspan="2"><?php echo $message;?></td>
											</tr>
											<?php }?>
											<tr>
												<td height="23" align="right" valign="top" class="admleftBg">Banner Caption</td>
												<td valign="top"><input type="text" name="banner_caption" id="banner_caption" value="<?php echo $banner_info[0]['banner_caption'];?>" style="width:200px;"></td>
											</tr>
											<tr>
												<td height="23" align="right" valign="top" class="admleftBg">Banner Name</td>
												<td valign="top"><input type="text" name="banner_name" id="banner_name" value="<?php echo $banner_info[0]['banner_name'];?>" style="width:200px;"></td>
											</tr>

                                            <tr>
												<td width="190" height="23" align="right" valign="top" class="admleftBg">Select Banner </td>
												<td valign="top"><input type="file" name="img_banner" id="img_bannerId"></td>
											</tr>
                                            
											<?php if(isset($banner_id) && $banner_id <> ''){?>
												<tr>
													<td width="190" height="23" align="right" valign="top" class="admleftBg">Banner</td>
													<td valign="top">
														<div>
															<span><img src="<?php echo $banner_name;?>" border="0"><input type="hidden" name="image_name" id="image_name" value="<?php echo $banner_info[0]['banner_name'];?>" /></span>&nbsp;
															<span><br /><input type="radio" name="image_action" value="1" />&nbsp;Replace this image<br /><input type="radio" name="image_action" value="2" />&nbsp;Delete this image</span>
														</div>
													</td>
												</tr>
											<?php }?>
											<tr>
												<td height="23"  align="right" valign="top" class="admleftBg">Banner Link</td>
												<td valign="top"><input type="text" name="banner_link" id="banner_link" value="<?php echo $banner_info[0]['banner_link'];?>" style="width:200px;"></td>
											</tr>
											<tr>
												<td width="190" height="23" align="right" valign="top" class="admleftBg">Select Offer </td>
												<td valign="top"><input type="file" name="img_offer" id="img_offerId"></td>
											</tr>

                                            <tr>
												<td height="23" align="right" valign="top" class="admleftBg">Offer Link</td>
												<td valign="top"><input type="text" name="offer_link" id="offer_link" value="<?php echo $banner_info[0]['offer_link'];?>" style="width:200px;"></td>
											</tr>
                                            <tr>
												<td height="23"  align="right" valign="top" class="admleftBg">Banner Type</td>
												<td valign="top">
												<select name="banner_type" id="banner_type" style="display:block;" class="select216">
                                                    <option value="1" <?php if($banner_info[0]['banner_type'] == "1") { echo " selected=\"selected\"";} ?>>Home Promo Banner</option>
                                                    <option value="2" <?php if($banner_info[0]['banner_type'] == "2") { echo " selected=\"selected\"";} ?>>Home Left Banner</option>
                                                    <option value="3" <?php if($banner_info[0]['banner_type'] == "3") { echo " selected=\"selected\"";} ?>>Search List Banner</option>
												</select>
                                                </td>
											</tr>
											<tr>
												<td height="23" align="right" valign="top" class="admleftBg">Start Date</td>
												<td valign="top"><input type="text" name="start_date" id="start_date" value="<?php echo $banner_info[0]['start_date'];?>" style="width:200px;">&nbsp;<a href="JavaScript:find_cal(<?php if(isset($dateFromUnix)) {echo $dateFromUnix;} else {echo time();} ?>,'start_date');"><img src="images/calender.gif" alt="calendar" border="0" /></a></td>
											</tr>
											<tr>
												<td height="23" align="right" valign="top" class="admleftBg">End Date</td>
												<td valign="top"><input type="text" name="end_date" id="end_date" value="<?php echo $banner_info[0]['end_date'];?>" style="width:200px;">&nbsp;<a href="JavaScript:find_cal(<?php if(isset($dateFromUnix)) {echo $dateFromUnix;} else {echo time();} ?>,'end_date');"><img src="images/calender.gif" alt="calendar" border="0" /></a></td>
											</tr>
											<tr>
												<td colspan="2" align="right" valign="top" class="header">
													<table width="100%" border="0" cellspacing="0" cellpadding="0">
														<tr>
															<td>&nbsp;</td>
															<td align="right" valign="bottom">&nbsp;<a href="javascript: history.go(-1);" style="text-decoration:none;"><img src="images/cancelChangesN.png" alt="Cancel" width="119" height="21" border="0" /></a>&nbsp;<a href="javascript:void(0);" onClick="frmValidate();" style="text-decoration:none;"><img src="images/saveChangesN.png" alt="Save Approve" width="108" height="21" border="0" /></a></td>
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
					<tr><td valign="top">&nbsp;</td></tr>
					<tr><td valign="top">&nbsp;</td></tr>
				</table>
			</td>
		</tr>
	</table>
</form>

<script language="javascript" type="text/javascript">
	var req = ajaxFunction();
	var x1 = "";
	var y1 = "";

	function find_cal(a,ct){
		var url = "<?php echo SITE_URL;?>get_cal.php";
		url = url+"?timestamp="+a+"&ct="+ct;
		req.onreadystatechange = function(){
			if (req.readyState == 4){
				var object;
				object = req.responseText;				
				x1 = x+160;
				y1 = y-153;
				var googlewin=dhtmlwindow.open("CalendarDiv", "inline", object, " ", "width=235px,height=285px,resize=0,scrolling=0,center=1,xAxis="+x1+",yAxis="+y1+"", "recal");
				googlewin.onclose = function(){
					return true
				}
			}
		}
		req.open("GET",url,true);
		req.send(null);
	}

	function find_cal1(a,ct){
		var url = "<?php echo SITE_URL;?>get_cal.php";
		url = url+"?timestamp="+a+"&ct="+ct;

		req.onreadystatechange = function(){
			if (req.readyState==4){
				var object;
				object = req.responseText;				
				x1 = x-75;
				y1 = y-153;
				var googlewin = dhtmlwindow.open("CalendarDiv", "inline", object, " ", "width=235px,height=285px,resize=0,scrolling=0,center=1,xAxis="+x1+",yAxis="+y1+"", "recal");
				googlewin.onclose = function(){
					return true
				}
			}
		}
		req.open("GET",url,true);
		req.send(null);
	}

	function find_cal2(a,ct){
		var url = "<?php echo SITE_URL;?>get_cal1.php";
		url = url+"?timestamp="+a+"&ct="+ct;
		req.onreadystatechange = function(){
			if (req.readyState==4){
				var object;
				object = req.responseText;				
				var googlewin = dhtmlwindow.open("CalendarDiv", "inline", object, " ", "width=235px,height=285px,resize=0,scrolling=0,center=1,xAxis="+x1+",yAxis="+y1+"", "recal");
				googlewin.onclose = function(){
					return true
				}
			}
		}
		req.open("GET",url,true);
		req.send(null);
	}

	function find_cal3(a,ct){
		var url = "<?php echo SITE_URL;?>get_cal.php";
		url=url+"?timestamp="+a+"&ct="+ct;
		req.onreadystatechange=function(){
			if(req.readyState==4){
				var object;
				object = req.responseText;				
				var googlewin=dhtmlwindow.open("CalendarDiv", "inline", object, " ", "width=235px,height=285px,resize=0,scrolling=0,center=1,xAxis="+x1+",yAxis="+y1+"", "recal");
				googlewin.onclose=function(){ //Run custom code when window is being closed (return false to cancel action):
					return true
				}
			}
		}
		req.open("GET",url,true);
		req.send(null);
	}
	
	function insert_date(dt,sid){
		var dateString = String(dt);
		var dateBody = dateString.split("/");

		var final_date = String(dateBody[2])+"-"+String(dateBody[0])+"-"+String(dateBody[1]);
		document.getElementById(sid).value = final_date;
		document.getElementById("CalendarDiv").style.display = "none";
	}

	function close_calendar(){		
		document.getElementById("CalendarDiv").style.display = "none";
	}

	function frmValidate(){
		var frm = document.frm_update_banner;
		if(frm.banner_caption.value == ''){
			alert("Error: Please enter the banner caption.");
			frm.banner_caption.focus();
			return false;
		}
		if(frm.banner_link.value == ''){
			alert("Error: Please enter banner link.");
			frm.banner_link.focus();
			return false;
		}
		if(frm.start_date.value == ''){
			alert("Error: Please enter start date.");
			frm.start_date.focus();
			return false;
		}if(frm.end_date.value == ''){
			alert("Error: Please enter end date.");
			frm.end_date.focus();
			return false;
		}else{
			document.frm_update_banner.submit();
		}
	}
</script>
