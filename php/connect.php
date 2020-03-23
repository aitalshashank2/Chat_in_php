<?php
    $host = "localhost";
    $uname = "root";
    $passwd = "SHAshu4321#@mysql";
    $db = "Chat_in_php";

    $conn = new mysqli($host, $uname, $passwd, $db);

    if($conn->connect_errno){
        echo "Failed to connect to MySQL: " + $conn->connect_error;
        die();
    }
?>