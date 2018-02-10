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
        <title>View History</title>
    </head>
    <body>
        <h3 align="center">View Past Executed Queries - Click on Execute Query button to run the query.</h2>
        <div class="scrolltable">
            <table>
                <tr>
                    <td>Query Type</td>
                    <td>Input Data</td>
                    <td>Action</td>
                </tr>
                <?php
                    DisplayHistory();

                    if(isset($_POST['submit']))
                    {
                        $query_type = $_POST["query_type"];
                        switch($query_type) {
                            case "1":
                            case "2":
                                GetResults($query_type, $_POST["input_data"]);
                                break;
                            case "3":
                                $input_data = explode(",", $_POST["input_data"]);
                                GetResults($query_type, $input_data[0], $input_data[1]);
                                break;
                        }

                    }

                ?>
            </table>
        </div>
    </body>
</html>
