<?php
function echo_notification($data) {
    ?>
    <a class="option notification" data-type="<?= $data['type'] ?>" data-id="<?= $data['id'] ?>" onclick="dismiss(<?= $data['type'] ?>, <?= $data['id'] ?>)" href="<?= htmlspecialchars($data['link']) ?>">
        <header>
            <span class="notification-title"><?= htmlspecialchars($data['title']) ?></span>
            <div class="flex-fill-space"></div>
            <span class="notification-time"><?= $data['time'] ?></span>
        </header>
        <div class="notification-desc"><?= htmlspecialchars($data['desc']) ?></div>
    </a>
    <?php
}