<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<?php

		require('db.php');

		$balance = '';

		session_start();
		if (isset($_SESSION['username'])) {
		$username = $_SESSION['username']; 

		$result_2 = $conn->prepare("SELECT username,acc_no,paytm,net_banking,debit_card,credit_card FROM user_accounts");

		if($result_2 === FALSE) { 
		    die(mysql_error()); 

		    $_SESSION = array();
    		session_destroy();

		    $error = "Error while connecting with the Database!";
			$nextPage = "http://localhost:8089/e_com/Payment/php/error.php?error=".$error;
			header("Location: ".$nextPage);
			exit();
		}

		$r_2=$result_2->execute();

		if($r_2) {

			$row_2=$result_2->bind_result($mer_usrn,$mer_accNo,$mer_paytm,$mer_netBanking,$mer_debitCard,$mer_creditCard); 

			while($result_2->fetch()) {

				$balance .= '<tr> <td>'.$mer_usrn.'</td> <td>'.$mer_accNo.'</td> <td>'.$mer_paytm.'</td> <td>'.$mer_netBanking.'</td> <td>'.$mer_debitCard.'</td> <td>'.$mer_creditCard.'</td> </tr>';

			}

		} else {
			
			$_SESSION = array();
    		session_destroy();

			$error = "Invalid credentials of Merchant's account!";
			$nextPage = "http://localhost:8089/e_com/Payment/php/error.php?error=".$error;
			header("Location: ".$nextPage);
			exit();	
		}

		} else {

			$_SESSION = array();
    		session_destroy();

			$error = "Invalid credentials!";
			$nextPage = "http://localhost:8089/e_com/Payment/php/error.php?error=".$error;
			header("Location: ".$nextPage);
			exit();	
		}

	?>

<br><br><br>
Balance Money (Rs.):

<table>
	
	<tr>
		
		<th>	Username		</th>
		<th>	Account No.		</th>
		<th>	PayTM			</th>
		<th>	Net Banking		</th>
		<th>	Debit Card		</th>
		<th>	Credit Card		</th>

	</tr>

	<?php echo $balance; ?>

</table>

<br><br><br>

<form name="form" method="POST" action="admin_action.php" onsubmit="return validateForm();">
	
	Username:
	<input type="text" name="username"> <br>
	
	Amount:
	<input type="number" name="amount"> <br>
	
	Action:
	<select name="action">
	    <option value="credit" selected="selected">Credit</option>
	    <option value="debit">Debit</option>
	</select>
	
	<br>

	Wallet:
	<select name="mode">
	    <option value="paytm" selected="selected">PayTM</option>
	    <option value="net_banking">Net Banking</option>
		<option value="debit_card">Debit Card</option>
	    <option value="credit_card">Credit Card</option>
	</select>

	<br>

	<input type="submit" name="submit" value="SUBMIT">
</form>

<a href="http://localhost:8089/e_com/Payment/php/RemoveSession.php?logout=true">Logout</a>


</body>

		<script>

		function validateForm() {
		    
		    var username = document.forms["form"]["username"].value;
		    var amount = document.forms["form"]["amount"].value;

		   if (username == "" || amount == "" || amount == 0) {
		   
		        alert("Please enter valid details!");
		        return false;
		   
		   } else if (!validateEmail(username)) {

		      	alert("Not a valid e-mail address");
		      	return false;

		   } 
		}

		function validateEmail(email) {
		
		    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		
		    return re.test(String(email).toLowerCase());
		}

	</script>

</html>