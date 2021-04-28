<?php
// use like: require 'includes/require-admin-privileges.php';


session_start();
if(!isset($_SESSION['uname']) || $_SESSION['privileged'] != 1) {
    header('Location: /includes/logout.php?error=UserIsNotAdmin');         //log the user out for being a hacker hehe
    exit();
}