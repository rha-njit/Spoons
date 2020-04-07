<!DOCTYPE html>
<html>

<head>
<title>Ban Player</title>
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
            

            include( "db_connect_info.php" );

			
            

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
           
            // Check connection
            if($conn->connect_error) {

                die("Connection failed: " . $conn->connect_error);

            } else{

                

                if (isset($_POST['logout']) and ($_POST['logout'] == "Log out")){
                    setcookie("cookieun", "", time() - 3600, "/");
                    $cookieun = "";
                }else{
                    $cookieun = $_COOKIE['cookieun'];
                }

                if (isset($_POST['Ban']) and ($_POST['Ban'] == "Ban")){ //ban player
                    $ucid = $_POST['ucid'];

                    $sql = "SELECT * FROM `RHA Assassin` WHERE `UCID` = '". $ucid."'";
                    $result = mysqli_query($conn, $sql);
                    if(mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $name = $row["First Name"] . " " . $row['Last Name'];
                        $pin = $row["Pin"];
                        $TargetPin = $row['Target Pin'];
                        $isAlive = $row['Is Alive'];
                        $building = $row['Building'];

                        $sql = "UPDATE `rha`.`RHA Assassin` SET `Is Alive` = '0' WHERE `RHA Assassin`.`Pin` = " . $pin; //kill person
                        $result2 = mysqli_query($conn, $sql);

                        $sql = "UPDATE `rha`.`RHA Assassin` SET `Target Pin` = '0' WHERE `RHA Assassin`.`Pin` = " . $pin; 
                        $result2 = mysqli_query($conn, $sql);

                        $sql = "UPDATE `rha`.`RHA Assassin` SET `Target Pin` = ". $TargetPin . " WHERE `RHA Assassin`.`Target Pin` = " . $pin; 
                        //Find the assassin and update their target with thier target's target.
                        $result2 = mysqli_query($conn, $sql);
                        
                        echo "<p>Player: " . $ucid . " banned</p>";
                        
                    }else{
                        echo "<p>Player: " . $ucid . " does not exsit</p>";
                    }

                }



            }
            
            if (isset($_COOKIE['cookieun']) and $cookieun != ""){
                ?>
                    <h2>Ban Player</h2>
                    <form name="ucidLook" method="post" action="banConfirmation.php">
                        <h3>UCID</h3>
                        <p>
                            <input id="ucid" name="ucid" type="text" />
                        </p>
                        <br />
                        <p>
                            <input type="submit" name="Ban" value="Ban"  />
                        </p>
                        <p>
                            <input type="submit" name="logout" value="Log out"  />
                        </p>
                        <br />
                        <p><a href="addPlayer.php">Admin Home</a></p>
                
                    </form>
                <?php
            }else{
                header('Location: addPlayer.php'); 
        
              
            }
		?>
        
        </div>

		
    </form>
</body>

</html>