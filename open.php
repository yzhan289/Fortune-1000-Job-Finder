<?php
    include 'conf.php';
    // call the database
    $mysqli = new mysqli($dbhost,$dbuser,$dbpass,$dbname);

    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
    }
?>
