<?php

require('db.php');

$form_username = $_POST['username'];
$form_password = $_POST['password'];
$form_userType = $_POST['userType'];
$form_name = $_POST['name'];



$hashed_password = password_hash($form_password, PASSWORD_DEFAULT);

//Login.....................

$result = $conn->prepare("SELECT username,password FROM user WHERE username = ?");
$result->bind_param("s",$form_username);


if($result === FALSE) { 
    die(mysql_error());
    
    $error = "Error while connecting with Database!";
    $nextPage = "http://localhost:8089/e_com/Payment/php/error.php?error=".$error;
	header("Location: ".$nextPage);
	exit(); 
}

$r=$result->execute();

if($r){

	$row=$result->bind_result($usr,$pass); 


	if($result->fetch() === TRUE) {

		
		 if($usr == $form_username) {
			
		    $error = "Uesr already exist!";
		    $nextPage = "http://localhost:8089/e_com/Payment/php/error.php?error=".$error;
			header("Location: ".$nextPage);
			exit();
		 }
		 
	} else {

//			echo"Signed";

//		 	$userType = 3;
		 	if($form_userType === "merchant" ) $userType = 2;
		 	else $userType = 1;

		 	$id = generateRandomString();
		 	$account_no = generateAccountNumber();
	    
			$stmt = $conn->prepare("INSERT INTO user (username, password, type, name, id, acc_no) VALUES (?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("ssisss", $form_username, $hashed_password, $userType, $form_name, $id, $account_no);

		 	$ro = null;

			if($stmt === FALSE) { 
			    die(mysql_error()); 
			}

			$ro=$stmt->execute();

			if($ro) {

			    // Inserting in user_accounts.....................................

				$initialAmount = 0.0;

				if($userType == 1) $initialAmount = 50000.0;
				else $initialAmount = 10000.0;

				$stmt = $conn->prepare("INSERT INTO user_accounts (id, username, acc_no, paytm, net_banking, debit_card, credit_card) VALUES (?, ?, ?, ?, ?, ?, ?)");
				$stmt->bind_param("sssdddd", $id, $form_username, $account_no, $initialAmount, $initialAmount, $initialAmount, $initialAmount);

			 	$ro = null;

				if($stmt === FALSE) { 
				    die(mysql_error()); 
				}

				$ro=$stmt->execute();

				if($ro) {
/*				    echo "successfully account created."."<br>";
				    echo "Balance Amount: ".$initialAmount." in all of your accounts <br>";
				    echo "<br> Please note your account_no and keep private: ".$account_no;
				    echo "<br> In case if required or any other issue occured!";*/

					$nextPage = "http://localhost:8089/e_com/Payment/LoginPage.php";
				    header("Location: ".$nextPage);
					exit();

				}
				 else {

				    $error = "Sorry, your credentials are not valid or Username Already used by someone, Please try again.";
				    $nextPage = "http://localhost:8089/e_com/Payment/php/error.php?error=".$error;
					header("Location: ".$nextPage);
					exit();
				}

			}
			 else {
			    $error = "Sorry, your credentials are not valid or Username Already used by someone, Please try again.";
				$nextPage = "http://localhost:8089/e_com/Payment/php/error.php?error=".$error;
				header("Location: ".$nextPage);
				exit();
			}

			
	}
//	echo "Done!";

} else { 

	$error = "Unsuccessful, Connection Error!";
    $nextPage = "http://localhost:8089/e_com/Payment/php/error.php?error=".$error;
	header("Location: ".$nextPage);
	exit();
}

mysqli_close($conn);



function generateRandomString($length = 20) {

    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function generateAccountNumber($length = 16) {

	$characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>
