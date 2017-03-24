<?php
// Form submision
$detail_array 	= array();
$error_msg		= 'no';

if($_POST['securityKey'] == md5("UPDATEPACKAGE")){
	$packageArr 	= array_combine($_POST['txtPackage'], $_POST['txtCredits']);
	$productRateArr = array_combine($_POST['txtProduct'], $_POST['txtProductRate']);
	$productObj->fun_editPackageCredit($packageArr);
	$productObj->fun_editProductsRate($productRateArr);
	echo "<script>location.href = 'admin-site-variables.php?sec=package';</script>";
}

$packageInfoArr 	= $productObj->fun_getPackageInfoArr();
?>
<script language="javascript" type="text/javascript">
	function frmValidatePackage() {
		var shwError = false;
		if(shwError == true) {
			return false;
		} else {
			document.frmPackage.submit();
		}
	}
</script>
<form name="frmPackage" id="frmPackage" action="admin-site-variables.php?sec=package" method="post">
<input type="hidden" name="securityKey" id="securityKey" value="<?php echo md5("UPDATEPACKAGE")?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr><td class="SectionSubHead pad-btm12"><?php echo $addtitle;?></td></tr>
    <tr><td>&nbsp;</td></tr>
	<tr>
		<td valign="top">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableRates">
				<tr>
					<th align="left">Package</th>
					<th align="center" class="blackTxt14 pad-rgt5">Credit</th>
					<th align="right" class="blackTxt14 pad-rgt5">USD</th>
				</tr>
				<?php
				for($i = 0; $i < count($packageInfoArr); $i++) {
					$products_id 	= $packageInfoArr[$i]['products_id'];
					$package_id 	= $packageInfoArr[$i]['package_id'];
					$package_name 	= $packageInfoArr[$i]['package_name'];
					$credits 		= $packageInfoArr[$i]['credits'];
					$products_price = $packageInfoArr[$i]['products_price'];
					echo "<tr>";
					echo "<td width=\"290\" class=\"pad-top5 blackTxt14 pad-btm5\">".ucfirst($package_name)."</td>";
					echo "<td width=\"150\" align=\"right\" class=\"pad-top5 pad-rgt5 pad-btm5\">";
					echo "<input name=\"txtPackage[]\" type=\"hidden\" value=\"".$package_id."\" />";
					echo "<input name=\"txtCredits[]\" type=\"text\" value=\"".$credits."\" class=\"Textfield75\" />";
					echo "</td>";
					echo "<td width=\"150\" align=\"right\" class=\"pad-top5 pad-rgt5 pad-btm5\">";
					echo "<input name=\"txtProduct[]\" type=\"hidden\" value=\"".$products_id."\" />";
					echo "<input name=\"txtProductRate[]\" type=\"text\" value=\"".$products_price."\" class=\"Textfield75\" />";
					echo "</td>";
					echo "</tr>";
				}
				?>
			</table>
		</td>
	</tr>
    <tr>
        <td valign="top" class="pad-lft20 pad-top15"><a href="javascript:void(0);" onclick="frmValidatePackage();" style="text-decoration:none;"><img src="images/save-changes-admin.png" alt="Save Changes"/></a></td>
    </tr>
    <tr><td>&nbsp;</td></tr>
</table>
</form>