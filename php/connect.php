<?php
    $host = "localhost";
    $uname = "first_year";
    $passwd = "first_year";
    $db = "first_year";

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
?>