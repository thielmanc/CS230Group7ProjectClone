<?php
require_once 'require-session-start.php';
require_once 'dbhandler.php';

function messages_to_and_from($user) {
    $stmt = safe_stmt_exec('SELECT *, IF(receiver = ?, "incoming", "outgoing") AS mode
                            FROM messages
                            WHERE (receiver = (SELECT uid FROM users WHERE uname = ?) AND sender   = ?) OR
                                  (sender   = (SELECT uid FROM users WHERE uname = ?) AND receiver = ?)', 'isisi', $_SESSION['user']['uid'], $user, $_SESSION['user']['uid'], $user, $_SESSION['user']['uid']);
    $stmt = $stmt->get_result();
    while($message = $stmt->fetch_assoc()) {
        yield array(
            'text' => $message['message'],
            'date' => $message['date'],
            'mode' => $message['mode']
        );
    }
}

function message_with_id($mid) {
    $stmt = safe_stmt_exec('SELECT *, IF(receiver = ?, "incoming", "outgoing") AS mode
                            FROM messages
                            WHERE mid = ?', 'ii', $_SESSION['user']['uid'], $mid);
    $stmt = $stmt->get_result();
    while($message = $stmt->fetch_assoc()) {
        yield array(
            'text' => $message['message'],
            'date' => $message['date'],
            'mode' => $message['mode']
        );
    }
}

function users_with_conversations() {
    require_once 'fetch-user-info.php';
    $stmt = safe_stmt_exec('SELECT receiver AS uid FROM messages WHERE sender = ?
                            UNION SELECT sender AS uid FROM messages WHERE receiver = ?', 'ii', $_SESSION['user']['uid'], $_SESSION['user']['uid']);
    $stmt = $stmt->get_result();
    while($user = $stmt->fetch_assoc()) {
        $arr = fetch_user_by_id($user['uid']);
        $arr['unread_messages_count'] = 'x'; # PLACEHOLDER
        yield $arr;
    }
}