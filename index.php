<?php

session_start();

ob_start();

include("includes/include.php");
include("includes/db_connect.php");

page_header();


if(isset($_POST['submit'])) {
  
  $email = $connection->real_escape_string(trim($_POST['email']));
  $password = $connection->real_escape_string(trim($_POST['password']));

  $sql = "SELECT u.email, u.role, m.name, m.is_validated
          FROM users u 
          JOIN mail_list m ON u.email = m.email 
          WHERE u.email=? AND u.user_password=?";
          
  $stmt = $connection->prepare($sql); 
  $stmt->bind_param("ss", $email, md5($password));
  $stmt->execute();
  $result = $stmt->get_result(); 
  $user = $result->fetch_assoc();
  
  // Set session
  $_SESSION["name"] = $user['name'];
  $_SESSION["role"] = $user['role'];
  
  if($user['is_validated'] == "Yes") {
  
    $URL = "";
    if($user['role'] == 1) {
       $URL = "http://ioc.actwazalendo.org/email_list.php";
    } else if($user['role'] == 2) {
       $URL = "http://ioc.actwazalendo.org/newsletter_list.php";
    }
    
    header('Location: '.$URL);
    exit();
  } else {
      echo "<p><a href='validate_email.php?email=$email'>Please validate your email to be able to view the list.</a></p>";
  }                                            

}

?>

<script>
$(document).ready(function() {
  
  $("#login").validate({
    
    rules: {
      email: {  
        required: true,
        email: true
      },
      password: {
        required: true
      }
    },
    // Specify validation error messages
    messages: {
      email: {
        required: "Email name is required",
        email: "Please enter valid email"
      },
      password: {
        required: "Password is required"
      }
    },
    submitHandler: function(form) {
      form.submit();
    }
  });   

});

</script>
<h2>Please login to continue</h2>

  <form id="login" action="index.php" method="post">
  
    <div class="form-group row">
      <label for="email" class="col-4">Email Address:</label>
      <div class="col-8">
        <input type="email" class="form-control" id="email" name="email" autocomplete="off" />
      </div>
    </div>
    
    <div class="form-group row">
      <label for="password" class="col-4">Password:</label>
      <div class="col-8">
        <input type="password" class="form-control" id="password" name="password" autocomplete="off" />
      </div>
    </div>
    
    <div class="form-group row">
      <div class="offset-4 col-8">
        <button type="submit" name="submit" class="btn btn-success">Login</button>
      </div>
    </div>
  </form> 
  
<?php

$connection->close();

page_footer();