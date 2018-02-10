<!-- UI for finding the school and clubs, given kid's email -->

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
        <title>Details from Kid's email</title>
    </head>
    <body>
        <h3 align="center">Find the school and clubs associated with a kid. Input details specified below:</h2>
        <h3 align="center">Input=Any kid's email; Output=A brief description of school and clubs associated with the kid</h2>
        <form class="form" method="post" action= "ViewResultsGivenKidEmail.php">
            <input type="email" name="kidemail" placeholder="Enter Kid's Email: " required />
            <input class="button" type="submit" name="submit" value="Submit">
            <?php
                if(isset($_POST['submit']))
                {
                    $query_type = "1";
                    GetResults($query_type, $_POST["kidemail"]);
                }
            ?>
        </form>
    </body>
</html>
