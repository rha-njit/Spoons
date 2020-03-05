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
                    <form name="KillAll" method="post" action="snapConfirmation.php">
                        <h4>Kill All players with less than 
                        <p>
                            <select class="smallSelect" type="dropdown" name="kills" id="kills" >
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                            </select> kills.</h4>
                        </p>
                        <h4>building:</h4>
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
                        <br />
                        <p>
                            <input type="submit" name="banHammer" value="Kill All"  />
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