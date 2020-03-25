<?php
    include '../php/connect.php';
    
    if(isset($_POST['Uname']) && isset($_POST['SUemail']) && isset($_POST['SignUpPass']) && isset($_POST['SignUpPassCnf']) && isset($_POST['sex'])){
        $userName = $_POST['Uname'];
        $email = $_POST['SUemail'];
        $Pass = $_POST['SignUpPass'];
        $CnfPass = $_POST['SignUpPassCnf'];
        $Gender = $_POST['sex'];

        if(preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)){

            if($Gender === 'M' || $Gender === 'F' || $Gender === 'O'){

                if(($Pass === $CnfPass) && (strlen($Pass) > 8)){
                    
                    $q = "SELECT * FROM shashank_Users WHERE Email = '$email';";
                    $r = $conn->query($q);
                    if(mysqli_num_rows($r) >= 1){
                        header("Location: ../html/signUp.html");
                        die("Account with this email already exists");
                    }
                    $q = "SELECT * FROM shashank_Users WHERE UserName = '$userName';";
                    $r = $conn->query($q);
                    if(mysqli_num_rows($r) >= 1){
                        header("Location: ../html/signUp.html");
                        die("Account with this userName already exists");
                    }else{
                        $Pass = 'someSalt'.$Pass.'someSalt';
                        $Pass = hash('sha512', $Pass);

                        $query = "INSERT INTO shashank_Users (UserName, Password, Email, Gender) VALUES ('$userName', '$Pass', '$email', '$Gender');";
                        $res = $conn->query($query);
                        header("Location: ../html/signIn.html");
                        die("User Signed Up");
                    }

                }else{
                    header("Location: ../html/signUp.html");
                    die("Password Mismatch");
                }

            }else{
                header("Location: ../html/signUp.html");
                die("Invalid Gender");
            }

        }else{
            header("Location: ../html/signUp.html");
            die("Invalid Email received");
        }
    }else{
        header("Location: ../html/signUp.html");
        die("Bad parameters");
    }
?>