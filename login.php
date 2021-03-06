<?php require 'includes/header.php' ?>
    <link rel="stylesheet" href="/css/login.css">
	<div class="backdrop-filter"></div>
	<div class="form-panel">
		<div class="info-panel">
			<h2>Website name placeholder</h2>
			<p>We help choosing a place to live in Morgantown by providing a space for current and prospective residents to browse, review, and discuss housing options.</p>
			<p>Placeholder xxxx xxxx xxxx xxxx xxxx xxxx xxxx xxxx xxxx xxxx xxxx xxxx xxxx xxxx</p>
			<p>This info panel can be removed too if that would be better</p>
			<p>New here? Get started by <a href="javascript:show_sign_up_form()">creating an account!</a></p>
			<div class="flex-fill-space"></div>
			<footer>
				<a href="javascript:alert('todo')">About us</a>
				<a href="javascript:alert('todo')">Browse without an account</a>
			</footer>
		</div>
		<div class="form-carousel">
			<div class="form-wrapper">
				<h2>Welcome back!</h2>
				<img id="login-pfp" src="/images/default-silhouette.svg">
				<form method="POST" action="/includes/login-helper.php">
					<label for="username">Your username or email:</label>
					<input type="text" id="username" name="username" placeholder="Username" required>
					
					<label for="password">Your password:</label>
					<input type="password" id="password" name="password" placeholder="Password" required>
					
					<input type="checkbox" id="remember-me" name="remember-me"><label for="remember-me">Remember me</label>
					<button type="submit" id="login" name="login" value="login">Sign in</button>
				</form>
				<a href="javascript:alert('todo')">Forgot password?</a>
				<a href="javascript:show_sign_up_form()">Create an account</a>
			</div>
			<div class="form-wrapper">
				<h2>Create an account</h2>
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
					<input type="password" id="password-signup" name="password" placeholder="Password" required>
					
					<label for="password-confirm-signup" class="required-label">Confirm your password:</label>
					<input type="password" id="password-confirm-signup" name="password-confirm" placeholder="Confirm password" required>
					
					<input type="checkbox" id="remember-me-signup" name="remember-me"><label for="remember-me-signup">Remember me</label>
					<button type="submit" id="signup" name="signup" value="signup">Sign up</button>
				</form>
				<a href="javascript:show_login_form()">I have an account</a>
			</div>
			<script>		
				let login_panel = document.querySelector('.form-wrapper:first-of-type');
				let signup_panel = document.querySelector('.form-wrapper:last-of-type');
			
				let active_panel = login_panel;
			
				// fixes animations not replaying when reset
				// I hate CSS and I hate javascript
				let recalc = function(elem) {
					elem.style.animation = '';
					void elem.offsetWidth;
				}
			
				function show_sign_up_form() {
					if(active_panel == signup_panel)
						return;
				
					recalc(login_panel);
					login_panel.style.animation = 'slide-out-left 0.2s linear forwards';
					recalc(signup_panel);
					signup_panel.style.animation = 'slide-in-right 0.2s linear forwards';
					
					active_panel = signup_panel;
				}
				
				function show_login_form() {
					if(active_panel == login_panel)
						return;
						
					recalc(login_panel);
					login_panel.style.animation = 'slide-out-left 0.2s linear reverse';
					recalc(signup_panel);
					signup_panel.style.animation = 'slide-in-right 0.2s linear reverse';
					
					active_panel = login_panel;
				}
				
				function show_sign_up_form_no_animate() {
					login_panel.style.animation = 'slide-out-left 0s linear forwards';
					signup_panel.style.animation = 'slide-in-right 0s linear forwards';
					active_panel = signup_panel;
				}
				
				function show_login_form_no_animate() {
					login_panel.style.animation = 'slide-out-left 0s linear reverse';
					signup_panel.style.animation = 'slide-in-right 0s linear reverse';
					active_panel = login_panel;
				}
			</script>
		</div>
	</div>
</body>