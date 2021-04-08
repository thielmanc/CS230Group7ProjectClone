<?php
require_once 'fetch-comment-helper.php';

function echo_comment($data) {

$uid = $data['cid'];
$rating = $data['rating'];
$time = $data['time'];
$author_image = $data['author_image'];
$author_url = $data['author_url'];
$author = $data['author'];
$role = $data['role'];
$text = $data['text'];
$replies_permitted = $data['replies_permitted'];

$rolemap = [
	'resident' => 'Resident'
]

?>
<div data-uid="<?= $uid ?>" class="comment">
    <div class="comment-content">
		<header>
			<div class="rating-container">
				<a class="upvote" href="javascript:upvote('<?= $uid ?>')">▲</a>
				<span class="rating"><?= $rating ?></span>
				<a class="downvote" href="javascript:downvote('<?= $uid ?>')">▼</a>
			</div>
			<a href="<?= htmlspecialchars($author_url) ?>"><img class="profile-picture" src="<?= htmlspecialchars($author_image) ?>"></a>
			<div>
				<a href="<?= htmlspecialchars($author_url) ?>" class="comment-user"><?= htmlspecialchars($author) ?></a>
				<span class="comment-time"><?= $time ?></span>
			</div>
			<p class="user-role-indicator" data-role="<?= $role ?>"><?= $rolemap[$role] ?></p>
			<div class="comment-header-space"></div>
			<a class="user-action-menu-link">⋮</a>
			<div class="user-action-menu hide-until-enabled">
				<a href="javascript:alert('doesnt do anything yet');void 0;">Report...</a>
				<a href="javascript:alert('doesnt do anything yet');void 0;">Delete...</a>
			</div>
		</header>
		<p class="comment-text"><?= htmlspecialchars($text) ?></p>
		<?php if($replies_permitted): ?>
		<form class="comment-reply-panel hide-until-enabled" action="includes/review-helper.php" method="POST">
			<textarea class="comment-reply-field" name="review" placeholder="Post a reply..."></textarea>
			<div class="comment-reply-panel-controls hide-until-enabled">
				<input type="checkbox" id="allow-replies--<?= $uid ?>" name="allow-replies" checked><label for="allow-replies--<?= $uid ?>">Allow replies</label>
				<button type="submit" name="review-submit">POST</button>
			</div>
			<input type="hidden" name="item_id" value="<?= htmlspecialchars($_GET['id']) ?>">
			<input type="hidden" name="parentid" value="<?= $uid ?>">
		</form>
		<?php else: ?>
		<span class="info">Replies are not permitted</span>
		<?php endif ?>
	</div>
	<div class="reply-tray">
		<?php foreach(replies_to($data['cid']) as $reply) {
			echo_comment($reply);
		} ?>
	</div>
</div>
<?php
}
