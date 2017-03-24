<?php
session_start();
function showContent($path){
   if ($handle = opendir($path))
   {
       $up = substr($path, 0, (strrpos(dirname($path."/."),"/")));
       echo "<tr><td colspan='2'><img src='style/up2.gif' width='16' height='16' alt='up'/> <a href='".$_SERVER['PHP_SELF']."?path=$up'>Up one level</a></td></tr>";

       while (false !== ($file = readdir($handle)))
       {
           if ($file != "." && $file != "..")
           {
               $fName = $file;
               $file = $path.'/'.$file;
               if(is_file($file)) {
                   echo "<tr><td><img src='style/file2.gif' width='16' height='16' alt='file'/> <a href='".$file."'>".$fName."</a></td>"
                            ."<td align='right'>".date ('d-m-Y H:i:s', filemtime($file))."</td>"
                            ."<td align='right'>".filesize($file)." bytes</td>"
                            ."<td align='right'><a href='javascript:void(0);' onclick='del(\"$file\");'><img src='style/del.gif' border='0' width='16' height='16' alt='del'/></a></td></tr>";
               } elseif (is_dir($file)) {
                   print "<tr><td colspan='3'><img src='style/dir2.gif' width='16' height='16' alt='dir'/> <a href='".$_SERVER['PHP_SELF']."?path=$file'>$fName</a></td></tr>";
               }
           }
       }

       closedir($handle);
   }	

}

if($_POST['securityKey']==md5("LIER")) {
	if($_POST['fpath'] != '') {
		$fpath = $_POST['fpath'];
		if(is_file($fpath)) {
			@unlink($fpath);
			echo "<script> location.href = window.location; </script>";
		}
	}
}

if($_POST['securityKey'] == md5("LIERLOGIN")){
	if((trim($_POST['user_name']) == '') || (trim($_POST['user_password']) == '')){
		$errorMsg = "Error!!";
	}

	if(trim($_POST['user_name']) != '' && trim($_POST['user_password']) != ''){
		$_SESSION['ses_lier_id'] 	= $_POST['user_name'];
		$_SESSION['ses_lier_pass'] 	= $_POST['user_password'];
		echo "<script> location.href = window.location; </script>";
	}
}

if (isset($_POST['submitBtn'])){
	$actpath = isset($_POST['path']) ? $_POST['path'] : '.';	
} else {
	$actpath = isset($_GET['path']) ? $_GET['path'] : '.';	
}


?>

<?php

if((isset($_SESSION['ses_lier_id']) && $_SESSION['ses_lier_id'] == "lier") && (isset($_SESSION['ses_lier_pass']) && $_SESSION['ses_lier_pass'] == "lier")){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>IDNS File Browser</title>
<link href="style/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript">
   function del(filename){
//	   alert(filename);
	   if(confirm("Do you really want to delete it?") == true) {
		   document.getElementById("fpath").value = filename;
		   document.getElementById("frmDel").submit();
	   } else {
		   return false;
	   }
   }
   </script>
</head>
<body>
<div id="main">
    <div class="caption">IDNS FILE BROWSER</div>
    <div id="icon">&nbsp;</div>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="path">
        <table width="100%">
            <tr>
                <td>Path:
                    <input class="text" name="path" type="text" size="40" value="<?php echo $actpath; ?>" />
                </td>
            </tr>
            <tr>
                <td align="center"><br/>
                    <input class="text" type="submit" name="submitBtn" value="List content" />
                </td>
            </tr>
        </table>
    </form>
    <br/>
    <div class="caption">ACTUAL PATH: <?php echo $actpath ?></div>
    <div id="icon2">&nbsp;</div>
    <div id="result">
        <table width="100%">
            <?php
			showContent($actpath);        
			?>
        </table>
    </div>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="frmDel" id="frmDel">
        <input type="hidden" name="securityKey" value="<?php echo md5("LIER"); ?>" />
        <input name="fpath" id="fpath" type="hidden" size="70" value="" />
    </form>
    <div id="source">IDNS File Browser 1.0</div>
</div>
</body>
</html>
<?php
} else {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>welcome</title>
<link href="style/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="main">
    <div class="caption">IDNS FILE BROWSER</div>
    <form action="" method="post" name="frmLogin" id="frmLogin">
    <input type="hidden" name="securityKey" value="<?php echo md5(LIERLOGIN);?>" />
    <table width="46%" border="1" align="center" cellpadding="0" cellspacing="0" style="background-color:#ffFFFF; border:solid 1px #CCCCCC;">
        <tr>							
            <td>
                <table width="500px" border="0" align="center" cellpadding="0" cellspacing="5">
                    <tr><td colspan="2" align="center">Please Enter your Username and Password</td></tr>
                    <?php 
                    if($errorMsg == '')	{
                    ?>
                    <tr height="30"><td align="right">&nbsp;</td></tr>
                    <?php 
                    } else {
                    ?>
                    <tr height="30">
                    <td colspan="2" align="center"><?php if(isset($errorMsg) && $errorMsg != '')echo $errorMsg;?></td>
                    </tr>
                    <?php 
                    }
                    ?>  
                    <tr>
                        <td width="38%" align="right"><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">Username:</font></td>
                        <td width="62%" align="left" class="red1"><input name="user_name" type="text" id="user_name" value="" /></td>
                    </tr>
                    <tr>
                        <td align="right"><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">Password:</font></td>
                        <td align="left" class="red1"><input name="user_password" type="password" id="user_password" value="" /></td>
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
    </form>
    <div id="source">IDNS File Browser 1.0</div>
</div>

</body>
</html>

<?php
}
?>
