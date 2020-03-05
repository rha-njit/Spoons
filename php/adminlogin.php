<!DOCTYPE html>
<html>

<head>
<title>Admin Login</title>
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

               

                if (isset($_POST['submit'])){

                    if ($_POST['submit'] == "login"){

                        $ReceivedUser = $_POST['ucid'];
                        $ReceivedPass = $_POST['password'];

                        $sql = "SELECT * FROM `RHA Admins` WHERE `ucid` = '$ReceivedUser'";
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
                            setcookie('cookieun', $cookieun, time() + (86400 / 24), "/");
                        }else {
                            setcookie("cookieun", "", time() - 3600, "/");
                            $cookieun = "Fail";
                        }
                    }
                }
            }
            
            if ( $cookieun != "Fail" and $cookieun != ""){
                
                header('Location: addPlayer.php'); 
            }else{
                    
                //echo "<p style=\"color: red;\">Invaid username/password.</p>";
                if($cookieun != ""){
                    echo "<p style=\"color: red;\">Invaid username/password.</p>";
                }
                
                ?>
                <h2>Admin Login</h2>
                <form name="login" method="post" action="adminlogin.php">
                    <h3>UCID</h3>
                    <p>
                        <input id="ucid" name="ucid" type="text" />
                    </p>
                    <h3>Password</h3>
                    <p>
                        <input name="password" type="password" />
                    </p>
                    <br />
                    <p>
                        <input type="submit" name="submit" value="login" />
                    </p>
                    <br />
                    <br />
            
                </form>
        <?php
        
            }
        ?>
        
    </div>
</body>

</html>