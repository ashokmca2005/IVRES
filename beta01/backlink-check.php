<?php
require_once("adm/includes/common.php");
require_once("adm/includes/database-table.php");
require_once("adm/includes/classes/class.DB.php");
require_once("adm/includes/classes/class.Email.php");
require_once("adm/includes/functions/general.php");

$dbObj = new DB();
$dbObj->fun_db_connect();

//Step I: get backlinks array
$property_not_in = "12,16,18,20,22,23,24,27,29";
$sql 	= "SELECT 	* FROM " . TABLE_PROPERTY_BACKLINK_RELATIONS . " WHERE status='2' AND backlink !='' AND property_id NOT IN (".$property_not_in.") ";
$rs 	= $dbObj->createRecordset($sql);
if($dbObj->getRecordCount($rs) > 0) {
	$arr = $dbObj->fetchAssoc($rs);
	for($i=0; $i < count($arr); $i++) {
		$id 			= $arr[$i]['id'];
		$property_id 	= $arr[$i]['property_id'];
		$backlink 		= $arr[$i]['backlink'];
		$backlinkcode 	= $arr[$i]['backlinkcode'];
		$crawldate 		= $arr[$i]['crawldate'];
		$crawlfailed 	= $arr[$i]['crawlfailed'];
		$status 		= $arr[$i]['status'];
		$cur_time 		= date("Y-m-d H:i:s");
		
		//Step II: check backlink on owner website and update 
		if(isset($backlink) && $backlink !="") {
			// make the cURL request to $backlink
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_USERAGENT, 'Firefox (WindowsXP) - Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6');
			curl_setopt($ch, CURLOPT_URL,$backlink);
			curl_setopt($ch, CURLOPT_FAILONERROR, true);
			curl_setopt($ch, CURLOPT_AUTOREFERER, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			$html= curl_exec($ch);
			if (!$html) {
				//echo "crawl error!<br>";
				//die();
				$dbObj->updateField(TABLE_PROPERTY_BACKLINK_RELATIONS, "id", $id, "crawldate", $cur_time);
				$crawlfailed = $dbObj->getField(TABLE_PROPERTY_BACKLINK_RELATIONS, "id", $id, "crawlfailed");
				$dbObj->updateField(TABLE_PROPERTY_BACKLINK_RELATIONS, "id", $id, "crawlfailed", ($crawlfailed+1));

				//Step III: if  crawlfailed==3 or crawlfailed>4 suspend property
				$crawlfailed = $dbObj->getField(TABLE_PROPERTY_BACKLINK_RELATIONS, "id", $id, "crawlfailed");
				if($crawlfailed >=3) {
					$dbObj->updateField(TABLE_PROPERTY_BACKLINK_RELATIONS, "id", $id, "status", "4");
					$dbObj->updateField(TABLE_PROPERTY, "property_id", $property_id, "status", "4");
					$dbObj->updateField(TABLE_PROPERTY, "property_id", $property_id, "active", "0");
					//Step IV: send email to homeowner
					$owner_id 		= $dbObj->getField(TABLE_PROPERTY_OWNER_RELATIONS, "property_id", $property_id, "owner_id");
					$owner_email 	= $dbObj->getField(TABLE_USERS, "user_id", $owner_id, "user_email");
					$sub 			= 'Property (ref.'.fill_zero_left($property_id, "0", (6-strlen($property_id))).') has been deactivated';
$msg = '<table width="600"  border="0" cellspacing="10" cellpadding="0">';
$msg .= '<tr><td align="left"><a href="'.SITE_URL.'"><img src="'.SITE_URL.'images/logo.jpg" border="0"></a></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;Dear Homeowner,</td></tr>
<tr><td>Your property (ref.'.fill_zero_left($property_id, "0", (6-strlen($property_id))).') has been deactivated due to following issues:</td></tr>
<tr><td style="color:#ff0000;"><strong>Error:</strong> Property activation backlinkcode not found here - '.$backlink.'</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>If you think this is done by mistake, please send us correct backlink url with your property ref. no. and we will fix this issue at our end.</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>If you have any other problems please <a href="'.SITE_URL.'contact-us" style="font-family: Arial, Helvetica, sans-serif; color: #357bdc; font-size: 12px; font-weight: normal; text-decoration:none;">contact us</a> and we\'ll do our best to help.</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>Thanks,</td></tr>
<tr><td>rentownersvillas.com team</td></tr>
</table>';
					$emailObj = new Email($owner_email, "Manager | rentownersvillas.com <".SITE_ADMIN_EMAIL.">", $sub, $msg);
					if($emailObj->sendEmail()) {
						return true;
					}
				}
				exit;
			}
			curl_close($ch); 
			// parse the html into a DOMDocument  
			$dom = new DOMDocument();
			@$dom->loadHTML($html);
			$strHTML 	= $dom->saveHTML();
			//$pos 		= strpos(htmlentities($strHTML), "www.rentownersvillas.com");
			$pos = strpos($strHTML, $_SERVER["SERVER_NAME"]);
			if($pos !== false) {
				$dbObj->updateField(TABLE_PROPERTY_BACKLINK_RELATIONS, "id", $id, "crawldate", $cur_time);
				$dbObj->updateField(TABLE_PROPERTY_BACKLINK_RELATIONS, "id", $id, "crawlfailed", "0");
				//$dbObj->updateField(TABLE_PROPERTY_BACKLINK_RELATIONS, "id", $id, "status", "2");
				exit;
			} else {
				$dbObj->updateField(TABLE_PROPERTY_BACKLINK_RELATIONS, "id", $id, "crawldate", $cur_time);
				$crawlfailed = $dbObj->getField(TABLE_PROPERTY_BACKLINK_RELATIONS, "id", $id, "crawlfailed");
				$dbObj->updateField(TABLE_PROPERTY_BACKLINK_RELATIONS, "id", $id, "crawlfailed", ($crawlfailed+1));
				//Step III: if  crawlfailed==3 or crawlfailed>4 suspend property
				$crawlfailed = $dbObj->getField(TABLE_PROPERTY_BACKLINK_RELATIONS, "id", $id, "crawlfailed");
				if($crawlfailed >= 3) {
					$dbObj->updateField(TABLE_PROPERTY_BACKLINK_RELATIONS, "id", $id, "status", "4");
					$dbObj->updateField(TABLE_PROPERTY, "property_id", $property_id, "status", "4");
					$dbObj->updateField(TABLE_PROPERTY, "property_id", $property_id, "active", "0");
					//Step IV: send email to homeowner
					$owner_id 		= $dbObj->getField(TABLE_PROPERTY_OWNER_RELATIONS, "property_id", $property_id, "owner_id");
					$owner_email 	= $dbObj->getField(TABLE_USERS, "user_id", $owner_id, "user_email");
					$sub 			= 'Property (ref.'.fill_zero_left($property_id, "0", (6-strlen($property_id))).') has been deactivated';
$msg = '<table width="600"  border="0" cellspacing="10" cellpadding="0">';
$msg .= '<tr><td align="left"><a href="'.SITE_URL.'"><img src="'.SITE_URL.'images/logo.jpg" border="0"></a></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;Dear Homeowner,</td></tr>
<tr><td>Your property (ref.'.fill_zero_left($property_id, "0", (6-strlen($property_id))).') has been deactivated due to following issues:</td></tr>
<tr><td style="color:#ff0000;"><strong>Error:</strong> Property activation backlinkcode not found here - '.$backlink.'</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>If you think this is done by mistake, please send us correct backlink url with your property ref. no. and we will fix this issue at our end.</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>If you have any other problems please <a href="'.SITE_URL.'contact-us" style="font-family: Arial, Helvetica, sans-serif; color: #357bdc; font-size: 12px; font-weight: normal; text-decoration:none;">contact us</a> and we\'ll do our best to help.</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>Thanks,</td></tr>
<tr><td>rentownersvillas.com team</td></tr>
</table>';
					$emailObj = new Email($owner_email, "Manager | rentownersvillas.com <".SITE_ADMIN_EMAIL.">", $sub, $msg);
					if($emailObj->sendEmail()) {
						return true;
					}
				}
				exit;
			}
		}
		sleep(5);
	}
}
?>