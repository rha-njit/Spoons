<!DOCTYPE html>
<html>

<head>
<title>Elimination Feed</title>
<meta name="author" content="Jason A. Laboy">


<link rel="stylesheet" type="text/css" href="MainStyle.css">
<script type="text/javascript">
    setTimeout(function () { 
      location.reload();
    }, 30 * 1000);
</script>
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



                ?>
                    <form>
                    <br />
                    <p><a href="index.php">Home</a></p>
                    <h3>Elimination Feed:</h3>
                    </form>
                <?php
                $sql = "SELECT * FROM `RHA Assassin` WHERE `Is Alive` <> 1 ORDER BY `RHA Assassin`.`Time Of Death` DESC";
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

            }

		?>
        </div>

		
    </form>
</body>

</html>