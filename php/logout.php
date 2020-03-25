<?php
    include 'connect.php';
    session_start();

    $sess = $_SESSION['userSessHash'];

    $q = "SELECT * FROM shashank_Sessions WHERE Session='$sess';";
    $res = $conn->query($q);
    $row = $res->fetch_assoc();
    $user = $row['UserName'];

    setcookie("CIPPreserve", "", time()-3600);
    
    $q = "DELETE FROM shashank_Preserve WHERE UserName='$user';";
    $conn->query($q);

    $q = "DELETE FROM shashank_Sessions WHERE UserName='$user';";
    $conn->query($q);

    $_SESSION['userSessHash'] = "";
    die(header("Location: ../html/signIn.html"));
?>