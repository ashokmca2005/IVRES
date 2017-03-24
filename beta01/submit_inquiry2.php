<?php 
	if(empty($_POST)){
		header('Content-Type: application/json');
		echo json_encode(array('error'=>'Form should not be emtpy'));
		exit();
	}
	
	
	$errors = array();
	$fields_to_validate = array('arrival_date','departure_date','adults','name','email','phone','property_id');
	
	
	foreach($fields_to_validate as $field_to_validate){
		if(!isset($_POST[$field_to_validate]) || $_POST[$field_to_validate]==''){
			$message = str_replace('_',' ',$field_to_validate);
			$message = ucwords($message).' should not be empty';
			$errors[$field_to_validate] = $message;
		}
	}
	
	if(!empty($errors)){
		header('Content-Type: application/json');
		echo json_encode(compact('errors'));
		exit();
	}
	
	$arrival_date 	= $_POST['arrival_date'];
	$departure_date = $_POST['departure_date'];
	$adults 		= $_POST['adults'];
	$children 		= $_POST['children'];
	$property_id 	= $_POST['property_id'];
	$name 			= $_POST['name'];
	$email 			= $_POST['email'];
	$country_code_phone = isset($_POST['country_code_phone'])  ? $_POST['country_code_phone']: '1';
	$phone 			= $_POST['phone'];
	$ip_address 	= $_SERVER['REMOTE_ADDR'];
	$partner_id 	= isset($_POST['partner_id'])  ? $_POST['partner_id']: '';
	$alias 			= isset($_POST['alias'])  ? $_POST['alias']: '';
	$post 			= $_POST;
	
	// for rentalo user updates
	require_once('nusoap/nusoap.php');
	
	//This will be the path when are located the webservices
	$proxy 			= "http://rentalo.com/WebServices/Inquiry";
	//This is the path of the package, relative to the domain
	$uri 			= "http://rentalo.com/Inquiry/InquiryService";
	
	$params 		= array($arrival_date, $departure_date, $adults, $children, $property_id, $name, $email, $country_code_phone, $phone, $ip_address, $partner_id, $alias);
	$client 		= new nusoap_client($proxy);
	$client->setCredentials($user,$pass); 
	$client->soap_defencoding='utf-8';
	$result 		= $client->call('createInquiry', $params, $uri, "$uri#createInquiry");
	if ($client->fault) {
		$response = compact('result');
	} else {
		$err = $client->getError();
		if($err) {
			$response = compact('err','result');
			
		} else {
			$response = compact('result');
			
		}
	}
	$response = compact('result','post');
	
	header('Content-Type: application/json');
	echo json_encode($response);
	exit();
?>