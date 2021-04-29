<?php
// easy way to require a user be logged in to view a page and redirect them to the login page if not
// use like: require 'includes/require-session-start.php';

session_start();
if(!isset($_SESSION['uname'])) {
    header('Location: /login.php?error=NotLoggedIn');
    exit();
}

// checks that the HTTP request is not cross-origin
// this should be used at all sensitive state-changing endpoints, such as edit profile and post comment forms
function check_csrf_token() {
    return isset($_COOKIE['csrftoken']) && $_COOKIE['csrftoken'] === $_SESSION['csrftoken'];
}