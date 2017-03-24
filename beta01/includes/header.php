<!--Header Starts Here -->
<?php /*?>
<style type="text/css">
.flag{
	font-size:10px;
	float:right;
	margin-right:10px;
	margin-top:5px;
	width:120px;
	border:1px solid #ccc;
	clear:both;
}
.flag div{
	width:100px;
	float:left;
}
.flag span.country{
	margin:0 3px;
	color:#777777;
}
.flag span.downarrow{
	margin:0 3px;
	color:#777777;
}
.flag span.flagicon{
	margin:0 3px;
}
.openflag{
	width:120px;
	margin-top:5px;
	padding:3px;
	background:#f8f8f8;
	visibility: hidden;
	z-index:999;
	position:absolute;
	border:1px solid #e8e4e3;
}
.openflag a{
	color:#2e2e2e;
	text-decoration:none;
}
.openflag .listCountry{
	padding-bottom:5px;
	overflow:auto;
}
.openflag table td{
	border-bottom:1px solid #e8e4e3;
	padding-bottom:5px;
}
</style>
<?php */?>
<script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>newslettersignup.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>header.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>dropdowncontent.js"></script>
<link type="text/css" href="<?php echo SITE_URL;?>jquery/themes/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo SITE_URL;?>jquery/js/jquery-1.6.2.js"></script>
<script type="text/javascript" src="<?php echo SITE_URL;?>jquery/js/jquery.ui.core.js"></script>
<script type="text/javascript" src="<?php echo SITE_URL;?>jquery/js/jquery.ui.widget.js"></script>
<script type="text/javascript" src="<?php echo SITE_URL;?>jquery/js/jquery.ui.position.js"></script>
<script type="text/javascript" src="<?php echo SITE_URL;?>jquery/js/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="<?php echo SITE_URL;?>jquery/js/jquery.ui.autocomplete.js"></script>
<script language="javascript" type="text/javascript">
	var req = ajaxFunction();

	function validateFrmMainSearch() {
	}
	function sendLoginRequest(strLoginName, strLoginPass, strRememberMe) { 
		req.open('get', '<?php echo SITE_URL;?>loginXml.php?usr=' + strLoginName + '&pass=' + strLoginPass + '&rm=' + strRememberMe); 
		req.onreadystatechange = handleLoginResponse; 
		req.send(null); 
	} 
	function handleLoginResponse() { 
		if(req.readyState == 4) {
			var response = req.responseText;
			xmlDoc=req.responseXML;
			var root = xmlDoc.getElementsByTagName('users')[0];
			if(root != null) {
				var items = root.getElementsByTagName("user");
				var item = items[0];
				var userstatus = item.getElementsByTagName("userstatus")[0].firstChild.nodeValue;
				var userurl = item.getElementsByTagName("userurl")[0].firstChild.nodeValue;
				if(userstatus == "User Login Success") {
					location.href = userurl;
				} else if(userstatus == "User Name Error") { 
					document.getElementById("loginErrorId").innerHTML = "<span style=\"font-size:12px; color:#FF0000; \">Please use a valid email address and try again</span>";
					document.getElementById("userEmailAddId").innerHTML = "<span style=\"font-size:12px; color:#FF0000; \">Email Address</span>";
					document.getElementById("user_name").value = "";
					document.getElementById("user_name").focus();
					return false;
				} else {
					document.getElementById("loginErrorId").innerHTML = "Please use a valid email address and try again";
					document.getElementById("userEmailPassId").innerHTML = "<span style=\"font-size:12px; color:#FF0000; \">Password</span>";
					document.getElementById("user_password").value = "";
					document.getElementById("user_password").focus();
					return false;
				}
			}
		} 
	} 
	function validatelogin(){
		var strRemember = "";
		if((document.getElementById("user_name").value == "")){
			document.getElementById("loginErrorId").innerHTML = "<span style=\"font-size:12px; color:#FF0000; \">Please use a valid email address and try again</span>";
			document.getElementById("userEmailAddId").innerHTML = "<span style=\"font-size:12px; color:#FF0000; \">Email Address</span>";
			document.getElementById("user_name").value = "";
			document.getElementById("user_name").focus();
			return false;
		}
		if((document.getElementById("user_password").value == "")){
			document.getElementById("loginErrorId").innerHTML = "Please use a valid email address and try again";
			document.getElementById("userEmailPassId").innerHTML = "<span style=\"font-size:12px; color:#FF0000; \">Password</span>";
			document.getElementById("user_password").value = "";
			document.getElementById("user_password").focus();
			return false;
		}
		if(document.getElementById("txtRememberMeId").checked == true){
			strRemember = document.getElementById("txtRememberMeId").value;
		}
		sendLoginRequest(document.getElementById("user_name").value, document.getElementById("user_password").value, strRemember);
	}
</script>
<div class="logo"><a href="<?php echo SITE_URL; ?>" title="<?php if(isset($siteVariableValueArr[9]) && $siteVariableValueArr[9] !=""){echo $siteVariableValueArr[9];}?>"><img src="<?php echo SITE_IMAGES;?>logo.jpg" alt="<?php if(isset($siteVariableValueArr[9]) && $siteVariableValueArr[9] !=""){echo $siteVariableValueArr[9];}?>" /></a></div>
<div id="menu">
    <ul>
		<?php
        if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] != "") {
            if(isset($_SESSION['ses_user_home']) && $_SESSION['ses_user_home'] != "") {
                if($_SESSION['ses_user_home'] == SITE_URL."owner-home") {
                    $help_page 	= SITE_URL."owner-help";
                    $fav_page 	= SITE_URL."owner-favourities";
                    $ads_page 	= SITE_URL."add-a-property";
                } else {
                    $help_page = SITE_URL."help";
                    $fav_page = SITE_URL."favourities";
                    $ads_page 	= SITE_URL."holiday-register-as-owner";
                }
                echo '<li style="padding:10px 10px 0px 0px; color:#009bd4; font-weight:bold;">Welcome '.$_SESSION["ses_user_fname"].'</li>';
                echo '<li><a href="'.$_SESSION["ses_user_home"].'" title="my account">'.ucwords(tranText('home')).'</a></li>';
                echo '<li><a href="'.SITE_URL.'logout">Logout</a></li>';
            } else {
                echo '<li style="padding:10px 10px 0px 0px; color:#009bd4; font-weight:bold;">Welcome '.$_SESSION["ses_user_fname"].'</li>';
                echo '<li><a href="'.$_SESSION["ses_user_home"].'" title="my account">'.ucwords(tranText('home')).'</a></li>';
                echo '<li><a href="'.SITE_URL.'logout">Logout</a></li>';
            }
		} else {
			echo '<li><a href="'.SITE_URL.'vacation-rentals">'.tranText('vacation_rentals').'</a></li>';
			echo '<li><a href="'.SITE_URL.'login">'.tranText('traveler_login').'</a></li>';
			echo '<li><a href="'.SITE_URL.'owner-login">'.tranText('owner_login').'</a></li>';
			echo '<li><a href="'.SITE_URL.'list-your-property" class="current1">'.tranText('list_your_property').'</a></li>';
        }
        ?>
    </ul>
</div>
