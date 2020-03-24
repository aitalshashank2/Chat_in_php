<?php
    include 'connect.php';

    session_start();
    $sessID = $_SESSION['userSessHash'];

    $q = "SELECT * FROM shashank_Sessions WHERE Session = '$sessID';";
    $res = $conn->query($q);

    //Cookie generation
    if($_SESSION['RememberStatus'] == 1){
        $h = RandHashGen();
        $i = 0;
        while($row = mysqli_fetch_assoc($res)){
            $usrName[$i] = $row['UserName'];
            $i = $i + 1;
        }
        $user = $usrName[0];
        $t = time() + 2*86400;

        $q = "DELETE FROM shashank_Preserve WHERE UserName='$user'";
        $conn->query($q);

        $q = "INSERT INTO shashank_Preserve (RetUserHash, UserName, ExpTime) VALUES ('$h', '$user', $t);";
        $conn->query($q);

        setcookie('CIPPreserve', $h, $t);

        $_SESSION['RememberStatus'] = 0;
    }

    if(mysqli_num_rows($res) >= 1){
        die(header('Location: ../php/landing.php'));
    }else{

        $prior = $_COOKIE['CIPPreserve'];
        $q = "SELECT * FROM shashank_Preserve WHERE RetUserHash='$prior';";
        $res = $conn->query($q);
        if(mysqli_num_rows($res) >= 1){
            die(header('Location: ../php/landing.php'));
        }else{        
            die(header("Location: ../html/signIn.html"));
        }
    }
?>