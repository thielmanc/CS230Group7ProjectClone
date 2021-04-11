<?php
// handles requests to report a comment
// right now, this doesnt limit how many times a single person can report, but thats not a huge deal

require 'require-session-start.php';
header('Content-Type: application/json');

if(!isset($_POST['cid'])) {
    echo json_encode([
        'success' => false,
        'error' => 'cid not set'
    ]);
    exit();
}

require 'dbhandler.php';

safe_query('UPDATE reviews SET status = status + 1 WHERE revid = ?', 'i', $_POST['cid']);

if($conn->affected_rows === 1)
    echo json_encode([
        'success' => true
    ]);
else
    echo json_encode([
        'success' => false,
        'error' => "{$conn->affected_rows} comments affected"
    ]);