<?php

$servename = "localhost";
$DBuname = "phpmyadmin";
$DBPass = "cs230lab"; // CHANGE AS NEEDED
$DBname = "cs230project";

mysqli_report(MYSQLI_REPORT_STRICT); // enables logging of SQL errors, much easier to debug

$conn = mysqli_connect($servename, $DBuname, $DBPass, $DBname);

if (!$conn) {
    die("Connection failed...".mysqli_connect_error());
}

const NO_CONNECTION_ERR_MSG = 'Error: No connection to database';

// executes a prepared query and returns an assoc array containing the FIRST ROW ONLY
// good for fetching something from the DB by a unique identifier - ex. fetching a user by username, comment by id, etc.
// use safe_stmt_exec if more than one row is needed or a more complex operation needs to be performed
function safe_query($query, $types, ...$params) {
    global $conn; // I should be executed for using this
    if(!$conn) {
        die(NO_CONNECTION_ERR_MSG);
    }
    $stmt = $conn->stmt_init();
    if(!$stmt->prepare($query)) {
        die($conn->error);
    }
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result ? $result->fetch_assoc() : $result;
    $stmt->close();
    return $data;
}

// executes a prepared statement and returns it
function safe_stmt_exec($query, $types, ...$params) {
    global $conn; // terrible
    if(!$conn) {
        die(NO_CONNECTION_ERR_MSG);
    }
    $stmt = $conn->stmt_init();
    if(!$stmt->prepare($query)) {
        die($conn->error);
    }
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    return $stmt;
} 

function unsafe_query($query) {
    global $conn;
    if(!$conn) {
        die(NO_CONNECTION_ERR_MSG);
    }
    return mysqli_query($conn, $query)->fetch_assoc();
}
