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
    $upvotes = 0;
    $downvotes = 0;
    $parentid = $_POST['parentid'];

    $sql = "INSERT INTO reviews (itemid, uname, title, reviewtext, revdate, upvotes, downvotes, parentid, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0)";
    safe_query($sql, 'issssiii', $item_id, $uname, $title, $review, $date, $upvotes, $downvotes, $parentid);

    header("Location: ../review.php?id=$item_id");
    exit();
}


