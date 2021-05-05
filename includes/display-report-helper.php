<?php 
require_once 'dbhandler.php';
require_once 'require-admin-privileges.php';
date_default_timezone_set('UTC');
//approve button
if (isset($_POST['approve-submit'])) {
    
    $review_ID = $_POST['id'];
    //set the status value in the database back to normal (0)
    safe_query('UPDATE reviews SET status=0 WHERE revid = ?', 'i', $review_ID);

    header("Location: ../admin.php?success=approved");
    exit();
}
//remove button
if (isset($_POST['remove-submit'])) {
    
    $review_ID = $_POST['id'];
    //deletes the comment from the database
    safe_query('DELETE FROM reviews WHERE revid = ?', 'i', $review_ID);

    header("Location: ../admin.php?success=removed");
    exit();
}