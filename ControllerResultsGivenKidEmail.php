<?php include "DBConnection.php";?>

<?php
    // FindSchoolGivenKidEmail() takes in kid's email id as paramter and queries
    // to find the school attended by the kid. If found, an
    // appropriate message is printed.
    function FindSchoolGivenKidEmail($email_id) {
        global $connection;
        try {
            $query = "SELECT School.school_name FROM School INNER JOIN Kid ON School.school_id = Kid.school_id WHERE Kid.kid_email = '$email_id'" ;
            $result = mysqli_query($connection, $query);

            if ($result) {
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                      $value = $row["school_name"];
                      echo "<p align=\"center\">{$email_id} attends \"{$value}\" school.</p>";
                    }
                } else {
                    echo "<p align=\"center\">{$email_id} has no school associated with it.</p>";
                }
            } else {
                echo "Error: " . $query. "<br>" . $connection->error;
            }
        } catch (Exception $e) {
            echo "Exception caught: {$e->getMessage()} <br>";
        }
    }

    // FindClubsGivenKidEmail() takes in kid's email id as paramter and queries
    // to find the clubs associated with the kid. If found, an
    // appropriate message is printed.
    function FindClubsGivenKidEmail($email_id) {
        global $connection;
        try {
            $query = "SELECT Club.club_name FROM Club INNER JOIN MainDB ON Club.club_id = MainDB.club_id INNER JOIN Kid ON Kid.kid_id = MainDB.kid_id WHERE Kid.kid_email = '$email_id'" ;
            $result = mysqli_query($connection, $query);
            if ($result) {
                if ($result->num_rows > 0) {
                    echo "<p align=\"center\">{$email_id} is also a part of the following clubs: ";
                    while($row = $result->fetch_assoc()) {
                      $value = $row["club_name"];
                      echo "\" {$value} \" ";
                    }
                    echo "</p>";
                } else {
                    echo "<p align=\"center\">{$email_id} is not associated with any clubs.</p>";
                }
            } else {
                echo "Error: " . $query. "<br>" . $connection->error;
            }
        } catch (Exception $e) {
            echo "Exception caught: {$e->getMessage()} <br>";
        }
    }
?>
