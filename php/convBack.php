<?php

    session_start();
    if ($_SESSION['userSessHash'] == "") {

        header('HTTP/1.0 403 Forbidden', TRUE, 403);

        die(header('location: ../html/signIn.html'));
    }


    $msgstr = "";

    $userFr = $_SESSION['chatFr'];

    include 'connect.php';

    $sess = $_SESSION['userSessHash'];
    $q = "SELECT * FROM shashank_Sessions WHERE Session='$sess';";
    $res = $conn->query($q);
    $row = $res->fetch_assoc();
    $user = $row['UserName'];

    $userHash1 = userHash($user, $userFr);
    $userHash2 = userHash($userFr, $user);
    
    $q = "SELECT * FROM shashank_Pairs WHERE UserHash='$userHash1' OR UserHash='$userHash2';";
    $res = $conn->query($q);
    if(mysqli_num_rows($res) == 1){
        $row = $res->fetch_assoc();
        $index = $row['indexInUse'];
        
        $iter = 0;
        while($iter < $index){
            $iter++;
            $msgHash1 = encrMsgInfo($user, $userFr, $iter);
            $msgHash2 = encrMsgInfo($userFr, $user, $iter);

            $q = "SELECT * FROM shashank_Messages WHERE msgHash='$msgHash1' OR msgHash='$msgHash2';";
            $res = $conn->query($q);

            if(mysqli_num_rows($res) == 1){

                $row = $res->fetch_assoc();
                $msgHash = $row['msgHash'];
                $msg = $row['msg'];
                if($msgHash == $msgHash1){
                    $temp = htmlspecialchars($msg);
                    $msgstr .= "////12////$temp";
                    
                }else if($msgHash == $msgHash2){
                    $temp = htmlspecialchars($msg);
                    $msgstr .= "////21////$temp";

                }else{
                    break;
                    die(header("Location: ../html/signIn.html"));
                }

            }else if(mysqli_num_rows($res) < 1){
                break;
            }else{
                $q = "DELETE FROM shashank_Messages WHERE msgHash='$msgHash2';";
                $conn->query($q);
            }

        }
        echo $msgstr;
    }else{
        $q = "DELETE FROM shashank_Pairs WHERE UserHash='$userHash1' OR UserHash='$userHash2';";
        $conn->query($q);
        $q = "INSERT INTO shashank_Pairs (UserHash, indexInUse) VALUES ('$userHash1', 0);";
        $conn->query($q);
    }
    
?>