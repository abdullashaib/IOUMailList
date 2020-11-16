<?php

include("includes/include.php");
include("includes/db_connect.php");

page_header();

if(isset($_POST['submit'])) {
  
  $name = $connection->real_escape_string(trim($_POST['name']));
  $email = $connection->real_escape_string(trim($_POST['email']));
  
  $sql = "INSERT INTO mail_list (name, email) VALUES (?,?)";
  $stmt= $connection->prepare($sql);
  $stmt->bind_param("ss", $name, $email);
  //$stmt->execute();
  
  if (!$stmt->execute()) {
    echo "<span id='message' class='error'>Execute failed: (" . $stmt->errno . ") " . $stmt->error . "</span>";
  } else {
     // Add user to users table for login
     $connection->query("INSERT INTO users (email, user_password, role) VALUES ('$email',md5('Iou123@$'), '2')");
     send_email($email, $url);
     echo "<span id='message' class='success'>Record inserted</span>";
  }
}


mail_list_form(); 
  
$connection->close();

page_footer();