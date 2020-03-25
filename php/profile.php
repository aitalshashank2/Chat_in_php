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

        $q = "SELECT * FROM shashank_Users WHERE UserName='$user';";
        $email = "";
        $gender = "";
        $ContactNo = "";
        
        if($res = $conn->query($q)){


            $row = $res->fetch_assoc();
            $email = $row['Email'];
            $gender = $row['Gender'];
            $pho = $row['Photo'];
            $ContactNo = $row['ContactNo'];


        }else{
            die(header("Location: ../html/signIn.html"));
        }


    }else{
        die(header("Location: ../html/signIn.html"));
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
        <script src="../js/fileExtension.js"></script>

        <script>
            function setGender(){
                var gen = '<?php echo $gender;?>';
                var sel = document.getElementById("Sex");
                switch(gen){
                    case 'M':
                        sel.selectedIndex = "0";
                        break;
                    case 'F':
                        sel.selectedIndex = "1";
                        break;
                    case 'O':
                        sel.selectedIndex = "2";
                        break;
                    default:
                        sel.selectedIndex = "0";
                }
            }

            window.onload = function(){
                setGender();
            };
        </script>
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
                Contact No<br>
                Profile Photo
            </div>
            <div id="userColon">
                :<br>:<br>:<br>:<br>:
            </div>
            <div id="userDetVal">
                <form method="POST" enctype="multipart/form-data" id="FileExt" action="../php/profileBack.php">
                    <input type="text" name="Uname" value="<?php echo $user; ?>" readonly><br>
                    <input type="email" name="email" value="<?php echo $email; ?>" required readonly><br>
                    <select name="Sex" id="Sex">
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                        <option value="O">Other</option>
                    </select>
                    <input type="number" name="ContactNo" value= "<?php echo $ContactNo; ?>" required >
                    <input type="file" name="ProPhoto">
                    <input type="submit" value="Change" style="font-weight:700; background:none; font-size:1.1em;">
                </form>
            </div>
            <div id="userPhoto">
                <img src = "<?php echo $pho; ?>" style="max-width: 100%; max-height: 100%;">
            </div>
        </div>
    </body>
</html>