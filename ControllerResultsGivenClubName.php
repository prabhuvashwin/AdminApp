<?php include "DBConnection.php";?>

<?php
    // FindSchoolGivenClubName() takes in club name as paramter and queries
    // to find the school to which the club is associated with. If found, an
    // appropriate message is printed.
    function FindSchoolGivenClubName($club_name) {
        global $connection;
        try {
            $query = "SELECT School.school_name FROM School INNER JOIN Club ON School.school_id = Club.school_id WHERE Club.club_name = '$club_name'" ;
            $result = mysqli_query($connection, $query);
            if ($result) {
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                      $value = $row["school_name"];
                      echo "<p align=\"center\">{$club_name} belongs to {$value}.</p>";
                    }
                } else {
                    echo "<p align=\"center\">{$club_name} has no school associated with it.</p>";
                }
            } else {
                echo "Error: " . $query. "<br>" . $connection->error;
            }
        } catch (Exception $e) {
            echo "Exception caught: {$e->getMessage()} <br>";
        }
    }

    // FindKidsGivenClubName() takes in club name as paramter and queries
    // to find all kids associated with the club. If found, an
    // appropriate message is printed.
    function FindKidsGivenClubName($club_name) {
        global $connection;
        try {
            $query = "SELECT Kid.kid_name FROM Kid INNER JOIN MainDB ON MainDB.kid_id = Kid.kid_id INNER JOIN Club ON MainDB.club_id = Club.club_id WHERE Club.club_name = '$club_name'" ;
            $result = mysqli_query($connection, $query);
            if ($result) {
                if ($result->num_rows > 0) {
                    echo "<p align=\"center\">{$club_name} has following kids: ";
                    while($row = $result->fetch_assoc()) {
                      $value = $row["kid_name"];
                      echo " \" {$value} \" ";
                    }
                    echo "</p>";
                } else {
                    echo "<p align=\"center\">{$club_name} has no kids associated with it.</p>";
                }
            } else {
                echo "Error: " . $query. "<br>" . $connection->error;
            }
        } catch (Exception $e) {
            echo "Exception caught: {$e->getMessage()} <br>";
        }
    }
?>
