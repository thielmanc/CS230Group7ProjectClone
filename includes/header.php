<?php session_start() ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="/css/_global.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/header.css">
    <script src="https://kit.fontawesome.com/0809ee8fa6.js" crossorigin="anonymous"></script>
</head>
<header class="global-header">
        <a class="header-logo" href="/index.php">APARTMENTS!</a>
        <?php
            //this checks to see if someone is loged in. you set the uid when you login
            if (isset($_SESSION['uid'])):
                if ($_SESSION['privileged'] == 1): //if the user is an admin ?>                  
                    <a class="navigation-link" href="admin.php">Admin</a>
                <?php endif ?>

                <a class="navigation-link" href="/index.php">Home</a>
                <a class="navigation-link" href="/profile.php">Profile</a>
                <a class="navigation-link" href="/gallery.php">Gallery</a>
                <a class="navigation-link" href="includes/logout.php">Logout</a>
                <a class="navigation-link" href="/about-us.php">About Us</a>
            <?php else: ?>
                <a class="navigation-link" href="/login.php">Login</a>
                <a class="navigation-link" href="/signup.php">Signup</a>
                <a class="navigation-link" href="/about-us.php">About Us</a>
            <?php endif ?>

    <link rel="stylesheet" href="/css/options-tray.css">
    <script src="/js/options-tray.js"></script>
    <div class="options-tray notification-tray hide-until-enabled">
        <?php
        if(isset($_SESSION['uid'])) {
            require_once 'fetch-notifications.php';
            require_once __DIR__.'/../view-components/notification.php';

            foreach(mention_notifications() as $notification)
                echo_notification($notification);
        }
        ?>
        <script src="/js/notifications.js"></script>
    </div>
</header>