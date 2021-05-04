<?php
header('Content-Type: application/json');
require_once '../../includes/require-session-start.php';
require_once '../../includes/dbhandler.php';

function dismiss($type, $id) {
    require_once '../../includes/fetch-notifications.php'; // for type constants

    switch($type) {
        case NOTIFICATION_MENTION:
            safe_query('UPDATE mentions SET dismissed = TRUE WHERE mid = ?', 'i', $id);
            break;
        case NOTIFICATION_MESSAGE:
            safe_query('UPDATE messages SET dismissed = TRUE WHERE mid = ?', 'i', $id);
            break;
        default:
            echo json_encode([
                'success' => false,
                'error' => "unknown type $type"
            ]);
            exit();
    }
}

if(!check_csrf_token()) {
    echo json_encode([
        'success' => false,
        'error' => 'request not same site'
    ]);
    exit();
}

if(isset($_GET['type']) && isset($_GET['id']) && isset($_GET['redirect'])) {
    // dismissal is GET-based, and client wants a redirect - this endpoint was visited by clicking a notification
    dismiss($_GET['type'], $_GET['id']);
    header("Location: {$_GET['redirect']}");

} else if(isset($_POST['type']) && isset($_POST['id'])) {
    // dismissal is POST-based, and client does not want redirect - this endpoint was POSTed to by a 'dismiss' button
    dismiss($_POST['type'], $_POST['id']);
    echo json_encode([
        'success' => true
    ]);

} else {
    echo json_encode([
        'success' => false,
        'error' => "endpoint must receive GET parameters type, id, redirect or POST parameters type, id"
    ]);
}