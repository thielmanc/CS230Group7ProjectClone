<?php
// easy way to require a user be logged in to view a page and redirect them to the login page if not
// use like: require 'includes/require-session-start.php';

session_start();
if(!isset($_SESSION['uname'])) {
    header('Location: /login.php?error=NotLoggedIn');
    exit();
}