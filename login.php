<?php require 'includes/header.php' ?>
	<main>
		<link rel="stylesheet" href="/css/login.css">
		<div class="backdrop-filter"></div>
		<div class="form-panel">
			<div class="info-panel">
				<h2>Morgantown Housing</h2>
				<p>We help make choosing a place to live in Morgantown easy by providing a space for current and prospective residents to browse, review, and discuss housing options.</p>
				<p>New here? Get started by <a href="javascript:show_sign_up_form()">creating an account</a></p>
				<div class="flex-fill-space"></div>
				<footer>
					<a href="/about-us.php">About Us</a>
					<a href="javascript:alert('todo')">Browse without an account (todo)</a>
				</footer>
			</div>
			<div class="carousel-viewport">
				<link rel="stylesheet" href="/css/carousel.css">
				<script src="/js/carousel.js"></script>
				<div class="carousel">
					<div class="form-wrapper">
						<h2>Welcome back!</h2>
						<img id="login-pfp" alt="Login Here" src="/images/default-silhouette.svg">
						<p class="error-message"><?php
							switch($_GET['error']) {
								case 'NotLoggedIn':
									echo 'Sorry, you need to be logged in to do that';
									break;
								case 'EmptyField':
									echo 'One of the fields were empty. Try logging in again.';
									break;
								case 'UserDNE':
									echo 'Sorry, that user doesn\'t exist';
									break;
								case 'WrongPass';
									echo 'Sorry, that password wasn\'t right. Try entering it again.';
									break;
								case 'UserIsNotAdmin':
									echo 'You don\'t have permission to do that';
									break;
								// add others as needed
							}
						?></p>
						<form method="POST" action="/includes/login-helper.php">
							<label for="username">Your username or email:</label>
							<input type="text" id="username" name="username" placeholder="Username" required>
							
							<label for="password">Your password:</label>
							<input type="password" id="password" name="password" placeholder="Password" required>
							
							<?php if(isset($_GET['redirect'])): ?>
							<input type="hidden" name="redirect" value="<?= htmlspecialchars($_GET['redirect']) ?>">
							<?php endif ?>

							<input type="checkbox" id="remember-me" name="remember-me"><label for="remember-me">Remember me</label>
							<button type="submit" id="login" name="login" value="login">Sign in</button>
						</form>
						<a href="javascript:alert('todo')">Forgot password?</a>
						<a href="javascript:show_sign_up_form()">Create an account</a>
					</div>
					<div class="form-wrapper">
						<h2>Create an account</h2>
						<p class="error-message"><?php
							switch($_GET['error']) {
								case 'PassMismatch':
									echo 'Sorry, those passwords were\'t the same. Try typing them again.';
									break;
								case 'UsernameOrEmailTaken':
									echo 'Either that username or email is already registered. If you have an account, try signing in instead.';
									break;
								case 'WeakPass':
									echo 'That password doesn\'t match our password policy. Make sure you use at least 8 characters, a number, a letter, and a special character.';
									break;
								// add others as needed
							}
						?></p>
						<form method="POST" action="/includes/signup-helper.php">
							<label>Your name:</label>
							<div class="name-wrapper">
								<input type="text" id="fname" name="fname" placeholder="First name">
								<input type="text" id="lname" name="lname" placeholder="Last name">
							</div>
							
							<label for="username-signup" class="required-label">Pick a username - up to 16 characters:</label>
							<input type="text" id="username-signup" name="username" placeholder="Username" required>
							
							<label for="email-signup" class="required-label">Your email address:</label>
							<input type="email" id="email-signup" name="email" placeholder="Email" required>
							
							<label for="password-signup" class="required-label">Your password:</label>
							<p class="password-policy-info">8+ characters, with at least one letter, number, and special character</p>
							<input type="password" id="password-signup" name="password" placeholder="Password" required minlength="8">
							
							<label for="password-confirm-signup" class="required-label">Confirm your password:</label>
							<input type="password" id="password-confirm-signup" name="password-confirm" placeholder="Confirm password" required>
							
							<input type="checkbox" id="remember-me-signup" name="remember-me"><label for="remember-me-signup">Remember me</label>
							<button type="submit" id="signup" name="signup" value="signup">Sign up</button>
							<script src="/js/signup.js"></script>
						</form>
						<a href="javascript:show_login_form()">I have an account</a>
					</div>
				</div>
				<script>		
					let carousel = document.getElementsByClassName('carousel')[0];
				
					function show_sign_up_form() {
						carousel.show(1);
					}
					
					function show_login_form() {
						carousel.show(0);
					}
					
					function show_sign_up_form_no_animate() {
						carousel.show_immediate(1);
					}
					
					function show_login_form_no_animate() {
						carousel.show_immediate(0);
					}
				</script>
			</div>
		</div>
	</main>
</body>