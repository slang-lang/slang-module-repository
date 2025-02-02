<?php

include "Config.php";


function ConnectDatabase($override = false)
{
    global $conn;
    global $DB_HOST, $DB_USER, $DB_PASSWD, $DB_SCHEMA;

    // Create database connection
    $conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWD, $DB_SCHEMA);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
}

function DisconnectDatabase()
{
    global $conn;

    mysqli_close($conn);
}
