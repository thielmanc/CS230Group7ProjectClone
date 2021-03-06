<?php

$servename = "localhost";
$DBuname = "phpmyadmin";
$DBPass = "480016329Aw'"; // CHANGE AS NEEDED
$DBname = "cs230project";

$conn = mysqli_connect($servename, $DBuname, $DBPass, $DBname);

if (!$conn)
    die("Connection failed...".mysqli_connect_error());

function safe_query($conn, $query, $types, $a, $b) {
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, $types, $a, $b);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return $data;
}

