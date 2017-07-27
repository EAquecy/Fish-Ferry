<?php
$content = file_get_contents('php://input');

$input = json_decode($content);

//var_dump($input); exit

//$firstName = $input->first_name; 


require_once("config.php");

 

//$firstName = $input->first_name;


if($_SERVER["REQUEST_METHOD"] == "POST" && $input != "") {
	include(ROOT_PATH . 'inc/db_connect.php');
	$android = 1;
$first_name = $input->first_name;
$first_name = trim($first_name);

$last_name = $input->last_name;
$last_name = trim($last_name);

$pot_name = $input->pot_name;
$pot_name = trim($pot_name);

$dob = $input->dob;
$dob = trim($dob);

$country = $input->country;
$country = trim($country);

//echo "country is :  " .  $country;
//exit;

	$first_name = mysqli_real_escape_string($mysqli, $first_name);
	$last_name = mysqli_real_escape_string($mysqli, $last_name);
	$pot_name = mysqli_real_escape_string($mysqli, $pot_name);
	$dob = mysqli_real_escape_string($mysqli, $dob);
	$country = mysqli_real_escape_string($mysqli, $country);


	if($country == ""){

		$create_account = "no";
	}

$password = $input->password;
$password = trim($password);

$login_type = $input->login_type;
$login_type = trim($login_type);

	include(ROOT_PATH . 'inc/pw_fold.php');

$sex = $input->sex;
$sex = trim($sex);


	if($login_type == "phone"){

$phone = $input->email_or_phone;
$phone = trim($phone);

		$phone_length = strlen($phone);

		if($phone_length > 15) {
			

			$signUpReturn  = array(
				'status' => 0, 
				'user_id' => "na", 
				'error_set' => 1, 
				'error' => "Something Went Awry Because Of Your Phone Number"

				);
			echo json_encode($signUpReturn,JSON_UNESCAPED_SLASHES); exit;

		}
		//$phone = mysqli_real_escape_string($mysqli, $phone);
		$email = $pot_name . "@fishpot.com";
		$check = $phone;
		$column_name = "phone";

	} elseif ($login_type == "email") {

		$email = $input->email_or_phone;
		$email = trim($email);


		if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {

				$signUpReturn  = array(
					'status' => 0, 
					'user_id' => "na", 
					'error_set' => 1, 
					'error' => "Something Went Awry Because Of Your Email"

					);
				echo json_encode($signUpReturn,JSON_UNESCAPED_SLASHES); exit;

			}
		//$email = mysqli_real_escape_string($mysqli, $email);
		$phone = $pot_name . "@fishpot.com";
		$check = $email;
		$column_name = "email";
	} else {

				$signUpReturn  = array(
					'status' => 0, 
					'user_id' => "na", 
					'error_set' => 1, 
					'error' => "Something Went Awry. Not Sure If You Are Using A Phone Or Email"

					);
				echo json_encode($signUpReturn,JSON_UNESCAPED_SLASHES); exit;
	}


	if(isset($_POST["check_human"]) && $_POST["check_human"] == "wrong"){


			$signUpReturn  = array(
				'status' => 0, 
				'user_id' => "na", 
				'error_set' => 1, 
				'error' => "Something Went Awry. We Can't Tell Why"

				);
			echo json_encode($signUpReturn,JSON_UNESCAPED_SLASHES); exit;

	} else {


		$user_table = "investor";
		$user_type = "investor";

		include(ROOT_PATH . 'inc/check_user.php'); 
		if($create_account != "no"){


		} else {

			$signUpReturn  = array(
				'status' => 0, 
				'user_id' => "na", 
				'error_set' => 1, 
				'error' => "We Already Have This User"

				);
			echo json_encode($signUpReturn,JSON_UNESCAPED_SLASHES); exit;


		}


		$user_table = "investor";
		$column_name = "pot_name";
		$check = $pot_name;
		include(ROOT_PATH . 'inc/check_user.php'); 
		if($create_account != "no"){


		} else {

			$signUpReturn  = array(
				'status' => 0, 
				'user_id' => "na", 
				'error_set' => 1, 
				'error' => "Pot Name Already In Use"

				);
			echo json_encode($signUpReturn,JSON_UNESCAPED_SLASHES); exit;


		}
		$investor_id = uniqid($check, TRUE);
		if($create_account != "no") { $create_account = "yes";}
		if($create_account == "yes"){

		$table_name = "investor";

		$column1_name = "first_name";
		$column2_name = "last_name";
		$column3_name = "pot_name";
		$column4_name = "dob";
		$column5_name = "country";
		$column6_name = "sex";
		$column7_name = "net_worth";
		$column8_name = "phone";
		$column9_name = "email";
		$column10_name = "investor_id";
		$column11_name = "coins_secure_datetime";

		$column1_value = $first_name;
		$column2_value = $last_name;
		$column3_value = $pot_name;
		$column4_value = $dob;
		$column5_value = $country;
		$column6_value = $sex;
		$column7_value = 20;
		$column8_value = $phone;
		$column9_value = $email;
		$column10_value = $investor_id;
		$column11_value = date("Y-m-d H:i:s");

		$pam1 = "s";
		$pam2 = "s";
		$pam3 = "s";
		$pam4 = "s";
		$pam5 = "s";
		$pam6 = "s";
		$pam7 = "i";
		$pam8 = "s";
		$pam9 = "s";
		$pam10 = "s";
		$pam11 = "s";

		$done = 0;
		include(ROOT_PATH . 'inc/insert11_prepared_statement.php');
		include(ROOT_PATH . 'inc/db_connect.php');

			if ($done == "1"){

					if($login_type == "phone"){

							$user_id = $phone;
					} else {

							$user_id = $email;

					}
					include(ROOT_PATH . 'inc/id_fold.php');

					session_start();
					$_SESSION["e_user"] = $e_user_id;
					$_SESSION["user"] = $user_id;
					$_SESSION["user_type"] = $e_user_type;
					$_SESSION["user_sys_id"] = $investor_id;


						$table_name = "wuramu";

						$column1_name = "flag";
						$column2_name = "id";
						$column3_name = "number_login";
						$column4_name = "email_login";
						$column5_name = "password";
						$column6_name = "login_type";
						$column7_name = "full_name";

						$column1_value = 0;
						$column2_value = $investor_id;
						$column3_value = $phone;
						$column4_value = $email;
						$column5_value = $e_password;
						$column6_value = "investor";
						$column7_value = $first_name . " " . $last_name;

						$pam1 = "i";
						$pam2 = "s";
						$pam3 = "s";
						$pam4 = "s";
						$pam5 = "s";
						$pam6 = "s";
						$pam7 = "s";

						$done = 0;
						include(ROOT_PATH . 'inc/insert7_prepared_statement.php');
						include(ROOT_PATH . 'inc/db_connect.php');


						if($done == 1) {

								$signUpReturn  = array(
									'status' => 1, 
									'user_id' => $investor_id, 
									'error_set' => 0, 
									'error' => ""

									);
								echo json_encode($signUpReturn,JSON_UNESCAPED_SLASHES); exit;
								$_SESSION["welcome"] = 1;
							} else {

								$signUpReturn  = array(
									'status' => 0, 
									'user_id' => "na", 
									'error_set' => 1, 
									'error' => "Something went Awry. It's Not Your Fault. Try Again later"

									);
								echo json_encode($signUpReturn,JSON_UNESCAPED_SLASHES); exit;
							
							}
				} else{

								$signUpReturn  = array(
									'status' => 0, 
									'user_id' => "na", 
									'error_set' => 1, 
									'error' => "Something went Awry. You Should Try Again later"

									);
								echo json_encode($signUpReturn,JSON_UNESCAPED_SLASHES); exit;

				} 
			}	else {

								$signUpReturn  = array(
									'status' => 0, 
									'user_id' => "na", 
									'error_set' => 1, 
									'error' => "Ooops...Something went Awry. Try Again later"

									);
								echo json_encode($signUpReturn,JSON_UNESCAPED_SLASHES); exit;

				}
		
	}


}

?>