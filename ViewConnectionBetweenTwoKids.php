<!-- UI for the feature, finding a connection between two kids -->

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
        <title>Find Connection between two Kid's</title>
    </head>
    <body>
        <h3 align="center">Find a Connection between two kids. Input details specified below:</h2>
        <h3 align="center">Input=Any two kid's email; Output=Yes-if the kid's are connected; No-otherwise</h2>
        <form class="form" method="post" action= "ViewConnectionBetweenTwoKids.php">
            <input type="email" name="kid1" placeholder="Enter First Kid's Email:" required />
            <input type="email" name="kid2" placeholder="Enter Second Kid's Email:" required />
            <input class="button" type="submit" name="submit" value="Submit">
            <?php
                if(isset($_POST['submit']))
                {
                    $query_type = "3";
                    GetResults($query_type, $_POST["kid1"], $_POST["kid2"]);
                }
            ?>

        </form>

    </body>
</html>
