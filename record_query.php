<?php
    // read init.php if you run into any problems
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "db";

    // create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // get query
    $sql = "";
    // $result = $conn->query($sql);  // commented for now

    // close connection
    $conn->close();
?>