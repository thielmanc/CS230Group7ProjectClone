<?php

$servename = "localhost";
$DBuname = "phpmyadmin";
$DBPass = "Mor3M4lloc!"; // CHANGE AS NEEDED
$DBname = "cs230project";

$conn = mysqli_connect($servename, $DBuname, $DBPass, $DBname);

if (!$conn) {
    die("Connection failed...".mysqli_connect_error());
    # code...
}

