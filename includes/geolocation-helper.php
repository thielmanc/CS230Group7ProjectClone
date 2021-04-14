<?php
require 'includes/header.php';
require 'includes/dbhandler.php';

$query = $_GET['query'];

if (empty($query)) {
    header("Location: /geolocation.php?error=EmptyField");
    exit();
}

$sql = "SELECT * FROM reviews WHERE place_name=$query";
$result = mysqli_query($sql, $conn);

if (empty($results)) {
    header("Location: /geolocation.php?error=NoReviews");
    exit();
}

while ($results = mysql_fetch_array($results)) {
    echo "<p><h3>".$results['place_name']."</h3>";

}