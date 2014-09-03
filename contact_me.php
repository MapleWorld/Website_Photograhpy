<?php
if($_POST){

	// ouye@ouye.photography
	// lonely550442072@hotmail.com
	$to_Email   	= "ouye@ouye.photography"; //Replace with recipient email address

	//check if its an ajax request, exit if not
    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
	
		//exit script outputting json data
		$output = json_encode(
		array(
			'type'=>'error', 
			'text' => 'Request must come from Ajax'
		));
		
		die($output);
    } 
	
	//check $_POST vars are set, exit if any missing
	if(!isset($_POST["userName"]) || !isset($_POST["userEmail"]) || !isset($_POST["userSubject"]) || !isset($_POST["userMessage"]))
	{
		$output = json_encode(array('type'=>'error', 'text' => 'Input fields are empty!'));
		die($output);
	}

	//Sanitize input data using PHP filter_var().
	$user_Name    	  = filter_var($_POST["userName"], FILTER_SANITIZE_STRING);
	$user_Email       = filter_var($_POST["userEmail"], FILTER_SANITIZE_EMAIL);
	$user_Subject     = filter_var($_POST["userSubject"], FILTER_SANITIZE_STRING);
	$user_Message     = filter_var($_POST["userMessage"], FILTER_SANITIZE_STRING);
	
	//additional php validation
	if(strlen($user_Name) < 3) { //check emtpy message
		$output = json_encode(array('type'=>'error', 'text' => 'Please enter a valid name!'));
		die($output);
	}
		
	if(!filter_var($user_Email, FILTER_VALIDATE_EMAIL)) { //email validation
		$output = json_encode(array('type'=>'error', 'text' => 'Please enter a valid email!'));
		die($output);
	}
	if(strlen($user_Subject) < 5) { //check emtpy message
		$output = json_encode(array('type'=>'error', 'text' => 'Subject too short! Please enter something.'));
		die($output);
	}
	if(strlen($user_Message) < 5) { //check emtpy message
		$output = json_encode(array('type'=>'error', 'text' => 'Too short message! Please enter something.'));
		die($output);
	}
	
	//proceed with PHP email.
	$headers = 'From: '.$user_Email.'' . "\r\n" .
	'Reply-To: '.$user_Email.'' . "\r\n" .
	'X-Mailer: PHP/' . phpversion();
	
	//relay-hosting.secureserver.net
	//ini_set('SMTP', "localhost");
	//ini_set('smtp_port', "25");
	 
	if(mail($to_Email, $user_Subject, $user_Message .'  -'.$user_Email, $headers)){
		$output = json_encode(array('type'=>'message', 'text' => 'Hi '.$user_Name .',  Thank you for your email'));
		die($output);
	}else{
		$output = json_encode(array('type'=>'error', 'text' => 'Could not send mail! Please check your PHP mail configuration.'));
		die($output);
	}
	
	/*	
	$sentMail = @mail($to_Email, $user_subject, $user_Message .'  -'.$user_Email, $headers);
	
	if(!$sentMail){
		$output = json_encode(array('type'=>'error', 'text' => 'Could not send mail! Please check your PHP mail configuration.'));
		die($output);
	}else{
		$output = json_encode(array('type'=>'message', 'text' => 'Hi '.$user_Name .',  Thank you for your email'));
		die($output);
	}
	*/
}
?>