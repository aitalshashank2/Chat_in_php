<?php
    include 'connect.php';

    $uname = $_POST['Uname'];
    $Pass = $_POST['SignInPass'];
    $Pass = 'someSalt'.$Pass.'someSalt';
    $Pass = hash('sha512', $Pass);
    $remme = $_POST['Remem'];

    $q = "SELECT * FROM shashank_Users WHERE UserName='$uname' AND Password='$Pass';";
    $res = $conn->query($q);

    if(mysqli_num_rows($res) >= 1){
        session_start();
        $q = "DELETE FROM shashank_Sessions WHERE UserName='$uname';";
        $conn->query($q);

        $userSessHash = RandHashGen();
        $_SESSION['userSessHash'] = $userSessHash;

        $q = "INSERT INTO shashank_Sessions (Session, UserName) VALUES ('$userSessHash', '$uname');";
        $conn->query($q);

        if($remme === "on"){
            $_SESSION['RememberStatus'] = 1;
            die(header("Location: ../php/hello.php"));
        }else{
            die(header("Location: ../php/hello.php"));
        }

    }else{
        alert("Invalid UserName or password");
        die(include("../html/signIn.html"));
    }
?>
