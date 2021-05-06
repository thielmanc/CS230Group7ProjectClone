<?php
header('Content-Type: application/json');

if(!isset($_POST[$param = 'address']) || !isset($_POST[$param = 'description'])) {
    echo json_encode([
        'success' => false,
        'error' => "required parameter $param not set"
    ]);
    exit();
}

require '../../includes/dbhandler.php';

safe_query('INSERT INTO requests (address, descript) VALUES (?, ?)', 'ss', $_POST['address'], $_POST['description']);

echo json_encode([
    'success' => true
]);

header('Location: /index.php');