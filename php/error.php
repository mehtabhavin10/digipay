<!DOCTYPE html>
<html>
<head>
	  <title>Digi Pay</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
div {
    margin-bottom: 15px;
    padding: 4px 12px;
}

.danger {
    background-color: #ffdddd;
    border-left: 6px solid #f44336;
}
</style>
</head>

<?php

$errorMsg = '';

if (isset($_GET['error'])) {
	// echo $_GET['error'];
	$errorMsg = $_GET['error'];
}

?>


<body>

<div class="danger">
  <p><strong>Error! </strong> <?php echo $errorMsg; ?> </p>
</div>

</body>
</html>
