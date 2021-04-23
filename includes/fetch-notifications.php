<?php
require_once 'require-session-start.php';
require_once 'dbhandler.php';

function mention_notifications() {
    $stmt = safe_stmt_exec('SELECT * FROM mentions
                            WHERE uid = (SELECT uid FROM users WHERE uname = ?) AND dismissed = FALSE', 's', $_SESSION['uname']);
    $stmt = $stmt->get_result();
    while($mention = $stmt->fetch_assoc()) {
        $commentData = safe_query('SELECT itemid, uname, reviewtext, revdate FROM reviews WHERE revid = ?', 'i', $mention['cid']);
        yield array(
            'commenter' => $commentData['uname'],
            'desc' => $commentData['reviewtext'],
            'time' => $commentData['revdate'],
            'link' => "/review.php?id={$commentData['itemid']}#comment--{$mention['cid']}"
        );
    }
}