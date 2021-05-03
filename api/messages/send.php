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

if(!isset($_POST[$param = 'recipient']) || !isset($_POST[$param = 'message'])) {
    echo json_encode([
        'success' => false,
        'error' => "required parameter $param not set"
    ]);
    exit();
}

require_once '../../includes/dbhandler.php';

safe_query('INSERT INTO messages (sender, receiver, message) VALUES (?, ?, ?)', 'iis', $_SESSION['user']['uid'], $_POST['recipient'], $_POST['message']);
$mid = unsafe_query('SELECT LAST_INSERT_ID() AS mid')['mid']; // automatically generated mid of previously inserted comment

require_once '../../includes/fetch-messages.php';
require_once '../../view-components/message.php';
ob_start();
echo_message(message_with_id($mid));
$messageHTML = ob_get_clean();

echo json_encode([
    'success' => true,
    'html' => $messageHTML
]);