<?php
// handles requests to report a comment
// right now, this doesnt limit how many times a single person can report, but thats not a huge deal

require_once 'require-session-start.php';
header('Content-Type: application/json');

if(!check_csrf_token()) {
    echo json_encode([
        'success' => false,
        'error' => 'request not same site'
    ]);
    exit();
}

if(!isset($_POST['cid'])) {
    echo json_encode([
        'success' => false,
        'error' => 'cid not set'
    ]);
    exit();
}

require_once 'dbhandler.php';

safe_query('UPDATE reviews SET status = status + 1 WHERE revid = ?', 'i', $_POST['cid']);

if($conn->affected_rows === 1) {
    echo json_encode([
        'success' => true
    ]);
} else {
    echo json_encode([
        'success' => false,
        'error' => "{$conn->affected_rows} comments affected"
    ]);
}