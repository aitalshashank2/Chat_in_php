<?php
    $host = "localhost";
    $uname = "first_year";
    $passwd = "first_year";
    $db = "shashank_Users";

    $conn = new mysqli($host, $uname, $passwd, $db);

    if($conn->connect_errno){
        echo "Failed to connect to MySQL: " + $conn->connect_error;
        die();
    }
?>