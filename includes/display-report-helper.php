<?php 
require_once 'dbhandler.php';
date_default_timezone_set('UTC');

if (isset($_POST['approve-submit'])) {
    
    $review_ID = $_POST['id'];
    $sql = "UPDATE reviews SET status='1' WHERE revid=$review_ID";
    mysqli_query($conn, $sql);

    header("Location: ../admin.php?success=approved");
    exit();
}
if (isset($_POST['remove-submit'])) {
    
    $review_ID = $_POST['id'];
    $sql = "DELETE FROM reviews WHERE revid = $review_ID";
    mysqli_query($conn, $sql);

    header("Location: ../admin.php?success=removed");
    exit();
}


