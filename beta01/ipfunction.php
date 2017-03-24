<?php
function getIPCountry(){
	if (getenv(HTTP_X_FORWARDED_FOR)) {
		$addr = getenv(HTTP_X_FORWARDED_FOR);
	} else {
		$addr = getenv(REMOTE_ADDR);
	}

	$ip = sprintf("%010u", ip2long($addr));

	// Open the csv file for reading
	$handle = fopen("IpToCountry.csv", "r");
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
	
/*
	echo "ipstart = " . sprintf("%010u", $ipdata[0]) . "<br />\n";
	echo "ipend = " . sprintf("%010u", $ipdata[1]) . "<br />\n";
	echo "registry = " . $ipdata[2] . "<br />\n";
	echo "assigned = " . date('j.n.Y', $ipdata[3]) . "<br />\n";
	echo "iso2 = " . $ipdata[4] . "<br />\n";
	echo "iso3 = " . $ipdata[5] . "<br />\n";
	echo "country = " . $ipdata[6] . "<br /><br />\n";
*/
	// Close the csv file
	fclose($handle);
	return $ipdata[5];
}

?>
