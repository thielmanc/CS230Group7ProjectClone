<?php
require_once '../../includes/require-session-start.php';
header('Content-Type: application/json');

require_once '../../includes/fetch-notifications.php';
require_once '../../view-components/notification.php';

$count = 0;
ob_start();
foreach(all_notifications() as $notification) {
    echo_notification($notification);
    $count++;
}
$notificationHTML = ob_get_clean();

echo json_encode([
    'success' => true,
    'count' => $count,
    'html' => $notificationHTML
]);