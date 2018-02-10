<!-- UI for finding the school and kids info given club name -->

<!DOCTYPE html>

<?php include "DBConnection.php";?>
<?php include "MainController.php";?>

<?php
    session_start();
    if(!isset($_SESSION['user'])) {
        header("location: login.php");
    }
?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/frames.css">
        <title>Details from Club Name</title>
    </head>
    <body>
        <h3 align="center">Find the school and kids associated with a club. Input details specified below:</h2>
        <h3 align="center">Input=Any clubs name; Output=School and all kids associated with the Club</h2>
        <form class="form" method="post" action= "ViewResultsGivenClubName.php">
            <input type="text" placeholder="Enter Club Name:" name="clubname" required />
            <input class="button" type="submit" name="submit" value="Submit">

            <?php
                if(isset($_POST['submit']))
                {
                    $query_type = "2";
                    GetResults($query_type, $_POST["clubname"]);
                }
            ?>
        </form>
    </body>
</html>
