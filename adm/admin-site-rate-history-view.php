<?php
require_once("includes/application-top-inner.php");
$productInfoArr 	= $productObj->fun_getProductRateHistoryInfoArr();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title><?php echo $sitetitle;?> :: Admin :: Site Variable :: Rate schedule</title>
    <link href="includes/css/admin.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div align="center" style="padding:0px 10px 0px 10px; font-size:12px; background-color:#FFFFFF;">
	<table width="450" border="0" cellspacing="0" cellpadding="0"  bgcolor="#FFFFFF">
		<tr><td class="SectionSubHead pad-btm12">Site rates and charges</td></tr>
		<tr><td class="blackTxt14 pad-btm5">Site price history</td></tr>
		<tr><td>&nbsp;</td></tr>
		<?php
		if(is_array($productInfoArr) && count($productInfoArr) > 0) {
		?>
			<tr>
				<td valign="top">
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableRates">
						<tr>
							<th align="left">Products</th>
							<th>&nbsp;</th>
							<th align="right" class="blackTxt14 pad-rgt5">EUR</th>
						</tr>
						<?php
						for($i = 0; $i < count($productInfoArr); $i++) {
							$products_id 	= $productInfoArr[$i]['products_id'];
							$products_name 	= $productInfoArr[$i]['products_name'];
							$products_price = $productInfoArr[$i]['product_price'];
							if($schedule_on != $productInfoArr[$i]['schedule_on']) {
								$schedule_on = $productInfoArr[$i]['schedule_on'];
								$created_by 	= ucwords($productInfoArr[$i]['user_name']);
								$strSchedule	= date('M d, Y - h:i', $schedule_on)." by ".$created_by;
								echo "<tr><td colspan=\"3\"><strong>".$strSchedule."</strong></td></tr>";
							}
							echo "<tr>";
							echo "<td colspan=\"2\" class=\"pad-top7 blackTxt14 pad-btm7\">".ucfirst($products_name)."</td>";
							echo "<td width=\"90\" align=\"right\" class=\"pad-top7 pad-rgt5 pad-btm7\">";
							echo "<div class=\"ratesBox\">".$products_price."</div>";
							echo "</td>";
							echo "</tr>";
						}
						?>
					</table>
				</td>
			</tr>
		<?php
		} else {
		?>
		<tr><td><strong>No site rate history available</strong></td></tr>
		<?php
		}
		?>
	</table>
</div>
</body>
</html>
