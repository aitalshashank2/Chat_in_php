<?php
    $host = "localhost";
    $uname = "first_year";
    $passwd = "first_year";
    $db = "Chat_in_php";

    $conn = new mysqli($host, $uname, $passwd, $db);

    if($conn->connect_errno){
        echo "Failed to connect to MySQL: " + $conn->connect_error;
        die();
    }
?>