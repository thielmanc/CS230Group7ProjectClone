<?php require 'includes/header.php' ?>
<main>
    <link rel="stylesheet" href="/css/comments.css">
    <div class="backdrop-filter"></div>
    <div class="comment-section">
        <div class="comment-tray">
        <?php
            require_once 'includes/fetch-comment-helper.php';

            function echo_comment($data) {
            
            $rolemap = [
                'resident' => 'Resident'
            ]
            
            ?>
            <div data-uid="<?= $data['cid'] ?>" data-vote-state="<?= $data['vote_state'] ?>" class="comment">
                <div class="comment-content">
                    <header>
                        <div class="rating-container">
                            <a class="upvote" href="javascript:upvote('<?= $data['cid'] ?>')">▲</a>
                            <span class="rating"><?= $data['rating'] ?></span>
                            <a class="downvote" href="javascript:downvote('<?= $data['cid'] ?>')">▼</a>
                        </div>
                        <a href="<?= htmlspecialchars($data['author_url']) ?>"><img class="profile-picture" src="<?= htmlspecialchars($data['author_image']) ?>"></a>
                        <div>
                            <a href="<?= htmlspecialchars($data['author_url']) ?>" class="comment-user"><?= htmlspecialchars($data['author']) ?></a>
                            <span class="comment-time"><?= $data['time'] ?></span>
                        </div>
                        <p class="user-role-indicator" data-role="<?= $data['role'] ?>"><?= $rolemap[$data['role']] ?></p>
                        <div class="comment-header-space"></div>
                        <a class="user-action-menu-link">⋮</a>
                        <div class="user-action-menu hide-until-enabled">
                            <a href="javascript:report('<?= $data['cid'] ?>')">Report...</a>
                            <a href="javascript:alert('doesnt do anything yet');void 0;">Delete...</a>
                        </div>
                    </header>
                    <p class="comment-text"><?= htmlspecialchars($data['text']) ?></p>
                    <?php if($data['replies_permitted']): ?>
                    <form class="comment-reply-panel hide-until-enabled" action="includes/review-helper.php" method="POST">
                        <textarea class="comment-reply-field" name="review" placeholder="Post a reply..."></textarea>
                        <div class="comment-reply-panel-controls hide-until-enabled">
                            <input type="checkbox" id="allow-replies--<?= $data['cid'] ?>" name="allow-replies" checked><label for="allow-replies--<?= $data['cid'] ?>">Allow replies</label>
                            <button type="submit" name="review-submit">POST</button>
                        </div>
                        <input type="hidden" name="item_id" value="<?= htmlspecialchars($_GET['id']) ?>">
                        <input type="hidden" name="parentid" value="<?= $data['cid'] ?>">
                    </form>
                    <?php else: ?>
                    <span class="info">Replies are not permitted</span>
                    <?php endif ?>
                </div>
                <div class="reply-tray"><?php
                    foreach(replies_to($data['cid']) as $reply) {
                        echo_comment($reply);
                    }
                ?></div>
            </div>
            <?php
            }

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
        </div>
        <script src="/js/comments.js"></script>
    </div>
</main>