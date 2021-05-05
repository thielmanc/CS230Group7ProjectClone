<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
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
        <a class="header-logo" href="/index.php">Housing Helper</a>

        <!-- notifications tray --> 
        <link rel="stylesheet" href="/css/options-tray.css">
        <script src="/js/options-tray.js"></script>
        <div class="options-tray notification-tray hide-until-enabled">
            <?php
            if(isset($_SESSION['uid'])) {
                require_once 'fetch-notifications.php';
                require_once __DIR__.'/../view-components/notification.php';

                $notification_count = 0;
                foreach(all_notifications() as $notification) {
                    echo_notification($notification);
                    $notification_count++;
                }
            }
            ?>
            <script src="/js/notifications.js"></script>
        </div>

        <?php
            //this checks to see if someone is loged in. you set the uid when you login
            if (isset($_SESSION['uid'])):
                if ($_SESSION['privileged'] == 1): //if the user is an admin ?>                  
                    <a class="navigation-link" href="admin.php">Admin</a>
                <?php endif ?>

                <a class="navigation-link" href="/index.php">Search</a>
                <a class="navigation-link" href="/gallery.php">Places</a>
                <a class="navigation-link" href="/profile.php">Profile</a>
                <a class="navigation-link" href="/messages.php">Direct Messages</a>
                <a class="navigation-link" href="includes/logout.php">Logout</a>
                <a class="navigation-link" href="/about-us.php">About Us</a>
                <div class="flex-fill-space"></div>
                <!-- notification bell -->
                <svg class="notification-bell" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                    <path fill="white" d="m 18 32 q 0 51 -15 51 a 2 2 0 0 0 0 6 L 39 89 a 1 1 0 0 0 22 0 L 97 89 a 1 1 0 0 0 0 -6 q -15 0 -15 -51 a 1 1 0 0 0 -64 0"></path>
                    <circle class="notification-alert-circle hide-until-enabled <?= $notification_count > 0 ? 'enabled' : '' ?>" cx="30" cy="30" r="30" fill="#7c0b0b"></circle>
                    <text class="notification-count hide-until-enabled <?= $notification_count > 0 ? 'enabled' : '' ?>" x="30" y="30" text-anchor="middle" dominant-baseline="middle" fill="white"><?= $notification_count ?></text>
                </svg>
            <?php else: ?>
                <a class="navigation-link" href="/login.php">Login</a>
                <a class="navigation-link" href="/signup.php">Signup</a>
                <a class="navigation-link" href="/about-us.php">About Us</a>
            <?php endif ?>
</header>