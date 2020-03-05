<!DOCTYPE html>
<html>

<head>
<title>Building Lookup</title>
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

                if (isset($_COOKIE['cookieun']) and $cookieun != ""){
                    ?>
                        <h2>View a buildings game.</h2>
                        <form name="ucidLook" method="post" action="viewCircle.php">
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

                if (isset($_POST['lookUp']) and ($_POST['lookUp'] == "Look Up")){
                    $building = $_POST['building'];

                    $sql = "SELECT * FROM `RHA Assassin` WHERE `Building` = '". $building ."' AND `Is Alive` = 1 ORDER BY `Kills` DESC";
                    $result = mysqli_query($conn, $sql);
                    if(mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $firstPin = $row["Pin"];
                        $TargetPin = $row['Target Pin'];
                        $Kills = $row['Kills'];
                        $ucid = $row['UCID'];
                        $name = "<img src='pics/$ucid.jpg' class='circlePics' /><br/>" . $row["First Name"] . " " . $row['Last Name'] . " UCID: $ucid, $Kills kills<p>V</p>";
                        if ($firstPin != $TargetPin){
                            echo "<h3>$building Elimination Circle:</h3>";
                            while ($firstPin != $TargetPin){
                                $sql = "SELECT * FROM `RHA Assassin` WHERE `Pin` = $TargetPin";
                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_assoc($result);
                                $TargetPin = $row['Target Pin'];
                                $Kills = $row['Kills'];
                                $ucid = $row['UCID'];
                                echo $name;
                                $name = "<img src='pics/$ucid.jpg' class='circlePics'   /><br/>" . $row["First Name"] . " " . $row['Last Name'] . " UCID: $ucid, $Kills kills<p>V</p>";




                            }
                            echo $name . "<p><a href='#'>Top</a></p>";
                        }else{
                            echo "<h3>Hall winner:</h3><img src='pics/$ucid.jpg' class='circlePics'   /><br/>" . $row["First Name"] . " " . $row['Last Name'] . " UCID: $ucid, $Kills kills";
                            
                        }
                    }
                    $sql = "SELECT * FROM `RHA Assassin` WHERE `Building` = '". $building ."' AND `Is Alive` <> 1 ORDER BY `Kills` DESC";
                    $result = mysqli_query($conn, $sql);
                    if(mysqli_num_rows($result) > 0) {
                        echo "<h3>Dead Players: </h3>";
                        while($row = mysqli_fetch_assoc($result)){
                            $firstPin = $row["Pin"];
                            $TargetPin = $row['Target Pin'];
                            $Kills = $row['Kills'];
                            $ucid = $row['UCID'];
                            echo "<img src='pics/$ucid.jpg' class='circlePics' /><br/>" . $row["First Name"] . " " . $row['Last Name'] . " UCID: $ucid, $Kills kills<br/><br/><br/>";
                        }
                        echo "<a href='#'>Top Of Page</a>";
                    }else{
                        echo "<p>No game in $building</p>";

                    }

                }



            }
            
            
		?>
        
        </div>

		
    </form>
</body>

</html>