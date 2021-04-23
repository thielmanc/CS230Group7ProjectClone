<?php require 'includes/header.php' ?>
<main>
    <link rel="stylesheet" href="/css/comments.css">
    <div class="backdrop-filter"></div>
    <div class="comment-section">
        <div class="comment-tray">
        <?php
            require_once 'includes/fetch-comment-helper.php';
            require_once 'view-components/comment.php';
            
            foreach(comments_on($_GET['id']) as $comment) {
                echo_comment($comment);
            }
        ?>
        </div>
        <div class="comment-reply-panel" id="main-comment-panel" action="includes/review-helper.php" method="POST">
            <div class="comment-reply-field" id="main-comment-field" contenteditable></div>
            <div class="comment-reply-panel-controls hide-until-enabled" id="main-comment-panel-controls">
                <input type="checkbox" id="allow-replies" class="allow-replies-input" checked><label for="allow-replies">Allow replies</label>
                <button onclick="commentCallback(null)">POST</button>
            </div>
        </div>
        <script src="/js/comments.js"></script>
    </div>
    <!-- script and stylesheetfor options-tray already loaded in header for notification tray, do not need to load again --> 
    <div class="options-tray user-mention-autocomplete-tray hide-until-enabled"></div>
</main>