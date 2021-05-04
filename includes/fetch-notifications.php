<?php
require_once 'require-session-start.php';
require_once 'dbhandler.php';
require_once 'pretty-relative-date.php';

// pseudo-enum of notification types
const NOTIFICATION_MENTION = 1;
const NOTIFICATION_MESSAGE = 2;

function mention_notifications() {
    $stmt = safe_stmt_exec('SELECT * FROM mentions
                            WHERE uid = (SELECT uid FROM users WHERE uname = ?) AND dismissed = FALSE', 's', $_SESSION['uname']);
    $stmt = $stmt->get_result();
    while($mention = $stmt->fetch_assoc()) {
        $commentData = safe_query('SELECT itemid, uname, reviewtext, revdate FROM reviews WHERE revid = ?', 'i', $mention['cid']);
        yield array(
            'title' => "{$commentData['uname']} mentioned you in a comment",
            'desc' => $commentData['reviewtext'],
            'time' => relative_date_string(new DateTime($commentData['revdate'])),
            'link' => '/api/notifications/dismiss.php?type='.NOTIFICATION_MENTION.'&id='.$mention['mid'].'&redirect='.urlencode("/review.php?id={$commentData['itemid']}#comment--{$mention['cid']}"),
            'id' => $mention['mid'],
            'type' => NOTIFICATION_MENTION
        );
    }
}

function message_notifications() {
    $stmt = safe_stmt_exec('SELECT *, (SELECT uname FROM users WHERE uid = sender) AS username FROM messages
                            WHERE receiver = ? AND dismissed = FALSE', 'i', $_SESSION['user']['uid']);
    $stmt = $stmt->get_result();
    while($message = $stmt->fetch_assoc()) {
        yield array(
            'title' => "{$message['username']} sent you a message",
            'desc' => $message['message'],
            'time' => relative_date_string(new DateTime($message['date'])),
            'link' => '/api/notifications/dismiss.php?type='.NOTIFICATION_MESSAGE.'&id='.$message['mid'].'&redirect='.urlencode("/messages.php?user={$message['username']}"),
            'id' => $message['mid'],
            'type' => NOTIFICATION_MESSAGE
        );
    }
}

function all_notifications() {
    yield from mention_notifications();
    yield from message_notifications();
}