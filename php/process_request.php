<!DOCTYPE html>
<html lang="en">
<?php

/*

    PROCESSING STEPS:

    STEP-1 ->   VERIFY THE CUSTOMERS CREDENTIALS.
    STEP-2 ->   EXTRACTING CUSTOMER ACCOUNTS/AMOUNTS FROM DATABASE.
    STEP-3 ->   DEBITING AMOUNT FROM CUSTOMER'S ACCOUNT.
    STEP-4 ->   VERIFYING AND EXTRACTING MERCHANT ACCOUNTS/AMOUNTS FROM DATABASE.
    STEP-5 ->   CREDITING AMOUNT INTO MERCHANT'S ACCOUNT.
    STEP-6 ->   SAVING THE TRANSACTION DETAILS INTO DATABASE FOR FUTURE REQUIREMENT.

*/

/*

    PROCESSING STEPS:

    STEP-1 ->   VERIFY THE CUSTOMERS CREDENTIALS.
    STEP-2 ->   EXTRACTING CUSTOMER ACCOUNTS/AMOUNTS FROM DATABASE.
<-->STEP-4 ->   VERIFYING AND EXTRACTING MERCHANT ACCOUNTS/AMOUNTS FROM DATABASE.
<-->STEP-3 ->   DEBITING AMOUNT FROM CUSTOMER'S ACCOUNT.
    STEP-5 ->   CREDITING AMOUNT INTO MERCHANT'S ACCOUNT.
    STEP-6 ->   SAVING THE TRANSACTION DETAILS INTO DATABASE FOR FUTURE REQUIREMENT.

*/




if (isset($_POST['submit'])) {


  require('db.php');

  session_start();

  if (isset($_SESSION['merchantUserName'])) {
    

    $form_accountNo = $_POST['acc_no'];
    $form_paymentMethod = $_POST['paymentType'];


    $form_username = $_SESSION['username'];
    $form_password = $_SESSION['password'];
    $form_name = $_SESSION['name'];


    $amountToPay = $_SESSION['amount'];
    $merchantUserName = $_SESSION['merchantUserName'];
    $merchantAccountNo = $_SESSION['merchantAccountNo'];

    $userType = $_SESSION['userType'];

    $sender_username = null;
    $sender_password = null;
    $sender_name = null;
    $sender_acc_no = null;
    $sender_paytm = null;
    $sender_net_banking = null;
    $sender_credit_card = null;
    $sender_debit_card = null;

    $receiver_username = null;
    $receiver_acc_no = null;
    $receiver_name = null;
    $receiver_paytm = null;
    $receiver_net_banking = null;
    $receiver_credit_card = null;
    $receiver_debit_card = null;


?>
<head>
  <title>Digi Pay</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body style="height:1500px">

<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#" style="margin-left: 5%">DIGIPAY</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active" style="margin-left: 5%"><a href="process_request.php?home=true">Home</a></li>
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
        <th>Customer</th>
        <td><?php echo $form_username ?></td>
      </tr>
      <tr>
        <th>Name</th>
        <td><?php echo $form_name ?></td>
      </tr>
      <tr>
        <th>Account Number</th>
        <td><?php echo $form_accountNo ?></td>
      </tr>
      <tr>
        <th>Payment Method</th>
        <td><?php echo $form_paymentMethod ?></td>
      </tr>
      <tr>
        <th>Amount</th>
        <td><?php echo $amountToPay ?></td>
      </tr>
      <tr>
        <th>Merchant</th>
        <td><?php echo $merchantUserName ?></td>
      </tr>
      <tr>
        <th>Merchant Account Number</th>
        <td><?php echo $merchantAccountNo ?></td>
      </tr>
      <tr>
    </tbody>
  </table>

        
  
<?php 

$status = '';
    $isPreviousQeurySuccessful = false;

    $result = $conn->prepare("SELECT username,password,name,acc_no FROM user WHERE username = ?");
    $result->bind_param("s",$form_username);

    $hashed_password = password_hash($form_password, PASSWORD_DEFAULT);

    if($result === FALSE) { 
        die(mysql_error());
      
      $_SESSION = array();
        session_destroy();

      $error ="<div class=\"alert alert-info\">
        <strong>Info!</strong> Error while connecting with the Database!
        </div>" ; 
      //$error = "<h2>Error while connecting with the Database!</h2>";
      
      $nextPage = "http://localhost:8089/e_com/Payment/php/error.php?error=".$error;
      header("Location: ".$nextPage);
      exit(); 
    }

    $r=$result->execute();

    if($r){

      $row=$result->bind_result($usr,$pass,$name,$acc_no); 

      while($result->fetch()){

        
        if(password_verify($form_password, $pass) && $form_name === $name && $form_accountNo === $acc_no) {
      
          $isPreviousQeurySuccessful = true;

          $sender_username = $usr;
          $sender_password = $pass;
          $sender_name = $name;
          $sender_acc_no = $acc_no;

        } else {
        
            echo "<div class=\"alert alert-info\">
        <strong>Info!</strong> Sorry, your credentials are not valid, Please try again.
        </div>";
            //echo "<h2>Sorry, your credentials are not valid, Please try again.</h2>";
          $status = 'unsuccess';
          $isPreviousQeurySuccessful = false;
        }
      }

    } else {

          $_SESSION = array();
            session_destroy();

          //$error = "<h2></h2>";
          $error = "<div class=\"alert alert-info\">
        <strong>Info!</strong>Invalid credentials of Merchant's account!</div>";

          $nextPage = "http://localhost:8089/e_com/Payment/php/error.php?error=".$error;
          header("Location: ".$nextPage);
          exit(); 
    }

    $result->close();



    if ($isPreviousQeurySuccessful) {


      // User account_no verified. Now debiting from his/her specified account.

      $result_step2 = $conn->prepare("SELECT username,acc_no,paytm,net_banking,debit_card,credit_card FROM user_accounts WHERE username = ? AND acc_no = ?");
      $result_step2->bind_param("ss",$form_username, $form_accountNo);
      
      if($result_step2 === FALSE) { 
          die(mysql_error());
        
        $_SESSION = array();
          session_destroy();


        $error = "<div class=\"alert alert-info\">
        <strong>Info!</strong>Error while connecting with the Database!</div>" ; 

        $nextPage = "http://localhost:8089/e_com/Payment/php/error.php?error=".$error;
        header("Location: ".$nextPage);
        exit(); 
      }


      $r_step2=$result_step2->execute();

      if($r_step2) {

        $row_step2=$result_step2->bind_result($usrn,$accNo,$paytm,$netBanking,$debitCard,$creditCard); 

        while($result_step2->fetch()) {

          $isPreviousQeurySuccessful = true;
          
          $sender_paytm = $paytm;
          $sender_net_banking = $netBanking;
          $sender_credit_card = $creditCard;
          $sender_debit_card = $debitCard;
        }

      } else {
        
        $isPreviousQeurySuccessful = false;


          $_SESSION = array();
            session_destroy();

      $error = "<div class=\"alert alert-info\">
        <strong>Info!</strong>Invalid credentials of Merchant's account!</div>";


          $nextPage = "http://localhost:8089/e_com/Payment/php/error.php?error=".$error;
          header("Location: ".$nextPage);
          exit(); 
      }

      $result_step2->close();

    } else {
      echo "<div class=\"alert alert-info\">
        <strong>Info!</strong>Something went wrong while verifying your account_no, please check again! </div>";

      //echo "<h2></h2>";
    }

    if($isPreviousQeurySuccessful) {



        // ----------------------------------------------------------------

      $result_step4 = $conn->prepare("SELECT username,acc_no,paytm,net_banking,debit_card,credit_card FROM user_accounts WHERE username = ? AND acc_no = ?");
      $result_step4->bind_param("ss",$merchantUserName,$merchantAccountNo);

      if($result_step4 === FALSE) { 
          die(mysql_error());
        
        $_SESSION = array();
          session_destroy();

         $error = "<div class=\"alert alert-info\">
        <strong>Info!</strong>Error while connecting with the Database!</div>";


        $nextPage = "http://localhost:8089/e_com/Payment/php/error.php?error=".$error;
        header("Location: ".$nextPage);
        exit(); 
      } 

      $r_step4=$result_step4->execute();

      if($r_step4) {

        $row_step4=$result_step4->bind_result($mer_usrn,$mer_accNo,$mer_paytm,$mer_netBanking,$mer_debitCard,$mer_creditCard); 

        while($result_step4->fetch()) {


          $isPreviousQeurySuccessful = true;

          $receiver_username = $mer_usrn;
          $receiver_acc_no = $mer_accNo;
          $receiver_paytm = $mer_paytm;
          $receiver_net_banking = $mer_netBanking;
          $receiver_debit_card = $mer_debitCard;
          $receiver_credit_card = $mer_creditCard;
        }
    /*
        if (!$result_step4->fetch()) {
          
            $_SESSION = array();
              session_destroy();

            $error = "Invalid credentials of Merchant's account!";
            $nextPage = "http://localhost:8089/e_com/Payment/php/error.php?error=".$error;
            header("Location: ".$nextPage);
            exit(); 
        }*/

                    echo "<div class=\"alert alert-info\">
        <strong>Info!</strong>Merchant account successfully verified!</div>";


      } else {

                      echo "<div class=\"alert alert-info\">
        <strong>Info!</strong>Invalid credentials of Merchant's account!</div>";

          $isPreviousQeurySuccessful = false;

          $_SESSION = array();
            session_destroy();

          $error = "<h2></h2>";
          
          $error = "<div class=\"alert alert-info\">
        <strong>Info!</strong>Invalid credentials of Merchant's account!</div>";

          $nextPage = "http://localhost:8089/e_com/Payment/php/error.php?error=".$error;
          header("Location: ".$nextPage);
          exit(); 
        
      }

      $result_step4->close();

    } else {
                  echo "<div class=\"alert alert-info\">
        <strong>Info!</strong>Error while Verifying Merchant's account, please check your credentials and try again!</div>";

    }


    if ($isPreviousQeurySuccessful) {
      
      switch ($form_paymentMethod) {

        case 'paytm':
          if ($sender_paytm >= $amountToPay && ($sender_paytm - $amountToPay >= 100)) {

            $sender_paytm = $sender_paytm - $amountToPay;
            $status = 'success';
            $result_step3 = $conn->prepare("UPDATE user_accounts SET paytm = ? WHERE username = ? AND acc_no = ?");
            $result_step3->bind_param("dss",$sender_paytm,$sender_username,$sender_acc_no);

          } else {

            echo "<div class=\"alert alert-info\">
        <strong>Info!</strong>You don't have enough money in that account, try another account or ask for loan.</div>";

            $status = 'unsuccess';
          }
          break;
                

        case 'net_banking':
          if ($sender_net_banking >= $amountToPay && ($sender_net_banking-$amountToPay>=100)) {

            $sender_net_banking = $sender_net_banking - $amountToPay;
            $status = 'success';
            $result_step3 = $conn->prepare("UPDATE user_accounts SET net_banking = ? WHERE username = ? AND acc_no = ?");
            $result_step3->bind_param("dss",$sender_net_banking,$sender_username,$sender_acc_no);

          } else {
            echo "<div class=\"alert alert-info\">
        <strong>Info!</strong>You don't have enough money in that account, try another account or ask for loan.</div>";
            $status = 'unsuccess';
          }
          break;
                

        case 'debit_card':
          if ($sender_debit_card >= $amountToPay && ($sender_debit_card-$amountToPay>=100)) {

            $sender_debit_card = $sender_debit_card - $amountToPay;
            $status = 'success';
            $result_step3 = $conn->prepare("UPDATE user_accounts SET debit_card = ? WHERE username = ? AND acc_no = ?");
            $result_step3->bind_param("dss",$sender_debit_card,$sender_username,$sender_acc_no);

          } else {

            echo "<div class=\"alert alert-info\">
        <strong>Info!</strong>You don't have enough money in that account, try another account or ask for loan.</div>";
                    $status = 'unsuccess';
          }
          break;
                

        case 'credit_card':
          if ($sender_credit_card >= $amountToPay && ($sender_credit_card-$amountToPay>=100)) {
                  
            $sender_credit_card = $sender_credit_card - $amountToPay;
            $status = 'success';
            $result_step3 = $conn->prepare("UPDATE user_accounts SET credit_card = ? WHERE username = ? AND acc_no = ?");
            $result_step3->bind_param("dss",$sender_credit_card,$sender_username,$sender_acc_no);

          } else {
            echo "<div class=\"alert alert-info\">
        <strong>Info!</strong>You don't have enough money in that account, try another account or ask for loan.</div>";
                    $status = 'unsuccess';
          }
          break;
                
                
        default:
                    echo "<div class=\"alert alert-info\">
        <strong>Info!</strong>Server side error, Please try again later.</div>";

          $status = 'unsuccess';
          break;
      }
            
        if ($status === 'unsuccess') {

            echo "<div class=\"alert alert-info\">
        <strong>Info!</strong>Sorry, You cannot proceed!<br> Transaction Failed, Please Try again!</div>";
              
            $isPreviousQeurySuccessful=false;
        } else {
      
          if($result_step3 === FALSE) { 
              die(mysql_error());
            
            $_SESSION = array();
              session_destroy();

            $error = "<div class=\"alert alert-info\">
        <strong>Info!</strong>Error while connecting with the Database!</div>";
  

            $nextPage = "http://localhost:8089/e_com/Payment/php/error.php?error=".$error;
            header("Location: ".$nextPage);
            exit(); 
          } 

          $r_step3=$result_step3->execute();

          if ($r_step3) {
                  
            // Amount Debited from sender's account now crediting to receiver's account

//            echo "<h2><br>"" </h2>";

           echo "<div class=\"alert alert-info\">
        <strong>Info!</strong>".$amountToPay."Rs. Have been debited from account now crediting in merchants account.</div>";


            $isPreviousQeurySuccessful = true; 

          } else {
                  
            $isPreviousQeurySuccessful = false;


            $_SESSION = array();
              session_destroy();
            
            $error = "<div class=\"alert alert-info\">
        <strong>Info!</strong>Invalid credentials of Merchant's account!</div>";


            $nextPage = "http://localhost:8089/e_com/Payment/php/error.php?error=".$error;
            header("Location: ".$nextPage);
            exit(); 
          
          }
                  $result_step3->close();
        }
    } 








    if ($isPreviousQeurySuccessful) {
      

      switch ($form_paymentMethod) {

        case 'paytm':

          $receiver_paytm = $receiver_paytm + $amountToPay;
          $status = 'success';
          $result_step5 = $conn->prepare("UPDATE user_accounts SET paytm = ? WHERE username = ? AND acc_no = ?");
          $result_step5->bind_param("dss",$receiver_paytm,$receiver_username,$receiver_acc_no);
          $status = 'success'; 

          break;
                        

        case 'net_banking':

          $receiver_net_banking = $receiver_net_banking + $amountToPay;
          $status = 'success';
          $result_step5 = $conn->prepare("UPDATE user_accounts SET net_banking = ? WHERE username = ? AND acc_no = ?");
          $result_step5->bind_param("dss",$receiver_net_banking,$receiver_username,$receiver_acc_no);                       
          $status = 'success'; 
                            
          break;
                        

        case 'debit_card':
                          
          $receiver_debit_card = $receiver_debit_card + $amountToPay;
          $status = 'success';
          $result_step5 = $conn->prepare("UPDATE user_accounts SET debit_card = ? WHERE username = ? AND acc_no = ?");
          $result_step5->bind_param("dss",$receiver_debit_card,$receiver_username,$receiver_acc_no);
          $status = 'success'; 

          break;
                        

        case 'credit_card':
                          
          $receiver_credit_card = $receiver_credit_card + $amountToPay;
          $status = 'success';
          $result_step5 = $conn->prepare("UPDATE user_accounts SET credit_card = ? WHERE username = ? AND acc_no = ?");
          $result_step5->bind_param("dss",$receiver_credit_card,$receiver_username,$receiver_acc_no);
                            $status = 'success'; 

          break;
                        
        default:
          
                      echo "<div class=\"alert alert-info\">
        <strong>Info!</strong>Server side error, Please try again later.</div>";
   $status = 'unsuccess';
          break;
      }
                    
      if ($status === 'unsuccess') {
                       echo "<div class=\"alert alert-info\">
        <strong>Info!</strong>Sorry, You cannot proceed!<br> Transaction Failed, Please Try again!</div>";
       
          break;
      
      } else {
        
        if($result_step5 === FALSE) { 
            die(mysql_error());
          
          $_SESSION = array();
            session_destroy();

          $error = "<h2></h2>";

          $error = "<div class=\"alert alert-info\">
        <strong>Info!</strong>Error while connecting with the Database!</div>";

          $nextPage = "http://localhost:8089/e_com/Payment/php/error.php?error=".$error;
          header("Location: ".$nextPage);
          exit(); 
        }

        $r_step5=$result_step5->execute();

        if ($r_step5) {

          // Tranction process is over, now Storing the transaction in DB

         echo "<div class=\"alert alert-info\">
        <strong>Info!</strong>".$amountToPay." Rs. Have been credited to account now recording the details of transaction.</div>";

          $isPreviousQeurySuccessful = true;
                        
        } else {
                    
          $isPreviousQeurySuccessful = false;
        
          $_SESSION = array();
            session_destroy();

          $error = "<div class=\"alert alert-info\">
        <strong>Info!</strong>Invalid credentials of Merchant's account!</div>";
    
          $nextPage = "http://localhost:8089/e_com/Payment/php/error.php?error=".$error;
          header("Location: ".$nextPage);
          exit(); 
        
        }
      }

      $result_step5->close();
    }

    if ($isPreviousQeurySuccessful) {
      
      // ----------------------------------------------------------

      $transactionId = generateRandomString();
      $result_step6 = $conn->prepare("INSERT INTO transactions (id, date_time, sender_username, receiver_username, sender_acc_no, receiver_acc_no, amount) VALUES (?, now(), ?, ?, ?, ?, ?)");
      $result_step6->bind_param("sssssd", $transactionId, $sender_username, $receiver_username, $sender_acc_no, $receiver_acc_no, $amountToPay);

      if($result_step6 === FALSE) { 

          die(mysql_error()); 
      }

      if($result_step6 === FALSE) { 
          die(mysql_error());
        
        $_SESSION = array();
          session_destroy();
        
        $error = "<div class=\"alert alert-info\">
        <strong>Info!</strong>Error while connecting with the Database!</div>";


        $nextPage = "http://localhost:8089/e_com/Payment/php/error.php?error=".$error;
        header("Location: ".$nextPage);
        exit(); 
      }

      $r_step6=$result_step6->execute();

      if($r_step6) {

            echo "<div class=\"alert alert-info\">
        <strong>Info!</strong>Transaction successfully done, Please double check you balance.</div>";

          $_SESSION['merchantUserName'] = '';
          $_SESSION['username'] = $sender_username;
          // Display Balance remaining.
      } else {

          $_SESSION = array();
            session_destroy();

          $error =  "<div class=\"alert alert-info\">
        <strong>Info!</strong>Invalid credentials of Merchant's account!</div>";


          $nextPage = "http://localhost:8089/e_com/Payment/php/error.php?error=".$error;
          header("Location: ".$nextPage);
          exit(); 
      }


      $result_step6->close();
    }


    mysqli_close($conn);

  } else {

      $_SESSION = array();
        session_destroy();

       $error = "<div class=\"alert alert-info\">
        <strong>Info!</strong>Invalid credentials!</div>";
 
      $nextPage = "http://localhost:8089/e_com/Payment/php/error.php?error=".$error;
      header("Location: ".$nextPage);
      exit(); 
  }
} else if (isset($_GET['home'])) {
  redirectToHome(); 
} else {

              echo "<div class=\"alert alert-info\">
        <strong>Info!</strong>Your form not submitted!</div>";

}

function generateRandomString($length = 10) {

    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}





function redirectToHome() {

  if ($userType == 1) {
    // Customer
    $nextPage = "http://localhost:8089/e_com/Payment/php/merchant_dashboard.php";
  } else {
    // Merchant
    $nextPage = "http://localhost:8089/e_com/Payment/php/merchant_dashboard.php";
  }
  header("Location: ".$nextPage);
  exit();
}


?>
</div>
</div>

</body>
</html>
