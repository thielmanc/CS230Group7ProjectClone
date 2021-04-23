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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/0809ee8fa6.js" crossorigin="anonymous"></script>
    <script src="js/header.js"></script>
</head>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="navbar navbar-expand-lg navbar-dark bg-dark">

        <a class="navbar-brand" href="../index.php">APARTMENTS!</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <?php
                //this checks to see if someone is loged in. you set the uid when you login
                if (isset($_SESSION['uid'])):
                    if ($_SESSION['privileged'] == 1): //if the user is an admin ?>                  
                        <li class="nav-item">
                            <a class="nav-link" href="admin.php">Admin</a>
                         </li>
                    <?php endif ?>

                    <li class="nav-item">
                        <a class="nav-link" href="/index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/gallery.php">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="includes/logout.php">Logout</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/about-us.php">About Us</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/signup.php">Signup</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/about-us.php">About Us</a>
                    </li>
                <?php endif ?>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>
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