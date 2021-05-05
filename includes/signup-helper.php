<?php

if (!isset($_POST['signup'])) {
	header("Location: /signup.php");
	exit();
}

$username = $_POST['username'];
$email = $_POST['email'];
$passw = $_POST['password'];
$passw_rep = $_POST['password-confirm'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];

if ($passw !== $passw_rep) {
	header("Location: /signup.php?error=PassMismatch");
	exit();
}

// enforce against password policy
if(strlen($passw) < 8 || preg_match('/[a-zA-Z]/', $passw) !== 1 || preg_match('/[0-9]/', $passw) !== 1 || preg_match('/['.preg_quote('~!@#$%^&*()_+{}[]|\:;"\'<,>.?').']/', $passw) !== 1 || preg_match('/[\s]/', $passw) !== 0) {
	header("Location: /signup.php?error=WeakPass");
	exit();
}

require 'dbhandler.php';

$stmt = safe_stmt_exec("SELECT 1 FROM users WHERE uname=? OR email=?", "ss", $username, $username);
$stmt->store_result();
$check = $stmt->num_rows();
$stmt->close();

if ($check > 0) {
	header("Location: /signup.php?error=UsernameOrEmailTaken");
	exit();
}

$hashed = password_hash($passw, PASSWORD_BCRYPT);

safe_query("INSERT INTO users (lname, fname, email, uname, password, privileged) VALUES (?, ?, ?, ?, ?, FALSE)", "sssss", $lname, $fname, $email, $username, $hashed);

require 'fetch-user-info.php';
session_start();
$_SESSION['user'] = fetch_user_by_username($username);
$_SESSION['fname'] = $_SESSION['user']['first_name'];
$_SESSION['lname'] = $_SESSION['user']['last_name'];
$_SESSION['uname'] = $_SESSION['user']['username'];
$_SESSION['email'] = $_SESSION['user']['email'];
$_SESSION['uid'] = $_SESSION['user']['uid'];
$_SESSION['pfpurl'] = $_SESSION['user']['profile_picture'];
$_SESSION['privileged'] = $_SESSION['user']['privileged'];

// set up csrf token for form security
$csrftoken = bin2hex(random_bytes(16));
$_SESSION['csrftoken'] = $csrftoken;
header("Set-Cookie: csrftoken=$csrftoken; Path=/; SameSite=Strict; HttpOnly");

header("Location: /profile.php?signup=success");
