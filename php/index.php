<!DOCTYPE html>
<html>

<head>
<title>Home</title>
<meta name="author" content="Jason A. Laboy">
<meta name="description" content="RHA Spoons game! Try to eliminate your target.">
<meta name="keywords" content="Spoons, Assassin, RHA, NJIT, School, College, Game, StayOnCampusStayConected, BOTH, Battle of the halls, Reslife">
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

            <form name="myForm" method="post" action="submitpin.php">
            <h2>Thanks for playing!</h2>

            <!--  uncomment this to start the game. -->
            <!-- -->
            <h2>Enter your pin to login</h2>
            <p>
            <input name="pin" type="password" />
            </p>
            <br />
            <br />
            <p>
                <input type="submit" value="login" />
            </p>
            

            <br/>
            <p><a href="eliminationFeed.php">Elimination Feed</a></p>
            <br />
            <h3>
                Message of the day:
            </h3>
            <br/>
            <p>
                Rules: 
                <ol>
                    <li>No eliminating when your target is in class.</li>
                    <li>No eliminating when they are in unconscious in their private area, I.E. Someone sleeping or showering in their room.</li>
                    <li>No eliminating in the bathrooms.</li>
                    <li>You cannot cover both your back and front since you are not participating fairly.</li>
                    <li>If someone covers their back only, then they cannot be attacked from the back.</li>
                    <li>If someone says they didn't witness an elimination, then that elimination is valid.</li>
                    <li>The eliminated target MUST give their spoon to the person who eliminated them.</li>
                    <li>You must always have your spoon on your person.</li>
                    <li>If your target gets banned, you will automatically receive a new target.</li>
                    <li>Your target is the only person you can eliminate (You can not eliminate people willy nilly).</li>
                    <li>If the last people eliminate each other at the same time, then the game will be settled with a Game Admin Present.</li>
                    <li>Kills are only valid from the front or the back.</li>
                    
                </ol>
            </p>
        </div>
        
    </form>
    
    <p class="secretMenu">
        <a href="adminlogin.php"></a>
    </p>
</body>

</html>