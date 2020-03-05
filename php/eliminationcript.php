<!DOCTYPE html>
<html>

    <head>
        <title>elimination</title>
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

                $cookieun = "";	
                if (isset($_COOKIE['cookieun'])){
                    $cookieun = $_COOKIE['cookieun'];
                }


                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);
                
                // Check connection
                if($conn->connect_error) {

                    die("Connection failed: " . $conn->connect_error);

                } else{

                    //Receive Credentials via POST 
                    if (isset($_POST['pin'])){
                        $pin= $_POST['pin'];
                        $targetPin = $_POST['tPin'];
                        //echo $pin;
                        
                        
                        $sql = "SELECT * FROM `RHA Assassin` WHERE `Pin` = ". $pin." AND `Target Pin` = " . $targetPin . " AND `Is Alive` = 1";
                        $result = mysqli_query($conn, $sql);

                        if(mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            $kills = $row['Kills'] + 1;

                            $sql = "UPDATE `rha`.`RHA Assassin` SET `Is Alive` = '0' WHERE `RHA Assassin`.`Pin` = " . $targetPin; //kill target
                            $result = mysqli_query($conn, $sql);
                            
                            $sql = "UPDATE `rha`.`RHA Assassin` SET `Time Of Death` = '". date("y-m-d H:i:s") . "' WHERE `RHA Assassin`.`Pin` = " . $targetPin; //kill target
                            $result = mysqli_query($conn, $sql);

                            $sql = "SELECT * FROM `RHA Assassin` WHERE `Pin` = ". $targetPin; //Give killer new target
                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($result);
                            $newTargetsPin = $row['Target Pin']; 

                            
                            $sql = "UPDATE `rha`.`RHA Assassin` SET `Kills` = ". $kills. " WHERE `RHA Assassin`.`Pin` = " . $pin; 
                            $result = mysqli_query($conn, $sql); 

                            if ($newTargetsPin == $pin){
                                $sql = "SELECT * FROM `RHA Assassin` WHERE `Pin` = ". $pin; //Retreave new targets name
                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_assoc($result); //retreave Assassin information
                                $name = $row['First Name'] . " " . $row['Last Name'];

                                $sql = "UPDATE `rha`.`RHA Assassin` SET `Target Pin` = '0' WHERE `RHA Assassin`.`Pin` = " . $targetPin; //kill target
                                $result = mysqli_query($conn, $sql);

                                $sql = "UPDATE `rha`.`RHA Assassin` SET `Target Pin` = '$pin' WHERE `RHA Assassin`.`Pin` = " . $pin; //set winner
                                $result = mysqli_query($conn, $sql);

                                echo "<h1>Congradulations " . $name . ", you win!<h1>";
                            }else{

                                $sql = "UPDATE `rha`.`RHA Assassin` SET `Target Pin` = ". $newTargetsPin . " WHERE `RHA Assassin`.`Pin` = " . $pin; //store it in the database
                                $result = mysqli_query($conn, $sql);  

                                
                                $sql = "UPDATE `rha`.`RHA Assassin` SET `Target Pin` = '0' WHERE `RHA Assassin`.`Pin` = " . $targetPin; //kill target
                                $result = mysqli_query($conn, $sql);

                                $sql = "SELECT * FROM `RHA Assassin` WHERE `Pin` = ". $newTargetsPin; //Retreave new targets name
                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_assoc($result);
                                $newTargetsName = $row['First Name'] . " " . $row['Last Name'];
                                $ucid = $row['UCID'];
                                echo "<h1>Target eliminated!</h1>";

                                echo "<h3>Your new target is: " . $newTargetsName . "</h3>";
                                //echo "<h3>UCID of target: $ucid </h3>" ;
                                echo "<img width='500px' class='targetPic' src='pics/$ucid.jpg' alt='$ucid'/>";
                            }
                            echo "<form><br/><p><a href='index.php'>Home</a></p></from>";
                                

                            

                        }else{
                            echo "<from><h1>Invalid Pin</h1><p><a href='index.php'>Try Again</a></p></from>";
                        }
                    }
                }
                ?>
            </div>
    </body>
</html>