<?php include "DBConnection.php";?>

<?php
    // Generates a graph by creating two views edges and connection_results.
    // edges view will hold every edge between the the nodes.
    // connection_results holds a list of connections going out from a
    // Parent node to various child nodes. This forms an undirected
    // unweighted connected graph. The values in connection_results are
    // stored into an array and passed as paramters to
    // FindConnectionBetweenKids()
    function GenerateConnectionGraph($kid1, $kid2) {
        global $connection;
        try {
            $query_1 = "CREATE VIEW IF NOT EXISTS edges (a, b) AS SELECT DISTINCT `M1`.`kid_id`, `M2`.`kid_id` FROM `MainDB` AS `M1` CROSS JOIN `MainDB` AS `M2` WHERE `M1`.`kid_id` <> `M2`.`kid_id` AND `M1`.`club_id` = `M2`.`club_id`";
            $result_1 = mysqli_query($connection, $query_1);

            $query_3 = "CREATE VIEW IF NOT EXISTS connection_results as SELECT a AS Parent, Group_Concat(b ORDER BY b) AS Child FROM edges GROUP BY a";
            $result_3 = mysqli_query($connection, $query_3);
            $query_4 = "SELECT * FROM connection_results";
            $result_4 = mysqli_query($connection, $query_4);

            $query_5 = "SELECT kid_id FROM Kid WHERE Kid.kid_email = '$kid1'";
            $result_5 = mysqli_query($connection, $query_5);
            $query_6 = "SELECT kid_id FROM Kid WHERE Kid.kid_email = '$kid2'";
            $result_6 = mysqli_query($connection, $query_6);

            $arr = array();
            $kidid_1 = -1;
            $kidid_2 = -1;

            if ($result_1 && $result_3 && $result_4 && $result_5 && $result_6) {
                if ($result_4->num_rows > 0) {
                    while($row = $result_4->fetch_assoc()) {
                        $arr[$row["Parent"]] = explode(",", $row["Child"]);
                    }
                }

                if ($result_5->num_rows > 0) {

                    while($row = $result_5->fetch_assoc()) {
                        $kidid_1 = $row["kid_id"];
                    }
                }

                if ($result_6->num_rows > 0) {

                    while($row = $result_6->fetch_assoc()) {
                        $kidid_2 = $row["kid_id"];
                    }
                }
            } else {
                echo "Error: " . $connection->error;
            }

            FindConnectionBetweenKids($arr, $kidid_1, $kidid_2, $kid1, $kid2);
        } catch (Exception $e) {
            echo "Exception caught: {$e->getMessage()} <br>";
        }
    }

    // FindConnectionBetweenKids() implements a Breadth-First Search traversal
    // algorithm to find a connection between two kids. A visited array
    // is maintained to keep track of all the visited nodes. And a queue is
    // maintained to traverse from the parent node to all the subsequent
    // child nodes one by one, before moving on to the next level. If the start
    // node or the end node are present in the connection results, then they
    // are obviously not reachable and hence a No is echoed. Otherwise, the
    // graph is traversed level-by-level till the node is found, or else No is
    // echoed.
    function FindConnectionBetweenKids($arr, $kidid_1, $kidid_2, $kid1, $kid2) {
        global $connection;
        try {
            $visited = array();
            $found = false;
            $queue = array();
            foreach ($arr as $key => $value) {
                $str = implode($value);
                $visited[$key] = false;
                for ($x=0; $x<sizeof($value); $x++) {
                    $visited[$value[$x]] = false;
                }
            }

            $visited[$kidid_1] = true;
            if (!empty(in_array($kidid_1, array_keys($arr))) && !empty(in_array($kidid_2, array_keys($arr)))) {

                array_push($queue, $kidid_1);

                while ((!empty($queue)) && (!$found)) {
                    $start = current($queue);
                    array_shift($queue);

                    if ($start!==NULL && $arr[$start]!==NULL) {
                        $child = $arr[$start];
                        for ($j=0; $j<sizeof($child); $j++) {
                            if ($visited[$child[$j]] == false) {
                                $visited[$child[$j]] = true;
                                array_push($queue, $child[$j]);
                            }

                            if ($child[$j] == $kidid_2 && $visited[$kidid_2] == true) {
                                $found = true;
                                echo "<p align=\"center\">\nYes. {$kid1} and {$kid2} are connected.</p>";
                                break;
                            }
                        }
                    }
                }
            }

            if (!$found) {
                echo "<p align=\"center\">\nNo. {$kid1} and {$kid2} are not connected.</p>";
            }
        } catch (Exception $e) {
            echo "Exception caught: {$e->getMessage()} <br>";
        }
    }
?>
