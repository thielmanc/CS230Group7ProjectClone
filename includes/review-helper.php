<?php 
require_once 'dbhandler.php';
date_default_timezone_set('UTC');

if (isset($_POST['review-submit'])) {
    session_start(); // gets session information
    $uname = $_SESSION['uname']; // define username variable from the session
    $title = $_POST['review-title'];
    $date = date('Y-m-d H:i:s');
    $review = $_POST['review'];
    $item_id = $_POST['item_id'];
    $rating = $_POST['rating'];

    $sql = "INSERT INTO reviews (itemid, uname, title, reviewtext, revdate, ratingnum, status) VALUES ('$item_id', '$name', '$title', '$review', '$date', '$rating', 1)";
    mysqli_query($conn, $sql);

    header("Location: ../review.php?id=$itemid");
    exit();
}


