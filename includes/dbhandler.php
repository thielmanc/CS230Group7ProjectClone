<?php

$servename = "localhost";
$DBuname = "phpmyadmin";
$DBPass = "cs230lab"; // CHANGE AS NEEDED
$DBname = "cs230project";

$conn = mysqli_connect($servename, $DBuname, $DBPass, $DBname);

if (!$conn) {
    die("Connection failed...".mysqli_connect_error());
    # code...
}

