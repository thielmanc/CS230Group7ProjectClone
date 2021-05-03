<?php
require '../../includes/require-session-start.php';
header('Content-Type: application/json');

if(!isset($_POST['substring'])) {
    echo json_encode([
        'success' => false,
        'error' => 'substring parameter not set'
    ]);
    exit();
}

require_once '../../includes/dbhandler.php';

$stmt = safe_stmt_exec("SELECT uname, pfpurl FROM users WHERE uname LIKE ? LIMIT 4", 's', $_POST['substring'].'%');
$stmt = $stmt->get_result();
$suggestions = [];
while($row = $stmt->fetch_assoc()) {
    array_push($suggestions, [
        'username' => $row['uname'],
        'user_image' => $row['pfpurl']
    ]);
}
$stmt->close();

echo json_encode([
    'success' => true,
    'suggestions' => $suggestions
]);