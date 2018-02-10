<!-- The web pages use $connection object to interact with the database.
     The database name is Securly. Hosted on phpmyadmin -->

<?php
    $connection = mysqli_connect('localhost', 'root', '', 'Securly');
    if(!$connection) {
        die("Database connection failed");
    }
?>
