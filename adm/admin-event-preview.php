<?php
require_once("includes/application-top-inner.php");
if(isset($_GET['evntid']) && $_GET['evntid'] !=""){
	$event_id = $_GET['evntid'];
	$eventInfoArr = $eventObj->fun_getEventInfo($event_id);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title><?php echo $sitetitle;?> :: Admin :: Event Preview</title>
    <link href="includes/css/admin.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div align="center" style="padding:0px 10px 0px 10px; font-size:12px; background-color:#FFFFFF;">
	<table width="450" border="0" cellspacing="0" cellpadding="0"  bgcolor="#FFFFFF">
		<tr><td align="left" valign="top" class="dash31">&nbsp;</td></tr>
		<tr><td align="left" valign="top" class="pad-btm10 pad-top10"><h1 class="page-heading"><?php echo $eventInfoArr['event_name']; ?></h1></td></tr>
		<tr>
			<td align="left" valign="top">
				<table width="450" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td align="left" valign="top" class="pad-top15">
							<table border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td align="left" valign="top">
										<table border="0" cellpadding="0" cellspacing="0">
											<?php
                                            if(isset($eventInfoArr['event_img']) && $eventInfoArr['event_img'] !="") {
                                                echo "<tr>";
                                                echo "<td valign=\"top\" class=\"pad-btm8\">";
                                                echo "<img src=\"../".EVENT_IMAGES_LARGE449x341.$eventInfoArr['event_img']."\" alt=\"".$eventInfoArr['event_img_caption']."\" id=\"txtEvntPhotoId\" width=\"449\" height=\"341\" />";
                                                echo "</td>";
                                                echo "</tr>";
                                                echo "<tr>";
                                                echo "<td valign=\"top\" class=\"pad-btm8\">";
                                                echo "<div id=\"txtEvntPhotoCaptionId\" class=\"font11 FloatLft\">".ucfirst($eventInfoArr['event_img_caption'])."</div>";
                                                if(isset($eventInfoArr['event_img_by']) && ($eventInfoArr['event_img_by'] != "" || $eventInfoArr['event_img_by'] != "Photo By")) {
                                                echo "<div id=\"txtEvntPhotoById\" class=\"font10 FloatRgt\">Photo By ".ucfirst($eventInfoArr['event_img_by'])."</div>";
                                                }
                                                echo "</td>";
                                                echo "</tr>";
                                            }
                                            ?>
											<tr>
												<td valign="top" class="pad-btm20"><div><?php echo $eventInfoArr['event_description']; ?></div></td>
											</tr>
											<tr>
												<td valign="top" class="pad-btm10"><span class="gray20">Information</span></td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td align="left" valign="top">
							<table border="0" cellpadding="0" cellspacing="0" class="eventsData">
								<?php
									if(isset($eventInfoArr['event_start_date']) && ($eventInfoArr['event_start_date'] != "") && isset($eventInfoArr['event_end_date']) && ($eventInfoArr['event_end_date'] != "")) {
									?>
										<tr class="grayRow">
											<td width="87"><strong>Dates</strong></td>
											<td width="364" align="left" class="pad-lft20">
                                            <strong>
												<?php 
													if($eventInfoArr['event_year_around'] == "1") {
														echo "All year round";
													} else {
														echo date('M d, Y', strtotime($eventInfoArr['event_start_date']))." - ".date('M d, Y', strtotime($eventInfoArr['event_end_date'])); 
													}
												?>
                                            </strong>
                                            </td>
										</tr>
									<?php
									}
								?>
								<?php
									if(isset($eventInfoArr['event_venue']) && ($eventInfoArr['event_venue'] != "")) {
									?>
										<tr>
											<td><strong>Venue</strong></td>
											<td align="left" class="pad-lft20"><?php echo $eventInfoArr['event_venue']; ?></td>
										</tr>
									<?php
									}
								?>
								<?php
									if(isset($eventInfoArr['event_price']) && ($eventInfoArr['event_price'] != "")) {
									?>
										<tr class="grayRow">
											<td><strong>Ticket prices</strong></td>
											<td align="left" class="pad-lft20"><?php echo $eventInfoArr['event_price']; ?></td>
										</tr>
									<?php
									}
								?>
								<?php
									if(isset($eventInfoArr['event_time']) && ($eventInfoArr['event_time'] != "")) {
									?>
										<tr>
											<td><strong>Times</strong></td>
											<td align="left" class="pad-lft20"><?php echo $eventInfoArr['event_time']; ?></td>
										</tr>
									<?php
									}
								?>
								<?php
									if(isset($eventInfoArr['event_phone']) && ($eventInfoArr['event_phone'] != "")) {
									?>
										<tr class="grayRow">
											<td><strong>Telephone</strong></td>
											<td align="left" class="pad-lft20"><?php echo $eventInfoArr['event_phone']; ?></td>
										</tr>
									<?php
									}
								?>
								<?php
									if(isset($eventInfoArr['event_website']) && ($eventInfoArr['event_website'] != "")) {
									?>
										<tr>
											<td><strong>Website</strong></td>
											<td align="left" class="pad-lft20"><a href="<?php if(substr($eventInfoArr['event_website'], 0, 7) == "http://") { echo $eventInfoArr['event_website']; } else { echo "http://".$eventInfoArr['event_website']; } ?>" class="blue-link"><?php echo $eventInfoArr['event_website']; ?></a></td>
										</tr>
									<?php
									}
								?>
								<?php
									if(isset($eventInfoArr['event_email']) && ($eventInfoArr['event_email'] != "")) {
									?>
										<tr class="grayRow">
											<td><strong>Email</strong></td>
											<td align="left" class="pad-lft20"><a class="blue-link" href="mailto:<?php echo $eventInfoArr['event_email']; ?>"><?php echo $eventInfoArr['event_email']; ?></a></td>
										</tr>
									<?php
									}
								?>

							</table>
						</td>
					</tr>
					<tr><td align="left" valign="top" class="dash31">&nbsp;</td></tr>
				</table>
			</td>
		</tr>
	</table>
</div>
</body>
</html>
