<?php

require('db.php');


$form_username = $_POST['username'];
$form_amount = $_POST['amount'];
$form_action = $_POST['action'];
$form_mode = $_POST['mode'];


$result_2 = $conn->prepare("SELECT username,".$form_mode." FROM user_accounts WHERE username = ?");
$result_2->bind_param("s",$form_username);

$isPreviousQuerySuccussfull = false;
$newBalance = 0;

if($result_2 === FALSE) { 
    die(mysql_error());

    $_SESSION = array();
    session_destroy();

	$error = "Error while connecting with Database!";
	$nextPage = "http://localhost:8089/e_com/Payment/php/error.php?error=".$error;
	header("Location: ".$nextPage);
	exit();	 
}

$r_2=$result_2->execute();

if($r_2) {

	$row_2=$result_2->bind_result($mer_usrn,$mer_accBalance); 

	while($result_2->fetch()) {

		$isPreviousQuerySuccussfull = true;

		echo "<br>User Verified, now Changing ".$mer_accBalance."+ or -".$form_amount;

		switch ($form_action) {
			case 'credit':
							$newBalance = $mer_accBalance + $form_amount;
							break;
			case 'debit':
							if ($form_amount > $mer_accBalance) {
								$newBalance = 0;
							} else {
								$newBalance = $mer_accBalance - $form_amount;
							}
							break;
			
			default:		$newBalance = $mer_accBalance;
							break;
		}
	}

} else {

	$_SESSION = array();
    session_destroy();

	$error = "Invalid credentials of Merchant's account!";
	$nextPage = "http://localhost:8089/e_com/Payment/php/error.php?error=".$error;
	header("Location: ".$nextPage);
	exit();				
}

$result_2->close();


if ($isPreviousQuerySuccussfull) {

	$result_step5 = $conn->prepare("UPDATE user_accounts SET ".$form_mode." = ? WHERE username = ?");
	$result_step5->bind_param("ds",$newBalance,$form_username);

	if($result_step5 === FALSE) { 
		    die(mysql_error()); 
	}

	$r_step5=$result_step5->execute();

	if ($r_step5) {

		$isPreviousQeurySuccessful = true;

		$nextPage = "http://localhost:8089/e_com/Payment/php/admin.php";
		header("Location: ".$nextPage);
		exit();										
	
	} else {
								
		$isPreviousQeurySuccessful = false;
		
		$_SESSION = array();
    	session_destroy();
    	
    	$error = "Error while updating new amount!";
		$nextPage = "http://localhost:8089/e_com/Payment/php/error.php?error=".$error;
		header("Location: ".$nextPage);
		exit();
	}
} else {

	$_SESSION = array();
    session_destroy();

	$error = "Error while updating new amount!";
	$nextPage = "http://localhost:8089/e_com/Payment/php/error.php?error=".$error;
	header("Location: ".$nextPage);
	exit();	
}

$result_step5->close();


?>