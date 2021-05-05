<?php
require_once 'require-session-start.php';
require_once 'dbhandler.php';

function messages_to_and_from($user) {
    $stmt = safe_stmt_exec('SELECT *, IF(receiver = ?, "incoming", "outgoing") AS mode
                            FROM messages
                            WHERE (receiver = (SELECT uid FROM users WHERE uname = ?) AND sender   = ?) OR
                                  (sender   = (SELECT uid FROM users WHERE uname = ?) AND receiver = ?)
                            ORDER BY date', 'isisi', $_SESSION['user']['uid'], $user, $_SESSION['user']['uid'], $user, $_SESSION['user']['uid']);
    $stmt = $stmt->get_result();
    while($message = $stmt->fetch_assoc()) {
        yield array(
            'mid' => $message['mid'],
            'text' => $message['message'],
            'date' => $message['date'],
            'mode' => $message['mode']
        );
    }
}

function message_with_id($mid) {
    $message = safe_query('SELECT *, IF(receiver = ?, "incoming", "outgoing") AS mode
                            FROM messages
                            WHERE mid = ?
                            ORDER BY date', 'ii', $_SESSION['user']['uid'], $mid);
    return array(
        'mid' => $message['mid'],
        'text' => $message['message'],
        'date' => $message['date'],
        'mode' => $message['mode']
    );
}

function unread_messages_from($user) {
    $stmt = safe_stmt_exec('SELECT * FROM messages
                            WHERE sender = (SELECT uid FROM users WHERE uname = ?) AND receiver = ? AND DISMISSED = FALSE
                            GROUP BY mid
                            ORDER BY date', 'si', $user, $_SESSION['user']['uid']);
    $messages = [];
    $count = 0;
    $stmt = $stmt->get_result();
    while($message = $stmt->fetch_assoc()) {
        $count++;
        array_push($messages, array(
            'mid' => $message['mid'],
            'text' => $message['message'],
            'date' => $message['date'],
            'mode' => 'incoming'
        ));
    }
    return array(
        'count' => $count,
        'messages' => $messages
    );
}

function users_with_conversations() {
    require_once 'fetch-user-info.php';
    $stmt = safe_stmt_exec('SELECT receiver AS uid FROM messages WHERE sender = ?
                            UNION SELECT sender AS uid FROM messages WHERE receiver = ?', 'ii', $_SESSION['user']['uid'], $_SESSION['user']['uid']);
    $stmt = $stmt->get_result();
    while($user = $stmt->fetch_assoc()) {
        $arr = fetch_user_by_id($user['uid']);
        $arr['unread_messages_count'] = safe_query('SELECT COUNT(*) AS count FROM messages WHERE sender = ? AND receiver = ? AND dismissed = FALSE', 'ii', $user['uid'], $_SESSION['user']['uid'])['count'];
        yield $arr;
    }
}