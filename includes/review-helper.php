<?php 
require_once 'dbhandler.php';
require_once 'censorfunction.php';
date_default_timezone_set('UTC');

if (isset($_POST['review-submit'])) {
    session_start(); // gets session information
    $uname = $_SESSION['uname']; // define username variable from the session
    $title = $_POST['review-title'];
    $date = date('Y-m-d H:i:s');
    $censoredReview = censor($review);
    $censoredReview = $_POST['review'];
    $item_id = $_POST['item_id'];
    $parentid = $_POST['parentid'];

    $sql = "INSERT INTO reviews (itemid, uname, title, reviewtext, revdate, parentid, upvotes, downvotes, upvoters, downvoters, status) VALUES (?, ?, ?, ?, ?, ?, 0, 0, '[]', '[]', 0)";
    safe_query($sql, 'issssi', $item_id, $uname, $title, $review, $date, $parentid);

    header("Location: ../review.php?id=$item_id");
    exit();
}


