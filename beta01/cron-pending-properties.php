<?php
	require_once("adm/includes/common.php");
	require_once("adm/includes/database-table.php");
	require_once("adm/includes/classes/class.DB.php");
	require_once("adm/includes/functions/general.php");

	$dbObj = new DB();
	$dbObj->fun_db_connect();

	$mailArray 			= array();
	$properpty_status 	= 1;
	$user_not_in 		= "1,9,19,22,25,30,31,32,43,48";
	$sql 				= "SELECT `user_email` FROM " . TABLE_USERS . " WHERE `user_id` IN (SELECT DISTINCT owner_id AS user_id FROM  " . TABLE_PROPERTY_OWNER_RELATIONS . " WHERE `property_id` IN (SELECT property_id FROM " . TABLE_PROPERTY . "  WHERE status='". $properpty_status ."')) AND `user_id` NOT IN (".$user_not_in.") ";
	$rs 				= $dbObj->createRecordset($sql);
	if($dbObj->getRecordCount($rs) > 0){
		$arr 			= $dbObj->fetchAssoc($rs);
		foreach($arr as $key=>$value) {
			array_push($mailArray, $value['user_email']);
		}
	}

	//print_r($mailArray);

	$emailHeaders = "";
	$emailHeaders .= "From: Administrator | rentownersvillas.com <admin@rentownersvillas.com>\n";
	//$emailHeaders .= "Cc: bestbookingsonline@gmail.com\n";
	$emailHeaders .= "Reply-to: admin@rentownersvillas.com\n";
	$emailHeaders .= "Bcc: admin@rentownersvillas.com\n";
	$emailHeaders .= "MIME-Version: 1.0\n";
	$emailHeaders .= "X-Mailer: PHP 4.x\n";
	$emailHeaders .= "Content-type: text/html; charset=iso-8859-1 \n";
	$emailHeaders .= "Content-Transfer-Encoding: 7bit";

	//$emailFrom 	= "Administrator BestBookingsOnline.com <admin@rentownersvillas.com>";
	$txtSubject = "Action required to approve your property listing";

$msg ='<table width="600px"  border="0" cellspacing="10" cellpadding="0"><tr><td>&nbsp;</td></tr><tr><td style="padding:5px; color:#0000ff;">';
$msg .='<p>Dear Homeowner,<br /><br />Hope you are doing well!<br /><br /></p>
<P>In order to approve your property listing, following actions are required from your side:</p>
<p>
- Add/Edit Property Details<br />
- Add/Edit Property Photos<br />
- Add/Edit Property Location Details<br />
- Add/Edit Property Rates Details<br />
- Add/Edit Property Availability Details<br />
- Add/Edit Property Contact Details<br />
- Activate property<br />
</p>
<p style="color:#ff0000;">Owner Login URL: <a href="http://www.rentownersvillas.com/owner-login">http://www.rentownersvillas.com/owner-login</a></p>
<p>If you have any query, feel free to contact us ...<br /></p>
<P>Best Regards<br />Administrator, rentownersvillas.com</P>
<P>&nbsp;</P>';
$msg .='</td></tr></table>';
$msg .='<em>Note: Share your property links among your customers & friends to get more chance to book your property soon...</em>';

for($i = 0; $i < count($mailArray); $i++) {
	$emailTo 	= strtolower($mailArray[$i]);
	$mailtest = mail($emailTo, $txtSubject, $msg, $emailHeaders);
	if($mailtest == true){
		echo $i.": mail sent<br>";
	}else{
		echo $i.": failed<br>";
	}
}

$emailTo 	= "ashokmca2005@gmail.com";
$mailtest 	= mail($emailTo, $txtSubject, $msg, $emailHeaders);
if($mailtest == true){
	echo "mail sent";
}else{
	echo "failed";
}
?>