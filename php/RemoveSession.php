<?php

if (isset($_GET['logout'])) {
	endSession(); 
}

function endSession() {
	session_start();
    $_SESSION = array();
    session_destroy();

    $nextPage = "http://localhost:8089/e_com/Payment/LoginPage.php";
	header("Location: ".$nextPage);
	exit();
}

?>