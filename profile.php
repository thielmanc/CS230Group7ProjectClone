<?php
    require_once 'includes/require-session-start.php';
    require 'includes/header.php';
    require 'includes/fetch-user-info.php';
    $user = isset($_GET['user']) ? fetch_user_by_username($_GET['user']) : $_SESSION['user'];
	if(!isset($user['username'])) {
		header('Location: profile.php?error=UserDNE');
		exit();
	}

	// whether or not the user is viewing their own profile
	$user_is_viewing_own_profile = $user['uid'] === $_SESSION['user']['uid'];
?>
<main>
    <link rel="stylesheet" href="/css/profile.css">
	<div class="backdrop-filter"></div>
	<header class="profile-header">
		<div class="pfp-container">
			<svg class="circle-svg">
				<!-- circle-fill isn't clipped and prevents graphical glitch with horizontal line near clipping boundary -->
				<circle class="circle-fill" cx="50%" cy="50%" r="50%" fill="#2f2f2f" />
				<circle class="circle-outline" cx="50%" cy="50%" r="50%" stroke="var(--horiz-line-color)" stroke-width="var(--horiz-line-thickness)" fill="#2f2f2f" />
			</svg> 
			<img class="profile-picture-main" alt="Profile Picture" src="<?= htmlspecialchars($user['profile_picture']) ?>">
		</div>
		<div class="above-line-bg"></div>
		<div class="right-content">
			<div class="above-line-content">
				<h1 class="username"><?= $user_is_viewing_own_profile ? 'Welcome, '.htmlspecialchars($user['username']).'!' : htmlspecialchars($user['username']) ?></h1>
				<div class="flex-fill-space"></div>

				<?php if($user_is_viewing_own_profile): ?>
					<a href="/edit-profile.php" class="edit-profile-button">Edit profile</a>
				<?php else: ?>
					<a href="/messages.php?user=<?= htmlspecialchars(urlencode($user['username'])) ?>" class="send-message-button">Send message</a>
				<?php endif ?>
			</div>
			<div class="below-line-content">
				<p class="bio" ><?= htmlspecialchars($user['bio'])?></p>
			</div>			
	</header>
	<div class="my-comments-panel">
		<h2><?= $user_is_viewing_own_profile ? 'My ' : htmlspecialchars($user['username']) . "'s " ?>comments</h2>
		<link rel="stylesheet" href="/css/comments.css">
		<?php
			require_once 'includes/fetch-comment-helper.php';
			require_once 'view-components/comment.php';
			$count = 0;
			foreach(comments_by($user['username']) as $comment) {
				echo_comment($comment);
				$count++;
			}
			if($count == 0):?>
			<p class="no-comments-placeholder"><?= $user_is_viewing_own_profile ? 'You do not ' : htmlspecialchars($user['username']) . ' does not ' ?>have any comments yet</p>
			<?php endif
		?>
	</div>
</main>
</body>