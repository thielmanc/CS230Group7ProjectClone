<?php
require_once '../../includes/require-session-start.php';
header('Content-Type: application/json');

if(!isset($_POST['sender'])) {
    echo json_encode([
        'success' => false,
        'error' => 'required parameter sender not set'
    ]);
    exit();
}

require_once '../../includes/fetch-messages.php';
require_once '../../view-components/message.php';
require_once '../../includes/dismiss-message.php';

$message_data = unread_messages_from($_POST['sender']);
$card_data = users_with_conversations();

ob_start();
foreach($message_data['messages'] as $message) {
    echo_message($message);
    dismiss($message['mid']);
}
$messageHTML = ob_get_clean();

ob_start();
foreach($card_data as $card)
    echo_user_conversation_card($card);
$cardHTML = ob_get_clean();

echo json_encode([
    'success' => true,
    'count' => $message_data['count'],
    'message-html' => $messageHTML,
    'card-html' => $cardHTML
]);