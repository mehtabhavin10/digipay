<!DOCTYPE html>
<html lang="en">
<head>
  <title>Digi Pay</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body style="height:1500px">
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
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#" style="margin-left: 5%">DIGIPAY</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active" style="margin-left: 5%"><a href="#">Home</a></li>
    </ul>

    <ul class="nav navbar-nav navbar-right" style="margin-right: 5%">
      <li><a href="http://localhost:8089/e_com/Payment/php/RemoveSession.php?logout=true">Logout</a></li>
    </ul>
  </div>
</nav>
  
<div class="container" style="margin-top:50px">
  
  <div class="container-fluid">
  
  <table class="table table-hover">
    <tbody>
      <tr>
    <th>  Username    </th>
    <th>  Account No.   </th>
    <th>  PayTM     </th>
    <th>  Net Banking   </th>
    <th>  Debit Card    </th>
    <th>  Credit Card   </th>
      </tr>
      <?php echo $balance; ?>
    </tbody>
  </table>
 
  <form role="form" name="loginForm" method="POST" action="admin_action.php" onsubmit="return validateForm();">
  
<div class="form-group">

              <label for="usrname"><span class="glyphicon glyphicon-user"></span> Username</label>
              <input type="text" class="form-control" id="usrname" placeholder="Enter username" name="username">
                    
              <label for="amount"><span class="glyphicon glyphicon-usd"></span> Amount</label>
              <input type="text" class="form-control" id="amount" placeholder="Enter amount" name="amount">
  


  Action:
  <select name="action" style="margin: 10px;">
      <option value="credit" selected="selected">Credit</option>
      <option value="debit">Debit</option>
  </select>
  
  <br>

  Wallet:
  <select name="mode" style="margin: 10px;">
      <option value="paytm" selected="selected">PayTM</option>
      <option value="net_banking">Net Banking</option>
    <option value="debit_card">Debit Card</option>
      <option value="credit_card">Credit Card</option>
  </select>

  <br>
   <button type="submit" name="submit" class="btn btn-success" value="Submit">Submit</button>


</div>
</form>
  

</div>
</div>

</body>
<script>

    function validateForm() {
        
        var amount = document.forms["loginForm"]["amount"].value;
        var username = document.forms["loginForm"]["username"].value;

       if (username == "" || amount == 0) {
       
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
