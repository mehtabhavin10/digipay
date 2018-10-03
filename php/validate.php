<?php

require('db.php');

$form_username = $_POST['username'];
$form_password = $_POST['password'];

$amountToPay = 	$_POST['amount'];
$merchantUserName = $_POST['receiver'];
$merchantAccountNo = $_POST['acc_no'];


$result = $conn->prepare("SELECT username,password,type,name FROM user WHERE username = ?");
$result->bind_param("s",$form_username);

$hashed_password = password_hash($form_password, PASSWORD_DEFAULT);

if($result === FALSE) { 
    die(mysql_error()); 

	$error = "Error while connecting with Database!";
	$nextPage = "http://localhost:8089/e_com/Payment/php/error.php?error=".$error;
	header("Location: ".$nextPage);
	exit();
}

$r=$result->execute();

if($r){

	$row=$result->bind_result($usr,$pass,$type,$name); 

	while($result->fetch()){
		
		if(password_verify($form_password, $pass)) {
			    	
		if ($type == 1) {

				session_start();

				if (!isset($_POST['amount']) || !isset($_POST['receiver']) || !isset($_POST['acc_no'])) {
					
					$_SESSION['username'] = $form_username;
					$_SESSION['password'] = $form_password;
					$_SESSION['name'] = $name;
					$_SESSION['userType'] = 1;

					$nextPage = "http://localhost:8089/e_com/Payment/php/merchant_dashboard.php";

				} else {
				
					$_SESSION['username'] = $form_username;
					$_SESSION['password'] = $form_password;
					$_SESSION['name'] = $name;
					$_SESSION['userType'] = 1;

					$_SESSION['amount'] = $amountToPay;
					$_SESSION['merchantUserName'] = $merchantUserName;
					$_SESSION['merchantAccountNo'] = $merchantAccountNo;

					$nextPage = "http://localhost:8089/e_com/Payment/gateway/index.html";
				}

				header("Location: ".$nextPage);
				exit();

		} else if ($type == 3) {

				session_start();
				

				$_SESSION['username'] = $form_username;
				$_SESSION['userType'] = 3;

				$nextPage = "http://localhost:8089/e_com/Payment/php/admin.php";
				header("Location: ".$nextPage);
				exit();

		} else {

			session_start();
			if (isset($_SESSION['username'])) {
					
				$_SESSION['userType'] = 2;
				$_SESSION['password'] = $form_password;
				$_SESSION['name'] = $name;
				$_SESSION['amount'] = $amountToPay;
				$_SESSION['merchantUserName'] = $merchantUserName;
				$_SESSION['merchantAccountNo'] = $merchantAccountNo;
				
			} else {

				$_SESSION['username'] = $form_username;
				$_SESSION['password'] = $form_password;
				$_SESSION['name'] = $name;
				$_SESSION['userType'] = 2;

				$nextPage = "http://localhost:8089/e_com/Payment/php/merchant_dashboard.php";
				header("Location: ".$nextPage);
				exit();
			}
		}


		} else {

			$error = "Sorry, your credentials are not valid, Please try again.";
			$nextPage = "http://localhost:8089/e_com/Payment/php/error.php?error=".$error;
			header("Location: ".$nextPage);
			exit();
		}
	}
	if (!$result->fetch()) {
		
		$error = "Invalid Credentials";
		$nextPage = "http://localhost:8089/e_com/Payment/php/error.php?error=".$error;
		header("Location: ".$nextPage);
		exit();
	}

} else {

	$error = "Invalid Credentials";
	$nextPage = "http://localhost:8089/e_com/Payment/php/error.php?error=".$error;
	header("Location: ".$nextPage);
	exit();
}


mysqli_close($conn);

?>