<!-- MainController.php is the main controller page which helps the web pages
     to navigate through the other functionality. -->

<?php include "DBConnection.php";?>
<?php include "ControllerResultsGivenKidEmail.php" ?>
<?php include "ControllerResultsGivenClubName.php" ?>
<?php include "ControllerConnectionBetweenTwoKids.php" ?>

<?php
    // AdminLogin(): Takes in username and password as parameters and
    // interacts with the database to determine the authenticity of the user
    // login. On successful login, a session is started and the page gets
    // redirected to index.php. Otherwise, an appropriate message is printed.
    function AdminLogin($username, $password) {
        global $connection;

        $query = "SELECT * FROM Admin WHERE username='$username' AND password='$password'";
        $result = mysqli_query($connection, $query);
        if(!$result) {
            die('Query FAILED' . mysqli_error());
        } else if ($result->num_rows == 1) {
            echo "Login Success";
            if (!session_id()) {
                session_start();
            }
            if (!isset($_SESSION["user"])) {
                $_SESSION["user"] = $username;
                echo "{$_SESSION["user"]}";
            }
            header('location:index.php');
        } else {
            echo "Login Failed. Please Try Again.";
        }
    }

    // GetResults() is the main method which all the features webpages call
    // upon to navigate to the right set of functions required to calculate
    // the appropriate result. The query type and input data is passed as
    // parameters to the function and a switch statement navigates the rest.
    // This method also logs any query run in to the database
    function GetResults($query_type, $input_data_1, $input_data_2 = "") {
        switch ($query_type) {
            case "1":
                FindSchoolGivenKidEmail($input_data_1);
                FindClubsGivenKidEmail($input_data_1);
                SaveQuery($query_type, $input_data_1);
                break;
            case "2":
                FindSchoolGivenClubName($input_data_1);
                FindKidsGivenClubName($input_data_1);
                SaveQuery($query_type, $input_data_1);
                break;
            case "3":
                GenerateConnectionGraph($input_data_1, $input_data_2);
                SaveQuery($query_type, $input_data_1, $input_data_2);
                break;
            default:
                break;
        }
    }

    // SaveQuery() function saves the query run into the database with
    // their appropriate paramter values
    function SaveQuery($query_type, $input_data_1, $input_data_2 = "") {
        global $connection;
        $input_data = "";
        switch ($query_type) {
            case "1":
            case "2":
                $input_data = $input_data_1;
                break;
            case "3":
                $input_data = $input_data_1 . "," . $input_data_2;
                break;
        }
        try {
            $query = "INSERT INTO Log (query_type, input_data) VALUES ('$query_type', '$input_data')";
            $result = mysqli_query($connection, $query);
            if (!$result) {
                echo "Error: " . $query. "<br>" . $connection->error;
            }
        } catch (Exception $e) {
            echo "Exception caught: {$e->getMessage()} <br>";
        }
    }

    // DisplayHistory() will generate a dynamic table to display all the past
    // run queries distinctly.
    function DisplayHistory() {
        global $connection;
        $query = "SELECT DISTINCT query_type, input_data FROM Log";
        $result = mysqli_query($connection, $query);
        if ($result) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $querytype = $row["query_type"];
                    $inputdata = $row["input_data"];
                    echo "<form class=\"form\" method=\"post\" action= \"ViewHistory.php\">";
                    echo "<tr>";
                    echo "<td><input class=\"conn\" type=\"text\" name=\"query_type\" value=\"{$querytype}\" readonly></input></td>";
                    echo "<td><input class=\"conn\" type=\"text\" name=\"input_data\" value=\"{$inputdata}\" readonly></input></td>";
                    echo "<td><input class=\"button\" type=\"submit\" name=\"submit\" value=\"Execute Query\"></input></td>";
                    echo "</tr>";
                    echo "</form>";
                }
            }
        } else {
            echo "Error: " . $query. "<br>" . $connection->error;
        }
    }

    // Temperory views - edges and connection_results are created in the
    // database, the first time, query type 3 is run to find a connection
    // between two kids. These two views are used to generate a connected
    // graph which is later used to find the connection through Breadth-First
    // Search traversal. These views are dropped on logout
    function DeleteTemporaryViewsInDB() {
        global $connection;
        try {
            $query_1 = "DROP VIEW IF EXISTS connection_results";
            $result_1 = mysqli_query($connection, $query_1);
            if (!$result_1) {
                echo "Error: " . $query_1. "<br>" . $connection->error;
            }

            $query_2 = "DROP VIEW IF EXISTS edges";
            $result_2 = mysqli_query($connection, $query_2);
            if (!$result_2) {
                echo "Error: " . $query_2. "<br>" . $connection->error;
            }
        } catch (Exception $e) {
            echo "Exception caught: {$e->getMessage()} <br>";
        }
    }
?>
