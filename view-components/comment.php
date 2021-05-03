<?php
function echo_comment($data) {       
    $rolemap = [
        'resident' => 'Resident'
    ]

    ?>
    <div id="comment--<?= $data['cid'] ?>" data-uid="<?= $data['cid'] ?>" data-vote-state="<?= $data['vote_state'] ?>" class="comment">
        <div class="comment-content">
            <header>
                <div class="rating-container">
                    <a class="upvote" href="javascript:upvote('<?= $data['cid'] ?>')">▲</a>
                    <span class="rating"><?= $data['rating'] ?></span>
                    <a class="downvote" href="javascript:downvote('<?= $data['cid'] ?>')">▼</a>
                </div>
                <a href="<?= htmlspecialchars($data['author_url']) ?>"><img class="profile-picture" alt="Profile Picture" src="<?= htmlspecialchars($data['author_image']) ?>"></a>
                <div>
                    <a href="<?= htmlspecialchars($data['author_url']) ?>" class="comment-user"><?= htmlspecialchars($data['author']) ?></a>
                    <span class="comment-time"><?= $data['time'] ?></span>
                </div>
                <p class="user-role-indicator" data-role="<?= $data['role'] ?>"><?= $rolemap[$data['role']] ?></p>
                <div class="comment-header-space"></div>
                <a class="user-action-menu-link">⋮</a>
                <div class="user-action-menu hide-until-enabled">
                    <a href="javascript:report('<?= $data['cid'] ?>')">Report...</a>
                    <?php if($_SESSION['user']['username'] === $data['author']): ?>
                    <a href="javascript:deleteComment(<?= $data['cid'] ?>)">Delete...</a>
                    <?php endif ?>
                </div>
            </header>
            <p class="comment-text"><?= preg_replace('/@\{ ([\S]+) \}/', "<span class=\"user-mention\">@$1</span>", htmlspecialchars($data['text'])) ?></p>
            <?php if($data['replies_permitted']): ?>
            <div class="comment-reply-panel hide-until-enabled">
                <div class="comment-reply-field" contenteditable></div>
                <div class="comment-reply-panel-controls hide-until-enabled">
                    <input type="checkbox" id="allow-replies--<?= $data['cid'] ?>" class="allow-replies-input" checked><label for="allow-replies--<?= $data['cid'] ?>">Allow replies</label>
                    <button onclick="commentCallback(<?= $data['cid'] ?>)">POST</button>
                </div>
            </div>
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