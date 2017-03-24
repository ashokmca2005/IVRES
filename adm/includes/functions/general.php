<?php
ob_start();
/*
	//Replaceuieste toate caracterele care nu-s litere sau cifre cu "_"  	
	// Added on : 11 Jun, 2008
	function replace_NonAlphaNumChars($string) {
		$string = preg_replace('/[^a-z0-9]/i', '-', $string);
		$string = preg_replace('/[-]+/', '-', $string);
		return $string;
	}	
*/

	#Replaceuieste toate caracterele care nu-s litere sau cifre cu "_"  	
	// Added on : 09 Oct, 2008
	function replace_NonAlphaNumChars($string, $table = FALSE, $field_id = FALSE, $value_id = FALSE, $column = FALSE) {
		
		$string = preg_replace('/[^a-z0-9]/i', '-', $string);
		$string = preg_replace('/[-]+/', '-', $string);
		
		if ($table and $field_id and $value_id and $column) {
		    $string .= "-".$value_id;
		}
		return $string;
	}	

	/*
	* Function to generate new password: Start here
	*/
	function generatePassword ($length = 8) {
		// start with a blank password
		$password = "";
		// define possible characters
		$possible = "0123456789bcdfghjkmnpqrstvwxyz"; 
		// set up a counter
		$i = 0; 
		// add random characters to $password until $length is reached
		while ($i < $length) { 
			// pick a random character from the possible ones
			$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
			// we don't want this character if it's already in the password
			if (!strstr($password, $char)) { 
				$password .= $char;
				$i++;
			}
		}
		// done!
		return $password;
	}
	/*
	* Function to generate new password: End here
	*/

	function getIPCountry() {
		/*
		if (getenv(HTTP_X_FORWARDED_FOR)) {
			$addr = getenv(HTTP_X_FORWARDED_FOR);
		} else {
			$addr = getenv(REMOTE_ADDR);
		}
		
		$ip = sprintf("%010u", ip2long($addr));
		// Open the csv file for reading
		$handle = fopen(SITE_DOC_ROOT."IpToCountry.csv", "r");
		// Load array with start ips
		$row = 1;
	
		while (($buffer = fgets($handle, 4096)) !== FALSE) {
			$array[$row] = $buffer;
			$row++;
		}
	
		// Locate the row with our ip using bisection
		$row_lower = '0';
		$row_upper = $row;
		while (($row_upper - $row_lower) > 1) {
			$row_midpt = (int) (($row_upper + $row_lower) / 2);
			$buffer = $array[$row_midpt];
			$start_ip = sprintf("%010u", substr($buffer, 1, strpos($buffer, ",") - 1));
			if ($ip >= $start_ip) {
				$row_lower = $row_midpt;
			} else {
				$row_upper = $row_midpt;
			}
		}
		
		// Read the row with our ip
		$buffer = $array[$row_lower];
		$buffer = str_replace("\"", "", $buffer);
		$ipdata = explode(",", $buffer);
		*/
		
		/*
		echo "ipstart = " . sprintf("%010u", $ipdata[0]) . "<br />\n";
		echo "ipend = " . sprintf("%010u", $ipdata[1]) . "<br />\n";
		echo "registry = " . $ipdata[2] . "<br />\n";
		echo "assigned = " . date('j.n.Y', $ipdata[3]) . "<br />\n";
		echo "iso2 = " . $ipdata[4] . "<br />\n";
		echo "iso3 = " . $ipdata[5] . "<br />\n";
		echo "country = " . $ipdata[6] . "<br /><br />\n";
		// Close the csv file
		fclose($handle);
		//return $ipdata[5];
		*/
		return "USA";
	}

	function getTimeLeft($strUnixDateFrom, $strUnixDateCur) {
		if ($strUnixDateFrom > $strUnixDateCur) {
			$startDate 	= date("Y-m-d H:i:s", $strUnixDateCur);
			$endDate 	= date("Y-m-d H:i:s", $strUnixDateFrom);
			 // exploding everything into seperate variabels
			list($startDateDate, $startDateTime) 		= explode(" ", $startDate);
			list($endDateDate, $endDateTime) 			= explode(" ", $endDate);
	
			list($startYear, $startMonth, $startDay) 	= explode("-", $startDateDate);
			list($endYear, $endMonth, $endDay) 			= explode("-", $endDateDate);
	
			list($startHour, $startMinute, $startSecond)= explode(":", $startDateTime);
			list($endHour, $endMinute, $endSecond) 		= explode(":", $endDateTime);
	
			 // now we can start calculating
			 // difference in seconds
			$secondDiff	= $endSecond - $startSecond;
			if ($startSecond > $endSecond) {
				 // if the difference is negative, we add 60 seconds and increase the starting minute
				$secondDiff += 60;
				$startMinute++;
			}
			$minuteDiff	= $endMinute - $startMinute;
			if ($startMinute > $endMinute) {
				$minuteDiff += 60;
				$startHour++;
			}
			$hourDiff	= $endHour - $startHour;
			if ($startHour > $endHour) {
				$hourDiff += 24;
				$startDay++;
			}
	
			 // days in starting month
			if ($endMonth > $startMonth || $endYear > $startYear) {
				if ($startDay > $endDay) {
					 // amount of days this month has
					$daysThisMonth = date("t", $startDate);
					 // difference in days to the next month
					$dayDiff	= ($daysThisMonth - $startDay) + $endDay;
					 // compensating for the months
					$startMonth++;
				} else {
					$dayDiff = $endDay - $startDay;
				}
			} else {
				$dayDiff = $endDay - $startDay;
			}
			$monthDiff	= $endMonth - $startMonth;
			if ($startMonth > $endMonth) {
				$monthDiff += 12;
				$startYear++;
			}
			$yearDiff	= $endYear - $startYear;
	
	
			 // we know all the differences, so we're outputting that
			if ($yearDiff > 0)
				$strTimeLeft = $yearDiff." yrs";
			elseif ($monthDiff > 0)
				$strTimeLeft = $monthDiff." months";
			elseif ($dayDiff > 0)
				$strTimeLeft = $dayDiff." days";
			elseif ($hourDiff > 0)
				$strTimeLeft = $hourDiff." hrs";
			elseif ($minuteDiff > 0)
				$strTimeLeft = $minuteDiff." mins";
			elseif ($secondDiff > 0)
				$strTimeLeft = $secondDiff." sec";
			else
				$strTimeLeft =  "";
		} else {
			$strTimeLeft =  "";
		}
		return $strTimeLeft;
	}

	function redirectURL($rurl){	
		header("Location: " . $rurl);
		exit;
	}

	/**
	* Remove a value from a array
	* @param string $val
	* @param array $arr
	* @return array $array_remval
	* function array_remval: Start here
	*/
	function array_remval($val, &$arr) {
		$array_remval = $arr;
		for($x=0;$x<count($array_remval);$x++) {
			$i=array_search($val,$array_remval);
			if (is_numeric($i)) {
				$array_temp  	= array_slice($array_remval, 0, $i );
				$array_temp2 	= array_slice($array_remval, $i+1, count($array_remval)-1 );
				$array_remval 	= array_merge($array_temp, $array_temp2);
			}
		}
		return $array_remval;
	}
	/**
	* function array_remval: End here
	*/


	function fun_db_output($str){
		return stripslashes($str);
	}

	function fun_db_input($str){
		$str = trim($str);
		if(!get_magic_quotes_gpc()){
			return addslashes($str);
		}else{
			return $str;
		}
	}
	
	// For translation
	function tranText($txt) {
		global $lang;
		if(isset($lang[$txt]) && $lang[$txt] != "") {
			return $lang[$txt];
		} else {
			return $txt;
		}
	}

	function fun_get_commas_values($str){ // if ,4,2,3,6, will be converted to 4,2,3,6
		$newStr = "";
		$str = trim($str);
		if(str!="" && strlen($str) > 2){
			$newStr = substr($str,1,strlen($str)-2);
		}
		return $newStr;
	}

	function fun_site_date_format($strDate){
		$dateFormat = "";
		if($strDate!=""){
			$dateFormat = date("d M, Y", strtotime($strDate));
		}
		return $dateFormat;
	}
	
	function fun_currency_format($curr=0){
		return number_format($curr, 2);
	}

	function fun_check_date($yyyy, $mm, $dd){
		$dateCode = array();
		if($mm < 1 || $mm > 12){
			$dateCode['code'] = false;
			$dateCode['codemsg'] = "The month date must be between 1 and 12";
			return $dateCode;
		}
		if($dd < 1 || $dd > 31){
			$dateCode['code'] = false;
			$dateCode['codemsg'] = "The day date must be between 1 and 31";
			return $dateCode;
		}
		if($dd==31 && ($mm==4 || $mm==6 || $mm==9 || $mm==11)){
			$dateCode['code'] = false;
			$dateCode['codemsg'] = "The month for your birth date doesn't have 31 days";
			return $dateCode;
		}
		if($mm==2){
			$leapYear = false;
			if($yyyy % 4 == 0 && ($yyyy % 100 != 0 || $yyyy % 400 == 0)){
				$leapYear = true;
			}
			if($dd > 29 || ($dd==29 && !$leapYear)){
				$dateCode['code'] = false;
				$dateCode['codemsg'] = "The month for your birth date doesn't have ".$dd." days";// for year ".$yyyy;
				return $dateCode;
			}
		}
		$dateCode['code'] = true;
		$dateCode['codemsg'] = "";
		return $dateCode;
	}
	function fun_create_number_options($startVal=0, $endVal=0, $selVal=''){
		$selected = "";
		for($i=$startVal; $i <= $endVal; $i++){
			if($i == $selVal && $selVal!=''){
				$selected = " selected";
			}else{
				$selected = "";
			}
			echo "<option value=\"".$i."\" ".$selected.">" . $i . "</option>\n";
		}
	}
	function fun_created_month_option($selVal=''){
		$monthsArray = array();
		$monthsArray['1'] = "January";
		$monthsArray['2'] = "February";
		$monthsArray['3'] = "March";
		$monthsArray['4'] = "April";
		$monthsArray['5'] = "May";
		$monthsArray['6'] = "June";
		$monthsArray['7'] = "July";
		$monthsArray['8'] = "August";
		$monthsArray['9'] = "September";
		$monthsArray['10'] = "October";
		$monthsArray['11'] = "November";
		$monthsArray['12'] = "December";
		foreach($monthsArray as $keys => $vals){
			if($keys == $selVal){
				$selected = " selected";
			}else{
				$selected = "";
			}
			echo "<option value=\"".$keys."\" ".$selected.">" . $vals . "</option>\n";
		}
	}
	
	function fun_getFileContent($fileName){
		$fileContent = "";
		
		$fp = fopen($fileName, "r");
		if($fp){
			$fileContent = fread($fp, filesize($fileName));
		}
		fclose($fp);
		return $fileContent;
	}
	
	function trimBodyText($theText, $lmt=70, $s_chr="\n", $s_cnt=1){
		  $pos = 0;
		  $trimmed = FALSE;
		  for($i=0; $i <= $s_cnt; $i++){
			  if($tmp = strpos($theText, $s_chr, $pos)){
				  $pos = $tmp;
				  $trimmed = TRUE;
			  }else{
				  $pos = strlen($theText);
				  $trimmed = FALSE;
				  break;
			  }
		  }
		  $theText = substr($theText, 0, $pos);
		  if(strlen($theText) > $lmt){
			  $theText = substr($theText, 0, $lmt);
			  $theText = substr($theText, 0, strrpos($theText, ' '));
			  $trimmed = TRUE;
		  }
		  if($trimmed){
			  $theText .= "...";
		  }
		  return $theText;
	  }
	
	/*
	* Function to add zero as pre-fixes and make it at certain length: Start here
	*/

	function fill_zero_left($string , $padchar , $int ) {
		$i = strlen ( $string ) + $int;
		$str = str_pad ( $string , $i , $padchar , STR_PAD_LEFT );
		return $str;
	}
	//echo fill_zero_left( $str , "0" , (6-strlen($str))); // Produces: 00test

	/*
	* Function to add zero as pre-fixes and make it at certain length: End here
	*/

	/*
	* Function to remove zero as pre-fixes and make it integer: Start here
	*/

	function remove_zero_left($string , $padchar) {
		$str = strrev($string);
		do {
			if(substr($str, (strlen($str)-1), strlen($str)) == $padchar) {
				$str = substr($str, 0, (strlen($str)-1));
			}
		} while (substr($str, (strlen($str)-1), strlen($str)) == $padchar);
		return strrev($str);
	}
	//echo fill_zero_left( $str , "0" , (6-strlen($str))); // Produces: 00test

	/*
	* Function to remove zero as pre-fixes and make it integer: End here
	*/

	/*
	* Function to check Existence of Url: Start here
	*/
	function url_exists($url) {
		$url = str_replace("http://", "", $url);
		if (strstr($url, "/")) {
			$url = explode("/", $url, 2);
			$url[1] = "/".$url[1];
		} else {
			$url = array($url, "/");
		}
		$fh = fsockopen($url[0], 80);
		if ($fh) {
			fputs($fh,"GET ".$url[1]." HTTP/1.1\nHost:".$url[0]."\n\n");
			if (fread($fh, 22) == "HTTP/1.1 404 Not Found") {
				return FALSE;
			} else {
				return TRUE;
			}
		} else {
			return FALSE;
		}
	}
	/*
	* Function to check Existence of Url: End here
	*/

	function url_encrypt($string, $key) {
		$result = '';
		for($i=0; $i < strlen($string); $i++) {
			$char 		= substr($string, $i, 1);
			if(isset($key) && $key != "") {
				$keychar 	= substr($key, ($i % strlen($key))-1, 1);
				$char 		= chr(ord($char)+ord($keychar));
			} else {
				$char 		= chr(ord($char));
			}
			$result.=$char;
		}
		return base64_encode($result);
	}
	
	function url_decrypt($string, $key) {
		$result = '';
		$string = base64_decode($string);
		for($i=0; $i<strlen($string); $i++) {
			$char = substr($string, $i, 1);
			if(isset($key) && $key != "") {
				$keychar 	= substr($key, ($i % strlen($key))-1, 1);
				$char 		= chr(ord($char)-ord($keychar));
			} else {
				$char 		= chr(ord($char));
			}
			$result.=$char;
		}
		return $result;
	}

	// Check if the file exists
	// Check in subfolders too
	function find_file ($dirname, $fname, &$file_path) {
		$dir = opendir($dirname);
		while ($file = readdir($dir)) {
			if (empty($file_path) && $file != '.' && $file != '..') {
				if (is_dir($dirname.'/'.$file)) {
					find_file($dirname.'/'.$file, $fname, $file_path);
				} else {
					if (file_exists($dirname.'/'.$fname)) {
						$file_path = $dirname.'/'.$fname;
						return;
					}
				}
			}
		}
	} // find_file

	function scan_directory_file_by_type($directory, $filetype = 'jpg') {
		// if the path has a slash at the end we remove it here
		if(substr($directory,-1) == '/') {
			$directory = substr($directory,0,-1);
		}
		// if the path is not valid or is not a directory ...
		if(!file_exists($directory) || !is_dir($directory)) {
			// ... we return false and exit the function
			return FALSE;
		// ... else if the path is readable
		} elseif(is_readable($directory)) {
			// we open the directory
			$directory_list = opendir($directory);
			// and scan through the items inside
			while (FALSE !== ($file = readdir($directory_list))) {
				// if the filepointer is not the current directory
				// or the parent directory
				if($file != '.' && $file != '..') {
					// if the path is readable
					if(is_file($directory."/".$file)) {
						if(isset($filetype) && $filetype != "") {
							$extn 	= split("\.",$file);
							if($filetype == $extn[1])
								$directory_file_list[] = $file;
						} else {
							$directory_file_list[] = $file;
						}
					}
				}
			}
			
			// close the directory
			closedir($directory_list);
			return $directory_file_list;
		// if the path is not readable ...
		} else {
			// ... we return false
			return FALSE;	
		}
	}


	function createDateRangeArray($start, $end) {
		$range = array();
		if(is_string($start) === true) $start = strtotime($start);
		if(is_string($end) === true ) $end = strtotime($end);
		
		if($start>$end) return createDateRangeArray($end, $start);
		
		do{
			$range[] = date('Y-m-d', $start);
			$start = strtotime("+ 1 day", $start);
		} while($start < $end);
		return $range;
	}

	function createDateRangeArrayJs($start, $end) {
		$range = array();
		if(is_string($start) === true) $start = strtotime($start);
		if(is_string($end) === true ) $end = strtotime($end);
		
		if($start>$end) return createDateRangeArray($end, $start);
		
		do{
			$range[] = date('n-j-Y', $start);
			$start = strtotime("+ 1 day", $start);
		} while($start <= $end);
		return $range;
	}

?>