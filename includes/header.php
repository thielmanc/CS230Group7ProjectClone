<?php session_start() ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="/css/header.css">
    <script src="https://kit.fontawesome.com/0809ee8fa6.js" crossorigin="anonymous"></script>
</head>
<header class="global-header">
        <a class="header-logo" href="/index.php">APARTMENTS!</a>
        <?php
            //this checks to see if someone is loged in. you set the uid when you login
            if (isset($_SESSION['uid'])):
                if ($_SESSION['privileged'] == 1): //if the user is an admin ?>                  
                    <a class="nav-link" href="admin.php">Admin</a>
                <?php endif ?>

                <a class="nav-link" href="/index.php">Home</a>
                <a class="nav-link" href="/profile.php">Profile</a>
                <a class="nav-link" href="/gallery.php">Gallery</a>
                <a class="nav-link" href="includes/logout.php">Logout</a>
                <a class="nav-link" href="/about-us.php">About Us</a>
            <?php else: ?>
                <a class="nav-link" href="/login.php">Login</a>
                <a class="nav-link" href="/signup.php">Signup</a>
                <a class="nav-link" href="/about-us.php">About Us</a>
            <?php endif ?>

    <link rel="stylesheet" href="/css/options-tray.css">
    <script src="/js/options-tray.js"></script>
    <div class="options-tray notification-tray">
        <?php /* ----- DOESNT WORK YET DUE TO require_once ERROR -----
        if(isset($_SESSION['uid'])) {
            require_once 'fetch-notifications.php';
            require_once '/home/as10/Desktop/project/WVU_CS230_2021.01_Group07/view-components/notification.php'; // TODO: fix include issue
            //require_once '../view-components/notification.php';

            foreach(mention_notifications() as $notification)
                echo_mention_notification($notification);
        } */
        ?>
    </div>
</header>