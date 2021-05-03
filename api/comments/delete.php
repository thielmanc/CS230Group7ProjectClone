<?php
require_once '../../includes/require-session-start.php';
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

require_once '../../includes/dbhandler.php';

$commenter = safe_query('SELECT uid FROM users WHERE uname = (SELECT uname FROM reviews WHERE revid = ?)', 'i', $_POST['cid'])['uid'];

if(!isset($commenter)) {
    echo json_encode([
        'success' => false,
        'error' => "comment $cid does not exist"
    ]);
    exit();
}

if($commenter !== $_SESSION['uid']) {
    echo json_encode([
        'success' => false,
        'error' => 'you do not have permission to do this',
    ]);
    exit();
}

safe_query('DELETE FROM reviews WHERE revid = ?', 'i', $_POST['cid']);

echo json_encode([
    'success' => true
]);
