<!-- Login page with a form to enter email, password, and a submit button -->

<!DOCTYPE html>

<?php include "DBConnection.php";?>
<?php include "MainController.php";?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Admin Login</title>
        <link rel="stylesheet" href="css/styles.css">
        <link rel="stylesheet" href="css/frames.css">
    </head>
    <body>
        <h1 align="center">District Admin Database</h1>
        <div class="page">

            <form class="form" method="post" action="login.php">
                <input type="text" placeholder="Enter Username:" name="username" required/>
                <input type="password" placeholder="Enter Password" name="password" required/>
                <input class="button" type="submit" name="submit" value="Submit">
                <?php
                    if (isset($_POST['submit'])) {
                        AdminLogin($_POST["username"], $_POST["password"]);
                    }
                 ?>
            </form>
        </div>
    </body>
</html>
