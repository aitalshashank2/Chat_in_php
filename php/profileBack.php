<?php
    session_start();
    if ($_SESSION['userSessHash'] == "") {

        header('HTTP/1.0 403 Forbidden', TRUE, 403);

        die(header('location: ../html/signIn.html'));
    }

    include 'connect.php';

    $user = $_POST['Uname'];
    $email = $_POST['email'];
    $gender = $_POST['Sex'];
    $ContactNo = $_POST['ContactNo'];
    $pho = $_FILES['ProPhoto'];

    $sess = $_SESSION['userSessHash'];
    $q = "SELECT * FROM shashank_Sessions WHERE Session='$sess';";
    $res = $conn->query($q);
    $row = $res->fetch_assoc();
    $dbUser = $row['UserName'];

    $q = "SELECT * FROM shashank_Users WHERE UserName='$dbUser';";
    $res = $conn->query($q);
    $row = $res->fetch_assoc();
    $dbEmail = $row['Email'];

    if($user == $dbUser && $email == $dbEmail){


        if($gender == 'M' || $gender == 'F' || $gender == 'O'){

            if(floor($ContactNo / 1000000000) != 0 && floor($ContactNo / 10000000000) == 0){

                if($pho['name']){

                    $name = $pho['name'];
                    $ext = pathinfo($name, PATHINFO_EXTENSION);
                    
                    if ($file["size"] > 50000) {
                        alert("Sorry, your file is too large.");
                        die();
                    }

                    if($ext === "png" || $ext === "jpg" || $ext === "jpeg"){
                        
                        $nameFile = hash('md5', $dbUser);

                        array_map('unlink', glob("../Photos/$nameFile.*"));

                        $target_file = "../Photos/$nameFile.$ext";
                        if(move_uploaded_file($pho["tmp_name"], $target_file)){
                            $q = "UPDATE shashank_Users SET Photo='$target_file', ContactNo='$ContactNo', Gender='$gender' WHERE UserName='$dbUser';";
                            if($conn->query($q)){
                                $newSess = RandHashGen();
                                $_SESSION['userSessHash'] = $newSess;

                                $qs = "UPDATE shashank_Sessions SET Session='$newSess' WHERE UserName='$user';";
                                if($conn->query($qs)){
                                    die(header("Location: ../php/profile.php"));
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
                        alert("Invalid file format");
                        die(header("Location: ../php/profile.php"));
                    }

                }else{
                    
                    $q = "UPDATE shashank_Users SET Gender='$gender', ContactNo='$ContactNo' WHERE UserName='$dbUser';";
                    $conn->query($q);
                    die(header("Location: ../php/profile.php"));

                }

            }else{
                alert("Invalid Contact Number");
                die(header("Location: ../php/profile.php"));
            }

        }else{
            alert("Invalid gender");
            die(include("../html/signIn.html"));
        }


    }else{
        alert("Invalid current user or email");
        die(include('../html/signIn.html'));
    }
?>
