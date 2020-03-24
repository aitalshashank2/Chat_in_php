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

    function RandHashGen(){
        $x = "As".rand(10000, 20000)."Gar".rand(40000,50000)."d".rand(70000,80000);
        $x = hash('sha512', $x);

        return $x;
    }

    function alert($str){
        echo "<script> alert('$str');</script>";
    }

?>