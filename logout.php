<!-- Logout page. Deletes temporary views created. Deletes the session
     variables and redirects to login page. -->

<!DOCTYPE html>

<?php include "DBConnection.php";?>
<?php include "MainController.php";?>

<?php
    session_start();
    if(!isset($_SESSION['user'])) {
        header("location: login.php");
    }
?>

<html>
    <head>
        <meta charset="utf-8">
        <title>Logout</title>
    </head>
    <body>
        <?php
            DeleteTemporaryViewsInDB();
            unset($_SESSION['user']);
            session_destroy();
            header("location:login.php");
            exit();
        ?>
    </body>
</html>
