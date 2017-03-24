<?php
require_once("adm/includes/common.php");
require_once("adm/includes/database-table.php");
require_once("adm/includes/classes/class.DB.php");
require_once("adm/includes/functions/general.php");

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
//ini_set('error_reporting', E_ALL);

$file = "http://www.ecb.int/stats/eurofxref/eurofxref-daily.xml";
function startElement($parser, $name, $attrs) 
{
	$dbObj = new DB();
	$dbObj->fun_db_connect();

	if($name == "CUBE" && ($attrs['CURRENCY'] == "USD" || $attrs['CURRENCY'] == "GBP" || $attrs['CURRENCY'] == "EUR")){

	if($attrs['CURRENCY'] == "USD"){
		$curUSD = $attrs['RATE'];
		//1 EURO = $curUSD
		$curEUR = (1/$curUSD);
		// update american dollar
		$strUpdateQuery = "UPDATE ".TABLE_CURRENCIES." SET currency_rate='1', updated_on = UNIX_TIMESTAMP(NOW()) WHERE currency_code = 'USD'";
		$dbObj->mySqlSafeQuery($strUpdateQuery);

		// update EURO
		$strUpdateQuery = "UPDATE ".TABLE_CURRENCIES." SET currency_rate='".$curEUR."', updated_on = UNIX_TIMESTAMP(NOW()) WHERE currency_code = 'EUR'";
		$dbObj->mySqlSafeQuery($strUpdateQuery);
	} else if($attrs['CURRENCY'] == "GBP"){
			$curEUR = $dbObj->getField(TABLE_CURRENCIES, "currency_code", "EUR", "currency_rate");
			$curGBP = ($attrs['RATE']*$curEUR);
			// update GBP
			$strUpdateQuery = "UPDATE ".TABLE_CURRENCIES." SET currency_rate='".$curGBP."', updated_on = UNIX_TIMESTAMP(NOW()) WHERE currency_code = 'GBP'";
			$dbObj->mySqlSafeQuery($strUpdateQuery);
		}
	}
}

function endElement($parser, $name) 
{
	// Do Nothing
}

function format_error ($p){ 
	$code 	= xml_get_error_code($p); 
	$str 	= xml_error_string($code); 
	$line 	= xml_get_current_line_number ($p); 
	return "XML ERROR ($code): $str at line $line"; 
}

$xml_parser = xml_parser_create();
xml_set_element_handler($xml_parser, "startElement", " ");
$fp = fopen($file, "r");
while ($data = fread($fp, 4096)) {
    xml_parse($xml_parser, $data, feof($fp)) or die( format_error($xml_parser));
}
xml_parser_free($xml_parser);
?>