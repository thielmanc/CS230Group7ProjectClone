<?php
    require_once 'includes/require-session-start.php';
    require 'includes/header.php';
?>
<main>
    <link rel="stylesheet" href="/css/profile.css">
	<header class="profile-header">
		<div class="pfp-container">
			<svg class="circle-svg">
				<!-- circle-fill isn't clipped and prevents graphical glitch with horizontal line near clipping boundary -->
				<circle class="circle-fill" cx="50%" cy="50%" r="50%" fill="#2f2f2f" />
				<circle class="circle-outline" cx="50%" cy="50%" r="50%" stroke="var(--horiz-line-color)" stroke-width="var(--horiz-line-thickness)" fill="#2f2f2f" />
			</svg> 
			<img id="profile-picture" class="profile-picture-main" alt="Profile Picture" src="<?= htmlspecialchars($_SESSION['user']['profile_picture']) ?>">
            <p class="edit-pfp-label">Click to edit</p>
		</div>
		<div class="above-line-bg"></div>
		<div class="right-content">
			<div class="above-line-content">
				<h1 class="username"><?= htmlspecialchars($_SESSION['user']['username']) ?></h1>
			</div>
			<div class="below-line-content">
				
			</div>			
		</div>
	</header>
	<div class="my-comments-panel">
		<h2>Settings:</h2>
        <form action="/includes/upload-helper.php" method="POST" enctype="multipart/form-data">
            <script src="js/image-upload-input.js"></script>
            <input type="file" name="prof-image" class="image-upload-input" data-preview-elem="profile-picture">
            <input type="hidden" name="prof-submit" value="prof-submit">
			
            <textarea name="bio" id="bio" cols="50" rows="2" placeholder="New Bio" class="form-control" style="text-align: center;"></textarea>
                
            <button type="submit" class="save-changes-button">Save</button>
        </form>
	</div>
</main>
</body>