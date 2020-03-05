<!DOCTYPE html>
<html>

<head>
<title>Thanos Snap</title>
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

            }
            
            if (isset($_COOKIE['cookieun']) and $cookieun != ""){
                ?>
                    <h2>Thanos Snap</h2>
                    <form name="KillAll" method="post" action="banHammer.php">
                        
                        <p>
                            <?php  
                                $ucid = $_POST['ucid'];
                            ?>
                            
                            Are you sure you want to ban
                            <?php echo $ucid ?>?
                            <input class="smallSelect" style="display:none;" type="text" name="ucid" id="ucid"  value="<?php echo $ucid ?>" />
                        </p>

                        <br />
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