<!-- Index page with all the links to the dashboard and an iframe element which
     will hold the the main features display-->

<!DOCTYPE html>

<?php
    session_start();
    if(!isset($_SESSION["user"])) {
        header("location: login.php");
    }
?>

<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/styles.css">
        <title>Home</title>
    </head>
    <body>
        <h1 align="center">District Admin Database</h1>
        <div class="dashboard">
            <a href="ViewResultsGivenKidEmail.php" id="1" class="button" target="appView">
                Input Kid's Email
            </a>
            <a href="ViewResultsGivenClubName.php" id="2" class="button" target="appView">
                Input Club's Name
            </a>
            <a href="ViewConnectionBetweenTwoKids.php" id="3" class="button" target="appView">
                Find a Connection
            </a>
            <a href="ViewHistory.php" class="button" id="4" target="appView">
                View History
            </a>
            <a href="logout.php" class="button">
                logout
            </a>
        </div>

        <iframe class="frame" name="appView" src="welcome.html" scrolling="no">

        </iframe>
    </body>
</html>
