<?php
require_once '../includes/require-session-start.php';
header('Content-Type: application/json');



$sql = "SELECT
            CONCAT((SELECT uname FROM users WHERE uid = ?), ' mentioned you in a comment') AS notif_title,
            'placeholder' AS notif_desc,
            CONCAT('/review.php?id=', (SELECT itemid FROM reviews WHERE revid = cid), '#', 'PLACEHOLDER-HASH') AS notif_link
        FROM mentions
        WHERE uid = ? AND dismissed = FALSE
        -- UNION SELECT ... AS notif_title, ... AS notif_desc
        -- FROM ...";