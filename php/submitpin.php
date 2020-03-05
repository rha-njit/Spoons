<!DOCTYPE html>
<html>

<head>
<title>Home</title>
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

            }else{

                if (isset($_POST['pin'])){
                    $pin = $_POST['pin'];

                    $sql = "SELECT * FROM `RHA Assassin` WHERE `Pin` = ". $pin; 
                    $result = mysqli_query($conn, $sql);

                    if(mysqli_num_rows($result) > 0) { //check pin and see if it's valid
                        $row = mysqli_fetch_assoc($result); //retreave Assassin information
                        $name = $row['First Name'] . " " . $row['Last Name'];
                        $targetPin = $row['Target Pin'];
                        $isAlive = $row['Is Alive'];
                        $tod = $row['Time Of Death'];
                        if ($isAlive == 1){
                            if ($targetPin == $pin){
                                echo "<h3>Hi $name, you won!</h3>";

                            }else{
                                    
                                $sql = "SELECT * FROM `RHA Assassin` WHERE `Pin` = ". $targetPin; //Retreave targets name
                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_assoc($result);
                                $targetsName = $row['First Name'] . " " . $row['Last Name'];
                                $ucid = $row['UCID'];

                                echo "<h3>Hi " . $name . ",<h3><h3>Your target is: " . $targetsName . "</h3>";
                                //echo "<h3>UCID of target: $ucid </h3>" ;
                                echo "<img width='500px' class='targetPic' src='pics/$ucid.jpg' alt='$ucid'/>";
                                ?>
                                <form name="myForm" method="post" action="eliminationcript.php">
                                    <input name="pin" type="password" value="<?php echo $pin;  ?>" style="visibility:collapse; display:none;" />
                                    <h2>Enter your target's pin:</h2>
                                    <p>
                                        <input name="tPin" type="password" />
                                    </p>
                                    <br />
                                    <p>
                                        <input type="submit" value="submit target" />
                                    </p>
                                </form>
                                <?php
                            }
                        }else{
                            echo "<h3>Sorry $name, you have been eliminated.</h3>";
                            echo "<h3>Your time of death was: $tod</h3>";
                        }
                        echo "<form><br/><p><a href='index.php'>Home</a></p></from>";
                    }else{
                        echo "<from><h1>Invalid Pin</h1><p><a href='index.php'>Try Again</a></p></from>";
                    }
                }else{
                    echo "<from><h1>Invalid Pin</h1><p><a href='index.php'>Try Again</a></p></from>";
                }
            }
        ?>
    </div>
</body>

</html>