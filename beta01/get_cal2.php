<?php
	if($_SERVER["SERVER_NAME"] == "localhost") {
		require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
	} else {
		require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
	}

	$ct = $_REQUEST['ct'];
	$timestamp = $_REQUEST['timestamp'];
	if($timestamp == "") {
		$timestamp = time();
	}	

	if($_REQUEST['mnt_cal'] != "" && $_REQUEST['day_cal'] != "" && $_REQUEST['yr_cal']) {
		$mnt_cal 	= $_REQUEST['mnt_cal'];
		$day_cal 	= $_REQUEST['day_cal'];
		$yr_cal 	= $_REQUEST['yr_cal'];
		$timestamp 	= mktime(0,0,0,$mnt_cal,$day_cal,$yr_cal);
	} else {
		$mnt_cal = date("m",$timestamp);
		$day_cal = date('d',$timestamp);
		$yr_cal  = date('Y',$timestamp);
	}

	$num_day = Date('t',$timestamp);
	$j = date('w',mktime(0,0,0,$mnt_cal,1,$yr_cal)); // This will calculate the week day of the first day of the month
	
	$next_year_timestamp = $timestamp + (365*24*60*60);
	$pre_year_timestamp  = $timestamp - (365*24*60*60);

	$next_timestamp = $timestamp + ($num_day * 24*60*60);
	$pre_timestamp = $timestamp - ($num_day * 24*60*60);
		
	for($k=1; $k<=$j; $k++){ // Adjustment of date starting
		$adj .="<td style='border:1px solid #AEAEAE;'>&nbsp;</td>";
	}
	if(($num_day+$j) > 35) {
		for($l=1; $l<=(42-($num_day+$j)); $l++){ // Adjustment of date starting
			$adj2 .="<td style='border:1px solid #AEAEAE;'>&nbsp;</td>";
		}
	} else {
		for($l=1; $l<=(35-($num_day+$j)); $l++){ // Adjustment of date starting
			$adj2 .="<td style='border:1px solid #AEAEAE;'>&nbsp;</td>";
		}
	}

	$calendar1  = "";	
	$calendar1 .= "<iframe frameborder='0' style='position:absolute;top:10px;left:7px;width:206px;height:262px' id='iframe'></iframe>";
	$calendar1 .= "<div style='position:relative; z-index:999;left:0px;width:230px; background:transparent'>";
	$calendar1 .= "<table align='left' border='0' cellpadding='0' cellspacing='0' style='background-color:transparent'>";
	$calendar1 .= "<tr>";
	$calendar1 .= "<td align='right' valign='top' class='leftBg1'></td>";
	$calendar1 .= "<td align='center' valign='top' class='calBg'>";
	$calendar1 .= "<table border='0' cellpadding='0' cellspacing='0' class='vfont12' style='background-color:#FFFFFF'>";
	$calendar1 .= "<tr>";
	$calendar1 .= "<td align='left' class='pad-btm7 pad-top7'><img src='".SITE_URL."images/cal_img/select-a-date.gif' alt='Select date'/></td>";
	$calendar1 .= "<td align='right' valign='top' class='pad-top5'><a href='JavaScript:close_calendar();'><img src='".SITE_URL."images/cal_img/close.gif' alt='Close' border='0'/></a></td>";
	$calendar1 .= "</tr>";
	$calendar1 .= "<tr>";
	$calendar1 .= "<td colspan='2'><table width='180' border='0' cellspacing='0' cellpadding='0'>";
	$calendar1 .= "<tr>";
	$calendar1 .= "<td colspan='3' class='dashvk'><img src='".SITE_URL."images/cal_img/ANP-LftDash.gif' alt='ANP' /></td>";
	$calendar1 .= "</tr>";
	$calendar1 .= "<tr>";
	$calendar1 .= "<td align='left'><a href='JavaScript:find_cal2(\"".$pre_year_timestamp."\", \"".$ct."\")'><img src='".SITE_URL."images/cal_img/arrow-left.gif' alt='One' border='0'/></a></td>";
	$calendar1 .= "<td align='center'>".Date('Y',$timestamp)."</td>";
	$calendar1 .= "<td align='right'><a href='JavaScript:find_cal2(\"".$next_year_timestamp."\", \"".$ct."\")'><img src='".SITE_URL."images/cal_img/gray-arrow-big.gif' alt='One' border='0'/></a></td>";
	$calendar1 .= "</tr>";
	$calendar1 .= "<tr>";
	$calendar1 .= "<td class='dashvk' colspan='3'><img src='".SITE_URL."images/cal_img/ANP-LftDash.gif' alt='ANP' /></td>";
	$calendar1 .= "</tr>";
	$calendar1 .= "<tr>";
	$calendar1 .= "<td align='left'><a href='JavaScript:find_cal2(\"".$pre_timestamp."\",\"".$ct."\")'><img src='".SITE_URL."images/cal_img/arrow-left.gif' alt='One' border='0'/></a></td>";
	$calendar1 .= "<td align='center'>".strtoupper(Date("F",$timestamp))."</td>";
	$calendar1 .= "<td align='right'><a href='JavaScript:find_cal2(\"".$next_timestamp."\",\"".$ct."\")'><img src='".SITE_URL."images/cal_img/gray-arrow-big.gif' alt='One' border='0'/></a></td>";
	$calendar1 .= "</tr>";
	$calendar1 .= "<tr>";
	$calendar1 .= "<td height='6' colspan='3'></td>";
	$calendar1 .= "</tr>";
	$calendar1 .= "<tr>";
	$calendar1 .= "<td colspan='3'></td>";
	$calendar1 .= "</tr>";
	$calendar1 .= "</table></td>";
	$calendar1 .= "</tr>";
	$calendar1 .= "<tr>";
	$calendar1 .= "<td colspan='2'><table width='180' border='0' align='center' cellpadding='0' cellspacing='0' bordercolor='#aeaeae' style='border-collapse:collapse;'  class='calDate'>";
	$calendar1 .= "<tr>";

	////// End of the top line showing name of the days of the week//////////
	//////// Starting of the days//////////
	for($i=1;$i<=$num_day;$i++) {
		if($i == date('d') && $mnt_cal == date('m') && $yr_cal == date('Y')) {
			$bgcolor = "#AEC4DE";
		} else {
			$bgcolor = "#E8E8E8";
		}
		$calendar1 .=$adj;
		$eventDate = $yr_cal."-".$mnt_cal."-".$i;
		$event_t1 = mktime(0,0,0,$mnt_cal,$i,$yr_cal);

		if($mnt_cal >= date('m') && $yr_cal >= date('Y')) {
			$calendar1 .="<td bgcolor = '".$bgcolor."' style='border:1px solid #AEAEAE;' align='right' valign='bottom' ><a href='JavaScript:insert_date(\"".Date("m/d/Y",$event_t1)."\",\"".$ct."\")' style='text-decoration:none;color:#666666'>".$i."</a></td>";
		} else {
			$calendar1 .="<td bgcolor = '".$bgcolor."' style='border:1px solid #AEAEAE;' align='right' valign='bottom'><a href='JavaScript:insert_date(\"".Date("m/d/Y",$event_t1)."\",\"".$ct."\")' style='text-decoration:none;color:#666666'>".$i."</a></td>";
		}			
		$adj='';
		$j++;
		if($j==7) {
			$calendar1 .="</tr><tr>";
			$j=0;
		}
	}	
	$calendar1 .=$adj2;
	$calendar1 .="</tr></table>"."\n";
	$calendar1 .= "</table></td>";
	$calendar1 .= "<td valign='top' class='rightBg1' width='22'></td>";
	$calendar1 .= "</tr>";
	$calendar1 .= "</table>";
	echo $calendar1;
?>