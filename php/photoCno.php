<?php
    session_start();
    if ($_SESSION['userSessHash'] == "") {

        header('HTTP/1.0 403 Forbidden', TRUE, 403);

        die(header('location: ../html/signIn.html'));
    }
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Chat in PHP</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel = "stylesheet" type="text/css" href="../styles/A1.css">
        <script src="../js/fileExtension.js"></script>
    </head>

    <body>
        <div id="Flash">Chat in PHP</div>

        <div class="fillForm">
            <div class="MForm">
                <form method="POST" name="FileExt" action="../php/photoCno.php" enctype="multipart/form-data" id="SubForm">
                    <h1>Welcome, user</h1><hr><br>
                    Please set up your Profile Photo and Contact Number here.
                    <br><br>
                    Profile Photo: &ensp;<input type="file" name="ProPhoto" required><br>
                    <div id="PhoErr" class="ErrorClass"></div><br>
                    Contact Number: <input type="number" name="ContactNo" placeholder="1234567890" required><br>
                    <div id="NoErr" class="ErrorClass"></div><br>

                    <h2 style="text-align: center;"><input type="submit" value="Submit"></h2>
                </form><br>
            </div>

        </div>
    </body>
</html>

<?php

    include 'connect.php';
    $file = $_FILES['ProPhoto'];
    $num = $_POST['ContactNo'];

    $name = $file['name'];
    $ext = pathinfo($name, PATHINFO_EXTENSION);

    //BACKEND VALIDATION

    if ($file["size"] > 50000) {
        alert("Sorry, your file is too large.");
        die();
    }

    if($ext !== "png" && $ext !== "jpg" && $ext !== "jpeg"){
        alert("Please enter an image file in png, jpg or jpeg formats only");
        die();
    }else if(floor($num / 1000000000) != 0 && floor($num / 10000000000) == 0){


        $sess = $_SESSION['userSessHash'];

        $q = "SELECT * FROM shashank_Sessions WHERE Session='$sess';";
        $res = $conn->query($q);
        $row = $res->fetch_assoc();
        $user = $row['UserName'];

        $nameFile = hash('md5', $user);

        array_map('unlink', glob("../Photos/$nameFile.*"));

        $target_file = "../Photos/$nameFile.$ext";
        if(move_uploaded_file($file["tmp_name"], $target_file)){
            $q = "UPDATE shashank_Users SET Photo='$target_file', ContactNo='$num' WHERE UserName='$user';";
            if($conn->query($q)){
                $newSess = RandHashGen();
                $_SESSION['userSessHash'] = $newSess;

                $qs = "UPDATE shashank_Sessions SET Session='$newSess' WHERE UserName='$user';";
                if($conn->query($qs)){
                    die(header("Location: ../html/welcome.html"));
                }else{
                    die(alert("Some Error Occured"));
                }

            }else{
                 die(alert("Some Error occured in populating database"));
            }
        }else{
            alert("Some Error occured");
            die();
        }

    }else{
        alert("Please enter a valid contact number number");
        die();
    }

?>