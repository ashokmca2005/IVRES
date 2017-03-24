<?php
session_start();
require_once("includes/common.php");
require_once("includes/database-table.php");
require_once("includes/classes/class.DB.php");
require_once("includes/functions/general.php");
require_once("includes/classes/class.Admins.php");
$dbObj = new DB();
$dbObj->fun_db_connect();

$adminsObj 		= new Admins();
$errorMsg 		= "";
$errorArray 	= "";
$errorArray['name_error'] 		= '';
$errorArray['password_error'] 	= '';
if($_POST['securityKey'] == md5("ADMINLOGIN")){
	if(trim($_POST['user_name']) == ''){
		$errorArray['name_error'] = 'Username required';
	}
	if(trim($_POST['user_password']) == ''){
		$errorArray['password_error'] = 'Password required';
	}
	if(trim($_POST['user_name']) != '' && trim($_POST['user_password']) != ''){
		$adminName 		= $_POST['user_name'];
		$adminPassword 	= $_POST['user_password'];
		if($adminsObj->fun_verifyAdmins($adminName, $adminPassword)){			
			$adminsDets = $adminsObj->fun_getAdminInfo(0, $adminName);
			if(($adminsDets["user_status"]=="1") && ($adminsDets["is_admin"]=="1")){
				$_SESSION['ses_admin_id'] 		= $adminsDets["user_id"];
				$_SESSION['ses_admin_fname'] 	= $adminsDets["user_fname"];
				$_SESSION['ses_admin_email'] 	= $adminsDets["user_email"];
				$_SESSION['ses_admin_pass'] 	= $adminsDets["user_pass"];
				redirectURL("admin-home.php"); // admin dashboard
			} else {
				$errorMsg = "Your account has been suspended due to some reasons.";
			}
		} else {
			$errorMsg = "Invalid Username or Password!";
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $sitetitle;?> :: Welcome</title>

</head>
<body>
<!-- UniqueSleeps Main Wrapper Starts Here -->
<div id="MainWrapper">
<div id="div">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td align="center" valign="middle">
			<table width="750px" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td>
						<div align="center">
                        <img src="../images/logo.jpg" /><br />
						<form action="" method="post" name="frmLogin" id="frmLogin">
						<input type="hidden" name="securityKey" value="<?php echo md5(ADMINLOGIN);?>" />
						<table width="46%" border="1" align="center" cellpadding="0" cellspacing="0" style="background-color:#ffFFFF; border:solid 1px #CCCCCC;">
							<tr>							
								<td>
									<table width="100%" border="0" align="center" cellpadding="0" cellspacing="5">
										<tr><td colspan="2" align="center" nowrap="nowrap" class="boldTitle">Please Enter your Username and Password</td></tr>
										<?php 
										if($errorMsg == '')	{
										?>
										<tr height="30"><td align="right">&nbsp;</td></tr>
										<?php 
										} else {
										?>
										<tr height="30">
										<td colspan="2" align="center" nowrap="nowrap" class="red1"><?php if(isset($errorMsg) && $errorMsg != '')echo $errorMsg;?></td>
										</tr>
										<?php 
										}
										?>  
										<tr>
											<td width="38%" align="right"><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">Username:</font></td>
											<td width="62%" align="left" class="red1"><input name="user_name" type="text" id="user_name" value="<?php echo trim($_POST['user_name']);?>" />&nbsp;<?php if(array_key_exists('name_error', $errorArray)) echo $errorArray['name_error'];?></td>
										</tr>
										<tr>
											<td align="right"><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">Password:</font></td>
											<td align="left" class="red1"><input name="user_password" type="password" id="user_password" value="<?php echo trim($_POST['user_password']);?>" />&nbsp;<?php if(array_key_exists('password_error', $errorArray)) echo $errorArray['password_error'];?></td>
										</tr>
										<tr>
											<td align="right">&nbsp;</td>
											<td align="left">&nbsp;</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td align="left">
												<input name="Submit" type="submit" class="formt" value="Submit" />
												<input name="Reset" type="reset" class="formt" id="Reset" value="Reset" />
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<br />
						<br />
						<br />
						<br />
						<br />
						<br />
						<br />
						<br />
						<br />
						</form>
						</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</div>
</div>
<!-- Main Wrapper Ends Here -->
</body>
</html>