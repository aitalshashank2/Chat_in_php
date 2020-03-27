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
                
                $q = "SELECT * FROM shashank_Users;";
                $resUsers = $conn->query($q);

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
        <link rel = "stylesheet" type="text/css" href="../styles/B2.css">

        <script src="../js/landScr.js"></script>

        <script>

            function changeFrName(userFrName, photoStr){

                if(userFrName == "<?php echo htmlspecialchars($user); ?>"){
                    document.getElementById("FrName").textContent = "Self";
                    document.getElementById("FrImg").src = "<?php echo $photo; ?>";
                }else{
                    document.getElementById("FrName").textContent = userFrName;
                    document.getElementById("FrImg").src = photoStr;
                }
                updateUser(userFrName);
            }
            
            function updateUser(userFr){
            
                var xmlHTTP = new XMLHttpRequest();
                xmlHTTP.open("GET", "../php/landingBack.php?frndUsrName=" + userFr, true);
                xmlHTTP.send();
            
            }

            window.onload = function(){
                updateUser("<?php echo htmlspecialchars($user); ?>");
            }

            function sendMsg(){
                var msg = document.getElementById("msgSend").value;
                
                var xmlHTTP = new XMLHttpRequest();
                xmlHTTP.open("POST", "../php/msgEncr.php", true);
                xmlHTTP.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlHTTP.send("chatMsg="+msg);

                document.getElementById("msgSend").value = "";
            }

            function disMessages(){
                var xmlHTTP = new XMLHttpRequest();
                xmlHTTP.onreadystatechange = function(){
                    if(this.readyState == 4 && this.status == 200){
                        var myObj = JSON.parse(this.responseText);

                        var msgIndex = myObj.length - 1;
                        var iter = 1;
                        var dis = document.getElementById("textShow");
                        dis.innerHTML = "";

                        for(iter = 1; iter <= msgIndex; iter++){
                            if(myObj[iter]['12'] !== undefined){
                                
                                var msgHolder = document.createElement("div");
                                msgHolder.classList.add("myWrapCont");
                                msgHolder.textContent = myObj[iter]['12'];
                                
                                var midmsgHolder = document.createElement("div");
                                midmsgHolder.classList.add("myTextBox");
                                midmsgHolder.appendChild(msgHolder);

                                var uppermsgHolder = document.createElement("div");
                                uppermsgHolder.classList.add("myText");
                                uppermsgHolder.appendChild(midmsgHolder);

                                document.getElementById("textShow").appendChild(uppermsgHolder);



                            }else if(myObj[iter]['21'] !== undefined){
                                
                                var msgHolder = document.createElement("div");
                                msgHolder.classList.add("otherWrapContent");
                                msgHolder.textContent = myObj[iter]['21'];
                                
                                var midmsgHolder = document.createElement("div");
                                midmsgHolder.classList.add("otherTextBox");
                                midmsgHolder.appendChild(msgHolder);

                                var uppermsgHolder = document.createElement("div");
                                uppermsgHolder.classList.add("otherText");
                                uppermsgHolder.appendChild(midmsgHolder);

                                document.getElementById("textShow").appendChild(uppermsgHolder);

                            }
                        }

                    }
                };
                xmlHTTP.open("GET", "../php/convBack.php", true);
                xmlHTTP.send();
            }

            setInterval(function(){
                disMessages();
            }, 100);

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
                <a href = "../php/profile.php">Profile</a><hr>
                <a href = "../php/passChange.php">Change Password</a><hr>
                <a href = "../php/logout.php">Logout</a>
            </div>
        </div>

        <div class="container">
            <div class="innerContainer">
                <div id="userPro">
                    <a href="../php/profile.php" style=" grid-area: 1 / 1 / 2 / 2;">
                        <img src = "<?php echo $photo; ?>" style="max-width: 5em; max-height: 3em;">
                    </a>
                    <a href="../php/profile.php" style="grid-area: 1 / 3 / 2 / 4; display:flex; justify-content:center; align-items:center;">
                        <div id="Flash" style="font-size:1.5em; margin:0;"> <?php echo htmlspecialchars($user); ?> </div>
                    </a>
                </div>
                <div id="frndPro">
                    <a href="../php/frndPro.php" style="width:100%; display:grid; grid-template: 1fr / 1fr 5em;">
                        <img src="<?php echo $photo; ?>" style="max-width: 5em; max-height: 3em; grid-area: 1 / 2 / 2 / 3;" id="FrImg">
                        <h2 style="grid-area: 1 / 1 / 2 / 2; display:flex; align-items:center; justify-content:center;" id="FrName">Self</h2>
                    </a>
                </div>
                <div id="frndList">
                    <a onclick="changeFrName('<?php echo htmlspecialchars($user); ?>');">
                        <div class="frndListItem">
                            <div class="frndListImg">
                                <img src="<?php echo $photo; ?>" style="max-height:2.0em; max-width:4em;">
                            </div>
                            <div class="frndListName">
                                Self
                            </div>
                        </div>
                    </a>

                    
                    <!-- Update contact list -->
                    <?php

                        while($row = $resUsers->fetch_assoc()){

                            $userFr = $row['UserName'];
                            $phoFr = $row['Photo'];

                            if(!(strcasecmp($user, $userFr))){
                                continue;
                            }

                            echo '
                            <a onclick="changeFrName(`'.htmlspecialchars($userFr).'`, `'.$phoFr.'`);">
                                <div class="frndListItem">
                                    <div class="frndListImg">
                                        <img src="'.$phoFr.'" style="max-height:2.0em; max-width:4em;">
                                    </div>
                                    <div class="frndListName">
                                        '.htmlspecialchars($userFr).'
                                    </div>
                                </div>
                            </a>
                            ';
                        }
                    ?>


                </div>

                <div id="chat">
                    <div id="textShow">
                        
                    </div>

                    <div id="textIn">
                        <div style="grid-area: 2 / 1 / 3 / 2; display:grid; grid-template: 1fr / 1fr 7em;">
                            <input type="text" style="grid-area: 1 / 1 / 2 / 2; width:95%;" id="msgSend" name="chatMsg" placeholder="Type something">
                            <input type="submit" style="grid-area: 1 / 2 / 2 / 3; width:80%; background:none; font-weight:700;" value="Send" onclick="sendMsg();">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>