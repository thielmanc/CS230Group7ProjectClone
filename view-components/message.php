<?php
function echo_message($data) {

    ?>
    <div class="message-row <?= $data['mode'] == 'incoming' ? 'incoming-message-row' : 'outgoing-message-row' ?>">
        <div class="message <?= $data['mode'] == 'incoming' ? 'incoming-message' : 'outgoing-message' ?>">
            <p class="message-text"><?= htmlspecialchars($data['text']) ?></p>
            <!--<p class="message-date"><?= htmlspecialchars($data['date']) ?></p>-->
        </div>
    </div>
    <?php
    
}

function echo_user_conversation_card($data) {

    ?>
    <a class="user-conversation-card" href="<?= htmlspecialchars('/messages.php?user='.urlencode($data['username'])) ?>">
        <img class="profile-picture" src="<?= htmlspecialchars($data['profile_picture']) ?>">
        <div class="user-conversation-info">
            <p class="username"><?= htmlspecialchars($data['username']) ?></p>
            <p class="messages-count"><?= $data['unread_messages_count'] ?> unread messages</p>
        </div>
    </a>
    <?php
}