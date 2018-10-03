<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
  .modal-header, h4, .close {
      background-color: #5cb85c;
      color:white !important;
      text-align: center;
      font-size: 30px;
  }
  .modal-footer {
      background-color: #f9f9f9;
  }
  </style>
</head>
<body>
      <?php

      $hiddenInputs = '';

      session_start();

      if (!isset($_SESSION['username'])) {
        
        $_SESSION = array();
          session_destroy();

      } else {

        if ($_SESSION['userType'] === 1) {

          if (!isset($_POST['amount']) || !isset($_POST['merchant']) || !isset($_POST['acc_no'])) {

            $nextPage = "http://localhost:8089/e_com/Payment/php/merchant_dashboard.php";
          
          } else {

            $_SESSION['amount'] = $_POST['amount'];
            $_SESSION['merchantUserName'] = $_POST['merchant'];
            $_SESSION['merchantAccountNo'] = $_POST['acc_no'];
            
            $nextPage = "http://localhost:8089/e_com/Payment/gateway/index.html";
          }
          header("Location: ".$nextPage);
          exit();

        } else {

          $_SESSION['amount'] = $_POST['amount'];
          $_SESSION['merchantUserName'] = $_POST['merchant'];
          $_SESSION['merchantAccountNo'] = $_POST['acc_no'];
          
          $nextPage = "http://localhost:8089/e_com/Payment/gateway/index.html";
          header("Location: ".$nextPage);
          exit();
        }
      }

      if (isset($_POST['submit'])) {

        $pay_amount = $_POST['amount'];
        $pay_receiver = $_POST['merchant'];
        $receiver_acc_no = $_POST['acc_no'];

        //----------------------


        //echo "Submit is set!";

        $hiddenInputs .= '<input type ="hidden" name = "amount" value = "'.htmlspecialchars($pay_amount).'"/>'.'<br>';
        $hiddenInputs .= '<input type ="hidden" name = "receiver" value = "'.htmlspecialchars($pay_receiver).'"/>'.'<br>';
        $hiddenInputs .= '<input type ="hidden" name = "acc_no" value = "'.htmlspecialchars($receiver_acc_no).'"/>'.'<br>';
      }
    ?>


<div class="container">
 

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="padding:35px 50px;">
          
          <h4><span class="glyphicon glyphicon-lock"></span> Login</h4>
        </div>
        <div class="modal-body" style="padding:40px 50px;">
          <form role="form" name="loginForm" method="post" action="php/validate.php" onsubmit="return validateForm();">
            <div class="form-group">
              <label for="usrname"><span class="glyphicon glyphicon-user"></span> Username</label>
              <input type="text" class="form-control" id="usrname" placeholder="Enter email" name="username">
            </div>
            <div class="form-group">
              <label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Password</label>
              <input type="password" class="form-control" id="psw" placeholder="Enter password" name="password">
            </div>
            <?php if (isset($_POST['submit'])) { echo $hiddenInputs; } ?>
              <button type="submit" class="btn btn-success btn-block"><span class="glyphicon glyphicon-off"></span> Login</button>
          </form>
        </div>
        <div class="modal-footer">
          
          <p>Not a member? <a href="register.html">Sign Up</a></p>
         
        </div>
      </div>
      
    </div>
  </div> 
</div>
 
<script>
$(document).ready(function(){
    
        $("#myModal").modal();
    
});


    function validateForm() {
        
        var username = document.forms["loginForm"]["username"].value;
        var password = document.forms["loginForm"]["password"].value;

       if (username == "" || password == "") {
       
            alert("Please enter valid details!");
            return false;
       
       } else if (!validateEmail(username)) {

            alert("Not a valid e-mail address");
            return false;

       } else if (password.length <= 6) {

          alert("Password must be of minimum 7 characters");
            return false;   

       } 
    }

    function validateEmail(email) {
    
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    
        return re.test(String(email).toLowerCase());
    }

</script>

</body>
</html>
