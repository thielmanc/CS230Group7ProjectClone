<?php 
require 'includes/dbhandler.php';
require 'includes/header.php'; 
require 'includes/review-helper.php';
?>

<main>
    <span id="testAvg"></span>
    <div class="container" aligne="center" style="max-width: 800px;">

        <div class="my-auto">

            <form id="review-form" action="includes/review-helper.php" method="post">

                <div class="form-group" style="margin-top: 15px;">
                    <label class="title-label" for="review-title" style="font-size: 16px; font-weight: bold;">Title</label>
                    <input type="text" name="review-title" id="review-title" style="width: 100%; margin-bottom: 10px;">
                    <textarea name="review" id="review-text" cols="80" rows="3" placeholder="Enter a Comment..."></textarea>
                    <input type="hidden" name="item_id" value="<?php echo $_GET['id']; ?>"> 
                </div>

                <div class="form-group">
                    <button class="btn btn-outline-danger" type="submit" name="review-submit" id="review-submit" style="width: 100%;">Review</button>
                </div>

            </form>

        </div>

    </div>
    
    <h5 style="text-align:center">todo: change this from dark mode to not dark mode</h5>
    <link rel="stylesheet" href="/css/comments.css">
    <div style="width: 1000px; margin-left: calc(50vw - 500px); background-color: #121212; padding: 16px;">
        <div class="comment-tray">
        <?php
            require_once 'includes/fetch-comment-helper.php';

            function echo_comment($data) {
            
            $rolemap = [
                'resident' => 'Resident'
            ]
            
            ?>
            <div data-uid="<?= $uid ?>" class="comment">
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
                            <a href="javascript:alert('doesnt do anything yet');void 0;">Report...</a>
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
        <div class="comment-reply-panel">
            <textarea class="comment-reply-field" placeholder="Post a comment..."></textarea>
            <div class="comment-reply-panel-controls hide-until-enabled">
                <input type="checkbox" id="allow-replies" name="allow-replies" checked><label for="allow-replies">Allow replies</label>
                <button>POST</button>
            </div>
        </div>
        <script src="/js/comments.js"></script>
    </div>
</main>