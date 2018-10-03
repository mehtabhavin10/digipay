<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body style="height:1500px">
  <?php

    require('db.php');

    //$list = '';
    $transactions = '';
    $balance = '';

    session_start();

    if (isset($_SESSION['username'])) {
      
    
      $username = $_SESSION['username']; 

      $result = $conn->prepare("SELECT id, date_time, sender_username, receiver_username, amount FROM transactions WHERE sender_username = ? OR receiver_username = ?");
      $result->bind_param('ss',$username,$username);


      if($result === FALSE) { 
          die(mysql_error()); 

          $_SESSION = array();
          session_destroy();

        $error = "Error while connecting with the Database!";
        $nextPage = "http://localhost:8089/e_com/Payment/php/error.php?error=".$error;
        header("Location: ".$nextPage);
        exit(); 
      }

      $r=$result->execute();

      if($r) {

        $row=$result->bind_result($Id,$date_Time,$senderUsername,$receiverUsername,$Amount);

        while ($result->fetch()) {

          //$list .= '<li>'.$Id.' '.$date_Time.' '.$senderUsername.' '.$receiverUsername.' '.$Amount.' '.'</li>';

          $transactions .= '<tr> <td>'.$Id.'</td> <td>'.$date_Time.'</td> <td>'.$senderUsername.'</td> <td>'.$receiverUsername.'</td> <td>'.$Amount.'</td> </tr>';
        }

/*        if (!$result->fetch()) {
        
          $_SESSION = array();
            session_destroy();

          $error = "Invalid credentials of Merchant's account!";
          $nextPage = "http://localhost:8089/e_com/Payment/php/error.php?error=".$error;
          header("Location: ".$nextPage);
          exit(); 
        }*/

      } else {

        $_SESSION = array();
          session_destroy();

        $error = "Invalid credentials of Merchant's account!";
        $nextPage = "http://localhost:8089/e_com/Payment/php/error.php?error=".$error;
        header("Location: ".$nextPage);
        exit(); 
      }

      $result->close();



      $result_2 = $conn->prepare("SELECT username,acc_no,paytm,net_banking,debit_card,credit_card FROM user_accounts WHERE username = ?");
      $result_2->bind_param("s",$username);

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

/*        if (!$result_2->fetch()) {
        
          $_SESSION = array();
            session_destroy();

          $error = "Invalid credentials of Merchant's account!";
          $nextPage = "http://localhost:8089/e_com/Payment/php/error.php?error=".$error;
          header("Location: ".$nextPage);
          exit(); 
        }*/

      } else {

        $_SESSION = array();
          session_destroy();

        $error = "Invalid credentials of Merchant's account!";
        $nextPage = "http://localhost:8089/e_com/Payment/php/error.php?error=".$error;
        header("Location: ".$nextPage);
        exit(); 
      }

      $result_2->close();
      
    }  else {

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

  <table class="table table-hover">
    <tbody>
      <tr>
          <th>  Transaction ID  </th>
          <th>  Date/Time   </th>
          <th>  Sender      </th>
          <th>  Receiver    </th>
          <th>  Amount(Rs.)   </th>
       </tr>
      <?php echo $transactions; ?>
    </tbody>
  </table>


</table> 

  <button type="submit" name="submit" class="btn btn-success" value="Submit"
  ><a href="http://localhost:8089/e_com/Payment/index.html" style="color:white">Transfer to Another Merchant</a></button>


</div>
</div>

</body>
</html>
