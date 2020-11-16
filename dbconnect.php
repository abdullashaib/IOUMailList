<?php

define('DB_HOST', 'ashaib583520.netfirmsmysql.com');
define('DB_USER', 'ioumaillist');
define('DB_PASS', 'Finch@255$1');
define('DB_NAME', 'maillist');

$conn = new mysqli(DB_HOST ,DB_USER ,DB_PASS ,DB_NAME);

if ($conn->connect_errno) {
    printf("connection failed: %s\n", $conn->connect_error());
    exit();
} 

return $conn;

