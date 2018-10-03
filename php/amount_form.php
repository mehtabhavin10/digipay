<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<?php

				require('db.php');

				$userType = 2;

				$option = '';

				session_start();
				echo $_SESSION['user'];

				$result = $conn->prepare("SELECT username,name FROM user WHERE type = ?");
				$result->bind_param('i',$userType);


				if($result === FALSE) { 
				    die(mysql_error()); 
				}

				$r=$result->execute();

				if($r) {

					$row=$result->bind_result($username,$name);
				//$sql = mysqli_query($conn, "SELECT username FROM user WHERE type = '.$userType.'");

					while ($result->fetch()) {

						$option .= '<option value = "'.$username.'">'.$name.'</option>';
					}
				}

?>


<form action="submit_form.php" method="post">

	Amount: 
	<input type="number" name="amount" min="100" max="10000000"> <br>

	Transfer Amount to:

		<select name="merchants">
			<?php echo $option; ?>
		</select> <br>

	<input type="submit" name="Pay">

</form>



</body>
</html>