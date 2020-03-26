<?php

    session_start();
    if ($_SESSION['userSessHash'] == "") {

        header('HTTP/1.0 403 Forbidden', TRUE, 403);

        die(header('location: ../html/signIn.html'));
    }

    
    $userFr = $_GET['frndUsrName'];
    $_SESSION['chatFr'] = $userFr;

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
    }else if(mysqli_num_rows($res) < 1){
        $q = "INSERT INTO shashank_Pairs (UserHash, indexInUse) VALUES ('$userHash1', 0);";
        $conn->query($q);
    }else{
        $q = "DELETE FROM shashank_Pairs WHERE UserHash='$userHash1' OR UserHash='$userHash2';";
        $conn->query($q);
        $q = "INSERT INTO shashank_Pairs (UserHash, indexInUse) VALUES ('$userHash1', 0);";
        $conn->query($q);
    }

?>