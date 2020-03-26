<?php
    session_start();
    if ($_SESSION['userSessHash'] == "") {

        header('HTTP/1.0 403 Forbidden', TRUE, 403);

        die(header('location: ../html/signIn.html'));
    }

    include 'connect.php';

    $userFr = $_SESSION['chatFr'];
    if($userFr == "self"){
        die(header("Location: ../php/profile.php"));
    }else{
        
        $q = "SELECT * FROM shashank_Users WHERE UserName='$userFr';";
        $res = $conn->query($q);

        if(mysqli_num_rows($res) >= 1){

            $row = $res->fetch_assoc();
            $email = $row['Email'];
            $gender = $row['Gender'];
            $photo = $row['Photo'];
            $cNo = $row['ContactNo'];

            $userFr = htmlspecialchars($userFr);
            $email = htmlspecialchars($email);

        }else{
            $_SESSION['chatFr'] = "self";
            die(header("Location: ../php/landing.php"));
        }
    }
?>

<html>
    <head>
        <title>Chat in PHP</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel = "stylesheet" type="text/css" href="../styles/A1.css">
        <link rel = "stylesheet" type="text/css" href="../styles/B1.css">
        <link rel = "stylesheet" type="text/css" href="../styles/C1.css">

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
                <a href = "../php/passChange.php">Change Password</a><hr>
                <a href = "../php/logout.php">Logout</a>
            </div>
        </div>

        <div class="mainPlaceholder">
            <div id="ErrSpace">
                <div>
                    <div id="PhoErr" class="ErrorClass"></div><br>
                    <div id="NoErr" class="ErrorClass"></div>
                </div>
            </div>

            <div id="userDetCat">
                UserName<br>
                Email<br>
                Gender<br>
                Contact No
            </div>
            <div id="userColon">
                :<br>:<br>:<br>:
            </div>
            <div id="userDetCat" style="grid-area: 2 / 3 / 3 / 4; text-align:left;">
                <?php echo "$userFr<br>$email<br>$gender<br>$cNo"; ?>
            </div>
            <div id="userPhoto">
                <img src = "<?php echo $photo; ?>" style="max-width: 100%; max-height: 100%;">
            </div>
        </div>
    </body>
</html>