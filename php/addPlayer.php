<!DOCTYPE html>
<html>

<head>
<title>Admin Home</title>
<meta name="author" content="Jason A. Laboy">
<script>

</script>

<link rel="stylesheet" type="text/css" href="MainStyle.css">
<link rel="shortcut icon" href="images/RHAlogo.jpg" type="image/x-icon"/>
</head>

<body>
    
    <div id="centerBox">
            <div class="Header">
                <a class="Logo" href='index.php' style="text-decoration:none;">
                    <div>
                        <img src="images/RHAlogo.jpg"  />
                    </div>
                    <div class="hWords">Spoons Game!</div>
                </a>
            </div>
        <?php

            
            
            $br = "<br />"; $hr = "<hr />";
            

            $servername = "sql1.njit.edu";
            $username = "rha";
            $password = "xghZnL9vN";
            $dbname = "rha";
            $cookieun = "aa";
            

			
            

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
           
            
            // Check connection
            if($conn->connect_error) {

                die("Connection failed: " . $conn->connect_error);

            } else{

                if (isset($_POST['banHammer']) and ($_POST['banHammer'] == "*Snap*")){  //activate snap

                    $building = $_POST['building'];
                    $Kills = $_POST['kills'];


                    $pin= 0;
                    $targetPin = 0;
                    
                    $sql = "SELECT * FROM `RHA Assassin` WHERE `Kills` < " . $Kills . " AND `Is Alive` = 1 AND `Building` = '" . $building . "'";
                    $result = mysqli_query($conn, $sql);

                    if(mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)){
                            $pinsToSnap[] = $row['Pin'];
                        }
                    }

                    echo "<p>Players Killed:</p>";
                    foreach($pinsToSnap as $pinToKill){
                            $sql = "SELECT * FROM `RHA Assassin` WHERE `Pin` = $pinToKill";
                            $result2 = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($result2);
                            $targetPin = $row['Target Pin'];
                            $name = $row['First Name'] . " " . $row["Last Name"];
                            echo "<p>$name</p>";

                            $sql = "UPDATE `rha`.`RHA Assassin` SET `Is Alive` = '2' WHERE `RHA Assassin`.`Pin` = " . $pinToKill; //kill person
                            $result2 = mysqli_query($conn, $sql);

                            $sql = "UPDATE `rha`.`RHA Assassin` SET `Target Pin` = '0' WHERE `RHA Assassin`.`Pin` = " . $pinToKill; 
                            $result2 = mysqli_query($conn, $sql);

                            $sql = "UPDATE `rha`.`RHA Assassin` SET `Time Of Death` = '". date("y-m-d H:i:s") . "' WHERE `RHA Assassin`.`Pin` = " . $pinToKill; 
                            $result = mysqli_query($conn, $sql);

                            $sql = "UPDATE `rha`.`RHA Assassin` SET `Target Pin` = " . $targetPin . " WHERE `RHA Assassin`.`Target Pin` = " . $pinToKill; 
                            //Find the assassin and update their target with thier target's target.
                            $result2 = mysqli_query($conn, $sql);  
                    }
                    


                }

                if (isset($_POST['logout']) and ($_POST['logout'] == "Log out")){ //check login cookie
                    setcookie("cookieun", "", time() - 3600, "/");
                    $cookieun = "";
                }else{
                    $cookieun = $_COOKIE['cookieun'];
                }

                if (isset($_POST['addPlayerSubmit']) and ($_POST['addPlayerSubmit'] == "Add Player")){ //add player to the game
                    $targetPin = 0;
                    $building = $_POST['building'];
                    $fname = $_POST['firstName'];
                    $lname = $_POST['lastName'];
                    $ucid =  str_replace(' ', '', strtolower($_POST['ucid']));

                    if ($fname != "" and $lname != "" and $ucid != "" and $building != "None"){

                        $target_dir = "pics/";
                        $target_file = $target_dir . basename($_FILES["pic"]["name"]);
                        $uploadOk = 1;
                        $pictureExt = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                        $tf = $target_dir . $ucid . "." . $pictureExt;

                        $check = getimagesize($_FILES["pic"]["tmp_name"]);

                        if($check !== false) {
                            //echo "File is an image - " . $check["mime"] . ".";
                            $uploadOk = 1;
                        } else {
                            echo "File is not an image.";
                            $uploadOk = 0;
                        }

                        if ($uploadOk == 0) {
                            echo "Sorry, your file was not uploaded.";
                        // if everything is ok, try to upload file
                        } else {
                            if (move_uploaded_file($_FILES["pic"]["tmp_name"], $tf)) {
                                //echo "The file ". basename( $_FILES["pic"]["name"]). " has been uploaded.";
                                $filename = $tf; /*ADD YOUR FILENAME WITH PATH*/
                                $exif = exif_read_data($filename);
                                $ort = $exif['Orientation']; /*STORES ORIENTATION FROM IMAGE */
                                $ort1 = $ort;
                                $exif = exif_read_data($filename, 0, true);
                                if (!empty($ort1))
                                {
                                    $image = imagecreatefromjpeg($filename);
                                    $ort = $ort1;
                                        switch ($ort) {
                                            case 3:
                                                $image = imagerotate($image, 180, 0);
                                                break;
                            
                                            case 6:
                                                $image = imagerotate($image, -90, 0);
                                                break;
                            
                                            case 8:
                                                $image = imagerotate($image, 90, 0);
                                                break;
                                        }
                                }
                                imagejpeg($image,$filename, 90);
                            
                                $digit = 0;
                                $sql = "SELECT * FROM `RHA Assassin` WHERE `UCID` = '". $ucid."'";
                                $result = mysqli_query($conn, $sql);
                                if(mysqli_num_rows($result) > 0) {
                                    echo "<p>Player already exists.</p>";
                                }else{

                                    switch ($building){
                                        case "Cypress": 
                                            $digit = 1;
                                            break;
                                        case "Honors": 
                                            $digit = 2;
                                            break;
                                        case "Oak": 
                                            $digit = 3;
                                            break;
                                        case "Laurel": 
                                            $digit = 4;
                                            break;
                                        case "Redwood": 
                                            $digit = 5;
                                            break;
                                        case "Test": 
                                            $digit = 6;
                                            break;
                                        case "RHA": 
                                            $digit = 7;
                                            break;
                                        case "The Master Round": 
                                            $digit = 8;
                                            break;
                                    }
                                    $digit = $digit * 1000;

                                    do {
                                        $pin = rand(10,99) * 10000 + $digit + rand(0,999);
                                        $sql = "SELECT `Pin` FROM `RHA Assassin` WHERE `Pin` = " . $pin;
                                        $result = mysqli_query($conn, $sql);

                                    }while(mysqli_num_rows($result) > 0); 

                                    $sql = "SELECT `Pin`,`Target Pin` FROM `RHA Assassin` WHERE `Building` = '$building' AND `Is Alive` = 1 ORDER BY RAND()";
                                    $result = mysqli_query($conn, $sql);

                                    if (mysqli_num_rows($result) > 0){
                                        $row = mysqli_fetch_assoc($result);
                                        $assassinPin = $row['Pin'];
                                        $targetPin = $row['Target Pin'];

                                        $sql = "UPDATE `rha`.`RHA Assassin` SET `Target Pin` = '". $pin ."' WHERE `RHA Assassin`.`Pin` = " . $assassinPin; //update assassins target
                                        $result = mysqli_query($conn, $sql);

                                        $sql = "SELECT `First Name`, `Last Name` FROM `RHA Assassin` WHERE `Pin` = ". $targetPin; //Retreave new targets name
                                        $result = mysqli_query($conn, $sql);
                                        $row = mysqli_fetch_assoc($result);
                                        $targetsName = $row['First Name'] . " " . $row['Last Name'];

                                    }else{
                                        $targetPin = $pin;
                                    }

                                    $sql = "INSERT INTO `rha`.`RHA Assassin` (`First Name`, `Last Name`, `UCID`, `Pin`, `Target Pin`, `Is Alive`, `Building`, `Kills`, `Time Of Death`) VALUES ('" . $fname ."', '". $lname ."', '". $ucid."', '" . $pin ."', '" . $targetPin ."', '1', '". $building ."', '0', '0');";
                                    $result = mysqli_query($conn, $sql);
                                    echo "<p>Player Added</p><p>Name: $fname $lname </p><p>UCID: $ucid</p>"; 
                                    echo "<p>Pin: $pin </p>";
                                }
                            } else {
                                echo "Sorry, there was an error uploading your file.";
                            }
                        }
                    }else{
                        echo "<p>Please enter valid information.</p>";
                    }
                }
            

                if (isset($_POST['submit'])){ //login to the admin mode

                    if ($_POST['submit'] == "login"){

                        $ReceivedUser = $_POST['ucid'];
                        $ReceivedPass = $_POST['password'];

                        $sql = "SELECT * FROM `RHA Admins`";
                        $result = mysqli_query($conn, $sql);

                        //Search through database for matching UserID, pull stored password if match found
                        if(mysqli_num_rows($result) > 0) {

                            while($row = mysqli_fetch_assoc($result)){
                                $storedpass = $row['password'];
                                $storeducid = $row['ucid'];
                                //echo $storeducid . " : " . $storedpass . "<br/>";
                                if( $storeducid == $ReceivedUser){   
                                    break;

                                }

                            }

                        } 
                        if($ReceivedPass == $storedpass){
                            $cookieun = $ReceivedPass;
                            setcookie('cookieun', $cookieun, time() + (8640), "/");
                        }else {
                            $cookieun = "";
                            echo "<p style=\"color: red;\">Invaid username/password.</p>";
                        }
                    }
                }
            }
            
            if (isset($_COOKIE['cookieun']) and $cookieun != ""){ //check if loged in and display admin home
                ?>
                    <h2>Add Player</h2>
                    <form name="addPlayer" method="post" action="addPlayer.php" enctype="multipart/form-data">
                        <h3>First Name</h3>
                        <p>
                        <input name="firstName" type="text" />
                        </p>
                        <h3>Last Name</h3>
                        <p>
                        <input name="lastName" type="text" />
                        </p>
                        <h3>UCID</h3>
                        <p>
                        <input name="ucid" type="text" />
                        </p>
                        
                        <h3>Building</h3>
                        <p>
                        <select type="dropdown" name="building" id="building" >
                            <option value="None">Select</option>
                            <option value="Cypress">Cypress</option>
                            <option value="Honors">Honors</option>
                            <option value="Laurel">Laurel</option>
                            <option value="Oak">Oak</option>
                            <option value="Redwood">Redwood</option>
                            <option value="The Master Round">The Master Round</option>
                            <option value="Test">Test</option>
                            <option value="RHA">RHA</option>
                        </select>
                        </p>
                        
                        <h3>Player picture</h3>
                        <p>
                            <input type="file" name="pic" id="pic" accept="image/jpg">
                        </p>
                        <br />
                        <p>
                        <input type="submit" name="addPlayerSubmit" value="Add Player"  />
                        </p>
                        <p>
                        <input type="submit" name="logout" value="Log out"  />
                        </p>
                        <br />
                        <p>Admin Tools:</p>
                        <p><a href="thanosSnap.php">Thanos Snap</a></p>
                        <p><a href="banHammer.php">Ban Player</a></p>
                        <p><a href="lookUp.php">Player Look Up</a></p>
                        <p><a href="rndtargets.php">Randomize Targets</a></p>
                        <p><a href="stats.php">Statistics</a></p>
                        <p><a href="viewCircle.php">View Building</a></p>
                    </form>
                <?php
            }else{ //if not loged in go to login page
                
                header('Location: adminlogin.php'); 
        
            }

        ?>
    </div>

</body>

</html>