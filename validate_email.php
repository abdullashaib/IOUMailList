<?php

include("includes/include.php");
include("includes/db_connect.php");

page_header();

  $email = $connection->real_escape_string(trim($_GET['email']));

  $connection->query("UPDATE mail_list SET is_validated = 'Yes' WHERE email = '$email'");

  echo "<span id='message' class='success'>Email validated </span>";
  
  echo "<br /><a href='index.php'>Log in now</a>";
   

$connection->close();

page_footer();
