<?php
// Form submision
$detail_array 	= array();
$error_msg		= 'no';
if($_POST['securityKey'] == md5(ADDCURRENCY)){
	$txtEUR 	= $_POST['txtEUR'];
	$txtGBP 	= $_POST['txtGBP'];
	$txtUSD 	= $_POST['txtUSD'];
	$currencyObj->fun_editCurrencyRate($txtUSD, $txtGBP, $txtEUR);
	echo "<script>location.href = 'admin-site-variables.php?sec=curr';</script>";
}
$currencyInfoArr 	= $currencyObj->fun_getCurrencyRateInfoArr();
$currencyRateArr = array();
$update_on = 0;
$update_by = 1;
foreach($currencyInfoArr as $value) {
	$currencyRateArr[$value['currency_code']] = $value['currency_rate'];
	if($update_on < $value['updated_on']) {
		$update_on = $value['updated_on'];
		$update_by = $value['updated_by'];
	}
}

$updateTime 	= date('H:i', $update_on);//12:00
$updateDate 	= date('j F, Y', $update_on);//22 January 2008
$userInfoArr 	= $usersObj->fun_getUsersInfo($update_by);
$user_fname 	= $userInfoArr['user_fname'];
$user_lname 	= $userInfoArr['user_lname'];
$user_name 		= $user_fname." ".$user_lname;//Ashok Green
$strUpdateInfo 	= "Last updated ".$updateTime." on ".$updateDate." by ".$user_name;
?>
<script language="javascript" type="text/javascript">
	function frmValidateAddCurrency() {
		var shwError = false;

        if(document.frmAddCurrency.txtGBP.value == "") {
            document.getElementById("txtGBPErrorId").innerHTML = "Please enter GBP rate";
            document.frmAddCurrency.txtGBP.focus();
            shwError = true;
        } 
		
		if(document.frmAddCurrency.txtEUR.value == "") {
            document.getElementById("txtEURErrorId").innerHTML = "Please enter EUR rate";
            document.frmAddCurrency.txtEUR.focus();
            shwError = true;
        }

		if(document.frmAddCurrency.txtUSD.value == "") {
            document.getElementById("txtUSDErrorId").innerHTML = "Please enter USD rate";
            document.frmAddCurrency.txtUSD.focus();
            shwError = true;
        } 

		if(shwError == true) {
			return false;
		} else {
			document.frmAddCurrency.submit();
		}
	}
</script>
<form name="frmAddCurrency" id="frmAddCurrency" action="admin-site-variables.php?sec=curr" method="post">
<input type="hidden" name="securityKey" id="securityKey" value="<?php echo md5("ADDCURRENCY")?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
	<tr>
		<td width="90" class="SectionSubHead pad-btm12"><?php echo $addtitle;?></td>
		<td width="300" class="pad-btm12"><?php echo $strUpdateInfo;?></td>
		<td width="300" align="right" class="pad-btm12">
		<?php /*?>
        <a href="javascript:void(0);" title="Add Currency" style="text-decoration:none;"><img src="images/add-currency-admin.png" alt="Add Currency" border="0" /> </a>
        <?php */?>
        </td>
	</tr>
	<tr>
		<td colspan="3" valign="top" class="adminBox1" style="padding-top:5px;">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td colspan="2" valign="top">
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td width="220" valign="top" class="pad-lft20 pad-top13"><span class="blackTxt14">USD United States Dollars</span></td>
								<td width="200" valign="top" class="pad-lft20 pad-top13"><input name="txtUSD" id="txtUSDId" type="text" class="Textfield230" value="<?php echo $currencyRateArr['USD']; ?>"/></td>
								<td valign="top" class="pad-lft20 pad-top13"><span class="boldTitle" id="txtUSDErrorId">Base</span></td>
							</tr>
							<tr>
								<td valign="top" class="pad-lft20 pad-top13"><span class="blackTxt14">GBP United Kingdom Pounds</span></td>
								<td valign="top" class="pad-lft20 pad-top13"><input name="txtGBP" id="txtGBPId" type="text" class="Textfield230" value="<?php echo $currencyRateArr['GBP']; ?>" readonly="readonly" /></td>
								<td valign="top" class="pad-lft20 pad-top13"><span class="pdError1 pad-lft10" id="txtGBPErrorId"></span></td>
							</tr>
							<tr>
								<td valign="top" class="pad-lft20 pad-top13"><span class="blackTxt14">EUR Euro</span></td>
								<td valign="top" class="pad-lft20 pad-top13"><input name="txtEUR" id="txtEURId" type="text" class="Textfield230" value="<?php echo $currencyRateArr['EUR']; ?>" /></td>
								<td valign="top" class="pad-lft10 pad-top13"><span class="pdError1 pad-lft10" id="txtEURErrorId"></span></td>
							</tr>
							<tr><td colspan="3" class="height20">&nbsp;</td></tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td colspan="3" valign="top">&nbsp;</td></tr>
	<tr>
		<td colspan="3" valign="top">
			<p class="FloatLft pad-rgt5"><a href="admin-site-variables.php?sec=curr"><img src="images/cancel-admin.png" alt="Cancel"/></a></p>
			<p class="Floatlft"><a href="javascript:void(0);" onclick="frmValidateAddCurrency();" title="Add Currency" style="text-decoration:none;"><img src="images/save-changes-admin.png" alt="Save Changes"/></a></p>
		</td>
	</tr>
</table>
</form>