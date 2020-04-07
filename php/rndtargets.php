<!DOCTYPE html>
<html>

<head>
<title>Randomize Targets</title>
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

                if (isset($_POST['randomize']) and ($_POST['randomize'] == "randomize")){
                    $bulding = $_POST['building'];

                    $sql = "SELECT * FROM `RHA Assassin` WHERE `Building` = '$bulding' AND `Is Alive` = 1 GROUP BY RAND()";
                    $result = mysqli_query($conn, $sql);
                    if(mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)){
                            $pins[] = $row['Pin'];
                        }

                        for ($i = 0; $i < sizeof($pins) - 1; $i++){
                            $sql = "UPDATE `rha`.`RHA Assassin` SET `Target Pin` = " . $pins[$i + 1]." WHERE `RHA Assassin`.`Pin` = " . $pins[$i]; 
                            $result = mysqli_query($conn, $sql); 
                        }
                        echo "<h3>Targets Radomized!</h3>";
                        $sql = "UPDATE `rha`.`RHA Assassin` SET `Target Pin` = " . $pins[0]." WHERE `RHA Assassin`.`Pin` = " . $pins[$i]; 
                        $result = mysqli_query($conn, $sql); 

                    }else{
                        echo "<h3>No one to randomize<h3>";
                    }

                }



            }
            
            if (isset($_COOKIE['cookieun']) and $cookieun != ""){
                ?>
                    <h2>Randomize Targets</h2>
                    <form name="ucidLook" method="post" action="rndtargets.php">
                        <h3>Select a building to randomize</h3>
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
                        <br />
                        <p>
                        <input type="submit" name="randomize" value="randomize"  />
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