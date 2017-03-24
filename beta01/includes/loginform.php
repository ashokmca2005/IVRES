<script type="text/javascript">
	$(document).ready(function(){
		$('#user_password').keypress(function(event){
			var keycode = (event.keyCode ? event.keyCode : event.which);
			if(keycode == '13'){
				validateLogin();
				//alert('You pressed a "enter" key in textbox');	
			}
			event.stopPropagation();
		});
	});
	/*
	$(document).keypress(function(event){
		var keycode = (event.keyCode ? event.keyCode : event.which);
		if(keycode == '13'){
			alert('You pressed a "enter" key in somewhere');	
		}
	});
	*/
</script>
<h2 class="font16-darkgrey">Login</h2>
<form name="frmLogin" id="frmLogin" action="login" method="post">
<input type="hidden" name="securityKey" value="<?php echo md5(USERLOGIN);?>" />
<table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr><td colspan="2" align="left"><strong>Please Enter your Username and Password</strong></td></tr>
    <tr><td colspan="2" class="error"><?php if($errorMsg == ''){ echo '&nbsp;'; } else { echo $errorMsg; }?></td></tr>
    <tr>
        <td width="235" valign="left">
        Username<span class="compulsory">*</span><br />
        <input type="text" name="user_name" id="user_name" class="RegFormFld" value="<?php echo trim($_POST['user_name']);?>" />
        </td>
        <td valign="top"><span class="error" id="showErrorUserNameId"><?php if(array_key_exists('name_error', $errorArray)) echo $errorArray['name_error'];?></span></td>
    </tr>
    <tr>
        <td width="235" valign="left">
        Password<span class="compulsory">*</span><br />
        <input type="password" name="user_password" id="user_password" class="RegFormFld" value="<?php echo trim($_POST['user_password']);?>" />
        </td>
        <td valign="top"><span class="error" id="showErrorPasswordId"><?php if(array_key_exists('password_error', $errorArray)) echo $errorArray['password_error'];?></span></td>
    </tr>
    <tr><td class="pad-top5" colspan="2"><a href="<?php echo SITE_URL; ?>forget-password.php" class="blue-link">Forgotton password</a></td></tr>
    <tr>
        <td colspan="2" valign="middle"><a href="javascript:cancelLogin();" class="button-grey" style="text-decoration:none;">Cancel</a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="return validateLogin();" class="button-blue" style="text-decoration:none;">Submit</a></td>
    </tr>
</table>
</form>
