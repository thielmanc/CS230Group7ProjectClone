<?php require 'includes/header.php' ?>
<main>
    <link rel="stylesheet" href="/css/comments.css">
    <div class="backdrop-filter"></div>
    <div class="comment-section">
        <div class="comment-tray">
        <?php
            require_once 'includes/fetch-comment-helper.php';
            require_once 'includes/comment.php';
            
            foreach(comments_on($_GET['id']) as $comment) {
                echo_comment($comment);
            }
        ?>
        </div>
        <form class="comment-reply-panel" id="main-comment-panel" action="includes/review-helper.php" method="POST">
            <textarea class="comment-reply-field" id="main-comment-field" name="review" placeholder="Post a comment..."></textarea>
            <div class="comment-reply-panel-controls hide-until-enabled" id="main-comment-panel-controls">
                <input type="checkbox" id="allow-replies" name="allow-replies" checked><label for="allow-replies">Allow replies</label>
                <button type="submit" name="review-submit">POST</button>
            </div>
            <input type="hidden" name="item_id" value="<?= htmlspecialchars($_GET['id']) ?>">
        </form>
        <script src="/js/comments.js"></script>
    </div>
    <link rel="stylesheet" href="/css/options-tray.css">
    <script src="/js/options-tray.js"></script>
    <div class="options-tray user-mention-autocomplete-tray hide-until-enabled"></div>
</main>