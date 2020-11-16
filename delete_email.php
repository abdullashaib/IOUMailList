<?php

include("includes/include.php");
include("includes/db_connect.php");

page_header();

  $id = $connection->real_escape_string(trim($_GET['id']));
  
  $URL = "http://ioc.actwazalendo.org/email_list.php";

if($id > 0 ) {
  
  $sql = "DELETE FROM mail_list WHERE id=?";
  $stmt= $connection->prepare($sql);
  $stmt->bind_param("i", $id);
  
  if (!$stmt->execute()) {
    echo "<span id='message' class='error'>Execute failed: (" . $stmt->errno . ") " . $stmt->error . "</span>";
  } else {
     echo "<span id='message' class='success'>Record deleted</span>";
     echo "<br /><a href='email_list.php'>Back to List</a>";
     
     header('Location: '.$URL);
     exit();
  }

}
 
$connection->close();  

page_footer();