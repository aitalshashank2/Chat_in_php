<?php
    session_start();
    if ($_SESSION['userSessHash'] == "") {

        header('HTTP/1.0 403 Forbidden', TRUE, 403);

        die(header('location: ../html/signIn.html'));
    }

    include 'connect.php';

    $userFr = $_SESSION['chatFr'];
    $sess = $_SESSION['userSessHash'];

    $q = "SELECT * FROM shashank_Users WHERE UserName='$userFr';";
    $res = $conn->query($q);
    if(mysqli_num_rows($res) >= 1){

        $q = "SELECT * FROM shashank_Sessions WHERE Session='$sess';";
        $res = $conn->query($q);
        $row = $res->fetch_assoc();
        $user = $row['UserName'];

        $msg = $_POST['chatMsg'];
        
        if(trim($msg) != ""){
            $userHash1 = userHash($user, $userFr);
            $userHash2 = userHash($userFr, $user);
            $q = "SELECT * FROM shashank_Pairs WHERE UserHash='$userHash1' OR UserHash='$userHash2';";
            $res = $conn->query($q);

            if(mysqli_num_rows($res) == 1){
                $row = $res->fetch_assoc();
                $userHash = $row['UserHash'];
                $index = $row['indexInUse'] + 1;

                $msgHash = encrMsgInfo($user, $userFr, $index);

                $q = "INSERT INTO shashank_Messages (msgHash, msg) VALUES ('$msgHash', '$msg');";
                $conn->query($q);

                $q = "UPDATE shashank_Pairs SET indexInUse = $index WHERE UserHash = '$userHash';";
                $conn->query($q);

                die(header("Location: ../php/landing.php"));
                
            }else{
                die(header("Location: ../php/landing.php"));
            }
            

        }else{
            die(header("Location: ../php/landing.php"));
        }
        
    }else{
        die(header("Location: ../php/landing.php"));
    }
?>