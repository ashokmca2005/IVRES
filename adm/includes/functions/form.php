<?

/**
 * Functions to validate form fields
 * All form field input for the site should be done through these functions, as handling
 * form input directly does not provide assurance that it is what we are expecting.
 * 
 */

 
/** 
 * Tess whether a form field (either GET or POST) has been set
 * 
 * Being 'set' means that a value has been input for the form via
 * GET or POST -- even if that value is 0 or the empty string.  As long
 * as it was part of the query or post, it is considered to be set.
 * 
 * @param	$varname	The name of the form field
 * @returns 	TRUE or FALSE
 */
function form_isset($varname) {
	$value = _form_gp($varname);
	if ($value === FALSE) {
		return FALSE;
	} else {
		return TRUE;
	}
}

function form_getPostedArrayValues($varname) {
	$value = _form_gp($varname);
	if ($value === FALSE) {
		return FALSE;
	} else {
		return $value;
	}
}

/** 
 * Tests whether an image button has been pressed
 */
function form_imgButton($varname) {
    if (form_isset($varname . "_x")) {
        return TRUE;
    } else {
        return FALSE;
    }
}


/** 
 * Uses a column in a table to determine valid form entries
 */
function form_table(&$db, $table, $column, $varname, $default = FALSE) {
	$value = _form_gp($varname);
	if (FALSE !== $db->getField($table,$column,$value,$column)) {
		return $value;
	} else {
		return FALSE;
	}
}


/** 
 * Uses an array to determine valid form entries
 */
function form_array($array,$varname,$default = FALSE) {
	$value = _form_gp($varname);
	if ($value === FALSE) {
		return $default;
	}
	if (in_array($value,$array)) {
		return $value;
	} else {
		return FALSE;
	}
}

// Validates array keys with a column table
// Used to validate arrays generated by checkboxes
function form_CheckBoxesArrayFromTable($table, $column, $varname, $default = FALSE){
    global $db;
	$result = array();
	$value = _form_gp($varname);

	if(!is_array($value)){
		return $default;
	}

	foreach($value as $key => $v){
	  if(FALSE == $db->getField($table,$column, $key, $column)){
	      return $default;
	  }else{
	      // Add keys to result array
	      $result[] = $key;
	  }
	}
	
    return $result;
}

function form_nullstring($varname) {
	$value = _form_gp($varname);
	if ($value === "") {
		return TRUE;
	} else {
		return FALSE;
	}
}

/**
 * Given a variable name, finds it in the GET or POST values and returns it
 *
 * If not present in the GET or POST values, returns FALSE
 * The order of searching GET and POST is undetermined, so don't rely on it 
 * looking for either on first -- i.e. don't use the same variable in both
 * a form and query string
 *
 * This is a private function and should never be called directly outside this file
 */
function _form_gp ($varname) {
	$value = FALSE;
	if (array_key_exists($varname,$_GET)) {
		$value = $_GET[$varname];
	} elseif (array_key_exists($varname,$_POST)) {
		$value = $_POST[$varname];
	}
	return $value;
}

/**
 * Given a GET or POST form field variable name, matches it to a Perl regular expression
 *
 * Returns the value of the form field if a match, otherwise returns the $default
 * $default is FALSE by default
 *
 * The regular expression *MUST* be anchored to the beginning and end
 * i.e. /^...$/.  Perhaps we should include this automatically if not present
 * in the given regular expression, rather than checking for it with another
 * regular expression?  This would be a more efficient way of doing things, but
 * would make the calling code less easy to understand.
 */
 function form_preg($preg, $varname, $default = FALSE) {
 	// Verify that the regular expression is anchored to both ends of the string
 	if (!preg_match("/^\/\^.*\/\w*$/",$preg)) {
		trigger_error("Regular expression ($preg) must be anchored to beginning and end",E_USER_ERROR);
	}
	
	$value = _form_gp($varname);	 
	if (preg_match($preg,$value)) {	
		$result = $value;
	} else {
		$result = $default;
	}
	return($result);
}

/**
 * Given a GET or POST variable name, matches it to a Extended regular expression
 *
 * Returns the value from the GET or POST if a match, otherwise returns the $default
 * $default is FALSE by default
 *
 * The regular expression should be anchored to the beginning and end
 * i.e. ^...$
 */
 function form_ereg($preg, $varname, $default = FALSE) {
	$value = _form_gp($varname);	 
	if ($value === FALSE) {
		return $default;
	}
	if (@ereg($preg,$value)) {	
		$result = $value;
	} else {
		$result = $default;
	}
	return($result);
}

/**
 * Checks if a form variable consists entirely of digits
 *
 * If so, returns the form variable's value, otherwise returns $default
 */
function form_digits($varname, $default = FALSE) {
	return form_preg("/^[0-9]+$/",$varname, $default);
}

/**
 * Checks if a form variable is an integer
 * 
 * @param	$varname	The form variable
 * @param	$default	If it is not an integer, or not between $min and $max, returns this value
 * @param	$min		The minimum allowable value (optional)
 * @param	$max		The maximum allowable value (optional)
 * @returns		If an integer, and between $min and $max if specified, returns the value of the form variable, otherwise returns $default
 */
function form_int($varname, $default = FALSE, $min = FALSE, $max = FALSE) {
	$value = _form_gp($varname);	 
	if ($value === FALSE) {
		return $default;
	}
	if (preg_match("/^-?[0-9]+$/",$value) && 
			($min === FALSE || intval($value) >= $min) && 
			($max === FALSE || intval($value) <= $max)) {	
		return $value;
	} 
	return $default;
}

/**
 * An attempt to allow English paragraph text -- all the regular characters on a keyboard on multiple line
 *
 * This rejects nonprintable characters as well as characters with high unicode values
 * More tests should be done on this function to see exactly what is allowed and what is not
 * and it probably should be replaced with a function that builds an explicit regular expresison
 * consisting of characters allowed in English text.
 */
function form_text($varname,$default = FALSE) {
	// Use ereg for this because it already has a character class encompassing all printable
	// characters.  We want to prevent anyone from submitting any control characters
	return stripslashes(form_ereg("^[[:print:]\n\r\t]*$",stripslashes($varname),$default));
}

/**
 * Checks if a form variable is a valid http:// url
 * 
 * @param	$varname	The form variable
 * @param	$default	If it is not valid, returns this value
 * @returns				If a valid URL, returns the value of the form variable, otherwise returns $default
 */
function form_url($varname, $default = FALSE) {
	$value = _form_gp($varname);	 
	if ($value === FALSE) {
		return $default;
	}
	if (preg_match("/^https?:\/\/([a-z0-9_\%\;\#\:\+\~\.\/\-\,\?\&\=]*)$/i",$value)) {	
		return $value;
	} 
	return $default;
}

function form_fileUploaded($varname, $extensions, $default = FALSE){
	$result = $default;
    $value = $_FILES[$varname];
	if($value["error"] == ""){
	    if(file_hasExtensions($value["name"], $extensions)){
		    $result = $value;
		}
	}
	return $result;
}

function form_email($varname, $default = FALSE) {
	$email_regexp = "/^[a-z0-9\.\-_\+]+@[a-z0-9\-_]+\.([a-z0-9\-_]+\.)*?[a-z]+$/is";
	return form_preg($email_regexp,$varname,$default);
}

/*function form_email($varname, $default = FALSE) {
	$email_regexp = _form_email_regexp();
	return form_preg($email_regexp,$varname,$default);
}*/

/** 
 * Email-matching regular expression
 *
 * PHP translation of Email Regex Program (optimized)
 * Derived from:
 *   Appendix B - Email Regex Program
 *   _Mastering Regular Expressions_ (First Edition, May 1997 revision)
 *     by Jeffrey E.F. Friedl
 *     Copyright 1997 O'Reilly & Associates
 *     ISBN: 1-56592-257-3
 *   For more info on this title, see:
 *     http: *www.oreilly.com/catalog/regex/
 *   For original perl version, see:
 *     http: *examples.oreilly.com/regex/
 *
 * Follows RFC 822 about as close as is possible.
 * http: *www.faqs.org/rfcs/rfc822.html
 *
 *
 * Translated by Clay Loveless <clay@killersoft.com> on March 11, 2002
 * ... in hopes that the "here's how to check an e-mail address!" 
 * discussion can finally end. After all ... 
 *
 *       Friedl is the master -- Hail to the King, baby!
 */

function _form_email_regexp () {

	// Some shortcuts for avoiding backslashitis
	$esc        = '\\\\';               $Period      = '\.';
	$space      = '\040';               $tab         = '\t';
	$OpenBR     = '\[';                 $CloseBR     = '\]';
	$OpenParen  = '\(';                 $CloseParen  = '\)';
	$NonASCII   = '\x80-\xff';          $ctrl        = '\000-\037';
	$CRlist     = '\n\015';  // note: this should really be only \015.

	// Items 19, 20, 21 -- see table on page 295 of 'Mastering Regular Expressions'
	$qtext = "[^$esc$NonASCII$CRlist\"]";				// for within "..."
	$dtext = "[^$esc$NonASCII$CRlist$OpenBR$CloseBR]";	// for within [...]
	$quoted_pair = " $esc [^$NonASCII] ";	// an escaped character

	// *********************************************
	// Items 22 and 23, comment.
	// Impossible to do properly with a regex, I make do by allowing at most 
	// one level of nesting.
	$ctext = " [^$esc$NonASCII$CRlist()] ";
	
	// $Cnested matches one non-nested comment.
	// It is unrolled, with normal of $ctext, special of $quoted_pair.
	$Cnested = "";
		$Cnested .= "$OpenParen";					// (
	    $Cnested .= "$ctext*";						// 	  normal*
	    $Cnested .= "(?: $quoted_pair $ctext* )*";	// 	  (special normal*)*
	    $Cnested .= "$CloseParen";					// 						)
	
	// $comment allows one level of nested parentheses
	// It is unrolled, with normal of $ctext, special of ($quoted_pair|$Cnested)
	$comment = "";
		$comment .= "$OpenParen";						//  (
		$comment .= "$ctext*";							//     normal*
		$comment .= "(?:";								//       (
		$comment .= "(?: $quoted_pair | $Cnested )";	//         special
		$comment .= "$ctext*";							//         normal*
		$comment .= ")*";								//            )*
		$comment .= "$CloseParen";						//                )
		
	// *********************************************
	// $X is optional whitespace/comments
	$X = "";
		$X .= "[$space$tab]*";					// Nab whitespace
		$X .= "(?: $comment [$space$tab]* )*";	// If comment found, allow more spaces
		
		
	// Item 10: atom
	$atom_char = "[^($space)<>\@,;:\".$esc$OpenBR$CloseBR$ctrl$NonASCII]";
	$atom = "";
		$atom .= "$atom_char+";		// some number of atom characters ...
		$atom .= "(?!$atom_char)";	// ... not followed by something that 
									//     could be part of an atom
									
	// Item 11: doublequoted string, unrolled.
	$quoted_str = "";
		$quoted_str .= "\"";							// "
		$quoted_str .= "$qtext *";						//   normal
		$quoted_str .= "(?: $quoted_pair $qtext * )*";	//   ( special normal* )*
		$quoted_str .= "\"";							//        "
	
	
	// Item 7: word is an atom or quoted string
	$word = "";
		$word .= "(?:";
		$word .= "$atom";		// Atom
		$word .= "|";			// or
		$word .= "$quoted_str";	// Quoted string
		$word .= ")";
		
	// Item 12: domain-ref is just an atom
	$domain_ref = $atom;
	
	// Item 13: domain-literal is like a quoted string, but [...] instead of "..."
	$domain_lit = "";
		$domain_lit .= "$OpenBR";						// [
		$domain_lit .= "(?: $dtext | $quoted_pair )*";	//   stuff
		$domain_lit .= "$CloseBR";						//         ]

	// Item 9: sub-domain is a domain-ref or a domain-literal
	$sub_domain = "";
		$sub_domain .= "(?:";
		$sub_domain .= "$domain_ref";
		$sub_domain .= "|";
		$sub_domain .= "$domain_lit";
		$sub_domain .= ")";
		$sub_domain .= "$X"; // optional trailing comments
		
	// Item 6: domain is a list of subdomains separated by dots
	$domain = "";
		$domain .= "$sub_domain";
		$domain .= "(?:";
		$domain .= "$Period $X $sub_domain";
		$domain .= ")*";
		
	// Item 8: a route. A bunch of "@ $domain" separated by commas, followed by a colon.
	$route = "";
		$route .= "\@ $X $domain";
		$route .= "(?: , $X \@ $X $domain )*"; // additional domains
		$route .= ":";
		$route .= "$X"; // optional trailing comments
		
	// Item 5: local-part is a bunch of $word separated by periods
	$local_part = "";
		$local_part .= "$word $X";
		$local_part .= "(?:";
		$local_part .= "$Period $X $word $X"; // additional words
		$local_part .= ")*";
		
	// Item 2: addr-spec is local@domain
	$addr_spec = "$local_part \@ $X $domain";

	// Item 4: route-addr is <route? addr-spec>
	$route_addr = "";
		$route_addr .= "< $X";
		$route_addr .= "(?: $route )?"; // optional route
		$route_addr .= "$addr_spec";	// address spec
		$route_addr .= ">";
		
	// Item 3: phrase........
	$phrase_ctrl = '\000-\010\012-\037'; // like ctrl, but without tab
	
	// Like atom-char, but without listing space, and uses phrase_ctrl.
	// Since the class is negated, this matches the same as atom-char plus space and tab
	$phrase_char = "[^()<>\@,;:\".$esc$OpenBR$CloseBR$NonASCII$phrase_ctrl]";

	// We've worked it so that $word, $comment, and $quoted_str to not consume trailing $X
	// because we take care of it manually.
	$phrase = "";
		$phrase .= "$word";                        	// leading word
		$phrase .= "$phrase_char *";               	// "normal" atoms and/or spaces
		$phrase .= "(?:";
		$phrase .= "(?: $comment | $quoted_str )"; 	// "special" comment or quoted string
		$phrase .= "$phrase_char *";            	//  more "normal"
		$phrase .= ")*";

	// Item 1: mailbox is an addr_spec or a phrase/route_addr
	$mailbox = "";
		$mailbox .= "$X";					// optional leading comment
		$mailbox .= "(?:";
		$mailbox .= "$addr_spec";			// address
		$mailbox .= "|";					// or
		$mailbox .= "$phrase  $route_addr";	// name and address
		$mailbox .= ")";

	// test it and return results
	$regexp = "/^$mailbox$/xS";
	
	return($regexp);
} 


?>
