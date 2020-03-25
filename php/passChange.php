<?php
    session_start();
    if ($_SESSION['userSessHash'] == "") {

        header('HTTP/1.0 403 Forbidden', TRUE, 403);

        die(header('location: ../html/signIn.html'));
    }
?>

<html>
    <head>
        <title>Chat in PHP</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel = "stylesheet" type="text/css" href="../styles/A1.css">
        <link rel = "stylesheet" type="text/css" href="../styles/B1.css">
        <link rel = "stylesheet" type="text/css" href="../styles/C2.css">

        <script src="../js/landScr.js"></script>
        <script src="../js/PassCheck.js"></script>
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
                <a href = "../php/logout.php">Logout</a>
            </div>
        </div>

        <div id="container">
            <div id="inner">
                <div class="ErrorClass" id="PasswordErr" style="text-align:center;"></div><br>
                <div class="ErrorClass" id="ConfirmErr" style="text-align:center;"></div><br>
                <h1>Change Password</h1><hr><br>
                <div id="formStyle">
                    <div id="formAtt">
                        Previous Password<br>
                        New Password<br>
                        Confirm new Password
                    </div>

                    <div id="formColon">
                        :<br>:<br>:
                    </div>
                    
                    <div id="formForm">
                        <form method="POST" enctype="multipart/form-data" action="../php/passChange.php" name="ChngPass">
                            <input type="password" name="oPass" required><br>
                            <input type="password" name="nPass" required><br>
                            <input type="password" name="CnfnPass" required><br>
                            <input type="submit" value="Confirm" style="background:none; font-weight:700; font-size:1.1em;">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<?php
    include 'connect.php';
    
    $sess = $_SESSION['userSessHash'];
    $q = "SELECT * FROM shashank_Sessions WHERE Session='$sess';";
    $res = $conn->query($q);
    $row = $res->fetch_assoc();
    $user = $row['UserName'];

    $toPass = $_POST['oPass'];
    $tnPass = $_POST['nPass'];
    $tcnfPass = $_POST['CnfnPass'];

    $toPass = "someSalt".$toPass."someSalt";
    $toPass = hash('sha512', $toPass);

    if(($tnPass === $tcnfPass) && (strlen($tnPass) > 8)){
        
        $q = "SELECT * FROM shashank_Users WHERE UserName='$user' AND Password='$toPass';";
        $res = $conn->query($q);

        if(mysqli_num_rows($res) >= 1){
            
            $tnPass = "someSalt".$tnPass."someSalt";
            $tnPass = hash('sha512', $tnPass);

            $q = "UPDATE shashank_Users SET Password='$tnPass' WHERE UserName='$user';";
            if($conn->query($q)){
                die(header("Location: ../php/logout.php"));
            }else{
                alert("Some error occured");
            }

        }else{
            alert("Invalid Old Password");
        }

    }else{
        alert("Please enter a password with more than 8 characters. You will be logged out after password change.");
    }
?>