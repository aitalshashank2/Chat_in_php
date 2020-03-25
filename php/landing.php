<?php
    include 'connect.php';

    session_start();
    $sessID = $_SESSION['userSessHash'];

    $q1 = "SELECT * FROM shashank_Sessions WHERE Session = '$sessID';";
    $res1 = $conn->query($q1);

    $prior = $_COOKIE['CIPPreserve'];
    $q2 = "SELECT * FROM shashank_Preserve WHERE RetUserHash='$prior';";
    $res2 = $conn->query($q2);

    if(mysqli_num_rows($res1) >= 1 || mysqli_num_rows($res2) >= 1){
        
        //get user
        $q = "SELECT * FROM shashank_Sessions WHERE Session='$sessID';";
        $res = $conn->query($q);
        $row = $res->fetch_assoc();
        $user = $row['UserName'];

        //check if user has a photo indeed
        $q = "SELECT * FROM shashank_Users WHERE UserName='$user';";
        $res = $conn->query($q);
        $row = $res->fetch_assoc();
        $photo = $row['Photo'];
        $contactNo = $row['ContactNo'];
        $fileEx = sizeof(glob($photo));

        if(($photo != null && $contactNo != null)){
            if($fileEx === 1){
                //assign all the variables
            }else{
                die(header("Location: ../php/photoCno.php"));
            }

        }else{
            die(header("Location: ../php/photoCno.php"));
        }

    }else{
        die(header("Location: ../html/signIn.html"));
    }
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Chat in PHP</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel = "stylesheet" type="text/css" href="../styles/A1.css">
        <link rel = "stylesheet" type="text/css" href="../styles/B1.css">

        <script src="../js/landScr.js"></script>
    </head>

    <body>
        <div class="NavBar">
            <div id="NavLand">
                <a href="../php/landing.php"><div class="FlashNav">Chat in PHP</div></a>
            </div>
            <div id="NavOptions">
                <a onclick="TogNavBar();"><img src = "../Assets/settings.png" width="50px" height="auto"></a>
            </div>
        </div>
        <div class="DropDown" id="landDrop">
            <div class="DropDownList">
                <a href = "../php/profile.php">Profile</a><hr>
                <a href = "../php/passChange.php">Change Password</a><hr>
                <a href = "../php/logout.php">Logout</a>
            </div>
        </div>
    </body>
</html>