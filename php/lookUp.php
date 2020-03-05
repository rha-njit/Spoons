<!DOCTYPE html>
<html>

<head>
<title>Player Lookup</title>
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

                if (isset($_POST['lookUp']) and ($_POST['lookUp'] == "Look Up")){
                    $ucid = strtolower($_POST['ucid']);

                    $sql = "SELECT * FROM `RHA Assassin` WHERE `UCID` = '". $ucid."'";
                    $result = mysqli_query($conn, $sql);
                    if(mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $name = $row["First Name"] . " " . $row['Last Name'];
                        $pin = $row["Pin"];
                        $TargetPin = $row['Target Pin'];
                        $isAlive = $row['Is Alive'];
                        $building = $row['Building'];
                        $Kills = $row['Kills'];
                        $tod = $row['Time Of Death'];
                        echo "<h3>UCID: $ucid</h3>";
                        echo "<h3>Name: $name</h3>";
                        echo "<h3>Bulding: $building</h3>";
                        echo "<h3>Pin: $pin</h3>";
                        echo "<h3>Kills: $Kills</h3>";
                        echo "<img width='500px' class='targetPic' src='pics/$ucid.jpg' alt='$ucid'/>";
                        if ($isAlive == 0){
                            echo "<h3>Is Dead</h3>";
                            echo "<h3>Time of death: $tod</h3>";
                        }else{
                            echo "<h3>Is Alive</h3>";
                            echo "<h3>Targets Pin: $TargetPin</h3>";
                           
                            $sql = "SELECT * FROM `RHA Assassin` WHERE `Pin` = ". $TargetPin; //Retreave  targets name
                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($result); //retreave Assassin information
                            $tname = $row['First Name'] . " " . $row['Last Name'];
                            $tucid = $row['UCID'];
                            
                            echo "<h3>Targets Name: $tname</h3>";
                            echo "<h3>Targets UCID: $tucid</h3>";
                            echo "<img width='500px' class='targetPic' src='pics/$tucid.jpg' alt='$tucid'/>";

                        }
                    }else{
                        echo "<p>Player: " . $ucid . " does not exsit</p>";
                    }

                }



            }
            
            if (isset($_COOKIE['cookieun']) and $cookieun != ""){
                ?>
                    <h2>Player Look Up</h2>
                    <form name="ucidLook" method="post" action="lookUp.php">
                        <h3>UCID</h3>
                        <p>
                            <input id="ucid" name="ucid" type="text" />
                        </p>
                        <br />
                        <p>
                        <input type="submit" name="lookUp" value="Look Up"  />
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