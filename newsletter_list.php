<?php

session_start();

ob_start();

include("includes/include.php");
include("includes/db_connect.php");

page_header();


if(isset($_SESSION["role"])) {
  
  echo "This is newsletter old list page";

}



page_footer();