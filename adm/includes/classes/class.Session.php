<?
session_start();
/** 
 * Useful session functions for maintaining separately-scoped sessions
 * $Id: class.Session.php,v 1.0 2008/02/20 19:35:33 Ashok Kumar $
 */
class Session {
	var $prefix;

	function Session($prefix) {
		$this->setPrefix($prefix);
	}
	
	function setPrefix($prefix) {
		$this->prefix = $prefix;
	}
	
	function getPrefix() {
		return $this->prefix;
	}
	
	function save($key, $value) {
		$key = $this->_getSessionKey($key);
		$_SESSION[$key] = $value;
	}
	
	function get($key) {
		$key = $this->_getSessionKey($key);
		if (array_key_exists($key,$_SESSION)) {
			return $_SESSION[$key];
		} else {
			return FALSE;
		}
	}
	
	function clear() {
		foreach (array_keys($_SESSION) as $key) {
			$pos = strpos($key,$this->prefix."_");
			if ($pos !== FALSE && $pos == 0) {
				unset($_SESSION[$key]);
			}
		}
	}
	
	function exists($key) {
		$key = $this->_getSessionKey($key);

		if (array_key_exists($key,$_SESSION)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function _getSessionKey($key) {
		return $this->prefix . "_" . $key;
	}
	
	/** 
	 * Gets a variable from the session, unless submitted by a form,
	 * and returns it 
	 */
	function formOrSession($preg, $key, $default) {
		$formValue = form_preg($preg, $key, FALSE);
		
		if ($formValue === FALSE) {
			$sessionValue = $this->get($key);
			if ($sessionValue === FALSE) {
				return $default;
			} else {
				return $sessionValue;
			}	
		}
		return $formValue;
	}
	
	/** 
	 * Gets a variable from the session, unless submitted by a form
	 * saves it in the session, and returns it
	 */
	 function persist($preg, $key, $default) {
	 	$value = $this->formOrSession($preg,$key,$default);
		$this->save($key,$value);
		return $value;
	 }
	 
     // todo find a better way to do this. this is not intuitive.
}
?>
