<!DOCTYPE html>
<html>

<head>
<title>Statistics</title>
<meta name="author" content="Jason A. Laboy">
<script type="text/javascript">
    setTimeout(function () { 
      location.reload();
    }, 120 * 1000);
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

                

                



            }
            
            if (isset($_COOKIE['cookieun']) and $cookieun != ""){
                ?>
                    <h2>Statistics</h2>
                    <form>
                        <p><a href="addPlayer.php">Admin Home</a></p>
                    </form>
                <?php

                function printHallLeader($buildingTo){
                    //$servername = "sql1.njit.edu";
                    //$username = "rha";
                    //$password = "xghZnL9vN";
                    //$dbname = "rha";
                    global $conn ;//= new mysqli($servername, $username, $password, $dbname);


                    $sql = "SELECT * FROM `RHA Assassin` WHERE `Building` = '$buildingTo' ORDER BY `RHA Assassin`.`Kills` DESC";
                    $result = mysqli_query($conn, $sql);
                    if(mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        if ($row['Kills'] > 0){
                            echo "<h4>" . $row['Building'] . ": " . $row['First Name'] . " " . $row['Last Name'] . ", UCID: " . $row['UCID'] . ", Kills: " . $row['Kills'] . "</h4>";
                        }
                    }
                }

                $sql = "SELECT `Building`, `Is Alive`, COUNT(`UCID`) FROM `RHA Assassin` WHERE `Building` <> 'Test' GROUP BY `Building`, `Is Alive`";
                //$sql = "SELECT `Building`, COUNT(`UCID`) FROM `RHA Assassin` WHERE `Building` <> 'Test' GROUP BY `Building`";
                $result = mysqli_query($conn, $sql);
                if(mysqli_num_rows($result) > 0) {
                    $total = 0;
                    $prebuild = "";
                    $building = "";
                    $dead = 0;
                    $alive = 0;
                    $isFirst = 1;

                    echo "<h3>Number of players per hall:</h3><div class='statsDiv'>";
                    while($row = mysqli_fetch_assoc($result)){
                        $buidling = $row['Building'];
                        if ($buidling != $prebuild and $isFirst == 0){
                            echo "<div><h4>" . $prebuild . "<br/>Alive: " . $alive . "<br/>Dead: $dead <br/>Total: " .  ($alive + $dead) . "</h4></div>";
                            $dead = 0;
                            $alive = 0;
                        }
                        $isFirst = 0;
                        
                        if ($row['Is Alive'] == 0){
                            $dead = $row['COUNT(`UCID`)'];
                            $totalPlayers += $dead;
                        }
                        if ($row['Is Alive'] == 1){
                            //$row = mysqli_fetch_assoc($result);
                            $count = $row['COUNT(`UCID`)'];
                            $totalPlayers += $count;
                            $totalAlive += $count;
                            $alive = $count;
                        }

                        if ($row['Is Alive'] == 2){
                            $count = $row['COUNT(`UCID`)'];
                            $dead += $count;
                            $totalPlayers += $count;

                        }
                        
                        
                        $prebuild = $buidling;
                        
                    }
                    echo "<div><h4>" . $prebuild . "<br/>Alive: " . $alive . "<br/>Dead: $dead <br/>Total: " .  ($alive + $dead) . "</h4></div></div>";
                    echo "<h4>Total Alive: $totalAlive<br/> Total Dead: " . ($totalPlayers - $totalAlive). "<br/> Total Players: $totalPlayers </h4>";
                }
                
                echo "<h3>Kill Leaders:</h3>";
                printHallLeader('Cypress');
                printHallLeader('Honors');
                printHallLeader('Laurel');
                printHallLeader('Oak');
                printHallLeader('Redwood');
                printHallLeader('The Master Round');

                ?>
                    
                    <h3>Elimination Feed:</h3>
                <?php
                //SELECT * FROM `RHA Assassin` ORDER BY `RHA Assassin`.`Time Of Death` DESC
                $sql = "SELECT * FROM `RHA Assassin` WHERE `Is Alive` <> 1 ORDER BY `RHA Assassin`.`Time Of Death` DESC";
                //$sql = "SELECT `Building`, COUNT(`UCID`) FROM `RHA Assassin` WHERE `Building` <> 'Test' GROUP BY `Building`";
                $result = mysqli_query($conn, $sql);
                if(mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)){
                        if ($row['Time Of Death'] != "0000-00-00 00:00:00" and $row['Is Alive'] != 2){
                            $date = new DateTime($row['Time Of Death'], new DateTimeZone('GMT'));
                            $date->setTimezone(new DateTimeZone('GMT-4'));

                            echo "<h3> " . $row['First Name'] . " " . $row['Last Name'] . " of " . $row['Building'] . " was eliminated at: " . $date->format('h:i:sa') . " on " . $date->format('m-d-y') . "</h3>";
                        }else if ($row['Is Alive'] == 2){

                            echo "<h3> " . $row['First Name'] . " " . $row['Last Name'] . " of " . $row['Building'] . " has been blown to dust.</h3>";
                            

                        }
                    }
                }


            }else{
                header('Location: addPlayer.php'); 
        
              
            }
		?>
        </div>

		
    </form>
</body>

</html>