<?php
require 'includes/header.php';
require 'includes/dbhandler.php';

$place = $_POST['place_name'];
$data = safe_query("SELECT * FROM reviews WHERE place_name=?","s",$place);

if (empty($data)) {
    header("Location: /geolocation.php?error=NoReviews");
    exit();
}