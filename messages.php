<?php
    require_once 'includes/require-session-start.php';
    require_once 'includes/header.php';
    require_once 'includes/fetch-user-info.php';
    require 'includes/fetch-messages.php';
    require 'view-components/message.php';
?>
<main>
    <link rel="stylesheet" href="/css/messages.css">
	<div class="backdrop-filter"></div>


    <script src="/js/messages.js"></script>
    <div class="conversations-aside">
        <h3 class="my-conversations-header">My conversations</h3>
        <div class="conversations-panel">
            <?php

            foreach(users_with_conversations() as $user)
                echo_user_conversation_card($user);
            ?>
        </div>
    </div>
	<div class="messages-panel">
		<div class="messages-section">
            <?php
            require_once 'includes/dismiss-message.php';

            foreach(messages_to_and_from($_GET['user']) as $message) {
                echo_message($message);
                if($message['mode'] === 'incoming')
                    dismiss($message['mid']);
            }
            ?>
		</div>
		<div class="send-message-form">
			<textarea type="text" id="send-message-input" placeholder="Send message..." rows="1"></textarea>
			<button onclick="sendMessage(<?= fetch_user_by_username($_GET['user'])['uid'] ?>)">Send</button>
		</div>
	</div>
</main>