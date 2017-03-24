<?php
require_once("includes/application-top-inner.php");
$userArr = $usersObj->fun_getUser4NewsLeterListArr();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>OneLocation :: Admin :: News letter sign up</title>
    <link href="includes/css/admin.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" language="javascript" src="includes/js/admin.js"></script>
</head>
<body>
<!-- OneLocation Main Wrapper Starts Here -->
<div id="OneLocation">
    <!-- Header Include Starts Here -->
    <div>
        <?php require_once(SITE_ADMIN_INCLUDES_PATH.'admin-header.php'); ?>
    </div>
    <!-- Header Include Ends Here -->
    <div id="div">
    <table width="974" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td class="width18">&nbsp;</td>
            <td valign="top" class="width210"><?php require_once(SITE_ADMIN_INCLUDES_PATH.'admin-left-links.php'); ?></td>
            <td valign="top" class="width26">&nbsp;</td>
            <!-- Main body should be added here : Start Here -->
            <td valign="top" style="font:Arial, Helvetica, sans-serif; font-size:11px;">
				<?php
				if(is_array($userArr) && count($userArr) > 0) {
				?>
				<table width="690" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td align="center">
							<table width="100%" border="0" cellspacing="0" cellpadding="2">
								<tr><td align="center" colspan="8"><strong>User Email list</strong></td></tr>
								<tr>
									<td align="center" width="10%"><strong>Sr. No.</strong></td>
									<td align="left" width="25%"><strong>Name</strong></td>
									<td align="left" width="30%"><strong>Email Id</strong></td>
									<td align="center" width="15%"><strong>Added Date</strong></td>
									<td align="center" width="10%"><strong>Is Owner?</strong></td>
									<td align="center" width="10%"><strong>Verified</strong></td>
								</tr>
		
								<?php
								for($i = 0; $i < count($userArr); $i++) {
									if($i%2 == 0) {$style = "style=\"background-color:#CCCCCC\"";} else {$style = "style=\"background-color:#FFFFFF\"";}
									echo "<tr ".$style.">";
									echo "<td align=\"center\">".($i+1)."</td>";
									echo "<td align=\"left\">".$userArr[$i]['user_name']."</td>";
									echo "<td align=\"left\">".$userArr[$i]['user_email']."</td>";
									echo "<td align=\"center\">".date('d M, Y', $userArr[$i]['created_on'])."</td>";
									echo "<td align=\"center\">";
									if($userArr[$i]['user_type'] == "1") {
										echo "Yes";
									} else {
										echo "No";
									}
									echo "</td>";
									echo "<td align=\"center\">";
									if($userArr[$i]['active'] == "1") {
										echo "Yes";
									} else {
										echo "No";
									}
									echo "</td>";
									echo "</tr>";
								}
								?>
							</table>
		
						</td>
					</tr>
				</table>
				<?php
				}
				?>
			</td>
            <!-- Main body should be added here : End Here -->
            <td class="width22">&nbsp;</td>
        </tr>
    </table>
    </div>
    <!-- Footer Include Starts Here -->
    <div id="footer">
        <?php require_once(SITE_ADMIN_INCLUDES_PATH.'admin-footer.php'); ?>
    </div>
    <!-- Footer Include Ends Here -->
</div>
<!-- OneLocation Main Wrapper Ends Here -->
</body>
</html>
