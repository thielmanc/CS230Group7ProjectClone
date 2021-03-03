<?php

    session_start();		// starts session
    session_unset();		// an array of key, value pairs. similar to $_SESSION = array() this is an empty array
    session_destroy();		// removes all files from temp directory
    header("Location: ../index.php");
    exit();
?>
