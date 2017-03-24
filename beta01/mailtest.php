<?php
	// Mail to customer.
	$subject1 		= $_SERVER['HTTP_HOST'].' - mail test';
	$to1 			= "ashokmca2005@gmail.com";    //  customer email
	$emailHeaders1 	= "";
	$emailHeaders1 .= "From: info@rentownersvillas.com";
	$emailHeaders1 .= "\nMIME-Version: 1.0\n";
	$emailHeaders1 .= "X-Mailer: PHP 4.x\n";
	$emailHeaders1 .= "Content-type: text/html; charset=iso-8859-1 \n";
	$emailHeaders1 .= "Content-Transfer-Encoding: 7bit";

	$body1 = "This is a test mail";
	$body1 .= "Hello";

	$test = mail($to1, $subject1, $body1, $emailHeaders1);
	if($test == false) {
		echo "Mail not sent!";
	} else {
		echo "Mail sent!";
	}

?>