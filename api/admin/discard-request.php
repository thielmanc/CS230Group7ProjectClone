<?php
require_once '../../includes/require-admin-privileges.php';
header('Content-Type: application/json');

if(!isset($_POST['rid'])) {
    echo json_encode([
        'success' => false,
        'error' => 'required parameter rid not set'
    ]);
    exit();
}

require_once '../../includes/dbhandler.php';

safe_query('DELETE FROM requests WHERE rid = ?', 'i', $_POST['rid']);

echo json_encode([
    'success' => true
]);