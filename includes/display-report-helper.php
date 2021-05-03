<?php 
require_once 'dbhandler.php';
date_default_timezone_set('UTC');
//approve button
if (isset($_POST['approve-submit'])) {
    
    $review_ID = $_POST['id'];
    //set the status value in the database back to normal (0)
    $sql = "UPDATE reviews SET status='0' WHERE revid=$review_ID";
    mysqli_query($conn, $sql);

    header("Location: ../admin.php?success=approved");
    exit();
}
//remove button
if (isset($_POST['remove-submit'])) {
    
    $review_ID = $_POST['id'];
    //deletes the comment from the database
    $sql = "DELETE FROM reviews WHERE revid = $review_ID";
    mysqli_query($conn, $sql);

    header("Location: ../admin.php?success=removed");
    exit();
}