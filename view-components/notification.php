<?php
function echo_notification($title, $desc, $time, $link) {
    ?>
    <a class="option notification" href="<?= htmlspecialchars($link) ?>">
        <header>
            <span class="notification-title"><?= htmlspecialchars($title) ?></span>
            <span class="notification-time"><?= $time ?></span>
        </header>
        <div class="notification-desc"><?= htmlspecialchars($desc) ?></div>
    </a>
    <?php
}

function echo_mention_notification($data) {
    echo_notification(
        "{$data['commenter']} mentioned you in a comment",
        $data['desc'],
        $data['time'],
        $data['link']
    );
}
