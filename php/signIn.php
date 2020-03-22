<?php
    include 'connect.php';

    $uname = $_POST['Uname'];
    $Pass = $_POST['SignInPass'];
    $Pass = 'someSalt'.$Pass.'someSalt';
    $Pass = hash('sha512', $Pass);

    $q = "SELECT * FROM shashank_Users WHERE UserName='$uname' AND Password='$Pass';";
    $res = $conn->query($q);

    if(mysqli_num_rows($res) >= 1){
        header("Location: ../html/hello.html");
        die("Login successful");
    }else{
        header("Location: ../html/signIn.html");
        die("Login Failed");
    }
?>