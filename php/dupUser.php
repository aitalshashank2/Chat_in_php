<?php
    include 'connect.php';

    $uname = $_GET['uname'];
    $email = $_GET['email'];

    if($email == ""){
        $q = "SELECT * FROM shashank_Users WHERE UserName = '$uname';";
        $res = $conn->query($q);
        if(mysqli_num_rows($res) >= 1){
            echo "UserName already exists";
        }
    }
    if($uname == ""){
        $q1 = "SELECT * FROM shashank_Users WHERE Email = '$email';";
        $res1 = $conn->query($q1);
        if(mysqli_num_rows($res1) >= 1){
            echo "Email already in use";
        }
    }
?>