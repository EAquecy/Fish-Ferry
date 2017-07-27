<?php
$content = file_get_contents('php://input');

$input = json_decode($content);

require_once("config.php");


if($_SERVER["REQUEST_METHOD"] == "POST" && $input != "") {
	$android = 1;
	$email_or_phone = $input->email_or_phone;
	$email_or_phone = trim($email_or_phone);

	$user_id = $email_or_phone;

	$login_type = $input->login_type;
	$login_type = trim($login_type);

	$password = $input->password;
	$password = trim($password);

	include(ROOT_PATH . 'inc/pw_fold.php');

	include(ROOT_PATH . 'inc/db_connect.php');

	include(ROOT_PATH . 'inc/check_logger.php');
	$user_type = $db_user_type;

	if($login == "yes") {
		
		include(ROOT_PATH . 'inc/id_fold.php');
		session_start();

		$_SESSION["e_user"] = $e_user_id;
		$_SESSION["user"] = $user_id;
		$_SESSION["login_type"] = $e_login_type;
		$_SESSION["user_sys_id"] = $user_sys_id;
		$_SESSION["user_type"] = $e_user_type;
	
		if($db_user_type == "investor") {

			$signUpReturn  = array(
				'status' => 1, 
				'user_id' => $investor_id, 
				'user_type' => "investor", 
				'error_set' => 0, 
				'error' => ""

				);
			echo json_encode($signUpReturn,JSON_UNESCAPED_SLASHES); exit;
			$_SESSION["welcome"] = 1;

		} elseif ($db_user_type == "business") {

			$signUpReturn  = array(
				'status' => 1, 
				'user_id' => $investor_id, 
				'user_type' => "business", 
				'error_set' => 0, 
				'error' => ""

				);
			echo json_encode($signUpReturn,JSON_UNESCAPED_SLASHES); exit;
			$_SESSION["welcome"] = 1;
		}

	} else {

		$signUpReturn  = array(
			'status' => 0, 
			'user_id' => "na", 
			'error_set' => 1, 
			'error' => "Something went Awry. We Couldn't Verify Your Pott"

			);
		echo json_encode($signUpReturn,JSON_UNESCAPED_SLASHES); exit;

	}
}